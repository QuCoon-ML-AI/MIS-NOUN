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
	<script language="JavaScript" type="text/javascript" src="./bamboo/blkstd.js"></script>
    <script language="JavaScript" type="text/javascript">
        function chk_inputs()
        {
            var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
            for (j = 0; j <= ulChildNodes.length-1; j++)
            {
                ulChildNodes[j].style.display = 'none';
            }

            _("smke_screen_2").style.display = "none";
            
            if (!sc_1_loc.uvApplicationNo.disabled && sc_1_loc.uvApplicationNo.value == '')
            {
                setMsgBox("labell_msg0","");
                sc_1_loc.uvApplicationNo.focus();
                return false;
            }  

            if (!sc_1_loc.bulk_change.disabled && sc_1_loc.bulk_change.value.trim() == '')
            {
                setMsgBox("labell_msg1","");
                sc_1_loc.bulk_change.focus();
                return false;
            }

            if (trim(sc_1_loc.rect_risn.value) == '')
            {
                setMsgBox("labell_msg2","");
                sc_1_loc.rect_risn.focus();
                return false;
            }

            var formdata = new FormData();

            formdata.append("rect_risn", _("rect_risn").value);
            
            formdata.append("id_no", _("id_no").value);
            formdata.append("whattodo", _("whattodo").value)
            

            if (sc_1_loc.conf.value == '1')
            {
                formdata.append("conf", sc_1_loc.conf.value);
            }

            
            formdata.append("ilin", sc_1_loc.ilin.value);
            formdata.append("user_cat", sc_1_loc.user_cat.value);
            
            if (!sc_1_loc.uvApplicationNo.disabled)
            {
                formdata.append("uvApplicationNo", sc_1_loc.uvApplicationNo.value);
            }    
                    
            if (!sc_1_loc.bulk_change.disabled)
            {
                formdata.append("bulk_change", _("bulk_change").value);
            }

            formdata.append("vApplicationNo", sc_1_loc.vApplicationNo.value);
            formdata.append("sm", sc_1_loc.sm.value);
            formdata.append("mm", sc_1_loc.mm.value);
            
            formdata.append("staff_study_center", sc_1_loc.user_centre.value);
            formdata.append("sRoleID", _('sRoleID').value);

            
            
            opr_prep(ajax = new XMLHttpRequest(),formdata);
        }
    </script>
	<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />
	<noscript>Please, enable JavaScript on your browser</noscript>
</head>


