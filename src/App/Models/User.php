<?php
declare(strict_types=1);


namespace App\Models;


use Core\App;
use Core\Model;

/**
 * Class User
 * @package App\Models
 * @property int $id
 * @property string $username
 * @property string $passwordHash
 * @property string $sessionHash
 * @property float $balance
 */
class User extends Model
{
    public static string $tableName = 'user';

    /**
     * @param string $username
     * @return User|null
     */
    public static function findByUsername($username)
    {
        $sql = 'SELECT * FROM ' . static::$tableName . ' WHERE `username` = ?';
        $stmt = App::$dbConnection->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows ? static::createModel($result->fetch_array()) : null;
    }

    /**
     * @param string $sessionHash
     * @return string
     */
    public static function generateSessionHash($sessionHash)
    {
        $ip = md5(md5(App::getInstance()->request->getServer()['REMOTE_ADDR']));

        return md5($ip . $sessionHash);
    }

    /**
     * @param string $sessionHash
     * @return bool
     */
    public function updateSessionHash($sessionHash)
    {
        if (!$this->isLoaded()) {
            return false;
        }

        $sql = 'UPDATE ' . static::$tableName . ' SET `sessionHash` = ? WHERE `id` = ?';
        $stmt = App::$dbConnection->prepare($sql);
        $stmt->bind_param('si', $sessionHash, $this->id);

        return $stmt->execute();
    }

    /**
     * @return int
     */
    public function getBalance()
    {
        return $this->balance;
    }

    public function withdrawBalance(float $amount)
    {
        if (!$this->isLoaded()) {
            return false;
        }

        $sql = 'UPDATE ' . static::$tableName . ' SET `balance` = `balance` - ? WHERE `balance` >= ? AND `id` = ?';
        $stmt = App::$dbConnection->prepare($sql);
        $stmt->bind_param('ddi', $amount, $amount, $this->id);
        $result = $stmt->execute();

        if ($result && $stmt->affected_rows > 0) {
            return true;
        }

        return  false;
    }
}