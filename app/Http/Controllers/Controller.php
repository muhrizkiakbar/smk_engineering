<?php

namespace App\Http\Controllers;

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
}
