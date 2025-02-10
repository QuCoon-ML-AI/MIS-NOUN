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
	strpos($_SERVER['REQUEST_URI'],'student_reset_password') || 
	strpos($_SERVER['REQUEST_URI'],'print_identity_card') ||
	strpos($_SERVER['REQUEST_URI'],'check_student_token') ||
	strpos($_SERVER['REQUEST_URI'],'check_for_running_programme') || 
	strpos($_SERVER['REQUEST_URI'],'preview-form') ||  
	strpos($_SERVER['REQUEST_URI'],'see-admission-slip') || 
	strpos($_SERVER['REQUEST_URI'],'student_login_check') || 
	strpos($_SERVER['REQUEST_URI'],'opr_') ||
	isset($_REQUEST["just_coming"])))
{
	/*if (!isset($_REQUEST['ilin']) || (isset($_REQUEST['ilin']) && $_REQUEST['ilin'] == ''))
	{
		header('Location: ../');
		exit;
	}
	
	if (isset($_REQUEST['login_status']) && $_REQUEST['login_status'] == '0')
	{
		eexit();
		header('Location: ../');
		exit;
	}*/
	
	if (session_timer() == 0)
	{
		header('Location: ../');
		exit;
	}
}

		
date_default_timezone_set('Africa/Lagos');
$date2 = date("Y-m-d h:i:s");

function eyes_pilled($val)
{
    return 1;
}


function eexit()
{
	$user_name = '';

	if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> '')
	{
		$user_name = $_REQUEST['vMatricNo'];
	}else if (isset($_REQUEST["vApplicationNo"]) && $_REQUEST['vApplicationNo'] <> '')
	{
		$user_name = $_REQUEST['vApplicationNo'];
	}else if (isset($_REQUEST['logged_in_user']))
	{
		$user_name = $_REQUEST['logged_in_user'];
	}
	
	$stmt = $mysqli->prepare("DELETE FROM ses_tab WHERE vApplicationNo = ?");
	$stmt->bind_param("s",  $user_name);
	$stmt->execute();
	$stmt->close();

	date_default_timezone_set('Africa/Lagos');
	$date2 = date("Y-m-d h:i:s");

	$stmt = $mysqli->prepare("DELETE FROM ses_tab WHERE TIMESTAMPDIFF(MINUTE,time_stamp,'$date2') >= 60");
	$stmt->execute();
	$stmt->close();
}

function session_timer()
{	
	$user_name = '';

	if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> '')
	{
		$user_name = $_REQUEST['vMatricNo'];
	}else if (isset($_REQUEST["vApplicationNo"]) && $_REQUEST['vApplicationNo'] <> '')
	{
		$user_name = $_REQUEST['vApplicationNo'];
	}else if (isset($_REQUEST['logged_in_user']))
	{
		$user_name = $_REQUEST['logged_in_user'];
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

			if (is_null($ilin))
			{
				$ilin = '';
			}
			
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
		
		if ($time_stamp > $orgsetins["tIdl_time"])
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
	}else if (isset($_REQUEST['justcomin']) && $_REQUEST['justcomin'] == '1')
	{
		return '1';	
	}
	return '1';
}


