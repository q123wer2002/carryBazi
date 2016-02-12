<?php
//pubic func  
function action_counter($action){

  $url_log=$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
  $action_visitor_where=null;
  if (!isset($_SESSION['ssion']['visitor_counter'])) {
      $_SESSION['ssion']['visitor_counter']=1;
      $visitor_counter=$_SESSION['ssion']['visitor_counter'];
      $action_visitor_where=" || action='visitor'";
    }
    
  $action_counter_sql="select * from action_counter where action='$action'";
  $result = mysql_query($action_counter_sql);
  $num_rows = mysql_num_rows($result);
  if($num_rows>=1){
    $action_counter_sql="update action_counter set counter=counter+1 , url_log='$url_log' where action='$action' || action='pageview' $action_visitor_where";
    mysql_query($action_counter_sql);
  }
  else{
    $action_counter_sql="INSERT INTO `action_counter` (`id` ,`action` ,`counter`,`url_log`) VALUES (null, '$action', '1','$url_log');";
    mysql_query($action_counter_sql);
    $action_counter_sql="update action_counter set counter=counter+1 ,url_log='$url_log' where action='pageview' $action_visitor_where";
    mysql_query($action_counter_sql);
  }
  mysql_free_result($result);
}
/*
function str_make($tmp_x){
  return mysql_escape_string($tmp_x);
}
*/

/*
function laout_check($value)
{
// 去除斜杠
if (get_magic_quotes_gpc())
{
$value = stripslashes($value);
}
// 如果不是数字则加引号
if (!is_numeric($value))
{
  $value =mysql_real_escape_string($value);
}
return $value;
}
*/


function get_counter(){
  $action_counter_sql="select * from action_counter where action='pageview'";
  $result = mysql_query($action_counter_sql);
  while($row = mysql_fetch_assoc($result)) {
    $count=$row['counter'];
    
    return $count;
   } 
}

function upload_img ($next_index)
{
  if(!empty($_FILES["file"]["tmp_name"])){
  if ((($_FILES["file"]["type"] == "image/jpeg")
  || ($_FILES["file"]["type"] == "image/pjpeg"))
  && ($_FILES["file"]["size"] < 512000))
    {
    if ($_FILES["file"]["error"] > 0)
      {
      echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
      }
    else
      {
    //  echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    //  echo "Type: " . $_FILES["file"]["type"] . "<br />";
    // echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    // echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
    
     $name=substr(md5($_FILES["file"]["name"].rand()),0,5).".jpg";
   
        while(file_exists("upload/" .$name."jpg")){
          $name=substr(md5($_FILES["file"]["name"].rand()),0,5).".jpg";
        }
        if(move_uploaded_file($_FILES["file"]["tmp_name"],"upload/".$name)){
        $x=null;
        $x=$name;
        return $x;
        }
        echo "Stored in: " . "upload/" . $name;
        
      }
    }
  else
    {
    //insert >80 msg
    echo "Please upload don't > 500k and file type jpg";
    exit;
    }
  }
  else{
    return "noPic_S.jpg";
  }
}


function upload_file($first_name,$next_index,$type)
{
  if(!empty($_FILES["file"]["tmp_name"][$type])){
    {

    if ($_FILES["file"]["error"][$type] > 0)
      {
      echo "Return Code: " . $_FILES["file"]["error"][$type] . "<br />";
      }
    else
      {
    //  echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    //  echo "Type: " . $_FILES["file"]["type"] . "<br />";
    // echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    // echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
      if(substr($_FILES["file"]["name"][$type],-4,4) =='html'){
        $limit_name=substr($_FILES["file"]["name"][$type],-5,5);
      }
      else{
        $limit_name=substr($_FILES["file"]["name"][$type],-4,4);
      }
      $name=$first_name.'_'.$next_index.'_'.substr(md5($next_index),0,5).$limit_name;
        if(move_uploaded_file($_FILES["file"]["tmp_name"][$type],"upload/$first_name/$type/".$name)){
        $x=null;
        $x=$name;
        return $x;
        }
        echo "Stored in: " . "upload/$first_name/" . $name;
        
      }
    }
  }
  else{
    return "";
  }
}


function upload_file_to_fd($first_path,$file_type=null,$old_file_name=null,$w=null,$h=null,$session_name="file")
{
	
  foreach ($_FILES[$session_name] as $key => &$value) {
    $check_pass=null; //mine是否通過
    $value1=null; 
    $check_type=null; //確認mine副檔名
    $limit_name=null; //副檔名
    $tmp_time=null; //亂數不重複時間亂碼
    $name=null; //命名變數
    $x=null; //回傳檔案名變數
    if($file_type !=null){
      $check_type=explode(',',$file_type);
      foreach ($check_type as &$value1) {
        if($value1 == $_FILES[$session_name]["type"]){
          $check_pass=1;
        }
      }
    }
    else{
      $check_pass=1;
    }
    

          echo "Upload: " . $_FILES[$session_name]["name"] . "<br />";
          echo "Type: " . $_FILES[$session_name]["type"] . "<br />";
          echo "Size: " . ($_FILES[$session_name]["size"] / 1024) . " Kb<br />";
          echo "Temp file: " . $_FILES[$session_name]["tmp_name"] . "<br />";
          exit;
    
    if(!empty($_FILES[$session_name]["tmp_name"]) || $check_pass =='1'){ //確認檔案存在，並且有
          if($w && $h)resizeTo($_FILES[$session_name]["tmp_name"],$_FILES[$session_name]["tmp_name"],$w,$h);
    
          if ($_FILES[$session_name]["error"][$type] > 0){
            echo "Return Code: " . $_FILES[$session_name]["error"] . "<br />";
          }
          else
          {
          
            //抓取副檔名
            if(substr($_FILES[$session_name]["name"][$type],-4,4) =='html'){
              $limit_name=substr($_FILES[$session_name]["name"],-5,5);
            }
            else{
              $limit_name=substr($_FILES[$session_name]["name"],-4,4);
            }
            //end 抓取副檔名
            
            //避開exe 檔
            if($limit_name =='exe'){
              echo "error,don't upload .exe";
            }
            //end 避開exe 檔
            $tmp_time=uniqid(PAGE_NAME.'_'); 
            $name=$tmp_time.$limit_name;
            
			//若路徑不存在 則新增
			if(!file_exists($first_path))
			{
				//新增資料夾
             	@mkdir($first_path, 0700);
              	//end  新增資料夾
			}
			
			//再次確認
            if(file_exists($first_path)){
              //確認檔案是否有重複
              while(file_exists($first_path.$name)){
                $tmp_time=uniqid(PAGE_NAME.'_'); 
                $name=$tmp_time.$limit_name;
              }
              //end  確認檔案是否有重複
              
              if(@move_uploaded_file($_FILES[$session_name]["tmp_name"],"$first_path".$name)){
                //刪除update之前的圖片
                if($old_file_name !=null){
                    @unlink($first_path."$old_file_name");
                  }
                //end  刪除update之前的圖片
                $x=null;
                $x=$name;
                return $x;
              } 
            }
                 
           // echo "Stored in: " . "upload/$first_name/" . $name; 
          }
    }
    else{
      return "";
    }
  }
}



function laout_check($str_arr=null,$option='strip_tags'){
	if (!get_magic_quotes_gpc()) {

		if(is_array($str_arr)){
      		foreach ($str_arr as $key=>$value){      		
        		$str_arr[$key]=addslashes($value);
        		$key1=addslashes($key);
        		if($key1 != $key){
        		  alert('操作錯誤',-1);
        		  exit;
        		  }
        		if($option !='no_strip_tags'){
          			$str_arr[$key]=strip_tags($value);
        		}
      		}
    	}
    	else if(!empty($str_arr)){
        	$str_arr=addslashes($str_arr);
        	if($option !='no_strip_tags'){
          		$str_arr=strip_tags($str_arr);
        	}
    	}
    	else{
    		$str_arr=null;
    	}
  	}
  	else{

    	if(is_array($str_arr)){
      		foreach ($str_arr as $key=>$value){
        		$key1=addslashes($key);
        		if($key1 != $key){
        		  alert('操作錯誤',-1);
        		  exit;
        		  }
        		if($option !='no_strip_tags'){
          			$str_arr[$key]=strip_tags($value);
        		}
      		}
    	}
    	elseif(!empty($str_arr)){
        	if($option !='no_strip_tags'){
          		$str_arr[$key]=strip_tags($str_arr);
        	}
    	}
    	else{
      		$str_arr=null;
    	}
  	}
  	return $str_arr;
}


