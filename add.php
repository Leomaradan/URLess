<?php

define('URLESS', true);

require 'functions.php';

if(isset($_POST['link'])) {
	$url = $_POST['link'];
	
	$terminate = false;
	$length = 4;
	$cpt = 0;
	
	while(!$terminate) {
		$cpt++;
		$uid = generateId($length);
		
		if($cpt >= 15) {
			$cpt = 0;
			$length++;
		}
		
		$use = openId($uid,true);
		
		if($use == false) {
			appendToId($uid,$url);
			$terminate = true;
		}
	}
	
	$short = $siteurl . '/?' . $uid;
	
	$message = "Your shortened url is <a href='http://$short' target=_blank>$short</a>";
	$title = 'Please sir, take your url';
	
	include 'view/index.php';
} else {
	header('Location: .');
}