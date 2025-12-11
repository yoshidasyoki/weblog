<?php

// データベースの構築と必要なテーブルを作成するための初期設定用のコード
// （本番環境では、データベースの構築が完了したらこのファイルは削除すること）

class DatabaseSetup
{
    public function run()
    {
        $hostname = 'db';
        $database = 'test_database';
        $username = 'test_user';
        $password = 'pass';

        $dbh = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
        $this->createUserTable($dbh);
        $this->createArticleTable($dbh);
        echo 'データベースの構築が完了しました。' . PHP_EOL;
    }

    private function createUserTable($dbh)
    {
        $dropSql = "DROP TABLE IF EXISTS users;";
        $dbh->exec($dropSql);

        $createSql = <<<EOT
            CREATE TABLE IF NOT EXISTS users (
                user_id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                username VARCHAR(50) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        EOT;

        $dbh->exec($createSql);
    }

    private function createArticleTable($dbh)
    {
        $dropSql = "DROP TABLE IF EXISTS articles;";
        $dbh->exec($dropSql);

        // is_publicは 0:非公開 1:公開 として扱う
        $createSql = <<<EOT
            CREATE TABLE IF NOT EXISTS articles (
                article_id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                title VARCHAR(100) NOT NULL,
                sentence TEXT,
                is_public INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        EOT;

        $dbh->exec($createSql);
    }
}

$databaseSetup = new DatabaseSetup();
$databaseSetup->run();
