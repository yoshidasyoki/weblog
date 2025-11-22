<?php

namespace App\Controllers;

use App\Application;
use App\Core\Response;
use App\Core\Controller;
use App\Services\LoginService;

class LoginController extends Controller
{
    public function index(): Response
    {
        $content = $this->render();
        return Response::html(200, $content);
    }

    public function auth()
    {
        $service = $this->getService();
        $result = $service->auth($_POST['email'], $_POST['password']);

        if ($result['flag'] === false) {
            $content = $this->render('index', ['errors' => $result['errors']]);
            return Response::html(200, $content);
        }

        $userId = $result['user']['id'];

        session_regenerate_id(true);
        $_SESSION['user_id'] = $userId;
        return Response::redirect('/home');
    }

    public function logout()
    {
        $_SESSION = [];
        setcookie('PHPSESSID', '', time() - 3600);
        session_destroy();

        $content = $this->render();
        return Response::html(200, $content);
    }

    // private function getService(): LoginService
    // {
    //     $loginModel = $this->databaseManager->getModel('LoginModel');
    //     return new LoginService($loginModel);
    // }
}
