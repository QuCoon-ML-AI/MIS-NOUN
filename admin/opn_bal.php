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
        
        var formdata = new FormData();

        if (_('mode_proc').checked)
        {        
            var files = _("sbtd_pix").files;
            if (!csvfileValidation("sbtd_pix") || _("sbtd_pix").files.length == 0)
            {
                setMsgBox("labell_msg2","Select a csv file to upload");
                return false;
            }
            
            if (files.length > 0)
            {
                formdata.append("sbtd_pix", _("sbtd_pix").files[0]);
            }

            if (opn_bal_loc.conf.value != '1')
            {
                _('conf_box_loc').style.display = 'block';
                _('conf_box_loc').style.zIndex = '3';
                _('smke_screen_2').style.display = 'block';
                _('smke_screen_2').style.zIndex = '2';

                return false;
            }
        }else
        {
            if (opn_bal_loc.vMatricNo.value == '')
            {
                setMsgBox("labell_msg0","");
                opn_bal_loc.vMatricNo.focus();
                return;
            }
            
            if (opn_bal_loc.new_balance.value.trim() == '')
            {
                setMsgBox("labell_msg1","");
                opn_bal_loc.new_balance.focus();
                return;
            }
            
            if (opn_bal_loc.narat.value.trim() == '')
            {
                setMsgBox("labell_msg3","");
                opn_bal_loc.narat.focus();
                return;
            }
            
            _('conf_box_loc').style.display='none';
            _('smke_screen_2').style.display='none';
            _('conf_box_loc').style.zIndex='-1';
            _('smke_screen_2').style.zIndex='-1';
        }
               
        
        if (opn_bal_loc.conf.value == '1')
        {            
            formdata.append("conf", opn_bal_loc.conf.value);
            formdata.append("new_balance", opn_bal_loc.new_balance.value);
            formdata.append("narat", opn_bal_loc.narat.value);
        }
        

        
        formdata.append("ilin", opn_bal_loc.ilin.value);
        formdata.append("user_cat", _('user_cat').value);
        formdata.append("vApplicationNo", opn_bal_loc.vApplicationNo.value);
        //formdata.append("save", _("save_cf").value);
        
        //formdata.append("rrr", opn_bal_loc.rrr.value.trim());
        //formdata.append("orderId", rect_rrr.orderId.value.trim());
        //formdata.append("vDesc_loc", rect_rrr.vDesc_loc.options[rect_rrr.vDesc_loc.selectedIndex].text);
        
        //formdata.append("f_item_id", rect_rrr.vDesc_loc.value);
        
        //formdata.append("iStudy_level", _("iStudy_level").value);
        //formdata.append("tSemester", _("tSemester").value);
        
        //formdata.append("arch_mode_hd", rect_rrr.arch_mode_hd.value);
        formdata.append("uvApplicationNo", opn_bal_loc.uvApplicationNo.value);
        formdata.append("vMatricNo", opn_bal_loc.vMatricNo.value);

        // if (_('t_sent').value == 1)
        // {
        //     formdata.append("t_sent", _('t_sent').value);
        // }

        formdata.append("sm", opn_bal_loc.sm.value);
        formdata.append("mm", opn_bal_loc.mm.value);
        
        //if (opn_bal_loc.conf.value == '1')
        //{
            //formdata.append("conf", '1');
            //formdata.append("amount", opn_bal_loc.amount.value);
            // formdata.append("payername", opn_bal_loc.payername.value);
            // formdata.append("payerphone", opn_bal_loc.payerphone.value);
            // formdata.append("cEduCtgId", opn_bal_loc.cEduCtgId.value);
        //}
        
        opr_prep(ajax = new XMLHttpRequest(),formdata);
    }
        

    function opr_prep(ajax,formdata)
    {
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        
        ajax.open("POST", "opr_opn_bal.php");
        ajax.send(formdata);
    }

    function completeHandler(event)
    {
        // if (event.target.responseText.indexOf("token:") != -1)
        // {
        //     return;
        // }

        on_error('0');
        on_abort('0');
        in_progress('0');

        var mask = '';

        var returnedStr = event.target.responseText;
        
        if (returnedStr.indexOf("success") != -1)
        {
            success_box(returnedStr);
        }else if (returnedStr.indexOf("Invalid") != -1)
        {
            caution_box(returnedStr);
        }else
        {
            _('conf_box_loc').style.display='none';
            _('smke_screen_2').style.display='none';
            _('conf_box_loc').style.zIndex='-1';
            _('smke_screen_2').style.zIndex='-1';

            if (!_('mode_proc').checked)
            {
                if (opn_bal_loc.conf.value != '1')
                {
                    const myArray = returnedStr.split("#");

                    _("name_div_val").innerHTML = myArray[0];

                    _("faculty_div_val").innerHTML = myArray[1];
                    _("dept_div_val").innerHTML = myArray[2];
                    _("prog_div_val").innerHTML = myArray[3];
                    
                    _("ent_level_div_val").innerHTML = myArray[4];
                    _("cur_level_div_val").innerHTML = myArray[5];
                    _("sem_div_val").innerHTML = myArray[6];
                    
                    _("cent_div_val").innerHTML = myArray[7];
                    _("phone_div_val").innerHTML = myArray[8];
                        
                    _('conf_box_loc').style.display = 'block';
                    _('conf_box_loc').style.zIndex = '3';
                    _('smke_screen_2').style.display = 'block';
                    _('smke_screen_2').style.zIndex = '2';
                    

                    _("all_div").style.display = 'block';
                    
                    return;
                }
            }

            if (opn_bal_loc.conf.value == '1')
            {
                caution_box(returnedStr);
            }
        }

        opn_bal_loc.conf.value = '';
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
        
        formdata.append("ilin", opn_bal_loc.ilin.value);
        formdata.append("user_cat", _('user_cat').value);
        formdata.append("vApplicationNo", _('vApplicationNo').value);
        formdata.append("uvApplicationNo", opn_bal_loc.uvApplicationNo.value);
        
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
    <div id="conf_box_loc" class="center" style="display:none; width:400px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
        <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
            Confirmation
        </div>
        <a href="#" style="text-decoration:none;">
            <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
        </a>
        <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:100%; float:left; text-align:center; padding:0px;">Continue?</div>
        <div style="margin-top:10px; width:100%; float:left; text-align:right; padding:0px;">
            <a href="#" style="text-decoration:none;" 
                onclick="opn_bal_loc.conf.value = '1';
                chk_inputs(); 
                return false">
                <div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
                    Yes
                </div>
            </a>

            <a href="#" style="text-decoration:none;" 
                onclick="opn_bal_loc.conf.value='';
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
        <div id="container_cover_in_chkps" class="center" style="display: none; 
            flex-direction:column; 
            gap:8px;  
            justify-content:space-around; 
            height:auto;
            padding:10px;
            box-shadow: 2px 2px 8px 2px #726e41;
            z-Index:3;
            background-color:#fff;" title="Press escape to close">
                <div style="line-height:1.5; width:70%; font-weight:bold">
                    Required columns
                </div>
                <div style="line-height:1.5; width:20; position:absolute; top:10px; right:10px;">
                    <img style="width:17px; height:17px; cursor:pointer" src="./img/close.png" 
                    onclick="_('container_cover_in_chkps').style.zIndex = -1;
                        _('container_cover_in_chkps').style.display = 'none';"/>
                </div>

                <div style="line-height:1.4; padding:8px 5px 8px 5px; width:99%; background-color: #fdf0bf;">
                    Required columns in the csv file to be uploaded are:
                </div>

                <div style="line-height:2;">
                    <ol>
                        <li>
                            Matriculation number
                        </li>
                        <li>
                            New balance
                        </li>
                        <li>
                            Naration
                        </li>
                    </ol>
                </div>
            </div>
		<!-- InstanceBeginEditable name="EditRegion6" --><?php
        $transaction_url = '';
        $rrr = '';
        $hash = '';
        //$orderId = '';

        //$responseurl = PATH . "/feed-back-from-rem";
        $amount = '';
        
        $session = $orgsetins['cAcademicDesc'];
        
        //$response_code = '';
        //$response_message = '';
        //$transactiontime = '';?>
		<div class="innercont_top">Adjust opening balance</div>
        
        <form method="post" name="opn_bal_loc" id="opn_bal_loc" enctype="multipart/form-data">
            <input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
            <input name="uvApplicationNo" id="uvApplicationNo" type="hidden" />
            
            <!-- <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST['vMatricNo'])){echo $_REQUEST['vMatricNo']; }?>" /> -->
            <input name="mm" id="mm" type="hidden" value="<?php if (isset($_REQUEST["mm"])){echo $_REQUEST["mm"];} ?>" />
            
            <input name="sm" id="sm" type="hidden" value="<?php if (isset($_REQUEST["sm"])){echo $_REQUEST["sm"];} ?>" />
            
            <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
            
            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
            <input name="save_cf" id="save_cf" type="hidden" value="-1" />
            <input name="conf" id="conf" type="hidden" value="" />
            
            <!-- <input name="vLastName" type="hidden" value="<?php //echo strtoupper($vLastName);?>" />
            <input name="vFirstName" type="hidden" value="<?php //echo ucwords(strtolower($vFirstName));?>" />
            <input name="vOtherName" type="hidden" value="<?php //echo ucwords(strtolower($vOtherName));?>" /> -->

            <input name="iStudy_level" id="iStudy_level" type="hidden"/>
            <input name="tSemester" id="tSemester" type="hidden"/>
            
            <!-- <input id="cEduCtgId" name="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST["cEduCtgId"])){echo $_REQUEST["cEduCtgId"];} ?>"/> -->
            
            <input name="app_frm_no" id="app_frm_no" type="hidden" />
            <input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />

            <!--<input name="service_mode" id="service_mode" type="hidden" 
            value="<?php //if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
            //else if (isset($study_mode)){echo $study_mode;}?>" />
            <input name="num_of_mode" id="num_of_mode" type="hidden" 
            value="<?php //if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
            //else if (isset($num_of_mode)){echo $num_of_mode;}?>" />-->

            <input name="user_centre" id="user_centre" type="hidden" 
            value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
            else if (isset($study_mode)){echo $study_mode;}?>" />
            <input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
            value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
            else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
		
            <input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>

            <div id="succ_boxt" class="succ_box blink_text orange_msg" style="margin-top:0px; color:#FF3300; line-height:1.8; width:98.5%; display:none"></div>

            <fieldset style="border-radius:3px; width:97.8%; float:left; border:1px solid #ccc;">
                <legend style="font-size:13px">Use for batch processing- Two columns, Matric number and new balance</legend>
                <div id="inmate_div" class="innercont_stff" style="margin-top:5px;">
                    <label class="labell" style="width:220px; margin-left:5px;"></label>
                    <div class="div_select">
                        <label for="mode_proc" class="labell" style="width:auto; text-align:left; cursor:pointer;">
                            <input id="mode_proc" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"
                                onclick="if (this.checked)
                                {
                                    _('sbtd_pix').disabled = false;

                                    _('all_div').style.display = 'none';
                                    opn_bal_loc.vMatricNo.disabled = true;
                                    opn_bal_loc.new_balance.disabled = true;
                                    opn_bal_loc.narat.disabled = true;
                                    
                                    _('container_cover_in_chkps').style.zIndex = 2;
                                    _('container_cover_in_chkps').style.display='flex';
                                }else 
                                {
                                    _('sbtd_pix').disabled = true;
                                    
                                    opn_bal_loc.vMatricNo.disabled = false;
                                    opn_bal_loc.new_balance.disabled = false;
                                    opn_bal_loc.narat.disabled = false;
                                            
                                    _('container_cover_in_chkps').style.zIndex = -1;
                                    _('container_cover_in_chkps').style.display='none';
                                }

                                var ulChildNodes = _('rtlft_std').getElementsByClassName('labell_msg');
                                for (j = 0; j <= ulChildNodes.length-1; j++)
                                {
                                    ulChildNodes[j].style.display = 'none';
                                }"
                                
                                <?php if ($sRoleID_u == 10){echo 'disabled';}?>/>
                                Bulk processing
                        </label>
                    </div>
                </div>

                <div class="innercont_stff" style="margin-top:20px; margin-bottom:10px;">
                    <label for="adj_type" class="labell" style="width:220px;">Select file to upload</label>
                    <div class="div_select">
                        <input type="file" name="sbtd_pix" id="sbtd_pix" style="width:180px" title="upload csv file" disabled>
                    </div>
                    <div id="labell_msg2" class="labell_msg blink_text orange_msg" style="width:280px;"></div>
                </div>
            </fieldset>

            <div class="innercont_stff" style="margin-bottom:3px;margin-top:10px;">
                <label for="vMatricNo" class="labell" style="width:220px; margin-left:7px;">
                    Matriculation number
                </label>
                <div class="div_select">
                <input name="vMatricNo" id="vMatricNo" 
                type="text"
                onkeypress="if(this.value.length==12){return false}" 
                onchange="this.value=this.value.trim();
                this.value=this.value.toUpperCase();" 
                class="textbox" 
                style="text-transform:none"
                autocomplete="off" 
                value="" />
                </div>
                <div id="labell_msg0" class="labell_msg blink_text orange_msg" style="float:left"></div>
            </div>
            
            <div class="innercont_stff" style="margin-bottom:3px;">
                <label for="new_balance" class="labell" style="width:220px; margin-left:7px;">
                    New balance (N)
                </label>
                <div class="div_select">
                <input name="new_balance" id="new_balance" 
                type="number"
                class="textbox" 
                style="text-transform:none"
                autocomplete="off" 
                value="" />
                </div>
                <div id="labell_msg1" class="labell_msg blink_text orange_msg" style="float:left"></div>
            </div>
            
            <div class="innercont_stff" style="margin-bottom:3px;">
                <label for="narat" class="labell" style="width:220px; margin-left:7px;">
                    Naration
                </label>
                <div class="div_select">
                <input name="narat" id="narat"
                    onchange="this.value=this.value.trim();"
                    type="text"
                    class="textbox" 
                    style="text-transform:none"
                    autocomplete="off" 
                    value="" />
                </div>
                <div id="labell_msg3" class="labell_msg blink_text orange_msg" style="float:left"></div>
            </div>

            <div id="all_div" style="display:none">
                <div id="name_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;">
                        Name
                    </div>
                    <div id="name_div_val" class="div_valu" style="font-weight:bold"></div>	
                </div>
                
                <div id="faculty_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;">
                        Faculty
                    </div>
                    <div id="faculty_div_val" class="div_valu" style="font-weight:bold"></div>	
                </div>

                <div id="dept_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;">
                        Department
                    </div>
                    <div id="dept_div_val" class="div_valu" style="font-weight:bold"></div>	
                </div>

                <div id="prog_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;">
                        Programme
                    </div>
                    <div id="prog_div_val" class="div_valu" style="font-weight:bold"></div>	
                </div>
                
                <div id="ent_level_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;">
                        Entry level
                    </div>
                    <div id="ent_level_div_val" class="div_valu" style="font-weight:bold"></div>	
                </div>
                
                <div id="cur_level_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;">
                        Current level
                    </div>
                    <div id="cur_level_div_val" class="div_valu" style="font-weight:bold"></div>	
                </div>
                
                <div id="sem_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;">
                        Semester
                    </div>
                    <div id="sem_div_val" class="div_valu" style="font-weight:bold"></div>	
                </div>
                
                <div id="cent_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;">
                        Study centre
                    </div>
                    <div id="cent_div_val" class="div_valu" style="font-weight:bold;"></div>	
                </div>
                
                <div id="phone_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;">
                        Phone number
                    </div>
                    <div id="phone_div_val" class="div_valu" style="font-weight:bold;"></div>	
                </div>
                
                <!-- <div id="purp_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;">
                        Purpose
                    </div>
                    <div id="purp_div_val" class="div_valu" style="font-weight:bold;"></div>	
                </div> -->
                
                <!-- <div id="date_div" class="innercont_stff">
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
                
                <div id="loc_status_div" class="innercont_stff">
                    <div class="div_label" style="width:220px; margin-left:7px;"></div>
                    <div id="loc_status_div_val" class="div_valu" style="font-weight:bold;"></div>	
                </div>-->
                
                <input name="t_sent" id="t_sent" type="hidden"/><?php 
                /*if (check_scope3('Bursary', 'Check payment satatus', 'Modify') > 0)
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
                                rect_rrr.conf.value='1';
                            }else
                            {
                                _('conf_box_loc').style.display='none';
                                _('conf_box_loc').style.zIndex='-1';
                                _('smke_screen_2').style.display='none';
                                _('smke_screen_2').style.zIndex='-1';
                                rect_rrr.conf.value='';
                            }"/>
                        </div>							
                        <div class="innercont" style="width:auto; height:16px; float:left; padding-top:3px; margin-left:5px">
                            <label for="payment_confirmed_successful">
                                Payment confirmed successful
                            </label>
                        </div>                    
                    </div><?php
                }*/?>
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