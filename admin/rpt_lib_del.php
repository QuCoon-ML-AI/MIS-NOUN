<?php

function std_cat()
{
	$str = '';
	if ($_REQUEST['std_cat'] == 'a')
	{
		$str = "From prog_choice a, pers_info r, ";
		//$str .= "pers_info r, ";
		$GLOBALS['sqlwhere'] .= "WHERE r.vApplicationNo = a.vApplicationNo AND ";
		
		// if ($_REQUEST['hdqry_type'] == 3)
		// {
		// 	$str .= "afnmatric t, ";
		// 	$GLOBALS['sqlwhere'] .= "t.vApplicationNo = a.vApplicationNo AND ";
		// }
	}else if ($_REQUEST['std_cat'] == 'b')
	{
		$str = "From prog_choice a, pers_info r, ";
		//$str .= "pers_info r, ";
		$GLOBALS['sqlwhere'] .= "WHERE r.vApplicationNo = a.vApplicationNo AND ";
		
		if ($_REQUEST['hdqry_type'] == 3)
		{
			$str .= "afnmatric t, ";
			$GLOBALS['sqlwhere'] .= "t.vApplicationNo = a.vApplicationNo AND ";
		}
	}else if ($_REQUEST['std_cat'] == 'c' || $_REQUEST['hdqry_type'] == 3)
	{
		$str = "FROM s_m_t a, ";	
		$GLOBALS['sqlwhere'] .= "WHERE ";
	}

	return $str;
}


