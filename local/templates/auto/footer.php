<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var \CMain $APPLICATION
 * @var \_CIBElement $CITY
 */

global $CITY, $USER;

?>
<section class="footer">
    <div class="container">
        <img src="/local/asset/img/svg/logo_end.svg" class="logo_end">
        <h4 class="footer_ooo">ОГРН 1195476042651 ИНН 5405042720
            © ООО «СД-АВТО» 2020 г. </h4>
        <p class="footer_text">Обращаем ваше внимание на то, что данный интернет-сайт носит исключительно информационный
            характер и ни при каких условиях не является публичной офертой, определяемой положениями ч. 2 ст. 437
            Гражданского кодекса Российской Федерации. Все персональные данные не подлежат передачи третьим лицам и
            защищены федеральным законом Российской Федерации от 27 июля 2006 г. № 152-ФЗ.</p>
        <p class="footer_text">
            ООО "АвтоМолл" ОГРН 1195476042651 Банк-партнер: "Тинькофф Банк" (АО), Лицензия на осуществление банковских
            операций № 2673 от 24.03.2015 , Учётный номер в Росфинмониторинге: 704012178</p>
        <p class="footer_text">
            Copyrights © 2017 All Rights Reserved Inc.</p>
        <a href="/local/doc/dogovor-bank.pdf" class="footer_doc" target="_blank">Агентский договор</a>
        <a href="/local/doc/litsenzia_Tinkoff.pdf" class="footer_doc footer_marg" target="_blank">Лицензия</a>
    </div>

</section>
</main>
</div>
</body>
<div style="display: none;" id="modal-form">
    <? $APPLICATION->IncludeComponent("pwd:connect_form", "", []); ?>
</div>
<!-- Modal free -->
<div style="display: none;" id="modal-free">
    <div class="modal-free-title">
        <h2>Бесплатно подберем автомобиль по вашим параметрам в лучшем состоянии!</h2>
    </div>
    <div class="modal-free-list">
        <img src="/local/asset/img/mod_1.png" class="form_icon">
        <p class="form_text_icon">Вы уже выбрали или выбираете нужный вам автомобиль, в автосалоне или на сайтах drom.ru
            /
            auto.ru и т.д.
        </p>
    </div>
    <div class="modal-free-list">
        <img src="/local/asset/img/mod_2.png" class="form_icon form_icon_second">
        <p class="form_text_icon form_text_icon_second">Наш специалист готов выехать и провести осмотр, показывая вам
            все
            дефекты и недочеты,
            чтобы обезопасить вас от выбора некачественного авто.</p>
    </div>
    <div class="botton_green_first">
        <div class="modal-free-button">
            <a href="#one_click" class="anchor-scroll button_first order">Заказать бесплатный подбор</a>
        </div>
    </div>
</div>
<div style="display: none;" id="modal-ok">
    <h2 style="text-align: center;
    font-size: 18px; padding: 10px 0 0 0;">Спасибо!</h2>
    <p style="text-align: center;
    font-size: 16px; padding: 15px;">Заявка отправлена</p>
</div>


<?php
$APPLICATION->IncludeComponent('pwd:city-select-form', '', [
    'CURRENT_CITY_CODE' => $CITY->fields['CODE'],
    'REQUEST_URI' => $_SERVER['REQUEST_URI'],
]); ?>
</html>
