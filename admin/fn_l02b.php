<?php

date_default_timezone_set('Africa/Lagos');

function cutlen($str, $len, $adjcase)
{
	if ($adjcase == '1'){$str = ucwords(strtolower($str));}
	if (strlen($str) > $len){return substr($str,0,($len-3)).'...';}else{return $str;}
}


function check_scope1($val)
{	
	//return 1;

	$mysqli = link_connect_db();

	$stmt = $mysqli->prepare("SELECT * FROM role_user a, role_perm b, menue_new c
	WHERE a.sRoleID = b.sRoleID
	AND c.ictID = b.ictID
	AND a.vUserId = ?
	AND c.level1 = ?
	AND c.cDel = 'N'");

	$stmt->bind_param("ss", $_REQUEST['vApplicationNo'], $val);		
	$stmt->execute();
	$stmt->store_result();

	return $stmt->num_rows;
}


function check_scope2($val1, $val2)
{
	//return 1;
	
	$mysqli = link_connect_db();

	$stmt = $mysqli->prepare("SELECT * FROM role_user a, role_perm b, menue_new c
	WHERE a.sRoleID = b.sRoleID
	AND c.ictID = b.ictID
	AND a.vUserId = ?
	AND c.level1 = ?
	AND c.level2 = ?
	AND c.cDel = 'N'");

	$stmt->bind_param("sss", $_REQUEST['vApplicationNo'], $val1, $val2);		
	$stmt->execute();
	$stmt->store_result();

	return $stmt->num_rows;
}


function check_scope3($val1, $val2, $val3)
{
	//return 1;

	$mysqli = link_connect_db();

	$stmt = $mysqli->prepare("SELECT * FROM role_user a, role_perm b, menue_new c
	WHERE a.sRoleID = b.sRoleID
	AND c.ictID = b.ictID
	AND a.vUserId = ?
	AND c.level1 = ?
	AND c.level2 = ?
	AND c.level3 = ?
	AND c.cDel = 'N'");

	$stmt->bind_param("ssss", $_REQUEST['vApplicationNo'], $val1, $val2, $val3);		
	$stmt->execute();
	$stmt->store_result();

	return $stmt->num_rows;
}


function check_scope4($val1, $val2, $val3, $val4)
{
	//return 1;
	
	$mysqli = link_connect_db();

	$stmt = $mysqli->prepare("SELECT * FROM role_user a, role_perm b, menue_new c
	WHERE a.sRoleID = b.sRoleID
	AND c.ictID = b.ictID
	AND a.vUserId = ?
	AND c.level1 = ?
	AND c.level2 = ?
	AND c.level3 = ?
	AND c.level4 = ?
	AND c.cDel = 'N'");

	$stmt->bind_param("sssss", $_REQUEST['vApplicationNo'], $val1, $val2, $val3, $val4);		
	$stmt->execute();
	$stmt->store_result();

	return $stmt->num_rows;
}


function check_scope()
{
	return 1;
	
	$mysqli = link_connect_db();

	if (check_service_mode() == 0){return 0;}

  	$sqlSubStr = ''; $in_str = ''; $level3_value = ''; $level4_value = '';	
	
	if (isset($_REQUEST['mm']) && isset($_REQUEST['sm']) && $_REQUEST['mm'] <> '' &&  $_REQUEST['sm'] <> '')
	{
    	if (isset($_REQUEST['mm']) && isset($_REQUEST['sm']) && $_REQUEST['mm'] == '0')
		{
			if ($_REQUEST['sm'] == '1')
			{
				$in_str = " and cspec_perms like '%w%'";
			}elseif ($_REQUEST['sm'] == '2' || $_REQUEST['sm'] == '3')
			{
				$in_str = " and cspec_perms like '%m%'";
			}elseif ($_REQUEST['sm'] == '4')
			{
				$in_str = " and cspec_perms like '%v%'";
			}elseif ($_REQUEST['sm'] == '5')
			{
				$in_str = " and cspec_perms like '%d%'";
			}elseif ($_REQUEST['sm'] == '7')
			{			
				if (isset($_REQUEST['what_to_do']) && $_REQUEST['what_to_do'] <> '' && isset($_REQUEST['on_what']) && $_REQUEST['on_what'] <> '')
				{
					$sqlSubStr = " and clevel3 = ? ";
					if ($_REQUEST['what_to_do'] == 0)//create
					{
						$in_str = " and cspec_perms like '%w%'";
						if ($_REQUEST['on_what'] == 0)//faculty
						{
							$level3_value = 1;
						}else if ($_REQUEST['on_what'] == 1)//dept
						{
							$level3_value = 2;
						}else if ($_REQUEST['on_what'] == 2)//prog
						{
							$level3_value = 3;
						}else if ($_REQUEST['on_what'] == 3)//course
						{
							$level3_value = 4;
						}
					}else if ($_REQUEST['what_to_do'] == 1)//edit
					{
						$in_str = " and cspec_perms like '%m%'";
						if ($_REQUEST['on_what'] == 0)//faculty
						{
							$level3_value = 5;
						}else if ($_REQUEST['on_what'] == 1)//dept
						{
							$level3_value = 6;
						}else if ($_REQUEST['on_what'] == 2)//prog
						{
							$level3_value = 7;
						}else if ($_REQUEST['on_what'] == 3)//course
						{
							$level3_value = 8;
						}
					}else if ($_REQUEST['what_to_do'] == 2)//delete
					{
						$in_str = " and cspec_perms like '%d%'";
						if ($_REQUEST['on_what'] == 0)//faculty
						{
							$level3_value = 9;
						}else if ($_REQUEST['on_what'] == 1)//dept
						{
							$level3_value = 10;
						}else if ($_REQUEST['on_what'] == 2)//prog
						{
							$level3_value = 11;
						}else if ($_REQUEST['on_what'] == 3)//course
						{
							$level3_value = 12;
						}
					}else if ($_REQUEST['what_to_do'] == 3)//add course
					{
						$in_str = " and (cspec_perms like '%m%' OR cspec_perms like '%w%')";
						if ($_REQUEST['on_what'] == 3)
						{
							$level3_value = 13;
						}
					}else if ($_REQUEST['what_to_do'] == 4)//view
					{
						$in_str = " and cspec_perms like '%v%'";
					}else if ($_REQUEST['what_to_do'] == 5)//assign course
					{
						$in_str = " and cspec_perms like '%w%'";
						if ($_REQUEST['on_what'] == 3)
						{
							$level3_value = 18;
						}
					}
				}
			}elseif ($_REQUEST['sm'] == '6' || $_REQUEST['sm'] == '9' || $_REQUEST['sm'] == '10' || $_REQUEST['sm'] == '11' || $_REQUEST['sm'] == '11')
			{
				$in_str = " and cspec_perms like '%v%'";
			}elseif ($_REQUEST['sm'] == '8')
			{
				if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] <> '')
				{
					$level3_value = $_REQUEST['whattodo'];
					$sqlSubStr = " and clevel3 = ? ";
					
					if ($_REQUEST['whattodo'] == '0' || $_REQUEST['whattodo'] == '1')
					{
						$in_str = " and cspec_perms like '%v%'";
					}
				}
			}elseif ($_REQUEST['sm'] == '12')
			{
				if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] <> '')
				{
					$level3_value = $_REQUEST['whattodo'];
					$sqlSubStr = " and clevel3 = ? ";
					if ($_REQUEST['whattodo'] >= 1 && $_REQUEST['whattodo'] <= 4)
					{
						$in_str = " and cspec_perms like '%w%'";
					}else if ($_REQUEST['whattodo'] == 16 || ($_REQUEST['whattodo'] >= 5 && $_REQUEST['whattodo'] <= 8))
					{
						$in_str = " and cspec_perms like '%m%'";
					}else
					{
						$in_str = " and cspec_perms like '%v%'";
					}
				}else if (isset($_REQUEST['save']) && $_REQUEST['save'] == 3)
				{
					$level3_value = 14;
					$sqlSubStr = " and clevel3 = ? ";
				}
			}
		}elseif (isset($_REQUEST['mm']) && isset($_REQUEST['sm']) && $_REQUEST['mm'] == '1')
		{
			if ($_REQUEST['sm'] == '2')
			{
				if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] <> '')
				{
					$level3_value = $_REQUEST['id_no'];
					$sqlSubStr = " and clevel3 = ? ";
				}
				
				if (isset($_REQUEST['tabno']) && $_REQUEST['tabno'] <> '' && $_REQUEST['tabno'] <> '0')
				{
					$level4_value = $_REQUEST['tabno'];
					$sqlSubStr .= " and clevel4 = ? ";
					$in_str = " and cspec_perms like '%m%' ";
				}else
				{
					$in_str = " and cspec_perms like '%v%' ";
				}
			}elseif ($_REQUEST['sm'] == '3')
			{
				$in_str = " and cspec_perms like '%m%'";
			}else if ($_REQUEST['sm'] == '4')
			{			
				if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] <> '')
				{
					$level3_value = $_REQUEST['whattodo'];
					$sqlSubStr = " and clevel3 = ? ";
					
					if ($_REQUEST['whattodo']== '0' || $_REQUEST['whattodo']== '7')
					{
						$in_str = " and cspec_perms like '%v%'";
					}else if ($_REQUEST['whattodo'] == '2' || $_REQUEST['whattodo'] == '3')
					{
						$in_str = " and (cspec_perms like '%d%' or cspec_perms like '%w%')";
					}else
					{
						$in_str = " and cspec_perms like '%m%'";
					}
				}
				
				if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] <> '')
				{
					$level4_value = $_REQUEST['id_no'];
					$sqlSubStr .= " and clevel4 = ? ";
				}
			}elseif ( $_REQUEST['sm'] == '5' || $_REQUEST['sm'] == '6' || $_REQUEST['sm'] == '7' || $_REQUEST['sm'] == '8' || $_REQUEST['sm'] == '9')
			{
				$in_str = " and cspec_perms like '%v%'";
			}elseif ($_REQUEST['sm'] == '10')
			{
				if (isset($_REQUEST['corect']) && $_REQUEST['corect'] <> '')
				{
					$level3_value = $_REQUEST['corect'];
					$sqlSubStr = " and clevel3 = ? ";
				}
				$in_str = " and (cspec_perms like '%m%' or cspec_perms like '%w%') ";
			}elseif ($_REQUEST['sm'] == '11')
			{
				if (isset($_REQUEST['tabno']) && $_REQUEST['tabno'] <> '')
				{
					$level3_value = $_REQUEST['tabno']-1;
					$sqlSubStr = " and clevel3 = ? ";
				}
				$in_str = " and (cspec_perms like '%v%' or (cspec_perms like '%m%' or cspec_perms like '%w%')) ";
			}
		}else if (isset($_REQUEST['mm']) && isset($_REQUEST['sm']) && $_REQUEST['mm'] == '2')
		{
			if ($_REQUEST['sm'] == '1' || $_REQUEST['sm'] == '2' || $_REQUEST['sm'] == '3' || $_REQUEST['sm'] == '11')
			{
				$in_str = " and cspec_perms like '%v%' ";
			}else if ($_REQUEST['sm'] == '4' || $_REQUEST['sm'] == '5')
			{
				$in_str = " and (cspec_perms like '%m%' or cspec_perms like '%w%') ";
			}else if ($_REQUEST['sm'] == '6')
			{
				if (isset($_REQUEST['whatodo']) && $_REQUEST['whatodo'] <> '')
				{
					if ($_REQUEST['whatodo'] == 'a'){$in_str = " and cspec_perms like '%w%' ";}
					elseif ($_REQUEST['whatodo'] == 'd'){$in_str = " and cspec_perms like '%d%' ";}
					elseif ($_REQUEST['whatodo'] == 'e'){$in_str = " and cspec_perms like '%m%' ";}
					else{$in_str = " and cspec_perms like '%v%' ";}
				}
			}else if ($_REQUEST['sm'] == '7' || $_REQUEST['sm'] == '8')
			{
				$in_str = " and cspec_perms like '%v%' ";
			}else if ($_REQUEST['sm'] == '9')
			{
				$in_str = " and (cspec_perms like '%v%' and cspec_perms like '%m%') ";
			}elseif ($_REQUEST['sm'] == '10')
			{
				if (isset($_REQUEST['tabno']) && $_REQUEST['tabno'] <> '')
				{
					$level3_value = $_REQUEST['tabno']-1;
					$sqlSubStr = " and clevel3 = ? ";
					
					if ($_REQUEST['tabno'] == 4)
					{
						$in_str = " and (cspec_perms like '%m%') ";
					}else 
					{
						$in_str = " and (cspec_perms like '%v%') ";
					}
				}else
				{
					$in_str = " and cspec_perms like '%v%' ";
				}
			}		
		}elseif (isset($_REQUEST['mm']) && isset($_REQUEST['sm']) && $_REQUEST['mm'] == '3')
		{
			if ($_REQUEST['sm'] == '1')
			{
				if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] <> '')
				{
					$level3_value = $_REQUEST['whattodo'];
					$sqlSubStr = " and clevel3 = ? ";
					
					if ($_REQUEST['whattodo']== '0' || $_REQUEST['whattodo']== '7')
					{
						$in_str = " and cspec_perms like '%v%'";
					}else if ($_REQUEST['whattodo'] == '2' || $_REQUEST['whattodo'] == '3')
					{
						$in_str = " and (cspec_perms like '%w%' OR cspec_perms like '%d%')";
					}else
					{
						$in_str = " and cspec_perms like '%m%'";
					}
				}
				
				if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] <> '')
				{
					$level4_value = $_REQUEST['id_no'];
					$sqlSubStr .= " and clevel4 = ? ";
				}
			}elseif ($_REQUEST['sm'] <= 8)
			{
				$in_str = " and cspec_perms like '%v%'";
			}elseif ($_REQUEST['sm'] == 9)
			{
				if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] <> '')
				{				
					if ($_REQUEST['whattodo'] == '0')
					{
						$in_str = " and cspec_perms like '%v%'";
					}else if ($_REQUEST['whattodo'] == '1')
					{
						$in_str = " and cspec_perms like '%w%'";
					}else if ($_REQUEST['whattodo'] == '2')
					{
						$in_str = " and cspec_perms like '%m%'";
					}else if ($_REQUEST['whattodo'] == '3')
					{
						$in_str = " and cspec_perms like '%d%'";
					}
				}
			}
		}elseif (isset($_REQUEST['mm']) && isset($_REQUEST['sm']) && $_REQUEST['mm'] == '4')
		{
			if ($_REQUEST['sm'] == '8')
			{
				if (isset($_REQUEST['whattodo']))
				{
					if ($_REQUEST['whattodo'] == '0')
					{
						$in_str = " and cspec_perms like '%v%'";
					}else
					{
						$in_str = " and cspec_perms like '%m%'";
					}
				}
			}else
			{
				$in_str = " and cspec_perms like '%v%'";
			}
		}elseif (isset($_REQUEST['mm']) && isset($_REQUEST['sm']) && $_REQUEST['mm'] == '5')
		{
      		if ($_REQUEST['sm'] == '1')
			{
				if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] <> '')
				{
					$level3_value = $_REQUEST['whattodo'];
					$sqlSubStr = " and clevel3 = ? ";
					
					if ($_REQUEST['whattodo']== '0' || $_REQUEST['whattodo']== '7')
					{
						$in_str = " and cspec_perms like '%v%'";
					}else if ($_REQUEST['whattodo'] == '2' || $_REQUEST['whattodo'] == '3')
					{
						$in_str = " and cspec_perms like '%wd%'";
					}else
					{
						$in_str = " and cspec_perms like '%m%'";
					}
				}
				
				if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] <> '')
				{
					$level4_value = $_REQUEST['id_no'];
					$sqlSubStr .= " and clevel4 = ? ";
				}
			}else
			{
				$in_str = " and cspec_perms like '%v%'";
			}
		}elseif (isset($_REQUEST['mm']) && isset($_REQUEST['sm'])  && $_REQUEST['mm'] == '6')
		{
			$in_str = " and cspec_perms like '%v%'";
		}elseif (isset($_REQUEST['mm']) && isset($_REQUEST['sm']) && $_REQUEST['mm'] == '7')
		{
			if ($_REQUEST['sm'] == '1')
			{
				if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] <> '')
				{
					$level3_value = $_REQUEST['whattodo'];
					$sqlSubStr = " and clevel3 = ?";
					if ($_REQUEST['whattodo'] == 0)
					{
						$in_str = " and cspec_perms like '%w%'";
					}else if ($_REQUEST['whattodo'] == 6)
					{
						$in_str = " and cspec_perms like '%d%'";
					}else 
					{
						$in_str = " and cspec_perms like '%m%'";
					}
				}
			}else if ($_REQUEST['sm'] == '2')
			{
				if (isset($_REQUEST['whattodo1']) && $_REQUEST['whattodo1'] <> '')
				{
					$level3_value = $_REQUEST['whattodo1'];
					$sqlSubStr = " and clevel3 = ?";
					if ($_REQUEST['whattodo1'] == 0)
					{
						$in_str = " and cspec_perms like '%v%'";
					}elseif ($_REQUEST['whattodo1'] == 1)
					{
						$in_str = " and cspec_perms like '%w%'";
					}else 
					{
						$in_str = " and cspec_perms like '%m%'";
					}
				}
			}else if ($_REQUEST['sm'] == '3')
			{
				if (isset($_REQUEST['tabno']) && $_REQUEST['tabno'] <> '')
				{
					$level3_value = $_REQUEST['tabno']-1;
					$sqlSubStr = " and clevel3 = ? ";
				}
				$in_str = " and (cspec_perms like '%v%' and (cspec_perms like '%m%' or cspec_perms like '%w%')) ";
			}
		}
		
		$clevel2 = '';
		if ($_REQUEST['mm'] <> 6)
		{
			$clevel2 = " and clevel2 = ?";
		}
		
		if ($level4_value <> '' && $level3_value <> '')
		{
		 	$stmt = $mysqli->prepare("SELECT * FROM menue_new a, role_perm b, role_user c 
			where c.vUserId = ? and 
			b.sRoleID = c.sRoleID and a.ictID = b.ictID and 
			clevel1 = ? $clevel2 $sqlSubStr $in_str");
			$stmt->bind_param("sssss", $_REQUEST['vApplicationNo'], $_REQUEST['mm'], $_REQUEST['sm'], $level3_value, $level4_value);
		}else if ($level3_value <> '' && $level4_value == '')
		{
			$stmt = $mysqli->prepare("SELECT * FROM menue_new a, role_perm b, role_user c 
			where c.vUserId = ? and 
			b.sRoleID = c.sRoleID and a.ictID = b.ictID and 
			clevel1 = ? $clevel2 $sqlSubStr $in_str");
			$stmt->bind_param("ssss", $_REQUEST['vApplicationNo'], $_REQUEST['mm'], $_REQUEST['sm'], $level3_value);
		}else if ($level3_value == '' && $level4_value == '')
		{
			$stmt = $mysqli->prepare("SELECT * FROM menue_new a, role_perm b, role_user c 
			where c.vUserId = ? and 
			b.sRoleID = c.sRoleID and a.ictID = b.ictID and 
			clevel1 = ? $clevel2 $in_str");
			$stmt->bind_param("sss", $_REQUEST['vApplicationNo'], $_REQUEST['mm'], $_REQUEST['sm']);
		}
		
		$stmt->execute();
		$stmt->store_result();
		return $stmt->num_rows;
	}else
	{
		return 1;
	}
}


function check_service_mode()
{
	if (isset($_REQUEST['mm']) && isset($_REQUEST['sm']) && $_REQUEST['mm'] <> '' &&  $_REQUEST['sm'] <> '' && (isset($_REQUEST['uvApplicationNo']) && $_REQUEST['uvApplicationNo'] <> ''))
	{
		$mysqli = link_connect_db();
		
		$check_role = array();

		$stmt = $mysqli->prepare("SELECT vRoleName 
		FROM userlogin a, role_user b, role c
		WHERE a.vApplicationNo = b.vUserId
		AND b.sRoleID = c.sRoleID
		AND c.vRoleName in ('Root', 'Technical support', 'Registrar DTP', 'Part time Tech Support')
		AND a.vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST['vApplicationNo']);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0){return 1;}
		
		$stmt->close();
		if ($_REQUEST['mm'] == '0')
		{
			if ($_REQUEST['sm'] >= 8 && $_REQUEST['sm'] <= 12)//applicant
			{
				if ($_REQUEST['sm'] == 8)//applicant
				{
					$primary_tab = 'prog_choice';
					$ref_column = 'vApplicationNo';
				}else if ($_REQUEST['sm'] == 9 || $_REQUEST['sm'] == 10 || $_REQUEST['sm'] == 11)//student
				{
					$primary_tab = 's_m_t';
					$ref_column = 'vMatricNo';
				}
			}
		}else if ($_REQUEST['mm'] == '1')
		{
			if ($_REQUEST['sm'] == 2 && $_REQUEST['id_no'] <> '')
			{
				if ($_REQUEST['id_no'] == 0)//applicant
				{
					$primary_tab = 'prog_choice';
					$ref_column = 'vApplicationNo';
				}else if ($_REQUEST['id_no'] == 1)//student
				{
					$primary_tab = 's_m_t';
					$ref_column = 'vMatricNo';
				}
			}else if ($_REQUEST['sm'] == 3 || ($_REQUEST['sm'] >= 7 && $_REQUEST['sm'] <= 10))//student
			{
				$primary_tab = 's_m_t';
				$ref_column = 'vMatricNo';
			}else if ($_REQUEST['sm'] == 4)//student
			{
				if ($_REQUEST['id_no'] == 0)//applicant
				{
					$primary_tab = 'prog_choice';
					$ref_column = 'vApplicationNo';
				}else if ($_REQUEST['id_no'] == 1)//student
				{
					$primary_tab = 's_m_t';
					$ref_column = 'vMatricNo';
				}
			}else if ($_REQUEST['sm'] == 5 || $_REQUEST['sm'] == 6)//applicant
			{
				$primary_tab = 'prog_choice';
				$ref_column = 'vApplicationNo';
			}
		}else if ($_REQUEST['mm'] == '2')
		{
			return 1;
		}else if ($_REQUEST['mm'] == '3')
		{
            if ($_REQUEST['sm'] == 1)//applicant
			{
				if ($_REQUEST['id_no'] == 0)//applicant
				{
					$primary_tab = 'prog_choice';
					$ref_column = 'vApplicationNo';
				}else if ($_REQUEST['id_no'] == 1)//student
				{
					$primary_tab = 's_m_t';
					$ref_column = 'vMatricNo';
				}
			}else if ($_REQUEST['sm'] == 2 || $_REQUEST['sm'] == 3)//applicant
			{
				$primary_tab = 'prog_choice';
				$ref_column = 'vApplicationNo';
			}else if ($_REQUEST['sm'] == 4 || $_REQUEST['sm'] == 5 || ($_REQUEST['sm'] >= 7 && $_REQUEST['sm'] <= 10))//student
			{
				$primary_tab = 's_m_t';
				$ref_column = 'vMatricNo';
			}else if ($_REQUEST['sm'] == 6)
			{
				return 1;
			}else if ($_REQUEST['sm'] == 9)//topup or odl
			{

			}
		}else if ($_REQUEST['mm'] == '4')
		{
            if ($_REQUEST['sm'] == 1 || $_REQUEST['sm'] == 2)
			{
				$primary_tab = 'prog_choice';
				$ref_column = 'vApplicationNo';
			}else if ($_REQUEST['sm'] == 3 || $_REQUEST['sm'] == 4 || $_REQUEST['sm'] == 6 || $_REQUEST['sm'] == 7)
			{
				$primary_tab = 's_m_t';
				$ref_column = 'vMatricNo';
			}else if ($_REQUEST['sm'] == 5)
			{
				return 1;
			}else if ($_REQUEST['sm'] == 7 || $_REQUEST['sm'] == 8)
			{
				if ($_REQUEST['id_no'] == 0)//applicant
				{
					$primary_tab = 'prog_choice';
					$ref_column = 'vApplicationNo';
				}else if ($_REQUEST['id_no'] == 1)//student
				{
					$primary_tab = 's_m_t';
					$ref_column = 'vMatricNo';
				}
			}
		}else if ($_REQUEST['mm'] == '5')
		{
      		if ($_REQUEST['sm'] == 1 || $_REQUEST['sm'] == 8)//applicant
			{
				if ($_REQUEST['id_no'] == 0)//applicant
				{
					$primary_tab = 'prog_choice';
					$ref_column = 'vApplicationNo';
				}else if ($_REQUEST['id_no'] == 1)//student
				{
					$primary_tab = 's_m_t';
					$ref_column = 'vMatricNo';
				}
			}else if ($_REQUEST['sm'] == 2 || $_REQUEST['sm'] == 3)//applicant
			{
				$primary_tab = 'prog_choice';
				$ref_column = 'vApplicationNo';
			}else if ($_REQUEST['sm'] == 4 || $_REQUEST['sm'] == 5 || $_REQUEST['sm'] == 7)//student
			{
				$primary_tab = 's_m_t';
				$ref_column = 'vMatricNo';
			}else if ($_REQUEST['sm'] == 6)
			{
				return 1;
			}
		}else if (isset($_REQUEST['mm']) && isset($_REQUEST['sm']) && $_REQUEST['mm'] == '6')
		{
			return 1;
		}else if (isset($_REQUEST['mm']) && isset($_REQUEST['sm']) && $_REQUEST['mm'] == '7')
		{
			return 1;
		}
				
		$stmt = $mysqli->prepare("SELECT * FROM userlogin a, user_mode c, $primary_tab b
		WHERE c.vApplicationNo = a.vApplicationNo 
		AND c.study_mode_ID = b.study_mode
		AND c.study_mode_ID = ?
		AND a.vApplicationNo = ? 
		AND b.$ref_column = ?");
		$stmt->bind_param("sss", $_REQUEST['study_mode'], $_REQUEST['vApplicationNo'], $_REQUEST['uvApplicationNo']);
		$stmt->execute();
		$stmt->store_result();
		return $stmt->num_rows;
	}
	return 1;
}


function rpts_frms_vars()
{?>
	<input id="whc_lnk" name="whc_lnk" type="hidden" value="<?php if (isset($_REQUEST['whc_lnk'])){echo $_REQUEST['whc_lnk'];}else{echo 'sf';}?>">
	
	<input name="tmpvar" type="hidden" value="">
	<input name="fwd" type="hidden">
	<input name="tabno" type="hidden" value="<?php if (isset($_REQUEST['tabno'])){echo $_REQUEST['tabno'];}?>">

	<input name="hdexp_reg" type="hidden" value="<?php if (isset($_REQUEST['hdexp_reg'])){echo $_REQUEST['hdexp_reg'];}?>">
	<input name="hdact_reg" type="hidden" value="<?php if (isset($_REQUEST['hdact_reg'])){echo $_REQUEST['hdact_reg'];}?>">
	<input name="hdsrc_tbl" type="hidden" value="<?php if (isset($_REQUEST['hdsrc_tbl'])){echo $_REQUEST['hdsrc_tbl'];}?>">
	<input name="hdxtra_col" id="hdxtra_col" type="hidden" value="<?php if (isset($_REQUEST['hdxtra_col'])){echo $_REQUEST['hdxtra_col'];}?>">
	<input name="hdcol_name" id="hdcol_name" type="hidden" value="<?php if (isset($_REQUEST['hdcol_name'])){echo $_REQUEST['hdcol_name'];}?>">
	
	<input name="hdcol_width" id="hdcol_width" type="hidden" value="<?php if (isset($_REQUEST['hdcol_width'])){echo $_REQUEST['hdcol_width'];}?>">

	<input name="hdsuppl_lst" type="hidden" value="<?php if (isset($_REQUEST['hdsuppl_lst'])){echo $_REQUEST['hdsuppl_lst'];}?>">
	<input name="hdpage_fetch" type="hidden" value="<?php if (isset($_REQUEST['hdpage_fetch'])){echo $_REQUEST['hdpage_fetch'];}?>">
	<input name="hdln_page" type="hidden" value="<?php if (isset($_REQUEST['hdln_page'])){echo $_REQUEST['hdln_page'];}?>">

	
	<input name="crit1lab" id="crit1lab" type="hidden" value="<?php if (isset($_REQUEST['crit1lab'])){echo $_REQUEST['crit1lab'];}?>"/>
	<input name="crit2lab" id="crit2lab" type="hidden" value="<?php if (isset($_REQUEST['crit2lab'])){echo $_REQUEST['crit2lab'];}?>"/>
	<input name="crit3lab" id="crit3lab" type="hidden" value="<?php if (isset($_REQUEST['crit3lab'])){echo $_REQUEST['crit3lab'];}?>"/>
	<input name="crit4lab" id="crit4lab" type="hidden" value="<?php if (isset($_REQUEST['crit4lab'])){echo $_REQUEST['crit4lab'];}?>"/>
	<input name="crit5lab" id="crit5lab" type="hidden" value="<?php if (isset($_REQUEST['crit5lab'])){echo $_REQUEST['crit5lab'];}?>"/>
	<input name="crit6lab" id="crit6lab" type="hidden" value="<?php if (isset($_REQUEST['crit6lab'])){echo $_REQUEST['crit6lab'];}?>"/>
	<input name="crit7lab" id="crit7lab" type="hidden" value="<?php if (isset($_REQUEST['crit7lab'])){echo $_REQUEST['crit7lab'];}?>"/>
	<input name="crit8lab" id="crit8lab" type="hidden" value="<?php if (isset($_REQUEST['crit8lab'])){echo $_REQUEST['crit8lab'];}?>"/>
	<input name="crit9lab" id="crit9lab" type="hidden" value="<?php if (isset($_REQUEST['crit9lab'])){echo $_REQUEST['crit9lab'];}?>"/>
	<input name="crit10lab" id="crit10lab" type="hidden" value="<?php if (isset($_REQUEST['crit10lab'])){echo $_REQUEST['crit10lab'];}?>"/>
	<input name="crit11lab" id="crit11lab" type="hidden" value="<?php if (isset($_REQUEST['crit11lab'])){echo $_REQUEST['crit11lab'];}?>"/>
	<input name="crit12lab" id="crit12lab" type="hidden" value="<?php if (isset($_REQUEST['crit12lab'])){echo $_REQUEST['crit12lab'];}?>"/>
	<input name="crit13lab" id="crit13lab" type="hidden" value="<?php if (isset($_REQUEST['crit13lab'])){echo $_REQUEST['crit13lab'];}?>"/>
	<input name="crit14lab" id="crit14lab" type="hidden" value="<?php if (isset($_REQUEST['crit14lab'])){echo $_REQUEST['crit14lab'];}?>"/>
	<input name="crit18lab" id="crit18lab" type="hidden" value="<?php if (isset($_REQUEST['crit18lab'])){echo $_REQUEST['crit18lab'];}?>"/>
	
	<input name="dir" type="hidden">
	<input name="clk" type="hidden" value="<?php if (isset($_REQUEST['clk'])){echo $_REQUEST['clk'];}?>">
	<input name="selection" id="selection" type="hidden" value="<?php if (isset($_REQUEST['selection'])){echo $_REQUEST['selection'];}?>">
	<input name="selectionst" id="selectionst" type="hidden" value="<?php if (isset($_REQUEST['selectionst'])){echo $_REQUEST['selectionst'];}?>">
	<input name="hdqry_type" id="hdqry_type" type="hidden" value="<?php if (isset($_REQUEST['hdqry_type'])){echo $_REQUEST['hdqry_type'];}else{echo '1';}?>">
	<input name="upd_frm" type="hidden" value="0">
	<input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />	

	<input name="service_mode" id="service_mode" type="hidden" value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}?>" />
	<input name="num_of_mode" id="num_of_mode" type="hidden" value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}?>" />

	<input name="user_centre" id="user_centre" type="hidden" value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}?>" />
	<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}?>" />
	
	<?php
}


