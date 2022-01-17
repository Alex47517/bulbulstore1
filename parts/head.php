<?php

if (!$title) {

	$title = 'BulBul';

}

echo '<meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">

    <title>'.$title.'</title>

    <link rel="shortcut icon" href="images/favicon.ico?v=2">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,600">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="//cdn.jsdelivr.net/jquery.touchswipe/1.6.5/jquery.touchSwipe.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-formhelpers/2.3.0/js/bootstrap-formhelpers.min.js" integrity="sha512-m4xvGpNhCfricSMGJF5c99JBI8UqWdIlSmybVLRPo+LSiB9FHYH73aHzYZ8EdlzKA+s5qyv0yefvkqjU2ErLMg==" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-formhelpers/2.3.0/css/bootstrap-formhelpers.css" integrity="sha512-UPFdMcy+35cR5gyOgX+1vkDEzlMa3ZkZJUdaI1JoqWbH7ubiS/mhGrcM5C72QYouc2EascN3UtUrYnPoUpk+Pg==" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/10.1.0/nouislider.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/10.1.0/nouislider.min.js"></script>    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css" integrity="sha512-UyNhw5RNpQaCai2EdC+Js0QL4RlVmiq41DkmCJsRV3ZxipG2L0HhTqIf/H9Hp8ez2EnFlkBnjRGJU2stW3Lj+w==" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.gstatic.com">

  <link href="https://fonts.googleapis.com/css2?family=Jura&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@900&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

      <link href="css/style.css?194" rel="stylesheet">

      <link href="css/media.css?191" rel="stylesheet">

      <script type="text/javascript" src="js/jquery.waterwheelCarousel.min.js"></script>

      <script type="text/javascript">

      $(document).ready(function () {

        var carousel = $("#carousel").waterwheelCarousel({

          flankingItems: 3,

          movingToCenter: function ($item) {

            $(\'#callback-output\').prepend(\'movingToCenter: \' + $item.attr(\'id\') + \'<br/>\');

          },

          movedToCenter: function ($item) {

            $(\'#callback-output\').prepend(\'movedToCenter: \' + $item.attr(\'id\') + \'<br/>\');

          },

          movingFromCenter: function ($item) {

            $(\'#callback-output\').prepend(\'movingFromCenter: \' + $item.attr(\'id\') + \'<br/>\');

          },

          movedFromCenter: function ($item) {

            $(\'#callback-output\').prepend(\'movedFromCenter: \' + $item.attr(\'id\') + \'<br/>\');

          },

          clickedCenter: function ($item) {

            $(\'#callback-output\').prepend(\'clickedCenter: \' + $item.attr(\'id\') + \'<br/>\');

          }

        });



        $(\'#prev\').bind(\'click\', function () {

          carousel.prev();

          return false

        });



        $(\'#next\').bind(\'click\', function () {

          carousel.next();

          return false;

        });



        $(\'#reload\').bind(\'click\', function () {

          newOptions = eval("(" + $(\'#newoptions\').val() + ")");

          carousel.reload(newOptions);

          return false;

        });



      });

    </script>

    <script src="//code.jivosite.com/widget/cU42A2hANm" async></script>

      ';