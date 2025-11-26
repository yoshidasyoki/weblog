<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
    <link rel="stylesheet" href="/css/vendor/sanitize.css">
    <link rel="stylesheet" href="/css/page/register/register.css">
</head>

<body>

    <div class="container">

        <h1>新規登録</h1>

        <?php if (isset($errors)) : ?>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?= htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form action="/register/create" method="post">

            <label>
                ユーザー名：
                <input type="text" name="username">
            </label>

            <label>
                メールアドレス：
                <input type="text" name="email">
            </label>

            <label>
                パスワード：
                <input type="password" name="password">
            </label>

            <button type="submit">登録</button>
        </form>

        <a class="login-link" href="/login">ログインはこちら</a>

    </div>

</body>

</html>