function create_session()
{
    include('../../PHPMailer/mail_con.php');

	$mysqli = link_connect_db();

    $user_id = '';
	/*try
	{
		$mysqli->autocommit(FALSE); //turn on transactions
	*/	
		$stmt = $mysqli->prepare("DELETE FROM ses_tab WHERE vApplicationNo = ?");
		if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> '')
		{
			$user_id = $_REQUEST['vMatricNo'];
		}else if (isset($_REQUEST["vApplicationNo"]) && $_REQUEST['vApplicationNo'] <> '')
		{
			$user_id = $_REQUEST['vApplicationNo'];
		}
		
		$stmt->bind_param("s", $user_id);
		$stmt->execute();
		$stmt->close();

		//date_default_timezone_set('Africa/Lagos');
		
		$date2 = date("Y-m-d h:i:s");
		$date3 = date("Y-m-d");
		
		$today = getdate();
		$min = ($today['hours'] * 60) + $today['minutes'];
		$ilin = date("dmyHis");
		
		$stmt = $mysqli->prepare("REPLACE INTO ses_tab 
		SET vApplicationNo = ?,
		ilin = '$ilin',
		dtl_date = '$date3',
		timer_prev = $min,
		time_stamp = '$date2'");
		$stmt->bind_param("s", $user_id);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare("DELETE FROM lg_a_t WHERE vu_id = ?");
		$stmt->bind_param("s", $user_id);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare("DELETE FROM ses_tab WHERE TIMESTAMPDIFF(HOUR,dtl_date,'$date2') > 24");
		$stmt->execute();
		$stmt->close();

		if (isset($_REQUEST['user_cat']) && $_REQUEST['user_cat'] <> '')
		{
			if ($_REQUEST['user_cat'] == '4' || $_REQUEST['user_cat'] == '5')
			{
				if (isset($_REQUEST['vMatricNo']))
				{
					$val_field = $_REQUEST['vMatricNo'];
				}

				if ($_REQUEST['user_cat'] == '4')
				{
					$source_table = 'prog_choice';
					$source_table2 = 'afnmatric';
				}else if ($_REQUEST['user_cat'] == '5')
				{
					$source_table = 's_m_t';
				}
			}else if ($_REQUEST['user_cat'] == '2' || $_REQUEST['user_cat'] == '3')
			{
				$val_field = $_REQUEST['vApplicationNo'];
				$source_table = 'prog_choice';
			}else if ($_REQUEST['user_cat'] == '1')
			{
				$val_field = $_REQUEST['vApplicationNo'];
				$source_table = 'remitapayments_app';
			}else 
			{
				$val_field = $_REQUEST['vApplicationNo'];
				$source_table = 'userlogin';
			}
			
			
			if ($_REQUEST['user_cat'] == '2' || $_REQUEST['user_cat'] == '3')
			{
				$stmt_1 = $mysqli->prepare("SELECT vFirstName, vEMailId
				FROM $source_table
				WHERE vApplicationNo = ?");
			}elseif ($_REQUEST['user_cat'] == '4')
			{
				$stmt_1 = $mysqli->prepare("SELECT a.vFirstName, vEMailId
				FROM $source_table a, $source_table2 b
				WHERE a.vApplicationNo = b.vApplicationNo
				AND b.vMatricNo = ?");
			}else if ($_REQUEST['user_cat'] == '5')
			{
				$stmt_1 = $mysqli->prepare("SELECT vFirstName, vEMailId
				FROM $source_table
				WHERE vMatricNo = ?");
			}else if ($_REQUEST['user_cat'] == '1')
			{
				$stmt_1 = $mysqli->prepare("SELECT vFirstName, payerEmail
				FROM $source_table
				WHERE Regno = ?");
			}else
			{
				$stmt_1 = $mysqli->prepare("SELECT vFirstName, cemail
				FROM $source_table
				WHERE vApplicationNo = ?");
			}
			
			$stmt_1->bind_param("s", $val_field);
			$stmt_1->execute();
			$stmt_1->store_result();
			$stmt_1->bind_result($vFirstName, $vEMailId);
			$stmt_1->fetch();

            if ($_REQUEST['user_cat'] == '5')
			{
			    $vEMailId = strtolower($val_field).'@noun.edu.ng';
			    //$vEMailId = 'aadeboyejo@noun.edu.ng';
			}else
			{
			    if (is_null($vEMailId))
				{
					$vEMailId = '';
					echo 'eMail address error';
				}
			}
			
            if ($vEMailId <> '' && ($_REQUEST["user_cat"] == 6 || $_REQUEST["user_cat"] == 5))
            {
    			$subject = 'NOUN MIS Support - New Login';
    			$mail_msg = "Dear $vFirstName,<br><br>
    			Your user account ($val_field) has been used to login.
    			<p>If this is not you, please login emmediately and change your password or contact MIS to disable your account
    			<p>Thank you";
    
    			$mail_msg = wordwrap($mail_msg, 70);
    			
    			$date2 = date("Y-m-d h:i:s");

				//$vEMailId = 'xx@noun.edu.ng';
    					
    			$mail->addAddress($vEMailId, $vFirstName); // Add a recipient
    			$mail->Subject = $subject;
    			$mail->Body = $mail_msg;
				try
	            {
    				if ($vEMailId <> '')
					{
						$mail->send();
					}
				}catch(Exception $e) 
				{
					//throw $e;
					echo 'eMail address error';
				}
            }

			if ($_REQUEST["user_cat"] == 6)
			{
				$stmt_1 = $mysqli->prepare("UPDATE userlogin
				SET cap_text = 'xxxxxxx'
				WHERE vApplicationNo  = ?");
				$stmt_1->bind_param("s", $_REQUEST["vApplicationNo"]);
				$stmt_1->execute();
			}else if ($_REQUEST["user_cat"] == 5)
			{
				$stmt_1 = $mysqli->prepare("UPDATE rs_client
				SET cap_text = 'xxxxxxx'
				WHERE vMatricNo  = ?");
				$stmt_1->bind_param("s", $_REQUEST["vMatricNo"]);
				$stmt_1->execute();
			}else if ($_REQUEST["user_cat"] == 3)
			{
				$stmt_1 = $mysqli->prepare("UPDATE app_client
				SET cap_text = 'xxxxxxx'
				WHERE vApplicationNo  = ?");
				$stmt_1->bind_param("s", $_REQUEST["vApplicationNo"]);
				$stmt_1->execute();
			}
			$stmt_1->close();
		}

	/*	$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
	}catch(Exception $e) 
	{
		$mysqli->rollback(); //remove all queries from queue if error (undo)
		throw $e;
	}*/

	echo 'session created'.hash('sha512', $ilin);
    //echo $ilin;
}


function clean_up()
{ 	
	$mysqli = link_connect_db();

    $stmt = $mysqli->prepare("DELETE FROM ses_tab WHERE vApplicationNo = ?");
    if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> '')
    {
        $user_id = $_REQUEST['vMatricNo'];
    }else if (isset($_REQUEST["vApplicationNo"]) && $_REQUEST['vApplicationNo'] <> '')
    {
        $user_id = $_REQUEST['vApplicationNo'];
    }
    $stmt->bind_param("s", $user_id);
    $stmt->execute();	
    $stmt->close();
}


function get_mail_add($user_name)
{
	$mysqli = link_connect_db();
	
    $stmt_1 = $mysqli->prepare("SELECT mail_id FROM mail_rec WHERE vApplicationNo = ?");
	$stmt_1->bind_param("s", $user_name);
	$stmt_1->execute();
	$stmt_1->store_result();
	$stmt_1->bind_result($vEMailId);
	$stmt_1->fetch();
	$stmt_1->close();
	
	$vEMailId = $vEMailId ?? '';
	
	return $vEMailId;
}

function valid_afn()
{
    $mysqli = link_connect_db();
    
    $stmt_a = $mysqli->prepare("SELECT vApplicationNo FROM app_client WHERE vApplicationNo = ?");
    $stmt_a->bind_param("s", $_REQUEST['vApplicationNo']);
    $stmt_a->execute();
    $stmt_a->store_result();

	if ($stmt_a->num_rows == 0)
	{
		$stmt_a = $mysqli->prepare("SELECT vApplicationNo FROM prog_choice WHERE vApplicationNo = ?");
		$stmt_a->bind_param("s", $_REQUEST['vApplicationNo']);
		$stmt_a->execute();
		$stmt_a->store_result();

		if ($stmt_a->num_rows <> 0)
		{
			$stmt = $mysqli->prepare("INSERT INTO app_client SET
			vPassword = 'frsh', 
			cpwd = '0',
			vApplicationNo = ?");
			$stmt->bind_param("s", $_REQUEST['vApplicationNo']);
			$stmt->execute();
			$stmt->close();

			return 1;
		}else
		{
			return 0;
		}
	}else
	{
		return $stmt_a->num_rows;
	}
}


function valid_mtn()
{
    if (!isset($_REQUEST['vMatricNo']))
	{
		return 0;
	}

	if (strlen($_REQUEST['vMatricNo']) == 21)
	{
		$vMatricNo = clean_string_as($_REQUEST['vMatricNo'],'matno_');
	}else
	{
		$vMatricNo = clean_string_as($_REQUEST['vMatricNo'],'matno');
	}
	
	$mysqli = link_connect_db();

	$stmt_a = $mysqli->prepare("SELECT * FROM s_m_t_grad_mat_list WHERE vMatricNo = ? and statuss = '1'");
    $stmt_a->bind_param("s", $vMatricNo);
    $stmt_a->execute();
    $stmt_a->store_result();
    $mtn_valid = $stmt_a->num_rows;
	if ($mtn_valid <> 0)
	{
		return 4;
	}
    
    $stmt_a = $mysqli->prepare("SELECT * FROM afnmatric WHERE vMatricNo = ?");
    $stmt_a->bind_param("s", $vMatricNo);
    $stmt_a->execute();
    $stmt_a->store_result();
    $mtn_valid = $stmt_a->num_rows;

	if ($mtn_valid == 0)
	{
		$stmt_a = $mysqli->prepare("SELECT * FROM all_mtns WHERE vMatricNo = ?");
		$stmt_a->bind_param("s", $vMatricNo);
		$stmt_a->execute();
		$stmt_a->store_result();
		$mtn_valid = $stmt_a->num_rows;

		if ($mtn_valid <> 0)
		{
			return 2;
		}
	}

	$stmt_a = $mysqli->prepare("SELECT * FROM s_m_t WHERE cProgrammeId = 'LAW201' AND vMatricNo = ?");
	$stmt_a->bind_param("s", $vMatricNo);
	$stmt_a->execute();
	$stmt_a->store_result();
	$mtn_valid1 = $stmt_a->num_rows;
	if ($mtn_valid1 <> 0)
	{
		return 3;
	}

	return $mtn_valid;
}



function mtn_in_arch()
{
    $mysqli_arch = link_connect_db_arch();
    
    $stmt_a = $mysqli_arch->prepare("SELECT vApplicationNo FROM arch_afnmatric WHERE vMatricNo = ?");
    $stmt_a->bind_param("s", $_REQUEST['vMatricNo']);
    $stmt_a->execute();
    $stmt_a->store_result();
    return $stmt_a->num_rows;
}


function count_login_attempt()
{
    date_default_timezone_set('Africa/Lagos');
    $date2 = date("Y-m-d H:i:s");

	$mysqli = link_connect_db();

	$val_field = '';
	if (isset($_REQUEST['vMatricNo']) && $_REQUEST['vMatricNo'] <> '')
	{
		$val_field = $_REQUEST['vMatricNo'];
	}else if (isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] <> '')
	{
		$val_field = $_REQUEST['vApplicationNo'];
	}
		
	if ($val_field == ''){return;}

	$stmt_a = $mysqli->prepare("SELECT action_time FROM lg_a_t 
	WHERE LEFT(action_time,10) = CURDATE() 
	AND taken_act LIKE 'Login attempt failed%'
	AND vu_id = ? 
	ORDER BY action_time ASC LIMIT 5");
    $stmt_a->bind_param("s", $val_field);
    $stmt_a->execute();
    $stmt_a->store_result();
    
	if ($stmt_a->num_rows == 5)
	{
		$stmt_a->bind_result($elapsed_time);
		$stmt_a->data_seek(4);
		$stmt_a->fetch();
		
		$date1 = strtotime($elapsed_time); 
		$date3 = strtotime($date2); 
		$diff = abs($date3 - $date1);
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24) / (60*60*24));
		$hours = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24 - $days * 60*60*24) / (60*60));
		$minutes = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24 - $days * 60*60*24 - $hours * 60*60) / 60);

		if ($minutes < 5)
		{
			return $elapsed_time.'min';
		}else
		{
			$stmt = $mysqli->prepare("DELETE FROM lg_a_t WHERE vu_id = ?");
			$stmt->bind_param("s", $val_field);
			$stmt->execute();
			$stmt->close();

			return 5;
		}
		
	}
    return $stmt_a->num_rows.'*';
}


function log_actv($vDeed)
{
	$mysqli = link_connect_db();
	
	$val_field = '';
	if (isset($_REQUEST['user_cat']) && !isset($_REQUEST["payerPhone"]))
	{
		if ($_REQUEST['user_cat'] == '4' || $_REQUEST['user_cat'] == '5')
		{
			if (isset($_REQUEST['vMatricNo'])){$val_field = $_REQUEST['vMatricNo'];}
		}else if (isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] <> '')
		{
			$val_field = $_REQUEST['vApplicationNo'];
		}
	}else if (isset($_REQUEST["payerPhone"]))
	{
	    $val_field = $_REQUEST["payerPhone"];
	}else if ($val_field == '')
	{
	    return;
	}
	
	$count_login_attempt = count_login_attempt();
	$count_login_attempt = $count_login_attempt ?? '';

	if (strpos($count_login_attempt,"*"))
	{
		$count_login_attempt = substr($count_login_attempt, 0, 1);
	}
		
	date_default_timezone_set('Africa/Lagos');
    $date2 = date("Y-m-d h:i:s");

	try
	{
		$mysqli->autocommit(FALSE); //turn on transactions

		if (is_numeric($count_login_attempt) && $count_login_attempt <= 5 && $val_field <> '' && !isset($_REQUEST["payerPhone"]))
		{
			$stmt = $mysqli->prepare("INSERT INTO lg_a_t SET  
			vu_id  = ?,
			taken_act = ?,
            action_time = '$date2'");
			$stmt->bind_param("ss", $val_field, $vDeed);
			$stmt->execute();
			$stmt->close();
		}

		$ipee = getIPAddress();

		$stmt = $mysqli->prepare("INSERT INTO atv_log SET 
		vApplicationNo  = ?,
		vDeed = ?,
		act_location = ?,
		tDeedTime = '$date2'");
		$stmt->bind_param("sss", $val_field, $vDeed, $ipee);
		$stmt->execute();
		$stmt->close();

		$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
	}catch(Exception $e) 
	{
		$mysqli->rollback(); //remove all queries from queue if error (undo)
		throw $e;
	}
	
	$stmt = $mysqli->prepare("SELECT tDeedTime FROM atv_log where vApplicationNo = ? order by tDeedTime desc limit 1");
	$stmt->bind_param("s",$val_field);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($tDeedTime);
	$stmt->fetch();
	$stmt->close();
	return $tDeedTime;
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
		}
	}	
	return '';
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




function stdnt_name()
{
	$vApplicationNo = '';
    if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '')
	{
		$vApplicationNo = $_REQUEST["uvApplicationNo"];
	}elseif (isset($_REQUEST["vApplicationNo"]))
	{
		$vApplicationNo = $_REQUEST["vApplicationNo"];
	}else
	{
	    return '';
	}
	
	$mysqli = link_connect_db();
	
	$stmt = $mysqli->prepare("select vLastName,vFirstName,vOtherName from prog_choice where vApplicationNo = ?");
	$stmt->bind_param("s",$vApplicationNo);
	$stmt->execute();
	$stmt->store_result();
	
	if ($stmt->num_rows > 0)
	{		
		$stmt->bind_result($vLastName, $vFirstName, $vOtherName);
		$stmt->fetch();
		$vOtherName = $vOtherName ?? ' ';
		$namess = strtoupper($vLastName).' '.ucwords(strtolower($vFirstName)).' '.ucwords(strtolower($vOtherName));
		
		$stmt->close();
		return $namess;
	}else
	{
		return '';
	}
}



function get_pp_pix($vApplicationNo)
{
	$mysqli = link_connect_db();
	$vmask = '';
	$cFacultyId = '';

	if ($vApplicationNo == '')
	{
		if (isset($_REQUEST['user_cat']))
		{
			if ($_REQUEST['user_cat'] == 1 || $_REQUEST['user_cat'] == 3 || $_REQUEST['user_cat'] == 4)
			{
				$stmt_last = $mysqli->prepare("SELECT vApplicationNo, trim(vmask) FROM pics WHERE vApplicationNo  = ? and cinfo_type = 'p'");
				$stmt_last->bind_param("s", $_REQUEST["vApplicationNo"]);

				$stmt = $mysqli->prepare("SELECT cFacultyId FROM prog_choice WHERE vApplicationNo = ?");		
				$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();		
				$stmt->bind_result($cFacultyId);
				$stmt->fetch();
				$stmt->close();
			}else if ($_REQUEST['user_cat'] == 5)
			{
				$stmt_last = $mysqli->prepare("SELECT a.vApplicationNo, trim(vmask) FROM pics a, afnmatric b WHERE a.vApplicationNo = b.vApplicationNo AND b.vMatricNo = ? AND cinfo_type = 'p'");
				$stmt_last->bind_param("s", $_REQUEST["vMatricNo"]);

				$stmt = $mysqli->prepare("SELECT cFacultyId FROM s_m_t WHERE vMatricNo = ?");		
				$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
				$stmt->execute();
				$stmt->store_result();		
				$stmt->bind_result($cFacultyId);
				$stmt->fetch();
				$stmt->close();
			}else if ($_REQUEST['user_cat'] == 6)
			{
				if (isset($_REQUEST['uvApplicationNo']) && $_REQUEST['uvApplicationNo'] <> '')
				{
					if (substr($_REQUEST['uvApplicationNo'],0,3) == 'NOU' || substr($_REQUEST['uvApplicationNo'],0,3) == 'COL')
					{
						$stmt_last = $mysqli->prepare("SELECT a.vApplicationNo, trim(vmask) FROM pics a, afnmatric b WHERE a.vApplicationNo = b.vApplicationNo AND b.vMatricNo = ? AND cinfo_type = 'p'");
						$stmt_last->bind_param("s", $_REQUEST["uvApplicationNo"]);

						$stmt = $mysqli->prepare("SELECT cFacultyId FROM s_m_t WHERE vMatricNo = ?");		
						$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
						$stmt->execute();
						$stmt->store_result();		
						$stmt->bind_result($cFacultyId);
						$stmt->fetch();
						$stmt->close();
					}else
					{
						$stmt_last = $mysqli->prepare("SELECT vApplicationNo, trim(vmask) FROM pics WHERE vApplicationNo  = ? and cinfo_type = 'p'");
						$stmt_last->bind_param("s", $_REQUEST["uvApplicationNo"]);

						$stmt = $mysqli->prepare("SELECT cFacultyId FROM prog_choice WHERE vApplicationNo = ?");		
						$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
						$stmt->execute();
						$stmt->store_result();		
						$stmt->bind_result($cFacultyId);
						$stmt->fetch();
						$stmt->close();
					}
				}else if (isset($_REQUEST['vMatricNo']) && $_REQUEST['vMatricNo'] <> '')
				{
					$stmt_last = $mysqli->prepare("SELECT a.vApplicationNo, trim(vmask) FROM pics a, afnmatric b WHERE a.vApplicationNo = b.vApplicationNo AND b.vMatricNo = ? AND cinfo_type = 'p'");
					$stmt_last->bind_param("s", $_REQUEST["vMatricNo"]);

					$stmt = $mysqli->prepare("SELECT cFacultyId FROM s_m_t WHERE vMatricNo = ?");		
					$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
					$stmt->execute();
					$stmt->store_result();		
					$stmt->bind_result($cFacultyId);
					$stmt->fetch();
					$stmt->close();
				}
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
		}else
		{
			return "data:image/jpg;base64,".c_image(BASE_FILE_NAME_FOR_IMG."left_side_logo.png");
		}
	}else if (substr($vApplicationNo,0,3) == 'NOU')
	{
		$stmt_last = $mysqli->prepare("SELECT a.vApplicationNo, trim(vmask), cFacultyId FROM pics a, s_m_t b WHERE a.vApplicationNo = b.vApplicationNo AND b.vMatricNo = ? AND cinfo_type = 'p'");
		$stmt_last->bind_param("s", $vApplicationNo);
		$stmt_last->execute();
		$stmt_last->store_result();
		$stmt_last->bind_result($vApplicationNo, $vmask, $cFacultyId);
		$stmt_last->fetch();
		$stmt_last->close();
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


	$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/pp/p_".$vmask.".jpg";
	if(file_exists($pix_file_name))
	{
		return "data:image/jpg;base64,".c_image($pix_file_name);
	}

	$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/pp/p_".$vmask.".jpeg";
	if(file_exists($pix_file_name))
	{
		return "data:image/jpg;base64,".c_image($pix_file_name);
	}

	$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/pp/p_".$vmask.".png";
	if(file_exists($pix_file_name))
	{
		return "data:image/jpg;base64,".c_image($pix_file_name);
	}


	if(file_exists(BASE_FILE_NAME_FOR_IMG."left_side_logo.png"))
	{
		return "data:image/jpg;base64,".c_image(BASE_FILE_NAME_FOR_IMG."left_side_logo.png");
	}
}



function build_mobile_menu($sidemenu)
{
	$mysqli = link_connect_db();
	$cSCrnd = '';
	$stmt = $mysqli->prepare("SELECT cSCrnd FROM prog_choice WHERE vApplicationNo = ?");
	$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cSCrnd);
	$stmt->fetch();
	$stmt->close();
	
	if (is_null($cSCrnd))
	{
		$cSCrnd = '';
	}?>
	<div class="appl_left_child_btn_div" style="margin-top:0px;"><?php
		if ($sidemenu == 1)
		{?>
			<button type="button" class="dull_button">
				<img width="40" height="35" src="./img/biodata.png" alt="biodata">
				<br>Biodata
			</button><?php
		}else
		{?>
			<button type="button" class="button"
				onclick="in_progress('1');form_sections.sidemenu.value=1;form_sections.action='appl-biodata';form_sections.submit();">
				<img width="40" height="35" src="./img/biodata.png" alt="biodata">
				<br>Biodata
			</button><?php
		}?>
	</div>
	<div class="appl_left_child_btn_div"><?php
		if ($sidemenu == 2)
		{?>
			<button type="button" class="dull_button">
				<img width="35" height="25" src="./img/envelope-line.png" alt="biodata">
				<br>
				Contact (Postal) address</button><?php
		}else
		{?>
			<button type="button" class="button"
				onclick="in_progress('1');form_sections.sidemenu.value=2;form_sections.action='postal-address';form_sections.submit();">
				<img width="35" height="25" src="./img/envelope-line.png" alt="biodata">
				<br>
				Contact (Postal) address</button><?php
		}?>
	</div>
	<div class="appl_left_child_btn_div"><?php
		if ($sidemenu == 3)
		{?>
			<button type="button" class="dull_button">
				<img width="35" height="25" src="./img/envelope-line1.png" alt="biodata">
				<br>Contact (Residential) address</button><?php
		}else
		{?>
			<button type="button" class="button"
				onclick="in_progress('1');form_sections.sidemenu.value=3;form_sections.action='residential-address';form_sections.submit();">
				<img width="35" height="25" src="./img/envelope-line1.png" alt="biodata">
				<br>Contact (Residential) address</button><?php
		}?>
	</div>
	<div class="appl_left_child_btn_div"><?php
		if ($sidemenu == 4)
		{?>
			<button type="button" class="dull_button">
				<img width="35" height="25" src="./img/envelope-line1.png" alt="biodata">
				<br>Next of Kin</button><?php
		}else
		{?>
			<button type="button" class="button">
				<img width="40" height="28" src="./img/nok.png" alt="biodata"
				onclick="in_progress('1');form_sections.sidemenu.value=4;form_sections.action='programme-of-choice';form_sections.submit();">
				<br>Next of Kin</button><?php
		}?>
	</div>
	<div class="appl_left_child_btn_div"><?php
		if ($sidemenu == 5 || $cSCrnd ==  '3')
		{?>
			<button type="button" class="dull_button">
				<img width="35" height="25" src="./img/envelope-line1.png" alt="biodata">
				<br>Academic Qualification</button><?php
		}else
		{?>
			<button type="button" class="button">
				<img width="40" height="32" src="./img/cert.png" alt="biodata"
				onclick="in_progress('1');form_sections.sidemenu.value=5;form_sections.action='programme-of-choice';form_sections.submit();">
				<br>Academic Qualification</button><?php
		}?>
	</div>
	<div class="appl_left_child_btn_div">
		<button type="button" class="button">
			<img width="40" height="32" src="./img/choice.png" alt="biodata">
			<br>Choice of Programme</button>
	</div>
	<div class="appl_left_child_btn_div">
		<button type="button" class="button"
		onclick="in_progress('1');appl_lgin_pg.logout.value='1';
		appl_lgin_pg.submit();">
			<img width="40" height="32" src="./img/logout.png" alt="Logout">
			<br>Logout</button>
	</div><?php
}


function build_menu($sidemenu)
{
	$mysqli = link_connect_db();
	$cSCrnd = '';
	$stmt = $mysqli->prepare("SELECT cSCrnd FROM prog_choice WHERE vApplicationNo = ?");
	$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cSCrnd);
	$stmt->fetch();
	$stmt->close();
	
	if (is_null($cSCrnd))
	{
		$cSCrnd = '';
	}?>
	<div class="appl_left_child_btn_div" style="margin-top:20px;"><?php
		if ($sidemenu == '1a')
		{?>
			<button type="button" class="dull_button">
				<img width="37" height="32" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'biodata.png');?>" alt="biodata">
				<br>Biodata 1 of 2...
			</button><?php
		}else
		{?>
			<button type="button" class="appl_button"
				onclick="form_sections.sidemenu.value='1a'; form_sections.action='appl-biodata_1'; app_confirm_box();">
				<img width="37" height="32" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'biodata.png');?>" alt="biodata">
				<br>Biodata 1 of 2...
			</button><?php
		}?>
	</div>
	<div class="appl_left_child_btn_div">
		<?php
		if ($sidemenu == '1b')
		{?>
			<button type="button" class="dull_button">
				<img width="37" height="32" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'biodata.png');?>" alt="biodata">
				<br>Biodata 2 of 2...
			</button><?php
		}else
		{?>
			<button type="button" class="appl_button"
				onclick="form_sections.sidemenu.value='1b';form_sections.action='appl-biodata_2'; app_confirm_box();">
				<img width="37" height="32" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'biodata.png');?>" alt="biodata">
				<br>Biodata 2 of 2...
			</button><?php
		}?>
	</div>
	<div class="appl_left_child_btn_div"><?php
		if ($sidemenu == 2)
		{?>
			<button type="button" class="dull_button">
			<img width="35" height="25" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'envelope-line.png');?>" alt="biodata">
			<br>
			Contact (Postal) address</button><?php
		}else
		{?>
			<button type="button" class="appl_button"
				onclick="form_sections.sidemenu.value=2;form_sections.action='postal-address'; app_confirm_box();">
			<img width="35" height="25" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'envelope-line.png');?>" alt="biodata">
			<br>
			Contact (Postal) address</button><?php
		}?>
	</div>
	<div class="appl_left_child_btn_div"><?php
		if ($sidemenu == 3)
		{?>
			<button type="button" class="dull_button">
			<img width="35" height="25" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'envelope-line1.png');?>" alt="biodata">
			<br>Contact (Residential) address</button><?php
		}else
		{?>
			<button type="button" class="appl_button"
				onclick="form_sections.sidemenu.value=3;form_sections.action='residential-address'; app_confirm_box();">
			<img width="35" height="25" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'envelope-line1.png');?>" alt="biodata">
			<br>Contact (Residential) address</button><?php
		}?>
	</div>
	<div class="appl_left_child_btn_div"><?php
		if ($sidemenu == 4)
		{?>
			<button type="button" class="dull_button">
			<img width="35" height="25" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'nok.png');?>" alt="biodata">
			<br>Next of Kin</button><?php
		}else
		{?>
			<button type="button" class="appl_button"
				onclick="form_sections.sidemenu.value=4;form_sections.action='next-of-kin'; app_confirm_box();">
			<img width="35" height="25" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'nok.png');?>" alt="biodata">
			<br>Next of Kin</button><?php
		}?>
	</div>
	<div class="appl_left_child_btn_div"><?php
		if ($sidemenu == 5 || $cSCrnd == '3')
		{?>
			<button type="button" class="dull_button">
			<img width="30" height="25" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'certificate.png');?>" alt="biodata">
			<br>Academic Qualification</button><?php
		}else
		{?>
			<button type="button" class="appl_button"
				onclick="form_sections.sidemenu.value=5;form_sections.action='academic-history'; app_confirm_box();">
			<img width="30" height="25" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'certificate.png');?>" alt="biodata">
			<br>Academic Qualification</button><?php
		}?>
	</div>
	<div class="appl_left_child_btn_div"><?php
		if ($sidemenu == 6 || $cSCrnd == '3')
		{?>
			<button type="button" class="dull_button">
			<img width="35" height="25" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'choice.png');?>" alt="biodata">
			<br>Choice of Programme</button><?php
		}else
		{?>
			<button type="button" class="appl_button"
				onclick="form_sections.sidemenu.value=6;form_sections.action='programme-of-choice'; app_confirm_box();">
			<img width="35" height="25" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'choice.png');?>" alt="biodata">
			<br>Choice of Programme</button><?php
		}?>
	</div>
	<div class="appl_left_child_btn_div">
		<button type="button" class="appl_button" 
		onclick="appl_lgin_pg.logout.value='1';
		appl_lgin_pg.submit();">
			<img width="32" height="32" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'logout.png');?>" alt="Logout">
			<br>Logout</button>
	</div>
                
	<!--<div class="appl_left_child_btn_div" style="margin-top:200px; width:100%;">
		Power
	</div>--><?php
}


