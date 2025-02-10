<?php
require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');
include ('remita_constants.php');

function remita_transaction_details($rrr)
{
	$mert =  MERCHANTID;
	$api_key =  APIKEY;
	
	$concatString = $rrr . $api_key . $mert;
	$hash = hash('sha512', $concatString);
	$url = CHECKSTATUSURL . '/' . $mert  . '/' . $rrr . '/' . $hash . '/' . 'status.reg';

	//  Initiate curl
	$ch = curl_init();
	// Disable SSL verification
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// Will return the response, if false it print the response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Set the url
	curl_setopt($ch, CURLOPT_URL, $url);
	// Execute
	$result=curl_exec($ch);
	// Closing
	curl_close($ch);

	$response = json_decode($result, true);
	return $response;
}


$staff_study_center = '';
if (isset($_REQUEST['user_centre']) && $_REQUEST['user_centre'] <> '')
{
	$staff_study_center = $_REQUEST['user_centre'];
}

$orgsetins = settns();
$study_mode_04 = 'odl';

date_default_timezone_set('Africa/Lagos');
$date2 = date("Y-m-d h:i:s");


if (isset($_REQUEST['ilin']) && $_REQUEST['ilin'] <> '')
{
	if (isset($_FILES['sbtd_pix']))
	{
		$file_chk = check_file('3000000', '1');
		if ($file_chk <> '')
		{
			//echo $file_chk;
			//exit;
		}

		$date2 = date("ymd");

		$file_name = 'batch_credit_'.$orgsetins['cAcademicDesc'].'_'.$orgsetins['tSemester'].'_'.$date2;
		$file = "../../ext_docs/bat_cr/".$file_name.'.csv';
		
		if (!move_uploaded_file($_FILES["sbtd_pix"]["tmp_name"], $file))
		{
			echo "Your file could not be uploaded. Try again later";
			exit;
		}else
		{
			$listed_matnos = "'";
			$valid_matnos = "'";
			$invalid_matnos = "";
			
			$valid_matnos_count = 0;
			$invalid_matnos_count = 0;

			chmod($file, 0755);
			log_actv('Uploaded file '.$file);

			$handle = fopen("$file", "r");
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
			{
				if (count($data) <> 6) 
				{
					fclose($handle);
					unlink($file) or die("Couldn't continue process ");

					echo 'File not valid';
					exit;
				}
				
				$listed_matnos .= $data[1]."', '";
			}
			
			fclose($handle);
			
			if ($listed_matnos <> "'")
			{
				//$transaction_desc = 'Wallet Funding (Internal credit adjustment)';

				$handle = fopen("$file", "r");
				try
				{
					$mysqli->autocommit(FALSE);
					
					$stmt_remitapayments = $mysqli->prepare("INSERT IGNORE INTO remitapayments 
					(Regno,
					payerName,
					vLastName,
					vFirstName,
					vOtherName,
					payerEmail,
					cEduCtgId,
					Amount, 
					payerPhone,
					MerchantReference,
					RetrievalReferenceNumber,
					ResponseCode,
					ResponseDescription,
					AcademicSession,
					tSemester, 
					vDesc,
					TransactionDate,
					Status)
					VALUE(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");


					$stmt_s_tranxion = $mysqli->prepare("INSERT IGNORE INTO s_tranxion_cr 
					(RetrievalReferenceNumber,
					vMatricNo,
					cCourseId,
					tdate,
					cTrntype,
					iItemID,
					amount,
					tSemester,
					cAcademicDesc,
					siLevel,
					trans_count,
					fee_item_id,
					vremark)
					VALUE
					(?, ?, 'ICA', ?, 'c', ?, ?, '".$orgsetins['tSemester']."', '".$orgsetins['cAcademicDesc']."', ?, ?, ?,?)");

					$stmt_cr_uploads = $mysqli->prepare("INSERT IGNORE INTO cr_uploads
					(payid,
					payname,
					rrr,
					amount,
					upldate,
					remark)
					VALUE
					(?, ?, ?, ?, ?, ?)");

					$err_mg = '';
					$count_r = 0;
					while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
					{
						
						//$l_names = strtoupper(trim(clean_str($data[0])));
						$l_names = strtoupper(clean_string($data[0], 'names'));

						//$f_names = ucwords(strtolower(trim(clean_str($data[1]))));
						$f_names = ucwords(strtolower(clean_string($data[1], 'names')));

						//$o_names = ucwords(strtolower(strtoupper(trim(clean_str($data[2])))));
						$o_names = ucwords(strtolower(clean_string($data[2], 'names')));

						$names = $l_names.' '.$f_names.' '.$o_names;

						//$matno = trim(clean_str($data[3]));
						$matno = strtoupper(clean_string($data[3], 'matno'));

						if (!(strlen($matno) == 12 && is_numeric(substr($matno,3,9)) && (substr($matno,0,3) == 'NOU' || substr($matno,0,3) == 'COL')))
						{
							$err_mg .= $names." Invalid matric number ".$matno.'<br>';
							continue;
						}

						$payerEmail = strtolower($matno)."@noun.edu.ng";

						//$rrr = trim(clean_str($data[4]));
						$rrr = clean_string($data[4], 'numbers');

						//$transaction_desc = 'Wallet Funding (Internal credit adjustment)';
						$transaction_desc = clean_string($data[5], 'sentence');

						if (!is_numeric($rrr))
						{
							$err_mg .= $names." Invalid rrr ".$rrr.'<br>';
							continue;
						}

						$response = remita_transaction_details($rrr);
			
						//var_dump($response) .'<p>';

						$response_code = '';
						$statuss = 'Pending';
						$statuss1 = '';
						$response_message = '';
						$orderid = '';
						$datt = '';
						$amount = 0.0;
						

						if (isset($response['status']))
						{
							if ($response['status'] == '998')
							{
								$err_mg .= $names." Refer to Bursary ".$rrr.'<br>';
								continue;
							}

							if ($response['status'] <> '00' && $response['status'] <> '01')
							{
								$err_mg .= $names." Transaction pending ".$rrr .' '.$response['status'].'<br>';
								continue;
							}
							
							if (isset($response['status']))
							{
								$response_code = trim($response['status']);
							}

							if ($response_code == '00' || $response_code == '01')
							{
								$statuss = 'Succesful';
								$statuss1 = 'Approved';
							}
							
							if (isset($response['message']))
							{
								$response_message = trim($response['message']);
							}
							
							if (isset($response['orderId']))
							{
								$orderid = trim($response['orderId']);
							}
							
							if (isset($response['transactiontime']))
							{
								$datt = trim($response['transactiontime']);
							}
							
							if (isset($response['amount']))
							{
								$amount = trim($response['amount']);
							}
						}
						
						$stmt = $mysqli->prepare("SELECT a.cFacultyId, iStudy_level, cEduCtgId, vMobileNo, tSemester FROM s_m_t a, programme b  WHERE a.cProgrammeId = b.cProgrammeId AND vMatricNo = ?");
						$stmt->bind_param("s", $matno);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($cFacultyId, $iStudy_level, $cEduCtgId, $vMobileNo, $tSemester);
						$stmt->fetch();
						if (is_null($cFacultyId))
						{
							$cFacultyId = '';
						}

						if (is_null($iStudy_level))
						{
							$iStudy_level = '';
						}
						
						if (is_null($cEduCtgId))
						{
							$cEduCtgId = '';
						}

						if ($cFacultyId == '')
						{
							$err_mg .= $names." ".$matno." yet to sign up <br>";
							continue;
						}

						if ($cFacultyId == '')
						{
							$err_mg .= $names." ".$matno." yet to sign up <br>";
							continue;
						}

						$rssql = mysqli_query(link_connect_db(), "SELECT b.fee_item_id, iItemID FROM s_f_s a, fee_items b 
						WHERE a.fee_item_id = b.fee_item_id 
						AND cEduCtgId = '$cEduCtgId'
						AND cFacultyId = '$cFacultyId'
						AND b.fee_item_desc = 'Internal credit adjustment'") or die("error: ".mysqli_error(link_connect_db()));
						$rs_iItemID = mysqli_fetch_array($rssql);
						$fee_item_id = $rs_iItemID[0];
						$iItemID_lc_c = $rs_iItemID[1];
						
						$nxt_sn = get_nxt_sn ($matno, '',$transaction_desc);
						
						$stmt_s_tranxion->bind_param("ssssdiiis", 
						$rrr, 
						$matno, 
						$datt, 
						$iItemID_lc_c, 
						$amount, 
						$iStudy_level, 
						$nxt_sn, 
						$fee_item_id,
						$transaction_desc);
						$stmt_s_tranxion->execute();
						$record_exsit_s_tranxion = $stmt_s_tranxion->affected_rows;

						if ($record_exsit_s_tranxion == 0)
						{
							$stmt_chk = $mysqli->prepare("SELECT amount 
							from s_tranxion_cr
							where RetrievalReferenceNumber = ?
							AND vMatricNo = ?");
							$stmt_chk->bind_param("ss", $rrr, $matno);
							$stmt_chk->execute();
							$stmt_chk->store_result();
							$stmt_chk->bind_result($chk_amount);
							$stmt_chk->fetch();

							if ($amount <> 0 && (is_null($chk_amount) || $chk_amount == 0))
							{
								$date_here = substr($datt, 0, 19);
								
								$stmt_updt_chk = $mysqli->prepare("UPDATE s_tranxion_cr 
								SET tdate = '$date_here',
								amount = ?
								WHERE RetrievalReferenceNumber = ?
								AND vMatricNo = ?");
								$stmt_updt_chk->bind_param("dss", $amount, $rrr, $matno);
								$stmt_updt_chk->execute();
							}
						}

						$stmt_cr_uploads->bind_param("sssdss", 
						$matno, 
						$names, 
						$rrr, 
						$amount, 
						$datt, 
						$remark);
						$stmt_cr_uploads->execute();
						$record_stmt_cr_uploads = $stmt_cr_uploads->affected_rows;

						$stmt_remitapayments->bind_param("sssssssdssssssisss", 
						$matno,
						$names,
						$l_names,
						$f_names,
						$o_names,
						$payerEmail,
						$cEduCtgId,
						$amount, 
						$vMobileNo,
						$orderid,
						$rrr,
						$response_code,
						$statuss1,
						$orgsetins['cAcademicDesc'],
						$tSemester, 
						$transaction_desc,
						$datt,
						$statuss);
						$stmt_remitapayments->execute();
						$record_stmt_remitapayments = $stmt_remitapayments->affected_rows;

						if ($record_exsit_s_tranxion == 0 || $record_stmt_cr_uploads == 0 || $record_stmt_remitapayments == 0)
						{
							//$err_mg .= $names." ".$matno." ".$rrr." RRR already uploaded <br>";
							//continue;
						}

						if ($record_exsit_s_tranxion == 1 || $record_stmt_cr_uploads == 1 || $record_stmt_remitapayments == 1)
						{
							log_actv($transaction_desc .' for '. $matno);
							$count_r++;
						}
					}

					$mysqli->autocommit(TRUE);

					$stmt_cr_uploads->close();
					$stmt_s_tranxion->close();
					$stmt_remitapayments->close();

					if (isset($stmt_chk))
					{
						$stmt_chk->close();
					}
					if (isset($stmt_updt_chk))
					{
						$stmt_updt_chk->close();
					}
				}catch(Exception $e)
				{
					$count = 0;
					$mysqli->rollback(); //remove all queries from queue if error (undo)
					throw $e;
				}
				
				echo $count_r." records uploaded successfully".'<p>'.$err_mg;exit;
			}
		}
	}else 
	{
		/*if (isset($_REQUEST['chk_inmate']) && $_REQUEST['chk_inmate'] <> '')
		{	
			$stmt = $mysqli->prepare("SELECT Regno FROM remitapayments_app WHERE RetrievalReferenceNumber = ? AND vDesc = 'Application Fee'");
			$stmt->bind_param("s", $_REQUEST['rrr']);
			$stmt->execute();
			$stmt->store_result();

			if ($stmt->num_rows == 0)
			{
				echo 'RRR not found for application fee';
				exit;
			}
			$stmt->bind_result($Regno);
			$stmt->fetch();
			$stmt->close();
						
			if (is_null($Regno))
			{
				$Regno = '';
			}

			try
			{
				$mysqli->autocommit(FALSE); //turn on transactions

				if ($Regno == '')
				{
					$Regno = alloc_dum_pin($_REQUEST['rrr']);
				}

				if (check_rrr($_REQUEST['rrr']) == 0)
				{
					$transaction_desc = 'Application Fee (Internal credit adjustment)';
					$nxt_sn = get_nxt_sn ($Regno, '',$transaction_desc);
					
					$stmt = $mysqli->prepare("SELECT a.cFacultyId, iStudy_level, cEduCtgId FROM s_m_t a, programme b  WHERE a.cProgrammeId = b.cProgrammeId AND vMatricNo = ?");
					$stmt->bind_param("s", $data[1]);
					$stmt->execute();
					$stmt->store_result();
					$stmt = $mysqli->prepare("SELECT a.cFacultyId, iStudy_level, cEduCtgId FROM s_m_t a, programme b  WHERE a.cProgrammeId = b.cProgrammeId AND vMatricNo = ?");
					$stmt->bind_result($cFacultyId, $iStudy_level, $cEduCtgId);
					$stmt->fetch();
					$stmt->close();

					// if ($cEduCtgId == 'PSZ')
					// {
					// 	$iStudy_level_01 = 100;
					// }else if ($cEduCtgId == 'PGX')
					// {
					// 	$iStudy_level_01 = 700;
					// }else if ($cEduCtgId == 'PGY')
					// {
					// 	$iStudy_level_01 = 700;
					// }else if ($cEduCtgId == 'PGY')
					// {
					// 	$iStudy_level_01 = 800;
					// }

					$rssql = mysqli_query(link_connect_db(), "SELECT b.fee_item_id, iItemID FROM s_f_s a, fee_items b 
					WHERE a.fee_item_id = b.fee_item_id 
					AND cEduCtgId = '$cEduCtgId'
					AND cFacultyId = '$cFacultyId'
					AND b.fee_item_desc = 'Application Fee'
					AND new_old_structure = 'o'") or die("error: ".mysqli_error(link_connect_db()));
					$rs_iItemID = mysqli_fetch_array($rssql);
					$fee_item_id = $rs_iItemID[0];
					$iItemID_lc_c = $rs_iItemID[1];
					mysqli_close(link_connect_db());			

					$stmt = $mysqli->prepare("INSERT INTO s_tranxion_cr SET 
					RetrievalReferenceNumber = ?,
					vMatricNo = ?, 
					cCourseId = 'xxxxxx', 
					cTrntype = 'c', 
					iItemID = $iItemID_lc_c, 
					amount = ?,
					tSemester = 1,
					cAcademicDesc = '".$orgsetins["cAcademicDesc"]."',
					siLevel = $iStudy_level_01,
					trans_count = $nxt_sn,
					vremark = ?,
					fee_item_id = '$fee_item_id',
					tdate = '$date2'");
					$stmt->bind_param("ssds",$_REQUEST['rrr'], $Regno, $_REQUEST['adj_amnt'], $transaction_desc);
					$stmt->execute();
					$stmt->close();

					$stmt = $mysqli->prepare("UPDATE remitapayments_app 
					SET ResponseCode = '01',
					Status = 'successful' 
					WHERE RetrievalReferenceNumber = ?");	
					$stmt->bind_param("s", $_REQUEST['rrr']);
					$stmt->execute();		
					$stmt->close();
					
					log_actv($transaction_desc.' of '. $_REQUEST['adj_amnt']. ' for '.$Regno);

					echo 'Account credited successfully';
				}else
				{
					echo 'Account already credited on this RRR';
				}

				$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
			}catch(Exception $e) 
			{
				$mysqli->rollback(); //remove all queries from queue if error (undo)
				throw $e;
			}
			exit;
		}*/

		$stmt = $mysqli->prepare("select * from afnmatric where vMatricNo = ?");
		$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
		$stmt->execute();
		$stmt->store_result();

		if ($stmt->num_rows == 0)
		{
			if ($_REQUEST['bal'] == 1)
			{
				echo '0Invalid matriculation number';
			}else if ($_REQUEST['bal'] == 0)
			{
				echo '1Invalid matriculation number'; 
			}
			
			$stmt->close();
			exit;
		}else if (check_grad_student($_REQUEST["uvApplicationNo"]) == 1)
		{
			if ($_REQUEST['bal'] == 1)
			{
				echo '0Matriculation number gradauted*'; 
			}else if ($_REQUEST['bal'] == 0)
			{
				echo '1Matriculation number gradauted*';
			}		
		}
		
		
		$trn_bal = wallet_bal1();
		

// 		$stmt = $mysqli->prepare("SELECT a.vApplicationNo, f.iStudy_level, f.tSemester, a.cSbmtd, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, d.vLastName, d.vFirstName, d.vOtherName, f.cStudyCenterId, g.vCityName, f.cFacultyId, a.cEduCtgId
// 		from prog_choice a, programme b, obtainablequal c, pers_info d, afnmatric e, s_m_t f, studycenter g
// 		where a.cProgrammeId = b.cProgrammeId 
// 		and b.cObtQualId = c.cObtQualId 
// 		and d.vApplicationNo = a.vApplicationNo 
// 		and e.vApplicationNo = a.vApplicationNo 
// 		and e.vMatricNo = f.vMatricNo 
// 		and f.cStudyCenterId = g.cStudyCenterId
// 		and e.vMatricNo = ?");
		
		$stmt = $mysqli->prepare("SELECT f.vApplicationNo, f.iStudy_level, f.tSemester, f.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, f.vLastName, f.vFirstName, f.vOtherName, f.cStudyCenterId, g.vCityName, f.cFacultyId, b.cEduCtgId
		from programme b, obtainablequal c, s_m_t f, studycenter g
		where f.cProgrammeId = b.cProgrammeId 
		and b.cObtQualId = c.cObtQualId 
		and f.cStudyCenterId = g.cStudyCenterId
		and f.vMatricNo = ?");
		
		
		$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
		$stmt->execute();
		$stmt->store_result();

		if ($stmt->num_rows == 0)
		{	
			$stmt->close();
			echo 'Invalid matriculation number';exit; 
		}
		
		$stmt->bind_result($vApplicationNo_01, $iStudy_level_01, $tSemester_01, $cProgrammeId_01, $vObtQualTitle_01, $vProgrammeDesc_01, $vLastName_01, $vFirstName_01, $vOtherName_01, $cStudyCenterId, $vCityName, $cFacultyId_01, $cEduCtgId_01);
		
		$stmt->fetch();
				
		if (!is_bool(strpos($vProgrammeDesc_01,"(d)")))
		{
			$vProgrammeDesc_01 = substr($vProgrammeDesc_01, 0, strlen($vProgrammeDesc_01)-4);
		}

		//$mask = get_mask($_REQUEST['uvApplicationNo']);
		$pix_mask = get_pp_pix($vApplicationNo_01);
						
		if (is_null($pix_mask))
		{
			$pix_mask = '';
		}
						
		if (is_null($vOtherName_01))
		{
			$vOtherName_01 = '';
		}

		$who_is_this = str_pad($vApplicationNo_01, 100).
		str_pad($vLastName_01, 100).
		str_pad($vFirstName_01, 100).
		str_pad($vOtherName_01, 100).
		str_pad($vObtQualTitle_01, 100).
		str_pad($vProgrammeDesc_01, 100).
		str_pad($iStudy_level_01, 100).
		str_pad($tSemester_01, 100).
		str_pad($trn_bal, 100).
		str_pad($vCityName, 100).
		str_pad(strtolower($cFacultyId_01), 100).
		str_pad($pix_mask, 100);
		$stmt->close();

		if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
		{
			echo 'Your study centre does not match that of the candidate<br>Direct candidate to his/her study centre for required action';exit;
		}
		
		$stmt_level = $mysqli->prepare("SELECT cResidenceCountryId, cAcademicDesc_1, a.cFacultyId, cEduCtgId FROM s_m_t a, programme b WHERE a.cProgrammeId = b.cProgrammeId AND vMatricNo = ?");
		$stmt_level->bind_param("s", $_REQUEST['uvApplicationNo']);
		$stmt_level->execute();
		$stmt_level->store_result();
		$stmt_level->bind_result($cResidenceCountryId, $cAcademicDesc_1, $cFacultyId, $cEduCtgId);
		$stmt_level->fetch();
		$stmt_level->close();

		//$sql_feet_type = select_fee_srtucture($_REQUEST['uvApplicationNo'], $cResidenceCountryId, $cEduCtgId);
		
		if ($_REQUEST['adj_type'] == 'c')
		{		
			$app_rrr_exist = -1;
			$reg_rrr_exist = -1;
			$r_rrr_exist = -1;
			
			$lp_cnt = 0;
			
			while ($reg_rrr_exist <> 0 || $app_rrr_exist <> 0 || $r_rrr_exist <> 0)
            {
				$rrr = DATE("dmyHis").'v';

				$stmt = $mysqli->prepare("SELECT * FROM remitapayments_app WHERE RetrievalReferenceNumber = ?");
				$stmt->bind_param("s", $rrr);
				$stmt->execute();
				$stmt->store_result();
				$app_rrr_exist = $stmt->num_rows;

				$stmt = $mysqli->prepare("SELECT * FROM remitapayments WHERE RetrievalReferenceNumber = ?");
				$stmt->bind_param("s", $rrr);
				$stmt->execute();
				$stmt->store_result();
				$reg_rrr_exist = $stmt->num_rows;

				$stmt = $mysqli->prepare("SELECT * FROM s_tranxion_cr WHERE RetrievalReferenceNumber = ?");
				$stmt->bind_param("s", $rrr);
				$stmt->execute();
				$stmt->store_result();
				$r_rrr_exist = $stmt->num_rows;

				$lp_cnt++;
				if ($lp_cnt > 5)
				{
					break;
				}
			}
			
			$vApplicationNo_01 = $vApplicationNo_01.'+';
			
			//if (check_rrr($_REQUEST['rrr']) == 0)
			if (check_rrr($rrr) == 0)
			{
				//$transaction_desc = $_REQUEST['vDesc_loc'].' (Internal credit adjustment)';
				
				//$_REQUEST['vDesc_loc'] = 'Paid '.$_REQUEST['vDesc_loc'];
				
				//$nxt_sn = get_nxt_sn ($_REQUEST['uvApplicationNo'], '',$transaction_desc);
				$nxt_sn = get_nxt_sn ($_REQUEST['uvApplicationNo'], '',$_REQUEST['vDesc_loc']);

				$stmt_fee = $mysqli->prepare("SELECT a.fee_item_id, iItemID FROM s_f_s a, fee_items b 
				WHERE a.fee_item_id = b.fee_item_id 
				AND cEduCtgId = '$cEduCtgId'
				AND cFacultyId = '$cFacultyId'
				AND a.new_old_structure = 'o'
				AND b.fee_item_desc = 'Internal credit adjustment'");
				$stmt_fee->execute();
				$stmt_fee->store_result();
				$stmt_fee->bind_result($fee_item_id, $iItemID_lc_c);
				$stmt_fee->fetch();
				$stmt_fee->close();

				// $rssql = mysqli_query(link_connect_db(), "SELECT a.fee_item_id, iItemID FROM s_f_s a, fee_items b 
				// WHERE a.fee_item_id = b.fee_item_id 
				// AND cEduCtgId = '$cEduCtgId_01'
				// AND cFacultyId = '$cFacultyId_01'
				// AND b.fee_item_desc = 'Internal credit adjustment'") or die("error: ".mysqli_error(link_connect_db()));
				// $rs_iItemID = mysqli_fetch_array($rssql);
				// $fee_item_id = $rs_iItemID[0];
				// $iItemID_lc_c = $rs_iItemID[1];
				// mysqli_close(link_connect_db());
				

				$stmt = $mysqli->prepare("INSERT INTO s_tranxion_cr SET 
				RetrievalReferenceNumber = ?,
				vMatricNo = ?, 
				cCourseId = 'xxxxxx',
				tdate = NOW(),
				cTrntype = 'c', 
				iItemID = $iItemID_lc_c, 
				amount = ?,
				tSemester = $tSemester_01,
				cAcademicDesc = '".$orgsetins["cAcademicDesc"]."',
				siLevel = $iStudy_level_01,
				trans_count = $nxt_sn,
				fee_item_id = $fee_item_id,
				vremark = ?");
				$stmt->bind_param("ssis",$rrr, $_REQUEST['uvApplicationNo'], $_REQUEST['adj_amnt'], $_REQUEST['vDesc_loc']);
				$stmt->execute();
				$stmt->close();
				
				log_actv($_REQUEST['vDesc_loc'].' of '. $_REQUEST['adj_amnt']. ' for '.$_REQUEST['uvApplicationNo']);

				echo 'Account credited successfully';
				//echo $who_is_this.'#Account credited successfully';
			}else
			{
				echo 'Account already credited on this RRR';
				//echo $who_is_this.'#Account already credited on this RRR';
			}
		}else if ($_REQUEST['adj_type'] == 'd')
		{
			//$trn_bal = wallet_bal();
			
			// $trn_bal = wallet_bal1();

			// if ($trn_bal < $_REQUEST['adj_amnt'])
			// {
			// 	//echo $who_is_this.'#Insufficient balance of N'.number_format($trn_bal).' for '.$_REQUEST['uvApplicationNo'];exit;
				
			// 	echo 'Insufficient balance of N'.number_format($trn_bal).' for '.$_REQUEST['uvApplicationNo'];exit;
			// }    
			     
			$stmt_fee = $mysqli->prepare("SELECT a.fee_item_id, iItemID FROM s_f_s a, fee_items b 
			WHERE a.fee_item_id = b.fee_item_id 
			AND cEduCtgId = '$cEduCtgId'
			AND cFacultyId = '$cFacultyId'
			AND a.new_old_structure = 'o'
			AND b.fee_item_desc = 'Internal debit adjustment'");
			$stmt_fee->execute();
			$stmt_fee->store_result();
			$stmt_fee->bind_result($fee_item_id, $iItemID_lc_d);
			$stmt_fee->fetch();
			$stmt_fee->close();


			// $rssql = mysqli_query(link_connect_db(), "SELECT fee_item_id, iItemID FROM s_f_s a, fee_items b 
			// WHERE a.fee_item_id = b.fee_item_id 
			// AND cEduCtgId = '$cEduCtgId'
			// AND cFacultyId = '$cFacultyId'
			// AND a.new_old_structure = 'o'
			// AND b.fee_item_desc = 'Internal debit adjustment'") or die("error: ".mysqli_error(link_connect_db()));
			// $rs_iItemID = mysqli_fetch_array($rssql);
			// $fee_item_id = $rs_iItemID[0];
			// $iItemID_lc_d = $rs_iItemID[1];
			// mysqli_close(link_connect_db());

			// if (isset($_REQUEST["chk_refund"]))
			// {
			// 	$transaction_desc = $_REQUEST['vDesc_loc'].' (Internal debit adjustment - refund)';
			// }else 
			// {
			// 	$transaction_desc = $_REQUEST['vDesc_loc'].' (Internal debit adjustment)';
			// }

			
			try
			{
				$mysqli->autocommit(FALSE); //turn on transactions				

				//$nxt_sn = get_nxt_sn ($_REQUEST['uvApplicationNo'], '',$transaction_desc);
				$nxt_sn = get_nxt_sn ($_REQUEST['uvApplicationNo'], '',$_REQUEST['vDesc_loc']);

				$stmt = $mysqli->prepare("INSERT IGNORE INTO s_tranxion_20242025 SET 
				RetrievalReferenceNumber = '0000',
				vMatricNo = ?, 
				cCourseId = 'xxxxxx', 
				cTrntype = 'd', 
				iItemID = $iItemID_lc_d, 
				amount = ?,
				tSemester = $tSemester_01,
				cAcademicDesc = '".$orgsetins["cAcademicDesc"]."',
				siLevel = $iStudy_level_01,
				trans_count = $nxt_sn,
				fee_item_id = $fee_item_id,
				vremark = ?,
				tdate = '$date2'");
				$stmt->bind_param("sis",$_REQUEST['uvApplicationNo'], $_REQUEST['adj_amnt'], $_REQUEST['vDesc_loc']);
				$stmt->execute();
				//$stmt->close();
				
				log_actv('Internal debit adjustment of '. $_REQUEST['adj_amnt']. ' for '.$_REQUEST['uvApplicationNo']);
				
				$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
				
				//echo $who_is_this.'#Account debited successfully';
				
				echo 'Account debited successfully';
				$stmt->close();
			}catch(Exception $e) 
			{
				$mysqli->rollback(); //remove all queries from queue if error (undo)
				throw $e;
			}
		}
	}
}?>
