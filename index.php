<?php

define('URLESS', true);

require 'include/functions.php';

if(count($_GET) > 0) {
	reset($_GET);
	$id = key($_GET);
	$response = getUrlById($id);
	
	switch($response['type']) {
		case 'ok':
			header("Status: 302 Moved Temporarily", false, 302);
			header("Location: ".$response['msg']);
			exit();			
		case 'invalid':
			$message = $i18n->getText('message invalid_url','message', array('url' => $response['msg']));
			$title = $i18n->getText('message invalid_url','title');		
			break;
		case 'no_url':
			$message = $i18n->getText('message no_url','message');
			$title = $i18n->getText('message no_url','title');				
			break;
		default:
			$message = $i18n->getText('message unknown','message');
			$title = $i18n->getText('message unknown','title');		
			break;					
	}
	
	include 'view/index.php';
	exit;	
}

$message = '						<form action=\'add.php\' method=\'post\'>
						<input type="url" name="link" placeholder="'.$i18n->getText('site','addlink').'" autofocus required autocomplete="off">
						<input type="submit" class="metal">
					</form>';
$title = $i18n->getText('site','default_title'); 

include 'view/index.php';

?>