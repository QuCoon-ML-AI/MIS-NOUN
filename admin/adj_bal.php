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
<link rel="icon" type="image/ico" href="img/left_side_logo.png" />
<!-- InstanceEndEditable -->




<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
<script language="JavaScript" type="text/javascript" src="button_ops.js"></script>
<script language="JavaScript" type="text/javascript" src="./bamboo/adjbal.js"></script>
<script language="JavaScript" type="text/javascript">
    function chk_inputs()
    {
        var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
        for (j = 0; j <= ulChildNodes.length-1; j++)
        {
            ulChildNodes[j].style.display = 'none';
        }
        
        var formdata = new FormData();

        var files = _("sbtd_pix").files;
        if (_('mode_proc').checked)
        {        
            if (!csvfileValidation("sbtd_pix") || _("sbtd_pix").files.length == 0)
            {
                setMsgBox("labell_msg4","Select a csv file to upload");
                return false;
            }
            
            if (files.length > 0)
            {
                formdata.append("sbtd_pix", _("sbtd_pix").files[0]);
            }
        }else
        {
                
            if (_('adj_bal_loc').uvApplicationNo.value == '')
            {
                setMsgBox("labell_msg0","");
                _('adj_bal_loc').uvApplicationNo.focus();
                return false;
            }else if (_('adj_type').value == '')
            {
                setMsgBox("labell_msg1","");
                _("adj_type").focus();
                return false;
            }else if (_("adj_amnt").value == '' || _("adj_amnt").value <= 0)
            {
                setMsgBox("labell_msg2","Ammount can neither be 0 nor empty");
                _("adj_amnt").focus();
                return false;
            }/*else if (_('rrr_div').style.display == 'block' && _("rrr").value == '')
            {
                setMsgBox("labell_msg3","");
                _("rrr").focus();
                return false;
            }else*/ if (_("vDesc_loc").value.trim() == '')
            {
                setMsgBox("labell_msg5","");
                _("vDesc_loc").focus();
                return false;
            }/*else if (_('dbt_div').style.display == 'block' && _("vremark").value == '')
            {
                setMsgBox("labell_msg6","");
                _("vremark").focus();
            }*/else if (_('adj_bal_loc').conf.value == '')
            {
                /*if (_('adj_type').value == 'c')
                {
                    _("conf_msg_msg_loc").innerHTML = 'The RRR identifies a successful transaction?';
                }else
                {
                    _("conf_msg_msg_loc").innerHTML = 'Are you sure about this ?';
                }*/
                
                _("conf_msg_msg_loc").innerHTML = 'Are you sure about this ?';
                _('conf_box_loc').style.display = 'block';
                _('conf_box_loc').style.zIndex = '3';
                _('smke_screen_2').style.display = 'block';
                _('smke_screen_2').style.zIndex = '2';
                return false;
            }

            
            formdata.append("uvApplicationNo", _('adj_bal_loc').uvApplicationNo.value);
            formdata.append("vMatricNo", _('adj_bal_loc').vMatricNo.value);
            

            // if (_('rrr_div').style.display == 'block')
            // {
            //     formdata.append("rrr", _('rrr').value);
            // }

            formdata.append("vDesc_loc", _('vDesc_loc').value);
                
            // if (_('refund_div').style.display == 'block' && _('chk_refund').checked)
            // {
            //     formdata.append("chk_refund", _('chk_refund').value);
            // }

            /*if (_('chk_inmate1').checked || _('chk_inmate2').checked)
            {*/
                formdata.append("chk_inmate", _('chk_inmate').value);
            //}
            
            formdata.append("adj_type", _('adj_type').value);
            formdata.append("adj_amnt", _('adj_amnt').value);		
            formdata.append("bal", _('bal').value);
        }
        
        
        formdata.append("ilin", _('adj_bal_loc').ilin.value);
        
        formdata.append("user_cat", _('adj_bal_loc').user_cat.value);
        formdata.append("vApplicationNo", _('adj_bal_loc').vApplicationNo.value);
        formdata.append("cAcademicDesc", _('cAcademicDesc').value);
        
        formdata.append("study_mode", _('adj_bal_loc').service_mode.value);
        formdata.append("user_centre", _('adj_bal_loc').user_centre.value);
        
        opr_prep(ajax = new XMLHttpRequest(),formdata);    
    }
    
    function completeHandler(event)
    {
        on_error('0');
        on_abort('0');
        in_progress('0');
        var returnedStr = event.target.responseText;
        
        _('container_cover_in_chkps').style.display = 'none';
        
        _('succ_boxt').className = "succ_box blink_text orange_msg";
        if ( returnedStr.indexOf("success") != -1)
        {
            _('succ_boxt').className = "succ_box blink_text green_msg";
        }
        
        _("succ_boxt").innerHTML = returnedStr;
        _("succ_boxt").style.display = 'block';
        
        _('adj_bal_loc').conf.value='';
    }
