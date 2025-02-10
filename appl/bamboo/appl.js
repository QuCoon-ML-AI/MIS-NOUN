function _(el)
{
    return document.getElementById(el)
}

function chk_inputs()
{
    if (_("cap_text").value != _("hidden_cap_text").value)
    {
        _("cap_text").setCustomValidity("Wrong entry");
        return false;
    }else
    {
        _("cap_text").setCustomValidity("");
    }
    
    var formdata = new FormData();
    formdata.append("vApplicationNo", ps.vApplicationNo.value);
    formdata.append("vPassword", _("vPassword").value);
    formdata.append("user_cat", '1');

    opr_prep(ajax = new XMLHttpRequest(),formdata);   
}


function opr_prep(ajax,formdata)
{
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    
    ajax.open("POST", "opr_l_ins.php");
    ajax.send(formdata);
}
    
function completeHandler(event)
{
    on_error('0');
    on_abort('0');
    in_progress('0');
    var returnedStr = event.target.responseText;
    returnedStr = returnedStr.trim();

    if (returnedStr.indexOf("success") != -1)
    {
        ps.ilin.value = returnedStr.substr(7);
        ps.action = 'applicant_welcome_page';
        ps.submit();
        return false;
    }else
    {
        caution_inform(returnedStr)
    }
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