<?php
include('const_def.php');
require_once('../../fsher/fisher.php');
include('../../PHPMailer/mail_con.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

if (isset($_REQUEST['ilin']) && $_REQUEST['ilin'] <> '')
{
	date_default_timezone_set('Africa/Lagos');
    //$date2 = date("Y-m-d h:i:s");
    $date2 = date("Y-m-d");
    
    if (isset($_REQUEST["del"]))
    {
        $stmt = $mysqli->prepare("UPDATE pg_seminar 
        SET cDel = 'Y'
        WHERE vMatricNo = ?
        AND topic = ?");
        $stmt->bind_param("ss", $_REQUEST["uvApplicationNo"], $_REQUEST["s_topic"]);
        $stmt->execute();
        $stmt->close();
        log_actv('Deleted seminar topic ('.$_REQUEST["s_topic"].') for '.$_REQUEST["uvApplicationNo"]);
        echo 'Record deleted successfully';
    }else if (isset($_REQUEST["s_topic"]))
    {
        $s_topic = strtolower($_REQUEST["s_topic"]);
        
        try
        {
            $mysqli->autocommit(FALSE); //turn on transactions
            
            $stmt = $mysqli->prepare("REPLACE INTO pg_seminar 
            SET vMatricNo = ?,
            topic = ?,
            date_ass = ?,
            presented = ?,
            date_presented = ?,
            score = ?");
            $stmt->bind_param("sssssi", $_REQUEST["vMatricNo"], $s_topic, $_REQUEST["date_ass"], $_REQUEST["presented"], $_REQUEST["date_presented"], $_REQUEST["score"]);
            $stmt->execute();
            $stmt->close();

            $stmt1 = $mysqli->prepare("SELECT vEMailId,	concat(vLastName,' ',vFirstName,' ',vOtherName) allname
            FROM s_m_t
            WHERE vMatricNo = ?");
            $stmt1->bind_param("s",$_REQUEST["supervisor"]);
            $stmt1->execute();
            $stmt1->store_result();
            $stmt1->bind_result($vEMailId, $allname);
            $stmt1->fetch();
            $stmt1->close();

            $subject = 'NOUN - Assigned Seminar Topic';
            $mail_msg = "Dear $allname,<br><br>Please refer to the subject matter.<p>
            You have been assigned a seminar topic, '".ucwords($s_topic)."'<p>
            Please contact your supervisor for further guide<p>
            Best wishes.";

            $mail_msg = wordwrap($mail_msg, 70);
            
            $mail->addAddress($vEMailId, $allname);
            $mail->Subject = $subject;
            $mail->Body = $mail_msg;
            
            for ($incr = 1; $incr <= 5; $incr++)
            {
                if ($mail->send())
                {
                    log_actv('Sent seminar topic to '.$vEMailId.', '.$_REQUEST["vMatricNo"]);
                    log_actv('Uploaded/Updated seminar record for '.$_REQUEST["vMatricNo"]);
                    break;
                }
            }

            echo 'Record of seminar uploaded/updated successfully';exit;
        }catch(Exception $e) 
        {
            $mysqli->rollback(); //remove all queries from queue if error (undo)
            throw $e;
        }
    }else if (isset($_REQUEST["supervisor"]))
    {
        try
        {
            $mysqli->autocommit(FALSE); //turn on transactions

            $stmt = $mysqli->prepare("REPLACE INTO mgt_pg_std 
            SET vMatricNo = ?,
            supervisor = ?,
            date_supervisor = '$date2'");
            $stmt->bind_param("ss", $_REQUEST["vMatricNo"], $_REQUEST["supervisor"]);
            $stmt->execute();
            $stmt->close();        

            $stmt1 = $mysqli->prepare("SELECT vEMailId,	concat(vLastName,' ',vFirstName,' ',vOtherName) allname
            FROM s_m_t
            WHERE vMatricNo = ?");
            $stmt1->bind_param("s",$_REQUEST["vMatricNo"]);
            $stmt1->execute();
            $stmt1->store_result();
            $stmt1->bind_result($vEMailId, $allname);
            $stmt1->fetch();
            $stmt1->close();
            
            $stmt1 = $mysqli->prepare("SELECT cemail, concat(vLastName,' ',vFirstName,' ',vOtherName) allname, cphone
            FROM userlogin
            WHERE vApplicationNo = ?");
            $stmt1->bind_param("s",$_REQUEST["supervisor"]);
            $stmt1->execute();
            $stmt1->store_result();
            $stmt1->bind_result($vEMailId, $allname_s, $phone);
            $stmt1->fetch();
            $stmt1->close();

            $subject = 'NOUN Ph.D. Programme - Assigned Supervisor';
            $mail_msg = "Dear $allname,<p>
            Please refer to the subject matter.<p>
            You have been assigned a supervisor with the following details<p>
            Name: $allname_s<br>
            Phone number: $phone<br>
            eMail address: $vEMailId<br>

            Please contact him/her for further guide<p>
            Best wishes.";

            $mail_msg = wordwrap($mail_msg, 70);
            
            $mail->addAddress($vEMailId, $allname);
            $mail->Subject = $subject;
            $mail->Body = $mail_msg;
            
            for ($incr = 1; $incr <= 5; $incr++)
            {
                if ($mail->send())
                {
                    log_actv('Sent assigned supervisor detail to '.$vEMailId);
                    break;
                }
            }
            
            log_actv('Assigned supervisor to '.$_REQUEST["vMatricNo"]);

            $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

            echo 'Supervisor assigned successfully';exit;
        }catch(Exception $e) 
        {
            $mysqli->rollback(); //remove all queries from queue if error (undo)
            throw $e;
        }
    }else if (isset($_REQUEST['number_of_boxes']))
    {
        for ($x = 1; $x <= $_REQUEST['number_of_boxes']; $x++)
        {
            if ($_REQUEST['sm'] == '24' || $_REQUEST['sm'] == '25' || (strlen($_REQUEST['sm']) == 3 && !is_numeric(substr($_REQUEST['sm'],2,1))))
            {
                $box_name = 'afn_'.$x;

            }

            if (isset($box_name))
            {
                if ($_REQUEST["sm"] == '24')//rpt back to SPGS
                {        
                    $stmt = $mysqli->prepare("UPDATE prog_choice_pg 
                    SET rpt_fwdd = '0',
                    date_rpt_fwdd = '$date2'
                    WHERE vApplicationNo = ?");
                    $stmt->bind_param("s", $_REQUEST["$box_name"]);
                    $stmt->execute();
                    $stmt->close();
                    log_actv('Retrieved report from SPGS');
                }else  if ($_REQUEST['sm'] == '25')//rpt back to SPGS
                {        
                    $stmt = $mysqli->prepare("UPDATE prog_choice_pg 
                    SET ltr_sent = '0',
                    date_ltr_sent = '$date2'
                    WHERE vApplicationNo = ?");
                    $stmt->bind_param("s", $_REQUEST["$box_name"]);
                    $stmt->execute();
                    $stmt->close();
                    log_actv('Retrieved admission letters');
                }else  if ($_REQUEST['sm'] == '27b')//def of tp
                {        
                    $stmt = $mysqli->prepare("UPDATE mgt_pg_std 
                    SET thesis_prop = '0',
                    date_thesis_prop = '$date2'
                    WHERE vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST["$box_name"]);
                    $stmt->execute();
                    $stmt->close();
                    log_actv('Reversed confirmation of submission of thesis proposals');
                }else  if ($_REQUEST['sm'] == '27c')//def of tp
                {        
                    $stmt = $mysqli->prepare("UPDATE mgt_pg_std 
                    SET pre_fld_def = '0',
                    date_pre_fld_def = '$date2'
                    WHERE vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST["$box_name"]);
                    $stmt->execute();
                    $stmt->close();
                    log_actv('Reversed confirmation of defence of thesis proposals');
                    
                }else if ($_REQUEST['sm'] == '27d')//post fld def
                {        
                    $stmt = $mysqli->prepare("UPDATE mgt_pg_std 
                    SET post_fld_def = '0',
                    date_post_fld_def = '$date2'
                    WHERE vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST["$box_name"]);
                    $stmt->execute();
                    $stmt->close();
                    log_actv('Reversed confirmation of post-field defence');
                    
                }else if ($_REQUEST['sm'] == '27e')//post fld def
                {        
                    $stmt = $mysqli->prepare("UPDATE mgt_pg_std 
                    SET thesis_apr = '0',
                    date_thesis_apr = '$date2'
                    WHERE vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST["$box_name"]);
                    $stmt->execute();
                    $stmt->close();
                    log_actv('Reversed confirmation of approval of theses');
                    
                }else if ($_REQUEST['sm'] == '27f')//thesis def
                {        
                    $stmt = $mysqli->prepare("UPDATE mgt_pg_std 
                    SET thesis_def = '0',
                    date_thesis_def = '$date2'
                    WHERE vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST["$box_name"]);
                    $stmt->execute();
                    $stmt->close();
                    log_actv('Reversed confirmation of theses defence');
                    
                }else if ($_REQUEST['sm'] == '27g')//thesis def
                {        
                    $stmt = $mysqli->prepare("UPDATE mgt_pg_std 
                    SET deg_award = '0',
                    date_deg_award = '$date2'
                    WHERE vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST["$box_name"]);
                    $stmt->execute();
                    $stmt->close();
                    log_actv('Reversed all award of degree');
                    
                }
            }
        }
        
        $count_update = 0;
        for ($x = 0; $x <= $_REQUEST['number_of_boxes']-1; $x++)
        {
            if ($_REQUEST['sm'] == '20' || $_REQUEST['sm'] == '21' || $_REQUEST['sm'] == '22' || $_REQUEST['sm'] == '23' || $_REQUEST['sm'] == '24' || $_REQUEST['sm'] == '25' || $_REQUEST['sm'] == '26' || $_REQUEST['sm'] == '28' || (strlen($_REQUEST['sm']) == 3 && !is_numeric(substr($_REQUEST['sm'],2,1))))
            {
                $box_name = 'afn_'.$x;
                $box_check = 'box_check_'.$x;
            }
        
            if (isset($_REQUEST["$box_name"]))
            {                
                /*if ($_REQUEST["sm"] == '20')//fwd
                {
                    $stmt = $mysqli->prepare("DELETE FROM prog_choice_pg WHERE vApplicationNo = ?");
                    $stmt->bind_param("s", $_REQUEST["$box_name"]);
                    $stmt->execute();
                    $stmt->close();

                    $stmt = $mysqli->prepare("INSERT INTO prog_choice_pg 
                    SET vApplicationNo = ?,
                    fwdd = '1',
                    date_fwdd = CURDATE()");
                    $stmt->bind_param("s", $_REQUEST["$box_name"]);
                    $stmt->execute();
                    
                    $count_update+=$stmt->affected_rows;

                    $stmt->close();

                    log_actv('Forwarded application form number '.$_REQUEST["$box_name"]. ' to department');
                }else if ($_REQUEST["sm"] == '21')//retr
                {
                    $stmt = $mysqli->prepare("UPDATE prog_choice_pg 
                    SET fwdd = '0',
                    retr = '1',
                    date_retr = CURDATE() 
                    WHERE vApplicationNo = ?");
                    $stmt->bind_param("s", $_REQUEST["$box_name"]);
                    $stmt->execute();
                    
                    $count_update+=$stmt->affected_rows;

                    $stmt->close();
                    log_actv('Retrieved application for '.$_REQUEST["$box_name"]);
                }else*/ if ($_REQUEST["sm"] == '22')//iv
                {
                    //if ($_REQUEST["$box_name"] == 0){continue;}
                    
                    $stmt = $mysqli->prepare("UPDATE prog_choice_pg 
                    SET invited = ?,
                    date_iv = CURDATE() 
                    WHERE vApplicationNo = ?");
                    $stmt->bind_param("ss", $_REQUEST["$box_check"], $_REQUEST["$box_name"]);
                    $stmt->execute();
                    
                    $count_update+=$stmt->affected_rows;

                    $stmt->close();
                    if ($_REQUEST["$box_check"] == '1')
                    {
                        $stmt1 = $mysqli->prepare("SELECT 
                        a.vEMailId,	concat(b.vLastName,' ',b.vFirstName,' ',b.vOtherName) allname
                        FROM post_addr a, prog_choice b 
                        WHERE a.vApplicationNo = b.vApplicationNo
                        AND a.vApplicationNo = ?");
                        $stmt1->bind_param("s",$_REQUEST["$box_name"]);
                        $stmt1->execute();
                        $stmt1->store_result();
                        $stmt1->bind_result($vEMailId, $allname);
                        $stmt1->fetch();
                        $stmt1->close();

                        $vEMailId = $vEMailId ?? '';

                        //$vEMailId = 'aadeboyejo@noun.edu.ng';
                        //$allname = 'Adeyinka';

                        $subject = 'NOUN PhD Programme- Invitation for Interview';
                        $mail_msg = "Dear $allname,<p>".
                        $_REQUEST["msg_body"]."<p>
                        Venue:".$_REQUEST["msg_venue"]."<br>
                        Date:".formatdate($_REQUEST["msg_date"],'fromdb')."<br>
                        Time:".$_REQUEST["msg_time"]."<p>
                        Come along with original copies of relevant documents<p>
                        Best wishes.";

                        $mail_msg = wordwrap($mail_msg, 70);
                        
                        $mail->addAddress($vEMailId, $allname);
                        $mail->Subject = $_REQUEST["msg_subject"];
                        $mail->Body = $mail_msg;
                        $mail->send();
                        /*for ($incr = 1; $incr <= 5; $incr++)
                        {
                            if ($mail->send())
                            {
                                log_actv('Sent Invitation for Interview to '.$vEMailId.', '.$_REQUEST["$box_name"]);
                                break;
                            }
                        }*/
                    }
                }else if ($_REQUEST["sm"] == '23')//interviewed
                {
                    $stmt = $mysqli->prepare("UPDATE prog_choice_pg 
                    SET itervwd = ?,
                    date_itervwd = '$date2' 
                    WHERE vApplicationNo = ?");
                    $stmt->bind_param("ss", $_REQUEST["$box_check"], $_REQUEST["$box_name"]);
                    $stmt->execute();
                    
                    $count_update+=$stmt->affected_rows;

                    $stmt->close();
                    log_actv('Confirmed '.$_REQUEST["$box_name"].' has been interviewed');
                }else if ($_REQUEST["sm"] == '24')//rpt back to SPGS
                {                    
                    $stmt = $mysqli->prepare("UPDATE prog_choice_pg 
                    SET rpt_fwdd = '1',
                    date_rpt_fwdd = '$date2',
                    recon = ?,
                    date_recon = '$date2'
                    WHERE vApplicationNo = ?");
                    $stmt->bind_param("ss", $_REQUEST["$box_check"], $_REQUEST["$box_name"]);
                    $stmt->execute();
                    
                    $count_update+=$stmt->affected_rows;

                    $stmt->close();
                    log_actv('Reported back to SPGS on the interview for '.$_REQUEST["$box_name"]);
                }else if ($_REQUEST["sm"] == '25')//ltr
                {
                    try
                    {
                        $mysqli->autocommit(FALSE); //turn on transactions

                        $stmt = $mysqli->prepare("UPDATE prog_choice_pg 
                        SET ltr_sent = ?,
                        date_ltr_sent = '$date2' 
                        WHERE vApplicationNo = ?");
                        $stmt->bind_param("ss", $_REQUEST["$box_check"], $_REQUEST["$box_name"]);
                        $stmt->execute();
                        
                        $count_update+=$stmt->affected_rows;
                        $stmt->close();
                       
                        if ($_REQUEST["$box_check"] == '1')
                        {
                            $stmt1 = $mysqli->prepare("SELECT 
                            a.vEMailId,	concat(b.vLastName,' ',b.vFirstName,' ',b.vOtherName) allname
                            FROM post_addr a, pers_info b 
                            WHERE a.vApplicationNo = b.vApplicationNo
                            AND a.vApplicationNo = ?");
                            $stmt1->bind_param("s",$_REQUEST["$box_name"]);
                            $stmt1->execute();
                            $stmt1->store_result();
                            $stmt1->bind_result($vEMailId, $allname);
                            $stmt1->fetch();
                            $stmt1->close();

                            $subject = 'NOUN PhD Programme - Admission';
                            $mail_msg = "Dear $allname,<br><br>Please refer to the subject matter.<p>
                            You are to login to your application form to print your admission letter and follow the instructions there in<p>
                            Congratulations.";

                            $mail_msg = wordwrap($mail_msg, 70);
                            
                            $mail->addAddress($vEMailId, $allname);
                            $mail->Subject = $subject;
                            $mail->Body = $mail_msg;
                                
                            for ($incr = 1; $incr <= 5; $incr++)
                            {
                                if ($mail->send())
                                {
                                    log_actv('Sent admission notice to '.$vEMailId.', '.$_REQUEST["$box_name"]);
                                    break;
                                }
                            }
                        }

                        $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
                    }catch(Exception $e) 
                    {
                        $mysqli->rollback(); //remove all queries from queue if error (undo)
                        throw $e;
                    }
                }else if ($_REQUEST["sm"] == '26')//scrn
                {
                    $stmt = $mysqli->prepare("UPDATE prog_choice SET cSbmtd = '2' WHERE vApplicationNo = ?");
                    $stmt->bind_param("s", $_REQUEST["$box_name"]);
                    $stmt->execute();
                    $stmt->close();
                    
                    $stmt = $mysqli->prepare("UPDATE prog_choice_pg 
                    SET cSCrnd = ?,
                    date_cSCrnd = '$date2' 
                    WHERE vApplicationNo = ?");
                    $stmt->bind_param("ss", $_REQUEST["$box_check"], $_REQUEST["$box_name"]);
                    $stmt->execute();
                    
                    $count_update+=$stmt->affected_rows;

                    $stmt->close();
                    log_actv('Screened '.$_REQUEST["$box_name"].' for registration');
                }else if ($_REQUEST["sm"] == '28')//transcript
                {
                    $stmt = $mysqli->prepare("UPDATE prog_choice_pg SET transcript = ?, date_transcript = '$date2' WHERE vApplicationNo = ?");
                    $stmt->bind_param("ss", $_REQUEST["$box_check"], $_REQUEST["$box_name"]);
                    $stmt->execute();

                    if ($stmt->affected_rows == 0)
                    {
                        $stmt->close();
                        $stmt = $mysqli->prepare("INSERT IGNORE INTO prog_choice_pg SET transcript = ?, date_transcript = '$date2', vApplicationNo = ?");
                        $stmt->bind_param("ss", $_REQUEST["$box_check"], $_REQUEST["$box_name"]);
                        $stmt->execute();
                    }
                    
                    $count_update+=$stmt->affected_rows;

                    $stmt->close();
                    log_actv('Confirm transcript submission for '.$_REQUEST["$box_name"]);
                }else  if ($_REQUEST['sm'] == '27b')//sub of tp
                {        
                    $stmt = $mysqli->prepare("UPDATE mgt_pg_std 
                    SET thesis_prop = ?,
                    date_thesis_prop = '$date2'
                    WHERE vMatricNo = ?");
                    $stmt->bind_param("ss", $_REQUEST["$box_check"], $_REQUEST["$box_name"]);
                    $stmt->execute();
                    
                    $count_update+=$stmt->affected_rows;

                    $stmt->close();
                    log_actv('Confirmed the submission of thesis proposals for '.$_REQUEST["$box_name"]);
                    
                }else  if ($_REQUEST['sm'] == '27c')//def of tp
                {        
                    $stmt = $mysqli->prepare("UPDATE mgt_pg_std 
                    SET pre_fld_def = '1',
                    date_pre_fld_def = '$date2'
                    WHERE vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST["$box_name"]);
                    $stmt->execute();
                    
                    $count_update+=$stmt->affected_rows;

                    $stmt->close();
                    log_actv('Confirmed the defence of thesis proposals for '.$_REQUEST["$box_name"]);
                    
                }else if ($_REQUEST['sm'] == '27d')//post fld def
                {        
                    $stmt = $mysqli->prepare("UPDATE mgt_pg_std 
                    SET post_fld_def = '1',
                    date_post_fld_def = '$date2'
                    WHERE vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST["$box_name"]);
                    $stmt->execute();
                    
                    $count_update+=$stmt->affected_rows;

                    $stmt->close();
                    log_actv('Confirmed post-field defences for '.$_REQUEST["$box_name"]);                    
                }else if ($_REQUEST['sm'] == '27e')//thesis apr
                {        
                    $stmt = $mysqli->prepare("UPDATE mgt_pg_std 
                    SET thesis_apr = '1',
                    date_thesis_apr = '$date2'
                    WHERE vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST["$box_name"]);
                    $stmt->execute();
                    
                    $count_update+=$stmt->affected_rows;

                    $stmt->close();
                    log_actv('Confirmed approval of thesis for '.$_REQUEST["$box_name"]);                    
                }else if ($_REQUEST['sm'] == '27f')//thesis def
                {        
                    $stmt = $mysqli->prepare("UPDATE mgt_pg_std 
                    SET thesis_def = '1',
                    date_thesis_def = '$date2'
                    WHERE vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST["$box_name"]);
                    $stmt->execute();
                    
                    $count_update+=$stmt->affected_rows;

                    $stmt->close();
                    log_actv('Confirmed defence of thesis for '.$_REQUEST["$box_name"]);                    
                }else if ($_REQUEST['sm'] == '27g')//deg award
                {        
                    $stmt = $mysqli->prepare("UPDATE mgt_pg_std 
                    SET deg_award = '1',
                    date_deg_award = '$date2'
                    WHERE vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST["$box_name"]);
                    $stmt->execute();
                    
                    $count_update+=$stmt->affected_rows;

                    $stmt->close();
                    log_actv('Confirmed award of degree for '.$_REQUEST["$box_name"]);                    
                }
            }
        }

        if ($_REQUEST["sm"] == '20')//fwd
        {
            $feed_back = " application(s) forwarded successfully";
        }else if ($_REQUEST["sm"] == '21')//iv
        {
            $feed_back = " apllication(s) retrieved successfully";
        }else if ($_REQUEST["sm"] == '22')//iv
        {
            $feed_back = " candidate(s) invited";
        }else if ($_REQUEST["sm"] == '23')//intv status
        {
            $feed_back = " candidates' interview status updated successfully";
        }else if ($_REQUEST["sm"] == '24')//iv
        {
            if ( $count_update == 0)
            {
                    echo "Report retrieved successfully"; exit;
            }else
            {
                    $feed_back = " candidates' performance reported back to SPGS";
            }
        }else if ($_REQUEST["sm"] == '25')//ltr
        {
            if ($count_update > 1)
            {
                    $feed_back = " admission letter(s) enabled for successful candidates respectively";
            }else
            {
                    $feed_back = " admission letter enabled for successful candidate";
            }
        }else if ($_REQUEST["sm"] == '26')//scrn
        {
            $feed_back = " candidate(s) record updated successfully";
        }else if ($_REQUEST["sm"] == '28')//scrn
        {
            $feed_back = " Submission(s) confirmed successfully";
        }else if ($_REQUEST["sm"] == '27b')//scrn
        {
            $feed_back = " Record(s) of submission of thesis proposal(s) updated successfully";
        }else if ($_REQUEST["sm"] == '27c')//scrn
        {
            $feed_back = " Record(s) of defence of thesis proposal(s) updated successfully";
        }else if ($_REQUEST["sm"] == '27d')//scrn
        {
            $feed_back = " Record(s) of post-field defence updated successfully";
        }else if ($_REQUEST["sm"] == '27e')//scrn
        {
            $feed_back = " Record(s) of approval of thesis updated successfully";
        }else if ($_REQUEST["sm"] == '27f')//scrn
        {
            $feed_back = " Record(s) of thesis defence updated successfully";
        }else if ($_REQUEST["sm"] == '27g')//scrn
        {
            $feed_back = " Record(s) of award of degree updated successfully";
        }

        echo  $count_update." ".$feed_back;exit;
    }
}