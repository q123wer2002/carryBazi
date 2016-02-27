<?php
include_once "../include/baziMain.php";

 $method = ( isset($_POST['method']) == true) ? $_POST['method'] : "null" ;

switch( $method ){
	case "login":
		$_SESSION['user'] = "testUser";

		$result = array( "result" => "success");
		print_r( json_encode($result) );
	break;

	default:
	break;
}

?>