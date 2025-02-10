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
// require_once('ids_1.php');
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
$spgs_msg = '';

if (isset($_REQUEST['uvApplicationNo']) && $_REQUEST['uvApplicationNo'] <> '' && (($mm == 0 && $sm >= 9) || $mm == 1 || $mm == 8 || $mm == 3 || ($mm == 2 && $sm > 1) || ($mm == 4) || $mm == 5))
{
    if ($mm == 8 && $cEduCtgId <> 'PGX' && $cEduCtgId <> 'PGY' && $cEduCtgId <> 'PGZ' && $cEduCtgId <> 'PRX')
    {
        $spgs_msg = 'Matriculaton number must be that of an MPhil, PhD or postgraduate student';
    }else if ($mm == 1 && ($cEduCtgId == 'PRX' || $cEduCtgId == 'PGZ'))
    {
        $spgs_msg = 'Matriculaton number must be that of an undergraduate, PGD or Masters student';
    }
}?>

<!-- InstanceBeginEditable name="doctitle" -->
<title>NOUN-MIS</title>
<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
<!-- InstanceEndEditable -->

<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
<link rel="stylesheet"  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet"  href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<link rel="stylesheet"  href="https://cdn.datatables.net/plug-ins/9dcbecd42ad/integration/jqueryui/dataTables.jqueryui.css">


<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="https:///cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>


<script type="text/javascript">
    $(document).ready(function ()
    {
		$('#gridz1').dataTable({
        	"reponsive": "true",
           	"pagingType": "full_numbers"
         });
		
		$('#gridz').dataTable({
				deferRender: true,
                fixedHeader: {
                header: true,
                footer: true,
            },
			

            
            columns: [
                { data: 'sn'},
                { data: 'date'},
                { data: 'describe'},
                { data: 'debit'},
                { data: 'credit'},
                { data: 'balance'},
            ],
            dom: 'Bfrtip',
			
            buttons: 
            [
                {
                    extend: 'excelHtml5',
                    title: 'Statement of account',
                    exportOptions: { columns: [ 0, 1, 2, 3, 4, 5 ] },
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Statement of account',
                    exportOptions: { columns: [ 0, 1, 2, 3, 4, 5 ] },
                    messageTop: 'Students Records',
                    messageBottom: 'Powered by NOUMIS',
                    title: 'National Open University of Nigeria:',
                    margin: [ 2, 2, 2, 2],
                    pageSize: 'A4',
                    orientation: 'portrate',
                },
                'print'
            ]
        } );
    });
</script>

<style>
    table td, table th
    {
        text-align:left;
        line-height:1.5;
    }
