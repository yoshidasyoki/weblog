<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/vendor/sanitize.css">
    <link rel="stylesheet" href="/css/page/article/edit.css">
</head>

<body>
    <header>
        <h1>編集ページ</h1>
        <div>
            <a href="/">Topへ戻る</a>
            <a href="/history">編集一覧へ戻る</a>
        </div>
    </header>

    <main>
        <div class="container">
            <?php if (isset($errors)) : ?>
                <div class="message">
                    <ul>
                        <?php foreach ($errors as $error) : ?>
                            <li><?= htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/history/edit/update?id=<?= $article['article_id']; ?>" method="post">
                <div>
                    <h3>タイトル</h3>
                    <input class="input-form title" type="text" name="article[title]"
                        value=<?= htmlspecialchars($article['title']); ?>>
                </div>

                <div>
                    <h3>本文</h3>
                    <textarea class="input-form sentence" name="article[sentence]"><?= htmlspecialchars($article['sentence']); ?></textarea>
                </div>

                <div>
                    <h3>公開設定</h3>
                    <div class="input-form">
                        <label class="radio-option">
                            <input type="radio" name="article[is_public]" value="1"
                                <?php if ($article['is_public'] === 1) echo 'checked'; ?>>
                            <span>公開する</span>
                        </label>

                        <label class="radio-option">
                            <input type="radio" name="article[is_public]" value="0"
                                <?php if ($article['is_public'] === 0) echo 'checked'; ?>>
                            <span>非公開にする</span>
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn-update">修正</button>
            </form>

            <div class="action-buttons">
                <a href="/history" class="btn-back">戻る</a>
                <a href="/history/edit/delete?id=<?= $article['article_id']; ?>"class="btn-remove">
                    削除
                </a>
            </div>
        </div>
    </main>
</body>

</html>
