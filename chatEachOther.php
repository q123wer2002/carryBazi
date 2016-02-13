<?php

include_once "include/baziMain.php";


$BPhotoObj->msgReceiver = "";
if(isset($_GET['receiver'])){
	$BPhotoObj->msgReceiver = $_GET['receiver'];
}

$BPhotoObj->topHtml = "top.html";
$BPhotoObj->contentHtml = "content/talk.html";
$BPhotoObj->footerHtml = "footer.html";
$BPhotoObj->showHTML("masterPage.html");

?>