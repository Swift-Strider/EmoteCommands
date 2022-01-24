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

    public function getEntry(string $name): ?EmoteCommandEntry
    {
        foreach ($this->entries as $entry) {
            if ($entry->getName() === $name) {
                return $entry;
            }
        }
        return null;
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
                $this->save();
                return true;
            }
        }
        return false;
    }
}
