<?php 
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

//$currency = eyes_pilled('0');

$center_cond_std_basic = '';
$feed_back = '';
$orgsetins = settns();

$str = ''; $sql = '';


if (isset($_REQUEST['ilin']) && $_REQUEST['ilin'] <> '')
{
	if (isset($_REQUEST['tabno']))
	{
		if ($_REQUEST['tabno'] == '1' && $_REQUEST["vOrgName"] <> '')
		{
			$imgData = '';
			$imgName = '';
			
			if (isset($_FILES['sbtd_pix']) && $_FILES['sbtd_pix']['name'] <> '')
			{
				// $imgData = addslashes (file_get_contents($_FILES['sbtd_pix']['tmp_name']));
				// $imgName = $_FILES['sbtd_pix']['name'];
				
				// $flname = "pics/p_.jpg";				
				// @unlink($flname);

				// if (!move_uploaded_file($_FILES['sbtd_pix']['tmp_name'], "pics/" . $_FILES['sbtd_pix']['name']))
				// {
				// 	echo  "Upload failed, please try again"; exit;
				// }
				// rename("pics/" . $_FILES['sbtd_pix']['name'], $flname);
				// chmod($flname, 0755);
				
        		// $imgData = addslashes (file_get_contents($_FILES['sbtd_pix']['tmp_name']));
				// $imgName = $_FILES['sbtd_pix']['name'];
				
				//log_actv('Uploaded '.$file_name);
			}
			
			$a = trim($_REQUEST["vOrgName"]);
			$b = trim($_REQUEST["vOrgCityName"]);
			$c = trim($_REQUEST["vEMailId"]);
			
			$stmt = $mysqli->prepare("SELECT vOrgCityName, cOrgLGAId, cOrgStateId, cOrgCountryId, vEMailId, vMobileNo1 FROM settns");
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($vOrgCityName, $vLGADesc, $vStateName, $vCountryName, $vEMailId, $vMobileNo1);
			$number_of_record = $stmt->num_rows;
			$stmt->close();

			if ($number_of_record == 0)
			{
				$stmt = $mysqli->prepare("INSERT INTO settns
				set vOrgName = ?,
				cOrgCountryId = ?,
				cOrgStateId = ?,
				cOrgLGAId = ?,
				vOrgCityName = ?,
				vEMailId = ?,
				vMobileNo1 = ?,
				vMobileNo2 = ?,
				blogo = ?");
			}else
			{
				$stmt = $mysqli->prepare("UPDATE settns
				set vOrgName = ?,
				cOrgCountryId = ?,
				cOrgStateId = ?,
				cOrgLGAId = ?,
				vOrgCityName = ?,
				vEMailId = ?,
				vMobileNo1 = ?,
				vMobileNo2 = ?,
				blogo = ?");
			}
			
			$stmt->bind_param("sssssssss", $a, $_REQUEST["cOrgCountryId"], $_REQUEST["cOrgStateId"], $_REQUEST["cOrgLGAId"], $b, $c, $_REQUEST["vMobileNo1"], $_REQUEST["vMobileNo2"], $imgData);
			$stmt->execute();
			$stmt->close();
			
			$feed_back = 'Record successfully saved';			
			log_actv('Updated contact and ID of institution');
		}elseif (($_REQUEST['tabno'] == '2' && isset($_REQUEST["tSemester0"]) && $_REQUEST["tSemester0"] <> '') || isset($_REQUEST['tIdl_time_only']) || isset($_REQUEST['iextend_reg_only']) || isset($_REQUEST['iextend_tma_only']))
		{
			if (isset($_REQUEST['ses_only']) && $_REQUEST['ses_only'] == '1')
			{
				try
				{
					$mysqli->autocommit(FALSE);
					
					$stmt = $mysqli->prepare("UPDATE settns set
					sesdate0 = ?,
					sesdate1 = ?,
					cAcademicDesc = ?,
					actdate = curdate()");
					
					$stmt->bind_param("sss", 
					$_REQUEST["sesdate0"], 
					$_REQUEST["sesdate1"],  
					$_REQUEST["AcademicDesc"]);
			
					$stmt->execute();
		
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
					$stmt->close();
				}catch(Exception $e)
				{
				  $mysqli->rollback(); //remove all queries from queue if error (undo)
				  throw $e;
				}
				
				if (isset($_REQUEST["cStudyCenterId2"]))
				{
					log_actv('Updated session period for '.$_REQUEST["cStudyCenterId2"]);
				}else
				{
					log_actv('Updated session period');
				}
				$feed_back = 'Record of session successfully saved';
			}else if (isset($_REQUEST['sem_only']) && $_REQUEST['sem_only'] == '1')
			{
				try
				{
					$mysqli->autocommit(FALSE);
					
					$stmt = $mysqli->prepare("UPDATE settns set
					tSemester = ?,
					semdate1 = ?,
					semdate2 = ?,
					actdate = curdate()");
					
					$stmt->bind_param("iss", 
					$_REQUEST["tSemester0"], 
					$_REQUEST["semdate1"], 
					$_REQUEST["semdate2"]);
			
					$stmt->execute();
					log_actv('Updated semester period');
		
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
					$stmt->close();
				}catch(Exception $e)
				{
				  $mysqli->rollback(); //remove all queries from queue if error (undo)
				  throw $e;
				}
				
				
				
				$feed_back = 'Record of schedule for semester successfully saved';
			}else if (isset($_REQUEST['tIdl_time_only']) && $_REQUEST['tIdl_time_only'] == '1')
			{			
				$stmt1 = $mysqli->prepare("UPDATE settns set tIdl_time = ?");
				try
				{
					$mysqli->autocommit(FALSE);	
					
					$stmt1->bind_param("i", $_REQUEST['tIdl_time']);
					$stmt1->execute();

					log_actv('Set idle time to '.$_REQUEST['tIdl_time']);
		
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
					$stmt1->close();
					$feed_back = 'Record successfully updated';
				}catch(Exception $e)
				{
					$mysqli->rollback(); //remove all queries from queue if error (undo)
				 	throw $e;
				}					
			}else if (isset($_REQUEST['reg_only']) && $_REQUEST['reg_only'] == '1')
			{
				try
				{
					$mysqli->autocommit(FALSE);	

					$stmt1 = $mysqli->prepare("UPDATE settns set
					regdate1 = ?,
					regdate_100_200_2 = ?,
					regdate_300_2 = ?,
					actdate = curdate()");
				
					$stmt1->bind_param("sss", $_REQUEST["regdate1"], $_REQUEST["regdate_100_200_2"], $_REQUEST["regdate_300_2"]);
					$stmt1->execute();

					log_actv('Updated registration schedule');
		
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
					$stmt1->close();
					$feed_back = 'Updated registration schedule successfully';
				}catch(Exception $e)
				{
					$mysqli->rollback(); //remove all queries from queue if error (undo)
				 	throw $e;
				}					
			}else if (isset($_REQUEST['tma_only']) && $_REQUEST['tma_only'] == '1')
			{
				try
				{
					$mysqli->autocommit(FALSE);

					$stmt1 = $mysqli->prepare("UPDATE settns set
					tmadate1 = ?,
					tmadate2 = ?,
					actdate = curdate()");
				
					$stmt1->bind_param("ss", $_REQUEST["tmadate1"], $_REQUEST["tmadate2"]);
					$stmt1->execute();

					log_actv('Updated TMA schedule for');
		
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
					$stmt1->close();
					$feed_back = 'Updated TMA schedule successfully';
				}catch(Exception $e)
				{
					$mysqli->rollback(); //remove all queries from queue if error (undo)
				 	throw $e;
				}					
			}else if (isset($_REQUEST['exam_only']) && $_REQUEST['exam_only'] == '1')
			{
				try
				{
					$mysqli->autocommit(FALSE);

					$stmt1 = $mysqli->prepare("UPDATE settns set
					examdate1 = ?,
					examdate2 = ?,
					actdate = curdate()");				
					$stmt1->bind_param("ss", $_REQUEST["examdate1"], $_REQUEST["examdate2"]);
					$stmt1->execute();

					log_actv('Updated exam schedule for');
		
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
					$stmt1->close();
					$feed_back = 'Updated exams schedule successfully';
				}catch(Exception $e)
				{
					$mysqli->rollback(); //remove all queries from queue if error (undo)
				 	throw $e;
				}					
			}else if (isset($_REQUEST['app_close_open_date']))
			{
				try
				{
					$mysqli->autocommit(FALSE);

					$stmt1 = $mysqli->prepare("UPDATE settns set
					app_close_open_date = ?,
					actdate = curdate()");
					$stmt1->bind_param("s", $_REQUEST["app_close_open_date"]);
					$stmt1->execute();

					log_actv('Updated application open/closure schedule for');
		
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
					$stmt1->close();
				}catch(Exception $e)
				{
					$mysqli->rollback(); //remove all queries from queue if error (undo)
				 	throw $e;
				}
					
				$feed_back = 'Updated schedule for application successfully';
			}else if (isset($_REQUEST['admission_letter_date']))
			{
				try
				{
					$mysqli->autocommit(FALSE);

					$stmt1 = $mysqli->prepare("UPDATE settns set
					admission_letter_date = ?,
					actdate = curdate()");
					$stmt1->bind_param("s", $_REQUEST["admission_letter_date"]);
					$stmt1->execute();

					log_actv('Updated date of admission letter');
		
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
					$stmt1->close();
					$feed_back = 'Updated date of admission letter successfully';
				}catch(Exception $e)
				{
					$mysqli->rollback(); //remove all queries from queue if error (undo)
				 	throw $e;
				}
					
			}else if (isset($_REQUEST['cemba_cempa_only']) && $_REQUEST['cemba_cempa_only'] == '1')
			{
				try
				{
					$mysqli->autocommit(FALSE);

					$stmt1 = $mysqli->prepare("UPDATE settns set
					cemba_cempa_date1 = ?,
					cemba_cempa_date2 = ?,
					actdate = curdate()");				
					$stmt1->bind_param("ss", $_REQUEST["cemba_cempa_date1"], $_REQUEST["cemba_cempa_date2"]);
					$stmt1->execute();

					log_actv('Updated CEMBA/CEMPA applicaton period for');
		
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
					$stmt1->close();
					$feed_back = 'Updated CEMBA/CEMPA applicaton period successfully';
				}catch(Exception $e)
				{
					$mysqli->rollback(); //remove all queries from queue if error (undo)
				 	throw $e;
				}					
			}else
			{
				try
				{
					$mysqli->autocommit(FALSE);
					
					/*if ($_REQUEST['session_year0_h'] <> $_REQUEST['AcademicDesc'] || $_REQUEST['sesdate1_h'] <> $_REQUEST['sesdate1'])
					{
						$stmt = $mysqli->prepare("UPDATE settns set
						tSemester = ?,
						sesdate0 = ?,
						sesdate1 = ?,
						cAcademicDesc = ?,
						semdate1 = ?,
						semdate2 = ?,
						regdate1 = ?,
						regdate_100_200_2 = ?,
						regdate_300_2 = ?,
						tIdl_time = ?,
						tmadate1 = ?,
						tmadate2 = ?,
						examdate1 = ?,
						examdate2 = ?,
						drp_exam = '0',
						drp_examdate = '00000000',
						drp_crs = '0',
						drp_crsdate = '00000000',
						late_fee = '0',
						cShowgrade = '0',
						cShowscore = '0',
						cShowgpa = '0',
						cShowtt = '0',
						poptt = '0',
						examtt = '0',
						late_regdate = '00000000',
						actdate = curdate()");
						
						$stmt->bind_param("issssssissssss", 
						$_REQUEST["tSemester0"], 
						$_REQUEST["sesdate0"], 
						$_REQUEST["sesdate1"], 
						$_REQUEST["AcademicDesc"], 
						$_REQUEST["semdate1"], 
						$_REQUEST["semdate2"],
						$_REQUEST["regdate1"], 
						$_REQUEST["regdate_100_200_2"], 
						$_REQUEST["regdate_300_2"],
						$_REQUEST['tIdl_time'],
						$_REQUEST["tmadate1"], 
						$_REQUEST["tmadate2"], 
						$_REQUEST["examdate1"], 
						$_REQUEST["examdate2"]);
				
						$stmt->execute();
						$stmt->close();

						log_actv('Updated session to new session');
						$feed_back = 'Records updated successfully';
					}*/

					//$count_active = 0;
					//$count_inactive = 0;
					

					if ($_REQUEST['session_year0_h'] <> $_REQUEST['AcademicDesc'] || $_REQUEST['sesdate1_h'] <> $_REQUEST['sesdate1'])
					{
						$stmt = $mysqli->prepare("UPDATE settns set
						tSemester = ?,
						sesdate0 = ?,
						sesdate1 = ?,
						cAcademicDesc = ?,
						semdate1 = ?,
						semdate2 = ?,
						regdate1 = ?,
						regdate_100_200_2 = ?,
						regdate_300_2 = ?,
						tIdl_time = ?,
						tmadate1 = ?,
						tmadate2 = ?,
						examdate1 = ?,
						examdate2 = ?,
						drp_exam = '0',
						drp_examdate = '00000000',
						drp_exam_2 = '0',
						drp_exam_2date = '00000000',
						drp_crs = '0',
						drp_crsdate = '00000000',
						late_fee = '0',
						cShowgrade = '0',
						cShowscore = '0',
						cShowgpa = '0',
						cShowtt = '0',
						poptt = '0',
						examtt = '0',
						late_regdate = '00000000',
						actdate = curdate()");
						
						$stmt->bind_param("issssssissssss", 
						$_REQUEST["tSemester0"], 
						$_REQUEST["sesdate0"], 
						$_REQUEST["sesdate1"], 
						$_REQUEST["AcademicDesc"], 
						$_REQUEST["semdate1"], 
						$_REQUEST["semdate2"],
						$_REQUEST["regdate1"], 
						$_REQUEST["regdate_100_200_2"], 
						$_REQUEST["regdate_300_2"],
						$_REQUEST['tIdl_time'],
						$_REQUEST["tmadate1"], 
						$_REQUEST["tmadate2"], 
						$_REQUEST["examdate1"], 
						$_REQUEST["examdate2"]);
				
						$stmt->execute();

						log_actv('Updated session to new session');
						$feed_back = 'Records updated successfully';
						
						//$stmt3_3 = $mysqli->prepare("UPDATE s_m_t SET session_reg = '0', semester_reg = '0' WHERE (cProgrammeId NOT LIKE '___5%' AND cProgrammeId NOT LIKE '___6%'");
						date_default_timezone_set('Africa/Lagos');
						$current_year = date("Y");
						$stmt3_3 = $mysqli->prepare("UPDATE s_m_t SET session_reg = '0', semester_reg = '0', cAcademicDesc = '$current_year'");
					}else if ($_REQUEST["tSemester0"] <> $_REQUEST["tSemester0_h"])
					{
						$stmt = $mysqli->prepare("UPDATE settns set
						tSemester = ?,
						semdate1 = ?,
						semdate2 = ?,
						regdate1 = ?,
						regdate_100_200_2 = ?,
						regdate_300_2 = ?,
						tIdl_time = ?,
						tmadate1 = ?,
						tmadate2 = ?,
						late_fee = '0',
						cShowrslt = '0',
						cShowgrade = '0',
						cShowscore = '0',
						cShowgpa = '0',
						cShowtt = '0',
						poptt = '0',
						examtt = '0',
						late_regdate = '00000000',
						actdate = curdate()");
						
						$stmt->bind_param("issssssss", 
						$_REQUEST["tSemester0"], 
						$_REQUEST["semdate1"], 
						$_REQUEST["semdate2"], 
						$_REQUEST["regdate1"], 
						$_REQUEST["regdate_100_200_2"], 
						$_REQUEST["regdate_300_2"],
						$_REQUEST['tIdl_time'],
						$_REQUEST["tmadate1"], 
						$_REQUEST["tmadate2"]);
						$stmt->execute();
						log_actv('Effected semester switching');

						$stmt3_3 = $mysqli->prepare("UPDATE s_m_t SET semester_reg = '0'");
					}

					if (isset($stmt3_3))
					{
						$stmt3_3->execute();
						$stmt3_3->close();
						
						$stmt->close();
					}

					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

					//$feed_back = $count_active.' records advanced successfully<br>'.$count_inactive.' records archived successfully<br>';
					$feed_back = $count_active.' records updated successfully';
				}catch(Exception $e)
				{
				  $mysqli->rollback(); //remove all queries from queue if error (undo)
				  throw $e;
				}				
			}			
		}elseif ($_REQUEST['tabno'] == '3')
		{
			try
			{
				$mysqli->autocommit(FALSE);

				$stmt = $mysqli->prepare("DELETE FROM mat_composi");
				$stmt->execute();
				$stmt->close();

				$stmt = $mysqli->prepare("INSERT INTO mat_composi set 
				matnoprefix1 = ?,
				place_sepa1 = ?,
				matnoprefix2 = ?,
				place_sepa2 = ?,
				matnosepa = ?,
				matnosufix = ?,
				place_sepa7 = ?,
				prefix_by_yr = ?,
				place_sepa5 = ?,
				prefix_by_dept = ?,
				place_sepa4 = ?,
				prefix_by_faculty = ?,
				place_sepa3 = ?,
				sampl_compoMat = ?,
				mat_comp_orda = ?");

				$stmt->bind_param("sssssssssssssss", $_REQUEST["matnoprefix1"], $_REQUEST["place_sepa1"], $_REQUEST["matnoprefix2"], $_REQUEST["place_sepa2"], $_REQUEST["matnosepa"], $_REQUEST["matnosufix"], $_REQUEST["place_sepa7"], $_REQUEST["prefix_by_yr"], $_REQUEST["place_sepa5"], $_REQUEST["prefix_by_dept"], $_REQUEST["place_sepa4"], $_REQUEST["prefix_by_faculty"], $_REQUEST["place_sepa3"], $_REQUEST["sampl_compoMat"], $_REQUEST["mat_comp_orda"]);
				$stmt->execute();
							
				log_actv('Updated composition of matriculation number');

				$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
				$stmt->close();
				$feed_back = 'Record successfully saved';	
			}catch(Exception $e)
			{
			  $mysqli->rollback(); //remove all queries from queue if error (undo)
			  throw $e;
			}			
		}elseif ($_REQUEST['tabno'] == '4')
		{
			if (($_REQUEST['mm'] == '1' && $_REQUEST['sm'] == '11') || ($_REQUEST['mm'] == '7' && $_REQUEST['sm'] == '3'))
			{
				try
				{
					$mysqli->autocommit(FALSE);

					$stmt1 = $mysqli->prepare("UPDATE settns set 
					studycenter = ?,
					semster_adm = ?,
					mail_req_rec1 = ?,
					mail_req_rec2 = ?,
					mail_req_rec3 = ?,
					cShowtt = ?,
					period_of_result_upload = ?,
					semester_of_result_upload = ?,
					session_of_result_upload = ?,
					cShowrslt = ?,
					cShowrslt_for_staff = ?,
					cShowrslt_for_student = ?,
					cShowgrade = ?,
					cShowscore = ?,
					cShowgpa = ?,
					sem_reg = ?,
					onlineca = ?,
					numoftma = ?,
					pc_char = ?,
					cc_char = ?,
					regexam = ?, 
					drp_exam = ?,
					drp_examdate = ?,
					drp_exam_2 = ?,
					drp_exam_2date = ?,
					drp_crs = ?,
					drp_crsdate = ?,
					upld_passpic = ?,
					upld_passpic_no = ?,
					enforce_co = ?,
					enforce_cc = ?,
					overall_ca = ?,
					overall_ex = ?,
					req_mail_level_cahnge = ?,
					req_mail_level_cahnge_cc1 = ?,
					req_mail_level_cahnge_cc2 = ?,
					req_mail_prog_cahnge = ?,
					req_mail_prog_cahnge_cc1 = ?,
					req_mail_prog_cahnge_cc2 = ?,
					req_mail_cent_cahnge = ?,
					req_mail_cent_cahnge_cc1 = ?,
					req_mail_cent_cahnge_cc2 = ?,
					wait_max_login = ?,
					max_login = ?,
					transission_in_progress = ?");
					if (isset($_REQUEST["ind_semster"]))
					{					
						$stmt2 = $mysqli->prepare("UPDATE settns set ind_semster = ?");
					}else
					{
						$stmt2 = $mysqli->prepare("UPDATE settns set ind_semster = '0'");
					}
					
					if ($_REQUEST['mm'] == '7' && $_REQUEST['sm'] == '3')
					{
						$stmt4 = $mysqli->prepare("UPDATE settns set course_fee_cat = ?, course_fee_course = ?, course_fee_credit_unit = ?, exam_fee = ?");
					}

					$stmt1->bind_param("sssssssisssssssssssssssssssssissssssssssssiis", $_REQUEST["studycenter"], $_REQUEST["semster_adm"], $_REQUEST["mailreqrec1"], $_REQUEST["mailreqrec2"], $_REQUEST["mailreqrec3"], $_REQUEST["cShowtt"], $_REQUEST["period_of_result_upload"], $_REQUEST["semester_of_result_upload"], $_REQUEST["session_of_result_upload"], $_REQUEST["cShowrslt"], $_REQUEST["cShowrslt_for_staff"], $_REQUEST["cShowrslt_for_student"], $_REQUEST["cShowgrade"], $_REQUEST["cShowscore"], $_REQUEST["cShowgpa"], $_REQUEST["sem_reg"], $_REQUEST["onlineca"], $_REQUEST["numoftma"], $_REQUEST["pc_char"], $_REQUEST["cc_char"], $_REQUEST["regexam"], $_REQUEST["drp_exam"], $_REQUEST["drp_examdate"], $_REQUEST["drp_exam_2"], $_REQUEST["drp_exam_2date"], $_REQUEST["drp_crs"], $_REQUEST["drp_crsdate"], $_REQUEST["upld_passpic"], $_REQUEST["upld_passpic_no"], $_REQUEST["enforce_co"], $_REQUEST["enforce_cc"], $_REQUEST["overall_ca"],$_REQUEST["overall_ex"],$_REQUEST["req_mail_level_cahnge"],$_REQUEST["req_mail_level_cahnge_cc1"],$_REQUEST["req_mail_level_cahnge_cc2"],$_REQUEST["req_mail_prog_cahnge"],$_REQUEST["req_mail_prog_cahnge_cc1"],$_REQUEST["req_mail_prog_cahnge_cc2"],$_REQUEST["req_mail_cent_cahnge"],$_REQUEST["req_mail_cent_cahnge_cc1"],$_REQUEST["req_mail_cent_cahnge_cc2"],$_REQUEST["wait_max_login"],$_REQUEST["max_login"],$_REQUEST["transission_in_progress"]);
			
					$stmt1->execute();

					if (isset($_REQUEST["ind_semster"]))
					{
						$stmt2->bind_param("s", $_REQUEST["ind_semster"]);
						$stmt2->execute();
					}else
					{
						$stmt2->execute();
					}

					if ($_REQUEST["regexam"] == '0')
					{					
						$stmt3->execute();
					}
					
					if ($_REQUEST['mm'] == '7' && $_REQUEST['sm'] == '3')
					{
						$stmt4->bind_param("ssss", $_REQUEST["course_fee_cat"], $_REQUEST["course_fee_course"], $_REQUEST["course_fee_credit_unit"], $_REQUEST["exam_fee"]);
						$stmt4->execute();
					}
					
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
					$stmt1->close();

					$stmt2->close();

					if ($_REQUEST["regexam"] == '0')
					{					
						$stmt3->close();
					}
					
					if ($_REQUEST['mm'] == '7' && $_REQUEST['sm'] == '3')
					{					
						$stmt4->close();
					}
				}catch(Exception $e)
				{
				  $mysqli->rollback(); //remove all queries from queue if error (undo)
				  throw $e;
				}
			}else if ($_REQUEST['mm'] == '2' && $_REQUEST['sm'] == '10')
			{
				try
				{
					$mysqli->autocommit(FALSE);
					
					$stmt = $mysqli->prepare("UPDATE settns set
					rr_sys = ?,
					cloadfund = ?,
					late_fee = ?,
					late_regdate = '00000000',
					semreg_fee = ?,
					course_fee_cat = ?,
					course_fee_course = ?,
					course_fee_credit_unit = ?,
					exam_fee = ?,
					ewallet_cred_for_ses_reg = ?,
					ewallet_cred_for_sem_reg = ?,
					uni_give_mat = ?,
					ac_close_date = ?,
					ac_open_date = ?");

					$stmt->bind_param("sssssssssssss", 
					$_REQUEST["rr_sys"], 
					$_REQUEST["loadfund"], 
					$_REQUEST["late_fee"],
					$_REQUEST["semreg_fee"], 
					$_REQUEST["course_fee_cat"], 
					$_REQUEST["course_fee_course"], 
					$_REQUEST["course_fee_credit_unit"], 
					$_REQUEST["exam_fee"], 
					$_REQUEST["ewallet_cred_for_ses_reg"], 
					$_REQUEST["ewallet_cred_for_sem_reg"], 
					$_REQUEST["uni_give_mat"], 
					$_REQUEST["ac_close"], 
					$_REQUEST["ac_open"]);
					$stmt->execute();
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
					$stmt->close();
				}catch(Exception $e)
				{
				  $mysqli->rollback(); //remove all queries from queue if error (undo)
				  throw $e;
				}
			}else if ($_REQUEST['mm'] == '7' && $_REQUEST['sm'] == '3')
			{
				try
				{
					$mysqli->autocommit(FALSE);	
					$stmt = $mysqli->prepare("UPDATE settns set
					size_cred = ?,
					size_pp = ?");
					$stmt->bind_param("ii", $_REQUEST["size_cred"], $_REQUEST["size_pp"]);						
					$stmt->execute();
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
					$stmt->close();
				}catch(Exception $e)
				{
					$mysqli->rollback(); //remove all queries from queue if error (undo)
					throw $e;
				}
			}

			
			
			if (isset($_REQUEST['student_req1']))
			{
				try
				{
					$mysqli->autocommit(FALSE);	
					$stmt = $mysqli->prepare("UPDATE settns set
					student_req1 = ?,
					student_req2 = ?");
					$stmt->bind_param("ss", $_REQUEST["student_req1"], $_REQUEST["student_req2"]);						
					$stmt->execute();
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
					$stmt->close();
				}catch(Exception $e)
				{
					$mysqli->rollback(); //remove all queries from queue if error (undo)
					throw $e;
				}
			}
			
			$feed_back = 'Record successfully saved';			
			log_actv('Updated options');
		}elseif ($_REQUEST['tabno'] == '5')
		{
			if (isset($_REQUEST["showttOnly"]))
			{
				$stmt = $mysqli->prepare("UPDATE settns SET cShowtt = ?");
				$stmt->bind_param("s", $_REQUEST["showttOnly"]);
				$stmt->execute();
				echo 'Timetable status successfully updated';exit;
			}
			
			$target_file = basename($_FILES["sbtd_pix1"]["name"]); 
			$file_name_ext = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			if ($file_name_ext <> 'csv')
			{
				echo 'Select file of CSV type to upload for timetable'; exit;
			}
			
			
			$file_name = "../../ext_docs/docs/" . $target_file;
			//$file_name = EXT_DOC1."docs/".$target_file;
			@unlink($file_name);

			
			if (!move_uploaded_file($_FILES['sbtd_pix1']['tmp_name'], $file_name))
			{
				echo  "Upload failed, please try again"; exit;
			}
			
			if ($_REQUEST['examType'] == 'p')
			{
				$new_file_name = "../../ext_docs/docs/popexam.".$file_name_ext;
				//$new_file_name = EXT_DOC1."docs/popexam.".$file_name_ext;
        
        		rename($file_name, $new_file_name);
				chmod($new_file_name, 0755);
				$sql = "UPDATE settns set poptt = '1'";			
				log_actv('Uploaded pop-exam timetable');
			}elseif ($_REQUEST['examType'] == 'e')
			{
				$new_file_name = "../../ext_docs/docs/eexam.".$file_name_ext;
				//$new_file_name = EXT_DOC1."docs/eexam.".$file_name_ext;

				rename($file_name, $new_file_name);
				chmod($new_file_name, 0755);
				$sql = "UPDATE settns set examtt = '1'";			
				log_actv('Uploaded e-exam timetable');
			}

			
			$handle = fopen("$new_file_name", "r");
			try
			{
				$mysqli->autocommit(FALSE);
			
				$stmt = $mysqli->prepare("replace into tt 
				(cCourseId, 
				iday, 
				cSession, 
				exam_date,
				final)
				values
				(?, ?, ?, ?, ?)");

				$count = 0;
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
				{					
					if (count($data) <> 4) 
					{
						fclose($handle);
						unlink($new_file_name) or die("Couldn't continue process ");

						echo 'There should be 4 columns of data';
						exit;
					}
					
					if (strlen(trim($data[0])) <> 6 || trim($data[1]) == '' || trim($data[2]) == '')
					{
						echo 'Timetable contains invalid data at row '.$count;
						exit;
					}
				
					$stmt->bind_param("sisss", $data[0], $data[1], $data[2], $data[3], $_REQUEST["examType_df"]);
					$stmt->execute();
					$count++;
				}
			
				$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
				$stmt->close();
			}catch(Exception $e)
			{
				$count = 0;
				$mysqli->rollback(); //remove all queries from queue if error (undo)
				throw $e;
			}

			$feed_back = 'File successfully saved';
		}
		
		if ($sql <> '')
		{
			mysqli_query(link_connect_db(), $sql)or die("error: updating seeting-mat no ".mysqli_error(link_connect_db()));
		}

		if ($feed_back <> '')
		{
			echo $feed_back;
		}else
		{
			echo 'There are no changes to save';
		}
	}
}else if (isset($_REQUEST['call_mat_no']))
{	
	$stmt = $mysqli->prepare("SELECT matnoprefix1, 
	place_sepa1, 
	matnoprefix2, 
	place_sepa2, 
	matnosepa, 
	matnosufix, 
	place_sepa7, 
	prefix_by_faculty, 
	place_sepa3, 
	prefix_by_dept, 
	place_sepa4, 
	prefix_by_yr, 
	place_sepa5, 
	matnumber, 
	sampl_compoMat, 
	mat_comp_orda, 
	uni_give_mat 
	study_mode FROM mat_composi");
	$stmt->execute();	
	$stmt->store_result();
	$stmt->bind_result($matnoprefix1, 
	$place_sepa1, 
	$matnoprefix2, 
	$place_sepa2, 
	$matnosepa, 
	$matnosufix, 
	$place_sepa7, 
	$prefix_by_faculty, 
	$place_sepa3, 
	$prefix_by_dept, 
	$place_sepa4, 
	$prefix_by_yr, 
	$place_sepa5, 
	$matnumber, 
	$sampl_compoMat, 
	$mat_comp_orda, 
	$uni_give_mat);

	$stmt->fetch();
	
	$str = '';
	$str = str_pad($matnoprefix1,50).
	str_pad($place_sepa1,50).
	str_pad($matnoprefix2,50). 
	str_pad($place_sepa2,50).
	str_pad($matnosepa,50).
	str_pad($matnosufix,50).
	str_pad($place_sepa7,50).
	str_pad($prefix_by_faculty,50).
	str_pad($place_sepa3,50).
	str_pad($prefix_by_dept,50).
	str_pad($place_sepa4,50).
	str_pad($prefix_by_yr,50).
	str_pad($place_sepa5,50).
	str_pad($matnumber,50).
	str_pad($sampl_compoMat,50).
	str_pad($mat_comp_orda,50).
	str_pad($uni_give_mat,50);
		
	echo $str;
	$stmt->close();
}else if (isset($_REQUEST['call_options_val']))
{
	$stmt = $mysqli->prepare("SELECT  
	studycenter, 
	semster_adm, 
	ind_semster, 
	sem_reg,
	onlineca,
	period_of_result_upload,
	semester_of_result_upload,
	session_of_result_upload, 
	cShowrslt,
	examtt, 
	poptt,
	cShowtt,  
	drp_crs, 
	drp_crsdate,
	regexam,
	drp_exam, 
	drp_examdate,
	drp_exam_2, 
	drp_exam_2date, 
	upld_passpic, 
	upld_passpic_no, 
	size_pp,  
	size_cred, 
	pc_char, 
	cc_char, 
	enforce_co,
	enforce_cc,
	rr_sys,
	cloadfund,
	late_fee,
	semreg_fee, 
	course_fee_cat,
	course_fee_course,  
	course_fee_credit_unit, 
	exam_fee, 
	ewallet_cred_for_ses_reg,
	ewallet_cred_for_sem_reg,  
	uni_give_mat,
	cShowgrade,
	cShowscore,
	cShowgpa, 
	overall_ca,
	overall_ex,
	cShowrslt_for_staff,
	cShowrslt_for_student
	FROM settns");

	$stmt->execute();	
	$stmt->store_result();
	$stmt->bind_result(  
	$studycenter, 
	$semster_adm, 
	$ind_semster, 
	$sem_reg,
	$onlineca,
	$period_of_result_upload,
	$semester_of_result_upload,
	$session_of_result_upload,  
	$cShowrslt,
	$examtt, 
	$poptt,
	$cShowtt,  
	$drp_crs, 
	$drp_crsdate,
	$regexam,
	$drp_exam, 
	$drp_examdate,
	$drp_exam_2, 
	$drp_exam_2date, 
	$upld_passpic, 
	$upld_passpic_no, 
	$size_pp,  
	$size_cred, 
	$pc_char, 
	$cc_char, 
	$enforce_co, 
	$enforce_cc,
	$rr_sys,
	$cloadfund,
	$late_fee,
	$semreg_fee,
	$course_fee_cat,
	$course_fee_course,  
	$course_fee_credit_unit,  
	$exam_fee, 
	$ewallet_cred_for_ses_reg,
	$ewallet_cred_for_sem_reg,  
	$uni_give_mat,
	$cShowgrade,
	$cShowscore,
	$cShowgpa,
	$overall_ca,
	$overall_ex,
	$cShowrslt_for_staff,
	$cShowrslt_for_student);

	$stmt->fetch();
	
	$str = '';
	$str = str_pad($studycenter,10). 
	str_pad($semster_adm,10). 
	str_pad($ind_semster,10). 
	str_pad($sem_reg,10).
	str_pad($onlineca,10). 
	str_pad($cShowrslt,10).
	str_pad($examtt,10). 
	str_pad($poptt,10).
	str_pad($cShowtt,10).  
	str_pad($drp_crs,10). 
	str_pad($drp_crsdate,10).
	str_pad($regexam,10).
	str_pad($drp_exam,10). 
	str_pad($drp_examdate,10). 
	str_pad($upld_passpic,10). 
	str_pad($upld_passpic_no,10). 
	str_pad($size_pp,10).  
	str_pad($size_cred,10). 
	str_pad($pc_char,10). 
	str_pad($cc_char,10). 
	str_pad($enforce_co,10).
	str_pad($rr_sys,10).
	str_pad($cloadfund,10).
	str_pad($late_fee,10).
	str_pad($semreg_fee,10).  
	str_pad($course_fee_cat,10).
	str_pad($course_fee_course,10).
	str_pad($course_fee_credit_unit,10).	
	str_pad($exam_fee,10). 
	str_pad($ewallet_cred_for_ses_reg,10).
	str_pad($ewallet_cred_for_sem_reg,10).  
	str_pad($uni_give_mat,10).  
	str_pad($cShowgrade,10).  
	str_pad($cShowscore,10).  
	str_pad($cShowgpa,10).  
	str_pad($overall_ca,10).  
	str_pad($overall_ex,10).  
	str_pad($period_of_result_upload,10).  
	str_pad($semester_of_result_upload,10).  
	str_pad($session_of_result_upload,10). 
	str_pad($cShowrslt_for_staff,10).  
	str_pad($cShowrslt_for_student,10).
	str_pad($enforce_cc,10).
	str_pad($drp_exam_2,10). 
	str_pad($drp_exam_2date,10);
	
	
	echo $str;
	$stmt->close();
}else if (isset($_REQUEST['call_date_val']))
{
	$stmt = $mysqli->prepare("SELECT
	sesdate0, 
	sesdate1,
	semdate1, 
	semdate2,
	regdate1, 
	regdate_100_200_2, 
	regdate_300_2,
	tSemester, 
	iextend_reg, 
	examregdate1, 
	examregdate_100_200_2, 
	examregdate_300_2,
	iextend_exam, 
	tmadate1, 
	tmadate2, 
	iextend_tma,
	tIdl_time,
	semreg_fee, 
	force_session_open,
	force_semester_open,
	force_registration_open,
	force_examreg_open,
	cAcademicDesc,
  	app_close_open_date,
	applic_session,
	onlineca
	FROM settns LIMIT 1");
	$stmt->execute();	
	$stmt->store_result();
	$stmt->bind_result( 
	$sesdate0, 
	$sesdate1,
	$semdate1, 
	$semdate2, 
	$regdate1, 
	$regdate_100_200_2, 
	$regdate_300_2,
	$tSemester, 
	$iextend_reg, 
	$examregdate1, 
	$examregdate_100_200_2, 
	$examregdate_300_2,
	$iextend_exam, 
	$tmadate1, 
	$tmadate2, 
	$iextend_tma,
	$tIdl_time,
	$semreg_fee, 
	$force_session_open,
	$force_semester_open, 
	$force_registration_open,  
	$force_examreg_open, 
	$cAcademicDesc,
  	$app_close_open_date,
	$applic_session,
	$onlineca);

	$stmt->fetch();
	
	$str = '';
	$str = str_pad($sesdate0,10).
	str_pad($sesdate1,10).
	str_pad($tSemester,10).
	str_pad($semdate1,10).
	str_pad($semdate2,10).
	str_pad($regdate_100_200_2,10).
	str_pad($regdate_300_2,10).
	str_pad($iextend_reg,10).
	str_pad($examregdate1,10).
	str_pad($examregdate_100_200_2,10).
	str_pad($examregdate_300_2,10).
	str_pad($iextend_exam,10).
	str_pad($tmadate1,10).
	str_pad($tmadate2,10).
	str_pad($iextend_tma,10).
	str_pad($tIdl_time,10).
	str_pad($semreg_fee,10).
	str_pad($force_session_open,10).
	str_pad($force_semester_open,10).
	str_pad($force_registration_open,10).
	str_pad($force_examreg_open,10).
	str_pad($cAcademicDesc,10).
	str_pad($app_close_open_date,10).
	str_pad($applic_session,10).
	str_pad($onlineca,10);
		
	echo $str;
	$stmt->close();
}?>