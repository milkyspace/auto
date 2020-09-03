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
				calc();
			}
		});

		$range2.ionRangeSlider({
			skin: "round",
			type: "single",
			min: 0,
			max: 15,
			from: 8,
			hide_min_max: true,
			onFinish: function (data) {
				v2 = data.from_pretty;
				jQuery('.term_credit').html(v2);
				calc();
			}
		});

		function calc() {
			let p = 0,
				s = $range1.prop("value"),
				r = 0.01,
				n = $range2.prop("value") * 12;

			p = s * (r * (1 + r) ** n) / ((1 + r) ** n - 1)
			jQuery('.calc_result').html(p.toFixed());
		}
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
