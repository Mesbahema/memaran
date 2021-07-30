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
        
        $message = $this->createOrUpdate($request->number, $request->body, $request->id);
        
        if (!$this->notSent()){
            
            $message->is_sent = true;
            $message->save();
            return $this->success($message->id);
        }
        //switch to other api
        if ($request->route()->getName() == 'send1')
            return $this->send2($request);

        throw new MessageNotSend();
    }
    /**
     * @param SendMessageRequest $request
     * 
     * @return
     */
    public function send2(SendMessageRequest $request)
    {
        $message = $this->createOrUpdate($request->number, $request->body, $request->id);

        if (!$this->notSent()){
            
            $message->is_sent = true;
            $message->save();
            return $this->success($message->id);
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

    public function success($id)
    {
        return response()->json([
            'message' => 'the message has been sent',
            'id' => $id]);
    }

    protected function createOrUpdate(string $number, string $body, $id = null)
    {
        if(!$id) {
            return Message::Create([
                'number' => $number,
                'body' => $body,
            ]);
        }

        $message = Message::find($id);
        $message->update([
            'number' => $number,
            'body' => $body,
        ]);
        return $message;
    }
}
