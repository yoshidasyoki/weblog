<?php

namespace App\Services;

use App\Core\DatabaseManager;
use App\Models\ArticleModel;

class HomeService
{
    private ArticleModel $articleModel;

    public function __construct(private DatabaseManager $databaseManager)
    {
        $this->articleModel = $this->databaseManager->getModel('ArticleModel');
    }

    public function getAllArticles()
    {
        $articles = $this->articleModel->findAllArticles();
        return $articles;
    }
}
