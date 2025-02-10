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
		
		var formdata = new FormData();

        if (l_all_user_loc.conf.value != 1)
        {
            if (_("mat_no_status").value == 0)
            {
                setMsgBox("labell_msg0","Invalid matriculation number");
                _('l_all_user_loc').uvApplicationNo.focus();
                return false;
            }

            if (_('l_all_user_loc').uvApplicationNo.value == '')
            {
                setMsgBox("labell_msg0","");
                _('l_all_user_loc').uvApplicationNo.focus();
                return false;
            }

            var made_request = 0;
            var ulChildNodes = _("rtlft_std").getElementsByTagName("input");
            for (j = 0; j <= ulChildNodes.length-1; j++)
            {
                if (ulChildNodes[j].offsetLeft > 0 && ulChildNodes[j].type == 'checkbox' && ulChildNodes[j].checked)
                {
                    made_request = 1;
                    break;
                }
            }

            if (made_request == 0)
            {
                caution_box('Select one or more request item on the menu by checking the corresponding box');
                return
            }
                
            if (_('l_all_user_loc').l_all_user_close.value == '')
            {
                setMsgBox("labell_msg1","");
                _('l_all_user_loc').l_all_user_close.focus();
                return false;
            }
        }else if (l_all_user_loc.conf.value == 1)
        {
            formdata.append("conf", l_all_user_loc.conf.value);
        }
				
		formdata.append("currency_cf", _("currency_cf").value);
		formdata.append("user_cat", _('l_all_user_loc').user_cat.value);
		formdata.append("save_cf", _("save_cf").value);
		formdata.append("uvApplicationNo", _('l_all_user_loc').uvApplicationNo.value);
		formdata.append("vApplicationNo", _('l_all_user_loc').vApplicationNo.value);
		
		formdata.append("sm", _('l_all_user_loc').sm.value);
		formdata.append("mm", _('l_all_user_loc').mm.value);

		formdata.append("staff_study_center", _('l_all_user_loc').user_centre.value);

        if (_("sp_sem_reg").checked)
        {
		    formdata.append("sp_sem_reg", "1");
        }else
        {
            formdata.append("sp_sem_reg", "0");
        }
        
        if (_("sp_crs_reg").checked)
        {
		    formdata.append("sp_crs_reg", "1");
        }else
        {
            formdata.append("sp_crs_reg", "0");
        }
        
        if (_("sp_drop_crs_reg").checked)
        {
		    formdata.append("sp_drop_crs_reg", "1");
        }else
        {
            formdata.append("sp_drop_crs_reg", "0");
        }
        
        // if (_("sp_see_crs_reg").checked)
        // {
		//     formdata.append("sp_see_crs_reg", "1");
        // }else
        // {
        //     formdata.append("sp_see_crs_reg", "0");
        // }
        
        
        if (_("sp_exam_reg").checked)
        {
		    formdata.append("sp_exam_reg", "1");
        }else
        {
            formdata.append("sp_exam_reg", "0");
        }

        if (_("sp_drop_exam_reg").checked)
        {
		    formdata.append("sp_drop_exam_reg", "1");
        }else
        {
            formdata.append("sp_drop_exam_reg", "0");
        }

        // if (_("sp_see_exam_reg").checked)
        // {
        //     formdata.append("sp_see_exam_reg", "1");
        // }else
        // {
        //     formdata.append("sp_see_exam_reg", "0");
        // }
        
		formdata.append("sp_see_exam_reg", _("sp_see_exam_reg").value);
		formdata.append("sp_see_crs_reg", _("sp_see_crs_reg").value);

		formdata.append("l_all_user_close", _("l_all_user_close").value);
        
		formdata.append("sp_ilevel", _("ilevel").value);
		formdata.append("sp_tsemester", _("tsemester").value);
        
		opr_prep(ajax = new XMLHttpRequest(),formdata);
	}
	
	
	function opr_prep(ajax,formdata)
	{
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		
		ajax.open("POST", "opr_l_all_user.php");
		ajax.send(formdata);
	}
   

    function Call_detail()
    {
        var formdata = new FormData();
        formdata.append("frm_upd", _("frm_upd").value);
        formdata.append("uvApplicationNo", _('l_all_user_loc').uvApplicationNo.value);

		formdata.append("currency_cf", _("currency_cf").value);
		opr_prep(ajax = new XMLHttpRequest(),formdata);
    }

    function completeHandler(event)
	{
        var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			ulChildNodes[j].style.display = 'none';
		}

        on_error('0');
        on_abort('0');
        in_progress('0');
        
        _("mat_no_status").value = 1;

		var returnedStr = event.target.responseText;
		
		var plus_ind = returnedStr.indexOf("+");
		var ash_ind = returnedStr.indexOf("#");
		
		if (returnedStr.indexOf("cannot be granted") != -1)
		{
            caution_box(returnedStr);
		}else if (returnedStr.indexOf("no active") != -1 || returnedStr.indexOf("graduated") != -1 || returnedStr.indexOf("invalid") != -1)
		{
            caution_box(returnedStr);
            _("mat_no_status").value = 0;
		}else if (_("frm_upd").value == 1)
        {
            _('app_frm_no').value = returnedStr.substr(0,plus_ind);
            
            _("std_names").innerHTML = returnedStr.substr(100, 100).trim()+'<br>'+
            returnedStr.substr(200, 100).trim()+'<br>'+
            returnedStr.substr(300, 100).trim();

            _("std_quali").innerHTML = returnedStr.substr(400, 100).trim()+'<br>'+
            returnedStr.substr(500, 100).trim();
            
            if (returnedStr.substr(600, 100).trim() == 20)
            {
                _("std_lvl").innerHTML = 'DIP 1';
            }else if (returnedStr.substr(600, 100).trim() == 30)
            {
                _("std_lvl").innerHTML = 'DIP 2';
            }else
            {
                _("std_lvl").innerHTML = returnedStr.substr(600, 100).trim()+' Level';
                _('ilevel').value = returnedStr.substr(600, 100).trim();
            }	
            
            _("std_lvl").style.display = 'block';

            
            _('tsemester').value = returnedStr.substr(700, 100).trim();

            if (returnedStr.substr(700, 100).trim() == 1)
            {
                if (_("std_sems")){_("std_sems").innerHTML = 'First semester';}
            }else
            {
                if (_("std_sems")){_("std_sems").innerHTML = 'Second semester';}
            }
            _("std_sems").style.display = 'block';
            
            _("std_vCityName").innerHTML = returnedStr.substr(800, 100).trim();
            _("std_vCityName").style.display = 'block';

            facult_id = returnedStr.substr(900,100).trim();

            var mask = returnedStr.substr(1000, 100).trim();

            _("passprt").src = '../../ext_docs/pics/'+facult_id+'/pp/p_'+mask+'.jpg';
            _("passprt").onerror = function() {myFunction1()};
            function myFunction1()
            {
                _("passprt").src = '../../ext_docs/pics/'+facult_id+'/pp/p_'+mask+'.jpeg';

                _("passprt").onerror = function() {myFunction2()};

                function myFunction2() 
                {
                    _("passprt").src = '../../ext_docs/pics/'+facult_id+'/pp/p_'+mask+'.pjpeg';
                    _("passprt").onerror = function() {myFunction3()};

                    function myFunction3() 
                    {
                        _("passprt").src = '../appl/img/left_side_logo.png';
                    }
                }
            }
            
            returnedStr = returnedStr.substr(ash_ind+1).trim();
            
            _("refresh_request").style.display = 'none';
            _("cancel_request").style.display = 'none';
            if (returnedStr != '')
            {
                caution_box("There is a request that is yet to be used");

                _("sp_sem_reg").checked = false;
                if (returnedStr.substr(0, 100).trim() == '1')
                {
                    _("sp_sem_reg").checked = true;
                }

                _("sp_crs_reg").checked = false;
                if (returnedStr.substr(100, 100).trim() == '1')
                {
                    _("sp_crs_reg").checked = true;
                }

                _("sp_drop_crs_reg").checked = false;
                if (returnedStr.substr(200, 100).trim() == '1')
                {
                    _("sp_drop_crs_reg").checked = true;
                }

                // _("sp_see_crs_reg").checked = false;
                // if (returnedStr.substr(300, 100).trim() == '1')
                // {
                //     _("sp_see_crs_reg").checked = true;
                // }

                _("sp_exam_reg").checked = false;
                if (returnedStr.substr(400, 100).trim() == '1')
                {
                    _("sp_exam_reg").checked = true;
                }

                _("sp_drop_exam_reg").checked = false;
                if (returnedStr.substr(500, 100).trim() == '1')
                {
                    _("sp_drop_exam_reg").checked = true;
                }

                // _("sp_see_exam_reg").checked = false;
                // if (returnedStr.substr(600, 100).trim() == '1')
                // {
                //     _("sp_see_exam_reg").checked = true;
                // }
                
                _("request_date").innerHTML = returnedStr.substr(700, 100).trim();
                _("l_all_user_close").value = returnedStr.substr(800, 100).trim();

                duration = parseInt(returnedStr.substr(800, 100).trim());
                elapsed_time = parseInt(returnedStr.substr(900, 100).trim());

                _("time_to_go").innerHTML = (duration - elapsed_time)+' minutes';


                _("refresh_request").style.display = 'block';
                _("cancel_request").style.display = 'block';
            }else
            {
                caution_box("There is no active request.<br>You may set options accordingly to set a new one");
                _("time_to_go").innerHTML = '0';
            }

            _("prv_request").style.display = 'block';
            if (_("list_request"))
            {
                _("list_request").style.display = 'none';
            }

            _("frm_upd").value = 0;
        }else if (returnedStr.indexOf("successfully") != -1)
		{
            success_box(returnedStr);
		}

        l_all_user_loc.conf.value='0';
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
</script><?php

