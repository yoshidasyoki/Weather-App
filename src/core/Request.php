<?php

class Request
{
    public function getAccessPath(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getRequestData(): array
    {
        $raw = file_get_contents('php://input');
        $requestData = json_decode($raw, true);
        if ($requestData) {
            $requestData['searches'] = array_keys(array_filter($requestData['search'], fn($value) => $value === true));
        } else {
            $requestData = "";
        }
        return $requestData;
    }

    public function isPost(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] === 'POST');
    }
}
