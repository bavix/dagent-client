<?php

declare(strict_types=1);

namespace Bavix\DAgent;

use JsonSerializable;

class MessageDto implements JsonSerializable
{
    public function __construct(
        private string $name,
        private int $value,
        private array $tags = [],
        private int $duration = 0
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function jsonSerialize()
    {
        return array_merge(
            [
                'name' => $this->name,
                'value' => $this->value,
            ],
            array_filter([
                'tags' => $this->tags,
                'duration' => $this->duration,
            ])
        );
    }
}