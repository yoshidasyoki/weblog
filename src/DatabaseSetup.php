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

        $dropSql = "DROP TABLE IF EXISTS users;";
        $dbh->exec($dropSql);

        $createSql = <<<EOT
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
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
}

$databaseSetup = new DatabaseSetup();
$databaseSetup->run();
