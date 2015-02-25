<?php
require_once(ROOT . 'include/wrapper.php');
$_db = new Wrapper(new mysqli_extended($DBHOST, $DBUSER, $DBPASS, $DBNAME));
