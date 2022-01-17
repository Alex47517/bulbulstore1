<?php
require 'start.php';
session_start();
if (!$_SESSION['user']['phone']) {
  header('Location: logout.php?riderect=sign_in');
}
if ($_POST && !$_POST['review']) {
  // die(var_dump($_POST));
  $user = R::load('clients', $_SESSION['user']['id']);
  if ($_POST['name'] && $_POST['surname']) {
    $user->name = $_POST['name'];
    $user->surname = $_POST['surname'];
  } 
  if ($_POST['phone']) {
    $user->phone = str_replace('+38', '', $_POST['phone']);
  }
  if ($_POST['np_number'] && $_POST['city']) {
    $user->np_number = $_POST['np_number'];
    $user->city = $_POST['city'];
  }
  R::store($user);
  $_SESSION['user'] = $user;
} else {
  $user = R::load('clients', $_SESSION['user']['id']);
  $_SESSION['user'] = $user;
}
if ($_POST['review']) {
  // die(var_dump($_POST['purchase_id']));
  $purchase = R::findOne('purchases', 'product = ?', array($_POST['purchase_id']));
  if ($purchase['client'] != $_SESSION['user']['id'] or !$purchase) {
      die('Увы, нельзя написать отзыв на чужую покупку))');
  }
  $purchase->review = $_POST['review'];
  $purchase->review_date = date('d.m.y');
  R::store($purchase);
  $alert = '<script>alert("Ваш отзыв опубликован!");</script>';
}
if (!$_SESSION['user']['phone']) {
  header('Location: logout.php?riderect=sign_in');
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php $title = 'Личный кабинет | BulBul'; require 'parts/head.php'; echo $alert; ?>
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
<?php $lc = 'Выйти'; $lc_link = '/logout.php'; require 'parts/first_header.php'; ?>
<?php require 'parts/second_header.php'; ?>
<section id="category">
    <div class="container">
        <div class="row py-4">
            <div class="col-12">
                <a href="/" class="breadcrumb-main-h3">Главная > </a><a href="/sign-in.php" class="breadcrumb-h3">Личный кабинет ></a>
            </div>
        </div>
    </div>
    <div class="cabinet-block">
    <div class="container">
        <div class="row pb-5">
        <div class="tab-content col-12 col-md-8 order-2 order-md-1 mb-4 mb-md-0 pb-5">
        <div class="tab-pane fade show active" id="v-pills-dannie" role="tabpanel" aria-labelledby="v-pills-dannie-tab">
        <div class="container">
        <div class="row">
            <h2 class="cab-h2 mt-0 mb-5 my-md-5"><i class="fa fa-check-square fa-fw" aria-hidden="true"></i>Личные данные</h2>
        </div>
        <div class="row">
            <div class="personal-info w-100" id="personal-red">
               <div class="row pb-2 pb-md-5">
                <div class="col-12 col-md-3">
                <p class="title"><b>Фамилия</b></p>
                <p class="info"><?php echo $_SESSION['user']['surname']; ?></p>
                </div>
            <div class="col-12 col-md-3">
                <p class="title"><b>Имя</b></p>
                <p class="info"><?php echo $_SESSION['user']['name']; ?></p>
            </div>
           <!--  <div class="col-12 col-md-3">
                <p class="title">Отчество</p>
                <p class="info">Не указано</p>
            </div> -->
            <div class="col-12 col-md-2 offset-md-1 offset-lg-2 offset-xl-3">
                <a onclick="personalEdit()" href="javascript: void(0)">Редактировать</a>
            </div>
            </div>
          <!--   <div class="row">
            <div class="col-12 col-md-3">
                <p class="title">Дата рождения</p>
                <p class="info">13 ноября 1992</p>
            </div>
            <div class="col-12 col-md-3">
                <p class="title">Пол</p>
                <p class="info">Мужской</p>
            </div>
            </div> -->
        </div>
        </div>
        <div class="row">
            <h2 class="cab-h2 my-5"><i class="fa fa-address-book fa-fw" aria-hidden="true"></i>Контакты</h2>
        </div>
        <div class="row">
            <div class="personal-info w-100" id="phone-red">
               <div class="row">
                <div class="col-12 col-md-5">
                <p class="title"><b>Телефон</b></p>
                <p class="info">+38<?php echo substr($_SESSION['user']['phone'], 0, 1).' '.substr($_SESSION['user']['phone'], 1, -7).' '.substr($_SESSION['user']['phone'], 3, -4).' '.substr($_SESSION['user']['phone'], 6, -2).' '.substr($_SESSION['user']['phone'], 8); ?></p>
            </div>
            <!-- <div class="col-12 col-md-5">
                <p class="title">Електронная почта</p>
                <p class="info">pedenko1392@gmail.cim</p>
            </div> -->
            <div class="col-12 col-md-2 offset-md-2 offset-lg-3 offset-xl-4">
            <a onclick="phoneEdit()" href="javascript: void(0)">Редактировать</a>
            </div>
            </div>
        </div>
        </div>
        <div class="row">
            <h2 class="cab-h2 my-5"><i class="fa fa-sign-in fa-fw" aria-hidden="true"></i></i>Доставка</h2>
        </div>
        <div class="row pb-2 pb-md-5">
            <div class="personal-info w-100" id="city-red">
               <div class="row">
                <div class="col-12 col-md-3 col-lg-4 col-xl-5">
                    <p class="title"><b>Город</b></p>
                    <p class="info"><?php if (!$_SESSION['user']['city']) { echo "Не указан"; } else { echo $_SESSION['user']['city']; } ?></p>
                </div>
                <div class="col-12 col-md-4">
                <p class="title"><b>№ отделения Новой почты</b></p>
                <p class="info"><?php if ($_SESSION['user']['np_number'] == 0) { echo "Не указан"; } else { echo $_SESSION['user']['np_number']; } ?></p>
                </div>
            <div class="col-12 col-md-4 col-lg-3 col-xl-2">
            <a onclick="cityEdit()" href="javascript: void(0)">Редактировать</a>
            </div>
            </div>
        </div>
        </div>  <!-- <br><br> -->
        </div>
</div>
<div class="tab-pane fade" id="v-pills-zakaz" role="tabpanel" aria-labelledby="v-pills-zakaz-tab">
<div class="container">    
<div class="row">
        <h2 class="cab-h2 mt-0 mb-5 my-md-5"><i class="fa fa-archive fa-fw" aria-hidden="true"></i></i>Мои заказы</h2>
    </div> 
    <?php
    $purchase = array_values(R::getAll('SELECT * FROM purchases WHERE client = '.$_SESSION['user']['id']));
    for ($i=0; $purchase[$i]; $i++) { 
      if ($purchase[$i]['review']) {
          $status = 'Выполнено';
      } else {
          $status = 'Ожидается отзыв';
      }
      $product = R::load('newproducts', $purchase[$i]['product']);
        echo '<div class="row pt-3 pb-5">
        <div class="personal-info w-100">
           <div class="row">
        <div class="col-1"><i class="fa fa-circle text-success" aria-hidden="true"></i></div>
        <div class="col-10 col-md-3">
            <p class="title">№ '.$purchase[$i]['id'].' от '.$purchase[$i]['date'].'</p>
            <p class="info">'.$status.'</p>
        </div>
        <div class="col-12 col-md-3">
            <p class="title">Сумма заказа</p>
            <p class="info">'.$purchase[$i]['sum'].' грн.</p>
        </div>
        <div class="col-12 col-md-3">
            <img class="w-100" src="products_img/'.$product['img'].'">
        </div>
        <div class="col-12 col-md-2">
            <p class="title">'.$product['ad_name'].'</p>
        </div>
        </div>
    </div>
    </div>';
    }
    if ($i == 0) {
      echo 'Вы еще не совершали заказов';
    }
    ?>
</div></div>
<div class="tab-pane fade" id="v-pills-otziv" role="tabpanel" aria-labelledby="v-pills-otziv-tab">
<div class="container">  
    <div class="row">
        <h2 class="cab-h2 mt-0 mb-5 my-md-5"><i class="fa fa-archive fa-fw" aria-hidden="true"></i></i>Отзывы</h2>
    </div> 
    <?php
    // $purchase = array_values(R::getAll('SELECT * FROM purchases WHERE client = '.$_SESSION['user']['id']));
    for ($i=0; $purchase[$i]; $i++) { 
      if ($purchase[$i]['review']) {
          $status = $purchase[$i]['review'];
      } else {
          $status = 'Оставьте тут отзыв о товаре';
      }
      $product = R::load('newproducts', $purchase[$i]['product']);
        echo '<div class="row pt-3 pb-5">
        <div class="personal-info w-100">
        <div class="row">
         <div class="col-12 col-md-3">
             <a href="/product.php?name='.$product['url_name'].'"><img class="w-100" src="products_img/'.$product['img'].'"></a>
         </div>
     <div class="col-10 col-md-7">
         <p class="cab-review-info">Товар</p>
         <p style="display: none;" id="review-art">'.$product['id'].'</p>
         <a href="/product.php?name='.$product['url_name'].'"><p class="title">'.$product['ad_name'].'</p></a>
         <hr>
         <p class="cab-review-info">Ваш комментарий</p>
         <p class="сab-review-text" id="review">'.$status.'</p>
     </div>
     <div class="col-12 col-md-2">
     <a onclick="reviewEdit('.$product['id'].')" href="#">Редактировать</a>
    </div>
     </div>
 </div>
    </div>';
    }
    if ($i == 0) {
      echo 'Вы еще не совершали заказов';
    }
    ?>

</div>
</div></div>
    <div class="col-12 col-md-4 order-1 order-md-2">
        <div class="cab-info py-3 px-5 px-md-3 px-lg-5">
            <div class="row">
            <i class="fa fa-address-card fa-3x col-4 col-lg-3 align-self-center" aria-hidden="true"></i>
            <div class="col-8 col-lg-9 align-self-center">
            <h4 class="cab-info-name"><?php echo $_SESSION['user']['name'].' '.$_SESSION['user']['surname']; ?></h4>
            </div>  
            </div>
        </div>
        <div class="cab-tabs mt-4 py-4 px-3 mb-5">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-pills-dannie-tab" data-toggle="pill" href="#v-pills-dannie" role="tab" aria-controls="v-pills-dannie" aria-selected="true">Данные учетной записи</a>
                <a class="nav-link" id="v-pills-zakaz-tab" data-toggle="pill" href="#v-pills-zakaz" role="tab" aria-controls="v-pills-zakaz" aria-selected="false">Мои заказы</a>
                <a class="nav-link" id="v-pills-otziv-tab" data-toggle="pill" href="#v-pills-otziv" role="tab" aria-controls="v-pills-otziv" aria-selected="false">Отзывы</a>
              </div>
        </div>
    </div>
        </div>
    </div>
    </div>
</section>
<script>
    function personalEdit(){
document.getElementById('personal-red').innerHTML = '	<form method="post" action="MyCabinet.php"><label for="newname">Имя</label><div class="form-group"><input type="text" name="name" class="form-control" id="newname"></div> <div class="form-group"><label for="newsurname">Фамилия</label><input type="text" name="surname" class="form-control" id="newsurname"></div><button type="submit" class="btn more-btn">Отправить</button></form> ';
};
function phoneEdit(){
document.getElementById('phone-red').innerHTML = '	<form method="post" action="MyCabinet.php"> <label for="newPhone">Телефон</label><input type="tel" name="phone" id="newPhone" class="form-control bfh-phone" data-format="+380ddddddddd" value="+380123456789" required=""><button type="submit" class="btn more-btn">Отправить</button></form> ';
};
function cityEdit(){
document.getElementById('city-red').innerHTML = '	<form method="post" action="MyCabinet.php"><label for="newcity">Город</label><div class="form-group"><input type="text" name="city" class="form-control" id="newcity"></div> <div class="form-group"><label for="newnp">Отделение новой почты</label><input type="text" name="np_number" class="form-control" id="newnp"></div><button type="submit" class="btn more-btn">Отправить</button></form> ';
};

    var reviewart = $("#review-art").html();
    function reviewEdit(id){
document.getElementById('review').innerHTML = '	<form method="post" action="MyCabinet.php">  <div class="form-group"><input type="hidden" class="form-control" id="reviewid" name=""><input type="hidden" class="form-control" id="reviewid" name="purchase_id" value="'+ id +'"></div> <div class="form-group"><label for="newreviewtext">Новый комментарий</label><input type="text" name="review" class="form-control" id="newreviewtext"></div><button type="submit" class="btn more-btn">Отправить</button></form> ';
   // Оставь одну строчку
   document.getElementById('reviewid').name = reviewart;   // W3C DOM
};

    </script>
<?php require 'parts/first_footer.php'; ?>
<?php require 'parts/second_footer.php'; ?>
<?php require 'parts/top_and_cart.php'; ?>
  </body>
  </html>