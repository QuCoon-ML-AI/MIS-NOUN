<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

if (isset($_REQUEST['save']) && $_REQUEST['save'] == '1')
{
	$str = '';
	if (isset($_REQUEST['whattodo']))
	{
		if ($_REQUEST['whattodo'] == '1' || $_REQUEST['whattodo'] == '2')
		{
			// $stateid = $_REQUEST["cstdStateId"];
			// if ($_REQUEST["cstdStateId"] == 'FC')
			// {
			// 	$stateid = 'FCT';
			// }

			$stmt = $mysqli->prepare("SELECT CONCAT(LEFT(cStudyCenterId,2),LPAD((RIGHT(cStudyCenterId,2)+1),2,'0')), gpz FROM studycenter WHERE cStateId = ? ORDER BY RIGHT(cStudyCenterId,2) DESC LIMIT 1;
			");
			$stmt->bind_param("s", $_REQUEST["cstdStateId"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($cStudyCenterId, $gpz);
			$stmt->fetch();
			$stmt->close();
			
			if ($_REQUEST['whattodo'] == '1')
			{
				$stmt = $mysqli->prepare("INSERT INTO studycenter 
				(cStudyCenterId,  
				cCountryId, 
				gpz,
				cStateId,
				cLGAId, 
				vCityName,
				vStudyCenterAddress, 
				contact_name1,
				vPhoneNo1,
				vEmaild,
				contact_name2,
				vPhoneNo2,
				p_center, 
				cStatus, 
				cDelFlag)
				VALUE
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'C', 'N')");

				$stmt->bind_param("ssssssssssssi", $cStudyCenterId, $_REQUEST["cstdCountryId"], $gpz, $_REQUEST["cstdStateId"], $_REQUEST["cstdLGAId"], $_REQUEST["vstdCityName"], $_REQUEST["vstdStudyCenterAddress"], $_REQUEST["contact_name1"], $_REQUEST["vstdMobileNo1"], $_REQUEST["vstdEMailId"], $_REQUEST["contact_name2"], $_REQUEST["vstdMobileNo2"], $_REQUEST["p_center"]);
			}else if ($_REQUEST['whattodo'] == '2')
			{			
				$stmt = $mysqli->prepare("UPDATE studycenter SET
				cCountryId = ?,
				gpz = ?, 
				cStateId = ?,
				cLGAId = ?, 
				vCityName = ?,
				vStudyCenterAddress = ?, 
				contact_name1 = ?,
				vPhoneNo1 = ?,
				vEmaild = ?,
				contact_name2 = ?,
				vPhoneNo2 = ?,
				p_center
				WHERE cStudyCenterId = ?");
				$stmt->bind_param("ssssssssssssi", $_REQUEST["cstdCountryId"], $gpz, $_REQUEST["cstdStateId"], $_REQUEST["cstdLGAId"], $_REQUEST["vstdCityName"], $_REQUEST["vstdStudyCenterAddress"], $_REQUEST["contact_name1"], $_REQUEST["vstdMobileNo1"], $_REQUEST["vstdEMailId"], $_REQUEST["contact_name2"], $_REQUEST["vstdMobileNo2"], $_REQUEST["cstdStudyCenterId"], $_REQUEST["p_center"]);
			}
			$stmt->execute();
			$stmt->close();
			
			if ($_REQUEST['whattodo'] == '1')
			{
				log_actv('Created study centre for '.$_REQUEST['vstdCityName']);
				echo 'Record created successfully';exit;
			}else
			{
				log_actv('Edited study centre record of '.$_REQUEST['vstdCityName']);
				echo 'Record edited successfully';exit;
			}
		}else if ($_REQUEST['whattodo'] == '3' && !isset($_REQUEST['conf']))
		{
			$stmt = $mysqli->prepare("select cStudyCenterId from s_m_t where cStudyCenterId = ?");
			$stmt->bind_param("s", $_REQUEST["cStudyCenterId"]);
			$stmt->execute();
			$stmt->store_result();
			
			if ($stmt->num_rows > 0)
			{
				$stmt->close();
				echo 'Process aborted. There are students in this centre';exit;
			}
			$stmt->close();

			$stmt = $mysqli->prepare("select cStudyCenterId from prog_choice where cStudyCenterId = ?");
			$stmt->bind_param("s", $_REQUEST["cStudyCenterId"]);
			$stmt->execute();
			$stmt->store_result();
						
			if ($stmt->num_rows > 0)
			{
				$stmt->close();
				echo 'Process aborted. There are applicants who have chosen this centre';exit;
			}
			$stmt->close();

			echo 'Delete selected study centre ?';exit;
		}else if ($_REQUEST['whattodo'] == '3' && isset($_REQUEST['conf']))
		{			
			$stmt = $mysqli->prepare("UPDATE studycenter SET cDelFlag = 'Y' where cStudyCenterId = ?");
			$stmt->bind_param("s", $_REQUEST["cStudyCenterId"]);
			$stmt->execute();
			$stmt->close();			
			
			log_actv('Deleted study centre in '.$_REQUEST['vstdCityName']);
			echo 'Record deleted successfully';exit;
		}
	}
}?>