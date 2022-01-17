<?php
require 'start.php';
session_start();
if (!$_SESSION['cart']) {
	header('Location: /');
}
for ($i=0; $_SESSION['cart'][$i]; $i++) { 
	$product = R::load('newproducts', $_SESSION['cart'][$i]['art']);
	$k[$i]['ad_name'] = $product['ad_name'];
	$k[$i]['url_name'] = $product['url_name'];
	$k[$i]['sum'] = $product['sum'];
	if ($product) {
		if (!$product['old_sum']) {
			$sum += $product['sum']*$_SESSION['cart'][$i]['count'];
		} else {
			$sum += $product['old_sum']*$_SESSION['cart'][$i]['count'];
		}
		$ord_sum += $product['sum']*$_SESSION['cart'][$i]['count'];
	}
}
$discount = $sum - $ord_sum;
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php $title = 'Оформление заказа (корзина) | BulBul'; require 'parts/head.php'; ?>
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
<div class="container">
  <div class="row py-4">
      <div class="col-12">
          <a href="/" class="breadcrumb-main-h3">Главная > </a><a href="/bucket-order.php" class="breadcrumb-h3"> Корзина ></a>
      </div>
  </div>
</div>
<div class="product-block">
<section id="category">
    <div class="container py-5">
    <div class="row min-vh-100 cart_wrapper">
      <div class="bucket-order w-75">
      <form class="buy-form" method="post" action="confirm.php">
      <h3 class="form-h3 py-3">Ваши данные для оформления заказа</h3>
      <?php
      if (!$_SESSION['user']) {
        echo '<p>Если Вы уже делали покупки у нас - <a href="/sign-in.php?red=/bucket-order.php">войдите</a>, данные будут заполнены автоматически</p><br>';
      }
      ?>
      <div class="form-row">
      <div class="form-group col-12 col-md-6">
      <label for="deliverName">Имя</label>
      <input type="text" class="form-control" name="name" value="<?php echo $_SESSION['user']['name']; ?>" id="deliverName" aria-describedby="nameHelp" placeholder="Введите имя">
      </div>
      <div class="form-group col-12 col-md-6">
      <label for="deliverSurname">Фамилия</label>
      <input type="text" class="form-control" name="surname" value="<?php echo $_SESSION['user']['surname']; ?>" id="deliverSurname" aria-describedby="surnameHelp" placeholder="Введите фамилию">
      </div>
      </div>
      <div class="form-row">
      <div class="form-group col-12 col-md-6">
      <label for="deliverPhone">Телефон</label>
      <input type="tel" name="phone" id="deliverPhone" name="phone" class="form-control bfh-phone" data-format="+380ddddddddd" value="+380<?php echo substr($_SESSION['user']['phone'], 1); ?>" required="">
      </div>
      </div>
      <h3 class="form-h3 pt-3 pb-5">Доставка</h3>
     <div class="form-row">
      <div class="form-group col-md-6">
        <label for="deliverMethod">Служба доставки: Новая почта</label>
      </div>
      <div class="form-group col-md-6">
        <!-- <label for="deliverPay">Телефон</label>
        <select id="deliverPay" class="form-control delivery-choose">
          <option selected=""></option>
          <option value="Білий">Оплата на карту</option>
          <option value="Сінаро">Оплата наличкой</option>
          <option value="Чорний">Я не хочу оплачивать</option>
      </select> -->
      </div>
     </div>
     <div class="form-row">
      <div class="form-group col-md-6">
        <label for="DeliverCity">Город</label>
        <input type="text" class="form-control" value="<?php echo $_SESSION['user']['city']; ?>" name="city" id="DeliverCity" placeholder="Введите город доставки">
        </div>
        <div class="form-group col-md-6">
          <label for="deliverDepartment">Номер отделения Новой почты (до 1000 кг)</label>
          <input type="number" class="form-control" name="np_number" value="<?php echo $_SESSION['user']['np_number']; ?>" id="DeliverCity" placeholder="Введите номер отделения Новой почты">
        </div>
     </div><br>
     <div class="buy-block">
       <h4 class="buy-h4">Ваш заказ</h4>
       <div class="row">
       </div>
       <div class="row">
         <p class="buy-sum col-6">Сумма заказа:</p>
         <p class="buy-amount col-6 text-right"><?php echo $sum; ?> грн</p>
       </div>
       <div class="row">
        <p class="buy-sum col-6">Скидка: </p>
        <p class="buy-amount col-6 text-right"><?php echo $discount; ?> грн</p>
      </div>
      <div class="row">
        <p class="buy-sum final col-6">Всего к оплате:</p>
        <p class="buy-amount final col-6 text-right"><?php echo $ord_sum; ?> грн</p>
      </div>
     <button type="submit" name="submit" class="btn signup-btn w-100">Оформить заказ</button>
    </div>
  </form></div>
  </div> 
</section>
</div>
<script>
   function buyButton()
   {    
    document.getElementById("nav-post-tab").click();
   }
</script>
<?php require 'parts/first_footer.php'; ?>
<?php require 'parts/second_footer.php'; ?>
<?php require 'parts/top_and_cart.php'; ?>
  </body>
  </html>