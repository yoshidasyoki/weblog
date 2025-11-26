<?php

namespace App\Controllers;

use App\Core\Response;
use App\Core\Controller;

class LoginController extends Controller
{
    public function index(): Response
    {
        $content = $this->render();
        return Response::html(200, $content);
    }

    public function auth()
    {
        $result = $this->service->auth($_POST['email'], $_POST['password']);

        if ($result['flag'] === false) {
            $content = $this->render('index', ['errors' => $result['errors']]);
            return Response::html(200, $content);
        }

        $userInfo = $result['user'];
        $userId = $userInfo['user_id'];
        $username = $userInfo['username'];

        session_regenerate_id(true);
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        return Response::redirect('/');
    }

    public function logout()
    {
        $_SESSION = [];
        session_regenerate_id(true);
        $_SESSION['logoutMsg'] = 'ログアウトしました';

        return Response::redirect('/');
    }
}