function build_dull_menu()
{?>
	<div class="appl_left_child_btn_div" style="margin-top:20px;" title="Buttons deactivated because you have submitted your form">
		<button type="button" class="dull_button">
			<img width="40" height="35" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'biodata.png');?>" alt="biodata">
			<br>Biodata
		</button>
	</div>
	<div class="appl_left_child_btn_div" title="Buttons deactivated because you have submitted your form">
		<button type="button" class="dull_button">
			<img width="35" height="25" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'envelope-line.png');?>" alt="biodata">
			<br>
			Contact (Postal) address</button>
	</div>
	<div class="appl_left_child_btn_div" title="Buttons deactivated because you have submitted your form">
		<button type="button" class="dull_button">
			<img width="35" height="25" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'envelope-line1.png');?>" alt="biodata">
			<br>Contact (Residential) address</button>
	</div>
	<div class="appl_left_child_btn_div" title="Buttons deactivated because you have submitted your form">
		<button type="button" class="dull_button">
			<img width="35" height="25" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'nok.png');?>" alt="biodata">
			<br>Next of Kin</button>
	</div>
	<div class="appl_left_child_btn_div" title="Buttons deactivated because you have submitted your form">
		<button type="button" class="dull_button">
			<img width="25" height="25" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'cert.png');?>" alt="biodata">
			<br>Academic Qualification</button>
	</div>
	<div class="appl_left_child_btn_div" title="Buttons deactivated because you have submitted your form">
			<button type="button" class="dull_button">
			<img width="34" height="25" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'choice.png');?>" alt="biodata">
			<br>Choice of Programme</button>
	</div>
	<div class="appl_left_child_btn_div">
		<button type="button" class="button" 
		onclick="appl_lgin_pg.logout.value='1';
		appl_lgin_pg.submit();">
			<img width="35" height="32" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'logout.png');?>" alt="Logout">
			<br>Logout</button>
	</div>
                
	<!--<div class="appl_left_child_btn_div" style="margin-top:200px; width:100%;">
		Power
	</div>--><?php
}

