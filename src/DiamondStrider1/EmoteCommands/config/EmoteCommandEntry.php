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

        return new self($emoteId, $commands);
    }

    public function __construct(
        private string $emoteId,
        /** @var array<string> */
        private array $commands,
    ) {
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
