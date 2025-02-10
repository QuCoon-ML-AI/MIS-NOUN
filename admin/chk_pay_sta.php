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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/applform.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php
require_once('var_colls.php');

require_once ('../appl/remita_constants.php');

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
        var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
        for (j = 0; j <= ulChildNodes.length-1; j++)
        {
            ulChildNodes[j].style.display = 'none';
        }
        
        if (chk_pay_sta_loc.rrr.value.trim() == '' && chk_pay_sta_loc.orderId.value.trim() == '')
        {
            setMsgBox("labell_msg0","Please fill one of the boxes. Number only");
            setMsgBox("labell_msg1","Please fill one of the boxes. Number only");
            chk_pay_sta_loc.rrr.focus();
            return;
        }
        
        if (chk_pay_sta_loc.vDesc_loc.value == '')
        {
            setMsgBox("labell_msg2","");
            chk_pay_sta_loc.vDesc_loc.focus();
            return;
        }

        var formdata = new FormData();
               
        
        if (chk_pay_sta_loc.conf.value == '1')
        {            
            formdata.append("conf", chk_pay_sta_loc.conf.value);   
            formdata.append("user_token", _('veri_token').value);        
        }
        
        formdata.append("ilin", chk_pay_sta_loc.ilin.value);
        formdata.append("user_cat", _('user_cat').value);
        formdata.append("vApplicationNo", _('vApplicationNo').value);
        formdata.append("save", _("save_cf").value);
        
        formdata.append("rrr", chk_pay_sta_loc.rrr.value.trim());
        formdata.append("orderId", chk_pay_sta_loc.orderId.value.trim());
        formdata.append("vDesc_loc", chk_pay_sta_loc.vDesc_loc.options[chk_pay_sta_loc.vDesc_loc.selectedIndex].text);
        
        formdata.append("f_item_id", chk_pay_sta_loc.vDesc_loc.value);
        
        formdata.append("iStudy_level", _("iStudy_level").value);
        formdata.append("tSemester", _("tSemester").value);
        
        formdata.append("arch_mode_hd", chk_pay_sta_loc.arch_mode_hd.value);
        formdata.append("uvApplicationNo", chk_pay_sta_loc.uvApplicationNo.value);

        if (_('t_sent').value == 1)
        {
            formdata.append("t_sent", _('t_sent').value);
        }

        formdata.append("sm", chk_pay_sta_loc.sm.value);
        formdata.append("mm", chk_pay_sta_loc.mm.value);
        
        opr_prep(ajax = new XMLHttpRequest(),formdata);
    }
        

    function opr_prep(ajax,formdata)
    {
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        
        ajax.open("POST", "trn_state");
        ajax.send(formdata);
    }

    function completeHandler(event)
    {
        if (event.target.responseText.indexOf("token:") != -1)
        {
            return;
        }

        on_error('0');
        on_abort('0');
        in_progress('0');

        var mask = '';

        var returnedStr = event.target.responseText;
        
        //caution_box(returnedStr);
        //return;
        
                
        if (returnedStr == 'Invalid token')
        {
            caution_box(returnedStr)
        }else if (returnedStr.trim() == 'Invalid ID' || returnedStr.trim() == '' || returnedStr.trim() == 0.00)
        {
            _("succ_boxt").style.display = 'block';
            if (chk_pay_sta_loc.arch_mode_hd.value == '1')
            {
                _("succ_boxt").innerHTML = 'Record not in the archive';
            }else
            {
                _("succ_boxt").innerHTML = 'Not found. Please check your entries and selection for possible error(s) and try again';
            }

            _("all_div").style.display = 'none';
        }else
        {
            //check remitta end for status
            
             _("succ_boxt").style.display = 'none';

            _("app_frm_no").value = returnedStr.substr(0,50).trim();

            chk_pay_sta_loc.uvApplicationNo.value = returnedStr.substr(0,50).trim();

            _("name_div_val").innerHTML = returnedStr.substr(50, 100).trim();
            _("mail_div_val").innerHTML = returnedStr.substr(150, 50).trim();

            _("phone_div_val").innerHTML = returnedStr.substr(200, 50).trim();		
            _("amount_div_val").innerHTML = returnedStr.substr(250, 50).trim();

            _("purp_div_val").innerHTML = returnedStr.substr(300, 50).trim();
            
            _("status_div_val").innerHTML = returnedStr.substr(350, 50).trim();
            _("status_div").style.color = '#ff6315';
            if (_("status_div_val").innerHTML == 'Successful')
            {
                _("status_div").style.color = '#1a9201';
            }
            
            if (_('payment_confirmed_successful_div'))
            {
                if (_("status_div_val").innerHTML.trim() != 'Successful')
                {
                    _('payment_confirmed_successful_div').style.display = 'block';
                }else
                {
                    _('payment_confirmed_successful_div').style.display = 'none';
                }
            }

            _("date_div_val").innerHTML = returnedStr.substr(400, 50).trim();
            _("all_div").style.display = 'block';
            
            if (returnedStr.substr(300, 50).trim() == 'Application Fee')
            {
                _("id_div_val").innerHTML = returnedStr.substr(0, 50).trim();
            }else
            {
                _("id_div_val").innerHTML = returnedStr.substr(500, 50).trim();
            }

            if (_("id_div_val").innerHTML == '')
            {
                _("id_div_val").innerHTML = 'Matric. no. not yet assigned'
            }
            
            _("iStudy_level").value = returnedStr.substr(550, 50).trim();
            srtudent_faculty = returnedStr.substr(600, 50).trim().toLowerCase();
            chk_pay_sta_loc.cEduCtgId.value = returnedStr.substr(650, 50).trim();
            mask = returnedStr.substr(700).trim();

            _("passprt").src = mask;
            _("passprt").onerror = function() {myFunction()};

           function myFunction()
            {
                _("passprt").src = 'img/p_.png'
            }
            
            if (_('status_message') && _('status_message').style.display == 'block')
            {
                _('status_message').style.display == 'none';
            }

            chk_pay_sta_loc.conf.value = '';
        }

        _('t_sent').value = '';
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


    function get_token()
    {
        var formdata = new FormData();
        
        formdata.append("ilin", chk_pay_sta_loc.ilin.value);
        formdata.append("user_cat", _('user_cat').value);
        formdata.append("vApplicationNo", _('vApplicationNo').value);
        formdata.append("uvApplicationNo", chk_pay_sta_loc.uvApplicationNo.value);
        
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler_t, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        
        ajax.open("POST", "get_permt");
        ajax.send(formdata);
    }

    function completeHandler_t(event)
    {
        on_error('0');
        on_abort('0');
        in_progress('0');
        _('t_sent').value = 1;

        _('veri_token').value = '';
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
        <input name="resend_req" id="resend_req" type="hidden" value="" />
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
<div id="container">
    <div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
    <div id="conf_box_loc" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
        <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
            Confirmation
        </div>
        <a href="#" style="text-decoration:none;">
            <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
        </a>
        <div id="submityes0" 
            style="border-radius:3px; margin:auto; margin-top:30px; margin-bottom:5px; height:auto; width:99%; text-align:center; padding:15px 0px 15px 0px; background:#f1f1f1">
            <div style="width:auto; margin:auto; margin-bottom:5px; padding:0px; width:95%; float:none; line-height:2.0;">
                Check your official e-mail in-box for a token to use for this session<br>Token expires in 10minutes
            </div>
            <div style="margin:auto; margin-top:10px; height:auto; text-align:center; padding:0px; width:95%;">
                <input name="veri_token" id="veri_token" type="text" class="textbox" 
                placeholder="Enter token here..."
                autocomplete="off"
                style="float:none; width:50%; padding:5px; text-align:center; height:25px"/>
                <div id="labell_msg_token" class="labell_msg blink_text orange_msg" style="float:none; text-align:center; display:none; width:50%; margin:auto; margin-top:10px;"></div>
            </div>
            
            <div id="resend_token_div" style="display:none; margin:auto; margin-top:10px; height:auto; text-align:center; padding:0px; width:95%;">
                <a href="#" style="text-decoration:none;" 
                    onclick="get_token(); return false">
                    <div class="submit_button_green" style="width:120px; margin:auto; padding:8px;">
                        Resend token
                    </div>
                </a>
            </div>
        </div>
        <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;">
            Payment confirmed successful?
        </div>
        <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
            <a href="#" style="text-decoration:none;" 
                onclick="if (_('veri_token').value.trim() == '')
                {
                    setMsgBox('labell_msg_token','Token required');
                    return false;
                }
                _('conf_box_loc').style.display='none';
                _('smke_screen_2').style.display='none';
                _('smke_screen_2').style.zIndex='-1';
                chk_pay_sta_loc.conf.value='1';
                chk_inputs();
                return false">
                <div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
                    Yes
                </div>
            </a>

            <a href="#" style="text-decoration:none;" 
                onclick="_('conf_box_loc').style.display='none';
                _('smke_screen_2').style.display='none';
                _('smke_screen_2').style.zIndex='-1';
                chk_pay_sta_loc.conf.value='';
                _('payment_confirmed_successful').checked=false;
                _('veri_token').value='';
                return false">
                <div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
                    No
                </div>
            </a>
        </div>
    </div>

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
		<!-- InstanceBeginEditable name="EditRegion6" --><?php
        $transaction_url = '';
        $rrr = '';
        $hash = '';
        $orderId = '';
        $responseurl = PATH . "/feed-back-from-rem";
        $amount = '';
        
        $session = $orgsetins['cAcademicDesc'];
        
        $response_code = '';
        $response_message = '';
        $transactiontime = '';?>
		<div class="innercont_top">Check payement status</div>
        
        <form method="post" name="chk_pay_sta_loc" id="chk_pay_sta_loc" enctype="multipart/form-data">
            <input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
            <input name="uvApplicationNo" id="uvApplicationNo" type="hidden" />
            
            <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST['vMatricNo'])){echo $_REQUEST['vMatricNo']; }?>" />
            <input name="mm" id="mm" type="hidden" value="<?php if (isset($_REQUEST["mm"])){echo $_REQUEST["mm"];} ?>" />
            
            <input name="sm" id="sm" type="hidden" value="<?php if (isset($_REQUEST["sm"])){echo $_REQUEST["sm"];} ?>" />
            
            <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
            
            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
            <input name="save_cf" id="save_cf" type="hidden" value="-1" />
            <input name="conf" id="conf" type="hidden" value="" />
            
            <input name="vLastName" type="hidden" value="<?php echo strtoupper($vLastName);?>" />
            <input name="vFirstName" type="hidden" value="<?php echo ucwords(strtolower($vFirstName));?>" />
            <input name="vOtherName" type="hidden" value="<?php echo ucwords(strtolower($vOtherName));?>" />

            <input name="iStudy_level" id="iStudy_level" type="hidden"/>
            <input name="tSemester" id="tSemester" type="hidden"/>            
            
            <input id="cEduCtgId" name="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST["cEduCtgId"])){echo $_REQUEST["cEduCtgId"];} ?>"/>
            
            <input name="app_frm_no" id="app_frm_no" type="hidden" />
            <input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />

            <input name="service_mode" id="service_mode" type="hidden" 
            value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
            else if (isset($study_mode)){echo $study_mode;}?>" />
            <input name="num_of_mode" id="num_of_mode" type="hidden" 
            value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
            else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

            <input name="user_centre" id="user_centre" type="hidden" 
            value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
            else if (isset($study_mode)){echo $study_mode;}?>" />
            <input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
            value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
            else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
		
            <input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>

            <div id="succ_boxt" class="succ_box blink_text orange_msg" style="margin-top:0px; color:#FF3300; line-height:1.8; width:98.5%; display:none"></div><?php 
			/*if (check_scope2('Academic registry','Archive') > 0 && isset($_REQUEST["mm"]) && $_REQUEST["mm"] == 4)
			{?>
				<div class="innercont_stff">
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
									chk_pay_sta_loc.arch_mode_hd.value='1';
								}else
								{
									nxt.arch_mode_hd.value='0';
									cf.arch_mode_hd.value='0';
									std_acad_hist.arch_mode_hd.value='0';
									chk_pay_sta.arch_mode_hd.value='0';
									vw_std_acnt_stff.arch_mode_hd.value='0';
									std_stat.arch_mode_hd.value='0';
									chk_pay_sta_loc.arch_mode_hd.value='0';
								}" 
								<?php if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1'){echo 'checked';} ?>/>
						</div>
						<div class="div_select" style="width:130px; height:25px; padding:5px; margin-right:0px; background:#f3f3f3">
							Look in the archive
						</div>                   
					</label>
				</div><?php
			}*/?>

            <div class="succ_box blue_msg" style="float:left; width:98.5%; display:block">
                Enter either RRR or order ID
            </div>

            <div class="innercont_stff" style="margin-bottom:3px;">
                <label for="rrr" class="labell" style="width:220px; margin-left:7px;"><?php
                    if ($orgsetins['rr_sys'] == '1'){echo 'Remita retrieval reference (RRR)';}else{echo 'Payment code';}?>
                </label>
                <div class="div_select">
                <input name="rrr" id="rrr" 
                    type="number"
                    onkeypress="if(this.value.length==12){return false}" 
                    class="textbox"
                    autocomplete="off"/>
                </div>
                <div id="labell_msg0" class="labell_msg blink_text orange_msg" style="float:left"></div>
            </div>
            <div class="innercont_stff" style="margin-bottom:3px;">
                <label for="orderId" class="labell" style="width:220px; margin-left:7px;">
                    Oreder ID
                </label>
                <div class="div_select">
                <input name="orderId" id="orderId" 
                type="number"
                onkeypress="if(this.value.length==12){return false}"  
                class="textbox" 
                style="text-transform:none"
                autocomplete="off" 
                value="" />
                </div>
                <div id="labell_msg1" class="labell_msg blink_text orange_msg" style="float:left"></div>
            </div>
            <div class="innercont_stff" style="margin-bottom:3px;"><?php
                $rs_sql = mysqli_query(link_connect_db(), "SELECT fee_item_id, fee_item_desc FROM fee_items WHERE fee_item_id IN ('3','71','31') ORDER BY fee_item_desc") or die(mysqli_error(link_connect_db()));?>
                <label for="vDesc_loc" class="labell" style="width:220px; margin-left:7px;">
                    Purpose of payment
                </label>
                <div class="div_select">
                <select name="vDesc_loc" id="vDesc_loc" class="select">
                    <option value="" selected></option><?php
                    $c = 0;
                    while ($rs = mysqli_fetch_array($rs_sql))
                    {
                        $c++;
                        if ($c%5==0)
                        {?>
                            <option disabled></option><?php
                        }?>
                        <option value="<?php echo $rs['fee_item_id'];?>">
                            <?php echo $rs['fee_item_desc'];?>
                        </option><?php
                    }
                    mysqli_close(link_connect_db());?>
                    </select>
                </div>
                <div id="labell_msg2" class="labell_msg blink_text orange_msg" style="float:left"></div>
            </div>

            <div id="all_div" style="display:none">
                <div id="id_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;">
                        Application form no./Matric. no.
                    </div>
                    <div id="id_div_val" class="div_valu" style="font-weight:bold"></div>	
                </div>

                <div id="name_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;">
                        Name
                    </div>
                    <div id="name_div_val" class="div_valu" style="font-weight:bold"></div>	
                </div>
                
                <div id="mail_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;">
                        eMail address
                    </div>
                    <div id="mail_div_val" class="div_valu" style="font-weight:bold"></div>	
                </div>
                
                <div id="phone_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;">
                        Phone
                    </div>
                    <div id="phone_div_val" class="div_valu" style="font-weight:bold;"></div>	
                </div>
                
                <div id="purp_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;">
                        Purpose
                    </div>
                    <div id="purp_div_val" class="div_valu" style="font-weight:bold;"></div>	
                </div>
                
                <div id="date_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;">
                        Date
                    </div>
                    <div id="date_div_val" class="div_valu" style="font-weight:bold;"></div>	
                </div>
                
                <div id="amount_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;">
                        Amount
                    </div>
                    <div id="amount_div_val" class="div_valu" style="font-weight:bold;"></div>	
                </div>
                
                <div id="status_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;">
                        Status
                    </div>
                    <div id="status_div_val" class="div_valu" style="font-weight:bold;"></div>	
                </div>
                
                <input name="t_sent" id="t_sent" type="hidden"/><?php 
                if (check_scope3('Bursary', 'Check payment satatus', 'Modify') > 0)
                {?>
                    <div id="payment_confirmed_successful_div" class="innercont_stff" style="margin-top:5px; border-top:1px solid #ccc; padding-top:5px;">
                        <div class="innercont" style="width:16px; float:left; height:19px; margin-right:3px;  margin-left:180px">
                            <input name="payment_confirmed_successful" id="payment_confirmed_successful" type="checkbox" 
                            onclick="if(this.checked)
                            {
                                get_token();
                                _('conf_box_loc').style.display='block';
                                _('conf_box_loc').style.zIndex='3';
                                _('smke_screen_2').style.display='block';
                                _('smke_screen_2').style.zIndex='2';
                                chk_pay_sta_loc.conf.value='1';
                            }else
                            {
                                _('conf_box_loc').style.display='none';
                                _('conf_box_loc').style.zIndex='-1';
                                _('smke_screen_2').style.display='none';
                                _('smke_screen_2').style.zIndex='-1';
                                chk_pay_sta_loc.conf.value='';
                            }"/>
                        </div>							
                        <div class="innercont" style="width:auto; height:16px; float:left; padding-top:3px; margin-left:5px">
                            <label for="payment_confirmed_successful">
                                Payment confirmed successful
                            </label>
                        </div>                    
                    </div><?php
                }?>
            </div>
        </form>
		<!-- InstanceEndEditable -->
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