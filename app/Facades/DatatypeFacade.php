<?php

namespace App\Facades;

class DatatypeFacade {
	public $data = [
		"text" => [
			"display_name" => "Text"
		],
		"number" => [
			"display_name" => "Number"
		],
		"textarea" => [
			"display_name" => "Textarea"
		],
		"richtext" => [
			"display_name" => "Richtext"
		],
		"code" => [
			"display_name" => "Code Editor"
		],
		"checkbox" => [
			"display_name" => "Checkbox",
			"clone" => '<span><input type="checkbox" name="mycheckbox" value="{0}"> {1}</span>',
		],
		"radio" => [
			"display_name" => "Radio",
			"clone" => '<span><input type="radio" name="myradio" value="{0}"> {1}</span>',
		],
		"select" => [
			"display_name" => "Select",
			"clone" => '<option value="{0}">{1}</option>',
		],
		"file" => [
			"display_name" => "File"
		],
		'image' => [
			"display_name" => "Image"
		],
		"datepicker" => [
			"display_name" => "Datepicker"
		],
		"timepicker" => [
			"display_name" => "Timepicker"
		],
		"currency" => [
			"display_name" => "Currency"
		]
	];

	public $module_type = [
		"single" => [
			"display_name" => 'Single'
		],
		"loop" => [
			"display_name" => 'Loop'
		],
		"sortable" => [
			"display_name" => 'Sortable'
		]
	];

	public function list() {
		return $this->data;
	}

	public function module_type() {
		return $this->module_type;
	}

	public function get($type) {
		$type = explode("|", $type);
		return $type[0];
	}

	public function getOptions($type) {
		$type = explode("|", $type);
		if(count($type) > 1) {
			return $type[1];
		}
	}

	public function getRequired($type) {
		$type = explode("|", $type);
		if(count($type) > 1) {
			return $type[2];
		}
	}

	public function options($options) {
		$to_options = $this->getOptions($options);
		$to_array = explode(",", $to_options);
		$arr = [];
		foreach($to_array as $item) {
			$arr[str_replace(" ", "", $item)] = $item;
		}
		return $arr;
	}

	public function render($item, $value=false) {
		$r = "";
		$h = "";
		$item = (object) $item;
		switch ($this->get($item->type)) {
			case 'text':
				$h .= '<input type="text" class="form-control" name="' . $item->name . '" value="' . (isset($value) ? $value : '') . '">';
				break;

			case 'number':
				$h .= '<input type="number" class="form-control" name="' . $item->name . '" value="' . (isset($value) ? $value : '') . '">';
				break;

			case 'textarea':
				$h .= '<textarea class="form-control" name="' . $item->name . '">' . (isset($value) ? $value : '') . '</textarea>';
				break;

			case 'richtext':
				$h .= '<textarea class="form-control editor" name="' . $item->name . '">' . (isset($value) ? $value : '') . '</textarea>';
				break;
			
			case 'code':
				$h .= '<textarea class="form-control code" name="' . $item->name . '">' . (isset($value) ? $value : '') . '</textarea>';
				break;

			case 'checkbox':
				if(isset($item->toolbox) && $item->toolbox !== true) {				
					foreach($this->options($item->type) as $val => $name) {
						$h .= '<input type="checkbox" name="' . $item->name . '[]" value="' . $val . '" ' . (isset($value) && $value !== false ? (in_array($val, json_decode($value)) ? 'checked' : '') : '') . '> ' . $name;
						$h .= " &nbsp; ";
					}
				}
				break;

			case 'radio':
				if(isset($item->toolbox) && $item->toolbox !== true) {				
					foreach($this->options($item->type) as $val => $name) {
						$h .= '<input type="radio" name="' . $item->name . '" value="' . $val . '" ' . (isset($value) ? ($value == $val ? 'checked' : '') : '') . '> ' . $name;
						$h .= " &nbsp; ";
					}
				}
				break;
			
			case 'select':
				$h .= '<select class="form-control" name="' . $item->name . '">';
				if(isset($item->toolbox) && $item->toolbox !== true) {
					foreach($this->options($item->type) as $val => $name) {
						$h .= "<option value='" . $val . "' " . (isset($value) ? ($value == $val) ? 'selected' : '' : '') . ">" . $name . "</option>";
					}
				}
				$h .= "</select>";
				break;
			
			case 'file':
				$h .= '<input type="file" class="form-control" name="' . $item->name . '">';
				break;

			case 'image':
				$h .= '<input type="file" accept="image/*" class="form-control" name="' . $item->name . '">';
				break;

			case 'datepicker':
				$h .= '<input type="text" class="form-control datepicker" name="' . $item->name . '" value="' . (isset($value) ? $value : '') . '">';
				break;

			case 'timepicker':
				$h .= '<input type="text" class="form-control timepicker" name="' . $item->name . '" value="' . (isset($value) ? $value : '') . '">';
				break;

			case 'currency':
				$h .= '<input type="text" class="form-control currency" name="' . $item->name . '" value="' . (isset($value) ? $value : '') . '">';
				break;

			default:
				return 'Field type not recognized';
				break;
		}

		$r .= "<div class='form-group " . (session('error') && isset(session("error")[$item->name]) ? "has-error" : "") . "'>";
		$r .= '<label class="control-label ' . ($this->getRequired($item->type) == 'required' ? 'required' : '') . '">' . $item->display_name . '</label>';
		$r .= $h;
		$r .= "<div class='help-block'>";
		if(session('error') && isset(session("error")[$item->name])) {
			$r .= session("error")[$item->name];
		}else{			
			if(isset($item->description)) {
				$r .= $item->description;
			}
		}
		$r .= "</div>";
		if(in_array($this->get($item->type), ['file', 'image'])) {
			if(isset($value)) {
				if($this->get($item->type) == 'image') $url = images($value);
				else if($this->get($item->type) == 'file') $url = files($value);
				if(isset($item->toolbox) && $item->toolbox !== true)
				$r .= 'Attached: <a target="_blank" href="' . $url . '">' . $value . "</a>";
			}
		}
		$r .= "</div>";

		return $r;
	}
}