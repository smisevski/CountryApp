<?php
namespace App\Libs;

use \App\Libs\Config;
use PDO;
use PDOException;

class DatabaseDriver 
{
    public $pdo;

    public function __construct() {
        $connParams = Config::get('connectionParams');
        $this->connect($connParams);
    }

    private function connect($params) {
        try {
            $this->pdo = new PDO($params['dataSourceName'], $params['user'], $params['password']);
        } catch (PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}