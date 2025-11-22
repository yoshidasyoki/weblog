<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;
use App\Services\RegisterService;

class RegisterController extends Controller
{
    public function index(): Response
    {
        $content = $this->render();
        return Response::html(200, $content);
    }

    public function create()
    {
        $service = $this->getService();
        $result = $service->register($_POST['username'], $_POST['email'], $_POST['password']);

        if ($result['flag'] === false) {
            $content = $this->render('index', ['errors' => $result['errors']]);
            return Response::html(200, $content);
        }

        return Response::redirect('/login');
    }
}
