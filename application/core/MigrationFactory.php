<?php


namespace core;


use core\db\DatabaseConnection;

class MigrationFactory
{
    /**
     * @param string $className
     * @param DatabaseConnection $db
     * @return Migration
     */
    public function createByClassName(string $className, DatabaseConnection $db): Migration
    {
        return new $className($db);
    }
}