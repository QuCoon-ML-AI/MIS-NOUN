<?php
require_once('../../fsher/fisher.php');
include('const_def.php');
require_once('lib_fn.php');

$mysqli = link_connect_db();

if (isset($_REQUEST['loadcred']) && $_REQUEST['loadcred'] == '1')
{
	$stmt = $mysqli->prepare("SELECT * FROM pics WHERE vApplicationNo = ? and cinfo_type = 'C' and cQualCodeId = ? and vExamNo = ?");
	$stmt->bind_param("sss",$_REQUEST["vApplicationNo"],  $_REQUEST["cQualCodeId"], $_REQUEST["vExamNo"]);
	$stmt->execute();
	$stmt->store_result();
	if($stmt->num_rows == 0) 
	{
		echo 'Scanned copy of credential not uploaded'.$_REQUEST["vApplicationNo"];
	}else
	{
		echo get_cert_pix('');
	}	
	$stmt->close();
}else //if (isset($_REQUEST['save']) && $_REQUEST['save'] == '1' && $_REQUEST['currency'] == '1')
{
	if ((isset($_REQUEST['ope_mode']) && $_REQUEST['ope_mode'] == 'a') || (isset($_REQUEST['hdcQualCodeId']) && $_REQUEST['hdcQualCodeId'] == ''))
	{
		$stmt = $mysqli->prepare("SELECT * FROM applyqual WHERE vApplicationNo = ? AND (cQualCodeId <> ? OR vExamNo <> ?) AND cExamMthYear = ?");
		$stmt->bind_param("ssss",$_REQUEST["vApplicationNo"],  $_REQUEST["cQualCodeId"], $_REQUEST["vExamNo"], $_REQUEST['cExamMthYear']);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows > 0) 
		{
			echo "A certificate with this date already exist";exit;
		}
		$stmt->close();
		
		$stmt = $mysqli->prepare("SELECT * FROM applyqual WHERE vApplicationNo = ? and cQualCodeId = ? and vExamNo = ?");
		$stmt->bind_param("sss",$_REQUEST["vApplicationNo"],  $_REQUEST["cQualCodeId"], $_REQUEST["vExamNo"]);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows > 0) 
		{
			echo "Qualification already exist";exit;
		}
		$stmt->close();

		$stmt = $mysqli->prepare("SELECT * FROM applyqual WHERE vApplicationNo = ? and cQualCodeId = ? and vExamNo = ?");
		$stmt->bind_param("sss",$_REQUEST["vApplicationNo"],  $_REQUEST["cQualCodeId"], $_REQUEST["vExamNo"]);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows > 0) 
		{
			echo "A qualification with this examination number already exists.";exit;
		}
		$stmt->close();


		if (($_REQUEST["cQualCodeId"] <> '601' && $_REQUEST['cEduCtgId_qual'] == 'PSZ') || ($_REQUEST["cQualCodeId"] == '601' && $_REQUEST['cEduCtgId_qual'] <> 'PSZ'))
		{
			echo "Please delete and add qualification afresh.";exit;
		}
	}	
	
	// try
	// {
	// 	$mysqli->autocommit(FALSE);

		if (isset($_FILES['sbtd_pix']) && $_FILES['sbtd_pix']['name'] <> '')
		{
			$filepath = $_FILES['sbtd_pix']['tmp_name'];
			$fileSize = filesize($filepath);
			//$fileinfo = finfo_open(FILEINFO_MIME_TYPE);
			//$filetype = finfo_file($fileinfo, $filepath);
			if ($fileSize == 0)
			{
				echo 'Cannot upload empty file for scanned copy of credential';
				exit;
			}

			if ($fileSize > 100000)
			{ // 3 MB (1 byte * 1024 * 1024 * 3 (for 3 MB))
				
				echo "The file is too large for scanned copy of credential. Max is 100KB";
				exit;
			}
			
			$image_properties = getimagesize($_FILES['sbtd_pix']['tmp_name']);
			if (!is_array($image_properties))
			{
				echo 'Select file of JPEG type to upload for credential'; exit;
			}

			if ($image_properties["mime"] <> 'image/jpg' && $image_properties["mime"]  <> 'image/jpeg' && $image_properties["mime"]  <> 'image/pjpeg')
			{
				echo 'Select file of JPEG type to upload for credential'; exit;
			}

			$target_file = basename($_FILES["sbtd_pix"]["name"]); 
			$file_name_ext = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			if ($file_name_ext <> 'jpg' && $file_name_ext  <> 'jpeg' && $file_name_ext  <> 'pjpeg')
			{
				echo 'Select file of JPEG type to upload for credential'; exit;
			}

			$file_name_ext = '.'.$file_name_ext;  

			delete_cert_file();

			
			
			//move file file to system temp folder
			if (!move_uploaded_file($_FILES['sbtd_pix']['tmp_name'], BASE_FILE_NAME_FOR_PP . $_FILES['sbtd_pix']['name']))
			{
				echo  "Upload failed, please try again"; exit;
			}
			
			$token = openssl_random_pseudo_bytes(6);
			$token = bin2hex($token);
			
			//prepare new temp file name
			$flname = BASE_FILE_NAME_FOR_PP.$_REQUEST["cQualCodeId"]."_".addslashes($_REQUEST["vExamNo"])."_".$token.$file_name_ext;

			//rename/copy file to perm folder
			rename(BASE_FILE_NAME_FOR_PP . $_FILES['sbtd_pix']['name'], $flname);
			chmod($flname, 0755);		
	
			$stmt = $mysqli->prepare("DELETE FROM pics WHERE vApplicationNo = ? AND cinfo_type = 'C' AND cQualCodeId = ? AND vExamNo = ?");
			$stmt->bind_param("sss", $_REQUEST["vApplicationNo"], $_REQUEST['hdcQualCodeId'], $_REQUEST['hdvExamNo']);
			$stmt->execute();
			$stmt->close();
	
			$stmt = $mysqli->prepare("REPLACE INTO pics (vApplicationNo, vmask, cinfo_type, cQualCodeId, vExamNo) VALUES (?, ?, 'C', ?, ?)");
			$stmt->bind_param("ssss", $_REQUEST["vApplicationNo"], $token, $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo']);
			$stmt->execute();
			$stmt->close();					
		}
	
		$stmt = $mysqli->prepare("DELETE FROM applyqual WHERE vApplicationNo = ? and cQualCodeId = ? and vExamNo = ?");
		$stmt->bind_param("sss", $_REQUEST['vApplicationNo'], $_REQUEST['hdcQualCodeId'], $_REQUEST['hdvExamNo']);
		$stmt->execute();
		$stmt->close();
	
		$stmt = $mysqli->prepare("DELETE FROM applyqual WHERE vApplicationNo = ? and cQualCodeId = ? and vExamNo = ?");
		$stmt->bind_param("sss", $_REQUEST['vApplicationNo'], $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo']);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare("REPLACE INTO applyqual (vApplicationNo, cQualCodeId, cEduCtgId, vExamNo, vExamSchoolName, vcard_pin, vcard_sn, cExamMthYear) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssssssss", $_REQUEST['vApplicationNo'], $_REQUEST['cQualCodeId'], $_REQUEST['cEduCtgId_qual'], $_REQUEST['vExamNo'], $_REQUEST['vExamSchoolName'], $_REQUEST['vcard_pin'], $_REQUEST['vcard_sn'], $_REQUEST['cExamMthYear']);
		$stmt->execute();
		$stmt->close();
	
		
		$stmt = $mysqli->prepare("DELETE FROM afnqualsubject WHERE vApplicationNo = ? and cQualCodeId = ? and vExamNo = ?");
		$stmt->bind_param("sss", $_REQUEST['vApplicationNo'], $_REQUEST['hdcQualCodeId'], $_REQUEST['hdvExamNo']);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare("DELETE FROM afnqualsubject WHERE vApplicationNo = ? and cQualCodeId = ? and vExamNo = ?");
		$stmt->bind_param("sss", $_REQUEST['vApplicationNo'], $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo']);
		$stmt->execute();
		$stmt->close();
		
		$stmt = $mysqli->prepare("DELETE FROM applysubject WHERE vApplicationNo = ? and cQualCodeId = ? and vExamNo = ?");
		$stmt->bind_param("sss", $_REQUEST['vApplicationNo'], $_REQUEST['hdcQualCodeId'], $_REQUEST['hdvExamNo']);
		$stmt->execute();
		$stmt->close();
		
		$stmt = $mysqli->prepare("DELETE FROM applysubject WHERE vApplicationNo = ? and cQualCodeId = ? and vExamNo = ?");
		$stmt->bind_param("sss", $_REQUEST['vApplicationNo'], $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo']);
		$stmt->execute();
		$stmt->close();
		
		
		$stmt = $mysqli->prepare("UPDATE prog_choice SET cFacultyId = '',
		cProgrammeId = '',
		cReqmtId = 0,
		iBeginLevel = 0,
		vProcessNote = '',
		cSCrnd = '',
		cqualfd = '',
		iprnltr = 0 
		WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare("UPDATE prog_choice_pg 
		SET cSCrnd = '0',
		date_cSCrnd = NOW()
		WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->close();
		
		if (isset($_REQUEST["iQSLCount"]) && $_REQUEST["iQSLCount"] == 9)
		{
			$subject = "subject1";
			$grade = "grade1";
		}else if (isset($_REQUEST["iQSLCount"]) && $_REQUEST["iQSLCount"] == 4)
		{
			$subject = "subject2";
			$grade = "grade2";
		}else
		{
			$subject = "subject3";
			$grade = "grade3";
		}

		$stmt1 = $mysqli->prepare("REPLACE INTO applysubject (vApplicationNo, cQualCodeId, vExamNo, cQualSubjectId, cQualGradeId) VALUES (?, ?, ?, ?, ?)");

		$stmt2 = $mysqli->prepare("SELECT iQualGradeRank FROM qualgrade WHERE cQualGradeId = ?");

		$stmt3 = $mysqli->prepare("REPLACE INTO afnqualsubject (vApplicationNo, cEduCtgId, cQualCodeId, vExamNo, cExamMthYear, cNouSubjectId, cNouGradeId, iGradeRank) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		
		$iQSLCount = 0;
		if (isset($_REQUEST["iQSLCount"]))
		{
			$iQSLCount = $_REQUEST["iQSLCount"];
		}

		for ($t = 1; $t <= $iQSLCount; $t++)
		{
			if (isset($_REQUEST[$subject.$t]) && $_REQUEST[$subject.$t] <> '' && isset($_REQUEST[$grade.$t]) && $_REQUEST[$grade.$t] <> '')
			{		
				$stmt1->bind_param("sssss", $_REQUEST['vApplicationNo'], $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo'], $_REQUEST[$subject.$t], $_REQUEST[$grade.$t]);
				$stmt1->execute();

				$stmt2->bind_param("s",$_REQUEST[$grade.$t]);
				$stmt2->execute();
				$stmt2->store_result();
				$stmt2->bind_result($iQualGradeRank);
				if($stmt2->num_rows === 0){continue;};
				$stmt2->fetch();

				$stmt3->bind_param("sssssssi",$_REQUEST["vApplicationNo"], $_REQUEST["cEduCtgId_qual"], $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo'], $_REQUEST['cExamMthYear'], $_REQUEST[$subject.$t], $_REQUEST[$grade.$t], $iQualGradeRank);
				$stmt3->execute();
			}
			log_actv('Saved subject area of academic qualification');
		}
		$stmt1->close();
		$stmt2->close();
		$stmt3->close();
	
		log_actv('Saved academic qualification for '.$_REQUEST["vApplicationNo"]);
	
		//$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
		
		echo "Success";
	// }catch(Exception $e)
	// {
	//   $mysqli->rollback(); //remove all queries from queue if error (undo)
	//   throw $e;
	// }
}?>
