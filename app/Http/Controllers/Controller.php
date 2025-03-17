<?php

namespace App\Http\Controllers;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

abstract class Controller
{
    public function formatPhoneNumber($number)
    {
        $number = preg_replace('/[^0-9]/', '', $number);

        if (substr($number, 0, 1) === '0') {
            $number = '+62' . substr($number, 1);
        } elseif (substr($number, 0, 2) !== '62') {
            $number = '+62' . $number;
        } else {
            $number = '+' . $number;
        }

        return $number;
    }

    public function calculate_velocity(string $formula, float $parameterValue): float
    {
        if (!str_contains($formula, '$water_level')) {
            return 0;
        }
        $processedFormula = str_replace('$water_level', $parameterValue, $formula);

        $expressLanguage =  new ExpressionLanguage();
        return $expressLanguage->evaluate($processedFormula, ['$water_level' => $parameterValue]);
    }
}
