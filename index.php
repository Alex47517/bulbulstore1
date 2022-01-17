<?php 
require 'start.php';
session_start();
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
    <?php $title = 'Главная | BulBul'; require 'parts/head.php'; ?>
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
<section id="main">
    <div class="container">
        <div class="row py-4 pl-3">
                <h3 class="main-h3">Главная</h3><div class="col line"></div>
        </div>
    </div>
    <div class="offer">
        <div class="container">
            <div class="row big-pad" style="">
                <div class="col-12 col-md-6 col-lg-6 col-xl-6  pb-5 pb-md-0" style="align-items: center; display: flex;flex-direction: column;justify-content:center;">
                    <h2 class="offer-h3">Почему более 10 000 клиентов выбрали Моечки BulBul? Давайте посмотрим на видео 😉</h2>
                    <!--<h3 class="offer-h3 align-self-start">Фиксируйте за собой скидку 👇</h3>-->
                    <a href="#categories" class="d-none d-md-block"><button type="button" class="btn more-btn button-margin" style="width: max-content;">Выбрать Лучшую Моечку. Клик 👇</button></a>
                </div>
                 <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                    <div id="carouselExampleControls" class="carousel slide offer-carousel" data-ride="carousel" style="display: flex; justify-content: center;">
                    <iframe
                          frameborder="0"
                      allowfullscreen=""
                      height="450"
                      src="https://www.youtube.com/embed/yHuL_SBFHDI?rel=0&amp;autoplay=1"
                      id="ips_uid_4488_9"
                      style="border-radius: 30px;"
                    ></iframe>
                      </div>
                      <a href="#categories" class="d-block d-md-none"><button type="button" class="btn more-btn button-margin">Выбрать Лучшую Моечку. Клик 👇</button></a>
                 </div>
            </div> 
        </div> 
    </div>
</section>
<section id="categories">
    <div class="container">
        <div class="row py-4 pl-3">
                <h3 class="main-h3">Категории товаров</h3><div class="col line"></div>
        </div>
        <div class="row my-0 my-md-3">
          <?php
          function product($pr) {
                   $a=substr($pr,strlen($pr)-1,1); 
                   if($a==1) $str="товар"; 
                   if($a==2 || $a==3 || $a==4) $str="товара"; 
                   if($a==5 || $a==6 || $a==7 || $a==8 || $a==9 || $a==0) $str="товаров"; 
                   if ($pr==11 or $pr==12 or $pr==13 or $pr==14) $str="товаров";
                   return $str; 
                }
            $category = array_values(R::getAll('SELECT * FROM categorys'));
            for ($i=0; $category[$i]; $i++) { 
              $products = array_values(R::getAll('SELECT * FROM newproducts WHERE category = '.$category[$i]['id'].' AND disabled = 0'));
                echo '<div class="col-12 col-md-6 col-lg-4 pb-3 pb-md-none">
              <div class="category py-3 px-3">
                <p class="category-text"><a href="/category.php?type='.$category[$i]['url_name'].'">
                    '.$category[$i]['name'].'
                </a></p>
                <div class="row">
                <div class="number align-self-start col-6 pr-0"><p class="pb-5">'.count($products).' '.product(count($products)).'</p>
                <a class="cart-btn btn" href="/category.php?type='.$category[$i]['url_name'].'">Далее>></a></div>
                <p style="display: none;" id="url_'.$i.'">'.$category[$i]['url_name'].'</p>
                <img class="d-inline col-6 category-image" onclick="link(document.getElementById(\'url_'.$i.'\').innerHTML);" src="images/'.$category[$i]['img'].'">
                </div>
              </div>
            </div>';
            }
          ?>
            <!-- <div class="col-12 col-md-6 col-lg-4">
              <div class="category py-4 px-3">
                <p class="category-text pl-4">
                    Гранитные мойки
                </p>
                <div class="row">
                <div class="number mt-3 col-6"><p>1325 товаров</p></div>
                <img class="d-inline col-6" src="images/sink.png">
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
              <div class="category py-4 px-3">
                <p class="category-text pl-4">
                  Умывальники для ванной
                </p>
                <div class="row">
                <div class="number mt-3 col-6"><p>1325 товаров</p></div>
                <img class="d-inline col-6" src="images/sink.png">
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
              <div class="category py-4 px-3">
                <p class="category-text pl-4">
                  Евросифоны
                </p>
                <div class="row">
                <div class="number mt-3 col-6"><p>1325 товаров</p></div>
                <img class="d-inline col-6" src="images/sink.png">
                </div>
              </div>
            </div>
        </div>
        <div class="row my-3">
          <div class="col-12 col-md-6 col-lg-4">
            <div class="category py-4 px-3">
              <p class="category-text pl-4">
                Кухонные смесители
              </p>
              <div class="row">
              <div class="number mt-3 col-6"><p>1325 товаров</p></div>
              <img class="d-inline col-6" src="images/sink.png">
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="category py-4 px-3">
              <p class="category-text pl-4">
                Умывальники для ванной
              </p>
              <div class="row">
              <div class="number mt-3 col-6"><p>1325 товаров</p></div>
              <img class="d-inline col-6" src="images/sink2.png">
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="category py-4 px-3">
              <p class="category-text pl-4">
                Дозаторы для моющего
              </p>
              <div class="row">
              <div class="number mt-3 col-6"><p>1325 товаров</p></div>
              <img class="d-inline col-6" src="images/sink.png">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-6 col-lg-4">
            <div class="category py-4 px-3">
              <p class="category-text pl-4">
                Евросифоны
              </p>
              <div class="row">
              <div class="number mt-3 col-6"><p>1325 товаров</p></div>
              <img class="d-inline col-6" src="images/sink.png">
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="category py-4 px-3">
              <p class="category-text pl-4">
                Умывальники для ванной
              </p>
              <div class="row">
              <div class="number mt-3 col-6"><p>1325 товаров</p></div>
              <img class="d-inline col-6" src="images/sink.png">
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="category py-4 px-3">
              <p class="category-text pl-4">
                Смесители для ванны
              </p>
              <div class="row">
              <div class="number mt-3 col-6"><p>1325 товаров</p></div>
              <img class="d-inline col-6" src="images/sink.png">
              </div>
            </div>
          </div> -->
        </div>
    <!-- <button type="button" class="btn more-btn mt-3">Подробнее</button> -->
    </div>
    <script type="text/javascript">
      function link(url_name) {
          window.location.replace('/category.php?type='+url_name);
      }
    </script>
