<?php

namespace App\Facades;
use App\Settings;
use App\SettingItems;
use App\SettingStored;
use Datatype;

class SettingsFacade {
	public function getGroup() {
		$settings = Settings::orderBy('sort')->get();
		return $settings;
	}

	public function get($name) {
		$get = SettingStored::whereName($name)->first();
		if(count($get)) {
			return $get->value;
		}
	}

	public function getType($name) {
		$get = SettingItems::whereName($name)->first();
		if(count($get)) {
			return Datatype::get($get->type);
		}
	}

	public function isRequired($name) {
		$get = SettingItems::whereName($name)->first();
		if(count($get)) {
			return (Datatype::getRequired($get->type) == 'required' ? true : false);
		}
	}

	public function getInfo($name) {
		$get = SettingItems::whereName($name)->first();
		if(count($get)) {
			return $get;
		}
	}

	public function getFirst() {
		$setting = Settings::orderBy('sort')->first();
		return $setting;
	}
}