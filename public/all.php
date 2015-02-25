<?php
require_once(__DIR__ . '/../include/connect.php');

$_PAGE = array(
	'id' => 'all',
	'title' => 'When Are Fruits In Season?',
	'url' => 'all',
	'description' => 'When are fruits in season?',
	'og_image' => array()
);

//-----------------------------------------------------------------------------
// Fruits

$sql = "SELECT *
	FROM `fruits`
	ORDER BY `name` ASC";
$exec = $_db->query($sql);

$fruits = $fruit_names = array();

while ($fruit = $exec->fetch_assoc()) {
	$fruits[] = $fruit;
	$fruit_names[] = $fruit['plural_name'];
	
	if (count($_PAGE['og_image']) < 3) {
		$_PAGE['og_image'][] = 'http://' . $_CONFIG['domain'] . '/images/fruits/' . $fruit['plural_name'] . '.jpg';
	}
}

$Smarty->assign('fruits', $fruits);

require_once(ROOT . 'header.php');

$Smarty->display('index.tpl');

require_once(ROOT . 'footer.php');
