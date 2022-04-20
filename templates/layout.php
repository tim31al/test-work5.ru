<?php
/** @var string $title */
/** @var string $content */
/** @var ?array $user */

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title ?></title>
	<style>
        .container {
            width: 80%;
            margin: 2rem auto;
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

        .navbar {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .error {
            color: red;
        }
	</style>
</head>

<body>
<header class="container navbar">
	<div>
		<a href="/">Главная</a>&nbsp;&nbsp;
	</div>
    <?php if ($user): ?>
		<div>
			<a href="/profile">
                <?= $user['lastname'] . ' ' . $user['firstname'] ?>
			</a>
		</div>
    <?php else: ?>
		<div class="nav-user">
			<a href="/register">Регистрация</a> | <a href="/login">Вход</a>
		</div>
    <?php endif; ?>


</header>
<div class="container">
    <?= $content ?>
</div>

</body>
</html>
