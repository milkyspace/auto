<?php

use \Pwd\Entity\CityTable;

/**
 * PWD
 */

require_once $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php';


if (isset($_GET['uri_city_code'])) {
    $CITY_URI_PREFIX = "/{$_GET['uri_city_code']}";
}

$userAgent = $_SERVER['HTTP_USER_AGENT'] ? \mb_strtolower($_SERVER['HTTP_USER_AGENT']) : '';

$IS_BOT = $IS_BOT || (\preg_match('#(mauibot|mj12bot|semrushbot|ahrefsbot|blexbot|serpstatbot|seznambot|nimbostratus-bot|sogou web spider)#', $userAgent) > 0);
$IS_BOT = $IS_BOT || (\preg_match('#(bingbot|googlebot|dotbot|mail\.ru_bot|yadirectfetcher|applebot)#', $userAgent) > 0);
$IS_BOT = $IS_BOT || (\preg_match('#yandex(bot|images|turbo|accessibilitybot|mobilebot|market)#', $userAgent) > 0);

$CITY_DETECTION = $_COOKIE['city_detection'] ?: null;
if ($CITY_DETECTION == 'unknown') {
    $CITY_DETECTION = null;
}
$cityObject = \CIBlockElement::GetList([], [
    'IBLOCK_ID' => CityTable::getIblockId(),
    'CODE' => $CITY_DETECTION ?? $_GET['uri_city_code'] ?? 'novosibirsk',
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

if ($CITY->fields['CODE'] === 'novosibirsk') {
    if (!empty($_GET['uri_city_code'])) {
        $url = \str_replace('/novosibirsk/', '/', $_SERVER['REQUEST_URI']);
    }
} elseif ($CITY->fields['ACTIVE'] === 'N') {
    $url = WEB_PROTOCOL . '://' . WEB_HOSTNAME;
    $uriParts = \explode('?', $_SERVER['REQUEST_URI']);
    $uri = $uriParts[0];
    $query = !empty($uriParts[1]) ? "?{$uriParts[1]}" : '';

    if (!empty($_GET['uri_city_code'])) {
        $uri = \str_replace("/{$_GET['uri_city_code']}/", '/', $uri);
    }

    switch (true) {
        case $uri === '/robots.txt':
            $APPLICATION->RestartBuffer();

            \header('Content-Type: text/plain; charset=utf-8');

            echo <<<TXT
User-agent: *
Disallow: /
TXT;

            exit;

        case $uri === '/sitemap.xml':
            $APPLICATION->RestartBuffer();

            \header('Content-Type: application/xml; charset=utf-8');

            echo <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"/>
XML;

            exit;

        case $uri === '/yandex-market.xml':
            $APPLICATION->RestartBuffer();

            \header('Content-Type: application/xml; charset=utf-8');

            $date = \date('Y-m-d H:i');

            echo <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="{$date}"/>
XML;

            exit;

        case \preg_match('#^/yandex\-turbo\-.*\.xml$#', $uri) === 1:
            $APPLICATION->RestartBuffer();

            \header('Content-Type: application/xml; charset=utf-8');

            $date = \date('Y-m-d H:i');

            echo <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<rss xmlns:yandex="http://news.yandex.ru" xmlns:media="http://search.yahoo.com/mrss/" xmlns:turbo="http://turbo.yandex.ru" version="2.0"/>
XML;

            exit;

        default:
            \LocalRedirect("{$url}{$uri}{$query}");
    }
}

$CITY_ADDRESS = $CITY->GetProperties()['ADDRESS']['VALUE'];

if ($_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
    if ($CITY_DETECTION === null) {
        $CITY_DETECTION = 'unknown';
    } elseif ($CITY_DETECTION === 'unknown') {
        $CITY_DETECTION = 'checked';
    }

    \setcookie('city_detection', $CITY_DETECTION, \strtotime('today +1 year'), '/');
}

$uri = \preg_replace('#//+#', '/', \parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '/');
$query = \parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);

$seoCityCode = $CITY->fields['CODE'] ?? '.default';
$seoPath = $APPLICATION->GetCurDir();
$seoType = 'subdomain';

if (isset($_GET['uri_city_code'])) {
    $seoCityCode = $_GET['uri_city_code'];
    $seoPath = \str_replace("/{$seoCityCode}/", '/', $seoPath);
    $seoType = 'subdirectory';
    \setcookie('city_detection', $_GET['uri_city_code'], \strtotime('today +1 year'), '/');
    $url = \str_replace('/?uri_city_code=' . $_GET['uri_city_code'], '/', $_SERVER['REQUEST_URI']);
    LocalRedirect($url);
}

$sql = <<<SQL
SELECT *

FROM `seo_text`

WHERE `CITY_CODE` = '{$seoCityCode}' AND
    `TYPE` = '{$seoType}' AND
    `PATH` = '{$seoPath}'
SQL;

$seoContentResult = $DB->Query($sql, true);
$SEO_CONTENT = $seoContentResult ? $seoContentResult->Fetch() : [];

if ($_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
    $APPLICATION->SetPageProperty('CANONICAL', WEB_PROTOCOL . '://' . $_SERVER['HTTP_HOST'] . $APPLICATION->GetCurPage());

}

\AddEventHandler('main', 'OnEndBufferContent', static function (&$content) {
    global $CITY;

    if (isset($_SERVER['REAL_FILE_PATH']) && \mb_strpos($_SERVER['REAL_FILE_PATH'], '/.meta') === 0) {
        return;
    }

    if (\stripos($_SERVER['REQUEST_URI'], '/bitrix/') === 0) {
        return;
    }

    if (!empty($_GET['uri_city_code'])) {
        $code = $_GET['uri_city_code'];
        $quoteCode = \preg_quote($code, '#');
        $content = \preg_replace("#(href|rel|link|action)=(['\"])/(?!(bitrix|local|favicon|css|js|img|node_modules|{$quoteCode}))#", "\$1=\$2/{$code}/$3", $content);
        $content = \preg_replace('#href="https://([^\.]+)\.znaki154\.ru"#', "href=\"https://znaki154.ru/\$1/\"", $content);
        $content = \preg_replace("#href=\"https://znaki154\\.ru/((?!{$quoteCode}/).*?)\"#", "href=\"https://znaki154.ru/{$code}/\$1\"", $content);
        $content = \preg_replace("#(\?|&|&amp;)uri_city_code={$quoteCode}&(amp;)?#", "\$1", $content);
        $content = \preg_replace("#(\?|&|&amp;)uri_city_code={$quoteCode}(['\"])#", "\$2", $content);
    }

    if (SUB_DOMAIN) {
        $code = SUB_DOMAIN;
        $content = \preg_replace("#href=\"https://znaki154\\.ru/#", "href=\"https://{$code}.znaki154.ru/", $content);
    }

    $fields = $CITY ? $CITY->GetFields() : [];
    $props = $CITY ? $CITY->GetProperties() : [];
    $phone = \array_values(\array_filter((array)$props['PHONE']['VALUE']))[0] ?: '';
    $content = \str_replace([
        ' class=""',
        " class=''",
        '#CITY_NAME#',
        '#CITY_NAME_IM#',
        '#CITY_NAME_ROD#',
        '#CITY_NAME_DAT#',
        '#CITY_NAME_VIN#',
        '#CITY_NAME_TVOR#',
        '#CITY_NAME_PRED#',
        '#CITY_ADDRESS#',
        '#CITY_ADDRESS_MOBILE#',
        '#CITY_PHONE#',
        '#CITY_PHONE_LINK#',
        '#CITY_PHONE_NBSP#',
        '#CITY_PHONE_MOBILE#',
        '#CITY_PHONE_MOBILE_LINK#',
        '#CITY_PHONE_MOBILE_NBSP#',
        '#CITY_DELIVERY_TIME#',
        '#CITY_DELIVERY_COST#',
        '#CITY_WORKTIME#',
        '#CITY_EMAIL#',
        '#CITY_MAP#'
    ], [
        '',
        '',
        $fields['NAME'] ?: 'Новосибирск',
        $fields['NAME'] ?: 'Новосибирск',
        $props['CASE_ROD']['VALUE'] ?: 'Новосибирска',
        $props['CASE_DAT']['VALUE'] ?: 'Новосибирску',
        $props['CASE_VIN']['VALUE'] ?: 'Новосибирск',
        $props['CASE_TVOR']['VALUE'] ?: 'Новосибирском',
        $props['CASE_PRED']['VALUE'] ?: 'Новосибирске',
        $props['ADDRESS']['VALUE'] ?: '',
        $props['ADDRESS_MOBILE']['VALUE'] ?: '',
        $phone,
        'tel:' . \preg_replace('#\D+#', '', $phone),
        \preg_replace('#\s+#', '&nbsp;', $phone),
        $props['PHONE_MOBILE']['VALUE'] ?: '',
        'tel:' . \preg_replace('#\D+#', '', $props['PHONE_MOBILE']['VALUE']),
        \preg_replace('#\s+#', '&nbsp;', $props['PHONE_MOBILE']['VALUE']),
        $props['TIME']['VALUE'] ?: '(по уточнению)',
        $props['COST']['VALUE'] ?: '(по уточнению)',
        $props['WORKTIME']['VALUE']['TEXT'],
        $props['EMAIL']['VALUE'],
        $props['MAP']['VALUE']
    ], $content);
})
?>