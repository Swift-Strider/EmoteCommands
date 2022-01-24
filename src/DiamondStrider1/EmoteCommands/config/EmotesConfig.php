<?php

declare(strict_types=1);

namespace DiamondStrider1\EmoteCommands\config;

use pocketmine\utils\Config;

class EmotesConfig
{
    /** @var array<string, EmoteCommandEntry> emoteId => entry */
    private array $entries = [];

    public function __construct(
        /** @var array<mixed> */
        private array $data,
    ) {
    }

    public function tryLoad(): bool
    {
        foreach ($this->data as $entry) {
            if (
                (!is_array($entry)) ||
                ($parsed = EmoteCommandEntry::tryFromArray($entry)) === null
            ) {
                return false;
            }
            $this->entries[$parsed->getEmoteId()] = $parsed;
        }
        return true;
    }

    /** @return array<EmoteCommandEntry> */
    public function getEntries(): array
    {
        return array_values($this->entries);
    }

    public function getEntryByEmoteId(string $emoteId): ?EmoteCommandEntry
    {
        return $this->entries[$emoteId] ?? null;
    }
}
