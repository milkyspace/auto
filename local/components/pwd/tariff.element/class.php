<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

class TariffElementComponent extends CBitrixComponent
{
    /**
     * Обработка входных параметров
     * @param mixed[] $arParams
     * @return mixed[] $arParams
     */
    public function onPrepareComponentParams($arParams)
    {
        return $arParams;
    }

    /**
     * выполняет логику работы компонента
     * @return void
     */
    public function executeComponent()
    {
        try {
            if ($this->StartResultCache($this->arParams["CACHE_TIME"])) {
                $this->includeComponentTemplate();
            }
        } catch (Exception $e) {
            ShowError($e->getMessage());
        }
    }
}

?>
