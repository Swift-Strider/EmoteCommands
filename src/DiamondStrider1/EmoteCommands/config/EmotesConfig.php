<?php

declare(strict_types=1);

namespace DiamondStrider1\EmoteCommands\config;

use pocketmine\utils\Config;

class EmotesConfig
{
    /** @var array<string, EmoteCommandEntry> emoteId => entry */
    private array $entries = [];

    public function __construct(
        private Config $config,
    ) {
    }

    public function tryLoad(): bool
    {
        foreach ($this->config->getAll() as $entry) {
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

    private function save(): void
    {
        $data = [];
        foreach ($this->entries as $entry) {
            $data[$entry->getEmoteId()] = $entry->toRawData();
        }
        $this->config->setAll($data);
        $this->config->save();
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

    public function setEntry(EmoteCommandEntry $entry): void
    {
        $this->removeEntry($entry->getName());
        $this->entries[$entry->getEmoteId()] = $entry;
        $this->save();
    }

    public function removeEntry(string $name): bool
    {
        foreach ($this->entries as $key => $entry) {
            if ($entry->getName() === $name) {
                unset($this->entries[$key]);
                return true;
            }
        }
        return false;
    }
}
