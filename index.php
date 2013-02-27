<?php

define('URLESS', true);

require 'functions.php';

if(count($_GET) > 0) {
	reset($_GET);
	$id = key($_GET);

	if(ctype_alnum($id)) {
		
		$url = $driver->openId($id);
		$dir = strtolower(substr($id,0,2));
		$file = strtolower(substr($id,0,4));

		if($url !== false) {

			$url = utf8_decode(urldecode($url));
			$httpCode = 600; // arbitrary value, out of bound
			
			$handle = curl_init($url);
			curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

			/* Get the HTML or whatever is linked in $url. */
			curl_exec($handle);
			
			if(!curl_errno($handle)) {
				/* Check for 404 (file not found). */
				$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);	
			}

			if($httpCode < 400) {
				header("Status: 302 Moved Temporarily", false, 302);
				header("Location: $url");
				exit();
			} else {
				//$message = "The requested URL is <a href='$url'>$url</a>, but it seems invalid.";
				//$title = 'URL seems invalid';	
				$message = $i18n->getText('message invalid_url','message', array('url' => $url));
				$title = $i18n->getText('message invalid_url','title');
			}
		} else {
			//$message = 'The requested URL does not exist.';
			//$title = 'Request error';	
			$message = $i18n->getText('message no_url','message');
			$title = $i18n->getText('message no_url','title');			
		}
		include 'view/index.php';
		exit;
	}
}
$message = '						<form action=\'add.php\' method=\'post\'>
						<input type="url" name="link" placeholder="'.$i18n->getText('site','addlink').'" autofocus required autocomplete="off">
						<input type="submit" class="metal">
					</form>';
$title = $i18n->getText('site','default_title'); 

include 'view/index.php';

?>