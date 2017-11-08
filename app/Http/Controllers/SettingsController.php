<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;
use App\SettingStored;
use Settings as SettingsFac;
use Session;

class SettingsController extends Controller
{
	public function index($setting=false) {
		if($setting == false) {
			$setting = SettingsFac::getFirst();
			return redirect()->route('settings', $setting->name);
		}

		$setting = Settings::with('items')->whereName($setting);
		if($setting->count()) {
			$setting = $setting->first();
		}else{
			return abort(404);
		}

		return view('settings.index', compact('setting'));
	}

	public function list() {
		$settings = Settings::paginate(config('starter.pagination'));
		$no = 1;
		return view('settings.list', compact('settings', 'no'));
	}

	public function create() {
		$sort = Settings::orderBy('sort', 'desc')->first();
		$sort = $sort->sort + 1;
		return view('settings.create', compact('sort'));
	}

	public function store(Request $request) {
		$this->validate($request, [
			'name' => 'required|unique:settings,name',
			'display_name' => 'required'
		]);

		Settings::create($request->all());

		Session::flash('success', 'Setting group created successfully');
		return redirect()->route('settings.list');
	}

	public function edit($id) {
		$setting = Settings::find($id);
		return view('settings.edit', compact('setting'));
	}

	public function update(Request $request, $id) {
		$this->validate($request, [
			'name' => 'required|unique:settings,name,' . $id,
			'display_name' => 'required'
		]);

		$setting = Settings::find($id);
		$setting->update($request->all());

		Session::flash('success', 'Setting group updated successfully');
		return redirect()->route('settings.list');
	}

	public function destroy($id) {
		Settings::find($id)->delete();
		Session::flash('success', 'Setting group deleted successfully');
		return redirect()->route('settings.list');
	}

	public function save(Request $request, $setting) {
		$settings = Settings::with('items')->whereName($setting)->first();
		$settings = $settings->items;
		$error = [];
		$store_setting = [];

		// Prepare data to store
		foreach ($settings as $setting) {
			$key = $setting->name;
			$setting = $request->{$key};

			// if value is array then do json_encode
			if(is_array($setting)) {
				$setting = json_encode($setting);
			}

			// Set value from request
			$store_setting[$key] = $setting;

			// Check required fields
			if(SettingsFac::isRequired($key)) {
				if(!isset($request->{$key}) && (SettingsFac::getType($key) !== 'image' && SettingsFac::getType($key) !== 'file')) {
					$error[$key] = 'The ' . SettingsFac::getInfo($key)->display_name . ' field is required';
					$store_setting[$key] = setting($key);
				}
			}

			if(SettingsFac::getType($key) == 'image') {
				if($request->hasFile($key)) {
					if(substr($request->file($key)->getMimeType(), 0, 5) == 'image') {
						$store_setting[$key] = $request->file($key)->getClientOriginalName();
						$request->file($key)->storeAs(media_path() . path() . config('starter.path.images'), $store_setting[$key]);						
					}else{
						$store_setting[$key] = setting($key);
						$error[$key] = 'The ' . SettingsFac::getInfo($key)->display_name . ' field must be an image';
					}
				}else{
					$store_setting[$key] = setting($key);
				}
			}

			if(SettingsFac::getType($key) == 'file') {
				if($request->hasFile($key)) {
					$store_setting[$key] = $request->file($key)->getClientOriginalName();
					$request->file($key)->storeAs(media_path() . path() . config('starter.path.files'), $store_setting[$key]);
				}else{
					$store_setting[$key] = setting($key);
				}
			}

			if(SettingsFac::getType($key) == 'currency') {
				$store_setting[$key] = str_replace(".", "", $setting);
			}

		}

		if(count($error)) {
			Session::flash('error', $error);
			return redirect()->back();
		}

		foreach($store_setting as $key => $setting) {
			$find = SettingStored::whereName($key);
			if($find->count()) {
				SettingStored::whereName($key)->update([
					'name' => $key,
					'value' => $setting
				]);
			}else{
				SettingStored::create([
					'name' => $key,
					'value' => $setting
				]);
			}			
		}

		Session::flash('success', 'Setting updated successfully');
		return redirect()->back();
	}
}
