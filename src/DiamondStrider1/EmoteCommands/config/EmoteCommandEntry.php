<?php

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
