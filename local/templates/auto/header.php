<? use Bitrix\Main\Page\Asset;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?php global $CITY, $USER; ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NTNM485');</script>
    <!-- End Google Tag Manager -->

    <?php $APPLICATION->ShowHead(); ?>
    <meta charset="UTF-8">
    <meta name="mailru-domain" content="CKNKtjAKBGkSXtkc" />
    <link rel="stylesheet prefetch"
          href="https://cdn.rawgit.com/mfd/e7842774e037edf15919037594a79b2b/raw/665bdfc532094318449f1010323c84013d5af953/graphik.css">
    <title><?php $APPLICATION->ShowTitle(false); ?></title>
    <?php Asset::getInstance()->addCss("/local/asset/css/reset.css"); ?>
    <?php Asset::getInstance()->addCss("/local/asset/css/style.css"); ?>
    <?php Asset::getInstance()->addCss("/local/asset/node_modules/jquery-modal/jquery.modal.css"); ?>
    <?php Asset::getInstance()->addCss("/local/asset/node_modules/ion-rangeslider/css/ion.rangeSlider.css"); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/favicon.png">
    <?php CJSCore::Init(array("jquery")); ?>
    <?php Asset::getInstance()->addJs("/local/asset/js/jquery.anchorScroll.min.js"); ?>
    <?php Asset::getInstance()->addJs("/local/asset/node_modules/jquery-modal/jquery.modal.js"); ?>
    <?php Asset::getInstance()->addJs("/local/asset/node_modules/ion-rangeslider/js/ion.rangeSlider.js"); ?>
    <?php Asset::getInstance()->addJs("/local/asset/node_modules/inputmask/dist/jquery.inputmask.js"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
            integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn"
            crossorigin="anonymous"></script>
    <?php Asset::getInstance()->addJs("/local/asset/js/scripts.js"); ?>
</head>

<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NTNM485"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
<div class="site-container">
    <header class="header">
        <div class="container header_container flex">

            <div class="header_logo">
                <a href="/" class="header_logo-link">
                    <img src="/local/asset/img/svg/sd_icon.svg" alt="ICON" class="header_logo_pic">
                </a>
            </div>
            <div class="header_contact-mobile">
                <a href="#CITY_PHONE_MOBILE_LINK#">#CITY_PHONE_MOBILE#</a>
                <span>#CITY_ADDRESS_MOBILE#</span>
            </div>

            <div class="hamburger-menu">
                <input id="menu__toggle" type="checkbox" />
                <label class="menu__btn" for="menu__toggle">
                    <span></span>
                </label>
                <div class="icon menu__box">
                    <nav class="icon_city">
                        <img src="/local/asset/img/svg/city1.svg" class="icon_city1"><a href="#">Ваш город:</a>
                        <a href="#modal-city" rel="modal:open" data-role="city-select"><p class="nsk">#CITY_NAME# </p></a>
                    </nav>
                    <nav class="icon_geo">
                        <img src="/local/asset/img/svg/geo1.svg" class="icon_geo1">
                        <a href="#contacts" class="anchor-scroll">#CITY_ADDRESS#</a>
                    </nav>
                    <nav class="icon_call">
                        <img src="/local/asset/img/svg/call.svg" class="icon_call1"><a href="tel:#CITY_PHONE#">#CITY_PHONE#</a>
                    </nav>
                    <nav class="icon_number">
                        <!--					<a href="#modal-form" rel="modal:open" class="button">Заказать звонок</a>-->
                        <a href="#one_click" class="button anchor-scroll">Заказать звонок</a>
                        <!--                    <a href="#modal-form" rel="modal:open" class="button">Заказать звонок</a>-->
                    </nav>
                </div>
            </div>

            <div class="text_title-mobile">
                <span class="title-n1">Автокредит</span>
                <span class="title-n2">в #CITY_NAME_PRED#</span>
                <span class="title-n3">это просто!</span>
            </div>

            <div class="text_desc-mobile">
                <div>
                    <img src="/local/asset/img/svg/circle.svg" alt="">
                    <span>Одобрим за 15 минут!</span>
                </div>
                <div>
                    <img src="/local/asset/img/svg/circle.svg" alt="">
                    <span>На любое авто Б/у или Новое</span>
                </div>
                <div>
                    <img src="/local/asset/img/svg/circle.svg" alt="">
                    <span>9.9% минимальный годовой процент!</span>
                </div>
            </div>

            <div class="icon">
                <nav class="icon_city">
                    <img src="/local/asset/img/svg/city1.svg" class="icon_city1"><a href="#">Ваш город:</a>
                    <a href="#modal-city" rel="modal:open" data-role="city-select"><p class="nsk">#CITY_NAME# </p></a>
                </nav>
                <nav class="icon_geo">
                    <img src="/local/asset/img/svg/geo1.svg" class="icon_geo1">
                    <a href="#contacts" class="anchor-scroll">#CITY_ADDRESS#</a>
                </nav>
                <nav class="icon_call">
                    <img src="/local/asset/img/svg/call.svg" class="icon_call1"><a href="tel:#CITY_PHONE#">#CITY_PHONE#</a>
                </nav>
                <nav class="icon_number">
                    <!--					<a href="#modal-form" rel="modal:open" class="button">Заказать звонок</a>-->
                    <a href="#one_click" class="button anchor-scroll">Заказать звонок</a>
<!--                    <a href="#modal-form" rel="modal:open" class="button">Заказать звонок</a>-->
                </nav>
            </div>


        </div>
    </header>