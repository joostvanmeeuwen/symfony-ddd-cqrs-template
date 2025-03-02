<?php
namespace App\Domain\Model;

use App\Domain\Exception\InvalidAlbumException;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

class Album
{
    /**
     * @throws InvalidAlbumException
     */
    private function __construct(
        private readonly UuidInterface $id,
        private readonly string $title,
        private readonly string $artist,
        private readonly DateTimeImmutable $releaseDate,
        private ?string $description = null,
    ) {
        if (strlen($this->title) < 1) {
            throw new InvalidAlbumException('Album title cannot be empty');
        }
        if (strlen($this->artist) < 1) {
            throw new InvalidAlbumException('Artist name cannot be empty');
        }
    }

    /**
     * @throws InvalidAlbumException
     */
    public static function create(
        UuidInterface $id,
        string $title,
        string $artist,
        DateTimeImmutable $releaseDate,
        ?string $description = null
    ): self {
        return new self($id, $title, $artist, $releaseDate, $description);
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getArtist(): string
    {
        return $this->artist;
    }

    public function getReleaseDate(): DateTimeImmutable
    {
        return $this->releaseDate;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function updateDescription(?string $description): void
    {
        $this->description = $description;
    }
}