function compose_cols()
{
    $selection = $_REQUEST['selection'];

    for ($t = 0; $t <= strlen($selection)-1; $t++)
	{
		switch (substr($selection,$t,1))
		{
			case "a": //centre
				if (isset($_REQUEST['col19']) && $_REQUEST['col19'] == 's')//showw state?
				{
					if (isset($_REQUEST['crit1']) && $_REQUEST['crit1'] == '')
					{
						$GLOBALS['sqlselect'] .= "ng1.vStateName AS 'State of Centre', s1.vCityName AS 'Study Centre', ";
					}
					$GLOBALS['sqlfrom'] .= "studycenter s1, ng_state ng1, ";
					$GLOBALS['sqlwhere'] .= "s1.cStudyCenterId = a.cStudyCenterId AND ng1.cStateId = s1.cStateId AND ";
				}else
				{
					if ($_REQUEST['crit1'] == '')
					{
						$GLOBALS['sqlselect'] .= "s1.vCityName AS 'Study Centre', ";
					}
					$GLOBALS['sqlfrom'] .= "studycenter s1, ";
					$GLOBALS['sqlwhere'] .= "s1.cStudyCenterId = a.cStudyCenterId AND ";
				}

				if ($_REQUEST['hdqry_type'] == '1')
				{
					if (isset($_REQUEST['show_state']))
					{
						$GLOBALS['sqlgrp'] .= "s1.cStateId, ";
					}
					$GLOBALS['sqlgrp'] .= "s1.cStudyCenterId, ";
				}
			break;

			case "b": //school
				if (!isset($_REQUEST['crit5']) || (isset($_REQUEST['crit5']) && $_REQUEST['crit5'] == ''))
				{
					if ($_REQUEST['crit2'] == '')
					{
						if (isset($_REQUEST['col9']) && $_REQUEST['col9'] == 'i')//show faculty name in full
						{
							$GLOBALS['sqlselect'] .= "f1.vFacultyDesc AS School, ";
						}else
						{
							$GLOBALS['sqlselect'] .= "a.cFacultyId AS School, ";
						}
					}
					$GLOBALS['sqlfrom'] .= "faculty f1, ";
					$GLOBALS['sqlwhere'] .= "a.cFacultyId = f1.cFacultyId AND ";
	
					if ($_REQUEST['hdqry_type'] == '1')
					{
						$GLOBALS['sqlgrp'] .= "a.cFacultyId, ";
					}
				}
			break;
			
			case "c": //department
				if (!isset($_REQUEST['crit3']) || (isset($_REQUEST['crit3']) && $_REQUEST['crit3'] == ''))
				{
					$GLOBALS['sqlselect'] .= "dpt.vdeptDesc AS vdeptDesc, ";
				}
				$GLOBALS['sqlfrom'] .= "depts dpt, ";				

				if (!is_bool(strpos($GLOBALS['sqlfrom'], "faculty f1, ")))
				{
					$GLOBALS['sqlwhere'] .= "f1.cFacultyId = dpt.cFacultyId AND ";
				}

				// if (is_bool(strpos($selection, "d")))
				// {
				// 	$GLOBALS['sqlfrom'] .= "programme p, ";
				// }

				if (strpos($GLOBALS['sqlfrom'], "programme p, ") === false)
				{
					$GLOBALS['sqlfrom'] .= "programme p, ";
				}

				if (is_bool(strpos($GLOBALS['sqlwhere'], "a.cProgrammeId = p.cProgrammeId AND ")))
				{
					$GLOBALS['sqlwhere'] .= "a.cProgrammeId = p.cProgrammeId AND ";
				}
				$GLOBALS['sqlwhere'] .= "p.cdeptId = dpt.cdeptId AND ";

				if ($_REQUEST['hdqry_type'] == '1')
				{
					$GLOBALS['sqlgrp'] .= "dpt.cdeptId, ";
				}
			break;			
			
			case "d": //programme
				if (isset($_REQUEST['col3']) && isset($_REQUEST['col10']) && $_REQUEST['col10'] == 'c')
				{
					if (!isset($_REQUEST['crit4']) || (isset($_REQUEST['crit4']) && $_REQUEST['crit4'] == ''))
					{
						$GLOBALS['sqlselect'] .= "CONCAT(o.vObtQualTitle,' ',p.vProgrammeDesc) AS Programme, ";
					}

					if (is_bool(strpos($selection, "c")))
					{
						$GLOBALS['sqlfrom'] .= "depts dpt, ";
					}

					if (strpos($GLOBALS['sqlfrom'], "programme p, ") === false)
					{
						$GLOBALS['sqlfrom'] .= "programme p, ";
					}

					if (strpos($GLOBALS['sqlfrom'], "obtainablequal o, ") === false)
					{
						$GLOBALS['sqlfrom'] .= "obtainablequal o, ";
					}
					
					if (is_bool(strpos($GLOBALS['sqlwhere'], "a.cProgrammeId = p.cProgrammeId AND ")))
					{
						$GLOBALS['sqlwhere'] .= "a.cProgrammeId = p.cProgrammeId AND ";
					}
					$GLOBALS['sqlwhere'] .= "p.cObtQualId = o.cObtQualId AND dpt.cdeptId = p.cdeptId AND ";
				}else if (isset($_REQUEST['col10']) && $_REQUEST['col10'] == 'j')
				{
					if ($_REQUEST['crit4'] == '')
					{
						$GLOBALS['sqlselect'] .= "CONCAT(o.vObtQualTitle,' ',p.vProgrammeDesc) AS Programme, ";
					}

					if (strpos($GLOBALS['sqlfrom'], "programme p, ") === false)
					{
						$GLOBALS['sqlfrom'] .= "programme p, ";
					}

					if (strpos($GLOBALS['sqlfrom'], "obtainablequal o, ") === false)
					{
						$GLOBALS['sqlfrom'] .= "obtainablequal o, ";
					}
					$GLOBALS['sqlwhere'] .= "a.cProgrammeId = p.cProgrammeId AND p.cObtQualId = o.cObtQualId AND ";
				}else if (isset($_REQUEST['col11']) && $_REQUEST['col11'] == 'k')
				{
					if ($_REQUEST['crit4'] == '')
					{
						$GLOBALS['sqlselect'] .= "CONCAT(o.vObtQualTitle,' ',p.vProgrammeDesc) AS Programme, ";
					}

					if (strpos($GLOBALS['sqlfrom'], "programme p, ") === false)
					{
						$GLOBALS['sqlfrom'] .= "programme p, ";
					}

					if (strpos($GLOBALS['sqlfrom'], "obtainablequal o, ") === false)
					{
						$GLOBALS['sqlfrom'] .= "obtainablequal o, ";
					}
					$GLOBALS['sqlwhere'] .= "a.cProgrammeId = p.cProgrammeId AND p.cObtQualId = o.cObtQualId AND ";
				}else 
				{
					if (!isset($_REQUEST['crit4']) || (isset($_REQUEST['crit4']) && $_REQUEST['crit4'] == ''))
					{
						$GLOBALS['sqlselect'] .= "p.vProgrammeDesc AS Programme, ";
					}
					if (strpos($GLOBALS['sqlfrom'], "programme p, ") === false)
					{
						$GLOBALS['sqlfrom'] .= "programme p, ";
					}

					//$GLOBALS['sqlfrom'] .= "programme p, ";
					$GLOBALS['sqlwhere'] .= "a.cProgrammeId = p.cProgrammeId AND ";
				}
				
				//$GLOBALS['sqlwhere'] .= "p.cdeptId = dpt.cdeptId AND ";

				if ($_REQUEST['hdqry_type'] == '1')
				{
					$GLOBALS['sqlgrp'] .= "a.cProgrammeId, ";
				}
			break;
			
			case "e": //courses
				if (!isset($_REQUEST['crit5']) || (isset($_REQUEST['crit5']) && $_REQUEST['crit5'] == ''))
				{
					$GLOBALS['sqlselect'] .= "CONCAT(crs1.cCourseId,' ',crs2.vCourseDesc) AS vCourseDesc, ";
					$GLOBALS['sqlfrom'] .= "coursereg_arch crs1, courses crs2, ";
					$GLOBALS['sqlwhere'] .= "crs1.cCourseId = crs2.cCourseId AND crs1.vMatricNo = a.vMatricNo AND ";
				}else
				{
					$GLOBALS['sqlfrom'] .= "coursereg crs1, ";
					$GLOBALS['sqlwhere'] .= "crs1.vMatricNo = a.vMatricNo AND ";
				}
				
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$GLOBALS['sqlgrp'] .= "crs1.cCourseId, ";
				}
			break;	
			
			case "f": //entry qualification
				if (!isset($_REQUEST['crit6']) || (isset($_REQUEST['crit6']) && $_REQUEST['crit6'] == ''))
				{
					$GLOBALS['sqlselect'] .= "q.vQualCodeDesc 'Qualification', ";
				}
				$GLOBALS['sqlfrom'] .= "qualification q, applyqual eq, ";
				$GLOBALS['sqlwhere'] .= "q.cQualCodeId = eq.cQualCodeId AND eq.vApplicationNo = a.vApplicationNo AND ";
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$GLOBALS['sqlgrp'] .= "eq.cQualCodeId, ";
				}
			break;
			
			case "g": //level
				if (!isset($_REQUEST['crit7']) || (isset($_REQUEST['crit7']) && $_REQUEST['crit7'] == ''))
				{
					$GLOBALS['sqlselect'] .= "a.iBeginLevel iBeginLevel, ";
				}
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$GLOBALS['sqlgrp'] .= "a.iBeginLevel, ";
				}
			break;			
			
			case "h": //gender
				if (!isset($_REQUEST['crit8']) || (isset($_REQUEST['crit8']) && $_REQUEST['crit8'] == ''))
				{
					$GLOBALS['sqlselect'] .= "r.cgender cgender, ";
				}
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$GLOBALS['sqlgrp'] .= "r.cgender, ";
				}
			break;		
			
			case "l": //Geo Political zone of Study Centre
				if ($_REQUEST['col19'] == 's')
				{
					if ($_REQUEST['hdqry_type'] == '1')
					{
						$GLOBALS['sqlselect'] .= "ng2.cGeoZoneId GeoZoneId, ng2.vStateName 'State of centre',
						CONCAT(s2.cStudyCenterId,' ',s2.vCityName) AS 'Study Centre', ";
					}else
					{
						$GLOBALS['sqlselect'] .= "distinct ng2.cGeoZoneId GeoZoneId, ng2.vStateName 'State of centre',
						CONCAT(s2.cStudyCenterId,' ',s2.vCityName) AS 'Study Centre', ";
					}
					//$GLOBALS['bind_rslt_vars'] .= '$GeoZoneId_001, $Stateofcentre_001, ';
				}else
				{
					if ($_REQUEST['hdqry_type'] == '1')
					{
						$GLOBALS['sqlselect'] .= "ng2.cGeoZoneId GeoZoneId,
					CONCAT(s2.cStudyCenterId,' ',s2.vCityName) AS 'Study Centre', ";
					}else
					{
						$GLOBALS['sqlselect'] .= "distinct ng2.cGeoZoneId GeoZoneId,
						CONCAT(s2.cStudyCenterId,' ',s2.vCityName) AS 'Study Centre', ";
					}
				}
				
				$GLOBALS['sqlfrom'] .= "ng_state ng2, studycenter s2, ";
				$GLOBALS['sqlwhere'] .= "ng2.cStateId = s2.cStateId AND s2.cStudyCenterId = a.cStudyCenterId AND ";

				if ($_REQUEST['hdqry_type'] == '1')
				{
					//$GLOBALS['sqlgrp'] .= "gz1.cGeoZoneId, ";
					$GLOBALS['sqlgrp'] .= "ng2.cGeoZoneId, ";
					if ($_REQUEST['show_state'] == 1)
					{
						$GLOBALS['sqlgrp'] .= "ng2.vStateName, ";
					}
					$GLOBALS['sqlgrp'] .= "a.cStudyCenterId, ";
				}
			break;

			case "m": //State of origin
				$GLOBALS['sqlselect'] .= "ng3.vStateName 'State of org', ";
				$GLOBALS['sqlfrom'] .= "ng_state ng3, ";

				if ($_REQUEST['std_cat'] == 'c')
				{
					$GLOBALS['sqlwhere'] .= "ng3.cStateId = a.cHomeStateId AND ";
				}else
				{
					$GLOBALS['sqlwhere'] .= "ng3.cStateId = r.cHomeStateId AND ";
				}
				
				if ($_REQUEST['hdqry_type'] == '1')
				{
					if ($_REQUEST['std_cat'] == 'c')
					{
						$GLOBALS['sqlgrp'] .= "a.cHomeStateId, ";
					}else
					{
						$GLOBALS['sqlgrp'] .= "r.cHomeStateId, ";
					}
				}
			break;

			case "n": //lga of origin
				$GLOBALS['sqlselect'] .= "la1.vLGADesc 'LGA of org', ";
				$GLOBALS['sqlfrom'] .= "localarea la1, ";

				if ($_REQUEST['std_cat'] == 'c')
				{
					$GLOBALS['sqlwhere'] .= "la1.cLGAId = a.cHomeLGAId AND ";
				}else
				{
					$GLOBALS['sqlwhere'] .= "la1.cLGAId = r.cHomeLGAId AND ";
				}
				
				if ($_REQUEST['hdqry_type'] == '1')
				{
					if ($_REQUEST['std_cat'] == 'c')
					{
						$GLOBALS['sqlgrp'] .= "a.cHomeLGAId, ";
					}else
					{
						$GLOBALS['sqlgrp'] .= "r.cHomeLGAId, ";
					}
				}
			break;

			case "o": //Geo Political zone of origin
				if (isset($_REQUEST['col19']) && $_REQUEST['col19'] == 's')//show state
				{
					$GLOBALS['sqlselect'] .= "ng4.cGeoZoneId GeoZoneId, ng4.vStateName StateName, ";
				}else
				{
					$GLOBALS['sqlselect'] .= "ng4.cGeoZoneId GeoZoneId, ";
				}
				$GLOBALS['sqlfrom'] .= "ng_state ng4, ";

				if ($_REQUEST['std_cat'] == 'c')
				{
					$GLOBALS['sqlwhere'] .= "ng4.cStateId = a.cHomeStateId AND ";
				}else
				{
					$GLOBALS['sqlwhere'] .= "ng4.cStateId = r.cHomeStateId AND ";
				}
				

				if ($_REQUEST['hdqry_type'] == '1')
				{
					$GLOBALS['sqlgrp'] .= "ng4.cGeoZoneId, ";
					if ($_REQUEST['show_state'] == 1)
					{
						if ($_REQUEST['std_cat'] == 'c')
						{
							$GLOBALS['sqlgrp'] .= "a.cHomeStateId, ";
						}else
						{
							$GLOBALS['sqlgrp'] .= "r.cHomeStateId, ";
						}
					}
				}
			break;

			case "p": //State of residence
				$GLOBALS['sqlselect'] .= "ng5.vStateName AS 'State of res', ";
				$GLOBALS['sqlfrom'] .= "ng_state ng5, res_addr s, ";
				$GLOBALS['sqlwhere'] .= "ng5.cStateId = s.cResidenceStateId AND ";
				if ($_REQUEST['hdqry_type'] == '1')
				{
					// if ($_REQUEST['std_cat'] == 'c')
					// {
					// 	$GLOBALS['sqlgrp'] .= "a.cResidenceStateId, ";
					// }else
					// {
						$GLOBALS['sqlgrp'] .= "s.cResidenceStateId, ";
					//}
				}
			break;

			case "q": //lga of residence
				$GLOBALS['sqlselect'] .= "la2.vLGADesc 'LGA of res', ";
				$GLOBALS['sqlfrom'] .= "localarea la2, ";

				if (strpos($GLOBALS['sqlfrom'], "res_addr s, ") === false)
				{
					$GLOBALS['sqlfrom'] .= "res_addr s, ";
				}
					
				$GLOBALS['sqlwhere'] .= "la2.cLGAId = s.cResidenceLGAId AND ";
				if ($_REQUEST['hdqry_type'] == '1')
				{
					// if ($_REQUEST['std_cat'] == 'c')
					// {
					// 	$GLOBALS['sqlgrp'] .= "a.cResidenceLGAId, ";
					// }else
					// {
						$GLOBALS['sqlgrp'] .= "s.cResidenceLGAId, ";
					//}
				}
			break;

			case "r": //Geo Political zone of residence
				if (isset($_REQUEST['col19']) && $_REQUEST['col19'] == 's')//show state
				{
					$GLOBALS['sqlselect'] .= "ng6.cGeoZoneId GeoZoneId, ng6.vStateName StateName, ";
					$GLOBALS['bind_rslt_vars'] .= '$GeoZoneId_001, $StateName_001';
				}else
				{
					$GLOBALS['sqlselect'] .= "ng6.cGeoZoneId GeoZoneId, ";
					$GLOBALS['bind_rslt_vars'] .= '$cGeoZoneId_001, ';
				}
				$GLOBALS['sqlfrom'] .= "ng_state ng6, ";
				
				if (strpos($GLOBALS['sqlfrom'], "res_addr s, ") === false)
				{
					$GLOBALS['sqlfrom'] .= "res_addr s, ";
				}
				
				// if ($_REQUEST['std_cat'] == 'c')
				// {
				// 	$GLOBALS['sqlwhere'] .= "ng6.cStateId = a.cResidenceStateId AND ";
				// }else
				// {
					$GLOBALS['sqlwhere'] .= "ng6.cStateId = s.cResidenceStateId AND ";
				//}				

				if ($_REQUEST['hdqry_type'] == '1')
				{
					$GLOBALS['sqlgrp'] .= "ng6.cGeoZoneId, ";
					if ($_REQUEST['show_state'] == 1)
					{
						// if ($_REQUEST['std_cat'] == 'c')
						// {
						// 	$GLOBALS['sqlgrp'] .= "a.cResidenceStateId, ";
						// }else
						// {
							$GLOBALS['sqlgrp'] .= "s.cResidenceStateId, ";
						//}
					}
				}
			break;

			case "t": //AFN
				$GLOBALS['sqlselect'] .= "a.vApplicationNo AS ApplicationNo, ";
				$GLOBALS['bind_rslt_vars'] .= '$ApplicationNo_001, ';
			break;

			case "u": //Matricno
			
				if ($_REQUEST['std_cat'] == 'c')
				{
					$GLOBALS['sqlselect'] .= "a.vMatricNo AS Matricno, ";
				}else if ($_REQUEST['std_cat'] == 'b')
				{
					$GLOBALS['sqlselect'] .= "t.vMatricNo AS Matricno, ";
				}/*else
				{
					$GLOBALS['sqlselect'] .= "a.vApplicationNo AS Matricno, ";
					$GLOBALS['bind_rslt_vars'] .= '$Matricno_001, ';
				}*/

				if (((isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] <> '') || (isset($_REQUEST['vMatricNo']) && $_REQUEST['vMatricNo'] <> '') || (isset($_REQUEST['vLastName']) && $_REQUEST['vLastName'] <> '')) && $_REQUEST['std_cat'] == 'b')
				{
					if (strpos($GLOBALS['sqlselect'], "CONCAT(o.vObtQualTitle,' ',p.vProgrammeDesc) AS Programme, ") === false)
					{
						if (!isset($_REQUEST['crit4']) || (isset($_REQUEST['crit4']) && $_REQUEST['crit4'] == ''))
						{
							//$GLOBALS['sqlselect'] .= "CONCAT(o.vObtQualTitle,' ',p.vProgrammeDesc) AS Programme, ";
							//$GLOBALS['bind_rslt_vars'] .= '$Programme_001, ';
						}
					}

					if (strpos($GLOBALS['sqlfrom'], "programme p, ") === false)
					{
						$GLOBALS['sqlfrom'] .= "programme p, ";
					}					

					if (strpos($GLOBALS['sqlfrom'], "obtainablequal o, ") === false)
					{
						$GLOBALS['sqlfrom'] .= "obtainablequal o, ";
					}

					if (strpos($GLOBALS['sqlwhere'], "a.cProgrammeId = p.cProgrammeId AND p.cObtQualId = o.cObtQualId AND ") === false)
					{
						$GLOBALS['sqlwhere'] .= "a.cProgrammeId = p.cProgrammeId AND p.cObtQualId = o.cObtQualId AND ";
					}					

					if (!is_bool(strpos($selection, "c")))
					{
						$GLOBALS['sqlwhere'] .= "dpt.cdeptId = p.cdeptId AND ";
					}
					
					// if (strpos($GLOBALS['sqlselect'], "CONCAT(o.vObtQualTitle,' ',p.vProgrammeDesc) AS Programme, ") === false &&
					// strpos($GLOBALS['sqlfrom'], "programme p, obtainablequal o, ") === false)
					// {
					// 	if ($_REQUEST['crit4'] == '')
					// 	{
					// 		$GLOBALS['sqlselect'] .= "CONCAT(o.vObtQualTitle,' ',p.vProgrammeDesc) AS Programme, ";
					// 	}
					
					// 	$GLOBALS['sqlfrom'] .= "programme p, obtainablequal o, ";
					// 	$GLOBALS['sqlwhere'] .= "a.cProgrammeId = p.cProgrammeId AND p.cObtQualId = o.cObtQualId AND ";
					// }
					// if (strpos($sqlselect, "a.vProcessNote AS vProcessNote, ") === false)
					// {
					// 	$GLOBALS['sqlselect'] .= "a.vProcessNote AS vProcessNote, ";
					// }
				}
			break;

			case "v": //Name
				if ($_REQUEST['std_cat'] == 'a' || $_REQUEST['std_cat'] == 'b')
				{
					$GLOBALS['sqlselect'] .= "CONCAT(r.vLastName,' ',r.vFirstName,' ',r.vOtherName) AS 'Name of Student', ";

					if (strpos($GLOBALS['sqlfrom'], "pers_info r, ") === false)
					{
						$GLOBALS['sqlfrom'] .= "pers_info r, ";
						$GLOBALS['sqlwhere'] .= "a.vApplicationNo = r.vApplicationNo AND ";
					}
				}else
				{					
					$GLOBALS['sqlselect'] .= "CONCAT(a.vLastName,', ',a.vFirstName,' ',a.vOtherName) AS 'Name of Student', ";
				}
			break;

			case "w": //email
				$GLOBALS['sqlselect'] .= "a.vEMailId EMailId, ";
			break;

			case "x": //GSM
				$GLOBALS['sqlselect'] .= "a.vMobileNo MobileNo, ";
			break;

			case "y": //email of NOK
				$GLOBALS['sqlselect'] .= "a.vNOKEMailId NOKEMailId, ";
			break;

			case "z": //GSM of NOK
				$GLOBALS['sqlselect'] .= "a.vNOKMobileNo NOKMobileNo, ";
			break;

			//case "A": //Type of Programme 
			//	$GLOBALS['sqlselect'] .= "CONCAT(a.prog_class,' ',a.prog_class_depend) prog_class, ";
			//break;
		}
	}
	
	
	/*if ($_REQUEST['crit5'] == '' && is_bool(strpos($selection,'e')))
	{
		$GLOBALS['sqlfrom'] .= "courses crs2, coursereg crs1, ";
		$GLOBALS['sqlwhere'] .= "crs1.cCourseId = crs2.cCourseId AND crs1.vMatricNo = a.vMatricNo AND ";
	}*/
}


