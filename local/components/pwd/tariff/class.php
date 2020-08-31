<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Pwd\Entity\TariffTable;

class TariffComponent extends CBitrixComponent
{
    /**
     * Обработка входных параметров
     * @param mixed[] $arParams
     * @return mixed[] $arParams
     */
    public function onPrepareComponentParams($arParams)
    {
        return $arParams;
    }

    /**
     * Достаем ссылки для редактирвоания
     * @param $arItem
     */
    protected function addEditLinkEl(&$arItem)
    {
        $arButtons = CIBlock::GetPanelButtons(
            $arItem['IBLOCK_ID'],
            $arItem['ID'],
            0,
            [
                'SECTION_BUTTONS' => false,
                'SESSID' => false
            ]
        );
        $arItem['ADD_LINK'] = $arButtons['edit']['add_element']['ACTION_URL'];
        $arItem['EDIT_LINK'] = $arButtons['edit']['edit_element']['ACTION_URL'];
        $arItem['DELETE_LINK'] = $arButtons['edit']['delete_element']['ACTION_URL'];
    }

    /**
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function getResult()
    {
        $arElements = TariffTable::getList([
            'select' => [
                '*',
                'EMAIL' => 'PROPERTY_SIMPLE.EMAIL',
                'SIZE' => 'PROPERTY_SIMPLE.SIZE',
                'CAL_CONT' => 'PROPERTY_SIMPLE.CAL_CONT',
                'SKYPE' => 'PROPERTY_SIMPLE.SKYPE',
                'PROTOCOLS' => 'PROPERTY_SIMPLE.PROTOCOLS',
                'OWA' => 'PROPERTY_SIMPLE.OWA',
                'AS' => 'PROPERTY_SIMPLE.AS',
                'MESS' => 'PROPERTY_SIMPLE.MESS',
                'AU_VI' => 'PROPERTY_SIMPLE.AU_VI',
                'PRICE' => 'PROPERTY_SIMPLE.PRICE',
                'LINK' => 'PROPERTY_SIMPLE.LINK',
            ],
            'order' => [
                'SORT' => 'ASC',
            ],
        ])->fetchAll();
        foreach ($arElements as &$item) {
            $this->addEditLinkEl($item);
            unset($item);
        }
        $this->arResult['ITEMS'] = $arElements;
    }

    /**
     * выполняет логику работы компонента
     * @return void
     */
    public function executeComponent()
    {
        try {
            if ($this->StartResultCache($this->arParams["CACHE_TIME"])) {
                $this->getResult();
                $this->includeComponentTemplate();
            }
        } catch (Exception $e) {
            ShowError($e->getMessage());
        }
    }
}

?>
