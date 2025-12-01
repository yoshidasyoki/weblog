<?php

namespace App\Middlewares;

class AuthMiddleware
{
    private array $excludePath = [
        '/',
        '/login',
        '/login/auth',
        '/register',
        '/register/create',
    ];

    public function handle($accessPath): bool
    {
        if (in_array($accessPath, $this->excludePath)) {
            return true;
        }

        if (!empty($_SESSION['user_id'])) {
            return true;
        }

        return false;
    }
}
