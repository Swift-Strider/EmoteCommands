<?php

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
        $this->setPermission("emotecommands.admin.create");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
    }
}
