<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
</head>
<body>
    <h1>新規登録ページ</h1>
    <p>
        <?php if (isset($errors)) : ?>
            <ul>
                <?php foreach($errors as $error) : ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </p>
    <form action="/register/create" method="post">
        <div>
            <label for="username">
                ユーザー名：
                <input type="text" name="username">
            </label>
        </div>
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
        <button type="submit">登録</button>
    </form>
    <a href="/login">ログインはこちら</a>
</body>
</html>
