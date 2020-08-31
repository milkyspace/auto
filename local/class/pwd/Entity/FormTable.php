<?php

namespace Pwd\Entity;

use Bitrix\Main\SystemException;
use spaceonfire\BitrixTools\ORM\IblockElement;

/**
 * Class FormTable
 * @package Pwd\Entity
 */
class FormTable extends IblockElement
{
    public static function getIblockId(): int
    {
        return CONST_IBLOCK_ID_FORM;
    }

    /**
     * @param $id
     * @param $arfields
     * @param $propList
     * @return bool
     * @throws SystemException
     */
    public static function updateElement($id, $arfields, $propList)
    {
        $prop = array();
        foreach ($propList as $propName => $propVal) {
            $propId = FormTable::getPropertyIdByCode($propName);
            $prop[$propId] = $propVal;
        }

        $arfields['PROPERTY_VALUES'] = $prop;
        $arfields['MODIFIED_BY'] = 1;
        $arfields['IBLOCK_ID'] = CONST_IBLOCK_ID_FORM;

        $el = new \CIBlockElement;

        if ($resId = $el->Update($id, $arfields)) {
            return $resId;
        } else {
            throw new SystemException('Ошибка при обновлении элемента '.$id.': '.$el->LAST_ERROR);
        }
    }

    /**
     * @param $arfields
     * @param $propList
     * @return bool
     * @throws SystemException
     */
    public static function addElement($arfields, $propList)
    {
        $prop = array();
        foreach ($propList as $propName => $propVal) {
            $propId = FormTable::getPropertyIdByCode($propName);
            $prop[$propId] = $propVal;
        }

        $arCodeParams = array("replace_space" => "-", "replace_other" => "-");
        $arfields['CODE'] = \Cutil::translit($arfields['NAME'], "ru", $arCodeParams);

        $arfields['PROPERTY_VALUES'] = $prop;
        $arfields['MODIFIED_BY'] = 1;
        $arfields['IBLOCK_ID'] = CONST_IBLOCK_ID_FORM;

        $el = new \CIBlockElement;
        if ($resId = $el->Add($arfields)) {
            return $resId;
        } else {
            throw new SystemException('Ошибка при добавлении элемента '.$arfields['NAME'].': '.$el->LAST_ERROR);
        }
    }

}