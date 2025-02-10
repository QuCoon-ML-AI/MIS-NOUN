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

if (isset($_REQUEST['vApplicationNo']))
{
	$centres = do_service_mode_centre("2", $_REQUEST['vApplicationNo']);	
	$service_centre = substr($centres,10);
	$num_of_service_centre = trim(substr($centres,0, 9));
}


$orgsetins = settns();
require_once('set_scheduled_dates.php');
require_once('staff_detail.php');


$staff_can_access = 0;

$staff_study_center = '';
if (isset($_REQUEST['user_centre']) && $_REQUEST['user_centre'] <> '')
{
    $staff_study_center = $_REQUEST['user_centre'];
}

$staff_study_center_new = str_replace("|","','",$staff_study_center);
$staff_study_center_new = substr($staff_study_center_new,2,strlen($staff_study_center_new)-4);

if (isset($_REQUEST['id_no']))
{                
    if ($_REQUEST['id_no'] == '0')
    {
        $pry_table = 'prog_choice';
        $main_para = 'vApplicationNo';
    }else
    {
        $pry_table = 's_m_t';	
        $main_para = 'vMatricNo';
    }

    $stmt = $mysqli->prepare("SELECT concat(b.vCityName,' centre')  
    from $pry_table a, studycenter b
    WHERE a.cStudyCenterId = b.cStudyCenterId
    AND a.cStudyCenterId IN ($staff_study_center_new) 
    AND a.$main_para = ?");
    $stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
		
    $stmt->execute();
    $stmt->store_result();

    $stmt->bind_result($vCityName);
    $stmt->fetch();

    $staff_can_access = $stmt->num_rows;
    $stmt->close();
}


$userInfo = '';
$stmt = $mysqli->prepare("SELECT concat(vLastName,' ',vFirstName,' ',vOtherName) username, a.cFacultyId, b.vFacultyDesc, a.cdeptId, c.vdeptDesc, d.sRoleID, e.vRoleName, a.cemail, a.cphone
FROM userlogin a, faculty b, depts c, role_user d, role e
WHERE a.cFacultyId = b.cFacultyId 
AND d.sRoleID = e.sRoleID
AND a.cdeptId = c.cdeptId 
AND d.vUserId = a.vApplicationNo 
AND vApplicationNo = ?");
$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0){$userInfo = '1';}

$stmt->bind_result($username, $cFacultyId_u, $vFacultyDesc_u, $cdeptId_u, $vdeptDesc_u, $sRoleID, $vRoleName, $cemail, $cphone_u);
$stmt->fetch();
$stmt->close();?>

<!-- InstanceBeginEditable name="doctitle" -->
<title>NOUN-MIS</title>
<link rel="icon" type="image/ico" href="./img/left_side_logo.png" />
<!-- InstanceEndEditable -->


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
    function chk_inputs()
	{
		var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			ulChildNodes[j].style.display = 'none';
		}

		if (_("ans5"))
		{
			_("ans5").style.display = 'none';
		}
		
		reg_grp1_loc.frm_upd.value = '';		
		
		if (_("sbtd_pix"))
		{
			var files = _("sbtd_pix").files;
		}
		
        var letters = /^[A-Za-z '-]+$/;
        var numbers_letter = /^[0-9A-Za-z ]+$/;
		var numbers = /^[NOUNSLPC0-9_]+$/;

		var formdata = new FormData();
		
		if (reg_grp1_loc.uvApplicationNo.value == '' || _('id_no').value == ''/*&& !_('enq_ans_div')*/)
		{
			setMsgBox("labell_msg0","");
			reg_grp1_loc.uvApplicationNo.focus();
			return false;
		}else if (!reg_grp1_loc.uvApplicationNo.value.match(numbers))
        {
            setMsgBox("labell_msg0","Invalid number");
			reg_grp1_loc.uvApplicationNo.focus();
			return false;
        }else if (reg_grp1_loc.sm.value == '2')
		{
			if (_('enq_ans_div') && _('enq_ans_div').style.display == 'block')
			{
				if (reg_grp1_loc.tabno.value == '1')
				{
					if (_("vLastName").value == '')
					{
						setMsgBox("labell_msg1","");
						_("vLastName").focus();
						return false;
					}else if (!_("vLastName").value.match(letters))
                    {
                        setMsgBox("labell_msg1","Only letters are allowed");
                        _("vLastName").focus();
                        return false;
                    }else if (_("vLastName").value.length < 3)
					{
						setMsgBox("labell_msg1","Enter full name");
						_("vLastName").focus();
						return false;
					}else if (_("vFirstName").value == '')
					{
						setMsgBox("labell_msg2","");
						_("vFirstName").focus();
						return false;
					}else if (!_("vFirstName").value.match(letters))
                    {
                        setMsgBox("labell_msg2","Only letters are allowed");
                        _("vFirstName").focus();
                        return false;
                    }else if (_("vFirstName").value.length < 3)
					{
						setMsgBox("labell_msg2","Enter full name");
						_("vFirstName").focus();
						return false;
					}else if(_("vOtherName").value.trim() != '' && !_("vOtherName").value.match(letters))
					{
						setMsgBox("labell_msg3","Only letters are allowed");
						_("vOtherName").focus();
						return false;
					}else if (_("vOtherName").value.trim() != '' && _("vOtherName").value.length < 3)
					{
						setMsgBox("labell_msg3","Enter full name");
						_("vOtherName").focus();
						return false;
					}else if (_("cGender").value == '')
					{
						setMsgBox("labell_msg4","");
						_("cGender").focus();
						return false;
					}else if (_("dBirthDate").value == '' || _("dBirthDate").value.length != 10 || _("dBirthDate").value == '00-00-0000')
					{
						setMsgBox("labell_msg5","");
						_("dBirthDate").focus();
						return false;
					}else if (_("cMaritalStatusId").value == '')
					{
						setMsgBox("labell_msg6","");
						_("cMaritalStatusId").focus();
						return false;
					}else if (_("cDisabilityId").value == '')
					{
						setMsgBox("labell_msg7","");
						_("cDisabilityId").focus();
						return false;
					}else if (_("cHomeCountryId").value == '')
					{
						setMsgBox("labell_msg9","");
						_("cHomeCountryId").focus();
						return false;
					}else if (_("cHomeStateId").value == '')
					{
						setMsgBox("labell_msg10","");
						_("cHomeStateId").focus();
						return false;
					}else if (_("cHomeLGAId").value == '')
					{
						setMsgBox("labell_msg11","");
						_("cHomeLGAId").focus();
						return false;
					}else if (_("vHomeCityName").value == '')
					{
						setMsgBox("labell_msg12","");
						_("vHomeCityName").focus();
						return false;
					}else if(rmv_inv_chars(_("vHomeCityName").value,1)!='')
					{
						setMsgBox("labell_msg12",rmv_inv_chars(_("vHomeCityName").value,1));
						_("vHomeCityName").focus();
						return false;
					}else if(marlic(_("vHomeCityName").value)!='')
					{
						setMsgBox("labell_msg12",marlic(_("vHomeCityName").value));
						_("vHomeCityName").focus();
						return false;
					}else if (_("sbtd_pix").files.length > 0)
					{
						if (files[0].type != 'image/jpeg' && files[0].type != 'image/pjpeg')
						{
							setMsgBox("labell_msg8","JPEG required");
							return false;
						}else if (files[0].size > 50000)
						{
							size = files[0].size/1000;
							setMsgBox("labell_msg8","File too large. Max size : 50KB. Attempted size : "+size+"KB");
							return false;
						}
						formdata.append("sbtd_pix", _("sbtd_pix").files[0]);
					}
					_("vLastName").value= _("vLastName").value.replace(/\s+/g, ' ');					
					_("vFirstName").value= _("vFirstName").value.replace(/\s+/g, ' ');
					_("vOtherName").value= _("vOtherName").value.replace(/\s+/g, ' ');

					formdata.append("vLastName", _("vLastName").value);
					formdata.append("vFirstName", _("vFirstName").value);
					formdata.append("vOtherName", _("vOtherName").value);
					formdata.append("cGender", _("cGender").value);
					formdata.append("dBirthDate", _("dBirthDate").value);
					formdata.append("cMaritalStatusId", _("cMaritalStatusId").value);
					formdata.append("cDisabilityId", _("cDisabilityId").value);
					formdata.append("cHomeCountryId", _("cHomeCountryId").value);
					formdata.append("cHomeStateId", _("cHomeStateId").value);
					formdata.append("cHomeLGAId", _("cHomeLGAId").value);
					formdata.append("vHomeCityName", _("vHomeCityName").value);
				}else if (reg_grp1_loc.tabno.value == '2')
				{
					if (_("cPostalCountryId").value == '')
					{
						setMsgBox("labell_msg16","");
						_("cPostalCountryId").focus();
						return false;
					}else if (_("cPostalStateId").value == '')
					{
						setMsgBox("labell_msg17","");
						_("cPostalStateId").focus();
						return false;
					}else if (_("cPostalLGAId").value == '')
					{
						setMsgBox("labell_msg18","");
						_("cPostalLGAId").focus();
						return false;
					}else if (_("vPostalCityName").value == '')
					{
						setMsgBox("labell_msg19","");
						_("vPostalCityName").focus();
						return false;
					}else if (_("vPostalAddress").value == '')
					{
						setMsgBox("labell_msg20","");
						_("vPostalAddress").focus();
						return false;
					}else if (!_("vPostalAddress").value.match(numbers_letter))
                    {
                        setMsgBox("labell_msg20","Only letters and numbers are allowed");
                        _("vPostalAddress").focus();
						return false;
                    }else if (chk_mail(_("vEMailId")) != '')
					{
						setMsgBox("labell_msg21",chk_mail(_("vEMailId")));
						_("vEMailId").focus();
						return false;
					}else if (_("vMobileNo").value == '')
					{
						setMsgBox("labell_msg22","");
						_("vMobileNo").focus();
						return false;
					}else
					{
						formdata.append("cPostalCountryId", _("cPostalCountryId").value);
						formdata.append("cPostalStateId", _("cPostalStateId").value);
						formdata.append("cPostalLGAId", _("cPostalLGAId").value);
						formdata.append("vPostalCityName", _("vPostalCityName").value);
						formdata.append("vPostalAddress", _("vPostalAddress").value);
						formdata.append("vEMailId", _("vEMailId").value);
						formdata.append("vMobileNo", _("vMobileNo").value);
					}
				}else if (reg_grp1_loc.tabno.value == '3')
				{
					if (_("cResidenceCountryId").value == '')
					{
						setMsgBox("labell_msg27","");
						_("cResidenceCountryId").focus();
						return false;
					}else if (_("cResidenceStateId").value == '')
					{
						setMsgBox("labell_msg28","");
						_("cResidenceStateId").focus();
						return false;
					}else if (_("cResidenceLGAId").value == '')
					{
						setMsgBox("labell_msg29","");
						_("cResidenceLGAId").focus();
						return false;
					}else if (_("vResidenceCityName").value == '')
					{
						setMsgBox("labell_msg30","");
						_("vResidenceCityName").focus();
						return false;
					}else if (_("vResidenceAddress").value == '')
					{
						setMsgBox("labell_msg31","");
						_("vResidenceAddress").focus();
						return false;
					}else if (!_("vResidenceAddress").value.match(numbers_letter))
                    {
                        setMsgBox("labell_msg31","Only letters and numbers are allowed");
                        _("vResidenceAddress").focus();
						return false;
                    }else
					{	
						formdata.append("vResidenceAddress", _("vResidenceAddress").value);
						formdata.append("vResidenceCityName", _("vResidenceCityName").value);
						formdata.append("cResidenceCountryId", _("cResidenceCountryId").value);
						formdata.append("cResidenceStateId", _("cResidenceStateId").value);
						formdata.append("cResidenceLGAId", _("cResidenceLGAId").value);
					}
				}else if (reg_grp1_loc.tabno.value == '4')
				{
					if (_("vNOKName").value == '')
					{
						setMsgBox("labell_msg32","");
						_("vNOKName").focus();
						return false;
					}else if (!_("vNOKName").value.match(letters))
                    {
                        setMsgBox("labell_msg32","Only letters are allowed");
                        _("vNOKName").focus();
                        return false;
                    }else if (_("cNOKType").value == '')
					{
						setMsgBox("labell_msg33","");
						_("cNOKType").focus();
						return false;
					}else if (_("vNOKAddress").value == '')
					{
						setMsgBox("labell_msg35","");
						_("vNOKAddress").focus();
						return false;
					}else if (!_("vNOKAddress").value.match(numbers_letter))
                    {
                        setMsgBox("labell_msg35","Only letters and numbers are allowed");
                        _("vNOKAddress").focus();
						return false;
                    }else if (_("vNOKEMailId").value == '')
					{
						setMsgBox("labell_msg36","");
						_("vNOKEMailId").focus();
						return false;
					}else if (chk_mail(_("vNOKEMailId")) != '')
					{
						setMsgBox("labell_msg36",chk_mail(_("vNOKEMailId")));
						_("vNOKEMailId").focus();
						return false;
					}else if (_("vNOKMobileNo").value.trim() == '')
					{
						setMsgBox("labell_msg37","");
						_("vNOKMobileNo").focus();
						return false;
					}else if (isNaN(_("vNOKMobileNo").value))
					{
						setMsgBox("labell_msg37","Numbers only");
						_("vNOKMobileNo").focus();
						return false;
					}else if (_("vNOKName1").value == '')
					{
						setMsgBox("labell_msg38","");
						_("vNOKName1").focus();
						return false;
					}/*else if (!_("vNOKName1").value.match(letters))
                    {
                        setMsgBox("labell_msg38","Only letters are allowed");
                        _("vNOKName1").focus();
                        return false;
                    }else if (_("cNOKType1").value == '')
					{
						setMsgBox("labell_msg39","");
						_("cNOKType1").focus();
						return false;
					}else if (_("vNOKAddress1").value == '')
					{
						setMsgBox("labell_msg41","");
						_("vNOKAddress1").focus();
						return false;
					}else if (!_("vNOKAddress1").value.match(numbers_letter))
                    {
                        setMsgBox("labell_msg41","Only letters and numbers are allowed");
                        _("vNOKAddress1").focus();
						return false;
                    }else if (_("vNOKEMailId1").value == '')
					{
						setMsgBox("labell_msg42","");
						_("vNOKEMailId1").focus();
						return false;
					}else if (chk_mail(_("vNOKEMailId1")) != '')
					{
						setMsgBox("labell_msg42",chk_mail(_("vNOKEMailId1")));
						_("vNOKEMailId1").focus();
						return false;
					}else if (_("vNOKMobileNo1").value.trim() == '')
					{
						setMsgBox("labell_msg43","");
						_("vNOKMobileNo1").focus();
						return false;
					}else if (isNaN(_("vNOKMobileNo1").value))
					{
						setMsgBox("labell_msg43","Numbers only");
						_("vNOKMobileNo1").focus();
						return false;
					}else if (isNaN(_("vNOKMobileNo1").value))
					{
						setMsgBox("labell_msg43","Numbers only");
						_("vNOKMobileNo1").focus();
						return false;
					}else if (_("vNOKName").value == _("vNOKName1").value)
					{
						setMsgBox("labell_msg32","The two cannot be the same");
						setMsgBox("labell_msg38","The two cannot be the same");
						return false;
					}else if (_("cNOKType").value == _("cNOKType1").value)
					{
						setMsgBox("labell_msg33","The two cannot be the same");
						setMsgBox("labell_msg39","The two cannot be the same");
						return false;
					}else if (_("sponsor").value == '0' && _("sponsor1").value == '0' && _("sponsor2").value == '0')
					{
						setMsgBox("labell_msg34","At least, one should be your sponsor");
						setMsgBox("labell_msg40","At least, one should be your sponsor");
						setMsgBox("labell_msg44","At least, one should be your sponsor");
						return false;
					}else if (_("vNOKEMailId").value == _("vNOKEMailId1").value)
					{
						setMsgBox("labell_msg36","The two cannot be the same");
						setMsgBox("labell_msg42","The two cannot be the same");
						return false;
					}else if (_("vNOKMobileNo").value == _("vNOKMobileNo1").value)
					{
						setMsgBox("labell_msg37","The two cannot be the same");
						setMsgBox("labell_msg43","The two cannot be the same");
						return false;
					}*/else
					{	
						formdata.append("vNOKName", _("vNOKName").value);
						formdata.append("cNOKType", _("cNOKType").value);
						formdata.append("sponsor", _("sponsor").value);
						formdata.append("vNOKAddress", _("vNOKAddress").value);
						formdata.append("vNOKEMailId", _("vNOKEMailId").value);
						formdata.append("vNOKMobileNo", _("vNOKMobileNo").value);
						
						formdata.append("vNOKName1", _("vNOKName1").value);
						formdata.append("cNOKType1", _("cNOKType1").value);
						formdata.append("sponsor1", _("sponsor1").value);
						formdata.append("vNOKAddress1", _("vNOKAddress1").value);
						formdata.append("vNOKEMailId1", _("vNOKEMailId1").value);
						formdata.append("vNOKMobileNo1", _("vNOKMobileNo1").value);
						
						formdata.append("sponsor2", _("sponsor2").value);
					}
				}
			}
		}else if (reg_grp1_loc.sm.value == '4')
		{
			if (_("ans7").style.display == 'block')
			{
				if (_("cFacultyIdold").value == '')
				{
					setMsgBox("labell_msg35","");
					_("cFacultyIdold").focus();
					return false;
				}else if (_("cdeptold").value == '')
				{
					setMsgBox("labell_msg36","");
					_("cdeptold").focus();
					return false;
				}else if (_("cprogrammeIdold").value == '')
				{
					setMsgBox("labell_msg37","");
					_("cprogrammeIdold").focus();
					return false;
				}else if (_("courseLevel").value == '')
				{
					setMsgBox("labell_msg38","");
					_("courseLevel").focus();
					return false;
				}else
				{
					if (_("courseLevel").value == 40 && _("user_cEduCtgId").value == 'PSZ')
					{
						setMsgBox("labell_msg38","Warning! This level implies access programme");
						_("courseLevel").focus();
						_("user_cEduCtgId").value = 'go';
					}
					
					formdata.append("cFacultyIdold", _("cFacultyIdold").value);
					formdata.append("cdeptold", _("cdeptold").value);
					formdata.append("cprogrammeIdold", _("cprogrammeIdold").value);
					formdata.append("courseLevel", _("courseLevel").value);
					formdata.append("user_cEduCtgId", _("user_cEduCtgId").value);
				}
			}else if (_("ans8").style.display == 'block')
			{
				if (_("cStudyCenterIdold").value == '')
				{
					setMsgBox("labell_msg39","");
					_("cStudyCenterIdold").focus();
					return false;	
				}else
				{
					formdata.append("cStudyCenterIdold", _("cStudyCenterIdold").value);
				}
			}else if (_("ans9").style.display == 'block')
			{
				if (_("tSemester").value == '')
				{
					setMsgBox("labell_msg40","");
					_("tSemester").focus();
					return false;	
				}else
				{
					formdata.append("tSemester", _("tSemester").value);
				}
			}else if (_("ans10").style.display == 'block')
			{
				if (_("courseLevel_2").value == '')
				{
					setMsgBox("labell_msg41","");
					_("courseLevel_2").focus();
					return false;	
				}else
				{
					formdata.append("courseLevel_2", _("courseLevel_2").value);
					if (_("courseLevel_2").value == 40 && _("user_cEduCtgId").value == 'PSZ')
					{
						setMsgBox("labell_msg41","Warning! This level implies access (sub-degree) programme");
						_("courseLevel_2").focus();
						_("user_cEduCtgId").value = 'go';
					}
					formdata.append("user_cEduCtgId", _("user_cEduCtgId").value);
				}
			}else if (_("whattodo").value == 9 && _("upld_passpic_no").value == 0)
			{
				//_("succ_boxt").className = "succ_box blink_text orange_msg";
					
				//_("succ_boxt").innerHTML = 'Passport upload chances cannot be updated';
				//_("succ_boxt").style.display = 'block';
				return false;
			}
			
			formdata.append("id_no", _("id_no").value);
			formdata.append("whattodo", _("whattodo").value);
			
			if ((_("whattodo").value == 2 || _("whattodo").value == 3) && _("boxchk").value == 1 && reg_grp1_loc.conf_g.value == '')
			{
				var container_cover_inheight = _("container_cover_in").style.height;
				container_cover_inheight = container_cover_inheight.substr(0, container_cover_inheight.length-2)
				
				var container_cover_inwidth = _("container_cover_in").style.width;
				container_cover_inwidth = container_cover_inwidth.substr(0, container_cover_inwidth.length-2)
				
				var screenAvailHeight = screen.availHeight;
				var screenAvailWidth = screen.availWidth;
				
				var topPos = (screenAvailHeight/2)- container_cover_inheight;
				var leftPos = (screenAvailWidth/2)- (container_cover_inwidth/2);
				
				_("container_cover_in").style.top = topPos+'px';
				_("container_cover_in").style.left = leftPos+'px';
				
				_("container_cover").style.display = 'block';
				_("container_cover").style.zIndex = 0;
				_("container_cover_in").style.display = 'block';
				_("container_cover_in").style.zIndex = 1;
				
				if (_("whattodo").value == 2)
				{
					_("inner_submityes_g").innerHTML = 'Are you sure you want to drop selected registered exams?';
					_("inner_submityes_header0").innerHTML = 'Drop exam';
				}else if (_("whattodo").value == 3)
				{
					_("inner_submityes_g").innerHTML = 'Are you sure you want to drop selected registered courses?';
					_("inner_submityes_header0").innerHTML = 'Drop courses';
				}
			}
			
			if (reg_grp1_loc.conf.value == '1' || reg_grp1_loc.conf_g.value == '1')
			{
				if (reg_grp1_loc.conf_g.value == '1'){reg_grp1_loc.conf.value = reg_grp1_loc.conf_g.value;}
				formdata.append("conf", reg_grp1_loc.conf.value);
			}
			
			if (reg_grp1_loc.numOfiputTag.value > 0 && (reg_grp1_loc.conf_g.value == '1' || reg_grp1_loc.conf.value == '1'))
			{
				formdata.append("numOfiputTag", reg_grp1_loc.numOfiputTag.value);
				for (j = 0; j < reg_grp1_loc.numOfiputTag.value; j++)
				{
					if (_('regCourses'+j) && _('regCourses'+j).checked && !_('regCourses'+j).disabled)
					{
						formdata.append("regCourses"+j, _("regCourses"+j).value);
						formdata.append("regCoursesh"+j, _("regCoursesh"+j).value);
						
						 _("regCourses"+j).disabled = true;
					}
				}
			}
		}
		
		
		formdata.append("currency_cf", _("currency_cf").value);
		formdata.append("user_cat", reg_grp1_loc.user_cat.value);
		formdata.append("save_cf", _("save_cf").value);
		formdata.append("uvApplicationNo", reg_grp1_loc.uvApplicationNo.value);
		formdata.append("vApplicationNo", reg_grp1_loc.vApplicationNo.value);
		formdata.append("sm", reg_grp1_loc.sm.value);
		formdata.append("mm", reg_grp1_loc.mm.value);
		
		formdata.append("study_mode_ID",reg_grp1_loc.study_mode_ID.value);
		

    	formdata.append("id_no", reg_grp1_loc.id_no.value);
		if(_('enq_ans_div') && _('enq_ans_div').style.display == 'block')
		{
			formdata.append("tabno", reg_grp1_loc.tabno.value);			
		}
		
		formdata.append("uvApplicationNo_loc", reg_grp1_loc.uvApplicationNo_loc.value);
		
		opr_prep(ajax = new XMLHttpRequest(),formdata);
	}
	
	
	function opr_prep(ajax,formdata)
	{
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		
		ajax.open("POST", "opr_reg_grp1.php");
		ajax.send(formdata);
    }

    function completeHandler(event)
    {
        on_error('0');
        on_abort('0');
        in_progress('0');
        //_("succ_boxt_mail").style.display = 'none';

        var returnedStr = event.target.responseText;
		var numberOfRec = 0;
		var app_frm_no = '';

		if (returnedStr.indexOf("too large") > -1 ||
		returnedStr.indexOf("Cannot upload") > -1 ||
		returnedStr.indexOf("file to upload") > -1)
		{
			caution_box(returnedStr)
		}

		if (_('frm_upd').value == '')
		{
			if (_("std_state")){_("std_state").innerHTML = '';}
			if (_("std_names")){_("std_names").innerHTML = '';}
			if (_("std_quali")){_("std_quali").innerHTML = '';}
			if (_("std_lvl")){_("std_lvl").innerHTML = '';}
			if (_("std_sems")){_("std_sems").innerHTML = '';}
		}
		
		if (_("whattodo") && _("frm_upd").value == '')
		{
			var plus_ind = returnedStr.indexOf("+");
			var at_ind = returnedStr.indexOf("@");
			var dol_ind = returnedStr.indexOf("$");
			var car_ind = returnedStr.indexOf("^");
			var ash_ind = returnedStr.indexOf("#");
			var perc_ind = returnedStr.indexOf("%");
			var bang_ind = returnedStr.indexOf("!");
			
			if (_("whattodo") && _("whattodo").value <= 3)
			{
				if (_("id_no") && _("id_no").value == 1)
				{
					app_frm_no = returnedStr.substr(0,plus_ind);
					
					_("std_names").innerHTML = returnedStr.substr(at_ind+1, (dol_ind-at_ind)-1);
					_("std_quali").innerHTML = returnedStr.substr(plus_ind+1, at_ind-plus_ind-1);
					_("std_lvl").innerHTML = returnedStr.substr(dol_ind+1, (car_ind-dol_ind)-1)+' Level';
				}else if (_("id_no") && _("id_no").value == 0)
				{
				
					_("std_names").innerHTML = returnedStr.substr(at_ind+1, (car_ind-at_ind)-1);
					_("std_quali").innerHTML = returnedStr.substr(plus_ind+1, at_ind-plus_ind-1);
					_("std_lvl").innerHTML = returnedStr.substr(car_ind+1, (ash_ind-car_ind)-1)+' Level';
				}
				
				if (returnedStr.substr(car_ind+1, 1) == 1)
				{
					if (_("std_sems")){_("std_sems").innerHTML = 'First semester';}
				}else
				{
					if (_("std_sems")){_("std_sems").innerHTML = 'Second semester';}
				}
				
				
				if (_("whattodo").value == 2 || _("whattodo").value == 3)
				{	
					numberOfRec = returnedStr.substr(ash_ind+1,perc_ind-ash_ind-1);
				}
				
				if (perc_ind > -1)
				{
					returnedStr = returnedStr.substr(perc_ind+1);
				}else if (ash_ind > -1)
				{
					returnedStr = returnedStr.substr(ash_ind+1);
				}
			}else if (reg_grp1_loc.sm.value == 4 && _("whattodo").value == 4)
			{
				if (_("id_no") && _("id_no").value == 1)
				{
					_("std_names").innerHTML = returnedStr.substr(at_ind+1, (dol_ind-at_ind)-1);
					_("std_lvl").innerHTML = returnedStr.substr(dol_ind+1, (car_ind-dol_ind)-1)+'Level';
				}else
				{
					_("std_names").innerHTML = returnedStr.substr(at_ind+1, (car_ind-at_ind)-1);
					_("std_lvl").innerHTML = returnedStr.substr(car_ind+1, (ash_ind-car_ind)-1)+' evel';
				}
				
				_("std_quali").innerHTML = returnedStr.substr(0, at_ind);
				if (reg_grp1_loc.sm.value == 1 || (reg_grp1_loc.sm.value == 4 && _("whattodo") && _("id_no").value == 0))
				{
					if (_("std_sems")){_("std_sems").innerHTML = 'First semester';}
				}
				returnedStr = returnedStr.substr(ash_ind+1);
			}else if (_("whattodo").value >= 5)
			{
				if (_("id_no").value == 1)
				{
					app_frm_no = returnedStr.substr(0,plus_ind);
				}
				returnedStr = returnedStr.substr(plus_ind+1);
			}else if (_("id_no").value == 1)
			{
				app_frm_no = returnedStr.substr(perc_ind+1,plus_ind);
				returnedStr = returnedStr.substr(plus_ind+1);
			}
		}else if (reg_grp1_loc.sm.value == 1 || reg_grp1_loc.sm.value == 2)
		{
			var at_ind = returnedStr.indexOf("@");
			var car_ind = returnedStr.indexOf("^");
			var ash_ind = returnedStr.indexOf("#");
			var dol_ind = returnedStr.indexOf("$");
			var plus_ind = returnedStr.indexOf("+");
			
			if (_('frm_upd').value == '')
			{
				if (reg_grp1_loc.sm.value == 1)
				{
					if (_("std_names")){_("std_names").innerHTML = returnedStr.substr(at_ind+1, (car_ind-at_ind)-1);}
					if (_("std_quali")){_("std_quali").innerHTML = returnedStr.substr(0, at_ind);}
					if (_("std_lvl")){_("std_lvl").innerHTML = returnedStr.substr(car_ind+1, (ash_ind-car_ind)-1)+'Level';}
					if (_("std_sems")){_("std_sems").innerHTML = 'First semester';}
				}else if (reg_grp1_loc.sm.value == 2)
				{
					if (_("std_names")){_("std_names").innerHTML = returnedStr.substr(at_ind+1, (dol_ind-at_ind)-1);}
					if (_("std_quali")){_("std_quali").innerHTML = returnedStr.substr(plus_ind+1, (at_ind-plus_ind)-1);}
					if (_("std_lvl")){_("std_lvl").innerHTML = returnedStr.substr(dol_ind+1, (car_ind-dol_ind)-1)+'Level';}
					if (returnedStr.substr(car_ind+1, 1) == 1)
					{
						if (_("std_sems")){_("std_sems").innerHTML = 'First semester';}
					}else
					{
						if (_("std_sems")){_("std_sems").innerHTML = 'Second semester';}
					}
				}
			}
			returnedStr = returnedStr.substr(ash_ind+1);
		}
		
		
		if (_("frm_upd").value == 1 || _("frm_upd").value == 3 || _("frm_upd").value == 5)
		{
			var stateid = '';
			var statename = '';
			
			var stateidname = '';
			if (_("frm_upd").value == 1)
			{
				_("cPostalStateId").options.length = 0;
				_("cPostalStateId").options[_("cPostalStateId").options.length] = new Option('', '');
				
				_("cPostalLGAId").options.length = 0;
				_("cPostalLGAId").options[_("cPostalLGAId").options.length] = new Option('', '');
			}else if(_("frm_upd").value == 3)
			{  
				_("cResidenceStateId").options.length = 0;
				_("cResidenceStateId").options[_("cResidenceStateId").options.length] = new Option('', '');
				
				_("cResidenceLGAId").options.length = 0;
				_("cResidenceLGAId").options[_("cResidenceLGAId").options.length] = new Option('', '');
			}else if(_("frm_upd").value == 5)
			{  
				_("cHomeStateId").options.length = 0;
				_("cHomeStateId").options[_("cHomeStateId").options.length] = new Option('', '');
				
				_("cHomeLGAId").options.length = 0;
				_("cHomeLGAId").options[_("cHomeLGAId").options.length] = new Option('', '');
			}
				
			
			for (i = 0; i <= returnedStr.length; i++)
			{
				if (stateid.length != 2)
				{
					stateid = stateid + returnedStr.charAt(i);
				}else if (returnedStr.charAt(i) != ',' && returnedStr.charAt(i) != ';' && stateid.length == 2)
				{
					statename = statename + returnedStr.charAt(i);
				}else if (returnedStr.charAt(i) != ',')
				{
					if (_("frm_upd").value == 1)
					{
						_("cPostalStateId").options[_("cPostalStateId").options.length] = new Option(statename, stateid);
					}else if (_("frm_upd").value == 3)
					{
						_("cResidenceStateId").options[_("cResidenceStateId").options.length] = new Option(statename, stateid);
					}else if (_("frm_upd").value == 5)
					{
						_("cHomeStateId").options[_("cHomeStateId").options.length] = new Option(statename, stateid);
					}
										
					stateid = '';
					statename = '';
				}
			}
		}else if (_("frm_upd").value == 2 || _("frm_upd").value == 4 || _("frm_upd").value == 6)
		{
			var lgaid = '';
			var lganame = '';
			
			var lgaidname = '';
			
			if (_("frm_upd").value == 2)
			{
				_("cPostalLGAId").options.length = 0;
				_("cPostalLGAId").options[_("cPostalLGAId").options.length] = new Option('', '');
			}else if (_("frm_upd").value == 4)
			{
				_("cResidenceLGAId").options.length = 0;
				_("cResidenceLGAId").options[_("cResidenceLGAId").options.length] = new Option('', '');
			}else if (_("frm_upd").value == 6)
			{
				_("cHomeLGAId").options.length = 0;
				_("cHomeLGAId").options[_("cHomeLGAId").options.length] = new Option('', '');
			}
			
			for (i = 0; i <= returnedStr.length; i++)
			{
				if (lgaid.length != 5)
				{
					lgaid = lgaid + returnedStr.charAt(i);
				}else if (returnedStr.charAt(i) != ',' && returnedStr.charAt(i) != ';' && lgaid.length == 5)
				{
					lganame = lganame + returnedStr.charAt(i);
				}else if (returnedStr.charAt(i) != ',')
				{
					if (_("frm_upd").value == 2)
					{
						_("cPostalLGAId").options[_("cPostalLGAId").options.length] = new Option(lganame, lgaid);
					}else if (_("frm_upd").value == 4)
					{
						_("cResidenceLGAId").options[_("cResidenceLGAId").options.length] = new Option(lganame, lgaid);
					}else if (_("frm_upd").value == 6)
					{
						_("cHomeLGAId").options[_("cHomeLGAId").options.length] = new Option(lganame, lgaid);
					}
									
					lgaid = '';
					lganame = '';
				}
			}
		}else
		{
			if (reg_grp1_loc.sm.value == 1 || reg_grp1_loc.sm.value == 2 || reg_grp1_loc.sm.value == 4 || reg_grp1_loc.sm.value == 5 || reg_grp1_loc.sm.value == 6)
			{
				if (returnedStr == 'Invalid input')
				{
					caution_box(returnedStr);
				}else if (returnedStr.indexOf("?") == -1  && returnedStr.indexOf("has matriculation") == -1  && returnedStr.indexOf("Programme") == -1 && returnedStr.indexOf("programme") == -1 && returnedStr.indexOf("Once matriculation") == -1 && (returnedStr.indexOf('No match') != -1 || returnedStr.indexOf('graduated') != -1 || returnedStr.indexOf('not') != -1 || returnedStr.indexOf('already') != -1 || returnedStr.indexOf('blocked') != -1))
				{
					setMsgBox("labell_msg0", returnedStr);
					reg_grp1_loc.tabno.value = '0';
					reg_grp1_loc.uvApplicationNo.focus();
				}else if ((reg_grp1_loc.sm.value == 1 || reg_grp1_loc.sm.value == 4) && returnedStr.indexOf("?") > -1)
				{
					_("inner_submityes").innerHTML = returnedStr.substr(returnedStr.indexOf("#")+1);
				}else if (reg_grp1_loc.conf.value == '1' &&  !(_("whattodo") &&  _("whattodo").value > 1))
				{
					setMsgBox("labell_msg0", returnedStr);
					reg_grp1_loc.conf.value = '';
				}else if (returnedStr.indexOf('cannot be changed') != -1 || returnedStr.indexOf('Access to application form blocked') != -1 || returnedStr.indexOf("has matriculation") != -1 || returnedStr.indexOf("Once matriculation") != -1 || returnedStr.indexOf('Beyond') != -1)
				{
					caution_box(returnedStr);
					reg_grp1_loc.conf.value = '';
				}else if (returnedStr.indexOf("Invalid programme level") != -1)
				{
					if (_("whattodo").value == 5)
					{
                        caution_box(returnedStr);
						_("courseLevel").focus();
					}else if (_("whattodo").value == 7)
					{
                        caution_box(returnedStr);
						_("courseLevel_2").focus();
					}
				}else if (returnedStr.indexOf("yet to") != -1)
				{
					caution_box(returnedStr);
				}else if (returnedStr.indexOf("Insufficient") != -1 || returnedStr.indexOf("Select file") != -1)
				{
					caution_box(returnedStr);
				}else if ((returnedStr.trim() == '' || returnedStr.indexOf("success") != -1) && ((reg_grp1_loc.mm.value == 1 || reg_grp1_loc.mm.value == 8) && (reg_grp1_loc.sm.value == 2 || reg_grp1_loc.sm.value == 5 || reg_grp1_loc.sm.value == 6)))
				{
					if (reg_grp1_loc.sm.value == 5 || reg_grp1_loc.sm.value == 6)
					{
						_("reg_grp1_loc").target = '_blank';
					}
					
					if (reg_grp1_loc.sm.value == 5)
					{
						_("reg_grp1_loc").action = 'preview-form';
					}
					
					if (reg_grp1_loc.sm.value == 6)
					{
						_("reg_grp1_loc").action = 'see-admission-letter';
					}
					
					_("reg_grp1_loc").submit();
				}else if (returnedStr.indexOf('successfully') != -1)
				{
					if (reg_grp1_loc.sm.value == 1)
					{
						//setMsgBox("labell_msg0", returnedStr);
                        success_box(returnedStr);
					}else if (reg_grp1_loc.sm.value == 2)
					{
                        success_box(returnedStr);
					}else if (reg_grp1_loc.sm.value == 4 && (_("whattodo").value == 5 || _("whattodo").value == 6 || _("whattodo").value == 7 || _("whattodo").value == 8 || _("whattodo").value == 9))
					{
                        success_box(returnedStr);
					}
				}
			}
			
			if (reg_grp1_loc.sm.value == '4' && (_("whattodo").value == 2 || _("whattodo").value == 3) && returnedStr.indexOf('Invalid') == -1 && returnedStr.indexOf('graduated') == -1 && returnedStr.indexOf('blocked') == -1 && returnedStr.charAt(0) != 'x' && returnedStr.indexOf('Beyond') == -1)
			{
				/*var ind_1 = 0;
				
				if (numberOfRec != '')
				{
					reg_grp1_loc.numOfiputTag.value = numberOfRec;
				}
				
				for (j = 0; j < numberOfRec; j++)
				{
					if (_('regCourses'+j) && (returnedStr.indexOf('Please drop the exam') != -1 || returnedStr.indexOf('return course material') != -1))
					{
						_("regCourses"+j).disabled = false;					
					}else if (!_('regCourses'+j))
					{
						var li = document.createElement('li');
						li.style.height = '23px';
						
						if (j%2 == 0){li.style.background = '#f5f5f5';}else{li.style.background = '#FFFFFF';}
						
						var label1 = document.createElement('label');
						label1.setAttribute('class','label');
						li.appendChild(label1);
						
						var div1 = document.createElement('div');
						div1.setAttribute('class','ctabletd_1');
						div1.innerHTML = j+1;
						div1.style.width = '29px';
						label1.appendChild(div1);
						
						var div11 = document.createElement('div');
						div11.setAttribute('class','ctabletd_1');
						div11.style.width = '20px';
						label1.appendChild(div11);
						 
						var input = document.createElement('input');
						input.type = 'checkbox';
						input.name = 'regCourses'+j;
						input.id = 'regCourses'+j;
						input.setAttribute('onclick', 'chk_4_chkd();');
						input.value = returnedStr.substr(ind_1,6);
						div11.appendChild(input);
						
						var div2 = document.createElement('div');
						div2.setAttribute('class','ctabletd_1');
						div2.style.width = '60px';
						div2.innerHTML = returnedStr.substr(ind_1,6);
						div2.style.textAlign = 'center';
						label1.appendChild(div2);
						
						ind_1 = ind_1 + 6 + 1;
						
						var div3 = document.createElement('div');
						div3.setAttribute('class','ctabletd_1');
						var sub_str = returnedStr.substr(ind_1,100); build_str = '';
						for (i = 0; i <= sub_str.length-1; i++)
						{
							if (sub_str.charAt(i) != '_'){build_str = build_str + sub_str.charAt(i)}
						}
						div3.innerHTML = build_str;
						div3.style.width = '404px';
						label1.appendChild(div3);
						 
						ind_1 = ind_1 + 100 + 1;
						 
						var div4 = document.createElement('div');
						div4.setAttribute('class','ctabletd_1');
						div4.style.width = '47px';
						div4.style.textAlign = 'center';
						div4.innerHTML = returnedStr.substr(ind_1,1);
						label1.appendChild(div4);
						 
						ind_1 = ind_1 + 1 + 1;
						 
						var div5 = document.createElement('div');
						div5.setAttribute('class','ctabletd_1');
						div5.style.width = '70px';
						div5.style.textAlign = 'center';
						div5.innerHTML = returnedStr.substr(ind_1,1);
						label1.appendChild(div5);
						
						var input = document.createElement('input');
						input.type = 'hidden';
						input.name = 'regCoursesh'+j;
						input.id = 'regCoursesh'+j;
						input.value = returnedStr.substr(ind_1,1);
						div5.appendChild(input);
						 
						ind_1 = ind_1 + 1 + 1;
						
						var div6 = document.createElement('div');
						div6.setAttribute('class','ctabletd_1');
						div6.style.width = '69px';
						div6.style.textAlign = 'right';
						
						var sub_str = returnedStr.substr(ind_1,5); build_str = '';
						for (i = 0; i <= sub_str.length-1; i++)
						{
						if (sub_str.charAt(i) != '_'){build_str = build_str + sub_str.charAt(i)}
						}
						
						div6.innerHTML = build_str;
						label1.appendChild(div6);
						
						ind_1 = ind_1 + 5 + 1;
						
						_("reg_courses").appendChild(li);
					}
				}*/
				
				
				_("ans5").style.display = 'block';
				_("reg_courses").style.display = 'block';
				
				if (_("numOfiputTag").value == 0)
				{
					var tmpStr = '';
					if (_("whattodo").value == 2){tmpStr = 'No course has been registered for exam this semester';}
					else if (_("whattodo").value == 3){tmpStr = 'No course has been registered this semester';}
					
                    caution_box(tmpStr);
				}else if (_("boxchk").value == 0 && _("numOfiputTag").value > 0)
				{
                    caution_box('Select course(s) to be dropped by clicking on the corresponding line');
				}else if (returnedStr.indexOf("drop") != -1 || returnedStr.indexOf('return course material') != -1)
				{
                    caution_box(returnedStr);
					
					reg_grp1_loc.conf.value = '';
					reg_grp1_loc.conf_g.value = '';
					_("boxchk").value = 0;
				}
			}else if (reg_grp1_loc.sm.value == '4' && (_("whattodo").value == 5 || _("whattodo").value == 6 || _("whattodo").value == 7 || _("whattodo").value == 8 || _("whattodo").value == 9))
			{
				if (reg_grp1_loc.frm_upd.value == 'f' || reg_grp1_loc.frm_upd.value == 'd')
				{
					if (reg_grp1_loc.frm_upd.value == 'f')
					{
						_("cdeptold").options.length = 0;
						_("cdeptold").options[_("cdeptold").options.length] = new Option('', '');
					}else if (reg_grp1_loc.frm_upd.value == 'd')
					{
						_("cprogrammeIdold").options.length = 0;
						_("cprogrammeIdold").options[_("cprogrammeIdold").options.length] = new Option('', '');
					}
					
					var cProgId = ''; cProgdesc = ''; comaFound = 0; semicol = 0;
					
					for (i = 0; i <= returnedStr.length-1; i++)
					{
						if (returnedStr.charAt(i) == '%'){semicol = 1;}
						if (returnedStr.charAt(i) == '+'){comaFound = 1;}
						
						if ((i == 0 || comaFound == 0) && returnedStr.charAt(i) != '$')
						{
							cProgId = cProgId + returnedStr.charAt(i);
						}else if (comaFound == 1 && semicol == 0 && returnedStr.charAt(i) != '+')
						{
							cProgdesc = cProgdesc + returnedStr.charAt(i);
						}else if (semicol == 1)
						{
							if (reg_grp1_loc.frm_upd.value == 'f')
							{
								_("cdeptold").options[_("cdeptold").options.length] = new Option(cProgdesc, cProgId);
							}else if (reg_grp1_loc.frm_upd.value == 'd')
							{
								_("cprogrammeIdold").options[_("cprogrammeIdold").options.length] = new Option(cProgdesc, cProgId);
							}
							cProgId = ''; cProgdesc = ''; semicol = 0; comaFound = 0
						}
					}
				}else if (_("ans6").style.display == 'none' && returnedStr.indexOf('Invalid') == -1 && returnedStr.indexOf('blocked') == -1 && returnedStr.indexOf("has matriculation") == -1 && returnedStr.indexOf("yet to") == -1 && returnedStr.indexOf('Beyond') == -1)
				{
					_("div_a").innerHTML = _("uvApplicationNo").value;
					_("div_0").innerHTML = returnedStr.substr(0,returnedStr.indexOf("@"));
					_("div_1").innerHTML = returnedStr.substr(returnedStr.indexOf("@")+1,(returnedStr.indexOf("$")-returnedStr.indexOf("@")-1));
					_("div_2").innerHTML = returnedStr.substr(returnedStr.indexOf("$")+1,(returnedStr.indexOf("%")-returnedStr.indexOf("$")-1));
					_("div_3").innerHTML = returnedStr.substr(returnedStr.indexOf("%")+1,(returnedStr.indexOf("!")-returnedStr.indexOf("%")-1));
					_("div_4").innerHTML = returnedStr.substr(returnedStr.indexOf("!")+1,(returnedStr.indexOf("^")-returnedStr.indexOf("!")-1));
					_("div_5").innerHTML = returnedStr.substr(returnedStr.indexOf("^")+1,(returnedStr.indexOf("&")-returnedStr.indexOf("^")-1))+'/'+
					returnedStr.substr(returnedStr.indexOf("&")+1,1);
					_("user_cEduCtgId").value = returnedStr.substr(returnedStr.indexOf("&")+2,3);
					
					if (_("id_no").value == 0)
					{
						_("div_lab_a").innerHTML = 'Appl. form number';
					}else if (_("id_no").value == 1)
					{
						_("div_lab_a").innerHTML = 'Matriculation number';
					}
					
					_("cFacultyIdold_div").style.display = 'block';
					_("cdeptold_div").style.display = 'block';
					_("cprogrammeIdold_div").style.display = 'block';
					_("courseLevel_div").style.display = 'block';
					
					_("ans6").style.display = 'block';
					
					if (_("whattodo").value == 5)
					{
						_("cFacultyIdold").value = '';
						_("cdeptold").options.length = 0;
						_("cdeptold").options[_("cdeptold").options.length] = new Option('', '');
						_("cprogrammeIdold").options.length = 0;
						_("cprogrammeIdold").options[_("cprogrammeIdold").options.length] = new Option('', '');
						
						_("courseLevel").value = '';
						
						_("ans7").style.display = 'block';
					}else if (_("whattodo").value == 6)
					{
						_("cStudyCenterIdold").value = '';
						
						_("ans8").style.display = 'block';
					}else if (_("whattodo").value == 7)
					{
						_("ans9").style.display = 'block';
						if(_('id_no').value == 0){_("tSemester").value = 1;}else{_("tSemester").value = '';}
					}else if (_("whattodo").value == 8)
					{
						_("courseLevel_2").value = '';
						_("ans10").style.display = 'block';
					}
				}
						
				
				if (_("whattodo").value == 9 && _("pasUpldFlg").value == 0)
				{
					_("inner_submityes").innerHTML = 'Are you sure you want to reset photo upload chances for student?';
					_("pasUpldFlg").value = 1;
				}
			}else if (returnedStr.charAt(0) == 'x')
			{
                caution_box(returnedStr.substr(1,returnedStr.length-1));
			}
		}
		reg_grp1_loc.conf.value = '';
		 
		
		if (!(reg_grp1_loc.mm.value == 1 && reg_grp1_loc.sm.value == 2) && 
		returnedStr.indexOf('Invalid') == -1 && 
		returnedStr.indexOf('successful') == -1 &&
		returnedStr.indexOf('not yet') == -1 &&
		returnedStr.indexOf('Please drop') == -1 &&
		returnedStr.indexOf('No course') == -1 &&
		reg_grp1_loc.frm_upd.value == '')
		{
			if (reg_grp1_loc.sm.value == 1 || reg_grp1_loc.sm.value == 5 || reg_grp1_loc.sm.value == 6 || (_("id_no") && _("id_no").value == 0))
			{
				_("passprt").src = '../../ext_docs/pics/'+reg_grp1_loc.cFacultyId.value+'/pp/p_'+reg_grp1_loc.uvApplicationNo.value+'.jpg';
				
				_("passprt").onerror = function() {myFunction()};

				function myFunction() {
				  _("passprt").src = './appl/img/left_side_logo.png'
				}
			}else if (_("id_no") && _("id_no").value == 1)
			{
				_("passprt").src = '../../ext_docs/pics/'+reg_grp1_loc.cFacultyId.value+'/pp/p_'+app_frm_no+'.jpg';
				_("passprt").onerror = function() {myFunction()};

				function myFunction() {
				_("passprt").src = './img/left_side_logo.png'
				}
				reg_grp1_loc.uvApplicationNo_loc.value = app_frm_no;
			}
		}
		reg_grp1_loc.frm_upd.value = '';
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

    
	function chk_4_chkd()
	{
		_("boxchk").value = 0;
		var ulChildNodes = _("reg_courses").getElementsByTagName("input");
		reg_grp1_loc.numOfiputTag.value = ulChildNodes.length-1;
		
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			if (ulChildNodes[j].type == 'checkbox' && ulChildNodes[j].checked && !ulChildNodes[j].disabled){_("boxchk").value = 1;return;}
		}
	}

    function tab_modify(tab_no)
    {        
		reg_grp1_loc.tabno.value = tab_no;       
		tablinks = document.getElementsByClassName("innercont_stff_tabs");
		for (i = 0; i < tablinks.length; i++) 
		{
			var tab_Id = 'tabss' + (i+1);
			if (!_(tab_Id) || tab_Id == 'tabss5'){continue;}
			
			var cover_maincontent_id = 'ans' + (i+1);
			if (tab_no == (i+1))
			{
				_(tab_Id).style.borderBottom = '1px solid #FFFFFF';
				_(cover_maincontent_id).style.visibility = 'visible';
				_(cover_maincontent_id).style.display = 'block';
			}else
			{
				_(tab_Id).style.border = '1px solid #BCC6CF';
				_(cover_maincontent_id).style.visibility = 'hidden';
				_(cover_maincontent_id).style.display = 'none';
			}
		}
    }


    function tidy_screen()
    {
        _("ans5").style.display = 'none';
        
		_("cFacultyIdold_div").style.display = 'none';
        _("cdeptold_div").style.display = 'none';
        _("cprogrammeIdold_div").style.display = 'none';
        _("courseLevel_div").style.display = 'none';
        
        _("pasUpldFlg").value = 0;
        
        reg_grp1_loc.conf.value = '';
        reg_grp1_loc.conf_g.value = '';
        reg_grp1_loc.boxchk.value = 0;
        
        _("ans6").style.display = 'none';
        _("ans7").style.display = 'none';
        _("ans8").style.display = 'none';
        _("ans9").style.display = 'none';
        _("ans10").style.display = 'none';

		_('enq_ans_div').style.display='none';
        
        var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
        for (j = 0; j <= ulChildNodes.length-1; j++)
        {
            ulChildNodes[j].style.display = 'none';
        }
        
        if (reg_grp1_loc.sm.value == '4' && (_("whattodo").value == 2 || _("whattodo").value == 3)){_("reg_courses").innerHTML = '';}
        
        if (_("whattodo"))
        { 
            if (_("whattodo").value > 1)
            {
                _('reg_courses').style.height = '395px';
            }else
            {
                _('ans5').style.display = 'none';
            }
        }
        _("user_cEduCtgId").value = '';
        
        _("passprt").src = './img/left_side_logo.png';
    }


    function updateScrn(val)
    {
        var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
        for (j = 0; j <= ulChildNodes.length-1; j++)
        {
            ulChildNodes[j].style.display = 'none';
        }
        
        var formdata = new FormData();
        if (val == 'f')
        {
            formdata.append("cFacultyIdold", _("cFacultyIdold").value);
        }else if (val == 'd')
        {
            formdata.append("cdeptold", _("cdeptold").value);
        }
        
        reg_grp1_loc.frm_upd.value = val;
        formdata.append("frm_upd", reg_grp1_loc.frm_upd.value);
        
        opr_prep(ajax = new XMLHttpRequest(),formdata);
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
	//time_out_box($currency);?>

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
		<form action="show-report" method="post" target="_blank" name="m_frm" id="m_frm" enctype="multipart/form-data">
			<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];}; ?>" />
			<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];}; ?>" />
			<input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];}; ?>" /> 
			<input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST['user_cat'];} ?>" />
			<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
			<input name="sm" id="sm" type="hidden" value="<?php echo $sm ?>" />
			<input name="mm" id="mm" type="hidden" value="<?php echo $mm ?>" />
			<!-- <input name="save_cf" id="save_cf" type="hidden" value="-1" /> -->
			<input name="conf" id="conf" type="hidden" value="" />
			<input name="see_frm" id="see_frm" type="hidden" value="1" />
			<input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
			<input name="internalchk" id="internalchk" type="hidden" value="1" />
			<input name="study_mode" id="study_mode" type="hidden" value="odl" />
			
			<input name="service_mode" id="service_mode" type="hidden" 
			value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
			else if (isset($study_mode)){echo $study_mode;}?>" />
			<input name="num_of_mode" id="num_of_mode" type="hidden" 
			value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
			else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

			<input name="user_centre" id="user_centre" type="hidden" 
			value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
			else if (isset($study_mode)){echo $study_mode;}?>" />
			<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
			value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
			else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
		</form>
			<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
            <!-- <div id="appl_box" class="innercont_stff" style="display:block"> -->
			<div class="innercont_top"><?php 
				if ($mm == 1 || $mm == 8)
				{
					if ($sm == 2)
					{
						echo 'Update student biodata';
					}else if ($sm == 3)
					{
						echo 'Update student academic data';
					}else if ($sm == 4)
					{
						echo 'Student requests';
					}else if ($sm == '5')
					{
						echo 'View application form';
					}else if ($sm == '6')
					{
						echo 'View admission letter';
					}
				}?>
			</div>
			
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
			</select><?php

			$mode_match = 1;?>
			<form action="registration-module-one" method="post" name="reg_grp1_loc" id="reg_grp1_loc" enctype="multipart/form-data">
				<input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />	
				<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
				<input name="save_cf" id="save_cf" type="hidden" value="-1" />
				<input name="conf" id="conf" type="hidden" value="" />
				<input name="tabno" id="tabno" type="hidden" 
					value="<?php if (isset($_REQUEST['id_no'])&&$_REQUEST['id_no']<>''&&isset($_REQUEST['tabno'])&&$_REQUEST['tabno']=='0'){echo '1';}else{echo '0';} ?>"/>
				<input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
				<input name="frm_upd" id="frm_upd" type="hidden" />
				<input name="user_cEduCtgId" id="user_cEduCtgId" type="hidden" value="" />
				<input name="numOfiputTag" id="numOfiputTag" type="hidden" value=""/>
				<input name="boxchk" id="boxchk" type="hidden" value="0"/>
				<input name="pasUpldFlg" id="pasUpldFlg" type="hidden" value="0"/>
				<input name="upld_passpic_no" id="upld_passpic_no" type="hidden" value="<?php echo $orgsetins['upld_passpic_no']; ?>"/>
				<input name="uvApplicationNo_loc" id="uvApplicationNo_loc" type="hidden" />
				
				<input name="study_mode_ID" id="study_mode_ID" type="hidden" value="odl" />
				<?php frm_vars(); ?>

				<div class="innercont_stff"><?php
					if (check_scope2('SPGS', 'SPGS menu') > 0)
					{?>
						<a href="#" style="text-decoration:none;" 
							onclick="pg_environ.mm.value=8;pg_environ.sm.value='';pg_environ.submit();return false;">
							<div class="rtlft_inner_button" style="position:absolute; right:0; top:25px; padding:10px;width:auto; height:auto">
								SPGS menu
							</div>
						</a><?php
					}?>

					<div class="div_select"><?php 
						if ($sm == 1 || $sm == '5' || $sm == '6')
						{
							echo 'Application form number (AFN)';
						}else if ($sm == 2)
						{?>
							<select name="id_no" id="id_no" class="select" style="margin-top:0px"
								onchange="tidy_screen();
								reg_grp1_loc.tabno.value='0';
								_('cover_tab').style.display='none';
								_('ans1').style.display='none';
								_('ans2').style.display='none';
								_('ans3').style.display='none';
								_('ans4').style.display='none';
								_('uvApplicationNo').value = '';">
								<option value=""  selected></option><?php
								if (check_scope3('Academic registry', 'Update biodata', 'Applicant') > 0 || check_scope3('SPGS', 'Update biodata', 'Applicant') > 0)
								{?>
									<option value="0"<?php if (isset($_REQUEST['id_no'])&&$_REQUEST['id_no']=='0'){echo 'selected';}?>>Application form number (AFN)</option><?php
								}

								if (check_scope3('Academic registry', 'Update biodata', 'Student') > 0 || check_scope3('SPGS', 'Update biodata', 'Student') > 0)
								{?>
									<option value="1"<?php if (isset($_REQUEST['id_no'])&&$_REQUEST['id_no']=='1'){echo 'selected';}?>>Matriculation number</option><?php
								}?>
							</select><?php
						}else if ($sm == 3)
						{
							echo 'Matriculation number';
						}else if ($sm == 4)
						{?>
							<select name="whattodo" id="whattodo" class="select" style="width:145px; margin-top:-4px" onchange="tidy_screen()">
								<option value="0" onclick="_('id_no').disabled=false;_('uvApplicationNo').focus();">0. Retrieve password for</option>
								<option value="1" onclick="_('id_no').disabled=false;_('uvApplicationNo').focus();">1. Reset password for</option>
								<option value="" disabled="disabled"></option><?php
								if ($orgsetins['regexam'] == '1')
								{?>
								<option value="2" onclick="_('id_no').value=1;_('reg_courses').innerHTML='';_('uvApplicationNo').focus();">2. Drop exam for</option><?php
								}?>
								<option value="3" onclick="_('id_no').value=1;_('reg_courses').innerHTML='';_('uvApplicationNo').focus();">3. Drop courses for</option>
								<option value="" disabled="disabled"></option>
								
								<!--<option value="4" onclick="_('act_reson').style.display='block'">4. Block for</option>
								<option value="5" onclick="_('act_reson').style.display='block'">5. Unblock for</option>
								<option value="6" onclick="_('id_no').value=0;_('uvApplicationNo').focus();_('act_reson').style.display='block'">6. Release form for</option>-->
								
								<option value="4" onclick="_('id_no').value=0;_('uvApplicationNo').focus();">4. Show matric. no. for</option>
								<option value="" disabled="disabled"></option>
								<option value="5" onclick="_('id_no').focus();">5. Change programme</option><?php
								if ($orgsetins['studycenter'] == '1' && (!is_bool(strpos($userInfo['study_mode_ID'], 'topup')) || !is_bool(strpos($userInfo['study_mode_ID'], 'odl'))))
								{?>
								<option value="6" onclick="_('id_no').focus();">6. Change study centre</option><?php
								}?>
								<option value="" disabled="disabled"></option>
								<!--<option value="7" onclick="_('id_no').value=1;_('uvApplicationNo').focus();" disabled="disabled">7. Change semester</option>-->
								<option value="7" onclick="_('id_no').value=1;_('uvApplicationNo').focus();">7. Change level</option>
								<option value="8" onclick="_('id_no').value=1;_('uvApplicationNo').focus();">8. Reset passport upload</option>
							</select>
							<select name="id_no" id="id_no" class="select" 
							onchange="if(_('whattodo').value==2||_('whattodo').value==3||_('whattodo').value==9){this.value=1}
							if(_('whattodo').value==4){this.value=0}
							tidy_screen();">
								<option value="0">Application form number</option>
								<option value="1">Matriculation number</option>
							</select><?php
						}?>
					</div>
					<div class="div_select" style="margin-top:0px">
						<input name="uvApplicationNo" id="uvApplicationNo" type="text"  
                            maxlength="25"
                            class="textbox"
							onchange="this.value=this.value.trim();
							this.value=this.value.toUpperCase();
							tidy_screen();
							rt_scrn_clr();
							reg_grp1_loc.tabno.value='0';
							_('cover_tab').style.display='none';
							_('ans1').style.display='none';
							_('ans2').style.display='none';
							_('ans3').style.display='none';
							_('ans4').style.display='none';" 
							value="<?php if (isset($_REQUEST['save_cf']) && $_REQUEST['save_cf'] == '1'){echo $_REQUEST['uvApplicationNo'];}?>"/>
					</div>
					<div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
				</div>
			</form><?php

			if (($mm == 8 && $cEduCtgId == 'PGZ' && $cEduCtgId == 'PRX') || ($mm == 1 && !($cEduCtgId == 'PGZ' && $cEduCtgId == 'PRX')))
			{?>
				<div class="innercont_stff" id="enq_ans_div" style="display:<?php if ($staff_can_access == 1 && isset($_REQUEST['save_cf'])&&$_REQUEST['save_cf']=='1'&&$mode_match=='1'){?>block<?php }else{?>none<?php }?>;">
					<div id="cover_tab" class="frm_element_tab_cover frm_element_tab_cover_std">
						<a href="#" onclick="tab_modify('1')">
							<div id="tabss1" class="tabss tabss_std" style=" border-bottom:1px solid #FFFFFF;">
								Biodata
							</div>
						</a>
						<a href="#" onclick="tab_modify('2')">
							<div id="tabss2" class="tabss tabss_std">
								Postal Address
							</div>
						</a>
						<a href="#" onclick="tab_modify('3')">
							<div id="tabss3" class="tabss tabss_std">
								Residential Address
							</div>
						</a>
						<a href="#" onclick="tab_modify('4')">
							<div id="tabss4" class="tabss tabss_std">
								Next of kin
							</div>
						</a>
						<!-- <a id="tabss5" href="#" onclick="m_frm.uvApplicationNo.value=_('vApplicationNo1').value;m_frm.submit()">
							<input type="button" value="Print" class="basic_three_stff_bck_btns" 
							style="float:right; width:80px; margin-top:-1px; padding:10px; margin-right:-1px;"/>
						</a> -->
					</div>
				</div><?php
				if ($staff_can_access == 0 && isset($_REQUEST['save_cf']) && $_REQUEST['save_cf'] == '1')
				{?>
					<div class="succ_box blink_text orange_msg" style="margin-top:20px; width:auto;display:block">Porcess aborted.<br>
						Student study centre does not match that of staff that is logged in</div><?php
				}else
				{
					$src_table = '';
					$bio_data= '';						
					
					if (isset($_REQUEST['id_no']))
					{
						if ($_REQUEST['id_no'] == '0')
						{
							$stmt = $mysqli->prepare("SELECT vApplicationNo, vLastName, vFirstName, vOtherName, cGender, dBirthDate, cMaritalStatusId, cDisabilityId, cHomeCountryId, cHomeStateId, cHomeLGAId, vHomeCityName
							FROM pers_info
							WHERE vApplicationNo = ?");
							$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($vApplicationNo1, $vLastName_su1, $vFirstName_su1, $vOtherName_su1, $cGender_su1, $dBirthDate_su1, $cMaritalStatusId_su1, $cDisabilityId_su1, $cHomeCountryId_su1, $cHomeStateId_su1, $cHomeLGAId_su1, $vHomeCityName_su1);
							$stmt->fetch();
							
							$stmt = $mysqli->prepare("SELECT cPostalCountryId, cPostalStateId, cPostalLGAId, vPostalCityName, vPostalAddress, vEMailId, vMobileNo 
							FROM post_addr
							WHERE vApplicationNo = ?");
							$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($cPostalCountryId_su1, $cPostalStateId_su1, $cPostalLGAId_su1, $vPostalCityName_su1, $vPostalAddress_su1, $vEMailId_su1, $vMobileNo_su1);
							$stmt->fetch();

							$stmt = $mysqli->prepare("SELECT cResidenceCountryId, cResidenceStateId, cResidenceLGAId, vResidenceCityName, vResidenceAddress
							FROM res_addr 
							WHERE vApplicationNo = ?");
							$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($cResidenceCountryId_su1, $cResidenceStateId_su1, $cResidenceLGAId_su1, $vResidenceCityName_su1, $vResidenceAddress_su1);
							$stmt->fetch();

							$stmt = $mysqli->prepare("SELECT vNOKName, cNOKType, sponsor, vNOKAddress, vNOKEMailId, vNOKMobileNo, vNOKName1, cNOKType1, sponsor1, vNOKAddress1, vNOKEMailId1, vNOKMobileNo1, sponsor2 
							FROM nextofkin
							WHERE vApplicationNo = ?");
							$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($vNOKName_su1, $cNOKType_su1, $sponsor_su1, $vNOKAddress_su1, $vNOKEMailId_su1, $vNOKMobileNo_su1, $vNOKName1_su1, $cNOKType1_su1, $sponsor1_su1, $vNOKAddress1_su1, $vNOKEMailId1_su1, $vNOKMobileNo1_su1, $sponsor2_su1);
							$stmt->fetch();

							// $stmt = $mysqli->prepare("SELECT b.vApplicationNo, vLastName, vFirstName, vOtherName, cGender, dBirthDate, cMaritalStatusId, cDisabilityId, cHomeCountryId, cHomeStateId, cHomeLGAId, vHomeCityName, cPostalCountryId, cPostalStateId, cPostalLGAId, vPostalCityName, vPostalAddress, vEMailId, vMobileNo, cResidenceCountryId, cResidenceStateId, cResidenceLGAId, vResidenceCityName, vResidenceAddress, vNOKName, cNOKType, sponsor, vNOKAddress, vNOKEMailId, vNOKMobileNo, vNOKName1, cNOKType1, sponsor1, vNOKAddress1, vNOKEMailId1, vNOKMobileNo1, sponsor2 
							// FROM pers_info a, post_addr b, res_addr c, nextofkin d
							// WHERE a.vApplicationNo = b.vApplicationNo 
							// and a.vApplicationNo = c.vApplicationNo  
							// and a.vApplicationNo = d.vApplicationNo 
							// and a.vApplicationNo = ?");
							//$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
						}else
						{							
							$stmt = $mysqli->prepare("SELECT b.vApplicationNo, vLastName, vFirstName, vOtherName, cGender, dBirthDate, cMaritalStatusId, cDisabilityId, cHomeCountryId, cHomeStateId, cHomeLGAId, vHomeCityName, cPostalCountryId, cPostalStateId, cPostalLGAId, vPostalCityName, vPostalAddress, vEMailId, vMobileNo, cResidenceCountryId, cResidenceStateId, cResidenceLGAId, vResidenceCityName, vResidenceAddress, vNOKName, cNOKType, sponsor, vNOKAddress, vNOKEMailId, vNOKMobileNo, vNOKName1, cNOKType1, sponsor1, vNOKAddress1, vNOKEMailId1, vNOKMobileNo1, sponsor2 
							FROM s_m_t a, afnmatric b 
							WHERE a.vMatricNo = b.vMatricNo and (b.vMatricNo = ? or b.vApplicationNo = ?)");
							$stmt->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST['uvApplicationNo']);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($vApplicationNo1, $vLastName_su1, $vFirstName_su1, $vOtherName_su1, $cGender_su1, $dBirthDate_su1, $cMaritalStatusId_su1, $cDisabilityId_su1, $cHomeCountryId_su1, $cHomeStateId_su1, $cHomeLGAId_su1, $vHomeCityName_su1, $cPostalCountryId_su1, $cPostalStateId_su1, $cPostalLGAId_su1, $vPostalCityName_su1, $vPostalAddress_su1, $vEMailId_su1, $vMobileNo_su1, $cResidenceCountryId_su1, $cResidenceStateId_su1, $cResidenceLGAId_su1, $vResidenceCityName_su1, $vResidenceAddress_su1, $vNOKName_su1, $cNOKType_su1, $sponsor_su1, $vNOKAddress_su1, $vNOKEMailId_su1, $vNOKMobileNo_su1, $vNOKName1_su1, $cNOKType1_su1, $sponsor1_su1, $vNOKAddress1_su1, $vNOKEMailId1_su1, $vNOKMobileNo1_su1, $sponsor2_su1);
							$stmt->fetch();
						}
					}else
					{
						$stmt = $mysqli->prepare("SELECT b.vApplicationNo, vLastName, vFirstName, vOtherName, cGender, dBirthDate, cMaritalStatusId, cDisabilityId, cHomeCountryId, cHomeStateId, cHomeLGAId, vHomeCityName, cPostalCountryId, cPostalStateId, cPostalLGAId, vPostalCityName, vPostalAddress, vEMailId, vMobileNo, cResidenceCountryId, cResidenceStateId, cResidenceLGAId, vResidenceCityName, vResidenceAddress, vNOKName, cNOKType, sponsor, vNOKAddress, vNOKEMailId, vNOKMobileNo, vNOKName1, cNOKType1, sponsor1, vNOKAddress1, vNOKEMailId1, vNOKMobileNo1, sponsor2 
						FROM s_m_t a, afnmatric b 
						WHERE a.vMatricNo = b.vMatricNo and (b.vMatricNo = ? or b.vApplicationNo = ?)");
						$stmt->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST['uvApplicationNo']);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($vApplicationNo1, $vLastName_su1, $vFirstName_su1, $vOtherName_su1, $cGender_su1, $dBirthDate_su1, $cMaritalStatusId_su1, $cDisabilityId_su1, $cHomeCountryId_su1, $cHomeStateId_su1, $cHomeLGAId_su1, $vHomeCityName_su1, $cPostalCountryId_su1, $cPostalStateId_su1, $cPostalLGAId_su1, $vPostalCityName_su1, $vPostalAddress_su1, $vEMailId_su1, $vMobileNo_su1, $cResidenceCountryId_su1, $cResidenceStateId_su1, $cResidenceLGAId_su1, $vResidenceCityName_su1, $vResidenceAddress_su1, $vNOKName_su1, $cNOKType_su1, $sponsor_su1, $vNOKAddress_su1, $vNOKEMailId_su1, $vNOKMobileNo_su1, $vNOKName1_su1, $cNOKType1_su1, $sponsor1_su1, $vNOKAddress1_su1, $vNOKEMailId1_su1, $vNOKMobileNo1_su1, $sponsor2_su1);
						$stmt->fetch();
					}

					if (is_null($vResidenceCityName_su1))
					{
						$vResidenceCityName_su1 = '';
					}
					// $stmt->execute();
					// $stmt->store_result();
					// $stmt->bind_result($vApplicationNo1, $vLastName_su1, $vFirstName_su1, $vOtherName_su1, $cGender_su1, $dBirthDate_su1, $cMaritalStatusId_su1, $cDisabilityId_su1, $cHomeCountryId_su1, $cHomeStateId_su1, $cHomeLGAId_su1, $vHomeCityName_su1, $cPostalCountryId_su1, $cPostalStateId_su1, $cPostalLGAId_su1, $vPostalCityName_su1, $vPostalAddress_su1, $vEMailId_su1, $vMobileNo_su1, $cResidenceCountryId_su1, $cResidenceStateId_su1, $cResidenceLGAId_su1, $vResidenceCityName_su1, $vResidenceAddress_su1, $vNOKName_su1, $cNOKType_su1, $sponsor_su1, $vNOKAddress_su1, $vNOKEMailId_su1, $vNOKMobileNo_su1, $vNOKName1_su1, $cNOKType1_su1, $sponsor1_su1, $vNOKAddress1_su1, $vNOKEMailId1_su1, $vNOKMobileNo1_su1, $sponsor2_su1);
					// $stmt->fetch();
					$stmt->close();
												
					if (is_null($vLastName_su1))
					{
						$vLastName_su1 = '';
					}
					
					if (is_null($vFirstName_su1))
					{
						$vFirstName_su1 = '';
					}
					
					if (is_null($vOtherName_su1))
					{
						$vOtherName_su1 = '';
					}
					
					if (is_null($vPostalAddress_su1))
					{
						$vPostalAddress_su1 = '';
					}
					
					if (is_null($vResidenceAddress_su1))
					{
						$vResidenceAddress_su1 = '';
					}?>
				
					<div class="innercont_stff_tabs" id="ans1" style="display:<?php if (isset($_REQUEST['save_cf'])&&$_REQUEST['save_cf']=='1'&&$mode_match=='1'){?>block<?php }else{?>none<?php }?>; height:78%; overflow:auto;">
						<div class="innercont_stff">
							<div class="labell" style="width:180px;" style="width:180px;">
								Surname
							</div>
							<div class="div_select">
								<input name="vLastName" id="vLastName" type="text" class="textbox" 
								style="text-transform:uppercase" value="<?php echo stripslashes($vLastName_su1);?>" 
								onchange="if (this.value.trim()!='')
								{
									this.value=this.value.trim();
									this.value=this.value.toUpperCase();
								}" />
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg1"></div>
						</div>
						<div class="innercont_stff">
							<div class="labell" style="width:180px;" style="width:180px;">
								First name
							</div>
							<div class="div_select">
								<input name="vFirstName" id="vFirstName" type="text" class="textbox" 
								value="<?php echo stripslashes($vFirstName_su1);?>" 
								onchange="if (this.value.trim()!='')
								{
									this.value=this.value.trim();
									this.value=capitalizeEachWord(this.value);
								}" />
								<input name="vApplicationNo1" id="vApplicationNo1" type="hidden" value="<?php echo $vApplicationNo1;?>" />
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg2"></div>
						</div>
						<div class="innercont_stff">
							<div class="labell" style="width:180px;" style="width:180px;">
								Other names
							</div>
							<div class="div_select">
								<input name="vOtherName" id="vOtherName" type="text" class="textbox" 
								value="<?php echo stripslashes($vOtherName_su1);?>" 
								onchange="if (this.value.trim()!='')
								{
									this.value=this.value.trim();
									this.value=capitalizeEachWord(this.value);
								}" />
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg3"></div>
						</div>

						<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.8px; margin-top:10px; margin-bottom:10px;" />

						<div class="innercont_stff">
							<div class="labell" style="width:180px;" style="width:180px;">
								Gender
							</div>
							<div class="div_select">
								<select name="cGender" id="cGender" class="select">
									<option value="" selected="selected"></option>
									<option value="M"<?php if ($cGender_su1 == 'M'){echo ' selected="selected"';}?>>Male</option>
									<option value="F"<?php if ($cGender_su1 == 'F'){echo ' selected="selected"';}?>>Female</option>
								</select>
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg4"></div>
						</div>
						<div class="innercont_stff">
							<div class="labell" style="width:180px;" style="width:180px;">
								Date of birth
							</div>
							<div class="div_select">
								<input type="date" name="dBirthDate" id="dBirthDate" class="textbox" style="height:99%; width:99%" value="<?php echo $dBirthDate_su1;?>"
								onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg5"></div>
						</div>
						<div class="innercont_stff">
							<div class="labell" style="width:180px;" style="width:180px;">
								Marital status
							</div>
							<div class="div_select"><?php
								$sql1 = "select cMaritalStatusId,vMaritalStatusDesc from maritalstatus ";
								$rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
								<select name="cMaritalStatusId" id="cMaritalStatusId" class="select">
									<option value="" selected="selected"></option><?php
									while ($table = mysqli_fetch_array($rsql1))
									{?>
										<option value="<?php echo $table["cMaritalStatusId"]?>"<?php if ($cMaritalStatusId_su1 == $table["cMaritalStatusId"]){echo ' selected';}?>><?php echo ucwords (strtolower($table["vMaritalStatusDesc"]))?></option><?php
									}
									mysqli_close(link_connect_db());?>
								</select>
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg6"></div>
						</div>
						<div class="innercont_stff">
							<div class="labell" style="width:180px;" style="width:180px;">
								Physical challenge
							</div>
							<div class="div_select"><?php
							$sql1="select cDisabilityId, vDisabilityDesc from disability";
							$rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
							<select name="cDisabilityId" id="cDisabilityId" class="select">
								<option value="" selected="selected" > </option><?php
								while ($table = mysqli_fetch_array($rsql1))
								{	?>
									<option value="<?php echo $table["cDisabilityId"]?>"
									<?php if ($cDisabilityId_su1 == $table["cDisabilityId"]){echo ' selected';}?>> <?php echo ucwords (strtolower($table["vDisabilityDesc"]))?> </option><?php
								}
								mysqli_close(link_connect_db());?>
							</select>
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg7"></div>
						</div>
						<div class="innercont_stff">
							<label for="sbtd_pix" class="labell" style="width:180px;" style="width:180px;">Upload passport picture<font color="#FF0000">*</font></label>
							<div class="div_select">
								<!-- <input type="file" name="sbtd_pix" id="sbtd_pix" style="display: inline-block;
								cursor: pointer;"> -->

								<input type="file" name="sbtd_pix" id="sbtd_pix" title="Max size: 50KB, Format: JPG">
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg8"></div>
						</div>

						<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.8px; margin-top:10px; margin-bottom:10px;" />
													
						<div class="innercont_stff">
							<label for="cHomeCountryId" class="labell" style="width:180px;" style="width:180px;">Nationality<font color="#FF0000">*</font></label>
							<div class="div_select"><?php
								$sql1="select cCountryId, vCountryName from country order by vCountryName";
								$rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
								<select name="cHomeCountryId" id="cHomeCountryId" class="select" 
									onchange="update_cat_country('cHomeCountryId', 'State_readup', 'cHomeStateId', 'cHomeLGAId');">
									<option value="" selected></option><?php
									$fnd = '';
									while ($table=mysqli_fetch_array($rsql1))
									{?>
										<option value="<?php echo $table["cCountryId"]?>"<?php if ($cHomeCountryId_su1 == $table["cCountryId"]){echo ' selected';}?>>
										<?php echo ucwords (strtolower($table["vCountryName"]))?>
										</option><?php
									}
									mysqli_close(link_connect_db());?>
									<option value="99" <?php if (isset($_REQUEST['cHomeCountryId']) && $_REQUEST['cHomeCountryId'] == "99"){echo ' selected';}?>>Other Country</option>
								</select>
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg9"></div>
						</div>
						<div class="innercont_stff">
							<label for="cHomeStateId" class="labell" style="width:180px;" style="width:180px;">State of origin<font color="#FF0000">*</font></label>								
							<div class="div_select" id="div_select"><?php
								if ($cHomeCountryId_su1 == 'NG')
								{
									$sql1 = "select cStateId,vStateName from ng_state where cCountryId = '".$cHomeCountryId_su1."' order by vStateName";
								}else
								{
									$sql1 = "select cStateId,vStateName from ng_state where cCountryId = '99' order by vStateName";
								}
								$rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
								<select name="cHomeStateId" id="cHomeStateId" class="select" 
									onchange="update_cat_country('cHomeStateId', 'LGA_readup', 'cHomeLGAId', 'cHomeLGAId');">
									<option value="" selected ></option><?php
									while ($table=mysqli_fetch_array($rsql1))
									{?>
										<option value="<?php echo $table["cStateId"]?>"<?php 
											if ($cHomeStateId_su1 == $table["cStateId"]){echo ' selected';}?>> 
											<?php echo ucwords (strtolower ($table["vStateName"]))?> 
										</option><?php
									}
									mysqli_close(link_connect_db());?>
								</select>
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg10"></div>
						</div>
						<div class="innercont_stff">
							<label for="cHomeLGAId" class="labell" style="width:180px;" style="width:180px;">Local govt. area of origin<font color="#FF0000">*</font></label>
							<div class="div_select" id="lgalst"><?php
								if ($cHomeStateId_su1 <> '')
								{
									if ($cHomeStateId_su1 <> '99')
									{
										$sql1 = "select b.cLGAId,b.vLGADesc from localarea b, ng_state c
										where b.cStateId = c.cStateId and c.cStateId = '".$cHomeStateId_su1."' order by b.vLGADesc";
									}else
									{
										$sql1 = "select cLGAId,vLGADesc from localarea where cStateId = '99' order by vLGADesc";
									}
								}
									
							$rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
							<select name="cHomeLGAId" id="cHomeLGAId" onchange="frm_upd.value=''" class="select">
								<option value="" selected ></option><?php
								while ($table=mysqli_fetch_array($rsql1))
								{
									if (isset($table["cLGAId"]))
									{?>
										<option value="<?php echo $table["cLGAId"]?>"<?php if (($cHomeLGAId_su1 == $table["cLGAId"]) || ($cHomeStateId_su1 == '' && $table["cLGAId"] == '9999')){echo ' selected';}?>> <?php echo ucwords (strtolower ($table["vLGADesc"]))?> </option><?php
									}
								}
								mysqli_close(link_connect_db());?>
							</select>
						</div>
						<div class="labell_msg blink_text orange_msg" id="labell_msg11"></div>
					</div>
					<div class="innercont_stff">
						<label for="vHomeCityName" class="labell" style="width:180px;" style="width:180px;">Home town</label>
						<div class="div_select">
							<input name="vHomeCityName" id="vHomeCityName" type="text" class="textbox" value="<?php if (isset($vHomeCityName_su1) && $vHomeCityName_su1 <> ''){echo stripslashes($vHomeCityName_su1);}?>" />
						</div>
						<div class="labell_msg blink_text orange_msg" id="labell_msg12"></div>
					</div>
				</div>
				
					<div class="innercont_stff_tabs" id="ans2" style="height:395px;">
						<div class="innercont_stff">
							<label for="cPostalCountryId" class="labell" style="width:180px;" style="width:180px;">Country<font color="#FF0000">*</font></label>
							<div class="div_select"><?php
								$sqlcCountryId="select cCountryId, vCountryName from country order by vCountryName";
								$rsqlcCountryId=mysqli_query(link_connect_db(), $sqlcCountryId)or die("cannot query the table".mysqli_error(link_connect_db()));?>
								<select name="cPostalCountryId" id="cPostalCountryId" 
									onchange="update_cat_country('cPostalCountryId', 'State_readup', 'cPostalStateId', 'cPostalLGAId');
									/*frm_upd.value=1;
									statelst('cPostalCountryId');*/" class="select">
									<option selected="selected" ></option><?php
									while ($table=mysqli_fetch_array($rsqlcCountryId))
									{?>
										<option value="<?php echo $table["cCountryId"]?>"<?php if ($cPostalCountryId_su1 == $table["cCountryId"])
										{echo ' selected';} ?>> <?php echo ucwords (strtolower ($table["vCountryName"]))?> </option>
										<?php
									}
									mysqli_close(link_connect_db());?>
								</select>
							</div> 
							<div class="labell_msg blink_text orange_msg" id="labell_msg16"></div>
						</div>
						<div class="innercont_stff">
							<label for="cPostalStateId" class="labell" style="width:180px;" style="width:180px;">State<font color="#FF0000">*</font></label>
							<div class="div_select"><?php
								if ($cPostalCountryId_su1 == 'NG')
								{
									$sql1 = "select cStateId,vStateName from ng_state where cCountryId = '".$cPostalCountryId_su1."' order by vStateName";
								}else
								{
									$sql1 = "select cStateId,vStateName from ng_state where cCountryId = 'xx' order by vStateName";
								}
								$rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
								<select name="cPostalStateId" id="cPostalStateId" 
									onchange="update_cat_country('cPostalStateId', 'LGA_readup', 'cPostalLGAId', 'cPostalLGAId');
									/*frm_upd.value=2;
									lgalst('cPostalStateId');*/" class="select">
									<option value="" selected></option><?php
									while ($table=mysqli_fetch_array($rsql1))
									{?>
										<option value="<?php echo $table["cStateId"]?>"<?php if ($cPostalStateId_su1 == $table["cStateId"])
											{echo ' selected';} ?>><?php echo ucwords (strtolower ($table["vStateName"]))?></option>
										<?php
									}
									mysqli_close(link_connect_db());?>
								</select>
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg17"></div>
						</div>
						<div class="innercont_stff">
							<label for="cPostalLGAId" class="labell" style="width:180px;" style="width:180px;">Local govt. area of origin<font color="#FF0000">*</font></label>
							<div class="div_select"><?php
								if ($cPostalStateId_su1 <> '')
								{
									if ($cPostalStateId_su1 <> '99')
									{
										$sql1 = "select b.cLGAId,b.vLGADesc
										from localarea b, ng_state c
										where b.cStateId = c.cStateId and c.cStateId = '".$cPostalStateId_su1."' order by b.vLGADesc";
									}else
									{
										$sql1 = "select cLGAId,vLGADesc from localarea where cStateId = '99' order by vLGADesc";
									}
								}
								$rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
								<select name="cPostalLGAId" id="cPostalLGAId" onchange="frm_upd.value=''" class="select">
									<option value="" selected ></option><?php
									while ($table=mysqli_fetch_array($rsql1))
									{
										if (isset($table["cLGAId"]))
										{?>
											<option value="<?php echo $table["cLGAId"]?>"<?php if (($cPostalLGAId_su1 == $table["cLGAId"]) || ($cPostalStateId_su1 == '99' && $table["cLGAId"] == '9999')){echo ' selected';}?>> <?php echo ucwords (strtolower ($table["vLGADesc"]))?> </option><?php
										}
									}
									mysqli_close(link_connect_db());?>
								</select>
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg18"></div>
						</div>
						<div class="innercont_stff">
							<label for="vPostalCityName" class="labell" style="width:180px;" style="width:180px;">Town</label>
							<div class="div_select">
								<input name="vPostalCityName" id="vPostalCityName" type="text" class="textbox" value="<?php if ($vPostalCityName_su1 <> ''){echo stripslashes($vPostalCityName_su1);}?>" />
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg19"></div>
						</div>
						<div class="innercont_stff">
							<label for="vPostalAddress" class="labell" style="width:180px;" style="width:180px;">P.O.B./Street address</label>
							<div class="div_select">
								<input name="vPostalAddress" id="vPostalAddress" type="text" class="textbox" 
									onchange="this.value=this.value.toLowerCase(); 
									this.value=capitalizeEachWord(this.value)" 
									value="<?php echo stripslashes($vPostalAddress_su1); ?>" />
							</div> 
							<div class="labell_msg blink_text orange_msg" id="labell_msg20"></div>
						</div>
						<div class="stat_noti_box">
							eMail address must be <b>functional</b> otherwise, you may miss vital pieces of information from the university.
						</div>
						<div class="innercont_stff">
							<label for="vEMailId" class="labell" style="width:180px;" style="width:180px;">eMail address<font color="#FF0000">*</font></label>
							<div class="div_select">
									<input name="vEMailId" id="vEMailId" type="text" class="textbox" style="text-transform:none" value="<?php  echo $vEMailId_su1;?>" />
								<input name="frm_upd2" type="hidden" />
								<input name="chng_cntry" type="hidden" />
								<input name="chng_state" type="hidden" />
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg21"></div>
						</div>
						<div class="innercont_stff">
							<label for="vMobileNo" class="labell" style="width:180px;" style="width:180px;">Mobile phone number<font color="#FF0000">*</font></label>
							<div class="div_select">
									<input name="vMobileNo" id="vMobileNo" type="number" class="textbox" style="text-transform:none" value="<?php  echo $vMobileNo_su1;?>" />
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg22"></div>
						</div>
					</div>
					
					<div class="innercont_stff_tabs" id="ans3" style="height:395px;">
						<div class="innercont_stff">
							<label for="cResidenceCountryId" class="labell" style="width:180px;" style="width:180px;">Country<font color="#FF0000">*</font></label>
							<div class="div_select"><?php
								$rsql1=mysqli_query(link_connect_db(), "select cCountryId, vCountryName from country order by vCountryName")or die("cannot query the table".mysqli_error(link_connect_db()));?>
								<select name="cResidenceCountryId" id="cResidenceCountryId" class="select" 
									onchange="update_cat_country('cResidenceCountryId', 'State_readup', 'cResidenceStateId', 'cResidenceLGAId');;
									/*frm_upd.value=3;
									statelst('cResidenceCountryId');*/">
									<option selected="selected" ></option><?php
									while ($table=mysqli_fetch_array($rsql1))
									{?>
										<option value="<?php echo $table["cCountryId"]?>"<?php if ($cResidenceCountryId_su1 == $table["cCountryId"]){echo ' selected';}?>> <?php echo ucwords (strtolower ($table["vCountryName"]))?> </option>
										<?php
									}
									mysqli_close(link_connect_db());?>
									</select>
							</div> 
							<div class="labell_msg blink_text orange_msg" id="labell_msg27"></div>
						</div>
						<div class="innercont_stff">
							<label for="cResidenceStateId" class="labell" style="width:180px;" style="width:180px;">State<font color="#FF0000">*</font></label>
							<div class="div_select"><?php
								if ($cResidenceCountryId_su1 == 'NG')
								{
									$sql2 = "select cStateId,vStateName from ng_state where cCountryId = '".$cResidenceCountryId_su1."' order by vStateName";
								}else
								{
									$sql2 = "select cStateId,vStateName from ng_state where cCountryId = 'XX' order by vStateName";
								}
								$rsql2 = mysqli_query(link_connect_db(), $sql2)or die("cannot query the table".mysqli_error(link_connect_db()));?>
								<select name="cResidenceStateId" id="cResidenceStateId" class="select" 
									onchange="update_cat_country('cResidenceStateId', 'LGA_readup', 'cResidenceLGAId', 'cResidenceLGAId');
									/*frm_upd.value=4;
									lgalst('cResidenceStateId');*/">
									<option value="" selected></option><?php
									while ($table=mysqli_fetch_array($rsql2))
									{?>
										<option value="<?php echo $table["cStateId"]?>"<?php if ($cResidenceStateId_su1 == $table["cStateId"])
											{echo ' selected';} ?>><?php echo ucwords (strtolower ($table["vStateName"]))?></option>
										<?php
									}
									mysqli_close(link_connect_db());?>
								</select>
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg28"></div>
						</div>
						<div class="innercont_stff">
							<label for="cResidenceLGAId" class="labell" style="width:180px;" style="width:180px;">Local govt. area of origin<font color="#FF0000">*</font></label>
							<div class="div_select"><?php
								if ($cResidenceStateId_su1 <> '99')
								{
									$sql1 = "select b.cLGAId,b.vLGADesc
									from localarea b, ng_state c
									where b.cStateId = c.cStateId and c.cStateId = '".$cResidenceStateId_su1."' order by b.vLGADesc";
								}else
								{
									$sql1 = "select cLGAId,vLGADesc from localarea where cStateId = '99' order by vLGADesc";
								}
								$rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
								<select name="cResidenceLGAId" id="cResidenceLGAId" class="select" onchange="frm_upd.value=''">
									<option value="" selected="selected"></option><?php
									while ($table=mysqli_fetch_array($rsql1))
									{?>
										<option value="<?php echo $table["cLGAId"]?>" <?php if (($cResidenceLGAId_su1 == $table["cLGAId"]) || ($cResidenceStateId_su1 == '' && $table["cLGAId"] == '9999')){echo ' selected';}?>><?php echo ucwords (strtolower($table["vLGADesc"]))?></option><?php
									}
									mysqli_close(link_connect_db());?>
								</select>
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg29"></div>
						</div>
						<div class="innercont_stff">
							<label for="cHomeStateId" class="labell" style="width:180px;" style="width:180px;">Town</label>
							<div class="div_select">
								<input name="vResidenceCityName" id="vResidenceCityName" type="text" class="textbox" 
								onblur="this.value=capitalizeEachWord(this.value)" value="<?php echo stripslashes($vResidenceCityName_su1);?>" />
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg30"></div>
						</div>
						<div class="innercont_stff">
							<label for="vResidenceAddress" class="labell" style="width:180px;" style="width:180px;">Street address<font color="#FF0000">*</font></label>
							<div class="div_select">
								<input name="vResidenceAddress" id="vResidenceAddress" type="text" class="textbox"  onblur="this.value=capitalizeEachWord(this.value)" value="<?php echo stripslashes($vResidenceAddress_su1); ?>" />
							</div> 
							<div class="labell_msg blink_text orange_msg" id="labell_msg31"></div>
						</div>
					</div>
					
					<div class="innercont_stff_tabs" id="ans4" style="height:80%; overflow:auto">
						<div class="innercont_stff">
							<label for="vNOKName" class="labell" style="width:180px;" style="width:180px;">Name<font color="#FF0000">*</font></label>
							<div class="div_select">
								<input name="vNOKName" id="vNOKName" type="text" class="textbox" value="<?php echo $vNOKName_su1;?>" onblur="this.value=capitalizeEachWord(this.value)" />
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg32"></div>
						</div>

						<div class="innercont_stff">
							<label for="cNOKType" class="labell" style="width:180px;" style="width:180px;">Relationship<font color="#FF0000">*</font></label>
							<div class="div_select"><?php
								$sql1="select cNOKType, vNOKTypeDesc from noktype order by vNOKTypeDesc";
								$rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
								<select name="cNOKType" id="cNOKType" class="select">
									<option value="" selected="selected" ></option><?php
										while ($table=mysqli_fetch_array($rsql1))
										{?>
											<option value="<?php echo $table["cNOKType"]?>"<?php if ($cNOKType_su1 == $table["cNOKType"])
											{echo ' selected';} ?>> <?php echo ucwords (strtolower($table["vNOKTypeDesc"]))?> </option><?php
										}
										mysqli_close(link_connect_db());?>
								</select>
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg33"></div>
						</div>

						<div class="innercont_stff">
							<div class="innercont" style="width:166px; float:left; height:19px; margin-right:10px; text-align:right;">
								<input name="sponsor" id="sponsor" style="margin-right:0px" 
								onclick="if(this.checked){this.value=1}else{this.value=0}"
								value="<?php echo $sponsor_su1; ?>" <?php if ($sponsor_su1=='1'){echo 'checked';} ?> type="checkbox"/>
							</div>							
							<div class="innercont" style="width:auto; height:16px; float:left; padding-top:3px">
								<label for="sponsor">
									Sponsor
								</label>
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg34"></div>
						</div>

						<div class="innercont_stff" style="height:85px;">
							<label for="vNOKAddress" class="labell" style="width:180px;" style="width:180px;">Address<font color="#FF0000">*</font></label>
							<div class="div_select" style="height:100%">
								<textarea rows="5" cols="30" 
								style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; height:92%; width:98%" name="vNOKAddress" id="vNOKAddress" 
								onblur="this.value=capitalizeEachWord(this.value)"><?php echo $vNOKAddress_su1;?></textarea>
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg35"></div>
						</div>
						
						<div class="innercont_stff">
							<label for="vNOKEMailId" class="labell" style="width:180px;" style="width:180px;">eMail Address<font color="#FF0000">*</font></label>
							<div class="div_select">
								<input name="vNOKEMailId" id="vNOKEMailId" type="text" class="textbox" style="text-transform:none" value="<?php echo $vNOKEMailId_su1;?>" />
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg36"></div>
						</div>
						
						<div class="innercont_stff">
							<label for="vNOKMobileNo" class="labell" style="width:180px;">Mobile Phone<font color="#FF0000">*</font></label>
							<div class="div_select">
								<input name="vNOKMobileNo" id="vNOKMobileNo" type="number" class="textbox" style="text-transform:none" value="<?php echo $vNOKMobileNo_su1;?>" />
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg37"></div>
						</div>

						<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.8px; margin-top:10px; margin-bottom:4px;" />

						<div class="innercont_stff" style="margin-top:10px;">
							<label for="vNOKName1" class="labell" style="width:180px;">Name<font color="#FF0000">*</font></label>
							<div class="div_select">
								<input name="vNOKName1" id="vNOKName1" type="text" class="textbox" value="<?php echo $vNOKName1_su1;?>" onblur="this.value=capitalizeEachWord(this.value)" />
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg38"></div>
						</div>
						<div class="innercont_stff">
							<label for="cNOKType1" class="labell" style="width:180px;">Relationship<font color="#FF0000">*</font></label>
							<div class="div_select"><?php
								$sql1="select cNOKType, vNOKTypeDesc from noktype order by vNOKTypeDesc";
								$rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
								<select name="cNOKType1" id="cNOKType1" class="select">
									<option value="" selected="selected" ></option><?php
										while ($table=mysqli_fetch_array($rsql1))
										{?>
											<option value="<?php echo $table["cNOKType"]?>"<?php if ($cNOKType1_su1 == $table["cNOKType"])
											{echo ' selected';} ?>> <?php echo ucwords (strtolower($table["vNOKTypeDesc"]))?> </option><?php
										}
										mysqli_close(link_connect_db());?>
								</select>
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg39"></div>
						</div>

						<div class="innercont_stff">
							<div class="innercont" style="width:166px; float:left; height:19px; margin-right:10px; text-align:right;">
								<input name="sponsor1" id="sponsor1" style="margin-right:0px" 
								onclick="if(this.checked){this.value=1}else{this.value=0}"
								value="<?php echo $sponsor1_su1; ?>" <?php if ($sponsor1_su1=='1'){echo 'checked';} ?> type="checkbox"/>
							</div>
							<div class="innercont" style="width:auto; height:16px; float:left; padding-top:3px">
								<label for="sponsor1">
									Sponsor
								</label>
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg40"></div>
						</div>
						<div class="innercont_stff" style="height:85px;">
							<label for="vNOKAddress1" class="labell" style="width:180px;">Address<font color="#FF0000">*</font></label>
							<div class="div_select" style="width:220px; height:80px">
								<textarea rows="5" cols="30" 
								style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; width:218px" name="vNOKAddress1" id="vNOKAddress1" 
								onblur="this.value=capitalizeEachWord(this.value)"><?php echo $vNOKAddress1_su1;?></textarea>
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg41"></div>
						</div>
						<div class="innercont_stff">
							<label for="vNOKEMailId1" class="labell" style="width:180px;">eMail Address<font color="#FF0000">*</font></label>
							<div class="div_select">
								<input name="vNOKEMailId1" id="vNOKEMailId1" type="text" class="textbox" style="text-transform:none" value="<?php echo $vNOKEMailId1_su1;?>" />
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg42"></div>
						</div>

						<div class="innercont_stff">
							<label for="vNOKMobileNo1" class="labell" style="width:180px;">Mobile Phone<font color="#FF0000">*</font></label>
							<div class="div_select">
								<input name="vNOKMobileNo1" id="vNOKMobileNo1" type="number" class="textbox" style="text-transform:none" value="<?php echo $vNOKMobileNo1_su1;?>" />
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg43"></div>
						</div>
						

						<div class="innercont_stff" style="margin-top:15px">
							<div class="innercont" style="width:166px; float:left; height:19px; margin-right:10px; text-align:right;">
								<input name="sponsor2" id="sponsor2" style="margin-right:0px" 
								onclick="if(this.checked){this.value=1}else{this.value=0}"
								value="<?php echo $sponsor2_su1; ?>" <?php if ($sponsor2_su1=='1'){echo 'checked';} ?> type="checkbox"/>
							</div>
							<div class="innercont" style="width:auto; height:16px; float:left; padding-top:3px">
								<label for="sponsor2">
									Self sponsor
								</label>
							</div>
							<div class="labell_msg blink_text orange_msg" id="labell_msg44"></div>
						</div>
					</div>
					
					<div class="innercont_stff_tabs" id="ans5" style="border:0px; margin-left:1px; height:395px;">
						<div class="innercont_stff" style="margin-top:0px; height:24px; font-weight:bold;margin-left:-1px">
							<div class="ctabletd_1" style="width:29px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; border-radius: 4px 0px 0px 0px;">Sno</div>
							<div class="ctabletd_1" style="width:83px; background-color:#E3EBE2; border:1px solid #A7BAAD;  text-align:left;">Course Code</div>
							<div class="ctabletd_1" style="width:404px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Course Title</div>								
							<div class="ctabletd_1" style="width:47px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center;">Status</div>
							
							<div class="ctabletd_1" style="width:70px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Credit Unit</div>
							
							<div class="ctabletd_1" style="width:69px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;border-radius: 0px 4px 0px 0px;">Fee</div>
						</div>
						<ul id="reg_courses" class="checklist cl1" style="margin-left:-1px"></ul>
					</div>
					
					<div class="innercont_stff_tabs" id="ans6" style="border:0px; height:auto; margin-left:1px;">
						<div class="innercont_stff" style="margin-bottom:-1px">
							<div id="div_lab_a" class="div_label">
								Matriculation number
							</div>
							<div id="div_a" class="div_valu"></div>	
						</div>
						<div class="innercont_stff">
							<div class="div_label">
								Name
							</div>
							<div id="div_0" class="div_valu"></div>	
						</div><?php
						if ($orgsetins['studycenter'] == '1')
						{?>
						<div class="innercont_stff">
							<div class="div_label">
								Study centre
							</div>
							<div id="div_1" class="div_valu"></div>	
						</div><?php
						}?>
						<div class="innercont_stff">
							<div class="div_label">
								Faculty
							</div>
							<div id="div_2"  class="div_valu"></div>	
						</div>
						<div class="innercont_stff">
							<div class="div_label">
								Department
							</div>
							<div id="div_3"  class="div_valu"></div>	
						</div>
						<div class="innercont_stff">
							<div class="div_label">
								Programme
							</div>
							<div id="div_4"  class="div_valu"></div>	
						</div>
						<div class="innercont_stff">
							<div class="div_label">
								Level/Semester
							</div>
							<div id="div_5"  class="div_valu"></div>	
						</div>
					</div>
					
					<div class="innercont_stff_tabs" id="ans7" style="border:0px; height:auto; margin-bottom:25px; margin-left:1px;">	
						<div id="cFacultyIdold_div" class="innercont_stff" style="margin-top:10px">
							<div class="div_label">
								Faculty
							</div>
							<div class="div_valu" style="width:345px">
								<select name="cFacultyIdold" id="cFacultyIdold" class="select" onchange="updateScrn('f')">
									<option value="" selected="selected"></option><?php
                                	$faculty = '';
                                	if (isset($_REQUEST["cFacultyIdold"])){$faculty = $_REQUEST["cFacultyIdold"];}
                                	get_faculties($faculty);?>
								</select>
							</div>
							<div id="labell_msg35" class="labell_msg blink_text orange_msg"></div>
						</div>
						
						<div id="cdeptold_div" class="innercont_stff">
							<div class="div_label">
								Department
							</div>
							<div class="div_valu" style="width:345px">
								<select name="cdeptold" id="cdeptold" class="select" onchange="updateScrn('d')">
									<option value="" selected="selected"></option>
								</select>
							</div>
							<div id="labell_msg36" class="labell_msg blink_text orange_msg"></div>
						</div>
						
						<div id="cprogrammeIdold_div" class="innercont_stff">
							<div class="div_label">
								Programme
							</div>
							<div class="div_valu" style="width:345px">
								<select name="cprogrammeIdold" id="cprogrammeIdold" class="select">
									<option value="" selected="selected"></option>
								</select>
							</div>
							<div id="labell_msg37" class="labell_msg blink_text orange_msg"></div>
						</div>
						
						
						<div id="courseLevel_div" class="innercont_stff" style="margin-bottom:5px">
							<div class="div_label">
								Level
							</div>
							<div class="div_valu" style="width:305px">
								<select name="courseLevel" id="courseLevel" class="select" style="width:auto">
									<option value="" selected="selected"></option>
									<option value="10">10</option>
									<option value="20">20</option>
									<option value="30">30</option>
									<option value="40">40</option><?php
									for ($t = 100; $t <= 900; $t+=100)
									{?>
										<option value="<?php echo $t ?>"><?php echo $t;?></option><?php
									}?>
								</select>
							</div>
							<div id="labell_msg38" class="labell_msg blink_text orange_msg" style="width:268px;"></div>
						</div>
					</div>
					
					<div class="innercont_stff_tabs" id="ans8" style="border:0px; height:auto; margin-bottom:30px; margin-left:1px;">	
						<div id="cFacultyIdold_div" class="innercont_stff" style="margin-top:10px">
							<div class="div_label">
								Study centre
							</div>
							<div class="div_valu" style="width:345px"><?php
								$sql1 = "select cStudyCenterId, vCityName from studycenter order by vCityName";
								$rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
								
								<select name="cStudyCenterIdold" id="cStudyCenterIdold" class="select">
									<option value="" selected="selected"></option><?php
									while ($table= mysqli_fetch_array($rsql1))
									{?>
										<option value="<?php echo $table[0] ?>"<?php 
										if ((isset($_REQUEST['cStudyCenterId']) && $table[0] == strtoupper($_REQUEST['cStudyCenterId'])) || (isset($_REQUEST['cFacultyIdold']) && $table[0] == $_REQUEST['cFacultyIdold'])){echo ' selected';}?>>
											<?php echo $table[1];?>
										</option><?php
									}
									mysqli_close(link_connect_db());?>
								</select>
							</div>
							<div id="labell_msg39" class="labell_msg blink_text orange_msg"></div>
						</div>
					</div>
					
					<div class="innercont_stff_tabs" id="ans9" style="border:0px; height:auto; margin-bottom:25px; margin-left:1px;">	
						<div id="courseLevel_div" class="innercont_stff" style="margin-bottom:25px">
							<div class="div_label">
								Semester
							</div>
							<div class="div_valu" style="width:345px">
								<select name="tSemester" id="tSemester" class="select" style="width:auto" 
									onchange="if(_('whattodo').value == 7 && _('id_no').value == 0){this.value=1;}">
									<option value="" selected="selected"></option>
									<option value="1">1</option>
									<option value="2">2</option>
								</select>
							</div>
							<div id="labell_msg40" class="labell_msg blink_text orange_msg"></div>
						</div>
					</div>
					
					<div class="innercont_stff_tabs" id="ans10" style="border:0px; height:auto; margin-bottom:25px; margin-left:1px;">	
						<div id="courseLevel_div" class="innercont_stff" style="margin-bottom:5px">
							<div class="div_label">
								Level
							</div>
							<div class="div_valu" style="width:305px">
								<select name="courseLevel_2" id="courseLevel_2" class="select" style="width:auto">
									<option value="" selected="selected"></option>
									<option value="10">10</option>
									<option value="20">20</option>
									<option value="30">30</option>
									<option value="40">40</option><?php
									for ($t = 100; $t <= 900; $t+=100)
									{?>
										<option value="<?php echo $t ?>"><?php echo $t;?></option><?php
									}?>
								</select>
							</div>
							<div id="labell_msg41" class="labell_msg blink_text orange_msg" style="width:268px;"></div>
						</div>
					</div>
					<div id="succ_boxu" class="succ_box blink_text orange_msg" style="width:auto;"></div><?php
					
					/*if ($mode_match<>'1' && $study_mode_su <> '' && isset($_REQUEST['uvApplicationNo']) && $_REQUEST['uvApplicationNo'] <> '')
					{
						if (substr(trim($study_mode_su), 0, 3) == 'odl'){$study_mode_su = 'DLI';}?>
						<div class="stat_noti_box orange_msg" style="width:270px; margin-top:150px; margin-left:245px; padding:10px">Mode mismatch, Please direct candidate/student to the <?php echo strtoupper($study_mode_su);?> section</div><?php
					}*/
				}
			}else
			{
				if (isset($_REQUEST["id_no"]))
				{
					if ($_REQUEST["id_no"] == '0')
					{
						$ref_name_0 = 'Application form number';
						$ref_name = 'candidate';
					}else
					{
						$ref_name_0 = 'Matriculaton number';
						$ref_name = 'student';
					}

					
					if ($mm == 8 && $cEduCtgId <> 'PGZ' && $cEduCtgId <> 'PRX')
					{
						caution_box($ref_name_0. ' must be that of an M. Phil. or Ph.D. '.$ref_name);
					}else if ($mm == 1 && ($cEduCtgId == 'PGZ' || $cEduCtgId == 'PRX'))
					{
						caution_box($ref_name_0.' must be that of an undergraduate, PGD or Masters '.$ref_name);
					}else if ($sRoleID_u == 29 && isset($_REQUEST["cProgrammeId"]) && is_bool(strpos($cProgrammeId, 'CHD')))
					{
						caution_box($ref_name_0." must be that of a certificate $ref_name in CHRD");
					}else if ($sRoleID_u == 26 && isset($_REQUEST["cProgrammeId"]) && is_bool(strpos($cProgrammeId, 'DEG')))
					{
						caution_box($ref_name_0." must be that of a certificate $ref_name in DE&GS");
					}
				}
			}?>
				<!-- </form> -->
			<!--</div>
			 </div> -->
		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;">
			<div id="pp_box">
                <img name="passprt" id="passprt" src="<?php echo get_pp_pix(''); ?>" width="95%" height="185" style="margin:0px;<?php if ($currency <> '1' ){?>opacity:0.3;<?php }?>"/>
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
<!-- InstanceEnd --></html>