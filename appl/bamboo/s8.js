
function _(el)
{
    return document.getElementById(el)
}


// function submitForm()
// {
//     if (!_("name_check").checked)
//     {
//         caution_inform("Check the appropriate box to confirm your identity otherwise, edit your form as applicable");
//         return false;
//     }

//     if (!_("pix_check").checked)
//     {
//         caution_inform("Check the appropriate box to confirm that you are the one in the uploaded passport picture otherwise, edit your form as applicable");
//         return false;
//     }

//     if (!_("pix_size_check").checked)
//     {
//         caution_inform("Check the appropriate box to confirm that the uploaded picture is of passport size  otherwise, edit your form as applicable");
//         return false;
//     }

//     if (!_("pix_time_check").checked)
//     {
//         caution_inform("Check the appropriate box to confirm that the uploaded picture was taken less than three months ago otherwise, edit your form as applicable");
//         return false;
//     }

//     if (!_("prog_check").checked)
//     {
//         caution_inform("Check the appropriate box to confirm that you are okay with the selected programme otherwise, edit your form as applicable");
//         return false;
//     }

//     if (!_("level_check").checked)
//     {
//         caution_inform("Check the appropriate box to confirm that you are okay with the selected level otherwise, edit your form as applicable");
//         return false;
//     }

//     if (_("vProgrammeDesc_db").value.indexOf("Nursing") != -1 && !_("nmcn_check").checked)
//     {
//         caution_inform("Check the appropriate box to confirm that you are registered with NMCN otherwise, edit your form as applicable");
//         return false;
//     }
    
//     if (_("post_g"))
//     {
//         var file_names = "";

//         var files_pr = _("sbtd_pix_pr").files;
//         if ((_("sbtd_pix_pr").files.length == 0 && (_("pr_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_pr").files.length > 0 && files_pr[0].type != "application/pdf"))
//         {
//             caution_inform("PDF file required for payment receipt");
//             _('conf_box_loc').style.zIndex='-1';
//             _('conf_box_loc').style.display='none';

//             _('smke_screen_2').style.zIndex='-1';
//             _('smke_screen_2').style.display='none';
//             return false;
//         }
        
//         if (_("sbtd_pix_pr").files.length > 0)
//         {
//             if (files_pr[0].size > 100000)
//             {
//                 caution_inform("Maximum file size for payment receipt is 100KB");
//                 _('conf_box_loc').style.zIndex='-1';
//                 _('conf_box_loc').style.display='none';
            
//                 _('smke_screen_2').style.zIndex='-1';
//                 _('smke_screen_2').style.display='none';
//                 return false;
//             }
//         }
        
        
//         var files_cv = _("sbtd_pix_cv").files;
//         if ((_("sbtd_pix_cv").files.length == 0 && (_("cv_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_cv").files.length > 0 && files_cv[0].type != "application/pdf"))
//         {
//             caution_inform("PDF file required for curriculum vitae");
//             _('conf_box_loc').style.zIndex='-1';
//             _('conf_box_loc').style.display='none';
            
//             _('smke_screen_2').style.zIndex='-1';
//             _('smke_screen_2').style.display='none';
//             return false;
//         }
        
//         if (_("sbtd_pix_cv").files.length > 0)
//         {
//             if (files_cv[0].size > 150000)
//             {
//                 caution_inform("Maximum file size for curriculum vitae is 100KB");
//                 _('conf_box_loc').style.zIndex='-1';
//                 _('conf_box_loc').style.display='none';
            
//                 _('smke_screen_2').style.zIndex='-1';
//                 _('smke_screen_2').style.display='none';
//                 return false;
//             }

//             if (file_names.indexOf(files_cv[0].name) >= 0)
//             {
//                 caution_inform("Curriculum vitae fle already selected");
//                 _('conf_box_loc').style.zIndex='-1';
//                 _('conf_box_loc').style.display='none';
            