function select_fee_srtucture($vMatricNo, $res_ctry)
{
	if ($res_ctry == 'NG')
	{
		$mysqli = link_connect_db();
		
		$stmt = $mysqli->prepare("SELECT tdate FROM s_tranxion_cr WHERE cTrntype = 'c' AND tdate < '2023-01-01' AND vMatricNo = ?");
        $stmt->bind_param("s", $vMatricNo);
        $stmt->execute();
        $stmt->store_result();
        $recods_found = $stmt->num_rows;
        $stmt->close();
		
		if ($recods_found > 0)
		{
			return " AND new_old_structure = 'o'";
		}else
		{
			return " AND new_old_structure = 'n'";
		}
	}else
	{
		return " AND new_old_structure = 'f'";
	}
}


function bar_codde($student_data, $vApplicationNo)
{
	$qr_code_file_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'qr_assets'.DIRECTORY_SEPARATOR;
	$set_qr_code_path = 'qr_assets/';

	if(!file_exists($qr_code_file_path)){
		mkdir($qr_code_file_path);
	}

	//$errorCorrectionLevel = 'L';
	//$errorCorrectionLevel = 'M';
	//$errorCorrectionLevel = 'Q';
	$errorCorrectionLevel = 'H';

	//$matrixPointSize = 1;
	$matrixPointSize = 2;
	//$matrixPointSize = 3;
	//$matrixPointSize = 4;
	// $matrixPointSize = 5;
	// $matrixPointSize = 6;
	// $matrixPointSize = 7;
	// $matrixPointSize = 8;
	// $matrixPointSize = 9;

	$frm_link	=	$student_data;
	$filename	=	$qr_code_file_path.'qr_'.$vApplicationNo.'.png';
	// After getting all the data, now pass all the value to generate QR code.
	QRcode::png($frm_link, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

	return $set_qr_code_path.basename($filename);
}


function send_token($purpose, $cap)
{
    include('../../PHPMailer/mail_con.php');
	
	$mysqli = link_connect_db();

	$subqry = '';

    date_default_timezone_set('Africa/Lagos');	
	$date2_0 = date("Y-m-d H:i:s");

	$date2 = date("Y-m-d");

	$stmt = $mysqli->prepare("SELECT ABS(TIMESTAMPDIFF(MINUTE,send_time,'$date2_0')), cused, vtoken FROM veri_token
	WHERE vApplicationNo = ?
	AND LEFT(send_time,10) = '$date2'
	ORDER BY send_time DESC LIMIT 1");

	$stmt->bind_param("s",$_REQUEST["vApplicationNo"]);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($minutes, $cused, $token);
	$stmt->fetch();

	$token1 = '';
    
	if (($minutes > 4 && $cused == 0) || $stmt->num_rows() == 0 || (isset($_REQUEST["token_request"]) && $_REQUEST["token_request"] == '1'))	
	{
		$token1 = openssl_random_pseudo_bytes(4);
		$token1 = bin2hex($token1);

		$stmt = $mysqli->prepare("DELETE FROM veri_token
    	WHERE vApplicationNo = ?
    	AND (LEFT(send_time,10) = '$date2' AND cused = '0')");
    	$stmt->bind_param("s",$_REQUEST["vApplicationNo"]);
    	$stmt->execute();
	}
	
	// if (isset($_REQUEST["token_request"]) && $_REQUEST["token_request"] == '1')	
	// {
	//     $stmt = $mysqli->prepare("delete FROM veri_token
    // 	WHERE vApplicationNo = ?
    // 	AND LEFT(send_time,10) = '$date2'");
    // 	$stmt->bind_param("s",$_REQUEST["vApplicationNo"]);
    // 	$stmt->execute();
	// }

	$stmt->close();

	$source_table1 = '';
	$source_table2 = '';
	$val_field = '';

	if ($token1 <> '')
	{
		$token = $token1;
		if ($_REQUEST['user_cat'] == '6' && isset($_REQUEST["ask_f_t"]) && $_REQUEST["ask_f_t"] == 1)
		{
			$val_field = $_REQUEST['staffid'];
		}else if ($_REQUEST['user_cat'] == '4' || $_REQUEST['user_cat'] == '5')
		{
			if (isset($_REQUEST['vMatricNo']))
			{
				$val_field = $_REQUEST['vMatricNo'];
			}

			if ($_REQUEST['user_cat'] == '4')
			{
				$source_table = 'prog_choice';
				$source_table2 = 'afnmatric';
			}else if ($_REQUEST['user_cat'] == '5')
			{
				$source_table = 's_m_t';
			}
		}else if ($_REQUEST['user_cat'] == '3')
		{
			$val_field = $_REQUEST['vApplicationNo'];
			$source_table = 'prog_choice';
		}else 
		{
			$val_field = $_REQUEST['vApplicationNo'];
			$source_table = 'userlogin';
		}
		
		if ($_REQUEST['user_cat'] == '4')
		{
			$stmt_1 = $mysqli->prepare("SELECT a.vFirstName, vEMailId
			FROM $source_table1 a, $source_table2 b
			WHERE a.vApplicationNo = b.vApplicationNo
			AND a.vApplicationNo = ?");
		}else
		{
			if ($_REQUEST['user_cat'] == '6')
			{
				if (isset($_REQUEST["ask_f_t"]) && $_REQUEST["ask_f_t"] == 1)
    			{
					$stmt_1 = $mysqli->prepare("SELECT 'Staff member', mail_id
					FROM mail_rec
					WHERE vApplicationNo = ?");
				}else
				{				
					$stmt_1 = $mysqli->prepare("SELECT vFirstName, cemail
					FROM $source_table
					WHERE vApplicationNo = ?");
				}
			}else
			{
				$stmt_1 = $mysqli->prepare("SELECT vFirstName, vEMailId
				FROM $source_table
				WHERE vApplicationNo = ?");
			}
		}
		
		$stmt_1->bind_param("s", $val_field);
		$stmt_1->execute();
		$stmt_1->store_result();
		$stmt_1->bind_result($vFirstName, $vEMailId);
		$stmt_1->fetch();
		$stmt_1->close();

		$vEMailId = $vEMailId ?? '';

		if (is_bool(strpos($vEMailId,"@noun.edu.ng")))
		{
			return 'NOUN official email required';
		}

		//$vEMailId = 'phadamoses@gmail.com';
		
		if (isset($_REQUEST["ask_f_t"]) && $_REQUEST["ask_f_t"] == 1)
    	{
			$subject = 'NOUN - Token for '.$purpose;
		}else
		{
			$subject = 'NOUN - Token for '.date("d-m-Y");
		}

		if (isset($_REQUEST["ask_f_t"]) && $_REQUEST["ask_f_t"] == 1)
    	{
			$mail_msg = "Dear Staff member,<br><br>
			Copy the token below and paste it in the appropriate box on the NOUN page.
			<p><b>$token</b>
			<p>Token expires in 10minutes";
		}else
		{
			$mail_msg = "Dear $vFirstName,<br><br>
			Copy the token below and paste it in the appropriate box on the NOUN page.
			<p><b>$token</b>";
		}

		$mail_msg .= "<p>Thank you";

		$mail_msg = wordwrap($mail_msg, 70);
		
		$date2 = date("Y-m-d h:i:s");
				
		$mail->addAddress($vEMailId, $vFirstName); // Add a recipient
		$mail->Subject = $subject;
		$mail->Body = $mail_msg;
		
		//for ($incr = 1; $incr <= 5; $incr++)
		//{
			try 
			{
				$mysqli->autocommit(FALSE); //turn on transactions
				
				if ($mail->send())
				{
					if(!empty($_SERVER['HTTP_CLIENT_IP'])) //whether ip is from the share internet
					{
						$ipee = $_SERVER['HTTP_CLIENT_IP'];  
					}else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) //whether ip is from the proxy
					{  
						$ipee = $_SERVER['HTTP_X_FORWARDED_FOR'];  
					}else//whether ip is from the remote address
					{  
						$ipee = $_SERVER['REMOTE_ADDR'];  
					}
					
					if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '')
					{
						$stmt = $mysqli->prepare("INSERT IGNORE INTO veri_token SET
						vApplicationNo = ?,
						uvApplicationNo = ?,
						vtoken = '$token',
						send_time = '$date2_0',
						purpose = ?");
						$stmt->bind_param("sss", $val_field, $_REQUEST["uvApplicationNo"], $purpose);
					}else
					{
						$stmt = $mysqli->prepare("INSERT IGNORE INTO veri_token SET
						vApplicationNo = ?,
						vtoken = '$token',
						send_time = '$date2_0',
						purpose = ?");
						$stmt->bind_param("ss", $val_field, $purpose);
					}
					$stmt->execute();
					$stmt->close();
					
					$stmt = $mysqli->prepare("INSERT INTO atv_log SET 
					vApplicationNo  = ?,
					vDeed = ?,
					act_location = ?,
					tDeedTime = '$date2'");
					$stmt->bind_param("sss", $val_field, $purpose, $ipee);
					$stmt->execute();
					$stmt->close();
					
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
					//break;
					
					//echo $token1;
				}
			} catch (Exception $e)
			{
				$mysqli->rollback(); //remove all queries from queue if error (undo)
				throw $e;
			}
		//}
	}

	return $token;
}


function validate_token($user_name, $purpose)
{
	$mysqli = link_connect_db();

    date_default_timezone_set('Africa/Lagos');	
	$date2 = date("Y-m-d H:i:s");
	$date2_0 = date("Y-m-d");
	
	/*$stmt = $mysqli->prepare("SELECT ABS(TIMESTAMPDIFF(MINUTE,send_time,'$date2')), send_time, vtoken, cused FROM veri_token
	WHERE vApplicationNo = ?
    AND vtoken = ?
	AND purpose = ?
	AND LEFT(send_time,10) = '$date2_0'"); SELECT * FROM veri_token WHERE vApplicationNo = '00062' AND vtoken = '0dd2a92' AND LEFT(send_time,10) = '2024-05-23';


	$stmt->bind_param("sss",$user_name, $_REQUEST["user_token"], $purpose);*/

	$stmt = $mysqli->prepare("SELECT * FROM veri_token
	WHERE vApplicationNo = ?
    AND vtoken = ?
	AND LEFT(send_time,10) = '$date2_0'");

	$stmt->bind_param("ss",$user_name, $_REQUEST["user_token"]);

	$stmt->execute();
	$stmt->store_result();
	
	/*$stmt->bind_result($minutes, $send_time, $token, $cused);
	$stmt->fetch();

	if ($purpose == 'verifying credentials')
	{
		if ($minutes > 360 || $stmt->num_rows() == 0 || $cused >= 20)	
		{
			return 'Invalid token';
		}
	}else if ($purpose == 'confirmation of payment')
	{
		if ($minutes > 15 || $stmt->num_rows() == 0 || $cused >= 20)	
		{
			return 'Invalid token';
		}
	}else if ($purpose == 'releasing of form')
	{
		if ($minutes > 20 || $stmt->num_rows() == 0 || $cused >= 20)	
		{
			return 'Invalid token';
		}
	}else if ($purpose == 'change of study centre')
	{
		if ($minutes > 20 || $stmt->num_rows() == 0)	
		{
			return 'Invalid token';
		}
	}else if ($purpose == 'change of study centre')
	{
		if ($minutes > 20 || $stmt->num_rows() == 0)	
		{
			return 'Invalid token';
		}
	}else if ($purpose == 'password recovery')
	{
		if ($minutes > 10 || $stmt->num_rows() == 0)	
		{
			return 'Invalid token';
		}
	}*/
	
	if ($stmt->num_rows() == 0)	
	{
		return 'Invalid token';
	}

	if (isset($_REQUEST["use_t"]) && $_REQUEST["use_t"] == 1)
    {
		$stmt = $mysqli->prepare("DELETE FROM veri_token WHERE vApplicationNo = ? AND vtoken = ?");
	}else
	{
    	$stmt = $mysqli->prepare("UPDATE veri_token SET cused = cused + 1, used_time = '$date2' WHERE vApplicationNo = ? AND vtoken = ?");
	}
    $stmt->bind_param("ss", $user_name, $_REQUEST["user_token"]); 
    $stmt->execute();
    $stmt->close();
    
    log_actv('Used token : '.$_REQUEST["user_token"]);
    
    return 'Token valid';
}


function match_user_client_dept($cdeptId_u, $client_d)
{
	$mysqli = link_connect_db();

	if (substr($client_d,0,3) == 'NOU' || substr($client_d,0,3) == 'COL')
	{
		$stmt = $mysqli->prepare("SELECT * from s_m_t where cdeptId = '$cdeptId_u' AND vMatricNo = ?");
	}else
	{
		$stmt = $mysqli->prepare("SELECT a.* from prog_choice a, programme b where a.cProgrammeId = b.cProgrammeId  AND b.cdeptId = '$cdeptId_u' AND  vApplicationNo = ?");
	}

	$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
	$stmt->execute();
	$stmt->store_result();

	$record_found = $stmt->num_rows;
	$stmt->close();

	return $record_found;
}


function stfn_role_id($id)
{
    $mysqli = link_connect_db();
    
    $stmt_a = $mysqli->prepare("SELECT * FROM role_user WHERE vUserId = ? and sRoleID = '$id'");
    $stmt_a->bind_param("s", $_REQUEST['vApplicationNo']);
    $stmt_a->execute();
    $stmt_a->store_result();
    return $stmt_a->num_rows;
}


function check_file($size, $case)
{
	if (!isset($_FILES['sbtd_pix']))
	{
		return 'File not selected';
	}
	
	$filepath = $_FILES['sbtd_pix']['tmp_name'];
	$fileSize = filesize($filepath);
	if ($fileSize == 0)
	{
		return 'Cannot upload empty file';
	}
	
	$fileinfo = finfo_open(FILEINFO_MIME_TYPE);
	$filetype = finfo_file($fileinfo, $filepath);

	

    if ($case == 1)
	{
	    if ($fileSize > $size)
	    {
	        return "The file is too large. Max is ".($size/1000000)."MB";
	    }
	}else if ($case == 2)
    {
    	if ($fileSize > $size)
	    {
	        return "The file is too large. Max is ".($size/1000)."KB";
	    }
    }
	
	if ($case == 1)
	{
		$allowedTypes = array(
			'text/csv',
			'application/csv',
			'text/comma-separated-values',
			'text/anytext',
			'application/octet-stream',
			'application/txt',
		);
	}else if ($case == 2)
	{
		$allowedTypes = array(
			'image/jpeg',
		);

		$image_properties = getimagesize($filepath);
	}

	if (!in_array($filetype, $allowedTypes))
	{
		if ($case == 1)
		{
			return "Select a csv file to upload";
		}else if ($case == 2)
		{
			return "Select a jpg file to upload";
		}
	}

	return '';
}


function call_f_file()
{
	$afn = '';
	if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '')
	{
		$afn = $_REQUEST["uvApplicationNo"];
	}else if (isset($_REQUEST["uvApplicationNo04"]) && $_REQUEST["uvApplicationNo04"] <> '')
	{
		$afn = $_REQUEST["uvApplicationNo04"];
	}

	//get rrr_surname_date from a db

	$file = '../ext_docs/p_cc/rrr_surname_date.pdf';
	if (file_exists($file))
	{
		return $file;
	}

	$file = '../ext_docs/u_cc/rrr_surname_date.pdf';
	if (file_exists($file))
	{
		return $file;
	}

	return '';
	//return '../ext_docs/project_report_template/msc_Undergraduate_Project_Format.pdf';
}


function chk_mail($email)
{
    $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

    if (preg_match($pattern, $email))
    {
        return 1;
    }else
    {
        return 0;
    }
}


function search_starting_pt_c($ref_no)
{
    if(substr($ref_no,3,2) <= 19)
	{
		//$tables = '20172019,20202021,20222023,20242025';
		$tables = '2017,2018,2019,20202021,20222023,20242025';
	}else if(substr($ref_no,3,2) == 20 || substr($ref_no,3,2) == 21)
	{
		$tables = '20202021,20222023,20242025';
	}else if(substr($ref_no,3,2) == 22 || substr($ref_no,3,2) == 23)
	{
		$tables = '20222023,20242025';
	}else
	{
		$tables = '20242025';
	}	
	return explode(",", $tables);
}

function search_starting_pt_crs($ref_no)
{
    if(substr($ref_no,3,2) <= 19)
	{
		$tables = '20172019,20202021,20222023,20242025';
		//$tables = '2017,2018,2019,20202021,20222023,20242025';
	}else if(substr($ref_no,3,2) == 20 || substr($ref_no,3,2) == 21)
	{
		$tables = '20202021,20222023,20242025';
	}else if(substr($ref_no,3,2) == 22 || substr($ref_no,3,2) == 23)
	{
		$tables = '20222023,20242025';
	}else
	{
		$tables = '20242025';
	}	
	return explode(",", $tables);
}

function clean_str($str)
{
	$chars = array("\r\n", '\\n', '\\r', "\n", "\r", "\t", "\0", "\x0B", "\x0A", "\xA0");
	$str = str_replace($chars,"",$str);

	$str = str_replace("\xc2\xa0", '', $str);
	
	$str = str_replace(chr(130), '', $str);    	// baseline single quote
	$str = str_replace(chr(131), '', $str);  	// florin
	$str = str_replace(chr(132), '', $str);    	// baseline double quote
	$str = str_replace(chr(133), '', $str);  	// ellipsis
	$str = str_replace(chr(134), '', $str);   	// dagger (a second footnote)
	$str = str_replace(chr(135), '', $str);  	// double dagger (a third footnote)
	$str = str_replace(chr(136), '', $str);    	// circumflex accent
	$str = str_replace(chr(137), '', $str); 	// permile
	$str = str_replace(chr(138), '', $str);   	// S Hacek
	$str = str_replace(chr(139), '', $str);    	// left single guillemet
	$str = str_replace(chr(140), '', $str);   	// OE ligature
	$str = str_replace(chr(145), "", $str);    	// left single quote
	$str = str_replace(chr(146), "", $str);    	// right single quote
	$str = str_replace(chr(147), '', $str);    	// left double quote
	$str = str_replace(chr(148), '', $str);    	// right double quote
	$str = str_replace(chr(149), '', $str);    	// bullet
	$str = str_replace(chr(150), '', $str);    	// endash
	$str = str_replace(chr(151), '', $str);   	// emdash
	$str = str_replace(chr(152), '', $str);    	// tilde accent
	$str = str_replace(chr(153), '', $str); 	// trademark ligature
	$str = str_replace(chr(154), '', $str);   	// s Hacek
	$str = str_replace(chr(155), '', $str);    	// right single guillemet
	$str = str_replace(chr(156), '', $str);   	// oe ligature
	$str = str_replace(chr(159), '', $str);    	// Y Dieresis
	//force convert to ISO-8859-1 then convert back to UTF-8 to remove the rest of unknown hidden characters
	$str = iconv("UTF-8","ISO-8859-1//IGNORE",$str);
	$str = iconv("ISO-8859-1","UTF-8",$str);

	$str = preg_replace('/[\x00-\x08\x0B-\x1F]/', '', $str);

	return $str;
}


function clean_string($value, $str_type)
{
	if (is_null($value))
	{
		return '';
	}

	$str_array = str_split($value);

	$return_val = '';
	foreach ($str_array as $val_arr)
	{
		$cap_ltrs = (ord($val_arr) >= 65 && ord($val_arr) <= 90);
		$smal_ltrs = (ord($val_arr) >= 97 && ord($val_arr) <= 122);
		$numbers = (ord($val_arr) >= 48 && ord($val_arr) <= 57);

		$hyphen = ord($val_arr) == 45;
		$period = ord($val_arr) == 46;
		$space = ord($val_arr) == 32;
		$coma = ord($val_arr) == 44;
		$colon = ord($val_arr) == 58;
		$slash = ord($val_arr) == 47;

		$at = ord($val_arr) == 64;
		$underscore = ord($val_arr) == 95;
		
		if ($str_type == 'email')
		{
			if ($cap_ltrs || $smal_ltrs || $numbers || $hyphen || $period || $at || $underscore)
			{
				$return_val .= $val_arr;
			}
		}else if ($str_type == 'matno')
		{
			if ($cap_ltrs || $smal_ltrs || $numbers)
			{
				$return_val .= $val_arr;
			}
		}else if ($str_type == 'names')
		{
			if ($cap_ltrs || $smal_ltrs || $hyphen || $space)
			{
				$return_val .= $val_arr;
			}
		}else if ($str_type == 'letters')
		{
			if ($cap_ltrs || $smal_ltrs)
			{
				$return_val .= $val_arr;
			}
		}else if ($str_type == 'numbers')
		{
			if ($numbers)
			{
				$return_val .= $val_arr;
			}
		}else if ($str_type == 'sentence')
		{
			if ($numbers || $cap_ltrs || $smal_ltrs || $hyphen || $period || $space || $coma || $colon || $slash)
			{
				$return_val .= $val_arr;
			}
		}
	}

	return $return_val;
}



function assign_matno_admin($cdeptId)
{
	$mysqli = link_connect_db();
	$orgsetins = settns();
	$adm_session = substr($orgsetins['cAcademicDesc'],2,2);
    $conr_matno = '0';
	
	while (1 == 1)
	{
		$sied = random_int(1000, 9999999);
		$sied = str_pad($sied, 7, "0", STR_PAD_LEFT);

		$rs_grad_record = 0;
		$s_number = $adm_session.$sied;
    	$stmt = $mysqli->prepare("SELECT * FROM s_m_t_grad_mat_list WHERE vMatricNo LIKE '%$s_number%';");
    	$stmt->execute();
    	$stmt->store_result();
		$rs_grad_record = $stmt->num_rows;
		
		$rs_client_record = 0;

    	$stmt = $mysqli->prepare("SELECT * FROM rs_client WHERE vMatricNo LIKE '%$sied';");
    	$stmt->execute();
    	$stmt->store_result();
		$rs_client_record = $stmt->num_rows;

    	$stmt = $mysqli->prepare("SELECT * FROM s_m_t WHERE vMatricNo LIKE '%$sied';");
    	$stmt->execute();
    	$stmt->store_result();
		$rs_student_record = $stmt->num_rows;
		
		$stmt = $mysqli->prepare("SELECT * FROM afnmatric WHERE vMatricNo LIKE '%$sied'");
		$stmt->execute();
		$stmt->store_result();
		$rs_afnmatric_record = $stmt->num_rows;
		if ($rs_afnmatric_record == 0 && $rs_client_record == 0 && $rs_grad_record == 0 && $rs_student_record == 0)
		{
		    $orgsetins = settns();
		
    		$stmt = $mysqli->prepare("select matnoprefix1, matnoprefix2, prefix_by_faculty,
    		prefix_by_dept, prefix_by_yr, matnosepa, matnosufix, matnumber, mat_comp_orda, 
    		place_sepa1, place_sepa2, place_sepa3, place_sepa4, place_sepa5, place_sepa7 
    		from mat_composi");
    		//$stmt->bind_param("s", $study_mode_ist);
    		$stmt->execute();
    		$stmt->store_result();
    		$stmt->bind_result($matnoprefix1, $matnoprefix2, $prefix_by_faculty,
    		$prefix_by_dept, $prefix_by_yr, $matnosepa, $matnosufix, $matnumber, $mat_comp_orda, 
    		$place_sepa1, $place_sepa2, $place_sepa3, $place_sepa4, $place_sepa5, $place_sepa7);
    		$stmt->fetch();
    				
    		//$adm_session = substr($orgsetins['applic_session'],2,2);
    		//$adm_session = substr($orgsetins['cAcademicDesc'],7,2);
    		//$adm_session = substr($orgsetins['cAcademicDesc'],2,2);
            
    		$arr = str_split($mat_comp_orda);
    		$suffix = ''; 
    		$prefix = '';		
    		
    		for ($i = 0; $i <= count($arr)-1; $i++)
    		{
    			switch ($arr[$i]) 
    			{
    				case 1:
    					if ($place_sepa1 == '1'){$suffix = $suffix . $matnosepa . $matnoprefix1;}
    					else{$prefix = $prefix . $matnoprefix1 . $matnosepa;}
    					break;
    				case 2:
    					if ($orgsetins['place_sepa2'] == '1')
    					{
    						$suffix = $suffix . $matnosepa . $orgsetins['matnoprefix2'];
    					}else
    					{
    						$prefix = $prefix . $orgsetins['matnoprefix2'] . $matnosepa;
    					}
    					break;
    				case 3:					
    					$stmt1 = $mysqli->prepare("select cFacultyId from prog_choice where vApplicationNo = ?");
    					$stmt1->bind_param("s",$_REQUEST["uvApplicationNo"]);
    					$stmt1->execute();
    					$stmt1->store_result();
    					$stmt1->bind_result($cFacultyId);
    					$stmt1->fetch();
    					$stmt1->close();
    					
    					if ($place_sepa3 == '1'){$suffix = $suffix . $matnosepa . $cFacultyId;}
    					else{$prefix = $prefix . $cFacultyId . $matnosepa;}
    					break;
    				case 4:
    					$stmt1 = $mysqli->prepare("SELECT cdeptId from prog_choice a, programme b 
    					where a.cProgrammeId = b.cProgrammeId 
    					and vApplicationNo = ?");
    					$stmt1->bind_param("s",$_REQUEST["uvApplicationNo"]);
    					$stmt1->execute();
    					$stmt1->store_result();
    					$stmt1->bind_result($cdeptId);
    					$stmt1->fetch();
    					$stmt1->close();
    					if ($place_sepa4 == '1'){$suffix = $suffix . $matnosepa . $cdeptId;}
    					else{$prefix = $prefix . $cdeptId . $matnosepa;}
    					break;
    				case 5:
    					if ($place_sepa5 == '1'){$suffix = $suffix . $matnosepa . $adm_session;}
    					else{$prefix = $prefix . $adm_session . $matnosepa;}
    					break;
    				case 7:
    					if ($place_sepa7 == '1'){$suffix = $suffix . $matnosepa . $matnosufix;}
    					else{$prefix = $prefix . $matnosufix . $matnosepa;}
    					break;
    			}
    		}
    	
    		$conr_matno = $prefix.$sied.$suffix;
		    break;
		}
	}
	
	if ($cdeptId == 'CPE')
	{
		$conr_matno = 'COL'.substr($conr_matno,3,9);
	}
	

	//create new student account
	$sqlins_matno = "INSERT IGNORE INTO rs_client SET
	vMatricNo = '$conr_matno',
	vPassword = 'frsh'";
	if (!mysqli_query(link_connect_db(), $sqlins_matno)){die('Error inserting rs_client ' . mysqli_error(link_connect_db()));}
	
	$stmt = $mysqli->prepare("INSERT IGNORE INTO afnmatric SET
	vApplicationNo = ?,
	ikeyMatric = '0',
	vMatricNo = '$conr_matno',
	dtStatusDate = now()");
	$stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
	$stmt->execute();
	
	// $stmt = $mysqli->prepare("UPDATE prog_choice SET
	// cSbmtd = '1' 
	// WHERE cSbmtd <> '2' 
	// AND vApplicationNo = ?");
	// $stmt->bind_param("s", $_REQUEST['vApplicationNo']);
	// $stmt->execute();
	
	$stmt->close();
	
	//log_actv('submitted application form');

	//return $conr_matno;
}


function assign_matno_cert_admin()
{
	$mysqli = link_connect_db();
	
	$mat = "NOU0".$_REQUEST['uvApplicationNo'];
	
	try
	{
		$mysqli->autocommit(FALSE); //turn on transactions

		$stmt = $mysqli->prepare("INSERT IGNORE INTO afnmatric SET
		vApplicationNo = ?,
		ikeyMatric = 0,
		vMatricNo = ?,
		dtStatusDate = now()");
		$stmt->bind_param("ss",$_REQUEST['uvApplicationNo'], $mat);
		$stmt->execute();

		$stmt = $mysqli->prepare("UPDATE prog_choice SET
		cSbmtd = '1' 
		WHERE cSbmtd <> '2' 
		AND vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
		$stmt->execute();

		$stmt = $mysqli->prepare("INSERT IGNORE INTO rs_client SET
		vMatricNo = '$mat',
		vPassword = 'frsh'");
		$stmt->execute();

		$stmt->close();

		$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
	}catch(Exception $e) 
	{
		$mysqli->rollback(); //remove all queries from queue if error (undo)
		throw $e;
	}
}


function assign_matno_cert_chd_admin()
{
	$mysqli = link_connect_db();

	$stmt = $mysqli->prepare("SELECT a.cProgrammeId, a.cEduCtgId, cdeptId 
	FROM prog_choice a, programme b
	WHERE a.cProgrammeId = b.cProgrammeId
	AND vApplicationNo = ?");
	$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cProgrammeId, $cEduCtgId, $cdeptId);
	$stmt->fetch();

	$currentyear = date("y");
	
	//while (1 == 1)
	//{
		if ($cEduCtgId == 'ELX')
		{
			$cat = 'C_';
		}else
		{
			$cat = 'D_';
		}

		if ($cdeptId == 'PCC')
		{
			$mat = "NOUN_SNL_PCC_".$cat.$currentyear."_";	
		}else if ($cdeptId == 'ACL')
		{
			$mat = "NOUN_".$cdeptId."_";
			if ($cProgrammeId == 'CHD002')
			{
				$mat1 = "ACS_";
			}else if ($cProgrammeId == 'CHD003')
			{
				$mat1 = "TYT_";
			}else if ($cProgrammeId == 'CHD004')
			{
				$mat1 = "TSC_";
			}else if ($cProgrammeId == 'CHD005')
			{
				$mat1 = "ADT_";
			}else if ($cProgrammeId == 'CHD006')
			{
				$mat1 = "CPI_";
			}else if ($cProgrammeId == 'CHD007')
			{
				$mat1 = "MEV_";
			}else if ($cProgrammeId == 'CHD007')
			{
				$mat1 = "MEV_";
			}else if ($cProgrammeId == 'CHD008')
			{
				$mat1 = "SOL_";
			}else if ($cProgrammeId == 'CHD009')
			{
				$mat1 = "AUE_";
			}

			$mat .= $mat1.$cat.$currentyear."_";
		}
		
		$cdept = "_".$cdeptId."_";
		$caat = "_".$cat;

		$stmt = $mysqli->prepare("SELECT LPAD(MAX(RIGHT(vMatricNo,3))+1,3,'0') 
		FROM afnmatric
		WHERE vMatricNo LIKE 'NOUN%'
		AND vMatricNo LIKE '%$caat%'
		AND vMatricNo LIKE '%$cdept%'");
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($nxt_no);
		$stmt->fetch();
		$stmt->close();

		if (is_numeric($nxt_no))
		{
			$nxt_no = str_pad($nxt_no, 3, "0", STR_PAD_LEFT);
		}else
		{
			$nxt_no = $nxt_no ?? '001';
		}

		$mat .= "$nxt_no";	
		

		$rs_grad_record = 0;
		$s_number = $adm_session.$sied;
		$stmt = $mysqli->prepare("SELECT * FROM s_m_t_grad_mat_list WHERE vMatricNo LIKE '$mat';");
		$stmt->execute();
		$stmt->store_result();
		$rs_grad_record = $stmt->num_rows;
		
		$rs_client_record = 0;
		$stmt = $mysqli->prepare("SELECT * FROM rs_client WHERE vMatricNo LIKE '$mat';");
		$stmt->execute();
		$stmt->store_result();
		$rs_client_record = $stmt->num_rows;

		$stmt = $mysqli->prepare("SELECT * FROM s_m_t WHERE vMatricNo LIKE '$mat';");
		$stmt->execute();
		$stmt->store_result();
		$rs_student_record = $stmt->num_rows;
		
		$stmt = $mysqli->prepare("SELECT * FROM afnmatric WHERE vMatricNo LIKE '$mat'");
		$stmt->execute();
		$stmt->store_result();
		$rs_afnmatric_record = $stmt->num_rows;

		// if ($rs_afnmatric_record == 0 && $rs_client_record == 0 && $rs_grad_record == 0 && $rs_student_record == 0)
		// {
		// 	break;
		// }
	//}
	
	try
	{
		$mysqli->autocommit(FALSE); //turn on transactions

		$stmt = $mysqli->prepare("INSERT IGNORE INTO afnmatric SET
		vApplicationNo = ?,
		ikeyMatric = 0,
		vMatricNo = ?,
		dtStatusDate = now()");
		$stmt->bind_param("ss",$_REQUEST['uvApplicationNo'], $mat);
		$stmt->execute();

		$stmt = $mysqli->prepare("UPDATE prog_choice SET
		cSbmtd = '1' 
		WHERE cSbmtd <> '2' 
		AND vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
		$stmt->execute();

		$stmt = $mysqli->prepare("INSERT IGNORE INTO rs_client SET
		vMatricNo = '$mat',
		vPassword = 'frsh'");
		$stmt->execute();

		$stmt->close();

		$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
	}catch(Exception $e) 
	{
		$mysqli->rollback(); //remove all queries from queue if error (undo)
		throw $e;
	}
}