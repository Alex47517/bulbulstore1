<?php
require 'start.php';
session_start();
//error_reporting(0);
if (!$_POST['phone']) {
    header('Location: /');
}
$user = R::findOne('clients', 'phone = ?', array(str_replace('+38', '', $_POST['phone'])));
if (!$user) {
    $user = R::dispense('clients');
    $user->name = $_POST['name'];
    $user->surname = $_POST['surname'];
    $user->city = $_POST['city'];
    $user->np_number = $_POST['np_number'];
    $user->phone = str_replace('+38', '', $_POST['phone']);
    R::store($user);
    $user = R::findOne('clients', 'phone = ?', array(str_replace('+38', '', $_POST['phone'])));
    $_SESSION['user'] = $user;
}
if (!$_POST['art']) {
    if ($_SESSION['cart']) {
        $cart = 'Корзина';
        $href = '#';
        $prod = null;
    } else {
        header('Location: /');
    }
} else {
    $product = R::load('newproducts', $_POST['art']);
if (!$product) {
    die('Товар не найден!');
}
$cat = R::load('categorys', $product['category']);
$cart = $product['ad_name'];
$href = '/product.php?name='.$product['url_name'].'';
$prod = '<a href="/category.php?type='.$cat['url_name'].'" class="main-h3">'.$cat['name'].' >';
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php $title = 'Оформление заказа | BulBul'; require 'parts/head.php'; ?>
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
    <div class="container">
        <div class="row py-4">
            <div class="col-12">
                <a href="/" class="breadcrumb-main-h3">Главная ></a><?php echo $prod; ?></a><a href="<?php echo $href; ?>" class="breadcrumb-h3"><?php echo $cart; ?> ></a><a href="#" class="breadcrumb-h3">Оформление заказа ></a>
            </div>
        </div>
    </div>
    <div class="sign-in">
        <div class="container">
            <div class="big-pad">
                    <div class="confirm-card">
                        <h2 class="confirm-h2 pb-5">Оформление заказа</h1><br>
                        <h3 class="sign-h3">Проверьте введенные данные:</h3>
                        <p class="sign-text text-center"><b>Имя, фамилия:</b> <?php echo $_POST['name'].' '.$_POST['surname']; ?></p>
                        <p class="sign-text text-center"><b>Город:</b> <?php echo $_POST['city']; ?></p>
                        <p class="sign-text text-center"><b>№ отделения Новой почты:</b> <?php echo $_POST['np_number']; ?></p>
                        <?php
                        if ($_POST['art']) {
                          echo '<p class="sign-text text-center"><b>Цвет:</b> '.$_POST['color'].'</p>';
                        }
                        ?>
                        <p class="sign-text text-center"><b>Номер телефона:</b> <?php echo $_POST['phone']; ?></p><br>
                        <?php
                        if ($cart == 'Корзина') {
                          echo '<h3 class="sign-h3">Товар:</h3>';
                          for ($i=0; $_SESSION['cart'][$i]; $i++) { 
                            $product = R::load('newproducts', $_SESSION['cart'][$i]['art']);
                            echo '<p class="sign-text text-center"><b><a target="_blank" href="/product.php?name='.$product['url_name'].'">'.$product['ad_name'].'</a></b> - '.$product['sum'].' грн. (х'.$_SESSION['cart'][$i]['count'].')</p>';
                            if ($product) {
                              if (!$product['old_sum']) {
                                $sum += $product['sum'];
                              } else {
                                $sum += $product['old_sum'];
                              }
                              $ord_sum += $product['sum']*$_SESSION['cart'][$i]['count'];
                            }
                          }
                          echo '<p class="sign-text text-center"><b>К оплате:</b> '.$ord_sum.' грн.</p>';
                          echo "<br>";
                        }
                        ?>
                       <p class="text-center"><a onclick="confirmOrder()" style="color: white;" class="btn signup-btn mx-auto">Подтвердить</a></p>
                    </div>
            </div>
        </div>
    </div>
</section>
<script>
   function confirmOrder(){
    var add = "<?php echo $product['id']; ?>";
   var color = "<?php echo $_POST['color']; ?>";
   var count = 1;
  
      var rest = 0;
  
      $.ajax({
  
          type: "GET",
  
          url: "api/cart.php",
  
          data: {add, color, count}
  
      }).done(function( result )
  
          {
  
      rest=result;
     console.log(rest);			
  
          });
  
          if (result='{"result":"true"}') {
  

     var name = '<?php echo $_POST['name']; ?>' 
     var surname = '<?php echo $_POST['surname']; ?>'
	 var phone = '<?php echo $_POST['phone']; ?>'
     var city = '<?php echo $_POST['city']; ?>'
     var np_number = '<?php echo $_POST['np_number']; ?>'
     var url = "api/order.php";

     $.ajax({
           type: "POST",
           url: url,
           data: {name, surname, phone, city, np_number}
        }).done(function( result )
           {
            window.location.replace('/thanks.php');
	console.log(result);

      });

 }

}
</script>
<?php require 'parts/first_footer.php'; ?>
<?php require 'parts/second_footer.php'; ?>
<?php require 'parts/top_and_cart.php'; ?>
  </body>
  </html>