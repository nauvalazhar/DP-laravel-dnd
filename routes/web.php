<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('frontend');


// Notifications
Route::group(['middleware' => ['auth']], function() {
	Route::get('notifications/read', function() {
		return Notifications::read();
	});

	Route::group(['prefix' => 'starter-kit'], function() {
		Route::get('{type}/{file}', function($type, $file) {
			$path = base_path("starter-kit" . path() . 'files' . path() . $file . "." . $type);

			if(file_exists($path)) {
				$content = file_get_contents($path);
				if($type == 'json') {
					$content = json_decode($content);
				}

				return response(['data' => $content], 200);
			}
			return response(['data' => "File can't be found (" . $path . ")"], 404);
		})->name('starterkit.file');
	});
});

Route::group(['prefix' => config('starter.prefix')], function() {
	Auth::routes();

	Route::group(['middleware' => ['auth']], function() {
		// Dashboard
		Route::get('', function(){
			return redirect()->route('dashboard');
		});
		Route::get('dashboard', 'HomeController@index')->name('dashboard');

		// Settings
		Route::group(['prefix' => 'settings'], function() {
			Route::put('{setting?}', 'SettingsController@save')->name('settings.save')->middleware('permission:setting_edit');
			Route::patch('{setting?}', 'SettingsController@save')->name('settings.save')->middleware('permission:setting_edit');
			Route::get('{setting?}', 'SettingsController@index')->name('settings')->middleware('permission:setting_list');
		});

		// Users
		Route::group(['prefix' => 'users'], function() {
			Route::get('', 'UsersController@index')->name('users.index')->middleware('permission:user_list');
			Route::get('create', 'UsersController@create')->name('users.create')->middleware('permission:user_create');
			Route::post('create', 'UsersController@store')->name('users.store')->middleware('permission:user_create');
			Route::get('{id}/notifications', 'UsersController@notifications')->name('users.notifications');
			Route::get('{id}/edit', 'UsersController@edit')->name('users.edit')->middleware('permission:user_edit');
			Route::put('{id}/edit', 'UsersController@update')->name('users.update')->middleware('permission:user_edit');
			Route::patch('{id}/edit', 'UsersController@update')->name('users.update')->middleware('permission:user_edit');
			Route::delete('{id}/delete', 'UsersController@destroy')->name('users.delete')->middleware('permission:user_delete');
		});

		// Roles
		Route::group(['prefix' => 'roles'], function() {
			Route::get('', 'RolesController@index')->name('roles.index')->middleware('permission:role_list');
			Route::get('create', 'RolesController@create')->name('roles.create')->middleware('permission:role_create');
			Route::post('create', 'RolesController@store')->name('roles.store')->middleware('permission:role_create');
			Route::get('{id}/edit', 'RolesController@edit')->name('roles.edit')->middleware('permission:role_edit');
			Route::put('{id}/edit', 'RolesController@update')->name('roles.update')->middleware('permission:role_edit');
			Route::patch('{id}/edit', 'RolesController@update')->name('roles.update')->middleware('permission:role_edit');
			Route::delete('{id}/delete', 'RolesController@destroy')->name('roles.delete')->middleware('permission:role_delete');
		});

		// Developers
		Route::group(['prefix' => 'dev', 'middleware' => ['role:developer']], function() {
			Route::group(['prefix' => 'settings'], function() {
				Route::get('list', 'SettingsController@list')->name('settings.list')->middleware('permission:dev_setting_group_list');
				Route::get('create', 'SettingsController@create')->name('settings.create')->middleware('permission:dev_setting_group_create');
				Route::post('create', 'SettingsController@store')->name('settings.store')->middleware('permission:dev_setting_group_create');
				Route::get('{id}/edit', 'SettingsController@edit')->name('settings.edit')->middleware('permission:dev_setting_group_edit');
				Route::put('{id}/edit', 'SettingsController@update')->name('settings.update')->middleware('permission:dev_setting_group_edit');
				Route::patch('{id}/edit', 'SettingsController@update')->name('settings.update')->middleware('permission:dev_setting_group_edit');
				Route::delete('{id}/delete', 'SettingsController@destroy')->name('settings.delete')->middleware('permission:dev_setting_group_delete');
			});
			
			// Setting Items
			Route::group(['prefix' => 'setting_items'], function() {
				Route::get('list', 'SettingItemsController@list')->name('setting_items.list')->middleware('permission:dev_setting_item_list');
				Route::get('create', 'SettingItemsController@create')->name('setting_items.create')->middleware('permission:dev_setting_item_create');
				Route::post('create', 'SettingItemsController@store')->name('setting_items.store')->middleware('permission:dev_setting_item_create');
				Route::get('{id}/edit', 'SettingItemsController@edit')->name('setting_items.edit')->middleware('permission:dev_setting_item_edit');
				Route::put('{id}/edit', 'SettingItemsController@update')->name('setting_items.update')->middleware('permission:dev_setting_item_edit');
				Route::patch('{id}/edit', 'SettingItemsController@update')->name('setting_items.update')->middleware('permission:dev_setting_item_edit');
				Route::delete('{id}/delete', 'SettingItemsController@destroy')->name('setting_items.delete')->middleware('permission:dev_setting_item_delete');
			});

			// Modules
			Route::group(['prefix' => 'modules'], function() {
				Route::get('', 'ModulesController@index')->name('modules.index')->middleware('permission:dev_module_list');
				Route::get('create', 'ModulesController@create')->name('modules.create')->middleware('permission:dev_module_create');
				Route::post('create', 'ModulesController@store')->name('modules.store')->middleware('permission:dev_module_create');
				Route::get('layout/{name}', 'ModulesController@layout')->name('modules.layout')->middleware('permission:dev_module_layout');
				Route::post('layout/{name}', 'ModulesController@layout')->name('modules.layout')->middleware('permission:dev_module_layout');
				Route::get('{id}/edit', 'ModulesController@edit')->name('modules.edit')->middleware('permission:dev_module_edit');
				Route::put('{id}/edit', 'ModulesController@update')->name('modules.update')->middleware('permission:dev_module_edit');
				Route::patch('{id}/edit', 'ModulesController@update')->name('modules.update')->middleware('permission:dev_module_edit');
				Route::delete('{id}/delete', 'ModulesController@destroy')->name('modules.delete')->middleware('permission:dev_module_delete');
			});
		});
	});
});

Route::get('media/{filename}', function ($filename)
{
	$filename = str_replace("/", path(), $filename);
  $path = storage_path('app' . path() . config('starter.path.media') . path() . $filename);

  if (!File::exists($path)) {
      abort(404);
  }

  $file = File::get($path);
  $type = File::mimeType($path);

  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);

  return $response;
})->where(['filename' => '[0-9A-Za-z./\-_ ]+']);