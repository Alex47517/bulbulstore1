<?php
require 'start.php';
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php $title = 'Гарантия | BulBul'; require 'parts/head.php'; ?>
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
                <a href="/" class="breadcrumb-main-h3">Главная ></a><a href="/about-us.php" class="breadcrumb-h3"> Контакты ></a>
            </div>
        </div>
    </div>
    <div class="sign-in">
        <div class="container">
            <div class="med-pad">
                    <div class="confirm-card">
                    <h2 class="about-us-h2 pb-1">Контакты</h1><br>
                        <p class="guarantee-text">Менеджер Виктория👩‍💼: <a href="tel:+380666053892">+380 66 605 38 92</a></p>
                        
<p class="guarantee-text">Напомню график работы: с 8:00 и до 00:00 

<p class="guarantee-text">Для удобства пишите в Вайбере или звоните!) 

<p class="guarantee-text">И мой контактный номер: <a href="tel:+380509901722">+380 50 990 17 22</a> 🧔🏻
<div class="thumb-wrap">
  <iframe id="ytplayer" type="text/html" width="720" height="405"
src="https://www.youtube.com/embed/l1xhW9J4R2s?autoplay=1"
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