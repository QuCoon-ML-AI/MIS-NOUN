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
   
	if ($_REQUEST['mm'] == '1' || $_REQUEST['mm'] == 8){$blksource = "regist  = '1', stdycentre = '0', ictech  = '0'";}
	else if ($_REQUEST['mm'] == '2'){$blksource = "regist  = '0', stdycentre = '1', ictech  = '0'";}
	else {$blksource = "regist  = '0', stdycentre = '0', ictech  = '1'";}
    
    $stmt = $mysqli->prepare("SELECT cblk, regist, stdycentre, ictech, act_date, period1, rect_risn 
    FROM rectional 
    WHERE vMatricNo = ? 
    ORDER by act_date DESC LIMIT 1");
    $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
    
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($cblk, $regist, $stdycentre, $ictech, $act_date, $period1, $rect_risn);
            
    if ($stmt->num_rows > 0)
    {
        $stmt->fetch();
        
        if ($regist == '1'){$blksource_name = ' Registry';}
        else if ($stdycentre == '1'){$blksource_name = ' Study Centre';}
        else if ($ictech == '1'){$blksource_name = ' DMIS';}
    }else 
	{
		$act_date = date("Y-m-d");
	}

    $stmt->close();	

    if (!isset($_REQUEST['conf']))
	{        
        if (isset($_REQUEST["uvApplicationNo"]))
		{
			if ($_REQUEST['id_no'] == '0')
			{
				$stmt = $mysqli->prepare("SELECT * FROM prog_choice WHERE vApplicationNo = ?");
				$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				
				if ($stmt->num_rows == 0)
				{
					//echo 'Invalid application form number';exit;
					echo 'No match found';exit;
				}
				$stmt->close();


				$stmt = $mysqli->prepare("SELECT a.cSbmtd, a.cFacultyId, a.iBeginLevel, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, a.vLastName, a.vFirstName, a.vOtherName, a.cStudyCenterId 
				FROM prog_choice a, programme b, obtainablequal c
				WHERE a.cProgrammeId = b.cProgrammeId
				AND b.cObtQualId = c.cObtQualId
				AND a.vApplicationNo = ?");
				$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($cSbmtd_02, $cFacultyId_03, $iBeginLevel_02, $cProgrammeId_02, $vObtQualTitle_02, $vProgrammeDesc_02, $vLastName_02, $vFirstName_02, $vOtherName_02, $cStudyCenterId);
				$stmt->fetch();
						
				if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
				{
					echo 'Your study centre does not match that of the candidate<br>Direct candidate to his/her study centre for required action';exit;
				}

				if ($cSbmtd_02 == '0' && $_REQUEST['sm'] == 3)
				{
					$stmt->close();
					echo 'Form not yet submitted';exit;
				}
				
				if ($_REQUEST['mm'] == 8 && $vObtQualTitle_02 <> 'M. Phil.,' && $vObtQualTitle_02 <> 'Ph.D.,')
				{
					echo 'Application form number must be that of an M. Phil. or Ph.D. candidate'; exit;
				}else if ($_REQUEST['mm'] == 1 && ($vObtQualTitle_02 == 'M. Phil.,' || $vObtQualTitle_02 == 'Ph.D.,'))
				{
					echo 'Application form number must be that of an undergraduate, PGD or Masters candidate'; exit;
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
					
					$study_mode_02 = '';
					
					$who_is_this = str_pad($vLastName_02, 100).
					str_pad($vFirstName_02, 100).
					str_pad($vOtherName_02, 100).
					str_pad($vObtQualTitle_02, 100).
					str_pad($vProgrammeDesc_02, 100).
					str_pad($iBeginLevel_02, 100).
					str_pad(strtoupper($study_mode_02), 100).
					str_pad($vCityName, 100).
					str_pad(strtolower($cFacultyId_03), 100).'#';
				}

				
				$stmt = $mysqli->prepare("SELECT cblk FROM rectional where vMatricNo = ? order by act_date desc limit 1");
				$stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($cblk_06);
								
				if ($stmt->num_rows > 0)
				{
					$stmt->fetch();
					$stmt->close();
					
					if ($cblk_06 == '0')
					{
						echo $who_is_this.'Application form already unblocked.';exit;
					}else if ($cblk_06 == '1')
					{
						if ($_REQUEST['mm'] <> 1 && $regist == '1')
						{
							echo 'Application form number can only be unblocked from Registry'; exit;
						}else if ($_REQUEST['mm'] <> 3 && $stdycentre == '1')
						{
							echo 'Application form number can only be unblocked at the Study centre'; exit;
						}else if ($_REQUEST['mm'] <> 5 && $ictech == '1')
						{
							echo 'Application form number can only be unblocked at DMIS'; exit;
						}else
						{
							echo $who_is_this.'Unblock application form?';exit;
						}
					}
				}else
				{
					$stmt->close();
					echo $who_is_this.'Unblock application form?';exit;
				}
			}else if ($_REQUEST['id_no'] == '1')
			{
				$stmt = $mysqli->prepare("SELECT a.vApplicationNo, a.cFacultyId, f.iStudy_level, f.tSemester, a.cSbmtd, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, a.vLastName, a.vFirstName, a.vOtherName, f.cStudyCenterId, g.vCityName  
				from prog_choice a, programme b, obtainablequal c, afnmatric e, s_m_t f, studycenter g
				where a.cProgrammeId = b.cProgrammeId  
				AND b.cObtQualId = c.cObtQualId 
				AND e.vApplicationNo = a.vApplicationNo 
				AND e.vMatricNo = f.vMatricNo 
				AND f.cStudyCenterId = g.cStudyCenterId
				AND e.vMatricNo = ?");
				$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($vApplicationNo_01, $cfacultyId_01, $iStudy_level_01, $tSemester_01, $cSbmtd_01, $cProgrammeId_01, $vObtQualTitle_01, $vProgrammeDesc_01, $vLastName_01, $vFirstName_01, $vOtherName_01, $cStudyCenterId, $vCityName);
				if ($stmt->num_rows === 0 && check_grad_student($_REQUEST["uvApplicationNo"]) == 0)
				{	
					$stmt->close();
					echo 'Matriculation number invalid or yet to sign-up';exit;
				}
				
				$stmt->fetch();
				
				if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
				{
					echo 'Your study centre does not match that of the candidate<br>Direct candidate to his/her study centre for required action';exit;
				}


				if ($_REQUEST['mm'] == 8 && $vObtQualTitle_01 <> 'M. Phil.,' && $vObtQualTitle_01 <> 'Ph.D.,')
				{
					echo 'Matriculaton form number must be that of an M. Phil. or Ph.D. student'; exit;
				}else if ($_REQUEST['mm'] == 1 && ($vObtQualTitle_01 == 'M. Phil.,' || $vObtQualTitle_01 == 'Ph.D.,'))
				{
					echo 'Matriculaton form number must be that of an undergraduate, PGD or Masters student'; exit;
				}

				$vApplicationNo_01 = $vApplicationNo_01.'+';
				
				if (!is_bool(strpos($vProgrammeDesc_01,"(d)")))
				{
					$vProgrammeDesc_01 = substr($vProgrammeDesc_01, 0, strlen($vProgrammeDesc_01)-4);
				}
				
				$who_is_this = str_pad($vApplicationNo_01, 100).
				str_pad($vLastName_01, 100).
				str_pad($vFirstName_01, 100).
				str_pad($vOtherName_01, 100).
				str_pad($vObtQualTitle_01, 100).
				str_pad($vProgrammeDesc_01, 100).
				str_pad($iStudy_level_01, 100).
				str_pad($tSemester_01, 100).
				str_pad($vCityName, 100).
				str_pad(strtolower($cfacultyId_01), 100).'#';
				
				$stmt->close();
				
				if (check_grad_student($_REQUEST["uvApplicationNo"]) == 1)
				{
					echo $who_is_this.'Matriculation number graduated';exit;
				}
				
				
				$stmt = $mysqli->prepare("SELECT cblk FROM rectional where vMatricNo = ? order by act_date desc limit 1");
				$stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($cblk_07);
				
				if ($stmt->num_rows > 0)
				{
					$rresult = $stmt->fetch();
					$stmt->close();
					if($cblk_07 == '0')
					{
						echo $who_is_this.'Matriculation number not blocked';exit;
					}else if ($_REQUEST['mm'] <> 1 && $regist == '1')
					{
						echo 'Matriculation number can only be unblocked from Registry'; exit;
					}else if ($_REQUEST['mm'] <> 3 && $stdycentre == '1')
					{
						echo 'Matriculation number can only be unblocked at the Study centre'; exit;
					}else if ($_REQUEST['mm'] <> 5 && $ictech == '1')
					{
						echo 'Matriculation number can only be unblocked at MIS'; exit;
					}else
					{
						echo $who_is_this.'Unblock matriculation number?';exit;
					}
				}else
				{
					$stmt->close();
					echo $who_is_this.'Unblock matriculation number?';exit;
				}
			}
		}else if (isset($_REQUEST["bulk_change"]))
		{
			echo 'All listed number will be unblocked<br> Continue?';exit;
		}
    }else if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1')
    {
        if (isset($_REQUEST["uvApplicationNo"]))
		{
			$stmt = $mysqli->prepare("UPDATE rectional 
			SET act_date = NOW(), 
			cblk = '0', 
			$blksource, 
			period1 = NOW(), 
			rect_risn1 = ?
			WHERE vMatricNo = ? 
			AND act_date = '$act_date' 
			AND cblk = '1'");
			$stmt->bind_param("ss", $_REQUEST["rect_risn"], $_REQUEST["uvApplicationNo"]);
			$stmt->execute();
			$stmt->close();
			
			log_actv('Access unblocked for '.$_REQUEST["uvApplicationNo"]);

			if ($_REQUEST['id_no'] == '0')
			{
				echo $who_is_this.'Form unblocked successfully';exit;
			}else if ($_REQUEST['id_no'] == '1')
			{
				echo $who_is_this.'Matriculation number unblocked successfully';exit;
			}
		}else if (isset($_REQUEST["bulk_change"]))
		{			
			$stmt_a = $mysqli->prepare("SELECT act_date
			FROM rectional 
			WHERE vMatricNo = ? 
			ORDER by act_date DESC LIMIT 1");
			
			$invalid_afn = '';
			$invalid_afn_count = 0;

			$valid_afn = '';
			$valid_afn_count = 0;

        	$splitLine = explode("\n", str_replace("\r", "", $_REQUEST["bulk_change"]));

			$number_of_records_done = 0;
			foreach ($splitLine as $val_arr)
			{
				$matno = trim($val_arr);

				$stmt_a->bind_param("s", $matno);				
				$stmt_a->execute();
				$stmt_a->store_result();
				$stmt_a->bind_result($act_date);
				$stmt_a->fetch();

				if (is_null($act_date))
				{
					$act_date = date("Y-m-d");
				}
	
				$stmt = $mysqli->prepare("UPDATE rectional 
				SET cblk = '0', 
				$blksource, 
				period1 = NOW(), 
				rect_risn1 = ?
				WHERE vMatricNo = ? 
				AND cblk = '1'");
				$stmt->bind_param("ss", $_REQUEST["rect_risn"], $matno);
				$stmt->execute();

				$number_of_records_done += $stmt->affected_rows;
			}

			echo $number_of_records_done . ' records updated successlly';
		}
    }
}