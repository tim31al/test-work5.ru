<?php
/** @var array $data */
/** @var bool $isRegister */
/** @var string $error */
?>

<h1>Регистрация</h1>

<?php if ($isRegister): ?>

	<div>
		<p>Вы успешно зарегистрированы</p> | <a href="/">На главную</a>&nbsp;<a href="/login">Вход</a>
	</div>

<?php else: ?>

	<form method="post">
		<div class="field">
			<label for="lastname">Фамилия</label>
			<input type="text" name="lastname" id="lastname" value="<?= htmlspecialchars($data['lastname']) ?>"/>
		</div>

		<div class="field">
			<label for="firstname">Имя</label>
			<input type="text" name="firstname" id="firstname" value="<?= htmlspecialchars($data['firstname']) ?>"/>
		</div>

		<div class="field">
			<label for="email">Email</label>
			<input type="email" name="email" id="email" value="<?= htmlspecialchars($data['email']) ?>"/>
		</div>

		<div class="field">
			<label for="password">Пароль</label>
			<input type="password" name="password" id="password"/>
		</div>

		<div class="field">
			<label></label>
			<input type="submit" value="Отправить"/>
		</div>


	</form>

    <?php if ($error): ?>
		<p class="error"><?= $error ?></p>
    <?php endif; ?>

<?php endif; ?>
