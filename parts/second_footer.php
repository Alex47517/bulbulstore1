<?php
$category = array_values(R::getAll('SELECT * FROM categorys'));
$categorys = null;
for ($i=0; $category[$i]; $i++) { 
  $categorys .= '<li class="nav-item py-2">
                  <a class="nav-link px-0 footer-info" href="/category.php?type='.$category[$i]['url_name'].'">'.$category[$i]['name'].'</a>
                </li>';
}
echo '<section id="second-footer">
  <div class="container">
    <div class="row py-5">
    <div class="col-12 col-md-4 ">
    <p class="footer-info">
    Добро пожаловать!<br>
     Меня зовут Егор, я Владелец магазина «Буль-Буль»<br>

Местоположение: город Сумы, но отправки по всей Украине.<br>

Чтобы больше узнать чем я занимаюсь, следите за страницей в <a class="footer-info" href="https://instagram.com/bulbul_ua?igshid=pyn3a0helo0q">Инстаграм ❤️</a><br>

На сайте представлены ТОЛЬКО Фото-ОТЗЫВЫ КЛИЕНТОВ. Чтобы Вы сразу увидели каждую мойку в рабочем виде!  А их уже более 1000 🔥<br>

Искренне надеюсь, что Вы это оцените !<br>

А если Вы ещё не посмотрели Краш-Тесты, то многое потеряли, очень советую обратить на них ВНИМАНИЕ! <br>
Уверен что подниму Вам настроение!)<br>

По сайту мне помогает Администратор - Виктория 👩‍💼 <br>

Можете писать в любое удобное для Вас время. <br>
Контактный номер – <a class="footer-info" href="tel:+380666053892" target="_blank">+380 66 605 3892</a><br>
Пишите в Вайбере или звоните 📞<br>
E-mail: <a class="footer-info" href="mailto:bulbul.ua21@gmail.com" target="_blank">bulbul.ua21@gmail.com</a>
</p>
  </div>
      <div class="col-12 col-md-5 pt-5 pt-md-0 align-self-start">
        <p class="footer-text">
          © “Буль-Буль” 2000 - 2021
        </p>
        <p class="footer-text">Режим работы оффлайн Магазина BulBul:<br/>
Пн-Пт: 11:00-19:00<br/>
Сб-Вс: 10:00-1700</p>
        <a class="footer-text" href="https://goo.gl/maps/6Kj5CNYXusG7bD6K8" target="_blank">г. Киев, ул. Саксаганского, 110</a>
      </div>
<div class="d-none d-md-block col-md-3">
<h3 class="footer-text w-100">Категории товаров:</h3><br>
<ul class="nav flex-column">
  '.$categorys.'
</ul>
</div>
    </div>
  </div>
</section>
<section id="credits">
<div class="credits py-3">
<span>Site created by</span>
<img src="images/itsa-logo.png">
</div>
</section>
';
?>