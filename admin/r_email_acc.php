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
	<script language="JavaScript" type="text/javascript" src="./bamboo/req_m_acc.js"></script>

	<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />
	<noscript>Please, enable JavaScript on your browser</noscript>
</head>


<body onLoad="checkConnection()">
    <?php admin_frms(); 
    $has_matno = 0;?>
	
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

            <div class="innercont_top" style="margin-bottom:0px;">Student's request - Request for eMail Account</div>
            
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

            <div class="innercont_stff" style="height:4%; width:83%; margin-top:10px; background-color:#ccc; border-radius:3px;">
                <div class="innercont_stff" style="height:auto; margin-top:2px;">
                    <div class="_label" style="width:5%; border:0px solid #cdd8cf; height:auto; padding-right:3px; padding-top:9px; padding-bottom:9px; text-align:right; margin-right:0.2%;">
                        Sno
                    </div>
                    <div class="_label" style="width:40%; border:0px solid #cdd8cf; height:auto; padding-right:5px; padding-top:9px; padding-bottom:9px; margin-left:-1px;text-align:left; text-indent:2px; margin-right:0.2%;">
                        Matriculation number
                    </div>
                    <div class="_label" style="width:49%; border:0px solid #cdd8cf; height:auto; padding-right:5px; padding-top:9px; padding-bottom:9px; margin-left:-1px;text-align:left; text-indent:2px; margin-right:0.2%;">
                        Name
                    </div>
                </div>
            </div>

            <div class="innercont_stff" style="height:89%; width:83%; margin-top:10px; overflow:scroll; overflow-x: hidden;">
                <form action="student-requests" method="post" name="sc_1_loc" id="sc_1_loc" enctype="multipart/form-data">
                    <input name="save_cf" id="save_cf" type="hidden" value="-1" />
                    <input name="tabno" id="tabno" type="hidden" value="<?php if (isset($_REQUEST['tabno'])){echo $_REQUEST['tabno'];}else{echo '0';} ?>"/>
                    <input name="user_cEduCtgId" id="user_cEduCtgId" type="hidden" value="go"/>
                    
                    <input name="pasUpldFlg" id="pasUpldFlg" type="hidden" value="0"/>
                    <input name="uvApplicationNo" id="uvApplicationNo" type="hidden" />
                    <input name="app_frm_no" id="app_frm_no" type="hidden" />
                    
                    <input name="userInfo_f" id="userInfo_f" type="hidden" value="<?php echo $cFacultyId_u ?>" />
                    <input name="study_mode_su" id="study_mode_su" type="hidden" value="odl" />
                    <input name="userInfo_d" id="userInfo_d" type="hidden" value="<?php echo $cdeptId_u ?>" />
                                    
                    <input name="cAcademicDesc" id="cAcademicDesc" type="hidden" value="<?php echo $orgsetins["cAcademicDesc"]; ?>" />
                    <input name="tSemester" id="tSemester" type="hidden" value="<?php echo $tSemester; ?>" />
                
                    <input name="tab_id" id="tab_id" type="hidden" value="<?php if (isset($_REQUEST['tab_id'])){echo $_REQUEST['tab_id'];}?>"/>
                    <input name="whattodo" id="whattodo" type="hidden" value="<?php if(isset($_REQUEST['whattodo'])){echo $_REQUEST['whattodo'];}else{echo '';}?>" /><?php 
                    frm_vars();
                    
                    require_once("student_requests.php");?><?php

                    $stmt = $mysqli->prepare("SELECT vMatricNo, CONCAT(LCASE(vMatricNo),'@noun.edu.ng'), vLastName, CONCAT(vFirstName,' ',vOtherName) 
                    FROM afnmatric a, prog_choice b 
                    WHERE a.vApplicationNo = b.vApplicationNo 
                    AND cmail_req = '0'
                    AND cSbmtd = '2'
                    ORDER BY dtStatusDate");
                    $stmt->execute();
                    $stmt->store_result();
                    $number_of_record = $stmt->num_rows;
                    $stmt->bind_result($vMatricNo, $student_mail, $l_name, $o_name);

                    
                    $cnt = 0;?><?php
                    while($stmt->fetch())
                    {
                        if (is_null($o_name))
                        {
                            $o_name = '';
                        }
                        //$o_name = $o_name ?? '';
                        
                        if ($cnt%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
                        
                        <label for="mat_chk_<?php echo ++$cnt;?>" class="lbl_beh" for="mat_chk_all"> 
                            <div class="innercont_stff" style="height:auto; margin-top:2px;">
                                <div class="_label" style="width:5%; border:1px solid #cdd8cf; height:auto; padding-right:3px; padding-top:9px; padding-bottom:9px; background-color:<?php echo $background_color;?>;  text-align:right; margin-right:0.2%;">
                                    <?php echo $cnt;?>
                                </div>
                                <div class="_label" style="width:40%; border:1px solid #cdd8cf; height:auto; padding-right:5px; padding-top:9px; padding-bottom:9px; margin-left:-1px; background-color:<?php echo $background_color;?>; text-align:left; text-indent:2px; margin-right:0.2%;">
                                    <?php echo $vMatricNo;?>
                                    <input name="mat_chk_h<?php echo $cnt;?>" id="mat_chk_h<?php echo $cnt;?>" type="hidden" value="<?php echo $student_mail; ?>" />
                                    <input name="lname_<?php echo $cnt;?>" id="lname_<?php echo $cnt;?>" type="hidden" value="<?php echo $l_name; ?>" />
                                    <input name="oname_<?php echo $cnt;?>" id="oname_<?php echo $cnt;?>" type="hidden" value="<?php echo $o_name; ?>" />
                                </div>
                                <div class="_label" style="width:49%; border:1px solid #cdd8cf; height:auto; padding-right:5px; padding-top:9px; padding-bottom:9px; margin-left:-1px; background-color:<?php echo $background_color;?>; text-align:left; text-indent:2px; margin-right:0.2%;">
                                <?php echo $l_name.' '. ucwords(strtolower($o_name));?>
                                </div>
                            </div>
                        </label><?php
                    }?><?php
                    $stmt->close();?>
                    <input name="candidate_count" id="candidate_count" type="hidden" value="<?php echo $cnt; ?>" /><?php
                    
                    if ($number_of_record > 0)
                    {?>
                        <div id="conf_box_loc" class="center" style="display:none; width:400px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
                            <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                                Confirmation
                            </div>
                            <a href="#" style="text-decoration:none;">
                                <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
                            </a>
                            
                            <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:100%; float:left; text-align:center; padding:0px;">
                                Forward request?
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
                    }else
                    {
                        information_box("There are no pending candidates");
                    }?>
                </form>        
            </div>
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