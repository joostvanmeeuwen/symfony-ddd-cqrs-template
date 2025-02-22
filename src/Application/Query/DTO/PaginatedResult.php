<?php

namespace App\Application\Query\DTO;

use JsonSerializable;

readonly class PaginatedResult implements JsonSerializable
{
    /**
     * @param array<Album> $items
     */
    public function __construct(
        public array $items,
        public int $total,
        public int $page,
        public int $itemsPerPage
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'items' => $this->items,
            'total' => $this->total,
            'page' => $this->page,
            'itemsPerPage' => $this->itemsPerPage,
            'totalPages' => ceil($this->total / $this->itemsPerPage)
        ];
    }
}