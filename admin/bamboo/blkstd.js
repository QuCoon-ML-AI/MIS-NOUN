document.onkeydown = function (e) 
{
    if (e.ctrlKey && e.keyCode === 85) 
    {
        return false;
    }
}
    
/*function chk_inputs()
{
    var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
    for (j = 0; j <= ulChildNodes.length-1; j++)
    {
        ulChildNodes[j].style.display = 'none';
    }

    _("smke_screen_2").style.display = "none";
    
    if (!sc_1_loc.uvApplicationNo.disabled && sc_1_loc.uvApplicationNo.value == '')
    {
        setMsgBox("labell_msg0","");
        sc_1_loc.uvApplicationNo.focus();
        return false;
    }  

    if (!sc_1_loc.bulk_change.disabled && sc_1_loc.bulk_change.value.trim() == '')
    {
        setMsgBox("labell_msg1","");
        sc_1_loc.bulk_change.focus();
        return false;
    }

    if (trim(sc_1_loc.rect_risn.value) == '')
    {
        setMsgBox("labell_msg2","");
        sc_1_loc.rect_risn.focus();
        return false;
    }

    var formdata = new FormData();

    formdata.append("rect_risn", _("rect_risn").value);
    
    formdata.append("id_no", _("id_no").value);
    formdata.append("whattodo", _("whattodo").value)
    

    if (sc_1_loc.conf.value == '1')
    {
        formdata.append("conf", sc_1_loc.conf.value);
    }

    
    formdata.append("ilin", sc_1_loc.ilin.value);
    formdata.append("user_cat", sc_1_loc.user_cat.value);
    
    if (!sc_1_loc.uvApplicationNo.disabled)
    {
        formdata.append("uvApplicationNo", sc_1_loc.uvApplicationNo.value);
    }    
            
    if (!sc_1_loc.bulk_change.disabled)
    {
        formdata.append("bulk_change", _("bulk_change").value);
    }

    formdata.append("vApplicationNo", sc_1_loc.vApplicationNo.value);
    formdata.append("sm", sc_1_loc.sm.value);
    formdata.append("mm", sc_1_loc.mm.value);
    
    formdata.append("staff_study_center", sc_1_loc.user_centre.value);
    formdata.append("sRoleID", _('sRoleID').value);

    
    
    opr_prep(ajax = new XMLHttpRequest(),formdata);
}*/


