<?php
if ( ! $_PAGE['title']) {
	$_PAGE['title'] = env('SITE_NAME');
}

if ( ! isset($_PAGE['og_image'])) {
	$_PAGE['og_image'] = array();
} elseif ( ! is_array($_PAGE['og_image'])) {
	$_PAGE['og_image'] = array($_PAGE['og_image']);
}

$_PAGE['og_image'][] = 'http://' . env('DOMAIN') . '/images/facebook.jpg';

$Smarty->assign('_PAGE', $_PAGE);
$Smarty->assign('versions', $versions);

$Smarty->display('header.tpl');
