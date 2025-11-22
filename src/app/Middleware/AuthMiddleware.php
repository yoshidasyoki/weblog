<?php

namespace App\Middleware;

use App\Core\Response;

class AuthMiddleware
{
    public function handle()
    {
        if (!isset($_SESSION['user_id'])) {
            Response::redirect('/login')->send();
        }

        if (isset($_SESSION['user_id'])) {
            Response::redirect('/home')->send();
        }
    }
}
