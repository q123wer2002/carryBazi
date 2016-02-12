<?php
date_default_timezone_set('Asia/Taipei');
//db sql function


function html_check_filed($tmp_array,$check_arr){
      foreach($tmp_array as $key => $value) {
        if(!in_array($key,$check_arr)){
        echo "this is error";
        exit;
        }
       }
}


function html_col_var($action,$tmp_array){
if($action =='insert'){
      foreach($tmp_array as $key => $value) {
          $cols[]="`$key`";
          $vars[]="'".$value."'";

       }
       $tmp_array=array();
          $tmp_array['col']=$cols;
          $tmp_array['var']=$vars; 
  }
if($action =='update'){
      foreach($tmp_array as $key => $value) {
          $vars[]="`$key`="."'".$value."'";
       }
       $tmp_array=array();
          $tmp_array['var']=$vars; 
}

  
          
  return $tmp_array;
}




function array_insert_sql($table_name,$tmp_var_col_array){   //sysdate
  $tmp_sql="INSERT INTO `$table_name` ( ".implode(', ',$tmp_var_col_array['col'])." )
   values ( ".implode(", ",$tmp_var_col_array['var'])." );";
  return $tmp_sql;
}



function array_update_sql($table_name,$tmp_var_col_array,$tmp_where){//sysdate
  $tmp_sql="update $table_name set ".implode(", ",$tmp_var_col_array['var'])." $tmp_where ;";
  
  return $tmp_sql;
}

function array_delete_sql($table_name,$tmp_where){   
  $tmp_sql="delete from $table_name  $tmp_where ;";
  return $tmp_sql;
}
/*
function array_select_sql($table_name,$tmp_var_col_array){   
  $tmp_sql="INSERT INTO `$table_name` ( ".implode(', ',$tmp_var_col_array['col'])." )
   values ( ".implode(', ',$tmp_var_col_array['var'])." );";
  return $tmp_sql;
}
*/
//end db sql function
?>
