<?php
require_once('good_entry.php');
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once(BASE_FILE_NAME.'lib_fn.php');

require_once('std_lib_fn.php');
	
require_once (BASE_FILE_NAME.'remita_constants.php');?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="<?php echo BASE_FILE_NAME;?>js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/reg_crs.js"></script>
        
        <script language="JavaScript" type="text/javascript">
            function chk_inputs()
            {
                var totCredUnit = 0;
                var boxchk = 0; 
                var boxavail = 0;
                
                var formdata = new FormData();
                
                if (_("resend_req").value == '1')
                {
                    with (course_form)
                    {
                        formdata.append("resend_req", '1');
                        formdata.append("conf", '1');
                    }
                }else 
                {
                    totCredUnit = parseInt(_('grand_total_credit_unit').value);

                    total_unit_carried =  parseInt(totCredUnit) + parseInt(_('carried_crload').value);

                    if (total_unit_carried > _("max_crload").value)
                    {
                        caution_inform(total_unit_carried +' credit units already registered for the semester<br> Addition of '+totCredUnit+' units exceeds '+_("max_crload").value+' maximum credit unit load for the smester.');
                        return false;
                    }
                    
                    for (var cnt = 1; cnt <= _('loc_numOfiputTag_0').value; cnt++)
                    {
                        if (_('regCourses'+cnt) && !_("regCourses"+cnt).disabled)
                        {
                            if (_('regCourses'+cnt).type == 'checkbox')
                            {
                                boxavail++;
                                if (_('regCourses'+cnt).checked){boxchk++;}
                            }
                        }
                    }
                    
                    if (boxavail == 0)
                    {
                        caution_inform('You have registered all available courses for this semester');
                        return false;
                    }
                
                    if (boxchk == 0)
                    {
                        caution_inform('Select one or more courses to register');
                        return false;
                    }			
                
                    if (course_form.cEduCtgId.value != 'ELX' && (parseInt(_('grand_total_amount').value) > parseInt(_('student_balance').value) || _('student_balance').value <= 0))
                    {
                        caution_inform("<b>Insufficient fund</b><br>To fund your eWallet:<p>1. Click the Ok button<br>2. Click 'Bursary' above<br>3. Click 'Make payment' (left)<br>4. Follow the prompt on the screen");
                        return false; 
                    }
                
                    if (_('conf').value != '1')
                    {
                        _("smke_screen").style.zIndex = '3';
                        _("smke_screen").style.display = 'block';
                        _("confirm_box_loc").style.zIndex = '4';
                        _("confirm_box_loc").style.display = 'block';
                        return false;
                    }
                
                    var formdata = new FormData();
                    
                    formdata.append("numofreg", course_form.loc_numOfiputTag_0.value);
                    
                    if (_('conf').value == '1' && _('token_supplied').value == '1')
                    {
                        with(course_form)
                        {
                            formdata.append("AcademicDesc", AcademicDesc.value);
                            
                            formdata.append("tSemester", tSemester.value);
                            formdata.append("semester_spent_loc", semester_spent_loc.value);
                            formdata.append("tSemester_loc", tSemester_loc.value);
                            formdata.append("iStudy_level", iStudy_level.value);
                            
                            for (j = 1; j <= loc_numOfiputTag_0.value; j++)
                            {								
                                if (_("regCourses"+j))
                                {
                                    if (_("regCourses"+j).checked && !_("regCourses"+j).disabled)
                                    {
                                        formdata.append("regCourses"+j, _("regCourses"+j).value);
                                        formdata.append("vCourseDesc"+j, _("vCourseDesc"+j).value);
                                        formdata.append("credUniInput"+j, _("credUniInput"+j).value);
                                        formdata.append("amount"+j, _("amntInput"+j).value);
                                        formdata.append("itemid"+j, _("itemid"+j).value);
                                        formdata.append("cCategoryInput"+j, _("cCategoryInput"+j).value);
                                        formdata.append("ancilary_type"+j, _("ancilary_type"+j).value);
                                    }
                                }
                            }
                        }
                        
                        if (course_form.cProgrammeId.value.indexOf("DEG") >= 0 || course_form.cProgrammeId.value.indexOf("CHD") >= 0)
                        {
                            formdata.append("cProgrammeId", course_form.cProgrammeId.value);
                            if (course_form.cProgrammeId.value.indexOf("DEG") >= 0)
                            {
                                formdata.append("deg_appl_cat", course_form.deg_appl_cat.value);
                            }
                        }
                        
                        formdata.append("token_supplied", '1');
                        formdata.append("user_token", _('user_token').value)
                    }
                }                
                
                with (course_form)
                {
                    formdata.append("ilin", ilin.value);
                    formdata.append("vMatricNo", vMatricNo.value);
                    formdata.append("user_cat", user_cat.value);

                    formdata.append("max_crload", max_crload.value);
                    formdata.append("total_unit_carried", total_unit_carried);
                    
                    formdata.append("carried_crload", carried_crload.value);
                    formdata.append("totCredUnit", totCredUnit);
                    formdata.append("cEduCtgId", cEduCtgId.value);
                    formdata.append("cProgramme", cProgrammeId.value);
                    
                    formdata.append("conf", '1');
                }
                
                opr_prep(ajax = new XMLHttpRequest(),formdata);
            }

            function completeHandler(event)
            {
                on_error('0');
                on_abort('0');
                in_progress('0');

                var returnedStr = event.target.responseText;
                
                if (returnedStr == 'Token sent')
                {
                    _("smke_screen").style.zIndex = '3';
                    _("smke_screen").style.display = 'block';
                    _("token_dialog_box").style.zIndex = '4';
                    _("token_dialog_box").style.display = 'block';

                    _("resend_req").value = '';
                }else if (returnedStr.indexOf("success") != -1)
                {
                    const myArray = returnedStr.split(",");

                    inform(myArray[0]);
                    course_form.carried_crload.value = myArray[1];
                    
                    for (var cnt = 1; cnt <= _('loc_numOfiputTag_0').value; cnt++)
                    {
                        if (_('regCourses'+cnt))
                        {
                            if (_('regCourses'+cnt).type == 'checkbox' && _('regCourses'+cnt).checked)
                            {
                                _('regCourses'+cnt).disabled = true;
                            }
                        }
                    }
                }else
                {
                    caution_inform(returnedStr)
                }
            }
        </script>

		<script language="JavaScript" type="text/javascript" src="./bamboo/std_m_js.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE_FILE_NAME;?>styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/reg_crs.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rs_side_menu.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body">
        <form method="post" name="login_form" enctype="multipart/form-data" onsubmit="_('token_supplied').value='1'; chk_inputs(); return false;">
			<input name="resend_req" id="resend_req" type="hidden" value="0"/>
			<input name="token_supplied" id="token_supplied" type="hidden" value="0"/>

            <div id="token_dialog_box" class="center top_most talk_backs_logo" 
                style="background-size:35px 40px; 
                background-position:20px 18px;
                box-shadow: 2px 2px 8px 2px #726e41;
                display:none;
                background-image: url('<?php echo BASE_FILE_NAME_FOR_IMG;?>secured_doc.png');" 
                title="Press escape to remove">
                <div style="width:4%;
						height:15px;
						padding:3px;
						float:right; 
						text-align:right;">
							<a href="#"
								onclick="_('token_dialog_box').style.display = 'none';
								_('token_dialog_box').zIndex = '-1';
								_('smke_screen').style.display = 'none';
								_('smke_screen').zIndex = '-1';
								return false" 
								style="margin-right:3px; text-decoration:none;">
									<img style="width:17px; height:17px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>"/>
							</a>
					</div>

                <div id="msg_div" class="informa_msg_content_caution_cls" style="text-align:left">
                    A token has been sent to your NOUN student e-mail address<br>Enter token below. It expires in 20 minutes
                </div>

                <div id="msg_div_resend" class="informa_msg_content_caution_cls" style="background-color:#fdf0bf; text-indent:6px; padding:6px 0px 6px 0px; text-align:left;display: none">
                    Token sent afresh to your NOUN student e-mail address
                </div>

                <div id="msg_div" class="informa_msg_content_caution_cls" style="text-align:left; height:40px; margin-top:10px">
                    <input type="text" id="user_token" name="user_token" onfocus="_('msg_div_resend').style.display='none'" 
                        placeholder="Enter token here..."
						autocomplete="off"  required>
                </div>
                <div class="informa_msg_content_caution_cls" style="margin-top:15px; text-align:right">
                    <button type="submit" class="info_buttonss" style="color: #000;">Ok</button>

                    <button type="button" class="info_buttonss" style="margin-right:10px" 
                        onclick="_('resend_req').value='1';
                        _('user_token').value='';
                        chk_inputs(); 
                        _('msg_div_resend').style.display='block';
                        return false;">Re-send token</button>
                </div>
            </div>
        </form>

        <div id="confirm_box_loc" class="center top_most talk_backs talk_backs_logo" 
            style="border-color:#4fbf5c; 
            background-size:30px 40px; 
            background-position:20px 18px; 
            background-image: url('<?php echo BASE_FILE_NAME_FOR_IMG;?>help.png');">
            <div id="msg_div" class="informa_msg_content_caution_cls" style="color:#4fbf5c; text-align:left">
                Register selected courses ? </div><p>
            <div class="informa_msg_content_caution_cls" style="margin-top:3px; text-align:right">
                <input class="buttons_yes" type="button" value="Yes" 
                    style="width:auto; padding:10px; height:auto;" 
                    onclick="_('smke_screen').style.display = 'none';
                    _('smke_screen').style.zIndex='-1';
                    _('confirm_box_loc').style.display = 'none';
                    _('confirm_box_loc').style.zIndex='-1';
                    _('conf').value='1';
                    chk_inputs();"/>

                <input class="buttons_no" type="button" value="No" 
                    style="width:auto; padding:10px; height:auto; margin-right:10px;" 
                    onclick="_('smke_screen').style.display = 'none';
                    _('smke_screen').style.zIndex='-1';
                    _('confirm_box_loc').style.display = 'none';
                    _('confirm_box_loc').style.zIndex='-1';
                    _('conf').value='-1';"/>
            </div>
        </div><?php
	    $mysqli = link_connect_db();

        $orgsetins = settns();
        
        require_once(BASE_FILE_NAME."feedback_mesages.php");
        
        require_once("std_detail_pg1.php");
        require_once("forms.php");
        
        require_once("./set_scheduled_dates.php");
        
                    
        $balance = 0.00;
        
        $returnedStr = calc_student_bal($_REQUEST["vMatricNo"], 'mone_at_hand', $cResidenceCountryId_loc);

        $balance = trim(substr($returnedStr, 0, 100));
        $minfee = trim(substr($returnedStr, 100, 100));
        $iItemID_str = trim(substr($returnedStr, 200, 100));
            
        //$balance = wallet_bal_std();

        $sql_feet_type = select_fee_srtucture($_REQUEST["vMatricNo"], $cResidenceCountryId_loc, $cEduCtgId_loc);        
        
        $num_reg_crs = 0;?>        
            
        <div class="appl_container">
            <div class="appl_left_div" style="z-index:2;">
                <div class="appl_left_child_logo_div"></div>
                <div class="appl_left_child_div" style="margin-top:0px; font-size:1.1em; font-weight:bold">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;  font-size:1.2em">Register courses</div>
                
                <div class="for_computer_screen">
                    <?php require_once ('std_left_side_menu.php');?>                    
                </div>
            </div>
            
            <div class="appl_right_div">     
                <div class="appl_left_child_div for_mobile_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php std_top_samll_menu();?>
                </div>

                <div class="appl_left_child_div for_computer_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php std_top_menu();?>
                </div>

                <div class="appl_left_child_div for_mobile_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php require_once ('mobile_menu_bar_content.php');?>
                </div>
                
                <div class="appl_left_child_div for_computer_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php require_once ('menu_bar_content.php');?>
                </div>

                <div id="menu_sm_scrn">
                    <?php build_menu_right();?>
                </div>

                <div class="appl_left_child_div" style="width:98%; margin:auto; height:auto; margin-top:10px; background-color:#eff5f0">
                    <div id="btn_div" style="display:flex; 
                        flex:100%;
                        height:auto; 
                        gap:15px;
                        margin-bottom:5px;
                        justify-content:flex-start;">
                        <button id="select_all1" type="button" class="login_button" onclick="chk_setFigure();">Select all</button>
                    </div>
                </div>
                
                <div class="appl_left_child_div" style="width:95%; margin:auto; height:auto; margin-top:10px; padding:0px; background-color:#eff5f0">
                    <div class="appl_left_child_div_child calendar_grid" style="font-weight: bold; margin:0px;">
                        <div style="flex:3.5%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                            Sno
                        </div>
                        <div style="flex:15%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                            Course Code
                        </div>
                        <div style="flex:50.5%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                            Course Title
                        </div>
                        <div style="flex:7%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                            Credit unit
                        </div>
                        <div style="flex:7%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                            Category
                        </div>
                        <div style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                            Fee <?php if ($cResidenceCountryId_loc == 'NG')
                            {
                                echo "(N)";
                            }else
                            {
                                echo "($)";
                            }?>
                        </div>
                    </div>
                </div>
                
                <div class="appl_left_child_div" style="width:98%; margin:auto; height:85%; margin-top:10px; overflow-x:hidden; overflow-y:scroll; background-color:#eff5f0">
                    <form action="" method="post" name="course_form" id="course_form" enctype="multipart/form-data">
                        <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] <> ''){echo $_REQUEST["user_cat"];}?>" />
                        <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"]) && $_REQUEST["ilin"] <> ''){echo $_REQUEST["ilin"];}?>" />
                        <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>" />
                        
                        <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] <> ''){echo $_REQUEST["top_menu_no"];}?>" />
                        <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> ''){echo $_REQUEST["side_menu_no"];}?>" />
                        
					    <input name="conf" id="conf" type="hidden" value="-1" />
                        <input name="max_crload" id="max_crload" type="hidden" value="<?php echo $max_crload_loc; ?>"/>
						<input name="AcademicDesc" id="AcademicDesc" type="hidden" value="<?php echo $orgsetins['cAcademicDesc']; ?>" />
						<input name="iStudy_level" id="iStudy_level" type="hidden" value="<?php echo $iStudy_level_loc; ?>" />
						<input name="tSemester_loc" id="tSemester_loc" type="hidden" value="<?php echo $tSemester_loc; ?>" /><?php
                        $semester = $tSemester_loc;
                        if ($cEduCtgId_loc <> 'PSZ')
                        {
                            $semester = $semester_spent_loc;
                        }?>
						<input name="tSemester" id="tSemester" type="hidden" value="<?php echo $semester; ?>" />
						<input name="semester_spent_loc" id="semester_spent_loc" type="hidden" value="<?php echo SEMESTER_COUNT; ?>" />
                        
						<input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php echo $cEduCtgId_loc; ?>" />
						<input name="cProgrammeId" id="cProgrammeId" type="hidden" value="<?php echo $cProgrammeId_loc; ?>" />
						<input name="deg_appl_cat" id="deg_appl_cat" type="hidden" value="<?php echo $deg_appl_cat; ?>" />
                        
						<input name="cc_must" id="cc_must" type="hidden" value="<?php echo $orgsetins["enforce_co"]; ?>" />
						
						<input name="wallet" id="wallet" type="hidden" value="<?php echo $balance; ?>" /><?php
                        if (!(((!is_bool(strpos($cProgrammeId_loc, "CHD")) || 
                        (!is_bool(strpos($cProgrammeId_loc, "DEG")))) && $reg_open_cert == 1) || 
                        (is_bool(strpos($cProgrammeId_loc, "CHD")) && is_bool(strpos($cProgrammeId_loc, "DEG")) && $reg_open == 1) ||
                        (($cEduCtgId_loc == 'PGZ' || $cEduCtgId_loc == 'PRX') && $reg_open_spg == 1) || get_active_request(0) == 1))
                        //if ($_REQUEST["side_menu_no"] <> 'see_all_registered_courses' && (get_active_request(0) <> 1 && get_active_request(1) <> 1 && ($session_open == 0 || $semester_open == 0 || $reg_open == 0)))
                        {?>                            
                            <div class="appl_left_child_div_child calendar_grid">
                                <div class="inlin_message_color" style="flex:5%; padding-left:4px; height:40px; background-color: #ffffff"></div>
                                <div class="inlin_message_color" style="flex:95%; padding-right:4px; height:40px;">
                                    Semester closed. You are advised to check for update at least, twice in a week;
                                </div>
                            </div><?php
                        }else if ($semester_reg_loc == '0')
                        {?>                            
                            <div class="appl_left_child_div_child calendar_grid">
                                <div class="inlin_message_color" style="flex:5%; padding-left:4px; height:40px; background-color: #ffffff"></div>
                                <div class="inlin_message_color" style="flex:95%; padding-right:4px; height:40px;">
                                    Please register for current semester on your home page. <?php if (!is_bool(strpos($cProgrammeId_loc, "DEG"))){echo ' Note that semester registration fee is not applicable to your programme ';} ?>See procedure 'K' in <a href="#" style="text-decoration:none; color:#FF3300" 
                                    onclick="guides_instructions.submit();
                                    return false">'How to do things'</a> for steps to follow
                                </div>
                            </div><?php
                        }else
                        {?>
                            <div class="appl_left_child_div_child calendar_grid">
                                <div class="inlin_message_color" style="flex:5%; padding-left:4px; height:45px; background-color: #ffffff"></div>
                                <div class="inlin_message_color" style="flex:95%; padding-right:4px; height:45px;">
                                    Please note that you are solely responsible for course registration action(s) on this page, whether it is done for you or you do it by yourself
                                </div>
                            </div><?php

                            $letter_grdaes = "'A','B','C','D'";
                            if ($cEduCtgId_loc == 'ELZ' || $cEduCtgId_loc == 'PSZ')
                            {
                                $letter_grdaes = "'A','B','C','D','E'";
                            }

                            $cnt = 0;
                            $not_passed_courses_arr = array();
                            $table = search_starting_pt_crs($_REQUEST['vMatricNo']);
                            foreach ($table as &$value)
                            {
                                $wrking_tab = 'examreg_result_'.$value;

                                $stmt = $mysqli->prepare("SELECT cCourseId FROM $wrking_tab  WHERE vMatricNo = ? AND cgrade NOT IN ($letter_grdaes) ORDER BY cAcademicDesc, cCourseId");
                                $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($cCourseId);
                                
                                while($stmt->fetch())
                                {
                                    $cnt++;
                                    $not_passed_courses_arr[$cnt] = $cCourseId;
                                    //echo $not_passed_courses_arr[$cnt].'<br>';
                                }
                            }



                            $all_courses_with_result = array();
                            $table = search_starting_pt_crs($_REQUEST['vMatricNo']);
                            $cnt = 0;
                            foreach ($table as &$value)
                            {
                                $wrking_tab = 'examreg_result_'.$value;

                                $stmt = $mysqli->prepare("SELECT cCourseId FROM $wrking_tab  WHERE vMatricNo = ? ORDER BY cAcademicDesc, cCourseId");
                                $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($cCourseId);
                                
                                while($stmt->fetch())
                                {
                                    $cnt++;
                                    $all_courses_with_result[$cnt] = $cCourseId;
                                    //echo $all_courses_with_result[$cnt].',';
                                }
                            }

                            //$cnt_rst = 0;
                            //$all_courses_without_result = array();

                            $reg_aa_courses_without_result = '';
                            $all_reg_courses = '';
                            $alll_reg_courses = '';

                            $table = search_starting_pt_crs($_REQUEST['vMatricNo']);
                            foreach ($table as &$value)
                            {
                                $wrking_tab = 'coursereg_arch_'.$value;

                                $stmt = $mysqli->prepare("SELECT cCourseId, ancilary_type FROM $wrking_tab  WHERE vMatricNo = ?");
                                $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($cCourseId, $ancilary_type);

                                while($stmt->fetch())
                                {
                                    
                                    if ($ancilary_type <> 'normal' && $ancilary_type <> 'Laboratory')
                                    {                                        
                                        $found_0 = 0;
                                        for ($b = 1; $b <= count($all_courses_with_result); $b++)
                                        {
                                            if ($all_courses_with_result[$b] == $cCourseId)
                                            {
                                                $found_0 = 1;
                                                break;
                                            }
                                        }

                                        if ($found_0 == 0)
                                        {
                                            //$cnt_rst++;
                                            //$all_courses_without_result[$cnt_rst] = $cCourseId;
                                            //echo $all_courses_without_result[$cnt_rst].',';
                                            $reg_aa_courses_without_result .= "'".$cCourseId."',";
                                        }

                                        
                                        $found = 0;
                                        for ($b = 1; $b <= count($not_passed_courses_arr); $b++)
                                        {
                                            if ($not_passed_courses_arr[$b] == $cCourseId)
                                            {
                                                //$all_reg_courses .= "'".$cCourseId."',";
                                                $found = 1;
                                                break;
                                            }
                                        }

                                        if ($found == 1)
                                        {
                                            continue;
                                        }

                                        $all_reg_courses .= "'".$cCourseId."',";
                                    }else
                                    {
                                        $all_reg_courses .= "'".$cCourseId."',";
                                    }

                                    $alll_reg_courses .= "'".$cCourseId."',";
                                }
                            }


                            $sql_prev_crs_reg = '';

                            if ($all_reg_courses <> '')
                            {
                                $all_reg_courses = substr($all_reg_courses, 0, strlen($all_reg_courses)-1);
                                $sql_prev_crs_reg = "AND a.cCourseId NOT IN ($all_reg_courses)";
                            }

                            $sql_prev_crss_reg = '';
                            if ($alll_reg_courses <> '')
                            {
                                $alll_reg_courses = substr($alll_reg_courses, 0, strlen($alll_reg_courses)-1);
                                $sql_prev_crss_reg = "AND a.cCourseId NOT IN ($alll_reg_courses)";
                            }

                            if ($reg_aa_courses_without_result <> '')
                            {
                                $reg_aa_courses_without_result = substr($reg_aa_courses_without_result, 0, strlen($reg_aa_courses_without_result)-1);
                                $sql_prev_crs_reg = "AND (a.cCourseId NOT IN ($all_reg_courses) OR a.cCourseId IN ($reg_aa_courses_without_result))";
                            }

                            $new_curr = select_curriculum($_REQUEST["vMatricNo"]);

                            //get total credit load carried for the semester
                            $stmt = $mysqli->prepare("SELECT SUM(iCreditUnit) FROM coursereg_arch_20242025 a 
                            WHERE tdate >= '$semester_begin_date'
                            AND vMatricNo = ?");
                            $stmt->bind_param("s", $vMatricNo);
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($carried_crload);
                            $stmt->fetch();
                            $stmt->close();
                            if (is_null($carried_crload))
                            {
                                $carried_crload = 0;
                            }?>
                            <input name="carried_crload" id="carried_crload" type="hidden" value="<?php echo $carried_crload; ?>"/><?php

                            /*$stmt = $mysqli->prepare("SELECT DISTINCT siLevel, tSemester FROM s_tranxion WHERE vremark = 'Registration Deduction' AND vMatricNo = ?");
                            $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
                            $stmt->execute();
                            $stmt->store_result();
                            $number_of_prev_sem = $stmt->num_rows;
                            $stmt->close();*/

                            //call for result in research methods if student is a PG student
                            

                            //pending courses to be registered
                            $tcr_all = 0;
                            $total_cost_all = 0.00;
                            $c = 0;
                            $total_cost = 0;
        
                            $level_semester_subqry = "";
                            
                            if ($semester_spent_loc > 1 || ($cEduCtgId_loc == 'PSZ' && $iBeginLevel_loc > 100))
                            {
                                if ($cEduCtgId_loc == 'PSZ')
                                {
                                    /*if ($iBeginLevel_loc == 100)
                                    {
                                        if ($tSemester_loc == 1)
                                        {
                                            $level_semester_subqry = " AND b.siLevel < c.iStudy_level";
                                        }else if ($tSemester_loc%2 == 0 || $tSemester_loc == 2)
                                        {
                                            $level_semester_subqry = " AND (b.siLevel < c.iStudy_level OR (b.siLevel = c.iStudy_level AND b.tSemester = 1))";
                                        }
                                    }else  if ($iBeginLevel_loc > 100)
                                    {
                                        if ($tSemester_loc%2 > 0 || $tSemester_loc == 1)
                                        {
                                            $level_semester_subqry = " AND b.siLevel < c.iStudy_level AND b.siLevel <> 100";
                                        }else if ($tSemester_loc%2 == 0 || $tSemester_loc == 2)
                                        {
                                            $level_semester_subqry = " AND ((b.tSemester = 1 AND b.siLevel = c.iStudy_level) OR (b.siLevel < c.iStudy_level AND b.siLevel <> 100))";
                                        }
                                    }*/

                                    
                                    $bi_semester = 1;
                                    if ($tSemester_loc%2 == 0)
                                    {
                                        $bi_semester = 2;
                                    }

                                    $level_semester_subqry = " AND (b.siLevel < c.iStudy_level OR (c.iStudy_level = b.siLevel AND b.tSemester < $bi_semester))";
                                }else if ($cEduCtgId_loc == 'PGX')
                                {
                                    if ($tSemester_loc <= 2)
                                    {
                                        $level_semester_subqry = " AND b.tSemester = 1";
                                        // if ($tSemester_loc%2 == 0)
                                        // {
                                        //     $level_semester_subqry = " AND b.tSemester = 2";
                                        // }
                                    }
                                    /*if ($semester_spent_loc == 2)
                                    {
                                        $level_semester_subqry = " AND b.tSemester = 1";
                                    }*/
                                }else if ($cEduCtgId_loc == 'PGY' || $cEduCtgId_loc == 'PGZ' || $cEduCtgId_loc == 'PRX')
                                {
                                    if ($tSemester_loc <= 2)
                                    {
                                        $level_semester_subqry = " AND b.tSemester = 1";
                                        // if ($tSemester_loc%2 == 0)
                                        // {
                                        //     $level_semester_subqry = " AND b.tSemester = 2";
                                        // }
                                    }
                                    
                                    /*if ($semester_spent_loc == 2)
                                    {
                                        $level_semester_subqry = " AND b.tSemester = 1";
                                    }else if ($number_of_prev_sem > 2)
                                    {
                                        check for unregistered courses $level_semester_subqry = "";
                                    }*/
                                }
                                
                                $new_curr = '';

                                /*$stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, b.cCategory, b.tSemester, b.siLevel, a.iCreditUnit, retActive, ancilary_type
                                FROM courses a, progcourse b, s_m_t c
                                WHERE a.cCourseId = b.cCourseId
                                AND b.cProgrammeId = c.cProgrammeId
                                AND b.tSemester = $tSemester_loc
                                $level_semester_subqry
                                $new_curr
                                AND c.vMatricNo = ?
                                AND b.cdel = 'N'
                                $sql_prev_crs_reg
                                ORDER BY b.siLevel, b.tSemester, a.cCourseId");*/

                                $semester_qry = " AND b.tSemester = $tSemester_loc";
                                if ($tSemester_loc > 2 && ($cEduCtgId_loc == 'PGX' || $cEduCtgId_loc == 'PGY' || $cEduCtgId_loc == 'PGZ' || $cEduCtgId_loc == 'PRX'))
                                {
                                    $semester_qry = "";
                                }

                                $semester_qry = '';

                                $stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, b.cCategory, b.tSemester, b.siLevel, a.iCreditUnit, retActive, ancilary_type
                                FROM courses_new a, progcourse b, s_m_t c
                                WHERE a.cCourseId = b.cCourseId
                                AND b.cProgrammeId = c.cProgrammeId
                                $semester_qry
                                $level_semester_subqry
                                $new_curr
                                AND c.vMatricNo = ?
                                AND b.cdel = 'N'
                                AND a.cdel = 'N'
                                $sql_prev_crs_reg
                                ORDER BY b.siLevel, b.tSemester, a.cCourseId");


                                $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
        
                                $stmt->execute();
                                $stmt->store_result();
                                $number_of_pending_courses = $stmt->num_rows;
                                $stmt->bind_result($cCourseId, $vCourseDesc, $cCategory, $tSemester_ex, $siLevel, $iCreditUnit, $retActive, $ancilary_type);

                                //if ($stmt->num_rows > 0)
                                if ($number_of_pending_courses > 0)
                                {?>
                                    <div class="appl_left_child_div_child calendar_grid">
                                        <div class="inlin_message_color" style="flex:5%; padding-left:4px; height:35px; background-color: #eff5f0"></div>
                                        <div class="inlin_message_color" style="flex:95%; padding-right:4px; height:35px; background-color: #eff5f0">
                                            Pending courses to register
                                        </div>
                                    </div><?php
                                    $prev_level = ''; 
                                    $prev_sem = '';
                                    $tcr1 = 0;

                                    $count_unit = 0;

                                    $c = 0;
                                    while($stmt->fetch())
                                    {
                                        if (is_null($iCreditUnit))
                                        {
                                            $iCreditUnit = 0;
                                        }

                                        if ($ancilary_type  == 'Project')
                                        {
                                            if ($cEduCtgId_loc == 'PGX')
                                            {
                                                if ($semester_spent_loc <= 1)
                                                {
                                                    continue;
                                                }
                                            }else if ($cEduCtgId_loc == 'PGY' && $cAcademicDesc_1 > 2017)
                                            {
                                                if ($cFacultyId_loc == 'SSC' || $cFacultyId_loc == 'ART' || $cFacultyId_loc == 'EDU' || $cFacultyId_loc == 'HSC' || $cFacultyId_loc == 'LAW' || $cFacultyId_loc == 'CMP')
                                                {
                                                    if ($semester_spent_loc <= 2)
                                                    {
                                                        continue;
                                                    }
                                                }else if ($cFacultyId_loc == 'MSC')
                                                {
                                                    if ($cProgrammeId_loc == 'MSC404')
                                                    {
                                                        if ($semester_spent_loc <= 2)
                                                        {
                                                            continue;
                                                        }
                                                    }else if ($semester_spent_loc <= 3)
                                                    {
                                                        continue;
                                                    }
                                                }
                                                /*if ($number_of_prev_sem < $number_of_semesters_loc)
                                                {
                                                    continue;
                                                }*/
                                            }
                                        }
                                        

                                        if ($cAcademicDesc_1 > 2017 && ($cEduCtgId_loc == 'PGX' || $cEduCtgId_loc == 'PGY' || $cEduCtgId_loc == 'PGZ' || $cEduCtgId_loc == 'PRX'))
                                        {
                                            if ($tSemester_ex == $tSemester_loc)
                                            {
                                                continue;
                                            }
                                        }
                                        
                                        
                                        $c++;

                                        $selected = 0;
                                        if ($cCourseId == 'NSC505' || $cCourseId == 'NSC501' || $cCourseId == 'NSC401')
                                        {
                                            $Amount = 3000;
                                            $itemid = '2134';
                                        }else if ($cCourseId == 'PHS326' || $cCourseId == 'PHS430')
                                        {
                                            $Amount = 15000;
                                            $itemid = '7116';
                                        }else if ($cCourseId == 'PHS823')
                                        {
                                            $Amount = 20000;
                                            $itemid = '7180';
                                        }else if ($cCourseId == 'MAC312' || $cCourseId == 'MAC421')
                                        {
                                            $Amount = 6500;
                                            $itemid = '7115';
                                        }else if ($cCourseId == 'DES303')
                                        {
                                            $Amount = 2500;
                                            $itemid = '7115';
                                        }else
                                        {
                                            if ($ancilary_type == 'normal' || $ancilary_type == 'Laboratory')
                                            {
                                                $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
                                                FROM s_f_s a, fee_items b
                                                WHERE a.fee_item_id = b.fee_item_id
                                                AND fee_item_desc LIKE '%Course Registration%'
                                                AND iCreditUnit = $iCreditUnit
                                                AND cEduCtgId = '$cEduCtgId_loc'
                                                AND cFacultyId = '$cFacultyId_loc'
                                                $sql_feet_type");                                        
                                            }else 
                                            {
                                                $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
                                                FROM s_f_s a, fee_items b
                                                WHERE a.fee_item_id = b.fee_item_id
                                                AND b.fee_item_desc = '$ancilary_type'
                                                AND cEduCtgId = '$cEduCtgId_loc'
                                                AND cFacultyId = '$cFacultyId_loc'
                                                $sql_feet_type");
                                            }

                                            $stmt_amount->execute();
                                            $stmt_amount->store_result();
                                            $stmt_amount->bind_result($Amount, $itemid);
                                            $stmt_amount->fetch();
                                            $stmt_amount->close();
                                        }
                                        
                                        if (is_null($Amount))
                                        {
                                            $Amount = 0.0;    
                                        }
                                        
                                        //$Amount = $Amount ?? 0;
                                        
                                        if ($tSemester_ex == 1){$semester = 'First ';}else{$semester = 'Second ';}

                                        if (($prev_level == '' || $prev_sem == '') || 
                                        ($prev_level <> '' && $siLevel <> $prev_level) || 
                                        ($prev_sem <> '' && $tSemester_ex <> $prev_sem))
                                        {?>
                                            <div class="appl_left_child_div_child calendar_grid">
                                                <div class="inlin_message_color" style="flex:5%; padding-left:4px; height:35px; background-color: #ffffff"></div>
                                                <div class="inlin_message_color" style="flex:95%; padding-right:4px; height:35px; background-color: #ffffff">
                                                    <b><?php echo $siLevel.' Level, '.$semester .' Semester' ?></b>
                                                </div>
                                            </div><?php
                                        }?>
                                        <label for="regCourses<?php echo $c ?>">
                                            <div class="appl_left_child_div_child calendar_grid course_line">
                                                <div style="flex:5%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                                    <?php echo $c;?>
                                                </div>
                                                <div style="flex:15%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                                    <input name="regCourses<?php echo $c ?>" id="regCourses<?php echo $c ?>" type="checkbox"
                                                        onclick="if(this.checked)
                                                        {
                                                            var total_credit_unit_toreg = 0;
                                                            if (_('total_credit_unit_toreg'))
                                                            {
                                                                var total_credit_unit_toreg = parseInt(_('total_credit_unit_toreg').value);
                                                            }

                                                            var total_credit_unit_pend = parseInt(_('total_credit_unit_pend').value);

                                                            var max_crload = parseInt(_('max_crload').value);
                                                            var carried_crload = parseInt(_('carried_crload').value);
                                                            var cr = parseInt(_('credUniInput<?php echo $c ?>').value);
                                                                                                                
                                                            if ((total_credit_unit_pend + total_credit_unit_toreg + cr + carried_crload) > max_crload)
                                                            {
                                                                caution_inform('Maximum credit unit exceeded');
                                                                return false
                                                            }

                                                            var balance = parseInt(_('wallet').value);
                                                            var total_cost_all = parseInt(_('grand_total_amnt').value);

                                                            var total_amnt_pend = parseInt(_('total_amnt_pend').value);

                                                            var total_amnt_toreg = 0;
                                                            if (_('total_amnt_toreg'))
                                                            {
                                                                var total_amnt_toreg = parseInt(_('total_amnt_toreg').value);
                                                            }
                                                            var amount = parseInt(_('amntInput<?php echo $c ?>').value);
                                                        
                                                            if (balance < total_cost_all + amount)
                                                            {
                                                                caution_inform('<b>Insufficient fund</b><p>To fund your eWallet:<br>1. Click the Ok button<br>2. Click Bursary above<br>3. Click Make payment (left)<br>4. Follow the prompt on the screen');
                                                                return false;
                                                            }

                                                            this.value='<?php echo $cCourseId;?>';
                                                        }else if (_('cCategoryInput<?php echo $c ?>').value == 'C')
                                                        {
                                                            if (_('cc_must').value == '0')
                                                            {
                                                                caution_inform('You should not leave out a core course');
                                                            }else if (_('cc_must').value == '1')
                                                            {
                                                                caution_inform('You cannot not leave out a core course');
                                                                return false
                                                            }
                                                        }else
                                                        {
                                                            this.value='';
                                                        }
                                                        set_figures(this.checked,<?php echo $Amount.','. $iCreditUnit; ?>,'pend')" <?php 
                                                    
                                                    if (($balance >= $total_cost_all + $total_cost + $Amount) && 
                                                    ($tcr_all + $tcr1 + $iCreditUnit + $carried_crload <= $max_crload_loc) && $cCategory == 'C' && $orgsetins["enforce_co"] == '1')
                                                    {
                                                        echo ' checked ';
                                                        $tcr1 += $iCreditUnit;
                                                        $selected = 1;
                                                    }
                                                    
                                                    if ($Amount < 2000.00 || ($cCourseId <> 'DES303' && $iCreditUnit == 0))
                                                    {
                                                        echo ' disabled';
                                                    }?> value="<?php echo $cCourseId;?>" style="padding:0px"/>
                                                    <?php echo $cCourseId;?>
                                                </div>
                                                <div style="flex:50%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                                    <?php echo $vCourseDesc;?>
									                <input id="vCourseDesc<?php echo $c ?>" type="hidden" value="<?php echo $vCourseDesc ?>"/>
                                                </div>
                                                <div id="credUnitDiv<?php echo $c ?>" style="flex:7%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                                    <?php echo $iCreditUnit;?>
                                                    <input id="credUniInput<?php echo $c ?>" type="hidden" value="<?php echo $iCreditUnit ?>"/>
                                                </div>
                                                <div style="flex:7%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                                    <?php echo $cCategory;?>
										            <input id="cCategoryInput<?php echo $c ?>" type="hidden" value="<?php echo $cCategory ?>"/>
                                                </div>
                                                <div style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;"><?php 
                                                    if ($selected == 1)
                                                    {
                                                        $total_cost  = $total_cost + $Amount;
                                                    }
                                                    echo number_format($Amount, 0, '', ',');?>
                                                    <input id="amntInput<?php echo $c ?>" type="hidden" value="<?php echo $Amount; ?>"/>
                                                    <input id="itemid<?php echo $c ?>" type="hidden" value="<?php echo $itemid; ?>"/>
                                                    <input id="ancilary_type<?php echo $c ?>" type="hidden" value="<?php echo $ancilary_type; ?>"/>
                                                </div>
                                            </div>                                            
                                        </label><?php
                                        $prev_level = $siLevel;
                                        $prev_sem = $tSemester_ex;
                                    }
                                    $stmt->close();

                                    if ($c > 0)
                                    {?>
                                        <div class="appl_left_child_div_child calendar_grid" style="font-weight: bold;">
                                            <div style="flex:5%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;"></div>
                                            <div style="flex:15%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff"></div>
                                            <div style="flex:50%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff">
                                                Total
                                            </div>
                                            <div id="total_credunit_div_pend" style="flex:7%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;"><?php
                                                if ($orgsetins["enforce_co"] == '1' || $tcr1 > 0)
                                                {
                                                    echo $tcr1; 
                                                    $tcr_all = $tcr1;
                                                }else
                                                {
                                                    echo '0';
                                                }?>
                                            </div>
                                            <div style="flex:7%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff"></div>
								            <input id="total_credit_unit_pend" type="hidden" value="<?php echo $tcr1;?>"/>
                                            <div id="total_amnt_div_pend" style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;"><?php
                                                if ($orgsetins["enforce_co"] == '1' || $total_cost > 0)
                                                {
                                                    echo number_format($total_cost, 0, '', ',');
                                                    $total_cost_all = $total_cost;
                                                }else
                                                {
                                                    echo '0';
                                                }?>
                                            </div>
                                        </div><?php
                                    }?>
                                    
                                    <input id="total_amnt_pend" type="hidden" value="<?php 
                                        if ($orgsetins["enforce_co"] == '1' || $total_cost > 0)
                                        {
                                            echo $total_cost;
                                        }else
                                        {
                                            echo '0';
                                        }?>"/>
                                    <input id="total_number_of_course_pend" type="hidden" value="<?php echo $c;?>"/>

                                    <input id="total_number_of_credit_unit_pend" type="hidden" value="<?php echo $tcr1;?>"/>
                                    <input name="total_numOf_pending_iputTag" id="total_numOf_pending_iputTag" type="hidden" value="<?php echo $c ?>"/><?php
                                }
                            }

							//$new_curr = select_curriculum($_REQUEST["vMatricNo"]);

                            //current courses to be registered
                            $level_semester_subqry = " AND b.tSemester = 1";

                            if ($cEduCtgId_loc == 'PSZ')
                            {
                                $bi_semester = 1;
                                if ($tSemester_loc%2 == 0)
                                {
                                    $bi_semester = 2;
                                }
                                $level_semester_subqry = " AND b.tSemester = $bi_semester";
                            }else if ($cEduCtgId_loc == 'ELX')
                            {

                            }else
                            {
                                //$level_semester_subqry = " AND b.tSemester = $semester_spent_loc";
                                $level_semester_subqry = " AND b.tSemester = $tSemester_loc";
                            }

                            // if ($tSemester_loc%2 == 0 || $semester_spent_loc == 1)
                            // {
                            //     $level_semester_subqry = " AND b.tSemester = 2";
                            //     if ($cEduCtgId_loc <> 'PSZ' && $semester_spent_loc > 2)
                            //     {
                            //         $level_semester_subqry = " AND b.tSemester = $semester_spent_loc";
                            //     }
                            // }

                            $stmt_course_reg_ = $mysqli->prepare("SELECT *
                            FROM coursereg_arch_20242025 b
                            WHERE b.vMatricNo = ? 
                            AND b.siLevel = $iStudy_level_loc
                            $level_semester_subqry");
                            $stmt_course_reg_->bind_param("s", $_REQUEST["vMatricNo"]);
                            $stmt_course_reg_->execute();
                            $stmt_course_reg_->store_result();
                            $no_course_reg_ = $stmt_course_reg_->num_rows;
                            $stmt_course_reg_->close();

                            $new_curr = '';

                            /*$g_course = "a.cCourseId = b.cCourseId
                            AND b.cProgrammeId = c.cProgrammeId
                            AND b.siLevel = c.iStudy_level
                            AND c.iStudy_level = $iStudy_level_loc
                            $level_semester_subqry
                            AND c.vMatricNo = ?
                            $new_curr
                            AND b.cdel = 'N'
                            ORDER BY b.cCourseId";

                            if (($iBeginLevel_loc == 300 || $iBeginLevel_loc == 200) && $iBeginLevel_loc == $iStudy_level_loc)
                            {
                                if (($tSemester_loc%2) > 0 || $tSemester_loc == 1)
                                {
                                    $g_course = "a.cCourseId IN ('NOU107','GST101','GST105') OR a.cCourseId = b.cCourseId
                                    (AND b.cProgrammeId = c.cProgrammeId
                                    AND b.siLevel = c.iStudy_level
                                    AND c.iStudy_level = $iStudy_level_loc
                                    $level_semester_subqry
                                    AND c.vMatricNo = ?
                                    $new_curr
                                    AND b.cdel = 'N')
                                    ORDER BY b.cCourseId";
                                }else if (($tSemester_loc%2) == 0 || $tSemester_loc == 2)
                                {
                                    $g_course = "a.cCourseId IN ('GST102') OR a.cCourseId = b.cCourseId
                                    (AND b.cProgrammeId = c.cProgrammeId
                                    AND b.siLevel = c.iStudy_level
                                    AND c.iStudy_level = $iStudy_level_loc
                                    $level_semester_subqry
                                    AND c.vMatricNo = ?
                                    $new_curr
                                    AND b.cdel = 'N')";
                                }
                            }else
                            {
                                
                            }*/

                            $stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, b.cCategory, a.iCreditUnit
                            FROM courses_new a, progcourse b, s_m_t c
                            WHERE a.cCourseId = b.cCourseId
                            AND b.cProgrammeId = c.cProgrammeId
                            AND b.siLevel = c.iStudy_level
                            AND c.iStudy_level = $iStudy_level_loc
                            $level_semester_subqry
                            AND c.vMatricNo = ?
                            $new_curr
                            AND b.cdel = 'N'
                            AND a.cdel = 'N'
                            ORDER BY b.cCourseId");
                            
                            $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
                            
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($cCourseId, $vCourseDesc, $cCategory, $iCreditUnit);
                            $semester_courses_loaded = $stmt->num_rows;
                            $stmt->close();

                            if (!is_bool(strpos($cFacultyId_loc, "DEG")) || !is_bool(strpos($cFacultyId_loc, "CHD")))
                            {
                                $stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, b.cCategory, a.iCreditUnit, a.ancilary_type
                                FROM courses_new a, progcourse b
                                WHERE a.cCourseId = b.cCourseId
                                AND b.cProgrammeId = '$cProgrammeId_loc'
                                $new_curr
                                AND b.cdel = 'N'
                                AND a.cdel = 'N'
                                $sql_prev_crs_reg
                                ORDER BY  b.cCategory, b.cCourseId");
                            }else
                            {
                                $stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, b.cCategory, a.iCreditUnit, a.ancilary_type
                                FROM courses_new a, progcourse b
                                WHERE a.cCourseId = b.cCourseId
                                AND b.cProgrammeId = '$cProgrammeId_loc'
                                AND b.siLevel = $iStudy_level_loc
                                $level_semester_subqry
                                $new_curr
                                AND b.cdel = 'N'
                                AND a.cdel = 'N'
                                $sql_prev_crss_reg
                                ORDER BY  b.cCategory, b.cCourseId");
                            }
                            //$stmt->bind_param("ss", $_REQUEST["vMatricNo"], $_REQUEST["vMatricNo"]);
                            //$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
                            
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($cCourseId, $vCourseDesc, $cCategory, $iCreditUnit, $ancilary_type);
                            $semester_total_reg = $stmt->num_rows;
                            $tcr1 = 0;
                            $total_cost = 0.00;
                            if ($semester_courses_loaded == 0)
                            {?>
                                <div class="appl_left_child_div_child calendar_grid">
                                    <div class="inlin_message_color" style="flex:5%; padding-left:4px; height:40px; background-color: #ffffff"></div>
                                    <div class="inlin_message_color" style="flex:95%; padding-right:4px; height:40px;">
                                        Courses are yet to be uploaded. Complain to the ICT officer at your centre for resolution
                                    </div>
                                </div><?php
                            }
                            
                            if ($no_course_reg_ > 0 && $c == 0 && $stmt->num_rows === 0)
                            {?>
                                <div class="appl_left_child_div_child calendar_grid">
                                    <div class="inlin_message_color" style="flex:5%; padding-left:4px; height:40px; background-color: #ffffff"></div>
                                    <div class="inlin_message_color" style="flex:95%; padding-right:4px; height:40px;">
                                        You have registered all available courses for the semester
                                    </div>
                                </div><?php
                            }else
                            {?>
                                <div class="appl_left_child_div_child calendar_grid">
                                    <div class="inlin_message_color" style="flex:5%; padding-left:4px; height:35px; background-color: #eff5f0"></div>
                                    <div class="inlin_message_color" style="flex:95%; padding-right:4px; height:35px; background-color: #eff5f0">
                                        Current courses to register
                                    </div>
                                </div><?php
						
                                if ($c > 0)
                                {
                                    $c;
                                }

                                while($stmt->fetch())
                                {
                                    if (is_null($iCreditUnit))
                                    {
                                        $iCreditUnit = 0;
                                    }
                                    
                                    $selected = 0;
                                    
                                    if ($ancilary_type  == 'Project')
                                    {
                                        if ($cEduCtgId_loc == 'PGX')
                                        {
                                            if ($semester_spent_loc <= 1)
                                            {
                                                continue;
                                            }
                                        }else if ($cEduCtgId_loc == 'PGY')
                                        {
                                            if ($cFacultyId_loc == 'SSC' || $cFacultyId_loc == 'ART' || $cFacultyId_loc == 'EDU' || $cFacultyId_loc == 'HSC' || $cFacultyId_loc == 'LAW' || $cFacultyId_loc == 'CMP')
                                            {
                                                if ($semester_spent_loc < 3)
                                                {
                                                    continue;
                                                }
                                            }else if ($cFacultyId_loc == 'MSC')
                                            {
                                                if ($cProgrammeId_loc == 'MSC404' || $cProgrammeId_loc == 'MSC406')
                                                {
                                                    if ($semester_spent_loc < 3)
                                                    {
                                                        continue;
                                                    }
                                                }else if ($semester_spent_loc < 4)
                                                {
                                                    continue;
                                                }
                                            }
                                            /*if ($number_of_prev_sem < $number_of_semesters_loc)
                                            {
                                                continue;
                                            }*/
                                        }
                                    }

                                    $c++;

                                    $deg_cond = '';
                                    if (!is_bool(strpos($cProgrammeId_loc, "DEG")))
                                    {
                                        if ($deg_appl_cat == '1')
                                        {
                                            $deg_cond = " AND fee_item_desc LIKE '%NOUN Incubatee'";
                                        }else if ($deg_appl_cat == '2')
                                        {
                                            $deg_cond = " AND fee_item_desc LIKE '%Staff/Alumni'";
                                        }else if ($deg_appl_cat == '3')
                                        {
                                            $deg_cond = " AND fee_item_desc LIKE '%Public'";
                                        }
                                    }

                                    if ($cCourseId == 'NSC505' || $cCourseId == 'NSC501' || $cCourseId == 'NSC401')
                                    {
                                        $Amount = 3000;
                                        $itemid = '2134';
                                    }else if ($cCourseId == 'PHS326' || $cCourseId == 'PHS430')
                                    {
                                        $Amount = 15000;
                                        $itemid = '7116';
                                    }else if ($cCourseId == 'PHS823')
                                    {
                                        $Amount = 20000;
                                        $itemid = '7180';
                                    }else if ($cCourseId == 'MAC312' || $cCourseId == 'MAC421')
                                    {
                                        $Amount = 6500;
                                        $itemid = '7115';
                                    }else if ($cCourseId == 'DES303')
                                    {
                                        $Amount = 2500;
                                        $itemid = '7115';
                                    }else 
                                    {
                                        if ($ancilary_type == 'normal' || $ancilary_type == 'Laboratory')
                                        {
                                            if ($cEduCtgId_loc == 'PGZ' || $cEduCtgId_loc == 'PRX')
                                            {
                                                $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
                                                FROM s_f_s a, fee_items b
                                                WHERE a.fee_item_id = b.fee_item_id
                                                AND (fee_item_desc LIKE '%Course Registration%' $deg_cond)
                                                AND cEduCtgId = '$cEduCtgId_loc'
                                                AND cFacultyId = '$cFacultyId_loc'
                                                $sql_feet_type");
                                            }else
                                            {
                                                $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
                                                FROM s_f_s a, fee_items b
                                                WHERE a.fee_item_id = b.fee_item_id
                                                AND (fee_item_desc LIKE '%Course Registration%' $deg_cond)
                                                AND iCreditUnit = $iCreditUnit
                                                AND cEduCtgId = '$cEduCtgId_loc'
                                                AND cFacultyId = '$cFacultyId_loc'
                                                $sql_feet_type");
                                            }
                                        }else 
                                        {
                                            $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
                                            FROM s_f_s a, fee_items b
                                            WHERE a.fee_item_id = b.fee_item_id
                                            AND b.fee_item_desc = '$ancilary_type'
                                            AND cEduCtgId = '$cEduCtgId_loc'
                                            AND cFacultyId = '$cFacultyId_loc'
                                            $sql_feet_type");
                                        }

                                        $stmt_amount->execute();
                                        $stmt_amount->store_result();
                                        $stmt_amount->bind_result($Amount, $itemid);
                                        $stmt_amount->fetch();
                                        $stmt_amount->close();
                                    }
                                    
                                    if (is_null($Amount))
                                    {
                                        $Amount = 0.0;
                                    }
                                        
                                        if (($tSemester_loc%2) > 0 || $tSemester_loc == 1){$semester = 'First ';}else{$semester = 'Second ';}?>
                                        <label for="regCourses<?php echo $c ?>">
                                            <div class="appl_left_child_div_child calendar_grid course_line">
                                                <div style="flex:5%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                                    <?php echo $c;?>
                                                </div>
                                                <div style="flex:15%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                                    <input name="regCourses<?php echo $c ?>" id="regCourses<?php echo $c ?>" type="checkbox"
                                                    onclick="if(this.checked)
                                                    {
                                                        var total_credit_unit_toreg = parseInt(_('total_credit_unit_toreg').value);

                                                        var total_credit_unit_pend = 0;
                                                        if (_('total_credit_unit_pend'))
                                                        {
                                                            var total_credit_unit_pend = parseInt(_('total_credit_unit_pend').value);
                                                        }

                                                        var max_crload = parseInt(_('max_crload').value);
                                                        var carried_crload = parseInt(_('carried_crload').value);
                                                        var cr = parseInt(_('credUniInput<?php echo $c ?>').value);
                                                        
                                                        if (course_form.cEduCtgId.value != 'ELX' && (total_credit_unit_pend + total_credit_unit_toreg + cr + carried_crload) > max_crload)
                                                        {
                                                            caution_inform('Maximum credit unit exceeded');
                                                            return false;
                                                        }

                                                        var balance = parseInt(_('wallet').value);
                                                        var total_cost_all = parseInt(_('grand_total_amnt').value);

                                                        var total_amnt_pend = 0;
                                                        if (_('total_amnt_pend'))
                                                        {
                                                            var total_amnt_pend = parseInt(_('total_amnt_pend').value);
                                                        }

                                                        var total_amnt_toreg = parseInt(_('total_amnt_toreg').value);
                                                        var amount = parseInt(_('amntInput<?php echo $c ?>').value);
                                                    
                                                        if (balance < total_cost_all + amount && course_form.cEduCtgId.value != 'ELX')
                                                        {
                                                            caution_inform('<b>Insufficient fund</b><p>To fund your eWallet:<br>1. Click the Ok button<br>2. Click Bursary above<br>3. Click Make payment (left)<br>4. Follow the prompt on the screen');
                                                            return false;
                                                        }

                                                        this.value='<?php echo $cCourseId;?>';
                                                    }else if (/*course_form.cProgrammeId.value.indexOf('DEG') == -1 && _('cc_must').value == '1' &&*/ _('cCategoryInput<?php echo $c ?>').value == 'C')
                                                    {
                                                        if (_('cc_must').value == '0')
                                                        {
                                                            caution_inform('You should not leave out a core course');
                                                        }else if (_('cc_must').value == '1')
                                                        {
                                                            caution_inform('You cannot not leave out a core course');
                                                            return false
                                                        }
                                                    }else
                                                    {
                                                        this.value='';
                                                    }
                                                    set_figures(this.checked,<?php echo $Amount.','. $iCreditUnit; ?>,'toreg')"

                                                    <?php if (($balance >= $total_cost_all + $total_cost + $Amount) && 
                                                    ($tcr_all + $tcr1 + $iCreditUnit + $carried_crload <= $max_crload_loc) && $cCategory == 'C' && $orgsetins["enforce_co"] == '1')
                                                    {
                                                        echo ' checked ';
                                                        $tcr1 += $iCreditUnit;
                                                        $selected = 1;
                                                    }
                                                    
                                                    if ($cFacultyId_loc <> 'CHD' && ($Amount < 2000.00 || ($cCourseId <> 'DES303' && $iCreditUnit == 0)))
                                                    {
                                                        echo ' disabled';
                                                    }?>
                                                value="<?php echo $cCourseId;?>"/>
                                                <?php echo $cCourseId;?>
                                            </div>
                                            <div style="flex:50%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                                <?php echo $vCourseDesc;?>
									            <input id="vCourseDesc<?php echo $c ?>" type="hidden" value="<?php echo $vCourseDesc ?>"/>
                                            </div>
                                            <div id="credUnitDiv<?php echo $c ?>" style="flex:7%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;"><?php 
                                                echo $iCreditUnit;?>
            
                                                <input id="credUniInput<?php echo $c ?>" type="hidden" value="<?php echo $iCreditUnit ?>"/>
                                            </div>
                                            <div style="flex:7%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                                <?php echo $cCategory;?>
                                                <input id="cCategoryInput<?php echo $c ?>" type="hidden" value="<?php echo $cCategory ?>"/>
                                            </div>
                                            <div style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;"><?php 
                                                if ($selected == 1)
                                                {
                                                    $total_cost = $total_cost  + $Amount;
                                                }
                                                echo number_format($Amount, 0, '', ',');?>
                                                <input id="amntInput<?php echo $c ?>" type="hidden" value="<?php echo $Amount;?>"/>
                                                <input id="itemid<?php echo $c ?>" type="hidden" value="<?php echo $itemid; ?>"/>
                                                <input id="ancilary_type<?php echo $c ?>" type="hidden" value="<?php echo $ancilary_type; ?>"/>
                                            </div>
                                        </div>
                                    </label><?php 
                                }
                                $stmt->close();?>

                                <input name="loc_numOfiputTag0" id="loc_numOfiputTag0" type="hidden" value="<?php echo $c ?>"/>
                            
                                <div class="appl_left_child_div_child calendar_grid" style="font-weight: bold;">
                                    <div style="flex:5%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                    </div>
                                    <div style="flex:15%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                    </div>
                                    <div style="flex:50%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right">
                                        Total
                                    </div>
                                    <div id="total_credunit_div_toreg" style="flex:7%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;"><?php 
                                        echo $tcr1; $tcr_all += $tcr1;?>
                                    </div>
                                    <input id="total_credit_unit_toreg" type="hidden" value="<?php echo $tcr1;?>"/>
                                    <div style="flex:7%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                    </div>
                                    <div id="total_amnt_div_toreg" style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;"><?php 
                                        echo $total_cost;
                                        $total_cost_all += $total_cost;?>
                                    </div>
                                </div>

                                <input id="total_amnt_toreg" type="hidden" value="<?php echo $total_cost;?>"/>
                                
                                <input id="grand_total_amnt" type="hidden" value="<?php echo $total_cost_all;?>"/>
                                
                                <input name="loc_numOfiputTag_0" id="loc_numOfiputTag_0" type="hidden" value="<?php echo $c ?>"/>
                                
                                <!-- <input name="total_amnt_curent_sel" id="total_amnt_curent_sel" type="hidden"/> -->

                                <div class="appl_left_child_div_child calendar_grid" style="font-weight: bold;">
                                    <div style="flex:5%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                    </div>
                                    <div style="flex:15%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                    </div>
                                    <div style="flex:50%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right">
                                        Grand Total
                                    </div>
                                    <div  id="grand_total_creditunit_div" style="flex:7%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;"><?php echo $tcr_all;?></div>
                                    <input name="grand_total_credit_unit" id="grand_total_credit_unit" type="hidden" value="<?php echo $tcr_all;?>" />
                                    
                                    <div style="flex:7%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                    </div>
                                    <div id="grand_total_amount_div" style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;"><?php echo number_format($total_cost_all, 0, '', ',');?></div>

                                    <input name="grand_total_amount" id="grand_total_amount" type="hidden" value="<?php echo $total_cost_all;?>" />
                                    <input name="arch_grand_totalAmnt" id="arch_grand_totalAmnt" type="hidden" value="<?php echo $balance; ?>" />

                                    <input name="student_balance" id="student_balance" type="hidden" value="<?php echo $balance;?>"/>
                                    <!--<input name="numofreg" id="numofreg" type="hidden" value="<?php echo $c; ?>" />
                                    <input name="num_reg_crs" id="num_reg_crs" type="hidden" value="<?php echo $num_reg_crs; ?>"/> -->
                                </div>

                                <div id="btn_div" style="display:flex; 
                                    flex:100%;
                                    height:auto; 
                                    margin-top:10px;">
                                        <button id="submit_btn" type="button" class="login_button" 
                                        onclick="chk_inputs();">Submit</button>
                                </div><?php
                            }?><?php
                        }?>
                    </form>
                </div>
            </div>

            <div id="menu_bs_scrn" class="appl_far_right_div" style="z-index:2;">
                <?php build_menu_right($balance);?>
            </div>
        </div>
	</body>
</html>