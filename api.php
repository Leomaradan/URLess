<?php

define('URLESS', true);

require 'include/functions.php';

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

echo json_encode($response);