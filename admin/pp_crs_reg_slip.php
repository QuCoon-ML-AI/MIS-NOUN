<?php
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/
	
require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php
// require_once('ids_1.php');
require_once('var_colls.php');

$currency = 1;

$mysqli = link_connect_db();

$service_mode = '';
$num_of_mode = 0;
$service_centre = '';
$num_of_service_centre = 0;

if (isset($_REQUEST['vApplicationNo']))
{
	$centres = do_service_mode_centre("2", $_REQUEST['vApplicationNo']);	
	$service_centre = substr($centres,10);
	$num_of_service_centre = trim(substr($centres,0, 9));
}


$orgsetins = settns();
require_once('set_scheduled_dates.php');
require_once('staff_detail.php');?>

<!-- InstanceBeginEditable name="doctitle" -->
<title>NOUN-MIS</title>
<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
<!-- InstanceEndEditable -->

<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
<!--<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico">-->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
<link rel="stylesheet"  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet"  href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<link rel="stylesheet"  href="https://cdn.datatables.net/plug-ins/9dcbecd42ad/integration/jqueryui/dataTables.jqueryui.css">


<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="https:///cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>

<style>
    table td, table th
    {
       	text-align:left;
        line-height:1.5;
    }
</style>

<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
<script language="JavaScript" type="text/javascript" src="button_ops.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />
<script language="JavaScript" type="text/javascript">
	document.onkeydown = function (e) 
	{
		if (e.ctrlKey && e.keyCode === 85) 
		{
            return false;
        }
	}
</script>
<noscript></noscript>

<!-- InstanceBeginEditable name="head" -->	
<script language="JavaScript" type="text/javascript">
    
</script><?php

require_once ('set_scheduled_dates.php');?>
<!-- InstanceEndEditable -->
</head>
<body onLoad="checkConnection()">
    <?php admin_frms(); $has_matno = 0;?>	
	<!-- InstanceBeginEditable name="nakedbody" -->
		<div id="container_cover_constat" style="display:none"></div>
		<div id="container_cover_in_constat" class="center" style="display:none; position:fixed;">
			<div id="div_header_main" class="innercont_stff" 
				style="float:left;
				width:99.5%;
				height:auto;
				padding:0px;
				padding-top:3px;
				padding-bottom:4px;
				border-bottom:1px solid #cccccc;">
				<div id="div_header_constat" class="innercont_stff" style="float:left; color:#FF3300;">
					Internet Connection Status
				</div>
			</div>
			
			<div id="div_message_constat" class="innercont_stff" style="margin-top:40px; float:left; width:413px; height:auto; color:#FF3300;">
				You are not connected
			</div>
		</div>
	<!-- InstanceEndEditable -->
