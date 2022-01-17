<?php
require 'start.php';
//===
$request_json = file_get_contents('php://input');
$request = json_decode($request_json);
$user_id = $request->message->from->id;
$chat_id = $request->message->chat->id;
$msg_id = $request->message->message_id;
if ($request->callback_query->from->id) {
$user_id = $request->callback_query->from->id;
$chat_id = $request->callback_query->message->chat->id;
$payload = $request->callback_query->data;
}
if (!$user_id) {
die();
}
$msg = $request->message->text;
$cmd = explode(' ', $msg);
// if ($msg) {
//  send('ЭРОРР $'); die();
// }
$user = R::findOne('users', 'user_id = ?', array($user_id));
if ($cmd[0] == '!chat' or $cmd[0] == '/chat' or $cmd[1] == '!chat') {
send($chat_id, false, true);
}
//if ($chat_id == $admin_chat) {
//}
if ($user) {
if ($cmd[0] == '/start' or $cmd[0] == '/cancel' or $msg == '❌ Отмена' or $msg == '🏠 Главное меню') {
$user->display = null;
R::store($user);
$pr = array_values(R::getAll('SELECT * FROM newproducts WHERE old_sum AND disabled = 0'));
$txt = '🏠 <b>Буль-Буль</b> ADMIN
🆔 ID: '.$user['id'].'
🎯 Telegram ID: <code>'.$user_id.'</code>
📚 <b>Товар:</b>
Активно: <b>'.count(array_values(R::getAll('SELECT * FROM `newproducts` WHERE `disabled` = ?', [0]))).'</b>
Всего: <b>'.R::count('newproducts').'</b>
';
keyboard_home('👋');
$keyboard = array(array(
array(
'text' => '➕ Добавить товар',
'callback_data' => 'btn1'
)
),
array(
array(
'text' => '🔧 Управление товаром',
'callback_data' => 'btn2'
)
),
array(
array(
'text' => '🔧 Управление категориями',
'callback_data' => 'btn3'
)
),
array(
array(
'text' => '⭐ Загрузить отзывы',
'callback_data' => 'btn4'
)
)
);
inline_keyboard($txt, $keyboard);
if (!$pr[2]) {
    send('⚠ <b>Блок акций на главной странице скрыт</b>
Добавьте акции хотя-бы на 3 товара для активации блока
<b>Сейчас активно акций: '.count($pr).'</b>');
}
die();
} elseif ($cmd[0] == '!клавиатура') {
keyboardRemove('✅ Клавиатура убрана');
}
//displays
if ($user['display'] == 'youtube') {
    send('$user[display] == youtube');
    $ad = R::load('newproducts', $user['tmp']);
    if (stristr($msg, 'youtu.be')) {
        $k = end(explode('/', $msg));
    } elseif (stristr($msg, 'youtube.com/')) {
        $k = explode('v=', $msg)[1];
        if (stristr($msg, '&')) {
            $k = explode('&', $k)[0];
        }
    } else {
        send('♨ Отправьте ссылку на youtube видео'); die();
    }
    send(var_export($k, true));
    $ad->video = $k;
    send('R::store');
    R::store($ad);
    send('done!');
    $user->display = null;
    $user->tmp = null;
    R::store($user);
    send('✅ Видео добавлено!'); die();
}
if (($user['display'] == 'red_category' or $user['display'] == 'red_category1') && $payload) {
    $childcategorys = array_values(R::getAll('SELECT * FROM childcategorys WHERE father = '.$payload));
    if ($payload == 'clear') {
        $payload = null;
    }
    if ($childcategorys && $user['display'] == 'red_category') {
        $user->display = 'red_category1';
        $user->tmp .= ':'.$payload.'';
        R::store($user);
        for ($i=0; $childcategorys[$i]; $i++) { 
            $keyboard[$i][0]['text'] = '🗂 '.$childcategorys[$i]['name'];
            $keyboard[$i][0]['callback_data'] = $childcategorys[$i]['id'];
        }
        $keyboard[$i][0]['text'] = 'Пропустить ➡';
        $keyboard[$i][0]['callback_data'] = 'clear';
        inline_keyboard('🔸 <b>Выберите подкатегорию</b>', $keyboard); die();
    }
    $product = R::load('newproducts', explode(':', $user['tmp'])[0]);
    if (!explode(':', $user['tmp'])[1]) {
        $product->category = $payload;
    } else {
        $product->category = explode(':', $user['tmp'])[1];
        $product->childcategory = $payload;
    }
    R::store($product);
    $user->display = null;
    $user->tmp = null;
    R::store($user);
    keyboard_home('✅ Товар перемещен в новую категорию'); die();
}
if ($user['display'] == 'new_childcategory' && $msg) {
    $category = R::load('categorys', $user['tmp']);
    if ($category) {
        $childcategory = R::dispense('childcategorys');
        $childcategory->name = $msg;
        $childcategory->url_name = translit_sef($msg);
        $childcategory->father = $user['tmp'];
        R::store($childcategory);
        $user->display = null;
        $user->tmp = null;
        R::store($user);
        keyboard_home('✅ Новая подкатегория <b>'.$msg.'</b> была создана внутри категории <b>'.$category['name'].'</b>'); die();
    }
} elseif ($user['display'] == 'reviews') {
    if (array_key_exists('photo', $request->message) or array_key_exists('document', $request->message)) {
        // send('⏳ Обработка изображения...');
        // если пришла картинка то сохраняем ее у себя
        if (!$request->message->photo) {
            $photo = $request->message->document;
            $file_id = $photo->file_id;
        } else {
            $photo = $request->message->photo;
            $file_id = $photo[(count($photo) - 1)]->file_id;
        }
        $rs = copyPhoto(json_decode(api(['file_id' => $file_id], "getFile"), TRUE)['result']['file_path'], 'reviews');
        // send(var_export($rs, true));
        // $rs = getPhoto($photo);
        if ($rs) {
            $photo = R::dispense('reviews');
            $photo->img = $rs;
            R::store($photo);
            $count = R::count('reviews');
            send('✅ <b>Отзыв загружен!</b>
Всего загружено отзывов: '.$count.'');
            die();
        }
    } else {
        send('♨ <b>Отправьте изображение!</b>
Пишите /cancel для отмены'); die();
    }
} elseif ($user['display'] == 'new_category1' && $msg) {
    $user->tmp = $msg;
    $user->display = 'new_category2';
    R::store($user);
    send('🔸 <b>Отправьте изображение-миниатюру для категории</b>');
} elseif ($user['display'] == 'red_action' && $msg) {
    if (!is_numeric($msg)) {
        send('♨ <b>Введите число!</b>
Пишите /cancel для отмены'); die();
    } else {
        $product = R::load('newproducts', $user['tmp']);
        if (!$product) {
            $user->display = null;
            R::store($user);
            keyboard_home('♨ <b>Товар с идентификатором '.$user['tmp'].' не найден</b>'); die();
        } else {
            if ($msg > $product['sum']) {
                send('♨ Акционная цена не может быть выше реальной ('.$product['sum'].' грн)
Пишите /cancel для отмены'); die();
            }
            $product->old_sum = $product['sum'];
            $product->sum = $msg;
            R::store($product);
            $user->display = null;
            $user->tmp = null;
            R::store($user);
            keyboard_home('✅ Установлена скидка <b>'.($product['old_sum'] - $msg).' грн ('.round((($product['old_sum'] - $msg)*100)/$product['old_sum']).'%)</b> на товар <b>'.$product['ad_name'].'</b>'); die();
        }
    }
} elseif ($user['display'] == 'red_price' && $msg) {
    if (!is_numeric($msg)) {
        send('♨ <b>Введите число!</b>
Пишите /cancel для отмены'); die();
    } else {
        $product = R::load('newproducts', $user['tmp']);
        if (!$product) {
            $user->display = null;
            R::store($user);
            keyboard_home('♨ <b>Товар с идентификатором '.$user['tmp'].' не найден</b>'); die();
        } else {
            $product->old_sum = null;
            $product->sum = $msg;
            R::store($product);
            $user->display = null;
            $user->tmp = null;
            R::store($user);
            keyboard_home('✅ Установлена цена <b>'.$msg.' грн.</b> на товар <b>'.$product['ad_name'].'</b>'); die();
        }
    }
} elseif ($user['display'] == 'new_category2') {
    if (array_key_exists('photo', $request->message)) {
        send('⏳ Обработка изображения...');
        // если пришла картинка то сохраняем ее у себя
        $rs = getPhoto($request->message->photo, 'images');
        if (!$rs) {
            send('❌ Произошла ошибка при загрузке фотографии'); die();
            // die();
        }
    } else {
        send('Отправьте изображение! (Используйте сжатие)'); die();
    }
    $category = R::dispense('categorys');
    $category->name = $user['tmp'];
    $category->url_name = translit_sef($user['tmp']);
    $category->img = $rs;
    R::store($category);
    $user->display = null;
    $user->tmp = null;
    R::store($user);
    keyboard_home('✅ Категория <b>'.$category['name'].'</b> создана!');
} elseif ($user['display'] == 'link1' && $msg) {
$user->display = 'link2';
$user->tmp = $msg.';@';
R::store($user);
send('🔸 <b>Отправьте главное изображение товара</b>'); die();
} elseif ($user['display'] == 'link2') {
    if (array_key_exists('photo', $request->message)) {
        send('⏳ Обработка изображения...');
        // если пришла картинка то сохраняем ее у себя
        $rs = getPhoto($request->message->photo);
        if ($rs) {
            send('✅ Успешно!');
            // die();
        }
    } else {
        send('Отправьте изображение!'); die();
    }
$user->display = 'link3';
$user->tmp .= $rs.';@';
R::store($user);
send('🔸 <b>Введите стоимость товара</b>'); die();
} elseif ($user['display'] == 'link3' && $msg) {
$user->display = 'link4';
$user->tmp .= $msg.';@';
R::store($user);
send('🔸 <b>Загрузите изображения товара, после чего напишите: </b><code>готово</code>
<em>Для вставки видео вставьте ссылку с youtube</em>'); die();
} elseif ($user['display'] == 'link4') {
    // send(var_export($request->message, true));
    if (array_key_exists('photo', $request->message) or array_key_exists('document', $request->message)) {
        // send('⏳ Обработка изображения...');
        // если пришла картинка то сохраняем ее у себя
        if (!$request->message->photo) {
            $photo = $request->message->document;
            $file_id = $photo->file_id;
        } else {
            $photo = $request->message->photo;
            $file_id = $photo[(count($photo) - 1)]->file_id;
        }
        $rs = copyPhoto(json_decode(api(['file_id' => $file_id], "getFile"), TRUE)['result']['file_path']);
        // $rs = getPhoto($photo);
        if ($rs) {
            $user = R::load('users', $user['id']);
            $user->tmp .= $rs.' ';
            R::store($user);
            $count = count(explode(' ', end(explode(';@', $user['tmp']))))-1;
            send('✅ <b>Загружено изображений: '.$count.'</b>
Если это все, напишите: <code>готово</code>');
            die();
        }
    } else {
        if ($cmd[0] == 'готово' or $cmd[0] == 'Готово') {
            if ((count(explode(' ', end(explode(';@', $user['tmp']))))-1) == 0) {
                send('♨ Загрузите хотя-бы одно изображение'); die();
            }
            $user->tmp .= ';@';
            $user->display = 'link5';
            R::store($user);
            send('🔸 <b>Отправьте ссылку на видео-обзор товара на youtube, для пропуска напишите </b><code>пропуск</code>'); die();
        } else {
            if (stristr($msg, 'youtu.be')) {
                $k = end(explode('/', $msg));
                $user = R::load('users', $user['id']);
                $user->tmp .= 'video$'.$k.' ';
                R::store($user);
                send('✅ <b>Видео добавлено!</b>
Если это все, напишите: <code>готово</code>');
                die();
            } elseif (stristr($msg, 'youtube.com/')) {
                $k = explode('v=', $msg)[1];
                if (stristr($msg, '&')) {
                    $k = explode('&', $k)[0];
                }
                $user = R::load('users', $user['id']);
                $user->tmp .= 'video$'.$k.' ';
                R::store($user);
                send('✅ <b>Видео добавлено!</b>
Если это все, напишите: <code>готово</code>');
                die();
            }
            // if () {
                
            // }
            send('Отправьте изображение!'); die();
        } 
    }
    send(var_export($request, true)); die();
} elseif ($user['display'] == 'link5' && $msg) {
	if (stristr($msg, 'youtu.be')) {
        $k = end(explode('/', $msg));
        $user = R::load('users', $user['id']);
        $user->tmp .= ''.$k.';@';
        $user->display = 'link6';
        R::store($user);
        send('✅ <b>Видео добавлено!</b>');
        die();
    } elseif (stristr($msg, 'youtube.com/')) {
        $k = explode('v=', $msg)[1];
        if (stristr($msg, '&')) {
            $k = explode('&', $k)[0];
        }
        $user = R::load('users', $user['id']);
        $user->tmp .= ''.$k.';@';
        $user->display = 'link6';
        R::store($user);
        send('🔸 <b>Введите описание товара</b>'); die();
    } else {
    	if ($msg == 'пропуск' or $msg == 'Пропуск') {
    		$user->tmp .= ';@';
        	$user->display = 'link6';
        	R::store($user);
        	send('🔸 <b>Введите описание товара</b>'); die();
    	}
    }
} elseif ($user['display'] == 'link6' && $msg) {
$kk = str_replace(PHP_EOL, '<br>',$msg);
$user->display = 'category';
$user->tmp .= $kk.';@';
R::store($user);
$category = array_values(R::getAll('SELECT * FROM categorys'));
for ($i=0; $category[$i]; $i++) { 
    $keyboard[$i][0]['text'] = '📁 '.$category[$i]['name'];
    $keyboard[$i][0]['callback_data'] = $category[$i]['id'];
}
inline_keyboard('🔸 <b>Выберите категорию</b>', $keyboard); die();
} elseif ($user['display'] == 'link7' && $msg) {
$user->display = '';
$ad = R::dispense('newproducts');
// $id = mt_rand(99999999, 999999999999);
//На случай, если выпадет повторно такое же число
// while (R::findOne('products', 'id = ?', array($id))) {
// $id = mt_rand(99999999, 999999999999);
// }
$tmp = explode(';@', $user['tmp']);
$category = explode('|', $tmp[6])[0];
$type = explode('|', $tmp[6])[1];
// $ad->id = $id;
$ad->category = $category;
$ad->childcategory = $tmp[7];
$ad->url_name = translit_sef($tmp[0]);
$ad->type = $type;
$ad->ad_name = $tmp[0];
$ad->img = $tmp[1];
$ad->sum = $tmp[2];
$ad->imgs = $tmp[3];
$ad->video = $tmp[4];
$ad->description = $tmp[5];
$ad->specifications = $msg;
$ad->user_id = $user_id;
$ad->date = date(U);
$ad->disabled = 0;
R::store($ad);
R::store($user);
$keyboard = array(array(array(
'text' => '🏠 Меню',
'callback_data' => 'menu'
)));
keyboard_home('✅ <b>Товар добавлен!</b>

🆔 <b>ID/артикул:</b> '.$ad['id'].'
🔗 <b>URL:</b> https://new.instabul.net/product.php?name='.$ad['url_name']); die();
}
if (explode(':', $payload)[0] == 'confirm') {
    $order = R::load('orders', explode(':', $payload)[1]);
    $order->confirmed = 1;
    R::store($order);
    $prod = explode(';', $order['products']);
    for ($i=0; $prod[$i]; $i++) { 
        $pr = explode(':', $prod[$i])[0];
        $pr_count = explode(':', $prod[$i])[1];
        $product = R::load('newproducts', $pr);
        for ($m=0; $m < $pr_count; $m++) { 
            $pur = R::dispense('purchases');
            $pur->product = $pr;
            $pur->client = $order['client'];
            $pur->sum = $product['sum'];
            $pur->date = date('d.m.y');
            R::store($pur);
        }
    }
    send('✅ <b>Запрос на заказ №'.$order['id'].' подтвержден</b>');
}
if ($payload && ($user['display'] == 'category' or $user['display'] == 'category1')) {
    $childcategorys = array_values(R::getAll('SELECT * FROM childcategorys WHERE father = '.$payload));
    if ($payload == 'clear') {
        $payload = null;
    }
    if ($childcategorys && $user['display'] == 'category') {
        $user->display = 'category1';
        $user->tmp .= $payload.';@';
        R::store($user);
        for ($i=0; $childcategorys[$i]; $i++) { 
            $keyboard[$i][0]['text'] = '🗂 '.$childcategorys[$i]['name'];
            $keyboard[$i][0]['callback_data'] = $childcategorys[$i]['id'];
        }
        $keyboard[$i][0]['text'] = 'Пропустить ➡';
        $keyboard[$i][0]['callback_data'] = 'clear';
        inline_keyboard('🔸 <b>Выберите подкатегорию</b>', $keyboard); die();
    }
    // if ($payload == 'sinks' && $user['display'] == 'category') {
    //     $user->tmp .= $payload.'|';
    //     $user->display = 'category1';
    //     R::store($user);
    //     $keyboard[0][0]['text'] = '✅ Да';
    //     $keyboard[0][0]['callback_data'] = 'true';
    //     $keyboard[0][1]['text'] = '❌ Нет';
    //     $keyboard[0][1]['callback_data'] = 'false';
    //     inline_keyboard('🔸 <b>Добавить выбор типа крыла?</b>', $keyboard); die();
    // }
    $user->tmp .= $payload.';@';
    $user->display = 'link7';
    R::store($user);
    send('🔸 <b>Введите характеристики товара</b>
Пример: <em>Тип:швейная;Управление:Электромеханическое;Тип челнока:Качающийся;Количество строчек:21;Количество видов петель:1;</em>
<b>НЕ ставьте пробелы между делиметрами</b>'); die();
}
if ($payload or $msg == '➕ Добавить товар' or $msg == '🔧 Управление товаром' or $msg == '🏠 Главное меню' or $msg == '🔧 Управление категориями' or $msg == '⭐ Загрузить отзывы') {
    if ($payload == 'menu' or $msg == '👤 Профиль') {
    $cmd[0] = '/start';
    }
    if ($payload == 'btn1' or $msg == '➕ Добавить товар') {
    keyboard_cancel('➕ <b>Добавление товара</b>
Для выхода в главное меню - /start
🔸 <b>Введите название товара</b>');
    $user->display = 'link1';
    $user->tmp = '';
    R::store($user);
    die();
    } elseif ($payload == 'btn2' or $msg == '🔧 Управление товаром') {
    $txt = '🔧 <b>Управление товаром</b>';
    $keyboard = array(array(
    array(
    'text' => '📄 Активный товар',
    'callback_data' => 'btn2_1'
    )
    ),
    array(
    array(
    'text' => '🗑 Архив',
    'callback_data' => 'btn2_2'
    )
    )
    );
    inline_keyboard($txt, $keyboard);
    die();
    } elseif ($payload == 'btn3' or $msg == '🔧 Управление категориями') {
    $txt = '🔧 <b>Управление категориями</b>';
    $category = array_values(R::getAll('SELECT * FROM categorys'));
    for ($i=0; $category[$i]; $i++) { 
        $keyboard[$i][0]['text'] = '📁 '.$category[$i]['name'];
        $keyboard[$i][0]['callback_data'] = 'category:'.$category[$i]['id'];
    }
    $keyboard[$i][0]['text'] = '➕ Создать категорию';
    $keyboard[$i][0]['callback_data'] = 'new_category';
    inline_keyboard($txt, $keyboard);
    die();
    } elseif ($payload == 'btn4' or $msg == '⭐ Загрузить отзывы') {
    $keyboard[0][0]['text'] = '🏠 Главное меню';
    $user->display = 'reviews';
    R::store($user);
    keyboard('⭐ <b>Загрузить отзывы</b>
Отправляйте скриншоты отзывов, после чего нажмите "Главное меню"', $keyboard);
    die();
    } elseif (explode(':', $payload)[0] == 'category') {
        $category = R::load('categorys', explode(':', $payload)[1]);
        if ($category) {
        	$childs = array_values(R::getAll('SELECT * FROM childcategorys WHERE father = '.$category['id']));
        	for ($i=0; $childs[$i]; $i++) { 
        		$keyboard[$i][0]['text'] = '🗂 '.$childs[$i]['name'];
        		$keyboard[$i][0]['callback_data'] = 'childcategory:'.$childs[$i]['id'];
        	}
            $keyboard[$i][0]['text'] = '➕ Создать подкатегорию';
            $keyboard[$i][0]['callback_data'] = 'add_childcategory:'.$category['id'];
            $keyboard[($i+1)][0]['text'] = '🗑 Удалить';
            $keyboard[($i+1)][0]['callback_data'] = 'category_delete:'.$category['id'];
            $txt = '❓ Что хотите сделать с категорией <b>'.$category['name'].'</b>?';
            inline_keyboard($txt, $keyboard); die();
        } else {
            send('Not Find'); die();
        }
    } elseif (explode(':', $payload)[0] == 'add_childcategory') {
            $user->display = 'new_childcategory';
            $user->tmp = explode(':', $payload)[1];
            R::store($user);
            keyboard_cancel('📝 <b>Введите название новой подкатегории</b>'); die();
    } elseif (explode(':', $payload)[0] == 'category_delete') {
        $category = R::load('categorys', explode(':', $payload)[1]);
        if ($category) {
            $keyboard[0][0]['text'] = '✅ Удалить';
            $keyboard[0][0]['callback_data'] = 'del_category:'.$category['id'];
            $keyboard[1][0]['text'] = '❎ Отмена';
            $keyboard[1][0]['callback_data'] = 'cancel';
            $txt = '🗑 Вы действительно хотите <b>удалить</b> категорию <b>'.$category['name'].'</b>?
⚠ <b>Это действие удалит все товары из этой категории</b>';
            inline_keyboard($txt, $keyboard); die();
        }
    } elseif (explode(':', $payload)[0] == 'childcategory') {
        $category = R::load('childcategorys', explode(':', $payload)[1]);
        if ($category) {
            $keyboard[0][0]['text'] = '✅ Удалить';
            $keyboard[0][0]['callback_data'] = 'del_childcategory:'.$category['id'];
            $keyboard[1][0]['text'] = '❎ Отмена';
            $keyboard[1][0]['callback_data'] = 'cancel';
            $txt = '🗑 Вы действительно хотите <b>удалить</b> подкатегорию <b>'.$category['name'].'</b>?
⚠ <b>Это действие удалит все товары из этой подкатегории</b>';
            inline_keyboard($txt, $keyboard); die();
        }
    } elseif (explode(':', $payload)[0] == 'del_childcategory') { 
        $category = R::load('childcategorys', explode(':', $payload)[1]);
        if ($category) {
            $cat = $category['name'];
            $products = array_values(R::getAll('SELECT * FROM newproducts WHERE childcategory = '.$category['id']));
            for ($i=0; $products[$i]; $i++) { 
                $p = R::load('newproducts', $products[$i]['id']);
                R::trash($p);
            }
            R::trash($category);
            keyboard_home('✅ Подкатегория <b>'.$cat.'</b> и ее содержимое удалены'); die();
        } else {
            send('Not Find'); die();
        }
    } elseif ($payload == 'new_category') {
            $user->display = 'new_category1';
            R::store($user);
            keyboard_cancel('📝 <b>Введите название новой категории</b>'); die();
    } elseif (explode(':', $payload)[0] == 'del_category') { 
        $category = R::load('categorys', explode(':', $payload)[1]);
        if ($category) {
            $cat = $category['name'];
            $products = array_values(R::getAll('SELECT * FROM newproducts WHERE category = '.$category['id']));
            for ($i=0; $products[$i]; $i++) { 
                $p = R::load('newproducts', $products[$i]['id']);
                R::trash($p);
            }
            R::trash($category);
            keyboard_home('✅ Категория <b>'.$cat.'</b> и ее содержимое удалены'); die();
        } else {
            send('Not Find'); die();
        }
    } elseif ($payload == 'cancel') { 
        keyboard_home('✅ Действие отменено!'); 
    } elseif ($payload == 'btn2_1') {
        $category = array_values(R::getAll('SELECT * FROM categorys'));
        for ($i=0; $category[$i]; $i++) { 
            $keyboard[$i][0]['text'] = '📁 '.$category[$i]['name'];
            $keyboard[$i][0]['callback_data'] = 'btn2_1:'.$category[$i]['id'];
        }
        if ($i == 0) {
            send('❌ На сайте отсуцтвуют категории => товары.
Создайте новую категорию в разделе "Управление категориями"'); die();
        }
        inline_keyboard('🔸 <b>Выберите категорию для просмотра активного товара</b>', $keyboard); die();
    } elseif (explode(':', $payload)[0] == 'btn2_1') {
    $products = array_values(R::getAll('SELECT * FROM `newproducts` WHERE `disabled` != 1 AND category = '.explode(':', $payload)[1], [0]));
    $category = R::load('categorys', explode(':', $payload)[1]);
    $all = count($products);
    if ($all == 0) {
    send('♨ В категории <b>'.$category['name'].'</b> нет товаров'); die();
    }
    send('📚 <b>Активный товар в категории "'.$category['name'].'":</b>');
    for ($i=0; $i < $all; $i++) {
    $txt = '📋 <em>'.$products[$i]['ad_name'].'</em> - <b>'.$products[$i]['sum'].' грн.</b>';
    $keyboard = array(array(
    array(
    'text' => 'ℹ Инфо',
    'callback_data' => 'info:'.$products[$i]['id']
    )
    )
    );
    inline_keyboard($txt, $keyboard);
    }
    die();
    } elseif (explode(':', $payload)[0] == 'info') {
    $ad = R::load('newproducts', explode(':', $payload)[1]);
    if (!$ad) {
    send('❌ Товар не найден'); die();
    }
    $orders = array_values(R::getAll('SELECT * FROM purchases WHERE product = '.$ad['id'].''));
    $txt = '📋 <b>Информация о товаре</b>
🔸 <em>'.$ad['ad_name'].'</em>
💰 Цена: <b>'.$ad['sum'].'</b> грн.
🔗 <b>ID: </b><code>'.$ad['id'].'</code>
📬 <b>Заказов: </b><code>'.count($orders).'</code>';
    $keyboard[0][0]['text'] = '✏ Редактировать';
    $keyboard[0][0]['callback_data'] = 'red:'.$ad['id'];
    $keyboard[1][0]['text'] = '🗑 Деактивировать';
    $keyboard[1][0]['callback_data'] = 'disable:'.$ad['id'];
    inline_keyboard($txt, $keyboard); die();
    } elseif ($payload == 'btn2_2') {
    $products = array_values(R::getAll('SELECT * FROM `products` WHERE `disabled` = ?', [1]));
    $all = count($products);
    if ($all == 0) {
    send('♨ Архив пуст'); die();
    }
    send('🗑 <b>Архив:</b>');
    for ($i=0; $i < $all; $i++) {
    $txt = '📋 <em>'.$products[$i]['ad_name'].'</em> - <b>'.$products[$i]['sum'].' руб.</b>';
    $keyboard = array(array(
    array(
    'text' => 'ℹ Подробнее',
    'callback_data' => 'info1:'.$products[$i]['id']
    )
    ),
    array(
    array(
    'text' => '⚡ Активировать',
    'callback_data' => 'enable:'.$products[$i]['id']
    )
    ),
    array(
    array(
    'text' => '❌ Удалить',
    'callback_data' => 'delete:'.$products[$i]['id']
    )
    )
    );
    inline_keyboard($txt, $keyboard);
    }
    die();
    }
    $exp_payload = explode(':', $payload);
    if ($exp_payload[0] == 'disable') {
    $ad = R::load('newproducts', $exp_payload[1]);
    if ($ad['id']) {
    $ad->disabled = 1;
    R::store($ad);
    send('✅ Товар <b>'.$ad['ad_name'].'</b> деактивирован и перенесен в архив'); die();
    } else {
    send('❌ Товар не найден'); die();
    }
    } elseif ($exp_payload[0] == 'red') {
    if ($exp_payload[1] == 'youtube') {
        $ad = R::load('newproducts', $exp_payload[2]);
        $user->display = 'youtube';
        $user->tmp = $ad['id'];
        send('🎥 <b>Вставьте ссылку на видео (youtube)</b>'); die();
    }
    if ($exp_payload[1] == 'category') {
        $user->display = 'red_category';
        $user->tmp = $exp_payload[2];
        R::store($user);
        $category = array_values(R::getAll('SELECT * FROM categorys'));
        for ($i=0; $category[$i]; $i++) { 
            $keyboard[$i][0]['text'] = '📁 '.$category[$i]['name'];
            $keyboard[$i][0]['callback_data'] = $category[$i]['id'];
        }
        inline_keyboard('🔸 <b>Выберите категорию</b>', $keyboard); die();
    }
    if ($exp_payload[1] == 'price') {
        $user->display = 'red_price';
        $user->tmp = $exp_payload[2];
        R::store($user);
        $ad = R::load('newproducts', $exp_payload[2]);
        send('📝 Введите новую цену для товара <b>'.$ad['ad_name'].'</b>
📏 Цена сейчас: '.$ad['sum'].' грн.
[i] Пишите /cancel для отмены'); die();
    } elseif ($exp_payload[1] == 'action') {
        if ($exp_payload[2] == 'delete') {
            $ad = R::load('newproducts', $exp_payload[3]);
            $ad->sum = $ad['old_sum'];
            $ad->old_sum = null;
            R::store($ad);
            send('✅ Акция на товар <b>'.$ad['ad_name'].'</b> удалена!
Его цена сейчас: '.$ad['sum'].''); die();
        }
        $ad = R::load('newproducts', $exp_payload[2]);
        $user->display = 'red_action';
        $user->tmp = $exp_payload[2];
        R::store($user);
        send('📝 Введите акционную цену для товара <b>'.$ad['ad_name'].'</b>
📏 Цена без акции: '.$ad['sum'].' грн.
[i] Пишите /cancel для отмены'); die();
    }
    $ad = R::load('newproducts', $exp_payload[1]);
    if ($ad['id']) {
    $keyboard[0][0]['text'] = '📈 Редактировать цену';
    $keyboard[0][0]['callback_data'] = 'red:price:'.$ad['id'];
    $keyboard[1][0]['text'] = '📨 Сменить категорию';
    $keyboard[1][0]['callback_data'] = 'red:category:'.$ad['id'];
    if ($ad['old_sum']) {
        $keyboard[2][0]['text'] = '♨ Отключить акцию';
        $keyboard[2][0]['callback_data'] = 'red:action:delete:'.$ad['id'];
    } else {
        $keyboard[2][0]['text'] = '🎉 Настроить акцию';
        $keyboard[2][0]['callback_data'] = 'red:action:'.$ad['id'];
    }
    $keyboard[3][0]['text'] = '🎥 Сменить видео-обзор';
    $keyboard[3][0]['callback_data'] = 'red:youtube:'.$ad['id'];
    $orders = array_values(R::getAll('SELECT * FROM purchases WHERE product = '.$ad['id'].''));
    inline_keyboard('📝 Редактирование товара <b>'.$ad['ad_name'].'</b>
🆔 Артикул: '.$ad['id'].'
📏 Цена: '.$ad['sum'].' грн.
📬 Заказов: '.count($orders), $keyboard); die();
    } else {
    send('❌ Товар не найден'); die();
    }
    } elseif ($exp_payload[0] == 'info1') {
        $ad = R::load('newproducts', $exp_payload[1]);
        $txt = '🗑 <b>Товар</b> <code>'.$ad['id'].'</code>
🔸 <em>'.$ad['ad_name'].'</em>
💰 Цена: <b>'.$ad['sum'].'</b> грн.';
        $keyboard = array(array(
        array(
        'text' => '⚡ Активировать',
        'callback_data' => 'enable:'.$ad['id']
        )
        ),
        array(
        array(
        'text' => '❌ Удалить',
        'callback_data' => 'delete:'.$ad['id']
        )
        )
        );
        inline_keyboard($txt, $keyboard);
    } elseif ($exp_payload[0] == 'enable') {
    $aka_domen = R::load('settings', 1)->value;
    $ad = R::load('newproducts', $exp_payload[1]);
    if ($ad) {
    $ad->disabled = 0;
    R::store($ad);
    send('✅ Товар <b>'.$ad['ad_name'].'</b> активирован!
🔗 <b>Артикул: </b><code>'.$ad['id'].'</code>'); die();
    } else {
    send('❌ Товар не найдено'); die();
    }
    } elseif ($exp_payload[0] == 'delete') {
    $ad = R::load('newproducts', $exp_payload[1]);
    if ($ad && $ad['id'] != 0) {
    R::trash($ad);
    send('✅ Товар <b>'.$ad['ad_name'].'</b> полностью удален');
    die();
    } else {
    send('❌ Товар не найден'); die();
    }
    }
}
if (array_key_exists('photo', $request->message) or array_key_exists('document', $request->message)) {
    // send('⏳ Обработка изображения...');
    // если пришла картинка то сохраняем ее у себя
    if (!$request->message->photo) {
        $photo = $request->message->document;
        $file_id = $photo->file_id;
    } else {
        $photo = $request->message->photo;
        $file_id = $photo[(count($photo) - 1)]->file_id;
    }
    $rs = copyPhoto(json_decode(api(['file_id' => $file_id], "getFile"), TRUE)['result']['file_path']);
    // $rs = getPhoto($photo);
    if ($rs) {
        $count = count(explode(' ', end(explode(';@', $user['tmp']))))-1;
        send('✅ <b>Изображение загружено: </b><code>'.$rs.'</code>');
        die();
    }
}
if ($cmd[0] == '!бд') {
if(!$cmd[1]) {
send('📕 <code>!бд [id] [колонка]</code>
<b>Выводит информацию из ячейки</b>
📕 <code>!бд записать [id] [колонка] [значение]</code>
<b>Записывает информацию в ячейку</b>'); die();
} elseif ($cmd[1] == 'записать') {
$ad = R::load('newproducts', $cmd[2]);
if ($ad) {
if ($cmd[4] && $cmd[4] != 'null' && $cmd[4] != 'NULL') {
for ($i=4; $cmd[$i]; $i++) {
$txt .= $cmd[$i].' ';
}
} else {
$txt = null;
}
$ad[$cmd[3]] = $txt;
R::store($ad);
send('⚙ SQL запрос отправлен на сервер!'); die();
} else {
send('❌ Неверный ID'); die();
}
} else {
$ad = R::load('newproducts', $cmd[1]);
if ($ad) {
if ($ad[$cmd[2]] == null) {
$ad[$cmd[2]] = 'NULL';
}
send('⚙ Значение колонки <b>'.$cmd[2].'</b>, <b>'.$cmd[1].' ID</b>:
<code>'.$ad[$cmd[2]].'</code>'); die();
} else {
send('❌ Неверный ID'); die();
}
}
}
//if ($cmd[0] == ...) {}
//end if($user) ...
} else {
if ($chat_id == $user_id) {
if ($msg == 'GO!') {
$user = R::dispense('users');
$user->user_id = $user_id;
$user->date = date(U);
R::store($user); send('ok!'); die();
} else {
send('ERR');
}
}
}
//functions
function send($msg, $reply = false) {
if ($reply == false) {
$reply = null;
}
global $chat_id;
global $token;
$request_params = array(
'text' => $msg,
'reply_to_message_id' => $reply
);
$get_params = http_build_query($request_params);
$s = file_get_contents_curl('https://api.telegram.org/bot'.$token.'/sendMessage?parse_mode=html&chat_id='.$chat_id.'&'.$get_params);
}
function getPhotoPath($file_id) {
    // получаем объект File
    $array = json_decode(api(['file_id' => $file_id], "getFile"), TRUE);
    // возвращаем file_path
    return $array['result']['file_path'];
}
function copyPhoto($file_path, $dir = 'products_img') {
    // ссылка на файл в телеграме
    global $token;
    $file_from_tgrm = "https://api.telegram.org/file/bot".$token."/".$file_path;
    // достаем расширение файла
    $k = explode(".", $file_path);
    $ext = end($k);
    // назначаем свое имя здесь время_в_секундах.расширение_файла
    $rand = mt_rand(1, 9999);
    $name_our_new_file = time()."_".$rand.".".$ext;
    $result = copy($file_from_tgrm, $dir."/".$name_our_new_file);
    if ($result) {
        return $name_our_new_file;
    } else {
        return false;
    }
//    return error_get_last();
}
// function copyPhoto_r($file_path, $dir = 'reviews/') {
//     // ссылка на файл в телеграме
//     global $token;
//     $file_from_tgrm = "https://api.telegram.org/file/bot".$token."/".$file_path;
//     // достаем расширение файла
//     $k = explode(".", $file_path);
//     $ext = end($k);
//     // назначаем свое имя здесь время_в_секундах.расширение_файла
//     $dir = opendir('reviews/');
//     $count = 0;
//     while($file = readdir($dir)){
//         if($file == '.' || $file == '..' || is_dir('reviews/' . $file)){
//             continue;
//         }
//         $count++;
//     }
//     $name_our_new_file = $count.".".$ext;
//     $result = copy($file_from_tgrm, $dir."/".$name_our_new_file);
//     if ($result) {
//         return $name_our_new_file;
//     } else {
//         return error_get_last();
//         return false;
//     }
// }
function getPhoto($data, $dir = 'products_img'){
    $file_id = $data[(count($data) - 1)]->file_id;
    if (!$file_id) {
        $file_id = $data->file_id;
    }
    // получаем file_path
    $file_path = getPhotoPath($file_id);
    // возвращаем результат загрузки фото
    return copyPhoto($file_path, $dir);
}
function translit_sef($value)
{
    $converter = array(
        'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
        'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
        'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
        'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
        'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
        'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
        'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
    );
 
    $value = mb_strtolower($value);
    $value = strtr($value, $converter);
    $value = mb_ereg_replace('[^-0-9a-z]', '-', $value);
    $value = mb_ereg_replace('[-]+', '-', $value);
    $value = trim($value, '-'); 
 
    return $value;
}
function GetUser($user) {
$id = explode('-', $user);
if (!is_numeric($id[1]) or !$user) {
$s_user = R::findOne('users', 'user_id = ?', array($user));
if (!$s_user) {
$s_user = R::findOne('users', 'nick = ?', array($user));
}
} else {
$s_user = R::load('users', $id[1]);
}
if (!$s_user) {
error(1);
}
return $s_user;
}
function error($error) {
if ($error == 1 or $error == 'find') {
send('❌ Пользователь не найден');
die('ok');
}
}
function emoji($number) {
if ($number == 0) {
$number = '0⃣';
} elseif ($number == 1) {
$number = '1⃣';
} elseif ($number == 2) {
$number = '2⃣';
} elseif ($number == 3) {
$number = '3⃣';
} elseif ($number == 4) {
$number = '4⃣';
} elseif ($number == 5) {
$number = '5⃣';
} elseif ($number == 6) {
$number = '6⃣';
} elseif ($number == 7) {
$number = '7⃣';
} elseif ($number == 8) {
$number = '8⃣';
} elseif ($number == 9) {
$number = '9⃣';
} elseif ($number == 10) {
$number = '🔟';
} else {
$number .= '.';
}
return $number;
}
function txt_users($s) {
$a=substr($s,strlen($s)-1,1);
if($a==1) $str="пользователю";
if($a==2 || $a==3 || $a==4) $str="пользователям";
if($a==5 || $a==6 || $a==7 || $a==8 || $a==9 || $a==0 || $s==11 || $s==12 || $s==13 || $s==14 || substr($s, -2)==11 || substr($s, -2)==12 || substr($s, -2)==13 || substr($s, -2)==14) $str="пользователям";
return $str;
}
function api($array, $method) {
    global $token;
    $get_params = http_build_query($array);
    $context = stream_context_create(array(
        'http' => array('ignore_errors' => true),
    ));
    $result = file_get_contents_curl('https://api.telegram.org/bot'.$token.'/'.$method.'?parse_mode=html&'.$get_params, false, $context);
//    send(var_export($result, true));
    return $result;
}
function inline_keyboard($msg, $keyboard) {
global $chat_id;
global $token;
$request_params = array(
'text' => $msg,
'reply_markup' => json_encode(array('inline_keyboard' => $keyboard))
);
$get_params = http_build_query($request_params);
return file_get_contents_curl('https://api.telegram.org/bot'.$token.'/sendMessage?parse_mode=html&chat_id='.$chat_id.'&'.$get_params);
}
function keyboard($msg, $keyboard) {
global $chat_id;
global $token;
$request_params = array(
'text' => $msg,
'reply_markup' => json_encode(array('keyboard' => $keyboard, 'resize_keyboard' => true))
);
$get_params = http_build_query($request_params);
return file_get_contents_curl('https://api.telegram.org/bot'.$token.'/sendMessage?parse_mode=html&chat_id='.$chat_id.'&'.$get_params);
}
function keyboardRemove($msg) {
global $chat_id;
global $token;
$request_params = array(
'text' => $msg,
'reply_markup' => json_encode(array('remove_keyboard' => true))
);
$get_params = http_build_query($request_params);
return file_get_contents_curl('https://api.telegram.org/bot'.$token.'/sendMessage?parse_mode=html&chat_id='.$chat_id.'&'.$get_params);
}
function keyboard_home($msg = null) {
$keyboard1 = array(array(
array(
'text' => '➕ Добавить товар'
)
),
array(
array(
'text' => '🔧 Управление товаром'
)
),
array(
array(
'text' => '🔧 Управление категориями'
)
),
array(
array(
'text' => '⭐ Загрузить отзывы',
)
),
array(
array(
'text' => '🏠 Главное меню'
)
)
);
keyboard($msg, $keyboard1);
}
function keyboard_cancel($msg = null) {
$keyboard1 = array(array(
array(
'text' => '❌ Отмена'
)
)
);
keyboard($msg, $keyboard1);
}
function send_adm($msg, $die = false) {
$chat_id = $GLOBALS['admin_chat'];
global $token;
$request_params = array(
'text' => $msg
);
$get_params = http_build_query($request_params);
$s = file_get_contents_curl('https://api.telegram.org/bot'.$token.'/sendMessage?parse_mode=html&chat_id='.$chat_id.'&'.$get_params);
if ($die) {
die('ok');
}
}