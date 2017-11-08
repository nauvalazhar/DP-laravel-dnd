<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SettingItems;
use Session;

class SettingItemsController extends Controller
{
	public function index() {
		return view('setting_items.index');
	}

	public function list() {
		$settings = SettingItems::paginate(config('starter.pagination'));
		$no = 1;
		return view('setting_items.list', compact('settings', 'no'));
	}

	public function create() {
		$sort = SettingItems::orderBy('sort', 'asc')->get();
		$sort_arr = [];
		foreach($sort as $s) {
			$sort_arr[$s->settings_id] = $s->sort + 1;
		}
		$sort = $sort_arr;
		return view('setting_items.create', compact('sort'));
	}

	public function store(Request $request) {
		$this->validate($request, [
			'name' => 'required|unique:settings,name',
			'display_name' => 'required',
			'type' => 'required'
		]);

		$input = $request->all();
		$input['type'] = $input['type'] . "|" . (count($input['attrs']['options']) ? $input['attrs']['options'] : 'null') . "|" . ($input['attrs']['required'] == 1 ? 'required' : 'not-required');

		SettingItems::create($input);

		Session::flash('success', 'Setting group created successfully');
		return redirect()->route('setting_items.list');
	}

	public function edit($id) {
		$setting = SettingItems::find($id);
		return view('setting_items.edit', compact('setting'));
	}

	public function update(Request $request, $id) {
		$this->validate($request, [
			'name' => 'required|unique:settings,name,' . $id,
			'display_name' => 'required'
		]);

		$input = $request->all();
		$input['type'] = $input['type'] . "|" . (count($input['attrs']['options']) ? $input['attrs']['options'] : 'null') . "|" . ($input['attrs']['required'] == 1 ? 'required' : 'not-required');

		$setting = SettingItems::find($id);
		$setting->update($input);

		Session::flash('success', 'Setting group updated successfully');
		return redirect()->route('setting_items.list');
	}

	public function destroy($id) {
		SettingItems::find($id)->delete();
		Session::flash('success', 'Setting group deleted successfully');
		return redirect()->route('setting_items.list');
	}
}
