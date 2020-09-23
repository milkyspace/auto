'use strict';
var anchorScroll = (function () {
    var init = function () {
        jQuery('.anchor-scroll').anchorScroll({
            scrollSpeed: 1000, // scroll speed
            offsetTop: 0, // offset for fixed top bars (defaults to 0)
            onScroll: function () {
                // callback on scroll start
            },
            scrollEnd: function () {
                // callback on scroll end
            }
        });
    };
    return {
        init: init,
    };
})();

var calculator = (function () {
    var init = function () {
        var $range1 = $(".js-range-slider-1");
        var $range2 = $(".js-range-slider-2");
        var $range3 = $(".js-range-slider-3");
        var $range4 = $(".js-range-slider-4");
        var v1 = 0;
        var v2 = 0;

        $range1.ionRangeSlider({
            skin: "round",
            type: "single",
            min: 0,
            max: 2000000,
            from: 1230380,
            hide_min_max: true,
            grid: false,
            onFinish: function (data) {
                v1 = data.from_pretty;
                jQuery('.sum_credit').html(v1);
                calc($range1.prop("value"), $range2.prop("value"));
            }
        });

        $range2.ionRangeSlider({
            skin: "round",
            type: "single",
            min: 0,
            max: 7,
            from: 3,
            hide_min_max: true,
            onFinish: function (data) {
                v2 = data.from_pretty;
                jQuery('.term_credit').html(v2);
                calc($range1.prop("value"), $range2.prop("value"));
            }
        });

        $range3.ionRangeSlider({
            skin: "round",
            type: "single",
            grid: false,
            min: 0,
            max: 2000000,
            from: 1230380,
            hide_min_max: true,
            onFinish: function (data) {
                v1 = data.from_pretty;
                jQuery('.sum_credit').html(v1);
                calc($range3.prop("value"), $range4.prop("value"));
            }
        });

        $range4.ionRangeSlider({
            skin: "round",
            type: "single",
            grid: false,
            min: 0,
            max: 7,
            from: 3,
            hide_min_max: true,
            onFinish: function (data) {
                v2 = data.from_pretty;
                jQuery('.term_credit').html(v2);
                calc($range3.prop("value"), $range4.prop("value"));
            }
        });

        function calc(a, b) {
            let p = 0,
                s = a,
                r = 0.01,
                n = b * 12;

            p = s * (r * (1 + r) ** n) / ((1 + r) ** n - 1)
            jQuery('.calc_result').html(p.toFixed());
            if((a == 0 && b != 0) || (a == 0 && b == 0)) {
                jQuery('.calc_result').html(0);
            }
            if(a != 0 && b == 0) {
                jQuery('.calc_result').html(a);
            }
        }

        jQuery('.minus.t-290').click(function (e) {
            e.preventDefault();
            if(parseInt($range4.prop("value")) > 0) {
                var instance = $('#js-range-slider-4').data("ionRangeSlider");
                instance.update({
                    from: (parseInt($range4.prop("value")) - 1)
                });
            }
            jQuery('.sum_credit').html($range3.prop("value"));
            jQuery('.term_credit').html($range4.prop("value"));
            calc($range3.prop("value"), $range4.prop("value"));
        })


        jQuery('.plus.t-290').click(function (e) {
            e.preventDefault();
            if(parseInt($range4.prop("value")) < 7) {
                var instance = $('#js-range-slider-4').data("ionRangeSlider");
                instance.update({
                    from: (parseInt($range4.prop("value")) + 1)
                });
            }
            jQuery('.sum_credit').html($range3.prop("value"));
            jQuery('.term_credit').html($range4.prop("value"));
            calc($range3.prop("value"), $range4.prop("value"));
        })

        jQuery('.minus.ones').click(function (e) {
            e.preventDefault();
            console.log($range3.prop("value"))
            if(parseInt($range3.prop("value")) > 0) {
                var instance = $('#js-range-slider-3').data("ionRangeSlider");
                instance.update({
                    from: (parseInt($range3.prop("value")) - 50000)
                });
            }
            jQuery('.sum_credit').html($range3.prop("value"));
            jQuery('.term_credit').html($range4.prop("value"));
            calc($range3.prop("value"), $range4.prop("value"));
        })


        jQuery('.plus.ones').click(function (e) {
            e.preventDefault();
            if(parseInt($range3.prop("value")) < 2000000) {
                var instance = $('#js-range-slider-3').data("ionRangeSlider");
                instance.update({
                    from: (parseInt($range3.prop("value")) + 50000)
                });
            }
            jQuery('.sum_credit').html($range3.prop("value"));
            jQuery('.term_credit').html($range4.prop("value"));
            calc($range3.prop("value"), $range4.prop("value"));
        })

    };
    return {
        init: init,
    };
})();

var formBottom = (function () {
    var sendForm = function () {

        var options = {
            success: showResponse,
            type: 'post',
            resetForm: true
        };

        jQuery('.search_form').ajaxForm(options);

        function showResponse(responseText, statusText, xhr, $form) {
            $('#modal-ok').modal();
        }

    };
    var mask = function () {

        var selector = document.getElementById("phone");
        var selector_modal = document.getElementById("phone-modal");

        var im = new Inputmask("+7 999-999-99-99");
        im.mask(selector);
        im.mask(selector_modal);

    };
    return {
        sendForm: sendForm,
        mask: mask,
    };
})();

var modal = (function () {
    var closeModal = function () {
        jQuery('.order').click(function () {
            $.modal.close();
        })
    };
    return {
        closeModal: closeModal,
    };
})();

$(function () {
    anchorScroll.init();
    calculator.init();
    formBottom.sendForm();
    formBottom.mask();
    modal.closeModal();
});
