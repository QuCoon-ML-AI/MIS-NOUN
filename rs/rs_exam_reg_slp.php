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
		<script language="JavaScript" type="text/javascript" src="./bamboo/reg_exam_slp.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/std_m_js.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE_FILE_NAME;?>styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/reg_exam_slp.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rs_side_menu.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body>
        <div id="confirm_box_loc" class="center top_most talk_backs talk_backs_logo" 
            style="border-color:#4fbf5c; 
            background-size:30px 40px; 
            background-position:20px 18px; 
            background-image: url('<?php echo BASE_FILE_NAME_FOR_IMG;?>help.png');">
            <div id="msg_div" class="informa_msg_content_caution_cls" style="color:#4fbf5c; text-align:left">
                Drop selected courses for exam? </div><p>
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
        </div>
        
        
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
                    Another token sent
                </div>

                <div id="msg_div" class="informa_msg_content_caution_cls" style="text-align:left; height:40px; margin-top:10px">
                    <input type="text" id="user_token" name="user_token" onfocus="_('msg_div_resend').style.display='none'" 
                        placeholder="Enter token here..."
						autocomplete="off" required>
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
        </form><?php
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
       
        $sql_feet_type = select_fee_srtucture($_REQUEST["vMatricNo"], $cResidenceCountryId_loc, $cEduCtgId_loc); ?>        
            
        <div class="appl_container">
            <div class="appl_left_div" style="z-index:2;">
                <div class="appl_left_child_logo_div"></div>
                <div class="appl_left_child_div" style="margin-top:0px; font-size:1.1em; font-weight:bold">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;  font-size:1.2em">Exam registration slip</div>
                
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

                <div class="appl_left_child_div" style="width:98%; height:90%; overflow:auto; margin:auto; background-color:#eff5f0"><?php
                    $can_see_slip = 1;
                    
                    /*if (!(((!is_bool(strpos($cProgrammeId_loc, "CHD")) || 
                    (!is_bool(strpos($cProgrammeId_loc, "DEG")))) && $reg_open_cert == 1) || 
                    (is_bool(strpos($cProgrammeId_loc, "CHD")) && is_bool(strpos($cProgrammeId_loc, "DEG")) && $reg_open == 1) || get_active_request(4) == 1))
                    //if (get_active_request(0) <> 1 && get_active_request(1) <> 1 && ($session_open == 0 || $semester_open == 0 || $reg_open == 0))
                    {?>                            
                        <div class="appl_left_child_div_child calendar_grid">
                            <div class="inlin_message_color" style="flex:5%; padding-left:4px; height:40px; background-color: #ffffff"></div>
                            <div class="inlin_message_color" style="flex:95%; padding-right:4px; height:40px;">
                                Semester closed. You are advised to check for update at least, twice in a week
                            </div>
                        </div><?php
                        $can_see_slip = 0;
                    }else */if ($semester_reg_loc == '0')
                    {?>                            
                        <div class="appl_left_child_div_child calendar_grid">
                            <div class="inlin_message_color" style="flex:5%; padding-left:4px; height:40px; background-color: #ffffff"></div>
                            <div class="inlin_message_color" style="flex:95%; padding-right:4px; height:40px;">
                                Please register for current semester on your home page. See procedure 'K' in <a href="#" style="text-decoration:none; color:#FF3300" 
                                onclick="guides_instructions.submit();
                                return false">'How to do things'</a> for steps to follow
                            </div>
                        </div><?php
                        $can_see_slip = 0;
                    }else
                    {
                        if (get_active_request(2) == 1 || $orgsetins['drp_exam'] == '1')
                        {
                            date_default_timezone_set('Africa/Lagos');

                            $currentDate = date('Y-m-d');
                            $set_date = substr($orgsetins['drp_examdate'],4,4).'-'.substr($orgsetins['drp_examdate'],2,2).'-'.substr($orgsetins['drp_examdate'],0,2);
                            $set_date_2 = substr($orgsetins['drp_exam_2date'],4,4).'-'.substr($orgsetins['drp_exam_2date'],2,2).'-'.substr($orgsetins['drp_exam_2date'],0,2);
                            
                            $stmt_last = $mysqli->prepare("SELECT * FROM matno_reg_24 WHERE vMatricNo = ?");
                            $stmt_last->bind_param("s", $_REQUEST["vMatricNo"]);
                            $stmt_last->execute();
                            $stmt_last->store_result();
                            $mul_reg = $stmt_last->num_rows;
                            $stmt_last->close();
                            
                            if ($mul_reg == 0 && (get_active_request(2) == 1 || ($iStudy_level_loc <= 200 && $currentDate <= $set_date) || ($iStudy_level_loc > 200 && $currentDate <= $set_date_2)))
                            {?>
                                <div class="appl_left_child_div_child calendar_grid">
                                    <div class="inlin_message_color" style="flex:5%; padding-left:4px; height:45px; background-color: #ffffff"></div>
                                    <div class="inlin_message_color" style="flex:95%; padding-right:4px; height:45px;">
                                        Please note that you are solely responsible for dropping of registered courses for exam on this page, whether it is done for you or you did it by yourself
                                    </div>
                                </div>
                            
                                <div id="btn_div" style="display:flex; 
                                    flex:100%;
                                    height:auto; 
                                    gap:15px;
                                    margin-top:10px;
                                    margin-bottom:10px;
                                    justify-content:flex-start;">                            
                                        <button id="select_all0" type="button" class="login_button" 
                                            onclick="for (var cnt = 1; cnt <= _('loc_numOfiputTag').value; cnt++)
                                            {
                                                if (_('regCourses'+cnt) && _('regCourses'+cnt).disabled == false && _('select_all0').innerHTML=='Select all')
                                                {
                                                    _('regCourses'+cnt).checked=true;
                                                }else if (_('regCourses'+cnt).disabled == false)
                                                {
                                                    _('regCourses'+cnt).checked=false;
                                                }
                                            }

                                            if(_('select_all0').innerHTML=='Select all')
                                            {
                                                _('select_all0').innerHTML='De-select all';
                                            }else
                                            {
                                                _('select_all0').innerHTML='Select all';
                                            }
                                            return false;">Select all</button>
                                        <button type="submit" class="login_button" 
                                            onclick="course_form.drp_exam.value=1;
                                            _('conf').value='-1';
                                            chk_inputs();
                                            return false">Drop course for exam</button>
                                </div><?php 
                            }else
                            {?>
                                <div class="appl_left_child_div_child calendar_grid" style="margin:0px;">
                                    <div style="flex:5.2%; padding-top:5px; height:35px; background-color: #ffffff; text-align:right;">
                                    </div>
                                    <div style="flex:95%; padding-top:5px; padding-left:4px; height:35px; background-color: #fdf0bf"><?php
                                        if ($mul_reg == 0)
                                        {
                                            echo 'Dropping course for exam - closed';
                                        }else
                                        {
                                            echo '';
                                        }?>
                                    </div>
                                </div><?php
                            }
                        }else
                        {?>
                            <div class="appl_left_child_div_child calendar_grid" style="margin:0px;">
                                <div style="flex:5.2%; padding-top:5px; height:35px; background-color: #ffffff; text-align:right;">
                                </div>
                                <div style="flex:95%; padding-top:5px; padding-left:4px; height:35px; background-color: #fdf0bf">
                                    Watch out for button for dropping course for exam here
                                </div>
                            </div><?php
                        }?>

                        <div class="appl_left_child_div_child calendar_grid" style="font-weight: bold; margin:0px;">
                            <div style="flex:5%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                Sno
                            </div>
                            <div style="flex:10%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                Course Code
                            </div>
                            <div style="flex:40%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                Course Title
                            </div>
                            <div style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                Credit unit
                            </div>
                            <div style="flex:10%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                Category
                            </div>
                            <div style="flex:15%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                Date
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
                        <form action="" method="post" name="course_form" id="course_form" enctype="multipart/form-data">
                            <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] <> ''){echo $_REQUEST["user_cat"];}?>" />
                            <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"]) && $_REQUEST["ilin"] <> ''){echo $_REQUEST["ilin"];}?>" />
                            <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>" />
                            
                            <input name="edu_cat" id="edu_cat" type="hidden" value="<?php echo $cEduCtgId_loc;?>" />
                            
                            <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] <> ''){echo $_REQUEST["top_menu_no"];}?>" />
                            <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> ''){echo $_REQUEST["side_menu_no"];}?>" />
                            
                            <input name="conf" id="conf" type="hidden" value="-1" />
                            <input name="max_crload" id="max_crload" type="hidden" value="<?php echo $max_crload_loc; ?>"/>
                            <input name="AcademicDesc" id="AcademicDesc" type="hidden" value="<?php echo $orgsetins['cAcademicDesc']; ?>" />
                            <input name="iStudy_level" id="iStudy_level" type="hidden" value="<?php echo $iStudy_level_loc; ?>" />
                            <input name="tSemester" id="tSemester" type="hidden" value="<?php echo $tSemester_loc; ?>" />
                            <input name="drp_exam" id="drp_exam" type="hidden" value="0" /><?Php
                            
                            $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
                            FROM s_f_s a, fee_items b
                            WHERE a.fee_item_id = b.fee_item_id
                            AND fee_item_desc = 'Examination Registration'
                            AND cEduCtgId = '$cEduCtgId_loc'
                            $sql_feet_type");
                            $stmt_amount->execute();
                            $stmt_amount->store_result();
                            $stmt_amount->bind_result($Amount, $itemid);
                            $stmt_amount->fetch();
                            $stmt_amount->close();
                            
                            if (is_null($Amount))
                            {
                                $Amount = 0.00;
                            }
                                                        
                            $arr_trabsactions = array(array(array()));

                            $cnt = 0;
                            $table = search_starting_pt_crs($_REQUEST['vMatricNo']);
                            foreach ($table as &$value)
                            {
                                $wrking_tab = 'coursereg_arch_'.$value;
                                $stmt = $mysqli->prepare("SELECT cCourseId, vCourseDesc, cCategory, iCreditUnit
                                FROM $wrking_tab
                                WHERE vMatricNo = ?
                                ORDER BY cCourseId");
                                
                                $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($cCourseId, $vCourseDesc, $cCategory, $iCreditUnit);
                                
                                while($stmt->fetch())
                                {
                                    if (isset($cCourseId))
                                    {
                                        $cnt++;
                                        $arr_trabsactions[$cnt]['cCourseId'] = $cCourseId;
                                        $arr_trabsactions[$cnt]['vCourseDesc'] = $vCourseDesc;
                                        $arr_trabsactions[$cnt]['cCategory'] = $cCategory;
                                        $arr_trabsactions[$cnt]['iCreditUnit'] = $iCreditUnit;
                                        
                                        /*echo $arr_trabsactions[$cnt]['cCourseId'].', '.
                                        $arr_trabsactions[$cnt]['vCourseDesc'].', '.
                                        $arr_trabsactions[$cnt]['cCategory'].', '.
                                        $arr_trabsactions[$cnt]['iCreditUnit'].'<p>';*/
                                    }
                                }
                            }
                            
                            $stmt->close();
                            
                            $c = 0; 
                            $total_cost = 0; 
                            $total_cr = 0;
                            $tcr1 = 0;
                            
                            $total_cost_all = 0;

                            // $stmt = $mysqli->prepare("SELECT cCourseId, tdate
                            // FROM examreg_20242025
                            // WHERE siLevel = $iStudy_level_loc
                            // AND tSemester = $tSemester_loc
                            // AND cAcademicDesc = '".$orgsetins['cAcademicDesc']."'
                            // AND vMatricNo = ?
                            // ORDER BY cCourseId");

                            $stmt = $mysqli->prepare("SELECT cCourseId, tdate
                            FROM examreg_20242025
                            WHERE tdate >= '$semester_begin_date'
                            AND vMatricNo = ?
                            ORDER BY cCourseId");
                            
                            $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($cCourseId, $tdate);
                            //$stmt->bind_result($cCourseId, $vCourseDesc, $cCategory, $iCreditUnit, $tdate);
                            if ($stmt->num_rows == 0)
                            {?>                                
                                <div class="appl_left_child_div_child calendar_grid" style="margin:0px;">
                                    <div style="flex:5.2%; padding-top:5px; height:35px; background-color: #ffffff; text-align:right;">
                                    </div>
                                    <div style="flex:95%; padding-top:5px; padding-left:4px; height:35px; background-color: #fdf0bf">
                                    You need to register courses for exam for the current semester. See procedure 'M' in <a href="#" style="text-decoration:none; color:#FF3300" 
                                        onclick="guides_instructions.submit();
                                        return false">'How to do things'</a> for steps to follow
                                    </div>
                                </div><?php
                                $can_see_slip = 0;
                                $stmt->close();
                            }else
                            {
                                $misconduct = 0;

                                while($stmt->fetch())
                                {
                                    $stmt_anx = $mysqli->prepare("SELECT ancilary_type
                                    FROM courses_new
                                    WHERE cCourseId = '$cCourseId'");
                                    $stmt_anx->execute();
                                    $stmt_anx->store_result();
                                    $stmt_anx->bind_result($ancilary_type);
                                    $stmt_anx->fetch();
                                    
                                    $record_found = 0;
                                    $vCourseDesc = '';
                                    $cCategory = '';
                                    $iCreditUnit = '';
                                            
                                    for ($b = 1; $b <= count($arr_trabsactions)-1; $b++)
                                    {
                                        if ($arr_trabsactions[$b]['cCourseId'] == $cCourseId)
                                        {
                                            $vCourseDesc = $arr_trabsactions[$b]['vCourseDesc'];
                                            $cCategory = $arr_trabsactions[$b]['cCategory'];
                                            $iCreditUnit = $arr_trabsactions[$b]['iCreditUnit'];
                                            $record_found = 1;
                                            break;
                                        }
                                    }
                                    
                                    if ($record_found == 1)
                                    {
                                        if ((!($cProgrammeId_loc == 'LAW301' || $cProgrammeId_loc == 'LAW401') && ($tcr1 + $iCreditUnit) > 24) || 
                                        (($cProgrammeId_loc == 'LAW301' || $cProgrammeId_loc == 'LAW401') && ($tcr1 + $iCreditUnit) > 29))
                                        {
                                            $misconduct = 1;
                                            //break;
                                        }
                                    }

                                    
                                    if ($cCourseId == 'EDU216' || $cCourseId == 'MAC312' || $cCourseId == 'MAC421' || $cCourseId == 'PHS823' || $cCourseId == 'PHS326' || $cCourseId == 'PHS430')
                                    {
                                        $Amount = 0.0;
                                        $itemid = '';
                                    }else if ($ancilary_type == 'Laboratory')
                                    {
                                        $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
                                        FROM s_f_s a, fee_items b
                                        WHERE a.fee_item_id = b.fee_item_id
                                        AND fee_item_desc = 'Laboratory'
                                        AND cEduCtgId = '$cEduCtgId_loc'
                                        AND cFacultyId = '$cFacultyId_loc'
                                        $sql_feet_type");
                                        $stmt_amount->execute();
                                        $stmt_amount->store_result();
                                        $stmt_amount->bind_result($Amount, $itemid);
                                        $stmt_amount->fetch();
                                        $stmt_amount->close();
                                        
                                        $Amount = 6500;
                                    }else
                                    {
                                        $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
                                        FROM s_f_s a, fee_items b
                                        WHERE a.fee_item_id = b.fee_item_id
                                        AND fee_item_desc = 'Examination Registration'
                                        AND cEduCtgId = '$cEduCtgId_loc'
                                        $sql_feet_type");
                                        $stmt_amount->execute();
                                        $stmt_amount->store_result();
                                        $stmt_amount->bind_result($Amount, $itemid);
                                        $stmt_amount->fetch();
                                        $stmt_amount->close();
                                                    
                                        if (is_null($Amount))
                                        {
                                            $Amount = 0.0;    
                                        }
                                    }
                                    
                                    
                                    if ($record_found == 0)
                                    {
                                        continue;
                                    }
                                    
                                    $c++;?>

                                    <label for="regCourses<?php echo $c ?>">
                                        <div class="appl_left_child_div_child calendar_grid">
                                            <div style="flex:5%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                                <?php echo $c;?>
                                            </div>

                                            <div style="flex:10%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff"><?php
                                            if (($ancilary_type == 'normal' || $ancilary_type == 'Laboratory') && $orgsetins['drp_exam'] == '1' && $currentDate <= $set_date)
                                                {?>
                                                    <input name="regCourses<?php echo $c ?>" id="regCourses<?php echo $c ?>" type="checkbox"
                                                    value="<?php echo $cCourseId;?>" /><?php
                                                }else
                                                {?>
                                                    <input name="regCourses<?php echo $c ?>" id="regCourses<?php echo $c ?>" type="checkbox"  disabled/><?php
                                                }
                                                echo $cCourseId;?>
                                            </div>

                                            <div style="flex:40%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                                <?php echo $vCourseDesc;?>
                                                <input id="vCourseDesc<?php echo $c ?>" type="hidden" value="<?php echo $vCourseDesc ?>"/>
                                            </div>

                                            <div id="credUnitDiv<?php echo $c ?>" style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                                <?php echo $iCreditUnit; $tcr1 += $iCreditUnit;?>        
                                                <input id="credUniInput<?php echo $c ?>" type="hidden" value="<?php echo $iCreditUnit ?>"/>
                                            </div>

                                            <div style="flex:10%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                                <?php echo $cCategory;?>
                                            </div>

                                            <div style="flex:15%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                                <?php echo formatdate($tdate, 'fromdb').' '.substr($tdate, 11,strlen($tdate)-1);?>
                                            </div>

                                            <div style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;"><?php 
                                                if ($ancilary_type == 'normal' || $ancilary_type == 'Laboratory')
                                                {
                                                    echo number_format($Amount, 0, '', ','); 
                                                    $total_cost = $total_cost  + $Amount;
                                                }else
                                                {
                                                    echo 'NA';
                                                }?>
                                                <input id="amntInput<?php echo $c ?>" type="hidden" 
                                                    value="<?php if ($ancilary_type == 'normal' || $ancilary_type == 'Laboratory')
                                                    {
                                                        echo $Amount;
                                                    }else
                                                    {
                                                        echo '0';
                                                    }?>"/>
                                                <input id="itemid<?php echo $c ?>" type="hidden" value="<?php echo $itemid; ?>"/>
                                                
                                                <input id="exam_amntInput<?php echo $c ?>" type="hidden" 
                                                    value="<?php if ($ancilary_type == 'normal' || $ancilary_type == 'Laboratory')
                                                    {
                                                        echo $Amount;
                                                    }else
                                                    {
                                                        echo '0';
                                                    }?>"/>
                                                <input id="exam_itemid<?php echo $c ?>" type="hidden" value="<?php echo $itemid; ?>"/>
                                            </div>
                                        </div>
                                    </label><?php
                                }
                                
                                $stmt_anx->close();
                                $stmt->close();?>
                                
                                <div class="appl_left_child_div_child calendar_grid" style="font-weight: bold; margin:0px;">
                                    <div style="flex:5%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                    </div>
                                    <div style="flex:10%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                    </div>
                                    <div style="flex:40%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right">
                                        Total
                                    </div>
                                    <div id="total_credunit_div_toreg" style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                        <?php echo $tcr1;?>
                                        <input id="total_credit_unit_toreg" type="hidden" value="<?php echo $tcr1;?>"/>
                                    </div>
                                    <div style="flex:10%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                    </div>
                                    <div style="flex:15%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                    </div>
                                    <div id="total_amnt_div_toreg" style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                    <?php echo number_format($total_cost, 0, '', ',');
                                        $total_cost_all += $total_cost;?>
                                    </div>
                                    <input name="loc_numOfiputTag" id="loc_numOfiputTag" type="hidden" value="<?php echo $c ?>"/>
                                </div><?php
                                if ($misconduct == 0)
                                {?>
                                    <div id="btn_div" style="display:flex; 
                                        flex:100%;
                                        height:auto;
                                        margin-top:10px;">
                                            <button id="submit_btn" type="button" class="login_button" 
                                            onclick="std_id_card.action='print-result'; std_id_card.submit();">Print</button>
                                    </div><?php
                                }else
                                {?>
                                   <div class="appl_left_child_div_child calendar_grid" style="margin:0px;">
                                        <div style="flex:5.2%; padding-top:5px; height:35px; background-color: #ffffff; text-align:right;">
                                        </div>
                                        <div style="flex:95%; padding-top:5px; padding-right:4px; height:35px; text-align:right; background-color: #fdf0bf">
                                            Drop excess credit load to avoid future delay.
                                        </div>
                                    </div><?php 
                                }?>
                            </form><?php
                            }
                        }?>
                </div>
            </div>

            <div id="menu_bs_scrn" class="appl_far_right_div" style="z-index:2;">
                <?php build_menu_right($balance);?>
            </div>
        </div>
	</body>
</html>