<body onLoad="checkConnection()">
    <?php admin_frms(); $has_matno = 0;?>
	
	<div id="container">		
		<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
		<div id="conf_box_loc" class="center" style="display:none; width:400px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
			<div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
				Confirmation
			</div>
			<a href="#" style="text-decoration:none;">
				<div style="width:20px; float:left; text-align:center; padding:0px;"></div>
			</a>
			
			<div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:100%; float:left; text-align:center; padding:0px;">
				Delete selected qualification?
			</div>
			<div style="margin-top:10px; width:100%; float:left; text-align:right; padding:0px;">
				<a href="#" style="text-decoration:none;" 
					onclick="
					_('conf_box_loc').style.display='none';
					_('smke_screen_2').style.display='none';
					_('smke_screen_2').style.zIndex='-1';
					sc_1_loc.conf.value='1';
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
					_('labell_msg0').style.display = 'none';
					_('hd_veri_token').value = '';
					_('veri_token').value = '';
					return false">
					<div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
						No
					</div>
				</a>
			</div>
		</div><?php
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
            <input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID_u ?>" /><?php

            $additional_title = '';
            if (isset($_REQUEST['whattodo']))
            {
                if ($_REQUEST['whattodo']=='4')
                {
                    $additional_title = ' - Block';
                }else if ($_REQUEST['whattodo']=='5')
                {
                    $additional_title = ' - Unblock';
                }
            }?>

            <div class="innercont_top" style="margin-bottom:0px;">Student's request<?php echo $additional_title?></div>
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
                <input name="save_cf" id="save_cf" type="hidden" value="-1" />
                <input name="tabno" id="tabno" type="hidden" 
                    value="<?php if (isset($_REQUEST['tabno'])){echo $_REQUEST['tabno'];}else{echo '0';} ?>"/>
                <input name="user_cEduCtgId" id="user_cEduCtgId" type="hidden" value="go"/>
                
                <input name="pasUpldFlg" id="pasUpldFlg" type="hidden" value="0"/>
                <input name="uvApplicationNo_loc" id="uvApplicationNo_loc" type="hidden" />
                <input name="app_frm_no" id="app_frm_no" type="hidden" />
                
                <input name="userInfo_f" id="userInfo_f" type="hidden" value="<?php echo $cFacultyId_u ?>" />
                <input name="study_mode_su" id="study_mode_su" type="hidden" value="odl" />
                <input name="userInfo_d" id="userInfo_d" type="hidden" value="<?php echo $cdeptId_u ?>" />
                                
                <input name="cAcademicDesc" id="cAcademicDesc" type="hidden" value="<?php echo $orgsetins["cAcademicDesc"]; ?>" />
                <input name="tSemester" id="tSemester" type="hidden" value="<?php echo $tSemester; ?>" />
            
                <input name="tab_id" id="tab_id" type="hidden" value="<?php if (isset($_REQUEST['tab_id'])){echo $_REQUEST['tab_id'];}?>"/>
                <input name="whattodo" id="whattodo" type="hidden" value="<?php if(isset($_REQUEST['whattodo'])){echo $_REQUEST['whattodo'];}else{echo '';}?>" /><?php 
                frm_vars();
                
                require_once("student_requests.php");

                $sho = 'none';

                if ((isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] <> '') || $sm == 5 || $sm == 6 || ($mm == 3 && ($sm == '2' || $sm == '3')))
                {
                    $sho = 'block';
                }?>

                <div class="innercont_stff" style="margin-top:10px; display:<?php echo $sho;?>;">
                    <div class="div_select" style="text-align:right"><?php 
                       if ((($mm == 1 || $mm == 8) && $sm == 4) || ($mm == 3 && $sm == 1) || ($mm == 5 && $sm == 1))
                        {?>
                            <select name="id_no" id="id_no" class="select" 
                            onchange="sc_1_loc.uvApplicationNo.value='';">
                                <option value="0">Application form number (AFN)</option>
                                <option value="1">Matriculation number</option>
                            </select><?php
                        }?>
                    </div>

                    <div id="uvApplicationNo_div" class="div_select">
                        <input name="uvApplicationNo" id="uvApplicationNo" type="text" class="textbox"  
                        placeholder="Enter AFN/Mat. no. here"
                        onchange="this.value=this.value.trim();
                        this.value=this.value.toUpperCase();
                        if (this.value!='')
                        {
                            _('bulk_change').disabled=true;
                        }else
                        {
                            _('bulk_change').disabled=false;
                        }" />
                    </div>
                    <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
                </div>

                <div id="act_reson" class="innercont_stff" style="height:auto; margin-top:10px;">
                    <label for="rect_risn" class="labell" style="width:232px;">Bulk treatment</label>
                    <div class="div_select"style="height:auto">
                        <textarea rows="5" 
                            style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; height:250px; width:96%; padding:5px" 
                            name="bulk_change" 
                            id="bulk_change" 
                            placeholder="To treat cases in batch, copy and paste numbers here"
                            title="Only usable if box above is empty"
                            onblur="if (this.value.trim() != '')
                            {
                                sc_1_loc.uvApplicationNo.disabled=true;
                            }else
                            {
                                sc_1_loc.uvApplicationNo.disabled=false;
                            }"></textarea>
                    </div>
                    <div id="labell_msg1" class="labell_msg blink_text orange_msg"></div>
                </div>

                <div id="act_reson" class="innercont_stff" style="height:85px; margin-top:10px;">
                    <label for="rect_risn" class="labell" style="width:232px;">Reason for action</label>
                    <div class="div_select">
                        <textarea rows="5" 
                        style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; height:92%; width:98%" name="rect_risn" id="rect_risn"></textarea>
                    </div>
                    <div id="labell_msg2" class="labell_msg blink_text orange_msg"></div>
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
                    
                    <?php side_detail($_REQUEST['uvApplicationNo']);?>
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