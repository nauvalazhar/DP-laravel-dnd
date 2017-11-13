<?php

function is_page($page) {
	if(Request::is(config('starter.prefix') . '/' . $page . '*')) {
		return true;
	}else{
		return false;
	}
}

function if_null($var, $text) {
	if(isset($var)) {
		return $var;
	}else{
		return $text;
	}
}

function table_action($data) {
	if(!is_array($data)) {
		return abort(500);
	}else{
		$buttons = "";
		$class = "btn-primary";
		$buttons .= "<form method=\"post\" action=\"".$data['delete']."\" data-delete>";
		$buttons .= method_field('DELETE');
		$buttons .= csrf_field();
		foreach($data as $k => $route) {
			if($k == 'delete') {
				$buttons .= '<a role="button" class="btn btn-danger btn-action delete-button">' . ucwords(human_string($k)) . '</a> ';
			}else{
				$buttons .= '<a href="'.$route.'" class="btn '.$class.' btn-action">' . ucwords(human_string($k)) . '</a> ';
			}
		}
		$buttons .= "</form";
		return $buttons;
	}
}

function human_string($text) {
	$text = str_replace("_", " ", $text);
	return $text;
}

function setting($get) {
	return Settings::get($get);
}

function media($p = '/') {
	return url(media_path() . '/' . $p);
}

function images($file) {
	return media(config("starter.path.images") . '/' . $file);
}

function files($file) {
	return media(config("starter.path.files") . '/' . $file);
}

function path() {
  if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
      return "\\";
  } else {
      return "/";
  }
}

function media_path() {
	return config("starter.path.media");
}

function module_path($name) {
	return config('view.paths')[0] . path() . $name;
}

function system_name($str) {
	$str = str_replace(" ", "_", $str);
	$str = strtolower($str);
	return $str;
}

function base_template($file) {
	$file = str_replace(".", path(), $file);
	$base = base_path('starter-kit' . path() . 'base_module' . path() . $file . '.tpl');
	return $base;
}

function get_base_template($file) {
	return file_get_contents(base_template($file));
}

function compile_base_template($files, $data) {
	$f = [];
	foreach ($files as $k => $file) {
		$f[$k] = $file;
		foreach($data as $d => $r) {
			$f[$k] = str_replace('['.$d.']', $r, $f[$k]);
		}
	}
	return $f;
}

function create_base_template($files, $name) {
	mkdir(config('view.paths')[0] . path() . $name);
	foreach($files as $k => $f) {
		$path = config('view.paths')[0] . path() . $name . path() . $k . '.blade.php';
		$create = fopen($path, 'w');
		fwrite($create, $f);
		fclose($create);
	}
}