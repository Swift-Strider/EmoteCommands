<?php

declare(strict_types=1);

namespace DiamondStrider1\EmoteCommands\command;

use DiamondStrider1\EmoteCommands\Loader;

final class Commands
{
    public static function registerAll()
    {
        $plugin = Loader::getInstance();
        $cm = $plugin->getServer()->getCommandMap();
        $cm->registerAll("emotecommands", [
            new MakeEmoteCommand("makeemotecommand")
        ]);
    }
}
