<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Album;
use App\Domain\Repository\AlbumRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

class DoctrineAlbumRepository implements AlbumRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function save(Album $album): void
    {
        $this->entityManager->persist($album);
        $this->entityManager->flush();
    }

    public function findById(UuidInterface $id): ?Album
    {
        return $this->entityManager->find(Album::class, $id);
    }

    public function findByArtist(string $artist): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('a')
            ->from(Album::class, 'a')
            ->where('a.artist = :artist')
            ->setParameter('artist', $artist)
            ->getQuery()
            ->getResult();
    }

    public function remove(Album $album): void
    {
        $this->entityManager->remove($album);
        $this->entityManager->flush();
    }
}