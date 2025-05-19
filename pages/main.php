<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="./styles/profile.css">
        <link rel="stylesheet" href="./styles/header.css">
        <title>Новости</title>
    </head>
    <body>
        <?php include('header.php'); ?>
        <div class="profile">
            <div class="posts">
            <h2>Последние новости</h2>
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h2><?= $post['name'] ?></h2>
                    <p><?= htmlspecialchars($post['text']) ?></p>
                    <?php if (!empty($post['photo_url'])): ?>
                    <img src="<?= htmlspecialchars($post['photo_url']) ?>" alt="Изображение в посте">
                    <?php endif; ?>
                    <p class="post-date">Опубликовано: <?= htmlspecialchars($post['datetime']) ?></p>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Пока нет новостей.</p>
            <?php endif; ?>
            </div>
        </div>
    </body>
</html>