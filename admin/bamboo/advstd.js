document.onkeydown = function (e) 
		{
			if (e.ctrlKey && e.keyCode === 85) 
			{
				return false;
			}
		}
			
		function chk_inputs()
		{
			var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
			for (j = 0; j <= ulChildNodes.length-1; j++)
			{
				ulChildNodes[j].style.display = 'none';
			}

            if (sc_1_loc.uvApplicationNo.value == '')
            {
                setMsgBox("labell_msg0","");
                sc_1_loc.uvApplicationNo.focus();
                return false;
            }            
            
            if (_("conf_box_loc").style.display == 'block')
            {
                if (_('veri_token').value == '')
                {
                    setMsgBox('labell_msg_token','Token required');
                    return false;
                }
                
                if (_('veri_token').value != _('hd_veri_token').value)
                {
                    setMsgBox('labell_msg_token','Invalid token');
                    return false;
                }
            }
            
            var formdata = new FormData();

			formdata.append("whattodo", _("whattodo").value);           
            
            if (sc_1_loc.conf.value == '1')
            {
                formdata.append("conf", sc_1_loc.conf.value);
                formdata.append("veri_token", _("hd_veri_token").value);
                formdata.append("app_frm_no", _("app_frm_no").value);

                formdata.append("tSemester", sc_1_loc.tSemester.value);
                formdata.append("next_level", sc_1_loc.next_level_frm_var.value);

                if (_("rev_adv").checked)
                {
                    formdata.append("rev_adv", sc_1_loc.rev_adv.value);
                }
                
            }
            

            if (_("ans6").style.display == 'none')
            {
                formdata.append("process_step", '1');
            }else  if (_("ans6").style.display == 'block')
            {
                formdata.append("process_step", '2');
            }

            formdata.append("currency_cf", _("currency_cf").value);
            formdata.append("user_cat", sc_1_loc.user_cat.value);
            formdata.append("save_cf", _("save_cf").value);
            
            formdata.append("uvApplicationNo", sc_1_loc.uvApplicationNo.value);

            formdata.append("vApplicationNo", sc_1_loc.vApplicationNo.value);
            formdata.append("sm", sc_1_loc.sm.value);
            formdata.append("mm", sc_1_loc.mm.value);
            
            formdata.append("study_mode_ID", sc_1_loc.service_mode.value);
		    formdata.append("staff_study_center", sc_1_loc.user_centre.value);
            
		    opr_prep(ajax = new XMLHttpRequest(),formdata);
		}

	
        function opr_prep(ajax,formdata)
        {
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "opr_advance_student.php");
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
                var at_ind = returnedStr.indexOf("@");
                var dol_ind = returnedStr.indexOf("$");
                var car_ind = returnedStr.indexOf("^");
                var ash_ind = returnedStr.indexOf("#");
                var perc_ind = returnedStr.indexOf("%");
                var bang_ind = returnedStr.indexOf("!");
                var tild_ind = returnedStr.indexOf("~");

                returnedStr = returnedStr.trim();

                if (returnedStr.indexOf("success") == -1 && returnedStr.charAt(0) != '*' && returnedStr.indexOf("?") == -1)
                {
                    _('app_frm_no').value = returnedStr.substr(0,(plus_ind-2));
                        
                    _("std_names").innerHTML = returnedStr.substr(100, 100).trim()+'<br>'+
                    returnedStr.substr(200, 100).trim()+'<br>'+
                    returnedStr.substr(300, 100).trim();
                    student_name = returnedStr.substr(100, 100).trim()+' '+returnedStr.substr(200, 100).trim()+' '+returnedStr.substr(300, 100).trim();

                    _("std_quali").innerHTML = returnedStr.substr(400, 100).trim()+'<br>'+
                    returnedStr.substr(500, 100).trim();
                    student_qualif = returnedStr.substr(400, 100).trim()+' '+returnedStr.substr(500, 100).trim();
                    
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
                    
                    _('level_now').value = returnedStr.substr(600, 100).trim();

                    _("std_lvl").style.display = 'block';
                    student_level = _("std_lvl").innerHTML;

                    if (returnedStr.substr(700, 100).trim() == 1)
                    {
                        if (_("std_sems")){_("std_sems").innerHTML = 'First semester';}
                    }else if (returnedStr.substr(700, 100).trim() == 2)
                    {
                        if (_("std_sems")){_("std_sems").innerHTML = 'Second semester';}
                    }
                    _("std_sems").style.display = 'block';
                    student_semester = _("std_sems").innerHTML;
                    
                    _("std_vCityName").innerHTML = returnedStr.substr(800, 100).trim();				
                    _("std_vCityName").style.display = 'block';
                    student_center =  _("std_vCityName").innerHTML;

                    facult_id = returnedStr.substr(900,100);

                    student_faculty = returnedStr.substr(1000,100).trim();
                    student_dept = returnedStr.substr(1100,100).trim();

                    _("user_cEduCtgId").value = returnedStr.substr(1300,100).trim();



                    _("div_a").innerHTML = _("sc_1_loc").uvApplicationNo.value;
                    
                    _("div_0").innerHTML = student_name;//name
					_("div_1").innerHTML = student_center;
                    
                    _("div_2").innerHTML = student_faculty;//faculty
					_("div_3").innerHTML = student_dept;//dept
					_("div_4").innerHTML = student_qualif;//programme
					_("div_5").innerHTML = student_level;//level
                    if (student_semester != '')
                    {
                        _("div_5").innerHTML = student_level+'/'+student_semester;//level/semester
                    }
                    
                    _("ans6").style.display = 'block';

                    var next_level = _("level_now").value;
                    
                    if (_("rev_adv").checked)
                    {
                        sc_1_loc.tSemester.value = 2;
                        if (student_semester == '1')
                        {
                            sc_1_loc.tSemester.value = 1;
                        }
                    }else
                    {
                        sc_1_loc.tSemester.value = 1;
                        if (student_semester == '2')
                        {
                            sc_1_loc.tSemester.value = 2;
                        }
                    }

                    // var semester = 'first semester';
                    // if (sc_1_loc.tSemester.value == 2)
                    // {
                    //     semester = 'second semester';
                    // }

                    if (_("rev_adv").checked)
                    {
                        if (_("user_cEduCtgId").value == 'ELZ')
                        {
                            if (parseInt(next_level) - 10 > 0)
                            {
                                next_level = parseInt(next_level) - 10;
                            }
                        }else 
                        {
                            if (parseInt(next_level) - 100 > 0)
                            {
                                next_level = parseInt(next_level) - 100;
                            }
                        }
                    }else
                    {
                        if (_("user_cEduCtgId").value == 'ELZ')
                        {
                            next_level = parseInt(next_level) + 10;
                            
                        }else 
                        {
                            next_level = parseInt(next_level) + 100;
                        }
                    }
                    
                    sc_1_loc.next_level_frm_var.value = next_level;
                }

                returnedStr = returnedStr.substr(ash_ind+1);


                var semester = 'first semester';
                if (sc_1_loc.tSemester.value == 2)
                {
                    semester = 'second semester';
                }

                
                if (returnedStr.indexOf("success") != -1)
                {
                    success_box(returnedStr.substr(1,returnedStr.length-1));

                    _("hd_veri_token").value = '';
                    _("veri_token").value = '';

                    _('conf_box_loc').style.display='none';
                    _('smke_screen_2').style.display='none';
                    _('smke_screen_2').style.zIndex='-1';
                }else  if (returnedStr.indexOf("?") != -1)
                {                    
                    _("submityes0").style.display = 'block';
                    _("hd_veri_token").value = returnedStr.substr(0,6);

                    var move_dir = 'advanced';
                    if (_("rev_adv").checked)
                    {
                        move_dir = 'reversed';
                    }

                    _("conf_msg_msg_loc").innerHTML = 'Student will be '+move_dir+' to '+sc_1_loc.cAcademicDesc.value+' '+sc_1_loc.next_level_frm_var.value+', '+semester+'<br>'+returnedStr.substr(6);

                    _('conf_box_loc').style.display = 'block';
                    _('conf_box_loc').style.zIndex = '3';
                    _('smke_screen_2').style.display = 'block';
                    _('smke_screen_2').style.zIndex = '2';
                }else if (returnedStr.charAt(0) == '*')
                {
                    caution_box(returnedStr.substr(1,returnedStr.length-1))
                }
                
                if (returnedStr.indexOf("success") == -1)
                {
                    _("passprt").src = '../../ext_docs/pics/'+facult_id+'/pp/p_'+_('app_frm_no').value+'.jpg';
                    _("passprt").onerror = function() {myFunction()};

                    function myFunction()
                    {
                        _("passprt").src = 'img/p_.png'
                    }
                    sc_1_loc.uvApplicationNo_loc.value = _('app_frm_no').value;
                }
                
                sc_1_loc.conf.value = '';
            }
        }

        
        function tidy_screen()
        {        
            _("ans6").style.display = 'none';
            
            sc_1_loc.conf.value = '';
            
            var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
            for (j = 0; j <= ulChildNodes.length-1; j++)
            {
                ulChildNodes[j].style.display = 'none';
            }

            _("user_cEduCtgId").value = '';
        }