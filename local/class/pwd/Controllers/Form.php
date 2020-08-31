<?php


namespace Pwd\Controllers;

use Bitrix\Main\Application;
use Bitrix\Main\Context;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Type\DateTime;
use spaceonfire\BitrixTools\Mvc\Controller\Prototype;
use spaceonfire\BitrixTools\Mvc\View;
use Pwd\Helpers\Sanitizer;
use Pwd\Entity\FormTable;
use Pwd\Entity\FormPropSimpleTable;

/**
 * Class RegToEventsController
 */
class Form extends Prototype
{
    public $baseDir = '';
    public $arReq;

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->baseDir = Application::getDocumentRoot() . '/local/class/pwd/Controllers';
        $this->arReq = Context::getCurrent()->getRequest()->get("form");
        $this->arReq = Sanitizer::safeArray($this->arReq);
    }

    /**
     * Формирование массивов
     * Закомментированные поля могут понадобиться
     *
     * @param $newElement
     * @param $firstRow
     * @return mixed
     * @throws SystemException
     */
    public function arrayCreatePropFields()
    {
        $date = new DateTime();
        $fields = array(
            'NAME' => "Заявка от " . $this->arReq['name'] . ' Дата: ' . $date,
            "ACTIVE" => "Y",
            'PREVIEW_TEXT' => $this->arReq['comment'],
        );
        $prop = array(
            'NAME' => $this->arReq['name'],
            'EMAIL' => $this->arReq['email'],
            'TEL' => $this->arReq['tel'],
            'COMPANY' => $this->arReq['company'],
        );

        $arCreate['fields'] = $fields;
        $arCreate['prop'] = $prop;
        return $arCreate;
    }

    /**
     * Экшн формы внизу
     * @return array
     * @throws \Bitrix\Main\ObjectException
     */
    public function bottomFormAction()
    {
        $this->view = new View\Json();
        $this->returnAsIs = true;

        $arCreate = $this->arrayCreatePropFields();
        $addResult = FormTable::addElement($arCreate['fields'], $arCreate['prop']);
        if ($addResult > 0) {
            $this->arResult['STATUS'] = true;
            $this->arResult['MESSAGE'] = 'Заявка добавлена';
        }
        return [
            "status" => $this->arResult['STATUS'],
            "status_msg" => $this->arResult['MESSAGE'],
        ];
    }
}
