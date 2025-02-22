<?php

namespace App\Application\Query\Handler;

use App\Application\Query\DTO\PaginatedResult;
use App\Application\Query\SearchAlbums;
use App\Domain\Repository\AlbumRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class SearchAlbumsHandler
{
    public function __construct(
        private AlbumRepositoryInterface $repository
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