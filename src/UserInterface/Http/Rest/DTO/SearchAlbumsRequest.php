<?php

namespace App\UserInterface\Http\Rest\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class SearchAlbumsRequest
{
    public function __construct(
        #[Assert\Length(
            min: 2,
            max: 255,
            minMessage: 'Search term must be at least {{ limit }} characters long',
            maxMessage: 'Search term cannot be longer than {{ limit }} characters'
        )]
        public ?string $searchTerm = null,

        #[Assert\Choice(
            choices: ['title', 'artist', 'releaseDate'],
            message: 'Sort field must be one of: title, artist, releaseDate'
        )]
        public string $sortBy = 'releaseDate',

        #[Assert\Choice(
            choices: ['asc', 'desc'],
            message: 'Sort direction must be either "asc" or "desc"'
        )]
        public string $sortDirection = 'desc',

        #[Assert\Range(
            notInRangeMessage: 'Items per page must be between {{ min }} and {{ max }}',
            min: 1,
            max: 100
        )]
        public int $itemsPerPage = 20,

        #[Assert\PositiveOrZero(message: 'Page number cannot be negative')]
        public int $page = 0
    ) {
    }

    public static function fromRequest(array $params): self
    {
        return new self(
            searchTerm: $params['q'] ?? null,
            sortBy: $params['sortBy'] ?? 'releaseDate',
            sortDirection: $params['sortDirection'] ?? 'desc',
            itemsPerPage: (int)($params['itemsPerPage'] ?? 20),
            page: (int)($params['page'] ?? 0)
        );
    }
}