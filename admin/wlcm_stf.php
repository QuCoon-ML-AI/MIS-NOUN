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
			for (j = 0; j <= 5; j++)
			{
				if (_('labell_msg_mail_'+j))
				{
					_('labell_msg_mail_'+j).style.display = 'none';
				}
			}

			if (_("msg_to").value == '')
			{
				setMsgBox("labell_msg_mail_0","");
				_("msg_to").focus();
				return false;
			}

			if (_("msg_to").value == _("sender_id").value)
			{
				setMsgBox("labell_msg_mail_0"," Sender and receiver cannot be the same");
				_("msg_to").focus();
				return false;
			}			

			var last_dig = _('msg_to').value.substr(_('msg_to').value.length-1,1);
			if (_('msg_to').value.length != 12 || 
			(_('msg_to').value.length == 12 && last_dig.indexOf("4") == -1 && last_dig.indexOf("5") == -1 && last_dig.indexOf("6") == -1))
			{
				_('succ_boxt_mail').className = 'succ_box orange_msg center';
				_('succ_boxt_mail').innerHTML = 'Type the first 4-7 digits of phone number of recipient and select correct entry from the dropdown options';
				_('succ_boxt_mail').style.display = 'block';
				return false;
			}

			if (_("msg_sbjt").value.trim() == '')
			{
				setMsgBox("labell_msg_mail_3","");
				_("msg_sbjt").focus();
				return false;
			}

			if (_("msg_msg").value.trim() == '')
			{
				setMsgBox("labell_msg_mail_4","");
				_("msg_msg").focus();
				return false;
			}
			
			var formdata = new FormData();
			
			formdata.append("vApplicationNo", wlcm_staff_frm.vApplicationNo.value);

			formdata.append("user_id", wlcm_staff_frm.vApplicationNo.value);
			formdata.append("msg_sbjt", _('msg_sbjt').value);
			formdata.append("msg_msg", _('msg_msg').value);
			formdata.append("sender_id", _('sender_id').value);
			
		  	formdata.append("user_cat", wlcm_staff_frm.user_cat.value);
		
			if (_('what').value != 'o')
			{
				formdata.append("user_cat_of_reciever", _('msg_to').value.substr(_('msg_to').value.length-1,1));
				_('msg_to').value = _('msg_to').value.substr(0, _('msg_to').value.length-1);
			}
			formdata.append("receiver_id", _('msg_to').value);
			
			formdata.append("what", _('what').value);
			
			formdata.append("currency", wlcm_staff_frm.currency.value);
			
			opr_prep(ajax = new XMLHttpRequest(),formdata);
		}

		function completeHandler(event)
		{
			
			on_error('0');
			on_abort('0');
			in_progress('0');
			_("succ_boxt_mail").style.display = 'none';

			var returnedStr = event.target.responseText;
			
			if (returnedStr.indexOf("not") != -1)
			{
				if (returnedStr.indexOf("Receiver") != -1)
				{
					setMsgBox("labell_msg_mail_0","Number not found");
					_("msg_to").focus();
				}else
				{
					_('succ_boxt_mail').className = 'succ_box orange_msg center';
					_('succ_boxt_mail').innerHTML = 'Processing request, please...wait';
					_('succ_boxt_mail').style.display = 'block';
				}
			}else if (_('what').value == 'o')
			{			
				_('succ_boxt_mail').style.display = 'none';
				_('succ_boxt_mail').className = 'succ_box green_msg center';
				_('succ_boxt_mail').innerHTML = '';
			}else if (_('what').value == 'r' || _('what').value == 'cm' || _('what').value == 'f' || _('what').value == 'd' || _('what').value == 'ds')
			{
				if (_("ans0").style.display == 'block')
                {
                    var count_limit = _('tot_num_of_mails').value;
                }else
                {
                    var count_limit = _('tot_num_of_mails_sent').value;
                }
                
                for (i = 1; i < count_limit; i++)
				{
					var msg_reply = 'msg_reply' + i;

					if (_(msg_reply))
					{
						_(msg_reply).style.display = 'none';
					}
				}

				_('succ_boxt_mail').className = 'succ_box green_msg center';
				_('succ_boxt_mail').innerHTML = returnedStr;
				_('succ_boxt_mail').style.display = 'block';
			}
			_('what').value = '';
		}

		function opr_prep(ajax,formdata)
		{
			ajax.upload.addEventListener("progress", progressHandler, false);
			ajax.addEventListener("load", completeHandler, false);
			ajax.addEventListener("error", errorHandler, false);
			ajax.addEventListener("abort", abortHandler, false);
			
			ajax.open("POST", "opr_send_mail.php");
			ajax.send(formdata);
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
		<input name="uvApplicationNo" id="uvApplicationNo" type="hidden" value="" />
		<input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
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

		<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
		
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
	require_once ('acad_cal.php');
	//time_out_box($currency);?>

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

	<div id="leftSide_std"><?php
		require_once ('stff_left_side_menu.php');?>
	</div>
	<div id="rtlft_std" style="position:relative;"><?php
		/*if (check_scope2('Academic registry','Archive') > 0 && isset($_REQUEST["mm"]) && $_REQUEST["mm"] == 4)
		{?>
			<div class="innercont_stff" style="width:100%; height:auto;">
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
							}else
							{
								nxt.arch_mode_hd.value='0';
								cf.arch_mode_hd.value='0';
								std_acad_hist.arch_mode_hd.value='0';
								chk_pay_sta.arch_mode_hd.value='0';
								vw_std_acnt_stff.arch_mode_hd.value='0';
								std_stat.arch_mode_hd.value='0';
							}" 
							<?php if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1'){echo 'checked';} ?>/>
					</div>
					<div class="div_select" style="width:130px; height:25px; padding:5px; margin-right:0px; background:#f3f3f3">
						Look in the archive
					</div>                   
				</label>
			</div><?php
		}*/?>
		<!-- InstanceBeginEditable name="EditRegion6" -->
			<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div><?php
			    $sql_cert = "SELECT count(*) FROM s_m_t WHERE semester_reg = '1' AND MID(cProgrammeId,4,1) = '0'";
			$rsql_0 = mysqli_query(link_connect_db(), $sql_cert)or die("cannot query the database".mysqli_error(link_connect_db()));
				$cert_std_count = mysqli_fetch_array($rsql_0);
				
			//if (!isset($sm) || (isset($sm) && $sm == ''))
			//{
				if ($mm == 8)
				{
					$sql = "SELECT count(*) FROM s_m_t WHERE (cProgrammeId LIKE '___3%' OR cProgrammeId LIKE '___4%'  OR cProgrammeId LIKE '___5%'  OR cProgrammeId LIKE '___6%') AND cAcademicDesc = '".$orgsetins["cAcademicDesc"]."' AND semester_reg = '1'";
				}else
				{
					$sql = "SELECT count(*) FROM s_m_t WHERE semester_reg = '1'";
					//$sql_cond = "(cProgrammeId LIKE '___0%' || cProgrammeId LIKE '___2%') AND semester_reg = '1'";
				}

				$rsql_0 = mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));
				$std_count_0 = mysqli_fetch_array($rsql_0);
				mysqli_close(link_connect_db());

				$cn = 0;

				$row_start = 0;
				$sql = "SELECT cFacultyId, vFacultyDesc FROM faculty WHERE cCat = 'A' AND cDelFlag = 'N' ORDER BY cFacultyId";
				$rsql = mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));
				while ($table= mysqli_fetch_array($rsql))
				{
					$cn++;
					$right_margin = "";
					if ($cn%4 > 0)
					{
						$right_margin = "margin-right:2.2%; ";
						$row_start = 0;
					}

					$left_margin = "";
					if ($row_start == 0)
					{
						$left_margin = "margin-left:0.8%; ";
					}

					$row_start++;

					$colo = '';
					if ($table["cFacultyId"] == 'AGR')
					{
						$colo = '#159938';
					}else if ($table["cFacultyId"] == 'ART')
					{
						$colo = '#188bb1';
					}else if ($table["cFacultyId"] == 'EDU')
					{
						$colo = '#d6871d';
					}else if ($table["cFacultyId"] == 'HSC')
					{
						$colo = '#e02b20';
					}else if ($table["cFacultyId"] == 'LAW')
					{
						$colo = '#e09900';
					}else if ($table["cFacultyId"] == 'MSC')
					{
						$colo = '#1ed2d8';
					}else if ($table["cFacultyId"] == 'SCI')
					{
						$colo = '#e02b20';
					}else if ($table["cFacultyId"] == 'SSC')
					{
						$colo = '#7cda24';
					}

					$sql = "SELECT count(*) FROM s_m_t WHERE cFacultyId = '".$table["cFacultyId"]."' AND semester_reg = '1'";
					$rsql_1 = mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));			
					$std_count = mysqli_fetch_array($rsql_1);
					mysqli_close(link_connect_db());
					
					$sql = "SELECT count(*) FROM depts WHERE cFacultyId = '".$table["cFacultyId"]."' AND cDelFlag = 'N'";
					$rsql_2 = mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));
					$std_count_3 = mysqli_fetch_array($rsql_2);
					mysqli_close(link_connect_db());?>
					<div class="innercont_stff" 
						style="border:0px solid #ccc; 
						height:150px;
						width:22.5%;
						padding-top:15px; 
						padding-bottom:6px; 
						font-size:small;
						line-height:1.3; 
						text-align:center; 
						border-radius:3px 3px 3px 3px;
						margin-top:20px;
						box-shadow: 1px 1px 3px 1px #b3b3b3;
						color:#6e8a6d;
						<?php echo $left_margin.$right_margin;?>">
						<?php echo '<b>'.$table["vFacultyDesc"].'</b><p>'.
						'Departments<br>'.
						$std_count_3[0].'<p>Active Students<br>'.
						number_format($std_count[0]).'<br>';
						if ($std_count_0[0] > 0)
						{
							echo round((($std_count[0]/$std_count_0[0])*100),1).'%';
						}else
						{
							echo '0%';
						}?>
					</div><?php
				}
				mysqli_close(link_connect_db());
			//}?>
				<div class="innercont_stff" 
    				style="border:0px solid #ccc; 
						height:150px;
						width:22.5%;
						padding-top:15px; 
						padding-bottom:6px; 
						font-size:small;
						line-height:1.3; 
						text-align:center; 
						border-radius:3px 3px 3px 3px;
						margin-top:20px;
						box-shadow: 1px 1px 3px 1px #b3b3b3;
						color:#6e8a6d;
						background-color:#f6faf7;
						margin-left:0%;
						margin-right:0%">
    				<?php echo '<p><b>Total Active Students</b><p>'.number_format($std_count_0[0]);?>
    			</div>
    			
    			<div class="innercont_stff" 
    				style="border:0px solid #ccc; 
						height:100px;
						width:22.5%;
						padding-top:15px; 
						padding-bottom:6px; 
						font-size:small;
						line-height:1.3; 
						text-align:center; 
						border-radius:3px 3px 3px 3px;
						margin-top:20px;
						box-shadow: 1px 1px 3px 1px #b3b3b3;
						color:#6e8a6d;
						background-color:#f6faf7;
						margin-right:0.9%;
						float:right;">
    				<?php echo '<p><b>Total Active Students (excluding certificate students)</b><p>'.number_format($std_count_0[0]-$cert_std_count[0]);?>
    			</div>

				<div id="cal_btn" class="innercont_stff" 
    				style="border:0px solid #ccc; 
						height:65px;
						width:22.5%;
						padding-top:50px; 
						padding-bottom:6px; 
						font-size:small;
						line-height:1.3; 
						text-align:center; 
						border-radius:3px 3px 3px 3px;
						margin-top:20px;
						box-shadow: 1px 1px 3px 1px #b3b3b3;
						color:#FF3300;
						margin-left:0.8%;
						float:left;
						cursor:pointer" 
						onclick="_('container_cover_in_chkps_cal').style.zIndex = 3;
						_('container_cover_in_chkps_cal').style.display = 'block';
						_('cal_btn').style.display = 'none';
						return false">
    					Calendar
    			</div>
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
                    <a href="#" style="text-decoration:none;" onclick="_('nxt').user_cat.value = '6';_('nxt').action = 'staff_home_page';_('nxt').mm.value='';_('nxt').submit();return false">
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