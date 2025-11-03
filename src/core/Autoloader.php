<?php

class Autoloader
{
    private array $dirPaths = [];

    public function __construct(private string $baseDir)
    {
    }

    public function registerDir(string $dirName): void
    {
        $this->dirPaths[] = $dirName;
    }

    public function autoload(): void
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    private function loadClass(string $className): void
    {
        foreach ($this->dirPaths as $dirPath) {
            $filePath = $this->baseDir . $dirPath . '/' . $className . '.php';
            if (is_readable($filePath)) {
                require_once $filePath;
            }
        }
    }
}
