<?php

interface AccessDriver {
	function openId($id, $create = false);
	function appendToId($id,$url);
	function getId($url);
}

class Driver {
	public static function Get($name) {
		if(ctype_alnum($name)) {
			$name = strtolower($name);
			if(file_exists('./include/' . $name . '.php')) {
				require_once './include/' . $name . '.php';
				$class = ucfirst($name) . 'Driver';
				return new $class();
			}

		}
		
		return null;
	}
}