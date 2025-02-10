<?php	
	$vApplicationNo = '';
		
	$cFacultyId = '';
	$cdept = '';
	$vdeptDesc = '';
	$vFacultyDesc= '';
	$cEduCtgId = '';
	$cEduCtgId_selected_qual = '';

	$cEduCtgId_1 = '';
	$cEduCtgId_2 = '';

	$cQualCodeId = '';
	$vQualCodeDesc = '';
	
	$vEduCtgDesc = '';
	$vApplicationNo = '';
	$vObtQualTitle = '';
	$cProgrammeId = '';
	$vProgrammeDesc = '';
	$begin_level = '';
	$prog_cat = '';
	
	$tSemester = '';
	$student_user_num = '';
	
	$cCourseCode = '';
	$cCourseCodeDesc = '';
	
	$user_cat = '';
	$ilin = '';
	$mm = '';
	$sm = '';
	$m = '';
		
	$sReqmtId = '';
	$vReqmtDesc = '';
	$cAcademicDesc = '';
	$iBeginLevel = '';
	$dtStatusDate = '';
	$dtCreateDate = '';
	
	$iMaxSittingCount = '';
	$iMinItemCount = '';
	$iQSLCount = '';
	
	$as = ''; 
	$es = ''; 
	$ds = ''; 
	$das = ''; 
	
	$aq = '';
	$eq = '';
	$dq = '';
	
	$ac = '';
	$ec = '';
	$dc = '';
	
	$dis = '';
	$en = '';
	
	$m = '';
	$sm = '';
	
	
	$sbjlist = '';
	$conf = '';
	
	$msg = '';
	$err_num = 0;
	
	
	$ctn_consumd = '';
	$admt = '';


	$vTitle = '';
	$vLastName = '';
	$vFirstName = '';
	$vOtherName = '';
	
	$vFacultyDesc = '';
	$vdeptDesc = '';
	$cProgrammeId = '';
	$vObtQualTitle = '';
	$vProgrammeDesc = '';
	
	$iStudy_level = '';
	$tSemester = '';
	$col_gown = '';
	$ret_gown = ''; 
	$vCityName = '';

	$side_menu_no = '';
	$criteriaqualId = '';

	$numOfiputTag = 0;

	$orgsetins = settns();
	
	$semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);
	
	$account_close_date = substr($orgsetins['ac_close_date'],4,4).'-'.substr($orgsetins['ac_close_date'],2,2).'-'.substr($orgsetins['ac_close_date'],0,2);
	$account_open_date = substr($orgsetins['ac_open_date'],4,4).'-'.substr($orgsetins['ac_open_date'],2,2).'-'.substr($orgsetins['ac_open_date'],0,2);

	$wrking_tab = 's_tranxion_20242025';
	$wrking_crsreg_tab = 'coursereg_arch_20242025';
	$wrking_examreg_tab = 'examreg_20242025';
	
	
	if (isset($_REQUEST['vApplicationNo'])){$vApplicationNo = $_REQUEST['vApplicationNo'];}
	if (isset($_REQUEST['ilin'])){$ilin = $_REQUEST['ilin'];}
	if (isset($_REQUEST['user_cat'])){$user_cat = $_REQUEST['user_cat'];}
	
	if (isset($_REQUEST['cFacultyId'])){$cFacultyId = $_REQUEST['cFacultyId'];} 
	if (isset($_REQUEST['cFacultyId1'])){$cFacultyId = $_REQUEST['cFacultyId1'];}
	if (isset($_REQUEST['vFacultyDesc'])){$vFacultyDesc = $_REQUEST['vFacultyDesc'];}
	if (isset($_REQUEST['cdept'])){$cdept = $_REQUEST['cdept'];}
	if (isset($_REQUEST['cdept1'])){$cdept = $_REQUEST['cdept1'];}
	if (isset($_REQUEST['vdeptDesc'])){$vdeptDesc = $_REQUEST['vdeptDesc'];}
	
	if (isset($_REQUEST['cQualCodeId'])){$cQualCodeId = $_REQUEST['cQualCodeId'];}
	if (isset($_REQUEST['cQualCodeId1'])){$cQualCodeId = $_REQUEST['cQualCodeId1'];}
	if (isset($_REQUEST['vQualCodeDesc'])){$vQualCodeDesc = $_REQUEST['vQualCodeDesc'];}
	
	if (isset($_REQUEST['cEduCtgId'])){$cEduCtgId = $_REQUEST['cEduCtgId'];}
	if (isset($_REQUEST['cEduCtgId1'])){$cEduCtgId = $_REQUEST['cEduCtgId1'];}
	
	if (isset($_REQUEST['cEduCtgId_1'])){$cEduCtgId_1 = $_REQUEST['cEduCtgId_1'];}
	if (isset($_REQUEST['cEduCtgId_2'])){$cEduCtgId_2 = $_REQUEST['cEduCtgId_2'];}

	if (isset($_REQUEST['cEduCtgId_selected_qual'])){$cEduCtgId_selected_qual = $_REQUEST['cEduCtgId_selected_qual'];}

	if (isset($_REQUEST['prog_cat'])){$prog_cat = $_REQUEST['prog_cat'];}
	if (isset($_REQUEST['prog_cat1'])){$prog_cat = $_REQUEST['prog_cat1'];}
	
	if (isset($_REQUEST['vEduCtgDesc'])){$vEduCtgDesc = $_REQUEST['vEduCtgDesc'];}
	
	if (isset($_REQUEST['vObtQualTitle'])){$vObtQualTitle = $_REQUEST['vObtQualTitle'];}
	if (isset($_REQUEST['cProgrammeId'])){$cProgrammeId = $_REQUEST['cProgrammeId'];}
	if (isset($_REQUEST['vProgrammeDesc'])){$vProgrammeDesc = $_REQUEST['vProgrammeDesc'];}
	
	if (isset($_REQUEST['begin_level'])){$begin_level = $_REQUEST['begin_level'];}
	
	
	if (isset($_REQUEST['cCourseCode'])){$cCourseCode = $_REQUEST['cCourseCode'];}
	if (isset($_REQUEST['cCourseCodeDesc'])){$cCourseCodeDesc = $_REQUEST['cCourseCodeDesc'];}
	
	if (isset($_REQUEST['sm'])){$sm = $_REQUEST['sm']; $side_menu_no = $_REQUEST['sm'];}
	if (isset($_REQUEST['mm'])){$mm = $_REQUEST['mm'];}
	if (isset($_REQUEST['m'])){$m = $_REQUEST['m'];}
			
	if (isset($_REQUEST['vReqmtDesc'])){$vReqmtDesc = ucwords(trim($_REQUEST['vReqmtDesc']));}
	if (isset($_REQUEST['vReqmtDesc1'])){$vReqmtDesc = ucwords(trim($_REQUEST['vReqmtDesc1']));}
	
	if (isset($_REQUEST['sReqmtId'])){$sReqmtId = $_REQUEST['sReqmtId'];}
	if (isset($_REQUEST['sReqmtId1'])){$sReqmtId = $_REQUEST['sReqmtId1'];}
		
	if (isset($_REQUEST['iBeginLevel'])){$iBeginLevel = $_REQUEST['iBeginLevel'];}
	if (isset($_REQUEST['iBeginLevel1'])){$iBeginLevel = $_REQUEST['iBeginLevel1'];}
	
	if (isset($_REQUEST['cAcademicDesc'])){$cAcademicDesc = $_REQUEST['cAcademicDesc'];}
	
	if (isset($_REQUEST['dtStatusDate'])){$dtStatusDate = $_REQUEST['dtStatusDate'];}
	if (isset($_REQUEST['dtCreateDate'])){$dtCreateDate = $_REQUEST['dtCreateDate'];}
	
	if (isset($_REQUEST['as'])){$as = $_REQUEST['as'];}
	if (isset($_REQUEST['es'])){$es = $_REQUEST['es'];}
	if (isset($_REQUEST['ds'])){$ds = $_REQUEST['ds'];}
	if (isset($_REQUEST['das'])){$das = $_REQUEST['das'];}
	
	if (isset($_REQUEST['aq'])){$aq = $_REQUEST['aq'];}
	if (isset($_REQUEST['eq'])){$eq = $_REQUEST['eq'];}
	if (isset($_REQUEST['dq'])){$dq = $_REQUEST['dq'];}
	if (isset($_REQUEST['dc'])){$dc = $_REQUEST['dc'];}
	
	if (isset($_REQUEST['ac'])){$ac = $_REQUEST['ac'];}
	if (isset($_REQUEST['ec'])){$ec = $_REQUEST['ec'];}
	
	if (isset($_REQUEST['dis'])){$dis = $_REQUEST['dis'];}
	if (isset($_REQUEST['en'])){$en = $_REQUEST['en'];}

	
	if (isset($_REQUEST['criteriaqualId'])){$criteriaqualId = $_REQUEST['criteriaqualId'];}
	
	if (isset($_REQUEST['iMaxSittingCount'])){$iMaxSittingCount = $_REQUEST['iMaxSittingCount'];}
	if (isset($_REQUEST['iMaxSittingCount1'])){$iMaxSittingCount = $_REQUEST['iMaxSittingCount1'];}
	
	if (isset($_REQUEST['iMinItemCount'])){$iMinItemCount = $_REQUEST['iMinItemCount'];}
	if (isset($_REQUEST['iMinItemCount1'])){$iMinItemCount = $_REQUEST['iMinItemCount1'];}
	
	if (isset($_REQUEST['iQSLCount'])){$iQSLCount = $_REQUEST['iQSLCount'];}

	if (isset($_REQUEST['ctn_consumd'])){$ctn_consumd = $_REQUEST['ctn_consumd'];}
	
	if (isset($_REQUEST['sbjlist'])){$sbjlist = $_REQUEST['sbjlist'];}
	if (isset($_REQUEST['conf'])){$conf = $_REQUEST['conf'];}
	
	if (isset($_REQUEST['admt'])){if ($_REQUEST['admt'] == '0'){$admt = "a.cSbmtd = '0' and b.vProcessNote <> ''";}else{$admt = "(a.cSbmtd = '1' or a.cSbmtd = '2')";}}?>
