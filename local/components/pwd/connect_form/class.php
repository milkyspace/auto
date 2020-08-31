<?php

use Pwd\Entity\RequestsTable;
use Pwd\Tools\SendFormTools;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\ActionFilter;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

class ConnectFormComponent extends CBitrixComponent implements Controllerable
{
    /**
     * Конфигурируем AJAX методы
     * @return array
     */
    public function configureActions()
    {
        // Сбрасываем фильтры по-умолчанию (ActionFilter\Authentication и ActionFilter\HttpMethod)
        // Предустановленные фильтры находятся в папке /bitrix/modules/main/lib/engine/actionfilter/
        return [
            'add' => [ // Ajax-метод
                'prefilters' => [
                    new ActionFilter\HttpMethod([
                        ActionFilter\HttpMethod::METHOD_POST
                    ])
                ],
            ],
            'addWithFile' => [ // Ajax-метод
                'prefilters' => [
                    new ActionFilter\HttpMethod([
                        ActionFilter\HttpMethod::METHOD_POST
                    ])
                ],
            ]
        ];
    }

    /**
     * Обработка входных параметров
     *
     * @param mixed[] $arParams
     *
     * @return mixed[] $arParams
     */
    public function onPrepareComponentParams($arParams)
    {
        return $arParams;
    }

    /**
     * выполняет логику работы компонента
     *
     * @return void
     */
    public function executeComponent()
    {
        try {
            \CJSCore::Init(array("jquery"));
            $this->includeComponentTemplate();
        } catch (Exception $e) {
            ShowError($e->getMessage());
        }
    }

    private function clearData($str = '')
    {
        $str = trim($str);
        $str = stripcslashes($str);
        $str = strip_tags($str);
        $str = htmlspecialchars($str);
        return $str;
    }

    /**
     * ajax метод отправки заявки
     * @param $docID
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\SystemException
     */
    public function addAction(): array
    {
        $this->arReq['form'] = $this->request->getPostList()->toArray()['form'];
        $check = true;
        $mResult = '';

        if (!check_bitrix_sessid()) {
            $check = false;
            $mResult = 'Не пройдена проверка сессии';
        }
        
        if (!$check) {
            return [
                "status" => $this->arReq,
                "status_msg" => $mResult,
                "status_check" => $check,
            ];
        }

        if (strlen($this->arReq['form']['email']) || strlen($this->arReq['form']['phone'])) {
            $form['email'] = self::clearData($this->arReq['form']['email']);
            $form['name'] = self::clearData($this->arReq['form']['name']);
            $form['phone'] = self::clearData($this->arReq['form']['phone']);

            $sUserName = $form['name'] . ' (' . date('d.m.Y H:i:s') . ')';

            $rsSites = \CSite::GetByID(SITE_ID);
            $arSite = $rsSites->Fetch();
            $email = $arSite['EMAIL'];

            $obElement = new \CIBlockElement;
            $nEID = $obElement->Add([
                "ACTIVE" => 'N',
                "NAME" => 'Заявка от ' . $sUserName,
                "IBLOCK_ID" => RequestsTable::getIblockId(),
                "PROPERTY_VALUES" => [
                    'EMAIL' => $form['email'],
                    'NAME' => $form['name'],
                    'PHONE' => $form['phone'],
                ]
            ]);

            if ($nEID) {
                $arSendData = [
                    'f_FIO' => $form['name'],
                    'f_PHONE' => $form['phone'],
                    'f_EMAIL' => $form['email'],
                    'f_EMAILS' => $email
                ];

                SendFormTools::send($arSendData, 'FORM_CONNECT');
                $mResult = 'Ваша заявка отправлена';
                $check = true;
            } else {
                $mResult = 'Ошибка ' . $obElement->LAST_ERROR . '. Сообщите об ошибке администратору сайта.';
                $check = false;
            }

        } else {
            $check = false;
            $mResult = 'Заполнены не все поля';
        }

        return [
            "status" => $this->arReq,
            "status_msg" => $mResult,
            "status_check" => $check,
        ];
    }

    /**
     * ajax метод отправки заявки и файла
     * @param $docID
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\SystemException
     */
    public function addWithFileAction(): array
    {
        $this->arReq['form'] = $this->request->getPostList()->toArray()['form'];
        $check = true;
        $mResult = '';

        if (!check_bitrix_sessid()) {
            $check = false;
            $mResult = 'Не пройдена проверка сессии';
        }

        if (!filter_var($this->arReq['form']['email'], FILTER_VALIDATE_EMAIL)
            && !preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $this->arReq['form']['email'])) {
            $check = false;
            $mResult = 'E-mail введен неверно';
        }

        if (!$check) {
            return [
                "status" => $this->arReq,
                "status_msg" => $mResult,
                "status_check" => $check,
            ];
        }

        if (strlen($this->arReq['form']['email'])) {
            $form['email'] = self::clearData($this->arReq['form']['email']);
            $form['name'] = self::clearData($this->arReq['form']['name']);
            $form['tariff'] = self::clearData($this->arReq['form']['tariff']);

            $sUserName = $form['name'] . ' (' . date('d.m.Y H:i:s') . ')';

            $rsSites = \CSite::GetByID(SITE_ID);
            $arSite = $rsSites->Fetch();
            $email = $arSite['EMAIL'];

            $obElement = new \CIBlockElement;
            $nEID = $obElement->Add([
                "ACTIVE" => 'N',
                "NAME" => 'Виртуальный офис
«1 год по цене 3-х месяцев» для ' . $sUserName,
                "IBLOCK_ID" => RequestsTable::getIblockId(),
                "PROPERTY_VALUES" => [
                    'EMAIL' => $form['email'],
                    'NAME' => $form['name'],
                    'PHONE' => 'Без номера',
                    'TARIFF' => $form['tariff'],
                ]
            ]);

            if ($nEID) {
                $arSendData = [
                    'f_TARIFF' => $form['tariff'],
                    'f_FIO' => $form['name'],
                    'f_EMAIL' => $form['email'],
                    'f_EMAILS' => $email,
                ];

                SendFormTools::send($arSendData, 'FORM_CONNECT_FILE');
                $mResult = 'Ваша заявка отправлена';
                $check = true;
            } else {
                $mResult = 'Ошибка ' . $obElement->LAST_ERROR . '. Сообщите об ошибке администратору сайта.';
                $check = false;
            }

        } else {
            $check = false;
            $mResult = 'Заполнены не все поля';
        }

        return [
            "status" => $this->arReq,
            "status_msg" => $mResult,
            "status_check" => $check,
        ];
    }

}

?>
