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

if (isset($_REQUEST['ilin']) && isset($_REQUEST['whattodo']))
{
    $mask = get_mask($_REQUEST["uvApplicationNo"]);
	
	if (!isset($_REQUEST['conf']))
	{
		$stmt = $mysqli->prepare("SELECT * FROM prog_choice WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
		$stmt->execute();
		$stmt->store_result();
		
		if ($stmt->num_rows == 0)
		{
			echo 'Invalid application form number';exit;
		}
		$stmt->close();


		$stmt = $mysqli->prepare("SELECT a.cSbmtd, a.cFacultyId, a.iBeginLevel, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, a.vLastName, a.vFirstName, a.vOtherName, a.cStudyCenterId, b.cEduCtgId 
		FROM prog_choice a, programme b, obtainablequal c
		WHERE a.cProgrammeId = b.cProgrammeId
		AND b.cObtQualId = c.cObtQualId
		AND a.vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($cSbmtd_02, $cFacultyId_03, $iBeginLevel_02, $cProgrammeId_02, $vObtQualTitle_02, $vProgrammeDesc_02, $vLastName_02, $vFirstName_02, $vOtherName_02, $cStudyCenterId, $cEduCtgId);
		$stmt->fetch();
		
		$cStudyCenterId = $cStudyCenterId ?? '';
				
		if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
		{
			echo 'Your study centre does not match that of the candidate<br>Direct candidate to his/her study centre for required action';exit;
		}

		if ($cSbmtd_02 == '0' && $_REQUEST['sm'] == 3)
		{
			$stmt->close();
			echo 'Form not yet submitted';exit;
		}
		
		if ($_REQUEST['mm'] == 8 && $cEduCtgId <> 'PGX' && $cEduCtgId <> 'PGY' && $cEduCtgId <> 'PGZ' && $cEduCtgId == 'PRX')
		{
			echo 'Application form number must be that of an M. Phil. or Ph.D. candidate'; exit;
		}else if ($_REQUEST['mm'] == 1 && ($cEduCtgId == 'PGX' || $cEduCtgId == 'PGY' || $cEduCtgId == 'PGZ' || $cEduCtgId == 'PRX'))
		{
			echo 'Application form number must be that of an undergraduate candidate'; exit;
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
		
		$vCityName = $vCityName ?? '';
		
		if (isset($vLastName_02) && $vLastName_02 <> '')
		{
			if (!is_bool(strpos($vProgrammeDesc_02,"(d)")))
			{
				$vProgrammeDesc_02 = substr($vProgrammeDesc_02, 0, strlen($vProgrammeDesc_02)-4);
			}
			
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
			str_pad($mask, 100).'#';
		}
		$stmt->close();
					
		$stmt = $mysqli->prepare("SELECT cSbmtd FROM prog_choice WHERE vApplicationNo = ?");
		$stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($cSbmtd_02);
					
		if ($stmt->num_rows === 0)
		{
			$stmt->close();
			echo 'Invalid application form number';exit;
		}
		
		$stmt->fetch();
		$stmt->close();
		if ($cSbmtd_02 == '0')
		{
			echo $who_is_this.'Form not submitted. Only submitted forms can be released';exit;
		}else if ($cSbmtd_02 == '2')
		{
			$stmt = $mysqli->prepare("SELECT a.vMatricNo 
			FROM rs_client a, afnmatric b 
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
				$stmt_crs_reg_check = $mysqli->prepare("SELECT * FROM coursereg_arch WHERE vMatricNo = '$vMatricNo_02'");
				$stmt_crs_reg_check->execute();
				$stmt_crs_reg_check->store_result();
				if ($stmt_crs_reg_check->num_rows > 0)
				{
					$stmt_crs_reg_check->close();
					$stmt->close();
					echo $who_is_this."Candidate has registered courses under the matriculation number, ".$vMatricNo_02. "<br> Form cannot be released.";exit;
				}else
				{
					$stmt_crs_reg_check->close();
					$stmt->close();
					echo $who_is_this."Candidate has been screened<br>Form cannot be released";exit;
					//echo $who_is_this.'Release application form?';exit;
				}
				$stmt_crs_reg_check->close();
			}else
			{
				$stmt->close();
				//echo $who_is_this.'Release application form?';exit;
			}
		}else if ($cSbmtd_02 == '1')
		{
			//echo $who_is_this.'Release application form?';exit;
		}else
		{
			echo 'Form not yet submitted';exit;
		}

		$token = send_token('releasing of form','0');

		if ($token == 'NOUN official email required')
		{
			echo $token; exit;
		}
		echo $who_is_this.'Release application form?';exit;
    }else if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1')
    {
        $token_status = validate_token($_REQUEST["vApplicationNo"], 'releasing of form');
    
		if ($token_status <> 'Token valid')
		{
			echo $token_status;
			exit;
		}
		
		$stmt = $mysqli->prepare("SELECT cFacultyId FROM prog_choice WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($cFacultyId_03);
		$stmt->fetch();

		if ($cFacultyId_03 == '')
		{
			exit;
		}
		
		$stmt = $mysqli->prepare("UPDATE prog_choice SET cSbmtd = '0', release_form = '1' WHERE vApplicationNo = ?");
        $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]); 
        $stmt->execute();
        $stmt->close();

		if ($_REQUEST['mm'] == 8 && ($cEduCtgId == 'PGX' || $cEduCtgId == 'PGY' || $cEduCtgId == 'PRX' || $cEduCtgId == 'PRX'))
		{
			$new_location = BASE_FILE_NAME_FOR_PP."p_".$mask.".jpg";
        
			$old_location = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId_03)."/pp/p_".$mask.".jpg";
			
			exit;
		}


					
        $new_location = BASE_FILE_NAME_FOR_PP."p_".$mask.".jpg";
        
        $old_location = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId_03)."/pp/p_".$mask.".jpg";

		if (file_exists($old_location))
		{
			if (copy($old_location, $new_location))
			{
				@unlink($old_location);
			}
		}else
		{
			$new_location = BASE_FILE_NAME_FOR_PP."p_".$mask.".png";
        
			$old_location = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId_03)."/pp/p_".$mask.".png";
			
			if (file_exists($old_location))
			{
				if (copy($old_location, $new_location))
				{
					@unlink($old_location);
				}
			}
		}       

        $stmt = $mysqli->prepare("SELECT cQualCodeId, vExamNo FROM applyqual WHERE vApplicationNo = ?");
        $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cQualCodeId, $vExamNo);

        while($stmt->fetch())
        {
            $mask = get_mask_for_certs($_REQUEST["uvApplicationNo"], $cQualCodeId, $vExamNo);
			
			$new_location = BASE_FILE_NAME_FOR_PP.$cQualCodeId."_".$vExamNo."_".$mask.".jpg";
                                            
            $old_location = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId_03)."/cc/".$cQualCodeId."_".$vExamNo."_".$mask.".jpg";
			
			if (file_exists($old_location))
			{
				if (copy($old_location, $new_location))
				{
					@unlink($old_location);
				}
			}else
			{
				$new_location = BASE_FILE_NAME_FOR_PP.$cQualCodeId."_".$vExamNo."_".$mask.".png";
				$old_location = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId_03)."/cc/".$cQualCodeId."_".$vExamNo."_".$mask.".png";
				
				if (file_exists($old_location))
				{
					if (copy($old_location, $new_location))
					{
						@unlink($old_location);
					}
				}else
				{
					//do for pdf format
				}
			}
        }
        $stmt->close();
                    
        log_actv('Released form for '.$_REQUEST["uvApplicationNo"]);
        echo $who_is_this.'Form released successfully';exit;
    }
}