function left_conttent_for_receipt($desc, $id)
{?>
	<div class="appl_left_div">
		<div class="appl_left_child_logo_div"></div>
		<div class="appl_left_child_div" style="margin-top:0px; font-size:1.7em; font-weight:bold">National Open University of Nigeria</div>
		<div class="appl_left_child_div" style="margin-top:15px; font-size:1.4em"><?php echo $desc;?></div>
		<div class="appl_left_child_div" style="margin-top:15px; font-size:1.4em">
			<img src="<?php echo get_pp_pix($id);?>" width="140px" height="140px" />
		</div>

		<!-- <div class="appl_left_child_div">(C) National Open University of Nigeria</div> -->
	</div><?php
}


function left_conttent($desc)
{?>
	<div class="appl_left_div">
		<div class="appl_left_child_logo_div"></div>
		<div class="appl_left_child_div" style="margin-top:0px; font-size:1.7em; font-weight:bold">National Open University of Nigeria</div>
		<div class="appl_left_child_div" style="margin-top:15px; font-size:1.4em"><?php echo $desc;?></div>
		<div class="appl_left_child_div" style="margin-top:15px; font-size:1.4em"><?php
		if (!is_bool(strpos($_SERVER['REQUEST_URI'], "pay-for-application-form")))
		{?>
			<a href="../ext_docs/newlyApprovedProcessForUndergraduateAdmission1.pdf" target="_blank" style="text-decoration:none;">Undergraduate admission application process (2025)</a><?php
		}?>
		</div>

		<!-- <div class="appl_left_child_div">(C) National Open University of Nigeria</div> -->
	</div><?php
}