function complete_order_clause()
{
	for ($t = 0; $t <= strlen($_REQUEST['selectionst'])-1; $t++)
	{
		switch (substr($_REQUEST['selectionst'],$t,1))
		{
			case "a": //centre
				if (!isset($_REQUEST['crit1']) || (isset($_REQUEST['crit1']) && $_REQUEST['crit1'] == ''))
				{
					$GLOBALS['sqlorder'] .= "a.cStudyCenterId, ";
				}
			break;

			case "b": //school
				if (!isset($_REQUEST['crit2']) || (isset($_REQUEST['crit2']) && $_REQUEST['crit2'] == ''))
				{
					$GLOBALS['sqlorder'] .= "a.cFacultyId, ";
				}
			break;

			case "c": //dept
				if (!isset($_REQUEST['crit3']) || (isset($_REQUEST['crit3']) && $_REQUEST['crit3'] == ''))
				{
					if (!is_bool(strpos($_REQUEST['selection'], 'd')))
					{
						$GLOBALS['sqlorder'] .= "p.cdeptId, ";
					}else
					{
						$GLOBALS['sqlorder'] .= "dpt.cdeptId, ";
					}
				}
			break;

			case "d": //programme
				if (!isset($_REQUEST['crit4']) || (isset($_REQUEST['crit4']) && $_REQUEST['crit4'] == ''))
				{
					$GLOBALS['sqlorder'] .= "a.cProgrammeId, ";
				}
			break;			
			
			case "e": //entry course
				if (!isset($_REQUEST['crit5']) || (isset($_REQUEST['crit5']) && $_REQUEST['crit5'] == ''))
				{
					$GLOBALS['sqlorder'] .= "crs1.cCourseId, ";
				}
			break;
			
			case "f": //entry qualification
				if (!isset($_REQUEST['crit6']) || (isset($_REQUEST['crit6']) && $_REQUEST['crit6'] == ''))
				{
					$GLOBALS['sqlorder'] .= "eq.cQualCodeId, ";
				}
			break;

			case "g": //level
				if (!isset($_REQUEST['crit7']) || (isset($_REQUEST['crit7']) && $_REQUEST['crit7'] == ''))
				{
					$GLOBALS['sqlorder'] .= "a.iBeginLevel, ";
				}
			break;
			
			case "h": //gender
				if (!isset($_REQUEST['crit8']) || (isset($_REQUEST['crit8']) && $_REQUEST['crit8'] == ''))
				{
					$GLOBALS['sqlorder'] .= "a.cgender, ";
				}
			break;

			case "l": //Geo Political zone of Study Centre
				if ($_REQUEST['col18'] == 1)
				{
					if ($_REQUEST['hdqry_type'] == '1')
					{
						$GLOBALS['sqlorder'] .= "ng2.cGeoZoneId, count(*), ";
					}else
					{
						$GLOBALS['sqlorder'] .= "ng2.cGeoZoneId, ng2.vStateName, 'Study Centre', ";
					}
				}else
				{
					if ($_REQUEST['hdqry_type'] == '1')
					{
						$GLOBALS['sqlorder'] .= "ng2.cGeoZoneId, count(*), ";
					}else
					{
						$GLOBALS['sqlorder'] .= "ng2.cGeoZoneId, 'Study Centre', ";
					}
				}
			break;

			case "m": //State of origin
				$GLOBALS['sqlorder'] .= "ng3.vStateName, ";
			break;			

			case "n": //lga of origin
				$GLOBALS['sqlorder'] .= "a.cHomeLGAId, ";
			break;

			case "o": //Geo Political zone of origin
				if ($_REQUEST['col19'] == 's')
				{
					if ($_REQUEST['hdqry_type'] == '1')
					{
						$GLOBALS['sqlorder'] .= "ng4.cGeoZoneId, count(*), ";
					}else
					{
						$GLOBALS['sqlorder'] .= "ng4.cGeoZoneId, ng4.vStateName, ";
					}
				}else
				{
					if ($_REQUEST['hdqry_type'] == '1')
					{
						$GLOBALS['sqlorder'] .= "ng4.cGeoZoneId, count(*), ";
					}else
					{
						$GLOBALS['sqlorder'] .= "ng4.cGeoZoneId, ";
					}
				}
			break;

			case "p": //State of residence
				$GLOBALS['sqlorder'] .= "ng5.vStateName, ";
			break;			

			case "q": //lga of residence
				$GLOBALS['sqlorder'] .= "a.cResidenceLGAId, ";
			break;

			case "r": //Geo Political zone of residence
				if ($_REQUEST['col19'] == 's')
				{
					if ($_REQUEST['hdqry_type'] == '1')
					{
						$GLOBALS['sqlorder'] .= "ng6.cGeoZoneId, count(*), ";
					}else
					{
						$GLOBALS['sqlorder'] .= "ng6.cGeoZoneId, ng6.vStateName, ";
					}
				}else
				{
					if ($_REQUEST['hdqry_type'] == '1')
					{
						$GLOBALS['sqlorder'] .= "ng6.cGeoZoneId, count(*), ";
					}else
					{
						$GLOBALS['sqlorder'] .= "ng6.cGeoZoneId, ";
					}
				}
			break;
			
			case "s": //AFN
				$GLOBALS['sqlorder'] .= "a.vApplicationNo, ";
			break;

			case "t": //Matricno
				$GLOBALS['sqlorder'] .= "a.vMatricNo, ";
			break;

			case "u": //Name
				$GLOBALS['sqlorder'] .= "a.vLastName, a.vFirstName ,a.vOtherName, ";
			break;

			case "v": //email
				$GLOBALS['sqlorder'] .= "a.vEMailId, ";
			break;

			case "w": //GSM
				$GLOBALS['sqlorder'] .= "a.vMobileNo, ";
			break;

			case "x": //email of NOK
				$GLOBALS['sqlorder'] .= "a.vNOKEMailId, ";
			break;

			case "y": //GSM of NOK
				$GLOBALS['sqlorder'] .= "a.vNOKMobileNo, ";
			break;

			case "z": //Type of Programme
				$GLOBALS['sqlorder'] .= "a.prog_class, ";
			break;
			
			case "-": //count
				$GLOBALS['sqlorder'] .= "count(*), ";
			break;
		}
	}
}


