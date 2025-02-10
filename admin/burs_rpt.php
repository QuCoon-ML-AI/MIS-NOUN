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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script src="../bamboo/sorttable.js"></script><?php
	
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
        $('#gridz').dataTable({
                deferRender: true,
                fixedHeader: {
                header: true,
                footer: true
            },
            
            columns: [
                { data: 'sn'},
                { data: 'namess'},
                { data: 'Regno'},
                { data: 'rrr'},
                { data: 'orderid'},
                { data: 'tdate'},
                { data: 'amount' },
            ],
            dom: 'Bfrtip',
            buttons: 
            [
                {
                    extend: 'excelHtml5',
                    title: '',
                    exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6 ] },
                },
                {
                    extend: 'pdfHtml5',
                    title: '',
                    exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6 ] },
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
        width:14%;
    }
</style>



<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
<script language="JavaScript" type="text/javascript" src="button_ops.js"></script>
<script language="JavaScript" type="text/javascript" src="./bamboo/b_rpt.js"></script>

<script language="JavaScript" type="text/javascript">
    function chk_inputs()
    {
        //if (_('fee_item_n').style.display == 'block' && _('fee_item_n').value == '')
        if (_('fee_item').value == '')
        {
            caution_box('Select a fee item to generate report');
        }/*else if (_('fee_item_r').style.display == 'block' && _('fee_item_r').value == '')
        {
            caution_box('Select a fee item to generate report');
        }*/else if (_('date_burs1').value == '' || _('date_burs1').value == '')
        {
            caution_box('Set period of report');
        }else 
        {
            excel_export.date_burs1_ex_burs.value = burs_loc.date_burs1.value;
            excel_export.date_burs1_ex_burs.value = burs_loc.date_burs2.value;
            excel_export.r_name.value = burs_loc.r_name.value;

            prns_form.date_burs1_prns.value = burs_loc.date_burs1.value;
            prns_form.date_burs2_prns.value = burs_loc.date_burs2.value;
            prns_form.r_name.value = burs_loc.r_name.value;
            burs_loc.submit();
        }
    }
</script>

<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />
<noscript>Please, enable JavaScript on your browser</noscript>

