<?php

namespace App\Application\Query\Handler;

use App\Application\Query\DTO\PaginatedResult;
use App\Application\Query\SearchAlbums;
use App\Domain\Repository\AlbumRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SearchAlbumsHandler
{
    public function __construct(
        private readonly AlbumRepositoryInterface $repository
    ) {
    }

    public function __invoke(SearchAlbums $query): PaginatedResult
    {
        return $this->repository->search(
            $query->searchTerm,
            $query->sortBy,
            $query->sortDirection,
            $query->itemsPerPage,
            $query->page
        );
    }
}