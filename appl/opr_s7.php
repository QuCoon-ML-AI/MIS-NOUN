<?php 
require_once('../../fsher/fisher.php');
include('const_def.php');
require_once('lib_fn.php');
require_once('lib_fn_2.php');


$orgsetins = settns();

$mysqli = link_connect_db();

$msg = '';

$vApplicationNo = '';
if (isset($_REQUEST["vApplicationNo"]))
{
	$vApplicationNo = $_REQUEST["vApplicationNo"];
}

if (isset($_REQUEST['chnge']) && $_REQUEST['chnge'] > 0 && isset($_REQUEST["cFacultyId7"]))
{
	$str = '';
	$rtned = '';
	$cFacultyId = $_REQUEST['cFacultyId7'];
		
	$stmt = $mysqli->prepare("SELECT cEduCtgId FROM prog_choice WHERE vApplicationNo = ? and cEduCtgId IN ('PRX','PGZ')");
	$stmt->bind_param("s", $vApplicationNo);
	$stmt->execute();
	$stmt->store_result();
	
	if($stmt->num_rows == 0)
	{
		$beginlevel = '';

		if ($_REQUEST["cdeptold7"] == 'CPE' && $_REQUEST["cEduCtgId"] == 'PGY')
		{
			if ($_REQUEST["amount"] <> 20000)
			{
				return '';
			}
			
			$rtned = s_cadm_cemba();
		}else
		{
			$rtned = s_cadm();
			
			// if ($rtned == "Insufficient Olevel qualification")
			// {
			// 	$rtned1 = s_cadm_mba();
				
			// 	if ($rtned1 <> '')
			// 	{
			// 		$rtned = $rtned1;
			// 	}
			// }

			$rtned1 = s_cadm_mba();
				
			if ($rtned1 <> '' && $rtned == "Insufficient Olevel qualification")
			{
				$rtned = $rtned1;
			}else if ($rtned1 <> '')
			{
				$rtned .= $rtned1;
			}

			

			$rtned1 = s_cadm_maeng();
				
			if ($rtned1 <> '' && $rtned == "Insufficient Olevel qualification")
			{
				$rtned = $rtned1;
			}else if ($rtned1 <> '')
			{
				$rtned .= $rtned1;
			}
		}

				
		$rtned = $rtned ?? '';
		
		//echo $rtned;exit;

		if (!is_bool(strpos($rtned, 'There are no')))
		{
			echo $rtned."Check other departments, possibly in other faculties";
			exit;
		}
		
		if (!is_bool(strpos($rtned, 'Olevel qualification')))
		{
			echo $rtned." Add Olevel qualification by clicking on 'Academic qualification' on the left side of the screen (or above on mobile screen)";
			exit;
		}

		if (!is_bool(strpos($rtned, 'Lack')))
		{
			echo $rtned.'Check other departments, possibly in other faculties'; exit;
		}
		
		if ($rtned == '')
		{
			echo 'No match found'; exit;
		}

		$st = '';
		$prog_arr = array(array());
		$cProgrammeId_collection= '';
		
		$rtned = substr($rtned, 0, strlen($rtned)-1);
		$available_options_0 = explode("~",$rtned);

		if (is_array($available_options_0))
		{
			foreach ($available_options_0 as $value) 
			{
				$available_options_1 = explode(" ",$value);

				if (!isset($available_options_1[0]))
				{
					continue;
				}
				
				$program = $available_options_1[0];
				$entry_level = $available_options_1[1];

				$sReqmtId = trim($available_options_1[2]);
				$sReqmtId = str_pad($sReqmtId, 2, "0", STR_PAD_LEFT);
				//echo $program.' '.$entry_level.' '.$sReqmtId.'-'; continue;

				$stmt = $mysqli->prepare("SELECT p.cProgrammeId,p.vProgrammeDesc,o.vObtQualTitle 
				FROM programme p,obtainablequal o, depts q 
				WHERE p.cObtQualId = o.cObtQualId 
				AND q.cdeptId = p.cdeptId 
				AND p.cProgrammeId = '$program'");
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($cProgrammeId, $vProgrammeDesc, $vObtQualTitle);

				$stmt->fetch();
				$stmt->close();			

				if (($_REQUEST["cEduCtgId"] == "PGY" && $entry_level <> 800) ||
				($_REQUEST["cEduCtgId"] == "PGX" && $entry_level <> 700))
				{
					continue;
				}

				if (is_bool(strpos($cProgrammeId_collection, $program.$entry_level)))
				{
					$cProgrammeId_collection .= $program.$entry_level.' ';

					// if ($cProgrammeId == 'MSC415' || $cProgrammeId == 'MSC416')
					// {
					// 	$st .= "*".$sReqmtId."*".
					// 	str_pad($cProgrammeId,10).
					// 	str_pad($vObtQualTitle,100).
					// 	str_pad($vProgrammeDesc,100).
					// 	str_pad('['.$entry_level.' Level]',15);
					// }else
					// {
						$st .= "*".$sReqmtId."*".
						str_pad($cProgrammeId,10).
						str_pad($vObtQualTitle,20).
						str_pad($vProgrammeDesc,100).
						str_pad('['.$entry_level.' Level]',15);
					//}				
				}
			}
		}
		echo $st; exit;
	}else
	{		
		$stmt = $mysqli->prepare("SELECT a.cEduCtgId, a.cProgrammeId, a.vProgrammeDesc, b.vObtQualTitle 
		FROM programme a, obtainablequal b
		WHERE a.cObtQualId = b.cObtQualId
		AND a.cdeptId = ?
		AND a.cDelFlag = 'N'
		AND a.cEduCtgId IN ('PRX', 'PGZ');");
		
		$stmt->bind_param("s", $_REQUEST["cdeptold7"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($cEduCtgId, $cProgrammeId, $vProgrammeDesc, $vObtQualTitle);
		
		$str = '';
		while($stmt->fetch())
		{
			$str .= "*99*".
			str_pad($cProgrammeId,10).
			str_pad($vObtQualTitle,20).
			str_pad($vProgrammeDesc,100);

			if ($cEduCtgId == 'PRX')
			{
				$str .= str_pad('[1000 Level]',15);
			}else
			{
				$str .= str_pad('[900 Level]',15);
			}
		}			
		$stmt->close();
	}
	
	echo $str; exit;
}?>
