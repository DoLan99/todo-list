<?php

namespace App\Core;

class Database
{
    protected \PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = 'mysql:host='.$config['dbHost'].';port='.$config['dbPort'].';dbname='.$config['dbName'];
        $userName = $config['user'];
        $password = $config['password'];
        $this->pdo = new \PDO($dsn, $userName, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }
}