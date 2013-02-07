<?php

define('URLESS', true);

require 'functions.php';

if(count($_GET) > 0) {
	reset($_GET);
	$id = key($_GET);

	$url = openId($id);
	$dir = strtolower(substr($id,0,2));
	$file = strtolower(substr($id,0,4));

	if($url !== false) {

		$handle = curl_init($url);
		curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

		/* Get the HTML or whatever is linked in $url. */
		$response = curl_exec($handle);

		/* Check for 404 (file not found). */
		$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);	
		
		if($httpCode < 400) {
			header("Status: 302 Moved Temporarily", false, 302);
			header("Location: $url");
			exit();
		} else {
			$message = "The requested URL is <a href='$url'>$url</a>, but it seems invalid.";
			$title = 'URL seems invalid';	
		}
	} else {
		$message = 'The requested URL does not exist.';
		$title = 'Request error';	
	}
	
} else {
	$message = '						<form action=\'add.php\' method=\'post\'>
							<input type="url" name="link" placeholder="Add your link" autofocus required autocomplete="off">
							<input type="submit" class="metal">
						</form>';
	$title = 'Add an URL';
}

include 'view/index.php';

?>