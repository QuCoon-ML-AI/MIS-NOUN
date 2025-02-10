document.onkeydown = function (e) 
{
    if (e.ctrlKey && e.keyCode === 85) 
    {
        return false;
    }
}

// function chk_inputs()
// {
//     //if (_('fee_item_n').style.display == 'block' && _('fee_item_n').value == '')
//     if (_('fee_item').value == '')
//     {
//         caution_box('Select a fee item to generate report');
//     }/*else if (_('fee_item_r').style.display == 'block' && _('fee_item_r').value == '')
//     {
//         caution_box('Select a fee item to generate report');
//     }*/else if (_('date_burs1').value == '' || _('date_burs1').value == '')
//     {
//         caution_box('Set period of report');
//     }else 
//     {
//         excel_export.date_burs1_ex_burs.value = burs_loc.date_burs1.value;
//         excel_export.date_burs1_ex_burs.value = burs_loc.date_burs2.value;
//         excel_export.r_name.value = burs_loc.r_name.value;

//         prns_form.date_burs1_prns.value = burs_loc.date_burs1.value;
//         prns_form.date_burs2_prns.value = burs_loc.date_burs2.value;
//         prns_form.r_name.value = burs_loc.r_name.value;
//         burs_loc.submit();
//     }
// }


function tab_modify(tab_no)
{
    _('sub_box2').style.display = 'none';
    //_('print_all').style.display = 'none';
    //_('exp_excel').style.display = 'none';
    
    burs_loc.tabno.value = tab_no;
        
    _("tabss1").style.borderBottom = '1px solid #FFFFFF';
    _("ans1").style.display = 'block';

    _('sub_box2').style.display = 'block';
    //_('print_all').style.display = 'none';
    //_('exp_excel').style.display = 'none';

    // _("tabss2").style.border = '1px solid #BCC6CF';
    // _("tabss2").style.background = 'none';
    _("ans2").style.display = 'none';
    
    _('sub_box2').style.display = 'block';
    //_('print_all').style.display = 'none';
    //_('exp_excel').style.display = 'none';

    _('selected_options_div').innerHTML = '';
}


/*function update_cat(which_ctrl)
{
    if (which_ctrl == 'mode')	
    {
        _('cEduCtgId_burs').length = 0;
        _("cEduCtgId_burs").options[_("cEduCtgId_burs").options.length] = new Option('', '');
        var cProgdesc = ''; cProgId = '';

        for (var i = 0; i <= _('cEduCtgId_readup_top').length-1; i++)
        {	
            cProgdesc = _('cEduCtgId_readup_top').options[i].text;
            cProgId = _('cEduCtgId_readup_top').options[i].value.substr(0,3)+
            _('cEduCtgId_readup_top').options[i].value.substr(3,30)+
            _('cEduCtgId_readup_top').options[i].value.substr(33,10)+
            _('cEduCtgId_readup_top').options[i].value.substr(43,100)+
            _('cEduCtgId_readup_top').options[i].value.substr(143,10)+
            _('cEduCtgId_readup_top').options[i].value.substr(153);
            if (_('cEduCtgId_readup_top').options[i].value.substr(3,30).trim() == _('study_mode_burs').value&& _('cAcademicDesc').value == _('cEduCtgId_readup_top').options[i].value.substr(158,10).trim())
            {
                _("cEduCtgId_burs").options[_("cEduCtgId_burs").options.length] = new Option(cProgdesc, cProgId);
            }
        }
    }
}*/


function compose_sel(chkobj)
{
    if (chkobj.checked)
    {
        _("sort_burs").value = _("sort_burs").value + chkobj.value;
        _("sort_ex_burs").value =  _("sort_burs").value;
        _("sort_burs_prns").value =  _("sort_burs").value;
    }else if (!chkobj.checked)
    {
        tmpvarST = '';
        for (t = 0; t <= _("sort_burs").value.length-1; t++)
        {
            if (_("sort_burs").value.charAt(t) != chkobj.value && tmpvarST.indexOf(_("sort_burs").value.charAt(t)) == -1)
            {
                tmpvarST = tmpvarST + _("sort_burs").value.charAt(t);
            }
        }
        _("sort_burs").value = tmpvarST;
        _("sort_ex_burs").value = tmpvarST;
        _("sort_burs_prns").value = tmpvarST;
    }

    //alert(_("sort_burs").value+', '+_("sort_ex_burs").value+', '+_("sort_burs_prns").value)
}