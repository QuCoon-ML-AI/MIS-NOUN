<?php

$url = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if (!($url == 'https://www.nouonline.nou.edu.ng/' || 
	strpos($_SERVER['REQUEST_URI'],'home-page') || 
	strpos($_SERVER['REQUEST_URI'],'check-qualification') || 
	strpos($_SERVER['REQUEST_URI'],'guides-instructions') || 
	strpos($_SERVER['REQUEST_URI'],'pay-for-application-form') || 
	strpos($_SERVER['REQUEST_URI'],'initiate-pay') || 
	strpos($_SERVER['REQUEST_URI'],'confirm-pay-detail') || 
	strpos($_SERVER['REQUEST_URI'],'confirm-payment') || 
	strpos($_SERVER['REQUEST_URI'],'feed-back-from-rem') || 
	strpos($_SERVER['REQUEST_URI'],'new-application-number') || 
	strpos($_SERVER['REQUEST_URI'],'new-loggin-parameters') || 
	strpos($_SERVER['REQUEST_URI'],'new-application-number') || 
	
	strpos($_SERVER['REQUEST_URI'],'applicant_login_page')  || 
	strpos($_SERVER['REQUEST_URI'],'applicant_recover_password') || 
	strpos($_SERVER['REQUEST_URI'],'applicant_reset_password') || 
	strpos($_SERVER['REQUEST_URI'],'check_applicant_token') || 

	strpos($_SERVER['REQUEST_URI'],'staff_login_page')|| 
	strpos($_SERVER['REQUEST_URI'],'staff_recover_password') ||
	strpos($_SERVER['REQUEST_URI'],'staff_reset_password') || 
	strpos($_SERVER['REQUEST_URI'],'check_staff_token') || 
	
	strpos($_SERVER['REQUEST_URI'],'student_login_page') || 
	strpos($_SERVER['REQUEST_URI'],'student_recover_password') || 
	strpos($_SERVER['REQUEST_URI'],'rs_reset_password') ||
	strpos($_SERVER['REQUEST_URI'],'check_student_token') || 
	strpos($_SERVER['REQUEST_URI'],'come-onboard') ||
	strpos($_SERVER['REQUEST_URI'],'save_other_cal') || 
	strpos($_SERVER['REQUEST_URI'],'opr_') ||
	isset($_REQUEST["just_coming"])))
{
	/*if (!isset($_REQUEST['ilin']) || (isset($_REQUEST['ilin']) && $_REQUEST['ilin'] == ''))
	{
		header('Location: ../');
	}
	
	if (isset($_REQUEST['logout']))
	{
	    eexit();
		header('Location: ../');
	}*/
	
	if (session_timer() == 0)
	{
		header('Location: ../');
	}
}

date_default_timezone_set('Africa/Lagos');

define("study_mode", "odl");

function err_box($msg)
{
	if ($msg == ''){return;}?>
	<div id="err_box"><?php echo $msg ?></div><?php
}


function eyes_pilled($val)
{
    return 1;
}


function session_timer()
{	
	$user_name = '';

	if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] <> '')
	{
		if ($_REQUEST["user_cat"] == '3' || $_REQUEST["user_cat"] == '6')
		{
			if (isset($_REQUEST["vApplicationNo"]) && $_REQUEST['vApplicationNo'] <> '')
			{
				$user_name = $_REQUEST['vApplicationNo'];
			}else
			{
				return 0;
			}
		}else if ($_REQUEST["user_cat"] == '5')
		{
			if (isset($_REQUEST["vMatricNo"]) && $_REQUEST['vMatricNo'] <> '')
			{
				$user_name = $_REQUEST['vMatricNo'];
			}else
			{
				return 0;
			}
		}
	}else
	{
		return 0;
	}
	
	if ($user_name <> '')
	{
		date_default_timezone_set('Africa/Lagos');
		$date2 = date("Y-m-d h:i:s");
		$date3 = date("Y-m-d");
		$today = getdate();
		$min = ($today['hours'] * 60) + $today['minutes'];
		
		$mysqli = link_connect_db();
		
		$stmt = $mysqli->prepare("SELECT ilin FROM ses_tab
		WHERE vApplicationNo = ? AND dtl_date = '$date3'");
		$stmt->bind_param("s", $user_name);

		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows == 0)
		{
			$stmt->close();
			return 0;
		}else
		{			
			$stmt->bind_result($ilin);
			$stmt->fetch();
			$stmt->close();

			$ilin = $ilin ?? '';
			
			if ($_REQUEST['ilin'] <> hash('sha512', $ilin))
			{
				$stmt_d = $mysqli->prepare("DELETE FROM ses_tab WHERE vApplicationNo = ?");
				$stmt_d->bind_param("s", $user_name);
				$stmt_d->execute();
				$stmt_d->close();

				return 0;
			}
		}
		
		$stmt = $mysqli->prepare("SELECT TIMESTAMPDIFF(MINUTE,time_stamp,'$date2') FROM ses_tab WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $user_name);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($time_stamp);
		$stmt->fetch();
		$stmt->close();
		
		$orgsetins = settns();
		
		// $date1 = strtotime($time_stamp); 
		// $date3 = strtotime($date2); 
		// $diff = abs($date3 - $date1);
		// $years = floor($diff / (365*60*60*24));
		// $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		// $days = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24) / (60*60*24));
		// $hours = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24 - $days * 60*60*24) / (60*60));
		// $min = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24 - $days * 60*60*24 - $hours * 60*60) / 60);
		
		if ($time_stamp > $orgsetins["tIdl_time"])
		//if ($min > $orgsetins["tIdl_time"])
		{
			$stmt = $mysqli->prepare("DELETE FROM ses_tab WHERE vApplicationNo = ?");
			$stmt->bind_param("s", $user_name);
			$stmt->execute();
			$stmt->close();
			
			return 0;
		}else
		{
			$stmt = $mysqli->prepare("UPDATE ses_tab
			SET time_stamp = '$date2'
			WHERE vApplicationNo = ?");
			$stmt->bind_param("s", $user_name);
			$stmt->execute();
			$stmt->close();
		}
	}else if (isset($_REQUEST['justcomin']) && $_REQUEST['justcomin'] == '1'){
		return '1';	
	}
	return '1';
}


function eexit()
{
	$user_cat = '';
	if ($_REQUEST['user_cat'] == '4' || $_REQUEST['user_cat'] == '5')
	{
		$user_cat = $_REQUEST['vMatricNo'];
	}else
	{
		$user_cat = $_REQUEST['vApplicationNo'];
	}
	
	$mysqli = link_connect_db();
	$stmt = $mysqli->prepare("DELETE FROM ses_tab WHERE vApplicationNo = ?");
	$stmt->bind_param("s", $user_cat);
	$stmt->execute();
	$stmt->close();
	
	date_default_timezone_set('Africa/Lagos');
	$date2 = date("Y-m-d h:i:s");

	$stmt = $mysqli->prepare("DELETE FROM ses_tab WHERE TIMESTAMPDIFF(MINUTE,time_stamp,'$date2') >= 60");
	$stmt->execute();
	$stmt->close();

}


function log_actv($vDeed)
{
	$mysqli = link_connect_db();
	
	$val_field = '';
	if (isset($_REQUEST['user_cat']))
	{
		if ($_REQUEST['user_cat'] == '4' || $_REQUEST['user_cat'] == '5')
		{
			if (isset($_REQUEST['vMatricNo'])){$val_field = $_REQUEST['vMatricNo'];}
		}else if (isset($_REQUEST["uvApplicationNo04"]))
		{
			$val_field = $_REQUEST['uvApplicationNo04'];
		}else if (isset($_REQUEST["vApplicationNo"]))
		{
			$val_field = $_REQUEST['vApplicationNo'];
		}
	}
		
	if ($val_field == ''){return;}
	
	$mysqli = link_connect_db();
	
	$ipee = getIPAddress();
		
	date_default_timezone_set('Africa/Lagos');
    $date2 = date("Y-m-d h:i:s");

	$stmt = $mysqli->prepare("insert into atv_log  set 
	vApplicationNo  = ?,
	vDeed = ?,
	act_location = ?,
	tDeedTime = '$date2'");
	$stmt->bind_param("sss", $val_field, $vDeed, $ipee);
	$stmt->execute();
	
	$stmt->close();
	
	// $stmt = $mysqli->prepare("SELECT tDeedTime FROM atv_log where vApplicationNo = ? order by tDeedTime desc limit 1");
	// $stmt->bind_param("s",$val_field);
	// $stmt->execute();
	// $stmt->store_result();
	// $stmt->bind_result($tDeedTime);
	// $stmt->fetch();
	// $stmt->close();
	// return $tDeedTime;
}


function getIPAddress()
{
	if(!empty($_SERVER['HTTP_CLIENT_IP'])) //whether ip is from the share internet
	{
		return $_SERVER['HTTP_CLIENT_IP'];  
	}else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) //whether ip is from the proxy
	{  
        return $_SERVER['HTTP_X_FORWARDED_FOR'];  
	}else//whether ip is from the remote address
	{  
		return $_SERVER['REMOTE_ADDR'];  
     } 
}



function settns()
{
	$rssqlsettns = mysqli_query(link_connect_db(), "SELECT * FROM settns") or die(mysqli_error(link_connect_db()));	
	return mysqli_fetch_array($rssqlsettns);
}


function formatdate($date,$dir)
{
	if ($dir == 'fromdb')
	{
		if ($date == ''){return '00-00-0000';}
		return substr($date,8,2) . '-' . substr($date,5,2) . '-' . substr($date,0,4);
	}else if ($dir == 'todb')
	{
		if ($date == ''){return '0000-00-00';}
		return substr($date,6,4) . '-' . substr($date,3,2) . '-' . substr($date,0,2);
	}
}


/*function alloc_dum_pin($rrr)
{
	$mysqli = link_connect_db();
	
	$next_afn = '';
	$afn_prefix = '';

	$afn_prefix = date("y");
	$stmt = $mysqli->prepare("SELECT CONCAT('$afn_prefix',RIGHT(MAX(RIGHT(Regno,5)), 5)+1) FROM `remitapayments` WHERE Regno LIKE '$afn_prefix%';");
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($next_afn);
	$stmt->fetch();
	$stmt->close();
	
	$next_afn = $next_afn ?? '';

	if ($next_afn == '')
	{
		$next_afn = $afn_prefix."10000";
	}

	try
	{
		$mysqli->autocommit(FALSE); //turn on transactions
		
		$stmt = $mysqli->prepare("UPDATE remitapayments SET Regno = '$next_afn' WHERE RetrievalReferenceNumber = ? AND Regno = ''");	
		$stmt->bind_param("s", $rrr);
		$stmt->execute();		
		$stmt->close();

		$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
		
		return $next_afn;
	}catch(Exception $e) 
	{
		$mysqli->rollback(); //remove all queries from queue if error (undo)
		throw $e;
	}
}*/


function admin_frms()
{?>
	<form action="home-page" method="post" name="hpg" enctype="multipart/form-data">
		<input name="uvApplicationNo" type="hidden" value="" />
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"])){echo $_REQUEST["vMatricNo"];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="logout" type="hidden" value="1" />
	</form>
	<form action="staff_login_page" method="post" name="pass1" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"])){echo $_REQUEST["vMatricNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="currency" id="currency" type="hidden" value="<?php if (isset($_REQUEST["currency"])){echo $_REQUEST["currency"];} ?>" />
		<input name="tpreg" type="hidden" value="<?php if (isset($_REQUEST["tpreg"])){echo $_REQUEST["tpreg"];}?>" />
		<input name="loggedout" id="loggedout" type="hidden" value="0" />
		<input name="logout" type="hidden" value="1" />
	</form>
	<form action="open-to-enter" method="post" name="pass" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"])){echo $_REQUEST["vMatricNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="recova" id="recova" type="hidden" value="<?php if (isset($_REQUEST['recova'])){echo $_REQUEST['recova'];} ?>" />
		<input name="tpreg" type="hidden" value="<?php if (isset($_REQUEST["tpreg"])){echo $_REQUEST["tpreg"];}?>" />
	</form>
	<form action="attend-to-students" method="post" name="cf" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
		

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />

		<input name="study_mode" id="study_mode" type="hidden" value="odl">

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($service_mode)){echo $service_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($service_centre)){echo $service_centre;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
		
		<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
	</form>
	<form action="student-academic-history" method="post" name="std_acad_hist" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
				

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />

		<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
	</form>
	<form action="student-transactions" method="post" name="vw_std_acnt_stff" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
		
		<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
	</form>
	<form action="manage-academic-units" method="post" name="setup_facult" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>
	<form action="registration-module-one" method="post" name="reg_grp1" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
		
		<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
	</form>
	<form action="registration-module-one-one" method="post" name="reg_grp1_1" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
		
		<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
	</form>
	<form action="reformatory-facility" method="post" name="rectional" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>
	
	<form action="send_message_to_student" method="post" name="student_msg" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>

	<form action="student-collections" method="post" name="f_account" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>
	

	<form action="student-clearance" method="post" name="clearance" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>

	<form action="rect-rrr" method="post" name="rect_payment" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>

	<form action="create_new_student_balances" method="post" name="student_balances" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>


	<form action="gown_refund" method="post" name="gown_ref" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>

	<form action="set-options" method="post" name="opsions" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>
	

	<form action="reactivate_application" method="post" name="recall_appl" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>
	
	<form action="varify-payment" method="post" name="chk_pay_sta" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
		
		<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
	</form>
	<form action="see-student-registrations" method="post" name="std_reg_hist" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
		
		<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
	</form>
	
	<form action="reverse-transaction" method="post" name="rev_sactn" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>
	<form action="adjust_student-balance" method="post" name="adj_bal" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="uvApplicationNo_1" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo_1"])){echo $_REQUEST["uvApplicationNo_1"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>
	<form action="b-report" method="post" name="b_report" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="uvApplicationNo_1" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo_1"])){echo $_REQUEST["uvApplicationNo_1"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>
	<form action="student-store-items" method="post" name="selitems" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="uvApplicationNo_1" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo_1"])){echo $_REQUEST["uvApplicationNo_1"];} ?>" />
		
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		
		<input name="study_mode0" id="study_mode0" type="hidden" value="<?php if (isset($_REQUEST['study_mode0'])){echo $_REQUEST['study_mode0'];} ?>" />
		<input name="study_center_loc0" id="study_center_loc0" type="hidden" value="<?php if (isset($_REQUEST['study_center_loc0'])){echo $_REQUEST['study_center_loc0'];} ?>" />
		
		<input name="cFacultyId_loc_0" id="cFacultyId_loc_0" type="hidden" value="<?php if (isset($_REQUEST['cFacultyId_loc_0'])){echo $_REQUEST['cFacultyId_loc_0'];} ?>" />
		
		<input name="cFacultyId_desc_loc_0" id="cFacultyId_desc_loc_0" type="hidden" value="<?php if (isset($_REQUEST['cFacultyId_desc_loc_0'])&&$_REQUEST['cFacultyId_desc_loc_0']<>''){echo $_REQUEST['cFacultyId_desc_loc_0'];} ?>" />

		<input name="cEduCtgId_loc_0" id="cEduCtgId_loc_0" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId_loc_0'])){echo $_REQUEST['cEduCtgId_loc_0'];} ?>" />

		<input name="show_all_burs" id="show_all_burs" type="hidden" value="<?php if (isset($_REQUEST['show_all_burs'])){echo $_REQUEST['show_all_burs'];}else{echo '1';} ?>" />
		
		<input name="new_old_structure_h" id="new_old_structure_h" type="hidden" 
            value="<?php if (isset($_REQUEST['new_old_structure_h']) && $_REQUEST['new_old_structure_h'] <> ''){echo $_REQUEST['new_old_structure_h'];}?>" />

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>
	<form action="check-student-status" method="post" name="std_stat" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
		
		<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
	</form>
	<form action="off_line_request" method="post" name="vc_request" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>
	
	<form action="scholarship_admission" method="post" name="skolasip" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>

	
	<form action="exit_all_current_users" method="post" name="l_all_user" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>

	<form action="manage-study-centres" method="post" name="study_cnetre" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>

	<form action="manage-inmates" method="post" name="mgt_inmates" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
		
		<input name="whattodo" id="whattodo" type="hidden"  value="<?php if (isset($_REQUEST["whattodo"])){echo $_REQUEST["whattodo"];}; ?>"/>
	</form>	

	<form action="manage-access" method="post" name="enq_pwd" enctype="multipart/form-data">
		<?php loc_frm_vars()?>
		<input name="whattodo" id="whattodo" type="hidden"  value="<?php if (isset($_REQUEST["whattodo"])){echo $_REQUEST["whattodo"];}; ?>"/>
	</form>

	

	<form action="manage-user" method="post" name="manag" enctype="multipart/form-data">
		<?php loc_frm_vars()?>
	</form>

	<form action="manage_user_password" method="post" name="manag_user_acc" enctype="multipart/form-data">
		<?php loc_frm_vars()?>
	</form>
	<form action="see-admission-criteria" method="post" name="crtrpt" enctype="multipart/form-data">
		<?php loc_frm_vars()?>
	</form>	
	
	<form action="un_arcive" method="post" name="unarch" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>

	<form action="student-requests" method="post" name="sc_1" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />

		<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>

	</form>
	<form action="pw.php" method="post" name="pw" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
		<input name="m" type="hidden" value="2" />
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>
	<form action="upw.php" method="post" name="upw" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>
	<form action="manage-result" method="post" name="result_stff" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>
	<form action="admcrit.php" method="post" name="admcrit" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="m" type="hidden" value="4" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">	

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>
	<form action="generate-reports" method="post" name="rpts1" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>
	<form action="ac.php" method="post" name="ac" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="m" type="hidden" value="0" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>
	
	<form action="settma.php" method="post" name="settma" enctype="multipart/form-data">
		<?php frm_vars();?>
		<input name="cCourseCode" id="cCourseCode" type="hidden" value="<?php if (isset($_REQUEST['cCourseCode'])){echo $_REQUEST['cCourseCode'];} ?>" />
		<input name="cCourseCodeDesc" id="cCourseCodeDesc" type="hidden" value="<?php if (isset($_REQUEST['cCourseCodeDesc'])){echo $_REQUEST['cCourseCodeDesc'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">	

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>
	<form action="programs-by-category" method="post" name="pgprgs" enctype="multipart/form-data"><?php frm_vars();?></form>
	<form action="verify-admission" method="post" name="gln" enctype="multipart/form-data"><?php frm_vars();?></form>
	
	<form action="stff-guides-instructions" method="post" id="stff_guide_instr" name="stff_guide_instr" target="_blank" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="6" />
		<input name="hlp" type="hidden" value="1" />
	</form>
	
	<form action="manage_pg_students" method="post" name="pg_environ" id="pg_environ" enctype="multipart/form-data">
		<input name="uvApplicationNo" id="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['uvApplicationNo'])){echo $_REQUEST['uvApplicationNo'];} ?>" />
		<input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
		<input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST['vMatricNo'])){echo $_REQUEST['vMatricNo']; }?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="currency" id="currency" type="hidden" value="<?php if (isset($_REQUEST["currency"])){echo $_REQUEST["currency"];} ?>" />
		<input name="mm" id="mm" type="hidden" value="<?php if (isset($_REQUEST["mm"])){echo $_REQUEST["mm"];} ?>" />
		<input name="sm" id="sm" type="hidden" value="<?php if (isset($_REQUEST["sm"])){echo $_REQUEST["sm"];} ?>" />
		<input name="contactus" id="contactus" type="hidden" />
		<input name="what" id="what" type="hidden" />

		<input name="conf" id="conf" type="hidden" />
		<input name="conf2" id="conf2" type="hidden" />
		<input name="del" id="del" type="hidden" />
		<input name="edit" id="edit" type="hidden" />
		
		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($service_mode)&&$service_mode<>''){echo $service_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($service_centre)&&$service_centre<>''){echo $service_centre;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
		
		<input name="facul" id="facul" type="hidden" value="<?php if (isset($_REQUEST["facul"])){echo $_REQUEST["facul"];} ?>" />
		
		<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
	</form>
	
	
	
	<form action="adjust.php" method="post" name="adjust" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
		
		<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
	</form>
	
	
	
	<form action="anavail.php" method="post" name="anavail" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">			

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
		
		<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
	</form>	

	<form action="adjust_opening_balance" method="post" name="opn_bal" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
		
		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form>	

	<form action="rpt_page_1" method="post" name="rpt_1" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
			
		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />

		<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
		<input name="whattodo" id="whattodo" type="hidden" value="<?php if(isset($_REQUEST['whattodo'])){echo $_REQUEST['whattodo'];}else{echo '';}?>" />
	</form><?php
}


function loc_frm_vars()
{?>
	<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
	<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
	<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
	<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
	<input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
	<input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
	<input name="study_mode" id="study_mode" type="hidden" value="odl">
		
	<input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />	

	<input name="service_mode" id="service_mode" type="hidden" 
	value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
	else if (isset($service_mode)){echo $service_mode;}?>" />

	<input name="num_of_mode" id="num_of_mode" type="hidden" 
	value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
	else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

	<input name="user_centre" id="user_centre" type="hidden" 
	value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
	else if (isset($service_centre)){echo $service_centre;}?>" />

	<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
	value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
	else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" /><?php
}


function frm_vars()
{?>
	<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
	<input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
	<input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
	<input name="tDeedTime" type="hidden" value="<?php if (isset($_REQUEST['tDeedTime'])){echo $_REQUEST['tDeedTime'];}?>" />
	<input name="cFacultyId" id="cFacultyId" type="hidden" value="<?php if (isset($_REQUEST['cFacultyId'])){echo $_REQUEST['cFacultyId'];} ?>" />
	<input name="cdept" id="cdept" type="hidden" value="<?php if (isset($_REQUEST['cdept'])){echo $_REQUEST['cdept'];} ?>" />
	<input name="vFacultyDesc" id="vFacultyDesc" type="hidden" value="<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];} ?>" />
	<input name="vdeptDesc" id="vdeptDesc" type="hidden" value="<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>" />
	<input name="vObtQualTitle" id="vObtQualTitle" type="hidden" value="<?php if (isset($_REQUEST['vObtQualTitle'])){echo $_REQUEST['vObtQualTitle'];} ?>" />
	
	<input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId']) && $_REQUEST['cEduCtgId'] <> ''){echo $_REQUEST['cEduCtgId'];}else if (isset($GLOBALS['cEduCtgId_loc'])){echo $GLOBALS['cEduCtgId_loc'];} ?>" />
	<input name="vEduCtgDesc" id="vEduCtgDesc" type="hidden" value="<?php if (isset($_REQUEST['vEduCtgDesc'])){echo $_REQUEST['vEduCtgDesc'];} ?>" />
	
	<input name="cEduCtgId_1" id="cEduCtgId_1" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId_1'])){echo $_REQUEST['cEduCtgId_1'];} ?>" />
	<input name="cEduCtgId_2" id="cEduCtgId_2" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId_2'])){echo $_REQUEST['cEduCtgId_2'];} ?>" />
	
	<input name="cEduCtgId_selected_qual" id="cEduCtgId_selected_qual" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId_selected_qual'])){echo $_REQUEST['cEduCtgId_selected_qual'];} ?>" />
	
	<input name="cQualCodeId" id="cQualCodeId" type="hidden" value="<?php if (isset($_REQUEST['cQualCodeId'])){echo $_REQUEST['cQualCodeId'];} ?>" />
	<input name="vQualCodeDesc" id="vQualCodeDesc" type="hidden" value="<?php if (isset($_REQUEST['vQualCodeDesc'])){echo $_REQUEST['vQualCodeDesc'];} ?>" />
	
	<input name="prog_cat" id="prog_cat" type="hidden" value="<?php if (isset($_REQUEST['prog_cat'])){echo $_REQUEST['prog_cat'];} ?>" />
	<input name="cProgrammeId" id="cProgrammeId" type="hidden" value="<?php if (isset($_REQUEST['cProgrammeId'])){echo $_REQUEST['cProgrammeId'];} ?>" />
	<input name="vProgrammeDesc" type="hidden" value="<?php if (isset($_REQUEST['vProgrammeDesc'])){echo $_REQUEST['vProgrammeDesc'];} ?>" />
	<input name="begin_level" type="hidden" value="<?php if (isset($_REQUEST['begin_level'])){echo $_REQUEST['begin_level'];} ?>" />
	
	<input name="vReqmtDesc" id="vReqmtDesc" type="hidden" value="<?php if (isset($_REQUEST['vReqmtDesc'])){echo $_REQUEST['vReqmtDesc'];} ?>" />
	<input name="sReqmtId" id="sReqmtId" type="hidden" value="<?php if (isset($_REQUEST['sReqmtId'])){echo $_REQUEST['sReqmtId'];} ?>" />
	<input name="criteriaqualId" id="criteriaqualId" type="hidden" value="<?php if (isset($_REQUEST['criteriaqualId'])){echo $_REQUEST['criteriaqualId'];}?>" />
		
	<input name="iBeginLevel" type="hidden" value="<?php if (isset($_REQUEST['iBeginLevel'])){echo $_REQUEST['iBeginLevel'];} ?>" />
	
	<input name="iMinItemCount" id="iMinItemCount" type="hidden" value="<?php if (isset($_REQUEST['iMinItemCount'])){echo $_REQUEST['iMinItemCount'];} ?>" />
	<input name="iMaxSittingCount" id="iMaxSittingCount" type="hidden" value="<?php if (isset($_REQUEST['iMaxSittingCount'])){echo $_REQUEST['iMaxSittingCount'];} ?>" />
	<input name="iQSLCount" id="iQSLCount" type="hidden" value="<?php if (isset($_REQUEST['iQSLCount'])){echo $_REQUEST['iQSLCount'];} ?>" />
	
	<input name="used_admitted" id="used_admitted" type="hidden" value="" />

	<input name="clk" type="hidden" value="0" />
	
	<input name="es" id="es" type="hidden" value="<?php if (isset($_REQUEST['es'])){echo $_REQUEST['es'];} ?>" />
	<input name="as" id="as" type="hidden" value="<?php if (isset($_REQUEST['as'])){echo $_REQUEST['as'];} ?>" />
	<input name="ds" id="ds" type="hidden" value="<?php if (isset($_REQUEST['ds'])){echo $_REQUEST['ds'];} ?>" />
	<input name="dc" id="dc" type="hidden" value="<?php if (isset($_REQUEST['dc'])){echo $_REQUEST['dc'];} ?>" />
	<input name="das" id="das" type="hidden" value="<?php if (isset($_REQUEST['das'])){echo $_REQUEST['das'];} ?>" />
	
	<input name="ec" id="ec" type="hidden" value="<?php if (isset($_REQUEST['ec'])){echo $_REQUEST['ec'];} ?>" />
	<input name="ac" id="ac" type="hidden" value="<?php if (isset($_REQUEST['ac'])){echo $_REQUEST['ac'];} ?>" />
	
	<input name="eq" id="eq" type="hidden" value="<?php if (isset($_REQUEST['eq'])){echo $_REQUEST['eq'];} ?>" />
	<input name="aq" id="aq" type="hidden" value="<?php if (isset($_REQUEST['aq'])){echo $_REQUEST['aq'];} ?>" />
	<input name="dq" id="dq" type="hidden" value="<?php if (isset($_REQUEST['dq'])){echo $_REQUEST['dq'];} ?>" />
	
	<input name="m" type="hidden" value="<?php if (isset($_REQUEST['m'])){echo $_REQUEST['m'];} ?>" />

	<input name="mm" id="mm" type="hidden" value="<?php if (isset($_REQUEST["mm"])){echo $_REQUEST["mm"];} ?>" />
	<input name="mm_desc" id="mm_desc" type="hidden" value="<?php if (isset($_REQUEST["mm_desc"])){echo $_REQUEST["mm_desc"];} ?>" />
	<input name="sm" id="sm" type="hidden" value="<?php if (isset($_REQUEST["sm"])){echo $_REQUEST["sm"];} ?>" />
	<input name="sm_desc" id="sm_desc" type="hidden" value="<?php if (isset($_REQUEST["sm_desc"])){echo $_REQUEST["sm_desc"];} ?>" />
	
	<input name="dis" type="hidden" value="<?php if (isset($_REQUEST['dis'])){echo $_REQUEST['dis'];} ?>" />
	<input name="en" type="hidden" value="<?php if (isset($_REQUEST['en'])){echo $_REQUEST['en'];} ?>" />
	
	<input name="sbjlist" type="hidden" />
	<input name="conf" id="conf" type="hidden" />
	<input name="admt" id="admt" type="hidden" />
	<input name="conf_g" id="conf_g" type="hidden" value="" />
		
	<input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />	
	
	<input name="service_mode" id="service_mode" type="hidden" 
	value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
	else if (isset($service_mode)){echo $service_mode;}?>" />

	<input name="num_of_mode" id="num_of_mode" type="hidden" 
	value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
	else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

	<input name="user_centre" id="user_centre" type="hidden" 
	value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
	else if (isset($service_centre)){echo $service_centre;}?>" />

	<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
	value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
	else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" /><?php
}


