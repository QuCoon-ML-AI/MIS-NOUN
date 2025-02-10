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



<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
<!--<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico">-->
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
		_('labell_msg0').style.display = 'none';
		
		var formdata = new FormData();
		if (sc_1_loc.uvApplicationNo.value == '')
		{
			setMsgBox("labell_msg0","");
			sc_1_loc.uvApplicationNo.focus();
			return false;
		}		
		
		formdata.append("ilin", sc_1_loc.ilin.value);
		formdata.append("vApplicationNo", sc_1_loc.vApplicationNo.value);
		formdata.append("uvApplicationNo", sc_1_loc.uvApplicationNo.value);
		
		formdata.append("staff_study_center", sc_1_loc.user_centre.value);
		formdata.append("arch_mode_hd", sc_1_loc.arch_mode_hd.value);
            
        formdata.append("sRoleID", _('sRoleID').value);
		
		formdata.append("mm", sc_1_loc.mm.value);
        
		opr_prep(ajax = new XMLHttpRequest(),formdata);
	}
	
	
	function opr_prep(ajax,formdata)
	{
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		
		ajax.open("POST", "opr_sc_1.php");
		ajax.send(formdata);
	}


    function completeHandler(event)
    {
        on_error('0');
        on_abort('0');
        in_progress('0');

        var returnedStr = event.target.responseText;
		
		if (returnedStr.indexOf('Invalid') != -1 || returnedStr.indexOf('number must be') != -1 || returnedStr.indexOf('not yet') != -1 || returnedStr.indexOf('does not') != -1)
		{
			caution_box(returnedStr);
		}else
		{
			_("sc_1_loc").target = '_blank';

			if (sc_1_loc.sm.value == 2 || sc_1_loc.sm.value == 5)
			{
				_("sc_1_loc").action = '../appl/preview-form';
				_("sc_1_loc").submit();
				return;
			}

			if (sc_1_loc.sm.value == 3 || sc_1_loc.sm.value == 6)
			{

				if (returnedStr.indexOf('ELX') != -1)
				{
					admltr.action = '../appl/see-admission-slip';
				}else if (returnedStr.indexOf('PSZ') != -1)
				{
					admltr.action = '../appl/see-admission-letter';
				}else if (returnedStr.indexOf('PRX') != -1)
				{
					admltr.action = '../appl/see-admission-letter-phd';
				}else if (returnedStr.indexOf('MSC415') != -1 || returnedStr.indexOf('MSC416') != -1)
				{
					admltr.action = '../appl/see-admission-letter-cemba';
				}
				
				admltr.vApplicationNo.value = admltr.uvApplicationNo.value;
				admltr.uvApplicationNo.value = _("sc_1_loc").uvApplicationNo.value;
				admltr.submit();
				return;
			}else if (sc_1_loc.sm.value == 3)
			{

			}
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


	$(document).ready(function ()
    {		
		$('#gridz').dataTable({
				deferRender: true,
                fixedHeader: {
                header: true,
                footer: true,
            },
			

            
            columns: [
                { data: 'sn'},
                { data: 'mtn'},
            ],
            dom: 'Bfrtip',
			
            buttons: 
            [
                {
                    extend: 'excelHtml5',
                    title: 'Pending requests for re-activation',
                    exportOptions: { columns: [ 0, 1 ] },
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Pending requests for re-activation',
                    exportOptions: { columns: [ 0, 1 ] },
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
    td, table th
    {
        text-align:left;
        line-height:1.5;
    }
</style><?php

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
	</form>
        
	<form action="<?php echo APPL_BASE_FILE_NAME;?>see-admission-letter" method="post" name="admltr" target="_blank" enctype="multipart/form-data">
		<input name="mm" type="hidden" value="<?php echo $_REQUEST["mm"];?>" />
		<input name="sm" type="hidden" value="<?php echo $_REQUEST["sm"];?>" />
		
		<input name="uvApplicationNo" id="uvApplicationNo" type="hidden" value="<?php if (isset($vApplicationNo)){echo $vApplicationNo;} ?>" />
		<input name="vApplicationNo" id="vApplicationNo" type="hidden" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
		<input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
		<input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />

		<input name="study_mode" id="study_mode" type="hidden" value="<?php if (isset($_REQUEST["study_mode"]) && $_REQUEST["study_mode"] <> ''){echo $_REQUEST["study_mode"];}?>" />		

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
		<!-- InstanceBeginEditable name="EditRegion6" -->
            <input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID_u ?>" />

			<div class="innercont_top" style="margin-bottom:0px;">Student's request</div>
            <form action="student-requests" method="post" name="sc_1_loc" id="sc_1_loc" enctype="multipart/form-data">
                <input name="save_cf" id="save_cf" type="hidden" value="-1" />
				
                <input name="tabno" id="tabno" type="hidden" 
                    value="<?php if (isset($_REQUEST['tabno'])){echo $_REQUEST['tabno'];}else{echo '0';} ?>"/>
                <input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                <input name="frm_upd" id="frm_upd" type="hidden" />
                <input name="user_cEduCtgId" id="user_cEduCtgId" type="hidden" value="go"/>
                <input name="pasUpldFlg" id="pasUpldFlg" type="hidden" value="0"/>
                <input name="upld_passpic_no" id="upld_passpic_no" type="hidden" value="<?php echo $orgsetins['upld_passpic_no']; ?>"/>
                <input name="uvApplicationNo_loc" id="uvApplicationNo_loc" type="hidden" />
                <input name="app_frm_no" id="app_frm_no" type="hidden" />
                <input name="pc_char" id="pc_char" type="hidden" value="<?php echo $orgsetins['pc_char'];?>" />
                
                <input name="userInfo_f" id="userInfo_f" type="hidden" value="<?php echo $cFacultyId_u ?>" />
                <input name="userInfo_d" id="userInfo_d" type="hidden" value="<?php echo $cdeptId_u ?>" />
                                
                <input name="cAcademicDesc" id="cAcademicDesc" type="hidden" value="<?php echo $orgsetins["cAcademicDesc"]; ?>" />
                <input name="tSemester" id="tSemester" type="hidden" value="<?php echo $tSemester; ?>" />
                <input name="next_level_frm_var" id="next_level_frm_var" type="hidden"/>
                <input name="tab_id" id="tab_id" type="hidden" value="<?php if (isset($_REQUEST['tab_id'])){echo $_REQUEST['tab_id'];}?>"/>
                <input name="whattodo" id="whattodo" type="hidden" value="<?php if(isset($_REQUEST['whattodo'])){echo $_REQUEST['whattodo'];}else{echo '';}?>" />
			
				<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>

				<!-- <input name="uvApplicationNo" id="uvApplicationNo" type="hidden" /> -->

                <?php frm_vars();
				$show_bilk = 'none';
				if (check_scope3('Technical support', 'Student request', 'Re-activate matric number') > 0)
				{
					$show_bilk = 'block';
				}?>

				<div id="container_cover_in_chkps" class="center" style="display: <?php echo $show_bilk;?>; 
					flex-direction:column; 
					gap:8px;  
					justify-content:space-around; 
					height:auto;
					padding:10px;
					box-shadow: 2px 2px 8px 2px #726e41;
					z-Index:3;
					background-color:#fff;
					max-height:550px;
					overflow:auto;
					overflow-x: hidden;" 
					title="Press escape to close">
					<div style="line-height:1.5; width:600px; font-weight:bold; margin-bottom:20px;">
						Pending requests for re-activation
					</div>
					<div style="line-height:1.5; width:20px; position:absolute; top:10px; right:10px; margin-bottom:20px;">
						<img style="width:17px; height:17px; cursor:pointer" src="./img/close.png" 
						onclick="_('container_cover_in_chkps').style.zIndex = -1;
							_('container_cover_in_chkps').style.display = 'none';"/>
					</div>

					<table id="gridz" class="table table-condensed table-responsive" style="width:100%;">
						<thead>
							<tr>
								<th style="text-align:right; padding-right:5%; width:20%">Sn</th>
								<th style="width:75%">Matriculation number</th>
							</tr>
						</thead><?php				
						$stmt = $mysqli->prepare("SELECT vMatricNo FROM mtn_act_request");
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($vMatricNo);
						$sno = 0;?>
						<tbody><?php
							while($stmt->fetch())
							{
								if ($sno%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
								<tr style="background-color:<?php echo $background_color;?>;">
									<td style="text-align:right; padding-right:5%"><?php echo ++$sno;?></td>
									<td><?php echo $vMatricNo;?></td>
								</tr><?php
							}
							$stmt->close();?>
						</tbody>
					</table>
				</div><?php
                require_once("student_requests.php");?>

                <div class="innercont_stff" style="width:80%;display:<?php if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] <> ''){echo 'display';}else{echo 'none';}?>">
                    <div class="div_select" style="text-align:right">
						Application form number
                    </div>

                    <div id="uvApplicationNo_div" class="div_select">
                        <input name="uvApplicationNo" id="uvApplicationNo" type="text" class="textbox"  
                        placeholder="Enter AFN/Mat. no. here"
                        onchange="this.value=this.value.trim();
                        this.value=this.value.toUpperCase();" />
                    </div>
                    <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
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