<!DOCTYPE html>
<html>
    <head>
        <title>Все</title>
        <link rel="stylesheet" href="./styles/profile.css">
        <link rel="stylesheet" href="./styles/header.css">
    </head>
    <body>
        <?php include('header.php'); ?>
        <div class="container">

        <div class="profile">
            <div class="posts">
            <h2>Список <?= $isusers ? 'пользователей' : 'питомцев' ?></h2>
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $info): ?>
                <div class="post"><a href="/<?= $isusers ? 'profile' : 'pet' ?>?id=<?= $isusers ? $info['uid'] : $info['pet_id'] ?>">
                    <h2><?= $isusers ? $info['first_name'] . ' ' . $info['last_name'] : $info['name'] ?></h2>
                </a></div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Пока нет ни одного <?= $isusers ? 'пользователя' : 'питомца' ?>.</p>
            <?php endif; ?>
            </div>
        </div>
    </div>
    </body>
</html>