<?php

namespace App\Database;

use PDO;
use PDOStatement;

/**
 * Class Repositories
 *
 * @package App
 */
class Repositories
{
    /**
     * @var MySQLConnector
     */
    private $connector;

    public function __construct()
    {
        $this->connector = MySQLConnector::getInstance();
    }

    /**
     * @param string $query
     *
     * @return mixed
     */
    protected function fetch($query, $bind = array())
    {
        $request = $this->connector->dbh->prepare($query);

        $request = $this->bindValue($request, $bind);

        $request->execute();

        return $request->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $query
     *
     * @return mixed
     */
    protected function fetchAll($query, $bind = array())
    {
        $request = $this->connector->dbh->prepare($query);

        $request = $this->bindValue($request, $bind);

        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $query
     *
     * @return mixed
     */
    protected function execute($query, $bind = array())
    {
        $request = $this->connector->dbh->prepare($query);

        $request = $this->bindValue($request, $bind);

        return $request->execute();
    }

    /**
     * @param PDOStatement $request
     * @param array $bind
     *
     * @return PDOStatement
     */
    private function bindValue(PDOStatement $request, array $bind = array())
    {
        foreach ($bind as $key => $val) {
            $request->bindValue($key, $val);
        }

        return $request;
    }
}