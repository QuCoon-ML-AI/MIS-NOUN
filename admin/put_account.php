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
        
require_once('staff_detail.php');


$staff_can_access = 0;

$staff_study_center = '';
if (isset($_REQUEST['user_centre']) && $_REQUEST['user_centre'] <> '')
{
    $staff_study_center = $_REQUEST['user_centre'];
}

$staff_study_center_new = str_replace("|","','",$staff_study_center);
$staff_study_center_new = substr($staff_study_center_new,2,strlen($staff_study_center_new)-4);

$userInfo = '';
$stmt = $mysqli->prepare("SELECT concat(vLastName,' ',vFirstName,' ',vOtherName) username, a.cFacultyId, b.vFacultyDesc, a.cdeptId, c.vdeptDesc, d.sRoleID, e.vRoleName, a.cemail, a.cphone
FROM userlogin a, faculty b, depts c, role_user d, role e
WHERE a.cFacultyId = b.cFacultyId 
AND d.sRoleID = e.sRoleID
AND a.cdeptId = c.cdeptId 
AND d.vUserId = a.vApplicationNo 
AND vApplicationNo = ?");
$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0){$userInfo = '1';}

$stmt->bind_result($username, $cFacultyId_u, $vFacultyDesc_u, $cdeptId_u, $vdeptDesc_u, $sRoleID, $vRoleName, $cemail, $cphone_u);
$stmt->fetch();
$stmt->close();?>

<!-- InstanceBeginEditable name="doctitle" -->
<title>NOUN-MIS</title>
<link rel="icon" type="image/ico" href="./img/left_side_logo.png" />
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
		
        var numbers_letter = /^[0-9A-Za-z ]+$/;

		var formdata = new FormData();

		with (reg_grp1_loc)
		{
			if (_('cEduCtgId').value != '')
			{
				remita_form.submit();
				return;	
			}
				
			if (uvApplicationNo.value == '')
			{
				setMsgBox("labell_msg0","");
				uvApplicationNo.focus();
				return false;
			}


			if (!uvApplicationNo.value.match(numbers_letter))
			{
				setMsgBox("labell_msg6","Only letters and numbers are allowed");
				uvApplicationNo.focus();
				return false;
			}

			if (amount.value == '')
			{
				setMsgBox("labell_msg1","");
				amount.focus();
				return false;
			}

			vDesc.value = 'Wallet Funding';
				
			on_error('0');
			submit();
		}
	}
</script><?php

require_once ('set_scheduled_dates.php');?>
<!-- InstanceEndEditable -->
<style>
	.div_label
	{
		width:235px;
	}
