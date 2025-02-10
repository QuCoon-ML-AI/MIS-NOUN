function _(el)
{
    return document.getElementById(el)
}

// function chk_inputs()
// {
//     var letters = /^[A-Za-z - ']+$/;           

//     with(to_remita)
//     {
//         if (orderId.value.trim() == '' &&  rrr.value.trim() == '')
//         {
//             caution_inform("Fill out either the order ID or the RRR");
//             return false;
//         }

//         if (!vLastName.value.match(letters))
//         {
//             caution_inform("Enter alphabets only for surname please");
//             return false;
//         }

//         if (!vFirstName.value.match(letters))
//         {
//             caution_inform("Enter alphabets only for first name please");
//             return false;
//         }

//         if (vOtherName.value.trim() != '' && !vOtherName.value.match(letters))
//         {
//             caution_inform("Enter alphabets only for other name please");
//             return false;
//         }

//         if (vLastName.value.trim().length < 3)
//         {
//             caution_inform("Enter last name in full please");
//             return false;
//         }
    
//         if (vFirstName.value.trim().length < 3)
//         {
//             caution_inform("Enter first name in full please");
//             return false;
//         }
    
//         if (vOtherName.value.trim() != '' && vOtherName.value.trim().length < 3)
//         {
//             caution_inform("Enter other name in full please");
//             return false;
//         }

//         if (chk_mail(_('payerEmail')) != '')
//         {
//             caution_inform('Personal eMail address '+chk_mail(_('payerEmail')));
//             return false;
//         }

//         if (cEduCtgId.value == '')
//         {
//             caution_inform("Select a programme please");
//             return false;
//         }
        
//         var formdata = new FormData();

//         formdata.append("rrr", rrr.value);
//         formdata.append("orderId", orderId.value);
            
//         formdata.append("vLastName", vLastName.value);
//         formdata.append("vFirstName", vFirstName.value);
//         formdata.append("vOtherName", vOtherName.value);
//         formdata.append("vEMailId", payerEmail.value);
//         formdata.append("vMobileNo", payerPhone.value);
//         formdata.append("amount", amount.value);
//         formdata.append("confirm_pay", '1');

//         opr_prep(ajax = new XMLHttpRequest(),formdata);
//     }
// }


function opr_prep(ajax,formdata)
{
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
            
    ajax.open("POST", "opr_pay_1.php");
    ajax.send(formdata);
}


/*function completeHandler(event)
{
    on_error('0');
    on_abort('0');
    in_progress('0');
    var returnedStr = event.target.responseText;//alert(returnedStr)
    
    _("submit_btn").style.display = 'block';
    _("continue_btn").style.display = 'none';

    if (returnedStr.indexOf("No match found") > -1)
    {
        caution_inform(returnedStr);
    }else if (returnedStr.indexOf("Got AFN") > -1)
    {
        inform("Payment already concluded successfully. Click continue to proceed");
        _("submit_btn").style.display = 'none';
        _("continue_btn").style.display = 'block';

        nxt.action ='new-application-number';
        
        nxt.vApplicationNo.value = returnedStr.substr(7,9);
        nxt.vApplicationNo.value.trim(); 
        nxt.payerName.value = '';
        nxt.payerEmail.value = to_remita.payerEmail.value;
    }else if (returnedStr.indexOf("success") != -1)
    {
        inform("Payment already concluded successfully.<br>Click continue to login to your application form with your application form number and password<br>Check your email box for your application number<br>Click on 'Reset password' on the login page if you do not have a password<br>See guide under 'Help'");
        _("submit_btn").style.display = 'none';
        _("continue_btn").style.display = 'block';

        nxt.action ='applicant_login_page';
    }else
    {
        with(to_remita)
        {
            payerName.value = vLastName.value+' '+vFirstName.value+' '+vOtherName.value;
            
            rrr.value = returnedStr.substr(0,50).trim();
            orderId.value = returnedStr.substr(50,50).trim();
            p_status.value = returnedStr.substr(100,50).trim();
            
            submit();
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
    
    with (to_remita)
    {
        orderId.value = '';
        rrr.value = '';
        
        payerName.value = '';
        vLastName.value = '';
        vFirstName.value = '';

        vOtherName.value = '';
        payerEmail.value = '';
        payerPhone.value = '';

        department.value = ''; 
    }
    _('pinfo').style.display='none';
}