<?php
require_once(__DIR__ . '/../include/connect.php');

$_PAGE = array(
	'title' => 'About',
	'url' => 'about'
);

require_once(__DIR__ . '/../header.php');

$Smarty->display('about.tpl');

require_once(__DIR__ . '/../footer.php');
