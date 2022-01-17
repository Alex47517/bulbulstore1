<?php
require 'start.php';
session_start();
if (!$_GET['name'] && !$_GET['art']) {
  header('Location: /');
}
if ($_GET['art']) {
  $product = R::load('newproducts', $_GET['art']);
  $_GET['name'] = $product['url_name'];
} else {
  $product = R::findOne('newproducts', 'url_name = ?', array($_GET['name']));
}
if (!$product) {
  header('Location: /');
}
$cat = R::load('categorys', $product['category']);
function twodshuffle($array) {
    // Get array length
    $count = count($array);
    // Create a range of indicies
    $indi = range(0,$count-1);
    // Randomize indicies array
    shuffle($indi);
    // Initialize new array
    $newarray = array($count);
    // Holds current index
    $i = 0;
    // Shuffle multidimensional array
    foreach ($indi as $index)
    {
        $newarray[$i] = $array[$index];
        $i++;
    }
    return $newarray;
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php $title = ''.$product['ad_name'].' | BulBul'; require 'parts/head.php'; ?>
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
          <a href="/" class="breadcrumb-main-h3">Главная > </a><a href="category.php?type=<?php echo $cat['url_name']; ?>" class="breadcrumb-h3"><?php echo $cat['name']; ?> ></a><a href="product.php?name=<?php echo $_GET['name']; ?>" class="breadcrumb-h3"><?php echo $product['ad_name']; ?> ></a>
      </div>
  </div>
</div>
<div class="product-block">
<section id="category">
    <div class="container py-5">
    <div class="row min-vh-100">
        <div class="сol-12 col-md-6" id="slider">
            <div id="myCarousel" class="carousel slide shadow">
                <!-- main slider carousel items -->
                <div class="carousel-inner">
                    <?php
                    $img = explode(' ', $product['imgs']);
                    $active = 'active ';
                    for ($i=0; $img[$i]; $i++) { 
                      echo '<script>
                        console.log("'.explode('$', $img[$i])[0].'");
                      </script>';
                      if (explode('$', $img[$i])[0] == 'video') {
                        echo '<script>
                        console.log("'.explode('$', $img[$i])[0].' - ok");
                      </script>';
                      		echo '<div class="'.$active.'carousel-item text-center" data-slide-number="'.$i.'">
                              <div class="thumb-wrap">
  <iframe id="ytplayer" type="text/html" width="720" height="405"
src="https://www.youtube.com/embed/'.explode('$', $img[$i])[1].'?autoplay=1"
frameborder="0" allowfullscreen></iframe>
</div>
                            </div>';
                      } else {
                      if ($i != 0) {
                          $active = null;
                      }
                      echo '<div class="'.$active.'carousel-item text-center" data-slide-number="'.$i.'">
                              <img src="products_img/'.$img[$i].'" class="img-fluid carousel-rounded">
                            </div>';
                    }
                  }
                    ?>
                </div>
                <!-- main slider carousel nav controls -->

                <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon new-icon-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon new-icon-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
                <ul class="carousel-indicators list-inline mx-auto">
                  <?php
                    $active = ' active';
                    $selected = ' class="selected"';
                    for ($i=0; $img[$i]; $i++) { 
                      if ($i != 0) {
                          $active = null;
                          $selected = null;
                      }
                      if (explode('$', $img[$i])[0] == 'video') {
                      	echo '<li class="list-inline-item'.$active.'">
                        <a id="carousel-selector-'.$i.'"'.$selected.' data-slide-to="'.$i.'" data-target="#myCarousel">
                            <img src="products_img/vid.png" class="img-fluid">
                        </a>
                    </li>';
                } else {
                      echo '<li class="list-inline-item'.$active.'">
                        <a id="carousel-selector-'.$i.'"'.$selected.' data-slide-to="'.$i.'" data-target="#myCarousel">
                            <img src="products_img/'.$img[$i].'" class="img-fluid">
                        </a>
                    </li>';
                }
                    }
                    ?>
                </ul>
            </div>
        </div>
<div class="col-12 col-md-6">
  <h3 class="product-h3"><?php echo $product['ad_name']; ?></h3>
  <div class="row">
  <p class="col-6 col-lg-4 prod-code">Код товара:<span><?php echo ' '.$product['id']; ?></span></p><p class="col-6 exist"><i class="fa fa-check text-success" aria-hidden="true"></i> в наличии</p>
  </div>
  <hr>
  <?php
  if ($product['video']) {
    echo '<div class="thumb-wrap">
<iframe id="ytplayer" type="text/html" width="720" height="405"
src="https://www.youtube.com/embed/'.$product['video'].'?autoplay=1"
frameborder="0" allowfullscreen></iframe></div><hr>';
  }
  ?>
    <div class="form-row">
      <div class="form-group col-md-5 col-lg-4 align-self-center">
        <label for="quantity" class="count-text">Кол-во товара </label>
        <input class="count" type="number" name="num" min="1" max="99" value="1" id="quantity <?php echo $product['id']; ?>">
      </div>
      <div class="form-group col-md-5 col-lg-3">
        <select id="color <?php echo $product['id']; ?>" class="form-control color-choose">
          <option selected>Выбор цвета...</option>
          <option value="Білий">Білий</option>
          <option value="Сінаро">Сахара</option>
          <option value="Чорний">Чорний</option>
          <option value="Сірий">Сірий</option>
          <option value="Коричневий">Коричневий</option>
          <option value="Avena">Avena</option>
          <option value="Terra">Terra</option>
          <option value="Ivory">Ivory</option>
          <option value="Світло-сірий">Світло-сірий</option>
          <option value="Old-stone">Old-stone</option>
          <option value="Terracota">Terracota</option>
          <option value="Mokko">Mokko</option>
        <option value="Графіт">Графіт</option>
      </select>
        </select>
      </div>
      <div class="form-group">
        <div class="form-row pl-1">
            <div class="col-12 col-md-12">
              <?php
                if ($product['old_sum']) {
                  echo '<p class="old-price">'.$product['old_sum'].' грн</p>';
                }
              ?>
              <p class="product-price">Цена: <span class="prom-price"><?php echo $product['sum']; ?> грн</span></p>
              <!--<p class="product-price" style="font-size: 14px;">Условие акции: при покупке с Моечкой на краники скидка до 40%, оставляйте заявку, чтобы зафиксировать за собой скидку. Действует до 27.11.2021 включительно. +380 66 605 3892</p>-->
            </div>
            <div class="col-12 col-md-6 mb-3 mb-md-0 mt-2"><button onclick="addtoCart(<?php echo $product['id']; ?>)" class="btn more-btn">В корзину</button></div>
            <div class="col-12 col-md-6 mt-2"><a href="#tabs" onclick="buyButton()" class="btn buy-now-btn" >Купить</a></div>
        </div>
    </div>
</div>
</div>
    </div>
    <!--/main slider carousel-->
</div>
</section>
<hr>
<section id="tabs">
  <div class="container">
    <div class="row">
   <nav class="col-12 col-lg-9 pb-4">
    <div class="nav nav-tabs product-tabs" id="nav-tab" role="tablist">
      <a class="nav-item nav-link active pl-0 pr-5" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Характеристики</a>
      <a class="nav-item nav-link pl-0 pr-5" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Описание</a>
      <a class="nav-item nav-link pl-0 pr-5" id="nav-review-tab" data-toggle="tab" href="#nav-review" role="tab" aria-controls="nav-review" aria-selected="false">Отзывы</a>
      <a class="nav-item nav-link pl-0 pr-5" id="nav-post-tab" data-toggle="tab" href="#nav-post" role="tab" aria-controls="nav-post" aria-selected="false">Доставка и оплата</a>
    </div>
  </nav>
  <div class="col-12 col-lg-9 tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
      <table class="table table-striped -td-width-half char-table" style="line-height: 20.7999992370605px;">
        <tbody>
          <?php
            $tr = explode(';', $product['specifications']);
            for ($i=0; $tr[$i]; $i++) { 
                $td = explode(':', $tr[$i]);
                echo '<tr>
                        <td class="name">'.$td[0].'</td>
                        <td class="result">'.$td[1].'</td>
                      </tr>';
            }
          ?>
        </tbody>
     </table>
    </div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
      <div class="description py-5 px-5">
        <p><?php echo $product['description']; ?></p>
      </div>
    </div>
    <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
      <?php
          $purchase = array_values(R::getAll('SELECT * FROM purchases WHERE product = '.$product['id']));
          for ($i=0; $purchase[$i]; $i++) { 
            if ($purchase[$i]['review']) {
              $client = R::load('clients', $purchase[$i]['client']);
              if ($client['name']) {
                echo '<div class="review mb-3">
        <p class="review-name d-inline"><b>'.$client['name'].'</b></p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <p class="rviewd-date d-inline"><i class="fa fa-clock-o" aria-hidden="true"></i> '.$purchase[$i]['review_date'].'</p>
        <hr>
        <p class="review-text">'.$purchase[$i]['review'].'</p>
      </div>';
              }
            }
          }
          if ($i == 0) {
              echo "<p>Отзывов нет...</p>";
            }
      ?>
      
      <hr>
<div class="row">
  <!-- <form class="review-form pt-5 w-100">
    <div class="form-row">
      <div class="form-group col-12 col-md-7">
          <label for="reviewName">Имя:</label>
          <input type="name" class="form-control" id="reviewName" aria-describedby="reviewHelp">
      </div>
      <div class="form-group col-12 col-md-5 align-self-center">

        <div class="rating-area">
          <span>Рейтинг: </span>
          <input type="radio" id="star-5" name="rating" value="5">
          <label for="star-5" title="Оценка «5»"></label>	
          <input type="radio" id="star-4" name="rating" value="4">
          <label for="star-4" title="Оценка «4»"></label>    
          <input type="radio" id="star-3" name="rating" value="3">
          <label for="star-3" title="Оценка «3»"></label>  
          <input type="radio" id="star-2" name="rating" value="2">
          <label for="star-2" title="Оценка «2»"></label>    
          <input type="radio" id="star-1" name="rating" value="1">
          <label for="star-1" title="Оценка «1»"></label>
        </div>
      </div>
    </div>
    <div class="form-group pb-3">
    <label for="reviewText">Текст:</label>
    <textarea class="form-control form-area" style="height: 100%;" id="reviewtext" rows="8"></textarea>
    </div>
    <button type="submit" class="btn sign-btn">Отправить</button>
</form> -->
<?php
    if (!$_SESSION['user']) {
        echo '<p><a href="sign_in.php">Войдите</a> что-бы оставить отзыв</p>';
    } else {
      echo '<p>Вы можете опубликовать/редактировать свой отзыв на странице <a href="MyCabinet.php">личного кабинета</a></p>';
    }
?>
</div>

    </div>
    <div class="tab-pane fade" id="nav-post" role="tabpanel" aria-labelledby="nav-post-tab">    
      <form class="buy-form" method="post" action="confirm.php">
      <h3 class="form-h3 py-3">Ваши данные для оформления заказа</h3>
      <?php
      if (!$_SESSION['user']) {
        echo '<p>Если Вы уже делали покупки у нас - <a href="/sign-in.php?red=product.php?name='.$_GET['name'].'">войдите</a>, данные будут заполнены автоматически</p><br>';
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
      <div class="form-row">
      <div class="form-group col-12 col-md-6">
      <label for="deliverPhone">Цвет товара</label>
      <select id="inputState" name="color" class="form-control color-choose">
          <option selected>Выбор цвета...</option>
          <option value="Білий">Білий</option>
          <option value="Сінаро">Сахара</option>
          <option value="Чорний">Чорний</option>
          <option value="Сірий">Сірий</option>
          <option value="Коричневий">Коричневий</option>
          <option value="Avena">Avena</option>
          <option value="Terra">Terra</option>
          <option value="Ivory">Ivory</option>
          <option value="Світло-сірий">Світло-сірий</option>
          <option value="Old-stone">Old-stone</option>
          <option value="Terracota">Terracota</option>
          <option value="Mokko">Mokko</option>
        <option value="Графіт">Графіт</option>
      </select>
      </div>
      </div>
      <h3 class="form-h3 pt-3 pb-5">Доставка</h3>
     <div class="form-row">
      <div class="form-group col-md-6">
        <label for="deliverMethod">Служба доставки: Новая почта</label>
       <!--  <select id="deliverMethod" class="form-control delivery-choose">
          <option selected="">Выбор способа...</option>
          <option value="Білий">Новая почта</option>
          <option value="Сінаро">Не новая почта</option>
          <option value="Чорний">Укрпошта</option>
          <option value="Сірий">Ололо</option>
      </select> -->
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
          <input type="hidden" name="art" value="<?php echo $product['id']; ?>">
          <label for="deliverDepartment">Номер отделения Новой почты</label>
          <input type="number" class="form-control" name="np_number" value="<?php echo $_SESSION['user']['np_number']; ?>" id="DeliverCity" placeholder="Введите номер отделения Новой почты">
        </div>
     </div><br>
     <div class="buy-block">
       <div class="buy-order">
       <h4 class="buy-h4">Ваш заказ</h4>
       <div class="row">
         <p class="buy-sum col-6">Сумма заказа:</p>
         <p class="buy-amount col-6 text-right"><?php echo $product['sum']; ?> грн</p>
       </div>
       <div class="row">
        <p class="buy-sum col-6">Скидка:</p>
        <?php
          if ($product['old_sum']) {
            $action = $product['old_sum'] - $product['sum'];
          } else {
            $action = '0';
          }
        ?>
        <p class="buy-amount col-6 text-right"><?php echo $action; ?> грн</p>
      </div>
      <div class="row">
        <p class="buy-sum final col-7">Всего к оплате:</p>
        <p class="buy-amount final col-5 text-right"><span class="final-price"><?php echo $product['sum']; ?> грн</span></p>
      </div>
     <button type="submit" name="submit" class="btn signup-btn w-100">Оформить заказ</button>
     </div>
       <a href="/#categories" onclick="addtoCart(<?php echo $product['id']; ?>)" class="btn continue-btn mt-3">&#60; Добавить и продолжить</a>
    </div>
    
  </form></div>
  </div> 
</div>
</div>
</section>
<hr>
<section id="also">
  <div class="container my-3">
    <div class="row py-4 pl-3">
            <h3 class="main-h3">С этим товаром покупают</h3>
            <div class="col line">
            </div>
            <a class="also-control-left" href="#carouselAlso" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
           </a>
              <a class="also-control-left" href="#carouselAlso" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div id="carouselAlso" class="carousel slide w-100" data-ride="carousel">
         <div class="carousel-inner">
           <div class="carousel-item active">
           <div class="container">
            <div class="row pb-3 pb-md-5">
              <?php
                $pr = array_values(R::getAll('SELECT * FROM newproducts WHERE category != '.$cat['id'].' AND disabled = 0'));
                $all = count($pr);
                $pr = twodshuffle($pr);
                for ($i=0; $i < $all; $i++) { 
                  if ($i == 10) {
                    break;
                  }
                  if ($pr[$i]['old_sum']) {
                      $action = '<p class="prom-green py-2">Акция</p>';
                      $old_sum = '<p class="old-price">'.$pr[$i]['old_sum'].' грн</p>';
                  } else {
                    $action = null;
                    $old_sum = null;
                  }
                  if ($close) {
                    echo '</div></div>
  </div>
  <div class="carousel-item">
  <div class="container">
    <div class="row pb-3 pb-md-5">';
                      $close = false;
                  }
                  $href = "product.php?name=".$pr[$i]['url_name'];
                  echo '<div class="col-12 col-md-6 col-lg-6 col-xl-3 pb-3 pb-xl-0">
                  <div class="category-card h-100">
                  <a href="'.$href.'"><div class="mb-4 category-img">
                      <img class="mw-100" src="products_img/'.$pr[$i]['img'].'">
                      </div></a>
                      '.$action.'
                        <div class="form-row">
                            <div class="form-group col-12 col-md-7">
                              <h4 class="category-h4">'.$pr[$i]['ad_name'].'</h4>
                            </div>
                            <div class="form-group col-12 col-md-5 align-self-center">
                              <p class="exist">в наличии</p>
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-5">
                              <label for="inputCity" class="count-text">Кол-во</label>
                              <input type="hidden" name="product" value="'.$pr[$i]['id'].'">
                              <input class="count" type="number" name="num" min="1" max="99" value="1" id="quantity '.$pr[$i]['id'].'">
                            </div>
                            <div class="form-group col-md-7">
                              <select id="color '.$pr[$i]['id'].'" class="form-control color-choose">
                                <option selected>Выбор цвета...</option>
                                <option value="Білий">Білий</option>
                                <option value="Сінаро">Сахара</option>
                                <option value="Чорний">Чорний</option>
                                <option value="Сірий">Сірий</option>
                                <option value="Коричневий">Коричневий</option>
                                <option value="Avena">Avena</option>
                                <option value="Terra">Terra</option>
                                <option value="Ivory">Ivory</option>
                                <option value="Світло-сірий">Світло-сірий</option>
                                <option value="Old-stone">Old-stone</option>
                                <option value="Terracota">Terracota</option>
                                <option value="Mokko">Mokko</option>
                              <option value="Графіт">Графіт</option>
                            </select>
                              </select>
                            </div>
                            </div>
                            <div class="form-row">
                                  <div class="form-group col-6 col-md-5">
                                      '.$old_sum.'
                                      <p class="prom-price">'.$pr[$i]['sum'].' грн</p>
                                  </div>
                                  <div class="form-group col-6 col-md-7"><button onclick="addtoCart('.$pr[$i]['id'].')" class="btn cart-btn">В корзину</button></div>
                      </div>
              </div>
          </div>';
          if (($i+1)%4 == 0) {
              $close = true;
          }
                }
              ?>
          <!-- <div class="col-12 col-md-6 col-lg-3 pb-3 pb-md-0">
              <div class="category-card">
                  <p class="prom-green py-2">Акция</p>
                  <img class="pb-4 mw-100" src="images/mojka1.png">
  
                  <form>
                      <div class="form-row">
                        <div class="form-group col-12 col-md-7">
                          <h4 class="category-h4">Мойка гранитная bulbul Forza XL</h4>
                        </div>
                        <div class="form-group col-12 col-md-5 align-self-center">
                          <p class="exist">в наличии</p>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-5">
                          <label for="inputCity" class="count-text">Кол-во</label>
                          <input class="count" type="number" name="num" min="1" max="99" value="1" id="inputCity">
                        </div>
                        <div class="form-group col-md-7">
                          <select id="inputState" class="form-control color-choose">
                            <option selected>Выбор цвета...</option>
                            <option value="Білий">Білий</option>
                            <option value="Сінаро">Сахара</option>
                            <option value="Чорний">Чорний</option>
                            <option value="Сірий">Сірий</option>
                            <option value="Коричневий">Коричневий</option>
                            <option value="Avena">Avena</option>
                            <option value="Terra">Terra</option>
                            <option value="Ivory">Ivory</option>
                            <option value="Світло-сірий">Світло-сірий</option>
                            <option value="Old-stone">Old-stone</option>
                            <option value="Terracota">Terracota</option>
                            <option value="Mokko">Mokko</option>
                          <option value="Графіт">Графіт</option>
                        </select>
                          </select>
                        </div>
                        <div class="form-group">
                          <div class="row">
                              <div class="col-6 col-md-6">
                                  <p class="old-price">3345 грн</p>
                                  <p class="prom-price">2850 грн</p>
                              </div>
                              <div class="col-6 col-md-6"><button type="submit" class="btn cart-btn">В корзину</button></div>
                          </div>
                      </div>
                  </div>
                    </form>
          </div>
      </div> -->
      
  </div>    </div>  
    </div>
   </div>
  </div>
    </div>
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