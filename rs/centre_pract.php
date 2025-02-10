<?php
require_once('good_entry.php');
// Date in the past
if (!isset($_REQUEST['user_cat']))
{?>
    <div style="font-family:Verdana, Arial, Helvetica, sans-serif; 
    margin:auto; 
    text-align:center;
	font-size: 0.78em;"> Follow <a href="../" style="text-decoration:none;">here</a></div><?php
    exit;
}

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
		<link rel="icon" type="image/ico" href="../appl/img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="../appl/js_file_1.js"></script>
		
		<script language="JavaScript" type="text/javascript" src="./bamboo/std_m_js.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="../appl/styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rs_cpw.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rs_side_menu.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>

        <script language="JavaScript" type="text/javascript">
            function chk_inputs()
            { 
                with (rs_pcentre)
                {
                    if (windwo_s.value != 1)
                    {
                        caution_inform("Select windows per course");
                        return false;
                    } 
                    
                    var formdata = new FormData();
                    
                    formdata.append("ilin", ilin.value);
                    formdata.append("vMatricNo", vMatricNo.value);

                    var count_picked_course = 0;

                    for (var i = 1; i <= _("course_ccount").value; i++)
                    {
                        for (var j = 1; j <= 5; j++)
                        {
                            radio_name = 'row'+i+'col'+j;
                            if (_(radio_name) && _(radio_name).checked)
                            {
                                //alert(_(radio_name).value)
                                count_picked_course++
                                formdata.append(radio_name, _(radio_name).value);
                            }
                        }
                    }

                    if (count_picked_course < _("course_ccount").value)
                    {
                        caution_inform("You have left out one or more courses");
                        return false;                        
                    }
                    
                    formdata.append("p_study_center", p_study_center.value);
                    formdata.append("course_ccount", course_ccount.value);
                    formdata.append("cAcademicDesc", cAcademicDesc_loc.value);
                    formdata.append("tSemester", tSemester_loc.value);

                    /*formdata.append("token_req", token_req.value);

                    if (token_req.value == '1')
                    {
                        formdata.append("user_token", pwd_token.value);
                    }*/
                }
                
                opr_prep(ajax = new XMLHttpRequest(),formdata);
            }

            function opr_prep(ajax,formdata)
            {
                ajax.upload.addEventListener("progress", progressHandler, false);
                ajax.addEventListener("load", completeHandler, false);
                ajax.addEventListener("error", errorHandler, false);
                ajax.addEventListener("abort", abortHandler, false);
                
                ajax.open("POST", "opr_centre_p.php");
                
                ajax.send(formdata);
            }


            function completeHandler(event)
            {
                on_error('0');
                on_abort('0');
                in_progress('0');

                var returnedStr = event.target.responseText;
                
                if (returnedStr  == "Success")
                {
                    inform(returnedStr);
                    _("prn_p_a_slip").style.display = 'block';
                }/*else if (returnedStr == "Token sent")
                {
                    rs_cpw.token_req.value = '1';
                    _('token_box').style.display = 'block';
                }*/else
                {
                    caution_inform(returnedStr)
                }

                return false;
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
        </script>
	</head>
	<body><?php
	    $mysqli = link_connect_db();

        $orgsetins = settns();
        
        require_once("../appl/feedback_mesages.php");
        
        require_once("std_detail_pg1.php");
        require_once("forms.php");
        
        require_once("./set_scheduled_dates.php");
                    
        $balance = 0.00;
        
        $centre_a = 100;
        $centre_b = 100;
        $centre_c = 100;
        $centre_d = 100;
        $centre_e = 100;
        
        $arr_pc = array(array());
        $cnt = 0;
        $stmt = $mysqli->prepare("SELECT cCentreId, count(DISTINCT vMatricNo) 'count' FROM pract_centre GROUP BY cCentreId");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cCentreId, $cnount);
        
        while($stmt->fetch())
        {
            $cnt++;
            $arr_pc[$cnt]['cCentreId'] = $cCentreId;
            $arr_pc[$cnt]['count'] = $cnount;
        }

        
        $arr_std_selections = array(array(array()));
        $stmt = $mysqli->prepare("SELECT cCourseId, cCentreId, cwindow
        FROM pract_centre
        WHERE vMatricNo = ?");
        $stmt->bind_param("s", $_REQUEST['vMatricNo']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cCourseId, $cCentreId, $cwindow);

        $cnt = 0;
        while ($stmt->fetch())
        {
            $cnt++;
            $arr_std_selections[$cnt]['cCourseId'] = $cCourseId;
            $arr_std_selections[$cnt]['cCentreId'] = $cCentreId;
            $arr_std_selections[$cnt]['cwindow'] = $cwindow;
        }
        $stmt->close()?>        
            
        <div class="appl_container">
            <div class="appl_left_div" style="z-index:2;">
                <div class="appl_left_child_logo_div"></div>
                <div class="appl_left_child_div" style="margin-top:0px; font-size:1.1em; font-weight:bold">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;  font-size:1.2em">Choose centre for practical sessions</div>
                
                <div class="for_computer_screen">
                    <?php require_once ('std_left_side_menu.php');
                    //build_menu($sidemenu);?>                    
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
                <div class="appl_left_child_div" style="width:98%; margin:auto; height:5%; margin-top:10px; overflow:scroll; overflow-x: hidden; background-color:#eff5f0">
                    <div class="appl_left_child_div_child calendar_grid">
                        <div style="flex:3%; height:35px; background-color: #ffffff; text-align:right; padding-right:1%">
                            Sno
                        </div>
                        <div style="flex:24%; height:35px; background-color: #ffffff; text-indent:5px;">
                            Check/Uncheck
                        </div>
                        <div style="flex:24%; height:35px; background-color: #ffffff; text-indent:5px; text-align:left">
                            State
                        </div>
                        <div style="flex:24%; height:35px; background-color: #ffffff; text-indent:5px; text-align:left">
                            Centre name
                        </div>
                        <div style="flex:23%; height:35px; background-color: #ffffff; text-align:right; padding-right:1%">
                            Available seats
                        </div>
                    </div>
                </div>

                <div class="appl_left_child_div" style="width:98%; margin:auto; max-height:90%; margin-top:10px; overflow:auto; background-color:#eff5f0">
                    <form action="" method="post" name="rs_pcentre" id="rs_pcentre" enctype="multipart/form-data" onsubmit="chk_inputs(); return false">
                        <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] <> ''){echo $_REQUEST["user_cat"];}?>" />
                        <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"]) && $_REQUEST["ilin"] <> ''){echo $_REQUEST["ilin"];}?>" />
                        <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>" />
                        
                        <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] <> ''){echo $_REQUEST["top_menu_no"];}?>" />
                        <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> ''){echo $_REQUEST["side_menu_no"];}?>" />
                        <input name="windwo_s" id="windwo_s" type="hidden" value="0" />

                        <input name="token_req" id="token_req" type="hidden" value="0" />
                        
                        <input name="tSemester_loc" id="tSemester_loc" type="hidden" value="<?php echo $tSemester_loc;?>" />
                        <input name="cAcademicDesc_loc" id="cAcademicDesc_loc" type="hidden" value="<?php echo $orgsetins['cAcademicDesc'];?>" />
                        
                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:100%; text-indent:4px; height:38px;">
                                Select a Centre
                            </div>
                        </div><?php

                        $sql = "SELECT cStudyCenterId, vCityName, vStateName, p_center FROM studycenter a, ng_state b 
                        WHERE a.cStateId = b.cStateId AND cStudyCenterId IN ('LA01','LA03','LA11','OG01','OS02','FC01','BA01','KN01','ED01','EN01','AK01') AND a.cDelFlag = 'N' ORDER BY a.cStateId, vCityName";
                        $rsql=mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));
                        $cStudyCenterId = '';
                        $C = 0;
                        while ($table= mysqli_fetch_array($rsql))
                        {?>
                            <div class="appl_left_child_div_child calendar_grid">
                                <div style="flex:3%; height:35px; background-color: #ffffff; text-align:right; padding-right:1%">
                                    <?php echo ++$C;?>
                                </div>
                                <div style="flex:24%; text-indent:4px; height:35px; background-color: #ffffff; text-indent:5px;">
                                    <label class="chkbox_container" style="margin-top:4px; margin-left:5px;">
                                        <input type="radio" name="p_study_center" id="p_study_center<?php echo $C;?>"
                                        value="<?php echo $table[0];?>"
                                        <?php                                    
                                        for ($b = 1; $b <= count($arr_std_selections); $b++)
                                        {
                                            if (isset($arr_std_selections[$b]['cCentreId']) && $arr_std_selections[$b]['cCentreId'] == $table[0])
                                            {
                                                echo 'checked';
                                                break;
                                            }
                                        }?>>
                                        <span class="checkmark radio_checkmark"></span><div style="line-height:1.8;"></div>
                                    </label>
                                </div>
                                <div style="flex:24%; height:35px; background-color: #ffffff; text-indent:5px; text-align:left">
                                    <?php echo $table['vStateName'];?>
                                </div>
                                <div style="flex:24%; height:35px; background-color: #ffffff; text-indent:5px; text-align:left">
                                    <?php echo $table['vCityName'];?>
                                </div>
                                <div style="flex:23%; height:35px; background-color: #ffffff; text-indent:5px; text-align:right; padding-right:1%">
                                    <?php 
                                    $center_f = 0;
                                    
                                    for ($b = 1; $b <= count($arr_pc); $b++)
                                    {
                                        if (isset($arr_pc[$b]['cCentreId']) && $arr_pc[$b]['cCentreId'] == $table[0])
                                        {
                                            $center_f = 1;
                                            echo ($table['p_center'] - $arr_pc[$b]['count']);
                                            break;
                                        }
                                    }
                                    
                                    if ($center_f == 0)
                                    {
                                        echo $table['p_center'];
                                    }?>
                                </div>
                            </div><?php
                        }
                        mysqli_close(link_connect_db());?>
                        
                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:100%; text-indent:4px; height:38px;">
                                Select respective windows of your choice for each of the listed courses
                            </div>
                        </div>
                        
                        <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                            <div style="flex:40%; height:35px;"></div>
                            <div style="flex:60%; height:35px; text-align:center">
                                Windows
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                            <div style="flex:4.5%; height:35px; background-color: #ffffff; text-align:right; padding-right:0.5%">
                                Sno
                            </div>
                            <div style="flex:35%; text-indent:4px; height:35px; background-color: #ffffff; text-align:left">
                                Course
                            </div>
                            <!-- <div style="flex:12%; text-indent:4px; height:35px; background-color: #ffffff; text-align:left">
                                26th August - 7th Sept 
                            </div> -->
                            <div style="flex:15%; text-indent:4px; height:35px; background-color: #ffffff; text-align:left">
                                9th sept - 21st Sept
                            </div>
                            <div style="flex:15%; text-indent:4px; height:35px; background-color: #ffffff; text-align:left">
                                23rd Sept - 5th Oct
                            </div>
                            <div style="flex:15%; text-indent:4px; height:35px; background-color: #ffffff; text-align:left">
                                7th Oct - 19th Oct
                            </div>
                            <div style="flex:15%; text-indent:4px; height:35px; background-color: #ffffff; text-align:left">
                                21st Oct - 2nd Nov
                            </div>
                        </div><?php

                        $reg_courses_arr = array(array());
                        $cnt = 0;

                        $stmt = $mysqli->prepare("SELECT cCourseId, vCourseDesc
                        FROM coursereg_arch_20242025
                        WHERE ancilary_type = 'Laboratory'
                        AND vMatricNo = ?
                        AND tdate >= '$semester_begin_date'
                        ORDER BY cCourseId");

                        $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($cCourseId, $vCourseDesc);
                        while($stmt->fetch())
                        {
                            $cnt++;
                            $reg_courses_arr[$cnt]['cCourseId'] = $cCourseId;
                            $reg_courses_arr[$cnt]['vCourseDesc'] = $vCourseDesc;

                            //echo $reg_courses_arr[$cnt]['cCourseId'].', '.$reg_courses_arr[$cnt]['vCourseDesc'].'<br>';
                        }

                        //if (count($reg_courses_arr) == 0)
                        if (!isset($reg_courses_arr[1]['cCourseId']))
                        {?>
                            <div class="appl_left_child_div_child calendar_grid">
                                <div class="inlin_message_color" style="flex:5%; padding-left:4px; height:40px; background-color: #ffffff"></div>
                                <div class="inlin_message_color" style="flex:95%; padding-right:4px; height:40px;">
                                    You need to register courses for the semester
                                </div>
                            </div><?php
                        }
                        

                        $win_courses_arr = array(array());
                        $cnt = 0;

                        $stmt = $mysqli->prepare("SELECT cCourseId, cwindow FROM pract_course_win ORDER BY cCourseId");
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($cCourseId_w, $cwindow);
                        while($stmt->fetch())
                        {
                            $cnt++;
                            $win_courses_arr[$cnt]['cCourseId'] = $cCourseId_w;
                            $win_courses_arr[$cnt]['cwindow'] = $cwindow;

                            //echo $win_courses_arr[$cnt]['cCourseId'].', '.$win_courses_arr[$cnt]['cwindow'].'<br>';
                        }

                        $sql = "SELECT DISTINCT cCourseId FROM pract_course_win ORDER BY cCourseId";
                        $rsql=mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));
                        $cStudyCenterId = '';
                        $C = 0;

                        $rad_cnt = 0;
                        $require_cond_placed = 0;
                        while ($table = mysqli_fetch_array($rsql))
                        {
                            $vCourseDesc = '';
                            for ($b = 1; $b <= count($reg_courses_arr); $b++)
                            {
                                if (isset($reg_courses_arr[$b]['cCourseId']) && $reg_courses_arr[$b]['cCourseId'] == $table[0])
                                {
                                    $vCourseDesc = $reg_courses_arr[$b]['vCourseDesc'];
                                    break;
                                }
                            }
                                
                            if ($vCourseDesc == '')
                            {
                                continue;
                            }
                            
                            $rad_cnt++;?>
                            <div class="appl_left_child_div_child calendar_grid">
                                <div style="flex:4.5%; height:35px; background-color: #ffffff; ; text-align:right; padding-right:0.5%">
                                    <?php echo ++$C;?>
                                </div>
                                <div style="flex:35%; text-indent:4px; height:35px; background-color: #ffffff">
                                    <?php echo $table[0].' '.$vCourseDesc;?>
                                </div>
                                <!--<div style="flex:12%; height:35px; background-color: #ffffff; text-align:center"><?php 
                                    /*for ($b = 1; $b <= count($win_courses_arr); $b++)
                                    {
                                        if (isset($win_courses_arr[$b]['cCourseId']) && $win_courses_arr[$b]['cCourseId'] == $table[0] && $win_courses_arr[$b]['cwindow'] == 'a')
                                        {?>
                                            <label class="chkbox_container" style="margin-top:4px; margin-left:5px;">
                                                <input type="radio" name="<?php echo 'row'.$rad_cnt;?>" id="<?php echo 'row'.$rad_cnt.'col1';?>" 
                                                onclick="if (this.checked)
                                                {
                                                    _('windwo_s').value = 1;
                                                }"
                                                value="<?php echo $table[0].'a';?>"<?php                                     

                                                for ($f = 1; $f <= count($arr_std_selections); $f++)
                                                {
                                                    if ($arr_std_selections[$f]['cCourseId'] == $table[0] && $arr_std_selections[$f]['cwindow'] == 'a')
                                                    {
                                                        echo 'checked';
                                                        break;
                                                    }
                                                }?>>
                                                <span class="checkmark radio_checkmark"></span><div style="line-height:1.8;"></div>
                                            </label><?php
                                            break;
                                        }
                                    }*/?>
                                </div>-->
                                <div style="flex:15%; height:35px; background-color: #ffffff; text-align:center">
                                    <?php for ($b = 1; $b <= count($win_courses_arr); $b++)
                                    {
                                        if (isset($win_courses_arr[$b]['cCourseId']) && $win_courses_arr[$b]['cCourseId'] == $table[0] && $win_courses_arr[$b]['cwindow'] == 'b')
                                        {?>
                                            <label class="chkbox_container" style="margin-top:4px; margin-left:5px;">
                                                <input type="radio" name="<?php echo 'row'.$rad_cnt;?>" id="<?php echo 'row'.$rad_cnt.'col2';?>"
                                                onclick="if (this.checked)
                                                {
                                                    _('windwo_s').value = 1;
                                                }"
                                                value="<?php echo $table[0].'b';?>"<?php                                     

                                                for ($f = 1; $f <= count($arr_std_selections); $f++)
                                                {
                                                    if (isset($arr_std_selections[$f]['cCourseId']) && $arr_std_selections[$f]['cCourseId'] == $table[0] && $arr_std_selections[$f]['cwindow'] == 'b')
                                                    {
                                                        echo 'checked';
                                                        break;
                                                    }
                                                }?>>
                                                <span class="checkmark radio_checkmark"></span><div style="line-height:1.8;"></div>
                                            </label><?php
                                            break;
                                        }
                                    }?>
                                </div>
                                <div style="flex:15%; height:35px; background-color: #ffffff; text-align:center">
                                    <?php for ($b = 1; $b <= count($win_courses_arr); $b++)
                                    {
                                        if (isset($win_courses_arr[$b]['cCourseId']) && $win_courses_arr[$b]['cCourseId'] == $table[0] && $win_courses_arr[$b]['cwindow'] == 'c')
                                        {?>
                                            <label class="chkbox_container" style="margin-top:4px; margin-left:5px;">
                                                <input type="radio" name="<?php echo 'row'.$rad_cnt;?>" id="<?php echo 'row'.$rad_cnt.'col3';?>"
                                                onclick="if (this.checked)
                                                {
                                                    _('windwo_s').value = 1;
                                                }"
                                                value="<?php echo $table[0].'c';?>"<?php                                     

                                                for ($f = 1; $f <= count($arr_std_selections); $f++)
                                                {
                                                    if (isset($arr_std_selections[$f]['cCourseId']) && $arr_std_selections[$f]['cCourseId'] == $table[0] && $arr_std_selections[$f]['cwindow'] == 'c')
                                                    {
                                                        echo 'checked';
                                                        break;
                                                    }
                                                }?>>
                                                <span class="checkmark radio_checkmark"></span><div style="line-height:1.8;"></div>
                                            </label><?php
                                            break;
                                        }
                                    }?>
                                </div>
                                <div style="flex:15%; height:35px; background-color: #ffffff; text-align:center">
                                    <?php for ($b = 1; $b <= count($win_courses_arr); $b++)
                                    {
                                        if (isset($win_courses_arr[$b]['cCourseId']) && $win_courses_arr[$b]['cCourseId'] == $table[0] && $win_courses_arr[$b]['cwindow'] == 'd')
                                        {?>
                                            <label class="chkbox_container" style="margin-top:4px; margin-left:5px;">
                                                <input type="radio" name="<?php echo 'row'.$rad_cnt;?>" id="<?php echo 'row'.$rad_cnt.'col4';?>"
                                                onclick="if (this.checked)
                                                {
                                                    _('windwo_s').value = 1;
                                                }"
                                                value="<?php echo $table[0].'d';?>"<?php                                     

                                                for ($f = 1; $f <= count($arr_std_selections); $f++)
                                                {
                                                    if (isset($arr_std_selections[$f]['cCourseId']) && $arr_std_selections[$f]['cCourseId'] == $table[0] && $arr_std_selections[$f]['cwindow'] == 'd')
                                                    {
                                                        echo 'checked';
                                                        break;
                                                    }
                                                }?>>
                                                <span class="checkmark radio_checkmark"></span><div style="line-height:1.8;"></div>
                                            </label><?php
                                            break;
                                        }
                                    }?>
                                </div>
                                <div style="flex:15%; height:35px; background-color: #ffffff; text-align:center">
                                    <?php for ($b = 1; $b <= count($win_courses_arr); $b++)
                                    {
                                        if (isset($win_courses_arr[$b]['cCourseId']) && $win_courses_arr[$b]['cCourseId'] == $table[0] && $win_courses_arr[$b]['cwindow'] == 'e')
                                        {?>
                                            <label class="chkbox_container" style="margin-top:4px; margin-left:5px;">
                                                <input type="radio" name="<?php echo 'row'.$rad_cnt;?>" id="<?php echo 'row'.$rad_cnt.'col5';?>"
                                                onclick="if (this.checked)
                                                {
                                                    _('windwo_s').value = 1;
                                                }"
                                                value="<?php echo $table[0].'e';?>"<?php                                     

                                                for ($f = 1; $f <= count($arr_std_selections); $f++)
                                                {
                                                    if (isset($arr_std_selections[$f]['cCourseId']) && $arr_std_selections[$f]['cCourseId'] == $table[0] && $arr_std_selections[$f]['cwindow'] == 'e')
                                                    {
                                                        echo 'checked';
                                                        break;
                                                    }
                                                }?>>
                                                <span class="checkmark radio_checkmark"></span><div style="line-height:1.8;"></div>
                                            </label><?php
                                            break;
                                        }
                                    }?>
                                </div>
                            </div><?php
                         }
                         
                        $stmt = $mysqli->prepare("SELECT * from pract_centre 
                        where tdate >= '$semester_begin_date'
                        AND vMatricNo = ?");
                        $stmt->bind_param("s", $_REQUEST['vMatricNo']);
                        $stmt->execute();
                        $stmt->store_result();
                        $reg_pract_crs = $stmt->num_rows;?>
                         
                        <input name="course_ccount" id="course_ccount" type="hidden" value="<?php echo $C;?>" />                        
                        
                         
                        <div id="btn_div" style="display:flex; 
                            flex:100%;
                            height:auto; 
                            margin-top:20px;"><?php
                                $sho_prn = 'none';
                                if ($reg_pract_crs > 0)
                                {
                                    $sho_prn = 'block';
                                }?>
                                <button id="prn_p_a_slip" type="button" class="login_button" style="display:<?php echo $sho_prn;?>" onclick="scs.submit()">Print centre admission slip</button>
                                <button type="submit" class="login_button">Submit</button>
                        </div>
                    </form>
                    <form action="practical_centre_admission_slip" method="post" name="scs" target="_blank" enctype="multipart/form-data">
                        <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>" />
                        <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                        <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                        <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else{echo $cEduCtgId;}?>" />
                        
                        <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> ''){echo $_REQUEST["side_menu_no"];}?>" />
                        <input name="tSemester_loc" id="tSemester_loc" type="hidden" value="<?php echo $tSemester_loc;?>" />
                        <input name="cAcademicDesc_loc" id="cAcademicDesc_loc" type="hidden" value="<?php echo $orgsetins['cAcademicDesc'];?>" />
                        <input name="vDesc" type="hidden" value="Wallet Funding" />
                    </form>
                </div>
            </div>

            <div id="menu_bs_scrn" class="appl_far_right_div" style="z-index:2;">
                <?php build_menu_right($balance);?>
            </div>
        </div>
	</body>
</html>