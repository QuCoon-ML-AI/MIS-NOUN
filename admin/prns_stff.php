<?php
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php

$currency = 1;

$study_mode_01 = 'odl';
$orgsetins = settns();
$cStudyCenterId = '';

if (isset($_REQUEST['user_centre']) && $_REQUEST['user_centre'] <> '')
{
	$cStudyCenterId = $_REQUEST['user_centre'];
}

$sql_sub1 = ''; $sql_sub2 = ''; $sql_sub3 = '';
if ($orgsetins['studycenter'] == '1')
{
	$sql_sub1 = ', studycenter f'; $sql_sub2 = 'and a.cStudyCenterId = f.cStudyCenterId'; $sql_sub3 = ', f.vCityName';
}


if (isset($_REQUEST['vMatricNo']) && $_REQUEST['vMatricNo'] <> '')
{
    $stmt = $mysqli->prepare("select vTitle, vLastName, concat(vFirstName,' ',vOtherName) othernames, b.vFacultyDesc, c.vdeptDesc,a.cProgrammeId, d.vObtQualTitle, e.vProgrammeDesc, a.iStudy_level, a.vMobileNo, a.vEMailId, a.tSemester $sql_sub3
    from s_m_t a, faculty b, depts c, obtainablequal d, programme e $sql_sub1
    where a.cFacultyId = b.cFacultyId
    and a.cdeptId = c.cdeptId
    and a.cObtQualId = d.cObtQualId
    and a.cProgrammeId = e.cProgrammeId 
    $sql_sub2 
    and a.vMatricNo = ?");
	$stmt->bind_param("s", $_REQUEST['vMatricNo']);
	$stmt->execute();
	$stmt->store_result();

	if ($orgsetins['studycenter'] == '1')
	{
		$stmt->bind_result($vTitle, $vLastName, $othernames, $vFacultyDesc, $vdeptDesc, $cProgrammeId, $vObtQualTitle, $vProgrammeDesc, $iStudy_level, $vMobileNo, $vEMailId, $tSemester_std, $vCityName);
	}else
	{
		$stmt->bind_result($vTitle, $vLastName, $othernames, $vFacultyDesc, $vdeptDesc, $cProgrammeId, $vObtQualTitle, $vProgrammeDesc, $iStudy_level, $vMobileNo, $vEMailId, $tSemester_std);
	}
	
    $stmt->fetch();
	$stmt->close();

	$tSemester = $tSemester_std;
	
	$balance = wallet_bal();
	
	$stmt->close();
	
	
}?>

<script language="JavaScript" type="text/javascript" src="button_ops.js"></script>
<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />
<title>NOUN-MIS</title>
<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
<script language="JavaScript" type="text/javascript">
	function call_image()
	{
		var formdata = new FormData();
		
		_("loadcred").value = 1;
		
		formdata.append("loadcred",_("loadcred").value);
		formdata.append("currency", _("currency_cf").value);
		formdata.append("user_cat", _("user_cat").value);
		
		formdata.append("vApplicationNo", _("vApplicationNo_img").value);
		
		formdata.append("vExamNo", _("vExamNo").value);
		formdata.append("cQualCodeId", _("cQualCodeId").value);
		
		opr_prep_img(ajax = new XMLHttpRequest(),formdata);
	}



	function opr_prep_img(ajax,formdata)
	{
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		
		ajax.open("POST", "opr_s5.php");
		ajax.send(formdata);
	}

	function completeHandler(event)
	{
		if (_("loadcred").value == 1)
		{
			_("container_cover_in").style.zIndex = 1;
			_("container_cover_in").style.display = 'block';
			_("credential_img").src = event.target.responseText;
			_("imgClose").focus();
			_("loadcred").value = 0;
		}
	}
	
	
	function progressHandler(event)
	{
	}
	
	
	function errorHandler(event)
	{
	}
	
	function abortHandler(event)
	{
	}
</script>

<style type="text/css">

	ol { list-style: decimal; margin-left: 2em;}
	.checklist li { background: none; padding: 0px; }
	.checklist {
		border: 0px solid #ccc;
		margin-left:-1px;
		list-style: none;
		overflow:hidden;
		margin-bottom:5px;		
	}
	
	li { margin: 0px;  padding: 0px; margin-top:-1; width:99.5%; height:20px; float:left}
	.checklist label { display: block; padding-left:0px;}
	.checklist li:hover { background: #777; color: #fff; cursor:default;}
	
	.cl1 { font-size: 1.0em; width:auto; height:auto;}
	.cl1 .alt { background:#EEF7EE; }
</style>
</head>

<body onload="window.print(); checkConnection()">
	<div id="container_cover_constat" style="display:none"></div>
	<div id="container_cover_in_constat" class="center" style="display:none; position:fixed;">
		<div id="div_header_main" class="innercont_stff" 
			style="float:left;
			width:100%;
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
	<div id="container_cover_in" 
		style="background:#FFFFFF;
		left:5px;
		top:5px;
		height:97%;
		width:500px; 
		float:left;
		box-shadow: 4px 4px 3px #888888;
		display:none; 
		position:absolute;
		text-align:center; 
		padding:5px;
		border: 1px solid #696969;
		opacity: 0.9;
		font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px">
			<div id="inner_submityes_header0" style="width:494px;
				height:15px;
				padding:3px; 
				float:left; 
				text-align:right;">
					<a id="imgClose" href="#"
						onclick="_('container_cover_in').style.display = 'none';
						_('container_cover_in').style.zIndex = -1;return false" 
						style="color:#666666; margin-right:3px; text-decoration:none;text-shadow: 0 1px 0 #fafafa;">X</a>
			</div>
			
			<div id="inner_submityes_g1" 
				style="width:inherit; 
				height:96%;
				border-radius:3px; 
				text-align:center; 
				float:left;
				top:15px; 
				z-index:-1;
				position:absolute;
				display:block;">
				<img id="credential_img" style="width:100%; height:100%"/>
			</div>
	</div>


	<div id="container" style="margin-top:3px; height:auto; border-top:1px solid #CCCCCC; border-left:1px solid #CCCCCC; width:850px; text-align:center; padding:4px;">
		<?php do_toup_div_prns('Student Management System');

		if (isset($_REQUEST['sm']) && isset($_REQUEST['mm']) && $_REQUEST['mm'] == 2)
		{
			if ($_REQUEST['sm'] == 6)
			{			
				$arr_faculty = array(array(array(array(array(array())))));

				$stmt = $mysqli->prepare("select a.cFacultyId, a.vFacultyDesc, b.cdeptId, b.vdeptDesc, c.cProgrammeId, c.vProgrammeDesc
				from faculty a, depts b, programme c
				where a.cFacultyId = b.cFacultyId
				and b.cdeptId = c.cdeptId
				order by a.cFacultyId, b.cdeptId, c.cProgrammeId");
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($cFacultyId, $vFacultyDesc, $cdeptId, $vdeptDesc, $cProgrammeId, $vProgrammeDesc);

				$cnt = -1;
				while($stmt->fetch())
				{
					$cnt++;
					$arr_faculty[$cnt]['cFacultyId'] = $cFacultyId;
					$arr_faculty[$cnt]['vFacultyDesc'] = $vFacultyDesc;

					$arr_faculty[$cnt]['cdeptId'] = $cdeptId;
					$arr_faculty[$cnt]['vdeptDesc'] = $vdeptDesc;

					$arr_faculty[$cnt]['cProgrammeId'] = $cProgrammeId;
					$arr_faculty[$cnt]['vProgrammeDesc'] = $vProgrammeDesc;
				}
				$stmt->close();

				$study_mode = '';
				if (isset($_REQUEST['service_mode'])){$study_mode = $_REQUEST['service_mode'];}?>
			
				<div class="innercont" style="margin-top:7px; height:auto; margin-left:4px; border-radius:0px;width:840px;"><?php					
					$faculty_sub_sql = "";
					if (isset($_REQUEST['cEduCtgId_loc0']) && $_REQUEST['cEduCtgId_loc0'] <> '')
					{
						$faculty_sub_sql = " AND a.cEduCtgId = '".$_REQUEST['cEduCtgId_loc0']."'";
					}
					
					if (isset($_REQUEST['show_all_burs']) && $_REQUEST['show_all_burs'] == '0')
					{
						$faculty_sub_sql .= " AND d.fee_item_desc <> 'Application Fee' AND d.fee_item_desc <> 'Late Fee'";
					}
		
					if (isset($_REQUEST['cFacultyId_loc_0']) && $_REQUEST['cFacultyId_loc_0'] <> '')
					{
						$faculty_sub_sql .= " AND cFacultyId = '".$_REQUEST['cFacultyId_loc_0']."'";
					}
		
					if (isset($_REQUEST['new_old_structure_burs']) && $_REQUEST['new_old_structure_burs'] <> '')
					{
						$faculty_sub_sql .= " AND new_old_structure = '".$_REQUEST['new_old_structure_burs']."'";
					}
					
					//$study_mode = '';

					$stmt = $mysqli->prepare("SELECT a.iItemID, a.citem_cat, a.cEduCtgId, b.vEduCtgDesc, a.iSemester, c.citem_cat_desc, d.fee_item_desc, d.fee_item_id, a.iCreditUnit, a.Amount, a.cFacultyId, a.cdeptid, a.cprogrammeId, a.ilevel
					FROM s_f_s a, educationctg b, sell_item_cat c, fee_items d
					WHERE a.cEduCtgId = b.cEduCtgId 
					AND a.citem_cat = c.citem_cat
					AND a.fee_item_id = d.fee_item_id
					AND a.cdel = 'N'
					AND d.cdel = 'N'
					AND a.Amount > 0
					$faculty_sub_sql
					ORDER BY a.citem_cat, d.fee_item_desc");
					$stmt->execute();
					$stmt->store_result();
					
					$stmt->bind_result($iItemID_01, $citem_cat_01, $cEduCtgId_01, $vEduCtgDesc_01, $iSemester_01, $citem_cat_desc_01, $vDesc_01, $fee_item_id_01, $iCreditUnit_01, $Amount_01, $cFacultyId_01, $cdeptid_01, $cprogrammeId_01, $ilevel_01);
				
					$prev_citem_cat = ''; $cnt = 0;?>
					
					<div class="innercont" style="margin-top:-1px; margin-left:-1px; padding-top:5px;  padding-bottom:5px; border-radius:0px; width:840px; height:auto; border: 1px solid #FFFFFF; line-height:2; font-weight:bold;"><?php 
						if (isset($_REQUEST['new_old_structure_burs']))
						{
							if ($_REQUEST["cEduCtgId_loc0"] == 'PSZ')
							{
							    if ($_REQUEST['new_old_structure_burs'] == 'o')
    							{
    								echo 'Old ';
    							}else if ($_REQUEST['new_old_structure_burs'] == 'n')
    							{
    								echo 'New ';
    							}else
    							{
    								echo 'Foreign ';
    							}
							}
						}?>Fee Structure<br>
						<?php echo 'Faculty: '. $_REQUEST['cFacultyId_desc_loc_0'].'<br>';
						if (isset($_REQUEST["cEduCtgId_loc0"]))
						{
							if ($_REQUEST["cEduCtgId_loc0"] == 'PSZ')
							{
								echo 'Udergraduate Programme';
							}else if ($_REQUEST["cEduCtgId_loc0"] == 'PGX')
							{
								echo 'Posgraduate Programme';
							}else if ($_REQUEST["cEduCtgId_loc0"] == 'PGY')
							{
								echo 'Masters Programme';
							}else if ($_REQUEST["cEduCtgId_loc0"] == 'PGZ' || $_REQUEST["cEduCtgId_loc0"] == 'PRX')
							{
								echo 'Doctoral  Programme';
							}
						}?>
					</div>
					<div class="innercont_stff" style="margin-bottom:3px; width:100%;">
						<div class="ctabletd_1" style="width:4%; height:auto; padding:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Sno</div>
						<!-- <div class="ctabletd_1" style="width:7%; height:auto; padding:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">ItemID</div> -->
						<div class="ctabletd_1" style="width:6%; height:auto; padding:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Depart.</div>
						<div class="ctabletd_1" style="width:16%; height:auto; padding:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Programme</div>
						<div class="ctabletd_1" style="width:5.2%; height:auto; padding:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:centre;">Level</div>
						<!--<div class="ctabletd_1" style="width:6%; height:auto; padding:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center;">Semester</div>-->
						<div class="ctabletd_1" style="width:53.45%; height:auto; padding:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Description</div>
						<div class="ctabletd_1" style="width:8.2%; height:auto; padding:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Amount(N)</div>
					</div>
					<ul id="li1" class="checklist cl1"><?php
						$balance = 0;
						$stmt->data_seek(0);
						$balance = 0; $cnt = 0;
                    
                        $prev_citem_cat = '';
                        $citem_cat_total = 0;  
                        $faculty_diff = '';
                        $prev_citem_cat_diff = '';
                        $cEduCtgId_transi = '';
                        $background_color='';

						while($stmt->fetch())
						{
							if ($prev_citem_cat == '' || ($prev_citem_cat <> $citem_cat_01))
							{
								if ($citem_cat_total > 0)
								{?>
									<li style="height:auto; font-weight:bold; padding:0px; width:100%; border:0px;">
										<div class="ctabletd_1" style="width:89.6%; height:auto; padding:4px; border:1px solid #A7BAAD; text-align:right;">
											Total
										</div>
										<div class="ctabletd_1" style="width:8.1%; height:auto; padding:4px; border:1px solid #A7BAAD; text-align:right; margin-left:-1px;">
											<?php if (substr($prev_citem_cat,1,1) == '1' || substr($prev_citem_cat,1,1) == '4' || substr($prev_citem_cat,1,1) == '5'){
												echo number_format($citem_cat_total); 
											}else{
												echo 'NA';
											}
											$citem_cat_total = 0;?>
										</div>
									</li><?php
								}

								$pay_type = '';?>
								<li style="text-align:left; height:auto; padding:4px; width:100%; font-weight:bold; border:0px;">
									<?php echo  $citem_cat_desc_01;?>
								</li><?php
							}?>
							<li style="height:auto; padding:0px; width:100%; border:0px;">
								<div class="ctabletd_1" style="width:4%; height:auto; padding:4px; border:1px solid #A7BAAD; text-align:right;">
									<?php echo ++$cnt; ?>
								</div>
								<!-- <div class="ctabletd_1" style="width:7.2%; height:auto; padding:4px; border:1px solid #A7BAAD; text-align:right; margin-left:-1px;">
									<?php echo str_pad($iItemID_01, 3, "0", STR_PAD_LEFT).' '.$citem_cat_01; ?>
								</div> -->
								<div class="ctabletd_1" style="width:6.2%; height:auto; padding:4px; border:1px solid #A7BAAD; text-align:right; margin-left:-1px;">
									<?php if ($cdeptid_01 == '0'){echo 'N/A.';}else{echo $cdeptid_01;}?>
								</div>
								<div class="ctabletd_1" style="width: 16.2%; height:auto; padding:4px; border:1px solid #A7BAAD; text-align:right; margin-left:-1px;">
									<?php if ($cprogrammeId_01 == '0'){echo 'N/A.';}else{echo $cprogrammeId_01;}?>
								</div>
								<div class="ctabletd_1" style="width:5.4%; height:auto; padding:4px; border:1px solid #A7BAAD; text-align:right; margin-left:-1px;">
									<?php if ($ilevel_01 == 0){echo 'All';}else{echo $ilevel_01;}?>
								</div>
								<!--<div class="ctabletd_1" style="width:6.2%; height:auto; padding:4px; border:1px solid #A7BAAD; text-align:right; margin-left:-1px;">
									<?php if ($iSemester_01 == 0){echo 'All';}else{echo $iSemester_01;}?>
								</div>-->
								<div class="ctabletd_1" style="width:53.55%; height:auto; padding:4px; border:1px solid #A7BAAD; text-align:left; margin-left:-1px;">
									<?php echo $vDesc_01; if ($citem_cat_01 == 'C2' && $fee_item_id_01 <> 8){echo ' '.$iCreditUnit_01;}?>
								</div>
								<div class="ctabletd_1" style="width:8.1%; height:auto; padding:4px; border:1px solid #A7BAAD; text-align:right; margin-left:-1px;">
									<?php if ($prev_citem_cat <> 'C2'){
										$balance += $Amount_01;
									}
									$citem_cat_total += $Amount_01;
									echo number_format($Amount_01);?>
								</div>
							</li><?php 
							
                            $prev_citem_cat = $citem_cat_01;
                            $faculty_diff = $cFacultyId_01;
                            $cEduCtgId_transi = $cEduCtgId_01;
						}
						$stmt->close();?>
						<li style="height:auto; font-weight:bold; padding:0px; width:100%; border:0px;">
							<div class="ctabletd_1" style="width:89.7%; height:auto; padding:4px; border:1px solid #A7BAAD; text-align:right;">
								Sub total
							</div>
							<div class="ctabletd_1" style="width:8%; height:auto; padding:4px; border:1px solid #A7BAAD; margin:0px; text-align:right; margin-left:-1px;">
								<?php echo number_format($citem_cat_total);?>
							</div>
						</li>
									
						<!--<li style="height:auto; font-weight:bold; padding:0px; width:100%; border:0px;">
							<div class="ctabletd_1" style="width:89.6%; height:auto; padding:4px; border:1px solid #A7BAAD; text-align:right;">
								Total
							</div>
							<div class="ctabletd_1" style="width:7.8%; height:auto; padding:4px; border:1px solid #A7BAAD; text-align:right;">
								<?php echo number_format($balance);?>
							</div>
						</li>-->
					</ul>
				</div><?php
			}else if ($_REQUEST['sm'] == 11)
			{	
				$selected_opt = '';?>
				
				<div class="innercont" style="margin-top:-1px; margin-left:4px; padding-top:5px; padding-bottom:5px; border-radius:0px; width:840px; height:auto; border:0px solid #ccc; line-height:2; font-weight:bold;">
					Transaction List<br>
					
					<?php if (isset($_REQUEST["fee_prns_disc"]) && $_REQUEST["fee_prns_disc"] <> '')
                    {
                        echo $_REQUEST["fee_prns_disc"];
                    }

                    if (isset($_REQUEST["level_burs_prns"]) && $_REQUEST["level_burs_prns"] <> '')
                    {
                        echo '<br>'.$_REQUEST["level_burs_prns"].'L';
                    }
                    
                    if (isset($_REQUEST["cEduCtgId_burs_prns_disc"]) && $_REQUEST["cEduCtgId_burs_prns_disc"] <> '')
                    {
                        echo '|'.$_REQUEST["cEduCtgId_burs_prns_disc"];
                    }
                    
                    if (isset($_REQUEST["faculty_burs_prns_disc"]) && $_REQUEST["faculty_burs_prns_disc"] <> '')
                    {
                        echo '<br>'.$_REQUEST["faculty_burs_prns_disc"];
                    }
                    
                    if (isset($_REQUEST["department_burs_prns_disc"]) && $_REQUEST["department_burs_prns_disc"] <> '')
                    {
                        echo '|'.$_REQUEST["department_burs_prns_disc"];
                    }
                    
                    if (isset($_REQUEST["date_burs1_prns"]) && $_REQUEST["date_burs1_prns"] <> '')
                    {
                        echo '<br>From '.$_REQUEST["date_burs1_prns"];
                    }
                    
                    if (isset($_REQUEST["date_burs2_prns"]) && $_REQUEST["date_burs2_prns"] <> '')
                    {
                        echo ' to '.$_REQUEST["date_burs2_prns"].' ';
                    }
					
					$soretd_by = '';
					if(strlen($_REQUEST["sort_burs_prns"]) > 0)
					{
						for($t = 0; $t <= strlen($_REQUEST["sort_burs_prns"])-1; $t++)
						{
							if(substr($_REQUEST["sort_burs_prns"], $t, 1) == 'a' && $_REQUEST['fee_disc'] <> '')
							{
								$soretd_by .= 'Name, ';
							}else if(substr($_REQUEST["sort_burs_prns"], $t, 1) == 'b')
							{
								$soretd_by .= 'Reference no., ';
							}else if(substr($_REQUEST["sort_burs_prns"], $t, 1) == 'c')
							{
								$soretd_by .= 'Date, ';
							}else if(substr($_REQUEST["sort_burs_prns"], $t, 1) == 'd' && $_REQUEST['fee_disc'] == '')
							{
								$soretd_by .= 'Description, ';
							}else if(substr($_REQUEST["sort_burs_prns"], $t, 1) == 'e')
							{
								$soretd_by .= 'Amount, ';
							}
						}
					}
					
					if ($soretd_by <> '')
					{
						echo "<br> Sorted by ".substr($soretd_by, 0, strlen($soretd_by)-2);
					}?>
				</div>
				<div class="innercont" style="margin-top:-1px; margin-left:4px; padding-bottom:5px; border-radius:0px; width:840px; height:auto; border:0px solid #ccc; line-height:2; font-weight:bold;">
					<?php date_default_timezone_set('Africa/Lagos');
					echo '<br>'.date("d-m-Y"); //date("l jS \of F Y h:i:s A");?>
				</div>
				
				<div class="innercont_stff" style="margin-bottom:1px; margin-left:3px; width:99.6%;">
					<div class="ctabletd_1" style="width:5%; height:auto; padding:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Sno</div>

					<div class="ctabletd_1" style="width:30%; height:auto; padding:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; margin-left:-1px; text-align:left;">Name</div>

					<div class="ctabletd_1" style="width:17%; height:auto; padding:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; margin-left:-1px; text-align:left;">AFN/Mat. No.</div>

					<div class="ctabletd_1" style="width:14%; height:auto; padding:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; margin-left:-1px; text-align:left;">Ref. No.</div>
					
					<div class="ctabletd_1" style="width:12%; height:auto; padding:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; margin-left:-1px; text-align:left;">Date</div>

					<div class="ctabletd_1" style="width:15%; height:auto; padding:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; margin-left:-1px; text-align:right;">Amount(N)</div>
				</div><?php
				

				$binded = array();
            
				$sql = substr($_REQUEST['sq_statement'],0,strpos($_REQUEST['sq_statement'],"^"));

				$binder_start = strpos($_REQUEST['sq_statement'],"^")+1;
				$binder_end = strpos($_REQUEST['sq_statement'],"~")-$binder_start;
				$binders = substr($_REQUEST['sq_statement'], $binder_start, $binder_end);

				$to_bind = substr($_REQUEST['sq_statement'], strpos($_REQUEST['sq_statement'],"~")+1);

				$binded = explode("|", $to_bind);

				$stmt = $mysqli->prepare($sql);
	
				if (count($binded) > 0)
				{
					if (count($binded) == 1)
					{
						$stmt->bind_param($binders, $binded[0]);
					}else if (count($binded) == 2)
					{
						$stmt->bind_param($binders, $binded[0], $binded[1]);
					}else if (count($binded) == 3)
					{
						$stmt->bind_param($binders, $binded[0], $binded[1], $binded[2]);
					}else if (count($binded) == 4)
					{
						$stmt->bind_param($binders, $binded[0], $binded[1], $binded[2], $binded[3]);
					}else if (count($binded) == 5)
					{
						$stmt->bind_param($binders, $binded[0], $binded[1], $binded[2], $binded[3], $binded[4]);
					}else if (count($binded) == 6)
					{
						$stmt->bind_param($binders, $binded[0], $binded[1], $binded[2], $binded[3], $binded[4], $binded[5]);
					}else if (count($binded) == 7)
					{
						$stmt->bind_param($binders, $binded[0], $binded[1], $binded[2], $binded[3], $binded[4], $binded[5], $binded[6]);
					}else if (count($binded) == 7)
					{
						$stmt->bind_param($binders, $binded[0], $binded[1], $binded[2], $binded[3], $binded[4], $binded[5], $binded[6], $binded[7]);
					}
				}
				$stmt->execute();
				$stmt->store_result();
				
            	$stmt->bind_result($namess, $Regno, $rrr, $tdate, $amount);?>
				
				<ul id="li1" class="checklist cl1"><?php
					$cont = 0;
					
					$total = 0;
					while ($stmt->fetch())
					{?>
						<li style="height:auto; padding:0px; width:100%; border:0px; margin-left:4px;">
							<div class="ctabletd_1" style="width:4.9%; height:auto; padding:4px; border:1px solid #A7BAAD; text-align:right;"><?php echo ++$cont;?>
							</div>

							<div class="ctabletd_1" style="width:29.9%; height:auto; padding:4px; margin-left:-1px; text-align:left;">
								<?php echo $namess;?>
							</div>

							<div class="ctabletd_1" style="width:17%; height:auto; padding:4px; margin-left:-1px; text-align:left;">
								<?php echo $Regno;?>
							</div>

							<div class="ctabletd_1" style="width:13.8%; height:auto; padding:4px; margin-left:-1px; text-align:left;">
								<?php echo $rrr;?>
							</div>
							<div class="ctabletd_1" style="width:12%; height:auto; padding:4px; margin-left:-1px; text-align:left;">
								<?php echo formatdate(substr($tdate,0,10), 'fromdb');?>
							</div>
							<div class="ctabletd_1" style="width:14.9%; height:auto; padding:4px; margin-left:-1px; text-align:right;"><?php 
								$total += $amount; 
								echo number_format($amount,2);?>
							</div>
						</li><?php
					}?>
					<li style="height:auto; padding:0px; width:100%; border:0px; margin-left:4px; font-weight:bold;">
						<div class="ctabletd_1" style="width:81.9%; height:auto; padding:4px; border:1px solid #A7BAAD; text-align:right;"><?php
							if (isset($_REQUEST['vMatricNo_burs_prns']) && $_REQUEST['vMatricNo_burs_prns'] <> '')
							{
								echo 'Balance';
							}else
							{
								echo 'Total';
							}?>
						</div>
						<div class="ctabletd_1" style="width:14.8%; height:auto; padding:4px; margin-left:-1px; border:1px solid #A7BAAD; text-align:right;"><?php echo number_format($total,2);?></div>
					</li><?php
					$stmt->close();?>
				</ul><?php
			}
		}else if (isset($_REQUEST['side_menu_no']))
		{
			if ($_REQUEST['side_menu_no'] == '1')
			{?>
				<div class="innercont" style="margin-top:7px; height:auto; margin-left:4px; border-radius:0px;width:840px;">
					<div class="innercont" style="margin-top:-1px; margin-left:-1px; padding-top:5px; border-radius:0px;width:840px;border: 1px solid #FFFFFF;">
						<b>Statement of credit transactions</b>	
					</div>
					<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:inherit; padding:0px;">
						<div class="ctabletd_1" style="width:40px; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Sno</div>
						<div class="ctabletd_1" style="width:165px;height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Date</div>
						<div class="ctabletd_1" style="width:317px; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Description</div>
						<div class="ctabletd_1" style="width:95px; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Debit(N)</div>
						<div class="ctabletd_1" style="width:95px; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Credit(N)</div>
						<div class="ctabletd_1" style="width:110px; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Balance(N)</div>					
					</div><?php
					$stmt = $mysqli->prepare("SELECT tdate, cCourseId, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester) vDesc, cAcademicDesc, tSemester, a.Amount Amount_a, vremark, a.RetrievalReferenceNumber, b.fee_item_desc 
                    FROM s_tranxion_cr a, fee_items b
                    WHERE a.fee_item_id = b.fee_item_id
                    AND b.cdel = 'N'
                    AND vMatricNo = ?
                    ORDER BY tdate;");
                        
					/*$stmt = $mysqli->prepare("SELECT a.iItemID, tdate, cCourseId, concat(c.fee_item_desc ,' ',cAcademicDesc,'-',cCourseId,'-',tSemester) c.fee_item_desc vDesc, cAcademicDesc, tSemester, cTrntype,a.Amount Amount_a, b.Amount Amount_b, vremark 
					FROM s_tranxion a, s_f_s b, fee_items c 
					WHERE b.fee_item_id = c.fee_item_id 
					AND a.iItemID = b.iItemID 
					and vMatricNo = ? 
					and cTrntype = 'c'
					AND c.cdel = 'N'
					order by tdate");*/
					
					$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result( $tdate, $cCourseId, $vDesc, $cAcademicDesc, $tSemester, $Amount_a, $vremark, $rrr, $fee_item_desc);?>
					<ul id="li1" class="checklist cl1"><?php
					$balance = 0; $cnt = 0;
					
					while($stmt->fetch())
					{?>
						<li <?php if ($cnt%2 == 0){echo ' class="alt"';}?> style="height:25px;">
							<div class="ctabletd_1" style="width:40px; height:20px; text-align:right;"><?php echo ++$cnt; ?></div>
							<div class="ctabletd_1" style="width:165px; height:20px; text-align:left;"><?php echo $tdate; ?></div>
							<div class="ctabletd_1" style="width:317px; height:20px; text-align:left;">
							</div>
							<div class="ctabletd_1" style="width:95px; height:20px; text-align:right;"></div>
							<div class="ctabletd_1" style="width:95px; height:20px; text-align:right;"><?php			
							    echo number_format($Amount_a);$balance += $Amount_a;?>
							</div>
							<div class="ctabletd_1" style="width:109px; height:20px; text-align:right;"><?php echo number_format($balance); ?></div>
						</li><?php 
					}
					$stmt->close();?>
					</ul>
					
					<div class="innercont" style="margin-top:-1px; margin-left:-1px; padding-top:15px; border-radius:0px;width:840px;border: 1px solid #FFFFFF;">
						<b>Statement of debit transactions</b>	
					</div>
					<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:inherit; padding:0px;">
						<div class="ctabletd_1" style="width:40px; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Sno</div>
						<div class="ctabletd_1" style="width:165px;height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Date</div>
						<div class="ctabletd_1" style="width:317px; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Description</div>
						<div class="ctabletd_1" style="width:95px; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Debit(N)</div>
						<div class="ctabletd_1" style="width:95px; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Credit(N)</div>
						<div class="ctabletd_1" style="width:110px; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Balance(N)</div>
					</div><?php
					
					$table = search_starting_pt($_REQUEST['vMatricNo']);
                    $wallet_trn_cnt = 0;
                    
                    foreach ($table as &$value)
                    {
                        $wrking_tab = 's_tranxion_'.$value;
                        
                        $stmt = $mysqli->prepare("SELECT tdate, cCourseId, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester) vDesc,  a.Amount Amount_a, vremark 
                        FROM $wrking_tab a, fee_items b
                        WHERE a.fee_item_id = b.fee_item_id
                        AND b.cdel = 'N'
                        AND vMatricNo = ?
                        ORDER BY tdate;");    
					
    					/*$stmt = $mysqli->prepare("SELECT tdate, concat(c.fee_item_desc,' ',cAcademicDesc,'-',tSemester) vDesc, cTrntype, a.Amount Amount_a, b.Amount Amount_b, vremark 
    					from s_tranxion a, s_f_s b, fee_items c  
    					where b.fee_item_id = c.fee_item_id 
    					AND a.iItemID = b.iItemID 
    					AND vMatricNo = ? 
    					AND cTrntype = 'd' 
    					AND b.cAcademicDesc = '".$orgsetins["cAcademicDesc"]."' order by tdate");*/
    					
    					$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
    					$stmt->execute();
    					$stmt->store_result();
    					
    					//$stmt->bind_result( $tdate, $cCourseId, $vDesc, $cTrntype, $Amount_a, $vremark);
    					
    					$stmt->bind_result( $tdate, $cCourseId, $vDesc, $Amount_a, $vremark);?>
    					<ul id="li1" class="checklist cl1"><?php
    						$balance_d = 0; $cnt = 0;
    						
    						while($stmt->fetch())
    						{?>
    							<li <?php if ($cnt%2 == 0){echo ' class="alt"';}?> style="height:25px;">
    								<div class="ctabletd_1" style="width:40px; height:20px; text-align:right;"><?php echo ++$cnt; ?></div>
    								<div class="ctabletd_1" style="width:165px; height:20px; text-align:left;"><?php echo $tdate ?></div>
    								<div class="ctabletd_1" style="width:317px; height:20px; text-align:left;">
    									<?php echo $vDesc;?>
    								</div>
    								<div class="ctabletd_1" style="width:95px; height:20px; text-align:right;"><?php 
    									echo number_format($Amount_a);$balance_d -= $Amount_a;?>
    								</div>
    								<div class="ctabletd_1" style="width:95px; height:20px; text-align:right;"></div>
    								<div class="ctabletd_1" style="width:109px; height:20px; text-align:right;"><?php echo number_format($balance_d); ?></div>
    							</li><?php 
    						}
                        }
						$stmt->close();?>
					</ul>
				</div>
				
				<div class="innercont" style="margin-top:10px; height:60px; padding-top:2px; padding-left:3px; margin-left:4px; margin-bottom:3px; border-radius:0px;width:837px;border:1px solid #CCCCCC;">
					<div style="margin-top:-1px; width:inherit; border-radius:0px; float:left;">
						<div style="width:150px; height:17px; margin-top:-1px; padding-top:5px;text-align:left; float:left; border-radius:0px;">Total credit transaction(N)</div>
						<div style="width:120px; height:17px; margin-top:-1px; padding-top:5px;text-align:right; float:left; border-radius:0px; margin-left:5px;">
							<b><?php echo number_format($balance); ?></b>
						</div>	
					</div>
					
					<div style="margin-top:-1px; width:inherit; border-radius:0px; float:left;">
						<div style="width:150px; height:17px; margin-top:-1px; padding-top:5px;text-align:left; float:left; border-radius:0px;">Total debit transaction(N)</div>
						<div style="width:120px; height:17px; margin-top:-1px; padding-top:5px;text-align:right; float:left; border-radius:0px; margin-left:5px;">
							<b><?php echo number_format($balance_d); ?></b>
						</div>	
					</div>
										
					<div style="margin-top:-1px; width:inherit; border-radius:0px; float:left;">
						<div style="width:150px; height:17px; margin-top:-1px; padding-top:5px;text-align:left; float:left; border-radius:0px;">Balance(N)</div>
						<div style="width:120px; height:17px; margin-top:-1px; padding-top:5px;text-align:right; float:left; border-radius:0px; margin-left:5px;">
							<b><?php echo number_format($balance-$balance_d); ?></b>
						</div>	
					</div>
				</div><?php
			}else if (($_REQUEST['side_menu_no'] == '7' && ($_REQUEST['what_to_do_frn'] == '3' || $_REQUEST['what_to_do_frn'] == '4') && $_REQUEST['on_what_frn'] == '3') || ($_REQUEST['side_menu_no'] == '6' && ($_REQUEST['what_to_do_frn'] == '3' || $_REQUEST['what_to_do_frn'] == '4') && $_REQUEST['on_what_frn'] == '3'))
			{
				$new_curr = '';
				$curr_set = '';
				if (isset($_REQUEST['select_curriculum_prn']))
				{
					if ($_REQUEST['select_curriculum_prn'] == '1')
					{
						//$new_curr = " AND a.cAcademicDesc <= 2023";
						$curr_set = '(Old curriculum)';
					}else if ($_REQUEST['select_curriculum_prn'] == '2')
					{
						//$new_curr = " AND a.cAcademicDesc = 2024";
						$curr_set = '(New curriculum)';
					}
				}?>
				<div class="innercont" style="margin-top:7px; height:auto; padding:10px; border-radius:0px;width:830px; font-size:0.9em;">
					<div class="innercont" style="margin-top:-1px; padding-top:5px; padding-bottom:5px; border-radius:0px; width:100%; font-weight:bold; height:auto; font-size:1em;">
						<?php echo $_REQUEST['vFacultyDesc_prn'];?>
					</div>
                    <div class="innercont" style="margin-top:-1px; padding-top:5px; padding-bottom:5px; border-radius:0px; width:100%; font-weight:bold; height:auto;">
						<?php echo 'Department of '.$_REQUEST['vdeptDesc_prn'];?>
					</div>
                    <div class="innercont" style="margin-top:-1px; padding-top:5px; padding-bottom:5px; border-radius:0px; width:100%; font-weight:bold; height:auto;">
						<?php echo $_REQUEST['vProgrammeDesc_prn'];?>
					</div><?php
					if (isset($_REQUEST['courseLevel_prn']) && $_REQUEST['courseLevel_prn'] <> '0' && $_REQUEST['courseLevel_prn'] <> '')
					{?>
						<div class="innercont" style="margin-top:-1px; padding-top:5px; padding-bottom:5px; border-radius:0px; width:100%; font-weight:bold; height:auto;">
							<?php echo $_REQUEST['courseLevel_prn'];?> Level
						</div><?php
					}?>
                    
                    <div class="innercont" style="margin-top:-1px; padding-top:5px; padding-bottom:5px; border-radius:0px; width:100%; font-weight:bold; height:auto;">
                        Registrable Courses <?php echo $curr_set;?>
					</div>
                    
                    <div class="innercont" style="margin-top:4px; padding-top:5px; padding-bottom:5px; border-radius:0px; width:100%; font-weight:bold; border-top: 1px solid #000;">
                        <div class="innercont" style="padding-top:5px; padding-bottom:5px; border-radius:0px; width:150px; text-align:left; height:auto; float:left">
                            <?php if ($_REQUEST['what_to_do_frn'] == '3')
							{?>
								Semester:<?php
								if ($_REQUEST['coursesemester_prn'] == '1')
								{
									echo 'First';
								}else if ($_REQUEST['coursesemester_prn'] == '2')
								{
									echo 'Second';
								}else {echo 'All';}
							}?>
                        </div>
                        
                        <div class="innercont" style="padding-top:5px; padding-bottom:5px; border-radius:0px; width:150px; height:auto; float:right; text-align:right">
                            <?php if ($_REQUEST['what_to_do_frn'] == '3' && $_REQUEST['courseLevel_prn'] <> '0'){echo 'Level: '.$_REQUEST['courseLevel_prn'];}?>
                        </div>
					</div><?php
					if (isset($_REQUEST['mm']) && $_REQUEST['mm'] <> 0)
					{?>                    
						<div class="innercont_stff" style="margin-top:-1px; margin-bottom:5px; font-weight:bold; height:auto">
							All Registered <?php if ($_REQUEST['side_menu_no'] == '7'){echo 'Courses ';}else{echo 'Courses for Examination ';}?>
						</div><?php
					}?>
					
					<div class="innercont_stff" style="border-radius:0px; margin-bottom:3px; width:100%; padding:0px;">
						<div class="ctabletd_1" style="width:5%; height:auto; padding:5px; background-color:#E3EBE2; text-align:right;">
							Sno
						</div>
						<div class="ctabletd_1" style="width:10%; height:auto; padding:5px; background-color:#E3EBE2; text-align:left;">
							Course code
						</div>
						<div class="ctabletd_1" style="width:44%; height:auto; padding:5px; background-color:#E3EBE2; text-align:left;">
							Course title
						</div>
						<div class="ctabletd_1" style="width:10%; height:auto; padding:5px; background-color:#E3EBE2; text-align:right;">
							Credit unit
						</div>
						<div class="ctabletd_1" style="width:10%; height:auto; padding:5px; background-color:#E3EBE2; text-align:center;">
							Category
						</div>
						<div class="ctabletd_1" style="width:12%; height:auto; padding:5px; background-color:#E3EBE2; text-align:right;">
							Cost (N)
						</div>
					</div>
					<ul id="rtside" class="checklist cl1" style="border:0px solid #cccccc;"><?php
                    	$stmt = $mysqli->prepare("SELECT cEduCtgId FROM programme WHERE cProgrammeId = ?");
						$stmt->bind_param("s", $_REQUEST['cprogrammeId_prn']);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($cEduCtgId);
						$stmt->fetch();
						$stmt->close();

						if ($_REQUEST['what_to_do_frn'] == '4')
						{
			 				$stmt = $mysqli->prepare("select a.siLevel, a.tSemester, a.cCourseId, c.vCourseDesc, iCreditUnit, cCategory
							from progcourse a, depts b, courses c
							where a.cdeptId = b.cdeptId 
							and a.cCourseId = c.cCourseId
							$new_curr
							and b.cFacultyId = ? and  a.cProgrammeId = ?
							and a.cdel = 'N'
							order by  a.siLevel, a.tSemester, cCategory, cCourseId");
							$stmt->bind_param("ss", $_REQUEST['cFacultyId_prn'],  $_REQUEST['cprogrammeId_prn']);
						}else if ($_REQUEST['what_to_do_frn'] == '3')
						{
							if (isset($_REQUEST['courseLevel_prn']) && $_REQUEST['courseLevel_prn'] <> '0' && isset($_REQUEST['coursesemester_prn']) && $_REQUEST['coursesemester_prn'] <> '3')
							{
								$stmt = $mysqli->prepare("select a.siLevel, a.tSemester, a.cCourseId, c.vCourseDesc, iCreditUnit, cCategory
								from progcourse a, depts b, courses c
								where a.cdeptId = b.cdeptId 
								and a.cCourseId = c.cCourseId
								$new_curr
								and a.siLevel = ? and a.tSemester = ?
								and b.cFacultyId = ? and  a.cProgrammeId = ?
								and a.cdel = 'N'
								order by siLevel, tSemester, cCategory, cCourseId");
								$stmt->bind_param("iiss", $_REQUEST['courseLevel_prn'], $_REQUEST['coursesemester_prn'], $_REQUEST['cFacultyId_prn'],  $_REQUEST['cprogrammeId_prn']);
							}else if (isset($_REQUEST['courseLevel_prn']) && $_REQUEST['courseLevel_prn'] <> '0' && !(isset($_REQUEST['coursesemester_prn']) && $_REQUEST['coursesemester_prn'] <> '3'))
							{
								$stmt = $mysqli->prepare("SELECT a.siLevel, a.tSemester, a.cCourseId, c.vCourseDesc, iCreditUnit, cCategory
								FROM progcourse a, depts b, courses c
								WHERE a.cdeptId = b.cdeptId 
								AND a.cCourseId = c.cCourseId
								$new_curr
								AND a.siLevel = ? 
								AND b.cFacultyId = ? 
								AND  a.cProgrammeId = ?
								AND a.cdel = 'N'
								ORDER BY siLevel, tSemester, cCategory, cCourseId");
								$stmt->bind_param("iss", $_REQUEST['courseLevel_prn'], $_REQUEST['cFacultyId_prn'],  $_REQUEST['cprogrammeId_prn']);
							}else if (!(isset($_REQUEST['courseLevel_prn']) && $_REQUEST['courseLevel_prn'] <> '0') && isset($_REQUEST['coursesemester_prn']) && $_REQUEST['coursesemester_prn'] <> '3')
							{
								$stmt = $mysqli->prepare("SELECT a.siLevel, a.tSemester, a.cCourseId, c.vCourseDesc, iCreditUnit, cCategory
								FROM progcourse a, depts b, courses c
								WHERE a.cdeptId = b.cdeptId 
								AND a.cCourseId = c.cCourseId
								$new_curr
								AND a.tSemester = ?
								AND b.cFacultyId = ? 
								AND  a.cProgrammeId = ?
								AND a.cdel = 'N'
								ORDER BY siLevel, tSemester, cCategory, cCourseId");
								$stmt->bind_param("iss", $_REQUEST['coursesemester_prn'], $_REQUEST['cFacultyId_prn'],  $_REQUEST['cprogrammeId_prn']);
							}else
							{
								$stmt = $mysqli->prepare("SELECT a.siLevel, a.tSemester, a.cCourseId, c.vCourseDesc, iCreditUnit, cCategory
								FROM progcourse a, depts b, courses c
								WHERE a.cdeptId = b.cdeptId 
								AND a.cCourseId = c.cCourseId
								$new_curr
								AND b.cFacultyId = ? 
								AND  a.cProgrammeId = ?
								AND a.cdel = 'N'
								ORDER BY a.siLevel, a.tSemester, cCategory, cCourseId");
								$stmt->bind_param("ss", $_REQUEST['cFacultyId_prn'],  $_REQUEST['cprogrammeId_prn']);
							}
						}
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result( $siLevel, $tSemester, $cCourseId, $vCourseDesc, $iCreditUnit, $cCategory);
			 
						$c = 0;  $total_total = 0; $total_cr = 0; $level = ''; $semester = '';
			 			$prev_dept = ''; $prev_fac = ''; $prev_dept = ''; $prevLevel = ''; $prevSemester = '';

						$total_cost = 0;
						$total_total_cost = 0;

						while($stmt->fetch())
						{
							$stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
							FROM s_f_s a, fee_items b
							WHERE a.fee_item_id = b.fee_item_id
							AND fee_item_desc = 'Course Registration'
							AND iCreditUnit = $iCreditUnit
							AND cEduCtgId = '$cEduCtgId'
							AND cFacultyId = ?
							AND a.citem_cat = 'A2'");
							$stmt_amount->bind_param("s", $_REQUEST['cFacultyId_prn']);
							$stmt_amount->execute();
							$stmt_amount->store_result();
							$stmt_amount->bind_result($Amount, $itemid);
							$stmt_amount->fetch();
							$stmt_amount->close();

							if (is_null($Amount))
							{
								$Amount = 0.00;
							}

							$c++;       
							$tSemester_desc = 'First';
							if ($tSemester == 2){$tSemester_desc = 'Second';}
							if ($_REQUEST['what_to_do_frn'] == '3')
							{
								if(($prevLevel = '' || $prevLevel <> $siLevel) || ($prevSemester = '' || $prevSemester <> $tSemester))
								{
									if($prevSemester <> '')
									{?>
										<li style="float:left; margin-left:2px; height:23px; width:100%; font-weight:bold">
											<div class="ctabletd_1" style="height:auto; width:61.7%; padding:5px; float:left; text-align:right;">
												Total
											</div>
											<div class="ctabletd_1" style="height:auto; width:10.1%; padding:5px; float:left; text-align:right;">
												<?php echo number_format($total_cr);?>
											</div>
											<div class="ctabletd_1" style="height:auto; width:10.1%; padding:5px; float:left; text-align:center;">
												-
											</div>
											<div class="ctabletd_1" style="height:auto; width:12%; padding:5px; float:left; text-align:right;">
												-<!-- <?php echo number_format($total_cost, 2, '.', ',');?> -->
											</div>
										</li><?php
									}?>
									<li style="float:left; margin-left:2px; height:23px; width:100%;">
											<div class="ctabletd_1" style="height:auto; width:99%; padding:3px; border:0px solid #A7BAAD; float:left; text-align:left;"><?php
										if (isset($_REQUEST['courseLevel_prn']) && $_REQUEST['courseLevel_prn'] == '0')
										{
											echo $siLevel.' Level ';
										}

										if (isset($_REQUEST['coursesemester_prn']) && $_REQUEST['coursesemester_prn'] == '3')
										{
											echo $tSemester_desc.' semester';
										}?>
										</div> 
									</li><?php
									$total_cr = 0;
									$total_cost = 0;
								}
							}else if ($_REQUEST['what_to_do_frn'] == '4')
							{
								if(($prevLevel = '' || $prevLevel <> $siLevel) || ($prevSemester = '' || $prevSemester <> $tSemester))
								{
									if($prevSemester <> '')
									{?>
										<li style="float:left; margin-left:2px; height:23px; width:100%; font-weight:bold;">
											<div class="ctabletd_1" style="height:auto; width:61.9%; padding:5px; border:none; border-right:1px solid #ccc; float:left; text-align:right;">
												Total
											</div>
											<div class="ctabletd_1" style="height:auto; width:9.9%; padding:5px; border:none; border-right:1px solid #ccc; float:left; text-align:right;">
												<?php echo number_format($total_cr);?>
											</div>
											<div class="ctabletd_1" style="height:auto; width:10.2%; padding:5px; border:none; border-right:1px solid #ccc; float:left; text-align:right;">
												-
											</div>
											<div class="ctabletd_1" style="height:auto; width:12.1%; padding:5px; border:none; border-right:1px solid #ccc; float:left; text-align:right;">
												-
											</div>
										</li><?php
									}?>
									<li style="float:left; margin-left:2px; height:23px; width:100%;">
											<div class="ctabletd_1" style="height:auto; width:99%; padding:3px; border:0px solid #A7BAAD; float:left; text-align:left;">
											<?php  echo $siLevel.'Level, '.$tSemester_desc.' semester';?>
										</div>
									</li><?php
									$total_cr = 0;
									$total_cost = 0;
								}
							}?>
                            
													
							<li style="float:left; margin-left:2px; height:23px; width:100%;">
								<div class="ctabletd_1" style="width:4.8%; height:auto; border-right:1px solid #ccc; padding:5px; text-align:right;">
									<?php echo $c;?>
								</div>
								<div class="ctabletd_1" style="width:10%; height:auto; border-right:1px solid #ccc; padding:5px; text-align:left;">
									<?php echo $cCourseId;?>
								</div>
								<div class="ctabletd_1" style="width:44.1%; height:auto; border-right:1px solid #ccc; padding:5px; text-align:left;">
									<?php echo $vCourseDesc; ?>
								</div>
								<div class="ctabletd_1" style="width:10%; height:auto; border-right:1px solid #ccc; padding:5px; text-align:right;">
									<?php echo $iCreditUnit;
									$total_cr += $iCreditUnit;
									$total_total += $iCreditUnit;?>
								</div>
								<div class="ctabletd_1" style="width:10.2%; height:auto; border-right:1px solid #ccc; padding:5px; text-align:center;">
									<?php echo $cCategory;?>
								</div>
								<div class="ctabletd_1" style="width:12%; height:auto; border-right:1px solid #ccc; padding:5px; text-align:right;">
									<?php echo number_format($Amount, 2, '.', ',');
									$total_cost = $total_cost + $Amount; 
									$total_total_cost += $Amount; ?>
								</div>
							</li><?php 
							if (isset($cFacultyId))
							{
								if ($_REQUEST['what_to_do_frn'] == '4')
								{								
									//$prev_fac = $cFacultyId;
									//$prev_dept = $cdeptId;
								}
							}
							$prevLevel = $siLevel;
							$prevSemester = $tSemester;
						}?>
						<li style="float:left; margin-left:2px; height:23px; width:100%; font-weight:bold">
							<div class="ctabletd_1" style="height:auto; width:61.7%; border:1px solid #ccc; padding:5px; float:left; text-align:right;">
								Totals
							</div>
							<div class="ctabletd_1" style="height:auto; width:10.1%; border:1px solid #ccc; padding:5px; float:left; text-align:right;">
								<?php echo number_format($total_cr);?>
							</div>
							<div class="ctabletd_1" style="height:auto; width:10.1%; border:1px solid #ccc; padding:5px; float:left; text-align:right;">
								-
							</div>
							<div class="ctabletd_1" style="height:auto; width:12%; border:1px solid #ccc; padding:5px; float:left; text-align:right;">
								-<!-- <?php echo number_format($total_cost, 2, '.', ',');?> -->
							</div>
						</li>
						<!-- <li style="float:left; margin-left:2px; height:23px; width:100%;">
							<div class="ctabletd_1" style="height:auto; width:61.9%; padding:5px; border:none; border-right:1px solid #ccc; float:left; text-align:right;">
							Grand total
							</div>
							<div class="ctabletd_1" style="height:auto; width:9.9%; padding:5px; border:none; border-right:1px solid #ccc; float:left; text-align:right;">
								<?php echo number_format($total_total);?>
							</div>
							<div class="ctabletd_1" style="height:auto; width:10.2%; padding:5px; border:none; border-right:1px solid #ccc; float:left; text-align:right;">
								-
							</div>
							<div class="ctabletd_1" style="height:auto; width:12.1%; padding:5px; border:none; border-right:1px solid #ccc; float:left; text-align:right;">
								-
							</div>
						
							<label style="height:auto;">
								<div class="ctabletd_1" style="height:auto; width:99%; padding:3px; border:0px solid #A7BAAD; float:left; text-align:right;">
                                    <?php  echo number_format($total_total_cost, 2, '.', ',');?>
                                </div> 
                            </label>
                        </li> -->
					</ul>
				</div><?php
			}else if ($_REQUEST['side_menu_no'] == '7' && $_REQUEST['what_to_do_frn'] == 4)
			{?>
				<div class="innercont" style="margin-top:7px; height:auto; margin-left:4px; border-radius:0px; width:840px;font-size: 1.0em;"><?php
					if ($_REQUEST['on_what_frn'] == '0')
					{?>					
						<div class="innercont_stff" style="margin-top:5px; margin-bottom:5px; font-weight:bold; height:auto">
						List of Faculties
						</div>
						<div class="innercont_stff" style="border-radius:0px; margin-bottom:3px;  padding:0px;">
							<div class="ctabletd_1" style="width:5%; height:auto; padding:5px; background-color:#E3EBE2; text-align:right;">
								Sno
							</div>
							<div class="ctabletd_1" style="width:10%; height:auto; padding:5px; background-color:#E3EBE2; text-align:left;">
								Faculty ID
							</div>
							<div class="ctabletd_1" style="width:80.7%; height:auto; padding:5px; background-color:#E3EBE2; text-align:left;">
								Faculty name
							</div>
						</div><?php
						$stmt = $mysqli->prepare("SELECT cFacultyId, vFacultyDesc FROM faculty WHERE cCat = 'A'AND cFacultyId <> 'CEG' AND cDelFlag = 'N' ORDER BY cFacultyId");
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result( $cFacultyId, $vFacultyDesc);
						
						$c = 0;?>
						<ul class="checklist cl1" style="border:1px solid #cccccc; margin-left:0.4px; width:99.5%; padding:-1px;"><?php
							while($stmt->fetch())
							{?>
								<li style="float:left; height:auto; width:100%;">
									<div class="ctabletd_1" style="width:5.1%; height:auto; padding:5px; border:0px; border-right:1px solid #ccc; text-align:right;">
										<?php echo ++$c;?>
									</div>
									<div class="ctabletd_1" style="width:10%; height:auto; padding:5px; border:0px; border-right:1px solid #ccc; text-align:left;">
										<?php echo $cFacultyId;?>
									</div>
									<div class="ctabletd_1" style="width:75%; height:auto; padding:5px; border:0px; text-align:left;">
										<?php echo $vFacultyDesc;?>
									</div>
								</li><?php							
							}
							$stmt->close();?>
						</ul><?php
					}else if ($_REQUEST['on_what_frn'] == '1')
					{						
						$ub_sql = '';
						if (isset($_REQUEST['cFacultyId_prn']) && $_REQUEST['cFacultyId_prn'] <> '')
						{
							$ub_sql = " where a.cFacultyId = '".$_REQUEST['cFacultyId_prn']."' ";?>
							<div class="innercont_stff" style="margin-top:-1px; margin-bottom:10px; font-weight:bold; height:auto">
								<?php echo $_REQUEST['vFacultyDesc_prn'];?>
							</div><?php
						}?>					
						
						<div class="innercont_stff" style="margin-top:-1px; margin-bottom:5px; font-weight:bold; height:auto">
							List of Academic Departments
						</div>
						<div class="innercont_stff" style="border-radius:0px; margin-bottom:3px;  padding:0px;">
							<div class="ctabletd_1" style="width:5%; height:auto; padding:5px; background-color:#E3EBE2; text-align:right;">
								Sno
							</div>
							<div class="ctabletd_1" style="width:12%; height:auto; padding:5px; background-color:#E3EBE2; text-align:left;">
								Department ID
							</div>
							<div class="ctabletd_1" style="width:78.7%; height:auto; padding:5px; background-color:#E3EBE2; text-align:left;">
								Department name
							</div>
						</div><?php
						$ub_sql = '';
						if (isset($_REQUEST['cFacultyId_prn']) && $_REQUEST['cFacultyId_prn'] <> '')
						{
							$stmt = $mysqli->prepare("select a.cFacultyId, vFacultyDesc, cdeptId, vdeptDesc
							from depts a inner join faculty b 
							using(cFacultyId) where a.cFacultyId = ? order by cFacultyId, cdeptId;");
							$stmt->bind_param("s", $_REQUEST["cFacultyId_prn"]);
						}else
						{
							$stmt = $mysqli->prepare("select a.cFacultyId, vFacultyDesc, cdeptId, vdeptDesc
							from depts a inner join faculty b 
							using(cFacultyId) order by cFacultyId, cdeptId;");
						}
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($cFacultyId, $vFacultyDesc, $cdeptId, $vdeptDesc);
						
						$c = 0; $count_fac = 0; $count_dept = 0;
						$prev_fac = '';?>
						<ul class="checklist cl1" style="border:1px solid #cccccc;"><?php
						while($stmt->fetch())
						{
							if ($ub_sql == '' && ($prev_fac == '' || $prev_fac <> $cFacultyId))
							{?>
								<li style="float:left; margin-left:2px; height:auto; width:100%; margin:-1px;">
									<label style="height:auto;">								
										<div class="ctabletd_1" style="width:100%; height:auto; padding:5px; border:1px solid #A7BAAD; text-align:left;">
											<?php echo '['.$cFacultyId.'] '.$vFacultyDesc;?>
										</div>
									</label>
								</li><?php
							 	$c = 0;
							 	$count_fac++;
							}?>							
							<li style="float:left; margin-left:2px; height:auto; width:100%; margin:-1px;">
								<div class="ctabletd_1" style="width:5%; height:auto; padding:5px; border:0px; border-right:10px solid ccc; text-align:right;">
									<?php echo ++$c;?>
								</div>
								<div class="ctabletd_1" style="width:12%; height:auto; padding:5px; border:0px; border-right:10px solid ccc; text-align:left;">
									<?php echo $cdeptId;?>
								</div>
								<div class="ctabletd_1" style="width:73%; height:auto; padding:5px; border:0px; text-align:left;">
									<?php echo $vdeptDesc;?>
								</div>
							</li><?php
						 	$prev_fac = $cFacultyId;
							$count_dept++;
						}
						$stmt->close();
						if ($ub_sql == '')
						{?>
							<li style="float:left; margin-left:2px; height:auto; width:100%; margin:-1px;">
								<label style="height:auto;">								
									<div class="ctabletd_1" style="width:100%; height:auto; padding:5px; border:1px solid #A7BAAD; text-align:left;">
									<?php echo 'Total numner of faculties: '.$count_fac.', Total number of departments:  '.$count_dept;?>
									</div>
								</label>
							</li><?php
						}?>
						</ul><?php
					}else if ($_REQUEST['on_what_frn'] == '2')
					{
						$ub_sql_fac = '';
						if (isset($_REQUEST['cFacultyId_prn']) && $_REQUEST['cFacultyId_prn'] <> '')
						{?>
							<div class="innercont" style="margin-top:-1px; margin-left:-1px; padding-top:3px; padding-bottom:3px; border-radius:0px; width:840px; font-weight:bold; height:auto; font-size:12px;">
								<?php echo $_REQUEST['vFacultyDesc_prn'];?>
							</div><?php
						 	$ub_sql_fac = '1';
						}
					 
						$ub_sql_dpt = '';
						if (isset($_REQUEST['cdept_prn']) && $_REQUEST['cdept_prn'] <> '')
						{?>
							<div class="innercont" style="margin-top:-1px; margin-left:-1px; padding-top:3px; padding-bottom:3px; border-radius:0px; width:840px; font-weight:bold; height:auto; font-size:12px;">
								<?php echo $_REQUEST['vdeptDesc_prn'];?>
							</div><?php
						 	$ub_sql_dpt = '1';
						}
						
						if (isset($_REQUEST['cFacultyId_prn']) && $_REQUEST['cFacultyId_prn'] <> '' && isset($_REQUEST['cdept_prn']) && $_REQUEST['cdept_prn'] <> '')
						{
							$stmt = $mysqli->prepare("select b.cFacultyId, c.vFacultyDesc, a.cdeptId, vdeptDesc, a.cProgrammeId, d.vObtQualTitle, vProgrammeDesc
							from programme a, depts b, faculty c, obtainablequal d
							where a.cdeptId = b.cdeptId
							and b.cFacultyId = c.cFacultyId
							and a.cObtQualId = d.cObtQualId
							and c.cFacultyId = ?
							and a.cdeptId = ?
							and c.cDelFlag = 'N'
							and b.cDelFlag = 'N'
							and a.cDelFlag = 'N'
							order by b.cFacultyId, a.cdeptId, a.cProgrammeId");
							$stmt->bind_param("ss", $_REQUEST["cFacultyId_prn"], $_REQUEST['cdept_prn']);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($cFacultyId, $vFacultyDesc, $cdeptId, $vdeptDesc, $cProgrammeId, $vObtQualTitle, $vProgrammeDesc);
						}else if (isset($_REQUEST['cFacultyId_prn']) && $_REQUEST['cFacultyId_prn'] <> '')
						{
							$stmt = $mysqli->prepare("select b.cFacultyId, c.vFacultyDesc, a.cdeptId, vdeptDesc, a.cProgrammeId, d.vObtQualTitle, vProgrammeDesc
							from programme a, depts b, faculty c, obtainablequal d
							where a.cdeptId = b.cdeptId
							and b.cFacultyId = c.cFacultyId
							and a.cObtQualId = d.cObtQualId
							and c.cFacultyId = ?
							and c.cDelFlag = 'N'
							and b.cDelFlag = 'N'
							and a.cDelFlag = 'N'
							order by b.cFacultyId, a.cdeptId, a.cProgrammeId");
							$stmt->bind_param("s", $_REQUEST["cFacultyId_prn"]);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($cFacultyId, $vFacultyDesc, $cdeptId, $vdeptDesc, $cProgrammeId, $vObtQualTitle, $vProgrammeDesc);
						}?>
						
						
						<div class="innercont_stff" style="margin-top:-1px; margin-bottom:5px; font-weight:bold; height:auto">
							List of Academic Programmes
						</div>
						
						<div class="innercont_stff" style="border-radius:0px; margin-bottom:3px; width:100%; padding:0px;">
							<div class="ctabletd_1" style="width:5%; height:auto; padding:5px; background-color:#E3EBE2; text-align:right;">
								Sno
							</div>
							<div class="ctabletd_1" style="width:92.14%; height:auto; padding:5px; background-color:#E3EBE2; text-align:left;">
								Programme
							</div>
						</div><?php						
						$c = 0; $count_fac = 0; $count_dept = 0; $count_prog = 0; $prev_fac = ''; $prev_dpt = '';
						if ($stmt->num_rows > 0)
						{?>						
							<ul class="checklist cl1" style="border:1px solid #cccccc;"><?php
							while($stmt->fetch())
							{
								if ($ub_sql_fac == '' && ($prev_fac == '' || $prev_fac <> $cFacultyId))
								{?>
									<li style="text-align:left; height:23px;font-weight:bold">
										<label style="height:auto;">								
											<div class="ctabletd_1" style="width:840px;height:17px; text-indent:4px; padding-top:5px; border:1px solid #A7BAAD; text-align:left; margin-right:2px">
												<?php echo '['.$cFacultyId.'] '.$vFacultyDesc;?>
											</div>
										</label>
									</li><?php
									$count_fac++;
									$c = 0;
								}

								if ($ub_sql_dpt == '' && ($prev_dpt == '' || $prev_dpt <> $cdeptId))
								{?>
									<li style="text-align:left; height:23px; background:#f3f3f3">
										<label style="height:auto;">								
											<div class="ctabletd_1" style="width:840px;height:17px; text-indent:4px; padding-top:5px; border:1px solid #A7BAAD; text-align:left; margin-right:2px">
												<?php echo '['.$cdeptId.'] '.$vdeptDesc;?>
											</div>
										</label>
									</li><?php
									$count_dept++;
									$c = 0;
								}?>

								<li style="float:left; margin-left:2px; height:auto; width:100%; margin:-1px;">
									<div class="ctabletd_1" style="width:5%; height:auto; padding:5px; border:0px; border-right:10px solid ccc; text-align:right;">
										<?php echo ++$c;?>
									</div>
									<div class="ctabletd_1" style="width:12%; height:auto; padding:5px; border:0px; border-right:10px solid ccc; text-align:left;">
										<?php echo $vObtQualTitle;?>
									</div>
									<div class="ctabletd_1" style="width:73%; height:auto; padding:5px; border:0px; text-align:left;">
										<?php echo $vProgrammeDesc;?>
									</div>
								</li><?php
								$prev_fac = $cFacultyId;
								$prev_dpt = $cdeptId;
								$count_prog++;
							}
						}

						if (isset($stmt))
						{
							$stmt->close();
						}
						
						if ($ub_sql_fac == '' || $ub_sql_dpt == '')
						{?>
							<li style="float:left; margin-left:2px; height:auto; width:100%; margin:-1px;">
								<label style="height:auto;">								
									<div class="ctabletd_1" style="width:100%; height:auto; padding:5px; border:1px solid #A7BAAD; text-align:left;"><?php 
										$totals = '';
										if ($ub_sql_fac == '')
									   {
											$totals = 'Total numner of faculties: '.$count_fac;
									   }
						   
									   if ($ub_sql_dpt == '')
									   {
										   if ($totals <> ''){$totals .= ', Total number of departments:  '.$count_dept;}else
										   {$totals .= 'Total number of departments:  '.$count_dept;}
									   }
									   $totals .= ', Total number of programmes:  '.$count_prog;
									   echo $totals;?>
									</div>
								</label>
							</li><?php
						}?>
						</ul><?php
					}?>
				</div><?php
			}else if ($_REQUEST['side_menu_no'] == '7' || $_REQUEST['side_menu_no'] == '10')
			{
				$new_curr = '';
				$curr_set = '';
				if (isset($_REQUEST['select_curriculum_prn']))
				{
					if ($_REQUEST['select_curriculum_prn'] == '1')
					{
						$new_curr = " AND f.cAcademicDesc <= 2023";
						$curr_set = '(Old curriculum)';
					}else if ($_REQUEST['select_curriculum_prn'] == '2')
					{
						$new_curr = " AND f.cAcademicDesc = 2024";
						$curr_set = '(New curriculum)';
					}
				}?>
				<div class="innercont" style="margin-top:7px; height:auto; margin-left:4px; border-radius:0px; width:840px;font-size: 1.0em;">
					<!-- <div class="innercont_stff" style="margin-top:-1px; margin-bottom:5px; font-weight:bold; height:auto">
						All Registered <?php if ($_REQUEST['side_menu_no'] == '7'){echo 'Courses ';}else{echo 'Courses for Examination ';}?>
					</div>
					
					<div class="innercont_stff" style="border-radius:0px; margin-bottom:3px; width:100%; padding:0px;">
						<div class="ctabletd_1" style="width:5%; height:auto; padding:5px; background-color:#E3EBE2; text-align:right;">
							Sno
						</div>
						<div class="ctabletd_1" style="width:10%; height:auto; padding:5px; background-color:#E3EBE2; text-align:left;">
							Course code
						</div>
						<div class="ctabletd_1" style="width:40%; height:auto; padding:5px; background-color:#E3EBE2; text-align:left;">
							Course title
						</div>
						<div class="ctabletd_1" style="width:10%; height:auto; padding:5px; background-color:#E3EBE2; text-align:left;">
							Credit unit
						</div>
						<div class="ctabletd_1" style="width:10%; height:auto; padding:5px; background-color:#E3EBE2; text-align:center;">
							Category
						</div>
						<div class="ctabletd_1" style="width:10%; height:auto; padding:5px; background-color:#E3EBE2; text-align:right;">
							Cost (N)
						</div>
					</div> -->
				
					<div class="innercont" style="margin-top:-1px; margin-left:-1px; padding-top:5px; border-radius:0px;width:840px;border: 1px solid #FFFFFF;">
						<b>Alls Registered <?php if ($_REQUEST['side_menu_no'] == '7'){echo 'Courses ';}else{echo 'Courses for Examination ';}?></b>	
					</div>
					<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:inherit; padding:0px;">
						<div class="ctabletd_1" style="width:30px; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Sno</div>
						<div class="ctabletd_1" style="width:75px;height:17px; text-indent:2px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Course code</div>
						<div class="ctabletd_1" style="width:372px; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Course title</div>
						<div class="ctabletd_1" style="width:65px; height:17px; padding-right:2px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Credit unit</div>
						<div class="ctabletd_1" style="width:70px; height:17px; text-indent:2px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Session</div>
						<div class="ctabletd_1" style="width:65px; padding-right:2px; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Cost (N)</div>
						<div class="ctabletd_1" style="width:55px; height:17px; padding-right:2px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:centeer;">Category</div>	
						<div class="ctabletd_1" style="width:80px;height:17px; text-indent:2px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Date</div>		
					</div>
					<ul id="rtside" class="checklist cl1" style="border:1px solid #cccccc;"><?php
						if ($_REQUEST['side_menu_no'] == '7')
						{
							// $stmt = $mysqli->prepare("SELECT a.cCourseId, b.vCourseDesc, a.cAcademicDesc, b.iCreditUnit, d.amount, c.tdate, e.cCategory, a.tSemester
							// FROM coursereg a, courses b, s_tranxion c, s_f_s d, progcourse e, s_m_t f, fee_items g
							// WHERE a.cCourseId = b.cCourseId
							// AND c.cCourseId = a.cCourseId
							// AND e.cCourseId = a.cCourseId
							// AND c.iItemID = d.iItemID 
							// AND d.fee_item_id = g.fee_item_id
							// AND d.cAcademicDesc = '".$orgsetins["cAcademicDesc"]."'
							// AND g.fee_item_desc like '%course reg%'
							// AND a.vMatricNo = f.vMatricNo
							// AND f.cProgrammeId = e.cProgrammeId
							// AND a.vMatricNo = ?
							// ORDER BY a.cAcademicDesc, a.siLevel, a.tSemester, a.cCourseId");

							$stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, a.cAcademicDesc, a.iCreditUnit, d.amount, c.tdate, a.cCategory, a.tSemester
							FROM coursereg_arch a, s_tranxion c, s_f_s d, fee_items g
							WHERE c.cCourseId = a.cCourseId
							AND c.iItemID = d.iItemID 
							AND d.fee_item_id = g.fee_item_id
							AND d.cAcademicDesc = '".$orgsetins["cAcademicDesc"]."'
							AND g.cdel = 'N'
							AND g.fee_item_desc like '%course reg%'
							AND a.vMatricNo = ?
							ORDER BY a.cAcademicDesc, a.siLevel, a.tSemester, a.cCourseId");
						}else
						{
							$stmt = $mysqli->prepare("SELECT a.cCourseId, b.vCourseDesc, a.cAcademicDesc, b.iCreditUnit, c.amount, f.cCategory, a.tdate, a.tSemester 
							FROM examreg a, courses b, s_f_s c, s_m_t d, programme e, progcourse f, fee_items g 
							WHERE a.cCourseId = b.cCourseId 
							AND d.cProgrammeId = e.cProgrammeId 
							AND d.cProgrammeId = f.cProgrammeId 
							AND a.cCourseId = f.cCourseId 
							AND e.cEduCtgId = c.cEduCtgId 
							AND a.vMatricNo = d.vMatricNo 
							AND c.fee_item_id = g.fee_item_id
							AND g.cdel = 'N'
							$new_curr
							AND c.cAcademicDesc = '".$orgsetins["cAcademicDesc"]."'
							AND c.fee_item_desc like '%exam reg%'
							AND a.vMatricNo = ?
							ORDER BY a.cAcademicDesc, a.siLevel, a.tSemester, f.cCategory, a.cCourseId");
						}
			 
						$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($cCourseId, $vCourseDesc, $cAcademicDesc, $iCreditUnit, $amount, $cCategory, $tdate, $tSemester);
						
						$c = 0;  $total_cost = 0; $total_cr = 0;
						while($stmt->fetch())
						{
							$c++;?>
							<li id="ali<?php echo $c;?>" style="text-align:left; height:23px;"<?php if ($c%2 == 0){echo ' class="alt"';}?>>
								<label for="regCourses<?php echo $c ?>" style="height:auto;">
									<div class="ctabletd_1" style="width:30px; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:right;">
										<?php echo $c ?>
									</div>
									<div class="ctabletd_1" style="width:75px;height:17px; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
										<?php echo '['.$tSemester.'] '.$cCourseId; ?>
									</div>
									<div class="ctabletd_1" style="width:372px; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
										<?php echo $vCourseDesc; ?>
									</div>
									<div class="ctabletd_1" style="width:65px; height:17px; padding-right:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:right;">
										<?php echo $iCreditUnit;$total_cr = $total_cr + $iCreditUnit; ?>
									</div>
									<div class="ctabletd_1" style="width:70px; height:17px; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
										<?php echo $cAcademicDesc; ?>
									</div>
									<div class="ctabletd_1" style="width:65px; padding-right:2px; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:right;">
										<?php echo number_format($amount);$total_cost = $total_cost + $amount; ?>
									</div>
									<div class="ctabletd_1" style="width:55px; height:17px; padding-right:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:center;">
										<?php echo $cCategory; ?>
									</div><div class="ctabletd_1" style="width:80px;height:17px; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
										<?php echo substr($tdate,8,2).'/'.substr($tdate,5,2).'/'.substr($tdate,0,4); ?>
									</div>
								</label>
							</li><?php
						}
						$stmt->close();?>
					</ul>
					<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-top:3px; font-weight:bold; width:inherit; padding:0px;">
						<div class="ctabletd_1" style="width:483px; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Total</div>
						<div class="ctabletd_1" style="width:65px; height:17px; padding-right:2px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
							<?php echo $total_cr ?>
						</div>
						<div class="ctabletd_1" style="width:70px; height:17px; text-indent:2px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;"></div>
						<div class="ctabletd_1" style="width:65px; padding-right:2px; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
								<?php echo number_format($total_cost) ?>
							</div>
						<div class="ctabletd_1" style="width:55px; height:17px; padding-right:2px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:centeer;"></div>	
						<div class="ctabletd_1" style="width:80px;height:17px; text-indent:2px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;"></div>				
					</div>
				</div><?php
			}else if ($_REQUEST['side_menu_no'] == '5')
			{?>
				<div class="innercont" style="margin-top:7px; height:auto; margin-left:4px; border-radius:0px;width:840px;font-size: 1.0em;">
					<div class="innercont" style="margin-top:-1px; margin-left:-1px; margin-bottom:4px; padding-top:5px; border-radius:0px;width:840px;border: 1px solid #ffffff;">
						<b>Academic History</b>	
					</div>
						<input name="vApplicationNo_img" id="vApplicationNo_img" type="hidden" />
						<input name="user_cat" id="user_cat" type="hidden" value="<?php echo $_REQUEST['user_cat']; ?>" />	
						<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
						<input name="currency" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
						<input name="cQualCodeId" id="cQualCodeId" type="hidden" value="" />
						<input name="vExamNo" id="vExamNo" type="hidden" value="" />
						<input name="loadcred" id="loadcred" type="hidden" value="" /><?php
						$stmt = $mysqli->prepare("select b.cEduCtgId, b.cQualCodeId, a.vExamNo, a.vApplicationNo, b.vQualCodeDesc, a.cExamMthYear 
						from applyqual a, qualification b, afnmatric c 
						where a.cQualCodeId = b.cQualCodeId 
						and c.vApplicationNo = a.vApplicationNo
						and c.vMatricNo = ? order by right(a.cExamMthYear,4), left(a.cExamMthYear,2)");
						$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($cEduCtgId, $cQualCodeId, $vExamNo, $vApplicationNo, $vQualCodeDesc, $cExamMthYear);

						$coun = $stmt->num_rows;
						$cred_cnt = 0;

						while($stmt->fetch())
						{
							$coun--;$cred_cnt++;

							$post_str = '';
							if ($cEduCtgId == 'OLX' ||  $cEduCtgId == 'OLZ'){$post_str = '335px';}
							else if ($cEduCtgId == 'OLY' ||  $cEduCtgId == 'ALX' ||  $cEduCtgId == 'ALY'){$post_str = '220px';}
							else if ($cEduCtgId == 'EVS'){$post_str = '175px';}
							else if (($cEduCtgId == 'ALW' ||  $cEduCtgId == 'ALZ' || substr($cEduCtgId,0,1) ==  'P' || substr($cEduCtgId,0,2) ==  'EL') && ($cEduCtgId <> 'PRP' && $cEduCtgId <> 'PMR')){$post_str = '155px';}?>

							<div id="credentialNum<?php echo $cred_cnt; ?>" class="innercont" 
							style="margin-bottom:5px; margin-left:-1px; padding:5px; border-radius:0px;width:830px;border: 1px dashed #000; height:auto">
								<div class="innercont" style="text-align:right; width:auto; height:18px;"><?php
									$qualc = "?cQualCodeId=".$cQualCodeId.
									"&vExamNo=".$vExamNo.
									"&vApplicationNo=".$vApplicationNo;?>
									<a href="#" onclick="_('vExamNo').value='<?php echo $vExamNo ?>';
									_('cQualCodeId').value='<?php echo $cQualCodeId ?>';
									_('vApplicationNo_img').value='<?php echo $vApplicationNo ?>';
									call_image();
									return false">
										<img src="img/cert.gif" title="Click to see uploaded scanned copy of credential" style="text-decoration:none" border="0" align="bottom"/>
									</a>
								</div>
								<div class="innercont" style="width:auto; height:20px; margin-top:-1px; padding:0px">
									<label class="div_lab">Exam Authority</label>
									<label class="div_val" style="width:420px;"><?php echo stripslashes($vQualCodeDesc);?></label>
								</div>
								<div class="innercont" style="width:auto; height:20px; margin-top:-1px; padding:0px;">
									<label class="div_lab">Centre/School Name</label>
									<label class="div_val" style="width:420px;"><?php echo ucwords(strtolower(stripslashes($vExamNo)));?></label>
								</div>

								<div class="innercont" style="width:auto; height:20px; margin-top:-1px; padding:0px;">
									<label class="div_lab">Month and year of qualification</label>
									<label class="div_val" style="width:420px;"><?php echo ucwords(strtolower(stripslashes($cExamMthYear)));?></label>
								</div>

								<div class="innercont" style="width:auto; height:20px; margin-top:-1px; padding:0px;">
									<label class="div_lab" style="text-align:right; font-weight:bold;background-color:#E3EBE2;border:1px solid #A7BAAD;">Subject</label>
									<label class="div_val" style="width:420px; text-align:left; margin-left:4px; font-weight:bold;background-color:#E3EBE2;border:1px solid #A7BAAD;">Grade<?php 
									$qual = "s6.cQualCodeId.value='".$cQualCodeId.
									"';s6.vExamNo.value='".$vExamNo."';";?>
									</label>
								</div><?php
								$stmt = $mysqli->prepare("select b.vQualSubjectDesc, c.cQualGradeCode from applysubject a, qualsubject b, qualgrade c, afnmatric d
								where a.cQualSubjectId = b.cQualSubjectId and
								a.cQualCodeId = '".$cQualCodeId."' and
								a.vExamNo = '".$vExamNo."' and
								a.cQualGradeId = c.cQualGradeId and
								d.vApplicationNo = a.vApplicationNo and 
								d.vMatricNo = ?");
								$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
								$stmt->execute();
								$stmt->store_result();
								$stmt->bind_result($vQualSubjectDesc, $cQualGradeCode);
								
								while($stmt->fetch())
								{?>
									<div class="innercont" style="width:auto; height:20px; margin-top:-1px;">
										<label class="div_lab" style="text-align:right;">
											<?php echo ucwords(strtolower(stripslashes($rssacad_sbjt["vQualSubjectDesc"])));?>
										</label>
										<label class="div_val" style="text-align:left; margin-left:4px; width:420px;">
											<?php echo stripslashes($rssacad_sbjt["cQualGradeCode"]);?>
										</label>
									</div><?php
								}
								$stmt->close();?>
							</div><?php
						}
						$stmt->close();?>
				</div><?php
			}else if ($_REQUEST['side_menu_no'] == '16')
			{
				$new_curr = '';
				$curr_set = '';
				if (isset($_REQUEST['select_curriculum_prn']))
				{
					if ($_REQUEST['select_curriculum_prn'] == '1')
					{
						$new_curr = " AND f.cAcademicDesc <= 2023";
						$curr_set = '(Old curriculum)';
					}else if ($_REQUEST['select_curriculum_prn'] == '2')
					{
						$new_curr = " AND f.cAcademicDesc = 2024";
						$curr_set = '(New curriculum)';
					}
				}?>
				<div class="innercont" style="margin-top:7px; height:auto; margin-left:4px; border-radius:0px;width:840px;font-size: 1.0em;">
					<div class="innercont" style="margin-top:-1px; margin-left:-1px; padding-top:5px; border-radius:0px;width:840px;border: 1px solid #FFFFFF;">
						<b>Course Grades and Status by Semester</b>	
					</div>
					
					<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:inherit; padding:0px;">
						<div  class="ctabletd_1" style="width:30px; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Sno</div>
						<div class="ctabletd_1" style="width:85px; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD;  text-align:left; text-indent:2px">Course Code</div>
						<div class="ctabletd_1" style="width:360px; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Course Title</div>						
						<div class="ctabletd_1" style="width:65px; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center;">CreditUnit</div>						
						<div class="ctabletd_1" style="width:70px; height:17px; padding-top:5px; text-indent:2px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Session</div>
						<div class="ctabletd_1" style="width:65px; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center;">
							Category
						</div>
						<div class="ctabletd_1" style="width:80px; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center;">Grade/Weight</div>
						<div class="ctabletd_1" style="width:60px; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center;border-radius: 0px 4px 0px 0px;">Repeat</div>
					</div><?php						
						$stmt = $mysqli->prepare("select a.cCourseId, b.vCourseDesc, a.siLevel, a.cAcademicDesc, b.iCreditUnit, c.amount, f.cCategory, e.cEduCtgId, a.tSemester, cgrade  
						from examreg a, courses b, s_f_s c, s_m_t d, programme e, progcourse f, fee_items g 
						where a.cCourseId = b.cCourseId 
						AND d.cProgrammeId = e.cProgrammeId 
						AND d.cProgrammeId = f.cProgrammeId 
						AND a.cCourseId = f.cCourseId 
						AND e.cEduCtgId = c.cEduCtgId 
						AND a.vMatricNo = d.vMatricNo 
						AND c.fee_item_id = g.fee_item_id
						and c.cAcademicDesc = '".$orgsetins["cAcademicDesc"]."' 
						AND g.fee_item_desc like '%exam reg%' 
						$new_curr
						AND a.vMatricNo = ? 
						ORDER BY a.siLevel, a.tSemester, f.cCategory, a.cCourseId");
						$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($cCourseId, $vCourseDesc, $siLevel, $cAcademicDesc, $iCreditUnit, $amount, $cCategory, $cEduCtgId, $tSemester, $cgrade);?>
					
						<ul id="rtside" class="checklist cl1" style="border:1px solid #cccccc;"><?php
						$c = 0; $total_cr = 0; $total_crp = 0; $total_cr_s = 0; $total_crp_s = 0; $prev_level = ''; $prev_sem = ''; $cwgp = 0; $wgp = 0; $total_cra_s = 0;
						
						while($stmt->fetch())
						{						
							if ($prev_sem <> $tSemester)
							{
								if ($prev_sem <> '')
								{?>
									<li id="ali<?php echo $c;?>" style="text-align:left; height:24px; margin-bottom:5px; margin-top:-1px">
										<div class="ctabletd_1" style="width:277px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">
											Total credit carried (TCC): <?php echo $total_cr_s; $total_cr_s = 0; ?>
										</div>
										<div class="ctabletd_1" style="width:269px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
											Totla credit earned (TCE): <?php echo $total_crp_s; ?>
										</div>
										<div class="ctabletd_1" style="width:284px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
											Grade point average (GPA): <?php 
											if($total_cra_s>0 && $orgsetins["cShowgpa"] == '1' && $orgsetins["cShowrslt_for_staff"] == '1')
											{
												echo round(($wgp/$total_cra_s),2);
											}
											$cwgp = $cwgp + $wgp; $wgp = 0; 
											$total_crp_s = 0; 
											$total_cra_s = 0; ?>
										</div>
									</li><?php
								}?>
								
								<li id="ali<?php echo $c;?>" style="text-align:left; height:24px;"<?php if ($c%2 == 0){echo ' class="alt"';}?>>
									<div style="padding:3px; font-weight:bold">
										<?php echo $siLevel.' level, '; 
										if ($tSemester == 1){echo 'First semester';}else{echo 'Second semester';}?>
									</div>
								</li><?php
							}
							
							$c++;
							$total_cr = $total_cr + $iCreditUnit;
							$total_cr_s = $total_cr_s + $iCreditUnit;
							
							if ($cgrade == 'A')
							{
								$wgp = $wgp + (5 * $iCreditUnit);
							}else if ($cgrade == 'B')
							{
								$wgp = $wgp + (4 * $iCreditUnit);
							}else if ($cgrade == 'C')
							{
								$wgp = $wgp + (3 * $iCreditUnit);
							}else if ($cgrade == 'D')
							{
								$wgp = $wgp + (2 * $iCreditUnit);
							}else if ($cgrade == 'E')
							{
								$wgp = $wgp + (1 * $iCreditUnit);
							}else if ($cgrade == 'F')
							{
								$wgp = $wgp + (0 * $iCreditUnit);
							}
							 
							if ($cEduCtgId <> 'PGX' && $cEduCtgId <> 'PGY')
							{
								if ($cgrade <> 'F' && $cgrade <> '')
								{
									$total_crp = $total_crp + $iCreditUnit;
									$total_crp_s = $total_crp_s + $iCreditUnit;
								}
							}else
							{
								if ($cgrade <> 'E' && $cgrade <> '')
								{
									$total_crp = $total_crp + $iCreditUnit;
									$total_crp_s = $total_crp_s + $iCreditUnit;
								}
							}
							
								
							if ($cgrade <> '')
							{
								$total_cra_s = $total_cra_s +  $iCreditUnit;
							}?>
							<li id="ali<?php echo $c;?>" style="text-align:left; height:24px;"<?php if ($c%2 == 0){echo ' class="alt"';}?>>
								<label for="regCourses<?php echo $c ?>" style="height:auto; padding-right:0px; cursor:default;">
									<div class="ctabletd_1" style="width:30px; text-align:right;">
										<?php echo $c;?>
									</div>
									<div class="ctabletd_1" style="width:85px; text-align:left; text-indent:2px">
										<?php echo $cCourseId;?>
									</div>
									<div class="ctabletd_1" style="width:360px; text-align:left;">
										<?php if (strlen($vCourseDesc) > 48){echo substr($vCourseDesc, 0,48)."...";}else{echo $vCourseDesc;}?>
									</div>
									<div class="ctabletd_1" style="width:65px; text-align:center;">
										<?php echo $iCreditUnit;?>
									</div>
									<div class="ctabletd_1"  style="width:70px; text-indent:2px; text-align:left;">
										<?php echo $cAcademicDesc;?>
									</div>
									<div class="ctabletd_1" style="width:65px; text-align:center;">
										<?php echo $cCategory;?>
									</div>										
									<div class="ctabletd_1" style="width:80px; text-align:center;"><?php 
										if ($orgsetins["cShowgrade"] == '1' && $orgsetins["cShowrslt_for_staff"] == '1')
										{
											echo $cgrade;
										}?>
									</div>										
									<div class="ctabletd_1" style="width:60px; text-align:center;">
										<?php 
										if (($orgsetins["cShowgrade"] == '1' || $orgsetins["cShowscore"] == '1') && $orgsetins["cShowrslt_for_staff"] == '1')
										{
											if ($cEduCtgId <> 'PGX' && $cEduCtgId <> 'PGY')
											{
												if ($cgrade == 'F'){echo 'Yes';}elseif ($cgrade == ''){echo 'Pending';}else{echo 'No';}
											}else
											{
												if ($cgrade == 'E'){echo 'Yes';}elseif ($cgrade == ''){echo 'Pending';}else{echo 'No';}
											}
										}?>
									</div>									
								</label>
							</li><?php
							$prev_level = $siLevel;
							$prev_sem = $tSemester;
						}
						$stmt->close();?>
						<li id="ali<?php echo $c;?>" style="text-align:left; height:24px; margin-bottom:5px">
							<div class="ctabletd_1" style="width:277px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">
								Total credit carried (TCC): <?php echo $total_cr_s; $total_cr_s = 0; ?>
							</div>
							<div class="ctabletd_1" style="width:277px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
								Totla credit earned (TCE): <?php echo $total_crp_s; ?>
							</div>
							<div class="ctabletd_1" style="width:276px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
								Grade point average (GPA): <?php 
								if($total_cra_s>0 && $orgsetins["cShowgpa"] == '1' && $orgsetins["cShowrslt_for_staff"] == '1')
								{
									echo round(($wgp/$total_cra_s),2);
								}
								$wgp = 0; 
								$total_crp_s = 0; 
								$total_cra_s = 0; ?>
							</div>
						</li>
					</ul>
					
					<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:inherit; padding:0px; font-weight:bold">
						<div class="ctabletd_1" style="width:277px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">
							Cummulative TCC: <?php echo $total_cr ?>
						</div>
						<div class="ctabletd_1" style="width:277px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
							Cummulative TCE: <?php echo $total_crp ?>
						</div>
						<div class="ctabletd_1" style="width:277px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
							Cummulative GPA: <?php 
							if($total_crp>0 && $orgsetins["cShowgpa"] == '1' && $orgsetins["cShowrslt_for_staff"] == '1')
							{
								$f_grade = round(($cwgp/$total_crp),2);
							} 
								echo $f_grade.' ';
							if ($f_grade >= 4.50)
                            {
                                echo '(1st class)';
                            }else if ($f_grade >= 3.50 && $f_grade <= 4.49)
                            {
                                echo '(2nd class upper)';
                            }else if ($f_grade >= 2.40 && $f_grade <= 3.49)
                            {
                                echo '(2nd class lower)';
                            }else if ($f_grade >= 1.50 && $f_grade <= 2.39)
                            {
                                echo '(3rd class)';
                            }else
                            {
                                echo '(Advised)';
                            }?>
						</div>
					</div>
				</div><?php
			}else if ($_REQUEST['side_menu_no'] == '17')
			{?>
				<div class="innercont_stff" style="margin-bottom:2px; margin-top:6px; font-weight:bold">
					Admission Criteria
				</div>
				<div class="innercont_stff">
					<?php $entlev = ""; 
					echo $_REQUEST['vFacultyDesc'].' :: '. $_REQUEST['vdeptDesc'].' :: '.$_REQUEST['vProgrammeDesc'];
					if ($_REQUEST["courseLevel"] <> "")
					{
						echo " <b>(".$_REQUEST["courseLevel"]." Level)</b>";
						$entlev = " and iBeginLevel = ".$_REQUEST["courseLevel"]." ";
					} ?>
				</div>
				
				<div class="innercont_stff_tabs" id="ans2" style="height:auto; display:block; margin-left:1px; width:auto; padding:0px; border:0px"><?php
					$cnt0 = 0;		
					$stmt = $mysqli->prepare("select sReqmtId, vReqmtDesc, iBeginLevel
					from criteriadetail
					where cCriteriaId = ?".$entlev." order by iBeginLevel desc");
					$stmt->bind_param("s", $_REQUEST["cprogrammeIdold"]);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($sReqmtId, $vReqmtDesc, $iBeginLevel);
			 
			 		while($stmt->fetch())
					{
						$stmt1 = $mysqli->prepare("select a.*
						from criteriaqual a, criteriasubject b
						where b.cCriteriaId = b.cCriteriaId and 
						b.sReqmtId = b.sReqmtId and 
						b.cEduCtgId = b.cEduCtgId and 
						b.cCriteriaId = ? AND
						b.sReqmtId = ".$sReqmtId);
						$stmt1->bind_param("s", $_REQUEST["cprogrammeIdold"]);
						$stmt1->execute();
						$stmt1->store_result();
						
						if ($stmt1->num_rows == 0){$stmt1->close(); continue;}
						$stmt1->close();
						
						$cnt0++;?>
						<div class="innercont_stff" style="font-weight:bold; margin-top:<?php if ($cnt0 == 1){?>2px<?php }else{?>17px<?php }?>; margin-left:15px;">
							<div class="ctabletd_1" style="width:241px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; border-radius:0px;height:15px;padding-top:2px;">
								Description
							</div>
							<div class="ctabletd_1" style="width:569px; text-align:left; margin-left:3px; margin-right:12px;height:15px;padding-top:2px;">
								<?php echo '[SN '.$cnt0.'] '.$vReqmtDesc.' ['.$sReqmtId.']'; //cutlen($vReqmtDesc, 45, '0'); ?>
							</div>
						</div><?php
						$cnt = 0;
						
						$stmt1 = $mysqli->prepare("select a.criteriaqualId, c.vQualCodeDesc, a.cEduCtgId, b.vEduCtgDesc, a.iMaxSittingCount, a.iMinItemCount 
						from criteriaqual a, educationctg b, qualification c 
						where a.cCriteriaId = ? and 
						a.sReqmtId = ".$sReqmtId." and 
						a.cEduCtgId = b.cEduCtgId and
						a.cQualCodeId = c.cQualCodeId");
						$stmt1->bind_param("s", $_REQUEST["cprogrammeIdold"]);
						$stmt1->execute();
						$stmt1->store_result();
						$stmt1->bind_result($criteriaqualId, $vQualCodeDesc, $cEduCtgId, $vEduCtgDesc, $iMaxSittingCount, $iMinItemCount);
						while($stmt1->fetch())
						{
							$cnt++;?>
							<div class="innercont_stff" style="margin-top:<?php if ($cnt == 1){?>5px<?php }else{?>10px<?php }?>; margin-left:15px;">
								<div class="ctabletd_1" style="width:100px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; border-radius:0px;height:15px;padding-top:2px;">
									Qualification
								</div>
								<div class="ctabletd_1" style="width:491px; text-align:left; margin-left:3px; margin-right:12px;height:15px;padding-top:2px;">
									<?php echo $vQualCodeDesc.' ['.$criteriaqualId.']'; //cutlen($vReqmtDesc, 45, '0'); ?>
								</div>
																
								<div class="ctabletd_1" style="width:157px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center;height:15px;padding-top:2px;">Min. Number of Subject(s)</div>
								<div class="ctabletd_1" style="width:40px; text-align:left; margin-left:3px;height:15px;padding-top:2px;">
									<?php echo $iMinItemCount ?>
								</div>
							</div>
							<div class="innercont_stff" style="margin-bottom:1px; margin-left:122px;">
								<div class="ctabletd_1" style="width:20px; background-color:#E2EBE3; border:1px solid #A7BAAD; text-align:right; border-radius: 0px;height:15px;">Sn</div>
								<div class="ctabletd_1" style="width:340px; background-color:#E2EBE3; border:1px solid #A7BAAD; text-align:left;height:15px;">Subject</div>									
								<div class="ctabletd_1" style="width:70px; background-color:#E2EBE3; border:1px solid #A7BAAD; text-align:center;height:15px;">
									Category
								</div>						
								<div class="ctabletd_1" style="width:53px; background-color:#E2EBE3; border:1px solid #A7BAAD; text-align:center;height:15px;">Grade</div>
							</div><?php
							
							$stmt2 = $mysqli->prepare("select q.vQualSubjectDesc, d.cQualGradeCode, c.cMandate
							from qualsubject q, criteriasubject c, qualgrade d
							where q.cQualSubjectId = c.cQualSubjectId and
							d.cQualGradeId = c.cQualGradeId and
							c.cCriteriaId = ? and
							c.sReqmtId = ".$sReqmtId." and
							c.criteriaqualId = ".$criteriaqualId." and
							c.cEduCtgId = '".$cEduCtgId."' order by q.vQualSubjectDesc");
							$stmt2->bind_param("s", $_REQUEST['cprogrammeIdold']);
							$stmt2->execute();
							$stmt2->store_result();
							$stmt2->bind_result($vQualSubjectDesc, $cQualGradeCode, $cMandate);						
							
							$cnt = 0;
							while($stmt2->fetch())
							{?>
								<div class="innercont_stff" style="margin-left:122px; margin-top:0px">
									<div class="ctabletd_1" style="width:20px; border:1px solid #A7BAAD; text-align:right; border-radius: 0px;"><?php echo ++$cnt; ?></div>
									<div class="ctabletd_1" style="width:340px; border:1px solid #A7BAAD; text-align:left; text-indent:2px"><?php echo $vQualSubjectDesc ?></div>									
									<div class="ctabletd_1" style="width:70px; border:1px solid #A7BAAD; text-align:center;">
										<?php echo $cMandate; ?>
									</div>						
									<div class="ctabletd_1" style="width:53px; border:1px solid #A7BAAD; text-align:center;"><?php echo $cQualGradeCode; ?></div>
								</div><?php
							}
							$stmt2->close();
						}
						$stmt1->close();
					}
					$stmt->close();?>
				</div><?php
			}else if ($_REQUEST['side_menu_no'] == '18')
			{?>
				<div class="innercont_stff" style="margin-top:13px; text-align:left; margin-left:3px;">
					<?php echo  '<b>'.$_REQUEST['vFacultyDesc'].'</b>'; ?>
				</div>
				<div class="innercont_stff" style="margin-bottom:2px; text-align:left; margin-left:3px;">
					<?php echo  'List of <b>' . $_REQUEST['prog_cat_desc'].'</b> programmes for which you are qualified:'; ?>
				</div><?php
				if (isset($_REQUEST['returnedStr']) && $_REQUEST['returnedStr'] <> '')
				{?>
					<div class="innercont" style="margin-left:4px; width:602px; border-radius:0px; margin-bottom:3px; padding:0px; background:#CCCCCC">
						<div  class="ctabletd_1" style="width:30px; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Sno</div>
						<div class="ctabletd_1" style="width:135px; background-color:#E3EBE2; border:1px solid #A7BAAD;  text-align:left; text-indent:2px">Programme Code</div>
						<div class="ctabletd_1" style="width:360px; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; text-indent:2px">Programme Title</div>						
						<div class="ctabletd_1" style="width:65px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center;">Entry Level</div>						
					</div><?php 
					$prgc = ''; $cReqmtId = ''; $beginlevel = '';
					$arr_cReqmtId = array();
					$arr_beginlevel = array();
					$ind = -1;
					for ($c = 0; $c <= strlen($_REQUEST['returnedStr'])-1; $c+=9)
					{
						$ind++;
						$prgc .= "'".substr($_REQUEST['returnedStr'],$c,4)."',";
						$arr_beginlevel[$ind] = substr($_REQUEST['returnedStr'],$c+4,3);
						$arr_cReqmtId[$ind] = substr($_REQUEST['returnedStr'],($c+7),2);
					}
					if (substr($prgc,0,strlen($prgc)-1) == ''){$prgc = "''";}else{$prgc = substr($prgc,0,strlen($prgc)-1);}
					
					$stmt = $mysqli->prepare("select p.cProgrammeId,p.vProgrammeDesc,o.vObtQualTitle
					from programme p,obtainablequal o, depts q
					where  p.cObtQualId = o.cObtQualId and
					q.cdeptId = p.cdeptId and
					q.cFacultyId = ? and
					p.cProgrammeId in ($prgc)
					order by p.cProgrammeId");
					$stmt->bind_param("s", $_REQUEST['cFacultyIdold22']);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($cProgrammeId, $vProgrammeDesc, $vObtQualTitle);	
					
					$ind = -1;
					while ($stmt->fetch())
					{
						$ind++;?>
						<div class="innercont" style="margin-left:4px; width:602px; border-radius:0px; padding:0px; margin-top:-1px">
							<div  class="ctabletd_1" 
								style="width:30px; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:right;">
									<?php echo $ind+1 ?>
							</div>
							<div class="ctabletd_1" 
								style="width:135px; border:1px solid #A7BAAD;  text-align:left; text-indent:2px">
									<?php echo $cProgrammeId; ?>
							</div>
							<div class="ctabletd_1" 
								style="width:360px; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:left; text-indent:2px">
									<?php echo $vObtQualTitle.' '.$vProgrammeDesc; ?>
							</div>						
							<div class="ctabletd_1" style="width:65px; border:1px solid #A7BAAD; text-align:center;">
								<?php echo $arr_beginlevel[$ind] ?>
							</div>						
						</div><?php
					}
					$stmt->close();
				}else
				{?>
					<div class="succ_box blink_text orange_msg" id="succ_boxt" style="margin-top:15px; margin-left:94px; display:block">
						No matching qualification found
					</div><?php
				}
			}else if ($_REQUEST['side_menu_no'] == '14')
			{
				$new_curr = '';
				$curr_set = '';
				if (isset($_REQUEST['select_curriculum_prn']))
				{
					if ($_REQUEST['select_curriculum_prn'] == '1')
					{
						$new_curr = " AND c.cAcademicDesc <= 2023";
						$curr_set = '(Old curriculum)';
					}else if ($_REQUEST['select_curriculum_prn'] == '2')
					{
						$new_curr = " AND c.cAcademicDesc = 2024";
						$curr_set = '(New curriculum)';
					}
				}
				$stmt = $mysqli->prepare("select a.cCourseId
				FROM coursereg_arch a
				where a.siLevel = ".$iStudy_level." AND 
				a.cAcademicDesc = '".$orgsetins['cAcademicDesc']."' AND 
				a.tSemester = $tSemester AND 
				a.vMatricNo = ?");
				$stmt->bind_param("s", $_REQUEST['vMatricNo']);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($cCourseId);
								
				$Regcourse = '';
				while($stmt->fetch())
				{
					$Regcourse .= "'".$cCourseId."',";
				}
				$stmt->close();
				$Regcourse = "(".substr($Regcourse,0,strlen($Regcourse)-1).")";?>
				
				<div class="innercont_stff" style="margin-bottom:2px; margin-top:6px; font-weight:bold">My Exam Timetable</div>
				
				<div class="innercont" style="margin-left:3px; border-radius:0px; margin-bottom:3px; padding:0px; width:842px;">
					<div class="ctabletd_1" style="width:20px; height:17px; padding-top:5px; padding-right:3px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Sn</div>
					<div class="ctabletd_1" style="width:66px;height:17px; padding-top:5px; padding-left:2px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Date</div>
					<div class="ctabletd_1" style="width:25px; height:17px; padding-top:5px; padding-right:3px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Day</div>
					<div class="ctabletd_1" style="width:235px; height:17px; padding-top:5px; padding-left:2px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">8am</div>
					<div class="ctabletd_1" style="width:235px; height:17px; padding-top:5px; padding-left:2px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">11am</div>				
					<div class="ctabletd_1" style="width:235px; height:17px; padding-top:5px; padding-left:2px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">2pm</div>				
				</div><?php
				
				$rsday = mysqli_query(link_connect_db(), "select max(iday) a from tt") or die("error: ".mysqli_error(link_connect_db()));
				$sql_day = mysqli_fetch_array($rsday);
				mysqli_close(link_connect_db());?>
				
				<ul id="li1" class="checklist cl1" style="margin-left:3px; width:841px"><?php
					$cnt = 0;
					for ($day = 1; $day <= $sql_day['a']; $day++)
					{
						$rschkCourse = mysqli_query(link_connect_db(), "select cCourseId, FixCourse from tt where iday = $day and cCourseId in $Regcourse") or die("error: ".mysqli_error(link_connect_db()));
						if (mysqli_num_rows($rschkCourse) == 0){continue;}
						$cnt++;
						$chkCourse = mysqli_fetch_array($rschkCourse);?>						
						<li <?php if ($cnt%2 == 0){echo ' class="alt"';}?> style="height:25px; width:844px">
							<div class="ctabletd_1" style="width:20px;height:20px; border:1px solid #A7BAAD; text-align:right; padding-right:3px; border-radius: 0px 0px 0px 0px;"><?php echo $cnt?></div>
							<div class="ctabletd_1" style="width:66px; height:20px; border:1px solid #A7BAAD; padding-left:2px; text-align:left;"><?php echo $chkCourse['FixCourse'];?></div>
							<div class="ctabletd_1" style="width:25px; height:20px; border:1px solid #A7BAAD; padding-right:3px; text-align:right;"><?php echo $day?></div><?php
							for ($ses = 1; $ses <= 3; $ses++)
							{
								$sql = "SELECT concat(a.cCourseId,' ', b.vCourseDesc), b.iCreditUnit, c.cCategory
								FROM tt a, courses b, progcourse c 
								WHERE a.cCourseId = b.cCourseId AND 
								a.cCourseId = c.cCourseId AND 
								iday = $day and cSession = '$ses' and 
								c.cProgrammeId = '$cProgrammeId' and a.cCourseId in $Regcourse
								$new_curr";
								$rschkCourse = mysqli_query(link_connect_db(), $sql) or die("error: ".mysqli_error(link_connect_db()));
								$chkCourse = mysqli_fetch_array($rschkCourse);?>
								<div class="ctabletd_1" style="width:235px; height:20px; border:1px solid #A7BAAD; padding-left:2px; text-align:left;">
									<?php if (isset($chkCourse[0]))
									{
										echo cutlen($chkCourse[0], 35,'0').'['.$chkCourse[1].']'.'['.$chkCourse[2].']';
									}?>
								</div><?php
							}?>
						</li><?php
					}?>
				</ul><?php
			}
		}?>
	</div>
</body>
</html>