</style>

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
        var numbers = /^[NOUNSLPC0-9_]+$/;

		var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			ulChildNodes[j].style.display = 'none';
		}
				
		if (_('std_acnt_stff').uvApplicationNo.value == '')
		{
			setMsgBox("labell_msg0","");
			_('std_acnt_stff').uvApplicationNo.focus();
			return false;
		}else if (!_('std_acnt_stff').uvApplicationNo.value.match(numbers))
        {
            setMsgBox("labell_msg0","Invalid number");
			_('std_acnt_stff').uvApplicationNo.focus();
			return false;
        }else if(marlic(_('std_acnt_stff').uvApplicationNo.value)!='')
		{
			setMsgBox("labell_msg0",marlic(_('std_acnt_stff').uvApplicationNo.value));
			_('std_acnt_stff').uvApplicationNo.focus();
			return false;
		}else
		{
			var formdata = new FormData();
			
			formdata.append("currency_cf", _("currency_cf").value);
			formdata.append("user_cat", _('std_acnt_stff').user_cat.value);
			formdata.append("save_cf", _("save_cf").value);
			formdata.append("uvApplicationNo", _('std_acnt_stff').uvApplicationNo.value);
			formdata.append("vApplicationNo", _('std_acnt_stff').vApplicationNo.value);
			formdata.append("sm", _('std_acnt_stff').sm.value);
			formdata.append("mm", _('std_acnt_stff').mm.value);
			
			opr_prep(ajax = new XMLHttpRequest(),formdata);			
		}
	}
	
	
	function opr_prep(ajax,formdata)
	{
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		
		ajax.open("POST", "opr_cf.php");
		ajax.send(formdata);
	}

		function completeHandler(event)
		{
			on_error('0');
			on_abort('0');
			in_progress('0');

            if (event.target.responseText.indexOf("Invalid") == -1 && event.target.responseText.indexOf("not submitted") == -1)
            {
                _("std_acnt_stff").submit();
            }else
            {
                if (_('tabss5'))
                {
                    _('std_account').style.display = 'none';
                    _('tabss5').style.display = 'none';
                }
				caution_box(event.target.responseText)
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
		<input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST['vMatricNo'])){echo $_REQUEST['vMatricNo']; }?>" />
        <input name="uvApplicationNo" id="uvApplicationNo" type="hidden" />
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
	<div id="rtlft_std" style="position:relative;"><?php
		$vbank_name = '';
		$acn_name = '';
		$acn_no = '';

		$stmt = $mysqli->prepare("SELECT vDesc, acn_name, acn_no FROM s_bank_d a, banks b WHERE a.bank_id = b.ccode AND vMatricNo = ?");
		$stmt->bind_param("s", $uvApplicationNo_2);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($vbank_name, $acn_name, $acn_no);
		$stmt->fetch();
		$stmt->close();?>

		<div id="bank_detail_div" class="center" 
			style="transform: translate(-51.5%, -51%);
			width:40vw; 
			height:auto;
			border:1px solid #CCCCCC; 
			padding:10px; 
			display:none;
			box-shadow: 4px 4px 3px #888888; 
			background:#ffffff; z-index:7;">
			<div id="div_header" class="innercont_stff" style="height:auto; color:#FFFFFF; margin-bottom:5px; width:97.4%; color:#637649;">
				Bank detail for <?php echo $vLastName.', '.$vFirstName.' '.$vOtherName.' '.$uvApplicationNo_2;?>
			</div>

			<div class="innercont_stff" style="height:auto; color:#FFFFFF; margin-bottom:5px; width:2%; color:#637649; text-align:right;">
				<img style="width:17px; height:17px; cursor:pointer" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" 
					onclick="_('bank_detail_div').style.zIndex = '-1';
					_('bank_detail_div').style.display='none';
				
					_('general_smke_screen').style.zIndex = '-1';
					_('general_smke_screen').style.display = 'none';
					return false"/>
			</div>

			<hr style="height:5px; width:100%; margin-top:6px;  margin-bottom:0.5%; background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0px; height:1px;" />

			<div class="innercont_stff" style="padding-top:4x;">
				<label for="user_names" class="labell" style="width:145px; margin-left:7px;">Bank</label>
				<div class="div_select">
					<input name="exist_user" id="exist_user" class="textbox" 
						style="height:78%;
						padding-left:6px;"
						readonly
						value="<?php echo $vbank_name; ?>"/>                
				</div>
			</div>

			<div class="innercont_stff" style="padding-top:4x;">
				<label for="user_names" class="labell" style="width:145px; margin-left:7px;">Account name</label>
				<div class="div_select">
					<input name="exist_user" id="exist_user" class="textbox" 
						style="height:78%;
						padding-left:6px;"
						readonly
						value="<?php echo $acn_name; ?>"/>                
				</div>
			</div>

			<div class="innercont_stff" style="padding-top:4x;">
				<label for="user_names" class="labell" style="width:145px; margin-left:7px;">Account number</label>
				<div class="div_select">
					<input name="exist_user" id="exist_user" class="textbox" 
						style="height:78%;
						padding-left:6px;"
						readonly
						value="<?php echo $acn_no; ?>"/>                
				</div>
			</div>
		</div>
		
        <form action="print-result" method="post" name="prns_form" target="_blank" id="prns_form" enctype="multipart/form-data">
            <input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];}; ?>" />
            <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];}; ?>" />
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
            <input name="side_menu_no" type="hidden" value="1" />
            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
            <input name="save" id="save" type="hidden" value="-1" />
            <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
            <input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />
            <input name="mm" id="mm" type="hidden" value="<?php echo $mm; ?>" />
            <input name="sm" id="sm" type="hidden" value="<?php echo $sm; ?>" />

			<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
        </form>
		<!-- InstanceBeginEditable name="EditRegion6" -->			
			
			<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>

            <div class="innercont_top">View student's account</div><?php
			
			$staff_can_access = 1;?>

            <form method="post" name="std_acnt_stff" id="std_acnt_stff" enctype="multipart/form-data">
                <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
                <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];} ?>" />	
                <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                <input name="sm" id="sm" type="hidden" value="<?php echo $sm ?>" />
                <input name="mm" id="mm" type="hidden" value="<?php echo $mm ?>" />
                <input name="save_cf" id="save_cf" type="hidden" value="-1" />
                <input name="conf" id="conf" type="hidden" value="" />
                <input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
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

				<div class="innercont_stff">
					<label for="vApplicationNo" class="labell">
						Matriculation number
					</label>
					<div class="div_select">
                        <input name="uvApplicationNo" id="uvApplicationNo" 
							type="text" 
							class="textbox"
                            maxlength="25"
							onchange="this.value=this.value.replace(/ /g, '');
							this.value=this.value.toUpperCase();" required 
							placeholder="Enter matriculation number here"
							value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];}; ?>"/>
					</div>
					<div id="labell_msg0" class="labell_msg blink_text orange_msg" style="float:left; width:auto; margin-right:6px"></div>
				</div>

				<div class="innercont_stff" style="margin-top:15px">
					<label for="vApplicationNo" class="labell"></label>
					<div class="div_select" style="width:auto">
						<input name="report_form" id="report_form" 
						value="0" 
						type="checkbox"
						<?php if (isset($_REQUEST["report_form"])){echo ' checked';}?>/>
					</div>							
					<div class="div_select" style="width:auto; margin-right:25px">
						<label for="report_form" id="report_form">
							Comprehensive
						</label>
					</div>

					<div class="div_select" style="width:auto">
						<input name="id_no" id="id_no_1" 
						value="0" 
						type="radio"
						<?php if (!isset($_REQUEST["id_no"]) || (isset($_REQUEST["id_no"]) && $_REQUEST["id_no"] == '0')){echo ' checked';}?>/>
					</div>							
					<div class="div_select" style="width:auto; margin-right:15px">
						<label for="id_no_1" id="id_no_1">
							Format 1
						</label>
					</div>

					<div class="div_select" style="width:auto">
						<input name="id_no" id="id_no_2"
						value="1"
						type="radio"
						<?php if (isset($_REQUEST["id_no"]) && $_REQUEST["id_no"] == '1'){echo ' checked';}?>/>
					</div>							
					<div class="div_select">
						<label for="id_no_2" id="id_no_2">
							Format 2
						</label>
					</div>
				</div>
            </form><?php 
			/*if (check_scope2('Academic registry','Archive') > 0 && isset($_REQUEST["mm"]) && $_REQUEST["mm"] == 4)
			{?>
				<div class="innercont_stff" style="width:auto; height:auto; position:absolute; right:260px; top:38px;">
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
									std_acnt_stff.arch_mode_hd.value='1';
									std_stat.arch_mode_hd.value='1';
									prns_form.arch_mode_hd.value='1';
								}else
								{
									nxt.arch_mode_hd.value='0';
									cf.arch_mode_hd.value='0';
									std_acad_hist.arch_mode_hd.value='0';
									chk_pay_sta.arch_mode_hd.value='0';
									vw_std_acnt_stff.arch_mode_hd.value='0';
									std_acnt_stff.arch_mode_hd.value='0';
									std_stat.arch_mode_hd.value='0';
									prns_form.arch_mode_hd.value='0';
								}" 
								<?php if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1'){echo 'checked';} ?>/>
						</div>
						<div class="div_select" style="width:130px; height:25px; padding:5px; margin-right:0px; background:#f3f3f3">
							Look in the archive
						</div>                   
					</label>
				</div><?php
			}*/?>
			<a href="#" style="text-decoration:none;" 
				onclick="_('bank_detail_div').style.zIndex = '2';
				_('bank_detail_div').style.display='block';
			
				_('general_smke_screen').style.zIndex = '2';
				_('general_smke_screen').style.display = 'block';
				return false;">
				<div class="rtlft_inner_button" style="position:absolute; right:130px; top:25px; padding:10px; width:110px; height:auto">
					See bank detail
				</div>
			</a><?php
			if (check_scope2('SPGS', 'SPGS menu') > 0)
			{?>
				<a href="#" style="text-decoration:none;" 
					onclick="pg_environ.mm.value=8;pg_environ.sm.value='';pg_environ.submit();return false;">
					<div class="rtlft_inner_button" style="position:absolute; right:0; top:25px; padding:10px; width:110px; height:auto">
						SPGS menu
					</div>
				</a><?php
			}

			if ($student_user_num <= 0 && isset($_REQUEST["uvApplicationNo"]) && trim($_REQUEST["uvApplicationNo"]) <> '')
            {
				if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                {
                    caution_box('Matriculation number not in the archive');
                }else
                {
                    caution_box('Invalid matriculation numbers');
                }
            }else if ($spgs_msg <> '')
			{
				caution_box($spgs_msg);
				
			}else if ($staff_can_access == 0 && isset($_REQUEST['uvApplicationNo']) && $_REQUEST['uvApplicationNo'] <> '')
            {
                $msg = "Record not found<br>Possible reasons are<br> (a) Student study centre does not match that of staff that is logged in<br> (b) Record not in selected faculty";
                caution_box($msg);
            }else if (isset($_REQUEST["uvApplicationNo"]) && trim($_REQUEST["uvApplicationNo"]) <> '')
            {
                if (check_grad_student($_REQUEST["uvApplicationNo"]) == 1)
				{
					caution_box_inline_bkp('Matriculation number graduated');
				}

				if (isset($_REQUEST["report_form"]))
				{				
					$stmt = $mysqli->prepare("SELECT tdate, cCourseId, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester) vDesc, a.Amount Amount_a, vremark, a.RetrievalReferenceNumber, b.fee_item_desc, a.tSemester
					FROM s_tranxion_cr a, fee_items b
					WHERE a.fee_item_id = b.fee_item_id
					AND b.cdel = 'N'
					AND vMatricNo = ?
					ORDER BY tdate, b.fee_item_desc;");
				}else
				{
					$stmt = $mysqli->prepare("SELECT tdate, cCourseId, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester) vDesc, a.Amount Amount_a, vremark, a.RetrievalReferenceNumber, b.fee_item_desc, a.tSemester
					FROM s_tranxion_cr a, fee_items b
					WHERE a.fee_item_id = b.fee_item_id
					AND a.tdate NOT LIKE '0000%'
					AND LEFT(a.tdate,10) > '$account_close_date'
					AND b.cdel = 'N'
					AND vMatricNo = ?
					ORDER BY tdate, b.fee_item_desc;");
				}

                $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
                $stmt->execute();
                $stmt->store_result();
				$stmt->bind_result($tdate_1, $cCourseId_1, $vDesc_1, $Amount_a_1, $vremark, $RetrievalReferenceNumber, $fee_item_desc, $tSemester_1);		

				$cnt = 0;
				$balance = 0;

				$stmt_b = $mysqli->prepare("SELECT n_balance, actual_balance, narata
				FROM s_tranxion_prev_bal1
				WHERE vMatricNo = ?;");							
				$stmt_b->bind_param("s", $_REQUEST["uvApplicationNo"]);
				$stmt_b->execute();
				$stmt_b->store_result();
				$stmt_b->bind_result($Amount_bal, $aAmount_bal, $narata);
				$stmt_b->fetch();
				
				if (is_null($Amount_bal))
				{
					$Amount_bal = 0.00;
					$narata = 'Opening balance';
				}

				

				$stmt_b = $mysqli->prepare("SELECT SUM(amount)
				FROM s_tranxion_cr
				WHERE (tdate >= '$semester_begin_date' AND tdate < '$account_open_date')
				AND vMatricNo = ?");							
				$stmt_b->bind_param("s", $_REQUEST["uvApplicationNo"]);
				$stmt_b->execute();
				$stmt_b->store_result();
				$stmt_b->bind_result($old_cr_bal);
				$stmt_b->fetch();
				
				if (is_null($old_cr_bal))
				{
					$old_cr_bal = 0.00;
				}
				
				

				$stmt_b = $mysqli->prepare("SELECT SUM(amount)
				FROM $wrking_tab
				WHERE (tdate >= '$semester_begin_date' AND tdate < '$account_open_date')
				AND cCourseId NOT LIKE 'F0%'
				AND trans_count IS NOT NULL
				AND vMatricNo = ?;");							
				$stmt_b->bind_param("s", $_REQUEST["uvApplicationNo"]);
				$stmt_b->execute();
				$stmt_b->store_result();
				$stmt_b->bind_result($old_dr_bal);
				$stmt_b->fetch();
				$stmt_b->close();
				
				if (is_null($old_dr_bal))
				{
					$old_dr_bal = 0.00;
				}			
				

				if ($Amount_bal <> $aAmount_bal)
				{?>
					<div class="innercont_stff" style="margin-top:0px; height:25px;">
						<div class="div_label" style="width:75%; text-align:right">
							Posted balance
						</div>
						<div  class="div_valu" style="width:20%; padding-right:20px; text-align:right; background:#e9ebe9">
							<?php echo number_format($Amount_bal);?>
						</div>	
					</div>					
					
					<div class="innercont_stff" style="margin-top:0px; height:25px;">
						<div class="div_label" style="width:75%; text-align:right">
							<?php echo 'Balance on the new system from '.$semester_begin_date.' to '.$account_close_date.'<br>';?>
						</div>	
					</div>

					<div class="innercont_stff" style="margin-top:0px; height:25px;">
						<div class="div_label" style="width:75%; text-align:right">
							Credit balance
						</div>
						<div  class="div_valu" style="width:20%; padding-right:20px; text-align:right; background:#e9ebe9">
							<?php echo number_format($old_cr_bal);?>
						</div>	
					</div>

					<div class="innercont_stff" style="margin-top:0px; height:25px;">
						<div class="div_label" style="width:75%; text-align:right">
							Debit balance
						</div>
						<div  class="div_valu" style="width:20%; padding-right:20px; text-align:right; background:#e9ebe9">
							<?php echo number_format($old_dr_bal);?>
						</div>	
					</div>

					<div class="innercont_stff" style="margin-top:0px; height:25px;">
						<div class="div_label" style="width:75%; text-align:right">
							Net
						</div>
						<div  class="div_valu" style="width:20%; padding-right:20px; text-align:right; background:#e9ebe9">
							<?php echo number_format($Amount_bal + ($old_cr_bal - $old_dr_bal));?>
						</div>	
					</div><?php
				}
				
				$Amount_bal = $Amount_bal + ($old_cr_bal - $old_dr_bal);

				if (!isset($_REQUEST["id_no"]) || (isset($_REQUEST["id_no"]) && $_REQUEST["id_no"] == '0'))
				{?>
					<table id="gridz1" class="table table-condensed table-responsive" style="width:95%;">
						<thead>
							<tr>
								<th style="text-align:right; width:8%; padding-right:2%">Sn</th>
								<th style="width:15%;">Date</th>
								<th style="width:30%;">Fee item-Item-Semester (-RRR)</th>
								<th style="text-align:right; width:13%; padding-right:2%">Debit</th>
								<th style="text-align:right; width:13%; padding-right:2%">Credit</th>
								<th style="text-align:right; width:13%; padding-right:2%">Balance</th>
							</tr>
						</thead><?php
						
						if (!isset($_REQUEST["report_form"]))
						{?>
							<tr>
								<td style="text-align:right; width:8%; padding-right:2%"><?php echo ++$cnt;?></td>
								<td style="widtd:15%;"><?php echo $account_open_date; ?></td>
								<td style="width:30%;">
									<?php echo $narata;?>
								</td>
								<td style="text-align:right; width:13%; padding-right:2%"><?php 
									if ($Amount_bal < 0.00)
									{
										echo number_format($Amount_bal);
										$balance = $Amount_bal;
									}else
									{
										echo '--';
									}?></td>
								<td style="text-align:right; width:13%; padding-right:2%"><?php 
									if ($Amount_bal >= 0.00)
									{
										echo number_format($Amount_bal);
										$balance = $Amount_bal;
									}else
									{
										echo '--';
									}?>
								</td>
								<td style="text-align:right; width:13%; padding-right:2%"><?php echo number_format($balance);?></td>
							</tr><?php
						}

						while($stmt->fetch())
						{?>
							<tr>
								<td style="text-align:right; width:8%; padding-right:2%"><?php echo ++$cnt;?></td>
								<td style="widtd:15%;"><?php echo $tdate_1; ?></td>
								<td style="width:30%;"><?php 
									/*if (!is_bool(strpos($vDesc_1, "internal")))
									{
										if ($cCourseId_1 <> 'xxxxxx' && strlen($cCourseId_1) == 6){echo ' '.$cCourseId_1.' ';}
										echo $vDesc_1;
										if($vremark == 'Registration Deduction'){echo ' '.$fee_item_desc;}else{echo ' '.$vremark;}
										if ($RetrievalReferenceNumber <> '0000'){echo ' '.$RetrievalReferenceNumber;}
									}else
									{
										echo ucfirst(strtolower($vremark));
									}*/
											
									echo ucfirst(strtolower($vremark)).'-'.$cCourseId_1.'-'.$tSemester_1;
									if ($RetrievalReferenceNumber <> '0000'){echo '-'.$RetrievalReferenceNumber;}
									if (!is_bool(strpos($vDesc_1, "internal")))
									{
										echo '-'.$vDesc_1.'-';
										//if ($RetrievalReferenceNumber <> '0000'){echo '-'.$RetrievalReferenceNumber;}
									}?>
								</td>
								<td style="text-align:right; width:13%; padding-right:2%">--</td>
								<td style="text-align:right; width:13%; padding-right:2%"><?php 
									echo number_format($Amount_a_1);$balance += $Amount_a_1;?>
								</td>
								<td style="text-align:right; width:13%; padding-right:2%"><?php echo number_format($balance);?></td>
							</tr><?php 
						}
						
						
						if (isset($_REQUEST["report_form"]))
						{
							if(substr($_REQUEST["uvApplicationNo"],3,2) <= 19)
							{
								$tables = '2017,2018,2019,20202021,20222023,20242025';
							}else if(substr($_REQUEST["uvApplicationNo"],3,2) == 20 || substr($_REQUEST["uvApplicationNo"],3,2) == 21)
							{
								$tables = '20202021,20222023,20242025';
							}else if(substr($_REQUEST["uvApplicationNo"],3,2) == 22 || substr($_REQUEST["uvApplicationNo"],3,2) == 23)
							{
								$tables = '20222023,20242025';
							}else
							{
								$tables = '20242025';
							}
							
							$table = explode(",", $tables);

							foreach ($table as &$value)
							{
								$wrking_tab = 's_tranxion_'.$value;								
						
								$stmt = $mysqli->prepare("SELECT cCourseId, tdate, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester,'-',fee_item_desc) vDesc,  tSemester, a.Amount Amount_a, vremark, a.RetrievalReferenceNumber, b.fee_item_desc 
								FROM $wrking_tab a, fee_items b
								WHERE a.fee_item_id = b.fee_item_id
								AND b.cdel = 'N'
								AND vMatricNo = ?
								ORDER BY cTrntype, tdate;");
								
								$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
								$stmt->execute();
								$stmt->store_result();
								$stmt->bind_result($cCourseId_1, $tdate_1, $vDesc_1, $tSemester_1, $Amount_a_1, $vremark, $RetrievalReferenceNumber, $fee_item_desc);
								
								if ($stmt->num_rows === 0)
								{
									//caution_box('There are no transactions to display');
								}else
								{
									while($stmt->fetch())
									{?>
										<tr>
											<td style="text-align:right; width:8%; padding-right:2%"><?php echo ++$cnt;?></td>
											<td style="widtd:15%;"><?php echo $tdate_1; ?></td>
											<td style="width:30%;"><?php 
												/*if (!is_bool(strpos($vDesc_1, "internal")))
												{
													echo $vDesc_1.'-'.$cCourseId_1.'-'.$tSemester_1;					
													if ($RetrievalReferenceNumber <> '0000'){echo '-'.$RetrievalReferenceNumber;}
												}else
												{
													echo ucfirst(strtolower($vremark));
												}*/
												
												//echo $fee_item_desc.'-'.ucfirst(strtolower($vremark)).'-'.$cCourseId_1.'-'.$tSemester_1;
												echo $fee_item_desc.'-'.$cCourseId_1.'-'.$tSemester_1;
												if ($RetrievalReferenceNumber <> '0000'){echo '-'.$RetrievalReferenceNumber;}
												if (!is_bool(strpos($vDesc_1, "internal")))
												{
													echo '-'.$vDesc_1.'-';					
													//if ($RetrievalReferenceNumber <> '0000'){echo '-'.$RetrievalReferenceNumber;}
												}?>
											</td>
											<td style="text-align:right; width:13%; padding-right:2%"><?php 
												echo '-'.number_format($Amount_a_1);$balance -= $Amount_a_1;?>
											</td>
											<td style="text-align:right; width:13%; padding-right:2%">--
											</td>
											<td style="text-align:right; width:13%; padding-right:2%"><?php echo number_format($balance);?></td>
										</tr><?php 
									} 
								}
							}
						}else
						{					
							$stmt = $mysqli->prepare("SELECT cCourseId, tdate, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester,'-',fee_item_desc) vDesc,  tSemester, a.Amount Amount_a, vremark, a.RetrievalReferenceNumber, b.fee_item_desc 
							FROM $wrking_tab a, fee_items b
							WHERE a.fee_item_id = b.fee_item_id
							AND a.tdate NOT LIKE '0000%'
							AND LEFT(a.tdate,10) > '$account_close_date'
							AND b.cdel = 'N'
							AND vMatricNo = ?
							ORDER BY cTrntype, tdate;");
							
							$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($cCourseId_1, $tdate_1, $vDesc_1, $tSemester_1, $Amount_a_1, $vremark, $RetrievalReferenceNumber, $fee_item_desc);
							
							if ($stmt->num_rows === 0)
							{
								//caution_box('There are no transactions to display');
							}else
							{
								while($stmt->fetch())
								{?>
									<tr>
										<td style="text-align:right; width:8%; padding-right:2%"><?php echo ++$cnt;?></td>
										<td style="widtd:15%;"><?php echo $tdate_1; ?></td>
										<td style="width:30%;"><?php 
											/*if (!is_bool(strpos($vDesc_1, "internal")))
											{
												echo $vDesc_1.'-'.$cCourseId_1.'-'.$tSemester_1;					
												if ($RetrievalReferenceNumber <> '0000'){echo '-'.$RetrievalReferenceNumber;}
											}else
											{
												echo ucfirst(strtolower($vremark));
											}*/
											
											//echo $fee_item_desc.'-'.ucfirst(strtolower($vremark)).'-'.$cCourseId_1.'-'.$tSemester_1;
											echo $fee_item_desc.'-'.$cCourseId_1.'-'.$tSemester_1;
											if ($RetrievalReferenceNumber <> '0000'){echo '-'.$RetrievalReferenceNumber;}

											if (!is_bool(strpos($vDesc_1, "internal")))
											{
												echo '-'.$vDesc_1.'-';					
												//if ($RetrievalReferenceNumber <> '0000'){echo '-'.$RetrievalReferenceNumber;}
											}?>
										</td>
										<td style="text-align:right; width:13%; padding-right:2%"><?php 
											echo '-'.number_format($Amount_a_1);$balance -= $Amount_a_1;?>
										</td>
										<td style="text-align:right; width:13%; padding-right:2%">--
										</td>
										<td style="text-align:right; width:13%; padding-right:2%"><?php echo number_format($balance);?></td>
									</tr><?php 
								} 
							}
						}?>
					</table><?php
				}else if (isset($_REQUEST["id_no"]) && $_REQUEST["id_no"] == '1')
				{?>
					<table id="gridz" class="table table-condensed table-responsive" style="width:95%;">
						<thead>
							<tr>
								<th style="text-align:right; width:8%; padding-right:2%">Sn</th>
								<th style="width:15%;">Date</th>
								<th style="width:30%;">Fee item-Item-Semester (-RRR)</th>
								<th style="text-align:right; width:13%; padding-right:2%">Debit</th>
								<th style="text-align:right; width:13%; padding-right:2%">Credit</th>
								<th style="text-align:right; width:13%; padding-right:2%">Balance</th>
							</tr>
						</thead><?php
												
						if (!isset($_REQUEST["report_form"]))
						{?>
							<tr>
								<td style="text-align:right; width:8%; padding-right:2%"><?php echo ++$cnt;?></td>
								<td style="widtd:15%;"><?php echo $account_open_date; ?></td>
								<td style="width:30%;">
									Opening balance
								</td>
								<td style="text-align:right; width:13%; padding-right:2%"><?php 
									if ($Amount_bal < 0.00)
									{
										echo number_format($Amount_bal);
										$balance = $Amount_bal;
									}else
									{
										echo '--';
									}?></td>
								<td style="text-align:right; width:13%; padding-right:2%"><?php 
									if ($Amount_bal >= 0.00)
									{
										echo number_format($Amount_bal);
										$balance = $Amount_bal;
									}else
									{
										echo '--';
									}?>
								</td>
								<td style="text-align:right; width:13%; padding-right:2%"><?php echo number_format($balance);?></td>
							</tr><?php
						}

						//$stmt->data_seek(0);
						while($stmt->fetch())
						{?>
							<tr>
								<td style="text-align:right; width:8%; padding-right:2%"><?php echo ++$cnt;?></td>
								<td style="widtd:15%;"><?php echo $tdate_1; ?></td>
								<td style="width:30%;"><?php 
									/*if (!is_bool(strpos($vDesc_1, "internal")))
									{
										echo $vDesc_1;
										if($vremark == 'Registration Deduction'){echo ' '.$fee_item_desc;}else{echo ' '.$vremark;}
										if ($RetrievalReferenceNumber <> '0000'){echo ' '.$RetrievalReferenceNumber;}
									}else
									{
										echo ucfirst(strtolower($vremark));
									}*/
											
									//echo $fee_item_desc.'-'.ucfirst(strtolower($vremark)).'-'.$cCourseId_1.'-'.$tSemester_1;
									echo $fee_item_desc.'-'.$cCourseId_1.'-'.$tSemester_1;
									if ($RetrievalReferenceNumber <> '0000'){echo '-'.$RetrievalReferenceNumber;}
									if (!is_bool(strpos($vDesc_1, "internal")))
									{
										echo '-'.$vDesc_1.'-';					
										//if ($RetrievalReferenceNumber <> '0000'){echo '-'.$RetrievalReferenceNumber;}
									}?>
								</td>
								<td style="text-align:right; width:13%; padding-right:2%">--</td>
								<td style="text-align:right; width:13%; padding-right:2%"><?php 
									echo number_format($Amount_a_1);$balance += $Amount_a_1;?>
								</td>
								<td style="text-align:right; width:13%; padding-right:2%"><?php echo number_format($balance);?></td>
							</tr><?php 
						}
						
						if (isset($_REQUEST["report_form"]))
						{
							if(substr($_REQUEST["uvApplicationNo"],3,2) <= 19)
							{
								$tables = '2017,2018,2019,20202021,20222023,20242025';
							}else if(substr($_REQUEST["uvApplicationNo"],3,2) == 20 || substr($_REQUEST["uvApplicationNo"],3,2) == 21)
							{
								$tables = '20202021,20222023,20242025';
							}else if(substr($_REQUEST["uvApplicationNo"],3,2) == 22 || substr($_REQUEST["uvApplicationNo"],3,2) == 23)
							{
								$tables = '20222023,20242025';
							}else
							{
								$tables = '20242025';
							}
							
							$table = explode(",", $tables);

							foreach ($table as &$value)
							{
								$wrking_tab = 's_tranxion_'.$value;								
						
								$stmt = $mysqli->prepare("SELECT cCourseId, tdate, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester,'-',fee_item_desc) vDesc,  tSemester, a.Amount Amount_a, vremark, a.RetrievalReferenceNumber, b.fee_item_desc 
								FROM $wrking_tab a, fee_items b
								WHERE a.fee_item_id = b.fee_item_id
								AND b.cdel = 'N'
								AND vMatricNo = ?
								ORDER BY cTrntype, tdate;");
								
								$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
								$stmt->execute();
								$stmt->store_result();
								$stmt->bind_result($cCourseId_1, $tdate_1, $vDesc_1, $tSemester_1, $Amount_a_1, $vremark, $RetrievalReferenceNumber, $fee_item_desc);
								
								if ($stmt->num_rows === 0)
								{
									//caution_box('There are no transactions to display');
								}else
								{
									while($stmt->fetch())
									{?>
										<tr>
											<td style="text-align:right; width:8%; padding-right:2%"><?php echo ++$cnt;?></td>
											<td style="widtd:15%;"><?php echo $tdate_1; ?></td>
											<td style="width:30%;"><?php 
												/*if (!is_bool(strpos($vDesc_1, "internal")))
												{
													echo $vDesc_1.'-'.$cCourseId_1.'-'.$tSemester_1;					
													if ($RetrievalReferenceNumber <> '0000'){echo '-'.$RetrievalReferenceNumber;}
												}else
												{
													echo ucfirst(strtolower($vremark));
												}*/												
											
												echo $fee_item_desc.'-'.$cCourseId_1.'-'.$tSemester_1;
												if ($RetrievalReferenceNumber <> '0000'){echo '-'.$RetrievalReferenceNumber;}
												if (!is_bool(strpos($vDesc_1, "internal")))
												{
													echo '-'.$vDesc_1.'-';					
													//if ($RetrievalReferenceNumber <> '0000'){echo '-'.$RetrievalReferenceNumber;}
												}?>
											</td>
											<td style="text-align:right; width:13%; padding-right:2%"><?php 
												echo '-'.number_format($Amount_a_1);$balance -= $Amount_a_1;?>
											</td>
											<td style="text-align:right; width:13%; padding-right:2%">--
											</td>
											<td style="text-align:right; width:13%; padding-right:2%"><?php echo number_format($balance);?></td>
										</tr><?php 
									} 
								}
							}
						}else
						{
					
							$stmt = $mysqli->prepare("SELECT cCourseId, tdate, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester,'-',fee_item_desc) vDesc,  tSemester, a.Amount Amount_a, vremark, a.RetrievalReferenceNumber, b.fee_item_desc 
							FROM $wrking_tab a, fee_items b
							WHERE a.fee_item_id = b.fee_item_id
							AND a.tdate NOT LIKE '0000%'
							AND LEFT(a.tdate,10) > '$account_close_date'
							AND b.cdel = 'N'
							AND vMatricNo = ?
							ORDER BY cTrntype, tdate;");
							
							$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($cCourseId_1, $tdate_1, $vDesc_1, $tSemester_1, $Amount_a_1, $vremark, $RetrievalReferenceNumber, $fee_item_desc);
							
							if ($stmt->num_rows === 0)
							{
								//caution_box('There are no transactions to display');
							}else
							{
								while($stmt->fetch())
								{?>
									<tr>
										<td style="text-align:right; width:8%; padding-right:2%"><?php echo ++$cnt;?></td>
										<td style="widtd:15%;"><?php echo $tdate_1; ?></td>
										<td style="width:30%;"><?php 
											/*if (!is_bool(strpos($vDesc_1, "internal")))
											{
												echo $vDesc_1.'-'.$cCourseId_1.'-'.$tSemester_1;					
												if ($RetrievalReferenceNumber <> '0000'){echo '-'.$RetrievalReferenceNumber;}
											}else
											{
												echo ucfirst(strtolower($vremark));
											}*/
											
											echo $fee_item_desc.'-'.$cCourseId_1.'-'.$tSemester_1;
											if ($RetrievalReferenceNumber <> '0000'){echo '-'.$RetrievalReferenceNumber;}
											if (!is_bool(strpos($vDesc_1, "internal")))
											{
												echo '-'.$vDesc_1.'-';
											}?>
										</td>
										<td style="text-align:right; width:13%; padding-right:2%"><?php 
											echo '-'.number_format($Amount_a_1);$balance -= $Amount_a_1;?>
										</td>
										<td style="text-align:right; width:13%; padding-right:2%">--
										</td>
										<td style="text-align:right; width:13%; padding-right:2%"><?php echo number_format($balance);?></td>
									</tr><?php 
								} 
							}
						//}
						}?>
					</table><?php
				}
                //}
                
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
                </div><?php 
				if (isset($_REQUEST['uvApplicationNo']))
                {
                    side_detail($_REQUEST['uvApplicationNo']);
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