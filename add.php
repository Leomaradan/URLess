<?php

define('URLESS', true);

require 'functions.php';

if(isset($_POST['link'])) {
	$url = filter_var($_POST['link'], FILTER_VALIDATE_URL);

	if($url) {
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
					$message = "An unknown error occurred";
					$title = 'Please try later';
					
					include 'view/index.php';
					exit;				
				}
			}
		}
		
		$short = $siteurl . '/?' . $uid;
		
		$message = "Your shortened url is <a href='http://$short' target=_blank>$short</a>";
		$title = 'Please sir, take your url';
		
		include 'view/index.php';
		exit;
	}
}

header('Location: .');
