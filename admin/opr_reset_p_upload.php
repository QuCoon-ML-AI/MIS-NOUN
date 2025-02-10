<?php
require_once('../../fsher/fisher.php');
include('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

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

$hint = '';

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
				echo '*Invalid application form number';exit;
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
					
			if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
			{
				echo '*Your study centre does not match that of the candidate<br>Direct candidate to his/her study centre for required actions';exit;
			}
			
			if ($_REQUEST['mm'] == 8 && $vObtQualTitle_02 <> 'M. Phil.,' && $vObtQualTitle_02 <> 'Ph.D.,')
			{
				echo '*Application form number must be that of an M. Phil. or Ph.D. candidate'; exit;
			}else if ($_REQUEST['mm'] == 1 && ($vObtQualTitle_02 == 'M. Phil.,' || $vObtQualTitle_02 == 'Ph.D.,'))
			{
				echo '*Application form number must be that of an undergraduate, PGD or Masters candidate'; exit;
			}else if ($_REQUEST['sRoleID'] == 29 && is_bool(strpos($cProgrammeId_02, 'CHD')))
			{
				echo '*Application form number must be that of a certificate candidate in CHRD'; exit;
			}else if ($_REQUEST['sRoleID'] == 26 && is_bool(strpos($cProgrammeId_02, 'DEG')))
			{
				echo '*Application form number must be that of a certificate candidate in DE&GS';exit;
			}

			if ($cSbmtd_02 == '0')
			{
				echo '*Form not yet submitted<br>Candidate may go and upload a valid passport picture';exit;
			}

			if ($cSbmtd_02 == '1' || $cSbmtd_02 == '2')
			{
				echo '*Form already submitted';exit;
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
				$mask = get_mask($_REQUEST["uvApplicationNo"]);

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

			if ($cSbmtd_02 == '2')
			{
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
			}
            
			if (isset($_REQUEST['cancel_perm']))
            {
                $feed_back_message = 'Are you sure you want to cancel the reseting of candidate\'s passport upload chance?';
            }else if ($_REQUEST['process_step'] == '2')
			{
				$feed_back_message = 'Are you sure you want to reset candidate\'s passport upload chance?';
			}
		}else if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == '1')
		{
			$stmt = $mysqli->prepare("SELECT f.vApplicationNo, f.cFacultyId, h.vFacultyDesc, i.vdeptDesc, f.iStudy_level, f.tSemester, a.cSbmtd, f.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, a.vLastName, a.vFirstName, a.vOtherName, f.cStudyCenterId, g.vCityName, b.cEduCtgId  
			FROM prog_choice a, programme b, obtainablequal c, afnmatric e, s_m_t f, studycenter g, faculty h, depts i
			WHERE f.cProgrammeId = b.cProgrammeId  
			AND b.cObtQualId = c.cObtQualId 
			AND e.vApplicationNo = a.vApplicationNo 
			AND e.vMatricNo = f.vMatricNo 
			AND f.cStudyCenterId = g.cStudyCenterId
			AND f.cFacultyId = h.cFacultyId
			AND b.cdeptId = i.cdeptId
			AND e.vMatricNo = ?");
			$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($vApplicationNo_01, $cfacultyId_01, $vFacultyDesc, $vdeptDesc, $iStudy_level_01, $tSemester_01, $cSbmtd_01, $cProgrammeId_01, $vObtQualTitle_01, $vProgrammeDesc_01, $vLastName_01, $vFirstName_01, $vOtherName_01, $cStudyCenterId, $vCityName, $cEduCtgId);
			if ($stmt->num_rows === 0 && check_grad_student($_REQUEST["uvApplicationNo"]) == 0)
			{	
				$stmt->close();
				echo '*Matriculation number invalid or yet to sign-up';exit;
			}
			
			$stmt->fetch();
			
			if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
			{
				echo '*Your study centre does not match that of the student<br>Direct student to his/her study centre for required action';exit;
			}

			if ($_REQUEST['mm'] == 8 && $vObtQualTitle_01 <> 'M. Phil.,' && $vObtQualTitle_01 <> 'Ph.D.,')
			{
				echo '*Matriculaton number must be that of an M. Phil. or Ph.D. student'; exit;
			}else if ($_REQUEST['mm'] == 1 && ($vObtQualTitle_01 == 'M. Phil.,' || $vObtQualTitle_01 == 'Ph.D.,'))
			{
				echo '*Matriculaton number must be that of an undergraduate, PGD or Masters student'; exit;
			}else if ($_REQUEST['sRoleID'] == 29 && is_bool(strpos($cProgrammeId_01, 'CHD')))
			{
				echo '*Matriculaton number must be that of a certificate student in CHRD'; exit;
			}else if ($_REQUEST['sRoleID'] == 26 && is_bool(strpos($cProgrammeId_01, 'DEG')))
			{
				echo '*Matriculaton number must be that of a certificate student in DE&GS';exit;
			}

			if (check_grad_student($_REQUEST["uvApplicationNo"]) == 1)
			{
				echo '*Matriculation number graduated';exit;
			}

			// $stmt = $mysqli->prepare("SELECT * FROM student_request_log_1 WHERE passport = '1' AND req_granted = '0' AND vMatricNo = ?");
			// $stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
			// $stmt->execute();
			// $stmt->store_result();

			// if ($stmt->num_rows == 0)
			// {
			// 	echo '*Student did not request for reset of passport upload chances';exit;
			// }


			$mask = get_mask($_REQUEST["uvApplicationNo"]);

			$vApplicationNo_01 = $vApplicationNo_01.'+';
			
			if (!is_bool(strpos($vProgrammeDesc_01,"(d)")))
			{
				$vProgrammeDesc_01 = substr($vProgrammeDesc_01, 0, strlen($vProgrammeDesc_01)-4);
			}

			$pix_mask = get_pp_pix($_REQUEST["uvApplicationNo"]);

			$pix_mask = $pix_mask ?? '';
			
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
			
			if (isset($_REQUEST['cancel_perm']))
            {
                $feed_back_message = 'Are you sure you want to cancel the reseting of student\'s passport upload chance?';
            }else if ($_REQUEST['process_step'] == '2')
			{
				$feed_back_message = 'Are you sure you want to reset student\'s passport upload chance?';
			}
		}

		if ($_REQUEST['process_step'] == '1')
		{
			echo $who_is_this;exit;
		}

		// if ($_REQUEST['process_step'] == '2')
		// {
		// 	if (!isset($_REQUEST['cancel_perm']))
        //     {
        //         $token = send_token('reset passport upload chance','0');
        //     }
		// 	echo $token.$feed_back_message;exit;
		// }

		echo $feed_back_message;exit;
	}else if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1')
    {		
		// $token_status = validate_token($_REQUEST["uvApplicationNo"], 'reset passport upload chance');
    
		// if ($token_status <> 'Token valid')
		// {
		// 	echo $token_status;
		// 	exit;
		// }

        try
        {
            $mysqli->autocommit(FALSE); //turn on transactions	
     
			if(isset($_REQUEST["cancel_perm"]))
            {
                $stmt = $mysqli->prepare("UPDATE pics 
                SET upld_passpic_no = 0
                WHERE cinfo_type = 'p'
                AND vApplicationNo = ?");
            }else
            {
                $stmt = $mysqli->prepare("UPDATE pics 
                SET upld_passpic_no = ".$orgsetins['upld_passpic_no']."
                WHERE cinfo_type = 'p'
                AND vApplicationNo = ?");
            }
            $stmt->bind_param("s", $_REQUEST["app_frm_no"]); 
            $stmt->execute();
            $stmt->close();

            if(isset($_REQUEST["cancel_perm"]))
            {
			    log_actv('Canceled passport upload chances for '.$_REQUEST["uvApplicationNo"]);
            }else
            {
                log_actv('Reset passport upload chances for '.$_REQUEST["uvApplicationNo"]);
            }
			
            $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

            if(isset($_REQUEST["cancel_perm"]))
            {
			    echo '*Passport upload reset successfully canceled'.$hint;exit;
            }else
            {
                echo '*Passport upload chances successfully reset'.$hint;exit;
            }
        }catch(Exception $e) 
        {
            $mysqli->rollback(); //remove all queries from queue if error (undo)
            throw $e;
        }
    }
}