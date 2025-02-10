<?php
include('const_def.php');

require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$staff_study_center = '';
if (isset($_REQUEST['staff_study_center']))
{
	$staff_study_center = $_REQUEST['staff_study_center'];
}

$orgsetins = settns();


$who_is_this = '';
$blksource = '';
$blksource_name = '';
$act_date = ''; 
$period1 = '';
$str = '';

$vApplicationNo_01 = '';
$cfacultyId_01 = '';
$iStudy_level_01 = '';
$tSemester_01 = '';
$study_mode_01 = '';
$cSbmtd_01 = '';
$cProgrammeId_01 = '';
$vObtQualTitle_01 = '';
$vProgrammeDesc_0 = '';
$vLastName_01 = '';
$vFirstName_01 = '';
$vOtherName_01 = '';
$cStudyCenterId = '';
$vCityName = '';

$token = '';

if (isset($_REQUEST['ilin']) && isset($_REQUEST['whattodo']))
{
    if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1')
    {        
        $token_status = validate_token($_REQUEST["vApplicationNo"], 'verifying credentials');
        
        if ($token_status <> 'Token valid')
        {
            echo $token_status; exit;
        }

        include('../../PHPMailer/mail_con.php');
        
        try
        {
            $mysqli->autocommit(FALSE); //turn on transactions

            $stmt = $mysqli->prepare("select vMatricNo from afnmatric where vApplicationNo = ?");
            $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]); 
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($vMatricNo);
            $stmt->fetch();

            $stmt = $mysqli->prepare("UPDATE prog_choice SET cSbmtd = '2', in_mate = ?, cqualfd = '1' WHERE vApplicationNo = ?");
            $stmt->bind_param("ss", $_REQUEST["in_mate"], $_REQUEST["uvApplicationNo"]); 
            $stmt->execute();

            if (isset($_REQUEST["deg_appl_cat"]))
            {
                $stmt = $mysqli->prepare("REPLACE INTO deg_appl_cat SET vApplicationNo = ?, deg_appl_cat = ?");
                $stmt->bind_param("ss", $_REQUEST["uvApplicationNo"], $_REQUEST["deg_appl_cat"]); 
                $stmt->execute();
            }

            log_actv('Verified credentials for '.$_REQUEST["uvApplicationNo"]);

            //send matric number to candidate's mail phone in the future
            /*$stmt = $mysqli->prepare("select vEMailId, vFirstName from prog_choice where vApplicationNo = ?");
            $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]); 
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($vEMailId, $vFirstName);
            $stmt->fetch();
            $stmt->close();
            
            $vEMailId = $vEMailId ?? '';

            if (isset($_REQUEST["cEduCtgId"]) && $_REQUEST["cEduCtgId"] == 'ELX')
            {
                $subject = 'NOUN - Activation of Registration Number ';
                $mail_msg = "Dear $vFirstName,<p>
                Thank you for your interest in NOUN certificate programme<p>
                Your registration number, ".$vMatricNo." has been activated.<p>
                You may go and sign-up as a fresh student on the home page, www.nouonline.nou.edu.ng.<p>
                You may use the 'Support' button to contact support, when you login if you need guidance<p>
                Congratulations.";
            }else
            {
                $subject = 'NOUN - Activation of Matriculation Number';
                $mail_msg = "Dear $vFirstName,<p>
                Thank you for your interest in NOUN programme<p>
                Your matriculation number, ".$vMatricNo." has been activated.<p>
                You may go and sign-up as a fresh student on the home page, www.nouonline.nou.edu.ng.<p>
                You may use the 'Support' button to contact support, when you login if you need guidance<p>
                Congratulations.";
            }

            $mail_msg = wordwrap($mail_msg, 70);
            
            $mail->addAddress($vEMailId, $vFirstName);
            $mail->Subject = $subject;
            $mail->Body = $mail_msg;
                                
            //record mail email_off
            for ($incr = 1; $incr <= 5; $incr++)
            {
                if ($mail->send())
                {
                    //log_actv('Notification of allocation of matriculation number sent to '.$_REQUEST["uvApplicationNo"].', '.$vEMailId);
                    break;
                }
            }*/
									
            $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

            //echo 'xRecords updated successfully<br>Mail sent to student accordingly<br>Candidate screened qualififed with matriculation number:<br>'.$vMatricNo;exit;
            echo 'xRecords updated successfully<br>Matriculation number is displayed on the form preview<br>Candidate screened qualififed with matriculation number:<br>'.$vMatricNo;exit;
        }catch(Exception $e) 
        {
            $mysqli->rollback(); //remove all queries from queue if error (undo)
            throw $e;
        }
    }
}