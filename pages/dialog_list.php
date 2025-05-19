<!DOCTYPE html>
<html>
    <head>
        <title>Диалоги</title>
        <link rel="stylesheet" href="./styles/profile.css">
        <link rel="stylesheet" href="./styles/header.css">
    </head>
    <body>
        <?php include('header.php'); ?>
        <div class="profile">
            <div class="posts">
            <h2>Диалоги</h2>
            <?php if (!empty($dialogs)): ?>
                <?php foreach ($dialogs as $dialog): ?>
                <div class="post"><a href="/dialog?id=<?= $dialog['uid'] ?>">
                    <h2><?= $dialog['first_name'] ?> <?= $dialog['last_name'] ?></h2>
                </a></div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Пока нет ни одного диалога.</p>
            <?php endif; ?>
            </div>
        </div>
    </body>
</html>