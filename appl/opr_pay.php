<?php 
//include('const_def.php');
//require_once('../../fsher/fisher.php');
//include('../../PHPMailer/mail_con.php');
//include('lib_fn.php');

$mysqli = link_connect_db();

if (isset($_REQUEST["save"]))
{
	$orgsetins = settns();

	$targ_session = substr($orgsetins["cAcademicDesc"], 0, 4);
	
	$cEduCtgId = '';
	if (isset($_REQUEST['cEduCtgId']) && $_REQUEST['cEduCtgId'] <> '')
	{
	    $cEduCtgId = trim($_REQUEST['cEduCtgId']);
	}
	
	if ($cEduCtgId <> '')
	{
		$vApplicationNo = '';
		//$c = substr($_REQUEST['cEduCtgId'],0,3);		
		
		// $d = $_REQUEST['vLastName'];
		// $e = $_REQUEST['vFirstName'];
		// $f = $_REQUEST['vOtherName'];

		//$dBirthDate = substr($_REQUEST['dBirthDate'],6,4).'-'.substr($_REQUEST['dBirthDate'],3,2).'-'.substr($_REQUEST['dBirthDate'],0,2);

		// $subject = 'NOUN - eMail ID Validity Test';
        // $mail->Subject = $subject;
		// $mail_msg = 'Dear '. $_REQUEST['vFirstName'].',<p>
		// This is a test message to ascertain the validity of your e-mail address.<p>
		// Thank you.';
		// $mail_msg = wordwrap($mail_msg, 70);

		// $vEMailId = $_REQUEST['payerEmail'];
		// //$vEMailId = 'phadamoses@gmail.com';

		// $mail->addAddress($vEMailId, $_REQUEST['vFirstName']);
        // $mail->Body = $mail_msg;
		//if (!$mail->send())
		//{
			//$msg = "Unable to send message via email, ".$_REQUEST['payerEmail'];?>
			<script language="JavaScript" type="text/javascript">
				//inform('<?php //echo 	$msg;?>');			
			</script><?php
		//}else
		//{
			$stmt = $mysqli->prepare("REPLACE INTO prog_choice_0
			SET cEduCtgId = ?,
			vLastName = ?,
			vFirstName = ?,
			vOtherName = ?,
			dateofbirth = ?,
			vEMailId = ?,
			vMobileNo = ?,
			cProgrammeId = ?,
			dAmnt = ?,
			cAcademicDesc = ?,
			resident_ctry = ?,
			jamb_reg_no = ?,
			trans_time = now()");
			$stmt->bind_param("ssssssssdsss", 
			$cEduCtgId, 
			$_REQUEST['vLastName'], 
			$_REQUEST['vFirstName'], 
			$_REQUEST['vOtherName'], 
			$_REQUEST['dBirthDate'], 
			$_REQUEST['payerEmail'], 
			$_REQUEST['payerPhone'],
			$_REQUEST['pgrID'], 
			$_REQUEST['amount'],  
			$orgsetins['cAcademicDesc'],  
			$_REQUEST['resident_ctry'],  
			$_REQUEST['jambno']);
			$stmt->execute();
			$stmt->close();?>

			<script language="JavaScript" type="text/javascript">
				inform("Payment intiated successfully<br>Click the Next button to continue");			
			</script><?php
		//}
	}else
	{?>
	    <script language="JavaScript" type="text/javascript">
			caution_inform("We could not determine the category of your programme of choice<br>Go to the home page and try again");			
		</script><?php
	}
}