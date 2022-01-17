<?php
echo '<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></button>
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
  <div id="popup" class="popup">
  <div class="modal fade" id="modaladdedtocart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        Товар добавлен в корзину
      </div>
      <div class="modal-footer">
        <button type="button" onclick="closepopup()" class="btn cart-btn mx-auto" data-dismiss="modal">ОК</button>
      </div>
    </div>
  </div>
</div>
</div>
  <div id="cart2"></div>  
    <script>
  
  var color;
  
  var type=(\'не выбран\');
  
  var count= 1;
  
  $(document).ready(function f3(){
  
  $(\'#type\').change(function f3() {
  
  type = $(this).val();
  })
  
  });
  $(document).ready(function f4(){
  
  $(\'#quantity\').change(function f4() {
  
  count = $(this).val();
  })
  
  });
  function addtoCart(add){
  
   var count= document.getElementById(\'quantity \'+ add).value;
  
   color = document.getElementById(\'color \'+ add).value;
  
    var rest = 0;
  
      $.ajax({
  
          type: "GET",
  
          url: "api/cart.php",
  
          data: {add, color, count}
  
      }).done(function( result )
  
          {
  
      rest=result;
      if (result=\'{"result":"true"}\') {
        console.log(result);
        
    document.getElementById("modaladdedtocart").className = "modal fade show";
    document.getElementById("modaladdedtocart").style.background = "#000000b0";
    document.getElementById("popup").style.display = "block";
    document.getElementById("modaladdedtocart").style.display = "block";
    loadCartData();
    if (document.getElementById("popup2") != null && document.getElementById("popup2").style.display != \'none\')
    {
    showCart();
    }

    }
          });
  }
  </script>
  <script>
  function closepopup() {
    document.getElementById(\'popup\').style.display=\'none\';
  }
  </script>
  <script>
  var res = [];
  function loadCartData () {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if(this.readyState === 4) {
          document.getElementById(\'container\').innerHTML = \'	<div id="loader" class="hide"></div>\';
        } else {
          document.getElementById(\'container\').innerHTML = \'<div id="loader"></div>\';
        }};
        
   
        xhr.open(\'GET\', \'api/cart.php\', false);
        xhr.send();
  
      
        if (xhr.status != 200) {
  
          // обработать ошибку
  
          alert(\'Ошибка \' + xhr.status + \': \' + xhr.statusText);
  
        } else {
      res=xhr.responseText;
      console.log(res);
        }
  }
  document.addEventListener("DOMContentLoaded", loadCartData);
  function showCart() {
    var overallSum = 0;
      var overallCount = 0;
           if(res == null || res == "NULL" || res == "[]") {
  
        var str3="<div class=\"d-flex flex-column\"><img class=\"img-fluid w-50 mx-auto pt-3\" src=\"images/sad.png\" alt=\"Корзина пустая\"><p>Корзина пустая</p></div>";
  
        document.getElementById("cart3").className = "show-modal";
        setTimeout(function(){document.getElementById("cart3").className = "d-none";},3000);
  
        document.getElementById("cart3").innerHTML = str3;
        if (document.documentElement.clientWidth < 991) {
          alert(\'Ваша корзина все еще пустая!\');
        }
      }
  
  else {		
   
      var obj = JSON.parse(res);
      
         var str="<div id=\"popup2\" class=\"cart-div\"><div class=\"cart-pop-up\"><div class=\"cart-obj\"><span id=\"closed\" class=\"close\">X</span><div class=\"cart-button\"><div class=\"overall pb-2\"><span id=\"overallCount\"></span> шт в корзине</div><div class=\"overall\">Всего к оплате:&nbsp;<span id=\"overall\"></span>&nbsp;грн</div><br class=\"hidesm\"><a href=\"/bucket-order.php\"><button class=\"btn more-btn\" data-gtm-id=\"quick-order\">Оформить заказ</button></a></div><br class=\"hidesm\"><hr>";
  
       for(var i=0; i<obj.length; i++) {
        overallSum += parseInt(obj[i].sum, 10)*parseInt(obj[i].count, 10);
        overallCount += parseInt(obj[i].count, 10);
         str += "<div id=\""+obj[i].art+"\" class=\"cart-obj\"><img class=\"cart-img\" src=\"/products_img/" +obj[i].img+"\"><div class=\"cart-text\"><p><b><a href=\"/product.php?name="+obj[i].url_name+"\">"+obj[i].name+"</a></b></p><p>Цвет:<br>"+obj[i].color+"</p><p id=\"price\">"+obj[i].sum+" грн</p><p id=\"count\">"+obj[i].count+" шт</p></div><span id=\""+obj[i].art+"\" onclick=\"clearArt();\" class=\"close2\">X</span><hr></div>";
  
       }
       str += "<a href=\"/bucket-order.php\"><button class=\"btn more-btn\" data-gtm-id=\"quick-order\">Оформить заказ</button></a></div></div>";
  
        document.getElementById("cart2").innerHTML = str;
      
       document.getElementById("overall").innerHTML = overallSum;
       document.getElementById("overallCount").innerHTML = overallCount;
  
       document.getElementById("closed").addEventListener(\'click\', function () {

        document.getElementById(\'popup2\').style.display=\'none\';
      });	
          } 	 
    }
    function clearArt(){

      del= event.target.id;
        let elem = event.currentTarget.parentElement;
     
         $.ajax({
     
             type: "GET",
     
             url: "api/cart.php",
     
             data: {del}
     
         }).done(function( clear ){
          if (clear==\'{"result":"true"}\') {
            var obj = JSON.parse(res);
            obj.splice(obj.indexOf(obj.find(element => element.art == del )), 1); 
            res = JSON.stringify(obj);
            if (res == "[]")
            document.getElementById(\'popup2\').style.display=\'none\';
        else
            showCart();
          }  
        });
      }
   ;
     </script>	
  
  <script>	function clearcart(){
  
      var clear =\'true\'
  
       $.ajax({
  
          type: "GET",
  
          url: "api/cart.php",
  
          data: {clear}
  
      }).done(function( results )
  
          {
  
        if (results=\'{"result":"true"}\') {
  
      location.reload();
  
        }	
  
        document.getElementById("close").addEventListener(\'click\', function () {

          document.getElementById(\'popup\').style.display=\'none\';
   
       });
  
          })
  ;
  
  }</script>   ';
?>