<?php

class Response
{
    public function send(int $statusCode, array $httpResponseBody = []): void
    {
        header_remove('Content-Type');
        http_response_code($statusCode);

        if (array_key_exists('json', $httpResponseBody)) {
            header('Content-Type: application/json');
            $json = json_encode($httpResponseBody);
            echo $json;
            return;
        }

        if (array_key_exists('content', $httpResponseBody)) {
            header('Content-Type: text/html');
            echo $httpResponseBody['content'];
            return;
        }
    }
}
