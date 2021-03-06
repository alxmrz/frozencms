<?php

namespace FF\db;

/**
 * Class DatabaseConnection
 * @package core
 */
class DatabaseConnection
{

    protected $pdo;
    private static $self;

    /**
     * @param $config array
     */
    public function __construct($config)
    {
        try {
            $this->pdo = new \PDO("mysql:host={$config['dbhost']};dbname={$config['dbname']}", $config['dbuser'], $config['dbpassword']);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("SET NAMES {$config['dbencoding']}");
        } catch (PDOException $ex) {
            //TODO: remake the way of displaying error
            $error = "Database error!";
            include '/view/error.php';
            exit();
        }
    }

    public function exec($sql)
    {
        return $this->pdo->exec($sql);
    }

    /**
     * @param string $tableName
     * @param $columnName
     * @return array
     */
    public function queryColumn(string $tableName, $columnName): array
    {
        $statement = $this->pdo->prepare("SELECT {$columnName} FROM {$tableName}");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_COLUMN, $columnName);
    }
}
