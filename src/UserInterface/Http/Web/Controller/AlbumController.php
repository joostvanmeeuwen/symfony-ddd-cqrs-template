<?php

namespace App\UserInterface\Http\Web\Controller;

use App\Application\Query\SearchAlbums;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class AlbumController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $queryBus,
    ) {
    }

    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $query = new SearchAlbums(
            searchTerm: null,
            sortBy: 'releaseDate',
            sortDirection: 'desc',
            itemsPerPage: 10,
            page: $request->query->getInt('page', 0)
        );

        $result = $this->queryBus
            ->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();

        return $this->render('albums/index.html.twig', [
            'albums' => $result->items,
            'pagination' => [
                'total' => $result->total,
                'page' => $result->page,
                'itemsPerPage' => $result->itemsPerPage
            ]
        ]);
    }
}