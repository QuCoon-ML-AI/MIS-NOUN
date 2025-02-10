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
	<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />
	<script language="JavaScript" type="text/javascript">
		document.onkeydown = function (e) 
		{
			if (e.ctrlKey && e.keyCode === 85) 
			{
				return false;
			}
		}

        
		//check_environ();
			
		function chk_inputs()
		{
			var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
			for (j = 0; j <= ulChildNodes.length-1; j++)
			{
				ulChildNodes[j].style.display = 'none';
			}

            if (sc_1_loc.uvApplicationNo.value == '')
            {
                setMsgBox("labell_msg0","");
                sc_1_loc.uvApplicationNo.focus();
                return false;
            }            
            
            // if (!sc_1_loc.cancel_perm.checked && _("conf_box_loc").style.display == 'block')
            // {
            //     if (_('veri_token') && _('veri_token').value == '')
            //     {
            //         setMsgBox('labell_msg_token','Token required');
            //         return false;
            //     }
                
            //     if (_('veri_token').value != _('hd_veri_token').value)
            //     {
            //         setMsgBox('labell_msg_token','Invalid token');
            //         return false;
            //     }
            // }
            
            var formdata = new FormData();

			formdata.append("whattodo", _("whattodo").value);           
            
            if (sc_1_loc.conf.value == '1')
            {
                formdata.append("conf", sc_1_loc.conf.value);
                // if (!sc_1_loc.cancel_perm.checked)
                // {
                //     formdata.append("veri_token", _("hd_veri_token").value);
                // }

                formdata.append("app_frm_no", _("app_frm_no").value);
            }
            

            if (_("ans6").style.display == 'none')
            {
                formdata.append("process_step", '1');
            }else  if (_("ans6").style.display == 'block')
            {
                formdata.append("process_step", '2');
            }

            if (sc_1_loc.cancel_perm.checked)
            {
                formdata.append("cancel_perm", '1');
            }

            formdata.append("id_no", sc_1_loc.id_no.value);
            formdata.append("ilin", sc_1_loc.ilin.value);
            formdata.append("user_cat", sc_1_loc.user_cat.value);
            
            formdata.append("uvApplicationNo", sc_1_loc.uvApplicationNo.value);

            formdata.append("vApplicationNo", sc_1_loc.vApplicationNo.value);
            formdata.append("sm", sc_1_loc.sm.value);
            formdata.append("mm", sc_1_loc.mm.value);
            
		    formdata.append("staff_study_center", sc_1_loc.user_centre.value);
            
            formdata.append("sRoleID", _('sRoleID').value);
            
		    opr_prep(ajax = new XMLHttpRequest(),formdata);
		}

	
        function opr_prep(ajax,formdata)
        {
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "opr_reset_p_upload.php");
            ajax.send(formdata);
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

        function completeHandler(event)
        {
            on_error('0');
            on_abort('0');
            in_progress('0');

            var returnedStr = event.target.responseText;
                        
            if (_("whattodo"))
		    { 
                var plus_ind = returnedStr.indexOf("+");
                var at_ind = returnedStr.indexOf("@");
                var dol_ind = returnedStr.indexOf("$");
                var car_ind = returnedStr.indexOf("^");
                var ash_ind = returnedStr.indexOf("#");
                var perc_ind = returnedStr.indexOf("%");
                var bang_ind = returnedStr.indexOf("!");
                var tild_ind = returnedStr.indexOf("~");
                
                var mask = '';

                returnedStr = returnedStr.trim();

                if (returnedStr.indexOf("success") == -1 && returnedStr.charAt(0) != '*' && returnedStr.indexOf("?") == -1)
                {
                    if (_("id_no") && _("id_no").value == 0)
                    {
                        _("app_frm_no").value = sc_1_loc.uvApplicationNo.value;

                        _("std_names").innerHTML = returnedStr.substr(0, 100).trim()+'<br>'+
                        returnedStr.substr(100, 100).trim()+'<br>'+
                        returnedStr.substr(200, 100).trim();
                        student_name = returnedStr.substr(0, 100).trim()+' '+returnedStr.substr(100, 100).trim()+' '+returnedStr.substr(200, 100).trim();

                        _("std_quali").innerHTML = returnedStr.substr(300, 100).trim()+'<br>'+
                        returnedStr.substr(400, 100).trim();
                        student_qualif = returnedStr.substr(300, 100).trim()+' '+returnedStr.substr(400, 100).trim()
                        
                        if (returnedStr.substr(500, 100).trim() == 20)
                        {
                            _("std_lvl").innerHTML = 'DIP 1';
                        }else if (returnedStr.substr(500, 100).trim() == 30)
                        {
                            _("std_lvl").innerHTML = 'DIP 2';
                        }else
                        {
                            _("std_lvl").innerHTML = returnedStr.substr(500, 100).trim()+' Level';
                        }
                        
                        _('level_now').value = returnedStr.substr(500, 100).trim();

                        student_level = _("std_lvl").innerHTML;
                        _("std_lvl").style.display = 'block';

                        _("std_sems").innerHTML = '';
                        _("std_sems").style.display = 'none';
                        student_semester = '';
                        
                        _("std_vCityName").innerHTML = returnedStr.substr(700, 100).trim();
                        _("std_vCityName").style.display = 'block';
                        student_center =  _("std_vCityName").innerHTML;

                        facult_id = returnedStr.substr(800,100);

                        student_faculty = returnedStr.substr(900,100).trim();
                        student_dept = returnedStr.substr(1000,100).trim();

                        _("user_cEduCtgId").value = returnedStr.substr(1200,100).trim();

                        mask = returnedStr.substr(1400).trim();
                    }else if (_("id_no") && _("id_no").value == 1)
                    {
                        _('app_frm_no').value = returnedStr.substr(0,(plus_ind-2));
                        
                        _("std_names").innerHTML = returnedStr.substr(100, 100).trim()+'<br>'+
                        returnedStr.substr(200, 100).trim()+'<br>'+
                        returnedStr.substr(300, 100).trim();
                        student_name = returnedStr.substr(100, 100).trim()+' '+returnedStr.substr(200, 100).trim()+' '+returnedStr.substr(300, 100).trim();

                        _("std_quali").innerHTML = returnedStr.substr(400, 100).trim()+'<br>'+
                        returnedStr.substr(500, 100).trim();
                        student_qualif = returnedStr.substr(400, 100).trim()+' '+returnedStr.substr(500, 100).trim();
                        
                        if (returnedStr.substr(600, 100).trim() == 20)
                        {
                            _("std_lvl").innerHTML = 'DIP 1';
                        }else if (returnedStr.substr(600, 100).trim() == 30)
                        {
                            _("std_lvl").innerHTML = 'DIP 2';
                        }else
                        {
                            _("std_lvl").innerHTML = returnedStr.substr(600, 100).trim()+' Level';
                        }
                        
                        _('level_now').value = returnedStr.substr(600, 100).trim();

                        _("std_lvl").style.display = 'block';
                        student_level = _("std_lvl").innerHTML;

                        if (returnedStr.substr(700, 100).trim() == 1)
                        {
                            if (_("std_sems")){_("std_sems").innerHTML = 'First semester';}
                        }else if (returnedStr.substr(700, 100).trim() == 2)
                        {
                            if (_("std_sems")){_("std_sems").innerHTML = 'Second semester';}
                        }
                        _("std_sems").style.display = 'block';
                        student_semester = _("std_sems").innerHTML;
                        
                        _("std_vCityName").innerHTML = returnedStr.substr(800, 100).trim();				
                        _("std_vCityName").style.display = 'block';
                        student_center =  _("std_vCityName").innerHTML;

                        facult_id = returnedStr.substr(900,100);

                        student_faculty = returnedStr.substr(1000,100).trim();
                        student_dept = returnedStr.substr(1100,100).trim();

                        _("user_cEduCtgId").value = returnedStr.substr(1300,100).trim();

                        mask = returnedStr.substr(1500).trim();
                    }

                    _("div_a").innerHTML = _("sc_1_loc").uvApplicationNo.value;
                    
                    _("div_0").innerHTML = student_name;//name
					_("div_1").innerHTML = student_center;
                    
                    _("div_2").innerHTML = student_faculty;//faculty
					_("div_3").innerHTML = student_dept;//dept
					_("div_4").innerHTML = student_qualif;//programme
					_("div_5").innerHTML = student_level;//level
                    if (student_semester != '')
                    {
                        _("div_5").innerHTML = student_level+'/'+student_semester;//level/semester
                    }
                    
					if (_("id_no").value == 0)
                    {
                        _("div_lab_a").innerHTML = 'Application form number';
                    }else if (_("id_no").value == 1)
                    {
                        _("div_lab_a").innerHTML = 'Matriculation number';
                    }
                    
                    _("ans6").style.display = 'block';
                }
                
                returnedStr = returnedStr.substr(ash_ind+1);
                
                if (returnedStr.indexOf("success") != -1)
                {
                    success_box(returnedStr.substr(1,returnedStr.length-1));

                    // if (!sc_1_loc.cancel_perm.checked)
                    // {
                    //     _("hd_veri_token").value = '';
                    //     _("veri_token").value = '';
                    // }

                    _('conf_box_loc').style.display='none';
                    _('smke_screen_2').style.display='none';
                    _('smke_screen_2').style.zIndex='-1';
                }else  if (returnedStr.indexOf("?") != -1)
                {    
                    if (sc_1_loc.cancel_perm.checked)
                    {
                        //_("submityes0").style.display = 'none';
                        _("conf_msg_msg_loc").innerHTML = returnedStr;
                    }else
                    {
                        //_("submityes0").style.display = 'block';
                        //_("hd_veri_token").value = returnedStr.substr(0,6);
                        //_("conf_msg_msg_loc").innerHTML = returnedStr.substr(6);

                        _("conf_msg_msg_loc").innerHTML = returnedStr;
                    }

                    _('conf_box_loc').style.display = 'block';
                    _('conf_box_loc').style.zIndex = '3';
                    _('smke_screen_2').style.display = 'block';
                    _('smke_screen_2').style.zIndex = '2';
                }else if (returnedStr.charAt(0) == '*')
                {
                    caution_box(returnedStr.substr(1,returnedStr.length-1))
                }
                
                if (returnedStr.indexOf("success") == -1 && returnedStr.indexOf("*") == -1)
                {
                    if (_("id_no") && _("id_no").value == 0 && returnedStr.indexOf('not yet submitted') != -1)
                    {
                        _("passprt").src = '../appl/img/left_side_logo.png';
                    }else
                    {                        
                        _("passprt").src = mask;
                        _("passprt").onerror = function() {myFunction()};
                        
                        if (_("id_no") && _("id_no").value == 1)
                        {
                            sc_1_loc.uvApplicationNo_loc.value = _('app_frm_no').value;
                        }

                        function myFunction() 
                        {
                            _("passprt").src = '../appl/img/left_side_logo.png';
                        }
                    }
                }
                
                sc_1_loc.conf.value = '';
            }
        }

        
        function tidy_screen()
        {        
            _("ans6").style.display = 'none';
            
            sc_1_loc.conf.value = '';
            
            var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
            for (j = 0; j <= ulChildNodes.length-1; j++)
            {
                ulChildNodes[j].style.display = 'none';
            }

            _("user_cEduCtgId").value = '';
        }
	</script>
	<noscript></noscript>
