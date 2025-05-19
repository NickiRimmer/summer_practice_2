<header>
    <h1>Социальная сеть домашних животных</h1>
    <nav>
        <ul>
            <li><a href="main">Главная</a></li>
            <li><a href="users">Пользователи</a></li>
            <li><a href="pets">Питомцы</a></li>

            <?php if(isset($_COOKIE['PHPSESSID'])): ?>
            <li><a href="my_profile">Профиль</a></li>
            <li><a href="dialogs">Сообщения</a></li>
            <li><a href="logout">Выйти</a></li>

            <?php else: ?>
            <li><a href="login">Войти</a></li>
            <li><a href="register">Регистрация</a></li>

            <?php endif; ?>
        </ul>
    </nav>
</header>