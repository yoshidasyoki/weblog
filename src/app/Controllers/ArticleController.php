<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;
use App\Exceptions\HttpNotFoundException;

class ArticleController extends Controller
{
    public function index()
    {
        $articleId = $_GET['id'];
        $article = $this->service->search($articleId);
        $content = $this->render('index', $article);
        return Response::html(200, $content);
    }

    public function write()
    {
        $content = $this->render();
        return Response::html(200, $content);
    }

    public function post()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }

        $userId = $_SESSION['user_id'];
        $postedArticle = $_POST['article'];
        $result = $this->service->post($userId, $postedArticle);

        if (!$result['flag']) {
            $content = $this->render('write', $result);
            return Response::html(200, $content);
        }

        $_SESSION['message'] = '投稿が完了しました';
        return Response::redirect('/');
    }

    public function history()
    {
        $result = [];

        if (isset($_SESSION['message'])) {
            $result['message'] = $_SESSION['message'];
            $_SESSION['message'] = [];
        }

        $userId = $_SESSION['user_id'];
        $result['articles'] = $this->service->getUserArticles($userId);
        $content = $this->render('history', $result);
        return Response::html(200, $content);
    }

    public function edit()
    {
        $userId = $_SESSION['user_id'];
        $articleId = $_GET['id'];
        $result['article'] = $this->service->getUserArticle($articleId, $userId);
        $content = $this->render('edit', $result);
        return Response::html(200, $content);
    }

    public function update()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }

        $articleId = $_GET['id'];
        $userId = $_SESSION['user_id'];
        $updateArticle = $_POST['article'];
        $this->service->update($articleId, $userId, $updateArticle);

        $_SESSION['message'] = '編集が完了しました';
        return Response::redirect('/history');
    }

    public function delete()
    {
        $articleId = $_GET['id'];
        $userId = $_SESSION['user_id'];
        $this->service->delete($articleId, $userId);

        $_SESSION['message'] = '削除しました';
        return Response::redirect('/history');
    }
}