function nav_frm()
{?>
	<form action="programs-by-category" method="post" name="pgprgs1" enctype="multipart/form-data"><?php frm_vars();?></form>
	<form action="edit-criterion" method="post" name="e_crit1" enctype="multipart/form-data"><?php frm_vars();?></form>
	<form action="add-edit-criterion" method="post" name="n_crit1" enctype="multipart/form-data"><?php frm_vars();?></form>
	<form action="edit_qualification" method="post" name="e_qual1" enctype="multipart/form-data"><?php frm_vars();?></form><?php
}


function nav_text($sm)
{
	if ($sm == 1){echo 'New criterion' ;}
	elseif ($sm == 2){echo 'Edit criterion' ;}
	elseif ($sm == 3){echo 'Disable/enable criterion' ;}
	elseif ($sm == 4){echo 'Verify/Glean admission' ;}
	elseif ($sm == 12){echo 'Management Assessement' ;}
	else{echo 'Delete criterion' ;}	
}


function stdnt_name()
{
	$vApplicationNo = '';
    if (isset($_REQUEST["uvApplicationNo"])){$vApplicationNo = $_REQUEST["uvApplicationNo"];}elseif (isset($_REQUEST["vApplicationNo"])){$vApplicationNo = $_REQUEST["vApplicationNo"];}
	
	$mysqli = link_connect_db();
	$stmt = $mysqli->prepare("select vLastName,vFirstName,vOtherName from prog_choice where vApplicationNo = ?");
	$stmt->bind_param("s",$vApplicationNo);
	$stmt->execute();
	$stmt->store_result();
	
	if ($stmt->num_rows > 0)
	{		
		$stmt->bind_result($vLastName, $vFirstName, $vOtherName);
		$stmt->fetch();
		$namess = $vApplicationNo.'<br>'.strtoupper($vLastName).'<br>'.ucwords(strtolower($vFirstName)).'<br>'.ucwords(strtolower($vOtherName));
		
		$stmt->close();
		return $namess;
	}else
	{
		return '';
	}
}


function tab_addr()
{?>
	<form action="appl-biodata" method="post" name="ts1" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
		<input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php if (isset($_REQUEST["passpotLoaded"])){echo $_REQUEST["passpotLoaded"];}?>">
		<input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>" />
		<input name="tpreg" type="hidden" value="<?php if (isset($_REQUEST["tpreg"])){echo $_REQUEST["tpreg"];}?>" />
	</form>
	<form action="postal-address" method="post" name="ts2" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
		<input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php if (isset($_REQUEST["passpotLoaded"])){echo $_REQUEST["passpotLoaded"];}?>">
		<input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>" />
		<input name="tpreg" type="hidden" value="<?php if (isset($_REQUEST["tpreg"])){echo $_REQUEST["tpreg"];}?>" />
	</form>
	<form action="residential-address" method="post" name="ts3" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
		<input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php if (isset($_REQUEST["passpotLoaded"])){echo $_REQUEST["passpotLoaded"];}?>">
		<input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>" />
		<input name="tpreg" type="hidden" value="<?php if (isset($_REQUEST["tpreg"])){echo $_REQUEST["tpreg"];}?>" />
	</form>
	<form action="next-of-kin" method="post" name="ts4" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
		<input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php if (isset($_REQUEST["passpotLoaded"])){echo $_REQUEST["passpotLoaded"];}?>">
		<input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>" />
		<input name="tpreg" type="hidden" value="<?php if (isset($_REQUEST["tpreg"])){echo $_REQUEST["tpreg"];}?>" />
	</form>
	<form action="academic-history" method="post" name="ts5" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
		<input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php if (isset($_REQUEST["passpotLoaded"])){echo $_REQUEST["passpotLoaded"];}?>">
		<input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>" />
		<input name="tpreg" type="hidden" value="<?php if (isset($_REQUEST["tpreg"])){echo $_REQUEST["tpreg"];}?>" />
		<input name="more_qual" id="more_qual" type="hidden" value="" />
	</form>
	<form action="programme-of-choice" method="post" name="ts6" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
		<input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php if (isset($_REQUEST["passpotLoaded"])){echo $_REQUEST["passpotLoaded"];}?>">
		<input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>" />
		<input name="tpreg" type="hidden" value="<?php if (isset($_REQUEST["tpreg"])){echo $_REQUEST["tpreg"];}?>" />
	</form>
	<form action="preview-form" method="post" name="ts8" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
		<input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php echo $_REQUEST['passpotLoaded'];?>">
		<input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>" />
		<input name="tpreg" type="hidden" value="<?php if (isset($_REQUEST["tpreg"])){echo $_REQUEST["tpreg"];}?>" />
	</form>
	<form action="congrat-cont" method="post" name="ts10" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="frm_prv" type="hidden" value="<?php if (isset($_REQUEST['frm_prv'])){echo $_REQUEST['frm_prv'];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
		<input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php if (isset($_REQUEST["passpotLoaded"])){echo $_REQUEST["passpotLoaded"];}?>">
		<input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>" />
		<input name="tpreg" type="hidden" value="<?php if (isset($_REQUEST["tpreg"])){echo $_REQUEST["tpreg"];}?>" />
	</form>	
	<form action="applicant-starting-page" method="post" name="std_hpg" id="std_hpg" enctype="multipart/form-data">
		<input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="currency" id="currency" type="hidden" value="<?php if (isset($_REQUEST['currency'])){echo $_REQUEST['currency'];} ?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="odl">
		<input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php if (isset($_REQUEST["passpotLoaded"])){echo $_REQUEST["passpotLoaded"];}?>">
		<input name="tpreg" type="hidden" value="<?php if (isset($_REQUEST["tpreg"])){echo $_REQUEST["tpreg"];}?>" />
	</form><?php
}


function gaurd_seq($val)
{
	if (!isset($_REQUEST["vApplicationNo"])){return;}
    
	$num_of_rows = 1;
	$mysqli = link_connect_db();
	
	/*if ($val > 7)
	{
		$stmt = $mysqli->prepare("select * from prog_choice where vApplicationNo = ?");
	}else*/ if ($val > 5)
	{
		$stmt = $mysqli->prepare("SELECT * FROM applyqual WHERE vApplicationNo = ? AND cQualCodeId NOT IN (SELECT cQualCodeId FROM applysubject  WHERE vApplicationNo = ?)");
	}else /*if ($val > 5)
	{	
		$stmt = $mysqli->prepare("select * from applyqual where vApplicationNo = ?");
	}else*/ if ($val > 4)
	{		
		$stmt = $mysqli->prepare("select * from nextofkin where vApplicationNo = ?");
	}else if ($val > 3)
	{		
		$stmt = $mysqli->prepare("select * from res_addr where vApplicationNo = ?");
	}else if ($val > 2)
	{
		$stmt = $mysqli->prepare("select * from post_addr where vApplicationNo = ?");
	}else if ($val > 1)
	{
		$stmt = $mysqli->prepare("select * from pers_info where vApplicationNo = ?");
	}
	
	if (isset($stmt))
	{
		if ($val > 5)
		{
			$stmt->bind_param("ss",$_REQUEST["vApplicationNo"], $_REQUEST["vApplicationNo"]);
		}else
		{
			$stmt->bind_param("s",$_REQUEST["vApplicationNo"]);
		}
		$stmt->execute();
		$stmt->store_result();
		$num_of_rows = $stmt->num_rows;
		$stmt->close();
	}

	if ($num_of_rows > 1)
	{
		if ($val > 5)
		{
			return '-1';
		}
		return 1;
	}else if ($val > 5)
	{
		$stmt = $mysqli->prepare("select * from applysubject where vApplicationNo = ?");
		$stmt->bind_param("s",$_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->store_result();
		$num_of_rows = $stmt->num_rows;
		$stmt->close();
		return $num_of_rows;
	}else
	{
		return $num_of_rows;
	}	
}


function stbmt_sta($val)
{	
	$mysqli = link_connect_db();
	
	if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '')
	{
		$stmt = $mysqli->prepare("select cSCrnd,cqualfd,cSbmtd,iprnltr from prog_choice where vApplicationNo = ?");
		$stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
	}else if (isset($_REQUEST["vApplicationNo"]) && $_REQUEST["vApplicationNo"] <> '')
	{
		$stmt = $mysqli->prepare("select cSCrnd,cqualfd,cSbmtd,iprnltr from prog_choice where vApplicationNo = ?");
		$stmt->bind_param("s",$_REQUEST["vApplicationNo"]);
	}else if (isset($_REQUEST["uvApplicationNo11"]) && $_REQUEST["uvApplicationNo11"] <> '')
	{
		$stmt = $mysqli->prepare("select cSCrnd,cqualfd,cSbmtd,iprnltr from prog_choice where vApplicationNo = ?");
		$stmt->bind_param("s",$_REQUEST["uvApplicationNo11"]);
	}
	
	if (isset($stmt))
	{
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($cSCrnd, $cqualfd, $cSbmtd, $iprnltr);
		
		if ($stmt->num_rows > 0)
		{
			$stmt->fetch();
			$stmt->close();
			if ($val == 0)
			{
				return $cSCrnd;
			}else if ($val == 1)
			{
				return $cqualfd;
			}else if ($val == 2)
			{
				return $cSbmtd;
			}else if ($val == 3)
			{
				return $iprnltr;
			}
		}else
		{
			$stmt->close();
		
			$stmt = $mysqli->prepare("select vApplicationNo from app_client where vApplicationNo = ?");
			$stmt->bind_param("s",$_REQUEST["vApplicationNo"]);
			$stmt->execute();
			$stmt->store_result();
			if ($stmt->num_rows > 0)
			{
				$stmt->close();
				return '0';
			}

			if (isset($_REQUEST['tpreg']) && $_REQUEST['tpreg'] == '1')
			{
				return '0';
			}
		}
	}	
	return '';
}


