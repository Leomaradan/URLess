<?php

define('URLESS', 'normal');

require 'include/functions.php';

$message = $i18n->getText('site','underconstruction');
$title = $i18n->getText('site','underconstruction');	
$noside = true;

include 'view/index.php';