<?php

namespace App\Exceptions;

use Exception;

class BalanceMismatchException extends Exception
{
    public function __construct($message = "Initial balance does not match the current balance..")
    {
        parent::__construct($message);
    }
}
