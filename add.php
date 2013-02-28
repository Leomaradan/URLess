<?php

define('URLESS', true);

require 'include/functions.php';

$link = getParam('link','post');

if($link != null) {
	
	$response = SetUrl($link);
	
	if($response['type'] == 'ok') {
		$message = $i18n->getText('message show_url','message', array('short' => $siteurl . '/?' . $response['msg']));
		$title = $i18n->getText('message show_url','title');	
	} else {
		$message = $i18n->getText('message unknown','message');
		$title = $i18n->getText('message unknown','title');				
	}

	include 'view/index.php';
	exit;		
}

header('Location: .');
