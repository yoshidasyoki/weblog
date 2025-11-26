<?php

namespace App\Models;

use App\Core\DatabaseModel;
use \PDO;

class ArticleModel extends DatabaseModel
{
    public function findAllArticles()
    {
        $sql = <<<EOT
            SELECT article_id, username, title, sentence, articles.created_at, articles.updated_at
            From articles
            INNER JOIN users
                ON articles.user_id = users.user_id
            ORDER BY articles.updated_at DESC;
        EOT;

        return $this->fetchData($sql);
    }

    public function findArticle(int $articleId)
    {
        $sql = <<<EOT
            SELECT title, username, sentence, articles.updated_at
            FROM articles
            INNER JOIN users
            ON users.user_id = articles.user_id
            WHERE article_id = :article_id
        EOT;

        $params = [
            ['placeholder' => ':article_id', 'value' => $articleId, 'type' => PDO::PARAM_INT]
        ];

        return $this->fetchData($sql, $params, 'one');
    }

    public function insertArticle(int $userId, string $title, string $sentence, int $publicFlag)
    {
        $sql = <<<EOT
            INSERT INTO articles (user_id, title, sentence, is_public)
            VALUES (:user_id, :title, :sentence, :is_public)
        EOT;

        $params = [
            ['placeholder' => ':user_id', 'value' => $userId, 'type' => PDO::PARAM_INT],
            ['placeholder' => ':title', 'value' => $title],
            ['placeholder' => ':sentence', 'value' => $sentence],
            ['placeholder' => ':is_public', 'value' => $publicFlag, 'type' => PDO::PARAM_INT]
        ];

        $this->executeQuery($sql, $params);
    }
}
