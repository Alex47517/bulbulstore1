<?php
require 'start.php';
function send($msg, $chat_id) {
global $token;
$request_params = array(
'text' => $msg,
'reply_to_message_id' => $reply
);
$get_params = http_build_query($request_params);
return file_get_contents_curl('https://api.telegram.org/bot'.$token.'/sendMessage?parse_mode=html&chat_id='.$chat_id.'&'.$get_params);
}
function inline_keyboard($msg, $keyboard, $chat_id) {
global $token;
$request_params = array(
'text' => $msg,
'reply_markup' => json_encode(array('inline_keyboard' => $keyboard))
);
$get_params = http_build_query($request_params);
return file_get_contents_curl('https://api.telegram.org/bot'.$token.'/sendMessage?parse_mode=html&chat_id='.$chat_id.'&'.$get_params);
}
?>