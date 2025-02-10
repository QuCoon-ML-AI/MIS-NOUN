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

$semester_begin = substr($orgsetins['semdate1'],4,4).'-'.substr($orgsetins['semdate1'],2,2).'-'.substr($orgsetins['semdate1'],0,2);

if (isset($_REQUEST['ilin']) && isset($_REQUEST['whattodo']))
{
    if (isset($_REQUEST["number_of_request"]))
	{
		$stmt = $mysqli->prepare("UPDATE s_m_t
		SET cStudyCenterId = ? 
		WHERE vMatricNo = ?");

		$stmt_1 = $mysqli->prepare("UPDATE student_request_log_1 SET
		req_granted = '1'
		WHERE vMatricNo = ?
		AND centre_req = '1'
		AND req_granted = '0'
		AND centre_req_date >= '$semester_begin'");
		
		$cnt = 0;
		for ($x = 1; $x <= $_REQUEST["number_of_request"]; $x++)
		{
			$mat_chk = "mat_chk".$x;

			if (isset($_REQUEST[$mat_chk]))
			{
				$passed_var = explode(",", $_REQUEST[$mat_chk]);
				//echo $passed_var[0].' '.$passed_var[1].' '.$passed_var[2].'<br>';

				$matno = $passed_var[0];
				$request_centre = $passed_var[1];
				$current_centre = $passed_var[2];

				$stmt->bind_param("ss", $request_centre, $matno); 
				$stmt->execute();

				$stmt_1->bind_param("s", $matno);
				$stmt_1->execute();

				log_actv('Changed study centre for '. $matno.' from '.$current_centre.' to '.$request_centre);
				$cnt++;
			}
		}
		$stmt->close();
		$stmt_1->close();
		echo $cnt . ' records updated successfully';
	}else
	{
		if (!isset($_REQUEST['conf']))
		{		
			$feed_back_message = '';
			if (isset($_REQUEST["uvApplicationNo"]))
			{
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
					
					$stmt = $mysqli->prepare("SELECT a.cSbmtd, cSCrnd, a.cFacultyId, e.vFacultyDesc, f.vdeptDesc, a.iBeginLevel, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, a.vLastName, a.vFirstName, a.vOtherName, a.cStudyCenterId, b.cEduCtgId
					FROM prog_choice a, programme b, obtainablequal c, faculty e, depts f 
					WHERE a.cProgrammeId = b.cProgrammeId
					AND b.cObtQualId = c.cObtQualId
					AND a.cFacultyId = e.cFacultyId
					AND b.cdeptId = f.cdeptId
					AND a.vApplicationNo = ?");
					$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($cSbmtd_02, $cSCrnd_02, $cFacultyId_03, $vFacultyDesc, $vdeptDesc, $iBeginLevel_02, $cProgrammeId_02, $vObtQualTitle_02, $vProgrammeDesc_02, $vLastName_02, $vFirstName_02, $vOtherName_02, $cStudyCenterId, $cEduCtgId);
					$stmt->fetch();
					$stmt->close();

					if (is_null($cStudyCenterId))
					{
						$cStudyCenterId = '';
					}
					
					/*if (is_null($cStudyCenterId) || is_null($cProgrammeId_02) || is_null($vObtQualTitle_02) || is_null($cFacultyId_03) || is_null($vdeptDesc))
					{
						echo '*Match not found';exit;
					}*/

					if (is_null($cProgrammeId_02) || is_null($vObtQualTitle_02) || is_null($cFacultyId_03) || is_null($vdeptDesc))
					{
						echo '*Match not found';exit;
					}
					
					if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
					{
						echo '*Your study centre does not match that of the candidate<br>Direct candidate to his/her study centre for required actions';exit;
					}

					if ($cSbmtd_02 == '0' && $cSCrnd_02 <> '3')
					{
						echo '*Form not yet submitted. Candidate may go and choose study centre of choice';exit;
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

					//$mask = get_mask($_REQUEST["uvApplicationNo"]);

					if (isset($vLastName_02) && $vLastName_02 <> '')
					{
						if (!is_bool(strpos($vProgrammeDesc_02,"(d)")))
						{
							$vProgrammeDesc_02 = substr($vProgrammeDesc_02, 0, strlen($vProgrammeDesc_02)-4);
						}

						$pix_mask = get_pp_pix($_REQUEST["uvApplicationNo"]);
							
						if (is_null($pix_mask))
						{
							$pix_mask = '';
						}
							
						if (is_null($vOtherName_02))
						{
							$vOtherName_02 = '';
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
						str_pad($vFacultyDesc, 100).
						str_pad($vdeptDesc, 100).
						str_pad($cProgrammeId_02, 100).
						str_pad($cEduCtgId, 100).
						str_pad($cStudyCenterId, 100).
						str_pad($pix_mask, 100);
					}
					
					if ($_REQUEST['process_step'] == '2')
					{
						$feed_back_message = 'Are you sure you want to change candidate\'s study centre?';
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
						$set_date = substr($orgsetins['student_req1'],4,4).'-'.substr($orgsetins['student_req1'],2,2).'-'.substr($orgsetins['student_req1'],0,2);
					}else
					{
						$set_date = substr($orgsetins['student_req2'],4,4).'-'.substr($orgsetins['student_req2'],2,2).'-'.substr($orgsetins['student_req2'],0,2);
					}
					

					if ($currentDate > $set_date)
					{
						echo '*Changing of Study Centre has closed';
						exit;
					}


					if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
					{
						echo '*Your study centre does not match that of the student<br>Direct student to his/her study centre for required action';exit;
					}

					if ($_REQUEST['mm'] == 8 && $vObtQualTitle_01 <> 'M. Phil.,' && $vObtQualTitle_01 <> 'Ph.D.,')
					{
						echo 'Application form number must be that of an M. Phil. or Ph.D. candidate'; exit;
					}else if ($_REQUEST['mm'] == 1 && ($vObtQualTitle_01 == 'M. Phil.,' || $vObtQualTitle_01 == 'Ph.D.,'))
					{
						echo 'Application form number must be that of an undergraduate, PGD or Masters candidate'; exit;
					}else if ($_REQUEST['sRoleID'] == 29 && is_bool(strpos($cProgrammeId_01, 'CHD')))
					{
						echo 'Application form number must be that of a certificate candidate in CHRD'; exit;
					}else if ($_REQUEST['sRoleID'] == 26 && is_bool(strpos($cProgrammeId_01, 'DEG')))
					{
						echo 'Application form number must be that of a certificate candidate in DE&GS';exit;
					}

					if (check_grad_student($_REQUEST["uvApplicationNo"]) == 1)
					{
						echo '*Matriculation number graduated';exit;
					}

					// $stmt = $mysqli->prepare("SELECT * FROM student_request_log_1 WHERE centre_req = '1' AND req_granted = '0' AND (centre_req_date >= '' AND centre_req_date <= '') AND vMatricNo = ?");
					// $stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
					// $stmt->execute();
					// $stmt->store_result();

					// if ($stmt->num_rows == 0)
					// {
					// 	echo '*Student did not request for a change of study centre';exit;
					// }

					//$mask = get_mask($_REQUEST["uvApplicationNo"]);

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
						
					if (is_null($vOtherName_01))
					{
						$vOtherName_01 = '';
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
					str_pad($vFacultyDesc, 100).
					str_pad($vdeptDesc, 100).
					str_pad($cProgrammeId_01, 100).
					str_pad($cEduCtgId, 100).
					str_pad($cStudyCenterId, 100).
					str_pad($pix_mask, 100);
					
					$stmt->close();
					
					if ($_REQUEST['process_step'] == '2')
					{
						$feed_back_message = 'Are you sure you want to change student\'s study centre?';
					}
				}

				if ($_REQUEST['process_step'] == '1')
				{
					echo $who_is_this;exit;
				}


				// if ($_REQUEST['process_step'] == '2')
				// {
				// 	$token = send_token('change of study centre','0');
				// 	echo $token.$feed_back_message;exit;
				// }

				echo $feed_back_message;exit;
			}else if (isset($_REQUEST["bulk_change"]))
			{
				if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == '1')
				{				
					$currentDate = date('Y-m-d');				
							
					$set_date = substr($orgsetins['drp_examdate'],4,4).'-'.substr($orgsetins['drp_examdate'],2,2).'-'.substr($orgsetins['drp_examdate'],0,2);

					if ($currentDate > $set_date)
					{
						echo 'Changing of Study Centre has closed';
						exit;
					}
				}
				
				// $feed_back_message = 'Are you sure you want to change study centre for all entered numbers?';
				// $token = send_token('bulk change of study centre','0');
				echo 'Are you sure you want to change study centre for listed numbers?';exit;
			}
		}else if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1')
		{
			$cFacultyId = '';

			if (isset($_REQUEST['bulk_change']))
			{
				// if (isset($_REQUEST['bulk_change']))
				// {
				// 	$token_status = validate_token($_REQUEST["uvApplicationNo"],'bulk change of study centre');
			
				// 	if ($token_status <> 'Token valid')
				// 	{
				// 		echo $token_status;
				// 		exit;
				// 	}
				// }

				$invalid_afn = '';
				$invalid_afn_count = 0;

				$not_submmited_afn = '';
				$not_submmited_afn_count = 0;

				$valid_afn = '';
				$valid_afn_count = 0;

				$splitLine = explode("\n", str_replace("\r", "", $_REQUEST["bulk_change"]));

				try
				{
					$mysqli->autocommit(FALSE); //turn on transactions	
					foreach ($splitLine as $val_arr)
					{
						if (!is_bool(strripos($invalid_afn, $val_arr)) || 
						!is_bool(strripos($not_submmited_afn, $val_arr)) || 
						!is_bool(strripos($valid_afn, $val_arr)))
						{
							continue;
						}

						if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == '0')
						{
							$stmt_a = $mysqli->prepare("SELECT cSbmtd, cFacultyId FROM prog_choice WHERE vApplicationNo = ?");
							$stmt_a->bind_param("s", $val_arr);
							$stmt_a->execute();
							$stmt_a->store_result();
							$stmt_a->bind_result($cSbmtd, $cFacultyId);
							$stmt_a->fetch();
							
							if (is_null($cFacultyId))
							{
								$cFacultyId = '';
							}else
							{
								$cFacultyId = strtolower($cFacultyId);
							}						
						}else if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == '1')
						{
							$stmt_a = $mysqli->prepare("SELECT cFacultyId FROM s_m_t WHERE vMatricNo = ?");
							$stmt_a->bind_param("s", $val_arr);
							$stmt_a->execute();
							$stmt_a->store_result();
							$stmt_a->bind_result($cFacultyId);
							$stmt_a->fetch();
							
							if (is_null($cFacultyId))
							{
								$cFacultyId = '';
							}else
							{
								$cFacultyId = strtolower($cFacultyId);
							}				
							
							$stmt_a = $mysqli->prepare("SELECT * FROM afnmatric WHERE vMatricNo = ?");
							$stmt_a->bind_param("s", $val_arr);
							$stmt_a->execute();
							$stmt_a->store_result();
						}				

						if ($stmt_a->num_rows == 0)
						{
							$invalid_afn_count++;
							$invalid_afn .= $invalid_afn_count.'. '.$val_arr.'<br>';
						}else if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == '0' && $cSbmtd == 0)
						{
							$not_submmited_afn_count++;
							$not_submmited_afn .= $not_submmited_afn_count.'. '.$val_arr.'<br>';
						}else 
						{
							$valid_afn_count++;
							$valid_afn .= $valid_afn_count.'. '.$val_arr.'<br>';
							
							if ($_REQUEST['id_no'] == '0')
							{
								/*if ($cFacultyId <> '')
								{
									$stmt = $mysqli->prepare("UPDATE prog_choice_$cFacultyId 
									SET cStudyCenterId = ? 
									WHERE vApplicationNo = ?");
									$stmt->bind_param("ss", $_REQUEST['cStudyCenterIdold'], $val_arr); 
									$stmt->execute();
								}*/

								$stmt_cent = $mysqli->prepare("SELECT cStudyCenterId
								FROM prog_choice 
								WHERE vApplicationNo = ?");
								$stmt_cent->bind_param("s", $val_arr);
								$stmt_cent->execute();
								$stmt_cent->store_result();
								$stmt_cent->bind_result($cStudyCenterId);
								$stmt_cent->fetch();

								$stmt = $mysqli->prepare("UPDATE prog_choice 
								SET cStudyCenterId = ? 
								WHERE vApplicationNo = ?");
								$stmt->bind_param("ss", $_REQUEST['cStudyCenterIdold'], $val_arr); 
								$stmt->execute();
								
								log_actv('Changed study centre for '.$val_arr.' from '.$cStudyCenterId.' to '.$_REQUEST['cStudyCenterIdold']);
							}else if ($_REQUEST['id_no'] == '1')
							{
								// if ($cFacultyId <> '')
								// {
								// 	$stmt = $mysqli->prepare("UPDATE s_m_t_$cFacultyId 
								// 	SET cStudyCenterId = ? 
								// 	WHERE vMatricNo = ?");
								// 	$stmt->bind_param("ss", $_REQUEST['cStudyCenterIdold'], $val_arr); 
								// 	$stmt->execute();
								// }					
								$stmt_cent = $mysqli->prepare("SELECT cStudyCenterId
								FROM s_m_t 
								WHERE vMatricNo = ?");
								$stmt_cent->bind_param("s", $val_arr);
								$stmt_cent->execute();
								$stmt_cent->store_result();
								$stmt_cent->bind_result($cStudyCenterId);
								$stmt_cent->fetch();

								$stmt = $mysqli->prepare("UPDATE s_m_t
								SET cStudyCenterId = ? 
								WHERE vMatricNo = ?");
								$stmt->bind_param("ss", $_REQUEST['cStudyCenterIdold'], $val_arr); 
								$stmt->execute();

								// $stmt_b = $mysqli->prepare("UPDATE veri_token SET cused = '1', used_time = NOW() WHERE vApplicationNo = ? AND uvApplicationNo = ? AND vtoken = ?");
								// $stmt_b->bind_param("sss", $_REQUEST["vApplicationNo"], $val_arr, $_REQUEST["veri_token"]); 
								// $stmt_b->execute();
								
								log_actv('Changed study centre for '.$val_arr.' from '.$cStudyCenterId.' to '.$_REQUEST['cStudyCenterIdold']);
							}
						}
					}
				
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

					//echo '*Study Centre successfully changed'.$hint;exit;
				}catch(Exception $e) 
				{
					$mysqli->rollback(); //remove all queries from queue if error (undo)
					throw $e;
				}
				
				if (isset($stmt))
				{
					$stmt->close();
				}
				
				if (isset($stmt_a))
				{
					$stmt_a->close();
				}

				
				if (isset($stmt_b))
				{
					$stmt_b->close();
				}

				$strng = '';
				if ($invalid_afn <> '')
				{
					$strng = '<b>Invalid numbers (not treated)</b><br>'.$invalid_afn.'<p>';
				}

				if ($not_submmited_afn <> '')
				{
					$strng .= '<b>Form not submitted (not treated)</b><br>'.$not_submmited_afn.'<p>';
				}

				if ($valid_afn <> '')
				{
					$strng .= '<b>Valid numbers (treated)</b><br>'.$valid_afn;
				}
				echo $strng;
				exit;
			}else if (isset($_REQUEST['uvApplicationNo']))
			{
				// $token_status = validate_token($_REQUEST["uvApplicationNo"],'change of study centre');
			
				// if ($token_status <> 'Token valid')
				// {
				// 	echo $token_status;
				// 	exit;
				// }

				//try
				//{
					//$mysqli->autocommit(FALSE); //turn on transactions	
			
					if ($_REQUEST['id_no'] == '0')
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

						/*$stmt_a = $mysqli->prepare("SELECT cFacultyId FROM prog_choice WHERE vApplicationNo = ?");
						$stmt_a->bind_param("s", $_REQUEST["uvApplicationNo"]);
						$stmt_a->execute();
						$stmt_a->store_result();
						$stmt_a->bind_result($cFacultyId);
						$stmt_a->fetch();

						$cFacultyId = $cFacultyId ?? '';
						$cFacultyId = strtolower($cFacultyId);
						
						if ($cFacultyId <> '')
						{
							$stmt = $mysqli->prepare("UPDATE prog_choice_$cFacultyId 
							SET cStudyCenterId = ? 
							WHERE vApplicationNo = ?");
							$stmt->bind_param("ss", $_REQUEST['cStudyCenterIdold'], $val_arr); 
							$stmt->execute();
						}*/
						
						$stmt_cent = $mysqli->prepare("SELECT cStudyCenterId
						FROM prog_choice 
						WHERE vApplicationNo = ?");
						$stmt_cent->bind_param("s", $_REQUEST["uvApplicationNo"]);
						$stmt_cent->execute();
						$stmt_cent->store_result();
						$stmt_cent->bind_result($cStudyCenterId);
						$stmt_cent->fetch();

						$stmt = $mysqli->prepare("UPDATE prog_choice 
						SET cStudyCenterId = ? 
						WHERE vApplicationNo = ?");
						$stmt->bind_param("ss", $_REQUEST['cStudyCenterIdold'], $_REQUEST["uvApplicationNo"]); 
						$stmt->execute();
						$stmt->close();

						log_actv('Changed study centre for '.$_REQUEST["uvApplicationNo"].' from '.$cStudyCenterId.' to '.$_REQUEST['cStudyCenterIdold']);
					}else if ($_REQUEST['id_no'] == '1')
					{
						// $stmt_a = $mysqli->prepare("SELECT cFacultyId FROM s_m_t WHERE vMatricNo = ?");
						// $stmt_a->bind_param("s", $_REQUEST["uvApplicationNo"]);
						// $stmt_a->execute();
						// $stmt_a->store_result();
						// $stmt_a->bind_result($cFacultyId);
						// $stmt_a->fetch();

						// $cFacultyId = $cFacultyId ?? '';
						// $cFacultyId = strtolower($cFacultyId);
						
						// if ($cFacultyId <> '')
						// {
						// 	$stmt = $mysqli->prepare("UPDATE s_m_t_$cFacultyId 
						// 	SET cStudyCenterId = ? 
						// 	WHERE vMatricNo = ?");
						// 	$stmt->bind_param("ss", $_REQUEST['cStudyCenterIdold'], $_REQUEST["uvApplicationNo"]); 
						// 	$stmt->execute();
						// }
						$stmt_cent = $mysqli->prepare("SELECT cStudyCenterId
						FROM s_m_t 
						WHERE vMatricNo = ?");
						$stmt_cent->bind_param("s", $_REQUEST["uvApplicationNo"]);
						$stmt_cent->execute();
						$stmt_cent->store_result();
						$stmt_cent->bind_result($cStudyCenterId);
						$stmt_cent->fetch();

						$stmt = $mysqli->prepare("UPDATE s_m_t 
						SET cStudyCenterId = ? 
						WHERE vMatricNo = ?");
						$stmt->bind_param("ss", $_REQUEST['cStudyCenterIdold'], $_REQUEST["uvApplicationNo"]); 
						$stmt->execute();
						//$stmt->close();

						log_actv('Changed study centre for '.$_REQUEST["uvApplicationNo"].' from '.$cStudyCenterId.' to '.$_REQUEST['cStudyCenterIdold']);

						
						// $stmt = $mysqli->prepare("REPLACE INTO student_request_log_1 
						// SET coldcentre = ?,
						// cnewcentre = ?, 
						// vMatricNo = ?");
						// $stmt->bind_param("sss", $_REQUEST['studycentre_now'], $_REQUEST['cStudyCenterIdold'], $_REQUEST["uvApplicationNo"]); 
						// $stmt->execute();
						// $stmt->close();					
					}

					// $stmt = $mysqli->prepare("UPDATE veri_token SET cused = '1', used_time = NOW() WHERE vApplicationNo = ? AND uvApplicationNo = ? AND vtoken = ?");
					// $stmt->bind_param("sss", $_REQUEST["vApplicationNo"], $_REQUEST["uvApplicationNo"], $_REQUEST["veri_token"]); 
					// $stmt->execute();
					// $stmt->close();

					//log_actv('Changed study centre for '.$_REQUEST["uvApplicationNo"]);
					//$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

					echo '*Study Centre successfully changed'.$hint;exit;
				// }catch(Exception $e) 
				// {
				// 	$mysqli->rollback(); //remove all queries from queue if error (undo)
				// 	throw $e;
				// }
			}
		}
	}
}