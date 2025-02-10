<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$currency = eyes_pilled('0');

require_once('var_colls.php');

if (isset($_REQUEST['save']) && $_REQUEST['save'] == '1' && $_REQUEST['currency'] == '1')
{
	$cProgrammeId_loc = "%$cProgrammeId%";

	if (isset($_REQUEST['eq']) && $_REQUEST['eq'] == '1')
	{		
		try
		{
			$mysqli->autocommit(FALSE); //turn on transactions
			
			$stmt_1 = $mysqli->prepare("UPDATE criteriadetail SET
			cEduCtgId_2 = ?
			WHERE cProgrammeId LIKE ? 
			AND sReqmtId = ?");
			$stmt_1->bind_param("ssi", $_REQUEST["cEduCtgId_2_loc"], $cProgrammeId_loc, $sReqmtId);
			$stmt_1->execute();

			$stmt = $mysqli->prepare("UPDATE criteriasubject SET
			cEduCtgId = ?
			WHERE cProgrammeId LIKE ? 
			AND sReqmtId = ?");
			$stmt->bind_param("ssi", $_REQUEST["cEduCtgId_2_loc"], $cProgrammeId_loc, $sReqmtId);
			$stmt->execute();

			log_actv('updated criterion qualification for '.$_REQUEST["cProgrammeId"]);

			$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
			$stmt_1->close();
			$stmt->close();

			echo 'Record successfully edited';exit;
		}catch(Exception $e) 
		{
			$mysqli->rollback(); //remove all queries from queue if error (undo)
			throw $e;
		}
	}elseif (isset($_REQUEST['aq']) && $_REQUEST['aq'] == '1')
	{
		$stmt = $mysqli->prepare("INSERT INTO criteriadetail SET
		cCriteriaId = ?,
		cProgrammeId = ?,
		sReqmtId = ?,
		cEduCtgId_1 = 'OL',
		cEduCtgId_2 = ?,
		vReqmtDesc = ?");
		$stmt->bind_param("ssiss", $cFacultyId, $cProgrammeId, $sReqmtId, $_REQUEST['cEduCtgId_2_loc'], $vReqmtDesc);
		$stmt->execute();
		$stmt->close();
		
		log_actv('added new criterion qualification for '.$sReqmtId. ' '.$cProgrammeId);	
		echo 'Record successfully saved';exit;
	}elseif (isset($_REQUEST['dq']) && $_REQUEST['dq'] = '1' && isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1')
	{
		$stmt = $mysqli->prepare("SELECT * FROM criteriasubject WHERE cProgrammeId = ? AND sReqmtId = ?");
		$stmt->bind_param("si",$cProgrammeId, $sReqmtId);
		$stmt->execute();
		$stmt->store_result();
		
		if ($stmt->num_rows > 0)
		{
			$stmt->close();
			echo 'Please delete the subjects under selected qualification';exit;
		}else
		{
			$stmt->close();

			$cProgrammeId_loc = '%$cProgrammeId%';
			$stmt = $mysqli->prepare("DELETE FROM criteriadetail WHERE cProgrammeId LIKE ? AND sReqmtId = ?");
			$stmt->bind_param("si",$cProgrammeId_loc, $sReqmtId);
			$stmt->execute();
			$stmt->close();

			log_actv('deleted criterion qualification for '.$cProgrammeId . 'in '.$cFacultyId);
			echo 'Record successfully deleted';exit;
		}
	}
}?>