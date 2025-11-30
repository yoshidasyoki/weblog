<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;

class RegisterController extends Controller
{
    public function index(): Response
    {
        $content = $this->render();
        return Response::html(200, $content);
    }

    public function create()
    {
        $result = $this->service->register($_POST['username'], $_POST['email'], $_POST['password']);

        if ($result['flag'] === false) {
            $content = $this->render('index', ['errors' => $result['errors']]);
            return Response::html(200, $content);
        }

        $_SESSION['message'] = '登録が完了しました';
        return Response::redirect('/login');
    }
}
