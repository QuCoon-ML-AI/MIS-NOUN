function _(el)
{
    return document.getElementById(el)
}

function chk_mtn()
{
                    
    with (ps)
    {
        if (vrePassword.value != vPassword.value)
        {
            caution_inform("Passwords not the same");
            return false;
        }
        new_pwd.value = '1';
        
        
        var formdata = new FormData();
        formdata.append("vMatricNo", vMatricNo.value);
        formdata.append("vPassword", vPassword.value);

        if (rec_pwd.value == '1')
        {
            formdata.append("rec_pwd", '1');
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
    
    ajax.open("POST", "./opr_checkmat.php");
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