function complete_where_clause_new()
{
	$array_count = 0;
	

	if ($_REQUEST['schl_session'] <> 'All')
	{
		if (($_REQUEST['std_cat'] == 'a' || $_REQUEST['std_cat'] == 'b') && is_bool(strpos($GLOBALS['sqlwhere'], "a.cAcademicDesc =")))
		{
			$GLOBALS['sqlwhere'] .= "a.cAcademicDesc = ? AND ";
			$array_count++;
			$GLOBALS['bind_vars'][$array_count] = $_REQUEST['schl_session'];
			$GLOBALS['binders'] .= 's';
		}else if ($_REQUEST['std_cat'] == 'c' && is_bool(strpos($GLOBALS['sqlwhere'], "a.cAcademicDesc =")))
		{
			$GLOBALS['sqlwhere'] .= "a.cAcademicDesc_1 = ? AND ";
			$array_count++;
			$GLOBALS['bind_vars'][$array_count] = $_REQUEST['schl_session'];
			$GLOBALS['binders'] .= 's';
		}
	}

	
	if (isset($_REQUEST['crit1']) && $_REQUEST['crit1'] <> '')
	{
		$GLOBALS['sqlwhere'] .= "a.cStudyCenterId = ? AND ";
		$array_count++;
		$GLOBALS['bind_vars'][$array_count] = $_REQUEST['crit1'];
		$GLOBALS['binders'] .= 's';
	}

	if (isset($_REQUEST['crit2']) && $_REQUEST['crit2'] <> '' && !isset($_REQUEST['chk_crit2']))
	{
		$GLOBALS['sqlwhere'] .= "a.cFacultyId = ? AND ";
		$array_count++;
		$GLOBALS['bind_vars'][$array_count] = $_REQUEST['crit2'];
		$GLOBALS['binders'] .= 's';
	}

	if ((isset($_REQUEST['crit3']) && $_REQUEST['crit3'] <> '') && !isset($_REQUEST['chk_crit3']))
	{
		if (!is_bool(strpos($_REQUEST['selection'], 'd')))
		{
			$GLOBALS['sqlwhere'] .= "p.cdeptId = ? AND ";
		}else //if ($_REQUEST['crit5'] == '')
		{
			$GLOBALS['sqlwhere'] .= "dpt.cdeptId = ? AND ";
		}
		$array_count++;
		$GLOBALS['bind_vars'][$array_count] = $_REQUEST['crit3'];
		$GLOBALS['binders'] .= 's';
	}

	if (isset($_REQUEST['crit4']) && $_REQUEST['crit4'] <> '')
	{
		$GLOBALS['sqlwhere'] .= "p.cProgrammeId = ? AND ";
		$array_count++;
		$GLOBALS['bind_vars'][$array_count] = $_REQUEST['crit4'];
		$GLOBALS['binders'] .= 's';
	}

	if (isset($_REQUEST['crit5']) && $_REQUEST['crit5'] <> '' && !is_bool(strpos($_REQUEST['selection'],'e')))
	{
		$GLOBALS['sqlwhere'] .= "crs1.cCourseId = ? AND ";
		$array_count++;
		$GLOBALS['bind_vars'][$array_count] = $_REQUEST['crit5'];
		$GLOBALS['binders'] .= 's';
	}

	if (isset($_REQUEST['crit7']) && $_REQUEST['crit7'] <> '')
	{
		$GLOBALS['sqlwhere'] .= "a.iBeginLevel = ? AND ";
		$array_count++;
		$GLOBALS['bind_vars'][$array_count] = $_REQUEST['crit7'];
		$GLOBALS['binders'] .= 'i';
	}

	if (isset($_REQUEST['crit8']) && $_REQUEST['crit8'] <> '')
	{
		if ($_REQUEST['std_cat'] == 'c')
		{
			$GLOBALS['sqlwhere'] .= "a.cgender = ? AND ";
		}else
		{
			$GLOBALS['sqlwhere'] .= "r.cgender = ? AND ";
		}
	
		$array_count++;
		$GLOBALS['bind_vars'][$array_count] = $_REQUEST['crit8'];
		$GLOBALS['binders'] .= 's';
	}

	if (isset($_REQUEST['crit9']) && $_REQUEST['crit9'] <> '')
	{
		$GLOBALS['sqlwhere'] .= "a.cHomeStateId = ? AND ";
		$array_count++;
		$GLOBALS['bind_vars'][$array_count] = $_REQUEST['crit9'];
		$GLOBALS['binders'] .= 's';
	}

	if (isset($_REQUEST['crit10']) && $_REQUEST['crit10'] <> '')
	{
		$GLOBALS['sqlwhere'] .= "a.cHomeLGAId = ? AND ";
		$array_count++;
		$GLOBALS['bind_vars'][$array_count] = $_REQUEST['crit10'];
		$GLOBALS['binders'] .= 's';
	}

	if (isset($_REQUEST['crit11']) && $_REQUEST['crit11'] <> '')
	{
		$GLOBALS['sqlwhere'] .= "a.cResidenceStateId = ? AND ";
		$array_count++;
		$GLOBALS['bind_vars'][$array_count] = $_REQUEST['crit11'];
		$GLOBALS['binders'] .= 's';
	}

	if (isset($_REQUEST['crit12']) && $_REQUEST['crit12'] <> '')
	{
		$GLOBALS['sqlwhere'] .= "a.cResidenceLGAId = ? AND ";
		$array_count++;
		$GLOBALS['bind_vars'][$array_count] = $_REQUEST['crit12'];
		$GLOBALS['binders'] .= 's';
	}
	
	if (isset($_REQUEST['crit13']) && $_REQUEST['crit13'] <> '')
	{
		$GLOBALS['sqlwhere'] .= "ng2.cGeoZoneId = ? AND ";
		$array_count++;
		$GLOBALS['bind_vars'][$array_count] = $_REQUEST['crit13'];
		$GLOBALS['binders'] .= 's';
	}

	if (isset($_REQUEST['hdqry_type']) && $_REQUEST['hdqry_type'] == '3')
	{
		$GLOBALS['sqlwhere'] .= "a.cSbmtd = '2' AND ";
	}else if (isset($_REQUEST['crit14']) && $_REQUEST['crit14'] <> '')
	{		
		 if ($_REQUEST['crit14'] == '0') //SCREENED Qualified
		{
			$GLOBALS['sqlwhere'] .= "(a.cqualfd = '1' OR a.cSbmtd = '2') AND ";
		}else if ($_REQUEST['crit14'] == '1') //SCREENED NOT Qualified
		{
			$GLOBALS['sqlwhere'] .= "a.cqualfd = '0' AND ";
		}else if ($_REQUEST['crit14'] == '2')//Submitted FORM NOT SCREENED
		{
			$GLOBALS['sqlwhere'] .= "(a.cSbmtd = '1' AND a.cqualfd = 'n') AND ";
		}else if ($_REQUEST['crit14'] == '3')//Printed letter
		{
			$GLOBALS['sqlwhere'] .= "a.iprnltr > 0 AND ";
		}else if ($_REQUEST['crit14'] == '4')//printed letter yet to screen
		{
			$GLOBALS['sqlwhere'] .= "(a.iprnltr > 0  AND a.cqualfd = 'n') AND ";
		}
	}

	if (isset($_REQUEST['crit15']) && $_REQUEST['crit15'] <> '')
	{
		$GLOBALS['sqlwhere'] .= "a.vApplicationNo = ? AND ";
		$array_count++;
		$GLOBALS['bind_vars'][$array_count] = $_REQUEST['crit15'];
		$GLOBALS['binders'] .= 's';
	}

	if (isset($_REQUEST['crit16']) && $_REQUEST['crit16'] <> '')
	{
		$GLOBALS['sqlwhere'] .= "a.vMatricNo = ? AND ";
		$array_count++;
		$GLOBALS['bind_vars'][$array_count] = $_REQUEST['crit16'];
		$GLOBALS['binders'] .= 's';
	}

	if (isset($_REQUEST['crit17']) && $_REQUEST['crit17'] <> '')
	{
		$GLOBALS['sqlwhere'] .= "a.vLastName = ? AND ";
		$array_count++;
		$GLOBALS['bind_vars'][$array_count] = $_REQUEST['crit17'];
		$GLOBALS['binders'] .= 's';
	}	

	if (isset($_REQUEST['crit18']) && $_REQUEST['crit18'] <> '')
	{
		$GLOBALS['sqlwhere'] .= "a.in_mate = ? AND ";
		$array_count++;
		$GLOBALS['bind_vars'][$array_count] = $_REQUEST['crit18'];
		$GLOBALS['binders'] .= 's';
	}
}


function date_cond($where)
{
	$local = '';
	if (isset($_REQUEST['rpt_date']) && $_REQUEST['rpt_date'] == ''){return '';}
    
	if(isset($_REQUEST['start_date']) && $_REQUEST['start_date'] <> '')
	{
		$local = " a.dCreateDate >= '". formatdate($_REQUEST['start_date'], 'todb') . "'";
	}

	if(isset($_REQUEST['end_date']) && $_REQUEST['end_date'] <> '' && isset($_REQUEST['start_date']) && $_REQUEST['start_date'] <> '')
	{
		$local .= " AND a.dCreateDate <= '". formatdate($_REQUEST['end_date'], 'todb') . "'";
	}else if(isset($_REQUEST['end_date']) && $_REQUEST['end_date'] <> '' && isset($_REQUEST['start_date']) && $_REQUEST['start_date'] == '')
	{
		$local .= " a.dCreateDate <= '". formatdate($_REQUEST['end_date'], 'todb') . "'";
	}
	if ($local <> '')
	{
		if(strlen($where) <> ' where '){return " AND (".$local.")";}else{return $local;}
	}else{return '';}
}


function title_rpt()
{
	$custom_title = 0;
	$title = '<b>NATIONAL OPEN UNIVERSITY OF NIGERIA</b><br>';

	for ($d = 1; $d <= 6; $d++)
	{
		if (isset($_REQUEST["rpt_title$d"]) && trim($_REQUEST["rpt_title$d"]) <> '')
		{
			$title .= $_REQUEST["rpt_title$d"] . '<br>';
			$custom_title = 1;
		}
	}

	$title .= put_crit_in_title1();
	$title .= put_crit_in_title2();

	if ($custom_title == 1){return $title;}

	if ($_REQUEST['hdqry_type'] == 1)
	{
		$title .= "<br><b>DISTRIBUTION OF ";
	}else if ($_REQUEST['hdqry_type'] == 2)
	{
		$title .= "<br><b>LIST OF ";
	}else if ($_REQUEST['hdqry_type'] == 3)
	{
		$title .= "<br><b>MATRICULATION LIST</b>";
	}

	if ($_REQUEST['hdqry_type'] <> 3 && $_REQUEST['hdqry_type'] <> 4)
	{
		if ($_REQUEST['std_cat'] == "a")
		{
			if (isset($_REQUEST['crnt_aplnt']) && $_REQUEST['crnt_aplnt'] <> ''){$title .= "(CURRENT) ";}
			if (isset($_REQUEST['old_aplnt']) && $_REQUEST['old_aplnt'] <> ''){$title .= "(OLD) ";}
		}
		
		if (isset($_REQUEST['crit14']) && $_REQUEST['crit14'] <> '')
		{
			if ($_REQUEST['crit14'] == '0') //SCREENED Qualified
			{
				$title = $title . " APPLICANTS SCREENED QUALIFIED</b>";
			}else if ($_REQUEST['crit14'] == '1') //SCREENED NOT Qualified
			{
				$title = $title . " APPLICANTS SCREENED NOT QUALIFIED</b>";
			}else if ($_REQUEST['crit14'] == '2')//Submitted FORM NOT SCREENED
			{
				$title = $title . " APPLICANTS THAT HAVE SUBMITTED FORM BUT YET TO BE SCREENED</b>";
			}else if ($_REQUEST['crit14'] == '3')//Printed letter
			{
				$title = $title . " APPLICANTS HAVE PRINTED LETTER</b>";
			}else if ($_REQUEST['crit14'] == '4')//printed letter yet to screen
			{
				$title = $title . " APPLICANTS THAT HAVE PRINTED LETTER BUT YET TO BE SCREENED</b>";
			}	
		}else if ($_REQUEST['std_cat'] == "a")
		{
			$title .= "APPLICANTS</b>";
		}else if ($_REQUEST['std_cat'] == "c")
		{
			$title .= "REGISTERED STUDENTS</b>";
		}

		if (isset($_REQUEST['crit18']) && $_REQUEST['crit18'] == '1')
		{
			$title = $title . " (IN-MATES)";
		}
	}
	
	return $title;
}


