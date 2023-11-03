<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Services\Result;

class RegonValidator
{
    public function validate(string $regon): bool
    {
        $regon = preg_replace('/\D/', '', $regon);

        if (strlen($regon) !== 9 && strlen($regon) !== 14) {
            return false;
        }

        if (strlen($regon) === 9) {
            $weights = [8, 9, 2, 3, 4, 5, 6, 7];
            $checksum = 0;

            for ($i = 0; $i < 8; $i++) {
                $checksum += intval($regon[$i]) * $weights[$i];
            }

            $checksum %= 11;
            if ($checksum === 10) {
                $checksum = 0;
            }

            return $checksum === intval($regon[8]);
        }

        return true;
    }
}