<?php
require("function/phpmailer/class.phpmailer.php");
mb_internal_encoding('UTF-8');

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true; // turn on SMTP authentication
//這幾行是必須的

$mail->Username = "service.taolou@gmail.com";
$mail->Password = "!@QWas1234";
//這邊是你的gmail帳號和密碼

$mail->FromName = "TaoLou";
// 寄件者名稱(你自己要顯示的名稱)
$webmaster_email = "service.taolou@gmail.com"; 
//回覆信件至此信箱

$mail->From = $webmaster_email;
$mail->AddReplyTo($webmaster_email,"Squall.f");
//這不用改

$mail->WordWrap = 50;
//每50行斷一次行

//$mail->AddAttachment("/XXX.rar");
// 附加檔案可以用這種語法(記得把上一行的//去掉)

$mail->IsHTML(true); // send as HTML

//信件內容(html版，就是可以有html標籤的如粗體、斜體之類)


/*if(!$mail->Send()){
echo "寄信發生錯誤：" . $mail->ErrorInfo;
//如果有錯誤會印出原因
}
else{ 
echo "寄信成功123";
}*/

?>