<?php

namespace App\Http\Controllers;

use App\Exceptions\MessageNotSend;
use App\Http\Requests\SendMessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class SendMessageController extends Controller
{
    /**
     * @param SendMessageRequest $request
     * 
     * @return
     */
    public function send1(SendMessageRequest $request)
    {
        $message = Message::firstOrCreate([
            'number' => $request->number,
            'body' => $request->body,
        ]);
        
        if (!$this->notSent()){
            return $this->success();
        }
        //switch to other api
        if ($request->route()->getName() == 'send1')
            return $this->send2($request);

        return $this->fail();
    }
    /**
     * @param SendMessageRequest $request
     * 
     * @return
     */
    public function send2(SendMessageRequest $request)
    {

        $message = Message::firstOrCreate([
            'number' => $request->number,
            'body' => $request->body,
        ]);

        if (!$this->notSent()){
            return $this->success();
        }

        //switch to other api
        if ($request->route()->getName() == 'send2')
            return $this->send1($request);

        throw new MessageNotSend();
    }

    /**
     * @return int
     */
    public function notSent()
    {
        return rand(0, 2);
    }

    public function success()
    {
        return response()->json(['message' => 'the message has been sent']);
    }

    public function fail()
    {
        return response()->json(['message' => 'the message has not been sent'], 500);
    }
}
