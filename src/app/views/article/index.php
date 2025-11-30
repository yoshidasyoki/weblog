<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿ページ</title>
    <link rel="stylesheet" href="/css/vendor/sanitize.css">
    <link rel="stylesheet" href="/css/page/article/index.css">
</head>

<body>
    <header>
        <h1>記事閲覧</h1>
        <a href="/">Topへ戻る</a>
    </header>

    <main>
        <div class="article-card">
            <h2><?= htmlspecialchars($title); ?></h2>

            <div class="article-meta">
                <span class="author">投稿者: <?= htmlspecialchars($username); ?></span>
                <span class="date">更新日: <?= htmlspecialchars($updated_at); ?></span>
            </div>

            <p class="sentence"><?= htmlspecialchars($sentence); ?></p>
        </div>
    </main>
</body>

</html>
