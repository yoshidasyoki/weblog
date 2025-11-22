<?php

namespace App\Core;

use \PDO;
use App\Models\LoginModel;
use App\Core\DatabaseModel;

class DatabaseManager
{
    private PDO $dbh;
    private array $models = [];

    public function connectDatabase(array $env)
    {
        $dbh = new PDO(
            "mysql:host={$env['hostname']};dbname={$env['database']}",
            $env['username'],
            $env['password']
        );
        $this->dbh = $dbh;
        return $this->dbh;
    }

    public function getModel(string $modelName)
    {
        if (!isset($this->models[$modelName])) {
            $modelClass = 'App\\Models\\' . $modelName;
            $this->models[$modelName] = new $modelClass($this->dbh);
        }

        return $this->models[$modelName];
    }
}
