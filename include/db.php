<?php
require_once(__DIR__ . '/wrapper.php');
$_db = new Wrapper(new mysqli_extended(getenv('DBHOST'), getenv('DBUSER'), getenv('DBPASS'), getenv('DBNAME')));
