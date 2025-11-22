<?php

namespace App\Core;

class Router
{
    public function __construct(private array $registerRouting)
    {
    }

    public function resolve(string $accessPath): array
    {
        if (in_array($accessPath, array_keys($this->registerRouting))){
            return $this->registerRouting[$accessPath];
        } else {
            return [];
        }
    }
}
