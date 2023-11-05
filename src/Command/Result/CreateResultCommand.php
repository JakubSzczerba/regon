<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Command\Result;

use App\Services\Result\RegonValidator;
use App\Services\Result\ResultService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class CreateResultCommand
{
    private RegonValidator $regonValidator;

    private ResultService $resultService;

    private SerializerInterface $serializer;

    public function __construct(RegonValidator $regonValidator, ResultService $resultService, SerializerInterface $serializer)
    {
        $this->regonValidator = $regonValidator;
        $this->resultService = $resultService;
        $this->serializer = $serializer;
    }

    public function execute(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return new JsonResponse(['error' => 'Nie podano numeru REGON'], 400);
        }

        if (!($this->regonValidator->validate($data['regon']))) {
            return new JsonResponse(['error' => 'Niepoprawny numer REGON'], 400);
        }

        $result = $this->resultService->saveData($data['regon']);
        if ($result === null) {
            return new JsonResponse(['message' => 'Brak danych dla numeru REGON: ' . $data['regon']], 404);
        }

        return new JsonResponse($this->serializer->serialize($result, 'json'), 200);
    }

}