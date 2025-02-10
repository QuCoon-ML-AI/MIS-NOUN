function _(el)
{
    return document.getElementById(el)
}

// function chk_inputs()
// {
//     var letters = /^[A-Za-z -]+$/;

//     if (!_("vLastName").value.match(letters))
//     {
//         caution_inform("Enter alphabets only for last name please");
//         return false;
//     }

//     if (_('vLastName').value.length < 3)
//     {
//         caution_inform("Abrevition not allowed for last name");
//         return false;
//     }


//     if (!_("vFirstName").value.match(letters))
//     {
//         caution_inform("Enter alphabets only for first name please");
//         return false;
//     }
    
//     if (_('vFirstName').value.length < 3)
//     {
//         caution_inform("Abrevition not allowed for first name");
//         return false;
//     }
    

//     if (_('vOtherName').value.length > 0 && !_("vFirstName").value.match(letters))
//     {
//         caution_inform("Enter alphabets only for other name please")
//         return false;
//     }

//     if (_('vOtherName').value.length > 0 && _('vOtherName').value.length < 3)
//     {
//         caution_inform("Abrevition not allowed for other name")
//         return false;
//     }
    
//     if (_('cnin').value.length != 11)
//     {
//         caution_inform("Invalid NIN")
//         return false;
//     }

    
//     var files = _("sbtd_pix").files;
    
//     if (_("sbtd_pix").files.length > 0)
//     {  
//         if (!fileValidation("sbtd_pix"))
//         {
//             caution_inform("Only JPG file format for passport picture is allowed");
//             return false;
//         }

//         max_size = _("max_size_of_pp").value * 1000
        
//         if (files[0].size > max_size)
//         {                        
//             size = files[0].size/1000;
//             caution_inform("File too large. Max. size: 100KB. Attempted size: "+size+"KB")
//             return false;
//         }
//     }
    
//     if (_('name_warn').value == 0 && !_('vLastName').readOnly)
//     {
//         caution_inform("Names can only be entered once. Ensure they are correct")

//         _('name_warn').value = 1;
//         return false;
//     }
    
//     var formdata = new FormData();
//     formdata.append("save", '1');

//     formdata.append("user_cat", ps.user_cat.value);
//     formdata.append("vApplicationNo", ps.vApplicationNo.value);
    
//     formdata.append("ilin",ps.ilin.value);

//     formdata.append("vTitle", _("vTitle").value);
//     formdata.append("vLastName", _("vLastName").value);
//     formdata.append("vFirstName", _("vFirstName").value);
//     formdata.append("vOtherName", _("vOtherName").value);
//     formdata.append("cGender", _("cGender").value);
    
//     formdata.append("cnin", _("cnin").value);
//     formdata.append("dBirthDate", _("dBirthDate").value);
//     formdata.append("cEduCtgId", ps.cEduCtgId.value);
    

//     if (files.length > 0)
//     {
//         formdata.append("sbtd_pix", _("sbtd_pix").files[0]);
//     }

//     opr_prep(ajax = new XMLHttpRequest(),formdata);   
// }


function opr_prep(ajax,formdata)
{
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    
    ajax.open("POST", "opr_s1a.php");
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
        ps.sidemenu.value = '1b';
        ps.r_saved.value = '1';
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