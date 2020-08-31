<?php

declare(strict_types=1);

namespace Pwd\Entity;

use spaceonfire\BitrixTools\ORM\IblockElement;

/**
 * Class SliderTable
 * @package Pwd\Entity
 */
class CityTable extends IblockElement
{
	/**
	 * @return string
	 */
	public static function getIblockCode(): string
	{
		return 'city';
	}
}
