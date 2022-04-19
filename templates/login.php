<?php
/** @var array $data */
/** @var string $error */
?>
<?php ob_start(); ?>

<h1>Вход</h1>


<form method="post">
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
	<p style="color: red"><?= $error ?></p>
<?php endif; ?>



<?php $content = ob_get_clean(); ?>

<?php include 'layout.php' ?>