</style>
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

	<div id="leftSide_std" style="margin-left:0px;"><?php
		require_once ('stff_left_side_menu.php');?>
	</div>
	<div id="rtlft_std" style="position:relative;">
		<!-- InstanceBeginEditable name="EditRegion6" -->
			<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
            <!-- <div id="appl_box" class="innercont_stff" style="display:block"> -->
			<div class="innercont_top">Fund Account</div><?php
			
			$vApplicationNo_loc = '';
			$vLastName_loc = '';
			$vFirstName_loc = '';
			$vOtherName_loc = '';
			$vFacultyDesc_loc = '';
			$cdeptId_loc = '';
			$vdeptDesc_loc = '';
			$cProgrammeId_loc = '';
			$vObtQualTitle_loc = '';
			$vProgrammeDesc_loc = '';
			$tSemester_loc = '';
			$iStudy_level_loc = '';
			$session_reg_loc = '';
			$semester_reg_loc = '';
			$vMobileNo_loc = '';
			$cEduCtgId_loc = '';
			$iBeginLevel_loc = '';
			$cAcademicDesc = '';
			$cAcademicDesc_1 = '';
			$cStudyCenterId_loc = '';
			$vCityName_loc = '';
			$grad = '';
			$cResidenceCountryId_loc = '';
			$vEduCtgDesc_loc = '';

			$reg_open = '';
			
			$err = 0;
			if (isset($_POST["uvApplicationNo"]) && $_POST["uvApplicationNo"] <> '')
			{
				$stmt = $mysqli->prepare("SELECT * FROM afnmatric WHERE vMatricNo = ?");
				$stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				if ($stmt->num_rows == 0)
				{
					$err = 1;
					caution_box('Invalid matriculation number');
				}else
				{
					$stmt = $mysqli->prepare("SELECT a.vApplicationNo,
					a.vLastName,
					a.vFirstName,
					a.vOtherName,
					b.vFacultyDesc,
					c.vdeptDesc,
					a.cProgrammeId,
					d.vObtQualTitle,
					e.vProgrammeDesc,
					a.tSemester,
					a.iStudy_level,
					a.vMobileNo,
					e.cEduCtgId,
					g.iBeginLevel,
					a.cAcademicDesc,
					a.cAcademicDesc_1,
					f.vCityName,
					a.grad,
					a.cResidenceCountryId,
					h.vEduCtgDesc
					from s_m_t a, faculty b, depts c, obtainablequal d, programme e, prog_choice g , studycenter f, educationctg h
					where a.cFacultyId = b.cFacultyId
					AND a.cdeptId = c.cdeptId
					AND a.cObtQualId = d.cObtQualId
					AND a.cProgrammeId = e.cProgrammeId 
					AND g.vApplicationNo = a.vApplicationNo
					AND a.cStudyCenterId = f.cStudyCenterId
					AND e.cEduCtgId = h.cEduCtgId
					AND a.vMatricNo = ?");
					$stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
					$stmt->execute();
					$stmt->store_result();
					if ($stmt->num_rows == 0)
					{
						$err = 1;
						caution_box('Matriculation number yet to login');
					}else
					{
						$stmt->bind_result($vApplicationNo_loc, 
						$vLastName_loc, 
						$vFirstName_loc, 
						$vOtherName_loc, 
						$vFacultyDesc_loc, 
						$vdeptDesc_loc, 
						$cProgrammeId_loc, 
						$vObtQualTitle_loc, 
						$vProgrammeDesc_loc, 
						$tSemester_loc, 
						$iStudy_level_loc,
						$vMobileNo_loc, 
						$cEduCtgId_loc, 
						$iBeginLevel_loc, 
						$cAcademicDesc, 
						$cAcademicDesc_1, 
						$vCityName_loc, 
						$grad, 
						$cResidenceCountryId_loc,
						$vEduCtgDesc_loc);
						$stmt->fetch();

						if ($iStudy_level_loc <= 200)
						{
							$reg_open = $reg_open_100_200;
						}else
						{
							$reg_open = $reg_open_300;
						}
					}
				}
			}
			
			$pay_type = '';
			if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '' && $err == 0)
			{
				$pay_type = 'Wallet Funding';
			}?>
			<form action="student-collections" method="post" name="reg_grp1_loc" id="reg_grp1_loc" enctype="multipart/form-data">
				<input name="user_cat" id="user_cat" type="hidden" value="<?php echo $_REQUEST['user_cat']; ?>" />	
				<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];} ?>" />
				<input name="save_cf" id="save_cf" type="hidden" value="-1" />
				<input name="conf" id="conf" type="hidden" value="" />
				
				<input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
				<input name="frm_upd" id="frm_upd" type="hidden" />
				
				<input name="uvApplicationNo_loc" id="uvApplicationNo_loc" type="hidden" />
				
				<input name="vDesc" id="vDesc" type="hidden" value="<?php if (isset($_REQUEST["vDesc"])){echo $_REQUEST["vDesc"];} ?>"/>
				<input name="cEduCtgId_text" id="cEduCtgId_text" type="hidden" value="<?php if (isset($vEduCtgDesc_loc)){echo $vEduCtgDesc_loc;} ?>"/>
				<?php frm_vars();?>

				<div class="innercont_stff" style="margin-top:10px; "><?php
					if (check_scope2('SPGS', 'SPGS menu') > 0)
					{?>
						<a href="#" style="text-decoration:none;" 
							onclick="pg_environ.mm.value=8;pg_environ.sm.value='';pg_environ.submit();return false;">
							<div class="rtlft_inner_button" style="position:absolute; right:0; top:25px; padding:10px;width:auto; height:auto">
								SPGS menu
							</div>
						</a><?php
					}?>

					<div class="div_select" style="text-align:right">
						Matriculation number
					</div>
					<div id="uvApplicationNo_div" class="div_select" style="margin-top:0px;">
						<input name="uvApplicationNo" id="uvApplicationNo" type="text" class="textbox"
							onchange="this.value=this.value.trim();"
							maxlength="12" 
							value="<?php if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> ''){echo $_REQUEST["uvApplicationNo"];}?>"/>
					</div>
					<div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
				</div>
				
				<div id="amount_div" class="innercont_stff" style="margin-top:5px;">
					<div class="div_select" style="text-align:right">
						Amount
					</div>
					<div id="uvApplicationNo_div" class="div_select" style="margin-top:0px;">
						<input name="amount" id="amount" type="number" class="textbox"
							value="<?php if (isset($_REQUEST["amount"]) && $_REQUEST["amount"] <> ''){echo $_REQUEST["amount"];}?>"/>
					</div>
					<div id="labell_msg1" class="labell_msg blink_text orange_msg"></div>
				</div><?php

				if (isset($_POST["uvApplicationNo"]) && $_POST["uvApplicationNo"] <> '' && $err == 0)
				{?>
					<div id="mat_div" class="innercont_stff" style="margin-top:8px;">
						<div class="div_label">
							Matriculation number
						</div>
						<div  class="div_valu">
							<b><?php echo $_REQUEST['uvApplicationNo'];?></b>
						</div>
					</div>
					<div class="innercont_stff" style="margin-top:8px;">
						<div class="div_label">
							Name
						</div>
						<div  class="div_valu">
							<b><?php echo $vLastName_loc.', '.$vFirstName_loc.' '.$vOtherName_loc;?></b>
						</div>	
					</div>
					<div class="innercont_stff" style="margin-top:8px;">
						<div class="div_label">
							Faculty
						</div>
						<div  class="div_valu">
							<b><?php echo $vFacultyDesc_loc;?></b>
						</div>	
					</div>
					<div class="innercont_stff">
						<div class="div_label">
							Department
						</div>
						<div  class="div_valu">
							<b><?php echo $vdeptDesc_loc;?></b>
						</div>	
					</div>
					<div class="innercont_stff">
						<div class="div_label">
							Programme
						</div>
						<div  class="div_valu">
							<b><?php echo substr($vObtQualTitle_loc, 0, strlen($vObtQualTitle_loc)-1).' '.$vProgrammeDesc_loc;?></b>
						</div>	
					</div>
					<div class="innercont_stff">
						<div class="div_label">
							Entry level
						</div>
						<div  class="div_valu">
							<b><?php echo $iBeginLevel_loc;?></b>
						</div>	
					</div>
					
					<div class="innercont_stff">
						<div class="div_label">
							Current level
						</div>
						<div  class="div_valu">
							<b><?php echo $iStudy_level_loc;?></b>
						</div>	
					</div>
					
					<div class="innercont_stff">
						<div class="div_label">
							Semester
						</div>
						<div  class="div_valu">
							<b><?php if ($tSemester_loc == 1){echo 'First';}else{echo 'Second';}?></b>
						</div>
					</div>
					
					<div class="innercont_stff">
						<div class="div_label">
							Study centre
						</div>
						<div  class="div_valu">
							<b><?php echo $vCityName_loc;?></b>
						</div>	
					</div>
					
					<div class="innercont_stff">
						<div class="div_label">
							eMail address
						</div>
						<div  class="div_valu">
							<b><?php echo strtolower($_REQUEST['uvApplicationNo']).'@noun.edu.ng';?></b>
						</div>	
					</div>
					
					<div class="innercont_stff">
						<div class="div_label">
							Phone number
						</div>
						<div  class="div_valu">
							<b><?php echo $vMobileNo_loc;?></b>
						</div>	
					</div><?php
				}?>
			</form><?php

			

			function httpPost($url, $content, $hash, $merchantId)
			{
				$curl = curl_init($url);

				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_ENCODING, '');

				curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
				curl_setopt($curl, CURLOPT_TIMEOUT, 30);
				curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

				curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
				curl_setopt($curl, CURLOPT_HTTPHEADER,  array(
					"Authorization: remitaConsumerKey=$merchantId,remitaConsumerToken=$hash",
					"Content-Type: application/json",
					"cache-control: no-cache"
					));

				$response = curl_exec($curl);
				curl_close($curl);
				return $response;
			}

			function remita_transaction_details($orderId, $rrr)
			{
				$mert =  MERCHANTID;
				$api_key =  APIKEY;

				if($rrr <> '')
				{
					$concatString = $rrr . $api_key . $mert;
					$hash = hash('sha512', $concatString);
					$url = CHECKSTATUSURL . '/' . $mert  . '/' . $rrr . '/' . $hash . '/' . 'status.reg';
				}else
				{
					$concatString = $orderId . $api_key . $mert;
					$hash = hash('sha512', $concatString);	
					$url = CHECKSTATUSURL . '/' . $mert  . '/' . $orderId . '/' . $hash . '/' . 'orderstatus.reg';
				}

				//  Initiate curl
				$ch = curl_init();
				// Disable SSL verification
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				// Will return the response, if false it print the response
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				// Set the url
				curl_setopt($ch, CURLOPT_URL,$url);
				// Execute
				$result=curl_exec($ch);
				// Closing
				curl_close($ch);
				$response = json_decode($result, true);
				return $response;
			}
			
			if (isset($_POST["uvApplicationNo"]) && $_POST["uvApplicationNo"] <> '' && $err == 0 && isset($_POST["cEduCtgId"]) && $_POST["cEduCtgId"] <> '')
			{
				require_once (APPL_BASE_FILE_NAME.'remita_constants.php');
				
				//$responseurl = PATH . "/feed-back-from-rem";

				$responseurl = '';

				$serviceTypeID = SERVICETYPEID;
				$merchantId = MERCHANTID;

				$amount = $_REQUEST['amount'];
				$orderId = DATE("dmyHis");

				$split_body = "";

				$app_rrr_exist = -1;
				$reg_rrr_exist = -1;
				$r_rrr_exist = -1;

				$semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);

				function split_merchantID($orderId)
				{
					$tnxref = '';
					for($i = 0; $i < 4; $i++)
					{
						$tnxref .= mt_rand(0, 9);
					}
					return $tnxref.$orderId;
				}
				
				$lp_cnt = 0;

				while ($reg_rrr_exist <> 0 || $app_rrr_exist <> 0 || $r_rrr_exist <> 0)
				{
					if ($app_rrr_exist <> -1)
					{
						$orderId = DATE("dmyHis");
					}

					if ($amount >= 3000 && $cResidenceCountryId_loc == 'NG' && $reg_open == 1 && is_bool(strpos($cProgrammeId_loc, "CHD")) && is_bool(strpos($cProgrammeId_loc, "DEG")))
                    {
						$stmt1 = $mysqli->prepare("SELECT vMatricNo FROM split_rec WHERE vMatricNo  = ? AND split_date  >= '$semester_begin_date'");
						$stmt1->bind_param("s", $_REQUEST['vMatricNo']);
						$stmt1->execute();
						$stmt1->store_result();
						if ($stmt1->num_rows == 0)
						{
							$itemid0 = split_merchantID($orderId);
							$itemid1 = split_merchantID($orderId);
							$itemid2 = split_merchantID($orderId);

							$parent_share_name = "National Open University";
							$parent_share_bank_acnt = '0230171261018';
							$parent_share_bank_code = '000';

							$parent_share = $amount - 2000;
							$child_share = 2000;

							$child_share_name = 'Intradot Limited';
							$child_share_bank_acnt = '1017753107';
							$child_share_bank_code = '057';


							$parent_share = $parent_share - 1000;
							$child_share1 = 1000;                        
						
							$child_share1_name = 'Cyberspace Ltd';
							$child_share1_bank_acnt = '1012598972';
							$child_share1_bank_code = '057';

							$split_body = ",
							\"lineItems\":[
								{
									\"lineItemsId\":\"$itemid0\",
									\"beneficiaryName\":\"$parent_share_name\",
									\"beneficiaryAccount\":\"$parent_share_bank_acnt\",
									\"bankCode\":\"$parent_share_bank_code\",
									\"beneficiaryAmount\":\"$parent_share\",
									\"deductFeeFrom\":\"1\"
								},
								{
									\"lineItemsId\":\"$itemid1\",
									\"beneficiaryName\":\"$child_share_name\",
									\"beneficiaryAccount\":\"$child_share_bank_acnt\",
									\"bankCode\":\"$child_share_bank_code\",
									\"beneficiaryAmount\":\"$child_share\",
									\"deductFeeFrom\":\"0\"
								},
								{
									\"lineItemsId\":\"$itemid2\",
									\"beneficiaryName\":\"$child_share1_name\",
									\"beneficiaryAccount\":\"$child_share1_bank_acnt\",
									\"bankCode\":\"$child_share1_bank_code\",
									\"beneficiaryAmount\":\"$child_share1\",
									\"deductFeeFrom\":\"0\"
								}
							]";
						}
						$stmt1->close();
					}

					$payerName = $vLastName_loc.' '.$vFirstName_loc.' '.$vOtherName_loc;
					$payerEmail = strtolower($_REQUEST['uvApplicationNo']).'@noun.edu.ng';
					$vDesc = 'Wallet Funding';

					$content = "{\"serviceTypeId\": \"$serviceTypeID\",
					\"amount\": \"$amount\",
					\"orderId\": \"$orderId\",
					\"payerName\": \"$payerName\",
					\"payerEmail\": \"$payerEmail\",
					\"payerPhone\": \"$vMobileNo_loc\",
					\"description\": \"$vDesc\"$split_body}";

					$concatString = MERCHANTID.SERVICETYPEID.$orderId.$amount.APIKEY;
					$hash = hash('sha512', $concatString);

					$url = GATEWAYURL;
					
					$response = httpPost($url, $content, $hash, $merchantId);
	
					$response = substr($response, 7, -1);
					$response = json_decode($response, true);

					//print_r($response);

					if (isset($response))
					{
						$statuscode = $response['statuscode'];
						if($statuscode == '025')
						{
							$rrr = trim($response['RRR']);

							$stmt = $mysqli->prepare("SELECT * FROM remitapayments_app WHERE RetrievalReferenceNumber = ?");
							$stmt->bind_param("s", $rrr);
							$stmt->execute();
							$stmt->store_result();
							$app_rrr_exist = $stmt->num_rows;

							$stmt = $mysqli->prepare("SELECT * FROM remitapayments WHERE RetrievalReferenceNumber = ?");
							$stmt->bind_param("s", $rrr);
							$stmt->execute();
							$stmt->store_result();
							$reg_rrr_exist = $stmt->num_rows;

							$stmt = $mysqli->prepare("SELECT * FROM s_tranxion_cr WHERE RetrievalReferenceNumber = ?");
							$stmt->bind_param("s", $rrr);
							$stmt->execute();
							$stmt->store_result();
							$r_rrr_exist = $stmt->num_rows;				
						}
					}

					$lp_cnt++;
					if ($lp_cnt > 5)
					{
						break;
					}
				}

				
				if (isset($response))
				{
					$statuscode = $response['statuscode'];
					$statusMsg = $response['status'];

					if($statuscode == '025')
					{
						$rrr = trim($response['RRR']);
						$new_hash_string = MERCHANTID . $rrr . APIKEY;
						$hash = hash('sha512', $new_hash_string);
						$url = GATEWAYRRRPAYMENTURL;

						$stmt1 = $mysqli->prepare("INSERT IGNORE INTO remitapayments 
						SET Regno = ?,
						payerName = '$vLastName_loc $vFirstName_loc $vOtherName_loc',
						vLastName = '$vLastName_loc',
						vFirstName = '$vFirstName_loc',
						vOtherName = '$vOtherName_loc',
						payerEmail = '".strtolower($_REQUEST['uvApplicationNo'])."@noun.edu.ng',
						cEduCtgId = '$cEduCtgId_loc',
						Amount = ?, 
						payerPhone = '$vMobileNo_loc',
						MerchantReference = '$orderId',
						RetrievalReferenceNumber = '$rrr',
						AcademicSession = '".$orgsetins['cAcademicDesc']."',
						tSemester = $tSemester_loc, 
						vDesc = 'Wallet Funding',
						TransactionDate = NOW(),
						Status = 'Pending'");
						$stmt1->bind_param("sd", $_REQUEST['uvApplicationNo'], $_REQUEST['amount']);
						$stmt1->execute();

						log_actv('Initiated payment for '.$_REQUEST['vMatricNo'].' for '.$_REQUEST['vDesc']);
									
						if ($split_body <> '')
						{
							$stmt1 = $mysqli->prepare("REPLACE INTO split_rec SET 
                            vMatricNo = ?, 
                            vLastName = '$vLastName_loc', 
                            vFirstName = '$vFirstName_loc', 
                            vOtherName = '$vOtherName_loc',
                            rrr = '$rrr',
                            orderid  = '$orderId', 
                            amount = 2000,
                            split_date = NOW(),
                            Acadsession = '".$orgsetins["cAcademicDesc"]."',
                            tsemster = $tSemester_loc");
                            $stmt1->bind_param("s",$_REQUEST['uvApplicationNo']);
                            $stmt1->execute();

                            $stmt1 = $mysqli->prepare("REPLACE INTO split_rec SET 
                            vMatricNo = ?, 
                            vLastName = '$vLastName_loc', 
                            vFirstName = '$vFirstName_loc', 
                            vOtherName = '$vOtherName_loc',
                            rrr = '$rrr',
                            orderid  = '$orderId', 
                            amount = 1000,
                            split_date = NOW(),
                            Acadsession = '".$orgsetins["cAcademicDesc"]."',
                            tsemster = $tSemester_loc");
                            $stmt1->bind_param("s",$_REQUEST['uvApplicationNo']);
                            $stmt1->execute();
						}?>

						<form action="<?php echo $url; ?>" id="remita_form" name="remita_form" method="POST" target="_blank">
							<input id="merchantId" name="merchantId" value="<?php echo MERCHANTID; ?>" type="hidden"/>
							<input id="serviceTypeId" name="serviceTypeId" value="<?php echo SERVICETYPEID; ?>" type="hidden"/>
							<input id="amt" name="amt" value="<?php if (isset($amount)){echo $amount;} ?>" type="hidden"/>
							<input id="responseurl" name="responseurl" value="<?php echo $responseurl; ?>" type="hidden"/>
							<input id="hash" name="hash" value="<?php echo $hash; ?>" type="hidden"/>
							<input id="payerName" name="payerName" value="<?php echo $vLastName_loc.' '.$vFirstName_loc.' '.$vOtherName_loc;?>" type="hidden"/>
							<input id="payerEmail" name="payerEmail" value="<?php echo strtolower($_REQUEST['uvApplicationNo']).'@noun.edu.ng'; ?>" type="hidden"/>
							<input id="payerPhone" name="payerPhone" value="<?php echo $vMobileNo_loc; ?>" type="hidden"/>
							<input id="orderId" name="orderId" value="<?php echo $orderId; ?>" type="hidden"/>
							<input id="rrr" name="rrr" value="<?php echo $rrr; ?>" type="hidden"/>
						</form>
					
						<div class="innercont_stff" style="border:1px solid #df1e23; border-radius:4px">
							<div class="div_label">
								RRR
							</div>
							<div  class="div_valu">
								<b><?php echo $rrr;?></b>
							</div>	
						</div><?php
					}
				}
				$stmt1->close();
			}?>
		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;">
			<div id="pp_box">
                <img name="passprt" id="passprt" src="<?php echo get_pp_pix(''); ?>" width="95%" height="185" style="margin:0px;<?php if ($currency <> '1' ){?>opacity:0.3;<?php }?>"/>
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