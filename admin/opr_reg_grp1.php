<?php
require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$currency = eyes_pilled('0');

$orgsetins = settns();
$str = '';

if (isset($_REQUEST['save_cf']) && $_REQUEST['save_cf'] == '1' && isset($_REQUEST['currency_cf']) && $_REQUEST['currency_cf'] == '1')
{
	if ($_REQUEST['mm'] == 1 || $_REQUEST['mm'] == 8)
	{
		$cProgrammeId_std = ''; $who_is_this = '';
		if ($_REQUEST['sm'] == 1 || $_REQUEST['sm'] == 2 || $_REQUEST['sm'] == 4 || $_REQUEST['sm'] == 5 || $_REQUEST['sm'] == '6')
		{
			if ((isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == 0 && $_REQUEST['sm'] == '4') || $_REQUEST['sm'] == '1' || $_REQUEST['sm'] == '5' || $_REQUEST['sm'] == '6')
			{
				$a = trim($_REQUEST["uvApplicationNo"]);
				if (isset($_REQUEST['id_no']))
				{
					if ($_REQUEST['id_no'] == '0')
					{
						$stmt = $mysqli->prepare("select a.cSbmtd, a.iBeginLevel, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, a.vLastName, a.vFirstName, a.vOtherName 
						from prog_choice a, programme b, obtainablequal c
						where a.cProgrammeId = b.cProgrammeId and 
						b.cObtQualId = c.cObtQualId and
						a.vApplicationNo = ?");
					}else
					{
						/*$stmt = $mysqli->prepare("select a.cSbmtd, a.iBeginLevel, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, d.vLastName, d.vFirstName, d.vOtherName,
						from prog_choice a, programme b, obtainablequal c, pers_info d, afnmatric e, s_m_t f
						where a.cProgrammeId = b.cProgrammeId and 
						b.cObtQualId = c.cObtQualId and
						d.vApplicationNo = a.vApplicationNo and
						e.vApplicationNo = a.vApplicationNo and
						e.vMatricNo = f.vMatricNo and
						and e.vMatricNo = ?");*/
						$stmt = $mysqli->prepare("select a.cSbmtd, a.iBeginLevel, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, f.vLastName, f.vFirstName, f.vOtherName,
						from prog_choice a, programme b, obtainablequal c, afnmatric e, s_m_t f
						where a.cProgrammeId = b.cProgrammeId and 
						b.cObtQualId = c.cObtQualId and
						e.vApplicationNo = a.vApplicationNo and
						e.vMatricNo = f.vMatricNo and
						and e.vMatricNo = ?");
					}
				}else
				{
					$stmt = $mysqli->prepare("select a.cSbmtd, a.iBeginLevel, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, a.vLastName, a.vFirstName, a.vOtherName 
					from prog_choice a, programme b, obtainablequal c 
					where a.cProgrammeId = b.cProgrammeId and 
					b.cObtQualId = c.cObtQualId and
					a.vApplicationNo = ?");
				}
				$stmt->bind_param("s", $a);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($acSbmtd, $iBeginLevel, $cProgrammeId, $vObtQualTitle, $vProgrammeDesc, $vLastName, $vFirstName, $vOtherName);
				
				if ($stmt->num_rows === 0)
				{	 
					if (isset($_REQUEST['id_no']))
					{
						if ($_REQUEST['id_no'] == '0')
						{
							echo 'Invalid application number';exit; 
						}else
						{
							echo 'Invalid matriculation number';exit; 
						}
					} 
				}

				$stmt->fetch();
				if ($cSbmtd == '0' && $_REQUEST['sm'] == 6)
				{
					$stmt->close();
					echo 'Form not submitted';exit;
				}
				$stmt->close();

				if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] >= 5)
				{
					$who_is_this = $_REQUEST['uvApplicationNo'].'+';
				}else
				{
					$who_is_this = $vObtQualTitle.'<br>'.
					$vProgrammeDesc.'@'.
					$vLastName.'<br>'.
					$vFirstName.'<br>'.
					$vOtherName.'^'.
					$iBeginLevel.'#';
				}
				$stmt->close();
			}elseif ((isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == 1) || $_REQUEST['sm'] == '2' || $_REQUEST['sm'] == '3' || (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] > 1))
			{
				$a = trim($_REQUEST["uvApplicationNo"]);

				if (isset($_REQUEST['id_no']))
				{
					if ($_REQUEST['id_no'] == '0')
					{
						// $stmt = $mysqli->prepare("select a.vApplicationNo, f.iStudy_level, f.tSemester, a.cSbmtd, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, d.vLastName, d.vFirstName, d.vOtherName 
						// from prog_choice a, programme b, obtainablequal c, pers_info d, afnmatric e, s_m_t f
						// where a.cProgrammeId = b.cProgrammeId and 
						// b.cObtQualId = c.cObtQualId and
						// d.vApplicationNo = a.vApplicationNo and
						// e.vApplicationNo = a.vApplicationNo and
						// e.vMatricNo = f.vMatricNo and 
						// e.vApplicationNo = ?");

						$stmt = $mysqli->prepare("SELECT a.vApplicationNo, 1, a.iBeginLevel iStudy_level, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, a.vLastName, a.vFirstName, a.vOtherName 
						FROM prog_choice a, programme b, obtainablequal c
						WHERE a.cProgrammeId = b.cProgrammeId  
						AND b.cObtQualId = c.cObtQualId 
						AND a.vApplicationNo = ?");
					}else
					{
						$stmt = $mysqli->prepare("select a.vApplicationNo, a.tSemester, a.iStudy_level, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, a.vLastName, a.vFirstName, a.vOtherName 
						from s_m_t a, programme b, obtainablequal c, afnmatric e
						where a.cProgrammeId = b.cProgrammeId and 
						b.cObtQualId = c.cObtQualId and
						e.vApplicationNo = a.vApplicationNo and
						e.vMatricNo = a.vMatricNo and 
						e.vMatricNo = ?");
					}
					$stmt->bind_param("s", $a);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($vApplicationNo, $tSemester, $iStudy_level, $cProgrammeId, $vObtQualTitle, $vProgrammeDesc, $vLastName, $vFirstName, $vOtherName);
				}
				
				if ($stmt->num_rows === 0)
				{	
					if ($_REQUEST['id_no'] == '0')
					{
						echo 'No match found';exit; 
					}else if (check_grad_student($a) == 1)
					{
						echo 'Matriculation number graduated';exit;
					}else
					{
						echo 'No match found';exit; 
					}                    
				}
				
				$stmt->fetch();
				if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] >= 5)
				{
					$who_is_this = $vApplicationNo.'+';
				}else
				{ 
					$who_is_this = $vApplicationNo.'+'.
					$vObtQualTitle.'<br>'.
					$vProgrammeDesc.'@'.
					$vLastName.'<br>'.
					$vFirstName.'<br>'.
					$vOtherName.'$'.
					$iStudy_level.'^'.
					$tSemester.'#';
				}
				$stmt->close();
			}
			
			if ($_REQUEST['sm'] == 2)
			{
				if (isset($_REQUEST['vLastName']) && isset($_REQUEST['tabno']) && $_REQUEST['tabno'] == 1)
				{
					if (isset($_FILES['sbtd_pix']))
					{
						$file_chk = check_file('50000', '2');
						if ($file_chk <> '')
						{
							echo $file_chk;
							exit;
						}

						$target_file = basename($_FILES["sbtd_pix"]["name"]); 
						$file_name_ext = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
						
						$token = openssl_random_pseudo_bytes(6);
						$token = bin2hex($token);


						if ($_REQUEST['id_no'] == '0')
						{							
							$stmt = $mysqli->prepare("SELECT cSbmtd, LCASE(cFacultyId), vmask FROM prog_choice a, pics b WHERE a.vApplicationNo = b.vApplicationNo AND cinfo_type = 'p' AND a.vApplicationNo = ?");
							$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($cSbmtd, $cFacultyId, $mask);
							$stmt->fetch();
							$stmt->close();

							if ($cSbmtd <> '0')
							{
								$old_file_name = BASE_FILE_NAME_FOR_PP.$cFacultyId."/pp/p_".$mask.".jpg";
								if (file_exists($old_file_name))
								{
									unlink($old_file_name);
								}else
								{
									$old_file_name = BASE_FILE_NAME_FOR_PP.$cFacultyId."/pp/p_".$mask.".jpeg";
									if (file_exists($old_file_name))
									{
										unlink($old_file_name);
									}
								}
							}else
							{
								$old_file_name = BASE_FILE_NAME_FOR_PP."p_".$mask.".jpg";
								if (file_exists($old_file_name))
								{
									unlink($old_file_name);
								}else
								{
									$old_file_name = BASE_FILE_NAME_FOR_PP."p_".$mask.".jpeg";
									if (file_exists($old_file_name))
									{
										unlink($old_file_name);
									}
								}
							}

							$afn = $_REQUEST["uvApplicationNo"];
						}else
						{
							$stmt = $mysqli->prepare("SELECT LCASE(cFacultyId), vmask, a.vApplicationNo FROM s_m_t a, pics b WHERE a.vApplicationNo = b.vApplicationNo AND cinfo_type = 'p' AND a.vMatricNo = ?");
							$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($cFacultyId, $mask, $afn);
							$stmt->fetch();
							$stmt->close();

							$old_file_name = BASE_FILE_NAME_FOR_PP.$cFacultyId."/pp/p_".$mask.".jpg";
							if (file_exists($old_file_name))
							{
								unlink($old_file_name);
							}else
							{
								$old_file_name = BASE_FILE_NAME_FOR_PP.$cFacultyId."/pp/p_".$mask.".jpeg";
								if (file_exists($old_file_name))
								{
									unlink($old_file_name);
								}
							}
						}

						$image_properties = getimagesize($_FILES['sbtd_pix']['tmp_name']);
						if (!is_array($image_properties))
						{
							echo 'Select file of JPEG type to upload for passport'; exit;
						}

						if ($image_properties["mime"] <> 'image/jpg' && $image_properties["mime"]  <> 'image/jpeg' && $image_properties["mime"]  <> 'image/pjpeg')
						{
							echo 'Select file of JPEG type to upload for passport'; exit;
						}

						$target_file = basename($_FILES["sbtd_pix"]["name"]); 
						$file_name_ext = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

						if ($file_name_ext <> 'jpg' && $file_name_ext  <> 'jpeg' && $file_name_ext  <> 'pjpeg')
						{
							echo 'Only JPEG type file is allowed for passport picture'; exit;
						}
						
						if ($_FILES["sbtd_pix"]["size"] > 50000)
						{
							echo '50KB exceeded for passport picture'; exit;
						}

						@unlink(BASE_FILE_NAME_FOR_PP."p_" .$mask.'png');
						@unlink(BASE_FILE_NAME_FOR_PP."p_" .$mask.'jpg');
						@unlink(BASE_FILE_NAME_FOR_PP."p_" .$mask.'jpeg');
						@unlink(BASE_FILE_NAME_FOR_PP."p_" .$mask.'pjpeg');

						if (!move_uploaded_file($_FILES['sbtd_pix']['tmp_name'], BASE_FILE_NAME_FOR_PP . $_FILES['sbtd_pix']['name']))
						{
							echo  "Upload failed, please try again"; exit;
						}

						// if (!move_uploaded_file($_FILES['sbtd_pix']['tmp_name'], $old_file_name))
						// {
						// 	echo  "Upload failed, please try again"; exit;
						// }

						//$new_file_name = BASE_FILE_NAME_FOR_PP."p_" . $token.".".$file_name_ext;
						rename(BASE_FILE_NAME_FOR_PP . $_FILES['sbtd_pix']['name'], $old_file_name);

						chmod($old_file_name, 0755);

						$stmt = $mysqli->prepare("DELETE FROM pics WHERE vmask = '$mask'");
						$stmt->execute();

						$stmt = $mysqli->prepare("INSERT INTO pics set vApplicationNo = ?, vmask = '$mask', cinfo_type = 'p'");
						$stmt->bind_param("s", $afn);
						$stmt->execute();
						$stmt->close();
					}
					
                    if (isset($_REQUEST['id_no']))
                    {						
						$a = addslashes(trim($_REQUEST["vLastName"]));
						$b = addslashes(trim(ucwords($_REQUEST["vFirstName"])));
						$c = addslashes(trim(ucwords($_REQUEST["vOtherName"])));
						$d = addslashes(trim(ucwords($_REQUEST["vHomeCityName"])));
						$e = trim($_REQUEST["uvApplicationNo"]);
							
						if ($_REQUEST['id_no'] == '0')
						{
							$stmt = $mysqli->prepare("update pers_info
							set vLastName = ?,
							vFirstName = ?,
							vOtherName = ?,
							dBirthDate = ?,
							cMaritalStatusId = ?,
							cGender = ?,
							cDisabilityId = ?,
							vHomeCityName = ?,
							cHomeLGAId= ?,
							cHomeStateId= ?,
							cHomeCountryId = ?
							where vApplicationNo = ?");
							$stmt->bind_param("ssssssssssss", $a, $b, $c, $_REQUEST["dBirthDate"], $_REQUEST["cMaritalStatusId"], $_REQUEST["cGender"], $_REQUEST["cDisabilityId"], $d, $_REQUEST["cHomeLGAId"], $_REQUEST["cHomeStateId"], $_REQUEST["cHomeCountryId"], $e);

							$stmt_p = $mysqli->prepare("update prog_choice
							set vLastName = ?,
							vFirstName = ?,
							vOtherName = ?,
							dateofbirth = ?
							where vApplicationNo = ?");
							$stmt_p->bind_param("sssss", $a, $b, $c, $_REQUEST["dBirthDate"], $e);
							$stmt_p->execute();						
						}else
						{
							$stmt = $mysqli->prepare("update s_m_t
							set vLastName = ?,
							vFirstName = ?,
							vOtherName = ?,
							dBirthDate = ?,
							cMaritalStatusId = ?,
							cGender = ?,
							cDisabilityId = ?,
							vHomeCityName = ?,
							cHomeLGAId= ?,
							cHomeStateId= ?,
							cHomeCountryId = ?
							where vMatricNo = ?");
							$stmt->bind_param("ssssssssssss", $a, $b, $c, $_REQUEST["dBirthDate"], $_REQUEST["cMaritalStatusId"], $_REQUEST["cGender"], $_REQUEST["cDisabilityId"], $d, $_REQUEST["cHomeLGAId"], $_REQUEST["cHomeStateId"], $_REQUEST["cHomeCountryId"], $e);							
						}
						
						$stmt->execute();
						$stmt->close();

						log_actv('Updated biodata for '.trim($_REQUEST["uvApplicationNo"]));
						echo $who_is_this.'Bio-data record successfully updated';
                    }
                    
				}else if (isset($_REQUEST['cPostalCountryId']) && isset($_REQUEST['tabno']) && $_REQUEST['tabno'] == 2)
				{ 
					if (isset($_REQUEST['id_no']))
                    {
						$a = addslashes(trim($_REQUEST["vPostalAddress"]));
						$b = addslashes(trim(ucwords($_REQUEST["vPostalCityName"])));
						$c = trim(ucwords($_REQUEST["uvApplicationNo"]));
						
						if ($_REQUEST['id_no'] == '0')
						{							
							$stmt = $mysqli->prepare("update post_addr
							set vPostalAddress = ?,
							vPostalCityName= ?,
							cPostalCountryId = ?,
							cPostalStateId = ?,
							cPostalLGAId = ?,
							vEMailId = ?,
							vMobileNo = ?
							where vApplicationNo = ?");
							$stmt->bind_param("ssssssss", $a, $b, $_REQUEST["cPostalCountryId"], $_REQUEST["cPostalStateId"], $_REQUEST["cPostalLGAId"], $_REQUEST["vEMailId"], $_REQUEST["vMobileNo"], $c);
						}else
						{
							$stmt = $mysqli->prepare("update s_m_t
							set vPostalAddress = ?,
							vPostalCityName= ?,
							cPostalCountryId = ?,
							cPostalStateId = ?,
							cPostalLGAId = ?,
							vEMailId = ?,
							vMobileNo = ?
							where vMatricNo = ?");
							$stmt->bind_param("ssssssss", $a, $b, $_REQUEST["cPostalCountryId"], $_REQUEST["cPostalStateId"], $_REQUEST["cPostalLGAId"], $_REQUEST["vEMailId"], $_REQUEST["vMobileNo"], $c);
						}
						$stmt->execute();
						$stmt->close();

						log_actv('Updated postal address for '. trim($_REQUEST["uvApplicationNo"]));
						echo $who_is_this.'Postal address record successfully updated';
                    }
				}else if (isset($_REQUEST['vResidenceAddress']) && isset($_REQUEST['tabno']) && $_REQUEST['tabno'] == 3)
				{
					if (isset($_REQUEST['id_no']))
                    {						
						$a = addslashes(trim($_REQUEST["vResidenceAddress"]));
						$b = addslashes(trim(ucwords($_REQUEST["vResidenceCityName"])));
						$c = trim(ucwords($_REQUEST["uvApplicationNo"]));
						
						if ($_REQUEST['id_no'] == '0')
                        {			
							$stmt = $mysqli->prepare("update res_addr
                            set vResidenceAddress = ?,
                            vResidenceCityName= ?,
                            cResidenceCountryId = ?,
                            cResidenceStateId = ?,
                            cResidenceLGAId = ?
                            where vApplicationNo = ?");
							$stmt->bind_param("ssssss", $a, $b, $_REQUEST["cResidenceCountryId"], $_REQUEST["cResidenceStateId"], $_REQUEST["cResidenceLGAId"], $c);
                        }else
                        {
                            $stmt = $mysqli->prepare("update s_m_t
                            set vResidenceAddress = ?,
                            vResidenceCityName= ?,
                            cResidenceCountryId = ?,
                            cResidenceStateId = ?,
                            cResidenceLGAId = ?
                            where vMatricNo = ?");
							$stmt->bind_param("ssssss", $a, $b, $_REQUEST["cResidenceCountryId"], $_REQUEST["cResidenceStateId"], $_REQUEST["cResidenceLGAId"], $c);
                        }
                    }
					
					$stmt->execute();
					$stmt->close();
				
					log_actv('Updated residential address for '.trim($_REQUEST["uvApplicationNo"]));
					echo $who_is_this.'Residential address record successfully updated';
				}else if (isset($_REQUEST['vNOKName']) && isset($_REQUEST['tabno']) && $_REQUEST['tabno'] == 4)
				{
					if (isset($_REQUEST['id_no']))
                    {								
						$a = trim($_REQUEST["vNOKName"]);
						$b = addslashes(trim(ucwords($_REQUEST["vNOKAddress"])));
						$c = addslashes(trim(ucwords($_REQUEST["vNOKName1"])));
						$d = addslashes(trim(ucwords($_REQUEST["vNOKAddress1"])));
						$e = trim($_REQUEST["uvApplicationNo"]);
						
						if ($_REQUEST['id_no'] == '0')
                        {
                            $stmt = $mysqli->prepare("update nextofkin
                            set vNOKName = ?,
                            cNOKType = ?,
                            sponsor = ?,
                            vNOKAddress = ?,
                            vNOKEMailId = ?,
                            vNOKMobileNo = ?,
							vNOKName1 = ?,
                            cNOKType1 = ?,
                            sponsor1 = ?,
                            vNOKAddress1 = ?,
                            vNOKEMailId1 = ?,
                            vNOKMobileNo1 = ?,
                            sponsor2 = ?
                            where vApplicationNo = ?");
							$stmt->bind_param("ssssssssssssss", $a, $_REQUEST['cNOKType'], $_REQUEST['sponsor'], $b, $_REQUEST["vNOKEMailId"], $_REQUEST["vNOKMobileNo"], $c, $_REQUEST["cNOKType1"], $_REQUEST['sponsor1'], $d, $_REQUEST['vNOKEMailId1'], $_REQUEST['vNOKMobileNo1'], $_REQUEST['sponsor2'], $e);
                        }else
                        {
                          	$stmt = $mysqli->prepare("update s_m_t
							set vNOKName = ?,
							cNOKType = ?,
							sponsor = ?,
							vNOKAddress = ?,
							vNOKEMailId = ?,
							vNOKMobileNo = ?,
							vNOKName1 = ?,
							cNOKType1 = ?,
							sponsor1 = ?,
							vNOKAddress1 = ?,
							vNOKEMailId1 = ?,
							vNOKMobileNo1 = ?,
							sponsor2 = ?
							where vMatricNo = ?");
							$stmt->bind_param("ssssssssssssss", $a, $_REQUEST['cNOKType'], $_REQUEST['sponsor'], $b, $_REQUEST["vNOKEMailId"], $_REQUEST["vNOKMobileNo"], $c, $_REQUEST["cNOKType1"], $_REQUEST['sponsor1'], $d, $_REQUEST['vNOKEMailId1'], $_REQUEST['vNOKMobileNo1'], $_REQUEST['sponsor2'], $e); 
                        }
                    }
					
					$stmt->execute();
					$stmt->close();
				
					log_actv('Updated nest of kin information for '.trim($_REQUEST["uvApplicationNo"]));
					echo $who_is_this.'Nest of kin record successfully updated';
				}	
			}else
			{
				$a = trim($_REQUEST["uvApplicationNo"]);
				
				// $stmt = $mysqli->prepare("select * from prog_choice where vApplicationNo = ?");
				// $stmt->bind_param("s", $a);
				// $stmt->execute();
				// $stmt->store_result();
				// $stmt->bind_result("s", $a);
				
				// $prog_choice = $result->fetch_assoc();
				// $stmt->close();
				
				if ($_REQUEST['sm'] == 1)
				{
					if (!isset($_REQUEST['conf']))
					{						
						$stmt = $mysqli->prepare("select distinct a.vApplicationNo
						from pers_info a, post_addr b, res_addr c, nextofkin d, prog_choice e, applyqual f, pics g
						where a.vApplicationNo = b.vApplicationNo
						and a.vApplicationNo = c.vApplicationNo
						and a.vApplicationNo = d.vApplicationNo
						and a.vApplicationNo = e.vApplicationNo
						and a.vApplicationNo = f.vApplicationNo
						and a.vApplicationNo = g.vApplicationNo
						and g.cinfo_type = 'C' 
						and a.vApplicationNo = ?");
						$stmt->bind_param("s", $a);
						$stmt->execute();
						$stmt->store_result();
						$cred_chk = $stmt->num_rows;
						$stmt->close();
						
						$stmt = $mysqli->prepare("select distinct a.vApplicationNo, e.cSbmtd, h.cblkd
						from pers_info a, post_addr b, res_addr c, nextofkin d, prog_choice e, applyqual f, pics g, rectional h
						where a.vApplicationNo = b.vApplicationNo
						and a.vApplicationNo = c.vApplicationNo
						and a.vApplicationNo = d.vApplicationNo
						and a.vApplicationNo = e.vApplicationNo
						and a.vApplicationNo = f.vApplicationNo
						and a.vApplicationNo = g.vApplicationNo
						and a.vApplicationNo = h.vApplicationNo
						and g.cinfo_type = 'P'
						and a.vApplicationNo = ?");
						$stmt->bind_param("s", $a);
						$stmt->execute();
						$stmt->store_result();
						
						$stmt->bind_result($vApplicationNo, $cSbmtd, $cblkd);
						$pic_chk = $stmt->num_rows;
						$stmt->fetch();
						$stmt->close();
						
								
						
						if ($_REQUEST['block_form'] == '')
						{
							if ($cred_chk == 0 || $pic_chk == 0)
							{
								echo $who_is_this.'Application form not completed.';exit;
							}else if ($cSbmtd == '2')
							{
								echo $who_is_this.'Form closed and not accessible';exit;
							}else if ($cblkd == '1')
							{
								echo $who_is_this.'Appl. form blocked and not accessible';exit;
							}else if ($cSbmtd == '0')
							{
								echo $who_is_this.'Application form not submitted';exit;
							}else if ($cSbmtd <> '2')
							{
								echo $who_is_this.'Release application form?';exit;
							}
						}else
						{
							$stmt = $mysqli->prepare("SELECT cblk, stdycentre FROM rectional where vMatricNo = ? order by act_date desc limit 1");
							$stmt->bind_param("s", $a);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($cblk, $stdycentre);
							
							if ($stmt->num_rows > 0)
							{
								$stmt->fetch();
								
								if ($_REQUEST['block_form'] == '0' && $cblk == '1')
								{
									echo $who_is_this.'Application form already blocked';exit;
								}else if ($_REQUEST['block_form'] == '1' && $cblk == '0')
								{
									echo $who_is_this.'Application form already unblocked';exit;
								}else if ($_REQUEST['block_form'] == '1' && $cblk == '1' && $stdycentre == '1')
								{
									echo $who_is_this.'Access to application form blocked from <b>Study Centre</b>';exit;
								}else if ($_REQUEST['block_form'] == '1' && $cblk == '1' && $stdycentre == '0')
								{
									echo $who_is_this.'Unblocked application form?';exit;
								}else if ($_REQUEST['block_form'] == '0' && $cblk == '0')
								{
									echo $who_is_this.'Block access to application form?';exit;
								}
							}else if ($_REQUEST['block_form'] == '1')
							{
								echo $who_is_this.'Unblocked application form?';exit;
							}else if ($_REQUEST['block_form'] == '0')
							{
								echo $who_is_this.'Block application form?';exit;
							}
							$stmt->close();
						}
					}else 
					{
						if ($_REQUEST['block_form'] == '')
						{							
							if ($cSbmtd == '1')
							{	
								$stmt = $mysqli->prepare("update prog_choice set cSbmtd = '0' where vApplicationNo = ?");
								$stmt->bind_param("s", $a); 
								$stmt->execute();
								$stmt->close();
								
								log_actv('Released form for '.trim($_REQUEST["uvApplicationNo"]));
								echo 'Form released successfully';exit;
							}
						}else if ($_REQUEST['block_form'] == '0')
						{							
							$stmt = $mysqli->prepare("insert into rectional set cblk = '1', cblk_arch = '1', period1 = now(), act_date = now(), vMatricNo = ?, stdycentre = '0', rect_risn = ?");
							$stmt->bind_param("ss", $a, $_REQUEST["rect_risn"]); 
							$stmt->execute();
							$stmt->close();
							
							log_actv('Form blocked for '.trim($_REQUEST["uvApplicationNo"]));
							echo $who_is_this.'Form blocked successfully';exit;
						}else if ($_REQUEST['block_form'] == '1')
						{							
							$stmt = $mysqli->prepare("update rectional set cblk = '0', period2 = now(), rect_risn1 = '".$_REQUEST["rect_risn"]."' where vMatricNo = ?");
							$stmt->bind_param("ss", $a); 
							$stmt->execute();
							$stmt->close();
							
							log_actv('Form unblocked for '.trim($_REQUEST["uvApplicationNo"]));
							echo $who_is_this.'Form unblocked successfully';exit;
						}
					}
				}else if ($_REQUEST['sm'] == 4)
				{
					if ($_REQUEST['whattodo'] == '4')
					{
						
						$stmt = $mysqli->prepare("select vMatricNo from afnmatric where vApplicationNo = ?");
						$stmt->bind_param("s", $a);
						$stmt->execute();
						$stmt->store_result();
													
						if ($stmt->num_rows === 0) 
						{	
							$stmt->close();
							echo 'xMatric. no. not yet assigned';exit;
						}	
						$stmt->close();
					}else if ($_REQUEST['whattodo'] <> '4')
					{
						$stmt = $mysqli->prepare("SELECT cblk, stdycentre FROM rectional where vMatricNo = ? order by act_date desc limit 1");
						$stmt->bind_param("s", $a);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($cblk, $stdycentre);
						
						if ($stmt->num_rows > 0)
						{
							$stmt->fetch();
							$stmt->close();
							if ($cblk == '1')
							{
								if ($_REQUEST['id_no'] == '0') 
								{
									if ($stdycentre == '1')
									{
										echo 'Candidtate blocked from <b>Study centre</b>';exit;
									}else
									{
										echo 'Candidtate blocked';exit;
									}
								}else if ($_REQUEST['id_no'] == '1') 
								{
									if ($stdycentre == '1')
									{
										echo 'Student blocked';exit;
									}else
									{
										echo 'Student blocked from <b>Registry</b>';exit;
									}
								}
							}
						}
						$stmt->close();
						
						
						if ($_REQUEST['id_no'] == '1') 
						{
							$stmt = $mysqli->prepare("select a.iStudy_level, a.cProgrammeId, a.tSemester from s_m_t a where a.vMatricNo = ?");
							$stmt->bind_param("s", $a);
							$stmt->execute();
							$stmt->store_result();
							
							if ($_REQUEST['whattodo'] <= 3 && $stmt->num_rows === 0)
							{
								$stmt->close();
								echo 'Matriculation number is yet to sign up as a student';exit;
							}
							
							if ($_REQUEST['whattodo'] >= 5 && $stmt->num_rows === 0)
							{
								$stmt->close();
								echo 'Matriculation number is yet to sign up as a student<p>
								You may effect changes on application form number<p>
								Changes will reflect accordingly when student sign up';exit;
							}
							$stmt->close();
						}
					}
					
					
					if (!isset($_REQUEST['conf']))
					{
						if ($_REQUEST['whattodo'] == '0')
						{
							if ($_REQUEST['id_no'] == '0')
							{
								echo $who_is_this.'Show password for application form?';exit;
							}else if ($_REQUEST['id_no'] == '1')
							{
								echo $who_is_this.'Show password for matriculation number?';exit;
							}
						}else if ($_REQUEST['whattodo'] == '1')
						{
							if ($_REQUEST['id_no'] == '0')
							{
								echo $who_is_this.'Reset password for application form?';exit;
							}else if ($_REQUEST['id_no'] == '1')
							{
								echo $who_is_this.'Reset password for matriculation number?';exit;
							}
						}else if ($_REQUEST['whattodo'] == '2' || $_REQUEST['whattodo'] == '3')
						{							
							if ($_REQUEST['whattodo'] == '2')
							{
								$pry_table = 'examreg';
								$course_exam = 'exam drop';
								
								$credit_unit_cond = '';
							}else
							{
								$pry_table = 'coursereg';
								$course_exam = 'course drop';
								 
								$credit_unit_cond = ' and b.iCreditUnit = d.iCreditUnit '; 
							}
							
							$stmt = $mysqli->prepare("SELECT a.cProgrammeId, a.iStudy_level, a.tSemester, a.cAcademicDesc_1 FROM s_m_t a WHERE a.vMatricNo = ?");
							$stmt->bind_param("s", $a);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($cProgrammeId_su, $iStudy_level_su, $tSemester_su, $cAcademicDesc_1_su);
							$stmt->fetch();
							$stmt->close();
							
							$tSemester = $tSemester_su;

							$new_curr = " AND c.cAcademicDesc <= 2023";
							if ($cAcademicDesc_1_su > 2023)
							{
								$new_curr = " AND c.cAcademicDesc = 2024";
							}
							
							$stmt = $mysqli->prepare("SELECT g.vApplicationNo, a.cCourseId, b.vCourseDesc, b.iCreditUnit, c.cCategory, d.amount
							from $pry_table a, courses b, progcourse c, s_f_s d, s_m_t e, programme f, afnmatric g, fee_items h
							where a.cCourseId = b.cCourseId 
							AND a.cCourseId = c.cCourseId 
							AND a.vMatricNo = e.vMatricNo
							AND f.cProgrammeId = e.cProgrammeId 
							AND f.cProgrammeId = c.cProgrammeId 
							AND f.cEduCtgId = d.cEduCtgId
							AND a.vMatricNo = g.vMatricNo
							AND d.fee_item_id = h.fee_item_id
							AND d.cAcademicDesc = '".$orgsetins["cAcademicDesc"]."'
							AND h.fee_item_desc like '%$course_exam%' 
							$credit_unit_cond
							$new_curr
							AND a.cAcademicDesc = '".$orgsetins['cAcademicDesc']."' 
							AND a.siLevel = ".$iStudy_level." 
							AND a.tSemester = $tSemester
							AND h.cdel = 'N' 
							AND a.vMatricNo = ?");
							$stmt->bind_param("s", $a);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($vApplicationNo, $cCourseId, $vCourseDesc, $iCreditUnit, $cCategory, $amount);
							
							$num_of_rec = $stmt->num_rows; 
							$str = '';
							while ($stmt->fetch())
							{
								$str .= $cCourseId.','.str_pad($vCourseDesc, 100, "_", STR_PAD_LEFT).','.$cCategory.','.$iCreditUnit.','.str_pad($amount, 5, "_", STR_PAD_LEFT).';';
							}
							$stmt->close();
							
							$str = $who_is_this.$num_of_rec.'%'.$str;
							echo $str;exit;
						}else if ($_REQUEST['whattodo'] == '4')
						{							
							$stmt1 = $mysqli->prepare("select a.vMatricNo, b.cSbmtd from afnmatric a, prog_choice b where a.vApplicationNo = b.vApplicationNo and a.vApplicationNo = ?");
							$stmt1->bind_param("s", $a);
							$stmt1->execute();
							$stmt1->store_result();
							$stmt1->bind_result($vMatricNo, $cSbmtd);
							
							if ($stmt1->num_rows === 0) 
							{	
								$stmt1->close();
								echo $who_is_this.'Matriculation number not yet assigned';exit;
							}else
							{
								$stmt1->fetch();
								$stmt1->close();
								if ($cSbmtd == '0')
								{	
									$stmt1->close();
									echo $who_is_this.'Form not submitted';exit;
								}	
								$stmt1->close();
								echo $who_is_this.'Once matriculation number is displayed, candidate will not be able to edit application form.<p>Proceed?';
							}
						}else if ($_REQUEST['whattodo'] == '5' || $_REQUEST['whattodo'] == '6' || $_REQUEST['whattodo'] == '7' || $_REQUEST['whattodo'] == '8' || $_REQUEST['whattodo'] == '9')
						{
							if (isset($_REQUEST['cprogrammeIdold']) && $_REQUEST['cprogrammeIdold'] <> '' && $_REQUEST['whattodo'] == '5')
							{
								if ($_REQUEST['id_no'] == '0')
								{
									$stmt = $mysqli->prepare("select cSbmtd from prog_choice where vApplicationNo = ?");
									$stmt->bind_param("s", $a);
									$stmt->execute();
									$stmt->store_result();
									$stmt->bind_result($cSbmtd);
																		
									$stmt->fetch();
									$stmt->close();
									if ($cSbmtd == '0')
									{
										echo $who_is_this.'Programme cannot be changed. Form not submitted';exit;
									}else if ($cSbmtd == '2')
									{
										echo $who_is_this.'Candidate already has matriculation number.<p>Are you sure you want to change candidate\'s programme?';exit;
									}else
									{
										echo $who_is_this.'Are you sure you want to change candidate\'s programme?';exit;
									}
								}else if ($_REQUEST['id_no'] == '1')
								{
									echo $who_is_this.'Are you sure you want to change student\'s programme?';exit;
								}
							}else if (isset($_REQUEST['cStudyCenterIdold']) && $_REQUEST['cStudyCenterIdold'] <> '' && $_REQUEST['whattodo'] == '6')
							{
								if ($_REQUEST['id_no'] == '0')
								{
									echo $who_is_this.'Are you sure you want to change candidate\'s student centre?';exit;
								}else if ($_REQUEST['id_no'] == '1')
								{
									echo $who_is_this.'Are you sure you want to change student\'s study centre?';exit;
								}
							}else if (isset($_REQUEST['tSemester']) && $_REQUEST['tSemester'] <> '' && $_REQUEST['whattodo'] == '7')
							{
								if ($_REQUEST['id_no'] == '0')
								{
									echo $who_is_this.'Are you sure you want to change candidate\'s semester?';exit;
								}else if ($_REQUEST['id_no'] == '1')
								{
									echo $who_is_this.'Are you sure you want to change student\'s semester?';exit;
								}
							}else if (isset($_REQUEST['courseLevel_2']) && $_REQUEST['courseLevel_2'] <> '' && $_REQUEST['whattodo'] == '8')
							{
								if ($_REQUEST['id_no'] == '0')
								{
									echo $who_is_this.'Are you sure you want to change candidate\'s level?';exit;
								}else if ($_REQUEST['id_no'] == '1')
								{
									echo $who_is_this.'Are you sure you want to change student\'s level?';exit;
								}
							}

							$tSemester = $tSemester_su;
							
							$sql_sub1 = ''; $sql_sub2 = ''; $sql_sub3 = '';
							if ($orgsetins['studycenter'] == '1')
							{
								$sql_sub1 = ', studycenter f'; $sql_sub2 = 'and a.cStudyCenterId = f.cStudyCenterId'; $sql_sub3 = ', trim(f.vCityName) vCityName';
							}
							
							$std_cent = 1;

							if ($_REQUEST['id_no'] == '0')
							{
								$mysqli_arch = link_connect_db_arch();

								$stmt = $mysqli_arch->prepare("select a.vTitle, trim(a.vLastName) vLastName, concat(trim(a.vFirstName),' ',trim(a.vOtherName)) othernames,
								e.vFacultyDesc, h.vdeptDesc, a.cProgrammeId, g.vObtQualTitle, f.vProgrammeDesc, a.iStudy_level, '1', a.tSemester, f.cEduCtgId, i.vCityName 
								from arch_s_m_t a, localarea b, ng_state c, country d,  faculty e, programme f, obtainablequal g, depts h, studycenter i
								where a.cPostalLGAId = b.cLGAId
								and a.cPostalStateId = c.cStateId
								and a.cPostalCountryId = d.cCountryId
								and a.cFacultyId = e.cFacultyId
								and a.cProgrammeId = f.cProgrammeId 
								and f.cObtQualId = g.cObtQualId 
								and a.cdeptId = h.cdeptId 
								and i.cStudyCenterId = a.cStudyCenterId 
								and a.vMatricNo = ?
								order by a.act_time desc limit 1");
								$stmt->bind_param("s", $a);
								$stmt->execute();
								$stmt->store_result();
								
								if ($stmt->num_rows === 0)
								{
									$std_cent = 0;
									$stmt->close();
									
									$stmt = $mysqli->prepare("select trim(a.vLastName) vLastName, concat(trim(a.vFirstName),' ',trim(a.vOtherName)) othernames, b.vFacultyDesc, c.vdeptDesc, 			
									a.cProgrammeId, d.vObtQualTitle, e.vProgrammeDesc, a.iBeginLevel iStudy_level, '1' tSemester, e.cEduCtgId, trim(f.vCityName) vCityName 
									from prog_choice a, faculty b, depts c, obtainablequal d, programme e , studycenter f
									where a.cFacultyId = b.cFacultyId 
									and e.cdeptId = c.cdeptId 
									and e.cObtQualId = d.cObtQualId 
									and a.cProgrammeId = e.cProgrammeId 
									and a.cStudyCenterId = f.cStudyCenterId 
									and a.vApplicationNo = ?");
									$stmt->bind_param("s", $a);
									$stmt->execute();
									$stmt->store_result();

									if ($stmt->num_rows == 0)
									{
										$stmt->close();
									
										$stmt = $mysqli->prepare("select trim(a.vLastName) vLastName, concat(trim(a.vFirstName),' ',trim(a.vOtherName)) othernames, b.vFacultyDesc, c.vdeptDesc, 			
										a.cProgrammeId, d.vObtQualTitle, e.vProgrammeDesc, a.iBeginLevel iStudy_level, '1' tSemester, e.cEduCtgId
										from prog_choice a, faculty b, depts c, obtainablequal d, programme e 
										where a.cFacultyId = b.cFacultyId 
										and e.cdeptId = c.cdeptId 
										and e.cObtQualId = d.cObtQualId 
										and a.cProgrammeId = e.cProgrammeId
										and a.vApplicationNo = ?");
										$stmt->bind_param("s", $a);
										$stmt->execute();
										$stmt->store_result();
									}
								}
							}else if ($_REQUEST['id_no'] == '1')
							{
								$stmt->close();
									
								$stmt = $mysqli->prepare("select trim(vLastName) vLastName, concat(trim(vFirstName),' ',trim(vOtherName)) othernames, b.vFacultyDesc, c.vdeptDesc, 
								a.cProgrammeId, d.vObtQualTitle, e.vProgrammeDesc, a.iStudy_level, a.tSemester,  e.cEduCtgId  $sql_sub3
								from s_m_t a, faculty b, depts c, obtainablequal d, programme e $sql_sub1
								where a.cFacultyId = b.cFacultyId
								and a.cdeptId = c.cdeptId
								and a.cObtQualId = d.cObtQualId
								and a.cProgrammeId = e.cProgrammeId
								$sql_sub2 
								and a.vMatricNo = ?");
								$stmt->bind_param("s", $a);
								$stmt->execute();
								$stmt->store_result();

								if ($stmt->num_rows === 0)
								{
									$std_cent = 0;	
									$stmt->close();
									
									$stmt = $mysqli->prepare("select trim(vLastName) vLastName, concat(trim(vFirstName),' ',trim(vOtherName)) othernames, b.vFacultyDesc, c.vdeptDesc, 
									a.cProgrammeId, d.vObtQualTitle, e.vProgrammeDesc, a.iStudy_level, a.tSemester, e.cEduCtgId
									from s_m_t a, faculty b, depts c, obtainablequal d, programme e
									where a.cFacultyId = b.cFacultyId
									and a.cdeptId = c.cdeptId
									and a.cObtQualId = d.cObtQualId
									and a.cProgrammeId = e.cProgrammeId
									and a.vMatricNo = ?");
									$stmt->bind_param("s", $a);
									$stmt->execute();
									$stmt->store_result();
								}
							}

							if ($std_cent == 1)
							{
								$stmt->bind_result($vLastName_su2, $othernames_su2, $vFacultyDesc_su2, $vdeptDesc_su2, 			
								$cProgrammeId_su2, $vObtQualTitle_su2, $vProgrammeDesc_su2, $iBeginLevel_su2, $iStudy_level_su2, $tSemester_su2, $cEduCtgId_su2, $vCityName_su2);
							}else
							{
								$stmt->bind_result($vLastName_su2, $othernames_su2, $vFacultyDesc_su2, $vFacultyDesc_su2, 
								$cProgrammeId_su2, $vFacultyDesc_su2, $vFacultyDesc_su2, $iStudy_level_su2, $tSemester_su2,  $cEduCtgId_su2);
							}
							
							
							$stmt->fetch();
							$stmt->close();
							
							
							if ($std_cent == 0)
							{								
								$vCityName_su2 = '';
							}

							echo $who_is_this.$vLastName_su2.' '.$othernames_su2.'@'.
							$vCityName_su2.'$'.
							$vFacultyDesc_su2.'%'.
							$vFacultyDesc_su2.'!'.
							$vFacultyDesc_su2.' '.$vFacultyDesc_su2.'^'.
							$iStudy_level_su2.'&'.$tSemester_su2.$cEduCtgId_su2;
						}
					}else if ($_REQUEST['conf'] == '1')
					{
						if ($_REQUEST['whattodo'] == '0')
						{
							if ($_REQUEST['id_no'] == '0')
							{
								$stmt = $mysqli->prepare("select vPassword, vPasswordp from app_client
								where vApplicationNo = ? and 
								vPassword <> '' and 
								vPassword is not null");
								$stmt->bind_param("s", $a);
								$stmt->execute();
								$stmt->store_result();
								
								if ($stmt->num_rows === 0)
								{	
									echo $who_is_this.'Password not yet set. May need to follow the link, \'Returning applicant\' on the home page';exit;
								}else
								{
									$stmt->bind_result($vPassword, $vPasswordp);
									$stmt->fetch();
									$stmt->close();
									
									//log_actv('Retrieve password for '.trim($_REQUEST["uvApplicationNo"]));
									//if ($vPasswordp <> ''){echo $who_is_this.$vPasswordp;}else{echo $who_is_this.$vPassword;}exit;

									echo $who_is_this.'Facility stepped down';exit;
								}
							}else if ($_REQUEST['id_no'] == '1')
							{
								$stmt = $mysqli->prepare("select vPassword, vPasswordp from rs_client where vMatricNo = ?");
								$stmt->bind_param("s", $a);
								$stmt->execute();
								$stmt->store_result();
								
								if ($stmt->num_rows === 0)
								{
									$stmt->close();
									echo $who_is_this.'Password not yet set. May need to follow the link, \'Fresh student\' on the home page';exit;
								}else
								{
									$stmt->bind_result($vPassword, $vPasswordp);
									$stmt->fetch();
									$stmt->close();
									//log_actv('Retrieve password for '.$_REQUEST["vMatricNo"]);
									//if ($vPasswordp <> ''){echo $who_is_this.$vPasswordp;}else{echo $who_is_this.$vPassword;}exit;

									echo $who_is_this.'Facility stepped down';exit;
								}
							}
						}else if ($_REQUEST['whattodo'] == '1')
						{
							if ($_REQUEST['id_no'] == '0')
							{
								$b = trim($_REQUEST["uvApplicationNo"]);
								$c = trim($_REQUEST["uvApplicationNo"]);
								
								$stmt = $mysqli->prepare("update app_client set vPassword = md5(?), cpwd = '1' where vApplicationNo = ?");
								$stmt->bind_param("ss", $_REQUEST['uvApplicationNo'], $c);
								$stmt->execute();
								$stmt->close();
																
								log_actv('Reset password for '.trim($_REQUEST["uvApplicationNo"]));
								echo $who_is_this.'Password reset successful';exit;
							}else if ($_REQUEST['id_no'] == '1')
							{
								$b = trim($_REQUEST["uvApplicationNo"]);
								$c = trim($_REQUEST["uvApplicationNo"]);
								
								$stmt = $mysqli->prepare("update rs_client set vPassword = md5(?), cpwd = '1' where vMatricNo = ?");
								$stmt->bind_param("ss", $_REQUEST['uvApplicationNo'], $c);
								$stmt->execute();
								$stmt->close();
								
								log_actv('Reset password for '.trim($_REQUEST["uvApplicationNo"]));
								echo $who_is_this.'Password reset successful';exit;
							}
						}else if ($_REQUEST['whattodo'] == '2' || $_REQUEST['whattodo'] == '3')
						{
							if ($_REQUEST['whattodo'] == '2')
							{
								$pry_table = 'examreg'; 
								$remak = 'exam dropped';
								
								$credit_unit_cond = '';
							}else
							{
								$pry_table = 'coursereg';
								$remak = 'course dropped';
								 
								$credit_unit_cond = ' and b.iCreditUnit = d.iCreditUnit '; 
							}
							
							$stmt = $mysqli->prepare("select a.cProgrammeId, a.iStudy_level, a.tSemester from s_m_t a where a.vMatricNo = ?");
							$stmt->bind_param("s", $a);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($cProgrammeId_su3, $iStudy_level_su3, $tSemester_su3);
							$stmt->fetch();
							$stmt->close();
							
							$tSemester = $tSemester_su3;
							
							if (isset($_REQUEST['numOfiputTag']) &&  $_REQUEST['numOfiputTag'] > 0)
							{
								$str = ''; $count = 0; $str1 = ''; $count1 = 0;
								for ($i = 0; $i <= $_REQUEST['numOfiputTag']; $i++)
								{
									if (isset($_REQUEST["regCourses$i"]) && $_REQUEST['whattodo'] == '3')
									{										
										$b = $_REQUEST["regCourses$i"];
										$stmt = $mysqli->prepare("select * from examreg 
										where vMatricNo = ? and
										siLevel = ".$iStudy_level_su3." and
										tSemester = $tSemester_su3 and
										cAcademicDesc = '".$orgsetins['cAcademicDesc']."' and
										cCourseId = ?");
										$stmt->bind_param("ss", $a, $b);
										$stmt->execute();
										$stmt->store_result();

										if ($stmt->num_rows > 0){$str = $str . $_REQUEST["regCourses$i"].', '; $count++;}
										$stmt->close();
										
										$b = $_REQUEST["regCourses$i"];
										$stmt = $mysqli->prepare("select * from coursereg 
										where vMatricNo = ? and
										siLevel = ".$iStudy_level_su3." and
										tSemester = $tSemester_su3 and
										cAcademicDesc = '".$orgsetins['cAcademicDesc']."' and
										cCourseId = ?");
										$stmt->bind_param("ss", $a, $b);
										$stmt->execute();
										$stmt->store_result();
										
										if ($stmt->num_rows > 0){$str1 = $str1 . $_REQUEST["regCourses$i"].', '; $count1++;}
										$stmt->close();
									}
								}
								
								
								if ($count1 > 1)
								{
									echo $who_is_this.'Please return course material for: '.substr($str1,0,strlen($str1)-10).' and '.substr($str1,strlen($str1)-8,6).' to the store'; exit;
								}else if ($str1 <> '')
								{
									echo $who_is_this.'Please return course material for: '.substr($str1,0,strlen($str1)-2).' to the store'; exit;
								}
								
								if ($count > 1)
								{
									echo $who_is_this.'Please drop the exam for: '.substr($str,0,strlen($str)-10).' and '.substr($str,strlen($str)-8,6); exit;
								}else if ($str <> '')
								{
									echo $who_is_this.'Please drop the exam for: '.substr($str,0,strlen($str)-2); exit;
								}
								
								$courDrop = 0;
								for ($i = 0; $i <= $_REQUEST['numOfiputTag']; $i++)
								{
									if (isset($_REQUEST["regCourses$i"]))
									{	
										$b = $_REQUEST["regCourses$i"];
										
										if ($_REQUEST['whattodo'] == '2')
										{
											$stmt1 = $mysqli->prepare("SELECT iItemID 
											FROM s_f_s a, programme b, fee_items c 
											WHERE a.fee_item_id = c.fee_item_id 
											AND c.fee_item_desc like '%exam drop%'
											AND a.cdel = 'N'  
											AND a.cEduCtgId = b.cEduCtgId 
											AND b.cProgrammeId = ?");
											$stmt1->bind_param("s", $student_user["cProgrammeId"]);
										}else
										{
											$b = $_REQUEST["regCourses$i"];
											$stmt1 = $mysqli->prepare("SELECT iItemID 
											FROM s_f_s a, programme b, fee_items c 
											WHERE a.fee_item_id = c.fee_item_id
											AND c.fee_item_desc like '%course drop%'
											AND a.cdel = 'N'   
											AND a.cAcademicDesc = '".$orgsetins["cAcademicDesc"]."' AND a.cEduCtgId = b.cEduCtgId 
											AND b.cProgrammeId = '".$student_user["cProgrammeId"]."' 
											AND a.iCreditUnit = ?");
											$stmt1->bind_param("s", $b);
										}
										
										$stmt->execute();
										$stmt->store_result();
										$stmt->bind_result($iItemID);
										$stmt->fetch();
										$stmt->close();

                                        date_default_timezone_set('Africa/Lagos');
                                        $date2 = date("Y-m-d h:i:s");
										
										$b = $_REQUEST["regCourses$i"];
										$stmt = $mysqli->prepare("INSERT IGNORE INTO s_tranxion_cr SET
										vMatricNo = ?,
										cCourseId = ?,
										tdate = '$date2',
										cTrntype = 'c',
										iItemID = '".$iItemID."',
										tSemester = $tSemester,
										cAcademicDesc = '".$orgsetins['cAcademicDesc']."',
										siLevel = ".$iStudy_level_su3.",
										vremark = '$remak'");
										$stmt->bind_param("ss", $a, $b);
										$stmt->execute();
										$stmt->close();
																				
										$stmt = $mysqli->prepare("delete from $pry_table 
										where vMatricNo = ? and
										siLevel = ".$student_user['iStudy_level']." and
										tSemester = $tSemester and
										cAcademicDesc = '".$orgsetins['cAcademicDesc']."' and
										cCourseId = ?");
										$stmt->bind_param("ss", $a, $b);
										$stmt->execute();
										$stmt->close();
										
										$courDrop++;
									}
								}
								
								if ($courDrop > 0)
								{
									if ($_REQUEST['whattodo'] == '2')
									{
										log_actv('Dropped for exam for '.trim($_REQUEST["uvApplicationNo"]));
										echo $who_is_this.$courDrop.' course(s) successfully dropped for exam';exit;
									}else
									{
										log_actv('Dropped for courses for '.trim($_REQUEST["uvApplicationNo"]));
										echo $who_is_this.$courDrop.' course(s) successfully dropped';exit;
									}
								}
							}
						}else if ($_REQUEST['whattodo'] == '4')
						{
							$stmt = $mysqli->prepare("update prog_choice set cSbmtd = '2' where vApplicationNo = ?");
							$stmt->bind_param("s", $a);
							$stmt->execute();
							$stmt->close();
							
							//$prog = $result1->fetch_array();
							echo $who_is_this.'x'.$vMatricNo;exit;
						}else if ($_REQUEST['whattodo'] == '5' || $_REQUEST['whattodo'] == '6' || $_REQUEST['whattodo'] == '7' || $_REQUEST['whattodo'] == '8' || $_REQUEST['whattodo'] == '9')
						{
							if ($_REQUEST['id_no'] == '0') 
							{
								$fac_dept_prog = "b.cFacultyId, c.cdeptId, b.cProgrammeId, c.cObtQualId";
								$tsdy_centre = "b.cStudyCenterId";
								$level = "b.iBeginLevel";
							}else if ($_REQUEST['id_no'] == '1') 
							{
								$fac_dept_prog = "cFacultyId, cdeptId, cProgrammeId, cObtQualId";
								$tsdy_centre = "cStudyCenterId";
								$level = "iStudy_level";
								$tSemester = "tSemester";
							}
							
							if ($_REQUEST['whattodo'] == '5' || $_REQUEST['whattodo'] == '7' || $_REQUEST['whattodo'] == '8')
							{
								if (isset($_REQUEST['cprogrammeIdold']))
								{
									$cProgrammeId_chk_level = $_REQUEST['cprogrammeIdold'];
								}else
								{
									if ($_REQUEST['id_no'] == '0') 
									{
										$mysqli_arch = link_connect_db_arch();
										$stmt = $mysqli_arch->prepare("select cProgrammeId from arch_s_m_t where vMatricNo = ?");
										$stmt->bind_param("s", $a);
										$stmt->execute();
										$stmt->store_result();
										$stmt->close();
										
										if ($stmt->num_rows === 0)
										{
											$stmt = $mysqli->prepare("select cProgrammeId from prog_choice where vApplicationNo = ?");
											$stmt->bind_param("s", $a);
										}
									}else if ($_REQUEST['id_no'] == '1') 
									{
										$stmt = $mysqli->prepare("select cProgrammeId from s_m_t where vMatricNo = ?");
										$stmt->bind_param("s", $a);
									}
									
									$stmt->execute();
									$stmt->store_result();
									$stmt->bind_result($cProgrammeId_chk_level);
									
									$stmt->fetch();
									$stmt->close();
								}
								
								if ($_REQUEST['user_cEduCtgId'] <> 'go' && ($_REQUEST['whattodo'] == '5' || $_REQUEST['whattodo'] == '8'))
								{
									if ($_REQUEST['whattodo'] == '5')
									{										
										$c = $_REQUEST['courseLevel'];
										$d = $_REQUEST['courseLevel'];
										
										$stmt = $mysqli->prepare("SELECT * FROM programme where cProgrammeId = '$cProgrammeId_chk_level' and iBeginLevel <= $c and iEndLevel >= $d");
										$stmt->bind_param("ss", $c, $d);
									}else if ($_REQUEST['whattodo'] == '8')
									{											
										$c = $_REQUEST['courseLevel_2'];
										$d = $_REQUEST['courseLevel_2'];
																		
										$stmt = $mysqli->prepare("SELECT * FROM programme where cProgrammeId = '$cProgrammeId_chk_level' and iBeginLevel <= '".$_REQUEST['courseLevel_2']."' and iEndLevel >= '".$_REQUEST['courseLevel_2']."'");
										$stmt->bind_param("ss", $c, $d);
									}
									$stmt->execute();
									$stmt->store_result();
									
									if ($stmt->num_rows === 0)
									{
										$stmt->close();
										echo $who_is_this.'Invalid programme level';exit;
									}
									$stmt->close();
								}
				
								
								if ($_REQUEST['id_no'] == '0')
								{									
									if ($_REQUEST['whattodo'] == '5')
									{
										$stmt = $mysqli->prepare("select cObtQualId from programme
										where cProgrammeId = ?");
										$stmt->bind_param("s",$_REQUEST['cprogrammeIdold']);
										$stmt->execute();
										$stmt->store_result();
										$stmt->bind_result($cObtQualId_obt_qual);
										
										$stmt->fetch();
										$stmt->close();
								
										$fac_dept_prog = "'".$_REQUEST['cFacultyIdold']."', '".$_REQUEST['cdeptold']."', '".$_REQUEST['cprogrammeIdold']."', '".$cObtQualId_obt_qual."'";
										$level = $_REQUEST['courseLevel'];
									}else if ($_REQUEST['whattodo'] == '7')
									{
										$tSemester = $_REQUEST['tSemester'];
									}else if ($_REQUEST['whattodo'] == '8')
									{
										$level = $_REQUEST['courseLevel_2'];
									}
								}else if ($_REQUEST['id_no'] == '1')
								{
									if ($_REQUEST['whattodo'] == '5')
									{										
										$stmt = $mysqli->prepare("select cObtQualId from programme
										where cProgrammeId = ?");
										$stmt->bind_param("s",$_REQUEST['cprogrammeIdold']);
										$stmt->execute();
										$stmt->store_result();
										
										$stmt->fetch();
										$stmt->close();
																				
										$fac_dept_prog = "'".$_REQUEST['cFacultyIdold']."', '".$_REQUEST['cdeptold']."', '".$_REQUEST['cprogrammeIdold']."', '".$cObtQualId_obt_qual."'";
										$level = $_REQUEST['courseLevel'];
									}else if ($_REQUEST['whattodo'] == '7')
									{
										$tSemester = $_REQUEST['tSemester'];
									}else if ($_REQUEST['whattodo'] == '8')
									{
										$level = $_REQUEST['courseLevel_2'];
									}
								}
							}else if ($_REQUEST['whattodo'] == '6')
							{
								$tsdy_centre = "'".$_REQUEST['cStudyCenterIdold']."'";
							}
			
							
							if ($_REQUEST['whattodo'] == '5' || $_REQUEST['whattodo'] == '6' || $_REQUEST['whattodo'] == '7' || $_REQUEST['whattodo'] == '8')
							{
								if ($_REQUEST['whattodo'] == '5')
								{
									if ($_REQUEST['id_no'] == '1')
									{										
										$stmt = $mysqli->prepare("update s_m_t 
										set cFacultyId = ?,						
										cdeptId = ?,
										cProgrammeId = ?,
										iBegin_level = ?,
										iStudy_level = ?,  
										cObtQualId = '$cObtQualId_obt_qual',
										tSemester = 1 
										where vMatricNo = ?");
										$stmt->bind_param("sssiis", $_REQUEST['cFacultyIdold'], $_REQUEST['cdeptold'], $_REQUEST['cprogrammeIdold'],  $_REQUEST['courseLevel'], $_REQUEST['courseLevel'], $a);
										$stmt->execute();
										$stmt->close();
									}
									
									log_actv('Changed programme for '.trim($_REQUEST["uvApplicationNo"]));
									echo $who_is_this.'Programme successfully changed';exit;
								}else if ($_REQUEST['whattodo'] == '6')
								{
									if ($_REQUEST['id_no'] == '1')
									{								
										$stmt = $mysqli->prepare("update s_m_t 
										set cStudyCenterId = ? 
										where vMatricNo = ?");
										$stmt->bind_param("ss", $_REQUEST['cStudyCenterIdold'], $a);
										$stmt->execute();
										$stmt->close();
									}
									
									log_actv('Changed study centre for '.trim($_REQUEST["uvApplicationNo"]));
									echo $who_is_this.'Study centre successfully changed';exit;
								}else if ($_REQUEST['whattodo'] == '7')
								{
									if ($_REQUEST['id_no'] == '1')
									{										
										$stmt = $mysqli->prepare("update s_m_t 
										set tSemester = ? 
										where vMatricNo = ?");
										$stmt->bind_param("ss", $_REQUEST['tSemester'], $a);
										$stmt->execute();
										$stmt->close();
									}
									
									log_actv('Changed semester for '.trim($_REQUEST["uvApplicationNo"]));
									echo $who_is_this.'Semester successfully changed';exit;
								}else if ($_REQUEST['whattodo'] == '8')
								{
									if ($_REQUEST['id_no'] == '1')
									{
										$stmt = $mysqli->prepare("update s_m_t 
										set iBegin_level = ?,
										iStudy_level = ?
										where vMatricNo = ?");
										$stmt->bind_param("iis", $_REQUEST['courseLevel_2'], $_REQUEST['courseLevel_2'], $a);
										$stmt->execute();
										$stmt->close();
									}
									
									log_actv('Changed level for '.trim($_REQUEST["uvApplicationNo"]));
									echo $who_is_this.'Level successfully changed';exit;
								}
							}else if ($_REQUEST['whattodo'] == '9')
							{
								$stmt = $mysqli->prepare("update pics 
								set upld_passpic_no = ".$orgsetins['upld_passpic_no']."
								where vApplicationNo = ?");
								$stmt->bind_param("s", $a);
								$stmt->execute();
								$stmt->close();
								
								log_actv('Updated photo upload chances for '.trim($_REQUEST["uvApplicationNo"]));
								echo $who_is_this.'Photo upload chances successfully updated';exit;
							}
						}
					}
				}else if ($_REQUEST['sm'] == 5)
				{
					log_actv('Viewed form for '.trim($_REQUEST["uvApplicationNo"]));
					echo '';
				}
			}
		}else if ($_REQUEST['sm'] == 3)
		{
			
		}
	}
}