<!-- InstanceBeginEditable name="head" --><?php

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
			
			<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
            <div class="innercont_top">Bursary report</div>

            <select name="cdeptId_readup" id="cdeptId_readup" style="display:none"><?php	
                $sql = "SELECT cFacultyId, cdeptId, concat(cdeptId,' ',vdeptDesc) vdeptDesc from depts where cDelFlag = 'N' order by cFacultyId, cdeptId, vdeptDesc";
                $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                while ($rs = mysqli_fetch_array($rssql))
                {?>
                    <option value="<?php echo $rs['cFacultyId']. $rs['cdeptId']?>"><?php echo $rs['vdeptDesc'];?></option><?php
                }
                mysqli_close(link_connect_db());?>
            </select>
            
            <select name="cprogrammeId_readup" id="cprogrammeId_readup" style="display:none"><?php	
                $sql = "SELECT s.cdeptId, p.cProgrammeId,p.vProgrammeDesc,o.vObtQualTitle 
                from programme p, obtainablequal o, depts s, faculty t
                where p.cObtQualId = o.cObtQualId 
                and s.cdeptId = p.cdeptId
                and s.cFacultyId = t.cFacultyId
                and p.cDelFlag = s.cDelFlag
                and p.cDelFlag = t.cDelFlag
                and p.cDelFlag = 'N'
                order by s.cdeptId, p.cProgrammeId";
                $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                while ($rs = mysqli_fetch_array($rssql))
                {?>
                    <option value="<?php echo $rs['cdeptId']. $rs['cProgrammeId']?>"><?php echo $rs['vObtQualTitle'].' '.$rs['vProgrammeDesc']; ?></option><?php
                }
                mysqli_close(link_connect_db());?>
            </select>
                
            <select name="State_readup" id="State_readup" style="display:none"><?php	
                $sql = "SELECT cStateId,cCountryId,vStateName from ng_state order by vStateName";
                $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                while ($rs = mysqli_fetch_array($rssql))
                {?>
                    <option value="<?php echo $rs['cStateId'].$rs['cCountryId'];?>"><?php echo $rs['vStateName']; ?></option><?php
                }
                mysqli_close(link_connect_db());?>
            </select>

            <select name="LGA_readup" id="LGA_readup" style="display:none"><?php	
                $sql = "SELECT cStateId,cLGAId, vLGADesc from localarea order by vLGADesc";
                $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                while ($rs = mysqli_fetch_array($rssql))
                {?>
                    <option value="<?php echo $rs['cStateId'].$rs['cLGAId'];?>"><?php echo ucwords (strtolower ($rs["vLGADesc"]))?></option><?php
                }
                mysqli_close(link_connect_db());?>
            </select>

            <input name="selection" id="selection" type="hidden" />
            <input name="cAcademicDesc" id="cAcademicDesc" type="hidden" value="<?php echo $orgsetins["cAcademicDesc"];?>" />
            
            <div class="innercont_stff" id="enq_ans_div">
                <div id="cover_tab" class="frm_element_tab_cover frm_element_tab_cover_std" style="height:26px;">
                    <a href="#" onclick="tab_modify('1')">
                        <div id="tabss1" class="tabss tabss_std" style="<?php if (!isset($_REQUEST['tabno']) || (isset($_REQUEST['tabno']) && $_REQUEST['tabno'] == ''))
                            {?>
                                border-bottom:1px solid #FFFFFF;<?php 
                            }else
                            {
                                if ($_REQUEST['tabno'] == 1)
                                {?>
                                    border-bottom:1px solid #FFFFFF;<?php 
                                }else
                                {?> 
                                    border-bottom:0px;<?php 
                                }
                            }?>">
                            Back
                        </div>
                    </a>
                    <!--<a href="#" onclick="if(burs_loc.tabno.value==1)
                        {
                            caution_box('Select/enter appropriate options and click on the submit button');return false; tab_modify('2');
                        }">
                        <div id="tabss2" class="tabss tabss_std" style="<?php if (isset($_REQUEST['tabno']) &&$_REQUEST['tabno'] == 2)
                        {?>
                            border-bottom:1px solid #FFFFFF;<?php 
                        }else
                        {?>
                            border-bottom:0px;<?php 
                        }?>">
                            Result
                        </div>
                    </a>-->
                    
                    <div id="selected_options_div"  style="float:right; width:auto; padding:6px;"><?php
                        if (isset($_REQUEST["fee_disc"]) && $_REQUEST["fee_disc"] <> '')
                        {
                            echo $_REQUEST["fee_disc"].'|';
                        }

                        if (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '2')
                        {
                            echo 'Split|';
                        }

                        if (isset($_REQUEST["chk_refund"]))
                        {
                            echo 'Refund|';
                        }

                        if (isset($_REQUEST["trn_side_h"]) && !(isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '2'))
                        {
                            if ($_REQUEST["trn_side_h"] == 'n')
                            {
                                echo 'Confirmed|';
                            }else
                            {
                                echo 'Initiated|';
                            }
                        }

                        if (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '1')
                        {
                            echo 'Pending|';
                        }
                        

                        if (isset($_REQUEST["l_f_resi_h"]))
                        {
                            if ($_REQUEST["l_f_resi_h"] == 'l')
                            {
                                echo 'Local|';
                            }else
                            {
                                echo 'Foreign|';
                            }
                        }

                        if (isset($_REQUEST["level_burs"]) && $_REQUEST["level_burs"] <> '')
                        {
                            echo $_REQUEST["level_burs"].'L|';
                        }
                        
                        if (isset($_REQUEST["cEduCtgId_burs_disc"]) && $_REQUEST["cEduCtgId_burs_disc"] <> '')
                        {
                            echo $_REQUEST["cEduCtgId_burs_disc"].'|';
                        }
                        
                        if (isset($_REQUEST["faculty_burs_disc"]) && $_REQUEST["faculty_burs_disc"] <> '')
                        {
                            echo $_REQUEST["faculty_burs_disc"].'|';
                        }
                        
                        if (isset($_REQUEST["department_burs_disc"]) && $_REQUEST["department_burs_disc"] <> '')
                        {
                            echo $_REQUEST["department_burs_disc"].'|';
                        }
                        
                        if (isset($_REQUEST["date_burs1"]) && $_REQUEST["date_burs1"] <> '')
                        {
                            echo ' From '.$_REQUEST["date_burs1"];
                        }
                        
                        if (isset($_REQUEST["date_burs2"]) && $_REQUEST["date_burs1"] <> '')
                        {
                            echo ' to '.$_REQUEST["date_burs2"].'|';
                        }?>
                    </div>
                </div>
            </div>

            <form method="post" name="burs_loc" id="burs_loc" enctype="multipart/form-data">
		        <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];} ?>" />
		        <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                <input name="tDeedTime" type="hidden" value="" />
		    
                <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php echo $_REQUEST['sm']; ?>" />
                
                <input name="tabno" id="tabno" type="hidden" value="<?php if (isset($_REQUEST["tabno"])){echo $_REQUEST["tabno"];}else{echo '1';} ?>"/>
                <input name="save" id="save" type="hidden" value="<?php if (isset($_REQUEST["save"])){echo $_REQUEST["save"];}; ?>" />
                <input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                
                <input name="mm" id="mm" type="hidden" value="<?php if (isset($_REQUEST["mm"])){echo $_REQUEST["mm"];}; ?>" />
                <input name="sm" id="sm" type="hidden" value="<?php if (isset($_REQUEST["sm"])){echo $_REQUEST["sm"];}; ?>" />
                
                <input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
                <input name="fee_disc" id="fee_disc" type="hidden" value="<?php if (isset($_REQUEST["fee_disc"])){echo $_REQUEST["fee_disc"];} ?>" />
                <input name="cEduCtgId_burs_disc" id="cEduCtgId_burs_disc" type="hidden" value="<?php if (isset($_REQUEST["cEduCtgId_burs_disc"])){echo $_REQUEST["cEduCtgId_burs_disc"];} ?>" />
                <input name="faculty_burs_disc" id="faculty_burs_disc" type="hidden" value="<?php if (isset($_REQUEST["faculty_burs_disc"])){echo $_REQUEST["faculty_burs_disc"];} ?>" />
                <input name="department_burs_disc" id="department_burs_disc" type="hidden" value="<?php if (isset($_REQUEST["department_burs_disc"])){echo $_REQUEST["department_burs_disc"];} ?>" />                
                

                <input name="sort_burs" id="sort_burs" type="hidden" value="<?php if (isset($_REQUEST['sort_burs']) && $_REQUEST['sort_burs'] <> ''){echo $_REQUEST['sort_burs'];} ?>" />
                <input name="r_name" id="r_name" type="hidden" value="<?php echo $sRoleID; ?>" />
                
                <input name="service_mode" id="service_mode" type="hidden" 
                value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}?>" />
                <input name="num_of_mode" id="num_of_mode" type="hidden" 
                value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
                else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

                <input name="user_centre" id="user_centre" type="hidden" 
                value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}?>" />
                <input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
                value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
                else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
    
                <div class="innercont_stff_tabs" id="ans1" style="margin-top:-1px; height:485px; overflow: auto; display:<?php if (isset($_REQUEST['save']) && $_REQUEST['save'] == '1'){echo 'none';}else{echo 'block';}?>"><?php							
                    $RoleName = '';
                    $stmt = $mysqli->prepare("SELECT c.vRoleName 
                    FROM userlogin a, role_user b, role c
                    WHERE a.vApplicationNo = b.vUserId
                    AND b.sRoleID = c.sRoleID
                    AND a.vApplicationNo = ?");
                    $stmt->bind_param("s", $_REQUEST['vApplicationNo']);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($RoleName);
                    $stmt->fetch();
                    $stmt->close();

                    $can_click = 'disabled';
                    $partner_check = '';

                    if ($RoleName == 'Root' || $RoleName == 'Registrar DTP'|| $RoleName == 'Director DTP')
                    {
                        $can_click = '';
                    }?>
                    <input name="can_click" id="can_click" type="hidden" value="<?php  echo $can_click;?>" />
                    
                    <!--<div class="innercont_stff" style="margin-top:5px">
                        <label class="labell" style="width:220px; margin-left:5px;"></label>
                        <div class="div_select">
                            <label for="chk_refund" class="labell" style="width:auto; text-align:left; cursor:pointer;">
                                <input name="chk_refund" id="chk_refund" type="checkbox" 
                                    onclick="if (this.checked)
                                    {
                                        _('fee_item_n').style.display='block';
                                        _('fee_item_r').style.display='none';
                                        _('trn_side1').checked = true;
                                        ('trn_side_h').value = 'n';
                                    }else
                                    {
                                        _('fee_item_n').style.display='none';
                                        _('fee_item_r').style.display='block';
                                        _('trn_side2').checked = true;
                                        ('trn_side_h').value = 'r';
                                    }"
                                    <?php //if (isset($_REQUEST["chk_refund"])){echo 'checked';}?> 
                                    style="margin-top:4px; margin-left:0px; cursor:pointer"  
                                    value="1" />
                                    Refund
                            </label>
                        </div>
                    </div>-->

                    <div class="innercont_stff" style="margin-top:10px">
                        <label class="labell" style="width:220px; margin-left:5px;">Transaction</label>
                        <div class="div_select" style="width:auto;">
                            <label for="trn_side1" class="labell" style="width:auto; text-align:left; cursor:pointer;">
                                <input name="trn_side" id="trn_side1" type="radio" style="margin-top:4px; margin-left:0px; cursor:pointer" title="transaction completed" 
                                    value="n" <?php if (!isset($_REQUEST["trn_side_h"]) || (isset($_REQUEST["trn_side_h"]) && $_REQUEST["trn_side_h"] == 'n')){echo 'checked';} ?>
                                    onclick="_('trn_side_h').value = this.value;
                                    _('trn_stat0').checked=false;
                                    _('trn_stat1').checked=false;
                                    _('trn_stat0').disabled=true;
                                    _('trn_stat1').disabled=true;
                                    
                                    _('trn_stat0').value='';
                                    _('trn_stat1').value='';" />
                                Confirmed
                            </label>
                            <label for="trn_side2" class="labell" style="margin-left:15px; width:auto; text-align:left; cursor:pointer;">
                                <input name="trn_side" id="trn_side2" type="radio" style="margin-top:4px; margin-left:0px; cursor:pointer" 
                                    value="r" <?php if (isset($_REQUEST["trn_side_h"]) && $_REQUEST["trn_side_h"] == 'r'){echo 'checked';} ?>
                                    onclick="_('trn_side_h').value = this.value;
                                    _('trn_stat0').disabled=false;
                                    _('trn_stat1').disabled=false;
                                                                        
                                    _('trn_stat0').checked=true;
                                    _('trn_stat0').value=0;" />
                                Initiated (may or may not be confirmed)
                            </label>
                        </div>
                        <input name="trn_side_h" id="trn_side_h" type="hidden" value="<?php if (!isset($_REQUEST["trn_side_h"])){echo 'n';}else{echo $_REQUEST["trn_side_h"];} ?>"/>
                    </div>

                    <div class="innercont_stff" style="margin-top:10px">
                        <label class="labell" style="width:220px; margin-left:5px;"></label>
                        <div class="div_select" style="width:auto; margin-left:5px;">
                            <label for="trn_stat0" class="labell" style="width:auto; text-align:left; cursor:pointer;">
                                <input name="trn_stat" id="trn_stat0" type="radio" style="margin-top:4px; margin-left:0px; cursor:pointer"  
                                    value="0" <?php if (!isset($_REQUEST["trn_stat"]) || (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '0')){echo 'checked';} ?>
                                    onclick="if(this.checked){this.value=0;}" />
                                Successful 
                            </label>
                            <label for="trn_stat1" class="labell" style="margin-left:15px; width:auto; text-align:left; cursor:pointer;">
                                <input name="trn_stat" id="trn_stat1" type="radio" style="margin-top:4px; margin-left:0px; cursor:pointer" 
                                    value="0" <?php if (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '1'){echo 'checked';} ?>
                                    onclick="if(this.checked){this.value=1;}" />
                                Pending
                            </label>
                            <label for="trn_stat2" class="labell" style="margin-left:15px; width:auto; text-align:left; cursor:pointer;">
                                <input name="trn_stat" id="trn_stat2" type="radio" style="margin-top:4px; margin-left:0px; cursor:pointer" 
                                    value="0" <?php if (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '2'){echo 'checked';} ?>
                                    onclick="if(this.checked){this.value=2;_('fee_item').value=71}" />
                                Split
                            </label>
                        </div>
                    </div>

                    <div class="innercont_stff" style="margin-top:10px"><?php
                        $sql = "SELECT fee_item_id, fee_item_desc FROM fee_items WHERE fee_item_id IN ('3','71','31','61') AND cdel = 'N' ORDER BY fee_item_desc";
                        $rs_sql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));?>
                        <label for="fee_item" class="labell" style="width:220px; margin-left:5px;">Fee items</label>
                        <div class="div_select">
                            <select name="fee_item" id="fee_item" class="select"
                                onChange="_('fee_item_prns').value=this.value;
                                _('fee_item').value=this.value;
                                _('fee_item_ex_burs').value=this.value;
                                burs_loc.fee_disc.value=this.options[this.selectedIndex].text;
                                prns_form.fee_prns_disc.value=burs_loc.fee_disc.value;
                                _('fee_disc_ex_burs').value=burs_loc.fee_disc.value;">
                                <option value="" selected></option><?php
                                $c = 0;
                                while ($rs = mysqli_fetch_array($rs_sql))
                                {
                                    $c++;
                                    if ($c%5==0)
                                    {?>
                                        <option disabled></option><?php
                                    }?>
                                    <option value="<?php echo $rs['fee_item_id'];?>" <?php if(isset($_REQUEST["fee_item"]) && $_REQUEST["fee_item"] == $rs['fee_item_id']){echo 'selected';}?>>
                                        <?php echo $rs['fee_item_desc'];?>
                                    </option><?php
                                }
                                mysqli_close(link_connect_db());?>
                            </select>
                        </div>  
                        <div id="labell_msg6" class="labell_msg blink_text orange_msg"></div>
                    </div>

                    <div class="innercont_stff" style="margin-top:10px">
                        <label class="labell" style="width:220px; margin-left:5px;">Residency</label>
                        <div class="div_select">
                            <label for="l_f_resi1" class="labell" style="width:auto; text-align:left; cursor:pointer;">
                                <input name="l_f_resi" id="l_f_resi1" type="radio" style="margin-top:4px; margin-left:0px; cursor:pointer"  
                                    value="l" <?php if (!isset($_REQUEST["l_f_resi_h"]) || (isset($_REQUEST["l_f_resi_h"]) && $_REQUEST["l_f_resi_h"] == 'l')){echo 'checked';} ?>
                                    onclick="_('l_f_resi_h').value = this.value;" />
                                Local
                            </label>
                            <label for="l_f_resi2" class="labell" style="margin-left:15px; width:auto; text-align:left; cursor:pointer;">
                                <input name="l_f_resi" id="l_f_resi2" type="radio" style="margin-top:4px; margin-left:0px; cursor:pointer" 
                                    value="f" <?php if (isset($_REQUEST["l_f_resi"]) && $_REQUEST["l_f_resi"] == 'f'){echo 'checked';} ?>
                                    onclick="_('l_f_resi_h').value = this.value;" />
                                Foreign
                            </label>
                        </div>
                        <input name="l_f_resi_h" id="l_f_resi_h" type="hidden" value="<?php if (!isset($_REQUEST["l_f_resi_h"])){echo 'l';}else{echo $_REQUEST["l_f_resi_h"];} ?>"/>
                    </div>

                    <div class="innercont_stff" style="margin-top:10px"><?php
                        $sql = "SELECT DISTINCT cEduCtgId, vEduCtgDesc 
                        FROM educationctg
                        WHERE cEduCtgId IN ('ELX','ELZ','PSZ','PGX','PGY','PGX','PGZ','PRX')
                        ORDER BY vEduCtgDesc";

                        $rssqlEduCtgId = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));?>

                        <label for="cEduCtgId_burs" class="labell" style="width:220px; margin-left:5px;">Programme category</label>
                        <div class="div_select">
                        <select name="cEduCtgId_burs" id="cEduCtgId_burs" class="select" 
                            onchange="_('cEduCtgId_burs_prns').value=this.value; 
                            _('cEduCtgId_ex_burs').value=this.value;
                            burs_loc.cEduCtgId_burs_disc.value=this.options[this.selectedIndex].text;
                            burs_loc.cEduCtgId_burs_prns_disc.value=this.options[this.selectedIndex].text;"><option value="" selected></option><?php
                            $cnt = 0;
                            while ($r_rssqlEduCtgId = mysqli_fetch_assoc($rssqlEduCtgId))
                            {
                                if ($cnt%5 == 0)
                                {?>
                                    <option disabled></option><?php
                                }?>
                                <option value="<?php echo $r_rssqlEduCtgId['cEduCtgId']?>" <?php if(isset($_REQUEST["cEduCtgId_burs"]) && $_REQUEST["cEduCtgId_burs"] == $r_rssqlEduCtgId['cEduCtgId']){echo 'selected';}?>><?php echo ucwords(strtolower($r_rssqlEduCtgId['vEduCtgDesc'])); ?></option><?php
                                $cnt++;
                            }
                            mysqli_close(link_connect_db());?>
                        </select>
                        </div>
                        <div id="labell_msg7" class="labell_msg blink_text orange_msg"></div>
                    </div>

                    <div class="innercont_stff" style="margin-top:10px">
                        <label for="level_burs" class="labell" style="width:220px; margin-left:5px;">Level</label>
                        <div class="div_select">
                        <select name="level_burs" id="level_burs" class="select" style="width:auto" 
                        onChange="_('level_burs_prns').value=this.value;
                            _('level_ex_burs').value=this.value;">
                            <option value="" selected="selected"></option>
                            <option value="10" <?php if (isset($_REQUEST['BeginLevel']) && $_REQUEST['BeginLevel'] == 10){echo ' selected';} ?>>10</option>
                            <option value="20" <?php if (isset($_REQUEST['BeginLevel']) && $_REQUEST['BeginLevel'] == 20){echo ' selected';} ?>>20</option>
                            <option value="30" <?php if (isset($_REQUEST['BeginLevel']) && $_REQUEST['BeginLevel'] == 30){echo ' selected';} ?>>30</option>
                            <option value="40" <?php if (isset($_REQUEST['BeginLevel']) && $_REQUEST['BeginLevel'] == 40){echo ' selected';} ?>>40</option><?php
                            for ($t = 100; $t <= 800; $t+=100)
                            {?>
                                <option value="<?php echo $t ?>" <?php if(isset($_REQUEST["level_burs"]) && $_REQUEST["level_burs"] == $t){echo 'selected';}?>><?php echo $t;?></option><?php
                            }?>
                        </select>
                        </div>
                        <div id="labell_msg5" class="labell_msg blink_text orange_msg"></div>
                    </div>
                    
                    <div class="innercont_stff" style="padding-top:10px">
                        <label for="faculty_burs" class="labell" style="width:220px; margin-left:5px;">Faculty</label>
                        <div class="div_select"><?php
                            $sqlschool = "SELECT cFacultyId, vFacultyDesc AS school FROM faculty WHERE cCat = 'A' ORDER BY cFacultyId";
                            $rsschool = mysqli_query(link_connect_db(), stripslashes($sqlschool)) or die(mysqli_error(link_connect_db()));?>
                            <select id="faculty_burs" name="faculty_burs" class="select" 
                                onchange="_('faculty_burs_prns').value=this.value; 
                                _('faculty_ex_burs').value=this.value;
                                burs_loc.faculty_burs_disc.value=this.options[this.selectedIndex].text;
                                prns_form.faculty_burs_prns_disc.value=this.options[this.selectedIndex].text;
                                update_cat_country('faculty_burs', 'cdeptId_readup', 'department_burs', 'department_burs');
                                _('department_burs').value='';
                                _('department_ex_burs').value='';">
                                <option value="">Select faculty </option><?php
                                while ($rowschool = mysqli_fetch_array($rsschool))
                                {?>
                                    <option value="<?php echo $rowschool['cFacultyId'];?>" <?php if(isset($_REQUEST["faculty_burs"]) && $_REQUEST["faculty_burs"] == $rowschool['cFacultyId']){echo 'selected';}?>><?php echo $rowschool['school'] ?></option><?php
                                }
                                mysqli_close(link_connect_db());?>
                            </select>
                        </div>
                        <div id="labell_msg8" class="labell_msg blink_text orange_msg"></div>
                    </div>
                    
                    <div class="innercont_stff" style="margin-top:10px">
                        <label for="department_burs" class="labell" style="width:220px; margin-left:5px;">Department</label><?php
                        if(isset($_REQUEST["faculty_burs"]) && $_REQUEST["faculty_burs"])
                        {
                            $sql1 = "select cdeptId, concat(cdeptId,' ',vdeptDesc) vdeptDesc 
							from depts where cFacultyId = '".$_REQUEST["faculty_burs"]."' order by vdeptDesc";
                            $rsdept = mysqli_query(link_connect_db(), $sql1) or die(mysqli_error(link_connect_db()));
                        }?>
                        <div class="div_select">
                            <select id="department_burs" name="department_burs" class="select" 
                                onchange="_('department_burs_prns').value=this.value;  
                                _('department_ex_burs').value=this.value;
                                burs_loc.department_burs_disc.value=this.options[this.selectedIndex].text;
                                burs_loc.department_burs_prns_disc.value=this.options[this.selectedIndex].text;">
                                <option value="">Select department </option><?php
                                if(isset($_REQUEST["faculty_burs"]) && $_REQUEST["faculty_burs"])
                                {
                                    while ($table= mysqli_fetch_array($rsdept))
                                    {?>
                                        <option value="<?php echo $table[0] ?>"
                                            <?php if (isset($_REQUEST['department_burs']) && $table["cdeptId"] == $_REQUEST['department_burs']){echo ' selected';}?>>
                                            <?php echo $table['vdeptDesc'];?>
                                        </option><?php
                                    }
                                    mysqli_close(link_connect_db());
                                }?>
                            </select>
                        </div>
                        <div id="labell_msg9" class="labell_msg blink_text orange_msg"></div>
                    </div>
                    
                    <div class="innercont_stff" style="margin-top:10px;">
                        <label class="labell" style="width:220px; margin-left:5px;">Period of report</label>
                        <div class="div_select" style="width:200px;">
                            <label for="date_burs1" class="labell" style="width:auto;">From</label>
                            <input type="date" name="date_burs1" id="date_burs1" class="textbox" style="height:99%; width:auto" value="<?php if (isset($_REQUEST['date_burs1']) && $_REQUEST["date_burs1"] <> ''){echo $_REQUEST['date_burs1'];};?>"
                            onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
                        </div>
                        
                        <div class="div_select" style="width:200px;">
                            <label for="date_burs2" class="labell" style="width:auto;">To</label>
                            <input type="date" name="date_burs2" id="date_burs2" class="textbox" style="height:99%; width:auto" value="<?php if (isset($_REQUEST['date_burs2']) && $_REQUEST["date_burs2"] <> ''){echo $_REQUEST['date_burs2'];};?>"
                            onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
                        </div>
                        <div id="labell_msg11" class="labell_msg blink_text orange_msg" style="width:130px;"></div>
                    </div>
                </div><?php
                require_once("opr_b_rpt.php");?>
            </form>
    
            <form action="show-report" method="post" name="prns_form" target="_blank" id="prns_form" enctype="multipart/form-data">
                <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
                
                <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php echo $_REQUEST['sm']; ?>" />
                <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                
                <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                <input name="mm" type="hidden" value="<?php echo $_REQUEST['mm']; ?>" />
                <input name="sm" type="hidden" value="<?php echo $_REQUEST['sm']; ?>" />
                                
                <input name="fee_cat_prns" id="fee_cat_prns" type="hidden" value="<?php if (isset($_REQUEST["fee_cat_prns"])){echo $_REQUEST["fee_cat_prns"];} ?>" />
                
                <input name="fee_item_prns" id="fee_item_prns" type="hidden" value="<?php if (isset($_REQUEST["fee_item_prns"])){echo $_REQUEST["fee_item_prns"];} ?>" />
                
                <input name="cEduCtgId_burs_prns" id="cEduCtgId_burs_prns" type="hidden" value="<?php if (isset($_REQUEST["cEduCtgId_burs_prns"])){echo $_REQUEST["cEduCtgId_burs_prns"];} ?>" />

                <input name="faculty_burs_prns" id="faculty_burs_prns" type="hidden" value="<?php if (isset($_REQUEST["faculty_burs_prns"])){echo $_REQUEST["faculty_burs_prns"];} ?>" />
                <input name="department_burs_prns" id="department_burs_prns" type="hidden" value="<?php if (isset($_REQUEST["department_burs_prns"])){echo $_REQUEST["department_burs_prns"];} ?>" />

                <input name="fee_prns_disc" id="fee_prns_disc" type="hidden" 
                    value="<?php if (isset($_REQUEST["fee_prns_disc"])){echo $_REQUEST["fee_prns_disc"];}else if (isset($_REQUEST["fee_disc"])){echo $_REQUEST["fee_disc"];} ?>"/>
                
                <input name="cEduCtgId_burs_prns_disc" id="cEduCtgId_burs_prns_disc" type="hidden" 
                    value="<?php if (isset($_REQUEST["cEduCtgId_burs_prns_disc"])){echo $_REQUEST["cEduCtgId_burs_prns_disc"];}else if (isset($_REQUEST["cEduCtgId_burs_disc"])){echo $_REQUEST["cEduCtgId_burs_disc"];} ?>"/>

                <input name="level_burs_prns" id="level_burs_prns" type="hidden" 
                    value="<?php if (isset($_REQUEST["level_burs_prns"])){echo $_REQUEST["level_burs_prns"];}else if (isset($_REQUEST["level_burs"])){echo $_REQUEST["level_burs"];} ?>" />

                <input name="faculty_burs_prns_disc" id="faculty_burs_prns_disc" type="hidden" 
                    value="<?php if (isset($_REQUEST["faculty_burs_prns_disc"])){echo $_REQUEST["faculty_burs_prns_disc"];}else if (isset($_REQUEST["faculty_burs_disc"])){echo $_REQUEST["faculty_burs_disc"];} ?>" />

                <input name="department_burs_prns_disc" id="department_burs_prns_disc" type="hidden" 
                    value="<?php if (isset($_REQUEST["department_burs_prns_disc"])){echo $_REQUEST["department_burs_prns_disc"];}else if (isset($_REQUEST["department_burs_disc"])){echo $_REQUEST["department_burs_disc"];} ?>" />
                
                <input name="date_burs1_prns" id="date_burs1_prns" type="hidden" 
                    value="<?php if (isset($_REQUEST["date_burs1_prns"])&&$_REQUEST["date_burs1_prns"]<>''){echo $_REQUEST["date_burs1_prns"];}else if (isset($_REQUEST["date_burs1"])){echo $_REQUEST["date_burs1"];} ?>" />

                <input name="date_burs2_prns" id="date_burs2_prns" type="hidden" 
                    value="<?php if (isset($_REQUEST["date_burs2_prns"])&&$_REQUEST["date_burs2_prns"]<>''){echo $_REQUEST["date_burs2_prns"];}else if (isset($_REQUEST["date_burs2"])){echo $_REQUEST["date_burs2"];} ?>" />

                <input name="sq_statement" id="sq_statement" type="hidden" value="<?php if (isset($_REQUEST["sq_statement"])&& $_REQUEST["sq_statement"] <> ''){echo $_REQUEST["sq_statement"];}else{echo str_pad($sql.'^'.$binders.'~'.$binded_none_arr, 2000);} ?>" />

                <input name="sort_burs_prns" id="sort_burs_prns" type="hidden" value="<?php if (isset($_REQUEST['sort_burs_prns']) && $_REQUEST['sort_burs_prns'] <> ''){echo $_REQUEST['sort_burs_prns'];}else if (isset($_REQUEST["sort_burs"])){echo $_REQUEST["sort_burs"];} ?>" />
                <input name="selected_opt" id="selected_opt" type="hidden" />
                
                <input name="service_mode" id="service_mode" type="hidden" 
                value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}?>" />
                <input name="num_of_mode" id="num_of_mode" type="hidden" 
                value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
                else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

                <input name="user_centre" id="user_centre" type="hidden" 
                value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}?>" />
                <input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
                value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
                else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
                
                <input name="r_name" id="r_name" type="hidden" value="<?php echo $sRoleID; ?>" />
            </form>
            
            <form action="show-excel-report" method="post" name="excel_export" id="excel_export" enctype="multipart/form-data">
                <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
                
                <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php echo $_REQUEST['sm']; ?>" />
                <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                
                <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];} ?>" />
                <input name="mm" type="hidden" value="<?php echo $_REQUEST['mm']; ?>" />
                <input name="sm" type="hidden" value="<?php echo $_REQUEST['sm']; ?>" />
                
                <input name="expected_actual_ex_burs" id="expected_actual_ex_burs" type="hidden" value="<?php if (isset($_REQUEST["expected_actual_ex_burs"])){echo $_REQUEST["expected_actual_ex_burs"];} ?>" />
                <input name="r_name" id="r_name" type="hidden" value="<?php echo $sRoleID; ?>" />
                
                <input name="fee_cat_ex_burs" id="fee_cat_ex_burs" type="hidden" value="<?php if (isset($_REQUEST["fee_cat_ex_burs"])){echo $_REQUEST["fee_cat_ex_burs"];} ?>" />
                <input name="level_ex_burs" id="level_ex_burs" type="hidden" value="<?php if (isset($_REQUEST["level_ex_burs"])){echo $_REQUEST["level_ex_burs"];} ?>"  />
                <input name="fee_item_ex_burs" id="fee_item_ex_burs" type="hidden" value="<?php if (isset($_REQUEST["fee_item_ex_burs"])){echo $_REQUEST["fee_item_ex_burs"];} ?>" />
                
                <input name="cEduCtgId_ex_burs" id="cEduCtgId_ex_burs" type="hidden" value="<?php if (isset($_REQUEST["cEduCtgId_ex_burs"])){echo $_REQUEST["cEduCtgId_ex_burs"];} ?>"  />
                <input name="faculty_ex_burs" id="faculty_ex_burs" type="hidden" value="<?php if (isset($_REQUEST["faculty_ex_burs"])){echo $_REQUEST["faculty_ex_burs"];} ?>"  />
                <input name="department_ex_burs" id="department_ex_burs" type="hidden" value="<?php if (isset($_REQUEST["department_ex_burs"])){echo $_REQUEST["department_ex_burs"];} ?>" />
                
                <input name="date_burs1_ex_burs" id="date_burs1_ex_burs" type="hidden" value="<?php if (isset($_REQUEST["date_burs1_ex_burs"])){echo $_REQUEST["date_burs1_ex_burs"];} ?>" />
                <input name="date_burs2_ex_burs" id="date_burs2_ex_burs" type="hidden" value="<?php if (isset($_REQUEST["date_burs2_ex_burs"])){echo $_REQUEST["date_burs2_ex_burs"];} ?>"  />
                
                <input name="sq_statement" id="sq_statement" type="hidden" value="<?php if (isset($_REQUEST["sq_statement"]) && $_REQUEST["sq_statement"] <> ''){echo $_REQUEST["sq_statement"];}else{echo str_pad($sql.'^'.$binders.'~'.$binded_none_arr, 2000);} ?>"/>

                <input name="fee_disc_ex_burs" id="fee_disc_ex_burs" type="hidden" value="<?php if (isset($_REQUEST["fee_disc_ex_burs"])){echo $_REQUEST["fee_disc_ex_burs"];} ?>" />
                <!-- <input name="staff_study_center_ex_burs" id="staff_study_center_ex_burs" type="hidden" value="<?php //echo $staff_study_center_u;?>" /> -->

                <input name="sort_ex_burs" id="sort_ex_burs" type="hidden" value="<?php if (isset($_REQUEST["sort_ex_burs"]) && $_REQUEST["sort_ex_burs"] <> ''){echo $_REQUEST["sort_ex_burs"];} ?>" />		

                <input name="service_mode" id="service_mode" type="hidden" 
                value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}?>" />
                <input name="num_of_mode" id="num_of_mode" type="hidden" 
                value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
                else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

                <input name="user_centre" id="user_centre" type="hidden" 
                value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}?>" />
                <input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
                value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
                else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
            </form>

		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;"><?php
			$img = '';
			if (isset($_REQUEST['vMatricNo']) && $_REQUEST['vMatricNo'] <> '')
			{
				$stmt_last = $mysqli->prepare("select a.vApplicationNo from pics a, afnmatric b where a.vApplicationNo = b.vApplicationNo and b.vMatricNo = ? and cinfo_type = 'p'");
				$stmt_last->bind_param("s", $_REQUEST["vMatricNo"]);
			}else if (isset($_REQUEST['uvApplicationNo']) && $_REQUEST['uvApplicationNo'] <> '')
			{
				$stmt_last = $mysqli->prepare("select a.vApplicationNo from pics a, afnmatric b where a.vApplicationNo = b.vApplicationNo and b.vMatricNo = ? and cinfo_type = 'p'");
				$stmt_last->bind_param("s", $_REQUEST["uvApplicationNo"]);
			}
			
			$a = '';
			if (isset($stmt_last))
			{	
				$stmt_last->execute();
				$stmt_last->store_result();
				if ($stmt_last->num_rows > 0)
				{
					$stmt_last->bind_result($a);
					$stmt_last->fetch();
				}
				$stmt_last->close();
			}?>
			<div id="pp_box">
                 <img name="passprt" id="passprt" src="<?php echo get_pp_pix($a); ?>" width="95%" height="185" style="margin:0px;<?php if ($currency <> '1' ){?>opacity:0.3;<?php }?>"/>
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