</section>
<?php
    $pr = array_values(R::getAll('SELECT * FROM newproducts WHERE old_sum AND disabled = 0'));
    $all = count($pr);
    $pr = twodshuffle($pr);
    if ($pr[0]) {
      $action[0]['discount_pr'] = round((($pr[0]['old_sum'] - $pr[0]['sum'])*100)/$pr[0]['old_sum']);
      $action[0]['ad_name'] = $pr[0]['ad_name'];
      $action[0]['url_name'] = $pr[0]['url_name'];
      $action[0]['img'] = $pr[0]['img'];
      $action[0]['old_sum'] = $pr[0]['old_sum'];
      $action[0]['sum'] = $pr[0]['sum'];
    }
    if ($pr[1]) {
      $action[1]['discount_pr'] = round((($pr[1]['old_sum'] - $pr[1]['sum'])*100)/$pr[1]['old_sum']);
      $action[1]['ad_name'] = $pr[1]['ad_name'];
      $action[1]['img'] = $pr[1]['img'];
      $action[1]['old_sum'] = $pr[1]['old_sum'];
      $action[1]['sum'] = $pr[1]['sum'];
    }
    if ($pr[2]) {
      $action[2]['discount_pr'] = round((($pr[2]['old_sum'] - $pr[2]['sum'])*100)/$pr[2]['old_sum']);
      $action[2]['ad_name'] = $pr[2]['ad_name'];
      $action[2]['img'] = $pr[2]['img'];
      $action[2]['old_sum'] = $pr[2]['old_sum'];
      $action[2]['sum'] = $pr[2]['sum'];
    } else {
      $promote_disable = 'style="display: none"';
    }
  ?>
