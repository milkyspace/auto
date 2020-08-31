<?php


namespace Pwd\Tools;

use Bitrix\Main\Loader;
use \Bitrix\Main\Mail\Event;

Loader::includeModule('iblock');

/**
 * Class SendFormTools
 * @package Pwd\Classes\Tools
 */
class SendFormTools
{
	const sPrefix = 'f_';

	/**
	 * отправялет данные формы по событию и сохраняет в ИБ (если задан код ИБ)
	 * @param array $arData - отправляемые данные
	 * @param string $sEventID - код события
	 * @param int|bool $nFormID - id инфоблока
	 * @param string|bool $sPrefix - префикс для определения полей формы (свойства ИБ)
	 * @return bool|string
	 */
	public static function send($arData, $sEventID, $nFormID = false, $sPrefix = false)
	{
		if (!$sEventID) {
			return 'Событие не определено';
		}

		if (!$sPrefix) {
			$sPrefix = self::sPrefix;
		}

		$arFields = [];
		foreach ($arData as $sKey => $mItem) {
			if (strstr($sKey, $sPrefix)) {
				$arFields[str_replace($sPrefix, '', $sKey)] = $mItem;
			}
		}
		if ($nFormID == CONST_IBLOCK_ID_CHECKIN) {
			$active = 'N';
		} else {
			$active = 'Y';
		}
		if ($nFormID && is_numeric($nFormID)) { // если ИБ задан - сохраняем элемент ИБ, отправляем событие
			$obElement = new \CIBlockElement;
			$arF = Array(
				"IBLOCK_SECTION_ID" => false,
				"IBLOCK_ID" => $nFormID,
				"PROPERTY_VALUES" => $arFields,
				"NAME" => 'Заявка ' . date('d.m.Y H:i:s'),//.' '.md5(microtime()),
				"ACTIVE" => $active,
			);

			if ($nID = $obElement->Add($arF)) {
				self::sendEvent($arFields, $sEventID);

				return true;
			} else {
				return $obElement->LAST_ERROR;
			}
		} else { // если ИБ не задан - просто отрпавляем событие
			self::sendEvent($arFields, $sEventID);
		}

	}

	/**
	 * отправляет почтовое событие
	 * @param array $arFields - значения полей
	 * @param string $sEvent - код события
	 */
	public static function sendEvent($arFields, $sEvent)
	{
		Event::send(array(
			"EVENT_NAME" => $sEvent,
			"LID" => "s1",
			"C_FIELDS" => $arFields,
			"FILE" => $arFields['FILE']
		));
	}
}