//                 _('smke_screen_2').style.zIndex='-1';
//                 _('smke_screen_2').style.display='none';
//                 return false;
//             }
//         }


//         var files_rl1 = _("sbtd_pix_rl1").files;
//         if ((_("sbtd_pix_rl1").files.length == 0 && (_("rl1_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_rl1").files.length > 0 &&files_rl1[0].type != "application/pdf"))
//         {
//             caution_inform("PDF file required for reference letter 1");
//             _('conf_box_loc').style.zIndex='-1';
//             _('conf_box_loc').style.display='none';
            
//             _('smke_screen_2').style.zIndex='-1';
//             _('smke_screen_2').style.display='none';
//             return false;
//         }
        
//         if (_("sbtd_pix_rl1").files.length > 0)
//         {
//             if (files_rl1[0].size > 100000)
//             {
//                 caution_inform("Maximum file size for reference letter 1 is 100KB");
//                 _('conf_box_loc').style.zIndex='-1';
//                 _('conf_box_loc').style.display='none';
            
//                 _('smke_screen_2').style.zIndex='-1';
//                 _('smke_screen_2').style.display='none';
//                 return false;
//             }

//             if (file_names.indexOf(files_rl1[0].name) >= 0)
//             {
//                 caution_inform("File for reference letter 1 already selected");
//                 _('conf_box_loc').style.zIndex='-1';
//                 _('conf_box_loc').style.display='none';
            
//                 _('smke_screen_2').style.zIndex='-1';
//                 _('smke_screen_2').style.display='none';
//                 return false;
//             }
//         }


//         var files_rl2 = _("sbtd_pix_rl2").files;
//         if ((_("sbtd_pix_rl2").files.length == 0 && (_("rl2_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_rl2").files.length > 0 &&files_rl2[0].type != "application/pdf"))
//         {
//             caution_inform("PDF file required for reference letter 2");
//             _('conf_box_loc').style.zIndex='-1';
//             _('conf_box_loc').style.display='none';
            
//             _('smke_screen_2').style.zIndex='-1';
//             _('smke_screen_2').style.display='none';
//             return false;
//         }
        
//         if (_("sbtd_pix_rl2").files.length > 0)
//         {
//             if (files_rl2[0].size > 100000)
//             {
//                 caution_inform("Maximum file size for reference letter 1 is 100KB");
//                 _('conf_box_loc').style.zIndex='-1';
//                 _('conf_box_loc').style.display='none';
            
//                 _('smke_screen_2').style.zIndex='-1';
//                 _('smke_screen_2').style.display='none';
//                 return false;
//             }

//             if (file_names.indexOf(files_rl2[0].name) >= 0)
//             {
//                 caution_inform("File for reference letter 1 already selected");
//                 _('conf_box_loc').style.zIndex='-1';
//                 _('conf_box_loc').style.display='none';
            
//                 _('smke_screen_2').style.zIndex='-1';
//                 _('smke_screen_2').style.display='none';
//                 return false;
//             }
//         }
        
        
//         var files_tp = _("sbtd_pix_tp").files;
//         if ((_("sbtd_pix_tp").files.length == 0 && (_("tp_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_tp").files.length > 0 && files_tp[0].type != "application/pdf"))
//         {
//             caution_inform("PDF file required for thesis proposal");
//             _('conf_box_loc').style.zIndex='-1';
//             _('conf_box_loc').style.display='none';
            
//             _('smke_screen_2').style.zIndex='-1';
//             _('smke_screen_2').style.display='none';
//             return false;
//         }
        
//         if (_("sbtd_pix_tp").files.length > 0)
//         {
//             if (files_tp[0].size > 150000)
//             {
//                 caution_inform("Maximum file size for thesis proposal is 100KB");
//                 _('conf_box_loc').style.zIndex='-1';
//                 _('conf_box_loc').style.display='none';
            
//                 _('smke_screen_2').style.zIndex='-1';
//                 _('smke_screen_2').style.display='none';
//                 return false;
//             }

