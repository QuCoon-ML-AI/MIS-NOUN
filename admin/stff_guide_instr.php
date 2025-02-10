<?php
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/applform.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php

require_once('const_def.php');
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');

$currency = 1;?>

<!-- InstanceBeginEditable name="doctitle" -->
<title>NOUN Application form</title>
<link rel="icon" type="image/ico" href="./img/left_side_logo.png" />
<!-- InstanceEndEditable -->

<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
<script language="JavaScript" type="text/javascript" src="button_ops.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />
<link rel="stylesheet" type="text/css" media="all" href="style_sheet_2.css" />
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
	document.onkeydown = function (e) 
	{
		if (e.ctrlKey && e.keyCode === 85) 
		{
            return false;
        }
	}
</script>

<style type="text/css">
    li{
        text-align:left;
        width:99%;
        border:none;
        cursor:default;
        height:32px;
        line-height:1.5;
    }

    li:hover {background: none; cursor:default;}

    dd, dt{text-align:left; width:100%}
</style>
<!-- InstanceEndEditable -->
</head>
<body onLoad="checkConnection()">
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


    <div id="container_cover_constat_warn" class="smoke_scrn"
	onclick="this.style.display='none'; _('container_cover_in_constat_warn').style.display='none'" title="Click to remove"></div>

    <!--<div id="container_cover_in_constat_warn" class="center smoke_scrn_box" class="center" style="color:#FF3300;" 
        onclick="this.style.display='none';
        _('container_cover_constat').style.display='none';
        _('container_cover_constat_warn').style.display='none'" title="Click to remove">
        <div id="div_header_main" class="innercont_stff" 
            style="height:auto;
            padding-bottom:5px;
            text-align:left;
            border-bottom:1px solid #ccc">
            Information
        </div>
        
        <div id="div_message_constat" class="innercont_stff" style="line-height: 1.6; margin-top:40px; float:left; height:auto;">
            The starting point of most of the steps is on the |<a href="" onClick="hpg.submit();return false" style="text-decoration:none">home page</a>|
        </div>
    </div>-->
	<!-- InstanceBeginEditable name="nakedbody" --><!--nakedbody--><!-- InstanceEndEditable -->
