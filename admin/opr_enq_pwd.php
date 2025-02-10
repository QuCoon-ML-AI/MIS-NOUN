<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$orgsetins = settns();

$staff_study_center = '';
if (isset($_REQUEST['user_centre']) && $_REQUEST['user_centre'] <> '')
{
	$staff_study_center = $_REQUEST['user_centre'];
}

if (isset($_REQUEST['save_cf']) && $_REQUEST['save_cf'] == '1' && isset($_REQUEST['currency_cf']) && $_REQUEST['currency_cf'] == '1')
{
	if ($_REQUEST['id_no'] == '0')//chk validity of AFN
	{
		$stmt = $mysqli->prepare("SELECT a.cSbmtd, a.iBeginLevel, a.cFacultyId, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, a.vLastName, a.vFirstName, a.vOtherName, e.vCityName, e.cStudyCenterId 
		from prog_choice a, programme b, obtainablequal c, studycenter e 
		where a.cProgrammeId = b.cProgrammeId 
		and b.cObtQualId = c.cObtQualId 
		and a.cStudyCenterId = e.cStudyCenterId
		and a.vApplicationNo = ?");
		$stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($cSbmtd_02, $iBeginLevel_02, $cFacultyId_01, $cProgrammeId_02, $vObtQualTitle_02, $vProgrammeDesc_02, $vLastName_02, $vFirstName_02, $vOtherName_02, $vCityName, $cStudyCenterId);
		
		if ($stmt->num_rows === 0)
		{
			echo 'Invalid application form number';exit;
		}
		$stmt->fetch();

		if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
		{
			echo 'Your study centre does not match that of the candidate<br>Direct candidate to his/her study centre for required action';exit;
		}
		

		if (!is_bool(strpos($vProgrammeDesc_02,"(d)")))
		{
			$vProgrammeDesc_02 = substr($vProgrammeDesc_02, 0, strlen($vProgrammeDesc_02)-4);
		}
		
		$who_is_this = str_pad($vLastName_02, 100).
		str_pad($vFirstName_02, 100).
		str_pad($vOtherName_02, 100).
		str_pad($vObtQualTitle_02, 100).
		str_pad($vProgrammeDesc_02, 100).
		str_pad($iBeginLevel_02, 100).
		str_pad($cFacultyId_01, 100).'#';
		
		$stmt->close();
	}else if ($_REQUEST['id_no'] == '1')//chk validity of mat. no.
	{
		$stmt = $mysqli->prepare("SELECT a.vApplicationNo, f.iStudy_level, f.tSemester, a.cSbmtd, a.cFacultyId, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, a.vLastName, a.vFirstName, a.vOtherName, g.vCityName, g.cStudyCenterId  
		from prog_choice a, programme b, obtainablequal c, afnmatric e, s_m_t f, studycenter g
		where a.cProgrammeId = b.cProgrammeId  
		and b.cObtQualId = c.cObtQualId 
		and e.vApplicationNo = a.vApplicationNo 
		and e.vMatricNo = f.vMatricNo 
		and f.cStudyCenterId = g.cStudyCenterId
		and e.vMatricNo = ?");
		$stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($vApplicationNo_01, $iStudy_level_01, $tSemester_01, $cSbmtd_01, $cFacultyId_01, $cProgrammeId_01, $vObtQualTitle_01, $vProgrammeDesc_01, $vLastName_01, $vFirstName_01, $vOtherName_01, $vCityName, $cStudyCenterId);
		
		if ($stmt->num_rows === 0)
		{	
			$stmt->close();			
			if (check_grad_student($_REQUEST["uvApplicationNo"]) == 0)
			{
				echo 'Invalid matriculation number';exit;
			}else
			{
				echo 'Matriculation number graduated';exit;
			}
		}
		$stmt->fetch();	
		
		if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
		{
			echo 'Your study centre does not match that of the candidate<br>Direct candidate to his/her study centre for required action';exit;
		}
		

		$vApplicationNo_01 = $vApplicationNo_01.'+';
		$who_is_this = str_pad($vApplicationNo_01, 100);		

		if (!is_bool(strpos($vProgrammeDesc_01,"(d)")))
		{
			$vProgrammeDesc_02 = substr($vProgrammeDesc_01, 0, strlen($vProgrammeDesc_01)-4);
		}
		
		$who_is_this .= str_pad($vLastName_01, 100).
		str_pad($vFirstName_01, 100).
		str_pad($vOtherName_01, 100).
		str_pad($vObtQualTitle_01, 100).
		str_pad($vProgrammeDesc_01, 100).
		str_pad($iStudy_level_01, 100).
		str_pad($tSemester_01, 100).
		str_pad($vCityName, 100).
		str_pad($cFacultyId_01, 100).'#';
		
		$stmt->close();
	}
	
	if (!isset($_REQUEST["conf"]))
	{
		$stmt = $mysqli->prepare("SELECT cblk, csuspe, cexpe, tempwith, permwith, rect_risn, rect_risn1 FROM rectional where vMatricNo = ? order by act_date desc limit 1");
		$stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($cblk_01, $csuspe, $cexpe, $tempwith, $permwith, $rect_risn_01, $rect_risn1_01);
		
		if ($stmt->num_rows > 0){$stmt->fetch();}
		$stmt->close();
		if (isset($cblk_01) && $cblk_01 == '1')
		{
			if ($_REQUEST['id_no'] == '0')
			{
				echo $who_is_this.'Application form number blocked.<br>('.$rect_risn_01.')';exit;
			}else if ($_REQUEST['id_no'] == '1')
			{
				echo $who_is_this.'Matriculation number blocked.<br>('.$rect_risn_01.')';exit;
			}
		}

		if (isset($csuspe) && $csuspe == '1')
		{
			if ($_REQUEST['id_no'] == '0')
			{
				echo $who_is_this.'Application form number suspended.<br>('.$rect_risn_01.')';exit;
			}else if ($_REQUEST['id_no'] == '1')
			{
				echo $who_is_this.'Matriculation number suspended.<br>('.$rect_risn_01.')';exit;
			}
		}

		if (isset($cexpe) && $cexpe == '1')
		{
			if ($_REQUEST['id_no'] == '0')
			{
				echo $who_is_this.'Application form number expelled.<br>('.$rect_risn_01.')';exit;
			}else if ($_REQUEST['id_no'] == '1')
			{
				echo $who_is_this.'Matriculation number expelled.<br>('.$rect_risn_01.')';exit;
			}
		}

		if (isset($tempwith) && $tempwith == '1')
		{
			if ($_REQUEST['id_no'] == '0')
			{
				echo $who_is_this.'Application form number temporarily withdrawn.<br>('.$rect_risn_01.')';exit;
			}else if ($_REQUEST['id_no'] == '1')
			{
				echo $who_is_this.'Matriculation number temporarily withdrawn.<br>('.$rect_risn_01.')';exit;
			}
		}

		if (isset($permwith) && $permwith == '1')
		{
			if ($_REQUEST['id_no'] == '0')
			{
				echo $who_is_this.'Application form number permanently withdrawn.<br>('.$rect_risn_01.')';exit;
			}else if ($_REQUEST['id_no'] == '1')
			{
				echo $who_is_this.'Matriculation number permanently withdrawn.<br>('.$rect_risn_01.')';exit;
			}
		}

		//if ($_REQUEST['whattodo'] == '0')
		//{
			if ($_REQUEST['id_no'] == '0')
			{			
				$stmt = $mysqli->prepare("select vPassword, vPasswordp from app_client
				where vApplicationNo = ?");
				$stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($vPassword_01, $vPasswordp_01);
				
				if ($stmt->num_rows === 0)
				{	
					$stmt->close();
					echo $who_is_this.'Password not yet set. May need to follow the link, \'Returning applicant\' on the home page<br> Note the middle drop-down box, is it application form number or matriculation number';exit;
				}else
				{
					$stmt->fetch();
					$stmt->close();
					//log_actv('Retrieved password for '.trim($_REQUEST["uvApplicationNo"]));
					//if ($vPasswordp_01 <> ''){echo $who_is_this.$vPasswordp_01;}else{echo $who_is_this.$vPassword_01;}exit;

					//echo $who_is_this.'Facility stepped down';exit;
				}
			}else if ($_REQUEST['id_no'] == '1')
			{
				$stmt = $mysqli->prepare("select vPassword, vPasswordp from rs_client where vMatricNo = ?");
				$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($vPassword_02, $vPasswordp_02);
				
				if ($stmt->num_rows === 0)
				{	
					$stmt->close();
					echo $who_is_this.'Password not yet set. May need to follow the link, \'Fresh student\' on the home page';exit;
				}else
				{
					$stmt->fetch();
					$stmt->close();
					//log_actv('Retrieve password for '.$_REQUEST["uvApplicationNo"]);
					//if ($vPasswordp_02 <> ''){echo $who_is_this.$vPasswordp_02;}else{echo $who_is_this.$vPassword_02;}exit;

					//echo $who_is_this.'Facility stepped down';exit;
				}
			}
		//}

		if ($_REQUEST['whattodo'] == '1')
		{
			if ($_REQUEST['id_no'] == '0')
			{
				echo $who_is_this.'Reset password for application form number?';exit;
			}else
			{
				echo $who_is_this.'Reset password for matriculation number?';exit;
			}
		}
	}else if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == 1)
	{
		if ($_REQUEST['whattodo'] == '1')
		{
			if ($_REQUEST['id_no'] == '0')
			{
				// $stmt = $mysqli->prepare("select vMatricNo from afnmatric where vApplicationNo = ?");
				// $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
				// $stmt->execute();
				// $stmt->store_result();
				// $stmt->bind_result($vMatricNo_01);
				
				// if ($stmt->num_rows <> 0)
				// {
				// 	$stmt->execute();
				// 	echo $who_is_this.'Matriculation number for application from number already logged in.<p> Kindly advise candidate to access his/her form via his/her (student) home page';exit;
				// }
				// $stmt->close();
				
				// $uvApplicationNo_a = $_REQUEST['uvApplicationNo'];
				// $uvApplicationNo_b = $_REQUEST['uvApplicationNo'];
				// $uvApplicationNo_c = $_REQUEST['uvApplicationNo'];
				
				$stmt = $mysqli->prepare("update app_client set vPassword = md5(?), cpwd = '1' where vApplicationNo = ?");
				$stmt->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST['uvApplicationNo']);
				$stmt->execute();
				$stmt->close();
				
				$matches = array();
				preg_match_all('/(\S[^:]+): (\d+)/', $mysqli->info, $matches); 
				
				if ($matches[1] == 0)
				{	
					echo $who_is_this.'Password not yet set. Kindly advise candidate to follow the link, \'Returning applicant\' on the home page';exit;
				}else
				{
					log_actv('Reset password for '.trim($_REQUEST["uvApplicationNo"]));
					echo $who_is_this.'Password reset successful';exit;
				}
			}else if ($_REQUEST['id_no'] == '1')
			{
				$stmt = $mysqli->prepare("update rs_client set vPassword = md5(?), cpwd = '1' where vMatricNo = ?");
				$stmt->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST['uvApplicationNo']);
				$stmt->execute();
				
				$matches = array();
				preg_match_all('/(\S[^:]+): (\d+)/', $mysqli->info, $matches); 
				
				$stmt->close();
				if ($matches[1] == 0)
				{	
					echo $who_is_this.'Password not yet set. Kindly advise candidate to follow the link, \'Fresh student\' on the home page';exit;
				}else
				{
					log_actv('Reset password for '.trim($_REQUEST["uvApplicationNo"]));
					echo $who_is_this.'Password reset successful';exit;
				}
			}
		}
	}
}?>