<!DOCTYPE html>
<html>
    <head>
        <title>Регистрация</title>
        <link rel="stylesheet" href="./styles/header.css">
        <link rel="stylesheet" href="./styles/login.css">
    </head>
    <body>
        <?php include('header.php'); ?>
        <div class="login-container">
            <h2>Регистрация</h2>
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
                <div class="form-group">
                    <label for="first_name">Имя:</label>
                    <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($first_name) ?>" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Фамилия:</label>
                    <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($last_name) ?>" required>
                </div>
                <div class="form-group">
                    <label for="bio">Информация о себе:</label>
                    <textarea type="password" id="bio" name="bio" style="width: 98%;" required><?= htmlspecialchars($bio) ?></textarea>
                </div>

                <button type="submit" class="submit-button">Зарегистрироваться</button>
            </form>
            <div class="register-link">
                <a href="/login">Войти</a>
            </div>
        </div>
    </body>
</html>