<?php

declare(strict_types=1);

namespace DiamondStrider1\EmoteCommands\command;

use DiamondStrider1\EmoteCommands\Loader;

final class Commands
{
    public static function registerAll(): void
    {
        $plugin = Loader::getInstance();
        $cm = $plugin->getServer()->getCommandMap();
        $cm->registerAll("emotecommands", [
            new MakeEmoteCommand("makeemotecommand"),
            new RemoveEmoteCommand("removeemotecommand"),
            new EditEmoteCommand("editemotecommand"),
        ]);
    }
}
