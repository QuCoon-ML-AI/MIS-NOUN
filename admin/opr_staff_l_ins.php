<?php
require_once('../../fsher/fisher.php');

include('const_def.php');

include(APPL_BASE_FILE_NAME.'lib_fn.php');
include(APPL_BASE_FILE_NAME.'lib_fn_2.php');

$mysqli = link_connect_db();

if (valid_stfn() == '0')
{
   echo "Invalid user name<p> Do the following:
   <br>1. Double check your entry
   <br>2. If there are no errors, click the 'Sign-up' button to create an account for yourself"; exit;
}else if (valid_stfn_role() == '0')
{
   echo 'Role not assigned. Let a request memo be sent to MIS from your Superior officer'; exit;
}else if (valid_stfn_center() == 0)
{
    echo 'Centre not assigned'; exit;
}else if (isset($_REQUEST["recover_pwd"]) && $_REQUEST["recover_pwd"] == '1')
{
    send_token('password recovery','0');
    echo 'can continue';
    exit;
}else
{
    $stmt_a = $mysqli->prepare("SELECT cStatus FROM userlogin WHERE vApplicationNo = ?");
    $stmt_a->bind_param("s", $_REQUEST['vApplicationNo']);
    $stmt_a->execute();
    $stmt_a->store_result();
    
    $stmt_a->bind_result($cStatus);
    $stmt_a->fetch();

    if ($cStatus == '0')
    {
        $stmt_a->close();
        echo 'Account diabled';
        exit;
    }
    
    
    $orgsetins = settns();

    //Track login attempts
    $count_log_attempt = count_login_attempt();

    $count_login_attempt = '';
    $attempt_msg = '';
    if (strpos($count_log_attempt,"*"))
    {
        $login_count = substr($count_log_attempt, 0, strlen($count_log_attempt)-3);
        
        if ($orgsetins["max_login"]-($login_count+1) > 0 && $orgsetins["max_login"]-($login_count+1) <= 3)
        {
            $count_login_attempt = substr($count_log_attempt, 0, strlen($count_log_attempt)-1);
            $attempt_msg = '<p>'.($orgsetins["max_login"]-($count_login_attempt+1)) . ' more attempt(s)';
        }
    }

    $elapsed_time = '';
    if (strpos($count_log_attempt,"min"))
    {
        $elapsed_time = substr($count_log_attempt, 0, strlen($count_log_attempt)-3);
    }

    if ((is_numeric($count_login_attempt) && $count_login_attempt >= $orgsetins["max_login"]) || (is_numeric($elapsed_time) && $elapsed_time < $orgsetins["wait_max_login"] && $elapsed_time >= 0))
    {
        if ($orgsetins["wait_max_login"] - $elapsed_time > 1)
        {
            echo 'Account temporarily disabled. Try again in '.($orgsetins["wait_max_login"] - $elapsed_time).'mins';
        }else
        {
            echo 'Account temporarily disabled. Try again in '.($orgsetins["wait_max_login"] - $elapsed_time).'min';
        }
        
        exit;
    }
    
    
    $stmt_a = $mysqli->prepare("SELECT vPassword, md5(?) vPassword_md5, cap_text FROM userlogin WHERE vApplicationNo = ?");
    $stmt_a->bind_param("ss", $_REQUEST['vPassword'], $_REQUEST['vApplicationNo']);
    $stmt_a->execute();
    $stmt_a->store_result();
    
    $stmt_a->bind_result($vPassword, $vPassword_md5, $cap_text);
    $stmt_a->fetch();
    $stmt_a->close();

    if ($_REQUEST["cap_text"] == 'xxxxxxx' || $_REQUEST["cap_text"] <> $cap_text)
    {
        log_actv('Login attempt failed - Wrong captcha');
        echo "Wrong captcha";exit;
    }

    if($vPassword <> $vPassword_md5 && $vPassword <> '' && !isset($_REQUEST["recova"]))
    {
        log_actv('Login attempt failed - Invalid password');
        echo "Invalid password".$attempt_msg;exit;
    }

    /*if (isset($_REQUEST["token_sent"]))
    {
        if ($_REQUEST["token_sent"] == '0')
        {
            $token = send_token_loc();
            if ($token == 'NOUN official email required')
            {
                echo $token;
            }else
            {
                echo '1';
            }
            exit;
        }else
        {
            $token_status = validate_token($_REQUEST["vApplicationNo"],'Login');
        
            if ($token_status <> 'Token valid')
            {
                echo $token_status;
                exit;
            }
        }
    }*/

    log_actv('Logged in');
    echo create_session(); exit;
}

