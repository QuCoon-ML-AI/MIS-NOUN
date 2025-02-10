<?php
require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$orgsetins = settns();
$staff_study_center = $_REQUEST['staff_study_center'];

if (isset($_REQUEST['save_cf']) && $_REQUEST['save_cf'] == '1' && isset($_REQUEST['currency_cf']) && $_REQUEST['currency_cf'] == '1')
{	
	$who_is_this = '';
	$grad_status = '';

	$vmask = '';
	
	$prog_choice = "prog_choice";
	$pers_info = "pers_info";
	$afnmatric = "afnmatric";
	$s_m_t = "s_m_t";

	if ($_REQUEST['id_no'] == '0')
	{		
		if (isset($_REQUEST['arch_mode_hd']) && $_REQUEST['arch_mode_hd'] == '1')
    	{
			$prog_choice = "arch_prog_choice";
			$pers_info = "arch_pers_info";
			$afnmatric = "arch_afnmatric";

			$mysqli = link_connect_db_arch();
		}

		$stmt = $mysqli->prepare("SELECT a.cSbmtd, a.iBeginLevel, a.cFacultyId, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, a.vLastName, a.vFirstName, a.vOtherName, e.vCityName, e.cStudyCenterId
		from $prog_choice a, programme b, obtainablequal c, studycenter e
		where a.cProgrammeId = b.cProgrammeId 
		and b.cObtQualId = c.cObtQualId 
		and a.cStudyCenterId = e.cStudyCenterId
		and a.vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($cSbmtd_01, $iBeginLevel_01, $cFacultyId_01, $cProgrammeId_01, $vObtQualTitle_01, $vProgrammeDesc_01, $vLastName_01, $vFirstName_01, $vOtherName_01, $vCityName, $cStudyCenterId);

		if ($stmt->num_rows == 0)
		{	 
			$stmt->close();
			if (isset($_REQUEST['arch_mode_hd']) && $_REQUEST['arch_mode_hd'] == '1')
			{
				echo 'Application form number not in the archive';exit; 
			}else
			{
				echo 'Invalid application form numbers';exit;
			}
		}
		$stmt->fetch();

		/*if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
		{
			echo 'Your study centre does not match that of the candidate<br>Direct candidate to his/her study centre for required action';exit;
		}*/
				
		if (!is_bool(strpos($vProgrammeDesc_01,"(d)")))
		{
			$vProgrammeDesc_01 = substr($vProgrammeDesc_01, 0, strlen($vProgrammeDesc_01)-4);
		}		
		
		$vmask = get_pp_pix($_REQUEST["uvApplicationNo"]);

		$who_is_this = str_pad($vLastName_01, 100).
		str_pad($vFirstName_01, 100).
		str_pad($vOtherName_01, 100).
		str_pad($vObtQualTitle_01, 100).
		str_pad($vProgrammeDesc_01, 100).
		str_pad($iBeginLevel_01, 100).
		str_pad('1', 100).
		str_pad($vCityName, 100).
		str_pad($cFacultyId_01, 100).
		str_pad($vmask, 100).'#';
		
		$stmt->close();
	}else if ($_REQUEST['id_no'] == '1')
	{
		if (isset($_REQUEST['arch_mode_hd']) && $_REQUEST['arch_mode_hd'] == '1')
    	{
			$s_m_t = "arch_s_m_t";
			$prog_choice = "arch_prog_choice";
			$pers_info = "arch_pers_info";
			$afnmatric = "arch_afnmatric";
			$mysqli = link_connect_db_arch();
		}
		
		// $stmt = $mysqli->prepare("SELECT a.vApplicationNo, f.iStudy_level, f.tSemester, a.cSbmtd, a.cFacultyId, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, a.vLastName, a.vFirstName, a.vOtherName, g.vCityName, g.cStudyCenterId 
		// FROM $prog_choice a, programme b, obtainablequal c, $afnmatric e, $s_m_t f, studycenter g
		// where a.cProgrammeId = b.cProgrammeId  
		// and b.cObtQualId = c.cObtQualId 
		// and e.vApplicationNo = a.vApplicationNo 
		// and e.vMatricNo = f.vMatricNo 
		// and f.cStudyCenterId = g.cStudyCenterId
		// and e.vMatricNo = ?");

		$stmt = $mysqli->prepare("SELECT f.vApplicationNo, f.iStudy_level, f.tSemester, f.cFacultyId, f.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, f.vLastName, f.vFirstName, f.vOtherName, g.vCityName, g.cStudyCenterId 
		FROM programme b, obtainablequal c, $afnmatric e, $s_m_t f, studycenter g
		where  b.cObtQualId = c.cObtQualId
		and e.vMatricNo = f.vMatricNo 
		and f.cStudyCenterId = g.cStudyCenterId
		and e.vMatricNo = ?");

		$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
		$stmt->execute();
		$stmt->store_result();
		
		$stmt->bind_result($vApplicationNo_01, $iStudy_level_01, $tSemester_01, $cFacultyId_01, $cProgrammeId_01, $vObtQualTitle_01, $vProgrammeDesc_01, $vLastName_01, $vFirstName_01, $vOtherName_01, $vCityName, $cStudyCenterId);
		
		if ($stmt->num_rows == 0)
		{
			$stmt->close();
			if (isset($_REQUEST['arch_mode_hd']) && $_REQUEST['arch_mode_hd'] == '1')
			{
				echo 'Matriculation number not in the archive';exit; 
			}else
			{
				echo 'Invalid matriculation number';exit;
			}
		}else
		{
			$stmt->fetch();
				
			if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
			{
				echo 'Your study centre does not match that of the candidate<br>Direct candidate to his/her study centre for required action';exit;
			}
			
			if (!is_bool(strpos($vProgrammeDesc_01,"(d)")))
			{
				$vProgrammeDesc_01 = substr($vProgrammeDesc_01, 0, strlen($vProgrammeDesc_01)-4);
			}
			
			if (!is_bool(strpos($vProgrammeDesc_01,"(d)")))
			{
				$vProgrammeDesc_01 = substr($vProgrammeDesc_01, 0, strlen($vProgrammeDesc_01)-4);
			}

			$vmask = get_pp_pix($_REQUEST["uvApplicationNo"]);

			$who_is_this = str_pad($vLastName_01, 100).
			str_pad($vFirstName_01, 100).
			str_pad($vOtherName_01, 100).
			str_pad($vObtQualTitle_01, 100).
			str_pad($vProgrammeDesc_01, 100).
			str_pad($iStudy_level_01, 100).
			str_pad($tSemester_01, 100).
			str_pad($vCityName, 100).
			str_pad($cFacultyId_01, 100).
			str_pad($vmask, 100).'#';
		}
		$stmt->close();
	}
		
	$str_val = '';
	if ($_REQUEST['id_no'] == '0')
	{
		$mysqli_loc = link_connect_db();
		$stmt = $mysqli_loc->prepare("SELECT cblk, rect_risn, rect_risn, act_date FROM rectional WHERE vMatricNo = ? ORDER BY act_date DESC LIMIT 2");
		$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
		$stmt->execute();
		$result = $stmt->store_result();
				
		if ($stmt->num_rows > 0)
		{
			$stmt->bind_result($cblk_01, $rect_risn_01, $rect_risn1_01, $act_date_01);
			while ($stmt->fetch())
			{
				if ($cblk_01 == '1')
				{
					$str_val .= 'Access to application form blocked on '.formatdate(substr($act_date_01,0,10),'fromdb').' '.substr($act_date_01,11,8).'.<br>('.$rect_risn_01.')<br>';
				}else if ($cblk_01 == '0')
				{
					$str_val .= 'Access to application form unblocked on '.formatdate(substr($act_date_01,0,10),'fromdb').' '.substr($act_date_01,11,8).'.<br>('.$rect_risn1_01.')<br>';
				}
			}
		}
		$stmt->close();
		
		
		$stmt = $mysqli->prepare("select b.vProcessNote, b.cSbmtd, b.cSCrnd, b.cqualfd, b.iprnltr
		from $pers_info a, $prog_choice b where a.vApplicationNo = b.vApplicationNo
		and a.vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($vProcessNote_02, $cSbmtd_02, $cSCrnd_02, $cqualfd_02, $iprnltr_02);
		
		$stmt->num_rows;
		$stmt->fetch();
		$stmt->close();
		
		if ($cqualfd_02 == '2')
		{
			$str_val .= '<p>Candidate screened qualified';
		}else if ($cqualfd_02 == '1')
		{
			$str_val .= '<p>Application form submitted	';
		}else if ($cqualfd_02 == '0')
		{
			$str_val .= '<p>Application form not submitted';
		}

		if ($iprnltr_02 == 0)
		{
			$str_val .= '<p>Candidate has not printed admission letter';
		}else if ($iprnltr_02 <> 0)
		{
			$str_val .= '<p>Candidate has printed admission letter '.$iprnltr_02. ' time(s)';
		} 
		
		if ($cSbmtd_02 == '2')
		{
			$stmt = $mysqli->prepare("select vMatricNo from $afnmatric where vApplicationNo = ?");
			$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($vMatricNo_01);
			$stmt->fetch();
			
			$str_val .= '<p>Matriculation number ('.$vMatricNo_01.') issued. Form can only be viewed';
		}
		log_actv('checked status of '.$_REQUEST['uvApplicationNo']);
		echo $who_is_this.$str_val;
	}else if ($_REQUEST['id_no'] == '1')
	{
		$mysqli_loc = link_connect_db();
		$stmt = $mysqli_loc->prepare("SELECT act_date, 
		cblk, 
		csuspe, 
		cexpe, 
		cre_expe, 
		tempwith, 
		permwith, 
		period1, 
		period2, 
		re_call, 
		rect_risn, 
		stdycentre, 
		regist, 
		ictech FROM rectional WHERE vMatricNo = ? ORDER BY act_date DESC LIMIT 2");
		$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
		$stmt->execute();
		$stmt->store_result();
		
		if ($stmt->num_rows > 0)
		{
			$stmt->bind_result($act_date_02, $cblk_02, $csuspe_02, $cexpe_02, $cre_expe_02, $tempwith_02, $permwith_02, $period1_02, $period2_02, $re_call_02, $rect_risn_02, $stdycentre_02, $regist_02, $ictech_02);

			$act_date_02_prev = '';
			$cblk_02_prev = '';
			$csuspe_02_prev = '';
			
			$cexpe_02_prev = '';
			$tempwith_02_prev = '';
			$permwith_02_prev = '';
			
			$period1_02_prev = '';
			$period2_02_prev = '';
			$rect_risn_02_prev = '';
			
			$stdycentre_02_prev = '';
			$regist_02_prev = '';
			$ictech_02_prev = '';

			$itera = 0;
			while ($stmt->fetch())
			{
				if ($itera == 0)
				{
					$act_date_02_prev = $act_date_02;
					$cblk_02_prev = $cblk_02;
					$csuspe_02_prev = $csuspe_02;
					
					$cexpe_02_prev = $cexpe_02;
					$tempwith_02_prev = $tempwith_02;
					$permwith_02_prev = $permwith_02;
					
					$period1_02_prev = $period1_02;
					$period2_02_prev = $period2_02;
					$rect_risn_02_prev = $rect_risn_02;
					
					$stdycentre_02_prev = $stdycentre_02;
					$regist_02_prev = $regist_02;
					$ictech_02_prev = $ictech_02;
				}
				$itera++;
			}
			$stmt->close();

			if ($cblk_02_prev <> $cblk_02)
			{
				if ($cblk_02_prev == '0')
				{
					$str_val .= 'Student unblocked on '.formatdate(substr($act_date_02_prev,0,10),'fromdb').' '.substr($act_date_02_prev,11,8).'.<br>('.$rect_risn_02_prev.')<br>';
				}else if ($cblk_02_prev == '1')
				{
					$str_val .= 'Student blocked on '.formatdate(substr($act_date_02_prev,0,10),'fromdb').' '.substr($act_date_02_prev,11,8).'.<br>('.$rect_risn_02_prev.')<br>';
				}
				
				if ($cblk_02 == '1')
				{
					$str_val .= 'Student blocked on '.formatdate(substr($act_date_02,0,10),'fromdb').' '.substr($act_date_02,11,8).'.<br>('.$rect_risn_02.')<br>';
				}else if ($cblk_02 == '0')
				{
					$str_val .= 'Student unblocked on '.formatdate(substr($act_date_02,0,10),'fromdb').' '.substr($act_date_02,11,8).'.<br>('.$rect_risn_02.')<br>';
				}
			}

			$str_val .= '<p>';
			if ($csuspe_02_prev <> $csuspe_02)
			{
				if ($csuspe_02_prev == '0')
				{
					$str_val .= 'Suspension lifted for student on '.formatdate(substr($act_date_02_prev,0,10),'fromdb').' '.substr($act_date_02_prev,11,8).'.<br>('.$rect_risn_02_prev.')<br>';
				}else if ($csuspe_02_prev == '1')
				{
					$str_val .= 'Student suspended on '.formatdate(substr($act_date_02_prev,0,10),'fromdb').' '.substr($act_date_02_prev,11,8).'.<br>('.$rect_risn_02_prev.')<br>To lapase on '.formatdate(substr($period2_02_prev,0,10),'fromdb').'<br>';
				}
				
				if ($csuspe_02 == '1')
				{
					$str_val .= 'Student suspended on '.formatdate(substr($act_date_02,0,10),'fromdb').' '.substr($act_date_02,11,8).'.<br>('.$rect_risn_02.')<br>To lapase on '.formatdate(substr($period2_02_prev,0,10),'fromdb').'<br>';
				}else if ($csuspe_02 == '0')
				{
					$str_val .= 'Suspension lifted for student on '.formatdate(substr($act_date_02,0,10),'fromdb').' '.substr($act_date_02,11,8).'.<br>('.$rect_risn_02.')<br>';
				}
			}			
			

			$str_val .= '<p>';
			if ($cexpe_02_prev <> $cexpe_02)
			{
				if ($cexpe_02_prev == '0')
				{
					$str_val .= 'Student called back from expulsion on '.formatdate(substr($act_date_02_prev,0,10),'fromdb').' '.substr($act_date_02_prev,11,8).'.<br>('.$rect_risn_02_prev.')<br>';
				}else if ($cexpe_02_prev == '1')
				{
					$str_val .= 'Student expelled on '.formatdate(substr($act_date_02_prev,0,10),'fromdb').' '.substr($act_date_02_prev,11,8).'.<br>('.$rect_risn_02_prev.')<br>';
				}
				
				if ($cexpe_02 == '1')
				{
					$str_val .= 'Student expelled on '.formatdate(substr($act_date_02,0,10),'fromdb').' '.substr($act_date_02,11,8).'.<br>('.$rect_risn_02.')<br>';
				}else if ($cexpe_02 == '0')
				{
					$str_val .= 'Student called back from expulsion on '.formatdate(substr($act_date_02,0,10),'fromdb').' '.substr($act_date_02,11,8).'.<br>('.$rect_risn_02.')<br>';
				}
			}

			$str_val .= '<p>';
			if ($tempwith_02_prev <> $tempwith_02)
			{
				if ($tempwith_02_prev == '0')
				{
					$str_val .= 'Student recalled on '.formatdate(substr($act_date_02_prev,0,10),'fromdb').' '.substr($act_date_02_prev,11,8).'.<br>('.$rect_risn_02_prev.')<br>';
				}else if ($tempwith_02_prev == '1')
				{
					$str_val .= 'Student temporarily withdrawn on '.formatdate(substr($act_date_02_prev,0,10),'fromdb').' '.substr($act_date_02_prev,11,8).'.<br>('.$rect_risn_02_prev.')<br>';
				}
				
				if ($tempwith_02 == '1')
				{
					$str_val .= 'Student temporarily withdrawn on '.formatdate(substr($act_date_02,0,10),'fromdb').' '.substr($act_date_02,11,8).'.<br>('.$rect_risn_02.')<br>';
				}else if ($tempwith_02 == '0')
				{
					$str_val .= 'Student recalled on '.formatdate(substr($act_date_02,0,10),'fromdb').' '.substr($act_date_02,11,8).'.<br>('.$rect_risn_02.')<br>';
				}
			}

			$str_val .= '<p>';
			if ($permwith_02_prev <> $permwith_02)
			{
				if ($permwith_02_prev == '0')
				{
					$str_val .= 'Student recalled on '.formatdate(substr($act_date_02_prev,0,10),'fromdb').' '.substr($act_date_02_prev,11,8).'.<br>('.$rect_risn_02_prev.')<br>';
				}else if ($permwith_02_prev == '1')
				{
					$str_val .= 'Student permanently withdrawn on '.formatdate(substr($act_date_02_prev,0,10),'fromdb').' '.substr($act_date_02_prev,11,8).'.<br>('.$rect_risn_02_prev.')<br>';
				}
				
				if ($permwith_02 == '1')
				{
					$str_val .= 'Student permanently withdrawn on '.formatdate(substr($act_date_02,0,10),'fromdb').' '.substr($act_date_02,11,8).'.<br>('.$rect_risn_02.')<br>';
				}else if ($permwith_02 == '0')
				{
					$str_val .= 'Student recalled on '.formatdate(substr($act_date_02,0,10),'fromdb').' '.substr($act_date_02,11,8).'.<br>('.$rect_risn_02.')<br>';
				}
			}
		}
		log_actv('checked status of '.$_REQUEST['uvApplicationNo']);
		echo $who_is_this.$str_val.'<br>'.$grad_status;
	}
}
