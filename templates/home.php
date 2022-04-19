<?php ob_start(); ?>

<h1>Home</h1>
<p><?= $message ?></p>

<?php $content = ob_get_clean(); ?>

<?php include 'layout.php' ?>
