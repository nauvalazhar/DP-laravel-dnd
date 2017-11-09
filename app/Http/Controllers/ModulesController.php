<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules;

class ModulesController extends Controller
{
    public function layout() {
        return view('modules.layout');
    }

    public function create() {
        return view('modules.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'display_name' => 'required',
            'type' => 'required'
        ]);

        $input = $request->all();
        $modules = Modules::create($input);

        return redirect()->route('modules.layout', $modules->name);
    }

}
