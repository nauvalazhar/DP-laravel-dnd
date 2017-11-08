<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
	protected $table = "notifications";
	protected $fillable = ['from', 'to', 'title', 'content', 'status', 'link'];
}
