<?php

namespace App\Core;

use App\Exceptions\HttpNotFoundException;

class Router
{
    public function __construct(private array $registerRouting)
    {
    }

    public function resolve(string $accessPath): array
    {
        if (!in_array($accessPath, array_keys($this->registerRouting))) {
            throw new HttpNotFoundException();
        }

        return $this->registerRouting[$accessPath];
    }
}
