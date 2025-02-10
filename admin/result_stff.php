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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php
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
<script language="JavaScript" type="text/javascript" src="./bamboo/stff_rslt.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />
<script language="JavaScript" type="text/javascript">
	
</script>
<noscript></noscript>

<!-- InstanceBeginEditable name="head" -->
<script language="JavaScript" type="text/javascript">
    
</script><?php

require_once ('set_scheduled_dates.php');?>
<!-- InstanceEndEditable -->
</head>
<body>
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
<div id="container" style="position:relative">
    <div id="container_cover_in"
        style="background:#FFFFFF;
        top:15px;
        right:15px;
        height:650px;
        width:450px;
        box-shadow: 4px 4px 4px #888888;
        display:none; 
        position:absolute;
        text-align:center; 
        padding:8px;
        padding-right:5px;
        padding-top:0px;
        border: 1px solid #CCCCCC;
        font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px">
        <div class="innercont_stff" 
            style="float:left;
            width:449px;
            height:auto;
            padding:0px;
            border-bottom: 1px solid #ccc;
            margin-bottom:5px">
            <div id="div_header_left" class="innercont_stff" 
                style="text-align:left;
                float:left;
                width:420px;
                height:18px;
                color:#FF3300;
                padding-top:8px;
                padding-bottom:4px;">List of Affected Matirculation Numbers
            </div>

            <a href="#"id="closex"
                onclick="_('container_cover_in').style.display = 'none';
                _('container_cover_in').style.zIndex = -1;
                _('container_cover').style.display = 'none';
                _('container_cover').style.zIndex = -1;
                return false" 
                style="color:#666666; text-decoration:none;text-shadow: 0 1px 0 #fafafa;">
                <div id="div_header_left" class="innercont_stff" 
                style="float:left;
                width:25px;
                height:18px;
                padding-top:8px;
                padding-bottom:4px;
                text-align:center;">
                    <img style="width:15px; height:15px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" />
                </div>
            </a>
        </div>
        <div id="message_text" style="float:left; margin-top:5px; height:605px; width:448px; overflow:auto; text-align:left; line-height:1.5"></div>
    </div>
    
    <div id="container_cover_in2"
        style="background:#FFFFFF;
        top:150px;
        left:330px;
        height:440px;
        width:725px;
        box-shadow: 4px 4px 4px #888888;
        display:none; 
        position:absolute;
        text-align:center; 
        padding:5px;
        border: 1px solid #CCCCCC;
        font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px"
        title="Press escape or double-click to remove"
        ondblclick="this.style.display='none'">
        <div class="innercont_stff" 
            style="float:left;
            width:inherit;
            height:inherit;
            padding:0px;
            border-bottom: 0px solid #ccc;">
            <div id="div_header_left2" class="innercont_stff" 
                style="text-align:left;
                float:left;
                width:636px;
                height:13px;
                padding-top:3px;
                border:none;
                margin-left:-1px;
                padding-bottom:4px;">
            </div>
            <a href="#"
            onclick="prns_form.vMatricNo.value=result_stff_loc.vMatricNo.value;
            prns_form.whattodo_1.value=result_stff_loc.whattodo.value;
            prns_form.schl_session_1.value=result_stff_loc.schl_session.value;
            prns_form.std_set_1.value=result_stff_loc.std_set.value;
            
            if (result_stff_loc.topupbacklog.checked)
            {
                prns_form.topupbacklog_1.value='1';
            }else
            {
                prns_form.topupbacklog_1.value='0';
            }
                            
            prns_form.courseId_1.value=result_stff_loc.courseId1.value;
            prns_form.coursedesc_1.value=result_stff_loc.courseId1.options[result_stff_loc.courseId1.selectedIndex].text.substr(6);

            prns_form.cFacultyId1_012_1.value=result_stff_loc.cFacultyId1_012.value;
            prns_form.cFacultyDesc_012.value=result_stff_loc.cFacultyId1_012.options[result_stff_loc.cFacultyId1_012.selectedIndex].text;

            prns_form.cdept_012_1.value=result_stff_loc.cdept_012.value;
            prns_form.cdeptDesc_012.value=result_stff_loc.cdept_012.options[result_stff_loc.cdept_012.selectedIndex].text.substr(4);

            prns_form.cprogrammeId_012_1.value=result_stff_loc.cprogrammeId_012.value;
            prns_form.cprogrammeDesc_012.value=result_stff_loc.cprogrammeId_012.options[result_stff_loc.cprogrammeId_012.selectedIndex].text;

            prns_form.action = 'print-mms-result';

            prns_form.submit();

            return false" style=" display:block">
                <input type="button" value="Print" class="basic_three_stff_bck_btns" 
                    style="float:left; width:90px; margin-top:-1px; padding-top:3px; height:21px; margin-right:0px;margin-bottom:5px;"/>
            </a>

            <div id="message_text2" style="float:left; margin-top:5px; width:inherit; text-align:left; line-height:1.5; margin-bottom:-1px; font-size:11px; display:none">
                <div class="ctabletd_1" style="width:40px; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; padding-right:3px;">Sno</div>
                <div class="ctabletd_1" style="width:83px;height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; text-indent:2px;">Course code</div>
                <div class="ctabletd_1" style="width:350px; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; text-indent:2px;">Course title</div>
                <div class="ctabletd_1" style="width:35px; height:17px; padding-top:5px; padding-right:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;" title="Credit unit">CU</div>
                <div class="ctabletd_1" style="width:50px; height:17px; padding-top:5px; padding-right:2px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">CA</div>
                <div class="ctabletd_1" style="width:50px; height:17px; padding-top:5px; padding-right:2px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Exam</div>
                <div class="ctabletd_1" style="width:70px; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Score(%)</div>
            </div>
            
            <div id="message_text3" style="float:left; margin-top:5px; width:inherit; text-align:left; line-height:1.5; margin-bottom:-1px; font-size:11px; display:none">
                <div class="ctabletd_1" style="width:50px; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; padding-right:3px;">Sno</div>
                <div class="ctabletd_1" style="width:170px;height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; text-indent:2px; margin-left:-1px">Matriculation number</div>
                <div class="ctabletd_1" style="width:310px;height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; text-indent:2px; margin-left:-1px">Name</div>
                <div class="ctabletd_1" style="width:50px; height:17px; padding-top:5px; padding-right:2px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; margin-left:-1px">CA</div>					
                <div class="ctabletd_1" style="width:50px; height:17px; padding-top:5px; padding-right:2px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; margin-left:-1px">Exam</div>
                <div class="ctabletd_1" style="width:55px; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; margin-left:-1px">Score(%)</div>
            </div>
        </div>
    </div>
    
    <div id="conf_box_loc" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
        <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
            Confirmation
        </div>
        <a href="#" style="text-decoration:none;">
            <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
        </a>
        <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;"></div>
        <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
            <a href="#" style="text-decoration:none;" 
                onclick="_('conf_box_loc').style.display='none';
                _('result_stff_loc').conf.value='1';
                result_stff_loc.save.value = 1;
                check_inputs();
                return false">
                <div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
                    Yes
                </div>
            </a>

            <a href="#" style="text-decoration:none;" 
                onclick="_('result_stff_loc').conf.value='';
				_('conf_box_loc').style.display='none';
                return false">
                <div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
                    No
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
		<!-- InstanceBeginEditable name="EditRegion6" -->
            <form action="result-format" method="post" name="excel_export" id="excel_export" target="_blank" enctype="multipart/form-data"></form>
            
            <form action="print-result" method="post" name="prns_form" target="_blank" id="prns_form" enctype="multipart/form-data">
                <input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];}; ?>" />
                <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];}; ?>" />
                <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                <input name="mm" type="hidden" value="<?php if (isset($_REQUEST["mm"])){echo $_REQUEST["mm"];} ?>" />
                <input name="sm" type="hidden" value="<?php if (isset($_REQUEST["sm"])){echo $_REQUEST["sm"];} ?>" />
                <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                <input name="save" id="save" type="hidden" value="-1" />
                <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                
                <input name="student_name" id="student_name" type="hidden" />

                <input name="whattodo_1" id="whattodo_1" type="hidden" />
                <input name="courseId_1" id="courseId_1" type="hidden" />
                <input name="schl_session_1" id="schl_session_1" type="hidden" />
                <input name="std_set_1" id="std_set_1" type="hidden" />
                
                <input name="topupbacklog_1" id="topupbacklog_1" type="hidden" />	
                <input name="staff_study_center" id="staff_study_center" type="hidden" value="<?php if (isset($staff_study_center_u)){echo $staff_study_center_u;}?>"/>						
                
                <input name="cFacultyDesc_012" id="cFacultyDesc_012" type="hidden" />
                <input name="cdeptDesc_012" id="cdeptDesc_012" type="hidden" />
                <input name="cprogrammeDesc_012" id="cprogrammeDesc_012" type="hidden" />
                <input name="coursedesc_1" id="coursedesc_1" type="hidden" />
                    
                <input name="cFacultyId1_012_1" id="cFacultyId1_012_1" type="hidden" />
                <input name="cdept_012_1" id="cdept_012_1" type="hidden" />
                <input name="cprogrammeId_012_1" id="cprogrammeId_012_1" type="hidden" />

                <input name="select_semester_1" id="select_semester_1" type="hidden" />
                <input name="select_level_1" id="select_level_1" type="hidden" />
                <input name="ben_inst" id="ben_inst" type="hidden" />
                
                <input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />

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
            </form>
            

			<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
            <div class="innercont_top">Manage Assessment Result</div>
            
            <form action="manage-result" method="post" name="result_stff_loc" id="result_stff_loc" enctype="multipart/form-data">
                <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];}; ?>" />
                
                <input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];}; ?>" />
                <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                <input name="side_menu_no" type="hidden" value="17" />
                <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                <input name="save" id="save" type="hidden" value="-1" />
                <input name="save_cf" id="save_cf" type="hidden" value="" />
                <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                <input name="sm" id="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
                <input name="mm" id="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
                <input name="conf" id="conf" type="hidden" value="0" />

                <!-- <input name="study_mode" id="study_mode" type="hidden" value="<?php //if (isset($_REQUEST["study_mode"]) && $_REQUEST["study_mode"] <> ''){echo $_REQUEST["study_mode"];}else if ($num_of_mode <= 1){echo $study_mode;}?>" />	 -->

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
                
                <input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />
                
                <!-- <input name="grade_dist" id="grade_dist" type="hidden" value="<?php if (isset($_REQUEST["grade_dist"]) && $_REQUEST["grade_dist"] <> ''){echo $_REQUEST["grade_dist"];}?>" /> -->
                
                <input name="sRoleID_u" id="sRoleID_u" type="hidden" value="<?php if (isset($sRoleID_u) && $sRoleID_u <> ''){echo $sRoleID_u;}?>" />

                <input name="session_of_result_upload" id="session_of_result_upload" type="hidden" value="<?php if (isset($orgsetins["session_of_result_upload"])){echo $orgsetins["session_of_result_upload"];}?>" />
                <input name="semester_of_result_upload" id="semester_of_result_upload" type="hidden" value="<?php if (isset($orgsetins["semester_of_result_upload"])){echo $orgsetins["semester_of_result_upload"];}?>" />

                <input name="whattodo" id="whattodo" type="hidden" value="4" />
				
    
                <div id="succ_boxt" class="succ_box blink_text orange_msg" style="line-height:1.5; width:98.5%"></div>

                <div id="schl_session_div" class="innercont_stff" style="margin-top:4px; display:block;">
                    <label for="schl_session" class="labell">Session</label>
                    <div class="div_select">								
                        <select id="schl_session" name="schl_session" class="select">
							<option value='' selected></option><?php
							$maxyr = substr($orgsetins['cAcademicDesc'],0,4);
                            for ($y = ($maxyr - 1); $y <= $maxyr; $y++)
                            {
                                //$sessn = $y.'/'.($y+1);
                                if ($y%5==0)
                                {?>
                                    <option disabled></option><?php
                                }?>
                                <option value="<?php echo $y; ?>">
                                    <?php echo $y; ?>
                                </option><?php
                            }?>
                        </select>
                    </div>
                    <div class="labell_msg blink_text orange_msg" id="labell_msg7" style="width:280px"></div>
                </div>

                <div id="schl_semester_div" class="innercont_stff" style="margin-top:4px; display:block;">
                    <label for="schl_semester" class="labell">Semester</label>
                    <div class="div_select">								
                        <select id="schl_semester" name="schl_semester" class="select">
                            <option value="" selected></option>
                            <option value="1">First semester</option>
                            <option value="2">Second semester</option>
                        </select>
                    </div>
                    <div class="labell_msg blink_text orange_msg" id="labell_msg7a" style="width:280px"></div>
                </div>

                <div id="container_cover_in_chkps" class="center" style="display: none; 
                flex-direction:column; 
                gap:8px;  
                justify-content:space-around; 
                height:auto;
                padding:10px;
                box-shadow: 2px 2px 8px 2px #726e41;
                z-Index:3;
                background-color:#fff;" title="Press escape to close">
                    <div style="line-height:1.5; width:70%; font-weight:bold">
                        Required columns
                    </div>
                    <div style="line-height:1.5; width:20; position:absolute; top:10px; right:10px;">
                        <img style="width:17px; height:17px; cursor:pointer" src="./img/close.png" 
                        onclick="_('container_cover_in_chkps').style.zIndex = -1;
                            _('container_cover_in_chkps').style.display = 'none';"/>
                    </div>
    
                    <div style="line-height:1.4; padding:8px 5px 8px 5px; width:99%; background-color: #fdf0bf;">
                        Required columns in the csv file to be uploaded are:
                    </div>
    
                    <div style="line-height:2;">
                        <ol>
                            <li>
                                Matriculation number
                            </li>
                            <li>
                                 Course code
                            </li>
                            <li>
                                Score
                            </li>
                            <li>
                                Grade
                            </li>
                        </ol>
                    </div>
                </div>
                
                <div class="innercont_stff" style="margin-top:10px;" title="Only CSV file">
                    <label for="sbtd_pix" class="labell">Upload csv file of result</label>
                    <div class="div_select">
                        <input type="file" name="sbtd_pix" id="sbtd_pix"  style="width:223px">
                    </div>
                    <input name="readyToGo" id="readyToGo" type="hidden" value="0" />	
                    <div class="labell_msg blink_text orange_msg" id="labell_msg8"  style="width:280px"></div>		
                </div>
                
                <div id="sbtd_pix_div" class="innercont_stff" style="margin-top:10px;">
                    <label class="labell" onmouseover="_('container_cover_in_chkps').style.zIndex = 2;_('container_cover_in_chkps').style.display='flex'">See format of content of file</label>	
                </div>

                <div id="topupbacklog_div" class="innercont_stff" style="margin-top:10px; display:none">
                    <div class="innercont" style="width:166px; float:left; height:19px; margin-right:10px; text-align:right;">
                        <input name="topupbacklog" id="topupbacklog" style="margin-right:0px" 
                        onclick="if (result_stff_loc.user_centre.value == '044' || result_stff_loc.user_centre.value == '049')
                        {
                            if(this.checked)
                            {
                                _('schl_session').disabled=false
                            }else
                            {
                                _('schl_session').disabled=true
                            }
                        }
                        _('succ_boxt').style.display='none'" type="checkbox"/>
                    </div>							
                    <div class="innercont" style="width:auto; height:16px; float:left; padding-top:3px">
                        <label for="topupbacklog">
                            Topup backlog
                        </label>
                    </div>
                    <div class="labell_msg blink_text orange_msg" id="labell_msg15" style="width:280px"></div>		
                </div>
                
                <div id="mat_div" class="innercont_stff" style="margin-top:10px; display:none">
                    <label for="vMatricNo" class="labell">Matriculation number</label>
                    <div class="div_select">
                        <input name="vMatricNo" id="vMatricNo" type="text" class="textbox" onchange="this.value=this.value.trim()" value="FTP/AEE/2018/2002"/>
                    </div>
                    <div class="labell_msg blink_text orange_msg" id="labell_msg9" style="width:280px"></div>
                </div>					
                
                <div id="obtained_ca_div" class="innercont_stff" style="display:none" title="(Re-)set obataineable, if there are no options here">
                    <label for="obtained_ca" class="labell">CA Score</label>
                    <div class="div_select">
                        <select id="obtained_ca" name="obtained_ca" class="select">
                            <option value="" selected></option>
                        </select>
                    </div>
                    <div class="labell_msg blink_text orange_msg" id="labell_msg10" style="width:280px"></div>
                </div>					
                
                <div id="obtained_ex_div" class="innercont_stff" style="display:none" title="(Re-)set obataineable, if there are no options here">
                    <label for="obtained_ex" class="labell">Exam score</label>
                    <div class="div_select">
                        <select id="obtained_ex" name="obtained_ex" class="select">
                            <option value="" selected></option>
                        </select>
                    </div>
                    <div class="labell_msg blink_text orange_msg" id="labell_msg10a" style="width:280px"></div>
                </div>

                <div id="select_level_div" class="innercont_stff" style="margin-top:4px; display:none;">
                    <label for="select_level" class="labell">Level</label>
                    <div class="div_select">								
                        <select id="select_level" name="select_level" class="select">
                        <option value=""></option>
                        <option value="20">DIP1</option>
                        <option value="30">DIP2</option>
                        <option disabled></option><?php
                            for ($y = 100; $y < 800; $y+=100)
                            {?>
                                <option value="<?php echo $y; ?>">
                                    <?php echo $y; ?>
                                </option><?php
                            }?>
                        </select>
                    </div>
                    <div class="labell_msg blink_text orange_msg" id="labell_msg12" style="width:280px"></div>
                </div>
                
                <div id="ben_inst_div" class="innercont_stff" style="margin-top:10px; display:none">
                    <label for="ben_inst" class="labell">Destination</label>
                    <div class="div_select">
                        <input name="ben_inst" id="ben_inst" type="text" class="textbox"/>
                    </div>
                    <div class="labell_msg blink_text orange_msg" id="labell_msg14" style="width:280px"></div>
                </div>
            </form>
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
					<?php echo strtoupper($vLastName).'<br>'.ucwords(strtolower($vFirstName)).' '.ucwords(strtolower($vOtherName));?>
				</div>
				<div style="width:auto; padding-top:10px;"><?php 
					if (!is_bool(strpos($vProgrammeDesc,"(d)")))
					{
						$vProgrammeDesc = substr($vProgrammeDesc, 0, strlen($vProgrammeDesc)-4);
					}
					echo $vObtQualTitle.'<br>'.$vProgrammeDesc;?>
				</div>
				<div style="width:auto; padding-top:6px; padding-bottom:4px; line-height:1.3; border-bottom:1px dashed #888888">
					<?php if ($iStudy_level == 30)
					{
						echo 'DIP 1<br>';
					}else if ($iStudy_level == 40)
					{
						echo 'DIP 2<br>';
					}else if ($iStudy_level <> '')
					{
						echo $iStudy_level.'Level<br>';
					}

					if ($vLastName <> '')
                    {
                        if ($orgsetins["tSemester"] == 1){echo 'First';}else{echo 'Second';}?> semester<?php
                    }

					echo '<br>'.$vCityName;?>
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