</head>


<body onLoad="checkConnection()">
    <?php admin_frms(); $has_matno = 0;?>
	
	<div id="container">		
		<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div><?php
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
            <input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID_u ?>" />
            
            <div id="conf_box_loc" class="center" style="display:none; width:400px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
                <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                    Confirmation
                </div>
                <a href="#" style="text-decoration:none;">
                    <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
                </a>
                <!-- <div id="submityes0" 
                    style="border-radius:3px; margin:auto; margin-top:30px; margin-bottom:5px; height:auto; width:95%; text-align:center; padding:2%; background:#f1f1f1">
                    <div style="width:auto; margin:auto; margin-bottom:5px; padding:0px; width:95%; float:none; line-height:1.5;">
                        Check your official e-mail in-box for a token to use for this session<br>Token expires in 20minutes
                    </div>
                    <div style="margin:auto; margin-top:10px; height:auto; text-align:center; padding:0px; width:95%;">
                        <input name="veri_token" id="veri_token" type="text" class="textbox" placeholder="Enter token here..." style="float:none; width:50%; padding:5px; text-align:center; height:25px"/>
                        <div id="labell_msg_token" class="labell_msg blink_text orange_msg" style="float:none; text-align:center; display:none; width:50%; margin:auto; margin-top:10px;"></div>
                        <input name="hd_veri_token" id="hd_veri_token" type="hidden"/>
                    </div>
                </div> -->
                <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:100%; float:left; text-align:center; padding:0px;"></div>
                <div style="margin-top:10px; width:100%; float:left; text-align:right; padding:0px;">
                    <a href="#" style="text-decoration:none;" 
                        onclick="sc_1_loc.conf.value = '1';
                        chk_inputs(); 
                        return false">
                        <div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
                            Yes
                        </div>
                    </a>

                    <a href="#" style="text-decoration:none;" 
                        onclick="sc_1_loc.conf.value='';
                        _('conf_box_loc').style.display='none';
                        _('smke_screen_2').style.display='none';
                        _('smke_screen_2').style.zIndex='-1';
                        sc_1_loc.cancel_permchecked = false;
                        //_('hd_veri_token').value = '';
                        //_('veri_token').value = '';
                        return false">
                        <div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
                            No
                        </div>
                    </a>
                </div>
            </div>

            <div class="innercont_top" style="margin-bottom:0px;">Student's request - Reset passport upload</div>
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
            </form>

            <form action="student-requests" method="post" name="sc_1_loc" id="sc_1_loc" enctype="multipart/form-data">
                <input name="tabno" id="tabno" type="hidden" 
                    value="<?php if (isset($_REQUEST['tabno'])){echo $_REQUEST['tabno'];}else{echo '0';} ?>"/>
                <input name="user_cEduCtgId" id="user_cEduCtgId" type="hidden" value="go"/>
                
                <input name="uvApplicationNo_loc" id="uvApplicationNo_loc" type="hidden" />
                <input name="app_frm_no" id="app_frm_no" type="hidden" />
                <input name="tSemester" id="tSemester" type="hidden" value="<?php echo $tSemester; ?>" />
                <input name="whattodo" id="whattodo" type="hidden" value="<?php if(isset($_REQUEST['whattodo'])){echo $_REQUEST['whattodo'];}else{echo '';}?>" />
                
                <input name="process_step" id="process_step" type="hidden" value="" /><?php 
                frm_vars();
                
                require_once("student_requests.php");?>

                <div class="innercont_stff" style="margin-top:20px;">
                    <div class="div_select" style="width:240px;">
                        <select name="id_no" id="id_no" class="select" 
                        onchange="sc_1_loc.uvApplicationNo.value=''; tidy_screen();">
                            <option value="0">Application form number (AFN)</option>
                            <option value="1">Matriculation number</option>
                        </select>
                    </div>

                    <div id="uvApplicationNo_div" class="div_select" style="display:block">
                        <input name="uvApplicationNo" id="uvApplicationNo" type="text" class="textbox"  
                        placeholder="Enter AFN/Mat. no. here"
                        onchange="this.value=this.value.trim();
                        this.value=this.value.toUpperCase();
                        tidy_screen()" />
                    </div>
                    <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
                </div>

                <div class="innercont_stff_tabs" id="ans6" style="border:0px; height:auto; margin-left:1px; margin-top:10px; width:736px;">
                    <div class="innercont_stff" style="margin-bottom:-1px;">
                        <div id="div_lab_a" class="div_label" style="width:239px;">
                            Matriculation number
                        </div>
                        <div id="div_a" class="div_valu"></div>	
                    </div>
                    <div class="innercont_stff">
                        <div class="div_label" style="width:239px;">
                            Name
                        </div>
                        <div id="div_0" class="div_valu"></div>	
                    </div>
                    
                    <div class="innercont_stff">
                        <div class="div_label" style="width:239px;">
                            Study centre
                            <input id="studycentre_now" type="hidden"/>
                        </div>
                        <div id="div_1" class="div_valu"></div>	
                    </div>
                    
                    <div class="innercont_stff">
                        <div class="div_label" style="width:239px;">
                            Faculty
                        </div>
                        <div id="div_2"  class="div_valu"></div>	
                    </div>
                    <div class="innercont_stff">
                        <div class="div_label" style="width:239px;">
                            Department
                        </div>
                        <div id="div_3"  class="div_valu"></div>	
                    </div>
                    <div class="innercont_stff">
                        <div class="div_label" style="width:239px;">
                            Programme
                            <input id="programme_now" type="hidden"/>
                        </div>
                        <div id="div_4"  class="div_valu"></div>	
                    </div>
                    <div class="innercont_stff">
                        <div class="div_label" style="width:239px;">
                            Level/Semester
                            <input id="level_now" type="hidden"/>
                        </div>
                        <div id="div_5"  class="div_valu"></div>	
                    </div>
                </div>

                <div class="innercont_stff" style="margin-top:15px">
                    <label for="cancel_perm" class="labell" style="width:239px;">Cancel permission</label>
                    <div class="div_select" style="height:auto;">
                        <input name="cancel_perm" id="cancel_perm" type="checkbox" style="margin-top:4px; margin-left:0px" />
                    </div>
                </div>
            </form>
        </div>
        
        <div class="rightSide_0">
            <div id="insiderightSide" style="margin-top:1px;">
                <div id="pp_box">
                    <img name="passprt" id="passprt" src="<?php echo get_pp_pix('');?>" width="95%" height="185"  
                    style="margin:0px;" alt="" />
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
                    
                    <?php if (isset($_REQUEST['uvApplicationNo']))
                    {
                        side_detail($_REQUEST['uvApplicationNo']);
                    }else
                    {
                        side_detail('');
                    }?>
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