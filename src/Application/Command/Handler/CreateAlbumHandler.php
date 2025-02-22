<?php

namespace App\Application\Command\Handler;

use App\Application\Command\CreateAlbum;
use App\Domain\Model\Album;
use App\Domain\Repository\AlbumRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateAlbumHandler
{
    public function __construct(
        private AlbumRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreateAlbum $command): void
    {
        $album = Album::create(
            Uuid::fromString($command->id),
            $command->title,
            $command->artist,
            $command->releaseDate,
            $command->description
        );

        $this->repository->save($album);
    }
}