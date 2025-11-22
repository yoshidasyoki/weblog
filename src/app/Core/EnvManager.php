<?php

namespace App\Core;

use Dotenv;

class EnvManager
{
    public function run()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        return [
            'hostname' => $_ENV['HOST'],
            'database' => $_ENV['DATABASE'],
            'username' => $_ENV['USER'],
            'password' => $_ENV['PASS']
        ];
    }
}