//             if (file_names.indexOf(files_tp[0].name) >= 0)
//             {
//                 caution_inform("File for thesis proposal already selected");
//                 _('conf_box_loc').style.zIndex='-1';
//                 _('conf_box_loc').style.display='none';
            
//                 _('smke_screen_2').style.zIndex='-1';
//                 _('smke_screen_2').style.display='none';
//                 return false;
//             }
//         }
//     }

//     if (_("cemba"))
//     {
//         var file_names = "";

//         var files_pr = _("sbtd_pix_pr").files;
//         if ((_("sbtd_pix_pr").files.length == 0 && (_("pr_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_pr").files.length > 0 && files_pr[0].type != "application/pdf"))
//         {
//             caution_inform("PDF file required for payment receipt");
//             _('conf_box_loc').style.zIndex='-1';
//             _('conf_box_loc').style.display='none';

//             _('smke_screen_2').style.zIndex='-1';
//             _('smke_screen_2').style.display='none';
//             return false;
//         }
        
//         if (_("sbtd_pix_pr").files.length > 0)
//         {
//             if (files_pr[0].size > 100000)
//             {
//                 caution_inform("Maximum file size for payment receipt is 100KB");
//                 _('conf_box_loc').style.zIndex='-1';
//                 _('conf_box_loc').style.display='none';
            
//                 _('smke_screen_2').style.zIndex='-1';
//                 _('smke_screen_2').style.display='none';
//                 return false;
//             }
//         }

        
//         var files_bc = _("sbtd_pix_bc").files;
//         if ((_("sbtd_pix_bc").files.length == 0 && (_("bc_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_bc").files.length > 0 && files_bc[0].type != "application/pdf"))
//         {
//             caution_inform("PDF file required for birth certificate");
//             _('conf_box_loc').style.zIndex='-1';
//             _('conf_box_loc').style.display='none';

//             _('smke_screen_2').style.zIndex='-1';
//             _('smke_screen_2').style.display='none';
//             return false;
//         }
        
//         if (_("sbtd_pix_bc").files.length > 0)
//         {
//             if (files_bc[0].size > 100000)
//             {
//                 caution_inform("Maximum file size for birth certificate is 100KB");
//                 _('conf_box_loc').style.zIndex='-1';
//                 _('conf_box_loc').style.display='none';
            
//                 _('smke_screen_2').style.zIndex='-1';
//                 _('smke_screen_2').style.display='none';
//                 return false;
//             }
//         }

        
//         var files_we = _("sbtd_pix_we").files;
//         if ((_("sbtd_pix_we").files.length == 0 && (_("bwe_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_we").files.length > 0 && files_we[0].type != "application/pdf"))
//         {
//             caution_inform("PDF file required for evidence of work experience");
//             _('conf_box_loc').style.zIndex='-1';
//             _('conf_box_loc').style.display='none';

//             _('smke_screen_2').style.zIndex='-1';
//             _('smke_screen_2').style.display='none';
//             return false;
//         }

//         if (_("sbtd_pix_we").files.length > 0)
//         {
//             if (files_we[0].size > 100000)
//             {
//                 caution_inform("Maximum file size for evidence of work experience is 100KB");
//                 _('conf_box_loc').style.zIndex='-1';
//                 _('conf_box_loc').style.display='none';
            
//                 _('smke_screen_2').style.zIndex='-1';
//                 _('smke_screen_2').style.display='none';
//                 return false;
//             }
//         }
//     }
    
    
//     if (_("hsc_cert"))
//     {
//         var file_names = "";

//         var files_pr = _("sbtd_pix_pc").files;
//         if ((_("sbtd_pix_pc").files.length == 0 && (_("pc_uploaded").value == '0' || _('release_form').value == '1')) || (_("sbtd_pix_pc").files.length > 0 && files_pr[0].type != "application/pdf"))
//         {
//             caution_inform("PDF file required for professional certificate");
//             _('conf_box_loc').style.zIndex='-1';
//             _('conf_box_loc').style.display='none';

