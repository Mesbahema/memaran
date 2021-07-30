<?php

namespace App\Exceptions;

use Exception;

class MessageNotSend extends Exception
{
    public function render()
    {
        return response()->json(['message' => 'the message has not been sent'], 500);
    }
}
