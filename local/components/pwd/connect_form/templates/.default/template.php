<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<h2>Отправьте заявку в 1 клик!</h2>
<!-- Form -->
<form id="modal-form-send" class="search_form">
    <?= bitrix_sessid_post() ?>
    <div class="search_form_info">
        <input type="text" name="form[name]" class="search_form_fild" placeholder="Имя" required>
        <input type="text" id="phone-modal" name="form[phone]" class="search_form_fild" placeholder="Номер телефона" required>
        <div class="button_main">
            <button type="submit" class="search_form_submit">Отправить заявку<img
                        src="/local/assets/img/svg/send.svg"
                        class="button_send"></button>

            <h4 class="search_form_text">*Я даю согласие на обработку персональных данных
            </h4>
        </div>

    </div>
</form>
<img src="/local/assets/img/svg/suppot.svg" class="form_icon">
<p class="form_text_icon">Бесплатно перезвоним и проконсультируем по всем вопросам Автокредитования</p>
<p class="form_request">Отправка заявки не обязывает
    Вас брать кредит</p>