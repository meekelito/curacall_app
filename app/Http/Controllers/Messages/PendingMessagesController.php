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

class PendingMessagesController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
  	$messages = Room::leftJoin('participants AS b','rooms.id','=','b.room_id') 
  						->leftJoin('messages AS c','rooms.last_message','=','c.id')
  						->leftJoin('users AS d','c.user_id','=','d.id')
  						->where('b.user_id',Auth::user()->id)
              ->where('b.is_read',1)
  						->select('rooms.id AS room_id','c.message','c.created_at','d.fname','d.lname')
  						->groupBy('rooms.id')
  						->get(); 

    return view( 'pending-messages',[ 'messages' => $messages ] );

  }
}
