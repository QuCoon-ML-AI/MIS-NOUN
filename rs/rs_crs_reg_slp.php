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
		<script language="JavaScript" type="text/javascript" src="./bamboo/reg_crs_slp.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/std_m_js.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE_FILE_NAME;?>styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/reg_crs_slp.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rs_side_menu.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
	    $mysqli = link_connect_db();

        $orgsetins = settns();
        
        require_once(BASE_FILE_NAME."feedback_mesages.php");
        
        require_once("std_detail_pg1.php");
        require_once("forms.php");
        
        require_once("./set_scheduled_dates.php");

        if (!is_bool(strpos($cProgrammeId_loc, "CHD")))
        {?>
            <div id="smke_screen_cm" class="smoke_scrn" style="display:block;
                z-index:3"></div>

            <div id="container_cover_in_cm" class="center" 
                style="display:flex; 
                flex-direction:column; 
                gap:15px;  
                justify-content:space-around; 
                max-height:70vh;
                padding:10px;
                box-shadow: 2px 2px 8px 2px #726e41;
                background-color:#fff;
                overflow:auto;
                x-overflow:hidden;
                z-index:4">
                <div style="line-height:2.0; width:70%; font-weight:bold">
                    Course materials
                </div>
                <div style="line-height:2.0; width:20; position:absolute; top:10px; right:10px;">
                    <img style="width:17px; height:17px; cursor:pointer" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" 
                    onclick="_('container_cover_in_cm').style.zIndex = -1;
                        _('container_cover_in_cm').style.display = 'none';
                        _('smke_screen_cm').style.zIndex = -1;
                        _('smke_screen_cm').style.display = 'none';"/>
                </div>

                <div style="line-height:1.4; padding:8px 0px 8px 5px; width:99%; background-color: #fdf0bf; margin-top:10px;">
                    Click on the links below to download course material
                </div><?php
                
                $stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc
                FROM coursereg_arch_20242025 a, courses_new b
                WHERE a.cCourseId = b.cCourseId
                AND a.vMatricNo = ?
                AND a.siLevel = $iStudy_level_loc
                AND a.tSemester = $tSemester_loc
                ORDER BY a.siLevel, a.tSemester, a.cCategory, a.cCourseId");

                $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($cCourseId, $vCourseDesc);
                while($stmt->fetch())
                {
                    if ($cProgrammeId_loc == 'CHD001')
                    {
                        if ($cCourseId == "BES001")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/BES001_Communication_and_Presentation_Skills.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "BES001")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/BES002_Leadership_Skills.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "BES002")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/BES002_Leadership_Skills.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "BES003")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/BES003_Financial_Literacy.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "BES004")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/BES004_Creativity_and_Innovation.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "BES005")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/BES005_Business_Plan.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "PCC001")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/PCC001_The_Childcare_Provider.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "PCC002")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/PCC002_Hygiene_and_Physical_Care.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "PCC003")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/PCC003_Nutrition.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "PCC004")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/PCC004_Milestones.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "PCC005")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/PCC005_Social_Skills.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "PCC006")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/PCC006_Importance_of_Play.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "PCC007")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/PCC007_Basic_First_Aid.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "PCC008")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/PCC008_Dealing_with_Emergencies.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "PCC009")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/PCC009_Safety_and_Making_Sure_that_Accidents_Do_Not_Happen.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "PCC010")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/PCC010_Safety_and_Making_Sure_that_Accidents_Do_Not_Happen.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }
                    }else if ($cProgrammeId_loc == 'CHD007')
                    {
                        if ($cCourseId == "ATC041")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/ATC041 Combine_1.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "ATC042")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/ATC042 AUTODIAGNOSTIC SYSTEM.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "ATC043")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/ATC043 AUTOTRONICS AND ELECTRIC VEHICLES.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "ATC044")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/ATC044 GPS AND TARCKINGSYSTEM FOR AUTOMOBILES.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }else if ($cCourseId == "ATC045")
                        {?>
                            <div style="line-height:2.0;">
                                <a href="../ext_docs/chd_mat/ATC045 ADVANCED DRIVER ASSISTANCE SYSTEMS.pdf" target="_blank" style="text-decoration:none" download><?php echo $cCourseId.' '.$vCourseDesc;?></a>
                            </div><?php
                        }
                    }
                }?>
            </div><?php
        }?>
        <div id="confirm_box_loc" class="center top_most talk_backs talk_backs_logo" 
            style="border-color:#4fbf5c; 
            background-size:30px 40px; 
            background-position:20px 18px; 
            background-image: url('<?php echo BASE_FILE_NAME_FOR_IMG;?>help.png');">
            <div id="msg_div" class="informa_msg_content_caution_cls" style="color:#4fbf5c; text-align:left">
                Drop selected courses ? </div><p>
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
                        placeholder="Enter token here..." required>
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
        
                    
        $balance = 0.00;
        
        $returnedStr = calc_student_bal($_REQUEST["vMatricNo"], 'mone_at_hand', $cResidenceCountryId_loc);

        $balance = trim(substr($returnedStr, 0, 100));
        $minfee = trim(substr($returnedStr, 100, 100));
        $iItemID_str = trim(substr($returnedStr, 200, 100));
        
        $sql_feet_type = select_fee_srtucture($_REQUEST["vMatricNo"], $cResidenceCountryId_loc, $cEduCtgId_loc);?>        
            
        <div class="appl_container">
            <div class="appl_left_div" style="z-index:2;">
                <div class="appl_left_child_logo_div"></div>
                <div class="appl_left_child_div" style="margin-top:0px; font-size:1.1em; font-weight:bold">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;  font-size:1.2em">Course registeration slip</div>
                
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
                    (is_bool(strpos($cProgrammeId_loc, "CHD")) && is_bool(strpos($cProgrammeId_loc, "DEG")) && $reg_open == 1) || get_active_request(1) == 1))
                    
                    //if (get_active_request(0) <> 1 && get_active_request(1) <> 1 && ($session_open == 0 || $semester_open == 0 || $reg_open == 0))
                    {?>                            
                        <div class="appl_left_child_div_child calendar_grid">
                            <div class="inlin_message_color" style="flex:5%; padding-left:4px; height:40px; background-color: #ffffff"></div>
                            <div class="inlin_message_color" style="flex:95%; padding-right:4px; height:40px;">
                                Semester closed. You are advised to check for update at least, twice in a week;
                            </div>
                        </div><?php
                    }else*/ if ($semester_reg_loc == '0')
                    {?>                            
                        <div class="appl_left_child_div_child calendar_grid">
                            <div class="inlin_message_color" style="flex:5%; padding-left:4px; height:40px; background-color: #ffffff"></div>
                            <div class="inlin_message_color" style="flex:95%; padding-right:4px; height:40px;">
                                Please register for current semester on your home page. See procedure 'K' in <a href="#" style="text-decoration:none; color:#FF3300" 
                                onclick="guides_instructions.submit();
                                return false">'How to do things'</a> for steps to follow
                            </div>
                        </div><?php
                    }else
                    {
                        $c = 0;

                        // $stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, a.siLevel, a.tSemester, a.tdate, a.iCreditUnit, a.cAcademicDesc, a.cCategory, a.ancilary_type
                        // FROM coursereg_arch_20242025 a
                        // WHERE a.vMatricNo = ?
                        // AND a.siLevel = $iStudy_level_loc
                        // AND a.tSemester = $tSemester_loc
                        // ORDER BY a.siLevel, a.tSemester, a.cCategory, a.cCourseId");

                        $stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, a.siLevel, a.tSemester, a.tdate, a.iCreditUnit, a.cAcademicDesc, a.cCategory, a.ancilary_type
                        FROM coursereg_arch_20242025 a
                        WHERE a.vMatricNo = ?
                        AND tdate >= '$semester_begin_date'
                        ORDER BY a.siLevel, a.tSemester, a.cCategory, a.cCourseId");
                        
                        $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($cCourseId, $vCourseDesc, $level, $tSemester, $tdate, $iCreditUnit, $cAcademicDesc, $cCategory, $ancilary_type);?><?php
                        if ($stmt->num_rows == 0)
                        {?>                            
                            <div class="appl_left_child_div_child calendar_grid" style="height:auto">
                                <div class="inlin_message_color" style="flex:5%; padding-left:4px; height:45px; background-color: #ffffff"></div>
                                <div class="inlin_message_color" style="flex:95%; padding-right:4px; height:45px;">
                                    You need to register courses for the current semester to see your course registration slip. See procedure 'L' in <a href="#" style="text-decoration:none; color:#FF3300" 
                                    onclick="guides_instructions.submit();
                                    return false">'How to do things'</a> for steps to follow
                                </div>
                            </div><?php
                            $stmt->close();
                        }else
                        {
                            if (get_active_request(2) == 1 || $orgsetins['drp_crs'] == '1')
                            {
                                //date_default_timezone_set('Africa/Lagos');

                                $currentDate = date('Y-m-d');
                                $set_date = substr($orgsetins['drp_crsdate'],4,4).'-'.substr($orgsetins['drp_crsdate'],2,2).'-'.substr($orgsetins['drp_crsdate'],0,2);
                                if (get_active_request(2) == 1 || $currentDate <= $set_date)
                                {?>
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
                                                onclick="course_form.drp_crs.value=1;
                                                _('conf').value='-1';
                                                chk_inputs();
                                                return false">Drop course</button>
                                    </div>
                                    
                                    <div class="appl_left_child_div_child calendar_grid">
                                        <div class="inlin_message_color" style="flex:5%; padding-left:4px; height:45px; background-color: #ffffff"></div>
                                        <div class="inlin_message_color" style="flex:95%; padding-right:4px; height:45px;">
                                            Please note that you are solely responsible for dropping of registered courses on this page, whether it is done for you or you did it by yourself
                                        </div>
                                    </div><?php 
                                }else
                                {?>
                                    <div class="appl_left_child_div_child calendar_grid" style="margin:0px;">
                                        <div style="flex:5.2%; padding-top:5px; height:35px; background-color: #ffffff; text-align:right;">
                                        </div>
                                        <div style="flex:95%; padding-top:5px; padding-left:4px; height:35px; background-color: #fdf0bf">
                                            Watch out for button for dropping course here
                                        </div>
                                    </div><?php
                                }
                            }else
                            {
                                if ($orgsetins['drp_crs'] == '1')
                                {?>
                                    <div class="appl_left_child_div_child calendar_grid" style="margin:0px;">
                                        <div style="flex:5.2%; padding-top:5px; height:35px; background-color: #ffffff; text-align:right;">
                                        </div>
                                        <div style="flex:95%; padding-top:5px; padding-left:4px; height:35px; background-color: #fdf0bf">
                                            Watch out for button for dropping course here
                                        </div>
                                    </div><?php
                                }
                                
                                if (!is_bool(strpos($cProgrammeId_loc, "CHD")))
                                {?>
                                    <div id="btn_div" style="display:flex; 
                                        flex:100%;
                                        height:auto;
                                        margin-top:10px;
                                        margin-bottom:10px;">
                                            <button id="submit_btn" type="button" class="login_button" 
                                            onclick="_('container_cover_in_cm').style.zIndex = 4;
                                            _('container_cover_in_cm').style.display = 'block';
                                            _('smke_screen_cm').style.zIndex = 3;
                                            _('smke_screen_cm').style.display = 'block';">See course materials</button>
                                    </div><?php
                                }
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
                                
                                <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] <> ''){echo $_REQUEST["top_menu_no"];}?>" />
                                <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> ''){echo $_REQUEST["side_menu_no"];}?>" />
                                
                                <input name="conf" id="conf" type="hidden" value="-1" />
                                <input name="max_crload" id="max_crload" type="hidden" value="<?php echo $max_crload_loc; ?>"/>
                                <input name="AcademicDesc" id="AcademicDesc" type="hidden" value="<?php echo $orgsetins['cAcademicDesc']; ?>" />
                                <input name="iStudy_level" id="iStudy_level" type="hidden" value="<?php echo $iStudy_level_loc; ?>" />
                                <input name="tSemester" id="tSemester" type="hidden" value="<?php echo $tSemester_loc; ?>" />
                                <input name="drp_crs" id="drp_crs" type="hidden" value="0" />
						        <input name="cProgrammeId" id="cProgrammeId" type="hidden" value="<?php echo $cProgrammeId_loc; ?>" />
                                
                        
                                <input name="edu_cat" id="edu_cat" type="hidden" value="<?php echo $cEduCtgId_loc; ?>" />
                                <input name="res_ctry" id="res_ctry" type="hidden" value="<?php echo $cResidenceCountryId_loc; ?>" /><?php
                                
                                
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

                                $c = 0; $total_cost = 0; $total_cr = 0;
                                $total_cost_all = 0;
                                $tcr1 = 0;
                                $prev_level = '';
                                $prev_semester = '';
                                while($stmt->fetch())
                                {
                                    $c++;
                                    
                                    if ($ancilary_type <> 'normal' && $ancilary_type <> 'Laboratory')
                                    {
                                        $stmt_amount = $mysqli->prepare("SELECT a.Amount, a.iItemID
                                        FROM s_f_s a, educationctg b, sell_item_cat c, fee_items d
                                        WHERE a.cEduCtgId = b.cEduCtgId 
                                        AND a.citem_cat = c.citem_cat
                                        AND a.fee_item_id = d.fee_item_id
                                        AND d.fee_item_desc = '$ancilary_type'
                                        AND a.cdel = 'N'
                        		        AND d.cdel = 'N'
                                        AND a.cEduCtgId = '$cEduCtgId_loc'
                                        AND cFacultyId = '$cFacultyId_loc'
                                        $sql_feet_type
                                        order by a.citem_cat, d.fee_item_desc");
                                        
                                        $stmt_amount->execute();
                                        $stmt_amount->store_result();
                                        
                                        $stmt_amount->bind_result($Amount, $itemid);
                                        $stmt_amount->fetch();
                                    }else
                                    {
                                        $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
                                        FROM s_f_s a, fee_items b
                                        WHERE a.fee_item_id = b.fee_item_id
                                        AND fee_item_desc = 'Course Registration'
                                        AND iCreditUnit = $iCreditUnit
                                        AND cEduCtgId = '$cEduCtgId_loc'
                                        AND cFacultyId = '$cFacultyId_loc'
                                        $sql_feet_type
                                        $deg_cond");
    
                                        $stmt_amount->execute();
                                        $stmt_amount->store_result();
                                        $stmt_amount->bind_result($Amount, $itemid);
                                        $stmt_amount->fetch();
                                    }
                                    
                                    $Amount = $Amount ?? 0;
                                    $stmt_amount->close();

                                    if (($prev_level == '' || $prev_level <> $level) || ($prev_semester <> '' && $prev_semester <> $tSemester))
                                    {?>
                                        <div class="appl_left_child_div_child calendar_grid" style="font-weight: bold; margin:0px;">
                                            <div style="flex:5.2%; padding-top:5px; height:35px; background-color: #ffffff; text-align:right;">
                                            </div>
                                            <div style="flex:95%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                                <?php echo $level.'Level, ';
                                                if ($tSemester == 1)
                                                {
                                                    echo 'First Semester';
                                                }else
                                                {
                                                    echo 'Second Semester';
                                                }?>
                                            </div>
                                        </div><?php
                                    }?>

                                    <label for="regCourses<?php echo $c ?>">
                                        <div class="appl_left_child_div_child calendar_grid">
                                            <div style="flex:5%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                                <?php echo $c;?>
                                            </div>

                                            <div style="flex:10%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff"><?php
                                                if (get_active_request(2) == 1 || ($orgsetins['drp_crs'] == '1' && $currentDate <= $set_date))
                                                {?>
                                                    <input name="regCourses<?php echo $c ?>" id="regCourses<?php echo $c ?>" type="checkbox"
                                                    value="<?php echo $cCourseId;?>" /><?php
                                                }else
                                                {?>
                                                    <input name="regCourses<?php echo $c ?>" id="regCourses<?php echo $c ?>" type="checkbox" disabled/><?php
                                                }?>
                                                <?php echo $cCourseId;?>
                                            </div>

                                            <div style="flex:40%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                                <?php echo $vCourseDesc;?>
                                                <input id="vCourseDesc<?php echo $c ?>" type="hidden" value="<?php echo $vCourseDesc ?>"/>
                                            </div>

                                            <div id="credUnitDiv<?php echo $c ?>" style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                                <?php echo $iCreditUnit; ; $tcr1 += $iCreditUnit;?>        
                                                <input id="credUniInput<?php echo $c ?>" type="hidden" value="<?php echo $iCreditUnit ?>"/>
                                            </div>

                                            <div style="flex:10%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                                <?php echo $cCategory;?>
                                            </div>

                                            <div style="flex:15%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                                <?php echo formatdate($tdate, 'fromdb').' '.substr($tdate, 11,strlen($tdate)-1);?>
                                            </div>

                                            <div style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;"><?php 
                                                echo number_format($Amount, 0, '2', ','); $total_cost = $total_cost  + $Amount;?>
                                                <input id="amntInput<?php echo $c ?>" type="hidden" value="<?php echo $Amount;?>"/>
                                                <input id="itemid<?php echo $c ?>" type="hidden" value="<?php echo $itemid; ?>"/>
                                                
                                                <input id="exam_amntInput<?php echo $c ?>" type="hidden" value="<?php if (isset($exam_Amount)){echo $exam_Amount;}?>"/>
                                                <input id="exam_itemid<?php echo $c ?>" type="hidden" value="<?php if (isset($exam_Amount)){echo $exam_itemid;} ?>"/>
                                            </div>
                                        </div>
                                    </label><?php

                                    
                                    $prev_level = $level;
                                    $prev_semester = $tSemester;
                                }
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
                                </div>
                                <div id="btn_div" style="display:flex; 
                                    flex:100%;
                                    height:auto;
                                    margin-top:10px;">
                                        <button id="submit_btn" type="button" class="login_button" 
                                        onclick="std_id_card.action='print-result'; std_id_card.submit();">Print</button>
                                </div>
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