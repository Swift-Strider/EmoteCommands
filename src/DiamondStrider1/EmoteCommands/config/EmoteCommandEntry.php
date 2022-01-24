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

class EmoteCommandEntry
{
    /**
     * @param array<mixed> $data
     */
    public static function tryFromArray(array $data): ?self
    {
        if (
            ($emoteId = $data['emote-id'] ?? null) === null ||
            (!is_string($emoteId)) ||
            ($name = $data['name'] ?? null) === null ||
            (!is_string($name)) ||
            ($commands = $data['commands'] ?? null) === null ||
            (!is_array($commands))
        ) {
            return null;
        }

        foreach ($commands as $command) {
            if (!is_string($command)) {
                return null;
            }
        }

        return new self($name, $emoteId, $commands);
    }

    /**
     * @return array<string, mixed>
     */
    public function toRawData(): array
    {
        return [
            "name" => $this->name,
            "emote-id" => $this->emoteId,
            "commands" => $this->commands,
        ];
    }

    public function __construct(
        private string $name,
        private string $emoteId,
        /** @var array<string> */
        private array $commands,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmoteId(): string
    {
        return $this->emoteId;
    }

    /**
     * @return array<string>
     */
    public function getCommands(): array
    {
        return $this->commands;
    }
}
