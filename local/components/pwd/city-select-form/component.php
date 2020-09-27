<?php

/**
 * @var CMain $APPLICATION
 * @var CUser $USER
 * @var CDatabase $DB
 * @var CBitrixComponent $this
 * @var array $arParams
 * @var array $arResult
 * @var string $componentName
 * @var string $componentPath
 * @var string $componentTemplate
 * @var string $parentComponentName
 * @var string $parentComponentPath
 * @var string $parentComponentTemplate
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$result = \CIBlockElement::GetList(['NAME' => 'ASC'], [
    'IBLOCK_ID' => \Pwd\Entity\CityTable::getIblockId(),
    'ACTIVE' => 'Y',
], false, false, [
    'ID',
    'NAME',
    'CODE',
    'IBLOCK_ID',
    'PROPERTY_REGION',
]);

$arResult['ITEMS'] = [];
$arResult['ACTIVE_GROUP'] = null;

while ($row = $result->GetNext(false, false)) {
    $region = $row['PROPERTY_REGION_VALUE'];

    if (\in_array($region, ['Новосибирская область', 'Московская область'], true)) {
        $row['PROPERTY_REGION_VALUE'] = $region = 'Россия';
    }

    $primaryGroup = $region === 'Россия' ? $region : 'СНГ';
    $secondaryGroup = $region === 'Россия' ? \mb_strtolower(\mb_substr($row['NAME'], 0, 1)) : $region;

    $protocol = WEB_PROTOCOL;
    $code = $row['CODE'];
    $hostname = WEB_HOSTNAME;
    $uri = \explode('?', $arParams['REQUEST_URI'])[0];
    $url = "/{$code}";

    if (!empty($_GET['uri_city_code'])) {
        $cityCode = $_GET['uri_city_code'];
        $url = "/?uri_city_code={$code}";
    }

    $arResult['ITEMS'][$primaryGroup][$secondaryGroup][] = [
        'CODE' => $row['CODE'],
        'URL' => \strtr($url, [
            '://novosibirsk.' => '://',
            "{$hostname}/novosibirsk/" => "{$hostname}/",
        ]),
        'NAME' => $row['NAME'],
    ];

    if ($arParams['CURRENT_CITY_CODE'] === $row['CODE']) {
        $arResult['ACTIVE_GROUP'] = $primaryGroup;
    }
}

$this->includeComponentTemplate();
