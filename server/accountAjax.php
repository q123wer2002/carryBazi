<?php
include_once "../include/baziMain.php";

 $method = ( isset($_POST['method']) == true) ? $_POST['method'] : "null" ;
 $post = ( isset($_POST) == true ) ? $_POST : "no post";

 $ENUM_accountErrorCode = array(
 	"success" 			=>  0,
 	"aleardyRegister" 	=>  1,
 	"noUser" 			=>  2,
 	"pwdError" 			=>  3,
 );

switch( $method ){
	case "register": //註冊會員
		$userEmail = $post['userEmail']
		$userPwd = $post['userPwd'];
		$userType = $post['userType'];
		$userName = $post['userName'];

		//confrim whether this user is already registered
		$sqltmp = "SELECT * FROM carrybazi_user WHERE account='".$userEmail."'";
		$BPhotoObj->resultAry['checkUser']=array();
		$BPhotoObj->basic_select('resultAry','checkUser',$sqltmp);
		unset( $sqltmp );

		if( empty($BPhotoObj->resultAry['checkUser']) == false ){
			//means this user is already registered
			$resultAry = array( "result" => "success", "dataCode" => $ENUM_accountErrorCode['aleardyRegister'] );
			print_r( json_encode($resultAry) );

			unset( $BPhotoObj->resultAry['checkUser'] );
			unset( $resultAry );
			break;
		}

		unset( $BPhotoObj->resultAry['checkUser'] );

		//go registering this user
		$sqltmp = "INSERT INTO carrybazi_user VALUES('', ".$userEmail.", ".md5($userPwd).", ".$userType.", 'carryPhoto', CURRENT_TIMESTAMP );";
		mysql_query( $sqltmp );
		unset( $sqltmp );

		$sqltmp = "INSERT INTO carrybazi_userinfo VALUES('', ".$userName.", ".$userEmail.", CURRENT_TIMESTAMP );";
		mysql_query( $sqltmp );
		unset( $sqltmp );

		$resultAry = array( "result" => "success", "dataCode" => $ENUM_accountErrorCode['success'] );
		print_r( json_encode($resultAry) );
		unset( $resultAry );
	break;
	
	case "forgetPwd": //忘記密碼
	break;
	
	case "facebook":
	break;
	
	case "instagram":
	break;

	case "login": //登入
		$userEmail = $post['userEmail']
		$userPwd = $post['userPwd'];
		
		$sqltmp = "SELECT * FROM carrybazi_user WHERE account='".$userEmail."'";
		$BPhotoObj->resultAry['checkUser']=array();
		$BPhotoObj->basic_select('resultAry','checkUser',$sqltmp);
		unset( $sqltmp );

		if( empty($BPhotoObj->resultAry['checkUser']) == true ){
			//means this user is already registered
			$resultAry = array( "result" => "success", "dataCode" => $ENUM_accountErrorCode['noUser'] );
			print_r( json_encode($resultAry) );

			unset( $BPhotoObj->resultAry['checkUser'] );
			unset( $resultAry );
			break;
		}

		if( md5($userPwd) != $BPhotoObj->resultAry['checkUser'][0]['password'] ){
			//means this user is already registered
			$resultAry = array( "result" => "success", "dataCode" => $ENUM_accountErrorCode['pwdError'] );
			print_r( json_encode($resultAry) );

			unset( $BPhotoObj->resultAry['checkUser'] );
			unset( $resultAry );
			break;
		}

		//login success

		$_SESSION['user'] = $userEmail;

		$resultAry = array( "result" => "success", "dataCode" => $ENUM_accountErrorCode['success'] );
		print_r( json_encode($resultAry) );
		unset( $resultAry );
	break;

	case "logout": // 登出
		unset($_SESSION['user']);

		$resultAry = array( "result" => "success", "dataCode" => $ENUM_accountErrorCode['success'] );
		print_r( json_encode($resultAry) );
		unset( $resultAry );
	break;

	default:
	break;
}

?>