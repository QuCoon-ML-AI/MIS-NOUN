function _(el)
{
    return document.getElementById(el)
}

function chk_inputs()
{
    alert('caled'); return false;
    with (ps)
    {
        if (vrePassword.value != vPassword.value)
        {
            caution_inform("Passwords not the same");
            return false;
        }
    }
    
    return true;
}