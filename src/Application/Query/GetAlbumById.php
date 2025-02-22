<?php

namespace App\Application\Query;

use Symfony\Component\Validator\Constraints as Assert;

class GetAlbumById
{
    public function __construct(
        #[Assert\NotBlank(message: 'Album ID cannot be empty')]
        #[Assert\Uuid(message: 'Invalid UUID format')]
        public readonly string $id
    ) {
    }
}