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

	// function preventBack(){window.history.forward();}
	// 	setTimeout("preventBack()", 0);
	// 	window.onunload=function(){null};		
		
    function chk_inputs()
    {
        var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
        for (j = 0; j <= ulChildNodes.length-1; j++)
        {
            ulChildNodes[j].style.display = 'none';
        }
        
        //_("submityes").style.display = 'none';
        
        if (_('enq_pwd_loc').uvApplicationNo.value == '')
        {
            setMsgBox("labell_msg0","");
            _('enq_pwd_loc').uvApplicationNo.focus();
            return false;
        }else if(marlic(_('enq_pwd_loc').uvApplicationNo.value)!='')
        {
            setMsgBox("labell_msg0",marlic(_('enq_pwd_loc').uvApplicationNo.value));
            _('enq_pwd_loc').uvApplicationNo.focus();
            return false;
        }

        if (_('enq_pwd_loc').sm.value == '9' && _('enq_pwd_loc').conf_g.value == '')
        {
            // if (_('id_no').value == 0)
            // {
            //     _("conf_msg_msg_loc").innerHTML = 'Reset password for application for number?';
            // }else if (_('id_no').value == 1)
            // {
            //     _("conf_msg_msg_loc").innerHTML = 'Reset password for matric. number for number?';
            // }
            
            // _('conf_box_loc').style.display = 'block';
            // _('conf_box_loc').style.zIndex = '3';
            // _('smke_screen_2').style.display = 'block';
            // _('smke_screen_2').style.zIndex = '2';
            // return false;
        }

        var formdata = new FormData();
        
        if (_('enq_pwd_loc').conf_g.value == '1')
        {
            formdata.append("conf", _('enq_pwd_loc').conf_g.value);
        }
        
        formdata.append("currency_cf", _("currency_cf").value);
        formdata.append("user_cat", _('enq_pwd_loc').user_cat.value);
        formdata.append("save_cf", _("save_cf").value);
        formdata.append("uvApplicationNo", _('enq_pwd_loc').uvApplicationNo.value);
        formdata.append("vApplicationNo", _('enq_pwd_loc').vApplicationNo.value);
        formdata.append("whattodo", _('whattodo').value);
        formdata.append("id_no", _('id_no').value);
        formdata.append("sm", _('enq_pwd_loc').sm.value);
        formdata.append("mm", _('enq_pwd_loc').mm.value);

        //formdata.append("study_mode", _('enq_pwd_loc').service_mode.value);
        formdata.append("user_centre", _('enq_pwd_loc').user_centre.value);
        
        opr_prep(ajax = new XMLHttpRequest(),formdata);
    }


    function opr_prep(ajax,formdata)
    {
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        
        ajax.open("POST", "opr_enq_pwd.php");
        ajax.send(formdata);
    }

	
    function completeHandler(event)
    {
        on_error('0');
        on_abort('0');
        in_progress('0');
        
        var returnedStr = event.target.responseText;

        var ash_ind = returnedStr.indexOf("#");
        var plus_ind = returnedStr.indexOf("+");
        if (returnedStr.indexOf("?") != -1)
        {
            _('conf_msg_msg_loc').innerHTML = returnedStr.substr(ash_ind+1);
            _('conf_box_loc').style.display = 'block';
            _('conf_box_loc').style.zIndex = '3';
            _('smke_screen_2').style.display = 'block';
            _('smke_screen_2').style.zIndex = '2';
        }else if (returnedStr.indexOf("does not") != -1 || 
        returnedStr.indexOf("not") != -1 || 
        returnedStr.indexOf("blocked") != -1 || 
        returnedStr.indexOf("already") != -1 || 
        returnedStr.indexOf("Insufficient") != -1 || 
        returnedStr.indexOf("Invalid") != -1 || 
        returnedStr.indexOf("graduated") != -1 || 
        returnedStr.indexOf("yet") != -1)
        {
            caution_box(returnedStr);
        }else if (returnedStr.indexOf("successful") != -1)
        {
            success_box(returnedStr);
        }
        
        if (_("id_no") && _("id_no").value == 1)
        {           
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
            }				
            _("std_lvl").style.display = 'block';
            
        
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

            faculty = returnedStr.substr(900, 100).trim().toLowerCase();
            _("passprt").src = '../../ext_docs/pics/'+faculty+'/pp/p_'+returnedStr.substr(0,plus_ind).trim()+'.jpg';
            
            _("passprt").onerror = function() {myFunction()};

            function myFunction() {
                _("passprt").src = 'img/p_.png'
            }
        }else if (_("id_no") && _("id_no").value == 0)
        {
            _("std_names").innerHTML = returnedStr.substr(0, 100).trim()+'<br>'+
            returnedStr.substr(100, 100).trim()+'<br>'+
            returnedStr.substr(200, 100).trim();

            _("std_quali").innerHTML = returnedStr.substr(300, 100).trim()+'<br>'+
            returnedStr.substr(400, 100).trim();
            
            _("std_lvl").innerHTML = returnedStr.substr(500, 100).trim()+' Level';
            faculty = returnedStr.substr(600, 100).trim();

            _("passprt").src = '../../ext_docs/pics/'+faculty+'/pp/p_'+_('enq_pwd_loc').uvApplicationNo.value+'.jpg';            
            _("passprt").onerror = function() {myFunction()};

            function myFunction() {
                _("passprt").src = 'img/p_.png'
            }
        }

        var ash_ind = returnedStr.indexOf("#");
        returnedStr = returnedStr.substr(ash_ind+1);			
        
       if (!(returnedStr.indexOf("mismatch") != -1 || 
        returnedStr.indexOf("not") != -1 || 
        returnedStr.indexOf("blocked") != -1 || 
        returnedStr.indexOf("already") != -1 || 
        returnedStr.indexOf("Insufficient") != -1 || 
        returnedStr.indexOf("Invalid") != -1 || 
        returnedStr.indexOf("yet") != -1 ||
        returnedStr.indexOf("?") != -1))
        {
            success_box(returnedStr);
        }
        _('enq_pwd_loc').conf_g.value = '';
    }

    
    function tidy_screen()
    {                    
        var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
        for (j = 0; j <= ulChildNodes.length-1; j++)
        {
            ulChildNodes[j].style.display = 'none';
        }
        _('enq_pwd_loc').conf_g.value = '';
        
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

    function centre_select()
    {
        return true;

        if (_("user_centre_loc").value == '')
        {
            _("succ_boxt").style.display = "block";
            _("succ_boxt").innerHTML = "Please select a study centre";
            _("succ_boxt").style.display = "block";
            return false;
        }

        if (_("service_mode_loc").value == '')
        {
            _("succ_boxt").style.display = "block";
            _("succ_boxt").innerHTML = "Please select a service mode";
            _("succ_boxt").style.display = "block";
            return false;
        }

        return true;
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
		<?php require_once ('menu_bar_content_stff.php');?>
		<!-- InstanceEndEditable -->
	</div>

	<div id="leftSide_std" style="margin-left:0px;"><?php
		require_once ('stff_left_side_menu.php');?>
	</div>
	<div id="rtlft_std" style="position:relative;">
		<!-- InstanceBeginEditable name="EditRegion6" -->			
			
			<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
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
                        _('smke_screen_2').style.display='none';
                        _('smke_screen_2').style.zIndex='-1';
                        _('enq_pwd_loc').conf_g.value='1';
                        chk_inputs();
                        return false">
                        <div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
                            Yes
                        </div>
                    </a>

                    <a href="#" style="text-decoration:none;" 
                        onclick="_('enq_pwd_loc').conf_g.value='';
                        _('conf_box_loc').style.display='none';
                        _('smke_screen_2').style.display='none';
                        _('smke_screen_2').style.zIndex='-1';
                        return false">
                        <div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
                            No
                        </div>
                    </a>
                </div>
            </div>
            <div class="innercont_top">Reset password</div>
            
            <form action="manage-access" method="post" name="enq_pwd_loc" id="enq_pwd_loc" enctype="multipart/form-data">
                <input name="user_cat" id="user_cat" type="hidden" value="<?php echo $_REQUEST['user_cat']; ?>" />	
                <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                <input name="save_cf" id="save_cf" type="hidden" value="-1" />
                <input name="tabno" id="tabno" type="hidden" 
                    value="<?php if (isset($_REQUEST['save_cf'])){echo $_REQUEST['tabno'];}else{echo '0';} ?>"/>
                <input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                <input name="frm_upd" id="frm_upd" type="hidden" />
                <input name="user_cEduCtgId" id="user_cEduCtgId" type="hidden" value="" />
                <input name="numOfiputTag" id="numOfiputTag" type="hidden" value=""/>
                <input name="app_frm_no" id="app_frm_no" type="hidden" />
                <?php frm_vars(); ?>
                
                <div class="innercont_stff">
                    <input name="whattodo" id="whattodo" type="hidden"  value="<?php if (isset($_REQUEST["whattodo"])){echo $_REQUEST["whattodo"];}; ?>"/>
                    <div class="div_select">
                        <select name="id_no" id="id_no" class="select" onchange="_('enq_pwd_loc').uvApplicationNo.value = ''; tidy_screen()">
                            <option value="0">Application form number</option>
                            <option value="1">Matriculation number</option>
                        </select>
                    </div>
                    <div class="div_select">
                        <input name="uvApplicationNo" id="uvApplicationNo" type="text" class="textbox" value="<?php echo $_REQUEST['uvApplicationNo']; ?>" onchange="tidy_screen()" />
                    </div>
                    <div id="labell_msg0" class="labell_msg blink_text orange_msg" style="height:auto"></div>
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
                
				<?php side_detail('');?>
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