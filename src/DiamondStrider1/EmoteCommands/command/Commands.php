<?php

/**
 * EmoteCommands, run commands when you emote~
 * Copyright (C) <2022>  <DiamondStrider1>

 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.

 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

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
