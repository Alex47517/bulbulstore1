<?php
if (!$lc) {
    if ($_SESSION['user']) {
        $lc = 'Личный кабинет ('.$_SESSION['user']['name'].')';
    } else {   
        $lc = 'Личный кабинет';
    }
 } 
if (!$lc_link) {
    $lc_link = '/sign-in.php';
}

/*

                <div class="col-md-9 align-self-center pr-0"><a class="header-link" href="'.$lc_link.'">'.$lc.'</a></div>
*/
echo '<section id="uphead">
<div class="container">
<div class="row d-none d-md-flex">
<ul class="nav first-menu justify-content-center justify-content-md-start">
    <li class="nav-item">
      <a class="nav-link active" href="/about-us.php">О нас</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/delivery.php">Оплата и доставка</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/guarantee.php">Гарантия</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/reviews.php">Отзывы</a>
    </li>
      <li class="nav-item">
        <a class="nav-link" href="/contacts.php">Контакты</a>
    </li>
  </ul>
</div>
</section>
<section id="first-head">
</div>
    <div class="container align-self-center">
	<div class="row d-none d-lg-flex">
        <div class="col-md-1 col-lg-1 col-xl-1 align-self-center">
        <a href="/"><img class="w-100 align-self-center" src="images/logo.png?v=2"></a>
        </div>
		<div class="col-md-5 col-lg-4 col-xl-3 align-self-center">
			<p class="header-text">Режим работы:<br>Ежедневно c 08:00 до 00:00</p>
		</div>
        <div class="offset-md-1 col-md-3 offset-lg-0 col-lg-3 offset-xl-1 col-xl-3 align-self-center">
        <div class="header-review px-2">
        <p class="d-inline">Более 1000 Фото-Отзывов от клиентов</p>
        <img class="d-inline header-img-rew" src="/images/header-review.png?v=2">
        </div>
        </div>
		<div class="col-md-3 col-lg-3 col-xl-3 align-self-center">
            <i class="fa fa-phone fa-fw" aria-hidden="true"></i>
            <a class="header-link" href="tel:+380666053892">+380 66 605 3892 - BulBul</a><br />
            <i class="fa fa-phone fa-fw" aria-hidden="true"></i>
            <a class="header-link" href="tel:+380991109998">+380 99 110 9998 - Киев BulBul</a>
		</div>
        <div class="col-md-1 col-lg-1 col-xl-1 align-self-center">
            <div class="row">

            <div class="col-md-12 align-self-center"><a href="javascript: void(0)" class="text-dark" role="button" onclick="showCart()"><i class="fa fa-2x fa-shopping-cart" aria-hidden="true"></i></a></div>
            <div id="cart3"></div>
            <div id="container"></div>
            </div>
        </div>
	</div>
    <div class="row d-lg-none">
    <div class="container">
    <div class="row pb-3">
    <div class="col-3 col-md-2 col-lg-3">
     <a href="/"><img class="w-100 align-self-center" src="images/logo.png?v=2"></a>
    </div>
    <div class="col-9 offset-md-1 offset-lg-0 align-self-center">
        <p class="header-text"><span>Режим работы:</span><br>Ежедневно c 08:00 до 00:00</p>
    </div>
    </div>
    <div class="row pb-3">
    <div class="col-6 align-self-center">
        <i class="fa fa-phone fa-fw" aria-hidden="true"></i>
        <a class="header-link" href="tel:+380666053892">+380 66 605 3892</a>                      
    </div>
    <div class="align-self-center header-review px-3">
    <div class="row">
    <p class="col-10 mb-0 px-0 align-self-center">Более 1000 Фото-Отзывов от клиентов</p>
    <img class="col-2 col-md-1 col-lg-2 px-0 align-self-center" src="/images/header-review.png?v=2">
    </div>
    </div>
    </div>
        <div class="d-flex border-mob py-2 mb-3">
        <div class="col-6 align-self-center">
        <a class="header-link" href="'.$lc_link.'">'.$lc.'</a>
    </div>
    <div class="col-4 align-self-center offset-2 pl-0 pr-1"><a href="javascript: void(0)" class="mob-cart" role="button" onclick="showCart()">Корзина <i class="fa fa-shopping-cart" aria-hidden="true"></i></a></div>
     <div id="cart3"></div>  
     <div id="container"></div> 
</div>
</div>
</div>
	</div>
</section>';
?>