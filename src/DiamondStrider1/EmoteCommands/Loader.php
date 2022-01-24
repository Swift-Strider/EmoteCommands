<?php

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