function index_counter(){
  $index_counter_sql="SELECT * FROM `action_counter` where action='pageview'";
  $result=mysql_query($index_counter_sql);
  while($row = mysql_fetch_assoc($result)) {
    $index_counter_arr[]=$row;
   }
   return $index_counter_arr;
}

function check_pree($str_arr=null){
 //form is posted
    //function 
      include("secur/securimage.php");
      $img = new Securimage();
      $valid = $img->check($_POST['code']);
    
      if($valid != true) {
      $msg_tmp='Sorry, the code you entered was invalid.';
      //laout
        $msg_arr['msg']=$msg_tmp;
      //end laout
      include_once 'templates/message.htm';
        exit;
      }
    //function//
}

function admin_check_pree($str_arr=null){
 //form is posted
    //function 
      include("../secur/securimage.php");
      $img = new Securimage();
      $valid = $img->check($_POST['code']);
    
      if($valid != true) {
        echo "<center>Sorry, the code you entered was invalid.";
        exit;
      }
    //function//
}

function resizeTo($filename,$to=null,$w,$h)
{
   $size = getimagesize($filename);
   $width=$size['0']>=$w?$w:$size['0'];
   $height=$size['1']>=$h?$h:$size['1'];
  
    switch($size[2])
    {
        case 1:
            $func = 'imagecreatefromgif';
            $func2 = 'imagegif';
            break;
        case 2:
            $func = 'imagecreatefromjpeg';
            $func2 = 'imagejpeg';
            break;
        case 3:
            $func = 'imagecreatefrompng';

            $func2 = 'imagepng';
            break;
    }
    $image = $func($filename);
          imagesavealpha($image,true);//这里很重要 意思是不要丢了$sourePic图像的透明色;
          $thumb = imagecreatetruecolor($width,$height);
          imagealphablending($thumb,false);//这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
          imagesavealpha($thumb,true);//这里很重要,意思是不要丢了$thumb图像的透明色;
          imagecopyresampled($thumb,$image,0,0,0,0,$width,$height,$size[0],$size[1]);
    $func2($thumb,$to);
   
//來源參考
/*
*$sourePic:原图路径
* $smallFileName:小图名称
* $width:小图宽
* $heigh:小图高
* 转载注明 www.chhua.com*/
/*
function pngthumb($sourePic,$smallFileName,$width,$heigh){
     $image=imagecreatefrompng($sourePic);//PNG
               imagesavealpha($image,true);//这里很重要 意思是不要丢了$sourePic图像的透明色;
               $BigWidth=imagesx($image);//大图宽度
               $BigHeigh=imagesy($image);//大图高度
               $thumb = imagecreatetruecolor($width,$heigh);
               imagealphablending($thumb,false);//这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
               imagesavealpha($thumb,true);//这里很重要,意思是不要丢了$thumb图像的透明色;
               if(imagecopyresampled($thumb,$image,0,0,0,0,$width,$heigh,$BigWidth,$BigHeigh)){
               imagepng($thumb,$smallFileName);}
               return $smallFileName;//返回小图路径 转载注明 www.chhua.com
}

pngthumb("a.png", "c.png", 300, 300);//调用
*/
}

function MultiValuedInOne($tmp_arr)
{
        if(isset($tmp_arr))foreach($tmp_arr as $key =>$value){
          if($key==0){
            $tmp_x=$value;
          }
          else{
            $tmp_x="$tmp_x,$value";
          }
        }

        return $tmp_x;

}

function MultiTxtdInOne($retun_arr,$text_arr)
{
        if(isset($retun_arr))foreach($retun_arr as $key =>$value){
           foreach($text_arr as $key1 =>$value1){
                if($value1['id'] ==$value){
              if($key==0){
                $retun_x=$value1['name'];
                }
                else{
                  $retun_x="$retun_x,$value1[name]";
                }
            }   
        }
      }


        return $retun_x;

}


function Who_Own($tmp_x,$tmp_y,$msg="你不是原始發布者，請重新登入",$go_to="<br /> <a href='javascript:history.go(-1)' /> 返回</a>")
{
  if($tmp_x !=  $tmp_y){
  include_once 'templates/msg_who_own.htm';
  exit;
  }
}


function pub_vote_arr(){
      $order='order by a.id asc '; 
      $tmp_sql="SELECT a. * , if( b.rows >0, b.rows+37, 0+37) as rows 
FROM pub_vote AS a
LEFT JOIN (

SELECT count( pub_vote_id ) AS
ROWS , pub_vote_id
FROM pub_vote_log where true_mail ='1'
GROUP BY pub_vote_id
) AS b ON a.id = b.pub_vote_id
  $order ";
      $result=mysql_query($tmp_sql);
      while($row = mysql_fetch_assoc($result)) {
        $tmp_arr[]=$row;
       }
       return $tmp_arr;

}

function pub_vote_insert($id,$local_ip,$email){
$mdate=date("Y-m-d H:i:s",strtotime('now'));
$check_day=date("Y-m-d",strtotime('now'));
$check_day2=date("Y-m-d",strtotime('now +1day'));

       $tmp_sql="SELECT * FROM `pub_vote_user`   where email ='$email'";
      $result=mysql_query($tmp_sql);
      $num_rows = mysql_num_rows($result);
      
$e_code= substr(md5($email.rand()),0,5);          
    
$tmp_sql="INSERT INTO `pub_vote_log` 
(`id` ,`ip` ,`pub_vote_id` ,`vote_datetime`,`email`,e_code,true_mail )
VALUES ('', '$local_ip', '$id', '$mdate','$email','$e_code',0); ";
$e_code_url="你的email 驗證網址為 \r\n http://badefun.com.tw/index.php?action=index_preview&webpage=stack_vote_email_vote&e_code=$e_code ";
mysql_query($tmp_sql);
mail("$email","八德意象設計票選驗證碼",$e_code_url );

/*
      if(mysql_query($tmp_sql)){
        $tmp_sql="update  pub_vote set vote_count=vote_count+1 where id ='$id'";
      if(mysql_query($tmp_sql)){
        echo "投票成功";
        exit;
        }
    }
    */


      // return $tmp_arr;

}


function pub_vote_check($id,$local_ip){
$mdate=date("Y-m-d H:i:s",strtotime('now'));
$check_day=date("Y-m-d",strtotime('now'));
$check_day2=date("Y-m-d",strtotime('now +1day'));
$tmp_sql="select * from pub_vote_log where email ='$email' and true_mail='1' and vote_datetime  between '$check_day' and '$check_day2'  ";
$result=mysql_query($tmp_sql);
$num_rows = mysql_num_rows($result);
if($num_rows >=2){ 
  $msg="你今天已經投超過兩次了";
  include_once 'templates/msg.htm';
exit;}
      // return $tmp_arr;

}

    
function strip_tags_array($array,$key){
      foreach ($array as  $key1=> $value1 ){
      if(!is_array($value1)){
        $_REQUEST[$key][$key1]=strip_tags($value1);
       }
       else{
        strip_tags_array($value1,$key1);
       }   
  }
   
}



//組成 select 的html
function Make_list($list,$value)
{	
	foreach($list as $k => $v)
	{
		if($value == $k && $value != NULL)
			$list_html .='<option value="'.$k.'" selected="selected">'.$v.'</option>';
		else
			$list_html .='<option value="'.$k.'">'.$v.'</option>';
	}
	return $list_html;
}

//組成 select 的html 撈出SQL用
function Make_sql_list($list,$value)
{
	foreach($list as $k => $v)
	{
		if($list[$k]["id"] == $value && $value != NULL)
			$html .= '<option value="'.$list[$k]["id"].'" selected="selected" >'.$list[$k]["name"].'</option>';
		else
			$html .= '<option value="'.$list[$k]["id"].'" >'.$list[$k]["name"].'</option>';
	}
	return $html;
}

