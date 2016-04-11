<?php

include_once 'include/baziMain.php';

//login check
if( isset($_SESSION['user']) == false || $_SESSION['user'] == ""  ){
	
	$BPhotoObj->topHtml = "";
	$BPhotoObj->contentHtml = "content/login.html";
	$BPhotoObj->showHTML("masterPage.html");

	exit;
}


?>