function appl_prv_top_menu()
{?>
	<div class="data_line data_line_logout" style="display:flex; padding:0px; width:98.7%; height:auto; margin-top:0px; justify-content:space-between; background-color:#eff5f0">
		<div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
			<button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
				onclick="appl_hpg.sidemenu.value='';appl_hpg.submit();">
				<img width="30" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'home.png');?>" alt="Home">
				<br>Home</button>
		</div>
		<div class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
			<button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
			onclick="appl_lgin_pg.logout.value='1';
			appl_lgin_pg.submit();">
			<img width="30" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'logout.png');?>" alt="Logout">
			<br>Logout</button>
		</div>
	</div><?php
}


function appl_top_menu()
{?>
	<div class="data_line data_line_logout" style="display:flex; padding:0px; width:98.7%; height:auto; margin-top:5px; justify-content:space-between;">
		<div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
			<button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
				onclick="appl_hpg.sidemenu.value='';appl_hpg.submit();">
				<img width="25" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'home.png');?>" alt="Home">
				<br>Home</button>
		</div><?php
		$mysqli = link_connect_db();
		
		$stmt_prog_choice = $mysqli->prepare("SELECT * FROM prog_choice WHERE vApplicationNo = ? AND cProgrammeId <> ''");
		$stmt_prog_choice->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt_prog_choice->execute();
		$stmt_prog_choice->store_result();
		$prog_choice_made = $stmt_prog_choice->num_rows;
		$stmt_prog_choice->close();
		if($prog_choice_made <> 0)
		{?>
			<div class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
				<button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
				onclick="form_sections.action='preview-form'; in_progress('1'); form_sections.submit();">
				<img width="20" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'preview.png');?>" alt="Preview form">
				<br>Preview form</button>
			</div><?php
		}?>

		<div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
			<button type="button" class="button" style="padding:5px; border:1px solid #b6b6b6;" 
				onclick="ps.sidemenu.value=''; ps.target='_blank'; ps.action='guides-instructions';
				ps.submit();">
				<img width="20" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'help.png');?>" alt="Home">
				<br>Help</button>
		</div>
		
		<div class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
			<button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
			onclick="appl_lgin_pg.logout.value='1';
			appl_lgin_pg.submit();">
			<img width="20" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'logout.png');?>" alt="Logout">
			<br>Logout</button>
		</div>
	</div><?php
}

function appl_top_menu_home()
{?>
	<div class="appl_left_child_div" style=" margin-top:0px; margin-bottom:0px; padding:0px; width:100%;">
		<div class="data_line data_line_logout" style="display:flex; flex-direction:row; justify-content:space-between; gap:10px; width:100%; padding:0px; height:auto; margin-top:5px">
			<div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
				<button type="button" class="button" style="padding:5px; border:1px solid #b6b6b6;" 
					onclick="ps.sidemenu.value='';ps.action='../';
					ps.submit();">
					<img width="25" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'home.png');?>" alt="Home">
					<br>Home</button>
			</div>

			<div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
				<button type="button" class="button" style="padding:5px; border:1px solid #b6b6b6;" 
					onclick="ps.sidemenu.value=''; ps.target='_blank'; ps.action='guides-instructions';
					ps.submit();">
					<img width="20" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'help.png');?>" alt="Home">
					<br>Help</button>
			</div>
			
			<div class="data_line_child data_line_child_home" style="margin:0px; width:auto;">
				<div class="appl_left_child_div_child" style="gap:0px; margin:0px; text-align:center;">
					<img id="remit_img" src="./img/remitahorizon.png" style="height:55px; width:100%" onclick="caution_inform('Click the Next button'); return false"/>
				</div>
			</div>
		</div>
	</div><?php
}


function settns()
{
	$rssqlsettns = mysqli_query(link_connect_db(), "SELECT * FROM settns") or die(mysqli_error(link_connect_db()));	
	return mysqli_fetch_array($rssqlsettns);
}


function settns_deg()
{
	$rssqlsettns = mysqli_query(link_connect_db(), "SELECT * FROM other_cals WHERE prog_name = 'DEG'") or die(mysqli_error(link_connect_db()));	
	return mysqli_fetch_array($rssqlsettns);
}


function settns_chd()
{
	$rssqlsettns = mysqli_query(link_connect_db(), "SELECT * FROM other_cals WHERE prog_name = 'CHD'") or die(mysqli_error(link_connect_db()));	
	return mysqli_fetch_array($rssqlsettns);
}


