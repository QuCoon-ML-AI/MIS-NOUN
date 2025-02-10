function _(el)
{
    return document.getElementById(el)
}

function chk_inputs()
{
    var formdata = new FormData();
    with (ps)
    {
        if (user_token.value.trim() == '')
        {
            caution_inform("Enter token");
            return false;
        }
        formdata.append("vMatricNo", vMatricNo.value);
        formdata.append("user_token", user_token.value);
    }
    opr_prep(ajax = new XMLHttpRequest(),formdata);   
}


function opr_prep(ajax,formdata)
{
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    
    ajax.open("POST", "check_student_token");
    ajax.send(formdata);
}
    
function completeHandler(event)
{
    on_error('0');
    on_abort('0');
    in_progress('0');
    var returnedStr = event.target.responseText;
    returnedStr = returnedStr.trim();
    
    if (returnedStr == 'Token valid')
    {
        in_progress("1");
        ps.action = 'student_reset_password';
        ps.token_veri.value='1';
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