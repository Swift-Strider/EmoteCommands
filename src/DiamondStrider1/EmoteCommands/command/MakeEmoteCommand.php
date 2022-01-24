<?php

declare(strict_types=1);

namespace DiamondStrider1\EmoteCommands\command;

use DiamondStrider1\EmoteCommands\session\EditEmoteCommandSession;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;

class MakeEmoteCommand extends Command implements PluginOwned
{
    use CommandTrait;

    public function __construct(string $name)
    {
        parent::__construct($name, "Creates a new emote-command for the server", "<name>");
        $this->setPermission("emotecommands.admin.create");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!($sender instanceof Player)) {
            $sender->sendMessage("You must run this command as a player!");
            return;
        }

        if (($name = array_shift($args)) === null) {
            $sender->sendMessage("Please give a name for the EmoteCommand.");
            return;
        }

        (new EditEmoteCommandSession($sender, $name))->start();
    }
}