//組成 ul 的html
function Make_Tab_list($list,$value)
{	
	foreach($list as $k => $v)
	{
		$list_html .='<li><a href="#tab_'.$k.'">'.$v.'</a></li>';
	}
	return $list_html;
}


//提示
function alert($messages,$url=NULL){
	print "<meta http-equiv=Content-Type content=text/html; charset=utf-8>";
	if (trim($url) == "-1") 
		$msg= "<script language=\"JavaScript\" type=\"text/JavaScript\">window.alert(\"$messages\");javascript:history.back(-1);</script>";
	else if (trim($url) == "submit")
		$msg= "<script language=\"JavaScript\" type=\"text/JavaScript\">window.alert(\"$messages\");document.vipform.submit();</script>";
	else if (trim($url) == "reload")
	{
		$msg= "<script language=\"JavaScript\" type=\"text/JavaScript\">window.alert(\"$messages\");javascript:history.back(-1);</script>";
	}
	else if (trim($url) == "")
		$msg= "<script language=\"JavaScript\" type=\"text/JavaScript\">window.alert(\"$messages\");</script>";
	else
		$msg= "<script language=\"JavaScript\" type=\"text/JavaScript\">window.alert(\"$messages\");location.href='$url';</script>";
	echo $msg;
	
}

//跳到指定頁面 同header
function LinkTo($url)
{	
	if($url=='-1')
		echo "<script>javascript:history.back(-1);</script>";
	else
		echo "<script>location='".$url."'</script>";
	exit;
}


//檢查帳號格式
function check_account($account)
{
	$is_pass = false;
	
	if($account != "")
	{
		if(Expression_EnAneMath($account))
		{
			if(!SQL_Injection_Chcek($account))
			{
				$is_pass = true;
			}
		}
	}
	
	return $is_pass;
}

//表達式檢查，是否只有英數混合
function Expression_EnAneMath($value)
{
	$token = "^[a-zA-z0-9]*$";
	$is_pass=false;
	
	if ( eregi($token,$value) )
	{
		$is_pass=true;
	}
	
	return $is_pass;
}

//SQL Injection檢查
function SQL_Injection_Chcek($value)
{
	$is_pass=false;
	$injection_string = array("0"=>"'","1"=>";","2"=>"--","3"=>"\t","4"=>"\n");
	foreach($injection_string as $key => $value)
	{
		if(strpos($value, $v))
		{
			$is_pass=true;
			break;
		}
	}
	
	return $is_pass;
}

//檢查帳密資料 若正確，則取得資料
function CheckSQL_User($obj_tmp1, $account, $password, $table_name)
{
    $obj_tmp1->func_arr=NULL;
	//default set
   	/*$obj_tmp1->table_name= $user_table;
   	$obj_tmp1->tmp_where="where account ='".$account."'";
   	$obj_tmp1->tmp_order ='order by id asc';*/
	
	$sql = "Select account.*, account_group._function_area_id As group_function_area_id 
			From ".$table_name."system_account As account 
			Left Join ".$table_name."system_account_group As account_group 
			On account._system_group_id = account_group.id 
			Where account.account = '".$account."' 
			Order By account.id Asc ";
  	//end set
   	//$obj_tmp1->tmp_select('func_arr',('tmp_arr'));
	$obj_tmp1->basic_select('func_arr',('tmp_arr'),$sql);
	
   	if(count($obj_tmp1->func_arr['tmp_arr']) ==1){
	    if($obj_tmp1->func_arr['tmp_arr'][0]['password'] ==  md5($password)){
    	    $chk_result[0] ='Success';
			$chk_result[1] = $obj_tmp1->func_arr['tmp_arr'];
			
			//若管理者 有加入群組，則套用群組的專區權限
			if($chk_result[1][0]["_system_group_id"] != "" && $chk_result[1][0]["_system_group_id"] > 0)
			{
				$chk_result[1][0]["_function_area_id"] = $chk_result[1][0]["group_function_area_id"];
			}
      	}
      	else{
        	$chk_result[0] ='密碼錯誤';
      	}
   	}
   	else{
    	$chk_result[0] ='查無此帳號';
   	}
	
   	return $chk_result;
}

//檢查 平台是否有該檔案，並比對使用者 是否有執行權限
function CheckPageAuth($obj_tmp1, $platform_Code = "", $linkto_page = "", $page_code = "", $user_type = "", $user_table = "", $user_data = array())
{
	$obj_tmp1->func_arr=null;
	//取得 功能資料
	//若沒有功能識別碼(Code)，則以URL撈取資料
	if($linkto_page != "" && $page_code == "")
	{
		//以URL撈取資料
	  	$sql = "Select function.* From ".TABLE_NAME."system_function As function Where function._system_area_id in (
Select area.id From ".TABLE_NAME."system_function_area As area Where area._system_platform_id = (Select platform.id From ".TABLE_NAME."system_function_platform As platform Where platform.Code = '".$platform_Code."' Order By platform.sort Asc Limit 0,1) And area.id in (".$user_data["_function_area_id"].") Order By area.sort Asc ) And function.url = '".$linkto_page."' Order By sort Limit 0,2";

		$obj_tmp1->basic_select('func_arr',('tmp_arr'),$sql);
	}
	else
	{
		//以Code撈取資料
    	$sql = "Select function.* From ".TABLE_NAME."system_function As function Where function._system_area_id in (
Select area.id From ".TABLE_NAME."system_function_area As area Where area._system_platform_id = (Select platform.id From ".TABLE_NAME."system_function_platform As platform Where platform.Code = '".$platform_Code."' Order By platform.sort Asc Limit 0,1)  And area.id in (".$user_data["_function_area_id"].") Order By area.sort Asc ) And function.Code = '".$page_code."' Order By sort limit 0,1";

		$obj_tmp1->basic_select('func_arr',('tmp_arr'),$sql);
	}
	
	//或是同一個平台 功能不能重複，且該功能的Code不能為空值
	if(count($obj_tmp1->func_arr['tmp_arr']) == 1 && $obj_tmp1->func_arr['tmp_arr'][0]["code"] != "")
	{
		$function_data = $obj_tmp1->func_arr['tmp_arr'];
			
		//判斷使用者 是否為管理者 且 是否有加入群組
        if($user_type == "account" && $user_data["_system_group_id"] == 0)
        {
        	//若為管理者，且無加入群組，則判斷 個人權限
           	$sql = "Select account_auth.*, function.name As function_name, function.parent_id As function_parent_id From ".$user_table."_auth_comparison As account_auth Left Join ".TABLE_NAME."system_function As function On account_auth._system_function_id = function.id Where account_auth._system_account_id = ".$user_data["id"]." And account_auth._system_function_id = ".$function_data[0]["id"]." Limit 0,1";
		}
        else
        {
        	//若非管理者，則判斷 群組權限
            //或是為管理者 且有加入群組，則判斷 群組權限
            $sql = "Select group_auth.*, function.name As function_name, function.parent_id As function_parent_id From ".$user_table."_group_auth_comparison As group_auth  Left Join ".TABLE_NAME."system_function As function On group_auth._system_function_id = function.id Where group_auth._system_group_id in ( ".$user_data["_system_group_id"]." ) And group_auth._system_function_id = ".$function_data[0]["id"]." Limit 0,1";
		}
        
		//判斷有無資料
		$obj_tmp1->basic_select('func_arr',('tmp_arr1'),$sql);
		if(count($obj_tmp1->func_arr['tmp_arr1']) == 1)
        {
			//有，再判斷有無讀取權限
			if($obj_tmp1->func_arr['tmp_arr1'][0]["is_read"] == "1")
			{
				//有讀取權限，回傳 Success + 權限陣列
				$chk_result[0] = 'Success';
		        $chk_result[1] = $obj_tmp1->func_arr['tmp_arr1'];
			}
        	else
			{
				//無讀取權限，回傳 AuthError
				$chk_result[0] = '無執行權限';
			}
		}
		else{
			//無，回傳 AuthError
			$chk_result[0] = '無執行權限';
		}
	}
	else
	{
		$chk_result[0] = '該平台無此功能';
	}
	
	$obj_tmp1->func_arr=NULL;
	return $chk_result;
}

