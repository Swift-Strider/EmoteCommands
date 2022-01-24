<?php

declare(strict_types=1);

namespace DiamondStrider1\EmoteCommands;

use pocketmine\plugin\PluginBase;

class Loader extends PluginBase
{
    private static self $instance;

    public static function getInstance(): self {
        return self::$instance;
    }

    public function onLoad(): void
    {
        self::$instance = $this;
    }
}
