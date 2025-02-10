function _(el)
{
    return document.getElementById(el)
}

function chk_inputs()
{                
    with (ps_1)
    {
        vFacultyDesc.value = cFacultyIdold07.options[cFacultyIdold07.selectedIndex].text;
        vdeptDesc.value = cdeptold.options[cdeptold.selectedIndex].text;
        vProgrammeDesc.value = cprogrammeIdold.options[cprogrammeIdold.selectedIndex].text;

        submit();
    }
    //  _("ps").submit();
}

function updateScrn()
{
    save.value = '0';                    
        
    ps.vFacultyDesc.value = ps.cFacultyIdold_loc.options[ps.cFacultyIdold_loc.selectedIndex].text;
    
    prns_form.cFacultyIdold.value = ps.cFacultyIdold_loc.value;

    prns_form.vFacultyDesc.value = ps.vFacultyDesc.value;
}