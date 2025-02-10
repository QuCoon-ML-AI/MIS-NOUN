<?php

date_default_timezone_set('Africa/Lagos');

function submit_acord()
{
    if (isset($_REQUEST['top_menu_no']))
    {
        $sub_url_str = "std_sections.target='_self';
		std_sections.side_menu_no.value='".$_REQUEST['side_menu_no']."';
		in_progress('1');
		std_sections.submit()";
		
		if ($_REQUEST['top_menu_no'] == '1')//orient
        {
            if ($_REQUEST['side_menu_no'] == '1')
            {
               // return "form_ewallet.side_menu_no.value='1';form_ewallet.submit()";
            }
        }else if ($_REQUEST['top_menu_no'] == '2')//dept
        {

        }else if ($_REQUEST['top_menu_no'] == '3')//burs
        {
            if ($_REQUEST['side_menu_no'] == 'list_transactions')//list
            {
                return "std_sections.action='account-statement';
				$sub_url_str";
            }else if ($_REQUEST['side_menu_no'] == 'make_payment')//make pay
            {
                return "std_sections.action='make-payment';
				$sub_url_str";
            }else if ($_REQUEST['side_menu_no'] == 'check_payment_status')//chk pay
            {
                return "$sub_url_str";
            }else if ($_REQUEST['side_menu_no'] == 'my_bank_detail')//bank detail
            {
                return "$sub_url_str";
            }else if ($_REQUEST['side_menu_no'] == 'final_year_clearance')//fy clr
            {
                return "$sub_url_str";
            }
        }else if ($_REQUEST['top_menu_no'] == '4')//Reg
        {
			if ($_REQUEST['side_menu_no'] == 'change_password')//cpw
            {
                return "std_sections.action='change_password'; 
				$sub_url_str";
            }else if ($_REQUEST['side_menu_no'] == 'change_password')//cpw
            {
                return "std_sections.action='change_password'; 
				$sub_url_str";
            }else if ($_REQUEST['side_menu_no'] == 'see_application_record')//c app rec
            {
                return "std_sections.action='see_application_record';
				$sub_url_str";
            }else if ($_REQUEST['side_menu_no'] == 'update_bio_data')//upd biodata
            {
                return "std_sections.action='update_bio_data';
				$sub_url_str";
            }else if ($_REQUEST['side_menu_no'] == 'print_identity_card')//upd biodata
            {
                return "std_sections.action='print_identity_card'; 
				$sub_url_str";
            }else if ($_REQUEST['side_menu_no'] == 'change_of_name')//
            {
                return "std_sections.action='students_requests';
				$sub_url_str";
            }else if ($_REQUEST['side_menu_no'] == 'change_of_level')//
            {
                return "std_sections.action='students_requests';
				$sub_url_str";
            }else if ($_REQUEST['side_menu_no'] == 'change_of_programme')//
            {
                return "std_sections.action='students_requests';
				$sub_url_str";
            }else if ($_REQUEST['side_menu_no'] == 'change_of_study_centre')//
            {
                return "std_sections.action='students_requests';
				$sub_url_str";
            }else if ($_REQUEST['side_menu_no'] == 'passport_upload')//
            {
                return "std_sections.action='students_requests';
				$sub_url_str";
            }else if ($_REQUEST['side_menu_no'] == 'transcript')//
            {
                return "std_sections.action='students_requests';
				$sub_url_str";
            }
        }else if ($_REQUEST['top_menu_no'] == '5')//My courses
        {
			return "$sub_url_str";
			// if ($_REQUEST['side_menu_no'] == 'register_courses')
            // {
            //     return "$sub_url_str";
            // }else if ($_REQUEST['side_menu_no'] == 'see_course_registration_slip')
            // {
            //     return "$sub_url_str";
            // }else if ($_REQUEST['side_menu_no'] == 'see_all_registered_courses')
            // {
            //     return "$sub_url_str";
            // }elseif ($_REQUEST['side_menu_no'] == 'register_courses_for_exam')
            // {
            //     return "$sub_url_str";
            // }elseif ($_REQUEST['side_menu_no'] == 'see_exam_registration_slip')
            // {
            //     return "$sub_url_str";
            // }else if ($_REQUEST['side_menu_no'] == 'see_all_registered_exams')
            // {
            //     return "$sub_url_str";
            // }
        }else if ($_REQUEST['top_menu_no'] == '6')
        {

        }else if ($_REQUEST['top_menu_no'] == '7')
        {

        }else if ($_REQUEST['top_menu_no'] == '8')
        {
			return "$sub_url_str";
        }else if ($_REQUEST['top_menu_no'] == '9')
        {
        }else if ($_REQUEST['top_menu_no'] == '10')
        {

        }else if ($_REQUEST['top_menu_no'] == '11')
        {

        }else if ($_REQUEST['top_menu_no'] == '12')
        {

        }
    }
    return 'std_sections.submit()';
}


function std_top_menu()
{?>
	<div class="data_line data_line_logout std_menu_cls" style="display:flex; padding:0px; width:98.7%; height:auto; margin-top:5px; justify-content:space-between;">
		<div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
			<button type="button" class="button" style="padding:7px; border:0px solid #b6b6b6;" 
				onclick="lib_js('','','_self','welcome_student');">
				<img width="25" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'home.png');?>" alt="Home">
				<br>Home</button>
		</div>

		<div class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
			<button type="button" class="button" style="padding:7px; border:0px solid #b6b6b6;" 
			onclick="if (std_sections.target=='_blank'){lib_js('','','_self','welcome_student');}<?php echo submit_acord(); ?>; return false">
			<img width="20" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'refresh.png');?>" alt="How to do things">
			<br>Refresh</button>
		</div>

		<div class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
			<button type="button" class="button" style="padding:7px; border:0px solid #b6b6b6;" 
			onclick="mail_account.submit(); return false">
			<img width="22" height="15" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'envelope-line1.png');?>" alt="How to do things">
			<br>Mail</button>
		</div>

		<div class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
			<button type="button" class="button" style="padding:7px; border:0px solid #b6b6b6;" 
			onclick="guides_instructions.submit(); return false">
			<img width="20" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'support.png');?>" alt="How to do things">
			<br>Help</button>
		</div>

		<div class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
			<button type="button" class="button" style="padding:7px; border:0px solid #b6b6b6;" 
			onclick="lib_js('','','_self','student_login_page');">
			<img width="20" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'logout.png');?>" alt="Logout">
			<br>Logout</button>
		</div>
	</div><?php
}


function std_top_samll_menu()
{?>
	<div class="data_line data_line_logout std_menu_cls" style="display:flex; padding:0px; width:98.7%; height:auto; margin-top:5px; justify-content:space-between;">
		<div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
			<button type="button" class="button" style="padding:7px; border:0px solid #b6b6b6;" 
				onclick="lib_js('0','','_self','welcome_student');">
				<img width="22" height="20" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'mobile_menu.png');?>" alt="Home">
				<br>Menu</button>
		</div>

		<div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
			<button type="button" class="button" style="padding:7px; border:0px solid #b6b6b6;" 
				onclick="lib_js('','','_self','welcome_student');">
				<img width="25" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'home.png');?>" alt="Home">
				<br>Home</button>
		</div>

		<div class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
			<button type="button" class="button" style="padding:7px; border:0px solid #b6b6b6;" 
			onclick="if (std_sections.target=='_blank'){lib_js('','','_self','welcome_student');}<?php echo submit_acord(); ?>; return false">
			<img width="20" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'refresh.png');?>" alt="How to do things">
			<br>Refresh</button>
		</div>

		<div class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
			<button type="button" class="button" style="padding:7px; border:0px solid #b6b6b6;" 
			onclick="mail_account.submit(); return false">
			<img width="22" height="15" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'envelope-line1.png');?>" alt="How to do things">
			<br>Mail</button>
		</div>

		<div class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
			<button type="button" class="button" style="padding:7px; border:0px solid #b6b6b6;" 
			onclick="guides_instructions.submit(); return false">
			<img width="20" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'support.png');?>" alt="How to do things">
			<br>Help</button>
		</div>

		<div class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
			<button type="button" class="button" style="padding:7px; border:0px solid #b6b6b6;" 
			onclick="lib_js('','','_self','student_login_page');">
			<img width="20" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'logout.png');?>" alt="Logout">
			<br>Logout</button>
		</div>
	</div><?php
}


