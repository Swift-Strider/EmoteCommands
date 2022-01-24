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

use DiamondStrider1\EmoteCommands\session\EditEmoteCommandSession;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;

class EditEmoteCommand extends Command implements PluginOwned
{
    use CommandTrait;

    public function __construct(string $name)
    {
        parent::__construct($name, "Edit an existing emote-command of the server", "<name>");
        $this->setPermission("emotecommands.admin.edit");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!($sender instanceof Player)) {
            $sender->sendMessage("You must run this command as a player!");
            return;
        }

        if (($name = array_shift($args)) === null) {
            $sender->sendMessage("Please give a name of an EmoteCommand.");
            return;
        }

        $entry = $this->getOwningPlugin()->getEmotesConfig()->getEntry($name);
        if ($entry === null) {
            $sender->sendMessage("The EmoteCommand \"$name\" does not exist.");
            return;
        }

        (new EditEmoteCommandSession($sender, $name, $entry->getEmoteId(), $entry->getCommands(), $entry))->start();
    }
}
