<?php
if ( ! $_PAGE['title']) {
	$_PAGE['title'] = getenv('SITE_NAME');
}

if ( ! isset($_PAGE['og_image'])) {
	$_PAGE['og_image'] = array();
} elseif ( ! is_array($_PAGE['og_image'])) {
	$_PAGE['og_image'] = array($_PAGE['og_image']);
}

$_PAGE['og_image'][] = 'http://' . getenv('DOMAIN') . '/images/facebook.jpg';

$versions = [
    'css' => 1,
];

$Smarty->assign('_PAGE', $_PAGE);
$Smarty->assign('versions', $versions);

$Smarty->display('header.tpl');
