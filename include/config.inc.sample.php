<?php
/**
 * Sample config file
 * Rename this to config.inc.php
 */

define('ROOT', '/var/www/fruits/');

$DBHOST = 'localhost';
$DBUSER = 'root';
$DBPASS = '';
$DBNAME = 'fruits';

$_CONFIG = [
	'type' => 'live', // or local
	'site_name' => "What Fruits Are In Season?",

	'domain' => 'whatfruitsareinseason.com',
	'cookie_domain' => '.whatfruitsareinseason.com',
	'cookie_name' => 'fruity',
	
	'email' => 'fruits@example.com', // not really used
];

$versions = [
	'css'    => '1',
	'js'     => '1',
	'jquery' => '1.9.1',
];

