<?php

namespace App\Core;

class Request
{
    public function getAccessPath(): string
    {
        $url = $_SERVER['REQUEST_URI'];
        $path = parse_url($url)['path'];
        return $path;
    }

    public function isPost(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] === 'POST');
    }
}
