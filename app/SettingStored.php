<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingStored extends Model
{
	protected $table = "setting_stored";
	protected $fillable = ["name", "value"];
}
