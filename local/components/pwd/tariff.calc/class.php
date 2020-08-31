<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)  die();

class TariffCalcComponent extends CBitrixComponent
{
    /**
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function getResult()
    {

    }

    /**
     * выполняет логику работы компонента
     * @return void
     */
    public function executeComponent()
    {

        try {
            if ($this->StartResultCache($this->arParams["CACHE_TIME"])) {
                $this->getResult();
                $this->includeComponentTemplate();
            }
        } catch (Exception $e) {
            ShowError($e->getMessage());
        }
    }
}
