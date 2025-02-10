<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$currency = eyes_pilled('0');

if (isset($_REQUEST['save_cf']) && $_REQUEST['save_cf'] == '1' && isset($_REQUEST['currency_cf']) && $_REQUEST['currency_cf'] == '1')
{
	$stmt = $mysqli->prepare("select vApplicationNo
	from afnmatric
	where vMatricNo = ?");
	$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($vApplicationNo_afnmatric);
	 
	if ($stmt->num_rows === 0)
	{
		$stmt->close();
		echo 'Invalid matriculation number';exit;
	}else if (check_grad_student($_REQUEST["uvApplicationNo"]) == 1)
	{
		echo 'Matriculation number graduated';exit;
	}
	
	if (isset($_REQUEST['cQualCodeId']))
	{
		$stmt->fetch();
		$stmt->close();
		
		if (isset($_FILES['sbtd_pix']))
		{
			$file_chk = check_file('100000', '2');
			if ($file_chk <> '')
			{
				echo $file_chk;
				exit;
			}

			$flname = "pics/".$_REQUEST["cQualCodeId"]."_".addslashes($_REQUEST["vExamNo"])."_".$vApplicationNo_afnmatric.".jpg";
			
			if (!move_uploaded_file($_FILES['sbtd_pix']['tmp_name'], "pics/" . $_FILES['sbtd_pix']['name']))
			{
				echo  "Upload failed, please try again"; exit;
			}
			$bkp_flname = $flname; $file_ext = 0;
			
			while (file_exists($bkp_flname))
			{
				$file_ext++;
				$bkp_flname = "pics/".$_REQUEST["cQualCodeId"]."_".addslashes($_REQUEST["vExamNo"])."_".$vApplicationNo_afnmatric."_$file_ext.jpg";
				
			}
			rename($flname, $bkp_flname);
			chmod($bkp_flname, 0755);
			
			rename("pics/" . $_FILES['sbtd_pix']['name'], $flname);
			chmod($flname, 0755);
			
			log_actv('Uploaded copy of credential exam no.: '.$_REQUEST["vExamNo"].' for '.$_REQUEST["vMatricNo"]);
		}else
		{
			$flname_old = "pics/".$_REQUEST["hdcQualCodeId"]."_".addslashes($_REQUEST["hdvExamNo"])."_".$vApplicationNo_afnmatric.".jpg";
			$flname_new = "pics/".$_REQUEST["cQualCodeId"]."_".addslashes($_REQUEST["vExamNo"])."_".$vApplicationNo_afnmatric.".jpg";
			
			if ($flname_old <> $flname_new)
			{
				rename($flname_old, $flname_new);
			}
		}
		
		try
		{
			$mysqli->autocommit(FALSE);
			$stmt1 = $mysqli->prepare("replace into pics set vApplicationNo = '".$rsafnmatric["vApplicationNo"]."', cinfo_type = 'c', vExamNo = ?, cQualCodeId = ?");
			$stmt1->bind_param("ss", $_REQUEST['vExamNo'], $_REQUEST['cQualCodeId']);
			$stmt1->execute();
			$stmt1->close();

			$stmt1 = $mysqli->prepare("delete from applyqual_stff where cQualCodeId = ? and vExamNo = ? and vMatricNo = ?");
			$stmt1->bind_param("sss", $_REQUEST['hdcQualCodeId'], $_REQUEST['hdvExamNo'], $_REQUEST['vMatricNo']);
			$stmt1->execute();
			$stmt1->close();

			$a = trim($_REQUEST['vExamSchoolName']);
			$stmt1 = $mysqli->prepare("replace into applyqual_stff
			set vMatricNo = ?,
			cQualCodeId = ?,
			vExamNo = ?,
			vExamSchoolName = ?,
			cExamMthYear = ?");
			$stmt1->bind_param("sssss", $_REQUEST['vMatricNo'], $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo'], $a, $_REQUEST['cExamMthYear']);
			$stmt1->execute();
			$stmt1->close();

			log_actv('Updated record of qualification for '.$_REQUEST["vMatricNo"]);

			$a = trim($_REQUEST['vExamNo']);
			$b = trim($_REQUEST['hdvExamNo']);
			if ($_REQUEST['cQualCodeId'] == $_REQUEST['hdcQualCodeId'])
			{			
				$stmt1 = $mysqli->prepare("update afnqualsubject_stff
				set cQualCodeId = ?,
				vExamNo = ?
				where vMatricNo = ? and
				cQualCodeId = ? and
				vExamNo = ?");
				$stmt1->bind_param("sssss", $_REQUEST['cQualCodeId'], $a, $_REQUEST["vMatricNo"], $_REQUEST['hdcQualCodeId'], $b);
				$stmt1->execute();
				$stmt1->close();

				$stmt1 = $mysqli->prepare("update applysubject_stff
				set cQualCodeId = ?,
				vExamNo = ?
				where vMatricNo = ? and
				cQualCodeId = ? and
				vExamNo = ?");
				$stmt1->bind_param("sssss", $_REQUEST['cQualCodeId'], $a, $_REQUEST["vMatricNo"], $_REQUEST['hdcQualCodeId'], $b);
				$stmt1->execute();
				$stmt1->close();

				log_actv('Updated record of qualification subjects for '.$_REQUEST["vMatricNo"]);
			}else
			{
				$stmt1 = $mysqli->prepare("delete from afnqualsubject_stff
				where vMatricNo = ? and
				cQualCodeId = ? and
				vExamNo = ?");
				$stmt1->bind_param("sss", $_REQUEST["vMatricNo"], $_REQUEST['hdcQualCodeId'], $b);
				$stmt1->execute();
				$stmt1->close();

				$stmt1 = $mysqli->prepare("delete from applysubject_stff
				where vMatricNo = ? and
				cQualCodeId = ? and
				vExamNo = ?");
				$stmt1->bind_param("sss", $_REQUEST["vMatricNo"], $_REQUEST['hdcQualCodeId'], $b);
				$stmt1->execute();
				$stmt1->close();
			}
			echo 'Credential uploaded successfully.';
	
			$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
		}catch(Exception $e)
		{
		  $mysqli->rollback(); //remove all queries from queue if error (undo)
		  throw $e;
		}
	}
	$stmt->close();
}
