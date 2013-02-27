<?php

session_start();

if(!defined('URLESS')) {
	header('Location: .');
}

require 'config.php';
require 'driver.php';
require 'i18n.php';

$driver = Driver::Get("file");

$lang = i18n::getLangCode();

$i18n = new i18n($lang);

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
