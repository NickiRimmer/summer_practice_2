<!DOCTYPE html>
<html>
    <head>
        <title>Редактирование</title>
        <link rel="stylesheet" href="./styles/header.css">
        <link rel="stylesheet" href="./styles/login.css">
    </head>
    <body>
        <?php include('header.php'); ?>
        <div class="login-container">
            <h2>Редактирование информации о питомце</h2>
            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label for="name">Имя:</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
                </div>
                <div class="form-group">
                    <label for="spec">Порода:</label>
                    <input type="text" id="spec" name="spec" value="<?= htmlspecialchars($spec) ?>" required>
                </div>
                <div class="form-group">
                    <label for="bio">Информация о питомце:</label>
                    <textarea id="bio" name="bio" style="width: 98%;" required><?= htmlspecialchars($bio) ?></textarea>
                </div>
                <button type="submit" class="submit-button">Сохранить</button>
            </form>
            <div class="register-link">
                <a href="/del_pet?id=<?= $_GET['id'] ?>">Удалить аккаунт</a>
            </div>
        </div>
    </body>
</html>