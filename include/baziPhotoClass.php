<?php

class  BaziPhoto{
  public $resultAry = array();
 
  protected $isShowLayout = true;
  protected $table_name;
  protected $tmp_order ='order by id asc';
  protected $tmp_id;

  function __construct()
  {
  }

  function __destruct()
  {
  }

  function __get($property_name)
  {
    return isset($this->$property_name) ? $this->$property_name : null;
  }
              
  function __set($property_name, $value)
  { 
    $this->$property_name = $value; 
    return true;
  } 

  //$basic_sql='select * from news order by id asc ';
  //$obj_tmp1->tmp_select('tmp_arr',$basic_sql);
  //執行sql回傳指定物件陣列為 $this->[參數1][參數2][參數4]
  function basic_select($arr_name, $arr_key, $sqlCmd, $arr_subkey='')
  {
    $result=mysql_query($sqlCmd);
    
    if($result){
      while($tmp_row = @mysql_fetch_assoc($result)){
        if($arr_subkey =='')
          $this->{$arr_name}[$arr_key][]=$tmp_row;
        else
          $this->{$arr_name}[$arr_key][$arr_subkey]=$tmp_row;
      }
      @mysql_free_result($result);            
    }      
  }
  //end basic_select
    
  //  指定輸出html
  function showHTML($htmlPageName)
  {
    $this->resultAry=$this->laout_change_lang($this->resultAry);

    if($this->isShowLayout == true)
      include_once 'templates/'.$htmlPageName;
    else
      include_once 'templates/msg.htm';
  }

  function getIP ()
  {
    global $_SERVER;
    if (getenv('HTTP_CLIENT_IP')) {
      echo $ip = getenv('HTTP_CLIENT_IP');
      exit;
    }else if (getenv('HTTP_X_FORWARDED_FOR')) {
      $ip = getenv('HTTP_X_FORWARDED_FOR');
    }else if (getenv('REMOTE_ADDR')) {
      $ip = getenv('REMOTE_ADDR');
    }else {
      $ip = $_SERVER['REMOTE_ADDR'];
    }

    @list($a,$b,$c,$d)=explode('.',$ip);
    $a=(int)$a;  $b=(int)$b;  $c=(int)$c;  $d=(int)$d;
    
    if($a<=255 && $a>=0 && $b<=255 && $b>=0 && $c<=255 && $c>=0 && $d<=255 && $d>=0){
      $ip="$a.$b.$c.$d";
    }
    else{
      $ip=false;
    }

    return $ip;
  }

  function curPageURL() 
  {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on"){
      $pageURL .= "s";
    }
    $pageURL .= "://";
    if($_SERVER["SERVER_PORT"] != "80"){
      $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    }
    else{
      $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
  }

}

?>