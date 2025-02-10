// function preventBack(){window.history.forward();}
// setTimeout("preventBack()", 0);
// //window.onunload=function(){null};    

// function _(el)
// {
//     return document.getElementById(el)
// }

// function chk_inputs()
// {
//     var numbers = /^[0-9]+$/;

//     with(ps)
//     {
//         if (!vApplicationNo.value.match(numbers))
//         {
//             caution_inform("Invalid 'User name (Staff ID)'")
//             return false;
//         }

//         if (vApplicationNo.value == '')
//         {
//             caution_inform("Enter your user name")
//             return false;
//         }
        
//         var formdata = new FormData();

//         formdata.append("vApplicationNo", vApplicationNo.value);
//         formdata.append("vPassword", vPassword.value);
//         formdata.append("user_cat", user_cat.value);
//         formdata.append("cap_text", cap_text.value);
//         if (recover_pwd.value == 1)
//         {
//             formdata.append("recover_pwd", recover_pwd.value);
//         }

//         formdata.append("token_sent", token_sent.value);
//     }
//     opr_prep(ajax = new XMLHttpRequest(),formdata);
// }


// function opr_prep(ajax,formdata)
// {
//     ajax.upload.addEventListener("progress", progressHandler, false);
//     ajax.addEventListener("load", completeHandler, false);
//     ajax.addEventListener("error", errorHandler, false);
//     ajax.addEventListener("abort", abortHandler, false);
    
//     ajax.open("POST", "opr_staff_l_ins.php");
//     ajax.send(formdata);
// }
    
        
// function completeHandler(event)
// {
//     on_error('0');
//     on_abort('0');
//     in_progress('0');
//     var returnedStr = event.target.responseText;
//     returnedStr = returnedStr.trim();

//     with(ps)
//     {
//         if (returnedStr == 'can continue')
//         {
//             in_progress('1');
//             action = './staff_recover_password';
//             submit();
//             return false;
//         }else if (returnedStr.indexOf("session created") > -1)
//         {
//             in_progress('1');
//             ilin.value = returnedStr.substr(15);
//             action = './staff_home_page';
//             submit();
//             return false;
//         }else if (returnedStr.trim() == '')
//         {
//             caution_inform('We could not reach your official email address. Contact MIS for resolution')
//         }else if (returnedStr == '1')
//         {
//             token_sent.value = '1';
//         }else
//         {
//             caution_inform(returnedStr)
//         }
//     }
// }

// function progressHandler(event)
// {
//     in_progress('1');
// }

// function errorHandler(event)
// {
//     on_error('1');
// }

// function abortHandler(event)
// {
//     on_abort('1');
// }