<?php

include_once "../include/baziMain.php";

if(isset($_FILES['file'])){

  $file = file_get_contents($_FILES['file']['tmp_name']);
  $f = finfo_open();
  $mime_type = finfo_buffer($f, $file, FILEINFO_MIME_TYPE);
  
  $supported_types = array(
    "image/png" => "png",
    "image/jpeg" => "jpg",
    "image/pjpeg" => "jpg",
    "image/gif" => "gif"
  );
  
  $extension = isset($supported_types[$mime_type]) ? $supported_types[$mime_type] : false;
  if($extension !== false){
    $fileName = rand(10000, 65000) . "." . $extension;
    $location = __DIR__."/../images/talk/uploads/".$fileName;

    
    move_uploaded_file($_FILES['file']['tmp_name'], $location);
    echo $fileName;
  }
}else{
  $action = ( isset($_POST['action']) == true) ? $_POST['action'] : "null" ;
  switch($action){
    
    case "login":
      $_SESSION['myName'] = $_POST['myName'];
      echo "success";
    break;

    case "initUserList":
      $sql_getAllUsers = "SELECT DISTINCT `sender`, `receiver` FROM `carrybazi_talk` GROUP BY `sender`";
      $BPhotoObj->resultAry['getAllUsers']=array();
      $BPhotoObj->basic_select('resultAry','getAllUsers',$sql_getAllUsers);
      //echo $sql_getAllUsers;
      //print_r($BPhotoObj->resultAry['getAllUsers']);

      $BPhotoObj->tmpUserList = array();

      foreach ($BPhotoObj->resultAry['getAllUsers'] as $key => $value) {
        if( !in_array($value['sender'], $BPhotoObj->tmpUserList) ){
          if( $_SESSION['myName'] == $value['sender'] ){ 
            continue;
          }
          array_push($BPhotoObj->tmpUserList, $value['sender']);
        }

        if( !in_array($value['receiver'], $BPhotoObj->tmpUserList) ){
          if( $_SESSION['myName'] == $value['receiver'] ){
            continue;
          }
          array_push($BPhotoObj->tmpUserList, $value['receiver']);
        }
      }
      $BPhotoObj->tmpUserList = json_encode($BPhotoObj->tmpUserList);
      
      echo $BPhotoObj->tmpUserList;
    break;

    case "getNumOgNoReadMsg":
      $sql_getNumOfNoRead = "SELECT COUNT(id) as num FROM carrybazi_talk WHERE isRead = 0 AND `sender` = '".$_POST['receiver']."' AND `receiver` = '".$_SESSION['myName']."' ;";
      $BPhotoObj->resultAry['getNumOfNoRead']=array();
      $BPhotoObj->basic_select('resultAry','getNumOfNoRead',$sql_getNumOfNoRead);

      $result = array( 'result' => "success", 'user' => $_POST['receiver'], 'num' =>  $BPhotoObj->resultAry['getNumOfNoRead'][0]['num']);
      print_r( json_encode($result) );
    break;

    case "clearNoReadMsg":
      $sql_clearNoMsg = "UPDATE carrybazi_talk SET isRead=1 WHERE isRead = 0 AND `sender` = '".$_POST['receiver']."' AND `receiver` = '".$_SESSION['myName']."' ;";
      $BPhotoObj->resultAry['clearNoMsg']=array();
      $BPhotoObj->basic_select('resultAry','clearNoMsg',$sql_clearNoMsg);

      echo "success";
    break;

    default:
      //print_r($_POST);
    break;
  }
}
