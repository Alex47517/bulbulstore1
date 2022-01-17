<?php
require '../start.php';
error_reporting(0);
session_start();
if ($_GET['clear'] == true) {
	$_SESSION['cart'] = null;
	die(json_encode(array('result' => 'true')));
}
if (!$_GET['count']) {
	$_GET['count'] = 1;
}
if ($_GET['add']) {
	if (!$_GET['color']) {
		die(json_encode(array('error' => 'undefined color')));
	}
	$product = R::load('newproducts', $_GET['add']);
	if ($product) {
		$add['art'] = $product['id'];
		$add['name'] = $product['ad_name'];
		$add['url_name'] = $product['url_name'];
		$add['img'] = $product['img'];
		$add['sum'] = $product['sum'];
		$add['category'] = $product['category'];
		$add['count'] = $_GET['count'];
		$add['color'] = $_GET['color'];
		$add['type'] = $_GET['type'];
		if (in_array($add, $_SESSION['cart'])) {
			die(json_encode(array('error' => 'the product is already in the cart')));
		}
		if (!$_SESSION['cart']) {
			$_SESSION['cart'][0] = $add;
		} else {
			array_push($_SESSION['cart'], $add);
		}
		die(json_encode(array('result' => 'true')));
	} else {
		die(json_encode(array('error' => 'product does not exist')));
	}
}
if ($_GET['del']) {
	if (!$_SESSION['cart']) {
		die('NULL');
	}
	$k = 0;
	for ($i=0; $_SESSION['cart'][$i]; $i++) { 
		if ($_SESSION['cart'][$i]['art'] == $_GET['del']) {
			$k = $i;
			$m = $i+1;
			$_SESSION['cart'][$i] = $_SESSION['cart'][$m];
		}
		if ($m) {
			$m = $i+1;
			$_SESSION['cart'][$i] = $_SESSION['cart'][$m];
		}
	}
	if (!$m) {
		die(json_encode(array('error' => 'Not found')));
	}
	$_SESSION['cart'] = array_filter($_SESSION['cart']);
	die(json_encode(array('result' => 'true')));
}
if ($_SESSION['cart']) {
	echo json_encode($_SESSION['cart']);
} else {
	die('NULL');
}