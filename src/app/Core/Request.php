<?php

namespace App\Core;

class Request
{
    public function getAccessPath()
    {
        $url = $_SERVER['REQUEST_URI'];
        $path = parse_url($url)['path'];
        return $path;
    }
}
