document.onkeydown = function (e) 
{
    if (e.ctrlKey && e.keyCode === 85) 
    {
        return false;
    }
}


function opr_prep(ajax,formdata)
{
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    
    ajax.open("POST", "opr_opsions.php");
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
        //_("succ_boxt").style.display = "block";
        //_("succ_boxt").innerHTML = "Please select a study centre";
        //_("succ_boxt").style.display = "block";
        return false;
    }

    if (_("service_mode_loc").value == '')
    {
        //_("succ_boxt").style.display = "block";
        //_("succ_boxt").innerHTML = "Please select a service mode";
        //_("succ_boxt").style.display = "block";
        return false;
    }

    return true;
}

function idlTimeOnly()
{
    var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
    for (j = 0; j <= ulChildNodes.length-1; j++)
    {
        ulChildNodes[j].style.display = 'none';
    }
    
    var newDay = '';
    var newMOnth = '';
    var newYear = '';
    var newDate = '';
    
    var formdata = new FormData();

    // if (_("study_mode2").value == '')
    // {
    //     setMsgBox("labell_msg1b","");
    //     _("study_mode2").focus();
    //     return false;
    // }	
    
    formdata.append("study_mode2", 'odl');



    if (_("tIdl_time_only").value == '1')
    {
        formdata.append("tIdl_time_only", _("tIdl_time_only").value);
        formdata.append("tIdl_time", _('opsions_loc').tIdl_time.value);
    }

    formdata.append("ilin", _('nxt').ilin.value);
    
    formdata.append("currency_cf", _("currency_cf").value);
    formdata.append("vApplicationNo", _('opsions_loc').vApplicationNo.value);
    formdata.append("user_cat", _('opsions_loc').user_cat.value);
    formdata.append("tabno", _('tabno').value);
    opr_prep(ajax = new XMLHttpRequest(),formdata);
}


function compose_number(name_val, val)
{
    var str = '';
    if ((_(name_val).value != '' && _(name_val).value != '0') || _(name_val).value == '1')
    {
        if (_("mat_comp_orda").value.indexOf(val) == -1)
        {
            _("mat_comp_orda").value += val;
        }
    }else
    {
        for (i = 0; i < _("mat_comp_orda").value.length-1; i++)
        {
            if (_("mat_comp_orda").value.charAt(i) != val)
            {
                str += _("mat_comp_orda").value.charAt(i);
            }
        }
        _("mat_comp_orda").value = str;
    }
}


function smpl_matno(val,prefix_sufix)
{
    var txt_before_x =  _('sampl_compoMat').value.substr(0, _('sampl_compoMat').value.indexOf("x"));
    var txt_after_x =  _('sampl_compoMat').value.substr(_('sampl_compoMat').value.indexOf("x")+5);
    
    if (_('sampl_compoMat').value.indexOf(val) == -1)
    {
        if (prefix_sufix == '0')
        {
            txt_before_x = txt_before_x + val + _("matnosepa").value;
        }else
        {
            txt_after_x = txt_after_x + _("matnosepa").value + val;
        }
    }
    _('sampl_compoMat').value = txt_before_x + 'xxxxx' + txt_after_x;
}


function tab_modify(tab_no)
{
    /*var ulChildNodes = _("rtlft_std").getElementsByClassName("innercont_stff_tabs");
    for (j = 0; j <= ulChildNodes.length-1; j++)
    {
        if (ulChildNodes[j]){ulChildNodes[j].style.height = '425px';}
    }*/
    
    _('tabno').value = tab_no;
        
    tablinks = document.getElementsByClassName("innercont_stff_tabs");
    for (i = 0; i < tablinks.length; i++) 
    {
        var tab_Id = 'tabss' + (i+1);
        var cover_maincontent_id = 'ans' + (i+1);
        if (tab_no == (i+1))
        {
            _(tab_Id).style.borderBottom = '1px solid #FFFFFF';
            //_(cover_maincontent_id).style.visibility = 'visible';
            _(cover_maincontent_id).style.display = 'block';

            if (nxt.mm.value == 2 && nxt.sm.value == 10)
            {
                if (tab_no == 4)
                {
                    _('sub_box').style.display = 'block';
                }else
                {
                    _('sub_box').style.display = 'none';
                }
            }
        }else if (_(tab_Id))
        {
            _(tab_Id).style.border = '1px solid #BCC6CF';
            //_(cover_maincontent_id).style.visibility = 'hidden';
            _(cover_maincontent_id).style.display = 'none';
            
            _(tab_Id).style.background = 'none';
        }
    }
}