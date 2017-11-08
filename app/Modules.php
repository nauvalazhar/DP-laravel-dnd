<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modules extends Model
{
	use SoftDeletes;

	protected $table = "modules";
	protected $fillable = ['name', 'display_name', 'description', 'type'];
}
