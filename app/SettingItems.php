<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingItems extends Model
{
	use SoftDeletes;

	protected $table = "setting_items";
	protected $fillable = ['settings_id', 'name', 'display_name', 'type', 'description', 'sort'];

	public function group() {
		return $this->belongsTo('App\Settings', 'settings_id');
	}
}