function side_detail($id_val)
{
	$mysqli = link_connect_db();

	$orgsetins = settns();

	$stmt = $mysqli->prepare("select * from afnmatric a inner join s_m_t b using(vMatricNo) where a.vApplicationNo = ? OR a.vMatricNo = ?");
	$stmt->bind_param("ss", $id_val, $id_val);
	$stmt->execute();
	$stmt->store_result();
		
	$has_matno = $stmt->num_rows;

	$vApplicationNo = '';
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
	$cEduCtgId = '';
	$tSemester = '';
	$col_gown = '';
	$ret_gown = '';
	$vCityName = '';

	if ($has_matno > 0)
	{
		$stmt = $mysqli->prepare("select a.vApplicationNo, vTitle, vLastName, vFirstName, vOtherName, b.vFacultyDesc, c.vdeptDesc, a.cProgrammeId, d.vObtQualTitle, e.vProgrammeDesc, a.iStudy_level, e.cEduCtgId, a.tSemester, a.col_gown, a.ret_gown , f.vCityName
		from s_m_t a, faculty b, depts c, obtainablequal d, programme e, studycenter f, afnmatric g
		where a.cFacultyId = b.cFacultyId
		and a.cdeptId = c.cdeptId
		and a.cObtQualId = d.cObtQualId
		and a.cProgrammeId = e.cProgrammeId
		and a.cStudyCenterId = f.cStudyCenterId
		and g.vMatricNo = a.vMatricNo
		and (g.vMatricNo = ? or
		g.vApplicationNo = ?)");
		$stmt->bind_param("ss", $id_val, $id_val);
		$stmt->execute();
		$stmt->store_result();
		
		$stmt->bind_result($vApplicationNo, $vTitle, $vLastName, $vFirstName, $vOtherName, $vFacultyDesc, $vdeptDesc, $cProgrammeId, $vObtQualTitle, $vProgrammeDesc, $iStudy_level, $cEduCtgId, $tSemester, $col_gown, $ret_gown, $vCityName);	
	}
	$stmt->fetch();
	$stmt->close();

	if (is_null($vLastName))
	{
		$vLastName = '';
	}
	$vLastName = clean_string_as($vLastName, 'names');

	// if ($vLastName <> '')
	// {
	// 	$vLastName = strtoupper(stripslasshes($vLastName));
	// }

	
	if (is_null($vFirstName))
	{
		$vFirstName = '';
	}
	$vFirstName = clean_string_as($vFirstName, 'names');
	
	// if ($vFirstName <> '')
	// {
	// 	$vFirstName = ucwords(strtoupper(stripslasshes($vFirstName)));
	// }
	
	
	if (is_null($vOtherName))
	{
		$vOtherName = '';
	}
	$vOtherName = clean_string_as($vOtherName, 'names');
	
	// if ($vOtherName <> '')
	// {
	// 	$vOtherName = ucwords(strtoupper(stripslasshes($vOtherName)));
	// }?>

	<div id="std_names" class="appl_left_child_btn_div" style="padding:20px 0px 20px 0px; border-bottom:1px dashed #ccc; line-height:1.6">
		<?php echo $vApplicationNo.'<br>'.$vLastName.'<br>'.$vFirstName.' '.$vOtherName;?>
	</div>
	<div id="std_sems" class="appl_left_child_btn_div" style=" padding:20px 0px 20px 0px; border-bottom:1px dashed #ccc; line-height:1.6">
		<?php echo 'Session<br>'.substr($orgsetins['cAcademicDesc'], 0, 4);?>
	</div>
	
	<div id="std_quali" class="appl_left_child_btn_div" style="width:auto;padding:20px 0px 20px 0px; border-bottom:1px dashed #ccc; line-height:1.6"><?php 
		if (!is_bool(strpos($vProgrammeDesc,"(d)")))
		{
			$vProgrammeDesc = substr($vProgrammeDesc, 0, strlen($vProgrammeDesc)-4);
		}
		echo $vObtQualTitle.'<br>'.$vProgrammeDesc;?>
	</div>
	<div id="std_lvl" class="appl_left_child_btn_div" style="padding:20px 0px 20px 0px; border-bottom:1px dashed #ccc; line-height:1.6">
		<?php if ($iStudy_level == 30)
		{
			echo 'DIP 1<br>';
		}else if ($iStudy_level == 40)
		{
			echo 'DIP 2<br>';
		}else if ($iStudy_level == 10)
		{
			echo 'Certificate<br>';
		}else if ($cEduCtgId == 'PSZ')
		{
			echo $iStudy_level.'Level<br>';
		}else
		{
			echo 'Postgraduate Programme';
		}?>
	</div>
	<div id="std_sems" class="appl_left_child_btn_div" style=" padding:20px 0px 20px 0px; border-bottom:1px dashed #ccc; line-height:1.6">
		<?php //if (SEMESTER_COUNT%2 == 0)
		if ($tSemester > 0 && ($tSemester%2) == 0)
		{
			echo 'Second semester';
		}else
		{
			echo 'First semester';
		}//echo 'Semester '.SEMESTER_COUNT;?>
	</div>
	<div id="std_vCityName" class="appl_left_child_btn_div" style=" padding:20px 0px 20px 0px; border-bottom:1px dashed #ccc; line-height:1.6"><?php
		echo $vCityName;?>
	</div><?php
}


function build_menu_right()
{
	$orgsetins = settns();
	$semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);
	$account_close_date = substr($orgsetins['ac_close_date'],4,4).'-'.substr($orgsetins['ac_close_date'],2,2).'-'.substr($orgsetins['ac_close_date'],0,2);
	$account_open_date = substr($orgsetins['ac_open_date'],4,4).'-'.substr($orgsetins['ac_open_date'],2,2).'-'.substr($orgsetins['ac_open_date'],0,2);

	$wrking_year_tab = WORKING_YR_TABLE;?>

	<div class="appl_left_child_btn_div" style="margin-top:5px;">
		<img name="passprt" id="passprt" src="<?php echo get_pp_pix('');?>" width="165px" height="100%"/>
	</div>
	<div class="appl_left_child_btn_div" style="border-bottom:1px dashed #ccc; padding:20px 0px 20px 0px; line-height:1.6">
		<?php echo $_REQUEST["vMatricNo"];?>
	</div>
	<?php side_detail($_REQUEST['vMatricNo']);
	
	$mysqli = link_connect_db();


	$stmt = $mysqli->prepare("SELECT SUM(amount)
	FROM s_tranxion_cr
	WHERE LEFT(tdate,10) > '$account_close_date'
	AND vMatricNo = ?;");							
	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($Amount_bal_1);
	$stmt->fetch();

	if (is_null($Amount_bal_1))
	{
		$Amount_bal_1 = 0.00;
	}
	//echo $Amount_bal_1;

	$stmt = $mysqli->prepare("SELECT SUM(amount)
	FROM $wrking_year_tab
	WHERE LEFT(tdate,10) > '$account_close_date'
	AND vMatricNo = ?;");							
	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($Amount_bal_2);
	$stmt->fetch();

	if (is_null($Amount_bal_2))
	{
		$Amount_bal_2 = 0.00;
	}
	//echo ', '.$Amount_bal_2;
	
	$stmt = $mysqli->prepare("SELECT n_balance
	FROM s_tranxion_prev_bal1
	WHERE vMatricNo = ?;");							
	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($Amount_bal);
	$stmt->fetch();

	if (is_null($Amount_bal))
	{
		$Amount_bal = 0.00;
	}


	$stmt_b = $mysqli->prepare("SELECT SUM(amount)
	FROM s_tranxion_cr
	WHERE (tdate >= '$semester_begin_date' AND tdate < '$account_open_date')
	AND vMatricNo = ?;");							
	$stmt_b->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt_b->execute();
	$stmt_b->store_result();
	$stmt_b->bind_result($old_cr_bal);
	$stmt_b->fetch();
	
	if (is_null($old_cr_bal))
	{
		$old_cr_bal = 0.00;
	}	
	//echo $old_cr_bal.'<br>';

	$stmt_b = $mysqli->prepare("SELECT SUM(amount)
	FROM $wrking_year_tab
	WHERE (tdate >= '$semester_begin_date' AND tdate < '$account_open_date')
	AND cCourseId NOT LIKE 'F0%'
	AND trans_count IS NOT NULL
	AND vMatricNo = ?;");							
	$stmt_b->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt_b->execute();
	$stmt_b->store_result();
	$stmt_b->bind_result($old_dr_bal);
	$stmt_b->fetch();
	$stmt_b->close();
	
	if (is_null($old_dr_bal))
	{
		$old_dr_bal = 0.00;
	}	
	//echo $old_dr_bal;
	
	//echo ', '.$Amount_bal.'<br>'.(($Amount_bal+$Amount_bal_1)-$Amount_bal_2);

	//$balance = $Amount_bal + $Amount_bal_1;

	//$balance = $Amount_bal + ($Amount_bal_1-$Amount_bal_2);

	//$balance = $Amount_bal + ($Amount_bal_1-$Amount_bal_2) + ($old_cr_bal - $old_dr_bal);
	
	$credit_balance = $Amount_bal_1+$old_cr_bal;
	$debit_balance = $Amount_bal_2 + $old_dr_bal;

	if ($Amount_bal < 0)
	{
		$debit_balance += $Amount_bal;
	}else
	{
		$credit_balance += $Amount_bal;
	}

	if ($credit_balance == 0 && $debit_balance < 0)
	{
		$balance = $debit_balance;
	}else
	{
		$balance = $credit_balance - $debit_balance;
	}

	$stmt->close();?>
	
	<div class="appl_left_child_btn_div" style="border-bottom:1px dashed #ccc; padding:20px 0px 20px 0px; line-height:1.6">
		<?php echo 'eWallet balance NGN<br>'.number_format($balance, 2, '.', ',');?>
	</div><?php

	if (isset($_REQUEST["vMatricNo"]) && !is_null($_REQUEST["vMatricNo"]))
	{
		$stmt_balance = $mysqli->prepare("REPLACE INTO s_tranxion_prev_bal1_next
		SET vMatricNo = ?,
		credit = $credit_balance,
		debit = $debit_balance,
		n_balance = $balance,
		actual_balance = $balance");							
		$stmt_balance->bind_param("s", $_REQUEST["vMatricNo"]);
		$stmt_balance->execute();
		$stmt_balance->close();
	}
}



/*function build_menu_right()
{?>
	<div class="appl_left_child_btn_div" style="margin-top:5px;">
		<img name="passprt" id="passprt" src="<?php echo get_pp_pix('');?>" width="165px" height="100%"/>
	</div>
	<div class="appl_left_child_btn_div" style="border-bottom:1px dashed #ccc; padding:20px 0px 20px 0px; line-height:1.6">
		<?php echo $_REQUEST["vMatricNo"];?>
	</div>
	<?php side_detail($_REQUEST['vMatricNo']);
	
	$mysqli = link_connect_db();
	
	$stmt = $mysqli->prepare("select  SUM(`amount`) 
	from s_tranxion_cr
	where vMatricNo = ?");
	$stmt->bind_param("s", $_REQUEST['vMatricNo']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($balance);
	$stmt->fetch();

	if (is_null($balance))
	{
		$balance = 0.00;
	}
	
	$table = search_starting_pt1($_REQUEST['vMatricNo']);
	foreach ($table as &$value)
    {
        $wrking_tab = 's_tranxion_'.$value;
        
        //echo $wrking_tab.'<br>';
	
    	$stmt = $mysqli->prepare("select  SUM(`amount`) 
    	from $wrking_tab
    	where vMatricNo = ?");
    	$stmt->bind_param("s", $_REQUEST['vMatricNo']);
    	$stmt->execute();
    	$stmt->store_result();
    	$stmt->bind_result($Amount_b);
    	$stmt->fetch();

		if (is_null($Amount_b))
		{
			$Amount_b = 0.00;
		}
    	
    	$balance -= $Amount_b;
    }



	if ($balance < 0)
	{
		$stmt = $mysqli->prepare("SELECT SUM(amount)
		FROM s_tranxion_cr
		WHERE (tdate >= '$semester_begin_date' AND tdate < '$account_close_date')
		AND vMatricNo = ?;");							
		$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($Amount_bal_1);
		$stmt->fetch();

		if (is_null($Amount_bal_1))
		{
			$Amount_bal_1 = 0.00;
		}
		
		$stmt = $mysqli->prepare("SELECT n_balance
		FROM s_tranxion_prev_bal1
		WHERE vMatricNo = ?;");							
		$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($Amount_bal);
		$stmt->fetch();

		if (is_null($Amount_bal))
		{
			$Amount_bal = 0.00;
		}

		$balance = $Amount_bal + $Amount_bal_1;
	}
	$stmt->close();?>
	
	<div class="appl_left_child_btn_div" style="border-bottom:1px dashed #ccc; padding:20px 0px 20px 0px; line-height:1.6">
		<?php echo 'eWallet balance NGN<br>'.number_format($balance, 2, '.', ',');?>
	</div><?php
} */


function search_starting_pt1($ref_no)
{
    if(substr($ref_no,3,2) <= 19)
	{
		//$tables = '20172019,20202021,20222023,20242025';
		$tables = '2017,2018,2019,20202021,20222023,20242025';
	}else if(substr($ref_no,3,2) == 20 || substr($ref_no,3,2) == 21)
	{
		$tables = '20202021,20222023,20242025';
	}else if(substr($ref_no,3,2) == 22 || substr($ref_no,3,2) == 23)
	{
		$tables = '20222023,20242025';
	}else
	{
		$tables = '20242025';
	}
	
	return explode(",", $tables);
}


function search_starting_crs1($ref_no)
{
    if(substr($ref_no,3,2) <= 19)
	{
		$tables = '20172019,20202021,20222023,20242025';
		//$tables = '2017,2018,2019,20202021,20222023,20242025';
	}else if(substr($ref_no,3,2) == 20 || substr($ref_no,3,2) == 21)
	{
		$tables = '20202021,20222023,20242025';
	}else if(substr($ref_no,3,2) == 22 || substr($ref_no,3,2) == 23)
	{
		$tables = '20222023,20242025';
	}else
	{
		$tables = '20242025';
	}
	
	return explode(",", $tables);
}


function calc_student_bal($vMatricNo, $what, $cResidenceCountryId_loc)
{	
	$orgsetins = settns();
	
	$semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);
	$account_close_date = substr($orgsetins['ac_close_date'],4,4).'-'.substr($orgsetins['ac_close_date'],2,2).'-'.substr($orgsetins['ac_close_date'],0,2);
	$account_open_date = substr($orgsetins['ac_open_date'],4,4).'-'.substr($orgsetins['ac_open_date'],2,2).'-'.substr($orgsetins['ac_open_date'],0,2);

	$wrking_year_tab = WORKING_YR_TABLE;

	$cFacultyId = '';
	$cdeptId = '';
	$cProgrammeId = '';
	$cEduCtgId = '';
	$iStudy_level = '';
	$tSemester = '';
	$cStudyCenterId = '';
	$entry_session = '';
	
	$mysqli = link_connect_db();

    $stmt = $mysqli->prepare("SELECT cFacultyId, a.cdeptId, a.cProgrammeId, cEduCtgId, iStudy_level, tSemester, cStudyCenterId, cAcademicDesc_1
	from s_m_t a, programme b
	where a.cProgrammeId = b.cProgrammeId
	AND vMatricNo = ?");
	$stmt->bind_param("s", $vMatricNo);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cFacultyId, $cdeptId, $cProgrammeId, $cEduCtgId, $iStudy_level, $tSemester, $cStudyCenterId, $entry_session);
	$stmt->fetch();


	$Amount = '';
	$cTrntype = '';
	$balance = 0;

	$stmt = $mysqli->prepare("SELECT SUM(amount)
	FROM s_tranxion_cr
	WHERE LEFT(tdate,10) > '$account_close_date'
	AND vMatricNo = ?;");							
	$stmt->bind_param("s", $vMatricNo);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($Amount_bal_1);
	$stmt->fetch();

	if (is_null($Amount_bal_1))
	{
		$Amount_bal_1 = 0.00;
	}
	//echo $Amount_bal_1;

	$stmt = $mysqli->prepare("SELECT SUM(amount)
	FROM $wrking_year_tab
	WHERE LEFT(tdate,10) > '$account_close_date'
	AND vMatricNo = ?;");							
	$stmt->bind_param("s", $vMatricNo);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($Amount_bal_2);
	$stmt->fetch();

	if (is_null($Amount_bal_2))
	{
		$Amount_bal_2 = 0.00;
	}
	//echo ', '.$Amount_bal_2;
	
	$stmt = $mysqli->prepare("SELECT n_balance
	FROM s_tranxion_prev_bal1
	WHERE vMatricNo = ?;");							
	$stmt->bind_param("s", $vMatricNo);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($Amount_bal);
	$stmt->fetch();

	if (is_null($Amount_bal))
	{
		$Amount_bal = 0.00;
	}


	$stmt_b = $mysqli->prepare("SELECT SUM(amount)
	FROM s_tranxion_cr
	WHERE (tdate >= '$semester_begin_date' AND tdate < '$account_open_date')
	AND vMatricNo = ?;");							
	$stmt_b->bind_param("s", $vMatricNo);
	$stmt_b->execute();
	$stmt_b->store_result();
	$stmt_b->bind_result($old_cr_bal);
	$stmt_b->fetch();
	
	if (is_null($old_cr_bal))
	{
		$old_cr_bal = 0.00;
	}	
	//echo $old_cr_bal.'<br>';

	$stmt_b = $mysqli->prepare("SELECT SUM(amount)
	FROM $wrking_year_tab
	WHERE (tdate >= '$semester_begin_date' AND tdate < '$account_open_date')
	AND cCourseId NOT LIKE 'F0%'
	AND trans_count IS NOT NULL
	AND vMatricNo = ?;");							
	$stmt_b->bind_param("s", $vMatricNo);
	$stmt_b->execute();
	$stmt_b->store_result();
	$stmt_b->bind_result($old_dr_bal);
	$stmt_b->fetch();
	$stmt_b->close();
	
	if (is_null($old_dr_bal))
	{
		$old_dr_bal = 0.00;
	}
	
	//echo $old_dr_bal;
	
	//echo ', '.$Amount_bal.'<br>'.(($Amount_bal+$Amount_bal_1)-$Amount_bal_2);

	//$balance = $Amount_bal + $Amount_bal_1;

	//$balance = $Amount_bal + ($Amount_bal_1-$Amount_bal_2);

	$balance = $Amount_bal + ($Amount_bal_1-$Amount_bal_2) + ($old_cr_bal - $old_dr_bal);

	
	
	$stmt->close();
	
	$iItemID_str = "'";
	
	if ($cdeptId == 'PCC')
	{
	    $sub_query = collect_fees_to_pay($vMatricNo, $cEduCtgId, $cFacultyId, 'PCC', $tSemester, $entry_session, $cResidenceCountryId_loc);
	}else if ($cdeptId == 'CPE')
	{
		$sub_query = collect_fees_to_pay($vMatricNo, $cEduCtgId, $cFacultyId, 'CPE', $tSemester, $entry_session, $cResidenceCountryId_loc);
	}else
	{
	    $sub_query = collect_fees_to_pay($vMatricNo, $cEduCtgId, $cFacultyId, 'All', $tSemester, $entry_session, $cResidenceCountryId_loc);
	}

    if ($what == 'mone_to_pay')
    {
        $stmt_reuse = $mysqli->prepare("SELECT citem_cat_desc, b.fee_item_desc vDesc, Amount, iItemID 
		FROM s_f_s a, fee_items b, sell_item_cat c 
		WHERE a.fee_item_id = b.fee_item_id 
		AND a.citem_cat = c.citem_cat
		AND a.cEduCtgId = c.cEduCtgId 
		AND b.fee_item_desc <> 'Late Fee' 
		AND b.fee_item_desc <> 'Course Registration' 
		AND b.fee_item_desc <> 'Examination Fee'
		AND study_mode_ID = 'odl' 
		AND a.cdel = 'N'
		AND cEduCtgId = '$cEduCtgId' $sub_query
		ORDER BY a.citem_cat, vDesc");
        
        $stmt_reuse->execute();
        $stmt_reuse->store_result();
        $stmt_reuse->bind_result($citem_cat_desc, $vDesc, $Amount, $iItemID);

		$str = '';
        while ($stmt_reuse->fetch())
		{
			$str .= str_pad($citem_cat_desc,100).str_pad($vDesc,100).str_pad($Amount,100);
		}
		$stmt_reuse->close();

		$arr = str_split($str, 100);
		return $arr;
    }else if ($what == 'mone_at_hand')
    {
        $sql = "SELECT sum(Amount) 
        FROM s_f_s a, fee_items b 
        WHERE a.fee_item_id = b.fee_item_id 
        AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')
        AND a.citem_cat NOT LIKE '_2'
		AND a.Amount > 0
        AND a.cdel = 'N'
        AND cEduCtgId = '$cEduCtgId' $sub_query";//echo $sql;
        $rsql3 = mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));
        $rs = mysqli_fetch_array($rsql3);

        $minfee = $rs[0];
        if ($minfee == '')
        {
            $minfee = 0;
        }
		mysqli_close(link_connect_db());
        
        $sql = "SELECT iItemID from s_f_s a, fee_items b 
        WHERE a.fee_item_id = b.fee_item_id 
        AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')
        AND a.citem_cat NOT LIKE '_2'
		AND a.Amount > 0
        AND a.cdel = 'N'
        AND cEduCtgId = '$cEduCtgId' $sub_query
		ORDER BY iItemID";//echo $sql;
        
        $rsql3 = mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));
        while($rs = mysqli_fetch_array($rsql3))
        {
            $iItemID_str .= $rs[0]."','";
        }
		mysqli_close(link_connect_db());
		$iItemID_str = substr($iItemID_str, 0, strlen($iItemID_str)-2);

        $semBeginDate = substr($orgsetins['semdate1'],4,4).'-'.substr($orgsetins['semdate1'],2,2).'-'.substr($orgsetins['semdate1'],0,2);

        $stmt = $mysqli->prepare("SELECT tdate, amount 
        FROM s_tranxion_cr 
        WHERE vMatricNo = ? 
        AND amount >= $minfee 
        AND cTrntype = 'c' 
        AND tdate >= '$semBeginDate'
		AND cAcademicDesc = '".$orgsetins['cAcademicDesc']."'");

        $stmt->bind_param("s", $vMatricNo);
        $stmt->execute();
        $stmt->store_result();
        $just_paid = $stmt->num_rows;
        $stmt->close();

		if (strlen($iItemID_str) < 8)
		{
			$iItemID_str = "''";
		}

        return str_pad($balance, 100).
        str_pad($minfee, 100).
        str_pad($iItemID_str, 300).
        str_pad($just_paid, 100);
    }
}

function prev_wallet_bal()
{
	$mysqli = link_connect_db();

	$stmt_b = $mysqli->prepare("SELECT * FROM s_tranxion_prev_bal1 WHERE vMatricNo = ?;");							
	$stmt_b->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt_b->execute();
	$stmt_b->store_result();
	$rows = $stmt_b->num_rows;
	if ($rows > 0)
	{
		$stmt_b->close();
		return;		
	}
	

	$balance = 0;

	$orgsetins = settns();
	//$semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);
	$semester_begin_date = '2024-07-22';

	//$account_close_date = substr($orgsetins['ac_close_date'],4,4).'-'.substr($orgsetins['ac_close_date'],2,2).'-'.substr($orgsetins['ac_close_date'],0,2);
	$account_close_date = '2024-08-31';

	//$account_open_date = substr($orgsetins['ac_open_date'],4,4).'-'.substr($orgsetins['ac_open_date'],2,2).'-'.substr($orgsetins['ac_open_date'],0,2);		
	$account_open_date = '2024-09-01';

	$wrking_year_tab = WORKING_YR_TABLE;
	

	$stmt = $mysqli->prepare("SELECT SUM(amount)
	FROM s_tranxion_cr
	WHERE LEFT(tdate,10) > '$account_close_date'
	AND vMatricNo = ?;");							
	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($Amount_bal_1);
	$stmt->fetch();

	if (is_null($Amount_bal_1))
	{
		$Amount_bal_1 = 0.00;
	}
	//echo $Amount_bal_1;

	$stmt = $mysqli->prepare("SELECT SUM(amount)
	FROM $wrking_year_tab
	WHERE LEFT(tdate,10) > '$account_close_date'
	AND vMatricNo = ?;");							
	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($Amount_bal_2);
	$stmt->fetch();

	if (is_null($Amount_bal_2))
	{
		$Amount_bal_2 = 0.00;
	}
	//echo ', '.$Amount_bal_2;

	$stmt = $mysqli->prepare("SELECT n_balance
	FROM s_tranxion_prev_bal_2024
	WHERE vMatricNo = ?;");							
	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($Amount_bal);
	$stmt->fetch();

	if (is_null($Amount_bal))
	{
		$Amount_bal = 0.00;
	}
	//echo ', '.$Amount_bal;

	$stmt_b = $mysqli->prepare("SELECT SUM(amount)
	FROM s_tranxion_cr
	WHERE (tdate >= '$semester_begin_date' AND tdate < '$account_open_date')
	AND vMatricNo = ?;");							
	$stmt_b->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt_b->execute();
	$stmt_b->store_result();
	$stmt_b->bind_result($old_cr_bal);
	$stmt_b->fetch();
	
	if (is_null($old_cr_bal))
	{
		$old_cr_bal = 0.00;
	}
	
	//echo $old_cr_bal.'<br>';

	$stmt_b = $mysqli->prepare("SELECT SUM(amount)
	FROM $wrking_year_tab
	WHERE (tdate >= '$semester_begin_date' AND tdate < '$account_open_date')
	AND cCourseId NOT LIKE 'F0%'
	AND trans_count IS NOT NULL
	AND vMatricNo = ?;");							
	$stmt_b->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt_b->execute();
	$stmt_b->store_result();
	$stmt_b->bind_result($old_dr_bal);
	$stmt_b->fetch();
	$stmt_b->close();
	
	if (is_null($old_dr_bal))
	{
		$old_dr_bal = 0.00;
	}
	
	//echo $old_dr_bal;

	$balance = $Amount_bal + ($Amount_bal_1-$Amount_bal_2) + ($old_cr_bal - $old_dr_bal);

	$stmt = $mysqli->prepare("INSERT IGNORE INTO s_tranxion_prev_bal1 
	(vMatricNo, 
	n_balance, 
	actual_balance, 
	narata)
	VALUE(?,$balance,$balance,'Opening balance')");
	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt->execute();

	//return $balance;
}


function collect_fees_to_pay($vMatricNo, $cEduCtgId_loc, $cFacultyId_loc, $cdeptId_loc, $tSemester_loc, $cAcademicDesc_1, $cResidenceCountryId_loc)
{
	$fac_dept_prog_spec_pay = '';
	$sql_cat ='';
	$sql_feet_type = '';
				
	if ($cFacultyId_loc <> 'ALL')
	{
		$fac_dept_prog_spec_pay .= " cFacultyId = '".$cFacultyId_loc."'";
	}

	if ($cdeptId_loc <> 'ALL')
	{
		$fac_dept_prog_spec_pay .= " AND cdeptId = '".$cdeptId_loc."'";
	}
	
	$fac_dept_prog_spec_pay = " AND (".$fac_dept_prog_spec_pay.")";

	if ($cResidenceCountryId_loc == 'NG')
	{
		if ($cEduCtgId_loc == 'ELX')
		{
			
		}else if ($cEduCtgId_loc == 'PSZ')
		{
			if ($tSemester_loc <= 1)
			{
				if (paid_one_off_fee($vMatricNo, 'A1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'A1' or citem_cat = 'A4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else
				{
					$sql_cat = " AND citem_cat = 'A4'";
				}
				
			}else
			{
				$sql_cat = " AND citem_cat = 'A5'";
			}
		}else if ($cEduCtgId_loc == 'PGX')
		{
			if ($tSemester_loc <= 1)
			{
				if (paid_one_off_fee($vMatricNo, 'B1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'B1' or citem_cat = 'B4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else
				{
					$sql_cat = " AND citem_cat = 'B4'";
				}
				
			}else
			{
				$sql_cat = " AND citem_cat = 'B5'";
			}
		}else if ($cEduCtgId_loc == 'PGY')
		{		
			if ($tSemester_loc <= 1)
			{
				if (paid_one_off_fee($vMatricNo, 'C1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'C1' or citem_cat = 'C4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else
				{
					$sql_cat = " AND citem_cat = 'C4'";
				}
				
			}else
			{
				$sql_cat = " AND citem_cat = 'C5'";
			}
		}else if ($cEduCtgId_loc == 'PGZ')
		{		
			//if ($tSemester_loc == 1)
			//{
				if (paid_one_off_fee($vMatricNo, 'G1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'G1' or citem_cat = 'G3' or citem_cat = 'G4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else if ($tSemester_loc%2 > 0)
				{
					$sql_cat = " AND citem_cat = 'G4' or citem_cat = 'G3'";
				}else
				{
					$sql_cat = " AND citem_cat = 'G4'";
				}
				
			//}else
			//{
				//$sql_cat = " AND citem_cat = 'G5'";
			//}
		}else if ($cEduCtgId_loc == 'PRX')
		{		
			/*if ($tSemester_loc == 1)
			{*/
				if (paid_one_off_fee($vMatricNo, 'D1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'D1' or citem_cat = 'D3' or citem_cat = 'D4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else if ($tSemester_loc%2 > 0)
				{
					$sql_cat = " AND citem_cat = 'D4' or citem_cat = 'D3'";
				}else
				{
					$sql_cat = " AND citem_cat = 'D4'";
				}
				
			/*}else
			{
				$sql_cat = " AND citem_cat = 'D5'";
			}*/
		}else if ($cEduCtgId_loc == 'ELZ')
		{
			if ($tSemester_loc == 1)
			{
				if (paid_one_off_fee($vMatricNo, 'E1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'E1' or citem_cat = 'E4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else
				{
					$sql_cat = " AND citem_cat = 'E4'";
				}
				
			}else
			{
				$sql_cat = " AND citem_cat = 'E5'";
			}
		}
	}else
	{
		if ($cEduCtgId_loc == 'PSZ')
		{
			if ($tSemester_loc <= 1)
			{
				if (paid_one_off_fee($vMatricNo, 'H1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'H1' or citem_cat = 'H4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else
				{
					$sql_cat = " AND citem_cat = 'H4'";
				}
				
			}else
			{
				$sql_cat = " AND citem_cat = 'H5'";
			}
		}else if ($cEduCtgId_loc == 'PGX')
		{
			if ($tSemester_loc <= 1)
			{
				if (paid_one_off_fee($vMatricNo, 'I1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'I1' or citem_cat = 'I3' or citem_cat = 'I4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else
				{
					$sql_cat = " AND (citem_cat = 'I3' or citem_cat = 'I4')";
				}
				
			}else
			{
				$sql_cat = " AND citem_cat = 'I5'";
			}
		}else if ($cEduCtgId_loc == 'PGY')
		{
			if ($tSemester_loc <= 1)
			{
				if (paid_one_off_fee($vMatricNo, 'J1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'J1' or citem_cat = 'J3' or citem_cat = 'J4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else
				{
					$sql_cat = " AND (citem_cat = 'J3' or citem_cat = 'J4')";
				}
				
			}else
			{
				$sql_cat = " AND citem_cat = 'J5'";
			}
		}else if ($cEduCtgId_loc == 'PGZ')
		{
			if ($tSemester_loc <= 1)
			{
				if (paid_one_off_fee($vMatricNo, 'N1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'N1' or citem_cat = 'N3' or citem_cat = 'N4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else
				{
					$sql_cat = " AND (citem_cat = 'N3' or citem_cat = 'N4')";
				}
				
			}else
			{
				$sql_cat = " AND citem_cat = 'N5'";
			}
		}else if ($cEduCtgId_loc == 'PRX')
		{
			if ($tSemester_loc <= 1)
			{
				if (paid_one_off_fee($vMatricNo, 'K1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'K1' or citem_cat = 'K3' or citem_cat = 'K4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else
				{
					$sql_cat = " AND (citem_cat = 'K3' or citem_cat = 'K4')";
				}
				
			}else
			{
				$sql_cat = " AND citem_cat = 'K5'";
			}
		}
	}

	$sql_feet_type = select_fee_srtucture($vMatricNo, $cResidenceCountryId_loc, $cEduCtgId_loc);

	return $fac_dept_prog_spec_pay.$sql_cat.$sql_feet_type;
}




function collect_all_fees_to_pay($vMatricNo, $cEduCtgId_loc, $cFacultyId_loc, $cdeptId_loc, $tSemester_loc, $cAcademicDesc_1, $cResidenceCountryId_loc)
{
	$fac_dept_prog_spec_pay = '';
	$sql_cat ='';
	$sql_feet_type = '';
				
	if ($cFacultyId_loc <> 'ALL')
	{
		$fac_dept_prog_spec_pay .= " cFacultyId = '".$cFacultyId_loc."'";
	}

	if ($cdeptId_loc <> 'ALL')
	{
		$fac_dept_prog_spec_pay .= " or cdeptId = '".$cdeptId_loc."'";
	}
	
	$fac_dept_prog_spec_pay = " AND (".$fac_dept_prog_spec_pay.")";

	if ($cResidenceCountryId_loc == 'NG')
	{
		if ($cEduCtgId_loc == 'PSZ')
		{
			if ($tSemester_loc == 1)
			{
				if (paid_one_off_fee($vMatricNo, 'A1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'A1' or citem_cat = 'A4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else
				{
					$sql_cat = " AND citem_cat = 'A4'";
				}
				
			}else
			{
				$sql_cat = " AND citem_cat = 'A5'";
			}
		}else if ($cEduCtgId_loc == 'PGX')
		{
			if ($tSemester_loc == 1)
			{
				if (paid_one_off_fee($vMatricNo, 'B1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'B1' or citem_cat = 'B4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else
				{
					$sql_cat = " AND citem_cat = 'B4'";
				}
				
			}else
			{
				$sql_cat = " AND citem_cat = 'B5'";
			}
		}else if ($cEduCtgId_loc == 'PGY')
		{		
			if ($tSemester_loc == 1)
			{
				if (paid_one_off_fee($vMatricNo, 'C1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'C1' or citem_cat = 'C4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else
				{
					$sql_cat = " AND citem_cat = 'C4'";
				}
				
			}else
			{
				$sql_cat = " AND citem_cat = 'C5'";
			}
		}else if ($cEduCtgId_loc == 'ELZ')
		{
			if ($tSemester_loc == 1)
			{
				if (paid_one_off_fee($vMatricNo, 'E1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'E1' or citem_cat = 'E4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else
				{
					$sql_cat = " AND citem_cat = 'E4'";
				}
				
			}else
			{
				$sql_cat = " AND citem_cat = 'E5'";
			}
		}
	}else
	{
		if ($cEduCtgId_loc == 'PSZ')
		{
			if ($tSemester_loc == 1)
			{
				if (paid_one_off_fee($vMatricNo, 'H1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'H1' or citem_cat = 'H4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else
				{
					$sql_cat = " AND citem_cat = 'H4'";
				}
				
			}else
			{
				$sql_cat = " AND citem_cat = 'H5'";
			}
		}else if ($cEduCtgId_loc == 'PGX')
		{
			if ($tSemester_loc == 1)
			{
				if (paid_one_off_fee($vMatricNo, 'I1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'I1' or citem_cat = 'I3' or citem_cat = 'I4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else
				{
					$sql_cat = " AND (citem_cat = 'I3' or citem_cat = 'I4')";
				}
				
			}else
			{
				$sql_cat = " AND citem_cat = 'I5'";
			}
		}else if ($cEduCtgId_loc == 'PGY')
		{
			if ($tSemester_loc == 1)
			{
				if (paid_one_off_fee($vMatricNo, 'J1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'J1' or citem_cat = 'J3' or citem_cat = 'J4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else
				{
					$sql_cat = " AND (citem_cat = 'J3' or citem_cat = 'J4')";
				}
				
			}else
			{
				$sql_cat = " AND citem_cat = 'J5'";
			}
		}else if ($cEduCtgId_loc == 'PGZ')
		{
			if ($tSemester_loc == 1)
			{
				if (paid_one_off_fee($vMatricNo, 'N1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'N1' or citem_cat = 'N3' or citem_cat = 'N4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else
				{
					$sql_cat = " AND (citem_cat = 'N3' or citem_cat = 'N4')";
				}
				
			}else
			{
				$sql_cat = " AND citem_cat = 'N5'";
			}
		}else if ($cEduCtgId_loc == 'PRX')
		{
			if ($tSemester_loc == 1)
			{
				if (paid_one_off_fee($vMatricNo, 'K1') == 0)
				{
					$sql_cat = " AND (citem_cat = 'K1' or citem_cat = 'K3' or citem_cat = 'K4') AND b.fee_item_desc NOT IN ('Application Fee','Convocation gown','Outstanding amount at graduation','Late Fee')";
				}else
				{
					$sql_cat = " AND (citem_cat = 'K3' or citem_cat = 'K4')";
				}
				
			}else
			{
				$sql_cat = " AND citem_cat = 'K5'";
			}
		}
	}

	$sql_feet_type = select_fee_srtucture($vMatricNo, $cResidenceCountryId_loc, $cEduCtgId_loc);

	return $fac_dept_prog_spec_pay.$sql_cat.$sql_feet_type;
}


function select_fee_srtucture($vMatricNo, $res_ctry, $cEduCtgId_loc)
{	
	$mysqli = link_connect_db();

	$cdeptId_loc = '';
	$stmt = $mysqli->prepare("SELECT cdeptId FROM s_m_t WHERE vMatricNo = ?");
    $stmt->bind_param("s", $vMatricNo);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($cdeptId_loc);
    $stmt->fetch();
    $stmt->close();
	//if ($res_ctry == 'NG')
	//{		
		if ($cEduCtgId_loc == 'PGX' || $cEduCtgId_loc == 'PGY' || $cEduCtgId_loc == 'PGZ' || $cEduCtgId_loc == 'PRX' || $cEduCtgId_loc == 'ELX')
		{
		    if ($cdeptId_loc == 'CPE' && $cEduCtgId_loc == 'PGY')
			{
				return " AND new_old_structure = 'c'";
			}
			return " AND (new_old_structure = 'o' OR a.fee_item_id = 1)";
		}
		
		// $mysqli = link_connect_db();
		
		// $stmt = $mysqli->prepare("SELECT tdate FROM s_tranxion_cr WHERE tdate < '2023-01-01' AND vMatricNo = ?");
        // $stmt->bind_param("s", $vMatricNo);
        // $stmt->execute();
        // $stmt->store_result();
        // $recods_found = $stmt->num_rows;
        // $stmt->close();
		
		if (substr($vMatricNo,3,2) <= 23)
		{
			return " AND (new_old_structure = 'o' OR a.fee_item_id = 1)";
		}else
		{
			return " AND (new_old_structure = 'n' OR a.fee_item_id = 1)";
		}
		// if ($recods_found > 0)
		// {
		// 	return " AND new_old_structure = 'o'";
		// }else
		// {
		// 	return " AND new_old_structure = 'n'";
		// }
	/*}else
	{
		return " AND new_old_structure = 'f'";
	}*/
}


function paid_one_off_fee($vMatricNo, $fee_cat)
{	
	if (strlen($vMatricNo) == 12 && substr($vMatricNo,3,2) < 22)
	{
		return 1;
	}
	
	$mysqli = link_connect_db();
	
	if(substr($vMatricNo,3,2) <= 19)
	{
		//$tables = '20172019,20202021,20222023,20242025';
		$tables = '2017,2018,2019,20202021,20222023,20242025';
	}else if(substr($vMatricNo,3,2) == 20 || substr($vMatricNo,3,2) == 21)
	{
		$tables = '20202021,20222023,20242025';
	}else if(substr($vMatricNo,3,2) == 22 || substr($vMatricNo,3,2) == 23)
	{
		$tables = '20222023,20242025';
	}else
	{
		$tables = '20242025';
	}
	
	$table = explode(",", $tables);

    $wallet_trn_cnt = 0;
    
    $trns = 0;
    foreach ($table as &$value)
    {
        $wrking_tab = 's_tranxion_'.$value;
	
        $stmt = $mysqli->prepare("SELECT * FROM $wrking_tab 
    	WHERE fee_item_id in ('1','4','13','17','19','21')
    	AND vMatricNo = '$vMatricNo'");
    	$stmt->execute();
    	$stmt->store_result();
    	$trns += $stmt->num_rows;
    }
    
    if (isset($stmt))
    {
	    $stmt->close();
    }
	
	return $trns;
}


function register_student_global($iStudy_level_loc, $tSemester_loc, $vMatricNo, $cResidenceCountryId_loc, $cEduCtgId_loc)
{
	$mysqli = link_connect_db();

	$orgsetins = settns();
							
    date_default_timezone_set('Africa/Lagos');
    $date2 = date("Y-m-d h:i:s");
	
	// if no, check for payment after the beginnig of the new session
	
	$credited_for_the_semester = 0;
	$credit_amount = 0;
	
	if ($orgsetins["ewallet_cred_for_sem_reg"] == '0')
	{
		$stmt = $mysqli->prepare("SELECT sum(amount) FROM s_tranxion_cr 
		WHERE cAcademicDesc = '".$orgsetins['cAcademicDesc']."'
		AND tSemester = $tSemester_loc
		AND vremark = 'Wallet Funding'
		AND vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($credit_amount);
		$stmt->fetch();
		$stmt->close();

		if (is_numeric($credit_amount) && $credit_amount > 0)
		{
			$credited_for_the_semester = 1;
		}else
		{
			return;
		}
	}else
	{
		$credited_for_the_semester = 1;
	}
	
	
	$balance = 0;	

	$returnedStr = calc_student_bal($vMatricNo, 'mone_at_hand', $cResidenceCountryId_loc);

	$balance = trim(substr($returnedStr, 0, 100));
	
	$minfee = trim(substr($returnedStr, 100, 100));
	$iItemID_str = trim(substr($returnedStr, 200, 300));
	//$just_paid = trim(substr($returnedStr, 500, 100));

	$semBeginDate = substr($orgsetins['semdate1'],4,4).'-'.substr($orgsetins['semdate1'],2,2).'-'.substr($orgsetins['semdate1'],0,2);

	// check for debit transactions to the tune of the expected payment for the new semester
	$wrking_year_tab = WORKING_YR_TABLE;
	$stmt = $mysqli->prepare("SELECT sum(amount) FROM $wrking_year_tab 
	WHERE tdate >= '$semBeginDate'
	AND vremark = 'Registration Deduction'
	AND vMatricNo = '$vMatricNo'");
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($debit_amount);
	$stmt->fetch();
	$stmt->close();

	if (is_null($debit_amount))
	{
		$debit_amount = 0.0;
	}
	
	if (is_numeric($debit_amount) && $debit_amount >= $minfee)
	{
		$stmt = $mysqli->prepare("UPDATE s_m_t SET semester_reg = '1' WHERE vMatricNo = '$vMatricNo'");
		$stmt->execute();
		$stmt->close();
		
		return;
	}
	
	//if yes, check if the payment is sufficient or the wallet balnce is suficient
	$enough_credit = -1;
	if ($credited_for_the_semester == 1)
	{
		$enough_credit = $credit_amount - $minfee;
	}
	
	// if no, did not register for new session
	if ($enough_credit < 0 && ($orgsetins["ewallet_cred_for_sem_reg"] == '1' && $balance < $minfee))
	{
		return;
	}
	

	$stmt_reuse = $mysqli->prepare("SELECT citem_cat_desc, b.fee_item_desc vDesc, Amount, iItemID, b.fee_item_id
	FROM s_f_s a, fee_items b, `sell_item_cat` c
	WHERE a.fee_item_id = b.fee_item_id
	AND a.`citem_cat` = c.`citem_cat`
	AND iItemID in ($iItemID_str)
	ORDER BY a.citem_cat, vDesc");

	$stmt_reuse->execute();
	$stmt_reuse->store_result();
	$stmt_reuse->bind_result($citem_cat_desc, $vDesc, $Amount, $iItemID, $fee_item_id);
	//$NumOfRec = $stmt_reuse->num_rows;
	
	if (!isset($cEduCtgId_loc))
	{
		exit;
	}
	
	try
	{				
		$mysqli->autocommit(FALSE); //turn on transactions

		initite_write_debit_transaction($vMatricNo, $orgsetins["cAcademicDesc"], $orgsetins['tSemester'], 'xxxxxx', 'Registration Deduction');

		$nxt_sn = get_nxt_sn ($vMatricNo, '','Registration Deduction', $cEduCtgId_loc);

		
		$NumOfRec = 0;
		while ($stmt_reuse->fetch())
		{
			$stmt = $mysqli->prepare("INSERT IGNORE INTO $wrking_year_tab 
			(vMatricNo, cCourseId, tdate, cTrntype, iItemID, amount, 
			tSemester, 
			cAcademicDesc, 
			siLevel,
			trans_count,
			fee_item_id, 
			vremark
			)VALUE('$vMatricNo','xxxxxx','$date2','d','".$iItemID."',".$Amount.",?,?,?,$nxt_sn,$fee_item_id,'Registration Deduction')");
			$stmt->bind_param("isi", $tSemester_loc, $orgsetins["cAcademicDesc"], $iStudy_level_loc);
			$stmt->execute();

			$NumOfRec++;
		}
		$stmt_reuse->close();
		
		$feed_back = '';
		if ($NumOfRec > 0)
		{
			if ($tSemester_loc%2 > 0)
			{
				$stmt = $mysqli->prepare("UPDATE s_m_t SET session_reg = '1',  semester_reg = '1', cAcademicDesc = '".$orgsetins["cAcademicDesc"]."', act_time = NOW() where vMatricNo = '$vMatricNo'");	
			    $stmt->execute();			
				log_actv('registered for new session');
				$feed_back = 'Registration successfull';
			}else //if ($tSemester_loc == 2)
			{
				$stmt = $mysqli->prepare("UPDATE s_m_t SET semester_reg = '1' WHERE vMatricNo = '$vMatricNo'");
			    $stmt->execute();
				
				log_actv('registered for second semester');
				$feed_back = 'Registration successfull';
			}

			//advance student
			if ($feed_back == 'Registration successfull')
			{		
				if ($cEduCtgId_loc == 'PSZ')
				{
					if ($tSemester_loc == 0)//fresher
					{
						$stmt = $mysqli->prepare("UPDATE s_m_t SET tSemester = tSemester + 1 WHERE vMatricNo = '$vMatricNo'");
						$stmt->execute();
					}else if ($tSemester_loc%2 > 0 && END_LEVEL > $iStudy_level_loc)//in 1st semester but not in final yr
					{
						$stmt = $mysqli->prepare("UPDATE s_m_t SET tSemester = tSemester + 1 WHERE vMatricNo = '$vMatricNo'");
						$stmt->execute();
					}else if ($tSemester_loc%2 == 0 && END_LEVEL > $iStudy_level_loc)//in 2nd semester but not in final yr
					{
						$stmt = $mysqli->prepare("UPDATE s_m_t SET tSemester = tSemester + 1, iStudy_level = iStudy_level + 100 WHERE vMatricNo = '$vMatricNo'");
						$stmt->execute();
					}else if (END_LEVEL == $iStudy_level_loc)//in 1st or 2nd semester in final yr
					{
						$stmt = $mysqli->prepare("UPDATE s_m_t SET tSemester = tSemester + 1 WHERE vMatricNo = '$vMatricNo'");
						$stmt->execute();
					}
				}else
				{
					$stmt = $mysqli->prepare("UPDATE s_m_t SET tSemester = tSemester + 1 WHERE vMatricNo = '$vMatricNo'");
					$stmt->execute();
				}
			}
		}		
		
		$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
		$stmt->close();

		return $feed_back;
	}catch(Exception $e)
	{
		$mysqli->rollback(); //remove all queries from queue if error (undo)
		throw $e;
	}
}


function get_active_request($spec_req)
{
	date_default_timezone_set('Africa/Lagos');
	$date2 = date("Y-m-d h:i:s");

	$mysqli = link_connect_db();
	
	$stmt = $mysqli->prepare("SELECT semester_reg,crs_reg,drp_crs_reg,see_crs_reg_slip,exam_reg,drp_exam_reg,see_exam_reg_slip,time_act,duration, used
	FROM vc_request
	WHERE vMatricNo = ?
	AND cdel = 'N'
    AND used = '0'
	AND LEFT(time_act,10) = CURDATE()
	ORDER BY time_act DESC LIMIT 1");
	$stmt->bind_param("s", $_REQUEST['vMatricNo']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($semester_reg, $crs_reg, $drp_crs_reg, $see_crs_reg_slip, $exam_reg, $drp_exam_reg, $see_exam_reg_slip, $time_act, $duration, $used);
	if ($stmt->num_rows > 0)
	{	
		$stmt->fetch();

		// $date1 = strtotime($time_act); 
		// $date3 = strtotime($date2); 
		// $diff = abs($date2 - $date1);
		// $years = floor($diff / (365*60*60*24));
		// $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		// $days = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24) / (60*60*24));
		// $hours = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24 - $days * 60*60*24) / (60*60));
		// $total_minutes = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24 - $days * 60*60*24 - $hours * 60*60) / 60);
		
		$datetime_1 = $time_act; 
		$datetime_2 = date("Y-m-d h:i:s");
		$start_datetime = new DateTime($datetime_1); 
		$diff = $start_datetime->diff(new DateTime($datetime_2)); 
		$total_minutes = ($diff->days * 24 * 60);
		$total_minutes += ($diff->h * 60);
		$total_minutes += $diff->i;
		//echo $total_minutes;
		if ($total_minutes < $duration && $used == '0')
		{
			if ($spec_req == 0)
			{
				return $semester_reg;
			}else if ($spec_req == 1)
			{
				return $crs_reg;
			}else if ($spec_req == 2)
			{
				return $drp_crs_reg;
			}else if ($spec_req == 3)
			{
				return $see_crs_reg_slip;
			}else if ($spec_req == 4)
			{
				return $exam_reg;
			}else if ($spec_req == 5)
			{
				return $drp_exam_reg;
			}else if ($spec_req == 6)
			{
				return $see_exam_reg_slip;
			}     
		}
	}
	$stmt->close();

	return '';
}


function send_token($purpose)
{
    require_once('../../PHPMailer/mail_con.php');
	$mysqli = link_connect_db();

    date_default_timezone_set('Africa/Lagos');	
	$date2 = date("Y-m-d H:i:s");
	$date2_0 = date("Y-m-d");
	
	$stmt = $mysqli->prepare("SELECT send_time, cused, vtoken FROM veri_token
	WHERE vApplicationNo = ?
	AND purpose = ?
	AND LEFT(send_time,10) = '$date2_0'
	ORDER BY send_time DESC LIMIT 1");
	$stmt->bind_param("ss",$_REQUEST["vMatricNo"], $purpose);

// 	$stmt = $mysqli->prepare("SELECT ABS(TIMESTAMPDIFF(MINUTE,send_time,'$date2')), send_time, cused, vtoken FROM veri_token
// 	WHERE vApplicationNo = ?
// 	AND LEFT(send_time,10) = '$date2_0'
// 	ORDER BY send_time DESC LIMIT 1");
// 	$stmt->bind_param("s",$_REQUEST["vMatricNo"]);

	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($send_date, $cused , $token);
	$stmt->fetch();

	if (is_null($send_date))
	{
		$send_date = '';
		$total_minutes = 21;
	}else
	{
		$date1 = strtotime($send_date); 
		$date3 = strtotime($date2); 
		$diff = abs($date3 - $date1);
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24) / (60*60*24));
		$hours = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24 - $days * 60*60*24) / (60*60));
		$total_minutes = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24 - $days * 60*60*24 - $hours * 60*60) / 60);

		// $datetime_1 = $send_date; 
		// $datetime_2 = date("Y-m-d h:i:s");
		// $start_datetime = new DateTime($datetime_1); 
		// $diff = $start_datetime->diff(new DateTime($datetime_2)); 
		// $total_minutes = ($diff->days * 24 * 60);
		// $total_minutes += ($diff->h * 60);
		// $total_minutes += $diff->i;
	}

	//$minutes = $minutes ?? '';
	
	if (($total_minutes > 20) || $stmt->num_rows() == 0 || $cused > 10)
	{
	    $stmt->close();

		$token = openssl_random_pseudo_bytes(4);
		//Convert the binary data into hexadecimal representation.
		$token = bin2hex($token);
	}else
	{
	    $stmt->close();
		return '';
	}
		
	$stmt_1 = $mysqli->prepare("SELECT vFirstName FROM s_m_t WHERE vMatricNo = ?");
	$stmt_1->bind_param("s", $_REQUEST['vMatricNo']);
	$stmt_1->execute();
	$stmt_1->store_result();
	$stmt_1->bind_result($vFirstName);
	$stmt_1->fetch();
	$stmt_1->close();

	$vEMailId = strtolower($_REQUEST['vMatricNo']).'@noun.edu.ng';

	//$vEMailId = 'aadeboyejo@noun.edu.ng';

	$subject = 'NOUN - Token for '.$purpose;
	$mail_msg = "Dear $vFirstName,<br><br>
	Copy the token below and paste it in the appropriate box on the NOUN page.
	<p><b>$token</b>
	<p>Thank you";

	$mail_msg = wordwrap($mail_msg, 70);
	
	$mail->addAddress($vEMailId, $vFirstName); // Add a recipient
	$mail->Subject = $subject;
	$mail->Body = $mail_msg;

	//for ($looop = 1; $looop <= 5; $looop++)
	//{

		if ($mail->send())
		{
			if(!empty($_SERVER['HTTP_CLIENT_IP'])) //whether ip is from the share internet
			{
				$ipee = $_SERVER['HTTP_CLIENT_IP'];  
			}else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) //whether ip is from the proxy
			{  
				$ipee = $_SERVER['HTTP_X_FORWARDED_FOR'];  
			}else//whether ip is from the remote address
			{  
				$ipee = $_SERVER['REMOTE_ADDR'];  
			}
			
				/*try
				{
					$mysqli->autocommit(FALSE);*/ 
					//turn on transactions

					$stmt = $mysqli->prepare("INSERT INTO veri_token SET
					vApplicationNo = ?,
					vtoken = '$token',
					send_time = '$date2',
					purpose = ?");
					$stmt->bind_param("ss", $_REQUEST['vMatricNo'], $purpose); 
					$stmt->execute();
					$stmt->close();
					
					$stmt = $mysqli->prepare("INSERT INTO atv_log SET 
					vApplicationNo  = ?,
					vDeed = 'sent a token for $purpose to $vEMailId',
					act_location = ?,
					tDeedTime = '$date2'");
					$stmt->bind_param("ss", $_REQUEST['vMatricNo'], $ipee);
					$stmt->execute();
					$stmt->close();

					/*$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
				}catch(Exception $e) 
				{
					$mysqli->rollback(); //remove all queries from queue if error (undo)
					throw $e;
				}*/

				//break;
			}
		//$looop++;
	//}	

	return $token;
}


function validate_token($purpose)
{
	$mysqli = link_connect_db();

    date_default_timezone_set('Africa/Lagos');
    $date2 = date("Y-m-d H:i:s");
    $date2_0 = date("Y-m-d");
	
	$stmt = $mysqli->prepare("SELECT send_time, vtoken FROM veri_token
	WHERE vApplicationNo = ?
    AND vtoken = ?
	AND purpose = ?
	AND LEFT(send_time,10) = '$date2_0'");
	$stmt->bind_param("sss",$_REQUEST['vMatricNo'], $_REQUEST["user_token"], $purpose);

// 	$stmt = $mysqli->prepare("SELECT ABS(TIMESTAMPDIFF(MINUTE,send_time,'$date2')), send_time, vtoken FROM veri_token
// 	WHERE vApplicationNo = ?
//     AND vtoken = ?
// 	AND LEFT(send_time,10) = '$date2_0'");
// 	$stmt->bind_param("ss",$_REQUEST['vMatricNo'], $_REQUEST["user_token"]);

	$stmt->execute();
	$stmt->store_result();
	
    if ($stmt->num_rows == 0)
    {
        echo 'Invalid token';exit;
    }

	$stmt->bind_result($send_time, $token);
	$stmt->fetch();
	
	$date1 = strtotime($send_time); 
	$date3 = strtotime($date2); 
	$diff = abs($date3 - $date1);
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24) / (60*60*24));
	$hours = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24 - $days * 60*60*24) / (60*60));
	$minutes = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24 - $days * 60*60*24 - $hours * 60*60) / 60);

	// $datetime_1 = $send_time; 
	// $datetime_2 = date("Y-m-d h:i:s");
	// $start_datetime = new DateTime($datetime_1); 
	// $diff = $start_datetime->diff(new DateTime($datetime_2)); 
	// $total_minutes = ($diff->days * 24 * 60);
	// $total_minutes += ($diff->h * 60);
	// $total_minutes += $diff->i;

    if ($minutes > 20)
    {
        //echo 'Token has expired. You may click the resend button to get another token';exit;
		echo 'Invalid token';exit;
    }    

    $stmt = $mysqli->prepare("UPDATE veri_token SET cused = cused + 1, used_time = '$date2', purpose = ? WHERE vApplicationNo = ? AND vtoken = ?");
    $stmt->bind_param("sss", $purpose, $_REQUEST['vMatricNo'], $_REQUEST["user_token"]); 
    $stmt->execute();
    $stmt->close();
    
    log_actv('Used token : '.$_REQUEST["user_token"]. " for ".$purpose);
    return 'Token valid';
}


function delete_std_pp_file($appl_frm)
{
	$mysqli = link_connect_db();

	$file_name_ext = '';

	$file_name_ext = '.jpg';

	$stmt_last = $mysqli->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? and cinfo_type = 'p'");
	$stmt_last->bind_param("s", $appl_frm);
	$stmt_last->execute();
	$stmt_last->store_result();
	$stmt_last->bind_result($vmask);
	$stmt_last->fetch();			
	$stmt_last->close();

	$search_file_name = DEL_FILE_NAME_FOR_PP."p_".$vmask.".jpg";
	$pix_file_name = BASE_FILE_NAME_FOR_PP.strtolower($_REQUEST["cFacultyId"])."/pp/p_".$vmask.".jpg";
	
	if(file_exists($pix_file_name))
	{                    
		if (copy($pix_file_name, $search_file_name))
		{
			@unlink($pix_file_name);
		}
	}

	@unlink(BASE_FILE_NAME_FOR_PP."p_" .$vmask.$file_name_ext);
}


function do_toup_div_prns($section)
{?>
	<a id="registered_student" href="#" style="display:none" 
		onclick="nxt.mm.value=0;nxt.sm.value=''; false">
		Faculty student
	</a>
	<div id="top" class="top_hed_prns" style="margin-top:8px; position:relative;">
		<div style="float:left; width:45px; height:inherit;">
			<img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>"  width="90%" height="90%" style="padding: 2%";/>
		</div>
		
		<div style="float:left; width:93%; text-align:left; height:auto; position:relative; font-size:x-large; color:#008000;">
			National Open University of Nigeria
			<div style="float:right; width:auto; height:auto; position:absolute; top: 30px; left:230px; color:#e31e24; font-size:12px;">
				Learn at any place at your pace...
			</div>
			<div style="width:auto; height:auto; position:absolute; top: 0px; right: 0px; color:#008000; font-size:11px">
				<?php echo $section;?>
			</div>
		</div>
	</div><?php
}


function select_curriculum($id)
{
	$mysqli = link_connect_db();

	$stmt = $mysqli->prepare("SELECT cAcademicDesc_1 from s_m_t WHERE vMatricNo = ?");
	$stmt->bind_param("s", $id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cAcademicDesc_1);
	$stmt->fetch();
	$stmt->close();
	
	//$new_curr = " AND b.cAcademicDesc <= 2023";
	
	$new_curr = " AND b.cAcademicDesc <= $cAcademicDesc_1";
	if ($cAcademicDesc_1 < 2017)
	{
		$new_curr = "";
	}
	
	if ($cAcademicDesc_1 > 2023)
	{
		//$new_curr = " AND b.cAcademicDesc = 2024";
	}

	return $new_curr;
}


function foriegn_rs()
{
	$mysqli = link_connect_db();

	$orgsetins = settns();

	$stmt = $mysqli->prepare("SELECT * FROM s_tranxion_cr a, s_m_t b 
	WHERE a.vMatricNo = b.vApplicationNo 
	AND b.vMatricNo = ? 
	AND vremark LIKE '%Application Fee' 
	AND amount IN ('8.00','12.00','32.00') 
	AND cTrntype = 'c' 
	AND b.cAcademicDesc = '".$orgsetins['cAcademicDesc']."'");
	
	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt->execute();
	$stmt->store_result();
	return $stmt->num_rows;
}


function cal_cgpa($cEduCtgId_loc)
{
	//return '';
	
	$mysqli = link_connect_db();

	$orgsetins = settns();
	
	$level_semester = array(array());
    $cnt = 0;
    
	
	//collect all results
	$table = search_starting_crs1($_REQUEST['vMatricNo']);
    
    $arr_all_reg_courses = array(array());
    $cnt = 0;
    foreach ($table as &$value)
    {
        $wrking_tab = 'coursereg_arch_'.$value;

        $stmt = $mysqli->prepare("SELECT cCourseId, vCourseDesc, iCreditUnit, cCategory
        FROM $wrking_tab  WHERE vMatricNo = ? 
        ORDER BY cCourseId");
        $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cCourseId_02, $vCourseDesc_02, $iCreditUnit_02, $cCategory_02);
        
        while($stmt->fetch())
        {
            $cnt++;
            $arr_all_reg_courses[$cnt]['cCourseId'] = $cCourseId_02;
            $arr_all_reg_courses[$cnt]['vCourseDesc'] = $vCourseDesc_02;
            $arr_all_reg_courses[$cnt]['iCreditUnit'] = $iCreditUnit_02;
            $arr_all_reg_courses[$cnt]['cCategory'] = $cCategory_02;
        }
    }

	$prev_session = '';
	$prev_level = '';

    $prev_sem = '';
    $sem_tcc = 0;
    $sem_tcp = 0;

    $cum_weight = 0;

    $tcp = 0;
	
	$gpa = 0;

	$weight = 0;

	$cCourseId_01 = '';
	$tSemester_03 = '';
	$iCreditUnit_01 = '';
	$siLevel_01 = '';

	$cAcademicDesc = '';

	$sem_count = 0;

	$cum_tcp = 0;
	
	$section_dis = 0;
	
	$coursecode_level_semester = '';
	
    $c = 0;
	//result summar
	foreach ($table as &$value)
    {
        $wrking_tab = 'examreg_result_'.$value;
        
    	$stmt = $mysqli->prepare("SELECT d.cCourseId, vCourseDesc, d.tSemester, a.iCreditUnit, cAcademicDesc, cgrade, iobtained_comp
    	FROM courses a, $wrking_tab d
    	WHERE a.cCourseId = d.cCourseId 
    	AND d.vMatricNo = ?
    	ORDER BY cAcademicDesc, d.tSemester, d.cCourseId");
    
        $stmt->bind_param("s", $_REQUEST['vMatricNo']);
        $stmt->execute();
        $stmt->store_result();
    	
        $stmt->bind_result($cCourseId_01, $vCourseDesc_01, $tSemester_03, $iCreditUnit_01, $cAcademicDesc, $cgrade_01, $score_01);
        if ($stmt->num_rows > 0 && $section_dis == 0)
    	{
    	    $section_dis = 1;?>
    		<!--<div class="appl_left_child_div_child calendar_grid" style="margin:0px;">
    			<div class="inlin_message_color" style="flex:100%; padding-top:15px; padding-right:4px; height:35px; text-align:left; text-indent:5px;">
    				Progress - click/tap each semester below to see detail
    			</div>
    		</div>--><?php
    	}
    	
    	while($stmt->fetch())
        {
            if ($prev_session <> '' && ($prev_sem == '' || $prev_sem <> $tSemester_03))
            {?>
                <div class="appl_left_child_div_child calendar_grid" style="font-weight: normal; margin:0px; margin-top:5px; cursor:pointer; background:#fff">
                    <div style="flex:25%; padding-top:5px; padding-right:4px; height:35px; text-align:right;">
                        .
                    </div>
                    <div style="flex:25%; padding-top:5px; padding-right:4px; height:35px; text-align:right;">
                        Total credit carried (TCC): <?php echo $sem_tcc;?>
                    </div>
                    <div style="flex:25%; padding-top:5px; padding-left:4px; height:35px; text-align:right;">
                        Total credit passed (TCP): <?php echo $sem_tcp; ?>
                    </div>
                    <div style="flex:25%; padding-top:5px; padding-right:4px; height:35px; text-align:right;">
                        Grade point average (GPA): <?php                    
                        if ($sem_tcp > 0)
                        {
                            echo round(($weight/$sem_tcp),1);
                        }else
                        {
                            echo 'To be determined';
                        }?>
                    </div>
                </div><?php
                
    			$cum_weight += $weight;
    			$tcp += $sem_tcp;
    
    			$weight = 0;
                $sem_tcp = 0;
    			$sem_tcc = 0;
    
    			$sem_count++;
    			
            	$level_semester[$sem_count]['semester'] = $prev_sem;
            	$level_semester[$sem_count]['cAcademicDesc'] = $prev_session;
            }
            
            if ($prev_sem == '' || ($prev_sem <> $tSemester_03))
            {?>
                <div class="appl_left_child_div_child calendar_grid" style="font-weight: normal; margin:0px; margin-top:5px; cursor:pointer; background:#fff">
                    <div style="flex:100%; padding-top:5px; padding-right:4px; height:35px; text-align:left; text-indent:5px">
                        <?php echo $cAcademicDesc.', Semester: '.$tSemester_03;?>
                    </div>
                </div><?php
            }
            
            
            
            for ($i = 1; $i <= count($arr_all_reg_courses); $i++)
            {
                if (isset($arr_all_reg_courses[$i]['cCourseId']) && $arr_all_reg_courses[$i]['cCourseId'] == $cCourseId_01)
                {
                    //echo ++$c.','.$cAcademicDesc.', '.$tSemester_03.', '.$cCourseId_01.', '.$iCreditUnit_01.', '.$cgrade_01.', '.$score_01.'<br>';
                    ?>
                    
                    <div class="appl_left_child_div" style="width:100%; margin:auto; height:auto; background-color:#eff5f0">
                        <div class="appl_left_child_div_child calendar_grid" style="font-weight: normal; margin:0px;">
                            <div style="flex:5%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                <?php echo ++$c;?>
                            </div>
                            <div style="flex:10%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                <?php echo $cCourseId_01;?>
                            </div>
                            <div style="flex:45%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                <?php echo $arr_all_reg_courses[$i]['vCourseDesc'];?>
                            </div>
                            <div style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                <?php echo $arr_all_reg_courses[$i]['iCreditUnit'];?>
                            </div>
                            <div style="flex:10%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                                <?php echo $arr_all_reg_courses[$i]['cCategory'];?>
                            </div>
                            <div style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                <?php echo $cgrade_01;?>
                            </div>
                            <div style="flex:5%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                <?php if ($cgrade_01 == 'F')
                                {
                                    echo 'Repeat';
                                }else if ($cgrade_01 == 'I')
                                {
                                    echo 'Incomplete';
                                }else
                                {
                                    echo '-';
                                }?>
                            </div>
                        </div>
                    </div><?php
                    
                    $sem_tcc += $iCreditUnit_01;
				
    				if ((($cEduCtgId_loc == 'PSZ' || $cEduCtgId_loc == 'ELX') && $cgrade_01 == 'F') || 
    				(($cEduCtgId_loc == 'PGX' || $cEduCtgId_loc == 'PGY' || $cEduCtgId_loc == 'PRX') && $cgrade_01 == 'E') ||
    				!is_numeric($score_01) || $score_01 > 100 || $cgrade_01 == '' || $cgrade_01 == 'I')
    				{
    					continue;
    				}
    					
					if ($score_01 >= 70)
					{
						$point = 5;
					}else if ($score_01 >= 60 && $score_01 <= 69)
					{
						$point = 4;
					}else if ($score_01 >= 50 && $score_01 <= 59)
					{
						$point = 3;
					}else if ($score_01 >= 45 && $score_01 <= 49)
					{
						$point = 2;
					}else if ($score_01 >= 40 && $score_01 <= 44)
					{
						$point = 1;
					}else if ($score_01 <= 39)
					{
						$point = 0;
					}
					
					
					$weight += $point*$iCreditUnit_01; 
					$sem_tcp += $iCreditUnit_01;
                }
            }
            
            
    		$prev_sem = $tSemester_03;
    		$prev_session = $cAcademicDesc;
        }
	    $stmt->close();
    }
    
    //result summary for last semester?>
     <div class="appl_left_child_div_child calendar_grid" style="font-weight: normal; margin:0px; margin-top:5px; cursor:pointer; background:#fff" 
		onclick="var ulChildNodes = _('par_name').getElementsByClassName('float_progress');
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			ulChildNodes[j].style.display = 'none';
			ulChildNodes[j].style.zIndex = 0;
		}  
		_('<?php echo $prev_session.'_'.$prev_sem;?>').style.display='flex'; 
		_('<?php echo $prev_session.'_'.$prev_sem;?>').zIndex=2;
		_('<?php echo $prev_session.'_'.$prev_sem."_tcc"; ?>').innerHTML='Total credit carried (TCC): <?php echo $sem_tcc;?>';
		_('<?php echo $prev_session.'_'.$prev_sem."_tcp"; ?>').innerHTML='Total credit passed (TCP): <?php echo $sem_tcp;?>';
		_('<?php echo $prev_session.'_'.$prev_sem."_gpa"; ?>').innerHTML='Grade point average (GPA):<?php
		    if ($sem_tcp > 0)
            {
                echo round(($weight/$sem_tcp),1);
            }else
            {
                echo 'To be determined';
            }?>';"> 
        <div style="flex:25%; padding-top:5px; padding-right:4px; height:35px; text-align:right;">
            <?php echo $prev_session.', Semester: '.$prev_sem;?>
        </div>
        <div style="flex:25%; padding-top:5px; padding-right:4px; height:35px; text-align:right;">
            Total credit carried (TCC): <?php echo $sem_tcc;?>
        </div>
        <div style="flex:25%; padding-top:5px; padding-left:4px; height:35px; text-align:right;">
            Total credit passed (TCP): <?php echo $sem_tcp; ?>
        </div>
        <div style="flex:25%; padding-top:5px; padding-right:4px; height:35px; text-align:right;">
            Grade point average (GPA): <?php                    
            if ($sem_tcp > 0)
            {
                echo round(($weight/$sem_tcp),1);
            }else
            {
                echo 'To be determined';
            }?>
        </div>
    </div><?php
    
    $cum_weight += $weight;
    $tcp += $sem_tcp;?>
	
	<!--cumm calcs -->
	<div class="appl_left_child_div_child calendar_grid" style="font-weight: bold; margin:0px;">
		<div style="flex:10%; padding-top:5px; padding-right:4px; height:35px; text-align:right;"></div>
		<div style="flex:30%; padding-top:5px; padding-right:4px; height:35px; text-align:right;"></div>
		<div style="flex:30%; padding-top:5px; padding-left:4px; height:35px; text-align:right;">
		   Cummulative total credit passed (CTCP): <?php
    			echo $tcp;?>
		</div>
		<div style="flex:30%; padding-top:5px; padding-right:4px; height:35px; text-align:right;">
			Cummulative GPA (CGPA): <?php 
			 if($orgsetins["cShowgpa"] == '1' && $orgsetins["cShowrslt_for_student"] == '1')
			 {
				$gpa = 0;            
				if ($tcp > 0)
				{
					$gpa = round(($cum_weight/$tcp),1); 
				}
				echo $gpa;
				gpa_class($gpa);
			 }else
			 {
				echo '-';
			}?>
		</div>
	</div><?php

	$level_semester[$sem_count+1]['semester'] = $prev_sem;
	$level_semester[$sem_count+1]['cAcademicDesc'] = $prev_session;
	return $level_semester;
}


function gpa_class($gpa)
{
	if ($gpa >= 4.5)
	{
		echo ' 1st Class';
	}else if ($gpa >= 3.5 && $gpa <= 4.49)
	{
		echo ' 2nd Class Upper';
	}else if ($gpa >= 2.5 && $gpa <= 3.49)
	{
		echo ' 2nd Class Lower';
	}else if ($gpa >= 1.5 && $gpa <= 2.49)
	{
		echo ' 3rd Class';
	}else if ($gpa >= 1.0 && $gpa <= 1.49)
	{
		echo ' Pass';
	}
}



function check_file($size, $case)
{
	$filepath = $_FILES['sbtd_pix']['tmp_name'];
	$fileSize = filesize($filepath);
	$fileinfo = finfo_open(FILEINFO_MIME_TYPE);
	$filetype = finfo_file($fileinfo, $filepath);

	if ($fileSize == 0)
	{
		return 'Cannot upload empty file';
	}

	if ($fileSize > $size/1000000)
	{ // 3 MB (1 byte * 1024 * 1024 * 3 (for 3 MB))
		if ($case == 1)
		{
			return "The file is too large. Max is ".($size/1000000)."MB";
		}else if ($case == 2)
		{
			return "The file is too large. Max is ".($size/1000)."KB";
		}
	}

	if ($case == 1)
	{
		$allowedTypes = array(
			'text/csv',
			'application/csv',
			'text/comma-separated-values',
			'text/anytext',
			'application/octet-stream',
			'application/txt',
		);
	}else if ($case == 2)
	{
		$allowedTypes = array(
			'image/jpeg',
		);

		//$image_properties = getimagesize($filepath);
	}

	if (!in_array($filetype, $allowedTypes))
	{
		if ($case == 1)
		{
			return "Select a csv file to upload";
		}else if ($case == 2)
		{
			return "Select a jpg file to upload";
		}
	}

	return '';
}



function wallet_bal_std()
{
	$mysqli = link_connect_db();

	$balance = 0;
	
	$stmt = $mysqli->prepare("select  SUM(`amount`) 
	from s_tranxion_cr
	where vMatricNo = ?");
	$stmt->bind_param("s", $_REQUEST['vMatricNo']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($Amount_a);
	$stmt->fetch();
	
	if(substr($_REQUEST['vMatricNo'],3,2) <= 19)
	{
		//$tables = '20172019,20202021,20222023,20242025';
		$tables = '2017,2018,2019,20202021,20222023,20242025';
	}else if(substr($_REQUEST['vMatricNo'],3,2) == 20 || substr($_REQUEST['vMatricNo'],3,2) == 21)
	{
		$tables = '20202021,20222023,20242025';
	}else if(substr($_REQUEST['vMatricNo'],3,2) == 22 || substr($_REQUEST['vMatricNo'],3,2) == 23)
	{
		$tables = '20222023,20242025';
	}else
	{
		$tables = '20242025';
	}
	
	$table = explode(",", $tables);

    $wallet_trn_cnt = 0;
    
    foreach ($table as &$value)
    {
        $wrking_tab = 's_tranxion_'.$value;
	
    	$stmt = $mysqli->prepare("select  SUM(`amount`) 
    	from $wrking_tab
    	where vMatricNo = ?");
    	$stmt->bind_param("s", $_REQUEST['vMatricNo']);
    	$stmt->execute();
    	$stmt->store_result();
    	$stmt->bind_result($Amount_b);
    	$stmt->fetch();
    	
    	$Amount_a -= $Amount_b;
    }
	$stmt->close();
	
	return $Amount_a;
}?>