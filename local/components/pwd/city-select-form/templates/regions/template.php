<?php

/**
 * @var CMain $APPLICATION
 * @var CUser $USER
 * @var CDatabase $DB
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 */

declare(strict_types=1);

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (\count($arResult['ITEMS']) === 0) {
    return;
}

global $CITY;

$citySelectTree = [];
$activeUrl = '';

foreach ($arResult['ITEMS'] as $groupName => $group) {
    foreach ($group as $subGroupName => $subGroup) {
        foreach ($subGroup as $item) {
            $url = str_replace('/regions/', '/', $item['URL']);

            if (empty(SUB_DOMAIN) && empty($arParams['URI_CITY_CODE'])) {
                $baseHostname = WEB_HOSTNAME;
                $baseHostnameQuote = \preg_quote($baseHostname, '#');

                $url = \preg_replace("#//(.+)\.{$baseHostnameQuote}#", "//{$baseHostname}/\$1", $url);
            }

            if ($CITY->fields['CODE'] === $item['CODE']) {
                $activeUrl = $url;
            }

            $citySelectTree[$groupName][$item['NAME']] = $url;
        }
    }
}

?>

<div class="section-city-select-regions">
    <?php foreach ($citySelectTree as $groupName => $groups): ?>
        <div class="group">
            <h2><?= $groupName; ?></h2>

            <div class="link-list">
                <ul>
                    <?php foreach ($groups as $cityName => $cityUrl) {
                        $classes = [];

                        if ($cityUrl === $activeUrl) {
                            $classes[] = 'active';
                        }

                        $linkClass = \count($classes) > 0 ? ' class="' . \implode(' ', $classes) . '"' : '';

                        echo "<li><a HREF=\"{$cityUrl}\"{$linkClass}>{$cityName}</a></li>";
                    } ?>
                </ul>
            </div>
        </div>
    <?php endforeach; ?>
</div>
