<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules;
use DB;

class ModulesController extends Controller
{
    public function layout() {
        return view('modules.layout');
    }

    public function create() {
        return view('modules.create');
    }

    public function generate(Request $request) {
        $setting = json_decode($request->setting);
        $module_name = system_name($setting->name);
        $module_name_plural = str_plural($module_name);
        $module_display_name = $setting->display_name;
        $module_display_name_plural = str_plural($setting->display_name);
        $module_type = $setting->type;
        $module_layout = $request->layout;

        $module_path = module_path($module_name_plural);

        $tables = array_map('reset', DB::select('SHOW TABLES'));
        // foreach($tables as $i=>$tb) {
        //     $tb = (array) $tb;
        // }

        // $errors = [];
        // if(is_dir($module_path)) {
        //     $errors[] = 'Module already exist';
        // }else{
        //     return 'a';
        // }
        
        $module_column_header = "";
        $module_column_row = "";

        $base_template = [];
        $base_template['index'] = get_base_mvc($module_type . '.index');
        $base_template['form'] = get_base_mvc($module_type . '.form');

        $compiled_template = compile_base_mvc($base_template, [
            'MODULE_NAME' => $module_name,
            'MODULE_NAME_PLURAL' => $module_name_plural,
            'MODULE_DISPLAY_NAME' => $module_display_name,
            'MODULE_DISPLAY_NAME_PLURAL' => $module_display_name_plural,
            'FIELDS_COLUMN_HEADER' => $module_column_header,
            'FIELDS_COLUMN_ROW' => $module_column_row,
            'MODULE_LAYOUT' => $module_layout
        ]);
        
        $create_template = create_base_mvc($compiled_template, $module_name);



        return $errors;
    }
}