function get_grp_flds($selection)
{
	$len = 0;
	$grp_list = 'GROUPED BY ';

	$selection = $_REQUEST['selection'];

	for ($e = 0; $e <= strlen($selection);  $e++)
	{
		switch (substr($selection,$e,1))
		{
			case 'a':
				if (isset($_REQUEST['crit1']) && $_REQUEST['crit1'] == '')
				{
					if (isset($_REQUEST['col19']) && $_REQUEST['col19'] == 's')
					{
						$grp_list .=  'HOST STATE OF STUDY CENTRE, ' ;
						$len = $len + 2;
					}else
					{
						$grp_list .=  'STUDY CENTRE, ' ;
						$len++;
					}
				}
			break;

			case 'b':
				if (isset($_REQUEST['crit2']) && $_REQUEST['crit2'] == '')
				{
					$grp_list .=  'FACULTY, ' ;
					$len++;
				}
			break;

			case 'c':
				if (isset($_REQUEST['crit3']) && $_REQUEST['crit3'] == '')
				{
					$grp_list .=  'DEPARTMENT, ' ;
					$len++;
				}
			break;

			case 'd':
				if (isset($_REQUEST['crit4']) && $_REQUEST['crit4'] == '')
				{
					$grp_list .=  'PROGRAMME, ' ;
					$len++;
				}
			break;

			case 'e':
				if (isset($_REQUEST['crit5']) && $_REQUEST['crit5'] == '')
				{
					$grp_list .=  'COURSES, ' ;
					$len++;
				}
			break;

			case 'f':
				if (isset($_REQUEST['crit6']) && $_REQUEST['crit6'] == '')
				{
					$grp_list .=  'QUALIFICATION, ' ;
					$len++;
				}
			break;

			case 'g':
				if (isset($_REQUEST['crit7']) && $_REQUEST['crit7'] == '')
				{
					$grp_list .=  'LEVEL, ' ;
					$len++;
				}
			break;

			case 'h':
				if (isset($_REQUEST['crit8']) && $_REQUEST['crit8'] == '')
				{
					$grp_list .=  'GENDER, ' ;
					$len++;
				}
			break;

			case 'l':
				return 'GROUPED BY GEO-POLITICAL ZONE OF STUDY CENTRE' ;
			break;

			case 'm':
				if (isset($_REQUEST['crit9']) && $_REQUEST['crit9'] == '')
				{
					$grp_list .=  'STATE OF ORIGIN, ' ;
					$len++;
				}
			break;			

			case 'n':
				if (isset($_REQUEST['crit10']) && $_REQUEST['crit10'] == '')
				{
					$grp_list .=  'LGA OF ORIGIN, ' ;
					$len++;
				}
			break;

			case 'o':
				return 'GROUPED BY GEO-POLITICAL ZONE OF ORIGIN';
			break;

			case 'p':
				if (isset($_REQUEST['crit11']) && $_REQUEST['crit11'] == '')
				{
					$grp_list .=  'STATE OF RESIDENCE, ';
					$len++;
				}
			break;

			case 'q':
				if (isset($_REQUEST['crit12']) && $_REQUEST['crit12'] == '')
				{
					$grp_list .=  'LGA OF RESIDENCE, ';
					$len++;
				}
			break;

			case 'r':
				return 'GROUPED BY GEO-POLITICAL ZONE OF RESIDENCE';
			break;
		}
	}

	if (isset($_REQUEST['crit1']) && $_REQUEST['crit1'] == '')
	{
		if (isset($_REQUEST['col19']) && $_REQUEST['col19'] == 's')
		{
			$grp_list .=  'HOST STATE OF STUDY CENTRE, ' ;
			$len = $len + 2;
		}/*else
		{
			$grp_list .=  'STUDY CENTRE, ' ;
			$len++;
		}*/
	}

	if ($grp_list == 'GROUPED BY ')
	{
		return '';
	}else
	{
		if ($len == 1)
		{
			return substr($grp_list, 0, strlen($grp_list)-2);
		}else
		{
			$grp_list = substr($grp_list, 0, strlen($grp_list)-2);
			for ($e = strlen($grp_list)-1; $e > 0; $e--)
			{
				if (substr($grp_list,$e,1) == ','){break;}
			}
			return substr($grp_list, 0, $e) . ' AND ' . substr($grp_list,$e+1, strlen($grp_list)-1);
		}
	}
}


function get_srt_flds($selectionst)
{
	if (strlen($selectionst) == 0){return;}
	
	$len = 0;
	$srt_list = 'SORTED BY ';
	if ($selectionst == '' && isset($_REQUEST['hdqry_type']) && $_REQUEST['hdqry_type'] == 1)
	{
		return 'SORTED BY COUNT' ;
	}
	
	for ($e = 0; $e <= strlen($selectionst)-1;  $e++)
	{
		switch ($selectionst[$e])
		{
			case 'a':
				if (!isset($_REQUEST['crit1']) || (isset($_REQUEST['crit1']) && $_REQUEST['crit1'] == ''))
				{
					$srt_list = $srt_list . 'STUDY CENTRE, '; $len++;
				}
			break;

			case 'b':
				if (!isset($_REQUEST['crit2']) || (isset($_REQUEST['crit2']) && $_REQUEST['crit2'] == ''))
				{
					$srt_list = $srt_list . 'FACULTY, '; $len++;
				}
			break;

			case 'c':
				if (!isset($_REQUEST['crit3']) || (isset($_REQUEST['crit3']) && $_REQUEST['crit3'] == ''))
				{
					$srt_list = $srt_list . 'DEPARTMENT, ';$len++;
				}
			break;
			
			case 'd':
				if (!isset($_REQUEST['crit4']) || (isset($_REQUEST['crit4']) && $_REQUEST['crit4'] == ''))
				{
					$srt_list = $srt_list . 'PROGRAMME, ';$len++;
				}
			break;
			
			case 'e':
				if (!isset($_REQUEST['crit5']) || (isset($_REQUEST['crit5']) && $_REQUEST['crit5'] == ''))
				{
					$srt_list = $srt_list . 'COURSE, ';$len++;
				}
			break;

			case 'f':
				if (!isset($_REQUEST['crit6']) || (isset($_REQUEST['crit6']) && $_REQUEST['crit6'] == ''))
				{
					$srt_list = $srt_list . 'QUALIFICATION, ' ;$len++;
				}
			break;

			case 'g':
				if (!isset($_REQUEST['crit7']) || (isset($_REQUEST['crit7']) && $_REQUEST['crit7'] == ''))
				{
					$srt_list = $srt_list . 'LEVEL, ' ;$len++;
				}
			break;

			case 'h':
				if (!isset($_REQUEST['crit8']) || (isset($_REQUEST['crit8']) && $_REQUEST['crit8'] == ''))
				{
					$srt_list = $srt_list . 'GENDER, ' ;$len++;
				}
			break;

			case 'l':
				$srt_list = $srt_list . 'GEO-POLITICAL ZONE OF STUDY CENTRE, ' ;$len++;
			break;

			case 'm':
				if (!isset($_REQUEST['crit9']) || (isset($_REQUEST['crit9']) && $_REQUEST['crit9'] == ''))
				{
					$srt_list = $srt_list . 'STATE OF ORIGIN, ' ;$len++;
				}
			break;

			case 'n':
				if (!isset($_REQUEST['crit10']) || (isset($_REQUEST['crit10']) && $_REQUEST['crit10'] == ''))
				{
					$srt_list = $srt_list . 'LGA OF ORIGIN, ' ;$len++;
				}
			break;

			case 'o':
				$srt_list = $srt_list . 'GEO-POLITICAL ZONE OF ORIGIN, ' ;$len++;
			break;

			case 'p':
				if (!isset($_REQUEST['crit11']) || (isset($_REQUEST['crit11']) && $_REQUEST['crit11'] == ''))
				{
					$srt_list = $srt_list . 'STATE OF RESIDENCE, ' ;$len++;
				}
			break;

			case 'q':
				if (!isset($_REQUEST['crit12']) || (isset($_REQUEST['crit12']) && $_REQUEST['crit12'] == ''))
				{
					$srt_list = $srt_list . 'LGA OF RESIDENCE, ' ;$len++;
				}
			break;

			case 'r':
				$srt_list = $srt_list . 'GEO-POLITICAL ZONE OF RESIDENCE, ' ;$len++;
			break;

			case 's':
				$srt_list = $srt_list . 'APPLICATION FORM NUMBER, ' ;$len++;
			break;

			case 't':
				$srt_list = $srt_list . 'MATRIC. NUMBER, ' ;$len++;
			break;

			case 'u':
				$srt_list = $srt_list . 'NAME, ' ;$len++;
			break;

			case 'v':
				$srt_list = $srt_list . 'eMAIL ADDRESS, ' ;$len++;
			break;

			case 'w':
				$srt_list = $srt_list . 'MOBILE, ' ;$len++;
			break;

			case 'x':
				$srt_list = $srt_list . 'eMAIL ADDRESS OF NOK, ' ;$len++;
			break;

			case 'y':
				$srt_list = $srt_list . 'eMAIL ADDRESS OF NOK, ' ;$len++;
			break;

			case 'z':
				$srt_list = $srt_list . 'PROGRAM CLASS, ' ;$len++;
			break;
		}
	}

	if ($srt_list == 'SORTED BY ')
	{
		return '';
	}else
	{
		if ($len == 1)
		{
			return substr($srt_list, 0, strlen($srt_list)-2);
		}else
		{
			$srt_list = substr($srt_list, 0, strlen($srt_list)-2);
			for ($e = strlen($srt_list)-1; $e > 0; $e--)
			{
				if (substr($srt_list,$e,1) == ','){break;}
			}
			return substr($srt_list, 0, $e) . ' AND ' . substr($srt_list,$e+1, strlen($srt_list)-1);
		}
	}
}


function put_crit_in_title1()
{
	$title = '';
	
	if (isset($_REQUEST['crit1']) && $_REQUEST['crit1'] <> '')
	{
		$title .= "<br>STUDY CENTRE: <b>". strtoupper(substr($_REQUEST['crit1lab'],0,strlen($_REQUEST['crit1lab'])-4)) ."</b>";
	}

	if (isset($_REQUEST['crit2']) && $_REQUEST['crit2'] <> '' && !isset($_REQUEST['chk_crit2']))
	{
		$title .= "<br>FACULTY: <b>" . strtoupper($_REQUEST['crit2lab']) ."</b>";
	}

	if (isset($_REQUEST['crit3']) && $_REQUEST['crit3'] <> '' && !isset($_REQUEST['chk_crit3']))
	{
		if (isset($_REQUEST['crit2']) && $_REQUEST['crit2'] <> '' && is_bool(strpos($title,'FACULTY')))
		{
			$title .= "<br>FACULTY: <b>" . strtoupper(substr($_REQUEST['crit2lab'],4,strlen($_REQUEST['crit2lab'])-1)) ."</b>";
		}
		$title .= "<br>DEPARTMENT: <b>". strtoupper($_REQUEST['crit3lab']) ."</b>";
	}

	if (isset($_REQUEST['crit4']) && $_REQUEST['crit4'] <> '' && !isset($_REQUEST['chk_crit4']))
	{
		if (!is_bool(strpos($_REQUEST['crit4lab'],"(d)")))
		{
			$title .=  "<br>PROGRAMME: <b>". strtoupper(substr($_REQUEST['crit4lab'], 0, strlen($_REQUEST['crit4lab'])-4)) ."</b>";
		}else
		{
			$title .=  "<br>PROGRAMME: <b>". strtoupper($_REQUEST['crit4lab']) ."</b>";
		}
	}

	if (isset($_REQUEST['crit5']) && $_REQUEST['crit5'] <> '')
	{
		$title .= "<br>COURSE: <b>". strtoupper($_REQUEST['crit5lab']) ."</b>";
	}
	return $title;
}


