<?php
require '../send.php';
error_reporting(0);
if ($_GET['call']) {
$lst = R::findLast('users')->id;
for ($i=1; $i <= $lst; $i++) {
	$user = R::load('users', $i); 
	send('📲 <b>Клиент запросил звонок!</b>

<b>Телефон: </b>'.$_GET['call'].'', $user['user_id']);
}
die(json_encode(array('result' => 'true')));
} else {
	die(json_encode(array('error' => '!$_GET')));
}