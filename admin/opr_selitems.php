<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$currency = eyes_pilled('0');

$orgsetins = settns();

if (isset($_REQUEST['ilin']) && $_REQUEST['ilin'] <> '')
{
	$cAcademicDesc = $orgsetins["cAcademicDesc"];
	
	$vDesc_loc = '';
	if (isset($_REQUEST['vDesc_loc']) && $_REQUEST['vDesc_loc'] <> '')
	{
		$vDesc_loc = $_REQUEST['vDesc_loc'];
	}

	$cEduCtgId_loc = '';
	if (isset($_REQUEST['cEduCtgId_loc']) && $_REQUEST['cEduCtgId_loc'] <> '')
	{
		$cEduCtgId_loc = $_REQUEST['cEduCtgId_loc'];
	}
	
	$item_cat = '';
	if (isset($_REQUEST['item_cat']) && trim($_REQUEST['item_cat']) <> '')
	{
		$item_cat = substr($_REQUEST['item_cat'],0,2);
	}
	
	$level_burs = 0;
	if (isset($_REQUEST['level_burs']) && $_REQUEST['level_burs'] <> '')
	{
		$level_burs = $_REQUEST['level_burs'];
	}

	$iCreditUnit = 0;
	if (isset($_REQUEST['iCreditUnit_burs']) && $_REQUEST['iCreditUnit_burs'] <> '')
	{
		$iCreditUnit = $_REQUEST['iCreditUnit_burs'];
	}

	$amount_loc = 0.0;
	if (isset($_REQUEST['amount_loc']) && $_REQUEST['amount_loc'] <> '')
	{
		$amount_loc = $_REQUEST['amount_loc'];
	}

	$study_mode_loc = 'odl';
	if (isset($_REQUEST['study_mode']) && $_REQUEST['study_mode'] <> '')
	{
		$study_mode_loc = $_REQUEST['study_mode'];
	}


	$new_old_structure = '';
	if (isset($_REQUEST['new_old_structure']) && $_REQUEST['new_old_structure'] <> '')
	{
		$new_old_structure = $_REQUEST['new_old_structure'];
	}
	
	
	$study_center = '';

	$parent_share = '';
	$parent_share_bank_account = '';
	$parent_share_banker = '';
	$parent_share_name = '';

	if (isset($_REQUEST['conf']) && $_REQUEST['whatodo'] == 'd')
	{
		$stmt = $mysqli->prepare("select * from s_tranxion_20242025 where fee_item_id = ?");
		$stmt->bind_param("s",$_REQUEST['fee_item_id']);
		$stmt->execute();
		$stmt->store_result();
		
		if ($stmt->num_rows > 0)
		{
			$stmt->close();
			echo 'Item cannot be deleted because it has transaction(s) under it';exit;
		}
		
		$stmt = $mysqli->prepare("delete from s_f_s where iItemID = ?");
		$stmt->bind_param("s",$_REQUEST['iItemID']);
		$stmt->execute();
		$stmt->close();
		
		echo 'Item deleted successfully';
		log_actv('Deleted an item (revenue head)');
	}else if (isset($_REQUEST['conf']) && $_REQUEST['whatodo'] == 'da')
	{		
		$stmt = $mysqli->prepare("SELECT iItemID FROM s_tranxion_20242025 WHERE fee_item_id 
		IN (SELECT fee_item_id FROM s_f_s WHERE citem_cat = ? AND fee_item_id = ? AND cEduCtgId = ? AND new_old_structure = ?)");
		$stmt->bind_param("siss",$_REQUEST['item_cat'],$_REQUEST['fee_item_id'],$_REQUEST['cEduCtgId'], $new_old_structure);
		$stmt->execute();
		$stmt->store_result();
		
		if ($stmt->num_rows > 0)
		{
			$stmt->close();
			echo 'Item cannot be deleted because it has transaction(s) under it';exit;
		}
		
		$stmt = $mysqli->prepare("SELECT iItemID FROM s_f_s WHERE citem_cat = ? AND fee_item_id = ? AND cEduCtgId = ? AND new_old_structure = ?");
		$stmt->bind_param("siss",$_REQUEST['item_cat'],$_REQUEST['fee_item_id'],$_REQUEST['cEduCtgId'], $new_old_structure);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($iItemID_02);
		$c = 0;
		while($stmt->fetch())
		{
		    $stmt_d = $mysqli->prepare("DELETE FROM s_f_s WHERE iItemID = '$iItemID_02'");
		    $stmt_d->execute();
		    $c++;
		}

        echo $c.' items deleted successfully';	
		log_actv('Deleted '.$c.' items (revenue heads)');
		$stmt_d->close();
		$stmt->close();
			
	}else
	{		
		$iItemID_01 = '';

		$stmt = $mysqli->prepare("select iSemester from s_f_s where citem_cat = ? and cdel = 'N' and cAcademicDesc = '$cAcademicDesc'");
		$stmt->bind_param("s", $item_cat);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($iSemester_01);
		$stmt->fetch();
		
		$iSemester_01 = $iSemester_01 ?? '';
		
		if (strlen($iSemester_01) == 0){$iSemester_01 = 0;}

		if ($_REQUEST['whatodo'] == 'a')
		{
			$stmt = $mysqli->prepare("SELECT a.* 
			FROM s_f_s a, fee_items b 
			WHERE a.fee_item_id = b.fee_item_id
			AND b.fee_item_desc = ? 
			AND cEduCtgId = ?
			AND citem_cat = ?
			AND a.cdel = 'N'
			AND b.cdel = 'N'");
			$stmt->bind_param("iss", $vDesc_loc, $cEduCtgId_loc, $item_cat);

			$stmt->execute();
			$stmt->store_result();
			if ($stmt->num_rows > 0 && !isset($_REQUEST['conf']))
			{
				$stmt->close();
				echo 'Item description already in use. Please enter a unique description for item';exit;
			}
			$stmt->close();
			
			$stmt = $mysqli->prepare("SELECT max(iItemID)+1 FROM s_f_s WHERE citem_cat = ? AND cdel = 'N'");
			$stmt->bind_param("s", $item_cat);
			$stmt->execute();
			$stmt->store_result();
			
			$stmt->bind_result($iItemID_01);
			$stmt->fetch();
			$stmt->close();

			$iItemID_01 = $iItemID_01 ?? '';

			if ($iItemID_01 == '')
			{
				$stmt = $mysqli->prepare("SELECT citem_cat_id FROM sell_item_cat WHERE citem_cat = ?");
				$stmt->bind_param("s", $item_cat);
				$stmt->execute();
				$stmt->store_result();				
				$stmt->bind_result($iItemID_01);
				$stmt->fetch();
				$stmt->close();				
				
				$iItemID_01 = $iItemID_01 ?? '';
			}

			if ($iItemID_01 == '')
			{
				echo 'Fee item ID not available';
				exit;
			}
			
			$stmt4 = $mysqli->prepare("REPLACE INTO s_f_s 
			(iItemID, 
			citem_cat,
			fee_item_id, 
			cEduCtgId, 
			cFacultyId, 
			cdeptid, 
			cprogrammeId, 
			iSemester,
			ilevel,
			iCreditUnit, 
			Amount, 
			study_mode_ID, 
			parent_share, 
			parent_share_bank_acnt, 
			parent_share_bank_code, 
			parent_share_name,
			cAcademicDesc,
			add_date,
			new_old_structure)
			VALUES
			(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE(), ?)");

			try
			{
				$mysqli->autocommit(FALSE);

				foreach ($_REQUEST['cFacultyId_loc'] as $key => $cFacultyId_01)
				{
					if (isset($_REQUEST['cdeptid_loc']))
					{
						foreach ($_REQUEST['cdeptid_loc'] as $key => $cdeptid_01)
						{
							if (isset($_REQUEST['cprogrammeId_loc']))
							{
								foreach ($_REQUEST['cprogrammeId_loc'] as $key => $cprogrammeId_01)
								{
									$stmt4->bind_param("isissssiiidsdsssss", $iItemID_01, $item_cat, $vDesc_loc, $cEduCtgId_loc, $cFacultyId_01, $cdeptid_01, $cprogrammeId_01, $iSemester_01, $level_burs, $iCreditUnit, $amount_loc, $study_mode_loc, $parent_share, $parent_share_bank_account, $parent_share_banker, $parent_share_name, $cAcademicDesc, $new_old_structure);
									$stmt4->execute();
									log_actv('Added an item (revenue head) for '.$cprogrammeId_01.', '.$cdeptid_01.', '.$cFacultyId_01);
									$iItemID_01++;
								}
							}else
							{
								$cprogrammeId_01 = 'All';
								
								$stmt4->bind_param("isissssiiidsdsssss", $iItemID_01, $item_cat, $vDesc_loc, $cEduCtgId_loc, $cFacultyId_01, $cdeptid_01, $cprogrammeId_01, $iSemester_01, $level_burs, $iCreditUnit, $amount_loc, $study_mode_loc, $parent_share, $parent_share_bank_account, $parent_share_banker, $parent_share_name, $cAcademicDesc, $new_old_structure);
								$stmt4->execute();
								log_actv('Added an item (revenue head) for '.$cdeptid_01. ', '.$cFacultyId_01);
								$iItemID_01++;
							}
						}
					}else
					{
						$cdeptid_01 = 'All';
						$cprogrammeId_01 = 'All';
						$stmt4->bind_param("isissssiiidsdsssss", $iItemID_01, $item_cat, $vDesc_loc, $cEduCtgId_loc, $cFacultyId_01, $cdeptid_01, $cprogrammeId_01, $iSemester_01, $level_burs, $iCreditUnit, $amount_loc, $study_mode_loc, $parent_share, $parent_share_bank_account, $parent_share_banker, $parent_share_name, $cAcademicDesc, $new_old_structure);
						
						$stmt4->execute();
						log_actv('Added an item (revenue head) for '.$cFacultyId_01);
						$iItemID_01++;
					}
				}				

				$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
				
				echo 'Record(s) successfully added';
			}catch(Exception $e)
			{
			  $mysqli->rollback(); //remove all queries from queue if error (undo)
			  throw $e;
			}	
			$stmt4->close();
		}else if ($_REQUEST['whatodo'] == 'e')
		{
			$unit_fee = '';
			$iItemID = $_REQUEST['iItemID'];
			if ($iCreditUnit <> '')
			{
				$unit_fee = " AND iCreditUnit = $iCreditUnit";
			}
			
			if (isset($_REQUEST['all_faculty']))
			{
				$stmt4 = $mysqli->prepare("UPDATE s_f_s SET
				Amount = ?,
				citem_cat = ?
				WHERE citem_cat = ?
				AND fee_item_id = ?
				AND cEduCtgId = ?
				$unit_fee");
			}else
			{
				$stmt4 = $mysqli->prepare("REPLACE INTO s_f_s SET
				citem_cat = ?,
				fee_item_id = ?, 
				cEduCtgId = ?, 
				cFacultyId = ?, 
				cdeptid = ?, 
				cprogrammeId = ?, 
				iSemester = ?,
				ilevel = ?,
				iCreditUnit = ?, 
				Amount = ?, 
				study_mode_ID = ?, 
				parent_share = ?, 
				parent_share_bank_acnt = ?, 
				parent_share_bank_code = ?,
				parent_share_name = ?,
				new_old_structure = ?,
				iItemID = ?");
			}

			try
			{
				$mysqli->autocommit(FALSE);

				if (isset($_REQUEST['all_faculty'])){
					$stmt4->bind_param("issis", $amount_loc, $_REQUEST['item_cat_cur'], $item_cat, $_REQUEST['fee_item_id'], $cEduCtgId_loc);
					$stmt4->execute();
					echo 'Record(s) successfully edited for all faculties';
					log_actv('Edited an item (revenue head) for all faculty for '.$item_cat .' '. $_REQUEST['fee_item_id'] .' '. $cEduCtgId_loc);
				}else{
					foreach ($_REQUEST['cFacultyId_loc'] as $key => $cFacultyId_01)
					{
						if (isset($_REQUEST['cdeptid_loc']))
						{
							foreach ($_REQUEST['cdeptid_loc'] as $key => $cdeptid_01)
							{
								if (isset($_REQUEST['cprogrammeId_loc']))
								{
									foreach ($_REQUEST['cprogrammeId_loc'] as $key => $cprogrammeId_01)
									{
										$stmt = $mysqli->prepare("select * from s_tranxion_20242025 where iItemID <> '0' AND iItemID = ?");
										$stmt->bind_param("i", $iItemID);
										$stmt->execute();
										$stmt->store_result();
													
										if ($stmt->num_rows > 0)
										{
											$stmt->close();
											echo 'Item cannot be edited because it has transaction(s) under it';exit;
										}
										$stmt->close();
										$stmt4->bind_param("sissssiiidsdsssss", $item_cat, $vDesc_loc, $cEduCtgId_loc, $cFacultyId_01, $cdeptid_01, $cprogrammeId_01, $iSemester_01, $level_burs, $iCreditUnit, $amount_loc, $study_mode_loc, $parent_share, $parent_share_bank_account, $parent_share_banker, $parent_share_name, $new_old_structure, $iItemID);
										$stmt4->execute();
										$stmt4->close();

										log_actv('Edited an item (revenue head) for '.$cdeptid_01. ', '.$cdeptid_01. ', '.$cFacultyId_01);
									}
								}else
								{
									$cprogrammeId_01 = 'All';
									$stmt4->bind_param("sissssiiidsdsssss", $item_cat, $vDesc_loc, $cEduCtgId_loc, $cFacultyId_01, $cdeptid_01, $cprogrammeId_01, $iSemester_01, $level_burs, $iCreditUnit, $amount_loc, $study_mode_loc, $parent_share, $parent_share_bank_account, $parent_share_banker, $parent_share_name, $new_old_structure, $iItemID);
									$stmt4->execute();
									log_actv('Edited an item (revenue head) for '.$cdeptid_01. ', '.$cFacultyId_01);
									$iItemID_01++;
								}
							}
						}else
						{
							$cdeptid_01 = 'All';
							$cprogrammeId_01 = 'All';
							$stmt4->bind_param("sissssiiidsdsssss", $item_cat, $vDesc_loc, $cEduCtgId_loc, $cFacultyId_01, $cdeptid_01, $cprogrammeId_01, $iSemester_01, $level_burs, $iCreditUnit, $amount_loc, $study_mode_loc, $parent_share, $parent_share_bank_account, $parent_share_banker, $parent_share_name, $new_old_structure, $iItemID);
							$stmt4->execute();
							
							log_actv('Edited an item (revenue head) for '.$cFacultyId_01);
							$iItemID_01++;
						}
					}
					echo 'Record(s) successfully edited';
				}
				$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
				
			}catch(Exception $e)
			{
			  $mysqli->rollback(); //remove all queries from queue if error (undo)
			  throw $e;
			}
		}
	}
}else if (isset($_REQUEST['edit_clk']) && $_REQUEST['edit_clk'] == '1')
{
}else if (isset($_REQUEST['edit_clk']) && $_REQUEST['edit_clk'] == '2')
{
	$returnStr = '';
	
	$stmt = $mysqli->prepare("select vEduCtgDesc from educationctg where cEduCtgId = ?");
	$stmt->bind_param("s", $_REQUEST["cEduCtgId"]);
	$stmt->execute();
	$stmt->store_result();	
	$stmt->bind_result($vEduCtgDesc_02);
	$stmt->fetch();
	$returnStr = str_pad($vEduCtgDesc_02,100);
	$stmt->close();

	$stmt = $mysqli->prepare("select concat(cFacultyId,' ',vFacultyDesc) vFacultyDesc from faculty where cFacultyId = ?");
	$stmt->bind_param("s", $_REQUEST["cFacultyId"]);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows == 0)
	{
		$returnStr .= str_pad('All',100);
	}else
	{
		$stmt->bind_result($vFacultyDesc_01);
		$stmt->fetch();
		$returnStr .= str_pad($vFacultyDesc_01,100);
	}
	$stmt->close();

	$stmt = $mysqli->prepare("select concat(cdeptId,' ',vdeptDesc) vdeptDesc from depts where cdeptId = ?");
	$stmt->bind_param("s", $_REQUEST["cdeptid"]);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows == 0)
	{
		$returnStr .= str_pad('All',100);
	}else
	{
		$stmt->bind_result($vdeptDesc_01);
		$stmt->fetch();
		$returnStr .= str_pad($vdeptDesc_01,100);
	}
	$stmt->close();

	$stmt = $mysqli->prepare("select vProgrammeDesc from programme where cProgrammeId = ?");
	$stmt->bind_param("s", $_REQUEST["cprogrammeId"]);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows == 0)
	{
		$returnStr .= str_pad('All',100);
	}else
	{
		$stmt->bind_result($vProgrammeDesc_01);
		$stmt->fetch();
		$returnStr .= str_pad($vProgrammeDesc_01,100);
	}
	$stmt->close();

	$stmt = $mysqli->prepare("select citem_cat_desc from sell_item_cat where citem_cat = ?");
	$stmt->bind_param("s", $_REQUEST["item_cat"]);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows == 0)
	{
		$returnStr .= str_pad('All',100);
	}else
	{
		$stmt->bind_result($citem_cat_desc_01);
		$stmt->fetch();
		$returnStr .= str_pad($citem_cat_desc_01,100);
	}
	$stmt->close();
	echo $returnStr;
}else if (isset($cEduCtgId_loc) && !isset($_REQUEST['frm_upd']))
{	
	$stmt = $mysqli->prepare("SELECT min(iItemID), max(iItemID) 
	FROM s_f_s 
	WHERE cEduCtgId = '".$cEduCtgId_loc."' 
	AND iSemester = ".$_REQUEST['iSemester_loc_t']." 
	AND cAcademicDesc = '$cAcademicDesc'
	AND cdel = 'N'");
	$stmt->bind_param("si", $cEduCtgId_loc, $_REQUEST['iSemester_loc_t']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($iItemID_min, $iItemID_max);
	
	if ($stmt->num_rows > 0)
	{
		$stmt->fetch();
		$stmt->close();
		echo $iItemID_min.'_'.$iItemID_max;exit;
	}
	$stmt->close();
}else if (isset($cEduCtgId_loc) && isset($_REQUEST['frm_upd']))
{	
	$citem_cat_like = '';	
	if ($cEduCtgId_loc == 'PSZ')
	{
		$citem_cat_like = "citem_cat like 'A%'";
	}else if ($cEduCtgId_loc == 'PGX')
	{
		$citem_cat_like = "citem_cat like 'B%'";
	}else if ($cEduCtgId_loc == 'PGY')
	{
		$citem_cat_like = "citem_cat like 'C%'";
	}else if ($cEduCtgId_loc == 'PRX')
	{
		$citem_cat_like = "citem_cat like 'D%'";
	}else if ($cEduCtgId_loc == 'ELZ')
	{
		$citem_cat_like = "citem_cat like 'E%'";
	}else if ($cEduCtgId_loc == 'ELX')
	{
		$citem_cat_like = "citem_cat like 'F%'";
	}else if ($cEduCtgId_loc == 'PGZ')
	{
		$citem_cat_like = "citem_cat like 'G%'";
	}
	
	$sql1 = "select distinct citem_cat, citem_cat_desc from sell_item_cat where $citem_cat_like order by citem_cat";
	
	$rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));
	if (mysqli_num_rows($rsql1) > 0)
	{
		$str = '';
		while ($table=mysqli_fetch_array($rsql1))
		{
			$str .= $table[0].str_pad($table[1],100);
		}
		echo mysqli_num_rows($rsql1).'+'.$str;
		
		mysqli_close(link_connect_db());
		exit;
	}
}?>