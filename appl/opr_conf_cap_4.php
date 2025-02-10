<?php 
require_once('../../fsher/fisher.php');
//include('const_def.php');
include('lib_fn.php');

$mysqli = link_connect_db();

if (valid_afn() == '0')
{
    log_actv('Login attempt failed - Invalid AFN');
   echo 'Invalid Application form number'; exit;
}else
{
	$cap = generate_string();
	$cap1 = str_replace(",","",$cap);

	$stmt = $mysqli->prepare("UPDATE app_client
	SET cap_text = '$cap1'
	WHERE vApplicationNo   = ?");
	$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
	$stmt->execute();
	$stmt->close();
	
	echo $cap;
	exit;
}?>