</script>

<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />
<noscript>Please, enable JavaScript on your browser</noscript>

<!-- InstanceBeginEditable name="head" -->
<script language="JavaScript" type="text/javascript">
    
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
<div id="container" style="position:relative">
    <div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
    
    <div id="container_cover_in"
        style="background:#FFFFFF;
        top:15px;
        right:15px;
        height:650px;
        width:450px;
        box-shadow: 4px 4px 4px #888888;
        display:none; 
        position:absolute;
        text-align:center; 
        padding:8px;
        padding-right:5px;
        padding-top:0px;
        border: 1px solid #CCCCCC;
        font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px">
        <div class="innercont_stff" 
            style="float:left;
            width:449px;
            height:auto;
            padding:0px;
            border-bottom: 1px solid #ccc;
            margin-bottom:5px">
            <div id="div_header_left" class="innercont_stff" 
                style="text-align:left;
                float:left;
                width:420px;
                height:18px;
                color:#FF3300;
                padding-top:8px;
                padding-bottom:4px;">List of Affected Matirculation Numbers
            </div>

            <a href="#"id="closex"
                onclick="_('container_cover_in').style.display = 'none';
                _('container_cover_in').style.zIndex = -1;
                _('container_cover').style.display = 'none';
                _('container_cover').style.zIndex = -1;
                return false" 
                style="color:#666666; text-decoration:none;text-shadow: 0 1px 0 #fafafa;">
                <div id="div_header_left" class="innercont_stff" 
                style="float:left;
                width:25px;
                height:18px;
                padding-top:8px;
                padding-bottom:4px;
                text-align:center;">
                    <img style="width:15px; height:15px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" />
                </div>
            </a>
        </div>
        <div id="message_text" style="float:left; margin-top:5px; height:605px; width:448px; overflow:auto; text-align:left; line-height:1.5"></div>
    </div>

    <div id="conf_box_loc" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
        <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
            Confirmation
        </div>
        <a href="#" style="text-decoration:none;">
            <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
        </a>
        <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;">
            Delete selected qualification?
        </div>
        <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
            <a href="#" style="text-decoration:none;" 
                onclick="_('conf_box_loc').style.display='none';
                _('smke_screen_2').style.display='none';
                _('smke_screen_2').style.zIndex='-1';
                _('labell_msg0').style.display = 'none';
                adj_bal_loc.conf.value='1';
                chk_inputs();
                return false">
                <div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
                    Yes
                </div>
            </a>

            <a href="#" style="text-decoration:none;" 
                onclick="adj_bal_loc.conf.value='';
                _('conf_box_loc').style.display='none';
                _('smke_screen_2').style.display='none';
                _('smke_screen_2').style.zIndex='-1';
                _('labell_msg0').style.display = 'none';
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
                            Last name
                        </li>
                        <li>
                            First name
                        </li>
                        <li>
                            Other name
                        </li>
                        <li>
                            Matriculation number
                        </li>
                        <li>
                            RRR
                        </li>
                        <li>
                            Naration
                        </li>
                    </ol>
                </div>
            </div>
		<!-- InstanceBeginEditable name="EditRegion6" -->
                <div class="innercont_top">Adjust balance</div>
                <div class="succ_box blink_text yello_msg" style="line-height:1.5; display:block; width:98.5%">
                    Maximum number of records that can be uploaded safely at a go is 200
                </div>
                
                <div id="succ_boxt" class="succ_box blink_text orange_msg" 
                    style="line-height:1.5; width:60%; margin:auto; max-height:400px; margin-bottom:10px; overflow:auto; text-align:left;"></div>

                <form action="adjust_student-balance" method="post" name="adj_bal_loc" id="adj_bal_loc" enctype="multipart/form-data">
                    <?php frm_vars();?>
                    <input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo trim($_REQUEST["uvApplicationNo"]);}?>" />
                    
                    <input name="bal" id="bal" type="hidden" value="1" />
                    <input name="cAcademicDesc" id="cAcademicDesc" type="hidden" value="<?php echo $orgsetins["cAcademicDesc"];?>" />
                    
                    <fieldset style="border-radius:3px; width:97.8%; float:left; border:1px solid #ccc;">
                        <legend style="font-size:13px">Use to upload credit schedule batch file</legend>
                        <div id="inmate_div" class="innercont_stff" style="margin-top:5px;">
                            <label class="labell" style="width:220px; margin-left:5px;"></label>
                            <div class="div_select">
                                <label for="mode_proc" class="labell" style="width:auto; text-align:left; cursor:pointer;">
                                    <input id="mode_proc" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"
                                        onclick="_('chk_inmate').value = '';
                                        if (this.checked)
                                        {
                                            _('sbtd_pix').disabled = false;
    
                                            // _('chk_inmate1').checked = false;
                                            //_('chk_inmate2').checked = false;
                                            
                                            // _('chk_inmate1').disabled = true;
                                            //_('chk_inmate2').disabled = true;
    
                                            _('adj_bal_loc').uvApplicationNo.value = '';
                                            _('adj_bal_loc').uvApplicationNo.disabled = true;
    
                                            _('adj_type').value = '';
                                            _('adj_type').disabled = true;
    
                                            _('adj_amnt').value = '';
                                            _('adj_amnt').disabled = true;
    
                                            _('fee_item_id').value = '';
                                            _('fee_item_id').disabled = true;
                                            
                                            _('cr_db_adj').style.display = 'none';

                                            _('container_cover_in_chkps').style.zIndex = 2;
                                            _('container_cover_in_chkps').style.display='flex';
                                        }else 
                                        {
                                            _('sbtd_pix').disabled = true;
                                            
                                            // _('chk_inmate1').disabled = false;
                                            //_('chk_inmate2').disabled = false;
    
                                            _('adj_bal_loc').uvApplicationNo.disabled = false;
    
                                            _('adj_type').disabled = false;
    
                                            _('adj_amnt').disabled = false;
    
                                            _('fee_item_id').disabled = false;
                                            
                                            _('cr_db_adj').style.display = 'block';
                                            
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
                            <label for="adj_type" class="labell" style="width:220px;">Bulk credit transaction upload</label>
                            <div class="div_select">
                                <input type="file" name="sbtd_pix" id="sbtd_pix" style="width:180px" title="upload csv file" disabled>
                            </div>
                            <div id="labell_msg4" class="labell_msg blink_text orange_msg" style="width:280px;"></div>
                        </div>
                    </fieldset>
                    
                    <!-- <div id="inmate_div" class="innercont_stff" style="margin-top:5px;">
                        <label class="labell" style="width:220px; margin-left:5px;"></label>
                        <div class="div_select" style="width:auto;">
                            <label for="chk_inmate1" class="labell" style="width:auto; text-align:left; cursor:pointer;">
                                <input id="chk_inmate1" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"  
                                    value="1"
                                    onclick="if (this.checked)
                                    {
                                        _('adj_type').value='c';
                                        _('fee_item_id').value='3';
                                        _('adj_amnt').value='5000';
                                        adj_bal_loc.adj_amnt.readOnly=true;
                                        adj_bal_loc.uvApplicationNo.readOnly=true;
                                        adj_bal_loc.uvApplicationNo.value = '';
                                        _('rrr_div').style.display='block';

                                        _('chk_inmate2').checked = false;
                                        _('chk_inmate').value = this.value;
                                        _('cr_db_adj').style.display = 'none';
                                    }else {
                                        _('adj_type').value='';
                                        _('fee_item_id').value='';
                                        _('adj_amnt').value='';
                                        _('chk_inmate').value = '';
                                        adj_bal_loc.adj_amnt.readOnly=false;
                                        adj_bal_loc.uvApplicationNo.readOnly=false;
                                        _('rrr_div').style.display='none';
                                        _('cr_db_adj').style.display = 'block';
                                    }
                                    _('labell_msg5').style.display = 'none';"/>
                                    Pay for application form for inmate(s)
                            </label>
                        </div>
                    </div> -->

                    <input name="chk_inmate" id="chk_inmate" type="hidden" value=""/>

                    <!--<div id="inmate_div" class="innercont_stff" style="margin-top:0px;">
                        <label class="labell" style="width:220px; margin-left:5px;"></label>
                        <div class="div_select" style="width:auto;">
                            <label for="chk_inmate2" class="labell" style="width:auto; text-align:left; cursor:pointer;">
                                <input id="chk_inmate2" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"  
                                    value="1"
                                    onclick="if (this.checked)
                                    {
                                        _('adj_type').value='c';
                                        _('fee_item_id').value='3';
                                        _('adj_amnt').value='5000';
                                        adj_bal_loc.adj_amnt.readOnly=true;
                                        adj_bal_loc.uvApplicationNo.readOnly=true;
                                        adj_bal_loc.uvApplicationNo.value = '';
                                        _('rrr_div').style.display='block';

                                        //_('chk_inmate1').checked = false;
                                        _('chk_inmate').value = this.value;
                                        
                                        _('cr_db_adj').style.display = 'none';
                                    }else {
                                        _('adj_type').value='';
                                        _('fee_item_id').value='';
                                        _('adj_amnt').value='';
                                        _('chk_inmate').value = '';
                                        adj_bal_loc.adj_amnt.readOnly=false;
                                        adj_bal_loc.uvApplicationNo.readOnly=false;
                                        _('rrr_div').style.display='none';
                                        
                                        _('cr_db_adj').style.display = 'block';
                                    }
                                    _('labell_msg5').style.display = 'none';"/>
                                    Resolve hanging payment for application form
                            </label>
                        </div>
                    </div>-->


                    <div id="cr_db_adj" class="succ_box blink_text yello_msg" style="line-height:1.5; display:block; width:50%; display:block">
                        Fill boxes below to credit or debit a student's account
                    </div>
                    
                    <div class="innercont_stff">
                        <label for="uvApplicationNo" class="labell" style="width:220px;">Matriculation number</label>
                        <div class="div_select">
                            <input name="uvApplicationNo" id="uvApplicationNo" type="text" class="textbox" 
                            style="text-transform:none;"
                            onkeypress="if(this.value.length==12){return false}" 
                            onchange="this.value=this.value.trim();
                            this.value=this.value.toUpperCase();" 
                            value="<?php if (isset($_REQUEST['uvApplicationNo'])){echo $_REQUEST['uvApplicationNo'];} ?>"
                            placeholder="Enabled if above box is not checked"/>
                        </div>
                        <div id="labell_msg0" class="labell_msg blink_text orange_msg" style="width:280px;"></div>
                    </div>
                    
                    <div class="innercont_stff" style="margin-top:4px;">
                        <label for="adj_type" class="labell" style="width:220px;">Action to take</label>
                        <div class="div_select">
                            <select name="adj_type" id="adj_type" class="select" style="width:100%;"
                                onchange="if(this.value=='c')
                                {
                                    //_('rrr_div').style.display='block';
                                    //_('refund_div').style.display = 'none';

                                    //_('dbt_div').style.display = 'none';
                                }else
                                {
                                    /*if (_('chk_inmate1').checked || _('chk_inmate2').checked)
                                    {
                                        this.value='c';
                                        return false;
                                    }*/
                                    //_('rrr_div').style.display='none'
                                    //_('refund_div').style.display = 'block';

                                    //_('dbt_div').style.display = 'block';
                                }" >
                                <option value=""></option>
                                <option value="c">Credit account</option>
                                <option value="d">Debit account</option>
                            </select>
                        </div>
                        <div id="labell_msg1" class="labell_msg blink_text orange_msg"></div>
                    </div>                    
                    
                    <!--<div id="refund_div" class="innercont_stff" style="margin-top:5px; display:none">
                        <label class="labell" style="width:220px; margin-left:5px;"></label>
                        <div class="div_select">
                            <label for="chk_refund" class="labell" style="width:auto; text-align:left; cursor:pointer;">
                                <input name="chk_refund" id="chk_refund" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"  
                                    value="1" />
                                    Refund
                            </label>
                        </div>
                    </div>-->
                    
                    <div class="innercont_stff" style="margin-top:4px;">
                        <label for="adj_amnt" class="labell" style="width:220px;">Amount</label>
                        <div class="div_select">
                            <input name="adj_amnt" id="adj_amnt" type="number" class="textbox" style="text-transform:none" />
                        </div>
                        <div class="labell_msg blink_text orange_msg" id="labell_msg2"></div>
                    </div>
                    
                    <!-- <div id="rrr_div" class="innercont_stff" style="margin-top:4px; display:none;">
                        <label for="rrr" class="labell" style="width:220px;"><?php
                            //if ($orgsetins['rr_sys'] == '1'){echo 'Remita retrieval reference (RRR)';}else{echo 'Payment code';}?>
                        </label>
                        <div class="div_select">
                            <input name="rrr" id="rrr" type="number" 
                                class="textbox" 
                                onkeypress="if(this.value.length==11){return false}"
                                style="width:80%"/>
                            <input name="rrr_a" id="rrr_a" type="text" 
                                class="textbox" 
                                maxlength="1"
                                onchange="this,value=this.value.toUpperCase()"
                                style="width:10%; float:right"/>
                        </div>
                        <div id="labell_msg3" class="labell_msg blink_text orange_msg" style="float:left"></div>
                    </div> -->

                    <div id="rrr_pay_div" class="innercont_stff" style="margin-top:4px;">
                        <label for="vDesc_loc" class="labell" style="width:220px;">
                            Naration
                        </label>
                        <div class="div_select">
                        <input name="vDesc_loc" id="vDesc_loc"
                            onchange="this.value=this.value.trim();"
                            type="text"
                            class="textbox" 
                            style="text-transform:none"
                            autocomplete="off" 
                            value="" />
                        </div>
                        <div id="labell_msg5" class="labell_msg blink_text orange_msg" style="float:left"></div>
                    </div>

                    <!--<div id="rrr_pay_div" class="innercont_stff"><?php
                        //$rs_sql = mysqli_query(link_connect_db(), "SELECT fee_item_id, fee_item_desc FROM fee_items WHERE fee_item_id IN ('3','71','31','61') ORDER BY fee_item_desc") or die(mysqli_error(link_connect_db()));?>
                        <label for="vDesc_loc" class="labell" style="width:220px;">
                            Purpose of transaction
                        </label>
                        <div class="div_select">
                        <select name="fee_item_id" id="fee_item_id" class="select" 
                            onchange="if (_('chk_inmate').value != '')
                            {
                                this.value='3';
                                _('vDesc_loc').value='Application Fee'
                                return false;
                            }
                            
                            _('labell_msg5').style.display = 'none';
                            if (_('chk_inmate').value == '' && this.value == '3')
                            {
                                setMsgBox('labell_msg5','Option only available if one of the two check boxes above is selected');
                                _('vDesc_loc').focus();
                                this.value='';
                            }
                            _('vDesc_loc').value=this.options[this.selectedIndex].text">
                            <option value="" selected></option><?php
                            /*$c = 0;
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
                            mysqli_close(link_connect_db());*/?>
                            </select>
                        </div>
                        <input name="vDesc_loc" id="vDesc_loc" type="hidden" />
                        <div id="labell_msg5" class="labell_msg blink_text orange_msg" style="float:left; width:400px;"></div>
                    </div>-->

                    <!-- <div id="dbt_div" class="innercont_stff" style="margin-top:4px;display:none">
                        <label for="vremark" class="labell" style="width:220px;">Purpose of deduction</label>
                        <div class="div_select">
                            <select name="fee_item_id" id="fee_item_id" class="select" onchange="_('vDesc_loc').value=this.options[this.selectedIndex].text">
                                <option value="" selected></option><?php
                                /*$c = 0;
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
                                }*/?>
                            </select>
                        
                            <input name="vremark" id="vremark" type="text" class="textbox" style="text-transform:none;" 
                                onchange="if (this.value.trim()!='')
                                   {
                                        this.value=this.value.trim();
                                        this.value=this.value.replace(/\s+/g, ' ');
                                        this.value=this.value.toLowerCase();
                                        this.value=capitalizeEachWord(this.value);
                                   }"/>
                        </div>
                        <div id="labell_msg6" class="labell_msg blink_text orange_msg" style="width:280px;"></div>
                    </div> -->
                </form>
		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;">
			<div id="pp_box">
                 <img name="passprt" id="passprt" src="<?php echo get_pp_pix(''); ?>" width="95%" height="185" style="margin:0px;"/>
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
                
				<div id="std_names" style="width:auto; padding-top:6px; padding-bottom:4px; border-bottom:1px dashed #888888"></div>
            	<div id="std_quali" style="width:auto; padding-top:5px; padding-bottom:5px; border-bottom:1px dashed #888888"></div>
            	<div id="std_lvl" style="width:auto; padding-top:6px;"></div>
            	<div id="std_sems" style="width:auto; padding-top:4px; padding-bottom:4px; border-bottom:1px dashed #888888"></div>				
            	<div id="std_vCityName" style="width:auto; padding-bottom:4px; border-bottom:1px dashed #888888"></div>
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