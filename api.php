<?php

error_reporting(0); // force error reporting to 0, for correct json response

define('URLESS', 'api');

require 'include/functions.php';

header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json; charset=utf8');

if($driver == null) {
	$response = array('type' => 'bad_api');
} else {

	// get all the parameters
	$request = getParam('request');
	$url = getParam('url');
	$id = getParam('id');

	if($request != null) {

		if($request == 'add' && $url != null) {
			$response = SetUrl($url);
		} elseif($request == 'get' && $id != null) {
			$response = getUrlById($id, false);
		} else {
			$response = array('type' => 'bad_api');
		}
		
		
	} else {
		$response = array('type' => 'bad_api');
	}
}

echo '('.json_encode($response).');';