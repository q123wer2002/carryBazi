<?php
/**
 * http://subinsb.com/php-websocket-advanced-chat
 */
ini_set("display_errors","on");
$docRoot  = realpath(dirname(__FILE__));

if( !isset($dbh) ){
  session_start();
  date_default_timezone_set("Asia/Taipei");
  $musername = "root";
  $mpassword = "1234";
  $hostname  = "127.0.0.1";
  $dbname    = "test";
  $port      = "3306";

  $dbh = new PDO("mysql:dbname={$dbname};host={$hostname};port={$port}", $musername, $mpassword);
  /**
   * Change The Credentials to connect to database.
   */
}
?>
