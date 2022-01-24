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

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;

class RemoveEmoteCommand extends Command implements PluginOwned
{
    use CommandTrait;

    public function __construct(string $name)
    {
        parent::__construct($name, "Removes an existing emote-command from the server", "<name>");
        $this->setPermission("emotecommands.admin.remove");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (($name = array_shift($args)) === null) {
            $sender->sendMessage("Please provide the name of the EmoteCommand to remove.");
            return;
        }

        $success = $this->getOwningPlugin()->getEmotesConfig()->removeEntry($name);
        if ($success) {
            $sender->sendMessage("Deleted EmoteCommand \"$name\"");
        } else {
            $sender->sendMessage("There is no EmoteCommand named \"$name\"");
        }
    }
}
