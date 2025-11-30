<?php

namespace App\Services;

use App\Core\DatabaseManager;
use App\Helpers\TimeHelper;
use App\Models\ArticleModel;

class HomeService
{
    private ArticleModel $articleModel;

    public function __construct(
        private DatabaseManager $databaseManager,
        private TimeHelper $timeHelper)
    {
        $this->articleModel = $this->databaseManager->getModel('ArticleModel');
    }

    public function getAllArticles()
    {
        $articles = $this->articleModel->findAllArticles();
        return array_map(function($article) {
            $article['updated_at'] = $this->timeHelper->convertTimeJst($article['updated_at']);
            $article['created_at'] = $this->timeHelper->convertTimeJst($article['created_at']);
            return $article;
        }, $articles);
    }
}
