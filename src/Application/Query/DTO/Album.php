<?php

namespace App\Application\Query\DTO;

use DateTimeImmutable;
use JsonSerializable;

class Album implements JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $artist,
        public readonly DateTimeImmutable $releaseDate,
        public readonly ?string $description
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'artist' => $this->artist,
            'releaseDate' => $this->releaseDate->format('Y-m-d'),
            'description' => $this->description,
        ];
    }
}