<?php

namespace App\Exceptions;

use Exception;

class Error extends Exception
{
    protected $errorCode;
    protected $httpCode;

    public function __construct(int $errorCode, int $httpCode, $messages = '')
    {
        $this->errorCode = $errorCode;
        $this->httpCode = $httpCode;
        $this->message = $messages;
    }

    public function render()
    {
        $message = !empty($this->message)?$this->message:config("errors.{$this->errorCode}");
        return response()->json([
            'code'  =>     $this->errorCode,
            'msg'   =>      $message,
        ],$this->httpCode);
    }
}