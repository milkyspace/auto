<?php

namespace Pwd\Entity;


use spaceonfire\BitrixTools\ORM\IblockPropSimple;

class FormPropSimpleTable extends IblockPropSimple
{
    public static function getIblockId(): int
    {
        return FormTable::getIblockId();
    }

}