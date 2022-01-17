<?php
require 'start.php';
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php $title = 'О нас | BulBul'; require 'parts/head.php'; ?>
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
                <a href="/" class="breadcrumb-main-h3">Главная ></a><a href="/about-us.php" class="breadcrumb-h3"> О Нас ></a>
            </div>
        </div>
    </div>
    <div class="sign-in">
        <div class="container">
            <div class="med-pad">
                    <div class="confirm-card">
                    <h2 class="about-us-h2 pb-1">САМЫЙ ВАЖНЫЙ ВОПРОС!️ Чем же лучше остальных?)<br>
                        Друзья, Вы это поймёте сами, когда станете моим клиентом. <br>
                        Неожиданно, правда?)</h1><br>
                        <p class="about-us-text">На самом деле всё намного проще) Скажите, Вы где-нибудь видели более 1000-чи Фото-Отзывов от реальных клиентов? Почему здесь только их часть? Сделано с целью лучшей работы сайта, чтобы не перегрузить, ведь их реально ОЧЕНЬ много) Но, каждый Отзыв  есть на странице в Инстаграмм - @bulbul_ua, где показываю и рассказываю ключевые моменты, делюсь интересными новостями с подписчиками. В общем, жду и Вас там!)</p>
                        <h3 class="about-us-h3">А давайте кратко? Чем же лучше всё же остальных?</h3> 
                        <dl>
                        <li class="about-text">Вы знаете у кого Вы покупаете, кто видит меня впервые, то зовут - Егор и могу похвастаться огромным количеством положительных отзывов)</li>
                        <li class="about-text">Я могу сказать гордо, что лучшее качество Гранитных моек, но разве это правдоподобно? Давайте лучше покажу Краш-Тесты и как всё есть на самом деле. Скачусь на Мойке с горки, буду кидать кастрюли, тарелки, оставлю на 24 часа «ядовитую смесь» чтобы посмотреть реакцию на пятна!) Если Вы их ещё не посмотрели, то <span class="text-danger">ОБЯЗАТЕЛЬНО</span> Рекомендую. И конечно  5 лет реальной гарантии!</li>
                        <li class="about-text"> Хорошо, Вы посмотрели видео, но хочется пощупать и убедится в этом лично? И здесь добавляю <span class="text-danger">ОГРОМНЫЙ</span> плюс. Отправки делаю <span class="text-danger">БЕЗ ПРЕДОПЛАТЫ</span>, чтобы на новой почте Вы сами во всем убедились!)</li>
                        <li class="about-text">Скорость отправки. Кому нужно срочно и побыстрей, и здесь Вас не подведу!  Отправка в день заказа до 16:00. Спасает наличие всего!</li>
                        <li class="about-text">Полный комплект! Вам не нужно бегать куда-то, ведь всё уже сделано для Вас. И причём идеально в цвет!</li>
                        <li class="about-text"> Доступная цена. Здесь думаю всё понятно!)</li>
                        <li class="about-text">Индивидуальная работа с каждым, если Вы чего-то не знаете или не можете определиться с цветом, формой, дизайном, то просто напишите или позвоните. Поверьте, покажу Вам готовое решение, Вашей же проблемы от предыдущих клиентов😉</li>
                        </dl>
                        <div class="thumb-wrap">
  <iframe id="ytplayer" type="text/html" width="720" height="405"
src="https://www.youtube.com/embed/cxU8EpG9_Sw?autoplay=1"
frameborder="0" allowfullscreen></iframe>
</div>
        <h3 class="sign-h3 mt-5">Ваш Егор❤️</h3> 
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