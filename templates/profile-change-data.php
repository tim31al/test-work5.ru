<?php
/** @var array $user */
/** @var string $error  */
?>

<form method="post" action="/profile?change_data">

    	<div class="field">
		<label for="lastname">Фамилия</label>
		<input type="text" name="lastname" id="lastname" value="<?= htmlspecialchars($user['lastname']) ?>"/>
	</div>

	<div class="field">
		<label for="firstname">Имя</label>
		<input type="text" name="firstname" id="firstname" value="<?= htmlspecialchars($user['firstname']) ?>"/>
	</div>

	<div class="field">
		<label></label>
		<input type="submit" value="Отправить"/>
	</div>


</form>

<?php if($error): ?>
<p class="error"><?= $error ?></p>
<?php endif; ?>
