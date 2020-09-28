<?php

use \Pwd\Entity\CityTable;

/**
 * PWD
 */

require_once $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php';

$IS_BOT = false;
$CITY_URI_PREFIX = '';

if (PHP_SAPI !== 'cli') {

    if (isset($_GET['uri_city_code'])) {
        $CITY_URI_PREFIX = "/{$_GET['uri_city_code']}";

        if (SUB_DOMAIN !== null) {
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
    }

    $userAgent = $_SERVER['HTTP_USER_AGENT'] ? \mb_strtolower($_SERVER['HTTP_USER_AGENT']) : '';

    $IS_BOT = $IS_BOT || (\preg_match('#(mauibot|mj12bot|semrushbot|ahrefsbot|blexbot|serpstatbot|seznambot|nimbostratus-bot|sogou web spider)#', $userAgent) > 0);
    $IS_BOT = $IS_BOT || (\preg_match('#(bingbot|googlebot|dotbot|mail\.ru_bot|yadirectfetcher|applebot)#', $userAgent) > 0);
    $IS_BOT = $IS_BOT || (\preg_match('#yandex(bot|images|turbo|accessibilitybot|mobilebot|market)#', $userAgent) > 0);

    $city = $_COOKIE['city_detection'] ?: null;

    if ($_GET['city-select'] == 'true') {
        $select = $_GET['city-select'];
        \setcookie('city_select', $select, \strtotime('today +1 year'));
        define("CITY_SELECT", "true");
        LocalRedirect('/');
    }

    if ($_COOKIE['city_select'] == 'true') {
        define("CITY_SELECT", "true");
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
        $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip . '?lang=ru'));
        if ($query && $query['status'] == 'success') {
            $cityFromIP = $query['city'];
            $cityCheckObj = \CIBlockElement::GetList([], ['IBLOCK_ID' => CityTable::getIblockId(), 'NAME' => \ucfirst($cityFromIP)], false, false, []);

            while ($row = $cityCheckObj->fetch()) {
                $cityCheck = $row;
            }

            if (strlen($cityCheck['CODE'])) {
                \setcookie('city_detection', $cityCheck['CODE'], \strtotime('today +1 year'));
                $city = $cityCheck['CODE'];
            } else {
                $city = 'novosibirsk';
            }
            define("CITY_IP", $cityCheck['NAME']);
        }
    }

    $uriParts = \explode('?', $_SERVER['REQUEST_URI']);
    $uri = $uriParts[0];
    $cityNameFromUri = \str_replace("/", '', $uri);

    if (strlen($cityNameFromUri)) {
        $cityCheckObj = \CIBlockElement::GetList([], ['IBLOCK_ID' => CityTable::getIblockId(), 'CODE' => $cityNameFromUri], false, false, []);

        while ($row = $cityCheckObj->fetch()) {
            $cityCheck = $row;
        }

        if (strlen($cityCheck['CODE'])) {
            \setcookie('city_detection', $cityNameFromUri, \strtotime('today +1 year'));
            $city = $cityCheck['CODE'];
        } else {
            $city = 'novosibirsk';
        }
    }

    $cityObject = \CIBlockElement::GetList([], [
        'IBLOCK_ID' => CityTable::getIblockId(),
        'CODE' => $city,
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

    $CITY_DETECTION = $CITY->GetFields('CODE');

    if ($CITY->fields['CODE'] === 'novosibirsk') {
        if (!empty($_GET['uri_city_code'])) {
            $url = \str_replace('/novosibirsk/', '/', $_SERVER['REQUEST_URI']);

            LocalRedirect($url);
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

        \setcookie('city_detection', $CITY_DETECTION, \strtotime('today +1 year'), '/', '.' . WEB_HOSTNAME);
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
}

\AddEventHandler('iblock', 'OnAfterIBlockElementAdd', [\core\EventHandler::class, 'OnAfterIBlockElementAdd']);
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
        '#CITY_PHONE#',
        '#CITY_PHONE_LINK#',
        '#CITY_PHONE_NBSP#',
        '#CITY_DELIVERY_TIME#',
        '#CITY_DELIVERY_COST#',
        '#CITY_WORKTIME#',
        '#CITY_EMAIL#'
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
        $phone,
        'tel:' . \preg_replace('#\D+#', '', $phone),
        \preg_replace('#\s+#', '&nbsp;', $phone),
        $props['TIME']['VALUE'] ?: '(по уточнению)',
        $props['COST']['VALUE'] ?: '(по уточнению)',
        $props['WORKTIME']['VALUE']['TEXT'] ?: '(по уточнению)',
        $props['EMAIL']['VALUE'] ?: '(по уточнению)',
    ], $content);
});

