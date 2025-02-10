<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$staff_study_center = '';
if (isset($_REQUEST['staff_study_center']) && $_REQUEST['staff_study_center'] <> '')
{
	$staff_study_center = $_REQUEST['staff_study_center'];
}

$vCityName = '';
$stmt = $mysqli->prepare("SELECT vCityName FROM studycenter  
WHERE cStudyCenterId = '$staff_study_center'");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($vCityName);
$stmt->fetch();
$stmt->close();

$study_mode_01 = '';
if (isset($_REQUEST['study_mode_ID']) && $_REQUEST['study_mode_ID'] <> '')
{
	$study_mode_01 = $_REQUEST['study_mode_ID'];
}

$orgsetins = settns();

$middle_session = $_REQUEST['schl_session'];

$courseId1 = '';
if (isset($_REQUEST['courseId1']))
{
	$courseId1 = $_REQUEST['courseId1'];
}

$crecommend = '';
$capprove = '';
$cgrade = '';
$show_student = '';

$topupbacklog = '';
if (isset($_REQUEST['topupbacklog']) && $_REQUEST['topupbacklog'] == '1')
{
	$topupbacklog = $_REQUEST['topupbacklog'];
}


date_default_timezone_set('Africa/Lagos');
$date2 = date("Y-m-d h:i:s");

if (isset($_REQUEST['ilin']))
{
	if (!isset($_REQUEST['for_all']))
	{
		$std_cFacultyId = '';
		$std_cdeptId = '';
		$std_cProgrammeId = '';
				
		$std_vFacultyDesc = '';
		$std_vdeptDesc = '';
		$std_vProgrammeDesc = '';
		$std_vObtQualTitle = '';	
		
		$result_already_uploaded = 0;
		
		//require 'php_sprdsht/vendor/autoload.php';
		
		$listed_matnos = "'";
		$valid_matnos = "'";
		$invalid_matnos = "";
		$matno_course_reg = '';
		$matno_exam_reg = '';
		
		$listed_matnos_count = 0;
		$valid_matnos_count = 0;
		$invalid_matnos_count = 0;
		$matno_course_reg_count = 0;
		$matno_exam_reg_count = 0;
		
		if (isset($_REQUEST['for_diff_course']))
		{
			$file_chk = check_file('3000000', '1');
			if ($file_chk <> '')
			{
				echo $file_chk;
				exit;
			}
			
			$file_name = 'diff_courses_'.$middle_session.'_'.$_REQUEST['schl_semester'];
			$dir_name = "../../ext_docs/results/result_".$middle_session;
			$file = $dir_name . '/' . $file_name;
	
			if( is_dir($dir_name) === false )
			{
				mkdir($dir_name);
			}

			$file_02 = '';
			for ($x = 1; $x <= 100; $x++)
			{
				$file_02 = $file . '_'.$x.'.'.$_REQUEST['file_name_ext']; 
				if (file_exists($file_02))
				{
					continue;
				}else
				{
					$file = $file_02;
					break;
				}
			}
			
			if (!move_uploaded_file($_FILES["sbtd_pix"]["tmp_name"], $file))
			{
				echo "We are Sorry, there was an error uploading your file.";exit;
			}else
			{
				chmod($file, 0755);
				log_actv('Uploaded file '.$file);
			}
			
			if ($_REQUEST['file_name_ext'] == 'csv')
			{
				$handle = fopen("$file", "r");
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
				{
					if (count($data) <> 4) 
					{
						fclose($handle);
						chmod($file, 0755);
						unlink($file) or die("Couldn't continue process ");

						echo 'There should be four columns of data: matriculation number, course code, score and grade.';
						exit;
					}

					
					$matricnum = strtoupper(str_replace(' ', '', $data[0]));

					//validate mat. no.
					$chk_mat_no = ($matricnum == '' ||
					strtolower($matricnum) == 'matriculation number' || 
					!is_bool(strpos(strtolower($matricnum), "matric")) || 
					!is_bool(strpos(strtolower($matricnum), "number")) || 
					!is_bool(strpos(strtolower($matricnum), "mat")) || 
					!is_bool(strpos(strtolower($matricnum), "no")) ||
					strlen($matricnum) <> 12);

					if ($chk_mat_no <> '1')
					{
						fclose($handle);
						chmod($file, 0755);
						unlink($file) or die("Couldn't continue process ");

						echo "Invalid matriculation number <b>$matricnum</b> found. Process aborted<br>";exit;
					}

					//validate mat. no. futher
					for ($t = 0; $t <= strlen($matricnum)-1; $t++)
					{
						if ($t == 0)
						{
							if (substr($matricnum, $t, 1) == 'N')
							{
								continue;
							}else
							{
								fclose($handle);
								chmod($file, 0755);
								unlink($file) or die("Couldn't continue process ");
								echo 'Invalid matriculation number <b>'.$matricnum.'</b> found. Does not begin with NOU';
								exit;
							}
						}else if ($t == 1)
						{
							if (substr($matricnum, $t, 1) == 'O')
							{
								continue;
							}else
							{
								fclose($handle);
								chmod($file, 0755);
								unlink($file) or die("Couldn't continue process ");
								echo 'Invalid matriculation number <b>'.$matricnum.'</b> found. Does not begin with NOU';
								exit;
							}
						}else if ($t == 2)
						{
							if (substr($matricnum, $t, 1) == 'U')
							{
								continue;
							}else
							{
								fclose($handle);
								chmod($file, 0755);
								unlink($file) or die("Couldn't continue process ");
								echo 'Invalid matriculation number <b>'.$matricnum.'</b> found. Does not begin with NOU';
								exit;
							}
						}else if (is_numeric(substr($matricnum, $t, 1)))
						{
							continue;
						}else
						{
							fclose($handle);
							chmod($file, 0755);
							unlink($file) or die("Couldn't continue process ");
							echo 'Invalid matriculation number <b>'.$matricnum.'</b> found. Has other character where there should be numeric';
							exit;
						}
					}


					//validate course code
					$course_code = str_replace(' ', '', $data[1]);
					$chk_cc = ($course_code == '' ||
					strtolower($course_code) == 'course code' || 
					!is_bool(strpos(strtolower($course_code), "course")) || 
					!is_bool(strpos(strtolower($course_code), "code")) ||
					strlen($course_code) <> 6 ||
					is_numeric(substr($course_code,0,3)) ||
					!is_numeric(substr($course_code,3,3)));

					if ($chk_cc == 1)
					{
						fclose($handle);
						chmod($file, 0755);
						unlink($file) or die("Couldn't continue process ");
						
						echo 'Invalid course codes: <b>'.$course_code.'</b> for matriculation number: <b>'.$matricnum.'</b> found. Process aborted<br>';
						exit;
					}
					
					//validate score
					$ex_score = str_replace(' ', '', $data[2]);
					$chk_score = !is_numeric($ex_score);

					if (!is_numeric($ex_score))
					{
						fclose($handle);
						chmod($file, 0755);
						unlink($file) or die("Couldn't continue process ");

						echo 'Invalid score: <b>'.$ex_score.'</b> for matriculation number: <b>'.$matricnum.'</b> found. Process aborted';
						exit;
					}

					if ($ex_score > 100 || $ex_score < 0)
					{
						fclose($handle);
						chmod($file, 0755);
						unlink($file) or die("Couldn't continue process ");
						echo 'Invalid score: <b>'.$ex_score.'</b> for matriculation number: <b>'.$matricnum.'</b> found. Process aborted';
						exit;
					}


					
					//validate grade
					$ex_grade = str_replace(' ', '', $data[3]);
					$chk_ex_grade = !($ex_grade == 'A' || $ex_grade == 'B' || $ex_grade == 'C' || $ex_grade == 'D' || $ex_grade == 'E'
					|| $ex_grade == 'F'|| $ex_grade == 'I');

					if ($chk_ex_grade == '1')
					{
						fclose($handle);
						chmod($file, 0755);
						unlink($file) or die("Couldn't continue process ");
						echo 'Invalid grade: <b>'.$ex_grade.'</b> for matriculation number: <b>'.$matricnum.'</b> found. Process aborted';
						exit;
					}

					
					// if (!is_numeric($data[3]))
					// {
					// 	fclose($handle);
					// 	chmod($file, 0755);
					// 	unlink($file) or die("Couldn't continue process ");
					// 	echo 'Invalid GPA for <b>'.$matricnum.'</b> found. Value is non-numeric';
					// 	exit;
					// }


					// if ($data[3] > 5)
					// {
					// 	fclose($handle);
					// 	chmod($file, 0755);
					// 	unlink($file) or die("Couldn't continue process ");
					// 	echo 'Invalid GPA for <b>'.$matricnum.'</b> found. Value greater than 5';
					// 	exit;
					// }

					

					

					/*$stmt = $mysqli->prepare("SELECT * FROM afnmatric WHERE vMatricNo = '$matricnum'");
					$stmt->execute();
					$stmt->store_result();
					if ($stmt->num_rows == 0)
					{
						$stmt->close();
						fclose($handle);
						chmod($file, 0755);
						unlink($file) or die("Couldn't continue process ");
						echo 'Invalid matriculation number <b>'.$matricnum.'</b> found for '.$course_code.'. Number does not exist. Process aborted';
						exit;
					}
					$stmt->close();*/

					//does code exist?						
					/*if ($chk_cc <> '1')
					{
						$new_curr = select_curriculum($matricnum);
						
						$stmt = $mysqli->prepare("SELECT * FROM progcourse b WHERE b.cCourseId = '$course_code' $new_curr LIMIT 1");
						$stmt->execute();
						$stmt->store_result();
						if ($stmt->num_rows == 0)
						{
							$stmt->close();
							echo 'Invalid course code <b>'.$course_code.'</b> found for '.$matricnum.' Process aborted';
							exit;
						}
					}*/

					// $stmt = $mysqli->prepare("SELECT * FROM examreg WHERE vMatricNo = '$matricnum' AND tSemester = ? AND cAcademicDesc = ?");
					// $stmt->bind_param("is", $_REQUEST["schl_semester"], $_REQUEST["schl_session"]);
					// $stmt->execute();
					// $stmt->store_result();
					// if ($stmt->num_rows == 0)
					// {
					// 	$stmt->close();
					// 	fclose($handle);
					// 	chmod($file, 0755);
					// 	unlink($file) or die("Couldn't continue process ");
					// 	echo 'Matriculation number <b>'.$matricnum.'</b> has no exam registration record for the course '.$course_code.' in the selected semester and session. Process aborted';
					// 	exit;
					// }
					// $stmt->close();
							
					//if ($chk_mat_no <> '1')
					//{
						$listed_matnos_count++;
					//}
					$listed_matnos .= $matricnum."', '";
				}
				fclose($handle);
				

				
				if ($listed_matnos <> "'")
				{
					$listed_matnos = substr($listed_matnos, 0, strlen($listed_matnos)-3);
					
					$stmt = $mysqli->prepare("SELECT vMatricNo FROM s_m_t where vMatricNo in ($listed_matnos)");
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($vMatricNo);
					
					while ($stmt->fetch())
					{
						$valid_matnos .= $vMatricNo."', '";
						$valid_matnos_count++;
					}
					$stmt->close();
		
					if ($valid_matnos <> "'")
					{
						$valid_matnos = substr($valid_matnos, 0, strlen($valid_matnos)-3);
					}
				}
				
				$handle = fopen("$file", "r");
				
				$count = 0;
				$result_compted = 0;
				
				try
				{
					$mysqli->autocommit(FALSE);

					while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
					{
						$stmt = $mysqli->prepare("REPLACE INTO examreg_result_20242025 
						(vMatricNo,
						cCourseId,
						iobtained_comp,
						cgrade,
						cAcademicDesc, 
						tsemester,
						tdate
						)
						VALUE
						(?, ?, ?, ?, ?, ?, '$date2')");

						if (is_bool(strripos(strtolower($valid_matnos), $data[0])))
						{
							$invalid_matnos .= ($invalid_matnos_count+1).'. '.$data[0].'<br>';
							$invalid_matnos_count++;
							continue;
						}						
										
						/*if (check_examreg_history($data[0], $data[1]) == 0)
						{					
							$matno_exam_reg .= ($matno_exam_reg_count+1).'. '.$data[0].'-'.$data[1].'<br>';			
							$matno_exam_reg_count++;
							continue;
						}

						if (check_coursereg_history($data[0], $data[1]) == 0)
						{					
							$matno_course_reg .= ($matno_course_reg_count+1).'. '.$data[0].'-'.$data[1].'<br>';			
							$matno_course_reg_count++;
							continue;
						}*/
						
						$stmt->bind_param("ssdssi", $data[0], $data[1], $data[2], $data[3], $_REQUEST['schl_session'], $_REQUEST['schl_semester']);
						
						$stmt->execute();
						$count++;
					}
					$stmt->close();

					if ($count > 0)
					{
						log_actv('Uploaded '.$file);
						$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
					}
				}catch(Exception $e)
				{
					$count = 0;
					$mysqli->rollback(); //remove all queries from queue if error (undo)
					throw $e;
				}			
				fclose($handle);

				if ($count > 0)
				{
					$feddback = str_pad($count, 10).' out of '.str_pad($listed_matnos_count,10).' records uploaded successfully ';
				}else
				{
					//$feddback = str_pad($count, 10).' out of '.str_pad($listed_matnos_count,10).' records uploaded successfully ';
					$feddback = "No record uploaded";
				}		
				
				$feddback_ma = '';
				if ($invalid_matnos_count > 0)
				{
					$feddback .= '<br> Number of invalid matric numbers: '.$invalid_matnos_count;
					$feddback_ma = '<br><b>Invalid Numbers</b><br>'.$invalid_matnos;
				}
				
				$feddback_reg = '';
				if ($matno_course_reg_count > 0)
				{
					$feddback .= '<br> Numbers that did not register selected course: '.$matno_course_reg_count;
					$feddback_reg = '<br><b>Numbers that did not register selected course</b><br>'.$matno_course_reg;
				}
				
				if ($matno_exam_reg_count > 0)
				{
					$feddback .= '<br> Numbers that did not register for the exam of selected course (in the selected academic session and semester): '.$matno_exam_reg_count;
					$feddback_reg = '<br><b>Numbers that did not register  for the exam of selected course (in the selected academic session and semester)</b><br>'.$matno_exam_reg;
				}

				
				
				if ($invalid_matnos_count > 0 || $matno_course_reg_count > 0 || $matno_exam_reg_count > 0)
				{
					$feddback .= '<br> See them <a href="#" onclick="show_list()" style="text-decoration:none">here</a>+'.$feddback_ma.$feddback_reg;
				}
				
				echo $feddback;exit;
			}
		}				
		echo $feddback;exit;
	}
}else
{
	echo 'Time out. Logout and login to continue please';exit;
}


function check_examreg_history($vMatricNo, $courseId)
{
	$mysqli = link_connect_db();
	
	$stmt = $mysqli->prepare("SELECT ancilary_type FROM courses WHERE cCourseId = '$courseId' AND ancilary_type <> 'normal' AND ancilary_type <> 'normal_practical'");
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows == 1)
	{
		$stmt->close();
		return 1;
	}

	$stmt = $mysqli->prepare("SELECT * FROM examreg WHERE vMatricNo = ? AND cCourseId = ? AND tSemester = ? AND cAcademicDesc = ?");
	$stmt->bind_param("ssis", $vMatricNo, $courseId, $_REQUEST["schl_semester"], $_REQUEST["schl_session"]);
	$stmt->execute();
	$stmt->store_result();
	return $stmt->num_rows;
}


function check_coursereg_history($vMatricNo, $courseId)
{
	$mysqli = link_connect_db();

	$stmt = $mysqli->prepare("SELECT * FROM coursereg_arch WHERE vMatricNo = ? AND cCourseId = ?");
	$stmt->bind_param("ss", $vMatricNo, $courseId);
	$stmt->execute();
	$stmt->store_result();
	return $stmt->num_rows;
}



function compute_result($vMatricNo, $topupbacklog, $study_mode_01, $staff_study_center, $overall_ex, $course_reg_session)
{
	$mysqli = link_connect_db();

	$matric_num_no_ca = "";
	$matric_num_no_ca_count = 0;
	$matric_num_no_ex = "";
	$matric_num_no_ex_count = 0;
	$success_count = 0;
	$ccount = 0;
	try
	{
		$mysqli->autocommit(FALSE);
		$ccount++;
		$exam_score = 0;
		
		$stmt1 = $mysqli->prepare("SELECT iobtained_ca FROM examreg_result where vMatricNo = '$vMatricNo' AND cCourseId = ?  AND cAcademicDesc = ?");
		$stmt1->bind_param("ss", $_REQUEST['courseId1'], $course_reg_session);
		//$stmt1->bind_param("ss", $_REQUEST['courseId1'], $_REQUEST['schl_session']);
		$stmt1->execute();
		$stmt1->store_result();
		$stmt1->bind_result($standar_ca);
		$stmt1->fetch();
		$stmt1->close();
		
		//track mat. nos. without CA score
		if ($overall_ex < 100)
		{
			if ($standar_ca == 0.0)
			{
				$matric_num_no_ca_count++;
				$matric_num_no_ca .= $matric_num_no_ca_count.". ".$vMatricNo."<br>";
				//return;
			}
		}	

		$stmt1 = $mysqli->prepare("SELECT iobtained_ex FROM examreg_result where vMatricNo = '$vMatricNo' AND cCourseId = ?  AND cAcademicDesc = ?");
		$stmt1->bind_param("ss", $_REQUEST['courseId1'], $course_reg_session);
		//$stmt1->bind_param("ss", $_REQUEST['courseId1'], $_REQUEST['schl_session']);
		$stmt1->execute();
		$stmt1->store_result();
		$stmt1->bind_result($standar_ex);	
		$stmt1->fetch();
		$stmt1->close();
		
		//track mat. nos. without ex score
		if ($standar_ex == 0.0)
		{
			$matric_num_no_ex_count++;
			$matric_num_no_ex .= $matric_num_no_ex_count.". ".$vMatricNo."<br>";
			return;
		}

		if ($overall_ex < 100)
		{
			$iobtained_comp = $standar_ex + $standar_ca;
		}else
		{
			$iobtained_comp = $standar_ex;
		}		

		if ($iobtained_comp >= 70)
		{
			$cgrade_01 = 'A';
		}else if ($iobtained_comp >= 60 && $iobtained_comp <= 69)
		{
			$cgrade_01 = 'B';
		}else if ($iobtained_comp >= 50 && $iobtained_comp <= 59)
		{
			$cgrade_01 = 'C';
		}else if ($iobtained_comp >= 45 && $iobtained_comp <= 49)
		{
			$cgrade_01 = 'D';
		}else if ($iobtained_comp >= 40 && $iobtained_comp <= 44)
		{
			$cgrade_01 = 'E';
		}else 
		{
			$cgrade_01 = 'F';
		}

		$stmt1 = $mysqli->prepare("UPDATE examreg_result 
		SET iobtained_comp = $iobtained_comp, 
		cgrade = '$cgrade_01',
		tdate = '$date2' 
		WHERE vMatricNo = '$vMatricNo' 
		AND cCourseId = ?  
		AND cAcademicDesc = ?");
		
		$stmt1->bind_param("ss", $_REQUEST['courseId1'], $course_reg_session);
		//$stmt1->bind_param("ss", $_REQUEST['courseId1'], $_REQUEST['schl_session']);
		$stmt1->execute();
		$stmt1->close();

		$success_count++;

		log_actv('Computed result for '. $_REQUEST['courseId1'].' of '. $course_reg_session);
		return $success_count;
	}catch(Exception $e)
	{
		$mysqli->rollback(); //remove all queries from queue if error (undo)
		throw $e;
	}
}?>