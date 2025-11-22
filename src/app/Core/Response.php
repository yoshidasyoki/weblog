<?php

namespace App\Core;

class Response
{
    public function __construct(
        private int $statusCode,
        private string $header,
        private string $content = ''
    ) {}

    public static function html($statusCode, $content)
    {
        $header = 'Content-Type: text/html; charset=utf-8';
        return new self($statusCode, $header, $content);
    }

    public static function redirect($url, $statusCode = 302)
    {
        $header = "Location: $url";
        return new self($statusCode, $header);
    }

    public function send()
    {
        http_response_code($this->statusCode);
        header($this->header);
        echo $this->content;
    }
}
