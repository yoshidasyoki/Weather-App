<?php

class Router
{
    public function __construct(private array $routingTable)
    {
    }

    public function routing(string $accessPath): array
    {
        if (!$this->canRouting($accessPath)) {
            throw new HttpNotFoundException();
        }

        return $this->routingTable[$accessPath];
    }

    private function canRouting(string $accessPath): bool
    {
        return (array_key_exists($accessPath, $this->routingTable));
    }
}