function opr_prep(ajax,formdata)
{
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    if (_("whattodo").value == 4)
    {
        ajax.open("POST", "opr_blk.php");
    }else if (_("whattodo").value == 5)
    {
        ajax.open("POST", "opr_unblk.php");
    }
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

    if (_("whattodo"))
    { 
        var plus_ind = returnedStr.indexOf("+");
        var ash_ind = returnedStr.indexOf("#");

        var mask = '';
        
        facult_id = returnedStr.substr(ash_ind-100,3);

        if (!sc_1_loc.uvApplicationNo.disabled && returnedStr.indexOf("success") == -1)
        {
            if (_("id_no") && _("id_no").value == 0)
            {
                _("std_names").innerHTML = returnedStr.substr(0, 100).trim()+'<br>'+
                returnedStr.substr(100, 100).trim()+'<br>'+
                returnedStr.substr(200, 100).trim();

                _("std_quali").innerHTML = returnedStr.substr(300, 100).trim()+'<br>'+
                returnedStr.substr(400, 100).trim();
                
                if (returnedStr.substr(500, 100).trim() == 20)
                {
                    _("std_lvl").innerHTML = 'DIP 1';
                }else if (returnedStr.substr(500, 100).trim() == 30)
                {
                    _("std_lvl").innerHTML = 'DIP 2';
                }else
                {
                    _("std_lvl").innerHTML = returnedStr.substr(500, 100).trim()+' Level';
                }
                _("std_lvl").style.display = 'block';

                _("std_sems").style.display = 'none';
                
                _("std_vCityName").innerHTML = returnedStr.substr(700, 100).trim();
                _("std_vCityName").style.display = 'block';

                facult_id = returnedStr.substr(800, 100).trim();
                
                mask = returnedStr.substr(900, 100).trim();
            }else if (_("id_no") && _("id_no").value == 1)
            {
                _('app_frm_no').value = returnedStr.substr(0,plus_ind);
                _("std_names").innerHTML = returnedStr.substr(100, 100).trim()+'<br>'+
                returnedStr.substr(200, 100).trim()+'<br>'+
                returnedStr.substr(300, 100).trim();
                _("std_quali").innerHTML = returnedStr.substr(400, 100).trim()+'<br>'+
                returnedStr.substr(500, 100).trim();
                
                if (returnedStr.substr(600, 100).trim() == 20)
                {
                    _("std_lvl").innerHTML = 'DIP 1';
                }else if (returnedStr.substr(600, 100).trim() == 30)
                {
                    _("std_lvl").innerHTML = 'DIP 2';
                }else
                {
                    _("std_lvl").innerHTML = returnedStr.substr(600, 100).trim()+' Level';
                }	
                
                _("std_lvl").style.display = 'block';

                if (returnedStr.substr(700, 100).trim() == 1)
                {
                    if (_("std_sems")){_("std_sems").innerHTML = 'First semester';}
                }else
                {
                    if (_("std_sems")){_("std_sems").innerHTML = 'Second semester';}
                }
                _("std_sems").style.display = 'block';
                
                _("std_vCityName").innerHTML = returnedStr.substr(800, 100).trim();				
                _("std_vCityName").style.display = 'block';
                
                facult_id = returnedStr.substr(900, 100).trim();
                
                mask = returnedStr.substr(1000, 100).trim();
            }
        }

        
        returnedStr = returnedStr.substr(ash_ind+1);
        
        if (returnedStr.indexOf("success") != -1)
        {
            success_box(returnedStr);
        }else  if (returnedStr.indexOf("?") != -1)
        {
            _("conf_msg_msg_loc").innerHTML = returnedStr;
            _('conf_box_loc').style.display = 'block';
            _('conf_box_loc').style.zIndex = '3';
            _('smke_screen_2').style.display = 'block';
            _('smke_screen_2').style.zIndex = '2';
        }else if (returnedStr.trim() == '')
        {
            caution_box('Error');
        }else
        {
            caution_box(returnedStr)
        }

        if (!sc_1_loc.uvApplicationNo.disabled && returnedStr.indexOf("success") == -1)
        {
            if (_("id_no") && _("id_no").value == 0 && returnedStr.indexOf('not yet submitted') != -1)
            {
                _("passprt").src = '../appl/img/left_side_logo.png';
            }else
            {
                if (_("id_no") && _("id_no").value == 0)
                {	
                    _("passprt").src = '../../ext_docs/pics/'+facult_id+'/pp/p_'+mask+'.jpg';
                    _("passprt").onerror = function() {myFunction1()};
                    function myFunction1()
                    {
                        _("passprt").src = '../../ext_docs/pics/'+facult_id+'/pp/p_'+mask+'.jpeg';

                        _("passprt").onerror = function() {myFunction2()};

                        function myFunction2() 
                        {
                            _("passprt").src = '../../ext_docs/pics/'+facult_id+'/pp/p_'+mask+'.pjpeg';
                            _("passprt").onerror = function() {myFunction3()};

                            function myFunction3() 
                            {
                                _("passprt").src = '../appl/img/left_side_logo.png';
                            }
                        }
                    }
                }else if (_("id_no") && _("id_no").value == 1)
                {
                    _("passprt").src = '../../ext_docs/pics/'+facult_id+'/pp/p_'+mask+'.jpg';
                    _("passprt").onerror = function() {myFunction1()};
                    function myFunction1()
                    {
                        _("passprt").src = '../../ext_docs/pics/'+facult_id+'/pp/p_'+mask+'.jpeg';

                        _("passprt").onerror = function() {myFunction2()};

                        function myFunction2() 
                        {
                            _("passprt").src = '../../ext_docs/pics/'+facult_id+'/pp/p_'+mask+'.pjpeg';
                            _("passprt").onerror = function() {myFunction3()};

                            function myFunction3() 
                            {
                                _("passprt").src = '../appl/img/left_side_logo.png';
                            }
                        }
                    }
                    sc_1_loc.uvApplicationNo_loc.value = _('app_frm_no').value;
                }
            }
        }

        sc_1_loc.conf.value = '';
    }
}


function tidy_screen()
{
    _("pasUpldFlg").value = 0;
    
    
    sc_1_loc.conf.value = '';
    sc_1_loc.conf_g.value = '';
    
    var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
    for (j = 0; j <= ulChildNodes.length-1; j++)
    {
        ulChildNodes[j].style.display = 'none';
    }

    _("smke_screen_2").style.display = "none";
    _("smke_screen_2").style.zIndex = -1;
    _("container_cover_in").style.display = "none";
    _("container_cover_in").style.zIndex = -1;
    
    _("user_cEduCtgId").value = '';
}