<?php
/** @var array $user */
?>

<?php ob_start(); ?>

<h1>Профиль пользователя</h1>
<p><?= $user['lastname']. ' ' . $user['firstname'] ?></p>

<?php
//var_dump($user);
//?>

<a href="/profile?change_data">Редактировать</a>&nbsp;
<a href="/profile?change_pass">Сменить пароль</a>

<?php $content = ob_get_clean(); ?>

<?php include 'layout.php' ?>