function send_app_alert()
{
	date_default_timezone_set('Africa/Lagos');

	$mysqli = link_connect_db();

	$stmt = $mysqli->prepare("SELECT MIN(CONVERT(LEFT(LPAD(TIMEDIFF(NOW(), tDeedTime),9,'0'), 3), UNSIGNED)) 
	FROM atv_log
	WHERE vDeed LIKE 'Sent summary of application%' ORDER BY tDeedTime");

	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($elapsed_time);
	$stmt->fetch();

	if (is_numeric($elapsed_time) && $elapsed_time < 336)
	{
		$stmt->close();
		return;
	}

    include('../../PHPMailer/mail_con.php');
	
	$stmt = $mysqli->prepare("SELECT * FROM remitapayments_app WHERE Status = 'Pending' and vDesc = 'Application Fee'");
	$stmt->execute();
	$stmt->store_result();
	$to_finilize_pay = $stmt->num_rows;

	$stmt = $mysqli->prepare("SELECT * FROM remitapayments_app WHERE (ResponseCode = '00' or ResponseCode = '01') and vDesc = 'Application Fee'");
	$stmt->execute();
	$stmt->store_result();
	$has_finilize_pay = $stmt->num_rows;

	$stmt = $mysqli->prepare("SELECT * FROM prog_choice WHERE `cSbmtd` = '0' AND vApplicationNo <> ''");
	$stmt->execute();
	$stmt->store_result();
	$to_submit = $stmt->num_rows;

	$stmt = $mysqli->prepare("SELECT * FROM prog_choice WHERE `cSbmtd` = '1'");
	$stmt->execute();
	$stmt->store_result();
	$has_submitted = $stmt->num_rows;

	$stmt = $mysqli->prepare("SELECT * FROM prog_choice WHERE `cSbmtd` = '2'");
	$stmt->execute();
	$stmt->store_result();
	$has_cleared = $stmt->num_rows;
	
	$vEMailId = 'phadamoses@gmail.com';
	
	$subject = 'NOUN Application Update';
	$mail_msg = "Vice Chancellor sir,<br><br>Subject mater refers.
	<p>Yet to finalize payment process: ".number_format($to_finilize_pay, 0, '.', ',').
	"<p>Completed payment process: ".number_format($has_finilize_pay, 0, '.', ','). 
	"<p>Yet to submit form: ".number_format($to_submit, 0, '.', ',').
	"<p>Submitted form: ".number_format($has_submitted, 0, '.', ',').
	"<p>Cleared: ".number_format($has_cleared, 0, '.', ',').
	"<p><i>This mail is auto-generated and cannot be replied</i><br><br>
	Thank you.";

	$mail_msg = wordwrap($mail_msg, 70);
	$date2 = date("Y-m-d h:i:s");
	
	$mail->addAddress($vEMailId, ''); // Add a recipient

	$mail->addCC('aadeboyejo@noun.edu.ng');

	$mail->Subject = $subject;
	$mail->Body = $mail_msg;

	for ($looop = 1; $looop <= 5; $looop++)
	{
		if ($mail->send())
		{
			if(!empty($_SERVER['HTTP_CLIENT_IP'])) //whether ip is from the share internet
			{
				$ipee = $_SERVER['HTTP_CLIENT_IP'];  
			}else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) //whether ip is from the proxy
			{  
				$ipee = $_SERVER['HTTP_X_FORWARDED_FOR'];  
			}else//whether ip is from the remote address
			{  
				$ipee = $_SERVER['REMOTE_ADDR'];  
			}
				
			$stmt = $mysqli->prepare("INSERT INTO atv_log SET 
			vApplicationNo  = 'System',
			vDeed = 'Sent summary of application to $vEMailId',
			act_location = '$ipee',
			tDeedTime = '$date2'");
			$stmt->execute();

			break;
		}
	}
	$stmt->close();

	//echo 'Message sent';
}


function isInjected_m($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	
	if(preg_match($inject,$str)){return true;}else{return false;}
}


function check_ol_qualification($cProgrammeId, $iBeginLevel)
{
	$mysqli = link_connect_db();

	//does candidate have all the qualifications, if no go to the next criterion
	$stmt_cand_qualifications = $mysqli->prepare("SELECT a.*
	FROM applyqual a, qualification b
	WHERE a.cQualCodeId = b.cQualCodeId 
	AND a.vApplicationNo = ? 
	AND b.cEduCtgId LIKE 'OL%'");
	$stmt_cand_qualifications->bind_param("s", $_REQUEST['vApplicationNo']);
	$stmt_cand_qualifications->execute();
	$stmt_cand_qualifications->store_result();
	if ($stmt_cand_qualifications->num_rows == 0)
	{
		return 'Lacks Olevel qualification<br>';
	}

	$min_number_of_subject = 5;
	if(($cProgrammeId == "MSC203" || $cProgrammeId == "MSC206") && $iBeginLevel == 200)
	{
		$min_number_of_subject = 3;
	}


	// if ($iBeginLevel > 300)
	// {
	// 	$stmt_programme = $mysqli->prepare("SELECT vProgrammeDesc
	// 	FROM programme 
	// 	WHERE cProgrammeId = '$cProgrammeId'");
	// 	$stmt_programme->execute();
	// 	$stmt_programme->store_result();
	// 	$stmt_programme->bind_result($vProgrammeDesc);
	// 	$stmt_programme->fetch();
	// 	$stmt_programme->close();

	// 	$stmt_programme = $mysqli->prepare("SELECT cProgrammeId
	// 	FROM programme 
	// 	WHERE vProgrammeDesc = '$vProgrammeDesc'
	// 	AND cEduCtgId = 'PSZ'");
	// 	$stmt_programme->execute();
	// 	$stmt_programme->store_result();
	// 	$stmt_programme->bind_result($cProgrammeId);
	// 	$stmt_programme->fetch();
	// 	$stmt_programme->close();
		
	// 	if ($cProgrammeId == ''){return '';}
	// }

	
	/**************what if the sought programme is a sub-degree programme?*/
	if ($iBeginLevel < 100)
	{

	}


	$stmt_criteriadetail = $mysqli->prepare("SELECT cEduCtgId_1, cEduCtgId_2, sReqmtId, iBeginLevel
	FROM criteriadetail 
	WHERE cProgrammeId LIKE '%$cProgrammeId%'
	AND iBeginLevel <= 300
	AND cStatus = '1'
	ORDER BY iBeginLevel DESC");

	$stmt_criteriadetail->execute();
	$stmt_criteriadetail->store_result();
	$stmt_criteriadetail->bind_result($cEduCtgId_1, $cEduCtgId_2, $sReqmtId, $iBeginLevel);

	$scrn_rsult = '';
	$detail_of_seleted_prog = '';

	$lacked_subjects = "";
	$lacked_Optional_subjects = "";

	$lacked_Optional_subject_grade = "";

	while($stmt_criteriadetail->fetch())
	{
		//do onl 100L and min level for that dpts without 100L entry
		if ($iBeginLevel > 100 && $_REQUEST["cdeptold7"] <> 'NSC'){continue;}
		
		//check for OL 'C' subjects that has no alternatives
		$stmt_chk_c_sbjts_1 = $mysqli->prepare("SELECT DISTINCT cEduCtgId, a.cQualSubjectId, mutual_ex, cQualGradeId, iQualGradeRank, cMandate, vQualSubjectDesc
		FROM criteriasubject a, qualsubject b  
		WHERE sReqmtId = $sReqmtId
		AND cEduCtgId LIKE 'OL%'
		AND cProgrammeId LIKE '%$cProgrammeId%'
		AND a.cQualSubjectId = b.cQualSubjectId
		AND cMandate = 'C' AND mutual_ex = '0'");
		$stmt_chk_c_sbjts_1->execute();
		$stmt_chk_c_sbjts_1->store_result();
		$stmt_chk_c_sbjts_1->bind_result($cEduCtgId, $cQualSubjectId, $mutual_ex, $cQualGradeId, $iQualGradeRank, $cMandate, $vQualSubjectDesc);
			
		$compulsory_subjects_found = '';
		$number_of_found_compulsory_subjects = 0;

		$optional_subjects_found = '';
		$number_of_found_optional_subjects = 0;

		$lacked_subject_grade = "";

		if ($stmt_chk_c_sbjts_1->num_rows > 0)
		{
			//does candidate have compulsory subjects at minimum grade.
			while($stmt_chk_c_sbjts_1->fetch())
			{
				//do not consider economics for selected programme
				if ($cQualSubjectId == '035' && ($cProgrammeId == "MSC303" || $cProgrammeId == "MSC406" || $cProgrammeId == "MSC407"))
				{
					continue;
				}
				
				$stmt_chk_cand_c_sbjts_1 = $mysqli->prepare("SELECT cNouSubjectId, a.iGradeRank, b.cQualGradeCode
				FROM afnqualsubject a, qualgrade b
				WHERE vApplicationNo = ?
				AND a.cNouGradeId = b.cQualGradeId
				AND a.cEduCtgId LIKE 'OL%'
				AND cNouSubjectId = '$cQualSubjectId'");
				$stmt_chk_cand_c_sbjts_1->bind_param("s", $_REQUEST['vApplicationNo']);
				$stmt_chk_cand_c_sbjts_1->execute();
				$stmt_chk_cand_c_sbjts_1->store_result();
				$stmt_chk_cand_c_sbjts_1->bind_result($cNouSubjectId, $iGradeRank, $cQualGradeCode);
				$stmt_chk_cand_c_sbjts_1->fetch();

				//has 'C' subject?
				if ($stmt_chk_cand_c_sbjts_1->num_rows > 0)
				{
					//at minimum grade?
					if ($iGradeRank >= $iQualGradeRank)
					{
						$compulsory_subjects_found .= $vQualSubjectDesc.', ';
						$number_of_found_compulsory_subjects++;
					}else 
					{
						$lacked_subject_grade .= $vQualSubjectDesc.':'.$cQualGradeCode.', ';
						break;
					}
				}else
				{
					if (is_bool(strpos($lacked_subjects, $vQualSubjectDesc)))
					{
						$lacked_subjects .= $vQualSubjectDesc.', ';
					}
					break;
				}
			}
			
			$stmt_chk_c_sbjts_1->close();
		}

		//check for OL 'C' subjects that has alternatives			
		$lacked_subject_grade_c_a = '';

		$stmt_chk_c_sbjts_1 = $mysqli->prepare("SELECT cEduCtgId, a.cQualSubjectId, mutual_ex, cQualGradeId, iQualGradeRank, cMandate, vQualSubjectDesc
		FROM criteriasubject a, qualsubject b  
		WHERE sReqmtId = $sReqmtId
		AND cProgrammeId LIKE '%$cProgrammeId%'
		AND cEduCtgId LIKE 'OL%'
		AND a.cQualSubjectId = b.cQualSubjectId
		AND cMandate = 'C' AND mutual_ex <> '0'
		ORDER BY mutual_ex");
		$stmt_chk_c_sbjts_1->execute();
		$stmt_chk_c_sbjts_1->store_result();
		$stmt_chk_c_sbjts_1->bind_result($cEduCtgId, $cQualSubjectId, $mutual_ex, $cQualGradeId, $iQualGradeRank, $cMandate, $vQualSubjectDesc);

		if ($stmt_chk_c_sbjts_1->num_rows > 0)
		{
			//does candidate have compulsory subjects at minimum grade.
			$tie_no = '';

			$prev_tie_no = '';
			$count_run = 0;

			while($stmt_chk_c_sbjts_1->fetch())
			{					
				$count_run++;

				$stmt_chk_cand_c_sbjts_1 = $mysqli->prepare("SELECT cNouSubjectId, a.iGradeRank
				FROM afnqualsubject a, qualgrade b
				WHERE vApplicationNo = ?
				AND a.cNouGradeId = b.cQualGradeId
				AND a.cEduCtgId LIKE 'OL%'
				AND cNouSubjectId = '$cQualSubjectId'");
				$stmt_chk_cand_c_sbjts_1->bind_param("s", $_REQUEST['vApplicationNo']);
				$stmt_chk_cand_c_sbjts_1->execute();
				$stmt_chk_cand_c_sbjts_1->store_result();
				$stmt_chk_cand_c_sbjts_1->bind_result($cNouSubjectId, $iGradeRank);
				$stmt_chk_cand_c_sbjts_1->fetch();

				//has 'C' subject?
				if ($stmt_chk_cand_c_sbjts_1->num_rows > 0 && is_bool(strpos($tie_no, $mutual_ex)))
				{
					//at minimum grade?
					if ($iGradeRank >= $iQualGradeRank)
					{
						
						$tie_no .= $mutual_ex."','";

						$compulsory_subjects_found .= $vQualSubjectDesc.', ';
						$number_of_found_compulsory_subjects++;
					}
				}
				$stmt_chk_cand_c_sbjts_1->close();
				
				if ($prev_tie_no <> '' && ($prev_tie_no <> $mutual_ex || $count_run == $stmt_chk_c_sbjts_1->num_rows) && is_bool(strpos($tie_no, $prev_tie_no)))
				{	
					$stmt_chk_c_a_sbjts_1 = $mysqli->prepare("SELECT b.cQualSubjectId, vQualSubjectDesc, c.cQualGradeCode 
					FROM criteriasubject a, qualsubject b, qualgrade c
					WHERE sReqmtId = $sReqmtId  
					AND cProgrammeId LIKE '%$cProgrammeId%' 
					AND a.cEduCtgId LIKE 'OL%' 
					AND a.cQualSubjectId = b.cQualSubjectId 
					AND a.cQualGradeId = c.cQualGradeId 
					AND cMandate = 'C' 
					AND mutual_ex = '$prev_tie_no' 
					ORDER BY vQualSubjectDesc;");
					$stmt_chk_c_a_sbjts_1->execute();
					$stmt_chk_c_a_sbjts_1->store_result();
					$stmt_chk_c_a_sbjts_1->bind_result($cQualSubjectId_c_a, $vQualSubjectDesc_c_a, $cQualGradeCode_c_a);
					while($stmt_chk_c_a_sbjts_1->fetch())
					{
						$lacked_subject_grade_c_a .= $vQualSubjectDesc_c_a.':'.$cQualGradeCode_c_a.', ';
					}
				}
				$prev_tie_no = $mutual_ex;
			}
			$stmt_chk_c_sbjts_1->close();
		}


		//has optional OL subjects
		if ($number_of_found_compulsory_subjects < $min_number_of_subject)
		{
			$stmt_chk_e_sbjts_1 = $mysqli->prepare("SELECT DISTINCT cEduCtgId, a.cQualSubjectId, mutual_ex, cQualGradeId, iQualGradeRank, cMandate, vQualSubjectDesc
			FROM criteriasubject a, qualsubject b  
			WHERE sReqmtId = $sReqmtId
			AND cProgrammeId LIKE '%$cProgrammeId%'
			AND cEduCtgId LIKE 'OL%'
			AND a.cQualSubjectId = b.cQualSubjectId
			AND cMandate = 'E'");
			$stmt_chk_e_sbjts_1->execute();
			$stmt_chk_e_sbjts_1->store_result();
			$stmt_chk_e_sbjts_1->bind_result($cEduCtgId, $cQualSubjectId, $mutual_ex, $cQualGradeId, $iQualGradeRank, $cMandate, $vQualSubjectDesc);
			

			if ($stmt_chk_e_sbjts_1->num_rows > 0)
			{
				while($stmt_chk_e_sbjts_1->fetch())
				{
					$stmt_chk_cand_e_sbjts_1 = $mysqli->prepare("SELECT cNouSubjectId, a.iGradeRank, b.cQualGradeCode
					FROM afnqualsubject a, qualgrade b
					WHERE vApplicationNo = ?
					AND a.cNouGradeId = b.cQualGradeId
					AND a.cEduCtgId LIKE 'OL%'
					AND cNouSubjectId = '$cQualSubjectId'");
					$stmt_chk_cand_e_sbjts_1->bind_param("s", $_REQUEST['vApplicationNo']);
					$stmt_chk_cand_e_sbjts_1->execute();
					$stmt_chk_cand_e_sbjts_1->store_result();
					$stmt_chk_cand_e_sbjts_1->bind_result($cNouSubjectId, $iGradeRank, $cQualGradeCode);
					$stmt_chk_cand_e_sbjts_1->fetch();

					if ($stmt_chk_cand_e_sbjts_1->num_rows > 0)
					{
						//at minimum grade?
						if ($iGradeRank >= $iQualGradeRank)
						{
							$optional_subjects_found .= $vQualSubjectDesc.', ';
							$number_of_found_optional_subjects++;
						}else 
						{
							$lacked_Optional_subject_grade .= $vQualSubjectDesc.':'.$cQualGradeCode.', ';
						}
					}else
					{
						if (is_bool(strpos($lacked_Optional_subjects, $vQualSubjectDesc)))
						{
							$lacked_Optional_subjects .= $vQualSubjectDesc.', ';
						}
					}
					
					if ($number_of_found_optional_subjects >= 5)
					{
						break;
					}
				}
				$stmt_chk_e_sbjts_1->close();
			}
		}


		if ($lacked_subjects <> '')
		{
			$scrn_rsult .= 'Lacks compulsory Olevel subject : '.substr($lacked_subjects,0,strlen($lacked_subjects)-2).'<br>';
		}

		if ($lacked_subject_grade <> '')
		{
			$scrn_rsult .= 'Lacks minimum grade in compulsory Olevel subject : '.substr($lacked_subject_grade,0,strlen($lacked_subject_grade)-2).'<br>';
		}

		if ($lacked_subject_grade_c_a <> '')
		{
			$scrn_rsult .= 'Lacks compulsory but alternative Olevel subjects : '.substr($lacked_subject_grade_c_a,0,strlen($lacked_subject_grade_c_a)-2).'<br>';
		}
		
		if ($lacked_Optional_subjects <> '' && ($number_of_found_optional_subjects + $number_of_found_compulsory_subjects < $min_number_of_subject))
		{
			//$scrn_rsult .= 'Lacks optional Olevel subject : '.substr($lacked_Optional_subjects,0,strlen($lacked_Optional_subjects)-2).'<br>';

			$scrn_rsult .= 'Lacks optional Olevel subject<br>';
		}

		if ($lacked_Optional_subject_grade <> '' && ($number_of_found_optional_subjects + $number_of_found_compulsory_subjects < $min_number_of_subject))
		{
			//$scrn_rsult .= 'Lacks minimum grade in compulsory Olevel subject : '.substr($lacked_Optional_subject_grade,0,strlen($lacked_Optional_subject_grade)-2).'<br>';
			
			$scrn_rsult .= 'Lacks minimum grade in compulsory Olevel subject<br>';
		}

		if ($number_of_found_optional_subjects + $number_of_found_compulsory_subjects < $min_number_of_subject)
		{
			return $scrn_rsult;
		}else
		{
			if(is_bool(strpos($detail_of_seleted_prog, $cProgrammeId.$iBeginLevel)))
			{
				$detail_of_seleted_prog .= '~'.$cProgrammeId.$iBeginLevel.str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
				//$detail_of_seleted_prog .= $cProgrammeId.$iBeginLevel.str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
			}
		}
	}

	

	//consider higher but sub-degree qualifications
	
	$scrn_rsult = '';

	$stmt_criteriadetail->data_seek(0);

	while($stmt_criteriadetail->fetch())
	{
		
		if ($cEduCtgId_2 == '' || $iBeginLevel == 100){continue;}

		if ($cEduCtgId_2 <> '')
		{
			$stmt_cand_higher_qualifications = $mysqli->prepare("SELECT *
			FROM applyqual
			WHERE cEduCtgId = '$cEduCtgId_2'
			AND vApplicationNo = ?");
			$stmt_cand_higher_qualifications->bind_param("s", $_REQUEST['vApplicationNo']);
			$stmt_cand_higher_qualifications->execute();
			$stmt_cand_higher_qualifications->store_result();
			if ($stmt_cand_higher_qualifications->num_rows == 0)
			{
				$stmt_cand_higher_qualifications->close();
				continue;
			}
		}

		$min_number_of_subject = 1;
		if (substr($cEduCtgId_2, 0, 2) == "AL")
		{
			$min_number_of_subject = 2;
		}

		//check for OL 'C' subjects that has no alternatives
		
		
		$stmt_chk_c_sbjts_1 = $mysqli->prepare("SELECT DISTINCT cEduCtgId, a.cQualSubjectId, mutual_ex, cQualGradeId, iQualGradeRank, cMandate, vQualSubjectDesc
		FROM criteriasubject a, qualsubject b  
		WHERE sReqmtId = $sReqmtId
		AND cEduCtgId = '$cEduCtgId_2'
		AND cProgrammeId LIKE '%$cProgrammeId%'
		AND a.cQualSubjectId = b.cQualSubjectId
		AND cMandate = 'C' AND mutual_ex = '0'");
		$stmt_chk_c_sbjts_1->execute();
		$stmt_chk_c_sbjts_1->store_result();
		$stmt_chk_c_sbjts_1->bind_result($cEduCtgId, $cQualSubjectId, $mutual_ex, $cQualGradeId, $iQualGradeRank, $cMandate, $vQualSubjectDesc);
			
		$compulsory_subjects_found = '';
		$number_of_found_compulsory_subjects = 0;

		$optional_subjects_found = '';
		$number_of_found_optional_subjects = 0;

		$lacked_subject_grade = "";

		if ($stmt_chk_c_sbjts_1->num_rows > 0)
		{
			//does candidate have compulsory subjects at minimum grade.
			while($stmt_chk_c_sbjts_1->fetch())
			{
				$stmt_chk_cand_c_sbjts_1 = $mysqli->prepare("SELECT cNouSubjectId, a.iGradeRank, b.cQualGradeCode
				FROM afnqualsubject a, qualgrade b
				WHERE vApplicationNo = ?
				AND a.cNouGradeId = b.cQualGradeId
				AND a.cEduCtgId = '$cEduCtgId_2'
				AND cNouSubjectId = '$cQualSubjectId'");
				$stmt_chk_cand_c_sbjts_1->bind_param("s", $_REQUEST['vApplicationNo']);
				$stmt_chk_cand_c_sbjts_1->execute();
				$stmt_chk_cand_c_sbjts_1->store_result();
				$stmt_chk_cand_c_sbjts_1->bind_result($cNouSubjectId, $iGradeRank, $cQualGradeCode);
				$stmt_chk_cand_c_sbjts_1->fetch();

				//has 'C' subject?
				if ($stmt_chk_cand_c_sbjts_1->num_rows > 0)
				{
					//at minimum grade?
					if ($iGradeRank >= $iQualGradeRank)
					{
						$compulsory_subjects_found .= $vQualSubjectDesc.', ';
						$number_of_found_compulsory_subjects++;
					}else 
					{
						$lacked_subject_grade .= $vQualSubjectDesc.':'.$cQualGradeCode.', ';
						break;
					}
				}else
				{
					if (is_bool(strpos($lacked_subjects, $vQualSubjectDesc)))
					{
						$lacked_subjects .= $vQualSubjectDesc.', ';
					}
					break;
				}

				if ($number_of_found_compulsory_subjects >= $min_number_of_subject)
				{
					$lacked_subjects = '';
					$lacked_subject_grade = '';

					$lacked_subject_grade_c_a = '';
					$lacked_Optional_subjects = '';
					$lacked_Optional_subject_grade = '';

					if(is_bool(strpos($detail_of_seleted_prog, $cProgrammeId.$iBeginLevel)))
					{
						//$detail_of_seleted_prog .= '~'.$cProgrammeId.$iBeginLevel.str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
						$detail_of_seleted_prog .= $cProgrammeId.$iBeginLevel.str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
					}

					break;
				}
			}
			
			$stmt_chk_c_sbjts_1->close();
		}

		//check for OL 'C' subjects that has alternatives			
		$lacked_subject_grade_c_a = '';

		$stmt_chk_c_sbjts_1 = $mysqli->prepare("SELECT cEduCtgId, a.cQualSubjectId, mutual_ex, cQualGradeId, iQualGradeRank, cMandate, vQualSubjectDesc
		FROM criteriasubject a, qualsubject b  
		WHERE sReqmtId = $sReqmtId
		AND cProgrammeId LIKE '%$cProgrammeId%'
		AND cEduCtgId = '$cEduCtgId_2'
		AND a.cQualSubjectId = b.cQualSubjectId
		AND cMandate = 'C' AND mutual_ex <> '0'
		ORDER BY mutual_ex");
		$stmt_chk_c_sbjts_1->execute();
		$stmt_chk_c_sbjts_1->store_result();
		$stmt_chk_c_sbjts_1->bind_result($cEduCtgId, $cQualSubjectId, $mutual_ex, $cQualGradeId, $iQualGradeRank, $cMandate, $vQualSubjectDesc);

		if ($stmt_chk_c_sbjts_1->num_rows > 0)
		{
			//does candidate have compulsory subjects at minimum grade.
			$tie_no = '';

			$prev_tie_no = '';
			$count_run = 0;

			while($stmt_chk_c_sbjts_1->fetch())
			{					
				$count_run++;

				$stmt_chk_cand_c_sbjts_1 = $mysqli->prepare("SELECT cNouSubjectId, a.iGradeRank
				FROM afnqualsubject a, qualgrade b
				WHERE vApplicationNo = ?
				AND a.cNouGradeId = b.cQualGradeId
				AND a.cEduCtgId = '$cEduCtgId_2'
				AND cNouSubjectId = '$cQualSubjectId'");
				$stmt_chk_cand_c_sbjts_1->bind_param("s", $_REQUEST['vApplicationNo']);
				$stmt_chk_cand_c_sbjts_1->execute();
				$stmt_chk_cand_c_sbjts_1->store_result();
				$stmt_chk_cand_c_sbjts_1->bind_result($cNouSubjectId, $iGradeRank);
				$stmt_chk_cand_c_sbjts_1->fetch();

				//has 'C' subject?
				if ($stmt_chk_cand_c_sbjts_1->num_rows > 0 && is_bool(strpos($tie_no, $mutual_ex)))
				{
					//at minimum grade?
					if ($iGradeRank >= $iQualGradeRank)
					{
						
						$tie_no .= $mutual_ex."','";

						$compulsory_subjects_found .= $vQualSubjectDesc.', ';
						$number_of_found_compulsory_subjects++;
					}
				}
				$stmt_chk_cand_c_sbjts_1->close();
				
				if ($prev_tie_no <> '' && ($prev_tie_no <> $mutual_ex || $count_run == $stmt_chk_c_sbjts_1->num_rows) && is_bool(strpos($tie_no, $prev_tie_no)))
				{	
					$stmt_chk_c_a_sbjts_1 = $mysqli->prepare("SELECT b.cQualSubjectId, vQualSubjectDesc, c.cQualGradeCode 
					FROM criteriasubject a, qualsubject b, qualgrade c
					WHERE sReqmtId = $sReqmtId  
					AND cProgrammeId LIKE '%$cProgrammeId%' 
					AND a.cEduCtgId = '$cEduCtgId_2'
					AND a.cQualSubjectId = b.cQualSubjectId 
					AND a.cQualGradeId = c.cQualGradeId 
					AND cMandate = 'C' 
					AND mutual_ex = '$prev_tie_no' 
					ORDER BY vQualSubjectDesc;");
					$stmt_chk_c_a_sbjts_1->execute();
					$stmt_chk_c_a_sbjts_1->store_result();
					$stmt_chk_c_a_sbjts_1->bind_result($cQualSubjectId_c_a, $vQualSubjectDesc_c_a, $cQualGradeCode_c_a);
					while($stmt_chk_c_a_sbjts_1->fetch())
					{
						$lacked_subject_grade_c_a .= $vQualSubjectDesc_c_a.':'.$cQualGradeCode_c_a.', ';

						if ($number_of_found_compulsory_subjects >= $min_number_of_subject)
						{
							$lacked_subjects = '';
							$lacked_subject_grade = '';

							$lacked_subject_grade_c_a = '';
							$lacked_Optional_subjects = '';
							$lacked_Optional_subject_grade = '';

							if(is_bool(strpos($detail_of_seleted_prog, $cProgrammeId.$iBeginLevel)))
							{
								$detail_of_seleted_prog .= '~'.$cProgrammeId.$iBeginLevel.str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
								//$detail_of_seleted_prog .= $cProgrammeId.$iBeginLevel.str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
							}
						}
					}
				}
				$prev_tie_no = $mutual_ex;
			}
			$stmt_chk_c_sbjts_1->close();
		}


		//has optional OL subjects
		if ($number_of_found_compulsory_subjects < $min_number_of_subject)
		{
			$stmt_chk_e_sbjts_1 = $mysqli->prepare("SELECT DISTINCT cEduCtgId, a.cQualSubjectId, mutual_ex, cQualGradeId, iQualGradeRank, cMandate, vQualSubjectDesc
			FROM criteriasubject a, qualsubject b  
			WHERE sReqmtId = $sReqmtId
			AND cProgrammeId LIKE '%$cProgrammeId%'
			AND cEduCtgId = '$cEduCtgId_2'
			AND a.cQualSubjectId = b.cQualSubjectId
			AND cMandate = 'E'");
			$stmt_chk_e_sbjts_1->execute();
			$stmt_chk_e_sbjts_1->store_result();
			$stmt_chk_e_sbjts_1->bind_result($cEduCtgId, $cQualSubjectId, $mutual_ex, $cQualGradeId, $iQualGradeRank, $cMandate, $vQualSubjectDesc);
			

			if ($stmt_chk_e_sbjts_1->num_rows > 0)
			{
				while($stmt_chk_e_sbjts_1->fetch())
				{
					$stmt_chk_cand_e_sbjts_1 = $mysqli->prepare("SELECT cNouSubjectId, a.iGradeRank, b.cQualGradeCode
					FROM afnqualsubject a, qualgrade b
					WHERE vApplicationNo = ?
					AND a.cNouGradeId = b.cQualGradeId
					AND a.cEduCtgId = '$cEduCtgId_2'
					AND cNouSubjectId = '$cQualSubjectId'");
					$stmt_chk_cand_e_sbjts_1->bind_param("s", $_REQUEST['vApplicationNo']);
					$stmt_chk_cand_e_sbjts_1->execute();
					$stmt_chk_cand_e_sbjts_1->store_result();
					$stmt_chk_cand_e_sbjts_1->bind_result($cNouSubjectId, $iGradeRank, $cQualGradeCode);
					$stmt_chk_cand_e_sbjts_1->fetch();

					if ($stmt_chk_cand_e_sbjts_1->num_rows > 0)
					{
						//at minimum grade?
						if ($iGradeRank >= $iQualGradeRank)
						{
							$optional_subjects_found .= $vQualSubjectDesc.', ';
							$number_of_found_optional_subjects++;
						}else 
						{
							$lacked_Optional_subject_grade .= $vQualSubjectDesc.':'.$cQualGradeCode.', ';
						}
					}else
					{
						if (is_bool(strpos($lacked_Optional_subjects, $vQualSubjectDesc)))
						{
							$lacked_Optional_subjects .= $vQualSubjectDesc.', ';
						}
					}
					
					if ($number_of_found_optional_subjects + $number_of_found_compulsory_subjects >= $min_number_of_subject)
					{
						$lacked_subjects = '';
						$lacked_subject_grade = '';

						$lacked_subject_grade_c_a = '';
						$lacked_Optional_subjects = '';
						$lacked_Optional_subject_grade = '';

						if(is_bool(strpos($detail_of_seleted_prog, $cProgrammeId.$iBeginLevel)))
						{
							$detail_of_seleted_prog .= '~'.$cProgrammeId.$iBeginLevel.str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
							//$detail_of_seleted_prog .= $cProgrammeId.$iBeginLevel.str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
						}
						break;
					}
				}
				$stmt_chk_e_sbjts_1->close();
			}
		}
		

		if ($lacked_subjects <> '')
		{
			$scrn_rsult .= 'Lacks compulsory higher level subject : '.substr($lacked_subjects,0,strlen($lacked_subjects)-2).'<br>';
		}

		if ($lacked_subject_grade <> '')
		{
			$scrn_rsult .= 'Lacks minimum grade in compulsory higher level subject : '.substr($lacked_subject_grade,0,strlen($lacked_subject_grade)-2).'<br>';
		}

		if ($lacked_subject_grade_c_a <> '')
		{
			$scrn_rsult .= 'Lacks compulsory but alternative higher level subjects : '.substr($lacked_subject_grade_c_a,0,strlen($lacked_subject_grade_c_a)-2).'<br>';
		}
		
		if ($lacked_Optional_subjects <> '' && ($number_of_found_optional_subjects + $number_of_found_compulsory_subjects < $min_number_of_subject))
		{
			$scrn_rsult .= 'Lacks optional higher level subject : '.substr($lacked_Optional_subjects,0,strlen($lacked_Optional_subjects)-2).'<br>';
		}

		if ($lacked_Optional_subject_grade <> '' && ($number_of_found_optional_subjects + $number_of_found_compulsory_subjects < $min_number_of_subject))
		{
			$scrn_rsult .= 'Lacks minimum grade in compulsory higher level subject : '.substr($lacked_Optional_subject_grade,0,strlen($lacked_Optional_subject_grade)-2).'<br>';
		}

		if ($scrn_rsult == '')
		{
			if(is_bool(strpos($detail_of_seleted_prog, $cProgrammeId.$iBeginLevel)))
			{
				$detail_of_seleted_prog .= '~'.$cProgrammeId.$iBeginLevel.str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
				//$detail_of_seleted_prog .= $cProgrammeId.$iBeginLevel.str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
			}
		}
	}
	$stmt_criteriadetail->close();	

	return  $detail_of_seleted_prog;
}


function check_al_qualification($cProgrammeId)
{
	$scrn_rsult= '';
	$detail_of_seleted_prog = '';
	$optional_subjects_found = '';
	$number_of_found_optional_qual_ol_subjects = 0;

	$compulsory_subjects_found = '';
	$number_of_found_compulsory_qual_ol_subjects = 0;

	$lacked_compulsory_subject = '';
	$lacked_compulsory_subject_grade = '';
	
	$mysqli = link_connect_db();

	$stmt_cand_qualifications = $mysqli->prepare("SELECT cEduCtgId
	FROM applyqual 
	WHERE vApplicationNo = ? 
	AND cEduCtgId NOT LIKE 'OL%'");
	$stmt_cand_qualifications->bind_param("s", $_REQUEST['vApplicationNo']);
	$stmt_cand_qualifications->execute();
	$stmt_cand_qualifications->store_result();
	if ($stmt_cand_qualifications->num_rows == 0)
	{
		return '';
	}else
	{
		$stmt_cand_qualifications->bind_result($cEduCtgId);
		while($stmt_cand_qualifications->fetch())
		{			
			//higher qualification consideration
			
			$stmt_criteriadetail = $mysqli->prepare("SELECT sReqmtId, iBeginLevel, cEduCtgId_2
			FROM criteriadetail 
			WHERE cProgrammeId LIKE '%$cProgrammeId%'
			AND cEduCtgId_2 = '$cEduCtgId'
			AND cStatus = '1'
			ORDER BY iBeginLevel DESC");
			
			//$stmt_criteriadetail->bind_param("s", $cFacultyId);
			$stmt_criteriadetail->execute();
			$stmt_criteriadetail->store_result();
			$stmt_criteriadetail->bind_result($sReqmtId, $iBeginLevel, $cEduCtgId_2);
			
			while($stmt_criteriadetail->fetch())
			{
				//PGD consideration
				if ($iBeginLevel == 700)
				{
					if ($_REQUEST["cdeptold7"] == 'BUS')
					{
						//return '~'.$cProgrammeId.$iBeginLevel.str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
						return $cProgrammeId.$iBeginLevel.str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
					}
				}

				if ($cProgrammeId == 'MSC401' || $cProgrammeId == 'MSC408' || $cProgrammeId == 'MSC409' || $cProgrammeId == 'MSC410' || $cProgrammeId == 'MSC411' || $cProgrammeId == 'MSC412' || $cProgrammeId == 'MSC413' || $cProgrammeId == 'MSC414' /* and it is cemba/cempa */)
				{
					//return '~'.$cProgrammeId.$iBeginLevel.str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
					return $cProgrammeId.$iBeginLevel.str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
				}

				//check for 'C' subjects that has no alternatives
				if ($cProgrammeId == 'SCI209')
				{
					$min_number_of_subject = 3;
				}else if (substr($cEduCtgId_2, 0, 2) == "AL")
				{
					$min_number_of_subject = 2;
				}else
				{
					$min_number_of_subject = 1;
				}

				$stmt_chk_c_higher_sbjts_1 = $mysqli->prepare("SELECT a.cQualSubjectId, mutual_ex, cQualGradeId, iQualGradeRank, cMandate, vQualSubjectDesc
				FROM criteriasubject a, qualsubject b  
				WHERE sReqmtId = $sReqmtId
				AND cEduCtgId = '$cEduCtgId'
				AND cProgrammeId LIKE '%$cProgrammeId%'
				AND a.cQualSubjectId = b.cQualSubjectId
				AND cMandate = 'C' AND mutual_ex = '0'
				ORDER BY vQualSubjectDesc, mutual_ex");

				$stmt_chk_c_higher_sbjts_1->execute();
				$stmt_chk_c_higher_sbjts_1->store_result();
				$stmt_chk_c_higher_sbjts_1->bind_result($cQualSubjectId, $mutual_ex, $cQualGradeId, $iQualGradeRank, $cMandate, $vQualSubjectDesc);
				
				if ($stmt_chk_c_higher_sbjts_1->num_rows > 0)
				{					
					//does candidate have compulsory subjects at minimum grade.
					while($stmt_chk_c_higher_sbjts_1->fetch())
					{	
						$stmt_chk_cand_c_higher_sbjts_1 = $mysqli->prepare("SELECT cNouSubjectId, a.iGradeRank, b.cQualGradeCode
						FROM afnqualsubject a, qualgrade b
						WHERE vApplicationNo = ?
						AND a.cNouGradeId = b.cQualGradeId
						AND a.cEduCtgId = '$cEduCtgId'
						AND cNouSubjectId = '$cQualSubjectId'");
						$stmt_chk_cand_c_higher_sbjts_1->bind_param("s", $_REQUEST['vApplicationNo']);
						$stmt_chk_cand_c_higher_sbjts_1->execute();
						$stmt_chk_cand_c_higher_sbjts_1->store_result();
						$stmt_chk_cand_c_higher_sbjts_1->bind_result($cNouSubjectId, $iGradeRank, $cQualGradeCode);
						$stmt_chk_cand_c_higher_sbjts_1->fetch();

						//has 'C' subject?
						if ($stmt_chk_cand_c_higher_sbjts_1->num_rows > 0)
						{
							//at minimum grade?
							if ($iGradeRank >= $iQualGradeRank && is_bool(strpos($compulsory_subjects_found,$vQualSubjectDesc)))
							{
								$number_of_found_compulsory_qual_ol_subjects++;
								$compulsory_subjects_found  .= $vQualSubjectDesc.', ';

								$cProgrammeId_iBeginLevel = $cProgrammeId.$iBeginLevel;
								if($number_of_found_compulsory_qual_ol_subjects >= $min_number_of_subject && is_bool(strpos($detail_of_seleted_prog, $cProgrammeId_iBeginLevel)))
								{
									//$detail_of_seleted_prog .= '~'.$cProgrammeId.$iBeginLevel.str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
									$detail_of_seleted_prog .= $cProgrammeId.$iBeginLevel.str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
									
									break;
								}
							}else if ($iGradeRank < $iQualGradeRank)
							{
								$lacked_compulsory_subject_grade  .= $vQualSubjectDesc.':'.$cQualGradeCode.', ';

								if (is_bool(strpos($scrn_rsult, "Lacks minimum grade for compulsory higher")))
								{
									$scrn_rsult .= 'Lacks minimum grade for compulsory higher qualification subject. See "Am I qualified" on the home page for detail.';
								}
							}
						}else
						{
							$lacked_compulsory_subject .= $vQualSubjectDesc.', ';
							if (is_bool(strpos($scrn_rsult, "Lacks compulsory higher qualification subject")))
							{
								$scrn_rsult .= 'Lacks compulsory higher qualification subject. See "Am I qualified" on the home page for detail.';
							}
						}
					}
					$stmt_chk_c_higher_sbjts_1->close();
				}


				if ($number_of_found_compulsory_qual_ol_subjects < $min_number_of_subject)
				{
					//has optional higher subjects
					$stmt_chk_e_higher_sbjts_1 = $mysqli->prepare("SELECT DISTINCT cEduCtgId, a.cQualSubjectId, mutual_ex, cQualGradeId, iQualGradeRank, cMandate, vQualSubjectDesc
					FROM criteriasubject a, qualsubject b  
					WHERE sReqmtId = $sReqmtId
					AND cProgrammeId LIKE '%$cProgrammeId%'
					AND cEduCtgId = '$cEduCtgId'
					AND a.cQualSubjectId = b.cQualSubjectId
					AND cMandate = 'E'");
					$stmt_chk_e_higher_sbjts_1->execute();
					$stmt_chk_e_higher_sbjts_1->store_result();
					$stmt_chk_e_higher_sbjts_1->bind_result($cEduCtgId_01, $cQualSubjectId, $mutual_ex, $cQualGradeId, $iQualGradeRank, $cMandate, $vQualSubjectDesc);

					if ($stmt_chk_e_higher_sbjts_1->num_rows > 0)
					{
						$number_of_found_optional_qual_ol_subjects = 0;
						while($stmt_chk_e_higher_sbjts_1->fetch())
						{
							
							$stmt_chk_cand_e_sbjts_1 = $mysqli->prepare("SELECT cNouSubjectId, a.iGradeRank, b.cQualGradeCode
							FROM afnqualsubject a, qualgrade b
							WHERE vApplicationNo = ?
							AND a.cNouGradeId = b.cQualGradeId
							AND a.cEduCtgId = '$cEduCtgId'
							AND cNouSubjectId = '$cQualSubjectId'");
							$stmt_chk_cand_e_sbjts_1->bind_param("s", $_REQUEST['vApplicationNo']);
							$stmt_chk_cand_e_sbjts_1->execute();
							$stmt_chk_cand_e_sbjts_1->store_result();
							$stmt_chk_cand_e_sbjts_1->bind_result($cNouSubjectId, $iGradeRank, $cQualGradeCode);
							$stmt_chk_cand_e_sbjts_1->fetch();

							if ($stmt_chk_cand_e_sbjts_1->num_rows > 0)
							{
								
								//at minimum grade?
								if ($iGradeRank >= $iQualGradeRank && is_bool(strpos($optional_subjects_found,$vQualSubjectDesc)))
								{
									$number_of_found_optional_qual_ol_subjects++;
									$optional_subjects_found  .= $vQualSubjectDesc.', ';

									$cProgrammeId_iBeginLevel = $cProgrammeId.$iBeginLevel;
									if($number_of_found_optional_qual_ol_subjects >= $min_number_of_subject && is_bool(strpos($detail_of_seleted_prog, $cProgrammeId_iBeginLevel)))
									{
										//$detail_of_seleted_prog .= '~'.$cProgrammeId.$iBeginLevel.str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
										$detail_of_seleted_prog .= $cProgrammeId.$iBeginLevel.str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
										break;
									}
								}else if ($iGradeRank < $iQualGradeRank)
								{
									if (is_bool(strpos($scrn_rsult, "Lacks minimum grade for optional")))
									{
										$scrn_rsult .= 'Lacks minimum grade for optional higher qualification subject. See "Am I qualified" on the home page for detail.';
									}
								}
							}else
							{
								if (is_bool(strpos($scrn_rsult, "Lacks optional higher qualification subject")))
								{
									$scrn_rsult .= 'Lacks optional higher qualification subject. See "Am I qualified" on the home page for detail.';
								}
							}
						}
						$stmt_chk_e_higher_sbjts_1->close();
					}
				}
			}
			$stmt_criteriadetail->close();
		}
		$stmt_cand_qualifications->close();
	}

	if ($detail_of_seleted_prog == '' && is_bool(strpos($scrn_rsult, "compulsory")) && is_bool(strpos($scrn_rsult, "Lacks")))
	{
		return $scrn_rsult;
	}else
	{
		return $detail_of_seleted_prog;
	}
}


function s_cadm()
{
	$detail_of_seleted_prog_1 = '';
	
	$mysqli = link_connect_db();

	$stmt_programme = $mysqli->prepare("SELECT cProgrammeId
	FROM programme 
	WHERE cdeptId = ?
	AND cEduCtgId = ?
	AND cDelFlag = 'N'");
	$stmt_programme->bind_param("ss", $_REQUEST["cdeptold7"], $_REQUEST["cEduCtgId"]);

	// $stmt_programme = $mysqli->prepare("SELECT cProgrammeId
	// FROM programme 
	// WHERE cProgrammeId = 'EDU207'");
	
	$stmt_programme->execute();
	$stmt_programme->store_result();
	$stmt_programme->bind_result($cProgrammeId);
	
	if ($stmt_programme->num_rows == 0 && isset($_REQUEST["cEduCtgId"]))
	{
		$cat_desc = '';
		if (!is_bool(strpos($_REQUEST["cEduCtgId"], 'AL')))
		{
			$cat_desc = 'AL';
		}elseif ($_REQUEST["cEduCtgId"] == 'ELZ')
		{
			$cat_desc = 'Diploma';
		}else if ($_REQUEST["cEduCtgId"] == 'PSX')
		{
			$cat_desc = 'Higher Nation Diploma';
		}else if ($_REQUEST["cEduCtgId"] == 'PSZ')
		{
			$cat_desc = 'First Degree';
		}else if ($_REQUEST["cEduCtgId"] == 'PGX')
		{
			$cat_desc = 'Postgraduate Diploma';
		}else if ($_REQUEST["cEduCtgId"] == 'PGY')
		{
			$cat_desc = 'Masters Degree';
		}else if ($_REQUEST["cEduCtgId"] == 'PGZ')
		{
			$cat_desc = 'Pre-Doctorate Degree';
		}else if ($_REQUEST["cEduCtgId"] == 'PRX')
		{
			$cat_desc = 'Doctorate Degree';
		}
		return "There are no programmes in the selected category ($cat_desc) in this department<br>";
	}

	if ($_REQUEST["cEduCtgId"] == 'PSZ')
	{
		$starting = 100;
		$ending = 300;
		if ($_REQUEST["cFacultyId7"] == 'HSC')
		{
			$starting = 200;
		}
	}else if ($_REQUEST["cEduCtgId"] == 'PGX')
	{
		$starting = 100;
		$ending = 700;
	}else// if ($_REQUEST["cEduCtgId"] == 'PGY')
	{
		$starting = 100;
		$ending = 800;
	}
	
	$compulsory_subjects_with_low_graded_0 = '';
	$compulsory_subjects_not_found_0 = '';

	while($stmt_programme->fetch())
	{
		$child_qry = '';
		$sReqmtId_qry = '';

		$child_qry = " AND a.cProgrammeId LIKE '%$cProgrammeId%' ";

		for ($level = $starting; $level <= $ending; $level += 100)
		{
			if ($level == 400 || $level == 500 || $level == 600)
			{
				continue;
			}

			$higher_qual_status = '';

			if ($detail_of_seleted_prog_1 == '')
			{
				if ($_REQUEST["cFacultyId7"] == 'HSC')
				{
					if ($level > 200)
					{
						break;
					}
				}elseif ($level > 100)
				{
					break;
				}
			}else
			{
				if ($_REQUEST["cFacultyId7"] == 'HSC' && $_REQUEST["cdeptold7"] <> 'NSC')
				{
					if ($level > 200)
					{
						$higher_qual_status = check_higher_level_qual(200, $child_qry, $cProgrammeId);
						//echo $higher_qual_status;
						if (!is_bool(strpos($higher_qual_status, "Lack")))
						{
							break;
						}
						
					}
				}
			}
			
			$expected_min_num_of_subject = 0;

			if ($_REQUEST["cEduCtgId"] == 'PGX')
			{
				$aa = get_qry_part('0', $_REQUEST['cFacultyId7'], $_REQUEST['cdeptold7'], $cProgrammeId, 700);
			}else if ($_REQUEST["cEduCtgId"] == 'PGY' || $_REQUEST["cEduCtgId"] == 'PGZ' || $_REQUEST["cEduCtgId"] == 'PRX')
			{
				$aa = get_qry_part('0', $_REQUEST['cFacultyId7'], $_REQUEST['cdeptold7'], $cProgrammeId, 800);
			}else
			{
				$aa = get_qry_part('0', $_REQUEST['cFacultyId7'], $_REQUEST['cdeptold7'], $cProgrammeId, $level);
			}
			if ($aa <> '')
			{
				$sReqmtId_qry = $aa;
			}

			if ($_REQUEST["cEduCtgId"] == 'PGX')
			{
				$bb = get_qry_part('1', $_REQUEST['cFacultyId7'], $_REQUEST['cdeptold7'], $cProgrammeId, 700);
			}else if ($_REQUEST["cEduCtgId"] == 'PGY' || $_REQUEST["cEduCtgId"] == 'PGZ' || $_REQUEST["cEduCtgId"] == 'PRX')
			{
				$bb = get_qry_part('1', $_REQUEST['cFacultyId7'], $_REQUEST['cdeptold7'], $cProgrammeId, 800);
			}else
			{
				$bb = get_qry_part('1', $_REQUEST['cFacultyId7'], $_REQUEST['cdeptold7'], $cProgrammeId, $level);
			}			
			if ($bb <> '')
			{
				$child_qry = $bb;
			}

			$pg_level_cond = "";
			if ($_REQUEST["cEduCtgId"] ==  'PGX')
			{
				$pg_level_cond = " OR a.iBeginLevel = 700";
			}else if ($_REQUEST["cEduCtgId"] == 'PGY' || $_REQUEST["cEduCtgId"] == 'PGZ' || $_REQUEST["cEduCtgId"] == 'PRX')
			{
				$pg_level_cond = " OR a.iBeginLevel = 800";
			}

			// echo "SELECT cEduCtgId_1, cEduCtgId_2, a.sReqmtId, c.vQualSubjectDesc, c.cQualSubjectId, b.cMandate, b.mutual_ex, b.cQualGradeId, b.iQualGradeRank, a.iBeginLevel
			// FROM criteriadetail a, criteriasubject b, qualsubject c
			// WHERE a.cCriteriaId = b.cCriteriaId
			// AND a.cProgrammeId = b.cProgrammeId
			// AND a.sReqmtId = b.sReqmtId
			// AND b.cQualSubjectId = c.cQualSubjectId
			// AND a.cCriteriaId = ?
			// AND a.cDelFlag = 'N'
			// AND b.cDelFlag = 'N'
			// $child_qry
			// AND ((a.iBeginLevel = $level 
			// $sReqmtId_qry)
			// $pg_level_cond)
			// ORDER BY a.sReqmtId DESC, b.cMandate";

			$stmt = $mysqli->prepare("SELECT cEduCtgId_1, cEduCtgId_2, a.sReqmtId, c.vQualSubjectDesc, c.cQualSubjectId, b.cMandate, b.mutual_ex, b.cQualGradeId, b.iQualGradeRank, a.iBeginLevel
			FROM criteriadetail a, criteriasubject b, qualsubject c
			WHERE a.cCriteriaId = b.cCriteriaId
			AND a.cProgrammeId = b.cProgrammeId
			AND a.sReqmtId = b.sReqmtId
			AND b.cQualSubjectId = c.cQualSubjectId
			AND a.cCriteriaId = ?
			AND a.cDelFlag = 'N'
			AND b.cDelFlag = 'N'
			$child_qry
			AND ((a.iBeginLevel = $level 
			$sReqmtId_qry)
			$pg_level_cond)
			ORDER BY a.sReqmtId DESC, b.cMandate");
			$stmt->bind_param("s", $_REQUEST['cFacultyId7']);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($cEduCtgId_1, $cEduCtgId_2, $sReqmtId, $vQualSubjectDesc, $cQualSubjectId, $cMandate, $mutual_ex, $cQualGradeId, $iQualGradeRank, $iBeginLevel);
			
			$cnt = 0;
			$number_of_compusl_sbj_found = 0;
			$compulsory_subjects_with_low_graded = '';

			$compulsory_subjects_not_found = '';
			$available_comp_sbj = 0;

			$number_of_optional_sbj_found = 0;
			$alt_no = '';

			$mutual_ex_comp_list = '';
			$prev_cEduCtgId_2 = '';
			//$cand_cbj_list = '';

			while($stmt->fetch())		
			{
				
				if ($prev_cEduCtgId_2 <> '' && $prev_cEduCtgId_2 <> $cEduCtgId_2)
				{
					$available_comp_sbj = 0;
					$number_of_optional_sbj_found = 0;
				}

				if ($_REQUEST["cFacultyId7"] == 'HSC')
				{
					if ($level == 200)
					{
						$expected_min_num_of_subject = 5;
					}
				}else if ($level == 100)
				{
					$expected_min_num_of_subject = 5;
				}else if ($level >= 700 || $cEduCtgId_2 == 'ELZ' || $cEduCtgId_2 == 'PSX' || $cEduCtgId_2 == 'PSZ' || $cEduCtgId_2 == 'PGX' || $cEduCtgId_2 == 'PGY' || $cEduCtgId_2 == 'PRX' || $cEduCtgId_2 == 'PGZ')
				{
					$expected_min_num_of_subject = 1;
				}else
				{
					$expected_min_num_of_subject = 2;
				}

				if ($cMandate == 'C')
				{
					if ($mutual_ex <> 0)
					{
						if (is_bool(strpos($mutual_ex_comp_list, $mutual_ex)))
						{
							$mutual_ex_comp_list .= $mutual_ex.',';
							$available_comp_sbj++;
						}
					}else
					{
						$available_comp_sbj++;
					}
				}
				
				//echo ++$cnt.' '.$cEduCtgId_1.', '.$cEduCtgId_2.', '.$sReqmtId.', '.$vQualSubjectDesc.', '.$cQualSubjectId.', '.$cMandate.', '.$mutual_ex.', '.$cQualGradeId.', '.$iQualGradeRank.', '.$iBeginLevel.'<br>';
				
				$cNouSubjectId = '';
				$iGradeRank = '';
				$cQualGradeCode = '';

				if ($_REQUEST["cFacultyId7"] == 'HSC')
				{
					if ($level == 200)
					{
						$sub_qry = " AND a.cEduCtgId LIKE 'OL%'";
					}
				}else if($iBeginLevel == 100)
				{
					$sub_qry = " AND a.cEduCtgId LIKE 'OL%'";
				}else
				{
					$sub_qry = " AND a.cEduCtgId = '$cEduCtgId_2'";
				}

				$stmt_chk_cand_c_sbjts_1 = $mysqli->prepare("SELECT cNouSubjectId, a.iGradeRank, b.cQualGradeCode
				FROM afnqualsubject a, qualgrade b
				WHERE vApplicationNo = ?
				AND a.cNouGradeId = b.cQualGradeId
				$sub_qry
				AND cNouSubjectId = '$cQualSubjectId'");
				$stmt_chk_cand_c_sbjts_1->bind_param("s", $_REQUEST['vApplicationNo']);
				$stmt_chk_cand_c_sbjts_1->execute();
				$stmt_chk_cand_c_sbjts_1->store_result();
				$stmt_chk_cand_c_sbjts_1->bind_result($cNouSubjectId, $iGradeRank, $cQualGradeCode);
				$stmt_chk_cand_c_sbjts_1->fetch();
				$stmt_chk_cand_c_sbjts_1->close();
				
				//if applicant does not have qual
				if ($cMandate == 'C')
				{
					if ($cNouSubjectId == '')
					{
						
						if ($mutual_ex <> 0)
							{
								$compulsory_subjects_not_found .= $vQualSubjectDesc.'(Comp. Alt.), ';
							}else
							{
								$compulsory_subjects_not_found .= $vQualSubjectDesc.', ';
							}
						
						if (is_bool(strpos($compulsory_subjects_not_found_0, $vQualSubjectDesc)))
						{
							if ($mutual_ex <> 0)
							{
								$compulsory_subjects_not_found_0 .= $vQualSubjectDesc.'(Comp. Alt.), ';
							}else
							{
								$compulsory_subjects_not_found_0 .= $vQualSubjectDesc.', ';
							}
						}

						if ($mutual_ex == 0)
						{
							continue;
						}
					}else if ($iGradeRank < $iQualGradeRank)
					{
						$compulsory_subjects_with_low_graded .= $vQualSubjectDesc.', ';

						if (is_bool(strpos($compulsory_subjects_with_low_graded_0, $vQualSubjectDesc)))
						{
							$compulsory_subjects_with_low_graded_0 .= $vQualSubjectDesc.', ';
						}
					}
				}

				if ($cNouSubjectId <> '' && $iGradeRank >= $iQualGradeRank)
				{
					if ($cMandate == 'C')
					{
						if ($mutual_ex <> 0)
						{							
							if (is_bool(strpos($alt_no, $mutual_ex)))
							{
								$alt_no .= $mutual_ex;
								$number_of_compusl_sbj_found++;

								//$cand_cbj_list .= $vQualSubjectDesc.', ';
							}
						}else
						{
							$number_of_compusl_sbj_found++;

							//$cand_cbj_list .= $vQualSubjectDesc.', ';
						}
					}else
					{
						if ($mutual_ex <> 0)
						{
							if (is_bool(strpos($alt_no, $mutual_ex)))
							{
								$alt_no .= $mutual_ex;
								$number_of_optional_sbj_found++;
							}
						}else
						{
							$number_of_optional_sbj_found++;
						}
					}
				}
				
				if ($available_comp_sbj > 0)
				{
					if ($number_of_compusl_sbj_found == $available_comp_sbj && 
					($number_of_optional_sbj_found + $number_of_compusl_sbj_found) >= $expected_min_num_of_subject)
					{						
						if ($iBeginLevel == 100 &&  substr($cProgrammeId,0,3) == 'HSC')
						{
							if (is_bool(strpos($detail_of_seleted_prog_1, $sReqmtId.'200'.$cProgrammeId)))
							{
								$detail_of_seleted_prog_1 .= $sReqmtId.'200'.$cProgrammeId.'~';
							}							
						}else
						{
							if (is_bool(strpos($detail_of_seleted_prog_1, $sReqmtId.$iBeginLevel.$cProgrammeId)))
							{
								$detail_of_seleted_prog_1 .= $sReqmtId.$iBeginLevel.$cProgrammeId.'~';
							}							
							//echo $sReqmtId.$iBeginLevel.$cProgrammeId.'~'.'<br>';
						}

						break;
					}
				}else
				{
					if ($number_of_optional_sbj_found >= $expected_min_num_of_subject)
					{
						if ($iBeginLevel == 100 && substr($cProgrammeId,0,3) == 'HSC')
						{
							if (is_bool(strpos($detail_of_seleted_prog_1, $sReqmtId.'200'.$cProgrammeId)))
							{
								$detail_of_seleted_prog_1 .= $sReqmtId.'200'.$cProgrammeId.'~';
							}
						}else
						{
							if (is_bool(strpos($detail_of_seleted_prog_1, $sReqmtId.$iBeginLevel.$cProgrammeId)))
							{
								$detail_of_seleted_prog_1 .= $sReqmtId.$iBeginLevel.$cProgrammeId.'~';
							}
							//echo $sReqmtId.$iBeginLevel.$cProgrammeId.'~'.'<br>';
						}

						break;
					}
				}
				$prev_cEduCtgId_2 = $cEduCtgId_2;
			}
			$stmt->close();

			//echo $cand_cbj_list.'<br>';
		}
	}

	if ($detail_of_seleted_prog_1 == '')
	{
		if ($compulsory_subjects_not_found_0 <> '')
		{
			echo "Lacks ".$compulsory_subjects_not_found_0.'<br>';
		}else if ($compulsory_subjects_not_found <> '')
		{
			echo "Lacks ".$compulsory_subjects_not_found.'<br>';
		}

		if ($compulsory_subjects_with_low_graded_0 <> '')
		{
			echo "Lacks minimum grade in ".$compulsory_subjects_with_low_graded_0.'<br>';
		}else if ($compulsory_subjects_with_low_graded <> '')
		{
			echo "Lacks minimum grade in ".$compulsory_subjects_with_low_graded.'<br>';
		}
	}else if (!is_bool(strpos($higher_qual_status, "Lack")))
	{
		echo "Lacks higher qualification ".'<br>';
	}else
	{
		echo $detail_of_seleted_prog_1.'<p>';
	}
}


function check_higher_level_qual($level, $child_qry, $cProgrammeId)
{
	$mysqli = link_connect_db();
	
	$expected_min_num_of_subject = 0;
	$detail_of_seleted_prog_1 = '';

	$stmt = $mysqli->prepare("SELECT cEduCtgId_1, cEduCtgId_2, a.sReqmtId, c.vQualSubjectDesc, c.cQualSubjectId, b.cMandate, b.mutual_ex, b.cQualGradeId, b.iQualGradeRank, a.iBeginLevel
	FROM criteriadetail a, criteriasubject b, qualsubject c
	WHERE a.cCriteriaId = b.cCriteriaId
	AND a.cProgrammeId = b.cProgrammeId
	AND a.sReqmtId = b.sReqmtId
	AND b.cQualSubjectId = c.cQualSubjectId
	AND a.cDelFlag = 'N'
	AND b.cDelFlag = 'N'
	$child_qry
	AND cEduCtgId_2 <> ''
	AND a.cProgrammeId = '$cProgrammeId'
	AND a.iBeginLevel = $level
	ORDER BY a.sReqmtId DESC, b.cMandate");
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cEduCtgId_1, $cEduCtgId_2, $sReqmtId, $vQualSubjectDesc, $cQualSubjectId, $cMandate, $mutual_ex, $cQualGradeId, $iQualGradeRank, $iBeginLevel);
	
	$cnt = 0;
	$number_of_compusl_sbj_found = 0;
	$compulsory_subjects_with_low_graded = '';

	$compulsory_subjects_not_found = '';
	$available_comp_sbj = 0;

	$number_of_optional_sbj_found = 0;
	$alt_no = '';

	$mutual_ex_comp_list = '';

	$prev_cEduCtgId_2 = '';
	
	while($stmt->fetch())		
	{
		if ($prev_cEduCtgId_2 <> '' && $prev_cEduCtgId_2 <> $cEduCtgId_2)
		{
			$available_comp_sbj = 0;
			$number_of_optional_sbj_found = 0;
		}
		
		if ($level >= 700 || $cEduCtgId_2 == 'ELZ' || $cEduCtgId_2 == 'PSX' || $cEduCtgId_2 == 'PSZ' || $cEduCtgId_2 == 'PGX' || $cEduCtgId_2 == 'PGY' || $cEduCtgId_2 == 'PRX' || $cEduCtgId_2 == 'PGZ')
		{
			$expected_min_num_of_subject = 1;
		}else
		{
			$expected_min_num_of_subject = 2;
		}

		
		//echo ++$cnt.' '.$cEduCtgId_1.', '.$cEduCtgId_2.', '.$sReqmtId.', '.$vQualSubjectDesc.', '.$cQualSubjectId.', '.$cMandate.', '.$mutual_ex.', '.$cQualGradeId.', '.$iQualGradeRank.', '.$iBeginLevel.'<br>';

		if ($cMandate == 'C')
		{
			if ($mutual_ex <> 0)
			{
				if (is_bool(strpos($mutual_ex_comp_list, $mutual_ex)))
				{
					$mutual_ex_comp_list .= $mutual_ex.',';
					$available_comp_sbj++;
				}
			}else
			{
				$available_comp_sbj++;
			}
		}


		$cNouSubjectId = '';
		$iGradeRank = '';
		$cQualGradeCode = '';

		$sub_qry = " AND a.cEduCtgId = '$cEduCtgId_2'";

		$stmt_chk_cand_c_sbjts_1 = $mysqli->prepare("SELECT cNouSubjectId, a.iGradeRank, b.cQualGradeCode
		FROM afnqualsubject a, qualgrade b
		WHERE vApplicationNo = ?
		AND a.cNouGradeId = b.cQualGradeId
		$sub_qry
		AND cNouSubjectId = '$cQualSubjectId'");
		$stmt_chk_cand_c_sbjts_1->bind_param("s", $_REQUEST['vApplicationNo']);
		$stmt_chk_cand_c_sbjts_1->execute();
		$stmt_chk_cand_c_sbjts_1->store_result();
		$stmt_chk_cand_c_sbjts_1->bind_result($cNouSubjectId, $iGradeRank, $cQualGradeCode);
		$stmt_chk_cand_c_sbjts_1->fetch();
		$stmt_chk_cand_c_sbjts_1->close();
		
		//if applicant does not have qual
		if ($cMandate == 'C')
		{
			if ($cNouSubjectId == '')
			{
				$compulsory_subjects_not_found .= $vQualSubjectDesc.', ';
				if ($mutual_ex == 0)
				{
					continue;
				}
			}else if ($iGradeRank < $iQualGradeRank)
			{
				$compulsory_subjects_with_low_graded .= $vQualSubjectDesc.', ';
			}
		}

		if ($cNouSubjectId <> '' && $iGradeRank >= $iQualGradeRank)
		{
			if ($cMandate == 'C')
			{
				if ($mutual_ex <> 0)
				{							
					if (is_bool(strpos($alt_no, $mutual_ex)))
					{
						$alt_no .= $mutual_ex;
						$number_of_compusl_sbj_found++;

						//$cand_cbj_list .= $vQualSubjectDesc.', ';
					}
				}else
				{
					$number_of_compusl_sbj_found++;

					//$cand_cbj_list .= $vQualSubjectDesc.', ';
				}
			}else
			{
				if ($mutual_ex <> 0)
				{
					if (is_bool(strpos($alt_no, $mutual_ex)))
					{
						$alt_no .= $mutual_ex;
						$number_of_optional_sbj_found++;
					}
				}else
				{
					$number_of_optional_sbj_found++;
				}
			}
		}

		if ($available_comp_sbj > 0)
		{
			if ($number_of_compusl_sbj_found == $available_comp_sbj && 
			($number_of_optional_sbj_found + $number_of_compusl_sbj_found) >= $expected_min_num_of_subject)
			{
				if ($iBeginLevel == 100 && substr($cProgrammeId,0,3) == 'HSC')
				{
					if (is_bool(strpos($detail_of_seleted_prog_1, $sReqmtId.'200'.$cProgrammeId)))
					{
						$detail_of_seleted_prog_1 .= $sReqmtId.'200'.$cProgrammeId.'~';
					}							
				}else
				{
					if (is_bool(strpos($detail_of_seleted_prog_1, $sReqmtId.$iBeginLevel.$cProgrammeId)))
					{
						$detail_of_seleted_prog_1 .= $sReqmtId.$iBeginLevel.$cProgrammeId.'~';
					}							
					//echo $sReqmtId.$iBeginLevel.$cProgrammeId.'~'.'<br>';
				}

				break;
			}
		}else
		{
			if ($number_of_optional_sbj_found >= $expected_min_num_of_subject)
			{
				if ($iBeginLevel == 100 && substr($cProgrammeId,0,3) == 'HSC')
				{
					if (is_bool(strpos($detail_of_seleted_prog_1, $sReqmtId.'200'.$cProgrammeId)))
					{
						$detail_of_seleted_prog_1 .= $sReqmtId.'200'.$cProgrammeId.'~';
					}
				}else
				{
					if (is_bool(strpos($detail_of_seleted_prog_1, $sReqmtId.$iBeginLevel.$cProgrammeId)))
					{
						$detail_of_seleted_prog_1 .= $sReqmtId.$iBeginLevel.$cProgrammeId.'~';
					}
					//echo $sReqmtId.$iBeginLevel.$cProgrammeId.'~'.'<br>';
				}

				break;
			}
		}
		$prev_cEduCtgId_2 = $cEduCtgId_2;
	}
	$stmt->close();

	

	if ($detail_of_seleted_prog_1 == '')
	{
		return "Lacks higher qualification";
	}else
	{
		return $detail_of_seleted_prog_1.'<p>';
	}
}


function get_qry_part($part, $faculty, $dept, $program, $level)
{
	$sReqmtId_qry = '';
	
	$child_qry = '';

	$begin_level = '';
	
	
	if ($faculty == 'AGR')
	{
		//$child_qry = " AND (a.cProgrammeId = 'AGR201' OR a.cProgrammeId LIKE '%$program%') ";
		// if ($level >= 700)
		// {
		//     if ($dept == 'ENG')
		//     {
		//         $child_qry = " AND (a.cProgrammeId = 'ART201' OR a.cProgrammeId LIKE '%$program%') ";
		//     }else if ($dept == 'RST')
		//     {
		//         $child_qry = " AND (a.cProgrammeId LIKE '%ART208%' OR a.cProgrammeId LIKE '%ART209%' OR a.cProgrammeId LIKE '%ART210%' OR a.cProgrammeId LIKE '%$program%') ";
		//     }
		// }              
	}else if ($faculty == 'ART')
	{
		if ($level >= 700)
		{
			if ($dept == 'ENG')
			{
				$child_qry = " AND (a.cProgrammeId = 'ART201' OR a.cProgrammeId LIKE '%$program%') ";
			}else if ($dept == 'RST')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%ART208%' OR a.cProgrammeId LIKE '%ART209%' OR a.cProgrammeId LIKE '%ART210%' OR a.cProgrammeId LIKE '%$program%') ";
			}
		}              
	}else if ($faculty == 'EDU')
	{
		if ($level == 700)
		{
			$child_qry = " AND (a.cProgrammeId = 'EDU212' OR a.cProgrammeId LIKE '%$program%') ";
		}else if ($level > 700)
		{
			if ($dept == 'EFO')
			{
				$child_qry = " AND (a.cProgrammeId = 'EDU212' OR a.cProgrammeId LIKE '%$program%') ";
			}else  if ($dept == 'SED')
			{
				$child_qry = " AND (a.cProgrammeId = 'EDU212' OR a.cProgrammeId LIKE '%$program%') ";
			}else  if ($dept == 'MED')
			{                            
				$child_qry = " AND (a.cProgrammeId = 'EDU203' OR a.cProgrammeId LIKE '%EDU401%' OR a.cProgrammeId LIKE '%$program%') ";
				
			}
		}
	}else if ($faculty == 'HSC')
	{
		$begin_level = 200;
		if ($dept == 'EHS')
		{
			$child_qry = " AND (a.cProgrammeId LIKE '%$program%') ";

			if ($program == 'HSC201')
			{
				$sReqmtId_qry = " AND a.sReqmtId = 16";
				$child_qry = " AND (a.cProgrammeId = 'HSC201' OR a.cProgrammeId LIKE '%$program%') ";
			}                     
		}else if ($dept == 'PHE')
		{
			if ($level >= 700)
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%HSC203%' OR a.cProgrammeId LIKE '%$program%') ";
			}
		}
	}else if ($faculty == 'MSC')
	{
		if ($level >= 700)
		{
			if ($dept == 'BUS')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%MSC201%' OR a.cProgrammeId LIKE '%$program%') ";
				if ($program == 'MSC401' || $program == 'MSC402' || $program == 'MSC408' || $program == 'MSC409' || $program == 'MSC410' || $program == 'MSC411' || $program == 'MSC412' || $program == 'MSC413')
				{
					$child_qry = " AND (a.cProgrammeId LIKE '%MSC203%' OR a.cProgrammeId LIKE '%$program%') ";
				}
			}else if ($dept == 'ENT')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%MSC209%' OR a.cProgrammeId LIKE '%$program%') ";
			}else if ($dept == 'PAD')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%MSC204%' OR a.cProgrammeId LIKE '%$program%') ";
			}
		}else
		{
			if ($dept == 'BUS')
			{
				//$child_qry = " AND (a.cProgrammeId LIKE '%MSC201%' OR a.cProgrammeId LIKE '%$program%') ";
			}else if ($dept == 'ENT')
			{
				//$child_qry = " AND (a.cProgrammeId LIKE '%MSC206%' OR a.cProgrammeId LIKE '%$program%') ";

				if ($program == "MSC204" /*&& $level == 100*/)
				{
					$cEduCtgId_2_qry = "b.cEduCtgId";

					//if ($level == 100)
					//{
						$ordering = "ORDER BY $cEduCtgId_2_qry  DESC, b.cMandate, c.vQualSubjectDesc";
					//}
				}
			}else if ($dept == 'PAD')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%$program%') ";
			}
		}
	}else if ($faculty == 'CMP')
	{
		$child_qry = " AND (a.cProgrammeId LIKE '%$program%') ";
	}else if ($faculty == 'SCI')
	{
		$child_qry = " AND (a.cProgrammeId LIKE '%$program%') ";
	}else if ($faculty == 'SSC')
	{
		if ($level >= 700)
		{
			if ($dept == 'CSS')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%SSC201%' OR a.cProgrammeId LIKE '%$program%') ";
			}else  if ($dept == 'ECO')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%SSC201%' OR a.cProgrammeId LIKE '%$program%') ";
			}else  if ($dept == 'MAC')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%SSC207%' OR a.cProgrammeId LIKE '%$program%') ";
			}else  if ($dept == 'PSC')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%SSC208%' OR a.cProgrammeId LIKE '%$program%') ";
			}
		}else
		{
			if ($dept == 'CSS')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%SSC211%' OR a.cProgrammeId LIKE '%$program%') ";
			}else  if ($dept == 'ECO')
			{
				//$child_qry = " AND (a.cProgrammeId LIKE '%SSC201%' OR a.cProgrammeId LIKE '%$program%') ";
			}else  if ($dept == 'MAC')
			{
				// if ($level >= 700)
				// {
				//     $child_qry = " AND (a.cProgrammeId LIKE '%SSC204%' OR a.cProgrammeId LIKE '%$program%') ";
				// }
			}
		}
	}else if ($faculty == 'LAW')
	{
		$child_qry = " AND (a.cProgrammeId LIKE '%LAW201%' OR a.cProgrammeId LIKE '%$program%') ";
		if ($dept == 'LED')
		{
			$child_qry = " AND (a.cProgrammeId LIKE '%LAW202%' OR a.cProgrammeId LIKE '%$program%') ";
		}
	}

	if ($part == 0)
	{
		return $sReqmtId_qry;
	}else if ($part == 1)
	{
		return $child_qry;
	}else if ($part == 2)
	{
		return $begin_level;
	}
}


function check_credit($minFee, $semBeginDate, $cAcademicDesc)
{
	$mysqli = link_connect_db();
	
	$stmt = $mysqli->prepare("SELECT b.ResponseCode 
	from s_tranxion_cr a, remitapayments b 
	where a.vMatricNo = b.Regno 
	and a.MerchantReference = b.MerchantReference 
	and a.vMatricNo = ? 
	and a.amount >= $minFee 
	and cTrntype = 'c' 
	and a.tdate >= '$semBeginDate' 
	and a.cAcademicDesc = '$cAcademicDesc'");
	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt->execute();
	$stmt->store_result();
	
	if ($stmt->num_rows > 0)
	{
		$stmt->bind_result($ResponseCode);
		$stmt->fetch();
		return $ResponseCode;
	}else
	{
		return 0;
	}
}


function passport_loaded($vApplicationNo)
{
	$mysqli = link_connect_db();
	
	$stmt = $mysqli->prepare("SELECT vApplicationNo from pics where cinfo_type = 'p' and vApplicationNo = ?");		
	$stmt->bind_param("s", $vApplicationNo);
	$stmt->execute();
	$stmt->store_result();
	$num = $stmt->num_rows;
	$stmt->close();
	
	return $num;
}


function birthcert_loaded($vApplicationNo)
{
	$mysqli = link_connect_db();
	
	$stmt = $mysqli->prepare("SELECT vApplicationNo from pics where cinfo_type = 'b' and vApplicationNo = ?");		
	$stmt->bind_param("s", $vApplicationNo);
	$stmt->execute();
	$stmt->store_result();
	$num = $stmt->num_rows;
	$stmt->close();
	
	return $num;
}


function credential_loaded($vApplicationNo, $cQualCodeId, $vExamNo)
{
	$mysqli = link_connect_db();
	
	$stmt = $mysqli->prepare("SELECT vApplicationNo from pics where cinfo_type = 'c' and vApplicationNo = ? AND cQualCodeId = ? AND vExamNo = ?");		
	$stmt->bind_param("sss", $vApplicationNo, $cQualCodeId, $vExamNo);
	$stmt->execute();
	$stmt->store_result();
	$num = $stmt->num_rows;
	$stmt->close();
	
	return $num;
}


function track_sent_mail($vApplicationNo, $towho, $stringpattern, $uniquesentdata)
{
	$mysqli = link_connect_db();
	
	$search = "{$stringpattern}%";
	
	$stmt = $mysqli->prepare("SELECT sum(numbersent)
	FROM trackmail a, trackmailsbj b 
	WHERE a.mailsubjectcode = b.mailsubjectcode
	AND mailsubject LIKE ?
	AND vApplicationNo = ?
	AND towho = ? 
	AND uniquesentdata = ?");
	$stmt->bind_param("ssss", $search, $vApplicationNo, $towho, $uniquesentdata);
	$stmt->execute();
	if ($stmt->num_rows > 0)
	{
		$stmt->bind_result($numbersent);
		$stmt->fetch();

		if ($numbersent >= 4){return;}
	}
	$stmt->close();
	
	$stmt = $mysqli->prepare("SELECT numbersent+1, a.mailsubjectcode
	FROM trackmail a, trackmailsbj b 
	WHERE a.mailsubjectcode = b.mailsubjectcode
	AND mailsubject LIKE ?
	AND vApplicationNo = ?
	AND towho = ? 
	AND uniquesentdata = ? 
	ORDER BY numbersent DESC LIMIT 1");
	$stmt->bind_param("ssss", $search, $vApplicationNo, $towho, $uniquesentdata);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($numbersent, $mailsubjectcode);

	if ($stmt->num_rows > 0)
	{
		$stmt->fetch();
		if ($numbersent >= 4){return;}
	}else
	{
		$numbersent = 1;
		$search = "{$stringpattern}%";

		$stmt1 = $mysqli->prepare("SELECT mailsubjectcode
		FROM trackmailsbj
		WHERE mailsubject LIKE ?");
		$stmt1->bind_param("s", $search);
		$stmt1->execute();
		$stmt1->store_result();
		$stmt1->bind_result($mailsubjectcode);
		$stmt1->fetch();
		$stmt1->close();
	}

	$stmt1 = $mysqli->prepare("REPLACE INTO trackmail 
	SET vApplicationNo = ?,
	mailsubjectcode = '".$mailsubjectcode."',
	towho = ?,
	uniquesentdata = ?,
	numbersent = $numbersent,
	senddate = NOW()");		
	$stmt1->bind_param("sss", $vApplicationNo, $towho, $uniquesentdata);
	$stmt1->execute();
	$stmt1->close();

	$stmt->close();
}


function cleanData(&$str)
{
	$str = $str ?? '';
	
	$str = preg_replace("/\t/", "\\t", $str);
	$str = preg_replace("/\r?\n/", "\\n", $str);
	if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}


function buildSheet($data)
{
	$flag = false;
	foreach($data as $row)
	{
		if(!$flag)
		{
			// display field/column names as first row
			echo implode("\t", array_keys($row)) . "\n";
			$flag = true;
		}
		array_walk($row, __NAMESPACE__ . '\cleanData');
		echo implode("\t", array_values($row)) . "\n";
	}
}


function find_date_diff($start_date, $end_date, $formatreturn) 
{
	error_reporting(0);

	list($date, $time) = explode(' ', $start_date);
	if ($time == null) {
			$time = '00:00:00';
	}
	if ($date == null) {
			$date = date("Y-m-d");
	}
	$startdate = explode("-", $date);
	$starttime = explode(":", $time);
	list($date, $time) = explode(' ', $end_date);
	if ($time == null) {
			$time = '00:00:00';
	}
	if ($date == null) {
			$date = date("Y-m-d");
	}
	$enddate = explode("-", $date);
	$endtime = explode(":", $time);

	$secons_dif = mktime($endtime[0], $endtime[1], $endtime[2], $enddate[1], $enddate[2], $enddate[0]) - mktime($starttime[0], $starttime[1], $starttime[2], $startdate[1], $startdate[2], $startdate[0]);
	switch ($formatreturn) {
			//In Millisecond:
			case 'milliseconds':
				$choice = $secons_dif * 1000;
				break;
				//In Seconds:
			case 'seconds':
					$choice = $secons_dif;
					break;
			//In Minutes:
			case 'minutes':
					$choice = floor($secons_dif / 60);
					break;
			//In Hours:
			case 'hours':
					$choice = floor($secons_dif / 60 / 60);
					break;
			//In days:
			case 'days':
					$choice = floor($secons_dif / 60 / 60 / 24);
					break;
			//In weeks:
			case 'weeks':
					$choice = floor($secons_dif / 60 / 60 / 24 / 7);
					break;
			//In Months:
			case 'months':
					$choice = floor($secons_dif / 60 / 60 / 24 / 7 / 4);
					break;
			//In years:
			case 'years':
					$choice = floor($secons_dif / 365 / 60 / 60 / 24);
					break;
	}
	$choice;

	error_reporting(1);

	return $choice;
}



function wallet_bal1()
{
	$mysqli = link_connect_db();

	$balance = 0;
	$id = '';
	if (isset($_REQUEST['vMatricNo']) && $_REQUEST['vMatricNo'] <> '')
	{
	    $id = $_REQUEST['vMatricNo'];
	}else if (isset($_REQUEST['uvApplicationNo']) && $_REQUEST['uvApplicationNo'] <> '')
	{
	    $id = $_REQUEST['uvApplicationNo'];
	}

	$orgsetins = settns();
	$semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);	
	$account_close_date = substr($orgsetins['ac_close_date'],4,4).'-'.substr($orgsetins['ac_close_date'],2,2).'-'.substr($orgsetins['ac_close_date'],0,2);
	$account_open_date = substr($orgsetins['ac_open_date'],4,4).'-'.substr($orgsetins['ac_open_date'],2,2).'-'.substr($orgsetins['ac_open_date'],0,2);		
	$wrking_year_tab = WORKING_YR_TABLE;
	//$account_close_date = '2024-08-31';
	//$wrking_year_tab = 's_tranxion_20242025';
	

	$stmt_b = $mysqli->prepare("SELECT n_balance, actual_balance, narata
	FROM s_tranxion_prev_bal1
	WHERE vMatricNo = ?;");							
	$stmt_b->bind_param("s", $id);
	$stmt_b->execute();
	$stmt_b->store_result();
	$stmt_b->bind_result($Amount_bal, $aAmount_bal, $narata);
	$stmt_b->fetch();
	
	if (is_null($Amount_bal))
	{	
		$Amount_bal = 0.00;
	}

	$stmt_b = $mysqli->prepare("SELECT SUM(amount)
	FROM s_tranxion_cr
	WHERE (tdate >= '$semester_begin_date' AND tdate <= '$account_close_date')
	AND vMatricNo = ?;");							
	$stmt_b->bind_param("s", $id);
	$stmt_b->execute();
	$stmt_b->store_result();
	$stmt_b->bind_result($old_cr_bal);
	$stmt_b->fetch();

	if (is_null($old_cr_bal))
	{
		$old_cr_bal = 0.00;
	}

	
	$stmt_b = $mysqli->prepare("SELECT SUM(amount)
	FROM $wrking_year_tab
	WHERE (tdate >= '$semester_begin_date' AND tdate <= '$account_close_date')
	AND cCourseId NOT LIKE 'F0%'
	AND trans_count IS NOT NULL
	AND vMatricNo = ?;");							
	$stmt_b->bind_param("s", $id);
	$stmt_b->execute();
	$stmt_b->store_result();
	$stmt_b->bind_result($old_dr_bal);
	$stmt_b->fetch();
	$stmt_b->close();

	if (is_null($old_dr_bal))
	{
		$old_dr_bal = 0.00;
	}
	
	$Amount_bal = $Amount_bal + ($old_cr_bal - $old_dr_bal);

	return $Amount_bal;
}



function wallet_bal()
{
	$mysqli = link_connect_db();

	$balance = 0;
	$id = '';
	if (isset($_REQUEST['vMatricNo']) && $_REQUEST['vMatricNo'] <> '')
	{
	    $id = $_REQUEST['vMatricNo'];
	}else if (isset($_REQUEST['uvApplicationNo']) && $_REQUEST['uvApplicationNo'] <> '')
	{
	    $id = $_REQUEST['uvApplicationNo'];
	}
	
	
	$stmt = $mysqli->prepare("select  SUM(`amount`) 
	from s_tranxion_cr
	where vMatricNo = ?");
	$stmt->bind_param("s", $id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($Amount_a);
	$stmt->fetch();
	
	if(substr($id,3,2) <= 19)
	{
		//$tables = '20172019,20202021,20222023,20242025';
		$tables = '2017,2018,2019,20202021,20222023,20242025';
	}else if(substr($id,3,2) == 20 || substr($id,3,2) == 21)
	{
		$tables = '20202021,20222023,20242025';
	}else if(substr($id,3,2) == 22 || substr($id,3,2) == 23)
	{
		$tables = '20222023,20242025';
	}else
	{
		$tables = '20242025';
	}
	
	
	$table = explode(",", $tables);

    $wallet_trn_cnt = 0;
    
    foreach ($table as &$value)
    {
        $wrking_tab = 's_tranxion_'.$value;
	
    	$stmt = $mysqli->prepare("select  SUM(`amount`) 
    	from $wrking_tab
    	where vMatricNo = ?");
    	$stmt->bind_param("s", $id);
    	$stmt->execute();
    	$stmt->store_result();
    	$stmt->bind_result($Amount_b);
    	$stmt->fetch();
    	
    	$Amount_a -= $Amount_b;
    }
	$stmt->close();
	
	return $Amount_a;
}


function do_service_mode_centre($v_which, $id)
{
	$mysqli = link_connect_db();

	$trg = '|';
	$num_of = 0;
	if ($v_which == '1')
	{
		$stmt = $mysqli->prepare("SELECT study_mode_ID
		FROM user_mode 
		WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->store_result();
		$num_of = $stmt->num_rows;
		$stmt->bind_result($study_mode_ID);
		while ($stmt->fetch())
		{
			$trg .= $study_mode_ID.'|';
		}
		$stmt->close();
	}else if ($v_which == '2')
	{
		$stmt = $mysqli->prepare("SELECT cStudyCenterId
		FROM user_centre 
		WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->store_result();
		$num_of = $stmt->num_rows;
		$stmt->bind_result($cStudyCenterId);
		while ($stmt->fetch())
		{
			$trg .= $cStudyCenterId.'|';
		}
		$stmt->close();
	}
		
	return str_pad($num_of, 10).$trg;
}


function do_toup_div_prns($section)
{?>
	<a id="registered_student" href="#" style="display:none" 
		onclick="nxt.mm.value=0;nxt.sm.value=''; false">
		Faculty student
	</a>
	<div id="top" class="top_hed_prns" style="margin-top:8px; position:relative;">
		<div style="float:left; width:45px; height:inherit;">
			<img src="./img/left_side_logo.png"  width="90%" height="90%" style="padding: 2%";/>
		</div>
		
		<div style="float:left; width:93%; text-align:left; height:auto; position:relative; font-size:x-large; color:#008000;">
			National Open University of Nigeria
			<div style="float:right; width:auto; height:auto; position:absolute; top: 30px; left:230px; color:#e31e24; font-size:12px;">
				Learn at any place at your pace...
			</div>
			<div style="width:auto; height:auto; position:absolute; top: 0px; right: 0px; color:#008000; font-size:11px">
				<?php echo $section;?>
			</div>
		</div>

		<!--<div style="float:left; width:84%; height:inherit; position:relative; font-size:x-large; text-align:left; color:#008000; background:#ccc">
			National Open University of Nigeria
			<div style="float:right; width:auto; height:auto; position:absolute; top: 30px; right: 40%; color:#FF3300; font-size:9px; background:#c0c;">
				Learn at any place at your pace
			</div>
			<div style="float:right; width:auto; height:auto; position:absolute; bottom: 5px; right: 0px; color:#FF3300; font-size:9px;">
				<?php echo $section;?>
			</div>
		</div>

		<div style="float:left; text-align:right; width:auto; height:auto; position:absolute; top: 5px; right: 5px; color:#FF3300; font-size:small"><?php
			if (isset($_REQUEST['user_cat']))
			{
				/*if ($_REQUEST['user_cat'] == '1' || $_REQUEST['user_cat'] == '3')
				{
					echo 'Applicant';
				}else if ($_REQUEST['user_cat'] == '4')
				{
					echo $_REQUEST['user_cat'];
				}else if ($_REQUEST['user_cat'] == '5')
				{
					echo $_REQUEST['user_cat'];
				}else if ($_REQUEST['user_cat'] == '6')
				{
					echo 'Staff section';
				}*/
			}else
			{
				echo 'Home';
			}?>
		</div>-->
	</div><?php
}


function do_toup_div()
{?>

	<a id="registered_student" href="#" style="display:none" 
		onclick="nxt.mm.value=0;nxt.sm.value=''; false">
		Faculty student
	</a>
	<div id="top" class="top_hed" style="position:relative;">
		<div style="float:left; width:4%; height:100%;">
			<img src="./img/left_side_logo.png" width="90%" height="90%" style="padding: 2%";/>
		</div>
		<div style="float:left; width:auto; height:auto; position:relative; font-size:x-large; color:#008000;">
			National Open University of Nigeria
			<div style="float:right; width:auto; height:auto; position:absolute; top: 30px; right: 0; color:#e31e24; font-size:12px;">
				Learn at any place at your pace...
			</div>
			<div style="float:right; width:auto; height:auto; position:absolute; bottom: 5px; right: 0px; color:#008000; font-size:11px">
				<?php //echo $section;?>
			</div>
		</div><?php
		if (!isset($_REQUEST["hlp"]))
		{
			if (!(isset($_REQUEST["comonboard"]) && $_REQUEST["comonboard"] == 1))
			{?>
				<a href="#" style="text-decoration:none;" 
					onclick="hpg.action='./staff_login_page';hpg.submit();return false">
					<div class="stff_mm_btns_logout" style="float:right; font-size:small">
						Logout
					</div>
				</a><?php
			}?>

			<a href="#" style="text-decoration:none;" 
				onclick="stff_guide_instr.submit();return false">
				<div class="stff_mm_btns_how" style="float:right; margin-right:10px; font-size:small" title="How to do things">
					Help
				</div>
			</a><?php
		}?>

		<div style="float:left; text-align:right; width:auto; height:auto; float:right; margin-right:10px; color:#6b6b6b; font-size:11px;"><?php
			if (isset($_REQUEST['user_cat']) && $_REQUEST['user_cat'] <> '')
			{
				if ($_REQUEST['user_cat'] == '1' || $_REQUEST['user_cat'] == '2' || $_REQUEST['user_cat'] == '3')
				{
					echo 'Application Section';
				}else if ($_REQUEST['user_cat'] == '4' || $_REQUEST['user_cat'] == '5')
				{
					echo 'Student Section';
				}else if ($_REQUEST['user_cat'] == '6')
				{
					if (isset($_REQUEST['username_u']) && $_REQUEST['username_u'] <> '')
					{
						echo $_REQUEST['username_u'];
					}else if (isset($_REQUEST['username']) && $_REQUEST['username'] <> '')
					{
						echo $_REQUEST['username'];
					}
				} 
			}else
			{
				echo '';
			}?>
		</div>
	</div><?php
}


function do_dull_left_side_div()
{?>

	<div id="general_smke_screen" class="smoke_scrn" style="display:none; z-index:-1"></div>
	
	<div id="in_progress" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
		<div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
			Information
		</div>
		<a href="#" style="text-decoration:none;">
			<div id="msg_title" style="width:20px; float:left; text-align:center; padding:0px;"></div>
		</a>
		<div style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#6b6b6b">
			Processing. Please wait...
		</div>
		<div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;"></div>
	</div>


	<div id="on_error" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
		<div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
			Information
		</div>
		<a href="#" style="text-decoration:none;">
			<div style="width:20px; float:left; text-align:center; padding:0px;"></div>
		</a>
		<div id="on_error_msg" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#6b6b6b">
			Your internet connection was interrupted. Please try again
		</div>
		<div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;"></div>
	</div>



	<div id="on_abort" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
		<div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
			Information
		</div>
		<a href="#" style="text-decoration:none;">
			<div style="width:20px; float:left; text-align:center; padding:0px;"></div>
		</a>
		<div style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#6b6b6b">
			Process aborted
		</div>
		<div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;"></div>
	</div>

	<div id="general_caution_box" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF; max-height:70vh; overflow:auto; overflow-x:hidden;  z-index:-1">
		<div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
			Caution
		</div>
		<a href="#" style="text-decoration:none;">
			<div style="width:20px; float:left; text-align:center; padding:0px;"></div>
		</a>
		<div id="general_caution_msg_msg" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#6b6b6b;"></div>
		<div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
			<a href="#" style="text-decoration:none;" 
				onclick="_('general_smke_screen').style.display='none';
				_('general_smke_screen').style.zIndex='-1';
				_('general_caution_box').style.display='none';
				_('general_caution_box').style.zIndex='-1';
				return false">
				<div class="submit_button_brown" style="width:60px; padding:6px; float:right">
					Ok
				</div>
			</a>
		</div>
	</div>



	<!--<div id="general_success_box" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:3">
		<div style="width:350px; float:left; text-align:left; padding:0px; color:#36743e; font-weight:bold">
			Information
		</div>
		<a href="#" style="text-decoration:none;">
			<div id="msg_title" style="width:20px; float:left; text-align:center; padding:0px;"></div>
		</a>
		<div id="general_success_msg_msg" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#36743e;"></div>
		<div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
			<a href="#" style="text-decoration:none;" 
				onclick="_('general_success_box').style.display= 'none';
				_('general_success_box').style.zIndex= '-1';
				_('general_smke_screen').style.display= 'none';
				_('general_smke_screen').style.zIndex= '-1';
				return false">
				<div class="submit_button_home" style="width:60px; padding:6px; float:right">
					Ok
				</div>
			</a>
		</div>
	</div>-->

	<!-- InstanceBeginEditable name="newApplicant" -->
		<div class="insideleftSide_dull" 
			style="margin-top:0%;
			background-image:url(../m/img/quality-control.png);
			background-position: 50% 48%;">
		</div>
	<!-- InstanceEndEditable -->
	
	<!-- InstanceBeginEditable name="newApplicant" -->
		<div class="insideleftSide_dull" 
			style="margin-top:17%;
			background-image:url(../m/img/pay_1.png);
			background-position: 50% 48%;">
		</div>
	<!-- InstanceEndEditable -->	
	
	<!-- InstanceBeginEditable name="newApplicant" -->
		<div class="insideleftSide_dull" 
			style="margin-top:19%;
			background-image:url(../m/img/validate_payment.png);
			background-position: 50% 48%;">
		</div>
	<!-- InstanceEndEditable -->	
	
	<!-- InstanceBeginEditable name="newApplicant" -->
		<div class="insideleftSide_dull" 
			style="margin-top:19%;
			background-image:url(../m/img/registration.png);
			background-position: 50% 48%;">
		</div>
	<!-- InstanceEndEditable -->	
	
	<!-- InstanceBeginEditable name="newApplicant" -->
		<div class="insideleftSide_dull" 
			style="margin-top:19%;
			background-image:url(../m/img/fresh_std.png);
			background-position: 50% 48%;">
		</div>
	<!-- InstanceEndEditable --><?php
}


function do_left_side_div()
{?>
	<!-- InstanceBeginEditable name="newApplicant" --><?php
		if (isset($_REQUEST['side_menu']) && $_REQUEST['side_menu'] == '1')
		{?>
			<div class="insideleftSide_dull" 
				style="margin-top:9%;
				background-image:url(../m/img/quality-control.png);"/>
				<div class="center" style="width:100%; top:80%;">Am I qualified?</div>
			</div><?php
		}else
		{?>
		<a href="#"  style="text-decoration:none" onclick="iamqual.side_menu.value='1'; iamqual.submit(); return false" title="Am I qualified?">
			<div class="insideleftSide" 
				style="margin-top:8%;
				height:16.2%;
				background-image:url(../m/img/quality-control.png);"/>
				<div class="center" style="width:100%; top:80%;">Am I qualified?</div>
			</div>
		</a><?php
		}?>
	<!-- InstanceEndEditable -->
	
	<!-- InstanceBeginEditable name="newApplicant" --><?php
		if (isset($_REQUEST['side_menu']) && $_REQUEST['side_menu'] == '2')
		{?>
			<div class="insideleftSide_dull" 
				style="margin-top:19%;
				background-image:url(../m/img/pay_1.png);"/>
				<div class="center" style="width:100%; top:80%;">Apply for admission</div>
			</div><?php
		}else
		{?>
		<a href="#"  style="text-decoration:none" onclick="sinein.side_menu.value='2'; sinein.submit(); return false" title="Pay for application form">
			<div class="insideleftSide" 
				style="margin-top:13%;
				height:16.4%;
				background-image:url(../m/img/pay_1.png);"/>
				<div class="center" style="width:100%; top:80%;">Apply for admission</div>
			</div>
		</a><?php
		}?>
	<!-- InstanceEndEditable -->	
	
	<!-- InstanceBeginEditable name="newApplicant" --><?php
		if (isset($_REQUEST['side_menu']) && $_REQUEST['side_menu'] == '3')
		{?>
			<div class="insideleftSide_dull" 
				style="margin-top:19%;
				background-image:url(../m/img/validate_payment.png);"/>
				<div class="center" style="width:100%; top:80%;">Continue after payment</div>
			</div><?php
		}else
		{?>
		<a href="#"  style="text-decoration:none" onclick="ep.side_menu.value='3'; ep.submit(); return false" title="Not necessary if you have your application form number and password">
			<div class="insideleftSide" 
				style="margin-top:14%;
				height:16.4%;
				background-image:url(../m/img/validate_payment.png);"/>
				<div class="center" style="width:100%; top:80%;">Continue after payment</div>
			</div>
		</a><?php
		}?>
	<!-- InstanceEndEditable -->	
	
	<!-- InstanceBeginEditable name="newApplicant" --><?php
		if (isset($_REQUEST['side_menu']) && $_REQUEST['side_menu'] == '4')
		{?>
			<div class="insideleftSide_dull" 
				style="margin-top:19%;
				background-image:url(../m/img/registration.png);"/>
				<div class="center" style="width:100%; top:80%;">Return to application form</div>
			</div><?php
		}else
		{?>
		<a href="#"  style="text-decoration:none" onclick="pass1.user_cat.value='3';pass1.side_menu.value='4'; pass1.submit(); return false" title="Return to form if not submitted or, to know admission status">
			<div class="insideleftSide" 
				style="margin-top:16%;
				height:16.4%;
				background-image:url(../m/img/registration.png);
				background-position: 50% 15px;"/>
				<div class="center" style="width:100%; top:80%;">Return to application form</div>
			</div>
		</a><?php
		}?>
	<!-- InstanceEndEditable -->	
	
	<!-- InstanceBeginEditable name="newApplicant" --><?php
		if (isset($_REQUEST['side_menu']) && $_REQUEST['side_menu'] == '5')
		{?>
			<div class="insideleftSide_dull" 
				style="margin-top:19%;
				background-image:url(../m/img/fresh_std.png);"/>
				<div class="center" style="width:100%; top:80%;">Fresh student</div>
			</div><?php
		}else
		{?>
		<a href="#"  style="text-decoration:none" onclick="pass1.user_cat.value='4';pass1.side_menu.value='5'; pass1.submit(); return false" title="Fresh student, sign up here">
			<div class="insideleftSide" 
				style="margin-top:14%;
				height:16.4%;
				background-image:url(../m/img/fresh_std.png);
				background-repeat:no-repeat;"/>
				<div class="center" style="width:100%; top:80%;">Fresh student</div>
			</div>
		</a><?php
		}?>
	<!-- InstanceEndEditable --><?php
}


function paid_reg_fee($table)
{
	$mysqli = link_connect_db();
	
	$orgsetins = settns();

	$regdate1 = substr($orgsetins["regdate1"], 4, 4)."-".substr($orgsetins["regdate1"],2,2)."-".substr($orgsetins["regdate1"],0,2);
	$regdate2 = substr($orgsetins["regdate_100_200_2"], 4, 4)."-".substr($orgsetins["regdate_100_200_2"],2,2)."-".substr($orgsetins["regdate_100_200_2"],0,2);
	$mat_no_str  = "'";

	if ($table == 'remitapayments')
	{
		$stmt = $mysqli->prepare("SELECT DISTINCT Regno
		FROM remitapayments 
		WHERE vDesc = 'Wallet Funding'
		AND (ResponseCode = '01' OR ResponseCode = '01')
		AND (LEFT(TransactionDate,10) >= '$regdate1'
		AND LEFT(TransactionDate,10) <= '$regdate2')
		AND AcademicSession = '".$orgsetins["cAcademicDesc"]."'"); 
    	//$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($vMatricNo);
		
		while($stmt->fetch())
		{
			$mat_no_str .= $vMatricNo."','";
		}
		$stmt->close();

		return substr($mat_no_str,0,strlen($mat_no_str)-2);
	}else if ($table == 's_tranxion_d')
	{
		$stmt = $mysqli->prepare("SELECT vMatricNo, count(*) 'count' FROM s_tranxion_20242025 
		WHERE cAcademicDesc = '".$orgsetins['cAcademicDesc']."' 
		AND tSemester = ".$orgsetins['tSemester']."
		AND vremark = 'Registration Deduction'
		GROUP BY vMatricNo");

		//$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($vMatricNo, $count);
		
		while($stmt->fetch())
		{
			if ($count >= 4)
			{
				$mat_no_str .= $vMatricNo."','";
			}
		}
		$stmt->close();

		return substr($mat_no_str,0,strlen($mat_no_str)-2);
	}
}



function unarchive_student($vMatricNo)
{
	$mysqli = link_connect_db();
	
	$mysqli_arch = link_connect_db_arch();
	$stmt = $mysqli_arch->prepare("SELECT vApplicationNo FROM arch_afnmatric WHERE vMatricNo = ?");
	$stmt->bind_param("s", $vMatricNo);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($vApplicationNo);
	$stmt->fetch();

	$vMatricNo = $vMatricNo ?? '';
	if ($vMatricNo == '')
	{
		return '';
	}

	try
	{
		$mysqli->autocommit(FALSE); //turn on transactions

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.afnmatric SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_afnmatric WHERE
		damu82ro_nouonlinenouedu_db2.arch_afnmatric.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_afnmatric WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.afnqualsubject SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_afnqualsubject WHERE
		damu82ro_nouonlinenouedu_db2.arch_afnqualsubject.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_afnqualsubject WHERE damu82ro_nouonlinenouedu_db2.arch_afnqualsubject.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.afnqualsubject_stff SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_afnqualsubject_stff WHERE
		damu82ro_nouonlinenouedu_db2.arch_afnqualsubject_stff.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_afnqualsubject_stff WHERE damu82ro_nouonlinenouedu_db2.arch_afnqualsubject_stff.vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.applyqual SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_applyqual WHERE
		damu82ro_nouonlinenouedu_db2.arch_applyqual.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_applyqual WHERE damu82ro_nouonlinenouedu_db2.arch_applyqual.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.applyqual_stff SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_applyqual_stff WHERE
		damu82ro_nouonlinenouedu_db2.arch_applyqual_stff.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_applyqual_stff WHERE damu82ro_nouonlinenouedu_db2.arch_applyqual_stff.vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.applysubject SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_applysubject WHERE
		damu82ro_nouonlinenouedu_db2.arch_applysubject.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_applysubject WHERE damu82ro_nouonlinenouedu_db2.arch_applysubject.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.applysubject_stff SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_applysubject_stff WHERE
		damu82ro_nouonlinenouedu_db2.arch_applysubject_stff.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_applysubject_stff WHERE damu82ro_nouonlinenouedu_db2.arch_applysubject_stff.vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.app_client SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_app_client WHERE
		damu82ro_nouonlinenouedu_db2.arch_app_client.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_app_client WHERE damu82ro_nouonlinenouedu_db2.arch_app_client.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.atv_log SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_atv_log WHERE
		damu82ro_nouonlinenouedu_db2.arch_atv_log.vApplicationNo = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db2.arch_atv_log.vApplicationNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_atv_log WHERE damu82ro_nouonlinenouedu_db2.arch_atv_log.vApplicationNo = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db2.arch_atv_log.vApplicationNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.pers_info SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_pers_info WHERE
		damu82ro_nouonlinenouedu_db2.arch_pers_info.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_pers_info WHERE damu82ro_nouonlinenouedu_db2.arch_pers_info.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.post_addr SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_post_addr WHERE
		damu82ro_nouonlinenouedu_db2.arch_post_addr.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_post_addr WHERE damu82ro_nouonlinenouedu_db2.arch_post_addr.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.res_addr SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_res_addr WHERE
		damu82ro_nouonlinenouedu_db2.arch_res_addr.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_res_addr WHERE damu82ro_nouonlinenouedu_db2.arch_res_addr.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.nextofkin SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_nextofkin WHERE
		damu82ro_nouonlinenouedu_db2.arch_nextofkin.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_nextofkin WHERE damu82ro_nouonlinenouedu_db2.arch_nextofkin.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.pics SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_pics WHERE
		damu82ro_nouonlinenouedu_db2.arch_pics.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_pics WHERE damu82ro_nouonlinenouedu_db2.arch_pics.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.prog_choice SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_prog_choice WHERE
		damu82ro_nouonlinenouedu_db2.arch_prog_choice.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_prog_choice WHERE damu82ro_nouonlinenouedu_db2.arch_prog_choice.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.s_m_t SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_s_m_t WHERE
		damu82ro_nouonlinenouedu_db2.arch_s_m_t.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_s_m_t WHERE damu82ro_nouonlinenouedu_db2.arch_s_m_t.vMatricNo = '$vMatricNo'");
		$stmt->execute();

		/*$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.s_tranxion SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_s_tranxion WHERE
		damu82ro_nouonlinenouedu_db2.arch_s_tranxion.vMatricNo = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db2.arch_s_tranxion.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_s_tranxion WHERE damu82ro_nouonlinenouedu_db2.arch_s_tranxion.vMatricNo = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db2.arch_s_tranxion.vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.s_tranxion_app SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_s_tranxion_app WHERE
		damu82ro_nouonlinenouedu_db2.arch_s_tranxion_app.vMatricNo = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db2.arch_s_tranxion_app.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_s_tranxion_app WHERE damu82ro_nouonlinenouedu_db2.arch_s_tranxion_app.vMatricNo = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db2.arch_s_tranxion_app.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		
		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.s_tranxion_cr SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_s_tranxion_cr WHERE
		damu82ro_nouonlinenouedu_db2.arch_s_tranxion_cr.vMatricNo = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db2.arch_s_tranxion_cr.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_s_tranxion_cr WHERE damu82ro_nouonlinenouedu_db2.arch_s_tranxion_cr.vMatricNo = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db2.arch_s_tranxion_cr.vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.s_tranxion_cr_app SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_s_tranxion_cr_app WHERE
		damu82ro_nouonlinenouedu_db2.arch_s_tranxion_cr_app.vMatricNo = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db2.arch_s_tranxion_cr_app.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_s_tranxion_cr_app WHERE damu82ro_nouonlinenouedu_db2.arch_s_tranxion_cr_app.vMatricNo = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db2.arch_s_tranxion_cr_app.vMatricNo = '$vMatricNo'");
		$stmt->execute();*/

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.remitapayments SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_remitapayments WHERE
		damu82ro_nouonlinenouedu_db2.arch_remitapayments.Regno = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db2.arch_remitapayments.Regno = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_remitapayments WHERE damu82ro_nouonlinenouedu_db2.arch_remitapayments.Regno = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db2.arch_remitapayments.Regno = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.remitapayments_app SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_remitapayments_app WHERE
		damu82ro_nouonlinenouedu_db2.arch_remitapayments_app.Regno = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db2.arch_remitapayments_app.Regno = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_remitapayments_app WHERE damu82ro_nouonlinenouedu_db2.arch_remitapayments_app.Regno = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db2.arch_remitapayments_app.Regno = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.coursereg SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_coursereg WHERE
		damu82ro_nouonlinenouedu_db2.arch_coursereg.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_coursereg WHERE damu82ro_nouonlinenouedu_db2.arch_coursereg.vMatricNo = '$vMatricNo'");
		$stmt->execute();

		/*$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.coursereg_arch SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_coursereg_arch WHERE
		damu82ro_nouonlinenouedu_db2.arch_coursereg_arch.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_coursereg_arch WHERE damu82ro_nouonlinenouedu_db2.arch_coursereg_arch.vMatricNo = '$vMatricNo'");
		$stmt->execute();*/

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.examreg SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_examreg WHERE
		damu82ro_nouonlinenouedu_db2.arch_examreg.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_examreg WHERE damu82ro_nouonlinenouedu_db2.arch_examreg.vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.examreg_result SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_examreg_result WHERE
		damu82ro_nouonlinenouedu_db2.arch_examreg_result.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_examreg_result WHERE damu82ro_nouonlinenouedu_db2.arch_examreg_result.vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.rs_client SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_rs_client WHERE
		damu82ro_nouonlinenouedu_db2.arch_rs_client.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_rs_client WHERE damu82ro_nouonlinenouedu_db2.arch_rs_client.vMatricNo = '$vMatricNo'");
		$stmt->execute();

		log_actv('Unarchived records of '.$vMatricNo);
		
		$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

		$stmt->close();

		return 1;
	}catch(Exception $e) 
	{
		$mysqli->rollback(); //remove all queries from queue if error (undo)
		throw $e;
	}
}


function archive_student($vMatricNo)
{
	$mysqli = link_connect_db();
		
	$stmt = $mysqli->prepare("SELECT vApplicationNo FROM afnmatric WHERE vMatricNo = ?");
	$stmt->bind_param("s", $vMatricNo);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($vApplicationNo);
	$stmt->fetch();

	$vMatricNo = $vMatricNo ?? '';
	if ($vMatricNo == '')
	{
		return '';
	}

	try
	{
		$mysqli->autocommit(FALSE); //turn on transactions

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_afnmatric SELECT * FROM damu82ro_nouonlinenouedu_db1.afnmatric WHERE
		damu82ro_nouonlinenouedu_db1.afnmatric.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM afnmatric WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_afnqualsubject SELECT * FROM damu82ro_nouonlinenouedu_db1.afnqualsubject WHERE
		damu82ro_nouonlinenouedu_db1.afnqualsubject.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM afnqualsubject WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_afnqualsubject_stff SELECT * FROM damu82ro_nouonlinenouedu_db1.afnqualsubject_stff WHERE
		damu82ro_nouonlinenouedu_db1.afnqualsubject_stff.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM afnqualsubject_stff WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_applyqual SELECT * FROM damu82ro_nouonlinenouedu_db1.applyqual WHERE
		damu82ro_nouonlinenouedu_db1.applyqual.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM applyqual WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_applyqual_stff SELECT * FROM damu82ro_nouonlinenouedu_db1.applyqual_stff WHERE
		damu82ro_nouonlinenouedu_db1.applyqual_stff.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM applyqual_stff WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_applysubject SELECT * FROM damu82ro_nouonlinenouedu_db1.applysubject WHERE
		damu82ro_nouonlinenouedu_db1.applysubject.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM applysubject WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_applysubject_stff SELECT * FROM damu82ro_nouonlinenouedu_db1.applysubject_stff WHERE
		damu82ro_nouonlinenouedu_db1.applysubject_stff.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM applysubject_stff WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_app_client SELECT * FROM damu82ro_nouonlinenouedu_db1.app_client WHERE
		damu82ro_nouonlinenouedu_db1.app_client.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM app_client WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_atv_log SELECT * FROM damu82ro_nouonlinenouedu_db1.atv_log WHERE
		damu82ro_nouonlinenouedu_db1.atv_log.vApplicationNo = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db1.atv_log.vApplicationNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM atv_log WHERE vApplicationNo = '$vApplicationNo' OR vApplicationNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_pers_info SELECT * FROM damu82ro_nouonlinenouedu_db1.pers_info WHERE
		damu82ro_nouonlinenouedu_db1.pers_info.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM pers_info WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_post_addr SELECT * FROM damu82ro_nouonlinenouedu_db1.post_addr WHERE
		damu82ro_nouonlinenouedu_db1.post_addr.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM post_addr WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_res_addr SELECT * FROM damu82ro_nouonlinenouedu_db1.res_addr WHERE
		damu82ro_nouonlinenouedu_db1.res_addr.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM res_addr WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_nextofkin SELECT * FROM damu82ro_nouonlinenouedu_db1.nextofkin WHERE
		damu82ro_nouonlinenouedu_db1.nextofkin.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM nextofkin WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_pics SELECT * FROM damu82ro_nouonlinenouedu_db1.pics WHERE
		damu82ro_nouonlinenouedu_db1.pics.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM pics WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_prog_choice SELECT * FROM damu82ro_nouonlinenouedu_db1.prog_choice WHERE
		damu82ro_nouonlinenouedu_db1.prog_choice.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM prog_choice WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_s_m_t SELECT * FROM damu82ro_nouonlinenouedu_db1.s_m_t WHERE
		damu82ro_nouonlinenouedu_db1.s_m_t.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM s_m_t WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_s_tranxion_cr SELECT * FROM damu82ro_nouonlinenouedu_db1.s_tranxion_cr WHERE
		damu82ro_nouonlinenouedu_db1.s_tranxion_cr.vMatricNo = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db1.s_tranxion_cr.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM s_tranxion_cr WHERE vMatricNo = '$vApplicationNo' OR vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_s_tranxion_cr_app SELECT * FROM damu82ro_nouonlinenouedu_db1.s_tranxion_cr_app WHERE
		damu82ro_nouonlinenouedu_db1.s_tranxion_cr_app.vMatricNo = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db1.s_tranxion_cr_app.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM s_tranxion_cr_app WHERE vMatricNo = '$vApplicationNo' OR vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_remitapayments SELECT * FROM damu82ro_nouonlinenouedu_db1.remitapayments WHERE
		damu82ro_nouonlinenouedu_db1.remitapayments.Regno = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db1.remitapayments.Regno = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM remitapayments WHERE Regno = '$vApplicationNo' OR Regno = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_remitapayments_app SELECT * FROM damu82ro_nouonlinenouedu_db1.remitapayments_app WHERE
		damu82ro_nouonlinenouedu_db1.remitapayments_app.Regno = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db1.remitapayments_app.Regno = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM remitapayments_app WHERE Regno = '$vApplicationNo' OR Regno = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_coursereg SELECT * FROM damu82ro_nouonlinenouedu_db1.coursereg WHERE
		damu82ro_nouonlinenouedu_db1.coursereg.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM coursereg WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();

		/*$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_coursereg_arch SELECT * FROM damu82ro_nouonlinenouedu_db1.coursereg_arch WHERE
		damu82ro_nouonlinenouedu_db1.coursereg_arch.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM coursereg_arch WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();*/

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_examreg SELECT * FROM damu82ro_nouonlinenouedu_db1.examreg WHERE
		damu82ro_nouonlinenouedu_db1.examreg.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM examreg WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_examreg_result SELECT * FROM damu82ro_nouonlinenouedu_db1.examreg_result WHERE
		damu82ro_nouonlinenouedu_db1.examreg_result.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM examreg_result WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_rs_client SELECT * FROM damu82ro_nouonlinenouedu_db1.rs_client WHERE
		damu82ro_nouonlinenouedu_db1.rs_client.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM rs_client WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();	
		
		$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

		$stmt->close();
		
		log_actv('Archived records of '.$vMatricNo);	

		return 1;
	}catch(Exception $e) 
	{
		$mysqli->rollback(); //remove all queries from queue if error (undo)
		throw $e;
	}
}



function unarchive_appl($applno)
{
	$mysqli = link_connect_db();
	
	$mysqli_arch = link_connect_db_arch();
	$stmt = $mysqli_arch->prepare("SELECT vApplicationNo FROM arch_prog_choice WHERE vApplicationNo = ?");
	$stmt->bind_param("s", $applno);
	$stmt->execute();
	$stmt->store_result();

	if ($stmt->num_rows == 0)
	{
		$stmt->close();
		return '';
	}

	try
	{
		$mysqli->autocommit(FALSE); //turn on transactions

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.afnqualsubject SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_afnqualsubject WHERE damu82ro_nouonlinenouedu_db2.arch_afnqualsubject.vApplicationNo = '$applno'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_afnqualsubject WHERE damu82ro_nouonlinenouedu_db2.arch_afnqualsubject.vApplicationNo = '$applno'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.applyqual SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_applyqual WHERE damu82ro_nouonlinenouedu_db2.arch_applyqual.vApplicationNo = '$applno'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_applyqual WHERE damu82ro_nouonlinenouedu_db2.arch_applyqual.vApplicationNo = '$applno'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.applysubject SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_applysubject WHERE damu82ro_nouonlinenouedu_db2.arch_applysubject.vApplicationNo = '$applno'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_applysubject WHERE damu82ro_nouonlinenouedu_db2.arch_applysubject.vApplicationNo = '$applno'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.app_client SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_app_client WHERE damu82ro_nouonlinenouedu_db2.arch_app_client.vApplicationNo = '$applno'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_app_client WHERE damu82ro_nouonlinenouedu_db2.arch_app_client.vApplicationNo = '$applno'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.atv_log SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_atv_log WHERE damu82ro_nouonlinenouedu_db2.arch_atv_log.vApplicationNo = '$applno'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_atv_log WHERE damu82ro_nouonlinenouedu_db2.arch_atv_log.vApplicationNo = '$applno'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.pers_info SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_pers_info WHERE damu82ro_nouonlinenouedu_db2.arch_pers_info.vApplicationNo = '$applno'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_pers_info WHERE damu82ro_nouonlinenouedu_db2.arch_pers_info.vApplicationNo = '$applno'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.post_addr SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_post_addr WHERE damu82ro_nouonlinenouedu_db2.arch_post_addr.vApplicationNo = '$applno'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_post_addr WHERE damu82ro_nouonlinenouedu_db2.arch_post_addr.vApplicationNo = '$applno'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.res_addr SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_res_addr WHERE damu82ro_nouonlinenouedu_db2.arch_res_addr.vApplicationNo = '$applno'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_res_addr WHERE damu82ro_nouonlinenouedu_db2.arch_res_addr.vApplicationNo = '$applno'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.nextofkin SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_nextofkin WHERE damu82ro_nouonlinenouedu_db2.arch_nextofkin.vApplicationNo = '$applno'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_nextofkin WHERE damu82ro_nouonlinenouedu_db2.arch_nextofkin.vApplicationNo = '$applno'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.pics SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_pics WHERE damu82ro_nouonlinenouedu_db2.arch_pics.vApplicationNo = '$applno'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_pics WHERE damu82ro_nouonlinenouedu_db2.arch_pics.vApplicationNo = '$applno'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.prog_choice SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_prog_choice WHERE damu82ro_nouonlinenouedu_db2.arch_prog_choice.vApplicationNo = '$applno'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_prog_choice WHERE damu82ro_nouonlinenouedu_db2.arch_prog_choice.vApplicationNo = '$applno'");
		$stmt->execute();

		/*$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.s_tranxion_app SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_s_tranxion WHERE damu82ro_nouonlinenouedu_db2.arch_s_tranxion.vMatricNo = '$applno'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.s_tranxion_app WHERE damu82ro_nouonlinenouedu_db2.arch_s_tranxion.vMatricNo = '$applno'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db1.remitapayments_app SELECT * FROM damu82ro_nouonlinenouedu_db2.arch_remitapayments_app WHERE damu82ro_nouonlinenouedu_db2.arch_remitapayments_app.Regno = '$applno'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM damu82ro_nouonlinenouedu_db2.arch_remitapayments_app WHERE damu82ro_nouonlinenouedu_db2.arch_remitapayments_app.Regno = '$applno'");
		$stmt->execute();*/

		log_actv('Unarchived records of '.$applno);
		
		$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

		$stmt->close();

		return 1;
	}catch(Exception $e) 
	{
		$mysqli->rollback(); //remove all queries from queue if error (undo)
		throw $e;
	}
}


function archive_appl($vApplicationNo)
{
	$mysqli = link_connect_db();
	
	$mysqli_arch = link_connect_db_arch();
	$stmt = $mysqli_arch->prepare("SELECT vApplicationNo FROM arch_prog_choice WHERE vApplicationNo = ?");
	$stmt->bind_param("s", $vApplicationNo);
	$stmt->execute();
	$stmt->store_result();

	if ($stmt->num_rows == 0)
	{
		$stmt->close();
		return '';
	}

	try
	{
		$mysqli->autocommit(FALSE); //turn on transactions

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_afnqualsubject SELECT * FROM damu82ro_nouonlinenouedu_db1.afnqualsubject WHERE damu82ro_nouonlinenouedu_db1.afnqualsubject.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM afnqualsubject WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_applyqual SELECT * FROM damu82ro_nouonlinenouedu_db1.applyqual WHERE damu82ro_nouonlinenouedu_db1.applyqual.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM applyqual WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_applysubject SELECT * FROM damu82ro_nouonlinenouedu_db1.applysubject WHERE damu82ro_nouonlinenouedu_db1.applysubject.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM applysubject WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_app_client SELECT * FROM damu82ro_nouonlinenouedu_db1.app_client WHERE damu82ro_nouonlinenouedu_db1.app_client.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM app_client WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_atv_log SELECT * FROM damu82ro_nouonlinenouedu_db1.atv_log WHERE damu82ro_nouonlinenouedu_db1.atv_log.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM atv_log WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_pers_info SELECT * FROM damu82ro_nouonlinenouedu_db1.pers_info WHERE damu82ro_nouonlinenouedu_db1.pers_info.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM pers_info WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_post_addr SELECT * FROM damu82ro_nouonlinenouedu_db1.post_addr WHERE damu82ro_nouonlinenouedu_db1.post_addr.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM post_addr WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_res_addr SELECT * FROM damu82ro_nouonlinenouedu_db1.res_addr WHERE damu82ro_nouonlinenouedu_db1.res_addr.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM res_addr WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_nextofkin SELECT * FROM damu82ro_nouonlinenouedu_db1.nextofkin WHERE damu82ro_nouonlinenouedu_db1.nextofkin.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM nextofkin WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_pics SELECT * FROM damu82ro_nouonlinenouedu_db1.pics WHERE damu82ro_nouonlinenouedu_db1.pics.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM pics WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_prog_choice SELECT * FROM damu82ro_nouonlinenouedu_db1.prog_choice WHERE damu82ro_nouonlinenouedu_db1.prog_choice.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM prog_choice WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		/*$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_s_tranxion SELECT * FROM damu82ro_nouonlinenouedu_db1.s_tranxion WHERE damu82ro_nouonlinenouedu_db1.s_tranxion.vMatricNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM s_tranxion WHERE vMatricNo = '$vApplicationNo'");
		$stmt->execute();
		
		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_s_tranxion_cr SELECT * FROM damu82ro_nouonlinenouedu_db1.s_tranxion_cr WHERE damu82ro_nouonlinenouedu_db1.s_tranxion_cr.vMatricNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM s_tranxion_cr WHERE vMatricNo = '$vApplicationNo'");
		$stmt->execute();*/

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_remitapayments_app SELECT * FROM damu82ro_nouonlinenouedu_db1.remitapayments_app WHERE damu82ro_nouonlinenouedu_db1.remitapayments_app.Regno = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM remitapayments_app WHERE Regno = '$vApplicationNo'");
		$stmt->execute();	
		
		$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

		$stmt->close();
		
		log_actv('Archived records of '.$vApplicationNo);	

		return 1;
	}catch(Exception $e) 
	{
		$mysqli->rollback(); //remove all queries from queue if error (undo)
		throw $e;
	}
}


function time_out_box($currency)
{
    if ($currency <> '1')
    {?>
        <div class="smoke_scrn" style="display:block; z-index:10; opacity:1; background-color:#818181"></div>
        <div class="center" style="display:block; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:11">
            <div id="msg_title" style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                Caution
            </div>
            <a href="#" style="text-decoration:none;">
                <div id="msg_title" style="width:20px; float:left; text-align:center; padding:0px;"></div>
            </a>
            <div id="msg_msg" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;">
                Time out. Click Ok to login and continue
            </div>
            <div id="msg_title" style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
                <a href="#" style="text-decoration:none;" 
                    onclick="pass1.loggedout.value=1;pass1.action='./staff_login_page';pass1.submit()
                    return false">
                    <div class="submit_button_brown" style="width:60px; padding:6px; float:right">
                        Ok
                    </div>
                </a>
            </div>
        </div><?php
    }
}


function caution_box($msg)
{?>
	<div id="smke_screen" class="smoke_scrn" style="display:block; z-index:2"></div>
	<div id="conf_warn" class="center" style="display:block; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF; z-index:3; position:fixed;">
		<div id="msg_title" style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
			Guide
		</div>
		<a href="#" style="text-decoration:none;">
			<div id="msg_title" style="width:20px; float:left; text-align:center; padding:0px;"></div>
		</a>
		<div id="msg_msg" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;">
			<?php echo $msg;?>
		</div>
		<div id="msg_title" style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
			<a href="#" style="text-decoration:none;" 
				onclick="_('conf_warn').style.display= 'none';
				_('conf_warn').style.zIndex= '-1';
				_('smke_screen').style.display= 'none';
				_('smke_screen').style.zIndex= '-1';
				return false">
				<div class="submit_button_brown" style="width:60px; padding:6px; float:right">
					Ok
				</div>
			</a>
		</div>
	</div><?php
}



function caution_box_inline($msg)
{?>
	<div id="caution_box_inline" class="center" style="display:block; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF; z-index:3; position:fixed;">
		<div id="msg_title" style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
			Guide
		</div>
		<a href="#" style="text-decoration:none;">
			<div id="msg_title" style="width:20px; float:left; text-align:center; padding:0px;"></div>
		</a>
		<div id="msg_msg" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;">
			<?php echo $msg;?>
		</div>
		<div id="msg_title" style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
			<a href="#" style="text-decoration:none;" 
				onclick="_('caution_box_inline').style.display= 'none';
				return false">
				<div class="submit_button_green" style="width:60px; padding:6px; float:right">
					Ok
				</div>
			</a>
		</div>
	</div><?php
}


function caution_box_inline_bkp($msg)
{?>
	<div id="caution_box_inline_bkp" class="center" style="display:block; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF; z-index:3; position:fixed;">
		<div id="msg_title_bkp" style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
			Guide
		</div>
		<a href="#" style="text-decoration:none;">
			<div id="msg_title_bkp" style="width:20px; float:left; text-align:center; padding:0px;"></div>
		</a>
		<div id="msg_msg_bkp" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;">
			<?php echo $msg;?>
		</div>
		<div id="msg_title" style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
			<a href="#" style="text-decoration:none;" 
				onclick="_('caution_box_inline_bkp').style.display='none';
				return false">
				<div class="submit_button_green" style="width:60px; padding:6px; float:right">
					Oks
				</div>
			</a>
		</div>
	</div><?php
}


function caution_box_inline_bkp_b($msg)
{?>
	<div id="caution_box_inline_bkp_b" class="center" style="display:block; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF; z-index:3; position:fixed;">
		<div id="msg_title_bkp_b" style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
			Guide
		</div>
		<a href="#" style="text-decoration:none;">
			<div id="msg_title_bkp_b" style="width:20px; float:left; text-align:center; padding:0px;"></div>
		</a>
		<div id="msg_msg_bkp_b" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;">
			<?php echo $msg;?>
		</div>
		<div id="msg_title" style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
			<a href="#" style="text-decoration:none;" 
				onclick="_('caution_box_inline_bkp_b').style.display= 'none';
				return false">
				<div class="submit_button_green" style="width:60px; padding:6px; float:right">
					Ok
				</div>
			</a>
		</div>
	</div><?php
}


function information_box($msg)
{?>
	<div id="smke_screen" class="smoke_scrn" style="display:block; z-index:2"></div>
	<div id="conf_warn" class="center" style="display:block; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF; z-index:3; position:fixed;">
		<div id="msg_title" style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
			Caution
		</div>
		<a href="#" style="text-decoration:none;">
			<div id="msg_title" style="width:20px; float:left; text-align:center; padding:0px;"></div>
		</a>
		<div id="msg_msg" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;">
		<?php echo $msg;?>
		</div>
		<div id="msg_title" style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
			<a href="#" style="text-decoration:none;" 
				onclick="_('conf_warn').style.display= 'none';
				_('conf_warn').style.zIndex= '-1';
				_('smke_screen').style.display= 'none';
				_('smke_screen').style.zIndex= '-1';
				return false">
				<div class="submit_button_brown" style="width:60px; padding:6px; float:right">
					Ok
				</div>
			</a>
		</div>
	</div><?php
}


function information_box_inline($msg)
{?>
	<div id="information_box_inline" class="center" style="display:block; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF; z-index:3; position:fixed;">
		<div id="msg_title" style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
			Information
		</div>
		<a href="#" style="text-decoration:none;">
			<div id="msg_title" style="width:20px; float:left; text-align:center; padding:0px;"></div>
		</a>
		<div id="msg_msg" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;">
		<?php echo $msg;?>
		</div>
		<div id="msg_title" style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
			<a href="#" style="text-decoration:none;" 
				onclick="_('information_box_inline').style.display= 'none';
				return false">
				<div class="submit_button_green" style="width:60px; padding:6px; float:right">
					Ok
				</div>
			</a>
		</div>
	</div><?php
}


function success_box($msg)
{?>
	<div id="green_smke_screen" class="smoke_scrn" style="display:block; z-index:2"></div>
	<div id="green_info_box" class="center" style="display:block; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF; z-index:3; position:fixed;">
		<div id="msg_title" style="width:350px; float:left; text-align:left; padding:0px; color:#36743e; font-weight:bold">
			Information
		</div>
		<a href="#" style="text-decoration:none;">
			<div id="msg_title" style="width:20px; float:left; text-align:center; padding:0px;"></div>
		</a>
		<div id="green_msg_msg" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#36743e;">
		<?php echo $msg;?>
		</div>
		<div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
			<a href="#" style="text-decoration:none;" 
				onclick="_('green_info_box').style.display= 'none';
				_('green_info_box').style.zIndex= '-1';
				_('green_smke_screen').style.display= 'none';
				_('green_smke_screen').style.zIndex= '-1';
				return false">
				<div class="submit_button_home" style="width:60px; padding:6px; float:right">
					Ok
				</div>
			</a>
		</div>
	</div><?php
}


function side_detail($id_val)
{
	$vApplicationNo = '';
	$vTitle = '';
	$vLastName = '';
	$vFirstName = '';
	$vOtherName = '';
	$vFacultyDesc = '';
	$vdeptDesc = '';
	$cProgrammeId = '';
	$vObtQualTitle = '';
	$vProgrammeDesc = '';
	$iStudy_level = '';
	$cEduCtgId = '';
	$tSemester = '';
	$col_gown = '';
	$ret_gown = '';
	$vCityName = '';

    if ($id_val <> '')
    {
		$mysqli = link_connect_db();

		$stmt = $mysqli->prepare("select * from afnmatric a inner join s_m_t b using(vMatricNo) where a.vApplicationNo = ? OR a.vMatricNo = ?");
		$stmt->bind_param("ss", $id_val, $id_val);
		$stmt->execute();
		$stmt->store_result();
			
		$has_matno = $stmt->num_rows;
		$stmt->close();
		
		if ($has_matno > 0)
		{
			$stmt = $mysqli->prepare("select a.vApplicationNo, vLastName, vFirstName, vOtherName, b.vFacultyDesc, c.vdeptDesc, a.cProgrammeId, d.vObtQualTitle, e.vProgrammeDesc, a.iStudy_level, e.cEduCtgId, a.tSemester, a.col_gown, a.ret_gown , f.vCityName
			from s_m_t a, faculty b, depts c, obtainablequal d, programme e, studycenter f, afnmatric g
			where a.cFacultyId = b.cFacultyId
			and a.cdeptId = c.cdeptId
			and a.cObtQualId = d.cObtQualId
			and a.cProgrammeId = e.cProgrammeId
			and a.cStudyCenterId = f.cStudyCenterId
			and g.vMatricNo = a.vMatricNo
			and (g.vMatricNo = ? or
			g.vApplicationNo = ?)");
			$stmt->bind_param("ss", $id_val, $id_val);
			$stmt->execute();
			$stmt->store_result();
		}else
		{
			$stmt = $mysqli->prepare("select b.vApplicationNo, b.vLastName, b.vFirstName, b.vOtherName, c.vFacultyDesc, d.vdeptDesc, e.cProgrammeId, f.vObtQualTitle, e.vProgrammeDesc, b.iBeginLevel, e.cEduCtgId, 'tSemester', 'col_gown', 'ret_gown', h.vCityName			
			from prog_choice b, faculty c, depts d, programme e, obtainablequal f, studycenter h
			where b.cFacultyId = c.cFacultyId
			and e.cdeptId = d.cdeptId
			and e.cProgrammeId = b.cProgrammeId
			and e.cObtQualId = f.cObtQualId
			and b.cStudyCenterId = h.cStudyCenterId
			and b.vApplicationNo = ?");
			$stmt->bind_param("s", $id_val);
			$stmt->execute();
			$stmt->store_result();
		}

		$stmt->bind_result($vApplicationNo, $vLastName, $vFirstName, $vOtherName, $vFacultyDesc, $vdeptDesc, $cProgrammeId, $vObtQualTitle, $vProgrammeDesc, $iStudy_level, $cEduCtgId, $tSemester, $col_gown, $ret_gown, $vCityName);
		$stmt->fetch();
		$stmt->close();

		$vOtherName = $vOtherName ?? '';
	}

	if (!isset($_REQUEST['mm']) || (($_REQUEST['mm'] == 8 && !($cEduCtgId == 'PGZ' && $cEduCtgId == 'PRX')) || ($_REQUEST['mm'] == 1 && ($cEduCtgId == 'PGZ' || $cEduCtgId == 'PRX'))))
	{
		//return '';
	}
	get_ctry_of_res_u();?>
	
	<div id="std_names" style="width:auto; padding-top:6px; padding-bottom:4px; border-bottom:1px dashed #888888">
		<?php echo $vApplicationNo.'<br>'.strtoupper($vLastName).'<br>'.ucwords(strtolower($vFirstName)).' '.ucwords(strtolower($vOtherName));?>
	</div>
	<div id="std_quali" style="width:auto; padding-top:5px; padding-bottom:5px; border-bottom:1px dashed #888888"><?php 
		if (!is_bool(strpos($vProgrammeDesc,"(d)")))
		{
			$vProgrammeDesc = substr($vProgrammeDesc, 0, strlen($vProgrammeDesc)-4);
		}
		echo $vObtQualTitle.'<br>'.$vProgrammeDesc;?>
	</div>
	<div id="std_lvl" style="width:auto; padding-top:6px;">
		<?php if ($iStudy_level == 30)
		{
			echo 'DIP 1<br>';
		}else if ($iStudy_level == 40)
		{
			echo 'DIP 2<br>';
		}else if ($cEduCtgId == 'PGZ')
		{
			echo $iStudy_level.'Level<br>';
		}?>
	</div>
	<div id="std_sems" style="width:auto; padding-top:4px; padding-bottom:4px; border-bottom:1px dashed #888888">
		<?php /*if ($vLastName <> '')
		{
			if ($tSemester == 1){echo 'First';}else{echo 'Second';}?> semester<?php
		}*/?>
	</div>			
	<div id="std_vCityName" style="width:auto; padding-bottom:4px; border-bottom:1px dashed #888888"><?php
		echo '<br>'.$vCityName;?>
	</div><?php
}


function foot_bar()
{
	echo 'Power';//echo '&#169; '.date("Y").' National Open University of Nigeria (NOUN)';
}


function check_rrr($rrr)
{
	$mysqli = link_connect_db();

	$stmt_check_rrr = $mysqli->prepare("SELECT * FROM s_tranxion_cr WHERE RetrievalReferenceNumber = ?");
	$stmt_check_rrr->bind_param("s", $rrr);
	$stmt_check_rrr->execute();
	$stmt_check_rrr->store_result();
	return $stmt_check_rrr->num_rows();
}


function initite_write_debit_transaction($matNo, $session, $semester, $cCourseId, $vremark){
	$mysqli = link_connect_db();

	$stmt1 = $mysqli->prepare("DELETE FROM s_tranxion_20242025 
	WHERE vMatricNo = ?
	AND cAcademicDesc = ?
	AND tSemester = ?
	AND cTrntype = 'd'
	AND cCourseId = ?
	AND vremark = ?");
	$stmt1->bind_param("ssiss", $matNo, $session, $semester, $cCourseId, $vremark);
	$stmt1->execute();
	$stmt1->close();
}


function get_nxt_sn ($vMatricNo, $iItemID, $vremark){
	$mysqli = link_connect_db();

	$stmt_tSemester = $mysqli->prepare("SELECT tSemester FROM s_m_t WHERE vMatricNo = ?");
	$stmt_tSemester->bind_param("s", $vMatricNo);
	$stmt_tSemester->execute();
	$stmt_tSemester->store_result();
	$stmt_tSemester->bind_result($tSemester);
	$stmt_tSemester->fetch();
	$stmt_tSemester->close();

	$tSemester = $tSemester ?? '';

	if ($tSemester == '')
	{
		$tSemester = 1;
	}

	$orgsetins = settns();
	$semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);

	$iItemID_lc_c = '';
	if ($iItemID <> '')
	{
		$iItemID_lc_c = " AND iItemID = $iItemID ";
	}

	$stmt_get_nxt_sn = $mysqli->prepare("SELECT MAX(trans_count) + 1 FROM s_tranxion_20242025 
	WHERE vMatricNo = '$vMatricNo'
	AND tdate >= '$semester_begin_date'
	AND vremark = '$vremark'
	$iItemID_lc_c");
	$stmt_get_nxt_sn->execute();
	$stmt_get_nxt_sn->store_result();
	$stmt_get_nxt_sn->bind_result($nxt_sn);
	$stmt_get_nxt_sn->fetch();
	$stmt_get_nxt_sn->close();
	
	if (is_null($nxt_sn))
	{
		$nxt_sn = 0;
	}
	//$nxt_sn = $nxt_sn ?? 0;

	return $nxt_sn;
}


function can_preview_form()
{
	$mysqli = link_connect_db();

	$stmt_prog_choice = $mysqli->prepare("SELECT * FROM prog_choice WHERE vApplicationNo = ? AND cProgrammeId <> ''");
	$stmt_prog_choice->bind_param("s", $_REQUEST["vApplicationNo"]);
	$stmt_prog_choice->execute();
	$stmt_prog_choice->store_result();
	$prog_choice_made = $stmt_prog_choice->num_rows;
	$stmt_prog_choice->close();

	return $prog_choice_made;
}


function get_subjects($cProgrammeId,$sReqmtId,$cEduCtgId_1,$cEduCtgId_2,$iBeginLevel,$cdept,$part)
{
	$child_qry = " AND a.cProgrammeId LIKE '%$cProgrammeId%' ";
	$cEduCtgId_qry = "";

    $sReqmtId_qry = $sReqmtId_qry = " AND a.sReqmtId = ".$sReqmtId;
    
    if ($_REQUEST['cFacultyId'] == 'AGR')
    {
        if ($cEduCtgId_2 == '')
        {
            $cEduCtgId_qry = " AND a.cEduCtgId = 'OL' ";
            $sReqmtId_qry = "";
        }
    }else if ($_REQUEST['cFacultyId'] == 'ART')
    {
        if ($cEduCtgId_2 <> '')
        {
            $cEduCtgId_qry = " AND a.cEduCtgId = '$cEduCtgId_2' ";
        }else if ($cEduCtgId_2 == '')
        {
            $cEduCtgId_qry = " AND a.cEduCtgId = 'OL' ";
            $sReqmtId_qry = "";

            if ($_REQUEST['cdept'] == 'ENG')
            {
                $child_qry = " AND a.cProgrammeId LIKE '%ART201%' ";
            }else if ($_REQUEST['cdept'] == 'RST')
            {
                $child_qry = " AND (a.cProgrammeId = 'ART208,ART209,ART210' OR a.cProgrammeId LIKE '%$cProgrammeId%') ";
            }
        }                   
    }else if ($_REQUEST['cFacultyId'] == 'EDU')
    {
        if ($cEduCtgId_2 == '')//if ($cEduCtgId_1 <> '')
        {
            $cEduCtgId_qry = " AND a.cEduCtgId LIKE 'OL%' ";
            $sReqmtId_qry = "";
        }
        
        if ($iBeginLevel >= 700)
        {
            if ($cdept == 'EFO')
            {
                $child_qry = " AND (a.cProgrammeId LIKE '%EDU212%' OR a.cProgrammeId LIKE '%$cProgrammeId%') ";
            }else if ($cdept == 'SED')
            {
                $child_qry = " AND (a.cProgrammeId LIKE '%EDU210%' OR a.cProgrammeId LIKE '%$cProgrammeId%') ";
            }
        }
    }else if ($_REQUEST['cFacultyId'] == 'HSC')
    {
        //$begin_level = 200;

        if ($cEduCtgId_1 <> '')
        {
            $cEduCtgId_qry = " AND a.cEduCtgId LIKE 'OL%' ";
            $sReqmtId_qry = "";
        }
    }else if ($_REQUEST['cFacultyId'] == 'MSC')
    {
        if ($cEduCtgId_2 == '')//if ($cEduCtgId_1 <> '')
        {
            $cEduCtgId_qry = " AND a.cEduCtgId LIKE 'OL%' ";
            $sReqmtId_qry = "";
        }
        
        if ($iBeginLevel >= 700)
        {
            if ($cdept == 'BUS')
            {
                $child_qry = " AND (a.cProgrammeId LIKE '%MSC201%' OR a.cProgrammeId LIKE '%$cProgrammeId%') ";
            }else if ($cdept == 'ENT')
            {
                $child_qry = " AND (a.cProgrammeId LIKE '%MSC206%' OR a.cProgrammeId LIKE '%$cProgrammeId%') ";
            }else if ($cdept == 'PAD')
            {
                $child_qry = " AND (a.cProgrammeId LIKE '%MSC202%' OR a.cProgrammeId LIKE '%$cProgrammeId%') ";
            }
        }
    }else if ($_REQUEST['cFacultyId'] == 'CMP')
    {
        if ($cEduCtgId_1 <> '')
        {
            $cEduCtgId_qry = " AND a.cEduCtgId LIKE 'OL%' ";
            $sReqmtId_qry = "";
        }
    }else if ($_REQUEST['cFacultyId'] == 'SCI')
    {
        if ($cEduCtgId_1 <> '')
        {
            $cEduCtgId_qry = " AND a.cEduCtgId LIKE 'OL%' ";
            $sReqmtId_qry = "";
        }
    }else if ($_REQUEST['cFacultyId'] == 'SSC')
    {
        if ($cEduCtgId_2 == '')//if ($cEduCtgId_1 <> '')
        {
            $cEduCtgId_qry = " AND a.cEduCtgId LIKE 'OL%' ";
            $sReqmtId_qry = "";
        }
        
        if ($_REQUEST['cdept'] == 'CSS')
        {
            $child_qry = " AND (a.cProgrammeId LIKE '%SSC211%' OR a.cProgrammeId LIKE '%$cProgrammeId%') ";
        }else  if ($_REQUEST['cdept'] == 'DTS')
        {
            $child_qry = " AND (a.cProgrammeId LIKE '%SSC212%' OR a.cProgrammeId LIKE '%$cProgrammeId%') ";
        }else  if ($_REQUEST['cdept'] == 'ECO')
        {
            $child_qry = " AND (a.cProgrammeId LIKE '%SSC201%' OR a.cProgrammeId LIKE '%$cProgrammeId%') ";
        }else  if ($_REQUEST['cdept'] == 'MAC')
        {
            $child_qry = " AND (a.cProgrammeId LIKE '%SSC204%' OR a.cProgrammeId LIKE '%$cProgrammeId%') ";
        }else  if ($_REQUEST['cdept'] == 'PSC')
        {
            $child_qry = " AND (a.cProgrammeId LIKE '%SSC210%' OR a.cProgrammeId LIKE '%$cProgrammeId%') ";
        }
    }

	

	if ($part == 'qry')
	{
		return $sReqmtId_qry;
	}else if ($part == 'chld')
	{
		return $child_qry;
	}else if ($part == 'edctg')
	{
		// echo "SELECT b.vQualSubjectDesc, a.cQualSubjectId, a.cMandate, a.mutual_ex, c.cQualGradeCode, c.cQualGradeId, c.iQualGradeRank
		// FROM criteriasubject a, qualsubject b, qualgrade c
		// WHERE a.cQualSubjectId = b.cQualSubjectId 
		// AND a.cQualGradeId = c.cQualGradeId
		// $sReqmtId_qry
		// $child_qry
		// $cEduCtgId_qry
		// ORDER BY a.cMandate, b.vQualSubjectDesc";
		
		return $cEduCtgId_qry;
	}
}


function check_grad_student($id)
{
	$mysqli_arch = link_connect_db_arch();

	$stmt = $mysqli_arch->prepare("SELECT * FROM arch_s_m_t WHERE vMatricNo = ?");
	$stmt->bind_param("s", $id);
	$stmt->execute();
	$stmt->store_result();
	return $stmt->num_rows;
}


function get_staff_pp_pix()
{
	$mysqli = link_connect_db();

	$id = '';

	if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '')
	{
		$id = $_REQUEST["uvApplicationNo"];
	}else if (isset($_REQUEST["exist_user"]) && $_REQUEST["exist_user"] <> '')
	{
		$id = $_REQUEST["exist_user"];
	}else if (isset($_REQUEST['exist_user1']) && $_REQUEST["exist_user1"] <> '')
	{
		$id = $_REQUEST["exist_user1"];
	}

	$stmt_last = $mysqli->prepare("SELECT trim(vmask) FROM staff_pics WHERE vApplicationNo  = ?");
	$stmt_last->bind_param("s", $id);
	$stmt_last->execute();
	$stmt_last->store_result();
	$stmt_last->bind_result($vmask);
	$stmt_last->fetch();
	$stmt_last->close();
	
	$vmask = $vmask ?? '';
	
	$search_file_name = BASE_FILE_NAME_FOR_STAFF. "p_".$vmask.".jpg"; 
	if(file_exists($search_file_name))
	{
		//return $search_file_name;
		return "data:image/jpg;base64,".c_image($search_file_name);
	}
	
	$search_file_name = BASE_FILE_NAME_FOR_STAFF. "p_".$vmask.".jpeg"; 
	if(file_exists($search_file_name))
	{
		//return $search_file_name;
		return "data:image/jpg;base64,".c_image($search_file_name);
	}

	$search_file_name = BASE_FILE_NAME_FOR_IMG."left_side_logo.png";
	return "data:image/jpg;base64,".c_image($search_file_name);
}


function get_pp_pix($vApplicationNo)
{
	$mysqli = link_connect_db();
	$vmask = '';

	$cFacultyId = '';

	$vApplicationNo = $vApplicationNo ?? '';

	if ($vApplicationNo == '')
	{
		if ((isset($_REQUEST['vMatricNo']) && $_REQUEST['vMatricNo'] <> '') || (isset($_REQUEST['uvApplicationNo']) && (substr($_REQUEST['uvApplicationNo'],0,3) == 'NOU' || substr($_REQUEST['uvApplicationNo'],0,3) == 'COL')))
		{
			$student_id = '';
			if (isset($_REQUEST['vMatricNo']) && $_REQUEST['vMatricNo'] <> '')
			{
				$student_id = $_REQUEST['vMatricNo'];
			}else if (substr($_REQUEST['uvApplicationNo'],0,3) == 'NOU' || substr($_REQUEST['uvApplicationNo'],0,3) == 'COL')
			{
				$student_id = $_REQUEST['uvApplicationNo'];
			}
			
			$stmt_last = $mysqli->prepare("SELECT a.vApplicationNo, trim(vmask) FROM pics a, afnmatric b WHERE a.vApplicationNo = b.vApplicationNo AND b.vMatricNo = ? AND cinfo_type = 'p'");
			$stmt_last->bind_param("s", $student_id);
		}else if (isset($_REQUEST['uvApplicationNo']) && $_REQUEST['uvApplicationNo'] <> '')
		{
			$stmt_last = $mysqli->prepare("SELECT a.vApplicationNo, trim(vmask) FROM pics a, afnmatric b WHERE a.vApplicationNo = b.vApplicationNo AND (b.vApplicationNo = ? OR b.vMatricNo = ?) and cinfo_type = 'p'");
			$stmt_last->bind_param("ss", $_REQUEST["uvApplicationNo"], $_REQUEST["uvApplicationNo"]);
		}else if (isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] <> '' && $_REQUEST['user_cat'] == 3)
		{
			$stmt_last = $mysqli->prepare("SELECT vApplicationNo, trim(vmask) FROM pics WHERE vApplicationNo  = ? and cinfo_type = 'p'");
			$stmt_last->bind_param("s", $_REQUEST["vApplicationNo"]);
		}

		if (isset($stmt_last))
		{
			$stmt_last->execute();
			$stmt_last->store_result();
			if ($stmt_last->num_rows > 0)
			{
				$stmt_last->bind_result($vApplicationNo, $vmask);
				$stmt_last->fetch();
			}
			$stmt_last->close();
		}
	}else if (substr($vApplicationNo,0,3) == 'NOU')
	{
		$stmt_last = $mysqli->prepare("SELECT a.vApplicationNo, trim(vmask) FROM pics a, afnmatric b WHERE a.vApplicationNo = b.vApplicationNo AND b.vMatricNo = ? AND cinfo_type = 'p'");
		$stmt_last->bind_param("s", $vApplicationNo);
		$stmt_last->execute();
		$stmt_last->store_result();
		$stmt_last->bind_result($vApplicationNo, $vmask);
		$stmt_last->fetch();
		$stmt_last->close();
	}

	if ((isset($_REQUEST['vMatricNo']) && $_REQUEST['vMatricNo'] <> '') || (isset($_REQUEST['uvApplicationNo']) && (substr($_REQUEST['uvApplicationNo'],0,3) == 'NOU' || substr($_REQUEST['uvApplicationNo'],0,3) == 'COL')))
	{
		if (isset($_REQUEST['vMatricNo']) && $_REQUEST['vMatricNo'] <> '')
		{
			$student_id = $_REQUEST['vMatricNo'];
		}else if ((isset($_REQUEST['uvApplicationNo']) && (substr($_REQUEST['uvApplicationNo'],0,3) == 'NOU' || substr($_REQUEST['uvApplicationNo'],0,3) == 'COL')))
		{
			$student_id = $_REQUEST['uvApplicationNo'];
		}
		
		$stmt = $mysqli->prepare("SELECT cFacultyId  
		FROM s_m_t WHERE vMatricNo = ?");
		$stmt->bind_param("s", $student_id);
		
		$stmt->execute();
		$stmt->store_result();		
		$stmt->bind_result($cFacultyId);
		$stmt->fetch();
		$stmt->close();
	}else if (substr($vApplicationNo,0,3) <> 'NOU' && substr($vApplicationNo,0,3) <> 'COL')
	{
		$stmt = $mysqli->prepare("SELECT cFacultyId  
		FROM prog_choice WHERE vApplicationNo = ?");		
		$stmt->bind_param("s", $vApplicationNo);
		$stmt->execute();
		$stmt->store_result();		
		$stmt->bind_result($cFacultyId);
		$stmt->fetch();
		$stmt->close();

		$vmask = get_mask($vApplicationNo);
	}

	$cFacultyId = $cFacultyId ?? '';
	
	$search_file_name = BASE_FILE_NAME_FOR_PP. "p_".$vmask.".jpg"; 
	if(file_exists($search_file_name))
	{
		return "data:image/jpg;base64,".c_image($search_file_name);
	}
	
	$search_file_name = BASE_FILE_NAME_FOR_PP. "p_".$vmask.".jpeg"; 
	if(file_exists($search_file_name))
	{
		return "data:image/jpg;base64,".c_image($search_file_name);
	}

	$search_file_name = BASE_FILE_NAME_FOR_PP. "p_".$vmask.".png";
	if(file_exists($search_file_name))
	{
		return "data:image/jpg;base64,".c_image($search_file_name);
	}

	

	if ($cFacultyId == '')
	{
		return "data:image/jpg;base64,".c_image(BASE_FILE_NAME_FOR_IMG."left_side_logo.png");
	}
	

	$search_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/pp/p_".$vmask.".jpg";
	if(file_exists($search_file_name))
	{
		return "data:image/jpg;base64,".c_image($search_file_name);
	}

	$search_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/pp/p_".$vmask.".jpeg";
	if(file_exists($search_file_name))
	{
		return "data:image/jpg;base64,".c_image($search_file_name);
	}

	$search_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/pp/p_".$vmask.".png";
	if(file_exists($search_file_name))
	{
		return "data:image/jpg;base64,".c_image($search_file_name);
	}

	if(file_exists(BASE_FILE_NAME_FOR_IMG."left_side_logo.png"))
	{
		return "data:image/jpg;base64,".c_image(BASE_FILE_NAME_FOR_IMG."left_side_logo.png");
	}
}


function get_cert_pix($id)
{
	$mysqli = link_connect_db();

	$stmt = $mysqli->prepare("SELECT cFacultyId  
	FROM prog_choice WHERE vApplicationNo = ?");		
	$stmt->bind_param("s", $id);
	$stmt->execute();
	$stmt->store_result();		
	$stmt->bind_result($cFacultyId);
	$stmt->fetch();
	$stmt->close();
	
	$cFacultyId = $cFacultyId ?? '';
	if ($cFacultyId == '')
	{
		$stmt = $mysqli->prepare("SELECT cFacultyId  
		FROM s_m_t WHERE vApplicationNo = ?");		
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->store_result();		
		$stmt->bind_result($cFacultyId);
		$stmt->fetch();
		$stmt->close();
	}
	
	if (isset($_REQUEST['cQualCodeId_01']) && isset($_REQUEST['vExamNo_01']) &&
	$_REQUEST['cQualCodeId_01'] <> '' && $_REQUEST['vExamNo_01'] <> '')
	{
		$cQualCodeId_local = $_REQUEST['cQualCodeId_01'];
		$vExamNo_local = $_REQUEST['vExamNo_01'];
	}else if (isset($_REQUEST["cQualCodeId"]) && isset($_REQUEST["vExamNo"]) &&
	$_REQUEST["cQualCodeId"] <> '' && $_REQUEST["vExamNo"] <> '')
	{
		$cQualCodeId_local = $_REQUEST["cQualCodeId"];
		$vExamNo_local = $_REQUEST["vExamNo"];
	}

	$stmt_last = $mysqli->prepare("SELECT trim(vmask) FROM pics WHERE vApplicationNo  = ? AND cQualCodeId = ? AND vExamNo = ?");
	$stmt_last->bind_param("sss", $id, $cQualCodeId_local, $vExamNo_local);
	$stmt_last->execute();
	$stmt_last->store_result();
	$stmt_last->bind_result($vmask);
	$stmt_last->fetch();
	$stmt_last->close();

	$vmask = $vmask ?? '';

	$search_file_name = BASE_FILE_NAME_FOR_PP.$cQualCodeId_local."_".$vExamNo_local."_".$vmask.".jpg";
	$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/cc/".$cQualCodeId_local."_".$vExamNo_local."_".$vmask.".jpg";
	
	if(file_exists($pix_file_name))
	{
		return "data:image/jpg;base64,".c_image($pix_file_name);
	}else if(file_exists($search_file_name))
	{
		return $search_file_name;
	}else if(file_exists(BASE_FILE_NAME_FOR_IMG."left_side_logo.jpg"))
	{
		return "data:image/jpg;base64,".c_image(BASE_FILE_NAME_FOR_IMG."left_side_logo.jpg");
	}else if(file_exists(BASE_FILE_NAME_FOR_IMG."left_side_logo.png"))
	{
		return "data:image/png;base64,".c_image(BASE_FILE_NAME_FOR_IMG."left_side_logo.png");
	}
}


function get_mask($spec_req)
{
	$mysqli = link_connect_db();

	if (substr($spec_req,0,3) == 'NOU' || substr($spec_req,0,3) == 'COL')
	{
		$stmt_last = $mysqli->prepare("SELECT trim(vmask) FROM pics a, afnmatric b WHERE a.vApplicationNo = b.vApplicationNo AND b.vMatricNo = ? AND cinfo_type = 'p'");
	}else
	{
		$stmt_last = $mysqli->prepare("SELECT trim(vmask) FROM pics WHERE vApplicationNo = ? AND cinfo_type = 'p'");
	}

	$stmt_last->bind_param("s", $spec_req);
	$stmt_last->execute();
	$stmt_last->store_result();
	$stmt_last->bind_result($vmask);
	$stmt_last->fetch();
	$stmt_last->close();

	$vmask = $vmask ?? '';

	return $vmask;
}


function get_staff_mask($spec_req)
{
	$mysqli = link_connect_db();

	$stmt_last = $mysqli->prepare("SELECT trim(vmask) FROM staff_pics WHERE vApplicationNo = ?");

	$stmt_last->bind_param("s", $spec_req);
	$stmt_last->execute();
	$stmt_last->store_result();
	$stmt_last->bind_result($vmask);
	$stmt_last->fetch();
	$stmt_last->close();

	$vmask = $vmask ?? '';
	
	
	$search_file_name = BASE_FILE_NAME_FOR_STAFF. "p_".$vmask.".jpg"; 
	if(file_exists($search_file_name))
	{
		return "data:image/jpg;base64,".c_image($search_file_name);
	}
	
	$search_file_name = BASE_FILE_NAME_FOR_STAFF. "p_".$vmask.".jpeg"; 
	if(file_exists($search_file_name))
	{
		return "data:image/jpg;base64,".c_image($search_file_name);
	}

	$search_file_name = BASE_FILE_NAME_FOR_STAFF. "p_".$vmask.".png";
	if(file_exists($search_file_name))
	{
		return "data:image/jpg;base64,".c_image($search_file_name);
	}	

	if(file_exists("img/p_.png"))
	{
		return "data:image/jpg;base64,".c_image("img/p_.png");
	}

	return '';
}


function get_mask_for_certs($spec_req, $cQualCodeId_local, $vExamNo_local)
{
	$mysqli = link_connect_db();

	$stmt_last = $mysqli->prepare("SELECT trim(vmask) FROM pics WHERE vApplicationNo  = ? AND cQualCodeId = ? AND vExamNo = ?");

	$stmt_last->bind_param("sss", $spec_req, $cQualCodeId_local, $vExamNo_local);
	$stmt_last->execute();
	$stmt_last->store_result();
	$stmt_last->bind_result($vmask);
	$stmt_last->fetch();
	$stmt_last->close();

	$vmask = $vmask ?? '';

	return $vmask;
}

function get_mask_for_b_certs($spec_req)
{
	$mysqli = link_connect_db();

	$stmt_last = $mysqli->prepare("SELECT trim(vmask) FROM pics WHERE vApplicationNo  = ? AND cinfo_type  = 'bc'");
	$stmt_last->bind_param("s", $spec_req);
	$stmt_last->execute();
	$stmt_last->store_result();
	$stmt_last->bind_result($vmask);
	$stmt_last->fetch();
	$stmt_last->close();

	$vmask = $vmask ?? '';

	return $vmask;
}

function get_mask_for_yc_certs($spec_req)
{
	$mysqli = link_connect_db();

	$stmt_last = $mysqli->prepare("SELECT trim(vmask) FROM pics WHERE vApplicationNo  = ? AND cinfo_type  = 'yc'");
	$stmt_last->bind_param("s", $spec_req);
	$stmt_last->execute();
	$stmt_last->store_result();
	$stmt_last->bind_result($vmask);
	$stmt_last->fetch();
	$stmt_last->close();

	$vmask = $vmask ?? '';

	return $vmask;
}

function get_mask_for_mc_certs($spec_req)
{
	$mysqli = link_connect_db();

	$stmt_last = $mysqli->prepare("SELECT trim(vmask) FROM pics WHERE vApplicationNo  = ? AND cinfo_type  = 'mc'");
	$stmt_last->bind_param("s", $spec_req);
	$stmt_last->execute();
	$stmt_last->store_result();
	$stmt_last->bind_result($vmask);
	$stmt_last->fetch();
	$stmt_last->close();

	$vmask = $vmask ?? '';

	return $vmask;
}


function get_active_request($spec_req)
{
	date_default_timezone_set('Africa/Lagos');
	$id = '';
	if (isset($_REQUEST['uvApplicationNo']) && $_REQUEST['uvApplicationNo'] <> '')
	{
		$id = $_REQUEST['uvApplicationNo'];
	}else if (isset($_REQUEST['vMatricNo']) && $_REQUEST['vMatricNo'] <> '')
	{
		$id = $_REQUEST['vMatricNo'];
	}

	$mysqli = link_connect_db();
	
	$stmt = $mysqli->prepare("SELECT semester_reg,crs_reg,drp_crs_reg,see_crs_reg_slip,exam_reg,drp_exam_reg,see_exam_reg_slip,time_act,duration, TIMESTAMPDIFF(MINUTE,time_act,NOW()), used
	FROM vc_request
	WHERE vMatricNo = ?
	AND cdel = 'N'
    AND used = '0'
	ORDER BY time_act DESC LIMIT 1");
	$stmt->bind_param("s", $id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($semester_reg, $crs_reg, $drp_crs_reg, $see_crs_reg_slip, $exam_reg, $drp_exam_reg, $see_exam_reg_slip, $time_act, $duration, $time_elapse, $used);
	if ($stmt->num_rows > 0)
	{
		$stmt->fetch();
		
		if ($time_elapse < $duration && $used == '0')
		{
			if ($spec_req == 0)
			{
				return $semester_reg;
			}else if ($spec_req == 1)
			{
				return $crs_reg;
			}else if ($spec_req == 2)
			{
				return $drp_crs_reg;
			}else if ($spec_req == 3)
			{
				return $see_crs_reg_slip;
			}else if ($spec_req == 4)
			{
				return $exam_reg;
			}else if ($spec_req == 5)
			{
				return $drp_exam_reg;
			}else if ($spec_req == 6)
			{
				return $see_exam_reg_slip;
			}
		}
	}
	$stmt->close();

	return '';
}


function get_faculties($remember)
{
	$sql1 = "SELECT cFacultyId, vFacultyDesc FROM faculty WHERE cCat = 'A' AND cFacultyId <> 'CEG' AND cDelFlag = 'N' ORDER BY vFacultyDesc";
	$rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
	<option value="" selected="selected">Select faculty</option><<?php
	while ($table= mysqli_fetch_array($rsql1))
	{?>
		<option value="<?php echo $table[0] ?>" <?php if(isset($remember) && $remember == $table[0]){echo ' selected';}?> >
			<?php echo $table[1];?>
		</option><?php
	}
	mysqli_close(link_connect_db());
}


function begin_end_level($limit)
{
	if (isset($_REQUEST["level_options"]))
	{
		$t1 = 0; $t2 = 0;
		if (substr($_REQUEST["level_options"],0,3) == 'PGD')
		{
			$t1 = 700;
			$t2 = 700;
		}else if (substr($_REQUEST["level_options"],0,1) == 'M' || substr($_REQUEST["level_options"],0,6) == 'Common' || substr($_REQUEST["level_options"],0,3) == 'LLM')
		{
			$t1 = 800;
			$t2 = 800;
		}else if (substr($_REQUEST["level_options"],0,1) == 'B')
		{
			$t1 = 100;
			$t2 = 300;
			if ($_REQUEST['cFacultyIdold07'] == 'EDU' || $_REQUEST["cprogrammeIdold"] == 'ART2')
			{                                                
				$t1 = 100;
				$t2 = 200;
			}else if ($_REQUEST['cFacultyIdold07'] == 'HSC')
			{
				$t1 = 200;
				$t2 = 300;

				if ($_REQUEST["cprogrammeIdold"] == 'HSC201' || $_REQUEST["cprogrammeIdold"] == 'HSC202' || $_REQUEST["cprogrammeIdold"] == 'HSC204')
				{
					$t1 = 200;
					$t2 = 200;
				}
			}else if ($_REQUEST['cFacultyIdold07'] == 'MSC')
			{
				$t1 = 100;
				$t2 = 300;

				if ($_REQUEST["cprogrammeIdold"] == 'MSC207')
				{
					$t1 = 100;
					$t2 = 300;
				}
			}else if ($_REQUEST['cFacultyIdold07'] == 'CMP')
			{
				$t1 = 100;
				$t2 = 300;
			}else if ($_REQUEST['cFacultyIdold07'] == 'SCI')
			{
				$t1 = 100;
				$t2 = 300;

				if ($_REQUEST["cprogrammeIdold"] == 'SCI204' || $_REQUEST["cprogrammeIdold"] == 'SCI207' || $_REQUEST["cprogrammeIdold"] == 'SCI210')
				{
					$t1 = 100;
					$t2 = 200;
				}
			}else if ($_REQUEST['cFacultyIdold07'] == 'SSC')
			{
				$t1 = 100;
				$t2 = 300;

				if ($_REQUEST["cprogrammeIdold"] == 'SSC205' || $_REQUEST["cprogrammeIdold"] == 'SSC206' || $_REQUEST["cprogrammeIdold"] == 'SSC201' || $_REQUEST["cprogrammeIdold"] == 'SSC209')
				{
					$t1 = 100;
					$t2 = 200;
				}
			}
		}else if (substr($_REQUEST["level_options"],0,1) == 'Phi')
		{
			$t1 = 900;
			$t2 = 900;
		}else 
		{
			$t1 = 1000;
			$t2 = 1000;
		}

		if ($limit == 0){return $t1;}
		if ($limit == 1){return $t2;}
	}

	return 0;
}


function get_ctry_of_res_u()
{
	$mysqli = link_connect_db();

	if (!(isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '' && (substr($_REQUEST["uvApplicationNo"],0,3) == 'NOU' || substr($_REQUEST["uvApplicationNo"],0,3) == 'COL')))
	{
		return '';
	}

	if (substr($_REQUEST["uvApplicationNo"],0,3) == 'NOU' || substr($_REQUEST["uvApplicationNo"],0,3) == 'COL')
	{
		$stmt = $mysqli->prepare("SELECT cResidenceCountryId from s_m_t where vMatricNo = ?");
	}else
	{
		//$stmt = $mysqli->prepare("SELECT cResidenceCountryId from res_addr where vApplicationNo = ?");
		$stmt = $mysqli->prepare("SELECT resident_ctry from prog_choice where vApplicationNo = ?");
		
	}
	
	$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cResidenceCountryId);
	$stmt->fetch();
	$stmt->close();

	$img = '';
	$title = '';
	if ($cResidenceCountryId == 'NG' || $cResidenceCountryId == '1')
	{
		$img = 'ng.png';
		$title = 'Resident in Nigeria';
	}else
	{
		$img = 'frn.png';
		$title = 'Resident abroad';
	}?>
	
	<img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.$img);?>"  width="20px" height="20px" style="margin: 6px"; title="<?php echo $title;?>"/><?php
}


function select_curriculum($id)
{
	$mysqli = link_connect_db();

	$stmt = $mysqli->prepare("SELECT cAcademicDesc_1 from s_m_t WHERE vMatricNo = ?");
	$stmt->bind_param("s", $id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cAcademicDesc_1);
	$stmt->fetch();
	$stmt->close();
	
	$new_curr = " AND b.cAcademicDesc <= 2023";
	if ($cAcademicDesc_1 > 2023)
	{
		//$new_curr = " AND b.cAcademicDesc = 2024";
	}

	return $new_curr;
}


function delete_pp_file()
{
	$mysqli = link_connect_db();

	$stmt_last = $mysqli->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? and cinfo_type = 'p'");
	$stmt_last->bind_param("s", $_REQUEST["uvApplicationNo"]);
	$stmt_last->execute();
	$stmt_last->store_result();
	$stmt_last->bind_result($vmask);
	$stmt_last->fetch();			
	$stmt_last->close();


	@unlink(BASE_FILE_NAME_FOR_PP."p_" .$vmask.'jpg');
	@unlink(BASE_FILE_NAME_FOR_PP."p_" .$vmask.'jpeg');
}


function delete_staff_pp_file($id)
{
	$mysqli = link_connect_db();

	$stmt_last = $mysqli->prepare("SELECT vmask FROM staff_pics WHERE vApplicationNo = ?");
	$stmt_last->bind_param("s", $id);
	$stmt_last->execute();
	$stmt_last->store_result();
	$stmt_last->bind_result($vmask);
	$stmt_last->fetch();			
	$stmt_last->close();

	$vmask = $vmask ?? '';
	if ($vmask == '')
	{
		return;
	}
	
	@unlink(BASE_FILE_NAME_FOR_STAFF."p_" .$vmask.'.jpg');	
}


function get_fee_item_id($desc)
{
	$mysqli = link_connect_db();

	$stmt_last = $mysqli->prepare("SELECT fee_item_id FROM fee_items WHERE LCASE(fee_item_desc) = LCASE(?)");
	$stmt_last->bind_param("s", $desc);
	$stmt_last->execute();
	$stmt_last->store_result();
	$stmt_last->bind_result($fee_item_id);
	$stmt_last->fetch();			
	$stmt_last->close();

	$fee_item_id = $fee_item_id ?? '';

	return $fee_item_id;
}


function c_image($i_name)
{
	if (!file_exists($i_name))
	{
		//$i_name = BASE_FILE_FOR_INDEX_IMG.'left_side_logo.png';
		$i_name = './img/left_side_logo.png';
	}
	
	$img = file_get_contents($i_name);
	return base64_encode($img);
}





function get_faculties_if_u_know($remember)
{
	$cProgrammeId = '';
	$cEduCtgId = '';

	
	$mysqli = link_connect_db();
	
	$sql1 = "SELECT LCASE(cFacultyId), vFacultyDesc FROM faculty WHERE cCat = 'A' AND cDelFlag = 'N' ORDER BY vFacultyDesc";

	/*if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] == 3 && isset($_REQUEST["vApplicationNo"]))
	{
		$stmt = $mysqli->prepare("SELECT cProgrammeId, cEduCtgId FROM prog_choice WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($cProgrammeId, $cEduCtgId);
		$stmt->fetch();
		$stmt->close();
			
		$cProgrammeId = $cProgrammeId ?? '';
		$cEduCtgId = $cEduCtgId ?? '';

		if ($cProgrammeId <> '' && $cEduCtgId == 'ELX')
		{
			$sql1 = "SELECT LCASE(cFacultyId) FROM faculty WHERE cFacultyId = LEFT('$cProgrammeId',3) AND cDelFlag = 'N' ORDER BY vFacultyDesc";
		}
	}*/	

	$rsql1 = mysqli_query($mysqli, $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
	<option value="" selected="selected">Select faculty if you know</option><<?php
	while ($table= mysqli_fetch_array($rsql1))
	{?>
		<option value="<?php echo $table[0] ?>" <?php if(isset($remember) && $remember == $table[0]){echo ' selected';}?> >
			<?php echo $table[1];?>
		</option><?php
	}
	mysqli_close(link_connect_db());
}


function src_table($pry_tab)
{
    if (isset($_REQUEST["faculty_u_no"]) && $_REQUEST["faculty_u_no"] <> '')
    {
        if ($_REQUEST["faculty_u_no"] == 'chd' || $_REQUEST["faculty_u_no"] == 'deg')
        {
            return $pry_tab."_elx";
        }else
        {
            return $pry_tab."_".$_REQUEST["faculty_u_no"];
        }
    }else
    {
        return $pry_tab;
    }
}
$mysqli = link_connect_db();?>