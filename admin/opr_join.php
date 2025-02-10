
<?php
include('const_def.php');

require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

if (isset($_REQUEST['save']))
{
	date_default_timezone_set('Africa/Lagos');
    $date2 = date("Y-m-d h:i:s");
    
    $staffid = $_REQUEST['staffid'];
    
    $stmt = $mysqli->prepare("SELECT * FROM userlogin where vApplicationNo = ?");
    $stmt->bind_param("s",$_REQUEST['staffid']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0)
    {
        echo 'You have already signed up 
        <p> You may sign in by doing the following:
        <br> 1. Click Home button
        <br>2. Click Staff button
        <br>3. Enter your user name 
        <br>4. Enter your password 
        <br>5. Click the Login button';exit;
    }else
    {        
        //$mysqli_hr = hr_bd();
        $stmt_a = $mysqli->prepare("SELECT vLastName, vFirstName, vOtherName FROM desigs where vApplicationNo = ?");
        $stmt_a->bind_param("s",$_REQUEST['staffid']);
        $stmt_a->execute();
        $stmt_a->store_result();
        if ($stmt_a->num_rows > 0)
        {
            $stmt_a->bind_result($vLastName, $vFirstName, $vOtherName);
            $stmt_a->fetch();
        }else
        {
            $stmt_a->close();
            echo "Staff ID not on record";exit;
        }
    }
    $stmt_a->close();

    
    if (isset($_REQUEST["ask_f_t"]) && $_REQUEST["ask_f_t"] == 1)
    {
        send_token('staff signing up','0');
        echo 'token sent';
        exit;
    }else if (isset($_REQUEST["use_t"]) && $_REQUEST["use_t"] == 1)
    {
        $token_status = validate_token($_REQUEST['staffid'], 'staff signing up');
    
        if ($token_status <> 'Token valid')
        {
            echo $token_status;
            exit;
        }
    }

    try
    {
        $mysqli->autocommit(FALSE);$mysqli->autocommit(FALSE);
					
        if (isset($_FILES['sbtd_pix']))
        {
            $file_chk = check_file('50000', '2');
            if ($file_chk <> '')
            {
                echo $file_chk;
                exit;
            }
        
            delete_staff_pp_file($_REQUEST["staffid"]);
            $target_file = basename($_FILES["sbtd_pix"]["name"]); 
            if (!move_uploaded_file($_FILES['sbtd_pix']['tmp_name'], BASE_FILE_NAME_FOR_STAFF . $target_file))
            {
                echo  "Upload failed, please try again"; exit;
            }

            $token = openssl_random_pseudo_bytes(6);
			$token = bin2hex($token);

            $new_file_name = BASE_FILE_NAME_FOR_STAFF."p_" . $token.".jpg";

            rename(BASE_FILE_NAME_FOR_STAFF . $_FILES['sbtd_pix']['name'], $new_file_name);
            chmod($new_file_name, 0755);
            
            
            $stmt = $mysqli->prepare("REPLACE INTO staff_pics
            SET vApplicationNo = ?, vmask = '$token', act_date = '$date2'");
            $stmt->bind_param("s", $_REQUEST["staffid"]);
            $stmt->execute();
            $stmt->close();
        }
		

        $stmt = $mysqli->prepare("INSERT INTO userlogin SET
        vApplicationNo = ?, 
        vPassword = md5(?),
        vLastName = '$vLastName', 
        vFirstName = '$vFirstName', 
        vOtherName = '$vOtherName',
        act_date = '$date2'");
        $stmt->bind_param("ss", 
        $_REQUEST['staffid'], 
        $_REQUEST['vPassword']);
        $stmt->execute();
        $stmt->close();
					
        log_actv($_REQUEST['staffid'].' signed up');

        $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

        $first_nae = '';
        $mail_id = '';

        $stmt = $mysqli->prepare("SELECT vFirstName, mail_id
        FROM desigs a, mail_rec b
        WHERE a.vApplicationNo = b.vApplicationNo
        AND a.vApplicationNo = ?");
        $stmt->bind_param("s", $_REQUEST['staffid']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($first_nae, $mail_id);
        $stmt->fetch();
        $stmt->close();

		$subject = 'NOUN - SMS User Account Creation';
		$mail_msg = 'Dear '.$first_nae.',<br><br>
        Your loggin details follow:<p>
        User ID : '.$_REQUEST['staffid'].' <br>
        Initial password is as you entered<p>
        Thank you';

		$mail_msg = wordwrap($mail_msg, 70);
		
		for ($incr = 1; $incr <= 5; $incr++)
		{
            try 
            {
                $mysqli->autocommit(FALSE); //turn on transactions
                
                include('../../PHPMailer/mail_con.php');
                
                $mail->addAddress($mail_id, $first_nae);
                $mail->Subject = $subject;
                $mail->Body = $mail_msg;
                $mail->send();
                
                log_actv('Sent newly created user account detail to '.$mail_id);
                $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
                
    			break;
            } catch (Exception $e)
            {
                $mysqli->rollback(); //remove all queries from queue if error (undo)
    	        throw $e;
            }
		}
        
		echo 'User account created successfully<br>Your account will be activated when DMIS is advised in writing from your superior officer'; exit;
    }catch(Exception $e)
    {
        $mysqli->rollback(); //remove all queries FROM queue if error (undo)
      throw $e;
    }
}?>