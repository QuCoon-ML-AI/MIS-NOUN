<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$mysqli = link_connect_db();

$currency = eyes_pilled('0');

$staff_study_center = '';
if (isset($_REQUEST['staff_study_center']))
{
	$staff_study_center = $_REQUEST['staff_study_center'];
}

if (isset($_REQUEST['ilin']) && $_REQUEST['ilin'] <> '')
{
	if (isset($_REQUEST['mm']) && isset($_REQUEST['sm']))
	{
		if (($_REQUEST['mm'] == 0 && ($_REQUEST['sm'] == 7 || $_REQUEST['sm'] == 8)) || 
		(($_REQUEST['mm'] == 1 || $_REQUEST['mm'] == 8) && ($_REQUEST['sm'] == 5 || $_REQUEST['sm'] == 6 || $_REQUEST['sm'] == 7 || $_REQUEST['sm'] == 8 || $_REQUEST['sm'] == 9)) || 
		($_REQUEST['mm'] == 2  && ($_REQUEST['sm'] == 2 || $_REQUEST['sm'] == 3)) || 
		($_REQUEST['mm'] == 3  && ($_REQUEST['sm'] == 3 || $_REQUEST['sm'] == 4)) || 
		($_REQUEST['mm'] == 4  && ($_REQUEST['sm'] == 1 || $_REQUEST['sm'] == 2)) || 
		($_REQUEST['mm'] == 5  && ($_REQUEST['sm'] == 2 || $_REQUEST['sm'] == 3 || $_REQUEST['sm'] == 4)) || 
		($_REQUEST['mm'] == 2  && ($_REQUEST['sm'] == 7 || $_REQUEST['sm'] == 8)))
		{
			if (($_REQUEST['mm'] == 0  && $_REQUEST['sm'] == 2) || 
			(($_REQUEST['mm'] == 1 || $_REQUEST['mm'] == 8)  && ($_REQUEST['sm'] == 5 || $_REQUEST['sm'] == 6 ||$_REQUEST['sm'] == 7 || $_REQUEST['sm'] == 8 || $_REQUEST['sm'] == 9)) || 
			($_REQUEST['mm'] == 2  && ($_REQUEST['sm'] == 2 || $_REQUEST['sm'] == 3)) || 
			($_REQUEST['mm'] == 3  && ($_REQUEST['sm'] == 3 || $_REQUEST['sm'] == 4)) ||
			($_REQUEST['mm'] == 5  && $_REQUEST['sm'] == 4) ||
			($_REQUEST['mm'] == 4  && $_REQUEST['sm'] == 2))
			{
				if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
				{
					$mysqli_arch = link_connect_db_arch();
					$stmt = $mysqli_arch->prepare("select * from arch_afnmatric where vMatricNo = ?");
					$stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
					$stmt->execute();
					$stmt->store_result();
				}else
				{
					$stmt = $mysqli->prepare("select * from afnmatric where vMatricNo = ?");
					$stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
					$stmt->execute();
					$stmt->store_result();
				}
				
				if ($stmt->num_rows === 0 && !(($_REQUEST['mm'] == 4  && $_REQUEST['sm'] == 2) ||
				($_REQUEST['mm'] == 8  && ($_REQUEST['sm'] == 5 || $_REQUEST['sm'] == 6)) ||
				($_REQUEST['mm'] == 1 && ($_REQUEST['sm'] == 5 || $_REQUEST['sm'] == 6)) ||
				($_REQUEST['mm'] == 3  && ($_REQUEST['sm'] == 3 || $_REQUEST['sm'] == 4))))
				{
					$stmt->close();
					
					if (check_grad_student($_REQUEST["uvApplicationNo"]) == 0)
					{
						echo 'Invalid matriculation number';exit;
					}else
					{
						echo 'Matriculation number graduated';exit;
					}
				}else
				{
					$stmt = $mysqli->prepare("SELECT cEduCtgId, cStudyCenterId, cProgrammeId 
					FROM prog_choice 
					WHERE vApplicationNo = ?");
					$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($cEduCtgId_01, $cStudyCenterId, $cProgrammeId);
					$stmt->fetch();
					$stmt->close();

					if (is_null($cStudyCenterId))
					{
						$cStudyCenterId = '';
					}
					if (is_null($cEduCtgId_01))
					{
						$cEduCtgId_01 = '';
					}
					if (is_null($cProgrammeId))
					{
						$cProgrammeId = '';
					}

					$cEduCtgId = $cEduCtgId_01;

					/*if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
					{
						echo 'Your study centre does not match that of the candidate<br>Direct candidate to his/her study centre for required actions';
						exit;
					}*/
					
					if ($cEduCtgId == '')
					{
						$stmt = $mysqli->prepare("SELECT cEduCtgId, f.cProgrammeId  
						from prog_choice a, afnmatric e, s_m_t f
						where e.vApplicationNo = a.vApplicationNo 
						AND e.vMatricNo = f.vMatricNo 
						AND e.vMatricNo = ?");
						$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($cEduCtgId, $cProgrammeId);
						if (!$stmt->num_rows === 0 && check_grad_student($_REQUEST["uvApplicationNo"]) == 0)
						{	
							$stmt->close();
							echo 'Matriculation number yet to sign-up';exit;
						}
						$stmt->fetch();
						$stmt->close();

						$cEduCtgId = $cEduCtgId ?? '';
						$cProgrammeId = $cProgrammeId ?? '';
					}
				}

				if ($_REQUEST['mm'] == 8 && $cEduCtgId <> 'PGX' && $cEduCtgId <> 'PGY' && $cEduCtgId <> 'PGZ' && $cEduCtgId <> 'PRX')
				{
					echo 'Matriculaton number must be that of an MPhil, PhD or postgraduate student'; exit;
				}else if ($_REQUEST['mm'] == 1 && ($cEduCtgId == 'PGZ' || $cEduCtgId == 'PRX'))
				{
					echo 'Matriculaton number must be that of an undergraduate, PGD or Masters student'; exit;
				}else if ($_REQUEST['sRoleID'] == 29 && is_bool(strpos($cProgrammeId, 'CHD')))
				{
					echo 'Matriculaton number must be that of a certificate student in CHRD'; exit;
				}else if ($_REQUEST['sRoleID'] == 26 && is_bool(strpos($cProgrammeId, 'DEG')))
				{
					echo 'Matriculaton number must be that of a certificate student in DE&GS';exit;
				}

				if ($_REQUEST['mm'] == 1 && $_REQUEST['sm'] == 5)
				{
					log_actv('Viewed application form of '.$_REQUEST["uvApplicationNo"]);
				}else if ($_REQUEST['mm'] == 1 && ($_REQUEST['sm'] == 5 || $_REQUEST['sm'] == 6))
				{
					$stmt_last = $mysqli->prepare("SELECT a.vApplicationNo FROM pics a, prog_choice b WHERE a.vApplicationNo = b.vApplicationNo AND cSbmtd <> '0' AND b.vApplicationNo = ? AND cinfo_type = 'p'");
					$stmt_last->bind_param("s", $_REQUEST["uvApplicationNo"]);
					$stmt_last->execute();
					$stmt_last->store_result();
					$has_pp = $stmt_last->num_rows;
					$stmt_last->close();

					if ($has_pp == 0)
    				{
						echo 'Admission letter is not yet available';
						exit;
					}

					log_actv('Viewed admission letter of '.$_REQUEST["uvApplicationNo"]);
				}			

				if ($cProgrammeId == 'MSC415' || $cProgrammeId == 'MSC416')
				{
					echo $cEduCtgId_01.'C';
				}else
				{
					echo $cEduCtgId_01;
				}
			}else 
			{
				$stmt = $mysqli->prepare("SELECT cSbmtd, cEduCtgId, cProgrammeId FROM prog_choice WHERE vApplicationNo = ?");
				$stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($cSbmtd, $cEduCtgId, $cProgrammeId);
				
				if ($stmt->num_rows == 0 && (($_REQUEST['mm'] == 0 && ($_REQUEST['sm'] == 7 || $_REQUEST['sm'] == 8)) || 
				($_REQUEST['mm'] == 1 && ($_REQUEST['sm'] == 5 || $_REQUEST['sm'] == 6)) || 
				($_REQUEST['mm'] == 4 && ($_REQUEST['sm'] == 1 || $_REQUEST['sm'] == 2)) || 
				($_REQUEST['mm'] == 2 && ($_REQUEST['sm'] == 7 || $_REQUEST['sm'] == 8)) ||
				($_REQUEST['mm'] == 5  && ($_REQUEST['sm'] == 2 || $_REQUEST['sm'] == 3))))
				{	
					echo 'Invalid application form number';exit;
				}

				$stmt->fetch();
				
				if ($cSbmtd == '0' && (($_REQUEST['mm'] == 0 && ($_REQUEST['sm'] == 7 || $_REQUEST['sm'] == 8)) || 
				($_REQUEST['mm'] == 1 && ($_REQUEST['sm'] == 5 || $_REQUEST['sm'] == 6)) || 
				($_REQUEST['mm'] == 4 && ($_REQUEST['sm'] == 1 || $_REQUEST['sm'] == 2)) || 
				($_REQUEST['mm'] == 2 && ($_REQUEST['sm'] == 7 || $_REQUEST['sm'] == 8)) ||
				($_REQUEST['mm'] == 5  && ($_REQUEST['sm'] == 2 || $_REQUEST['sm'] == 3))))
				{
					$stmt->close();
					echo 'Form not submitted';exit;
				}
				$stmt->close();
				

				if ($_REQUEST['mm'] == 8 && $cEduCtgId <> 'PGX' && $cEduCtgId <> 'PGY' && $cEduCtgId <> 'PGZ' && $cEduCtgId <> 'PRX')
				{
					echo 'Application form number must be that of an MPhil, PhD or postgraduate candidate'; exit;
				}else if ($_REQUEST['mm'] == 1 && ($cEduCtgId == 'PRX' || $cEduCtgId == 'PGZ'))
				{
					echo 'Application form number must be that of an undergraduate, PGD or Masters candidate'; exit;
				}else if ($_REQUEST['sRoleID'] == 29 && is_bool(strpos($cProgrammeId, 'CHD')))
				{
					echo 'Application form number must be that of a certificate candidate in CHRD'; exit;
				}else if ($_REQUEST['sRoleID'] == 26 && is_bool(strpos($cProgrammeId, 'DEG')))
				{
					echo 'Application form number must be that of a certificate candidate in DE&GS';exit;
				}
				
				if (($_REQUEST['mm'] == 0 && $_REQUEST['sm'] == 7) || 
				($_REQUEST['mm'] == 1 && ($_REQUEST['sm'] == 5 || $_REQUEST['sm'] == 6)) || 
				($_REQUEST['mm'] == 4 && $_REQUEST['sm'] == 1) || 
				($_REQUEST['mm'] == 2 && $_REQUEST['sm'] == 7))
				{
					log_actv('Viewed form for '.$_REQUEST["uvApplicationNo"]);
				}
			} 
		}else if (($_REQUEST['mm'] == 0 && $_REQUEST['sm'] > 8) || ($_REQUEST['mm'] == 4  && $_REQUEST['sm'] == 3) || ($_REQUEST['mm'] == 5  && $_REQUEST['sm'] == 5))
		{
			$stmt = $mysqli->prepare("SELECT a.cEduCtgId, a.cProgrammeId  
			from prog_choice a, afnmatric e, s_m_t f
			where e.vApplicationNo = a.vApplicationNo 
			AND e.vMatricNo = f.vMatricNo 
			AND e.vMatricNo = ?");
			$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($cEduCtgId, $cProgrammeId);
			if ($stmt->num_rows === 0 && check_grad_student($_REQUEST["uvApplicationNo"]) == 0)
			{	
				$stmt->close();
				echo 'Matriculation number invalid or yet to sign-up';exit;
			}			
			$stmt->fetch();
			$stmt->close();
			
			if ($_REQUEST['mm'] == 8 && $cEduCtgId <> 'PGX' && $cEduCtgId <> 'PGY' && $cEduCtgId <> 'PGZ' && $cEduCtgId <> 'PRX')
			{
				echo 'Application form number must be that of an MPhil, PhD or postgraduate candidate'; exit;
			}else if ($_REQUEST['mm'] == 1 && ($cEduCtgId == 'PRX' || $cEduCtgId == 'PGZ'))
			{
				echo 'Application form number must be that of an undergraduate, PGD or Masters candidate'; exit;
			}else if ($_REQUEST['sRoleID'] == 29 && is_bool(strpos($cProgrammeId, 'CHD')))
			{
				echo 'Application form number must be that of a certificate candidate in CHRD'; exit;
			}else if ($_REQUEST['sRoleID'] == 26 && is_bool(strpos($cProgrammeId, 'DEG')))
			{
				echo 'Application form number must be that of a certificate candidate in DE&GS';exit;
			}

			if (check_grad_student($_REQUEST["uvApplicationNo"]) == 1)
			{
				echo 'Matriculation number gradauted'; 
				exit;
			}

			if (($_REQUEST['mm'] == 0 && $_REQUEST['sm'] == 9) || ($_REQUEST['mm'] == 4  && $_REQUEST['sm'] == 3) || ($_REQUEST['mm'] == 5  && $_REQUEST['sm'] == 4))
			{
				log_actv('Viewed biodata of '.$_REQUEST["uvApplicationNo"]);
			}else if (($_REQUEST['mm'] == 0 && $_REQUEST['sm'] == 10) || ($_REQUEST['mm'] == 4  && $_REQUEST['sm'] == 4) || ($_REQUEST['mm'] == 5  && $_REQUEST['sm'] == 5))
			{
				log_actv('Viewed academic record of '.$_REQUEST["uvApplicationNo"]);
			}else if (($_REQUEST['mm'] == 0 && $_REQUEST['sm'] == 11) || ($_REQUEST['mm'] == 4  && $_REQUEST['sm'] == 4))
			{
				log_actv('Viewed account record of '.$_REQUEST["uvApplicationNo"]);
			}
		}

		
		if (($_REQUEST['mm'] == 1 || $_REQUEST['mm'] == 8))
		{
			if ($_REQUEST['sm'] == 1)
			{			
				$stmt = $mysqli->prepare("select * from prog_choice where vApplicationNo = ?");
				$stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
			
				if ($stmt->num_rows === 0)
				{
					$stmt->close();
					echo 'Invalid application form numbers';exit;
				}
				$stmt->close();
			}
		}
	}
}