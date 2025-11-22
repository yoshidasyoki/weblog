<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
</head>

<body>
    <h1>ログインページ</h1>
    <p>
        <?php if (isset($errors)) : ?>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </p>
    <form action="/login/auth" method="post">
        <div>
            <label for="email">
                メールアドレス：
                <input type="text" name="email">
            </label>
        </div>
        <div>
            <label for="password">
                パスワード：
                <input type="password" name="password">
            </label>
        </div>
        <button type="submit">ログイン</button>
    </form>
    <a href="/register">新規登録はこちら</a>
</body>

</html>
