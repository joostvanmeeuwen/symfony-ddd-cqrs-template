<?php

namespace App\UserInterface\Http\Rest\DTO;

use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema(
    schema: 'CreateAlbumRequest',
    description: 'DTO for creating a new album',
    required: ['title', 'artist', 'releaseDate']
)]
class CreateAlbumRequest
{
    public function __construct(
        #[OA\Property(
            description: 'The title of the album',
            example: 'Abbey Road'
        )]
        #[Assert\NotBlank(message: 'Title is required')]
        #[Assert\Length(
            min: 1,
            max: 255,
            minMessage: 'Title must be at least {{ limit }} character long',
            maxMessage: 'Title cannot be longer than {{ limit }} characters'
        )]
        public readonly string $title,

        #[OA\Property(
            description: 'The artist of the album',
            example: 'The Beatles'
        )]
        #[Assert\NotBlank(message: 'Artist is required')]
        #[Assert\Length(
            min: 1,
            max: 255,
            minMessage: 'Artist must be at least {{ limit }} character long',
            maxMessage: 'Artist cannot be longer than {{ limit }} characters'
        )]
        public readonly string $artist,

        #[OA\Property(
            description: 'The release date of the album',
            format: 'date',
            example: '1969-09-26'
        )]
        #[Assert\NotBlank(message: 'Release date is required')]
        #[Assert\Date(message: 'Invalid date format. Use YYYY-MM-DD')]
        #[SerializedName('releaseDate')]
        public readonly string $releaseDate,

        #[OA\Property(
            description: 'Optional description of the album',
            example: 'The last album recorded by the Beatles',
            nullable: true
        )]
        #[Assert\Length(
            max: 1000,
            maxMessage: 'Description cannot be longer than {{ limit }} characters'
        )]
        public readonly ?string $description = null,
    ) {
    }
}