<section id="promotion" <?php echo $promote_disable; ?>>
  <div class="container my-3">
    <div class="row py-4 pl-3">
            <h3 class="main-h3">Акции</h3><div class="col line"></div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div id="carouselReviews" class="carousel slide w-100" data-ride="carousel">
      <ol class="carousel-indicators d-md-none">
          <li data-target="#carouselReviews" data-slide-to="0" class="active"></li>
          <li data-target="#carouselReviews" data-slide-to="1"></li>
          <li data-target="#carouselReviews" data-slide-to="2"></li>
     </ol>
         <div class="carousel-inner">
           <div class="carousel-item active">
           <div class="container">
             <div class="row prom-slide med-pad pt-5 pt-md-0">
              <div class="col-12 offset-md-2 col-md-4 py-0 py-md-5">
                <h2 class="prom-h2">Акция</h2>
                <h3 class="prom-h3">Скидка <?php echo $action[0]['discount_pr'].'  %'; ?></h3>
                <h4 class="prom-h4"><?php echo $action[0]['ad_name']; ?></h4>  
                <a href="/product.php?name=<?php echo $action[0]['url_name']; ?>"><button type="button" class="btn more-btn mt-3 d-none d-md-block">Подробнее</button></a>
              </div>
               <div class="col-12 col-md-4 align-self-center review-slide-picture d-flex">
                <img class="mw-100 align-self-center" src="products_img/<?php echo $action[0]['img']; ?>">   
               </div>   
               <div class="col-12 mb-5">
               <a href="/product.php?name=<?php echo $action[2]['url_name']; ?>"><button type="button" class="btn more-btn mt-3 d-block d-md-none">Подробнее</button></a>     
             </div></div>
          </div>
  </div>
   <div class="carousel-item">
   <div class="container">
   <div class="row prom-slide med-pad pt-5 pt-md-0">
    <div class="col-12 offset-md-2 col-md-4 py-0 py-md-5">
        <h2 class="prom-h2">Акция</h2>
        <h3 class="prom-h3">Скидка <?php echo $action[1]['discount_pr'].'  %'; ?></h3>
        <h4 class="prom-h4"><?php echo $action[1]['ad_name']; ?></h4>  
         <a href="/product.php?name=<?php echo $action[1]['url_name']; ?>"><button type="button" class="btn more-btn mt-3 d-none d-md-block">Подробнее</button></a>
      </div>
      <div class="col-12 col-md-4 align-self-center review-slide-picture d-flex">
        <img class="mw-100 align-self-center" src="products_img/<?php echo $action[1]['img']; ?>">   
       </div>
       <div class="col-12 mb-5">
       <a href="/product.php?name=<?php echo $action[2]['url_name']; ?>"><button type="button" class="btn more-btn mt-3 d-block d-md-none">Подробнее</button></a>
     </div>
     </div>
     </div>
  </div>
  <div class="carousel-item">
  <div class="container">
  <div class="row prom-slide med-pad pt-5 pt-md-0">
    <div class="col-12 offset-md-2 col-md-4 py-0 py-md-5">
        <h2 class="prom-h2">Акция</h2>
        <h3 class="prom-h3">Скидка <?php echo $action[2]['discount_pr'].'  %'; ?></h3>
        <h4 class="prom-h4"><?php echo $action[2]['ad_name']; ?></h4>  
        <a href="/product.php?name=<?php echo $action[2]['url_name']; ?>"><button type="button" class="btn more-btn mt-3 d-none d-md-block">Подробнее</button></a>
      </div>
      <div class="col-12 col-md-4 align-self-center review-slide-picture d-flex">
        <img class="mw-100 align-self-center" src="products_img/<?php echo $action[2]['img']; ?>">   
       </div>
       <div class="col-12 mb-5">
       <a href="/product.php?name=<?php echo $action[2]['url_name']; ?>"><button type="button" class="btn more-btn mt-3 d-block d-md-none">Подробнее</button></a>
     </div>     </div>
    </div>
    </div>
   </div>
   <a class="carousel-control-prev" href="#carouselReviews" role="button" data-slide="prev">
     <span class="carousel-control-prev-icon new-icon-left" aria-hidden="true"></span>
     <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselReviews" role="button" data-slide="next">
      <span class="carousel-control-next-icon new-icon-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
  </div>
    </div>
  </div>
 <!--  <script>
    var Prom1 = "Sep 5, 2021";
    var Prom2 = "Sep 6, 2021";
    var Prom3 = "Sep 8, 2021";
    function countdown (short, id) {
      // Set the date we're counting down to
      var countDownDate = new Date(short).getTime();
      
         // Get todays date and time
          var now = new Date().getTime();
          
          // Find the distance between now an the count down date
          var distance = countDownDate - now;
          
          // Time calculations for days, hours, minutes and seconds
          var days = Math.floor(distance / (1000 * 60 * 60 * 24));
          
          // Output the result in an element with id="demo"
          document.getElementById(id).innerHTML = "Осталось<br>" + days + "<br>дней";
          
          // If the count down is over, write some text 
          if (distance < 0) {
                clearInterval(x);
                document.getElementById(id).innerHTML = "Акция<br>окончена";
            }
        };
      countdown(Prom1, 'countdown1');
      countdown(Prom2, 'countdown2');
      countdown(Prom3, 'countdown3');
      </script>  -->
