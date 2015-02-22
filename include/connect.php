<?php
require_once(__DIR__ . '/config.inc.php');

require_once(ROOT . 'libraries/Smarty-3.1.8/libs/Smarty.class.php');
require_once(ROOT . 'libraries/phpmailer/class.phpmailer.php');

require_once(ROOT . 'include/db.php');
require_once(ROOT . 'include/functions.php');

session_start();

$errors = array();
$template_paths = array();

// Detect mobile device
if (isset($_GET['mobile'])) {
	setcookie('no_mobile', '', time()-3600, '/', $_CONFIG['cookie_domain']);
	setcookie('mobile', '1', 2145916800, '/', $_CONFIG['cookie_domain']);
} elseif (isset($_GET['no_mobile'])) {
	setcookie('mobile', '', time()-3600, '/', $_CONFIG['cookie_domain']);
	setcookie('no_mobile', '1', 2145916800, '/', $_CONFIG['cookie_domain']);
}

$is_mobile = is_mobile();
if ($is_mobile) {
	$template_paths[] = ROOT . 'templates/mobile/';
}
$template_paths[] = ROOT . 'templates/';

// Smaller/larger images
$smaller = false;
if (isset($_COOKIE['smaller'])) {
	$smaller = true;
}
if (isset($_GET['smaller'])) {
	setcookie('smaller', '1', 2145916800, '/', $_CONFIG['cookie_domain']);
	$smaller = true;
} elseif (isset($_GET['larger'])) {
	setcookie('smaller', '', time()-3600, '/', $_CONFIG['cookie_domain']);
	$smaller = false;
}

// Smarty templating
$Smarty = new Smarty();
$Smarty->setCompileCheck(true);
$Smarty->debugging		= false;
$Smarty->compile_dir	= ROOT . 'templates/compiled/';
$Smarty->template_dir	= $template_paths;

// Global variables
$ip = $_SERVER['REMOTE_ADDR'];

$Smarty->assign('is_mobile', $is_mobile);
$Smarty->assign('smaller', $smaller);
$Smarty->assign('_CONFIG', $_CONFIG);