<div id="container">
	<noscript>
		<div class="smoke_scrn" style="display:block"></div>
		<?php information_box_inline('You need to enable javascript for this browser');?>
	</noscript>
	<?php do_toup_div('Student Management System');?>
	
	<div id="menubar">
		<!-- InstanceBeginEditable name="menubar" -->
			<div style="float:left"></div>
			<div style="float:right"></div>
		<!-- InstanceEndEditable -->
	</div>

    <div id="leftSide">
        <?php do_dull_left_side_div();?>
    </div>

	<div id="rtlft">
        <div id="smke_screen_2" class="smoke_scrn" style="display:block; z-index:2"></div>
        <div id="information_box_inline_loc" class="center" style="display:block; width:525px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF; z-index:2">
            <div style="width:99%; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                Information
            </div>
            <a href="#" style="text-decoration:none;">
                <div id="msg_title" style="width:20px; float:left; text-align:center; padding:0px;"></div>
            </a>
            <div style="line-height:2; margin-top:10px; width:99%; float:left; text-align:left; padding:0px;">
                Please note that you may not be able to execute every activity you see here.<p>This is because, what you are able to do when you login is determined by your authorization level
            </div>
            <div style="margin-top:10px; width:99%; float:left; text-align:right; padding:0px;">
                <a href="#" style="text-decoration:none;" 
                    onclick="_('information_box_inline_loc').style.display = 'none';
                    _('information_box_inline_loc').zIndex = '-1';
                    _('smke_screen_2').style.display = 'none';
                    _('smke_screen_2').zIndex = '-1';
                    return false;">
                    <div class="submit_button_green" style="width:60px; padding:6px; float:right">
                        Ok
                    </div>
                </a>
            </div>
        </div>
        <!-- InstanceBeginEditable name="EditRegion6" -->
            <form action="home-page" method="post" target="_blank" name="hpg" enctype="multipart/form-data"></form>            
		
            <form action="sample-form" method="post" target="_blank"  name="smpl" enctype="multipart/form-data">
                <input name="vApplicationNo" type="hidden" value="" />
                <input name="ilin" type="hidden" value="" />
            </form>
            
            <form action="open-to-enter" method="post" name="pass1" enctype="multipart/form-data">
                <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
                <input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"])){echo $_REQUEST["vMatricNo"];} ?>" />
                <input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
                <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
                <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
                <input name="currency" id="currency" type="hidden" value="<?php if ($GLOBALS['currency']=='1'){echo $GLOBALS['currency'];} ?>" />
                <input name="loggedout" id="loggedout" type="hidden" value="0" />
            </form>
            <div id="newappli" class="innercont_top">
                Guides and instructions
            </div>
            
            <div class="innercont_stff" style="margin-top:0px; padding:8px; height:auto; text-align:left; border-bottom:1px solid #82ad8b; width:98.2%; font-weight:bold;">
                Listed are the steps to follow for various activities as catogorized  below
            </div>
            
            <!--<div class="innercont_stff" style="margin-top:0px; padding:8px; height:auto; text-align:left; border-bottom:1px solid #82ad8b; width:98.2%; font-weight:bold;">
                Below are the steps to follow, beginning from enquiry on qualification, applying for admission ... and ultimately becoming a student 
            </div>--><?php
            time_out_box($currency);
            if ($currency == 1){?>            
                <div class="innercont_stff" style="margin-top:0px; float:left; height:88%; overflow-x: hidden; overflow-y: auto; text-align:left;">            
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('div1').style.display=='block')
                        {
                            _('div1').style.display='none'
                            _('div1minus').style.display='none'
                            _('div1plus').style.display='block';
                        }else
                        {
                            _('div1').style.display='block'
                            _('div1minus').style.display='block'
                            _('div1plus').style.display='none';
                        }return false">
                        <div id="div1plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="div1minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; font-weight:bold">
                            Sign-up
                        </div>
                    </div>
                    <div id="div1" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Go to <a href="<?php echo base_URL;?>" target="_blank"><?php echo extend_URL;?></a>
                            </li>
                            <li>
                                Click 'Staff login'
                            </li>
                            <li>
                                Click 'Sign up'
                            </li>
                            <li>
                                Fill all the boxes or select all options accordingly
                            </li>
                            <li>
                                Click the 'Submit' button
                            </li>
                            <li>
                                Follow the instruction on the screen
                            </li>
                        </ol>
                    </div>
                    
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('div2').style.display=='block')
                        {
                            _('div2').style.display='none'
                            _('div2minus').style.display='none'
                            _('div2plus').style.display='block';
                        }else
                        {
                            _('div2').style.display='block'
                            _('div2minus').style.display='block'
                            _('div2plus').style.display='none';
                        }return false">
                        <div id="div2plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="div2minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; font-weight:bold">
                            Sign-in
                        </div>
                    </div>
                    <div id="div2" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                            <li>
                                Go to <a href="<?php echo base_URL;?>" target="_blank"><?php echo extend_URL;?></a>
                            </li>
                            <li>
                                Click 'Staff login' (lower right corner)
                            </li>
                            <li>
                                Enter your user name and password in the correspondng boxes
                            </li>
                            <li>
                                Click the 'Login' button (lower right corner)
                            </li>
                            <li>
                                Follow the instruction on the screen
                            </li>
                        </ol>
                    </div>
                    


                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; padding-top:10px; padding-bottom:10px; float:left; height:auto; text-align:left; background:#fafffb; cursor:pointer;">
                        <div style="float:left; width:auto; height:auto; text-align:center; font-weight:bold">
                        Faculty
                        </div>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('diva1').style.display=='block')
                        {
                            _('diva1').style.display='none'
                            _('diva1minus').style.display='none'
                            _('diva1plus').style.display='block';
                        }else
                        {
                            _('diva1').style.display='block'
                            _('diva1minus').style.display='block'
                            _('diva1plus').style.display='none';
                        }return false">
                        <div id="diva1plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="diva1minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            A. Set new admission criteria
                        </div>
                    </div>
                    <div id="diva1" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                            <li>
                                Sign-in
                            </li>
                            <li>
                                Click 'Faculty' (top left corner)
                            </li>
                            <li>
                                Click 'New admission criteria' (first button on the left sub-menu)
                            </li>
                            <li>
                                Select faculty, department and category of programme
                            </li>
                            <li>
                                Click the 'detail' <img src="img/crit_det_ico.png" border="0" /> icon of the corresponding programme
                            </li>
                            <li>
                                Click 'New admission criteria' <img src="img/add_crit_ico.png" border="0" /> icon
                            </li>
                            <li>
                                Enter 'Description of criterion' and select entry level
                            </li>
                            <li>
                                Click the 'Submit' button
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('diva2').style.display=='block')
                        {
                            _('diva2').style.display='none'
                            _('diva2minus').style.display='none'
                            _('diva2plus').style.display='block';
                        }else
                        {
                            _('diva2').style.display='block'
                            _('diva2minus').style.display='block'
                            _('diva2plus').style.display='none';
                        }return false">
                        <div id="diva2plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="diva2minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            B. Edit admission criteria
                        </div>
                    </div>
                    <div id="diva2" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                            <li>
                                Sign-in
                            </li>
                            <li>
                                Click 'Faculty' (top left corner)
                            </li>
                            <li>
                                Click 'Edit admission criteria' (second button on the left sub-menu)
                            </li>
                            <li>
                                Select faculty, department and category of programme
                            </li>
                            <li>
                                Click the 'detail' <img src="img/crit_det_ico.png" border="0" /> icon of the corresponding programme
                            </li>
                            <li>
                                Click 'edit' <img src="img/edit_crit_ico.png" border="0" /> icon of the corresponding criterion
                            </li>
                            <li>
                                Enter 'Description of criterion' and select entry level
                            </li>
                            <li>
                                Click the 'Submit' button (lower right area)
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('diva3').style.display=='block')
                        {
                            _('diva3').style.display='none'
                            _('diva3minus').style.display='none'
                            _('diva3plus').style.display='block';
                        }else
                        {
                            _('diva3').style.display='block'
                            _('diva3minus').style.display='block'
                            _('diva3plus').style.display='none';
                        }return false">
                        <div id="diva3plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="diva3minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            C. Toggle admission criteria
                        </div>
                    </div>
                    <div id="diva3" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                            <li>
                                Sign-in
                            </li>
                            <li>
                                Click 'Faculty' (top left corner)
                            </li>
                            <li>
                                Click 'Toggle admission criteria' (third button on the left sub-menu)
                            </li>
                            <li>
                                Select faculty, department and category of programme
                            </li>
                            <li>
                                Click the 'detail' <img src="img/crit_det_ico.png" border="0" /> icon of the corresponding programme
                            </li>
                            <li>
                                Click the corresponding 'disable/enable' <img src="img/en_disable_ico.png" border="0" /> icon 
                            </li>
                            <li>
                                Confirm your intention by clicking 'Yes' or 'No'
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('diva4').style.display=='block')
                        {
                            _('diva4').style.display='none'
                            _('diva4minus').style.display='none'
                            _('diva4plus').style.display='block';
                        }else
                        {
                            _('diva4').style.display='block'
                            _('diva4minus').style.display='block'
                            _('diva4plus').style.display='none';
                        }return false">
                        <div id="diva4plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="diva4minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            D. Verify or screen for admission
                        </div>
                    </div>
                    <div id="diva4" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                            <li>
                                Sign-in
                            </li>
                            <li>
                                Click 'Faculty' (top left corner)
                            </li>
                            <li>
                                Click 'Admission (verify or screen)' (fourth button on the left sub-menu)
                            </li>
                            <li>
                                Select faculty, department and category of programme
                            </li>
                            <li>
                                Click the 'detail' <img src="img/crit_det_ico.png" border="0" /> icon of the corresponding programme
                            </li>
                            <li>
                                Enter application form number of candidate
                            </li>
                            <li>
                                To verify admission, click 'verify' (on the left side of the University logo)
                            </li>
                            <li>
                                To screen admission, click 'Screen' (on the left side of the University logo)
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('diva5').style.display=='block')
                        {
                            _('diva5').style.display='none'
                            _('diva5minus').style.display='none'
                            _('diva5plus').style.display='block';
                        }else
                        {
                            _('diva5').style.display='block'
                            _('diva5minus').style.display='block'
                            _('diva5plus').style.display='none';
                        }return false">
                        <div id="diva5plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="diva5minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            E. Delete admission criteria
                        </div>
                    </div>
                    <div id="diva5" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                            <li>
                                Sign-in
                            </li>
                            <li>
                                Click 'Faculty' (top left corner)
                            </li>
                            <li>
                                Click 'Delete admission criteria'
                            </li>
                            <li>
                                Select faculty, department and category of programme
                            </li>
                            <li>
                                Click the corresponding 'detail' <img src="img/crit_det_ico.png" border="0" /> icon
                            </li>
                            <li>
                                Click the 'delete' <img src="img/delete.gif" border="0" /> icon of the corresponding criterion
                            </li>
                            <li>
                                Confirm your intention by clicking 'Yes' or 'No'
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('diva6').style.display=='block')
                        {
                            _('diva6').style.display='none'
                            _('diva6minus').style.display='none'
                            _('diva6plus').style.display='block';
                        }else
                        {
                            _('diva6').style.display='block'
                            _('diva6minus').style.display='block'
                            _('diva6plus').style.display='none';
                        }return false">
                        <div id="diva6plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="diva6minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            F. See admission criteria
                        </div>
                    </div>
                    <div id="diva6" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                            <li>
                                Sign-in
                            </li>
                            <li>
                                Click 'Faculty' (top left corner)
                            </li>
                            <li>
                                Click 'See admission criterion'
                            </li>
                            <li>
                                Select faculty and level
                            </li>
                            <li>
                                Click 'Submit' button (lower right area)
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('diva7').style.display=='block')
                        {
                            _('diva7').style.display='none'
                            _('diva7minus').style.display='none'
                            _('diva7plus').style.display='block';
                        }else
                        {
                            _('diva7').style.display='block'
                            _('diva7minus').style.display='block'
                            _('diva7plus').style.display='none';
                        }return false">
                        <div id="diva7plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="diva7minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            G. Set faculty, programme, department and courses
                        </div>
                    </div>
                    <div id="diva7" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">                
                        <ol>
                            <li>
                                Create faculty, department, programme or courses
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click Faculty (top left area)
                                </li>
                                <li>
                                    Click Faculty, department... (middle left side) <img src="img/setup_fact_ico.png" border="0" /> button
                                </li>
                                <li>
                                    Click Create faculty, Create dept, Create Prog or Create courses (whichever action you wish to perform) <img src="img/create_fact_ico.png" border="0" />
                                </li>
                                <li>
                                    Select and enter options accordingly
                                </li>
                                <li>
                                    Click submit button
                                </li>
                            </ol>

                            <li>
                                Edit faculty, Department, Programme or Courses
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click Faculty (top left area)
                                </li>
                                <li>
                                    Click Faculty, department... (middle left side) button
                                </li>
                                <li>
                                    Click Edit faculty, Edit dept, Edit Prog or Edit courses (whichever action you wish to perform) <img src="img/edit_fact_ico.png" border="0" />
                                </li>
                                <li>
                                    Select and enter options accordingly
                                </li>
                                <li>
                                    Click submit button
                                </li>
                            </ol>

                            <li>
                                Delete faculty, Department, Programme or Courses
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click Faculty (top left area)
                                </li>
                                <li>
                                    Click Faculty, department... (middle left side) button
                                </li>
                                <li>
                                    Click Delete faculty, Delete dept, Delete Prog or Delete courses (whichever action you wish to perform) <img src="img/del_fact_ico.png" border="0" />
                                </li>
                                <li>
                                    Select and enter options accordingly
                                </li>
                                <li>
                                    Click submit button
                                </li>
                                <li>
                                    Confirm your intention
                                </li>
                            </ol>

                            <li>
                                Add or remove courses from a programme
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click Faculty (top left area)
                                </li>
                                <li>
                                    Click Faculty, department... (middle left side) button
                                </li>
                                <li>
                                    Click Add or remove course <img src="img/add_rmv_crs_fact_ico.png" border="0" />
                                </li>
                                <li>
                                    Select and enter options accordingly
                                </li>
                                <li>
                                    Click submit button
                                </li>
                                <li>
                                    Confirm your intention
                                </li>
                            </ol>

                            <li>
                                View faculty, department, programme or course
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click Faculty (top left area)
                                </li>
                                <li>
                                    Click Faculty, department... (middle left side) button
                                </li>
                                <li>
                                    Click View Faculty, View Dept, View Prog or View Course  (whichever action you wish to perform) <img src="img/voews_ico.png" border="0" />
                                </li>
                                <li>
                                    Select options accordingly
                                </li>
                                <li>
                                    Click submit button
                                </li>
                            </ol>
                        </ol>
                    </div>
                    
                
                    <!--<div class="innercont_stff guide_instruct" style="padding:4px; margin-top:10px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('diva8').style.display=='block')
                        {
                            _('diva8').style.display='none'
                            _('diva8minus').style.display='none'
                            _('diva8plus').style.display='block';
                        }else
                        {
                            _('diva8').style.display='block'
                            _('diva8minus').style.display='block'
                            _('diva8plus').style.display='none';
                        }return false">
                        <div id="diva8plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="diva8minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            H. See application record
                        </div>
                    </div>
                    <div id="diva8" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in
                            </li>
                            <li>
                                Click Enquiry (upper middle area)
                            </li>
                            <li>
                                Click 'See application form' or 'See admission letter'
                            </li>
                            <li>
                                Enter the application fomr number in the Application form number box
                            </li>
                            <li>
                                Click Submit btton (lower right area of the screen)
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('diva9').style.display=='block')
                        {
                            _('diva9').style.display='none'
                            _('diva9minus').style.display='none'
                            _('diva9plus').style.display='block';
                        }else
                        {
                            _('diva9').style.display='block'
                            _('diva9minus').style.display='block'
                            _('diva9plus').style.display='none';
                        }return false">
                        <div id="diva9plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="diva9minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            I. See student biodata
                        </div>
                    </div>
                    <div id="diva9" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in
                            </li>
                            <li>
                                Click Enquiry (upper middle area)
                            </li>
                            <li>
                                Click 'See student's biodata'
                            </li>
                            <li>
                                Enter the matriculation number in the 'Matriculation number' box
                            </li>
                            <li>
                                Click Submit btton (lower right area of the screen)
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('diva10').style.display=='block')
                        {
                            _('diva10').style.display='none'
                            _('diva10minus').style.display='none'
                            _('diva10plus').style.display='block';
                        }else
                        {
                            _('diva10').style.display='block'
                            _('diva10minus').style.display='block'
                            _('diva10plus').style.display='none';
                        }return false">
                        <div id="diva10plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="diva10minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            J. See student academic record
                        </div>
                    </div>
                    <div id="diva10" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in
                            </li>
                            <li>
                                Click Enquiry (upper middle area)
                            </li>
                            <li>
                                Click 'See student's academic record'
                            </li>
                            <li>
                                Enter the matriculation number in the 'Matriculation number' box
                            </li>
                            <li>
                                Click Submit btton (lower right area of the screen)
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('diva11').style.display=='block')
                        {
                            _('diva11').style.display='none'
                            _('diva11minus').style.display='none'
                            _('diva11plus').style.display='block';
                        }else
                        {
                            _('diva11').style.display='block'
                            _('diva11minus').style.display='block'
                            _('diva11plus').style.display='none';
                        }return false">
                        <div id="diva11plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="diva11minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            K. See student account
                        </div>
                    </div>
                    <div id="diva11" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in
                            </li>
                            <li>
                                Click Enquiry (upper middle area)
                            </li>
                            <li>
                                Click 'See student's account'
                            </li>
                            <li>
                                Enter the matriculation number in the 'Matriculation number' box
                            </li>
                            <li>
                                Click Submit btton (lower right area of the screen)
                            </li>
                        </ol>
                    </div>-->



                    
                    <div class="innercont_stff guide_instruct" style="padding:4px; padding-top:10px; padding-bottom:10px; float:left; height:auto; text-align:left; background:#fafffb; cursor:pointer;">
                        <div style="float:left; width:auto; height:auto; text-align:center; font-weight:bold">
                        Academic registry
                        </div>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divb1').style.display=='block')
                        {
                            _('divb1').style.display='none'
                            _('divb1minus').style.display='none'
                            _('divb1plus').style.display='block';
                        }else
                        {
                            _('divb1').style.display='block'
                            _('divb1minus').style.display='block'
                            _('divb1plus').style.display='none';
                        }return false">
                        <div id="divb1plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divb1minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            A. Update biodata
                        </div>
                    </div>
                    <div id="divb1" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in
                            </li>
                            <li>
                                Click 'Academic registry' (2nd button on the main menu)
                            </li>
                            <li>
                                Click 'Update biodata' (first button on the left side sub-menu)
                            </li>
                            <li>
                                Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                            </li>
                            <li>
                                Enter either the AFN or the matriculation number the next box
                            </li>
                            <li>
                                Click Submit btton (lower right area of the screen)
                            </li>
                            <li>
                                Click the tab (Biodata, Postal address, Residential address or next of kin) under which you want to update candidate's ot sudent's record
                            </li>
                            <li>
                                Make changes as required
                            </li>
                            <li>
                                Click Submit btton (lower right area of the screen)
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divb2').style.display=='block')
                        {
                            _('divb2').style.display='none'
                            _('divb2minus').style.display='none'
                            _('divb2plus').style.display='block';
                        }else
                        {
                            _('divb2').style.display='block'
                            _('divb2minus').style.display='block'
                            _('divb2plus').style.display='none';
                        }return false">
                        <div id="divb2plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divb2minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            B. Students's request
                        </div>
                    </div>
                    <div id="divb2" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                            <li>
                                Retrieve password
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Retrieve password' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Reset passowrd
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Reset password' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Block applicant or student
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Block' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Enter the reason for the action to be taken
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Unblock applicant or student
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Unblock' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Enter the reason for the action to be taken
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Release submitted form
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Release form' (on the left side of the University logo or passport picture)
                                </li>
                                <li title="AFN = Application form number">
                                    Enter the AFN in the indicated box
                                </li>
                                <li>
                                    Conirm your intention
                                </li>
                            </ol>

                            <li>
                                Activate matriculation number (single mode)
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Activate mat. no.' (on the left side of the University logo or passport picture)
                                </li>
                                <li title="AFN = Application form number">
                                    Enter the AFN in the next box
                                </li>
                                <li>
                                    Conirm your intention
                                </li>
                            </ol>

                            <li>
                                Activate matriculation number (batch mode)
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Activate mat. no.' (on the left side of the University logo or passport picture)
                                </li>
                                <li title="AFN = Application form number">
                                    Check (click) the box lableled 'In batch'
                                </li>
                                <li title="AFN = Application form number">
                                    Enter the AFNs (one per line) in the indicated box
                                </li>
                                <li>
                                    Click the 'Submit button'
                                </li>
                                <li>
                                    Conirm your intention
                                </li>
                            </ol>

                            <li>
                                Change programme
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Change programme' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Note the displayed message
                                </li>
                                <li>
                                    Select options accordingly
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Change study centre
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Change study centre' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Select study centre
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Change level
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Change level' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Select level
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Reset passport upload chance
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Reset passport upload' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Confirm intention
                                </li>
                            </ol>

                            <li>
                                Advance student
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Advance student' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select 'Matriculation number' in the appropriate box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Confirm intention
                                </li>
                            </ol>
                        </ol>
                    </div>
                    
                
                    <!--<div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divb3').style.display=='block')
                        {
                            _('divb3').style.display='none'
                            _('divb3minus').style.display='none'
                            _('divb3plus').style.display='block';
                        }else
                        {
                            _('divb3').style.display='block'
                            _('divb3minus').style.display='block'
                            _('divb3plus').style.display='none';
                        }return false">
                        <div id="divb3plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divb3minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            C. See applicatiom
                        </div>
                    </div>
                    <div id="divb3" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divb4').style.display=='block')
                        {
                            _('divb4').style.display='none'
                            _('divb4minus').style.display='none'
                            _('divb4plus').style.display='block';
                        }else
                        {
                            _('divb4').style.display='block'
                            _('divb4minus').style.display='block'
                            _('divb4plus').style.display='none';
                        }return false">
                        <div id="divb4plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divb4minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            D. See admission letter
                        </div>
                    </div>
                    <div id="divb4" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divb5').style.display=='block')
                        {
                            _('divb5').style.display='none'
                            _('divb5minus').style.display='none'
                            _('divb5plus').style.display='block';
                        }else
                        {
                            _('divb5').style.display='block'
                            _('divb5minus').style.display='block'
                            _('divb5plus').style.display='none';
                        }return false">
                        <div id="divb5plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divb5minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            E. See student's biodata
                        </div>
                    </div>
                    <div id="divb5" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divb6').style.display=='block')
                        {
                            _('divb6').style.display='none'
                            _('divb6minus').style.display='none'
                            _('divb6plus').style.display='block';
                        }else
                        {
                            _('divb6').style.display='block'
                            _('divb6minus').style.display='block'
                            _('divb6plus').style.display='none';
                        }return false">
                        <div id="divb6plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divb6minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            F. See student's academic record
                        </div>
                    </div>
                    <div id="divb6" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divb7').style.display=='block')
                        {
                            _('divb7').style.display='none'
                            _('divb7minus').style.display='none'
                            _('divb7plus').style.display='block';
                        }else
                        {
                            _('divb7').style.display='block'
                            _('divb7minus').style.display='block'
                            _('divb7plus').style.display='none';
                        }return false">
                        <div id="divb7plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divb7minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            G. See student's account
                        </div>
                    </div>
                    <div id="divb7" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>-->
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divb8').style.display=='block')
                        {
                            _('divb8').style.display='none'
                            _('divb8minus').style.display='none'
                            _('divb8plus').style.display='block';
                        }else
                        {
                            _('divb8').style.display='block'
                            _('divb8minus').style.display='block'
                            _('divb8plus').style.display='none';
                        }return false">
                        <div id="divb8plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divb8minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            C. Correctional facilities
                        </div>
                    </div>
                    <div id="divb8" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                            <li>
                                Block
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                    Click 'Correctional facilities' (last but one button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Block' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Enter matriculation number and the reason for action in the appropriate boxes
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Confirm intention
                                </li>
                            </ol>

                            <li>
                                Suspend
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                    Click 'Suspend' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Enter matriculation number, end date of susspension and the reason for action in the appropriate boxes
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Confirm intention
                                </li>
                            </ol>

                            <li>
                                Expell
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                    Click 'Expell' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Enter matriculation number and the reason for action in the appropriate boxes
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Confirm intention
                                </li>
                            </ol>

                            <li>
                                Withdraw temporarily
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                    Click 'Withdraw temporarily' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Enter matriculation number and the reason for action in the appropriate boxes
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Confirm intention
                                </li>
                            </ol>

                            <li>
                                Withdraw permanently
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                    Click 'Withdraw permanently' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Enter matriculation number and the reason for action in the appropriate boxes
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Confirm intention
                                </li>
                            </ol>

                            <li>
                                Unblock
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                    Click 'Unblock' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Enter matriculation number and the reason for action in the appropriate boxes
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Confirm intention
                                </li>
                            </ol>

                            <li>
                                Lift suspension
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                    Click 'Lift suspension' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Enter matriculation number and the reason for action in the appropriate boxes
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Confirm intention
                                </li>
                            </ol>

                            <li>
                                Re-call from expulsion
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                    Click 'Re-call from expulsion' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Enter matriculation number and the reason for action in the appropriate boxes
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Confirm intention
                                </li>
                            </ol>

                            <li>
                                Re-call from withdrawal
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                    Click 'Re-call from withdrawal' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Enter matriculation number and the reason for action in the appropriate boxes
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Confirm intention
                                </li>
                            </ol>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divb9').style.display=='block')
                        {
                            _('divb9').style.display='none'
                            _('divb9minus').style.display='none'
                            _('divb9plus').style.display='block';
                        }else
                        {
                            _('divb9').style.display='block'
                            _('divb9minus').style.display='block'
                            _('divb9plus').style.display='none';
                        }return false">
                        <div id="divb9plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divb9minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            D. Students' notice board
                        </div>
                    </div>
                    <div id="divb9" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                            <li>
                                Sign-in
                            </li>
                            <li>
                                Click 'Academic registry' (2nd button on the main menu)
                            </li>
                            <li>
                                Click 'Students notice board' (last but one button on the left side of the screen)
                            </li>
                            <li>
                                To send message to the notice board:
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Click 'Compose' (right, next to the University logo)
                                </li>
                                <li>
                                    Ignore the drop-down for previous message
                                </li>
                                <li>
                                    Fill out all (drop-down) boxes as applicable
                                </li>
                                <li>
                                    Click the 'Send' button (bottom right) to pasting the message on the notice board or,
                                </li>
                                <li>
                                    Click the 'Save' button (bottom right) if you just want to save the message without pasting it on the notice board
                                </li>
                            </ol>
                            <li>
                                To edit existing message:
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Click 'Edit' (right, next to the University logo)
                                </li>
                                <li>
                                    Select desired message in the drop-down for previous messages
                                </li>
                                <li>
                                    Edit message as applicable
                                </li>
                                <li>
                                    Click the 'Send' button (bottom right)
                                </li>
                                <li>
                                    Click the 'Save' button (bottom right) if you just want to save the message without pasting it on the notice board
                                </li>
                            </ol>
                            <li>
                                To delete existing message:
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Click 'Delete' (right, next to the University logo)
                                </li>
                                <li>
                                    Select desired message in the drop-down for previous messages
                                </li>
                                <li>
                                    Click the 'Delete' button (bottom right)
                                </li>
                                <li>
                                    Click the 'Yes' or 'No' to confirm (or otherwise) your intention
                                </li>
                            </ol>

                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divb10').style.display=='block')
                        {
                            _('divb10').style.display='none'
                            _('divb10minus').style.display='none'
                            _('divb10plus').style.display='block';
                        }else
                        {
                            _('divb10').style.display='block'
                            _('divb10minus').style.display='block'
                            _('divb10plus').style.display='none';
                        }return false">
                        <div id="divb10plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divb10minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            E. Settings
                        </div>
                    </div>
                    <div id="divb10" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                            <li>
                                Set date for session, semester and regitration periods
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                    Click 'Settings' (last button on the left side of the screen)
                                </li>
                                <li>
                                    Click the tab lebeled 'Date and time'
                                </li>
                                <li>
                                    Set beginning and closing date for events accordingly
                                </li>
                                <li>
                                    Click 'Submit' button (lower right area of the screen)
                                </li>
                                <li>
                                    Confirm intention
                                </li>
                            </ol>
                        </ol>
                    </div>



                    
                    <div class="innercont_stff guide_instruct" style="padding:4px; padding-top:10px; padding-bottom:10px; float:left; height:auto; text-align:left; background:#fafffb; cursor:pointer;">
                        <div style="float:left; width:auto; height:auto; text-align:center; font-weight:bold">
                        Bursary
                        </div>
                    </div>
                    
                
                    <!--<div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divc1').style.display=='block')
                        {
                            _('divc1').style.display='none'
                            _('divc1minus').style.display='none'
                            _('divc1plus').style.display='block';
                        }else
                        {
                            _('divc1').style.display='block'
                            _('divc1minus').style.display='block'
                            _('divc1plus').style.display='none';
                        }return false">
                        <div id="divc1plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divc1minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            A. Check payment status
                        </div>
                    </div>
                    <div id="divc1" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divc2').style.display=='block')
                        {
                            _('divc2').style.display='none'
                            _('divc2minus').style.display='none'
                            _('divc2plus').style.display='block';
                        }else
                        {
                            _('divc2').style.display='block'
                            _('divc2minus').style.display='block'
                            _('divc2plus').style.display='none';
                        }return false">
                        <div id="divc2plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divc2minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            B. See students's account
                        </div>
                    </div>
                    <div id="divc2" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divc3').style.display=='block')
                        {
                            _('divc3').style.display='none'
                            _('divc3minus').style.display='none'
                            _('divc3plus').style.display='block';
                        }else
                        {
                            _('divc3').style.display='block'
                            _('divc3minus').style.display='block'
                            _('divc3plus').style.display='none';
                        }return false">
                        <div id="divc3plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divc3minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            C. See stuent's academic record
                        </div>
                    </div>
                    <div id="divc3" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>-->
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divc4').style.display=='block')
                        {
                            _('divc4').style.display='none'
                            _('divc4minus').style.display='none'
                            _('divc4plus').style.display='block';
                        }else
                        {
                            _('divc4').style.display='block'
                            _('divc4minus').style.display='block'
                            _('divc4plus').style.display='none';
                        }return false">
                        <div id="divc4plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divc4minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            A. Adjust balance
                        </div>
                    </div>
                    <div id="divc4" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in
                            </li>
                            <li>
                                Click 'Bursary' (3rd button on the main menu)
                            </li>
                            <li>
                                Click 'Adjust balance' (4th button on the left side of the screen)
                            </li>
                            <li>
                                Enter/ select option accordingly
                            </li>
                            <li>
                                Click 'Submit' button (lower right area of the screen)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divc5').style.display=='block')
                        {
                            _('divc5').style.display='none'
                            _('divc5minus').style.display='none'
                            _('divc5plus').style.display='block';
                        }else
                        {
                            _('divc5').style.display='block'
                            _('divc5minus').style.display='block'
                            _('divc5plus').style.display='none';
                        }return false">
                        <div id="divc5plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divc5minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            B. Manage fee structure
                        </div>
                    </div>
                    <div id="divc5" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in
                            </li>
                            <li>
                                Click 'Fee structure' (5th button on the left side of the screen)
                            </li>
                            <li>
                                Select category of programme and faculty
                            </li>
                            
                            <li>
                                To add a fee item
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Click 'Add' button (left side of the University logo)
                                </li>
                                <li>
                                    Select/enter options accordingly
                                </li>
                                <li>
                                    Click 'Save' button
                                </li>
                            </ol>
                            
                            <li>
                                To edit a fee item
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Click the 'Edit' <img src="img/edit_ico.png" border="0" /> icon for the selected fee item
                                </li>
                                <li>
                                    Select/enter options accordingly. <i>To apply change to the selected fee item in all faculties for the selected category of programme, check the box labeled 'All faculty'</i>
                                </li>
                                <li>
                                    Click 'Save' button
                                </li>
                            </ol>
                            
                            <li>
                                Delete fee item(s)
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                

                            <li>
                                To delete an item
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Bursary'
                                </li>
                                <li>
                                    Click 'Fee structure' (5th button on the left side of the screen)
                                </li>
                                <li>
                                    Select category (of programme) and faculty
                                </li>
                                <li>
                                    Click the 'Delete' <img src="img/del_ico.png" border="0" /> icon for the selected fee item
                                </li>
                                <li>
                                    Confirm intention
                                </li>
                            </ol>

                            <li>
                                To delete multiple items
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Bursary'
                                </li>
                                <li>
                                    Click 'Fee structure' (5th button on the left side of the screen)
                                </li>
                                <li>
                                    Select category (of programme) and faculty
                                </li>
                                <li>
                                    Click the 'Delete all' <img src="img/del_all_ico.png" border="0" /> icon for the selected fee item
                                </li>
                                <li>
                                    Confirm intention
                                </li>
                            </ol>
                        </ol>
                    </div>
                    
                
                    <!--<div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divc6').style.display=='block')
                        {
                            _('divc6').style.display='none'
                            _('divc6minus').style.display='none'
                            _('divc6plus').style.display='block';
                        }else
                        {
                            _('divc6').style.display='block'
                            _('divc6minus').style.display='block'
                            _('divc6plus').style.display='none';
                        }return false">
                        <div id="divc6plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divc6minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            F. See application form
                        </div>
                    </div>
                    <div id="divc6" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divc7').style.display=='block')
                        {
                            _('divc7').style.display='none'
                            _('divc7minus').style.display='none'
                            _('divc7plus').style.display='block';
                        }else
                        {
                            _('divc7').style.display='block'
                            _('divc7minus').style.display='block'
                            _('divc7plus').style.display='none';
                        }return false">
                        <div id="divc7plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divc7minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            G. See admission letter
                        </div>
                    </div>
                    <div id="divc7" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>-->
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divc8').style.display=='block')
                        {
                            _('divc8').style.display='none'
                            _('divc8minus').style.display='none'
                            _('divc8plus').style.display='block';
                        }else
                        {
                            _('divc8').style.display='block'
                            _('divc8minus').style.display='block'
                            _('divc8plus').style.display='none';
                        }return false">
                        <div id="divc8plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divc8minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            C. Store
                        </div>
                    </div>
                    <div id="divc8" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                            <li>
                                Monitor student collection of course material
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign in
                                </li>
                                <li>
                                    Click 'Bursary'
                                </li>
                                <li>
                                    Click 'Store'
                                </li>
                                <li>
                                    Enter matriculation number
                                </li>
                                <li>
                                    Click 'Submit' button (lower right area of the screen)
                                </li>
                                <li>
                                    Click tab labeled 'Course material'
                                </li>
                                <li>
                                    Check the boxes corresponding the the course whose material has been collected by the student
                                </li>
                                <li>
                                    Click 'Submit' button
                                </li>
                            </ol>

                            <li>
                                Monitor gown collection
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign in
                                </li>
                                <li>
                                    Click 'Bursary'
                                </li>
                                <li>
                                    Click 'Store'
                                </li>
                                <li>
                                    Enter matriculation number
                                </li>
                                <li>
                                    Click 'Submit' button (lower right area of the screen)
                                </li>
                                <li>
                                    Click tab labeled 'Gownl'
                                </li>
                                <li>
                                    Check the boxes corresponding the the course whose material has been collected by the student
                                </li>
                                <li>
                                    Click 'Submit' button
                                </li>
                            </ol>
                        </ol>
                    </div>
                    
                
                    <!--<div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divc9').style.display=='block')
                        {
                            _('divc9').style.display='none'
                            _('divc9minus').style.display='none'
                            _('divc9plus').style.display='block';
                        }else
                        {
                            _('divc9').style.display='block'
                            _('divc9minus').style.display='block'
                            _('divc9plus').style.display='none';
                        }return false">
                        <div id="divc9plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divc9minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            D. Settings
                        </div>
                    </div>
                    <div id="divc9" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                            <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divc10').style.display=='block')
                        {
                            _('divc10').style.display='none'
                            _('divc10minus').style.display='none'
                            _('divc10plus').style.display='block';
                        }else
                        {
                            _('divc10').style.display='block'
                            _('divc10minus').style.display='block'
                            _('divc10plus').style.display='none';
                        }return false">
                        <div id="div10plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="div10minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            E. Report
                        </div>
                    </div>
                    <div id="divc10" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>-->



                    
                    <div class="innercont_stff guide_instruct" style="padding:4px; padding-top:10px; padding-bottom:10px; float:left; height:auto; text-align:left; background:#fafffb; cursor:pointer;">
                        <div style="float:left; width:auto; height:auto; text-align:center; font-weight:bold">
                        Learner support
                        </div>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divd1').style.display=='block')
                        {
                            _('divd1').style.display='none'
                            _('divd1minus').style.display='none'
                            _('divd1plus').style.display='block';
                        }else
                        {
                            _('divd1').style.display='block'
                            _('divd1minus').style.display='block'
                            _('divd1plus').style.display='none';
                        }return false">
                        <div id="divd1plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divd1minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            A. Students's request
                        </div>
                    </div>
                    <div id="divd1" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                            <li>
                                Retrieve password
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Retrieve password' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Reset passowrd
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Reset password' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Block applicant or student
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Block' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Enter the reason for the action to be taken
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Unblock applicant or student
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Unblock' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Enter the reason for the action to be taken
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Release submitted form
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Release form' (on the left side of the University logo or passport picture)
                                </li>
                                <li title="AFN = Application form number">
                                    Enter the AFN in the indicated box
                                </li>
                                <li>
                                    Conirm your intention
                                </li>
                            </ol>

                            <li>
                                Activate matriculation number (single mode)
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Activate mat. no.' (on the left side of the University logo or passport picture)
                                </li>
                                <li title="AFN = Application form number">
                                    Enter the AFN in the next box
                                </li>
                                <li>
                                    Conirm your intention
                                </li>
                            </ol>

                            <li>
                                Activate matriculation number (batch mode)
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Activate mat. no.' (on the left side of the University logo or passport picture)
                                </li>
                                <li title="AFN = Application form number">
                                    Check (click) the box lableled 'In batch'
                                </li>
                                <li title="AFN = Application form number">
                                    Enter the AFNs (one per line) in the indicated box
                                </li>
                                <li>
                                    Click the 'Submit button'
                                </li>
                                <li>
                                    Conirm your intention
                                </li>
                            </ol>

                            <li>
                                Change programme
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Change programme' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Note the displayed message
                                </li>
                                <li>
                                    Select options accordingly
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Change study centre
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Change study centre' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Select study centre
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Change level
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Change level' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Select level
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>
                        </ol>
                    </div>
                
                    <!--<div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divd2').style.display=='block')
                        {
                            _('divd2').style.display='none'
                            _('divd2minus').style.display='none'
                            _('divd2plus').style.display='block';
                        }else
                        {
                            _('divd2').style.display='block'
                            _('divd2minus').style.display='block'
                            _('divd2plus').style.display='none';
                        }return false">
                        <div id="divd2plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divd2minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            B. See applicatiom
                        </div>
                    </div>
                    <div id="divd2" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divd3').style.display=='block')
                        {
                            _('divd3').style.display='none'
                            _('divd3minus').style.display='none'
                            _('divd3plus').style.display='block';
                        }else
                        {
                            _('divd3').style.display='block'
                            _('divd3minus').style.display='block'
                            _('divd3plus').style.display='none';
                        }return false">
                        <div id="divd3plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divd3minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            C. See admission letter
                        </div>
                    </div>
                    <div id="divd3" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divd4').style.display=='block')
                        {
                            _('divd4').style.display='none'
                            _('divd4minus').style.display='none'
                            _('divd4plus').style.display='block';
                        }else
                        {
                            _('divd4').style.display='block'
                            _('divd4minus').style.display='block'
                            _('divd4plus').style.display='none';
                        }return false">
                        <div id="divd4plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divd4minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            D. See student's biodata
                        </div>
                    </div>
                    <div id="divd4" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divd5').style.display=='block')
                        {
                            _('divd5').style.display='none'
                            _('divd5minus').style.display='none'
                            _('divd5plus').style.display='block';
                        }else
                        {
                            _('divd5').style.display='block'
                            _('divd5minus').style.display='block'
                            _('divd5plus').style.display='none';
                        }return false">
                        <div id="divd5plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divd5minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            E. See student's academic record
                        </div>
                    </div>
                    <div id="divd5" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divd6').style.display=='block')
                        {
                            _('divd6').style.display='none'
                            _('divd6minus').style.display='none'
                            _('divd6plus').style.display='block';
                        }else
                        {
                            _('divd6').style.display='block'
                            _('divd6minus').style.display='block'
                            _('divd6plus').style.display='none';
                        }return false">
                        <div id="divd6plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divd6minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            F. Check payment status
                        </div>
                    </div>
                    <div id="divd6" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divd7').style.display=='block')
                        {
                            _('divd7').style.display='none'
                            _('divd7minus').style.display='none'
                            _('divd7plus').style.display='block';
                        }else
                        {
                            _('divd7').style.display='block'
                            _('divd7minus').style.display='block'
                            _('divd7plus').style.display='none';
                        }return false">
                        <div id="divd7plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divd7minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            G. See student's account
                        </div>
                    </div>
                    <div id="divd7" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divd8').style.display=='block')
                        {
                            _('divd8').style.display='none'
                            _('divd8minus').style.display='none'
                            _('divd8plus').style.display='block';
                        }else
                        {
                            _('divd8').style.display='block'
                            _('divd8minus').style.display='block'
                            _('divd8plus').style.display='none';
                        }return false">
                        <div id="divd8plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divd8minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            H. See student's status
                        </div>
                    </div>
                    <div id="divd8" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>-->
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divd9').style.display=='block')
                        {
                            _('divd9').style.display='none'
                            _('divd9minus').style.display='none'
                            _('divd9plus').style.display='block';
                        }else
                        {
                            _('divd9').style.display='block'
                            _('divd9minus').style.display='block'
                            _('divd9plus').style.display='none';
                        }return false">
                        <div id="divd9plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divd9minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            B. Study centre
                        </div>
                    </div>
                    <div id="divd9" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                            <li>
                                View
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Learner support'
                                </li>
                                <li>
                                    Click 'Study centre' (last button on the left side of the screen)
                                </li>
                                <li>
                                    Select study centre to view
                                </li>
                            </ol>

                            <li>
                                Create
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Learner support'
                                </li>
                                <li>
                                    Click 'Study centre' (last button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Create' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select/enter options accordingly
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Edit
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Learner support'
                                </li>
                                <li>
                                    Click 'Study centre' (last button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Edit' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select/enter options accordingly
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Delete
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Learner support'
                                </li>
                                <li>
                                    Click 'Study centre' (last button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Delete' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select study centre
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Confirm intention
                                </li>
                            </ol>
                        </ol>
                    </div>
                    
                    
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divd10').style.display=='block')
                        {
                            _('divd10').style.display='none'
                            _('divd10minus').style.display='none'
                            _('divd10plus').style.display='block';
                        }else
                        {
                            _('divd10').style.display='block'
                            _('divd10minus').style.display='block'
                            _('divd10plus').style.display='none';
                        }return false">
                        <div id="divd10plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divd10minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            C. Students' notice board
                        </div>
                    </div>
                    <div id="divd10" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                            <li>
                                Sign-in
                            </li>
                            <li>
                                Click 'Learner support' (4th button on the main menu)
                            </li>
                            <li>
                                Click 'Students notice board' (last button on the left side of the screen)
                            </li>
                            <li>
                                To send message to the notice board:
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Click 'Compose' (right, next to the University logo)
                                </li>
                                <li>
                                    Ignore the drop-down for previous message
                                </li>
                                <li>
                                    Fill out all (drop-down) boxes as applicable
                                </li>
                                <li>
                                    Click the 'Send' button (bottom right) to pasting the message on the notice board or,
                                </li>
                                <li>
                                    Click the 'Save' button (bottom right) if you just want to save the message without pasting it on the notice board
                                </li>
                            </ol>
                            <li>
                                To edit existing message:
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Click 'Edit' (right, next to the University logo)
                                </li>
                                <li>
                                    Select desired message in the drop-down for previous messages
                                </li>
                                <li>
                                    Edit message as applicable
                                </li>
                                <li>
                                    Click the 'Send' button (bottom right)
                                </li>
                                <li>
                                    Click the 'Save' button (bottom right) if you just want to save the message without pasting it on the notice board
                                </li>
                            </ol>
                            <li>
                                To delete existing message:
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Click 'Delete' (right, next to the University logo)
                                </li>
                                <li>
                                    Select desired message in the drop-down for previous messages
                                </li>
                                <li>
                                    Click the 'Delete' button (bottom right)
                                </li>
                                <li>
                                    Click the 'Yes' or 'No' to confirm (or otherwise) your intention
                                </li>
                            </ol>

                        </ol>
                    </div>

                    
                    <div class="innercont_stff guide_instruct" style="padding:4px; padding-top:10px; padding-bottom:10px; float:left; height:auto; text-align:left; background:#fafffb; cursor:pointer;">
                        <div style="float:left; width:auto; height:auto; text-align:center; font-weight:bold">
                        Enquiry
                        </div>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('dive1').style.display=='block')
                        {
                            _('dive1').style.display='none'
                            _('dive1minus').style.display='none'
                            _('dive1plus').style.display='block';
                        }else
                        {
                            _('dive1').style.display='block'
                            _('dive1minus').style.display='block'
                            _('dive1plus').style.display='none';
                        }return false">
                        <div id="dive1plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="dive1minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            A. See applicatiom
                        </div>
                    </div>
                    <div id="dive1" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in
                            </li>
                            <li>
                                Click Enquiry (upper middle area)
                            </li>
                            <li>
                                Click 'See application form'
                            </li>
                            <li>
                                Enter the application fomr number in the Application form number box
                            </li>
                            <li>
                                Click Submit btton (lower right area of the screen)
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('dive2').style.display=='block')
                        {
                            _('dive2').style.display='none'
                            _('dive2minus').style.display='none'
                            _('dive2plus').style.display='block';
                        }else
                        {
                            _('dive2').style.display='block'
                            _('dive2minus').style.display='block'
                            _('dive2plus').style.display='none';
                        }return false">
                        <div id="dive2plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="dive2minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            B. See admission letter
                        </div>
                    </div>
                    <div id="dive2" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in
                            </li>
                            <li>
                                Click Enquiry (upper middle area)
                            </li>
                            <li>
                                Click 'See admission letter'
                            </li>
                            <li>
                                Enter the application fomr number in the Application form number box
                            </li>
                            <li>
                                Click Submit btton (lower right area of the screen)
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('dive3').style.display=='block')
                        {
                            _('dive3').style.display='none'
                            _('dive3minus').style.display='none'
                            _('dive3plus').style.display='block';
                        }else
                        {
                            _('dive3').style.display='block'
                            _('dive3minus').style.display='block'
                            _('dive3plus').style.display='none';
                        }return false">
                        <div id="dive3plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="dive3minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            C. See student's biodata
                        </div>
                    </div>
                    <div id="dive3" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in
                            </li>
                            <li>
                                Click Enquiry (upper middle area)
                            </li>
                            <li>
                                Click 'See student's biodata'
                            </li>
                            <li>
                                Enter the matriculation number in the 'Matriculation number' box
                            </li>
                            <li>
                                Click Submit btton (lower right area of the screen)
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('dive4').style.display=='block')
                        {
                            _('dive4').style.display='none'
                            _('dive4minus').style.display='none'
                            _('dive4plus').style.display='block';
                        }else
                        {
                            _('dive4').style.display='block'
                            _('dive4minus').style.display='block'
                            _('dive4plus').style.display='none';
                        }return false">
                        <div id="dive4plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="dive4minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            D. See student's academic record
                        </div>
                    </div>
                    <div id="dive4" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in
                            </li>
                            <li>
                                Click Enquiry (upper middle area)
                            </li>
                            <li>
                                Click 'See student's academic record'
                            </li>
                            <li>
                                Enter the matriculation number in the 'Matriculation number' box
                            </li>
                            <li>
                                Click Submit btton (lower right area of the screen)
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('dive5').style.display=='block')
                        {
                            _('dive5').style.display='none'
                            _('dive5minus').style.display='none'
                            _('dive5plus').style.display='block';
                        }else
                        {
                            _('dive5').style.display='block'
                            _('dive5minus').style.display='block'
                            _('dive5plus').style.display='none';
                        }return false">
                        <div id="dive5plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="dive5minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            E. Check payment status
                        </div>
                    </div>
                    <div id="dive5" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in
                            </li>
                            <li>
                                Click Enquiry (upper middle area)
                            </li>
                            <li>
                                Click 'Check payment status'
                            </li>
                            <li>
                                Enter either the RRR or the order ID (available in your mail) in the corresponding box
                            </li>
                            <li>
                                Select purpose of payment
                            </li>
                            <li>
                                Click Submit btton (lower right area of the screen)
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('dive6').style.display=='block')
                        {
                            _('dive6').style.display='none'
                            _('dive6minus').style.display='none'
                            _('dive6plus').style.display='block';
                        }else
                        {
                            _('dive6').style.display='block'
                            _('dive6minus').style.display='block'
                            _('dive6plus').style.display='none';
                        }return false">
                        <div id="dive6plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="dive6minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            F. See student's account
                        </div>
                    </div>
                    <div id="dive6" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in
                            </li>
                            <li>
                                Click Enquiry (upper middle area)
                            </li>
                            <li>
                                Click 'See student's account'
                            </li>
                            <li>
                                Enter the matriculation number in the 'Matriculation number' box
                            </li>
                            <li>
                                Click Submit btton (lower right area of the screen)
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('dive7').style.display=='block')
                        {
                            _('dive7').style.display='none'
                            _('dive7minus').style.display='none'
                            _('dive7plus').style.display='block';
                        }else
                        {
                            _('dive7').style.display='block'
                            _('dive7minus').style.display='block'
                            _('dive7plus').style.display='none';
                        }return false">
                        <div id="dive7plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="dive7minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            G. See student's status
                        </div>
                    </div>
                    <div id="dive7" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in
                            </li>
                            <li>
                                Click Enquiry (upper middle area)
                            </li>
                            <li>
                                Click 'See student's/applicant's status'
                            </li>
                            <li>
                                Select 'Matriculation number for' or 'Application form number for' in the drop-down box
                            </li>
                            <li>
                                Enter the matriculation number or application form number in the next box
                            </li>
                            <li>
                                Click Submit btton (lower right area of the screen)
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('dive8').style.display=='block')
                        {
                            _('dive8').style.display='none'
                            _('dive8minus').style.display='none'
                            _('dive8plus').style.display='block';
                        }else
                        {
                            _('dive8').style.display='block'
                            _('dive8minus').style.display='block'
                            _('dive8plus').style.display='none';
                        }return false">
                        <div id="dive8plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="dive8minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            H. Retrieve password
                        </div>
                    </div>
                    <div id="dive8" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in
                            </li>
                            <li>
                                Click Enquiry (upper middle area)
                            </li>
                            <li>
                                Click 'Retreive password'
                            </li>
                            <li>
                                Select 'Matriculation number for' or 'Application form number for' in the drop-down box
                            </li>
                            <li>
                                Enter the matriculation number or application form number in the next box
                            </li>
                            <li>
                                Click Submit btton (lower right area of the screen)
                            </li>
                        </ol>
                    </div>
                    
                
                    <!--<div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('dive9').style.display=='block')
                        {
                            _('dive9').style.display='none'
                            _('dive9minus').style.display='none'
                            _('dive9plus').style.display='block';
                        }else
                        {
                            _('dive9').style.display='block'
                            _('dive9minus').style.display='block'
                            _('dive9plus').style.display='none';
                        }return false">
                        <div id="dive9plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="dive9minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            I. Reset password
                        </div>
                    </div>
                    <div id="dive9" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>-->



                    
                    <div class="innercont_stff guide_instruct" style="padding:4px; padding-top:10px; padding-bottom:10px; float:left; height:auto; text-align:left; background:#fafffb; cursor:pointer;">
                        <div style="float:left; width:auto; height:auto; text-align:center; font-weight:bold">
                        Technical support
                        </div>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divf1').style.display=='block')
                        {
                            _('divf1').style.display='none'
                            _('divf1minus').style.display='none'
                            _('divf1plus').style.display='block';
                        }else
                        {
                            _('divf1').style.display='block'
                            _('divf1minus').style.display='block'
                            _('divf1plus').style.display='none';
                        }return false">
                        <div id="divf1plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divf1minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            A. Students's request
                        </div>
                    </div>
                    <div id="divf1" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                            <li>
                                Retrieve password
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Retrieve password' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Reset passowrd
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Reset password' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Block applicant or student
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Block' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Enter the reason for the action to be taken
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Unblock applicant or student
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Unblock' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Enter the reason for the action to be taken
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Release submitted form
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Release form' (on the left side of the University logo or passport picture)
                                </li>
                                <li title="AFN = Application form number">
                                    Enter the AFN in the indicated box
                                </li>
                                <li>
                                    Conirm your intention
                                </li>
                            </ol>

                            <li>
                                Activate matriculation number (single mode)
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Activate mat. no.' (on the left side of the University logo or passport picture)
                                </li>
                                <li title="AFN = Application form number">
                                    Enter the AFN in the next box
                                </li>
                                <li>
                                    Conirm your intention
                                </li>
                            </ol>

                            <li>
                                Activate matriculation number (batch mode)
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Activate mat. no.' (on the left side of the University logo or passport picture)
                                </li>
                                <li title="AFN = Application form number">
                                    Check (click) the box lableled 'In batch'
                                </li>
                                <li title="AFN = Application form number">
                                    Enter the AFNs (one per line) in the indicated box
                                </li>
                                <li>
                                    Click the 'Submit button'
                                </li>
                                <li>
                                    Conirm your intention
                                </li>
                            </ol>

                            <li>
                                Change programme
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Change programme' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Note the displayed message
                                </li>
                                <li>
                                    Select options accordingly
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Change study centre
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Change study centre' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Select study centre
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Change level
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Change level' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Select level
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                            </ol>

                            <li>
                                Reset passport upload chance
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Reset passport upload' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select either 'Application form number' (AFN) or 'Matriculation number' in the drop-down box
                                </li>
                                <li>
                                    Enter either the AFN or matriculation number in the next box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Confirm intention
                                </li>
                            </ol>

                            <li>
                                Advance student
                            </li>
                            <ol style="list-style-type:lower-alpha">
                                <li>
                                    Sign-in
                                </li>
                                <li>
                                    Click 'Academic registry' (2nd button on the main menu)
                                </li>
                                <li>
                                Click 'Student request' (second button on the left side of the screen)
                                </li>
                                <li>
                                    Click 'Advance student' (on the left side of the University logo or passport picture)
                                </li>
                                <li>
                                    Select 'Matriculation number' in the appropriate box
                                </li>
                                <li>
                                    Click submit button (lower right area)
                                </li>
                                <li>
                                    Confirm intention
                                </li>
                            </ol>
                        </ol>
                    </div>
                    
                
                    <!--<div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divf2').style.display=='block')
                        {
                            _('divf2').style.display='none'
                            _('divf2minus').style.display='none'
                            _('divf2plus').style.display='block';
                        }else
                        {
                            _('divf2').style.display='block'
                            _('divf2minus').style.display='block'
                            _('divf2plus').style.display='none';
                        }return false">
                        <div id="divf2plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divf2minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            B. See applicatiom
                        </div>
                    </div>
                    <div id="divf2" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divf3').style.display=='block')
                        {
                            _('divf3').style.display='none'
                            _('divf3minus').style.display='none'
                            _('divf3plus').style.display='block';
                        }else
                        {
                            _('divf3').style.display='block'
                            _('divf3minus').style.display='block'
                            _('divf3plus').style.display='none';
                        }return false">
                        <div id="divf3plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divf3minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            C. See admission letter
                        </div>
                    </div>
                    <div id="divf3" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divf4').style.display=='block')
                        {
                            _('divf4').style.display='none'
                            _('divf4minus').style.display='none'
                            _('divf4plus').style.display='block';
                        }else
                        {
                            _('divf4').style.display='block'
                            _('divf4minus').style.display='block'
                            _('divf4plus').style.display='none';
                        }return false">
                        <div id="divf4plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divf4minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            D. See student's biodata
                        </div>
                    </div>
                    <div id="divf4" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divf5').style.display=='block')
                        {
                            _('divf5').style.display='none'
                            _('divf5minus').style.display='none'
                            _('divf5plus').style.display='block';
                        }else
                        {
                            _('divf5').style.display='block'
                            _('divf5minus').style.display='block'
                            _('divf5plus').style.display='none';
                        }return false">
                        <div id="divf5plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divf5minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            E. See student's academic record
                        </div>
                    </div>
                    <div id="divf5" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divf6').style.display=='block')
                        {
                            _('divf6').style.display='none'
                            _('divf6minus').style.display='none'
                            _('divf6plus').style.display='block';
                        }else
                        {
                            _('divf6').style.display='block'
                            _('divf6minus').style.display='block'
                            _('divf6plus').style.display='none';
                        }return false">
                        <div id="divf6plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divf6minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            F. Check payment status
                        </div>
                    </div>
                    <div id="divf6" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divf7').style.display=='block')
                        {
                            _('divf7').style.display='none'
                            _('divf7minus').style.display='none'
                            _('divf7plus').style.display='block';
                        }else
                        {
                            _('divf7').style.display='block'
                            _('divf7minus').style.display='block'
                            _('divf7plus').style.display='none';
                        }return false">
                        <div id="divf7plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divf7minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            G. See student's account
                        </div>
                    </div>
                    <div id="divf7" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>
                    
                
                    <div class="innercont_stff guide_instruct" style="padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                        onClick="if(_('divf8').style.display=='block')
                        {
                            _('divf8').style.display='none'
                            _('divf8minus').style.display='none'
                            _('divf8plus').style.display='block';
                        }else
                        {
                            _('divf8').style.display='block'
                            _('divf8minus').style.display='block'
                            _('divf8plus').style.display='none';
                        }return false">
                        <div id="divf8plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                        <div id="divf8minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                        <div style="float:left; width:auto; height:inherit; text-align:center; ">
                            H. See student's status
                        </div>
                    </div>
                    <div id="divf8" class="innercont_stff" style="margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                        <ol>
                        <li>
                                Sign-in as descibed in procedure J
                            </li>
                            <li>
                                Click 'See course registration slip'
                            </li>
                            <li>
                                Click 'Courses to drop'
                            </li>
                            <li>
                                Click 'Drop course' (if applicable)
                            </li>
                            <li>
                                Confirm your intention
                            </li>
                        </ol>
                    </div>-->
                </div><?php
            }?>
		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;">
			<div id="pp_box">
                <img src="./img/left_side_logo.png" width="95%" height="185"/>
			</div>
            <!-- InstanceBeginEditable name="EditRegion7" --><!-- InstanceEndEditable -->
		</div>
		
		<div id="insiderightSide">
			<!-- InstanceBeginEditable name="EditRegion8" -->
				<!--<div style="padding:12px; float:left; background-color:#FFFFEA; border: 1px solid #9fa35f">
					Click <a href="" target="_blank" onclick="smpl.submit();return false" style="text-decoration:none"><br>[here]<br></a> to see and study the sample application form carefully
				</div>-->
			<!-- InstanceEndEditable -->
		</div>
		
		<div id="insiderightSide">
			<!-- InstanceBeginEditable name="EditRegion9" -->
			<!-- InstanceEndEditable -->
		</div>
	</div>	
	<div id="futa"><?php foot_bar();?></div>
</div>
</body>
<!-- InstanceEnd --></html>