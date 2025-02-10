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
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php
require_once('var_colls.php');

$currency = 1;

$mysqli = link_connect_db();

$service_mode = '';
$num_of_mode = 0;
$service_centre = '';
$num_of_service_centre = 0;

$staff_study_center = '';
if (isset($_REQUEST['user_centre']) && $_REQUEST['user_centre'] <> '')
{
    $staff_study_center = $_REQUEST['user_centre'];
}

$staff_study_center_new = str_replace("|","','",$staff_study_center);
$staff_study_center_new = substr($staff_study_center_new,2,strlen($staff_study_center_new)-4);

$orgsetins = settns();

$today = getdate();
$today_day = $today['mday'];
$today_mon = $today['mon'];
$today_year = $today['year'];

require_once('set_scheduled_dates.php');
require_once('staff_detail.php');?>

<!-- InstanceBeginEditable name="doctitle" -->
<title>NOUN-MIS</title>
<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
<!-- InstanceEndEditable -->




<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
<script language="JavaScript" type="text/javascript" src="button_ops.js"></script>
<script language="JavaScript" type="text/javascript" src="./bamboo/ops.js"></script>
<script language="JavaScript" type="text/javascript">
    function chk_inputs()
    {
        var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
        for (j = 0; j <= ulChildNodes.length-1; j++)
        {
            ulChildNodes[j].style.display = 'none';
        }
                    
        var files = _("sbtd_pix").files;
        var files1 = _("sbtd_pix1").files;
        
        var formdata = new FormData();
        
        if (_('opsions_loc').mm.value == 2 && _('opsions_loc').sm.value == 7){_('tabno').value=4;}
        
        if (_('tabno').value == '1')
        {
            if (_("vOrgName").value == '')
            {
                setMsgBox("labell_msg0","");
                _("vOrgName").focus();
                return false;
            }else if(rmv_inv_chars(_("vOrgName").value,1)!='')
            {
                setMsgBox("labell_msg0",rmv_inv_chars(_("vOrgName").value,1));
                _("vOrgName").focus();
                return false;
            }else if(marlic(_("vOrgName").value)!='')
            {
                setMsgBox("labell_msg0",marlic(_("vOrgName").value));
                _("vOrgName").focus();
                return false;
            }else if (_("cOrgCountryId").value == '')
            {
                setMsgBox("labell_msg1","");
                _("cOrgCountryId").focus();
                return false;
            }else if (_("cOrgStateId").value == '')
            {
                setMsgBox("labell_msg2","");
                _("cOrgStateId").focus();
                return false;
            }else if (_("cOrgLGAId").value == '')
            {
                setMsgBox("labell_msg3","");
                _("cOrgLGAId").focus();
                return false;
            }else if (_("vOrgCityName").value == '')
            {
                setMsgBox("labell_msg4","");
                _("vOrgCityName").focus();
                return false;
            }else if(rmv_inv_chars(_("vOrgCityName").value,1)!='')
            {
                setMsgBox("labell_msg4",rmv_inv_chars(_("vOrgCityName").value,1));
                _("vOrgCityName").focus();
                return false;
            }else if(marlic(_("vOrgCityName").value)!='')
            {
                setMsgBox("labell_msg4",marlic(_("vOrgCityName").value));
                _("vOrgCityName").focus();
                return false;
            }else if (_("vEMailId").value == '')
            {
                setMsgBox("labell_msg5","");
                _("vEMailId").focus();
                return false;
            }else if (chk_mail(_("vEMailId")) != '')
            {
                setMsgBox("labell_msg5",chk_mail(_("vEMailId")));
                _("vEMailId").focus();
                return false;
            }else if (_("vMobileNo1").value == '')
            {
                setMsgBox("labell_msg6","");
                _("vMobileNo1").focus();
                return false;
            }else if (isNaN(_("vMobileNo1").value))
            {
                setMsgBox("labell_msg6","Numbers only");
                _("vMobileNo1").focus();
                return false;
            }else if (_("vMobileNo2").value == '')
            {
                setMsgBox("labell_msg7","You skipped this");
                _("vMobileNo2").focus();
            }else if (isNaN(_("vMobileNo2").value))
            {
                setMsgBox("labell_msg7","Numbers only");
                _("vMobileNo2").focus();
                return false;
            }else if (_("sbtd_pix").files.length > 0 && files[0].type != 'image/jpeg' && files[0].type != 'image/pjpeg')
            {
                setMsgBox("labell_msg8","JPEG required");
                _("sbtd_pix").value = '';
                return false;
            }else if (_("sbtd_pix").files.length > 0 && files[0].size > 60000)
            {
                setMsgBox("labell_msg8","File too large. Maximum size is 60KB");
                _("sbtd_pix").value = '';
                return false;
            }else
            {
                formdata.append("vOrgName", _("vOrgName").value);
                formdata.append("cOrgCountryId", _("cOrgCountryId").value);
                formdata.append("cOrgStateId", _("cOrgStateId").value);
                formdata.append("cOrgLGAId", _("cOrgLGAId").value);
                formdata.append("vOrgCityName", _("vOrgCityName").value);
                formdata.append("vEMailId", _("vEMailId").value);
                formdata.append("vMobileNo1", _("vMobileNo1").value);
                formdata.append("vMobileNo2", _("vMobileNo2").value);
                formdata.append("sbtd_pix", _("sbtd_pix").files[0]);
            }
        }else if (_('tabno').value == '2')
        {
            if (_("session_year0").value == '')
            {
                setMsgBox("labell_msg11a","");
                _("session_year0").focus();
                return false;
            }

            if (_("sesdate0").value == '' || _("sesdate0").value.length != 10)
            {
                setMsgBox("labell_msg11","");
                _("sesdate0").focus();
                return false;
            }
            
            if (_("sesdate1").value == '' || _("sesdate1").value.length != 10)
            {
                setMsgBox("labell_msg12","");
                _("sesdate1").focus();
                return false;
            }		
            
            var date1 = new Date(_("sesdate0").value);
            var date2 = new Date(_("sesdate1").value);

            if (date1.getTime() == date2.getTime())
            {
                setMsgBox("labell_msg11"," Session begin and end date should not be the same");
                setMsgBox("labell_msg12"," Session begin and end date should not be the same");
                _("sesdate1").focus();
                return false;
            }            
            
            if (date1.getTime() > date2.getTime())
            {			
                setMsgBox("labell_msg11","Session end date should come after Session begin date");
                setMsgBox("labell_msg12","Session end date should come after Session begin date");
                _("semdate2").focus();
                return false;
            }
            
            if (_("tSemester0").value == '')
            {
                setMsgBox("labell_msg13","");
                _("tSemester0").focus();
                return false;
            }
            
            if (_("semdate1").value == '' || _("semdate1").value.length != 10)
            {
                setMsgBox("labell_msg14","");
                _("semdate1").focus();
                return false;
            }
            
            if (_("semdate2").value == '' || _("semdate2").value.length != 10)
            {
                setMsgBox("labell_msg15","");
                _("semdate2").focus();
                return false;
            }		
            
            var date1 = new Date(_("sesdate0").value);
            var date2 = new Date(_("semdate1").value);
            if (date1.getTime() > date2.getTime())
            {
                setMsgBox("labell_msg11","Semester should begin after session begins");
                setMsgBox("labell_msg14","Semester should begin after session begins");
                return false;
            }
            
            var date1 = new Date(_("semdate1").value);
            var date2 = new Date(_("semdate2").value);
            if (date1.getTime() > date2.getTime())
            {
                setMsgBox("labell_msg14","Semester end date should come after semester begin date");
                setMsgBox("labell_msg15","Semester end date should come after semester begin date");
                _("semdate2").focus();
                return false;
            }
            
            if (_("semdate1").value == _("semdate2").value)
            {
                setMsgBox("labell_msg14"," Semester begin and end date should not be the same");
                setMsgBox("labell_msg15"," Semester begin and end date should not be the same");
                _("semdate2").focus();
                return false;
            }
            
            var date1 = new Date(_("sesdate1").value);
            var date2 = new Date(_("semdate2").value);
            if (date1.getTime() < date2.getTime())
            {
                setMsgBox("labell_msg12","Session should end after Semester ends");
                setMsgBox("labell_msg15","Session should end after Semester ends");
                _('semdate2').focus();
                return false;
            }
            
            if (_("regdate1").value == '' || _("regdate1").value.length != 10)
            {
                setMsgBox("labell_msg16","");
                _("regdate1").focus();
                return false;
            }
            
            if (_("regdate_100_200_2").value == '' || _("regdate_100_200_2").value.length != 10)
            {
                setMsgBox("labell_msg17","");
                _("regdate_100_200_2").focus();
                return false;
            }
            
            if (_("regdate_300_2").value == '' || _("regdate_300_2").value.length != 10)
            {
                setMsgBox("labell_msg17a","");
                _("regdate_300_2").focus();
                return false;
            }
            
            var date1 = new Date(_("semdate1").value);
            var date2 = new Date(_("regdate1").value);
            if (date1.getTime() > date2.getTime())
            {
                setMsgBox("labell_msg14","Registration should begin after semester begins");
                setMsgBox("labell_msg16","Registration should begin after semester begins");
                _("regdate1").focus();
                return false;
            }

            var date1 = new Date(_("regdate1").value);
            var date2 = new Date(_("regdate_100_200_2").value);
            if (date1.getTime() > date2.getTime())
            {
                setMsgBox("labell_msg17","Registration end date should come after registration begin date");
                _("regdate1").focus();
                return false;
            }
            
            var date2 = new Date(_("regdate_300_2").value);
            if (date1.getTime() > date2.getTime())
            {
                setMsgBox("labell_msg17a","Registration end date should come after registration begin date");
                _("regdate1").focus();
                return false;
            }
            
            var date1 = new Date(_("regdate_100_200_2").value);
            var date2 = new Date(_("semdate2").value);
            if (date1.getTime() > date2.getTime())
            {
                setMsgBox("labell_msg15","Semester should end after registration ends");
                setMsgBox("labell_msg17a","Semester should end after registration ends");
                _("regdate_100_200_2").focus();
                return false;
            }
            
            var date1 = new Date(_("regdate_300_2").value);
            var date2 = new Date(_("semdate2").value);
            if (date1.getTime() > date2.getTime())
            {
                setMsgBox("labell_msg15","Semester should end after registration ends");
                setMsgBox("labell_msg17a","Semester should end after registration ends");
                _("regdate_100_200_2").focus();
                return false;
            }
            
            if (_("regdate1").value == _("regdate_100_200_2").value)
            {
                setMsgBox("labell_msg6","Registration begin and end date should not be the same");
                setMsgBox("labell_msg17","Registration begin and end date should not be the same");
                _("regdate_100_200_2").focus();
                return false;
            }
            
            if (_("regdate1").value == _("regdate_300_2").value)
            {
                setMsgBox("labell_msg6","Registration begin and end date should not be the same");
                setMsgBox("labell_msg17a","Registration begin and end date should not be the same");
                _("regdate_300_2").focus();
                return false;
            }
            
            if (!_('tmadate1').disabled)
            {
                if (_("tmadate1").value == '' || _("tmadate1").value.length != 10)
                {
                    setMsgBox("labell_msg19","");
                    _("tmadate1").focus();
                    return false;
                }
                
                if (_("tmadate2").value == '' || _("tmadate2").value.length != 10)
                {
                    setMsgBox("labell_msg20","");
                    _("tmadate2").focus();
                    return false;
                }
                                            
                var date1 = new Date(_("tmadate1").value);
                var date2 = new Date(_("tmadate2").value);
                if (date1.getTime() > date2.getTime())
                {
                    setMsgBox("labell_msg20","TMA end date should come after the begin date");
                    _("tmadate2").focus();
                    return false;
                }
                            
                var date1 = new Date(_("tmadate2").value);
                var date2 = new Date(_("semdate2").value);
                if (date1.getTime() > date2.getTime())
                {
                    setMsgBox("labell_msg20","TMA should end bedore semester ends");
                    _("tmadate2").focus();
                    return false;
                }
                
                if (_("regexam").value == 1 && _("tmadate1").value == _("tmadate2").value)
                {
                    setMsgBox("labell_msg19","TMA beginning and end date should not be the same");
                    setMsgBox("labell_msg20","TMA beginning and end date should not be the same");
                    _("tmadate2").focus();
                    return false;
                }
            }

            
            if (_("examdate1").value == '' || _("examdate1").value.length != 10)
            {
                setMsgBox("labell_msg41","");
                _("examdate1").focus();
                return false;
            }
            
            if (_("examdate2").value == '' || _("examdate2").value.length != 10)
            {
                setMsgBox("labell_msg42","");
                _("examdate2").focus();
                return false;
            }

            if (_("examdate1").value ==  _("examdate2").value)
            {
                setMsgBox("labell_msg41","Beginning and end date of exams cannot be the same");
                setMsgBox("labell_msg42","Beginning and end date of exams cannot be the same");
                _("examdate1").focus();
                return false;
            }
            
                
            var date1 = new Date(_("examdate1").value);
            var date2 = new Date(_("examdate2").value);
            if (date1.getTime() > date2.getTime())
            {
                setMsgBox("labell_msg42","Exams end date should come after the begin date");
                _("examdate2").focus();
                return false;
            }


            if (_("tIdl_time").value == '')
            {
                setMsgBox("labell_msg22","");
                _("tIdl_time").focus();
                return false;
            }       
            

            _('AcademicDesc').value = _('session_year0').value;
            
            formdata.append("tSemester0", _("tSemester0").value);
            formdata.append("tSemester0_h", _("tSemester0_h").value);
            
            formdata.append("sesdate0", remove_hyphen(_("sesdate0").value));
            formdata.append("sesdate0_h", _("sesdate0_h").value);
            formdata.append("sesdate1", remove_hyphen(_("sesdate1").value));
            formdata.append("sesdate1_h", _("sesdate1_h").value);
            
            formdata.append("regdate1", remove_hyphen(_("regdate1").value));
            formdata.append("regdate_100_200_2", remove_hyphen(_("regdate_100_200_2").value));
            formdata.append("regdate_300_2", remove_hyphen(_("regdate_300_2").value));
            
            formdata.append("AcademicDesc", _('AcademicDesc').value);

            //formdata.append("session_year0", _('session_year0').value);
            //formdata.append("session_year1", _('session_year1').value);
            formdata.append("session_year0_h", _('session_year0_h').value);
            //formdata.append("session_year1_h", _('session_year1_h').value);		
            
            formdata.append("semdate1", remove_hyphen(_("semdate1").value));
            formdata.append("semdate2", remove_hyphen(_("semdate2").value));

            formdata.append("tmadate1", remove_hyphen(_("tmadate1").value));
            formdata.append("tmadate2", remove_hyphen(_("tmadate2").value));

            formdata.append("examdate1", remove_hyphen(_("examdate1").value));
            formdata.append("examdate2", remove_hyphen(_("examdate2").value));

            formdata.append("cemba_cempa_date1", remove_hyphen(_("cemba_cempa_date1").value));
            formdata.append("cemba_cempa_date2", remove_hyphen(_("cemba_cempa_date2").value));
            
            if (_("cemba_cempa_only").checked)
            {
                formdata.append("cemba_cempa_only", '1');
            }

            formdata.append("tIdl_time", _("tIdl_time").value);
            
            formdata.append("ind_semster", _("ind_semster").value);

            if (_("ses_only").checked)
            {
                formdata.append("ses_only", '1');
            }
            
            if (_("sem_only").checked)
            {
                formdata.append("sem_only",'1');
            }

            if (_("reg_only").checked)
            {
                formdata.append("reg_only", '1');
            }

            if (_("tma_only").checked)
            {
                formdata.append("tma_only", '1');
            }

            if (_("exam_only").checked)
            {
                formdata.append("exam_only", '1');
            }
            
            // if (_("app_close_open_date_only").checked)
            // {
            //     formdata.append("app_close_open_date", remove_hyphen(_("app_close_open_date").value));
            // }

            // if(_('applic_session_only').checked)
            // {
            //     formdata.append("applic_session", _("applic_session").value);
            // }

            // if(_('admission_letter_date_only').checked)
            // {
            //     formdata.append("admission_letter_date", remove_hyphen(_("admission_letter_date").value));
            // }
        }else if (_('tabno').value == '3')
        {            
            if (trim(_("matnoprefix1").value) != '' && trim(_("place_sepa1").value) == '')
            {
                caution_box('Please specify whether attacment 1 is a prefix or suffix');
                return false;
            }else if (trim(_("matnoprefix2").value) != '' && trim(_("place_sepa2").value) == '')
            {
                caution_box('Please specify whether attacment 2 is a prefix or suffix');
                return false;
            }else if (_("prefix_by_faculty").checked && trim(_("place_sepa3").value) == '')
            {
                caution_box('Please specify whether faculty is a prefix or suffix');
                return false;
            }else if (_("prefix_by_dept").checked && trim(_("place_sepa4").value) == '')
            {
                caution_box('Please specify whether department is a prefix or suffix');
                return false;
            }else if (_("prefix_by_yr").checked && trim(_("place_sepa5").value) == '')
            {
                caution_box('Please specify whether year is a prefix or suffix');
                return false;
            }else if (trim(_("matnosufix").value) != '' && trim(_("place_sepa7").value) == '')
            {
                caution_box('Please specify whether attacment 7 is a prefix or suffix');
                return false;
            }else
            {
                formdata.append("matnoprefix1", _("matnoprefix1").value);
                formdata.append("place_sepa1", _("place_sepa1").value);
                formdata.append("matnoprefix2", _("matnoprefix2").value);
                formdata.append("place_sepa2", _("place_sepa2").value);
                formdata.append("matnosepa", _("matnosepa").value);
                formdata.append("matnosufix", _("matnosufix").value);
                formdata.append("place_sepa7", _("place_sepa7").value);
                formdata.append("sampl_compoMat", _("sampl_compoMat").value);
                formdata.append("mat_comp_orda", _("mat_comp_orda").value);
                formdata.append("prefix_by_yr", _("prefix_by_yr").value);
                formdata.append("place_sepa5", _("place_sepa5").value);
                formdata.append("prefix_by_dept", _("prefix_by_dept").value);
                formdata.append("place_sepa4", _("place_sepa4").value);
                formdata.append("prefix_by_faculty", _("prefix_by_faculty").value);
                formdata.append("place_sepa3", _("place_sepa3").value);
            }
        }else if (_('tabno').value == '4')
        {
            if (_('opsions_loc').mm.value == 7 && _('opsions_loc').sm.value == 8)
            {
                if (_("size_cred").value == '')
                {
                    setMsgBox("labell_msg25","");
                    _("size_cred").focus();
                    return false;
                }else if (_("size_pp").value == '')
                {
                    setMsgBox("labell_msg26","");
                    _("size_pp").focus();
                    return false;
                }
            }
            
            if (_("pc_char") && _("pc_char").value == '')
            {
                setMsgBox("labell_msg27","");
                _("pc_char").focus();
                return false;
            }else if (_("cc_char") && _("cc_char").value == '')
            {
                setMsgBox("labell_msg28","");
                _("cc_char").focus();
                return false;
            }
            
            if ((_('opsions_loc').mm.value == 1 && _('opsions_loc').sm.value == 11) || (_('opsions_loc').mm.value == 7 && _('opsions_loc').sm.value == 3))
            {
                if (_("mailreqrec1").value == '')
                {
                    setMsgBox("labell_msg44","");
                    _("mailreqrec1").focus();
                    return false;
                }
                
                if (_("mailreqrec3").value == '')
                {
                    setMsgBox("labell_msg46","");
                    _("mailreqrec3").focus();
                    return false;
                }
                
                if (chk_mail(_("mailreqrec1")) != '')
                {
                    setMsgBox("labell_msg44",chk_mail(_("mailreqrec1")));
                    _("mailreqrec1").focus();
                    return false;
                }
                
                if (_("mailreqrec2").value != '' && chk_mail(_("mailreqrec2")) != '')
                {
                    setMsgBox("labell_msg45",chk_mail(_("mailreqrec1")));
                    _("mailreqrec2").focus();
                    return false;
                }
                
                if (_("cShowrslt").checked )
                {
                    if (!_("cShowrslt_for_student").checked && !_("cShowrslt_for_staff").checked)
                    {
                        setMsgBox("labell_msg37","Indicate category of user");
                        return false;
                    }

                    if (!_("cShowgrade").checked && !_("cShowscore").checked && !_("cShowgpa").checked)
                    {
                        setMsgBox("labell_msg38","One or more of these is required");
                        setMsgBox("labell_msg39","One or more of these is required");
                        setMsgBox("labell_msg40","One or more of these is required");
                        return false;
                    }
                }

                if (_("period_of_result_upload").checked)
                {
                    if (_("semester_of_result_upload").value == '')
                    {
                        setMsgBox("labell_msg36","Semester is required");
                        return false;
                    }
                    
                    if (_("hd_session_of_result_upload").value == '0000/0000')
                    {
                        setMsgBox("labell_msg36","Session is required");
                        return false;
                    }
                }

                if (!_("drp_crs").disabled && _("drp_crs").checked && (_("hd_drp_crsdate").value == '' || _("hd_drp_crsdate").value == '00000000' || _("hd_drp_crsdate").value.length != 10))
                {
                    setMsgBox("labell_msg31","Set date please");
                    return false;
                }
                
                if (!_("drp_crs").disabled && _("drp_crs").checked &&properdate(_('hd_drp_crsdate').value,_('semdate1').value))
                {
                    setMsgBox("labell_msg31","Date should fall within the semester");
                    _("semdate1").focus();
                    return false;
                }
                
                if (!_("drp_crs").disabled && _("drp_crs").checked && !properdate(_('hd_drp_crsdate').value,_('semdate2').value))
                {
                    setMsgBox("labell_msg31","Date should fall within the semester");
                    _("semdate2").focus();
                    return false;
                }

                
                if (!_("drp_exam").disabled && _("drp_exam").checked && (_("hd_drp_examdate").value == '' || _("hd_drp_examdate").value == '00000000' || _("hd_drp_examdate").value.length != 10))			
                {
                    setMsgBox("labell_msg32","Set date please");
                    return false;
                }

                
                if (!_("drp_exam_2").disabled && _("drp_exam_2").checked && (_("hd_drp_exam_2date").value == '' || _("hd_drp_exam_2date").value == '00000000' || _("hd_drp_exam_2date").value.length != 10))			
                {
                    setMsgBox("labell_msg33","Set date please");
                    return false;
                }
                        
                if (!_("drp_exam").disabled && _("drp_exam").checked && !properdate(_('hd_drp_examdate').value,_('semdate2').value))
                {
                    setMsgBox("labell_msg32","Date should fall within the semester");
                    _("semdate1").focus();
                    return false;
                }
                        
                if (!_("drp_exam_2").disabled && _("drp_exam_2").checked && !properdate(_('hd_drp_exam_2date').value,_('semdate2').value))
                {
                    setMsgBox("labell_msg33","Date should fall within the semester");
                    _("semdate1").focus();
                    return false;
                }
                
                if (!_("drp_exam").disabled && _("drp_exam").checked && !properdate(_('semdate1').value,_('hd_drp_examdate').value))
                {
                    setMsgBox("labell_msg32","Date should fall within the semester");
                    _("semdate2").focus();
                    return false;
                }
                
                if (!_("drp_exam_2").disabled && _("drp_exam_2").checked && !properdate(_('semdate1').value,_('hd_drp_exam_2date').value))
                {
                    setMsgBox("labell_msg33","Date should fall within the semester");
                    _("semdate2").focus();
                    return false;
                }
                
                if (!_("drp_exam").disabled && _("drp_exam").checked && properdate(_('hd_drp_examdate').value,_('hd_drp_crsdate').value))
                {
                    setMsgBox("labell_msg32","Dead line should come after that of dropping of course");
                    _("drp_exam").focus();
                    return false;
                }
                
                if (!_("drp_exam_2").disabled && _("drp_exam_2").checked && properdate(_('hd_drp_exam_2date').value,_('hd_drp_crsdate').value))
                {
                    setMsgBox("labell_msg33","Dead line should come after that of dropping of course");
                    _("drp_exam_2").focus();
                    return false;
                }

                
                
                if (_('req_mail_level_cahnge').value.trim() == '')
                {
                    setMsgBox("labell_msg51","");
                    _("req_mail_level_cahnge").focus();
                    return false;
                }

                /*if (chk_mail(_("req_mail_level_cahnge")) != '')
                {
                    setMsgBox("labell_msg51",chk_mail(_("req_mail_level_cahnge")));
                    _("req_mail_level_cahnge").focus();
                    return false;
                }*/

                if (_('req_mail_level_cahnge_cc1').value.trim() == '')
                {
                    setMsgBox("labell_msg52","");
                    _("req_mail_level_cahnge_cc1").focus();
                    return false;
                }

                /*if (chk_mail(_("req_mail_level_cahnge_cc1")) != '')
                {
                    setMsgBox("labell_msg52",chk_mail(_("req_mail_level_cahnge_cc1")));
                    _("req_mail_level_cahnge_cc1").focus();
                    return false;
                }*/

                /*if (_("req_mail_level_cahnge_cc2").value.trim() != '' && chk_mail(_("req_mail_level_cahnge_cc2")) != '')
                {
                    setMsgBox("labell_msg53",chk_mail(_("req_mail_level_cahnge_cc2")));
                    _("req_mail_level_cahnge_cc2").focus();
                    return false;
                }*/
                
                
                if (_('req_mail_prog_cahnge').value.trim() == '')
                {
                    setMsgBox("labell_msg54","");
                    _("req_mail_prog_cahnge").focus();
                    return false;
                }

                /*if (chk_mail(_("req_mail_prog_cahnge")) != '')
                {
                    setMsgBox("labell_msg54",chk_mail(_("req_mail_prog_cahnge")));
                    _("req_mail_prog_cahnge").focus();
                    return false;
                }*/

                if (_('req_mail_prog_cahnge_cc1').value.trim() == '')
                {
                    setMsgBox("labell_msg55","");
                    _("req_mail_prog_cahnge_cc1").focus();
                    return false;
                }

                /*if (chk_mail(_("req_mail_prog_cahnge_cc1")) != '')
                {
                    setMsgBox("labell_msg55",chk_mail(_("req_mail_prog_cahnge_cc1")));
                    _("req_mail_prog_cahnge_cc1").focus();
                    return false;
                }*/

                /*if (_("req_mail_prog_cahnge_cc2").value.trim() != '' && chk_mail(_("req_mail_prog_cahnge_cc2")) != '')
                {
                    setMsgBox("labell_msg56",chk_mail(_("req_mail_prog_cahnge_cc2")));
                    _("req_mail_prog_cahnge_cc2").focus();
                    return false;
                }*/
                
                
                if (_('req_mail_cent_cahnge').value.trim() == '')
                {
                    setMsgBox("labell_msg57","");
                    _("req_mail_cent_cahnge").focus();
                    return false;
                }

                // if (chk_mail(_("req_mail_cent_cahnge")) != '')
                // {
                //     setMsgBox("labell_msg57",chk_mail(_("req_mail_cent_cahnge")));
                //     _("req_mail_cent_cahnge").focus();
                //     return false;
                // }

                if (_('req_mail_cent_cahnge_cc1').value.trim() == '')
                {
                    setMsgBox("labell_msg58","");
                    _("req_mail_cent_cahnge_cc1").focus();
                    return false;
                }

                // if (chk_mail(_("req_mail_cent_cahnge_cc1")) != '')
                // {
                //     setMsgBox("labell_msg58",chk_mail(_("req_mail_cent_cahnge_cc1")));
                //     _("req_mail_cent_cahnge_cc1").focus();
                //     return false;
                // }

                // if (_("req_mail_cent_cahnge_cc2").value.trim() != '' && chk_mail(_("req_mail_cent_cahnge_cc2")) != '')
                // {
                //     setMsgBox("labell_msg59",chk_mail(_("req_mail_cent_cahnge_cc2")));
                //     _("req_mail_cent_cahnge_cc2").focus();
                //     return false;
                // }


                formdata.append("mailreqrec1", _("mailreqrec1").value);
                formdata.append("mailreqrec2", _("mailreqrec2").value);
                formdata.append("mailreqrec3", _("mailreqrec3").value);
                
                formdata.append("semster_adm", _("semster_adm").value);
                
                formdata.append("period_of_result_upload", _("period_of_result_upload").value);
                formdata.append("semester_of_result_upload", _("semester_of_result_upload").value);
                formdata.append("session_of_result_upload", _("hd_session_of_result_upload").value);

                formdata.append("cShowrslt", _("cShowrslt").value);
                
                formdata.append("cShowrslt_for_staff", _("cShowrslt_for_staff").value);
                formdata.append("cShowrslt_for_student", _("cShowrslt_for_student").value);

                formdata.append("cShowgrade", _("cShowgrade").value);
                formdata.append("cShowscore", _("cShowscore").value);
                formdata.append("cShowgpa", _("cShowgpa").value);
                            
                formdata.append("sem_reg", _("sem_reg").value);
                
                formdata.append("cShowtt", _("cShowtt").value);
                formdata.append("pc_char", _("pc_char").value);
                formdata.append("cc_char", _("cc_char").value);
                
                formdata.append("enforce_co", _("enforce_co").value);
                formdata.append("transission_in_progress", _("transission_in_progress").value);


                //formdata.append("enforce_cc", _("enforce_cc_h").value);
                
                formdata.append("enforce_cc", '0'); 

                formdata.append("overall_ca", _("overall_ca").value);
                formdata.append("overall_ex", _("overall_ex").value);
                
                formdata.append("drp_crs", _("drp_crs").value);
                formdata.append("drp_crsdate", remove_hyphen(_("hd_drp_crsdate").value));
                
                if (_("student_req1"))
                {
                    formdata.append("student_req1", remove_hyphen(_("student_req1").value));
                    formdata.append("student_req2", remove_hyphen(_("student_req2").value));
                }

                formdata.append("regexam", _("regexam").value);
                    
                
                if (_("regexam").value == '1')
                {
                    formdata.append("drp_exam", _("drp_exam").value);
                    formdata.append("drp_examdate", remove_hyphen(_("hd_drp_examdate").value));
                    
                    formdata.append("drp_exam_2", _("drp_exam_2").value);
                    formdata.append("drp_exam_2date", remove_hyphen(_("hd_drp_exam_2date").value));
                }else
                {
                    formdata.append("drp_exam", '0');
                    formdata.append("drp_examdate", '00000000');
                }
                
                formdata.append("upld_passpic", _("upld_passpic").value);
                formdata.append("upld_passpic_no", _("upld_passpic_no").value);
                if (_("ind_semster")){formdata.append("ind_semster", _("ind_semster").value);}
                    
                
                if (_('opsions_loc').mm.value == 7 && _('opsions_loc').sm.value == 3)
                {
                    formdata.append("course_fee_cat", _("course_fee_cat").value);
                    formdata.append("course_fee_course", _("course_fee_course").value);
                    formdata.append("course_fee_credit_unit", _("course_fee_credit_unit").value);

                    formdata.append("exam_fee", _("exam_fee").value);
                }

                
                formdata.append("req_mail_level_cahnge", _("req_mail_level_cahnge").value);
                formdata.append("req_mail_level_cahnge_cc1", _("req_mail_level_cahnge_cc1").value);
                formdata.append("req_mail_level_cahnge_cc2", _("req_mail_level_cahnge_cc2").value);
                
                formdata.append("req_mail_prog_cahnge", _("req_mail_prog_cahnge").value);
                formdata.append("req_mail_prog_cahnge_cc1", _("req_mail_prog_cahnge_cc1").value);
                formdata.append("req_mail_prog_cahnge_cc2", _("req_mail_prog_cahnge_cc2").value);
                
                formdata.append("req_mail_cent_cahnge", _("req_mail_cent_cahnge").value);
                formdata.append("req_mail_cent_cahnge_cc1", _("req_mail_cent_cahnge_cc1").value);
                formdata.append("req_mail_cent_cahnge_cc2", _("req_mail_cent_cahnge_cc2").value);
                
                formdata.append("wait_max_login", _("wait_max_login").value);
                formdata.append("max_login", _("max_login").value);
            }
            
            if (_('opsions_loc').mm.value == 2 && _('opsions_loc').sm.value == 10)
            {
                if (!_("loadfund").disabled)
                {
                    formdata.append("loadfund", _("loadfund").value);
                }
                
                if (_("ac_close").value == '')
                {
                    setMsgBox("labell_msg49","");
                    return false;
                }

                if (_("ac_open").value == '')
                {
                    setMsgBox("labell_msg50","");
                    return false;
                }

                formdata.append("late_fee", _("late_fee").value);

                formdata.append("rr_sys", _("rr_sys").value);
                formdata.append("semreg_fee", _("semreg_fee").value);
                
                formdata.append("course_fee_cat", _("course_fee_cat").value);
                formdata.append("course_fee_course", _("course_fee_course").value);
                formdata.append("course_fee_credit_unit", _("course_fee_credit_unit").value);

                formdata.append("exam_fee", _("exam_fee").value);
                formdata.append("ewallet_cred_for_sem_reg", _("ewallet_cred_for_sem_reg").value);
                formdata.append("ewallet_cred_for_ses_reg", _("ewallet_cred_for_ses_reg").value);
                
                formdata.append("uni_give_mat", _("uni_give_mat").value);
                
                formdata.append("ac_close", remove_hyphen(_("ac_close").value));
                formdata.append("ac_open", remove_hyphen(_("ac_open").value));
            }
            
            if (_('opsions_loc').mm.value == 7 && _('opsions_loc').sm.value == 3)
            {
                formdata.append("size_cred", _("size_cred").value);
                formdata.append("size_pp", _("size_pp").value);
            }
        }else if (_('tabno').value == '5')
        {
            if (_("h_examType").value == '')
            {
                setMsgBox("labell_msg29","");
                return false;
            }else if (_("h_examType_df").value == '')
            {
                setMsgBox("labell_msg43","");
                return false;
            }else if (_("sbtd_pix1").files.length == 0)
            {
                setMsgBox("labell_msg30","");
                _("sbtd_pix1").focus();
                return false;
            }
            
            var file_name = _("sbtd_pix1").files[0].name;
            //var file_name_ext = file_name.substr(_("sbtd_pix1").files[0].name.indexOf(".")+1);
            if (!csvfileValidation("sbtd_pix1") || _("sbtd_pix1").files.length == 0)
            {
                setMsgBox("labell_msg30","Select a csv file to upload");
                return false;
            }

            // if (_("sbtd_pix1").files[0].type != 'text/csv')
            // {
            //     setMsgBox("labell_msg30","CSV file required");
            //     _("sbtd_pix1").value = '';
            //     return false;
            // }
            //alert('sss')
            //formdata.append("file_name_ext", file_name_ext);
            formdata.append("sbtd_pix1", _("sbtd_pix1").files[0]);
            formdata.append("examType", _('opsions_loc').h_examType.value);
            formdata.append("examType_df", _('opsions_loc').h_examType_df.value);

            if (_('show_tt').checked)
            {
                formdata.append("show_tt", 1);
            }
            
        }
            
        formdata.append("currency_cf", _("currency_cf").value);
        formdata.append("user_cat", _('opsions_loc').user_cat.value);
        formdata.append("ilin", _('nxt').ilin.value);
        formdata.append("save_cf", _("save_cf").value);
        formdata.append("vApplicationNo", _('opsions_loc').vApplicationNo.value);
        formdata.append("tabno", _('tabno').value);
        formdata.append("sm", _('opsions_loc').sm.value);
        formdata.append("mm", _('opsions_loc').mm.value);

        if (_('tabno').value == '1')
        {
            formdata.append("mm", _('opsions_loc').mm.value);
        }
        
        if ((_('opsions_loc').conf.value == '' || _('opsions_loc').conf.value == 0) && _('tabno').value == '2' && !_('cemba_cempa_only').checked)
        {
            $section_restr = (_("tIdl_time_only").checked || _("reg_only").checked || _("tma_only").checked || _("exam_only").checked);

            if ((_('sesdate0_h').value != _('sesdate0').value || _('semdate1_h').value != _('semdate1').value) && !$section_restr)
            {
                _("conf_msg_msg_loc").innerHTML = 'You have set a commencement date for the next semester <br></br> Do you want changes to be saved?';
            }
            
            _('conf_box_loc').style.display = 'block';
            _('conf_box_loc').style.zIndex = '3';
            _('smke_screen_2').style.display = 'block';
            _('smke_screen_2').style.zIndex = '2';
        }else
        {
            opr_prep(ajax = new XMLHttpRequest(),formdata);
        }
    }

    function completeHandler(event)
    {
        on_error('0');
        on_abort('0');
        in_progress('0');

        var returnedStr = event.target.responseText;
        
        if (isNaN(returnedStr) && returnedStr != '' && returnedStr.indexOf(";") == -1 && returnedStr.indexOf("$") == -1 && returnedStr.indexOf("%") == -1)
        {
            if (returnedStr.indexOf("successful") != -1)
            {
                success_box(returnedStr);

                _("tSemester0_h").value = _("tSemester0").value;
                _("sesdate1_h").value = _("sesdate1").value;
            }else
            {
                caution_box(returnedStr);
            }
        }
        
        if (returnedStr != ''){_("frm_upd").value = 0;}
        _("save_cf").value = -1;
        _("tIdl_time_only").value = 0;
        
        //_("app_close_open_date_only").value = 0;
        _('opsions_loc').conf.value = '';

        _("ses_only").value = 0;
        _("sem_only").value = 0;
        
        _('ses_only').checked = false;
        _('sem_only').checked = false;
        _('reg_only').checked = false;
        
        //_('exam_reg_only').checked = false;
        //_('app_close_open_date_only').checked = false;
    }

    
    function showttOnly()
    {        
        var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
        for (j = 0; j <= ulChildNodes.length-1; j++)
        {
            ulChildNodes[j].style.display = 'none';
        }
        
        var formdata = new FormData();
        
        if (_('opsions_loc').show_tt.checked)
        {
            formdata.append("showttOnly", 1);
        }else
        {
            formdata.append("showttOnly", 0);
        }        

        formdata.append("ilin", _('nxt').ilin.value);
        
        //formdata.append("currency_cf", _("currency_cf").value);
        formdata.append("vApplicationNo", _('opsions_loc').vApplicationNo.value);
        formdata.append("user_cat", _('opsions_loc').user_cat.value);
        formdata.append("tabno", _('tabno').value);
        opr_prep(ajax = new XMLHttpRequest(),formdata);
    }
