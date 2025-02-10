<?php
require_once('../../fsher/fisher.php');
include('const_def.php');
require_once('lib_fn.php');

$msg = '';
$err_num = 0;
$str = '';
if (isset($_REQUEST['save']) && $_REQUEST['save'] == '1')
{	
	$mysqli = link_connect_db();

	try
	{
		$mysqli->autocommit(FALSE);

		if (isset($_FILES['sbtd_pix']) && isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] <> '' && $_FILES['sbtd_pix']['tmp_name'] <> '' && 
		!($_FILES['sbtd_pix']['error'] == 4 || ($_FILES['sbtd_pix']['size'] == 0 && $_FILES['sbtd_pix']['error'] == 0)))
		{
			$file_name_ext = '';

			$image_properties = getimagesize($_FILES['sbtd_pix']['tmp_name']);
			if (!is_array($image_properties))
			{
				echo 'Select file of JPG type to upload for passport'; exit;
			}

			//if ($image_properties["mime"] <> 'image/jpg' && $image_properties["mime"]  <> 'image/jpeg' && $image_properties["mime"]  <> 'image/pjpeg')
			if ($image_properties["mime"] <> 'image/jpeg')
			{
				echo 'Select file of JPG type to upload for passport'.$image_properties["mime"]; exit;
			}
			
			
			$target_file = basename($_FILES["sbtd_pix"]["name"]); 
			$file_name_ext = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			//if ($file_name_ext <> 'jpg' && $file_name_ext  <> 'jpeg' && $file_name_ext  <> 'pjpeg')
			// if ($file_name_ext <> 'jpg')
			// {
			// 	echo 'Only JPG type file is allowed for passport picture'; exit;
			// }
			
			if ($_FILES["sbtd_pix"]["size"] > 100000)
			{
				echo '100KB exceeded for passport picture'; exit;
			}


			$vmask = '';

			delete_pp_file();
			
			if (!move_uploaded_file($_FILES['sbtd_pix']['tmp_name'], BASE_FILE_NAME_FOR_PP . $_FILES['sbtd_pix']['name']))
			{
				echo  "Upload failed, please try again"; exit;
			}

			$token = openssl_random_pseudo_bytes(6);
			$token = bin2hex($token);

			$new_file_name = BASE_FILE_NAME_FOR_PP."p_" . $token.".".$file_name_ext;

			rename(BASE_FILE_NAME_FOR_PP . $_FILES['sbtd_pix']['name'], $new_file_name);
			chmod($new_file_name, 0755);

			$stmt = $mysqli->prepare("REPLACE INTO pics
			SET vApplicationNo = ?, 
			vmask = '$token', 
			cinfo_type = 'p', 
			vExamNo = '', 
			cQualCodeId = ''");
			$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
			$stmt->execute();
		}

		$orgsetins = settns();

		$stmt = $mysqli->prepare("SELECT *  FROM pers_info WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->store_result();

		$a = addslashes(trim($_REQUEST["vLastName"]));
		$b = addslashes(trim($_REQUEST["vFirstName"]));
		$c = addslashes(trim($_REQUEST["vOtherName"]));

		if ($stmt->num_rows() > 0)
		{
			$stmt = $mysqli->prepare("UPDATE pers_info
			SET vTitle = ?,
			vLastName= ?,
			vFirstName =?,
			vOtherName = ?,
			cGender = ?,
			cnin = ?,
			cAcademicDesc = '".$orgsetins['cAcademicDesc']."'
			WHERE vApplicationNo = ?");
			$stmt->bind_param("sssssss",
			$_REQUEST["vTitle"], 
			$a, 
			$b, 
			$c,
			$_REQUEST["cGender"],
			$_REQUEST["cnin"],
			$_REQUEST["vApplicationNo"]);
			$stmt->execute();
		}else
		{
			$stmt = $mysqli->prepare("REPLACE INTO pers_info
			set vApplicationNo = ?,
			vTitle = ?,
			vLastName= ?,
			vFirstName =?,
			vOtherName = ?,
			cGender = ?,
			cnin = ?,
			dBirthDate = ?,
			cAcademicDesc = '".$orgsetins['cAcademicDesc']."'");
			$stmt->bind_param("ssssssss", $_REQUEST["vApplicationNo"], 
			$_REQUEST["vTitle"], 
			$a, 
			$b, 
			$c,
			$_REQUEST["cGender"],
			$_REQUEST["cnin"],
			$_REQUEST["dBirthDate"]);
			$stmt->execute();
		}

		log_actv('Saved personal_1 information');

		$stmt = $mysqli->prepare("UPDATE prog_choice SET cSbmtd = '0' WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST['vApplicationNo']);
		$stmt->execute();
		

		$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

		$stmt->close();
		echo "success"; exit;
		
		//echo BASE_FILE_NAME_FOR_PP. "p_" . $_REQUEST['vApplicationNo'].$file_name_ext." success"; exit;
	}catch(Exception $e)
	{
	  $mysqli->rollback(); //remove all queries from queue if error (undo)
	  throw $e;
	}
}?>