<?php

$USERINFORMATION = array(
	"TABLE"			=> "user_information",
	"ALL"			=> "user_information.*",
	"USERID"		=> "user_information.user_id",
	"NAME"			=> "user_information.name",
	"TYPE"			=> "user_information.type",
	"EMAIL"			=> "user_information.email",
	"PHOTO"			=> "user_information.photo",
	"UPDATETIME"	=> "user_information.update_time",		
);

$BAZICHAT = array(
	"TABLE"			=> "bazi_chat",
	"ALL"			=> "bazi_chat.*",
	"ID"			=> "bazi_chat.chat_id",
	"SENDER"		=> "bazi_chat.sender",
	"RECEIVER"		=> "bazi_chat.receiver",
	"TYPE"			=> "bazi_chat.type",
	"CONTENT"		=> "bazi_chat.content",
	"ISREAD"		=> "bazi_chat.is_read",
	"UPDATETIME"	=> "bazi_chat.update_time",
);



?>