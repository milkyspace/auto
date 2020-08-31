<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use \Bitrix\Main\Data\Cache;
use \Pwd\Entity\RequestsTable;
use \Pwd\Tools\SendFormTools;

$result = [ 'success' => false ];

switch ($_REQUEST['method']){
    case 'get-calc-params':

        $cache = Cache::createInstance(); // получаем экземпляр класса
        if ($cache->initCache(7200, "cache_key")) { // проверяем кеш и задаём настройки
            $vars = $cache->getVars();
        }
        elseif ($cache->startDataCache()) {

            \Bitrix\Main\Loader::includeModule('iblock');

            $propertys = \Pwd\Entity\TariffSettingsTable::getList([
                'filter' => [
                    'ACTIVE' => 'Y',
                    'IBLOCK_SECTION.ACTIVE' => 'Y'
                ],
                'select' => [
                    'ID',
                    'NAME',
                    'SECTION_NAME' => 'IBLOCK_SECTION.NAME',
                    'TYPE' => 'PROPERTY_SIMPLE.TYPE',
                    'PRICE' => 'PROPERTY_SIMPLE.PRICE'
                ],
                'order' => [
                    'IBLOCK_SECTION.SORT' => 'ASC',
                    'SORT' => 'ASC',
                ]
            ])->fetchAll();

            $sections = [];

            foreach ($propertys as &$property){
                $property['TYPE'] = \Pwd\Entity\TariffSettingsTable::getXmlIdById($property['TYPE'], 'TYPE');

                $inSections = false;

                foreach ($sections as $section){
                    if($section['NAME'] == $property['SECTION_NAME']){
                        $inSections = true;
                    }
                }

                if(!$inSections){
                    $sections[] = [
                        'NAME' => $property['SECTION_NAME'],
                        'TYPE' => $property['TYPE']
                    ];
                }
            }

            $tariffs = \Pwd\Entity\TariffTable::getList([
                'filter' => ['ACTIVE' => 'Y'],
                'select' => [
                    'NAME',
                    'ID',
                    'PARAMS',
                    'SORT',
                    'PRICE' => 'PROPERTY_SIMPLE.PRICE_NUMBER'
                ],
                "runtime" => array(
                    "PARAMS" => array(
                        "data_type" => "string",
                        "expression" => array(
                            "GROUP_CONCAT(%s)",
                            "PROPERTY_MULTIPLE_TARIF_PROPS.VALUE"
                        )
                    )
                ),
                'order' => [
                    'SORT' => 'ASC'
                ]
            ])->fetchAll();

            $vars = array("tariffs" => $tariffs, 'sections' => $sections, 'propertys' => $propertys);
            $cache->endDataCache($vars); // записываем в кеш
        }

        $result['success'] = true;
        $result['tarifs'] = $vars;

        break;
    case 'send-form':
        if(check_bitrix_sessid()){

            //записать данные в вебформу
            ob_start();

            ?>
Выбранные тарифы<?=PHP_EOL?>
<? foreach ($_REQUEST['data']['tariffs'] as $tarifInfo){ ?>
  Тариф: <?=$tarifInfo['name']?>(<?=$tarifInfo['quantity']?>шт. | <?=$tarifInfo['price']?>руб. )<?=PHP_EOL?>
<? }?>

итого: <?=$_REQUEST['data']['total']['price']?> руб./мес

            <?php
            $text = ob_get_clean();

            \Bitrix\Main\Loader::includeModule('iblock');

            $obElement = new \CIBlockElement;
            $nEID = $obElement->Add([
                "ACTIVE" => 'N',
                "NAME" => 'Заявка от ' . $_REQUEST['name'],
                "IBLOCK_ID" => RequestsTable::getIblockId(),
                "PROPERTY_VALUES" => [
                    'EMAIL' => $_REQUEST['email'],
                    'NAME' => $_REQUEST['name'],
                    'PHONE' => $_REQUEST['phone'],
                    'TARIFF' => 'Описание заказа в детальном описание',
                ],
                'DETAIL_TEXT' => $text
            ]);

            if($nEID){

                $rsSites = \CSite::GetByID(SITE_ID);
                $arSite = $rsSites->Fetch();
                $email = $arSite['EMAIL'];

                $arSendData = [
                    'f_TARIFF' => $text,
                    'f_FIO' => $_REQUEST['name'],
                    'f_PHONE' => $_REQUEST['phone'],
                    'f_EMAIL' =>  $_REQUEST['email'],
                    'f_EMAILS' => $email
                ];

                SendFormTools::send($arSendData, 'FORM_CONNECT');

                $result['success'] = true;
            }else{
                $result['success'] = false;
            }
        }
        break;
    default:
        $result['message'] = 'not exist method';
        break;
}
header('Content-Type: application/json');
echo json_encode($result);