</section>
<section id="advantages">
  <div class="container my-3">
    <div class="row py-4 pl-3">
            <h3 class="main-h3">Преимущества</h3><div class="col line"></div>
    </div>
  </div>
  <div class="advn-block med-pad">
    <div class="container">
      <div class="row py-md-5">
        <div class="col-12 col-md-5">
          <h2 class="adv-h3">Наши приемущества</h2>
          <p class="advn-text">
          Считаю, что главным преимуществом, которое отличает нас АБСОЛЮТНО от всех -  это подход. Подход к созданию контента, Краш-Тестов, Видео-Обзоров, и конечно же к Клиентам. Не люблю хвастаться, но более чем 1000 Отзывов о чем-то говорят)  Гранитные мойки - которые оценили тысячи людей. Надеюсь, что Вы пополните список довольных клиентов!
          </p>
          <p class="advn-text">
         Посмотрите каталоги с товарами или просто напишите\позвоните и убедитесь сами в подходе, о котором я говорю! 
      </p>
        </div>
        <div class="col-12 col-md-7 pt-2">
          <div class="row pb-0 pb-md-5">
            <div class="col-6 col-md-6 pb-2 pb-md-none">
              <div class="d-flex">
                <img src="images/send-offer.png">
                <p class="adv-offer col align-self-center">Отправка<br>в день заказа</p>
              </div>
            </div>
            <div class="col-6 col-md-6 pb-2 pb-md-none">
              <div class="d-flex">
                <img src="images/price-offer.png">
                <p class="adv-offer col align-self-center">Низкие<br>цены</p>
              </div>
            </div>
            <div class="col-6 col-md-6 pb-2 pb-md-none">
              <div class="d-flex">
                <img src="images/discount-offer.png">
                <p class="adv-offer col align-self-center">Система<br>скидок</p>
              </div>
            </div>
            <div class="col-6 col-md-6 pb-2 pb-md-none">
              <div class="d-flex">
                <img src="images/consult-offer.png">
                <p class="adv-offer col align-self-center pr-0">Подробная<br>консультация</p>
              </div>
            </div>
            <div class="col-6 col-md-6 pb-2 pb-md-none">
              <div class="d-flex">
                <img src="images/assort-offer.png">
                <p class="adv-offer col align-self-center pr-0">Большой<br>ассортимент</p>
              </div>
            </div>
            <div class="col-6 col-md-6 pb-2 pb-md-none">
              <div class="d-flex">
                <img  src="images/review-offer.png">
                <p class="adv-offer col align-self-center pr-0">Более 1000 <br>позитивных отзывов</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php require 'parts/first_footer.php'; ?>
<?php require 'parts/second_footer.php'; ?>
<?php require 'parts/top_and_cart.php'; ?>
<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></button>
<script>
  // When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
</script>
<script>
$(document).ready(function(){
	$("#carouselExampleControls").swipe( {
		swipeLeft: function() {
			$(this).carousel("next");
		},
		swipeRight: function() {
			$(this).carousel("prev");
		},
		allowPageScroll: "vertical"
	});
});
$(document).ready(function(){
	$("#carouselReviews").swipe( {
		swipeLeft: function() {
			$(this).carousel("next");
		},
		swipeRight: function() {
			$(this).carousel("prev");
		},
		allowPageScroll: "vertical"
	});
});
</script>
<script>
  $(function () {
      $('[data-toggle="popover"]').popover({
html: true,
placement: 'bottom',
content: '<div class="d-flex flex-column"><img class="img-fluid w-50 mx-auto pt-3" src="images/sad.png" alt="Корзина пустая"><p>Корзина пустая</p>' 
});
  })
</script>
</body>
</html>