<?php
namespace App\Http\Controllers\Messages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Message;
use App\Room;
use App\Participant;
use Auth;

class NewMessageController extends Controller
{

  public function index()
  {
  	$users = User::all()->except(Auth::user()->id);
    return view('new-message',['users'=>$users] );
  }

  public function addMessage(Request $request)
  {
    $user = Auth::user();

  	$recipient = $request->input("recipient");
    $message = $request->input("message");
 
    $room_id = Room::create(['name'=>'room', 'user_id'=>$user ])->id;

    $res = Participant::create(
    [
      'room_id'=> $room_id, 
      'user_id'=>$recipient,
      'is_read' => 0 
    ],
     [
      'room_id'=>$room_id, 
      'user_id'=>Auth::user()->id,
      'is_read' => 0 
    ]);

    $message = $user->messages()->create([
      'room_id' => $room_id, 
      'message' => $request->input('message')
    ]);
 
  	return $message; 
  }

}
