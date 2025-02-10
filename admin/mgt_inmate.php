<?php
require_once ('good_entry.php');

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

$vFacultyDesc_u = '';
$vdeptDesc_u = '';

if ((($mm == 0 && $sm >= 9) || $mm == 1 || $mm == 8 || $mm == 3 || ($mm == 2 && $sm > 1) || ($mm == 4) || $mm == 5)  && $currency == '1')
{
	$uvApplicationNo_1 = '';
	$uvApplicationNo_2 = '';
	if (isset($_REQUEST['uvApplicationNo']))
	{
		$uvApplicationNo_1 = $_REQUEST['uvApplicationNo'];
		$uvApplicationNo_2 = $_REQUEST['uvApplicationNo'];
	}
	
	$stmt = $mysqli->prepare("select vTitle, vLastName, vFirstName, vOtherName, b.vFacultyDesc, c.vdeptDesc,a.cProgrammeId, d.vObtQualTitle, e.vProgrammeDesc, a.iStudy_level, e.cEduCtgId, a.tSemester, a.col_gown, a.ret_gown , f.vCityName
	from s_m_t a, faculty b, depts c, obtainablequal d, programme e, studycenter f, afnmatric g
	where a.cFacultyId = b.cFacultyId
	and a.cdeptId = c.cdeptId
	and a.cObtQualId = d.cObtQualId
	and a.cProgrammeId = e.cProgrammeId
	and a.cStudyCenterId = f.cStudyCenterId
	and g.vMatricNo = a.vMatricNo
	and (g.vMatricNo = ? or
	g.vApplicationNo = ?)");
	$stmt->bind_param("ss", $uvApplicationNo_1, $uvApplicationNo_2);
	$stmt->execute();
	$stmt->store_result();

	$stmt->bind_result($vTitle, $vLastName, $vFirstName, $vOtherName, $vFacultyDesc, $vdeptDesc, $cProgrammeId, $vObtQualTitle, $vProgrammeDesc, $iStudy_level, $cEduCtgId, $tSemester, $col_gown, $ret_gown,  $vCityName);
	
	$student_user_num = $stmt->num_rows;
	$stmt->fetch();
	$stmt->close();
	
	$stmt = $mysqli->prepare("select * from afnmatric where vMatricNo = ?");
	$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows === 0)
	{	
		$student_user_num = -1;
	}
	$stmt->close();
	
	$stmt = $mysqli->prepare("select 
	cblk,  
	csuspe, 
	cexpe, 
	tempwith,  
	permwith,
	period1, 
	period2, 
	re_call, 
	rect_risn, 
	rect_risn1, 
	stdycentre, 
	regist, 
	ictech from rectional where vMatricNo = ? and (cexpe = '1' or csuspe = '1' or cblk = '1') order by period1 limit 1");
	$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result( 
	$cblk,
	$csuspe,
	$cexpe, 
	$tempwith,
	$permwith,
	$period1, 
	$period2, 
	$re_call, 
	$rect_risn, 
	$rect_risn1, 
	$stdycentre, 
	$regist, 
	$ictech);
	$stmt->fetch();
	$stmt->close();	
}

require_once('staff_detail.php');?>

<!-- InstanceBeginEditable name="doctitle" -->
<title>NOUN-MIS</title>
<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
<!-- InstanceEndEditable -->




<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
<script language="JavaScript" type="text/javascript" src="button_ops.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />
<script language="JavaScript" type="text/javascript">
	
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
		
    function chk_inputs()
	{
		var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
        for (j = 0; j <= ulChildNodes.length-1; j++)
        {
            ulChildNodes[j].style.display = 'none';
        }
        
        var formdata = new FormData();
		
		if (mgt_inmates_loc.whattodo.value == '1')
		{
			if (mgt_inmates_loc.sbtd_pix.value == '')
			{
				setMsgBox("labell_msg1","");
				mgt_inmates_loc.sbtd_pix.focus();
				return false;
			}

			var files = _("sbtd_pix").files;
			if (files[0].type != 'text/csv')
			{ 
				setMsgBox("labell_msg1","Only CSV file is allowed");
				return false;
			}else if (files[0].length <= 1 /*|| files[0].size <= 16*/)
			{
				setMsgBox("labell_msg1","Empty file not allowed");
				return false;
			}else if (files[0].size > 5000000)
			{
				setMsgBox("labell_msg1","File too large. Max size is 5MB");
				return false;
			}

			
			formdata.append("sbtd_pix", _("sbtd_pix").files[0]);
		}else if (mgt_inmates_loc.whattodo.value == '2')
		{
			if (mgt_inmates_loc.uvApplicationNo.value == '')
			{
				setMsgBox("labell_msg2","");
				mgt_inmates_loc.uvApplicationNo.focus();
				return false;
			}

			
			formdata.append("uvApplicationNo",mgt_inmates_loc.uvApplicationNo.value);
		}
		
		//mgt_inmates_loc.save_cf.value = 1;
		//mgt_inmates_loc.submit();


        
        formdata.append("ilin", mgt_inmates_loc.ilin.value);
        formdata.append("mm", mgt_inmates_loc.mm.value);
        formdata.append("sm", mgt_inmates_loc.sm.value);
        formdata.append("vApplicationNo",mgt_inmates_loc.vApplicationNo.value);
        
		opr_prep(ajax = new XMLHttpRequest(),formdata);
	}

	    
    
    function opr_prep(ajax,formdata)
    {
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);

        ajax.open("POST", "opr_inm_appl.php");
        ajax.send(formdata);
    }
	
    
    function completeHandler(event)
    {
        var returnedStr = event.target.responseText;
            
        on_error('0');
        on_abort('0');
        in_progress('0');
        
        _('succ_boxt').className = "succ_box blink_text orange_msg";
        if ( returnedStr.indexOf("success") != -1)
        {
            _('succ_boxt').className = "succ_box blink_text green_msg";
        }
        
        _("succ_boxt").innerHTML = returnedStr;
        _("succ_boxt").style.display = 'block';
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
		<div id="container_cover_in_chkps" class="center" style="display:<?php if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] == '1'){echo 'block';}else{echo 'none';}?>;
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

                <div style="line-height:1.4; padding:8px 5px 8px 5px; width:97%; background-color: #fdf0bf; margin-top:10px;">
                    Required columns in the csv file to be uploaded are:
                </div>

                <div style="line-height:2;">
                    <ol>
                        <li>
                            Programme category (UG, PGD, Masters etc)
                        </li>
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
                            Gender
                        </li>
                        <li>
                            eMail ID
                        </li>
                        <li>
                            Phone number
                        </li>
                    </ol>
                </div>
            </div>
			
		<!-- InstanceBeginEditable name="EditRegion6" -->
            <input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID_u ?>" />

			<div class="innercont_top" style="margin-bottom:0px;">Manage inmate</div>
            <form method="post" name="mgt_inmates_loc" id="mgt_inmates_loc" enctype="multipart/form-data">			
				<input name="save_cf" id="save_cf" type="hidden" value="-1" />
				
                <input name="tabno" id="tabno" type="hidden" 
                    value="<?php if (isset($_REQUEST['tabno'])){echo $_REQUEST['tabno'];}else{echo '0';} ?>"/>
                <input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                <input name="frm_upd" id="frm_upd" type="hidden" />
                
                <input name="userInfo_f" id="userInfo_f" type="hidden" value="<?php echo $cFacultyId_u ?>" />
                <input name="userInfo_d" id="userInfo_d" type="hidden" value="<?php echo $cdeptId_u ?>" />
                                
                <input name="cAcademicDesc" id="cAcademicDesc" type="hidden" value="<?php echo $orgsetins["cAcademicDesc"]; ?>" />
                <input name="tSemester" id="tSemester" type="hidden" value="<?php echo $tSemester; ?>" />
                <input name="whattodo" id="whattodo" type="hidden" value="<?php if(isset($_REQUEST['whattodo'])){echo $_REQUEST['whattodo'];}else{echo '';}?>" />
			
				<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>

                <?php frm_vars();

                //require_once("student_requests.php");?>
				
				<div id="succ_boxt" class="succ_box blink_text orange_msg" style="line-height:1.5; width:60%; margin:auto; margin-top:15px; max-height:400px; overflow:auto; text-align:left;"></div>

				<div style="width:15%; height:auto; position:absolute; right:5px; margin-top:10px; border-radius:0px;"><?php
					if (check_scope3('Learner support', 'Inmate', 'Initiate application') > 0)
					{
						if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='1')
						{?>
							<div class="rtlft_inner_button_dull" 
								style="background-color:#a6cda0;
								color:#FFFFFF;">
									Initiate application
							</div>

							<a href="#" style="text-decoration:none;" 
								onclick="mgt_inmates_loc.whattodo.value=1;
								in_progress('1');
								mgt_inmates_loc.uvApplicationNo.value='';
								mgt_inmates_loc.frm_upd.value='1';
								mgt_inmates_loc.submit();
								return false">
								<div id="tabss4" class="rtlft_inner_button" style="width:100%; display:none;">
									Initiate application
								</div>
							</a><?php
						}else
						{?>
							<a href="#" style="text-decoration:none;" 
								onclick="mgt_inmates_loc.whattodo.value=1;
								mgt_inmates_loc.uvApplicationNo.value='';
								mgt_inmates_loc.frm_upd.value='1';
								in_progress('1');
								mgt_inmates_loc.submit();
								return false">
								<div id="tabss4" class="rtlft_inner_button" style="width:100%;">
									Initiate application
								</div>
							</a><?php
						}
					}
					
					if (check_scope3('Learner support', 'Inmate', 'Fund account') > 0)
					{
						if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='2')
						{?>
							<div class="rtlft_inner_button_dull" 
								style="background-color:#a6cda0;
								color:#FFFFFF;">
									Fund account
							</div>

							<a href="#" style="text-decoration:none;" 
								onclick="mgt_inmates_loc.whattodo.value=2;
								in_progress('1');
								mgt_inmates_loc.uvApplicationNo.value='';
								mgt_inmates_loc.frm_upd.value='1';
								mgt_inmates_loc.submit();
								return false">
								<div id="tabss4" class="rtlft_inner_button" style="width:100%; display:none;">
									Fund account
								</div>
							</a><?php
						}else
						{?>
							<a href="#" style="text-decoration:none;" 
								onclick="mgt_inmates_loc.whattodo.value=2;
								mgt_inmates_loc.uvApplicationNo.value='';
								mgt_inmates_loc.frm_upd.value='1';
								in_progress('1');
								mgt_inmates_loc.submit();
								return false">
								<div id="tabss4" class="rtlft_inner_button" style="width:100%;">
									Fund account
								</div>
							</a><?php
						}
					}?>
				</div>

				<div class="innercont_stff" style="margin-top:20px; display:<?php if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] == '1'){echo 'display';}else{echo 'none';}?>" title="Only CSV file">
                    <label for="sbtd_pix" class="labell" style="width:auto">Upload csv file</label>
                    <div class="div_select">
                        <input type="file" name="sbtd_pix" id="sbtd_pix"  style="width:223px">
                    </div>
                    <div id="labell_msg1" class="labell_msg blink_text orange_msg"></div>	
                </div>

                <div class="innercont_stff" style="margin-top:20px; width:80%; display:<?php if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] == '2'){echo 'display';}else{echo 'none';}?>">
                    <!-- <div class="div_select" style="text-align:right">
						Matric. number
                    </div> -->

                    <div id="uvApplicationNo_div" class="div_select">
                        <input name="uvApplicationNo" id="uvApplicationNo" type="text" class="textbox"  
                        placeholder="Enter Mat. no. here"
                        onchange="this.value=this.value.trim();
                        this.value=this.value.toUpperCase();" />
                    </div>
                    <div id="labell_msg2" class="labell_msg blink_text orange_msg"></div>
                </div>
            </form>
		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;">
			<div id="pp_box">
				<img name="passprt" id="passprt" src="<?php echo get_pp_pix('');?>" width="95%" height="185" style="margin:0px;" alt="" />
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
<!-- InstanceEnd --></html>