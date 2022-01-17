<?php 
$category = array_values(R::getAll('SELECT * FROM categorys'));
if (!$category) {
  die('<h1 align="center">Сайт не настроен!</h1><p align="center">Создайте категории и добавьте товар через админ-бота</p>');
}
$categorys_burger = '<div class="card-header" id="headingOne">
                            <h5 class="mb-0 d-flex">
                              <a class="burger-a" href="/">
                                Главная</a>
                            </h5>
                          </div>';
$categorys .= '<li class="nav-item py-2">
                  <a class="nav-link" href="/">Главная</a>
                </li>';
for ($i=0; $category[$i]; $i++) { 
  $child_category = array_values(R::getAll('SELECT * FROM childcategorys WHERE father = '.$category[$i]['id'].''));
    if ($child_category) {
        for ($l=0; $child_category[$l]; $l++) { 
          $ch_categorys .= '<li class="nav-item">
                            <a class="nav-link" href="child_category.php?type='.$child_category[$l]['url_name'].'">- '.$child_category[$l]['name'].'</a>
                          </li>';
        }
        $ch = '<div id="collapse'.$i.'" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <ul class="nav flex-column burger-list">
                                  '.$ch_categorys.'                                  
                                </ul>
                            </div>
                          </div>';
        $ch_categorys = null;
        $btn = '<button class="btn burger-link collapsed" data-toggle="collapse" data-target="#collapse'.$i.'" aria-expanded="true" aria-controls="collapseOne"> </button>';
    } else {
        $btn = null;
        $ch = null;
    }
    $categorys_burger .= '<div class="card-header" id="headingOne">
                            <h5 class="mb-0 d-flex">
                              <a class="burger-a" href="/category.php?type='.$category[$i]['url_name'].'">
                                '.$category[$i]['name'].'
                                </a>'.$btn.'
                            </h5>
                          </div>'.$ch;
    $categorys .= '<li class="nav-item py-2">
                  <a class="nav-link" href="/category.php?type='.$category[$i]['url_name'].'">'.$category[$i]['name'].'</a>
                </li>';
}
if (!$search_head) {
  $search_head = null;
}
echo '<section id="second-header">
    <div class="container">
        <div class="row">
            <nav class="navbar navbar-light justify-content-between w-100 py-4 pb-md-0">
               <div class="mr-1 mr-md-0 noclose">
                <button class="btn btn-primary burger" type="button" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bars pr-2" aria-hidden="true"></i> <span class="d-none d-md-inline">Каталог</span>
                  </button>
                <div class="dropdown-menu" id="dropdown">
                  <div class="card card-body burger-menu mb-3">
                    <div id="accordion">
                        <div class="card">
                          '.$categorys_burger.'
                        </div>
                      </div>
                    </div>
                </div>     
            </div>  
                <form class="form-inline align-self-start ml-auto ml-md-0 position-relative"  method="get" action="search.php">
                    <div class="input-group search">
                        <input id="searchinput" autocomplete="off" name="search" oninput="searchFunction()" class="form-control" value="'.$search_head.'" placeholder="&nbsp; Поиск..." type="text">
                        <span class="input-group-btn">
                           <button class="btn search-btn" type="submit"><i class="fa fa-search pr-1" aria-hidden="true"></i></button>
                        </span>
                      </div>
                      <div id="searchresult"></div>
                </form>
              </nav>
        </div>
        <p class="best-text mb-0 align-self-center pt-3 d-none d-lg-flex">Интернет-магазин Гранитных Моек №1 в Украине</p>
           <div class="row pt-3 d-none d-lg-flex">
            <ul class="nav nav-fill second-menu align-items-center">
                '.$categorys.'
              </ul>
        </div>
    </div>
</section>
<div id="top-margin" class="d-none"></div>
<script>
$(document).on("click.bs.dropdown.data-api", ".noclose", function (e) { e.stopPropagation() });
</script>
<script>
function searchFunction () {
var searchrest= 0
  
  search =  document.getElementById(\'searchinput\').value;
  console.log(search);

  $.ajax({
  
    type: "GET",

    url: "api/search.php",

    data: {search}

}).done(function( resulted )

    {

searchrest=resulted;
console.log(searchrest);			
if (searchrest == "{\"error\":\"Not found\"}") {

  var str5 = "<div class=\"d-flex flex-column\"><img class=\"img-fluid w-10 mx-auto pt-3\" src=\"images/sad.png\" alt=\"Ничего не найдено\"><p>Ничего не найдено</p></div>";

  document.getElementById("searchresult").className = "show-modal";
  document.getElementById("searchresult").innerHTML = str5;
  document.getElementById("searchresult").style.display = "block";
} 
 else {		

  var obj = JSON.parse(searchrest);
  
     var str6="<div id=\"popup3\" class=\"cart-div\"><div class=\"search-pop-up\"><div class=\"search-obj\">Результаты поиска:<br class=\"hidesm\"><hr>";

   for(var i=0; i<obj.length; i++) {
     str6 += "<div id=\""+obj[i].id+"\" class=\"search-obj\"><img class=\"cart-img\" src=\"/products_img/" +obj[i].img+"\"><div class=\"cart-text\"><p><b><a href=\"/product.php?name="+obj[i].url_name+"\">"+obj[i].ad_name+"</a></b></p><p id=\"price\">"+obj[i].sum+" грн</p></div><hr></div>";

   }
   str6 += "</div></div>";

    document.getElementById("searchresult").innerHTML = str6;
    document.getElementById("searchresult").className = "show-modal";
    document.getElementById("searchresult").style.display = "block";

    $(document).on(\'click\', function(e) {
      if (!$(e.target).closest("#popup3").length) {
        $(\'#searchresult\').hide();
      }
      e.stopPropagation();
    });
     } 	 
   });

}
</script>
<script>
$(window).scroll(function(){
  var h_hght = 150; 
  if (document.documentElement.clientWidth < 376) {
    var h_hght = 187; 
  } else  if (document.documentElement.clientWidth < 415) {
    var h_hght = 199; 
  } else  if (document.documentElement.clientWidth < 429) {
    var h_hght = 204; 
  }
  else  if (document.documentElement.clientWidth < 768) {
    var h_hght = 240; 
  } else  if (document.documentElement.clientWidth < 992) {
    var h_hght = 287; 
  }
  var docscroll=$(document).scrollTop();
  if(docscroll>h_hght + 105){
    $(\'#second-header\').addClass(\'fixed-top\');
    $(\'#second-header\').css({ top: "-105px" });
    $(\'#top-margin\').removeAttr(\'class\').addClass(\'d-block\');
  }else{
    $(\'#second-header\').removeClass(\'fixed-top\');
    $(\'#second-header\').css({ top: "0" });
    $(\'#top-margin\').removeAttr(\'class\').addClass(\'d-none\');
  }
});
</script>
';