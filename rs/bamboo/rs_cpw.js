function _(el)
{
    return document.getElementById(el);
}

function chk_inputs_cpw()
{
    with (rs_cpw)
    {
        if (vrePassword.value != vPassword.value)
        {
            caution_inform("New and confirmation password must be the same");
            return false;
        } 
        
        var formdata = new FormData();
        
        formdata.append("ilin", ilin.value);
        formdata.append("vMatricNo", vMatricNo.value);
        formdata.append("vfPassword", vfPassword.value);
        formdata.append("vPassword", vPassword.value);

        formdata.append("token_req", token_req.value);

        if (token_req.value == '1')
        {
            formdata.append("user_token", pwd_token.value);
        }
    }
    
    opr_prep(ajax = new XMLHttpRequest(),formdata);
}

function opr_prep(ajax,formdata)
{
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    
    ajax.open("POST", "back_end_change_password");
    
    ajax.send(formdata);
}


function completeHandler(event)
{
    on_error('0');
    on_abort('0');
    in_progress('0');

    var returnedStr = event.target.responseText;
    
    if (returnedStr  == "Success")
    {
        inform(returnedStr);
    }else if (returnedStr == "Token sent")
    {
        rs_cpw.token_req.value = '1';
        _('token_box').style.display = 'block';
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