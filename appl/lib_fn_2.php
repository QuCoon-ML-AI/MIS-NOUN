<?php

date_default_timezone_set('Africa/Lagos');
function s_cadm_cemba()
{
	$mysqli = link_connect_db();

	$detail_of_seleted_prog_1 = '';

	$candidate_qual_sbj = $mysqli->prepare("SELECT DISTINCT cNouSubjectId
	FROM afnqualsubject 
	WHERE (cEduCtgId LIKE 'OL%' OR cEduCtgId = 'ALW')
	AND cNouSubjectId IN ('001','016')
	AND iGradeRank >= 4
	AND vApplicationNo = ?");
	$candidate_qual_sbj->bind_param("s", $_REQUEST["vApplicationNo"]);
	$candidate_qual_sbj->execute();
	$candidate_qual_sbj->store_result();
	if ($candidate_qual_sbj->num_rows == 2)
	{
		$candidate_o_qual_sbj = $mysqli->prepare("SELECT DISTINCT cNouSubjectId, cNouGradeId, iGradeRank
		FROM afnqualsubject 
		WHERE (cEduCtgId LIKE 'OL%' OR cEduCtgId = 'ALW')
		AND cNouSubjectId NOT IN ('001','016')
		AND iGradeRank >= 4
		AND vApplicationNo = ?");
		$candidate_o_qual_sbj->bind_param("s", $_REQUEST["vApplicationNo"]);
		$candidate_o_qual_sbj->execute();
		$candidate_o_qual_sbj->store_result();
		if ($candidate_o_qual_sbj->num_rows >= 3)
		{
			//cemba pg qual
			$candidate_h_qual_sbj = $mysqli->prepare("SELECT *
			FROM afnqualsubject 
			WHERE cEduCtgId = 'PGX'
			AND cNouSubjectId = '517'
			AND iGradeRank >= 1
			AND vApplicationNo = ?");
			$candidate_h_qual_sbj->bind_param("s", $_REQUEST["vApplicationNo"]);
			$candidate_h_qual_sbj->execute();
			$candidate_h_qual_sbj->store_result();
			if ($candidate_h_qual_sbj->num_rows > 0)
			{
				$detail_of_seleted_prog_1 = 'MSC415 800 18~';

			}

			//cempa pg qual
			$candidate_h_qual_sbj = $mysqli->prepare("SELECT *
			FROM afnqualsubject 
			WHERE cEduCtgId = 'PGX'
			AND cNouSubjectId = '604'
			AND iGradeRank >= 1
			AND vApplicationNo = ?");
			$candidate_h_qual_sbj->bind_param("s", $_REQUEST["vApplicationNo"]);
			$candidate_h_qual_sbj->execute();
			$candidate_h_qual_sbj->store_result();
			if ($candidate_h_qual_sbj->num_rows > 0)
			{
				$detail_of_seleted_prog_1 .= 'MSC416 800 21~';
			}

			//cemba higher qual
			$stmt_qual_sbj = $mysqli->prepare("SELECT a.*
			FROM criteriasubject a, afnqualsubject b
			WHERE a.cEduCtgId = b.cEduCtgId
			AND b.iGradeRank >= a.iQualGradeRank
			AND a.cEduCtgId IN ('PSX','PSZ')
			AND a.cProgrammeId = 'MSC415'
			AND b.vApplicationNo = ?
			AND a.cDelFlag = 'N'");
			$stmt_qual_sbj->bind_param("s", $_REQUEST["vApplicationNo"]);
			
			$stmt_qual_sbj->execute();
			$stmt_qual_sbj->store_result();
			if ($stmt_qual_sbj->num_rows > 0)
			{
				if (is_bool(strpos($detail_of_seleted_prog_1,'MSC415')))
				{
					$detail_of_seleted_prog_1 .= 'MSC415 800 17~';
				}
				
			}

			//cempa higher qual
			$stmt_qual_sbj = $mysqli->prepare("SELECT a.*
			FROM criteriasubject a, afnqualsubject b
			WHERE a.cEduCtgId = b.cEduCtgId
			AND b.iGradeRank >= a.iQualGradeRank
			AND a.cEduCtgId IN ('PSX','PSZ')
			AND a.cProgrammeId = 'MSC416'
			AND b.vApplicationNo = ?
			AND a.cDelFlag = 'N'");
			$stmt_qual_sbj->bind_param("s", $_REQUEST["vApplicationNo"]);
			
			$stmt_qual_sbj->execute();
			$stmt_qual_sbj->store_result();
			if ($stmt_qual_sbj->num_rows > 0)
			{
				if (is_bool(strpos($detail_of_seleted_prog_1,'MSC416')))
				{
					$detail_of_seleted_prog_1 .= 'MSC416 800 20~';
				}
			}
		}
	}

	return $detail_of_seleted_prog_1;
}


function s_cadm_mba()
{
	$mysqli = link_connect_db();

	$detail_of_seleted_prog_1 = '';

	if ($_REQUEST["cdeptold7"] == 'BUS')
	{
		if ($_REQUEST["cEduCtgId"] == 'PGY')
		{
			//MBA
			$candidate_qual_sbj = $mysqli->prepare("SELECT DISTINCT cNouSubjectId
			FROM afnqualsubject 
			WHERE (cEduCtgId LIKE 'OL%' OR cEduCtgId = 'ALW')
			AND cNouSubjectId IN ('001','016')
			AND iGradeRank >= 4
			AND vApplicationNo = ?");
			$candidate_qual_sbj->bind_param("s", $_REQUEST["vApplicationNo"]);
			$candidate_qual_sbj->execute();
			$candidate_qual_sbj->store_result();
			if ($candidate_qual_sbj->num_rows == 2)
			{
				//echo $candidate_qual_sbj->num_rows;

				$candidate_o_qual_sbj = $mysqli->prepare("SELECT DISTINCT cNouSubjectId, cNouGradeId, iGradeRank
				FROM afnqualsubject 
				WHERE (cEduCtgId LIKE 'OL%' OR cEduCtgId = 'ALW')
				AND cNouSubjectId NOT IN ('001','016')
				AND iGradeRank >= 4
				AND vApplicationNo = ?");
				$candidate_o_qual_sbj->bind_param("s", $_REQUEST["vApplicationNo"]);
				$candidate_o_qual_sbj->execute();
				$candidate_o_qual_sbj->store_result();
				$candidate_o_qual_sbj->bind_result($cNouSubjectId, $cNouGradeId, $iGradeRank);

				$taken_opt_subjects = '';
				$opt_subject_count = 0;
				while ($candidate_o_qual_sbj->fetch())
				{
					/*if ($cNouSubjectId == '033' || $cNouSubjectId == '035' || $cNouSubjectId == '038')
					{
						if ($taken_opt_subjects == '')
						{
							$taken_opt_subjects = $cNouSubjectId;
							$opt_subject_count++;
						}
					}else
					{*/
						$opt_subject_count++;
					//}
				}

				if ($opt_subject_count < 3)
				{
					return '';
				}

				$candidate_h_qual_sbj = $mysqli->prepare("SELECT *
				FROM afnqualsubject 
				WHERE cEduCtgId IN ('PSX', 'PSZ')
				AND vApplicationNo = ?");
				$candidate_h_qual_sbj->bind_param("s", $_REQUEST["vApplicationNo"]);
				$candidate_h_qual_sbj->execute();
				$candidate_h_qual_sbj->store_result();
				//echo $candidate_h_qual_sbj->num_rows;

				if ($candidate_h_qual_sbj->num_rows > 0)
				{
					$stmt_reqr = $mysqli->prepare("SELECT sReqmtId
					FROM criteriadetail a, afnqualsubject b
					WHERE cProgrammeId LIKE '%MSC403%'
					AND a.cEduCtgId_2 = b.cEduCtgId
					AND vApplicationNo = ?
					AND a.cDelFlag = 'N'");
					$stmt_reqr->bind_param("s", $_REQUEST["vApplicationNo"]);
					$stmt_reqr->execute();
					$stmt_reqr->store_result();
					$stmt_reqr->bind_result($sReqmtId);
					$stmt_reqr->fetch();					
					
					$detail_of_seleted_prog_1 = 'MSC403 800 '.$sReqmtId.'~';
				}
			}
		}
	}
	
	return $detail_of_seleted_prog_1;
}

function s_cadm_maeng()
{
	$mysqli = link_connect_db();

	$detail_of_seleted_prog_1 = '';

	if ($_REQUEST["cdeptold7"] == 'ENG')
	{
		if ($_REQUEST["cEduCtgId"] == 'PGY')
		{
			//MBA
			$candidate_qual_sbj = $mysqli->prepare("SELECT cNouSubjectId, cNouGradeId, iGradeRank
			FROM afnqualsubject 
			WHERE (cEduCtgId LIKE 'OL%' OR cEduCtgId = 'ALW')
			AND cNouSubjectId IN ('001','016')
			AND iGradeRank >= 4
			AND vApplicationNo = ?");
			$candidate_qual_sbj->bind_param("s", $_REQUEST["vApplicationNo"]);
			$candidate_qual_sbj->execute();
			$candidate_qual_sbj->store_result();
			if ($candidate_qual_sbj->num_rows == 2)
			{
				//echo $candidate_qual_sbj->num_rows;
			
				$candidate_h_qual_sbj = $mysqli->prepare("SELECT *
				FROM afnqualsubject 
				WHERE cEduCtgId = 'PSZ'
				AND cNouSubjectId IN ('001','536','565')
				AND cNouGradeId = '603'
				AND iGradeRank >= 3
				AND vApplicationNo = ?");
				$candidate_h_qual_sbj->bind_param("s", $_REQUEST["vApplicationNo"]);
				$candidate_h_qual_sbj->execute();
				$candidate_h_qual_sbj->store_result();
				//echo $candidate_h_qual_sbj->num_rows;

				if ($candidate_h_qual_sbj->num_rows > 0)
				{
					$stmt_reqr = $mysqli->prepare("SELECT sReqmtId
					FROM criteriadetail a, afnqualsubject b
					WHERE cProgrammeId LIKE '%ART416%'
					AND a.cEduCtgId_2 = b.cEduCtgId
					AND vApplicationNo = ?
					AND a.cDelFlag = 'N' LIMIT 1");
					$stmt_reqr->bind_param("s", $_REQUEST["vApplicationNo"]);
					$stmt_reqr->execute();
					$stmt_reqr->store_result();
					$stmt_reqr->bind_result($sReqmtId);
					$stmt_reqr->fetch();					
					
					$detail_of_seleted_prog_1 = 'ART416 800 '.$sReqmtId.'~';
				}
			}
		}
	}
	
	return $detail_of_seleted_prog_1;
}


function s_cadm()
{
    $mysqli = link_connect_db();
    
    $ol_qualified = 0;
    $h_qualified = 0;
    
    $detail_of_seleted_prog_1 = '';
    
    $stmt_programme = $mysqli->prepare("SELECT cProgrammeId
	FROM programme 
	WHERE cdeptId = ?
	AND cEduCtgId = ?
	AND cDelFlag = 'N'");
	$stmt_programme->bind_param("ss", $_REQUEST["cdeptold7"], $_REQUEST["cEduCtgId"]);
	$stmt_programme->execute();
	$stmt_programme->store_result();
	//$stmt_programme->bind_result($cProgrammeId);
	
	if ($stmt_programme->num_rows == 0 && isset($_REQUEST["cEduCtgId"]))
	{
		$cat_desc = '';
		if (!is_bool(strpos($_REQUEST["cEduCtgId"], 'AL')))
		{
			$cat_desc = 'AL';
		}elseif ($_REQUEST["cEduCtgId"] == 'ELZ')
		{
			$cat_desc = 'Diploma';
		}else if ($_REQUEST["cEduCtgId"] == 'PSX')
		{
			$cat_desc = 'Higher Nation Diploma';
		}else if ($_REQUEST["cEduCtgId"] == 'PSZ')
		{
			$cat_desc = 'First Degree';
		}else if ($_REQUEST["cEduCtgId"] == 'PGX')
		{
			$cat_desc = 'Postgraduate Diploma';
		}else if ($_REQUEST["cEduCtgId"] == 'PGY')
		{
			$cat_desc = 'Masters Degree';
		}else if ($_REQUEST["cEduCtgId"] == 'PGZ')
		{
			$cat_desc = 'Pre-Doctorate Degree';
		}else if ($_REQUEST["cEduCtgId"] == 'PRX')
		{
			$cat_desc = 'Doctorate Degree';
		}else if ($_REQUEST["cEduCtgId"] == 'ELX')
		{
			$cat_desc = 'Certificate programm';
		}
		return "There are no programmes in the selected category ($cat_desc) in this department<br>";
	}

	$sub_qry = "AND cDelFlag = 'N'";
	if ($_REQUEST["cdeptold7"] == 'LLW')
	{
		$sub_qry = "";
	}

	if ($_REQUEST["cdeptold7"] == 'BUS')
	{
		if ($_REQUEST["cEduCtgId"] == 'PGX')
		{
			$stmt_programme = $mysqli->prepare("SELECT cProgrammeId
			FROM programme 
			WHERE cdeptId = ?
			AND cEduCtgId = 'PGX'
			$sub_qry");
		}else
		{
			$stmt_programme = $mysqli->prepare("SELECT cProgrammeId
			FROM programme 
			WHERE cdeptId = ?
			AND cEduCtgId = 'PSZ'
			$sub_qry");
		}
	}else
	{
		$stmt_programme = $mysqli->prepare("SELECT cProgrammeId
		FROM programme 
		WHERE cdeptId = ?
		AND cEduCtgId = 'PSZ'
		$sub_qry");
	}
	
	
	$stmt_programme->bind_param("s", $_REQUEST["cdeptold7"]);
	$stmt_programme->execute();
	$stmt_programme->store_result();
	$stmt_programme->bind_result($cProgrammeId);

	while($stmt_programme->fetch())
	{
	    if ($cProgrammeId == 'HSC204' || $cProgrammeId == 'HSC205')
	    {
	        continue;
	    }
		

		//$cProgrammeId_ol = $cProgrammeId;   
	    
	    $stmt_reqr = $mysqli->prepare("SELECT sReqmtId, cEduCtgId_2, iBeginLevel
    	FROM criteriadetail 
    	WHERE cProgrammeId LIKE '%$cProgrammeId%'
		AND cEduCtgId_1 = 'OL'
		AND cEduCtgId_2 = ''
    	AND cDelFlag = 'N'
    	ORDER BY iBeginLevel DESC");
    	$stmt_reqr->execute();
    	$stmt_reqr->store_result();
    	$stmt_reqr->bind_result($sReqmtId, $cEduCtgId_2, $iBeginLevel);
		while($stmt_reqr->fetch())
	    {			
			//echo $cProgrammeId.','.$sReqmtId.', '.$cEduCtgId_2.', '.$iBeginLevel.'<br>';
			
			$pgd_condition = "";
			if (($_REQUEST["cdeptold7"] == 'PAD' || substr($cProgrammeId, 0,3) == 'SSC') && $_REQUEST["cEduCtgId"] == 'PGX')
			{
				$pgd_condition = " AND a.cQualSubjectId IN ('001','016')";
			}
		
			$mutual_ex_str = '';
			//get number of C subjects
			$stmt_qual_sbj = $mysqli->prepare("SELECT mutual_ex, cMandate
			FROM criteriasubject a, qualsubject b
			WHERE a.cQualSubjectId = b.cQualSubjectId 
			AND sReqmtId = '$sReqmtId'
			AND cProgrammeId  LIKE '%$cProgrammeId%'
			$pgd_condition
			AND cEduCtgId = 'OL'
			AND cMandate = 'C'
			AND a.cDelFlag = 'N'");
			
        	$stmt_qual_sbj->execute();
        	$stmt_qual_sbj->store_result();
        	$stmt_qual_sbj->bind_result($mutual_ex, $cMandate);
			$obtainable_comp_sub = 0;
	        while($stmt_qual_sbj->fetch())
    	    {
				if ($mutual_ex <> '0' && is_bool(strpos($mutual_ex_str, $mutual_ex)))
				{
					$mutual_ex_str .= $mutual_ex;
					$obtainable_comp_sub++;
				}else if ($mutual_ex == '0')
				{
					$obtainable_comp_sub++;
				}
			}
		}
		
		$ol_qualified = 0;

	    //$obtainable_comp_sub = 0;
        $obtained_comp_sub = 0;
        $count_opt_cubject = 0;

		//echo $cProgrammeId.','.$obtainable_comp_sub.'<br>';
		$candidate_qual_sbj = $mysqli->prepare("SELECT cNouSubjectId, cNouGradeId, iGradeRank
		FROM afnqualsubject 
		WHERE (cEduCtgId LIKE 'OL%' OR cEduCtgId = 'ALW')
		AND vApplicationNo = ?
		ORDER BY cNouSubjectId, cNouGradeId, iGradeRank");
		$candidate_qual_sbj->bind_param("s", $_REQUEST["vApplicationNo"]);
		$candidate_qual_sbj->execute();
		$candidate_qual_sbj->store_result();
		$candidate_qual_sbj->bind_result($candi_cNouSubjectId, $cNouGradeId, $candi_iGradeRank);
		
		//run thru selected cand qual and subject
		
		$x = 0;
		$arr_track_mutual_ex = array();

		$cnt = 0;
		$arr_subjects = array();
		
		while($candidate_qual_sbj->fetch())
		{
			if (!is_bool(array_search($candi_cNouSubjectId, $arr_subjects)))
			{
				continue;
			}

			//echo $cProgrammeId.','.$obtainable_comp_sub.','.$candi_cNouSubjectId.','.$candi_iGradeRank.'*<br>';

			$stmt_qual_sbj = $mysqli->prepare("SELECT vQualSubjectDesc, a.cQualSubjectId, mutual_ex, cQualGradeId, iQualGradeRank, cMandate
			FROM criteriasubject a, qualsubject b
			WHERE a.cQualSubjectId = b.cQualSubjectId 
			AND sReqmtId = '$sReqmtId'
			AND cProgrammeId  LIKE '%$cProgrammeId%'
			AND cEduCtgId = 'OL'
			AND a.cQualSubjectId = '$candi_cNouSubjectId'
			AND iQualGradeRank <= $candi_iGradeRank
			AND a.cDelFlag = 'N'");
			
			$stmt_qual_sbj->execute();
			$stmt_qual_sbj->store_result();
			if ($stmt_qual_sbj->num_rows > 0)
			{
				$stmt_qual_sbj->bind_result($vQualSubjectDesc, $cQualSubjectId, $mutual_ex, $cQualGradeId, $iQualGradeRank, $cMandate);
				$stmt_qual_sbj->fetch();
				
				if (!(($cQualSubjectId == '033' || $cQualSubjectId == '035' || $cQualSubjectId == '093' || $cQualSubjectId == '091') && $_REQUEST["cEduCtgId"] == 'PGX' && $_REQUEST["cdeptold7"] == 'PAD'))
				{
					if ($mutual_ex <> 0)
					{
						if (!is_bool(array_search($mutual_ex, $arr_track_mutual_ex)))
						{
							continue;
						}else
						{
							$x++;
							$arr_track_mutual_ex[$x] = $mutual_ex;
						}
					}
				}

				$cnt++;
				$arr_subjects[$cnt] = $cQualSubjectId;

				if ($cMandate == 'C')
				{					
					$obtained_comp_sub++;
					if (($cQualSubjectId == '092' && $_REQUEST["cEduCtgId"] == 'PGX' && $_REQUEST["cdeptold7"] == 'CSS') ||
					(($cQualSubjectId == '033' || $cQualSubjectId == '035' || $cQualSubjectId == '093' || $cQualSubjectId == '091') && $_REQUEST["cEduCtgId"] == 'PGX' && $_REQUEST["cdeptold7"] == 'PAD') ||
					($cQualSubjectId == '035' && $_REQUEST["cEduCtgId"] == 'PGX' && ($_REQUEST["cdeptold7"] == 'CSS' || $_REQUEST["cdeptold7"] == 'ECO')))
					{
						$cMandate = 'E';
						$obtained_comp_sub--;
						$count_opt_cubject++;
					}
					
				}else
				{
					$count_opt_cubject++;
				}

				//echo $vQualSubjectDesc.','.$cQualSubjectId.','.$mutual_ex.','.$cQualGradeId.','.$iQualGradeRank.','.$candi_iGradeRank.','.$cMandate.'<br>';
			}

			if ($obtainable_comp_sub == $obtained_comp_sub && $obtained_comp_sub + $count_opt_cubject >= 5)
			{
				if ($_REQUEST["cEduCtgId"] == 'PSZ' && $_REQUEST["cdeptold7"] <> 'LLW')
				{
					if (is_bool(strpos($detail_of_seleted_prog_1, $cProgrammeId.' '.$iBeginLevel.' '.$sReqmtId)))
					{
						$detail_of_seleted_prog_1 .= $cProgrammeId.' '.$iBeginLevel.' '.$sReqmtId.'~';
					}
				}				
				$ol_qualified = 1;
				break;
			}
		}
	}

	//echo $detail_of_seleted_prog_1.'<p>';

	
		
	//ccheck higher qualification
	if ($ol_qualified <> '1' && $detail_of_seleted_prog_1 == '')
	{
		return 'Insufficient Olevel qualification';
	}



	$stmt_programme = $mysqli->prepare("SELECT cProgrammeId
	FROM programme 
	WHERE cdeptId = ?
	AND cEduCtgId = ?
	AND cDelFlag = 'N'");
	$stmt_programme->bind_param("ss", $_REQUEST["cdeptold7"], $_REQUEST["cEduCtgId"]);
	$stmt_programme->execute();
	$stmt_programme->store_result();
	$stmt_programme->bind_result($cProgrammeId);

	while($stmt_programme->fetch())
	{
		$stmt_reqr = $mysqli->prepare("SELECT sReqmtId, cEduCtgId_2, iBeginLevel
    	FROM criteriadetail 
    	WHERE cProgrammeId LIKE '%$cProgrammeId%'
		AND cEduCtgId_2 <> ''
    	AND cDelFlag = 'N'
    	ORDER BY iBeginLevel DESC");
    	$stmt_reqr->execute();
    	$stmt_reqr->store_result();
    	$stmt_reqr->bind_result($sReqmtId, $cEduCtgId_2, $iBeginLevel);
		while($stmt_reqr->fetch())
	    {
			if ($cEduCtgId_2 == 'ELZ' || $cEduCtgId_2 == 'PSX' || $cEduCtgId_2 == 'PSZ' || $cEduCtgId_2 == 'PGX' || $cEduCtgId_2 == 'PGY' || $cEduCtgId_2 == 'PRX' || $cEduCtgId_2 == 'PGZ')
			{
				$expected_min_num_of_subject = 1;
			}else
			{
				$expected_min_num_of_subject = 2;
			}

			$h_qualified = 0;

			//echo $cProgrammeId.','.$sReqmtId.', '.$cEduCtgId_2.', '.$iBeginLevel.'<br>';
		
			$ol_qualified = 0;

			$mutual_ex_str = '';
			
	
			//get number of C subjects
			$obtainable_comp_sub = 0;
			$stmt_qual_sbj = $mysqli->prepare("SELECT mutual_ex, cMandate
			FROM criteriasubject a, qualsubject b
			WHERE a.cQualSubjectId = b.cQualSubjectId 
			AND sReqmtId = '$sReqmtId'
			AND cProgrammeId  LIKE '%$cProgrammeId%'
			AND cEduCtgId = '$cEduCtgId_2'
			AND cMandate = 'C'
			AND a.cDelFlag = 'N'");
			
        	$stmt_qual_sbj->execute();
        	$stmt_qual_sbj->store_result();
        	$stmt_qual_sbj->bind_result($mutual_ex, $cMandate);
			$obtainable_comp_sub = 0;
	        while($stmt_qual_sbj->fetch())
    	    {
				if ($mutual_ex <> '0' && is_bool(strpos($mutual_ex_str, $mutual_ex)))
				{
					$mutual_ex_str .= $mutual_ex;
					$obtainable_comp_sub++;
				}else if ($mutual_ex == '0')
				{
					$obtainable_comp_sub++;
				}
			}

			$obtained_comp_sub = 0;
			$count_opt_cubject = 0;

			$candidate_qual_sbj = $mysqli->prepare("SELECT cNouSubjectId, cNouGradeId, iGradeRank
			FROM afnqualsubject 
			WHERE cEduCtgId = '$cEduCtgId_2'
			AND vApplicationNo = ?
			ORDER BY cNouSubjectId, cNouGradeId, iGradeRank");
			$candidate_qual_sbj->bind_param("s", $_REQUEST["vApplicationNo"]);
			$candidate_qual_sbj->execute();
			$candidate_qual_sbj->store_result();
			$candidate_qual_sbj->bind_result($candi_cNouSubjectId, $cNouGradeId, $candi_iGradeRank);
			
			//run thru selected cand qual and subject
			
			$x = 0;
			$arr_track_mutual_ex = array();

			$cnt = 0;
			$arr_subjects = array();
			
			while($candidate_qual_sbj->fetch())
			{
				if (!is_bool(array_search($candi_cNouSubjectId, $arr_subjects)))
				{
					continue;
				}


				$subject_condition = " AND a.cQualSubjectId = '$candi_cNouSubjectId'
				AND iQualGradeRank <= $candi_iGradeRank";
				
				
				//echo $cProgrammeId.','.$obtainable_comp_sub.','.$candi_cNouSubjectId.','.$candi_iGradeRank.','.$sReqmtId.','.$cEduCtgId_2.','.$subject_condition.'*<br>';

				// if ($cProgrammeId <> 'CMP301' && ((substr($cProgrammeId, 3, 1) == 3 && $iBeginLevel == 700) ||
				// ($cProgrammeId == 'MSC403' && $iBeginLevel == 800)))
				// {
				// 	$subject_condition = '';
				// }

				if ((substr($cProgrammeId, 3, 1) == 3 && $iBeginLevel == 700) ||
				($cProgrammeId == 'MSC403' && $iBeginLevel == 800))
				{
					$subject_condition = '';
				}
				

				$stmt_qual_sbj = $mysqli->prepare("SELECT vQualSubjectDesc, a.cQualSubjectId, mutual_ex, cQualGradeId, iQualGradeRank, cMandate
				FROM criteriasubject a, qualsubject b
				WHERE a.cQualSubjectId = b.cQualSubjectId 
				AND sReqmtId = '$sReqmtId'
				AND cProgrammeId  LIKE '%$cProgrammeId%'
				AND cEduCtgId = '$cEduCtgId_2'
				$subject_condition
				AND a.cDelFlag = 'N'");
				
				$stmt_qual_sbj->execute();
				$stmt_qual_sbj->store_result();
				if ($stmt_qual_sbj->num_rows > 0)
				{
					$stmt_qual_sbj->bind_result($vQualSubjectDesc, $cQualSubjectId, $mutual_ex, $cQualGradeId, $iQualGradeRank, $cMandate);
					$stmt_qual_sbj->fetch();
					
					if ($mutual_ex <> 0)
					{
						if (!is_bool(array_search($mutual_ex, $arr_track_mutual_ex)))
						{
							continue;
						}else
						{
							$x++;
							$arr_track_mutual_ex[$x] = $mutual_ex;
						}
					}

					$cnt++;
					$arr_subjects[$cnt] = $cQualSubjectId;

					if ($cMandate == 'C')
					{
						$obtained_comp_sub++;
					}else
					{
						$count_opt_cubject++;
					}

					//echo $vQualSubjectDesc.','.$cQualSubjectId.','.$mutual_ex.','.$cQualGradeId.','.$iQualGradeRank.','.$candi_iGradeRank.','.$cMandate.$expected_min_num_of_subject.','.'<br>';
				}
				//echo $count_opt_cubject.','.$expected_min_num_of_subject.','.$cProgrammeId.','.$iBeginLevel.',<br>';
				//if ($obtainable_comp_sub + $count_opt_cubject == $expected_min_num_of_subject)
				if ($obtainable_comp_sub == $obtained_comp_sub && $obtained_comp_sub + $count_opt_cubject >= $expected_min_num_of_subject)
				{
					if (is_bool(strpos($detail_of_seleted_prog_1, $cProgrammeId.' '.$iBeginLevel.' '.$sReqmtId)))
					{
						$detail_of_seleted_prog_1 .= $cProgrammeId.' '.$iBeginLevel.' '.$sReqmtId.'~';
					}
					//$ol_qualified = 1;
					break;
				}
			}
		}
		
		//echo $cProgrammeId.','.$obtainable_comp_sub.','.$count_opt_cubject.'<p>';
	}
	//echo $detail_of_seleted_prog_1.'<p>';
	
	return $detail_of_seleted_prog_1;
}






function get_qry_part($part, $faculty, $dept, $program, $level)
{
	$sReqmtId_qry = '';	
	$child_qry = '';
	$begin_level = '';
	
	
	if ($faculty == 'AGR')
	{
		//$child_qry = " AND (a.cProgrammeId = 'AGR201' OR a.cProgrammeId LIKE '%$program%') ";
		// if ($level >= 700)
		// {
		//     if ($dept == 'ENG')
		//     {
		//         $child_qry = " AND (a.cProgrammeId = 'ART201' OR a.cProgrammeId LIKE '%$program%') ";
		//     }else if ($dept == 'RST')
		//     {
		//         $child_qry = " AND (a.cProgrammeId LIKE '%ART208%' OR a.cProgrammeId LIKE '%ART209%' OR a.cProgrammeId LIKE '%ART210%' OR a.cProgrammeId LIKE '%$program%') ";
		//     }
		// }
	}else if ($faculty == 'ART')
	{
		if ($level >= 700)
		{
			if ($dept == 'LNG' || $dept == 'ENG')
			{
				$child_qry = " AND (a.cProgrammeId = 'ART204' OR a.cProgrammeId LIKE '%$program%') ";
			}else if ($dept == 'RST')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%ART202%' OR a.cProgrammeId LIKE '%$program%') ";
			}
		}              
	}else if ($faculty == 'EDU')
	{
		if ($level == 700)
		{
			$child_qry = " AND (a.cProgrammeId = 'EDU212' OR a.cProgrammeId LIKE '%$program%') ";
		}else if ($level > 700)
		{
			if ($dept == 'EFO')
			{
				$child_qry = " AND (a.cProgrammeId = 'EDU212' OR a.cProgrammeId LIKE '%$program%') ";
			}else  if ($dept == 'SED')
			{
				$child_qry = " AND (a.cProgrammeId = 'EDU212' OR a.cProgrammeId LIKE '%$program%') ";
			}else  if ($dept == 'MED')
			{                            
				$child_qry = " AND (a.cProgrammeId = 'EDU203' OR a.cProgrammeId LIKE '%EDU401%' OR a.cProgrammeId LIKE '%$program%') ";
				
			}
		}
	}else if ($faculty == 'HSC')
	{
		$begin_level = 200;
		if ($dept == 'EHS')
		{
			$child_qry = " AND (a.cProgrammeId LIKE '%$program%') ";

			if ($program == 'HSC201')
			{
				$sReqmtId_qry = " AND a.sReqmtId = 16";
				$child_qry = " AND (a.cProgrammeId = 'HSC201' OR a.cProgrammeId LIKE '%$program%') ";
			}                     
		}else if ($dept == 'PHE')
		{
			if ($level >= 700)
			{
				if ($program == 'HSC401')
			    {
			        $child_qry = " AND (a.cProgrammeId LIKE '%HSC203%' OR a.cProgrammeId = '$program') ";
			    }else
			    {
			        $child_qry = " AND (a.cProgrammeId LIKE '%HSC203%' OR a.cProgrammeId LIKE '%$program%') ";
			    }
			}
		}
	}else if ($faculty == 'MSC')
	{
		if ($level >= 700)
		{
			if ($dept == 'BUS')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%MSC201%' OR a.cProgrammeId LIKE '%$program%') ";
				if ($program == 'MSC301')
				{
					$child_qry = " AND (a.cProgrammeId LIKE '%$program%') ";
				}else if ($program == 'MSC401' || $program == 'MSC402' || $program == 'MSC408' || $program == 'MSC409' || $program == 'MSC410' || $program == 'MSC411' || $program == 'MSC412' || $program == 'MSC413')
				{
					$child_qry = " AND (a.cProgrammeId LIKE '%MSC203%' OR a.cProgrammeId LIKE '%$program%') ";
				}
			}else if ($dept == 'CPE')
			{
				if ($program == 'MSC415')
				{
					$child_qry = " AND (a.cProgrammeId = 'MSC215' OR a.cProgrammeId LIKE '%$program%') ";
				}else if ($program == 'MSC416')
				{
					$child_qry = " AND (a.cProgrammeId = 'MSC216' OR a.cProgrammeId LIKE '%$program%') ";
				}
			}else if ($dept == 'ENT')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%MSC209%' OR a.cProgrammeId LIKE '%$program%') ";
			}else if ($dept == 'PAD')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%MSC204%' OR a.cProgrammeId LIKE '%$program%') ";
			}
		}else
		{
			if ($dept == 'BUS')
			{
				//$child_qry = " AND (a.cProgrammeId LIKE '%MSC201%' OR a.cProgrammeId LIKE '%$program%') ";
			}else if ($dept == 'ENT')
			{
				//$child_qry = " AND (a.cProgrammeId LIKE '%MSC206%' OR a.cProgrammeId LIKE '%$program%') ";

				if ($program == "MSC204" || $program == "MSC205" /*&& $level == 100*/)
				{
					$cEduCtgId_2_qry = "b.cEduCtgId";

					//if ($level == 100)
					//{
						$ordering = "ORDER BY $cEduCtgId_2_qry  DESC, b.cMandate, c.vQualSubjectDesc";
					//}
				}
			}else if ($dept == 'PAD')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%$program%') ";
			}
		}
	}else if ($faculty == 'SCI')
	{
	    $child_qry = " AND (a.cProgrammeId LIKE '%$program%') ";
	}else if ($faculty == 'CMP')
	{
		$child_qry = " AND (a.cProgrammeId LIKE '%$program%') ";
	}else if ($faculty == 'SSC')
	{
		if ($level >= 700)
		{
			if ($dept == 'CSS')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%SSC201%' OR a.cProgrammeId LIKE '%$program%') ";
			}else  if ($dept == 'ECO')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%SSC201%' OR a.cProgrammeId LIKE '%$program%') ";
			}else  if ($dept == 'MAC')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%SSC207%' OR a.cProgrammeId LIKE '%$program%') ";
			}else  if ($dept == 'PCR')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%SSC208%' OR a.cProgrammeId LIKE '%$program%') ";
			}
		}else
		{
			if ($dept == 'CSS')
			{
				$child_qry = " AND (a.cProgrammeId LIKE '%SSC211%' OR a.cProgrammeId LIKE '%$program%') ";
			}else  if ($dept == 'ECO')
			{
				//$child_qry = " AND (a.cProgrammeId LIKE '%SSC201%' OR a.cProgrammeId LIKE '%$program%') ";
			}else  if ($dept == 'MAC')
			{
				// if ($level >= 700)
				// {
				//     $child_qry = " AND (a.cProgrammeId LIKE '%SSC204%' OR a.cProgrammeId LIKE '%$program%') ";
				// }
			}
		}
	}else if ($faculty == 'LAW')
	{
		$child_qry = " AND (a.cProgrammeId LIKE '%LAW201%' OR a.cProgrammeId LIKE '%$program%') ";
		if ($dept == 'LED')
		{
			$child_qry = " AND (a.cProgrammeId LIKE '%LAW202%' OR a.cProgrammeId LIKE '%$program%') ";
		}
	}

	if ($part == 0)
	{
		return $sReqmtId_qry;
	}else if ($part == 1)
	{
		return $child_qry;
	}else if ($part == 2)
	{
		return $begin_level;
	}
}


function begin_end_level($limit)
{
	if (isset($_REQUEST["level_options"]))
	{
		$t1 = 0; $t2 = 0;
		if (substr($_REQUEST["level_options"],0,3) == 'PGD')
		{
			$t1 = 700;
			$t2 = 700;
		}else if (substr($_REQUEST["level_options"],0,1) == 'M' || substr($_REQUEST["level_options"],0,6) == 'Common' || substr($_REQUEST["level_options"],0,3) == 'LLM')
		{
			$t1 = 800;
			$t2 = 800;
		}else if (substr($_REQUEST["level_options"],0,1) == 'B')
		{
			$t1 = 100;
			$t2 = 300;
			
			if ($_REQUEST['cFacultyIdold07'] == 'EDU' || $_REQUEST["cprogrammeIdold"] == 'ART2')
			{                                                
				$t1 = 100;
				$t2 = 200;
			}else if ($_REQUEST['cFacultyIdold07'] == 'HSC')
			{
				if ($_REQUEST["cprogrammeIdold"] == 'HSC201' || $_REQUEST["cprogrammeIdold"] == 'HSC202' || $_REQUEST["cprogrammeIdold"] == 'HSC204' || $_REQUEST["cprogrammeIdold"] == 'HSC205')
				{
					$t1 = 200;
					$t2 = 200;
				}
			}else if ($_REQUEST['cFacultyIdold07'] == 'MSC')
			{
				if ($_REQUEST["cprogrammeIdold"] == 'MSC207')
				{
					$t1 = 100;
					$t2 = 300;
				}
			}else if ($_REQUEST['cFacultyIdold07'] == 'SCI')
			{
				if ($_REQUEST["cprogrammeIdold"] == 'SCI204' || $_REQUEST["cprogrammeIdold"] == 'SCI207' || $_REQUEST["cprogrammeIdold"] == 'SCI210')
				{
					$t1 = 100;
					$t2 = 200;
				}else if ($_REQUEST["cprogrammeIdold"] == 'SCI209')
				{
					$t1 = 100;
					$t2 = 300;
				} 
			}else if ($_REQUEST['cFacultyIdold07'] == 'SSC')
			{
				if ($_REQUEST["cprogrammeIdold"] == 'SSC205' || $_REQUEST["cprogrammeIdold"] == 'SSC206' || $_REQUEST["cprogrammeIdold"] == 'SSC201' || $_REQUEST["cprogrammeIdold"] == 'SSC209')
				{
					$t1 = 100;
					$t2 = 200;
				}
			}
		}else if (substr($_REQUEST["level_options"],0,1) == 'Phi')
		{
			$t1 = 900;
			$t2 = 900;
		}else 
		{
			$t1 = 1000;
			$t2 = 1000;
		}

		if ($limit == 0){return $t1;}
		if ($limit == 1){return $t2;}
	}

	return 0;
}


function check_higher_level_qual($level, $child_qry, $cProgrammeId)
{
	$mysqli = link_connect_db();
	
	$expected_min_num_of_subject = 0;
	$detail_of_seleted_prog_1 = '';

	$stmt = $mysqli->prepare("SELECT cEduCtgId_1, cEduCtgId_2, a.sReqmtId, c.vQualSubjectDesc, c.cQualSubjectId, b.cMandate, b.mutual_ex, b.cQualGradeId, b.iQualGradeRank, a.iBeginLevel
	FROM criteriadetail a, criteriasubject b, qualsubject c
	WHERE a.cCriteriaId = b.cCriteriaId
	AND a.cProgrammeId = b.cProgrammeId
	AND a.sReqmtId = b.sReqmtId
	AND b.cQualSubjectId = c.cQualSubjectId
	AND a.cDelFlag = 'N'
	AND b.cDelFlag = 'N'
	$child_qry
	AND cEduCtgId_2 <> ''
	AND a.cProgrammeId = '$cProgrammeId'
	AND a.iBeginLevel = $level
	ORDER BY a.sReqmtId DESC, b.cMandate");
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cEduCtgId_1, $cEduCtgId_2, $sReqmtId, $vQualSubjectDesc, $cQualSubjectId, $cMandate, $mutual_ex, $cQualGradeId, $iQualGradeRank, $iBeginLevel);
	
	$cnt = 0;
	$number_of_compusl_sbj_found = 0;
	$compulsory_subjects_with_low_graded = '';

	$compulsory_subjects_not_found = '';
	$available_comp_sbj = 0;

	$number_of_optional_sbj_found = 0;
	$alt_no = '';

	$mutual_ex_comp_list = '';

	$prev_cEduCtgId_2 = '';
	
	while($stmt->fetch())		
	{
		if ($prev_cEduCtgId_2 <> '' && $prev_cEduCtgId_2 <> $cEduCtgId_2)
		{
			$available_comp_sbj = 0;
			$number_of_optional_sbj_found = 0;
		}
		
		if ($level >= 700 || $cEduCtgId_2 == 'ELZ' || $cEduCtgId_2 == 'PSX' || $cEduCtgId_2 == 'PSZ' || $cEduCtgId_2 == 'PGX' || $cEduCtgId_2 == 'PGY' || $cEduCtgId_2 == 'PRX' || $cEduCtgId_2 == 'PGZ')
		{
			$expected_min_num_of_subject = 1;
		}else
		{
			$expected_min_num_of_subject = 2;
		}

		
		//echo ++$cnt.' '.$cEduCtgId_1.', '.$cEduCtgId_2.', '.$sReqmtId.', '.$vQualSubjectDesc.', '.$cQualSubjectId.', '.$cMandate.', '.$mutual_ex.', '.$cQualGradeId.', '.$iQualGradeRank.', '.$iBeginLevel.'<br>';

		if ($cMandate == 'C')
		{
			if ($mutual_ex <> 0)
			{
				if (is_bool(strpos($mutual_ex_comp_list, $mutual_ex)))
				{
					$mutual_ex_comp_list .= $mutual_ex.',';
					$available_comp_sbj++;
				}
			}else
			{
				$available_comp_sbj++;
			}
		}


		$candi_cNouSubjectId = '';
		$candi_iGradeRank = '';
		$cQualGradeCode = '';

		$sub_qry = " AND a.cEduCtgId = '$cEduCtgId_2'";

		$stmt_chk_cand_c_sbjts_1 = $mysqli->prepare("SELECT cNouSubjectId, a.iGradeRank, b.cQualGradeCode
		FROM afnqualsubject a, qualgrade b
		WHERE vApplicationNo = ?
		AND a.cNouGradeId = b.cQualGradeId
		$sub_qry
		AND cNouSubjectId = '$cQualSubjectId'");
		$stmt_chk_cand_c_sbjts_1->bind_param("s", $_REQUEST['vApplicationNo']);
		$stmt_chk_cand_c_sbjts_1->execute();
		$stmt_chk_cand_c_sbjts_1->store_result();
		$stmt_chk_cand_c_sbjts_1->bind_result($candi_cNouSubjectId, $candi_iGradeRank, $cQualGradeCode);
		$stmt_chk_cand_c_sbjts_1->fetch();
		$stmt_chk_cand_c_sbjts_1->close();
		
		//if applicant does not have qual
		if ($cMandate == 'C')
		{
			if ($candi_cNouSubjectId == '')
			{
				$compulsory_subjects_not_found .= $vQualSubjectDesc.', ';
				if ($mutual_ex == 0)
				{
					continue;
				}
			}else if ($candi_iGradeRank < $iQualGradeRank)
			{
				$compulsory_subjects_with_low_graded .= $vQualSubjectDesc.', ';
			}
		}

		if ($candi_cNouSubjectId <> '' && $candi_iGradeRank >= $iQualGradeRank)
		{
			if ($cMandate == 'C')
			{
				if ($mutual_ex <> 0)
				{							
					if (is_bool(strpos($alt_no, $mutual_ex)))
					{
						$alt_no .= $mutual_ex;
						$number_of_compusl_sbj_found++;

						//$cand_cbj_list .= $vQualSubjectDesc.', ';
					}
				}else
				{
					$number_of_compusl_sbj_found++;

					//$cand_cbj_list .= $vQualSubjectDesc.', ';
				}
			}else
			{
				if ($mutual_ex <> 0)
				{
					if (is_bool(strpos($alt_no, $mutual_ex)))
					{
						$alt_no .= $mutual_ex;
						$number_of_optional_sbj_found++;
					}
				}else
				{
					$number_of_optional_sbj_found++;
				}
			}
		}

		if ($available_comp_sbj > 0)
		{
			if ($number_of_compusl_sbj_found == $available_comp_sbj && 
			($number_of_optional_sbj_found + $number_of_compusl_sbj_found) >= $expected_min_num_of_subject)
			{
				if ($iBeginLevel == 100 && substr($cProgrammeId,0,3) == 'HSC')
				{
					if (is_bool(strpos($detail_of_seleted_prog_1, $sReqmtId.'200'.$cProgrammeId)))
					{
						$detail_of_seleted_prog_1 .= $sReqmtId.'200'.$cProgrammeId.'~';
					}							
				}else
				{
					if (is_bool(strpos($detail_of_seleted_prog_1, $cProgrammeId.' '.$iBeginLevel.' '.$sReqmtId)))
					{
						$detail_of_seleted_prog_1 .= $cProgrammeId.' '.$iBeginLevel.' '.$sReqmtId.'~';
					}							
					//echo $cProgrammeId.' '.$iBeginLevel.' '.$sReqmtId.'~'.'<br>';
				}

				break;
			}
		}else
		{
			if ($number_of_optional_sbj_found >= $expected_min_num_of_subject)
			{
				if ($iBeginLevel == 100 && substr($cProgrammeId,0,3) == 'HSC')
				{
					if (is_bool(strpos($detail_of_seleted_prog_1, $sReqmtId.'200'.$cProgrammeId)))
					{
						$detail_of_seleted_prog_1 .= $sReqmtId.'200'.$cProgrammeId.'~';
					}
				}else
				{
					if (is_bool(strpos($detail_of_seleted_prog_1, $cProgrammeId.' '.$iBeginLevel.' '.$sReqmtId)))
					{
						$detail_of_seleted_prog_1 .= $cProgrammeId.' '.$iBeginLevel.' '.$sReqmtId.'~';
					}
					//echo $cProgrammeId.' '.$iBeginLevel.' '.$sReqmtId.'~'.'<br>';
				}

				break;
			}
		}
		$prev_cEduCtgId_2 = $cEduCtgId_2;
	}
	$stmt->close();

	

	if ($detail_of_seleted_prog_1 == '')
	{
		//return "Lacks higher qualification";
	}else
	{
		return $detail_of_seleted_prog_1;
	}
}


function assign_matno()
{
	$mysqli = link_connect_db();
	$orgsetins = settns();
	$adm_session = substr($orgsetins['cAcademicDesc'],2,2);

	// $stmt = $mysqli->prepare("SELECT cSbmtd FROM prog_choice WHERE vApplicationNo = ?");
	// $stmt->bind_param("s", $_REQUEST['vApplicationNo']);
	// $stmt->execute();
	// $stmt->store_result();
    // $stmt->bind_result($cSbmtd);
    // $stmt->fetch();
    
    // $cSbmtd = $cSbmtd ?? '';
    
    // if ($cSbmtd == 0)
    // {
    //     //return;
    // }

	// $stmt = $mysqli->prepare("select vMatricNo from afnmatric where vApplicationNo = ?");
	// $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]); 
	// $stmt->execute();
	// $stmt->store_result();
	// $stmt->bind_result($vMatricNo);
	// $stmt->fetch();
	// $vMatricNo = $vMatricNo ?? '';
	// if ($vMatricNo <> '')
	// {
	// 	//return;
	// }
		

	/*$rs_grad_record = 0;
    	$stmt = $mysqli->prepare("SELECT * FROM s_m_t_grad_mat_list WHERE vMatricNo LIKE '%$sied%';");
    	$stmt->execute();
    	$stmt->store_result();
		$rs_grad_record = $stmt->num_rows; */
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
		if ($stmt->num_rows == 0 && $rs_client_record == 0 && $rs_grad_record == 0 && $rs_student_record == 0)
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
    					$stmt1->bind_param("s",$vApplicationNo);
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
    					$stmt1->bind_param("s",$vApplicationNo);
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
	
	if ($_REQUEST["cdeptold7_1st"] == 'CPE')
	{
		$conr_matno = 'COL'.substr($conr_matno,3,9);
	}

	//create new student account
	$sqlins_matno = "INSERT IGNORE INTO rs_client SET
	vMatricNo = '$conr_matno',
	vPassword = 'frsh'";
	if (!mysqli_query(link_connect_db(), $sqlins_matno)){die('Error inserting ' . mysqli_error(link_connect_db()));}
	
	$stmt = $mysqli->prepare("INSERT IGNORE INTO afnmatric SET
	vApplicationNo = ?,
	ikeyMatric = '0',
	vMatricNo = '$conr_matno',
	dtStatusDate = now()");
	$stmt->bind_param("s",$_REQUEST['vApplicationNo']);
	$stmt->execute();
	
	$stmt = $mysqli->prepare("UPDATE prog_choice SET
	cSbmtd = '1' 
	WHERE cSbmtd <> '2' 
	AND vApplicationNo = ?");
	$stmt->bind_param("s", $_REQUEST['vApplicationNo']);
	$stmt->execute();
	
	$stmt->close();
	
	log_actv('submitted application form');

	return $conr_matno;
}


function assign_matno00($grad_matno)
{
	//
	$snt_no = 1;
	
	// if (!is_bool(strpos($grad_matno,"_")))
	// {
		$sn_no = substr($grad_matno, strlen($grad_matno)-1,1);
	// }



	$old_prog_mat = $_REQUEST['first_prog'] .'_'.$snt_no;

	//archive mat no of prev prog
	$stmt = $mysqli->prepare("UPDATE afnmatric SET
	vMatricNo = ?,
	WHERE vMatricNo = ?");
	$stmt->bind_param("ss",$old_prog_mat, $_REQUEST['first_prog']);
	$stmt->execute();

	//insert record with first_prog mat. no. for new prog
	$stmt = $mysqli->prepare("INSERT IGNORE INTO afnmatric SET
	vApplicationNo = ?,
	ikeyMatric = '0',
	vMatricNo = ?,
	dtStatusDate = now()");
	$stmt->bind_param("ss",$_REQUEST['vApplicationNo'], $_REQUEST['first_prog']);
	$stmt->execute();

	//check whether login credential is et up for mat no for new prog.
	$stmt = $mysqli->prepare("SELECT * FROM rs_client WHERE vMatricNo = ?");
	$stmt->bind_param("s",$_REQUEST['first_prog']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows == 0)
	{
		$stmt_1 = $mysqli->prepare("INSERT INTO rs_client SET
		vMatricNo = ?,
		vPassword = 'frsh'");
		$stmt_1->bind_param("s", $_REQUEST['first_prog']);
		$stmt_1->execute();
		$stmt_1->close();
	}

	$stmt = $mysqli->prepare("UPDATE prog_choice SET
	cSbmtd = '1' 
	WHERE cSbmtd <> '2' 
	AND vApplicationNo = ?");
	$stmt->bind_param("s", $_REQUEST['vApplicationNo']);
	$stmt->execute();
	$stmt->close();

	$stmt->close();

	log_actv('submitted application form');
}


function assign_matno_cert()
{
	$mysqli = link_connect_db();
	
	$mat = "NOU0".$_REQUEST['vApplicationNo'];
	
	try
	{
		$mysqli->autocommit(FALSE); //turn on transactions

		$stmt = $mysqli->prepare("INSERT IGNORE INTO afnmatric SET
		vApplicationNo = ?,
		ikeyMatric = 0,
		vMatricNo = ?,
		dtStatusDate = now()");
		$stmt->bind_param("ss",$_REQUEST['vApplicationNo'], $mat);
		$stmt->execute();

		$stmt = $mysqli->prepare("UPDATE prog_choice SET
		cSbmtd = '1' 
		WHERE cSbmtd <> '2' 
		AND vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST['vApplicationNo']);
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


function assign_matno_cert_chd()
{
	$mysqli = link_connect_db();

	$stmt = $mysqli->prepare("SELECT a.cProgrammeId, a.cEduCtgId, cdeptId 
	FROM prog_choice a, programme b
	WHERE a.cProgrammeId = b.cProgrammeId
	AND vApplicationNo = ?");
	$stmt->bind_param("s", $_REQUEST['vApplicationNo']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cProgrammeId, $cEduCtgId, $cdeptId);
	$stmt->fetch();

	$currentyear = date("y");

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
	
	try
	{
		$mysqli->autocommit(FALSE); //turn on transactions

		$stmt = $mysqli->prepare("INSERT IGNORE INTO afnmatric SET
		vApplicationNo = ?,
		ikeyMatric = 0,
		vMatricNo = ?,
		dtStatusDate = now()");
		$stmt->bind_param("ss",$_REQUEST['vApplicationNo'], $mat);
		$stmt->execute();

		$stmt = $mysqli->prepare("UPDATE prog_choice SET
		cSbmtd = '1' 
		WHERE cSbmtd <> '2' 
		AND vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST['vApplicationNo']);
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


function valid_stfn()
{
    $mysqli = link_connect_db();
    
    $stmt_a = $mysqli->prepare("SELECT vApplicationNo FROM userlogin WHERE vApplicationNo = ?");
    $stmt_a->bind_param("s", $_REQUEST['vApplicationNo']);
    $stmt_a->execute();
    $stmt_a->store_result();
    return $stmt_a->num_rows;
}


function valid_stfn_role()
{
    $mysqli = link_connect_db();
    
    $stmt_a = $mysqli->prepare("SELECT * FROM role_user WHERE vUserId = ?");
    $stmt_a->bind_param("s", $_REQUEST['vApplicationNo']);
    $stmt_a->execute();
    $stmt_a->store_result();
    return $stmt_a->num_rows;
}


function valid_stfn_center()
{
    $mysqli = link_connect_db();
    
    $stmt_a = $mysqli->prepare("SELECT * FROM user_centre WHERE vApplicationNo = ?");
    $stmt_a->bind_param("s", $_REQUEST['vApplicationNo']);
    $stmt_a->execute();
    $stmt_a->store_result();
    return $stmt_a->num_rows;
}


function send_token($purpose)
{
    if (!isset($_REQUEST['user_cat']))
	{
		return 'User category';
	}
	
	include('../../PHPMailer/mail_con.php');
	
	$mysqli = link_connect_db();

	
    date_default_timezone_set('Africa/Lagos');
	$date2 = date("Y-m-d");
	$date2_0 = date("Y-m-d H:i:s");
	
	// $stmt = $mysqli->prepare("SELECT send_time, vtoken FROM veri_token
	// WHERE vApplicationNo = ?
	// AND cused = '0'
	// AND purpose = ?
	// ORDER BY send_time DESC");

	$stmt = $mysqli->prepare("SELECT ABS(TIMESTAMPDIFF(MINUTE,send_time,'$date2_0')), send_time, vtoken FROM veri_token
	WHERE vApplicationNo = ?
	AND cused = '0'
	AND LEFT(send_time,10) = '$date2'
	AND purpose = ?
	ORDER BY send_time DESC LIMIT 1");

	$stmt->bind_param("ss",$_REQUEST["vApplicationNo"], $purpose);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($minutes, $send_time, $token);
	$stmt->fetch();
	
	if (is_null($minutes))
	{
		$minutes = 0;
	}
				
    if ($minutes > 15 || $stmt->num_rows() == 0)
	{		
		$token = openssl_random_pseudo_bytes(3);
		$token = bin2hex($token);
	}
	$stmt->close();

	$source_table = '';
	$source_table2 = '';
	$val_field = '';

	if ($_REQUEST['user_cat'] == '4')
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
	}else if ($_REQUEST['user_cat'] == '3' || $_REQUEST['user_cat'] == '1')
	{
		$val_field = $_REQUEST['vApplicationNo'];
		$source_table = 'prog_choice';
	}else if ($_REQUEST['user_cat'] <> '5')
	{
		$val_field = $_REQUEST['vApplicationNo'];
		$source_table = 'userlogin';
	}
			
	if ($_REQUEST['user_cat'] == '4')
	{
		$stmt_1 = $mysqli->prepare("SELECT a.vFirstName, vEMailId
		FROM $source_table a, $source_table2 b
		WHERE a.vApplicationNo = b.vApplicationNo
		AND a.vApplicationNo = ?");
	}else
	{
		if ($_REQUEST['user_cat'] == '6')
		{
			$stmt_1 = $mysqli->prepare("SELECT vFirstName, cemail
			FROM $source_table
			WHERE vApplicationNo = ?");
		}else if ($_REQUEST['user_cat'] <> '5')
		{
			$stmt_1 = $mysqli->prepare("SELECT vFirstName, vEMailId
			FROM $source_table
			WHERE vApplicationNo = ?");
		}
	}
	
	if (isset($stmt_1))
	{
    	$stmt_1->bind_param("s", $val_field);
    	$stmt_1->execute();
    	$stmt_1->store_result();
    	$stmt_1->bind_result($vFirstName, $vEMailId);
    	$stmt_1->fetch();
    	$stmt_1->close();
	    
		if (is_null($vEMailId))
	    {
			$vEMailId = '';
		}
	}else if ($_REQUEST['user_cat'] == '5')
    {
        if (isset($_REQUEST['vMatricNo']))
		{
			$vEMailId = strtolower($_REQUEST['vMatricNo']).'@noun.edu.ng';
		    $val_field = $_REQUEST['vMatricNo'];

			$stmt_1 = $mysqli->prepare("SELECT *
			FROM afnmatric
			WHERE cmail_req = '1'
			AND vMatricNo = ?");
			$stmt_1->bind_param("s", $val_field);
        	$stmt_1->execute();
        	$stmt_1->store_result();
        	$email_address_ready = $stmt_1->num_rows;

			if ($email_address_ready == '0')
			{
				$stmt_1->close();
				echo 'eMail address error';
				exit;
			}
		    
		    $stmt_1 = $mysqli->prepare("SELECT vFirstName
			FROM s_m_t
			WHERE vMatricNo = ?");
			$stmt_1->bind_param("s", $val_field);
        	$stmt_1->execute();
        	$stmt_1->store_result();
        	$stmt_1->bind_result($vFirstName);
        	$stmt_1->fetch();
		}
    }
	
	//$vEMailId = 'aadeboyejo@noun.edu.ng';

	$subject = 'NOUN - Token for '.$purpose;
	$mail_msg = "Dear $vFirstName,<br><br>
	Copy the token below and paste it in the corresponding box on the '$purpose' page.
	<p><b>$token</b> 
	<p>The token expires in 15 minutes
	<p><i>Please do not reply this mail</i>
	<p>Thank you";

	$mail_msg = wordwrap($mail_msg, 70);
	$mail->addAddress($vEMailId, $vFirstName); // Add a recipient
	$mail->Subject = $subject;
	$mail->Body = $mail_msg;
	try
	{
		$mail->send();
	}catch(Exception $e) 
	{
		echo 'eMail address error';
		exit;
	}

	//for ($incr = 1; $incr <= 5; $incr++)
	//{
	try
	{
		//if ($mail->send())
		//{
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
			
			
			date_default_timezone_set('Africa/Lagos');
			$date2 = date("Y-m-d h:i:s");
			
			//try
			//{
				//$mysqli->autocommit(FALSE); //turn on transactions

				$stmt = $mysqli->prepare("INSERT INTO veri_token SET
				vApplicationNo = ?,
				vtoken = '$token',
				send_time = '$date2',
				purpose = ?");
				$stmt->bind_param("ss", $val_field, $purpose); 
				$stmt->execute();
				
				$stmt = $mysqli->prepare("INSERT INTO atv_log SET 
				vApplicationNo  = ?,
				vDeed = 'sent a token for $purpose to $vEMailId',
				act_location = ?,
				tDeedTime = '$date2'");
				$stmt->bind_param("ss", $val_field, $ipee);
				$stmt->execute();
				$stmt->close();

			// 	$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
			// }catch(Exception $e) 
			// {
			// 	$mysqli->rollback(); //remove all queries from queue if error (undo)
			// 	throw $e;
			// }

			//break;
		//}
	}catch(Exception $e) 
	{
		echo 'Token not sent';
		exit;
	}
	//}

	return $token;
}


function validate_token($user_name, $purpose)
{
	$mysqli = link_connect_db();
	
    date_default_timezone_set('Africa/Lagos');
    $date2_0 = date("Y-m-d h:i:s");
    $date2 = date("Y-m-d");
	
	$stmt = $mysqli->prepare("SELECT ABS(TIMESTAMPDIFF(MINUTE,send_time,'$date2_0')) FROM veri_token
	WHERE vApplicationNo = ?
	AND cused = '0'
	AND LEFT(send_time,10) = '$date2'
    AND vtoken = ?
	AND purpose = ?
	ORDER BY send_time DESC LIMIT 1");

	// $stmt = $mysqli->prepare("SELECT send_time, vtoken FROM veri_token
	// WHERE vApplicationNo = ?
	// AND cused = '0'
    // AND vtoken = ?
	// AND purpose = ?");
	$stmt->bind_param("sss",$user_name, $_REQUEST["user_token"], $purpose);
	$stmt->execute();
	$stmt->store_result();
		
    if ($stmt->num_rows == 0)
    {
        echo 'Invalid token';exit;
    }
	
	$stmt->bind_result($minutes);
	$stmt->fetch();
	
	/*$$send_time = $send_time ?? '';
		
	date1 = strtotime($send_time);
    
    $diff = abs($date2 - $date1);
    $years = floor($diff / (365*60*60*24));
    
    $months = floor(($diff - $years * 365*60*60*24)
								/ (30*60*60*24));
    
    $days = floor(($diff - $years * 365*60*60*24 -
			$months*30*60*60*24)/ (60*60*24));
	
	$hours = floor(($diff - $years * 365*60*60*24
		- $months*30*60*60*24 - $days*60*60*24)
									/ (60*60));
									
    $minutes = floor(($diff - $years * 365*60*60*24
		- $months*30*60*60*24 - $days*60*60*24
							- $hours*60*60)/ 60);*/
	
    if ($minutes > 20)
    {
        echo 'Token has expired. You may click the resend button to get another token';exit;
    }
    
    // date_default_timezone_set('Africa/Lagos');
    // $date2 = date("Y-m-d h:i:s");

    $stmt = $mysqli->prepare("UPDATE veri_token SET cused = 1, used_time = '$date2_0', purpose = ? WHERE vApplicationNo = ? AND vtoken = ?");
    $stmt->bind_param("sss", $purpose, $user_name, $_REQUEST["user_token"]); 
    $stmt->execute();
    $stmt->close();
    
    log_actv('Used token : '.$_REQUEST["user_token"]);
    echo 'Token valid';
}


function do_service_mode_centre($v_which, $id)
{
	$mysqli = link_connect_db();

	$trg = '|';
	$num_of = 0;
	if ($v_which == '1')
	{
		$stmt = $mysqli->prepare("SELECT study_mode_ID
		FROM user_mode 
		WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->store_result();
		$num_of = $stmt->num_rows;
		$stmt->bind_result($study_mode_ID);
		while ($stmt->fetch())
		{
			$trg .= $study_mode_ID.'|';
		}
		$stmt->close();
	}else if ($v_which == '2')
	{
		$stmt = $mysqli->prepare("SELECT cStudyCenterId
		FROM user_centre 
		WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->store_result();
		$num_of = $stmt->num_rows;
		$stmt->bind_result($cStudyCenterId);
		while ($stmt->fetch())
		{
			$trg .= $cStudyCenterId.'|';
		}
		$stmt->close();
	}
		
	return str_pad($num_of, 10).$trg;
}



function move_pp_out_of_root($vmask, $cFacultyId)
{
	if (is_null($cFacultyId) || $cFacultyId == '')
	{
		return;
	}
	
	//move jpeg passport pics out of pub folder
	$search_file_name = BASE_FILE_NAME_FOR_PP."p_".$vmask.".jpg";
	$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/pp/p_".$vmask.".jpg";
	
	if(file_exists($search_file_name))
	{
		if (copy($search_file_name, $pix_file_name))
		{
			@unlink($search_file_name);
		}
		return;
	}else
	{
		$search_file_name = BASE_FILE_NAME_FOR_PP.strtolower($_REQUEST['old_faculty'])."/pp/p_".$vmask.".jpg";
		if(file_exists($search_file_name))
		{                    
			if (copy($search_file_name, $pix_file_name))
			{
				@unlink($search_file_name);
			}
			return;
		}
	}

	$search_file_name = BASE_FILE_NAME_FOR_PP."p_".$vmask.".jpeg";
	$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/pp/p_".$vmask.".jpeg";
	
	if(file_exists($search_file_name))
	{
		if (copy($search_file_name, $pix_file_name))
		{
			@unlink($search_file_name);
		}
		return;
	}else
	{
		$search_file_name = BASE_FILE_NAME_FOR_PP.strtolower($_REQUEST['old_faculty'])."/pp/p_".$vmask.".jpeg";
		if(file_exists($search_file_name))
		{                    
			if (copy($search_file_name, $pix_file_name))
			{
				@unlink($search_file_name);
			}
			return;
		}
	}

	
	//move passport png pics out of pub folder
	$search_file_name = BASE_FILE_NAME_FOR_PP."p_".$vmask.".png";
	$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/pp/p_".$vmask.".png";
	
	if(file_exists($search_file_name))
	{                    
		if (copy($search_file_name, $pix_file_name))
		{
			@unlink($search_file_name);
		}
		return;
	}else
	{
		$search_file_name = BASE_FILE_NAME_FOR_PP.strtolower($_REQUEST['old_faculty'])."/pp/p_".$vmask.".png";
		if(file_exists($search_file_name))
		{                    
			if (copy($search_file_name, $pix_file_name))
			{
				@unlink($search_file_name);
			}
			return;
		}
	}
}


function move_pp_into_root($cFacultyId)
{
	$mysqli = link_connect_db();

	 //relocate img file
	$vmask = '';
	
	$stmt_last = $mysqli->prepare("SELECT trim(vmask) FROM pics WHERE vApplicationNo  = ? and cinfo_type = 'p'");
	$stmt_last->bind_param("s", $_REQUEST["vApplicationNo"]);
	$stmt_last->execute();
	$stmt_last->store_result();
	if ($stmt_last->num_rows > 0)
	{
		$stmt_last->bind_result($vmask);
		$stmt_last->fetch();
	}
	$stmt_last->close();
	
	//move jpeg passport pics out of pub folder
	$search_file_name = BASE_FILE_NAME_FOR_PP."p_".$vmask.".jpg";
	$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/pp/p_".$vmask.".jpg";
	
	if(file_exists($pix_file_name))
	{                    
		if (copy($pix_file_name, $search_file_name))
		{
			@unlink($pix_file_name);
		}
	}else
	{
		$search_file_name = BASE_FILE_NAME_FOR_PP.strtolower($_REQUEST['old_faculty'])."/pp/p_".$vmask.".jpg";
		if(file_exists($pix_file_name))
		{                    
			if (copy($pix_file_name, $search_file_name))
			{
				@unlink($pix_file_name);
			}
		}
	}

	
	$search_file_name = BASE_FILE_NAME_FOR_PP."p_".$vmask.".jpeg";
	$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/pp/p_".$vmask.".jpeg";
	
	if(file_exists($pix_file_name))
	{                    
		if (copy($pix_file_name, $search_file_name))
		{
			@unlink($pix_file_name);
		}
	}else
	{
		$search_file_name = BASE_FILE_NAME_FOR_PP.strtolower($_REQUEST['old_faculty'])."/pp/p_".$vmask.".jpeg";
		if(file_exists($pix_file_name))
		{                    
			if (copy($pix_file_name, $search_file_name))
			{
				@unlink($pix_file_name);
			}
		}
	}

	
	$search_file_name = BASE_FILE_NAME_FOR_PP."p_".$vmask.".pjpeg";
	$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/pp/p_".$vmask.".pjpeg";
	
	if(file_exists($pix_file_name))
	{                    
		if (copy($pix_file_name, $search_file_name))
		{
			@unlink($pix_file_name);
		}
	}else
	{
		$search_file_name = BASE_FILE_NAME_FOR_PP.strtolower($_REQUEST['old_faculty'])."/pp/p_".$vmask.".pjpeg";
		if(file_exists($pix_file_name))
		{                    
			if (copy($pix_file_name, $search_file_name))
			{
				@unlink($pix_file_name);
			}
		}
	}



	
	$search_file_name = BASE_FILE_NAME_FOR_PP."p_".$vmask.".png";
	$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/pp/p_".$vmask.".png";
	
	if(file_exists($pix_file_name))
	{                    
		if (copy($pix_file_name, $search_file_name))
		{
			@unlink($pix_file_name);
		}
	}else
	{
		$search_file_name = BASE_FILE_NAME_FOR_PP.strtolower($_REQUEST['old_faculty'])."/pp/p_".$vmask.".png";
		if(file_exists($pix_file_name))
		{                    
			if (copy($pix_file_name, $search_file_name))
			{
				@unlink($pix_file_name);
			}
		}
	}
}


function move_cc_out_of_root($cFacultyId)
{	
	if (is_null($cFacultyId) || $cFacultyId == '')
	{
		return;
	}
	
	$mysqli = link_connect_db();

	$stmt_a = $mysqli->prepare("SELECT vmask, cQualCodeId, vExamNo FROM pics WHERE vApplicationNo = ? and cinfo_type = 'C'");
	$stmt_a->bind_param("s", $_REQUEST["vApplicationNo"]);
	$stmt_a->execute();
	$stmt_a->store_result();
	$stmt_a->bind_result($vmask, $cQualCodeId, $vExamNo);

	while($stmt_a->fetch())
	{
		$search_file_name = BASE_FILE_NAME_FOR_PP.$cQualCodeId."_".$vExamNo."_".$vmask.".jpg";
		$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/cc/".$cQualCodeId."_".$vExamNo."_".$vmask.".jpg";

		if(file_exists($search_file_name))
		{
			if (copy($search_file_name, $pix_file_name))
			{
				@unlink($search_file_name);
			}
			chmod($pix_file_name, 0644);
		}else
		{
			$search_file_name = BASE_FILE_NAME_FOR_PP.strtolower($_REQUEST['old_faculty'])."/cc/".$cQualCodeId."_".$vExamNo."_".$vmask.".jpg";
			if(file_exists($search_file_name))
			{
				if (copy($search_file_name, $pix_file_name))
				{
					@unlink($search_file_name);
				}
				chmod($pix_file_name, 0644);
			}
		}

		$search_file_name = BASE_FILE_NAME_FOR_PP.$cQualCodeId."_".$vExamNo."_".$vmask.".jpeg";
		$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/cc/".$cQualCodeId."_".$vExamNo."_".$vmask.".jpeg";

		if(file_exists($search_file_name))
		{
			if (copy($search_file_name, $pix_file_name))
			{
				@unlink($search_file_name);
			}
			chmod($pix_file_name, 0644);
		}else
		{
			$search_file_name = BASE_FILE_NAME_FOR_PP.strtolower($_REQUEST['old_faculty'])."/cc/".$cQualCodeId."_".$vExamNo."_".$vmask.".jpeg";
			if(file_exists($search_file_name))
			{
				if (copy($search_file_name, $pix_file_name))
				{
					@unlink($search_file_name);
				}
				chmod($pix_file_name, 0644);
			}
		}

		$search_file_name = BASE_FILE_NAME_FOR_PP.$cQualCodeId."_".$vExamNo."_".$vmask.".pjpeg";
		$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/cc/".$cQualCodeId."_".$vExamNo."_".$vmask.".pjpeg";

		if(file_exists($search_file_name))
		{
			if (copy($search_file_name, $pix_file_name))
			{
				@unlink($search_file_name);
			}
			chmod($pix_file_name, 0644);
		}else
		{
			$search_file_name = BASE_FILE_NAME_FOR_PP.strtolower($_REQUEST['old_faculty'])."/cc/".$cQualCodeId."_".$vExamNo."_".$vmask.".pjpeg";
			if(file_exists($search_file_name))
			{
				if (copy($search_file_name, $pix_file_name))
				{
					@unlink($search_file_name);
				}
				chmod($pix_file_name, 0644);
			}
		}
	}
	$stmt_a->close();

	
	if (isset($_FILES['sbtd_pix_gbc']) && !($_FILES['sbtd_pix_gbc']['error'] == 4 || ($_FILES['sbtd_pix_gbc']['size'] == 0 && $_FILES['sbtd_pix_gbc']['error'] == 0)))
	{
		$old_base_dir = "../ext_docs/g_bc/".strtolower($_REQUEST['old_faculty'])."/";
		$new_base_dir = "../ext_docs/g_bc/".strtolower($cFacultyId)."/";
		$base_dir = "../ext_docs/g_bc/";

		if (!move_uploaded_file($_FILES['sbtd_pix_gbc']['tmp_name'], $base_dir . $_FILES['sbtd_pix_gbc']['name']))
		{
			echo  "Upload failed, please try again"; exit;
		}

		$stmt = $mysqli->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? and cinfo_type = 'bc'");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($vmask);
		$stmt->fetch();

		$old_file = $old_base_dir."bc_".$vmask.".pdf"; 
		if(file_exists($old_file))
		{
			@unlink($old_file);
		}
		
		$old_file = $new_base_dir."bc_".$vmask.".pdf"; 
		if(file_exists($old_file))
		{
			@unlink($old_file);
		}

		$token = openssl_random_pseudo_bytes(6);
		$token = bin2hex($token);

		$new_file_name = $new_base_dir."bc_" . $token.".pdf";

		rename($base_dir . $_FILES['sbtd_pix_gbc']['name'], $new_file_name);
		chmod($new_file_name, 0755);


		$stmt = $mysqli->prepare("REPLACE INTO pics
		SET vmask = '$token', vApplicationNo = ?, cinfo_type = 'bc', vExamNo = '', cQualCodeId = '', f_type = 'f'");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->close();
	}

	if (isset($_FILES['sbtd_pix_yc']) && !($_FILES['sbtd_pix_yc']['error'] == 4 || ($_FILES['sbtd_pix_yc']['size'] == 0 && $_FILES['sbtd_pix_yc']['error'] == 0)))
	{
		$base_dir = "../ext_docs/g_yc/";
		if (!move_uploaded_file($_FILES['sbtd_pix_yc']['tmp_name'], $base_dir . $_FILES['sbtd_pix_yc']['name']))
		{
			echo  "Upload failed, please try again"; exit;
		}

		$stmt = $mysqli->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? and cinfo_type = 'yc'");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($vmask_yc);
		$stmt->fetch();

		$old_file = $base_dir."yc_".$vmask_yc.".pdf"; 
		if(file_exists($old_file))
		{
			@unlink($old_file);
		}

		$token = openssl_random_pseudo_bytes(6);
		$token = bin2hex($token);

		$new_file_name = $base_dir."yc_" . $token.".pdf";

		rename($base_dir . $_FILES['sbtd_pix_yc']['name'], $new_file_name);
		chmod($new_file_name, 0755);
		
		$stmt = $mysqli->prepare("REPLACE INTO pics
		SET vmask = '$token', vApplicationNo = ?, cinfo_type = 'yc', vExamNo = '', cQualCodeId = '', f_type = 'f'");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->close();
	}

	

	if (isset($_FILES['sbtd_pix_mc']) && !($_FILES['sbtd_pix_mc']['error'] == 4 || ($_FILES['sbtd_pix_mc']['size'] == 0 && $_FILES['sbtd_pix_mc']['error'] == 0)) && !($_FILES['sbtd_pix_mc']['error'] == 4 || ($_FILES['sbtd_pix_mc']['size'] == 0 && $_FILES['sbtd_pix_mc']['error'] == 0)))
	{
		$base_dir = "../ext_docs/g_mc/";
		if (!move_uploaded_file($_FILES['sbtd_pix_mc']['tmp_name'], $base_dir . $_FILES['sbtd_pix_mc']['name']))
		{
			echo  "Upload failed, please try again"; exit;
		}

		$stmt = $mysqli->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? and cinfo_type = 'mc'");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($vmask_mc);
		$stmt->fetch();

		$old_file = $base_dir."mc_".$vmask_mc.".pdf"; 
		if(file_exists($old_file))
		{
			@unlink($old_file);
		}

		$token = openssl_random_pseudo_bytes(6);
		$token = bin2hex($token);

		$new_file_name = $base_dir."mc_" . $token.".pdf";

		rename($base_dir . $_FILES['sbtd_pix_mc']['name'], $new_file_name);
		chmod($new_file_name, 0755);
		
		$stmt = $mysqli->prepare("REPLACE INTO pics
		SET vmask = '$token', vApplicationNo = ?, cinfo_type = 'mc', vExamNo = '', cQualCodeId = '', f_type = 'f'");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->close();
	}
}


function move_cc_into_root($cFacultyId)
{
	$mysqli = link_connect_db();

	$stmt_a = $mysqli->prepare("SELECT vmask, cQualCodeId, vExamNo FROM pics WHERE vApplicationNo = ? and cinfo_type = 'c'");
	$stmt_a->bind_param("s", $_REQUEST["vApplicationNo"]);
	$stmt_a->execute();
	$stmt_a->store_result();
	$stmt_a->bind_result($vmask, $cQualCodeId, $vExamNo);

	while($stmt_a->fetch())
	{
		$search_file_name = BASE_FILE_NAME_FOR_PP.$cQualCodeId."_".$vExamNo."_".$vmask.".jpg";
		$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/cc/".$cQualCodeId."_".$vExamNo."_".$vmask.".jpg";

		if(file_exists($pix_file_name))
		{
			if (copy($pix_file_name, $search_file_name))
			{
				@unlink($pix_file_name);
			}
			chmod($search_file_name, 0644);
		}else
		{
			$search_file_name = BASE_FILE_NAME_FOR_PP.strtolower($_REQUEST['old_faculty'])."/cc/".$cQualCodeId."_".$vExamNo."_".$vmask.".jpg";
			if(file_exists($pix_file_name))
			{
				if (copy($pix_file_name, $search_file_name))
				{
					@unlink($pix_file_name);
				}
				chmod($search_file_name, 0644);
			}
		}

		$search_file_name = BASE_FILE_NAME_FOR_PP.$cQualCodeId."_".$vExamNo."_".$vmask.".jpeg";
		$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/cc/".$cQualCodeId."_".$vExamNo."_".$vmask.".jpeg";

		if(file_exists($pix_file_name))
		{
			if (copy($pix_file_name, $search_file_name))
			{
				@unlink($pix_file_name);
			}
			chmod($search_file_name, 0644);
		}else
		{
			$search_file_name = BASE_FILE_NAME_FOR_PP.strtolower($_REQUEST['old_faculty'])."/cc/".$cQualCodeId."_".$vExamNo."_".$vmask.".jpeg";
			if(file_exists($pix_file_name))
			{
				if (copy($pix_file_name, $search_file_name))
				{
					@unlink($pix_file_name);
				}
				chmod($search_file_name, 0644);
			}
		}

		$search_file_name = BASE_FILE_NAME_FOR_PP.$cQualCodeId."_".$vExamNo."_".$vmask.".pjpeg";
		$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/cc/".$cQualCodeId."_".$vExamNo."_".$vmask.".pjpeg";

		if(file_exists($pix_file_name))
		{
			if (copy($pix_file_name, $search_file_name))
			{
				@unlink($pix_file_name);
			}
			chmod($search_file_name, 0644);
		}else
		{
			$search_file_name = BASE_FILE_NAME_FOR_PP.strtolower($_REQUEST['old_faculty'])."/cc/".$cQualCodeId."_".$vExamNo."_".$vmask.".pjpeg";
			if(file_exists($pix_file_name))
			{
				if (copy($pix_file_name, $search_file_name))
				{
					@unlink($pix_file_name);
				}
				chmod($search_file_name, 0644);
			}
		}
	}
	$stmt_a->close();
}


function move_pgdoc_out_of_root($cFacultyId)
{ 
	if (isset($_FILES['sbtd_pix_pr']))
	{
		$filepath = $_FILES['sbtd_pix_pr']['tmp_name'];
		$fileSize = filesize($filepath);
	
		if (mime_content_type($_FILES['sbtd_pix_pr']['tmp_name']) <> "application/pdf")
		{
			echo 'Invalid file format for payment receipt';
			exit;
		}

		if ($fileSize == 0)
		{
			echo 'Empty file not allowed for payment receipt';
			exit;
		}

		if ($fileSize > 100000)
		{
			echo 'Maximum file size for payment receipt is 100KB';
			exit;
		}
	}

	if (isset($_FILES['sbtd_pix_cv']))
	{
		$filepath = $_FILES['sbtd_pix_cv']['tmp_name'];
		$fileSize = filesize($filepath);

		if (mime_content_type($_FILES['sbtd_pix_cv']['tmp_name']) <> "application/pdf")
		{
			echo 'Invalid file format for CV';
			exit;
		}

		if ($fileSize == 0)
		{
			echo 'Empty file not allowed for cv';
			exit;
		}

		if ($fileSize > 100000)
		{
			echo 'Maximum file size for cv is 150KB';
			exit;
		}
	}

	if (isset($_FILES['sbtd_pix_rl1']))
	{
		$filepath = $_FILES['sbtd_pix_rl1']['tmp_name'];
		$fileSize = filesize($filepath);

		if (mime_content_type($_FILES['sbtd_pix_rl1']['tmp_name']) <> "application/pdf")
		{
			echo 'Invalid file format for first letter of referee';
			exit;
		}

		if ($fileSize == 0)
		{
			echo 'Empty file not allowed for first letter of referee';
			exit;
		}

		if ($fileSize > 100000)
		{
			echo 'Maximum file size for first letter of referee is 100KB';
			exit;
		}
	}

	if (isset($_FILES['sbtd_pix_rl2']))
	{
		$filepath = $_FILES['sbtd_pix_rl2']['tmp_name'];
		$fileSize = filesize($filepath);

		if (mime_content_type($_FILES['sbtd_pix_rl2']['tmp_name']) <> "application/pdf")
		{
			echo 'Invalid file format for second letter of referee';
			exit;
		}

		if ($fileSize == 0)
		{
			echo 'Empty file not allowed for second letter of referee';
			exit;
		}

		if ($fileSize > 100000)
		{
			echo 'Maximum file size for second letter of referee is 100KB';
			exit;
		}
	}

	if (isset($_FILES['sbtd_pix_tp']))
	{
		$filepath = $_FILES['sbtd_pix_tp']['tmp_name'];
		$fileSize = filesize($filepath);

		if (mime_content_type($_FILES['sbtd_pix_tp']['tmp_name']) <> "application/pdf")
		{
			echo 'Invalid file format for project proposal';
			exit;
		}

		if ($fileSize == 0)
		{
			echo 'Empty file not allowed for project proposal';
			exit;
		}

		if ($fileSize > 150000)
		{
			echo 'Maximum file size for project proposal is 150KB';
			exit;
		}
	}
	
	$mysqli = link_connect_db();
	
	$mask = '';
	
	if (isset($_FILES['sbtd_pix_pr']) && !($_FILES['sbtd_pix_pr']['error'] == 4 || ($_FILES['sbtd_pix_pr']['size'] == 0 && $_FILES['sbtd_pix_pr']['error'] == 0)) && isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] <> '')
	{
		//use old faculty to get the current mask
		//use it to locate and delete/move currently uploaded docs accordingly

		$stmt_last = $mysqli->prepare("SELECT trim(vmask) FROM pics WHERE vApplicationNo  = ? AND cinfo_type IN ('pr','cv','rl1','rl2','tp')");
		$stmt_last->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt_last->execute();
		$stmt_last->store_result();
		$stmt_last->bind_result($mask);
		while($stmt_last->fetch())
		{
			$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($_REQUEST["old_faculty"])."/cc/pr_".$mask.".pdf";
			if(file_exists($pix_file_name))
			{
				@unlink($pix_file_name);
			}else
			{
				$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/pr_".$mask.".pdf";
				if(file_exists($pix_file_name))
				{
					@unlink($pix_file_name);
				}
			}			
			
			$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($_REQUEST["old_faculty"])."/cc/cv_".$mask.".pdf";
			if(file_exists($pix_file_name))
			{
				@unlink($pix_file_name);
			}else
			{
				$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/cv_".$mask.".pdf";
				if(file_exists($pix_file_name))
				{
					@unlink($pix_file_name);
				}
			}
			
			$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($_REQUEST["old_faculty"])."/cc/rl1_".$mask.".pdf";
			if(file_exists($pix_file_name))
			{
				@unlink($pix_file_name);
			}else
			{
				$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/rl1_".$mask.".pdf";
				if(file_exists($pix_file_name))
				{
					@unlink($pix_file_name);
				}
			}
			
			$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($_REQUEST["old_faculty"])."/cc/rl2_".$mask.".pdf";
			if(file_exists($pix_file_name))
			{
				@unlink($pix_file_name);
			}else
			{
				$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/rl2_".$mask.".pdf";
				if(file_exists($pix_file_name))
				{
					@unlink($pix_file_name);
				}
			}
			
			$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($_REQUEST["old_faculty"])."/cc/tp_".$mask.".pdf";
			if(file_exists($pix_file_name))
			{
				@unlink($pix_file_name);
			}else
			{
				$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/tp_".$mask.".pdf";
				if(file_exists($pix_file_name))
				{
					@unlink($pix_file_name);
				}
			}
		}
		$stmt_last->close();


		$token = openssl_random_pseudo_bytes(6);
		$token = bin2hex($token);

		$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/pr_".$token.".pdf";
		if (!move_uploaded_file($_FILES['sbtd_pix_pr']['tmp_name'], $pix_file_name))
		{
			echo  "Upload failed, please try again"; exit;
		}
		chmod($pix_file_name, 0644);

		$stmt = $mysqli->prepare("REPLACE INTO pics
		SET vmask = '$token', vApplicationNo = ?, cinfo_type = 'pr', vExamNo = '', cQualCodeId = '', f_type = 'f'");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->close();
	}

	if (isset($_FILES['sbtd_pix_cv']) && !($_FILES['sbtd_pix_cv']['error'] == 4 || ($_FILES['sbtd_pix_cv']['size'] == 0 && $_FILES['sbtd_pix_cv']['error'] == 0)) && isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] <> '')
	{
		$token = openssl_random_pseudo_bytes(6);
		$token = bin2hex($token);

		$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/cv_".$token.".pdf";
		if (!move_uploaded_file($_FILES['sbtd_pix_cv']['tmp_name'], $pix_file_name))
		{
			echo  "Upload failed, please try again"; exit;
		}
		chmod($pix_file_name, 0644);

		$stmt = $mysqli->prepare("REPLACE INTO pics
		SET vmask = '$token', vApplicationNo = ?, cinfo_type = 'cv', vExamNo = '', cQualCodeId = '', f_type = 'f'");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->close();
	}

	if (isset($_FILES['sbtd_pix_rl1']) && !($_FILES['sbtd_pix_rl1']['error'] == 4 || ($_FILES['sbtd_pix_rl1']['size'] == 0 && $_FILES['sbtd_pix_rl1']['error'] == 0)) && isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] <> '')
	{
		$token = openssl_random_pseudo_bytes(6);
		$token = bin2hex($token);

		$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/rl1_".$token.".pdf";
		if (!move_uploaded_file($_FILES['sbtd_pix_rl1']['tmp_name'], $pix_file_name))
		{
			echo  "Upload failed, please try again"; exit;
		}
		chmod($pix_file_name, 0644);

		$stmt = $mysqli->prepare("REPLACE INTO pics
		SET vmask = '$token', vApplicationNo = ?, cinfo_type = 'rl1', vExamNo = '', cQualCodeId = '', f_type = 'f'");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->close();
	}

	if (isset($_FILES['sbtd_pix_rl2']) && !($_FILES['sbtd_pix_rl2']['error'] == 4 || ($_FILES['sbtd_pix_rl2']['size'] == 0 && $_FILES['sbtd_pix_rl2']['error'] == 0)) && isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] <> '')
	{
		$token = openssl_random_pseudo_bytes(6);
		$token = bin2hex($token);

		$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/rl2_".$token.".pdf";
		if (!move_uploaded_file($_FILES['sbtd_pix_rl2']['tmp_name'], $pix_file_name))
		{
			echo  "Upload failed, please try again"; exit;
		}
		chmod($pix_file_name, 0644);

		$stmt = $mysqli->prepare("REPLACE INTO pics
		SET vmask = '$token', vApplicationNo = ?, cinfo_type = 'rl2', vExamNo = '', cQualCodeId = '', f_type = 'f'");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->close();
	}

	if (isset($_FILES['sbtd_pix_tp']) && !($_FILES['sbtd_pix_tp']['error'] == 4 || ($_FILES['sbtd_pix_tp']['size'] == 0 && $_FILES['sbtd_pix_tp']['error'] == 0)) && isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] <> '')
	{
		$token = openssl_random_pseudo_bytes(6);
		$token = bin2hex($token);

		$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/tp_".$token.".pdf";
		if (!move_uploaded_file($_FILES['sbtd_pix_tp']['tmp_name'], $pix_file_name))
		{
			echo  "Upload failed, please try again"; exit;
		}
		chmod($pix_file_name, 0644);

		$stmt = $mysqli->prepare("REPLACE INTO pics
		SET vmask = '$token', vApplicationNo = ?, cinfo_type = 'tp', vExamNo = '', cQualCodeId = '', f_type = 'f'");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->close();
	}

	return 1;
}

function move_cembadoc_out_of_root($cFacultyId)
{ 
	$mysqli = link_connect_db();
	
	$mask = '';
	
	if (isset($_FILES['sbtd_pix_pr']) && !($_FILES['sbtd_pix_pr']['error'] == 4 || ($_FILES['sbtd_pix_pr']['size'] == 0 && $_FILES['sbtd_pix_pr']['error'] == 0)) && isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] <> '')
	{
		$filepath = $_FILES['sbtd_pix_pr']['tmp_name'];
		$fileSize = filesize($filepath);

		if ($fileSize == 0)
		{
			echo 'Empty file not allowed for payment receipt';
			exit;
		}

		if ($fileSize > 100000)
		{
			echo 'Maximum file size for payment receipt is 100KB';
			exit;
		}

		if (mime_content_type($_FILES['sbtd_pix_pr']['tmp_name']) <> "application/pdf")
		{
			echo 'Invalid file format for payment receipt';
			exit;
		}
		
		//use old faculty to get the current mask
		//use it to locate and delete/move currently uploaded docs accordingly

		$stmt_last = $mysqli->prepare("SELECT trim(vmask) FROM pics WHERE vApplicationNo  = ? AND cinfo_type IN ('pr','cv','rl1','rl2','tp')");
		$stmt_last->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt_last->execute();
		$stmt_last->store_result();
		$stmt_last->bind_result($mask);
		while($stmt_last->fetch())
		{
			$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($_REQUEST["old_faculty"])."/cc/pr_".$mask.".pdf";
			if(file_exists($pix_file_name))
			{
				@unlink($pix_file_name);
			}else
			{
				$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/pr_".$mask.".pdf";
				if(file_exists($pix_file_name))
				{
					@unlink($pix_file_name);
				}
			}			
			
			$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($_REQUEST["old_faculty"])."/cc/cv_".$mask.".pdf";
			if(file_exists($pix_file_name))
			{
				@unlink($pix_file_name);
			}else
			{
				$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/cv_".$mask.".pdf";
				if(file_exists($pix_file_name))
				{
					@unlink($pix_file_name);
				}
			}
			
			$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($_REQUEST["old_faculty"])."/cc/rl1_".$mask.".pdf";
			if(file_exists($pix_file_name))
			{
				@unlink($pix_file_name);
			}else
			{
				$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/rl1_".$mask.".pdf";
				if(file_exists($pix_file_name))
				{
					@unlink($pix_file_name);
				}
			}
			
			$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($_REQUEST["old_faculty"])."/cc/rl2_".$mask.".pdf";
			if(file_exists($pix_file_name))
			{
				@unlink($pix_file_name);
			}else
			{
				$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/rl2_".$mask.".pdf";
				if(file_exists($pix_file_name))
				{
					@unlink($pix_file_name);
				}
			}
			
			$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($_REQUEST["old_faculty"])."/cc/tp_".$mask.".pdf";
			if(file_exists($pix_file_name))
			{
				@unlink($pix_file_name);
			}else
			{
				$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/tp_".$mask.".pdf";
				if(file_exists($pix_file_name))
				{
					@unlink($pix_file_name);
				}
			}
		}
		$stmt_last->close();


		$token = openssl_random_pseudo_bytes(6);
		$token = bin2hex($token);

		$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/pr_".$token.".pdf";
		if (!move_uploaded_file($_FILES['sbtd_pix_pr']['tmp_name'], $pix_file_name))
		{
			echo  "Upload failed, please try again"; exit;
		}
		chmod($pix_file_name, 0644);

		$stmt = $mysqli->prepare("REPLACE INTO pics
		SET vmask = '$token', vApplicationNo = ?, cinfo_type = 'pr', vExamNo = '', cQualCodeId = '', f_type = 'f'");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->close();
	}

	if (isset($_FILES['sbtd_pix_bc']) && !($_FILES['sbtd_pix_bc']['error'] == 4 || ($_FILES['sbtd_pix_bc']['size'] == 0 && $_FILES['sbtd_pix_bc']['error'] == 0)) && isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] <> '')
	{
		$filepath = $_FILES['sbtd_pix_bc']['tmp_name'];
		$fileSize = filesize($filepath);

		if ($fileSize == 0)
		{
			echo 'Empty file not allowed for payment receipt';
			exit;
		}

		if ($fileSize > 100000)
		{
			echo 'Maximum file size for payment receipt is 100KB';
			exit;
		}

		if (mime_content_type($_FILES['sbtd_pix_bc']['tmp_name']) <> "application/pdf")
		{
			echo 'Invalid file format for birth certificate';
			exit;
		}

		$token = openssl_random_pseudo_bytes(6);
		$token = bin2hex($token);

		$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/bc_".$token.".pdf";
		if (!move_uploaded_file($_FILES['sbtd_pix_bc']['tmp_name'], $pix_file_name))
		{
			echo  "Upload failed, please try again"; exit;
		}
		chmod($pix_file_name, 0644);

		$stmt = $mysqli->prepare("REPLACE INTO pics
		SET vmask = '$token', vApplicationNo = ?, cinfo_type = 'bc', vExamNo = '', cQualCodeId = '', f_type = 'f'");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->close();
	}

	if (isset($_FILES['sbtd_pix_we']) && !($_FILES['sbtd_pix_we']['error'] == 4 || ($_FILES['sbtd_pix_we']['size'] == 0 && $_FILES['sbtd_pix_we']['error'] == 0)) && isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] <> '')
	{
		$filepath = $_FILES['sbtd_pix_we']['tmp_name'];
		$fileSize = filesize($filepath);

		if ($fileSize == 0)
		{
			echo 'Empty file not allowed for work experience';
			exit;
		}

		if ($fileSize > 100000)
		{
			echo 'Maximum file size for work experience is 100KB';
			exit;
		}

		if (mime_content_type($_FILES['sbtd_pix_we']['tmp_name']) <> "application/pdf")
		{
			echo 'Invalid file format for work experience';
			exit;
		}

		$token = openssl_random_pseudo_bytes(6);
		$token = bin2hex($token);

		$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/we_".$token.".pdf";
		if (!move_uploaded_file($_FILES['sbtd_pix_we']['tmp_name'], $pix_file_name))
		{
			echo  "Upload failed, please try again"; exit;
		}
		chmod($pix_file_name, 0644);

		$stmt = $mysqli->prepare("REPLACE INTO pics
		SET vmask = '$token', vApplicationNo = ?, cinfo_type = 'we', vExamNo = '', cQualCodeId = '', f_type = 'f'");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->close();
	}

	if (isset($_FILES['sbtd_pix_rl2']) && !($_FILES['sbtd_pix_rl2']['error'] == 4 || ($_FILES['sbtd_pix_rl2']['size'] == 0 && $_FILES['sbtd_pix_rl2']['error'] == 0)) && isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] <> '')
	{
		$filepath = $_FILES['sbtd_pix_rl2']['tmp_name'];
		$fileSize = filesize($filepath);

		if ($fileSize == 0)
		{
			echo 'Empty file not allowed for letter of reference';
			exit;
		}

		if ($fileSize > 100000)
		{
			echo 'Maximum file size for letter of referenceis 100KB';
			exit;
		}

		if (mime_content_type($_FILES['sbtd_pix_rl2']['tmp_name']) <> "application/pdf")
		{
			echo 'Invalid file format for letter of reference';
			exit;
		}

		$token = openssl_random_pseudo_bytes(6);
		$token = bin2hex($token);

		$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/rl2_".$token.".pdf";
		if (!move_uploaded_file($_FILES['sbtd_pix_rl2']['tmp_name'], $pix_file_name))
		{
			echo  "Upload failed, please try again"; exit;
		}
		chmod($pix_file_name, 0644);

		$stmt = $mysqli->prepare("REPLACE INTO pics
		SET vmask = '$token', vApplicationNo = ?, cinfo_type = 'rl2', vExamNo = '', cQualCodeId = '', f_type = 'f'");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->close();
	}

	if (isset($_FILES['sbtd_pix_tp']) && !($_FILES['sbtd_pix_tp']['error'] == 4 || ($_FILES['sbtd_pix_tp']['size'] == 0 && $_FILES['sbtd_pix_tp']['error'] == 0)) && isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] <> '')
	{
		$token = openssl_random_pseudo_bytes(6);
		$token = bin2hex($token);

		$pix_file_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/tp_".$token.".pdf";
		if (!move_uploaded_file($_FILES['sbtd_pix_tp']['tmp_name'], $pix_file_name))
		{
			echo  "Upload failed, please try again"; exit;
		}
		chmod($pix_file_name, 0644);

		$stmt = $mysqli->prepare("REPLACE INTO pics
		SET vmask = '$token', vApplicationNo = ?, cinfo_type = 'tp', vExamNo = '', cQualCodeId = '', f_type = 'f'");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->close();
	}

	return 1;
}


function move_hscert_out_of_root()
{
	if (isset($_FILES['sbtd_pix_pc']) && isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] <> '')
	{
		$filepath = $_FILES['sbtd_pix_pc']['tmp_name'];
		$fileSize = filesize($filepath);

		if ($fileSize == 0)
		{
			echo 'Empty file not allowed for professional certificate';
			exit;
		}

		if ($fileSize > 100000)
		{
			echo 'Maximum file size for professional certificate is 100KB';
			exit;
		}

		if (mime_content_type($_FILES['sbtd_pix_pc']['tmp_name']) <> "application/pdf")
		{
			echo 'Invalid file format for professional certificate';
			exit;
		}

		if (isset($_FILES['sbtd_pix_pc']) && !($_FILES['sbtd_pix_pc']['error'] == 4 || ($_FILES['sbtd_pix_pc']['size'] == 0 && $_FILES['sbtd_pix_pc']['error'] == 0)))
		{
			$base_dir = "../ext_docs/pcert/";

			if (!move_uploaded_file($_FILES['sbtd_pix_pc']['tmp_name'], $base_dir . $_FILES['sbtd_pix_pc']['name']))
			{
				echo  "Upload failed, please try again"; exit;
			}

			$mysqli = link_connect_db();

			$stmt = $mysqli->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? and cinfo_type = 'pc'");
			$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($vmask);
			$stmt->fetch();

			$old_file = $base_dir."pc_".$vmask.".pdf"; 
			if(file_exists($old_file))
			{
				@unlink($old_file);
			}
			

			$token = openssl_random_pseudo_bytes(6);
			$token = bin2hex($token);

			$new_file_name = $base_dir."pc_" . $token.".pdf";

			rename($base_dir . $_FILES['sbtd_pix_pc']['name'], $new_file_name);
			chmod($new_file_name, 0755);


			$stmt = $mysqli->prepare("REPLACE INTO pics
			SET vmask = '$token', vApplicationNo = ?, cinfo_type = 'pc', vExamNo = '', cQualCodeId = '', f_type = 'f'");
			$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
			$stmt->execute();
			$stmt->close();
		}


		$filepath = $_FILES['sbtd_pix_nl']['tmp_name'];
		$fileSize = filesize($filepath);

		if ($fileSize == 0)
		{
			echo 'Empty file not allowed for professional practicing license';
			exit;
		}

		if ($fileSize > 100000)
		{
			echo 'Maximum file size for professional practicing license is 100KB';
			exit;
		}

		if (mime_content_type($_FILES['sbtd_pix_nl']['tmp_name']) <> "application/pdf")
		{
			echo 'Invalid file format for professional practicing license';
			exit;
		}

		if (isset($_FILES['sbtd_pix_nl']) && !($_FILES['sbtd_pix_nl']['error'] == 4 || ($_FILES['sbtd_pix_nl']['size'] == 0 && $_FILES['sbtd_pix_nl']['error'] == 0)))
		{
			$base_dir = "../ext_docs/pcert/";

			if (!move_uploaded_file($_FILES['sbtd_pix_nl']['tmp_name'], $base_dir . $_FILES['sbtd_pix_nl']['name']))
			{
				echo  "Upload failed, please try again"; exit;
			}

			$mysqli = link_connect_db();

			$stmt = $mysqli->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? and cinfo_type = 'nl'");
			$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($vmask);
			$stmt->fetch();

			$old_file = $base_dir."nl_".$vmask.".pdf"; 
			if(file_exists($old_file))
			{
				@unlink($old_file);
			}
			

			$token = openssl_random_pseudo_bytes(6);
			$token = bin2hex($token);

			$new_file_name = $base_dir."nl_" . $token.".pdf";

			rename($base_dir . $_FILES['sbtd_pix_nl']['name'], $new_file_name);
			chmod($new_file_name, 0755);


			$stmt = $mysqli->prepare("REPLACE INTO pics
			SET vmask = '$token', vApplicationNo = ?, cinfo_type = 'nl', vExamNo = '', cQualCodeId = '', f_type = 'f'");
			$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
			$stmt->execute();
			$stmt->close();
		}
	}

	return 1;
}


function get_ctry_of_res()
{
	$mysqli = link_connect_db();

	if (substr($_REQUEST["uvApplicationNo"],0,3) == 'NOU' || substr($_REQUEST["uvApplicationNo"],0,3) == 'COL')
	{
		$stmt = $mysqli->prepare("SELECT cResidenceCountryId from s_m_t where vMatricNo = ?");
	}else
	{
		$stmt = $mysqli->prepare("SELECT cResidenceCountryId from res_addr where vApplicationNo = ?");
	}
	
	$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cResidenceCountryId);
	$stmt->fetch();
	$stmt->close();

	$img = '';
	$title = '';
	if ($cResidenceCountryId == 'NG')
	{
		$img = 'ng.png';
		$title = 'Resident in Nigeria';
	}else
	{
		$img = 'frn.png';
		$title = 'Resident abroad';
	}?>
	<img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.$img);?>"  width="20px" height="20px" style="margin: 6px"; title="<?php echo $title;?>"/><?php
}


function do_fac_tables($fac)
{	
	$mysqli = link_connect_db();

	$fac = strtolower($fac);

	try
	{
		$mysqli->autocommit(FALSE); //turn on transactions

		$stmt = $mysqli->prepare("REPLACE INTO prog_choice_$fac select * from prog_choice
		WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO pers_info_$fac select * from pers_info
		WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO post_addr_$fac select * from post_addr
		WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO res_addr_$fac select * from res_addr
		WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO nextofkin_$fac select * from nextofkin
		WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO afnqualsubject_$fac select * from afnqualsubject
		WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
		$stmt->execute();

		$stmt->close();
					
		$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

		return 1;
	}catch(Exception $e)
	{
	  $mysqli->rollback(); //remove all queries from queue if error (undo)
	  throw $e;
	}
}




function archive_student_xtra($vMatricNo)
{
	$mysqli = link_connect_db();
		
	$stmt = $mysqli->prepare("SELECT vApplicationNo FROM afnmatric WHERE vMatricNo = ?");
	$stmt->bind_param("s", $vMatricNo);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($vApplicationNo);
	$stmt->fetch();

	$vApplicationNo = $vApplicationNo ?? '';

	if ($vApplicationNo == '')
	{
		return;
	}

	$stmt = $mysqli->prepare("SELECT vMatricNo FROM damu82ro_nouonlinenouedu_db2.arch_afnmatric WHERE vMatricNo LIKE '$vMatricNo%'");
	//$stmt->bind_param("s", $vMatricNo);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($vMatricNo_extr);
	$stmt->fetch();

	$vMatricNo_extr = $vMatricNo_extr ?? '';

	$next_no = 1;

	if ($vMatricNo_extr <> '')
	{
		if (!is_bool(strpos($vMatricNo_extr,"_")))
		{
			$next_no = substr($vMatricNo_extr, strlen($vMatricNo_extr)-1,1) + 1;
		}
	}

	$new_matno = $vMatricNo."_".$next_no;
	
	try
	{
		$mysqli->autocommit(FALSE); //turn on transactions

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_afnmatric SELECT * FROM damu82ro_nouonlinenouedu_db1.afnmatric WHERE
		damu82ro_nouonlinenouedu_db1.afnmatric.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("UPDATE IGNORE damu82ro_nouonlinenouedu_db2.arch_afnmatric SET vMatricNo = '$new_matno' WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("UPDATE afnmatric SET vApplicationNo = ? WHERE vMatricNo = '$vMatricNo'");
		$stmt->bind_param("s", $_REQUEST['vApplicationNo']);
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_afnqualsubject SELECT * FROM damu82ro_nouonlinenouedu_db1.afnqualsubject WHERE
		damu82ro_nouonlinenouedu_db1.afnqualsubject.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM afnqualsubject WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_afnqualsubject_stff SELECT * FROM damu82ro_nouonlinenouedu_db1.afnqualsubject_stff WHERE
		damu82ro_nouonlinenouedu_db1.afnqualsubject_stff.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("UPDATE IGNORE damu82ro_nouonlinenouedu_db2.arch_afnqualsubject_stff SET vMatricNo = '$new_matno' WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM afnqualsubject_stff WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_applyqual SELECT * FROM damu82ro_nouonlinenouedu_db1.applyqual WHERE
		damu82ro_nouonlinenouedu_db1.applyqual.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM applyqual WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_applyqual_stff SELECT * FROM damu82ro_nouonlinenouedu_db1.applyqual_stff WHERE
		damu82ro_nouonlinenouedu_db1.applyqual_stff.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("UPDATE IGNORE damu82ro_nouonlinenouedu_db2.arch_applyqual_stff SET vMatricNo = '$new_matno' WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM applyqual_stff WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_applysubject SELECT * FROM damu82ro_nouonlinenouedu_db1.applysubject WHERE
		damu82ro_nouonlinenouedu_db1.applysubject.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM applysubject WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_applysubject_stff SELECT * FROM damu82ro_nouonlinenouedu_db1.applysubject_stff WHERE
		damu82ro_nouonlinenouedu_db1.applysubject_stff.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("UPDATE IGNORE damu82ro_nouonlinenouedu_db2.arch_applysubject_stff SET vMatricNo = '$new_matno' WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM applysubject_stff WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_app_client SELECT * FROM damu82ro_nouonlinenouedu_db1.app_client WHERE
		damu82ro_nouonlinenouedu_db1.app_client.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM app_client WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_atv_log SELECT * FROM damu82ro_nouonlinenouedu_db1.atv_log WHERE
		damu82ro_nouonlinenouedu_db1.atv_log.vApplicationNo = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db1.atv_log.vApplicationNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM atv_log WHERE vApplicationNo = '$vApplicationNo' OR vApplicationNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_pers_info SELECT * FROM damu82ro_nouonlinenouedu_db1.pers_info WHERE
		damu82ro_nouonlinenouedu_db1.pers_info.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM pers_info WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_post_addr SELECT * FROM damu82ro_nouonlinenouedu_db1.post_addr WHERE
		damu82ro_nouonlinenouedu_db1.post_addr.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM post_addr WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_res_addr SELECT * FROM damu82ro_nouonlinenouedu_db1.res_addr WHERE
		damu82ro_nouonlinenouedu_db1.res_addr.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM res_addr WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_nextofkin SELECT * FROM damu82ro_nouonlinenouedu_db1.nextofkin WHERE
		damu82ro_nouonlinenouedu_db1.nextofkin.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM nextofkin WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_pics SELECT * FROM damu82ro_nouonlinenouedu_db1.pics WHERE
		damu82ro_nouonlinenouedu_db1.pics.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM pics WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_prog_choice SELECT * FROM damu82ro_nouonlinenouedu_db1.prog_choice WHERE
		damu82ro_nouonlinenouedu_db1.prog_choice.vApplicationNo = '$vApplicationNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM prog_choice WHERE vApplicationNo = '$vApplicationNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_s_m_t SELECT * FROM damu82ro_nouonlinenouedu_db1.s_m_t WHERE
		damu82ro_nouonlinenouedu_db1.s_m_t.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("UPDATE damu82ro_nouonlinenouedu_db2.arch_s_m_t SET vMatricNo = '$new_matno' WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM s_m_t WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();

		/*$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_s_tranxion SELECT * FROM damu82ro_nouonlinenouedu_db1.s_tranxion WHERE
		damu82ro_nouonlinenouedu_db1.s_tranxion.vMatricNo = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db1.s_tranxion.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("UPDATE damu82ro_nouonlinenouedu_db2.arch_s_tranxion SET vMatricNo = '$new_matno' WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM s_tranxion WHERE vMatricNo = '$vApplicationNo' OR vMatricNo = '$vMatricNo'");
		$stmt->execute();*/
		
		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_s_tranxion_cr SELECT * FROM damu82ro_nouonlinenouedu_db1.s_tranxion_cr WHERE
		damu82ro_nouonlinenouedu_db1.s_tranxion_cr.vMatricNo = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db1.s_tranxion_cr.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("UPDATE damu82ro_nouonlinenouedu_db2.arch_s_tranxion_cr SET vMatricNo = '$new_matno' WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM s_tranxion_cr WHERE vMatricNo = '$vApplicationNo' OR vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_s_tranxion_app SELECT * FROM damu82ro_nouonlinenouedu_db1.s_tranxion_app WHERE
		damu82ro_nouonlinenouedu_db1.s_tranxion_app.vMatricNo = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db1.s_tranxion_app.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM s_tranxion_app WHERE vMatricNo = '$vApplicationNo' OR vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_remitapayments SELECT * FROM damu82ro_nouonlinenouedu_db1.remitapayments WHERE
		damu82ro_nouonlinenouedu_db1.remitapayments.Regno = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db1.remitapayments.Regno = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("UPDATE damu82ro_nouonlinenouedu_db2.arch_remitapayments SET Regno = '$new_matno' WHERE Regno = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM remitapayments WHERE Regno = '$vApplicationNo' OR Regno = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_remitapayments_app SELECT * FROM damu82ro_nouonlinenouedu_db1.remitapayments_app WHERE
		damu82ro_nouonlinenouedu_db1.remitapayments_app.Regno = '$vApplicationNo' OR damu82ro_nouonlinenouedu_db1.remitapayments_app.Regno = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM remitapayments_app WHERE Regno = '$vApplicationNo' OR Regno = '$vMatricNo'");
		$stmt->execute();

		/*$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_coursereg SELECT * FROM damu82ro_nouonlinenouedu_db1.coursereg WHERE
		damu82ro_nouonlinenouedu_db1.coursereg.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("UPDATE damu82ro_nouonlinenouedu_db2.arch_coursereg SET vMatricNo = '$new_matno' WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM coursereg WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_coursereg_arch SELECT * FROM damu82ro_nouonlinenouedu_db1.coursereg_arch WHERE
		damu82ro_nouonlinenouedu_db1.coursereg_arch.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("UPDATE damu82ro_nouonlinenouedu_db2.arch_coursereg_arch SET vMatricNo = '$new_matno' WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM coursereg_arch WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_examreg SELECT * FROM damu82ro_nouonlinenouedu_db1.examreg WHERE
		damu82ro_nouonlinenouedu_db1.examreg.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("UPDATE damu82ro_nouonlinenouedu_db2.arch_examreg SET vMatricNo = '$new_matno' WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM examreg WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_examreg_result SELECT * FROM damu82ro_nouonlinenouedu_db1.examreg_result WHERE
		damu82ro_nouonlinenouedu_db1.examreg_result.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("UPDATE damu82ro_nouonlinenouedu_db2.arch_examreg_result SET vMatricNo = '$new_matno' WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM examreg_result WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();*/

		$stmt = $mysqli->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_rs_client SELECT * FROM damu82ro_nouonlinenouedu_db1.rs_client WHERE
		damu82ro_nouonlinenouedu_db1.rs_client.vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("UPDATE damu82ro_nouonlinenouedu_db2.arch_rs_client SET vMatricNo = '$new_matno' WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt = $mysqli->prepare("DELETE FROM rs_client WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();
		
		$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

		$stmt->close();
		
		log_actv('Archived records of '.$vMatricNo);	

		return 1;
	}catch(Exception $e) 
	{
		$mysqli->rollback(); //remove all queries from queue if error (undo)
		throw $e;
	}
}?>