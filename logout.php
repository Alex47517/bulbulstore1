<?php
session_start();
unset($_SESSION['user']);
if ($_GET['riderect'] == 'sign_in') {
	header('Location: /sign-in.php');
}
header('Location: /');
?>