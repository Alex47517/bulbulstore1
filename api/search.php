<?php
require '../send.php';
error_reporting(0);
if (!$_GET['search']) {
	die(json_encode(array('error' => '!$_GET')));
}
$search = array_values(R::getAll("SELECT * FROM `newproducts` WHERE `ad_name` LIKE '%".$_GET['search']."%' AND `disabled` = 0"));
if ($search) {
   for ($i=0; $search[$i]; $i++) { 
      $result[$i]['id'] = $search[$i]['id'];
      $result[$i]['ad_name'] = $search[$i]['ad_name'];
      $result[$i]['url_name'] = $search[$i]['url_name'];
      $result[$i]['sum'] = $search[$i]['sum'];
      $result[$i]['img'] = $search[$i]['img'];
   }
   die(json_encode($result));
} else {
   die(json_encode(array('error' => 'Not found')));
}