\AddEventHandler('original_simpleshop', 'OnProductPrice', [\core\EventHandler::class, 'OnProductPrice']);
\AddEventHandler('original_simpleshop', 'OnRenderSaleProductDetails', [\core\EventHandler::class, 'OnRenderSaleProductDetails']);
\AddEventHandler('original_simpleshop', 'OnSaleCreate', [\core\EventHandler::class, 'OnSaleCreate']);

/**
 * @param string $property
 *
 * @return string
 */
function getPageProperty($property)
{
    global $APPLICATION;

    $constants = \get_defined_constants(true);

    if (\defined($property)) {
        return $constants['user'][$property];
    }

    return $APPLICATION->GetDirProperty($property, false, null);
}

function renderRecursiveMenu($items, $depth = 0, $useWrapper = false)
{
    if (\count($items) === 0) {
        return '';
    }

    $ulClassList = [];

    if ($depth === 0) {
        $ulClassList[] = 'menu';
    }
    ($depth === 0) ? $dropdown = 'dropdown' : $dropdown = '';
    ($depth === 1) ? $level = 'level1' : $level = '';
    $html = '<ul class="' . $level . ' ' . $dropdown . ' ' . \implode(' ', $ulClassList) . '">';

    foreach ($items as $item) {
        $classes = [];

        if ($item['SELECTED']) {
            $classes[] = 'active';
        }

        if (\count($item['CHILDREN']) > 0) {
            $classes[] = 'sub-menu';
        }

        $classes = \implode(' ', $classes);

        $html .= "<li class=\"{$classes}\">";

        $hasChildren = \is_array($item['CHILDREN']) && \count($item['CHILDREN']) > 0;
        $submenuTpl = $hasChildren ? '<a href="#" class="toggle" title="Развернуть меню"></a>' : '';

        $html .= <<<HTML
<div class="link-wrapper">
    <a href="{$item['LINK']}" class="link" title="{$item['TEXT']}">{$item['TEXT']}</a>
    {$submenuTpl}
</div>
HTML;

        $html .= \renderRecursiveMenu($item['CHILDREN'], $depth + 1, $useWrapper);
        $html .= '</li>';
    }

    $html .= '</ul>';

    if ($useWrapper) {
        $html = "<div class=\"menu-wrapper\">{$html}</div>";

    }

    return $html;
}

function buildNestedMenu($items)
{
    $menu = [];
    $first = \current($items);
    $level = (int)$first['DEPTH_LEVEL'];
    $levels = [
        $level => &$menu,
    ];

    foreach ($items as $item) {
        $current = (int)$item['DEPTH_LEVEL'];

        $item['CHILDREN'] = [];

        if ($current > $level) {
            $levels[$current] = &$levels[$level][\count($levels[$level]) - 1]['CHILDREN'];
        }

        $levels[$current][] = $item;

        $level = $current;
    }

    unset($level, $levels, $current);

    return $menu;
}

function translateLabel($text)
{
    $translate = [
        'SIZE' => 'Размер',
        'SURFACE' => 'Поверхность',
        'VARIANT' => 'Вариант исполнения',
        'HEIGHT' => 'Высота',
        'LAMINATION' => 'Ламинация',

        'NON_REFLECTIVE' => 'Не световозвращающая',
        'REFLECTIVE' => 'Световозвращающая',
        'FILM' => 'Пленка',
        'PVC' => 'ПВХ',
        'METAL_ZINC' => 'Металл оцинковка',
        'METAL_SIDE' => 'Металл + отбортовка',
        'COMPOSITE' => 'Композит (АКП)',
        'PILLAR' => 'Знак + столбик',
        'NON_LAMINATED' => 'Без ламинации',
        'LAMINATED' => 'С ламинацией',
    ];

    return \array_key_exists($text, $translate) ? $translate[$text] : $text;
}

