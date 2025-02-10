<?php
include('const_def.php');
include('../../PHPMailer/mail_con.php');
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

if (isset($_REQUEST['ilin']))
{
    
    $user_CSV = array();
    $c = 0;
    
    $stmt = $mysqli->prepare("SELECT vMatricNo, vLastName, CONCAT(vFirstName,' ',vOtherName), vMobileNo from afnmatric a, prog_choice b WHERE a.vApplicationNo = b.vApplicationNo
    AND cSbmtd = '2'
    AND cmail_req = '0' LIMIT 250");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($vMatricNo, $vLastName, $othernames, $vMobileNo);
    while($stmt->fetch())
    {
        $user_CSV["$c"] = array($vMatricNo, $vLastName, $othernames, $vMobileNo);
        $stmt_a = $mysqli->prepare("UPDATE afnmatric SET cmail_req = '1' WHERE vMatricNo = ?");
        $stmt_a->bind_param("s", $vMatricNo);
        $stmt_a->execute();
        $c++;
    }
    $stmt_a->close();
    
    
    $file = "../../ext_docs/docs/mail_request.csv";
    $filename = "mail_request.csv";

    if (!file_exists($file))
    {
        echo 'File not found';
        exit;
    }

    $fp = fopen($file , 'w');
    foreach ($user_CSV as $line) 
    {
        fputcsv($fp, $line, ',');
    }
    fclose($fp);


    $file_size = filesize($file);

    if ($file_size == 0)
    {
        echo 'Request not sent or, all requests already sent';
        exit;
    }

    $orgsetins = settns();
    $mail_to1 = $orgsetins['mail_req_rec1'];
    $mail_to3 = $orgsetins['mail_req_rec3'];
    
    $stmt1 = $mysqli->prepare("SELECT cemail 
    FROM userlogin
    WHERE vApplicationNo = ?");
    $stmt1->bind_param("s",$_REQUEST["vApplicationNo"]);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($cemail);
    $stmt1->fetch();
    $stmt1->close();
    
    $subject = "Request for Student eMail Accounts";
    $mail_msg = "Please treat attachment with respect to subject matter"; //body of the email

    $mail->addAttachment($file); // Add attachments
    $mail->addAddress($mail_to1, '');
    $mail->addCC($mail_to3, '');
    $mail->addCC($cemail, '');
    $mail->Subject = $subject;
    $mail->Body = $mail_msg;
                            
    for ($incr = 1; $incr <= 5; $incr++)
    {
        if ($mail->send())
        {
            log_actv('Sent mail request to '.$mail_to1.' for '.$_REQUEST["candidate_count"].' students');
            echo 'Request sent successfully';
            break;
        }
    }
}?>