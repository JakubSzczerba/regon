<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Services\Result;

use App\Entity\Result;
use App\Provider\Result\ResultProvider;
use GusApi\GusApi;
use GusApi\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class ResultService
{
    private ResultProvider $resultProvider;

    private EntityManagerInterface $em;

    public function __construct(ResultProvider $resultProvider, EntityManagerInterface $em)
    {
        $this->resultProvider = $resultProvider;
        $this->em = $em;
    }

    public function saveData(string $regon): ?Result
    {
        $data = [];
        $gus = new GusApi($_ENV['GUS_API_KEY']);

        try {
            $sessionId = $gus->login();
            $data = $gus->getByRegon($sessionId, $regon);
        } catch (NotFoundException) {
            echo 'Brak danych dla numeru REGON: ' . $regon;
        }

        $result = null;
        if (!empty($data)) {
            $result = $this->resultProvider->createResult($data);

            $this->em->persist($result);
            $this->em->flush();
        }

        return $result;
    }

}