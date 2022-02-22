<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Auth;
use App\Events\MessageSent;

class ChatsController extends Controller
{

    /**
     * Fetch all messages
     *
     * @return Message
     */
    public function fetchMessages($id)
    {
        return Message::with('user')->whereRequestId($id)->get();
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        $message = $user->messages()->create([
            'message' => $request->input('message'),
            'request_id' => $request->input('requestId')
        ]);

        broadcast(new MessageSent($user, $message, $request->input('requestId')))->toOthers();

        return ['status' => 'Message Sent!'];
    }
}