<div id="container"><?php
	//time_out_box($currency);?>

	<noscript>
		<div class="smoke_scrn" style="display:block"></div>
		<?php information_box_inline('You need to enable javascript for this browser');?>
	</noscript>
	<?php //do_toup_div('Student Management System');?>
	

	<!-- <div id="rtlft_std" style="position:relative; height:88%; margin-left:0.3%; width:99.7%;"> -->
		<!-- InstanceBeginEditable name="EditRegion6" -->
            <div class="innercont_top"><?php
				if(isset($_REQUEST['whattodo']))
				{
					if($_REQUEST['whattodo'] == '9a')
					{
						echo 'Printing press - Course registration slips';
					}
				}else
				{
					echo '';
				}?>
			</div><?php

			//echo $_REQUEST['whattodo'];

			if(isset($_REQUEST['whattodo']))
			{				
				if($_REQUEST['whattodo'] == '9a')//Printing press
				{
					/*if (isset($_REQUEST['staff_study_center']) && $_REQUEST['staff_study_center'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo $_REQUEST['centre_disc'];?></label>
						</div><?php
					}
					
					if (isset($_REQUEST['cFacultyIdold']) && $_REQUEST['cFacultyIdold'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo $_REQUEST['faculty_disc'];?></label>
						</div><?php
					}
					
					if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo $_REQUEST['courseLevel'].'Level';?></label>
						</div><?php
					}
					
					if (isset($_REQUEST['prog_cat_loc']) && $_REQUEST['prog_cat_loc'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo $_REQUEST['prog_cat_disc'];?></label>
						</div><?php
					}*/

					$where_crit = "";
										
					if (isset($_REQUEST['staff_study_center']) && $_REQUEST['staff_study_center'] <> '')
					{
						$where_crit .= "a.cStudyCenterId = '".$_REQUEST['staff_study_center']."' AND ";
					}
										
					if (isset($_REQUEST['cFacultyIdold_loc']) && $_REQUEST['cFacultyIdold_loc'] <> '')
					{
						$where_crit .= "a.cFacultyId = '".$_REQUEST['cFacultyIdold_loc']."' AND ";
					}

					if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '')
					{
						$where_crit .= "a.iStudy_level = '".$_REQUEST['courseLevel']."' AND ";
					}

					if (isset($_REQUEST['prog_cat_loc']))
					{
						if ($_REQUEST['prog_cat_loc'] == 'PSZ')
						{
							$where_crit .= "e.cProgrammeId LIKE '___2%' AND ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PGX')
						{
							$where_crit .= "e.cProgrammeId LIKE '___3%' AND ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PGY')
						{
							$where_crit .= "e.cProgrammeId LIKE '___4%' AND ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PGZ')
						{
							$where_crit .= "e.cProgrammeId LIKE '___5%' AND ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PRX')
						{
							$where_crit .= "e.cProgrammeId LIKE '___6%' AND ";
						}
					}

					$where_crit = substr($where_crit,0,strlen($where_crit)-4);
					
					$vMatricNo = 'NOU211087737';
					$stmt = $mysqli->prepare("SELECT vApplicationNo, a.vMatricNo, vTitle, vLastName, concat(vFirstName,' ',vOtherName) othernames, b.cFacultyId, b.vFacultyDesc, c.vdeptDesc,a.cProgrammeId, d.vObtQualTitle, e.vProgrammeDesc, a.iStudy_level, a.vMobileNo, a.vEMailId, a.tSemester, f.vCityName, e.cEduCtgId, a.cAcademicDesc,  a.cAcademicDesc_1, a.cResidenceCountryId
					FROM s_m_t a, faculty b, depts c, obtainablequal d, programme e, studycenter f
					WHERE a.cFacultyId = b.cFacultyId
					and a.cdeptId = c.cdeptId
					and a.cObtQualId = d.cObtQualId
					and a.cProgrammeId = e.cProgrammeId 
					and a.cStudyCenterId = f.cStudyCenterId
					and $where_crit LIMIT 15");
					
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($vApplicationNo, $vMatricNo, $vTitle, $vLastName, $othernames, $cFacultyId, $vFacultyDesc, $vdeptDesc, $cProgrammeId, $vObtQualTitle, $vProgrammeDesc, $iStudy_level, $vMobileNo, $vEMailId, $tSemester, $vCityName, $cEduCtgId, $cAcademicDesc, $cAcademicDesc_1, $cResidenceCountryId);
					
				}
			}else
			{
				echo '';
			}

			
			if ($_REQUEST['whattodo'] == '9a')//Printing press
			{
				if (isset($_REQUEST['crs_reg_slip_form_chk']))
				{
					$cnt1 = 0;
					while($stmt->fetch())
					{
						$cnt1++?>
						<div id="container" style="margin-top:3px; height:auto; border-bottom:1px solid #706e6e; width:710px; text-align:center; padding:10px; font-size: 1.0em; position:relative">
							<div class="innercont" 
								style="margin:auto; 
								height:170px; 
								padding:0px; 
								border-radius:0px; 
								width:98%;">
								<div id="pp_box" style="position:absolute; top:15px; right:35px;  width:125px; border: 0px; height:auto;">
									<img src="<?php echo get_pp_pix($vApplicationNo);?>" style="width:inherit; height:inherit;" alt="" />
								</div>
								<div style="width:80%; height:auto; border-radius:0px; float:left;">
									<div style="width:34%; height:17px; text-align:left; border-radius:0px; float:left;">
										Matriculation number/Name
									</div>
									<div style="width:64%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:5px;">
										<b><?php echo $vMatricNo.'/'.$vLastName.' '.$othernames;?></b>
									</div>	
								</div>
					
								<!-- <div style="width:80%; height:auto; border-radius:0px; float:left; margin-top:3px;">
									<div style="width:34%; height:17px; text-align:left; border-radius:0px; float:left;">
										Name
									</div>
									<div style="width:64%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:5px;">
										<b><?php //echo $vLastName.' '.$othernames;?></b>
									</div>	
								</div> -->
					
								<div style="width:80%; height:auto; border-radius:0px; float:left; margin-top:3px;">
									<div style="width:34%; height:17px; text-align:left; border-radius:0px; float:left;">
										Mobile number/e-Mail
									</div>
									<div style="width:64%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:5px;">
										<b><?php echo $vMobileNo.'/'.$vEMailId;?></b>
									</div>	
								</div>
								
								<!-- <div style="width:80%; height:auto; border-radius:0px; float:left; margin-top:3px;">
									<div style="width:34%; height:17px; text-align:left; border-radius:0px; float:left;">
										e-Mail
									</div>
									<div style="width:64%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:5px;">
										<b><?php //echo $vEMailId;?></b>
									</div>	
								</div> -->
					
								<div style="width:80%; height:auto; border-radius:0px; float:left; margin-top:3px;">
									<div style="width:34%; height:17px; text-align:left; border-radius:0px; float:left;">
										Study centre
									</div>
									<div style="width:64%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:5px; white-space:normal; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
										<b><?php echo $vCityName;?></b>
									</div>	
								</div>
								
								<div style="width:80%; height:auto; border-radius:0px; float:left; margin-top:3px;">
									<div style="width:34%; height:17px; text-align:left; border-radius:0px; float:left;">
										Faculty
									</div>
									<div style="width:64%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:5px;">
										<b><?php echo $vFacultyDesc;?></b>
									</div>	
								</div>
								
								<div style="width:80%; height:auto; border-radius:0px; float:left; margin-top:3px;">
									<div style="width:34%; height:17px; text-align:left; border-radius:0px; float:left;">
										Department
									</div>
									<div style="width:64%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:5px;">
										<b><?php echo $vdeptDesc;?></b>
									</div>	
								</div>
								
								<div style="width:80%; height:auto; border-radius:0px; float:left; margin-top:3px;">
									<div style="width:34%; height:17px; text-align:left; border-radius:0px; float:left;">
										Programme
									</div>
									<div style="width:64%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:5px;">
										<b><?php echo $vObtQualTitle.' '.$vProgrammeDesc;?></b>
									</div>	
								</div>
								
								<div style="width:80%; height:auto; border-radius:0px; float:left; margin-top:3px;">
									<div style="width:34%; height:17px; text-align:left; border-radius:0px; float:left;">
										Session/Semester
									</div>
									<div style="width:64%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:5px;">
										<b><?php echo $orgsetins['cAcademicDesc'].'/'; if ($tSemester%2==0){echo 'Second';}else{echo 'First';}?></b>
									</div>	
								</div>
							</div>

							<div class="innercont" 
								style="margin:auto;
								margin-bottom:5px; 
								height:auto; 
								padding:0px; 
								border-radius:0px; 
								width:98%;
								border-top: 1px #cccccc solid;
								border-bottom: 1px #cccccc solid;
								line-height:2.0;">
									Printing press - Course registration slip [<?php echo $cnt1;?>]
							</div>

							<div class="innercont" 
								style="margin:auto; 
								height:30px; 
								padding:0px; 
								border-radius:0px; 
								width:98%;">
								<div style="width:100%; height:auto; border-radius:0px; float:left; font-weight:bold">
									<div style="width:4%; height:17px; text-align:left; border-radius:0px; float:left; text-align:right;">
										Sno
									</div>
									<div style="width:12.9%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:0.1%; text-indent:5px;">
										Course code
									</div>
									<div style="width:49.9%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:0.1%;">
										Course title
									</div>
									<div style="width:8.9%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:0.1%; text-align:right;">
										Cr. unit
									</div>
									<div style="width:8.9%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:0.1%; text-indent:5px;">
										Mandate
									</div>
									<div style="width:14.9%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:0.1%; text-indent:5px;">
										Date
									</div>
								</div>
							</div><?php
							$stmt_s = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, a.cCategory, a.iCreditUnit, a.cAcademicDesc, a.siLevel, a.tSemester, a.tdate, a.ancilary_type
							FROM $wrking_crsreg_tab a
							WHERE tdate >= '$semester_begin_date'
							AND a.vMatricNo = ?
							ORDER BY a.cCategory, a.cCourseId");
							$stmt_s->bind_param("s", $vMatricNo);
							$stmt_s->execute();
							$stmt_s->store_result();
							$stmt_s->bind_result($cCourseId, $vCourseDesc, $cCategory, $iCreditUnit, $cAcademicDesc, $siLevel, $tSemester, $tdate, $ancilary_type);
						
							$cnt = 0;
							while($stmt_s->fetch())
							{?>
								<div class="innercont" 
								style="margin:auto; 
								height:20px; 
								padding:0px; 
								border-radius:0px; 
								width:98%;">
									<div style="width:100%; height:auto; border-radius:0px; float:left; border-bottom:1px #ccc solid;">
										<div style="width:4%; height:17px; text-align:left; border-radius:0px; float:left; text-align:right;">
											<?php echo ++$cnt;?>
										</div>
										<div style="width:12.9%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:0.1%; text-indent:5px;">
											<?php echo $cCourseId;?>
										</div>
										<div style="width:49.9%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:0.1%;">
											<?php echo $vCourseDesc;?>
										</div>
										<div style="width:8.9%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:0.1%; text-align:right;">
											<?php echo $iCreditUnit;?>
										</div>
										<div style="width:8.9%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:0.1%; text-indent:5px;">
											<?php echo $cCategory;?>
										</div>
										<div style="width:14.9%; height:17px; text-align:left; border-radius:0px; float:left; margin-left:0.1%; text-indent:5px;">
											<?php echo formatdate(substr($tdate,0,10),'fromdb');?>
										</div>
									</div>
								</div><?php
							}?>
						</div><?php

						if ($cnt1%2==0)
						{?>
							<p style="page-break-after: always;">&nbsp;</p><?php
						}
					}
				}
			}?>
		<!-- InstanceEndEditable -->
	<!-- </div>	 -->
	<div id="futa"><?php foot_bar();?></div>
</body>
<!-- InstanceEnd --></html>