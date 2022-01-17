<?php
require 'start.php';
session_start();
if (!$_GET['type']) {
	header('Location: /');
}
$cat = R::findOne('childcategorys', 'url_name = ?', array($_GET['type']));
if (!$cat) {
	header('Location: /');
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php $title = ''.$cat['name'].' | BulBul'; require 'parts/head.php'; ?>
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
<section id="category">
    <div class="container">
        <div class="row py-4">
            <div class="col-12">
                <a href="/" class="breadcrumb-main-h3">Главная > </a><a href="child_category.php?type=<?php echo $_GET['type']; ?>" class="breadcrumb-h3"><?php echo $cat['name'].''; ?></a>
            </div>
        </div>
    </div>
    <div class="category-block">
    <div class="container">
        <h3 class="category-h3 pt-5"><?php echo $category['name']; ?></h3>
        <div class="container">
   <div class="row">
        <div class="row pb-3 pb-md-5 order-2">
            <?php
            $max = 0;
            $min = 0;
            	$product = array_values(R::getAll('SELECT * FROM newproducts WHERE childcategory = '.$cat['id'].' ORDER by sum'));
            	for ($i=0; $product[$i]; $i++) { 
            		if (!$product[$i]['disabled']) {
            			if ($product[$i]['old_sum']) {
            				$action = '<p class="prom-green py-2">Акция</p>';
            				$old_sum = '<p class="old-price">'.$product[$i]['old_sum'].' грн</p>';
            			} else {
            				$action = null;
            				$old_sum = null;
            			}
                  if ($product[$i]['sum'] > $max) {
                    $max = $product[$i]['sum'];
                  } 
                  if ($product[$i]['sum'] < $min or $min == 0) {
                    $min = $product[$i]['sum'];
                  }
                  //$sort = '<div class="filter p-4 p-md-5 mb-5 order-1" id="filters">
//<p class="filter-head pb-3">Сортировать по цене:</p>
//<div class="slider-wrapper pb-5 pl-3">
//<div id="range" max="'.$max.'" min="'.$min.'"></div>
//</div>
//<div id="priceinput" class="price-inputs pl-3">
//<div class="row">
//<input type="text" id="inputminprice" class="col-4" value="'.$min.'"> 

//<input type="text" id="inputmaxprice" class="col-4 offset-1" value="'.$max.'"> 
//<button onclick="filterElements()" class="btn col-2 offset-1">ОК</button>
//</div>
//</div>
//</div>';
                  $href = 'product.php?name='.$product[$i]['url_name'];
            			echo '<div class="col-12 col-md-6 col-lg-4 col-xl-3 pb-3 pb-md-0 box" data-price="'.$product[$i]['sum'].'">
                <div class="category-card h-100">
                    '.$action.'
                    <a href="'.$href.'"><div class="mb-4 category-img"><img class="mw-100" src="products_img/'.$product[$i]['img'].'"></div></a>

                    <div class="form-row">
                          <div class="form-group<!-- col-12 col-md-7-->">
                            <a href="'.$href.'"><h4 class="category-h4">'.$product[$i]['ad_name'].'</h4></a>
                          </div>
                          <!--<div class="form-group col-12 col-md-5 align-self-center">
                            <p class="exist">в наличии</p>
                          </div>-->
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-5">
                            <label for="quantity" class="count-text">Кол-во</label>
                            <input class="count" type="number" name="num" min="1" max="99" value="1" id="quantity '.$product[$i]['id'].'">
                          </div>
                          <div class="form-group col-md-7">
                            <select id="color '.$product[$i]['id'].'" class="form-control color-choose">
                              <option value="Не выбран" selected>Выбор цвета...</option>
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
                                    <p class="prom-price">'.$product[$i]['sum'].' грн</p>
                                </div>
                                <div class="form-group col-6 col-md-7"><button onclick="addtoCart('.$product[$i]['id'].')" class="btn cart-btn">В корзину</button>
                                <div id="cart4" class="cart3-small-screen"></div>	
                                </div>
                                
                            </div>
               </div>
        </div>';
            		}
              }
            	if ($i == 0) {
                $sort = null;
            		echo "<h3 class=\"pl-3\">В этой подкатегории нет товаров</h3>";
            	}
            ?>
        </div>  
        <?php echo $sort; ?>
        </div> 
  </div>
       <!--  <div class="row med-pad">
            <div class="col-12 col-md-6">
                <nav aria-label="...">
                    <ul class="pagination category-pag">
                      <li class="page-item"><a class="page-link" href="#">1</a></li>
                      <li class="page-item active">
                        <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                      </li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item"><a class="page-link" href="#">4</a></li>
                      <li class="page-item"><a class="page-link" href="#">5</a></li>
                    </ul>
                </nav>
            </div>
            <p class="col-12 col-md-4 offset-md-2 seen-text">
                Вы посмотрели 8 товаров из 105
            </p>
        </div>  --> <br><br>    
    </div>
</div>
</section>
<script>
var filterAll = $('.filter-all'),
    boxs = $('.box'),
    length = boxs.length;
filterAll.text(length);



// Range Slider
var range = document.getElementById('range'),
    t = [],
    maximum = parseInt(range.attributes.max.value, 10),
    minimum = parseInt(range.attributes.min.value, 10),
    delta = (maximum - minimum) / 4,
    options = {
      min: [minimum],
      "16.6%": [minimum + delta * 1, 1e6],
      "33.2%": [minimum + delta * 1.5, 1e6],
      "49.8%": [minimum + delta * 2, 1e6],
      "66.4%": [minimum + delta * 2.5, 1e6],
      "83%": [minimum + delta * 3, 1e6],
      max: [maximum]
    };

//console.log(minimum + delta * 1, 1e6);

t.push(parseInt(range.attributes.min.value, 10)), 
  t.push(parseInt(range.attributes.max.value, 10));
var n = parseInt(range.attributes.max.value, 10); 
// i = parseInt(range.attributes.min.value, 10),

noUiSlider.create(
  range, 
  {
    range: options,
    start: t,
    connect: !0,
    pips: {
      mode: "range",
      density: 2
    }
  }
);

$(".noUi-value-horizontal").each(function() {
  var range = $(this).text().split("").join("");
  $(this).html(range);
});

range.noUiSlider.on('change', function(values, handle){
  $(".box").each(function() {
    var $this = $(this);
        price = $this.data('price');
    
    var val1 =  values[0];
    var val2 =  values[1];
    document.getElementById('inputminprice').value = parseInt(val1);
    document.getElementById('inputmaxprice').value = parseInt(val2);
    if(price <= val2 && price >= val1 ) {
      $this.show();
    }else {
      $this.hide();
    }
    
  });
}
);

function filterElements() {
  $(".box").each(function() {
    var $this = $(this);
        price = $this.data('price');
    minprice = document.getElementById('inputminprice').value;
    maxprice = document.getElementById('inputmaxprice').value;
    range.noUiSlider.set([minprice, maxprice]);
        var val3 = minprice;
    var val4 =  maxprice;
  
    if(price <= val4 && price >= val3 ) {
      $this.show();
    }else {
      $this.hide();
    }
    
  });
}
</script>
<?php require 'parts/first_footer.php'; ?>
<?php require 'parts/second_footer.php'; ?>
<?php require 'parts/top_and_cart.php'; ?>
  </body>
  </html>