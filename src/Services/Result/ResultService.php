<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Services\Result;

use App\Entity\Result;
use App\Provider\Result\ResultProvider;
use App\Repository\ResultRepository;
use GusApi\GusApi;
use GusApi\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResultService
{
    private ResultProvider $resultProvider;

    private ResultRepository $resultRepository;

    public function __construct(ResultProvider $resultProvider, ResultRepository $resultRepository)
    {
        $this->resultProvider = $resultProvider;
        $this->resultRepository = $resultRepository;
    }

    public function saveData(string $regon): JsonResponse|Result|null
    {
        $data = [];
        $gus = new GusApi($_ENV['GUS_API_KEY']);

        try {
            $sessionId = $gus->login();
            $data = $gus->getByRegon($sessionId, $regon);
        } catch (NotFoundException) {
            return new JsonResponse(['message' => 'Brak danych dla numeru REGON: ' . $regon], 404);
        }

        $result = null;
        if (!empty($data)) {
            $result = $this->resultProvider->createResult($data);

            $this->resultRepository->save($result);
        }

        return $result;
    }
}