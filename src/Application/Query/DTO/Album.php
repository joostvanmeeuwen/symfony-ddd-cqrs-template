<?php

namespace App\Application\Query\DTO;

use DateTimeImmutable;
use JsonSerializable;

readonly class Album implements JsonSerializable
{
    public function __construct(
        public string $id,
        public string $title,
        public string $artist,
        public DateTimeImmutable $releaseDate,
        public ?string $description
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