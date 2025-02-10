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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/applform.dwt.php" codeOutsideHTMLIsLocked="false" -->
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




<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
<script language="JavaScript" type="text/javascript" src="button_ops.js"></script>
<script language="JavaScript" type="text/javascript" src="setup_facult.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />
<script language="JavaScript" type="text/javascript">
	document.onkeydown = function (e) 
	{
		if (e.ctrlKey && e.keyCode === 85) 
		{
            return false;
        }
	}

	function selectCourse(courseCode, tSemester, iCreditUnit, courseTitle)
	{
		if (courseCode.substr(4,2) != 99)
		{
			if (courseCode.substr(3,1)+'00' != _("courseLevel").value && _("courseLevel").value >= 100)
			{
				return;
			}else if (_("coursesemester_h2").value == '' || ((courseCode.substr(5,1))%2 == 0 && _("coursesemester_h2").value == 1) || ((courseCode != 'CHM499' && (courseCode.substr(5,1))%2 > 0 && _("coursesemester_h2").value == 2)))
			{        
				return;
			}	
		}

		var retActive = '0';
		if (_('course_selector').style.display == 'block')
		{
			var cusStatus = _('course_mandate_h').value;
			var retActive = _('course_effect_h').value;
		}else if (event.ctrlKey)
		{
			var cusStatus = 'C';
		}else if (event.altKey)
		{
			var cusStatus = 'R';
		}else
		{
			var cusStatus = 'E';
		}
			
		var allChildNodes = _("reg_courses").getElementsByTagName('input');
		for (i = 0; i < allChildNodes.length; i++)
		{
			if (allChildNodes[i].value.substr(1,6) == courseCode){return;}
		}

		if (_("numOfiputTag").value == ''){_("numOfiputTag").value = 0;}
		
		_("numOfiputTag").value = parseInt(_("numOfiputTag").value) + 1;
		var numOfiputTags = _("numOfiputTag").value;
		
		
		var li = document.createElement('li');
		li.setAttribute('onclick', 'this.parentNode.removeChild(this);');
		li.style.background = '#E2D8D6';
		li.style.height = '30px';
		
		var input = document.createElement('input');
		input.type = 'hidden';
		input.name = 'regCourses'+numOfiputTags;
		input.id = 'regCourses'+numOfiputTags;
		input.value = cusStatus+retActive+courseCode;
		li.appendChild(input);
		
		var div1 = document.createElement('div');
		div1.setAttribute('class','chkboxNoDiv');
		div1.innerHTML = parseInt(numOfiputTags)+1;
		li.appendChild(div1);
		
		var div2 = document.createElement('div');
		div2.setAttribute('class','ccodeDiv');
		div2.innerHTML = courseCode;
		li.appendChild(div2);

		var div3 = document.createElement('div');
		div3.setAttribute('class','singlecharDiv');
		div3.innerHTML = cusStatus;
		li.appendChild(div3);

		var div4 = document.createElement('div');
		div4.setAttribute('class','singlecharDiv');
		div4.innerHTML = tSemester;
		li.appendChild(div4);

		/*var div5 = document.createElement('div');
		div5.setAttribute('class','singlecharDiv');
		div5.innerHTML = iCreditUnit;
		li.appendChild(div5);*/

		var div6 = document.createElement('div');
		div6.setAttribute('class','ctitle ctitle_right');
		div6.innerHTML = courseTitle;
		li.appendChild(div6);
		
		_("reg_courses").appendChild(li);



		var allChildNodes = _("reg_courses_ec").getElementsByTagName('input');
		for (i = 0; i < allChildNodes.length; i++)
		{
			if (allChildNodes[i].value.substr(1,6) == courseCode){return;}
		}

		if (_("numOfiputTag").value == ''){_("numOfiputTag").value = 0;}
		
		var numOfiputTags = _("numOfiputTag").value;
		
		
		var li = document.createElement('li');
		li.setAttribute('onclick', 'this.parentNode.removeChild(this);');
		li.style.background = '#E2D8D6';
		
		var input = document.createElement('input');
		input.type = 'hidden';
		input.name = 'regCourses'+numOfiputTags+'_ec';
		input.id = 'regCourses'+numOfiputTags+'_ec';
		input.value = cusStatus+retActive+courseCode;
		li.appendChild(input);
		
		var div1 = document.createElement('div');
		div1.setAttribute('class','chkboxNoDiv');
		div1.innerHTML = parseInt(numOfiputTags)+1;
		li.appendChild(div1);
		
		var div2 = document.createElement('div');
		div2.setAttribute('class','ccodeDiv');
		div2.innerHTML = courseCode;
		li.appendChild(div2);

		var div3 = document.createElement('div');
		div3.setAttribute('class','singlecharDiv');
		div3.innerHTML = cusStatus;
		li.appendChild(div3);

		var div4 = document.createElement('div');
		div4.setAttribute('class','singlecharDiv');
		div4.innerHTML = tSemester;
		li.appendChild(div4);

		/*var div5 = document.createElement('div');
		div5.setAttribute('class','singlecharDiv');
		div5.innerHTML = iCreditUnit;
		li.appendChild(div5);*/

		var div6 = document.createElement('div');
		div6.setAttribute('class','ctitle ctitle_right');
		div6.innerHTML = courseTitle;
		li.appendChild(div6);
		_("reg_courses_ec").appendChild(li);
		
		_("sub_box").style.display = 'block';
	}
</script>
<noscript></noscript>

<!-- InstanceBeginEditable name="head" -->
<script language="JavaScript" type="text/javascript"></script>

