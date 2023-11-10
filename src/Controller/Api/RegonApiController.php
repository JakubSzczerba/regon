<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Controller\Api;

use App\Command\Result\CreateResult;
use App\Repository\ResultRepository;
use App\Services\Result\RegonValidator;
use GusApi\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api')]
class RegonApiController extends AbstractController
{
    private ResultRepository $resultRepository;

    private SerializerInterface $serializer;

    private RegonValidator $regonValidator;

    public function __construct(ResultRepository $resultRepository, SerializerInterface $serializer, RegonValidator $regonValidator)
    {
        $this->resultRepository = $resultRepository;
        $this->serializer = $serializer;
        $this->regonValidator = $regonValidator;
    }

    #[Route('/regon', name: "listRegon", methods: ['GET'])]
    public function listRegon(): JsonResponse
    {
        $results = $this->resultRepository->getResults();

        if (empty($results)) {
            return new JsonResponse(['message' => 'Brak zapisanych wyników'], 200);
        }

        return new JsonResponse($this->serializer->serialize($results, 'json'), 200);
    }

    #[Route('/regon', name: "searchRegon", methods: ['POST'])]
    public function searchRegon(Request $request, MessageBusInterface $commandBus): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return new JsonResponse(['error' => 'Nie podano numeru REGON'], 400);
        }

        if (!($this->regonValidator->validate($data['regon']))) {
            return new JsonResponse(['error' => 'Niepoprawny numer REGON'], 400);
        }

        $commandBus->dispatch(new CreateResult($data['regon']));

        return new JsonResponse(['message' => 'Dodano wynik wyszukiwania'], 200);
    }
}