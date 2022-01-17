<?php
require 'start.php';
session_start();
error_reporting(0);
if ($_GET['red']) {
    $red = '?red='.$_GET['red'];
}
if ($_POST['phone']) {
  // die(var_dump($_POST));
  $user = R::findOne('clients', 'phone = ?', array(str_replace('+38', '', str_replace('(', '', str_replace(' ', '', str_replace(')', '', str_replace('-', '', $_POST['phone'])))))));
  if ($user) {
    $_SESSION['user'] = $user;
  } else {
    $error = 'Похоже, что Вы у нас ничего не покупали. <br>Совершите любую покупку или <a href="sign-up.php">зарегистрируйтесь</a> для создания учетной записи';
  }
}
if ($_SESSION['user']) {
    if ($_GET['red']) {
        header('Location: '.$_GET['red'].'');
    } else {
        header('Location: MyCabinet.php');
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php $title = 'Авторизация | BulBul'; require 'parts/head.php'; ?>
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
                <a href="/" class="breadcrumb-main-h3">Главная ></a><a href="/sign-in.php" class="breadcrumb-h3">Личный кабинет ></a>
            </div>
        </div>
    </div>
    <div class="sign-in">
        <div class="container">
            <div class="row big-pad">
                <div class="col-12 col-md-4">
                    <h3 class="sign-h3">Зарегистрированные клиенты</h3>
                    <form class="sign-form pt-5" method="post" action="sign-in.php<?php echo $red; ?>">
                        <div class="form-group">
                        <label for="signupPhone">Телефон</label>
                        <input type="tel" name="phone" id="signupPhone" class="form-control bfh-phone" data-format="+380 (dd) ddd-dd-dd" value="+380" required="">
                        </div>
                        <?php if ($error) { echo '<p style="color: red">'.$error.'</p>'; } else { echo "<br>"; } ?>
                        <button type="submit" class="btn sign-btn mb-5">Войти</button>
                    </form>
                </div>
                <div class="col-12 col-md-6 mx-auto">
                    <div class="sign-card">
                        <h3 class="sign-h3">Новые клиенты</h3>
                        <p class="sign-text">Создание учётной записи происходит при оформлении первого заказа. Но при желани Вы можете создать его вручную, не делая покупок</p>
                        <a href="sign-up.php" class="btn signup-btn">Создать учётную запись</a>
                    </div>
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