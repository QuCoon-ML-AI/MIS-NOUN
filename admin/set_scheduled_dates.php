<?php 
	date_default_timezone_set('Africa/Lagos');

	$currentDate = date('Y-m-d');
	
	$account_close_date = substr($orgsetins['ac_close_date'],4,4).'-'.substr($orgsetins['ac_close_date'],2,2).'-'.substr($orgsetins['ac_close_date'],0,2);
	$account_open_date = substr($orgsetins['ac_open_date'],4,4).'-'.substr($orgsetins['ac_open_date'],2,2).'-'.substr($orgsetins['ac_open_date'],0,2);
	$books_ready =  ($currentDate <= $account_close_date || $currentDate >= $account_open_date);
		
	$set_date = substr($orgsetins['sesdate0'],4,4).'-'.substr($orgsetins['sesdate0'],2,2).'-'.substr($orgsetins['sesdate0'],0,2);
	$session_begin = ($currentDate >= $set_date);	
	$set_date = substr($orgsetins['sesdate1'],4,4).'-'.substr($orgsetins['sesdate1'],2,2).'-'.substr($orgsetins['sesdate1'],0,2);
	$session_end = $currentDate >= $set_date;	
	$session_open = $session_begin == 1 && $session_end == 0;

	$semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);
	
	$set_date = substr($orgsetins['semdate1'],4,4).'-'.substr($orgsetins['semdate1'],2,2).'-'.substr($orgsetins['semdate1'],0,2);
	$semester_begin = $currentDate >= $set_date;
	$set_date = substr($orgsetins['semdate2'],4,4).'-'.substr($orgsetins['semdate2'],2,2).'-'.substr($orgsetins['semdate2'],0,2);
	$semester_end = $currentDate >= $set_date;
	$semester_open = $semester_begin == 1 && $semester_end == 0;

	$set_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);
	$reg_begin = $currentDate >= $set_date;


	$set_date = substr($orgsetins['regdate_100_200_2'],4,4).'-'.substr($orgsetins['regdate_100_200_2'],2,2).'-'.substr($orgsetins['regdate_100_200_2'],0,2);
	$reg_end = $currentDate >= $set_date;
	$reg_open_100_200 = $reg_begin == 1 && $reg_end == 0;
	
	$set_date = substr($orgsetins['regdate_300_2'],4,4).'-'.substr($orgsetins['regdate_300_2'],2,2).'-'.substr($orgsetins['regdate_300_2'],0,2);
	$reg_end = $currentDate >= $set_date;
	$reg_open_300 = $reg_begin == 1 && $reg_end == 0;

	
	$set_date = substr($orgsetins['examregdate1'],4,4).'-'.substr($orgsetins['examregdate1'],2,2).'-'.substr($orgsetins['examregdate1'],0,2);
	$exam_reg_begin = $currentDate >= $set_date;


	$set_date = substr($orgsetins['examregdate_100_200_2'],4,4).'-'.substr($orgsetins['examregdate_100_200_2'],2,2).'-'.substr($orgsetins['examregdate_100_200_2'],0,2);
	$exam_reg_end = $currentDate >= $set_date;
	$exam_reg_open_100_200 = $exam_reg_begin == 1 && $exam_reg_end == 0;
	
	$set_date = substr($orgsetins['examregdate_300_2'],4,4).'-'.substr($orgsetins['examregdate_300_2'],2,2).'-'.substr($orgsetins['examregdate_300_2'],0,2);
	$exam_reg_end = $currentDate >= $set_date;
	$exam_reg_open_300 = $exam_reg_begin == 1 && $exam_reg_end == 0;

	//$RegEndDate = substr($orgsetins['regdate2'],4,4).'-'.substr($orgsetins['regdate2'],2,2).'-'.substr($orgsetins['regdate2'],0,2);

	$set_date = substr($orgsetins['tmadate1'],4,4).'-'.substr($orgsetins['tmadate1'],2,2).'-'.substr($orgsetins['tmadate1'],0,2);
	if ($currentDate >= $set_date){$TmaBegin = 1;}else{$TmaBegin = 0;}
	
	$set_date = substr($orgsetins['tmadate2'],4,4).'-'.substr($orgsetins['tmadate2'],2,2).'-'.substr($orgsetins['tmadate2'],0,2);
	if ($currentDate < $set_date){$tma_not_close = 1;}else{$tma_not_close = 0;}
	if (($TmaBegin == 1 && $tma_not_close == 1) || $orgsetins['force_session_open'] == '1'){$tma_open = 1;}else{$tma_open = 0;}

	$iextend_exam = ''; $iextend_reg = ''; $iextend_tma = '';
	
	/*$rsextDate_reg = mysqli_query(link_connect_db(), "select curdate() > ADDDATE('$RegEndDate', INTERVAL iextend_reg DAY) FROM settns")or die("error: ".mysqli_error(link_connect_db()));
	$arr_extDate_reg = mysqli_fetch_array($rsextDate_reg);
	$iextend_reg = $arr_extDate_reg[0];

	$rsextDate_tma = mysqli_query(link_connect_db(), "select curdate() > ADDDATE('$RegEndDate', INTERVAL iextend_tma DAY) FROM settns")or die("error: ".mysqli_error(link_connect_db()));
	$arr_extDate_tma = mysqli_fetch_array($rsextDate_tma);
	$iextend_tma = $arr_extDate_tma[0];

	$rsextDate_exam = mysqli_query(link_connect_db(), "select curdate() > ADDDATE('$RegEndDate', INTERVAL iextend_exam DAY) FROM settns")or die("error: ".mysqli_error(link_connect_db()));
	$arr_extDate_exam = mysqli_fetch_array($rsextDate_exam);
	$iextend_exam = $arr_extDate_exam[0];*/?>