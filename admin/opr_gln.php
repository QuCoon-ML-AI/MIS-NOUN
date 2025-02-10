<?php

include('const_def.php');
include('../../PHPMailer/mail_con.php');
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$currency = eyes_pilled('0');

require_once('var_colls.php');

if (isset($_REQUEST['ilin']) && $_REQUEST['ilin'] <> '')
{
	$ref_table = 'prog_choice';
	//$ref_table = 'prog_choice_test';
	
	if ($_REQUEST["id_no"] == 0 || $_REQUEST["id_no"] == 1)
	{
		$stmt = $mysqli->prepare("select * from prog_choice where vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
		$stmt->execute();
		$stmt->store_result();
		
		if ($stmt->num_rows === 0)
		{
			$stmt->close();
			echo 'Invalid application form number';exit;
		}
		$stmt->close();	
		
		$stmt = $mysqli->prepare("select * from applyqual where vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
		$stmt->execute();
		$stmt->store_result();
		
		if ($stmt->num_rows === 0)
		{	
			$stmt->close();
			echo 'Needs to finish filling form';exit;
		}
		$stmt->close();
		echo '';
	}else if($_REQUEST["id_no"] == 2)
	{
		$stmt = $mysqli->prepare("SELECT vEMailId, vFirstName from prog_choice WHERE vApplicationNo = ?");

		if (isset($_REQUEST["afn_list"]))
		{
			$splitLine = explode("\n", str_replace("\r", "", $_REQUEST["afn_list"]));

			$cent_cnt = 0;

			$subject = 'NOUN - Invitation for Interview';
            $mail->Subject = $subject;
			
			foreach ($splitLine as $val_arr)
			{			
				$stmt->bind_param("s", $val_arr);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($vEMailId, $vFirstName);
				$stmt->fetch();

				$mail_msg = 'Dear '.$vFirstName.',<p>
				You are hereby invited for a screening interview with respect to your programme of interest as indicated in your provisional admission letter.<p>
				
				Details follows:<p>
				
				Date: xx/xx/xxx<br>
				Venue: venue<br>
				Time: xx:xxhr<br>

				Do come along with all relevant documents<p>

				Best wishes.<p>
				
				Thank you.';

				$mail_msg = wordwrap($mail_msg, 70);
				
                $mail->addAddress($vEMailId, $vFirstName);
                $mail->Body = $mail_msg;
                
				for ($incr = 1; $incr <= 5; $incr++)
				{
					try 
                    {
                        $mysqli->autocommit(FALSE); //turn on transactions
                        
                        if ($mail->send())
                        {
                            $ipee = getIPAddress();
    
    						$stmt_log = $mysqli->prepare("INSERT INTO atv_log SET 
    						vApplicationNo  = ?,
    						vDeed = 'Sent interview invtation to ".$vEMailId."',
    						act_location = ?");
    						$stmt_log->bind_param("ss", $val_arr, $ipee);
    						$stmt_log->execute();						
    						$stmt_log->close();
    						
                            $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
                			break;
                        }
                    } catch (Exception $e)
                    {
                        $mysqli->rollback(); //remove all queries from queue if error (undo)
            	        throw $e;
                    }
				}
					
				$cent_cnt++;
			}
			$stmt->close();

			if ($cent_cnt <= 1)
			{
				echo $cent_cnt. ' mail successfully sent'; exit;
			}else
			{
				echo $cent_cnt. ' mails successfully sent'; exit;
			}
		}else if (isset($_REQUEST["uvApplicationNo04"]))
		{
			$cent_cnt = 1;

			$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($vEMailId, $vFirstName);
			$stmt->fetch();
			$stmt->close();

			$subject = 'NOUN - Invitation for Interview';
			$mail_msg = 'Dear '.$vFirstName.',<p>
			
			You are hereby invited for a screening interview with respect to your programme of interest as indicated in your provisional admission letter.<p>
			
			Details follows:<p>
			
			Date: xx/xx/xxx<br>
			Venue: venue<br>
			Time: 00:00hr<br>

			Do come along with all relevant documents<p>

			Best wishes.
			
			Thank you.';

			$mail_msg = wordwrap($mail_msg, 70);
			
			for ($incr = 1; $incr <= 5; $incr++)
			{
				try 
                {
                    $mysqli->autocommit(FALSE); //turn on transactions
                    
                    $mail->addAddress($vEMailId, $vFirstName);
                    $mail->Subject = $subject;
                    $mail->Body = $mail_msg;
                    $mail->send();
                    
                    log_actv('Sent interview invtation to '.$vEMailId);
                    $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
                    
                    echo $cent_cnt. ' mail successfully sent'; exit;
        			break;
                } catch (Exception $e)
                {
                    $mysqli->rollback(); //remove all queries from queue if error (undo)
        	        throw $e;
                }
			}
		}

		echo 'No mail sent';exit;
	}else if ($_REQUEST["id_no"] == 2 && isset($_REQUEST['save']) && $_REQUEST['save'] == 1)//if ($_REQUEST["id_no"] == 2 && (isset($_REQUEST['count_rec_q']) || isset($_REQUEST['count_rec_nq'])))
	{
		$update_count = 0;
		
		$stmt = $mysqli->prepare("UPDATE $ref_table
		SET vProcessNote = '',
		cSCrnd = '0',
		cqualfd = '0'
		WHERE cFacultyId = ?");
		$stmt->bind_param("s", $_REQUEST["cFacultyId"]);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare("UPDATE $ref_table
		SET vProcessNote = 'qualified for one or more programmes',
		cSCrnd = '1',
		cqualfd = '1'
		WHERE vApplicationNo = ?");

		for ($x = 1; $x <= $_REQUEST["count_rec_q"]; $x++)
		{
			$apllicant = "apllicant".$x;
			if (isset($_REQUEST["$apllicant"]))
			{
				$stmt->bind_param("s", $_REQUEST["$apllicant"]);
				$stmt->execute();
				$update_count++;
			}
		}
		$stmt->close();

		$stmt = $mysqli->prepare("UPDATE $ref_table
		SET vProcessNote = 'mannually qualified',
		cSCrnd = '1',
		cqualfd = '1'
		WHERE vApplicationNo = ?");

		for ($x = 1; $x <= $_REQUEST["count_rec_nq"]; $x++)
		{
			$apllicant = "apllicant_0".$x;
			if (isset($_REQUEST["$apllicant"]))
			{
				$stmt->bind_param("s", $_REQUEST["$apllicant"]);
				$stmt->execute();
				$update_count++;
			}
		}
		$stmt->close();

		echo $update_count . " record(s) updated successfully";
	}
}?>