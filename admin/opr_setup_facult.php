<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$currency = eyes_pilled('0');

require_once('var_colls.php');

$what_to_do = '';
if (isset($_REQUEST['what_to_do'])){$what_to_do = $_REQUEST['what_to_do'];}

$cFacultyIdold = '';
if (isset($_REQUEST['cFacultyIdold'])){$cFacultyIdold = $_REQUEST['cFacultyIdold'];}
$cdeptold = '';
if (isset($_REQUEST['cdeptold'])){$cdeptold = $_REQUEST['cdeptold'];}

date_default_timezone_set('Africa/Lagos');
$date2 = date("Y-m-d h:i:s");

if (!isset($_REQUEST['confam']) && isset($_REQUEST['sm']) && isset($_REQUEST['save']) && $_REQUEST['save'] == '1' && $_REQUEST['currency'] == '1')
{
	$orgsetins = settns();

	$feed_back = ''; 
	$sql = '';
	
	$sub_sql_faculty = " cFacultyId = ?,";
	$c = $cFacultyIdold;
	if (isset($_REQUEST["new_cFacultyIdold"]) && $_REQUEST["new_cFacultyIdold"] <> '')
	{
		$sub_sql_faculty = " cFacultyId = ?,";
		$c = $_REQUEST["new_cFacultyIdold"];
	}
	
	$a = $cdeptold;
	$sub_sql_dept = " cdeptId = ?,";
	if (isset($_REQUEST["new_cdeptold"]) && $_REQUEST["new_cdeptold"] <> '')
	{
		$a = $_REQUEST["new_cdeptold"];
		$sub_sql_dept = " cdeptId = ?,";
	}
	
	if ($what_to_do == '0' && $_REQUEST['on_what'] == '0')// create faculty
	{
		$stmt = $mysqli->prepare("select concat(cFacultyId,' ',vFacultyDesc) from faculty where cFacultyId = ? AND cDelFlag = 'N'");
		$stmt->bind_param("s", $_REQUEST["cFacultyIdNew_abrv"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($there_is_cfcode);
		$stmt->fetch();
		$stmt->close();
		
		$stmt = $mysqli->prepare("select concat(cFacultyId,' ',vFacultyDesc) from faculty where vFacultyDesc = ? AND cDelFlag = 'N'");
		$stmt->bind_param("s", $_REQUEST["cFacultyDescNew"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($there_is_dfcode);
		$stmt->fetch();
		$stmt->close();
		
		if (isset($there_is_cfcode))
		{
			$feed_back = 'A faculty ('.$there_is_cfcode.') with code already exist';
		}else if (isset($there_is_dfcode))
		{
			$feed_back = 'A faculty ('.$there_is_dfcode.') with description already exist';
		}else
		{			
			$a = strtoupper($_REQUEST["cFacultyIdNew_abrv"]);
			$b = ucwords($_REQUEST["cFacultyDescNew"]);
							
			$stmt = $mysqli->prepare("INSERT INTO faculty
			SET cFacultyId = ?,
			vFacultyDesc = ?");
			$stmt->bind_param("ss", $a, $b);
			$stmt->execute();
			$stmt->close();
            
			$feed_back = 'New faculty created successfully';
		}
	}else if ($what_to_do == '0' && $_REQUEST['on_what'] == '1')//create dept
	{
		$a = strtoupper($_REQUEST["cFacultyIdNew_abrv"]);
		
		$stmt = $mysqli->prepare("select concat(cdeptId,' ',vdeptDesc) from depts where cdeptId = ? AND cDelFlag = 'N'");
		$stmt->bind_param("s", $a);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($there_is_cfcode);
		$stmt->fetch();
		$stmt->close();
		
		$stmt = $mysqli->prepare("select concat(cdeptId,' ',vdeptDesc) from depts where vdeptDesc = ? AND cDelFlag = 'N'");
		$stmt->bind_param("s", $_REQUEST["cDeptDescNew"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($there_is_dfcode);
		$stmt->fetch();
		$stmt->close();
		
		if (isset($there_is_cfcode))
		{
			$feed_back = 'A department ('.$there_is_cfcode.') with code already exist';
		}else if (isset($there_is_dfcode))
		{
			$feed_back = 'A department ('.$there_is_dfcode.') with description already exist';
		}else
		{
			$a = strtoupper($_REQUEST["cFacultyIdNew_abrv"]);
			$b = ucwords(strtolower($_REQUEST["cDeptDescNew"]));
			
			$stmt = $mysqli->prepare("insert into depts set cdeptId = ?, cFacultyId = ?, vdeptDesc = ?");
			$stmt->bind_param("sss", $a, $_REQUEST["cFacultyIdold"], $b);
			$stmt->execute();
			$stmt->close();
            
			$feed_back = 'New department created successfully';
		}
	}else if ($what_to_do == '0' && $_REQUEST['on_what'] == '2')//create progs
	{
		$a = strtoupper($_REQUEST['cprogrammeIdNew']);
		
		$stmt = $mysqli->prepare("select concat(cProgrammeId,' ',vProgrammeDesc) from programme where cProgrammeId = ?");
		$stmt->bind_param("s", $a);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($there_is_cfcode);
		$stmt->fetch();
		$stmt->close();
		
		$stmt = $mysqli->prepare("select concat(cProgrammeId,' ',vProgrammeDesc) from programme where vProgrammeDesc = ? AND cObtQualId = ?");
		$stmt->bind_param("ss", $_REQUEST['cprogrammedescNew'], $cObtQualId);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($there_is_dfcode);
		$stmt->fetch();
		$stmt->close();
	
		if (isset($there_is_cfcode))
		{
			$feed_back = 'A programme ('.$there_is_cfcode.') with programme code already exist';
		}else if (isset($there_is_dfcode))
		{
			$feed_back = 'A programme ('.$there_is_dfcode.') with programme title already exist';
		}else
		{			
			$stmt = $mysqli->prepare("select b.cEduCtgId from obtainablequal a, educationctg b where a.cEduCtgId = b.cEduCtgId and a.cObtQualId = ?");
			$stmt->bind_param("s", $_REQUEST['cprogrammetitleNew']);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($cEduCtgId);
			$stmt->fetch();
			$stmt->close();
			
			//$sqlinsert_sub = '';
			// foreach ($_REQUEST['study_mode'] as $key => $value){ $sqlinsert_sub .= "$value,";}
			// $sqlinsert_sub =  substr($sqlinsert_sub, 0, strlen($sqlinsert_sub)-1);
			
			if ($cEduCtgId == '')
			{
				$cEduCtgId = substr($_REQUEST['cprogrammetitleNew'], 0, 3);
			}

			$cObtQualId = substr($_REQUEST['cprogrammetitleNew'], 3, 3);

			$a = strtoupper($_REQUEST["cprogrammeIdNew"]);
			$b = ucwords($_REQUEST["cprogrammedescNew"]);
			
			$stmt = $mysqli->prepare("INSERT INTO programme
			SET cdeptId = ?,
			cEduCtgId = '".$cEduCtgId."',
			cProgrammeId = ?,
			iBeginLevel = ?,
			iEndLevel = ?,
			grdtce = ?,
			grdtce2 = ?,
			max_crload = ?,
			no_sem = ?,
			tgst_tcu = ?,
			tbasic_tcu = ?,
			tfaculty_tcu = ?,
			tcc_tcu = ?,
			telect_tcu = ?,
			tsiwess_tcu = ?,
			tentrep_tcu = ?,
			tcompul_tcu = ?,
			treq_tcu = ?,
			telec_tcu = ?,
			tgs_tcu = ?,
			cObtQualId = ?,
			vProgrammeDesc = ?,
			dtCreateDate = '$date2'");
			$stmt->bind_param("ssiiiiiiiiiiiiiiiiiss", $_REQUEST['cdeptold'], $a, $_REQUEST["BeginLevel"], $_REQUEST["EndLevel"], $_REQUEST["grdtce"], $_REQUEST["grdtce2"], $_REQUEST["max_crload"], $_REQUEST["no_semester"], $_REQUEST["tgst_tcu"], $_REQUEST["tbasic_tcu"], $_REQUEST["tfaculty_tcu"], $_REQUEST["tcc_tcu"], $_REQUEST["telect_tcu"], $_REQUEST["tsiwess_tcu"], $_REQUEST["tentrep_tcu"], $_REQUEST["tcompul_tcu"], $_REQUEST["treq_tcu"], $_REQUEST["telec_tcu"], $_REQUEST["tgs_tcu"], $cObtQualId, $b);
			$stmt->execute();
			$stmt->close();
			
			$feed_back = 'New programme created successfully';
		}
	}else if ($what_to_do == '0' && $_REQUEST['on_what'] == '3')//create course
	{
		$a = strtoupper($_REQUEST['cCourseIdNew']);
		
		$stmt = $mysqli->prepare("SELECT concat(cCourseId,' ',vCourseDesc) FROM courses WHERE cCourseId = ? AND cdel = 'N'");
		$stmt->bind_param("s", $a);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($there_is_cfcode);
		$stmt->fetch();
		$stmt->close();
		
		$stmt = $mysqli->prepare("SELECT concat(cCourseId,' ',vCourseDesc) FROM courses WHERE vCourseDesc = ? AND cdel = 'N'");
		$stmt->bind_param("s", $_REQUEST['cCoursetitleNew']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($there_is_dfcode);
		$stmt->fetch();
		$stmt->close();
		
		if (isset($there_is_cfcode))
		{
			$feed_back = 'A course ('.$there_is_cfcode.') with course code already exist';
		}else if (isset($there_is_dfcode))
		{
			$feed_back = 'A course ('.$there_is_dfcode.') with course title already exist';
		}else
		{
			$b = strtoupper($_REQUEST["cCourseIdNew"]);
			$c = ucwords(strtolower($_REQUEST["cCoursetitleNew"]));
			
			$stmt = $mysqli->prepare("REPLACE INTO courses
			set cFacultyId = ?,
			cdeptId = ?,
			cCourseId = ?,
			vCourseDesc = ?,
			iCreditUnit = ?,
			tSemester = ?,
			ancilary_type = ?");
			$stmt->bind_param("ssssiis", $_REQUEST["cFacultyIdold"], $_REQUEST["cdeptold"], $b, $c, $_REQUEST["iCreditUnit"], $_REQUEST["tSemester_h2"], $_REQUEST["courseclass"]);
			$stmt->execute();
			$stmt->close();
			
			$feed_back = 'New course created successfully';
		}
	}else if ($what_to_do == '1' && $_REQUEST['on_what'] == '0')//edit fac
	{
		$isthere = 0;
		if ($_REQUEST["cFacultyIdold"] <> $_REQUEST["cFacultyIdNew_abrv"])
		{
			$a= strtoupper($_REQUEST['cFacultyIdNew_abrv']);
			
			$stmt = $mysqli->prepare("select concat(cFacultyId,' ',vFacultyDesc) vFacultyDesc from faculty where cFacultyId = ? and vFacultyDesc <> ?");
			$stmt->bind_param("ss", $a, $_REQUEST["cFacultyDescNew"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($a);
			
			if ($stmt->num_rows > 0)
			{
				$stmt->fetch();
				$feed_back = 'A faculty ('.$a.') with this code already exist';
			}
			$isthere = $stmt->num_rows;
			$stmt->close();
		}else if ($_REQUEST["cFacultyDescNew_h"] <> $_REQUEST["cFacultyDescNew"])
		{
			$a = ucwords(strtolower($_REQUEST['cFacultyDescNew_h']));
			
			$stmt = $mysqli->prepare("select concat(cFacultyId,' ',vFacultyDesc) vFacultyDesc from faculty where vFacultyDesc = ? and cFacultyId <> ?");
			$stmt->bind_param("ss", $a, $_REQUEST["cFacultyIdNew_abrv"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($a);
			
			if ($stmt->num_rows > 0)
			{
				$stmt->fetch();
				$feed_back = 'A faculty ('.$a.') with this description already exist';
			}
			$isthere = $stmt->num_rows;
			$stmt->close();
		}
		
		
		if ($isthere == 0)
		{
			$a = strtoupper($_REQUEST["cFacultyIdNew_abrv"]);
			try
			{
				$mysqli->autocommit(FALSE); //turn on transactions
				
				$stmt = $mysqli->prepare("update criteriadetail
				set cCriteriaId = ?
				where cCriteriaId = ?");
				$stmt->bind_param("ss", $a, $_REQUEST["cFacultyIdold"]);
				$stmt->execute();
				$stmt->close();
				
				$stmt = $mysqli->prepare("update criteriasubject
				set cCriteriaId = ?
				where cCriteriaId = ?");
				$stmt->bind_param("ss", $a, $_REQUEST["cFacultyIdold"]);
				$stmt->execute();
				$stmt->close();
				
				$stmt = $mysqli->prepare("update courses 
				set cFacultyId = ? 
				where cFacultyId = ?");
				$stmt->bind_param("ss", $a, $_REQUEST["cFacultyIdold"]);
				$stmt->execute();
				$stmt->close();

				$stmt = $mysqli->prepare("update depts
				set cFacultyId = ?
				where cFacultyId = ?");
				$stmt->bind_param("ss", $a, $_REQUEST["cFacultyIdold"]);
				$stmt->execute();
				$stmt->close();

				$stmt = $mysqli->prepare("update prog_choice
				set cFacultyId = ?
				where cFacultyId = ?");
				$stmt->bind_param("ss", $a, $_REQUEST["cFacultyIdold"]);
				$stmt->execute();
				$stmt->close();

				$stmt1 = $mysqli->prepare("UPDATE programme
				SET cProgrammeId = CONCAT(?,RIGHT(cProgrammeId,3))
				WHERE LEFT(cProgrammeId,3) = ?");
				$stmt1->bind_param("ss", $a, $_REQUEST["cFacultyIdold"]);
				$stmt1->execute();
				$stmt1->close();

				$stmt = $mysqli->prepare("update userlogin
				set cFacultyId = ?, act_date = '$date2'
				where cFacultyId = ?");
				$stmt->bind_param("ss", $a, $_REQUEST["cFacultyIdold"]);
				$stmt->execute();
				$stmt->close();

				$a = strtoupper($_REQUEST["cFacultyIdNew_abrv"]);
				$b = ucwords(strtolower($_REQUEST["cFacultyDescNew"]));

				$stmt = $mysqli->prepare("update faculty
				set cFacultyId = ?,
				vFacultyDesc = ?
				where cFacultyId = ?");
				$stmt->bind_param("sss", $a, $b, $_REQUEST["cFacultyIdold"]);
				$stmt->execute();
				$stmt->close();
				
				$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries			
				
				$feed_back = 'Faculty name updated successfully';
			}catch(Exception $e)
			{
			  $mysqli->rollback(); //remove all queries from queue if error (undo)
			  throw $e;
			}
		}
	}else if ($what_to_do == '1' && $_REQUEST['on_what'] == '1')//edit dept
	{
		$isthere = 0;
		if (strtolower($_REQUEST["cdeptold"]) <> strtolower($_REQUEST["cFacultyIdNew_abrv"]))
		{
			$a = strtoupper($_REQUEST['cFacultyIdNew_abrv']);
			
			$stmt = $mysqli->prepare("select concat(cdeptId,' ',vdeptDesc) vdeptDesc from depts where cdeptId = ? and (cFacultyId <> ? or cFacultyId = ?)");
			$stmt->bind_param("sss", $a, $_REQUEST["cFacultyIdold"], $_REQUEST["new_cFacultyIdold"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($a);
			
			if ($stmt->num_rows > 0)
			{
				$stmt->fetch();
				$feed_back = 'A department ('.$a.') with this code already exist';
			}
			$isthere = $stmt->num_rows;
			$stmt->close();
		}else if (strtolower($_REQUEST["cDeptDescNew_h"]) <> strtolower($_REQUEST["cDeptDescNew"]))
		{
			$a = strtoupper($_REQUEST['cDeptDescNew']);
			
			$stmt = $mysqli->prepare("select concat(cdeptId,' ',vdeptDesc) vdeptDesc from depts where lcase(vdeptDesc) = ?");
			$stmt->bind_param("s", $a);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($b);
			
			if ($stmt->num_rows > 0)
			{
				$stmt->fetch();
				$feed_back = 'A department ('.$b.') with this description already exist';
			}
			$isthere = $stmt->num_rows;
			$stmt->close();
		}
		
		if ($isthere == 0)
		{
			$a = strtoupper($_REQUEST["cFacultyIdNew_abrv"]);
			$sub_sql_dept = " cdeptId = ? ";
			if (isset($_REQUEST["new_cdeptold"]) && $_REQUEST["new_cdeptold"] <> '')
			{
				$sub_sql_dept = " cdeptId = ? ";
				$a = strtoupper($_REQUEST["cdeptold"]);
			}
			$b = strtoupper(($_REQUEST["cFacultyIdNew_abrv"]));
			
			try
			{				
				$mysqli->autocommit(FALSE); //turn on transactions
				
				$stmt1 = $mysqli->prepare("UPDATE IGNORE courses
				set $sub_sql_faculty
				cdeptId = ?,
				cCourseId = CONCAT(?, RIGHT(cCourseId,3))
				where $sub_sql_dept");
				$stmt1->bind_param("ssss", $c, $a, $b, $a);
				$stmt1->execute();
				$stmt1->close();
								
				$stmt1 = $mysqli->prepare("UPDATE IGNORE progcourse
				SET $sub_sql_dept,
				cCourseId = CONCAT(?, RIGHT(cCourseId,3)),
				act_date = '$date2'
				WHERE cdeptId = ?");
				$stmt1->bind_param("sss", $a, $a, $_REQUEST["cdeptold"]);
				$stmt1->execute();
				$stmt1->close();
								
				$stmt1 = $mysqli->prepare("UPDATE IGNORE programme
				set $sub_sql_dept
				where cdeptId = ?");
				$stmt1->bind_param("ss", $a, $_REQUEST["cdeptold"]);
				$stmt1->execute();
				$stmt1->close();
				
				$stmt1 = $mysqli->prepare("update userlogin
				set $sub_sql_dept
				where cdeptId = ?");
				$stmt1->bind_param("ss", $a, $_REQUEST["cdeptold"]);
				$stmt1->execute();
				$stmt1->close();
				
				if (trim($_REQUEST["cDeptDescNew"]) == '')
				{
					$stmt1 = $mysqli->prepare("UPDATE IGNORE depts
					set ".substr($sub_sql_faculty, 0, strlen($sub_sql_faculty)-1)."
					where cdeptId = ?");
					$stmt1->bind_param("ss", $c, $_REQUEST["cdeptold"]);
				}else
				{
					$b = ucwords($_REQUEST["cDeptDescNew"]);
					$a = strtoupper($_REQUEST["cFacultyIdNew_abrv"]);

					$stmt1 = $mysqli->prepare("UPDATE IGNORE depts
					set $sub_sql_faculty
					vdeptDesc = ?,
					cdeptId = ?
					where cdeptId = ?");
					$stmt1->bind_param("ssss", $c, $b, $a, $_REQUEST["cdeptold"]);
				}
				$stmt1->execute();
				$stmt1->close();
			
				$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
				
				$feed_back = 'Department updated successfully';
			}catch(Exception $e)
			{
			  $mysqli->rollback(); //remove all queries from queue if error (undo)
			  throw $e;
			}
		}
	}else if ($what_to_do == '1' && $_REQUEST['on_what'] == '2')//edit progs
	{
		$sub_sql_dept = " cdeptId = ?, ";
		$a = strtoupper($_REQUEST["cdeptold"]);
		if (isset($_REQUEST["new_cdeptold"]) && $_REQUEST["new_cdeptold"] <> '')
		{
			$sub_sql_dept = " cdeptId = ?, ";
			$a = strtoupper($_REQUEST["new_cdeptold"]);
		}
		
		$isthere = 0;
		if ($_REQUEST["cprogrammeIdNew"] <> strtoupper($_REQUEST["cprogrammeIdold"]))
		{
			$stmt = $mysqli->prepare("select concat(cProgrammeId,' ',b.vObtQualTitle,' ',vProgrammeDesc) vProgrammeDesc 
			from programme a, obtainablequal b where a.cObtQualId = b.cObtQualId and cProgrammeId = ?");
			$stmt->bind_param("s", $_REQUEST["cprogrammeIdNew"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($vProgrammeDesc);
			
			if ($stmt->num_rows > 0)
			{
				$stmt->fetch();
				$feed_back = 'A programme ('.$vProgrammeDesc.') with this code already exist';
			}
			$isthere = $stmt->num_rows;
			$stmt->close();
		}else if ($_REQUEST["cprogrammedescNew_h"] <> $_REQUEST["cprogrammedescNew"])
		{
			$stmt = $mysqli->prepare("select concat(cProgrammeId,' ',b.vObtQualTitle,' ',vProgrammeDesc) vProgrammeDesc 
			from programme a, obtainablequal b where a.cObtQualId = b.cObtQualId and vProgrammeDesc = ?");
			$stmt->bind_param("s", $_REQUEST["cprogrammedescNew"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($vProgrammeDesc);
			
			if ($stmt->num_rows > 0)
			{
				$stmt->fetch();
				$feed_back = 'A programme ('.$vProgrammeDesc.') with this title already exist';
			}
			$isthere = $stmt->num_rows;
			$stmt->close();
		}
		
		if ($isthere == 0)
		{  
			try
			{				
				$mysqli->autocommit(FALSE); //turn on transactions
				
				$b = strtoupper(($_REQUEST["cprogrammeIdNew"]));
				
				$stmt = $mysqli->prepare("UPDATE IGNORE progcourse
				set $sub_sql_dept
				cProgrammeId = ?,
				act_date = '$date2'
				where cProgrammeId = ?");
				$stmt->bind_param("sss", $a, $b, $_REQUEST["cprogrammeIdNew"]);
				$stmt->execute();
				$stmt->close();
				
				$str_1 = '';
				$search = "%{$_REQUEST["cprogrammeIdold"]}%";
				
				$stmt = $mysqli->prepare("select b.cEduCtgId from obtainablequal a, educationctg b where a.cEduCtgId = b.cEduCtgId and a.cObtQualId = ?");
				$stmt->bind_param("s", $_REQUEST['cprogrammetitleNew']);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($cEduCtgId);
				$stmt->fetch();
				$stmt->close();
				
				$sqlinsert_sub = '';
				
				$b = strtoupper($_REQUEST["cprogrammeIdNew"]);
				$c = ucwords($_REQUEST["cprogrammedescNew"]);				
				
				$stmt = $mysqli->prepare("UPDATE programme
				SET $sub_sql_dept
				cEduCtgId = '".$cEduCtgId."',
				cProgrammeId = ?,
				iBeginLevel = ?,
				iEndLevel = ?,
				grdtce = ?,
				grdtce2 = ?,
				max_crload = ?,
				no_sem = ?,
				tgst_tcu = ?,
				tbasic_tcu = ?,
				tfaculty_tcu = ?,
				tcc_tcu = ?,
				telect_tcu = ?,
				tsiwess_tcu = ?,
				tentrep_tcu = ?,
				tcompul_tcu = ?,
				treq_tcu = ?,
				telec_tcu = ?,
				tgs_tcu = ?,
				cObtQualId = ?,
				vProgrammeDesc = ?
				WHERE cProgrammeId = ?");
				$stmt->bind_param("ssiiiiiiiiiiiiiiiiisss", $a, $b, $_REQUEST["BeginLevel"], $_REQUEST["EndLevel"], $_REQUEST["grdtce"], $_REQUEST["grdtce2"], $_REQUEST["max_crload"], $_REQUEST["no_semester"], $_REQUEST["tgst_tcu"], $_REQUEST["tbasic_tcu"], $_REQUEST["tfaculty_tcu"], $_REQUEST["tcc_tcu"], $_REQUEST["telect_tcu"], $_REQUEST["tsiwess_tcu"], $_REQUEST["tentrep_tcu"], $_REQUEST["tcompul_tcu"], $_REQUEST["treq_tcu"], $_REQUEST["telec_tcu"], $_REQUEST["tgs_tcu"], $_REQUEST['cprogrammetitleNew'], $c, $_REQUEST["cprogrammeIdold"]);
				$stmt->execute();
				$stmt->close();			
				
				$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
				
				$feed_back = 'Programme updated successfully';
			}catch(Exception $e)
			{
			  $mysqli->rollback(); //remove all queries from queue if error (undo)
			  throw $e;
			}
		}
	}else if ($what_to_do == '1' && $_REQUEST['on_what'] == '3')//edit course
	{
		$sub_sql_dept = " cdeptId = ?, ";
		$a = strtoupper($_REQUEST["cdeptold"]);
		if (isset($_REQUEST["new_cdeptold"]) && $_REQUEST["new_cdeptold"] <> '')
		{
			$sub_sql_dept = " cdeptId = ?, ";
			$a = strtoupper($_REQUEST["new_cdeptold"]);
		}
		
		$ccourseIdold = $_REQUEST["ccourseIdold"];
		if (substr($_REQUEST["ccourseIdold"],0,1) == '$'){$ccourseIdold = substr($_REQUEST["ccourseIdold"],1,strlen($_REQUEST["ccourseIdold"])-1);}
		
		$isthere = 0;
		if ($ccourseIdold <> $_REQUEST["cCourseIdNew"])
		{
			$stmt = $mysqli->prepare("select concat(cCourseId,' ',vCourseDesc) vCourseDesc 
			from courses where cCourseId = ?");
			$stmt->bind_param("s", $_REQUEST['cCourseIdNew']);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($vCourseDesc);
			
			if ($stmt->num_rows > 0)
			{
				$stmt->fetch();
				$feed_back = 'A course ('.$vCourseDesc.') with this code already exist';
			}
			$isthere = $stmt->num_rows;
			$stmt->close();
		}else if (ucwords(strtolower($_REQUEST["cCoursetitleNew"])) <> $_REQUEST["cCoursetitleNew_h"])
		{
			$a = ucwords(strtolower($_REQUEST["cCoursetitleNew"]));
			
			$stmt = $mysqli->prepare("select concat(cCourseId,' ',vCourseDesc) vCourseDesc 
			from courses where vCourseDesc = ?");
			$stmt->bind_param("s", $a);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($vCourseDesc);
			if ($stmt->num_rows > 0)
			{
				$stmt->fetch();
				$feed_back = 'A course ('.$vCourseDesc.') with this title already exist';
			}
			$isthere = $stmt->num_rows;
			$stmt->close();
		}
		
		if ($isthere == 0)
		{
			$sub_sql_prog = "";
			
			$b = $_REQUEST["cprogrammeIdold"];
			$sub_sql_prog = " cprogrammeId = ?,";
			if (isset($_REQUEST["new_cprogrammeIdold"]) && $_REQUEST["new_cprogrammeIdold"] <> '')
			{
				$b = $_REQUEST["new_cprogrammeIdold"];
				$sub_sql_prog = " cprogrammeId = ?,";
			}
			
			$d = strtoupper($_REQUEST["cCourseIdNew"]);
			$e = addslashes(ucwords(strtolower($_REQUEST["cCoursetitleNew"])));

			$stmt = $mysqli->prepare("UPDATE IGNORE courses
			set $sub_sql_faculty
			$sub_sql_dept
			cCourseId = ?,
			vCourseDesc = ?,
			iCreditUnit = ?,
			tSemester = ?,
			ancilary_type = ?
			where cCourseId = ?");
			$stmt->bind_param("ssssiiss", $c, $a, $d, $e, $_REQUEST["iCreditUnit"], $_REQUEST["tSemester_h2"], $ccourseIdold, $_REQUEST["courseclass"]);
			$stmt->execute();
			$stmt->close();
			
			$feed_back = 'Course updated successfully';
		}
	}else if ($what_to_do == '3' && $_REQUEST['on_what'] == '3')//add/remove course from prog
	{		
		if ($_REQUEST['selected_curriculum'] == '1')
		{
			$new_curr = " AND cAcademicDesc <= 2023";
		}else if ($_REQUEST['selected_curriculum'] == '2')
		{
			$new_curr = " AND cAcademicDesc = 2024";
		}
		
		try
		{
			$mysqli->autocommit(FALSE); //turn on transactions
			
			$stmt = $mysqli->prepare("DELETE FROM progcourse 
			WHERE cprogrammeId = ? 
			AND siLevel = ? 
			AND tSemester = ?
			$new_curr");
			$stmt->bind_param("sss", $_REQUEST["cprogrammeIdold"], $_REQUEST["courseLevel"], $_REQUEST["coursesemester"]);
			$stmt->execute();
			$stmt->close();
			
			if ($_REQUEST['selected_curriculum'] == '1')
			{
				$new_curr = " cAcademicDesc = '2023'";
			}else if ($_REQUEST['selected_curriculum'] == '2')
			{
				$new_curr = " cAcademicDesc = '2024'";
			}

			$stmt = $mysqli->prepare("REPLACE INTO progcourse SET
			cdeptId = ?,
			cprogrammeId = ?,
			siLevel = ?, 
			tSemester = ?, 
			cCourseId = ?,
			cCategory = ?,
			$new_curr,
			cdel = 'N',
			retActive = ?,
			act_date = '$date2'");
			
			for ($k = 0; $k <= $_REQUEST["numOfiputTag"]; $k++)
			{
				if (isset($_REQUEST["regCourses$k"."_ec"]))
				{
					$regCourses = $_REQUEST["regCourses$k"."_ec"];
				}else if (isset($_REQUEST["regCourses$k"]))
				{
					$regCourses = $_REQUEST["regCourses$k"];
				}
				if (isset($regCourses))
				{
					$cusStatus = substr($regCourses,0,1);
					$retActive = substr($regCourses,1,1);
					$cCourseId = substr($regCourses,2,6);
										
					$stmt->bind_param("ssiisss", $_REQUEST["cdeptold"], $_REQUEST["cprogrammeIdold"], $_REQUEST["courseLevel"], $_REQUEST["coursesemester"], $cCourseId, $cusStatus, $retActive);
					$stmt->execute();       
				}
			}
			$stmt->close();
			$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
			
			$feed_back = 'Course(s) added to selected programme successfully';
		}catch(Exception $e)
		{
		  $mysqli->rollback(); //remove all queries from queue if error (undo)
		  throw $e;
		}
	}
	
	log_actv($feed_back);
	echo $feed_back;
}else if (isset($_REQUEST['save']) && $_REQUEST['save'] == '2' && $_REQUEST['currency'] == '1')
{
	if ($_REQUEST['selected_curriculum'] == '1')
	{
		$new_curr = " AND cAcademicDesc <= 2023";
	}else if ($_REQUEST['selected_curriculum'] == '1')
	{
		$new_curr = " AND cAcademicDesc = 2024";
	}
	
	try
	{
		$mysqli->autocommit(FALSE); //turn on transactions
		
		$stmt_arch = $mysqli->prepare("REPLACE INTO progcourse_arch SELECT cdeptId, 
		cProgrammeId, 
		cCourseId, 
		cCategory, 
		siLevel, 
		tSemester,
		cAcademicDesc, 
		cdel, 
		'$date2' FROM progcourse 
		WHERE cdeptId = ?
		AND cprogrammeId = ?
		AND siLevel = ?
		AND tSemester = ?
		$new_curr");
		$stmt_arch->bind_param("ssii", $_REQUEST["cdeptold"], $_REQUEST["cprogrammeIdold"], $_REQUEST["courseLevel"], $_REQUEST["coursesemester_h2"]);
		$stmt_arch->execute();
		$stmt_arch->close();
		
		$stmt_del = $mysqli->prepare("DELETE FROM progcourse 
		WHERE cdeptId = ? 
		AND cprogrammeId = ?
		AND siLevel = ?
		AND tSemester = ?
		$new_curr");
		$stmt_del->bind_param("ssii", $_REQUEST["cdeptold"], $_REQUEST["cprogrammeIdold"], $_REQUEST["courseLevel"], $_REQUEST["coursesemester_h2"]);
		$stmt_del->execute();
		$stmt_del->close();

		$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
		
		echo 'All registrable courses cleared successfully';
	}catch(Exception $e)
	{
	  $mysqli->rollback(); //remove all queries from queue if error (undo)
	  throw $e;
	}
}else if (isset($_REQUEST['confam']) && $_REQUEST['confam'] == '1' && $_REQUEST['currency'] == '1')
{
	if ($what_to_do == '2' && $_REQUEST['on_what'] == '0' && $_REQUEST['confam'] == '1')//delete fac
	{
		$stmt = $mysqli->prepare("select * from s_m_t where cFacultyId = ?");
		$stmt->bind_param("s", $_REQUEST['cFacultyIdold']); 
		$stmt->execute();
		$stmt->store_result();
			
		if ($stmt->num_rows > 0)
		{
			$stmt->close();
			echo 'Faculty cannot be deleted. There are students';
			exit;
		}
		$stmt->close();
		
		try 
		{
			$mysqli->autocommit(FALSE); //turn on transactions
		
			$stmt = $mysqli->prepare("DELETE FROM courses WHERE cFacultyId = ?");		
			$stmt->bind_param("s", $_REQUEST["cFacultyIdold"]);
			$stmt->execute(); 
			$stmt->close();

			$stmt = $mysqli->prepare("DELETE FROM progcourse WHERE cdeptId in (SELECT cdeptId FROM depts WHERE cFacultyId = ?)");		
			$stmt->bind_param("s", $_REQUEST["cFacultyIdold"]);
			$stmt->execute(); 
			$stmt->close();

			$stmt = $mysqli->prepare("DELETE FROM criteriadetail WHERE cCriteriaId IN (SELECT b.cProgrammeId FROM depts a, programme b WHERE a.cdeptId = b.cdeptId AND cFacultyId = ?)");
			$stmt->bind_param("s", $_REQUEST["cFacultyIdold"]);
			$stmt->execute(); 
			$stmt->close();
			
			$stmt = $mysqli->prepare("DELETE FROM criteriasubject WHERE cCriteriaId IN (SELECT b.cProgrammeId FROM depts a, programme b WHERE a.cdeptId = b.cdeptId AND cFacultyId = ?)");
			$stmt->bind_param("s", $_REQUEST["cFacultyIdold"]);
			$stmt->execute(); 
			$stmt->close();

			$stmt = $mysqli->prepare("DELETE FROM depts WHERE cFacultyId = ?");
			$stmt->bind_param("s", $_REQUEST["cFacultyIdold"]);
			$stmt->execute(); 
			$stmt->close();

			$stmt = $mysqli->prepare("DELETE FROM faculty WHERE cFacultyId = ?");
			$stmt->bind_param("s", $_REQUEST["cFacultyIdold"]);
			$stmt->execute(); 
			$stmt->close();
			
			$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
			
			$feed_back = 'Faculty deleted successfully';
		}catch(Exception $e)
		{
			 $mysqli->rollback(); //remove all queries from queue if error (undo)
	  		throw $e;
		}
	}else if ($what_to_do == '2' && $_REQUEST['on_what'] == '1' && $_REQUEST['confam'] == '1')//delete dept
	{
		$stmt = $mysqli->prepare("select * from s_m_t where cdeptId = ?");
		$stmt->bind_param("s", $_REQUEST['cdeptold']); 
		$stmt->execute();
		$stmt->store_result();
			
		if ($stmt->num_rows > 0)
		{
			$stmt->close();
			echo 'Department not deleted. There are students';
			exit;
		}
		$stmt->close();

		try 
		{
			$mysqli->autocommit(FALSE); //turn on transactions
			
			$stmt = $mysqli->prepare("DELETE FROM courses WHERE cdeptId = ?");
			$stmt->bind_param("s", $_REQUEST["cdeptold"]);
			$stmt->execute(); 
			$stmt->close();

			$stmt = $mysqli->prepare("DELETE FROM progcourse WHERE cdeptId = ?");
			$stmt->bind_param("s", $_REQUEST["cdeptold"]);
			$stmt->execute(); 
			$stmt->close();

			$stmt = $mysqli->prepare("DELETE FROM criteriadetail WHERE cCriteriaId IN (SELECT cProgrammeId FROM programme WHERE cdeptId = ?)");
			$stmt->bind_param("s", $_REQUEST["cdeptold"]);
			$stmt->execute(); 
			$stmt->close();
			
			$stmt = $mysqli->prepare("DELETE FROM criteriasubject WHERE cCriteriaId IN (SELECT cProgrammeId FROM programme WHERE cdeptId = ?)");
			$stmt->bind_param("s", $_REQUEST["cdeptold"]);
			$stmt->execute(); 
			$stmt->close();

			$stmt = $mysqli->prepare("DELETE FROM programme WHERE cdeptId = ?");
			$stmt->bind_param("s", $_REQUEST["cdeptold"]);
			$stmt->execute(); 
			$stmt->close();

			$stmt = $mysqli->prepare("DELETE FROM depts WHERE cdeptId = ?");
			$stmt->bind_param("s", $_REQUEST["cdeptold"]);
			$stmt->execute(); 
			$stmt->close();
			
			$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
			
			$feed_back = 'Department deleted successfully';
		}catch(Exception $e)
		{
			 $mysqli->rollback(); //remove all queries from queue if error (undo)
	  		throw $e;
		}
	}else if ($what_to_do == '2' && $_REQUEST['on_what'] == '2' && $_REQUEST['confam'] == '1')//delete progs
	{
		$stmt = $mysqli->prepare("select * from s_m_t where cProgrammeId = ?");
		$stmt->bind_param("s", $_REQUEST['cprogrammeIdold']); 
		$stmt->execute();
		$stmt->store_result();
			
		if ($stmt->num_rows > 0)
		{
			$stmt->close();
			echo 'Programme not deleted. There are students';
			exit;
		}
		$stmt->close();

		try 
		{
			$mysqli->autocommit(FALSE); //turn on transactions
			
			$stmt = $mysqli->prepare("DELETE FROM progcourse WHERE cProgrammeId = ?");
			$stmt->bind_param("s", $_REQUEST["cprogrammeIdold"]);
			$stmt->execute(); 
			$stmt->close();

			$stmt = $mysqli->prepare("DELETE FROM criteriadetail WHERE cCriteriaId = ?");		
			$stmt->bind_param("s", $_REQUEST["cprogrammeIdold"]);
			$stmt->execute(); 
			$stmt->close();

			$stmt = $mysqli->prepare("DELETE FROM criteriasubject WHERE cCriteriaId = ?");
			$stmt->bind_param("s", $_REQUEST["cprogrammeIdold"]);
			$stmt->execute(); 
			$stmt->close();

			$stmt = $mysqli->prepare("DELETE FROM programme WHERE cProgrammeId = ?");
			$stmt->bind_param("s", $_REQUEST["cprogrammeIdold"]);
			$stmt->execute(); 
			$stmt->close();

			$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
			
			$feed_back = 'Programme deleted successfully';
		}catch(Exception $e)
		{
			 $mysqli->rollback(); //remove all queries from queue if error (undo)
	  		throw $e;
		}
	}else if ($what_to_do == '2' && $_REQUEST['on_what'] == '3' && $_REQUEST['confam'] == '1')//delete course
	{
		try 
		{
			$mysqli->autocommit(FALSE); //turn on transactions
			
			//$stmt = $mysqli->prepare("update progcourse set cdel = 'Y' where cCourseId = ? and cProgrammeId = ?");
			$stmt = $mysqli->prepare("DELETE FROM progcourse WHERE cCourseId = ? AND cProgrammeId = ?");
			$stmt->bind_param("ss", $_REQUEST["ccourseIdold"], $_REQUEST["cprogrammeIdold"]);
			$stmt->execute(); 
			$stmt->close();

			//$stmt = $mysqli->prepare("update courses set cdel = 'Y' where cCourseId = ?");
			$stmt = $mysqli->prepare("DELETE FROM courses WHERE cCourseId = ?");
			$stmt->bind_param("s", $_REQUEST["ccourseIdold"]);
			$stmt->execute(); 
			$stmt->close();
			
			$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
			
			$feed_back = 'Course deleted from programme successfully';
		}catch(Exception $e)
		{
			 $mysqli->rollback(); //remove all queries from queue if error (undo)
	  		throw $e;
		}
	}
	
	echo $feed_back;
	log_actv($feed_back);
}else if (isset($_REQUEST['cprogrammeIdold']) && isset($_REQUEST['frm_upd']) && $_REQUEST['frm_upd'] == 'qual')
{
	$stmt = $mysqli->prepare("SELECT cObtQualId, iBeginLevel, iEndLevel, grdtce, grdtce2, max_crload, no_sem, tgst_tcu, tbasic_tcu, tfaculty_tcu, tcc_tcu, telect_tcu, tsiwess_tcu, tentrep_tcu, tcompul_tcu, treq_tcu, telec_tcu, tgs_tcu, cEduCtgId FROM programme WHERE cProgrammeId = ?");
	$stmt->bind_param("s", $_REQUEST['cprogrammeIdold']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cObtQualId, $iBeginLevel, $iEndLevel, $grdtce, $grdtce2, $max_crload, $no_sem, $tgst_tcu, $tbasic_tcu, $tfaculty_tcu, $tcc_tcu, $telect_tcu, $tsiwess_tcu, $tentrep_tcu, $tcompul_tcu, $treq_tcu, $telec_tcu, $tgs_tcu, $cEduCtgId);
	$stmt->fetch();
	$stmt->close();
	
	$study_mode_ID = '';

	echo str_pad($cObtQualId,100).
	str_pad($iBeginLevel,100).
	str_pad($iEndLevel,100).
	str_pad($grdtce,100).
	str_pad($grdtce2,100).
	str_pad($max_crload,100).
	str_pad($study_mode_ID,100).
	str_pad($tgst_tcu,10).
	str_pad($tbasic_tcu,10).
	str_pad($tfaculty_tcu,10).
	str_pad($tcc_tcu,10).
	str_pad($telect_tcu,10).
	str_pad($tsiwess_tcu,10).
	str_pad($tentrep_tcu,10).
	str_pad($tcompul_tcu,10).
	str_pad($treq_tcu,10).
	str_pad($telec_tcu,10).
	str_pad($tgs_tcu,10).
	str_pad($cEduCtgId,10).
	str_pad($no_sem,10);exit;
}/*else if (isset($_REQUEST['cprogrammeIdold']) && isset($_REQUEST['frm_upd']) && $_REQUEST['frm_upd'] == 'procourse')
{ 
	if (isset($_REQUEST['selected_course_grp']) && $_REQUEST['selected_course_grp'] == 'reg_courses')
	{
		if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '' && isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] <> '')
		{
			$stmt = $mysqli->prepare("select concat(b.cCategory,a.cCourseId) cCourseId, b.cCategory, b.tSemester, a.iCreditUnit, a.vCourseDesc, b.siLevel
			from courses a, progcourse b 
			where a.cCourseId = b.cCourseId and b.cProgrammeId = ? and a.cdel = 'N' and b.cdel = 'N'  and siLevel = ? and b.tSemester = ? 
			order by b.siLevel, b.tSemester, b.cCategory, a.iCreditUnit, a.cCourseId");
			$stmt->bind_param("sii", $_REQUEST['cprogrammeIdold'], $_REQUEST['courseLevel'], $_REQUEST['coursesemester_h2']);
		}else if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '' && !(isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] <> ''))
		{
			$stmt = $mysqli->prepare("select concat(b.cCategory,a.cCourseId) cCourseId, b.cCategory, b.tSemester, a.iCreditUnit, a.vCourseDesc, b.siLevel
			from courses a, progcourse b 
			where a.cCourseId = b.cCourseId and b.cProgrammeId = ? and a.cdel = 'N' and b.cdel = 'N' and siLevel = ? order by b.siLevel, b.tSemester, b.cCategory, a.iCreditUnit, a.cCourseId");
			$stmt->bind_param("si", $_REQUEST['cprogrammeIdold'], $_REQUEST['courseLevel']);
		}else if (!(isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '') && isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] <> '')
		{
			$stmt = $mysqli->prepare("select concat(b.cCategory,a.cCourseId) cCourseId, b.cCategory, b.tSemester, a.iCreditUnit, a.vCourseDesc, b.siLevel
			from courses a, progcourse b 
			where a.cCourseId = b.cCourseId and b.cProgrammeId = ? and a.cdel = 'N' and b.cdel = 'N' and b.tSemester = ? 
			order by b.siLevel, b.tSemester, b.cCategory, a.iCreditUnit, a.cCourseId");
			$stmt->bind_param("si", $_REQUEST['cprogrammeIdold'], $_REQUEST['coursesemester_h2']);
		}
	}else if (isset($_REQUEST['selected_course_grp']))
	{
		if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '' && isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] <> '')
		{
			$stmt = $mysqli->prepare("select distinct concat('M',a.cCourseId) cCourseId, 'M', a.tSemester, a.iCreditUnit, a.vCourseDesc, concat(substr(a.cCourseId,4,1),'00') siLevel, cFacultyId, a.cdeptId
			from courses a
			inner join faculty b
			using (cFacultyId) 
			inner join depts c
			using (cFacultyId)
			where a.cdel = b.cDelFlag
			and b.cDelFlag = c.cDelFlag
			and c.cDelFlag = 'N' and substr(a.cCourseId,4,1) = left(?,1) and a.tSemester = ? 
			order by cFacultyId, a.cdeptId, siLevel, a.tSemester, siLevel, a.iCreditUnit, a.cCourseId");
			$stmt->bind_param("si", $_REQUEST['courseLevel'], $_REQUEST['coursesemester_h2']);
		}else if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '' && !(isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] <> ''))
		{
			$stmt = $mysqli->prepare("select distinct concat('M',a.cCourseId) cCourseId, 'M', a.tSemester, a.iCreditUnit, a.vCourseDesc, concat(substr(a.cCourseId,4,1),'00') siLevel, cFacultyId, a.cdeptId
			from courses a
			inner join faculty b
			using (cFacultyId) 
			inner join depts c
			using (cFacultyId)
			where a.cdel = b.cDelFlag
			and b.cDelFlag = c.cDelFlag
			and c.cDelFlag = 'N' and substr(a.cCourseId,4,1) = left(?,1) order by cFacultyId, a.cdeptId, siLevel, a.tSemester, siLevel, a.iCreditUnit, a.cCourseId");
			$stmt->bind_param("s", $_REQUEST['courseLevel']);
		}else if (!(isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '') && isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] <> '')
		{
			$stmt = $mysqli->prepare("select distinct concat('M',a.cCourseId) cCourseId, 'M', a.tSemester, a.iCreditUnit, a.vCourseDesc, concat(substr(a.cCourseId,4,1),'00') siLevel, cFacultyId, a.cdeptId
			from courses a
			inner join faculty b
			using (cFacultyId) 
			inner join depts c
			using (cFacultyId)
			where a.cdel = b.cDelFlag
			and b.cDelFlag = c.cDelFlag
			and c.cDelFlag = 'N' and a.tSemester = ? 
			order by cFacultyId, a.cdeptId, siLevel, a.tSemester, siLevel, a.iCreditUnit, a.cCourseId");
			$stmt->bind_param("i", $_REQUEST['coursesemester_h2']);
		}
	}
	
	$stmt->execute();
	$stmt->store_result();

	if (isset($_REQUEST['selected_course_grp']) && $_REQUEST['selected_course_grp'] == 'reg_courses')
	{
		$stmt->bind_result($cCourseId, $cCategory, $tSemester, $iCreditUnit, $vCourseDesc, $siLevel);
	}else if (isset($_REQUEST['selected_course_grp']))
	{
		$stmt->bind_result($cCourseId, $cCategory, $tSemester, $iCreditUnit, $vCourseDesc, $siLevel, $cFacultyId, $cdeptId);
	}

	$str = '';
	if ($stmt->num_rows > 0)
	{
        while ($stmt->fetch())
		{
			if (isset($_REQUEST['selected_course_grp']) && $_REQUEST['selected_course_grp'] == 'reg_courses')
			{
				$str .= str_pad($cCourseId,100).str_pad($cCategory,100).str_pad($tSemester,100).str_pad($iCreditUnit,100).str_pad($vCourseDesc,100).str_pad($siLevel,100);
			}else if (isset($_REQUEST['selected_course_grp']))
			{
				$str .= str_pad($cCourseId,100).str_pad($cCategory,100).str_pad($tSemester,100).str_pad($iCreditUnit,100).str_pad($vCourseDesc,100).str_pad($siLevel,100).str_pad($cFacultyId,100).str_pad($cdeptId,100);
			}
		}
	}
	$stmt->close();
	echo $str;exit;
}else if ((isset($_REQUEST['frm_upd']) && $_REQUEST['frm_upd'] == 'ass_courses') || (isset($_REQUEST['save']) && $_REQUEST['save'] == '1'))
{
	if (isset($_REQUEST['save']) && $_REQUEST['save'] == '1' && isset($_REQUEST['exist_user']))
	{
		$str = '';
		foreach ($_REQUEST['ccourseIdold_mult'] as $key => $value)
		{   
			$str .= $value.',';
		}
		$str = substr($str, 0, strlen($str)-1);
		$stmt = $mysqli->prepare("update userlogin set cCourseId = ? where vApplicationNo = ?");
		$stmt->bind_param("ss", $str, $_REQUEST["vApplicationNo"]);
		$stmt->execute();
		$stmt->close();
		
		echo 'Record successfully updated';exit;
	}
	
	$str = '';
	$stmt = $mysqli->prepare("select cCourseId from userlogin where vApplicationNo = ? order by cCourseId");
	$stmt->bind_param("s", $_REQUEST['exist_user']);
	
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cCourseId);
	
	while($stmt->fetch())
	{
		$str .= $cCourseId.',';
	}
	$stmt->close();
	echo $str;exit;
}*/else if ((isset($_REQUEST['frm_upd']) && $_REQUEST['frm_upd'] == 'form_prog_code'))
{
	$stmt = $mysqli->prepare("SELECT MAX(RIGHT(cProgrammeId,2))+1 FROM programme WHERE LEFT(cProgrammeId,3) = ? AND cEduCtgId = ?");
	$stmt->bind_param("ss", $cFacultyIdold, $_REQUEST['cEduCtgId']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($a);
	$stmt->fetch();
	$stmt->close();
	
	$a = $a ?? '';
	if (str_pad($a, 2, "0", STR_PAD_LEFT) == '00')
	{
		echo '01';
	}else
	{
		echo str_pad($a, 2, "0", STR_PAD_LEFT);
	}
	exit;	
}?>