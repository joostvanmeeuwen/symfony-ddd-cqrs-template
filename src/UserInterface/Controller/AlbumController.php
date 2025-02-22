<?php

namespace App\UserInterface\Controller;

use App\Application\Command\CreateAlbum;
use App\Application\Query\DTO\PaginatedResult;
use App\Application\Query\SearchAlbums;
use App\UserInterface\DTO\CreateAlbumRequest;
use App\UserInterface\DTO\SearchAlbumsRequest;
use DateTimeImmutable;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[OA\Tag(name: 'Albums')]
class AlbumController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
        private readonly MessageBusInterface $queryBus,
    ) {
    }

    #[Route('/api/v1/albums', methods: ['POST'])]
    #[OA\Response(
        response: 201,
        description: 'Creates a new album',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'id', type: 'string', example: '123e4567-e89b-12d3-a456-426614174000')
            ]
        )
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: new Model(type: CreateAlbumRequest::class)
        )
    )]
    public function create(
        #[MapRequestPayload] CreateAlbumRequest $request
    ): JsonResponse {
        $id = Uuid::uuid4()->toString();

        $command = new CreateAlbum(
            id: $id,
            title: $request->title,
            artist: $request->artist,
            releaseDate: new DateTimeImmutable($request->releaseDate),
            description: $request->description
        );

        $this->commandBus->dispatch($command);

        return new JsonResponse(['id' => $id], Response::HTTP_CREATED);
    }

    #[Route('/api/v1/albums', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns the album list',
        content: new Model(type: PaginatedResult::class)
    )]
    #[OA\Parameter(
        name: 'q',
        description: 'Search term',
        in: 'query',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'sortBy',
        description: 'Field to sort by',
        in: 'query',
        schema: new OA\Schema(type: 'string', enum: ['title', 'artist', 'releaseDate'])
    )]
    #[OA\Parameter(
        name: 'sortDirection',
        description: 'Sort direction',
        in: 'query',
        schema: new OA\Schema(type: 'string', enum: ['asc', 'desc'])
    )]
    #[OA\Parameter(
        name: 'itemsPerPage',
        description: 'Number of items per page',
        in: 'query',
        schema: new OA\Schema(type: 'integer', minimum: 1, maximum: 100)
    )]
    #[OA\Parameter(
        name: 'page',
        description: 'Page number',
        in: 'query',
        schema: new OA\Schema(type: 'integer', minimum: 0)
    )]
    public function search(
        #[MapQueryString] SearchAlbumsRequest $request
    ): JsonResponse {
        $query = new SearchAlbums(
            searchTerm: $request->searchTerm,
            sortBy: $request->sortBy,
            sortDirection: $request->sortDirection,
            itemsPerPage: $request->itemsPerPage,
            page: $request->page
        );

        $result = $this->queryBus->dispatch($query);

        return new JsonResponse($result);
    }
}