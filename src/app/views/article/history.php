<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Topページ</title>
    <link rel="stylesheet" href="css/vendor/sanitize.css">
    <link rel="stylesheet" href="css/page/article/history.css">

</head>

<body>
    <header>
        <h1>自分の投稿記事</h1>
        <div>
            <a href="/logout">ログアウト</a>
            <a href="/">トップへ</a>
        </div>
    </header>

    <main>
        <?php if (!empty($message)) : ?>
            <div class="message">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <h2>記事の編集</h2>
        <p>編集したい記事をクリックしてください。</p>

        <?php if (empty($articles)) : ?>
            <p>※ 投稿記事がまだありません。</p>
        <?php endif; ?>

        <?php foreach ($articles as $article) : ?>
            <a href="/history/edit?id=<?= htmlspecialchars($article['article_id']); ?>">
                <div class="article">
                    <div class="sub-header">
                        <?php if ($article['is_public'] === 1) : ?>
                            <span class="public">公開</span>
                        <?php elseif ($article['is_public'] === 0) : ?>
                            <span class="private">非公開</span>
                        <?php endif; ?>
                        <h3><?= htmlspecialchars($article['title']); ?></h3>
                    </div>
                    <p class="meta">
                        投稿日: <?= htmlspecialchars($article['created_at']) ?> /
                        更新日: <?= htmlspecialchars($article['updated_at']); ?>
                    </p>
                </div>
            </a>
        <?php endforeach; ?>
    </main>

</body>

</html>
