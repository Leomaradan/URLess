<?php

if(!defined('URLESS')) {
	header('Location: .');
}

require 'config.php';

function openId($id, $create = false) {
	$dir = strtolower(substr($id,0,2));
	$file = strtolower(substr($id,0,4));


	if(file_exists('./data/' . $dir . '/' . $file . '.php')) {

		include './data/' . $dir . '/' . $file . '.php';

		
		if(isset($links[$id])) {
			return $links[$id];
		}
	} elseif($create) {
		if(!file_exists('./data/' . $dir . '/')) {
			mkdir('./data/' . $dir . '/');
		}
		
		file_put_contents('./data/' . $dir . '/' . $file . '.php', '<?php ' . PHP_EOL . PHP_EOL);
	}	
	
	return false;
}

function appendToId($id,$url) {
	$dir = strtolower(substr($id,0,2));
	$file = strtolower(substr($id,0,4));
	
	file_put_contents('./data/' . $dir . '/' . $file . '.php', '$links[\''.$id.'\'] = \''.$url.'\';' . PHP_EOL, FILE_APPEND);
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