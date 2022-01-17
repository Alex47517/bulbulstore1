<?php
require 'rb.php';
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
//БД
R::setup( 'mysql:host=localhost;dbname=u1187552_test', 'u1187552_test', 'zalJfYnUos5b' );
//Токен бота
$token = '1596167108:AAHtyeFTZjCM1QjypWkQ1lTliQqOc53Pqkc';
if (R::load('settings', 1)->value == 1) {
	die('ERR');
}

//для доменов с дефисом функция file_get_contents не работает, обход:

function file_get_contents_curl($url) {
  $ch = curl_init();
  curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
  curl_setopt( $ch, CURLOPT_HEADER, 0 );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt( $ch, CURLOPT_URL, $url );
  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
  $data = curl_exec( $ch );
  curl_close( $ch );
  return $data;
}