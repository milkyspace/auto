<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<section class="sec-4">
    <div class="container">
        <div class="b-tarif">
            <div class="b-tarif__pic">
                <div class="b-tarif__pic__title">
                    <?= $arParams['TEXT_IMG_1'] ?>
                    <span class="bold">
                    <?= $arParams['TEXT_IMG_2'] ?>
                </span>
                </div>
                <p>
                    <?= $arParams['TEXT_IMG_3'] ?>
                </p><a class="btn-border-white b-tarif__pic__btn yakor" href="#" data-target="#modal-2" data-toggle="modal"><?= $arParams['TEXT_BUTTON'] ?></a>
            </div>

            <div class="b-tarif__txt">
                <div class="b-tarif__desc"><?= $arParams['TEXT_TITLE_PRE'] ?></div>
                <h3 class="h3 b-tarif__h3">«<?= $arParams['TEXT_TITLE'] ?>» <span
                            class="blue-text font-black"><?= $arParams['TEXT_TITLE_PRICE'] ?></span>
                </h3>
                <ul class="lisct-circle b-tarif__list">
                    <li><?= $arParams['PROP1'] ?></li>
                    <li><?= $arParams['PROP2'] ?></li>
                    <li><?= $arParams['PROP3'] ?></li>
                    <li><?= $arParams['PROP4'] ?></li>
                </ul>
                <a class="btn-blue b-tarif__btn yakor modal-link" href="<?=$arParams['BUTTON_LINK']?>"
                   data-name="<?= $arParams['TEXT_TITLE'] ?>">Заказать</a>
            </div>
        </div>
    </div>
</section>