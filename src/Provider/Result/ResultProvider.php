<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Provider\Result;

use App\Entity\Result;

class ResultProvider
{
    public function createResult(array $data): Result
    {
        $result = new Result();
        foreach ($data as $value) {
            $result
                ->setRegon($value->getRegon())
                ->setRegon14($value->getRegon14())
                ->setName($value->getName())
                ->setProvince($value->getProvince())
                ->setDistrict($value->getDistrict())
                ->setCommunity($value->getCommunity())
                ->setCity($value->getCity())
                ->setZipCode($value->getZipCode())
                ->setStreet($value->getStreet())
                ->setType($value->getType())
                ->setSilo($value->getSilo());
        }

        return $result;
    }
}