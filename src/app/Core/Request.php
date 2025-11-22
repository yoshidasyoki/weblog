<?php

namespace App\Core;

use App\Core\Response;

class Request
{
    public function getAccessPath(): string
    {
        return $_SERVER['REQUEST_URI'];
    }
}
