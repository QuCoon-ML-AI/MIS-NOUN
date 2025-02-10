function _(el)
{
    return document.getElementById(el)
}



function chk_dob()
{
                    
    var formdata = new FormData();
    formdata.append("save", '1');

    var letters = /^[A-Za-z -]+$/;
    var letters_numbers = /^[A-Za-z 0-9]+$/;

    with(to_remita)
    {
        if (!vLastName.value.match(letters))
        {
            caution_inform("Enter alphabets only for surname please");
            return false;
        }

        if (!vFirstName.value.match(letters))
        {
            caution_inform("Enter alphabets only for first name please");
            return false;
        }

        if (vOtherName.value.trim() != '' && !vOtherName.value.match(letters))
        {
            caution_inform("Enter alphabets only for other name please");
            return false;
        }

        if (vLastName.value.trim().length < 3)
        {
            caution_inform("Enter surname in full please");
            return false;
        }
    
        if (vFirstName.value.trim().length < 3)
        {
            caution_inform("Enter first name in full please");
            return false;
        }
    
        if (vOtherName.value.trim() != '' && vOtherName.value.trim().length < 3)
        {
            caution_inform("Enter other name in full please");
            return false;
        }

        if (chk_mail(_('payerEmail')) != '')
        {
            caution_inform('Personal eMail address '+chk_mail(_('payerEmail')));
            return false;
        }

        if (cEduCtgId.value == '')
        {
            caution_inform("Select a programme category please");
            return false;
        }


        if (cEduCtgId.value == 'PSZ')
        {
            if (jambno.value == '')
            {
                caution_inform("Enter JAMB registration number");
                return false;
            }

            if (jambno.value != '' && !jambno.value.match(letters_numbers))
            {
                caution_inform("Enter alphabets and numbers only for JAMB registration number");
                return false;
            }
        }
        
        
        formdata.append("vLastName", vLastName.value);
        formdata.append("vFirstName", vFirstName.value);
        formdata.append("vOtherName", vOtherName.value);
        formdata.append("dBirthDate", dBirthDate.value);
        formdata.append("cEduCtgId", cEduCtgId.value);
        
        formdata.append("payerEmail", payerEmail.value);
        formdata.append("payerPhone", payerPhone.value);
    }

    opr_prep(ajax = new XMLHttpRequest(),formdata);   
}


function opr_prep(ajax,formdata)
{
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    
    ajax.open("POST", "check_for_running_programme");
    ajax.send(formdata);
}
    
function completeHandler(event)
{
    on_error('0');
    on_abort('0');
    in_progress('0');
    var returnedStr = event.target.responseText;
    returnedStr = returnedStr.trim();
    
    if (returnedStr == 'can apply')
    {
        in_progress('1');
        to_remita.submit();
        return false;
    }else if (returnedStr == '')
    {
        caution_inform('We are unable to reach the email address you entered. Please enter a functional email address');
    }else
    {
        caution_inform(returnedStr);
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



function show_appl_cat(section)
{
    var ulChildNodes = _("right_div").getElementsByTagName("input");
    for (j = 0; j <= ulChildNodes.length-1; j++)
    {
        if (ulChildNodes[j].type == 'radio')
        {
            ulChildNodes[j].checked = false;
        }
    }

    var ulChildNodes = _("container_cover_ini_pay").getElementsByTagName("input");
    for (j = 0; j <= ulChildNodes.length-1; j++)
    {
        if (ulChildNodes[j].type == 'radio')
        {
            ulChildNodes[j].checked = false;
        }
    }
    
    var ulChildNodes = _("right_div").getElementsByClassName("lbl_beh_l");
    for (j = 0; j <= ulChildNodes.length-1; j++)
    {
        ulChildNodes[j].style.display = 'none';
    }

    var ulChildNodes = _("right_div").getElementsByClassName("lbl_beh_f");
    for (j = 0; j <= ulChildNodes.length-1; j++)
    {
        ulChildNodes[j].style.display = 'none';
    }
    

    if (section == 'lbl_beh_f')
    {
        caution_inform('Coming soon...');
    }else
    {
        var ulChildNodes = _("right_div").getElementsByClassName(section);
        for (j = 0; j <= ulChildNodes.length-1; j++)
        {
            ulChildNodes[j].style.display = 'block';
        }
    }
    
    with(to_remita)
    {
        cEduCtgId.value = '';

        payerName.value = '';
        vLastName.value = '';
        vFirstName.value = '';
        vOtherName.value = '';
        dBirthDate.value = '';
        payerEmail.value = '';
        payerPhone.value = '';
        department.value = ''; 
    }
    
    _('pinfo').style.display='none';
}