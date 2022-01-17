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
  <div id="cart5"></div>  
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
  window.onload = loadCartData;
  </script>
  
  ';
?>