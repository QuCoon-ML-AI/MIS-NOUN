<?php 
include('const_def.php');
require_once('../../fsher/fisher.php');
include('../../PHPMailer/mail_con.php');
include('lib_fn.php');

$mysqli = link_connect_db();

if (isset($_REQUEST['confirm_pay']))
{	
	$a = addslashes(trim($_REQUEST["vLastName"]));
	$b = addslashes(trim($_REQUEST["vFirstName"]));
	$c = addslashes(trim($_REQUEST["vOtherName"]));
	
	if (isset($_REQUEST['rrr']) && $_REQUEST['rrr'] <> '')
	{
	    //echo $_REQUEST['rrr'].'<br>'.$_REQUEST['vLastName'].'<br>'.$_REQUEST['vFirstName'].'<br>'.$_REQUEST['vOtherName'].'<br>'.$_REQUEST['vEMailId'].'<br>'.$_REQUEST['vMobileNo'].'<br>'.$_REQUEST['amount'];
		$stmt = $mysqli->prepare("SELECT Regno, RetrievalReferenceNumber, MerchantReference, vDesc, Status, ResponseCode, vDesc
		FROM remitapayments_app 
		WHERE RetrievalReferenceNumber = ? AND 
		vLastName = ? AND vFirstName = ? AND vOtherName = ? AND payerEmail = ? AND payerPhone = ? AND Amount = ?");
	
		$stmt->bind_param("ssssssi", $_REQUEST['rrr'], $a, $b, $c, $_REQUEST['vEMailId'], $_REQUEST['vMobileNo'], $_REQUEST['amount']);
	}else if (isset($_REQUEST['orderId']) && $_REQUEST['orderId'] <> '')
	{
		$stmt = $mysqli->prepare("SELECT Regno, RetrievalReferenceNumber, MerchantReference, vDesc, Status, ResponseCode, vDesc 
		FROM remitapayments_app 
		WHERE MerchantReference = ? AND 
		vLastName = ? AND vFirstName = ? AND vOtherName = ? AND payerEmail = ? AND payerPhone = ? AND Amount = ?");

		$stmt->bind_param("ssssssi", $_REQUEST['orderId'], $a, $b, $c, $_REQUEST['vEMailId'], $_REQUEST['vMobileNo'], $_REQUEST['amount']);
	}
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($Regno, $RetrievalReferenceNumber_db, $MerchantReference_db, $vDesc_db, $Status_db, $ResponseCode_db, $vDesc_db);

	if ($stmt->num_rows > 0)
	{ 
		$stmt->fetch();

		if (is_null($Regno))
		{
			$Regno = '';
		}
		
		if ($vDesc_db <> 'Application Fee')
		{
			echo 'No match found. Details not for application fee';
			exit;
		}else if ($ResponseCode_db == '00' || $ResponseCode_db == '01')
		{			
			if ($Regno == '')
			{
				$Regno = alloc_dum_pin($RetrievalReferenceNumber_db);

				$subject = 'Re: Allocation of Application form number';
				$mail_msg = 'Dear '.$_REQUEST['vFirstName'].',<p>The application form number, '.$Regno.' has been allocated to you.<br>
				You will enter it along with the password of your choice at the point of logging into your application form.<br><br>
				Thank you.';

				$mail_msg = wordwrap($mail_msg, 70);
				$payerEmail_db = $_REQUEST['vEMailId'];

				$mail->addAddress($payerEmail_db, $_REQUEST['vFirstName']); // Add a recipient
				$mail->Subject = $subject;
				$mail->Body = $mail_msg;

				try 
				{
					$mail->send();
					log_actv('Sent Application form number to '.$payerEmail_db);
				} catch (Exception $e)
				{
					echo 'Email address error';
				}
				
				// for ($incr = 1; $incr <= 5; $incr++)
				// {
				// 	if ($mail->send())
				// 	{
				// 		log_actv('Sent Application form number to '.$payerEmail_db);
				// 		break;
				// 	}
				// }
				if (isset($_REQUEST['rrr']) && $_REQUEST['rrr'] <> '')
				{
					$stmt1 = $mysqli->prepare("UPDATE remitapayments_app SET 
					Regno = '$Regno'
					WHERE RetrievalReferenceNumber = ?");
					$stmt1->bind_param("s", $_REQUEST['rrr']);
					$stmt1->execute();
				}else if (isset($_REQUEST['orderId']) && $_REQUEST['orderId'] <> '')
				{
					$stmt1 = $mysqli->prepare("UPDATE remitapayments_app SET 
					Regno = '$Regno'
					WHERE MerchantReference = ?");
					$stmt1->bind_param("s", $_REQUEST['orderId']);
					$stmt1->execute();
				}

				$stmt1 = $mysqli->prepare("UPDATE prog_choice_0 SET 
				vApplicationNo = '$Regno'
				WHERE vLastName = ? 
				and vFirstName = ?
				and vOtherName = ? 
				and vEMailId = ?
				and vMobileNo = ?
				and dAmnt = ?");
				$stmt1->bind_param("sssssi", $a, $b, $c, $_REQUEST['vEMailId'], $_REQUEST['vMobileNo'], $_REQUEST['amount']);
				$stmt1->execute();
				
				$stmt1 = $mysqli->prepare("INSERT IGNORE INTO prog_choice SELECT * FROM prog_choice_0 WHERE vApplicationNo = '$Regno';");
				$stmt1->execute();
				
				$stmt1 = $mysqli->prepare("DELETE FROM prog_choice_0 WHERE vApplicationNo = '$Regno';");
				//$stmt1->execute();
				$stmt1->close();

				echo 'Got AFN'.str_pad($Regno,50);
			}else
			{
				$stmt1 = $mysqli->prepare("UPDATE prog_choice_0 SET 
				vApplicationNo = '$Regno'
				WHERE vLastName = ? 
				and vFirstName = ?
				and vOtherName = ? 
				and vEMailId = ?
				and vMobileNo = ?
				and dAmnt = ?");
				$stmt1->bind_param("sssssi", $a, $b, $c, $_REQUEST['vEMailId'], $_REQUEST['vMobileNo'], $_REQUEST['amount']);
				$stmt1->execute();
				
				$stmt1 = $mysqli->prepare("INSERT IGNORE INTO prog_choice SELECT * FROM prog_choice_0 WHERE vApplicationNo = '$Regno';");
				$stmt1->execute();
				
				$stmt1 = $mysqli->prepare("DELETE FROM prog_choice_0 WHERE vApplicationNo = '$Regno';");
				//$stmt1->execute();
				$stmt1->close();
				
				
				$subject = 'Re: Allocation of Application form number';
				$mail_msg = 'Dear '.$_REQUEST['vFirstName'].',<p>The application form number, '.$Regno.' has been allocated to you.<br>
				You will enter it along with the password of your choice at the point of logging into your application form.<br><br>
				Thank you.';

				$mail_msg = wordwrap($mail_msg, 70);
				$payerEmail_db = $_REQUEST['vEMailId'];

				$mail->addAddress($payerEmail_db, $_REQUEST['vFirstName']); // Add a recipient
				$mail->Subject = $subject;
				$mail->Body = $mail_msg;
				try 
				{
					$mail->send();
					log_actv('Sent Application form number to '.$payerEmail_db);
				} catch (Exception $e)
				{
					echo 'Email address error';
				}

				// for ($incr = 1; $incr <= 5; $incr++)
				// {
				// 	if ($mail->send())
				// 	{
				// 		log_actv('Sent Application form number to '.$payerEmail_db);
				// 		break;
				// 	}
				// }
				
				echo 'success';
				exit;
			}
		}
		
		echo str_pad($RetrievalReferenceNumber_db,50).
		str_pad($MerchantReference_db,50).
		str_pad($Status_db,50).
		str_pad($vDesc_db,50).
		str_pad($Regno,50);
		exit;
	}else
	{
		echo 'No match found. Possible reasons are:<p>
		1. Payment is yet to be initiated. To initiate payment, click as follows:<p>Home > Admission > Apply for admission<p>
		2.Pieces of information entered does not match what was originally entered. Double-check entries';
		exit;
	}
}