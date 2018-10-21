<?php

namespace App\Http\Controllers;

use App\Message;
use App\Room;
use App\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;



class ChatsController extends Controller
{
	public function __construct()
	{
	  $this->middleware('auth');
	}

	/**
	 * Show chats
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
	  // return view('chat');
	  $document = Participant::where("room_id","=",$request->input('room'))
								->where("user_id","=",Auth::user()->id)
								->firstOrFail();
    $document->is_read = 1; 
    $document->save();


    $info = Room::leftJoin('participants AS b','rooms.id','=','b.room_id') 
						->leftJoin('users AS c','b.user_id','=','c.id')
						->where('rooms.id',$request->input('room'))
            ->where('b.user_id','!=',Auth::user()->id)
						->select('c.fname','c.lname','c.email','c.mobile_no')
						->get();  

	  return view('chat',['room_id' => $request->input('room'),'recipient_info' => $info ]);
	}

	/**
	 * Fetch all messages
	 *
	 * @return Message
	 */
	public function fetchMessages(Request $request)
	{ 
	  return Message::with('user')->get();
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
	  	'room_id' => $request->input('room_id'), 
	    'message' => $request->input('message')
	  ]);

		Participant::where('room_id', '=', $request->input('room_id')  )->update(['is_read' => 0]);

	  broadcast(new MessageSent($user, $message))->toOthers();

	  return ['status' => 'Message Sent!'];
	}
}
