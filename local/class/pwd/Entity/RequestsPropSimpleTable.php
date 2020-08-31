<?php

declare(strict_types=1);

namespace Pwd\Entity;

use spaceonfire\BitrixTools\ORM\IblockPropSimple;

/**
 * Class SliderPropSimpleTable
 * @package Pwd\Entity
 */
class RequestsPropSimpleTable extends IblockPropSimple
{
	/**
	 * @inheritDoc
	 */
	public static function getIblockId(): int
	{
		return RequestsTable::getIblockId();
	}
}
