<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Application\Query\DTO\Album as AlbumDto;
use App\Application\Query\DTO\PaginatedResult;
use App\Domain\Model\Album;
use App\Domain\Repository\AlbumRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

readonly class DoctrineAlbumRepository implements AlbumRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
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

    public function search(
        ?string $searchTerm,
        string $sortBy,
        string $sortDirection,
        int $itemsPerPage,
        int $page
    ): PaginatedResult {
        $qb = $this->entityManager->createQueryBuilder()
            ->select('a')
            ->from('App\Domain\Model\Album', 'a');

        if ($searchTerm) {
            $qb->andWhere('a.title LIKE :term OR a.artist LIKE :term')
                ->setParameter('term', '%' . $searchTerm . '%');
        }

        $countQb = clone $qb;
        $total = $countQb->select('COUNT(a.id)')->getQuery()->getSingleScalarResult();

        $qb->orderBy('a.' . $sortBy, $sortDirection);

        $qb->setFirstResult($page * $itemsPerPage)
            ->setMaxResults($itemsPerPage);

        $albums = $qb->getQuery()->getResult();

        $items = array_map(
            fn($album) => new AlbumDto(
                $album->getId()->toString(),
                $album->getTitle(),
                $album->getArtist(),
                $album->getReleaseDate(),
                $album->getDescription()
            ),
            $albums
        );

        return new PaginatedResult(
            $items,
            $total,
            $page,
            $itemsPerPage
        );
    }
}