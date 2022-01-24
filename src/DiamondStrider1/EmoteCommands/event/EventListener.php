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

namespace DiamondStrider1\EmoteCommands\event;

use DiamondStrider1\EmoteCommands\Loader;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerEmoteEvent;

class EventListener implements Listener
{
    public function __construct(
        private Loader $plugin,
    ) {
    }

    /**
     * @priority HIGHEST
     */
    public function onPlayerEmote(PlayerEmoteEvent $ev): void
    {
        $conf = $this->plugin->getEmotesConfig();

        $entry = $conf->getEntryByEmoteId($ev->getEmoteId());
        if ($entry === null) {
            return;
        }

        $ev->cancel();
        foreach ($entry->getCommands() as $cmd) {
            $this->plugin->getServer()->dispatchCommand(
                $ev->getPlayer(),
                $cmd
            );
        }
    }
}
