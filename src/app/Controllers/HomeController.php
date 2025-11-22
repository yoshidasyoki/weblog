<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;

class HomeController extends Controller
{
    public function index()
    {
        $content = $this->render();
        return Response::html(200, $content);
    }
}
