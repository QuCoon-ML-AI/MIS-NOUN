<?php
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once(BASE_FILE_NAME.'lib_fn.php');

require_once('std_lib_fn.php');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="<?php echo BASE_FILE_NAME;?>js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/rs_request.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/std_m_js.js"></script>
        
        <script language="JavaScript" type="text/javascript">
            function chk_inputs()
            {
                var formdata = new FormData();

                with (rs_cpw)
                {
                    if (semester_reg_loc.value != 1 && begin_level.value >= 100)
                    {
                        caution_inform("Please register for the semester");
                        return false;
                    }
                    
                    /*if (side_menu_no.value == 'change_of_name')
                    {
                        if (!name_req.checked)
                        {
                            caution_inform("Please check the box to confirm request");
                            return false;
                        }
                        formdata.append("name_req", name_req.value);
                    }else*/ if (cancel_op.value == '1')
                    {
                        formdata.append("cancel_op", '1');
                        formdata.append("cancel_op", '1');
                    }else if (side_menu_no.value == 'change_of_level')
                    {
                        if (h_r_level_req.value == '0')
                        {
                            caution_inform("Please select a level");
                            return false;
                        }else if (h_r_semester_req.value == '0')
                        {
                            caution_inform("Please select a semester");
                            return false;
                        }else
                        {
                            formdata.append("level_req", h_r_level_req.value);
                            formdata.append("curent_level", curent_level.value);
                            formdata.append("semester_req", h_r_semester_req.value);
                            formdata.append("curent_semester", curent_semester.value);
                            formdata.append("begin_level", begin_level.value);
                        }
                    }else if (side_menu_no.value == 'change_of_programme')
                    {
                        formdata.append("cFacultyId_req", cFacultyId_req.value);
                        formdata.append("cdeptold_req", cdeptold_req.value);
                        formdata.append("cprogrammeIdold_req", cprogrammeIdold_req.value);
                        
                        formdata.append("curent_program", curent_program.value);
                    }else if (side_menu_no.value == 'change_of_study_centre')
                    {
                        formdata.append("cStudyCenterId", cStudyCenterId.value);
                        formdata.append("curent_sc", curent_sc.value);
                    }else if (side_menu_no.value == 'passport_upload')
                    {
                        if (!passport_req.checked)
                        {
                            caution_inform("Please check the box to confirm request");
                            return false;
                        }
                        formdata.append("passport_req", passport_req.value);
                    }else if (side_menu_no.value == 'transcript')
                    {
                        if (!transcript_req.checked)
                        {
                            caution_inform("Please check the box to confirm request");
                            return false;
                        }else
                        {
                            formdata.append("transcript_req", transcript_req.value);
                        }
                    }
                    
                    if (_('token_supplied').value == 0)
                    {
                        if (conf.value != '1')
                        {
                            _('confirm_box_loc').style.display = 'block';
                            _('confirm_box_loc').style.zIndex = '5';
                            _('smke_screen').style.display = 'block';
                            _('smke_screen').style.zIndex = '4';

                            return;
                        }else if (conf.value == '1' || _('resend_req').value == '1')
                        {
                            formdata.append("request_token", 1);
                        }
                    }else
                    {                        
                        formdata.append("token_supplied", '1');
                        formdata.append("user_token", _('user_token').value)
                    }

                    formdata.append("side_menu_no", side_menu_no.value);
                    formdata.append("ilin", ilin.value);
                    formdata.append("vMatricNo", vMatricNo.value);
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
                }else if (returnedStr  == "Success")
                {
                    inform(returnedStr);

                    _('resend_req').value='';
                    _('user_token').value='';
                    _('token_supplied').value='0';
                }else
                {
                    caution_inform(returnedStr)
                }

                rs_cpw.conf.value == '';
            } 
        </script>

        <link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE_FILE_NAME;?>styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rs_request.css" />
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
                Are you sure ? </div><p>
            <div class="informa_msg_content_caution_cls" style="margin-top:3px; text-align:right">
                <input class="buttons_yes" type="button" value="Yes" 
                    style="width:auto; padding:10px; height:auto;" 
                    onclick="_('smke_screen').style.display = 'none';
                    _('smke_screen').style.zIndex='-1';
                    _('confirm_box_loc').style.display = 'none';
                    _('confirm_box_loc').style.zIndex='-1';
                    rs_cpw.conf.value = '1';
                    chk_inputs();"/>

                <input class="buttons_no" type="button" value="No" 
                    style="width:auto; padding:10px; height:auto; margin-right:10px;" 
                    onclick="_('smke_screen').style.display = 'none';
                    _('smke_screen').style.zIndex='-1';
                    _('confirm_box_loc').style.display = 'none';
                    _('confirm_box_loc').style.zIndex='-1';
                    rs_cpw.cancel_op.value='0';
                    rs_cpw.conf.value = '0';
                    _('resend_req').value='0';
                    _('user_token').value='';
                    _('token_supplied').value='0';"/>
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
                        _('token_supplied').value='0';
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

        $page_title = '';
        if (isset($_REQUEST['side_menu_no']))
        {
            if ($_REQUEST['side_menu_no'] == 'change_of_level')//
            {
                $page_title = 'Request for change of level';
            }else if ($_REQUEST['side_menu_no'] == 'change_of_programme')//
            {
                $page_title = 'Request for change of programme';
            }else if ($_REQUEST['side_menu_no'] == 'change_of_study_centre')//
            {
                $page_title = 'Request for change of study centre';
            }else if ($_REQUEST['side_menu_no'] == 'passport_upload')//
            {
                $page_title = 'Request for reset of passport upload';
            }else if ($_REQUEST['side_menu_no'] == 'transcript')//
            {
                $page_title = 'Request for transcript';
            }
        }
               
        $balance = 0.00;
        
        
        $orgsetins = settns();?>        
            
        <div class="appl_container">
            <div class="appl_left_div" style="z-index:2;">
                <div class="appl_left_child_logo_div"></div>
                <div class="appl_left_child_div" style="margin-top:0px; font-size:1.1em; font-weight:bold">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;  font-size:1.2em"><?php echo $page_title;?></div>
                
                <div class="menu_bg_scrn">
                    <?php require_once ('std_left_side_menu.php');?>                    
                </div>
            </div>
            
            <div class="appl_right_div">
                <div class="appl_left_child_div" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php std_top_menu();?>
                </div>
                
                <div class="appl_left_child_div" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php require_once ('menu_bar_content.php');?>
                </div>

                <div id="menu_sm_scrn">
                    <?php build_menu_right();?>
                </div>

                <form method="post" name="rs_cpw" id="rs_cpw" enctype="multipart/form-data" onsubmit="chk_inputs(); return false;">
                    <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] <> ''){echo $_REQUEST["user_cat"];}?>" />
                    <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"]) && $_REQUEST["ilin"] <> ''){echo $_REQUEST["ilin"];}?>" />
                    <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>" />
                    
                    <input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php echo $vApplicationNo_loc;?>" />
                    
                    <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] <> ''){echo $_REQUEST["top_menu_no"];}?>" />
                    <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> ''){echo $_REQUEST["side_menu_no"];}?>" />

                    <input name="curent_program" id="curent_program" type="hidden" value="<?php echo $cProgrammeId_loc;?>" />
                    <input name="curent_level" id="curent_level" type="hidden" value="<?php echo $iStudy_level_loc;?>" />
                    <input name="begin_level" id="begin_level" type="hidden" value="<?php echo $iBeginLevel_loc;?>" />
                    
                    <input name="curent_semester" id="curent_semester" type="hidden" value="<?php echo $tSemester_loc;?>" />
                    <input name="curent_sc" id="curent_sc" type="hidden" value="<?php echo $cStudyCenterId_loc;?>" />
                    <input name="semester_reg_loc" id="semester_reg_loc" type="hidden" value="<?php echo $semester_reg_loc;?>" />
                    
                    <input name="cancel_op" id="cancel_op" type="hidden" />
                    <input name="conf" id="conf" type="hidden" value="0" />

                    <div class="appl_left_child_div_child calendar_grid">
                        <div class="inlin_message_color" style="flex:5%; padding-left:4px; height:60px; background-color: #ffffff"></div>
                        <div class="inlin_message_color" style="flex:95%; padding-right:4px; height:60px;line-height:1.6">
                            If you have placed a request this semster, there will be no option displayed for you to select<br>
                            If you have placed a request and it is yet to be granted, the 'Cancel' button will be displayed in the event you wish to cancel the request.
                        </div>
                    </div><?php

                    $can_request = 0;
                    
                    if (isset($_REQUEST['side_menu_no']) && $_REQUEST['side_menu_no'] == 'change_of_level')//
                    {   
                        $stmt = $mysqli->prepare("SELECT req_granted 
                        FROM student_request_log_1
                        WHERE vMatricNo = ?
                        AND level_req = '1'
                        AND req_canceled = '0'
                        AND level_req_date >= '$semester_begin_date'");
				        $stmt->bind_param("s", $vMatricNo);
                        $stmt->execute();
                        $stmt->store_result();
                        $can_request = $stmt->num_rows;
                        $stmt->bind_result($req_granted);
                        $stmt->fetch();
                        if ($can_request == 0)
                        {?>
                            <div class="appl_left_child_div" style="width:98%; margin:auto; max-height:95%; margin-top:20px; overflow:auto; background-color:#eff5f0">
                                <div class="appl_left_child_div_child calendar_grid">
                                    <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                        1
                                    </div>
                                    <div style="flex:95%; padding-left:4px; height:48px; background-color: #ffffff">
                                        <label class="chkbox_container" style="margin-top:7px">
                                            <input name="r_level_req" id="r_level_req1" type="radio"
                                            onclick="h_r_level_req.value='100'">
                                            <span class="checkmark radio_checkmark"></span><div style="line-height:1.8;">100L</div>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="appl_left_child_div_child calendar_grid">
                                    <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                        2
                                    </div>
                                    <div style="flex:95%; padding-left:4px; height:48px; background-color: #ffffff">
                                        <label class="chkbox_container" style="margin-top:7px">
                                            <input name="r_level_req" id="r_level_req2" type="radio"
                                            onclick="h_r_level_req.value='200'">
                                            <span class="checkmark radio_checkmark"></span><div style="line-height:1.8;">200L</div>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="appl_left_child_div_child calendar_grid">
                                    <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                        3
                                    </div>
                                    <div style="flex:95%; padding-left:4px; height:48px; background-color: #ffffff">
                                        <label class="chkbox_container" style="margin-top:7px">
                                            <input name="r_level_req" id="r_level_req3" type="radio"
                                            onclick="h_r_level_req.value='300'">
                                            <span class="checkmark radio_checkmark"></span><div style="line-height:1.8;">300L</div>
                                        </label>
                                    </div>
                                    <input name="h_r_level_req" id="h_r_level_req" type="hidden" value="0" />
                                </div>

                                
                                
                                <div class="appl_left_child_div_child calendar_grid" style="margin-top:20px">
                                    <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                        4
                                    </div>
                                    <div style="flex:95%; padding-left:4px; height:48px; background-color: #ffffff">
                                        <label class="chkbox_container" style="margin-top:7px">
                                            <input name="r_semester_req" id="r_semester_req1" type="radio"
                                            onclick="h_r_semester_req.value='1'">
                                            <span class="checkmark radio_checkmark"></span><div style="line-height:1.8;">First semester</div>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="appl_left_child_div_child calendar_grid">
                                    <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                        5
                                    </div>
                                    <div style="flex:95%; padding-left:4px; height:48px; background-color: #ffffff">
                                        <label class="chkbox_container" style="margin-top:7px">
                                            <input name="r_semester_req" id="r_semester_req2" type="radio"
                                            onclick="h_r_semester_req.value='2'">
                                            <span class="checkmark radio_checkmark"></span><div style="line-height:1.8;">Second semester</div>
                                        </label>
                                    </div>
                                    <input name="h_r_semester_req" id="h_r_semester_req" type="hidden" value="0" />
                                </div>
                            </div><?php
                        }
                    }else if (isset($_REQUEST['side_menu_no']) && $_REQUEST['side_menu_no'] == 'change_of_programme')//
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
                            $sql = "select s.cdeptId, p.cProgrammeId,p.vProgrammeDesc,o.vObtQualTitle 
                            from programme p, obtainablequal o, depts s, faculty t
                            where p.cObtQualId = o.cObtQualId 
                            and s.cdeptId = p.cdeptId
                            and s.cFacultyId = t.cFacultyId
                            and p.cDelFlag = s.cDelFlag
                            and p.cDelFlag = t.cDelFlag
                            and p.cDelFlag = 'N'
                            order by s.cdeptId, p.cProgrammeId";
                            $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                            while ($rs = mysqli_fetch_array($rssql))
                            {?>
                                <option value="<?php echo $rs['cdeptId']. $rs['cProgrammeId']?>"><?php echo $rs['vObtQualTitle'].' '.$rs['vProgrammeDesc']; ?></option><?php
                            }
                            mysqli_close(link_connect_db());?>
                        </select>
                        
                        <div class="appl_left_child_div" style="width:98%; margin:auto; max-height:95%; margin-top:10px; overflow:auto; background-color:#eff5f0">
                            <div class="appl_left_child_div_child calendar_grid">
                                <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                    1
                                </div>
                                <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                    Faculty
                                </div>
                                <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                    <select name="cFacultyId_req" id="cFacultyId_req" style="height:100%;" required
                                        onchange="_('cdeptold_req').length = 0;
                                            _('cdeptold_req').options[_('cdeptold_req').options.length] = new Option('Select a department', '');
                                                    
                                            _('cprogrammeIdold_req').length = 0;
                                            _('cprogrammeIdold_req').options[_('cprogrammeIdold_req').options.length] = new Option('', '');
                                        
                                            update_cat_country('cFacultyId_req', 'cdeptId_readup', 'cdeptold_req', 'cprogrammeIdold_req');"><?php
                                            get_faculties($_REQUEST["cFacultyId_req"]);?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child calendar_grid">
                                <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                    2
                                </div>
                                <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                    Department
                                </div>
                                <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                <select name="cdeptold_req" id="cdeptold_req" style="height:100%;" required
                                        
                                        onchange="_('cprogrammeIdold_req').length = 0;
                                        _('cprogrammeIdold_req').options[_('cprogrammeIdold_req').options.length] = new Option('Select a programme', '');

                                        update_cat_country('cdeptold_req', 'cprogrammeId_readup', 'cprogrammeIdold_req', 'cprogrammeIdold_req');"><?php

                                        if (isset($_REQUEST["cFacultyId_req"]) && $_REQUEST["cFacultyId_req"] <> '')
                                        {
                                            $stmt = $mysqli->prepare("select cdeptId, concat(cdeptId,' ',vdeptDesc) vdeptDesc from depts where cFacultyId = ? order by vdeptDesc");
                                            $stmt->bind_param("s", $_REQUEST["cFacultyId_req"]);
                                            $stmt->execute();
                                            $stmt->store_result();
                                            $stmt->bind_result($cdeptId1, $vdeptDesc1);
                                            
                                            while ($stmt->fetch())
                                            {?>
                                                <option value="<?php echo $cdeptId1; ?>"<?php if (isset($_REQUEST['cdeptold_req']) && $cdeptId1 == $_REQUEST['cdeptold_req']){echo ' selected';}?>>
                                                    <?php echo $vdeptDesc1;?>
                                                </option><?php
                                            }
                                            $stmt->close();
                                        }?>
                                    </select>
                                </div>
                                <input name="h_r_level_req" id="h_r_level_req" type="hidden" value="0" />
                            </div>
                            
                            <div class="appl_left_child_div_child calendar_grid">
                                <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                    3
                                </div>
                                <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                    Programme
                                </div>
                                <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                    <select name="cprogrammeIdold_req" id="cprogrammeIdold_req" style="height:100%;" required>
                                        <option value="" selected="selected"></option><?php                             
                                        if (isset($_REQUEST['cdeptold_req']))
                                        {
                                            $stmt = $mysqli->prepare("select p.cProgrammeId, p.vProgrammeDesc, o.vObtQualTitle 
                                            from programme p, obtainablequal o, depts s
                                            where p.cObtQualId = o.cObtQualId 
                                            and s.cdeptId = p.cdeptId
                                            and p.cDelFlag = s.cDelFlag
                                            and p.cDelFlag = 'N'
                                            and p.cdeptId = ?
                                            order by s.cdeptId, p.cProgrammeId");
                                            $stmt->bind_param("s", $_REQUEST['cdeptold_req']);
                                            $stmt->execute();
                                            $stmt->store_result();
                                            $stmt->bind_result($cProgrammeId, $vProgrammeDesc, $vObtQualTitle);

                                            $notice_written = 0;
                                            
                                            while ($stmt->fetch())
                                            {
                                                $vProgrammeDesc_01 = $vProgrammeDesc;
                                                if (!is_bool(strpos($vProgrammeDesc,"(d)")))
                                                {
                                                    $vProgrammeDesc_01 = substr($vProgrammeDesc, 0, strlen($vProgrammeDesc)-4);
                                                }

                                                if ($vObtQualTitle == 'Ph.D.,')
                                                {
                                                    if ($notice_written == 0)
                                                    {?>
                                                        <option value="">M. Phil. and Ph.D. candidates are screened addionally via interview</option><?php
                                                        $notice_written = 1;
                                                    }
                                                }else
                                                {?>
                                                    <option value="<?php echo $cProgrammeId?>"<?php if (isset($_REQUEST['cprogrammeIdold_req']) && $cProgrammeId == $_REQUEST['cprogrammeIdold_req']){echo ' selected';}?>><?php echo $vObtQualTitle.' '.$vProgrammeDesc_01; ?></option><?php
                                                }
                                            }
                                            $stmt->close();
                                        }?>
                                    </select>
                                </div>
                                <input name="h_r_level_req" id="h_r_level_req" type="hidden" value="0" />
                            </div>
                        </div><?php
                    }else if (isset($_REQUEST['side_menu_no']) && $_REQUEST['side_menu_no'] == 'change_of_study_centre')
                    {
                        $stmt = $mysqli->prepare("SELECT req_granted 
                        FROM student_request_log_1
                        WHERE vMatricNo = ?
                        AND centre_req = '1'
                        AND req_canceled = '0'
                        AND centre_req_date >= '$semester_begin_date'");
				        $stmt->bind_param("s", $vMatricNo);
                        $stmt->execute();
                        $stmt->store_result();
                        $can_request = $stmt->num_rows;
                        $stmt->bind_result($req_granted);
                        $stmt->fetch();
                        if ($can_request == 0)
                        {?>
                            <div class="appl_left_child_div" style="width:98%; margin:auto; max-height:95%; margin-top:10px; overflow:auto; background-color:#eff5f0">
                                <div class="appl_left_child_div_child calendar_grid">
                                    <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                        1
                                    </div>
                                    <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                        Study centre
                                    </div>
                                    <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff"><?php
                                        $sql = "SELECT cStudyCenterId, vCityName FROM studycenter where cDelFlag = 'N' ORDER BY vCityName";
                                        $rsql=mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));?>
                                        <select name="cStudyCenterId" id="cStudyCenterId" style="height:100%;" required>
                                            <option value="" selected>Select a study centre</option><?php
                                            $cnt = 0;
                                            while ($table= mysqli_fetch_array($rsql))
                                            {
                                                if ($cStudyCenterId_loc == $table['cStudyCenterId'])
                                                {
                                                    continue;
                                                }
                                                $cnt++;
                                                if ($cnt%5 == 0)
                                                {?>
                                                    <option disabled></option><?php
                                                }?>
                                                <option value="<?php echo $table['cStudyCenterId']; ?>"><?php echo $table['vCityName'];?></option><?php
                                            }
                                            mysqli_close(link_connect_db());?>
                                        </select>
                                    </div>
                                </div>
                            </div><?php
                        }
                    }else if (isset($_REQUEST['side_menu_no']) && $_REQUEST['side_menu_no'] == 'passport_upload')//
                    {?>
                        <div class="appl_left_child_div" style="width:98%; margin:auto; max-height:95%; margin-top:10px; overflow:auto; background-color:#eff5f0">
                            <div class="appl_left_child_div_child calendar_grid">
                                <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                    1
                                </div>
                                <div style="flex:95%; padding-left:4px; height:48px; background-color: #ffffff">
                                    <label class="chkbox_container" style="margin-top:7px" for="passport_req">
                                        <input name="passport_req" id="passport_req" type="checkbox" value="1">
                                        <span class="checkmark box_checkmark"></span><div style="line-height:1.8;">Reset passport upload</div>
                                    </label>
                                </div>
                            </div>
                        </div><?php
                    }else if (isset($_REQUEST['side_menu_no']) && $_REQUEST['side_menu_no'] == 'transcript')//
                    {?>
                        <div class="appl_left_child_div" style="width:98%; margin:auto; max-height:95%; margin-top:10px; overflow:auto; background-color:#eff5f0">
                            <div class="appl_left_child_div_child calendar_grid">
                                <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                    1
                                </div>
                                <div style="flex:95%; padding-left:4px; height:48px; background-color: #ffffff">
                                    <label class="chkbox_container" style="margin-top:7px" for="transcript_req">
                                        <input name="transcript_req" id="transcript_req" type="checkbox" value="1">
                                        <span class="checkmark box_checkmark"></span><div style="line-height:1.8;">Request transcript</div>
                                    </label>
                                </div>
                            </div>
                        </div><?php
                    }?>
                         
                    <div id="btn_div" style="display:flex; 
                        flex:100%;
                        height:auto; 
                        gap:15px;
                        margin-top:20px;"><?php
                    
                            $name_req = '';
                            $prog_req = '';
                            $prog_req_date= '';
                            $centre_req = '';
                            $centre_req_date = '';
                            $level_req = '';
                            $level_req_date = '';
                            $passport = '';
                            $passport_date = '';

                            $transcript_req_date = '';
                            $transcript_req = '';
                            $req_canceled = '';

                            $sub_qry = '';


                            
                            if (isset($_REQUEST['side_menu_no']))
                            {
                                if ($_REQUEST["side_menu_no"] == 'change_of_level')
                                {
                                    $sub_qry = " AND level_req = '1' AND level_req_date >= '".$semester_begin_date."' AND level_req_date <= '".$semester_end_date."'";
                                }else if ($_REQUEST["side_menu_no"] == 'change_of_programme')
                                {
                                    $sub_qry = " AND prog_req = '1' AND prog_req_date >= '".$semester_begin_date."' AND prog_req_date <= '".$semester_end_date."'";
                                }else if ($_REQUEST["side_menu_no"] == 'change_of_study_centre')
                                {
                                    $sub_qry = " AND centre_req = '1' AND centre_req_date >= '".$semester_begin_date."' AND centre_req_date <= '".$semester_end_date."'";
                                }else if ($_REQUEST["side_menu_no"] == 'passport_upload')
                                {
                                    $sub_qry = " AND passport = '1' AND passport_date >= '".$semester_begin_date."' AND passport_date <= '".$semester_end_date."'";
                                }else if ($_REQUEST["side_menu_no"] == 'transcript')
                                {
                                    $sub_qry = " AND transcript_req = '1' AND transcript_req_date >= '".$semester_begin_date."' AND transcript_req_date <= '".$semester_end_date."'";
                                }
                            }

                            $stmt = $mysqli->prepare("SELECT name_req, prog_req, prog_req_date, centre_req, centre_req_date, level_req, level_req_date, passport, passport_date, transcript_req, transcript_req_date, req_canceled
                            FROM student_request_log_1 
                            WHERE vMatricNo = ? 
                            AND req_granted = '0'
                            $sub_qry");
                            $stmt->bind_param("s", $_REQUEST['vMatricNo']);
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($name_req, $prog_req, $prog_req_date, $centre_req, $centre_req_date, $level_req, $level_req_date, $passport, $passport_date, $transcript_req, $transcript_req_date, $req_canceled);
                            $stmt->fetch();
                            $stmt->close();

                            $can_cancel = 0;

                            if (isset($_REQUEST['side_menu_no']))
                            {
                                if ($_REQUEST["side_menu_no"] == 'change_of_level' && $level_req == '1')
                                {
                                    $can_cancel = 1;
                                }else if ($_REQUEST["side_menu_no"] == 'change_of_programme' && $prog_req == '1')
                                {
                                    $can_cancel = 1;
                                }else if ($_REQUEST["side_menu_no"] == 'change_of_study_centre' && $centre_req == '1')
                                {
                                    $can_cancel = 1;
                                }else if ($_REQUEST["side_menu_no"] == 'passport_upload' && $passport == '1')
                                {
                                    $can_cancel = 1;
                                }else if ($_REQUEST["side_menu_no"] == 'transcript' && $transcript_req == '1')
                                {
                                    $can_cancel = 1;
                                }
                            }
                            
                            if ($can_cancel == 1 && $req_granted == '0')
                            {?>
                                <button type="button" class="rec_pwd_button" style="color:#eb0c27"
                                    onclick="_('smke_screen').style.display = 'block';
                                    _('smke_screen').style.zIndex='3';
                                    _('confirm_box_loc').style.display = 'block';
                                    _('confirm_box_loc').style.zIndex='4';
                                    rs_cpw.cancel_op.value='1';">Cancel request</button><?php
                            }
                            
                            
                            if ($can_request == 0)
                            {?>
                                <button type="submit" class="login_button" onclick="cancel_op.value='0'">Submit</button><?php
                            }?>
                    </div>
                </form>
            </div>

            <div id="menu_bs_scrn" class="appl_far_right_div" style="z-index:2;">
                <?php build_menu_right($balance);?>
            </div>
        </div>
	</body>
</html>