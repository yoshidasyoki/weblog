<?php

namespace App\Controllers;

use \DateTime;
use \DateTimeZone;
use App\Core\Controller;
use App\Core\Response;

class ArticleController extends Controller
{
    public function index()
    {
        $articleId = $_GET['id'];
        $result = $this->service->search($articleId);
        $result['updated_at'] = $this->convertTimeJst($result['updated_at']);
        $content = $this->render('index', $result);
        return Response::html(200, $content);
    }

    public function write()
    {
        $content = $this->render();
        return Response::html(200, $content);
    }

    public function post()
    {
        $userId = $_SESSION['user_id'];
        $postedArticle = $_POST['article'];
        $result = $this->service->post($userId, $postedArticle);

        if (!$result['flag']) {
            $content = $this->render('write', $result);
            return Response::html(200, $content);
        }
        return Response::redirect('/');
    }

    public function history()
    {
    }

    private function convertTimeJst($date, $formatType = 'Y年m月d日'): string
    {
        $utc = new DateTime($date, new DateTimeZone('UTC'));
        $utc->setTimeZone(new DateTimeZone('Asia/Tokyo'));
        return $utc->format($formatType);
    }
}
