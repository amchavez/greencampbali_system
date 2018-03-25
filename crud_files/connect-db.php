<?php

// server info
$host = 'localhost';
$user = 'root';
$pass = 'bali123';
$db = 'greencampbali';

// connect to the database
$mysqli = new mysqli($host, $user, $pass, $db);

// show errors (remove this line if on a live site)
mysqli_report(MYSQLI_REPORT_ERROR);

?>
