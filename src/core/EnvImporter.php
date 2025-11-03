<?php

require __DIR__ . '/../vendor/autoload.php';

class EnvImporter
{
    public function run(): array
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        if (!$this->canImport()) {
            throw new EnvImportException();
        }

        return [
            'hostname' => $_ENV['HOST'],
            'database' => $_ENV['DATABASE'],
            'username' => $_ENV['USER'],
            'password' => $_ENV['PASS']
        ];
    }

    private function canImport(): bool
    {
        return (!empty($_ENV['HOST']) && !empty($_ENV['DATABASE']) && !empty($_ENV['USER']) && !empty($_ENV['PASS']));
    }
}
