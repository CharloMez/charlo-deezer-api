<?php

namespace App\Database;

use PDO;

/**
 * Class MySQLConnector
 *
 * @package App
 */
class MySQLConnector
{
    /**
     * @var null|MySQLConnector
     */
    private static $instance = null;

    /**
     * @var \PDO
     */
    public $dbh;

    private function __construct(array $config = array())
    {
        try {
            $this->dbh = new PDO(
                sprintf(
                    'mysql:host=%s:%s;dbname=%s',
                    $config['database_host'],
                    $config['database_port'],
                    $config['database_name']
                ),
                $config['database_user'],
                $config['database_password']
            );
        } catch (\PDOException $e) {
            throw new \Exception('Database connection error ! ' . $e->getMessage());
        }
    }

    public function __destruct()
    {
        $this->dbh = null;
    }

    /**
     * @return MySQLConnector
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            throw new \Exception('Database error ! Init Database first');
        }

        return self::$instance;
    }

    public static function initDB(array $config = array())
    {
        if (empty($config)) {
            throw new \Exception('Database error ! Missing database config');
        }

        if (is_null(self::$instance)) {
            self::$instance = new MySQLConnector($config);
        }
    }
}