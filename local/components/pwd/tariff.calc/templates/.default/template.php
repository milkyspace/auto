<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;

$asset = \Bitrix\Main\Page\Asset::getInstance();
$asset->addJs($this->GetFolder().'/tariff-calc/dist/js/chunk-vendors.js');
$asset->addJs($this->GetFolder().'/tariff-calc/dist/js/app.js');
$asset->addCss($this->GetFolder().'/tariff-calc/dist/css/app.css');

?>

<div class="c-tarif__btn-row"><a class="btn-blue c-tarif__btn-calc" href="#" data-target="#modal-1" data-toggle="modal"><?=Loc::getMessage('CALAC_BTN_NAME')?></a></div>
<div class="modal scroll fade" id="modal-1" tabindex="-1">
    <div class="modal-calc">
        <button class="close-modal" type="button" data-dismiss="modal">
            <svg class="icon icon-close_big close-modal__ico">
                <use xlink:href="/local/asset/build/img/svg-sprite/sprite.svg#close_big"></use>
            </svg>
        </button>
        <div class="modal-calc__title"><?=Loc::getMessage('CALAC_NAME_MODAL_FIRST')?> <span class="blue-text font-black"><?=Loc::getMessage('CALAC_NAME_MODAL_SECOND')?></span></div>
        <form action="" method="" id="vue-calc-container">
        </form>
    </div>
</div>
