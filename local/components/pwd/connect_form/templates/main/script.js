'use strict';
var formFeedbackMain = (function () {
    //Отправка формы
    var sendForm = function () {
        let $form = jQuery('form#main-form-send');
        let modalOk = jQuery('#modal-ok');

        $form.on('submit', function (e) {
            e.preventDefault();

            let $this = jQuery(this),
                formData = new FormData(this);

            BX.ajax.runComponentAction('pwd:connect_form',
                'add', { // Вызывается без постфикса Action
                    mode: 'class',
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    data: formData
                })
                .then(function (data) {
                    if (data.data.status_check == true) {
                        $.modal.close();
                        modalOk.modal();
                        document.getElementById('main-form-send').reset();
                    }
                });
        });
    };

    return {
        sendForm: sendForm,
    };
})();

jQuery(function () {
    formFeedbackMain.sendForm();
});
