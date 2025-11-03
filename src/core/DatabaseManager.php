<?php

class DatabaseManager
{
    private PDO $dbh;
    private array $models = [];

    public function connectDatabase(array $envInfo): void
    {
        $this->dbh = new PDO("mysql:host={$envInfo['hostname']};dbname={$envInfo['database']}", $envInfo['username'], $envInfo['password']);
    }

    public function getModel(string $modelName): DatabaseModel
    {
        if (!array_key_exists($modelName, $this->models)) {
            $this->models[$modelName] = new $modelName($this->dbh);
        }

        return $this->models[$modelName];
    }
}
