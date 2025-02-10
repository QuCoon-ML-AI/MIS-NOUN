<?php 
if (!isset($_REQUEST['user_cat']))
{?>
    <div style="font-family:Verdana, Arial, Helvetica, sans-serif; 
    margin:auto; 
    text-align:center;
	font-size: 0.78em;"> Follow <a href="../" style="text-decoration:none;">here</a></div><?php
    exit;
}
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('lib_fn.php');
require_once('lib_fn_2.php');
require_once('const_def.php');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="./img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
        <script language="JavaScript" type="text/javascript">
            function update_cat_country_l(callerctrl, parentctrl, childctrl1, childctrl2)
            {
                cProgdesc = '';
                cProgId = '';

                external_cnt = 0;
                
                if (callerctrl.indexOf("Country") > -1)	
                {
                    _(childctrl1).length = 0;
                    _(childctrl1).options[_(childctrl1).options.length] = new Option('', '');

                    if (_(childctrl2))
                    {
                        _(childctrl2).length = 0;
                        _(childctrl2).options[_(childctrl2).options.length] = new Option('', '');
                    }

                    for (var i = 0; i <= _(parentctrl).length-1; i++)
                    {
                        if (_(parentctrl).options[i].value.substr(2,2) == _(callerctrl).value)
                        {
                            external_cnt++;
                            if (external_cnt%5==0)
                            {
                                _(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
                                //_(childctrl1).options[_(childctrl1).options.length].disabled = true;
                            }

                            cProgdesc = _(parentctrl).options[i].text;
                            cProgId = _(parentctrl).options[i].value.substr(0,2);

                            _(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
                        }
                    }
                    
                    if (cProgId == '')
                    {
                        _(childctrl1).length = 0;
                        _(childctrl1).options[_(childctrl1).options.length] = new Option('Non Nigerian', '99');
                        
                        if (_(childctrl2))
                        {
                            _(childctrl2).length = 0;
                            _(childctrl2).options[_(childctrl2).options.length] = new Option('Non Nigerian', '99999');
                        }
                    }
                }else if (callerctrl.indexOf("State") > -1 || callerctrl == 'crit9' || callerctrl == 'crit11')	
                {
                    _(childctrl1).length = 0;
                    _(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
                    
                    for (var i = 0; i <= _(parentctrl).length-1; i++)
                    {
                        if (_(parentctrl).options[i].value.substr(0,2) == _(callerctrl).value)
                        {
                            external_cnt++;
                            if (external_cnt%5==0)
                            {
                                _(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
                                //_(childctrl1).options[_(childctrl1).options.length].disabled = true;
                            }
                            
                            cProgdesc = _(parentctrl).options[i].text;
                            cProgId = _(parentctrl).options[i].value.substr(2,5);

                            _(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
                        }
                    }
                }else if (callerctrl.indexOf("Faculty") > -1 || callerctrl.indexOf("faculty") > -1 || callerctrl == 'crit2')	
                {
                    _(childctrl1).length = 0;
                    _(childctrl1).options[_(childctrl1).options.length] = new Option('Select a department', '');

                    if (_(childctrl2))
                    {
                        _(childctrl2).length = 0;
                        _(childctrl2).options[_(childctrl2).options.length] = new Option('', '');
                    }
                    
                    if (_(callerctrl).value == 'NA')
                    {
                        _(childctrl1).options[_(childctrl1).options.length] = new Option('Not applicable', 'NA');
                        return;
                    }
                    
                    if (_("courseId1"))
                    {
                        _("courseId1").length = 0;
                        _("courseId1").options[_("courseId1").options.length] = new Option('', '');
                    }		
                    
                    if (_("ccourseIdold") && _('frm_upd').value != 'n_f' && _('frm_upd').value != 'n_d')
                    {
                        _("ccourseIdold").length = 0;
                        _("ccourseIdold").options[_("ccourseIdold").options.length] = new Option('', '');
                    }
                    
                    for (var i = 0; i <= _(parentctrl).length-1; i++)
                    {
                        if (_(parentctrl).options[i].value.substr(0,3) == _(callerctrl).value)
                        {
                            cProgdesc = _(parentctrl).options[i].text;
                            cProgId = _(parentctrl).options[i].value.substr(3,3);

                            _(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
                        }
                    }
                }else if (callerctrl.indexOf("dept") > -1 || callerctrl.indexOf("department") > -1 || callerctrl == 'crit3')	
                {
                    _(childctrl1).length = 0;
                    _(childctrl1).options[_(childctrl1).options.length] = new Option('Select a programme', '');		
                    
                    if (_(callerctrl).value == 'NA')
                    {
                        _(childctrl1).options[_(childctrl1).options.length] = new Option('Not applicable', 'NA');
                        return;
                    }

                    var notice_written = 0;

                    for (var i = 0; i <= _(parentctrl).length-1; i++)
                    {
                        if (_(parentctrl).options[i].value.substr(0,3) == _(callerctrl).value)
                        {				
                            cProgdesc = _(parentctrl).options[i].text;
                            cProgId = _(parentctrl).options[i].value.substr(3,6);
                            
                            if (cProgId == 'HSC204' || cProgId == 'HSC205')
                            {
                                continue;
                            }
                            
                            if (cProgdesc.indexOf("PhD") != -1 || cProgdesc.indexOf("MPhil") != -1)
                            {
                                if (notice_written == 0 && !_("mm"))
                                {
                                    if (_(callerctrl).value == 'BUS' || 
                                    _(callerctrl).value == 'CIT' || 
                                    _(callerctrl).value == 'ENG' || 
                                    _(callerctrl).value == 'RST' || 
                                    _(callerctrl).value == 'LNG' || 
                                    _(callerctrl).value == 'EFO' || 
                                    _(callerctrl).value == 'SED' || 
                                    _(callerctrl).value == 'PAD' || 
                                    _(callerctrl).value == 'PHE' || 
                                    _(callerctrl).value == 'LLW' ||
                                    _(callerctrl).value == 'ENT' ||
                                    _(callerctrl).value == 'CSS' || 
                                    _(callerctrl).value == 'MAC' || 
                                    _(callerctrl).value == 'ECO' || 
                                    _(callerctrl).value == 'PCR')
                                    {
                                        _(childctrl1).options[_(childctrl1).options.length+1] = new Option("MPhil and PhD candidates are screened via interview", '');
                                        notice_written = 1;
                                    }
                                }
                            }else
                            {
                                _(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
                            }
                        }
                    }
                }else if (callerctrl.indexOf("programme") > -1 || callerctrl == 'crit4')	
                {
                    _(childctrl1).length = 0;
                    _(childctrl1).options[_(childctrl1).options.length] = new Option('', '');		
                    
                    var prev_semester = '';
                    
                    for (var i = 0; i <= _(parentctrl).length-1; i++)
                    {
                        if (childctrl1 == childctrl2 && (childctrl1.indexOf("crit5") > -1 || (childctrl1.indexOf("courseIdold") > -1 && _("what_to_do").value == '1' && _("on_what").value == '3')))
                        {
                            if ((_('crit3') && _('crit3').value == _(parentctrl).options[i].value.substr(18,3)) || (_('cdeptold') && _('cdeptold').value == _(parentctrl).options[i].value.substr(18,3)))
                            {
                                if (prev_semester != '' && prev_semester != _(parentctrl).options[i].text.substr(0,1))
                                {
                                    _(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
                                    _(childctrl1).options[_(childctrl1).options.length-1].disabled = true;
                                }
                                
                                cProgdesc = _(parentctrl).options[i].text.trim();
                                cProgId = _(parentctrl).options[i].value.substr(11,6);

                                var alreadyEntered = 0;
                                for (j = 0; j < _(childctrl1).length; j++)
                                {
                                    if (_(childctrl1).options[j].value == cProgId)
                                    {
                                        alreadyEntered = 1;
                                        break;
                                    }
                                }

                                if (alreadyEntered == 0)
                                {
                                    _(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
                                }

                                
                                prev_semester = _(parentctrl).options[i].text.substr(0,1);
                            }
                        }else if (_(parentctrl).options[i].value.substr(4,6).trim() == _(callerctrl).value.trim())
                        {
                            if (prev_semester != '' && prev_semester != _(parentctrl).options[i].text.substr(0,1))
                            {
                                _(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
                                _(childctrl1).options[_(childctrl1).options.length-1].disabled = true;
                            }
                            
                            cProgdesc = _(parentctrl).options[i].text.trim();
                            cProgId = _(parentctrl).options[i].value.substr(11,6);

                            _(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
                            
                            prev_semester = _(parentctrl).options[i].text.substr(0,1);
                        }
                    }

                    for (i = 0; i < _(childctrl1).length; i++)
                    {
                        //alert(_(childctrl1).options[i].value)
                    }
                }else if (callerctrl == 'cEduCtgId_loc')
                {
                    _(childctrl1).length = 0;
                    _(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
                    
                    for (var i = 0; i <= _(parentctrl).length-1; i++)
                    {
                        if (_(parentctrl).options[i].value.substr(2,3) == _(callerctrl).value)
                        {
                            cProgdesc = _(parentctrl).options[i].text;
                            cProgId = _(parentctrl).options[i].value;

                            _(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
                        }
                    }
                }else if (callerctrl == 'cEduCtgId1')
                {
                    _(childctrl1).length = 0;
                    _(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
                    
                    for (var i = 0; i <= _(parentctrl).length-1; i++)
                    {
                        if (_(parentctrl).options[i].value.substr(3,3) == _(callerctrl).value)
                        {
                            cProgdesc = _(parentctrl).options[i].text;
                            cProgId = _(parentctrl).options[i].value.substr(0,3);

                            _(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
                        }
                    }
                    
                    if (_("cQualCodeIdTmp").value != ''){e_qual.cQualCodeId1.value = _("cQualCodeIdTmp").value;}
                }
            }
        </script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/iamqual.js"></script>
        
		<script language="JavaScript" type="text/javascript">            
            function set_lower_uper_limit()
            {
                function _(el)
                {
                    return document.getElementById(el)
                }
                
                _('courseLevel_old').length = 0;
                _('courseLevel_old').options[_('courseLevel_old').options.length] = new Option('Select level', '');

                if(_('cprogrammeIdold').value!='')
                {
                    if (_('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,3) == 'PGD')
                    {
                        _('courseLevel_old').options[_('courseLevel_old').options.length] = new Option(700, 700);
                        _('courseLevel_old').value=700;
                    }else if ((_('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,1) == 'M' || _('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,5) == 'CEMBA' || _('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,5) == 'CEMPA') && _('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,7) != 'M. Phil')
                    {
                        _('courseLevel_old').options[_('courseLevel_old').options.length] = new Option(800, 800);
                        _('courseLevel_old').value=800;
                    }else if (_('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,1) == 'B' || _('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,3) == 'LLM')
                    {
                        cnt1 = 100;
                        cnt2 = 300;

                        if (_('cprogrammeIdold').value.substr(0,6) == 'AGR206')
                        {
                            cnt1 = 100;
                            cnt2 = 100;
                        }else if (_('cprogrammeIdold').value.substr(0,4) == 'EDU2' || _('cprogrammeIdold').value.substr(0,4) == 'ART2')
                        {
                            cnt1 = 100;
                            cnt2 = 200;
                        }else if (_('cFacultyIdold07').value == 'HSC')
                        {
                            cnt1 = 200;
                            cnt2 = 300;
                            if (_('cprogrammeIdold').value == 'HSC202'|| _('cprogrammeIdold').value == 'HSC204')
                            {
                                cnt1 = 200;
                                cnt2 = 200;
                            }
                        }else if (_('cFacultyIdold07').value == 'MSC')
                        {
                            if (_('cprogrammeIdold').value == 'MSC207')
                            {
                                cnt1 = 100;
                                cnt2 = 300;
                            }                                                    
                        }else if (_('cFacultyIdold07').value == 'SCI')
                        {
                            if (_('cprogrammeIdold').value == 'SCI204' || _('cprogrammeIdold').value == 'SCI207' || _('cprogrammeIdold').value == 'SCI210')
                            {
                                cnt1 = 100;
                                cnt2 = 200;
                            }else if (_('cprogrammeIdold').value == 'SCI209')
                            {
                                cnt1 = 100;
                                cnt2 = 300;
                            }
                        }else if (_('cFacultyIdold07').value == 'SSC')
                        {
                            if (_('cprogrammeIdold').value == 'SSC205' || _('cprogrammeIdold').value == 'SSC206' || _('cprogrammeIdold').value == 'SSC201' || _('cprogrammeIdold').value == 'SSC209')
                            {
                                cnt1 = 100;
                                cnt2 = 200;
                            }
                        }else if (_('cFacultyIdold07').value == 'LAW')
                        {
                            cnt1 = 800;
                            cnt2 = 800;
                        }

                        for (cnt = cnt1; cnt <= cnt2; cnt+=100)
                        {
                            _('courseLevel_old').options[_('courseLevel_old').options.length] = new Option(cnt, cnt);
                        }

                        _('courseLevel_old').value=100;
                    }else if (_('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(3,3) == 'Phi')
                    {
                        _('courseLevel_old').length = 0;
                    }else
                    {
                        _('courseLevel_old').length = 0;
                    }
                    _('level_options').value = _('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,3);
                }
            }
        </script>

        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/iamqual.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php        
        require_once("feedback_mesages.php");?>
        <form method="post" name="ps" enctype="multipart/form-data">
            <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
            <input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php if (isset($_REQUEST["passpotLoaded"])){echo $_REQUEST["passpotLoaded"];}?>">
            <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />
        </form>

        
        <form action="print-result" method="post" name="prns_form" target="_blank" id="prns_form" enctype="multipart/form-data">            
            <input name="vFacultyDesc" id="vFacultyDesc" type="hidden" value="<?php  if (isset($_REQUEST["vFacultyDesc"])){echo $_REQUEST["vFacultyDesc"];} ?>" />
            <input name="vdeptDesc" id="vdeptDesc" type="hidden" value="<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>" />
            <input name="vProgrammeDesc" id="vProgrammeDesc" type="hidden" value="<?php if (isset($_REQUEST["vProgrammeDesc"])){echo $_REQUEST["vProgrammeDesc"];} ?>" />
            
            <input name="cFacultyIdold_prns" id="cFacultyIdold_prns" type="hidden" value="<?php if (isset($_REQUEST["cFacultyIdold07"])){echo $_REQUEST["cFacultyIdold07"];}?>" />
            <input name="cdeptold_prns" id="cdeptold_prns" type="hidden" value="<?php if (isset($_REQUEST['cdeptold'])){echo $_REQUEST['cdeptold'];} ?>" />
            <input name="cprogrammeIdold_prns" id="cprogrammeIdold_prns" type="hidden" value="<?php if (isset($_REQUEST['cprogrammeIdold'])){echo $_REQUEST['cprogrammeIdold'];} ?>" />
            
            <input name="courseLevel" id="courseLevel" type="hidden" value="<?php if (isset($_REQUEST['courseLevel_old'])){echo $_REQUEST['courseLevel_old'];} ?>" />
        </form>
        
        <div id="smke_screen_2" class="smoke_scrn" style="display:none; z-index:5"></div><?php
        require_once("feedback_mesages.php");
        require_once("forms.php");
        
	    $mysqli = link_connect_db();		
	
        $sidemenu = '';
        if (isset($_REQUEST["sidemenu"]) && $_REQUEST["sidemenu"] <> '')
        {
            $sidemenu = $_REQUEST["sidemenu"];
        }?>
        <div class="appl_container">
            <div class="appl_left_div">
                <div class="appl_left_child_logo_div"></div>
                <div class="appl_left_child_div" style="margin-top:0px; font-weight:bold">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;font-size:1.1em">Admission requirements for various programmes</div>
            </div>
            <!-- left_conttent('Check admission requirement for my choice of programme') -->
            
            <div class="appl_right_div" style="font-size:1em;">
                <div class="appl_left_child_div" style="text-align: left; margin-top:0px; margin-bottom:0px; padding:0px; width:100%;">
                    <div class="data_line data_line_logout" style="display:flex; width:100%; gap:5px; padding:0px; height:auto; margin-top:5px; justify-content:space-between;">
                        <!-- <div class="data_line_child data_line_child_home" style="display:flex; text-align:center; margin: 0px;"> -->
                        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
                            <button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
                                onclick="ps.sidemenu.value='';
                                ps.action='../';
                                ps.submit();">
                                <img width="30" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'home.png');?>" alt="Home">
                                <br>Home</button>
                        </div><?php 
                        if ((!isset($_REQUEST['backk']) || (isset($_REQUEST['backk'])) && $_REQUEST['backk'] == '0')  && isset($_REQUEST['cFacultyIdold07']) && $_REQUEST['cFacultyIdold07'] <> '')
                        {?>
                            <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
                                <button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
                                    onclick="ps_1.backk.value='1';
                                    ps_1.sidemenu.value='1';
                                    ps_1.submit();">
                                    <img width="30" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'back.png');?>" alt="Go back">
                                    <br>Back</button>
                            </div><?php
                        }?>

                        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
                            <button type="button" class="button" style="padding:5px; border:1px solid #b6b6b6;" 
                                onclick="ps.sidemenu.value=''; ps.target='_blank'; ps.action='guides-instructions';
                                ps.submit();">
                                <img width="20" height="22" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'help.png');?>" alt="Home">
                                <br>Help</button>
                        </div>
                    </div><?php  
                    if ((!isset($_REQUEST['backk']) || (isset($_REQUEST['backk'])) && $_REQUEST['backk'] == '0')  && isset($_REQUEST['cFacultyIdold07']) && $_REQUEST['cFacultyIdold07'] <> '')
                    {
                        $progr_cat_desc = '<b> ['.$_REQUEST["courseLevel_old"].' level] Admission Requirements</b>';
                        if ($_REQUEST["courseLevel_old"] == 20)
                        {
                            $progr_cat_desc = '<b> [Diploma] Admission Requirements</b>';
                        }?>
                        
                        <div class="appl_left_child_div_child" style="margin-top: 10px;">
                            <div style="flex:100%; padding-left:4px; height:50px; background-color: #ffffff">
                                <?php echo $_REQUEST['vFacultyDesc'].' :: '. $_REQUEST['vdeptDesc'].' :: '.$_REQUEST['vProgrammeDesc'].$progr_cat_desc; ?>
                            </div>
                        </div><?php
                    }?>

                </div>
                <div class="appl_left_child_div" style="text-align: left; margin:auto; margin-top:5px; overflow:auto; width:100%; background-color: #eff5f0;">
                    <form action="check-qualification" method="post" id="ps_1" name="ps_1" enctype="multipart/form-data" onsubmit="chk_inputs(); return false">
                        <input name="vFacultyDesc" id="vFacultyDesc" type="hidden" />
                        <input name="vdeptDesc" id="vdeptDesc" type="hidden" value="<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>" />
                        <input name="vProgrammeDesc" id="vProgrammeDesc" type="hidden" value="<?php if (isset($_REQUEST['vProgrammeDesc'])){echo $_REQUEST['vProgrammeDesc'];} ?>" />
                        
                        <input name="cFacultyIdold07_1" id="cFacultyIdold07_1" type="hidden" value="<?php if (isset($_REQUEST['cFacultyIdold07'])){echo $_REQUEST['cFacultyIdold07'];} ?>"/>
                        <input name="cdeptold_1" id="cdeptold_1" type="hidden" value="<?php if (isset($_REQUEST['cdeptold'])){echo $_REQUEST['cdeptold'];} ?>" />
                        <input name="cprogrammeIdold_1" id="cprogrammeIdold_1" type="hidden" value="<?php if (isset($_REQUEST['cprogrammeIdold'])){echo $_REQUEST['cprogrammeIdold'];} ?>" />

                        <input name="courseLevel_old_1" id="courseLevel_old_1" type="hidden" value="<?php if (isset($_REQUEST['courseLevel_old'])){echo $_REQUEST['courseLevel_old'];} ?>" />
                        <input name="level_options_1" id="level_options_1" type="hidden" value="<?php if (isset($_REQUEST['courseLevel_old'])){echo $_REQUEST['courseLevel_old'];} ?>" />
                        
                        <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />

                        <?php

                        $t1 = begin_end_level(0);
                        $t2 = begin_end_level(1);?>
                        
                        <input name="begin_level_count" id="begin_level_count" type="hidden" value="<?php if (isset($_REQUEST['begin_level_count'])){echo $_REQUEST['begin_level_count'];}else{echo $t1;} ?>" />
                                        
                        <input name="end_level_count" id="end_level_count" type="hidden" value="<?php if (isset($_REQUEST['end_level_count'])){echo $_REQUEST['end_level_count'];}else{echo $t2;} ?>" />

                        <input name="save" id="save" type="hidden" value="0" />
                        <input name="name_warn" id="name_warn" type="hidden" value="0" />

                        <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
                        <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                        <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                        
                        <input name="backk" type="hidden" value="0" /><?php  
                        if ((!isset($_REQUEST['backk']) || (isset($_REQUEST['backk'])) && $_REQUEST['backk'] == '0')  && isset($_REQUEST['cFacultyIdold07']) && $_REQUEST['cFacultyIdold07'] <> '')
                        {
                            require_once("adm_req_list.php");
                        }else
                        {?>
                            <div class="appl_left_child_div_child" style="margin-top:10px;">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff"></div>
                                <div style="flex:95%; text-indent:5px; height:50px; background-color: #ffffff">
                                    <label class="chkbox_container" style="margin-top:7px">
                                        <input name="r_app_record" id="r_app_record1" type="radio" checked
                                        onclick="_('cFacultyIdold07').disabled=false;
                                        _('cdeptold').disabled=false;
                                        _('cprogrammeIdold').disabled=false;
                                        _('courseLevel_old').disabled=false;
                                        _('sub_btn').disabled=false;">
                                        <span class="checkmark radio_checkmark"></span><div style="line-height:1.8;">Degree prgramme</div>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child" style="margin-top:10px;">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff"></div>
                                <div style="flex:95%; text-indent:5px; height:50px; background-color: #ffffff">
                                    <label class="chkbox_container" style="margin-top:7px">
                                        <input name="r_app_record" id="r_app_record2" type="radio"
                                        onclick="_('cFacultyIdold07').disabled=true;
                                        _('cdeptold').disabled=true;
                                        _('cprogrammeIdold').disabled=true;
                                        _('courseLevel_old').disabled=true;
                                        _('sub_btn').disabled=true;
                                        inform('A minimum of three olevel subjects at a minimum of credit grade is required')">
                                        <span class="checkmark radio_checkmark"></span><div style="line-height:1.8;">Certificate course</div>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child" style="margin-top:10px;">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff"></div>
                                <div style="flex:95%; text-indent:5px; height:50px; background-color: #ffffff">
                                    Select options below and click on the submit button.
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
                                    <option value="<?php echo $rs['cdeptId']. $rs['cProgrammeId']?>"><?php echo $rs['vObtQualTitle'].' '.$rs['vProgrammeDesc']; ?></option><?php
                                }
                                mysqli_close(link_connect_db());?>
                            </select>
                            
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    1
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="cFacultyIdold07">Faculty</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <select name="cFacultyIdold07" id="cFacultyIdold07" style="height:100%;" required
                                        onchange="_('cdeptold').length = 0;
                                            _('cdeptold').options[_('cdeptold').options.length] = new Option('Select a department', '');
                                                    
                                            _('cprogrammeIdold').length = 0;
                                            _('cprogrammeIdold').options[_('cprogrammeIdold').options.length] = new Option('', '');

                                            _('courseLevel_old').length = 0;
                                            _('courseLevel_old').options[_('courseLevel_old').options.length] = new Option('Select level', '');
                                        
                                            update_cat_country_l('cFacultyIdold07', 'cdeptId_readup', 'cdeptold', 'cprogrammeIdold');
                                            //_('warned1').value='0';
                                            updateScrn();"><?php
                                            
                                            $faculty = '';
                                            if (isset($_REQUEST["cFacultyIdold07_1"]))
                                            {
                                                $faculty = $_REQUEST["cFacultyIdold07_1"];
                                            }
                                            
                                            get_faculties($faculty);?>
                                    </select>
                                    <input name="chnge" id="chnge" type="hidden" value="0" />
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    2
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="cdeptold">Department</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <select name="cdeptold" id="cdeptold" style="height:100%;" required
                                        
                                        onchange="_('cprogrammeIdold').length = 0;
                                        _('cprogrammeIdold').options[_('cprogrammeIdold').options.length] = new Option('Select a programme', '');

                                        _('courseLevel_old').length = 0;
                                        _('courseLevel_old').options[_('courseLevel_old').options.length] = new Option('Select level', '');

                                        update_cat_country_l('cdeptold', 'cprogrammeId_readup', 'cprogrammeIdold', 'cprogrammeIdold');"><?php

                                        if (isset($_REQUEST["cFacultyIdold07_1"]) && $_REQUEST["cFacultyIdold07_1"] <> '')
                                        {
                                            $stmt = $mysqli->prepare("select cdeptId, concat(cdeptId,' ',vdeptDesc) vdeptDesc from depts where cDelFlag = 'N' and cFacultyId = ? order by vdeptDesc");
                                            $stmt->bind_param("s", $_REQUEST["cFacultyIdold07_1"]);
                                            $stmt->execute();
                                            $stmt->store_result();
                                            $stmt->bind_result($cdeptId1, $vdeptDesc1);
                                            
                                            while ($stmt->fetch())
                                            {?>
                                                <option value="<?php echo $cdeptId1; ?>"<?php if (isset($_REQUEST['cdeptold_1']) && $cdeptId1 == $_REQUEST['cdeptold_1']){echo ' selected';}?>>
                                                    <?php echo $vdeptDesc1;?>
                                                </option><?php
                                            }
                                            $stmt->close();
                                        }?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    3
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="cprogrammeIdold">Programme</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <select name="cprogrammeIdold" id="cprogrammeIdold" style="height:100%;"
                                        onchange="set_lower_uper_limit();
                                        if (this.options[this.selectedIndex].text.indexOf('PhD') > -1 || this.options[this.selectedIndex].text.indexOf('MPhil') > -1)
                                        {
                                            caution_inform('MPhil and PhD candidates are screened via interview.<br>You may contact SPGS for more information and/or click on the home button to proceed with the application');
                                        }" required>
                                        <option value="" selected="selected"></option><?php                             
                                        if (isset($_REQUEST['cdeptold_1']))
                                        {
                                            $stmt = $mysqli->prepare("select p.cProgrammeId, p.vProgrammeDesc, o.vObtQualTitle 
                                            from programme p, obtainablequal o, depts s
                                            where p.cObtQualId = o.cObtQualId 
                                            and s.cdeptId = p.cdeptId
                                            and p.cDelFlag = s.cDelFlag
                                            and p.cDelFlag = 'N'
                                            and p.cdeptId = ?
                                            order by s.cdeptId, p.cProgrammeId");
                                            $stmt->bind_param("s", $_REQUEST['cdeptold_1']);
                                            $stmt->execute();
                                            $stmt->store_result();
                                            $stmt->bind_result($cProgrammeId, $vProgrammeDesc, $vObtQualTitle);

                                            $notice_written = 0;
                                            
                                            while ($stmt->fetch())
                                            {
                                                $vProgrammeDesc_01 = $vProgrammeDesc;
                                                if (!is_bool(strpos($vProgrammeDesc,"(d)")))
                                                {
                                                    $vProgrammeDesc_01 = substr($vProgrammeDesc, 0, strlen($vProgrammeDesc)-4);
                                                }

                                                if ($vObtQualTitle == 'PhD,' || $vObtQualTitle == 'MPhil,')
                                                {
                                                    if ($notice_written == 0)
                                                    {?>
                                                        <option value="">MPhil and PhD candidates are screened via interview</option><?php
                                                        $notice_written = 1;
                                                    }
                                                }else
                                                {?>
                                                    <option value="<?php echo $cProgrammeId?>"<?php if (isset($_REQUEST['cprogrammeIdold_1']) && $cProgrammeId == $_REQUEST['cprogrammeIdold_1']){echo ' selected';}?>><?php echo $vObtQualTitle.' '.$vProgrammeDesc_01; ?></option><?php
                                                }
                                            }
                                            $stmt->close();
                                        }?>
                                    </select>
                                    <input name="level_options" id="level_options" type="hidden" value="<?php if (isset($_REQUEST["level_options_1"]) && $_REQUEST["level_options_1"] <> ''){echo $_REQUEST["level_options_1"];}?>" />
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    4
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="cprogrammeIdold">Level</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    
                                    <select name="courseLevel_old" id="courseLevel_old" style="height:100%"
                                        onchange="prns_form.courseLevel.value=this.value;                                        
                                        iamqual.save.value='1';
                                        chk_inputs();" required>
                                        <option value="" selected="selected"></option><?php

                                        if (isset($_REQUEST["begin_level_count"]) && $_REQUEST["begin_level_count"] <> '')
                                        {
                                            $t1 = $_REQUEST["begin_level_count"];
                                        }else
                                        {
                                            $t1 = begin_end_level(0);
                                        }

                                        

                                        if (isset($_REQUEST["end_level_count"]) && $_REQUEST["end_level_count"] <> '')
                                        {
                                            $t2 = $_REQUEST["end_level_count"];
                                        }else
                                        {
                                            $t2 = begin_end_level(1);
                                        }
                                        
                                        for ($t = $t1; $t <= $t2; $t+=100)
                                        {?>
                                            <option value="<?php echo $t ?>" <?php if (isset($_REQUEST['courseLevel_old_1']) && $_REQUEST['courseLevel_old_1'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
                                        }?>
                                    </select>
                                </div>
                            </div>
                            
                            
                            <div style="display:flex; 
                                flex-flow: row;
                                justify-content: flex-end;
                                flex:100%;
                                height:auto; 
                                margin-top:10px;">
                                    <button id="sub_btn" type="submit" class="login_button">Next</button>  
                            </div><?php
                        }?>
                    </form>
                </div>
            </div>                
        </div>
	</body>
</html>