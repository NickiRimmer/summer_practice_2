<!DOCTYPE html>
<html>
    <head>
        <title>Авторизация</title>
        <link rel="stylesheet" href="./styles/header.css">
        <link rel="stylesheet" href="./styles/login.css">
    </head>
    <body>
        <?php include('header.php'); ?>
        <div class="login-container">
            <h2>Авторизация</h2>
            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label for="username">Логин:</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($username) ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Пароль:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="submit-button">Войти</button>
            </form>
            <div class="register-link">
                <a href="/register">Зарегистрироваться</a>
            </div>
        </div>
    </body>
</html>