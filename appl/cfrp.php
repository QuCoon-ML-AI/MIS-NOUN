<?php
require_once('../../fsher/fisher.php');
require_once('../../PHPMailer/mail_con.php');
require_once('lib_fn.php');

if (isset($_REQUEST['save']) && $_REQUEST['save'] == '1')
{	
	$mysqli = link_connect_db();
    
	$stmt = $mysqli->prepare("SELECT * FROM s_m_t 
    WHERE vLastName = ?
    AND vFirstName = ?
    AND vOtherName = ?
    AND dBirthDate = ?
    AND grad <> '0'");
    $stmt->bind_param("ssss",
    $_REQUEST["vLastName"], 
    $_REQUEST["vFirstName"], 
    $_REQUEST["vOtherName"], 
    $_REQUEST["dBirthDate"]);
    $stmt->execute();
    $stmt->store_result();
    $row_exist = $stmt->num_rows;

    if ($row_exist > 0)
    {
        $stmt->close();
        echo 'Candidate is currently running a programme';
        exit;
    }
    
    $stmt = $mysqli->prepare("SELECT RetrievalReferenceNumber 
    FROM remitapayments_app a, prog_choice_0 b 
    WHERE ResponseCode <> '00'
    AND ResponseCode <> '01'
    AND a.vLastName = b.vLastName
    AND a.vFirstName = b.vFirstName
    AND a.vOtherName = b.vOtherName
    AND a.cEduCtgId = b.cEduCtgId
    AND a.vLastName = ?
    AND a.vFirstName = ?
    AND a.vOtherName = ?
    AND a.cEduCtgId = ?
    AND b.dateofbirth = ?");
    $stmt->bind_param("sssss",
    $_REQUEST["vLastName"], 
    $_REQUEST["vFirstName"], 
    $_REQUEST["vOtherName"], 
    $_REQUEST["cEduCtgId"], 
    $_REQUEST["dBirthDate"]);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($rrr);
    $stmt->fetch();
    
    $rrr = $rrr ?? '';

    if ($rrr <> '' && $rrr <> 'xxxx')
    {
        $stmt->close();
        echo 'Payment already initiated. Please do the following to continue:<p>
        1. Click the Ok button<br>
        2. Click the home button (top left)<br>
        3. Click Ádmission<br>
        4. Click Conclude hanging payment<br>
        5. Select and enter options exactly as you did when you initiated payment<br>
        6. Click the Submit button<br>
        7. Follow the prompt on the screen';
        exit;
    }
    
    if (chk_mail($_REQUEST["payerEmail"]) == 0)
    {
        echo 'Invalid e-mail address';
        exit;
    }
    
	$stmt = $mysqli->prepare("SELECT * FROM remitapayments_app 
    WHERE payerEmail = ? AND (ResponseCode = '00' OR ResponseCode = '01')");
    $stmt->bind_param("s",
    $_REQUEST["payerEmail"]);
    $stmt->execute();
    $stmt->store_result();
    $row_exist = $stmt->num_rows;

    if ($row_exist > 0)
    {
        $stmt->close();
        echo 'eMail address is already in use';
        exit;
    }
    
    $stmt = $mysqli->prepare("SELECT * FROM remitapayments_app 
    WHERE payerPhone = ? AND (ResponseCode = '00' OR ResponseCode = '01')");
    $stmt->bind_param("s",
    $_REQUEST["payerPhone"]);
    $stmt->execute();
    $stmt->store_result();
    $row_exist = $stmt->num_rows;

    if ($row_exist > 0)
    {
        $stmt->close();
        echo 'Phone number is already in use';
        exit;
    }
    
	/*$stmt = $mysqli->prepare("SELECT * FROM prog_choice 
    WHERE vMobileNo = ?");
    $stmt->bind_param("s",
    $_REQUEST["payerPhone"]);
    $stmt->execute();
    $stmt->store_result();
    $row_exist = $stmt->num_rows;

    if ($row_exist > 0)
    {
        $stmt->close();
        echo 'Phone number is already in use';
        exit;
    }*/

    $stmt->close();
    
    $mail->addAddress($_REQUEST["payerEmail"], $_REQUEST["vFirstName"]);
    $mail->Subject = 'NOUN MIS-Address Validity Test';
    $mail->Body = 'You email address passed validity test';
    try
	{
		$mail->send();
	}catch(Exception $e) 
	{
		echo 'eMail address error';
		exit;
	}

    echo 'can apply';
    exit;
}?>