<style type="text/css">

	ol { list-style: decimal;}
	.checklist li { background: none; padding: 0px; }
	.checklist {
		border: 1px solid #ccc;
		margin-left:0px;
		list-style: none;
		overflow: auto;
	}
	
	li {float:left; margin: 0px;  padding: 0px; margin-top:-1; width:100%;}
	.checklist label { display: block; padding-left:0px;}
	.checklist li:hover { background: #777; color: #fff; }
	
	.cl1 { font-size: 0.9em;}
	.cl1 .alt { background:#EEF7EE; }
</style><?php

require_once ('set_scheduled_dates.php');?>
<!-- InstanceEndEditable -->
</head>
<body onLoad="checkConnection()">
	
						 
<div id="course_selector" class="center" 
	style="width:1295px; 
	height:auto;
	border:1px solid #CCCCCC; 
	padding:15px; 
	display:none;
	box-shadow: 4px 4px 3px #888888; 
	background:#ffffff;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:13px;
	z-index:0;
	opacity:1">
	<div id="div_header" class="innercont_stff" style="font-size:13px; height:auto; padding:3px; margin-bottom:5px; width:97%;">
		Edit Curriculum <?php if (isset($_REQUEST["cprogrammedescNew_h1"])){echo $_REQUEST["cprogrammedescNew_h1"];}?>
	</div>

	<div class="innercont_stff" style="height:auto; padding:3px; margin-bottom:5px; width:2%; text-align:right;">
		<img style="width:17px; height:17px; cursor:pointer" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" 
			onclick="_('course_selector').style.zIndex = '-1';
			_('course_selector').style.display='none';
			_('smke_screen_2').style.zIndex = '-1';
			_('smke_screen_2').style.display = 'none';
			
			_('print_btn').style.display = 'block';
			return false"/>
	</div>
	
	<!-- <hr style="height:5px; width:100%; margin-top:6px; margin-bottom:15px; background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0px; height:1px;" />
	
	<div class="innercont_stff" style="height:30px; width:99%; padding-left:0.5%; margin-top:0px">
		<?php //echo $_REQUEST["cprogrammedescNew_h1"];?>
	</div> -->

	<div class="innercont_stff" style="height:30px; width:48.5%; padding-left:0.5%; padding-top:0.8%; border:1px solid #CCC; background-color:#DFE3E2">
		All courses sorted by facuty, department, programmes,...
	</div>
	<div class="innercont_stff" style="height:30px; width:48.5%; padding-left:0.5%; padding-top:0.8%; border:1px solid #CCC; background-color:#DFE3E2; margin-left:1.2%;">
		Registrable courses for selected programme, sorted by level and semster
	</div><?php

	if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '0' && isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] <> '5')
	{
		if ($_REQUEST['courseLevel'] >= 100)
		{
			$stmt = $mysqli->prepare("SELECT concat(substr(cCourseId,4,1),'00') siLevel, tSemester, cCourseId, vCourseDesc, iCreditUnit, ancilary_type
			from courses
			where substr(cCourseId,4,1) = left(?,1) and tSemester = ?	
			and cdel = 'N'
			order by cdeptId, siLevel, tSemester, cCourseId");
			$stmt->bind_param("si", $_REQUEST['courseLevel'], $_REQUEST['coursesemester_h2']);
		}else
		{
			$stmt = $mysqli->prepare("SELECT concat(substr(cCourseId,4,1),'00') siLevel, tSemester, cCourseId, vCourseDesc, iCreditUnit, ancilary_type
			from courses
			where (substr(cCourseId,4,1) = '0'
			or (substr(cCourseId,4,1) = '1' and cFacultyId = ?)
			or cCourseId like 'GST%' or cCourseId like 'NOU%')
			and tSemester = ?
			and cdel = 'N'
			order by cdeptId, siLevel, tSemester, cCourseId");
			$stmt->bind_param("si", $_REQUEST['cFacultyIdold'], $_REQUEST['coursesemester_h2']);
		}									
	}else if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '0' && !(isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] <> '5'))
	{
		if ($_REQUEST['courseLevel'] >= 100)
		{
			$stmt = $mysqli->prepare("select concat(substr(cCourseId,4,1),'00') siLevel, tSemester, cCourseId, vCourseDesc, iCreditUnit, ancilary_type
			from courses
			where substr(cCourseId,4,1) = left(?,1)	
			and cdel = 'N'
			order by cdeptId, siLevel, tSemester, cCourseId");
			$stmt->bind_param("s", $_REQUEST['courseLevel']);
		}else 
		{
			$stmt = $mysqli->prepare("SELECT concat(substr(cCourseId,4,1),'00') siLevel, tSemester, cCourseId, vCourseDesc, iCreditUnit, ancilary_type
			from courses
			where (substr(cCourseId,4,1) = '0'
			or (substr(cCourseId,4,1) = '1' and cFacultyId = ?)
			or cCourseId like 'GST%' or cCourseId like 'NOU%')
			and cdel = 'N'
			order by cdeptId, siLevel, tSemester, cCourseId");
			$stmt->bind_param("s", $_REQUEST['cFacultyIdold']);
		}		
	}else if (!(isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '0') && isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] <> '5')
	{
		if ($_REQUEST['courseLevel'] >= 100)
		{
			$stmt = $mysqli->prepare("select concat(substr(cCourseId,4,1),'00') siLevel, tSemester, cCourseId, vCourseDesc, iCreditUnit, ancilary_type
			from courses
			where tSemester = ?	
			and cdel = 'N'
			order by cdeptId, siLevel, tSemester, cCourseId");
			$stmt->bind_param("i", $_REQUEST['coursesemester_h2']);
		}else
		{
			$stmt = $mysqli->prepare("SELECT concat(substr(cCourseId,4,1),'00') siLevel, tSemester, cCourseId, vCourseDesc, iCreditUnit, ancilary_type
			from courses
			where (substr(cCourseId,4,1) = '0'
			or (substr(cCourseId,4,1) = '1' and cFacultyId = ?)
			or cCourseId like 'GST%' or cCourseId like 'NOU%')
			and tSemester = ?
			and cdel = 'N'
			order by cdeptId, siLevel, tSemester, cCourseId");
			$stmt->bind_param("si", $_REQUEST['cFacultyIdold'], $_REQUEST['coursesemester_h2']);
		}
	}else
	{
		$stmt = $mysqli->prepare("select concat(substr(cCourseId,4,1),'00') siLevel, tSemester, cCourseId, vCourseDesc, iCreditUnit, ancilary_type
		from courses
		where tSemester = 0	
		and cdel = 'N'
		order by cFacultyId, cdeptId, siLevel, tSemester, cCourseId");
	}
	$stmt->execute();
	$stmt->store_result();
	
	$stmt->bind_result($siLevel2, $tSemester2, $cCourseId2, $vCourseDesc2, $iCreditUnit2, $ancilary_type);?>
	
	<ul id="all_courses" class="checklist cl1" style="float:left; width:49%; margin-left:0px; height:469px; margin-right:1.2%; overflow:auto; overflow-x: hidden;"><?php
		$c = 0;
			
		$prevLevel = ''; 
		$prevSemester = '';
		$prev_dept = '';
		while($stmt->fetch())
		{
			$tSemester_desc = 'First';
			if ($tSemester2 == 2){$tSemester_desc = 'Second';}											
			
			if (($prevSemester <> '' && $prevSemester <> $tSemester2) || ($prev_dept <> '' && $prev_dept <> substr($cCourseId2,0,3)))
			{?>
				<li>
					<div style="padding:0.4%; padding-top:1.5%; padding-bottom:1.5%; border-radius:0px; color:#FFFFFF">
						.
					</div>
				</li><?php  
			}
												
			$c++;
			$selectCourse_para = "'".$cCourseId2."','".$tSemester2."','".$iCreditUnit2."','".$vCourseDesc2."'";?>
			
			<li id="ali<?php echo $c;?>" style="text-align:left; font-size:11px; height:auto;"<?php if ($c%2 == 0){echo ' class="alt"';}?> 
				title="Click to add course to the box on the right. Ctrl+Click = Compulsory. Alt+Click = Required. Click = Elective" 
				onclick="selectCourse(<?php echo $selectCourse_para;?>)">
				<div class="chkboxNoDiv" style="padding:0.8%; padding-top:1.5%; padding-bottom:1.5%;"><?php echo $c;?></div>

				<div class="ccodeDiv" style="width:8.5%; padding:0.8%; padding-top:1.5%; padding-bottom:1.5%;">
					<?php echo $cCourseId2;?>
				</div>
				
				<div class="singlecharDiv" style="width:5%; padding:0.8%; padding-top:1.5%; padding-bottom:1.5%;">
					<?php echo $iCreditUnit2;?>
				</div>

				<div class="ctitle" style="width:74.7%; padding:0.8%; padding-top:1.5%; padding-bottom:1.5%;">
					<?php echo $vCourseDesc2;?>
				</div>
			</li><?php
			
			$prev_dept = substr($cCourseId2, 0, 3);
			$prevSemester = $tSemester2;
		}
		$stmt->close();?>
	</ul><?php
	$selected_curr = "";
	if (isset($_REQUEST["select_curriculum_h2"]))
	{
		if ($_REQUEST["select_curriculum_h2"] == '1')
		{
			$selected_curr = " AND a.cAcademicDesc <= 2023";
		}else if ($_REQUEST["select_curriculum_h2"] == '2')
		{
			//$selected_curr = " AND a.cAcademicDesc = 2024";
		}
	}
	
	if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '0' && isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] <> '3')
	{
		$stmt = $mysqli->prepare("select a.siLevel, a.tSemester, a.cCourseId, c.vCourseDesc, iCreditUnit, cCategory, retActive
		from progcourse a, depts b, courses c
		where a.cdeptId = b.cdeptId 
		and a.cCourseId = c.cCourseId
		and a.siLevel = ? and a.tSemester = ?
		and b.cFacultyId = ? and  a.cProgrammeId = ?
		$selected_curr
		and a.cdel = 'N'
		order by siLevel, tSemester, cCourseId");
		$stmt->bind_param("iiss", $_REQUEST['courseLevel'], $_REQUEST['coursesemester_h2'], $_REQUEST['cFacultyIdold'],  $_REQUEST['cprogrammeIdold']);
	}else if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '0' && !(isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] <> '3'))
	{
		$stmt = $mysqli->prepare("select a.siLevel, a.tSemester, a.cCourseId, c.vCourseDesc, iCreditUnit, cCategory, retActive
		from progcourse a, depts b, courses c
		where a.cdeptId = b.cdeptId 
		and a.cCourseId = c.cCourseId
		and a.siLevel = ? 
		and b.cFacultyId = ? and  a.cProgrammeId = ?
		$selected_curr
		and a.cdel = 'N'
		order by  siLevel, tSemester, cCourseId");
		$stmt->bind_param("iss", $_REQUEST['courseLevel'], $_REQUEST['cFacultyIdold'],  $_REQUEST['cprogrammeIdold']);
	}else if (!(isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '0') && isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] <> '3')
	{
		$stmt = $mysqli->prepare("select a.siLevel, a.tSemester, a.cCourseId, c.vCourseDesc, iCreditUnit, cCategory, retActive
		from progcourse a, depts b, courses c
		where a.cdeptId = b.cdeptId 
		and a.cCourseId = c.cCourseId
		and a.tSemester = ?
		and b.cFacultyId = ? and  a.cProgrammeId = ?
		$selected_curr
		and a.cdel = 'N'
		order by siLevel, tSemester, cCourseId");
		$stmt->bind_param("iss", $_REQUEST['coursesemester_h2'], $_REQUEST['cFacultyIdold'],  $_REQUEST['cprogrammeIdold']);
	}else
	{
		$stmt = $mysqli->prepare("select a.siLevel, a.tSemester, a.cCourseId, c.vCourseDesc, iCreditUnit, cCategory, retActive
		from progcourse a, depts b, courses c
		where a.cdeptId = b.cdeptId 
		and a.cCourseId = c.cCourseId
		and b.cFacultyId = ? and  a.cProgrammeId = ?
		$selected_curr
		and a.cdel = 'N'
		order by  siLevel, tSemester, cCourseId");
		$stmt->bind_param("ss", $_REQUEST['cFacultyIdold'],  $_REQUEST['cprogrammeIdold']);
	}
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($siLevel3, $tSemester3, $cCourseId3, $vCourseDesc3, $iCreditUnit3, $cCategory3, $retActive);?>
	
	<ul id="reg_courses_ec" class="checklist cl1" style="float:left; width:49%; margin-left:0px; height:469px; overflow:auto; overflow-x: hidden;"><?php
		$numOfiputTag = -1; $prev_dept = ''; $prev_fac = ''; $prev_dept = ''; $prevLevel = ''; $prevSemester = '';
		while($stmt->fetch())
		{
			$tSemester_desc = 'First';
			if ($tSemester3 == 2){$tSemester_desc = 'Second';}
			
			if(($prevLevel = '' || $prevLevel <> $siLevel3) || ($prevSemester = '' || $prevSemester <> $tSemester3))
			{?>
				<li style="height:auto; line-height:1.8;">
					<div style="padding:0.4%; border-radius:0px; font-weight:bold">
						<b><?php echo $siLevel3.'Level, '.$tSemester_desc.' semester';?></b>
					</div>
				</li><?php
			}
			$numOfiputTag++;?>
			
			<li id="ali<?php echo $c;?>" style="text-align:left; font-size:11px; height:auto;"<?php if ($numOfiputTag%2 == 0){echo ' class="alt"';}?> title="Click to remove course" 
				onclick="this.parentNode.removeChild(this);">
				<input name="regCourses<?php echo $numOfiputTag ?>_ec" id="regCourses<?php echo $numOfiputTag ?>_ec" type="hidden" 
					value="<?php echo $cCategory3.$retActive.$cCourseId3;?>"/>
				<div class="chkboxNoDiv" style="width:5%; padding:0.8%; padding-top:1.5%; padding-bottom:1.5%;"><?php echo ($numOfiputTag+1);?></div>
				<div class="ccodeDiv" style="width:8.5%; padding:0.8%; padding-top:1.5%; padding-bottom:1.5%;">
					<?php echo $cCourseId3;?>
				</div>
				<div class="singlecharDiv" style="width:5%; padding:0.8%; padding-top:1.5%; padding-bottom:1.5%;">
					<?php echo $cCategory3;?>
				</div>
				<div class="singlecharDiv" style="width:5%; padding:0.8%; padding-top:1.5%; padding-bottom:1.5%;">
					<?php echo $iCreditUnit3;?>
				</div>
				<div class="singlecharDiv" style="width:5%; padding:0.8%; padding-top:1.5%; padding-bottom:1.5%;">
					<?php if ($retActive == '0')
					{
						echo 'NR';
					}else if ($retActive == '1')
					{
						echo 'RA';
					}else
					{
						echo 'NA';
					}?>
				</div>								
				<div class="ctitle_right" style="width:60.8%; padding:0.8%; padding-top:1.5%; padding-bottom:1.5%;">
					<?php echo $vCourseDesc3;?>
				</div>
			</li><?php
			$prevLevel = $siLevel3;
			$prevSemester = $tSemester3;
		}
		$stmt->close();?>
	</ul>

	<div class="innercont_stff" style="width:100%;">
		<div style="float:right">                            
			<a href="#" class="basic_three_sm_stff"
			style="width:85px; padding:9px; margin:0px; display:block" 
			onclick="sets.save.value='1';
			chk_inputs();return false">Submit</a>
		</div>
								
		<div style="float:right; margin-right:10px">                            
			<a href="#" class="basic_three_sm_stff"
			style="width:85px; padding:9px; margin:0px; display:block" 
			onclick="sets.save.value='2';
			chk_inputs();return false">Clear all</a>
		</div>
	</div>
</div>
    <?php admin_frms(); $has_matno = 0;?>
	
	<form action="staff_home_page" method="post" name="nxt" id="nxt" enctype="multipart/form-data">
		<input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
        <input name="uvApplicationNo" id="uvApplicationNo" type="hidden" />
		<input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST['vMatricNo'])){echo $_REQUEST['vMatricNo']; }?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
		<input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
		
		<input name="mm" id="mm" type="hidden" value="<?php if (isset($_REQUEST["mm"])){echo $_REQUEST["mm"];} ?>" />
		<input name="mm_desc" id="mm_desc" type="hidden" value="<?php if (isset($_REQUEST["mm_desc"])){echo $_REQUEST["mm_desc"];} ?>" />
		<input name="sm" id="sm" type="hidden" value="<?php if (isset($_REQUEST["sm"])){echo $_REQUEST["sm"];} ?>" />
		<input name="sm_desc" id="sm_desc" type="hidden"  value="<?php if (isset($_REQUEST["sm_desc"])){echo $_REQUEST["sm_desc"];} ?>"/>

		<input name="contactus" id="contactus" type="hidden" />
		<input name="what" id="what" type="hidden" />
		
		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($service_mode)&&$service_mode<>''){echo $service_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($service_centre)&&$service_centre<>''){echo $service_centre;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form><?php
	//include ('msg_service.php');?>
	
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
<div id="container">
	<div id="green_smke_screen" class="smoke_scrn" style="display:none; z-index:-1"></div>
	
	<div id="green_info_box" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
		<div id="msg_title" style="width:350px; float:left; text-align:left; padding:0px; color:#36743e; font-weight:bold">
			Information
		</div>
		<a href="#" style="text-decoration:none;">
			<div id="msg_title" style="width:20px; float:left; text-align:center; padding:0px;"></div>
		</a>
		<div id="green_msg_msg" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#36743e;">
		<?php echo $msg;?>
		</div>
		<div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
			<a href="#" style="text-decoration:none;" 
				onclick="_('green_smke_screen').style.display= 'none';
				_('green_smke_screen').style.zIndex= '-1';
				_('green_info_box').style.display= 'none';
				_('green_info_box').style.zIndex= '-1';
				return false">
				<div class="submit_button_home" style="width:60px; padding:6px; float:right">
					Ok
				</div>
			</a>
		</div>
	</div><?php
	time_out_box($currency);?>

	<noscript>
		<div class="smoke_scrn" style="display:block"></div>
		<?php information_box_inline('You need to enable javascript for this browser');?>
	</noscript>
	<?php do_toup_div('Student Management System');?>
	<div id="menubar">
		<!-- InstanceBeginEditable name="menubar" -->
		<?php require_once ('menu_bar_content_stff.php');?>
		<!-- InstanceEndEditable -->
	</div>

	<div id="leftSide_std" style="margin-left:0px;"><?php
		require_once ('stff_left_side_menu.php');?>
	</div>
	<div id="rtlft_std" style="position:relative;">
		<!-- InstanceBeginEditable name="EditRegion6" --><?php
			if ($currency == '1')
            {?>
				<select name="cdeptId_readup" id="cdeptId_readup" style="display:none"><?php	
					$sql = "select cFacultyId, cdeptId, concat(cdeptId,' ',vdeptDesc) vdeptDesc from depts where cDelFlag = 'N' order by cFacultyId, cdeptId, vdeptDesc";
					$rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
					while ($rs = mysqli_fetch_array($rssql))
					{?>
						<option value="<?php echo $rs['cFacultyId']. $rs['cdeptId']?>"><?php echo $rs['vdeptDesc'];?></option><?php
					}
					mysqli_close(link_connect_db());?>
				</select>

				<select name="cprogrammeId_readup" id="cprogrammeId_readup" style="display:none"><?php	
					// $sql = "select s.cdeptId, p.cProgrammeId,p.vProgrammeDesc,o.vObtQualTitle 
					// from programme p, obtainablequal o, depts s
					// where p.cObtQualId = o.cObtQualId 
					// and s.cdeptId = p.cdeptId
					// and p.cDelFlag = s.cDelFlag
					// and p.cDelFlag = 'N'
					// order by s.cdeptId, p.cProgrammeId";

					$sql = "select s.cdeptId, p.cProgrammeId,p.vProgrammeDesc,o.vObtQualTitle 
					from programme p, obtainablequal o, depts s
					where p.cObtQualId = o.cObtQualId 
					and s.cdeptId = p.cdeptId
					and p.cDelFlag = 'N'
					order by s.cdeptId, p.cProgrammeId";
					$rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
					while ($rs = mysqli_fetch_array($rssql))
					{
						$vProgrammeDesc_01 = $rs['vProgrammeDesc'];
						if (!is_bool(strpos($rs['vProgrammeDesc'],"(d)")))
						{
							$vProgrammeDesc_01 = substr($rs['vProgrammeDesc'], 0, strlen($rs['vProgrammeDesc'])-4);
						}?>
						<option value="<?php echo $rs['cdeptId']. $rs['cProgrammeId']?>"><?php echo str_pad($rs['vObtQualTitle'], 10, " ", STR_PAD_LEFT).' '.$vProgrammeDesc_01; ?></option><?php
					}
					mysqli_close(link_connect_db());?>
				</select>
					
				<select name="courseId_readup" id="courseId_readup" style="display:none"><?php	
					$sql = "SELECT concat(lpad(b.siLevel,3,'0'),' ',b.cProgrammeId,' ',a.cCourseId,' ',a.cdeptId) cCourseId, concat(a.tSemester,' ',a.iCreditUnit,' ',b.cCategory,' ',a.cCourseId,' ',a.vCourseDesc) vCourseDesc
					FROM courses_new a 
					INNER JOIN progcourse b 
					on a.cCourseId = b.cCourseId 
					INNER JOIN programme c 
					on b.cProgrammeId = c.cProgrammeId
					WHERE a.cdel = b.cdel
					AND c.cDelFlag = b.cdel
					AND c.cDelFlag = 'N'
					ORDER BY b.siLevel, a.tSemester, b.cCategory, a.cCourseId";
					$rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
					while ($rs = mysqli_fetch_array($rssql))
					{?>
						<option value="<?php echo $rs['cCourseId'];?>"><?php echo $rs['vCourseDesc']; ?></option><?php
					}
					mysqli_close(link_connect_db());?>
				</select>
					
				<select name="courseId_new_readup" id="courseId_new_readup" style="display:none"><?php	
					$sql = "select concat(lpad(b.siLevel,3,'0'),' ',b.cProgrammeId,' ',a.cCourseId,' ',a.cdeptId) cCourseId, concat(a.tSemester,' ',a.iCreditUnit,' ',b.cCategory,' ',a.cCourseId,' ',a.vCourseDesc) vCourseDesc
					from courses_new a 
					inner join progcourse b 
					on a.cCourseId = b.cCourseId 
					inner join programme c 
					on b.cProgrammeId = c.cProgrammeId
					where a.cdel = b.cdel
					and c.cDelFlag = b.cdel
					and c.cDelFlag = 'N'
					order by b.siLevel, a.tSemester, b.cCategory, a.cCourseId";
					$rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
					while ($rs = mysqli_fetch_array($rssql))
					{?>
						<option value="<?php echo $rs['cCourseId'];?>"><?php echo $rs['vCourseDesc']; ?></option><?php
					}
					mysqli_close(link_connect_db());?>
				</select>			
				
				<div id="smke_screen_2" class="smoke_scrn" style="display:none;"></div>
				
				<form action="show-report" method="post" name="prns_form" target="_blank" id="prns_form" enctype="multipart/form-data">
					<input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
					
					<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
					<input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["sm"])){ echo $_REQUEST['sm'];} ?>" />
					<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
					<input name="save" id="save" type="hidden" value="-1" />
					<input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />

					<input name="cFacultyId_prn" id="cFacultyId_prn" type="hidden" value="<?php if (isset($_REQUEST['cFacultyIdold'])){echo $_REQUEST['cFacultyIdold'];}?>" />
					
					<input name="vFacultyDesc_prn" id="vFacultyDesc_prn" type="hidden" value="<?php if (isset($_REQUEST['cFacultyDescNew_h'])){echo $_REQUEST['cFacultyDescNew_h'];} ?>" />
					
					<input name="cdept_prn" id="cdept_prn" type="hidden" value="<?php if (isset($_REQUEST['cdeptold'])){echo $_REQUEST['cdeptold'];}?>" />
					
					<input name="vdeptDesc_prn" id="vdeptDesc_prn" type="hidden" value="<?php if (isset($_REQUEST['cDeptDescNew_h'])){echo $_REQUEST['cDeptDescNew_h'];}?>" />
					
					<input name="cprogrammeId_prn" id="cprogrammeId_prn" type="hidden" value="<?php if (isset($_REQUEST['cprogrammeIdold'])){echo $_REQUEST['cprogrammeIdold'];}?>" />
					
					<input name="vProgrammeDesc_prn" id="vProgrammeDesc_prn" type="hidden" value="<?php if (isset($_REQUEST['cprogrammedescNew_h1'])){echo $_REQUEST['cprogrammedescNew_h1'];}?>" />
					
					<input name="courseLevel_prn" id="courseLevel_prn" type="hidden" value="<?php if (isset($_REQUEST['courseLevel'])){echo $_REQUEST['courseLevel'];}?>" />
					
					<input name="coursesemester_prn" id="coursesemester_prn" type="hidden" value="<?php if (isset($_REQUEST['coursesemester_h2'])){echo $_REQUEST['coursesemester_h2'];}?>" />
					<input name="select_curriculum_prn" id="select_curriculum_prn" type="hidden" value="<?php if (isset($_REQUEST['select_curriculum_prn'])){echo $_REQUEST['select_curriculum_prn'];}?>" />
					
					<input name="what_to_do_frn" id="what_to_do_frn" type="hidden" value="<?php if (isset($_REQUEST['what_to_do'])){echo $_REQUEST['what_to_do'];}?>" />
					<input name="on_what_frn" id="on_what_frn" type="hidden" value="<?php if (isset($_REQUEST['on_what'])){echo $_REQUEST['on_what'];}?>" />
					<input name="study_mode_ID" id="study_mode_ID" type="hidden" value="odl" />
				</form>
				
				<div id="page_title" style="float:left;" class="innercont_top">Composition of faculties, departments, programmes and courses</div>
				
				<div id="structure" class="innercont_stff" style="height:auto; margin-top:0px; margin-bottom:3.5%; font-size:0.9em; position:relative;">
					<div id="level3_opts" style="width:100%; float:left; border-radius:0px; position:absolute; left:0; top:0; background:#FFF; display:block"><?php
						if (check_scope3('Faculty', 'Faculties, departent, programmes', 'Create Facult') > 0)
						{
							if (isset($_REQUEST['what_to_do'])&&$_REQUEST['what_to_do']=='0'&&isset($_REQUEST['on_what'])&&$_REQUEST['on_what']=='0')
							{?>
								<div id="tabss0_0" class="rtlft_inner_button" style="margin-left:0%;
									border-left:1px solid #2b8007;
									border-right:1px solid #2b8007;
									background-color:#2b8007;
									color:#FFFFFF;
									width:5.28%; padding:0.3%;
									display:block;
									text-align:center;
									text-indent:0px;">
										Create faculty
								</div><?php
							}else
							{?>
								
								<a href="#" style="text-decoration:none;" 
									onclick="_('save').value = '-1';
									_('frm_upd').value = 'ff';
									_('what_to_do_frn').value=0;
									_('what_to_do').value=0;
									_('on_what_frn').value=0;
									_('on_what').value=0;
									show_proper(_('what_to_do').value,_('on_what').value);
									tab_modify(0);
									_('page_title').innerHTML = 'Create faculty';
									return false">
									<div id="tabss0" class="rtlft_inner_button" style="width:5.2%; padding:0.3%; text-align:center; text-indent:0px;">
										Create faculty
									</div>
								</a><?php
							}
						}
						
						if (check_scope3('Faculty', 'Faculties, departent, programmes', 'Create Department') > 0)
						{
							if (isset($_REQUEST['what_to_do'])&&$_REQUEST['what_to_do']=='0'&&isset($_REQUEST['on_what'])&&$_REQUEST['on_what']=='1')
							{?>
								<div id="tabss1_0" class="rtlft_inner_button" style="margin-left:0%;
									background-color:#2b8007;
									color:#FFFFFF;
									width:5.28%; padding:0.3%;
									display:block;
									text-align:center;
									text-indent:0px;" title="Create department">
										Create Dept
								</div><?php
							}else
							{?>
								<a href="#" style="text-decoration:none;" 
									onclick="_('save').value = '-1';
									_('frm_upd').value = 'ff';
									_('what_to_do_frn').value=0;
									_('what_to_do').value=0;
									_('on_what_frn').value=1;
									_('on_what').value=1;
									show_proper(_('what_to_do').value,_('on_what').value);
									tab_modify(1);
									_('page_title').innerHTML = 'Create department';
									return false">
									<div id="tabss1" class="rtlft_inner_button" style="width:5.28%; padding:0.3%; text-align:center; text-indent:0px;" title="Create department">
										Create Dept
									</div>
								</a><?php
							}
						}
						
						if (check_scope3('Faculty', 'Faculties, departent, programmes', 'Create Programme') > 0)
						{
							if (isset($_REQUEST['what_to_do'])&&$_REQUEST['what_to_do']=='0'&&isset($_REQUEST['on_what'])&&$_REQUEST['on_what']=='2')
							{?>
								<div id="tabss2_0" class="rtlft_inner_button" style="margin-left:0%;
									background-color:#2b8007;
									color:#FFFFFF;
									width:5.28%; padding:0.3%;
									display:block;
									text-align:center;
									text-indent:0px;" title="Create programme">
										Create Prog
								</div><?php
							}else
							{?>
								<a href="#" style="text-decoration:none;" 
									onclick="_('save').value = '-1';
									_('frm_upd').value = 'ff';
									_('what_to_do_frn').value=0;
									_('what_to_do').value=0;
									_('on_what_frn').value=2;
									_('on_what').value=2;
									show_proper(_('what_to_do').value,_('on_what').value);
									tab_modify(2);
									_('page_title').innerHTML = 'Create programme';
									return false">
									<div id="tabss2" class="rtlft_inner_button" style="width:5.28%; padding:0.3%; text-align:center; text-indent:0px;" title="Create programme">
										Create Prog
									</div>
								</a><?php
							}
						}
						
						if (check_scope3('Faculty', 'Faculties, departent, programmes', 'Create Course') > 0)
						{
							if (isset($_REQUEST['what_to_do'])&&$_REQUEST['what_to_do']=='0'&&isset($_REQUEST['on_what'])&&$_REQUEST['on_what']=='3')
							{?>
								<div id="tabss3_0" class="rtlft_inner_button" style="margin-left:0%; 
									border-left:1px solid #2b8007;
									border-right:1px solid #2b8007;
									background-color:#2b8007;
									color:#FFFFFF;
									width:5.28%; padding:0.3%;
									display:block;
									text-align:center;
									text-indent:0px;">
										Create Course
								</div><?php
							}else
							{?>
								<a href="#" style="text-decoration:none;" 
									onclick="_('save').value = '-1';
									_('frm_upd').value = 'ff';
									_('what_to_do_frn').value=0;
									_('what_to_do').value=0;
									_('on_what_frn').value=3;
									_('on_what').value=3;
									show_proper(_('what_to_do').value,_('on_what').value);
									tab_modify(3);
									_('page_title').innerHTML = 'Create course';
									return false">
									<div id="tabss3" class="rtlft_inner_button" style="width:5.28%; padding:0.3%; text-align:center; text-indent:0px;">
										Create Course
									</div>
								</a><?php
							}
						}
						
						
						if (check_scope3('Faculty', 'Faculties, departent, programmes', 'Edit Faculty') > 0)
						{
							if (isset($_REQUEST['what_to_do'])&&$_REQUEST['what_to_do']=='1'&&isset($_REQUEST['on_what'])&&$_REQUEST['on_what']=='0')
							{?>
								<div id="tabss4_0" class="rtlft_inner_button" style="margin-left:0%;
									background-color:#2b8007;
									color:#FFFFFF;
									width:5.28%; padding:0.3%;
									display:block;
									text-align:center;
									text-indent:0px;">
										Edit Faculty
								</div><?php
							}else
							{?>
								<a href="#" style="text-decoration:none;" 
									onclick="_('save').value = '-1';
									_('frm_upd').value = 'ff';
									_('what_to_do_frn').value=1;
									_('what_to_do').value=1;
									_('on_what_frn').value=0;
									_('on_what').value=0;
									show_proper(_('what_to_do').value,_('on_what').value);
									tab_modify(4);
									_('page_title').innerHTML = 'Edit faculty';
									return false">
									<div id="tabss4" class="rtlft_inner_button" style="width:5.28%; padding:0.3%; text-align:center; text-indent:0px;">
										Edit Faculty
									</div>
								</a><?php
							}
						}
													
						if (check_scope3('Faculty', 'Faculties, departent, programmes', 'Edit Department') > 0)
						{
							if (isset($_REQUEST['what_to_do'])&&$_REQUEST['what_to_do']=='1'&&isset($_REQUEST['on_what'])&&$_REQUEST['on_what']=='1')
							{?>
								<div id="tabss5_0" class="rtlft_inner_button" style="margin-left:0%;
									background-color:#2b8007;
									color:#FFFFFF;
									width:5.28%; padding:0.3%;
									display:block;
									text-align:center;
									text-indent:0px;">
										Edit Dept
								</div><?php
							}else
							{?>
								<a href="#" style="text-decoration:none;" 
									onclick="_('save').value = '-1';
									_('frm_upd').value = 'ff';
									_('what_to_do_frn').value=1;
									_('what_to_do').value=1;
									_('on_what_frn').value=1;
									_('on_what').value=1;
									show_proper(_('what_to_do').value,_('on_what').value);
									tab_modify(5);
									_('page_title').innerHTML = 'Edit department';
									return false">
									<div id="tabss5" class="rtlft_inner_button" style="width:5.28%; padding:0.3%; text-align:center; text-indent:0px;" title="Edit department">
										Edit<br>Dept
									</div>
								</a><?php
							}
						}
													
						if (check_scope3('Faculty', 'Faculties, departent, programmes', 'Edit Programme') > 0)
						{
							if (isset($_REQUEST['what_to_do'])&&$_REQUEST['what_to_do']=='1'&&isset($_REQUEST['on_what'])&&$_REQUEST['on_what']=='2')
							{?>
								<div id="tabss6_0" class="rtlft_inner_button" style="margin-left:0%;
									background-color:#2b8007;
									color:#FFFFFF;
									width:5.28%; padding:0.3%;
									display:block;
									text-align:center;
									text-indent:0px;">
										Edit<br>Prog
								</div><?php
							}else
							{?>
								<a href="#" style="text-decoration:none;" 
									onclick="_('save').value = '-1';
									_('frm_upd').value = 'ff';
									_('what_to_do_frn').value=1;
									_('what_to_do').value=1;
									_('on_what_frn').value=2;
									_('on_what').value=2;
									show_proper(_('what_to_do').value,_('on_what').value);
									tab_modify(6);
									_('page_title').innerHTML = 'Edit programme';
									return false">
									<div id="tabss6" class="rtlft_inner_button" style="width:5.28%; padding:0.3%; text-align:center; text-indent:0px;" title="Edit programme">
										Edit<br>Prog
									</div>
								</a><?php
							}
						}							
													
						if (check_scope3('Faculty', 'Faculties, departent, programmes', 'Edit Course') > 0)
						{
							if (isset($_REQUEST['what_to_do'])&&$_REQUEST['what_to_do']=='1'&&isset($_REQUEST['on_what'])&&$_REQUEST['on_what']=='3')
							{?>
								<div id="tabss7_0" class="rtlft_inner_button" style="margin-left:0%;
									background-color:#2b8007;
									color:#FFFFFF;
									width:5.28%; padding:0.3%;										 
									display:block;
									text-align:center;
									text-indent:0px;">
										Edit<br>Course
								</div><?php
							}else
							{?>
								<a href="#" style="text-decoration:none;" 
									onclick="_('save').value = '-1';
									_('frm_upd').value = 'ff';
									_('what_to_do_frn').value=1;
									_('what_to_do').value=1;
									_('on_what_frn').value=3;
									_('on_what').value=3;
									show_proper(_('what_to_do').value,_('on_what').value);
									tab_modify(7);
									_('page_title').innerHTML = 'Edit course';
									return false">
									<div id="tabss7" class="rtlft_inner_button" style="width:5.28%; padding:0.3%; text-align:center; text-indent:0px;">
										Edit Course
									</div>
								</a><?php
							}
						}
						
						
						if (check_scope3('Faculty', 'Faculties, departent, programmes', 'Delete Faculty') > 0)
						{
							if (isset($_REQUEST['what_to_do'])&&$_REQUEST['what_to_do']=='2'&&isset($_REQUEST['on_what'])&&$_REQUEST['on_what']=='0')
							{?>
								<div id="tabss8_0" class="rtlft_inner_button" style="margin-left:0%;
									background-color:#2b8007;
									color:#FFFFFF;
									width:5.28%; padding:0.3%;
									display:block;
									text-align:center;
									text-indent:0px;">
										Delete Faculty
								</div><?php
							}else
							{?>
								<a href="#" style="text-decoration:none;" 
									onclick="_('save').value = '-1';
									_('frm_upd').value = 'ff';
									_('what_to_do_frn').value=2;
									_('what_to_do').value=2;
									_('on_what_frn').value=0;
									_('on_what').value=0;
									show_proper(_('what_to_do').value,_('on_what').value);
									tab_modify(8);
									_('page_title').innerHTML = 'Delete faculty';
									return false">
									<div id="tabss8" class="rtlft_inner_button" style="width:5.28%; padding:0.3%; text-align:center; text-indent:0px;">
										Delete Faculty
									</div>
								</a><?php
							}
						}
													
						if (check_scope3('Faculty', 'Faculties, departent, programmes', 'Delete Department') > 0)
						{
							if (isset($_REQUEST['what_to_do'])&&$_REQUEST['what_to_do']=='2'&&isset($_REQUEST['on_what'])&&$_REQUEST['on_what']=='1')
							{?>
								<div id="tabss9_0" class="rtlft_inner_button" style="margin-left:0%;
									background-color:#2b8007;
									color:#FFFFFF;
									width:5.28%; padding:0.3%;
									display:block;
									text-align:center;
									text-indent:0px;">
										Delete Dept
								</div><?php
							}else
							{?>
								<a href="#" style="text-decoration:none;" 
									onclick="_('save').value = '-1';
									_('frm_upd').value = 'ff';
									_('what_to_do_frn').value=2;
									_('what_to_do').value=2;
									_('on_what_frn').value=1;
									_('on_what').value=1;
									show_proper(_('what_to_do').value,_('on_what').value);
									tab_modify(9);
									_('page_title').innerHTML = 'Delete department';
									return false">
									<div id="tabss9" class="rtlft_inner_button" style="width:5.28%; padding:0.3%; text-align:center; text-indent:0px;" title="Delete Department">
										Delete Dept
									</div>
								</a><?php
							}
						}							
													
						if (check_scope3('Faculty', 'Faculties, departent, programmes', 'Delete Programme') > 0)
						{
							if (isset($_REQUEST['what_to_do'])&&$_REQUEST['what_to_do']=='2'&&isset($_REQUEST['on_what'])&&$_REQUEST['on_what']=='2')
							{?>
								<div id="tabss10_0" class="rtlft_inner_button" style="margin-left:0%;
									background-color:#2b8007;
									color:#FFFFFF;
									width:5.28%; padding:0.3%;
									display:block;
									text-align:center;
									text-indent:0px;">
										Delete Prog
								</div><?php
							}else
							{?>
								<a href="#" style="text-decoration:none;" 
									onclick="_('save').value = '-1';
									_('frm_upd').value = 'ff'
									_('what_to_do_frn').value=2;
									_('what_to_do').value=2;
									_('on_what_frn').value=2;
									_('on_what').value=2;
									show_proper(_('what_to_do').value,_('on_what').value);
									tab_modify(10);
									_('page_title').innerHTML = 'Delete programme';
									return false">
									<div id="tabss10" class="rtlft_inner_button" style="width:5.28%; padding:0.3%; text-align:center; text-indent:0px;" title="Delete Programme">
										Delete Prog
									</div>
								</a><?php
							}
						}
						
						if (check_scope3('Faculty', 'Faculties, departent, programmes', 'Delete Course') > 0)
						{
							if (isset($_REQUEST['what_to_do'])&&$_REQUEST['what_to_do']=='2'&&isset($_REQUEST['on_what'])&&$_REQUEST['on_what']=='3')
							{?>
								<div id="tabss11_0" class="rtlft_inner_button" style="margin-left:0%;
									background-color:#2b8007;
									color:#FFFFFF;
									width:5.28%; padding:0.3%;
									display:block;
									text-align:center;
									text-indent:0px;">
										Delete Course
								</div><?php
							}else
							{?>
								<a href="#" style="text-decoration:none;" 
									onclick="_('save').value = '-1';
									_('frm_upd').value = 'ff';
									_('what_to_do_frn').value=2;
									_('what_to_do').value=2;
									_('on_what_frn').value=3;
									_('on_what').value=3;
									show_proper(_('what_to_do').value,_('on_what').value);
									tab_modify(11);
									_('page_title').innerHTML = 'Delete course';
									return false">
									<div id="tabss11" class="rtlft_inner_button" style="width:5.28%; padding:0.3%; text-align:center; text-indent:0px;">
										Delete Course
									</div>
								</a><?php
							}
						}
						

						if (check_scope3('Faculty', 'Faculties, departent, programmes', 'Add/remove Courses') > 0)
						{
							if (isset($_REQUEST['what_to_do'])&&$_REQUEST['what_to_do']=='3'&&isset($_REQUEST['on_what'])&&$_REQUEST['on_what']=='3')
							{?>
								<div id="tabss12_0" class="rtlft_inner_button" style="margin-left:0%;
									background-color:#2b8007;
									color:#FFFFFF;
									width:5.28%; padding:0.3%;
									display:block;
									text-align:center;
									text-indent:0px;" title="Add or remove course from programme">
										+/-<br>Course
								</div>
								<a href="#" style="text-decoration:none;" 
									onclick="_('save').value = '-1';
									_('frm_upd').value = 'ff';
									_('what_to_do_frn').value=3;
									_('what_to_do').value=3;
									_('on_what_frn').value=3;
									_('on_what').value=3;
									show_proper(_('what_to_do').value,_('on_what').value);
									tab_modify(12);
									_('page_title').innerHTML = 'Add/Remove course from programme';
									return false">
									<div id="tabss12" class="rtlft_inner_button" style="width:5.28%; padding:0.3%; display:none; text-align:center; text-indent:0px;" title="Add or remove course from programme">
										+/-<br>Course
									</div>
								</a><?php
							}else
							{?>
								<a href="#" style="text-decoration:none;" 
									onclick="_('save').value = '-1';
									_('frm_upd').value = 'ff';
									_('what_to_do_frn').value=3;
									_('what_to_do').value=3;
									_('on_what_frn').value=3;
									_('on_what').value=3;
									show_proper(_('what_to_do').value,_('on_what').value);
									tab_modify(12);
									_('page_title').innerHTML = 'Add or remove course from programme';
									return false">
									<div id="tabss12" class="rtlft_inner_button" style="width:5.28%; padding:0.3%; text-align:center; text-indent:0px;" title="Add or remove course">
										+/-<br>Course
									</div>
								</a><?php
							}
						}
						

						if (check_scope3('Faculty', 'Faculties, departent, programmes', 'View Faculty') > 0)
						{
							if (isset($_REQUEST['what_to_do'])&&$_REQUEST['what_to_do']=='4'&&isset($_REQUEST['on_what'])&&$_REQUEST['on_what']=='0')
							{?>
								<div id="tabss13_0" class="rtlft_inner_button" style="margin-left:0%;
									background-color:#2b8007;
									color:#FFFFFF;
									width:5.28%; padding:0.3%;
									display:block;
									text-align:center;
									text-indent:0px;">
										View Faculty
								</div><?php
							}else
							{?>
								<a href="#" style="text-decoration:none;" 
									onclick="_('save').value = '-1';
									_('frm_upd').value = 'ff';
									_('what_to_do_frn').value=4;
									_('what_to_do').value=4;
									_('on_what_frn').value=0;
									_('on_what').value=0;
									show_proper(_('what_to_do').value,_('on_what').value);
									tab_modify(13);
									_('page_title').innerHTML = 'View faculty';
									return false">
									<div id="tabss13" class="rtlft_inner_button" style="width:5.28%; padding:0.3%; text-align:center; text-indent:0px;">
										View Faculty
									</div>
								</a><?php
							}
						}

						if (check_scope3('Faculty', 'Faculties, departent, programmes', 'View Department') > 0)
						{
							if (isset($_REQUEST['what_to_do'])&&$_REQUEST['what_to_do']=='4'&&isset($_REQUEST['on_what'])&&$_REQUEST['on_what']=='1')
							{?>
								<div id="tabss14_0" class="rtlft_inner_button" style="margin-left:0%;
									background-color:#2b8007;
									color:#FFFFFF;
									width:5.28%; padding:0.3%;
									display:block;
									text-align:center;
									text-indent:0px;" title="Add or remove course">
										View<br>Dept
								</div><?php
							}else
							{?>
								<a href="#" style="text-decoration:none;" 
									onclick="_('save').value = '-1';
									_('frm_upd').value = 'ff';
									_('what_to_do_frn').value=4;
									_('what_to_do').value=4;
									_('on_what_frn').value=1;
									_('on_what').value=1;
									show_proper(_('what_to_do').value,_('on_what').value);
									tab_modify(14);
									_('page_title').innerHTML = 'View department';
									return false">
									<div id="tabss14" class="rtlft_inner_button" style="width:5.28%; padding:0.3%; text-align:center; text-indent:0px;" title="View Department">
										View<br>Dept
									</div>
								</a><?php
							}
						}

						if (check_scope3('Faculty', 'Faculties, departent, programmes', 'View Programme') > 0)
						{
							if (isset($_REQUEST['what_to_do'])&&$_REQUEST['what_to_do']=='4'&&isset($_REQUEST['on_what'])&&$_REQUEST['on_what']=='2')
							{?>
								<div id="tabss15_0" class="rtlft_inner_button" style="margin-left:0%;
									background-color:#2b8007;
									color:#FFFFFF;
									width:5.28%; padding:0.3%;
									display:block;
									text-align:center;
									text-indent:0px;" title="Add or remove course">
										View<br>Prog
								</div><?php
							}else
							{?>
								<a href="#" style="text-decoration:none;" 
									onclick="_('save').value = '-1';
									_('frm_upd').value = 'ff';
									_('what_to_do_frn').value=4;
									_('what_to_do').value=4;
									_('on_what_frn').value=2;
									_('on_what').value=2;
									show_proper(_('what_to_do').value,_('on_what').value);
									tab_modify(15);
									_('page_title').innerHTML = 'View programme';
									return false">
									<div id="tabss15" class="rtlft_inner_button" style="width:5.28%; padding:0.3%; text-align:center; text-indent:0px;" title="View Programme">
										View<br>Prog
									</div>
								</a><?php
							}
						}

						if (check_scope3('Faculty', 'Faculties, departent, programmes', 'View Course') > 0)
						{
							if (isset($_REQUEST['what_to_do'])&&$_REQUEST['what_to_do']=='4'&&isset($_REQUEST['on_what'])&&$_REQUEST['on_what']=='3')
							{?>
								<div id="tabss16_0" class="rtlft_inner_button" style="margin-left:0%;
									background-color:#2b8007;
									color:#FFFFFF;
									width:5.28%; padding:0.3%;
									display:block;
									text-align:center;
									text-indent:0px;">
										View<br>Course
								</div><?php
							}else
							{?>
								<a href="#" style="text-decoration:none;" 
									onclick="_('save').value = '-1';
									_('frm_upd').value = 'ff';
									_('what_to_do_frn').value=4;
									_('what_to_do').value=4;
									_('on_what_frn').value=3;
									_('on_what').value=3;
									show_proper(_('what_to_do').value,_('on_what').value);
									tab_modify(16);
									_('page_title').innerHTML = 'View course';
									return false">
									<div id="tabss16" class="rtlft_inner_button" style="width:5.28%; padding:0.3%; text-align:center; text-indent:0px;">
										View<br>Course
									</div>
								</a><?php
							}
						}?>
					</div>
				</div><?php
						
				$sho3 = 'none';
				if (isset($_REQUEST['what_to_do']) && $_REQUEST['what_to_do'] == 3 && isset($_REQUEST['on_what']) && $_REQUEST['on_what'] == 3){$sho3 = 'block';}?>

				<div id="inner_structure" class="innercont_stff" style="margin-top:20px; height:82.4%; padding-bottom:0.5%; display:<?php echo $sho3;?>; overflow:auto; overflow-x: hidden;">
					<form method="post" id="sets" name="sets" enctype="multipart/form-data">
						<input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
						<input name="uvApplicationNo" type="hidden" value="<?php  if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
						<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
						<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
						
						<input name="mm" id="mm" type="hidden" value="<?php if (isset($_REQUEST["mm"])){ echo $_REQUEST['mm'];} ?>" />
						<input name="sm" id="sm" type="hidden" value="<?php if (isset($_REQUEST["sm"])){ echo $_REQUEST['sm'];} ?>" />
						<input name="save" id="save" type="hidden" value="-1" />
						<input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
						<input name="frm_upd" id="frm_upd" type="hidden" value="0" />
						<input name="confam" id="confam" type="hidden" value="0" />
						<input name="warned1" id="warned1" type="hidden" value="0" />
						<input name="warned2" id="warned2" type="hidden" value="0" />
						<input name="returnedStr" id="returnedStr" type="hidden" />
						<input name="pc_char" id="pc_char" type="hidden" value="<?php echo $orgsetins['pc_char']; ?>" />
						<input name="cc_char" id="cc_char" type="hidden" value="<?php echo $orgsetins['cc_char']; ?>" />
						
						<input name="userInfo_f" id="userInfo_f" type="hidden" value="<?php echo $cFacultyId_u;?>" />
						<input name="userInfo_d" id="userInfo_d" type="hidden" value="<?php echo $cdeptId_u; ?>" />
						<input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID_u; ?>" />
						<input name="study_mode_ID" id="study_mode_ID" type="hidden" value="odl" />

						<input name="study_mode" id="study_mode" type="hidden" value="odl" />	

						<input name="service_mode" id="service_mode" type="hidden" 
						value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
						else if (isset($study_mode)){echo $study_mode;}?>" />
						<input name="num_of_mode" id="num_of_mode" type="hidden" 
						value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
						else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

						<input name="user_centre" id="user_centre" type="hidden" 
						value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
						else if (isset($study_mode)){echo $study_mode;}?>" />
						<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
						value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
						else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />

						<input name="what_to_do" id="what_to_do" type="hidden" value="<?php if(isset($_REQUEST['what_to_do'])){echo $_REQUEST['what_to_do'];}else{echo '-1';}?>" />
						<input name="on_what" id="on_what" type="hidden" value="<?php if(isset($_REQUEST['on_what'])){echo $_REQUEST['on_what'];}else{echo '-1';}?>" />
						

						<div id="cFacultyIdold_div" class="setup_fac_dummy_lass innercont_stff" style="margin-top:0.5%; display:<?php echo $sho3;?>">
							<label for="cFacultyIdold" class="labell_structure">Faculty</label>
							<div class="div_select">
								<select name="cFacultyIdold" id="cFacultyIdold" class="select" 
									onchange="if(sets.userInfo_f.value==this.value||_('what_to_do').value==4 || _('sRoleID').value==6)
									{
										_('confam').value='0';
										_('warned1').value='0';
										_('warned2').value='0';
										_('labell_msg15').style.display='none';
												
										_('cdeptold').length = 0;
										_('cdeptold').options[_('cdeptold').options.length] = new Option('', '');
												
										_('cprogrammeIdold').length = 0;
										_('cprogrammeIdold').options[_('cprogrammeIdold').options.length] = new Option('', '');
												
										_('ccourseIdold').length = 0;
										_('ccourseIdold').options[_('ccourseIdold').options.length] = new Option('', '');
										update_cat_country('cFacultyIdold', 'cdeptId_readup', 'cdeptold', 'cprogrammeIdold');
												
										if(_('what_to_do').value=='1'&&_('on_what').value=='2')
										{
												_('cprogrammeIdNew').value = ''; 
												_('cprogrammetitleNew').value = ''; 
												_('cprogrammedescNew').value = ''; 
												_('BeginLevel').value = ''; 
												_('EndLevel').value = ''; 
												_('grdtce').value = ''; 
												_('grdtce2').value = '';
												_('max_crload').value = ''; 
										}
										_('cFacultyDescNew_h').value=this.options[this.selectedIndex].text.substr(4,this.options[this.selectedIndex].text.length-1);
										
										if(_('what_to_do').value=='0'&&_('on_what').value=='1'&&!(_('what_to_do').value=='3'&&_('on_what').value=='3'))
										{															
											_('new_cFacultyIdold').value='';
											if(_('what_to_do').value=='1'&&_('on_what').value>0){_('new_cdeptold').value='';}
											form_code(this.options[this.selectedIndex].text.substr(4,this.options[this.selectedIndex].text.length-1));
										}
										_('cFacultyId_prn').value=this.value;
										_('vFacultyDesc_prn').value=this.options[this.selectedIndex].text;
												
										_('cdept_prn').value='';
										_('vdeptDesc_prn').value='';
									}else if (_('what_to_do').value!=4 && _('sRoleID').value!=6)
									{
										setMsgBox('labell_msg15','You can only work in your own faculty');
										this.value='';
										this.focus();
									}">
									<option value="" selected="selected">Select a faculty</option><?php
										$sql1 = "SELECT cFacultyId, concat(cFacultyId,' ',vFacultyDesc) vFacultyDesc FROM faculty WHERE cCat = 'A' AND cDelFlag = 'N' ORDER BY vFacultyDesc";
										$rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));
										while ($table= mysqli_fetch_array($rsql1))
										{?>
											<option value="<?php echo $table[0] ?>"<?php 
											if ($sRoleID_u <> '6' && $table[0] == $cFacultyId_u)
											{
												echo ' selected';
											}else if ((isset($_REQUEST['cFacultyIdNew_abrv']) && $table[0] == strtoupper($_REQUEST['cFacultyIdNew_abrv'])) || 
											(isset($_REQUEST['cFacultyIdold']) && $table[0] == $_REQUEST['cFacultyIdold'])){echo ' selected';}?>>
												<?php echo $table[1];?>
											</option><?php
										}
										mysqli_close(link_connect_db());?>
								</select>
								<input name="cFacultyDescNew_h" id="cFacultyDescNew_h" type="hidden" value="<?php if (isset($_REQUEST['cFacultyDescNew_h'])){echo $_REQUEST['cFacultyDescNew_h'];}?>" />
							</div>
							<div id="labell_msg15" class="labell_msg blink_text orange_msg"></div>
						</div>
						
						<div id="cdeptold_div" class="setup_fac_dummy_lass innercont_stff" style="display:<?php echo $sho3;?>">
							<label for="cdeptold" class="labell_structure">Department</label>
							<div class="div_select">
								<select name="cdeptold" id="cdeptold" class="select" 
									onchange="if(sets.userInfo_d.value==this.value||_('what_to_do').value==4|| _('sRoleID').value==6)
									{
										_('confam').value='0';
										_('warned1').value='0';
										_('warned2').value='0';

										_('cprogrammeIdold').length = 0;
										_('cprogrammeIdold').options[_('cprogrammeIdold').options.length] = new Option('', '');

										_('ccourseIdold').length = 0;
										_('ccourseIdold').options[_('ccourseIdold').options.length] = new Option('', '');

										update_cat_country('cdeptold', 'cprogrammeId_readup', 'cprogrammeIdold', 'ccourseIdold');
										_('cDeptDescNew_h').value=this.options[this.selectedIndex].text.substr(4,this.options[this.selectedIndex].text.length-1);
										
										if(!(_('what_to_do').value=='0'&&_('on_what').value=='2'))
										{
											form_code(this.options[this.selectedIndex].text.substr(4,this.options[this.selectedIndex].text.length-1));
										}
										_('labell_msg16').style.display='none';
										_('cdept_prn').value=this.value;
										_('vdeptDesc_prn').value=this.options[this.selectedIndex].text;
										
										_('cCourseIdNew_a').value = this.value;
										_('cCourseIdNew_b').value = '';
										_('cCourseIdNew').value = '';
										_('tSemester_h2').value = '';
										//_('inner_structure').style.height = '420px';
									}else if (_('what_to_do').value!=4&&_('sRoleID').value!=6)
									{
										setMsgBox('labell_msg16','You can only work in your own department');
										this.value='';
										this.focus();
									}">
									<option value="" selected="selected"></option><?php
									if (isset($_REQUEST['cFacultyIdold']) && $_REQUEST['cFacultyIdold'] <> '' && $sho3 == 'block')
									{
										$stmt = $mysqli->prepare("select cdeptId, concat(cdeptId,' ',vdeptDesc) vdeptDesc from depts where cFacultyId = ? order by vdeptDesc");
										$stmt->bind_param("s", $_REQUEST['cFacultyIdold']);
										$stmt->execute();
										$stmt->store_result();
										$stmt->bind_result($cdeptId1, $vdeptDesc1);
										
										while ($stmt->fetch())
										{?>
											<option value="<?php echo $cdeptId1; ?>"<?php if (isset($_REQUEST['cdeptold']) && $cdeptId1 == $_REQUEST['cdeptold']){echo ' selected';}?>>
												<?php echo $vdeptDesc1;?>
											</option><?php
										}
										$stmt->close();
									}?>
								</select>
								<input name="cDeptDescNew_h" id="cDeptDescNew_h" type="hidden" 
									value="<?php if (isset($_REQUEST['cDeptDescNew_h'])){echo $_REQUEST['cDeptDescNew_h'];}?>" />
							</div>
							<div id="labell_msg16" class="labell_msg blink_text orange_msg"></div>
						</div><?php
						if (isset($_REQUEST['cdeptold']) && $_REQUEST['cdeptold'] <> '' && $sho3 == 'block')
						{
							// $stmt = $mysqli->prepare("select p.cProgrammeId, p.vProgrammeDesc, o.vObtQualTitle 
							// from programme p, obtainablequal o, depts s
							// where p.cObtQualId = o.cObtQualId 
							// and s.cdeptId = p.cdeptId
							// and p.cDelFlag = s.cDelFlag
							// and p.cDelFlag = 'N'
							// and p.cdeptId = ?
							// order by s.cdeptId, p.cProgrammeId");

							$stmt = $mysqli->prepare("select p.cProgrammeId, p.vProgrammeDesc, o.vObtQualTitle 
							from programme p, obtainablequal o, depts s
							where p.cObtQualId = o.cObtQualId 
							and s.cdeptId = p.cdeptId
							and p.cdeptId = ?
							order by s.cdeptId, p.cProgrammeId");
							$stmt->bind_param("s", $_REQUEST['cdeptold']);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($cProgrammeId, $vProgrammeDesc, $vObtQualTitle);
						}?>

						<div id="cprogrammeIdold_div" class="setup_fac_dummy_lass innercont_stff" style="display:<?php echo $sho3;?>">
							<label for="cprogrammeIdold" class="labell_structure">Programme</label>
							<div class="div_select">
							<select name="cprogrammeIdold" id="cprogrammeIdold" class="select" 
								onchange="if(this.value!='')
								{
									_('confam').value='0';
									_('frm_upd').value='p';
									_('warned1').value='0';
									_('warned2').value='0';
									_('cprogrammeId_prn').value=this.value;
									_('cprogrammedescNew_h1').value=this.options[this.selectedIndex].text;
									update_cat_country('cprogrammeIdold', 'courseId_readup', 'ccourseIdold', 'ccourseIdold');
									updateScrn();
									select_qual();
								}">
								<option value="" selected="selected"></option><?php
								if (isset($_REQUEST['cdeptold']) && $_REQUEST['cdeptold'] <> '' && $sho3 == 'block')
								{
									while ($stmt->fetch())
									{
										$vProgrammeDesc_01 = $vProgrammeDesc;
										if (!is_bool(strpos($vProgrammeDesc,"(d)")))
										{
											$vProgrammeDesc_01 = substr($vProgrammeDesc, 0, strlen($vProgrammeDesc)-4);
										}?>
										<option value="<?php echo $cProgrammeId?>"<?php if (isset($_REQUEST['cprogrammeIdold']) && $cProgrammeId == $_REQUEST['cprogrammeIdold']){echo ' selected';}?>><?php echo $vObtQualTitle.' '.$vProgrammeDesc_01; ?></option><?php
									}
									$stmt->close();
								}?>
							</select>
							</div>
							<div id="labell_msg17" class="labell_msg blink_text orange_msg"></div>
							<input name="cprogrammedescNew_h1" id="cprogrammedescNew_h1" type="hidden" value="<?php if(isset($_REQUEST['cprogrammedescNew_h1'])){echo $_REQUEST['cprogrammedescNew_h1'];} ?>"/>
						</div>

						<div id="ccourseIdold_mult_div" class="setup_fac_dummy_lass innercont_stff" style="display:none"><?php
							$sql = "SELECT a.cFacultyId, a.cdeptId, RPAD(MID(a.cCourseId,4,1),3,'0') ilevel, a.tSemester, a.iCreditUnit, a.cCourseId, a.vCourseDesc
							FROM courses a, faculty b, depts c
							WHERE a.cFacultyId = b.cFacultyId
							AND a.cdeptId = c.cdeptId
							ORDER BY a.cFacultyId, a.cdeptId, ilevel, a.tSemester, a.cCourseId, a.vCourseDesc";

							$rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
							$prev_faculty = '';
							$prev_dept = '';
							$Level = '';
							$Semester = '';?>
							<label for="ccourseIdold_mult" class="labell_structure">Course</label>
							<div id="ccourseIdold_cont" class="div_select" style="height:auto;width:480px;">
							<select name="ccourseIdold_mult" id="ccourseIdold_mult" multiple size="28" class="select" style="height:auto; width:inherit">
								<option value="" selected="selected"></option><?php
									while($rs = mysqli_fetch_assoc($rssql))
									{
										if ($prev_faculty <> '' && $prev_faculty <> $rs['cFacultyId'] ||
										$prev_dept <> '' && $prev_dept <> $rs['cdeptId'] ||
										$Level <> '' && $Level <> $rs['ilevel'] ||
										$Semester <> '' && $Semester <> $rs['tSemester'])
										{?>
											<option disabled></option><?php
										}?>
										<option value="<?php echo $rs['cCourseId'];?>"
										<?php if (isset($_REQUEST['exist_user']) &&
										$_REQUEST['exist_user'] == $getroles['vApplicationNo']){echo 'selected';}?>>
										<?php echo $rs['cFacultyId'].' '.$rs['cdeptId'].' '.$rs['ilevel'].' '.$rs['tSemester'].' '.$rs['cCourseId'].' '.$rs['vCourseDesc'];?></option><?php
										
										$prev_faculty = $rs['cFacultyId'];
										$prev_dept = $rs['cdeptId'];

										$Level = $rs['ilevel'];
										$Semester = $rs['tSemester'];
									}
									mysqli_close(link_connect_db());?>
							</select>
							</div>
							<div id="labell_msg41"class="labell_msg blink_text orange_msg"></div>
						</div>
						
						<div id="curriculum_div" class="setup_fac_dummy_lass innercont_stff" style="display:none; margin-top:10px;">
							<label class="labell_structure">Curriculum:</label>
							<div class="div_select" style="width:auto; margin-left:1px; padding-left:0px">
								<input name="select_curri_gen_h2" id="select_curri_gen_h2" type="hidden" value="1"/>
								
								<input name="select_curri_gen" id="select_curri_gen1" type="radio" checked value="1"
									style="margin-top:4px; cursor:pointer"
									onclick="_('select_curri_gen_h2').value='1';
									_('select_curriculum_prn').value='1';
									update_cat_country('cprogrammeIdold', 'courseId_readup', 'ccourseIdold', 'ccourseIdold');"/>
								<label for="select_curri_gen1" style="width:auto; cursor:pointer">Old</label>
							</div>

							<div class="div_select" style="width:auto; margin-left:10px; padding-left:0px">								
								<input name="select_curri_gen" id="select_curri_gen2" type="radio" value="2" 
									style="margin-top:4px; margin-left:0px; cursor:pointer"
									onclick="_('select_curri_gen_h2').value='2';
									_('select_curriculum_prn').value='2';
									update_cat_country('cprogrammeIdold', 'courseId_new_readup', 'ccourseIdold', 'ccourseIdold');" />
								<label for="select_curri_gen2" style="width:auto; cursor:pointer">New</label>
							</div>
						</div>

						<div id="ccourseIdold_div" class="setup_fac_dummy_lass innercont_stff" style="display:none">
							<label for="ccourseIdold" class="labell_structure">Course</label>
							<div id="ccourseIdold_cont" class="div_select">
							<select name="ccourseIdold" id="ccourseIdold" class="select" 
								onchange="_('frm_upd').value='cc';
								_('warned1').value='0';
								_('warned2').value='0';
								updateScrn();">
								<option value="" selected="selected"></option>
							</select>
							</div>
							<a href="#" onclick="settma.vFacultyDesc.value=sets.cFacultyIdold.options[sets.cFacultyIdold.selectedIndex].text.substr(4);
								settma.vdeptDesc.value=sets.cdeptold.options[sets.cdeptold.selectedIndex].text.substr(4);
								settma.vObtQualTitle.value=sets.cprogrammeIdold.value.substr(5,sets.cprogrammeIdold.value.indexOf(',')-5);
								settma.cProgrammeId.value=sets.cprogrammeIdold.value;
								settma.vProgrammeDesc.value=sets.cprogrammeIdold.options[sets.cprogrammeIdold.selectedIndex].text.substr(5);
								settma.cCourseCode.value=_('ccourseIdold').value;
								settma.cCourseCodeDesc.value=_('ccourseIdold').options[_('ccourseIdold').selectedIndex].text;
								settma.submit();return false">
							</a>
							<div id="labell_msg18"class="labell_msg blink_text orange_msg"></div>
						</div>

						<div id="level_semester_div" class="setup_fac_dummy_lass innercont_stff" style="display:<?php echo $sho3;?>">
							<label for="courseLevel" class="labell_structure">Level</label>
							<div class="div_select" style="width:40px;">
								<select name="courseLevel" id="courseLevel" class="select" style="width:auto" 
								onchange="//alert(_('cFacultyIdold').value+', '+_('cdeptold').value+', '+_('cprogrammeIdold').value+', '+_('courseLevel').value+', '+_('select_curriculum_h2').value+', '+_('coursesemester_h2').value);								
								_('courseLevel_prn').value=this.value;
									if (_('cFacultyIdold').value != '' && 
									_('cdeptold').value != '' && 
									_('cprogrammeIdold').value != '' && 
									_('courseLevel').value != '' && 
									_('select_curriculum_h2').value != '' &&
									_('coursesemester_h2').value != '')
									{
										in_progress('1');
										sets.submit();
									}">
									<option value="0" selected="selected">All</option>
									<option value="10" <?php if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] == 10){echo ' selected';} ?>>10</option>
									<option value="20" <?php if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] == 20){echo ' selected';} ?>>20</option>
									<option value="30" <?php if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] == 30){echo ' selected';} ?>>30</option>
									<option value="40" <?php if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] == 40){echo ' selected';} ?>>40</option><?php
									for ($t = 100; $t <= 1000; $t+=100)
									{?>
										<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
									}?>
								</select>
							</div>

							<label class="labell_structure" style="width:auto; margin-left:17px; padding-right:0px; margin-right:3px;">Curriculum:</label>
							<div class="div_select" style="width:auto; margin-left:1px; padding-left:0px">
								<input name="select_curriculum_h2" id="select_curriculum_h2" type="hidden" 
									value="<?php if (isset($_REQUEST['select_curriculum_h2']) && $_REQUEST['select_curriculum_h2'] <> ''){echo $_REQUEST['select_curriculum_h2'];} ?>" />
								
								<input name="select_curriculum" id="select_curriculum1" type="radio" value="1" style="margin-top:4px; margin-left:10px; cursor:pointer"
									onclick="								  
									_('select_curriculum_h2').value='1';
									_('select_curriculum_prn').value='1';
									if (_('cFacultyIdold').value != '' && 
									_('cdeptold').value != '' && 
									_('cprogrammeIdold').value != '' && 
									_('courseLevel').value != '' && 
									_('select_curriculum_h2').value != '' &&
									_('coursesemester_h2').value != '')
									{
										in_progress('1');
										sets.submit();
									}" <?php if (isset($_REQUEST['select_curriculum_h2']) && $_REQUEST['select_curriculum_h2'] == '1'){echo 'checked';} ?> />
								<label for="select_curriculum1" style="width:auto; cursor:pointer">Old</label>
							</div>

							<div class="div_select" style="width:auto; margin-left:10px; padding-left:0px">								
								<input name="select_curriculum" id="select_curriculum2" type="radio" value="2" style="margin-top:4px; margin-left:0px; cursor:pointer"
									onclick="								  
									_('select_curriculum_h2').value='2';
									_('select_curriculum_prn').value='2';
									if (_('cFacultyIdold').value != '' && 
									_('cdeptold').value != '' && 
									_('cprogrammeIdold').value != '' && 
									_('courseLevel').value != '' && 
									_('select_curriculum_h2').value != '' &&
									_('coursesemester_h2').value != '')
									{
										in_progress('1');
										sets.submit();
									}" <?php if (isset($_REQUEST['select_curriculum_h2']) && $_REQUEST['select_curriculum_h2'] == '2'){echo 'checked';} ?> />
								<label for="select_curriculum2" style="width:auto; cursor:pointer">New</label>
							</div>



							<label class="labell_structure" style="width:auto; margin-left:20px; padding-right:0px; margin-right:3px;">Semester:</label>
							<div class="div_select" style="width:auto; margin-left:1px; padding-left:0px">
								<input name="coursesemester_h2" id="coursesemester_h2" type="hidden" 
									value="<?php if (isset($_REQUEST['coursesemester_h2'])){echo $_REQUEST['coursesemester_h2'];} ?>" />
								
								<input name="coursesemester2" id="coursesemester12" type="radio" value="1" style="margin-top:4px; margin-left:0px; cursor:pointer"
									onclick="								  
									_('coursesemester_h2').value='1';
									_('coursesemester_prn').value='1';
									if (_('cFacultyIdold').value != '' && 
									_('cdeptold').value != '' && 
									_('cprogrammeIdold').value != '' && 
									_('courseLevel').value != '' && 
									_('select_curriculum_h2').value != '' &&
									_('coursesemester_h2').value != '')
									{
										in_progress('1');
										sets.submit();
									}" <?php if (isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] == '1'){echo 'checked';} ?> />
								<label for="coursesemester12" style="width:auto; cursor:pointer">First</label>
							</div>

							<div class="div_select" style="width:auto;">
								<input name="coursesemester2" id="coursesemester22" type="radio" value="2" style="margin-top:4px; cursor:pointer" title="Click to populate the left box" 
									onclick="
									_('coursesemester_h2').value='2';
									_('coursesemester_prn').value='2';
									if (_('cFacultyIdold').value != '' && 
									_('cdeptold').value != '' && 
									_('cprogrammeIdold').value != '' && 
									_('courseLevel').value != '' && 
									_('select_curriculum_h2').value != '' &&
									_('coursesemester_h2').value != '')
									{
										in_progress('1');
										sets.submit();
									}" <?php if (isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] == '2'){echo 'checked';} ?>/>
								
								<label for="coursesemester22" style="width:auto; cursor:pointer">Second</label>
							</div>

							<div class="div_select" style="width:auto;">
								<input name="coursesemester2" id="coursesemester32" type="radio" value="3" style="margin-top:4px; cursor:pointer" title="Click to populate the left box" 
									onclick="
									_('coursesemester_h2').value='3';
									_('coursesemester_prn').value='3';
									if (_('cFacultyIdold').value != '' && 
									_('cdeptold').value != '' && 
									_('cprogrammeIdold').value != '' && 
									_('courseLevel').value != '' && 
									_('select_curriculum_h2').value != '' &&
									_('coursesemester_h2').value != '')
									{
										in_progress('1');
										sets.submit();
									}" <?php if (isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] == '3'){echo 'checked';} ?>/>
								
								<label for="coursesemester32" style="width:auto; cursor:pointer">Third</label>
							</div>

							<div class="div_select" style="width:auto;">
								<input name="coursesemester2" id="coursesemester42" type="radio" value="4" style="margin-top:4px; cursor:pointer" title="Click to populate the left box" 
									onclick="
									_('coursesemester_h2').value='4';
									_('coursesemester_prn').value='4';
									if (_('cFacultyIdold').value != '' && 
									_('cdeptold').value != '' && 
									_('cprogrammeIdold').value != '' && 
									_('courseLevel').value != '' && 
									_('select_curriculum_h2').value != '' &&
									_('coursesemester_h2').value != '')
									{
										in_progress('1');
										sets.submit();
									}" <?php if (isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] == '4'){echo 'checked';} ?>/>
								
								<label for="coursesemester42" style="width:auto; cursor:pointer">Fourth</label>
							</div>

							<div class="div_select" style="width:auto;">
								<input name="coursesemester2" id="coursesemester52" type="radio" value="5" style="margin-top:4px; cursor:pointer"  
								onclick="_('coursesemester_h2').value='5';
								_('coursesemester_prn').value='5';
								if (_('cFacultyIdold').value != '' && 
								_('cdeptold').value != '' && 
								_('cprogrammeIdold').value != '' && 
								_('courseLevel').value != '' && 
								_('select_curriculum_h2').value != '' &&
								_('coursesemester_h2').value != '')
								{
									in_progress('1');
									sets.submit();
								}" <?php if (isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] == '5'){echo 'checked';} ?>/>
								<label for="coursesemester52" style="width:auto; cursor:pointer">All</label>									
							</div>
							<div id="labell_msg28" class="labell_msg blink_text orange_msg"></div>

							<div class="innercont_stff" style="float:right; width:auto; margin-right:5px; margin-top:0px;">
								<a href="#" style="text-decoration:none;" 
									onclick="_('course_selector').style.display = 'block';									
									_('course_selector').style.zIndex = '4';
									_('smke_screen_2').style.zIndex = '1';
									_('smke_screen_2').style.display = 'block';
									return false">
									<img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'search.png');?>" title="Click to magnify selection boxes below" 
											style="text-decoration:none; height:25px; width:28px" border="0" align="bottom"/>
								</a>
							</div>
						</div>
						
						
						<div id="ccourseIdold_div1" class="setup_fac_dummy_lass innercont_stff" style="display:<?php echo $sho3;?>; height:auto;">
							<div style="width: 48.4%; padding: 0.4%; float:left; border-radius:0px; border:1px solid #CCC; background-color:#DFE3E2">
								All courses sorted by facuty, department, programmes,...
							</div>
							<div style="width: 48.2%; padding: 0.4%; float:left; border-radius:0px; margin-left:1.2%; border:1px solid #CCC; background-color:#DFE3E2">
								Registrable courses for selected programme, sorted by level and semster
							</div><?php
							if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '0' && isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] <> '5')
							{
								if ($_REQUEST['courseLevel'] >= 100)
								{
									$stmt = $mysqli->prepare("SELECT concat(substr(cCourseId,4,1),'00') siLevel, tSemester, cCourseId, vCourseDesc, iCreditUnit
									from courses
									where substr(cCourseId,4,1) = left(?,1) and tSemester = ?	
									and cdel = 'N'
									order by cdeptId, siLevel, tSemester, cCourseId");
									$stmt->bind_param("si", $_REQUEST['courseLevel'], $_REQUEST['coursesemester_h2']);
								}else
								{
									$stmt = $mysqli->prepare("SELECT concat(substr(cCourseId,4,1),'00') siLevel, tSemester, cCourseId, vCourseDesc, iCreditUnit
									from courses
									where (substr(cCourseId,4,1) = '0'
									or (substr(cCourseId,4,1) = '1' and cFacultyId = ?)
									or cCourseId like 'GST%' or cCourseId like 'NOU%')
									and tSemester = ?
									and cdel = 'N'
									order by cdeptId, siLevel, tSemester, cCourseId");
									$stmt->bind_param("si", $_REQUEST['cFacultyIdold'], $_REQUEST['coursesemester_h2']);
								}									
							}else if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '0' && !(isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] <> '5'))
							{
								if ($_REQUEST['courseLevel'] >= 100)
								{
									$stmt = $mysqli->prepare("select concat(substr(cCourseId,4,1),'00') siLevel, tSemester, cCourseId, vCourseDesc, iCreditUnit
									from courses
									where substr(cCourseId,4,1) = left(?,1)	
									and cdel = 'N'
									order by cdeptId, siLevel, tSemester, cCourseId");
									$stmt->bind_param("s", $_REQUEST['courseLevel']);
								}else 
								{
									$stmt = $mysqli->prepare("SELECT concat(substr(cCourseId,4,1),'00') siLevel, tSemester, cCourseId, vCourseDesc, iCreditUnit
									from courses
									where (substr(cCourseId,4,1) = '0'
									or (substr(cCourseId,4,1) = '1' and cFacultyId = ?)
									or cCourseId like 'GST%'or cCourseId like 'NOU%')
									and cdel = 'N'
									order by cdeptId, siLevel, tSemester, cCourseId");
									$stmt->bind_param("s", $_REQUEST['cFacultyIdold']);
								}
								
							}else if (!(isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '0') && isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] <> '5')
							{
								if ($_REQUEST['courseLevel'] >= 100)
								{
									$stmt = $mysqli->prepare("select concat(substr(cCourseId,4,1),'00') siLevel, tSemester, cCourseId, vCourseDesc, iCreditUnit
									from courses
									where tSemester = ?	
									and cdel = 'N'
									order by cdeptId, siLevel, tSemester, cCourseId");
									$stmt->bind_param("i", $_REQUEST['coursesemester_h2']);
								}else
								{
									$stmt = $mysqli->prepare("SELECT concat(substr(cCourseId,4,1),'00') siLevel, tSemester, cCourseId, vCourseDesc, iCreditUnit
									from courses
									where (substr(cCourseId,4,1) = '0'
									or (substr(cCourseId,4,1) = '1' and cFacultyId = ?)
									or cCourseId like 'GST%' or cCourseId like 'NOU%')
									and tSemester = ?
									and cdel = 'N'
									order by cdeptId, siLevel, tSemester, cCourseId");
									$stmt->bind_param("si", $_REQUEST['cFacultyIdold'], $_REQUEST['coursesemester_h2']);
								}
							}else
							{
								$stmt = $mysqli->prepare("select concat(substr(cCourseId,4,1),'00') siLevel, tSemester, cCourseId, vCourseDesc, iCreditUnit
								from courses
								where tSemester = 20	
								and cdel = 'N'
								order by cFacultyId, cdeptId, siLevel, tSemester, cCourseId");
							}
							$stmt->execute();
							$stmt->store_result();
							
							$stmt->bind_result($siLevel2, $tSemester2, $cCourseId2, $vCourseDesc2, $iCreditUnit2);?>
							
							<ul id="all_courses" class="checklist cl1" style="float:left; width:49.2%; margin-left:0px; height:365px; margin-right:1.2%; overflow:auto; overflow-x: hidden;"><?php
								$c = 0; 
									
								$prevLevel = ''; 
								$prevSemester = '';
								$prev_dept = '';
								while($stmt->fetch())
								{
									$tSemester_desc = 'First';
									if ($tSemester2 == 2){$tSemester_desc = 'Second';}
									
									if (($prevSemester <> '' && $prevSemester <> $tSemester2) || ($prev_dept <> '' && $prev_dept <> substr($cCourseId2,0,3)))
									{?>
										<li style="height:25px;">
											<div style="border-radius:0px;">
												.
											</div>
										</li><?php  
									}
																		
									$c++;
									$selectCourse_para = "'".$cCourseId2."','".$tSemester2."','".$iCreditUnit2."','".$vCourseDesc2."'";?>
									
									<li id="ali<?php echo $c;?>" style="height:25px; text-align:left"<?php if ($c%2 == 0){echo ' class="alt"';}?> 
										title="Click to add course to the box on the right. Ctrl+Click = Compulsory. Alt+Click = Required. Click = Elective" 
										onclick="selectCourse(<?php echo $selectCourse_para;?>)">
										<div class="chkboxNoDiv" style="padding:0.8%;"><?php echo $c;?></div>

										<div class="ccodeDiv" style="width:8.5%; line-height:1.8;">
											<?php echo $cCourseId2;?>
										</div>
										
										<div class="singlecharDiv" style="width:5%; line-height:1.8;">
											<?php echo $iCreditUnit2;?>
										</div>

										<div class="ctitle" style="width:73.3%; line-height:1.8;">
											<?php echo $vCourseDesc2;?>
										</div>
									</li><?php
									
									$prev_dept = substr($cCourseId2, 0, 3);
									$prevSemester = $tSemester2;
								}
								$stmt->close();?>
							</ul><?php
							
							if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '0' && isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] <> '5')
							{
								$stmt = $mysqli->prepare("select a.siLevel, a.tSemester, a.cCourseId, c.vCourseDesc, iCreditUnit, cCategory, retActive
								from progcourse a, depts b, courses c
								where a.cdeptId = b.cdeptId 
								and a.cCourseId = c.cCourseId
								and a.siLevel = ? and a.tSemester = ?
								and b.cFacultyId = ? and  a.cProgrammeId = ?
								$selected_curr
								and a.cdel = 'N'
								order by siLevel, tSemester, cCourseId");
								$stmt->bind_param("iiss", $_REQUEST['courseLevel'], $_REQUEST['coursesemester_h2'], $_REQUEST['cFacultyIdold'],  $_REQUEST['cprogrammeIdold']);
							}else if (isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '0' && !(isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] <> '5'))
							{
								$stmt = $mysqli->prepare("select a.siLevel, a.tSemester, a.cCourseId, c.vCourseDesc, iCreditUnit, cCategory, retActive
								from progcourse a, depts b, courses c
								where a.cdeptId = b.cdeptId 
								and a.cCourseId = c.cCourseId
								and a.siLevel = ? 
								and b.cFacultyId = ? and  a.cProgrammeId = ?
								$selected_curr
								and a.cdel = 'N'
								order by  siLevel, tSemester, cCourseId");
								$stmt->bind_param("iss", $_REQUEST['courseLevel'], $_REQUEST['cFacultyIdold'],  $_REQUEST['cprogrammeIdold']);
							}else if (!(isset($_REQUEST['courseLevel']) && $_REQUEST['courseLevel'] <> '0') && isset($_REQUEST['coursesemester_h2']) && $_REQUEST['coursesemester_h2'] <> '5')
							{
								$stmt = $mysqli->prepare("select a.siLevel, a.tSemester, a.cCourseId, c.vCourseDesc, iCreditUnit, cCategory, retActive
								from progcourse a, depts b, courses c
								where a.cdeptId = b.cdeptId 
								and a.cCourseId = c.cCourseId
								and a.tSemester = ?
								and b.cFacultyId = ? and  a.cProgrammeId = ?
								$selected_curr
								and a.cdel = 'N'
								order by siLevel, tSemester, cCourseId");
								$stmt->bind_param("iss", $_REQUEST['coursesemester_h2'], $_REQUEST['cFacultyIdold'],  $_REQUEST['cprogrammeIdold']);
							}else
							{
								$stmt = $mysqli->prepare("select a.siLevel, a.tSemester, a.cCourseId, c.vCourseDesc, iCreditUnit, cCategory, retActive
								from progcourse a, depts b, courses c
								where a.cdeptId = b.cdeptId 
								and a.cCourseId = c.cCourseId
								and b.cFacultyId = ? and  a.cProgrammeId = ?
								$selected_curr
								and a.cdel = 'N'
								order by  siLevel, tSemester, cCourseId");
								$stmt->bind_param("ss", $_REQUEST['cFacultyIdold'],  $_REQUEST['cprogrammeIdold']);
							}
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($siLevel3, $tSemester3, $cCourseId3, $vCourseDesc3, $iCreditUnit3, $cCategory3, $retActive);?>
							
							<ul id="reg_courses" class="checklist cl1" style="float:left; width:49%; margin-left:0px; height:365px; overflow:auto; overflow-x: hidden;"><?php
								$numOfiputTag = -1; $prev_dept = ''; $prev_fac = ''; $prev_dept = ''; $prevLevel = ''; $prevSemester = '';
								while($stmt->fetch())
								{
									$tSemester_desc = 'First';
									if ($tSemester3 == 2){$tSemester_desc = 'Second';}
									
									if(($prevLevel = '' || $prevLevel <> $siLevel3) || ($prevSemester = '' || $prevSemester <> $tSemester3))
									{	?>
										<li style="height:30px;">
											<div style="height:30px; line-height:1.8; padding:0.4%; border-radius:0px; font-weight:bold">
												<b><?php echo $siLevel3.'Level, '.$tSemester_desc.' semester'.$tSemester3;?></b>
											</div>
										</li><?php
									}
									$numOfiputTag++;?>
									
									<li id="ali<?php echo $c;?>" style="text-align:left; height:30px;"<?php if ($numOfiputTag%2 == 0){echo ' class="alt"';}?> title="Click to remove course" 
										onclick="this.parentNode.removeChild(this);">
										<input name="regCourses<?php echo $numOfiputTag ?>" id="regCourses<?php echo $numOfiputTag ?>" type="hidden" 
											value="<?php echo $cCategory3.$retActive.$cCourseId3;?>"/>
										<div class="chkboxNoDiv" style="width:5%; line-height:1.8;"><?php echo ($numOfiputTag+1);?></div>
										<div class="ccodeDiv" style="width:8.5%; height:30px; line-height:1.8;">
											<?php echo $cCourseId3;?>
										</div>
										<div class="singlecharDiv" style="width:5%; height:30px; line-height:1.8;">
											<?php echo $cCategory3;?>
										</div>
										<div class="singlecharDiv" style="width:5%; height:30px; line-height:1.8;">
											<?php echo $iCreditUnit3;?>
										</div>
										<div class="singlecharDiv" style="width:5%; height:30px; line-height:1.8;">
											<?php if ($retActive == '0')
											{
												echo 'NR';
											}else if ($retActive == '1')
											{
												echo 'RA';
											}else
											{
												echo 'NA';
											}?>
										</div>
										<div class="ctitle_right" style="width:58%; height:30px; line-height:1.8;">
											<?php echo $vCourseDesc3;?>
										</div>
									</li><?php
									$prevLevel = $siLevel3;
									$prevSemester = $tSemester3;
								}
								$stmt->close();?>
							</ul>
							<input name="numOfiputTag" id="numOfiputTag" type="hidden" value="<?php echo $numOfiputTag;?>"/>
						</div>
						
						<div id="cFacultyIdNew_div" class="setup_fac_dummy_lass innercont_stff" style="display:none">
							<label for="cFacultyDescNew" class="labell_structure">Name</label>
							<div class="div_select">
								<input name="cFacultyDescNew" id="cFacultyDescNew" type="text" class="textbox" 
									onchange="form_code(this.value);
									this.value=this.value.trim();
									this.value.toLowerCase();
									this.value=capitalizeEachWord(this.value)"
									maxlength="30"
									value="<?php if (isset($_REQUEST['cFacultyDescNew'])){echo $_REQUEST['cFacultyDescNew'];}?>"/>
							</div>
							<div id="labell_msg19" class="labell_msg blink_text orange_msg"></div>
						</div>
						
						<div id="cDeptDescNew_div" class="setup_fac_dummy_lass innercont_stff" style="display:none">
							<label for="cDeptDescNew" class="labell_structure">Department name</label>
							<div class="div_select">
							<input name="cDeptDescNew" id="cDeptDescNew" type="text" class="textbox" 
								onchange="form_code(this.value);
								this.value=this.value.trim();
								this.value.toLowerCase();
								this.value=capitalizeEachWord(this.value)"
								maxlength="30"
								value="<?php if (isset($_REQUEST['cDeptDescNew'])){echo ucwords(strtolower($_REQUEST['cDeptDescNew']));}?>"/>
							</div>
							<div id="labell_msg21" class="labell_msg blink_text orange_msg"></div>
						</div>

						<div id="cFacultyIdNew_abrv_div" class="setup_fac_dummy_lass innercont_stff" style="display:none">
							<label for="cFacultyIdNew_abrv" class="labell_structure">Code</label>
							<div class="div_select">
							<input name="cFacultyIdNew_abrv" id="cFacultyIdNew_abrv" type="text" maxlength="3" class="textbox" style="width:35px; text-transform:uppercase" 
								value="<?php if (isset($_REQUEST['cFacultyIdNew_abrv'])){echo strtoupper($_REQUEST['cFacultyIdNew_abrv']);}?>"/>
							</div>
							<div id="labell_msg20" class="labell_msg blink_text orange_msg"></div>
						</div>
						
						<div id="cprogrammeIdNew_div" class="setup_fac_dummy_lass innercont_stff" style="display:none">
							<label for="cprogrammeIdNew" class="labell_structure">Programme code</label>
							<div class="div_select" style="width:60px;">
								<input name="cprogrammeIdNew" id="cprogrammeIdNew" readonly type="text" maxlength="6" class="textbox" style="width:100%;" onchange="this.value=this.value.toUpperCase()" 
							value="<?php if (isset($_REQUEST['cprogrammeIdNew'])){echo $_REQUEST['cprogrammeIdNew'];} ?>"/>
							</div>
							
							<label for="cprogrammetitleNew" class="labell_structure" style="width:auto;margin-left:23px;">Qualification</label>
							<div class="div_select" style="width:71px;margin-left:1px;"><?php
								$sql = "select cEduCtgId, cObtQualId, vObtQualTitle from obtainablequal order by cObtQualId";
								$rsql = mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));?>
								<select name="cprogrammetitleNew" onChange="form_prog_code()" id="cprogrammetitleNew" class="select" style="width:75px">
									<option value="" selected="selected"></option><?php
									while ($table = mysqli_fetch_array($rsql))
									{?>
										<option value="<?php echo $table['cEduCtgId'].$table['cObtQualId'] ?>" <?php if (isset($_REQUEST['cprogrammetitleNew']) && $_REQUEST['cprogrammetitleNew'] == $table['cObtQualId']){echo ' selected';} ?>><?php echo $table['vObtQualTitle'] ;?></option><?php
									}
									mysqli_close(link_connect_db());?>
								</select>
							</div>
							
							<label for="cprogrammedescNew" class="labell_structure" style="width:auto; margin-left:16px">Programme title</label>
							<div class="div_select" style="width:243px;">
								<input name="cprogrammedescNew" id="cprogrammedescNew" type="text" class="textbox" style="width:inherit" 
									onchange="this.value=this.value.trim();
									this.value.toLowerCase();
									this.value=capitalizeEachWord(this.value)"
									maxlength="40"
									value="<?php if (isset($_REQUEST['cprogrammedescNew'])){echo $_REQUEST['cprogrammedescNew'];} ?>"/>
								<input name="cprogrammedescNew_h" id="cprogrammedescNew_h" type="hidden" value="<?php if(isset($_REQUEST['cprogrammedescNew'])){echo $_REQUEST['cprogrammedescNew'];} ?>"/>
							</div>
						</div>

						<div id="cprogrammeLevel_div" class="setup_fac_dummy_lass innercont_stff" style="display:none; width:98%">
							<label for="BeginLevel" class="labell_structure">Begin level</label>
							<div class="div_select" style="width:40px; background:#ccc">
								<select name="BeginLevel" id="BeginLevel" class="select" style="width:auto">
									<option value="" selected="selected"></option>
									<option value="10" <?php if (isset($_REQUEST['BeginLevel']) && $_REQUEST['BeginLevel'] == 10){echo ' selected';} ?>>10</option>
									<option value="20" <?php if (isset($_REQUEST['BeginLevel']) && $_REQUEST['BeginLevel'] == 20){echo ' selected';} ?>>20</option>
									<option value="30" <?php if (isset($_REQUEST['BeginLevel']) && $_REQUEST['BeginLevel'] == 30){echo ' selected';} ?>>30</option>
									<option value="40" <?php if (isset($_REQUEST['BeginLevel']) && $_REQUEST['BeginLevel'] == 40){echo ' selected';} ?>>40</option><?php
									for ($t = 100; $t <= 1000; $t+=100)
									{?>
										<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['BeginLevel']) && $_REQUEST['BeginLevel'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
									}?>
								</select>
							</div>
							
							<label for="EndLevel" class="labell_structure" style="width:85px; margin-left:28px; margin-right:5px;">End level</label>
							<div class="div_select" style="width:40px;">
								<select name="EndLevel" id="EndLevel" class="select" style="width:auto">
									<option value="" selected="selected"></option>
									<option value="10" <?php if (isset($_REQUEST['EndLevel']) && $_REQUEST['EndLevel'] == 10){echo ' selected';} ?>>10</option>
									<option value="20" <?php if (isset($_REQUEST['EndLevel']) && $_REQUEST['EndLevel'] == 20){echo ' selected';} ?>>20</option>
									<option value="30" <?php if (isset($_REQUEST['EndLevel']) && $_REQUEST['EndLevel'] == 30){echo ' selected';} ?>>30</option>
									<option value="40" <?php if (isset($_REQUEST['EndLevel']) && $_REQUEST['EndLevel'] == 40){echo ' selected';} ?>>40</option><?php
									for ($t = 100; $t <= 1000; $t+=100)
									{?>
										<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['EndLevel']) && $_REQUEST['EndLevel'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
									}?>
								</select>
							</div>
							<label for="grdtce" class="labell_structure" style="width:102px; margin-left:38px;" title="TCE=Total credit earned">Min. grad. TCE</label>
							<div class="div_select" style="width:40px;">
								<select name="grdtce" id="grdtce" class="select" style="width:auto">
									<option value="" selected="selected"></option><?php
									for ($t = 10; $t <= 280; $t++)
									{?>
										<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['grdtce']) && $_REQUEST['grdtce'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
									}?>
								</select>
							</div>
							<div id="labell_msg24" class="labell_msg blink_text orange_msg" style="width:auto"></div>
						</div>

						<div id="cprogrammeLevel1_div" class="setup_fac_dummy_lass innercont_stff" style="display:none">
							<label for="grdtce2" class="labell_structure" style="width:150px;" title="TCE=Total credit earned, DE=Direct entry">Min. grad. TCE (DE)</label>
							<div class="div_select" style="width:40px;">
								<select name="grdtce2" id="grdtce2" class="select" style="width:auto">
									<option value="" selected="selected"></option><?php
									for ($t = 10; $t <= 200; $t++)
									{?>
										<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['grdtce2']) && $_REQUEST['grdtce2'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
									}?>
								</select>
							</div>

							<label for="max_crload" class="labell_structure" style="width:auto; margin-left:154px;">Max. credit load/semester</label>
							<div class="div_select" style="width:40px;">
								<select name="max_crload" id="max_crload" class="select" style="width:auto">
									<option value="" selected="selected"></option><?php
									for ($t = 10; $t <= 40; $t++)
									{?>
										<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['max_crload']) && $_REQUEST['max_crload'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
									}?>
								</select>
							</div>
							<div id="labell_msg25" class="labell_msg blink_text orange_msg" style="width:auto; margin-left:4px;"></div>
						</div>

						<div id="no_semester_div" class="setup_fac_dummy_lass innercont_stff" style="display:none">
							<label for="cprogrammeIdold" class="labell_structure">Minimum number of semester</label>
							<div class="div_select">
							<select name="no_semester" id="no_semester" class="select" style="width:auto">
									<option value="" selected="selected"></option><?php
									for ($t = 2; $t <= 10; $t++)
									{?>
										<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['no_semester']) && $_REQUEST['no_semester'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
									}?>
								</select>
							</div>
							<div id="labell_msg43" class="labell_msg blink_text orange_msg"></div>
						</div>

						<div id="tcu_counts_div" class="setup_fac_dummy_lass innercont_stff" style="margin-top:0.5%; display:none; height:auto;">
							<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.2%; margin:0px; margin-top:0.7%; margin-bottom:0.7%;" />
							<div class="innercont_stff" style="height:auto;">
								<label class="labell_structure"></label>
								<label class="labell_structure" style="width:auto; font-weight:bold" title="TCU=Total Credit Unit">TCU (course registration guide) requirements for graduation (option a)</label>
							</div>
							
							<div id="tgst_tcu_div" class="innercont_stff" syle="height:auto; margin-top:0.5%;">
								<label for="tgst_tcu" class="labell_structure">GST/NOU</label>
								<div class="div_select" style="width:40px; float:left">
									<select name="tgst_tcu" id="tgst_tcu" class="select" style="width:auto">
										<option value="" selected="selected"></option><?php
										for ($t = 0; $t <= 20; $t++)
										{?>
											<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['tgst_tcu']) && $_REQUEST['tgst_tcu'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
										}?>
									</select>
								</div>
								<div id="labell_msg30" class="labell_msg blink_text orange_msg"></div>
							</div>
							
							<div id="tbasic_tcu_div" class="innercont_stff" syle="height:auto; margin-top:0.5%;">
								<label for="tbasic_tcu" class="labell_structure">Basic courses</label>
								<div class="div_select" style="width:40px; float:left">
									<select name="tbasic_tcu" id="tbasic_tcu" class="select" style="width:auto">
										<option value="" selected="selected"></option><?php
										for ($t = 0; $t <= 45; $t++)
										{?>
											<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['tbasic_tcu']) && $_REQUEST['tbasic_tcu'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
										}?>
									</select>
								</div>
								<div id="labell_msg31" class="labell_msg blink_text orange_msg"></div>
							</div>
							
							<div id="tfaculty_tcu_div" class="innercont_stff" syle="height:auto; margin-top:0.5%;">
								<label for="tfaculty_tcu" class="labell_structure">Faculty courses
								</label>
								<div class="div_select" style="width:40px; float:left">
									<select name="tfaculty_tcu" id="tfaculty_tcu" class="select" style="width:auto">
										<option value="" selected="selected"></option><?php
										for ($t = 0; $t <= 105; $t++)
										{?>
											<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['tbasic_tcu']) && $_REQUEST['tbasic_tcu'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
										}?>
									</select>
								</div>
								<div id="labell_msg32" class="labell_msg blink_text orange_msg"></div>
							</div>
							
							<div id="tcc_tcu_div" class="innercont_stff" syle="height:auto; margin-top:0.5%;">
								<label for="tcc_tcu" class="labell_structure">Core Courses</label>
								<div class="div_select" style="width:40px; float:left">
									<select name="tcc_tcu" id="tcc_tcu" class="select" style="width:auto">
										<option value="" selected="selected"></option><?php
										for ($t = 0; $t <= 100; $t++)
										{?>
											<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['tcc_tcu']) && $_REQUEST['tcc_tcu'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
										}?>
									</select>
								</div>
								<div id="labell_msg33" class="labell_msg blink_text orange_msg"></div>
							</div>
							
							<div id="telect_tcu_div" class="innercont_stff" syle="height:auto; margin-top:0.5%;">
								<label for="telect_tcu" class="labell_structure">Electives</label>
								<div class="div_select" style="width:40px; float:left">
									<select name="telect_tcu" id="telect_tcu" class="select" style="width:auto">
										<option value="" selected="selected"></option><?php
										for ($t = 0; $t <= 20; $t++)
										{?>
											<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['telect_tcu']) && $_REQUEST['telect_tcu'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
										}?>
									</select>
								</div>
								<div id="labell_msg34" class="labell_msg blink_text orange_msg"></div>
							</div>
							
							<div id="tsiwess_tcu_div" class="innercont_stff" syle="height:auto; margin-top:0.5%;">
								<label for="tsiwess_tcu" class="labell_structure">SIWES</label>
								<div class="div_select" style="width:40px; float:left">
									<select name="tsiwess_tcu" id="tsiwess_tcu" class="select" style="width:auto">
										<option value="" selected="selected"></option><?php
										for ($t = 0; $t <= 20; $t++)
										{?>
											<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['tsiwess_tcu']) && $_REQUEST['tsiwess_tcu'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
										}?>
									</select>
								</div>
								<div id="labell_msg35" class="labell_msg blink_text orange_msg"></div>
							</div>
							
							<div id="tentrep_tcu_div" class="innercont_stff" syle="height:auto; margin-top:0.5%;">
								<label for="tentrep_tcu" class="labell_structure">Entrepreneur</label>
								<div class="div_select" style="width:40px; float:left">
									<select name="tentrep_tcu" id="tentrep_tcu" class="select" style="width:auto">
										<option value="" selected="selected"></option><?php
										for ($t = 0; $t <= 20; $t++)
										{?>
											<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['tentrep_tcu']) && $_REQUEST['tentrep_tcu'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
										}?>
									</select>
								</div>
								<div id="labell_msg36" class="labell_msg blink_text orange_msg"></div>
							</div>
							

							<div class="innercont_stff" style="margin-top:0.5%; height:auto;">
								<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.8px; margin:0px; margin-bottom:10px; margin-top:10px;" />
								<label class="labell_structure"></label>
								<label class="labell_structure" style="width:auto; font-weight:bold" title="TCU=Total Credit Unit">TCU (course registration guide) requirements for graduation (option b)</label>
							</div>
							
							<div id="tcompul_tcu_div" class="innercont_stff" syle="height:auto; margin-top:0.5%;">
								<label for="tcompul_tcu" class="labell_structure">Compulsory courses</label>
								<div class="div_select" style="width:40px; float:left">
									<select name="tcompul_tcu" id="tcompul_tcu" class="select" style="width:auto">
										<option value="" selected="selected"></option><?php
										for ($t = 0; $t <= 160; $t++)
										{?>
											<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['tcompul_tcu']) && $_REQUEST['tcompul_tcu'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
										}?>
									</select>
								</div>
								<div id="labell_msg37" class="labell_msg blink_text orange_msg"></div>
							</div>
							
							<div id="treq_tcu_div" class="innercont_stff" syle="height:auto; margin-top:0.5%;">
								<label for="treq_tcu" class="labell_structure">Required courses</label>
								<div class="div_select" style="width:40px; float:left">
									<select name="treq_tcu" id="treq_tcu" class="select" style="width:auto">
										<option value="" selected="selected"></option><?php
										for ($t = 0; $t <= 75; $t++)
										{?>
											<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['treq_tcu']) && $_REQUEST['treq_tcu'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
										}?>
									</select>
								</div>
								<div id="labell_msg38" class="labell_msg blink_text orange_msg"></div>
							</div>
							
							<div id="telec_tcu_div" class="innercont_stff" syle="height:auto; margin-top:0.5%;">
								<label for="telec_tcu" class="labell_structure">Elective courses</label>
								<div class="div_select" style="width:40px; float:left">
									<select name="telec_tcu" id="telec_tcu" class="select" style="width:auto">
										<option value="" selected="selected"></option><?php
										for ($t = 0; $t <= 30; $t++)
										{?>
											<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['telec_tcu']) && $_REQUEST['telec_tcu'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
										}?>
									</select>
								</div>
								<div id="labell_msg39" class="labell_msg blink_text orange_msg"></div>
							</div>								
							
							<div id="tgs_tcu_div" class="innercont_stff" syle="height:auto; margin-top:0.5%;">
								<label for="tgs_tcu" class="labell_structure">GST/NOU courses</label>
								<div class="div_select" style="width:40px; float:left">
									<select name="tgs_tcu" id="tgs_tcu" class="select" style="width:auto">
										<option value="" selected="selected"></option><?php
										for ($t = 0; $t <= 20; $t++)
										{?>
											<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['tgs_tcu']) && $_REQUEST['tgs_tcu'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
										}?>
									</select>
								</div>
								<div id="labell_msg40" class="labell_msg blink_text orange_msg"></div>
							</div>
						</div>
							
						<!--<div id="study_mode_div" class="setup_fac_dummy_lass innercont_stff" style="display:none; height:4%; margin-top:0.5%;">
							<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.8px; margin:0px; margin-bottom:10px; margin-top:10px;" />
							<label for="study_mode_loc" class="labell_structure">Programme category</label>
							<div class="div_select" style="height:auto; width:auto;"><?php
								//$rs_sql = mysqli_query(link_connect_db(), "SELECT study_mode_ID, study_mode_Desc FROM study_mode WHERE cdel = 'N' ORDER BY study_mode_ID;") or die(mysqli_error(link_connect_db()));?>
								<select name="study_mode_loc" id="study_mode_loc" class="select" style="height:100px; width:auto" multiple size="5">
									<option value="" selected="selected">Select programme category</option><?php
									/*while ($rs = mysqli_fetch_array($rs_sql))
									{
										if ($rs['study_mode_ID'] == 'topup')
										{?>
											<option disabled></option><?php
										}?>
										<option value="<?php echo $rs['study_mode_ID'];?>">
											<?php echo $rs['study_mode_Desc'];?>
										</option><?php
										if ($rs['study_mode_ID'] == 'pre_degree')
										{?>
											<option disabled></option><?php
										}
									}
									mysqli_close(link_connect_db());*/?>
								</select>
							</div>
							<div id="labell_msg29" class="labell_msg blink_text orange_msg"></div>
						</div>-->

						<div id="cCourseIdNew_div" class="setup_fac_dummy_lass innercont_stff" style="margin-top:0.5%; display:none;">
							<label for="cCourseIdNew" class="labell_structure">Course code</label>
							<div class="div_select" style="width:auto;">
								<input name="cCourseIdNew_a" id="cCourseIdNew_a" type="text" class="textbox"
									maxlength="3" style="text-transform:uppercase; width:35px; margin:0px;" 
									value="<?php if (isset($_REQUEST['cCourseIdNew'])){echo strtoupper(substr($_REQUEST['cCourseIdNew'],0,3));}?>"/>	
							
								<input name="cCourseIdNew_b" id="cCourseIdNew_b" type="number" class="textbox"
									maxlength="3" style="text-transform:uppercase; width:40px; margin:0px" 
									onchange="if(this.value.length==3)
									{
										if(this.value.substr(2,1)%2==0||this.value.substr(2,1)==0)
										{
											_('tSemester_h2').value=2;
										}else
										{
											_('tSemester_h2').value=1;
										}

										if (_('cCourseIdNew_a').value != '')
										{
											_('cCourseIdNew').value = _('cCourseIdNew_a').value + this.value;
										}
									}else
									{
										_('tSemester_h2').value='';
									}"
									value="<?php if (isset($_REQUEST['cCourseIdNew'])){echo substr($_REQUEST['cCourseIdNew'],3,3);}?>"/>

									<input name="cCourseIdNew" id="cCourseIdNew" type="hidden" value="<?php if (isset($_REQUEST['cCourseIdNew'])){echo $_REQUEST['cCourseIdNew'];}?>" />
							</div>
							<label for="cCoursetitleNew" class="labell_structure" style="width:80px; margin-left:10px;">Course title</label>
							<div class="div_select" style="width:354px; margin-left:0px">
								<input name="cCoursetitleNew" id="cCoursetitleNew" type="text" class="textbox"  
									style="width:354px;" 
									value="<?php if (isset($_REQUEST['cCoursetitleNew'])){echo $_REQUEST['cCoursetitleNew'];}?>"
									maxlength="70"
									onchange="this.value=this.value.trim();
									this.value.toLowerCase();
									this.value=capitalizeEachWord(this.value)"/>
							</div>
							<input name="cCoursetitleNew_h" id="cCoursetitleNew_h" type="hidden" 
							value="<?php if (isset($_REQUEST['cCoursetitleNew_h'])){echo $_REQUEST['cCoursetitleNew_h'];}?>" />
						</div>

						<div id="cCourseIdNew_div2" class="setup_fac_dummy_lass innercont_stff" style="display:none;">
							<label for="iCreditUnit" class="labell_structure" style="margin-left:0px">Credit unit</label>
							<div class="div_select" style="width:89px">
								<select name="iCreditUnit" id="iCreditUnit" class="select" style="width:inherit">
									<option value="" selected="selected"></option><?php
									for ($t = 1; $t <= 6; $t++)
									{?>
										<option value="<?php echo $t ?>" <?php if (isset($_REQUEST['iCreditUnit']) && $_REQUEST['iCreditUnit'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
									}?>
								</select>  
							</div>

							<label for="tSemester_h2" class="labell_structure" style="width:80px; margin-left:15px; padding-right:0px; margin-right:3px">Semester:</label>
							<div class="div_select" style="width:auto">
								<select name="tSemester_h2" id="tSemester_h2" class="select" style="width:inherit">
									<option value="" selected="selected"></option>
									<option value="1">First</option>
									<option value="2">Second</option>
									<option value="3">Third</option>
									<option value="4">Fourth</option>
								</select>
							</div>
							<div id="labell_msg23" class="labell_msg blink_text orange_msg"></div>
						</div>

						<div id="courseclass_div" class="setup_fac_dummy_lass innercont_stff" style="margin-top:0.5%; display:none;">
							<label for="courseclass" class="labell_structure">Class of course</label>
							<div class="div_select">
								<select name="courseclass" id="courseclass" class="select" style="width:inherit">
									<option value="" selected="selected"></option>
									<option value="clinical_attachment" <?php if (isset($_REQUEST['courseclass']) && $_REQUEST['courseclass'] == 'clinical_attachment'){echo ' selected';} ?>>Clinical attachment</option>
									<option value="field_trip" <?php if (isset($_REQUEST['courseclass']) && $_REQUEST['courseclass'] == 'clinical_attachment'){echo ' selected';} ?>>Field trip</option>
									<option value="normal" <?php if (isset($_REQUEST['courseclass']) && $_REQUEST['courseclass'] == 'normal'){echo ' selected';} ?>>Normal</option>
									<option value="practical" <?php if (isset($_REQUEST['courseclass']) && $_REQUEST['courseclass'] == 'practical'){echo ' selected';} ?>>Practical</option>
									<option value="Project" <?php if (isset($_REQUEST['courseclass']) && $_REQUEST['courseclass'] == 'Project'){echo ' selected';} ?>>Project</option>
									<option value="Laboratory" <?php if (isset($_REQUEST['courseclass']) && $_REQUEST['courseclass'] == 'Laboratory'){echo ' selected';} ?>>Practical examinable</option>
									<option value="Practicum" <?php if (isset($_REQUEST['courseclass']) && $_REQUEST['courseclass'] == 'Practicum'){echo ' selected';} ?>>Practicum</option>
									<option value="seminar" <?php if (isset($_REQUEST['courseclass']) && $_REQUEST['courseclass'] == 'seminar'){echo ' selected';} ?>>Seminar</option>
									<option value="siwes" <?php if (isset($_REQUEST['courseclass']) && $_REQUEST['courseclass'] == 'siwes'){echo ' selected';} ?>>SIWES</option>
									<option value="teaching_practice" <?php if (isset($_REQUEST['courseclass']) && $_REQUEST['courseclass'] == 'teaching_practice'){echo ' selected';} ?>>Teaching practice</option>
									</option>
								</select>
							</div> 
							<div id="labell_msg42" class="labell_msg blink_text orange_msg"></div>
						</div>

						<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:1; width:99.9%; float:left; height:0.8px; margin:0px; margin-bottom:10px; margin-top:10px;" />

						<div id="new_cFacultyIdold_div" class="setup_fac_dummy_lass innercont_stff" style="display:<?php if(isset($_REQUEST['what_to_do'])&&isset($_REQUEST['on_what'])&&	$_REQUEST['what_to_do']=='1'&&($_REQUEST['on_what']=='1'||$_REQUEST['on_what']=='2'||$_REQUEST['on_what']=='3')){echo 'block';}else{echo 'none';} ?>;"><?php
							$sql1 = "SELECT cFacultyId, concat(cFacultyId,' ',vFacultyDesc) vFacultyDesc FROM faculty WHERE cCat = 'A' AND cDelFlag = 'N' ORDER BY vFacultyDesc";
							$rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
						
							<label for="new_cFacultyIdold" class="labell_structure">New faculty</label>
							<div class="div_select">
							<select name="new_cFacultyIdold" id="new_cFacultyIdold" class="select" 
								onchange="
								_('frm_upd').value='n_f';
								update_cat_country('new_cFacultyIdold', 'cdeptId_readup', 'new_cdeptold', 'new_cprogrammeIdold');">
								<option value="" selected="selected"></option><?php
								
									while ($table= mysqli_fetch_array($rsql1))
									{?>
										<option value="<?php echo $table[0] ?>"<?php if (isset($_REQUEST['new_cFacultyIdold']) && ($table[0] == strtoupper($_REQUEST['new_cFacultyIdold']))){echo ' selected';}?>>
											<?php echo $table[1];?>
										</option><?php
									}
									mysqli_close(link_connect_db());?>
							</select>
							</div>
							<div id="labell_msg25" class="labell_msg blink_text orange_msg"></div>
						</div>

						<div id="new_cdeptold_div" class="setup_fac_dummy_lass innercont_stff" style="display:<?php if(isset($_REQUEST['what_to_do'])&&isset($_REQUEST['on_what'])&&
							$_REQUEST['what_to_do']=='1'&&($_REQUEST['on_what']=='2'||$_REQUEST['on_what']=='3')){echo 'block';}else{echo 'none';} ?>;">
							<label for="new_cdeptold" class="labell_structure">New department</label>
							<div class="div_select">
							<select name="new_cdeptold" id="new_cdeptold" class="select"
								onchange="_('frm_upd').value='n_d';
								update_cat_country('new_cdeptold', 'cprogrammeId_readup', 'new_cprogrammeIdold', 'new_cprogrammeIdold');">
								<option value="" selected="selected"></option>
							</select>
							</div>
							<div id="labell_msg26" class="labell_msg blink_text orange_msg"></div>
						</div>

						<div id="new_cprogrammeIdold_div" class="setup_fac_dummy_lass innercont_stff" style="display:<?php if(isset($_REQUEST['what_to_do'])&&isset($_REQUEST['on_what'])&& $_REQUEST['what_to_do']=='1'&&$_REQUEST['on_what']=='3'){echo 'block';}else{echo 'none';} ?>;">
							<label for="new_cprogrammeIdold" class="labell_structure">New programme</label>
							<div class="div_select">
							<select name="new_cprogrammeIdold" id="new_cprogrammeIdold" class="select">
								<option value="" selected="selected"></option>
							</select>
							</div>
							<div id="labell_msg27" class="labell_msg blink_text orange_msg"></div>
						</div>

						
						<div id="del_impli" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;">
							<div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
								Confirmation
							</div>
							<a href="#" style="text-decoration:none;">
								<div style="width:20px; float:left; text-align:center; padding:0px;"></div>
							</a>
							<div id="inner_del_impli" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;"></div>
							<div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
								<a href="#" style="text-decoration:none;" 
									onclick="_('del_impli').style.display='none';
								_('confam').value='1';
								chk_inputs();
									return false">
									<div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
										Yes
									</div>
								</a>

								<a href="#" style="text-decoration:none;" 
									onclick="_('del_impli').style.display='none';
									_('smke_screen_2').style.display = 'none';
									_('smke_screen_2').style.zIndex = '-1';
									_('confam').value='0';
									return false">
									<div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
										No
									</div>
								</a>
							</div>
						</div>
					<form>
				</div><?php
			}?>
		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;">
			<div id="pp_box">
				<img name="passprt" id="passprt" src="<?php echo get_pp_pix('');?>" width="95%" height="185"  
				style="margin:0px;<?php if ($currency <> '1' ){?>opacity:0.3;<?php }?>" alt="" />
			</div>
			<!-- InstanceBeginEditable name="EditRegion7" -->
			<!-- InstanceEndEditable -->
		</div>
		<div id="insiderightSide">
			<!-- InstanceBeginEditable name="EditRegion8" -->
                <div class="innercont_stff" style="margin:0px; padding:0px;">
                    <a href="#" style="text-decoration:none;" onclick="_('nxt').action = 'staff_home_page';_('nxt').mm.value='';_('nxt').submit();return false">
                        <div class="basic_three" style="height:auto; width:inherit; padding:8.5px; float:none; margin:0px;">Home</div>
                    </a>
                </div>
                
				<div style="width:auto; padding-top:6px; padding-bottom:4px; border-bottom:1px dashed #888888">
				</div>
				<div style="width:auto; padding-top:10px;">
				</div>
				<div style="width:auto; padding-top:6px; padding-bottom:4px; line-height:1.3; border-bottom:1px dashed #888888">
				</div>
				<!-- InstanceEndEditable -->
		</div>
		<div id="insiderightSide" style="position:relative;">
			<!-- InstanceBeginEditable name="EditRegion9" -->
			<?php require_once ('stff_bottom_right_menu.php');?>
			<!-- InstanceEndEditable -->
		</div>
	</div>
	<div id="futa"><?php foot_bar();?></div>
</div>
</body>
<!-- InstanceEnd --></html>