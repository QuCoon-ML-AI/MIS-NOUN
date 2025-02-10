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
	// require_once('ids_1.php');
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
		document.onkeydown = function (e) 
		{
			if (e.ctrlKey && e.keyCode === 85) 
			{
				return false;
			}
		}
			
		function chk_inputs()
		{
			var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
			for (j = 0; j <= ulChildNodes.length-1; j++)
			{
				ulChildNodes[j].style.display = 'none';
			}

            
            _('conf_box_loc').style.display = 'none';
            _('conf_box_loc').style.zIndex = '-1';
            _('smke_screen_2').style.display = 'none';
            _('smke_screen_2').style.zIndex = '-1';

            var formdata = new FormData();

            if (_('container_cover_in_chkps').style.display != 'none')
            {
                box_checked = 0;
                for (cnt = 1; cnt <= _('number_of_request').value; cnt++)
                {
                    mat_chk = "mat_chk"+cnt;
                    request_centre = "request_centre"+cnt;
                    current_centre = "current_centre"+cnt;

                    if (_(mat_chk) && _(mat_chk).checked)
                    {
                        candidate = _(mat_chk).value+','+_(request_centre).value+','+_(current_centre).value;    
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
                    _('conf_box_loc').style.display = 'block';
                    _('conf_box_loc').style.zIndex = '5';
                    _('smke_screen_2').style.display = 'block';
                    _('smke_screen_2').style.zIndex = '4';

                    return;
                }
            }else
            {
                if (sc_1_loc.id_no.value == '')
                {
                    setMsgBox("labell_msg0","");
                    sc_1_loc.id_no.focus();
                    return false;
                }

                if (!sc_1_loc.uvApplicationNo.disabled && sc_1_loc.uvApplicationNo.value.trim() == '')
                {
                    setMsgBox("labell_msg1","");
                    sc_1_loc.uvApplicationNo.focus();
                    return false;
                }

                if (!sc_1_loc.bulk_change.disabled && sc_1_loc.bulk_change.value.trim() == '')
                {
                    setMsgBox("labell_msg2","");
                    sc_1_loc.bulk_change.focus();
                    return false;
                }
                
                if (_("ans8").style.display == 'block')
                {
                    if (_("cStudyCenterIdold").value == '')
                    {
                        setMsgBox("labell_msg39","");
                        _("cFacultyIdold").focus();
                        return false;
                    }
                
                    if (_("studycentre_now").value == _("cStudyCenterIdold").value)
                    {
                        setMsgBox("labell_msg39","New study centre cannot be the same as the current");
                        _("cStudyCenterIdold").focus();
                        return false;
                    }
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

            formdata.append("whattodo", _("whattodo").value);           
            
            if (sc_1_loc.conf.value == '1')
            {
                formdata.append("conf", sc_1_loc.conf.value);
                formdata.append("cStudyCenterIdold", _("cStudyCenterIdold").value);
                formdata.append("studycentre_now", _("studycentre_now").value);

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
            formdata.append("ilin", sc_1_loc.ilin.value);
            formdata.append("user_cat", sc_1_loc.user_cat.value);
            
            if (!sc_1_loc.uvApplicationNo.disabled)
            {
			    formdata.append("uvApplicationNo", sc_1_loc.uvApplicationNo.value);
            }
            

            formdata.append("vApplicationNo", sc_1_loc.vApplicationNo.value);
            formdata.append("sm", sc_1_loc.sm.value);
            formdata.append("mm", sc_1_loc.mm.value);
            
            formdata.append("staff_study_center", sc_1_loc.user_centre.value);
            
            if (!sc_1_loc.bulk_change.disabled)
            {
			    formdata.append("bulk_change", _("bulk_change").value);
            }
            
            formdata.append("sRoleID", _('sRoleID').value);
            
		    opr_prep(ajax = new XMLHttpRequest(),formdata);
		}

	
        function opr_prep(ajax,formdata)
        {
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "opr_center_change.php");
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
            
            if (_('container_cover_in_chkps').style.display != 'none')
            {
                if (returnedStr.indexOf("success") == -1)
                {
                    caution_box(returnedStr); 
                }else
                {
                    success_box(returnedStr);
                }
            }else
            {
                if (!sc_1_loc.uvApplicationNo.disabled)
                { 
                    var plus_ind = returnedStr.indexOf("+");                
                    var ash_ind = returnedStr.indexOf("#");

                    var mask = '';

                    returnedStr = returnedStr.trim();


                    if (returnedStr.indexOf("success") == -1 && returnedStr.charAt(0) != '*' && returnedStr.indexOf("?") == -1)
                    {
                        if (sc_1_loc.id_no.value == 0)
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

                            mask = returnedStr.substr(1400).trim();
                        }else if (sc_1_loc.id_no.value == 1)
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
                            
                            _("std_lvl").style.display = 'block';
                            student_level = _("std_lvl").innerHTML;

                            if (returnedStr.substr(700, 100).trim() == 1)
                            {
                                if (_("std_sems")){_("std_sems").innerHTML = 'First semester';}
                            }else if (returnedStr.substr(700, 100).trim() == 2)
                            {
                                if (_("std_sems")){_("std_sems").innerHTML = 'Second semester';}
                            }
                            _("std_sems").style.display = 'block';
                            student_semester = _("std_sems").innerHTML;
                            
                            _("std_vCityName").innerHTML = returnedStr.substr(800, 100).trim();				
                            _("std_vCityName").style.display = 'block';
                            student_center =  _("std_vCityName").innerHTML;

                            facult_id = returnedStr.substr(900,100);

                            student_faculty = returnedStr.substr(1000,100).trim();
                            student_dept = returnedStr.substr(1100,100).trim();
                            
                            mask = returnedStr.substr(1500).trim();
                        }

                        _("div_a").innerHTML = _("sc_1_loc").uvApplicationNo.value;
                    
                        if (sc_1_loc.id_no.value == 0)
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
                            _("div_5").innerHTML = student_level+'/'+student_semester;//level/semester
                        }
                        
                        _('studycentre_now').value = student_center;

                        if (sc_1_loc.id_no.value == 0)
                        {
                            _("div_lab_a").innerHTML = 'Application form number';
                        }else if (sc_1_loc.id_no.value == 1)
                        {
                            _("div_lab_a").innerHTML = 'Matriculation number';
                        }
                        
                        _("ans6").style.display = 'block';
                        _("ans8").style.display = 'block';
                    }
                    
                    returnedStr = returnedStr.substr(ash_ind+1);
                    
                    if (returnedStr.indexOf("success") != -1)
                    {
                        success_box(returnedStr.substr(1,returnedStr.length-1));

                        _("cStudyCenterIdold").value = '';
                        // _("hd_veri_token").value = '';
                        // _("veri_token").value = '';

                        _('conf_box_loc').style.display='none';
                        _('smke_screen_2').style.display='none';
                        _('smke_screen_2').style.zIndex='-1';
                    }else if (returnedStr.indexOf("?") != -1)
                    {                    
                        //_("hd_veri_token").value = returnedStr.substr(0,6);

                        //_("conf_msg_msg_loc").innerHTML = returnedStr.substr(6);

                        _("conf_msg_msg_loc").innerHTML = returnedStr;
                        _('conf_box_loc').style.display = 'block';
                        _('conf_box_loc').style.zIndex = '3';
                        _('smke_screen_2').style.display = 'block';
                        _('smke_screen_2').style.zIndex = '2';
                    }else if (returnedStr.charAt(0) == '*')
                    {
                        caution_box(returnedStr.substr(1,returnedStr.length-1));                   
                    }
                    
                    if (returnedStr.indexOf("success") == -1 && returnedStr.indexOf("?") == -1)
                    {
                        if (sc_1_loc.id_no.value == 0 && returnedStr.indexOf('not yet submitted') != -1)
                        {
                            _("passprt").src = '../appl/img/left_side_logo.png';
                        }else
                        {
                            _("passprt").src = mask;
                            _("passprt").onerror = function() {myFunction()};

                            if (sc_1_loc.id_no.value == 1)
                            {
                                sc_1_loc.uvApplicationNo_loc.value = _('app_frm_no').value;
                            }
                        }
                            
                        function myFunction()
                        {
                            _("passprt").src = '../appl/img/left_side_logo.png';
                        }
                    }

                }else if (!sc_1_loc.bulk_change.disabled)
                {
                    if (returnedStr.indexOf("?") != -1)
                    {                    
                        //_("hd_veri_token").value = returnedStr.substr(0,6);

                        //_("conf_msg_msg_loc").innerHTML = returnedStr.substr(6);

                        _("conf_msg_msg_loc").innerHTML = returnedStr;
                        _('conf_box_loc').style.display = 'block';
                        _('conf_box_loc').style.zIndex = '3';
                        _('smke_screen_2').style.display = 'block';
                        _('smke_screen_2').style.zIndex = '2';
                    }else
                    {
                        _("cStudyCenterIdold").value = '';
                        // _("hd_veri_token").value = '';
                        // _("veri_token").value = '';

                        _('conf_box_loc').style.display='none';
                        _('smke_screen_2').style.display='none';
                        _('smke_screen_2').style.zIndex='-1';
                        
                        caution_box(returnedStr);                   
                    }
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
                ],
                dom: 'Bfrtip',
                
                buttons: 
                [
                    {
                        extend: 'excelHtml5',
                        title: 'Pending requests for change of centre',
                        exportOptions: { columns: [ 0, 1, 2, 3, 4, 5 ] },
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Pending requests for change of centre',
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
	<noscript></noscript>

    <style>
        td, table th
        {
            text-align:left;
            line-height:1.5;
        }
    </style>
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
            <input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID_u ?>" /><?php
            
            $show_bilk = 'none';
            $number_of_record = 0;
            if (check_scope3('Academic registry', 'Student request', 'Bulk change of study centre') > 0)
            {
                $show_bilk = 'flex';
            }
            
            $stmt = $mysqli->prepare("SELECT a.vMatricNo, CONCAT(vLastName,' ', vFirstName,' ',vOtherName), c.vCityName, c.cStudyCenterId, d.vCityName, d.cStudyCenterId, centre_req_date 
            FROM student_request_log_1 a, s_m_t b, studycenter c, studycenter d 
            WHERE a.vMatricNo = b.vMatricNo
            AND a.coldcentre = c.cStudyCenterId 
            AND a.cnewcentre = d.cStudyCenterId
            AND centre_req = '1'
            AND req_granted = '0'
            AND req_canceled = '0'
            AND centre_req_date >= '$semester_begin_date'
            ORDER BY act_date");
            $stmt->execute();
            $stmt->store_result();
            $number_of_record = $stmt->num_rows;?>

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
                width:60vw" 
                title="Press escape to close">
                <div style="line-height:1.5; width:70%; font-weight:bold">
                    Pending requests for change of centre
                </div>
                <div style="line-height:1.5; width:20px; position:absolute; top:10px; right:10px;">
                    <img style="width:17px; height:17px; cursor:pointer" src="./img/close.png" 
                    onclick="_('container_cover_in_chkps').style.zIndex = -1;
                        _('container_cover_in_chkps').style.display = 'none';"/>
                </div>                

                <table id="gridz" class="table table-condensed table-responsive" style="width:100%;">
                    <thead>
                        <tr>
                            <th style="text-align:right; padding-right:2%; width:5%">Sn</th>
                            <th style="width:11%">Matric. number</th>
                            <th style="width:20%">Name</th>
                            <th style="width:23%">Current centre</th>
                            <th style="width:23%">Requested centre</th>
                            <th style="width:7%">Date</th>
                        </tr>
                    </thead><?php
                    $stmt->bind_result($vMatricNo, $names, $current_centre, $current_centre_id, $request_centre, $request_centre_id, $centre_req_date);
                    
                    $cnt = 0;
                    //for ($x = 0; $x < 20; $x++)
                    //{
                        //$stmt->data_seek(0);
                        while($stmt->fetch())
                        {
                            $cnt++;
                            if ($cnt%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
                            <tr style="background-color:<?php echo $background_color;?>;">
                                <td style="text-align:right; padding-right:2%"><?php echo $cnt;?></td>
                                <td>
                                    <label for="mat_chk<?php echo $cnt;?>" class="lbl_beh">
                                        <input name="mat_chk<?php echo $cnt;?>" id="mat_chk<?php echo $cnt;?>" type="checkbox" value="<?php echo $vMatricNo;?>" style="margin:0px" checked/>
                                        <?php echo $vMatricNo;?>
                                    </label>
                                </td>
                                <td><?php echo $names;?></td>
                                <td><?php echo $current_centre;?></td>
                                <td><?php echo $request_centre;?></td>
                                <td><?php echo formatdate($centre_req_date, 'fromdb');?></td>
                                <input name="current_centre<?php echo $cnt;?>" id="current_centre<?php echo $cnt;?>" type="hidden" value="<?php echo $current_centre_id; ?>" />
                                <input name="request_centre<?php echo $cnt;?>" id="request_centre<?php echo $cnt;?>" type="hidden" value="<?php echo $request_centre_id; ?>" />
                            </tr><?php
                        }
                    //}
                    $stmt->close();?>                
                </table>
            </div>
            <input name="number_of_request" id="number_of_request" type="hidden" value="<?php echo $cnt; ?>" />
            
            
            <div id="conf_box_loc" class="center" style="display:none; width:400px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
                <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                    Confirmation
                </div>
                <a href="#" style="text-decoration:none;">
                    <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
                </a>
                <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:100%; float:left; text-align:center; padding:0px;">Are you sure?</div>
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
                        _('hd_veri_token').value = '';
                        _('veri_token').value = '';
                        return false">
                        <div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
                            No
                        </div>
                    </a>
                </div>
            </div>
			
            <select name="cdeptId_readup" id="cdeptId_readup" style="display:none"><?php	
                $sql = "select cFacultyId, cdeptId, concat(cdeptId,' ',vdeptDesc) vdeptDesc from depts where cDelFlag = 'N' order by cFacultyId, cdeptId, vdeptDesc";
                $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                while ($rs = mysqli_fetch_array($rssql))
                {?>
                    <option value="<?php echo $rs['cFacultyId']. $rs['cdeptId']?>"><?php echo $rs['vdeptDesc'];?></option><?php
                }
                mysqli_close(link_connect_db());?>
            </select>

            <select name="cprogrammeId_readup" id="cprogrammeId_readup" style="display:none"><?php	
                $sql = "select s.cdeptId, p.cProgrammeId,p.vProgrammeDesc,o.vObtQualTitle 
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
                    <option value="<?php echo $rs['cdeptId']. $rs['cProgrammeId']?>"><?php echo str_pad($rs['vObtQualTitle'], 10, " ", STR_PAD_LEFT).' '.$rs['vProgrammeDesc']; ?></option><?php
                }
                mysqli_close(link_connect_db());?>
            </select>

            <div class="innercont_top" style="margin-bottom:0px;">Student's request - Change Study Centre</div>
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
               <input name="tabno" id="tabno" type="hidden" 
                    value="<?php if (isset($_REQUEST['tabno'])){echo $_REQUEST['tabno'];}else{echo '0';} ?>"/>

                <input name="user_cEduCtgId" id="user_cEduCtgId" type="hidden" value="go"/>
                <input name="uvApplicationNo_loc" id="uvApplicationNo_loc" type="hidden" />
                <input name="app_frm_no" id="app_frm_no" type="hidden" />
                <input name="tSemester" id="tSemester" type="hidden" value="<?php echo $tSemester; ?>" />
                <input name="whattodo" id="whattodo" type="hidden" value="<?php if(isset($_REQUEST['whattodo'])){echo $_REQUEST['whattodo'];}else{echo '';}?>" />
                               
                <input name="process_step" id="process_step" type="hidden" value="" /><?php 
                frm_vars();
                
                require_once("student_requests.php");?>
                <div class="innercont_stff" style="margin-top:15px">
					<div class="div_select" style="width:auto">
						<input name="id_no" id="id_no_1" 
						value="0" 
						type="radio"
                        onclick="_('ans6').style.display='none';
                        _('ans8').style.display='none';
                        sc_1_loc.uvApplicationNo.placeholder='Enter AFN here';"/>
					</div>							
					<div class="div_select">
						<label for="id_no_1" id="enforce_cc_lbl">
							Application form number (AFN)
						</label>
					</div>
					<div id="labell_msg0" class="labell_msg blink_text orange_msg" style="width:auto"></div>
				</div>

                
                <div class="innercont_stff">
					<div class="div_select" style="width:auto">
						<input name="id_no" id="id_no_2"
						value="1" 
						type="radio"
                        onclick="_('ans6').style.display='none';
                        _('ans8').style.display='none';
                        sc_1_loc.uvApplicationNo.placeholder='Enter matriculation number here';"/>
					</div>							
					<div class="div_select">
						<label for="id_no_2" id="enforce_cc_lbl">
							Matriculation number
						</label>
					</div>
				</div>
                
                
				<div class="innercont_stff">
					<div class="div_select" style="margin-top:0px">
						<input name="uvApplicationNo" id="uvApplicationNo" type="text" class="textbox"
							onchange="this.value=this.value.trim();
							this.value = this.value.toUpperCase();
                            _('ans6').style.display='none';
                            _('ans8').style.display='none';" 
                            placeholder="Enter number here"
                            title="Only usable if box below is empty"
                            onblur="if (this.value.trim() != '')
                            {
                                sc_1_loc.bulk_change.disabled=true
                            }else
                            {
                                sc_1_loc.bulk_change.disabled=false
                            }"/>
					</div>
					<div id="labell_msg1" class="labell_msg blink_text orange_msg" style="width:auto"></div>
				</div>


                <div class="innercont_stff" style="margin-top:20px; height:auto">
                    <div class="div_select" style="height:auto">
                    <textarea rows="5" 
                        style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; height:250px; width:96%; padding:5px" 
                        name="bulk_change" 
                        id="bulk_change" 
                        placeholder="To treat cases in batch, copy and paste numbers here"
                        title="Only usable if box above is empty"
                        onblur="if (this.value.trim() != '')
                        {
                            sc_1_loc.uvApplicationNo.disabled=true;
                            _('ans8').style.display='block';
                        }else
                        {
                            sc_1_loc.uvApplicationNo.disabled=false;
                            _('ans8').style.display='none';
                        }"></textarea>
                    </div>
					<div id="labell_msg2" class="labell_msg blink_text orange_msg" style="width:auto"></div>
                </div>

                <div class="innercont_stff_tabs" id="ans6" style="border:0px; height:auto; margin-left:1px; margin-top:10px; width:736px;">
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
                            Level/Semester
                            <input id="level_now" type="hidden"/>
                        </div>
                        <div id="div_5"  class="div_valu"></div>	
                    </div>
                </div>
                
                <div class="innercont_stff" id="ans8" style="display:none;">
                    <div class="div_label" style="width:auto;">
                        New study centre
                    </div>
                    <div class="div_select" style="height:98%;"><?php
                        $sql1 = "SELECT cStudyCenterId, vCityName, vStateName FROM studycenter a, ng_state b 
                                    WHERE a.cStateId = b.cStateId AND a.cDelFlag = 'N' ORDER BY vStateName, vCityName";
                        //$sql1 = "SELECT cStudyCenterId, vCityName FROM studycenter ORDER BY vCityName";
                        $rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
                        
                        <select name="cStudyCenterIdold" id="cStudyCenterIdold" class="select">
                            <option value="" selected="selected"></option><?php
                            $counter = 0;
                            while ($table= mysqli_fetch_array($rsql1))
                            {?>
                                <option value="<?php echo $table[0] ?>"><?php echo $table[2].' '.$table[1];?></option><?php
                                if (++$counter%5 == 0)
                                {?>
                                    <option disabled></option><?php
                                }
                            }
                            mysqli_close(link_connect_db());?>
                        </select>
                    </div>
                    <div id="labell_msg39" class="labell_msg blink_text orange_msg"></div>
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
                    
                    <?php if (isset($_REQUEST['uvApplicationNo']))
                    {
                        side_detail($_REQUEST['uvApplicationNo']);
                    }else
                    {
                        side_detail('');
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
</html>