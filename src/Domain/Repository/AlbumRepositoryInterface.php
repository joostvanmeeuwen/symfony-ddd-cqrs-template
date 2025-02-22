<?php

namespace App\Domain\Repository;

use App\Application\Query\DTO\PaginatedResult;
use App\Domain\Model\Album;
use Ramsey\Uuid\UuidInterface;

interface AlbumRepositoryInterface
{
    public function save(Album $album): void;

    public function findById(UuidInterface $id): ?Album;

    public function findByArtist(string $artist): array;

    public function remove(Album $album): void;

    /**
     * @return PaginatedResult<Album>
     */
    public function search(
        ?string $searchTerm,
        string $sortBy,
        string $sortDirection,
        int $itemsPerPage,
        int $page
    ): PaginatedResult;
}