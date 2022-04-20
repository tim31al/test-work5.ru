<?php
/** @var array $user */
?>


<h1>Профиль пользователя</h1>
<p><?= $user['lastname'] . ' ' . $user['firstname'] ?></p>

<a href="/profile?change_data">Редактировать</a>&nbsp;|
<a href="/profile?change_pass">Сменить пароль</a> |
<a href="/logout">Выход</a>

