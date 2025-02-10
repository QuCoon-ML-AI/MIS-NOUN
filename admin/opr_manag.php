<?php
include('const_def.php');
require_once('../../fsher/fisher.php');
include('../../PHPMailer/mail_con.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

date_default_timezone_set('Africa/Lagos');
$date2 = date("Y-m-d h:i:s");

if (isset($_REQUEST['ilin']) && $_REQUEST['ilin'] <> '' && isset($_REQUEST['save']) && $_REQUEST['save'] == '1' && isset($_REQUEST['currency']) && $_REQUEST['currency'] == '1')
{
	if (isset($_REQUEST['whattodo']) && !isset($_REQUEST['whattodo1']))
	{	
		if ($_REQUEST['whattodo'] == '0')
		{
			$new_role_name = strtolower($_REQUEST['new_role_name']);
			$stmt = $mysqli->prepare("SELECT * FROM role where lcase(vRoleName) = ?");
			$stmt->bind_param("s", $new_role_name);
			$stmt->execute();
			$stmt->store_result();
			
			if ($stmt->num_rows > 0)
			{	
				$stmt->close();
				echo 'Role already exist.'; exit;
			}
			
			$sql = mysqli_query(link_connect_db(), "SELECT max(sRoleID)+1 FROM role") or die(mysqli_error(link_connect_db()));
			$rs = mysqli_fetch_array($sql);
			
			$stmt = $mysqli->prepare("INSERT INTO role SET vRoleName = ?, sRoleID = ". $rs[0]);
			$stmt->bind_param("s", $_REQUEST['new_role_name']);
			$stmt->execute();
			$stmt->close();

			mysqli_close(link_connect_db());
			
			log_actv('created role, '.$_REQUEST["new_role_name"]);
			echo 'Role created successfully';
		}else if ($_REQUEST['whattodo'] == '1')
		{
			$exist_role = '';
			$a = strtolower($_REQUEST['new_role_name']);
			
			if (isset($_REQUEST['exist_role_one']))
			{
				$exist_role = $_REQUEST['exist_role_one'];
				$stmt = $mysqli->prepare("SELECT * FROM role where lcase(vRoleName) = ? and sRoleID <> ?");
				$stmt->bind_param("si", $a, $exist_role);
			}else if (isset($_REQUEST['exist_role_mult']))
			{				
				$exist_role = $_REQUEST['exist_role_mult'];
				$stmt = $mysqli->prepare("SELECT * FROM role where lcase(vRoleName) = ? and sRoleID <> ?");
				$stmt->bind_param("si", $a, $exist_role);
			}
			
			$stmt->execute();
			$stmt->store_result();
			
			if ($stmt->num_rows === 0)
			{
				$stmt->close();
				$stmt = $mysqli->prepare("update role set vRoleName = ? where sRoleID = ?");
				$stmt->bind_param("si", $_REQUEST['new_role_name'], $exist_role);
				$stmt->execute();
				$stmt->close();
				
				log_actv('edited role FROM '.$exist_role.' to '.$_REQUEST["new_role_name"]);
				echo 'Role edited successfully';exit;
			}
			$stmt->close();
			echo 'Role already exist.'; exit;
		}else if ($_REQUEST['whattodo'] == '2')
		{
			$stmt = $mysqli->prepare("DELETE FROM role_perm WHERE sRoleID = ?");
			$stmt->bind_param("i", $_REQUEST['exist_role_one']);
			$stmt->execute();
			$stmt->close();
						
			$str_name = ''; $spec_perms = '';

			$stmt = $mysqli->prepare("INSERT INTO role_perm 
			(sRoleID, ictID)
			VALUE(?, ?)");
			
			try
			{
				$mysqli->autocommit(FALSE);
				for ($k = 1; $k <= $_REQUEST['number_perms']; $k++)
				{
					$spec_perms = "perm_chk".$k;

					if (isset($_REQUEST["$spec_perms"]))
					{
						$stmt->bind_param("ii", $_REQUEST['exist_role_one'], $k);
						$stmt->execute();
						//echo $_REQUEST['exist_role_one'].','.$k.', '.$stmt->affected_rows;'<br>';
					}
				}
				$stmt->close();
				
				log_actv('assigned permision(s) to role, '.$_REQUEST['exist_role_one']);

				$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
				
				echo'Permision(s) assigned successfully';
			}catch(Exception $e)
			{
			  $mysqli->rollback(); //remove all queries FROM queue if error (undo)
			  throw $e;
			}
		}else if ($_REQUEST['whattodo'] == '3')
		{			
			$stmt = $mysqli->prepare("DELETE FROM role_perm WHERE sRoleID = ?");
			$stmt->bind_param("s", $_REQUEST['exist_role_one']);
			$stmt->execute();
			$stmt->close();
			
			log_actv('revoked permision(s) FROM role, '.$_REQUEST['exist_role_one']);
			echo'Permision(s) revoked successfully';
		}else if ($_REQUEST['whattodo'] == '4') // assign role to user
		{
			if (isset($_REQUEST['exist_role1']))
			{				
				$stmt = $mysqli->prepare("SELECT * FROM role_perm where sRoleID = ?");
				$role_names = '(';
				
				foreach ($_REQUEST['exist_role1'] as $key => $value)
				{					
					$stmt->bind_param("s",$value);
					$stmt->execute();
					$stmt->store_result();
					if ($stmt->num_rows === 0)
					{
						$role_names .= "'$value',";
					}
				}
				$stmt->close();
				
				if ($role_names <> '(')
				{
					$role_names = substr($role_names,0,strlen($role_names)-1) . ")";
					$rssql_names = mysqli_query(link_connect_db(), "SELECT vRoleName FROM role WHERE sRoleID in $role_names") or die(mysqli_error(link_connect_db()));
					
					$rec_num = mysqli_num_rows($rssql_names); 
					$cnt = 0; 
					$role_names = '';

					while($rs_names = mysqli_fetch_array($rssql_names))
					{
						$cnt++; 
						if ($cnt == $rec_num && $cnt == 1)
						{
							$role_names = $rs_names[0];
						}elseif ($cnt == $rec_num)
						{
							$role_names = substr($role_names,0,strlen($role_names)-2) . ' and ' . $rs_names[0];
						}else
						{
							$role_names .= $rs_names[0] . ', ';
						}
					}
                    mysqli_close(link_connect_db());
					
					echo "Role(s): $role_names, must be assigned permision(s) before it/they can be assigned to user(s).";exit;
				}
				
				$stmt = $mysqli->prepare("DELETE FROM role_user WHERE vUserId = ?");
				$stmt->bind_param("s", $_REQUEST['exist_user']);
				$stmt->execute();
				$stmt->close();
				
				try
				{
					$mysqli->autocommit(FALSE); //turn on transactions

					$stmt = $mysqli->prepare("INSERT INTO role_user 
					(sRoleID, vUserId)
					values (?, ?)");

					foreach ($_REQUEST['exist_role1'] as $key => $value)
					{   
						$stmt->bind_param("ss", $value, $_REQUEST["exist_user"]);
						$stmt->execute();
					}
					$stmt->close();
					
					log_actv('assigned role(s) to user, '.$_REQUEST['exist_user']);
					
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

					$stmt = $mysqli->prepare("SELECT vFirstName FROM userlogin where vApplicationNo = ?");
					$stmt->bind_param("s", $_REQUEST['exist_user']);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($vFirstName);
					$stmt->fetch();
					$stmt->close();

					$stmt = $mysqli->prepare("SELECT mail_id FROM mail_rec where vApplicationNo = ?");
					$stmt->bind_param("s", $_REQUEST['exist_user']);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($mail_id);
					$stmt->fetch();
					$stmt->close();

					$payerEmail = $mail_id;
					
					if (!is_bool(strpos($payerEmail, "@noun.edu.ng")))
                    {
    					$subject = 'NOUN MIS Support - Assignmemnt of role';
    					$mail_msg = 'Dear '.$vFirstName.',<p>
    					Your user account has been activated.<p>
    					You may now login to attend to applicants and students<p>
    					
    					Thank you';
    		
    					$mail_msg = wordwrap($mail_msg, 70);
    					
    					$mail->addAddress($payerEmail, $vFirstName);
    					$mail->Subject = $subject;
    					$mail->Body = $mail_msg;
    					
    					for ($incr = 1; $incr <= 5; $incr++)
    					{
    						try 
    						{
    							$mysqli->autocommit(FALSE); //turn on transactions
    							
    							if ($mail->send())
    							{
    								log_actv('Sent role assignment notification to '.$payerEmail);
    								$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
    								
    								break;
    							}
    						} catch (Exception $e)
    						{
    							$mysqli->rollback(); //remove all queries from queue if error (undo)
    							throw $e;
    						}
    					}
                    }
					echo 'Role(s) assigned successfully';exit; 
				}catch(Exception $e)
				{
				  $mysqli->rollback(); //remove all queries FROM queue if error (undo)
				  throw $e;
				}
			}			
		}else if ($_REQUEST['whattodo'] == '5')
		{			
			$stmt = $mysqli->prepare("delete FROM role_user where vUserId = ?");
			$stmt->bind_param("i", $_REQUEST['exist_user']);
			$stmt->execute();
			$stmt->close();
			
			log_actv('revoked role(s) FROM user, '.$_REQUEST['exist_user']);
			echo 'Role(s) revoked successfully';
		}else if ($_REQUEST['whattodo'] == '6')
		{			
			$stmt = $mysqli->prepare("SELECT DISTINCT vUserId FROM role_user where sRoleID = ?");
			$stmt->bind_param("s", $_REQUEST['exist_role_one']);
			$stmt->execute();
			$stmt->store_result();
			
			if ($stmt->num_rows > 0)
			{
				echo 'Role cannot be deletedd. It has been assigned to '.$stmt->num_rows.' user(s)';exit;
			}
			$stmt->close();
			
			if (!isset($_REQUEST['conf']))
			{
				echo 'Delete selected role?';exit;
			}
			
			$stmt = $mysqli->prepare("delete FROM role where sRoleID = ?");
			$stmt->bind_param("s", $_REQUEST['exist_role_one']);
			$stmt->execute();
			$stmt->close();
						
			log_actv('deleted role, '.$_REQUEST['exist_role_one']);
			echo 'Role deleted successfully';
		}
	}else if (!isset($_REQUEST['whattodo']) && isset($_REQUEST['whattodo1']))
	{
		if ($_REQUEST['whattodo1'] == '1')
		{			
			$stmt = $mysqli->prepare("SELECT * FROM userlogin where vApplicationNo = ?");
			$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
			$stmt->execute();
			$stmt->store_result();
			
			if ($stmt->num_rows > 0)
			{
				echo 'User already exist.'; exit;
			}
			$stmt->close();

			$stmt = $mysqli->prepare("SELECT * FROM desigs where vApplicationNo = ?");
			$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
			$stmt->execute();
			$stmt->store_result();
			
			if ($stmt->num_rows == 0)
			{
				echo 'Staff id (User ID) does not exist'; exit;
			}
			$stmt->close();
		}

		if ($_REQUEST['whattodo1'] == '1' || $_REQUEST['whattodo1'] == '2')
		{			
			// $sqlinsert_sub1 = '';

			// if (isset($_REQUEST['cprogrammeId72']))
			// {
			// 	foreach ($_REQUEST['cprogrammeId72'] as $key => $value){ $sqlinsert_sub1 .= "$value,";}
			// 	$sqlinsert_sub1 =  substr($sqlinsert_sub1, 0, strlen($sqlinsert_sub1)-1);
			// }

			if ($_REQUEST['whattodo1'] == '1')// create user
			{			
				$e = $_REQUEST["uvApplicationNo"];
				$f = $_REQUEST["uvApplicationNo"];

				try
				{
					$mysqli->autocommit(FALSE);
					
					if (isset($_FILES['sbtd_pix']))
					{
						$file_chk = check_file('50000', '2');
						if ($file_chk <> '')
						{
							echo $file_chk;
							exit;
						}
						
						$target_file = basename($_FILES["sbtd_pix"]["name"]); 
						$file_name_ext = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

						delete_staff_pp_file($_REQUEST['uvApplicationNo']);
						
						if (!move_uploaded_file($_FILES['sbtd_pix']['tmp_name'], BASE_FILE_NAME_FOR_STAFF . $target_file))
						{
							echo  "Upload failed, please try again"; exit;
						}

						$token = openssl_random_pseudo_bytes(6);
						$token = bin2hex($token);

						$new_file_name = BASE_FILE_NAME_FOR_STAFF."p_" . $token.".$file_name_ext";

						rename(BASE_FILE_NAME_FOR_STAFF . $_FILES['sbtd_pix']['name'], $new_file_name);
						chmod($new_file_name, 0644);

						$stmt = $mysqli->prepare("REPLACE INTO staff_pics SET vApplicationNo = ?, vmask = '$token', act_date = '$date2'");
						$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
						$stmt->execute();
						$stmt->close();
					}
					
					$stmt2 = $mysqli->prepare("DELETE FROM user_centre WHERE vApplicationNo = ?");
					$stmt2->bind_param("s", $_REQUEST['uvApplicationNo']);
					$stmt2->execute();
					$stmt2->close();
					
					$stmt2 = $mysqli->prepare("REPLACE INTO user_centre set vApplicationNo = ?, cStudyCenterId = ?");
					foreach ($_REQUEST['staff_study_center'] as $key => $value)
					{
						$stmt2->bind_param("ss", $_REQUEST['uvApplicationNo'], $value);
						$stmt2->execute();
					}
					
					$stmt = $mysqli->prepare("INSERT INTO userlogin SET
					vApplicationNo = ?, 
					vPassword = md5(?),
					cFacultyId = ?, 
					cdeptId = ?,
					vLastName = ?, 
					vFirstName = ?, 
					vOtherName = ?, 
					cphone = ?, 
					cemail = ?, 
					cpwd = '0',
					cStatus = '1',
					tech_support = ?,
					staff_cat = ?,
					act_date = '$date2'");
					$stmt->bind_param("sssssssssss", $e, $f, 
					$_REQUEST["cFacultyId"], 
					$_REQUEST["cdept"],
					$_REQUEST["vLastName"], 
					$_REQUEST["vFirstName"], 
					$_REQUEST["vOtherName"], 
					$_REQUEST['cphone'], 
					$_REQUEST['cemail'], 
					$_REQUEST['tech_support'], 
					$_REQUEST['staff_cat']);
					$stmt->execute();

					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
					$stmt->close();
				}catch(Exception $e)
				{
					$mysqli->rollback(); //remove all queries FROM queue if error (undo)
				  throw $e;
				}

				$payerName = $_REQUEST["vLastName"].' '.$_REQUEST["vFirstName"];

				if ($_REQUEST["vOtherName"] <> '')
				{
					$payerName .= ' '.$_REQUEST["vOtherName"];
				}

				$payerEmail = $_REQUEST['cemail'];	

				$subject = 'NOUN -  SMS User Account Creation';
				$mail_msg = 'Dear '.$payerName.',<p>
				Your loggin details follows:<p>
				User ID (Staff ID): '.$_REQUEST["uvApplicationNo"].' <br>
				Initial password: '.$_REQUEST["uvApplicationNo"].'<p>
				You will be required to change your password when you attempt to use the above detail at www.nouonline.nou.edu.ng<p>
				
				Thank you';
	
				$mail_msg = wordwrap($mail_msg, 70);
				
                $mail->addAddress($payerEmail, $payerName);
                $mail->Subject = $subject;
                $mail->Body = $mail_msg;
                
				for ($incr = 1; $incr <= 5; $incr++)
				{
					try 
                    {
                        $mysqli->autocommit(FALSE); //turn on transactions
                        
                        if ($mail->send())
                        {
                            log_actv('Sent newly created user account detail to '.$mail_id);
                            $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
                            
                			break;
                        }
                    } catch (Exception $e)
                    {
                        $mysqli->rollback(); //remove all queries from queue if error (undo)
            	        throw $e;
                    }
				}
				
				log_actv('created user, '.$_REQUEST["uvApplicationNo"]);
				echo $token.'User created successfully'; exit;
			}else if ($_REQUEST['whattodo1'] == '2')//edit user
			{
				try
				{
					$mysqli->autocommit(FALSE);
					
					if (isset($_FILES['sbtd_pix']))
					{
						$file_chk = check_file('50000', '2');
						if ($file_chk <> '')
						{
							echo $file_chk;
							exit;
						}
						
						$target_file = basename($_FILES["sbtd_pix"]["name"]); 
						$file_name_ext = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

						delete_staff_pp_file($_REQUEST['uvApplicationNo']);
						
						if (!move_uploaded_file($_FILES['sbtd_pix']['tmp_name'], BASE_FILE_NAME_FOR_STAFF . $target_file))
						{
							echo  "Upload failed, please try again"; exit;
						}

						$token = openssl_random_pseudo_bytes(6);
						$token = bin2hex($token);

						$new_file_name = BASE_FILE_NAME_FOR_STAFF."p_" . $token.".$file_name_ext";

						rename(BASE_FILE_NAME_FOR_STAFF . $_FILES['sbtd_pix']['name'], $new_file_name);
						chmod($new_file_name, 0644);

						$stmt = $mysqli->prepare("REPLACE INTO staff_pics SET vApplicationNo = ?, vmask = '$token', act_date = '$date2'");
						$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
						$stmt->execute();
						$stmt->close();
					}
					
					$stmt2 = $mysqli->prepare("DELETE FROM user_centre WHERE vApplicationNo = ?");
					$stmt2->bind_param("s", $_REQUEST['exist_user1']);
					$stmt2->execute();
					$stmt2->close();

					$stmt2 = $mysqli->prepare("REPLACE INTO user_centre set vApplicationNo = ?, cStudyCenterId = ?");
					foreach ($_REQUEST['staff_study_center'] as $key => $value)
					{
						$stmt2->bind_param("ss", $_REQUEST['exist_user1'], $value);
						$stmt2->execute();
					}
					
					$stmt = $mysqli->prepare("UPDATE userlogin SET
					vLastName = ?,
					vFirstName = ?,
					vOtherName = ?,
					cFacultyId = ?, 
					cdeptId = ?, 
					cphone = ?, 
					cemail = ?,
					tech_support = ?,
					staff_cat = ?,
					act_date = '$date2'
					WHERE vApplicationNo = ?");
					$stmt->bind_param("ssssssssss", $_REQUEST["vLastName"],$_REQUEST["vFirstName"],$_REQUEST["vOtherName"],$_REQUEST["cFacultyId"], $_REQUEST["cdept"], $_REQUEST['cphone'], $_REQUEST['cemail'], $_REQUEST['tech_support'], $_REQUEST["staff_cat"], $_REQUEST['exist_user1']);
					$stmt->execute();
					
					log_actv('Edited user record, '.$_REQUEST["exist_user1"]);
					
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

					$stmt_last = $mysqli->prepare("SELECT vmask FROM staff_pics WHERE vApplicationNo = ?");
					$stmt_last->bind_param("s", $_REQUEST["exist_user1"]);
					$stmt_last->execute();
					$stmt_last->store_result();
					$stmt_last->bind_result($token);
					$stmt_last->fetch();			
					$stmt_last->close();

					echo $token.'Record edited successfully'; exit;
					$stmt->close();
				}catch(Exception $e)
				{
					$mysqli->rollback(); //remove all queries FROM queue if error (undo)
				  throw $e;
				}
			}
			$stmt->close();
		}else if ($_REQUEST['whattodo1'] == '3')//block user
		{
			$stmt = $mysqli->prepare("SELECT cStatus FROM userlogin where vApplicationNo = ?");
			$stmt->bind_param("s", $_REQUEST['exist_user1']);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($cStatus_01);
			$stmt->fetch();
			
			if ($cStatus_01 == '0')
			{
				echo 'User already blocked';exit;
			}
			
			$stmt = $mysqli->prepare("UPDATE userlogin SET cStatus = '0', act_date = '$date2' WHERE vApplicationNo = ?");
			$stmt->bind_param("s", $_REQUEST['exist_user1']);
			$stmt->execute();
			$stmt->close();
						
			log_actv('user, '.$_REQUEST["exist_user1"].' blocked');
			echo 'User blocked successfully';exit;
		}else if ($_REQUEST['whattodo1'] == '4')//unblock user
		{
			$stmt = $mysqli->prepare("SELECT cStatus FROM userlogin where vApplicationNo = ?");
			$stmt->bind_param("s", $_REQUEST['exist_user1']);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($cStatus_02);
			$stmt->fetch();
			
			if ($cStatus_02 == '1')
			{
				echo 'User not blocked';exit;
			}
			
			$stmt = $mysqli->prepare("UPDATE userlogin SET cStatus = '1', act_date = '$date2' WHERE vApplicationNo = ?");
			$stmt->bind_param("s", $_REQUEST['exist_user1']);
			$stmt->execute();
			$stmt->close();
			
			log_actv('user, '.$_REQUEST["exist_user1"].' unblocked');
			echo 'User unblocked successfully';
		}
	}
}else if (isset($_REQUEST['ilin']) && $_REQUEST['ilin'] <> '' && isset($_REQUEST['update_frm']) && $_REQUEST['update_frm'] == '1' && isset($_REQUEST['exist_user1']))
{
	$cnt = 0; $str = '';
	
	$stmt = $mysqli->prepare("SELECT * FROM staff_pics WHERE vApplicationNo = ?");
	$stmt->bind_param("s", $_REQUEST['exist_user1']);
	$stmt->execute();
	$stmt->store_result();
	$passpotLoaded = $stmt->num_rows;
	$stmt->close();
	
	$stmt = $mysqli->prepare("SELECT vRoleName FROM userlogin a, role_user b, role c 
	where vUserId = vApplicationNo and b.sRoleID = c.sRoleID and vApplicationNo = ?");
	$stmt->bind_param("s", $_REQUEST['exist_user1']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($vRoleName_02);
	$stmt->fetch();
	$stmt->close();

	$vRoleName_02 = $vRoleName_02 ?? '';

	$stmt = $mysqli->prepare("SELECT vLastName, vFirstName, vOtherName, cphone, cemail, cFacultyId, cdeptId, tech_support, staff_cat FROM userlogin 
	where vApplicationNo = ?");
	$stmt->bind_param("s", $_REQUEST['exist_user1']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($vLastName_02, $vFirstName_02, $vOtherName_02, $cphone_02, $cemail_02, $cFacultyId_02, $cdeptId_02, $tech_support_02, $staff_cat_02);	
	$stmt->fetch();
	$stmt->close();

	$vLastName_02 = $vLastName_02 ?? '';
	$vFirstName_02 = $vFirstName_02 ?? '';
	$vOtherName_02 = $vOtherName_02 ?? '';
	$cphone_02 = $cphone_02 ?? '';

	$cemail_02 = $cemail_02 ?? '';
	if ($cemail_02 == '')
	{
		$stmt = $mysqli->prepare("SELECT mail_id FROM mail_rec 
		where vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST['exist_user1']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($cemail_02);	
		$stmt->fetch();
		$stmt->close();
	}

	$cFacultyId_02 = $cFacultyId_02 ?? '';
	$cdeptId_02 = $cdeptId_02 ?? '';
	
	$tech_support_02 = $tech_support_02 ?? '';
	$staff_cat_02 = $staff_cat_02 ?? '';

	$str = '';

	$stmt = $mysqli->prepare("SELECT cStudyCenterId FROM user_centre 
	where vApplicationNo = ?");
	$stmt->bind_param("s", $_REQUEST['exist_user1']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cStudyCenterId_02);	
	while($stmt->fetch())
	{
		$str .= str_pad($cStudyCenterId_02, 3).',';
	}
	$cStudyCenterId_02 = $str;
	$stmt->close();

	$mask = get_staff_mask($_REQUEST['exist_user1']);
	$mask = $mask ?? '';
	
	$str = str_pad($vRoleName_02, 100).
	str_pad($vLastName_02, 100).
	str_pad($vFirstName_02, 100).
	str_pad($vOtherName_02, 100).
	str_pad($cphone_02, 100).
	str_pad($cemail_02, 100).
	
	str_pad($cStudyCenterId_02, 1000).
	str_pad($staff_cat_02, 100).
	str_pad($cFacultyId_02, 100).
	str_pad($cdeptId_02, 100).
	str_pad($tech_support_02, 100).'#'.
 	$mask;
	
	echo $str; exit;
}else if (isset($_REQUEST['update_frm']) && $_REQUEST['update_frm'] == '0' && isset($_REQUEST['whattodo']))
{
	$str = '';
	$rsql = mysqli_query(link_connect_db(), "SELECT sRoleID, vRoleName FROM role order by vRoleName")or die("unable to insert applyqual record ".mysqli_error(link_connect_db()));
	$num = mysqli_num_rows($rsql);
	while($rs = mysqli_fetch_array($rsql))
	{
		$str .= $rs['sRoleID'].'+'.$rs['vRoleName'].',';
	}
	mysqli_close(link_connect_db());
	echo $str;exit;
}else if (isset($_REQUEST['update_frm']) && $_REQUEST['update_frm'] == '2' && isset($_REQUEST['whattodo1']))
{
	$str = '';
	$rsql = mysqli_query(link_connect_db(), "SELECT vApplicationNo, concat(ucase(vLastName),' ',vFirstName,' ',vOtherName) namess FROM userlogin order by namess")or die("unable to insert record ".mysqli_error(link_connect_db()));
	while($rs = mysqli_fetch_array($rsql))
	{
		$str .= $rs['vApplicationNo'].'+'.$rs['namess'].',';
	}
	mysqli_close(link_connect_db());
	echo $str;exit;
}else if (isset($_REQUEST['update_frm']) && $_REQUEST['update_frm'] == '3' && isset($_REQUEST['whattodo']) && isset($_REQUEST['exist_role_one']))
{	
	$str = '';

	$stmt = $mysqli->prepare("SELECT ictID FROM role_perm  where sRoleID = ? ORDER BY ictID");
	$stmt->bind_param("i", $_REQUEST['exist_role_one']);
	$stmt->execute();
	$stmt->store_result();

	$stmt->bind_result($ictID_01);
	$num = $stmt->num_rows;
	while($stmt->fetch())
	{
		//$str .= str_pad($ictID_01, 3).', ';
		$str .= $ictID_01.',';
	}
	$stmt->close();
	echo $str;exit;
}else if (isset($_REQUEST['update_frm']) && $_REQUEST['update_frm'] == '4' && 
((isset($_REQUEST['whattodo']) && isset($_REQUEST['exist_user'])) || 
(isset($_REQUEST['whattodo1']) && isset($_REQUEST['exist_user1']))))
{
	$str = '';
	$stmt = $mysqli->prepare("SELECT sRoleID FROM role_user  where vUserId = ? order by sRoleID");
	if (isset($_REQUEST['whattodo']) && isset($_REQUEST['exist_user']))
	{
		$stmt->bind_param("s", $_REQUEST['exist_user']);
	}else
	{
		$stmt->bind_param("s", $_REQUEST['exist_user1']);
	}
	
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($sRoleID_01);
	
	while($stmt->fetch())
	{
		$str .= $sRoleID_01.',';
	}
	echo $str;exit;
}?>
