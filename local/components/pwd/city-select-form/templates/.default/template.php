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

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (\count($arResult['ITEMS']) === 0) {
    return;
}

$lastLetter = '';

$citySelectTree = [];
$citySelectUrl = '';

foreach ($arResult['ITEMS'] as $groupName => $group) {
    foreach ($group as $subGroupName => $subGroup) {
        foreach ($subGroup as $item) {
            if ($item['CODE'] === $arParams['CURRENT_CITY_CODE']) {
                $citySelectUrl = $item['URL'];
            }

            $citySelectTree[$groupName][$subGroupName][] = [$item['NAME'], $item['URL']];
        }
    }
}

?>
<script>
    window.citySelectTree = <?= \json_encode($citySelectTree, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
    window.citySelectUrl = '<?= $citySelectUrl; ?>';
</script>
<div style="display: none;" id="modal-city">
    <div class="section-city-select-form">
            <form autocomplete="off">
                <?php if (\count($arResult['ITEMS']) > 1): ?>
                    <div class="form-group-switch">
                        <?php foreach (\array_keys($arResult['ITEMS']) as $i => $groupName): ?>
                            <?php
                            $checked = !empty($arResult['ACTIVE_GROUP']) ? $arResult['ACTIVE_GROUP'] === $groupName : $i === 0;
                            ?>

                            <input id="city-group-switch-<?= $i; ?>" name="group" type="radio"
                                   value="<?= $groupName; ?>" <?= $checked ? 'checked' : ''; ?>>
                            <label for="city-group-switch-<?= $i; ?>"><?= $groupName; ?></label>
                        <?php endforeach; ?>
                    </div>
                <?php elseif (\count($arResult['ITEMS']) === 1): ?>
                    <input type="hidden" name="group" value="<?= \array_keys($arResult['ITEMS'])[0]; ?>">
                <?php endif; ?>

            </form>
        <div class="content"></div>
    </div>
</div>


