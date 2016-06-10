<?php

function DBAPI( $szDBAPIName, $aryParam, &$aryResult )
{
	require "DBSchema.php";

	$ErrorCode = array(
		//minus means error
		//zero means normal finish
		//positive means pass
		"Empty"			=>	-4,
		"ZeroData"		=>	-3,
		"NoData"		=>	-2,
		"ServerBusy"	=>	-1,
		"Success"		=>	0,
		"NeedDoSome"	=>	1,
	);

	//init
	$nErrorCode = $ErrorCode["Success"];
	$aryResult = "";

	//find api
	switch( $szDBAPIName )
	{
	//system_related
		case "Login":
		break;
		case "Logout":
		break;
	}
}

//db component
	function isDoSQLCmd( $szSQLCmd, $szDBAPIName, &$aryResult )
	{
		$isSuccess = false;

		$DBConnector = new RemoteModule();
		$DBConnector->SQLQuery( $szDBAPIName, $szSQLCmd );

		if( empty($DBConnector->resultArray[$szDBAPIName]) == false ){
			$isSuccess = true;
			$aryResult = $DBConnector->resultArray[$szDBAPIName];
		}

		unset( $DBConnector->resultArray[$szDBAPIName] );
		unset( $DBConnector );

		return $isSuccess;
	}

	function DoNonQueryComd( $szSQLCmd, $szDBAPIName )
	{
		$DBConnector = new RemoteModule();
		$DBConnector->SQLUpdate( $szSQLCmd );
		unset( $DBConnector );
	}

?>