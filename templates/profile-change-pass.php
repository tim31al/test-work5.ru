<?php
/** @var array $user */
/** @var string $error */
?>

<form method="post" action="/profile?change_pass">

	<div class="field">
		<label for="password">Пароль</label>
		<input type="password" name="password" id="password"/>
	</div>

	<div class="field">
		<label for="new_password">Новый пароль</label>
		<input type="password" name="new_password" id="new_password"/>
	</div>

	<div class="field">
		<label></label>
		<input type="submit" value="Отправить"/>
	</div>


</form>

<?php if ($error): ?>
	<p class="error"><?= $error ?></p>
<?php endif; ?>