function pageNotFound()
{
    global $APPLICATION;

    $APPLICATION->RestartBuffer();

    \ob_end_clean();

    \CHTTP::SetStatus('404 Not Found');

    $serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?: 'nginx';

    echo <<<HTML
<html>
<head><title>404 Not Found</title></head>
<body>
<center><h1>404 Not Found</h1></center>
<hr><center>{$serverSoftware}</center>
</body>
</html>
<!-- a padding to disable MSIE and Chrome friendly error page -->
<!-- a padding to disable MSIE and Chrome friendly error page -->
<!-- a padding to disable MSIE and Chrome friendly error page -->
<!-- a padding to disable MSIE and Chrome friendly error page -->
<!-- a padding to disable MSIE and Chrome friendly error page -->
<!-- a padding to disable MSIE and Chrome friendly error page -->
HTML;

    exit;
}

function getMetaFile(string $type, bool $fullPath = false): string
{
    global $APPLICATION, $CITY;

    $code = $CITY->fields['CODE'] ?? '.default';
    $uri = $APPLICATION->GetCurDir();

    if (isset($_GET['uri_city_code'])) {
        $code = $_GET['uri_city_code'];
        $uri = \str_replace("/{$code}/", '/', $uri);
    }

    $uri = \str_replace(['-or-', '-is-'], ['/or/', '/is/'], $uri);
    $uri = \trim($uri, '/');

    $subDomainPath = "/include/seo/{$code}/{$uri}/.{$type}.php";
    $subDirectoryPath = "/include/seo/.extra/{$code}/{$uri}/.{$type}.php";

    $path = isset($_GET['uri_city_code']) ? $subDirectoryPath : $subDomainPath;

    if ($fullPath) {
        $path = WEB_ROOT . $path;
    }

    return $path;
}

function cacheGetOrSet(string $key, int $duration, callable $callable)
{
    $cache = new \CPHPCache();

    if ($cache->InitCache($duration, $key, 'cached_data')) {
        $vars = $cache->GetVars();

        return $vars['result'];
    }

    $result = $callable();

    if ($cache->StartDataCache()) {
        $cache->EndDataCache(['result' => $result]);
    }

    return $result;
}

function getIframeSrcUrl($url): ?string
{
    if (empty($url)) {
        return null;
    }

    $url = (string)$url;

    if (\mb_strpos($url, 'https://www.youtube.com/watch') === 0) {
        $query = [];

        \parse_str(\parse_url($url, PHP_URL_QUERY), $query);

        $url = "https://www.youtube.com/embed/{$query['v']}";
    }

    return $url;
}

function renderCatalogSectionVideoBlock(int $sectionID, int $blockID): void
{
    /**
     * @var \CMain $APPLICATION
     */
    global $APPLICATION;

    $properties = \core\helpers\Catalog::getSectionVideoDetails($sectionID, $blockID);

    $url = $properties['VIDEO_URL'];
    $title = $properties['VIDEO_TITLE'];
    $description = $properties['VIDEO_DESCRIPTION'];
    $preview = $properties['VIDEO_PREVIEW'];

    if (empty($url)) {
        return;
    }

    echo <<<HTML
<section class="section-catalog-video-block" id="catalog-video-block">
    <div class="video-column">
        <div class="iframe-wrapper">
            <iframe
                width="560"
                height="315"
                src="{$url}"
                frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
        </div>
    </div>

    <div class="content-column">
        <h3>{$title}</h3>
        <div class="content">{$description}</div>
    </div>
</section>
HTML;

    if (!empty($preview)) {
        \Bitrix\Main\Page\Asset::getInstance()->addCss('/node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.css');
        \Bitrix\Main\Page\Asset::getInstance()->addJs('/node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.js');

        $file = \CFile::GetFileArray($preview);
        $html = <<<HTML
<div class="catalog-video-block-preview">
    <a href="{$url}}" data-fancybox>
        <img src="{$file['SRC']}" alt="">
    </a>
</div>
HTML;

        $APPLICATION->SetPageProperty('TOP_SEO_CONTENT_BEFORE', $html);
    }
}

?>