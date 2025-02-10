<?php
// Date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
	
require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/applform.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php
require_once('var_colls.php');

$currency = eyes_pilled('0');

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
	// function preventBack(){window.history.forward();}
	// setTimeout("preventBack()", 0);
	// window.onunload=function(){null};

    //check_environ();

	function chk_inputs()
	{
		var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			ulChildNodes[j].style.display = 'none';
		}
		
		// var ulChildNodes = _("rtlft_std").getElementsByClassName("innercont_stff_tabs");
		// for (j = 0; j <= ulChildNodes.length-1; j++)
		// {
		// 	ulChildNodes[j].style.display = 'none';
		// }

		// if (_('enq_ans_div'))
		// {
		// 	_('enq_ans_div').style.display = 'none';
		// }
		
		
		if (_('c_material_loc').uvApplicationNo.value == '')
		{
			setMsgBox("labell_msg0","");
			_('c_material_loc').uvApplicationNo.focus();

			if (_("numofreg"))
			{
				_("numofreg").value = 0;
			}
		}else
		{
			var formdata = new FormData();
			
			formdata.append("tabno", _('c_material_loc').tabno.value);
			
			formdata.append("currency", _('c_material_loc').currency.value);
			formdata.append("user_cat", _('c_material_loc').user_cat.value);
			formdata.append("save", _('c_material_loc').save_cf.value);
            
			formdata.append("sm", _('c_material_loc').sm.value);
			formdata.append("mm", _('c_material_loc').mm.value);
			
			formdata.append("uvApplicationNo", _('c_material_loc').uvApplicationNo.value);
			formdata.append("vApplicationNo", _('c_material_loc').vApplicationNo.value);

			formdata.append("iStudy_level", _('c_material_loc').iStudy_level.value);
			formdata.append("tSemester", _('c_material_loc').tSemester.value);
             
			
			if (_("numofreg") && _("numofreg").value > 0 &&_("tabno").value == 1)
			{
				var ulChildNodes = _("ans1").getElementsByTagName("input");
				
				for (j = 1; j <= _("numofreg").value; j++)
                {
					var regCourses = "regCourses"+j;
                    var cAcademicDesc = "cAcademicDesc"+j;
                    var tSemester = "tSemester"+j;

                    if (_(regCourses).checked)
                    {
						formdata.append(regCourses, _(regCourses).value);
                        formdata.append(cAcademicDesc, _(cAcademicDesc).value);
                        formdata.append(tSemester, _(tSemester).value);
					}
				}
				formdata.append("numofreg", _('numofreg').value);
				
				//opr_prep(ajax = new XMLHttpRequest(),formdata);
			}else if (_("tabno").value == 2)
			{
				if (_('ret_gown').value == '1' && _('col_gown').value == '0')
                {
                    setMsgBox("labell_msg2","Return of uncollected gown is not possible");
                    return false;
                }
                
                formdata.append("ret_gown", _('ret_gown').value);
				formdata.append("col_gown", _('col_gown').value);
				//opr_prep(ajax = new XMLHttpRequest(),formdata);
			}else
			{
				//opr_prep(ajax = new XMLHttpRequest(),formdata);
			}

            opr_prep(ajax = new XMLHttpRequest(),formdata);
		}
	}
	
	
	function opr_prep(ajax,formdata)
	{
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		
		ajax.open("POST", "opr_c_material.php");
		ajax.send(formdata);
	}

    function completeHandler(event)
	{
        on_error('0');
        on_abort('0');
        in_progress('0');

		var returnedStr = event.target.responseText.trim();
		_("labell_msg0").style.display = 'none';
		
		if (returnedStr != '' && returnedStr.indexOf("successfully") == -1 && returnedStr.indexOf("retrieved") == -1)
		{
			setMsgBox("labell_msg0", returnedStr);
		}else if (returnedStr.indexOf("successfully") != -1 || returnedStr.indexOf("retrieved") != -1)
		{
            success_box(returnedStr);
			
			_('enq_ans_div').style.display = 'block';
			if (_("tabno").value == 1)
			{
				_('ans1').style.display = 'block';
			}else if (_("tabno").value == 2)
			{
				_('ans2').style.display = 'block';
			}
			
		}else if (!_("numofreg") || (_("numofreg") && _("numofreg").value == 0))
		{
			_('c_material_loc').submit()
		}
		
		_('c_material_loc').save_cf.value = '-1';
	}
		

    function progressHandler(event)
    {
        in_progress('1');
    }

    function errorHandler(event)
    {
        on_error('1');
    }
    
    function abortHandler(event)
    {
        on_abort('1');
    }

    function tab_modify(tab_no)
    {        
        _('c_material_loc').tabno.value = tab_no;
            
        tablinks = document.getElementsByClassName("innercont_stff_tabs");
        for (i = 0; i < tablinks.length; i++) 
        {
        var tab_Id = 'tabss' + (i+1);
        var cover_maincontent_id = 'ans' + (i+1);
        if (tab_no == (i+1))
        {
            _(tab_Id).style.borderBottom = '1px solid #FFFFFF';
            _(cover_maincontent_id).style.visibility = 'visible';
            _(cover_maincontent_id).style.display = 'block';
        }else if (_(tab_Id))
        {
            _(tab_Id).style.border = '1px solid #BCC6CF';
            _(cover_maincontent_id).style.visibility = 'hidden';
            _(cover_maincontent_id).style.display = 'none';
            
            _(tab_Id).style.background = 'none';
        }
        }
    }

    function centre_select()
    {
        return true;

        if (_("user_centre_loc").value == '')
        {
            return false;
        }

        if (_("service_mode_loc").value == '')
        {
            return false;
        }

        return true;
    }