</script>

<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />
<noscript>Please, enable JavaScript on your browser</noscript>

<!-- InstanceBeginEditable name="head" --><?php

//require_once ('set_scheduled_dates.php');?>
<!-- InstanceEndEditable -->
</head>
<body onLoad="checkConnection()">
    <?php admin_frms(); $has_matno = 0;?>
	
	<form action="staff_home_page" method="post" name="nxt" id="nxt" enctype="multipart/form-data">
		<input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
        <input name="uvApplicationNo" id="uvApplicationNo" type="hidden" />
		<input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST['vMatricNo'])){echo $_REQUEST['vMatricNo']; }?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
		<input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
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
	
	<!-- InstanceBeginEditable name="nakedbody" --><div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
        
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
    require_once("deages_cal.php");
    require_once("chd_cal.php");
    require_once("spgs_cal.php");?>
    <div id="conf_box_loc" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
        <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
            Confirmation
        </div>
        <a href="#" style="text-decoration:none;">
            <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
        </a>
        <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;">
            Save chnage(s)??
        </div>
        <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
            <a href="#" style="text-decoration:none;" 
                onclick="_('conf_box_loc').style.display='none';
                _('smke_screen_2').style.display='none';
                _('smke_screen_2').style.zIndex='-1';
                _('labell_msg0').style.display = 'none';
                _('opsions_loc').conf.value='1';
                chk_inputs();
                return false">
                <div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
                    Yes
                </div>
            </a>

            <a href="#" style="text-decoration:none;" 
                onclick="_('opsions_loc').conf.value='';
                _('conf_box_loc').style.display='none';
                _('smke_screen_2').style.display='none';
                _('smke_screen_2').style.zIndex='-1';
                _('labell_msg0').style.display = 'none';
                return false">
                <div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
                    No
                </div>
            </a>
        </div>
    </div><?php
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
	<div id="rtlft_std" style="position:relative; overflow:auto; overflow-x: hidden;">
		<!-- InstanceBeginEditable name="EditRegion6" -->			
			
        <div class="innercont_top">Settings</div>

        <div class="innercont_stff" id="enq_ans_div">  
            <div id="cover_tab" class="frm_element_tab_cover frm_element_tab_cover_std"><?php
                if (!($mm == 2 && $sm == 9))
                {?>
                    <a href="#" onclick="tab_modify('1')">
                        <div id="tabss1" class="tabss tabss_std" style=" border-bottom:1px solid #FFFFFF;">
                            Contact
                        </div>
                    </a>
                    <a href="#" onclick="tab_modify('2')">
                        <div id="tabss2" class="tabss tabss_std">
                            Date and time
                        </div>
                    </a>
                    <a href="#" onclick="tab_modify('3')">
                        <div id="tabss3" class="tabss tabss_std">
                            Matriculation number
                        </div>
                    </a><?php
                }?>
                <a href="#" onclick="tab_modify('4')">
                    <div id="tabss4" class="tabss tabss_std">
                        Options
                    </div>
                </a>
                <a href="#" onclick="tab_modify('5')">
                    <div id="tabss5" class="tabss tabss_std">
                        Exam Timetable
                    </div>
                </a>
            </div>
        </div>

        <form action="set-options" method="post" name="opsions_loc" id="opsions_loc" enctype="multipart/form-data"><?php
            frm_vars();
            $tabno = '';
            if (isset($_REQUEST['save_cf']))
            {
                $tabno = $_REQUEST['tabno'];
            }else if ($_REQUEST['mm'] == 2 && $_REQUEST['sm'] == 9)
            {
                $tabno = '4';
            }else{$tabno = '1';}?>
						
            <input name="tIdl_time_only" id="tIdl_time_only" type="hidden" value="0" />
            <input name="iextend_reg_only" id="iextend_reg_only" type="hidden" value="0" />
            <input name="iextend_tma_only" id="iextend_tma_only" type="hidden" value="0" />
                                    
            <input name="save_cf" id="save_cf" type="hidden" value="-1" />
            <input name="tabno" id="tabno" type="hidden" value="<?php echo $tabno;?>"/>
            <input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
            <input name="frm_upd" id="frm_upd" type="hidden" />
            <input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />

            
            <select name="State_readup" id="State_readup" style="display:none"><?php	
                $sql = "select cStateId,cCountryId,vStateName from ng_state order by vStateName";
                $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                while ($rs = mysqli_fetch_array($rssql))
                {?>
                    <option value="<?php echo $rs['cStateId'].$rs['cCountryId'];?>"><?php echo $rs['vStateName']; ?></option><?php
                }
                mysqli_close(link_connect_db());?>
            </select>

            <select name="LGA_readup" id="LGA_readup" style="display:none"><?php	
                $sql = "select cStateId,cLGAId, vLGADesc from localarea order by vLGADesc";
                $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                while ($rs = mysqli_fetch_array($rssql))
                {?>
                    <option value="<?php echo $rs['cStateId'].$rs['cLGAId'];?>"><?php echo ucwords (strtolower ($rs["vLGADesc"]))?></option><?php
                }
                mysqli_close(link_connect_db());?>
            </select>
            
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
            
            <div class="innercont_stff_tabs" id="ans1" style="height:auto; width:100%; padding:0px; margin-top:5px;; display:<?php if (!($mm == 2 && $sm == 9)){?>block<?php }else{?>none<?php }?>;"><?php
                $vOrgName = $orgsetins['vOrgName'];
                $cOrgCountryId = $orgsetins['cOrgCountryId'];
                $cOrgStateId = $orgsetins['cOrgStateId'];
                $cOrgStateId_chnge = $cOrgStateId;
                
                $cOrgLGAId = $orgsetins['cOrgLGAId'];
                $vOrgCityName = $orgsetins['vOrgCityName'];
                $vEMailId = $orgsetins['vEMailId'];
                $vMobileNo1 = $orgsetins['vMobileNo1'];
                $vMobileNo2 = $orgsetins['vMobileNo2'];?>
                <div class="innercont_stff" style="margin-top:15px">
                    <label for="vOrgName" class="labell" style="width:205px">Name of instituion<font color="#FF0000">*</font></label>
                    <div class="div_select">
                        <input name="vOrgName" id="vOrgName" type="text" onchange="this.value=this.value.trim();this.value=capitalizeEachWord(this.value);" class="textbox" value="<?php  echo stripslashes($vOrgName);?>" />
                    </div>
                    <div id="labell_msg0" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>
                
                <div class="innercont_stff">
                    <label for="cOrgCountryId" class="labell" style="width:205px">Country<font color="#FF0000">*</font></label>
                    <div class="div_select"><?php
                        $sqlcCountryId="select cCountryId, vCountryName from country order by vCountryName";
                        $rsqlcCountryId=mysqli_query(link_connect_db(), $sqlcCountryId)or die("cannot query the table".mysqli_error(link_connect_db()));?>
                        <select name="cOrgCountryId" id="cOrgCountryId" onchange="update_cat_country('cOrgCountryId', 'State_readup', 'cOrgStateId', 'cOrgLGAId')" class="select">
                            <option selected="selected" ></option><?php
                            while ($table=mysqli_fetch_array($rsqlcCountryId))
                            {?>
                                <option value="<?php echo $table["cCountryId"]?>"<?php if ($cOrgCountryId == $table["cCountryId"])
                                {echo ' selected';} ?>> <?php echo ucwords (strtolower ($table["vCountryName"]))?> </option>
                                <?php
                            }
                            mysqli_close(link_connect_db());?>
                        </select>
                    </div>
                    <div id="labell_msg1" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>
                
                <div class="innercont_stff">
                    <label for="cOrgStateId" class="labell" style="width:205px">State<font color="#FF0000">*</font></label>
                    <div class="div_select"><?php
                        if($cOrgCountryId == 'NG')
                        {
                            $sql1 = "select cStateId,vStateName from ng_state where cCountryId = '$cOrgCountryId' order by vStateName";
                        }else
                        {
                            $sql1 = "select cStateId,vStateName from ng_state where cCountryId = '99' order by vStateName";
                        }
                        //echo $sql1;
                        $rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
                        <select name="cOrgStateId" id="cOrgStateId" onchange="update_cat_country('cOrgStateId', 'LGA_readup', 'cOrgLGAId', 'cOrgLGAId')" class="select">
                            <option value="" selected></option><?php
                            while ($table=mysqli_fetch_array($rsql1))
                            {?>
                                <option value="<?php echo $table["cStateId"]?>"<?php if ($cOrgStateId == $table["cStateId"])
                                    {echo ' selected';} ?>><?php echo ucwords (strtolower ($table["vStateName"]))?></option>
                                <?php
                            }
                            mysqli_close(link_connect_db());?>
                        </select>
                    </div>
                    <div id="labell_msg2" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>
                
                <div class="innercont_stff">
                    <label for="cOrgLGAId" class="labell" style="width:205px">Local Govt. Area of origin<font color="#FF0000">*</font></label>
                    <div class="div_select"><?php
                            $sql1 = "select b.cLGAId,b.vLGADesc
                            from localarea b, ng_state c
                            where b.cStateId = c.cStateId and c.cStateId = '$cOrgStateId_chnge'";
                        $rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
                        <select name="cOrgLGAId" id="cOrgLGAId" onchange="frm_upd.value=''" class="select">
                            <option value="" selected ></option><?php
                            while ($table=mysqli_fetch_array($rsql1))
                            {?>
                                <option value="<?php echo $table["cLGAId"]?>"<?php if (($cOrgLGAId == $table["cLGAId"]) || ($cOrgStateId == '' && $table["cLGAId"] == '9999')){echo ' selected';}?>> <?php echo ucwords (strtolower ($table["vLGADesc"]))?> </option><?php
                            }
                            mysqli_close(link_connect_db());?>
                        </select>
                    </div>
                    <div id="labell_msg3" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>
                
                <div class="innercont_stff">
                    <label for="vOrgCityName" class="labell" style="width:205px">Town</label>
                    <div class="div_select">
                        <input name="vOrgCityName" id="vOrgCityName" type="text" class="textbox" value="<?php if ($vOrgCityName <> ''){echo $vOrgCityName;}?>" onChange="this.value=capitalizeEachWord(this.value);" />
                    </div>
                    <div id="labell_msg4" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>
                
                <hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.2%; margin-top:10px; margin-bottom:0.8%;" />
                <div class="innercont_stff">
                    <label for="vEMailId" class="labell" style="width:205px">eMail address<font color="#FF0000">*</font></label>
                    <div class="div_select">
                        <input name="vEMailId" id="vEMailId" type="text" class="textbox" value="<?php  echo $vEMailId;?>" />
                    </div>
                    <div id="labell_msg5" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>						
                <div class="innercont_stff">
                    <label for="vMobileNo1" class="labell" style="width:205px">Mobile phone number 1<font color="#FF0000">*</font></label>
                    <div class="div_select">
                            <input name="vMobileNo1" id="vMobileNo1" type="text" class="textbox" value="<?php  echo $vMobileNo1;?>" />
                    </div>
                    <div id="labell_msg6" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>								
                <div class="innercont_stff">
                    <label for="vMobileNo2" class="labell" style="width:205px">Mobile phone number 2</label>
                    <div class="div_select">
                            <input name="vMobileNo2" id="vMobileNo2" type="text" class="textbox" value="<?php  echo $vMobileNo2;?>" />
                    </div>
                    <div id="labell_msg7" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>						
                <div class="innercont_stff">
                    <label for="sbtd_pix" class="labell" style="width:205px">Upload logo<font color="#FF0000">*</font></label>
                    <div class="div_select">
                            <input type="file" name="sbtd_pix" id="sbtd_pix"  style="width:223px" value="<?php if(isset($sbtd_pix)){echo $sbtd_pix;} ?>" >
                    </div>
                    <div class="labell_msg blink_text orange_msg" id="labell_msg8" style="width:475px"></div>
                </div>
            </div>
            
            <div class="innercont_stff_tabs" id="ans2" style="height:auto; width:100%; padding:0px; margin-top:5px;;"><?php
                $session_year0 = substr($orgsetins['cAcademicDesc'],0,4);
                //$session_year1 = substr($orgsetins['cAcademicDesc'],5,4);

                $sesdate0 = $orgsetins['sesdate0'];
                $sesdate1 = $orgsetins['sesdate1'];
                $semdate1 = $orgsetins['semdate1'];
                $semdate2 = $orgsetins['semdate2'];
    
                $regdate1 = $orgsetins['regdate1'];
                $regdate_100_200_2 = $orgsetins['regdate_100_200_2'];	
                $regdate_300_2 = $orgsetins['regdate_300_2'];

                $iextend_reg = $orgsetins['iextend_reg'];
    
                $tSemester = $orgsetins['tSemester'];
                
                $tmadate1 =  $orgsetins['tmadate1'];
                $tmadate2 =  $orgsetins['tmadate2'];
                $iextend_tma =  $orgsetins['iextend_tma'];

                $examdate1 =  $orgsetins['examdate1'];
                $examdate2 =  $orgsetins['examdate2'];
    
                $cemba_cempa_date1 =  $orgsetins['cemba_cempa_date1'];
                $cemba_cempa_date2 =  $orgsetins['cemba_cempa_date2'];
                

                $tIdl_time = $orgsetins['tIdl_time'];
                $semreg_fee_2 = $orgsetins['semreg_fee'];
                
                $cStudyCenterId = $orgsetins['cStudyCenterId'];
                
                $force_semester_open = $orgsetins['force_semester_open'];
                $force_session_open = $orgsetins['force_session_open'];
                $force_registration_open = $orgsetins['force_registration_open'];
                $force_examreg_open = $orgsetins['force_examreg_open'];?>
                
                <input name="curr_month" id="curr_month" type="hidden" value="<?php echo $today_mon; ?>" />
                <input name="curr_day" id="curr_day" type="hidden" value="<?php echo $today_day; ?>" />
                <input name="curr_year" id="curr_year" type="hidden" value="<?php echo $today_year; ?>" />
                
                <input name="curr_date" id="curr_date" type="hidden" value="<?php echo $today_day.$today_mon.$today_year; ?>" />
                
                <input name="semreg_fee_2" id="semreg_fee_2" value="<?php echo  $semreg_fee_2; ?>" type="hidden"/><?php
                if (substr($sesdate0,4,4)+1 == substr($sesdate1,4,4))
                {
                    $AcademicDesc = substr($sesdate0,4,4).'/'.substr($sesdate1,4,4);
                }else if (substr($sesdate0,4,4) == substr($sesdate1,4,4))
                {
                    $AcademicDesc = substr($sesdate0,4,4).'/'.(substr($sesdate1,4,4)+1);
                }?>

                
                <div class="innercont_stff" style="height:auto; margin-top:0.5%; text-align:right;">								
                    <div class="innercont_stff" style="height:auto; text-align:left; color:#FF3300; width:170px; float:left;"><?php
                        if ($session_open == 1)
                        {
                            echo 'Session open';
                        }else
                        {
                            echo 'Session closed';
                        }?>
                    </div>
                    <div class="innercont_stff" style="height:auto; text-align:left; color:#FF3300; width:170px; float:left;"><?php
                        if ($semester_open == 1)
                        {
                            echo 'Semester is open';
                        }else
                        {
                            echo 'Semester closed';
                        }?>
                    </div>
                    <div class="innercont_stff" style="height:auto; text-align:left; color:#FF3300; width:260px; float:left;"><?php
                        if ($reg_open_100_200 == 1)
                        {
                            echo 'Registration open for 100L and 200L';
                        }else
                        {
                            echo 'Registration closed for 100L and 200L';
                        }?>
                    </div>
                    
                    <div class="innercont_stff" style="height:auto; text-align:left; color:#FF3300; width:260px; float:left;"><?php
                        if ($reg_open_300 == 1)
                        {
                            echo 'Registration open for 300L and above';
                        }else
                        {
                            echo 'Registration closed for 300L and above';
                        }?>
                    </div>

                    
                    <div id="add_qual_div" class="submit_button_green" 
                        style="margin-left:0px; 
                        padding:7px 0px 7px 0px; 
                        width:80px;
                        float:right;
                        cursor:pointer;" 
                        title="Click to call up academic calendar for Directorate for Entrepreneurship and General Studies (DE&GS)"
                        onclick="_('degs_div').style.display='block';
                        _('degs_div').style.zIndex='3';
                        _('smke_screen_5').style.display='block';
                        _('smke_screen_5').style.zIndex='2';">
                        DE&GS
                    </div>
                    
                    <div id="add_qual_div" class="submit_button_green" 
                        style="margin-left:0px;
                        margin-right:7px;
                        padding:7px 0px 7px 0px; 
                        width:80px;
                        float:right;
                        cursor:pointer;" 
                        title="Click to call up academic calendar for Directorate for Human Resources Development (CHD)"
                        onclick="_('chd_div').style.display='block';
                        _('chd_div').style.zIndex='3';
                        _('smke_screen_5').style.display='block';
                        _('smke_screen_5').style.zIndex='2';">
                        CHD
                    </div>
                    
                    <div id="add_qual_div" class="submit_button_green" 
                        style="margin-left:0px;
                        margin-right:7px;
                        padding:7px 0px 7px 0px; 
                        width:80px;
                        float:right;
                        cursor:pointer;" 
                        title="Click to call up academic calendar for School of Postgraduate Studies (SPGS)"
                        onclick="_('spgs_div').style.display='block';
                        _('spgs_div').style.zIndex='3';
                        _('smke_screen_5').style.display='block';
                        _('smke_screen_5').style.zIndex='2';">
                        SPGS
                    </div>
                </div>
                
                <hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.2%; margin-top:0.5%; margin-bottom:0.8%;" />

                <div class="innercont_stff">
                    <input name="AcademicDesc" id="AcademicDesc" type="hidden" value="<?php echo substr($AcademicDesc, 0, 4); ?>" />
                    <label for="sesdate1" class="labell" style="width:320px;">Session</label>
                    <div class="div_select" style="width:auto;"><?php 
                        $current=getdate();?>
                        <select name="session_year0" id="session_year0" class="select" style="width:auto" 
                            onchange="/*if(this.value!=''){_('session_year1').value=parseInt(this.value)+1}*/">
                            <option value="" selected="selected"></option><?php
                            for($i=$today_year-1;$i<=$today_year+1;$i++)
                            {?>
                                <option value="<?php echo $i; ?>"<?php if ($i == $session_year0){echo " selected";}?>> <?php echo $i;?></option><?php
                            }?>
                        </select> 
                        <!-- /<select name="session_year1" id="session_year1" class="select" style="width:auto" 
                            onchange="if(this.value!=''){_('session_year0').value=parseInt(this.value)-1}">
                            <option value="" selected="selected"></option><?php
                            //for($i=$today_year-2;$i<=$today_year+2;$i++)
                            //{?>
                                <option value="<?php //echo $i; ?>"<?php //if ($i == $session_year1){echo " selected";}?>> <?php //echo $i;?></option><?php
                            //}?>
                        </select> -->
                        <input name="session_year0_h" id="session_year0_h" type="hidden" value="<?php echo $session_year0;?>" />
                        <!-- <input name="session_year1_h" id="session_year1_h" type="hidden" value="<?php //echo $session_year1;?>" /> -->
                    </div>
                    <div id="labell_msg11a" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>


                <div class="innercont_stff" style="margin-top:10px;">
                    <input name="AcademicDesc" id="AcademicDesc" type="hidden" value="<?php echo $AcademicDesc; ?>" />
                    <label for="sesdate1" class="labell" style="width:320px;">Session begins on</label>
                    <div class="div_select" style="width:auto;"><?php 
                        $current=getdate();?>
                        <input type="date" name="sesdate0" id="sesdate0" class="textbox" style="height:99%; width:99%" 
                            value="<?php echo substr($sesdate0,4,4).'-'.substr($sesdate0,2,2).'-'.substr($sesdate0,0,2);?>"
                            onchange="_('sesdate1').min = this.value;
                            _('cemba_cempa_date1').min=this.value;
                            _('semdate1').min=this.value;
                            var date1 = new Date(this.value);
                            dd2 = date1.getDate();
                            dd2 = dd2.toString();
                            dd2 = dd2.padStart(2, 0);
                            mm2 =  date1.getMonth() + 1;
                            mm2 = mm2.toString();
                            mm2 = mm2.padStart(2, 0);
                            yy2 = date1.getFullYear();
                            new_date = yy2+'-'+mm2+'-'+dd2;
                            _('ac_open').value=new_date;

                            var day = date1.getDate() - 1;
                            date1.setDate(day);
                            dd2 = date1.getDate();
                            dd2 = dd2.toString();
                            dd2 = dd2.padStart(2, 0);
                            mm2 =  date1.getMonth() + 1;
                            mm2 = mm2.toString();
                            mm2 = mm2.padStart(2, 0);
                            yy2 = date1.getFullYear();
                            new_date = yy2+'-'+mm2+'-'+dd2;
                            _('ac_close').value=new_date;"
                            onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
                        <input name="sesdate0_h" id="sesdate0_h" type="hidden" value="<?php echo $sesdate0;?>" />
                    </div>
                    <div id="labell_msg11" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>

            
                <div class="innercont_stff" style="margin-top:10px;">
                    <label for="sesdate1" class="labell" style="width:320px;">Session ends on</label>
                    <div class="div_select" style="width:auto;"><?php 
                    $current=getdate();?>
                    <input type="date" name="sesdate1" id="sesdate1" class="textbox" style="height:99%; width:99%" 
                        value="<?php echo substr($sesdate1,4,4).'-'.substr($sesdate1,2,2).'-'.substr($sesdate1,0,2);?>"
                        onchange="_('cemba_cempa_date1').max=this.value;
                            _('cemba_cempa_date2').max=this.value;
                            _('semdate1').max=this.value;
                            _('semdate2').max=this.value;"
                        min="<?php echo substr($sesdate0,4,4).'-'.substr($sesdate0,2,2).'-'.substr($sesdate0,0,2);?>"
                        onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
                        <input name="sesdate1_h" id="sesdate1_h" type="hidden" value="<?php echo $sesdate1;?>" />
                    </div>
                    <div id="labell_msg12" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>


                <!--<div class="innercont_stff" style="margin-top:5px">
                    <div class="innercont" style="width:16px; float:left; height:19px; margin-right:3px;  margin-left:325px">
                        <input name="force_session_open" id="force_session_open" type="checkbox" 
                        onclick="if(this.checked){this.value='1'}else{this.value='0'}"
                        value="<?php echo $force_session_open;?>" 
                        <?php if ($force_session_open=='1'){echo ' checked';}?>/>
                    </div>							
                    <div class="innercont" style="width:auto; height:16px; float:left; padding-top:3px">
                        <label for="force_session_open">
                            Force session open
                        </label>
                    </div>
                </div>-->

                    
                <div class="innercont_stff" style="height:auto;  margin-top:10px;">
                    <div class="innercont" style="width:16px; float:left; height:19px; margin-right:3px; margin-left:325px">
                        <input name="ses_only" id="ses_only" type="checkbox"/>
                    </div>							
                    <div class="innercont" style="width:auto; height:16px; float:left; padding-top:3px">
                        <label for="ses_only">
                            Update only this section
                        </label>
                    </div>
                </div>

                <hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.2%; margin-top:10px; margin-bottom:0.8%;" />
                
                <div class="innercont_stff">
                    <label for="tSemester0" class="labell" style="width:320px;">Semester</label>
                    <div class="div_select" style="width:auto">
                    <select name="tSemester0" id="tSemester0" class="select" style="width:auto">
                        <option value="" selected="selected"></option>
                        <option value="1" <?php if ($tSemester == 1){echo ' selected';}?>>1</option>
                        <option value="2" <?php if ($tSemester == 2){echo ' selected';}?>>2</option>
                    </select>
                    <input name="tSemester0_h" id="tSemester0_h" type="hidden" value="<?php echo $tSemester;?>" />
                    </div>
                    <div id="labell_msg13" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>

            
                <div class="innercont_stff" style="margin-top:10px">
                    <label for="semdate1" class="labell" style="width:320px;">Semester begins on</label>
                    <div class="div_select" style="width:auto">
                        <input type="date" name="semdate1" id="semdate1" class="textbox" style="height:99%; width:99%" 
                            value="<?php echo substr($semdate1,4,4).'-'.substr($semdate1,2,2).'-'.substr($semdate1,0,2);?>"
                            min="<?php echo substr($sesdate0,4,4).'-'.substr($sesdate0,2,2).'-'.substr($sesdate0,0,2);?>"
                            max="<?php echo substr($sesdate1,4,4).'-'.substr($sesdate1,2,2).'-'.substr($sesdate1,0,2);?>"
                            onchange="_('semdate2').min = this.value;
                            _('regdate1').min = this.value;
                            _('tmadate1').min = this.value;
                            _('examdate1').min = this.value;"
                            onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
                        <input name="semdate1_h" id="semdate1_h" type="hidden" value="<?php echo $semdate1;?>" />
                    </div>
                    <div id="labell_msg14" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>
                
                <div class="innercont_stff" style="margin-top:10px">
                    <label for="semdate2" class="labell" style="width:320px;">Semester ends on</label>
                    <div class="div_select" style="width:auto">
                        <input type="date" name="semdate2" id="semdate2" class="textbox" style="height:99%; width:99%" 
                            value="<?php echo substr($semdate2,4,4).'-'.substr($semdate2,2,2).'-'.substr($semdate2,0,2);?>"
                            min="<?php echo substr($semdate1,4,4).'-'.substr($semdate1,2,2).'-'.substr($semdate1,0,2);?>"
                            max="<?php echo substr($sesdate1,4,4).'-'.substr($sesdate1,2,2).'-'.substr($sesdate1,0,2);?>"
                            onchange="_('regdate1').max = this.value;
                            _('regdate_100_200_2').max = this.value;
                            _('regdate_300_2').max = this.value;
                            _('tmadate1').max = this.value;
                            _('tmadate2').max = this.value;
                            _('examdate1').max = this.value;
                            _('examdate2').max = this.value;"
                            onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
                        <input name="semdate2_h" id="semdate2_h" type="hidden" value="<?php echo $semdate2;?>" />
                    </div>
                    <div id="labell_msg15" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>                
                
                    
                <div class="innercont_stff" style="height:auto;  margin-top:10px;">
                    <div class="innercont" style="width:16px; float:left; height:19px; margin-right:3px; margin-left:325px">
                        <input name="sem_only" id="sem_only" type="checkbox" value="1"/>
                    </div>							
                    <div class="innercont" style="width:auto; height:16px; float:left; padding-top:3px">
                        <label for="sem_only">
                            Update only this section
                        </label>
                    </div>
                </div>

                
                <hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.2%; margin-top:10px; margin-bottom:0.8%;" />
                
                
                <div class="innercont_stff">
                    <label for="regdate1" class="labell" style="width:320px;">Registration begins on</label>
                    <div class="div_select" style="width:auto">
                        <input type="date" name="regdate1" id="regdate1" class="textbox" style="height:99%; width:99%" 
                            value="<?php echo substr($regdate1,4,4).'-'.substr($regdate1,2,2).'-'.substr($regdate1,0,2);?>"
                            min="<?php echo substr($semdate1,4,4).'-'.substr($semdate1,2,2).'-'.substr($semdate1,0,2);?>"
                            max="<?php echo substr($semdate2,4,4).'-'.substr($semdate2,2,2).'-'.substr($semdate2,0,2);?>"
                            onchange="_('regdate_100_200_2').min = this.value; 
                            _('regdate_300_2').min = this.value;                            
                            _('tmadate1').min = this.value;"
                            onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
                        <input name="regdate1_h" id="regdate1_h" type="hidden" value="<?php echo $semdate1;?>" />
                    </div>
                    <div id="labell_msg16" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>
            
                
                <div class="innercont_stff">
                    <label for="regdate_100_200_2" class="labell" style="width:320px;">Registration for 100L-200L ends on</label>
                    <div class="div_select" style="width:auto">
                        <input type="date" name="regdate_100_200_2" id="regdate_100_200_2" class="textbox" style="height:99%; width:99%" 
                            value="<?php echo substr($regdate_100_200_2,4,4).'-'.substr($regdate_100_200_2,2,2).'-'.substr($regdate_100_200_2,0,2);?>"
                            min="<?php echo substr($regdate1,4,4).'-'.substr($regdate1,2,2).'-'.substr($regdate1,0,2);?>"
                            max="<?php echo substr($semdate2,4,4).'-'.substr($semdate2,2,2).'-'.substr($semdate2,0,2);?>"
                            onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false"
                            onchange="_('student_req1').max=this.value;
                            
                            _('student_req1').value=this.value;
                            _('student_req1').stepDown(14);">
                    </div>
                    <div id="labell_msg17" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>
            
                
                <div class="innercont_stff" style="margin-top:10px;">
                    <label for="regdate_300_2" class="labell" style="width:320px; color:#FF3300">Registration for 300L and above ends on</label>
                    <div class="div_select" style="width:auto">
                        <input type="date" name="regdate_300_2" id="regdate_300_2" class="textbox" style="height:99%; width:99%" 
                            value="<?php echo substr($regdate_300_2,4,4).'-'.substr($regdate_300_2,2,2).'-'.substr($regdate_300_2,0,2);?>"
                            min="<?php echo substr($regdate1,4,4).'-'.substr($regdate1,2,2).'-'.substr($regdate1,0,2);?>"
                            max="<?php echo substr($semdate2,4,4).'-'.substr($semdate2,2,2).'-'.substr($semdate2,0,2);?>"
                            onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false"
                            onchange="_('student_req2').max=this.value;
                            
                            _('student_req2').value=this.value;
                            _('student_req2').stepDown(14);">
                    </div>
                    <div id="labell_msg17a" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>


                <!-- <div class="innercont_stff">
                    <label for="iextend_reg" class="labell" style="width:320px;">Extend registration for</label>
                    <div class="div_select" style="width:auto">
                    <select name="iextend_reg" id="iextend_reg" class="select" style="width:auto" onchange="_('iextend_reg_only').value='1';idlTimeOnly()">
                    <option value="0" selected>0</option><?php
                        for($i=1;$i<=30;$i++)
                        {?>
                            <option value="<?php echo $i; ?>"<?php if ($i == $iextend_reg){echo " selected";}?>><?php echo $i;?></option><?php
                        }?>
                    </select> (day)
                    </div>
                    <div id="labell_msg18" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>

                <div class="innercont_stff" style="margin-top:5px">
                    <div class="innercont" style="width:16px; float:left; height:19px; margin-right:3px;  margin-left:325px">
                        <input name="force_registration_open" id="force_registration_open" type="checkbox" 
                        onclick="if(this.checked){this.value='1'}else{this.value='0'}"
                        value="<?php echo $force_registration_open;?>" 
                        <?php if ($force_registration_open=='1'){echo ' checked';}?>/>
                    </div>							
                    <div class="innercont" style="width:auto; height:16px; float:left; padding-top:3px">
                        <label for="force_registration_open">
                            Force registration open
                        </label>
                    </div>
                </div>-->

                
                <div class="innercont_stff" style="height:auto; margin-top:10px;">
                    <div class="innercont" style="width:16px; float:left; height:19px; margin-right:3px;  margin-left:325px">
                        <input name="reg_only" id="reg_only" type="checkbox" value="1"/>
                    </div>							
                    <div class="innercont" style="width:auto; height:16px; float:left; padding-top:3px">
                        <label for="reg_only">
                            Update only this section
                        </label>
                    </div>
                </div>
                
                <hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.2%; margin-top:10px; margin-bottom:0.8%;" />
                
                <div class="innercont_stff" style="margin-top:10px; height:auto; border-top:1px dashed #ccc">
                    <div class="innercont_stff" style="margin-top:10px"><?php
                        $statte = '';				
                        if ($orgsetins['onlineca'] == '0'){$statte = 'disabled';}?>
    
                        <label for="tmadate1" class="labell" style="width:320px;">TMA begins on</label>
                        <div class="div_select" style="width:auto">
                            <input type="date" name="tmadate1" id="tmadate1" class="textbox" style="height:99%; width:99%" 
                                value="<?php echo substr($tmadate1,4,4).'-'.substr($tmadate1,2,2).'-'.substr($tmadate1,0,2);?>"
                                onchange="_('tmadate2').min = this.value;
                                _('examdate1').min = this.value;
                                _('examdate1').min = this.value;"
                                min="<?php echo substr($regdate1,4,4).'-'.substr($regdate1,2,2).'-'.substr($regdate1,0,2);?>"
                                max="<?php echo substr($semdate2,4,4).'-'.substr($semdate2,2,2).'-'.substr($semdate2,0,2);?>"
                                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false" <?php echo $statte;?>>
                        </div>
                        <div id="labell_msg19" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                    </div>
                
                    
                    <div class="innercont_stff">
                        <label for="tmadate2" class="labell" style="width:320px;">TMA ends on</label>
                        <div class="div_select" style="width:auto">
                            <input type="date" name="tmadate2" id="tmadate2" class="textbox" style="height:99%; width:99%" 
                                value="<?php echo substr($tmadate2,4,4).'-'.substr($tmadate2,2,2).'-'.substr($tmadate2,0,2);?>"
                                min="<?php echo substr($tmadate1,4,4).'-'.substr($tmadate1,2,2).'-'.substr($tmadate1,0,2);?>"
                                max="<?php echo substr($semdate2,4,4).'-'.substr($semdate2,2,2).'-'.substr($semdate2,0,2);?>"
                                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false" <?php echo $statte;?>>
                        </div>
                        <div id="labell_msg20" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                    </div>
                    
                    
                    <div class="innercont_stff">
                        <label for="iextend_tma" class="labell" style="width:320px;">Extend TMA for</label>
                        <div class="div_select" style="width:auto">
                        <select name="iextend_tma" id="iextend_tma" class="select" style="width:auto" <?php echo $statte;?> onchange="_('iextend_tma_only').value='1';idlTimeOnly()">
                        <option value="0" selected>0</option><?php
                            for($i=1;$i<=30;$i++)
                            {?>
                                <option value="<?php echo $i; ?>"<?php if ($i == $iextend_tma){echo " selected";}?>><?php echo $i;?></option><?php
                            }?>
                        </select> (day)
                        </div>
                        <div id="labell_msg21" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                    </div>
                    
                    
                    <div class="innercont_stff" style="margin-top:10px">
                        <div class="innercont" style="width:16px; float:left; height:19px; margin-left:325px; margin-right:3px">
                            <input name="tma_only" id="tma_only" type="checkbox" <?php echo $statte;?> value="1"/>
                        </div>							
                        <div class="innercont" style="width:auto; height:16px; float:left; padding-top:3px">
                            <label for="tma_only">
                                Update only this section
                            </label>
                        </div>
                    </div>
                </div>

                
                <div class="innercont_stff" style="margin-top:10px; height:auto; border-top:1px dashed #ccc">
                    <div class="innercont_stff" style="margin-top:10px">
                        <label for="examdate1" class="labell" style="width:320px;">Exams begin on</label>
                        <div class="div_select" style="width:auto">
                            <input type="date" name="examdate1" id="examdate1" class="textbox" style="height:99%; width:99%" 
                            value="<?php echo substr($examdate1,4,4).'-'.substr($examdate1,2,2).'-'.substr($examdate1,0,2);?>"
                            min="<?php echo substr($tmadate1,4,4).'-'.substr($tmadate1,2,2).'-'.substr($tmadate1,0,2);?>"
                            max="<?php echo substr($semdate2,4,4).'-'.substr($semdate2,2,2).'-'.substr($semdate2,0,2);?>"
                            onchange="_('examdate2').min = this.value;"
                            onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
                        </div>
                        <div id="labell_msg41" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                    </div>

                    
                    <div class="innercont_stff">
                        <label for="examdate2" class="labell" style="width:320px;">Exams end on</label>
                        <div class="div_select" style="width:auto">
                            <input type="date" name="examdate2" id="examdate2" class="textbox" style="height:99%; width:99%" 
                                value="<?php echo substr($examdate2,4,4).'-'.substr($examdate2,2,2).'-'.substr($examdate2,0,2);?>"
                                min="<?php echo substr($examdate1,4,4).'-'.substr($examdate1,2,2).'-'.substr($examdate1,0,2);?>"
                                max="<?php echo substr($semdate2,4,4).'-'.substr($semdate2,2,2).'-'.substr($semdate2,0,2);?>"
                                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
                        </div>
                        <div id="labell_msg42" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                    </div>
                    
                    
                    <div class="innercont_stff" style="margin-top:10px">
                        <div class="innercont" style="width:16px; float:left; height:19px; margin-left:325px; margin-right:3px">
                            <input name="exam_only" id="exam_only" type="checkbox" value="1"/>
                        </div>							
                        <div class="innercont" style="width:auto; height:16px; float:left; padding-top:3px">
                            <label for="exam_only">
                                Update only this section
                            </label>
                        </div>
                    </div>
                </div>

                <!-- <div class="inline_dashed_hrline"></div> -->

                
                <hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.2%; margin-top:10px; margin-bottom:0.8%;" />                
                
                <div class="innercont_stff">
                    <label for="tIdl_time" class="labell" style="width:320px;">System idle time (min)</label>
                    <div class="div_select" style="width:auto">
                        <select name="tIdl_time" id="tIdl_time" class="select" style="width:auto" onchange="_('tIdl_time_only').value='1';idlTimeOnly()"><?php
                            for($i=1;$i<=60;$i++)
                            {?>
                                <option value="<?php echo $i; ?>"<?php if ($i == $tIdl_time){echo " selected";}?>><?php echo $i;?></option><?php
                            }?>
                        </select>
                    </div>
                        <div id="labell_msg22" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>
                
                <!-- <hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.2%; margin-top:10px; margin-bottom:0.8%;" />                
                
                <div class="innercont_stff">				
                    <label class="labell" style="width:320px;">Application ends on</label>
                    <div class="div_select" style="width:auto;">
                        <input type="date" name="app_close_open_date" id="app_close_open_date" class="textbox" style="height:99%; width:99%" value="<?php //echo substr($app_close_open_date,4,4).'-'.substr($app_close_open_date,2,2).'-'.substr($app_close_open_date,0,2);?>">
                    </div>
                    <div id="labell_msg23" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>
                    
                <div class="innercont_stff" style="height:auto;  margin-top:10px;">
                    <div class="innercont" style="width:16px; float:left; height:19px; margin-left:325px; margin-right:3px">
                        <input name="app_close_open_date_only" id="app_close_open_date_only" type="checkbox" value="1"/>
                    </div>							
                    <div class="innercont" style="width:auto; height:16px; float:left; padding-top:3px">
                        <label for="app_close_open_date_only">
                            Update only this section
                        </label>
                    </div>
                </div>
                                
                <hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.2%; margin-top:10px; margin-bottom:0.8%;" />
                
                <div class="innercont_stff">				
                    <label class="labell" style="width:320px;">Session of application</label>
                    <div class="div_select" style="width:auto;">
                        <select name="applic_session0" id="applic_session0" class="select" style="width:auto" 
                            onchange="if(this.value!=''){_('applic_session1').value=parseInt(this.value)+1}">
                            <option value="" selected="selected"></option><?php
                            for($i=$today_year-3;$i<=$today_year;$i++)
                            {?>
                                <option value="<?php //echo $i; ?>"<?php //if ($i == $applic_session0){echo " selected";}?>> <?php //echo $i;?></option><?php
                            }?>
                        </select> /
                        <select name="applic_session1" id="applic_session1" class="select" style="width:auto" 
                            onchange="if(this.value!=''){_('applic_session0').value=parseInt(this.value)-1}">
                            <option value="" selected="selected"></option><?php
                            for($i=$today_year-2;$i<=$today_year+1;$i++)
                            {?>
                                <option value="<?php //echo $i; ?>"<?php //if ($i == $applic_session1){echo " selected";}?>> <?php //echo $i;?></option><?php
                            }?>
                        </select>
                        <input name="applic_session" id="applic_session" type="hidden" value="<?php //echo $applic_session0.'/'.$applic_session1;?>" />
                    </div>
                    <div id="labell_msg24" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>
                    
                <div class="innercont_stff" style="margin-top:10px">
                    <div class="innercont" style="width:16px; float:left; height:19px; margin-left:325px; margin-right:3px">
                        <input name="applic_session_only" id="applic_session_only" type="checkbox" value="1"/>
                    </div>							
                    <div class="innercont" style="width:auto; height:16px; float:left; padding-top:3px">
                        <label for="applic_session_only">
                            Update only this section
                        </label>
                    </div>
                </div>

                <hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.2%; margin-top:10px; margin-bottom:0.8%;" />
                
                <div class="innercont_stff">				
                    <label class="labell" style="width:320px;">Date on admission letter</label>
                    <div class="div_select" style="width:auto;">
                        <input type="date" name="admission_letter_date" id="admission_letter_date" class="textbox" style="height:99%; width:99%" value="<?php //echo substr($admission_letter_date,4,4).'-'.substr($admission_letter_date,2,2).'-'.substr($admission_letter_date,0,2);?>">
                    </div>
                    <div id="labell_msg24a" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                </div>
                    
                <div class="innercont_stff"style="margin-top:10px;">
                    <div class="innercont" style="width:16px; float:left; height:19px; margin-left:325px; margin-right:3px">
                        <input name="admission_letter_date_only" id="admission_letter_date_only" type="checkbox" value="1"/>
                    </div>							
                    <div class="innercont" style="width:auto; height:16px; float:left; padding-top:3px">
                        <label for="admission_letter_date_only">
                            Update only this section
                        </label>
                    </div>
                </div> -->

                
                
                <hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.2%; margin-top:10px; margin-bottom:0.8%;" /> 

                <div class="innercont_stff" style="margin-top:10px; height:auto; border-top:1px dashed #ccc">
                    <div class="innercont_stff" style="margin-top:10px">
                        <label class="labell" style="width:320px;">CEMBA/CEMPA application</label>
                    </div>
                    
                    <div class="innercont_stff" style="margin-top:10px">
                        <label for="cemba_cempa_date1" class="labell" style="width:320px;">Commencement date</label>
                        <div class="div_select" style="width:auto">
                            <input type="date" name="cemba_cempa_date1" id="cemba_cempa_date1" class="textbox" style="height:99%; width:99%" 
                                value="<?php echo substr($cemba_cempa_date1,4,4).'-'.substr($cemba_cempa_date1,2,2).'-'.substr($cemba_cempa_date1,0,2);?>"
                                onchange="_('cemba_cempa_date2').min = this.value;"
                                min="<?php echo substr($sesdate0,4,4).'-'.substr($sesdate0,2,2).'-'.substr($sesdate0,0,2);?>"
                                max="<?php echo substr($sesdate1,4,4).'-'.substr($sesdate1,2,2).'-'.substr($sesdate1,0,2);?>"
                                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
                        </div>
                        <div id="labell_msg41" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                    </div>

                    <div class="innercont_stff">
                        <label for="cemba_cempa_date2" class="labell" style="width:320px;">Clossing date</label>
                        <div class="div_select" style="width:auto">
                            <input type="date" name="cemba_cempa_date2" id="cemba_cempa_date2" class="textbox" style="height:99%; width:99%" 
                            value="<?php echo substr($cemba_cempa_date2,4,4).'-'.substr($cemba_cempa_date2,2,2).'-'.substr($cemba_cempa_date2,0,2);?>"
                            min="<?php echo substr($cemba_cempa_date1,4,4).'-'.substr($cemba_cempa_date1,2,2).'-'.substr($cemba_cempa_date1,0,2);?>"
                            max="<?php echo substr($sesdate1,4,4).'-'.substr($sesdate1,2,2).'-'.substr($sesdate1,0,2);?>"
                            onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
                        </div>
                        <div id="labell_msg42" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                    </div>
                    
                    <div class="innercont_stff" style="margin-top:10px">
                        <div class="innercont" style="width:16px; float:left; height:19px; margin-left:325px; margin-right:3px">
                            <input name="cemba_cempa_only" id="cemba_cempa_only" type="checkbox" value="1"/>
                        </div>							
                        <div class="innercont" style="width:auto; height:16px; float:left; padding-top:3px">
                            <label for="cemba_cempa_only">
                                Update only this section
                            </label>
                        </div>
                    </div>
                </div>

                <!-- <div class="inline_dashed_hrline"></div> -->
            </div>
            
            <div class="innercont_stff_tabs" id="ans3" style="height:auto; width:100%; padding:0px; margin-top:5px;;"><?php
                $stmt = $mysqli->prepare("SELECT matnoprefix1, 
                place_sepa1, 
                matnoprefix2, 
                place_sepa2, 
                matnosepa, 
                matnosufix, 
                place_sepa7, 
                prefix_by_faculty, 
                place_sepa3, 
                prefix_by_dept, 
                place_sepa4, 
                prefix_by_yr, 
                place_sepa5, 
                matnumber, 
                sampl_compoMat, 
                mat_comp_orda, 
                uni_give_mat, 
                study_mode
                FROM mat_composi");
                $stmt->execute();
                $stmt->store_result();
            
                $stmt->bind_result($matnoprefix1, $place_sepa1, $matnoprefix2, $place_sepa2, $matnosepa, $matnosufix, $place_sepa7, $prefix_by_faculty, $place_sepa3, $prefix_by_dept, $place_sepa4, $prefix_by_yr, $place_sepa5, $matnumber, $sampl_compoMat, $mat_comp_orda, $uni_give_mat, $study_mode);
                $stmt->fetch();
                $stmt->close();?>
                
                <div class="innercont_stff">
                    <label for="matnoprefix1" class="labell" style="width:205px">Attachment 1</label>
                    <div class="div_select">
                        <input name="matnoprefix1" id="matnoprefix1" type="text" class="textbox" 
                            onblur="compose_number('matnoprefix1','1');
                            if(this.value=='')
                            {place_sepa_11.checked=false;
                            place_sepa_11.disabled=true;
                            place_sepa_12.checked=false;
                            place_sepa_12.disabled=true;
                            place_sepa1.value='';}
                            else{place_sepa_11.disabled=false;
                            place_sepa_12.disabled=false}" value="<?php  echo stripslashes($matnoprefix1);?>" />
                    </div>
                    <div class="div_select">
                        <input name="place_sepa_1" id="place_sepa_12" type="radio" value="0" 
                            onclick="_('place_sepa1').value='0';smpl_matno(matnoprefix1.value,this.value)" <?php if ($place_sepa1==''){echo 'disabled';}else if ($place_sepa1=='0'){echo 'checked';} ?>/>
                            <label for="place_sepa_12">Prefix</label>&nbsp;&nbsp;
                        <input name="place_sepa_1" id="place_sepa_11" type="radio" value="1" 
                            onclick="_('place_sepa1').value='1';smpl_matno(matnoprefix1.value,this.value)" <?php if ($place_sepa1==''){echo 'disabled';}else if ($place_sepa1=='1'){echo 'checked';} ?> />
                            <label for="place_sepa_11">Suffix</label>
                            <input name="place_sepa1" id="place_sepa1" type="hidden" value="<?php echo $place_sepa1 ?>" />
                    </div>
                </div>
                
                <div class="innercont_stff">
                    <label for="matnoprefix2" class="labell" style="width:205px">Attachment 2</label>
                    <div class="div_select">
                            <input name="matnoprefix2" id="matnoprefix2" type="text" class="textbox" 
                            onblur="compose_number('matnoprefix2','2');
                            if(this.value=='')
                            {place_sepa_21.checked=false;
                            place_sepa_21.disabled=true;
                            place_sepa_22.checked=false;
                            place_sepa_22.disabled=true;
                            place_sepa2.value='';}
                            else{place_sepa_21.disabled=false;
                            place_sepa_22.disabled=false;}" value="<?php  echo stripslashes($matnoprefix2);?>" />
                    </div>
                    <div class="div_select">
                        <input name="place_sepa_2" id="place_sepa_22" type="radio" value="0" 
                            onclick="_('place_sepa2').value='0';smpl_matno(matnoprefix2.value,this.value)" <?php if ($place_sepa2==''){echo 'disabled';}else if ($place_sepa2=='0'){echo 'checked';}else if ($place_sepa2=='0'){echo 'checked';} ?>/>
                            <label for="place_sepa_22">Prefix</label>&nbsp;&nbsp;
                        <input name="place_sepa_2" id="place_sepa_21" type="radio" value="1" 
                            onclick="_('place_sepa2').value='1';smpl_matno(matnoprefix2.value,this.value)" <?php if ($place_sepa2==''){echo 'disabled';}else if ($place_sepa2=='1'){echo 'checked';} ?> />
                            <label for="place_sepa_21">Suffix</label>
                        <input name="place_sepa2" id="place_sepa2" type="hidden" value="<?php echo $place_sepa2 ?>" />
                    </div>
                </div>
                
                <div class="innercont_stff">
                    <label for="prefix_by_faculty" class="labell" style="width:205px">Faculty 3</label>
                    <div class="div_select">
                        <input name="prefix_by_faculty" id="prefix_by_faculty" value="<?php echo $prefix_by_faculty ?>" 
                            type="checkbox" <?php if ($prefix_by_faculty=='1'){echo 'checked="checked"';}?>
                            onclick="if(this.checked)
                            {
                            prefix_by_faculty.value='1';
                            place_sepa_31.disabled=false;
                            place_sepa_32.disabled=false;
                            compose_number('prefix_by_faculty','3')}
                            else{
                            prefix_by_faculty.value='0';										
                            place_sepa_31.checked=false;
                            place_sepa_31.disabled=true;
                            place_sepa_32.checked=false;
                            place_sepa_32.disabled=true;
                            place_sepa3.value='';
                            compose_number('prefix_by_faculty','3')}"/>									
                    </div>
                    <div class="div_select">
                        <input name="place_sepa_3" id="place_sepa_32" type="radio" value="0" 
                            onclick="_('place_sepa3').value='0';smpl_matno('faculty',this.value)" <?php if ($place_sepa3==''){echo 'disabled';}else if ($place_sepa3=='0'){echo 'checked';} ?>/>
                            <label for="place_sepa_32">Prefix</label>&nbsp;&nbsp;
                        <input name="place_sepa_3" id="place_sepa_31" type="radio" value="1" 
                            onclick="_('place_sepa3').value='1';smpl_matno('faculty',this.value)" <?php if ($place_sepa3==''){echo 'disabled';}else if ($place_sepa3=='1'){echo 'checked';} ?> />
                            <label for="place_sepa_31">Suffix</label>
                        <input name="place_sepa3" id="place_sepa3" type="hidden" value="<?php echo $place_sepa3 ?>" />
                    </div>
                </div>	
                
                <div class="innercont_stff">
                    <label for="prefix_by_dept" class="labell" style="width:205px">Department 4</label>
                    <div class="div_select">
                        <input name="prefix_by_dept" id="prefix_by_dept" value="<?php echo $prefix_by_dept ?>"
                        type="checkbox" <?php if ($prefix_by_dept=='1'){echo 'checked="checked"';}?> 
                        onclick="if(this.checked)
                        {
                        prefix_by_dept.value='1';
                        place_sepa_41.disabled=false;
                        place_sepa_42.disabled=false;
                        compose_number('prefix_by_dept','4')}
                        else{
                        prefix_by_dept.value='0';										
                        place_sepa_41.checked=false;
                        place_sepa_41.disabled=true;
                        place_sepa_42.checked=false;
                        place_sepa_42.disabled=true;
                        place_sepa4.value='';
                        compose_number('prefix_by_dept','4')}"/>									
                    </div>
                    <div class="div_select">
                        <input name="place_sepa_4" id="place_sepa_42" type="radio" value="0" 
                            onclick="_('place_sepa4').value='0';smpl_matno('dept',this.value)" <?php if ($place_sepa4==''){echo 'disabled';}else if ($place_sepa4=='0'){echo 'checked';} ?>/>
                            <label for="place_sepa_42">Prefix</label>&nbsp;&nbsp;
                        <input name="place_sepa_4" id="place_sepa_41" type="radio" value="1" 
                            onclick="_('place_sepa4').value='1';smpl_matno('dept',this.value)" <?php if ($place_sepa4==''){echo 'disabled';}else if ($place_sepa4=='1'){echo 'checked';} ?> />
                            <label for="place_sepa_41">Suffix</label>
                        <input name="place_sepa4" id="place_sepa4" type="hidden" value="<?php echo $place_sepa4 ?>" />
                    </div>
                </div>						
                
                <div class="innercont_stff">
                    <label for="prefix_by_yr" class="labell" style="width:205px">Admission Year 5</label>
                    <div class="div_select">
                        <input name="prefix_by_yr" id="prefix_by_yr" value="<?php echo $prefix_by_yr ?>" 
                        type="checkbox" <?php if ($prefix_by_yr=='1'){echo 'checked="checked"';}?>
                            onclick="if(prefix_by_yr.checked)
                            {
                            prefix_by_yr.value='1';
                            place_sepa_51.disabled=false;
                            place_sepa_52.disabled=false;
                            compose_number('prefix_by_yr','5')}
                            else{
                            prefix_by_yr.value='0';										
                            place_sepa_51.checked=false;
                            place_sepa_51.disabled=true;
                            place_sepa_52.checked=false;
                            place_sepa_52.disabled=true;
                            place_sepa5.value='';
                            compose_number('prefix_by_yr','5')}" />
                    </div>
                    <div class="div_select">
                        <input name="place_sepa_5" id="place_sepa_52" type="radio" value="0" 
                            onclick="_('place_sepa5').value='0';smpl_matno('year',this.value)" <?php if ($place_sepa5==''){echo 'disabled';}else if ($place_sepa5=='0'){echo 'checked';} ?>/>
                            <label for="place_sepa_52">Prefix</label>&nbsp;&nbsp;
                        <input name="place_sepa_5" id="place_sepa_51" type="radio" value="1" 
                            onclick="_('place_sepa5').value='1';smpl_matno('year',this.value)" <?php if ($place_sepa5==''){echo 'disabled';}else if ($place_sepa5=='1'){echo 'checked';} ?> />
                            <label for="place_sepa_51">Suffix</label>
                        <input name="place_sepa5" id="place_sepa5" type="hidden" value="<?php echo $place_sepa5 ?>" />
                    </div>
                </div>
                
                <div class="innercont_stff">
                    <label for="vOrgName" class="labell" style="width:205px">Separator 6</label>
                    <div class="div_select">
                        <input name="matnosepa" id="matnosepa" type="text" class="textbox" value="<?php  echo stripslashes($matnosepa);?>" />
                    </div>
                </div>
                
                <div class="innercont_stff">
                    <label for="matnosufix" class="labell" style="width:205px">Attachment 7</label>
                    <div class="div_select">
                        <input name="matnosufix" id="matnosufix" type="text" class="textbox" 
                        onchange="compose_number('matnosufix','7');
                            if(this.value==''){place_sepa_71.checked=false;
                            place_sepa_71.disabled=true;
                            place_sepa_72.checked=false;
                            place_sepa_72.disabled=true;}
                            else{place_sepa_71.disabled=false;
                            place_sepa_72.disabled=false}" value="<?php  echo stripslashes($matnosufix);?>" />
                    </div>
                    <div class="div_select">
                        <input name="place_sepa_7" id="place_sepa_72" type="radio" value="0" 
                            onclick="_('place_sepa7').value='0';smpl_matno(matnosufix.value,this.value)" <?php if ($matnosufix==''){echo 'disabled';}else if ($place_sepa7=='0'){echo 'checked';}?>/>
                        <label for="place_sepa_72">Prefix</label>&nbsp;&nbsp;
                        <input name="place_sepa_7" id="place_sepa_71" type="radio" value="1" 
                            onclick="_('place_sepa7').value='1';smpl_matno(matnosufix.value,this.value)" <?php if ($matnosufix==''){echo 'disabled';}else if ($place_sepa7=='1'){echo 'checked';}?> />
                        <label for="place_sepa_71">Suffix</label>
                        <input name="place_sepa7" id="place_sepa7" type="hidden" value="<?php echo $place_sepa7 ?>" />
                    </div>
                </div>
                
                <div class="innercont_stff" style="margin-top:10px">
                    <label for="sampl_compoMat" class="labell" style="width:205px">Preview</label>
                    <div class="div_select">
                        <input type="text" class="textbox" readonly="true" id="sampl_compoMat" value="<?php if ($sampl_compoMat == ''){echo 'xxxxx';}else{echo $sampl_compoMat;}?>" ondblclick="this.value='xxxxx'" 
                        style="border:1px solid #cccccc; color:#666666;"/>
                    </div>
                    <div class="div_select">
                        <input name="mat_comp_orda" id="mat_comp_orda" type="text" class="textbox" readonly="true" value="<?php echo $mat_comp_orda ?>"style="border:1px solid #cccccc; color:#666666;"/>
                    </div>
                </div>
            </div>
            
            <div class="innercont_stff_tabs" id="ans4" style="height:auto; width:100%; padding:0px; margin-top:5px;; display:<?php if ($mm == 2 && $sm == 9){?>block<?php }else{?>none<?php }?>;"><?php 
                $studycenter = $orgsetins['studycenter'];
                $semster_adm = $orgsetins['semster_adm'];
                $ind_semster = $orgsetins['ind_semster'];
                
                $mail_req_rec1 = $orgsetins['mail_req_rec1'];
                $mail_req_rec2 = $orgsetins['mail_req_rec2'];
                $mail_req_rec3 = $orgsetins['mail_req_rec3'];
                
                $onlineca = $orgsetins['onlineca'];

                $cShowrslt_for_student = $orgsetins['cShowrslt_for_student'];
                $cShowrslt_for_staff = $orgsetins['cShowrslt_for_staff'];

                $cShowrslt = $orgsetins['cShowrslt'];                
                $cShowgrade = $orgsetins['cShowgrade'];
                $cShowscore = $orgsetins['cShowscore'];
                $cShowgpa = $orgsetins['cShowgpa'];							

                $sem_reg = $orgsetins['sem_reg'];
                $numoftma = $orgsetins['numoftma'];                
    
                $cShowtt = $orgsetins['cShowtt'];
                $loadfund = $orgsetins['cloadfund'];
                $cc_char = $orgsetins['cc_char'];
                $pc_char = $orgsetins['pc_char'];
                $rr_sys = $orgsetins['rr_sys'];
                
                $upld_passpic = $orgsetins['upld_passpic'];
                $upld_passpic_no = $orgsetins['upld_passpic_no'];
                $size_pp = $orgsetins['size_pp'];
                $size_cred = $orgsetins['size_cred'];
                $late_fee = $orgsetins['late_fee'];
                $late_regdate = $orgsetins['late_regdate'];
    
                $regexam = $orgsetins['regexam'];
                $drp_exam =  $orgsetins['drp_exam'];
                $drp_exam_2 =  $orgsetins['drp_exam_2'];

                $drp_examdate = $orgsetins['drp_examdate'];
                $drp_exam_2date = $orgsetins['drp_exam_2date'];

                $drp_crs =  $orgsetins['drp_crs'];
                $drp_crsdate = $orgsetins['drp_crsdate'];
                
                if ($orgsetins['student_req1'] <> '')
                {
                    $student_req1 = $orgsetins['student_req1'];
                }else if ($orgsetins['regdate_100_200_2'] <> '')
                {
                    $student_req1 = substr($orgsetins['regdate_100_200_2'],4,4).'-'.substr($orgsetins['regdate_100_200_2'],2,2).'-'.substr($orgsetins['regdate_100_200_2'],0,2);
                    $student_req1 = date('dmY', strtotime($student_req1. ' - 14 days'));
                }
                
                if ($orgsetins['student_req2'] <> '')
                {
                    $student_req2 = $orgsetins['student_req2'];
                }else if ($orgsetins['regdate_300_2'] <> '')
                {
                    $student_req2 = substr($orgsetins['regdate_300_2'],4,4).'-'.substr($orgsetins['regdate_300_2'],2,2).'-'.substr($orgsetins['regdate_300_2'],0,2);
                    $student_req2 = date('dmY', strtotime($student_req2. ' - 14 days'));
                }
                
                $semreg_fee = $orgsetins['semreg_fee'];
                
                $course_fee_cat = $orgsetins['course_fee_cat'];
                $course_fee_credit_unit = $orgsetins['course_fee_credit_unit'];
                $course_fee_course = $orgsetins['course_fee_course'];

                $exam_fee = $orgsetins['exam_fee'];
                $ewallet_cred_for_sem_reg = $orgsetins['ewallet_cred_for_sem_reg'];
                $ewallet_cred_for_ses_reg = $orgsetins['ewallet_cred_for_ses_reg'];
                
                $enforce_co = $orgsetins['enforce_co'];
                $transission_in_progress = $orgsetins['transission_in_progress'];
                $enforce_cc = $orgsetins['enforce_cc'];
                
                $overall_ex = $orgsetins['overall_ex'];
                $overall_ca = $orgsetins['overall_ca'];
                
                
                $max_login = $orgsetins['max_login'];
                $wait_max_login = $orgsetins['wait_max_login'];

                $uni_give_mat = $orgsetins['uni_give_mat'];
                
                $cStudyCenterId = $orgsetins['cStudyCenterId'];
                
                $period_of_result_upload = $orgsetins['period_of_result_upload'];
                $semester_of_result_upload = $orgsetins['semester_of_result_upload'];
                
                $session_of_result_upload = $orgsetins['session_of_result_upload'];
                $session_of_result_upload0 = substr($orgsetins['session_of_result_upload'],0,4);
                $session_of_result_upload1 = substr($orgsetins['session_of_result_upload'],5,4);
                
                $ac_open_date = $orgsetins['ac_open_date'];
                $ac_close_date = $orgsetins['ac_close_date'];
                

                $req_mail_level_cahnge = $orgsetins['req_mail_level_cahnge'];
                $req_mail_level_cahnge_cc1 = $orgsetins['req_mail_level_cahnge_cc1'];
                $req_mail_level_cahnge_cc2 = $orgsetins['req_mail_level_cahnge_cc2'];
                
                $req_mail_prog_cahnge = $orgsetins['req_mail_prog_cahnge'];
                $req_mail_prog_cahnge_cc1 = $orgsetins['req_mail_prog_cahnge_cc1'];
                $req_mail_prog_cahnge_cc2 = $orgsetins['req_mail_prog_cahnge_cc2'];

                $req_mail_cent_cahnge = $orgsetins['req_mail_cent_cahnge'];
                $req_mail_cent_cahnge_cc1 = $orgsetins['req_mail_cent_cahnge_cc1'];
                $req_mail_cent_cahnge_cc2 = $orgsetins['req_mail_cent_cahnge_cc2'];?>

                <!-- <div class="innercont_stff" style="height:30px; margin-top:3px;">
                    <div class="div_select" style="height:auto;width:auto;"><?php
                        //$rs_sql = mysqli_query(link_connect_db(), "SELECT study_mode_ID, study_mode_Desc FROM study_mode WHERE cdel = 'N' ORDER BY study_mode_ID;") or die(mysqli_error(link_connect_db()));?>
                        <select name="study_mode4" id="study_mode4" class="select" onChange="_('cStudyCenterId_div4').style.display = 'none';
                        if(this.value=='topup')
                        {
                            _('cStudyCenterId_div4').style.display = 'block';
                            if(_('cStudyCenterId4').value!='')
                            {
                                call_options();
                            }
                        }else if(this.value!='')
                        {
                            call_options();
                        }">
                            <option value="" selected>Select study mode</option>
                            <option disabled></option><?php
                            //while ($rs = mysqli_fetch_array($rs_sql))
                            //{
                                //if ($rs['study_mode_ID'] == 'topup' || $rs['study_mode_ID'] == 'odl_cert' || $rs['study_mode_ID'] == 'pre_degree' || $rs['study_mode_ID'] == 'regular_cert' || $rs['study_mode_ID'] == 'part_time')
                                //{?>
                                    <option disabled></option><?php
                                //}?>
                                <option value="<?php //echo $rs['study_mode_ID'];?>">
                                    <?php //echo $rs['study_mode_Desc'];?>
                                </option><?php
                            //}?>
                        </select>
                    </div>
                    <div id="labell_msg1d" class="labell_msg blink_text orange_msg" style="width:170px"></div>
                    <input name="call_options_val" id="call_options_val" type="hidden" value="0" />
                </div>

                <div id="cStudyCenterId_div4" class="innercont_stff" style="margin-bottom:5px; margin-top:3px; display:none">
                    <div class="div_select" style="height:auto;width:auto;"><?php
                        //$rs_sql = mysqli_query(link_connect_db(), "select cStudyCenterId, vCityName from studycenter order by study_mode_ID, vCityName") or die(mysqli_error(link_connect_db()));?>
                        <select name="cStudyCenterId4" id="cStudyCenterId4" class="select" onChange="call_options()">
                            <option value="" selected>Select study centre</option><?php
                            // $counter = 0;
                            // while ($table= mysqli_fetch_array($rs_sql))
                            // {?>
                                <option value="<?php //echo $table[0] ?>" <?php //if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] == $table[0]){echo ' selected';}?>><?php //echo $table[1];?></option><?php
                                //if (++$counter%5 == 0)
                                //{?>
                                    <option disabled></option><?php
                                //}
                            //}?>
                        </select>
                    </div>
                    <div id="labell_msg1f" class="labell_msg blink_text orange_msg" style="width:170px"></div>
                </div>--><?php
				if (!($mm == 2 && $sm == 10))
                {?>
                    <div class="innercont_stff" style="margin-top:0px;">
                        <div class="div_select" style="width:auto">
                            <input name="studycenter" id="studycenter" 
                            onclick="if(this.checked){this.value=1}else{this.value=0}"
                            value="<?php if ($studycenter=='1'){echo '1';}else{echo '0';} ?>" <?php if ($studycenter=='1'){echo 'checked';} ?> type="checkbox"/>
                        </div>							
                        <div class="div_select">
                            <label for="studycenter">
                                Distributed campus system
                            </label>
                        </div>
                    </div>
                    
                    <div class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="semster_adm" id="semster_adm" 
                            onclick="if(this.checked)
                            {
                                this.value=1;
                                ind_semster.disabled=false;
                                _('ind_semster_lbl').style.color='#000'
                            }else
                            {
                                this.value=0;
                                ind_semster.checked=false;
                                ind_semster.value=0;
                                ind_semster.disabled=true;
                                _('ind_semster_lbl').style.color='#999';
                            }"
                            value="<?php if ($semster_adm=='1'){echo '1';}else{echo '0';} ?>" <?php if ($semster_adm=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div>
                        <div class="div_select">
                            <label for="semster_adm">
                                Admission is every semester
                            </label>
                        </div>
                    </div>
                    
                    <div class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="ind_semster" id="ind_semster" <?php if ($semster_adm=='0'){echo 'disabled';} ?>
                            onclick="if(this.checked){this.value=1}else{this.value=0}"
                            value="<?php if ($ind_semster=='1'){echo '1';}else{echo '0';} ?>" <?php if ($ind_semster=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div>							
                        <div class="div_select">
                            <label for="ind_semster" id="ind_semster_lbl" style="color:<?php if ($semster_adm=='0'){echo '#cccccc';}else{echo '#6b6b6b';} ?>">
                                Individualize semester count
                            </label>
                        </div>
                    </div>

                    <div class="innercont_stff">
                        <label for="mailreqrec1" class="labell" style="width:320px; text-align:left">Receiver of email request</label>
                        <div class="div_select">
                            <input name="mailreqrec1" id="mailreqrec1" type="email" 
                                class="textbox"
                                maxlength="30"
                                value="<?php  echo stripslashes($mail_req_rec1);?>"
                                onblur="this.value=this.value.trim();
                                this.value=this.value.replace(/ /g, '');
                                this.value=this.value.toLowerCase();" />
                        </div>
                        <div id="labell_msg44" class="labell_msg blink_text orange_msg" style="width:305px; float:left;"></div>
                    </div>

                    <div class="innercont_stff">
                        <label for="mailreqrec3" class="labell" style="width:320px; text-align:left">Receiver of CC of email request</label>
                        <div class="div_select">
                            <input name="mailreqrec3" id="mailreqrec3" type="email" 
                                class="textbox" 
                                maxlength="30"
                                value="<?php  echo stripslashes($mail_req_rec3);?>"
                                onblur="this.value=this.value.trim();
                                this.value=this.value.replace(/ /g, '');
                                this.value=this.value.toLowerCase();" />
                        </div>
                        <div id="labell_msg45" class="labell_msg blink_text orange_msg" style="width:305px; float:left;"></div>
                    </div>

                    <div class="innercont_stff">
                        <label for="mailreqre2" class="labell" style="width:320px; text-align:left">Receiver of admision and registration information</label>
                        <div class="div_select">
                            <input name="mailreqre2" id="mailreqrec2" type="email" 
                                class="textbox" 
                                maxlength="30"
                                value="<?php  echo stripslashes($mail_req_rec2);?>"
                                onblur="this.value=this.value.trim();
                                this.value=this.value.replace(/ /g, '');
                                this.value=this.value.toLowerCase();" />
                        </div>
                        <div id="labell_msg45" class="labell_msg blink_text orange_msg" style="width:305px; float:left;"></div>
                    </div>                    
                    

                    <div class="innercont_stff" style="margin-top:20px;">
                        <label for="req_mail_level_cahnge" class="labell" style="width:320px; text-align:left">Receiver of request for change of level</label>
                        <div class="div_select">
                            <input name="req_mail_level_cahnge" id="req_mail_level_cahnge" type="email" 
                                class="textbox"
                                maxlength="30"
                                value="<?php  echo stripslashes($req_mail_level_cahnge);?>"
                                onblur="this.value=this.value.trim();
                                this.value=this.value.replace(/ /g, '');
                                this.value=this.value.toLowerCase();" />
                        </div>
                        <div id="labell_msg51" class="labell_msg blink_text orange_msg" style="width:305px; float:left;"></div>
                    </div>
                    
                    <div class="innercont_stff">
                        <label for="req_mail_level_cahnge_cc1" class="labell" style="width:320px; text-align:left">Receiver1 of CC for request for change of level</label>
                        <div class="div_select">
                            <input name="req_mail_level_cahnge_cc1" id="req_mail_level_cahnge_cc1" type="email" 
                                class="textbox"
                                maxlength="30"
                                value="<?php  echo stripslashes($req_mail_level_cahnge_cc1);?>"
                                onblur="this.value=this.value.trim();
                                this.value=this.value.replace(/ /g, '');
                                this.value=this.value.toLowerCase();" />
                        </div>
                        <div id="labell_msg52" class="labell_msg blink_text orange_msg" style="width:305px; float:left;"></div>
                    </div>
                    
                    <div class="innercont_stff">
                        <label for="req_mail_level_cahnge_cc2" class="labell" style="width:320px; text-align:left">Receiver2 of CC for request for change of level</label>
                        <div class="div_select">
                            <input name="req_mail_level_cahnge_cc2" id="req_mail_level_cahnge_cc2" type="email" 
                                class="textbox"
                                maxlength="30"
                                value="<?php  echo stripslashes($req_mail_level_cahnge_cc2);?>"
                                onblur="this.value=this.value.trim();
                                this.value=this.value.replace(/ /g, '');
                                this.value=this.value.toLowerCase();" />
                        </div>
                        <div id="labell_msg53" class="labell_msg blink_text orange_msg" style="width:305px; float:left;"></div>
                    </div>


                    <div class="innercont_stff" style="margin-top:15px;">
                        <label for="mailreqrec1" class="labell" style="width:320px; text-align:left">Receiver of request for change of programme</label>
                        <div class="div_select">
                            <input name="req_mail_prog_cahnge" id="req_mail_prog_cahnge" type="email" 
                                class="textbox"
                                maxlength="30"
                                value="<?php  echo stripslashes($req_mail_prog_cahnge);?>"
                                onblur="this.value=this.value.trim();
                                this.value=this.value.replace(/ /g, '');
                                this.value=this.value.toLowerCase();" />
                        </div>
                        <div id="labell_msg54" class="labell_msg blink_text orange_msg" style="width:305px; float:left;"></div>
                    </div>
                    
                    <div class="innercont_stff">
                        <label for="req_mail_prog_cahnge_cc1" class="labell" style="width:320px; text-align:left">Receiver1 of CC for request for change of programme</label>
                        <div class="div_select">
                            <input name="req_mail_prog_cahnge_cc1" id="req_mail_prog_cahnge_cc1" type="email" 
                                class="textbox"
                                maxlength="30"
                                value="<?php  echo stripslashes($req_mail_prog_cahnge_cc1);?>"
                                onblur="this.value=this.value.trim();
                                this.value=this.value.replace(/ /g, '');
                                this.value=this.value.toLowerCase();" />
                        </div>
                        <div id="labell_msg55" class="labell_msg blink_text orange_msg" style="width:305px; float:left;"></div>
                    </div>
                    
                    <div class="innercont_stff">
                        <label for="req_mail_prog_cahnge_cc2" class="labell" style="width:320px; text-align:left">Receiver2 of CC for request for change of programme</label>
                        <div class="div_select">
                            <input name="req_mail_prog_cahnge_cc2" id="req_mail_prog_cahnge_cc2" type="email" 
                                class="textbox"
                                maxlength="30"
                                value="<?php  echo stripslashes($req_mail_prog_cahnge_cc2);?>"
                                onblur="this.value=this.value.trim();
                                this.value=this.value.replace(/ /g, '');
                                this.value=this.value.toLowerCase();" />
                        </div>
                        <div id="labell_msg56" class="labell_msg blink_text orange_msg" style="width:305px; float:left;"></div>
                    </div>


                    <div class="innercont_stff" style="margin-top:15px;">
                        <label for="req_mail_cent_cahnge" class="labell" style="width:320px; text-align:left">Receiver of request for change of centre</label>
                        <div class="div_select">
                            <input name="req_mail_cent_cahnge" id="req_mail_cent_cahnge" type="email" 
                                class="textbox"
                                maxlength="30"
                                value="<?php  echo stripslashes($req_mail_cent_cahnge);?>"
                                onblur="this.value=this.value.trim();
                                this.value=this.value.replace(/ /g, '');
                                this.value=this.value.toLowerCase();" />
                        </div>
                        <div id="labell_msg57" class="labell_msg blink_text orange_msg" style="width:305px; float:left;"></div>
                    </div>
                    
                    <div class="innercont_stff">
                        <label for="req_mail_cent_cahnge_cc1" class="labell" style="width:320px; text-align:left">Receiver1 of CC for request for change of centre</label>
                        <div class="div_select">
                            <input name="req_mail_cent_cahnge_cc1" id="req_mail_cent_cahnge_cc1" type="email" 
                                class="textbox"
                                maxlength="30"
                                value="<?php  echo stripslashes($req_mail_cent_cahnge_cc1);?>"
                                onblur="this.value=this.value.trim();
                                this.value=this.value.replace(/ /g, '');
                                this.value=this.value.toLowerCase();" />
                        </div>
                        <div id="labell_msg58" class="labell_msg blink_text orange_msg" style="width:305px; float:left;"></div>
                    </div>
                    
                    <div class="innercont_stff">
                        <label for="req_mail_cent_cahnge_cc2" class="labell" style="width:320px; text-align:left">Receiver2 of CC for request for change of centre</label>
                        <div class="div_select">
                            <input name="req_mail_cent_cahnge_cc2" id="req_mail_cent_cahnge_cc2" type="email" 
                                class="textbox"
                                maxlength="30"
                                value="<?php  echo stripslashes($req_mail_cent_cahnge_cc2);?>"
                                onblur="this.value=this.value.trim();
                                this.value=this.value.replace(/ /g, '');
                                this.value=this.value.toLowerCase();" />
                        </div>
                        <div id="labell_msg59" class="labell_msg blink_text orange_msg" style="width:305px; float:left;"></div>
                    </div>

                                
    				<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.2%; margin-top:10px; margin-bottom:0.8%;" />                    
                    
					<div class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="sem_reg" id="sem_reg"
                            onclick="if(this.checked)
                                {
                                    this.value=1;
                                    if (_('id_ewallet_cred_for_sem_reg'))
                                    {
                                        _('ewallet_cred_for_sem_reg').disabled=false;
                                        _('id_ewallet_cred_for_sem_reg').title='';
                                        _('ewallet_cred_for_sem_reg_lbl').style.color='#000';
                                    }
                                }else
                                {
                                    this.value=0;
                                    if (_('id_ewallet_cred_for_sem_reg'))
                                    {
                                        _('ewallet_cred_for_sem_reg').disabled=true;
                                        _('id_ewallet_cred_for_sem_reg').title='Enable semester registration in registry to enable this';
                                        _('ewallet_cred_for_sem_reg').value='0';
                                        _('ewallet_cred_for_sem_reg_lbl').style.color='#ccc';
                                        _('ewallet_cred_for_sem_reg').checked = false;
                                    }
                                }"
                            value="<?php if ($sem_reg=='1'){echo '1';}else{echo '0';} ?>" <?php if ($sem_reg=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div>
                        <div class="div_select">
                            <label for="sem_reg" id="sem_reg_lbl">
                                Enable semester registration
                            </label>
                        </div>
                    </div>

                    <div class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="onlineca" id="onlineca"
                            onclick="if(this.checked)
                            {
                                this.value=1;
                                _('tmadate1').disabled = false;
                                _('tmadate2').disabled = false;
                                _('iextend_tma').disabled = false;
                                
                                _('tma_only').disabled = false;
                                _('iextend_tma').disabled = false;
                            }else
                            {
                                this.value=0;
                                _('tmadate1').disabled = true;
                                _('tmadate2').disabled = true;
                                _('iextend_tma').disabled = true;
                                _('iextend_tma').checked = false;
                                
                                _('tma_only').disabled = true;
                                _('iextend_tma').disabled = true;
                                
                                _('tmadate1').value = '';
                                _('tmadate2').value = '';
                            }"
                            value="<?php echo $onlineca; ?>" <?php if ($onlineca=='1'){echo ' checked';} ?> 
                            type="checkbox"/>
                        </div>
                        <div class="div_select">
                            <label for="onlineca" id="onlineca">
                                Enable online continuous assessment
                            </label>
                        </div>
                    </div>
							
                    <div class="innercont_stff" style="margin-top:10px;">
                        <div class="div_select" style="width:auto">
                            <input name="period_of_result_upload" id="period_of_result_upload" 
                            onclick="if(this.checked)
                            {
                                this.value=1;
                                _('semester_of_result_upload').disabled=false;
                                _('session_of_result_upload0').disabled=false;
                                _('session_of_result_upload1').disabled=false;
                            }else
                            {
                                this.value=0;
                                _('semester_of_result_upload').disabled=true;
                                _('session_of_result_upload0').disabled=true;
                                _('session_of_result_upload1').disabled=true;
                                                                        
                                _('semester_of_result_upload').value='';
                                _('session_of_result_upload0').value='';
                                _('session_of_result_upload1').value='';
                                        
                                _('hd_session_of_result_upload').value='0000/0000';
                            }"
                            value="<?php if ($period_of_result_upload=='1'){echo '1';}else{echo '0';} ?>" <?php if ($period_of_result_upload=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div><?php
                        $statte = '';
                        if ($drp_crs == '0'){$statte = 'disabled';}?>
                        <div class="div_select" style="width:auto;">
                            Upload result for 
                            <select name="semester_of_result_upload" id="semester_of_result_upload" <?php if ($period_of_result_upload=='0'){echo ' disabled';}?> class="select" style="width:auto">
                                <option value="" selected="selected"></option>
                                <option value="1" <?php if ($semester_of_result_upload == 1){echo ' selected';}?>>1st</option>
                                <option value="2" <?php if ($semester_of_result_upload == 2){echo ' selected';}?>>2nd</option>
                            </select> semester in 
                            <select name="session_of_result_upload0" id="session_of_result_upload0" <?php if ($period_of_result_upload=='0'){echo 'disabled';}?> class="select" style="width:auto" 
                                onchange="if(this.value!='')
                                {
                                    _('session_of_result_upload1').value=parseInt(this.value)+1;
                                    _('hd_session_of_result_upload').value = this.value+'/'+_('session_of_result_upload1').value;
                                }else
                                {
                                    _('session_of_result_upload1').value='';
                                }">
                                <option value="" selected="selected"></option><?php
                                for($i=$today_year-2;$i<=$today_year;$i++)
                                {?>
                                    <option value="<?php echo $i; ?>"<?php if ($i == $session_of_result_upload0){echo " selected";}?>><?php echo $i;?></option><?php
                                }?>
                            </select> /
                            <select name="session_of_result_upload1" id="session_of_result_upload1" <?php if ($period_of_result_upload=='0'){echo 'disabled';}?> class="select" style="width:auto" 
                                onchange="if(this.value!='')
                                {
                                    _('session_of_result_upload0').value=parseInt(this.value)-1;
                                    _('hd_session_of_result_upload').value = _('session_of_result_upload0').value+'/'+this.value;
                                }else
                                {
                                    _('session_of_result_upload0').value='';
                                }">
                                <option value="" selected="selected"></option><?php
                                for($i=$today_year-2;$i<=$today_year+1;$i++)
                                {?>
                                    <option value="<?php echo $i; ?>"<?php if ($i == $session_of_result_upload1){echo " selected";}?>><?php echo $i;?></option><?php
                                }?>
                            </select> session
                            <input name="hd_session_of_result_upload" id="hd_session_of_result_upload" type="hidden" value="<?php echo $session_of_result_upload;?>" />
                        </div>
                        <div id="labell_msg36" class="labell_msg blink_text orange_msg" style="width:305px; float:left;"></div>
                    </div>
                    
                    <div class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="cShowrslt" id="cShowrslt" 
                            onclick="if(this.checked)
                            {
                                this.value=1;
                                _('cShowrslt_for_student').disabled=false;
                                _('cShowrslt_for_staff').disabled=false;

                                _('cShowgrade').disabled=false;
                                _('cShowscore').disabled=false;
                                _('cShowgpa').disabled=false;
                                _('cShowtt').checked=false
                            }else
                            {
                                _('cShowrslt_for_student').disabled=true;
                                _('cShowrslt_for_staff').disabled=true;

                                _('cShowgrade').disabled=true;
                                _('cShowscore').disabled=true;
                                _('cShowgpa').disabled=true;
                                
                                _('cShowgrade').value='0';
                                _('cShowscore').value='0';
                                _('cShowgpa').value='0';
                                this.value=0
                            }
                                
                            _('cShowgrade').checked=false;
                            _('cShowscore').checked=false;
                            _('cShowgpa').checked=false;"
                            value="<?php if ($cShowrslt=='1'){echo '1';}else{echo '0';} ?>" <?php if ($cShowrslt=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div>							
                        <div class="div_select">
                            <label for="cShowrslt" id="cShowrslt_lbl">
                                Show student result
                            </label>
                        </div>
                    </div>

                    <div class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="cShowrslt_for_staff" id="cShowrslt_for_staff" 
                            onclick="if(this.checked){this.value=1;}else{this.value=0}"
                            value="<?php echo $cShowrslt_for_staff ;?>" 
                            <?php if ($cShowrslt == '0'){echo ' disabled';}
                            if ($cShowrslt_for_staff == '1'){echo ' checked';}?>
                            type="checkbox"/>
                        </div>							
                        <div class="div_select">
                            <label for="cShowrslt_for_staff" id="cShowrslt_for_staff_lbl">
                                For staff members
                            </label>
                        </div>

                        <div class="div_select" style="width:auto">
                            <input name="cShowrslt_for_student" id="cShowrslt_for_student" 
                            onclick="if(this.checked){this.value=1;}else{this.value=0}"
                            value="<?php echo $cShowrslt_for_student ;?>" 
                            <?php if ($cShowrslt == '0'){echo ' disabled';}
                            if ($cShowrslt_for_student == '1'){echo ' checked';}?>
                            type="checkbox"/>
                        </div>							
                        <div class="div_select">
                            <label for="cShowrslt_for_student" id="cShowrslt_for_student_lbl">
                                For students
                            </label>
                        </div>
                        <div id="labell_msg37" class="labell_msg blink_text orange_msg" style="width:380px; float:left;"></div>
                    </div>


                    <div class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="cShowgrade" id="cShowgrade" 
                            onclick="if(this.checked){this.value=1;}else{this.value=0}"
                            value="<?php echo $cShowgrade ;?>" 
                            <?php if ($cShowrslt == '0'){echo ' disabled';}
                            if ($cShowgrade == '1'){echo ' checked';}?>
                            type="checkbox"/>
                        </div>							
                        <div class="div_select">
                            <label for="cShowgrade" id="cShowgrade_lbl">
                                Show grade
                            </label>
                        </div>
                        <div id="labell_msg38" class="labell_msg blink_text orange_msg" style="width:380px; float:left;"></div>
                    </div>
                    
                    <div class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="cShowscore" id="cShowscore" 
                            onclick="if(this.checked){this.value=1;}else{this.value=0}"
                            value="<?php echo $cShowscore ;?>"
                            <?php if ($cShowrslt == '0'){echo ' disabled';}
                            if ($cShowscore == '1'){echo ' checked';}?>
                            type="checkbox"/>
                        </div>							
                        <div class="div_select">
                            <label for="cShowscore" id="cShowscore_lbl">
                                Show score
                            </label>
                        </div>
                        <div id="labell_msg39" class="labell_msg blink_text orange_msg" style="width:380px; float:left;"></div>
                    </div>
                    
                    <div class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="cShowgpa" id="cShowgpa" 
                            onclick="if(this.checked){this.value=1;}else{this.value=0}" 
                            value="<?php echo $cShowgpa ;?>"
                            <?php if ($cShowrslt == '0'){echo ' disabled';}
                            if ($cShowgpa == '1'){echo ' checked';}?>
                            type="checkbox"/>
                        </div>							
                        <div class="div_select">
                            <label for="cShowgpa" id="cShowgpa_lbl">
                                Show GPA
                            </label>
                        </div>
                        <div id="labell_msg40" class="labell_msg blink_text orange_msg" style="width:380px; float:left;"></div>
                    </div>
                    
                    <div class="innercont_stff" style="margin-top:10px;">
                        <div class="div_select" style="width:auto">
                            <input name="cShowtt" id="cShowtt" 
                            onclick="if(this.checked){this.value=1;_('cShowrslt').value=0;_('cShowrslt').checked=false}else{this.value=0}"
                            value="<?php if ($cShowtt=='1'){echo '1';}else{echo '0';} ?>" <?php if ($cShowtt=='1'){echo 'checked';} ?> 
                            type="checkbox" <?php if($orgsetins['poptt'] == '0' && $orgsetins['examtt'] == '0'){?> disabled="disabled"<?php }?>/>
                        </div>							
                        
                        <div class="div_select" title="Active when timetable is uploaded">
                            <label for="cShowtt" id="cShowtt_lbl" style="color:<?php if($orgsetins['poptt'] == '0' && $orgsetins['examtt'] == '0'){?> #cccccc;<?php }else{?> #000;<?php }?>">
                                Show exam timetable
                            </label>
                        </div><?php
                        if($orgsetins['poptt'] == '0' && $orgsetins['examtt'] == '0')
                        {?>
                            <div class="labell_msg blink_text orange_msg" style="width:auto; float:left; background-color:#FFFFEA; border: 1px solid #BDBB6A; text-align:center">
                                Option not available. Timetable not uploaded
                            </div><?php
                        }?>
                    </div>
                    
                    <div class="innercont_stff" style="margin-top:10px;">
                        <div class="div_select" style="width:auto">
                            <input name="drp_crs" id="drp_crs" 
                            onclick="if(this.checked)
                            {
                                this.value=1;
                                _('hd_drp_crsdate').disabled=false;
                            }else
                            {
                                this.value=0;
                                _('hd_drp_crsdate').disabled=true;                                                                        
                                _('hd_drp_crsdate').value='00000000';
                            }"
                            value="<?php if ($drp_crs=='1'){echo '1';}else{echo '0';} ?>" <?php if ($drp_crs=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div>
                        <!-- <div class="innercont_stff" style="margin-top:0px;">--><?php 
                            $statte = '';
                            if ($drp_crs == '0'){$statte = 'disabled';}?>
                            <!-- <label for="drp_crs" id="drp_crs_lbl"> -->
                            <div id="drp_crs_lbl" class="div_select" style="width:275px;">
                                <label for="drp_crs" id="regexam_lbl">
                                    Student can drop course on or before
                                </label>
                            </div>
                            <div class="div_select">
                                <input type="date" name="hd_drp_crsdate" id="hd_drp_crsdate" class="textbox" style="height:99%; width:auto" value="<?php echo substr($drp_crsdate,4,4).'-'.substr($drp_crsdate,2,2).'-'.substr($drp_crsdate,0,2);?>"
                            onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false" <?php echo $statte;?>>
                            </div>
                        <!-- </div>								 -->
                        <div id="labell_msg31" class="labell_msg blink_text orange_msg" style="width:380px; float:left;"></div>
                    </div>
                    
                    <div class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="regexam" id="regexam" 
                            onclick="if(this.checked)
                            {
                                this.value=1;
                                _('drp_exam').disabled=false;
                                _('drp_exam_lbl').style.color='#000';
                                _('id_drp_exam').title='';
                                
                                _('hd_drp_examdate').disabled=false;

                                
                                _('drp_exam_2').disabled=false;
                                _('drp_exam_2_lbl').style.color='#000';
                                _('id_drp_exam_2').title='';
                                
                                _('hd_drp_exam_2date').disabled=false;
                                        
                                // _('examregdate1').disabled=false;
                                // _('examregdate_100_200_2').disabled=false;
                                // _('examregdate_300_2').disabled=false;
                                        
                                // _('iextend_exam').disabled=false;
                            }else
                            {
                                this.value=0;
                                _('drp_exam').checked=false;
                                _('drp_exam').value='0';
                                _('drp_exam').disabled=true;
                                _('id_drp_exam').title='Enable Exam registration separately to enable this';
                                _('drp_exam_lbl').style.color='#ccc';
                                
                                _('drp_exam_2').checked=false;
                                _('drp_exam_2').value='0';
                                _('drp_exam_2').disabled=true;
                                _('id_drp_exam_2').title='Enable Exam registration separately to enable this';
                                _('drp_exam_2_lbl').style.color='#ccc';
                                
                                _('hd_drp_examdate').disabled=true;                                
                                _('hd_drp_examdate').value='';

                                _('hd_drp_exam_2date').disabled=true;                                
                                _('hd_drp_exam_2date').value='';
                                
                                // _('examregdate1').disabled=true;                                
                                // _('examregdate_100_200_2').disabled=true;
                                // _('examregdate_300_2').disabled=false;

                                // _('iextend_exam').disabled=true;
                                
                                _('hd_drp_examdate').value='00000000';
                                _('hd_drp_exam_2date').value='00000000';
                            }"
                            value="<?php if ($regexam=='1'){echo '1';}else{echo '0';} ?>" <?php if ($regexam=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div>							
                        <div class="div_select">
                            <label for="regexam" id="regexam_lbl">
                                Exam registration is separate
                            </label>
                        </div>
                    </div>
                    
                    <div id="id_drp_exam" class="innercont_stff" <?php if ($regexam=='0'){?>title="Enable 'Exam registration is separate' to enable this"<?php }?>>
                        <div class="div_select" style="width:auto">
                            <input name="drp_exam" id="drp_exam" <?php if ($regexam=='0'){echo 'disabled';} ?>
                            onclick="if(this.checked)
                            {
                                this.value=1;
                                _('hd_drp_examdate').disabled=false;
                            }else
                            {
                                this.value=0;									
                                _('hd_drp_examdate').disabled=true;
                                _('hd_drp_examdate').value='00000000';
                            }"
                            value="<?php if ($drp_exam=='1'){echo '1';}else{echo '0';} ?>" <?php if ($drp_exam=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div>
                        <div class="div_select" style="width:275px;">
                            <label for="drp_exam" id="drp_exam_lbl" style="color:<?php if ($regexam=='0'){echo '#cccccc';}else{echo '#6b6b6b';} ?>">
                                100L-200L students can drop exam on or before
                            </label>
                        </div>
                        <div class="div_select"><?php
                            $statte = '';
                            if ($drp_exam == '0'){$statte = 'disabled';}?>
                            <input type="date" name="hd_drp_examdate" id="hd_drp_examdate" class="textbox" style="height:99%; width:auto" value="<?php echo substr($drp_examdate,4,4).'-'. substr($drp_examdate,2,2).'-'.substr($drp_examdate,0,2);?>"
                            onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false" <?php echo $statte;?>>
                        </div>
                        <div id="labell_msg32" class="labell_msg blink_text orange_msg"></div>
                    </div>
                    
                    
                    
                    <div id="id_drp_exam_2" class="innercont_stff" <?php if ($regexam=='0'){?>title="Enable 'Exam registration is separate' to enable this"<?php }?>>
                        <div class="div_select" style="width:auto">
                            <input name="drp_exam_2" id="drp_exam_2" <?php if ($regexam=='0'){echo 'disabled';} ?>
                            onclick="if(this.checked)
                            {
                                this.value=1;
                                _('hd_drp_exam_2date').disabled=false;
                            }else
                            {
                                this.value=0;									
                                _('hd_drp_exam_2date').disabled=true;
                                _('hd_drp_exam_2date').value='00000000';
                            }"
                            value="<?php if ($drp_exam_2=='1'){echo '1';}else{echo '0';} ?>" <?php if ($drp_exam_2=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div>
                        <div class="div_select" style="width:275px;">
                            <label for="drp_exam_2" id="drp_exam_2_lbl" style="color:<?php if ($regexam=='0'){echo '#cccccc';}else{echo '#6b6b6b';} ?>">
                            300L and above students can drop exam on or before
                            </label>
                        </div>
                        <div class="div_select"><?php
                            $statte = '';
                            if ($drp_exam_2 == '0'){$statte = 'disabled';}?>
                            <input type="date" name="hd_drp_exam_2date" id="hd_drp_exam_2date" class="textbox" style="height:99%; width:auto" value="<?php echo substr($drp_exam_2date,4,4).'-'. substr($drp_exam_2date,2,2).'-'.substr($drp_exam_2date,0,2);?>"
                            onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false" <?php echo $statte;?>>
                        </div>
                        <div id="labell_msg33" class="labell_msg blink_text orange_msg"></div>
                    </div><?php

                    if (($mm == '1' && $sm == '11') || ($mm == '7' && $sm == '3'))
				    {?>
                        <div class="innercont_stff" style="margin-top:10px;">
                            <div class="div_select" style="width:auto">
                                <input name="upld_passpic" id="upld_passpic" 
                                onclick="if(this.checked)
                                {
                                    this.value=1;
                                    _('upld_passpic_no').disabled=false;
                                    _('upld_passpic_no').value=1;
                                }else
                                {
                                    this.value=0;
                                    _('upld_passpic_no').disabled=true;
                                    _('upld_passpic_no').value=0;
                                }"
                                value="<?php if ($upld_passpic=='1'){echo '1';}else{echo '0';} ?>" <?php if ($upld_passpic=='1'){echo 'checked';} ?> 
                                type="checkbox"/>
                            </div>
                            <div class="div_select" style="width:275px;">
                                <label for="upld_passpic" id="upld_passpic_lbl">
                                    Student can upload passport picture 
                                </label>
                            </div>
                            <div class="div_select">                                
                                <select name="upld_passpic_no" id="upld_passpic_no" class="select" style="width:auto"><?php
                                    for($i=0;$i<=5;$i++)
                                    {?>
                                        <option value="<?php echo $i; ?>"<?php if ($i == $upld_passpic_no){echo " selected";}?>><?php echo $i;?></option><?php
                                    }?>
                                </select>
                                time(s)
                            </div>
                        </div>
                        
                        <div class="innercont_stff">
                            <div class="div_select" style="width:300px;">
                                <label for="size_pp" class="labell" style="width:260px; text-align:left; text-indent:3px">
                                    File size of uploaded passport picture (KB)
                                </label>
                            </div>
                            <div class="div_select">
                                <select name="size_pp" id="size_pp" class="select" style="width:auto">
                                    <option value="" selected="selected"></option><?php
                                    for($i=10;$i<=100;$i+=5)
                                    {?>
                                        <option value="<?php echo $i; ?>"<?php if ($i == $size_pp){echo " selected";}?>><?php echo $i;?></option><?php
                                    }?>
                                </select> 
                            </div>
                            <div id="labell_msg26" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                        </div>
                        
                        <div class="innercont_stff">
                            <div class="div_select" style="width:300px;">
                                <label for="size_cred" class="labell" style="width:auto; text-align:left; text-indent:3px">
                                    File size of uploaded credential (KB)
                                </label>                     
                            </div>
                            <div class="div_select">
                            <select name="size_cred" id="size_cred" class="select" style="width:auto">
                                <option value="" selected="selected"></option><?php
                                for($i=10;$i<=200;$i+=10)
                                {?>
                                    <option value="<?php echo $i; ?>"<?php if ($i == $size_cred){echo " selected";}?>><?php echo $i;?></option><?php
                                }?>
                            </select> 
                            </div>
                            <div id="labell_msg25" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                        </div><?php


                        if (($mm == '1' && $sm == '11') || ($mm == '7' && $sm == '3'))
                        {
                            $student_req1_close_date = substr($regdate_100_200_2,4,4).'-'.substr($regdate_100_200_2,2,2).'-'.substr($regdate_100_200_2,0,2);
                            $student_req1_close_date = date('Y-m-d', strtotime($student_req1_close_date. ' - 3 days'));
                            
                            
                            $student_req2_close_date = substr($regdate_300_2,4,4).'-'.substr($regdate_300_2,2,2).'-'.substr($regdate_300_2,0,2);
                            $student_req2_close_date = date('Y-m-d', strtotime($student_req2_close_date. ' - 5 days'));?>

                            <div class="innercont_stff" style="margin-top:20px;">
                                <div class="div_select" style="width:300px;">
                                    <label for="student_req1" class="labell" style="width:auto; text-align:left; text-indent:3px">
                                        100L-200L students' requests closes on
                                    </label>                     
                                </div>
                                <div class="div_select">
                                    <input type="date" name="student_req1" id="student_req1" class="textbox" style="height:99%; width:auto" 
                                    value="<?php echo substr($student_req1,4,4).'-'.substr($student_req1,2,2).'-'.substr($student_req1,0,2);?>"
                                    onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false"
                                    max="<?php echo $student_req1_close_date;?>">
                                </div>
                                <div id="labell_msg60" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                            </div>
                            
                            <div class="innercont_stff">
                                <div class="div_select" style="width:300px;">
                                    <label for="student_req2" class="labell" style="width:auto; text-align:left; text-indent:3px">
                                        300L and above students' requests closes on
                                    </label>                     
                                </div>
                                <div class="div_select">
                                    <input type="date" name="student_req2" id="student_req2" class="textbox" style="height:99%; width:auto" 
                                    value="<?php echo substr($student_req2,4,4).'-'.substr($student_req2,2,2).'-'.substr($student_req2,0,2);?>"
                                    onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false"
                                    max="<?php //echo $student_req2_close_date;?>">
                                </div>
                                <div id="labell_msg61" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                            </div><?php
                        }?>
                        
                        <!-- <div class="innercont_stff" style="margin-top:10px;">
                            <div class="div_select">
                                <input name="upld_passpic" id="upld_passpic" 
                                onclick="if(this.checked)
                                {
                                    this.value=1;
                                    _('upld_passpic_no').disabled=false;
                                    _('upld_passpic_no').value=1;
                                }else
                                {
                                    this.value=0;
                                    _('upld_passpic_no').disabled=true;
                                    _('upld_passpic_no').value=0;
                                }"
                                value="<?php if ($upld_passpic=='1'){echo '1';}else{echo '0';} ?>" <?php if ($upld_passpic=='1'){echo 'checked';} ?> 
                                type="checkbox"/>
                            </div>							
                            <div class="innercont" style="width:625px; height:17px; float:left; padding-top:0px">
                                <label for="upld_passpic" id="upld_passpic_lbl">
                                    Student can upload passport picture 
                                    <select name="upld_passpic_no" id="upld_passpic_no" class="select" style="width:auto"><?php
                                        for($i=0;$i<=5;$i++)
                                        {?>
                                            <option value="<?php echo $i; ?>"<?php if ($i == $upld_passpic_no){echo " selected";}?>><?php echo $i;?></option><?php
                                        }?>
                                    </select>
                                    time(s)
                                </label>
                            </div>
                        </div>--><?php
                    }?>

    				<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.2%; margin-top:10px; margin-bottom:0.8%;" />                    
                    
					<div class="innercont_stff">
                        <div class="div_select" style="width:300px;">
                            <label for="pc_char" class="labell" style="width:auto; text-align:left; text-indent:3px">
                                Number of characters of programme code
                            </label>
                        </div>
                        <div class="div_select">
                            <select name="pc_char" id="pc_char" class="select" style="width:auto">
                                <option value="" selected="selected"></option><?php
                                for($i=2;$i<=8;$i++)
                                {?>
                                    <option value="<?php echo $i; ?>"<?php if ($i == $pc_char){echo " selected";}?>><?php echo $i;?></option><?php
                                }?>
                            </select> 
                        </div>
                        <div id="labell_msg27" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                    </div>
                    <div class="innercont_stff">
                        <div class="div_select" style="width:300px;">
                            <label for="cc_char" class="labell" style="width:auto; text-align:left; text-indent:3px">
                                Number of characters of course code
                            </label>
                        </div>
                        <div class="div_select">
                            <select name="cc_char" id="cc_char" class="select" style="width:auto">
                                <option value="" selected="selected"></option><?php
                                for($i=2;$i<=8;$i++)
                                {?>
                                    <option value="<?php echo $i; ?>"<?php if ($i == $cc_char){echo " selected";}?>><?php echo $i;?></option><?php
                                }?>
                            </select> 
                        </div>
                        <div id="labell_msg28" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                    </div><?php
                    
                    if (($mm == '1' && $sm == '11') || ($mm == '7' && $sm == '3'))
					{?>
        				<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.2%; margin-top:10px; margin-bottom:0.8%;" />                        
                        <div class="innercont_stff">
                            <div class="div_select" style="width:auto">
                                <input name="enforce_co" id="enforce_co" 
                                onclick="if(this.checked)
                                {
                                    this.value=1;
                                    //_('enforce_cc_1').disabled=false;
                                    //_('enforce_cc_2').disabled=false;
                                }else
                                {
                                    this.value=0
                                    //_('enforce_cc_1').disabled=true;
                                    //_('enforce_cc_1').checked = false;
                                    //_('enforce_cc_2').disabled=true;
                                    //_('enforce_cc_2').checked = false;
                                }"
                                value="<?php if ($enforce_co=='1'){echo '1';}else{echo '0';} ?>" <?php if ($enforce_co=='1'){echo 'checked';} ?> 
                                type="checkbox"/>
                            </div>							
                            <div class="div_select">
                                <label for="enforce_co" id="enforce_co_lbl">
                                    Enforce carry over
                                </label>
                            </div>
                        </div>
                        
                        <!--<div class="innercont_stff">
                            <div class="div_select" style="width:auto">
                                <input name="enforce_cc_p" id="enforce_cc_p" 
                                onclick="if (this.checked)
                                {
                                    _('enforce_cc_h').value=1;
                                    _('enforce_cc_f').checked = false;
                                }else
                                {
                                    _('enforce_cc_h').value=0;
                                }"
                                value="<?php echo $enforce_cc; ?>" <?php if ($enforce_cc=='1'){echo 'checked';} ?> 
                                type="checkbox"/>
                            </div>							
                            <div class="div_select">
                                <label for="enforce_cc_p" id="enforce_cc_lbl">
                                    Partially enforce compulsory courses
                                </label>
                            </div>
                        </div>
                        
                        <div class="innercont_stff">
                            <div class="div_select" style="width:auto">
                                <input name="enforce_cc_f" id="enforce_cc_f" 
                                onclick="if (this.checked)
                                {
                                    _('enforce_cc_h').value=2;
                                    _('enforce_cc_p').checked = false;
                                }else
                                {
                                    _('enforce_cc_h').value=0;
                                }"
                                value="<?php echo $enforce_cc; ?>" <?php if ($enforce_cc=='2'){echo 'checked';} ?> 
                                type="checkbox"/>
                            </div>							
                            <div class="div_select">
                                <label for="enforce_cc_f" id="enforce_cc_lbl">
                                    Fully enforce compulsory courses
                                </label>
                            </div>

                            <input name="enforce_cc_h" id="enforce_cc_h" value="<?php echo $enforce_cc; ?>" type="hidden"/>
                        </div>-->
                                                        
                        <div class="innercont_stff">
                            <div class="div_select" style="width:300px;">
                                <label for="overall_ex" class="labell" style="text-align:left;">
                                    Maximum exam score
                                </label>
                            </div>
                            <div class="div_select">
                                <select name="overall_ex" id="overall_ex" class="select" style="width:auto" 
                                    onchange="_('overall_ca').value=100-this.value">
                                    <option value="" selected="selected"></option><?php
                                    for($i=0;$i<=100;$i++)
                                    {?>
                                        <option value="<?php echo $i; ?>"<?php if ($i == $overall_ex){echo " selected";}?>><?php echo $i;?></option><?php
                                    }?>
                                </select> 
                            </div>
                            <div id="labell_msg28" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                        </div>
                                                        
                        <div class="innercont_stff">
                            <div class="div_select" style="width:300px;">
                                <label for="overall_ca" class="labell" style="text-align:left;">
                                    Maximum CA score
                                </label>
                            </div>
                            <div class="div_select">
                                <select name="overall_ca" id="overall_ca" class="select" style="width:auto" 
                                    onchange="_('overall_ex').value=100-this.value">
                                    <option value="" selected="selected"></option><?php
                                    for($i=0;$i<=100;$i++)
                                    {?>
                                        <option value="<?php echo $i; ?>"<?php if ($i == $overall_ca){echo " selected";}?>><?php echo $i;?></option><?php
                                    }?>
                                </select> 
                            </div>
                            <div id="labell_msg28" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                        </div>

                        <hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.8px; margin-top:10px; margin-bottom:10px;" />                        
                        
                                                        
                        <div class="innercont_stff">
                            <div class="div_select" style="width:300px;">
                                <label for="max_login" class="labell" style="text-align:left;">
                                    Attempts at logiing in
                                </label>
                            </div>
                            <div class="div_select">
                                <select name="max_login" id="max_login" class="select" style="width:auto"><?php
                                    for($i=3;$i<=10;$i++)
                                    {?>
                                        <option value="<?php echo $i; ?>"<?php if ($i == $max_login){echo " selected";}?>><?php echo $i;?></option><?php
                                    }?>
                                </select> 
                            </div>
                            <div id="labell_msg47" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                        </div>
                        
                                                        
                        <div class="innercont_stff" style="margin-bottom:10px;">
                            <div class="div_select" style="width:300px;">
                                <label for="wait_max_login" class="labell" style="text-align:left;">
                                    Waiting time to login (min)
                                </label>
                            </div>
                            <div class="div_select">
                                <select name="wait_max_login" id="wait_max_login" class="select" style="width:auto"><?php
                                    for($i=5;$i<=60;$i+=5)
                                    {?>
                                        <option value="<?php echo $i; ?>"<?php if ($i == $wait_max_login){echo " selected";}else if ($i == 5){echo " selected";}?>><?php echo $i;?></option><?php
                                    }?>
                                </select> 
                            </div>
                            <div id="labell_msg48" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                        </div>

                                              
                        <div class="innercont_stff">
                            <div class="div_select" style="width:auto">
                                <input name="transission_in_progress" id="transission_in_progress"
                                onclick="if(this.checked){this.value=1}else{this.value=0}"
                                value="<?php if ($transission_in_progress=='1'){echo '1';}else{echo '0';} ?>" <?php if ($transission_in_progress=='1'){echo 'checked';} ?> 
                                type="checkbox"/>
                            </div>							
                            <div class="div_select">
                                <label for="transission_in_progress" id="enforce_co_lbl">
                                    Transission in progress
                                </label>
                            </div>
                        </div><?php
                    }
                }
                
                if (($mm == '2' && $sm == '10') || ($mm == '7' && $sm == '3'))
				{?>
                    <div class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="rr_sys" id="rr_sys" 
                            onclick="if(this.checked){this.value=1}else{this.value=0}"
                            value="<?php if ($rr_sys=='1'){echo '1';}else{echo '0';} ?>" <?php if ($rr_sys=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div>							
                        <div class="div_select" style="width:320px">
                            <label for="rr_sys" id="rr_sys_lbl">
                                RRR system of payment
                            </label>
                        </div>
                    </div>
                    
                    <div class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="loadfund" id="loadfund" 
                            onclick="if(this.checked){this.value=1}else{this.value=0}"
                            value="<?php if ($loadfund=='1'){echo '1';}else{echo '0';} ?>" <?php if ($loadfund=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div>							
                        <div class="div_select" style="width:320px">
                            <label for="loadfund" id="loadfund_lbl">
                                Can load fund
                            </label>
                        </div>
                    </div>

                    <div class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="late_fee" id="late_fee" 
                            onclick="									
                            if(this.checked)
                            {
                                this.value=1;
                            }else
                            {
                                this.value=0;
                            }"
                            value="<?php if ($late_fee=='1'){echo '1';}else{echo '0';} ?>" <?php if ($late_fee=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div><?php
                        $statte = '';
                        if ($late_fee == '0'){$statte = 'disabled';}?>
                         <div class="div_select" style="width:320px">
                            <label for="late_fee" id="ind_late_fee_lbl">
                                Charge late registration fee
                            </label>
                        </div>
                    </div>
                    
                    <div class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="semreg_fee" id="semreg_fee" 
                            onclick="if(this.checked){this.value=1}else{this.value=0}"
                            value="<?php if ($semreg_fee=='1'){echo '1';}else{echo '0';} ?>" 
                            <?php if ($sem_reg == '1')
                            {
                                if ($semreg_fee=='1'){echo ' checked';}
                            }else
                            {
                                echo ' disabled';
                            } ?> 
                            type="checkbox"/>
                        </div>
                        <div class="div_select" style="width:320px; color:<?php if ($sem_reg == '1')
                        {
                            if ($semreg_fee=='1'){echo '#000';}
                        }else
                        {
                            echo '#ccc';
                        } ?>">
                            <label for="semreg_fee" id="semreg_fee_lbl" >
                                Charge semester registration fee
                            </label>
                        </div>
                    </div>

    				<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.2%; margin-top:10px; margin-bottom:0.8%;" />                    
                    
					<div class="innercont_stff">
                        <div class="div_select" style="width:348px">
                            <label id="course_fee_lbl">
                                Charge course registration fee by:
                            </label>
                        </div>
                    </div>

                    <div class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="course_fee_cat" id="course_fee_cat" 
                            onclick="if(this.checked)
                            {
                                this.value=1;
                                _('course_fee_course').disabled = false;
                                _('course_fee_credit_unit').disabled = false;
                                _('course_fee_credit_unit_lbl').style.color = '#000000';
                                _('course_fee_course_lbl').style.color = '#000000';
                            }else
                            {
                                this.value=0;
                                _('course_fee_course').disabled = true;
                                _('course_fee_credit_unit').disabled = true;
                                _('course_fee_course').checked = false;
                                _('course_fee_credit_unit').checked = false;
                                _('course_fee_credit_unit_lbl').style.color = '#cccccc';
                                _('course_fee_course_lbl').style.color = '#cccccc';
                            }"
                            value="<?php if ($course_fee_cat=='1'){echo '1';}else{echo '0';} ?>" <?php if ($course_fee_cat=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div>					
                        <div class="div_select" style="width:320px">
                            <label for="course_fee_cat" id="course_fee_cat_lbl">
                                programme category
                            </label>
                        </div>
                    </div>

                    <div class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="course_fee_course" id="course_fee_course" <?php if ($course_fee_course=='1'){echo 'checked';} if ($course_fee_cat=='0'){echo 'disabled';}?>
                            onclick="if(this.checked)
                            {
                                this.value=1;
                                _('course_fee_credit_unit').checked = false;
                                _('course_fee_credit_unit').value=0;
                                }else
                                {
                                    this.value=0;
                                }"
                            value="<?php if ($course_fee_course=='1'){echo '1';}else{echo '0';} ?>" <?php if ($course_fee_course=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div>					
                        <div class="div_select" style="width:320px">
                            <label for="course_fee_course" id="course_fee_course_lbl" style="color:<?php if ($course_fee_course=='0'){echo '#cccccc';}else{echo '#6b6b6b';} ?>">
                                course
                            </label>
                        </div>
                    </div>

                    <div class="innercont_stff" style="margin-bottom:20px">
                        <div class="div_select" style="width:auto">
                            <input name="course_fee_credit_unit" id="course_fee_credit_unit"<?php if ($course_fee_cat=='0'){echo 'disabled';} if ($course_fee_credit_unit=='1'){echo 'checked';} ?> 
                            onclick="if(this.checked)
                            {
                                this.value=1;
                                _('course_fee_course').checked = false;
                                _('course_fee_course').value = 0;
                                }else
                                {
                                    this.value=0
                                }"
                            value="<?php if ($course_fee_credit_unit=='1'){echo '1';}else{echo '0';} ?>" <?php if ($course_fee_credit_unit=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div>
                        <div class="div_select" style="width:320px">
                            <label for="course_fee_credit_unit" id="course_fee_credit_unit_lbl" style="color:<?php if ($course_fee_credit_unit=='0'){echo '#cccccc';}else{echo '#6b6b6b';} ?>">
                                credit unit
                            </label>
                        </div>
                    </div>

                    <div class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="exam_fee" id="exam_fee" <?php if ($regexam == '0'){echo ' disabled';} ?>
                            onclick="if(this.checked){this.value=1}else{this.value=0}"
                            value="<?php if ($exam_fee=='1'){echo '1';}else{echo '0';} ?>" <?php if ($exam_fee=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div>							
                        <div class="div_select" style="width:320px">
                            <label for="exam_fee" id="exam_fee_lbl" style="color:<?php if ($regexam=='0'){echo '#cccccc';}else{echo '#6b6b6b';} ?>" title="<?php if ($regexam=='0'){echo 'Registry needs to enable exam registration as a separate action to enble this option';}else{echo '';} ?>">
                                Charge exam registration fee
                            </label>
                        </div>
                    </div>
                    
                    <div id="id_ewallet_cred_for_sem_reg" class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="ewallet_cred_for_ses_reg" id="ewallet_cred_for_ses_reg"
                            onclick="if(this.checked){this.value=1}else{this.value=0}"
                            value="<?php if ($ewallet_cred_for_ses_reg=='1'){echo '1';}else{echo '0';} ?>" <?php if ($ewallet_cred_for_ses_reg=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div>							
                        <div class="div_select" style="width:320px">
                            <label for="ewallet_cred_for_ses_reg" id="ewallet_cred_for_sem_reg_lbl">
                                Can use e-walet credit for session registration
                            </label>
                        </div>
                    </div>

                    <div id="id_ewallet_cred_for_sem_reg" class="innercont_stff" <?php if ($sem_reg=='0'){?>title="Enable semester registration in registry to enable this"<?php }?>>
                        <div class="div_select" style="width:auto">
                            <input name="ewallet_cred_for_sem_reg" id="ewallet_cred_for_sem_reg" <?php if ($sem_reg == '0'){echo ' disabled';} ?>
                            onclick="if(this.checked){this.value=1}else{this.value=0}"
                            value="<?php if ($ewallet_cred_for_sem_reg=='1'){echo '1';}else{echo '0';} ?>" <?php if ($ewallet_cred_for_sem_reg=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div>							
                        <div class="div_select" style="width:320px">
                            <label for="ewallet_cred_for_sem_reg" id="ewallet_cred_for_sem_reg_lbl" style="color:<?php if ($sem_reg=='0'){echo '#cccccc';}else{echo '#6b6b6b';} ?>">
                                Can use e-walet credit for semester registration
                            </label>
                        </div>
                    </div>

    				<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.2%; margin-top:10px; margin-bottom:0.8%;" />                
                    
					<div id="id_uni_give_mat" class="innercont_stff">
                        <div class="div_select" style="width:auto">
                            <input name="uni_give_mat" id="uni_give_mat" <?php if ($sem_reg == '0'){echo ' disabled';} ?>
                            onclick="if(this.checked){this.value=1}else{this.value=0}"
                            value="<?php if ($uni_give_mat=='1'){echo '1';}else{echo '0';} ?>" <?php if ($uni_give_mat=='1'){echo 'checked';} ?> 
                            type="checkbox"/>
                        </div>							
                        <div class="div_select" style="width:320px">
                            <label for="uni_give_mat" id="uni_give_mat_lbl">
                                University gives out course materials
                            </label>
                        </div>
                    </div>
                    
                    <div class="innercont_stff" style="margin-top:10px;">
                        <label for="ac_close" class="labell" style="width:220px;">Account close date</label>
                        <div class="div_select" style="width:auto;">
                            <input type="date" name="ac_close" id="ac_close" class="textbox" style="height:99%; width:99%" 
                                value="<?php echo substr($ac_close_date,4,4).'-'.substr($ac_close_date,2,2).'-'.substr($ac_close_date,0,2);?>"
                                min="<?php //echo substr($semdate1,4,4).'-'.substr($semdate1,2,2).'-'.substr($semdate1,0,2);?>"
                                onchange="if (this.value!='')
                                {
                                    _('ac_open').value=this.value;
                                    _('ac_open').stepUp(1)
                                }else
                                {
                                    _('ac_open').value='';
                                }"
                                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
                        </div>
                        <div id="labell_msg49" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                    </div>

                    <div class="innercont_stff" style="margin-top:10px;">
                        <label for="ac_open" class="labell" style="width:220px;">Account open date</label>
                        <div class="div_select" style="width:auto;">
                            <input type="date" name="ac_open" id="ac_open" class="textbox" style="height:99%; width:99%" 
                                value="<?php echo substr($ac_open_date,4,4).'-'.substr($ac_open_date,2,2).'-'.substr($ac_open_date,0,2);?>"
                                min="<?php //echo substr($semdate1,4,4).'-'.substr($semdate1,2,2).'-'.substr($semdate1,0,2);?>"
                                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
                        </div>
                        <div id="labell_msg50" class="labell_msg blink_text orange_msg" style="width:475px"></div>
                    </div><?php
                }?>
                
            </div>

            <div class="innercont_stff_tabs" id="ans5" style="height:auto; width:100%; padding:0px; margin-top:5px;;"><?php
                $poptt = $orgsetins['poptt'];
                $examtt = $orgsetins['examtt'];
                $show_tt = $orgsetins['cShowtt'];?>
                
                <div class="innercont_stff">
                    <label class="labell" style="width:205px">Type of exam</label>
                    <div id="tabletd"  class="div_select">
                        <div style="height:auto; width:20px; margin-top:-2px; float:left">
                            <input name="examType" id="examType1" type="radio" value="p" onclick="opsions_loc.h_examType.value='p'" />
                        </div>
                        <label for="examType1" class="labell" style="margin-top:-3px;width:80px; text-align:left">POP-Exam</label>
                        <div style="height:auto; width:20px; margin-top:-2px; float:left; margin-left:5px;">
                            <input name="examType" id="examType2" type="radio" value="e" onclick="opsions_loc.h_examType.value='e';" />
                        </div>
                        <label for="examType2" class="labell" style="margin-top:-3px;width:80px; text-align:left">e-Exam</label>
                        <input name="h_examType" id="h_examType" type="hidden" value="" />
                    </div>
                    <div class="labell_msg blink_text orange_msg" id="labell_msg29" style="width:475px"></div>
                </div>

                <div class="innercont_stff">
                <label class="labell" style="width:205px"></label>
                    <div id="tabletd"  class="div_select">
                        <div style="height:auto; width:20px; margin-top:-2px; float:left">
                            <input name="examType_df" id="examType_df1" type="radio" value="0" onclick="opsions_loc.h_examType_df.value='0'" />
                        </div>
                        <label for="examType_df1" class="labell" style="margin-top:-3px;width:80px; text-align:left">Draft</label>
                        <div style="height:auto; width:20px; margin-top:-2px; float:left; margin-left:5px;">
                            <input name="examType_df" id="examType_df2" type="radio" value="1" onclick="opsions_loc.h_examType_df.value='1';" />
                        </div>
                        <label for="examType_df2" class="labell" style="margin-top:-3px;width:80px; text-align:left">Final</label>
                        <input name="h_examType_df" id="h_examType_df" type="hidden" value="" />
                    </div>
                    <div class="labell_msg blink_text orange_msg" id="labell_msg43" style="width:475px"></div>
                </div>
                            
                <div class="innercont_stff">
                    <label for="sbtd_pix" class="labell" style="width:205px">Upload timetable<font color="#FF0000">*</font></label>
                    <div class="div_select">
                        <input type="file" name="sbtd_pix1" id="sbtd_pix1"  style="width:223px" value="<?php if(isset($sbtd_pix1)){echo $sbtd_pix1;} ?>" >
                    </div>
                    <div class="labell_msg blink_text orange_msg" id="labell_msg30" style="width:475px"></div>
                </div>

                <div class="innercont_stff">
                    <div class="div_select" style="width:205px; text-align:right">
                        <input name="show_tt" id="show_tt" <?php if ($show_tt=='1'){echo 'checked';} ?> 
                        type="checkbox"
                        onclick="showttOnly()"/>
                    </div>							
                    <div class="div_select">
                        <label for="show_tt">
                            Show timetable
                        </label>
                    </div>
                </div>                
            </div>
        </form>
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