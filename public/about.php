<?php
require_once(__DIR__ . '/../include/connect.php');

$_PAGE = array(
	'title' => 'About',
	'url' => 'about'
);

require_once(ROOT . 'header.php');

$Smarty->display('about.tpl');

require_once(ROOT . 'footer.php');