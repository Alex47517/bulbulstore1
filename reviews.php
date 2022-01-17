<?php
require 'start.php';
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php $title = 'Ваши отзывы | BulBul'; require 'parts/head.php'; ?>
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
                <a href="/" class="breadcrumb-main-h3">Главная ></a><a href="/review.php" class="breadcrumb-h3"> Ваши отзывы ></a>
            </div>
        </div>
    </div>
    <div class="sign-in">
    <div class="container">
			<div class="row">
			 <h3 class="mt-5 ml-3 ml-md-0">Ваши отзывы</h3>
            </div>
            <div class="row pb-5">		 
     <div class="w-100 big-pad position-relative">
      <div id="carousel" class="mx-auto reviews">
      <?php
        $review = array_values(R::getAll('SELECT * FROM reviews'));
        for ($i=0; $review[$i]; $i++) { 
          echo '<a href="javascript: void(0)"><img class="review-img" src="reviews/'.$review[$i]['img'].'" id="item-'.($i+1).'" /></a>';
        }
      ?>
    </div> 
    <a href="javascript: void(0)" id="prev" class="arrow-left"><div class="new-icon-left myarrow"></div></a> 
    <a href="javascript: void(0)" id="next" class="arrow-right" ><div class="new-icon-right myarrow"></div></a>   
</div>
<div class="carouselfon d-md-none"></div>
	</div>
			 </div>
    </div>
</section>
<script>
 $(function() {      
      $(".carouselfon").swipe( {
        swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
          if("right" === direction) {
          	$("#prev").click();
          } else if("left" === direction) {
          	$("#next").click();
          }
        },
        allowPageScroll: "vertical"
      });
      
    });
</script>
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