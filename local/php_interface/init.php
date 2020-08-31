<?php
/**
 * PWD
 */

require_once $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php';


global $APPLICATION, $DB, $CITY, $CITY_DETECTION, $CITY_ADDRESS, $CITY_URI_PREFIX, $SEO_CONTENT;
$SEO_CONTENT = [];
$CITY = null;
$CITY_URI_PREFIX = '';

if (isset($_GET['uri_city_code'])) {
    $CITY_URI_PREFIX = "/{$_GET['uri_city_code']}";
}


$cityObject = \CIBlockElement::GetList([], [
    'IBLOCK_ID' => \Pwd\Entity\CityTable::getIblockId(),
    'CODE' => $_GET['uri_city_code'] ?? 'novosibirsk',
], false, false, []);

if ($cityObject->SelectedRowsCount() === 0) {
    \AddEventHandler('main', 'OnProlog', static function () {
        global $APPLICATION, $CITY;

        $CITY = null;

        $APPLICATION->RestartBuffer();

        \CHTTP::SetStatus('404 Not Found');
        @\define('ERROR_404', 'Y');

        echo 'File not found.';

        exit;
    });

    return;
}

$CITY = $cityObject->GetNextElement(false, false);
$CITY_DETECTION = $_COOKIE['city_detection'] ?: null;

if ($CITY->fields['CODE'] === 'novosibirsk') {
    if (!empty($_GET['uri_city_code'])) {
        $url = \str_replace('/novosibirsk/', '/'. $_SERVER['REQUEST_URI']);

        LocalRedirect($url);
    }
}

$CITY_ADDRESS = $CITY->GetProperties()['ADDRESS']['VALUE'];

if ($_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
    if ($CITY_DETECTION === null) {
        $CITY_DETECTION = 'unknown';
    } elseif ($CITY_DETECTION === 'unknown') {
        $CITY_DETECTION = 'checked';
    }

    \setcookie('city_detection', $CITY_DETECTION, \strtotime('today +1 year'), '/', 'auto');
}

?>