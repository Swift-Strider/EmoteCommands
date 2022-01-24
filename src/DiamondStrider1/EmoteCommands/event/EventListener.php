<?php

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
