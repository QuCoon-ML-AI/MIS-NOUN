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
    function chk_inputs()
	{
        var numbers = /^[NOU0-9]+$/;

		var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			ulChildNodes[j].style.display = 'none';
		}
			
		if (_('std_stat_loc').uvApplicationNo.value == '')
		{
			setMsgBox("labell_msg0","");
			_('std_stat_loc').uvApplicationNo.focus();
			return false;
		}

		if (_('std_stat_loc').uvApplicationNo.type=='text' && !_('std_stat_loc').uvApplicationNo.value.match(numbers))
        {
            setMsgBox("labell_msg0","Invalid number");
			_('std_stat_loc').uvApplicationNo.focus();
			return false;
        }
		
		if(marlic(_('std_stat_loc').uvApplicationNo.value)!='')
		{
			setMsgBox("labell_msg0",marlic(_('std_stat_loc').uvApplicationNo.value));
			_('std_stat_loc').uvApplicationNo.focus();
			return false;
		}
		
		var formdata = new FormData();
		
		formdata.append("currency_cf", _("currency_cf").value);
		formdata.append("user_cat", _('std_stat_loc').user_cat.value);
		formdata.append("save_cf", _("save_cf").value);
		formdata.append("uvApplicationNo", _('std_stat_loc').uvApplicationNo.value);
		formdata.append("vApplicationNo", _('std_stat_loc').vApplicationNo.value);
		formdata.append("id_no", _('std_stat_loc').id_no.value);
		formdata.append("sm", _('std_stat_loc').sm.value);
		formdata.append("mm", _('std_stat_loc').mm.value);

		formdata.append("arch_mode_hd", _('std_stat_loc').arch_mode_hd.value);
		

		formdata.append("staff_study_center", _('std_stat_loc').user_centre.value);
			
		opr_prep(ajax = new XMLHttpRequest(),formdata);
	}
	
	
	function opr_prep(ajax,formdata)
	{
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		
		ajax.open("POST", "opr_std_stat.php");
		ajax.send(formdata);
	}
   

    function completeHandler(event)
	{
        on_error('0');
        on_abort('0');
        in_progress('0');

		var returnedStr = event.target.responseText;
		
		var plus_ind = returnedStr.indexOf("+");
		var ash_ind = returnedStr.indexOf("#");
		
		if (returnedStr.indexOf("mismatch") != -1 || returnedStr.indexOf("Invalid") != -1 || returnedStr.indexOf("not in the archive") != -1|| returnedStr.indexOf("does not") != -1)
		{
            caution_box(returnedStr);
			_("passprt").src = 'img/p_.png'
			return;
		}else
		{
			_("std_names").innerHTML = returnedStr.substr(0, 100).trim()+'<br>'+
			returnedStr.substr(100, 100).trim()+'<br>'+
			returnedStr.substr(200, 100).trim();

			_("std_quali").innerHTML = returnedStr.substr(300, 100).trim()+'<br>'+
			returnedStr.substr(400, 100).trim();
			
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
			

			_("std_vCityName").innerHTML = returnedStr.substr(700, 100).trim();
			_("std_vCityName").style.display = 'block';

			student_faculty = returnedStr.substr(800, 100).trim();
			
			mask = returnedStr.substr(900, ash_ind).trim();						
		}

		_("passprt").src = mask;
		_("passprt").onerror = function() {myFunction()};

		function myFunction()
		{
			_("passprt").src = 'img/p_.png'
		}

		returnedStr = returnedStr.substr(returnedStr.indexOf("#")+1);
		
		_("labell_msg0").style.display = 'none';
		if (returnedStr != '' && returnedStr != '<p><p>' && returnedStr != '<br>' && returnedStr.trim() != '#')
		{
            success_box(returnedStr);
		}else
		{			
			if (_("id_no") && _("id_no").value == 0)
			{
				success_box('Candidate is clean');
			}else
			{
				success_box('Student is clean');
			}
		}
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
		
		<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
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
            <div class="innercont_top">View student's status</div>
			<?php 
            /*if (check_scope2('Academic registry','Archive') > 0 && isset($_REQUEST["mm"]) && $_REQUEST["mm"] == 4)
            {?>
                <div class="innercont_stff" style="width:auto; height:auto; position:absolute; right:0px; top:32px;">
                    <label for="arch_mode" class="lbl_beh" for="arch_modeall" style="float:right;"> 
                        <div class="div_select" style="width:20px; height:25px; padding:5px; background:#f3f3f3">   
                            <input name="arch_mode" id="arch_mode" type="checkbox" 
                                onclick="if (this.checked)
                                {
                                    nxt.arch_mode_hd.value='1';
                                    cf.arch_mode_hd.value='1';
                                    std_acad_hist.arch_mode_hd.value='1';
                                    chk_pay_sta.arch_mode_hd.value='1';
                                    vw_std_acnt_stff.arch_mode_hd.value='1';
                                    std_stat.arch_mode_hd.value='1';
                                    std_stat_loc.arch_mode_hd.value='1';
                                }else
                                {
                                    nxt.arch_mode_hd.value='0';
                                    cf.arch_mode_hd.value='0';
                                    std_acad_hist.arch_mode_hd.value='0';
                                    chk_pay_sta.arch_mode_hd.value='0';
                                    vw_std_acnt_stff.arch_mode_hd.value='0';
                                    std_stat.arch_mode_hd.value='0';
                                    std_stat_loc.arch_mode_hd.value='0';
                                }" 
                                <?php if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1'){echo 'checked';} ?>/>
                        </div>
                        <div class="div_select" style="width:130px; height:25px; padding:5px; margin-right:0px; background:#f3f3f3">
                            Look in the archive
                        </div>                   
                    </label>
                </div><?php
            }*/?>
            <form action="check-student-status" method="post" name="std_stat_loc" id="std_stat_loc" enctype="multipart/form-data">
                <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST['user_cat'];} ?>" />	
                <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                <input name="save_cf" id="save_cf" type="hidden" value="-1" />
                <input name="conf" id="conf" type="hidden" value="" />
                <input name="tabno" id="tabno" type="hidden" 
                    value="<?php if (isset($_REQUEST['save_cf'])){echo $_REQUEST['tabno'];}else{echo '0';} ?>"/>
                <input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                <input name="frm_upd" id="frm_upd" type="hidden" />
                <input name="numOfiputTag" id="numOfiputTag" type="hidden" value="0"/>

				<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>

                <?php frm_vars(); ?>
                <div class="innercont_stff" style="margin-bottom:3px; padding-top:3px">
					<div class="div_select">
                        <select name="id_no" id="id_no" class="select" 
							onchange="if (this.value!='')
							{
								std_stat_loc.uvApplicationNo.value='';
								std_stat_loc.uvApplicationNo.style.display='block';
								if (this.value==0)
								{
									std_stat_loc.uvApplicationNo.type='number';
									td_stat_loc.uvApplicationNo.maxlength=8;
								}else if (this.value==1)
								{
									std_stat_loc.uvApplicationNo.type='text';
									td_stat_loc.uvApplicationNo.maxlength=12;
								}
							}else
							{
								
								std_stat_loc.uvApplicationNo.style.display='none';
							}">
                            <option value="">Select option</option>
                            <option value="0">Application form number</option>
                            <option value="1">Matriculation number for</option>
                        </select>
					</div>
                    <div class="div_select">
                        <input name="uvApplicationNo" id="uvApplicationNo" 
						type="number" 
						style="display:none" 
						class="textbox"
						onkeypress="if (this.type=='number')
						{
							if (this.value.length==8)
							{
								return false;
							}	
						}if (this.type=='text')
						{
							if (this.value.length==12)
							{
								return false;
							}	
						}"/>
                    </div>
                    <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
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
<!-- InstanceEnd --></html>