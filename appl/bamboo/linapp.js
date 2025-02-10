function preventBack(){window.history.forward();}
setTimeout("preventBack()", 0);
window.onunload=function(){null};

function chk_inputs()
{
    with(ps)
    {
        var numbers = /^[0-9]+$/;
        
        if (!vApplicationNo.value.match(numbers))
        {
            caution_inform("Invalid 'Application form number'")
            return false;
        }

        if (vApplicationNo.value == '')
        {
            caution_inform("Enter your application form number")
            return false;
        }

        if (vApplicationNo.value.length < 7)
        {
            caution_inform("Invalid application form number")
            return false;
        }
        
        var formdata = new FormData();
        formdata.append("vApplicationNo", vApplicationNo.value);
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

    with(ps)
    {
        if (returnedStr == 'can continue')
        {
            in_progress('1');
            
            //action = './applicant_recover_password';
            action = './applicant_reset_password'; 

            submit();
            return false;
        }else if (returnedStr.indexOf("session created") > -1)
        {
            in_progress('1');
            ilin.value = returnedStr.substr(15);
            action = './applicant_welcome_page';
            submit();
            return false;
        }else if (returnedStr == '')
        {
            caution_inform('We could not reach your email address. Please ensure your email address is functional')
        }else
        {
            caution_inform(returnedStr)
        }
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