<?php

namespace App\Core;

use App\Core\DatabaseManager;

class Service
{
    public function __construct(protected DatabaseManager $databaseManager)
    {
    }
}
