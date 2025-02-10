document.onkeydown = function (e) 
{
    if (e.ctrlKey && e.keyCode === 85) 
    {
        return false;
    }
}
    
function chk_inputs()
{
    var formdata = new FormData();

    formdata.append("ilin", sc_1_loc.ilin.value);
    formdata.append("vApplicationNo", sc_1_loc.vApplicationNo.value);
    formdata.append("ilin", sc_1_loc.ilin.value);
    formdata.append("candidate_count", sc_1_loc.candidate_count.value);
    
    opr_prep(ajax = new XMLHttpRequest(),formdata);
}


function opr_prep(ajax,formdata)
{
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    ajax.open("POST", "opr_req_m.php");
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

function completeHandler(event)
{
    on_error('0');
    on_abort('0');
    in_progress('0');

    var returnedStr = event.target.responseText;
    if (returnedStr.indexOf("success") > -1)
    {
        success_box(returnedStr);
    }else
    {
        caution_box(returnedStr);
    }
}