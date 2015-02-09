<?php
require_once(__DIR__ . '/../include/connect.php');

$_PAGE = array(
	'id' => 'error',
	'title' => 'Fruit Not Found'
);

$type = (int)$_GET['type'];
if( $type != 403 ) { $type = 404; }

$url = ltrim($_SERVER['REQUEST_URI'], '/');

//-----------------------------------------------------------------------------
// See if they misspelled something closely

$sql = "SELECT *
	FROM `fruits`
	ORDER BY `name` ASC";
$exec = $_db->query($sql);

$fruit_names = array();
$suggested = array();

while( $fruit = $exec->fetch_assoc() ) {
	$fruit_names[] = $fruit['plural_name'];
	
	$lev = levenshtein($fruit['plural_name'], $url);
	if( $lev <= 2 ) {
		$suggested[] = $fruit['plural_name'];
	}
}

require_once(ROOT . 'header.php');

$Smarty->assign('type', $type);
$Smarty->assign('suggested', $suggested);

$Smarty->display('error.tpl');

require_once(ROOT . 'footer.php');
