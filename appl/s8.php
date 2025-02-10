<?php
require_once('good_entry.php');
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('lib_fn.php');
require_once('lib_fn_2.php');
require_once('const_def.php');

$mysqli = link_connect_db();?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG?>left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/s8.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/s8.css" />
        <link rel="stylesheet" type="text/css" media="all" href="../admin/style_sheet_1.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
        <script language="JavaScript" type="text/javascript">
            function submitForm()
            {
                if (!_("name_check").checked)
                {
                    caution_inform("Check the appropriate box to confirm your identity otherwise, edit your form as applicable");
                    return false;
                }

                if (!_("pix_check").checked)
                {
                    caution_inform("Check the appropriate box to confirm that you are the one in the uploaded passport picture otherwise, edit your form as applicable");
                    return false;
                }

                if (!_("pix_size_check").checked)
                {
                    caution_inform("Check the appropriate box to confirm that the uploaded picture is of passport size  otherwise, edit your form as applicable");
                    return false;
                }

                if (!_("pix_time_check").checked)
                {
                    caution_inform("Check the appropriate box to confirm that the uploaded picture was taken less than three months ago otherwise, edit your form as applicable");
                    return false;
                }

                if (!_("prog_check").checked)
                {
                    caution_inform("Check the appropriate box to confirm that you are okay with the selected programme otherwise, edit your form as applicable");
                    return false;
                }

                if (!_("level_check").checked)
                {
                    caution_inform("Check the appropriate box to confirm that you are okay with the selected level otherwise, edit your form as applicable");
                    return false;
                }

                if (_("vProgrammeDesc_db").value.indexOf("Nursing") != -1 && !_("nmcn_check").checked)
                {
                    caution_inform("Check the appropriate box to confirm that you are registered with NMCN otherwise, edit your form as applicable");
                    return false;
                }
                
                if (_("post_g"))
                {
                    var file_names = "";

                    var files_pr = _("sbtd_pix_pr").files;
                    if ((_("sbtd_pix_pr").files.length == 0 && (_("pr_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_pr").files.length > 0 && files_pr[0].type != "application/pdf"))
                    {
                        caution_inform("PDF file required for payment receipt");
                        _('conf_box_loc').style.zIndex='-1';
                        _('conf_box_loc').style.display='none';

                        _('smke_screen_2').style.zIndex='-1';
                        _('smke_screen_2').style.display='none';
                        return false;
                    }
                    
                    if (_("sbtd_pix_pr").files.length > 0)
                    {
                        if (files_pr[0].size > 100000)
                        {
                            caution_inform("Maximum file size for payment receipt is 100KB");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';
                        
                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }
                    }
                    
                    
                    var files_cv = _("sbtd_pix_cv").files;
                    if ((_("sbtd_pix_cv").files.length == 0 && (_("cv_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_cv").files.length > 0 && files_cv[0].type != "application/pdf"))
                    {
                        caution_inform("PDF file required for curriculum vitae");
                        _('conf_box_loc').style.zIndex='-1';
                        _('conf_box_loc').style.display='none';
                        
                        _('smke_screen_2').style.zIndex='-1';
                        _('smke_screen_2').style.display='none';
                        return false;
                    }
                    
                    if (_("sbtd_pix_cv").files.length > 0)
                    {
                        if (files_cv[0].size > 150000)
                        {
                            caution_inform("Maximum file size for curriculum vitae is 100KB");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';
                        
                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }

                        if (file_names.indexOf(files_cv[0].name) >= 0)
                        {
                            caution_inform("Curriculum vitae fle already selected");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';
                        
                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }
                    }


                    var files_rl1 = _("sbtd_pix_rl1").files;
                    if ((_("sbtd_pix_rl1").files.length == 0 && (_("rl1_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_rl1").files.length > 0 &&files_rl1[0].type != "application/pdf"))
                    {
                        caution_inform("PDF file required for reference letter 1");
                        _('conf_box_loc').style.zIndex='-1';
                        _('conf_box_loc').style.display='none';
                        
                        _('smke_screen_2').style.zIndex='-1';
                        _('smke_screen_2').style.display='none';
                        return false;
                    }
                    
                    if (_("sbtd_pix_rl1").files.length > 0)
                    {
                        if (files_rl1[0].size > 100000)
                        {
                            caution_inform("Maximum file size for reference letter 1 is 100KB");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';
                        
                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }

                        if (file_names.indexOf(files_rl1[0].name) >= 0)
                        {
                            caution_inform("File for reference letter 1 already selected");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';
                        
                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }
                    }


                    var files_rl2 = _("sbtd_pix_rl2").files;
                    if ((_("sbtd_pix_rl2").files.length == 0 && (_("rl2_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_rl2").files.length > 0 &&files_rl2[0].type != "application/pdf"))
                    {
                        caution_inform("PDF file required for reference letter 2");
                        _('conf_box_loc').style.zIndex='-1';
                        _('conf_box_loc').style.display='none';
                        
                        _('smke_screen_2').style.zIndex='-1';
                        _('smke_screen_2').style.display='none';
                        return false;
                    }
                    
                    if (_("sbtd_pix_rl2").files.length > 0)
                    {
                        if (files_rl2[0].size > 100000)
                        {
                            caution_inform("Maximum file size for reference letter 1 is 100KB");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';
                        
                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }

                        if (file_names.indexOf(files_rl2[0].name) >= 0)
                        {
                            caution_inform("File for reference letter 1 already selected");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';
                        
                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }
                    }
                    
                    
                    var files_tp = _("sbtd_pix_tp").files;
                    if ((_("sbtd_pix_tp").files.length == 0 && (_("tp_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_tp").files.length > 0 && files_tp[0].type != "application/pdf"))
                    {
                        caution_inform("PDF file required for thesis proposal");
                        _('conf_box_loc').style.zIndex='-1';
                        _('conf_box_loc').style.display='none';
                        
                        _('smke_screen_2').style.zIndex='-1';
                        _('smke_screen_2').style.display='none';
                        return false;
                    }
                    
                    if (_("sbtd_pix_tp").files.length > 0)
                    {
                        if (files_tp[0].size > 150000)
                        {
                            caution_inform("Maximum file size for thesis proposal is 100KB");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';
                        
                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }

                        if (file_names.indexOf(files_tp[0].name) >= 0)
                        {
                            caution_inform("File for thesis proposal already selected");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';
                        
                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }
                    }
                }

                if (_("cemba"))
                {
                    var file_names = "";

                    var files_pr = _("sbtd_pix_pr").files;
                    if ((_("sbtd_pix_pr").files.length == 0 && (_("pr_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_pr").files.length > 0 && files_pr[0].type != "application/pdf"))
                    {
                        caution_inform("PDF file required for payment receipt");
                        _('conf_box_loc').style.zIndex='-1';
                        _('conf_box_loc').style.display='none';

                        _('smke_screen_2').style.zIndex='-1';
                        _('smke_screen_2').style.display='none';
                        return false;
                    }
                    
                    if (_("sbtd_pix_pr").files.length > 0)
                    {
                        if (files_pr[0].size > 100000)
                        {
                            caution_inform("Maximum file size for payment receipt is 100KB");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';
                        
                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }
                    }

                    
                    var files_bc = _("sbtd_pix_bc").files;
                    if ((_("sbtd_pix_bc").files.length == 0 && (_("bc_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_bc").files.length > 0 && files_bc[0].type != "application/pdf"))
                    {
                        caution_inform("PDF file required for birth certificate");
                        _('conf_box_loc').style.zIndex='-1';
                        _('conf_box_loc').style.display='none';

                        _('smke_screen_2').style.zIndex='-1';
                        _('smke_screen_2').style.display='none';
                        return false;
                    }
                    
                    if (_("sbtd_pix_bc").files.length > 0)
                    {
                        if (files_bc[0].size > 100000)
                        {
                            caution_inform("Maximum file size for birth certificate is 100KB");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';
                        
                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }
                    }
                    
                    
                    var files_we = _("sbtd_pix_we").files;
                    if ((_("sbtd_pix_we").files.length == 0 && (_("we_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_we").files.length > 0 && files_we[0].type != "application/pdf"))
                    {
                        caution_inform("PDF file required for evidence of work experience");
                        _('conf_box_loc').style.zIndex='-1';
                        _('conf_box_loc').style.display='none';

                        _('smke_screen_2').style.zIndex='-1';
                        _('smke_screen_2').style.display='none';
                        return false;
                    }
                    
                    if (_("sbtd_pix_we").files.length > 0)
                    {
                        if (files_we[0].size > 100000)
                        {
                            caution_inform("Maximum file size for evidence of work experience is 100KB");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';
                        
                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }
                    }
                }
                
                
                if (_("hsc_cert"))
                {
                    var file_names = "";

                    var files_pr = _("sbtd_pix_pc").files;
                    if ((_("sbtd_pix_pc").files.length == 0 && (_("pc_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_pc").files.length > 0 && files_pr[0].type != "application/pdf"))
                    {
                        caution_inform("PDF file required for professional certificate");
                        _('conf_box_loc').style.zIndex='-1';
                        _('conf_box_loc').style.display='none';

                        _('smke_screen_2').style.zIndex='-1';
                        _('smke_screen_2').style.display='none';
                        return false;
                    }

                    if (_("sbtd_pix_pc").files.length > 0)
                    {
                        if (files_pr[0].size > 100000)
                        {
                            caution_inform("Maximum file size for professional certificate is 100KB");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';
                        
                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }
                    }


                    var files_pr = _("sbtd_pix_nl").files;
                    if ((_("sbtd_pix_nl").files.length == 0 && (_("nl_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_nl").files.length > 0 && files_pr[0].type != "application/pdf"))
                    {
                        caution_inform("PDF file required for professional practicing license");
                        _('conf_box_loc').style.zIndex='-1';
                        _('conf_box_loc').style.display='none';

                        _('smke_screen_2').style.zIndex='-1';
                        _('smke_screen_2').style.display='none';
                        return false;
                    }

                    if (_("sbtd_pix_nl").files.length > 0)
                    {
                        if (files_pr[0].size > 100000)
                        {
                            caution_inform("Maximum file size for professional practicing license is 100KB");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';
                        
                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }
                    }
                }
                
                if (_("b_cert"))
                {
                    var files_pr = _("sbtd_pix_gbc").files;
                    if (_("gbc_uploaded").value == '0' || _('release_form').value == '1' || _("sbtd_pix_gbc").files.length > 0)
                    {            
                        if ((_("sbtd_pix_gbc").files.length == 0 || files_pr[0].type != "application/pdf") && (_("gbc_uploaded").value == '0' || _('release_form').value == '1'))
                        {
                            caution_inform("PDF file required for birth certificate");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';

                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }else if ( _("sbtd_pix_gbc").files.length > 0 && files_pr[0].size > 100000)
                        {
                            caution_inform("Maximum file size for birth certificate is 100KB");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';
                        
                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }
                    }
                }

                if (_("yc_cert"))
                {
                    var files_pr = _("sbtd_pix_yc").files;
                    if (_("yc_uploaded").value == '0' || _('release_form').value == '1' || _("sbtd_pix_yc").files.length > 0)
                    {
                        if ((files_pr[0].type != "application/pdf" || _("sbtd_pix_yc").files.length == 0) && (_("yc_uploaded").value == '0' || _('release_form').value == '1'))
                        {
                            caution_inform("PDF file required for NYSC certificate");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';

                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }else if ( _("sbtd_pix_yc").files.length > 0 && files_pr[0].size > 100000)
                        {
                            caution_inform("Maximum file size for NYSC certificate is 100KB");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';
                        
                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }
                    }
                }

                if (_("m_cert"))
                {
                    var files_pr = _("sbtd_pix_mc").files;
                    if (_("sbtd_pix_mc").files.length > 0)
                    {
                        if (files_pr[0].type != "application/pdf")
                        {
                            caution_inform("PDF file required for marriage certificate");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';

                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }else if ( _("sbtd_pix_mc").files.length > 0 && files_pr[0].size > 100000)
                        {
                            caution_inform("Maximum file size for marriage certificate is 100KB");
                            _('conf_box_loc').style.zIndex='-1';
                            _('conf_box_loc').style.display='none';
                        
                            _('smke_screen_2').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            return false;
                        }
                    }
                }       

                ps.submit_form.value='1'; 
                ps.action='preview-form'; 
                in_progress('1'); 
                ps.submit();
            }
        </script>
	</head>
	<body><?php
        $app_num = '';
        if (isset($_REQUEST["uvApplicationNo"]))
        {
            $app_num = $_REQUEST["uvApplicationNo"];
        }else if (isset($_REQUEST["vApplicationNo"]))
        {
            $app_num = $_REQUEST["vApplicationNo"];
        }
        $stmt = $mysqli->prepare("SELECT f_type FROM pics WHERE cinfo_type = 'C' AND vApplicationNo = ? LIMIT 1");
        $stmt->bind_param("s",$app_num);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($f_type);
        $stmt->fetch();
        $f_type = $f_type ?? '';

        $f_name = '';
        if ($f_type == 'f')
        {
            //compose file name
            $f_name = call_f_file();
        }

        $cEduCtgId_elx = '';

        $stmt = $mysqli->prepare("SELECT cFacultyId, cEduCtgId, cProgrammeId, cSCrnd, jamb_reg_no FROM prog_choice 
        WHERE vApplicationNo = ?");

        if ($_REQUEST['user_cat'] == 6)
        {
            $stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
        }else
        {
            $stmt->bind_param("s", $_REQUEST['vApplicationNo']);
        }
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cFacultyId_old, $cEduCtgId_org, $cProgrammeId_org, $cSCrnd_org, $jamb_reg_no);
        $stmt->fetch();
        $stmt->close();

        if (is_null($cFacultyId_old))
        {
            $cFacultyId_old = '';
        }

        if (is_null($cEduCtgId_org))
        {
            $cEduCtgId_org = '';
        }

        if (is_null($cProgrammeId_org))
        {
            $cProgrammeId_org = '';
        }

        $cEduCtgId_elx = $cEduCtgId_org;

        $ccr_exist = 0;

        if ($cEduCtgId_elx == 'ELX')
        {
            $stmt_last = $mysqli->prepare("SELECT trim(vmask) FROM pics WHERE vApplicationNo  = ? AND cinfo_type = 'ccr'");
            if ($_REQUEST['user_cat'] == 6)
            {
                $stmt_last->bind_param("s", $_REQUEST['uvApplicationNo']);
            }else
            {
                $stmt_last->bind_param("s", $_REQUEST['vApplicationNo']);
            }
            $stmt_last->execute();
            $stmt_last->store_result();
            $stmt_last->bind_result($mask);
            $stmt_last->fetch();
            $stmt_last->close();
            
            if (file_exists("../../ext_docs/ccr/ccr_".$mask.".pdf"))
            {
                $ccr_exist = 1;?>

                <div class="cert_img_container" 
                    id="ccr_container_cover_in" 
                    style="display:none;">
                    <div id="inner_submityes_header0" style="width:50px;
                        height:15px;
                        padding:3px; 
                        float:right; 
                        text-align:right;
                        z-Index:1;">
                            <a id="close_cert_container" href="#"
                                onclick="_('smke_screen_2').style.display = 'none';
                                _('smke_screen_2').style.zIndex = -1;
                                _('ccr_container_cover_in').style.display = 'none';
                                _('ccr_container_cover_in').style.zIndex = -1;
                                return false" 
                                style="color:#666666; margin-right:3px; text-decoration:none;text-shadow: 0 1px 0 #fafafa;">
                                    <img style="width:15px; height:15px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" />
                                </a>
                    </div>
                    
                    <div id="inner_submityes_g1" 
                        style="width:inherit; 
                        height:96%;
                        border-radius:3px; 
                        text-align:center; 
                        float:left;
                        top:15px; 
                        position:absolute;
                        display:block;">
                        <iframe src="<?php echo "../../ext_docs/ccr/ccr_".$mask.".pdf";?>" style="width:95%; height:inherit;" frameborder="0"></iframe>
                    </div>
                </div><?php
            }
        }?>


        <div class="cert_img_container" id="container_cover_in" 
            style="display:none;">
            <div id="inner_submityes_header0" style="width:50px;
                height:15px;
                padding:3px; 
                float:right; 
                text-align:right;
                z-Index:-1;">
                    <a id="close_cert_container" href="#"
                        onclick="_('smke_screen_2').style.display = 'none';
                        _('smke_screen_2').style.zIndex = -1;
                        _('container_cover_in').style.display = 'none';
                        _('container_cover_in').style.zIndex = -1;
                        return false" 
                        style="color:#666666; margin-right:3px; text-decoration:none;text-shadow: 0 1px 0 #fafafa;">
                            <img style="width:15px; height:15px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" />
                        </a>
            </div>
            
            <div id="inner_submityes_g1" 
                style="width:inherit; 
                height:96%;
                border-radius:3px; 
                text-align:center; 
                float:left;
                top:15px; 
                z-index:-1;
                position:absolute;
                display:block;"><?php
                if ($f_type == 'g')
                {?>
                    <img id="credential_img" style="width:100%; height:100%" src=""/><?php
                }else if ($f_type == 'f')
                {?>
                    <iframe id="credential_img" src="<?php echo $f_name;?>" style="width:100%; height:100%;" frameborder="0"></iframe><?php
                }?>
            </div>
        </div><?php
        require_once("feedback_mesages.php");
        require_once("forms.php");
        
        if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] == 6)
        {
            if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '')
            {
                $vApplicationNo = $_REQUEST["uvApplicationNo"]; echo $vApplicationNo;
            }
        }else
        {
            if (isset($_REQUEST["vApplicationNo"]) && $_REQUEST["vApplicationNo"] <> '')
            {
                $vApplicationNo = $_REQUEST["vApplicationNo"];
            }
        }
        
        $ref_table = src_table("prog_choice");
	
        $save_status = '';
        $cEduCtgId = '';
        $release_form = '';

        $stmt = $mysqli->prepare("SELECT release_form FROM $ref_table WHERE vApplicationNo = ?");
        $stmt->bind_param("s", $vApplicationNo);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($release_form);
        $stmt->fetch();
        $stmt->close();

        if (isset($_REQUEST["cReqmtId_1st"]) && isset($_REQUEST["iBeginLevel_1st"]) && isset($_REQUEST["r_saved"]) && $_REQUEST["r_saved"] == '1')
        {            
            move_pp_into_root($cFacultyId_old);
            move_cc_into_root($cFacultyId_old);
            
            
            if (!is_numeric($_REQUEST["cReqmtId_1st"]) || !is_bool(strpos($_REQUEST["cReqmtId_1st"],"un")))
            {
                //caution_box('Something went wrong. Please contact MIS');
                caution_box('Select programme of choice in step 7');
                exit;
            }
            
            try
            {
                $mysqli->autocommit(FALSE); //turn on transactions
            
                $stmt = $mysqli->prepare("UPDATE prog_choice SET  
                cStudyCenterId = ?,
                cFacultyId = ?,
                cProgrammeId = ?,
                cReqmtId = ?,
                iBeginLevel = ?,
                cSbmtd = '0'
                where vApplicationNo = ?");
                $stmt->bind_param("ssssss", $_REQUEST["cStudyCenterId"], 
                $_REQUEST["cFacultyIdold07"], 
                $_REQUEST["selcted_prog_to_send"], 
                $_REQUEST["cReqmtId_1st"], 
                $_REQUEST["iBeginLevel_1st"], 
                $vApplicationNo);
                $stmt->execute();
                $stmt->close();
                
                $stmt2 = $mysqli->prepare("UPDATE criteriadetail SET cUsed = '1' where cCriteriaId = ? and
                sReqmtId = ?");
                $stmt2->bind_param("ss", $_REQUEST["cFacultyIdold07"], $_REQUEST["cReqmtId_1st"]);
                $stmt2->execute();
                $stmt2->close();

                $stmt = $mysqli->prepare("REPLACE INTO empl_hist SET  
                employ_sta = ?,
                vemployer_address = ?,
                vApplicationNo = ?");
                $stmt->bind_param("sss", 
                $_REQUEST["employ_sta"], 
                $_REQUEST["vemployer_address"], 
                $vApplicationNo);
                $stmt->execute();
                $stmt->close();

                log_actv('Updated records choice of programme');
                            
                $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

                $save_status = 'Success';
            }catch(Exception $e)
            {
                $mysqli->rollback(); //remove all queries from queue if error (undo)
                throw $e;
            }
        }

        if ($save_status == 'Success')
        {?>
            <script language="JavaScript" type="text/javascript">
                inform('<?php echo $save_status;?>');
            </script><?php
        }?>

        
        <form method="post" name="doc_ref" id="doc_ref" target="_blank" enctype="multipart/form-data"></form>

        <form action="see-admission-letter" method="post" name="admltr" target="_blank" enctype="multipart/form-data">
            <input name="vApplicationNo" type="hidden" value="<?php if (isset($vApplicationNo)){echo $vApplicationNo;} ?>" />
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
            <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else{echo $cEduCtgId;}?>" />
        </form>			

        <form action="see-admission-letter-phd" method="post" name="admltr_phd" target="_blank" enctype="multipart/form-data">
            <input name="vApplicationNo" type="hidden" value="<?php if (isset($vApplicationNo)){echo $vApplicationNo;} ?>" />
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
            <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else{echo $cEduCtgId;}?>" />
            <input name="tpreg" type="hidden" value="<?php if (isset($_REQUEST["tpreg"])){echo $_REQUEST["tpreg"];}?>" />
        </form>			

        <form action="see-admission-letter-cemba" method="post" name="admltr_cemba" target="_blank" enctype="multipart/form-data">
            <input name="vApplicationNo" type="hidden" value="<?php if (isset($vApplicationNo)){echo $vApplicationNo;} ?>" />
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
            <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else{echo $cEduCtgId;}?>" />
            <input name="tpreg" type="hidden" value="<?php if (isset($_REQUEST["tpreg"])){echo $_REQUEST["tpreg"];}?>" />
        </form>		

        <form action="see-admission-slip" method="post" name="cert_adm_slip" target="_blank" enctype="multipart/form-data">
            <input name="vApplicationNo" type="hidden" value="<?php if (isset($vApplicationNo)){echo $vApplicationNo;} ?>" />
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
            <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="ELX" />
            <input name="tpreg" type="hidden" value="<?php if (isset($_REQUEST["tpreg"])){echo $_REQUEST["tpreg"];}?>" />
        </form>
        
        <div id="smke_screen_2" class="smoke_scrn" style="display:none; z-index:-1"></div>
        
        <div id="conf_box_loc" class="top_most center" 
            style="display:none;
            text-align:center; 
            padding:15px; 
            box-shadow: 2px 2px 8px 2px #726e41;
            z-index:6;
            position:fixed;">
            <div style="width:90%; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                Confirmation
            </div>
            <a href="#" style="text-decoration:none;">
                <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
            </a>
            <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:99%; float:left; text-align:justify; padding:0px;"><?php
                $stmt = $mysqli->prepare("SELECT a.vLastName, a.vFirstName, a.vOtherName, CONCAT(a.vLastName,', ',a.vFirstName,' ',a.vOtherName) my_name, vObtQualTitle, vProgrammeDesc, a.iBeginLevel, a.cEduCtgId, g.vEduCtgDesc, h.dBirthDate, cGender 
                FROM $ref_table a, programme e, obtainablequal f, educationctg g, pers_info h
                WHERE a.cProgrammeId = e.cProgrammeId 
                AND e.cObtQualId = f. cObtQualId 
                AND a.cEduCtgId = g.cEduCtgId
                AND a.vApplicationNo = h.vApplicationNo
                AND a.vApplicationNo = ?");
                $stmt->bind_param("s", $vApplicationNo);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($vLastName, $vFirstName, $vOtherName, $my_name, $vObtQualTitle_db, $vProgrammeDesc_db, $iBeginLevel_db, $cEduCtgId, $vEduCtgDesc, $dBirthDat, $cGender);

                $stmt->fetch();
                $stmt->close();?>

                By submitting this form, I <b><?php echo $my_name;?></b> declare that the pieces of information I have given in this form are correct to the best of my knowledge and that if it is discovered after this point in time that any part is false, my admission stands null and void.<p>
                Submitted form will not be available for editing. Please <b>ensure</b> there are <b>NO</b> mistakes and that all uploaded documents are legible, <b>to avoid delay</b>. <p><?php 
                if (isset($iBeginLevel_db))
                {
                    echo "<b>".$vObtQualTitle_db;
                    if (is_bool(strpos($vProgrammeDesc_db, 'CEM'))){echo ' '.$vProgrammeDesc_db;}
                    if ($cEduCtgId == 'PSZ')
                    {
                        echo ' ['.$iBeginLevel_db."Level]</b>";
                    }else
                    {
                        echo '</b>';
                    }
                }?><p>
                <label for="name_check">
                    <input type="checkbox" id="name_check" name="name_check">&nbsp;
                    The names on this form are mine and they are the same as those on the uploaded credentials<p>
                </label>

                <label for="pix_check">
                    <input type="checkbox" id="pix_check" name="pix_check">&nbsp;
                    I am the one in the uploaded passport picture<p>
                </label>

                <label for="pix_size_check">
                    <input type="checkbox" id="pix_size_check" name="pix_size_check">&nbsp;
                    The uploaded picture is a passport size picture<p>
                </label>

                <label for="pix_time_check">
                    <input type="checkbox" id="pix_time_check" name="pix_time_check">&nbsp;
                    Uploaded passport picture was taken less than three months ago<p>
                </label>
                    
                <label for="prog_check">
                    <input type="checkbox" id="prog_check" name="prog_check">&nbsp;
                    I am okay with the selected programme<p>
                </label>
                    
                <label for="level_check">
                    <input type="checkbox" id="level_check" name="level_check">&nbsp;
                    I am okay with the selected level<p>
                </label><?php
                
                $vProgrammeDesc_db = $vProgrammeDesc_db ?? '';
                
                if (!is_bool(strpos($vProgrammeDesc_db,'Nursing')))
                {?>
                    <label for="nmcn_check">
                        <input type="checkbox" id="nmcn_check" name="nmcn_check">&nbsp;
                        I am a registered Nurse licensed by Nursing and Midwifery Council of Nigeria (NMCN)<p>
                    </label><?php
                }else  if (!is_bool(strpos($vProgrammeDesc_db,'Public Health')))
                {?>
                    <label for="nmcn_check">
                        <input type="checkbox" id="nmcn_check" name="nmcn_check">&nbsp;
                        I am a licensed public health officer<p>
                    </label><?php
                }?>
                Proceed?
            </div>
            <div style="margin-top:10px; width:90%; float:right; text-align:right; padding:0px;">
                <input name="vProgrammeDesc_db" id="vProgrammeDesc_db" type="hidden" value="<?php echo $vProgrammeDesc_db;?>" />
                <a href="#" style="text-decoration:none;" 
                    onclick="submitForm(); return false;
                    return false">
                    <div class="login_button" style="width:60px; padding:6px; margin-left:10px; float:right">
                        Yes
                    </div>
                </a>

                <a href="#" style="text-decoration:none;" 
                    onclick="_('smke_screen_2').style.zIndex='-1';
                    _('smke_screen_2').style.display='none';
                    _('conf_box_loc').style.zIndex='-1';
                    _('conf_box_loc').style.display='none';  return false">
                    <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                        No
                    </div>
                </a>
            </div>
        </div><?php
        //$vLastName, $vFirstName, $vOtherName, $my_name, $vObtQualTitle_db, $vProgrammeDesc_db, $iBeginLevel_db, $cEduCtgId, $vEduCtgDesc, $dBirthDat, $cGender
        $orgsetins = settns();
        
        if (isset($_REQUEST["submit_form"]) && $_REQUEST["submit_form"] == '1' && isset($_REQUEST["old_faculty"]))
        {
            $can_cont = 1;
            $match_found = 0;
            $grad_matno = '';

            if (isset($_REQUEST['first_prog']) && $_REQUEST['first_prog'] <> '')
            {
                $mysqli_arch = link_connect_db_arch();
                $stmt = $mysqli_arch->prepare("SELECT grad FROM arch_s_m_t 
                WHERE vLastName = '$vLastName'
                AND vFirstName = '$vFirstName'
                AND vOtherName = '$vOtherName'
                AND vMatricNo = ?
                AND dBirthDate = '$dBirthDat'
                AND cGender = '$cGender'");
                $stmt->bind_param("s", $_REQUEST['first_prog']);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($grad);
                
                if ($stmt->num_rows > 0)
                {
                    $match_found = $stmt->num_rows;
                    $stmt->fetch();
                    if ($grad <> 2)
                    {
                        $can_cont = 0;
                    }
                }else
                {
                    $stmt = $mysqli->prepare("SELECT vMatricNo FROM s_m_t_grad_mat_list 
                    WHERE vLastName = '$vLastName'
                    AND (vFirstName = '$vFirstName'
                    OR vOtherName = '$vOtherName')
                    AND LEFT(vMatricNo,12) = ?
                    AND cGender = '$cGender'");
                    // $stmt = $mysqli->prepare("SELECT * FROM s_m_t_grad_mat_list 
                    // WHERE vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST['first_prog']);
                    $stmt->execute();
                    $stmt->store_result();
                
                    if ($stmt->num_rows > 0)
                    {
                        $match_found = $stmt->num_rows;
                        $stmt->bind_result($grad_matno);
                        $stmt->fetch();
                        // if ($grad <> 2)
                        // {
                        //     $can_cont = 0;
                        // }else
                        // {
                        //     archive_student_xtra($_REQUEST['first_prog']);
                        // }
                    }
                }
            }
            
            if (isset($_REQUEST['first_prog']) && $_REQUEST['first_prog'] <> '' && $match_found == 0)
            {
                caution_box('Match for matriculation number of NOUN previous programme not found');
            }/*else if ($can_cont == 0)
            {
                caution_box('Previous programme not yet concluded');
            }*/else
            {
                try
                {
                    $mysqli->autocommit(FALSE); //turn on transactions

                    $stmt = $mysqli->prepare("SELECT cFacultyId, cEduCtgId FROM prog_choice 
                    WHERE vApplicationNo = ?");
                    $stmt->bind_param("s", $_REQUEST['vApplicationNo']);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($cFacultyId, $cEduCtgId);
                    $stmt->fetch();
                    
                    // if ($cEduCtgId == 'ELX')
                    // {
                    //     do_fac_tables('elx');    
                    // }else
                    // {
                    //     do_fac_tables($cFacultyId);
                    // }

                    $stmt = $mysqli->prepare("SELECT * FROM afnmatric WHERE vApplicationNo = ?");
                    $stmt->bind_param("s", $_REQUEST['vApplicationNo']);
                    $stmt->execute();
                    $stmt->store_result();
                
                    if ($stmt->num_rows == 0)
                    {
                        if ($cEduCtgId == 'ELX')
                        {
                            if ($cFacultyId == 'CHD')
                            {
                                assign_matno_cert_chd();
                            }else
                            {
                                assign_matno_cert();
                            }
                        }else if (!(isset($_REQUEST['first_prog']) && $_REQUEST['first_prog'] <> ''))
                        {                            
                            assign_matno();
                        }else if (isset($_REQUEST['first_prog']) && $_REQUEST['first_prog'] <> '')
                        {                            
                            assign_matno00($grad_matno);
                        }
                    }else
                    {
                        if (!is_bool(strpos("PGX,PGY,PGZ,PRX", $cEduCtgId)))
                        {
                            //check duplicate file upload

                            $stmt = $mysqli->prepare("INSERT IGNORE INTO prog_choice_pg 
                            SET vApplicationNo = ?,
                            fwdd = '1',
                            date_fwdd = CURDATE()");
                            $stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
                            $stmt->execute();
                        }

                        if (isset($_REQUEST['r_app_record']) && isset($_REQUEST['first_prog']) && $_REQUEST["r_app_record"] == '0')
                        {
                            $stmt = $mysqli->prepare("UPDATE prog_choice SET
                            cSbmtd = '1',
                            first_prog = ?,
                            release_form = '0' 
                            WHERE cSbmtd <> '2' 
                            AND vApplicationNo = ?");
                            $stmt->bind_param("ss", $_REQUEST["first_prog"], $_REQUEST['vApplicationNo']);
                        }else
                        {
                            if ($_REQUEST['cEduCtgId_org'] == 'PSZ')
                            {
                                $stmt = $mysqli->prepare("UPDATE prog_choice SET
                                cSbmtd = '1',
                                release_form = '0',
                                jamb_reg_no	= ? 
                                WHERE cSbmtd <> '2' 
                                AND vApplicationNo = ?");  
                                $stmt->bind_param("ss", $_REQUEST['jambno_frm'], $_REQUEST['vApplicationNo']);  
                            }else
                            {
                                $stmt = $mysqli->prepare("UPDATE prog_choice SET
                                cSbmtd = '1',
                                release_form = '0' 
                                WHERE cSbmtd <> '2' 
                                AND vApplicationNo = ?");
                                $stmt->bind_param("s", $_REQUEST['vApplicationNo']);
                            }
                        }
                        $stmt->execute();
                        
                        log_actv('submitted application form');
                    }
                    $stmt->close();

                    //relocate img file

                    $stmt_last = $mysqli->prepare("SELECT trim(vmask) FROM pics WHERE vApplicationNo = ? AND cinfo_type = 'p'");
                    $stmt_last->bind_param("s", $_REQUEST['vApplicationNo']);
                    $stmt_last->execute();
                    $stmt_last->store_result();
                    $stmt_last->bind_result($vmask);
                    $stmt_last->fetch();
                    $stmt_last->close();

                    $vmask = $vmask ?? '';
                    
                    move_pp_out_of_root($vmask, $cFacultyId);
                    move_cc_out_of_root($cFacultyId);

                    $err_upload = '';
                    if (isset($_REQUEST["post_g"]) || $cEduCtgId == 'PRX' || $cEduCtgId == 'PGZ')
                    {
                        $err_upload = move_pgdoc_out_of_root($cFacultyId);
                        if ($err_upload <> 1)
                        {
                            exit;
                        }
                    }

                    if (isset($_REQUEST["cemba"]))
                    {
                        $err_upload = move_cembadoc_out_of_root($cFacultyId);
                        if ($err_upload <> 1)
                        {
                            exit;
                        }                        
                    }

                    if (isset($_REQUEST["hsc_cert"]))
                    {
                        $err_upload = move_hscert_out_of_root();
                        if ($err_upload <> 1)
                        {
                            exit;
                        }
                    }
                
                    $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
                }catch(Exception $e) 
                {
                    $mysqli->rollback(); //remove all queries from queue if error (undo)
                    throw $e;
                }

                if (is_null($cFacultyId))
                {
                    $cFacultyId = '';
                }
                
                $fac = strtolower($cFacultyId);

                $stmt = $mysqli->prepare("REPLACE INTO a_fac 
                SET vappNo = ?,
                cfacultyId = ?");
                $stmt->bind_param("ss", $_REQUEST["vApplicationNo"], $fac);
                $stmt->execute();
                $stmt->close();
            
            
                $stmt = $mysqli->prepare("SELECT vFirstName my_name, vObtQualTitle, vProgrammeDesc, a.iBeginLevel, e.cProgrammeId 
                FROM prog_choice a, programme e, obtainablequal f
                WHERE a.cProgrammeId = e.cProgrammeId 
                AND e.cObtQualId = f. cObtQualId 
                AND vApplicationNo = ?");
                $stmt->bind_param("s", $vApplicationNo);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($my_name, $vObtQualTitle_db, $vProgrammeDesc_db, $iBeginLevel_db, $cProgrammeId);
                $stmt->fetch();
                $stmt->close();?>

                <div id="smke_screen_3" class="smoke_scrn" style="display:block; z-index:2"></div>
                <div id="success_note" class="center top_most" 
                    style="position:fixed; display:block;
                    text-align:center; 
                    padding:10px; 
                    box-shadow: 2px 2px 8px 2px #726e41; 
                    background:#FFF; 
                    z-index:4;
                    position:fixed;
                    font-size:1em;
                    height:auto;">                
                    <div style="width:350px; float:left; text-align:left; padding:0px; height:23px; line-height:2; margin-top:10px; color:#e31e24; font-weight:bold">
                        Information
                    </div>
                    <a href="#" style="text-decoration:none;">
                        <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
                    </a>
                    
                    <div style="width:99.6%; float:left; text-align:left; padding:0px; height:23px; line-height:2; margin-top:10px; color:#24b533; font-weight:bold;">
                        Success!!!
                    </div><?php 
                    if ($cEduCtgId <> 'ELX')
                    {?>
                        <div style="width:99.6%; float:left; text-align:left; padding:0px; height:40px; line-height:2; margin-top:10px;">
                            Please read and follow the instructions below<br>
                            Print and keep a copy of your application form
                        </div><?php
                    }                
                    
                    if ($vObtQualTitle_db == 'MPhil/PhD,' || $vObtQualTitle_db == 'Ph.D.,')
                    {?>
                        <div style="width:99.6%; float:left; text-align:left; padding:0px; height:85px; line-height:2; margin-top:10px;">
                            You have successfully submitted your application form for <?php echo $vObtQualTitle_db.' '.$vProgrammeDesc_db;?>
                        </div><?php
                    }
                    
                    if ($cProgrammeId == 'MSC415' || $cProgrammeId == 'MSC416')
                    {?>
                        <div style="width:99.6%; float:left; text-align:left; padding:0px; height:40px; line-height:2; margin-top:10px;">
                            You will be invited for an interview via your e-mail or SMS. Date, time and venue will be communicated to you in the invitation
                        </div><?php
                    }
                    
                    
                    if ($cEduCtgId == 'ELX')
                    {
                        $directorate = 'Directorate';
                        if (!is_bool(strpos($cProgrammeId,'DEG')))
                        {
                            $directorate = 'Centre';
                        }?>
                        <div style="width:99.6%; float:left; text-align:left; padding:0px; height:350px; line-height:2; margin-top:10px;">
                        <?php echo "Dear $my_name";?>,<p>
                            Thank you for submitting your application for <?php echo $vObtQualTitle_db.' '.$vProgrammeDesc_db;?> at the National Open University of Nigeria. Your interest in our program is highly appreciated.<p>
                            Please be advised that the <?php echo $directorate;?> will review your application diligently. You will be notified of the outcome in due course. Should you have any queries in the meantime, feel free to reach out to our admissions office.<p>
                            Ensure you logout when you are through<p>
                            Best regards<p>
                            Registrar<br>
                            National Open University of Nigeria
                        </div><?php
                    }else if (!($vObtQualTitle_db == 'MPhil/PhD,' || $vObtQualTitle_db == 'PhD,'))
                    {?>
                        <div style="width:99.6%; float:left; text-align:left; padding:0px; height:40px; line-height:2; margin-top:10px;">
                            Print out a copy of your provisional admission leter and follow the instructions there in. Link to your letter is behind this box
                        </div><?php
                    }
                    
                    if ($vObtQualTitle_db == 'MPhil/PhD,' || $vObtQualTitle_db == 'PhD,')
                    {?>
                        <div style="width:99.6%; float:left; text-align:left; padding:0px; height:35px; line-height:2; margin-top:10px;">
                            Print out your application form, attach your CV, copies of your certificates, research proposal and two reference letters with a cover letter addressed to the Secretary, School of Postgraduate Studies, National Open University of Nigeria, University Village, Plot 91, Cadastral Zone, Nnamdi Azikiwe Expressway, Jabi Abuja- Nigeria. Also endeavour to apply for your academic transcript in your institution to be addressed to the Secretary, School of Postgraduate Studies (<b>Non-Alumni only</b>)
                        </div><?php
                    }
                                                    
                    
                    if ($cEduCtgId <> 'ELX')
                    {?>
                        <div style="width:99.6%; float:left; text-align:left; padding:0px; height:35px; line-height:2; margin-top:10px;">
                            Ensure you logout when you are through
                        </div><?php
                    }?>

                    <div style="width:99.6%; float:left; text-align:left; padding:0px; height:auto;">
                        <a href="#" style="text-decoration:none;" 
                            onclick="_('success_note').style.display='none';
                            _('success_note').style.zIndex='-1';
                            _('smke_screen_3').style.display='none';
                            _('smke_screen_3').style.zIndex='-1';
                            return false">
                            <div class="login_button" style="width:60px; padding:6px; margin-left:6px; float:right">
                                Ok
                            </div>
                        </a>
                    </div>
                </div><?php

                $release_form = '0';
            }
        }
        
        $cAcademicDesc = '';
        $number_of_rec = 0;
        
        if (isset($vApplicationNo) && $vApplicationNo <> '')
        {
            if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
            {
                $mysqli_arch = link_connect_db_arch();
                $stmt = $mysqli_arch->prepare("SELECT cProgrammeId, vEduCtgDesc, cAcademicDesc 
                FROM arch_prog_choice a, educationctg b 
                WHERE a.cEduCtgId  = b.cEduCtgId 
                AND vApplicationNo = ?");
            }else
            {
                $stmt = $mysqli->prepare("SELECT cProgrammeId, vEduCtgDesc, cAcademicDesc 
                FROM $ref_table a, educationctg b 
                WHERE a.cEduCtgId  = b.cEduCtgId 
                AND vApplicationNo = ?");
            }
            $stmt->bind_param("s", $vApplicationNo);
            $stmt->execute();
            $stmt->store_result();
            $number_of_rec = $stmt->num_rows;
            $stmt->bind_result($cProgrammeId, $vEduCtgDesc, $cAcademicDesc);
            $stmt->fetch();
            $stmt->close();

            $cAcademicDesc = $cAcademicDesc ?? '';
        }

        if ($cAcademicDesc == '')
        {
            $cAcademicDesc = $orgsetins["cAcademicDesc"];
        }
        
        if ($number_of_rec == 0)
        {
            caution_box('Record not found');
            exit;
        }?>

        <div class="appl_container" style="width:96vw;">
            <div class="appl_right_div" style="font-size:1em; flex: 100%;">
                    <div class="appl_left_child_div" style="text-align: center; width:99%; margin:auto; background-color: #eff5f0;">
                        <div class="appl_left_child_div_child" style="margin-top:0px; gap:0px; flex-direction:column">
                            <div style="flex:100%; height:auto; text-align:center; background-color: #ffffff">
                                <img width="80" height="92" src="data:image/jpg;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG."left_side_logo.png");?>" alt="NOUN Logo">
                            </div>
                            <div style="flex:100%; height:auto; padding:0px; text-align:center; line-height:normal; font-size:2em; background-color: #ffffff">
                                NATIONAL OPEN UNIVERSITY OF NIGERIA<br>
                                <div style="font-size: 0.5em;">University Village, Plot 9, Cadastral Zone, Nnamdi Azikiwe Express Way, Jabi, Abuja</div>
                            </div>
                            <div style="flex:100%; height:auto; padding:0px; text-align:center; font-size:1.4em; background-color: #ffffff">
                                <?php echo $vEduCtgDesc;?> Application Form for Admission
                            </div>
                            <div style="flex:100%; height:auto; padding:0px; text-align:center; font-size:1.4em; background-color: #ffffff">
                                Form Preview
                            </div>
                        </div><?php
                        if (isset ($_REQUEST["user_cat"]) && ($_REQUEST["user_cat"] == 3 || $_REQUEST["user_cat"] == 1))
                        {?>
                            <div class="appl_left_child_div" style="text-align: left; margin-top:0px; margin-bottom:0px; background-color:#eff5f0">
                                <?php appl_prv_top_menu();?>
                            </div><?php
                        }                        
                        
                        $error_omission = '0';
                        $olevel_num = '0';

                        if (isset($vApplicationNo) && $vApplicationNo <> '')
                        {
                            if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                            {
                                $mysqli_arch = link_connect_db_arch();
                                $stmt = $mysqli_arch->prepare("SELECT vMatricNo FROM arch_afnmatric WHERE vApplicationNo = ?");
                            }else
                            {
                                $stmt = $mysqli->prepare("SELECT vMatricNo FROM afnmatric WHERE vApplicationNo = ?");
                            }
                            $stmt->bind_param("s", $vApplicationNo);
                            $stmt->execute();
                            $stmt->store_result();
                            $has_matric_num = $stmt->num_rows;
                            $stmt->close();

                            if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                            {
                                $mysqli_arch = link_connect_db_arch();
                                $stmt = $mysqli_arch->prepare("SELECT * from arch_applyqual a, qualification b where a.cQualCodeId = b.cQualCodeId AND vApplicationNo = ? AND b.cEduCtgId IN ('OLX','OLY','OLZ')");
                            }else
                            {
                                $stmt = $mysqli->prepare("SELECT * from applyqual a, qualification b where a.cQualCodeId = b.cQualCodeId AND vApplicationNo = ? AND b.cEduCtgId IN ('OLX','OLY','OLZ')");
                            }
                            $stmt->bind_param("s", $vApplicationNo);
                            $stmt->execute();
                            $stmt->store_result();
                            if($stmt->num_rows == 0)
                            {
                                $error_omission = '1';
                            }
                            $olevel_num = $stmt->num_rows;
                            

                            if ((isset($cEduCtgId) && ($cEduCtgId == 'PRX' || $cEduCtgId == 'PGZ')) || (isset($_REQUEST['cEduCtgId']) && ($_REQUEST['cEduCtgId'] == 'PRX' || $_REQUEST['cEduCtgId'] == 'PGZ')))
                            {
                                if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                                {
                                    $mysqli_arch = link_connect_db_arch();
                                    $stmt = $mysqli_arch->prepare("SELECT * from arch_applyqual a, qualification b where a.cQualCodeId = b.cQualCodeId AND vApplicationNo = ? AND b.cEduCtgId IN ('PSZ','PGY','PSX')");
                                }else
                                {
                                    $stmt = $mysqli->prepare("SELECT * from applyqual a, qualification b where a.cQualCodeId = b.cQualCodeId AND vApplicationNo = ? AND b.cEduCtgId IN ('PSZ','PGY','PSX')");
                                }
                                $stmt->bind_param("s", $vApplicationNo);
                                $stmt->execute();
                                $stmt->store_result();
                                if($stmt->num_rows < 2)
                                {
                                    $error_omission = '1';
                                    caution_box('The category of your choice of programme requires that you enter your first and masters degree qualifications. To do this, click on the edit icon above line 32 on this page and follow the guide in the yellow box:');
                                }
                            }                           

                            $stmt = $mysqli->prepare("SELECT trim(vmask) FROM pics WHERE vApplicationNo = ? AND cinfo_type = 'p'");
                            $stmt->bind_param("s", $vApplicationNo);
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($vmask_test);
                            $stmt->fetch();

                            if (is_null($vmask_test))
                            {
                                $error_omission = '1';
                            }

                            $stmt->close();
                        }
                        
                        $submission_status = stbmt_sta('2');
                        $submission_status = $submission_status ?? '0';

                        if ($olevel_num >= 1 && $error_omission == '0' && $submission_status == '0')
                        {?>
                            <div class="appl_left_child_div_child" style="margin-top:10px; gap:0px; flex-direction:column; background-color:#eff5f0">
                                <div id="form_not_sub_div inlin_message_color" style="flex:100%; padding:5px; height:auto; text-align:center; font-size:1.2em; background-color:#fdf0bf">
                                    Form NOT submitted. To submit, scroll to the end of this page, upload remaining relevant documents and click on the submit button
                                </div>
                            </div><?php
                        }else if ($submission_status == '1' || $submission_status == '2')
                        {
                            if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                            {
                                $mysqli_arch = link_connect_db_arch();
                                $stmt = $mysqli_arch->prepare("SELECT vMatricNo FROM arch_afnmatric WHERE vApplicationNo = ?");
                            }else
                            {
                                $stmt = $mysqli->prepare("SELECT vMatricNo FROM afnmatric WHERE vApplicationNo = ?");
                            }
                            $stmt->bind_param("s", $vApplicationNo);
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($vMatricNo);
                            $stmt->fetch();
                            $stmt->close();
                            
                            $stmt = $mysqli->prepare("SELECT * FROM prog_choice_pg WHERE transcript = '1' AND vApplicationNo = ?");
                            $stmt->bind_param("s", $vApplicationNo);
                            $stmt->execute();
                            $stmt->store_result();
                            $submited_trn = $stmt->num_rows;
                            $stmt->close();?>
                            <div class="appl_left_child_div_child" style="margin-top:10px; gap:0px; flex-direction:column; background-color:#eff5f0">
                                <div style="flex:100%; height:auto; text-align:center; font-size:1.2em; color:#24b533;">
                                    Form submitted<?php
                                    if ($vMatricNo <> '' && $submission_status == '2')
                                    {

                                        if ($cEduCtgId == 'ELX')
                                        {
                                            echo "<br>Registration number is <b>$vMatricNo</b>";
                                        }else
                                        {
                                            echo "<br>Matriculation number is <b>$vMatricNo</b>";
                                        }

                                        $verifier = 'Verified credentials for '.$vApplicationNo;
                                        $stmt = $mysqli->prepare("SELECT CONCAT(vLastName,' ',vFirstName,' ',vOtherName), a.vApplicationNo 
                                        FROM atv_log a, userlogin b 
                                        WHERE a.vApplicationNo   = b.vApplicationNo  
                                        AND vDeed = '$verifier'");
                                        
                                        $stmt->execute();
                                        $stmt->store_result();
                                        $number_of_rec = $stmt->num_rows;
                                        $stmt->bind_result($veri_name, $veri_id);
                                        $stmt->fetch();
                                        $stmt->close();

                                        echo "<br>Verified by ".$veri_name.' ['.$veri_id.']';

                                        if ($submited_trn == 0 && ($cEduCtgId == 'PGX' || $cEduCtgId == 'PGY' || $cEduCtgId == 'PGZ' || $cEduCtgId == 'PRX'))
                                        {
                                            $req_prog_cat = '';
                                            if ($cEduCtgId == 'PGX')
                                            {
                                                $req_prog_cat = 'HND or first';
                                            }else if ($cEduCtgId == 'PGY')
                                            {
                                                $req_prog_cat = 'first';
                                            }else if ($cEduCtgId == 'PGZ' || $cEduCtgId == 'PRX')
                                            {
                                                $req_prog_cat = 'Masters';
                                            }?>
                                            <br><font style="color:#e31e24">Your admission process is not complete until the University receives the transacript of your <?php echo $req_prog_cat;?> degree</font><?php
                                        }
                                    }else if ($submited_trn == 0 && ($cProgrammeId_org <> 'MSC415' && $cProgrammeId_org <> 'MSC416') && ($cEduCtgId == 'PGX' || $cEduCtgId == 'PGY' || $cEduCtgId == 'PGZ' || $cEduCtgId == 'PRX'))
                                    {?>
                                        <br><font style="color:#e31e24">Your admission process is not complete until the University receives the transacript of your Masters degree</font><?php
                                    }?>
                                </div>
                            </div><?php
                            
                            $non_phd = (($_REQUEST["user_cat"] == 1 || $_REQUEST["user_cat"] == 3) && $submission_status <> '0' && ($cEduCtgId == 'PSZ' || $cEduCtgId == 'PGY' || $cEduCtgId == 'PGX') && !($cProgrammeId == 'MSC415' || $cProgrammeId == 'MSC416'));

                            
                            $phd = 0;
                            if ($cEduCtgId == 'PGZ' || $cEduCtgId == 'PRX')
                            {
                                $stmt = $mysqli->prepare("SELECT ltr_sent, cSCrnd FROM prog_choice_pg WHERE vApplicationNo = ?");
                                $stmt->bind_param("s", $vApplicationNo);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($ltr_sent, $cSCrnd);
                                $stmt->fetch();
                                $stmt->close();

                                if ($ltr_sent == '1' && ($_REQUEST["user_cat"] == 1 || $_REQUEST["user_cat"] == 3))
                                {
                                    $phd = 1;
                                }
                            }
                            
                            $cemba = (($_REQUEST["user_cat"] == 1 || $_REQUEST["user_cat"] == 3) && ($submission_status == '1' || $submission_status == '2')) && ($cProgrammeId == 'MSC415' || $cProgrammeId == 'MSC416');

                            if ($non_phd == 1 || $phd == 1 || $cemba == 1)
                            {?>
                                <div class="appl_left_child_div_child" style="margin-top:10px; gap:0px; flex-direction:column; background-color:#eff5f0">
                                    <div style="flex:100%; height:auto; text-align:center; font-size:1.2em; color:#24b533;">
                                        <button type="button" class="login_button"
                                        onclick="<?php if ($non_phd == 1)
                                        {
                                            echo 'admltr.submit()';
                                        }else if ($cemba == 1)
                                        {
                                            echo 'admltr_cemba.submit()';
                                        }else if ($phd == 1)
                                        {
                                            echo 'admltr_phd.submit()';
                                        }?>;
                                        return false"><?php 
                                        if (stbmt_sta('3') == '0'){echo 'Print provisional admission letter';}else{echo 'Re-print provisional admission letter';}?></button>
                                    </div>
                                </div><?php
                            }else if ($cEduCtgId == 'ELX' && ($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"]=='3'))
                            {?>
                                <div class="appl_left_child_div_child" style="margin-top:10px; gap:0px; flex-direction:column; background-color:#eff5f0">
                                    <div style="flex:100%; height:auto; text-align:center; font-size:1.2em; color:#24b533;">
                                        <button type="button" class="login_button"
                                        onclick="cert_adm_slip.submit();
                                        return false"><?php 
                                        if (stbmt_sta('3') == '0'){echo 'Print admission slip';}else{echo 'Re-print admission slip';}?></button>
                                    </div>
                                </div><?php
                            }
                        }?>

                        <div class="appl_left_child_div_child" style="margin-top:10px;">
                            <div style="flex:5%; height:auto; background-color: #ffffff"><?php 
                                if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] == 6)
                                {
                                    get_ctry_of_res();
                                }?>
                            </div>
                            <div style="flex:25%; padding-left:5px; height:auto; background-color: #ffffff">
                                Application form number: <b><?php echo $vApplicationNo;?></b>
                            </div>
                            <div style="flex:20%; padding-left:5px; height:auto; background-color: #ffffff">
                                Session: <b><?php echo substr($cAcademicDesc, 0, 4);?></b>
                            </div>
                            <div id="log_div" style="flex:50%; text-indent:5px; height:auto; background-color: #ffffff">
                                <img style="width:135px; height:155px" src="<?php echo get_pp_pix('');?>" alt="biodata">
                            </div>
                        </div><?php
                        $vTitle = ''; 
                        $vLastName = ''; 
                        $vFirstName = ''; 
                        $vOtherName = ''; 
                        $dBirthDate = ''; 
                        $cGender = ''; 
                        $cnin = '';
                        $vDisabilityDesc = '';
                        $vMaritalStatusDesc = '';
                        $cmp_lit = '';
                         
                        $vHomeCityName = ''; 
                        $vLGADesc = ''; 
                        $vStateName = ''; 
                        $vCountryName = '';
                        $pers_info_num = 0;
            
                        if (isset($vApplicationNo) && $vApplicationNo <> '')
                        {
                            if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                            {
                                $mysqli_arch = link_connect_db_arch();
                                $stmt = $mysqli_arch->prepare("SELECT vTitle, 
                                vLastName, 
                                vFirstName, 
                                vOtherName, 
                                dBirthDate, 
                                c.vMaritalStatusDesc, 
                                cGender,
                                cnin,
                                b.vDisabilityDesc,
                                cmp_lit, 
                                vHomeCityName, 
                                f.vLGADesc, 
                                e.vStateName, 
                                d.vCountryName 
                                FROM arch_pers_info a, disability b, maritalstatus c, country d, ng_state e, localarea f
                                WHERE a.cDisabilityId = b.cDisabilityId AND 
                                a.cMaritalStatusId = c.cMaritalStatusId AND 
                                a.cHomeCountryId = d.cCountryId AND
                                a.cHomeStateId = e.cStateId AND
                                a.cHomeLGAId = f.cLGAId AND 
                                vApplicationNo = ?");
                            }else
                            {
                                $stmt = $mysqli->prepare("SELECT vTitle, 
                                vLastName, 
                                vFirstName, 
                                vOtherName, 
                                dBirthDate, 
                                c.vMaritalStatusDesc, 
                                cGender,
                                cnin,
                                b.vDisabilityDesc,
                                cmp_lit, 
                                vHomeCityName, 
                                f.vLGADesc, 
                                e.vStateName, 
                                d.vCountryName 
                                FROM pers_info a, disability b, maritalstatus c, country d, ng_state e, localarea f
                                WHERE a.cDisabilityId = b.cDisabilityId AND 
                                a.cMaritalStatusId = c.cMaritalStatusId AND 
                                a.cHomeCountryId = d.cCountryId AND
                                a.cHomeStateId = e.cStateId AND
                                a.cHomeLGAId = f.cLGAId AND 
                                vApplicationNo = ?");
                            }
                            $stmt->bind_param("s", $vApplicationNo);
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($vTitle, 
                            $vLastName, 
                            $vFirstName, 
                            $vOtherName, 
                            $dBirthDate, 
                            $vMaritalStatusDesc, 
                            $cGender,
                            $cnin,
                            $vDisabilityDesc,
                            $cmp_lit, 
                            $vHomeCityName, 
                            $vLGADesc, 
                            $vStateName, 
                            $vCountryName);
                            
                            $pers_info_num = $stmt->num_rows;

                            $stmt->fetch();
                            $stmt->close();
                        }?>

                        <div class="appl_left_child_div_child">
                            <div style="flex:100%; text-indent:5px; height:30px; padding-top:4px; background-color: #ffffff; text-align:left; font-weight:bold">
                                A. Biodata
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="display:flex; justify-content:flex-end; gap:4px; flex:100%; padding-right:5px; height:30px; padding-top:4px; background-color: #ffffff; text-align:right; font-weight:bold;">
                                <div>
                                    Personal information [1]
                                </div><?php
                                if (($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3') && $submission_status <> '2' && !isset($_REQUEST['internalchk']))
                                {?>
                                    <div>
                                        <a href="#"target="_self" style="text-decoration:none" 
                                            onclick="in_progress('1');
                                                form_sections.sidemenu.value=1;
                                                form_sections.action='appl-biodata_1';
                                                form_sections.submit();
                                                return false;">
                                            <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'edit.png');?>" width="30px" height="29px" title="Click to edit your bio-data" border="0" />
                                        </a>
                                    </div><?php
                                }?>
                            </div>
                        </div>
                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                1
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Title
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vTitle;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                2
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Surname
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vLastName;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                3
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                First name
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vFirstName;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                4
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Other name
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vOtherName;?>
                            </div>
                        </div>
                        
                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                5                                
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                               NIN
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $cnin;?>
                            </div>
                        </div>
                        
                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                6                            
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                               Gender
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $cGender;?>
                            </div>
                        </div>

                        <p style="page-break-after:auto;">&nbsp;</p>
                        
                        <div  class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                7
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Date of birth
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo formatdate($dBirthDate, 'fromdb');?>
                            </div>
                        </div>

                        <div  class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                8
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Marital status
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vMaritalStatusDesc;?>
                            </div>
                        </div>

                        <div  class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                9
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Physical chalenge
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vDisabilityDesc;?>
                            </div>
                        </div>

                        <div  class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                10
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Level of computer litracy
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php if ($cmp_lit == '0')
                                {
                                    echo 'None';
                                }else if ($cmp_lit == '1')
                                {
                                    echo 'Low';
                                }else if ($cmp_lit == '2')
                                {
                                    echo 'Moderate';
                                }else if ($cmp_lit == '3')
                                {
                                    echo 'High';
                                }?>
                            </div>
                        </div>
                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                11
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Nationality
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vCountryName;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                               12
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                State of Origin
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vStateName;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                13
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Local Govt. Area of Origin
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vLGADesc;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                14
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Home Town
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vHomeCityName;?>
                            </div>
                        </div>


                        <div class="appl_left_child_div_child">
                            <div style="flex:100%; display:flex; justify-content:flex-end; gap:4px; padding-right:5px; height:30px; padding-top:4px; background-color: #ffffff; text-align:right; font-weight:bold">
                                <div>
                                    Contact information - Postal address [2]
                                </div><?php
                                    if (($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3') && $submission_status <> '2' && !isset($_REQUEST['internalchk']))
                                    {?>
                                        <div>
                                            <a href="#"target="_self" style="text-decoration:none" 
                                                onclick="in_progress('1');
                                                    form_sections.sidemenu.value=2;
                                                    form_sections.action='postal-address';
                                                    form_sections.submit();
                                                    return false;">
                                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'edit.png');?>" width="30px" height="29px" title="Click to edit your postal address" border="0" />
                                            </a>
                                        </div><?php
                                    }?>
                            </div>
                        </div><?php
                        $vPostalAddress = ''; 
                        $vPostalCityName = ''; 
                        $vPostalLGADesc = ''; 
                        $vPostalStateName = ''; 
                        $vPostalCountryName = ''; 
                        $vEMailId = ''; 
                        $vMobileNo = '';
                        $w_vMobileNo = '';

                        if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                        {
                            $mysqli_arch = link_connect_db_arch();
                            $stmt = $mysqli_arch->prepare("select vPostalAddress, f.vLGADesc, vPostalCityName, e.vStateName, d.vCountryName, vEMailId, vMobileNo, w_vMobileNo
                            from arch_post_addr a, country d, ng_state e, localarea f 
                            where a.cPostalCountryId = d.cCountryId and
                            a.cPostalStateId = e.cStateId and
                            a.cPostalLGAId = f.cLGAId and 
                            vApplicationNo = ?");
                        }else
                        {
                            $stmt = $mysqli->prepare("select vPostalAddress, f.vLGADesc, vPostalCityName, e.vStateName, d.vCountryName, vEMailId, vMobileNo, w_vMobileNo
                            from post_addr a, country d, ng_state e, localarea f 
                            where a.cPostalCountryId = d.cCountryId and
                            a.cPostalStateId = e.cStateId and
                            a.cPostalLGAId = f.cLGAId and 
                            vApplicationNo = ?");
                        }
                        $stmt->bind_param("s", $vApplicationNo);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($vPostalAddress, $vPostalLGADesc, $vPostalCityName, $vPostalStateName, $vPostalCountryName, $vEMailId, $vMobileNo, $w_vMobileNo);
                        $post_addr_num = $stmt->num_rows;
                        $stmt->fetch();
                        $stmt->close();?>


                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                15
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                P. O. Box address
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vPostalAddress;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                16
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Town
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vPostalCityName;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                17
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Local Govt. Area
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vPostalLGADesc;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                18
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                State
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vPostalStateName;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                19
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Country
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vPostalCountryName;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                20
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Personal eMail address
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vEMailId;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                21
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Personal mobile phone
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vMobileNo;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                22
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Whatsapp number
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $w_vMobileNo;?>
                            </div>
                        </div><?php
						
                        $vResidenceAddress = ''; 
                        $vResidenceCityName = ''; 
                        $vResidenceLGADesc = ''; 
                        $vResidenceStateName = ''; 
                        $vResidenceCountryName = ''; 

                        if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                        {
                            $mysqli_arch = link_connect_db_arch();
                            $stmt = $mysqli_arch->prepare("select vResidenceAddress, vResidenceCityName, f.vLGADesc, e.vStateName, d.vCountryName
                            from res_addr a, country d, ng_state e, localarea f 
                            where a.cResidenceCountryId = d.cCountryId and
                            a.cResidenceStateId = e.cStateId and
                            a.cResidenceLGAId = f.cLGAId and vApplicationNo = ?");
                        }else
                        {
                            $stmt = $mysqli->prepare("select vResidenceAddress, vResidenceCityName, f.vLGADesc, e.vStateName, d.vCountryName
                            from res_addr a, country d, ng_state e, localarea f 
                            where a.cResidenceCountryId = d.cCountryId and
                            a.cResidenceStateId = e.cStateId and
                            a.cResidenceLGAId = f.cLGAId and vApplicationNo = ?");
                        }
                        $stmt->bind_param("s", $vApplicationNo);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($vResidenceAddress, $vResidenceCityName, $vResidenceLGADesc, $vResidenceStateName, $vResidenceCountryName);
                        $res_addr_num = $stmt->num_rows;
    
                        $stmt->fetch();
                        $stmt->close();?>

                        <p style="page-break-after:auto;">&nbsp;</p>


                        <div class="appl_left_child_div_child">
                            <div style="flex:100%; display:flex; justify-content:flex-end; gap:4px; padding-right:5px; height:30px; padding-top:4px; background-color: #ffffff; text-align:right; font-weight:bold">
                                <div>
                                    Contact information - Residential address [3]
                                </div><?php
                                    if (($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3') && $submission_status <> '2' && !isset($_REQUEST['internalchk']))
                                    {?>
                                        <div>
                                            <a href="#"target="_self" style="text-decoration:none" 
                                                onclick="in_progress('1');
                                                    form_sections.sidemenu.value=3;
                                                    form_sections.action='residential-address';
                                                    form_sections.submit();
                                                    return false;">
                                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'edit.png');?>" width="30px" height="29px" title="Click to edit your residential address" border="0" />
                                            </a>
                                        </div><?php
                                    }?>
                            </div>
                        </div>


                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                23
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                P. O. Box address
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vResidenceAddress;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                24
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Town
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vResidenceCityName;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                25
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Local Govt. Area
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vResidenceLGADesc;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                26
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                State
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vResidenceStateName;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                27
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Country
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vResidenceCountryName;?>
                            </div>
                        </div><?php 

                        if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                        {
                            $mysqli_arch = link_connect_db_arch();
                            $stmt_1 = $mysqli_arch->prepare("SELECT vNOKName, b.vNOKTypeDesc, vNOKAddress, vNOKEMailId, vNOKMobileNo
                            FROM nextofkin a, noktype b 
                            WHERE a.cNOKType = b.cNOKType
                            AND vApplicationNo = ?");
                        }else
                        {
                            $stmt_1 = $mysqli->prepare("SELECT vNOKName, b.vNOKTypeDesc, vNOKAddress, vNOKEMailId, vNOKMobileNo
                            FROM nextofkin a, noktype b 
                            WHERE a.cNOKType = b.cNOKType
                            AND vApplicationNo = ?");
                        }
                        $stmt_1->bind_param("s", $vApplicationNo);
                        $stmt_1->execute();
                        $stmt_1->store_result();
                        $stmt_1->bind_result($vNOKName, $vNOKTypeDesc, $vNOKAddress, $vNOKEMailId, $vNOKMobileNo);
                        $stmt_1->fetch();?>

                        <div class="appl_left_child_div_child">
                            <div style="flex:100%; display:flex; justify-content:flex-end; gap:4px; padding-right:5px; height:30px; padding-top:4px; background-color: #ffffff; text-align:right; font-weight:bold">
                                <div>
                                    Next of Kin Information [4]
                                </div><?php
                                    if (($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3') && $submission_status <> '2' && !isset($_REQUEST['internalchk']))
                                    {?>
                                        <div>
                                            <a href="#"target="_self" style="text-decoration:none" 
                                                onclick="in_progress('1');
                                                    form_sections.sidemenu.value=4;
                                                    form_sections.action='next-of-kin';
                                                    form_sections.submit();
                                                    return false;">
                                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'edit.png');?>" width="30px" height="29px" title="Click to edit your next of kin" border="0" />
                                            </a>
                                        </div><?php
                                    }?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                28
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Name
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vNOKName;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                29
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Relationship
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vNOKTypeDesc;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                30
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                eMail address
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vNOKEMailId;?>
                            </div>
                        </div>
                        

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                31
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Phone number
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vNOKMobileNo;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:100%; text-indent:5px; height:30px; padding-top:4px; background-color: #ffffff; text-align:left; font-weight:bold">
                                B. Academic history
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:100%; display:flex; justify-content:flex-end; gap:4px; padding-right:5px; height:30px; padding-top:4px; background-color: #ffffff; text-align:right; font-weight:bold">
                                <div>
                                    Qualification(s) [5]
                                </div><?php
                                    if (($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3') && $cSCrnd_org <> '3' && $submission_status <> '2' && !isset($_REQUEST['internalchk']))
                                    {?>
                                        <div>
                                            <a href="#"target="_self" style="text-decoration:none" 
                                                onclick="in_progress('1');
                                                    form_sections.sidemenu.value=5;
                                                    form_sections.action='academic-history';
                                                    form_sections.submit();
                                                    return false;">
                                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'edit.png');?>" width="30px" height="29px" title="Click to edit your academic history" border="0" />
                                            </a>
                                        </div><?php
                                    }?>
                            </div>
                        </div><?php
                        $number = 31;
						$cEduCtgId = ''; 
                        $cQualCodeId = ''; 
                        $vExamSchoolName = ''; 
                        $vExamNo = ''; 
                        $vQualCodeDesc = ''; 
                        $cExamMthYear = ''; 
                        $iQSLCount = ''; 

                        if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                        {
                            $mysqli_arch = link_connect_db_arch();
                            $stmt = $mysqli_arch->prepare("SELECT b.cEduCtgId, b.cQualCodeId, a.vExamSchoolName, a.vExamNo, b.vQualCodeDesc, a.cExamMthYear, c.iQSLCount 
                            FROM arch_applyqual a, qualification b, educationctg c 
                            WHERE a.cQualCodeId = b.cQualCodeId 
                            AND b.cEduCtgId = c.cEduCtgId 
                            AND vApplicationNo = ? ORDER BY right(a.cExamMthYear,4), left(a.cExamMthYear,2)");
                        }else
                        {
                            $stmt = $mysqli->prepare("SELECT b.cEduCtgId, b.cQualCodeId, a.vExamSchoolName, a.vExamNo, b.vQualCodeDesc, a.cExamMthYear, c.iQSLCount 
                            FROM applyqual a, qualification b, educationctg c 
                            WHERE a.cQualCodeId = b.cQualCodeId 
                            AND b.cEduCtgId = c.cEduCtgId 
                            AND vApplicationNo = ? ORDER BY right(a.cExamMthYear,4), left(a.cExamMthYear,2)");
                        }
                        $stmt->bind_param("s", $vApplicationNo);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($cEduCtgId, $cQualCodeId, $vExamSchoolName, $vExamNo, $vQualCodeDesc, $cExamMthYear, $iQSLCount);
                        $coun = $stmt->num_rows;
    
                        $cred_cnt = 0;
                        $prev_cred_cnt = 0;
                        while($stmt->fetch())
                        {						
                            $coun--;$cred_cnt++;
                            
                            $post_str = '';?>

                            <div id="cert_qual_div<?php echo $cred_cnt; ?>" class="appl_left_child_div_child" style="margin-top: 15px;">
                                <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #eff5f0">
                                    <?php echo ++$number;?>
                                </div>
                                <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #eff5f0">
                                    Qualification
                                </div>
                                <div style="flex:60%; height:30px; padding-top:4px; text-indent:4px; background-color: #eff5f0">
                                    <?php echo stripslashes($vQualCodeDesc);?>
                                </div>
                                <div style="flex:10%; height:30px; padding-top:4px; text-align:right; background-color: #eff5f0">
                                    <a href="#"target="_self" style="text-decoration:none" 
                                        onclick="ps.vExamNo.value='<?php echo $vExamNo; ?>';
                                            ps.cQualCodeId.value='<?php echo $cQualCodeId; ?>';
                                            call_image();
                                            return false;">
                                        <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'certificate.png');?>" width="30px" height="29px" style="margin-right:8px;" title="Click to see uploaded copy of certificate" border="0" />
                                    </a>
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #eff5f0">
                                    <?php echo ++$number;?>
                                </div>
                                <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #eff5f0">
                                    Examination number
                                </div>
                                <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #eff5f0">
                                    <?php echo $vExamNo;?>
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #eff5f0">
                                    <?php echo ++$number;?>
                                </div>
                                <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #eff5f0">
                                    Centre/School Name
                                </div>
                                <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #eff5f0">
                                    <?php echo ucwords(strtolower(stripslashes($vExamSchoolName)))?>
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #eff5f0">
                                    <?php echo ++$number;?>
                                </div>
                                <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #eff5f0">
                                    Qualification date (mmyyyy)
                                </div>
                                <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #eff5f0">
                                    <?php echo $cExamMthYear;?>
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child appl_left_child_div_child_1">
                                <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                    Sno.
                                </div>
                                <div style="flex:25%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                    Subject
                                </div>
                                <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                    Grade
                                </div>
                            </div><?php

                            if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                            {
                                $mysqli_arch = link_connect_db_arch();
                                $stmt2 = $mysqli_arch->prepare("SELECT b.vQualSubjectDesc, c.cQualGradeCode FROM applysubject a, qualsubject b, qualgrade c
                                WHERE a.cQualSubjectId = b.cQualSubjectId and
                                a.cQualCodeId = '$cQualCodeId' and
                                a.vExamNo = '$vExamNo' and
                                a.cQualGradeId = c.cQualGradeId and
                                vApplicationNo = ?");
                            }else
                            {
                                $stmt2 = $mysqli->prepare("SELECT b.vQualSubjectDesc, c.cQualGradeCode FROM applysubject a, qualsubject b, qualgrade c
                                WHERE a.cQualSubjectId = b.cQualSubjectId and
                                a.cQualCodeId = '$cQualCodeId' and
                                a.vExamNo = '$vExamNo' and
                                a.cQualGradeId = c.cQualGradeId and
                                vApplicationNo = ?");
                            }
							$stmt2->bind_param("s", $vApplicationNo);
							$stmt2->execute();
							$stmt2->store_result();
							$stmt2->bind_result($vQualSubjectDesc, $cQualGradeCode);
							$num_qual_sbj = $stmt2->num_rows;
                            $subject_coun = 0;
                            while($stmt2->fetch())
							{?>
                                <div class="appl_left_child_div_child appl_left_child_div_child_1">
                                    <div style="flex:5%; text-indent:4px; padding-top:4px; height:30px; background-color: #ffffff">
                                        <?php echo ++$subject_coun;?>
                                    </div>
                                    <div style="flex:25%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                        <?php echo ucwords(strtolower(stripslashes($vQualSubjectDesc)));?>
                                    </div>
                                    <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                        <?php echo stripslashes($cQualGradeCode);?>
                                    </div>
                                </div><?php
                            }
                        }
                        
                        if ($ccr_exist == 1)
                        {?>
                            <div id="cert_qual_div<?php echo $cred_cnt; ?>" class="appl_left_child_div_child" style="margin-top: 15px;">
                                <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #eff5f0">
                                    <?php echo ++$number;?>
                                </div>
                                <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #eff5f0">
                                    Complementary qualification
                                </div>
                                <div style="flex:60%; height:30px; padding-top:4px; text-indent:4px; background-color: #eff5f0">
                                    Complementary qualification
                                </div>
                                <div style="flex:10%; height:30px; padding-top:4px; text-align:right; background-color: #eff5f0">
                                    <a href="#"target="_self" style="text-decoration:none" 
                                        onclick="_('ccr_container_cover_in').style.zIndex = 3;
                                        _('ccr_container_cover_in').style.display='block';
                                        _('close_cert_container').focus();
                                        return false;">
                                        <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'certificate.png');?>" 
                                            width="30px" 
                                            height="29px" 
                                            style="margin-right:8px;" 
                                            title="Click to see uploaded copy of certificate" border="0" />
                                    </a>
                                </div>
                            </div><?php
                        }?>

                        <div class="appl_left_child_div_child">
                            <div style="flex:100%; padding-right:5px; display:flex; justify-content:flex-end; gap:4px; height:30px; padding-top:4px; background-color: #ffffff; text-align:right; font-weight:bold">
                               <div>
                                    Choice of programme [6]
                                </div><?php
                                    if (($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3') && $submission_status <> '2' && $cSCrnd_org <> '3' && !isset($_REQUEST['internalchk']))
                                    {?>
                                        <div>
                                            <a href="#"target="_self" style="text-decoration:none" 
                                                onclick="in_progress('1');
                                                    form_sections.sidemenu.value=6;
                                                    form_sections.action='programme-of-choice';
                                                    form_sections.submit();
                                                    return false;">
                                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'edit.png');?>" width="30px" height="29px" title="Click to edit your choice of programme, centre etc." border="0" />
                                            </a>
                                        </div><?php
                                    }?>
                            </div>
                        </div><?php
                        $vCityName = ''; 
                        $vFacultyDesc = ''; 
                        $vdeptDesc = ''; 
                        $vObtQualTitle = ''; 
                        $vProgrammeDesc = ''; 
                        $iBeginLevel = ''; 
                        $cStudyCenterId = ''; 
                        $cFacultyId = '';

                        if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                        {
                            $mysqli_arch = link_connect_db_arch();

                            $stmt = $mysqli_arch->prepare("SELECT vCityName, vFacultyDesc, e.vdeptDesc, vObtQualTitle, vProgrammeDesc, a.iBeginLevel, b.cStudyCenterId, a.cFacultyId
                            FROM arch_prog_choice a, studycenter b, faculty c, programme d, depts e, obtainablequal f 
                            WHERE a.cStudyCenterId = b.cStudyCenterId 
                            AND a.cFacultyId = c.cFacultyId 
                            AND d.cProgrammeId = a.cProgrammeId
                            AND d.cObtQualId = f. cObtQualId
                            AND d.cdeptId = e.cdeptId 
                            AND vApplicationNo = ?");
                        }else
                        {
                            $stmt = $mysqli->prepare("SELECT vCityName, vFacultyDesc, e.vdeptDesc, vObtQualTitle, vProgrammeDesc, a.iBeginLevel, b.cStudyCenterId, a.cFacultyId, first_prog
                            FROM $ref_table a, studycenter b, faculty c, programme d, depts e, obtainablequal f 
                            WHERE a.cStudyCenterId = b.cStudyCenterId 
                            AND a.cFacultyId = c.cFacultyId 
                            AND d.cProgrammeId = a.cProgrammeId
                            AND d.cObtQualId = f. cObtQualId
                            AND d.cdeptId = e.cdeptId 
                            AND vApplicationNo = ?");
                        }
                        $stmt->bind_param("s", $vApplicationNo);
                        $stmt->execute();
                        $stmt->store_result();
                        $number_of_record = $stmt->num_rows;
                        $stmt->bind_result($vCityName, $vFacultyDesc, $vdeptDesc, $vObtQualTitle, $vProgrammeDesc, $iBeginLevel, $cStudyCenterId, $cFacultyId, $first_prog);
                        $stmt->fetch();
                        $stmt->close();?>
                        
                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                <?php echo ++$number;?>
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Study Centre
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vCityName;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                <?php echo ++$number;?>
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Faculty
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php echo $vFacultyDesc;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                <?php echo ++$number;?>
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Department
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php if (!is_bool(strpos($vdeptDesc, 'CEMBA')))
                                    {
                                        echo 'CEMBA/CEMPA';
                                    }else
                                    {
                                        echo ucwords(strtolower($vdeptDesc));
                                    }?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                <?php echo ++$number;?>
                            </div>
                            <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                Programme
                            </div>
                            <div style="flex:70%; height:30px; padding-top:4px; text-indent:4px; background-color: #ffffff">
                                <?php 
                                if (is_bool(strpos($vProgrammeDesc, 'CEM')))
                                {
                                    echo substr($vObtQualTitle, 0, strlen($vObtQualTitle)-0) . ' '.$vProgrammeDesc;
                                }else if (!is_bool(strpos($vProgrammeDesc, 'CEMBA')))
                                {
                                    echo ' Commonwealth Executive Masters of Business Administration (CEMBA)';
                                }else if (!is_bool(strpos($vProgrammeDesc, 'CEMPA')))
                                {
                                    echo ' Commonwealth Executive Masters of Public Administration (CEMPA)';
                                }

                                if ((isset($cEduCtgId_org) && $cEduCtgId_org == 'PSZ') || (isset($_REQUEST['cEduCtgId']) && $_REQUEST['cEduCtgId'] == 'PSZ'))
                                {
                                    echo ' ['.$iBeginLevel."Level]";
                                }?>
                            </div>
                        </div><?php 
                        if ($cEduCtgId_org == 'PSZ')
                        {?>
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                    <?php echo ++$number;?>
                                </div>
                                <div style="flex:25%; text-indent:5px; padding-top:4px; height:30px; background-color: #ffffff">
                                    JAMB registration number
                                </div>
                                <div style="flex:70%; height:30px; background-color: #ffffff"><?php
                                    if (($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3') && $submission_status <> '2' && $cSCrnd_org <> '3' && !isset($_REQUEST['internalchk']))
                                    {?>
                                        <input name="jambno" id="jambno" type="text"
                                            onchange="this.value=this.value.trim();
                                            this.value=this.value.toUpperCase();
                                            this.value=this.value.replace(/ /g, '');
                                            ps.jambno_frm.value=this.value;"
                                            maxlength="20"
                                            autocomplete="off"
                                            placeholder="For undergraduate application only"
                                            value="<?php echo $jamb_reg_no;?>"/><?php
                                    }else
                                    {
                                        echo $jamb_reg_no;
                                    }?>
                                </div>
                            </div><?php
                        }?>
                        
                        <form method="post" name="ps" enctype="multipart/form-data">
                            <input name="vApplicationNo" type="hidden" value="<?php if (isset($vApplicationNo)){echo $vApplicationNo;} ?>" />
                            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
                            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
                            <input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php if (isset($_REQUEST["passpotLoaded"])){echo $_REQUEST["passpotLoaded"];}?>">
                            <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />
                            <input name="submit_form" id="submit_form" type="hidden" value="0" />
                            
                            <input name="old_faculty" id="old_faculty" type="hidden" value="<?php if (isset($_REQUEST["old_faculty"]) && $_REQUEST["old_faculty"] <> ''){echo $_REQUEST["old_faculty"];}else{echo $cFacultyId_old;} ?>" />

                            <input name="cdeptold7_1st" id="cdeptold7_1st" type="hidden" value="<?php if (isset($_REQUEST["cdeptold7_1st"])){echo $_REQUEST["cdeptold7_1st"];} ?>" />

                            <input name="vExamNo" id="vExamNo" type="hidden" />
                            <input name="cQualCodeId" id="cQualCodeId" type="hidden" />
                            <input name="loadcred" id="loadcred" type="hidden" />
                            <input name="release_form" id="release_form" type="hidden"  value="<?php echo $release_form;?>"/>

                            <input name="cEduCtgId_org" id="cEduCtgId_org" type="hidden" value="<?php echo $cEduCtgId_org;?>"/>
                            <input name="jambno_frm" id="jambno_frm" type="hidden" value="<?php echo $jamb_reg_no;?>"/>
                            
                            <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else{echo $cEduCtgId;}?>" />
                            <input name="fil_ex" id="fil_ex" type="hidden" value="<?php echo $f_type; ?>" /><?php
                        
                            if ($vObtQualTitle == 'M. Phil.,' || $vObtQualTitle == 'Ph.D.,')
                            {
                                if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                                {
                                    $mysqli_arch = link_connect_db_arch();
                                    $stmt = $mysqli_arch->prepare("SELECT cinfo_type, vmask FROM pics WHERE vApplicationNo = ? AND cinfo_type NOT IN ('p','c')");
                                }else
                                {
                                    $stmt = $mysqli->prepare("SELECT cinfo_type, vmask FROM pics WHERE vApplicationNo = ? AND cinfo_type NOT IN ('p','c')");		
                                }
                                $stmt->bind_param("s", $vApplicationNo);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($cinfo_type, $mask);

                                $payment_r = '';
                                $mask_r = '';

                                $curr_v = '';
                                $mask_v = '';

                                $ref_ltr1 = '';
                                $mask_ltr1 = '';

                                $ref_ltr2 = '';
                                $mask_ltr2 = '';

                                $thesis_pr = '';
                                $mask_pr = '';

                                while($stmt->fetch())
                                {
                                    if ($cinfo_type == 'pr')
                                    {
                                        $payment_r = $cinfo_type;
                                        $mask_r = $mask;
                                    }else if ($cinfo_type == 'cv')
                                    {
                                        $curr_v = $cinfo_type;
                                        $mask_v = $mask;
                                    }else if ($cinfo_type == 'rl1')
                                    {
                                        $ref_ltr1 = $cinfo_type;
                                        $mask_ltr1 = $mask;
                                    }else if ($cinfo_type == 'rl2')
                                    {
                                        $ref_ltr2 = $cinfo_type;
                                        $mask_ltr2 = $mask;
                                    }else if ($cinfo_type == 'tp')
                                    {
                                        $thesis_pr = $cinfo_type;
                                        $mask_pr = $mask;
                                    }
                                }
                                $stmt->close();?>						
                                <input name="post_g" id="post_g" type="hidden" value="1" />                                
                                
                                <div class="appl_left_child_div_child" style="margin-top:10px; gap:0px; flex-direction:column; background-color:#fdf0bf">
                                    <div id="form_not_sub_div inlin_message_color" style="flex:100%; padding:5px; height:auto; text-align:center;">
                                        Upload the following documents in PDF format.
                                    </div>
                                </div>

                                <div class="appl_left_child_div_child">
                                    <div style="flex:5%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        1
                                    </div>
                                    <div style="flex:25%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        Payment receipt
                                    </div>
                                    <div style="flex:70%; height:auto; padding-top:4px; text-indent:4px; background-color: #ffffff"><?php
                                         $f_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/pr_".$mask_r.".pdf";

                                        if ($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3')
                                        {
                                            if ($submission_status <> '2')
                                            {?>
                                                <input type="file" name="sbtd_pix_pr" id="sbtd_pix_pr" style="width:180px" 
                                                    title="Max size: 100KB, Format: PDF"><?php
                                            }

                                            if (($submission_status == '1' || $submission_status == '2') && $payment_r == 'pr' && file_exists($f_name) && $release_form == '0')
                                            {
                                                echo ' Uploaded. ';?>

                                                <a href="#" style="text-decoration:none;"
                                                    onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                    _('doc_ref').submit();
                                                    return false">
                                                    <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                        View
                                                    </div>
                                                </a><?php
                                            }?>
                                            <input name="pr_uploaded" id="pr_uploaded" type="hidden" value="<?php if ($payment_r == 'pr' && file_exists($f_name)){echo '1';}else{echo '0';}?>"required /><?php
                                        }else if (file_exists($f_name) && ($_REQUEST["user_cat"] == '5' || $_REQUEST["user_cat"] == '6'))
                                        {?>
                                            <a href="#" style="text-decoration:none;"
                                                onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                _('doc_ref').submit();
                                                return false">
                                                <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                    View
                                                </div>
                                            </a><?php
                                        }?>
                                    </div>
                                </div>
                                

                                <div class="appl_left_child_div_child">
                                    <div style="flex:5%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        2
                                    </div>
                                    <div style="flex:25%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        Curriculum vitae
                                    </div>
                                    <div style="flex:70%; height:auto; padding-top:4px; text-indent:4px; background-color: #ffffff"><?php
                                        $f_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/cv_".$mask_v.".pdf";

                                        if ($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3')
                                        {
                                            if ($submission_status <> '2')
                                            {?>
                                                <input type="file" name="sbtd_pix_cv" id="sbtd_pix_cv" style="width:180px" 
                                                title="Max size: 150KB, Format: PDF"><?php
                                            }
                                            
                                            if (($submission_status == '1' || $submission_status == '2') && $curr_v == 'cv' && file_exists($f_name) && $release_form == '0')
                                            {
                                                echo ' Uploaded. ';?>
                                                <a href="#" style="text-decoration:none;"
                                                    onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                    _('doc_ref').submit();
                                                    return false">
                                                    <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                        View
                                                    </div>
                                                </a><?php
                                            }?>
                                            <input name="cv_uploaded" id="cv_uploaded" type="hidden" value="<?php if ($curr_v == 'cv' && file_exists($f_name)){echo '1';}else{echo '0';}?>" required/><?php
                                        }else if (file_exists($f_name) && ($_REQUEST["user_cat"] == '5' || $_REQUEST["user_cat"] == '6'))
                                        {?>
                                            <a href="#" style="text-decoration:none;"
                                                onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                _('doc_ref').submit();
                                                return false">
                                                <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                    View
                                                </div>
                                            </a><?php
                                        }?>
                                    </div>
                                </div>
                                

                                <div class="appl_left_child_div_child">
                                    <div style="flex:5%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        3
                                    </div>
                                    <div style="flex:25%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        Reference letter 1
                                    </div>
                                    <div style="flex:70%; height:auto; padding-top:4px; text-indent:4px; background-color: #ffffff"><?php
                                        $f_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/rl1_".$mask_ltr1.".pdf";

                                        if ($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3')
                                        {
                                            if ($submission_status <> '2')
                                            {?>
                                                <input type="file" name="sbtd_pix_rl1" id="sbtd_pix_rl1" style="width:180px" 
                                                title="Max size: 100KB, Format: PDF"><?php
                                            }
                                            
                                            if (($submission_status == '1' || $submission_status == '2') && $ref_ltr1 == 'rl1' && file_exists($f_name) && $release_form == '0')
                                            {
                                                echo ' Uploaded. ';?>
                                                <a href="#" style="text-decoration:none;"
                                                    onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                    _('doc_ref').submit();
                                                    return false">
                                                    <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                        View
                                                    </div>
                                                </a><?php
                                            }?>
                                            <input name="rl1_uploaded" id="rl1_uploaded" type="hidden" value="<?php if ($ref_ltr1 == 'rl1' && file_exists($f_name)){echo '1';}else{echo '0';}?>" required/><?php
                                        }else if (file_exists($f_name) && ($_REQUEST["user_cat"] == '5' || $_REQUEST["user_cat"] == '6'))
                                        {?>
                                            <a href="#" style="text-decoration:none;"
                                                onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                _('doc_ref').submit();
                                                return false">
                                                <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                    View
                                                </div>
                                            </a><?php
                                        }?>
                                    </div>
                                </div>
                                

                                <div class="appl_left_child_div_child">
                                    <div style="flex:5%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        4
                                    </div>
                                    <div style="flex:25%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        Reference letter 2
                                    </div>
                                    <div style="flex:70%; height:auto; padding-top:4px; text-indent:4px; background-color: #ffffff"><?php
                                        $f_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/rl2_".$mask_ltr2.".pdf";

                                        if ($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3')
                                        {
                                            if ($submission_status <> '2')
                                            {?>
                                                <input type="file" name="sbtd_pix_rl2" id="sbtd_pix_rl2" style="width:180px" 
                                                title="Max size: 100KB, Format: PDF"><?php
                                            }
                                            if (($submission_status == '1' || $submission_status == '2') && $ref_ltr2 == 'rl2' && file_exists($f_name) && $release_form == '0')
                                            {
                                                echo ' Uploaded. ';?>
                                                <a href="#" style="text-decoration:none;"
                                                    onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                    _('doc_ref').submit();
                                                    return false">
                                                    <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                        View
                                                    </div>
                                                </a><?php
                                            }?>
                                            <input name="rl2_uploaded" id="rl2_uploaded" type="hidden" value="<?php if ($ref_ltr2 == 'rl2' && file_exists($f_name)){echo '1';}else{echo '0';}?>" required /><?php
                                        }else if (file_exists($f_name) && ($_REQUEST["user_cat"] == '5' || $_REQUEST["user_cat"] == '6'))
                                        {?>
                                            <a href="#" style="text-decoration:none;"
                                                onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                _('doc_ref').submit();
                                                return false">
                                                <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                    View
                                                </div>
                                            </a><?php
                                        }?>
                                    </div>
                                </div>
                                

                                <div class="appl_left_child_div_child">
                                    <div style="flex:5%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        5
                                    </div>
                                    <div style="flex:25%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        Thesis proposal
                                    </div>
                                    <div style="flex:70%; height:auto; padding-top:4px; text-indent:4px; background-color: #ffffff"><?php
                                        $f_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/tp_".$mask_pr.".pdf";

                                        if ($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3')
                                        {
                                            if ($submission_status <> '2')
                                            {?>
                                                <input type="file" name="sbtd_pix_tp" id="sbtd_pix_tp" style="width:180px" 
                                                    title="Max size: 150KB, Format: PDF"><?php
                                            }
                                            if (($submission_status == '1' || $submission_status == '2') && $thesis_pr == 'tp' && file_exists($f_name) && $release_form == '0')
                                            {
                                                echo ' Uploaded. ';?>
                                                <a href="#" style="text-decoration:none;"
                                                    onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                    _('doc_ref').submit();
                                                    return false">
                                                    <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                        View
                                                    </div>
                                                </a><?php
                                            }?>
                                            <input name="tp_uploaded" id="tp_uploaded" type="hidden" value="<?php if ($thesis_pr == 'tp' && file_exists($f_name)){echo '1';}else{echo '0';}?>" required/><?php
                                        }else if (file_exists($f_name) && ($_REQUEST["user_cat"] == '5' || $_REQUEST["user_cat"] == '6'))
                                        {?>
                                            <a href="#" style="text-decoration:none;"
                                                onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                _('doc_ref').submit();
                                                return false">
                                                <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                    View
                                                </div>
                                            </a><?php
                                        }?>
                                    </div>
                                </div><?php
                            }



                            if ($vObtQualTitle == 'CEMBA' || $vObtQualTitle == 'CEMPA')
                            {
                                if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                                {
                                    $mysqli_arch = link_connect_db_arch();
                                    $stmt = $mysqli_arch->prepare("SELECT cinfo_type, vmask FROM pics WHERE vApplicationNo = ? AND cinfo_type NOT IN ('p','c')");
                                }else
                                {
                                    $stmt = $mysqli->prepare("SELECT cinfo_type, vmask FROM pics WHERE vApplicationNo = ? AND cinfo_type NOT IN ('p','c')");		
                                }
                                $stmt->bind_param("s", $vApplicationNo);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($cinfo_type, $mask);

                                $payment_r = '';
                                $mask_r = '';

                                $curr_bc = '';
                                $mask_bc = '';

                                $ref_we = '';
                                $mask_we = '';

                                while($stmt->fetch())
                                {
                                    if ($cinfo_type == 'pr')
                                    {
                                        $payment_r = $cinfo_type;
                                        $mask_r = $mask;
                                    }else if ($cinfo_type == 'bc')
                                    {
                                        $curr_bc = $cinfo_type;
                                        $mask_bc = $mask;
                                    }else if ($cinfo_type == 'we')
                                    {
                                        $ref_we = $cinfo_type;
                                        $mask_we = $mask;
                                    }
                                }
                                $stmt->close();?>		
                                <input name="cemba" id="cemba" type="hidden" value="1" />
                                
                                <div class="appl_left_child_div_child" style="margin-top:10px; gap:0px; flex-direction:column; background-color:#fdf0bf">
                                    <div id="form_not_sub_div inlin_message_color" style="flex:100%; padding:5px; height:auto; text-align:center;">
                                        Upload the following documents in PDF format. Maximum size for each file is 100KB.
                                    </div>
                                </div>

                                <div class="appl_left_child_div_child">
                                    <div style="flex:5%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        1
                                    </div>
                                    <div style="flex:25%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        Payment receipt
                                    </div>
                                    <div style="flex:70%; height:auto; padding-top:4px; text-indent:4px; background-color: #ffffff"><?php
                                         $f_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/pr_".$mask_r.".pdf";

                                        if ($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3')
                                        {
                                            if ($submission_status <> '2')
                                            {?>
                                                <input type="file" name="sbtd_pix_pr" id="sbtd_pix_pr" style="width:180px" 
                                                    title="Max size: 100KB, Format: PDF"><?php
                                            }

                                            if (($submission_status == '1' || $submission_status == '2') && $payment_r == 'pr' && file_exists($f_name) && $release_form == '0')
                                            {
                                                echo ' Uploaded. ';?>

                                                <a href="#" style="text-decoration:none;"
                                                    onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                    _('doc_ref').submit();
                                                    return false">
                                                    <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                        View
                                                    </div>
                                                </a><?php
                                            }?>
                                            <input name="pr_uploaded" id="pr_uploaded" type="hidden" value="<?php if ($payment_r == 'pr' && file_exists($f_name)){echo '1';}else{echo '0';}?>"required /><?php
                                        }else if (file_exists($f_name) && ($_REQUEST["user_cat"] == '5' || $_REQUEST["user_cat"] == '6'))
                                        {?>
                                            <a href="#" style="text-decoration:none;"
                                                onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                _('doc_ref').submit();
                                                return false">
                                                <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                    View
                                                </div>
                                            </a><?php
                                        }?>
                                    </div>
                                </div>
                                
                                
                                <div class="appl_left_child_div_child">
                                    <div style="flex:5%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        2
                                    </div>
                                    <div style="flex:25%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        Birth certificate
                                    </div>
                                    <div style="flex:70%; height:auto; padding-top:4px; text-indent:4px; background-color: #ffffff"><?php
                                        $f_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/bc_".$mask_bc.".pdf";

                                        if ($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3')
                                        {
                                            if ($submission_status <> '2')
                                            {?>
                                                <input type="file" name="sbtd_pix_bc" id="sbtd_pix_bc" style="width:180px" 
                                                title="Max size: 100KB, Format: PDF"><?php
                                            }
                                            
                                            if (($submission_status == '1' || $submission_status == '2') && $curr_bc == 'bc' && file_exists($f_name) && $release_form == '0')
                                            {
                                                echo ' Uploaded. ';?>
                                                <a href="#" style="text-decoration:none;"
                                                    onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                    _('doc_ref').submit();
                                                    return false">
                                                    <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                        View
                                                    </div>
                                                </a><?php
                                            }?>
                                            <input name="bc_uploaded" id="bc_uploaded" type="hidden" value="<?php if ($curr_bc == 'bc' && file_exists($f_name)){echo '1';}else{echo '0';}?>" required/><?php
                                        }else if (file_exists($f_name) && ($_REQUEST["user_cat"] == '5' || $_REQUEST["user_cat"] == '6'))
                                        {?>
                                            <a href="#" style="text-decoration:none;"
                                                onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                _('doc_ref').submit();
                                                return false">
                                                <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                    View
                                                </div>
                                            </a><?php
                                        }?>
                                    </div>
                                </div>
                                

                                <div class="appl_left_child_div_child">
                                    <div style="flex:5%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        3
                                    </div>
                                    <div style="flex:25%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        Evidence of work experience
                                    </div>
                                    <div style="flex:70%; height:auto; padding-top:4px; text-indent:4px; background-color: #ffffff"><?php
                                        $f_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/we_".$mask_we.".pdf";

                                        if ($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3')
                                        {
                                            if ($submission_status <> '2')
                                            {?>
                                                <input type="file" name="sbtd_pix_we" id="sbtd_pix_we" style="width:180px" 
                                                title="Max size: 100KB, Format: PDF"><?php
                                            }
                                            
                                            if (($submission_status == '1' || $submission_status == '2') && $ref_we == 'we' && file_exists($f_name) && $release_form == '0')
                                            {
                                                echo ' Uploaded. ';?>
                                                <a href="#" style="text-decoration:none;"
                                                    onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                    _('doc_ref').submit();
                                                    return false">
                                                    <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                        View
                                                    </div>
                                                </a><?php
                                            }?>
                                            <input name="we_uploaded" id="we_uploaded" type="hidden" value="<?php if ($ref_we == 'we' && file_exists($f_name)){echo '1';}else{echo '0';}?>" required/><?php
                                        }else if (file_exists($f_name) && ($_REQUEST["user_cat"] == '5' || $_REQUEST["user_cat"] == '6'))
                                        {?>
                                            <a href="#" style="text-decoration:none;"
                                                onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                _('doc_ref').submit();
                                                return false">
                                                <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                    View
                                                </div>
                                            </a><?php
                                        }?>
                                    </div>
                                </div><?php
                            }
                            
                            
                            if ($cProgrammeId == 'HSC202' || $cProgrammeId == 'HSC203' || $cProgrammeId == 'HSC204' || $cProgrammeId == 'HSC205')
                            {
                                if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                                {
                                    $mysqli_arch = link_connect_db_arch();
                                    $stmt = $mysqli_arch->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? AND cinfo_type  = 'pc'");
                                }else
                                {
                                    $stmt = $mysqli->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? AND cinfo_type  = 'pc'");		
                                }
                                $stmt->bind_param("s", $vApplicationNo);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($mask_pc);
                                $stmt->fetch();
                                $stmt->close();?>
                                
                                <input name="hsc_cert" id="hsc_cert" type="hidden" value="1" />                                
                                
                                
                                <div class="appl_left_child_div_child" style="margin-top:10px; gap:0px; flex-direction:column; background-color:#fdf0bf">
                                    <div id="form_not_sub_div inlin_message_color" style="flex:100%; padding:5px; height:auto; text-align:center;">
                                        Upload a scanned copy of your profession certificate. Maximum file size is 100KB.
                                    </div>
                                </div>

                                <div class="appl_left_child_div_child">
                                    <div style="flex:5%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff"></div>
                                    <div style="flex:25%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        Professional Certificate
                                    </div>
                                    <div style="flex:70%; height:auto; padding-top:4px; text-indent:4px; background-color: #ffffff"><?php
                                        $f_name = "../ext_docs/pcert/pc_".$mask_pc.".pdf";
                                        
                                        //$f_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/pc_".$mask_pc.".pdf";

                                        if ($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3')
                                        {
                                            if ($submission_status <> '2')
                                            {?>
                                                <input type="file" name="sbtd_pix_pc" id="sbtd_pix_pc" style="width:180px" 
                                                    title="Max size: 100KB, Format: PDF"><?php
                                            }

                                            if (($submission_status == '1' || $submission_status == '2') && file_exists($f_name) && $release_form == '0')
                                            {
                                                echo ' Uploaded. ';?>

                                                <a href="#" style="text-decoration:none;"
                                                    onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                    _('doc_ref').submit();
                                                    return false">
                                                    <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                        View
                                                    </div>
                                                </a><?php
                                            }?>
                                            <input name="pc_uploaded" id="pc_uploaded" type="hidden" value="<?php if (file_exists($f_name)){echo '1';}else{echo '0';}?>"required /><?php
                                        }else if (file_exists($f_name) && ($_REQUEST["user_cat"] == '5' || $_REQUEST["user_cat"] == '6'))
                                        {?>
                                            <a href="#" style="text-decoration:none;"
                                                onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                _('doc_ref').submit();
                                                return false">
                                                <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                    View
                                                </div>
                                            </a><?php
                                        }?>
                                    </div>
                                </div><?php

                                if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                                {
                                    $mysqli_arch = link_connect_db_arch();
                                    $stmt = $mysqli_arch->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? AND cinfo_type  = 'nl'");
                                }else
                                {
                                    $stmt = $mysqli->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? AND cinfo_type  = 'nl'");		
                                }
                                $stmt->bind_param("s", $vApplicationNo);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($mask_nl);
                                $stmt->fetch();
                                $stmt->close();?>

                                <div class="appl_left_child_div_child" style="margin-top:10px; gap:0px; flex-direction:column; background-color:#fdf0bf">
                                    <div id="form_not_sub_div inlin_message_color" style="flex:100%; padding:5px; height:auto; text-align:center;">
                                        Upload a scanned copy of your profession practising license. Maximum file size is 100KB.
                                    </div>
                                </div>

                                <div class="appl_left_child_div_child">
                                    <div style="flex:5%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff"></div>
                                    <div style="flex:25%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        Professional practising license
                                    </div>
                                    <div style="flex:70%; height:auto; padding-top:4px; text-indent:4px; background-color: #ffffff"><?php
                                        $f_name = "../ext_docs/pcert/nl_".$mask_nl.".pdf";
                                        
                                        //$f_name = BASE_FILE_NAME_FOR_PG_DOCS.strtolower($cFacultyId)."/cc/pc_".$mask_pc.".pdf";

                                        if ($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3')
                                        {
                                            if ($submission_status <> '2')
                                            {?>
                                                <input type="file" name="sbtd_pix_nl" id="sbtd_pix_nl" style="width:180px" 
                                                    title="Max size: 100KB, Format: PDF"><?php
                                            }

                                            if (($submission_status == '1' || $submission_status == '2') && file_exists($f_name) && $release_form == '0')
                                            {
                                                echo ' Uploaded. ';?>

                                                <a href="#" style="text-decoration:none;"
                                                    onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                    _('doc_ref').submit();
                                                    return false">
                                                    <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                        View
                                                    </div>
                                                </a><?php
                                            }?>
                                            <input name="nl_uploaded" id="nl_uploaded" type="hidden" value="<?php if (file_exists($f_name)){echo '1';}else{echo '0';}?>"required /><?php
                                        }else if (file_exists($f_name) && ($_REQUEST["user_cat"] == '5' || $_REQUEST["user_cat"] == '6'))
                                        {?>
                                            <a href="#" style="text-decoration:none;"
                                                onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                _('doc_ref').submit();
                                                return false">
                                                <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                    View
                                                </div>
                                            </a><?php
                                        }?>
                                    </div>
                                </div><?php
                            }


                            if ($vObtQualTitle <> 'CEMBA' && $vObtQualTitle <> 'CEMPA' && $cEduCtgId_elx <> 'ELX')
                            {
                                if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                                {
                                    $mysqli_arch = link_connect_db_arch();
                                    $stmt = $mysqli_arch->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? AND cinfo_type  = 'bc'");
                                }else
                                {
                                    $stmt = $mysqli->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? AND cinfo_type  = 'bc'");		
                                }
                                $stmt->bind_param("s", $vApplicationNo);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($mask_bc);
                                $stmt->fetch();
                                $stmt->close();?>
                                
                                <input name="b_cert" id="b_cert" type="hidden" value="1" />                                
                                
                                <div class="appl_left_child_div_child" style="margin-top:10px; gap:0px; flex-direction:column; background-color:#fdf0bf">
                                    <div id="form_not_sub_div inlin_message_color" style="flex:100%; padding:5px; height:auto; text-align:center;">
                                        Upload a scanned copy of your birth certificate. Maximum file size is 100KB.
                                    </div>
                                </div>

                                <div class="appl_left_child_div_child">
                                    <div style="flex:5%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff"></div>
                                    <div style="flex:25%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        Birth Certificate
                                    </div>
                                    <div style="flex:70%; height:auto; padding-top:4px; text-indent:4px; background-color: #ffffff"><?php
                                         $f_name1 = "../ext_docs/g_bc/bc_".$mask_bc.".pdf";
                                         $f_name = '';
                                         if (file_exists($f_name1))
                                         {
                                            $f_name = $f_name1;
                                         }else
                                         {
                                            $f_name2 = "../ext_docs/g_bc/".strtolower($cFacultyId)."/bc_".$mask_bc.".pdf";
                                            if (file_exists($f_name2))
                                            {
                                                $f_name = $f_name2;
                                            }
                                         }
                                         
                                        if ($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3')
                                        {
                                            if ($submission_status <> '2')
                                            {?>
                                                <input type="file" name="sbtd_pix_gbc" id="sbtd_pix_gbc" style="width:180px" 
                                                    title="Max size: 100KB, Format: PDF"><?php
                                            }
                                            
                                            if (($submission_status == '1' || $submission_status == '2') && file_exists($f_name) && $release_form == '0')
                                            {
                                                echo ' Uploaded. ';?>

                                                <a href="#" style="text-decoration:none;"
                                                    onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                    _('doc_ref').submit();
                                                    return false">
                                                    <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                        View
                                                    </div>
                                                </a><?php
                                            }?>
                                            <input name="gbc_uploaded" id="gbc_uploaded" type="hidden" value="<?php if (file_exists($f_name)){echo '1';}else{echo '0';}?>"required /><?php
                                        }else if (file_exists($f_name) && ($_REQUEST["user_cat"] == '5' || $_REQUEST["user_cat"] == '6'))
                                        {?>
                                            <a href="#" style="text-decoration:none;"
                                                onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                _('doc_ref').submit();
                                                return false">
                                                <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                    View
                                                </div>
                                            </a><?php
                                        }?>
                                    </div>
                                </div><?php
                            }


                            /*if (!is_bool(strpos("PGY,PGX,PGZ,PRX",$cEduCtgId)))
                            {
                                if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                                {
                                    $mysqli_arch = link_connect_db_arch();
                                    $stmt = $mysqli_arch->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? AND cinfo_type  = 'yc'");
                                }else
                                {
                                    $stmt = $mysqli->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? AND cinfo_type  = 'yc'");		
                                }
                                $stmt->bind_param("s", $vApplicationNo);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($mask_yc);
                                $stmt->fetch();
                                $stmt->close();?>
                                
                                <input name="yc_cert" id="yc_cert" type="hidden" value="1" />                                
                                
                                <div class="appl_left_child_div_child" style="margin-top:10px; gap:0px; flex-direction:column; background-color:#fdf0bf">
                                    <div id="form_not_sub_div inlin_message_color" style="flex:100%; padding:5px; height:auto; text-align:center;">
                                        Upload a scanned copy of NYSC certificate. Maximum file size is 100KB.
                                    </div>
                                </div>

                                <div class="appl_left_child_div_child">
                                    <div style="flex:5%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff"></div>
                                    <div style="flex:25%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                        National youth service corp certificate
                                    </div>
                                    <div style="flex:70%; height:auto; padding-top:4px; text-indent:4px; background-color: #ffffff"><?php
                                         $f_name1 = "../ext_docs/g_yc/yc_".$mask_yc.".pdf";
                                         $f_name = '';
                                         if (file_exists($f_name1))
                                         {
                                            $f_name = $f_name1;
                                         }
                                         
                                        if ($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3')
                                        {
                                            if ($submission_status <> '2')
                                            {?>
                                                <input type="file" name="sbtd_pix_yc" id="sbtd_pix_yc" style="width:180px" 
                                                    title="Max size: 100KB, Format: PDF"><?php
                                            }
                                            
                                            if (($submission_status == '1' || $submission_status == '2') && file_exists($f_name) && $release_form == '0')
                                            {
                                                echo ' Uploaded. ';?>

                                                <a href="#" style="text-decoration:none;"
                                                    onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                    _('doc_ref').submit();
                                                    return false">
                                                    <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                        View
                                                    </div>
                                                </a><?php
                                            }?>
                                            <input name="yc_uploaded" id="yc_uploaded" type="hidden" value="<?php if (file_exists($f_name)){echo '1';}else{echo '0';}?>"required /><?php
                                        }else if (file_exists($f_name) && ($_REQUEST["user_cat"] == '5' || $_REQUEST["user_cat"] == '6'))
                                        {?>
                                            <a href="#" style="text-decoration:none;"
                                                onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                _('doc_ref').submit();
                                                return false">
                                                <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                    View
                                                </div>
                                            </a><?php
                                        }?>
                                    </div>
                                </div><?php
                            }*/



                            //marraige cert
                            if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                            {
                                $mysqli_arch = link_connect_db_arch();
                                $stmt = $mysqli_arch->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? AND cinfo_type  = 'mc'");
                            }else
                            {
                                $stmt = $mysqli->prepare("SELECT vmask FROM pics WHERE vApplicationNo = ? AND cinfo_type  = 'mc'");		
                            }
                            $stmt->bind_param("s", $vApplicationNo);
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($mask_mc);
                            $stmt->fetch();
                            $stmt->close();?>
                            
                            <input name="m_cert" id="m_cert" type="hidden" value="1" />                                
                            
                            <div class="appl_left_child_div_child" style="margin-top:10px; gap:0px; flex-direction:column; background-color:#fdf0bf">
                                <div id="form_not_sub_div inlin_message_color" style="flex:100%; padding:5px; height:auto; text-align:center;">
                                    Upload a scanned copy of marriage certificate (optional). Maximum file size is 100KB.
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff"></div>
                                <div style="flex:25%; text-indent:5px; padding-top:4px; height:auto; background-color: #ffffff">
                                    Marriage certificate (optional)
                                </div>
                                <div style="flex:70%; height:auto; padding-top:4px; text-indent:4px; background-color: #ffffff"><?php
                                    $f_name1 = "../ext_docs/g_mc/mc_".$mask_mc.".pdf";
                                    $f_name = '';
                                    if (file_exists($f_name1))
                                    {
                                        $f_name = $f_name1;
                                    }
                                        
                                    if ($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"] == '3')
                                    {
                                        if ($submission_status <> '2')
                                        {?>
                                            <input type="file" name="sbtd_pix_mc" id="sbtd_pix_mc" style="width:180px" 
                                                title="Max size: 100KB, Format: PDF"><?php
                                        }
                                        
                                        if (($submission_status == '1' || $submission_status == '2') && file_exists($f_name) && $release_form == '0')
                                        {
                                            echo ' Uploaded. ';?>

                                            <a href="#" style="text-decoration:none;"
                                                onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                                _('doc_ref').submit();
                                                return false">
                                                <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                    View
                                                </div>
                                            </a><?php
                                        }?>
                                        <input name="mc_uploaded" id="mc_uploaded" type="hidden" value="<?php if (file_exists($f_name)){echo '1';}else{echo '0';}?>"required /><?php
                                    }else if (file_exists($f_name) && ($_REQUEST["user_cat"] == '5' || $_REQUEST["user_cat"] == '6'))
                                    {?>
                                        <a href="#" style="text-decoration:none;"
                                            onclick="_('doc_ref').action='<?php echo $f_name;?>';
                                            _('doc_ref').submit();
                                            return false">
                                            <div class="rec_pwd_button" style="border-left:1px solid #b6b6b6; width:60px; padding:6px; line-height:normal; height:auto;">
                                                View
                                            </div>
                                        </a><?php
                                    }?>
                                </div>
                            </div><?php
                            
                            
                            if (!is_bool(strpos("PGY,PGX,PGZ,PRX",$cEduCtgId)) && $submission_status <> '2' && ($_REQUEST["user_cat"] == 3 || $_REQUEST["user_cat"] == 1))
                            {?>
                                <!--<div class="appl_left_child_div_child" style="margin-top:25px">
                                    <div style="flex:5%; text-indent:5px; padding-top:4px; height:150px; background-color: #fdf0bf">
                                        <?php echo ++$number;?>
                                    </div>
                                    <div style="flex:25%; text-indent:5px; padding-top:4px; height:150px; background-color: #fdf0bf">
                                        I have completed one or more degree programmes in NOUN
                                    </div>
                                    <div style="flex:70%; height:150px; padding-top:4px; background-color: #fdf0bf">
                                        <label class="chkbox_container" style="margin-top:7px; margin-left:7px;">
                                            <input name="r_app_record" id="r_app_record1" type="radio" value="0"
                                            onclick="_('first_prog').style.display='block';">
                                            <span class="checkmark radio_checkmark"></span><div style="line-height:1.8;">Yes</div>
                                        </label>

                                        <label class="chkbox_container" style="margin-top:7px; margin-left:7px;">
                                            <input name="r_app_record" id="r_app_record2" type="radio" value="1"
                                            onclick="_('first_prog').style.display='none';">
                                            <span class="checkmark radio_checkmark"></span><div style="line-height:1.8;">No</div>
                                        </label>

                                        <input name="first_prog" id="first_prog" type="text" style="height:40px; margin-top:10px; display:none"
                                            placeholder="Enter matriculation number of programme in NOUN here..." 
                                            onchange="this.value=this.value.replace(/ /g, '');
                                            this.value=this.value.toUpperCase();"
                                            autocomplete="off" 
                                            maxlength="12" />
                                    </div>
                                </div>--><?php                    
                            }?>
                        </form>

                        <div style="display:flex; 
                            flex-flow: row;
                            justify-content: flex-end;
                            flex:100%;
                            height:auto; 
                            margin-top:10px;
                            margin-bottom:10px;"><?php
                            if ($_REQUEST["user_cat"] <> 3 && $_REQUEST["user_cat"] <> 1)
                            {?>
                                <button type="button" class="dull_button" style="width:20%">Submit button is active for applicant only</button><?php
                            }else if ($submission_status <> '2' && $error_omission == 0)
                            {?>
                                <button type="button" class="login_button" style="width:20%" 
                                    onclick="if (_('r_app_record1'))
                                    {
                                        if(ps.r_app_record.value=='')
                                        {
                                            caution_inform('Respond on line 41');
                                            return false;   
                                        }
                                        
                                        if(ps.r_app_record.value==0)
                                        {
                                            if(first_prog.value.trim()=='')
                                            {
                                                caution_inform('Enter matriculation number of your last programme');
                                                return false;   
                                            }

                                            if(first_prog.value.trim().length!=12)
                                            {
                                                caution_inform('Invalid Matriculation (Registration) number')
                                                return false;   
                                            }

                                            var letters_numbers = /^[A-Za-z0-9_]+$/;
                                            if (!ps.first_prog.value.match(letters_numbers))
                                            {
                                                caution_inform('Invalid Matriculation (Registration) number')
                                                return false;
                                            }
                                        }
                                    }

                                    if (_('cEduCtgId_org').value == 'PSZ')
                                    {
                                        if (_('jambno') && _('jambno').value == '')
                                        {
                                            caution_inform('Enter JAMB registration number');
                                            return false;
                                        }
                                    }

                                    _('smke_screen_2').style.zIndex='2';
                                    _('smke_screen_2').style.display='block';
                                    _('conf_box_loc').style.zIndex='3';
                                    _('conf_box_loc').style.display='block';">Submit</button><?php
                            }else if ($error_omission == 1)
                            {?>
                                <button type="button" class="dull_button" style="width:20%">Submit button is active when form is properly completed</button><?php
                            }?>
                        </div>                        
						
						<div style="display:flex; 
                            flex-flow: row;
                            justify-content: flex-end;
                            flex:100%;
                            height:auto;
                            padding:10px;">
							This document is only valid if its content exactly matches what is on the University database
						</div>
                    </div>
            </div>
        </div>
	</body>
</html>