</script><?php

include ('set_scheduled_dates.php');?>
<!-- InstanceEndEditable -->
</head>
<body onLoad="checkConnection()">
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
<div id="container"><?php
	time_out_box($currency);?>

	<noscript>
		<div class="smoke_scrn" style="display:block"></div>
		<?php information_box_inline('You need to enable javascript for this browser');?>
	</noscript>
	<?php do_toup_div('Student Management System');?>
	<div id="menubar">
		<!-- InstanceBeginEditable name="menubar" -->
		<?php include ('menu_bar_content_stff.php');?>
		<!-- InstanceEndEditable -->
	</div>

	<div id="leftSide_std" style="margin-left:0px;"><?php
		include ('stff_left_side_menu.php');?>
	</div>
	<div id="rtlft_std" style="position:relative;">
		<!-- InstanceBeginEditable name="EditRegion6" -->			
			
			<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
			
            <div class="innercont_top" style="float:left">Issuance/retrieval of course material/gown</div>
            
            <form action="student-collections" method="post" target="_self" name="c_material_loc" id="c_material_loc" enctype="multipart/form-data">
                <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];}; ?>" />
                <input name="user_cat" id="user_cat" type="hidden" value="<?php echo $_REQUEST['user_cat']; ?>" />	
                <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                <input name="sm" id="sm" type="hidden" value="<?php echo $sm ?>" />
                <input name="mm" id="mm" type="hidden" value="<?php echo $mm ?>" />
                <input name="save" id="save" type="hidden" value="-1" />
                <input name="save_cf" id="save_cf" type="hidden" value="-1" />
                <input name="tabno" id="tabno" type="hidden" value="1"/>
                <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />						
                
                <input name="iStudy_level" id="iStudy_level" type="hidden" value="<?php if (isset($iStudy_level)){echo $iStudy_level;} ?>" />
                <input name="cAcademicDesc" id="cAcademicDesc" type="hidden" value="<?php if (isset($orgsetins['cAcademicDesc'])){echo $orgsetins['cAcademicDesc'];} ?>" />
                <input name="tSemester" id="tSemester" type="hidden" value="<?php if (isset($tSemester)){echo $tSemester;} ?>" />
                <input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />
                
                <input name="service_mode" id="service_mode" type="hidden" 
                value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
                else if (isset($study_mode)){echo $study_mode;}?>" />
                <input name="num_of_mode" id="num_of_mode" type="hidden" 
                value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
                else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

                <input name="user_centre" id="user_centre" type="hidden" 
                value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}?>" />
                <input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
                value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
                else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />

                <div id="appl_box" class="innercont_stff">
                    <label for="vApplicationNo" class="labell">Matriculation number</label>
                    <div class="div_select">
                        <input name="uvApplicationNo" id="uvApplicationNo" type="text" class="textbox" value="<?php if (isset($_REQUEST['uvApplicationNo'])){echo $_REQUEST['uvApplicationNo'];} ?>" />
                    </div>
                    <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
                </div>
            </form>
            <div class="innercont_stff" id="enq_ans_div" style="display:<?php if (isset($_REQUEST['save_cf'])&&$_REQUEST['save_cf']=='1'){?>block<?php }else{?>none<?php }?>;">  
                <div id="cover_tab" class="frm_element_tab_cover frm_element_tab_cover_std">                        
                    <a href="#" onclick="tab_modify('1')">
                        <div id="tabss1" class="tabss tabss_std" style=" border-bottom:1px solid #FFFFFF;">
                            Course material
                        </div>
                    </a>
                    <a href="#" onclick="tab_modify('2')">
                        <div id="tabss2" class="tabss tabss_std">
                            Gown
                        </div>
                    </a>
                </div>
            </div>

            <div class="innercont_stff_tabs" id="ans1" 
                style="display:<?php if (isset($_REQUEST['save_cf']) && $_REQUEST['save_cf'] == '1'){?>block<?php }else{?>none<?php }?>; width:100%; padding:0px; border:none; height:76.3%;">
                <?php 
                if (isset($_REQUEST['save_cf']) && $_REQUEST['save_cf'] == '1')
                {
                    $stmt = $mysqli->prepare("SELECT d.cCourseId, d.vCourseDesc, d.cAcademicDesc, d.siLevel, d.tSemester, d.iCreditUnit, d.tdate, d.cCategory, c_mat, date_c_mat
                    FROM coursereg_arch d
                    WHERE d.vMatricNo = ? 
                    ORDER BY d.siLevel, d.tSemester, d.cCourseId");
                    $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($cCourseId_01, $vCourseDesc_01, $cAcademicDesc_01, $siLevel_01, $tSemester_01, $iCreditUnit_01, $tdate_01, $cCategory_01, $c_mat, $date_c_mat);?>							
                    
                    <div class="innercont_stff" style="height:auto; margin-top:5px; font-weight:bold;">
                        <div class="ctabletd_1" style="width:5.3%; height:auto; padding-right:3px; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; border-radius: 4px 0px 0px 0px;">
                            Sn
                        </div>
                        <div class="ctabletd_1" style="width:12.1%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; margin-left:-1px; background-color:#E3EBE2; border:1px solid #A7BAAD;  text-align:left;">
                            Course Code
                        </div>
                        <div class="ctabletd_1" style="width:37.6%; height:auto; padding-top:8px; padding-bottom:8px; margin-left:-1px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; text-indent:2px;">
                            Course Title
                        </div>
                        <div class="ctabletd_1" style="width:7.2%; height:auto; padding-right:3px; padding-top:8px; padding-bottom:8px; margin-left:-1px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
                            Cr. Unit
                        </div>
                        <div class="ctabletd_1" style="width:7.7%; height:auto; padding-top:8px; padding-bottom:8px; margin-left:-1px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center;">
                            Session
                        </div>
                        <div class="ctabletd_1" style="width:9.9%; height:auto; padding-right:3px; padding-top:8px; padding-bottom:8px; margin-left:-1px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; ">
                            Fee (NGN)
                        </div>
                        <div class="ctabletd_1" style="width:6.2%; height:auto; padding-top:8px; padding-bottom:8px; margin-left:-1px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center;">
                            Status
                        </div>
                        <div class="ctabletd_1" style="width:11.2%; height:auto; padding-top:8px; padding-bottom:8px; margin-left:-1px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center;border-radius: 0px 4px 0px 0px;">
                            Date
                        </div>
                    </div>

                    <div id="rtside" class="innercont_stff" style="height:90%; overflow:scroll; overflow-x: hidden;"><?php
                        $c = 0; 
                        $total_cost = 0; 
                        $total_cr = 0;
                        $background_color='';

                        $prev_level = '';
						$prev_semester = '';

                        $sql_feet_type = select_fee_srtucture($uvApplicationNo_2, $cResidenceCountryId_1);
                        
                        while($stmt->fetch())
                        {						
                            $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
							FROM s_f_s a, fee_items b
							WHERE a.fee_item_id = b.fee_item_id
							AND fee_item_desc = 'Course Registration'
							AND iCreditUnit = $iCreditUnit_01
							AND cEduCtgId = '$cEduCtgId'
							AND cFacultyId = '$cFacultyId'
                            AND b.cdel = 'N'
							$sql_feet_type");

							$stmt_amount->execute();
							$stmt_amount->store_result();
							$stmt_amount->bind_result($amount_01, $itemid);
							$stmt_amount->fetch();
							$stmt_amount->close();
                            
                            $c++;
                            if ($c%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}                            
                            
							if (($prev_level == '' || $prev_level <> $siLevel_01) || ($prev_semester <> '' && $prev_semester <> $tSemester_01))
							{?>
								<div class="_label" style="; font-weight:bold; border:1px solid #cdd8cf; width:97.8%; padding-left:0.6%; padding-top:0.6%; padding-bottom:0.7%; background-color:<?php echo $background_color;?>; text-align:left; margin-bottom:4px; margin-top:15px;">
									<?php echo $siLevel_01.'Level, Semester: '.$tSemester_01; ?>
								</div><?php
							}?>
                            <label class="lbl_beh" title="<?php echo 'Date collected: '.formatdate($date_c_mat,'fromdb'); ?>">
                                <div class="_label" style="border:1px solid #cdd8cf; width:5.1%; padding-right:0.5%; padding-top:0.5%; padding-bottom:0.5%; background-color:<?php echo $background_color;?>; text-align:right">
                                    <?php echo $c;?>
                                </div>
                                <div class="_label" style="border:1px solid #cdd8cf; width:11.7%; padding-left:0.5%; padding-top:0.2%; padding-bottom:0.5%; background-color:<?php echo $background_color;?>; text-align:left">
                                    <input name="regCourses<?php echo $c ?>" id="regCourses<?php echo $c ?>" type="checkbox"
                                        value="<?php echo $cCourseId_01;?>" 
                                        <?php if ($c_mat == '1'){echo ' checked';}
                                        if (!($iStudy_level == $siLevel_01 && $tSemester == $tSemester_01)){echo ' disabled';}?>/>
                                        <?php echo $cCourseId_01;?>
                                </div>
                                <div class="_label" style="border:1px solid #cdd8cf; width:37.4%; padding-left:0.5%; padding-top:0.5%; padding-bottom:0.5%; background-color:<?php echo $background_color;?>; text-align:left">
                                    <?php echo $vCourseDesc_01;?>
                                </div>
                                <div class="_label" style="border:1px solid #cdd8cf; width:7.1%; padding-right:0.5%; padding-top:0.5%; padding-bottom:0.5%; background-color:<?php echo $background_color;?>; text-align:right">
                                    <?php echo $iCreditUnit_01;$total_cr = $total_cr + $iCreditUnit_01;?>
                                </div>
                                <div class="_label" style="border:1px solid #cdd8cf; width:6.9%; padding-left:0.5%; padding-top:0.5%; padding-bottom:0.5%; background-color:<?php echo $background_color;?>; text-align:right">
                                    <?php echo substr($cAcademicDesc_01, 0, 4);?>
                                    <input name="cAcademicDesc<?php echo $c ?>" id="cAcademicDesc<?php echo $c ?>" type="hidden" value="<?php echo $cAcademicDesc_01;?>"/>
                                    <input name="tSemester<?php echo $c ?>" id="tSemester<?php echo $c ?>" type="hidden" value="<?php echo $tSemester_01;?>"/>
                                </div>
                                <div class="_label" style="border:1px solid #cdd8cf; width:9.8%; padding-right:0.5%; padding-top:0.5%; padding-bottom:0.5%; background-color:<?php echo $background_color;?>; text-align:right">
                                    <?php echo number_format($amount_01);$total_cost = $total_cost + $amount_01;?>
                                </div>
                                <div class="_label" style="border:1px solid #cdd8cf; width:6%; padding-right:0.5%; padding-top:0.5%; padding-bottom:0.5%; background-color:<?php echo $background_color;?>; text-align:center">
                                    <?php echo $cCategory_01;?>
                                </div>
                                <div class="_label" style="border:1px solid #cdd8cf; width:8%; padding-left:0.5%; padding-top:0.5%; padding-bottom:0.5%; background-color:<?php echo $background_color;?>; text-align:center">
                                    <?php echo substr($tdate_01,8,2).'/'.substr($tdate_01,5,2).'/'.substr($tdate_01,0,4);?>
                                </div>
                            </label><?php 

							$prev_level = $siLevel_01;
							$prev_semester = $tSemester_01;
                        }
                        $stmt->close();?>						
                    </div>
                        
                    <input name="numofreg" id="numofreg" type="hidden" value="<?php echo $c; ?>" /><?php
                }?>
                
                <div class="innercont_stff">
                    <label class="lbl_beh" style="margin-top:4px">
                        <div class="_label" style="border:1px solid #cdd8cf; width:55.47%; padding-right:0.5%; padding-top:0.5%; padding-bottom:0.5%; background-color:<?php echo $background_color;?>; text-align:right">
                            Total
                        </div>
                        <div class="_label" style="border:1px solid #cdd8cf; width:6.9%; padding-right:0.5%; padding-top:0.5%; padding-bottom:0.5%; background-color:<?php echo $background_color;?>; text-align:right">
                            <?php echo $total_cr ?>
                        </div>
                        <div class="_label" style="border:1px solid #cdd8cf; width:6.8%; padding-left:0.5%; padding-top:0.5%; padding-bottom:0.5%; background-color:<?php echo $background_color;?>; text-align:center">
                            -
                        </div>
                        <div class="_label" style="border:1px solid #cdd8cf; width:9.6%; padding-right:0.5%; padding-top:0.5%; padding-bottom:0.5%; background-color:<?php echo $background_color;?>; text-align:right">
                            <?php echo number_format($total_cost) ?>
                        </div>
                        <div class="_label" style="border:1px solid #cdd8cf; width:14.8%; padding-right:0.5%; padding-top:0.5%; padding-bottom:0.5%; background-color:<?php echo $background_color;?>; text-align:right">
                            -
                        </div>
                    </label>
                </div>
            </div>
            
            <div class="innercont_stff_tabs" id="ans2" style="height:79%; display:none;">
                <!-- <div class="innercont">-->
                <div class="innercont_stff"><?php
                    $vMatricNo = "";
                    if (isset($_REQUEST['uvApplicationNo'])){$vMatricNo = "%{$_REQUEST['uvApplicationNo']}%";}
                    
                    $stmt = $mysqli->prepare("SELECT tDeedTime from atv_log where vDeed like ? and vDeed like '%issued gown to%' order by tDeedTime DESC limit 1");
                    $stmt->bind_param("s", $vMatricNo);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($issued_tDeedTime);
                    $stmt->fetch();
                    $stmt->close();?>
                    <div class="div_select" style="width:auto">
                        <input name="col_gown" id="col_gown" 
                        onclick="if(this.checked)
                        {
                            this.value=1;
                            _('ret_gown').checked = false
                        }else
                        {
                            this.value=0
                        }"
                        value="<?php if ($col_gown=='1'){echo '1';}else{echo '0';} ?>" <?php if ($col_gown=='1'){echo 'checked';} ?> 
                        type="checkbox"/>
                    </div>
                    <div class="div_select" style="width:auto">
                        <label for="col_gown" id="col_gown_lbl">
                            Collected gown <b><?php if (isset($issued_tDeedTime)){echo 'on '.formatdate(substr($issued_tDeedTime,0,10),'fromdb').' '.substr($issued_tDeedTime,11,8);}?></b>
                        </label>
                    </div>
                    <div id="labell_msg1" class="labell_msg blink_text orange_msg"></div>
                </div>
                <div class="innercont_stff"><?php
                    $vMatricNo = "";
                    if (isset($_REQUEST['uvApplicationNo'])){$vMatricNo = "%{$_REQUEST['uvApplicationNo']}%";}
                    
                    $stmt = $mysqli->prepare("SELECT tDeedTime from atv_log where vDeed like ? and vDeed like '%issued gown%' order by tDeedTime DESC limit 1");
                    $stmt->bind_param("s", $vMatricNo);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($retrieval_tDeedTime_01);
                    $stmt->fetch();
                    $stmt->close();?>
                   
                    <div class="div_select" style="width:auto">
                        <input name="ret_gown" id="ret_gown" 
                        onclick="if(this.checked)
                        {
                            this.value=1;
                            _('col_gown').checked = false;
                        }else
                        {
                            this.value=0;
                        }"
                        value="<?php if ($ret_gown=='1'){echo '1';}else{echo '0';} ?>" <?php if ($ret_gown=='1'){echo 'checked';} ?> 
                        type="checkbox"/>
                    </div><?php                    
                    
                    $stmt = $mysqli->prepare("SELECT tDeedTime from atv_log where vDeed like ? and vDeed like '%retrieved gown%' order by tDeedTime DESC limit 1");
                    $stmt->bind_param("s", $vMatricNo);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($retrieval_tDeedTime_01);
                    $stmt->fetch();
                    $stmt->close();?>						
                    
                    <div class="div_select" style="width:auto">
                        <label for="ret_gown" id="ret_gown_lbl">
                            Returned gown<b> <?php if (isset($retrieval_tDeedTime_01)){echo 'on '.formatdate(substr($retrieval_tDeedTime_01,0,10),'fromdb').' '.substr($retrieval_tDeedTime_01,11,8);}?></b>
                        </label>
                    </div>
                    <div id="labell_msg2" class="labell_msg blink_text orange_msg"></div>
                </div>
            </div>
            <!-- </form> -->
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
                
				<?php side_detail('');?>
				<!-- InstanceEndEditable -->
		</div>
		<div id="insiderightSide" style="position:relative;">
			<!-- InstanceBeginEditable name="EditRegion9" -->
			<?php include ('stff_bottom_right_menu.php');?>
			<!-- InstanceEndEditable -->
		</div>
	</div>
	<div id="futa"><?php foot_bar();?></div>
</div>
</body>
<!-- InstanceEnd --></html>