<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
  protected $fillable = ['name','user_id'];

  public function user()
	{
	  return $this->belongsTo(User::class);
	}
	
  public function messages()
  {
    return $this->hasMany(Message::class);
  }
}

