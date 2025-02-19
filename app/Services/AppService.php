<?php

namespace App\Services;

class AppService
{
    public function __construct()
    {
        // Example logic for initializing ApiService
    }

    public function convertToFloat($currency)
    {
        // Remove the "Rp" currency symbol and any leading or trailing spaces
        $currency = trim(str_replace('Rp', '', $currency));

        // Remove any periods (thousands separator)
        $currency = str_replace('.', '', $currency);

        // Replace the comma with a period (decimal separator)
        $currency = str_replace(',', '.', $currency);

        // Convert the string to float and return
        return (float) $currency;
    }

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
}
