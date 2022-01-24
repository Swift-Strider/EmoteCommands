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

namespace DiamondStrider1\EmoteCommands;

use DiamondStrider1\EmoteCommands\command\Commands;
use DiamondStrider1\EmoteCommands\config\EmotesConfig;
use DiamondStrider1\EmoteCommands\event\EventListener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Loader extends PluginBase
{
    private static self $instance;

    public static function getInstance(): self
    {
        return self::$instance;
    }

    private EmotesConfig $emotesConfig;
    private EventListener $eventListener;

    public function onLoad(): void
    {
        self::$instance = $this;
    }

    public function onEnable(): void
    {
        $this->emotesConfig = new EmotesConfig(new Config($this->getDataFolder() . "emote-commands.yml"));
        if (!$this->emotesConfig->tryLoad()) {
            $this->getLogger()->emergency("emote-command.yml is corrupted ... shutting down!");
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return;
        }

        $this->eventListener = new EventListener($this);
        $this->getServer()->getPluginManager()->registerEvents($this->eventListener, $this);

        Commands::registerAll();
    }

    public function getEmotesConfig(): EmotesConfig
    {
        return $this->emotesConfig;
    }
}
