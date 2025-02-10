<?php 
require_once('../../fsher/fisher.php');
include('const_def.php');

include(APPL_BASE_FILE_NAME.'lib_fn.php');
include(APPL_BASE_FILE_NAME.'lib_fn_2.php');

$mysqli = link_connect_db();

if (valid_stfn() == '0')
{
   echo "Invalid user name<p> Do the following:
   <br>1. Double check your entry for errors
   <br>2. If there are no errors, click the 'Sign-up' button to create an account for yourself"; 
   exit;
}else if (valid_stfn_role() == '0')
{
   echo 'Role not assigned. Let a request memo be sent to MIS from your Superior officer'; 
   exit;
}else if (valid_stfn_center() == 0)
{
    echo 'Centre not assigned'; 
	exit;
}else
{
	$cap = generate_string();
	$cap1 = str_replace(",","",$cap);

	$stmt = $mysqli->prepare("UPDATE userlogin
	SET cap_text = '$cap1'
	WHERE vApplicationNo  = ?");
	$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
	$stmt->execute();
	$stmt->close();
	
	echo $cap;
	exit;
}?>