<?php
require 'start.php';
session_start();
//error_reporting(0);
unset($_SESSION['cart']);
// $user = R::findOne('clients', 'phone = ?', array(str_replace('+38', '', $_POST['phone'])));
// if (!$user) {
//     $user = R::dispense('clients');
//     $user->name = $_POST['name'];
//     $user->surname = $_POST['surname'];
//     $user->city = $_POST['city'];
//     $user->np_number = $_POST['np_number'];
//     $user->phone = str_replace('+38', '', $_POST['phone']);
//     R::store($user);
//     $user = R::findOne('clients', 'phone = ?', array(str_replace('+38', '', $_POST['phone'])));
//     $_SESSION['user'] = $user;
// }
// if (!$_POST['art']) {
//     if ($_SESSION['cart']) {
//         $cart = 'Корзина';
//         $href = '#';
//         $prod = null;
//     } else {
//         header('Location: /');
//     }
// } else {
//     $product = R::load('newproducts', $_POST['art']);
// if (!$product) {
//     die('Товар не найден!');
// }
// $cat = R::load('categorys', $product['category']);
// $cart = $product['ad_name'];
// $href = '/product.php?name='.$product['url_name'].'';
// $prod = '<a href="/category.php?type='.$cat['url_name'].'" class="main-h3">'.$cat['name'].' >';
// }
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php $title = 'Спасибо за заказ! | BulBul'; require 'parts/head.php'; ?>
    <!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '430398447988155');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=430398447988155&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
</head>
<body>
<?php require 'parts/first_header.php'; ?>
<?php require 'parts/second_header.php'; ?>
<section id="sign">
    <div class="sign-in">
        <div class="container">
            <div class="big-pad">
                    <div class="confirm-card">
                        <h2 class="confirm-h2 pb-5">Спасибо за заказ!</h1>
                        <!-- <h3 class="sign-h3">Проверьте введенные данные:</h3> -->
                        <p class="sign-text text-center"><b>Возможно Вам перезвонит менеджер для уточнения деталей</b></p>
                        <p class="sign-text text-center">Вы увидите свой заказ в <a href="/sign-in.php">личном кабинете</a>, как только мы его подтвердим. Не забудьте оставить отзыв после получения)</p>
                       <p class="text-center"><a style="color: white;" href="/" class="btn signup-btn mx-auto">Хорошо</a></p>
                    </div>
            </div>
        </div>
    </div>
</section>
<?php require 'parts/first_footer.php'; ?>
<?php require 'parts/second_footer.php'; ?>
<?php require 'parts/top_and_cart.php'; ?>
  </body>
  </html>