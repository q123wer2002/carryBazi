<?php
session_start();

include_once 'settingConfig.php';

header("Content-Type:text/html; charset=utf-8");

$BPhotoObj = new BaziPhoto();

$BPhotoObj->metaHtml = "meta.html";
$BPhotoObj->topHtml = "top.html";
$BPhotoObj->footerHtml = "footer.html";


?>