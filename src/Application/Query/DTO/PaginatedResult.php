<?php

namespace App\Application\Query\DTO;

use JsonSerializable;

class PaginatedResult implements JsonSerializable
{
    /**
     * @param array<Album> $items
     */
    public function __construct(
        public readonly array $items,
        public readonly int $total,
        public readonly int $page,
        public readonly int $itemsPerPage
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