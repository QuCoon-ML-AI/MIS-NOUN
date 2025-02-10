function chk_inputs()
{
    var letters_numbers = /^[A-Za-z 0-9]+$/;
    
    with(ps)
    {
        if (chnge.value == 0)
        {
            if (vemployer_address.value == '' && employ_sta.value != 2)
            {
                caution_inform("Please enter the address of your employer");
                return false;
            }
            
            if (vemployer_address.value != '' && !vemployer_address.value.match(letters_numbers))
            {
                caution_inform("Only alphabets and number allowed for Employer address");
                return false;
            }
            
            if (cStudyCenterId.value == '')
            {
                caution_inform("Please select a study centre");
                return false;
            }
            
            

            sidemenu.value = '6'; 
            r_saved.value='1';
            in_progress("1");            
        }
    }
    return true;
}

function updateScrn()
{
    var formdata = new FormData();
update_cat_country
    with(ps)
    {
        formdata.append("chnge", chnge.value);
        formdata.append("vApplicationNo", vApplicationNo.value);
        formdata.append("ilin", ilin.value);

        formdata.append("cStudyCenterId", cStudyCenterId.value);
        formdata.append("cdeptold7", cdeptold7_1st.value);
        formdata.append("study_mode", 'odl');
        formdata.append("cEduCtgId", cEduCtgId.value);
        formdata.append("cFacultyId7", _("cFacultyIdold07").value);
        formdata.append("amount", _("amount").value);
    }
    
    opr_prep(ajax = new XMLHttpRequest(),formdata);
}


function opr_prep(ajax,formdata)
{
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);

    ajax.open("POST", "opr_s7.php");
    ajax.send(formdata);
}

// function completeHandler(event)
// {
//     on_error('0');
//     on_abort('0');
//     in_progress('0');
    
//     var returnedStr = event.target.responseText;
    
//     //inform(returnedStr)
//     //return;

//     if (returnedStr == '')
//     {
//         caution_inform("No match found. Check other departments");
//     }
    
//     if (ps.chnge.value == 1)
//     {
//         var cProgId = ''; cProgdesc = ''; cProgrammeId7 = ''; cReqmtId_all = '';                    
        
//         var cProgrammeId7 = 'cProgrammeId7_1st';
        
//         _(cProgrammeId7).options.length = 0;
//         _(cProgrammeId7).options[_(cProgrammeId7).options.length] = new Option('', '');
        
//         if (returnedStr.indexOf("Lack") != -1 ||
//         returnedStr.indexOf("There are no") != -1 ||
//         returnedStr.indexOf("Olevel qualification") != -1)
//         {
//             caution_inform(returnedStr);
//             return;
//         }
        
//         var middle_string = '';
//         var qual_title = ''; prog_title = ''; adm_crit = ''; lvl = '';

//         returnedStr = returnedStr.trim();
        
//         for (var i = 0; i <= returnedStr.length-1; i+=149)
//         {
//             sReqmtId = returnedStr.substr(i,4);
//             sReqmtId = sReqmtId.trim();

//             cProgId = returnedStr.substr(i+4,10);
//             cProgId = cProgId.trim()+sReqmtId;
            
//             qual_title = returnedStr.substr(i+14, 20);
//             qual_title = qual_title.trim();
            
//             prog_title = returnedStr.substr(i+34,100);
//             prog_title = prog_title.trim();
                        
//             lvl = returnedStr.substr(i+134,15);
//             lvl = lvl.trim();
            
//             cProgdesc = qual_title+' '+prog_title+' '+lvl;
            
//             _(cProgrammeId7).options[_(cProgrammeId7).options.length] = new Option(cProgdesc, cProgId);
//         }
        
//         ps.chnge.value = 0;
//     }
// }


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