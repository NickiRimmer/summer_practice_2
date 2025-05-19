<?php

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Питомец</title>
        <link rel="stylesheet" href="./styles/profile.css">
        <link rel="stylesheet" href="./styles/header.css">
    </head>
    <body>
        <?php include('header.php'); ?>
        <div class="profile">
            <?php if($isconf): ?>
            <div style="position: absolute; right: 10%;" class="add-button">
                <a href="/edit_pet?id=<?= $_GET['id'] ?>">Редактировать</a>
            </div>
            <?php endif; ?>

            <div class="profile-header">
            <img src="<?= htmlspecialchars($user['photo_url'] ?? '/default_pet.png') ?>" alt="Фото профиля" class="profile-photo">
            <h1><?= htmlspecialchars($user['name'] ?? 'Имя') ?></h1>
            <p class="username"><?= htmlspecialchars($user['spec'] ?? '')?></p>
            <p class="bio"><?= htmlspecialchars($user['bio'] ?? 'Описание отсутствует') ?></p>
            </div>

            <div class="add-button">
                <a href="/profile?id=<?= $user['uid'] ?>">Хозяин</a>
            </div>

            <div class="posts">
            <h2>Посты</h2>
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                <div class="post">
                    <p><?= htmlspecialchars($post['text']) ?></p>
                    <?php if (!empty($post['photo_url'])): ?>
                    <img src="<?= htmlspecialchars($post['photo_url']) ?>" alt="Изображение в посте">
                    <?php endif; ?>
                    <p class="post-date">Опубликовано: <?= htmlspecialchars($post['datetime']) ?></p>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Пока нет ни одного поста.</p>
            <?php endif; ?>
            </div>
        </div>
    </body>
</html>