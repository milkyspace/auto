<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<h2 class="connect-form-desktop_h2" style="">Отправьте заявку в 1 клик!</h2>
<!-- Form -->
<form id="modal-form-send" class="search_form connect-form-desktop_form" style="">
    <?= bitrix_sessid_post() ?>
    <div class="search_form_info connect-form-desktop_div" style="">
        <input type="text" name="form[name]" class="search_form_fild connect-form-desktop_fild" placeholder="Имя"
               required
               style="                                                                                                                                                                                                                  ">
        <input type="text" id="phone-modal" name="form[phone]" class="search_form_fild" placeholder="Номер телефона"
               required style="width: 100%;
    margin-right: 0;
    margin-bottom: 23px;">
        <div class="button_main" style="width: 100%;
    padding-top: 30px;">
            <button type="submit" class="search_form_submit" style="width: 100%">Отправить заявку<img
                        src="/local/asset/img/svg/send.svg"
                        class="button_send"></button>

            <h4 class="search_form_text h4-block">*Я даю согласие на обработку персональных данных
            </h4>
        </div>
    </div>
    <div class="block_info-check">
        <span>
            <img src="/local/asset/img/svg/suppot.svg" class="form_icon">
            <p class="form_text_icon">Бесплатно перезвоним и проконсультируем по всем вопросам Автокредитования</p>
        </span>
    </div>
    <p class="form_request"><span>Отправка заявки не обязывает
        Вас брать кредит</span></p>
</form>