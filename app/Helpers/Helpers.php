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