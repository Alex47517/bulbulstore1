<?php
require 'start.php';
session_start();
if ($_POST['phone']) {
  // die(var_dump($_POST));
  $user = R::findOne('clients', 'phone = ?', array(str_replace('+38', '', $_POST['phone'])));
  if ($user) {
    $error = 'Ваш номер уже зарегистрирован. Воспользуйтесь <a href="/sign_in.php">этой формой</a> что-бы войти';
  } else {
    if ($_POST['name']) {
      if ($_POST['surname']) {
        if ($_POST['city']) {
          if ($_POST['np_number']) {
            if (strlen(str_replace('+38', '', $_POST['phone'])) != 10) {
              $error = 'Введите корректный номер телефона';
            } else {
            $user = R::dispense('clients');
            $user->name = $_POST['name'];
            $user->surname = $_POST['surname'];
            $user->city = $_POST['city'];
            $user->np_number = $_POST['np_number'];
            $user->phone = str_replace('+38', '', $_POST['phone']);
            R::store($user);
            $user = R::findOne('clients', 'phone = ?', array(str_replace('+38', '', $_POST['phone'])));
            if ($user) {
              $_SESSION['user'] = $user;
            } else {
              die('Ошибка при создании учетной записи');
            }
            }
          } else {
            $error = 'Введите номер склада Новой почты, Вы в любой момент сможете поменять его в будущем';
          }
        } else {
          $error = 'Введите название вашего города, Вы в любой момент сможете поменять его в будущем';
        }
      } else {
        $error = 'Введите фамилию, Вы в любой момент сможете поменять ее в будущем';
      }
    } else {
      $error = 'Введите имя, Вы в любой момент сможете поменять его в будущем';
    }
  }
}
if ($_SESSION['user']) {
  header('Location: MyCabinet.php');
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
<section id="forgot">
    <div class="container">
        <div class="row py-4">
            <div class="col-12">
                <a href="/" class="breadcrumb-main-h3">Главная > </a><a href="sign-up.php" class="breadcrumb-h3">Зарегестрироватся ></a>
            </div>
        </div>
    </div>
    <div class="sign-in">
        <div class="container">
            <div class="row big-pad">
                <div class="col-12 col-md-6 mx-auto">
                    <div class="sign-card">
                        <h3 class="sign-h3">Создать новую учётную запись клиента</h3>
                            <form class="sign-form" method="post" action="sign-up.php"><br>
                                <div class="form-group">
                                <label for="signupName">Имя</label>
                                <input type="text" class="form-control" required="" name="name" id="signupName" aria-describedby="nameHelp">
                                </div>
                                <div class="form-group">
                                <label for="signupSurname">Фамилия</label>
                                <input type="text" class="form-control" required="" name="surname" id="signupSurname" aria-describedby="surnameHelp">
                                </div>
                                <div class="form-group">
                                <label for="signupSurname">Город</label>
                                <input type="text" class="form-control" required="" name="city" id="signupSurname" aria-describedby="City">
                                </div>
                                <div class="form-group">
                                <label for="signupSurname">№ Склада Новой почты</label>
                                <input type="number" class="form-control" required="" name="np_number" id="signupSurname" aria-describedby="np_number">
                                </div>
                                <div class="form-group">
                                <label for="signupPhone">Телефон</label>
                                <input type="tel" name="phone" id="signupPhone" class="form-control bfh-phone" data-format="+380ddddddddd" value="+380" required="">
                                </div>
                                <!-- <div class="form-group pb-3">
                                <label for="signupInputPassword1">Пожалуйста, введите буквы, показанные ниже</label>
                                <input type="password" class="form-control" id="signupInputPassword1">
                                </div> -->
                                <?php if ($error) { echo '<p style="color: red;">'.$error.'</p>'; } else { echo '<br>'; }?>
                                <button type="submit" class="btn signup-btn">Зарегестрироватся</button>
                            </form>
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