<?php
require_once(__DIR__ . '/wrapper.php');
$_db = new Wrapper(new mysqli_extended(env('DBHOST'), env('DBUSER'), env('DBPASS'), env('DBNAME')));
