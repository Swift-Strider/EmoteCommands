<?php

declare(strict_types=1);

namespace DiamondStrider1\EmoteCommands;

use DiamondStrider1\EmoteCommands\config\EmotesConfig;
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

    public function onLoad(): void
    {
        self::$instance = $this;
    }

    public function onEnable(): void
    {
        $this->emotesConfig = new EmotesConfig((new Config($this->getDataFolder() . "emote-commands.yml"))->getAll());
        if (!$this->emotesConfig->tryLoad()) {
            $this->getLogger()->emergency("emote-command.yml is corrupted ... shutting down!");
            $this->getServer()->getPluginManager()->disablePlugin($this);
        }
    }
}
