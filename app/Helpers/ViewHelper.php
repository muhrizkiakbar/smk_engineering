<?php

// Code within app\Helpers\Helper.php

namespace App\Helpers;

class ViewHelper
{
    public static function shout(string $string)
    {
        return strtoupper($string);
    }

    public static function render_condition($data)
    {
        if ($data) {

            return '<button class="btn btn-sm btn-circle btn-success">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7" />
                        </svg>
                        </button>';
        }


        return '<button class="btn btn-sm btn-circle">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">
            <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12" />
        </svg>
        </button>';
    }
}
