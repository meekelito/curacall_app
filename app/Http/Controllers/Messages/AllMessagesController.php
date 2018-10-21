<?php
namespace App\Http\Controllers\Messages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Room;
use App\Participants;
use App\Messages;
use App\Users;
use DB;
use Cache;
use Auth;

class AllMessagesController extends Controller
{
  public function index()
  {
  	$messages = Room::leftJoin('participants AS b','rooms.id','=','b.room_id') 
  						->leftJoin('messages AS c','rooms.last_message','=','c.id')
  						->leftJoin('users AS d','c.user_id','=','d.id')
  						->where('b.user_id',Auth::user()->id)
  						->select('rooms.id AS room_id','b.is_read','c.message','c.created_at','d.fname','d.lname')
  						->groupBy('rooms.id','b.is_read')
  						->get();  

    return view( 'all-messages',[ 'messages' => $messages ] );

  }
}
