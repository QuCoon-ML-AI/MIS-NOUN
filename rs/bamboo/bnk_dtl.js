function _(el)
{
    return document.getElementById(el)
}

function chk_inputs_cps()
{
    var letters = /^[A-Za-z -]+$/;   
    var formdata = new FormData();

    with(chk_p_sta)
    {
        if (!b_account_name.value.match(letters))
        {
            caution_inform("Enter alphabets only for account name please");
            return false;
        }
        
        var text = b_account_no.value.toString()
        
        if (text.length != 10)
        {
            caution_inform("Account number must be 10 digits");
            return false
        }
        
        formdata.append("user_cat", user_cat.value);
        formdata.append("vMatricNo", vMatricNo.value);
        formdata.append("ilin", ilin.value);
        
        formdata.append("bank_id", bank_id.value);
        formdata.append("b_account_no", b_account_no.value);
        formdata.append("b_account_name", b_account_name.value);
        
        formdata.append("bank_id_h", bank_id_h.value);
        formdata.append("b_account_no_h", b_account_no_h.value);
        formdata.append("b_account_name_h", b_account_name_h.value);
    }
    
    opr_prep(ajax = new XMLHttpRequest(),formdata);
}

function opr_prep(ajax,formdata)
{
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    
    ajax.open("POST", "back_end_update_bank_detail");
    
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