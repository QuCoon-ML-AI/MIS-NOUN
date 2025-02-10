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
    <!--<link rel="shortcut icon" type="image/ico" href="https://www.datatables.net/favicon.ico">-->
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
		document.onkeydown = function (e) 
		{
			if (e.ctrlKey && e.keyCode === 85) 
			{
				return false;
			}
		}

        
		//check_environ();
			
		function chk_inputs()
		{
			var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
			for (j = 0; j <= ulChildNodes.length-1; j++)
			{
				ulChildNodes[j].style.display = 'none';
			}

            var files = _("sbtd_pix").files;
            var formdata = new FormData();
            
            
            _('conf_box_loc').style.display = 'none';
            _('conf_box_loc').style.zIndex = '-1';
            _('smke_screen_2').style.display = 'none';
            _('smke_screen_2').style.zIndex = '-1';

            if (_('container_cover_in_chkps').style.display != 'none')
            {

                if (_('number_of_request').value == 0)
                {
                    caution_box("There are no pending request");
                    return false;
                }

                box_checked = 0;
                for (cnt = 1; cnt <= _('number_of_request').value; cnt++)
                {
                    mat_chk = "mat_chk"+cnt;
                    coldlevel = "coldlevel"+cnt;
                    cnewlevel = "cnewlevel"+cnt;
                    
                    coldsemester = "coldsemester"+cnt;
                    cnewsemester = "cnewsemester"+cnt;

                    if (_(mat_chk).checked)
                    {                            
                        candidate = _(mat_chk).value+','+_(coldlevel).value+','+_(cnewlevel).value+','+_(coldsemester).value+','+_(cnewsemester).value;    
                        formdata.append(mat_chk, candidate);
                        box_checked++;
                    }
                }

                if (box_checked == 0)
                {
                    caution_box("Check one or more boxes");
                    return false;
                }
                
                formdata.append("number_of_request", _("number_of_request").value);                

                if (sc_1_loc.conf.value != '1')
                {
                    _("conf_msg_msg_loc").innerHTML = 'Levels and semesters will be updated<br>Continue?';
                    _('conf_box_loc').style.display = 'block';
                    _('conf_box_loc').style.zIndex = '5';
                    _('smke_screen_2').style.display = 'block';
                    _('smke_screen_2').style.zIndex = '4';

                    return;
                }                
            }else if (_("sbtd_pix").files.length == 0)
            {
                if (sc_1_loc.uvApplicationNo.value == '')
                {
                    setMsgBox("labell_msg0","");
                    sc_1_loc.uvApplicationNo.focus();
                    return false;
                }
                
                if (_("ans8").style.display == 'block')
                {                
                    if (_("courseLevel_2_0").style.display == 'block')
                    {
                        if (_("courseLevel_2_0").value == '')
                        {
                            setMsgBox("labell_msg39","");
                            _("courseLevel_2_0").focus();
                            return false;
                        }
                    }else if (_("courseLevel_2_1").style.display == 'block')
                    {
                        if (_("courseLevel_2_1").value == '')
                        {
                            setMsgBox("labell_msg39","");
                            _("courseLevel_2_1").focus();
                            return false;
                        }
                    }

                    
                    
                    if (_("semester_2").value == '')
                    {
                        setMsgBox("labell_msg40","");
                        _("semester_2").focus();
                        return false;
                    }
                }
                
                
                // if (_("conf_box_loc").style.display == 'block')
                // {
                //     if (_('veri_token').value == '')
                //     {
                //         setMsgBox('labell_msg_token','Token required');
                //         return false;
                //     }
                    
                //     if (_('veri_token').value != _('hd_veri_token').value)
                //     {
                //         setMsgBox('labell_msg_token','Invalid token');
                //         return false;
                //     }
                // }

                if (sc_1_loc.conf.value == '1')
                {
                    formdata.append("conf", sc_1_loc.conf.value);

                    if (_("courseLevel_2_0").style.display == 'block')
                    {
                        formdata.append("courseLevel_2", _("courseLevel_2_0").value);
                    }else if (_("courseLevel_2_1").style.display == 'block')
                    {
                        formdata.append("courseLevel_2", _("courseLevel_2_1").value);
                    }
                    
                    formdata.append("level_now", _("level_now").value);
                    formdata.append("semester_2", _("semester_2").value);

                    //formdata.append("veri_token", _("hd_veri_token").value);
                }

                if (_("ans8").style.display == 'none')
                {
                    formdata.append("process_step", '1');
                }else  if (_("ans8").style.display == 'block')
                {
                    formdata.append("process_step", '2');
                }

                formdata.append("id_no", sc_1_loc.id_no.value);
                
                formdata.append("uvApplicationNo", sc_1_loc.uvApplicationNo.value);
            }else
            {
                if (sc_1_loc.conf.value != '1')
                {
                    _("conf_msg_msg_loc").innerHTML = 'Levels and semesters will be updated<br>Continue?';
                    _('conf_box_loc').style.display = 'block';
                    _('conf_box_loc').style.zIndex = '3';
                    _('smke_screen_2').style.display = 'block';
                    _('smke_screen_2').style.zIndex = '2';

                    return;
                }
                
                formdata.append("conf", sc_1_loc.conf.value); 
                formdata.append("sbtd_pix", _("sbtd_pix").files[0]);
            }

            formdata.append("whattodo", _("whattodo").value);
            
            formdata.append("ilin", _("ilin").value);
            formdata.append("user_cat", sc_1_loc.user_cat.value);

            formdata.append("vApplicationNo", sc_1_loc.vApplicationNo.value);
            formdata.append("sm", sc_1_loc.sm.value);
            formdata.append("mm", sc_1_loc.mm.value);
            
            formdata.append("staff_study_center", sc_1_loc.user_centre.value);
            
            formdata.append("sRoleID", _('sRoleID').value);

            if (_('over_ride_callendar'))
            {
                if (sc_1_loc.over_ride_callendar.checked)
                {
                    formdata.append("over_ride_callendar", 1);
                }
            }
            
		    opr_prep(ajax = new XMLHttpRequest(),formdata);
		}

	
        function opr_prep(ajax,formdata)
        {
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "opr_level_change.php");
            ajax.send(formdata);
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

        function completeHandler(event)
        {
            on_error('0');
            on_abort('0');
            in_progress('0');

            var returnedStr = event.target.responseText;
            
            var files = _("sbtd_pix").files;

            if (_('container_cover_in_chkps').style.display != 'none')
            {
                if (returnedStr.indexOf("success") != -1)
                {
                    success_box(returnedStr);
                }else
                {
                    caution_box(returnedStr);
                }
            }else if (returnedStr.indexOf("above requested level") != -1 ||
            returnedStr.indexOf("not registered for the semester") != -1)
            {
                caution_box(returnedStr);
            }else if (_("sbtd_pix").files.length == 0)
            {
                if (_("whattodo"))
                { 
                    var plus_ind = returnedStr.indexOf("+");
                    var at_ind = returnedStr.indexOf("@");
                    var dol_ind = returnedStr.indexOf("$");
                    var car_ind = returnedStr.indexOf("^");
                    var ash_ind = returnedStr.indexOf("#");
                    var perc_ind = returnedStr.indexOf("%");
                    var bang_ind = returnedStr.indexOf("!");
                    var tild_ind = returnedStr.indexOf("~");
                    
                    var mask = '';

                    returnedStr = returnedStr.trim();


                    if (returnedStr.indexOf("success") == -1 && returnedStr.charAt(0) != '*' && returnedStr.indexOf("?") == -1)
                    {
                        if (_("id_no") && _("id_no").value == 0)
                        {
                            _("std_names").innerHTML = returnedStr.substr(0, 100).trim()+'<br>'+
                            returnedStr.substr(100, 100).trim()+'<br>'+
                            returnedStr.substr(200, 100).trim();
                            student_name = returnedStr.substr(0, 100).trim()+' '+returnedStr.substr(100, 100).trim()+' '+returnedStr.substr(200, 100).trim();

                            _("std_quali").innerHTML = returnedStr.substr(300, 100).trim()+'<br>'+
                            returnedStr.substr(400, 100).trim();
                            student_qualif = returnedStr.substr(300, 100).trim()+' '+returnedStr.substr(400, 100).trim()
                            
                            if (returnedStr.substr(500, 100).trim() == 20)
                            {
                                _("std_lvl").innerHTML = 'DIP 1';
                            }else if (returnedStr.substr(500, 100).trim() == 30)
                            {
                                _("std_lvl").innerHTML = 'DIP 2';
                            }else
                            {
                                _("std_lvl").innerHTML = returnedStr.substr(500, 100).trim()+' Level';
                            }
                            
                            _('level_now').value = returnedStr.substr(500, 100).trim();

                            student_level = _("std_lvl").innerHTML;
                            _("std_lvl").style.display = 'block';

                            _("std_sems").innerHTML = '';
                            _("std_sems").style.display = 'none';
                            student_semester = '';
                            
                            _("std_vCityName").innerHTML = returnedStr.substr(700, 100).trim();
                            _("std_vCityName").style.display = 'block';
                            student_center =  _("std_vCityName").innerHTML;

                            facult_id = returnedStr.substr(800,100);

                            student_faculty = returnedStr.substr(900,100).trim();
                            student_dept = returnedStr.substr(1000,100).trim();

                            _("user_cEduCtgId").value = returnedStr.substr(1200,100).trim();

                            mask = returnedStr.substr(1400).trim();

                            
                            _('courseLevel_2_0').style.display = 'block';
                            _('courseLevel_2_1').style.display = 'none';
                        }else if (_("id_no") && _("id_no").value == 1)
                        {
                            _('app_frm_no').value = returnedStr.substr(0,(plus_ind-2));
                            _("std_names").innerHTML = returnedStr.substr(100, 100).trim()+'<br>'+
                            returnedStr.substr(200, 100).trim()+'<br>'+
                            returnedStr.substr(300, 100).trim();
                            student_name = returnedStr.substr(100, 100).trim()+' '+returnedStr.substr(200, 100).trim()+' '+returnedStr.substr(300, 100).trim();

                            _("std_quali").innerHTML = returnedStr.substr(400, 100).trim()+'<br>'+
                            returnedStr.substr(500, 100).trim();
                            student_qualif = returnedStr.substr(400, 100).trim()+' '+returnedStr.substr(500, 100).trim();
                            
                            if (returnedStr.substr(600, 100).trim() == 20)
                            {
                                _("std_lvl").innerHTML = 'DIP 1';
                            }else if (returnedStr.substr(600, 100).trim() == 30)
                            {
                                _("std_lvl").innerHTML = 'DIP 2';
                            }else
                            {
                                _("std_lvl").innerHTML = returnedStr.substr(600, 100).trim()+' Level';
                            }
                            
                            _('level_now').value = returnedStr.substr(600, 100).trim();
                            
                            _("std_lvl").style.display = 'block';
                            student_level = _("std_lvl").innerHTML;

                            if (returnedStr.substr(700, 100).trim() == 1)
                            {
                                if (_("std_sems")){_("std_sems").innerHTML = 'First semester';}
                            }else if (returnedStr.substr(700, 100).trim() == 2)
                            {
                                if (_("std_sems")){_("std_sems").innerHTML = 'Second semester';}
                            }

                            _("std_sems").innerHTML = returnedStr.substr(700, 100).trim();
                            _("std_sems").style.display = 'block';
                            student_semester = _("std_sems").innerHTML;
                            
                            _("std_vCityName").innerHTML = returnedStr.substr(800, 100).trim();				
                            _("std_vCityName").style.display = 'block';
                            student_center =  _("std_vCityName").innerHTML;

                            facult_id = returnedStr.substr(900,100);

                            student_faculty = returnedStr.substr(1000,100).trim();
                            student_dept = returnedStr.substr(1100,100).trim();

                            _("user_cEduCtgId").value = returnedStr.substr(1300,100).trim();
                            
                            mask = returnedStr.substr(1600,100).trim();
                            
                            _("std_lvl").innerHTML = _("std_lvl").innerHTML;
                            
                            _('courseLevel_2_0').style.display = 'none';
                            _('courseLevel_2_1').style.display = 'block';
                        }

                        _("div_a").innerHTML = _("sc_1_loc").uvApplicationNo.value;
                    
                        if (_("id_no").value == 0)
                        {
                            _('app_frm_no').value = _("div_a").innerHTML;
                        }
                        
                        _("div_0").innerHTML = student_name;//name
                        _("div_1").innerHTML = student_center;
                        
                        _("div_2").innerHTML = student_faculty;//faculty
                        _("div_3").innerHTML = student_dept;//dept
                        _("div_4").innerHTML = student_qualif;//programme
                        _("div_5").innerHTML = student_level;//level

                        if (student_semester != '')
                        {
                            _("div_5").innerHTML = returnedStr.substr(1500,100).trim()+'/'+student_level+'/'+student_semester;//level/semester
                        }
                        
                        if (_("id_no").value == 0)
                        {
                            _("div_lab_a").innerHTML = 'Application form number';
                        }else if (_("id_no").value == 1)
                        {
                            _("div_lab_a").innerHTML = 'Matriculation number';
                        }
                        
                        _("ans6").style.display = 'block';
                        _("ans8").style.display = 'block';

                        first_no = 0;
                        last_no = 0;
                        if (_("user_cEduCtgId").value == 'PGX')//PGD
                        {
                            first_no = 700;
                            last_no = 700;
                        }else if (_("user_cEduCtgId").value == 'PGY')//masters
                        {
                            first_no = 800;
                            last_no = 800;
                        }else if (_("user_cEduCtgId").value == 'PGZ')//mphil
                        {
                            first_no = 900;
                            last_no = 900;
                        }else
                        {
                            first_no = 1000;
                            last_no = 1000;
                        }
                        
                        
                        if (_("courseLevel_2_0").style.display == 'block')
                        {
                            if (_("user_cEduCtgId").value == 'PSZ')//UG
                            {
                                first_no = 100;
                                last_no = 300;
                            }

                            _("courseLevel_2_0").options.length = 0;
                            _("courseLevel_2_0").options[_("courseLevel_2_0").options.length] = new Option('', '');
                            for (next = first_no; next <= last_no; next+=100)
                            {
                                _("courseLevel_2_0").options[_("courseLevel_2_0").options.length] = new Option(next, next);
                            }
                        }else if (_("courseLevel_2_1").style.display == 'block')
                        {
                            if (_("user_cEduCtgId").value == 'PSZ')//UG
                            {
                                first_no = 100;
                                last_no = 500;
                            }
                            
                            _("courseLevel_2_1").options.length = 0;
                            _("courseLevel_2_1").options[_("courseLevel_2_1").options.length] = new Option('', '');
                            for (next = first_no; next <= last_no; next+=100)
                            {
                                _("courseLevel_2_1").options[_("courseLevel_2_1").options.length] = new Option(next, next);
                            }
                        }
                    }
                    
                    returnedStr = returnedStr.substr(ash_ind+1);
                    
                    if (returnedStr.indexOf("success") != -1)
                    {
                        success_box(returnedStr.substr(1,returnedStr.length-1));
                        
                        _("courseLevel_2_0").value = '';
                        _("courseLevel_2_1").value = '';

                        _("semester_2").value = '';
                        // _("hd_veri_token").value = '';
                        // _("veri_token").value = '';

                        _('conf_box_loc').style.display='none';
                        _('smke_screen_2').style.display='none';
                        _('smke_screen_2').style.zIndex='-1';
                    }else  if (returnedStr.indexOf("?") != -1)
                    {                    
                        //_("hd_veri_token").value = returnedStr.substr(0,6);

                        //_("conf_msg_msg_loc").innerHTML = returnedStr.substr(6);

                        _("conf_msg_msg_loc").innerHTML = returnedStr;
                        _('conf_box_loc').style.display = 'block';
                        _('conf_box_loc').style.zIndex = '3';
                        _('smke_screen_2').style.display = 'block';
                        _('smke_screen_2').style.zIndex = '2';
                    }else  if (returnedStr.charAt(0) == '*')
                    {
                        caution_box(returnedStr.substr(1,returnedStr.length-1));                  
                    }
                    
                    if (returnedStr.indexOf("success") == -1 && returnedStr.indexOf("?") == -1)
                    {
                        if (_("id_no") && _("id_no").value == 0 && returnedStr.indexOf('not yet submitted') != -1)
                        {
                            _("passprt").src = '../appl/img/left_side_logo.png';
                        }else
                        {
                            _("passprt").src = mask;
                            _("passprt").onerror = function() {myFunction()};
                            
                            if (_("id_no") && _("id_no").value == 1)
                            {
                                sc_1_loc.uvApplicationNo_loc.value = _('app_frm_no').value;
                            }

                            function myFunction() 
                            {
                                _("passprt").src = '../appl/img/left_side_logo.png';
                            }
                        }
                    }
                }
            }else
            {
                _('conf_box_loc').style.display='none';
                _('smke_screen_2').style.display='none';
                _('smke_screen_2').style.zIndex='-1';
                
                if (returnedStr.indexOf("success") != -1)
                {
                    success_box(returnedStr);
                }else
                {
                    caution_box(returnedStr);
                }
            }
            sc_1_loc.conf.value = ''
        }

        
        function tidy_screen()
        {        
            _("ans6").style.display = 'none';
            _("ans8").style.display = 'none';
            
            sc_1_loc.conf.value = '';
            
            var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
            for (j = 0; j <= ulChildNodes.length-1; j++)
            {
                ulChildNodes[j].style.display = 'none';
            }

            _("user_cEduCtgId").value = '';

            if (sc_1_loc.uvApplicationNo.value.trim() != '')
            {
                sc_1_loc.sbtd_pix.value = '';
            }

            if (sc_1_loc.sbtd_pix.value.trim() != '')
            {
                sc_1_loc.uvApplicationNo.value = '';
            }
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
                    { data: 'col3'},
                    { data: 'col4'},
                    { data: 'col5'},
                    { data: 'col6'},
                    { data: 'col7'},
                ],
                dom: 'Bfrtip',
                
                buttons: 
                [
                    {
                        extend: 'excelHtml5',
                        title: 'Pending requests for change of level',
                        exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6] },
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Pending requests for change of level',
                        exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6] },
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
    </style>
	<noscript></noscript>
