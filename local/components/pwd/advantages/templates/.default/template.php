<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult["SMALL"]) || !empty($arResult["BIG"])) { ?>
    <? $this->AddEditAction('addblock', $arResult["SMALL"][0]['ADD_LINK'], 'Добавить'); ?>
    <section class="sec-2" id="id_1">
        <div class="container" id="<?= $this->GetEditAreaId('addblock'); ?>">
            <div class="b-inf">
                <h2 class="h2 b-inf__h2"><?= $arParams['TEXT_TITLE'] ?><span
                            class="blue-text font-black"> <?= $arParams['TEXT_TITLE_C'] ?></span></h2>
                <div class="b-inf__txt">
                    <div class="b-inf__desc">
                        <?= $arParams['TEXT_DESC'] ?>
                    </div>
                    <ul class="list-gal b-inf__list">
                        <? foreach ($arResult["SMALL"] as $k => $arItem) { ?>
                            <?
                            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], 'Изменить ' . $arItem['NAME']);
                            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], 'Удалить ' . $arItem['NAME'], array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                            ?>
                            <li id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                                <?= $arItem['NAME'] ?>
                            </li>
                        <? } ?>
                    </ul>
                    <a class="btn-blue b-inf__btn yakor yakor"
                       href="<?= $arParams['LINK_BUTTON'] ?>"><?= $arParams['TEXT_BUTTON'] ?></a>
                </div>
                <div class="ico-list b-inf__ico-list">
                    <? foreach ($arResult["BIG"] as $k => $arItem) { ?>
                        <?
                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], 'Изменить ' . $arItem['NAME']);
                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], 'Удалить ' . $arItem['NAME'], array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                        ?>
                        <div class="ico-list__item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                            <div class="ico-list__ico">
                                <svg class="icon icon-i-<?= $k + 1 ?> ico-list__svg ico-list__svg--<?= $k + 1 ?>">
                                    <use xlink:href="<?= $arItem['IMAGE'] . $arItem['SVG'] ?>"></use>
                                </svg>
                            </div>
                            <p>
                                <?= $arItem['NAME'] ?>
                            </p>
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>
    </section>
<? } ?>