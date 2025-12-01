<?php

namespace App\Services;

use App\Core\DatabaseManager;
use App\Exceptions\HttpNotFoundException;
use App\Helpers\TimeHelper;
use App\Models\ArticleModel;

class ArticleService
{
    private const MAX_TITLE_LENGTH = 100;
    private const MAX_SENTENCE_LENGTH = 1000;
    private const DEFINE_PUBLIC_FLAG_ARRAY = [0, 1];

    private ArticleModel $articleModel;

    public function __construct(
        private DatabaseManager $databaseManager,
        private TimeHelper $timeHelper)
    {
        $this->articleModel = $this->databaseManager->getModel('ArticleModel');
    }

    public function search(int $articleId): array
    {
        $result = $this->articleModel->findArticle($articleId);
        if (!$result) {
            throw new HttpNotFoundException();
        }

        $result['updated_at'] = $this->timeHelper->convertTimeJst($result['updated_at']);
        return $result;
    }

    public function post(int $userId, array $article)
    {
        $title = empty($article['title']) ? '無題' : $article['title'];
        $sentence = $article['sentence'];
        $publicFlag = $article['is_public'] ?? null;

        $errors = [];
        $errors = $this->validateTitle($title, $errors);
        $errors = $this->validateSentence($sentence, $errors);
        $errors = $this->validatePublicFlag($publicFlag, $errors);

        if (!empty($errors)) {
            return [
                'flag' => false,
                'errors' => $errors
            ];
        }

        $this->articleModel->insertArticle($userId, $title, $sentence, $publicFlag);
        return ['flag' => true];
    }

    public function getUserArticles(int $userId)
    {
        $articles = $this->articleModel->findUserArticles($userId);
        return array_map(function($article) {
            $article['updated_at'] = $this->timeHelper->convertTimeJst($article['updated_at']);
            $article['created_at'] = $this->timeHelper->convertTimeJst($article['created_at']);
            return $article;
        }, $articles);
    }

    public function getUserArticle(int $articleId, int $userId)
    {
        $result = $this->articleModel->findUserArticle($articleId, $userId);
        if (!$result) {
            throw new HttpNotFoundException();
        }
        return $result;
    }

    public function update(int $articleId, int $userId, array $updateArticle)
    {
        $title = $updateArticle['title'];
        $sentence = $updateArticle['sentence'];
        $publicFlag = $updateArticle['is_public'];
        $this->articleModel->updateArticle($articleId, $userId, $title, $sentence, $publicFlag);
    }

    public function delete(int $article, int $userId)
    {
        $this->articleModel->deleteArticle($article, $userId);
    }

    private function validateTitle(string $title, array $errors)
    {
        if (mb_strlen($title) > self::MAX_TITLE_LENGTH) {
            $errors[] = 'タイトル上限は100文字です';
        }
        return $errors;
    }

    private function validateSentence(string $sentence, array $errors)
    {
        if (empty($sentence)) {
            $errors[] = '本文を入力してください';
        }

        if (mb_strlen($sentence) > self::MAX_SENTENCE_LENGTH) {
            $errors[] = '本文の上限は1000文字です';
        }
        return $errors;
    }

    private function validatePublicFlag(?int $publicFlag, array $errors)
    {
        if (!isset($publicFlag)) {
            $errors[] = '公開設定は必須です';
            return $errors;
        }

        if (!in_array($publicFlag, self::DEFINE_PUBLIC_FLAG_ARRAY)) {
            $errors[] = '不正な公開設定が入力されました';
        }

        return $errors;
    }
}