/*function send_token_loc()
{
    if (!isset($_REQUEST['user_cat']))
	{
		return 'User category';
	}

    $purpose = 'Login';
	
	include('../../PHPMailer/mail_con.php');
	//include(BASE_FILE_NAME.'PHPMailer/mail_con.php');
	
	$mysqli = link_connect_db();

	
    date_default_timezone_set('Africa/Lagos');
	$date2 = date("Y-m-d");
	$date2_0 = date("Y-m-d H:i:s");
	
	// $stmt = $mysqli->prepare("SELECT send_time, vtoken FROM veri_token
	// WHERE vApplicationNo = ?
	// AND cused = '0'
	// AND purpose = ?
	// ORDER BY send_time DESC");

	$stmt = $mysqli->prepare("SELECT ABS(TIMESTAMPDIFF(MINUTE,send_time,'$date2_0')), send_time, vtoken FROM veri_token
	WHERE vApplicationNo = ?
	AND LEFT(send_time,10) = '$date2'
	AND purpose = ?
	ORDER BY send_time DESC LIMIT 1");

	$stmt->bind_param("ss",$_REQUEST["vApplicationNo"], $purpose);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($minutes, $send_time, $token);
	$stmt->fetch();
	
	if (is_null($minutes))
	{
		$minutes = 0;
	}
				
    if ($minutes > 15 || $stmt->num_rows() == 0)
	{		
		$token = openssl_random_pseudo_bytes(3);
		$token = bin2hex($token);
	}
	$stmt->close();

	$source_table = '';
	$source_table2 = '';
	$val_field = '';

	if ($_REQUEST['user_cat'] == '4')
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
	}else if ($_REQUEST['user_cat'] == '3' || $_REQUEST['user_cat'] == '1')
	{
		$val_field = $_REQUEST['vApplicationNo'];
		$source_table = 'prog_choice';
	}else if ($_REQUEST['user_cat'] <> '5')
	{
		$val_field = $_REQUEST['vApplicationNo'];
		$source_table = 'userlogin';
	}
			
	if ($_REQUEST['user_cat'] == '4')
	{
		$stmt_1 = $mysqli->prepare("SELECT a.vFirstName, vEMailId
		FROM $source_table a, $source_table2 b
		WHERE a.vApplicationNo = b.vApplicationNo
		AND a.vApplicationNo = ?");
	}else
	{
		if ($_REQUEST['user_cat'] == '6')
		{
			$stmt_1 = $mysqli->prepare("SELECT vFirstName, cemail
			FROM $source_table
			WHERE vApplicationNo = ?");
		}else if ($_REQUEST['user_cat'] <> '5')
		{
			$stmt_1 = $mysqli->prepare("SELECT vFirstName, vEMailId
			FROM $source_table
			WHERE vApplicationNo = ?");
		}
	}
	
	if (isset($stmt_1))
	{
    	$stmt_1->bind_param("s", $val_field);
    	$stmt_1->execute();
    	$stmt_1->store_result();
    	$stmt_1->bind_result($vFirstName, $vEMailId);
    	$stmt_1->fetch();
    	$stmt_1->close();
	    
		if (is_null($vEMailId))
	    {
			$vEMailId = '';
		}
	}else if ($_REQUEST['user_cat'] == '5')
    {
        if (isset($_REQUEST['vMatricNo']))
		{
		    $vEMailId = strtolower($_REQUEST['vMatricNo']).'@noun.edu.ng';
		    $val_field = $_REQUEST['vMatricNo'];
		    
		    $stmt_1 = $mysqli->prepare("SELECT vFirstName
			FROM s_m_t
			WHERE vMatricNo = ?");
			$stmt_1->bind_param("s", $val_field);
        	$stmt_1->execute();
        	$stmt_1->store_result();
        	$stmt_1->bind_result($vFirstName);
        	$stmt_1->fetch();
        	$stmt_1->close();
		}
    }
	
	//$vEMailId = 'aadeboyejo@noun.edu.ng';

	$subject = 'NOUN - Token for '.$purpose;
	$mail_msg = "Dear $vFirstName,<br><br>
	Copy the token below and paste it in the corresponding box on the '$purpose' page.
	<p><b>$token</b> 
	<p><i>Please do not reply this mail</i>
	<p>Thank you";

	$mail_msg = wordwrap($mail_msg, 70);
	$mail->addAddress($vEMailId, $vFirstName); // Add a recipient
	$mail->Subject = $subject;
	$mail->Body = $mail_msg;
	try
	{
		if ($minutes > 5)
        {
            $mail->send();
        }
	}catch(Exception $e) 
	{
		echo 'eMail address error';
		exit;
	}

	//for ($incr = 1; $incr <= 5; $incr++)
	//{
	try
	{
		//if ($mail->send())
		//{
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
			
			
			date_default_timezone_set('Africa/Lagos');
			$date2 = date("Y-m-d h:i:s");
			
			//try
			//{
				//$mysqli->autocommit(FALSE); //turn on transactions

				$stmt = $mysqli->prepare("INSERT INTO veri_token SET
				vApplicationNo = ?,
				vtoken = '$token',
				send_time = '$date2',
				purpose = ?");
				$stmt->bind_param("ss", $val_field, $purpose); 
				$stmt->execute();
				
				$stmt = $mysqli->prepare("INSERT INTO atv_log SET 
				vApplicationNo  = ?,
				vDeed = 'sent a token for $purpose to $vEMailId',
				act_location = ?,
				tDeedTime = '$date2'");
				$stmt->bind_param("ss", $val_field, $ipee);
				$stmt->execute();
				$stmt->close();

			// 	$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
			// }catch(Exception $e) 
			// {
			// 	$mysqli->rollback(); //remove all queries from queue if error (undo)
			// 	throw $e;
			// }

			//break;
		//}
	}catch(Exception $e) 
	{
		echo 'Token not sent';
	}
	//}

	return $token;
}*/