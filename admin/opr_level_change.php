<?php
require_once('../../fsher/fisher.php');
include('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$currency = eyes_pilled('0');


$staff_study_center = '';
if (isset($_REQUEST['staff_study_center']))
{
	$staff_study_center = $_REQUEST['staff_study_center'];
}

$orgsetins = settns();
$semester_begin_date = substr($orgsetins['semdate1'],4,4).'-'.substr($orgsetins['semdate1'],2,2).'-'.substr($orgsetins['semdate1'],0,2);

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

if (isset($_REQUEST['ilin']) && $_REQUEST['ilin'] <> '' && isset($_REQUEST['whattodo']))
{
	//$mask = get_mask($_REQUEST["uvApplicationNo"]);

    if (isset($_REQUEST["number_of_request"]))
	{
		$stmt_s_m_t = $mysqli->prepare("UPDATE s_m_t 
		SET iStudy_level = ?, 
		tSemester = ? 
		WHERE semester_reg = '1'
		AND vMatricNo = ?");

		$stmt_log = $mysqli->prepare("UPDATE student_request_log_1 
		SET req_granted = '1'
		WHERE level_req = '1'
		AND LEFT(act_date,10) >= '$semester_begin_date'
		AND vMatricNo = ?");

		$cnt = 0;
		for ($x = 1; $x <= $_REQUEST["number_of_request"]; $x++)
		{
			$mat_chk = "mat_chk".$x;

			if (isset($_REQUEST[$mat_chk]))
			{
				$passed_var = explode(",", $_REQUEST[$mat_chk]);
				//echo $passed_var[0].' '.$passed_var[1].' '.$passed_var[2].' '.$passed_var[3].' '.$passed_var[4].'<br>';

				$matno = $passed_var[0];
				$coldlevel = $passed_var[1];
				$cnewlevel = $passed_var[2];
				$coldsemester = $passed_var[3];
				$cnewsemester = $passed_var[4];

				$actual_semester = actual_semester($matno, $cnewlevel, $cnewsemester); 

				$stmt_s_m_t->bind_param("sss", $cnewlevel, $actual_semester, $matno); 
				$stmt_s_m_t->execute();
				
				$stmt_log->bind_param("s",  $matno); 
				$stmt_log->execute();

				$cnt++;
			}	
		}
		
		echo $cnt. ' records updated successfully';
	}else if (!isset($_REQUEST['conf']))
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
				//echo '*Invalid application form numbers';exit;
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
					
			if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
			{
				echo '*Your study centre does not match that of the candidate<br>Direct candidate to his/her study centre for required actions';exit;
			}

			if ($cSbmtd_02 == '0')
			{
				echo '*Form not yet submitted. Candidate may go and choose level accordingly';exit;
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
				if (!is_bool(strpos($vProgrammeDesc_02,"(d)")))
				{
					$vProgrammeDesc_02 = substr($vProgrammeDesc_02, 0, strlen($vProgrammeDesc_02)-4);
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
				$feed_back_message = 'Are you sure you want to change candidate\'s level?';
			}
		}else if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == '1')
		{
			// $stmt = $mysqli->prepare("SELECT f.vApplicationNo, f.cFacultyId, h.vFacultyDesc, i.vdeptDesc, f.iStudy_level, f.tSemester, a.cSbmtd, f.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, d.vLastName, d.vFirstName, d.vOtherName, f.cStudyCenterId, g.vCityName, b.cEduCtgId  
			// FROM prog_choice a, programme b, obtainablequal c, pers_info d, afnmatric e, s_m_t f, studycenter g, faculty h, depts i
			// WHERE f.cProgrammeId = b.cProgrammeId  
			// AND b.cObtQualId = c.cObtQualId 
			// AND d.vApplicationNo = a.vApplicationNo 
			// AND e.vApplicationNo = a.vApplicationNo 
			// AND e.vMatricNo = f.vMatricNo 
			// AND f.cStudyCenterId = g.cStudyCenterId
			// AND f.cFacultyId = h.cFacultyId
			// AND b.cdeptId = i.cdeptId
			// AND e.vMatricNo = ?");

			$stmt = $mysqli->prepare("SELECT f.vApplicationNo, f.cFacultyId, h.vFacultyDesc, i.vdeptDesc, f.iBegin_level, f.iStudy_level, f.tSemester, f.semester_reg, f.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, f.vLastName, f.vFirstName, f.vOtherName, f.cStudyCenterId, g.vCityName, b.cEduCtgId  
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
			$stmt->bind_result($vApplicationNo_01, $cfacultyId_01, $vFacultyDesc, $vdeptDesc, $iBegin_level, $iStudy_level_01, $tSemester_01, $semester_reg_01, $cProgrammeId_01, $vObtQualTitle_01, $vProgrammeDesc_01, $vLastName_01, $vFirstName_01, $vOtherName_01, $cStudyCenterId, $vCityName, $cEduCtgId);
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

			if ($currentDate > $set_date && !isset($_REQUEST['over_ride_callendar']))
			{
				echo '*Changing of level has closed';
				exit;
			}
			
			if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
			{
				echo '*Your study centre does not match that of the student<br>Direct student to his/her study centre for required action';exit;
			}
			
			if ($_REQUEST['mm'] == 8 && $cProgrammeId_01 <> 'PGX' && $cProgrammeId_01 <> 'PGY' && $cProgrammeId_01 <> 'PGZ' && $cProgrammeId_01 <> 'PRX')
			{
				echo '*Matriculaton form number must be that of an M. Phil. or Ph.D. student'; exit;
			}else if ($_REQUEST['mm'] == 1 && ($cProgrammeId_01 == 'PGZ' || $cProgrammeId_01 == 'PRX'))
			{
				echo '*Matriculaton form number must be that of an undergraduate, PGD or Masters student'; exit;
			}

			if (check_grad_student($_REQUEST["uvApplicationNo"]) == 1)
			{
				echo '*Matriculation number graduated';exit;
			}

			if ($semester_reg_01 <> '1')
			{
				echo 'Student not registered for the semester';exit;
			}

			// $stmt = $mysqli->prepare("SELECT * FROM student_request_log_1 WHERE level_req = '1' AND req_granted = '0' AND vMatricNo = ?");
			// $stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
			// $stmt->execute();
			// $stmt->store_result();

			// if ($stmt->num_rows == 0)
			// {
			// 	echo '*Student did not request for a change of level';exit;
			// }

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
			str_pad($iBegin_level, 100).
			str_pad($pix_mask, 100);
			
			$stmt->close();
			
			if ($_REQUEST['process_step'] == '2')
			{
				$feed_back_message = 'Are you sure you want to change student\'s level?';
			}
		}

		if ($_REQUEST['process_step'] == '1')
		{
			echo $who_is_this;exit;
		}

		// if ($_REQUEST['process_step'] == '2')
		// {
		// 	$token = send_token('change of level','0');
		// 	echo $token.$feed_back_message;exit;
		// }

		echo $feed_back_message;exit;
	}else if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1')
    {

		$currentDate = date('Y-m-d');
                    
		if ($iStudy_level_01 <= 200)
		{
			$set_date = substr($orgsetins['drp_examdate'],4,4).'-'.substr($orgsetins['drp_examdate'],2,2).'-'.substr($orgsetins['drp_examdate'],0,2);
		}else
		{
			$set_date = substr($orgsetins['drp_exam_2date'],4,4).'-'.substr($orgsetins['drp_exam_2date'],2,2).'-'.substr($orgsetins['drp_exam_2date'],0,2);
		}
		
		if ($currentDate > $set_date && !isset($_REQUEST['over_ride_callendar']))
		{
			echo 'Changing of level has closed';
			exit;
		}
        // $token_status = validate_token($_REQUEST["uvApplicationNo"],'change of level');
    
		// if ($token_status <> 'Token valid')
		// {
		// 	echo $token_status;
		// 	exit;
		// }
		
		if (isset($_FILES["sbtd_pix"]))
		{
			$file_name = 'level_record.csv';
			$dir_name = "../../ext_docs/docs/";
			$file = $dir_name . '/' . $file_name;
			@unlink($file);
	
			if (!move_uploaded_file($_FILES["sbtd_pix"]["tmp_name"], $file))
			{
				echo "We are Sorry, there was an error uploading your file.";exit;
			}

			chmod($file, 0755);
			log_actv('Uploaded file '.$file);
			
			$handle = fopen("$file", "r");
			
			$c = 0;
			$feed_back = '';

			$err_count = 0;
			
			$number_of_transactions = 0;

			$stmt_s_m_t = $mysqli->prepare("UPDATE s_m_t 
			SET iStudy_level = ?, 
			tSemester = ? 
			WHERE vMatricNo = ?");

			$stmt_log = $mysqli->prepare("REPLACE INTO student_request_log_1 
			SET level_req = '1',
			req_granted = '1',
			coldlevel = ?,
			cnewlevel = ?, 
			vMatricNo = ?");

			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
			{
				if (count($data) <> 3) 
				{
					fclose($handle);
					chmod($file, 0755);
					unlink($file) or die("Couldn't continue process ");

					echo 'There should be 3 columns of data: Matric. no., level and semester';
					exit;
				}

				$semester_actual = '';
				
				$matno = strtoupper(clean_string($data[0], 'matno'));
				//$matno = clean_str($data[0]);

				$level = clean_string($data[1], 'numbers');
				//$level = clean_str($data[1]);

				$semester = clean_string($data[2], 'numbers');
				//$semester = clean_str($data[2]);

				
				//$matno = strtoupper($data[0]);
				//$level = ucfirst(strtolower($data[1]));
				//$semester = ucfirst(strtolower($data[2]));

				$stmt = $mysqli->prepare("SELECT iBegin_level, iStudy_level FROM s_m_t WHERE vMatricNo = ?");
				$stmt->bind_param("s", $matno);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($iBegin_level, $iStudy_level);
				$stmt->fetch();

				if (is_null($iBegin_level) || !is_numeric($iBegin_level))
				{
					$feed_back .= ++$err_count.' '.$matno.' invalid entry level<br>';
			    	continue;
				}

				if (is_null($level) || !is_numeric($level) || $level < 100 || $level == 600)
				{
					$feed_back .= ++$err_count.' '.$matno.' invalid level<br>';
			    	continue;
				}

				$cango = courses_reg_above_level ($matno, $level);
				if ($cango > 0)
				{
					continue;
				}

				if (is_null($semester) || !is_numeric($semester))
				{
					$feed_back .= ++$err_count.' '.$matno.' invalid semester ';
			    	continue;
				}

				$semester_actual = actual_semester($matno, $level, $semester);

				/*if ($iBegin_level == 100)
				{
					if ($level == 100)
					{
						$semester_actual = $semester;
					}else if ($level == 200)
					{
						if ($semester == 1)
						{
							$semester_actual = 3;
						}else if ($semester == 2)
						{
							$semester_actual = 4;
						}
					}else if ($level == 300)
					{
						if ($semester == 1)
						{
							$semester_actual = 5;
						}else if ($semester == 2)
						{
							$semester_actual = 6;
						}
					}else if ($level == 400)
					{
						if ($semester == 1)
						{
							$semester_actual = 7;
						}else if ($semester == 2)
						{
							$semester_actual = 8;
						}
					}else if ($level == 500)
					{
						if ($semester == 1)
						{
							$semester_actual = 9;
						}else if ($semester == 2)
						{
							$semester_actual = 10;
						}
					}
				}else if ($iBegin_level == 200)
				{
					if ($level == 200)
					{
						$semester_actual = $semester;
					}else if ($level == 300)
					{
						if ($semester == 1)
						{
							$semester_actual = 3;
						}else if ($semester == 2)
						{
							$semester_actual = 4;
						}
					}else if ($level == 400)
					{
						if ($semester == 1)
						{
							$semester_actual = 5;
						}else if ($semester == 2)
						{
							$semester_actual = 6;
						}
					}else if ($level == 500)
					{
						if ($semester == 1)
						{
							$semester_actual = 7;
						}else if ($semester == 2)
						{
							$semester_actual = 8;
						}
					}
				}else if ($iBegin_level == 300)
				{
					if ($level == 300)
					{
						$semester_actual = $semester;
					}else if ($level == 400)
					{
						if ($semester == 1)
						{
							$semester_actual = 3;
						}else if ($semester == 2)
						{
							$semester_actual = 4;
						}
					}else if ($level == 500)
					{
						if ($semester == 1)
						{
							$semester_actual = 5;
						}else if ($semester == 2)
						{
							$semester_actual = 6;
						}
					}
				}else if ($iBegin_level == 700)
				{
					$semester_actual = $semester;
				}else if ($iBegin_level == 800)
				{
					$semester_actual = $semester;
				}*/

				
				$stmt_s_m_t->bind_param("iis", $level, $semester_actual, $matno); 
				$stmt_s_m_t->execute();

				$stmt_log->bind_param("sss", $iStudy_level, $level, $matno); 
				$stmt_log->execute();

				//echo $matno.','.$iBegin_level.','.$level.','.$semester.','.$semester_actual.'<br>';

				$c++;
			}
			$stmt_s_m_t->close();
			$stmt_log->close();
			$stmt->close();

			echo $c.' records updated successfully';
			if ($feed_back <> '')
			{
				echo '<p>'.$feed_back;
			}
		}else
		{
			try
			{
				$mysqli->autocommit(FALSE); //turn on transactions	
		
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
						$hint = "<br>Candidate's record must also be updated under his/her matriculation number, ".strtoupper($vMatricNo_02);
					}

					$stmt = $mysqli->prepare("SELECT cFacultyId FROM prog_choice WHERE vApplicationNo = ?");
					$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($cFacultyId);
					$stmt->fetch();
							
					if (is_null($cFacultyId))
					{
						$cFacultyId = '';
					}else
					{
						$cFacultyId = strtolower($cFacultyId);
					}
					

					
					// if ($cFacultyId <> '')
					// {
					// 	$stmt = $mysqli->prepare("update prog_choice_$cFacultyId 
					// 	set iBeginLevel = ?
					// 	where vApplicationNo = ?");
					// 	$stmt->bind_param("is", $_REQUEST['courseLevel_2'], $_REQUEST["uvApplicationNo"]); 
					// 	$stmt->execute();
					// }
					
					
					$stmt = $mysqli->prepare("update prog_choice 
					set iBeginLevel = ?
					where vApplicationNo = ?");
					$stmt->bind_param("is", $_REQUEST['courseLevel_2'], $_REQUEST["uvApplicationNo"]); 
					$stmt->execute();

					$stmt->close();
				}else if ($_REQUEST['id_no'] == '1')
				{
					$cango = courses_reg_above_level ($_REQUEST["uvApplicationNo"], $_REQUEST['courseLevel_2']);
					if ($cango > 0)
					{
						echo 'Student has registered courses above requested level';
						exit;
					}

					$stmt = $mysqli->prepare("SELECT cFacultyId FROM prog_choice WHERE vApplicationNo = ?");
					$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($cFacultyId);
					$stmt->fetch();
							
					if (is_null($cFacultyId))
					{
						$cFacultyId = '';
					}else
					{
						$cFacultyId = strtolower($cFacultyId);
					}

					
					if ($cFacultyId <> '')
					{
						// $stmt = $mysqli->prepare("UPDATE s_m_t_$cFacultyId 
						// SET iBegin_level = ?,
						// iStudy_level = ?
						// WHERE vMatricNo = ?");
						// $stmt->bind_param("iis", $_REQUEST['courseLevel_2'], $_REQUEST['courseLevel_2'], $_REQUEST["uvApplicationNo"]); 

						// $stmt = $mysqli->prepare("UPDATE s_m_t_$cFacultyId 
						// SET iStudy_level = ?
						// WHERE vMatricNo = ?");
						// $stmt->bind_param("is", $_REQUEST['courseLevel_2'], $_REQUEST["uvApplicationNo"]); 
						// $stmt->execute();
					}

					// $stmt = $mysqli->prepare("UPDATE s_m_t
					// SET iBegin_level = ?,
					// iStudy_level = ?
					// WHERE vMatricNo = ?");
					// $stmt->bind_param("iis", $_REQUEST['courseLevel_2'], $_REQUEST['courseLevel_2'], $_REQUEST["uvApplicationNo"]); 
					$stmt = $mysqli->prepare("UPDATE s_m_t
					SET iStudy_level = ?,
					tSemester = ?
					WHERE vMatricNo = ?");
					$stmt->bind_param("iis", $_REQUEST['courseLevel_2'], $_REQUEST['semester_2'], $_REQUEST["uvApplicationNo"]); 
					$stmt->execute();

					$stmt = $mysqli->prepare("REPLACE INTO student_request_log_1 
					SET coldlevel = ?,
					cnewlevel = ?, 
					vMatricNo = ?");
					$stmt->bind_param("sss", $_REQUEST['level_now'], $_REQUEST['courseLevel_2'], $_REQUEST["uvApplicationNo"]); 
					$stmt->execute();

					$stmt->close();
				}

				log_actv('Changed level for '.$_REQUEST["uvApplicationNo"]);
				$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

				echo '*Level successfully changed'.$hint;exit;
			}catch(Exception $e) 
			{
				$mysqli->rollback(); //remove all queries from queue if error (undo)
				throw $e;
			}
		}
    }
}


function courses_reg_above_level ($matno, $level)
{
	if ($level == 100)
	{
		$confirm_str = "('2','3','4','5','7','8','9')";
	}else if ($level == 200)
	{
		$confirm_str = "('3','4','5','7','8','9')";
	}else if ($level == 300)
	{
		$confirm_str = "('4','5','7','8','9')";
	}else if ($level == 400)
	{
		$confirm_str = "('5','7','8','9')";
	}else if ($level == 500)
	{
		$confirm_str = "('7','8','9')";
	}else if ($level == 700)
	{
		$confirm_str = "('8','9')";
	}else if ($level == 800)
	{
		$confirm_str = "('9')";
	}

	$mysqli = link_connect_db();

	/*$stmt = $mysqli->prepare("SELECT * FROM coursereg_arch_20242025 WHERE vMatricNo = ? AND MID(cCourseId,4,1) IN $confirm_str");
	$stmt->bind_param("s", $matno);
	$stmt->execute();
	$stmt->store_result();
	$num = $stmt->num_rows;
	$stmt->close();

	return $num;*/

	if(substr($matno,3,2) <= 19)
	{
		$tables = '20172019,20202021,20222023,20242025';		
	}else if(substr($matno,3,2) == 20 || substr($matno,3,2) == 21)
	{
		$tables = '20202021,20222023,20242025';
	}else if(substr($matno,3,2) == 22 || substr($matno,3,2) == 23)
	{
		$tables = '20222023,20242025';
	}else
	{
		$tables = '20242025';
	}
	
    $num = 0;
	$table = explode(",", $tables);

    foreach ($table as &$value)
    {
        $wrking_tab = 'coursereg_arch_'.$value;

        $stmt = $mysqli->prepare("SELECT *
        FROM $wrking_tab 
        WHERE vMatricNo = ?
        AND MID(cCourseId,4,1) IN $confirm_str");
        $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
        $stmt->execute();
        $stmt->store_result();
        $num = $stmt->num_rows;

        if ($num > 0)
        {
            return $num;
        }
    }
	return $num;
}


function actual_semester($matno, $level, $semester)
{
	$mysqli = link_connect_db();

	$stmt = $mysqli->prepare("SELECT iBegin_level, iStudy_level FROM s_m_t WHERE vMatricNo = ?");
	$stmt->bind_param("s", $matno);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($iBegin_level, $iStudy_level);
	$stmt->fetch();

	$semester_actual = '';

	if ($iBegin_level == 100)
	{
		if ($level == 100)
		{
			$semester_actual = $semester;
		}else if ($level == 200)
		{
			if ($semester == 1)
			{
				$semester_actual = 3;
			}else if ($semester == 2)
			{
				$semester_actual = 4;
			}
		}else if ($level == 300)
		{
			if ($semester == 1)
			{
				$semester_actual = 5;
			}else if ($semester == 2)
			{
				$semester_actual = 6;
			}
		}else if ($level == 400)
		{
			if ($semester == 1)
			{
				$semester_actual = 7;
			}else if ($semester == 2)
			{
				$semester_actual = 8;
			}
		}else if ($level == 500)
		{
			if ($semester == 1)
			{
				$semester_actual = 9;
			}else if ($semester == 2)
			{
				$semester_actual = 10;
			}
		}
	}else if ($iBegin_level == 200)
	{
		if ($level == 200)
		{
			$semester_actual = $semester;
		}else if ($level == 300)
		{
			if ($semester == 1)
			{
				$semester_actual = 3;
			}else if ($semester == 2)
			{
				$semester_actual = 4;
			}
		}else if ($level == 400)
		{
			if ($semester == 1)
			{
				$semester_actual = 5;
			}else if ($semester == 2)
			{
				$semester_actual = 6;
			}
		}else if ($level == 500)
		{
			if ($semester == 1)
			{
				$semester_actual = 7;
			}else if ($semester == 2)
			{
				$semester_actual = 8;
			}
		}
	}else if ($iBegin_level == 300)
	{
		if ($level == 300)
		{
			$semester_actual = $semester;
		}else if ($level == 400)
		{
			if ($semester == 1)
			{
				$semester_actual = 3;
			}else if ($semester == 2)
			{
				$semester_actual = 4;
			}
		}else if ($level == 500)
		{
			if ($semester == 1)
			{
				$semester_actual = 5;
			}else if ($semester == 2)
			{
				$semester_actual = 6;
			}
		}
	}else if ($iBegin_level == 700)
	{
		$semester_actual = $semester;
	}else if ($iBegin_level == 800)
	{
		$semester_actual = $semester;
	}

	return $semester_actual;
}