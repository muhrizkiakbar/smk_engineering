<?php
namespace App\Enum;


enum PriceEnum:string
{
    case MAKAN = 'makan';
    case HOTEL = 'hotel';
    case HARIAN = 'harian';
    case TRANSPORT = 'transport';
}
