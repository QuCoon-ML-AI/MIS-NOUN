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


<link rel="stylesheet" type="text/css" href="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
<!-- <link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico"> -->
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
         
         $('#gridz2').dataTable({
        	"reponsive": "true",
           	"pagingType": "full_numbers"
         });
         
         $('#gridz3').dataTable({
        	"reponsive": "true",
           	"pagingType": "full_numbers"
         });
         
         $('#gridz4').dataTable({
        	"reponsive": "true",
           	"pagingType": "full_numbers"
         });
         
         $('#gridz5').dataTable({
        	"reponsive": "true",
           	"pagingType": "full_numbers"
         });
         
         $('#gridz6').dataTable({
        	"reponsive": "true",
           	"pagingType": "full_numbers"
         });
		
		// $('#gridz').dataTable({
		// 		deferRender: true,
        //         fixedHeader: {
        //         header: true,
        //         footer: true,
        //     },
			

            
        //     columns: [
        //         { data: 'sn'},
        //         { data: 'date'},
        //         { data: 'describe'},
        //         { data: 'debit'},
        //         { data: 'credit'},
        //         { data: 'balance'},
        //     ],
        //     dom: 'Bfrtip',
			
        //     buttons: 
        //     [
        //         {
        //             extend: 'excelHtml5',
        //             title: 'Statement of account',
        //             exportOptions: { columns: [ 0, 1, 2, 3, 4, 5 ] },
        //         },
        //         {
        //             extend: 'pdfHtml5',
        //             title: 'Statement of account',
        //             exportOptions: { columns: [ 0, 1, 2, 3, 4, 5 ] },
        //             messageTop: 'Students Records',
        //             messageBottom: 'Powered by NOUMIS',
        //             title: 'National Open University of Nigeria:',
        //             margin: [ 2, 2, 2, 2],
        //             pageSize: 'A4',
        //             orientation: 'portrate',
        //         },
        //         'print'
        //     ]
        // } );
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
	function tab_modify(tab_no)
    {
        // if (tab_no != 1 && tab_no != 5)
        // {
        //     _("tabss6").style.display = 'block'; 
        //     _('acad_rec').tabno.value = tab_no;
        // }else
        // {
        //     _("tabss6").style.display = 'none';
        // }
        
        tablinks = document.getElementsByClassName("innercont_stff_tabs");
        for (i = 0; i < tablinks.length; i++) 
        {
            var tab_Id = 'tabss' + (i+1);
            var cover_maincontent_id = 'ans' + (i+1);
            
            if (tab_no == (i+1))
            {
                _(tab_Id).style.borderBottom = '1px solid #FFFFFF';
                _(cover_maincontent_id).style.visibility = 'visible';
                _(cover_maincontent_id).style.display = 'block';
            }else if (_(tab_Id))
            {
                _(tab_Id).style.border = '1px solid #BCC6CF';
                _(cover_maincontent_id).style.visibility = 'hidden';
                _(cover_maincontent_id).style.display = 'none';
            }
        }
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
			
            <div class="innercont_top" style="float:left">Student clearance</div>
            
            <form action="student-clearance" method="post" target="_self" name="clearance_loc" id="clearance_loc" enctype="multipart/form-data">
                <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];}; ?>" />
                <input name="user_cat" id="user_cat" type="hidden" value="<?php echo $_REQUEST['user_cat']; ?>" />	
                <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                <input name="sm" id="sm" type="hidden" value="<?php echo $sm ?>" />
                <input name="mm" id="mm" type="hidden" value="<?php echo $mm ?>" />
                <input name="save" id="save" type="hidden" value="-1" />
                <input name="save_cf" id="save_cf" type="hidden" value="-1" />
                <input name="tabno" id="tabno" type="hidden" value="1"/>
                <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />						
                
                <input name="iStudy_level" id="iStudy_level" type="hidden" value="<?php if (isset($iStudy_level)){echo $iStudy_level;} ?>" />
                <input name="cAcademicDesc" id="cAcademicDesc" type="hidden" value="<?php if (isset($orgsetins['cAcademicDesc'])){echo $orgsetins['cAcademicDesc'];} ?>" />
                <input name="tSemester" id="tSemester" type="hidden" value="<?php if (isset($tSemester)){echo $tSemester;} ?>" />
                <input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />
                
                <input name="service_mode" id="service_mode" type="hidden" 
                value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
                else if (isset($study_mode)){echo $study_mode;}?>" />
                <input name="num_of_mode" id="num_of_mode" type="hidden" 
                value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
                else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

                <input name="user_centre" id="user_centre" type="hidden" 
                value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}?>" />
                <input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
                value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
                else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />

                <div id="appl_box" class="innercont_stff">
                    <label for="vApplicationNo" class="labell">Matriculation number</label>
                    <div class="div_select">
                        <input name="uvApplicationNo" id="uvApplicationNo" type="text" class="textbox" value="<?php if (isset($_REQUEST['uvApplicationNo'])){echo $_REQUEST['uvApplicationNo'];} ?>" />
                    </div>
                    <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
                </div>
            </form><?php

            
            if (isset($_REQUEST['save_cf']) && $_REQUEST['save_cf'] == '1')
            {
                $stmt = $mysqli->prepare("SELECT a.vApplicationNo, vTitle, a.vLastName, a.vFirstName, a.vOtherName, a.cFacultyId, b.vFacultyDesc, a.cdeptId, c.vdeptDesc,a.cProgrammeId, d.vObtQualTitle, e.vProgrammeDesc, a.tSemester, a.iStudy_level, session_reg, semester_reg, a.vEMailId, a.vMobileNo, e.cEduCtgId, e.iEndLevel, g.iBeginLevel, a.cAcademicDesc, a.cAcademicDesc_1, a.cStudyCenterId, f.vCityName, a.grad, a.cResidenceCountryId, e.max_crload, h.vEduCtgDesc
                from s_m_t a, faculty b, depts c, obtainablequal d, programme e, prog_choice g , studycenter f, educationctg h
                where a.cFacultyId = b.cFacultyId
                AND a.cdeptId = c.cdeptId
                AND a.cObtQualId = d.cObtQualId
                AND a.cProgrammeId = e.cProgrammeId 
                AND g.vApplicationNo = a.vApplicationNo
                AND a.cStudyCenterId = f.cStudyCenterId
                AND e.cEduCtgId = h.cEduCtgId
                AND a.vMatricNo = ?");
                $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($vApplicationNo_loc, $vTitle_loc, $vLastName_loc, $vFirstName_loc, $vOtherName_loc, $cFacultyId_loc, $vFacultyDesc_loc, $cdeptId_loc, $vdeptDesc_loc, $cProgrammeId_loc, $vObtQualTitle_loc, $vProgrammeDesc_loc, $tSemester_loc, $iStudy_level_loc, $session_reg_loc, $semester_reg_loc, $vEMailId_loc, $vMobileNo_loc, $cEduCtgId_loc, $iEndLevel_loc, $iBeginLevel_loc, $cAcademicDesc, $cAcademicDesc_1, $cStudyCenterId_loc, $vCityName_loc, $grad, $cResidenceCountryId_loc, $max_crload_loc, $vEduCtgDesc_loc);
                $stmt->fetch();
                $stmt->close();
                
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
                $table = explode(",", $tables);?>

                <div id="cover_tab" class="frm_element_tab_cover frm_element_tab_cover_std" style="margin-top:10px; margin-bottom:10px;">
                    <!-- <a id="tabss6" href="#" onclick="tab_modify('6')" style="display:none">
                        <input type="button" value="Print" class="basic_three_stff_bck_btns" 
                            style="float:right; width:80px; margin-top:-1px; padding:10px; margin-right:-1px;"/>
                    </a>     -->
                    
                    <a href="#" onclick="tab_modify('1')">
                        <div id="tabss1" class="tabss tabss_std" style="width:190px; border-bottom:1px solid #FFFFFF;">
                            Credits
                        </div>
                    </a>
                    <a href="#" onclick="tab_modify('2')">
                        <div id="tabss2" class="tabss tabss_std" style="width:190px;">
                            Compulsory payments
                        </div>
                    </a>
                    <a href="#" onclick="tab_modify('3')">
                        <div id="tabss3" class="tabss tabss_std" style="width:190px;">
                            Semester payments
                        </div>
                    </a>
                    <a href="#" onclick="tab_modify('4')">
                        <div id="tabss4" class="tabss tabss_std" style="width:190px;">
                            Course payments
                        </div>
                    </a>
                    <a href="#" onclick="tab_modify('5')">
                        <div id="tabss5" class="tabss tabss_std" style="width:190px;">
                            Exam payments
                        </div>
                    </a>
                    <a href="#" onclick="tab_modify('6')">
                        <div id="tabss6" class="tabss tabss_std" style="width:190px;">
                            Other payments
                        </div>
                    </a>
                </div>
                
                <div class="innercont_stff_tabs" id="ans1" style="height:80%; display:block">
                    <table id="gridz1" class="table table-condensed table-responsive" style="width:100%;">
						<thead>
							<tr>
								<th style="text-align:right; width:8%; padding-right:2%">Sn</th>
								<th style="width:15%;">Date</th>
								<th style="width:30%;">Fee item-Item-Semester (-RRR)</th>
								<th style="text-align:right; width:13%; padding-right:2%">Debit</th>
								<th style="text-align:right; width:13%; padding-right:2%">Credit</th>
								<th style="text-align:right; width:13%; padding-right:2%">Balance</th>
							</tr>
						</thead>
                        <tbody><?php
                            $stmt = $mysqli->prepare("SELECT tdate, cCourseId, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester) vDesc, a.Amount Amount_a, vremark, a.RetrievalReferenceNumber, b.fee_item_desc, a.tSemester
                            FROM s_tranxion_cr a, fee_items b
                            WHERE a.fee_item_id = b.fee_item_id
                            AND b.cdel = 'N'
                            AND vMatricNo = ?
                            ORDER BY tdate, b.fee_item_desc;");

                            $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($tdate_1, $cCourseId_1, $vDesc_1, $Amount_a_1, $vremark, $RetrievalReferenceNumber, $fee_item_desc, $tSemester_1);

                            $cnt = 0;
                            $balance = 0;
                            
                            $arr_cnt = 0;

                            while($stmt->fetch())
                            {                                
                                if ($cnt%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
                                <tr style="background-color:<?php echo $background_color;?>;">
                                    <td style="text-align:right; width:8%; padding-right:2%"><?php echo ++$cnt;?></td>
                                    <td style="widtd:15%;"><?php echo $tdate_1; ?></td>
                                    <td style="width:30%;"><?php                                                 
                                        echo ucfirst(strtolower($vremark)).'-'.$cCourseId_1.'-'.$tSemester_1;
                                        if ($RetrievalReferenceNumber <> '0000'){echo '-'.$RetrievalReferenceNumber;}
                                        if (!is_bool(strpos($vDesc_1, "internal")))
                                        {
                                            echo '-'.$vDesc_1.'-';
                                        }?>
                                    </td>
                                    <td style="text-align:right; width:13%; padding-right:2%">--</td>
                                    <td style="text-align:right; width:13%; padding-right:2%"><?php 
                                        echo number_format($Amount_a_1);$balance += $Amount_a_1;?>
                                    </td>
                                    <td style="text-align:right; width:13%; padding-right:2%"><?php echo number_format($balance);?></td>
                                </tr><?php 
                            }?>                       
  					    </tbody>
                        <tfoot>
                            <tr style="background-color:<?php echo $background_color;?>;">
                                <td colspan="5" style="text-align:right; padding-right:2%">Total</td>
                                <td style="text-align:right; padding-right:2%"><?php echo number_format($balance);?></td>
                            </tr>
                        </tfoot>
					</table>
                </div>                

                <div class="innercont_stff_tabs" id="ans2" style="height:80%;">
                    <table id="gridz2" class="table table-condensed table-responsive" style="width:100%;">
						<thead>
							<tr>
								<th style="text-align:right; width:8%; padding-right:2%">Sn</th>
								<th style="width:15%;">Date</th>
								<th style="width:30%;">Fee item-Item-Semester (-RRR)</th>
								<th style="text-align:right; width:13%; padding-right:2%">Debit</th>
								<th style="text-align:right; width:13%; padding-right:2%">Credit</th>
								<th style="text-align:right; width:13%; padding-right:2%">Balance</th>
							</tr>
						</thead>
                        <tbody><?php
                            $cnt = 0;
                            //$balance = 0;

							foreach ($table as &$value)
							{
								$wrking_tab = 's_tranxion_'.$value;								
						
								$stmt = $mysqli->prepare("SELECT cCourseId, tdate, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester,'-',fee_item_desc) vDesc,  tSemester, a.Amount Amount_a, vremark, a.RetrievalReferenceNumber, b.fee_item_desc 
								FROM $wrking_tab a, fee_items b
								WHERE a.fee_item_id = b.fee_item_id
                                AND b.fee_item_id IN ('1','4','13','17','19','21','28')
								AND b.cdel = 'N'
								AND vMatricNo = ?
								ORDER BY tdate, b.fee_item_desc;");
								
								$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
								$stmt->execute();
								$stmt->store_result();
								$stmt->bind_result($cCourseId_1, $tdate_1, $vDesc_1, $tSemester_1, $Amount_a_1, $vremark, $RetrievalReferenceNumber, $fee_item_desc);
								//$stmt->bind_result($tdate_1, $cCourseId_1, $vDesc_1, $Amount_a_1, $vremark, $RetrievalReferenceNumber, $fee_item_desc, $tSemester_1);
								if ($stmt->num_rows === 0)
								{
									//caution_box('There are no transactions to display');
								}else
								{
									while($stmt->fetch())
									{
                                        if ($cnt%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
										<tr style="background-color:<?php echo $background_color;?>;">
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
							}?>                       
  					    </tbody>
                        <tfoot>
                            <tr style="background-color:<?php echo $background_color;?>;">
                                <td colspan="5" style="text-align:right; padding-right:2%">Total</td>
                                <td style="text-align:right; padding-right:2%"><?php echo number_format($balance);?></td>
                            </tr>
                        </tfoot>
					</table>
                </div>                

                <div class="innercont_stff_tabs" id="ans3" style="height:80%;">
                    <table id="gridz3" class="table table-condensed table-responsive" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="text-align:right; width:8%; padding-right:2%">Sn</th>
                                <th style="width:15%;">Date</th>
                                <th style="width:30%;">Fee item-Item-Semester (-RRR)</th>
                                <th style="text-align:right; width:13%; padding-right:2%">Debit</th>
                                <th style="text-align:right; width:13%; padding-right:2%">Credit</th>
                                <th style="text-align:right; width:13%; padding-right:2%">Balance</th>
                            </tr>
                        </thead>
                        <tbody><?php
                            $cnt = 0;
                            //$balance = 0;
                            $prev_date = '';
                            $tSemester_count = 0;

                            foreach ($table as &$value)
                            {
                                $wrking_tab = 's_tranxion_'.$value;								
                        
                                $stmt = $mysqli->prepare("SELECT cCourseId, tdate, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester,'-',fee_item_desc) vDesc,  tSemester, a.Amount Amount_a, vremark, a.RetrievalReferenceNumber, b.fee_item_desc 
                                FROM $wrking_tab a, fee_items b
                                WHERE a.fee_item_id = b.fee_item_id
                                AND b.fee_item_id IN ('72','29','12','16','20')
                                AND b.cdel = 'N'
                                AND vMatricNo = ?
                                ORDER BY tdate, b.fee_item_desc;");
                                
                                $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($cCourseId_1, $tdate_1, $vDesc_1, $tSemester_1, $Amount_a_1, $vremark, $RetrievalReferenceNumber, $fee_item_desc);
                                
                                while($stmt->fetch())
                                {
                                    if ($cnt%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
                                    <tr style="background-color:<?php echo $background_color.';'; if ($prev_date == '' || $prev_date <> $tdate_1){echo 'font-weight:bold';}?>;">
                                        <td style="text-align:right; width:8%; padding-right:2%"><?php echo ++$cnt;?></td>
                                        <td style="widtd:15%;"><?php echo $tdate_1;if ($prev_date == '' || $prev_date <> $tdate_1){$tSemester_count++; echo ' Semester '.$tSemester_count;} ?></td>
                                        <td style="width:30%;"><?php 		
                                        
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
                                    $prev_date = $tdate_1;
                                }

                            }?>                       
                        </tbody>
                        <tfoot>
                            <tr style="background-color:<?php echo $background_color;?>;">
                                <td colspan="5" style="text-align:right; padding-right:2%">Total</td>
                                <td style="text-align:right; padding-right:2%"><?php echo number_format($balance);?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="innercont_stff_tabs" id="ans4" style="height:80%;">
                    <table id="gridz4" class="table table-condensed table-responsive" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="text-align:right; width:8%; padding-right:2%">Sn</th>
                                <th style="width:15%;">Date</th>
                                <th style="width:30%;">Fee item-Item-Semester (-RRR)</th>
                                <th style="text-align:right; width:13%; padding-right:2%">Debit</th>
                                <th style="text-align:right; width:13%; padding-right:2%">Credit</th>
                                <th style="text-align:right; width:13%; padding-right:2%">Balance</th>
                            </tr>
                        </thead>
                        <tbody><?php
                            $arr_crs_reg_trn = array(array());

                            $arr_cnt = 0;
                            foreach ($table as &$value)
                            {
                                $wrking_tab = 's_tranxion_'.$value;

                                $stmt_dr = $mysqli->prepare("SELECT Amount, cCourseId 
                                FROM $wrking_tab 
                                WHERE fee_item_id = 56
                                AND vMatricNo = ?");
                                
                                $stmt_dr->bind_param("s", $_REQUEST["uvApplicationNo"]);
                                $stmt_dr->execute();
                                $stmt_dr->store_result();

                                $stmt_dr->bind_result($Amount_crs_reg_trn, $cCourseId_crs_reg_trn);
                                while($stmt_dr->fetch())
                                {
                                    $arr_cnt++;
                                    $arr_crs_reg_trn[$arr_cnt]['cCourseId'] = $cCourseId_crs_reg_trn;
                                    $arr_crs_reg_trn[$arr_cnt]['amount'] = $Amount_crs_reg_trn;

                                    //echo $arr_cnt.','.$arr_crs_reg_trn[$arr_cnt]['cCourseId'].', '.$arr_crs_reg_trn[$arr_cnt]['amount'].'<br>';
                                }                                        
                            }

                            $cnt = 0;
                            //$balance = 0;
                            $prev_cAcademicDesc = '';
                            $tSemester_count = 0;

                            $table_0 = search_starting_pt_crs($_REQUEST['uvApplicationNo']);
                            foreach ($table_0 as &$value)
                            {
                                $wrking_tab = 'coursereg_arch_'.$value;						
                        
                               $stmt = $mysqli->prepare("SELECT d.cCourseId, d.vCourseDesc, d.siLevel, d.tSemester, d.tdate, d.iCreditUnit, d.cAcademicDesc, d.cCategory
                                FROM $wrking_tab d
                                WHERE d.vMatricNo = ? 
                                ORDER BY d.cAcademicDesc, d.tSemester, d.cCourseId");
                                $stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
                                $stmt->execute();
                                $stmt->store_result();

                                $stmt->bind_result($cCourseId, $vCourseDesc, $siLevel, $tSemester_01, $tdate, $iCreditUnit, $cAcademicDesc_01, $cCategory);

                                while($stmt->fetch())
                                {
                                    if ($cnt%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
                                    <tr style="background-color:<?php echo $background_color.';';if ($prev_cAcademicDesc == '' || $prev_cAcademicDesc <> $cAcademicDesc_01){echo 'font-weight:bold';}?>;">
                                        <td style="text-align:right; width:8%; padding-right:2%"><?php echo ++$cnt;?></td>
                                        <td style="widtd:15%;"><?php echo $tdate; if ($prev_cAcademicDesc == '' || $prev_cAcademicDesc <> $cAcademicDesc_01){echo ' '.$cAcademicDesc_01;}?></td>
                                        <td style="width:30%;"><?php 
                                            echo $cCourseId.'-'.$vCourseDesc.'-'.$iCreditUnit.'-'.$cCategory;?>
                                        </td>
                                        <td style="text-align:right; width:13%; padding-right:2%"><?php 
                                            $return_times = 0;
                                            for ($b = 1; $b <= count($arr_crs_reg_trn)-1; $b++)
                                            {
                                                if ($arr_crs_reg_trn[$b]['cCourseId'] == $cCourseId)
                                                {
                                                    $return_times++;
                                                    echo '-'.number_format($arr_crs_reg_trn[$b]['amount']);$balance -= $arr_crs_reg_trn[$b]['amount'];
                                                    break;
                                                }
                                            }

                                            if ($return_times == 0)
                                            {
                                                echo 0;
                                            }
                                            // if ($crs_num > $return_times)
                                            // {
                                            //     echo '-'.number_format($Amount);$balance += $Amount;
                                            // }
                                            
                                            //echo '-'.number_format($Amount_a_1);$balance += $Amount_a_1;?>
                                        </td>
                                        <td style="text-align:right; width:13%; padding-right:2%">--
                                        </td>
                                        <td style="text-align:right; width:13%; padding-right:2%"><?php echo number_format($balance);?></td>
                                    </tr><?php
                                    $prev_cAcademicDesc = $cAcademicDesc_01;
                                }
                            }?>                       
                        </tbody>
                        <tfoot>
                            <tr style="background-color:<?php echo $background_color;?>;">
                                <td colspan="5" style="text-align:right; padding-right:2%">Total</td>
                                <td style="text-align:right; padding-right:2%"><?php echo number_format($balance);?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>                

                <div class="innercont_stff_tabs" id="ans5" style="height:80%;">
                    <table id="gridz5" class="table table-condensed table-responsive" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="text-align:right; width:8%; padding-right:2%">Sn</th>
                                <th style="width:15%;">Date</th>
                                <th style="width:30%;">Fee item-Item-Semester (-RRR)</th>
                                <th style="text-align:right; width:13%; padding-right:2%">Debit</th>
                                <th style="text-align:right; width:13%; padding-right:2%">Credit</th>
                                <th style="text-align:right; width:13%; padding-right:2%">Balance</th>
                            </tr>
                        </thead>
                        <tbody><?php
                            $arr_crs_reg_trn = array(array(array()));

                            $arr_cnt = 0;
                            foreach ($table as &$value)
                            {
                                $wrking_tab = 's_tranxion_'.$value;

                                $stmt_dr = $mysqli->prepare("SELECT Amount, cCourseId, tdate 
                                FROM $wrking_tab 
                                WHERE fee_item_id = 8
                                AND vMatricNo = ?");
                                
                                $stmt_dr->bind_param("s", $_REQUEST["uvApplicationNo"]);
                                $stmt_dr->execute();
                                $stmt_dr->store_result();

                                $stmt_dr->bind_result($Amount_crs_reg_trn, $cCourseId_crs_reg_trn, $tdate_crs_reg_trn);
                                while($stmt_dr->fetch())
                                {
                                    $arr_cnt++;
                                    $arr_crs_reg_trn[$arr_cnt]['cCourseId'] = $cCourseId_crs_reg_trn;
                                    $arr_crs_reg_trn[$arr_cnt]['amount'] = $Amount_crs_reg_trn;
                                    $arr_crs_reg_trn[$arr_cnt]['date'] = $tdate_crs_reg_trn;

                                    //echo $arr_crs_reg_trn[$arr_cnt]['date'].','.$arr_crs_reg_trn[$arr_cnt]['cCourseId'].', '.$arr_crs_reg_trn[$arr_cnt]['amount'].'<br>';
                                }                                        
                            }

                            $cnt = 0;
                            //$balance = 0;
                            $prev_cAcademicDesc = '';
                            $tSemester_count = 0;

                            $table_0 = search_starting_pt_crs($_REQUEST['uvApplicationNo']);
                            foreach ($table_0 as &$value)
                            {
                                $wrking_tab = 'examreg_'.$value;
                        
                                $stmt = $mysqli->prepare("SELECT d.cCourseId, d.siLevel, d.tSemester, d.tdate, d.cAcademicDesc
                                FROM $wrking_tab d
                                WHERE d.vMatricNo = ? 
                                ORDER BY d.cAcademicDesc, d.cCourseId");
                                $stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
                                $stmt->execute();
                                $stmt->store_result();

                                $stmt->bind_result($cCourseId, $siLevel, $tSemester_01, $tdate, $cAcademicDesc_01);

                                while($stmt->fetch())
                                {
                                    if ($cnt%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
                                    <tr style="background-color:<?php echo $background_color.';';if ($prev_cAcademicDesc == '' || $prev_cAcademicDesc <> $cAcademicDesc_01){echo 'font-weight:bold';}?>;">
                                        <td style="text-align:right; width:8%; padding-right:2%"><?php echo ++$cnt;?></td>
                                        <td style="widtd:15%;"><?php echo $tdate; if ($prev_cAcademicDesc == '' || $prev_cAcademicDesc <> $cAcademicDesc_01){echo ' '.$cAcademicDesc_01;}?></td>
                                        <td style="width:30%;"><?php
                                            $stmt_courses = $mysqli->prepare("SELECT vCourseDesc, iCreditUnit FROM courses_new WHERE cCourseId  = '$cCourseId'");
                                            $stmt_courses->execute();
                                            $stmt_courses->store_result();            
                                            $stmt_courses->bind_result($vCourseDesc_courses, $iCreditUnit_courses);
                                            $stmt_courses->fetch();

                                            echo $cCourseId.'-'.$vCourseDesc_courses.'-'.$iCreditUnit_courses;?>
                                        </td>
                                        <td style="text-align:right; width:13%; padding-right:2%"><?php 
                                            $return_times = 0;
                                            for ($b = 1; $b <= count($arr_crs_reg_trn)-1; $b++)
                                            {
                                                if ($arr_crs_reg_trn[$b]['cCourseId'] == $cCourseId)
                                                {
                                                    $return_times++;
                                                    echo '-'.number_format($arr_crs_reg_trn[$b]['amount']);$balance -= $arr_crs_reg_trn[$b]['amount'];
                                                    break;
                                                }
                                            }

                                            if ($return_times == 0)
                                            {
                                                echo 0;
                                            }
                                            // if ($crs_num > $return_times)
                                            // {
                                            //     echo '-'.number_format($Amount);$balance += $Amount;
                                            // }
                                            
                                            //echo '-'.number_format($Amount_a_1);$balance += $Amount_a_1;?>
                                        </td>
                                        <td style="text-align:right; width:13%; padding-right:2%">--
                                        </td>
                                        <td style="text-align:right; width:13%; padding-right:2%"><?php echo number_format($balance);?></td>
                                    </tr><?php
                                    $prev_cAcademicDesc = $cAcademicDesc_01;
                                }
                            }?>                       
                        </tbody>
                        <tfoot>
                            <tr style="background-color:<?php echo $background_color;?>;">
                                <td colspan="5" style="text-align:right; padding-right:2%">Total</td>
                                <td style="text-align:right; padding-right:2%"><?php echo number_format($balance);?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>              
                

                <div class="innercont_stff_tabs" id="ans6" style="height:80%;">
                    <table id="gridz6" class="table table-condensed table-responsive" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="text-align:right; width:8%; padding-right:2%">Sn</th>
                                <th style="width:15%;">Date</th>
                                <th style="width:30%;">Fee item-Item-Semester (-RRR)</th>
                                <th style="text-align:right; width:13%; padding-right:2%">Debit</th>
                                <th style="text-align:right; width:13%; padding-right:2%">Credit</th>
                                <th style="text-align:right; width:13%; padding-right:2%">Balance</th>
                            </tr>
                        </thead>
                        <tbody><?php
                            $cnt = 0;
                            //$balance = 0;
                            foreach ($table as &$value)
                            {
                                $wrking_tab = 's_tranxion_'.$value;

                                $stmt_dr = $mysqli->prepare("SELECT Amount, fee_item_desc, tdate 
                                FROM $wrking_tab a, fee_items b 
                                WHERE a.fee_item_id = b.fee_item_id
                                AND a.fee_item_id Not IN ('8','56','1','4','13','17','19','21','28','72','29','12','16','20')
                                AND vMatricNo = ?");
                                $stmt_dr->bind_param("s", $_REQUEST["uvApplicationNo"]);
                                $stmt_dr->execute();
                                $stmt_dr->store_result();

                                $stmt_dr->bind_result($Amount_crs_reg_trn, $cCourseId_crs_reg_trn, $tdate);
                                while($stmt_dr->fetch())
                                {
                                    if ($cnt%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
                                    <tr style="background-color:<?php echo $background_color.';';?>;">
                                        <td style="text-align:right; width:8%; padding-right:2%"><?php echo ++$cnt;?></td>
                                        <td style="widtd:15%;"><?php echo $tdate;?></td>
                                        <td style="width:30%;"><?php
                                            echo $cCourseId_crs_reg_trn;?>
                                        </td>
                                        <td style="text-align:right; width:13%; padding-right:2%"><?php
                                            echo number_format($Amount_crs_reg_trn);
                                            $balance -= $Amount_crs_reg_trn;?>
                                        </td>
                                        <td style="text-align:right; width:13%; padding-right:2%">--
                                        </td>
                                        <td style="text-align:right; width:13%; padding-right:2%"><?php echo number_format($balance);?></td>
                                    </tr><?php
                                }                                        
                            }?>                       
                        </tbody>
                        <tfoot>
                            <tr style="background-color:<?php echo $background_color;?>;">
                                <td colspan="5" style="text-align:right; padding-right:2%">Total</td>
                                <td style="text-align:right; padding-right:2%"><?php echo number_format($balance);?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div><?php
            }?>
            <!-- </form> -->
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
                    <a href="#" style="text-decoration:none;" onclick="_('nxt').action = 'staff_home_page';_('nxt').mm.value='';_('nxt').submit();return false">
                        <div class="basic_three" style="height:auto; width:inherit; padding:8.5px; float:none; margin:0px;">Home</div>
                    </a>
                </div>
                
				<?php side_detail($_REQUEST["uvApplicationNo"]);?>
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