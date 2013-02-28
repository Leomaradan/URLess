<?php

if(!defined('URLESS')) {
	header('Location: ..');
}

$siteurl = 'htmltest/URLess';

$config['pdo']['dsn'] = 'mysql:dbname=urless;host=127.0.0.1';
$config['pdo']['user'] = 'root';
$config['pdo']['passwd'] = null;
$config['pdo']['table'] = 'url';

$config['sqlite']['db'] = 'data/sqlite.db';
$config['sqlite']['table'] = 'url';