<?php
if( !$_PAGE['title'] ) {
	$_PAGE['title'] = $_CONFIG['site_name'];
}

if( !isset($_PAGE['og_image']) ) {
	$_PAGE['og_image'] = array();
}
else if( !is_array($_PAGE['og_image']) ) {
	$_PAGE['og_image'] = array($_PAGE['og_image']);
}
$_PAGE['og_image'][] = 'http://' . $_CONFIG['domain'] . '/images/facebook.jpg';

$Smarty->assign('_PAGE', $_PAGE);
$Smarty->assign('versions', $versions);

$Smarty->display('header.tpl');
