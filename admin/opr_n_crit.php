<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$currency = eyes_pilled('0');

require_once('var_colls.php');

if (isset($_REQUEST['save']) && $_REQUEST['save'] == '1' && $_REQUEST['currency'] == '1')
{
	$cProgrammeId_loc = "%$cProgrammeId%";
	
	if (isset($_REQUEST['ac']) && $_REQUEST['ac'] == '1')
	{
		$stmt = $mysqli->prepare("SELECT * FROM criteriadetail WHERE cProgrammeId LIKE ? AND sReqmtId = ?");
		$stmt->bind_param("si", $cProgrammeId_loc, $sReqmtId);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0)
		{
			$stmt->close();
			echo 'Criterion already created';exit;
		}
		$stmt->close();
		
		$stmt = $mysqli->prepare("INSERT INTO criteriadetail SET
		cCriteriaId = ?,
		cProgrammeId = ?,
		sReqmtId = ?,
		cEduCtgId_1 = 'OL',	
		cEduCtgId_2 = ?,
		vReqmtDesc = ?,
		iBeginLevel = ?");
		$stmt->bind_param("ssissi", $cFacultyId, $cProgrammeId, $sReqmtId, $_REQUEST['cEduCtgId_2_loc'], $vReqmtDesc, $_REQUEST['iBeginLevel1']);
		$stmt->execute();
		$stmt->close();
		echo 'Record successfully saved';
	}
	
	if (isset($_REQUEST['ec']) && $_REQUEST['ec'] == '1')
	{
		if ($iBeginLevel > 100)
		{
			try
            {
                $mysqli->autocommit(FALSE); //turn on transactions
				
				$stmt_1 = $mysqli->prepare("UPDATE criteriadetail 
				SET vReqmtDesc = ?,
				iBeginLevel = ?,
				cEduCtgId_2 = ?
				WHERE cProgrammeId LIKE ?
				AND sReqmtId = ?");
				$stmt_1->bind_param("sissi", $_REQUEST["vReqmtDesc1"], $_REQUEST["iBeginLevel1"], $_REQUEST["cEduCtgId_2_loc"], $cProgrammeId_loc, $sReqmtId);
				$stmt_1->execute();

				$stmt = $mysqli->prepare("UPDATE criteriasubject 
				SET cEduCtgId = ?
				WHERE cProgrammeId LIKE ?
				AND sReqmtId = ?");
				$stmt->bind_param("ssi", $_REQUEST["cEduCtgId_2_loc"], $cProgrammeId_loc, $sReqmtId);
				$stmt->execute();
            
                $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
				
				$stmt_1->close();				
				$stmt->close();
				echo 'Record successfully updated';
            }catch(Exception $e) 
            {
                $mysqli->rollback(); //remove all queries from queue if error (undo)
                throw $e;
            }
		}else
		{
			$stmt = $mysqli->prepare("UPDATE criteriadetail 
			SET vReqmtDesc = ?
			WHERE cProgrammeId LIKE ?
			AND sReqmtId = ?");
			$stmt->bind_param("ssi", $_REQUEST["vReqmtDesc1"], $cProgrammeId_loc, $sReqmtId);
			$stmt->execute();
			$stmt->close();
			echo 'Record successfully updated';
		}		
	}	
}?>