//製做功能列表
function CreateMenu($obj_tmp1, $table_name, $user_table = "", $user_type="", $user_data = array(), $area_array=array(), $func_array=array())
{
	$obj_tmp1->tmp_arr =array();
	//若身為管理者
	//且沒有加入任何群組
	if($user_type == "account" && $user_data["_system_group_id"] == 0)
	{
		//以個人權限抓取功能
		
		$sql = " Select id, name, root_id, parent_id, url, lang_key From ".$table_name."system_function As function Where ( Select is_read From ".$table_name."system_account_auth_comparison As account_auth Where account_auth._system_account_id = ".$user_data["id"]." And account_auth._system_function_id = function.id )= 1 And _system_area_id = ".$area_array["id"]." And status = 'y' And root_id = ".$func_array["root_id"]." And parent_id = ".$func_array["id"]." Order By sort Asc ";
		
	}
	else
	{
		//以群組權限 抓取功能
		
		$sql = " Select id, name, root_id, parent_id, url, lang_key From ".$table_name."system_function As function Where ( Select is_read From ".$table_name."system_account_group_auth_comparison As group_auth Where group_auth._system_group_id = ".$user_data["_system_group_id"]." And group_auth._system_function_id = function.id )= 1 And _system_area_id = ".$area_array["id"]." And status = 'y' And root_id = ".$func_array["root_id"]." And parent_id = ".$func_array["id"]." Order By sort Asc ";
		
	}
	$obj_tmp1->basic_select('tmp_arr',('tmp_arr1'),$sql);
		
	//判斷取得的陣列大小
	//若長度 = 0，則return
	//不然繼續執行foreach 並呼叫CreateMenu function
		
	if(count($obj_tmp1->tmp_arr) != 0)
	{
		//暫存
		$array_buff = $obj_tmp1->tmp_arr[tmp_arr1];
		//查詢子功能
		foreach($array_buff as $key => $value)
		{
			//取得子功能
			$array_buff[$key]["submenu"] = CreateMenu($obj_tmp1, $table_name, $user_table, $user_type, $user_data, $area_array, $value);
		}
		return $array_buff;
	}
	else
	{
		return NULL;
	}
}


//先註解 ～
/*
function ChangeLang($menu_array = array(), $lang_array = array())
{
	foreach($menu_array as $key => $value)
	{
		if(!empty($lang_array[$value["lang_key"]]))
		{
			$menu_array[$key]["name"] = $lang_array[$value["lang_key"]];
		}
		
		foreach($value as $key2 => $value2)
		{
			if(is_array($menu_array[$key][$key2]))

			{
				$menu_array[$key][$key2] = ChangeLang($menu_array[$key][$key2] , $lang_array);
			}
		}
	}
	
	return $menu_array;
}
*/

//搜尋各個查詢欄位的值
function WhereSearch($obj_tmp1, $id=0, $table_name="", $where_array=array())
{
	$result_value="";
	if($table_name != "")
	{
		$obj_tmp1->tmp_arr =array();
		
		//搜尋欄位字串
		foreach($where_array as $key=> $value)
		{
			if($value != "")
			{
				if($Select_String != "")
				{
					$Select_String .= ", ";
				}
				$Select_String .= $value;
			}
		}
		
		if($Select_String != "")
		{
			//查詢欄位資料
			$sql = " Select ".$Select_String." From ".$table_name." Where id=".$id;
			$obj_tmp1->basic_select('tmp_arr',('tmp_arr1'),$sql);
			
			if(count($obj_tmp1->tmp_arr) == 1)
			{
				$array_buff = $obj_tmp1->tmp_arr[tmp_arr1];
				
				foreach($where_array as $key=> $value)
				{
					if($result_value != "")
					{
						$result_value .= " And ";
					}
					$result_value .= $value."='".$array_buff[0][$value]."'";
				}
			}
			else
			{
				$result_value=" 1=1 ";
			}
		}
		else
		{
			$result_value=" 1=1 ";
		}
	}
	else
	{
		$result_value=" 1=1 ";
	}
	
	return $result_value;
}

//單階整體排序
function OverallSort($obj_tmp1, $table_name="", $where_string="", $order_by_string="")
{
	if($table_name != "")
	{
		$obj_tmp1->tmp_arr =array();
		$obj_tmp1->laout_set=false;
		
		//查詢全部資料
		$sql = " Select id, sort From ".$table_name.$where_string.$order_by_string;
		$obj_tmp1->basic_select('tmp_arr',('tmp_arr1'),$sql);
		
		if(count($obj_tmp1->tmp_arr['tmp_arr1']) != 0)
		{
			$index = 1;
			foreach($obj_tmp1->tmp_arr['tmp_arr1'] as $key => $value)
			{
				$sql = " Update ".$table_name." Set sort=".$index." Where id=".$value["id"];
				$obj_tmp1->basic_sql_run($sql,'no');
				
				$index = $index + 1;
			}
		}
	}
}

function FunctionOverAllSort($obj_tmp1, $table_name="", $parent_id , $order_by_string="")
{
	if($table_name != "")
	{
		$obj_tmp1->tmp_arr =array();
		$obj_tmp1->laout_set=false;
		
		//查詢全部資料
		$sql = " Select id, sort From ".$table_name." Where paren_id = ".$parent_id." ".$order_by_string;
		$obj_tmp1->basic_select('tmp_arr',('tmp_arr1'),$sql);
		
		if(count($obj_tmp1->tmp_arr['tmp_arr1']) != 0)
		{
			$parent_array = $obj_tmp1->tmp_arr['tmp_arr1'];
			
			foreach($parent_array as $key => $value)
			{
				//編輯下層排序
				FunctionOverAllSort($obj_tmp1, $table_name, $value["id"], $order_by_string);
			}
			$where_string = " Where parent_id= ".$parent_id;
			OverallSort($obj_tmp1, $table_name, $where_string, $order_by_string);
		}
	}
}

