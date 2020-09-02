<?php

use Pwd\Entity\TariffTable;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult["ITEMS"])) { ?>
    <? $this->AddEditAction('addblock', $arResult["ITEMS"][0]['ADD_LINK'], 'Добавить'); ?>
    <section class="sec-3">
        <div class="container" id="<?= $this->GetEditAreaId('addblock'); ?>">
            <div class="c-tarif" id="id_2">
                <div class="c-tarif-header">
                    <div class="c-tarif-header__title">
                        <h2 class="h2 c-tarif__h2">
                            <?= $arParams['TEXT_TITLE'] ?> <span
                                    class="blue-text font-black"><?= $arParams['TEXT_TITLE_C'] ?></span>
                        </h2>
                    </div>
                    <div class="c-tarif-header__desc">
                        <?= $arParams['TEXT_DESC'] ?>
                    </div>
                </div>
                <div class="responsive-table">
                    <table class="table-tarif">
                        <thead>
                        <tr>
                            <th>Тарифы</th>
                            <? foreach ($arResult["ITEMS"] as $k => $arItem) { ?>
                                <?
                                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], 'Изменить ' . $arItem['NAME']);
                                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], 'Удалить ' . $arItem['NAME'], array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                                ?>
                                <th id="<?= $this->GetEditAreaId($arItem['ID']); ?>"><?= $arItem['NAME'] ?></th>
                            <? } ?>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Корпоративная почта</td>
                            <? foreach ($arResult["ITEMS"] as $k => $arItem) {
                                switch (TariffTable::getXmlIdById($arItem['EMAIL'], 'EMAIL')) {
                                    case 'y':
                                        $check = 'tick';
                                        $class = 'gal';
                                        $icon = 'icon-tick';
                                        $svg = 'gal__svg';
                                        break;
                                    default:
                                        $check = 'close_big';
                                        $class = 'cross';
                                        $icon = 'icon-close_big';
                                        $svg = 'cross__svg';
                                        break;
                                } ?>
                                <td>
                                    <span class="<?= $class ?>">
                                        <svg class="icon <?= $icon ?> <?= $svg ?>">
                                          <use xlink:href="/local/asset/app/img/svg-sprite/sprite.svg#<?= $check ?>"></use>
                                        </svg>
                                    </span>
                                </td>
                            <? } ?>
                        </tr>
                        <tr>
                            <td>Размер почтового ящика *</td>
                            <? foreach ($arResult["ITEMS"] as $k => $arItem) { ?>
                                <td><?= $arItem['SIZE'] ?></td>
                            <? } ?>
                        </tr>
                        <tr class="hidden-row">
                            <td>Протоколы POP3/IMAP/MAPI</td>
                            <? foreach ($arResult["ITEMS"] as $k => $arItem) { ?>
                                <td><?= $arItem['PROTOCOLS'] ?></td>
                            <? } ?>
                        </tr>
                        <tr class="hidden-row">
                            <td>Веб-интерфейс OWA (Outlook Web App)</td>
                            <? foreach ($arResult["ITEMS"] as $k => $arItem) {
                                switch (TariffTable::getXmlIdById($arItem['OWA'], 'OWA')) {
                                    case 'y':
                                        $check = 'tick';
                                        $class = 'gal';
                                        $icon = 'icon-tick';
                                        $svg = 'gal__svg';
                                        break;
                                    default:
                                        $check = 'close_big';
                                        $class = 'cross';
                                        $icon = 'icon-close_big';
                                        $svg = 'cross__svg';
                                        break;
                                } ?>
                                <td>
                                    <span class="<?= $class ?>">
                                        <svg class="icon <?= $icon ?> <?= $svg ?>">
                                          <use xlink:href="/local/asset/app/img/svg-sprite/sprite.svg#<?= $check ?>"></use>
                                        </svg>
                                    </span>
                                </td>
                            <? } ?>
                        </tr>
                        <tr class="hidden-row">
                            <td>Синхронизация данных на всех устройствах (Active Sync)</td>
                            <? foreach ($arResult["ITEMS"] as $k => $arItem) {
                                switch (TariffTable::getXmlIdById($arItem['AS'], 'AS')) {
                                    case 'y':
                                        $check = 'tick';
                                        $class = 'gal';
                                        $icon = 'icon-tick';
                                        $svg = 'gal__svg';
                                        break;
                                    default:
                                        $check = 'close_big';
                                        $class = 'cross';
                                        $icon = 'icon-close_big';
                                        $svg = 'cross__svg';
                                        break;
                                } ?>
                                <td>
                                    <span class="<?= $class ?>">
                                        <svg class="icon <?= $icon ?> <?= $svg ?>">
                                          <use xlink:href="/local/asset/app/img/svg-sprite/sprite.svg#<?= $check ?>"></use>
                                        </svg>
                                    </span>
                                </td>
                            <? } ?>
                        </tr>
                        <tr class="bg-white">
                            <td>Календари и контакты</td>
                            <? foreach ($arResult["ITEMS"] as $k => $arItem) { ?>
                                <td>
                                    <?= $arItem['CAL_CONT']['TEXT'] ?>
                                </td>
                            <? } ?>
                        </tr>
                        <tr class="hidden-row">
                            <td>Мгновенные сообщения</td>
                            <? foreach ($arResult["ITEMS"] as $k => $arItem) {
                                switch (TariffTable::getXmlIdById($arItem['MESS'], 'MESS')) {
                                    case 'y':
                                        $check = 'tick';
                                        $class = 'gal';
                                        $icon = 'icon-tick';
                                        $svg = 'gal__svg';
                                        break;
                                    default:
                                        $check = 'close_big';
                                        $class = 'cross';
                                        $icon = 'icon-close_big';
                                        $svg = 'cross__svg';
                                        break;
                                } ?>
                                <td>
                                    <span class="<?= $class ?>">
                                        <svg class="icon <?= $icon ?> <?= $svg ?>">
                                          <use xlink:href="/local/asset/app/img/svg-sprite/sprite.svg#<?= $check ?>"></use>
                                        </svg>
                                    </span>
                                </td>
                            <? } ?>
                        </tr>
                        <tr class="hidden-row">
                            <td>Аудио-, видео- и веб-конференции</td>
                            <? foreach ($arResult["ITEMS"] as $k => $arItem) {
                                switch (TariffTable::getXmlIdById($arItem['AU_VI'], 'AU_VI')) {
                                    case 'y':
                                        $check = 'tick';
                                        $class = 'gal';
                                        $icon = 'icon-tick';
                                        $svg = 'gal__svg';
                                        break;
                                    default:
                                        $check = 'close_big';
                                        $class = 'cross';
                                        $icon = 'icon-close_big';
                                        $svg = 'cross__svg';
                                        break;
                                } ?>
                                <td>
                                    <span class="<?= $class ?>">
                                        <svg class="icon <?= $icon ?> <?= $svg ?>">
                                          <use xlink:href="/local/asset/app/img/svg-sprite/sprite.svg#<?= $check ?>"></use>
                                        </svg>
                                    </span>
                                </td>
                            <? } ?>
                        </tr>
                        <tr>
                            <td>Общение через сеть Skype</td>
                            <? foreach ($arResult["ITEMS"] as $k => $arItem) {
                                switch (TariffTable::getXmlIdById($arItem['SKYPE'], 'SKYPE')) {
                                    case 'y':
                                        $check = 'tick';
                                        $class = 'gal';
                                        $icon = 'icon-tick';
                                        $svg = 'gal__svg';
                                        break;
                                    default:
                                        $check = 'close_big';
                                        $class = 'cross';
                                        $icon = 'icon-close_big';
                                        $svg = 'cross__svg';
                                        break;
                                } ?>
                                <td>
                                    <span class="<?= $class ?>">
                                        <svg class="icon <?= $icon ?> <?= $svg ?>">
                                          <use xlink:href="/local/asset/app/img/svg-sprite/sprite.svg#<?= $check ?>"></use>
                                        </svg>
                                    </span>
                                </td>
                            <? } ?>
                        </tr>
                        <tr class="btn-table-row">
                            <td colspan="4"><a class="more-btn" id="show-table-row" href="javascript: void(0);">Развернуть
                                    тарифы
                                    <svg class="icon icon-arrow_down more-btn__svg">
                                        <use xlink:href="/local/asset/app/img/svg-sprite/sprite.svg#arrow_down"></use>
                                    </svg>
                                </a></td>
                        </tr>
                        </tbody>
                        <tfoot class="change-color">
                        <tr>
                            <td></td>
                            <? foreach ($arResult["ITEMS"] as $k => $arItem) { ?>
                                <td><?= $arItem['PRICE'] ?></td>
                            <? } ?>
                        </tr>
                        <tr>
                            <td></td>
                            <? foreach ($arResult["ITEMS"] as $k => $arItem) { ?>
                                <td>
                                    <a class="btn-border-blue table-tarif__btn modal-link" href="#consult"
                                       data-name="<?= $arItem['NAME'] ?>">Заказать</a>
                                </td>
                            <? } ?>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                 <? $APPLICATION->IncludeComponent(
            "pwd:tariff.calc",
            ".default",
                [
                        'CLASS_WRAPER' => 'c-tarif__btn-row',
                ]); ?>
            </div>
        </div>
    </section>
<? } ?>