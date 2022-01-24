<?php

declare(strict_types=1);

namespace DiamondStrider1\EmoteCommands\session;

use DiamondStrider1\EmoteCommands\config\EmoteCommandEntry;
use DiamondStrider1\EmoteCommands\Loader;
use pocketmine\event\HandlerList;
use pocketmine\event\HandlerListManager;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerEmoteEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\player\Player;

class EditEmoteCommandSession implements Listener
{
    private Loader $plugin;

    public function __construct(
        private Player $player,
        private string $emoteCommandName,
        private ?string $emoteId = null,
        /** @var array<string> */
        private array $commands = [],
    ) {
        $this->plugin = Loader::getInstance();
    }

    public function start(): void
    {
        $this->plugin->getServer()->getPluginManager()->registerEvents($this, $this->plugin);
        $this->player->sendMessage("You are now in the EmoteCommand Creation wizard\n");
        $this->giveHelp();
    }

    public function giveHelp(): void
    {
        $this->player->sendMessage("-------");
        $this->player->sendMessage("Say `done` to finnish");
        $this->player->sendMessage("Say `list` to list commands");
        $this->player->sendMessage("Say `remove` to remove the last command");
        $this->player->sendMessage("Say `remove <index>` to remove the command at that index");
        $this->player->sendMessage("Say `cancel` to quit");
        $this->player->sendMessage("Prefix a command with a `#/` to add it");
        $this->player->sendMessage("Perform and emote to register it to the EmoteCommand");
        $this->player->sendMessage("-------");
    }

    /**
     * @priority LOWEST
     */
    public function onPlayerChat(PlayerChatEvent $ev): void
    {
        if ($ev->getPlayer() !== $this->player) return;
        $ev->cancel();
        $args = explode(" ", $ev->getMessage());
        $cmd = array_shift($args);
        switch ($cmd) {
            case "done":
                if ($this->emoteId === null) {
                    $this->player->sendMessage("Perform an emote first!");
                    break;
                }
                if (count($this->commands) === 0) {
                    $this->player->sendMessage("Register a command by running it, first!");
                    break;
                }
                $this->plugin->getInstance()->getEmotesConfig()->setEntry(new EmoteCommandEntry(
                    $this->emoteCommandName,
                    $this->emoteId,
                    $this->commands
                ));
                $this->player->sendMessage("Finished Setting Up EmoteCommand \"" . $this->emoteCommandName . "\"");
                HandlerListManager::global()->unregisterAll($this);
                break;
            case "cancel":
                HandlerListManager::global()->unregisterAll($this);
                $this->player->sendMessage("Canceled EmoteCommand Wizard");
                break;
            case "list":
                $this->player->sendMessage("Configured commands so far are:");
                foreach ($this->commands as $index => $cmd) {
                    $this->player->sendMessage("$index:  /$cmd");
                }
                break;
            case "remove":
                $id = array_shift($args) ?? count($this->commands) - 1;

                if (!isset($this->commands[$id])) {
                    $this->player->sendMessage("No Command to delete");
                    break;
                }

                $cmd = $this->commands[$id];
                unset($this->commands[$id]);
                $this->commands = array_values($this->commands);

                $this->player->sendMessage("Removed Command \"$cmd\"");
                break;
            default:
                if (str_starts_with($cmd, "#/")) {
                    $cmd = substr($cmd, 2, strlen($cmd) - 2) . " " . implode(" ", $args);
                    $this->commands[] = $cmd;
                    $this->player->sendMessage("Added Command `$cmd`");
                    break;
                }
                $this->giveHelp();
        }
    }

    /**
     * @priority LOWEST
     */
    public function onPlayerEmote(PlayerEmoteEvent $ev): void
    {
        if ($ev->getPlayer() !== $this->player) return;
        $this->emoteId = $ev->getEmoteId();
        $ev->cancel();
        $this->player->sendMessage("Using that Emote (id: " . $this->emoteId . ")");
    }

    public function onPlayerQuit(PlayerQuitEvent $ev): void
    {
        if ($ev->getPlayer() !== $this->player) return;
        HandlerListManager::global()->unregisterAll($this);
    }
}
