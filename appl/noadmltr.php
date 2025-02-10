<?php
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
include('const_def.php');
include('lib_fn.php');
include('lib_fn_2.php');

$mysqli = link_connect_db();?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="./img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/phdltr.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>

        
        <style>
            #conf_box_loc
            {
                width:370px;
            }

            #tel_phd_available
            {
                width:480px;
            }

            li, dd
            {
                text-align:justify;
                width:99%;
                border:none;
                cursor:default;
                line-height:1.8;
				padding:0px;
            }

            li:hover {background: none; cursor:default;}

            dd, dt{text-align:left; width:100%}

            #application_steps
            {
                position:absolute;
                top:63px;
                right:15px;
                width:725px; 
            }

            .appl_left_child_div_child
            {
                display:flex; 
                flex-flow: row;
                justify-content: flex-start;
                gap:0px;
                flex:100%;
                height:auto; 
                text-align:left;
                /* margin-bottom:4px; */
            }

            #log_div
            {
                text-align:right;
            }

            @media screen and (max-width: 800px) 
            {
                #conf_box_loc
                {
                    width:85vw;
                }

                #tel_phd_available
                {
                    width:85vw;
                }

                #application_steps
                {
                    margin:auto;
                    width:85vw; 
                }

                li, dd
                {
                    line-height:2.5;
                    height:auto;
                }

                .appl_left_child_div_child
                {
                    flex-direction: column;
                } 

                #log_div
                {
                    text-align: center;
                }
            }
        </style>
        
	
        <script language="JavaScript" type="text/javascript">
            
            
            function _(el)
            {
                return document.getElementById(el)
            }
        </script>
	</head>
	<body><?php
        include("feedback_mesages.php");
        include("forms.php");

        if ($_REQUEST["user_cat"] == 6)
        {
            if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '')
            {
                $vApplicationNo = $_REQUEST["uvApplicationNo"];
            }
        }else
        {
            if (isset($_REQUEST["vApplicationNo"]) && $_REQUEST["vApplicationNo"] <> '')
            {
                $vApplicationNo = $_REQUEST["vApplicationNo"];
            }
        }

		$trans_time = '';
		$leter_ref_no = '';
		$vTitle = '';
		$namess = '';
		$vFacultyDesc = '';
		$vObtQualDesc = '';
		$vObtQualTitle = '';
		$vProgrammeDesc = '';
		$Programme = '';
		$iBeginLevel = '';
		$vdeptDesc = '';
		$cdeptId = '';
		$vCityName = '';
		$cEduCtgId = '';
		$cStudyCenterId = '';
		$cFacultyId = '';
		$iprnltr = '';

		$stmt = $mysqli->prepare("SELECT trans_time, leter_ref_no, a.vTitle, concat(ucase(a.vLastName),' ',a.vFirstName,' ',a.vOtherName) namess, e.vFacultyDesc, i.vObtQualDesc, i.vObtQualTitle, g.vProgrammeDesc, concat(i.vObtQualTitle,' ',g.vProgrammeDesc) Programme, f.iBeginLevel, h.vdeptDesc, g.cdeptId, j.vCityName, i.cEduCtgId, f.cStudyCenterId, e.cFacultyId, f.iprnltr, f.cAcademicDesc, f.cProgrammeId
		FROM pers_info a, faculty e, prog_choice f, programme g, obtainablequal i, depts h, studycenter j
		WHERE f.cFacultyId = e.cFacultyId and
		f.vApplicationNo = a.vApplicationNo and
		f.cProgrammeId = g.cProgrammeId and
		i.cObtQualId = g.cObtQualId and 
		g.cdeptId = h.cdeptId and 
		j.cStudyCenterId = f.cStudyCenterId and
		f.cSbmtd <> '0' and 
		a.vApplicationNo = ?");
		$stmt->bind_param("s", $vApplicationNo);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($trans_time, $leter_ref_no, $vTitle, $namess, $vFacultyDesc, $vObtQualDesc, $vObtQualTitle, $vProgrammeDesc, $Programme, $iBeginLevel, $vdeptDesc, $cdeptId, $vCityName, $cEduCtgId, $cStudyCenterId, $cFacultyId, $iprnltr, $cAcademicDesc, $cProgrammeId);
		$stmt->fetch();

		if (!is_bool(strpos($vProgrammeDesc, '(d)')))
		{
			$vProgrammeDesc = substr($vProgrammeDesc, 0, strlen(trim($vProgrammeDesc))-4);
		}

		if ($stmt->num_rows <> 0)
		{
			$staff_can_access = 0;

			$staff_study_center = '';
			if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] == '6')
			{
				$staff_study_center = $_REQUEST['user_centre'];

				$staff_study_center_new = str_replace("|","','",$staff_study_center);
				$staff_study_center_new = substr($staff_study_center_new,2,strlen($staff_study_center_new)-4);

				$stmt = $mysqli->prepare("SELECT concat(b.vCityName,' centre')  
				from prog_choice a, studycenter b
				WHERE a.cStudyCenterId = b.cStudyCenterId
				AND a.cStudyCenterId IN ($staff_study_center_new) 
				AND a.vApplicationNo = ?");
				$stmt->bind_param("s", $vApplicationNo);			
				$stmt->execute();
				$stmt->store_result();
				$staff_can_access = $stmt->num_rows;
				$stmt->close();
			}
			
			$orgsetins = settns();?>
			<div class="appl_container" style="width:96vw;">
				<?php //left_conttent('Pay for application form');?> 
				
				<div class="appl_right_div" style="font-size:1em; flex: 100%;">
					<div class="appl_left_child_div" style="text-align: center; width:99%; margin:auto; margin-top:5px; position:relative; background-color: #eff5f0;">
						<div id="background" class="center"
							style="z-index:0; 
							position: absolute; 
							display:block;
							height:auto; 
							width:auto;
							text-align:center">
							<p id="bg-text" 
								style="color:#ff9797;
								font-size:60px;
								transform:rotate(-45deg);
								-webkit-transform:rotate(-45deg);
								opacity:0.3"><?php echo $namess;?></p>
						</div><?php
						if ($staff_can_access == 0 && $_REQUEST["user_cat"] == '6')
						{?>
							<div class="appl_left_child_div_child" style="margin-top:10px; gap:0px; flex-direction:column">
								<div style="flex:100%; height:auto; text-align:center; background-color: #ffffff">
									Student study centre does not match that of staff that is logged in
								</div>
							</div><?php
						}else if ((isset($_REQUEST["user_cat"]) && ($_REQUEST["user_cat"] == '7' || $_REQUEST["user_cat"] == '6' || $_REQUEST["user_cat"] == '5' || $_REQUEST["user_cat"] == '3')))
						{
							if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] == '3')
							{
								$stmt = $mysqli->prepare("UPDATE prog_choice SET iprnltr = iprnltr + 1 WHERE vApplicationNo = ?");
								$stmt->bind_param("s", $vApplicationNo);
								$stmt->execute();
								$stmt->close();
								log_actv('Printed admission letter for '.$vApplicationNo);
							}?>
							<div class="appl_left_child_div_child" style=" gap:0px; flex-direction:column">
								<div style="flex:100%; height:auto; text-align:center; background-color: #ffffff">
									<img width="80" height="72" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" alt="Home">
								</div>
								<div style="flex:100%; height:auto; padding:0px; text-align:center; line-height:normal; font-size:2em; background-color: #ffffff; color:#068950;">
								<?php echo strtoupper($orgsetins['vOrgName']);?><br>
									<div style="font-size: 0.5em; color:#000;">University Village, Plot 9, Cadastral Zone, Nnamdi Azikiwe Express Way, Jabi, Abuja, Nigeria</div>
								</div>
								<div style="flex:100%; height:auto; padding:0px; text-align:center; font-size:1.4em; background-color: #ffffff">
									(Office of the Registrar)
								</div>
							</div><?php
							$today = getdate();
							$today_day = str_pad($today['mday'], 2, "0", STR_PAD_LEFT);
							$today_mon = str_pad($today['mon'], 2, "0", STR_PAD_LEFT);
							$today_year = $today['year'];
							
							$stmt1 = $mysqli->prepare("select trans_time, leter_ref_no from prog_choice where vApplicationNo = ? and iprnltr <> '' and iprnltr <> '0'");
							$stmt1->bind_param("s", $vApplicationNo);
							$stmt1->execute();
							$stmt1->store_result();
							$stmt1->bind_result($trans_time_01, $leter_ref_no_01);
					
							if ($stmt1->num_rows <> 0)
							{
								$stmt1->fetch();
								$letter_date = formatdate($trans_time_01,'fromdb');
								$leter_ref_no = $leter_ref_no_01;
							}
							$stmt1->close();
                            
                            if($leter_ref_no == '')
							{
								$stmt2 = $mysqli->prepare("SELECT MerchantReference, cAcademicDesc, MAX(RIGHT(leter_ref_no,3))+1 FROM prog_choice a, remitapayments b WHERE a.vApplicationNo = b.Regno AND vApplicationNo = '$vApplicationNo' AND iprnltr <> 0");
								$stmt2->execute();
								$stmt2->store_result();
								$stmt2->bind_result($MerchantReference, $cAcademicDesc, $next_seria_no);
								$stmt2->fetch();

								if (is_numeric($next_seria_no))
								{
									$seria_no = $next_seria_no;
								}else
								{
									$seria_no = 1;
								}
								$stmt2->close();

								$letter_date = date("d-m-Y");
								
								//$leter_ref_no = 'NOUN/REG/ADM/'.str_pad($today_mon,2,'0', STR_PAD_LEFT).'/'. $cdeptId.'/'.str_pad($seria_no,3,'0', STR_PAD_LEFT);

                                $leter_ref_no = $cProgrammeId.'/'.$MerchantReference.'/'.substr($cAcademicDesc,2,2). $orgsetins["tSemester"].'/'.$next_seria_no;
								
								$stmt2 = $mysqli->prepare("UPDATE prog_choice SET leter_ref_no = '$leter_ref_no', trans_time = CURDATE() WHERE vApplicationNo = ?");
								$stmt2->bind_param("s", $vApplicationNo);
								$stmt2->execute();
								$stmt2->close();
							}?>
                            
							<div class="appl_left_child_div_child">
								<div style="flex:50%; padding-left:5px; height:40px; padding-top:4px; background-color: #ffffff; text-align:left;">
									<?php echo 'Our Reference: <b>'.$leter_ref_no.'</b>';?>
								</div>
								<div style="flex:50%; padding-right:5px; height:40px; padding-top:4px; background-color: #ffffff; text-align:right;">
									<?php echo $letter_date;?>
								</div>
							</div><?php
					
							//$trans_time_01 = formatdate($trans_time_01,'fromdb');echo $trans_time_01.', '.$letter_date;
							if ($letter_date < date("d-m-Y"))
							{?>
								<div class="appl_left_child_div_child">
									<div style="flex:100%; padding-right:5px; height:40px; padding-top:4px; background-color: #ffffff; text-align:right;">
										<?php echo 'Re-print: '.date("d-m-Y");?>
									</div>
								</div><?php
							}
                            
                            $vPostalAddress = ''; 
                            $vPostalCityName = ''; 
                            $vPostalLGADesc = ''; 
                            $vPostalStateName = ''; 
                            $vPostalCountryName = ''; 
                            $vEMailId = ''; 
                            $vMobileNo = '';
                            $w_vMobileNo = '';
    
                            $stmt = $mysqli->prepare("select vPostalAddress, f.vLGADesc, vPostalCityName, e.vStateName, d.vCountryName, vEMailId, vMobileNo, w_vMobileNo
                            from post_addr a, country d, ng_state e, localarea f 
                            where a.cPostalCountryId = d.cCountryId and
                            a.cPostalStateId = e.cStateId and
                            a.cPostalLGAId = f.cLGAId and 
                            vApplicationNo = ?");
                            $stmt->bind_param("s", $vApplicationNo);
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($vPostalAddress, $vPostalLGADesc, $vPostalCityName, $vPostalStateName, $vPostalCountryName, $vEMailId, $vMobileNo, $w_vMobileNo);
                            $stmt->fetch();
                            $stmt->close();?>

                            <div class="appl_left_child_div_child">
                                <div style="flex:100%; padding-left:5px; height:auto; padding-top:4px; background-color: #ffffff; text-align:left;">
                                    <?php echo $vPostalAddress.',<br>'.
                                    $vPostalCityName.',<br>'.
                                    $vPostalLGADesc.',<br>'.
                                    $vPostalStateName.',<br>'.
                                    $vPostalCountryName.'.';?>
                                </div>
                            </div>

							<div class="appl_left_child_div_child">
								<div style="flex:100%; padding-left:5px; height:40px; padding-top:4px; background-color: #ffffff; text-align:left;">
									Dear <b><?php echo $namess;
                                    if ($vTitle <> ''){echo ' ('.$vTitle.')';}
                                    echo  ' ['.$vApplicationNo.']';?></b>
								</div>
							</div>

							<!-- <div class="appl_left_child_div_child">
								<div style="flex:100%; padding-left:5px; height:40px; padding-top:4px; background-color: #ffffff; text-align:left;">
                                    Dear <b><?php /*echo $namess;
                                    if ($vTitle <> ''){echo ' ('.$vTitle.')';}
                                    echo  ' ['.$vApplicationNo.']';*/?></b>
								</div>
							</div> -->
							
							<div class="appl_left_child_div_child">
                                <div style="flex:100%; height:auto; padding-top:4px; background-color: #ffffff; text-align:center; font-weight:800;">
									OFFER of PROVISIONAL ADMISSION <br>[<?php echo substr($cAcademicDesc, 0, 4).' SESSION';?>]
								</div>
							</div>
							
							
							<div class="appl_left_child_div_child">
								<div style="flex:100%; height:auto; padding-top:4px; background-color: #ffffff; text-align:left;">
									<ol>
										<li>
											I am pleased to inform you that you have been offered a provisional admission into <b><?php echo $iBeginLevel;?>Level</b> of 
											<?php echo $orgsetins['vOrgName'];?> to pursue a programme leading to the award of <b><?php echo $vObtQualTitle.' '. $vProgrammeDesc;?></b>
											in the faculty of <b><?php echo $vFacultyDesc;?></b>.
										</li>

										<li>
											When it is time, you are advised to register at the <b><?php echo $vCityName;?> Centre</b> specified in your application form.
										</li>

										<li>You must produce the following at the time of registration:
											<ol style="list-style-type: lower-alpha; padding-bottom: 0;">
												<li style="margin-left:1em">
													original and three copies of academic credentials specified on your application form
												</li>
												<li style="margin-left:1em; padding-bottom: 0;">original and copies of birth certificate of sworn declaration of age</li>
												<li style="margin-left:1em; padding-bottom: 0;">three recent  passport picture</li>
											</ol>
										</li>
										<li>The University reserves the right to change your programme if you do not meet the criteria for admission 
											into the programme for which you have been provisionally admitted
										</li>
										<li>
											The University further reserves the right to withdraw your admission whenever it is discovered that your have
											given false pieces of information
										</li>
										<li>
											You are advised to proceed for registration at the study centre indicated above and recieve further information 
											about yout programme and the University
										</li>
									</ol>
									Congratulations!<p>
								</div>
							</div>
							
							<div class="appl_left_child_div_child" style="flex-direction:column">
								<div style="flex:100%; padding-left:5px; height:auto; padding-top:4px; background-color: #ffffff; text-align:left;">
									<img src="img/authorSign.png" style="height:55px; width:175px"/>
								</div>
								<div style="flex:100%; padding-left:5px; height:auto; padding-top:4px; background-color: #ffffff; text-align:left;">
									<b>Oladipo A. Ajayi</b><br>Registrar
								</div>
							</div>
							<img name="p_port" src="<?php echo get_pp_pix(''); ?>" width="125px" height='125px'  style="border-radius:5%; position:absolute; right:15px; bottom:15px"/><?php
						}?>
					</div>
				</div>
			</div><?php
		}else
        {?>
            <div style="margin:50px auto; width:350px; text-align:center; padding:20px; background-color:#eff5f0">
                Application form not submitted
            </div><?php
        }?>
	</body>
</html>