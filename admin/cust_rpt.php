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
	<?php do_toup_div('Student Management System');?>
	

	<div id="rtlft_std" style="position:relative; height:88%; margin-left:0.3%; width:99.7%; overflow:auto;">
		<!-- InstanceBeginEditable name="EditRegion6" -->
            <div class="innercont_top"><?php
				if(isset($_REQUEST['whattodo']))
				{
					if($_REQUEST['whattodo'] == 1)
					{
						echo 'Exam registration count';
					}else if($_REQUEST['whattodo'] == 2)
					{
						echo 'Student count';
					}else if($_REQUEST['whattodo'] == 3)
					{
						echo 'List of faculties';
					}else if($_REQUEST['whattodo'] == 4)
					{
						echo 'List of faculties and departments';
					}else if($_REQUEST['whattodo'] == 5)
					{
						echo 'List of faculties, departments and programmes';
					}else if($_REQUEST['whattodo'] == 6)
					{
						echo 'List of registrable courses';
					}else if($_REQUEST['whattodo'] == 7)
					{
						echo 'List of Study centres';
					}else if($_REQUEST['whattodo'] == '7a')
					{
						echo 'List of students';
					}else if($_REQUEST['whattodo'] == 8)
					{
						echo 'DEA request';
					}else if($_REQUEST['whattodo'] == '8a')
					{
						echo 'Exam registrations';
					}else if($_REQUEST['whattodo'] == 9)
					{
						echo 'PAS';
					}else if($_REQUEST['whattodo'] == '9a')
					{
						if (isset($_REQUEST['crs_reg_slip']))
						{
							echo 'Printing press - Course registration slips';
						}else
						{
							echo 'Printing press - Distribution of Course registration by Study Centre';
						}
					}else if($_REQUEST['whattodo'] == 10)
					{
						echo 'CEMBA/CEMPA - Applicants yet to be cleared';
					}else if($_REQUEST['whattodo'] == 11)
					{
						echo 'NELFUND List';
					}else if($_REQUEST['whattodo'] == 12)
					{
						echo 'JAMB List';
					}else if($_REQUEST['whattodo'] == '12a')
					{
						echo 'SIWES List';
					}else if($_REQUEST['whattodo'] == 13)
					{
						echo 'Wallet funding';
					}else if($_REQUEST['whattodo'] == 14)
					{
						if (isset($_REQUEST['debit_smry1']))
						{
							echo 'Summary of wallet debits';
						}else if (isset($_REQUEST['debit_smry2']))
						{
							echo 'Payment distribution by items';
						}else
						{
							echo 'Wallet debits';
						}
					}else if($_REQUEST['whattodo'] == 15)
					{
						echo 'Gown refund requests';
					}else if($_REQUEST['whattodo'] == 16)//CHD
					{
						if ($_REQUEST["show_chd_opt_h"] == '1')
						{
							echo 'CHRD Applicants';
						}else if ($_REQUEST["show_chd_opt_h"] == '2')
						{
							echo 'CHRD Registrations';
						}
					}else if($_REQUEST['whattodo'] == 17)
					{
						echo 'LAW Application list - Not cleared';
					}
				}else
				{
					echo '';
				}?>
			</div><?php

			//echo $_REQUEST['whattodo'];

			if(isset($_REQUEST['whattodo']))
			{				
				if($_REQUEST['whattodo'] == 1)//Exam registration count
				{?>
					<div class="innercont_stff" style="width:80%; margin-top:0px;">
						<label class="labell_structure" style="width:auto"><?php echo $_REQUEST['study_center_disc'];?></label>
					</div>
					<div class="innercont_stff" style="width:80%; margin-top:0px;">
						<label class="labell_structure" style="width:auto"><?php if ($_REQUEST['exam_type'] == 2){echo 'e-Exam';}else{echo 'POP Exam';}?></label>
					</div><?php
					$sqlstr = "(MID(c.cCourseId,4,1) IN ('1','2') OR c.cCourseId IN ('NOU707','NOU807','GST707','GST807','GST302'))";
					if($_REQUEST['exam_type'] == 1)
					{
						$sqlstr = "MID(c.cCourseId,4,1) IN ('3','4','5','7','8') AND c.cCourseId <> 'GST302' ";
					}

					$sql = "SELECT a.cCourseId , c.vCourseDesc, count(*) 
					FROM $wrking_examreg_tab a, s_m_t b, courses_new c
					WHERE a.vMatricNo = b.vMatricNo
					AND a.cCourseId  = c.cCourseId 
					AND LEFT(a.tdate,10) >= '$semester_begin_date'
					AND b.cStudyCenterId = ?
					AND $sqlstr
					GROUP BY a.cCourseId, c.vCourseDesc"; //echo $sql;

					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param("s", $_REQUEST['study_center']);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($coursesid, $coursesdesc, 
					$counts);
				}else if($_REQUEST['whattodo'] == 2)//student count
				{
					if (isset($_REQUEST['staff_study_center']) && $_REQUEST['staff_study_center'] <> '')
					{?>
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto">Study centre: <?php echo $_REQUEST['centre_disc'];?></label>
						</div><?php
					}

					if (isset($_REQUEST['cFacultyIdold']) && $_REQUEST['cFacultyIdold'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto">Faculty: <?php echo $_REQUEST['faculty_disc'];?></label>
						</div><?php
					}
					
					if (isset($_REQUEST['cdeptold']) && $_REQUEST['cdeptold'] <> '')
					{?>	
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto">Department: <?php echo $_REQUEST['dept_disc'];?></label>
						</div><?php
					}
					
					if (isset($_REQUEST['cprogrammeIdold']) && $_REQUEST['cprogrammeIdold'] <> '')
					{?>
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto">Programme: <?php echo $_REQUEST['prog_disc'];?></label>
						</div><?php
					}
					
					if (isset($_REQUEST['reg_point']) && $_REQUEST['reg_point'] <> '')
					{?>
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto">Registration point: <?php echo $_REQUEST['reg_point_disc'];?></label>
						</div><?php
					}
					
					if (isset($_REQUEST['prog_cat_loc']) && $_REQUEST['prog_cat_loc'] <> '')
					{?>
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto">Category: <?php echo $_REQUEST['prog_cat_disc'];?></label>
						</div><?php
					}

					$field_list = "";
					$tables = "s_m_t a,";
					$where_c = "";
					$where_crit = "";
					$groupin = "";
					$order = "";

					$arr1 = str_split($_REQUEST['dist_point']);
					
					foreach ($arr1 as $val_arr)
					{
						if ($val_arr == 's')//study centre
						{
							$field_list .= "b.vCityName 'Study centre', ";
							$tables .= "studycenter b,";
							$where_c .= "a.cStudyCenterId = b.cStudyCenterId AND ";
							$groupin .= "b.vCityName, ";
							$order .= "b.vCityName, ";
						}else if ($val_arr == 'f')//faculty
						{
							$field_list .= "c.vFacultyDesc Faculty, ";
							$tables .= "faculty c,";
							$where_c .= "a.cFacultyId = c.cFacultyId AND ";
							$groupin .= "c.vFacultyDesc, ";
							$order .= "c.vFacultyDesc, ";
						}else if ($val_arr == 'd')//department
						{
							$field_list .= "d.vdeptDesc Department, ";
							$tables .= "depts d,";
							$where_c .= "a.cdeptId = d.cdeptId AND ";
							$groupin .= "d.vdeptDesc, ";
							$order .= "d.vdeptDesc, ";
						}else if ($val_arr == 'p')//Programme
						{
							$field_list .= "REPLACE(h.vObtQualTitle, '.', '') Qualification, e.vProgrammeDesc Programme, ";
							$tables .= "programme e, obtainablequal h,";
							$where_c .= "a.cProgrammeId = e.cProgrammeId AND a.cObtQualId = h.cObtQualId AND ";
							$groupin .= "h.vObtQualTitle, e.vProgrammeDesc, ";
							$order .= "h.vObtQualTitle, e.vProgrammeDesc, ";
						}else if ($val_arr == 'l')//Level
						{ 
							$field_list .= "a.iStudy_level 'Level', ";
							$groupin .= "a.iStudy_level, ";
							$order .= "a.iStudy_level, ";
						}else if ($val_arr == 'g')//Gender
						{
							$field_list .= "a.cGender Gender, ";
							$groupin .= "a.cGender, ";
							$order .= "a.cGender, ";
						}
					}

					if (isset($_REQUEST['staff_study_center']) && $_REQUEST['staff_study_center'] <> '')
					{
						$where_crit .= "AND a.cStudyCenterId = '".$_REQUEST['staff_study_center']."' ";
					}
					
					if (isset($_REQUEST['cFacultyIdold']) && $_REQUEST['cFacultyIdold'] <> '')
					{
						$where_crit .= "AND a.cFacultyId = '".$_REQUEST['cFacultyIdold']."' ";
					}
					
					if (isset($_REQUEST['cdeptold']) && $_REQUEST['cdeptold'] <> '')
					{
						$where_crit .= "AND a.cdeptId = '".$_REQUEST['cdeptold']."' ";
					}
					
					if (isset($_REQUEST['cprogrammeIdold']) && $_REQUEST['cprogrammeIdold'] <> '')
					{
						$where_crit .= "AND a.cProgrammeId = '".$_REQUEST['cprogrammeIdold']."' ";
					}


					if (isset($_REQUEST['prog_cat_loc']) && $_REQUEST['prog_cat_loc'] <> '')
					{
						if ($_REQUEST['prog_cat_loc'] == 'PSZ')
						{
							$where_crit .= "AND MID(cProgrammeId,4,1) = 2 ";
							
						}else if ($_REQUEST['prog_cat_loc'] == 'PGX')
						{
							$where_crit .= "AND MID(cProgrammeId,4,1) = 3 ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PGY')
						{
							$where_crit .= "AND MID(cProgrammeId,4,1) = 4 ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PGZ')
						{
							$where_crit .= "AND MID(cProgrammeId,4,1) = 5 ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PRX')
						{
							$where_crit .= "AND MID(cProgrammeId,4,1) = 6 ";
						}else if ($_REQUEST['prog_cat_loc'] == 'ELZ')
						{
							//$where_crit .= "AND MID(cProgrammeId,4,1) = 0 ";
							$where_crit .= "AND (cProgrammeId LIKE 'CHD01%' OR cProgrammeId LIKE 'DEG01%') ";
						}else if ($_REQUEST['prog_cat_loc'] == 'ELX')
						{
							$where_crit .= "AND (cProgrammeId LIKE 'CHD00%' OR cProgrammeId LIKE 'DEG00%') ";
						}
						
						// if ($_REQUEST['prog_cat_loc'] <> 'ELZ' && $_REQUEST['prog_cat_loc'] <> 'ELX')
						// {
						// 	$where_crit .= "AND vMatricNo IN (SELECT DISTINCT `vMatricNo` FROM $wrking_tab WHERE fee_item_id IN ('1','4','13','17','19','21') AND tdate >= '$semester_begin_date') ";
						// }
					}


					if (isset($_REQUEST['reg_point']) && $_REQUEST['reg_point'] <> '')
					{
						if ($_REQUEST['reg_point'] == 's')
						{
							$where_crit .= "AND a.semester_reg = '1' ";

							if (isset($_REQUEST['prog_cat_loc']) && $_REQUEST['prog_cat_loc'] <> '')
							{
								// if ($_REQUEST['prog_cat_loc'] == 'PSZ')
								// {
								// 	$where_crit .= "AND MID(cProgrammeId,4,1) = 2 ";
									
								// }else if ($_REQUEST['prog_cat_loc'] == 'PGX')
								// {
								// 	$where_crit .= "AND MID(cProgrammeId,4,1) = 3 ";
								// }else if ($_REQUEST['prog_cat_loc'] == 'PGY')
								// {
								// 	$where_crit .= "AND MID(cProgrammeId,4,1) = 4 ";
								// }else if ($_REQUEST['prog_cat_loc'] == 'PGZ')
								// {
								// 	$where_crit .= "AND MID(cProgrammeId,4,1) = 5 ";
								// }else if ($_REQUEST['prog_cat_loc'] == 'PRX')
								// {
								// 	$where_crit .= "AND MID(cProgrammeId,4,1) = 6 ";
								// }else if ($_REQUEST['prog_cat_loc'] == 'ELZ')
								// {
								// 	//$where_crit .= "AND MID(cProgrammeId,4,1) = 0 ";
								// 	$where_crit .= "AND (cProgrammeId LIKE 'CHD01%' OR cProgrammeId LIKE 'DEG01%') ";
								// }else if ($_REQUEST['prog_cat_loc'] == 'ELX')
								// {
								// 	$where_crit .= "AND (cProgrammeId LIKE 'CHD00%' OR cProgrammeId LIKE 'DEG00%') ";
								// }
								
								if ($_REQUEST['prog_cat_loc'] <> 'ELZ' && $_REQUEST['prog_cat_loc'] <> 'ELX')
								{
									$where_crit .= "AND vMatricNo IN (SELECT DISTINCT `vMatricNo` FROM $wrking_tab WHERE fee_item_id IN ('1','4','13','17','19','21') AND tdate >= '$semester_begin_date') ";
								}
							}
						}else if ($_REQUEST['reg_point'] == 'c')
						{
							$where_crit .= "AND a.vMatricNo IN (SELECT DISTINCT vMatricNo FROM $wrking_crsreg_tab WHERE LEFT(tdate,10) >= '$semester_begin_date') ";
						}else if ($_REQUEST['reg_point'] == 'e')
						{
							$where_crit .= "AND a.vMatricNo IN (SELECT DISTINCT vMatricNo FROM $wrking_examreg_tab WHERE LEFT(tdate,10) >= '$semester_begin_date') ";
						}
					}					
					
					
					
					$field_list .= "count(*) Count";
					$tables = substr($tables,0,strlen($tables)-1);
					$where_c = substr($where_c,0,strlen($where_c)-4);
					$groupin = "GROUP BY ".substr($groupin,0,strlen($groupin)-2);
					$order = "ORDER BY ".substr($order,0,strlen($order)-2);

					$sql = "SELECT ".$field_list." FROM ".$tables." WHERE ".$where_c." ".$where_crit." ".$groupin." ".$order;
					if ($where_c == '' && $where_crit == '')
					{
						$sql = "SELECT ".$field_list." FROM ".$tables." ".$groupin." ".$order;
					}else if ($where_c == '' && $where_crit <> '')
					{
						$where_crit = substr($where_crit,4,strlen($where_crit)-1);
						$sql = "SELECT ".$field_list." FROM ".$tables." WHERE ".$where_crit." ".$groupin." ".$order;
					}

					//$sql = "SELECT ".$field_list." FROM ".$tables." WHERE ".$where_c." ".$where_crit." ".$groupin." ".$order; 
					//echo $sql;
					
					$result = $mysqli -> query($sql);
				}else if($_REQUEST['whattodo'] == 3)//list faculties
				{
					$stmt = $mysqli->prepare("SELECT vFacultyDesc FROM faculty
					WHERE cCat = 'A'
					AND cDelFlag = 'N'");
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($vFacultyDesc);
				}else if($_REQUEST['whattodo'] == 4)//list dept
				{
					$stmt = $mysqli->prepare("SELECT vFacultyDesc, vdeptDesc FROM faculty a, depts b
					WHERE a.cFacultyId  = b.cFacultyId 
					AND cCat = 'A'
					AND a.cDelFlag = b.cDelFlag
                    AND a.cDelFlag = 'N'
					order by vFacultyDesc, vdeptDesc");
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($vFacultyDesc, $vdeptDesc);
				}else if($_REQUEST['whattodo'] == 5)//list programmes
				{
					$stmt = $mysqli->prepare("SELECT vFacultyDesc, vdeptDesc, CONCAT(REPLACE(d.vObtQualTitle, '.', ''),' ',c.vProgrammeDesc) program 
					FROM faculty a, depts b, programme c, obtainablequal d
					WHERE a.cFacultyId  = b.cFacultyId
                    AND c.cdeptId = b.cdeptId
                    AND c.cObtQualId = d.cObtQualId
					AND cCat = 'A'
					AND a.cDelFlag = b.cDelFlag
                    AND a.cDelFlag = 'N'
					order by vFacultyDesc, vdeptDesc, program");
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($vFacultyDesc, $vdeptDesc, $program);
				}else if($_REQUEST['whattodo'] == 6)//list courses
				{?>
					<div class="innercont_stff" style="width:80%; margin-top:0px;">
						<label class="labell_structure" style="width:auto">Faculty: <?php echo $_REQUEST['faculty_disc'];?></label>
					</div>
					<div class="innercont_stff" style="width:80%; margin-top:0px;">
						<label class="labell_structure" style="width:auto">Department: <?php echo $_REQUEST['dept_disc'];?></label>
					</div>
					<div class="innercont_stff" style="width:80%; margin-top:0px;">
						<label class="labell_structure" style="width:auto">Programme: <?php echo $_REQUEST['prog_disc'];?></label>
					</div><?php
					$stmt = $mysqli->prepare("SELECT f.siLevel, e.tSemester, e.iCreditUnit, f.cCategory, e.ancilary_type, f.cCourseId, e.vCourseDesc 
					FROM faculty a, depts b, programme c, obtainablequal d, courses_new e, progcourse f
					WHERE a.cFacultyId  = b.cFacultyId
                    AND c.cdeptId = b.cdeptId
                    AND c.cObtQualId = d.cObtQualId
                    AND f.cProgrammeId = c.cProgrammeId
                    AND e.cCourseId = f.cCourseId
					AND cCat = 'A'
					AND a.cDelFlag = b.cDelFlag
                    AND a.cDelFlag = 'N'
					AND a.cFacultyId = ?
					AND c.cdeptId = ?
					AND f.cProgrammeId = ?
					order by f.siLevel, e.tSemester, f.cCourseId");
					$stmt->bind_param("sss", $_REQUEST["cFacultyIdold"], $_REQUEST["cdeptold"], $_REQUEST["cprogrammeIdold"]);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($level, $semester, $crunit, $cCategory, $class, $coursecode, $coursetitle);
				}else if($_REQUEST['whattodo'] == 7)//list centres
				{
					$stmt = $mysqli->prepare("SELECT a.cGeoZoneId, a.vStateName, b.vCityName 
					FROM ng_state a, studycenter b 
					WHERE a.cStateId = b.cStateId
					ORDER BY a.cGeoZoneId, a.vStateName, b.vCityName");
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($zone, 
					$sate, 
					$centre);
				}else if($_REQUEST['whattodo'] == '7a')//list student
				{
					if (isset($_REQUEST['cFacultyIdold']) && $_REQUEST['cFacultyIdold'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto">Faculty: <?php echo $_REQUEST['faculty_disc'];?></label>
						</div><?php
					}

					if (isset($_REQUEST['cdeptold']) && $_REQUEST['cdeptold'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto">Department: <?php echo $_REQUEST['dept_disc'];?></label>
						</div><?php
					}
					
					if (isset($_REQUEST['cprogrammeIdold']) && $_REQUEST['cprogrammeIdold'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto">Programme: <?php echo $_REQUEST['prog_disc'];?></label>
						</div><?php
					}
					
					$arr_values = "";
					if (isset($_REQUEST['ccourseIdold']))
					{						
						foreach ($_REQUEST['ccourseIdold'] as $key => $value)
						{
							$arr_values .= "'".$value."',";
						}
						$arr_values = substr($arr_values,0,strlen($arr_values)-1);

						if (strlen($arr_values) > 6)
						{?>
							<div class="innercont_stff" style="width:80%; margin-top:0px; height:auto;">
								<label class="labell_structure" style="width:auto; height:auto;padding: 5px 0 5px 0; line-height:1.5;">Course(s): <?php 
								$sql = "SELECT cCourseId, vCourseDesc FROM courses_new WHERE cCourseId IN ($arr_values)";
								$rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
								while ($rs = mysqli_fetch_array($rssql))
								{
									echo $rs['cCourseId'].' '.$rs['vCourseDesc'].'<br>';
								}
								mysqli_close(link_connect_db());?>
								</label>
							</div><?php
						}?><?php
					}
					
					if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto">Level: <?php echo $_REQUEST['courseLevel'].'Level';?></label>
						</div><?php
					}
					
					if (isset($_REQUEST['staff_study_center']) && $_REQUEST['staff_study_center'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto">Study centre: <?php echo $_REQUEST['centre_disc'];?></label>
						</div><?php
					}

					if (isset($_REQUEST['frs_students']))
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto">Fresh students only</label>
						</div><?php
					}

					$cnt = -1;
					$country_arr = array(array());
					$stmt = $mysqli->prepare("SELECT cCountryId, vCountryName FROM country ORDER BY cCountryId");
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($cCountryId, $vCountryName);					
					while($stmt->fetch())
					{
						$cnt++;
						$country_arr[$cnt]['cCountryId'] = $cCountryId;
						$country_arr[$cnt]['vCountryName'] = $vCountryName;
						//echo $country_arr[$cnt]['cCountryId'].'*'.$country_arr[$cnt]['vCountryName'].'<br>';
					}

					$cnt = -1;
					$state_arr = array(array());
					$stmt = $mysqli->prepare("SELECT cStateId, vStateName FROM ng_state ORDER BY cStateId");
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($cStateId, $vStateName);					
					while($stmt->fetch())
					{
						$cnt++;
						$state_arr[$cnt]['cStateId'] = $cStateId;
						$state_arr[$cnt]['vStateName'] = $vStateName;
						//echo $state_arr[$cnt]['state'].'*'.$state_arr[$cnt]['statename'].'<br>';
					}

					$cnt = -1;
					$localarea_arr = array(array());
					$stmt = $mysqli->prepare("SELECT cLGAId, vLGADesc FROM localarea ORDER BY cLGAId");
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($cLGAId, $vLGADesc);					
					while($stmt->fetch())
					{
						$cnt++;
						$localarea_arr[$cnt]['cLGAId'] = $cLGAId;
						$localarea_arr[$cnt]['vLGADesc'] = ucwords(strtolower($vLGADesc));
						//echo $localarea_arr[$cnt]['cLGAId'].'*'.$localarea_arr[$cnt]['vLGADesc'].', '.$cnt.'<br>';
					}
					
					$cnt = -1;
					$disability_arr = array(array());
					$stmt = $mysqli->prepare("SELECT cDisabilityId, vDisabilityDesc FROM disability ORDER BY cDisabilityId");
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($cDisabilityId, $vDisabilityDesc);					
					while($stmt->fetch())
					{
						$cnt++;
						$disability_arr[$cnt]['cDisabilityId'] = $cDisabilityId;
						$disability_arr[$cnt]['vDisabilityDesc'] = $vDisabilityDesc;
						//echo $disability_arr[$cnt]['cDisabilityId'].'*'.$disability_arr[$cnt]['vDisabilityDesc'].'<br>';
					}
					
					$cnt = -1;
					$faculty_arr = array(array());
					$stmt = $mysqli->prepare("SELECT cFacultyId, vFacultyDesc FROM faculty ORDER BY cFacultyId");
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($cFacultyId, $vFacultyDesc);					
					while($stmt->fetch())
					{
						$cnt++;
						$faculty_arr[$cnt]['cFacultyId'] = $cFacultyId;
						$faculty_arr[$cnt]['vFacultyDesc'] = $vFacultyDesc;
						//echo $faculty_arr[$cnt]['cFacultyId'].'*'.$faculty_arr[$cnt]['vFacultyDesc'].'<br>';
					}
					
					$cnt = -1;
					$dept_arr = array(array());
					$stmt = $mysqli->prepare("SELECT cdeptId, vdeptDesc FROM depts ORDER BY cdeptId");
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($cdeptId, $vdeptDesc);					
					while($stmt->fetch())
					{
						$cnt++;
						$dept_arr[$cnt]['cdeptId'] = $cdeptId;
						$dept_arr[$cnt]['vdeptDesc'] = $vdeptDesc;
						//echo $dept_arr[$cnt]['cdeptId'].'*'.$dept_arr[$cnt]['vdeptDesc'].'<br>';
					}
					
					$cnt = -1;
					$prog_arr = array(array());
					$stmt = $mysqli->prepare("SELECT cProgrammeId, CONCAT(REPLACE(vObtQualTitle, '.', ''),' ',vProgrammeDesc) vProgrammeDesc FROM programme a, obtainablequal b WHERE a.cObtQualId = b.cObtQualId ORDER BY cProgrammeId");
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($cProgrammeId, $vProgrammeDesc);					
					while($stmt->fetch())
					{
						$cnt++;
						$prog_arr[$cnt]['cProgrammeId'] = $cProgrammeId;
						$prog_arr[$cnt]['vProgrammeDesc'] = $vProgrammeDesc;
						//echo $prog_arr[$cnt]['cProgrammeId'].'*'.$prog_arr[$cnt]['vProgrammeDesc'].'<br>';
					}

					//$where_crit = "";
					$where_crit = "a.semester_reg = '1' AND ";
					$where = "";
					$more_table = "";

					/*$sql = "SELECT UCASE(a.vMatricNo),
					vLastName,
					vFirstName,
					vOtherName,
					cMaritalStatusId,
					cGender,
					cDisabilityId,
					cHomeCountryId,
					cHomeStateId,
					cHomeLGAId,
					cResidenceCountryId,
					cResidenceStateId,
					cResidenceLGAId,
					vMobileNo 
					FROM s_m_t a";*/

					$sql = "SELECT UCASE(a.vMatricNo),
					vLastName,
					vFirstName,
					vOtherName,
					cMaritalStatusId,
					cGender,
					cDisabilityId,
					b.vCityName,
					cFacultyId,
					cdeptId,
					cProgrammeId,
					iStudy_level,
					vMobileNo 
					FROM s_m_t a, studycenter b";
					$where_crit = " a.cStudyCenterId = b.cStudyCenterId AND ";
					
					if (isset($_REQUEST['staff_study_center']) && $_REQUEST['staff_study_center'] <> '')
					{
						$where_crit .= "a.cStudyCenterId = '".$_REQUEST['staff_study_center']."' AND ";
					}
					
					if (isset($_REQUEST['cFacultyIdold']) && $_REQUEST['cFacultyIdold'] <> '')
					{
						$where_crit .= "a.cFacultyId = '".$_REQUEST['cFacultyIdold']."' AND ";
					}
					
					if (isset($_REQUEST['cdeptold']) && $_REQUEST['cdeptold'] <> '')
					{
						$where_crit .= "a.cdeptId = '".$_REQUEST['cdeptold']."' AND ";
					}
					
					if (isset($_REQUEST['cprogrammeIdold']) && $_REQUEST['cprogrammeIdold'] <> '')
					{
						$where_crit .= "a.cProgrammeId = '".$_REQUEST['cprogrammeIdold']."' AND ";
					}
					
					if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '')
					{
						$where_crit .= "a.iStudy_level = ".$_REQUEST['courseLevel']." AND ";
					}

					if (isset($_REQUEST['frs_students']))
					{
						$where_crit .= "vMatricNo IN (SELECT DISTINCT `vMatricNo` FROM $wrking_tab WHERE fee_item_id IN ('1','4','13','17','19','21') AND tdate >= '$semester_begin_date') AND ";
					}

					$arr_values = "";
					if (isset($_REQUEST['ccourseIdold']))
					{						
						foreach ($_REQUEST['ccourseIdold'] as $key => $value)
						{
							$arr_values .= "'".$value."',";
						}
						$arr_values = substr($arr_values,0,strlen($arr_values)-1);
						if (strlen($arr_values) > 6)
						{
							$more_table = ", $wrking_crsreg_tab b";
							$where_crit .= " a.vMatricNo = b.vMatricNo AND LEFT(b.tdate,10) >= '$semester_begin_date' AND ";
							$where_crit .= "b.cCourseId IN ($arr_values) AND ";
						}
					}

					//$where_crit .= $where;
					$where_crit = substr($where_crit,0,strlen($where_crit)-4);

					if ($where_crit <> '')
					{
						$sql .= $more_table . " WHERE ".$where_crit;
					}

					//echo $sql;exit;

					$stmt = $mysqli->prepare($sql);
					$stmt->execute();
					$stmt->store_result();
					/*$stmt->bind_result($vMatricNo,
					$vLastName,
					$vFirstName,
					$vOtherName,
					$cMaritalStatusId,
					$cGender,
					$cDisabilityId,
					$cHomeCountryId,
					$cHomeStateId,
					$cHomeLGAId,
					$cResidenceCountryId,
					$cResidenceStateId,
					$cResidenceLGAId,
					$vMobileNo);*/
					
					$stmt->bind_result($vMatricNo,
					$vLastName,
					$vFirstName,
					$vOtherName,
					$cMaritalStatusId,
					$cGender,
					$cDisabilityId,
					$cStudyCenterId, 
					$cFacultyId,
					$cdeptId,
					$cProgrammeId,
					$iStudy_level,
					$vMobileNo);
				}else if($_REQUEST['whattodo'] == 8)//DEA request
				{
					if (isset($_REQUEST['date_1']) && $_REQUEST['date_1'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo 'From '.formatdate($_REQUEST['date_1'],'fromdb').' to '.formatdate($_REQUEST['date_2'],'fromdb');?></label>
						</div><?php
					}
										
					if (isset($_REQUEST['cFacultyIdold']) && $_REQUEST['cFacultyIdold'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo $_REQUEST['faculty_disc'];?></label>
						</div><?php
					}
					
					if (isset($_REQUEST['prog_cat_loc']) && $_REQUEST['prog_cat_loc'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo $_REQUEST['prog_disc'];?></label>
						</div><?php
					}
					
					if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo $_REQUEST['courseLevel'].'Level';?></label>
						</div><?php
					}

					$where_crit = "";
										
					if (isset($_REQUEST['cFacultyIdold']) && $_REQUEST['cFacultyIdold'] <> '')
					{
						$where_crit .= "a.cFacultyId = '".$_REQUEST['cFacultyIdold']."' AND ";
					}

					if (isset($_REQUEST['prog_cat_loc']) && $_REQUEST['prog_cat_loc'] <> '')
					{
						$where_crit .= "c.cEduCtgId = '".$_REQUEST['prog_cat_loc']."' AND ";
					}
					
					if (isset($_REQUEST['date_1']) && $_REQUEST['date_1'] <> '')
					{
						$where_crit .= "(LEFT(b.tdate,10) >= '".$_REQUEST['date_1']."' AND LEFT(b.tdate,10) <= '".$_REQUEST['date_2']."') AND ";
					}
					
					if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '')
					{
						$where_crit .= "a.iStudy_level = ".$_REQUEST['courseLevel']." AND ";
					}

					$where_crit = substr($where_crit,0,strlen($where_crit)-4);
					
					$sql = "SELECT CONCAT(UCASE(a.vMatricNo), b.cCourseId) matcrs, 
					a.cProgrammeId programmeID, 
					CONCAT(REPLACE(d.vObtQualTitle, '.', ''),' ', c.vProgrammeDesc) programme, 
					UCASE(a.vMatricNo) matno, 
					CONCAT(a.vLastName,' ',a.vFirstName,' ',a.vOtherName) 'name',
					'242' sesion,
					'NULL' Field1,
					e.cCourseId,
					e.vCourseDesc,
					e.iCreditUnit,
					a.iStudy_level,
					a.cStudyCenterId,
					a.cFacultyId,
					f.vFacultyDesc,
					g.vCityName,
					CONCAT(lcase(a.vMatricNo),'@noun.edu.ng'),
					a.vMobileNo,
					a.vEMailId,
					'NULL' Field2,
					b.tdate
					FROM s_m_t a, $wrking_examreg_tab b, programme c, obtainablequal d, courses_new e, faculty f, studycenter g
					WHERE a.vMatricNo = b.vMatricNo
					AND a.cProgrammeId = c.cProgrammeId
					AND d.cObtQualId = c.cObtQualId
					and b.cCourseId = e.cCourseId
					AND a.cFacultyId = f.cFacultyId
					AND a.cStudyCenterId = g.cStudyCenterId
					AND LEFT(b.tdate,10) >= '$semester_begin_date' AND $where_crit";

					$stmt = $mysqli->prepare($sql);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($matcrs, 
					$programmeID, 
					$programme, 
					$matno, 
					$name, 
					$sesion, 
					$Field1,
					$courseID,
					$coursetitle,
					$creditunit,
					$level,
					$centreid,
					$facultyid,
					$facultydesc,
					$centre,
					$email,
					$phone,
					$email2,
					$field2,
					$tdate);
				}else if($_REQUEST['whattodo'] == '8a')//Exam registrations
				{										
					if (isset($_REQUEST['exam_type_disc']) && $_REQUEST['exam_type_disc'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo $_REQUEST['exam_type_disc'];?></label>
						</div><?php
					}

					if (isset($_REQUEST['date_1']) && $_REQUEST['date_1'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo 'From '.formatdate($_REQUEST['date_1'],'fromdb').' to '.formatdate($_REQUEST['date_2'],'fromdb');?></label>
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

					$where_crit = "";
										
					if (isset($_REQUEST['exam_type']) && $_REQUEST['exam_type'] <> '')
					{
						$where_crit .= "(e.cCourseId IN ('NOU707','NOU807') OR MID(e.cCourseId,4,1) IN ".$_REQUEST['exam_type'].") AND ";
					}
										
					if (isset($_REQUEST['cFacultyIdold']) && $_REQUEST['cFacultyIdold'] <> '')
					{
						$where_crit .= "a.cFacultyId = '".$_REQUEST['cFacultyIdold']."' AND ";
					}

					if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '')
					{
						$where_crit .= "a.iStudy_level = '".$_REQUEST['courseLevel']."' AND ";
					}
					
					if (isset($_REQUEST['date_1']) && $_REQUEST['date_1'] <> '')
					{
						$where_crit .= "(LEFT(b.tdate,10) >= '".$_REQUEST['date_1']."' AND LEFT(b.tdate,10) <= '".$_REQUEST['date_2']."') AND ";
					}					

					$where_crit = substr($where_crit,0,strlen($where_crit)-4);
					
					$sql = "SELECT UCASE(a.vMatricNo) matno, 
					CONCAT(a.vLastName,' ',a.vFirstName,' ',a.vOtherName) 'name',
					e.cCourseId,
					e.vCourseDesc,
					e.iCreditUnit,
					b.tdate,
					a.iStudy_level,
					a.cStudyCenterId,
					g.vCityName,
					a.cProgrammeId
					FROM s_m_t a, $wrking_examreg_tab b, courses_new e, studycenter g
					WHERE a.vMatricNo = b.vMatricNo
					and b.cCourseId = e.cCourseId
					AND a.cStudyCenterId = g.cStudyCenterId
					AND LEFT(b.tdate,10) >= '$semester_begin_date'
					AND $where_crit"; //echo $sql;

					$stmt = $mysqli->prepare($sql);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($matno,
					$names,
					$cCourseId,
					$vCourseDesc,
					$iCreditUnit,
					$tdate,  
					$iStudy_level,
					$cStudyCenterId,
					$vCityName,
					$cProgrammeId);
				}else if($_REQUEST['whattodo'] == 9)//PAS
				{
					if (isset($_REQUEST['date_1']) && $_REQUEST['date_1'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo 'From '.formatdate($_REQUEST['date_1'],'fromdb').' to '.formatdate($_REQUEST['date_2'],'fromdb');?></label>
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
					}

					$where_crit = "";
										
					if (isset($_REQUEST['cFacultyIdold']) && $_REQUEST['cFacultyIdold'] <> '')
					{
						$where_crit .= "a.cFacultyId = '".$_REQUEST['cFacultyIdold']."' AND ";
					}

					if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '')
					{
						$where_crit .= "a.iStudy_level = '".$_REQUEST['courseLevel']."' AND ";
					}

					if (isset($_REQUEST['prog_cat_loc']) && $_REQUEST['prog_cat_loc'] <> '')
					{
						$where_crit .= "h.cEduCtgId = '".$_REQUEST['prog_cat_loc']."' AND ";
					}
					
					if (isset($_REQUEST['date_1']) && $_REQUEST['date_1'] <> '')
					{
						$where_crit .= "(LEFT(b.tdate,10) >= '".$_REQUEST['date_1']."' AND LEFT(b.tdate,10) <= '".$_REQUEST['date_2']."') AND ";
					}

					$where_crit = substr($where_crit,0,strlen($where_crit)-4);

					$sql = "SELECT 
					a.vLastName, 
					a.vFirstName, 
					a.vOtherName,
					a.cStudyCenterId 'studycentre id',
					g.vCityName 'studycentre name',
					a.cFacultyId 'faculty id',
					j.vFacultyDesc 'faculty name',
					a.cProgrammeId 'programme id',
					concat(REPLACE(i.vObtQualTitle, '.', ''),' ',h.vProgrammeDesc) 'programme name',
					UCASE(a.vMatricNo) 'matric number',
					b.cCourseId coursecode,
					b.vCourseDesc coursetitle,
					b.iCreditUnit 'credit unit',
					concat(lcase(a.vMatricNo),'@noun.edu.ng') email,
					a.vMobileNo mobile
					FROM s_m_t a, $wrking_crsreg_tab b, studycenter g, programme h, obtainablequal i, faculty j
					WHERE a.vMatricNo = b.vMatricNo
					AND a.cStudyCenterId = g.cStudyCenterId
					AND a.cProgrammeId = h.cProgrammeId
					AND h.cObtQualId = i.cObtQualId
					AND a.cFacultyId = j.cFacultyId
					AND b.ancilary_type not in ('normal', 'Laboratory')
					AND LEFT(b.tdate,10) >= '$semester_begin_date'
					AND $where_crit";

					$stmt = $mysqli->prepare($sql);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($vLastName,
					$vFirstName,
					$vOtherName,
					$centreId,
					$centre,
					$facultyId,
					$faculty,  
					$progId,
					$prog,
					$vMatricNo,
					$courseId,
					$Course,
					$crunit,
					$email,
					$phone);
				}else if($_REQUEST['whattodo'] == '9a')//Printing press
				{
					if (isset($_REQUEST['staff_study_center']) && $_REQUEST['staff_study_center'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo $_REQUEST['centre_disc'];?></label>
						</div><?php
					}
					
					if (isset($_REQUEST['cFacultyIdold_loc']) && $_REQUEST['cFacultyIdold_loc'] <> '')
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
					}

					$where_crit = "";
										
					if (isset($_REQUEST['staff_study_center']) && $_REQUEST['staff_study_center'] <> '')
					{
						$where_crit .= "b.cStudyCenterId = '".$_REQUEST['staff_study_center']."' AND ";
					}
										
					if (isset($_REQUEST['cFacultyIdold_loc']) && $_REQUEST['cFacultyIdold_loc'] <> '')
					{
						$where_crit .= "b.cFacultyId = '".$_REQUEST['cFacultyIdold_loc']."' AND ";
					}

					if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '')
					{
						$where_crit .= "b.iStudy_level = '".$_REQUEST['courseLevel']."' AND ";
					}

					if (isset($_REQUEST['prog_cat_loc']))
					{
						if ($_REQUEST['prog_cat_loc'] == 'PSZ')
						{
							$where_crit .= "b.cProgrammeId LIKE '___2%' AND ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PGX')
						{
							$where_crit .= "b.cProgrammeId LIKE '___3%' AND ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PGY')
						{
							$where_crit .= "b.cProgrammeId LIKE '___4%' AND ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PGZ')
						{
							$where_crit .= "b.cProgrammeId LIKE '___5%' AND ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PRX')
						{
							$where_crit .= "b.cProgrammeId LIKE '___6%' AND ";
						}
					}

					$where_crit = substr($where_crit,0,strlen($where_crit)-4);
					
					$sql = "SELECT c.vCityName, CONCAT(a.cCourseId,' ',d.vCourseDesc) cCourseId, count(*) 
					FROM $wrking_crsreg_tab a, s_m_t b, studycenter c, courses_new d 
					where a.vMatricNo = b.vMatricNo 
					and b.cStudyCenterId = c.cStudyCenterId 
					AND a.cCourseId = d.cCourseId 
					and LEFT(a.tdate,10) >= '$semester_begin_date'
					AND $where_crit 
					group by b.cStudyCenterId, a.cCourseId 
					order by c.vCityName, a.cCourseId";//echo $sql;

					$stmt = $mysqli->prepare($sql);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($studycentre,
					$courseid,
					$count);
					
				}else if($_REQUEST['whattodo'] == 10)//CEMBA
				{
					$stmt = $mysqli->prepare("SELECT b.vCityName, 
					c.vProgrammeDesc, 
					vApplicationNo,
					vLastName,
					vFirstName,
					vOtherName,
					vEMailId,
					vMobileNo 
					FROM prog_choice a, studycenter b, programme c
					where a.cStudyCenterId = b.cStudyCenterId 
					and a.cProgrammeId = c.cProgrammeId
					and c.cProgrammeId in ('MSC415','MSC416') AND cSbmtd <> 2;");
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($vCityName, 
					$vProgrammeDesc, 
					$vApplicationNo, 
					$vLastName, 
					$vFirstName, 
					$vOtherName, 
					$vEMailId,
					$vMobileNo);
				}else if($_REQUEST['whattodo'] == 11)//NELFUND
				{
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

					$where_crit = "";
										
					if (isset($_REQUEST['cFacultyIdold']) && $_REQUEST['cFacultyIdold'] <> '')
					{
						$where_crit .= "a.cFacultyId = '".$_REQUEST['cFacultyIdold']."' AND ";
					}

					if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '')
					{
						$where_crit .= "a.iStudy_level = '".$_REQUEST['courseLevel']."' AND ";
					}

					$where_crit = substr($where_crit,0,strlen($where_crit)-4);

					$sql = "SELECT vApplicationNo, ucase(vFirstName) firstname, 
					ucase(vOtherName) middlename, 
					vLastName lastname, 
					concat(lcase(vMatricNo),'@noun.edu.ng') email, 
					vMobileNo 'phone number', 
					cGender gender, 
					ucase(vMatricNo) 'matric number',  
					'JAMB No',
					iStudy_level 'level', 
					YEAR(NOW()),
					dBirthDate,
					cHomeStateId, 
					concat(REPLACE(d.vObtQualTitle, '.', ''),' ', b.vProgrammeDesc) 'degree type',
					e.vFacultyDesc faculty,
					f.vdeptDesc department
					FROM s_m_t a, programme b, obtainablequal d, faculty e, depts f
					WHERE a.cProgrammeId = b.cProgrammeId
					AND a.cObtQualId = d.cObtQualId
					AND a.cFacultyId = e.cFacultyId
					AND a.cdeptId = f.cdeptId
					AND b.cEduCtgId <> 'ELX'
					AND a.semester_reg = '1'
					AND $where_crit";

					$stmt = $mysqli->prepare($sql);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($afn,
					$vFirstName,
					$middlename, 
					$vLastName,
					$email,
					$phone,
					$gender,
					$vMatricNo,
					$jambno, 
					$level,
					$year,
					$dob,
					$cHomeStateId,
					$program,
					$faculty,  
					$depts);
				}else if($_REQUEST['whattodo'] == 12)//JAMB
				{
					if (isset($_REQUEST['date_1']) && $_REQUEST['date_1'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo 'From '.formatdate($_REQUEST['date_1'],'fromdb').' to '.formatdate($_REQUEST['date_2'],'fromdb');?></label>
						</div><?php
					}

					if (isset($_REQUEST['cFacultyIdold']) && $_REQUEST['cFacultyIdold'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto">Faculty: <?php echo $_REQUEST['faculty_disc'];?></label>
						</div><?php
					}
					
					if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto">Level: <?php echo $_REQUEST['courseLevel'].'Level';?></label>
						</div><?php
					}

					$where_crit = "";
										
					if (isset($_REQUEST['cFacultyIdold']) && $_REQUEST['cFacultyIdold'] <> '')
					{
						$where_crit .= "a.cFacultyId = '".$_REQUEST['cFacultyIdold']."' AND ";
					}

					if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '')
					{
						$where_crit .= "a.iStudy_level = '".$_REQUEST['courseLevel']."' AND ";
					}

					if (isset($_REQUEST['date_1']) && $_REQUEST['date_1'] <> '')
					{
						$where_crit .= "(h.tdate >= '".$_REQUEST['date_1']."' AND h.tdate <= '".$_REQUEST['date_2']."') AND ";
					}

					$where_crit = substr($where_crit,0,strlen($where_crit)-4);

					//echo $wrking_tab;

					$sql = "SELECT DISTINCT vApplicationNo, UCASE(a.vMatricNo),
					UCASE(vFirstName) firstname, 
					vLastName lastname, 
					cGender gender,
					dBirthDate, 
					cHomeStateId, 
					iStudy_level 'level', 
					'JAMB No',
					concat(REPLACE(d.vObtQualTitle, '.', ''),' ', b.vProgrammeDesc) 'degree type',
					f.vdeptDesc department,
					e.vFacultyDesc faculty,
					((b.iEndLevel - b.iBeginLevel)+100)/100
					FROM s_m_t a, programme b, obtainablequal d, faculty e, depts f, $wrking_tab h
					WHERE a.cProgrammeId = b.cProgrammeId
					AND a.cObtQualId = d.cObtQualId
					AND a.cFacultyId = e.cFacultyId
					AND a.cdeptId = f.cdeptId
					AND a.vMatricNo = h.vMatricNo
					AND b.cEduCtgId = 'PSZ'
					AND (h.fee_item_id IN ('1','4','13','17','19','21','28') OR h.fee_item_id IN ('F003','F004','F006','F008','F007','F017'))
					AND $where_crit";

					//echo $sql;

					$stmt = $mysqli->prepare($sql);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($afn, 
					$vMatricNo, 
					$vFirstName, 
					$vLastName,
					$gender,
					$dob,
					$cHomeStateId,
					$level,
					$jambno,
					$vProgrammeDesc, 
					$depts,
					$faculty,  
					$duration);
				}else if($_REQUEST['whattodo'] == '12a')//siwes
				{
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
					}

					$where_crit = "";
										
					if (isset($_REQUEST['cFacultyIdold']) && $_REQUEST['cFacultyIdold'] <> '')
					{
						$where_crit .= "b.cFacultyId = '".$_REQUEST['cFacultyIdold']."' AND ";
					}

					if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '')
					{
						$where_crit .= "b.iStudy_level = '".$_REQUEST['courseLevel']."' AND ";
					}

					if (isset($_REQUEST['prog_cat_loc']) && $_REQUEST['prog_cat_loc'] <> '')
					{
						$where_crit .= "c.cEduCtgId = '".$_REQUEST['prog_cat_loc']."' AND ";
					}

					$where_crit = substr($where_crit,0,strlen($where_crit)-4);

					$sql = "SELECT d.cStudyCenterId, 
					d.vCityName, 
					b.cFacultyId, 
					b.cProgrammeId, 
					REPLACE(e.vObtQualTitle, '.', ''), 
					c.vProgrammeDesc,
					UCASE(a.vMatricNo), 
					vLastName, 
					vFirstName, 
					vOtherName, 
					b.tSemester, 
					a.cCourseId, 
					a.vCourseDesc, 
					a.iCreditUnit, 
					b.vEMailId, 
					b.vMobileNo 
					FROM $wrking_crsreg_tab a, s_m_t b, programme c, studycenter d, obtainablequal e
					where a.vMatricNo = b.vMatricNo
					AND b.cStudyCenterId = d.cStudyCenterId
					AND b.cProgrammeId = c.cProgrammeId
					AND c.cObtQualId = e.cObtQualId
					AND LEFT(a.tdate,10) >= '$semester_begin_date'
					AND lcase(a.ancilary_type) = 'siwes'
					AND $where_crit"; //echo $sql;

					$stmt = $mysqli->prepare($sql);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($cStudyCenterId, 
					$vCityName, 
					$cFacultyId, 
					$cProgrammeId, 
					$vObtQualTitle, 
					$vProgrammeDesc,
					$vMatricNo, 
					$vLastName, 
					$vFirstName, 
					$vOtherName, 
					$tSemester, 
					$cCourseId, 
					$vCourseDesc, 
					$iCreditUnit, 
					$vEMailId, 
					$vMobileNo);
				}else if($_REQUEST['whattodo'] == 13)//wallet funding
				{
					if (isset($_REQUEST['date_1']) && $_REQUEST['date_1'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo 'From '.formatdate($_REQUEST['date_1'],'fromdb').' to '.formatdate($_REQUEST['date_2'],'fromdb');?></label>
						</div><?php
					}
					
					if (isset($_REQUEST['prog_cat_loc']) && $_REQUEST['prog_cat_loc'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo $_REQUEST['prog_cat_disc'];?></label>
						</div><?php
					}

					$where_crit = "";

					if (isset($_REQUEST['date_1']) && $_REQUEST['date_1'] <> '')
					{
						$where_crit .= "(TransactionDate >= '".$_REQUEST['date_1']."' AND TransactionDate <= '".$_REQUEST['date_2']."') AND ";
					}

					if (isset($_REQUEST['prog_cat_loc']) && $_REQUEST['prog_cat_loc'] <> '')
					{
						$where_crit .= "cEduCtgId = '".$_REQUEST['prog_cat_loc']."' AND ";
					}

					$where_crit = substr($where_crit,0,strlen($where_crit)-4);

					$sql = "SELECT Regno,RetrievalReferenceNumber,payerName,vDesc,TransactionDate,Amount 
					FROM remitapayments where ResponseCode IN ('01','00')
					AND TransactionDate >= '$semester_begin_date'
					AND $where_crit";

					$stmt = $mysqli->prepare($sql);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($matno,
					$rrr, 
					$payerName, 
					$vDesc, 
					$TransactionDate, 
					$Amount);
				}else if($_REQUEST['whattodo'] == 14)
				{
					if (isset($_REQUEST['date_1']) && $_REQUEST['date_1'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo 'From '.formatdate($_REQUEST['date_1'],'fromdb').' to '.formatdate($_REQUEST['date_2'],'fromdb');?></label>
						</div><?php
					}
					
					if (isset($_REQUEST['prog_cat_loc']) && $_REQUEST['prog_cat_loc'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo $_REQUEST['prog_cat_disc'];?></label>
						</div><?php
					}
					
					if (!isset($_REQUEST['debit_smry1']) && !isset($_REQUEST['debit_smry2']) && isset($_REQUEST['debitype_disc']) && $_REQUEST['debitype_disc'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo $_REQUEST['debitype_disc'];?></label>
						</div><?php
					}

					
					$where_crit = "";

					if (!isset($_REQUEST['debit_smry1']) && !isset($_REQUEST['debit_smry2']) && isset($_REQUEST['debitype']) && $_REQUEST['debitype'] <> '')
					{
						if (is_numeric($_REQUEST['debitype']))
						{
							$where_crit .= "fee_item_id = ".$_REQUEST['debitype']." AND ";
						}else
						{
							$where_crit .= "vremark = '".$_REQUEST['debitype']."' AND ";
						}
					}

					if (isset($_REQUEST['date_1']) && $_REQUEST['date_1'] <> '')
					{
						$where_crit .= "(LEFT(tdate,10) >= '".$_REQUEST['date_1']."' AND LEFT(tdate,10) <= '".$_REQUEST['date_2']."') AND ";
					}

					if (isset($_REQUEST['prog_cat_loc']))
					{
						if ($_REQUEST['prog_cat_loc'] == 'PSZ')
						{
							$where_crit .= "b.cProgrammeId LIKE '___2%' AND ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PGX')
						{
							$where_crit .= "b.cProgrammeId LIKE '___3%' AND ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PGY')
						{
							$where_crit .= "b.cProgrammeId LIKE '___4%' AND ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PGZ')
						{
							$where_crit .= "b.cProgrammeId LIKE '___5%' AND ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PRX')
						{
							$where_crit .= "b.cProgrammeId LIKE '___6%' AND ";
						}
					}

					$where_crit = substr($where_crit,0,strlen($where_crit)-4);

					if (isset($_REQUEST['debit_smry1']))
					{
						$sql = "SELECT c.fee_item_desc, SUM(amount) FROM $wrking_tab a, s_m_t b, fee_items c
						WHERE a.vMatricNo = b.vMatricNo
						AND a.fee_item_id = c.fee_item_id
						AND LEFT(tdate,10) >= '$semester_begin_date'
						AND $where_crit
						GROUP BY c.fee_item_desc";

						//echo $sql;

						$stmt = $mysqli->prepare($sql);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($item, $Amount);
					}else if (isset($_REQUEST['debit_smry2']))
					{
						$sql = "SELECT c.fee_item_desc, COUNT(amount) FROM $wrking_tab a, s_m_t b, fee_items c
						WHERE a.vMatricNo = b.vMatricNo
						AND a.fee_item_id = c.fee_item_id
						AND LEFT(tdate,10) >= '$semester_begin_date'
						AND $where_crit
						GROUP BY c.fee_item_desc";

						//echo $sql;

						$stmt = $mysqli->prepare($sql);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($item, $Amount);
					}else
					{
						$sql = "SELECT UCASE(a.vMatricNo), 
						CONCAT(vLastName,' ',vFirstName,' ',vOtherName) names,
						vremark,
						tdate,
						amount 
						FROM $wrking_tab a, s_m_t b 
						WHERE a.vMatricNo = b.vMatricNo
						AND LEFT(tdate,10) >= '$semester_begin_date'
						AND $where_crit";

						$stmt = $mysqli->prepare($sql);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($matno, 
						$payerName, 
						$vDesc, 
						$TransactionDate, 
						$Amount);
					}
				}else if($_REQUEST['whattodo'] == 15)//gown refund
				{
					if (isset($_REQUEST['staff_study_center']) && $_REQUEST['staff_study_center'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo $_REQUEST['centre_disc'];?></label>
						</div><?php
					}

					if (isset($_REQUEST['date_1']) && $_REQUEST['date_1'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo 'From '.formatdate($_REQUEST['date_1'],'fromdb').' to '.formatdate($_REQUEST['date_2'],'fromdb');?></label>
						</div><?php
					}
					
					if (isset($_REQUEST['cFacultyIdold']) && $_REQUEST['cFacultyIdold'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo $_REQUEST['faculty_disc'];?></label>
						</div><?php
					}

					if (isset($_REQUEST['prog_cat_loc']) && $_REQUEST['prog_cat_loc'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo $_REQUEST['prog_cat_disc'];?></label>
						</div><?php
					}

					if (isset($_REQUEST['bank_loc']) && $_REQUEST['bank_loc'] <> '')
					{?>					
						<div class="innercont_stff" style="width:80%; margin-top:0px;">
							<label class="labell_structure" style="width:auto"><?php echo $_REQUEST['bank_disc'];?></label>
						</div><?php
					}

					$where_crit = "";
										
					if (isset($_REQUEST['staff_study_center']) && $_REQUEST['staff_study_center'] <> '')
					{
						$where_crit .= "b.cStudyCenterId = '".$_REQUEST['staff_study_center']."' AND ";
					}
					
					if (isset($_REQUEST['date_1']) && $_REQUEST['date_1'] <> '')
					{
						$where_crit .= "(LEFT(pay_date,10) >= '".$_REQUEST['date_1']."' AND LEFT(pay_date,10) <= '".$_REQUEST['date_2']."') AND ";
					}
										
					if (isset($_REQUEST['cFacultyIdold']) && $_REQUEST['cFacultyIdold'] <> '')
					{
						$where_crit .= "b.cFacultyId = '".$_REQUEST['cFacultyIdold']."' AND ";
					}

					if (isset($_REQUEST['prog_cat_loc']))
					{
						if ($_REQUEST['prog_cat_loc'] == 'PSZ')
						{
							$where_crit .= "b.cProgrammeId LIKE '___2%' AND ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PGX')
						{
							$where_crit .= "b.cProgrammeId LIKE '___3%' AND ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PGY')
						{
							$where_crit .= "b.cProgrammeId LIKE '___4%' AND ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PGZ')
						{
							$where_crit .= "b.cProgrammeId LIKE '___5%' AND ";
						}else if ($_REQUEST['prog_cat_loc'] == 'PRX')
						{
							$where_crit .= "b.cProgrammeId LIKE '___6%' AND ";
						}
					}
					
										
					if (isset($_REQUEST['bank_loc']) && $_REQUEST['bank_loc'] <> '')
					{
						$where_crit .= "a.bank_id = '".$_REQUEST['bank_loc']."' AND ";
					}

					if ($where_crit <> '')
					{
						$where_crit = " AND " . substr($where_crit,0,strlen($where_crit)-4);
					}

					$sql = "SELECT a.vMatricNo, account_name, c.vDesc, annount_no, d.vCityName, amount, pay_date, rrr 
					FROM g_refund a, s_m_t b, banks c, studycenter d 
					WHERE a.vMatricNo = b.vMatricNo
					AND a.bank_id = c.ccode
					AND b.cStudyCenterId = d.cStudyCenterId
					AND LEFT(pay_date,10) >= '$semester_begin_date'
					$where_crit";

					$stmt = $mysqli->prepare($sql);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($matno, 
					$account_name, 
					$bank_name, 
					$account_number,
					$studycentre, 
					$Amount,
					$tdate,
					$rrr);
				}else if($_REQUEST['whattodo'] == 16)//CHD
				{
					if ($_REQUEST["show_chd_opt_h"] == '1')
					{
						$stmt = $mysqli->prepare("SELECT b.vCityName, 
						c.vProgrammeDesc, 
						vApplicationNo,
						vLastName,
						vFirstName,
						vOtherName,
						vEMailId,
						vMobileNo,
						cSbmtd,
						trans_time 
						FROM prog_choice a, studycenter b, programme c
						where a.cStudyCenterId = b.cStudyCenterId 
						and a.cProgrammeId = c.cProgrammeId
						and c.cProgrammeId in ('CHD001','CHD007');");
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($vCityName, 
						$vProgrammeDesc, 
						$vApplicationNo, 
						$vLastName, 
						$vFirstName, 
						$vOtherName, 
						$vEMailId,
						$vMobileNo,
						$cSbmtd,
						$tdate);
					}else if ($_REQUEST["show_chd_opt_h"] == '2')
					{
						$stmt = $mysqli->prepare("SELECT b.vCityName, 
						c.vProgrammeDesc, 
						UCASE(vMatricNo),
						vLastName,
						vFirstName,
						vOtherName,
						vEMailId,
						vMobileNo,
						semester_reg,
						act_time 
						FROM s_m_t a, studycenter b, programme c
						where a.cStudyCenterId = b.cStudyCenterId 
						and a.cProgrammeId = c.cProgrammeId
						and c.cProgrammeId in ('CHD001','CHD007');");
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($vCityName, 
						$vProgrammeDesc, 
						$vApplicationNo, 
						$vLastName, 
						$vFirstName, 
						$vOtherName, 
						$vEMailId,
						$vMobileNo,
						$semester_reg,
						$tdate);
					}
				}else if($_REQUEST['whattodo'] == 17)//LAW
				{
					$stmt = $mysqli->prepare("SELECT b.vCityName, 
					c.vProgrammeDesc, 
					vApplicationNo, 
					vLastName, 
					vFirstName, 
					vOtherName, 
					vEMailId, 
					vMobileNo,
					trans_time 
					FROM prog_choice a, studycenter b, programme c 
					where a.cStudyCenterId = b.cStudyCenterId 
					and a.cProgrammeId = c.cProgrammeId 
					and c.cProgrammeId in ('LAW301','LAW401') 
					and cSbmtd <> '2'");
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($vCityName, 
					$vProgrammeDesc, 
					$vApplicationNo, 
					$vLastName, 
					$vFirstName, 
					$vOtherName, 
					$vEMailId,
					$vMobileNo,
					$tdate);
				}
			}else
			{
				echo '';
			}

			$background_color='#FFFFFF';
			
			if(isset($_REQUEST['whattodo']))
			{
				if ($_REQUEST['whattodo'] == 1)//Exam registration count
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								columns: [
									{ data: 'sno'},
									{ data: 'coursecode'},
									{ data: 'title'},
									{ data: 'count'},
								],
								dom: 'Bfrtip',
								
								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'Exam Registration 2024_2',
										exportOptions: { columns: [ 0, 1, 2, 3 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'Exam Registration 2024_2',
										exportOptions: { columns: [ 0, 1, 2, 3 ] },
										messageTop: 'Course registration count',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:50%;">
						<thead>
							<tr>
								<th style="padding-right:2%; text-align:right; width:10%;">Sno</th>
								<th style="width:20%;">Course code</th>
								<th style="width:60%;">Course title</th>
								<th style="padding-right:2%; text-align:right; width:10%;">Count</th>
							</tr>
						</thead>
						<tbody><?php
						$sno = 0;
						$tottal_count = 0;
						while($stmt->fetch())
						{
							if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
							<tr style="background-color:<?php echo $background_color;?>;">
								<td><?php echo ++$sno;?></td>
								<td><?php echo $coursesid;?></td>
								<td><?php echo $coursesdesc;?></td>
								<td style="text-align:right;"><?php echo $counts;?></td>
							</tr><?php
							
							$tottal_count += $counts;
						}?>
						</tbody>
						<tfoot>
							<tr style="background-color:<?php echo $background_color;?>;">
								<td></td>
								<td></td>
								<td style="text-align:right;">Total sittings</td>
								<td style="text-align:right;"><?php echo number_format($tottal_count);?></td>
							</tr>
						</tfoot>
					</table><?php
					log_actv('generated report on exam registration counts');
				}else if ($_REQUEST['whattodo'] == 2)//student count
				{
					$column_count = count($arr1);

					if ($column_count == 1)
					{?>
						<script type="text/javascript">
							$(document).ready(function ()
							{							
								$('#gridz').dataTable({
										deferRender: true,
										fixedHeader: {
										header: true,
										footer: true,
									},
									
									columns: [
										{ data: 'Sno'},
										{ data: 'ReferenceItem1'},
										{ data: 'count'},
									],
									dom: 'Bfrtip',
									
									buttons: 
									[
										{
											extend: 'excelHtml5',
											title: 'Students count',
											exportOptions: { columns: [ 0, 1, 2 ] },
										},
										{
											extend: 'pdfHtml5',
											title: 'Students count',
											exportOptions: { columns: [ 0, 1, 2 ] },
											messageTop: 'Students count',
											messageBottom: 'Powered by MIS',
											title: 'National Open University of Nigeria:',
											margin: [ 2, 2, 2, 2],
											pageSize: 'A4',
											orientation: 'portrate',
										},
										'print'
									]
								} );
							});
						</script><?php
					}
										
					if ($column_count == 2)
					{?>
						<script type="text/javascript">
							$(document).ready(function ()
							{							
								$('#gridz').dataTable({
										deferRender: true,
										fixedHeader: {
										header: true,
										footer: true,
									},
									
									columns: [
										{ data: 'Sno'},
										{ data: 'ReferenceItem1'},
										{ data: 'ReferenceItem2'},
										{ data: 'count'},
									],
									dom: 'Bfrtip',
									
									buttons: 
									[
										{
											extend: 'excelHtml5',
											title: 'Students count',
											exportOptions: { columns: [ 0, 1, 2, 3 ] },
										},
										{
											extend: 'pdfHtml5',
											title: 'Students count',
											exportOptions: { columns: [ 0, 1, 2, 3 ] },
											messageTop: 'Students Records',
											messageBottom: 'Powered by MIS',
											title: 'National Open University of Nigeria:',
											margin: [ 2, 2, 2, 2],
											pageSize: 'A4',
											orientation: 'portrate',
										},
										'print'
									]
								} );
							});
						</script><?php
					}
										
					if ($column_count == 3)
					{?>
						<script type="text/javascript">
							$(document).ready(function ()
							{							
								$('#gridz').dataTable({
										deferRender: true,
										fixedHeader: {
										header: true,
										footer: true,
									},
									
									columns: [
										{ data: 'Sno'},
										{ data: 'ReferenceItem1'},
										{ data: 'ReferenceItem2'},
										{ data: 'ReferenceItem3'},
										{ data: 'count'},
									],
									dom: 'Bfrtip',
									
									buttons: 
									[
										{
											extend: 'excelHtml5',
											title: 'Students count',
											exportOptions: { columns: [ 0, 1, 2, 3, 4 ] },
										},
										{
											extend: 'pdfHtml5',
											title: 'Students count',
											exportOptions: { columns: [ 0, 1, 2, 3, 4 ] },
											messageTop: 'Students Records',
											messageBottom: 'Powered by MIS',
											title: 'National Open University of Nigeria:',
											margin: [ 2, 2, 2, 2],
											pageSize: 'A4',
											orientation: 'portrate',
										},
										'print'
									]
								} );
							});
						</script><?php
					}
										
					if ($column_count == 4)
					{?>
						<script type="text/javascript">
							$(document).ready(function ()
							{							
								$('#gridz').dataTable({
										deferRender: true,
										fixedHeader: {
										header: true,
										footer: true,
									},
									
									columns: [
										{ data: 'Sno'},
										{ data: 'ReferenceItem1'},
										{ data: 'ReferenceItem2'},
										{ data: 'ReferenceItem3'},
										{ data: 'ReferenceItem4'},
										{ data: 'count'},
									],
									dom: 'Bfrtip',
									
									buttons: 
									[
										{
											extend: 'excelHtml5',
											title: 'Students count',
											exportOptions: { columns: [ 0, 1, 2, 3, 4, 5 ] },
										},
										{
											extend: 'pdfHtml5',
											title: 'Students count',
											exportOptions: { columns: [ 0, 1, 2, 3, 4, 5 ] },
											messageTop: 'Students Records',
											messageBottom: 'Powered by MIS',
											title: 'National Open University of Nigeria:',
											margin: [ 2, 2, 2, 2],
											pageSize: 'A4',
											orientation: 'portrate',
										},
										'print'
									]
								} );
							});
						</script><?php
					}
										
					if ($column_count == 5)
					{?>
						<script type="text/javascript">
							$(document).ready(function ()
							{							
								$('#gridz').dataTable({
										deferRender: true,
										fixedHeader: {
										header: true,
										footer: true,
									},
									
									columns: [
										{ data: 'Sno'},
										{ data: 'ReferenceItem1'},
										{ data: 'ReferenceItem2'},
										{ data: 'ReferenceItem3'},
										{ data: 'ReferenceItem4'},
										{ data: 'ReferenceItem5'},
										{ data: 'count'},
									],
									dom: 'Bfrtip',
									
									buttons: 
									[
										{
											extend: 'excelHtml5',
											title: 'Students count',
											exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6 ] },
										},
										{
											extend: 'pdfHtml5',
											title: 'Students count',
											exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6 ] },
											messageTop: 'Students Records',
											messageBottom: 'Powered by MIS',
											title: 'National Open University of Nigeria:',
											margin: [ 2, 2, 2, 2],
											pageSize: 'A4',
											orientation: 'portrate',
										},
										'print'
									]
								} );
							});
						</script><?php
					}
										
					if ($column_count == 6)
					{?>
						<script type="text/javascript">
							$(document).ready(function ()
							{							
								$('#gridz').dataTable({
										deferRender: true,
										fixedHeader: {
										header: true,
										footer: true,
									},
									
									columns: [
										{ data: 'Sno'},
										{ data: 'ReferenceItem1'},
										{ data: 'ReferenceItem2'},
										{ data: 'ReferenceItem3'},
										{ data: 'ReferenceItem4'},
										{ data: 'ReferenceItem5'},
										{ data: 'ReferenceItem6'},
										{ data: 'count'},
									],
									dom: 'Bfrtip',
									
									buttons: 
									[
										{
											extend: 'excelHtml5',
											title: 'Students count',
											exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ] },
										},
										{
											extend: 'pdfHtml5',
											title: 'Students count',
											exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ] },
											messageTop: 'Students Records',
											messageBottom: 'Powered by MIS',
											title: 'National Open University of Nigeria:',
											margin: [ 2, 2, 2, 2],
											pageSize: 'A4',
											orientation: 'portrate',
										},
										'print'
									]
								} );
							});
						</script><?php
					}?>					
						
					<table id="gridz" class="table table-condensed table-responsive" style="width:70%;">
						<thead>
							<tr>
								<th style="padding-right:1.5%; text-align:right;">Sno</th><?php
								$cnt = 0;
								while ($fieldinfo = $result -> fetch_field())
								{
									$cnt++;
									if (($column_count+1) == $cnt)
									{?>
										<th style="padding-right:1.5%; text-align:right"><?php echo $fieldinfo -> name;?></th><?php
									}else
									{?>
										<th style="text-indent:0.5%;"><?php echo $fieldinfo -> name;?></th><?php
									}
								}?>
							</tr>
						</thead>
						<tbody><?php
							$sno = 0;
							$tottal_count = 0;
							while ($row = $result -> fetch_array(MYSQLI_NUM))
							{
								if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
								<tr style="background-color:<?php echo $background_color;?>;">
									<td style="text-indent:0.5%; text-align:right;"><?php echo ++$sno;?></td><?php
									for ($x = 0; $x <= count($row)-1; $x++)
									{
										if ($x == count($row)-1)
										{?>
											<td style="padding-right:1.5%; text-align:right"><?php echo $row[$x];?></td><?php
											$tottal_count += $row[$x];
										}else
										{?>
											<td style="text-indent:0.5%;"><?php echo $row[$x];?></td><?php
										}
									}?>
								</tr><?php							
							}?>
						</tbody>
						<tfoot>
							<tr style="background-color:<?php if (isset($background_color)){echo $background_color;}else{echo '#FFFFFF';}?>;"><?php
								for ($x = 0; $x <= $cnt-2; $x++)
								{?>
									<td></td><?php
								}?>
								<td style="text-align:right;">Total</td>
								<td style="text-align:right;"><?php echo number_format($tottal_count);?></td>
							</tr>
						</tfoot>
					</table><?php
					log_actv('generated report on student counts');
				}else if ($_REQUEST['whattodo'] == 3)//list faculties
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								columns: [
									{ data: 'sno'},
									{ data: 'faculty'},
								],
								dom: 'Bfrtip',
								
								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'List of Faculties',
										exportOptions: { columns: [ 0, 1 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'List of Faculties',
										exportOptions: { columns: [ 0, 1 ] },
										messageTop: 'List of Faculties',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:45%;">
						<thead>
							<tr>
								<th style="text-indent:2%; width:8%;">Sno</th>
								<th style="width:90%;">Faculty name</th>
							</tr>
						</thead><?php

						$sno = 0;
						while($stmt->fetch())
						{
							if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>

							<tr style="background-color:<?php echo $background_color;?>;">
								<td><?php echo ++$sno;?></td>
								<td><?php echo $vFacultyDesc;?></td>
							</tr><?php 
						}?>
					</table><?php
					log_actv('generated list of faculties');
				}else if ($_REQUEST['whattodo'] == 4)//list dept
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								columns: [
									{ data: 'sno'},
									{ data: 'faculty'},
									{ data: 'dept'},
								],
								dom: 'Bfrtip',
								
								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'List of Faculties and departments',
										exportOptions: { columns: [ 0, 1, 2 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'List of Faculties and departments',
										exportOptions: { columns: [ 0, 1, 2 ] },
										messageTop: 'List of Faculties and departments',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:65%;">
						<thead>
							<tr>
								<th style="text-indent:2%; width:8%;">Sno</th>
								<th style="width:45%;">Faculty</th>
								<th style="width:45%;">Department</th>
							</tr>
						</thead><?php

						$sno = 0;
						while($stmt->fetch())
						{
							if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
							<tr style="background-color:<?php echo $background_color;?>;">
								<td><?php echo ++$sno;?></td>
								<td><?php echo $vFacultyDesc;?></td>
								<td><?php echo $vdeptDesc;?></td>
							</tr><?php 
						}?>
					</table><?php
					log_actv('generated list of departments');
				}else if ($_REQUEST['whattodo'] == 5)//list programmes
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								columns: [
									{ data: 'sno'},
									{ data: 'faculty'},
									{ data: 'dept'},
									{ data: 'prog'},
								],
								dom: 'Bfrtip',
								
								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'List of Faculties, departments and programmes',
										exportOptions: { columns: [ 0, 1, 2, 3 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'List of Faculties, departments and programmes',
										exportOptions: { columns: [ 0, 1, 2, 3 ] },
										messageTop: 'List of Faculties, departments and programmes',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:64%;">
						<thead>
							<tr>
								<th style="padding-right:1.5%; text-align:right; width:5%;">Sno</th>
								<th style="width:31%;">Faculty</th>
								<th style="width:31%;">Department</th>
								<th style="width:31.6%;">Programme</th>
							</tr>
						</thead><?php

						$sno = 0;
						while($stmt->fetch())
						{
							if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
							<tr style="background-color:<?php echo $background_color;?>;">
								<td style="text-align:right;"><?php echo ++$sno;?></td>
								<td><?php echo $vFacultyDesc;?></td>
								<td><?php echo $vdeptDesc;?></td>
								<td><?php echo $program;?></td>
							</tr><?php 
						}?>
					</table><?php
					log_actv('generated list of programmes');
				}else if ($_REQUEST['whattodo'] == 6)//list courses
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								columns: [
									{ data: 'sno'},
									{ data: 'level'},
									{ data: 'semester'},
									{ data: 'crunit'},
									{ data: 'mandate'},
									{ data: 'anciliary'},
									{ data: 'courseid'},
									{ data: 'coursetitle'},
								],
								dom: 'Bfrtip',
								
								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'List of registrable courses',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'List of registrable courses',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ] },
										messageTop: 'List of registrable courses',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:80%;">
						<thead>
							<tr>
								<th style="padding-right:1.5%; text-align:right; width:5%;">Sno</th>
								<th style="width:9.3%;">Level</th>
								<th style="width:7.8%;">Semester</th>
								<th style="width:6.8%;">Credit unit</th>
								<th style="width:7.8%;">Mandate</th>
								<th style="width:15.8%;">Class</th>
								<th style="width:10.8%;">Course code</th>
								<th style="width:35.8%;">Course title</th>
							</tr>
						</thead><?php

						$sno = 0;
						while($stmt->fetch())
						{
							if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
							<tr style="background-color:<?php echo $background_color;?>;">
								<td style="padding-right:1.5%; text-align:right;"><?php echo ++$sno;?></td>
								<td><?php echo $level;?></td>
								<td><?php echo $semester;?></td>
								<td><?php echo $crunit;?></td>
								<td><?php echo $cCategory;?></td>
								<td><?php echo ucwords(strtolower($class));?></td>
								<td><?php echo $coursecode;?></td>
								<td><?php echo $coursetitle;?></td>
							</tr><?php 
						}?>
					</table><?php
					log_actv('generated list of courses');
				}else if ($_REQUEST['whattodo'] == 7)//list centres
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								columns: [
									{ data: 'sno'},
									{ data: 'zone'},
									{ data: 'state'},
									{ data: 'centre'},
								],
								dom: 'Bfrtip',
								
								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'List of Study Centres',
										exportOptions: { columns: [ 0, 1, 2, 3 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'List of Study Centres',
										exportOptions: { columns: [ 0, 1, 2, 3 ] },
										messageTop: 'List of Study Centres',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:64%;">
						<thead>
							<tr>
								<th style="padding-right:1.5%; text-align:right; width:3.5%;">Sno</th>
								<th style="width:25%;">Geo-Political Zone</th>
								<th style="width:25%;">State</th>
								<th style="width:45%;">Centre name</th>
							</tr>
						</thead><?php

						$sno = 0;
						while($stmt->fetch())
						{
							if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
							<tr style="background-color:<?php echo $background_color;?>;">
								<td style="padding-right:1.5%; text-align:right;"><?php echo ++$sno;?></td>
								<td><?php echo $zone;?></td>
								<td><?php echo $sate;?></td>
								<td><?php echo $centre;?></td>
							</tr><?php 
						}?>
					</table><?php
					log_actv('generated list of Study centres');
				}else if ($_REQUEST['whattodo'] == '7a')//list student
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								/*columns: [
									{ data: 'sno'},
									{ data: 'matno'},
									{ data: 'lname'},
									{ data: 'fname'},
									{ data: 'oname'},
									{ data: 'marr'},
									{ data: 'gender'},
									{ data: 'disab'},
									{ data: 'homecountry'},
									{ data: 'homestate'},
									{ data: 'homelga'},
									{ data: 'resicountry'},
									{ data: 'resistate'},
									{ data: 'resilga'},
									{ data: 'phone'},
								],*/
								
								columns: [
									{ data: 'sno'},
									{ data: 'matno'},
									{ data: 'lname'},
									{ data: 'fname'},
									{ data: 'oname'},
									{ data: 'marr'},
									{ data: 'gender'},
									{ data: 'disab'},
									{ data: 'cStudyCenterId'},
									{ data: 'cFacultyId'},
									{ data: 'cdeptId'},
									{ data: 'cProgrammeId'},
									{ data: 'iStudy_level'},
									{ data: 'phone'},
								],
								dom: 'Bfrtip',
								
								/*buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'Exam Registration',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, , 8, 9, 10, 11, 12, 13, 14 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'Exam Registration',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, , 8, 9, 10, 11, 12, 13, 14 ] },
										messageTop: 'List of Study Centres',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]*/

								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'List of Students',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'List of Students',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13 ] },
										messageTop: 'Student list',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:95%;">
						<thead>
							<tr>
								<th style="padding-right:5%; text-align:right; width:3.5%;">Sno</th>
								<!--<th style="width:6.8%;">MatricNo</th>
								<th style="width:6.8%;">LastName</th>
								<th style="width:10.8%;">FistName</th>
								<th style="width:6.8%;">OtherName</th>
								<th style="width:4.8%;">Marital</th>
								<th style="width:4.8%;">Gender</th>
								<th style="width:4.8%;">Disability</th>
								<th style="width:6.8%;">HomeCountry</th>
								<th style="width:6.8%;">HomeState</th>
								<th style="width:7.8%;">HomeLGA</th>
								<th style="width:7.8%;">ResidentCountry</th>
								<th style="width:6.8%;">ResidentState</th>
								<th style="width:8.8%;">ResidentLGA</th>
								<th style="width:4.8%;">Phone</th>-->
								<th style="width:5.9%;">MatricNo</th>
								<th style="width:6.9%;">LastName</th>
								<th style="width:6.9%;">FistName</th>
								<th style="width:7.9%;">OtherName</th>
								<th style="width:4.9%;">Marital</th>
								<th style="width:4.9%;">Gender</th>
								<th style="width:4.9%;">Disability</th>
								<th style="width:4.9%;">Centre</th>
								<th style="width:7.9%;">Faculty</th>
								<th style="width:12.9%;">Department</th>
								<th style="width:18.9%;">Programme</th>
								<th style="width:3.9%;">Level</th>
								<th style="width:4%;">Phone</th>
							</tr>
						</thead><?php

						$sno = 0;
						while($stmt->fetch())
						{
							if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}

							/*$key = array_search($cDisabilityId, array_column($disability_arr, 'cDisabilityId'));
							if (!is_bool($key)){$cDisabilityId = $disability_arr[$key]['vDisabilityDesc'];}
							
							$key = array_search($cHomeCountryId, array_column($country_arr, 'cCountryId'));
							if (!is_bool($key)){$cHomeCountryId = $country_arr[$key]['vCountryName'];}
							
							$key = array_search($cHomeStateId, array_column($state_arr, 'cStateId'));
							if (!is_bool($key)){$cHomeStateId = $state_arr[$key]['vStateName'];}
							
							$key = array_search($cHomeLGAId, array_column($localarea_arr, 'cLGAId'));
							if (!is_bool($key)){$cHomeLGAId = $localarea_arr[$key]['vLGADesc'];}
							
							$key = array_search($cResidenceCountryId, array_column($country_arr, 'cCountryId'));
							if (!is_bool($key)){$cResidenceCountryId = $country_arr[$key]['vCountryName'];}
							
							$key = array_search($cResidenceStateId, array_column($state_arr, 'cStateId'));
							if (!is_bool($key)){$cResidenceStateId = $state_arr[$key]['vStateName'];}
							
							$key = array_search($cResidenceLGAId, array_column($localarea_arr, 'cLGAId'));
							if (!is_bool($key)){$cResidenceLGAId = $localarea_arr[$key]['vLGADesc'];}*/
							
							$key = array_search($cFacultyId, array_column($faculty_arr, 'cFacultyId'));
							if (!is_bool($key)){$cFacultyId = $faculty_arr[$key]['vFacultyDesc'];}
							
							$key = array_search($cdeptId, array_column($dept_arr, 'cdeptId'));
							if (!is_bool($key)){$cdeptId = $dept_arr[$key]['vdeptDesc'];}
							
							$key = array_search($cProgrammeId, array_column($prog_arr, 'cProgrammeId'));
							if (!is_bool($key)){$cProgrammeId = $prog_arr[$key]['vProgrammeDesc'];}?>

							<tr style="background-color:<?php echo $background_color;?>;">
								<td style="padding-right:5%; text-align:right; width:3.5%;"><?php echo ++$sno; ?></td>
								<td style="text-align:left;"><?php echo $vMatricNo; ?></td>
								<td style="text-align:left;"><?php echo $vLastName; ?></td>
								<td style="text-align:left;"><?php echo $vFirstName; ?></td>
								<td style="text-align:left;"><?php echo $vOtherName; ?></td>
								<td style="text-align:left;"><?php echo $cMaritalStatusId; ?></td>
								<td style="text-align:left;"><?php echo $cGender; ?></td>
								<td style="text-align:left;"><?php echo $cDisabilityId; ?></td>
								<td style="text-align:left;"><?php echo $cStudyCenterId; ?></td>
								<td style="text-align:left;"><?php echo $cFacultyId; ?></td>
								<td style="text-align:left;"><?php echo $cdeptId; ?></td>
								<td style="text-align:left;"><?php if (!is_null($cProgrammeId))
								{
									echo str_replace(",","",$cProgrammeId);
								}?></td>
								<td style="text-align:left;"><?php echo $iStudy_level; ?></td>
								<td style="text-align:left;"><?php echo $vMobileNo; ?></td>
							</tr><?php 
						}?>
					</table><?php
					log_actv('generated student list');
				}else if ($_REQUEST['whattodo'] == 8)//DEA request
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								columns: [
									{ data: 'matricnocc'},
									{ data: 'datprogrammeid'},
									{ data: 'programme'},
									{ data: 'matricno'},
									{ data: 'name'},
									{ data: 'semester'},
									{ data: 'field1'},
									{ data: 'coursecode'},
									{ data: 'coursetitle'},
									{ data: 'creditunit'},
									{ data: 'level'},
									{ data: 'studycentreid'},
									{ data: 'facultyid'},
									{ data: 'facultydesc'},
									{ data: 'studycentre'},
									{ data: 'email'},
									{ data: 'mobile'},
									{ data: 'personalemail'},
									{ data: 'field2'},
									{ data: 'date'},
								],
								dom: 'Bfrtip',
								
								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'Exam Registration 2024_2',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'Exam Registration 2024_2',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19 ] },
										messageTop: 'Students Records',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:100%;">
						<thead>
							<tr>
								<th style="text-indent:0.5%; width:8%;">MTN_CourseCode</th>
								<th style="text-indent:0.5%; width:15%;">ProgID</th>
								<th style="text-indent:0.5%;width:30%;">Programme</th>
								<th style="text-indent:0.5%; width:13%;">MatricNo</th>
								<th style="text-indent:0.5%; width:13%;">Name</th>
								<th style="text-indent:0.5%; width:13%;">Session</th>
								<th style="text-indent:0.5%; width:13%;">Field1</th>
								<th style="text-indent:0.5%; width:13%;">CourseID</th>
								<th style="text-indent:0.5%; width:13%;">CourseTitle</th>
								<th style="text-align:right; width:13%; padding-right:2%">Cr.Unit</th>
								<th style="text-indent:0.5%; width:13%;">Level</th>
								<th style="text-indent:0.5%; width:13%;">CentreID</th>
								<th style="text-indent:0.5%; width:13%;">FacultyID</th>
								<th style="text-indent:0.5%; width:13%;">FacultyDesc</th>
								<th style="text-indent:0.5%; width:13%;">Centre</th>
								<th style="text-indent:0.5%; width:13%;">eMail</th>
								<th style="text-indent:0.5%; width:13%;">Phone</th>
								<th style="text-indent:0.5%; width:13%;">PersonalPhone</th>
								<th style="text-indent:0.5%; width:13%;">Field2</th>
								<th style="text-indent:0.5%; width:13%;">Date</th>
							</tr>
						</thead><?php
						$sno = 0;
						while($stmt->fetch())
						{
							$sno++;
							if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
							<tr style="background-color:<?php echo $background_color;?>;">
								<td><?php echo $matcrs;?></td>
								<td><?php echo $programmeID;?></td>
								<td><?php echo $programme;?></td>
								<td><?php echo $matno;?></td>
								<td><?php echo $name;?></td>
								<td><?php echo $sesion;?></td>
								<td><?php echo $Field1;?></td>
								<td><?php echo $courseID;?></td>
								<td><?php echo $coursetitle;?></td>
								<td><?php echo $creditunit;?></td>
								<td><?php echo $level;?></td>
								<td><?php echo $centreid;?></td>
								<td><?php echo $facultyid;?></td>
								<td><?php echo $facultydesc;?></td>
								<td><?php echo $centre;?></td>
								<td><?php echo $email;?></td>
								<td><?php echo $phone;?></td>
								<td><?php echo $email2;?></td>
								<td><?php echo $field2;?></td>
								<td><?php echo $tdate;?></td>
							</tr><?php 
						}?>
					</table><?php
				}else if ($_REQUEST['whattodo'] == '8a')//Exam registrations
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								columns: [
									{ data: 'sno'},
									{ data: 'matno'},
									{ data: 'names'},
									{ data: 'cCourseId'},
									{ data: 'vCourseDesc'},
									{ data: 'iCreditUnit'},
									{ data: 'tdate'},
									{ data: 'iStudy_level'},
									{ data: 'vCityName'},
									{ data: 'cStudyCenterId'},
									{ data: 'cProgrammeId'},
								],
								dom: 'Bfrtip',
								
								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'Exam Registration 2024_2s',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'Exam Registration 2024_2s',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ] },
										messageTop: 'Students Records',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:90%;">
						<thead>
							<tr>
								<th style="padding-right:1%; text-align:right; width:5%;">Sno</th>
								<th style="text-indent:0.5%; width:9.5%;">MatNo</th>
								<th style="text-indent:0.5%; width:11.5%;">Name</th>
								<th style="text-indent:0.5%; width:7.5%;">CourseID</th>
								<th style="text-indent:0.5%; width:17.5%;">CourseTitle</th>
								<th style="text-indent:0.5%; width:4.5%;">CrUnit</th>
								<th style="text-indent:0.5%; width:10.5%;">Date</th>
								<th style="text-indent:0.5%; width:6.5%;">Level</th>
								<th style="text-indent:0.5%; width:14.5%;">CemtreName</th>
								<th style="text-indent:0.5%; width:6.5%;">CentreID</th>
								<th style="text-indent:0.5%; width:5.5%;">ProgID</th>
							</tr>
						</thead><?php
						$sno = 0;
						while($stmt->fetch())
						{
							if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
							<tr style="background-color:<?php echo $background_color;?>;">
								<td style="padding-right:1%; text-align:right;"><?php echo ++$sno;?></td>
								<td><?php echo $matno;?></td>
								<td><?php echo $names;?></td>
								<td><?php echo $cCourseId;?></td>
								<td><?php echo $vCourseDesc;?></td>
								<td><?php echo $iCreditUnit;?></td>
								<td><?php echo $tdate;?></td>
								<td><?php echo $iStudy_level;?></td>
								<td><?php echo $vCityName;?></td>
								<td><?php echo $cStudyCenterId;?></td>
								<td><?php echo $cProgrammeId;?></td>
							</tr><?php 
						}?>
					</table><?php
					log_actv('generated student list for TMA');
				}else if ($_REQUEST['whattodo'] == 9)//PAS
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								columns: [
									{ data: 'sno'},
									{ data: 'lname'},								
									{ data: 'fname'},
									{ data: 'mname'},
									{ data: 'centreId'},
									{ data: 'centre'},
									{ data: 'facultyId'},
									{ data: 'faculty'},
									{ data: 'progId'},
									{ data: 'prog'},
									{ data: 'mtn'},
									{ data: 'courseId'},
									{ data: 'course'},
									{ data: 'crunit'},
									{ data: 'emai;'},
									{ data: 'phone'},
								],
								dom: 'Bfrtip',
								
								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'Registration of Non-Examinable Courses',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'Student list',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15 ] },
										messageTop: 'Student list',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:100%;">
						<thead>
							<tr>
								<th style="padding-right:1%; text-align:right; width:4%;">Sno</th>
								<th style="text-indent:0.5%; width:6.8%;">LastName</th>
								<th style="text-indent:0.5%; width:6.8%;">FirstName</th>
								<th style="text-indent:0.5%; width:6.8%;">OtherName</th>
								<th style="text-indent:0.5%; width:5.8%;">CenterID</th>
								<th style="text-indent:0.5%; width:6.8%;">Centre</th>
								<th style="text-indent:0.5%; width:5.8%;">FacultID</th>
								<th style="text-indent:0.5%; width:6.8%;">Faculty</th>
								<th style="text-indent:0.5%; width:5.8%;">ProgID</th>
								<th style="text-indent:0.5%; width:7.8%;">Prog</th>
								<th style="text-indent:0.5%; width:6.8%;">MatNo</th>
								<th style="text-indent:0.5%; width:6.8%;">CourseID</th>
								<th style="text-indent:0.5%; width:8.8%;">Course</th>
								<th style="text-indent:0.5%; width:4.3%;">CrUnit</th>
								<th style="text-indent:0.5%; width:6.8%;">eMail</th>
								<th style="text-indent:0.5%; width:6.8%;">Phone</th>
							</tr>
						</thead><?php
						$sno = 0;
						while($stmt->fetch())
						{
							if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
							<tr style="background-color:<?php echo $background_color;?>;">
								<td style="text-align:right;"><?php echo ++$sno;?></td>
								<td><?php echo $vLastName;?></td>
								<td><?php echo $vFirstName;?></td>
								<td><?php echo $vOtherName;?></td>
								<td><?php echo $centreId;?></td>
								<td><?php echo $centre;?></td>
								<td><?php echo $facultyId;?></td>
								<td><?php echo $faculty;?></td>
								<td><?php echo $progId;?></td>
								<td><?php echo $prog;?></td>
								<td><?php echo $vMatricNo;?></td>
								<td><?php echo $courseId;?></td>
								<td><?php echo $Course;?></td>
								<td><?php echo $crunit;?></td>
								<td><?php echo $email;?></td>
								<td><?php echo $phone;?></td>
							</tr><?php 
						}?>
					</table><?php
					log_actv('generated student list on for PAS');
				}else if ($_REQUEST['whattodo'] == '9a')//Printing press
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								columns: [
									{ data: 'sno'},
									{ data: 'StudyCentre'},								
									{ data: 'Courseid'},
									{ data: 'count'},
								],
								dom: 'Bfrtip',
								
								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'Distribution of course registration',
										exportOptions: { columns: [ 0, 1, 2, 3 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'Student list',
										exportOptions: { columns: [ 0, 1, 2, 3 ] },
										messageTop: 'Distribution of course registration',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:70%;">
						<thead>
							<tr>
								<th style="padding-right:2%; text-align:right; width:10%;">Sno</th>
								<th style="text-indent:0.5%; width:40%;">StudyCentre</th>
								<th style="text-indent:0.5%; width:40%;">Course</th>
								<th style="padding-right:2%; text-align:right; width:10%;">Count</th>
							</tr>
						</thead><?php
						$sno = 0;
						while($stmt->fetch())
						{
							if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
							<tr style="background-color:<?php echo $background_color;?>;">
								<td style="text-align:right;"><?php echo ++$sno;?></td>
								<td><?php echo $studycentre;?></td>
								<td><?php echo $courseid;?></td>
								<td style="text-align:right;"><?php echo $count;?></td>
							</tr><?php 
						}?>
					</table><?php
					log_actv('generated student count on course registration');
				}else if ($_REQUEST['whattodo'] == 10)//CEMBA request
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								columns: [
									{ data: 'sno'},
									{ data: 'centre'},
									{ data: 'programme'},
									{ data: 'afn'},
									{ data: 'lname'},
									{ data: 'fname'},
									{ data: 'oname'},
									{ data: 'email'},
									{ data: 'phone'},
								],
								dom: 'Bfrtip',
								
								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'CEMBA-CEMPA Application List',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'CEMBA-CEMPA Application List',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ] },
										messageTop: 'Application Records',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:90%;">
						<thead>
							<tr>
								<th style="padding-right:2%; text-align:right; width:5%;">Sno</th>
								<th style="text-indent:0.5%; width:12.5%;">StudyCentre</th>
								<th style="text-indent:0.5%;width:12.5%;">Programme</th>
								<th style="text-indent:0.5%; width:12.5%;">AFN</th>
								<th style="text-indent:0.5%; width:12.5%;">LastName</th>
								<th style="text-indent:0.5%; width:12.5%;">FirstName</th>
								<th style="text-indent:0.5%; width:12.5%;">OtherName</th>
								<th style="text-indent:0.5%; width:12.5%;">eMail</th>
								<th style="text-indent:0.5%; width:12.5%;">Phone</th>
							</tr>
						</thead><?php
						$sno = 0;
						while($stmt->fetch())
						{
							if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
							<tr style="background-color:<?php echo $background_color;?>;">
								<td style="text-align:right;"><?php echo ++$sno;?></td>
								<td><?php echo $vCityName;?></td>
								<td><?php echo $vProgrammeDesc;?></td>
								<td><?php echo $vApplicationNo;?></td>
								<td><?php echo $vLastName;?></td>
								<td><?php echo $vFirstName;?></td>
								<td><?php echo $vOtherName;?></td>
								<td><?php echo $vEMailId;?></td>
								<td><?php echo $vMobileNo;?></td>
							</tr><?php 
						}?>
					</table><?php
					log_actv('generated applicant list on CEMBA/CEMPA programme');
				}else if ($_REQUEST['whattodo'] == 11)//NELFUND
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								columns: [
									{ data: 'sno'},
									{ data: 'fname'},
									{ data: 'mname'},
									{ data: 'lname'},
									{ data: 'emai;'},
									{ data: 'phone'},
									{ data: 'gender'},
									{ data: 'mtn'},
									{ data: 'Jnumber'},
									{ data: 'level'},
									{ data: 'year'},
									{ data: 'field'},
									{ data: 'state'},
									{ data: 'programme'},
									{ data: 'faculty'},
									{ data: 'dept'},
								],
								dom: 'Bfrtip',
								
								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'tudent list',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'Student list',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14 ] },
										messageTop: 'Student list',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:100%;">
						<thead>
							<tr>
								<th style="padding-right:1%; text-align:right; width:4%;">Sno</th>
								<th style="text-indent:0.5%; width:9.3%;">FirstName</th>
								<th style="text-indent:0.5%; width:7.3%;">MiddleName</th>
								<th style="text-indent:0.5%; width:7.3%;">LastName</th>
								<th style="text-indent:0.5%; width:7.3%;">eMail</th>
								<th style="text-indent:0.5%; width:6.3%;">Phone</th>
								<th style="text-indent:0.5%; width:4.3%;">Gender</th>
								<th style="text-indent:0.5%; width:6.3%;">MatNo</th>
								<th style="text-indent:0.5%; width:4.3%;">JAMBNo</th>
								<th style="text-indent:0.5%; width:4.3%;">Level</th>
								<th style="text-indent:0.5%; width:4.3%;">Year</th>
								<th style="text-indent:0.5%; width:7.3%;">DOB</th>
								<th style="text-indent:0.5%; width:5%;">StateOfOrigin</th>
								<th style="text-indent:0.5%;width:7.3%;">Programme</th>
								<th style="text-indent:0.5%; width:7.3%;">Faculty</th>
								<th style="text-indent:0.5%; width:7.3%;">Dept</th>
							</tr>
						</thead><?php
						$sno = 0;
						while($stmt->fetch())
						{
							if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
							<tr style="background-color:<?php echo $background_color;?>;">
								<td style="text-align:right;"><?php echo ++$sno;?></td>
								<td><?php echo $vFirstName;?></td>
								<td><?php echo $middlename;?></td>
								<td><?php echo $vLastName;?></td>
								<td><?php echo $email;?></td>
								<td><?php echo $phone;?></td>
								<td><?php echo $gender;?></td>
								<td><?php echo $vMatricNo;?></td>
								<td><?php  			
									$stmt_jamb = $mysqli->prepare("SELECT jamb_reg_no FROM prog_choice WHERE vApplicationNo = '$afn'");
									$stmt_jamb->execute();
									$stmt_jamb->store_result();
									$stmt_jamb->bind_result($jambno_1);
									$stmt_jamb->fetch();
									echo $jambno_1;?></td>
								<td><?php echo $level;?></td>
								<td><?php echo $year;?></td>
								<td><?php echo formatdate($dob,'fromdb');?></td>
								<td><?php  			
									$stmt_hstate = $mysqli->prepare("SELECT vStateName FROM ng_state WHERE cStateId = '$cHomeStateId'");
									$stmt_hstate->execute();
									$stmt_hstate->store_result();
									$stmt_hstate->bind_result($vStateName);
									$stmt_hstate->fetch();
									echo $vStateName;?></td>
								<td><?php echo $program;?></td>
								<td><?php echo $faculty;?></td>
								<td><?php echo $depts;?></td>
							</tr><?php 
						}?>
					</table><?php
					log_actv('generated student list on NELFUND');
				}else if ($_REQUEST['whattodo'] == 12)//JAMB request
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								columns: [
									{ data: 'sno'},
									{ data: 'MatNo'},
									{ data: 'fname'},
									{ data: 'lname'},
									{ data: 'gender'},
									{ data: 'dob'},
									{ data: 'state'},
									{ data: 'level'},
									{ data: 'Jnumber'},
									{ data: 'program'},
									{ data: 'dept'},
									{ data: 'faculty'},
									{ data: 'duration'},
								],
								dom: 'Bfrtip',
								
								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'Student List',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'Student List',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ] },
										messageTop: 'Student List',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:100%;">
						<thead>
							<tr>
								<th style="padding-right:1%; text-align:right; width:6%;">Sno</th>
								<th style="text-indent:0.5%; width:8.1%;">MatNo</th>
								<th style="text-indent:0.5%; width:9.1%;">FirstName</th>
								<th style="text-indent:0.5%;width:9.1%;">LastName</th>
								<th style="text-indent:0.5%; width:9.1%;">Gender</th>
								<th style="text-indent:0.5%; width:5%;">DOB</th>
								<th style="text-indent:0.5%; width:9.1%;">StateOfOrigin</th>
								<th style="text-indent:0.5%; width:6.1%;">Level</th>
								<th style="text-indent:0.5%; width:7.1%;">JAMBNo</th>
								<th style="text-indent:0.5%; width:8.1%;">Programme</th>
								<th style="text-indent:0.5%; width:8.1%;">Department</th>
								<th style="text-indent:0.5%; width:8.1%;">Faculty</th>
								<th style="padding-right:1%; text-align:right; width:5.6%;">Duration</th>
							</tr>
						</thead><?php
						$sno = 0;

						while($stmt->fetch())
						{
							if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
							<tr style="background-color:<?php echo $background_color;?>;">
								<td style="padding-right:1%; text-align:right;"><?php echo ++$sno;?></td>
								<td><?php echo $vMatricNo;?></td>
								<td><?php echo $vFirstName;?></td>
								<td><?php echo $vLastName;?></td>
								<td><?php echo $gender;?></td>
								<td><?php echo formatdate($dob,'fromdb');?></td>
								<td><?php $stmt_hstate = $mysqli->prepare("SELECT vStateName FROM ng_state WHERE cStateId = '$cHomeStateId'");
									$stmt_hstate->execute();
									$stmt_hstate->store_result();
									$stmt_hstate->bind_result($vStateName);
									$stmt_hstate->fetch();
									echo $vStateName;
									
									//echo $state;?></td>
								<td><?php echo $level;?></td>
								<td><?php 			
									$stmt_jamb = $mysqli->prepare("SELECT jamb_reg_no FROM prog_choice WHERE vApplicationNo = '$afn'");
									$stmt_jamb->execute();
									$stmt_jamb->store_result();
									$stmt_jamb->bind_result($jambno_1);
									$stmt_jamb->fetch();
									echo $jambno_1;?>
								</td>
								<td><?php echo $vProgrammeDesc;?></td>
								<td><?php echo $depts;?></td>
								<td><?php echo $faculty;?></td>
								<td style="padding-right:1%; text-align:right;"><?php echo intval($duration);?></td>
							</tr><?php 
						}?>
					</table><?php
					log_actv('generated student list on JAMB request');
				}else if ($_REQUEST['whattodo'] == '12a')//siwes
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								columns: [
									{ data: 'sno'},
									{ data: 'centreid'},								
									{ data: 'centre'},
									{ data: 'facultyid'},
									{ data: 'programid'},
									{ data: 'qualif'},
									{ data: 'program'},
									{ data: 'matricno'},
									{ data: 'lname'},
									{ data: 'fname'},
									{ data: 'oname'},
									{ data: 'semester'},
									{ data: 'courseId'},
									{ data: 'course'},
									{ data: 'crunit'},
									{ data: 'emai'},
									{ data: 'phone'},
								],
								dom: 'Bfrtip',
								
								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'SIWES List',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'SIWES list',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16 ] },
										messageTop: 'SIWES List',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:100%;">
						<thead>
							<tr>
								<th style="padding-right:1%; text-align:right; width:4%;">Sno</th>
								<th style="text-indent:0.5%; width:5.9%;">CentreID</th>
								<th style="text-indent:0.5%; width:5.9%;">CentreName</th>
								<th style="text-indent:0.5%; width:5.9%;">FaucltyID</th>
								<th style="text-indent:0.5%; width:5.8%;">ProgramID</th>
								<th style="text-indent:0.5%; width:5.9%;">Qualification</th>
								<th style="text-indent:0.5%; width:5.8%;">Program</th>
								<th style="text-indent:0.5%; width:5.9%;">MatricNo</th>
								<th style="text-indent:0.5%; width:5.8%;">LastName</th>
								<th style="text-indent:0.5%; width:5.9%;">FirstName</th>
								<th style="text-indent:0.5%; width:5.9%;">OtherName</th>
								<th style="text-indent:0.5%; width:5.9%;">Semester</th>
								<th style="text-indent:0.5%; width:5.9%;">CourseID</th>
								<th style="text-indent:0.5%; width:5.9%;">CourseTitle</th>
								<th style="padding-right:0.5%; text-align:right; width:5.9%;">CrUnit</th>
								<th style="text-indent:0.5%; width:5.9%;">eMail</th>
								<th style="text-indent:0.5%; width:5.9%;">Phone</th>
							</tr>
						</thead><?php
						$sno = 0;
						while($stmt->fetch())
						{
							if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
							<tr style="background-color:<?php echo $background_color;?>;">
								<td style="text-align:right;"><?php echo ++$sno;?></td>
								<td><?php echo $cStudyCenterId;?></td>
								<td><?php echo $vCityName;?></td>
								<td><?php echo $cFacultyId;?></td>
								<td><?php echo $cProgrammeId;?></td>
								<td><?php echo $vObtQualTitle;?></td>
								<td><?php echo $vProgrammeDesc;?></td>
								<td><?php echo $vMatricNo;?></td>
								<td><?php echo $vLastName;?></td>
								<td><?php echo $vFirstName;?></td>
								<td><?php echo $vOtherName;?></td>
								<td><?php echo $tSemester;?></td>
								<td><?php echo $cCourseId;?></td>
								<td><?php echo $vCourseDesc;?></td>
								<td><?php echo $iCreditUnit;?></td>
								<td><?php echo $vEMailId;?></td>
								<td><?php echo $vMobileNo;?></td>
							</tr><?php 
						}?>
					</table><?php
					log_actv('generated SIWES student list');
				}else if ($_REQUEST['whattodo'] == '13')//wallet funding
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								columns: [
									{ data: 'sno'},
									{ data: 'Matno'},
									{ data: 'rrr'},								
									{ data: 'Name'},								
									{ data: 'Description'},
									{ data: 'Date'},
									{ data: 'Amount'},
								],
								dom: 'Bfrtip',
								
								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'Wallet funding',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'Wallet funding',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6 ] },
										messageTop: 'Wallet funding',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:70%;">
						<thead>
							<tr>
								<th style="padding-right:2%; text-align:right; width:7%;">Sno</th>
								<th style="text-indent:0.5%; width:15.2%;">MatNo.</th>
								<th style="text-indent:0.5%; width:16.2%;">RRR</th>
								<th style="text-indent:0.5%; width:18.2%;">name</th>
								<th style="text-indent:0.5%; width:15.2%;">Description</th>
								<th style="text-indent:0.5%; width:15.2%;">Date</th>
								<th style="padding-right:2%; text-align:align; width:12.2%;">Amount</th>
							</tr>
						</thead>
						<tbody><?php
							$sno = 0;
							$tAmount = 0;
							while($stmt->fetch())
							{
								if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
								<tr style="background-color:<?php echo $background_color;?>;">
									<td style="text-align:right;"><?php echo ++$sno;?></td>
									<td><?php echo $matno;?></td>
									<td><?php echo $rrr;?></td>
									<td><?php echo $payerName;?></td>
									<td><?php echo $vDesc;?></td>
									<td><?php echo $TransactionDate;?></td>
									<td style="padding-right:2%; text-align:right;"><?php echo number_format($Amount);?></td>
								</tr><?php 
								$tAmount += $Amount;
							}?>
						</tbody>						
						<tfoot>
							<tr style="background-color:<?php echo $background_color;?>;">
								<td colspan="4"></td>
								<td></td>
								<td style="text-align:right;">Total</td>
								<td style="padding-right:2%; text-align:right;"><?php echo number_format($tAmount);?></td>
							</tr>
						</tfoot>
					</table><?php
					log_actv('generated report on wallet fundings');
				}else if ($_REQUEST['whattodo'] == '14')//debits
				{
					if (isset($_REQUEST['debit_smry1']) || isset($_REQUEST['debit_smry2']))
					{?>
						<script type="text/javascript">
							$(document).ready(function ()
							{							
								$('#gridz').dataTable({
										deferRender: true,
										fixedHeader: {
										header: true,
										footer: true,
									},
									
									columns: [
										{ data: 'sno'},
										{ data: 'Item'},								
										{ data: 'Amount'},								
									],
									dom: 'Bfrtip',
									
									buttons: 
									[
										{
											extend: 'excelHtml5',
											title: 'Summary of debit transactions',
											exportOptions: { columns: [ 0, 1, 2 ] },
										},
										{
											extend: 'pdfHtml5',
											title: 'Summary of debit transactions',
											exportOptions: { columns: [ 0, 1, 2 ] },
											messageTop: 'Debit transactions',
											messageBottom: 'Powered by MIS',
											title: 'National Open University of Nigeria:',
											margin: [ 2, 2, 2, 2],
											pageSize: 'A4',
											orientation: 'portrate',
										},
										'print'
									]
								} );
							});
						</script>
						
						<table id="gridz" class="table table-condensed table-responsive" style="width:50%;">
							<thead>
								<tr>
									<th style="padding-right:5%; text-align:right; width:10%;">Sno</th>
									<th style="text-indent:0.5%; width:60%;">Item</th>
									<th style="padding-right:2%; text-align:right; width:25%;"><?php
										if (isset($_REQUEST['debit_smry1']))
										{
											echo 'Amount';
										}else if (isset($_REQUEST['debit_smry2']))
										{
											echo 'Count';
										}?>
									</th>
								</tr>
							</thead>
							<tbody><?php
								$sno = 0;
								$tAmount = 0;
								while($stmt->fetch())
								{
									if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
									<tr style="background-color:<?php echo $background_color;?>;">
										<td style="text-align:right;"><?php echo ++$sno;?></td>
										<td><?php echo $item;?></td>
										<td style="padding-right:2%; text-align:right;"><?php echo number_format($Amount);?></td>
									</tr><?php
									$tAmount += $Amount;
								}?>
							</tbody><?php
							if (isset($_REQUEST['debit_smry1']))
							{?>
								<tfoot>
									<tr style="background-color:<?php echo $background_color;?>;">
										<td colspan="2" style="text-align:right;">Total</td>
										<td style="padding-right:2%; text-align:right;"><?php echo number_format($tAmount);?></td>
									</tr>
								</tfoot><?php
							}?>
						</table><?php
					}else
					{?>
						<script type="text/javascript">
							$(document).ready(function ()
							{							
								$('#gridz').dataTable({
										deferRender: true,
										fixedHeader: {
										header: true,
										footer: true,
									},
									
									columns: [
										{ data: 'sno'},
										{ data: 'Matno'},								
										{ data: 'Name'},								
										{ data: 'Description'},
										{ data: 'Date'},
										{ data: 'Amount'},
									],
									dom: 'Bfrtip',
									
									buttons: 
									[
										{
											extend: 'excelHtml5',
											title: 'Debit transactions',
											exportOptions: { columns: [ 0, 1, 2, 3, 4, 5 ] },
										},
										{
											extend: 'pdfHtml5',
											title: 'Debit transactions',
											exportOptions: { columns: [ 0, 1, 2, 3, 4, 5 ] },
											messageTop: 'Debit transactions',
											messageBottom: 'Powered by MIS',
											title: 'National Open University of Nigeria:',
											margin: [ 2, 2, 2, 2],
											pageSize: 'A4',
											orientation: 'portrate',
										},
										'print'
									]
								} );
							});
						</script>
						<table id="gridz" class="table table-condensed table-responsive" style="width:70%;">
							<thead>
								<tr>
									<th style="padding-right:2%; text-align:right; width:7%;">Sno</th>
									<th style="text-indent:0.5%; width:19.2%;">MatNo.</th>
									<th style="text-indent:0.5%; width:29.2%;">Name</th>
									<th style="text-indent:0.5%; width:19.2%;">Description</th>
									<th style="text-indent:0.5%; width:12.2%;">Date</th>
									<th style="padding-right:2%; text-align:right; width:12.2%;">Amount</th>
								</tr>
							</thead><?php
							$sno = 0;
							while($stmt->fetch())
							{
								if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
								<tr style="background-color:<?php echo $background_color;?>;">
									<td style="text-align:right;"><?php echo ++$sno;?></td>
									<td><?php echo $matno;?></td>
									<td><?php echo $payerName;?></td>
									<td><?php echo $vDesc;?></td>
									<td><?php echo $TransactionDate;?></td>
									<td style="padding-right:2%; text-align:right;"><?php echo number_format($Amount);?></td>
								</tr><?php 
							}?>
						</table><?php
						log_actv('generated report on debit transactions');
					}
				}else if ($_REQUEST['whattodo'] == '15')//g_refund
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								columns: [
									{ data: 'sno'},
									{ data: 'Matno'},								
									{ data: 'ac_name'},								
									{ data: 'b_name'},
									{ data: 'an_no'},
									{ data: 'centre'},
									{ data: 'amount'},
									{ data: 'date'},
									{ data: 'rrr'},
								],
								dom: 'Bfrtip',
								
								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'Refund on gown payment',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'Refund on gown payment',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ] },
										messageTop: 'Refund on gown payment',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:90%;">
						<thead>
							<tr>
								<th style="padding-right:2%; text-align:right; width:7%;">Sno</th>
								<th style="padding-right:2%; width:11.4%;">Study Centre</th>
								<th style="text-indent:0.5%; width:11.4%;">Matric. No.</th>
								<th style="text-indent:0.5%; width:11.4%;">Account name</th>
								<th style="text-indent:0.5%; width:11.4%;">bank</th>
								<th style="text-indent:0.5%; width:10.2%;">Account No.</th>
								<th style="padding-right:2%; width:11.4%; text-align:right;">Amount</th>
								<th style="text-indent:0.5%; width:11.4%;">Date</th>
								<th style="text-indent:0.5%; width:11.4%;">RRR</th>
							</tr>
						</thead><?php
						$sno = 0;
						
						while($stmt->fetch())
						{
							if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
							<tr style="background-color:<?php echo $background_color;?>;">
								<td style="text-align:right;"><?php echo ++$sno;?></td>
								<td><?php echo $studycentre;?></td>
								<td><?php echo $matno;?></td>
								<td><?php echo $account_name;?></td>
								<td><?php echo $bank_name;?></td>
								<td><?php echo $account_number;?></td>
								<td style="padding-right:2%; text-align:right"><?php echo $Amount;?></td>
								<td><?php echo $tdate;?></td>
								<td><?php echo $rrr;?></td>
							</tr><?php 
						}?>
					</table><?php
					log_actv('generated report on gown refund');
				}else if ($_REQUEST['whattodo'] == 16)//CHD request
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								columns: [
									{ data: 'sno'},
									{ data: 'centre'},
									{ data: 'programme'},
									{ data: 'afn'},
									{ data: 'lname'},
									{ data: 'fname'},
									{ data: 'oname'},
									{ data: 'email'},
									{ data: 'phone'},
									{ data: 'status'},
									{ data: 'date'},
								],
								dom: 'Bfrtip',
								
								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'CHD Application List',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'CHD Application List',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ] },
										messageTop: 'Application Records',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:95%;">
						<thead>
							<tr>
								<th style="padding-right:2%; text-align:right; width:5%;">Sno</th>
								<th style="text-indent:0.5%; width:11.5%;">StudyCentre</th>
								<th style="text-indent:0.5%;width:11.5%;">Programme</th>
								<th style="text-indent:0.5%; width:9.5%;">AFN</th>
								<th style="text-indent:0.5%; width:9.5%;">LastName</th>
								<th style="text-indent:0.5%; width:9.5%;">FirstName</th>
								<th style="text-indent:0.5%; width:9.5%;">OtherName</th>
								<th style="text-indent:0.5%; width:9.5%;">eMail</th>
								<th style="text-indent:0.5%; width:9.5%;">Phone</th>
								<th style="text-indent:0.5%; width:5.5%;">Status</th>
								<th style="text-indent:0.5%; width:9.5%;">Date</th>
							</tr>
						</thead><?php
						$sno = 0;
						while($stmt->fetch())
						{
							if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
							<tr style="background-color:<?php echo $background_color;?>;">
								<td style="text-align:right;"><?php echo ++$sno;?></td>
								<td><?php echo $vCityName;?></td>
								<td><?php echo $vProgrammeDesc;?></td>
								<td><?php echo $vApplicationNo;?></td>
								<td><?php echo $vLastName;?></td>
								<td><?php echo $vFirstName;?></td>
								<td><?php echo $vOtherName;?></td>
								<td><?php echo $vEMailId;?></td>
								<td><?php echo $vMobileNo;?></td>
								<td><?php if ($_REQUEST["show_chd_opt_h"] == '1')
								{
									if ($cSbmtd == '0')
									{
										echo 'To submit';
									}else if ($cSbmtd == '1')
									{
										echo 'Submitted';
									}else if ($cSbmtd == '2')
									{
										echo 'Cleared';
									}
								}else if ($_REQUEST["show_chd_opt_h"] == '2')
								{
									if ($semester_reg == '0')
									{
										echo 'Not registered';
									}else if ($semester_reg == '1')
									{
										echo 'Registered';
									}
								}?></td>
								<td><?php echo $tdate;?></td>
							</tr><?php 
						}?>
					</table><?php
					log_actv('generated applicant list on CHD programme');
				}else if ($_REQUEST['whattodo'] == 17)//LAW request
				{?>
					<script type="text/javascript">
						$(document).ready(function ()
						{							
							$('#gridz').dataTable({
									deferRender: true,
									fixedHeader: {
									header: true,
									footer: true,
								},
								
								columns: [
									{ data: 'sno'},
									{ data: 'centre'},
									{ data: 'programme'},
									{ data: 'afn'},
									{ data: 'lname'},
									{ data: 'fname'},
									{ data: 'oname'},
									{ data: 'email'},
									{ data: 'phone'},
									{ data: 'date'},
								],
								dom: 'Bfrtip',
								
								buttons: 
								[
									{
										extend: 'excelHtml5',
										title: 'LAW Application List - Not cleared',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ] },
									},
									{
										extend: 'pdfHtml5',
										title: 'LAW Application List - Not cleared',
										exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ] },
										messageTop: 'Application Records',
										messageBottom: 'Powered by MIS',
										title: 'National Open University of Nigeria:',
										margin: [ 2, 2, 2, 2],
										pageSize: 'A4',
										orientation: 'portrate',
									},
									'print'
								]
							} );
						});
					</script>
					<table id="gridz" class="table table-condensed table-responsive" style="width:95%;">
						<thead>
							<tr>
								<th style="padding-right:2%; text-align:right; width:5%;">Sno</th>
								<th style="text-indent:0.5%; width:13%;">StudyCentre</th>
								<th style="text-indent:0.5%;width:11.5%;">Programme</th>
								<th style="text-indent:0.5%; width:9.5%;">AFN</th>
								<th style="text-indent:0.5%; width:10.5%;">LastName</th>
								<th style="text-indent:0.5%; width:10.5%;">FirstName</th>
								<th style="text-indent:0.5%; width:10.5%;">OtherName</th>
								<th style="text-indent:0.5%; width:9.5%;">eMail</th>
								<th style="text-indent:0.5%; width:9.5%;">Phone</th>
								<th style="text-indent:0.5%; width:9.5%;">Date</th>
							</tr>
						</thead><?php
						$sno = 0;
						while($stmt->fetch())
						{
							if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
							<tr style="background-color:<?php echo $background_color;?>;">
								<td style="text-align:right;"><?php echo ++$sno;?></td>
								<td><?php echo $vCityName;?></td>
								<td><?php echo $vProgrammeDesc;?></td>
								<td><?php echo $vApplicationNo;?></td>
								<td><?php echo $vLastName;?></td>
								<td><?php echo $vFirstName;?></td>
								<td><?php echo $vOtherName;?></td>
								<td><?php echo $vEMailId;?></td>
								<td><?php echo $vMobileNo;?></td>
								<td><?php echo $tdate;?></td>
							</tr><?php 
						}?>
					</table><?php
					log_actv('generated applicant list on LAW programme');
				}
			}?>
		<!-- InstanceEndEditable -->
	</div>	
	<div id="futa"><?php foot_bar();?></div>
</body>
<!-- InstanceEnd --></html>