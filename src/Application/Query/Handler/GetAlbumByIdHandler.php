<?php

namespace App\Application\Query\Handler;

use App\Application\Query\DTO\Album;
use App\Application\Query\GetAlbumById;
use App\Domain\Repository\AlbumRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetAlbumByIdHandler
{
    public function __construct(
        private AlbumRepositoryInterface $repository
    ) {
    }

    public function __invoke(GetAlbumById $query): ?Album
    {
        $album = $this->repository->findById(Uuid::fromString($query->id));

        if ($album === null) {
            return null;
        }

        return new Album(
            $album->getId()->toString(),
            $album->getTitle(),
            $album->getArtist(),
            $album->getReleaseDate(),
            $album->description
        );
    }
}