function preventBack(){window.history.forward();}
setTimeout("preventBack()", 0);
window.onunload=function(){null};            

function _(el)
{
    return document.getElementById(el)
}

function chk_inputs()
{
    var letters_numbers = /^[A-Za-z0-9_]+$/;
            
    with(ps)
    {
        if (!vMatricNo.value.match(letters_numbers))
        {
            caution_inform("Invalid 'Matriculation (Registration) number'")
            return false;
        }

        if (vMatricNo.value == '')
        {
            caution_inform("Enter your matriculation number")
            return false;
        }
        
        var formdata = new FormData();

        formdata.append("vMatricNo", vMatricNo.value);
        formdata.append("vPassword", vPassword.value);
        formdata.append("user_cat", user_cat.value);
        
        formdata.append("cap_text", cap_text.value);

        if (recover_pwd.value == 1)
        {
            formdata.append("recover_pwd", recover_pwd.value);
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
    
    ajax.open("POST", "student_login_check");
    ajax.send(formdata);
}
    
/*function completeHandler(event)
{
    on_error('0');
    on_abort('0');
    in_progress('0');
    var returnedStr = event.target.responseText;
    returnedStr = returnedStr.trim();

    with(ps)
    {
        if (returnedStr == 'can continue')
        {
            in_progress('1');
            action = './student_recover_password';
            submit();
            return false;
        }else if (returnedStr.indexOf("session created") > -1)
        {
            in_progress('1');
            ilin.value = returnedStr.substr(15);
            action = './welcome_student';
            submit();
            return false;
        }else if (returnedStr == '')
        {
            caution_inform('We could not reach your student email address. Please contact the ICT unit at your study centre for resolution')
        }else
        {
            caution_inform(returnedStr)
        }
    }
}*/

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