<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

if (isset($_REQUEST['ilin']) && $_REQUEST['ilin'] <> '' )
{
	$str = '';
	if (isset($_REQUEST['submission']) && $_REQUEST['submission'] == '1')
	{
		$stmt = $mysqli->prepare("REPLACE INTO other_cals 
		(prog_name,
		session_year0, 
		sem0, 
		sem1, 
		reg0, 
		reg1, 
		prj0,
		prj1,
		exam0,
		exam1)
		values
		(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssssssssss", 
		$_REQUEST["dept"],  
		$_REQUEST["session_year0"],   
		$_REQUEST["semester0"], 
		$_REQUEST["semester1"], 
		$_REQUEST["regist0"], 
		$_REQUEST["regist1"], 
		$_REQUEST["project0"], 
		$_REQUEST["project1"], 
		$_REQUEST["exami0"], 
		$_REQUEST["exami1"]);
		$stmt->execute();
		$stmt->close();

		echo 'Success';
	}
}?>