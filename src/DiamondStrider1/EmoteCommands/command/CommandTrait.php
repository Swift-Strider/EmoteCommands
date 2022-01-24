<?php

declare(strict_types=1);

namespace DiamondStrider1\EmoteCommands\command;

use DiamondStrider1\EmoteCommands\Loader;

trait CommandTrait
{
    public function getOwningPlugin(): Loader
    {
        return Loader::getInstance();
    }
}
