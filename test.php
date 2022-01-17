<?php
require 'start.php';
$pr = array_values(R::getAll('SELECT*FROM newproducts'));
for ($i=1; $pr[$i]; $i++) { 
    $p = R::load('newproducts', $pr[$i]['id']);
    $p->disabled = 0;
    R::store($p);
    echo $p['id'].' - ok';
}
//===============================
// function copyPhoto($file_path, $dir = 'products_img') {
//     $file_from_tgrm = $file_path;
//     // достаем расширение файла
//     $k = explode(".", $file_path);
//     $ext = end($k);
//     // назначаем свое имя здесь время_в_секундах.расширение_файла
//     $rand = mt_rand(1, 9999);
//     $name_our_new_file = time()."_".$rand.".".$ext;
//     $result = copy($file_from_tgrm, $dir."/".$name_our_new_file);
//     if ($result) {
//         return $name_our_new_file;
//     } else {
//         return false;
//     }
// //    return error_get_last();
// }
// function translit_sef($value) {
//     $converter = array(
//         'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
//         'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
//         'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
//         'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
//         'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
//         'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
//         'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
//     );
 
//     $value = mb_strtolower($value);
//     $value = strtr($value, $converter);
//     $value = mb_ereg_replace('[^-0-9a-z]', '-', $value);
//     $value = mb_ereg_replace('[-]+', '-', $value);
//     $value = trim($value, '-'); 
 
//     return $value;
// }
// require 'start.php';
//  $pr = array_values(R::getAll('SELECT * FROM products'));
//  for ($i=0; $pr[$i]; $i++) { 
//  	// $p = R::load('products', $pr[$i]['id']);
//  	// $p->url_name = translit_sef($p['ad_name']);
//  	// R::store($p);
//  	$n = R::findOne('newproducts', 'ad_name = ?', array($pr[$i]['ad_name']));
//     if (!$n) {
//         $n = R::dispense('newproducts');
//     }
//  	$n->ad_name = $pr[$i]['ad_name'];
//  	if ($pr[$i] == 'mixers') {
//  		$category = 2;
//  	} elseif ($pr[$i] == 'sinks') {
//  		$category = 4;
//  	} elseif ($pr[$i] == 'siphons') {
//  		$category = 6;
//  	} else {
//  		$category = 2;
//  	}
//  	$n->category = $category;
//  	$n->img = copyPhoto($pr[$i]['img']);
//  	$imgs = explode(' ', $pr[$i]['imgs']);
//     $new_imgs = null;
//  	for ($k=0; $imgs[$k]; $k++) { 
//  		$new_imgs .= copyPhoto($imgs[$k]).' ';
//  	}
//  	$n->imgs = $new_imgs;
//     $n->url_name = translit_sef($pr[$i]['ad_name']);
//  	$n->description = $pr[$i]['description'];
//  	$n->specifications = $pr[$i]['specifications'];
// 	$n->user_id = $pr[$i]['user_id'];
// 	$n->date = $pr[$i]['date'];
// 	$n->sum = $pr[$i]['sum'];
// 	R::store($n);
// 	echo $pr[$i]['id'].' - done!<br>';
//  }
?>