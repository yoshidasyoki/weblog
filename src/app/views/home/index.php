<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Topページ</title>
    <link rel="stylesheet" href="css/vendor/sanitize.css">
    <link rel="stylesheet" href="css/page/home/home.css">

</head>

<body>
    <header>
        <h1>Topページ</h1>

        <?php if ($isLoggedIn) : ?>
            <div>
                <span>ようこそ、<?= htmlspecialchars($username) ?> さん！</span>
                <a href="/logout">ログアウト</a>
                <a href="/article/write">投稿する</a>
                <a href="/history">投稿記事</a>
            </div>
        <?php else : ?>
            <a href="/login">ログイン</a>
        <?php endif; ?>
    </header>

    <main>
        <h2>記事一覧</h2>
        <?php if (isset($message)) : ?>
            <div class="message">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($articles)) : ?>
            <p>投稿記事がまだありません。</p>
        <?php endif; ?>

        <?php foreach ($articles as $article) : ?>
            <a href="/article?id=<?= htmlspecialchars($article['article_id']); ?>">
                <div class="article">
                    <h3><?= htmlspecialchars($article['title']); ?></h3>
                    <p class="meta">
                        投稿者: <?= htmlspecialchars($article['username']); ?> /
                        更新日: <?= htmlspecialchars($article['updated_at']); ?>
                    </p>
                </div>
            </a>
        <?php endforeach; ?>
    </main>

</body>

</html>
