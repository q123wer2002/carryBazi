<?php

$dbHost = "localhost";
$dbUser = "root";
$dbPass = "1234";
$dbData = "carry_photo";


@$conn=mysql_connect($dbHost,$dbUser,$dbPass);

@mysql_query("SET NAMES utf8"); 
@mysql_query("SET CHARACTER_SET_CLIENT=utf8");
@mysql_query("SET CHARACTER_SET_RESULTS=utf8");
@mysql_select_db($dbData, $conn) or die('cannot connect to database');

?>
