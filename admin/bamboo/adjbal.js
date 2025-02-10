document.onkeydown = function (e) 
{
    if (e.ctrlKey && e.keyCode === 85) 
    {
        return false;
    }
}


// function chk_inputs()
// {
//     var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
//     for (j = 0; j <= ulChildNodes.length-1; j++)
//     {
//         ulChildNodes[j].style.display = 'none';
//     }
    
//     var formdata = new FormData();

//     var files = _("sbtd_pix").files;
//     if (_('mode_proc').checked)
//     {        
//         if (!csvfileValidation("sbtd_pix") || _("sbtd_pix").files.length == 0)
//         {
//             setMsgBox("labell_msg4","Select a csv file to upload");
//             return false;
//         }
        
//         if (files.length > 0)
//         {
//             formdata.append("sbtd_pix", _("sbtd_pix").files[0]);
//         }
//     }else
//     {
            
//         if (!_('chk_inmate2').checked && _('adj_bal_loc').uvApplicationNo.value == '')
//         {
//             setMsgBox("labell_msg0","");
//             _('adj_bal_loc').uvApplicationNo.focus();
//             return false;
//         }else if (_('adj_type').value == '')
//         {
//             setMsgBox("labell_msg1","");
//             _("adj_type").focus();
//             return false;
//         }else if (_("adj_amnt").value == '' || _("adj_amnt").value <= 0)
//         {
//             setMsgBox("labell_msg2","Ammount can neither be 0 nor empty");
//             _("adj_amnt").focus();
//             return false;
//         }else if (_('rrr_div').style.display == 'block' && _("rrr").value == '')
//         {
//             setMsgBox("labell_msg3","");
//             _("rrr").focus();
//             return false;
//         }else if (_('rrr_pay_div').style.display == 'block' && _("vDesc_loc").value == '')
//         {
//             setMsgBox("labell_msg5","");
//             _("vDesc_loc").focus();
//             return false;
//         }/*else if (_('dbt_div').style.display == 'block' && _("vremark").value == '')
//         {
//             setMsgBox("labell_msg6","");
//             _("vremark").focus();
//         }*/else if (_('adj_bal_loc').conf.value == '')
//         {
//             if (_('adj_type').value == 'c')
//             {
//                 _("conf_msg_msg_loc").innerHTML = 'The RRR identifies a successful transaction?';
//             }else
//             {
//                 _("conf_msg_msg_loc").innerHTML = 'Are you sure about this ?';
//             }
            
//             _('conf_box_loc').style.display = 'block';
//             _('conf_box_loc').style.zIndex = '3';
//             _('smke_screen_2').style.display = 'block';
//             _('smke_screen_2').style.zIndex = '2';
//             return false;
//         }

        
//         formdata.append("uvApplicationNo", _('adj_bal_loc').uvApplicationNo.value);
//         formdata.append("vMatricNo", _('adj_bal_loc').vMatricNo.value);
        

//         if (_('rrr_div').style.display == 'block')
//         {
//             formdata.append("rrr", _('rrr').value);
//         }

//         formdata.append("vDesc_loc", _('vDesc_loc').value);
            
//         if (_('refund_div').style.display == 'block' && _('chk_refund').checked)
//         {
//             formdata.append("chk_refund", _('chk_refund').value);
//         }

//         if (/*_('chk_inmate1').checked ||*/ _('chk_inmate2').checked)
//         {
//             formdata.append("chk_inmate", _('chk_inmate').value);
//         }
        
//         formdata.append("adj_type", _('adj_type').value);
//         formdata.append("adj_amnt", _('adj_amnt').value);		
//         formdata.append("bal", _('bal').value);
//     }
    
    
//     formdata.append("ilin", _('adj_bal_loc').ilin.value);
    
//     formdata.append("user_cat", _('adj_bal_loc').user_cat.value);
//     formdata.append("vApplicationNo", _('adj_bal_loc').vApplicationNo.value);
//     formdata.append("cAcademicDesc", _('cAcademicDesc').value);
    
//     formdata.append("study_mode", _('adj_bal_loc').service_mode.value);
//     formdata.append("user_centre", _('adj_bal_loc').user_centre.value);
    
//     opr_prep(ajax = new XMLHttpRequest(),formdata);    
// }


function opr_prep(ajax,formdata)
{
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    
    ajax.open("POST", "opr_bal_sactn.php");
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

function centre_select()
{
    return true;

    if (_("user_centre_loc").value == '')
    {
        _("succ_boxt").style.display = "block";
        _("succ_boxt").innerHTML = "Please select a study centre";
        _("succ_boxt").style.display = "block";
        return false;
    }

    if (_("service_mode_loc").value == '')
    {
        _("succ_boxt").style.display = "block";
        _("succ_boxt").innerHTML = "Please select a service mode";
        _("succ_boxt").style.display = "block";
        return false;
    }

    return true;
}



function show_list()
{
    /*_('container_cover').style.zIndex = 2;
    _('container_cover').style.display = 'block';*/
    _('container_cover_in').style.zIndex = 3;
    _('container_cover_in').style.display = 'block';
    
    //_('container_cover').style.display='block';
    _('container_cover_in').style.display='block';
}