function put_crit_in_title2()
{
	$title = '';

	if (isset($_REQUEST['crit6']) && $_REQUEST['crit6'] <> '')
	{
		$title = $title . "<br>QUALIFICATION: <b>". $_REQUEST['crit6lab'] ."</b>";
	}

	if (isset($_REQUEST['crit7']) && $_REQUEST['crit7'] <> '')
	{
		$title = $title . "<br>LEVEL: <b>". $_REQUEST['crit7lab'] ."</b>";
	}

	if (isset($_REQUEST['crit8']) && $_REQUEST['crit8'] <> '')
	{
		$title = $title . "<br>GENDER: <b>". strtoupper($_REQUEST['crit8lab'] )."</b>";
	}

	if (isset($_REQUEST['crit9']) && $_REQUEST['crit9'] <> '')
	{
		$title = $title . "<br>STATE: OF ORIGIN <b>". strtoupper($_REQUEST['crit9lab']) ."</b>";
	}

	if (isset($_REQUEST['crit10']) && $_REQUEST['crit10'] <> '')
	{
		$title = $title . "<br>LGA OF ORIGIN: <b>". strtoupper($_REQUEST['crit10lab']) ."</b>";
	}

	if (isset($_REQUEST['crit11']) && $_REQUEST['crit11'] <> '')
	{
		$title = $title . "<br>STATE OF RESIDENCE: <b>". strtoupper($_REQUEST['crit11lab']) ."</b>";
	}

	if (isset($_REQUEST['crit12']) && $_REQUEST['crit12'] <> '')
	{
		$title = $title . "<br>LGA OF RESIDENCE: <b>". strtoupper($_REQUEST['crit12lab']) ."</b>";
	}

	if (isset($_REQUEST['crit13']) && $_REQUEST['crit13'] <> '')
	{
		$title = $title . "<br>GEO-POLITICAL ZONE: <b>". strtoupper($_REQUEST['crit13lab']) ."</b>";
	}
	return $title;
}


function box_status($hay_sack, $needle,$ctlr_type)
{
	$pos = strrpos($hay_sack, $needle);
	if (!is_bool($pos))
	{
		if ($ctlr_type == 'chk')
		{
			return ' checked';
		}elseif ($ctlr_type == 'menu' || $ctlr_type == 'chkst')
		{
			return '';
		}else if ($ctlr_type == '')
		{
			return true;
		}
	}else if (!$pos)
	{
		if ($ctlr_type == 'menu' || $ctlr_type == 'chkst')
		{
			return ' disabled';
		}else
		{
			return false;
		}
	}
}


function col_crit_diff()
{
	$sel_occur_cnt = 1;

	for ($e = 'a'; $e <= 'z'; $e++)
	{
		if (box_status($_REQUEST['selection'], $e, ''))
		{
			if ($e == 'e' || $e == 'g' || $e == 'i')
			{
				if ($e == 'e'){$sel_occur_cnt = 2;}else{$sel_occur_cnt = 1;}
			}else if ($sel_occur_cnt <= strlen($_REQUEST['selection']))
			{
				$sel_occur_cnt++;
			}
		}
	}
	
	for ($e = 'A'; $e <= 'Z'; $e++)
	{
		if (box_status($_REQUEST['selection'], $e, ''))
		{
			$sel_occur_cnt++;
		}
	}
	
	
	if ($_REQUEST['hdqry_type'] == 3)
	{
		$sel_occur_cnt++;
	}

	if ($_REQUEST['hdqry_type'] == 1)
	{
		$sel_occur_cnt+=2;
	}
	
	if (isset($_REQUEST['col18']) && $_REQUEST['col18'] == 1)
	{
		$sel_occur_cnt++;
	}
	
	if (($_REQUEST['crit15'] <> '' || $_REQUEST['crit16'] <> '' || $_REQUEST['crit17'] <> '') && $_REQUEST['std_cat'] == 'b')
	{
		$sel_occur_cnt++;
	}
	
	
	if (isset($_REQUEST['crit1']) && $_REQUEST['crit1'] <> ''){$sel_occur_cnt--;}
	if (isset($_REQUEST['crit2']) && $_REQUEST['crit2'] <> ''){$sel_occur_cnt--;}
	if (isset($_REQUEST['crit3']) && $_REQUEST['crit3'] <> ''){$sel_occur_cnt--;}
	if (isset($_REQUEST['crit4']) && $_REQUEST['crit4'] <> ''){$sel_occur_cnt--;}
	if (isset($_REQUEST['crit5']) && $_REQUEST['crit5'] <> ''){$sel_occur_cnt--;}

	if (isset($_REQUEST['crit6']) && $_REQUEST['crit6'] <> ''){$sel_occur_cnt--;}
	if (isset($_REQUEST['crit7']) && $_REQUEST['crit7'] <> ''){$sel_occur_cnt--;}
	if (isset($_REQUEST['crit8']) && $_REQUEST['crit8'] <> ''){$sel_occur_cnt--;}
	if (isset($_REQUEST['crit9']) && $_REQUEST['crit9'] <> ''){$sel_occur_cnt--;}
	if (isset($_REQUEST['crit10']) && $_REQUEST['crit10'] <> ''){$sel_occur_cnt--;}

	if (isset($_REQUEST['crit11']) && $_REQUEST['crit11'] <> ''){$sel_occur_cnt--;}
	if (isset($_REQUEST['crit12']) && $_REQUEST['crit12'] <> ''){$sel_occur_cnt--;}
	if (isset($_REQUEST['crit13']) && $_REQUEST['crit13'] <> ''){$sel_occur_cnt--;}
	
	return $sel_occur_cnt;
}


