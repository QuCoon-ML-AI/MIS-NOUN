	<?php
	//require_once('./php_qr_code/qrlib.php');

	require_once('../../fsher/fisher.php');
	require_once('const_def.php');
	require_once(BASE_FILE_NAME.'lib_fn.php');
	
	require_once('good_entry.php');

	require_once('std_lib_fn.php');?>
	<!DOCTYPE html>
	<html lang="en">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php
	
	$mysqli = link_connect_db();

	$vMatricNo = '';

	if (isset($_REQUEST['vMatricNo']))
	{
		$vMatricNo = $_REQUEST['vMatricNo'];
	}

	$study_mode_1st = 'odl';


	$stmt = $mysqli->prepare("SELECT cStudyCenterId FROM s_m_t where vMatricNo = ?");
	$stmt->bind_param("s", $vMatricNo);

	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cStudyCenterId);
	$stmt->fetch();
	$stmt->close();
	$orgsetins = settns();

	$sql_sub1 = ''; $sql_sub2 = ''; $sql_sub3 = '';
	if ($orgsetins['studycenter'] == '1')
	{
		$sql_sub1 = ', studycenter f'; $sql_sub2 = 'and a.cStudyCenterId = f.cStudyCenterId'; $sql_sub3 = ', f.vCityName';
	}

	$vApplicationNo = '';
	$vTitle = '';
	$vLastName = '';
	$othernames = '';
	$vFacultyDesc = '';
	$vdeptDesc = '';
	$cProgrammeId = '';
	$vObtQualTitle = '';
	$vProgrammeDesc = '';
	$iStudy_level = '';
	$study_mode = '';
	$vMobileNo = '';
	$vEMailId = '';
	$tSemester = '';
	$vCityName = '';
	$cEduCtgId = '';


	if ($vMatricNo <> '')
	{
		$stmt = $mysqli->prepare("select vApplicationNo, vTitle, vLastName, concat(vFirstName,' ',vOtherName) othernames, b.vFacultyDesc, c.vdeptDesc,a.cProgrammeId, d.vObtQualTitle, e.vProgrammeDesc, a.iStudy_level, a.vMobileNo, a.vEMailId, a.tSemester, f.vCityName, e.cEduCtgId
		from s_m_t a, faculty b, depts c, obtainablequal d, programme e, studycenter f
		where a.cFacultyId = b.cFacultyId
		and a.cdeptId = c.cdeptId
		and a.cObtQualId = d.cObtQualId
		and a.cProgrammeId = e.cProgrammeId 
		and a.cStudyCenterId = f.cStudyCenterId
		and a.vMatricNo = ?");
		$stmt->bind_param("s", $vMatricNo);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($vApplicationNo, $vTitle, $vLastName, $othernames, $vFacultyDesc, $vdeptDesc, $cProgrammeId, $vObtQualTitle, $vProgrammeDesc, $iStudy_level, $vMobileNo, $vEMailId, $tSemester, $vCityName, $cEduCtgId);
		$stmt->fetch();
		$stmt->close();
	}?>

	<title>NOUN-SMS</title>
	<link rel="icon" type="image/ico" href="../appl/img/left_side_logo.png" />
	<script language="JavaScript" type="text/javascript" src="../appl/js_file_1.js"></script>
	<link rel="stylesheet" type="text/css" media="all" href="../appl/styless.css" />
	<noscript>Please, enable JavaScript on your browser</noscript>
	<script language="JavaScript" type="text/javascript">
	document.onkeydown = function (e) 
	{
		if (e.ctrlKey && e.keyCode === 85) 
		{
            return false;
        }
	}
</script>

	</head>

	<body onload="/*window.print();checkConnection()*/">
		<div id="container_cover_constat" style="display:none"></div>
		<div id="container_cover_in_constat" class="center" style="display:none; position:fixed;">
			<div id="div_header_main" class="innercont_stff" 
				style="float:left;
				width:99.5%;
				height:auto;
				padding:0px;
				padding-top:3px;
				padding-bottom:4px;
				border-bottom:1px solid #545454;">
				<div id="div_header_constat" class="innercont_stff" style="float:left; color:#FF3300;">
					Internet Connection Status
				</div>
			</div>
			
			<div id="div_message_constat" class="innercont_stff" style="margin-top:40px; float:left; width:413px; height:auto; color:#FF3300;">
				You are not connected
			</div>
		</div>
		<div id="container" 
			style="color:#000000;
			margin:auto;
			margin-top:30px; 
			height:195px;  
			width:370px;
			border:1.5px solid #b6b6b6;  
			padding:6px; 
			box-shadow:0px 0px 0px 0px; 
			position: relative;
			background-image: url('<?php echo BASE_FILE_NAME_FOR_IMG;?>p_op3.png');
			background-repeat: repeat;
			background-size: 50px 50px;
			background-position: 37px 45px;
			font-family:Arial, Helvetica, Verdana, sans-serif;
    		font-size: 0.8em;
			line-height:1.5">
				<div style="float:left; 
					width:100%; 
					height:25%; 
					background-color:#FFFFFF; 
					opacity:0.9">
					<div style="float:left; 
						width:10%; 
						height:100%; 
						margin-right:0.5%;">
						<img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" style="height:100%; width:100%"/>
					</div>

					<div style="float:left; 
						width:79%; 
						height:100%; 
						margin-right:0.5%;">
						<div style="float:left; 
							width:100%; 
							padding-top:0%; 
							padding-bottom:0.2%; 
							text-align:center; 
							font-weight:bold; 
							font-size:11px;">
							<?php echo strtoupper($orgsetins['vOrgName']);?>
						</div>
						<div style="float:left; 
							width:100%; 
							padding:0%;
							text-align:center; 
							font-size:8px;">
							University Village, Plot 91, Cadastral Zone, Nnamdi Azikiwe Expressway, Jabi, Abuja, Nigeria
						</div>
						<div style="float:left; 
							width:100%;
							padding:0%;
							text-align:center; 
							font-size:8px; line-height:normal;">
							<?php echo ucwords(strtolower($vCityName));?> Centre
						</div>
					</div>

					<div style="float:left; 
						width:10%; 
						height:100%;">
						<img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" style="height:100%; width:100%"/>
					</div>
				</div>

				
				<div style="float:left; 
					width:100%; 
					height:65%;
					background-color:#FFFFFF;
					opacity:0.9">
					<div style="float:left; 
						width:79%; 
						height:100%;
						margin-right:0.5%;">
						<div style="float:left; 
							width:20%; 
							padding:0%; 
							padding-top:1.5%;
							border-bottom:1px dashed #545454;margin-top:-1px">
							Name
						</div>						
						<div style="float:left; 
							width:80%; 
							padding:0%; 
							padding-top:1.5%;
							border-bottom:1px dashed #545454;
							font-weight:bold;margin-top:-1px">
								<?php echo clean_string_as($vLastName, 'names').' '.clean_string_as($othernames, 'names');?>
						</div>
						
						<div style="float:left; 
							width:20%; 
							padding:0%; 
							padding-top:1.5%;
							border-bottom:1px dashed #545454;margin-top:-1px">
							Mat. no.
						</div>						
						<div style="float:left; 
							width:80%; 
							padding:0%; 
							padding-top:1.5%;
							border-bottom:1px dashed #545454;
							font-weight:bold;margin-top:-1px">
								<?php echo $vMatricNo;?>
						</div>
						
						<div style="float:left; 
							width:20%; 
							padding:0%; 
							padding-top:1.5%;
							border-bottom:1px dashed #545454;margin-top:-1px">
							Faculty
						</div>
						<div style="float:left; 
							width:80%; 
							padding:0%; 
							padding-top:1.5%;
							border-bottom:1px dashed #545454;
							font-weight:bold;margin-top:-1px">
								<?php echo $vFacultyDesc;?>
						</div>
						
						<div style="float:left; 
							width:20%; 
							padding:0%; 
							padding-top:1.5%;
							border-bottom:1px dashed #545454;margin-top:-1px">
							Dept.
						</div>						
						<div style="float:left; 
							width:80%; 
							padding:0%; 
							padding-top:1.5%;
							border-bottom:1px dashed #545454;
							font-weight:bold;margin-top:-1px">
								<?php echo $vdeptDesc;?>
						</div>
						
						<div style="float:left; 
							width:20%; 
							padding:0%; 
							padding-top:1.5%;
							border-bottom:1px dashed #545454;margin-top:-1px">
							Prog.
						</div>						
						<div style="float:left; 
							width:80%; 
							padding:0%; 
							padding-top:1.5%;
							border-bottom:1px dashed #545454;
							font-weight:bold;margin-top:-1px">
								<?php echo $vObtQualTitle.' '.$vProgrammeDesc;?>
						</div>
						
						<div style="float:left; 
							width:20%; 
							padding:0%; 
							padding-top:1.5%;
							border-bottom:1px dashed #545454;margin-top:-1px">
							Session
						</div>						
						<div style="float:left; 
							width:80%; 
							padding:0%; 
							padding-top:1.5%;
							border-bottom:1px dashed #545454;
							font-weight:bold;margin-top:-1px">
								<?php echo substr($orgsetins['cAcademicDesc'], 0, 4);?>
						</div>
					</div>

					<div style="float:left; 
						width:20%;
						height:90%;">
						<img src="<?php echo get_pp_pix('');?>" style="height:100%; width:100%;"/>
					</div>
				</div>

				<div style="float:left; 
					width:100%; 
					height:9%;
					margin-top:0.5%;
					background-color:#FFFFFF;
					opacity:0.9;
					text-align:center;
					opacity:0.9;">
					Signature
				</div>
		</div>


		<div id="container" 
			style="color:#000000;
			margin:auto;
			margin-top:30px; 
			height:195px;  
			width:370px;
			border:1.5px solid #b6b6b6; 
			padding:6px; 
			box-shadow:0px 0px 0px 0px; 
			position: relative;
			background-image: url('<?php echo BASE_FILE_NAME_FOR_IMG;?>p_op3.png');
			background-repeat: repeat;
			background-size: 50px 50px;
			background-position: 37px 45px;
			font-family:Arial, Helvetica, Verdana, sans-serif;
    		font-size: 0.9em;
			line-height:1.5">
				<div style="float:left; 
					width:100%; 
					height:59%; 
					background-color:#FFF; 
					opacity:0.9;
					text-align:center;
					line-height:1.5;
					pading-top:15px; ">
					I certify that the bearer whose photograph appears<br>
					overleaf is a student of this Study Centre.<br>
					The loss/recovery of this card should be reported<br> 
					to the office of the undersigned.<br>
					This card remains the property of the University and must be<br>
					surrendered on request to the Registrar of the University.
				</div>

				
				<div style="float:left; 
					width:100%; 
					height:34%;
					margin-top:0px;
					background-color:#FFF;
					opacity:0.9">
					<!-- <div style="float:left; 
						width:59%; 
						height:100%;
						margin-right:0.5%;"><?php
							$frm_link	=	$vMatricNo.'; '.$vLastName.', '.$othernames.'; '.$vFacultyDesc.'; '.$vdeptDesc.'; '.$orgsetins['cAcademicDesc'].'; '.$study_mode_1st;?>
							<img src="<?php //echo bar_codde($frm_link, $vMatricNo); ?>" style="height:100%; width:37%" />
					</div> -->
					
					<div style="float:left; 
						width:100%;
						height:87%;
						text-align:center;
						padding-top:3%">
						<img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'reg_sig.png');?>" style="height:60%; width:40%;"/><br>Registrar's signature
					</div>
				</div>
		</div>
	</body>
	</html>