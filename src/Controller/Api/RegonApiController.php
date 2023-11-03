<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Controller\Api;

use App\Command\Result\CreateResultCommand;
use App\Command\Result\GetResultCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api')]
class RegonApiController extends AbstractController
{
    private GetResultCommand $getResultCommand;

    private CreateResultCommand $createResultCommand;

    public function __construct(GetResultCommand $getResultCommand, CreateResultCommand $createResultCommand)
    {
        $this->getResultCommand = $getResultCommand;
        $this->createResultCommand = $createResultCommand;
    }

    #[Route('/regon', name: "listRegon", methods: ['GET'])]
    public function listRegon(): JsonResponse
    {
        return $this->getResultCommand->execute();
    }

    #[Route('/regon', name: "searchRegon", methods: ['POST'])]
    public function searchRegon(Request $request): JsonResponse
    {
        return $this->createResultCommand->execute($request);
    }
}