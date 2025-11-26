<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/vendor/sanitize.css">
    <link rel="stylesheet" href="/css/page/post/post.css">
</head>

<body>
    <header>
        <h1>投稿ページ</h1>
        <a href="/">Topへ戻る</a>
    </header>

    <main>
        <?php if (isset($errors)) : ?>
            <div class="message">
                <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?= htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="/article/write/post" method="post">
            <div>
                <h3>タイトル</h3>
                <input class="input_form title" type="text" name="article[title]">
            </div>

            <div>
                <h3>本文</h3>
                <textarea class="input_form sentence" name="article[sentence]" id=""></textarea>
            </div>

            <div>
                <h3>公開設定</h3>
                <div class="input_form">
                    <label class="radio-option">
                        <input type="radio" name="article[is_public]" value="1">
                        <span>公開する</span>
                    </label>

                    <label class="radio-option">
                        <input type="radio" name="article[is_public]" value="0">
                        <span>非公開にする</span>
                    </label>
                </div>
            </div>
            <button type="submit">投稿</button>
        </form>
    </main>
</body>

</html>
