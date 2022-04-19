<?php
/** @var string $title */
/** @var string $content */

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title ?></title>
	<style>
		.container {
            width: 80%; margin: 2rem auto;
		}
		form {
			margin-top: 2rem;
		}
		.field {
			margin: 1rem auto;
		}
		.field label {
			display: inline-block;
			width: 10%;
			text-align: right;
			margin-right: .5rem;
		}
	</style>
</head>

<body>
<header class="container" style="display: flex; flex-direction: row; justify-content: space-around">
	<div>
		<a href="/">Главная</a>&nbsp;&nbsp;
		<a href="/profile">Профиль</a>
	</div>
	<div style="display: inline-block; margin-left: auto">
		<a href="/register">Регистрация</a> | <a href="/login">Вход</a>
	</div>


</header>
<div class="container">
	<?= $content ?>
</div>

</body>
</html>
