<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<h3 class="request_text">Оставьте заявку, чтобы получить бесплатную консультацию</h3>
<img id="one_click" src="/local/asset/img/svg/boy.svg" class="boy_pic" style="float: right ;
margin: -195px -6px 0px 0px;">
<!-- Form -->
<form id="main-form-send" class="search_form">
    <?= bitrix_sessid_post() ?>
    <div class="search_form_info">
        <div class="search_form_info">
            <input type="text" name="form[name]" class="search_form_fild" placeholder="Имя" required>
            <input type="text" id="phone" name="form[phone]" class="search_form_fild" placeholder="Номер телефона"
                   required>
            <div class="button_main">
                <button type="submit" class="search_form_submit">Отправить заявку<img
                            src="/local/asset/img/svg/send.svg"
                            class="button_send"></button>

                <h4 class="search_form_text">*Я даю согласие на обработку персональных данных
                </h4>
            </div>
        </div>
    </div>
        <img id="one_click" src="/local/asset/img/svg/boy.svg" class="boy_pic mobile_boy_pic">
</form>