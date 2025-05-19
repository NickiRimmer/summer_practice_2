<?php

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Профиль</title>
        <link rel="stylesheet" href="./styles/profile.css">
        <link rel="stylesheet" href="./styles/header.css">
    </head>
    <body>
        <?php include('header.php'); ?>
        <div class="profile">
            <?php if ($isconf): ?>
            <div style="position: absolute; right: 10%;" class="add-button">
                <a href="/edit_profile">Редактировать</a>
            </div>
            <?php else: ?>
            <div style="position: absolute; right: 10%;" class="add-button">
                <a href="/dialog?id=<?= $_GET['id'] ?>">Написать</a>
            </div>
            <?php endif; ?>

            <div class="profile-header">
            <img src="<?= htmlspecialchars($user['photo_url'] ?? '/default_profile.jpg') ?>" alt="Фото профиля" class="profile-photo">
            <h1><?= htmlspecialchars($user['first_name'] ?? 'Имя') ?> <?= htmlspecialchars($user['last_name'] ?? 'Фамилия') ?></h1>
            <p class="bio"><?= htmlspecialchars($user['bio'] ?? 'Описание отсутствует') ?></p>
            </div>
            
            <div class="pets">
                <h2>Питомцы</h2>
                <?php if ($isconf): ?>
                    <div class="add-button">
                        <a href="new_pet">Добавить питомца</a>
                    </div>
                    <div class="add-button">
                        <a href="new_post">Написать пост</a>
                    </div>
                <?php endif; ?>
                <?php if (!empty($pets)): ?>
                <div class="pet-list">
                <?php foreach ($pets as $pet): ?>
                    <div class="pet-card">
                    <a style="display: block; color: black; text-decoration: none;" href="/pet?id=<?= $pet['pet_id'] ?>">
                        <img src="<?= htmlspecialchars($pet['photo_url'] ?? '/default_pet.png') ?>" alt="Фото питомца" class="pet-photo">
                        <h3><?= htmlspecialchars($pet['name']) ?></h3>
                        <p><?= htmlspecialchars($pet['spec']) ?></p>
                        <p><?= htmlspecialchars($pet['bio']) ?></p>
                    </a>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p>Пока нет ни одного питомца.</p>
                
            </div>
            <?php endif; ?>

            <div class="posts">
            <h2>Советы</h2>
            <?php if ($isconf): ?>
                <div class="add-button">
                    <a href="new_tip">Написать совет</a>
                </div>
            <?php endif; ?>
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
                <p>Пока нет ни одного совета.</p>
            <?php endif; ?>
            </div>
        </div>
    </body>
</html>