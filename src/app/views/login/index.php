<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="/css/vendor/sanitize.css">
    <link rel="stylesheet" href="/css/page/login/login.css">
</head>

<body>

    <div class="container">
        <h1>ログイン</h1>

        <?php if (isset($errors)) : ?>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form action="/login/auth" method="post">
            <label>
                メールアドレス：
                <input type="text" name="email">
            </label>

            <label>
                パスワード：
                <input type="password" name="password">
            </label>

            <button type="submit">ログイン</button>
        </form>

        <a class="register-link" href="/register">新規登録はこちら</a>
    </div>

</body>

</html>
