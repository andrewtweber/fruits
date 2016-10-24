<?php
require_once(__DIR__ . '/../vendor/autoload.php');

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

require_once(__DIR__ . '/../include/functions.php');
require_once(__DIR__ . '/../include/db.php');

session_start();

$errors = array();
$template_paths = array();

// Detect mobile device
if (isset($_GET['mobile'])) {
	setcookie('no_mobile', '', time()-3600, '/', env('COOKIE_DOMAIN')); 
	setcookie('mobile', '1', 2145916800, '/', env('COOKIE_DOMAIN'));
} elseif (isset($_GET['no_mobile'])) {
	setcookie('mobile', '', time()-3600, '/', env('COOKIE_DOMAIN'));
	setcookie('no_mobile', '1', 2145916800, '/', env('COOKIE_DOMAIN'));
}

$is_mobile = is_mobile();
if ($is_mobile) {
	$template_paths[] = __DIR__ . '/../views/mobile/';
}
$template_paths[] = __DIR__ . '/../views/';

// Smaller/larger images
$smaller = false;
if (isset($_COOKIE['smaller'])) {
	$smaller = true;
}
if (isset($_GET['smaller'])) {
	setcookie('smaller', '1', 2145916800, '/', env('COOKIE_DOMAIN')); 
	$smaller = true;
} elseif (isset($_GET['larger'])) {
	setcookie('smaller', '', time()-3600, '/', env('COOKIE_DOMAIN'));
	$smaller = false;
}

// Smarty templating
$Smarty = new Smarty();
$Smarty->setCompileCheck(true);
$Smarty->debugging		= false;
$Smarty->compile_dir	= __DIR__ . '/../views/compiled/';
$Smarty->template_dir	= $template_paths;

// Global variables
$ip = $_SERVER['REMOTE_ADDR'];

$Smarty->assign('is_mobile', $is_mobile);
$Smarty->assign('smaller', $smaller);

