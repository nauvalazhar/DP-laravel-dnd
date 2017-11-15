<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\[MODULE_MODEL_NAME];

class [MODULE_CONTROLLER_NAME] extends Controller
{
    public function index() {
    	$[MODULE_MODEL_NAME_VAR] = [MODULE_MODEL_NAME]::paginate(10);
    	return view('[MODULE_NAME_PLURAL].index');
    }

    public function create() {
    	return view('[MODULE_NAME_PLURAL].form', 'create');
    }

    public function store() {

    }

    public function edit() {

    }

    public function update() {

    }

    public function delete() {

    }
}
