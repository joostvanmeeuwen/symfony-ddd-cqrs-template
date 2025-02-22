<?php

namespace App\Application\Command;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateAlbum
{
    public function __construct(
        #[Assert\NotBlank(message: 'ID cannot be empty')]
        #[Assert\Uuid(message: 'Invalid UUID format')]
        public string $id,

        #[Assert\NotBlank(message: 'Title cannot be empty')]
        #[Assert\Length(
            min: 1,
            max: 255,
            minMessage: 'Title must be at least {{ limit }} characters long',
            maxMessage: 'Title cannot be longer than {{ limit }} characters'
        )]
        public string $title,

        #[Assert\NotBlank(message: 'Artist cannot be empty')]
        #[Assert\Length(
            min: 1,
            max: 255,
            minMessage: 'Artist must be at least {{ limit }} characters long',
            maxMessage: 'Artist cannot be longer than {{ limit }} characters'
        )]
        public string $artist,

        #[Assert\NotNull(message: 'Release date is required')]
        #[Assert\Type(DateTimeImmutable::class)]
        public DateTimeImmutable $releaseDate,

        #[Assert\Length(
            max: 1000,
            maxMessage: 'Description cannot be longer than {{ limit }} characters'
        )]
        public ?string $description = null,
    ) {
    }
}