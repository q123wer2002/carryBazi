<?php

include_once "include/baziMain.php";

$BPhotoObj->myName = "";
if(isset($_SESSION['myName'])){
	$BPhotoObj->myName = $_SESSION['myName'];
}
		

$BPhotoObj->topHtml = "";
$BPhotoObj->contentHtml = "content/talk.html";
$BPhotoObj->footerHtml = "footer.html";
$BPhotoObj->showHTML("masterPage.html");



?>