//             _('smke_screen_2').style.zIndex='-1';
//             _('smke_screen_2').style.display='none';
//             return false;
//         }

//         if (_("sbtd_pix_pc").files.length > 0)
//         {
//             if (files_pr[0].size > 100000)
//             {
//                 caution_inform("Maximum file size for professional certificate is 100KB");
//                 _('conf_box_loc').style.zIndex='-1';
//                 _('conf_box_loc').style.display='none';
            
//                 _('smke_screen_2').style.zIndex='-1';
//                 _('smke_screen_2').style.display='none';
//                 return false;
//             }
//         }
//     }
    
//     if (_("b_cert"))
//     {
//         var files_pr = _("sbtd_pix_gbc").files;
//         if (_("gbc_uploaded").value == '0' || _('release_form').value == '1' || _("sbtd_pix_gbc").files.length > 0)
//         {            
//             if (_("sbtd_pix_gbc").files.length == 0 && (_("gbc_uploaded").value == '0' || _('release_form').value == '1'))
//             {
//                 caution_inform("PDF file required for birth certificate");
//                 _('conf_box_loc').style.zIndex='-1';
//                 _('conf_box_loc').style.display='none';

//                 _('smke_screen_2').style.zIndex='-1';
//                 _('smke_screen_2').style.display='none';
//                 return false;
//             }else if ( _("sbtd_pix_gbc").files.length > 0 && files_pr[0].size > 100000)
//             {
//                 caution_inform("Maximum file size for birth certificate is 100KB");
//                 _('conf_box_loc').style.zIndex='-1';
//                 _('conf_box_loc').style.display='none';
            
//                 _('smke_screen_2').style.zIndex='-1';
//                 _('smke_screen_2').style.display='none';
//                 return false;
//             }
//         }
//     }

//     if (_("yc_cert"))
//     {
//         var files_pr = _("sbtd_pix_yc").files;
//         if (_("yc_uploaded").value == '0' || _('release_form').value == '1' || _("sbtd_pix_yc").files.length > 0)
//         {
//             if (_("sbtd_pix_yc").files.length == 0 && (_("yc_uploaded").value == '0' || _('release_form').value == '1'))
//             {
//                 caution_inform("PDF file required for NYSC certificate");
//                 _('conf_box_loc').style.zIndex='-1';
//                 _('conf_box_loc').style.display='none';

//                 _('smke_screen_2').style.zIndex='-1';
//                 _('smke_screen_2').style.display='none';
//                 return false;
//             }
//         }
//     } 

    

//     ps.submit_form.value='1'; 
//     ps.action='preview-form'; 
//     in_progress('1'); 
//     ps.submit();
// }



function call_image()
{
    var formdata = new FormData();
    
    with(ps)
    {
        formdata.append("loadcred",'1');
        formdata.append("user_cat", user_cat.value);
        
        formdata.append("vApplicationNo", vApplicationNo.value);
        
        formdata.append("vExamNo", vExamNo.value);
        formdata.append("cQualCodeId", cQualCodeId.value);
    }
    
    opr_prep(ajax = new XMLHttpRequest(),formdata);
}


function opr_prep(ajax,formdata)
{
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);                
    
    ajax.open("POST", "./opr_s5.php");
    ajax.send(formdata);
}


function completeHandler(event)
{
    on_error('0');
    on_abort('0');
    in_progress('0');
    
    if (_('fil_ex').value == 'g')
    {
        _("credential_img").src = event.target.responseText;
    }
    
    _("smke_screen_2").style.zIndex = 2;
    _("smke_screen_2").style.display = 'block';

    _("container_cover_in").style.zIndex = 3;
    _("container_cover_in").style.display = 'block';
    
    _("close_cert_container").focus();
    _("loadcred").value = 0;
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