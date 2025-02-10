function _(el)
{
    return document.getElementById(el)
}


function chk_inputs()
{
    if (_("vPassword").value != '' && _("vPassword").value != _("vrePassword").value)
    {
        caution_inform("The two paswwords must be the same");
        return false;
    }
    
    loc_ps.submit();
    return false;
}