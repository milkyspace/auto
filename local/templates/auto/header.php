<? use Bitrix\Main\Page\Asset;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?php global $CITY, $USER; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php $APPLICATION->ShowHead(); ?>
    <meta charset="UTF-8">
    <link rel="stylesheet prefetch"
          href="https://cdn.rawgit.com/mfd/e7842774e037edf15919037594a79b2b/raw/665bdfc532094318449f1010323c84013d5af953/graphik.css">
    <title><?php $APPLICATION->ShowTitle(false); ?></title>
    <?php Asset::getInstance()->addCss("/local/assets/css/reset.css"); ?>
    <?php Asset::getInstance()->addCss("/local/assets/css/style.css"); ?>
    <?php Asset::getInstance()->addCss("/local/assets/node_modules/jquery-modal/jquery.modal.css"); ?>
    <?php Asset::getInstance()->addCss("/local/assets/node_modules/ion-rangeslider/css/ion.rangeSlider.css"); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php CJSCore::Init(array("jquery")); ?>
    <?php Asset::getInstance()->addJs("/local/assets/js/jquery.anchorScroll.min.js"); ?>
    <?php Asset::getInstance()->addJs("/local/assets/node_modules/jquery-modal/jquery.modal.js"); ?>
    <?php Asset::getInstance()->addJs("/local/assets/node_modules/ion-rangeslider/js/ion.rangeSlider.js"); ?>
    <?php Asset::getInstance()->addJs("/local/assets/node_modules/inputmask/dist/jquery.inputmask.js"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
            integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn"
            crossorigin="anonymous"></script>
    <?php Asset::getInstance()->addJs("/local/assets/js/scripts.js"); ?>
</head>

<body>
<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
<div class="site-container">
    <header class="header">
        <div class="container header_container flex">

            <div class="header_logo">
                <a href="/" class="header_logo-link">
                    <img src="/local/assets/img/svg/sd_icon.svg" alt="ICON" class="header_logo_pic">
                </a>
            </div>
            <div class="icon">


                <nav class="icon_city">
                    <img src="/local/assets/img/svg/city1.svg" class="icon_city1"><a href="#">Ваш город:</a>
                    <a href="#modal-city" rel="modal:open" data-role="city-select"><p class="nsk"><?=$CITY->fields['NAME']?> </p></a>
                </nav>
                <nav class="icon_geo">
                    <img src="/local/assets/img/svg/geo1.svg" class="icon_geo1">
                    <a href="#contacts" class="anchor-scroll">ул. Кирова 113/3 офис 311</a>
                </nav>
                <nav class="icon_call">
                    <img src="/local/assets/img/svg/call.svg" class="icon_call1"><a href="tel:83832479777">8(383)247-9-777</a>
                </nav>
                <nav class="icon_number">
                    <!--					<a href="#modal-form" rel="modal:open" class="button">Заказать звонок</a>-->
                    <a href="#one_click" class="button anchor-scroll">Заказать звонок</a>
<!--                    <a href="#modal-form" rel="modal:open" class="button">Заказать звонок</a>-->
                </nav>

            </div>


        </div>
    </header>