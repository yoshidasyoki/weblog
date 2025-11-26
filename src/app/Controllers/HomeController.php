<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;

class HomeController extends Controller
{
    public function index()
    {
        $params = [
            'isLoggedIn' => false
        ];

        if (isset($_SESSION['user_id'])) {
            $params = [
                'isLoggedIn' => true,
                'username' => $_SESSION['username']
            ];
        }

        if (isset($_SESSION['logoutMsg'])) {
            $params['message'] = $_SESSION['logoutMsg'];
            unset($_SESSION['logoutMsg']);
        }

        $params['articles'] = $this->service->getAllArticles();

        $content = $this->render('index', $params);
        return Response::html(200, $content);
    }
}
