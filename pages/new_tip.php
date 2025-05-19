<!DOCTYPE html>
<html>
    <head>
        <title>Новый совет</title>
        <link rel="stylesheet" href="./styles/header.css">
        <link rel="stylesheet" href="./styles/new_post.css">
    </head>
    <body>
        <?php include('header.php'); ?>
        <div class="login-container">
            <h2>Новый совет:</h2>
            <form method="post">
                <div class="form-group">
                    <label for="text">Текст:</label>
                    <textarea type="text" id="text" name="text" style="width: 98%; max-width: 98%; height: 100px;" required></textarea>
                </div>
                <!--div class="form-group">
                    <label for="photo">Фотогравия к совету:</label>
                    <input type="file" id="photo" name="photo">
                </div-->
                <button type="submit" class="submit-button">Опубликовать</button>
            </form>
        </div>
    </body>
</html>