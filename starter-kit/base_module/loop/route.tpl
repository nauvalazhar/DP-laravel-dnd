Route::get('[MODULE_NAME]', '[MODULE_CONTROLLER_NAME]@index')->name('[MODULE_NAME].index')->middleware('permission:[MODULE_NAME]_list');
Route::get('[MODULE_NAME]/create', '[MODULE_CONTROLLER_NAME]@create')->name('[MODULE_NAME].create')->middleware('permission:[MODULE_NAME]_create');
Route::post('[MODULE_NAME]/create', '[MODULE_CONTROLLER_NAME]@create')->name('[MODULE_NAME].create')->middleware('permission:[MODULE_NAME]_create');
Route::get('[MODULE_NAME]/{id}/edit', '[MODULE_CONTROLLER_NAME]@edit')->name('[MODULE_NAME].edit')->middleware('permission:[MODULE_NAME]_edit');
Route::patch('[MODULE_NAME]/{id}/edit', '[MODULE_CONTROLLER_NAME]@edit')->name('[MODULE_NAME].edit')->middleware('permission:[MODULE_NAME]_edit');
Route::update('[MODULE_NAME]/{id}/edit', '[MODULE_CONTROLLER_NAME]@update')->name('[MODULE_NAME].update')->middleware('permission:[MODULE_NAME]_edit');
Route::delete('[MODULE_NAME]/{id}/delete', '[MODULE_CONTROLLER_NAME]@delete')->name('[MODULE_NAME].delete')->middleware('permission:[MODULE_NAME]_delete');