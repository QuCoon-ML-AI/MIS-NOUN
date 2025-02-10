<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');
include('const_def.php');

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
$cSbmtd_01 = '';
$cProgrammeId_01 = '';
$vObtQualTitle_01 = '';
$vProgrammeDesc_0 = '';
$vLastName_01 = '';
$vFirstName_01 = '';
$vOtherName_01 = '';
$cStudyCenterId = '';
$vCityName = '';


$cSbmtd_02 = '';
$cFacultyId_03 = '';
$iBeginLevel_02 = '';
$cProgrammeId_02 = '';
$vObtQualTitle_02 = '';
$vProgrammeDesc_02 = '';
$vLastName_02 = '';
$vFirstName_02 = '';
$vOtherName_02 = '';
$cStudyCenterId = '';

$token = '';
$hint = '';

if (isset($_REQUEST['ilin']) && isset($_REQUEST['whattodo']))
{
	$mask = get_mask($_REQUEST["uvApplicationNo"]);

    if (!isset($_REQUEST['conf']))
	{		
		$feed_back_message = '';
		if ((isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == '0'))
		{
			$stmt = $mysqli->prepare("SELECT * FROM prog_choice WHERE vApplicationNo = ?");
			$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
			$stmt->execute();
			$stmt->store_result();
			
			if ($stmt->num_rows == 0)
			{
				//echo '*Invalid application form number';exit;
				echo '*Match not found';exit;
			}
			$stmt->close();
			
			$stmt = $mysqli->prepare("SELECT a.cSbmtd, a.cFacultyId, e.vFacultyDesc, f.vdeptDesc, a.iBeginLevel, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, a.vLastName, a.vFirstName, a.vOtherName, a.cStudyCenterId, b.cEduCtgId
			FROM prog_choice a, programme b, obtainablequal c, faculty e, depts f 
			WHERE a.cProgrammeId = b.cProgrammeId
			AND b.cObtQualId = c.cObtQualId
			AND a.cFacultyId = e.cFacultyId
			AND b.cdeptId = f.cdeptId
			AND a.vApplicationNo = ?");
			$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($cSbmtd_02, $cFacultyId_03, $vFacultyDesc, $vdeptDesc, $iBeginLevel_02, $cProgrammeId_02, $vObtQualTitle_02, $vProgrammeDesc_02, $vLastName_02, $vFirstName_02, $vOtherName_02, $cStudyCenterId, $cEduCtgId);
			$stmt->fetch();
			$stmt->close();
			
			if (is_null($cStudyCenterId))
			{
				$cStudyCenterId = '';
			}

			if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
			{
				echo '*Your study centre does not match that of the candidate<br>Direct candidate to his/her study centre for required actions';exit;
			}

			if ($cSbmtd_02 == '0')
			{
				echo '*Form not yet submitted. Candidate may go and choose programme of choice';exit;
			}

			if ($cSbmtd_02 == '2')
			{
				//echo '*Candidate already has matriculation number.<br>Programme cannot be changed on the application form';exit;
			}

			if ($_REQUEST['mm'] == 8 && $vObtQualTitle_02 <> 'M. Phil.,' && $vObtQualTitle_02 <> 'Ph.D.,')
			{
				echo '*Application form number must be that of an M. Phil. or Ph.D. candidate'; exit;
			}else if ($_REQUEST['mm'] == 1 && ($vObtQualTitle_02 == 'M. Phil.,' || $vObtQualTitle_02 == 'Ph.D.,'))
			{
				echo '*Application form number must be that of an undergraduate, PGD or Masters candidate'; exit;
			}else if ($_REQUEST['sRoleID'] == 29 && is_bool(strpos($cProgrammeId_02, 'CHD')))
			{
				echo 'Application form number must be that of a certificate candidate in CHRD'; exit;
			}else if ($_REQUEST['sRoleID'] == 26 && is_bool(strpos($cProgrammeId_02, 'DEG')))
			{
				echo 'Application form number must be that of a certificate candidate in DE&GS';exit;
			}

			$vCityName = '';
			$stmt_cent = $mysqli->prepare("SELECT vCityName
			FROM prog_choice a, studycenter b
			WHERE a.cStudyCenterId = b.cStudyCenterId
			AND a.vApplicationNo = ?");
			$stmt_cent->bind_param("s", $_REQUEST["uvApplicationNo"]);
			$stmt_cent->execute();
			$stmt_cent->store_result();
			$stmt_cent->bind_result($vCityName);
			$stmt_cent->fetch();
			$stmt_cent->close();

			if (isset($vLastName_02) && $vLastName_02 <> '')
			{
				if (!is_bool(strpos($vProgrammeDesc_02,"(d)")))
				{
					$vProgrammeDesc_02 = substr($vProgrammeDesc_02, 0, strlen($vProgrammeDesc_02)-4);
				}

				$pix_mask = get_pp_pix($_REQUEST["uvApplicationNo"]);

				$pix_mask = $pix_mask ?? '';
				
				$study_mode_02 = '';
				
				$who_is_this = str_pad($vLastName_02, 100).
				str_pad($vFirstName_02, 100).
				str_pad($vOtherName_02, 100).
				str_pad($vObtQualTitle_02, 100).
				str_pad($vProgrammeDesc_02, 100).
				str_pad($iBeginLevel_02, 100).
				str_pad(strtoupper($study_mode_02), 100).
				str_pad($vCityName, 100).
				str_pad(strtolower($cFacultyId_03), 100).
				str_pad($vFacultyDesc, 100).
				str_pad($vdeptDesc, 100).
				str_pad($cProgrammeId_02, 100).
				str_pad($cEduCtgId, 100).
				str_pad($cStudyCenterId, 100).
				str_pad($pix_mask, 100);
			}
			
			if ($_REQUEST['process_step'] == '2')
			{
				$feed_back_message = 'Are you sure you want to change candidate\'s programme?';
			}
		}else if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == '1')
		{
			$stmt = $mysqli->prepare("SELECT f.vApplicationNo, f.cFacultyId, h.vFacultyDesc, i.vdeptDesc, f.iStudy_level, f.tSemester, f.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, f.vLastName, f.vFirstName, f.vOtherName, f.cStudyCenterId, g.vCityName, b.cEduCtgId  
			FROM programme b, obtainablequal c, afnmatric e, s_m_t f, studycenter g, faculty h, depts i
			WHERE f.cProgrammeId = b.cProgrammeId  
			AND b.cObtQualId = c.cObtQualId
			AND e.vMatricNo = f.vMatricNo 
			AND f.cStudyCenterId = g.cStudyCenterId
			AND f.cFacultyId = h.cFacultyId
			AND b.cdeptId = i.cdeptId
			AND e.vMatricNo = ?");
			$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($vApplicationNo_01, $cfacultyId_01, $vFacultyDesc, $vdeptDesc, $iStudy_level_01, $tSemester_01, $cProgrammeId_01, $vObtQualTitle_01, $vProgrammeDesc_01, $vLastName_01, $vFirstName_01, $vOtherName_01, $cStudyCenterId, $vCityName, $cEduCtgId);
			if ($stmt->num_rows === 0 && check_grad_student($_REQUEST["uvApplicationNo"]) == 0)
			{	
				$stmt->close();
				echo '*Matriculation number invalid or yet to sign-up';exit;
			}
			
			$stmt->fetch();

			$currentDate = date('Y-m-d');
                    
			if ($iStudy_level_01 <= 200)
			{
				$set_date = substr($orgsetins['drp_examdate'],4,4).'-'.substr($orgsetins['drp_examdate'],2,2).'-'.substr($orgsetins['drp_examdate'],0,2);
			}else
			{
				$set_date = substr($orgsetins['drp_exam_2date'],4,4).'-'.substr($orgsetins['drp_exam_2date'],2,2).'-'.substr($orgsetins['drp_exam_2date'],0,2);
			}

			if ($currentDate > $set_date)
			{
				echo '*Changing of programme has closed';
				exit;
			}

			$vApplicationNo_01 = $vApplicationNo_01.'+';
			
			if (!is_bool(strpos($vProgrammeDesc_01,"(d)")))
			{
				$vProgrammeDesc_01 = substr($vProgrammeDesc_01, 0, strlen($vProgrammeDesc_01)-4);
			}

			$pix_mask = get_pp_pix($_REQUEST["uvApplicationNo"]);
			if (is_null($pix_mask))
			{
				$pix_mask = '';
			}
			//$pix_mask = $pix_mask ?? '';
			
			$who_is_this = str_pad($vApplicationNo_01, 100).
			str_pad($vLastName_01, 100).
			str_pad($vFirstName_01, 100).
			str_pad($vOtherName_01, 100).
			str_pad($vObtQualTitle_01, 100).
			str_pad($vProgrammeDesc_01, 100).
			str_pad($iStudy_level_01, 100).
			str_pad($tSemester_01, 100).
			str_pad($vCityName, 100).
			str_pad(strtolower($cfacultyId_01), 100).
			str_pad($vFacultyDesc, 100).
			str_pad($vdeptDesc, 100).
			str_pad($cProgrammeId_01, 100).
			str_pad($cEduCtgId, 100).
			str_pad($cStudyCenterId, 100).
			str_pad($pix_mask, 100);
			$stmt->close();
			
			if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
			{
				echo '*Your study centre does not match that of the student<br>Direct student to his/her study centre for required action';exit;
			}

			if ($_REQUEST['mm'] == 8 && $cEduCtgId <> 'PGX' && $cEduCtgId <> 'PGY' && $cEduCtgId <> 'PGZ' && $cEduCtgId <> 'PRX')
			{
				echo '*Matriculaton number must be that of an M. Phil. or Ph.D. student'; exit;
			}else if ($_REQUEST['mm'] == 1 && ($cEduCtgId == 'PGZ' || $cEduCtgId == 'PRX'))
			{
				echo '*Matriculaton number must be that of an undergraduate, PGD or Masters student'; exit;
			}else if ($_REQUEST['sRoleID'] == 29 && is_bool(strpos($cProgrammeId_01, 'CHD')))
			{
				echo '*Matriculaton number must be that of a certificate candidate in CHRD'; exit;
			}else if ($_REQUEST['sRoleID'] == 26 && is_bool(strpos($cProgrammeId_01, 'DEG')))
			{
				echo '*Matriculaton number must be that of a certificate candidate in DE&GS';exit;
			}

			if (check_grad_student($_REQUEST["uvApplicationNo"]) == 1)
			{
				echo '*Matriculation number graduated';exit;
			}

			// $stmt = $mysqli->prepare("SELECT * FROM student_request_log_1 WHERE prog_req = '1' AND req_granted = '0' AND (prog_req_date >= '' AND prog_req_date <= '') AND vMatricNo = ?");
			// $stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
			// $stmt->execute();
			// $stmt->store_result();

			// if ($stmt->num_rows == 0)
			// {
			// 	echo '*Student did not request for a change of programme';exit;
			// }

			//$stmt->close();
			
			if ($_REQUEST['process_step'] == '2')
			{
				$feed_back_message = 'Are you sure you want to change student\'s programme?';
			}
		}

		if ($_REQUEST['process_step'] == '1')
		{
			echo $who_is_this;exit;
		}

		// if ($_REQUEST['process_step'] == '2')
		// {
		// 	$token = send_token('change of programme','0');
		// 	echo $token.$feed_back_message;exit;
		// }

		echo $feed_back_message;exit;
	}else if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1')
    {		
		// $token_status = validate_token($_REQUEST["uvApplicationNo"], 'change of programme');
    
		// if ($token_status <> 'Token valid')
		// {
		// 	echo $token_status;
		// 	exit;
		// }

		$new_fac = strtolower($_REQUEST['cFacultyIdold']);
		
		try
        {
            $mysqli->autocommit(FALSE); //turn on transactions	
     
			if ($_REQUEST['id_no'] == '0')
			{
				$stmt = $mysqli->prepare("SELECT cFacultyId FROM prog_choice WHERE vApplicationNo = ?");
				$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($cFacultyId_03);
				$stmt->fetch();
				
				$stmt = $mysqli->prepare("SELECT a.vMatricNo FROM rs_client a, afnmatric b 
				WHERE a.vMatricNo = b.vMatricNo
				AND b.vApplicationNo = ?
				AND a.vPassword <> 'frsh'");
				$stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($vMatricNo_02);
				$stmt->fetch();
				if ($stmt->num_rows > 0)
				{
					$hint = "<br>Candidate's record must also be updated under his/her matriculation number, ".$vMatricNo_02;
				}
				$stmt->close();
				
				$stmt = $mysqli->prepare("UPDATE prog_choice 
				SET cFacultyId = ?,
				cProgrammeId = ?, 
				iBeginLevel = ?
				WHERE vApplicationNo = ?");
				$stmt->bind_param("ssis", $_REQUEST['cFacultyIdold'], $_REQUEST['cprogrammeIdold'], $_REQUEST['courseLevel'], $_REQUEST["uvApplicationNo"]); 
				$stmt->execute();

				//do_faculty_tableser($_REQUEST['cFacultyIdold']);
				// $stmt = $mysqli->prepare("REPLACE INTO prog_choice_$new_fac select * from pers_info
				// WHERE vApplicationNo = ?");
				// $stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
				// $stmt->execute();

				$stmt->close();

				move_docs($mask, $cFacultyId_03);
			}else if ($_REQUEST['id_no'] == '1')
			{
				
				$stmt = $mysqli->prepare("SELECT cFacultyId FROM s_m_t WHERE vMatricNo = ?");
				$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($cFacultyId_03);
				$stmt->fetch();

				$stmt = $mysqli->prepare("select cObtQualId from programme
				where cProgrammeId = ?");
				$stmt->bind_param("s", $_REQUEST['cprogrammeIdold']); 
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($cObtQualId);				
				$stmt->fetch();				
				$stmt->close();
				
				$stmt = $mysqli->prepare("UPDATE s_m_t
				SET cFacultyId = ?,						
				cdeptId = ?,
				cProgrammeId = ?, 
				cObtQualId = '$cObtQualId',
				iBegin_level = ?,
				iStudy_level = ? 
				WHERE vMatricNo = ?");
				$stmt->bind_param("sssiis", $_REQUEST['cFacultyIdold'], $_REQUEST['cdeptold'], $_REQUEST['cprogrammeIdold'], $_REQUEST['courseLevel'], $_REQUEST['courseLevel'], $_REQUEST["uvApplicationNo"]); 
				$stmt->execute();
				$stmt->close();

				$stmt = $mysqli->prepare("REPLACE INTO student_request_log_1 
				SET coldprog = ?,
				cnewprog = ?, 
				vMatricNo = ?");
				$stmt->bind_param("sss", $_REQUEST['cprogrammeIdold'], $_REQUEST['programme_now'], $_REQUEST["uvApplicationNo"]); 
				$stmt->execute();

				//do_faculty_tables
				// $stmt = $mysqli->prepare("REPLACE INTO s_m_t_$new_fac select * from s_m_t
				// WHERE vApplicationNo = ?");
				// $stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
				// $stmt->execute();

				$stmt->close();
			}

			move_docs($mask, $cFacultyId_03);

			log_actv('Changed programme for '.$_REQUEST["uvApplicationNo"]);
			
			//send_app_alert();

            $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

			echo 'Programme successfully changed'.$hint;
        }catch(Exception $e) 
        {
            $mysqli->rollback(); //remove all queries from queue if error (undo)
            throw $e;
        }
    }
}


function move_docs($mask, $old_fac)
{
	$mysqli = link_connect_db();

	if (is_null($old_fac))
	{
		$old_fac = '';
	}

	$old_fac = strtolower($old_fac);
	$new_fac = strtolower($_REQUEST['cFacultyIdold']);
			
	$new_location = BASE_FILE_NAME_FOR_PP.strtolower($new_fac)."/pp/p_".$mask.".jpg";
	$old_location = BASE_FILE_NAME_FOR_PP.strtolower($old_fac)."/pp/p_".$mask.".jpg";
	
	
	if (@copy($old_location, $new_location))
	{
		@unlink($old_location);
	}

	$vApplicationNo_03 = '';

	if ($_REQUEST['id_no'] == '0')
	{
		$stmt = $mysqli->prepare("SELECT cQualCodeId, vExamNo FROM applyqual WHERE vApplicationNo = ?");
	}else
	{
		$stmt = $mysqli->prepare("SELECT vApplicationNo FROM s_m_t WHERE vMatricNo = ?");
		$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($vApplicationNo_03);
		$stmt->fetch();
		
		$stmt = $mysqli->prepare("SELECT cQualCodeId, vExamNo FROM applyqual_stff WHERE vMatricNo = ?");
	}

	$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cQualCodeId, $vExamNo);

	while($stmt->fetch())
	{
		if ($_REQUEST['id_no'] == '0')
		{
			$mask = get_mask_for_certs($_REQUEST["uvApplicationNo"], $cQualCodeId, $vExamNo);
		}else
		{			
			$mask = get_mask_for_certs($vApplicationNo_03, $cQualCodeId, $vExamNo);
		}
		
		
		$new_location = BASE_FILE_NAME_FOR_PP.strtolower($new_fac)."/cc/".$cQualCodeId."_".$vExamNo."_".$mask.".jpg";
		$old_location = BASE_FILE_NAME_FOR_PP.strtolower($old_fac)."/cc/".$cQualCodeId."_".$vExamNo."_".$mask.".jpg";
		
		if (@copy($old_location, $new_location))
		{
			@unlink($old_location);
		}
	}

	$mask_bc = get_mask_for_b_certs($_REQUEST["uvApplicationNo"]);
	$new_location = "../ext_docs/g_bc/".strtolower($new_fac)."/bc_".$mask_bc.".pdf";
	$old_location = "../ext_docs/g_bc/".strtolower($old_fac)."/bc_".$mask_bc.".pdf";
	if (@copy($old_location, $new_location))
	{
		@unlink($old_location);
	}

	if ($_REQUEST['id_no'] == '0')
	{
		$stmt = $mysqli->prepare("REPLACE INTO a_fac 
		SET vappNo = ?,
		cfacultyId = ?");
	}else
	{
		$stmt = $mysqli->prepare("REPLACE INTO s_fac 
		SET vMatricNo = ?,
		cfacultyId = ?");
	}
	$stmt->bind_param("ss", $_REQUEST["vApplicationNo"], $new_fac);
	$stmt->execute();

	$stmt->close();
}