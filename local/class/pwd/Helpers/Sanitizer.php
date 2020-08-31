<?php

namespace Pwd\Helpers;

/**
 * Класс для обработки данных, пришедших от пользователя
 * Class Sanitizer
 * @package Pwd\Medturizm
 */
class Sanitizer
{
    /**
     * Фильтрует данные POST запроса
     * @param array $arr
     *
     * @return array
     */
    public static function safeArray(array $arr): array
    {
        $filteredArr = [];
        foreach ($arr as $param => $value) {
            if (!is_array($value)) {
                $value = strip_tags($value);
                $value = htmlspecialchars($value);
                $value = trim($value);

                $filteredArr[$param] = $value;
            } else {
                $filteredArr[$param] = self::safeArray($value);
            }
        }

        return $filteredArr;
    }

    /**
     * Фильтрует строку POST запроса
     * @param string $str
     *
     * @return string
     */
    public static function safeString(string $str = ''): string
    {
        $value = strip_tags($str);
        $value = htmlspecialchars($value);
        $value = trim($value);

        return $value ?? '';
    }
}