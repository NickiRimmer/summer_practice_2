<!DOCTYPE html>
<html>
    <head>
        <title>Новый питомец</title>
        <link rel="stylesheet" href="./styles/header.css">
        <link rel="stylesheet" href="./styles/new_post.css">
    </head>
    <body>
        <?php include('header.php'); ?>
        <div class="login-container">
            <h2>Новый питомец</h2>
            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label for="name">Имя питомца:</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
                </div>
                <div class="form-group">
                    <label for="spec">Порода питомца:</label>
                    <input type="text" id="spec" name="spec" value="<?= htmlspecialchars($spec) ?>" required>
                </div>
                <div class="form-group">
                    <label for="bio">Описание питомца:</label>
                    <textarea type="text" id="bio" name="bio" style="width: 98%; max-width: 98%; height: 100px;" required><?= $bio ?></textarea>
                </div>
                <!--div class="form-group">
                    <label for="photo">Фотогравия Питомца:</label>
                    <input type="file" id="photo" name="photo">
                </div-->
                <button type="submit" class="submit-button">Сохранить</button>
            </form>
        </div>
    </body>
</html>