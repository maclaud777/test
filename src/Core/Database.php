<?php
declare(strict_types=1);

namespace Core;

use mysqli;

/**
 * Class Database
 * @package Core
 */
class Database
{
    /**
     * @var mysqli
     */
    protected mysqli $connection;

    /**
     * @param array $dbParams
     * @return mysqli
     * @throws Exception
     */
    public function connect(array $dbParams)
    {
        $this->connection = new mysqli($dbParams['host'], $dbParams['username'], $dbParams['password'], $dbParams['dbname']);

        if ($this->connection->connect_errno) {
            throw new Exception(
                'Database error: code  ' . $this->connection->connect_errno . ' | message: ' . $this->connection->connect_error
            );
        }

        register_shutdown_function([$this, 'close']);

        return $this->connection;
    }

    /**
     * Close connection
     */
    public function close()
    {
        $this->connection->close();
        App::$logger->debug('DB close');
    }
}