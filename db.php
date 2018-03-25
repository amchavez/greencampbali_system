<?php
/* Database connection settings */
$host = 'localhost';
$user = 'root';
$pass = 'bali123';
$db = 'greencampbali';
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
