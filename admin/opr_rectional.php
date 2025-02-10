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

date_default_timezone_set('Africa/Lagos');
$date2 = date("Y-m-d h:i:s");

if (isset($_REQUEST['ilin']) && $_REQUEST['ilin'] <> '')
{	
	$mask= '';
	
	if (isset($_REQUEST["uvApplicationNo"]))
	{
		$mask = get_mask($_REQUEST["uvApplicationNo"]);
	

		$stmt = $mysqli->prepare("select * from afnmatric where vMatricNo = ?");
		$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);	
		$stmt->execute();
		$stmt->store_result();
			
		if ($stmt->num_rows === 0)
		{
			$stmt->close();
			echo 'Invalid matriculation number';exit;
		}else if (check_grad_student($_REQUEST["uvApplicationNo"]) == 1)
		{
			echo 'Matriculation number graduated';exit;
		}
		$stmt->close();
	
	
		$stmt = $mysqli->prepare("select a.cFacultyId, a.vApplicationNo, a.vLastName, a.vFirstName, a.vOtherName, b.vObtQualTitle, a.cProgrammeId, c.vProgrammeDesc, a.iStudy_level, a.tSemester, a.cStudyCenterId, c.cEduCtgId  
		from s_m_t a, obtainablequal b, programme c
		where a.cObtQualId = b.cObtQualId
		and a.cProgrammeId = c.cProgrammeId
		and vMatricNo = ?");
		$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
		$stmt->execute();
		$stmt->store_result();
		
		$stmt->bind_result($cFacultyId_01, $vApplicationNo_01, $vLastName_01, $vFirstName_01, $vOtherName_01, $vObtQualTitle_01, $cProgrammeId_01, $vProgrammeDesc_01, $iStudy_level_01, $tSemester_01, $cStudyCenterId, $cEduCtgId);
		$stmt->fetch();

		if ($_REQUEST['mm'] == 8 && $cEduCtgId <> 'PGX' && $cEduCtgId <> 'PGY' && $cEduCtgId <> 'PGZ' && $cEduCtgId <> 'PRX')
		{
			echo 'Matriculaton number must be that of an MPhil, PhD or postgraduate student'; exit;
		}else if ($_REQUEST['mm'] == 1 && ($cEduCtgId == 'PGZ' || $cEduCtgId == 'PRX'))
		{
			echo 'Matriculaton number must be that of an undergraduate, PGD or Masters student'; exit;
		}else if ($_REQUEST['sRoleID'] == 29 && is_bool(strpos($cProgrammeId_01, 'CHD')))
		{
			echo '*Matriculaton number must be that of a certificate student in CHRD'; exit;
		}else if ($_REQUEST['sRoleID'] == 26 && is_bool(strpos($cProgrammeId_01, 'DEG')))
		{
			echo '*Matriculaton number must be that of a certificate student in DE&GS';exit;
		}

		if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
		{
			echo 'Your study centre does not match that of the student<br>Direct student to his/her study centre for required action';exit;
		}
		
		if (!is_bool(strpos($vProgrammeDesc_01,"(d)")))
		{
			$vProgrammeDesc_01 = substr($vProgrammeDesc_01, 0, strlen($vProgrammeDesc_01)-4);
		}

		$who_is_this = str_pad($vApplicationNo_01, 100).'+'.
		str_pad($vLastName_01, 100).
		str_pad($vFirstName_01, 100).
		str_pad($vOtherName_01, 100).
		str_pad($vObtQualTitle_01, 100).
		str_pad($vProgrammeDesc_01, 100).
		str_pad($iStudy_level_01, 100).
		str_pad($tSemester_01, 100).
		str_pad($cFacultyId_01, 100).
		str_pad($mask, 100).'#';
		$stmt->close();
	}

	if (!isset($_REQUEST['conf']))
	{	
		$feedback = '';
		
		if (isset($_REQUEST["uvApplicationNo"]))
		{
			$stmt1 = $mysqli->prepare("SELECT permwith, 
			act_date, 
			cblk, 
			rect_risn, 
			period1, 
			period2, 
			csuspe, 
			cexpe, 
			tempwith, 
			permwith,
			(NOW() >= period1) date_wall,
			regist, 
			stdycentre, 
			ictech,
			period1 
			FROM rectional 
			WHERE vMatricNo = ? 
			AND stdycentre = '0' 
			ORDER BY act_date 
			DESC LIMIT 1");
			$stmt1->bind_param("s", $_REQUEST['uvApplicationNo']);
			$stmt1->execute();
			$stmt1->store_result();
			
			if ($stmt1->num_rows > 0)
			{
				$stmt1->bind_result($permwith, $act_date, $cblk, $rect_risn, $period1, $period2, $csuspe, $cexpe, $tempwith, $permwith, $date_wall, $regist, $stdycentre, $ictech, $period1);
				$stmt1->fetch();
				$stmt1->close();
				
				if ($_REQUEST['corect'] < 5)
				{
					if ($cblk == '1')
					{
						$feedback = 'Student already blocked <br>on<br>'.formatdate($act_date,'fromdb').'<br>'.$rect_risn;
					}else if ($csuspe == '1')
					{
						$feedback = 'Student already suspended<br>on<br>'.formatdate($act_date,'fromdb').'<br>'.$rect_risn.'<br>To lapse on '.formatdate($period1,'fromdb');
					}else if ($cexpe == '1')
					{
						$feedback = 'Student already expelled<br>on<br>'.formatdate($act_date,'fromdb').'<br>'.$rect_risn;
					}else if ($tempwith == '1')
					{
						$feedback = 'Student already temporarily withdrawn<br>on<br>'.formatdate($act_date,'fromdb').'<br>'.$rect_risn;
					}else if ($permwith == '1')
					{
						$feedback = 'Student already permanently withdrawn<br>on<br>'.formatdate($act_date,'fromdb').'<br>'.$rect_risn;
					}
				}

				if ($_REQUEST['corect'] == 5)//unblock
				{
					if ($cblk == '0')
					{
						$feedback = 'Student already unblocked<br>on<br>'.formatdate($act_date,'fromdb').'<br>'.$rect_risn;
					}else if ($stdycentre == '1')
					{
						$feedback =  'Student can only be unblocked at the Study centre'; exit;
					}else if ($ictech == '1')
					{
						$feedback =  'Student can only be unblocked at MIS'; exit;
					}
				}else if ($_REQUEST['corect'] == 6)//lift sus
				{			
					if ($csuspe == '0')
					{
						$feedback = 'Suspension already lifted for student<br>on<br>'.formatdate($act_date,'fromdb').'<br>'.$rect_risn;
					}
				}else if ($_REQUEST['corect'] == 7)//recall from exp
				{
					if ($cexpe == '0')
					{
						$feedback = 'Student already re-called from expulsion<br>on<br>'.formatdate($act_date,'fromdb').'<br>'.$rect_risn;
					}
				}else if ($_REQUEST['corect'] == 8)//recal from with
				{
					if ($tempwith == '0' && $permwith <> '1')
					{
						$feedback = 'Student already temporarily withdrawn<br>on<br>'.formatdate($act_date,'fromdb').'<br>'.$rect_risn;
					}else if ($permwith == '0' && $tempwith <> '1')
					{
						$feedback = 'Student already permanently withdrawn<br>on<br>'.formatdate($act_date,'fromdb').'<br>'.$rect_risn;
					}
				}

				if ($feedback <> '')
				{
					echo $who_is_this.$feedback;exit;
				}
			}		

			
			if ($_REQUEST['corect'] == 0)
			{
				echo $who_is_this.'Block student?';exit;
			}else if ($_REQUEST['corect'] == 1)
			{
				echo $who_is_this.'Suspend student?';exit;
			}else if ($_REQUEST['corect'] == 2)
			{
				echo $who_is_this.'Expell student?';exit;
			}else if ($_REQUEST['corect'] == 3)
			{
				echo $who_is_this.'Withdraw student temporarily?';exit;
			}else if ($_REQUEST['corect'] == 4)
			{
				echo $who_is_this.'Withdraw student permanently?';exit;
			}else if ($_REQUEST['corect'] == 5)
			{
				echo $who_is_this.'Unblock student?';exit;
			}else if ($_REQUEST['corect'] == 6)
			{
				echo $who_is_this.'Lift suspension for student?';exit;
			}else if ($_REQUEST['corect'] == 7)
			{
				echo $who_is_this.'Recall student from expulsion?';exit;
			}else if ($_REQUEST['corect'] == 8)
			{
				echo $who_is_this.'Recall student from temporary withdrawal?';exit;
			}
		}else if ($_REQUEST['corect'] == 0)
		{
			echo 'Block students?';exit;
		}
	}else if (isset($_REQUEST['conf']))
	{
		
		
		if ($_REQUEST['corect'] == 0)//block
		{
			if (isset($_REQUEST['afn_list']))
			{
				$invalid_afn = '';
				$invalid_afn_count = 0;

				$valid_afn = '';
				$valid_afn_count = 0;

				$splitLine = explode("\n", str_replace("\r", "", $_REQUEST["afn_list"]));

				$stmt_a = $mysqli->prepare("REPLACE INTO rectional SET
				vMatricNo = ?, 
				rect_risn = ?,
				cblk = '1',
				regist  = '1',
				act_date = '$date2'");

				foreach ($splitLine as $val_arr)
				{
					$stmt = $mysqli->prepare("SELECT * FROM s_m_t WHERE vMatricNo = '$val_arr'");
					$stmt->execute();
					$stmt->store_result();
					
					if ($stmt->num_rows == 0)
					{
						$invalid_afn_count++;
						$invalid_afn .= $invalid_afn_count.'. '.$val_arr.'<br>';
						$stmt->close();
						continue;
					}else
					{
						$valid_afn_count++;
						$valid_afn .= $valid_afn_count.'. '.$val_arr.'<br>';
						$stmt_a->bind_param("ss", $val_arr, $_REQUEST['rect_risn']);
						$stmt_a->execute();
					}
					$stmt->close();
				}
				//$stmt_a->close();

				if ($valid_afn_count > 0)
				{
					log_actv('Blocked '.$valid_afn_count.' matric. numbers');
				}

				echo 'Blocked numbers<br>'.$valid_afn.'<p>Invalid numbers<br>'.$invalid_afn;
				exit;
			}else if (isset($_REQUEST['uvApplicationNo']))
			{
				$stmt = $mysqli->prepare("INSERT INTO rectional SET
				vMatricNo = ?, 
				rect_risn = ?,
				cblk = '1',
				regist  = '1',
				act_date = '$date2'");
				$stmt->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST['rect_risn']);
				$stmt->execute();
				$stmt->close();
				$logmsg = 'Blocked '.$_REQUEST["uvApplicationNo"];
				$feedback = 'Student blocked successfully.';
			}
			
			//$stmt->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST['rect_risn']);
							
			// $logmsg = 'Blocked '.$_REQUEST["uvApplicationNo"];
			// $feedback = 'Student blocked successfully.';
		}else 
		{
			if ($_REQUEST['corect'] == 1)//susp
			{
				$a = formatdate($_REQUEST["period1"],'todb');
					
				$stmt = $mysqli->prepare("INSERT INTO rectional SET
				period1 = ?, 
				vMatricNo = ?, 
				rect_risn = ?,
				csuspe = '1',
				regist  = '1',
				act_date = '$date2'");
				$stmt->bind_param("sss", $a, $_REQUEST['uvApplicationNo'], $_REQUEST['rect_risn']);
								
				$logmsg = 'Suspended '.$_REQUEST["uvApplicationNo"];
				$feedback = 'Student suspended successfully.';
			}else if ($_REQUEST['corect'] == 2)//exp
			{
				$stmt = $mysqli->prepare("INSERT INTO rectional SET
				vMatricNo = ?, 
				rect_risn = ?,
				cexpe = '1',
				regist  = '1',
				act_date = '$date2'");
				$stmt->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST['rect_risn']);
							
				$logmsg = 'Expelled '.$_REQUEST["uvApplicationNo"];
				$feedback = 'Student expelled successfully.';
			}else if ($_REQUEST['corect'] == 3)//with temp
			{	
				//$a = formatdate($_REQUEST["period1"],'todb');
					
				$stmt = $mysqli->prepare("INSERT INTO rectional SET act_date = NOW(),
				vMatricNo = ?, 
				rect_risn = ?,
				tempwith = '1',
				regist  = '1',
				act_date = '$date2'");
				//$stmt->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST['rect_risn']);
					
				$logmsg ='Temporarily withdraw '.$_REQUEST["uvApplicationNo"];
				$feedback = 'Student temporarily withdrawn successfully.';
			}else if ($_REQUEST['corect'] == 4)//with perm
			{
				$stmt = $mysqli->prepare("INSERT INTO rectional SET
				vMatricNo = ?, 
				rect_risn = ?,
				permwith = '1',
				regist = '1',
				act_date = '$date2'");
				//$stmt->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST['rect_risn']);
					
				$logmsg ='Permanently withdraw '.$_REQUEST["uvApplicationNo"];
				$feedback = 'Student permanently withdrawn successfully.';
			}else if ($_REQUEST['corect'] == 5)//unblock
			{
				if (isset($_REQUEST['afn_list']))
				{
					$invalid_afn = '';
					$invalid_afn_count = 0;

					$valid_afn = '';
					$valid_afn_count = 0;

					$splitLine = explode("\n", str_replace("\r", "", $_REQUEST["afn_list"]));

					$stmt_a = $mysqli->prepare("INSERT INTO rectional SET
					vMatricNo = ?, 
					rect_risn = ?,
					cblk = '0',
					regist  = '1',
					act_date = '$date2'");

					foreach ($splitLine as $val_arr)
					{
						$stmt = $mysqli->prepare("SELECT * FROM s_m_t WHERE vMatricNo = '$val_arr'");
						$stmt->execute();
						$stmt->store_result();
						
						if ($stmt->num_rows == 0)
						{
							$invalid_afn_count++;
							$invalid_afn .= $invalid_afn_count.'. '.$val_arr.'<br>';
							$stmt->close();
							continue;
						}else
						{
							$valid_afn_count++;
							$valid_afn .= $valid_afn_count.'. '.$val_arr.'<br>';
							$stmt_a->bind_param("ss", $val_arr, $_REQUEST['rect_risn']);
							$stmt_a->execute();
						}
						$stmt->close();
					}
					//$stmt_a->close();

					if ($valid_afn_count > 0)
					{
						log_actv('Ublocked '.$valid_afn_count.' matric. numbers');
					}

					echo 'Unblocked numbers<br>'.$valid_afn.'<p>Invalid numbers<br>'.$invalid_afn;
					exit;
				}else
				{
					$stmt = $mysqli->prepare("INSERT INTO rectional SET
					vMatricNo = ?, 
					rect_risn = ?,
					cblk = '0',
					regist  = '1',
					act_date = '$date2'");
						
					$logmsg ='Unblocked '.$_REQUEST["uvApplicationNo"];
					$feedback = 'Student unblocked successfully.';
				}
			}else if ($_REQUEST['corect'] == 6)//lift sus
			{			
				$stmt = $mysqli->prepare("INSERT INTO rectional SET
				vMatricNo = ?,
				rect_risn = ?,
				csuspe = '0', 
				regist  = '1',
				act_date = '$date2'");
				$stmt->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST['rect_risn']);
				
				// $stmt = $mysqli->prepare("update rectional set 
				// csuspe = '0',
				// period2 = now(), 
				// rect_risn1 = ? 
				// where vMatricNo = ? 
				// and act_date = ? 
				// and stdycentre = '0'");
					
				$logmsg ='Recalled '.$_REQUEST["uvApplicationNo"].' from suspension';
				$feedback = 'Suspension lifted for Student successfully.';
			}else if ($_REQUEST['corect'] == 7)//recall from exp
			{
				$stmt = $mysqli->prepare("INSERT INTO rectional SET
				vMatricNo = ?, 
				rect_risn = ?,
				cexpe = '0',
				regist  = '1',
				act_date = '$date2'");
				//$stmt->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST['rect_risn']);
				
				// $stmt = $mysqli->prepare("update rectional set 
				// cexpe = '0', 
				// cre_expe = '1', 
				// period2 = now(), 
				// rect_risn1 = ? 
				// where vMatricNo = ? 
				// and act_date = ? 
				// and stdycentre = '0'");
								
				$logmsg ='Recalled '.$_REQUEST["uvApplicationNo"].' from expulsion';
				$feedback = 'Student recalled successfully.';
			}else if ($_REQUEST['corect'] == 8)//recal from with
			{
				// if ($tempwith == 1)
				// {
					$stmt = $mysqli->prepare("INSERT INTO rectional SET 
					vMatricNo = ?, 
					rect_risn = ?,
					tempwith = '0',
					permwith = '0',
					regist = '1',
				    act_date = '$date2'");
					//$stmt->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST['rect_risn']);
					
					// $stmt = $mysqli->prepare("update rectional set 
					// tempwith = '0',
					// period2 = now(), 
					// rect_risn1 = ? 
					// where vMatricNo = ? 
					// and act_date = ? 
					// and stdycentre = '0'");
					$logmsg ='Recalled '.$_REQUEST["uvApplicationNo"].' from temporary withdrawal';
				// }else if ($permwith == 1)
				// {
					// $stmt = $mysqli->prepare("INSERT INTO rectional SET
					// vMatricNo = ?, 
					// rect_risn = ?,
					// permwith = '0',
					// regist = '1'");
					//$stmt->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST['rect_risn']);
					
					// $stmt = $mysqli->prepare("update rectional set 
					// permwith = '0',
					// period2 = now(), 
					// rect_risn1 = ? 
					// where vMatricNo = ? 
					// and act_date = ? 
					// and stdycentre = '0'");
				// 	$logmsg ='Recalled '.$_REQUEST["uvApplicationNo"].' from permanent withdrawal';
				// }
				
				$feedback = 'Student recalled successfully.';
			}

			if (!isset($_REQUEST['afn_list']) && $_REQUEST['corect'] <> 1)
			{	
				$stmt->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST['rect_risn']);
			}

			if (!isset($_REQUEST['afn_list']))
			{
				$stmt->execute();
			}

			$stmt->close();
		}
			
		if ($logmsg <> '')
		{
			log_actv($logmsg);
			echo $who_is_this.$feedback; exit;
		}
	}
}?>
