<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Command\Result;

use App\Repository\ResultRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetResultCommand
{
    private ResultRepository $resultRepository;

    private SerializerInterface $serializer;

    public function __construct(ResultRepository $resultRepository, SerializerInterface $serializer)
    {
        $this->resultRepository = $resultRepository;
        $this->serializer = $serializer;
    }

    public function execute(): JsonResponse
    {
        $results = $this->resultRepository->findAll();

        if (empty($results)) {
            return new JsonResponse(['message' => 'Brak zapisanych wyników'], 200);
        }

        return new JsonResponse($this->serializer->serialize($results, 'json'), 200);
    }
}