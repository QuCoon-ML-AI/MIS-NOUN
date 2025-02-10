function _(el)
{
    return document.getElementById(el)
}

function chk_inputs()
{
    if (ps.request_id.value == 2)
    {
        in_progress('1');
        remita_form.submit();
        return false;
    }else
    {
        ps.request_id.value = 1;
        in_progress('1');
        return true;
    }
}