function CreateFunctionList($obj_tmp1, $table_name, $user_table = "", $parent_id = 0, $where_string="", $order_by_string = " Order By id Asc ", $LevelNumber = 1)
{
	$obj_tmp1->laout_arr["tmp_arr_sublist"] =array();
	$obj_tmp1->tmp_where = $where_string;
	
	$sql=" Select ".$table_name.".*, user_table.name As user_name From  ".$table_name." As ".$table_name." Left Join ".$user_table." As user_table On ".$table_name."._system_account_id = user_table.id ".$obj_tmp1->tmp_where." ";
	if($obj_tmp1->tmp_where == "")
	{
		$sql .= " Where 1=1 ";
	}
	$sql .= " And ".$table_name.".parent_id = ".$parent_id." ".$order_by_string;
	
	$obj_tmp1->basic_select('laout_arr','tmp_arr_sublist',$sql);
	
	//暫存
	$SubList = $obj_tmp1->laout_arr["tmp_arr_sublist"];
	
	if(count($SubList) != 0)
	{
		$TotalList = array();
		$space_string ="";
		for($index = 1; $index <= $LevelNumber; $index++)
		{
			if($LevelNumber > 1)
			{
				$space_string .="&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			else
			{
				$space_string .="&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		}
		//查詢子功能
		foreach($SubList as $key => $value)
		{
			
			$value["name_tw"] = $space_string.$value["name_tw"];
			$value["name_en"] = $space_string.$value["name_en"];
			$TotalList[] = $value;
			//取得下層類別
			$LevelNumber = $LevelNumber + 1;
			$array_buff = CreateFunctionList($obj_tmp1, $table_name, $user_table, $value["id"], $where_string, $order_by_string, $LevelNumber);
			
			if(count($array_buff) > 0)
			{
				foreach($array_buff as $key2 => $value2)
				{
					$TotalList[] = $value2;
				}
			}
		}
		return $TotalList;
	}
	else
	{
		return NULL;
	}
}

//新增功能時，新增會員、群組、管理者的權限
function AddFunctionAuth($obj_tmp1, $function_id = 0, $default_is_read = 0, $default_is_insert = 0, $default_is_edit = 0, $default_is_delete = 0, $default_is_control = 0, $sys_table_name = "")
{
	if($function_id == 0 || $sys_table_name == "")
	{
		return;
	}
	else
	{
		$obj_tmp1->laout_arr["auth_arr1"] = NULL;
		//取得管理者
		$sql = " Select id From ".$sys_table_name."system_account Order By id Asc";
		$obj_tmp1->basic_select('laout_arr',('auth_arr1'),$sql);
		
		if(count($obj_tmp1->laout_arr["auth_arr1"]) > 0)
		{
			$auth_array = $obj_tmp1->laout_arr["auth_arr1"];
			foreach($auth_array as $key => $value)
			{
				//新增初始權限
				InsertAccountAuth($obj_tmp1, $value["id"], $function_id, $default_is_read, $default_is_insert, $default_is_edit, $default_is_delete, $default_is_control, $sys_table_name."system_account_auth_comparison");
			}
			
			$obj_tmp1->laout_arr["auth_arr1"]	= NULL;
		}
		
		//取得管理者群組
		$sql = " Select id From ".$sys_table_name."system_account_group Order By id Asc";
		$obj_tmp1->basic_select('laout_arr',('auth_arr1'),$sql);
		
		if(count($obj_tmp1->laout_arr["auth_arr1"]) > 0)
		{
			$auth_array = $obj_tmp1->laout_arr["auth_arr1"];
			foreach($auth_array as $key => $value)
			{
				//新增初始權限
				InsertAccountGroupAuth($obj_tmp1, $value["id"], $function_id, $default_is_read, $default_is_insert, $default_is_edit, $default_is_delete, $default_is_control, $sys_table_name."system_account_group_auth_comparison");
			}
			
			$obj_tmp1->laout_arr["auth_arr1"]	= NULL;
		}
		
		//取得會員群組
		$sql = " Select id From ".$sys_table_name."system_member_group Order By id Asc";
		$obj_tmp1->basic_select('laout_arr',('auth_arr1'),$sql);
		
		if(count($obj_tmp1->laout_arr["auth_arr1"]) > 0)
		{
			$auth_array = $obj_tmp1->laout_arr["auth_arr1"];
			foreach($auth_array as $key => $value)
			{
				//新增初始權限
				InsertMemberGroupAuth($obj_tmp1, $value["id"], $function_id, $default_is_read, $default_is_insert, $default_is_edit, $default_is_delete, $default_is_control, $sys_table_name."system_member_auth_comparison");
			}
			
			$obj_tmp1->laout_arr["auth_arr1"]	= NULL;
		}
	}
}

//新增功能時，新增管理者的權限
function AddAccountAuth($obj_tmp1, $account_id = 0, $default_is_read = 0, $default_is_insert = 0, $default_is_edit = 0, $default_is_delete = 0, $default_is_control = 0, $sys_table_name = "")
{
	if($account_id == 0 || $sys_table_name == "")
	{
		return;
	}
	else
	{
		$obj_tmp1->laout_arr["auth_arr1"] = NULL;
		//取得功能
		$sql = " Select id From ".$sys_table_name."system_function Order By id Asc";
		$obj_tmp1->basic_select('laout_arr',('auth_arr1'),$sql);
		
		if(count($obj_tmp1->laout_arr["auth_arr1"]) > 0)
		{
			$account_array = $obj_tmp1->laout_arr["auth_arr1"];
			foreach($account_array as $key => $value)
			{
				//新增初始權限
				InsertAccountAuth($obj_tmp1, $account_id, $value["id"], $default_is_read, $default_is_insert, $default_is_edit, $default_is_delete, $default_is_control, $sys_table_name."system_account_auth_comparison");
			}
			
			$obj_tmp1->laout_arr["auth_arr1"]	= NULL;
		}
	}
}

//新增功能時，新增管理者群組的權限
function AddAccountGroupAuth($obj_tmp1, $account_group_id = 0, $default_is_read = 0, $default_is_insert = 0, $default_is_edit = 0, $default_is_delete = 0, $default_is_control = 0, $sys_table_name = "")
{
	if($account_group_id == 0 || $sys_table_name == "")
	{
		return;
	}
	else
	{
		$obj_tmp1->laout_arr["auth_arr1"] = NULL;
		//取得功能
		$sql = " Select id From ".$sys_table_name."system_function Order By id Asc";
		$obj_tmp1->basic_select('laout_arr',('auth_arr1'),$sql);
		
		if(count($obj_tmp1->laout_arr["auth_arr1"]) > 0)
		{
			$account_array = $obj_tmp1->laout_arr["auth_arr1"];
			foreach($account_array as $key => $value)
			{
				//新增初始權限
				InsertAccountGroupAuth($obj_tmp1, $account_group_id, $value["id"], $default_is_read, $default_is_insert, $default_is_edit, $default_is_delete, $default_is_control, $sys_table_name."system_account_group_auth_comparison");
			}
			
			$obj_tmp1->laout_arr["auth_arr1"]	= NULL;
		}
	}
}

//新增管理者權限
function InsertAccountAuth($obj_tmp1, $account_id, $function_id, $is_read = 0, $is_insert = 0, $is_edit = 0, $is_delete = 0, $is_control = 0, $table_name)
{
	//top set
   	$obj_tmp1->title="會議內容列表";
   	$obj_tmp1->keywords='會議內容列表';
   	$obj_tmp1->description='會議內容列表';
  	$obj_tmp1->laout_set=false;
	$obj_tmp1->table_name=$table_name;
  	//end top set
	$query_arr["_system_account_id"]	=	$account_id;
	$query_arr["_system_function_id"]	=	$function_id;
	$query_arr["is_read"]				=	$is_read;
	$query_arr["is_insert"]				=	$is_insert;
	$query_arr["is_edit"]				=	$is_edit;
	$query_arr["is_delete"]				=	$is_delete;
	$query_arr["is_control"]			=	$is_control;
	
	$obj_tmp1->insert_update($query_arr,'no');
}

//新增功能時，新增會員群組的權限
function AddMemberGroupAuth($obj_tmp1, $account_group_id = 0, $default_is_read = 0, $default_is_insert = 0, $default_is_edit = 0, $default_is_delete = 0, $default_is_control = 0, $sys_table_name = "")
{
	if($account_group_id == 0 || $sys_table_name == "")
	{
		return;
	}
	else
	{
		$obj_tmp1->laout_arr["auth_arr1"] = NULL;
		//取得功能
		$sql = " Select id From ".$sys_table_name."system_function Order By id Asc";
		$obj_tmp1->basic_select('laout_arr',('auth_arr1'),$sql);
		
		if(count($obj_tmp1->laout_arr["auth_arr1"]) > 0)
		{
			$account_array = $obj_tmp1->laout_arr["auth_arr1"];
			foreach($account_array as $key => $value)
			{
				//新增初始權限
				InsertAccountGroupAuth($obj_tmp1, $account_group_id, $value["id"], $default_is_read, $default_is_insert, $default_is_edit, $default_is_delete, $default_is_control, $sys_table_name."system_member_auth_comparison");
			}
			
			$obj_tmp1->laout_arr["auth_arr1"]	= NULL;
		}
	}
}

//新增管理者群組權限
function InsertAccountGroupAuth($obj_tmp1, $account_group_id, $function_id, $is_read = 0, $is_insert = 0, $is_edit = 0, $is_delete = 0, $is_control = 0, $table_name)
{
	//top set
   	$obj_tmp1->title="會議內容列表";
   	$obj_tmp1->keywords='會議內容列表';
   	$obj_tmp1->description='會議內容列表';
  	$obj_tmp1->laout_set=false;
	$obj_tmp1->table_name=$table_name;
  	//end top set
	$query_arr["_system_group_id"]		=	$account_group_id;
	$query_arr["_system_function_id"]	=	$function_id;
	$query_arr["is_read"]				=	$is_read;
	$query_arr["is_insert"]				=	$is_insert;
	$query_arr["is_edit"]				=	$is_edit;
	$query_arr["is_delete"]				=	$is_delete;
	$query_arr["is_control"]			=	$is_control;
	
	$obj_tmp1->insert_update($query_arr,'no');
}

//新增會員群組權限
function InsertMemberGroupAuth($obj_tmp1, $member_group_id, $function_id, $is_read = 0, $is_insert = 0, $is_edit = 0, $is_delete = 0, $is_control = 0, $table_name)
{
	//top set
   	$obj_tmp1->title="會議內容列表";
   	$obj_tmp1->keywords='會議內容列表';
   	$obj_tmp1->description='會議內容列表';
  	$obj_tmp1->laout_set=false;
	$obj_tmp1->table_name=$table_name;
  	//end top set
	$query_arr["_system_group_id"]		=	$member_group_id;
	$query_arr["_system_function_id"]	=	$function_id;
	$query_arr["is_read"]				=	$is_read;
	$query_arr["is_insert"]				=	$is_insert;
	$query_arr["is_edit"]				=	$is_edit;
	$query_arr["is_delete"]				=	$is_delete;
	$query_arr["is_control"]			=	$is_control;
	
	$obj_tmp1->insert_update($query_arr,'no');
}


//編輯器 名稱,寬,高,值
function Fck($name,$width,$height,$path,$value = NULL,$style = NULL)
{
//html編輯器
$oFCKeditor = new FCKeditor($name);
$oFCKeditor->BasePath = $path;
$oFCKeditor->Width = $width;
$oFCKeditor->Height = $height;	
$oFCKeditor->Config['DefaultLanguage'] = 'zh';
if($style!=NULL)$oFCKeditor->Config['EditorAreaCSS'] = $style;

$oFCKeditor->Value = deQuotes($value,-1);


/*FCK
$style = substr($style,3,strlen($style));//FCK  CK 所在資料夾不同

return Ckedit($name,$value,$style);
/*FCK*/


return $oFCKeditor->CreateHtml();

}





//編輯器 名稱,寬,高,值
function Ckedit($name,$value,$style=NULL)
{
	ob_start(); //打開快取
	echo '<textarea id="'.$name.'" name="'.$name.'" cols="1" rows="1">'.deQuotes($value,-1).'</textarea>';
	$CKEditor = new CKEditor();
	$CKEditor->basePath = '../includes/ckeditor/';
	
	if($style!=NULL) $CKEditor->config = array('contentsCss'=>$style);
	
	$CKEditor->replace($name);
	
	$tmp = ob_get_contents(); //接收快取頁面
	ob_end_clean(); //關閉快取
	
	return $tmp;
}


//魔術引號
function quotes($content)
{
	if (is_array($content)) 
	{
		foreach ($content as $key=>$value) 
		{
			$content[$key] = addslashes(trim($value));
		}
	}
	 else 
	{
		$content=addslashes(trim($content));
	}
	return $content;
}


//解魔術引號  $mode:1預設移除html標籤避免破壞版面
function deQuotes($content,$mode=1)
{
	//不管get_magic_quotes_gpc 開啟只會幫你加/，不會幫解。故不管開啟與否都要加 stripslashes 自解

	if (is_array($content)) 
	{
		foreach ($content as $key=>$value) 
		{
			$content[$key] = stripslashes($value);
		}
	}
	 else 
	{
		$content=stripslashes($content);
	}
	
	if($mode==1)
	{
		//濾掉所有標籤 防止xss攻擊
		$content=strip_tags($content);
	}
	
	return $content;
}

//初始化產品子項目
function ProductItemInitHandle($obj_tmp1, $table_name, $product_id)
{
	$sql="Update ".$table_names." Set status= 'x' where product_id= ".$product_id." ";
    mysql_query($sql);
}

//處理產品子項目
function ProductItemHandle($obj_tmp1, $table_name, $item_id, $query_arr)
{
	//top set
   	$obj_tmp1->title="會議內容列表";
   	$obj_tmp1->keywords='會議內容列表';
   	$obj_tmp1->description='會議內容列表';
  	$obj_tmp1->laout_set=false;
	$obj_tmp1->table_name=$table_name;
	
  	//end top set
	//get
	$query_arr['update_date_time']=date('Y-m-d H:i:s',strtotime('now'));
	$query_arr['_system_account_id']=$_SESSION[USER_INFO]["id"];
	//end get
	
	if($item_id == "0")
	{
		$sql = "SELECT count(id) + 1 As max_sort FROM ".$table_name." Where status!='x' ";
		$obj_tmp1->basic_select('laout_arr','tmp_arr',$sql);
		$query_arr['sort']=$obj_tmp1->laout_arr['tmp_arr'][0]['max_sort'];
		if($query_arr['sort'] ==0){$query_arr['sort'] =1;}
		$obj_tmp1->laout_arr['tmp_arr']=NULL;
	
		$query_arr['create_date_time']=date('Y-m-d H:i:s',strtotime('now'));
		$obj_tmp1->insert_update($query_arr,'no');
	}
	else
	{
		$obj_tmp1->tmp_where="where id ='".$item_id."'";
    	$obj_tmp1->edit_update($query_arr, 'no');
	}
}

//處理購物車詳細內容
function OrderDetailHandle($obj_tmp1, $table_name, $query_arr)
{
	//top set
   	$obj_tmp1->title="會議內容列表";
   	$obj_tmp1->keywords='會議內容列表';
   	$obj_tmp1->description='會議內容列表';
  	$obj_tmp1->laout_set=false;
	$obj_tmp1->table_name=$table_name;
  	//end top set
	
	//get
	
	//end get
	
	$obj_tmp1->insert_update($query_arr,'no');
}

function CreateShoppingCart($Shopping_Order_Name, $Shopping_OrderDetail_Name)
{
	$ShoppingCart[$Shopping_Order_Name] = CreateShoppingOrder();
	$ShoppingCart[$Shopping_OrderDetail_Name] = "";
	
	return $ShoppingCart;
}

//建立訂單欄位
function CreateShoppingOrder()
{
	$ShoppingOrder["first_name"] = "";
	$ShoppingOrder["first_name_billing"] = "";
	$ShoppingOrder["last_name"] = "";
	$ShoppingOrder["last_name_billing"] = "";
	$ShoppingOrder["title_id"] = "";
	$ShoppingOrder["title_id_billing"] = "";
	$ShoppingOrder["phone"] = "";
	$ShoppingOrder["phone_billing"] = "";
	$ShoppingOrder["mobile"] = "";
	$ShoppingOrder["mobile_billing"] = "";
	$ShoppingOrder["country_id"] = "";
	$ShoppingOrder["country_id_billing"] = "";
	$ShoppingOrder["zipcode"] = "";
	$ShoppingOrder["zipcode_billing"] = "";
	$ShoppingOrder["city"] = "";
	$ShoppingOrder["city_billing"] = "";
	$ShoppingOrder["territory"] = "";
	$ShoppingOrder["territory_billing"] = "";
	$ShoppingOrder["address"] = "";
	$ShoppingOrder["address_billing"] = "";
	$ShoppingOrder["bonus_id"] = 0;
	$ShoppingOrder["bonus_use"] = 0;
	$ShoppingOrder["order_count"] = 0;
	$ShoppingOrder["order_quantity_count"] = 0;
	$ShoppingOrder["order_fare"] = 0;
	$ShoppingOrder["order_discount"] = 0;
	$ShoppingOrder["order_realTotal"] = 0;
	
	return $ShoppingOrder;
}

//建立訂單細項欄位
function CreateShoppingOrderDetail()
{
	$ShoppingOrderDetail["product_id"] = "";
	$ShoppingOrderDetail["product_item_id"] = "";
	$ShoppingOrderDetail["product_item_number"] = "";
	$ShoppingOrderDetail["series_id"] = "";
	$ShoppingOrderDetail["color_id"] = "";
	$ShoppingOrderDetail["size_id"] = "";
	$ShoppingOrderDetail["quantity"] = 0;
	$ShoppingOrderDetail["price"] = 0;
	$ShoppingOrderDetail["count"] = 0;
	
	return $ShoppingOrderDetail;
}

//訂單寄信
function OrderMailTo($obj_tmp1, $ToEmail, $ShoppingCart, $Shopping_Order_Name, $Shopping_OrderDetail_Name)
{
	//page default
   	$obj_tmp1->table_name = $table_name;
	$obj_tmp1->title="會議內容列表";
	$obj_tmp1->keywords='會議內容列表';
	$obj_tmp1->description='會議內容列表';
   	$obj_tmp1->tmp_where;
   	$obj_tmp1->tmp_order;
   	$obj_tmp1->tmp_id;
   	$obj_tmp1->lang_set = $_SESSION[Platform_Code][USER_INFO]["lang_set"];
	$obj_tmp1->laout_set=true;
	//end page default

	$product_table_name = TABLE_NAME."backservice_product";
	$product_item_table_name = TABLE_NAME."backservice_product_item";
	$product_series_table_name = TABLE_NAME."backservice_series";
	$page_edit_table_name = TABLE_NAME."backservice_page_edit";
	$website_setting_table_name = TABLE_NAME."system_website_setting";
	
	//取得網站設定	Start
	$sql = " Select * From ".$website_setting_table_name." ";
	$sql .= " Where type='default' And status='y' Limit 0,1 ";
	
	$obj_tmp1->basic_select('laout_arr','setting_arr',$sql);
	//取得網站設定	End
	
	//取得城鎮	Start
	$sql = " Select * From ".$page_edit_table_name." ";
	$sql .= " Where id = ".$ShoppingCart[$Shopping_Order_Name]["country_id"]." And type = 'country_fare' And status = 'y' Limit 0,1 ";
			
	$obj_tmp1->basic_select('laout_arr','country_fare_arr',$sql);
	//取得城鎮	End
	
	if(count($obj_tmp1->laout_arr["setting_arr"]) > 0)
	{
		$quantity_total = 0;
		$tr_html = "";
		foreach($ShoppingCart[$Shopping_OrderDetail_Name] as $key => $value)
		{
			$obj_tmp1->laout_arr["product_item_arr"] = null;
			
			//取得Product Item	Start
			$sql = " Select ".$product_item_table_name.".*, ".$product_table_name.".name_".$obj_tmp1->lang_set." As ProductName ,".$product_table_name.".series_id, ".$product_table_name.".color_id, ".$product_table_name.".file_path, ".$product_table_name.".file_name, ".$product_series_table_name.".name_".$obj_tmp1->lang_set." As SeriesName, ".$product_series_table_name.".price, Color_".$page_edit_table_name.".name_".$obj_tmp1->lang_set." As ColorName, Size_".$page_edit_table_name.".name_".$obj_tmp1->lang_set." As SizeName ";
			$sql .= " From ".$product_item_table_name." As ".$product_item_table_name." ";
			$sql .= " Left Join ".$product_table_name." As ".$product_table_name." On ".$product_table_name.".id = ".$product_item_table_name.".product_id ";
			$sql .= " Left Join ".$product_series_table_name." As ".$product_series_table_name." On ".$product_series_table_name.".id = ".$product_table_name.".series_id ";
			$sql .= " Left Join ".$page_edit_table_name." As Color_".$page_edit_table_name." On Color_".$page_edit_table_name.".id = ".$product_table_name.".color_id ";
			$sql .= " Left Join ".$page_edit_table_name." As Size_".$page_edit_table_name." On Size_".$page_edit_table_name.".id = ".$product_item_table_name.".size_id ";
			$sql .= " Where ".$product_item_table_name.".id = ".$value["product_item_id"]." And ".$product_item_table_name.".status = 'y' Order by ".$product_item_table_name.".sort Asc Limit 0,1 ";
				
			$obj_tmp1->basic_select('laout_arr','product_item_arr',$sql);
			//取得Product Item	End
			
			$quantity_total += intval($value["quantity"], 10);
			
			if(count($obj_tmp1->laout_arr["product_item_arr"]) > 0)
			{
				foreach($obj_tmp1->laout_arr["product_item_arr"] as $key2 => $value2)
				{
					$tr_html .= "<tr>";
					$tr_html .= "	<td align=\"center\" height=\"40\">";
					$tr_html .= $value["product_item_number"];
					$tr_html .= "	</td>";
					$tr_html .= "	<td align=\"center\">";
					$tr_html .= $value2["ProductName"];
					$tr_html .= "	</td>";
					$tr_html .= "	<td align=\"center\">";
					$tr_html .= $value2["ColorName"];
					$tr_html .= "	</td>";
					$tr_html .= "	<td align=\"center\">";
					$tr_html .= $value2["SizeName"];
					$tr_html .= "	</td>";
					$tr_html .= "	<td align=\"center\">";
					$tr_html .= $value["price"];
					$tr_html .= "	</td>";
					$tr_html .= "	<td align=\"center\">";
					$tr_html .= $value["quantity"];
					$tr_html .= "	</td>";
					$tr_html .= "	<td align=\"center\">";
					$tr_html .= $value["count"];
					$tr_html .= "	</td>";
				}
			}
		}
		
		$LogoImg = WEB_PATH."images/invoice_logo.jpg";
		
		$email = array();
		$email["order_no"] = $ShoppingCart[$Shopping_Order_Name]["OrderNo"];
		$email["name"] = $ShoppingCart[$Shopping_Order_Name]["first_name"]." ".$ShoppingCart[$Shopping_Order_Name]["last_name"];
		$email["order_realTotal"] = $ShoppingCart[$Shopping_Order_Name]["order_realTotal"];
		$email["address"] = $ShoppingCart[$Shopping_Order_Name]["address"];
		$email["city"] = $ShoppingCart[$Shopping_Order_Name]["city"];
		$email["zipcode"] = $ShoppingCart[$Shopping_Order_Name]["zipcode"];
		$email["country"] = $obj_tmp1->laout_arr["country_fare_arr"][0]["name_".$obj_tmp1->lang_set];
		$email["phone"] = $ShoppingCart[$Shopping_Order_Name]["phone"];
		$email["order_fare"] = $ShoppingCart[$Shopping_Order_Name]["order_fare"];
		$email["quantity_total"] = $quantity_total;
		$email["tr_html"] = $tr_html;
		$email["logo_image"] = $LogoImg;
		$obj_tmp1->email = $email;
		
		ob_start(); 	//打開快取
		$obj_tmp1->laout(('invoice.html'));
		$cache_string = ob_get_contents(); //接收快取頁面
		ob_end_clean(); //關閉快取
		
		$message = iconv("utf-8","big5",$cache_string);
		$subject = iconv("utf-8","big5",$ToEmail);
		$headers = 'Content-type: text/html; charset="big5"' . "\r\n";
		$headers .= "From: ".$obj_tmp1->laout_arr["setting_arr"][0]["email"]. "\r\n"; // 請自行替換寄件地址
		$mailTo = $ToEmail;
		
		ini_set ( "SMTP", "msa.hinet.net" );
		mail($mailTo, $subject, $message, $headers);
	}
}

//整理購物車
function ShoppingCartHandle($obj_tmp1, $ShoppingCart, $Shopping_Order_Name, $Shopping_OrderDetail_Name)
{
	if(!empty($ShoppingCart))
	{
		if(count($ShoppingCart[$Shopping_Order_Name]) > 0)
		{
			$bonus_use = 0;
			$order_count = 0;
			$order_quantity_count = 0;
			$order_fare = 0;
			$order_discount = 0;
			$order_realTotal = 0;
			
			if(count($ShoppingCart[$Shopping_OrderDetail_Name]) > 0)
			{
				$product_total = 0;
				foreach($ShoppingCart[$Shopping_OrderDetail_Name] as $key => $value)
				{
					$product_count = 0;
					$product_price = 0;
					$product_quantity = 0;
					
					$product_price = floatval($value["price"]);
					$product_quantity = intval($value["quantity"]);
					$product_count = sprintf("%.2f", ($product_price * $product_quantity));
					$ShoppingCart[$Shopping_OrderDetail_Name][$key]["count"] = $product_count;
					
					$order_quantity_count += $product_quantity;
					$product_total += $product_count;
				}
				$order_count = $product_total;
			}
			$bonus_use = floatval($ShoppingCart[$Shopping_Order_Name]["bonus_use"]);
			$order_fare = floatval($ShoppingCart[$Shopping_Order_Name]["order_fare"]);
			$order_realTotal = $order_count + $order_fare - $bonus_use;
			
			$_SESSION[Platform_Code][USER_INFO]["ShoppingCart"][$Shopping_Order_Name]["bonus_use"] = sprintf("%.2f", $bonus_use);
			$_SESSION[Platform_Code][USER_INFO]["ShoppingCart"][$Shopping_Order_Name]["order_discount"] = sprintf("%.2f", $order_discount);
			$_SESSION[Platform_Code][USER_INFO]["ShoppingCart"][$Shopping_Order_Name]["order_count"] = sprintf("%.2f", $order_count);
			$_SESSION[Platform_Code][USER_INFO]["ShoppingCart"][$Shopping_Order_Name]["order_quantity_count"] = $order_quantity_count;
			$_SESSION[Platform_Code][USER_INFO]["ShoppingCart"][$Shopping_Order_Name]["order_fare"] = sprintf("%.2f", $order_fare);
			$_SESSION[Platform_Code][USER_INFO]["ShoppingCart"][$Shopping_Order_Name]["order_realTotal"] = sprintf("%.2f", $order_realTotal);
		}
	}
}

function isActiveProduct($obj_tmp1, $ActiveSetCategoryID, $ProductID)
{
	//top set
   	$obj_tmp1->title="會議內容列表";
   	$obj_tmp1->keywords='會議內容列表';
   	$obj_tmp1->description='會議內容列表';
  	$obj_tmp1->laout_set=false;
	$obj_tmp1->table_name=$table_name;
  	//end top set
	
	$product_table_name = TABLE_NAME."backservice_product";
	$product_item_table_name = TABLE_NAME."backservice_product_item";
	$product_series_table_name = TABLE_NAME."backservice_series";
	
	$reVal = false;
	
	//取得Product	Start
	$sql = " Select ".$product_table_name.".* ";
	$sql .= " From ".$product_table_name." As ".$product_table_name." ";
	$sql .= " Left Join ".$product_series_table_name." As ".$product_series_table_name." On ".$product_series_table_name.".id = ".$product_table_name.".series_id ";
	$sql .= " Where ".$product_table_name.".id = ".$ProductID." And ".$product_series_table_name.".id in (".$ActiveSetCategoryID.") And ".$product_table_name.".status = 'y' ";
	
	$obj_tmp1->basic_select('laout_arr','product_arr',$sql);
	//取得Product	End
	
	if(count($obj_tmp1->laout_arr["product_arr"]) > 0)
	{
		$reVal = true;
	}
	
	return $reVal;
}

function ActiveDetailHandle($obj_tmp1, $table_name, $ActiveID, $OrderID, $MemberID, $OnlineDate, $OfflineDate, $Bonus)
{
	//top set
   	$obj_tmp1->title="會議內容列表";
   	$obj_tmp1->keywords='會議內容列表';
   	$obj_tmp1->description='會議內容列表';
  	$obj_tmp1->laout_set=false;
	$obj_tmp1->table_name=$table_name;
  	//end top set
	
	//get
	$ActiveNo = GetActiveNo($obj_tmp1, $table_name);
	$query_arr["ActiveNo"] = $ActiveNo;
	$query_arr["ActiveID"] = $ActiveID;
	$query_arr["OrderID"] = $OrderID;
	$query_arr["MemberID"] = $MemberID;
	$query_arr["OnlineDate"] = $OnlineDate;
	$query_arr["OfflineDate"] = $OfflineDate;
	$query_arr["Bonus"] = $Bonus;
	$query_arr['update_date_time']=date('Y-m-d H:i:s',strtotime('now'));
	$query_arr['create_date_time']=date('Y-m-d H:i:s',strtotime('now'));
	$query_arr['_system_account_id']=1;
	//end get
	
	if($ActiveNo != "")
	{
		$obj_tmp1->insert_update($query_arr,'no');
	}
}

function GetActiveNo($obj_tmp1, $table_name)
{
	$ActiveNo = "";
	
	//產生不重複活動編號
	while (CheckActiveNo($obj_tmp1, $table_name, $ActiveNo)) {
		$ActiveNo = date('ymd',strtotime('now')).GetRandomNumber(6);
	}
	
	return $ActiveNo;
}

function CheckActiveNo($obj_tmp1, $table_name, $ActiveNo)
{
	$isNG = true;
	
	if($ActiveNo != "")
	{
		//top set
		$obj_tmp1->title="會議內容列表";
		$obj_tmp1->keywords='會議內容列表';
		$obj_tmp1->description='會議內容列表';
		$obj_tmp1->laout_set=false;
		$obj_tmp1->table_name=$table_name;
		//end top set
		
		//取得活動內容	Start
		$sql = " Select * From ".$table_name." ";
		$sql .= " Where ActiveNo = '".$ActiveNo."' Limit 0,1 ";
		
		$obj_tmp1->basic_select('laout_arr','active_deatil_arr',$sql);
		//取得活動內容	End
		
		//如果活動編號不重複
		if(count($obj_tmp1->laout_arr["active_deatil_arr"]) <= 0)
		{
			$isNG = false;
		}
	}
	
	return $isNG;
}

function GetRandomNumber($NumberLength)
{
	$reVal = "";
	$EnglishString = "abcdefghijklmnopqrstuvwxyz0123456789";
	
	for($RowIndex = 0;$RowIndex < $NumberLength;$RowIndex++)
	{
		$RndLength = rand(0, strlen($EnglishString) - 1);
		$reVal .= mb_substr( $EnglishString, $RndLength, 1,"utf-8");
	}
	
	return $reVal;
}

function CreateActiveBonus($obj_tmp1, $active_detail_table_name, $member_active_table_name, $OrderID, $system_account_id)
{
	//top set
	$obj_tmp1->title="會議內容列表";
	$obj_tmp1->keywords='會議內容列表';
	$obj_tmp1->description='會議內容列表';
	$obj_tmp1->laout_set=false;
	$obj_tmp1->table_name=$member_active_table_name;
	//end top set
		
	//取得活動內容	Start
	$sql = " Select * From ".$active_detail_table_name." ";
	$sql .= " Where OrderID = ".$OrderID." Order By create_date_time Asc ";
		
	$obj_tmp1->basic_select('laout_arr','active_deatil_arr',$sql);
	//取得活動內容	End
	
	if(count($obj_tmp1->laout_arr["active_deatil_arr"]) > 0)
	{
		foreach($obj_tmp1->laout_arr["active_deatil_arr"] as $key => $value)
		{
			$query_arr = null;
			$query_arr = $value;
			$query_arr['used_date_time'] = date('Y-m-d H:i:s',strtotime('now'));
			$query_arr['update_date_time'] = date('Y-m-d H:i:s',strtotime('now'));
			$query_arr['create_date_time'] = date('Y-m-d H:i:s',strtotime('now'));
			$query_arr['_system_account_id'] = $system_account_id;
			
			$obj_tmp1->insert_update($query_arr,'no');
		}
	}
}

function BonusDataHandle($obj_tmp1, $member_active_table_name, $MemberActiveID)
{
	//top set
	$obj_tmp1->title="會議內容列表";
	$obj_tmp1->keywords='會議內容列表';
	$obj_tmp1->description='會議內容列表';
	$obj_tmp1->laout_set=false;
	$obj_tmp1->table_name=$active_detail_table_name;
	//end top set
	
	$NowTime = date('Y-m-d H:i:s',strtotime('now'));
	$action_counter_sql="update ".$member_active_table_name." set isUsed='y', used_date_time='".$NowTime."', update_date_time='".$NowTime."' where id=".$MemberActiveID." ";
    mysql_query($action_counter_sql);
}

function UpdateActiveBonus($obj_tmp1, $member_active_table_name, $MemberBonusID)
{
	//top set
	$obj_tmp1->title="會議內容列表";
	$obj_tmp1->keywords='會議內容列表';
	$obj_tmp1->description='會議內容列表';
	$obj_tmp1->laout_set=false;
	$obj_tmp1->table_name=$member_active_table_name;
	//end top set
	
	$NowTime = date('Y-m-d H:i:s',strtotime('now'));
	$action_counter_sql="update ".$member_active_table_name." set isUsed='n', update_date_time='".$NowTime."' where id=".$MemberBonusID." ";
	
	mysql_query($action_counter_sql);
}
//end pubic func
?>