require_once ('set_scheduled_dates.php');?>
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
				border-bottom:1px solid #FF3300;">
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
		<?php require_once ('menu_bar_content_stff.php');?>
		<!-- InstanceEndEditable -->
	</div>

	<div id="leftSide_std" style="margin-left:0px;"><?php
		require_once ('stff_left_side_menu.php');?>
	</div>
	<div id="rtlft_std" style="position:relative;">
		<!-- InstanceBeginEditable name="EditRegion6" -->			
			
			<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
            <div class="innercont_top">Logout all current users</div>

            <form method="post" name="l_all_user_loc" id="l_all_user_loc" enctype="multipart/form-data">
                <input name="user_cat" id="user_cat" type="hidden" value="<?php echo $_REQUEST['user_cat']; ?>" />	
                <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                <input name="save_cf" id="save_cf" type="hidden" value="-1" />
                <input name="tabno" id="tabno" type="hidden" 
                    value="<?php if (isset($_REQUEST['save_cf'])){echo $_REQUEST['tabno'];}else{echo '0';} ?>"/>
                <input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                <input name="frm_upd" id="frm_upd" type="hidden" />
                <input name="numOfiputTag" id="numOfiputTag" type="hidden" value="0"/>
                <input name="study_mode" id="study_mode" type="hidden" value="odl" />
                
                <input name="app_frm_no" id="app_frm_no" type="hidden" value="<?php if (isset($_REQUEST["app_frm_no"])){echo $_REQUEST["app_frm_no"];} ?>"/>
                <input name="ilevel" id="ilevel" type="hidden" value="<?php if (isset($_REQUEST["ilevel"])){echo $_REQUEST["ilevel"];}?>"/>
                <input name="tsemester" id="tsemester" type="hidden" value="<?php if (isset($_REQUEST["tsemester"])){echo $_REQUEST["tsemester"];} ?>"/>
                <input name="mat_no_status" id="mat_no_status" type="hidden"  value="<?php if (isset($_REQUEST["mat_no_status"])){echo $_REQUEST["mat_no_status"];} ?>"/>

                <?php frm_vars();
    
                if (isset($_REQUEST["conf"]))
                {
                    $stmt = $mysqli->prepare("DELETE FROM ses_tab");
                    $stmt->execute();
                    $stmt->close();

                    success_box('All users (including you) have been logged out');
                }?>
                
                <div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
                <div id="submityes" class="center" 
                    style="display:<?php if (!isset($_REQUEST["conf"])){echo 'block';}else{echo 'none';}?>; 
                    width:500px;
                    text-align:center; 
                    padding:10px; 
                    line-height:1.6; 
                    box-shadow: 4px 4px 8px 5px #726e41; 
                    background:#FFFFFF">
                    <div id="submityes_msg" style="width:inherit; float:left; height:auto; text-align:left; padding:3px; color:#bf2323">
                        Confirmation
                    </div>
                    <div id="submityes_msg" 
                        style="width:inherit; 
                        float:left; 
                        height:auto; 
                        text-align:center; 
                        padding:3px; 
                        margin-top:5px; 
                        margin-bottom:10px;">
                        Are you sure you want to logout all current users ?
                    </div>
                    
                    <a href="#" style="text-decoration:none;" 
                        onclick="l_all_user_loc.conf.value='1';
                        in_progress('1');
                        l_all_user_loc.submit();
                        return false">
                        <div class="submit_button_green" style="width:60px; padding:2px; float:right">
                            Yes
                        </div>
                    </a>

                    <a href="#" style="text-decoration:none;" 
                        onclick="l_all_user_loc.conf.value='0';
                        _('submityes').style.display='none';
                        _('smke_screen_2').style.display='none';
                        return false">
                        <div class="submit_button_brown_reverse" style="width:60px; padding:2px; margin-right:4px; float:right">
                            No
                        </div>
                    </a>
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
                
				<?php //side_detail($_REQUEST['uvApplicationNo']);?>
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