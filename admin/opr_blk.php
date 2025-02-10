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

if (isset($_REQUEST['ilin']) && isset($_REQUEST['whattodo']))
{
	if ($_REQUEST['mm'] == '1' || $_REQUEST['mm'] == 8){$blksource = "regist  = '1', stdycentre = '0', ictech  = '0'";}
	else if ($_REQUEST['mm'] == '2'){$blksource = "regist  = '0', stdycentre = '1', ictech  = '0'";}
	else {$blksource = "regist  = '0', stdycentre = '0', ictech  = '1'";}

	
	$stmt = $mysqli->prepare("SELECT cblk, regist, stdycentre, ictech, act_date, period1, rect_risn 
	FROM rectional WHERE vMatricNo = ? 
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
	}
	$stmt->close();	

    if (!isset($_REQUEST['conf']))
	{
		if (isset($_REQUEST["uvApplicationNo"]))
		{
			if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == '0')
			{
				$stmt = $mysqli->prepare("SELECT * FROM prog_choice WHERE vApplicationNo = ?");
				$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				
				if ($stmt->num_rows == 0)
				{
					//echo 'Invalid application form number';exit;
					echo 'Match not found';exit;
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
					echo 'Your study centre does not match that of the candidate<br>Direct candidate to his/her study centre for required actions';exit;
				}

				if ($cSbmtd_02 == '0' && $_REQUEST['sm'] == 3)
				{
					$stmt->close();
					echo 'Form not yet submitted';exit;
				}
				
				if ($_REQUEST['mm'] == 8 && $cProgrammeId_02 <> 'PGX' && $cProgrammeId_02 <> 'PGY' && $cProgrammeId_02 <> 'PGZ' && $cProgrammeId_02 <> 'PRX')
				{
					echo 'Application form number must be that of an MPhil or PhD candidate'; exit;
				}else if ($_REQUEST['mm'] == 1 && ($cProgrammeId_02 == 'PGZ' || $cProgrammeId_02 == 'PRX'))
				{
					echo 'Application form number must be that of an undergraduate, PGD or Masters candidate'; exit;
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
					$mask = get_mask($_REQUEST["uvApplicationNo"]);

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
				

				if ($cblk == '1')
				{
					echo $who_is_this.'Application form already blocked at the <b>'.$blksource_name.'</b>. <br> on <br>'.formatdate(substr($act_date,0,10),'fromdb').' '.substr($act_date,11,8).'<br>'.$rect_risn;exit;
				}

				echo $who_is_this.'Block application form?';exit;
			}else if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == '1')
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
					echo 'Your study centre does not match that of the student<br>Direct student to his/her study centre for required action';exit;
				}		

				if ($_REQUEST['mm'] == 8 && $cProgrammeId_01 <> 'PGX' && $cProgrammeId_01 <> 'PGY' && $cProgrammeId_01 <> 'PGZ' && $cProgrammeId_01 <> 'PRX')
				{
					echo 'Application form number must be that of an MPhil or PhD candidate'; exit;
				}else if ($_REQUEST['mm'] == 1 && ($cProgrammeId_01 == 'PGZ' || $cProgrammeId_01 == 'PRX'))
				{
					echo 'Application form number must be that of an undergraduate, PGD or Masters candidate'; exit;
				}else if ($_REQUEST['sRoleID'] == 29 && is_bool(strpos($cProgrammeId_01, 'CHD')))
				{
					echo '*Application form number must be that of a certificate candidate in CHRD'; exit;
				}else if ($_REQUEST['sRoleID'] == 26 && is_bool(strpos($cProgrammeId_01, 'DEG')))
				{
					echo '*Application form number must be that of a certificate candidate in DE&GS';exit;
				}

				$mask = get_mask($_REQUEST["uvApplicationNo"]);

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
				str_pad(strtolower($cfacultyId_01), 100).
				str_pad($mask, 100).'#';
				
				$stmt->close();
				
				if (check_grad_student($_REQUEST["uvApplicationNo"]) == 1)
				{
					echo $who_is_this.'Matriculation number graduated';exit;
				}

				if ($cblk == '1')
				{
					echo $who_is_this.'Matriculation form already blocked at the <b>'.$blksource_name.'</b>. <br> on <br>'.formatdate(substr($act_date,0,10),'fromdb').' '.substr($act_date,11,8).'<br>'.$rect_risn;exit;
				}

				echo $who_is_this.'Block matriculation number?';exit;
			}
		}else if (isset($_REQUEST["bulk_change"]))
		{
			echo 'All listed number will be blocked<br> Continue?';exit;
		}
	}else if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1')
	{
		
		if (isset($_REQUEST["uvApplicationNo"]))
		{
			$stmt = $mysqli->prepare("REPLACE INTO rectional SET act_date = NOW(), cblk = '1', $blksource, period1 = NOW(), vMatricNo = ?, rect_risn = ?");
			$stmt->bind_param("ss", $_REQUEST["uvApplicationNo"], $_REQUEST["rect_risn"]);
			$stmt->execute();
			$stmt->close();
			

			if ($_REQUEST['id_no'] == '0')
			{						
				log_actv('Form blocked for '.$_REQUEST["uvApplicationNo"]);
				echo $who_is_this.'Form blocked successfully';exit;
			}else if ($_REQUEST['id_no'] == '1')
			{				
				log_actv('Access blocked for '.$_REQUEST["uvApplicationNo"]);
				echo $who_is_this.'Matriculation number. blocked successfully';exit;
			}
		}else if (isset($_REQUEST["bulk_change"]))
		{
			$stmt = $mysqli->prepare("INSERT IGNORE INTO rectional SET act_date = NOW(), cblk = '1', $blksource, period1 = NOW(), vMatricNo = ?, rect_risn = ?");
			
			$invalid_afn = '';
			$invalid_afn_count = 0;

			$valid_afn = '';
			$valid_afn_count = 0;

        	$splitLine = explode("\n", str_replace("\r", "", $_REQUEST["bulk_change"]));
			foreach ($splitLine as $val_arr)
			{
				if (!is_bool(strripos($invalid_afn, $val_arr)) || 
				!is_bool(strripos($valid_afn, $val_arr)))
				{
					continue;
				}

				if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == '0')
				{
					$stmt_a = $mysqli->prepare("SELECT * FROM prog_choice WHERE vApplicationNo = ?");
					$stmt_a->bind_param("s", $val_arr);
					$stmt_a->execute();
					$stmt_a->store_result();
				}else if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == '1')
				{
					$stmt_a = $mysqli->prepare("SELECT * FROM s_m_t WHERE vMatricNo = ?");
					$stmt_a->bind_param("s", $val_arr);
					$stmt_a->execute();
					$stmt_a->store_result();
				}

				if (isset($stmt_a))
				{
					if ($stmt_a->num_rows == 0)
					{
						$invalid_afn_count++;
						$invalid_afn .= $invalid_afn_count.'. '.$val_arr.'<br>';
					}else
					{
						$valid_afn_count++;
						$valid_afn .= $valid_afn_count.'. '.$val_arr.'<br>';
					}					

					/*$stmt_b = $mysqli->prepare("SELECT MAX(act_date) FROM rectional WHERE vMatricNo = ? AND cblk = '0'");
					$stmt_b->bind_param("s", $val_arr);
					$stmt_b->execute();
					$stmt_b->store_result();
					$stmt->bind_result($last_date);
					$last_date = $last_date ?? '';
					if ($last_date == 0)
					{*/
						$stmt->bind_param("ss", $val_arr, $_REQUEST["rect_risn"]);
						$stmt->execute();
						log_actv('Blocked '.$val_arr.' for '.$_REQUEST["rect_risn"]);
					//}
				}
			}

			$stmt->close();
			if (isset($stmt_a))
			{
				$stmt_a->close();
				//$stmt_b->close();
			}

			$strng = '';
			if ($invalid_afn <> '')
			{
				$strng = '<b>Invalid numbers </b><br>'.$invalid_afn.'<p>';
			}

			if ($valid_afn <> '')
			{
				$strng .= '<b>Valid numbers </b><br>'.$valid_afn;
			}
			echo $strng;
		}
	}
}?>