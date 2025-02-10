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
require_once('staff_detail.php');


function confirm_role($sample_role)
{
    $mysqli = link_connect_db();
    
    $stmt = $mysqli->prepare("SELECT * FROM role_user where vUserId = ? AND sRoleID = '$sample_role'");
    $stmt->bind_param("s",$_REQUEST["exist_user"]);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0)
    {
        return ' selected';
    }else
    {
        return '';
    }
}?>

<!-- InstanceBeginEditable name="doctitle" -->
<title>NOUN-MIS</title>
<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
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
        var formdata = new FormData();
        
        var files = _("sbtd_pix").files;
        var letters = /^[A-Za-z ]+$/;
        
        var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
        for (j = 0; j <= ulChildNodes.length-1; j++)
        {
            ulChildNodes[j].style.display = 'none';
        }

        _('manag_loc').save.value = -1;
        
        if (_("roles").style.display == 'block')
        {
            if (_("whattodo").value == '')
            {
                setMsgBox("labell_msg1","");
                _("whattodo").focus();
                return false;
            }
            
            if (_("whattodo").value == '0')
            {
                if (trim(_("new_role_name").value) == '')
                {
                    setMsgBox("labell_msg4","");
                    _("new_role_name").focus();
                    return false;
                }
                
                if (!_("new_role_name").value.match(letters))
                {
                    setMsgBox("labell_msg4","Only letters are allowed");
                    _("new_role_name").focus();
                    return false;
                }
                formdata.append("new_role_name", _('manag_loc').new_role_name.value);
            }else if (_("whattodo").value == '1')
            {
                if(manag_loc.whattodo.value=='1'||manag_loc.whattodo.value=='2'||manag_loc.whattodo.value=='3')
                {
                    if (_("exist_role_one").value == '')
                    {
                        setMsgBox("labell_msg3","");
                        _("exist_role_one").focus();
                        return false;
                    }
                }
                
                if (trim(_("new_role_name").value) == '')
                {
                    setMsgBox("labell_msg4","");
                    _("new_role_name").focus();
                    return false;
                }
                
                if (!_("new_role_name").value.match(letters))
                {
                    setMsgBox("labell_msg4","Only letters are allowed");
                    _("new_role_name").focus();
                    return false;
                }
                
                formdata.append("exist_role_one", _('exist_role_one').value);
                formdata.append("new_role_name", _('manag_loc').new_role_name.value);				
            }else if (_("whattodo").value == '2' || _("whattodo").value == '3')
            {
                if (_("exist_role_one").value == '')
                {
                    setMsgBox("labell_msg3","");
                    _("exist_role_one").focus();
                    return false;
                }

                formdata.append("exist_role_one", _('exist_role_one').value);
                
                var foundchecked = 0;
                for (j = 1; j <= _('number_perms').value; j++)
                {
                    var chk_box = 'perm_chk'+j;

                    if (_(chk_box) && _(chk_box).checked)
                    {
                        foundchecked = 1;
                        formdata.append(_(chk_box).id, _(chk_box).id);
                    }
                }  
            
                if (foundchecked == 0)
                {
                    if (_("whattodo").value == '2')
                    {
                        caution_box('Please check relevant permission boxes before you click the submission button');
                    }else if (_("whattodo").value == '3' &&  _('manag_loc').conf.value != '1')
                    {
                        caution_box('There are no permissions to revoke');
                    }
                    return false;
                }
                formdata.append("number_perms", _('number_perms').value);

                if (_("whattodo").value == '3' &&  _('manag_loc').conf.value != '1')
                {
                    _("conf_msg_msg_loc").innerHTML = 'Are you sure about this ?';
        
                    _('conf_box_loc').style.display = 'block';
                    _('conf_box_loc').style.zIndex = '3';
                    _('smke_screen_2').style.display = 'block';
                    _('smke_screen_2').style.zIndex = '2';
                    return false;
                }
            }else if (_("whattodo").value == '4' || _("whattodo").value == '5')
            {
                if (_("exist_user").value == '')
                {
                    setMsgBox("labell_msg2","");
                    _("exist_user").focus();
                    return false;
                }
                                
                formdata.append("exist_user", _('manag_loc').exist_user.value);
                
                var option_sel = 0;
                if (_("whattodo").value == '4')
                {
                    for (var i = 0; i < _("exist_role1").length; i++)
                    {
                        if (_("exist_role1").options[i].selected)
                        {
                            formdata.append("exist_role1[]", _("exist_role1").options[i].value);
                            var option_sel = 1;
                        }
                    }

                    if (option_sel == 0)
                    {
                        setMsgBox("labell_msg3","");
                        _("exist_role1").focus();
                        return false;
                    }
                }
            }else if (_("whattodo").value == '6')
            {
                if (_("exist_role_one").value == '')
                {
                    setMsgBox("labell_msg3","");
                    _("exist_role_one").focus();
                    return false;
                }
                
                if (_('manag_loc').conf.value != '1')
                {
                    _("conf_msg_msg_loc").innerHTML = 'Are you sure about this ?';
        
                    _('conf_box_loc').style.display = 'block';
                    _('conf_box_loc').style.zIndex = '3';
                    _('smke_screen_2').style.display = 'block';
                    _('smke_screen_2').style.zIndex = '2';
                    return false;
                }
                formdata.append("exist_role_one", _('exist_role_one').value);
                formdata.append("conf", _('manag_loc').conf.value);
            }
            formdata.append("whattodo", manag_loc.whattodo.value);
        }else if (_("users").style.display == 'block')
        {
            if (_("whattodo1").value != '1' && _("exist_user1").value == '')
            {
                setMsgBox("labell_msg17","");
                _("exist_user1").focus();
                return false;
            }
            
            if (_("whattodo1").value == '1' || _("whattodo1").value == '2')
            {
                if (_("exist_user1"))
                {
                    if (_("exist_user1").style.display == 'block' && _("exist_user1").value == '')
                    {
                        setMsgBox("labell_msg17","");
                        _("exist_user1").focus();
                        return false;
                    }
                }
                
                if (trim(_('manag_loc').uvApplicationNo.value) == '')
                {
                    setMsgBox("labell_msg19","");
                    _("uvApplicationNo").focus();
                    return false;
                }
                
                if (trim(_("vLastName").value) == '')
                {
                    setMsgBox("labell_msg20","");
                    _("vLastName").focus();
                    return false;
                }
                
                if (!_("vLastName").value.match(letters))
                {
                    setMsgBox("labell_msg20","Only letters are allowed");
                    _("vLastName").focus();
                    return false;
                }
                
                
                if (trim(_("vFirstName").value) == '')
                {
                    setMsgBox("labell_msg21","");
                    _("vFirstName").focus();
                    return false;
                }
                                
                if (!_("vFirstName").value.match(letters))
                {
                    setMsgBox("labell_msg21","Only letters are allowed");
                    _("vFirstName").focus();
                    return false;
                }
                
                
                if (_("vOtherName").value != '' && !_("vOtherName").value.match(letters))
                {
                    setMsgBox("labell_msg22","Only letters are allowed");
                    _("vOtherName").focus();
                    return false;
                }                
                
                if(_("cphone").value == '')
                {
                    setMsgBox("labell_msg23",'');
                    _("cphone").focus();
                    return false;
                }
                
                if(_("cemail").value == '')
                {
                    setMsgBox("labell_msg24",'');
                    _("cemail").focus();
                    return false;
                }
                
                if (chk_mail(_("cemail")) != '')
                {
                    setMsgBox("labell_msg24",chk_mail(_("cemail")));
                    _("cemail").focus();
                    return false;
                }
                
                if (_("whattodo1").value == '2' || _('passpotLoaded').value == '0' || _('passpotLoaded').value == '')
                {
                    if (_('passpotLoaded').value != 1 && _("sbtd_pix").files.length == 0)
                    {
                        setMsgBox("labell_msg24a","");
                        return false;
                    }else if (_('passpotLoaded').value != 1 && !fileValidation("sbtd_pix"))
                    {
                        setMsgBox("labell_msg24a","JPEG required");
                        return false;
                    }else if (_('passpotLoaded').value != 1 && files[0].size > 100000)
                    {
                        setMsgBox("labell_msg24a","File too large. Max: 50KB");
                        return false;
                    }

                    formdata.append("sbtd_pix", _("sbtd_pix").files[0]);
                }

                var option_selected = '';
                for (var i = 0; i < _('manag_loc').staff_study_center.length; i++)
                {
                    if (_('manag_loc').staff_study_center.options[i].selected && _('manag_loc').staff_study_center.options[i].value != '')
                    {
                        formdata.append("staff_study_center[]", _('manag_loc').staff_study_center.options[i].value);
                        option_selected = 1;
                    }
                }
                
                if (option_selected == '')
                {
                    setMsgBox("labell_msg29","");
                    _('manag_loc').staff_study_center.focus();
                    return false;
                }

                if (_("staff_cat").value == '')
                {
                    setMsgBox("labell_msg31","");
                    _('manag_loc').staff_cat.focus();
                    return false;
                }

                if (_("for_ts").style.display == 'block')
                {
                    if (_('manag_loc').cFacultyId72.value == '')
                    {
                        setMsgBox("labell_msg26","");
                        _('manag_loc').cFacultyId72.focus();
                        return false;
                    }
                }

                

                if (_("for_nts").style.display == 'block')
                {
                    if (_('manag_loc').cFacultyId72_nts.value == '')
                    {
                        setMsgBox("labell_msg32","");
                        _('manag_loc').cFacultyId72_nts.focus();
                        return false;
                    }
                }


                
                if (_('manag_loc').cdept72.value == '')
                {
                    setMsgBox("labell_msg27","");
                    _('manag_loc').cdept72.focus();
                    return false;
                }                  
                
                    
                // var option_selected = '';
                // for (var i = 0; i < _('manag_loc').cprogrammeId72.length; i++)
                // { 
                //     if (_('manag_loc').cprogrammeId72.options[i].selected && _('manag_loc').cprogrammeId72.options[i].value != '')
                //     {
                //         option_selected = 1;
                //         break;
                //     }
                // }
                
                formdata.append("exist_user1", _('manag_loc').exist_user1.value);
                formdata.append("uvApplicationNo", _('manag_loc').uvApplicationNo.value);
                
                if (_("whattodo1").value == '1' || _("whattodo1").value == '2')
                {
                    formdata.append("vLastName", _('manag_loc').vLastName.value.trim());
                    formdata.append("vFirstName", _('manag_loc').vFirstName.value.trim());
                    formdata.append("vOtherName", _('manag_loc').vOtherName.value.trim());
                }
                
                formdata.append("cphone", _('manag_loc').cphone.value.trim());
                formdata.append("cemail", _('manag_loc').cemail.value.trim());                

                if (_("for_ts").style.display == 'block')
                {
                    formdata.append("cFacultyId", _('manag_loc').cFacultyId72.value);
                }else 
                if (_("for_nts").style.display == 'block')
                {
                    formdata.append("cFacultyId", _('manag_loc').cFacultyId72_nts.value);
                }

                
                formdata.append("cdept", _('manag_loc').cdept72.value);
                
                if (_('tech_support').checked)
                {
                    formdata.append("tech_support", '1');
                }else
                {
                    formdata.append("tech_support", '0');
                }
                
                formdata.append("staff_cat", _('staff_cat').value);
            }else if (_("whattodo1").value == '3' || _("whattodo1").value == '4')
            {
                if (_('manag_loc').conf.value != '1')
                {
                    _("conf_msg_msg_loc").innerHTML = 'Are you sure about this ?';
            
                    _('conf_box_loc').style.display = 'block';
                    _('conf_box_loc').style.zIndex = '3';
                    _('smke_screen_2').style.display = 'block';
                    _('smke_screen_2').style.zIndex = '2';
                    return false;
                }
                
                formdata.append("exist_user1", _('manag_loc').exist_user1.value);
            }

            
            formdata.append("whattodo1", _('whattodo1').value);
        }
                
        _('manag_loc').save.value = '1';
        formdata.append("save", _('manag_loc').save.value);
        
        formdata.append("ilin", _('manag_loc').ilin.value);
        formdata.append("currency", _('manag_loc').currency.value);

        formdata.append("user_cat", _('manag_loc').user_cat.value);
        formdata.append("vApplicationNo", _('manag_loc').vApplicationNo.value);
        formdata.append("mm", _('manag_loc').mm.value);
        formdata.append("sm", _('manag_loc').sm.value);
        
        opr_prep(ajax = new XMLHttpRequest(),formdata);
    }
    
    
    function opr_prep(ajax,formdata)
    {
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        
        ajax.open("POST", "opr_manag.php");
        ajax.send(formdata);
    }


    function completeHandler(event)
    {
        on_error('0');
        on_abort('0');
        in_progress('0');
        var returnedStr = event.target.responseText;
       
        var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
        for (j = 0; j <= ulChildNodes.length-1; j++)
        {
            ulChildNodes[j].style.display = 'none';
        }
        
        if (returnedStr.indexOf("successful") == -1)
        {
            if (returnedStr.indexOf("?") != -1 && _('manag_loc').conf.value == '') 
            {
                _("conf_msg_msg_loc").innerHTML = returnedStr;
                
                _('conf_box_loc').style.display = 'block';
                _('conf_box_loc').style.zIndex = '3';
                _('smke_screen_2').style.display = 'block';
                _('smke_screen_2').style.zIndex = '2';
            }else if (_('update_frm').value == '1' && (_("whattodo1").value == '0' || _("whattodo1").value == '2'))
            {
                if (_('manag_loc').getDptProg.value == 1)
                {
                    _('manag_loc').uvApplicationNo.value = _('manag_loc').exist_user1.value;
                    
                    
                    /*if (_("whattodo1").value == '2')
                    {
                        _('manag_loc').vLastName.disabled = true;
                        _('manag_loc').vFirstName.disabled = true;
                        _('manag_loc').vOtherName.disabled = true;
                    }else
                    {*/
                        _('manag_loc').vLastName.disabled = false;
                        _('manag_loc').vFirstName.disabled = false;
                        _('manag_loc').vOtherName.disabled = false;
                    //}
                    
                    _('role_desc_lbl').value = returnedStr.substr(0,100).trim();
                    
                    _('manag_loc').vLastName.value = returnedStr.substr(100,100).trim();
                    _('manag_loc').vFirstName.value = returnedStr.substr(200,100).trim();
                    _('manag_loc').vOtherName.value = returnedStr.substr(300,100).trim();
                    
                    _('manag_loc').cphone.value = returnedStr.substr(400,100).trim();
                    _('manag_loc').cemail.value = returnedStr.substr(500,100).trim();
                    
                    var user_centre = returnedStr.substr(600,1000).trim();
                    
                    for ( var i = 0; i <= _('manag_loc').staff_study_center.options.length-1; i++ )
                    {
                        _('manag_loc').staff_study_center.options[i].selected = false;
                        strVal = _('manag_loc').staff_study_center.options[i].value;
                        if (strVal != '' && user_centre.indexOf(strVal) > -1)
                        {
                            _('manag_loc').staff_study_center.options[i].selected = true;
                        }
                    }
                    
                    _('staff_cat').value = returnedStr.substr(1600,100).trim();

                    if(_('staff_cat').value=='0')
                    {
                        _("for_nts").style.display='block';
                        _("for_ts").style.display='none';

                       _('manag_loc').cFacultyId72_nts.value = returnedStr.substr(1700,100).trim();
                        
                        _('cdept72').length = 0;
                        _('cdept72').options[_('cdept72').options.length] = new Option('Not applicable', 'NA');
                        _('cdept72').value='NA';
                    }else
                    {
                        _("for_nts").style.display='none';
                        _("for_ts").style.display='block';

                        _('manag_loc').cFacultyId72.value = returnedStr.substr(1700,100).trim();
                        
                        update_cat_country('cFacultyId72', 'cdeptId_readup', 'cdept72', 'cdept72');
                        _('manag_loc').cdept72.value = returnedStr.substr(1800,100).trim();
                        _('manag_loc').dptmnt.value = returnedStr.substr(1800,100).trim();
                    }
                    
                    _('tech_support').checked = false;
                    if (returnedStr.substr(1900,100).trim() == '1')
                    {
                        _('tech_support').checked = true;
                    }
                    
                    index_of_ash = returnedStr.indexOf("#")+1;
                    mask = returnedStr.substr(index_of_ash).trim();
                    
                    _('passpotLoaded').value = '0';
                    if (mask != '')
                    {
                        _('passpotLoaded').value = '1';
                    }

                    _("passprt").src = mask;
                    _("passprt").onerror = function() {myFunction()};

                    function myFunction()
                    {
                        _("passprt").src = 'img/p_.png';
                    }

                }else if (_('manag_loc').getDptProg.value == 'dept')
                {
                    _('manag_loc').cdept72.options.length = 0;
                    _('manag_loc').cdept72.options[_('manag_loc').cdept72.options.length] = new Option('', '');
                    
                    _('manag_loc').cprogrammeId72.options.length = 0;
                    _('manag_loc').cprogrammeId72.options[_('manag_loc').cprogrammeId72.options.length] = new Option('', '');
                    
                    var comaFound = 0; semicol = 0;  dolarFound = 0; cProgId = ''; cProgdesc = '';
                    for (i = 0; i <= returnedStr.length-1; i++)
                    {
                        if (returnedStr.charAt(i) == '%'){semicol = 1;}
                        if (returnedStr.charAt(i) == '+'){comaFound = 1;}
                        if (returnedStr.charAt(i) == '$'){dolarFound = 1;}
                        
                        if ((i == 0 || comaFound == 0) && returnedStr.charAt(i) != '$')
                        {
                            cProgId = cProgId + returnedStr.charAt(i);
                        }else if (comaFound == 1 && semicol == 0 && returnedStr.charAt(i) != '+')
                        {
                            cProgdesc = cProgdesc + returnedStr.charAt(i);
                        }else if (semicol == 1)
                        {
                            if (dolarFound == 0)
                            {
                                _('manag_loc').cdept72.options[_('manag_loc').cdept72.options.length] = new Option(cProgdesc, cProgId);
                            }
                            cProgId = ''; cProgdesc = ''; semicol = 0; comaFound = 0
                        }
                    }
                    _('manag_loc').cdept72.value = _('manag_loc').dptmnt.value;
                    
                    _('manag_loc').getDptProg.value = 'prog';

                    var formdata = new FormData();
                        
                    formdata.append("frm_upd", 'd');
                    formdata.append("cdeptold", _('manag_loc').cdept72.value);
                    opr_prep1(ajax = new XMLHttpRequest(),formdata);
                }else if (_('manag_loc').getDptProg.value == 'prog')
                {					
                    _('manag_loc').getDptProg.value == '';
                    _('update_frm').value = '';
                }
            }else if (_('update_frm').value == '2' && _("whattodo1").value != '1')
            {
                _("exist_user1").options.length = 0;
                _("exist_user1").options[_("exist_user1").options.length] = new Option('', '');
                
                var plusFound = ''; comaFound = ''; cProgId = ''; cProgdesc = '';
                for (i = 0; i <= returnedStr.length-1; i++)
                {
                    if (returnedStr.charAt(i) == '+'){plusFound = 1;}
                    if (returnedStr.charAt(i) == ','){comaFound = 1;}
                    
                    if (i == 0 || plusFound == 0)
                    {
                        cProgId = cProgId + returnedStr.charAt(i);
                    }else if (returnedStr.charAt(i) != '+' && returnedStr.charAt(i) != ',')
                    {
                        cProgdesc = cProgdesc + returnedStr.charAt(i);
                    }else if (comaFound == 1 && cProgdesc != '' && cProgId != '')
                    {
                        _("exist_user1").options[_("exist_user1").options.length] = new Option(cProgdesc, cProgId);
                        cProgId = ''; cProgdesc = ''; plusFound = 0; comaFound = 0
                    }

                    if (_("exist_user1").options.length%11==0)
                    {
                        _("exist_user1").options[_("exist_user1").options.length] = new Option("", "");
                    }

                    if (_("exist_user1").options.length-1 > 0 && _("exist_user1").options[_("exist_user1").options.length-1].value == '')
                    {
                        _("exist_user1").options[_("exist_user1").options.length-1].disabled = true;
                    }
                }
                _('update_frm').value = '';
                _("exist_user_div1").style.display = 'block';
            }else if (_('update_frm').value == '3' && (_("whattodo").value == '2' || _("whattodo").value == '3' || _("whattodo").value == '4' || _("whattodo").value == '6' || _("whattodo").value == '8'))
            {
                if (_("whattodo").value == '4' || _("whattodo").value == '6')
                {
                    caution_box(returnedStr);
                }else
                {
                    var splitStr = returnedStr.split(',');

                    //var check_valu = '';
                    for (j = 1; j <= _('number_perms').value; j++)
                    {
                        var chk_box = 'perm_chk'+j;

                        if (_(chk_box))
                        {
                            _(chk_box).checked = false;
                            if (splitStr.indexOf(_(chk_box).value) != -1)
                            {
                                _(chk_box).checked = true;
                            }
                        }
                    }
                }            
                _('update_frm').value = '';
            }else if (_('update_frm').value == '4' && (_("whattodo1").value == '3' || _("whattodo1").value == '4'))
            {
                /*if (_('manag_loc').sm.value == '2' && (_("whattodo1").value == '3' || _("whattodo1").value == '4'))
                {
                    for (j = 0; j <= _("exist_role1").length-1; j++){_("exist_role1").options[j].selected = false;}
                    
                    str = '';
                    for (i = 0; i <= returnedStr.length-1; i++)
                    {
                        if (returnedStr.charAt(i) == ',')
                        {
                            for (j = 0; j <= _("exist_role1").length-1; j++)
                            {
                                if (_("exist_role1").options[j].value == str)
                                {
                                    _("exist_role1").options[j].selected = true; break;
                                }
                            }
                            str = '';
                        }else
                        {
                            str = str + returnedStr.charAt(i);
                        }
                    }
                }*/
                //_('update_frm').value = '';
                
                caution_box(returnedStr);
            }else if (_('update_frm').value == 'f' || _('update_frm').value == 'd')
            {
                if (_('update_frm').value == 'f')
                {
                    _('manag_loc').cdept72.options.length = 0;
                    _('manag_loc').cdept72.options[_('manag_loc').cdept72.options.length] = new Option('', '');
                    
                    _('manag_loc').cprogrammeId72.options.length = 0;
                    _('manag_loc').cprogrammeId72.options[_('manag_loc').cprogrammeId72.options.length] = new Option('', '');
                }else if (_('update_frm').value == 'd')
                {
                    _('manag_loc').cprogrammeId72.options.length = 0;
                    _('manag_loc').cprogrammeId72.options[_('manag_loc').cprogrammeId72.options.length] = new Option('', '');					
                }
                
                var comaFound = 0; semicol = 0;  dolarFound = 0; cProgId = ''; cProgdesc = '';
                for (i = 0; i <= returnedStr.length-1; i++)
                {
                    if (returnedStr.charAt(i) == '%'){semicol = 1;}
                    if (returnedStr.charAt(i) == '+'){comaFound = 1;}
                    if (returnedStr.charAt(i) == '$'){dolarFound = 1;}
                    
                    if ((i == 0 || comaFound == 0) && returnedStr.charAt(i) != '$')
                    {
                        cProgId = cProgId + returnedStr.charAt(i);
                    }else if (comaFound == 1 && semicol == 0 && returnedStr.charAt(i) != '+')
                    {
                        cProgdesc = cProgdesc + returnedStr.charAt(i);
                    }else if (semicol == 1)
                    {
                        if (_('update_frm').value == 'f')
                        {
                            if (dolarFound == 0)
                            {
                                _('manag_loc').cdept72.options[_('manag_loc').cdept72.options.length] = new Option(cProgdesc, cProgId);
                            }
                        }else if (_('update_frm').value == 'd')
                        {
                            if (dolarFound == 0)
                            {
                                _('manag_loc').cprogrammeId72.options[_('manag_loc').cprogrammeId72.options.length] = new Option(cProgdesc, cProgId);
                            }
                        }
                        cProgId = ''; cProgdesc = ''; semicol = 0; comaFound = 0
                    }
                }
                _('update_frm').value = '';
            }
        }else if (_('manag_loc').save.value == '1')
        {
            if (returnedStr.indexOf("successful") != -1)
            {
                if (_("roles").style.display == 'block')
                {
                    if (_("whattodo").value == '0')
                    {
                        success_box('Role created successfully');
                    }else if (_("whattodo").value == '1')
                    {
                        success_box('Role edited successfully');
                    }else if (_("whattodo").value == '2' || _("whattodo").value == '3')
                    {
                        success_box(returnedStr);
                    }else if (_("whattodo").value == '4')
                    {
                        success_box('Role(s) assigned successfully');
                    }else if (_("whattodo").value == '5' && _('manag_loc').conf.value == '1')
                    {
                        success_box(returnedStr);
                    }else if (_("whattodo").value == '6' && _('manag_loc').conf.value == '1')
                    {
                        success_box('Role deleted successfully');
                    }
                }else if (_("users").style.display == 'block')
                {
                    var mask = '';
                    if (returnedStr.indexOf("successful") != -1)
                    {
                        success_box(returnedStr.substr(12));
                        //success_box(returnedStr);
                    }else
                    {
                        caution_box(returnedStr);
                    }
                }
            }else
            {
                caution_box(returnedStr);
            }

            _('manag_loc').save.value == '';
        }
        _('manag_loc').conf.value = '';
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



    function updateScrn()
    {
        var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
        for (j = 0; j <= ulChildNodes.length-1; j++)
        {
            ulChildNodes[j].style.display = 'none';
        }
                
        _('role_desc_div').style.display = 'none';
        
        _('manag_loc').save.value = -1;
                
        _("exist_role_div").style.display = 'none';
        _("exist_role_one_div").style.display = 'none';		
        
        _("new_role_name_div").style.display = 'none';
        _("exist_user_div").style.display = 'none';
        
        _("exist_role_div1").style.display = 'none';
        _("new_user_name_div1").style.display = 'none';
        _("exist_user_div1").style.display = 'none';			
        
        _("perms").style.display = 'none';
        
        if (_("roles").style.display == 'block')
        {
            if (_('update_frm').value == '0' && _("whattodo").value != '0')
            {
                var formdata = new FormData();
                    
                formdata.append("whattodo", manag_loc.whattodo.value);
                formdata.append("update_frm", _('update_frm').value);
                
                opr_prep(ajax = new XMLHttpRequest(),formdata);
                _("new_user_name_div1").style.display = 'block';
            }
            
            if (_("whattodo").value == '0')
            {
                _("new_role_name_lab").innerHTML = 'Name of new role';
                _("new_role_name_div").style.display = 'block';
            }else if (_("whattodo").value == '1')
            {
                _("new_role_name_lab").innerHTML = 'New name of role';
                _('new_role_name').value = _('exist_role_one').options[_('exist_role_one').selectedIndex].text;
                
                _("exist_role_div").style.display = 'block';
                //_("exist_role_div").style.height = '23px';
                _("exist_role_one_div").style.display = 'block';
                
                _("new_role_name_div").style.display = 'block';
            }else if (_("whattodo").value == '2' || _("whattodo").value == '3' || _("whattodo").value == '8')
            {
                if (_("whattodo").value != '8')
                {
                    _("sub_box").style.display = 'block';
                }

                _("exist_role_div").style.display = 'block';
                _("exist_role_one_div").style.display = 'block';
                                
                if (_("exist_role_one").value != '')
                {
                    _("perms").style.display = 'block';
                }else
                {
                    _("perms").style.display = 'none';
                }
                
                
                var ulChildNodes = _("perms").getElementsByTagName("input");
                for (j = 0; j <= ulChildNodes.length-1; j++)
                {
                    if (ulChildNodes[j].offsetLeft > 0 && ulChildNodes[j].type == 'checkbox')
                    {
                        ulChildNodes[j].checked = false;
                    }
                }
                
                var formdata = new FormData();
                
                formdata.append("exist_role_one", _('exist_role_one').value);
                
                formdata.append("whattodo", manag_loc.whattodo.value);
                formdata.append("update_frm", _('update_frm').value);
                
                if (_('exist_role_one').value != '')
                {
                    opr_prep(ajax = new XMLHttpRequest(),formdata);
                }
            }else if (_("whattodo").value == '4' || _("whattodo").value == '5')
            {
                if (_('update_frm').value == '4')
                {
                    var formdata = new FormData();
                    
                    formdata.append("whattodo", manag_loc.whattodo.value);
                    formdata.append("exist_user", _('manag_loc').exist_user.value);
                    formdata.append("update_frm", _('update_frm').value);

                    if (_('manag_loc').exist_user.value != '')
                    {
                        opr_prep(ajax = new XMLHttpRequest(),formdata);
                    }
                }
                
                
                if ( _("whattodo").value != '5')
                {
                    _("exist_role_div").style.display = 'block';
                    //_("exist_role_div").style.height = '118px';
                    //_("exist_role_mult_div").style.display = 'block';
                }
                
                _("exist_user_div").style.display = 'block';
            }else if (_("whattodo").value == '6')
            {
                _("exist_role_div").style.display = 'block';
                //_("exist_role_div").style.height = '118px';
                _("exist_role_one_div").style.display = 'block';
                
            }
        }else if (_("users").style.display == 'block')
        {
            _('sub_box').style.display = 'block';
            
            if (_('update_frm').value == '2' && _("whattodo1").value != '1')
            {
                var formdata = new FormData();
                formdata.append("ilin", _('manag_loc').ilin.value);
                formdata.append("whattodo1", _('whattodo1').value);
                formdata.append("update_frm", _('update_frm').value);
                
                opr_prep(ajax = new XMLHttpRequest(),formdata);
            }
            
            if (_("whattodo1").value == '0' || _("whattodo1").value == '1' || _("whattodo1").value == '2')
            {
                _('manag_loc').uvApplicationNo.value = '';
                _('manag_loc').vLastName.value = '';
                _('manag_loc').vFirstName.value = '';
                _('manag_loc').vOtherName.value = '';
                _('manag_loc').cphone.value = '';
                _('manag_loc').cemail.value = '';
                _('manag_loc').cFacultyId72.value = '';
                _('manag_loc').cdept72.value = '';
                //_('manag_loc').study_mode72.value = '';
                //_('manag_loc').cprogrammeId72.options.length = 0;
                
                _("new_user_name_div1").style.display = 'block';
                
                /*if (_("whattodo1").value == '2')
                {
                    _('manag_loc').vLastName.disabled = true;
                    _('manag_loc').vFirstName.disabled = true;
                    _('manag_loc').vOtherName.disabled = true;
                }else
                {*/
                    _('manag_loc').vLastName.disabled = false;
                    _('manag_loc').vFirstName.disabled = false;
                    _('manag_loc').vOtherName.disabled = false;
                //}
            }
            
            if (_("whattodo1").value == '0' || _("whattodo1").value == '2')
            {
                if (_("whattodo1").value == '0')
                {
                    _('sub_box').style.display = 'none';
                }
                
                _("exist_user_div1").style.display = 'block';
                if (_('update_frm').value == '1')
                {
                    var formdata = new FormData();
                    formdata.append("ilin", _('manag_loc').ilin.value);
                    formdata.append("exist_user1", _('manag_loc').exist_user1.value);
                    formdata.append("update_frm", _('update_frm').value);
                    
                    opr_prep(ajax = new XMLHttpRequest(),formdata);
                }				
            }else if (_("whattodo1").value == '3' || _("whattodo1").value == '4')
            {
                if (_('update_frm').value == '4')
                {
                    var formdata = new FormData();
                    formdata.append("ilin", _('manag_loc').ilin.value);
                    formdata.append("whattodo1", _('whattodo1').value);
                    formdata.append("exist_user1", _('manag_loc').exist_user1.value);
                    formdata.append("update_frm", _('update_frm').value);

                    if (_('manag_loc').exist_user1.value != '')
                    {
                        opr_prep(ajax = new XMLHttpRequest(),formdata);
                    }
                }
                
                _("exist_role_div1").style.display = 'block';
                _("exist_user_div1").style.display = 'block';
            }else if (_("whattodo1").value == '5' || _("whattodo1").value == '6' || _("whattodo1").value == '7')
            {
                _("exist_user_div1").style.display = 'block';
            }
        }
    }
    
    
    function opr_prep1(ajax,formdata)
    {
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        
        ajax.open("POST", "opr_setup_facult.php");
        ajax.send(formdata);
    }

		
    function setupothers(val, strg)
    {
        //perm_chk number_perms
        for (j = 1; j <= _("number_perms").value; j++)
        {
            var perm_chk = 'perm_chk'+j;

            if (_(perm_chk))
            {
                _(perm_chk).checked = val;
            }
        }
        return;
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
	if ($currency <> '1')
	{?>
		<div id="smke_screen" class="smoke_scrn" style="display:block; z-index:2"></div>
		<div id="conf_warn" class="center" style="display:block; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:3">
			<div id="msg_title" style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
				Caution
			</div>
			<a href="#" style="text-decoration:none;">
				<div id="msg_title" style="width:20px; float:left; text-align:center; padding:0px;"></div>
			</a>
			<div id="msg_msg" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;">
				Time out. Click Ok to login and continue
			</div>
			<div id="msg_title" style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
				<a href="#" style="text-decoration:none;" 
					onclick="pass1.loggedout.value=1;in_progress('1');pass1.submit()
					return false">
					<div class="submit_button_green" style="width:60px; padding:6px; float:right">
						Ok
					</div>
				</a>
			</div>
		</div><?php
	};?>

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
			
			<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
            <div id="conf_box_loc" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
                <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                    Confirmation
                </div>
                <a href="#" style="text-decoration:none;">
                    <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
                </a>
                <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;"></div>
                <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
                    <a href="#" style="text-decoration:none;" 
                        onclick="_('conf_box_loc').style.display='none';
                        _('smke_screen_2').style.display='none';
                        _('smke_screen_2').style.zIndex='-1';
                        _('manag_loc').conf.value='1';
                        chk_inputs();
                        return false">
                        <div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
                            Yes
                        </div>
                    </a>

                    <a href="#" style="text-decoration:none;" 
                        onclick="_('manag_loc').conf.value='';
                        _('conf_box_loc').style.display='none';
                        _('smke_screen_2').style.display='none';
                        _('smke_screen_2').style.zIndex='-1';
                        return false">
                        <div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
                            No
                        </div>
                    </a>
                </div>
            </div>

            <div id="page_title" class="innercont_top"><?php
                
                if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] <> '')
                {
                    //echo $_REQUEST['whattodo'];
                    if ($_REQUEST['whattodo'] == '0')
                    {
                        echo 'Create role';
                    }else if ($_REQUEST['whattodo'] == '1')
                    {
                        echo 'Edit role';
                    }else if ($_REQUEST['whattodo'] == '2')
                    {
                        echo 'Assign permission to role';
                    }else if ($_REQUEST['whattodo'] == '3')
                    {
                        echo 'Revoke permission from role';
                    }else if ($_REQUEST['whattodo'] == '4')
                    {
                        echo 'Assign role to user';
                    }else if ($_REQUEST['whattodo'] == '6')
                    {
                        echo 'Delete role';
                    }else if ($_REQUEST['whattodo'] == '7')
                    {
                        echo 'See assigned role';
                    }else if ($_REQUEST['whattodo'] == '8')
                    {
                        echo 'See assigned permissions';
                    }
                }else if (isset($_REQUEST['sm']))
                {
                    if ($_REQUEST['sm'] == '1')
                    {
                        echo 'Role';
                    }else if ($_REQUEST['sm'] == '2')
                    {
                        echo 'User account';
                    }else if ($_REQUEST['sm'] == '3')
                    {
                        echo 'Reset password';
                    }else if ($_REQUEST['sm'] == '4')
                    {
                        echo 'Retreive password';
                    }
                }?>
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

            <div class="innercont_stf" id="user_account" 
				style="height:93%; 
				padding:0px; 
				display:block; 
				overflow:scroll; 
				overflow-x: hidden; 
				border:0px solid #ccc;">
                <form method="post" name="manag_loc" id="manag_loc" enctype="multipart/form-data">
                    <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];}; ?>" />
                    <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                    <input name="side_menu_no" type="hidden" value="17" />
                    <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                    <input name="save" id="save" type="hidden" value="-1" />
                    <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                    <input name="sm" id="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
                    <input name="mm" id="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
                    
                    <input name="update_frm" id="update_frm" type="hidden" value=""/>
                    <input name="conf" id="conf" type="hidden" value="" />
                    <input name="getDptProg" id="getDptProg" type="hidden" value="" />
                    <input name="dptmnt" id="dptmnt" type="hidden" value="" />
                    <input name="prgrm" id="prgrm" type="hidden" value="" />

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
                    <input name="passpotLoaded" id="passpotLoaded" type="hidden"/>

                    <input name="BASE_FILE_NAME_FOR_STAFF" id="BASE_FILE_NAME_FOR_STAFF" type="hidden" value="<?php echo BASE_FILE_NAME_FOR_STAFF; ?>" />
                    
                
                    <div class="innercont_stff" id="roles" 
						style="display:<?php if (isset($_REQUEST['sm']) && $_REQUEST['sm']==1){?>block<?php }else{?>none<?php }?>; width:100%; margin:0px; height:auto; position:relative;">
                        <input name="whattodo" id="whattodo" type="hidden" 
                            value="<?php if (isset($_REQUEST["whattodo"]) && $_REQUEST["whattodo"] <> ''){echo $_REQUEST["whattodo"];}?>"/>
                       
                            <div style="width:17%; height:auto;
                            position: absolute; 
                            top:0; 
                            right:0; 
                            border-radius:0px;"><?php
                            if (check_scope3('System admin', 'Role', 'Create role') > 0)
                            {
                                if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='0')
                                {?>
                                    <div id="tabss0_0" class="rtlft_inner_button" style="margin-left:0%;
                                        border-left:1px solid #2b8007;
                                        background-color:#2b8007;
                                        color:#FFFFFF;
                                        display:block;">
                                            Create role
                                    </div>

                                    <a href="#" style="text-decoration:none;" 
                                        onclick="manag_loc.whattodo.value=0;
                                        _('new_role_name').value = '';
                                        _('exist_user').value = '';
                                        _('update_frm').value='0';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss0" class="rtlft_inner_button" style="display:none;">
                                            Create role
                                        </div>
                                    </a><?php
                                }else
                                {?>
                                    <a href="#" style="text-decoration:none;" 
                                        onclick="manag_loc.whattodo.value=0;
                                        _('new_role_name').value = '';
                                        _('exist_user').value = '';
                                        _('update_frm').value='0';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss0" class="rtlft_inner_button">
                                            Create role
                                        </div>
                                    </a><?php
                                }
                            }
                            
                            if (check_scope3('System admin', 'Role', 'Edit role') > 0)
                            {
                                if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='1')
                                {?>
                                    <div id="tabss0_0" class="rtlft_inner_button" style="margin-left:0%;
                                        border-left:1px solid #2b8007;
                                        background-color:#2b8007;
                                        color:#FFFFFF;
                                        display:block;">
                                            Edit role
                                    </div>

                                    <a href="#" style="text-decoration:none;" 
                                        onclick="manag_loc.whattodo.value=1;
                                        _('exist_role_one').value='';
                                        _('new_role_name').value = '';
                                        _('exist_user').value = '';
                                        _('update_frm').value='0';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss0" class="rtlft_inner_button" style="display:none;">
                                            Edit role
                                        </div>
                                    </a><?php
                                }else
                                {?>
                                    <a href="#" style="text-decoration:none;" 
                                        onclick="manag_loc.whattodo.value=1;
                                        _('exist_role_one').value='';
                                        _('new_role_name').value = '';
                                        _('exist_user').value = '';
                                        _('update_frm').value='0';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss0" class="rtlft_inner_button">
                                            Edit role
                                        </div>
                                    </a><?php
                                }
                            }
                            
                            if (check_scope3('System admin', 'Role', 'Assign permission(s) to role') > 0)
                            {
                                if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='2')
                                {?>
                                    <div id="tabss0_0" class="rtlft_inner_button" style="margin-left:0%;
                                        border-left:1px solid #2b8007;
                                        background-color:#2b8007;
                                        color:#FFFFFF;
                                        display:block;">
                                            Assign permision to role
                                    </div>

                                    <a href="#" style="text-decoration:none;" 
                                        onclick="manag_loc.whattodo.value=2;
                                        _('exist_role_one').value='';
                                        _('new_role_name').value = '';
                                        _('exist_user').value = '';
                                        _('update_frm').value='0';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss0" class="rtlft_inner_button" style="display:none;">
                                            Assign permision to role
                                        </div>
                                    </a><?php
                                }else
                                {?>
                                    <a href="#" style="text-decoration:none;" 
                                        onclick="manag_loc.whattodo.value=2;
                                        _('exist_role_one').value='';
                                        _('new_role_name').value = '';
                                        _('exist_user').value = '';
                                        _('update_frm').value='0';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss0" class="rtlft_inner_button">
                                            Assign permision to role
                                        </div>
                                    </a><?php
                                }
                            }
                            
                            if (check_scope3('System admin', 'Role', 'Revoke permission(s) from role') > 0)
                            {
                                if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='3')
                                {?>
                                    <div id="tabss0_0" class="rtlft_inner_button" style="margin-left:0%;
                                        border-left:1px solid #2b8007;
                                        background-color:#2b8007;
                                        color:#FFFFFF;
                                        display:block;">
                                            Revoke permision from role
                                    </div>

                                    <a href="#" style="text-decoration:none;" 
                                        onclick="manag_loc.whattodo.value=3;
                                        _('exist_role_one').value='';
                                        _('new_role_name').value = '';
                                        _('exist_user').value = '';
                                        _('update_frm').value='0';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss0" class="rtlft_inner_button" style="display:none;">
                                        Revoke permision from role
                                        </div>
                                    </a><?php
                                }else
                                {?>
                                    <a href="#" style="text-decoration:none;" 
                                        onclick="manag_loc.whattodo.value=3;
                                        _('exist_role_one').value='';
                                        _('new_role_name').value = '';
                                        _('exist_user').value = '';
                                        _('update_frm').value='0';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss0" class="rtlft_inner_button">
                                        Revoke permision from role
                                        </div>
                                    </a><?php
                                }
                            }
                            
                            if (check_scope3('System admin', 'Role', 'Assign roles to user') > 0)
                            {
                                if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='4')
                                {?>
                                    <div id="tabss1_0" class="rtlft_inner_button" style="margin-left:0%;
                                        border-left:1px solid #2b8007; 
                                        background-color:#2b8007;
                                        color:#FFFFFF;
                                        display:block;">
                                            Assign role to user
                                    </div>

                                    <a href="#" style="text-decoration:none;" 
                                        onclick="manag_loc.whattodo.value=4;
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss1" class="rtlft_inner_button" style="display:none;">
                                            Assign role to user
                                        </div>
                                    </a><?php
                                }else
                                {?>
                                    <a href="#" style="text-decoration:none;" 
                                        onclick="manag_loc.whattodo.value=4;
                                        _('new_role_name').value = '';
                                        _('exist_user').value = '';
                                        _('update_frm').value='0';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss1" class="rtlft_inner_button">
                                            Assign role to user
                                        </div>
                                    </a><?php
                                }
                            }
                            
                            if (check_scope3('System admin', 'Role', 'Revoke all roles from user') > 0)
                            {
                                if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='5')
                                {?>
                                    <div id="tabss4_0" class="rtlft_inner_button" style="margin-left:0%;
                                        border-left:1px solid #2b8007;
                                        background-color:#2b8007;
                                        color:#FFFFFF;
                                        display:block;">
                                            Revoke all roles from user
                                    </div>

                                    <a href="#" style="text-decoration:none;" 
                                        onclick="manag_loc.whattodo.value=5;
                                        _('new_role_name').value = '';
                                        _('exist_user').value = '';
                                        _('update_frm').value='0';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss4" class="rtlft_inner_button" style="display:none;">
                                            Revoke all roles from user
                                        </div>
                                    </a><?php
                                }else
                                {?>
                                    <a href="#" style="text-decoration:none;" 
                                        onclick="manag_loc.whattodo.value=5;
                                        _('new_role_name').value = '';
                                        _('exist_user').value = '';
                                        _('update_frm').value='0';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss4" class="rtlft_inner_button">
                                            Revoke all roles from user
                                        </div>
                                    </a><?php
                                }
                            }
                            
                            if (check_scope3('System admin', 'Role', 'Delete role') > 0)
                            {
                                if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='6')
                                {?>
                                    <div id="tabss5_0" class="rtlft_inner_button" style="margin-left:0%;
                                        border-left:1px solid #2b8007;
                                        background-color:#2b8007;
                                        color:#FFFFFF;
                                        display:block;">
                                            Delete role
                                    </div>

                                    <a href="#" style="text-decoration:none;" 
                                        onclick="manag_loc.whattodo.value=6;
                                        _('new_role_name').value = '';
                                        _('exist_user').value = '';
                                        _('update_frm').value='0';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss5" class="rtlft_inner_button" style="display:none;">
                                            Delete role
                                        </div>
                                    </a><?php
                                }else
                                {?>
                                    <a href="#" style="text-decoration:none;" 
                                        onclick="manag_loc.whattodo.value=6;
                                        _('new_role_name').value = '';
                                        _('exist_user').value = '';
                                        _('update_frm').value='0';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss5" class="rtlft_inner_button">
                                            Delete role
                                        </div>
                                    </a><?php
                                }
                            }
                            
                            if (check_scope3('System admin', 'Role', 'See assigned roles') > 0)
                            {                            
                                if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='7')
                                {?>
                                    <div id="tabss5_0" class="rtlft_inner_button" style="margin-left:0%;
                                        border-left:1px solid #2b8007; 
                                        border-right:1px solid #2b8007;
                                        background-color:#2b8007;
                                        color:#FFFFFF;
                                        display:block;">
                                            See assigned role
                                    </div>

                                    <a href="#" style="text-decoration:none;" 
                                        onclick="manag_loc.whattodo.value=7;
                                        _('new_role_name').value = '';
                                        _('exist_user').value = '';
                                        _('update_frm').value='0';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss5" class="rtlft_inner_button" style="display:none;">
                                            See assinged role
                                        </div>
                                    </a><?php
                                }else
                                {?>
                                    <a href="#" style="text-decoration:none;" 
                                        onclick="manag_loc.whattodo.value=7;
                                        _('new_role_name').value = '';
                                        _('exist_user').value = '';
                                        _('update_frm').value='0';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss5" class="rtlft_inner_button">
                                            See assigned role
                                        </div>
                                    </a><?php
                                }
                            }
                            
                            if (check_scope3('System admin', 'Role', 'See assigned permission') > 0)
                            {                            
                                if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='8')
                                {?>
                                    <div id="tabss5_0" class="rtlft_inner_button" style="margin-left:0%;
                                        border-left:1px solid #2b8007; 
                                        border-right:1px solid #2b8007;
                                        background-color:#2b8007;
                                        color:#FFFFFF;
                                        display:block;">
                                            See assigned permissions
                                    </div>

                                    <a href="#" style="text-decoration:none;" 
                                        onclick="manag_loc.whattodo.value=8;
                                        _('new_role_name').value = '';
                                        _('exist_user').value = '';
                                        _('update_frm').value='0';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss5" class="rtlft_inner_button" style="display:none;">
                                            See assigned permissions
                                        </div>
                                    </a><?php
                                }else
                                {?>
                                    <a href="#" style="text-decoration:none;" 
                                        onclick="manag_loc.whattodo.value=8;
                                        _('new_role_name').value = '';
                                        _('exist_user').value = '';
                                        _('update_frm').value='0';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss5" class="rtlft_inner_button" style="border-bottom:1px dashed #2b8007;">
                                            See assigned permissions
                                        </div>
                                    </a><?php
                                }
                            }?>
                        </div>
                        

                        <div id="exist_user_div" class="innercont_stff" style="display:<?php if (isset($_REQUEST['whattodo'])&&($_REQUEST['whattodo']==4||$_REQUEST['whattodo']==5||$_REQUEST['whattodo']==7)){echo 'block';}else{echo 'none';}?>;"> 
                            <label for="exist_user" class="labell" style="width:185px; margin-left:7px;">Existing users</label>
                            <div class="div_select">
                                <input list="user_names" name="exist_user" id="exist_user" class="textbox"  
                                    onchange="_('update_frm').value='4'; 
                                    if(manag_loc.whattodo.value==4||manag_loc.whattodo.value==7)
                                    {
                                        in_progress('1');
                                        _('manag_loc').submit();
                                    }" 
                                    placeholder="Type name here..." 
                                    style="height:78%;
                                    background-image: url('img/search.png'); 
                                    background-position: 5px 5px; 
                                    background-repeat: no-repeat;
                                    background-size: 8% 70%;
                                    text-indent:25px;
                                    border:1px solid #000;
                                    border-radius:3px;
                                    padding:3px;"
                                    value="<?php if (isset($_REQUEST["exist_user"])){echo $_REQUEST["exist_user"];} ?>"/>
                                <datalist id="user_names"><?php
                                    $sql = "SELECT vApplicationNo, concat(vLastName,', ',vFirstName,' ',vOtherName) allnames FROM userlogin where vLastName is not null ORDER BY vLastName, vFirstName, vOtherName";
                                    $rsgetroles = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                                    $item_count = 0;
                                    while($getroles = mysqli_fetch_array($rsgetroles))
                                    {
                                        $clnt_roles_id = $getroles['vApplicationNo'] ?? '';
                                        $clnt_roles_name = $getroles['allnames'] ?? '';
                                        $item_count++;
                                        if (($item_count%5)==0)
                                        {?>
                                            <option disabled></option><?php
                                        }?>
                                        <option value="<?php echo $clnt_roles_id;?>"><?php echo strtoupper($clnt_roles_name);?></option><?php
                                    }
                                    mysqli_close(link_connect_db());?>
                                </datalist>
                            </div>
                            <div id="labell_msg2" class="labell_msg blink_text orange_msg"></div>
                        </div>


                        <div id="exist_role_div" class="innercont_stff"
                            style="<?php  if (isset($_REQUEST['whattodo'])&&($_REQUEST['whattodo']=='4' || $_REQUEST['whattodo']=='7')){echo 'height:330px';}?>; margin-top:10px; display:<?php if (isset($_REQUEST['whattodo'])&&($_REQUEST['whattodo']==1||$_REQUEST['whattodo']==2||$_REQUEST['whattodo']==3||$_REQUEST['whattodo']==4||$_REQUEST['whattodo']==6||$_REQUEST['whattodo']==7||$_REQUEST['whattodo']==8)){echo 'block';}else{echo 'none';}?>;">
                            <label for="exist_role1" class="labell" style="width:185px; margin-left:7px;">
                                Existing roles
                            </label>
                            
                            <div id="exist_role_one_div" class="div_select" style="display:<?php if (isset($_REQUEST['whattodo'])&&($_REQUEST['whattodo']==1||$_REQUEST['whattodo']==2||$_REQUEST['whattodo']==3||$_REQUEST['whattodo']==4||$_REQUEST['whattodo']==6||$_REQUEST['whattodo']==7||$_REQUEST['whattodo']==8)){echo 'block';}else{echo 'none';}?>;"><?php
                                $rsgetroles = mysqli_query(link_connect_db(), "SELECT sRoleID, vRoleName FROM role ORDER BY vRoleName") 
                                or die(mysqli_error(link_connect_db()));?>
                                
                                <select name="exist_role1[]" id="exist_role1" class="select" multiple="multiple" style="height:inherit; display:<?php if (isset($_REQUEST['whattodo'])&&($_REQUEST['whattodo']==4||$_REQUEST['whattodo']==7)){echo 'block';}else{echo 'none';}?>" 
                                    onchange="_('update_frm').value='3';/*updateScrn();*/">
                                    <option value=""></option><?php
                                    $item_count = 0;
                                    while($getroles = mysqli_fetch_array($rsgetroles))
                                    {
                                        if ($sRoleID_u <> 6 && $getroles['sRoleID'] == 6)
                                        {
                                            continue;
                                        }

                                        $item_count++;
                                        if (($item_count%5)==0)
                                        {?>
                                            <option disabled></option><?php
                                        }?>
                                        <option value="<?php echo $getroles['sRoleID'];?>"
                                        <?php if (isset($_REQUEST['update_frm']) && $_REQUEST['update_frm'] == 4)
                                        {
                                            echo confirm_role($getroles['sRoleID']);
                                        }?>><?php echo $getroles['vRoleName']?></option><?php
                                    }
                                    mysqli_close(link_connect_db());?>
                                </select>
                                
                                <select name="exist_role_one" id="exist_role_one" class="select" style="display:<?php if (isset($_REQUEST['whattodo'])&&($_REQUEST['whattodo']==1||$_REQUEST['whattodo']==2||$_REQUEST['whattodo']==3||$_REQUEST['whattodo']==6||$_REQUEST['whattodo']==8)){echo 'block';}else{echo 'none';}?>" 
                                    onchange="_('update_frm').value='3';updateScrn();">
                                    <option value=""></option><?php
                                    $item_count = 0;

                                    mysqli_data_seek($rsgetroles, 0);
                                    while($getroles = mysqli_fetch_array($rsgetroles))
                                    {
                                        $item_count++;
                                        if (($item_count%5)==0)
                                        {?>
                                            <option disabled></option><?php
                                        }?>
                                        <option value="<?php echo $getroles['sRoleID']?>"
                                        <?php if (isset($_REQUEST['exist_role_one']) &&
                                        $_REQUEST['exist_role_one'] == $getroles['sRoleID']){echo 'selected';}?>>
                                        <?php echo $getroles['vRoleName']?></option><?php
                                    }?>
                                </select>
                            </div>
                            <div id="labell_msg3" class="labell_msg blink_text orange_msg"></div>
                        </div>
                        

                        <div id="new_role_name_div" class="innercont_stff" 
                            style="display:<?php if (isset($_REQUEST['whattodo'])&&($_REQUEST['whattodo']==0||$_REQUEST['whattodo']==1)){echo 'block';}else{echo 'none';}?>">
                            <label id="new_role_name_lab" for="new_role_name" class="labell" style="width:185px; margin-left:7px;"><?php 
                                if (isset($_REQUEST['whattodo'])&&($_REQUEST['whattodo']==0||$_REQUEST['whattodo']==1)){echo 'Name of new role';}?>
                            </label>
                            <div class="div_select">
                                <input name="new_role_name" id="new_role_name" type="text" class="textbox" 
                                onchange="if (this.value.trim()!='')
                                {
                                    this.value=this.value.trim();
                                    this.value=capitalizeEachWord(this.value);
                                }" />
                            </div>
                            <div id="labell_msg4" class="labell_msg blink_text orange_msg"></div>
                        </div>

                        
                        <div id="perms" class="innercont_stff" style="width:82.5%; padding:0px; height:auto; display:none;">
                            <div class="innercont_stff" style="font-weight:bold; width:100%; margin:0px; height:auto">
                                <div class="ctabletd_1" 
                                    style="width:10%; 
                                    text-align:right;
                                    margin-left:0px;
                                    padding:0px;
                                    padding-top:8px;
                                    padding-bottom:8px;
                                    padding-right:0.5%;
                                    height:auto;">
                                    Sno
                                </div>
                                <div class="ctabletd_1" 
                                    style="width:75.3%; 
                                    margin-left:-1px;
                                    text-align:left;
                                    padding:0px;
                                    padding-top:8px;
                                    padding-bottom:8px;
                                    text-indent:4px;
                                    height:auto;">
                                    Action
                                </div>
                                <div class="ctabletd_1" 
                                    style="width:12.1%; 
                                    margin-left:-1px;
                                    text-align:center;
                                    padding:0px;
                                    padding-top:8px;
                                    padding-bottom:8px;
                                    height:auto;">
                                    Allow
                                </div>
                            </div>
                            
                            <ul id="list_cover" class="checklist cl1" style="width:100%; height:80%; font-size:12px;"><?php
                                $level1 = ''; $level2 = ''; $level3 = ''; $c = 0; $c1 = 0;
                                $rsqlmenuItems = mysqli_query(link_connect_db(), "select * from menue_new order by level1, level2")or die("unable to query".mysqli_error(link_connect_db()));
                                    while($rsmenuItems = mysqli_fetch_array($rsqlmenuItems))
                                    {
                                        $c++;
                                        $c1+=10;
                                        if (($level1 == '' || $level1 <> $rsmenuItems['level1']) || ($level2 == '' || $level2 <> $rsmenuItems['level2']) || ($level3 == '' || $level3 <> $rsmenuItems['level3']))
                                        {
                                            if ($level1 == '' || $level1 <> $rsmenuItems['level1'])
                                            {?>
                                                <li style="float:left; 
                                                    margin:0px; 
                                                    padding:0px; 
                                                    height:auto; 
                                                    margin-top:4px; 
                                                    margin-bottom:4px; 
                                                    width:98.07%; 
                                                    border:1px solid #D5DBD5;
                                                    padding-top:10px;
                                                    padding-bottom:10px;
                                                    text-indent:5px;">
                                                    <?php echo $rsmenuItems['level1'];?> 
                                                </li><?php
                                            }

                                            if (($level2 == '' || $level2 <> $rsmenuItems['level2']) && $rsmenuItems['level3'] <> '')
                                            {?>
                                                <div class="innercont_stff" style="font-weight:normal; width:100%; margin:0px; height:auto">
                                                    <div class="ctabletd_1" 
                                                        style="width:10%; 
                                                        text-align:right;
                                                        margin-left:0px;
                                                        padding:0px;
                                                        padding-top:10px;
                                                        padding-bottom:10px;
                                                        padding-right:0.5%;
                                                        height:auto;">
                                                        -
                                                    </div>
                                                    <div class="ctabletd_1" 
                                                        style="width:75.3%; 
                                                        text-align:left;
                                                        margin-left:-1px;
                                                        padding:0px;
                                                        padding-top:10px;
                                                        padding-bottom:10px;
                                                        text-indent:4px;
                                                        height:auto;">
                                                        <?php echo $rsmenuItems['level2'];?>
                                                    </div>
                                                    <div class="ctabletd_1" 
                                                        style="width:12.1%; 
                                                        margin-left:-1px;
                                                        text-align:center;
                                                        padding:0px;
                                                        padding-top:10px;
                                                        padding-bottom:10px;
                                                        height:auto;">
                                                        -
                                                    </div>
                                                </div><?php
                                            } 
                                            
                                            if (($level2 == '' || $level2 <> $rsmenuItems['level2']) && $rsmenuItems['level3'] == '')
                                            {?>
                                                <li style="float:left; height:auto; padding:0px; width:98.3%; border:none;"<?php if ($c%2 == 0){echo ' class="alt"';}?>>
                                                    <label style="cursor:default;">
                                                        <div class="ctabletd_1" 
                                                            style="width:10.2%; 
                                                            text-align:right;
                                                            margin-left:0px;
                                                            padding:0px;
                                                            padding-top:9px;
                                                            padding-bottom:9.5px;
                                                            padding-right:0.5%;
                                                            height:auto;">
                                                            <?php echo $c;//.' '.$rsmenuItems['ictID'];?>
                                                        </div>

                                                        <div class="ctabletd_1" 
                                                            style="width:76.65%; 
                                                            margin-left:-1px;
                                                            text-align:left;
                                                            padding:0px;
                                                            padding-top:9px;
                                                            padding-bottom:9.5px;
                                                            text-indent:4px;
                                                            height:auto;">
                                                            <?php echo $rsmenuItems['level2'];?>
                                                        </div>

                                                        <div class="ctabletd_1" 
                                                            style="width:12.2%; 
                                                            margin-left:-1px;
                                                            text-align:center;
                                                            padding:0px;
                                                            padding-top:8px;
                                                            padding-bottom:8.9px;
                                                            height:auto;">
                                                            <input name="<?php echo 'perm_chk'.$rsmenuItems['ictID'];?>" 
                                                                id="<?php echo 'perm_chk'.$rsmenuItems['ictID'];?>" 
                                                                type="checkbox" 
                                                                style="margin:auto;
                                                                margin-top:3px;"
                                                                value="<?php echo $rsmenuItems['ictID'];?>" />
                                                        </div>
                                                    </label>
                                                </li><?php
                                            }
                                        }
                                        
                                        if ($rsmenuItems['level3'] <> '')
                                        {?>
                                            <li style="float:left; height:auto; padding:0px; width:98.2%; border:none;"<?php if ($c%2 == 0){echo ' class="alt"';}?>>
                                                <label style="cursor:default;">
                                                    <div class="ctabletd_1" 
                                                        style="width:10.2%; 
                                                            text-align:right;
                                                            margin-left:0px;
                                                            padding:0px;
                                                            padding-top:9px;
                                                            padding-bottom:11px;
                                                            padding-right:0.5%;
                                                            height:auto;">-</div>
                                                        
                                                    <div class="ctabletd_1" 
                                                        style="width:8%; 
                                                        text-align:left;
                                                        margin-left:-1px;
                                                        padding:0px;
                                                        padding-top:10px;
                                                        padding-bottom:10px;
                                                        text-indent:4px;
                                                        height:auto;">
                                                        <?php echo $c;//.' '.$rsmenuItems['ictID'];?>
                                                    </div>

                                                    <div class="ctabletd_1" 
                                                        style="width:68.6%; 
                                                        text-align:left;
                                                        margin-left:-1px;
                                                        padding:0px;
                                                        padding-top:10px;
                                                        padding-bottom:10px;
                                                        text-indent:4px;
                                                        height:auto;">
                                                        <?php echo $rsmenuItems['level3'];?>
                                                    </div>

                                                    <div class="ctabletd_1" 
                                                        style="width:12.2%; 
                                                            margin-left:-1px;
                                                            text-align:center;
                                                            padding:0px;
                                                            padding-top:8px;
                                                            padding-bottom:9px;
                                                            height:auto;">
                                                        <input name="<?php echo 'perm_chk'.$rsmenuItems['ictID'];?>" 
                                                        id="<?php echo 'perm_chk'.$rsmenuItems['ictID'];?>" 
                                                        type="checkbox" 
                                                        style="margin:auto; 
                                                        margin-top:5px;"
                                                        value="<?php echo $rsmenuItems['ictID'];?>" />
                                                    </div>
                                                </label>
                                            </li><?php 
                                        }
                                        $level3 = $rsmenuItems['level3'];
                                        $level2 = $rsmenuItems['level2'];
                                        $level1 = $rsmenuItems['level1'];
                                    }
                                    mysqli_close(link_connect_db());?>
                            </ul>
                        </div>
                        <input name="number_perms" id="number_perms" type="hidden" value="<?php echo $c1; ?>"/>
                    </div>

					
                    <div id="users"
                        style="float:left;
						height:auto; 
						width:100%;
						margin-top:0px; 
						position:relative;
						display:<?php if (isset($_REQUEST['sm']) && $_REQUEST['sm']==2){?>block<?php }else{?>none<?php }?>;">
                        <input name="whattodo1" id="whattodo1" type="hidden" value="<?php if (isset($_REQUEST["whattodo1"]) && $_REQUEST["whattodo1"] <> ''){echo $_REQUEST["whattodo1"];}?>"/>
                        
                        <div style="width:15%; height:auto; position:absolute; top:0; right:0; border-radius:0px; z-Index:1;"><?php
                            if (check_scope3('System admin', 'User', 'View user') > 0)
                            {
                                if (isset($_REQUEST['whattodo1'])&&$_REQUEST['whattodo1']=='0')
                                {?>
                                    <div id="tabss0_0" class="rtlft_inner_button" style="margin-left:0%;
                                        border-left:1px solid #2b8007;
                                        background-color:#2b8007;
                                        color:#FFFFFF;
                                        padding:5px; 
                                        height:auto; 
                                        display:block;">
                                            View user
                                    </div>

                                    <a href="#" style="text-decoration:none;" 
                                        onclick="_('whattodo1').value=0;
                                        _('exist_user1').value = '';
                                        _('update_frm').value='2';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss0" class="rtlft_inner_button" style="display:none;">
                                            View user
                                        </div>
                                    </a><?php
                                }else
                                {?>
                                    <a href="#" style="text-decoration:none;" 
                                        onclick="_('whattodo1').value=0;
                                        _('exist_user1').value = '';
                                        _('update_frm').value='2';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss0" class="rtlft_inner_button">
                                            View user
                                        </div>
                                    </a><?php
                                }
                            }

                            if (check_scope3('System admin', 'User', 'Create user') > 0)
                            {
                                if (isset($_REQUEST['whattodo1'])&&$_REQUEST['whattodo1']=='1')
                                {?>
                                    <div id="tabss0_0" class="rtlft_inner_button" style="margin-left:0%;
                                        border-left:1px solid #2b8007;
                                        background-color:#2b8007;
                                        color:#FFFFFF;
                                        display:block;">
                                            Create user
                                    </div>

                                    <a href="#" style="text-decoration:none;" 
                                        onclick="_('whattodo1').value=1;
                                        _('exist_user1').value = '';
                                        _('update_frm').value='2';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss0" class="rtlft_inner_button" style="display:none;">
                                            Create user
                                        </div>
                                    </a><?php
                                }else
                                {?>
                                    <a href="#" style="text-decoration:none;" 
                                        onclick="_('whattodo1').value=1;
                                        _('exist_user1').value = '';
                                        _('update_frm').value='2';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss0" class="rtlft_inner_button">
                                            Create user
                                        </div>
                                    </a><?php
                                }
                            }
                            
                            if (check_scope3('System admin', 'User', 'Edit user') > 0)
                            {
                                if (isset($_REQUEST['whattodo1'])&&$_REQUEST['whattodo1']=='2')
                                {?>
                                    <div id="tabss0_0" class="rtlft_inner_button" style="margin-left:0%;
                                        border-left:1px solid #2b8007;
                                        background-color:#2b8007;
                                        color:#FFFFFF;
                                        display:block;">
                                            Edit user
                                    </div>

                                    <a href="#" style="text-decoration:none;" 
                                        onclick="_('whattodo1').value=2;
                                        _('exist_user1').value = '';
                                        _('update_frm').value='2';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss0" class="rtlft_inner_button" style="display:none;">
                                            Edit user
                                        </div>
                                    </a><?php
                                }else
                                {?>
                                    <a href="#" style="text-decoration:none;" 
                                        onclick="_('whattodo1').value=2;
                                        _('exist_user1').value = '';
                                        _('update_frm').value='2';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss0" class="rtlft_inner_button">
                                            Edit user
                                        </div>
                                    </a><?php
                                }
                            }
                            
                            if (check_scope3('System admin', 'User', 'Block user') > 0)
                            {
                                if (isset($_REQUEST['whattodo1'])&&$_REQUEST['whattodo1']=='3')
                                {?>
                                    <div id="tabss4_0" class="rtlft_inner_button" style="margin-left:0%;
                                        border-left:1px solid #2b8007;
                                        background-color:#2b8007;
                                        color:#FFFFFF;
                                        padding:5px; 
                                        height:auto; 
                                        display:block;">
                                            Block user
                                    </div>

                                    <a href="#" style="text-decoration:none;" 
                                        onclick="_('whattodo1').value=3;
                                        _('exist_user1').value = '';
                                        _('update_frm').value='2';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss4" class="rtlft_inner_button" style="display:none;">
                                            Block user
                                        </div>
                                    </a><?php
                                }else
                                {?>
                                    <a href="#" style="text-decoration:none;" 
                                        onclick="_('whattodo1').value=3;
                                        _('exist_user1').value = '';
                                        _('update_frm').value='2';
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss4" class="rtlft_inner_button">
                                            Block user
                                        </div>
                                    </a><?php
                                }
                            }
                            
                            if (check_scope3('System admin', 'User', 'Unblock user') > 0)
                            {
                                if (isset($_REQUEST['whattodo1'])&&$_REQUEST['whattodo1']=='4')
                                {?>
                                    <div id="tabss5_0" class="rtlft_inner_button" style="margin-left:0%;
                                        border-left:1px solid #2b8007; 
                                        border-right:1px solid #2b8007;
                                        background-color:#2b8007;
                                        color:#FFFFFF;
                                        display:block;">
                                            Unblock user
                                    </div>

                                    <a href="#" style="text-decoration:none;" 
                                        onclick="_('whattodo1').value=4;
                                        _('exist_user1').value = '';
                                        _('update_frm').value='2';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss5" class="rtlft_inner_button" style="display:none;">
                                            Unblock user
                                        </div>
                                    </a><?php
                                }else
                                {?>
                                    <a href="#" style="text-decoration:none;" 
                                        onclick="_('whattodo1').value=4;
                                        _('exist_user1').value = '';
                                        _('update_frm').value='2';
                                        in_progress('1');
                                        manag_loc.submit();
                                        return false">
                                        <div id="tabss5" class="rtlft_inner_button" style="border-bottom:1px dashed #2b8007;">
                                            Unblock user
                                        </div>
                                    </a><?php
                                }
                            }?>
                        </div>

                        <div id="exist_user_div1" class="innercont_stff" style="margin-bottom:5px; display:<?php if (isset($_REQUEST['whattodo1'])&&$_REQUEST['whattodo1']<>1){echo 'block';}else{echo 'none';}?>;">
                            <label for="exist_user1" class="labell" style="width:185px; margin-left:7px;">Existing users</label>
                            <div class="div_select">										
                                <input list="user_name1" name="exist_user1" id="exist_user1" class="textbox"  
                                    onchange="_('update_frm').value='1';
                                    _('manag_loc').getDptProg.value='1';
                                    if(_('whattodo1').value=='3'||_('whattodo1').value=='4'){_('update_frm').value='4';}
                                    if(_('whattodo1').value<3){updateScrn();}"
                                    placeholder="Type name or staff number here ..." 
                                    style="height:78%;
                                    background-image: url('img/search.png'); 
                                    background-position: 5px 5px; 
                                    background-repeat: no-repeat;
                                    background-size: 8% 70%;
                                    text-indent:25px;
                                    border:1px solid #000;
                                    border-radius:3px;
                                    padding:3px;"/>
                                <datalist id="user_name1"><?php
                                    $sql = "SELECT vApplicationNo, concat(vLastName,', ',vFirstName,' ',vOtherName) allnames FROM userlogin ORDER BY allnames";
                                    $rsgetroles_2 = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                                    $item_count = 0;
                                    while($getroles_2 = mysqli_fetch_array($rsgetroles_2))
                                    {
                                        $item_count++;
                                        if (($item_count%5)==0)
                                        {?>
                                            <option disabled></option><?php
                                        }?>
                                        <option value="<?php echo $getroles_2['vApplicationNo']?>"><?php if (isset($getroles_2['allnames'])){echo strtoupper($getroles_2['allnames']);}?></option><?php
                                    }
                                    mysqli_close(link_connect_db());?>
                                </datalist>
                            </div>
                            <div id="labell_msg17" class="labell_msg blink_text orange_msg"></div>
                        </div>
                        
                        <div id="exist_role_div1" class="innercont_stff" style="display:<?php if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']==4){echo 'block';}else{echo 'none';}?>">
                            <label for="exist_role1" class="labell" style="width:185px; margin-left:7px;">Existing roles</label>
                            <div class="div_select"><?php
                                $rsgetroles = mysqli_query(link_connect_db(), "SELECT sRoleID, vRoleName FROM role ORDER BY vRoleName") or die(mysqli_error(link_connect_db()));?>
                                <select name="exist_role2[]" id="exist_role2" class="select" multiple="multiple" style="width:155px; height:auto" 
                                    onchange="_('update_frm').value='3';updateScrn();">
                                    <option value=""></option><?php
                                    $item_count = 0;
                                    while($getroles = mysqli_fetch_array($rsgetroles))
                                    {
                                        if ($sRoleID_u <> 6 && $getroles['sRoleID'] == 6)
                                        {
                                            continue;
                                        }
                                        
                                        $item_count++;
                                        if (($item_count%5)==0)
                                        {?>
                                            <option disabled></option><?php
                                        }?>
                                        <option value="<?php echo $getroles['sRoleID']?>"
                                        <?php if (isset($_REQUEST['exist_role']) &&
                                        $_REQUEST['exist_role'] == $getroles['sRoleID']){echo 'selected';}?>>
                                        <?php echo $getroles['vRoleName']?></option><?php
                                    }
                                    mysqli_close(link_connect_db());?>
                                </select>
                            </div>
                            <div id="labell_msg18" class="labell_msg blink_text orange_msg"></div>
                        </div>

                        <div id="new_user_name_div1" class="innercont_stff" style="z-Index:0; margin-top:0px; height:auto; display:<?php if (isset($_REQUEST['whattodo1'])&&$_REQUEST['whattodo1']==1){echo 'block';}else{echo 'none';}?>; position:relative">
                            <input name="get_staff_detail" id="get_staff_detail" type="hidden" /><?php
                            $vLastName = '';
                            $vFirstName = ''; 
                            $vOtherName = '';

                            $mail_id = '';
                            
                            if (isset($_REQUEST["get_staff_detail"]) && $_REQUEST["get_staff_detail"] == '1')
                            {
                                $stmt = $mysqli->prepare("SELECT vLastName, vFirstName, vOtherName FROM desigs where vApplicationNo = ?");
                                $stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($vLastName, $vFirstName, $vOtherName);
                                $stmt->fetch();
                                $stmt->close();

                                $stmt = $mysqli->prepare("SELECT mail_id FROM mail_rec where vApplicationNo = ?");
                                $stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($mail_id);
                                $stmt->fetch();
                                $stmt->close();
                            }?>
                            <div class="innercont_stff">
                                <label for="uvApplicationNo" class="labell" style="width:185px; margin-left:7px;">User name (Staff ID) </label>
                                <div class="div_select">
                                    <input name="uvApplicationNo" id="uvApplicationNo" type="text" class="textbox" 
                                        style="text-transform:none;" 
                                        onchange="this.value = pad(this.value, 5, 0);
                                        get_staff_detail.value='1';
                                        in_progress('1');
                                        manag_loc.submit();"
                                        value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
                                </div>
                                <div id="labell_msg19" class="labell_msg blink_text orange_msg"></div>
                            </div>
                            
                            <div id="role_desc_div" class="innercont_stff" style="display:none;">
                                <label class="labell" style="width:185px; margin-left:7px;">Role</label>
                                <div class="div_select">
                                    <input  id="role_desc_lbl" type="text" class="textbox" disabled />
                                </div>
                            </div>

                            <div class="innercont_stff">
                                <label for="vLastName" class="labell" style="width:185px; margin-left:7px;">Last name</label>
                                <div class="div_select">
                                    <input name="vLastName" id="vLastName" type="text" class="textbox" style="text-transform:uppercase;" 
                                        onchange="this.value=this.value.trim();
                                        this.value=this.value.toUpperCase()" 
                                        value="<?php echo $vLastName;?>"/>
                                </div>
                                <div id="labell_msg20" class="labell_msg blink_text orange_msg"></div>
                            </div>
                            
                            <div class="innercont_stff">
                                <label for="vFirstName" class="labell" style="width:185px; margin-left:7px;">First name</label>
                                <div class="div_select">
                                    <input name="vFirstName" id="vFirstName" type="text" class="textbox" 
                                        onchange="this.value=this.value.trim();
                                        this.value=capitalizeEachWord(this.value)" 
                                        value="<?php echo $vFirstName;?>"/>
                                </div>
                                <div id="labell_msg21" class="labell_msg blink_text orange_msg"></div>
                            </div>
                            
                            <div class="innercont_stff">
                                <label for="vOtherName" class="labell" style="width:185px; margin-left:7px;">Other names</label>
                                <div class="div_select">
                                    <input name="vOtherName" id="vOtherName" type="text" class="textbox" 
                                    onchange="this.value=this.value.trim();
                                    this.value=capitalizeEachWord(this.value)" 
                                        value="<?php echo $vOtherName;?>" />
                                </div>
                                <div id="labell_msg22" class="labell_msg blink_text orange_msg"></div>
                            </div>
                            
                            <div class="innercont_stff">
                                <label for="cphone" class="labell" style="width:185px; margin-left:7px;">Phone number</label>
                                <div class="div_select">
                                    <input name="cphone" id="cphone" type="number" class="textbox" style="text-transform:none;" />
                                </div>
                                <div id="labell_msg23" class="labell_msg blink_text orange_msg"></div>
                            </div>
                            
                            <div class="innercont_stff">
                                <label for="cemail" class="labell" style="width:185px; margin-left:7px;">eMail address</label>
                                <div class="div_select">
                                    <input name="cemail" id="cemail" type="text" class="textbox" style="text-transform:none;"  
                                        value="<?php echo $mail_id;?>"/>
                                </div>
                                <div id="labell_msg24" class="labell_msg blink_text orange_msg"></div>
                            </div>
                            
                            <div class="innercont_stff" style="margin-top:10px; height:auto;">
                                <label for="sbtd_pix" class="labell" style="width:185px; margin-left:7px;">Upload passport picture</label>
                                <input type="file" name="sbtd_pix" id="sbtd_pix" style="width:185px; float:left;" title="Max size: 100KB, Format: JPG">
                                <div id="labell_msg24a" class="labell_msg blink_text orange_msg"></div>
                            </div>
                            

                            <div id="staff_study_center_div" class="innercont_stff" style="margin-top:7px; height:auto; display:block"><?php
                                $rs_sql = mysqli_query(link_connect_db(), "SELECT cStudyCenterId, vCityName, vStateName FROM studycenter a, ng_state b 
                                    WHERE a.cStateId = b.cStateId AND a.cDelFlag = 'N' ORDER BY b.vStateName, vCityName") or die(mysqli_error(link_connect_db()));?>
                                <label for="staff_study_center" class="labell" style="width:185px; margin-left:7px;">Study centre</label>
                                <div class="div_select">
                                <select name="staff_study_center[]" id="staff_study_center" size="5" multiple="multiple" class="select"style="height:150px">
                                    <option value="" selected></option><?php                                    
                                    $study_mode_loc = '';
                                    $C = 0;
                                    while ($rs = mysqli_fetch_array($rs_sql))
                                    {
                                        $c++;
                                        if ($c%5==0)
                                        {?>
                                            <option disabled></option><?php
                                        }?>
                                        <option value="<?php echo $rs['cStudyCenterId'];?>"><?php echo $rs['vStateName'].' '.$rs['vCityName'];?></option><?php
                                    }
                                    mysqli_close(link_connect_db());?>
                                    <option value="" selected></option>
                                    <option value="OTH">
                                        Other
                                    </option>
                                </select>
                                </div>
                                <div id="labell_msg29" class="labell_msg blink_text orange_msg"></div>
                            </div>
                            
                            <div class="innercont_stff" style="margin-top:7px;">
                                <label for="staff_cat" class="labell" style="width:185px; margin-left:7px;">Staff category</label>
                                <div class="div_select">
                                    <select name="staff_cat" id="staff_cat" class="select" onchange="if(this.value==0)
                                    {
                                        for_nts.style.display='block';
                                        for_ts.style.display='none';
                                    }else
                                    {
                                        for_nts.style.display='none';
                                        for_ts.style.display='block';
                                    }">
                                        <option value="" selected="selected"></option>
                                        <option value="0">None-teaching</option>
                                        <option value="1">Teaching</option>
                                    </select>
                                </div>
                                <div id="labell_msg31" class="labell_msg blink_text orange_msg"></div>
                            </div>
                            
                            <div id="for_ts" class="innercont_stff" style="margin-top:7px; display:none"><?php
                                $sql1 = "SELECT cFacultyId, vFacultyDesc FROM faculty WHERE cCat = 'A' ORDER BY cFacultyId";
                                $rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
                                <label for="cFacultyId72" class="labell" style="width:185px; margin-left:7px;">Faculties</label>
                                <div class="div_select">
                                    <select name="cFacultyId72" id="cFacultyId72" class="select" 
                                        onchange="update_cat_country('cFacultyId72', 'cdeptId_readup', 'cdept72', 'cdept72');">
                                        <option value="" selected="selected"></option>
                                        <option value="" disabled></option><?php
                                        $c = 0;
                                        while ($table= mysqli_fetch_array($rsql1))
                                        {
                                            $c++;
                                            if ($c%5==0){?><option disabled></option><?php }?>
                                            <option value="<?php echo $table[0] ?>"><?php echo $table[1];?></option><?php
                                        }
                                        mysqli_close(link_connect_db());?>
                                    </select>
                                </div>
                                <div id="labell_msg26" class="labell_msg blink_text orange_msg"></div>
                            </div>
                            
                            
                            <div id="for_nts" class="innercont_stff" style="margin-top:7px; display:block"><?php                                
                                $sql1 = "SELECT unit_code, unit_desc FROM units ORDER BY unit_desc";
                                $rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
                                <label for="cFacultyId72_nts" class="labell" style="width:185px; margin-left:7px;">Units</label>
                                <div class="div_select">
                                    <select name="cFacultyId72_nts" id="cFacultyId72_nts" class="select" 
                                        onchange="_('cdept72').length = 0;
                                        _('cdept72').options[_('cdept72').options.length] = new Option('Not applicable', 'NA');
                                        _('cdept72').value='NA';">
                                        <option value="" selected="selected"></option>
                                        <option value="" disabled></option><?php
                                        $c = 0;
                                        while ($table= mysqli_fetch_array($rsql1))
                                        {
                                            $c++;
                                            if ($c%5==0){?><option disabled></option><?php }?>
                                            <option value="<?php echo $table[0] ?>"><?php echo $table[1];?></option><?php
                                        }
                                        mysqli_close(link_connect_db());?>
                                    </select>
                                </div>
                                <div id="labell_msg32" class="labell_msg blink_text orange_msg"></div>
                            </div>
                            <div class="innercont_stff">
                                <label for="cdept72" class="labell" style="width:185px; margin-left:7px;">Department</label>
                                <div class="div_select">
                                    <select name="cdept72" id="cdept72" class="select">
                                        <option value="" selected="selected"></option>
                                    </select>
                                </div>
                                <div id="labell_msg27" class="labell_msg blink_text orange_msg"></div>
                            </div>

                            <div class="innercont_stff" style="height:auto; margin-top:7px;">
                                <label for="tech_support" class="labell" style="width:193px;">Technical support</label>
                                <div class="div_select">
                                    <input name="tech_support" id="tech_support" type="checkbox"
                                        style="margin-top:4px; margin-left:0px;" />
                                </div>
                            </div>


                            <!--<div class="innercont_stff" style="height:auto; padding:10px 0px 0px 0;">-->
                            <!--    <label class="labell" style="width:193px;line-height:1.4;"></label>-->
                            <!--    <div class="div_select">Can recieve students' requests for...</div>-->
                            <!--</div>-->

                            <!--<div class="innercont_stff" style="height:auto; margin-top:7px;">-->
                            <!--    <label for="change_of_name" class="labell" style="width:193px;">...change of name</label>-->
                            <!--    <div class="div_select">-->
                            <!--        <input name="change_of_name" id="change_of_name" type="checkbox" value="1"-->
                            <!--            style="margin-top:4px; margin-left:0px;" />-->
                            <!--    </div>-->
                            <!--</div>-->

                            <!--<div class="innercont_stff" style="height:auto; margin-top:7px;">-->
                            <!--    <label for="change_of_level" class="labell" style="width:193px;">...change of level</label>-->
                            <!--    <div class="div_select">-->
                            <!--        <input name="change_of_level" id="change_of_level" type="checkbox" value="1"-->
                            <!--            style="margin-top:4px; margin-left:0px;" />-->
                            <!--    </div>-->
                            <!--</div>-->

                            <!--<div class="innercont_stff" style="height:auto; margin-top:7px;">-->
                            <!--    <label for="change_of_programme" class="labell" style="width:193px;">...change of programme</label>-->
                            <!--    <div class="div_select">-->
                            <!--        <input name="change_of_programme" id="change_of_programme" type="checkbox" value="1"-->
                            <!--            style="margin-top:4px; margin-left:0px;" />-->
                            <!--    </div>-->
                            <!--</div>-->

                            <!--<div class="innercont_stff" style="height:auto; margin-top:7px;">-->
                            <!--    <label for="change_of_study_centre" class="labell" style="width:193px;">...change of Study Centre</label>-->
                            <!--    <div class="div_select">-->
                            <!--        <input name="change_of_study_centre" id="change_of_study_centre" type="checkbox" value="1"-->
                            <!--            style="margin-top:4px; margin-left:0px;" />-->
                            <!--    </div>-->
                            <!--</div>-->

                            <!--<div class="innercont_stff" style="height:auto; margin-top:7px;">-->
                            <!--    <label for="passport_upload" class="labell" style="width:193px;">...passport upload</label>-->
                            <!--    <div class="div_select">-->
                            <!--        <input name="passport_upload" id="passport_upload" type="checkbox" value="1"-->
                            <!--            style="margin-top:4px; margin-left:0px;" />-->
                            <!--    </div>-->
                            <!--</div>-->
                            
                            <!--<div class="innercont_stff" style="height:auto; margin:7px 0px 7px 0px;">-->
                            <!--    <label for="transcript" class="labell" style="width:193px;">...transcript</label>-->
                            <!--    <div class="div_select">-->
                            <!--        <input name="transcript" id="transcript" type="checkbox" value="1"-->
                            <!--            style="margin-top:4px; margin-left:0px;" />-->
                            <!--    </div>-->
                            <!--</div>-->
                            
                            <!--<div class="innercont_stff" style="height:auto; margin-top:7px;">-->
                            <!--    <label for="cProgrammeId72" class="labell" style="width:185px; margin-left:7px;">Programme</label>-->
                            <!--    <div class="div_select">-->
                            <!--        <select name="cprogrammeId72[]" id="cprogrammeId72" size="3" multiple="multiple" class="select" style="height:auto">-->
                            <!--            <option value="" selected="selected"></option>-->
                            <!--        </select>-->
                            <!--    </div>-->
                            <!--    <div id="labell_msg28" class="labell_msg blink_text orange_msg"></div>-->
                            <!--</div>-->
                            
                            <!--<div class="innercont_stff" style="height:auto; margin-top:7px;">-->
                            <!--    <label for="assigned_crs" class="labell" style="width:185px; margin-left:7px;">Assigned courses</label>-->
                            <!--    <div class="div_select">-->
                            <!--        <textarea onchange="this.value=this.value.trim()" -->
                            <!--            style="width:98%" name="assigned_crs" id="assigned_crs"></textarea>-->
                            <!--    </div>-->
                            <!--    <div id="labell_msg30" class="labell_msg blink_text orange_msg"></div>-->
                            <!--</div>-->
                        </div>
                    </div>
                </form>
            </div>
		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;">
			<div id="pp_box">
				<img name="passprt" id="passprt" src="<?php echo get_staff_pp_pix();?>" width="95%" height="185"  
				style="margin:0px;<?php if ($currency <> '1' ){?>opacity:0.3;<?php }?>" alt="" />
			</div>
			<!-- InstanceBeginEditable name="EditRegion7" -->
			<!-- InstanceEndEditable -->
		</div>
		<div id="insiderightSide">
			<!-- InstanceBeginEditable name="EditRegion8" -->
                <div class="innercont_stff" style="margin:0px; padding:0px;">
                    <a href="#" style="text-decoration:none;" onclick="_('nxt').action = 'staff_home_page';_('nxt').mm.value='';in_progress('1');_('nxt').submit();return false">
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