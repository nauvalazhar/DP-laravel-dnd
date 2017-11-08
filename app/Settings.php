<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settings extends Model
{
	use SoftDeletes;
	
	protected $table = "settings";
	protected $fillable = ['name', 'display_name', 'description', 'sort'];

	public function items() {
		return $this->hasMany('App\SettingItems');
	}
}
