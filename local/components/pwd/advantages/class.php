<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Pwd\Entity\AdvantagesTable;

class AdvantagesComponent extends CBitrixComponent
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
        $arElements = AdvantagesTable::getList([
            'select' => [
                '*',
                'IMAGE' => 'PROPERTY_SIMPLE.IMAGE',
                'TYPE' => 'PROPERTY_SIMPLE.TYPE',
                'SVG' => 'PROPERTY_SIMPLE.SVG',
            ],
            'order' => [
                'SORT' => 'ASC',
            ],
        ])->fetchAll();

        foreach ($arElements as &$arRow) {
            $this->addEditLinkEl($arRow);
            switch (AdvantagesTable::getXmlIdById($arRow['TYPE'], 'type')) {
                case 'small':
                    $this->arResult['SMALL'][] = $arRow;
                    break;
                case 'big':
                    $arRow['IMAGE'] = \CFile::GetPath($arRow['IMAGE']);
                    $this->arResult['BIG'][] = $arRow;
                    break;
            }
            unset($item);
        }
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