function settns_spg()
{
	$rssqlsettns = mysqli_query(link_connect_db(), "SELECT * FROM other_cals WHERE prog_name = 'SPG'") or die(mysqli_error(link_connect_db()));	
	return mysqli_fetch_array($rssqlsettns);
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


function alloc_dum_pin($rrr)
{
	$mysqli = link_connect_db();
	
	$c = 0;
	while (1 == 1 /*|| $c <= 10*/)
	{
    	$randomid = mt_rand(100000,999999);
		$randomid = date("y").$randomid;
    	
		$remitapayments_app_record = 0;

    	$stmt_g = $mysqli->prepare("SELECT * FROM remitapayments_app WHERE Regno = '$randomid';");
    	$stmt_g->execute();
    	$stmt_g->store_result();
		$remitapayments_app_record = $stmt_g->num_rows;


		$app_client_record = 0;

    	$stmt_g = $mysqli->prepare("SELECT * FROM app_client WHERE vApplicationNo = '$randomid';");
    	$stmt_g->execute();
    	$stmt_g->store_result();
		$app_client_record = $stmt_g->num_rows;


		$app_client_b24_record = 0;

    	$stmt_g = $mysqli->prepare("SELECT * FROM app_client_b24 WHERE vApplicationNo = '$randomid';");
    	$stmt_g->execute();
    	$stmt_g->store_result();
		$app_client_b24_record = $stmt_g->num_rows;
		

		$prog_choice_record = 0;

    	$stmt_g = $mysqli->prepare("SELECT * FROM prog_choice WHERE vApplicationNo = '$randomid';");
    	$stmt_g->execute();
    	$stmt_g->store_result();
		$prog_choice_record = $stmt_g->num_rows;

    	if ($remitapayments_app_record == 0 && $app_client_record == 0 && $prog_choice_record == 0 && $app_client_b24_record == 0)
    	{
            try
        	{
        		$mysqli->autocommit(FALSE); //turn on transactions
        		
        		$stmt = $mysqli->prepare("UPDATE remitapayments_app SET Regno = '$randomid' WHERE RetrievalReferenceNumber = ? AND Regno = ''");	
        		$stmt->bind_param("s", $rrr);
        		$stmt->execute();
        
        		$stmt = $mysqli->prepare("INSERT IGNORE INTO app_client SET
        		vPassword = 'frsh', 
        		cpwd = '0',
        		vApplicationNo = '$randomid'");
        		$stmt->execute();
        
        		$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
        		
        		$stmt->close();
        	    $stmt_g->close();
        	    
        	    return $randomid;
        	}catch(Exception $e) 
        	{
        		$mysqli->rollback(); //remove all queries from queue if error (undo)
        		throw $e;
        	}
    	}
    	
    	$c++;
    }
    $stmt_g->close();
}


function alloc_dum_pin_old($rrr)
{
	$mysqli = link_connect_db();
	
	$next_afn = '';
	$afn_prefix = '';

	$afn_prefix = date("y");
	
	$stmt = $mysqli->prepare("SELECT CONCAT('$afn_prefix',RIGHT(MAX(RIGHT(Regno,6)), 6)+1) FROM remitapayments_app WHERE Regno LIKE '$afn_prefix%';");
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($next_afn);
	$stmt->fetch();
	$stmt->close();

	$next_afn = $next_afn ?? '';

	if ($next_afn == '')
	{
		$next_afn = $afn_prefix."100000";
	}

	try
	{
		$mysqli->autocommit(FALSE); //turn on transactions
		
		$stmt = $mysqli->prepare("UPDATE remitapayments_app SET Regno = '$next_afn' WHERE RetrievalReferenceNumber = ? AND Regno = ''");	
		$stmt->bind_param("s", $rrr);
		$stmt->execute();

		$stmt = $mysqli->prepare("INSERT IGNORE INTO app_client SET
		vPassword = 'frsh', 
		cpwd = '0',
		vApplicationNo = '$next_afn'");
		$stmt->execute();

		$stmt->close();

		$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
		
		return $next_afn;
	}catch(Exception $e) 
	{
		$mysqli->rollback(); //remove all queries from queue if error (undo)
		throw $e;
	}
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


function get_nxt_sn ($vMatricNo, $iItemID, $vremark, $cEduCtgId){
	$mysqli = link_connect_db();

	$orgsetins = settns();

	$iItemID_lc_c = '';
	if ($iItemID <> '')
	{
		$iItemID_lc_c = " AND iItemID = $iItemID ";
	}

	$sub_qry = " AND tSemester = " . $orgsetins['tSemester'];
	if ($cEduCtgId == 'ELX')
	{
		$sub_qry = " AND tSemester = 1";
	}

	$stmt_get_nxt_sn = $mysqli->prepare("SELECT MAX(trans_count) + 1 FROM s_tranxion_20242025 
	WHERE vMatricNo = '$vMatricNo'
	AND cAcademicDesc = '".$orgsetins['cAcademicDesc']."'
	$sub_qry
	AND vremark = '$vremark'
	$iItemID_lc_c");
	$stmt_get_nxt_sn->execute();
	$stmt_get_nxt_sn->store_result();
	$stmt_get_nxt_sn->bind_result($nxt_sn);
	$stmt_get_nxt_sn->fetch();
	$stmt_get_nxt_sn->close();
	
	$nxt_sn = $nxt_sn ?? 0;
	
	return $nxt_sn;
}


function get_nxt_sn_cr (){
	$mysqli = link_connect_db();

	$orgsetins = settns();

    while(1==1)
    {
        $token = openssl_random_pseudo_bytes(6);
		$token = strtoupper(bin2hex($token));
		
		$stmt_get_nxt_sn = $mysqli->prepare("SELECT * FROM s_tranxion_cr 
	    WHERE RetrievalReferenceNumber  = '$token'");
    	$stmt_get_nxt_sn->execute();
    	$stmt_get_nxt_sn->store_result();
    	if ($stmt_get_nxt_sn->num_rows == 0)
    	{
    	    return $token;
    	}
    }
}


function initite_write_debit_transaction($matNo, $session, $semester, $cCourseId, $vremark)
{
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



function gaurd_seq($val)
{
	if (!isset($_REQUEST["vApplicationNo"])){return;}
    
	$num_of_rows = 1;
	$mysqli = link_connect_db();
	
	if ($val > 5)
	{
		$stmt = $mysqli->prepare("SELECT * FROM applyqual WHERE vApplicationNo = ? AND cQualCodeId NOT IN (SELECT cQualCodeId FROM applysubject  WHERE vApplicationNo = ?)");
	}else if ($val > 4)
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


function get_cert_pix($id)
{
	$mysqli = link_connect_db();

	$vmask = '';
	
	if (isset($GLOBALS['cQualCodeId_01']) && isset($GLOBALS['vExamNo_01']) &&
	$GLOBALS['cQualCodeId_01'] <> '' && $GLOBALS['vExamNo_01'] <> '')
	{
		$cQualCodeId_local = $GLOBALS['cQualCodeId_01'];
		$vExamNo_local = $GLOBALS['vExamNo_01'];
	}else if (isset($_REQUEST["cQualCodeId"]) && isset($_REQUEST["vExamNo"]) &&
	$_REQUEST["cQualCodeId"] <> '' && $_REQUEST["vExamNo"] <> '')
	{
		$cQualCodeId_local = $_REQUEST["cQualCodeId"];
		$vExamNo_local = $_REQUEST["vExamNo"];
	}

	
	if ($id == '')
	{
		if (isset($_REQUEST['vMatricNo']) && $_REQUEST['vMatricNo'] <> '')
		{
			$stmt_last = $mysqli->prepare("SELECT a.vApplicationNo, trim(vmask) FROM pics a, afnmatric b 
			WHERE a.vApplicationNo = b.vApplicationNo AND b.vMatricNo = ? and cQualCodeId = '$cQualCodeId_local' and vExamNo = '$vExamNo_local'");
			$stmt_last->bind_param("s", $_REQUEST["vMatricNo"]);

			$id = $_REQUEST["vMatricNo"];
		}else if (isset($_REQUEST['uvApplicationNo']) && $_REQUEST['uvApplicationNo'] <> '')
		{
			$stmt_last = $mysqli->prepare("SELECT a.vApplicationNo, trim(vmask) FROM pics a, afnmatric b 
			WHERE a.vApplicationNo = b.vApplicationNo AND b.vMatricNo = ? and cQualCodeId = '$cQualCodeId_local' and vExamNo = '$vExamNo_local'");
			$stmt_last->bind_param("s", $_REQUEST["uvApplicationNo"]);
			$id = $_REQUEST["uvApplicationNo"];
		}else if (isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] <> '')
		{
			$stmt_last = $mysqli->prepare("SELECT trim(vmask) FROM pics 
			WHERE vApplicationNo  = ? and cQualCodeId = '$cQualCodeId_local' and vExamNo = '$vExamNo_local'");
			$stmt_last->bind_param("s", $_REQUEST["vApplicationNo"]);
			$id = $_REQUEST["vApplicationNo"];
		}	


		$stmt = $mysqli->prepare("SELECT cFacultyId  
		FROM prog_choice WHERE vApplicationNo = ?");		
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->store_result();		
		$stmt->bind_result($cFacultyId);
		$stmt->fetch();
		$stmt->close();

		$cFacultyId = $cFacultyId ?? '';
		
		if (isset($stmt_last))
		{
			$stmt_last->execute();
			$stmt_last->store_result();
			if ($stmt_last->num_rows > 0)
			{
				$stmt_last->bind_result($vmask);
				$stmt_last->fetch();
			}
			$stmt_last->close();
		}
	}

	$search_file_name = BASE_FILE_NAME_FOR_PP.$cQualCodeId_local."_".$vExamNo_local."_".$vmask.".jpg";
	$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/cc/".$cQualCodeId_local."_".$vExamNo_local."_".$vmask.".jpg";
	if(file_exists($pix_file_name))
	{
		return "data:image/jpg;base64,".c_image($pix_file_name);
	}else if(file_exists($search_file_name))
	{
		return "data:image/png;base64,".c_image($search_file_name);
	}

	$search_file_name = BASE_FILE_NAME_FOR_PP.$cQualCodeId_local."_".$vExamNo_local."_".$vmask.".jpeg";
	$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/cc/".$cQualCodeId_local."_".$vExamNo_local."_".$vmask.".jpeg";
	if(file_exists($pix_file_name))
	{
		return "data:image/jpeg;base64,".c_image($pix_file_name);
	}else if(file_exists($search_file_name))
	{
		return "data:image/png;base64,".c_image($search_file_name);
	}
	
	$search_file_name = BASE_FILE_NAME_FOR_PP.$cQualCodeId_local."_".$vExamNo_local."_".$vmask.".png"; 
	$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/cc/".$cQualCodeId_local."_".$vExamNo_local."_".$vmask.".png";

	if(file_exists($pix_file_name))
	{
		return "data:image/png;base64,".c_image($pix_file_name);
	}else if(file_exists($search_file_name))
	{
		return "data:image/png;base64,".c_image($search_file_name);
	}else
	{
		//if pdf file exist send it else send below
		return "data:image/jpg;base64,".c_image($pix_file_name."left_side_logo.png");
	}
}


function get_faculties($remember)
{
	$cProgrammeId = '';
	$cEduCtgId = '';

	
	$mysqli = link_connect_db();
	
	$sql1 = "SELECT cFacultyId, vFacultyDesc FROM faculty WHERE cCat = 'A' AND cFacultyId NOT IN ('DEG','CHD') AND cDelFlag = 'N' ORDER BY vFacultyDesc";

	if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] == 3 && isset($_REQUEST["vApplicationNo"]))
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

		//if ($cProgrammeId <> '' && $cEduCtgId == 'ELX')
		if ($cEduCtgId == 'ELX')
		{
			$sql1 = "SELECT cFacultyId, vFacultyDesc FROM faculty WHERE cFacultyId IN ('DEG','CHD') AND cDelFlag = 'N' ORDER BY vFacultyDesc";
		}
	}	

	$rsql1 = mysqli_query($mysqli, $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
	<option value="" selected="selected">Select faculty</option><<?php
	while ($table= mysqli_fetch_array($rsql1))
	{?>
		<option value="<?php echo $table[0] ?>" <?php if(isset($remember) && $remember == $table[0]){echo ' selected';}?> >
			<?php echo $table[1];?>
		</option><?php
	}
	mysqli_close(link_connect_db());
}


function student_signup()
{
	$mysqli = link_connect_db();
    
	$vPassword =''; 
	$vPassword_md5 = '';

    $stmt_a = $mysqli->prepare("SELECT vPassword, md5(?) vPassword_md5 FROM rs_client WHERE vMatricNo = ?");
	$stmt_a->bind_param("ss", $_REQUEST['vPassword'], $_REQUEST['vMatricNo']);
    $stmt_a->execute();
    $stmt_a->store_result();
    $stmt_a->bind_result($vPassword, $vPassword_md5);
    $stmt_a->fetch();
    $stmt_a->close();

	$vPassword = $vPassword ?? '';

	return $vPassword;
}


function delete_cert_file()
{
	$mysqli = link_connect_db();
	
	$file_name_ext = '';

	$image_properties = getimagesize($_FILES['sbtd_pix']['tmp_name']);
	if (!is_array($image_properties))
	{
		echo 'Select file of JPEG type to upload for copy of credential'; exit;
	}

	if ($image_properties["mime"] <> 'image/jpg' && $image_properties["mime"]  <> 'image/jpeg' && $image_properties["mime"]  <> 'image/pjpeg')
	{
		echo 'Select file of JPEG type to upload for copy of credential'; exit;
	}
	
	$file_name_ext = '.jpg';

//	$file_name_ext = '';

// 	if ($_REQUEST["file_type"] == 'image/png')
// 	{
// 		$file_name_ext = '.png';
// 	}else if ($_REQUEST["file_type"] == 'image/jpeg')
// 	{
// 		$file_name_ext = '.jpg';
// 	}else if ($_REQUEST["file_type"] == 'image/jpeg' || $_REQUEST["file_type"] == 'image/jpg')
// 	{
// 		$file_name_ext = '.jpg';
// 	}

// 	if ($file_name_ext == '')
// 	{
// 		echo 'File type unknown'.; exit;
// 	}

	$stmt_last = $mysqli->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? and cQualCodeId = ? and vExamNo = ? and cinfo_type = 'c'");
	$stmt_last->bind_param("sss", $_REQUEST["vApplicationNo"], $_REQUEST["hdcQualCodeId"], $_REQUEST["hdvExamNo"]);
	$stmt_last->execute();
	$stmt_last->store_result();
	$stmt_last->bind_result($vmask);
	$stmt_last->fetch();			
	$stmt_last->close();

	$flname = BASE_FILE_NAME_FOR_PP.$_REQUEST["hdcQualCodeId"]."_".addslashes($_REQUEST["hdvExamNo"])."_".$vmask.'.jpg';
	if (file_exists($flname))
	{
		@unlink($flname);
	}
}


function delete_pp_file()
{
	$mysqli = link_connect_db();

	$stmt_last = $mysqli->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? and cinfo_type = 'p'");
	$stmt_last->bind_param("s", $_REQUEST["vApplicationNo"]);
	$stmt_last->execute();
	$stmt_last->store_result();
	$stmt_last->bind_result($vmask);
	$stmt_last->fetch();			
	$stmt_last->close();


	@unlink(BASE_FILE_NAME_FOR_PP."p_" .$vmask.'png');
	@unlink(BASE_FILE_NAME_FOR_PP."p_" .$vmask.'jpg');
	@unlink(BASE_FILE_NAME_FOR_PP."p_" .$vmask.'jpeg');
	@unlink(BASE_FILE_NAME_FOR_PP."p_" .$vmask.'pjpeg');
}


function appl_form_header ($title,  $vEduCtgDesc, $vLastName, $vFirstName, $vOtherName, $vTitle)
{?>
	<div class="appl_left_child_div_child align_pp">
		<div style="flex:20%; padding-left:4px; height:auto;text-align:left;">
			<?php echo $title;?>
		</div>
		<div style="flex:45%; padding-left:4px; height:auto;text-align:left;">
			<?php echo $vEduCtgDesc.' Application Form<br>';
			echo $vLastName.' '.$vFirstName.' '.$vOtherName;
			
			if ($vTitle <> '')
			{
				echo ' ('.$vTitle.')';
			}?>
		</div>
		<div style="flex:10%; padding-left:4px; height:auto;text-align:left;">
			<?php echo 'Application form number '.$_REQUEST["vApplicationNo"]?>
		</div>
		<div style="flex:25%; padding-left:4px; height:auto;">
			<img style="width:135px; height:155px" src="<?php echo get_pp_pix('');?>" alt="biodata">
		</div>
	</div><?php
}


function foriegn_appl()
{
	$mysqli = link_connect_db();

	$orgsetins = settns();

	$stmt = $mysqli->prepare("SELECT * FROM s_tranxion_cr WHERE vremark LIKE '%Application Fee' AND amount IN ('8.00','12.00','32.00') AND cAcademicDesc = '".$orgsetins['cAcademicDesc']."' AND vMatricNo = ?");
	
	$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
	$stmt->execute();
	$stmt->store_result();
	return $stmt->num_rows;
}


function create_new_session($user_id)
{ 	
	$mysqli = link_connect_db();

    $stmt = $mysqli->prepare("DELETE FROM ses_tab WHERE vApplicationNo = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->close();

    date_default_timezone_set('Africa/Lagos');
	$date2 = date("Y-m-d");
	
	$today = getdate();
    $min = ($today['hours'] * 60) + $today['minutes'];
    $ilin = date("dmyHis");
    
    $stmt = $mysqli->prepare("REPLACE INTO ses_tab 
    SET vApplicationNo = ?,
    ilin = '$ilin',
    dtl_date = '$date2',
    timer_prev = $min");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->close();

	return hash('sha512', $ilin);
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


function get_fee_item_id_deg($desc)
{
	$mysqli = link_connect_db();

	$stmt_last = $mysqli->prepare("SELECT fee_item_id FROM fee_items WHERE fee_item_desc LIKE '%Course Registration%' $desc");
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
		$i_name = './img/left_side_logo.png';
	}
	
	$img = file_get_contents($i_name);
	return base64_encode($img);
}

function caution_box($msg)
{?>
	<div id="smke_screen_cb" class="smoke_scrn" style="display:block; z-index:2"></div>
	<div id="conf_warn" class="center" style="display:block; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:3; position:fixed;">
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
				_('smke_screen_cb').style.display= 'none';
				_('smke_screen_cb').style.zIndex= '-1';
				return false">
				<div class="submit_button_brown" style="width:60px; padding:6px; float:right">
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

function generate_string() 
{
	//$permitted_chars = '1234567890abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ[{}]';
	$permitted_chars = '123456789abcdefghijkmnpqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ[{}]';
	$input_length = strlen($permitted_chars);
	$random_string = '';
	for($i = 0; $i <= 4; $i++) 
	{
		$random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
		$random_string .= $random_character;
		$random_string .= ',';
	}
	
	return $random_string;
}


function chk_mail($email)
{
    $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

    if (preg_match($pattern, $email))
    {
        return 1;
    }else
    {
        return 0;
    }
}


function search_starting_pt($ref_no)
{
    if(substr($ref_no,3,2) <= 19)
	{
		//$tables = '20172019,20202021,20222023,20242025';
		$tables = '2017,2018,2019,20202021,20222023,20242025';
	}else if(substr($ref_no,3,2) == 20 || substr($ref_no,3,2) == 21)
	{
		$tables = '20202021,20222023,20242025';
	}else if(substr($ref_no,3,2) == 22 || substr($ref_no,3,2) == 23)
	{
		$tables = '20222023,20242025';
	}else
	{
		$tables = '20242025';
	}
	
	return explode(",", $tables);
}


function search_starting_pt_crs($ref_no)
{
    if(substr($ref_no,3,2) <= 19)
	{
		$tables = '20172019,20202021,20222023,20242025';
		//$tables = '2017,2018,2019,20202021,20222023,20242025';
	}else if(substr($ref_no,3,2) == 20 || substr($ref_no,3,2) == 21)
	{
		$tables = '20202021,20222023,20242025';
	}else if(substr($ref_no,3,2) == 22 || substr($ref_no,3,2) == 23)
	{
		$tables = '20222023,20242025';
	}else
	{
		$tables = '20242025';
	}
	
	return explode(",", $tables);
}



function clean_str($str)
{
	//$chars = array("\r\n", '\\n', '\\r', "\n", "\r", "\t", "\0", "\x0B");
	//str_replace($chars,"",$str);
	
	$str = str_replace(chr(130), ',', $str);    // baseline single quote
	$str = str_replace(chr(131), 'NLG', $str);  // florin
	$str = str_replace(chr(132), '"', $str);    // baseline double quote
	$str = str_replace(chr(133), '...', $str);  // ellipsis
	$str = str_replace(chr(134), '**', $str);   // dagger (a second footnote)
	$str = str_replace(chr(135), '***', $str);  // double dagger (a third footnote)
	$str = str_replace(chr(136), '^', $str);    // circumflex accent
	$str = str_replace(chr(137), 'o/oo', $str); // permile
	$str = str_replace(chr(138), 'Sh', $str);   // S Hacek
	$str = str_replace(chr(139), '<', $str);    // left single guillemet
	$str = str_replace(chr(140), 'OE', $str);   // OE ligature
	$str = str_replace(chr(145), "'", $str);    // left single quote
	$str = str_replace(chr(146), "'", $str);    // right single quote
	$str = str_replace(chr(147), '"', $str);    // left double quote
	$str = str_replace(chr(148), '"', $str);    // right double quote
	$str = str_replace(chr(149), '-', $str);    // bullet
	$str = str_replace(chr(150), '-', $str);    // endash
	$str = str_replace(chr(151), '--', $str);   // emdash
	$str = str_replace(chr(152), '~', $str);    // tilde accent
	$str = str_replace(chr(153), '(TM)', $str); // trademark ligature
	$str = str_replace(chr(154), 'sh', $str);   // s Hacek
	$str = str_replace(chr(155), '>', $str);    // right single guillemet
	$str = str_replace(chr(156), 'oe', $str);   // oe ligature
	$str = str_replace(chr(159), 'Y', $str);    // Y Dieresis
	//force convert to ISO-8859-1 then convert back to UTF-8 to remove the rest of unknown hidden characters
	$str = iconv("UTF-8","ISO-8859-1//IGNORE",$str);
	$str = iconv("ISO-8859-1","UTF-8",$str);

	return $str;
}


function clean_string_as($value, $str_type)
{
	if (is_null($value))
	{
		return '';
	}

	$str_array = str_split($value);

	$return_val = '';
	foreach ($str_array as $val_arr)
	{
		$cap_ltrs = (ord($val_arr) >= 65 && ord($val_arr) <= 90);
		$smal_ltrs = (ord($val_arr) >= 97 && ord($val_arr) <= 122);
		$numbers = (ord($val_arr) >= 48 && ord($val_arr) <= 57);

		$hyphen = ord($val_arr) == 45;
		$period = ord($val_arr) == 46;
		$space = ord($val_arr) == 32;
		$coma = ord($val_arr) == 44;
		$colon = ord($val_arr) == 58;
		$slash = ord($val_arr) == 47;
		
		$at = ord($val_arr) == 64;
		$underscore = ord($val_arr) == 95;
		
		if ($str_type == 'email')
		{
			if ($cap_ltrs || $smal_ltrs || $numbers || $hyphen || $period || $at || $underscore)
			{
				$return_val .= $val_arr;
			}
		}else if ($str_type == 'matno')
		{
			if ($cap_ltrs || $smal_ltrs || $numbers)
			{
				$return_val .= $val_arr;
			}
		}else if ($str_type == 'matno_')
		{
			if ($cap_ltrs || $smal_ltrs || $numbers || $underscore)
			{
				$return_val .= $val_arr;
			}
		}else if ($str_type == 'names')
		{
			if ($cap_ltrs || $smal_ltrs || $hyphen || $space)
			{
				$return_val .= $val_arr;
			}
		}else if ($str_type == 'letters')
		{
			if ($cap_ltrs || $smal_ltrs)
			{
				$return_val .= $val_arr;
			}
		}else if ($str_type == 'numbers')
		{
			if ($numbers)
			{
				$return_val .= $val_arr;
			}
		}else if ($str_type == 'sentence')
		{
			if ($numbers || $cap_ltrs || $smal_ltrs || $hyphen || $period || $space || $coma || $colon || $slash)
			{
				$return_val .= $val_arr;
			}
		}
	}

	return $return_val;
}