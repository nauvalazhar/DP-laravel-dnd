<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleFields extends Model
{
	protected $table = "module_fields";
	protected $fillable = ["modules_id", "name", "display_name", "description", "type"];
	public $timestamps = false;
}
