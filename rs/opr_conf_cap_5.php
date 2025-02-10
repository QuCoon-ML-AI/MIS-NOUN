<?php 
require_once('../../fsher/fisher.php');
include('const_def.php');

include(BASE_FILE_NAME.'lib_fn.php');
//include(BASE_FILE_NAME.'lib_fn_2.php');

$mysqli = link_connect_db();

$mtn_satus = valid_mtn();

if ($mtn_satus == '0')
{
    echo 'Invalid matriculation number'; exit;
}else if ($mtn_satus == '2')
{
    $stmt = $mysqli->prepare("INSERT IGNORE INTO mtn_act_request SET vMatricNo = ?");
	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt->execute();
	$stmt->close();
	
	echo 'Matriculation number to be activated'; exit;
}else if (isset($_REQUEST["recover_pwd"]) && $_REQUEST["recover_pwd"] == '1')
{
    echo 'can continue';
    exit;
}else
{
	$cap = generate_string();
	$cap1 = str_replace(",","",$cap);

	$stmt = $mysqli->prepare("UPDATE rs_client
	SET cap_text = '$cap1'
	WHERE vMatricNo  = ?");
	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt->execute();
	$stmt->close();
	
	echo $cap;
	exit;
}?>