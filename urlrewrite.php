<?php

$cityUriPrefix = '';

if (isset($_GET['uri_city_code'])) {
    $cityUriPrefix = "/{$_GET['uri_city_code']}";
}

$arUrlRewrite = array(
    0 =>
        array(
            'CONDITION' => "#^{$cityUriPrefix}/rest/#",
            'RULE' => '',
            'ID' => NULL,
            'PATH' => '/bitrix/services/rest/index.php',
            'SORT' => 100,
        ),
    1 =>
        array(
            'CONDITION' => "#^{$cityUriPrefix}/#",
            'RULE' => '',
            'ID' => NULL,
            'PATH' => '/index.php',
            'SORT' => 100,
        ),
);