function wrt_rpt($title, $sqloverall)
{?>
	<table style="margin:auto" cellspacing="0">
		<tr align="left">
			<td colspan="<?php echo col_crit_diff(); ?>">
				<table border="0" cellspacing="0" cellpadding="0" bordercolorlight="#CCCCCC" style="width:100%; border:0px">
					<tr align="left">
						<td style="border:0px; width:15%; text-align:left;" valign = Top>
							<img src="img/p_.png" width="100%"/>
						</td>						
						<td style="border:0px; width:84%; line-height:1.6; padding-left:1; vertical-align:top">
							<font style="font-size:14px">
								<?php echo $title; ?><br>
							</font><p></p>
							<font style="font-size:12px"><?php								
								date_default_timezone_set('Africa/Lagos');
								echo "As at ". date('d/m/Y h:i:s a', time());?>
							</font>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="text-align:right">
				<b>SNO</b>
			</td><?php
		
			$selection_bind_rslt_vars = '';

			for ($t = 0; $t <= strlen($_REQUEST['selection'])-1; $t++)
			{
				$ind = substr($_REQUEST['selection'],$t,1);
				switch ($ind)
				{
					case "a": //centre
						if (isset($_REQUEST['col19']))
						{?>
							<td>
								<b>STATE</b>
							</td><?php
						}
						
						if (isset($_REQUEST['crit1']) && $_REQUEST['crit1'] == '')
						{
							$selection_bind_rslt_vars .= $ind;?>
							<td>
								<b>STUDY CENTRE</b>
							</td><?php
						}
					break;

					case "b": //school
						if (isset($_REQUEST['crit2']) && $_REQUEST['crit2'] == '' || $_REQUEST['hdqry_type'] == '4')
						{
							$selection_bind_rslt_vars .= $ind;
							//if ($_REQUEST['hdqry_type'] <> '4')
							//{?>
								<td>
									<b>FACULTY</b>
								</td><?php
							//}
						}
					break;

					case "c": //dept
						if (isset($_REQUEST['crit3']) && $_REQUEST['crit3'] == '' || $_REQUEST['hdqry_type'] == '4')
						{
							$selection_bind_rslt_vars .= $ind;
							//if ($_REQUEST['hdqry_type'] <> '4')
							//{?>
								<td>
									<b>DEPARTMENT</b>
								</td><?php
							//}
						}
					break;
					
					case "d": //programme
						if (isset($_REQUEST['crit4']) && $_REQUEST['crit4'] == '' || $_REQUEST['hdqry_type'] == '4')
						{
							$selection_bind_rslt_vars .= $ind;
							//if ($_REQUEST['hdqry_type'] <> '4')
							//{?>
								<td>
									<b>PROGRAMME</b>
								</td><?php
							//}
						}
					break;			

					case "e": //course
						if (isset($_REQUEST['crit5']) && $_REQUEST['crit5'] == '' || $_REQUEST['hdqry_type'] == '4')
						{
							$selection_bind_rslt_vars .= $ind;
							if ($_REQUEST['hdqry_type'] <> '4')
							{?>
								<td>
									<b>COURSES</b>
								</td><?php
							}
						}
					break;			

					case "f": //course
						if (isset($_REQUEST['crit6']) && $_REQUEST['crit6'] == '')
						{
							$selection_bind_rslt_vars .= $ind;?>
							<td>
								<b>QUALIFICATION</b>
							</td><?php
						}
					break;

					case 'g':
						if (isset($_REQUEST['crit7']) && $_REQUEST['crit7'] == '')
						{
							$selection_bind_rslt_vars .= $ind;?>
							<td>
								<b>LEVEL</b>
							</td><?php
						}
					break;

					case "h": //gender
						if (isset($_REQUEST['crit8']) && $_REQUEST['crit8'] == '')
						{
							$selection_bind_rslt_vars .= $ind;?>
							<td>
								<b>GENDER</b>
							</td><?php
						}
					break;

					case "l": //Geo Political zone of Study Centre
						$selection_bind_rslt_vars .= $ind;?>
						<td>
							<b>GEO-POLITICAL ZONE</b>
						</td><?php
						if (isset($_REQUEST['col19']))
						{?>
							<td>
								<b>STATE</b>
							</td><?php
						}

						if (isset($_REQUEST['crit1']) && $_REQUEST['crit1'] == '')
						{
							$selection_bind_rslt_vars .= $ind;?>
							<td>
								<b>STUDY CENTRE</b>
							</td><?php
						}
					break;

					case "m": //State of origin
						if (isset($_REQUEST['crit9']) && $_REQUEST['crit9'] == '')
						{
							$selection_bind_rslt_vars .= $ind;?>
							<td>
								<b>STATE OF ORIGIN</b>
							</td><?php
						}
					break;			

					case 'n':
						if (isset($_REQUEST['crit10']) && $_REQUEST['crit10'] == '')
						{
							$selection_bind_rslt_vars .= $ind;?>
							<td>
								<b>LGA OF ORIGIN</b>
							</td><?php
						}
					break;

					case "o": //Geo Political zone of origin
						$selection_bind_rslt_vars .= $ind;?>
						<td>
							<b>GEO-POLITICAL ZONE OF ORIGIN</b>
						</td><?php
						if (isset($_REQUEST['col19']))
						{?>
							<td>
								<b>STATE OF ORIGIN</b>
							</td><?php
						}
					break;

					case "p": //State of residence
						if (isset($_REQUEST['crit11']) && $_REQUEST['crit11'] == '')
						{
							$selection_bind_rslt_vars .= $ind;?>
							<td>
								<b>STATE OF RESIDENCE</b>
							</td><?php
						}
					break;

					case "q": //lga of residence
						if (isset($_REQUEST['crit12']) && $_REQUEST['crit12'] == '')
						{
							$selection_bind_rslt_vars .= $ind;?>
							<td>
								<b>LGA OF RESIDENCE</b>
							</td><?php
						}
					break;

					case "r": //Geo Political zone of residence
						$selection_bind_rslt_vars .= $ind;?>
						<td>
							<b>GEO-POLITICAL ZONE OF RESIDENCE</b>
						</td><?php
						if (isset($_REQUEST['col19']))
						{?>
							<td>
								<b>STATE OF RESIDENCE</b>
							</td><?php
						}
					break;

					case "t": //AFN
					if ($_REQUEST['hdqry_type'] <> 1)
					{
						$selection_bind_rslt_vars .= $ind;?>
						<td>
							<b>APPLICATION NO.</b>
						</td><?php
					}
					break;

					case "u": //Matricno
					if ($_REQUEST['hdqry_type'] <> 1)
					{
						$selection_bind_rslt_vars .= $ind;?>
						<td>
							<b>MATRIC NO.</b>
						</td><?php
					}
					break;

					case "v": //Name
					if ($_REQUEST['hdqry_type'] <> 1)
					{
						$selection_bind_rslt_vars .= $ind;?>
						<td>
							<b>NAME</b>
						</td><?php
					}
					break;

					case "w": //email
					if ($_REQUEST['hdqry_type'] <> 1)
					{
						$selection_bind_rslt_vars .= $ind;?>
						<td>
							<b>eMAIL ADDRESS</b>
						</td><?php
					}
					break;

					case "x": //GSM
					if ($_REQUEST['hdqry_type'] <> 1)
					{
						$selection_bind_rslt_vars .= $ind;?>
						<td>
							<b>GSM NO.</b>
						</td><?php
					}
					break;

					case "y": //email of NOK
					if ($_REQUEST['hdqry_type'] <> 1)
					{
						$selection_bind_rslt_vars .= $ind;?>
						<td>
							<b>eMAIL ADRESS OF NOK</b>
						</td><?php
					}
					break;

					case "z": //GSM of NOK
					if ($_REQUEST['hdqry_type'] <> 1)
					{
						$selection_bind_rslt_vars .= $ind;?>
						<td>
							<b>GSM NO. OF NOK</b>
						</td><?php
					}
					break;
				}
			}
			
			if ($_REQUEST['hdqry_type'] == 1)
			{
				$selection_bind_rslt_vars .= $ind;?>
				<td style="text-align:right">
					<b>COUNT</b>
				</td><?php
			}

			if ($_REQUEST['hdqry_type'] == 3)
			{?>
				<td align="left"><b>SIGN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td><?php
			}?>
		</tr><?php
		if (strlen(trim(strpos($_REQUEST['selection'],'u'))) > 0)
		{
			$sqloverall = substr($sqloverall,0,6) . ' DISTINCT ' . substr($sqloverall,7,strlen($sqloverall)-1);
		}


		// echo '<p>'.trim($sqloverall);
		// echo '<br>'.$GLOBALS['binders'].' ';
		// $i = 1;
		// foreach ($GLOBALS['bind_vars'] as $v)
		// {
		// 	echo $i.":".$v."\n";
		// 	$i++;
		// }


		$total_count = 0;
			
		$mysqli = link_connect_db();
		$stmt = $mysqli->prepare($sqloverall);
		

		if (count($GLOBALS['bind_vars']) > 0)
		{
			if (count($GLOBALS['bind_vars']) == 1)
			{
				$stmt->bind_param($GLOBALS['binders'], 
				$GLOBALS['bind_vars'][1]);
			}else if (count($GLOBALS['bind_vars']) == 2)
			{
				$stmt->bind_param($GLOBALS['binders'], 
				$GLOBALS['bind_vars'][1], 
				$GLOBALS['bind_vars'][2]);
			}else if (count($GLOBALS['bind_vars']) == 3)
			{
				$stmt->bind_param($GLOBALS['binders'], 
				$GLOBALS['bind_vars'][1], 
				$GLOBALS['bind_vars'][2], 
				$GLOBALS['bind_vars'][3]);
			}else if (count($GLOBALS['bind_vars']) == 4)
			{
				$stmt->bind_param($GLOBALS['binders'], 
				$GLOBALS['bind_vars'][1], 
				$GLOBALS['bind_vars'][2], 
				$GLOBALS['bind_vars'][3], 
				$GLOBALS['bind_vars'][4]);
			}else if (count($GLOBALS['bind_vars']) == 5)
			{
				$stmt->bind_param($GLOBALS['binders'], 
				$GLOBALS['bind_vars'][1], 
				$GLOBALS['bind_vars'][2], 
				$GLOBALS['bind_vars'][3], 
				$GLOBALS['bind_vars'][4], 
				$GLOBALS['bind_vars'][5]);
			}else if (count($GLOBALS['bind_vars']) == 6)
			{
				$stmt->bind_param($GLOBALS['binders'], 
				$GLOBALS['bind_vars'][1], 
				$GLOBALS['bind_vars'][2], 
				$GLOBALS['bind_vars'][3], 
				$GLOBALS['bind_vars'][4], 
				$GLOBALS['bind_vars'][5], 
				$GLOBALS['bind_vars'][6]);
			}else if (count($GLOBALS['bind_vars']) == 7)
			{
				$stmt->bind_param($GLOBALS['binders'], 
				$GLOBALS['bind_vars'][1], 
				$GLOBALS['bind_vars'][2], 
				$GLOBALS['bind_vars'][3], 
				$GLOBALS['bind_vars'][4], 
				$GLOBALS['bind_vars'][5], 
				$GLOBALS['bind_vars'][6], 
				$GLOBALS['bind_vars'][7]);
			}else if (count($GLOBALS['bind_vars']) == 8)
			{
				$stmt->bind_param($GLOBALS['binders'], 
				$GLOBALS['bind_vars'][1], 
				$GLOBALS['bind_vars'][2], 
				$GLOBALS['bind_vars'][3], 
				$GLOBALS['bind_vars'][4], 
				$GLOBALS['bind_vars'][5], 
				$GLOBALS['bind_vars'][6], 
				$GLOBALS['bind_vars'][7], 
				$GLOBALS['bind_vars'][8]);
			}else if (count($GLOBALS['bind_vars']) == 9)
			{
				$stmt->bind_param($GLOBALS['binders'], 
				$GLOBALS['bind_vars'][1], 
				$GLOBALS['bind_vars'][2], 
				$GLOBALS['bind_vars'][3], 
				$GLOBALS['bind_vars'][4], 
				$GLOBALS['bind_vars'][5], 
				$GLOBALS['bind_vars'][6], 
				$GLOBALS['bind_vars'][7], 
				$GLOBALS['bind_vars'][8], 
				$GLOBALS['bind_vars'][9]);
			}else if (count($GLOBALS['bind_vars']) == 10)
			{
				$stmt->bind_param($GLOBALS['binders'], 
				$GLOBALS['bind_vars'][1], 
				$GLOBALS['bind_vars'][2], 
				$GLOBALS['bind_vars'][3], 
				$GLOBALS['bind_vars'][4], 
				$GLOBALS['bind_vars'][5], 
				$GLOBALS['bind_vars'][6], 
				$GLOBALS['bind_vars'][7], 
				$GLOBALS['bind_vars'][8], 
				$GLOBALS['bind_vars'][9], 
				$GLOBALS['bind_vars'][10]);
			}else if (count($GLOBALS['bind_vars']) == 11)
			{
				$stmt->bind_param($GLOBALS['binders'], 
				$GLOBALS['bind_vars'][1], 
				$GLOBALS['bind_vars'][2], 
				$GLOBALS['bind_vars'][3], 
				$GLOBALS['bind_vars'][4], 
				$GLOBALS['bind_vars'][5], 
				$GLOBALS['bind_vars'][6], 
				$GLOBALS['bind_vars'][7], 
				$GLOBALS['bind_vars'][8], 
				$GLOBALS['bind_vars'][9], 
				$GLOBALS['bind_vars'][10], 
				$GLOBALS['bind_vars'][11]);
			}else if (count($GLOBALS['bind_vars']) == 12)
			{
				$stmt->bind_param($GLOBALS['binders'], 
				$GLOBALS['bind_vars'][1], 
				$GLOBALS['bind_vars'][2], 
				$GLOBALS['bind_vars'][3], 
				$GLOBALS['bind_vars'][4], 
				$GLOBALS['bind_vars'][5], 
				$GLOBALS['bind_vars'][6], 
				$GLOBALS['bind_vars'][7], 
				$GLOBALS['bind_vars'][8], 
				$GLOBALS['bind_vars'][9], 
				$GLOBALS['bind_vars'][10], 
				$GLOBALS['bind_vars'][11], 
				$GLOBALS['bind_vars'][12]);
			}else if (count($GLOBALS['bind_vars']) == 13)
			{
				$stmt->bind_param($GLOBALS['binders'], 
				$GLOBALS['bind_vars'][1], 
				$GLOBALS['bind_vars'][2], 
				$GLOBALS['bind_vars'][3], 
				$GLOBALS['bind_vars'][4], 
				$GLOBALS['bind_vars'][5], 
				$GLOBALS['bind_vars'][6], 
				$GLOBALS['bind_vars'][7], 
				$GLOBALS['bind_vars'][8], 
				$GLOBALS['bind_vars'][9], 
				$GLOBALS['bind_vars'][10], 
				$GLOBALS['bind_vars'][11], 
				$GLOBALS['bind_vars'][12], 
				$GLOBALS['bind_vars'][13]);
			}else if (count($GLOBALS['bind_vars']) == 14)
			{
				$stmt->bind_param($GLOBALS['binders'], 
				$GLOBALS['bind_vars'][1], 
				$GLOBALS['bind_vars'][2], 
				$GLOBALS['bind_vars'][3], 
				$GLOBALS['bind_vars'][4], 
				$GLOBALS['bind_vars'][5], 
				$GLOBALS['bind_vars'][6], 
				$GLOBALS['bind_vars'][7],
				$GLOBALS['bind_vars'][8], 
				$GLOBALS['bind_vars'][9], 
				$GLOBALS['bind_vars'][10], 
				$GLOBALS['bind_vars'][11], 
				$GLOBALS['bind_vars'][12], 
				$GLOBALS['bind_vars'][13], 
				$GLOBALS['bind_vars'][14]);
			}else if (count($GLOBALS['bind_vars']) == 15)
			{
				$stmt->bind_param($GLOBALS['binders'], 
				$GLOBALS['bind_vars'][1], 
				$GLOBALS['bind_vars'][2], 
				$GLOBALS['bind_vars'][3], 
				$GLOBALS['bind_vars'][4], 
				$GLOBALS['bind_vars'][5], 
				$GLOBALS['bind_vars'][6], 
				$GLOBALS['bind_vars'][7], 
				$GLOBALS['bind_vars'][8], 
				$GLOBALS['bind_vars'][9], 
				$GLOBALS['bind_vars'][10], 
				$GLOBALS['bind_vars'][11], 
				$GLOBALS['bind_vars'][12], 
				$GLOBALS['bind_vars'][13], 
				$GLOBALS['bind_vars'][14], 
				$GLOBALS['bind_vars'][15]);
			}else if (count($GLOBALS['bind_vars']) == 16)
			{
				$stmt->bind_param($GLOBALS['binders'], 
				$GLOBALS['bind_vars'][1], 
				$GLOBALS['bind_vars'][2], 
				$GLOBALS['bind_vars'][3], 
				$GLOBALS['bind_vars'][4], 
				$GLOBALS['bind_vars'][5], 
				$GLOBALS['bind_vars'][6], 
				$GLOBALS['bind_vars'][7], 
				$GLOBALS['bind_vars'][8], 
				$GLOBALS['bind_vars'][9], 
				$GLOBALS['bind_vars'][10], 
				$GLOBALS['bind_vars'][11], 
				$GLOBALS['bind_vars'][12], 
				$GLOBALS['bind_vars'][13], 
				$GLOBALS['bind_vars'][14], 
				$GLOBALS['bind_vars'][15], 
				$GLOBALS['bind_vars'][16]);
			}
		}
		 
		$stmt->execute();
		$stmt->store_result();
		
		$bind_rslt_vars = array();
		if (strlen($selection_bind_rslt_vars) > 0)
		{
			if (strlen($selection_bind_rslt_vars) == 1)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 2)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 3)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 4)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 5)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 6)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 7)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 8)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 9)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 10)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 11)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 12)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 13)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 14)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 15)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 16)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 17)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 18)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,17,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 19)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,17,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,17,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,18,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 20)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,17,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,18,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,17,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,18,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,19,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 21)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,17,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,18,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,19,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,17,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,18,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,19,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,20,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 22)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,17,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,18,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,19,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,20,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,17,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,18,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,19,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,20,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,21,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 23)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,17,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,18,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,19,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,20,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,21,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,17,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,18,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,19,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,20,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,21,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,22,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 24)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,17,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,18,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,19,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,20,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,21,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,22,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,17,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,18,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,19,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,20,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,21,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,22,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,23,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 25)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,17,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,18,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,19,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,20,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,21,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,22,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,23,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,24,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,17,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,18,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,19,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,20,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,21,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,22,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,23,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,24,1)]);
				}
			}else if (strlen($selection_bind_rslt_vars) == 26)
			{
				if ($_REQUEST['hdqry_type'] == '1')
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,17,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,18,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,19,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,20,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,21,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,22,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,23,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,24,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,25,1)],
					$bind_rslt_vars['A']);
				}else
				{
					$stmt->bind_result($bind_rslt_vars[substr($selection_bind_rslt_vars,0,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,1,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,2,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,3,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,4,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,5,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,6,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,7,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,8,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,9,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,10,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,11,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,12,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,13,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,14,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,15,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,16,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,17,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,18,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,19,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,20,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,21,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,22,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,23,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,24,1)],
					$bind_rslt_vars[substr($selection_bind_rslt_vars,25,1)]);
				}
			}
		}

		// $i = 1;
		// echo $selection_bind_rslt_vars."<br>";
		// foreach ($bind_rslt_vars as $v) {
		// 	echo $i."=".$v.", ";
		// 	$i++;
		//  }

		$fetched_col_count = $stmt->num_rows;
		$row_count = 0;
		while ($stmt->fetch())
		{?>
			<tr>
				<td style="text-align:right">
					<?php echo ++$row_count; ?>
				</td><?php
				for ($t = 0; $t <= strlen($_REQUEST['selection'])-1; $t++)
				{
					$ind = substr($_REQUEST['selection'],$t,1);
					switch ($ind)
					{
						case "a": //centre
							if (isset($_REQUEST['col19']))
							{?>
								<td>
									<?php echo $bind_rslt_vars[$ind]; ?>
								</td><?php
							}

							if ($_REQUEST['crit1'] == '')
							{?>
								<td>
									<?php echo $bind_rslt_vars[$ind]; ?>
								</td><?php
							}
						break;

						case "b": //school
							if ($_REQUEST['crit2'] == '')
							{?>
								<td>
									<?php
										echo $bind_rslt_vars[$ind];?>
									
								</td><?php
							}
						break;

						case "c": //dept
							if ($_REQUEST['crit3'] == '')
							{?>
								<td>
									<?php
										echo  $bind_rslt_vars[$ind];?>
									
								</td><?php
							}
						break;

						case "d": //programme
							if ($_REQUEST['crit4'] == '')
							{?>
								<td>
									<?php
										if (!is_bool(strpos($bind_rslt_vars[$ind],"(d)")))
									{
										echo substr($bind_rslt_vars[$ind], 0, strlen($bind_rslt_vars[$ind])-4);
									}else
									{
										echo  $bind_rslt_vars[$ind];
									}?>
									
								</td><?php
							}
						break;

						case "e": //courses
							if ($_REQUEST['crit5'] == '')
							{?>
								<td>
									<?php
										echo  $bind_rslt_vars[$ind];?>
									
								</td><?php
							}
						break;

						case "f": //entry qulaification
							if ($_REQUEST['crit6'] == '')
							{?>
								<td>
									<?php
										echo  $bind_rslt_vars[$ind];?>
									
								</td><?php
							}
						break;

						case "g": //level
						if ($_REQUEST['crit7'] == '')
						{?>
							<td>
								<?php echo $bind_rslt_vars[$ind];?>
							</td><?php
						}
						break;

						case "h": //gender
							if ($_REQUEST['crit8'] == '')
							{?>
								<td>
									<?php
										echo  $bind_rslt_vars[$ind];?>
									
								</td><?php
							}
						break;

						case "l": //Geo Political zone of Study Centre?>
							<td>
								<?php echo $bind_rslt_vars[$ind]; ?>
							</td><?php
							if (isset($_REQUEST['col19']))
							{?>
								<td>
									<?php echo $bind_rslt_vars[$ind]; ?>
								</td><?php
							}

							if ($_REQUEST['crit1'] == '')
							{?>
							<td>
								<?php echo $bind_rslt_vars[$ind]; ?>
							</td><?php
							}
						break;

						case "m": //State of origin
							if ($_REQUEST['crit9'] == '')
							{?>
								<td>
									<?php echo $bind_rslt_vars[$ind]; ?>
								</td><?php
							}
						break;

						case "n": //State of origin
							if ($_REQUEST['crit10'] == '')
							{?>
								<td>
									<?php echo $bind_rslt_vars[$ind]; ?>
								</td><?php
							}
						break;

						case "o": //Geo Political zone of origin?>
							<td>
								
								<?php echo $bind_rslt_vars[$ind];?>
							</td><?php

							if (isset($_REQUEST['col19']))
							{?>
								<td>
									<?php echo $bind_rslt_vars[$ind];?>
								</td><?php
							}
						break;

						case "p": //State of residence
							if ($_REQUEST['crit11'] == '')
							{?>
								<td>
									<?php echo $bind_rslt_vars[$ind];?>
								</td><?php
							}
						break;

						case "q": //lga of residence
							if ($_REQUEST['crit12'] == '')
							{?>
								<td>
									<?php echo $bind_rslt_vars[$ind];?>
								</td><?php
							}
						break;

						case "r": //Geo Political zone of residence?>
							<td>
								<?php echo $bind_rslt_vars[$ind];?>
							</td><?php
							if (isset($_REQUEST['col19']))
							{?>
								<td>
									<?php echo $bind_rslt_vars[$ind];?>
								</td><?php
							}
						break;

						case "t": //AFN
						if ($_REQUEST['hdqry_type'] <> 1)
						{?>
							<td>
								<?php echo $bind_rslt_vars[$ind];?>
							</td><?php
						}
						break;

						case "u": //Matricno
						if ($_REQUEST['hdqry_type'] <> 1)
						{?>
							<td>
								<?php echo $bind_rslt_vars[$ind];?>
							</td><?php
						}
						break;

						case "v": //Name
						if ($_REQUEST['hdqry_type'] <> 1)
						{?>
							<td>
								<?php echo $bind_rslt_vars[$ind];?>
							</td><?php
						}
						break;

						case "w": //email
						if ($_REQUEST['hdqry_type'] <> 1)
						{?>
							<td>
								<?php echo $bind_rslt_vars[$ind];?>
							</td><?php
						}
						break;

						case "x": //GSM
						if ($_REQUEST['hdqry_type'] <> 1)
						{?>
							<td>
								<?php echo $bind_rslt_vars[$ind];?>
							</td><?php
						}
						break;

						case "y": //email of NOK
						if ($_REQUEST['hdqry_type'] <> 1)
						{?>
							<td>
								<?php echo $bind_rslt_vars[$ind];?>
							</td><?php
						}
						break;

						case "z": //GSM of NOK
						if ($_REQUEST['hdqry_type'] <> 1)
						{?>
							<td>
								<?php echo $bind_rslt_vars[$ind];?>
							</td><?php
						}
						break;
					}
				}

				if ($_REQUEST['hdqry_type'] == 3)
				{?>
					<td align="left"></td><?php
				}

				if ($_REQUEST['hdqry_type'] == 1)
				{?>
					<td style="text-align:right">
						<?php $total_count += $bind_rslt_vars['A']; echo number_format($bind_rslt_vars['A']);?>
					</td><?php
				}

				if (($_REQUEST['vApplicationNo'] <> '' || $_REQUEST['vMatricNo'] <> '' || $_REQUEST['vLastName'] <> '') && $_REQUEST['std_cat'] == 'b')
				{?>
					<!-- <td>
						<?php echo $bind_rslt_vars[$ind];?>
					</td> --><?php
				}?>
			</tr><?php
		}?>
		<tr>
			<td colspan="<?php echo col_crit_diff(); ?>" style="text-align:right">
				<?php if ($_REQUEST['hdqry_type'] == 1)
				{echo 'Total: '.number_format($total_count);}else{echo 'Total number of record(s): '.number_format($fetched_col_count);} ?>
				
			</td>
		</tr>	
	</table><?php
}?>