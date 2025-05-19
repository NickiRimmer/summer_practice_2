<!DOCTYPE html>
<html>
    <head>
        <title>Диалог</title>
        <link rel="stylesheet" href="./styles/dialog.css">
        <link rel="stylesheet" href="./styles/header.css">
    </head>
    <body>
        <?php include('header.php'); ?>
        <div class="dialog">
            <div class="message-list">
            <?php if (empty($messages)): ?>
                <p class="no-messages">Нет сообщений в этом диалоге.</p>
            <?php else: ?>
                <?php foreach ($messages as $message): ?>
                <?php
                $is_outgoing = $message['uid_from'] == $_SESSION['id'];
                $message_class = $is_outgoing ? 'outgoing-message' : 'incoming-message';
                ?>
                <div class="message <?= htmlspecialchars($message_class) ?>">
                    <div class="message-content">
                    <?= htmlspecialchars($message['text']) ?>
                    </div>
                    <div class="message-info">
                    <span class="message-time"><?= htmlspecialchars(date('H:i', strtotime($message['datetime']))) ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
            </div>

            <div class="message-form">
            <form id="send-message-form" action="#" method="post">
                <!---input type="hidden" name="receiver_id" value="<?= htmlspecialchars($other_user_id) ?>"-->
                <textarea id="message" name="message" placeholder="Напишите сообщение..."></textarea>
                <button type="submit">Отправить</button>
            </form>
            </div>
        </div>
    </body>
</html>