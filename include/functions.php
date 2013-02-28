<?php

session_start();

if(!defined('URLESS')) {
	header('Location: ..');
}

require 'config.php';
require 'driver.php';
require 'i18n.php';

$driver = Driver::Get("file");

$lang = i18n::getLangCode();

$i18n = new i18n($lang);

if($driver == null) {
	$message = $i18n->getText('message unknown','message');
	$title = $i18n->getText('message unknown','title');	
	include 'view/index.php';
	die;
}

function generateId($nb) {

	$generate = '';

	for($i = 1; $i<=$nb; $i++) {
		$type = mt_rand(1,3);
		
		if($type==1) {
			$char = mt_rand(48,57);
		} elseif($type==2) {
			$char = mt_rand(65,90);	
		} else {
			$char = mt_rand(97,122);	
		}
		
		$generate .= chr($char);
	}
	
	return $generate;
}

function getUrlById($id, $curl = true) {
	global $driver;
	
	if(ctype_alnum($id)) {
		
		$url = $driver->openId($id);
		$dir = strtolower(substr($id,0,2));
		$file = strtolower(substr($id,0,4));

		if($url !== false) {

			$url = utf8_decode(urldecode($url));
			$httpCode = 600; // arbitrary value, out of bound
			
			if($curl) {
				$handle = curl_init($url);
				curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

				/* Get the HTML or whatever is linked in $url. */
				curl_exec($handle);
				
				if(!curl_errno($handle)) {
					/* Check for 404 (file not found). */
					$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);	
				}
			}
			
			if($httpCode < 400 || !$curl) {
				return array('type' => 'ok', 'msg' => $url);
				/*header("Status: 302 Moved Temporarily", false, 302);
				header("Location: $url");
				exit();*/
			} else {
				return array('type' => 'invalid', 'msg' => $url);
				//$message = "The requested URL is <a href='$url'>$url</a>, but it seems invalid.";
				//$title = 'URL seems invalid';	
				//$message = $i18n->getText('message invalid_url','message', array('url' => $url));
				//$title = $i18n->getText('message invalid_url','title');
			}
		} else {
			return array('type' => 'no_url');
			//$message = 'The requested URL does not exist.';
			//$title = 'Request error';	
			//$message = $i18n->getText('message no_url','message');
			//$title = $i18n->getText('message no_url','title');			
		}
		//include 'view/index.php';
		//exit;
	}
}

function SetUrl($url) {

	global $driver;//, $siteurl;

	$url = filter_var($url, FILTER_VALIDATE_URL);

	if(!empty($url)) {
		$terminate = false;
		$length = 4;
		$cpt = 0;
		
		$uid = $driver->getId($url);
		
		if($uid != null) {
			$terminate = true;
		}
		
		while(!$terminate) {
			$cpt++;
			$uid = generateId($length);
			
			if($cpt >= 15) {
				$cpt = 0;
				$length++;
			}
			
			$use = $driver->openId($uid,true);
			
			if($use == false) {
				$result = $driver->appendToId($uid,$url);
				$terminate = true;
				
				if($result == false) {
					return array('type' => 'unknown');
			
				}
			}
		}
		
		//$short = $siteurl . '/?' . $uid;
		
		return array('type' => 'ok', 'msg' => $uid);
	}
	
	return array('type' => 'bad_url');
}

function getParam($param, $scope = 'get') {
	switch($scope) {
		case 'get':
			$scope_array = $_GET;
			break;
		case 'post':
			$scope_array = $_POST;
			break;		
		case 'request':
		default:
			$scope_array = $_REQUEST;
			break;		
	}

	if(isset($scope_array[$param])) {
		return $scope_array[$param];
	}
	
	return null;
	
}
