<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class ParameterException extends \Exception
{
    public function __construct($message, $code = Response::HTTP_PRECONDITION_REQUIRED, \Throwable $previous = null){
        parent::__construct($message, $code, $previous);
    }
}