</head>


<body onLoad="checkConnection()">
    <?php admin_frms(); $has_matno = 0;?>
	
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
            <input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID_u ?>" />
            
            <div id="conf_box_loc" class="center" style="display:none; width:400px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
                <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                    Confirmation
                </div>
                <a href="#" style="text-decoration:none;">
                    <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
                </a>
                <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:100%; float:left; text-align:center; padding:0px;"></div>
                <div style="margin-top:10px; width:100%; float:left; text-align:right; padding:0px;">
                    <a href="#" style="text-decoration:none;" 
                        onclick="sc_1_loc.conf.value = '1';
                        chk_inputs(); 
                        return false">
                        <div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
                            Yes
                        </div>
                    </a>

                    <a href="#" style="text-decoration:none;" 
                        onclick="sc_1_loc.conf.value='';
                        _('conf_box_loc').style.display='none';
                        _('smke_screen_2').style.display='none';
                        _('smke_screen_2').style.zIndex='-1';
                        //_('hd_veri_token').value = '';
                        //_('veri_token').value = '';
                        return false">
                        <div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
                            No
                        </div>
                    </a>
                </div>
            </div>

            <div class="innercont_top" style="margin-bottom:0px;">Student's request - Change level</div>
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
            </form>

            <form action="student-requests" method="post" name="sc_1_loc" id="sc_1_loc" enctype="multipart/form-data">
                <input name="save_cf" id="save_cf" type="hidden" value="-1" />
                <input name="tabno" id="tabno" type="hidden" 
                    value="<?php if (isset($_REQUEST['tabno'])){echo $_REQUEST['tabno'];}else{echo '0';} ?>"/>
                <input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                <input name="user_cEduCtgId" id="user_cEduCtgId" type="hidden" value="go"/>

                <input name="uvApplicationNo_loc" id="uvApplicationNo_loc" type="hidden" />
                <input name="app_frm_no" id="app_frm_no" type="hidden" />
                <input name="tSemester" id="tSemester" type="hidden" value="<?php echo $tSemester; ?>" />
                <input name="whattodo" id="whattodo" type="hidden" value="<?php if(isset($_REQUEST['whattodo'])){echo $_REQUEST['whattodo'];}else{echo '';}?>" />
                
                <input name="process_step" id="process_step" type="hidden" value="" /><?php 
                frm_vars();
				$show_bilk = 'none';
				if (check_scope3('Academic registry', 'Student request', 'Request for change of level') > 0)
				{
					$show_bilk = 'block';
				}?>

				<div id="container_cover_in_chkps" style="display: <?php echo $show_bilk;?>; 
					flex-direction:column; 
					gap:8px;  
					justify-content:space-around; 
					height:auto;
					padding:10px;
					box-shadow: 2px 2px 8px 2px #726e41;
					z-Index:3;
					background-color:#fff;
                    position: absolute;
                    top:100px;
                    left:25px;
					max-height:550px;
					overflow:auto;
					overflow-x: hidden;
                    width:55vw" 
					title="Press escape to close">
					<div style="line-height:1.5; width:70%; font-weight:bold; margin-bottom:20px;">
						Pending requests for change of level
					</div>
					<div style="line-height:1.5; width:20px; position:absolute; top:10px; right:10px; margin-bottom:20px;">
						<img style="width:17px; height:17px; cursor:pointer" src="./img/close.png" 
						onclick="_('container_cover_in_chkps').style.zIndex = -1;
							_('container_cover_in_chkps').style.display = 'none';"/>
					</div>

					<table id="gridz" class="table table-condensed table-responsive" style="width:100%;">
						<thead>
							<tr>
								<th style="text-align:right; padding-right:5%; width:13%">Sn</th>
								<th style="width:17%">Matriculation number</th>
								<th style="width:15%">Current level</th>
								<th style="width:15%">Requested level</th>
								<th style="width:12%">Current semester</th>
								<th style="width:14%">Requested semester</th>
								<th style="width:9%">Date</th>
							</tr>
						</thead><?php				
						$stmt = $mysqli->prepare("SELECT vMatricNo, coldlevel, cnewlevel, coldsemester, cnewsemester, level_req_date FROM student_request_log_1 
                        WHERE level_req = '1'
                        AND req_granted = '0'
                        AND req_canceled = '0'
                        AND level_req_date >= '$semester_begin_date'");
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($vMatricNo, $coldlevel, $cnewlevel, $coldsemester, $cnewsemester, $level_req_date);
						$cnt = 0;?>
						<tbody><?php
                            //for ($x = 0; $x < 10; $x++)
                            //{
                            //    $stmt->data_seek(0);
                                while($stmt->fetch())
                                {
                                    $cnt++;
                                    if ($cnt%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
                                    <tr style="background-color:<?php echo $background_color;?>;">
                                        <td style="text-align:right; padding-right:5%"><?php echo $cnt;?></td>
                                        <td>
                                            <label for="mat_chk<?php echo $cnt;?>" class="lbl_beh">
                                                <input name="mat_chk<?php echo $cnt;?>" id="mat_chk<?php echo $cnt;?>" type="checkbox" value="<?php echo $vMatricNo;?>" style="margin:0px" checked/>
                                                <?php echo ' '.$vMatricNo;?>
                                            </label>
                                        </td>
                                        <td><?php echo $coldlevel;?></td>
                                        <td><?php echo $cnewlevel;?></td>
                                        <td><?php echo $coldsemester;?></td>
                                        <td><?php echo $cnewsemester;?></td>
                                        <td><?php echo formatdate($level_req_date, 'fromdb');?></td>
                                        <input name="coldlevel<?php echo $cnt;?>" id="coldlevel<?php echo $cnt;?>" type="hidden" value="<?php echo $coldlevel; ?>" />
                                        <input name="cnewlevel<?php echo $cnt;?>" id="cnewlevel<?php echo $cnt;?>" type="hidden" value="<?php echo $cnewlevel; ?>" />
                                        <input name="coldsemester<?php echo $cnt;?>" id="coldsemester<?php echo $cnt;?>" type="hidden" value="<?php echo $coldsemester; ?>" />
                                        <input name="cnewsemester<?php echo $cnt;?>" id="cnewsemester<?php echo $cnt;?>" type="hidden" value="<?php echo $cnewsemester; ?>" />
                                    </tr><?php
                                }
                            //}
							$stmt->close();?>
						</tbody>
					</table>
                    <input name="number_of_request" id="number_of_request" type="hidden" value="<?php echo $cnt; ?>" />
				</div><?php
                
                require_once("student_requests.php");
                
                $currentDate = date('Y-m-d');
                
                $statuss = '';
                
                if (check_scope3('System admin', 'User', 'Over-ride Calendar') > 0)
                {?>
                    <div class="innercont_stff" style="margin-top:5px;">
                        <label class="labell" style="width:240px; margin-left:5px;"></label>
                        <div class="div_select">
                            <label for="over_ride_callendar" class="labell" style="width:auto; text-align:left; cursor:pointer;">
                                <input name="over_ride_callendar" id="over_ride_callendar" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"
                                onclick="if (this.checked)
                                {
                                    sc_1_loc.sbtd_pix.disabled = false
                                }"
                                <?php if ($sRoleID_u <> 6){echo 'disabled';}?>/>
                                Over-ride calendar
                            </label>
                        </div>
                    </div><?php
                }
                
                
                if ($reg_open_300 <> 1)
                {
                    $statuss = 'disabled';
                }?>

                <div class="innercont_stff" style="margin-top:20px;" title="Only CSV file">
                    <label for="sbtd_pix" class="labell" style="width:240px; margin-left:5px;">Upload csv file (batch update)</label>
                    <div class="div_select">
                        <input type="file" name="sbtd_pix" id="sbtd_pix" style="width:223px" <?php echo $statuss;?>
                        onchange="sc_1_loc.uvApplicationNo.value=''; 
                        tidy_screen();">
                    </div>
                    <div class="labell_msg blink_text orange_msg" id="labell_msg"  style="width:280px"></div>		
                </div>

                <div class="innercont_stff">
                    <div class="div_select" style="width:240px;">
                        <select name="id_no" id="id_no" class="select" 
                        onchange="sc_1_loc.uvApplicationNo.value=''; 
                        tidy_screen();">
                            <option value="0">Application form number (AFN)</option>
                            <option value="1" selected>Matriculation number</option>
                        </select>
                    </div>

                    <div id="uvApplicationNo_div" class="div_select" style="display:block">
                        <input name="uvApplicationNo" id="uvApplicationNo" type="text" class="textbox"  
                        placeholder="Enter AFN/Mat. no. here"
                        onchange="this.value=this.value.trim();
                        this.value=this.value.toUpperCase();
                        tidy_screen()" />
                    </div>
                    <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
                </div>

                <div class="innercont_stff_tabs" id="ans6" style="border:0px; height:auto; margin-left:1px; margin-top:10px; width:800px;">
                    <div class="innercont_stff" style="margin-bottom:-1px;">
                        <div id="div_lab_a" class="div_label" style="width:239px;">
                            Matriculation number
                        </div>
                        <div id="div_a" class="div_valu"></div>	
                    </div>
                    <div class="innercont_stff">
                        <div class="div_label" style="width:239px;">
                            Name
                        </div>
                        <div id="div_0" class="div_valu"></div>	
                    </div>
                    
                    <div class="innercont_stff">
                        <div class="div_label" style="width:239px;">
                            Study centre
                            <input id="studycentre_now" type="hidden"/>
                        </div>
                        <div id="div_1" class="div_valu"></div>	
                    </div>
                    
                    <div class="innercont_stff">
                        <div class="div_label" style="width:239px;">
                            Faculty
                        </div>
                        <div id="div_2"  class="div_valu"></div>	
                    </div>
                    <div class="innercont_stff">
                        <div class="div_label" style="width:239px;">
                            Department
                        </div>
                        <div id="div_3"  class="div_valu"></div>	
                    </div>
                    <div class="innercont_stff">
                        <div class="div_label" style="width:239px;">
                            Programme
                            <input id="programme_now" type="hidden"/>
                        </div>
                        <div id="div_4"  class="div_valu"></div>	
                    </div>
                    <div class="innercont_stff">
                        <div class="div_label" style="width:239px;">
                            Begin level/Currrent level/Semester
                            <input id="level_now" type="hidden"/>
                        </div>
                        <div id="div_5"  class="div_valu"></div>	
                    </div>
                </div>
                <div class="innercont_stff_tabs" id="ans8" style="display:none; border:0px; height:auto; margin-left:1px; margin-top:10px;">
                    <div class="innercont_stff">
                        <div class="div_label" style="width:239px;">
                            New level
                        </div>
                        <div class="div_select">
                            <select name="courseLevel_2_0" id="courseLevel_2_0" class="select" style="display:block">
                                <option value="" selected="selected"></option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option><?php
                                for ($t = 100; $t <= 1000; $t+=100)
                                {?>
                                    <option value="<?php echo $t ?>"><?php echo $t;?></option><?php
                                }?>
                            </select>

                            <select name="courseLevel_2_1" id="courseLevel_2_1" class="select" style="display:none">
                                <option value="" selected="selected"></option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option><?php
                                for ($t = 100; $t <= 1000; $t+=100)
                                {?>
                                    <option value="<?php echo $t ?>"><?php echo $t;?></option><?php
                                }?>
                            </select>
                        </div>
                        <div id="labell_msg39" class="labell_msg blink_text orange_msg"></div>
                    </div>

                    <div class="innercont_stff">
                        <div class="div_label" style="width:239px;">
                            New semester
                        </div>
                        <div class="div_select">
                            <select name="semester_2" id="semester_2" class="select"
                                onchange="if(_('id_no').value=='0'&&this.value!=1){this.value=1;}">
                                <option value="" selected="selected"></option><?php
                                for ($i = 0; $i <= 16; $i++)
                                {?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option><?php
                                }?>
                            </select>
                        </div>
                        <div id="labell_msg40" class="labell_msg blink_text orange_msg"></div>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="rightSide_0">
            <div id="insiderightSide" style="margin-top:1px;">
                <div id="pp_box">
                    <img name="passprt" id="passprt" src="<?php echo get_pp_pix('');?>" width="95%" height="185"  
                    style="margin:0px;" alt="" />
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
                    
                    <div id="std_names" style="width:auto; padding-top:6px; padding-bottom:4px; border-bottom:1px dashed #888888"></div>
                    <div id="std_quali" style="width:auto; padding-top:5px; padding-bottom:5px; border-bottom:1px dashed #888888"></div>
                    <div id="std_lvl" style="width:auto; padding-top:6px;"></div>
                    <div id="std_sems" style="width:auto; padding-top:4px; padding-bottom:4px; border-bottom:1px dashed #888888"></div>				
                    <div id="std_vCityName" style="width:auto; padding-bottom:4px; border-bottom:1px dashed #888888"></div>
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
</html>