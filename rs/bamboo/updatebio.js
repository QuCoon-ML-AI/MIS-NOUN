function _(el)
{
    return document.getElementById(el)
}

function chk_inputs_cps()
{
    var letters_numbers = /^[A-Za-z 0-9]+$/;
    var letters = /^[A-Za-z ]+$/;

    var formdata = new FormData();

    with(chk_p_sta)
    {
        if (upld_passpic_no.value > 0 && std_upld_passpic_no.value > 0)
        {
            var files = sbtd_pix.files;
        
            if (sbtd_pix.files.length > 0)
            {  
                if (!fileValidation("sbtd_pix"))
                {
                    caution_inform("JPEG file format required for passport picture");
                    return false;
                }
                
                if (files[0].size > 50100)
                {                        
                    size = files[0].size/1000;
                    caution_inform("File of passport picture is too big. Max. size is 50KB. Attempted size is "+size+"KB")
                    return false;
                }
            }                    
        
            if (_("sbtd_pix").files.length != 0)
            {
                formdata.append("sbtd_pix", _("sbtd_pix").files[0]);
            }
        }
        
        if (!vResidenceCityName.value.match(letters))
        {
            caution_inform("Only alphabets are allowed for name of 'Town'")
            return false;
        }
        
        if (!vResidenceAddress.value.match(letters_numbers))
        {
            caution_inform("Only numbers and alphabets are allowed for 'Street address'")
            return false;
        }

        if (!vNOKName.value.match(letters))
        {
            caution_inform("Only alphabets are allowed for 'Name'")
            return false;
        }
        
        if (!vNOKAddress.value.match(letters_numbers))
        {
            caution_inform("Only numbers and alphabets are allowed for 'Address'")
            return false;
        }
        
        formdata.append("vMatricNo", vMatricNo.value);
        formdata.append("ilin", ilin.value);
        
        formdata.append("cMaritalStatusId", cMaritalStatusId.value);
        formdata.append("cDisabilityId", cDisabilityId.value);
        formdata.append("cResidenceCountryId", cResidenceCountryId.value);

        formdata.append("cResidenceStateId", cResidenceStateId.value);
        formdata.append("cResidenceLGAId", cResidenceLGAId.value);
        formdata.append("vResidenceCityName", vResidenceCityName.value);
        formdata.append("vResidenceAddress", vResidenceAddress.value);
        
        formdata.append("vEMailId", vEMailId.value);
        formdata.append("vMobileNo", vMobileNo.value);
        formdata.append("w_vMobileNo", w_vMobileNo.value);

        formdata.append("vNOKName", vNOKName.value);
        formdata.append("vNOKMobileNo", vNOKMobileNo.value);
        formdata.append("vNOKEMailId", vNOKEMailId.value);
        formdata.append("vNOKAddress", vNOKAddress.value);
        formdata.append("cNOKType", cNOKType.value);
        
        formdata.append("cFacultyId", cFacultyId.value);
        formdata.append("cEduCtgId", cEduCtgId.value);
        formdata.append("vApplicationNo", vApplicationNo.value);
        
        formdata.append("std_upld_passpic_no", std_upld_passpic_no.value);
        formdata.append("upld_passpic_no", upld_passpic_no.value);
        formdata.append("vmask", vmask.value);

        formdata.append("token_req", token_req.value);

        if (token_req.value == '1')
        {
            formdata.append("user_token", p_token.value);
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
    
    ajax.open("POST", "back_end_update_bio_data");
    
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
        chk_p_sta.token_req.value = '1';
        _('token_box').style.display = 'block';
        _('p_token').focus();
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