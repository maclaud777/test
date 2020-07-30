<?php
declare(strict_types=1);

namespace Core;

/**
 * Class Model
 * @package core
 */
abstract class Model
{
    /**
     * @var string
     */
    public static string $tableName;

    /**
     * @var int
     */
    public int $id;

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * @param integer $id
     * @return null|Model
     */
    public static function findById($id)
    {
        $sql = 'SELECT * FROM ' . static::$tableName . ' WHERE `id` = ?';
        $stmt = App::$dbConnection->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows ? static::createModel($result->fetch_array()) : null;
    }

    /**
     * @param $attributes
     * @return static
     */
    public static function createModel($attributes)
    {
        $model = new static();
        foreach ($attributes as $key => $value) {
            $model->$key = $value;
        }

        return $model;
    }

    /**
     * @return bool
     */
    public function isLoaded()
    {
        return $this->id > 0;
    }
}