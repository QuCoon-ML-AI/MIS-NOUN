<?php 
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');

if (isset($_REQUEST["mm"]) && isset($_REQUEST["sm"]) && isset($_REQUEST["currency_cf"]) && isset($_REQUEST["user_cat"]))
{
	$orgsetins = settns();

    if (isset($_REQUEST["conf_del"]) && $_REQUEST["conf_del"] == '1')
    {
        $stmt = $mysqli->prepare("DELETE FROM student_notice_board
		WHERE vApplicationNo = ?
		AND msg_subject = ?");
		$stmt->bind_param("ss", $_REQUEST['vApplicationNo'], $_REQUEST['msg_subject']);
		$stmt->execute();

        log_actv('deleted message with subject matter '.$_REQUEST['msg_subject']);

        echo $stmt->affected_rows.' record deleted successfully';
		$stmt->close();
    }else if (isset($_REQUEST["get_msg_detail"]))
    {
        $stmt = $mysqli->prepare("SELECT cFacultyId, cdeptId, cProgrammeId, silevel, msg_subject, msg_body, sender_signature, date1, cshow, msg_loc
		FROM student_notice_board 
		WHERE vApplicationNo = ? AND 
		msg_subject = ?");
		$stmt->bind_param("ss", $_REQUEST['vApplicationNo'], $_REQUEST['msg_prv']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cFacultyId, $cdeptId, $cProgrammeId, $silevel, $msg_subject, $msg_body, $sender_signature, $date1, $cshow, $msg_loca);
		$stmt->fetch();
		$stmt->close();

        echo str_pad($cFacultyId,5).
        str_pad($cdeptId,5).
        str_pad($cProgrammeId,10).
        str_pad($silevel,5).
        str_pad($msg_subject,150).
        str_pad($msg_body,1000).
        str_pad($sender_signature,150).
        str_pad($date1,15).
        str_pad($cshow,10).
        str_pad($msg_loca,10);
        
        log_actv('called up message with subject matter '.$msg_subject);
    }else if (isset($_REQUEST["save_cf"]))
    {
        date_default_timezone_set('Africa/Lagos');

        $currentDate = date('Y-m-d');
        if ($currentDate >= $_REQUEST['date_msg1'])
        {
            echo 'Date must be in the future'; exit;
        }

        $sent_date = new DateTimeImmutable($_REQUEST["date_msg1"]." Africa/Lagos");
        $current_date = new DateTimeImmutable("Now");
        $interval = $sent_date->diff($current_date);
        if ($interval->format("%a") > 28)
        {
            echo 'Notice cannot be on the board for more than 14 days'; 
            exit;
        }
        
        if (isset($_REQUEST['what']) && $_REQUEST['what'] == 0)
        {
            $stmt = $mysqli->prepare("SELECT * FROM student_notice_board
            WHERE LCASE(msg_subject) = LCASE(TRIM(?))");
            $stmt->bind_param("s", $_REQUEST['msg_subject']);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0)
            {
                if ($_REQUEST["save_cf"] == 1)
                {
                    echo 'Message not sent<br>';
                    log_actv('attempted to compose and send a message with already existing subject matter: '.$_REQUEST['msg_subject']);
                }else if ($_REQUEST["save_cf"] == 2)
                {
                    echo 'Message not saved<br>';
                    log_actv('attempted to compose and save a message with already existing subject matter: '.$_REQUEST['msg_subject']);
                }
                
                echo 'Another message with subject matter already exist<br>You may either modify the subject matter or edit exisiting subject matter, if it was created by you.';
                exit;
            }           
		    $stmt->close();            
        }else if (isset($_REQUEST['what']) && $_REQUEST['what'] == 1)
        {
            $stmt = $mysqli->prepare("DELETE FROM student_notice_board
            WHERE vApplicationNo = ?
            AND msg_subject = ?");
            $stmt->bind_param("ss", $_REQUEST['vApplicationNo'], $_REQUEST['existing_msg_subject']);
            $stmt->execute();
        }
        
        $sub_qry = ", cshow = '0'";

        if ($_REQUEST["save_cf"] == 1)
        {
            $sub_qry = ", cshow = '1'";
        }

        //$pg_students_sql = '';
        if (isset($_REQUEST["mm"]) && $_REQUEST["mm"] == '8')
        {
            $sub_qry .= ", f_pg = '1'";
        }

        date_default_timezone_set('Africa/Lagos');
        $current_date = date("Y-m-d");
        $act_date = date("Y-m-d H:i:s");
        
        $stmt = $mysqli->prepare("REPLACE INTO student_notice_board
		set vApplicationNo = ?,
		cFacultyId = ?,
        cdeptId = ?,
        cProgrammeId = ?,
        silevel = ?,
		msg_subject = ?,
		msg_body = ?,
		sender_signature = ?,
		date1 = ?,
        msg_loc = ?,
        act_time = '$act_date'
        $sub_qry");
		$stmt->bind_param("ssssisssss", $_REQUEST['vApplicationNo'], $_REQUEST['msg_faculty'], $_REQUEST['msg_dept'], $_REQUEST['msg_programe'], $_REQUEST['msg_level'], $_REQUEST['msg_subject'], $_REQUEST['msg_body'], $_REQUEST['msg_sign'], $_REQUEST['date_msg1'], $_REQUEST['msg_loc']);
		$stmt->execute();
		$stmt->close();
       
        if ($_REQUEST["save_cf"] == 1)
        {
           echo 'Success. Message sent';
           log_actv('sent message with subject matter '.$_REQUEST['msg_dept']);
        }else if ($_REQUEST["save_cf"] == 2)
        {
           echo 'Success. Message saved';
           log_actv('saved message with subject matter '.$_REQUEST['msg_dept']);
        }
    }
}