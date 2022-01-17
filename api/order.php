<?php
require '../send.php';
error_reporting(0);
session_start();
// die(var_dump($_SESSION));
if (!$_POST['name'] or !$_POST['surname'] or !$_POST['phone'] or !$_POST['city'] or !$_POST['np_number']) {
	die(json_encode(array('error' => '!$_POST')));
}
if (!$_SESSION['cart']) {
	die(json_encode(array('error' => 'No product')));
}
if ($_SESSION['cart']) {
			$k = R::dispense('orders');
			$k->client = $_SESSION['user']['id'];
            for ($m=0; $_SESSION['cart'][$m]; $m++) { 
               if (!$_SESSION['cart'][$m]['color']) {
                  $_SESSION['cart'][$m]['color'] = 'Не указан';
               }
               if (!$_SESSION['cart'][$m]['type']) {
                  $_SESSION['cart'][$m]['type'] = 'Не указан';
               }
               if (!$_SESSION['cart'][$m]['count']) {
                  $_SESSION['cart'][$m]['count'] = 1;
               }
               $arts .= $_SESSION['cart'][$m]['art'].', ';
               $k->products .= $_SESSION['cart'][$m]['art'].':'.$_SESSION['cart'][$m]['count'].';';
               $links .= 'https://bulbulstore.com.ua/product.php?art='.$_SESSION['cart'][$m]['art'].'
Цвет/тип/к-во: '.$_SESSION['cart'][$m]['color'].'/'.$_SESSION['cart'][$m]['type'].'/'.$_SESSION['cart'][$m]['count'].'
';
            }
            $k->confirmed = null;
            R::store($k);
         }
         if (!$links) {
         	die(json_encode(array('error' => '!$links')));
         }
$lst = R::findLast('users')->id;
$kb[0][0]['text'] = '✅ Подтвердить';
$kb[0][0]['callback_data'] = 'confirm:'.$k['id'];
for ($i=1; $i <= $lst ; $i++) {
	$user = R::load('users', $i); 
	inline_keyboard('🔔 <b>Новый заказ!</b>
<b>Имя, фамилия: </b>'.$_POST['name'].' '.$_POST['surname'].'
<b>Телефон: </b>'.$_POST['phone'].'
<b>Город: </b>'.$_POST['city'].'
<b>№ НП: </b>'.$_POST['np_number'].'

'.$links.'', $kb, $user['user_id']);
}
die(json_encode(array('result' => 'true')));
header('Location: ../success.php');