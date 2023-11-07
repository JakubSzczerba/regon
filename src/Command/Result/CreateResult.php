<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Command\Result;

class CreateResult
{
    private string $regon;

    public function __construct(string $regon)
    {
        $this->regon = $regon;
    }

    public function getRegon(): string
    {
        return $this->regon;
    }
}