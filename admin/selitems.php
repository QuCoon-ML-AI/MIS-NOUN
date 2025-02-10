<?php
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/applform.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php
require_once('var_colls.php');

$currency = 1;

$mysqli = link_connect_db();

$service_mode = '';
$num_of_mode = 0;
$service_centre = '';
$num_of_service_centre = 0;

if (isset($_REQUEST['vApplicationNo']))
{
	$centres = do_service_mode_centre("2", $_REQUEST['vApplicationNo']);	
	$service_centre = substr($centres,10);
	$num_of_service_centre = trim(substr($centres,0, 9));
}


$orgsetins = settns();
require_once('set_scheduled_dates.php');
require_once('staff_detail.php');?>

<!-- InstanceBeginEditable name="doctitle" -->
<title>NOUN-MIS</title>
<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
<!-- InstanceEndEditable -->




<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
<script language="JavaScript" type="text/javascript" src="button_ops.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />
<script language="JavaScript" type="text/javascript">
	document.onkeydown = function (e) 
	{
		if (e.ctrlKey && e.keyCode === 85) 
		{
            return false;
        }
	}
</script>
<noscript></noscript>

<!-- InstanceBeginEditable name="head" -->
<script language="JavaScript" type="text/javascript">
    function chk_inputs()
	{
		var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			ulChildNodes[j].style.display = 'none';
		}
		
		if (_("whatodo").value == 'd')
		{
		 	var formdata = new FormData();
			formdata.append("currency_cf", _("currency_cf").value);
			formdata.append("user_cat", selitems_loc.user_cat.value);
			formdata.append("save_cf", '1');
			formdata.append("vApplicationNo", selitems_loc.vApplicationNo.value);
			
			formdata.append("study_mode_ID", selitems_loc.study_mode_ID.value);
			formdata.append("sm", selitems_loc.sm.value);
			formdata.append("mm", selitems_loc.mm.value);
			
			formdata.append("iItemID", _("iItemID_h").value);
			formdata.append("conf", selitems_loc.conf.value);
			
			formdata.append("whatodo", _('whatodo').value);
			formdata.append("ilin", selitems_loc.ilin.value);
            
			opr_prep(ajax = new XMLHttpRequest(),formdata);
		}else if (_("whatodo").value == 'da')
		{
		 	var formdata = new FormData();
			formdata.append("currency_cf", _("currency_cf").value);
			formdata.append("user_cat", selitems_loc.user_cat.value);
			formdata.append("save_cf", '1');
			formdata.append("vApplicationNo", selitems_loc.vApplicationNo.value);
			
			formdata.append("study_mode_ID", selitems_loc.study_mode_ID.value);
			formdata.append("sm", selitems_loc.sm.value);
			formdata.append("mm", selitems_loc.mm.value);
			
			formdata.append("fee_item_id", _("vDesc_loc").value);
			formdata.append("item_cat", _("item_cat_loch").value);
			formdata.append("cEduCtgId", _("cEduCtgId_loc").value);
			formdata.append("new_old_structure", _("new_old_structure").value);

			formdata.append("conf", selitems_loc.conf.value);
			
			formdata.append("whatodo", _('whatodo').value);
			formdata.append("ilin", selitems_loc.ilin.value);
			
			opr_prep(ajax = new XMLHttpRequest(),formdata);
		}else if (_("cEduCtgId_loc").value == '')
		{
			setMsgBox("labell_msg0","");
			_("cEduCtgId_loc").focus();
		}else if (_("item_cat_div").style.display == 'block' && _("item_cat").value == '')
		{
			setMsgBox("labell_msg4","");
			_("item_cat").focus();
		}else if (_("item_cat_div").style.display == 'block' && _("whatodo").value == 'e' && _("item_cat").value != _("item_cat_loch").value && _('conf_loc').value == '')
		{
			setMsgBox("labell_msg4","Warning! This changes item category");
			_('conf_loc').value = '1'
			_("item_cat").focus();
		}/*else if (_("iCreditUnit_burs_div").style.display == 'block' && _("iCreditUnit_burs").value == '')
		{
			setMsgBox("labell_msg11","");
			_("iCreditUnit_burs").focus();
		}*/else if (trim(_("vDesc_loc").value) == '')
		{
			setMsgBox("labell_msg5","");
			_("vDesc_loc").focus();
		}else if (trim(_("amount_loc").value) == '')
		{
			setMsgBox("labell_msg6","");
			_("amount_loc").focus();
		}else if (_('eff_date').value == '')
		{
			setMsgBox("labell_msg7","");
			_("eff_date").focus();
		}else
		{
			//if (_("prog_cat").value == 'topup')
			//{
				// var child_share_h2 = parseFloat(_("child_share_h2").value);
				// if (_("child_share_i2").disabled == true || _("child_share_i2").value == '')
				// {
				// 	var child_share_h2 = 0;
				// }

				// var child_share_h3 = parseFloat(_("child_share_h3").value);
				// if (_("child_share_i3").disabled == true || _("child_share_i3").value == '')
				// {
				// 	var child_share_h3 = 0;
				// }

				// if ((parseFloat(_("parent_share_h").value) + 
				// parseFloat(_("child_share_h1").value) + 
				// child_share_h2 + 
				// child_share_h3) != 100)
				// {
				// 	setMsgBox("labell_msg7","Total ratio should be = 100");
				// 	if(_("child_share_h1").value > 0)
				// 	{
				// 		setMsgBox("labell_msg8","Total ratio should be = 100");
				// 	}

				// 	if(_("child_share_h2").value > 0)
				// 	{
				// 		setMsgBox("labell_msg9","Total ratio should be = 100");
				// 	}

				// 	if(_("child_share_h3").value > 0)
				// 	{
				// 		setMsgBox("labell_msg10","Total ratio should be = 100");
				// 	}
				// 	_("parent_share_i1").focus();
				// 	return;
				// }

				if (_('parent_share_banker').value == '')
				{
					setMsgBox("labell_msg7","Banker required");
					_("parent_share_banker").focus();
					return;
				}

				if (_('parent_share_bank_account').value == 'Enter bank account no.')
				{
					setMsgBox("labell_msg7","Bank account no. required");
					_("parent_share_bank_account").focus();
					return;
				}

				if (isNaN(_('parent_share_bank_account').value))
				{
					setMsgBox("labell_msg7","Numbers only");
					_("parent_share_bank_account").focus();
					return;
				}
				 

				/*for (i = 1; i <= 3; i++)
				{
					var child_share_name = 'child_share_name'+i;
					var child_share_banker = 'child_share_banker'+i;
					var child_share_bank_account = 'child_share_bank_account'+i;
					var child_share_h = 'child_share_h'+i;

					if (_(child_share_h).value == 0){continue;}

					if (_(child_share_banker).value == '')
					{
						_(child_share_banker).focus();
						if (i == 1)
						{
							setMsgBox("labell_msg8","Banker required");
							return;
						}else if (i == 2)
						{						
							setMsgBox("labell_msg9","Banker required");
							return;
						}else if (i == 3)
						{
							setMsgBox("labell_msg10","Banker required");
							return;							
						}
					}else if (_(child_share_bank_account).value.trim() == '' || _(child_share_bank_account).value.trim() == 'Enter bank account no.')
					{
						_(child_share_bank_account).focus();
						if (i == 1)
						{
							setMsgBox("labell_msg8","Bank account no. required");
							return;
						}else if (i == 2)
						{						
							setMsgBox("labell_msg9","Bank account no. required");
							return;
						}else if (i == 3)
						{
							setMsgBox("labell_msg10","Bank account no. required");
							return;							
						}
					}else if (isNaN(_(child_share_bank_account).value))
					{
						_(child_share_bank_account).focus();
						if (i == 1)
						{
							setMsgBox("labell_msg8","Numbers only");
							return;
						}else if (i == 2)
						{						
							setMsgBox("labell_msg9","Numbers only");
							return;
						}else if (i == 3)
						{
							setMsgBox("labell_msg10","Numbers only");
							return;							
						}
					}else if (_(child_share_name).value.trim() == '')
					{
						_(child_share_name).focus();
						if (i == 1)
						{
							setMsgBox("labell_msg8","Name required");
							return;
						}else if (i == 2)
						{						
							setMsgBox("labell_msg9","Name required");
							return;
						}else if (i == 3)
						{
							setMsgBox("labell_msg10","Name required");
							return;							
						}
					}
				}*/

				/*for (i = 0; i <= 3; i++)
				{
					if (i > 0)
					{
						var child_share_h = 'child_share_h'+i;
						if (i > 1 && _(child_share_h).value == 0){continue;}
						
						var child_share_banker_i = 'child_share_banker'+i;
						var child_share_bank_account_i = 'child_share_bank_account'+i;
					}else
					{
						var child_share_banker_i = 'parent_share_banker';
						var child_share_bank_account_i = 'parent_share_bank_account';
					}

					//var repeatitionfound = 0;

					for (j = i+1; j <= 3; j++)
					{
						if (j > 0)
						{
							var child_share_h = 'child_share_h'+j;
							if (j > 1 && _(child_share_h).value == 0){continue;}

							var child_share_banker_j = 'child_share_banker'+j;
							var child_share_bank_account_j = 'child_share_bank_account'+j;
						}else
						{
							var child_share_banker_j = 'parent_share_banker';
							var child_share_bank_account_j = 'parent_share_bank_account';
						}
						
						if (_(child_share_banker_i).value == _(child_share_banker_j).value && 
						_(child_share_bank_account_i).value == _(child_share_bank_account_j).value && 
						_(child_share_bank_account_j).value != 'Enter bank account no.')
						{
							repeatitionfound = 1;
							if (i == 0)
							{
								setMsgBox("labell_msg7","Repeated entry not allowed");
							}else if (i == 1)
							{
								setMsgBox("labell_msg8","Repeated entry not allowed");
							}else if (i == 2)
							{						
								setMsgBox("labell_msg9","Repeated entry not allowed");
							}else if (i == 3)
							{
								setMsgBox("labell_msg10","Repeated entry not allowed");
							}

							if (j == 0)
							{
								setMsgBox("labell_msg7","Repeated entry not allowed");
							}else if (j == 1)
							{
								setMsgBox("labell_msg8","Repeated entry not allowed");
							}else if (j == 2)
							{						
								setMsgBox("labell_msg9","Repeated entry not allowed");
							}else if (j == 3)
							{
								setMsgBox("labell_msg10","Repeated entry not allowed");
							}
						}
					}
				}*/
				//if (repeatitionfound == 1){return;}
			//}
			
			var formdata = new FormData();
			
			if (selitems_loc.conf.value == '1')
			{
				formdata.append("conf", selitems_loc.conf.value);
			}

            if (_("all_faculty").checked && _("whatodo").value == 'e'){
                formdata.append("all_faculty", 1);
                formdata.append("fee_item_id",  _('vDesc_loc').value);                
            }
			

			formdata.append("currency_cf", _("currency_cf").value);
			formdata.append("user_cat", selitems_loc.user_cat.value);
			formdata.append("save_cf", _("save_cf").value);
			formdata.append("vApplicationNo", selitems_loc.vApplicationNo.value);

			formdata.append("sm", selitems_loc.sm.value);
			formdata.append("mm", selitems_loc.mm.value);
			formdata.append("ilin", selitems_loc.ilin.value);
			formdata.append("cEduCtgId_loc", _("cEduCtgId_loc").value);
			
			
			faculy_selected = 0;
			for (var i = 0; i < _("cFacultyId_loc").length; i++)
			{
				if (_("cEduCtgId_loc").value == 'PDS')
				{
					if (i > 0 )
					{
						formdata.append("cFacultyId_loc[]", _("cFacultyId_loc").options[i].value);
						faculy_selected = 1;
					}
				}else if (_("cFacultyId_loc").options[i].selected && _("cFacultyId_loc").options[i].value != '')
				{
					formdata.append("cFacultyId_loc[]", _("cFacultyId_loc").options[i].value);
					faculy_selected = 1;
				}
			}
			
			if (faculy_selected == 0)
			{
				setMsgBox("labell_msg1","");
				return;
			}			

			for (var i = 0; i < _("cdeptid_loc").length; i++)
			{
				if (_("cdeptid_loc").options[i].selected && _("cdeptid_loc").options[i].value != '')
				{
					formdata.append("cdeptid_loc[]", _("cdeptid_loc").options[i].value);
				}
			}
			
			for (var i = 0; i < _("cprogrammeId_loc").length; i++)
			{
				if (_("cprogrammeId_loc").options[i].selected && _("cprogrammeId_loc").options[i].value != '')
				{
					formdata.append("cprogrammeId_loc[]", _("cprogrammeId_loc").options[i].value);
				}
			}
			
			if (_('level_burs').value != '')
			{
				formdata.append("level_burs", _('level_burs').value);
			}
			
			formdata.append("parent_share", _("parent_share_h").value);
            formdata.append("parent_share_banker", _("parent_share_banker").value);				
            formdata.append("parent_share_name", _("parent_share_name").value);
            formdata.append("parent_share_bank_account", _("parent_share_bank_account").value);
			
			if (_("whatodo").value == 'a')
			{
				formdata.append("item_cat_letter", _("item_cat_letter").value);
                formdata.append("item_cat", _("item_cat").value);
			}else if (_("whatodo").value == 'e')
			{
				formdata.append("iItemID", _("iItemID_h").value);
			    formdata.append("item_cat", _("item_cat_loch").value);
                formdata.append("item_cat_cur", _("item_cat").value.substr(0,2));
			}
			
			formdata.append("vDesc_loc", _("vDesc_loc").value);
			formdata.append("vDesc_loc_h", _("vDesc_loch").value);
			formdata.append("amount_loc", _("amount_loc").value);
			
			formdata.append("whatodo", _("whatodo").value);
			formdata.append("new_old_structure", _("new_old_structure").value);
            

			if (_("iCreditUnit_burs_div").style.display == 'block' && _("iCreditUnit_burs").value != '')
			{
				formdata.append("iCreditUnit_burs", _("iCreditUnit_burs").value);
			}

            formdata.append("eff_date", _("eff_date").value);

            opr_prep(ajax = new XMLHttpRequest(),formdata);
		}
	}

    function opr_prep(ajax,formdata)
	{
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		
		ajax.open("POST", "opr_selitems.php");
		ajax.send(formdata);
	}
			

    function completeHandler(event)
	{
		on_error('0');
        on_abort('0');
        in_progress('0');
		
		var returnedStr = event.target.responseText;
		
		if (_('cFacultyId_loch').value == '0' && _('edit_clk').value == '1')
		{
			fill_item_cat(returnedStr);
			_('item_cat').value = _('item_cat_loch').value;
			_('edit_clk').value = '0';
		}else if (_('edit_clk').value == '1')
		{
			var returnedStr1 = returnedStr.substr(0,returnedStr.indexOf('#')-1);			
			fill_item_cat(returnedStr1);
			_('item_cat').value = _('item_cat_loch').value;
			
			_("frm_upd").value = 'f';
			var returnedStr2 = returnedStr.substr(returnedStr.indexOf('#')+1, ((returnedStr.indexOf('@')-1)-returnedStr.indexOf('#')+1)-1);			
			fill_combo(returnedStr2);
			_('cdeptid_loc').value = _('cdeptid_loch').value;
			
			_("frm_upd").value = 'd';
			var returnedStr2 = returnedStr.substr(returnedStr.indexOf('@')+1);
			fill_combo(returnedStr2);
			_('cprogrammeId_loc').value = _('cprogrammeId_loch').value;
			
			_('edit_clk').value = '0';
		}else if (_('whatodo').value == 'e')
		{
			_("edit_new_it").style.display = 'block';
			_("view_new_it").style.display = 'none';
		}else if (_('whatodo').value == 'v')
		{
			_("edit_new_it").style.display = 'none';
			 
			_("cEduCtgId_div").innerHTML = returnedStr.substr(0,100).trim();
			_("cFacultyId_div").innerHTML = returnedStr.substr(100,100).trim();
			_("cdeptid_div").innerHTML = returnedStr.substr(200,100).trim();
			_("cprogrammeId_div").innerHTML = returnedStr.substr(300,100).trim();
			
			_("item_cat_div_v").innerHTML = returnedStr.substr(400,100).trim();
			_("amount_div").innerHTML = _("amount_loch").value;
			
            _("parent_share_div").innerHTML = _('parent_share_h').value;
            _("parent_share_banker_div").innerHTML = _('parent_share_banker_name').value;
            _("parent_share_bank_account_div").innerHTML = _('parent_share_bank_account').value;
            _("parent_share_name_div").innerHTML = _('parent_share_name').value;
			returnedStr = '';
		}else
		{			
			if (returnedStr.indexOf("in use") != -1 && selitems_loc.conf.value == '')
			{
                _("conf_msg_msg_loc").innerHTML = returnedStr+'<br>You still want to save ?';
                _('conf_box_loc').style.display = 'block';
                _('conf_box_loc').style.zIndex = '3';
                _('smke_screen_2').style.display = 'block';
                _('smke_screen_2').style.zIndex = '2';
				
				_('edit_new_it').style.display = 'none';
				return;
			}else
			{
                success_box(returnedStr);
			}
		}

		
		if (returnedStr != '')
		{
			if (returnedStr.indexOf("+") == -1 && returnedStr.indexOf("@") == -1 && returnedStr.indexOf("#") == -1 && returnedStr.indexOf("_") == -1)
			{
				if (returnedStr.indexOf("success") != -1)
				{
                    success_box(returnedStr);
				}else if (returnedStr.indexOf("already") != -1)
				{
                    caution_box(returnedStr);
				}
			}
		}
		
		_('print_btn').style.display = 'block';
		
		_('frm_upd').value = '';
		selitems_loc.conf.value = '';
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

    function fill_item_cat(returnedStr)
	{
		_("item_cat").options.length = 0;
		_("item_cat").options[_("item_cat").options.length] = new Option('', '');

		var num_runs = returnedStr.substr(0,returnedStr.indexOf("+"));
		returnedStr = returnedStr.substr(returnedStr.indexOf("+")+1,returnedStr.length-1);
		for (i = 0; i < returnedStr.length-0; i+=102)
		{
			_("item_cat").options[_("item_cat").options.length] = new Option(returnedStr.substr(i+2,100), returnedStr.substr(i, 2));
		}
	}
	
	
	function fill_combo(returnedStr2)
	{
		var comaFound = 0; semicol = 0;  dolarFound = 0;
		var cProgId = ''; cProgdesc = '';		
		
		for (i = 0; i <= returnedStr2.length-1; i++)
		{
			if (returnedStr2.charAt(i) == '%'){semicol = 1;}
			if (returnedStr2.charAt(i) == '+'){comaFound = 1;}
			if (returnedStr2.charAt(i) == '$'){dolarFound = 1;}

			if ((i == 0 || comaFound == 0) && returnedStr2.charAt(i) != '$')
			{
				cProgId = cProgId + returnedStr2.charAt(i);
			}else if (comaFound == 1 && semicol == 0 && returnedStr2.charAt(i) != '+')
			{
				cProgdesc = cProgdesc + returnedStr2.charAt(i);
			}else if (semicol == 1)
			{
				if (_("frm_upd").value == 'f')
				{
					if (dolarFound == 0)
					{
						_("cdeptid_loc").options[_("cdeptid_loc").options.length] = new Option(cProgdesc, cProgId);
					}
				}
				
				if (_('frm_upd').value == 'd')
				{
					if (dolarFound == 0)
					{
						_("cprogrammeId_loc").options[_("cprogrammeId_loc").options.length] = new Option(cProgdesc, cProgId);
					}else if (dolarFound == 1)
					{
						_("cprogrammeId_loc").options[_("cprogrammeId_loc").options.length] = new Option(cProgdesc, cProgId);
					}
				}
				cProgId = ''; cProgdesc = ''; semicol = 0; comaFound = 0
			}
		}
	}
	
	
	
	function setScreen()
	{
		if (_("whatodo").value == 'a' || _("whatodo").value == 'e')
		{
			_('smke_screen_2').style.zIndex = '2';
            _("smke_screen_2").style.display = 'block';
            _("edit_new_it").style.zIndex = '2';
            _("edit_new_it").style.display = 'block';
		}else
		{
			_('smke_screen_2').style.zIndex = '2';
            _("smke_screen_2").style.display = 'block';
			_("edit_new_it").style.zIndex = '-1';
			_("edit_new_it").style.display = 'none';
		}
        
		if (_("whatodo").value == 'a')
		{
            _('parent_share_h').value = '0';
            _('parent_share_i1').value = '';
            _('parent_share_d1').value = '';

            _('parent_share_banker').value = '000';
            _('parent_share_bank_account').value = '0320496861013';
            _('parent_share_name').value = 'Remita Revenue';
		}
		
		if (_("whatodo").value == 'a' || _("whatodo").value == 'e')
		{
			//_("btn_del").style.display = 'none';
			_("edit_new_it").style.zIndex = 2;

			if (_("whatodo").value == 'a')
			{
                _("all_faculty_div").style.display = 'block';
                
                _("div_header").innerHTML = 'Add new fee item';
                _("btn_save").style.display = 'block';
                _("item_cat").options.length = 0;
				_("item_cat").options[_("item_cat").options.length] = new Option('', '');
			}else if (_("whatodo").value == 'e')
			{
				_("all_faculty_div").style.display = 'block';

                _("div_header").innerHTML = 'Edit fee item';
				_('item_cat_div').style.display = 'block';
				_("conf_loc").value = '';
			}
		}else if (_("whatodo").value == 'd')
		{
			_("div_header").innerHTML = 'Delete item';
			_("btn_save").style.display = 'none';
			//_("btn_del").style.display = 'block';
			_('item_cat_div').style.display = 'block';
		}
	}
	
	
	function updateScrn()
	{
		if (_("frm_upd").value != '0')
		{
			var formdata = new FormData();
			formdata.append("frm_upd", _("frm_upd").value);
			
			if (_('edit_clk').value == '2')
			{
				formdata.append("edit_clk", _('edit_clk').value);

				formdata.append("cEduCtgId_loc", _("cEduCtgId_loc").value);
			
				formdata.append("cFacultyId", _("cFacultyId_loc").value);
				formdata.append("cdeptid", _("cdeptid_loc").value);
				formdata.append("cprogrammeId", _("cprogrammeId_loc").value);
				
				formdata.append("whatodo", _("whatodo").value);			
				formdata.append("item_cat", _("item_cat").value);
				
			}else if (_("frm_upd").value == 'f')
			{
				formdata.append("cFacultyId", _("cFacultyId_loc").value);
			}else if (_("frm_upd").value == 'd')
			{
				formdata.append("cEduCtgId", _("cEduCtgId_loc").value);
				formdata.append("cFacultyId", _("cFacultyId_loc").value);
				formdata.append("cdeptid", _("cdeptid_loc").value);
			}
		
			if (_('frm_upd').value == '1')
			{			
				_("cdeptid_loc").options.length = 1;
				_("cdeptid_loc").options[_("cdeptid_loc").options.length] = new Option('', '');

				_("cprogrammeId_loc").options.length = 1;
				_("cprogrammeId_loc").options[_("cprogrammeId_loc").options.length] = new Option('', '');
			}else if (_('frm_upd').value == 'f')
			{
				_("cdeptid_loc").options.length = 1;
				_("cdeptid_loc").options[_("cdeptid_loc").options.length] = new Option('', '');

				_("cprogrammeId_loc").options.length = 1;
				_("cprogrammeId_loc").options[_("cprogrammeId_loc").options.length] = new Option('', '');
			}else if (_('frm_upd').value == 'd')
			{
				("cprogrammeId_loc").options.length = 1;
				_("cprogrammeId_loc").options[_("cprogrammeId_loc").options.length] = new Option('', '');
			}
			
			opr_prep(ajax = new XMLHttpRequest(),formdata);
		}
	}

    function centre_select()
    {
        return true;

        if (_("user_centre_loc").value == '')
        {
            _("succ_boxt").style.display = "block";
            _("succ_boxt").innerHTML = "Please select a study centre";
            _("succ_boxt").style.display = "block";
            return false;
        }

        if (_("service_mode_loc").value == '')
        {
            _("succ_boxt").style.display = "block";
            _("succ_boxt").innerHTML = "Please select a service mode";
            _("succ_boxt").style.display = "block";
            return false;
        }

        return true;
    }
</script><?php

require_once ('set_scheduled_dates.php');?>
<!-- InstanceEndEditable -->
</head>
<body onLoad="checkConnection()">
    <?php admin_frms(); $has_matno = 0;?>
	
	<form action="staff_home_page" method="post" name="nxt" id="nxt" enctype="multipart/form-data">
		<input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
        <input name="uvApplicationNo" id="uvApplicationNo" type="hidden" />
		<input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST['vMatricNo'])){echo $_REQUEST['vMatricNo']; }?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
		<input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
		
		<input name="mm" id="mm" type="hidden" value="<?php if (isset($_REQUEST["mm"])){echo $_REQUEST["mm"];} ?>" />
		<input name="mm_desc" id="mm_desc" type="hidden" value="<?php if (isset($_REQUEST["mm_desc"])){echo $_REQUEST["mm_desc"];} ?>" />
		<input name="sm" id="sm" type="hidden" value="<?php if (isset($_REQUEST["sm"])){echo $_REQUEST["sm"];} ?>" />
		<input name="sm_desc" id="sm_desc" type="hidden"  value="<?php if (isset($_REQUEST["sm_desc"])){echo $_REQUEST["sm_desc"];} ?>"/>

		<input name="contactus" id="contactus" type="hidden" />
		<input name="what" id="what" type="hidden" />
		
		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($service_mode)&&$service_mode<>''){echo $service_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($service_centre)&&$service_centre<>''){echo $service_centre;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form><?php
	//include ('msg_service.php');?>
	
	<!-- InstanceBeginEditable name="nakedbody" -->
		<div id="container_cover_constat" style="display:none"></div>
		<div id="container_cover_in_constat" class="center" style="display:none; position:fixed;">
			<div id="div_header_main" class="innercont_stff" 
				style="float:left;
				width:99.5%;
				height:auto;
				padding:0px;
				padding-top:3px;
				padding-bottom:4px;
				border-bottom:1px solid #cccccc;">
				<div id="div_header_constat" class="innercont_stff" style="float:left; color:#FF3300;">
					Internet Connection Status
				</div>
			</div>
			
			<div id="div_message_constat" class="innercont_stff" style="margin-top:40px; float:left; width:413px; height:auto; color:#FF3300;">
				You are not connected
			</div>
		</div>
	<!-- InstanceEndEditable -->
<div id="container">
    <div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
    <div id="conf_box_loc" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
        <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
            Confirmation
        </div>
        <a href="#" style="text-decoration:none;">
            <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
        </a>
        <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;">
            Delete selected qualification?
        </div>
        <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
            <a href="#" style="text-decoration:none;" 
                onclick="_('conf_box_loc').style.display='none';
                _('smke_screen_2').style.display='none';
                _('smke_screen_2').style.zIndex='-1';
                _('labell_msg0').style.display = 'none';
                selitems_loc.conf.value='1';
                chk_inputs();
                return false">
                <div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
                    Yes
                </div>
            </a>

            <a href="#" style="text-decoration:none;" 
                onclick="selitems_loc.conf.value='';
                _('conf_box_loc').style.display='none';
                _('smke_screen_2').style.display='none';
                _('smke_screen_2').style.zIndex='-1';
                _('labell_msg0').style.display = 'none';
                return false">
                <div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
                    No
                </div>
            </a>
        </div>
    </div><?php
    time_out_box($currency);?>

	<noscript>
		<div class="smoke_scrn" style="display:block"></div>
		<?php information_box_inline('You need to enable javascript for this browser');?>
	</noscript>
	<?php do_toup_div('Student Management System');?>
	<div id="menubar">
		<!-- InstanceBeginEditable name="menubar" -->
		<?php require_once ('menu_bar_content_stff.php');?>
		<!-- InstanceEndEditable -->
	</div>

	<div id="leftSide_std" style="margin-left:0px;"><?php
		require_once ('stff_left_side_menu.php');?>
	</div>
	<div id="rtlft_std" style="position:relative;">
        <form action="show-excel-report" method="post" name="excel_export" id="excel_export" enctype="multipart/form-data">
            <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
            
            <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php echo $_REQUEST['sm']; ?>" />
            <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
            
            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
            <input name="mm" type="hidden" value="<?php echo $_REQUEST['mm']; ?>" />
            <input name="sm" type="hidden" value="<?php echo $_REQUEST['sm']; ?>" />
            
            <input name="study_center_loc0_ex_burs" id="study_center_loc0_ex_burs" type="hidden" />
            <input name="study_mode_ex_burs" id="study_mode_ex_burs" type="hidden" />
            <input name="cFacultyId_ex_burs" id="cFacultyId_ex_burs" type="hidden" />
            <input name="cEduCtgId_loc_ex_burs" id="cEduCtgId_loc_ex_burs" type="hidden" />
            
            <input name="user_centre_ex_burs" id="user_centre_ex_burs" type="hidden" />
            
            <input name="show_all_ex_burs" id="show_all_ex_burs" type="hidden" />
		
		    <input name="new_old_structure_ex_burs" id="new_old_structure_ex_burs" type="hidden" />
            <input name="study_mode_ID" id="study_mode_ID" type="hidden" value="odl" />
        </form>

        <form action="show-report" method="post" name="prns_form" target="_blank" id="prns_form" enctype="multipart/form-data">
            <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
            
            <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php echo $_REQUEST['sm']; ?>" />
            <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
            
            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
            <input name="mm" type="hidden" value="<?php echo $_REQUEST['mm']; ?>" />
            <input name="sm" type="hidden" value="<?php echo $_REQUEST['sm']; ?>" />
            
            <input name="study_mode0" id="study_mode0" type="hidden" value="<?php if (isset($_REQUEST['study_mode0'])){echo $_REQUEST['study_mode0'];} ?>" />
            
            <input name="study_center_loc0" id="study_center_loc0" type="hidden" value="<?php if (isset($_REQUEST['study_center_loc0'])){echo $_REQUEST['study_center_loc0'];} ?>" />
            
            <input name="cEduCtgId_loc0" id="cEduCtgId_loc0" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId_loc_0'])){echo $_REQUEST['cEduCtgId_loc_0'];} ?>" />
            
            <input name="cFacultyId_loc_0" id="cFacultyId_loc_0" type="hidden" value="<?php if (isset($_REQUEST['cFacultyId_loc_0'])&&$_REQUEST['cFacultyId_loc_0']<>''){echo $_REQUEST['cFacultyId_loc_0'];}else  if (isset($_REQUEST['cFacultyId_loc_1'])){echo $_REQUEST['cFacultyId_loc_1'];} ?>" />
            <input name="cFacultyId_desc_loc_0" id="cFacultyId_desc_loc_0" type="hidden" value="<?php if (isset($_REQUEST['cFacultyId_desc_loc_0'])&&$_REQUEST['cFacultyId_desc_loc_0']<>''){echo $_REQUEST['cFacultyId_desc_loc_0'];} ?>" />
            
            <input name="study_mode_ID" id="study_mode_ID" type="hidden" value="odl" />

            <input name="show_all_burs" id="show_all_burs" type="hidden" value="<?php if (isset($_REQUEST["show_all_burs"]) && $_REQUEST["show_all_burs"] <> ''){echo $_REQUEST["show_all_burs"];}?>" />

            
		    <input name="new_old_structure_burs" id="new_old_structure_burs" type="hidden" value="<?php if (isset($_REQUEST["new_old_structure_h"]) && $_REQUEST["new_old_structure_h"] <> ''){echo $_REQUEST["new_old_structure_h"];}?>"/>

            <input name="service_mode" id="service_mode" type="hidden" 
            value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
            else if (isset($study_mode)){echo $study_mode;}?>" />
            <input name="num_of_mode" id="num_of_mode" type="hidden" 
            value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
            else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

            <input name="user_centre" id="user_centre" type="hidden" 
            value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
            else if (isset($study_mode)){echo $study_mode;}?>" />
            <input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
            value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
            else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
        </form>

        <form method="post" name="selitems_loc" id="selitems_loc" enctype="multipart/form-data">
            <?php frm_vars();?>
            <input name="save_cf" id="save_cf" type="hidden" value="-1" />
            <input name="iItemID_h" id="iItemID_h" type="hidden" />
            <input name="nxtval" id="nxtval" type="hidden" />
            <input name="whatodo" id="whatodo" type="hidden" />
            <input name="whatodo" id="whatodo" type="hidden" />
            <input name="frm_upd" id="frm_upd" type="hidden" />
            <input name="conf_loc" id="conf_loc" type="hidden" value="" />
            <input name="edit_clk" id="edit_clk" type="hidden" value="0" />
            <input name="semester_open" id="semester_open" type="hidden" value="<?php if ($semester_open == ''){echo '0';}else{echo $semester_open;}?>" />
            
            <input name="cEduCtgId_loc_1" id="cEduCtgId_loc_1" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId_loc_0'])){echo $_REQUEST['cEduCtgId_loc_0'];}?>" />

            <input name="service_mode" id="service_mode" type="hidden" 
            value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
            else if (isset($study_mode)){echo $study_mode;}?>" />
            <input name="num_of_mode" id="num_of_mode" type="hidden" 
            value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
            else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

            <input name="user_centre" id="user_centre" type="hidden" 
            value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
            else if (isset($study_mode)){echo $study_mode;}?>" />
            <input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
            value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
            else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />

            <input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
        </form>
		<!-- InstanceBeginEditable name="EditRegion6" -->	
            <div class="innercont_top">Fee structure</div>
            <select name="cdeptId_readup" id="cdeptId_readup" style="display:none"><?php	
                $sql = "SELECT cFacultyId, cdeptId, concat(cdeptId,' ',vdeptDesc) vdeptDesc FROM depts where cDelFlag = 'N' order by cFacultyId, cdeptId, vdeptDesc";
                $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                while ($rs = mysqli_fetch_array($rssql))
                {?>
                    <option value="<?php echo $rs['cFacultyId']. $rs['cdeptId']?>"><?php echo $rs['vdeptDesc'];?></option><?php
                }
                mysqli_close(link_connect_db());?>
            </select>

            <select name="cprogrammeId_readup" id="cprogrammeId_readup" style="display:none"><?php	
                $sql = "SELECT s.cdeptId, p.cProgrammeId,p.vProgrammeDesc,o.vObtQualTitle 
                FROM programme p, obtainablequal o, depts s, faculty t
                where p.cObtQualId = o.cObtQualId 
                AND s.cdeptId = p.cdeptId
                AND s.cFacultyId = t.cFacultyId
                AND p.cDelFlag = s.cDelFlag
                AND p.cDelFlag = t.cDelFlag
                AND p.cDelFlag = 'N'
                order by s.cdeptId, p.cProgrammeId";
                $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                while ($rs = mysqli_fetch_array($rssql))
                {?>
                    <option value="<?php echo $rs['cdeptId']. $rs['cProgrammeId']?>"><?php echo $rs['vObtQualTitle'].' '.$rs['vProgrammeDesc']; ?></option><?php
                }
                mysqli_close(link_connect_db());?>
            </select>	
            
            <select name="item_cat_readup" id="item_cat_readup" style="display:none"><?php
                if (isset($_REQUEST["new_old_structure_h"]) && $_REQUEST["new_old_structure_h"] == 'f')
                {
                    $sql = "SELECT distinct citem_cat, cEduCtgId, citem_cat_desc FROM sell_item_cat WHERE citem_cat_desc LIKE '%(F)' ORDER BY citem_cat";    
                }else
                {
                    $sql = "SELECT distinct citem_cat, cEduCtgId, citem_cat_desc FROM sell_item_cat WHERE citem_cat_desc not LIKE '%(F)' ORDER BY citem_cat";
                }
                $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                while ($rs = mysqli_fetch_array($rssql))
                {?>
                    <option value="<?php echo $rs['citem_cat'].$rs['cEduCtgId'];?>"><?php echo $rs['citem_cat_desc'];?></option><?php
                }
                mysqli_close(link_connect_db());?>
            </select>
            
            
            <div class="innercont_stff" style="margin-bottom:1%; width:99.5%; display:block">
                <div class="div_select" style="margin-right:10px; width:auto; background:#ccc"><?php
                    $stmt = $mysqli->prepare("SELECT distinct cEduCtgId, vEduCtgDesc, iEduCtgRank 
                    FROM educationctg WHERE cEduCtgId IN ('ELX','ELZ','PGX','PGY','PGZ','PRX','PSZ') ORDER BY iEduCtgRank");
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($cEduCtgId_02, $vEduCtgDesc_02, $iEduCtgRank_02);									
                    $prev_iEduCtgRank = '';?>

                    <select name="prog_cat_loc" id="prog_cat_loc" class="select" style="width:200px"
                        onchange="selitems.cEduCtgId_loc_0.value=this.value
                            if (this.value == 'PGX' || this.value == 'PGY' || this.value == 'PGZ' || this.value == 'PRX')
                            {
                                _('new_old_structure').value='o';
                                _('new_old_structure_h').value='o';
                            }
                            
                            if(_('prog_cat_loc').value!=''&&_('cFacultyId_loc_1').value!=''&&_('new_old_structure_h').value!='')
                            {
                                selitems.submit();
                            }">
                        <option value="" selected>Select category</option><?php
                        while ($stmt->fetch())
                        {
                            if ($prev_iEduCtgRank <> $iEduCtgRank_02)
                            {?>
                                <option disabled></option><?php
                            }?>
                            <option value="<?php echo $cEduCtgId_02?>" <?php if (isset($_REQUEST['cEduCtgId_loc_0']) && $_REQUEST['cEduCtgId_loc_0'] == $cEduCtgId_02){echo ' selected';}?>>
                                <?php echo $vEduCtgDesc_02;?>
                            </option><?php
                            $prev_iEduCtgRank = $iEduCtgRank_02;
                        }
                        $stmt->close();?>
                    </select>
                </div>
                
                <div id="show_all_burs_div" class="div_select" style="float:left; display:block; width:auto; margin-right:10px">
                    <a href="#" onclick="
                    if(_('prog_cat_loc').value!=''&&_('cFacultyId_loc_1').value!=''&&_('new_old_structure_h').value!='')
                    {
                        if(selitems.show_all_burs.value == 1)
                        {
                            selitems.show_all_burs.value = 0;
                        }else
                        {
                            selitems.show_all_burs.value = 1;
                        }
                        selitems.submit();
                    }
                    return false">
                        <input type="button" value="<?php if (isset($_REQUEST['show_all_burs'])&&$_REQUEST['show_all_burs']=='1'){echo 'Show lim';}else{echo 'Show all';}?>" class="basic_three_stff_sbt_btns_rslt" style="width:70px; padding:10px; font-size:12px;"/>
                    </a>
                </div>

                <div class="div_select" style="margin-right:10px; width:auto;">
                    <select name="cFacultyId_loc_1" id="cFacultyId_loc_1" class="select" style="width:200px"
                        onchange="selitems.cFacultyId_loc_0.value=this.value;
                        selitems.cFacultyId_desc_loc_0.value=this.options[this.selectedIndex].text;
                        if(_('prog_cat_loc').value!=''&&_('cFacultyId_loc_1').value!=''&&_('new_old_structure_h').value!='')
                        {
                            selitems.submit();
                        }"><?php
                        if (isset($_REQUEST['cFacultyId_loc_0']))
                        {
                            get_faculties($_REQUEST['cFacultyId_loc_0']);
                        }else
                        {
                            get_faculties('');
                        }?>
                    </select>
                </div>

                <div class="div_select" style="margin-right:10px; width:auto;">
                    <select name="new_old_structure" id="new_old_structure" class="select" style="width:200px"
                        onchange="if (this.value == 'n' && (_('prog_cat_loc').value == 'PGX' || _('prog_cat_loc').value == 'PGY' || _('prog_cat_loc').value == 'PGZ' || _('prog_cat_loc').value == 'PRX'))
                        {
                            this.value = 'o';
                        }
                        _('new_old_structure_h').value=this.value;
                        
                        if(_('prog_cat_loc').value!=''&&_('cFacultyId_loc_1').value!=''&&_('new_old_structure_h').value!='')
                        {
                            selitems.submit();
                        }">
                        <option value="" selected>Select fee category</option>
                        <option value="o" <?php if (isset($_REQUEST["new_old_structure_h"])&&$_REQUEST["new_old_structure_h"]=='o'){echo ' selected';}?>>Old fee</option>
                        <option value="n" <?php if (isset($_REQUEST["new_old_structure_h"])&&$_REQUEST["new_old_structure_h"]=='n'){echo ' selected';}?>>New fee</option>
                        <option value="f" <?php if (isset($_REQUEST["new_old_structure_h"])&&$_REQUEST["new_old_structure_h"]=='f'){echo ' selected';}?>>Foreign student fee</option>
                        <option value="c" <?php if (isset($_REQUEST["new_old_structure_h"])&&$_REQUEST["new_old_structure_h"]=='c'){echo ' selected';}?>>CEMBA CEMPA fee</option>
                    </select>
                </div><?php 
                if (check_scope3('Bursary', 'Fee structure', 'Add') > 0)
                {?>
                    <div class="div_select" style="width:85px; float:right">
                        <a href="#" style="text-decoration:none;" 
                            onclick="_('whatodo').value='a';
                            _('frm_upd').value='';
                            _('cEduCtgId_loc').value='';
                            _('cEduCtgId_loch').value='';
                            _('vDesc_loc').value='';
                            _('vDesc_loch').value='';
                            _('amount_loc').value='';
                            _('eff_date').value='';
                            _('amount_loch').value='';
                            _('edit_clk').value='0';
                            selitems_loc.save_cf.value='-1';
                            _('cFacultyId_loc').value='0';
                            _('cFacultyId_loch').value='0';
                            _('cdeptid_loc').length='0';
                            _('cdeptid_loch').value='0';
                            _('cprogrammeId_loc').length='0';
                            _('level_burs').value='';
                            _('cprogrammeId_loch').value='0';
                            _('iCreditUnit_burs_div').value='';
                            _('iCreditUnit_burs_div').style.display='none';
                            _('item_cat').value='';
                            _('item_cat_loch').value='<';
                            setScreen();
                            return false">
                            <div id="add_qual_div" class="submit_button_green" 
                                style="margin-left:0px; 
                                padding:10px; 
                                width:70px;
                                font-size:0.9em;" 
                                title="Click to add a new fee item">
                                Add
                            </div>
                        </a>
                    </div><?php
                }else
                {?>
                    <div class="div_select" style="width:85px; float:right">
                        <div id="add_qual_div" class="submit_button_green" 
                            style="margin-left:0px; 
                            padding:10px; 
                            width:70px;
                            font-size:0.9em; opacity:0.2; cursor:not-allowed" title="Not available for your role">
                            Add
                        </div>
                    </div><?php
                }?>
            </div>
				
            <div class="innercont_stff" style="margin-bottom:0.5%; font-weight:bold;
                    display:<?php if (isset($_REQUEST['cFacultyId_loc_0']) && $_REQUEST['cFacultyId_loc_0'] <> ''){echo 'block';}else{echo 'none';}?>">
                <div class="_label" style="border:1px solid #cdd8cf; width:4.5%; height:auto; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:right; background-color:#E3EBE2;">
                    Sno
                </div>
                <!-- <div class="_label" style="border:1px solid #cdd8cf; width:7.2%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; background-color:#E3EBE2;">
                    Item ID
                </div> -->
                <!--<div class="_label" style="border:1px solid #cdd8cf; width:5%; height:auto; padding-top:8px; padding-bottom:8px; border-radius:0px; background-color:#E3EBE2;">
                    Faculty
                </div>-->
                <div class="_label" style="border:1px solid #cdd8cf; width:7.3%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:left; background-color:#E3EBE2;">
                    Dept.
                </div>
                <div class="_label" style="border:1px solid #cdd8cf; width:7.2%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:left; background-color:#E3EBE2;">
                    Programe
                </div>
                <div class="_label" style="border:1px solid #cdd8cf; width:4.8%; height:auto; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:right; background-color:#E3EBE2;">
                    Level
                </div>
                <!--<div class="_label" style="border:1px solid #cdd8cf; width:6%; padding-top:0.6%; padding-bottom:0.6%; border-radius:0px; text-align:right; background-color:#E3EBE2;">
                    Semester
                </div>-->
                <div class="_label" style="border:1px solid #cdd8cf; width:49.4%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:left; background-color:#E3EBE2;">
                    Description
                </div>
                <div class="_label" style="border:1px solid #cdd8cf; width:9.9%; height:auto; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:right; background-color:#E3EBE2;">
                    <?php if (isset($_REQUEST['new_old_structure_h']))
                    {
                        if ($_REQUEST['new_old_structure_h'] == 'f')
                        {
                            echo "Amount($)";
                        }else 
                        {
                            echo 'Amount(N)';
                        }
                    }?>
                </div>
                <div class="_label" style="border:1px solid #cdd8cf; width:11.5%; height:auto; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:right; background-color:#E3EBE2;">.</div>
            </div><?php

            $arr_bank = array(array());
            $rssql = mysqli_query(link_connect_db(), "SELECT ccode, vDesc FROM banks order by ccode") or die(mysqli_error(link_connect_db()));
            $cnt = -1;
            while($rrssql = mysqli_fetch_array($rssql))
            {
                $cnt++;
                $arr_bank[$cnt]['vDesc'] = $rrssql['vDesc'];
                $arr_bank[$cnt]['ccode'] = $rrssql['ccode'];
            }
            mysqli_close(link_connect_db());

            $arr_faculty = array(array(array(array(array(array())))));
            
            $sql = "SELECT a.cFacultyId, a.vFacultyDesc, b.cdeptId, b.vdeptDesc, c.cProgrammeId, c.vProgrammeDesc
            FROM faculty a, depts b, programme c
            WHERE a.cFacultyId = b.cFacultyId
            AND b.cdeptId = c.cdeptId
            AND a.cFacultyId NOT IN ('ICT','GST') 
            AND a.cDelFlag = 'N'
            order by a.cFacultyId, b.cdeptId, c.cProgrammeId";
            
            $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));

            $cnt = -1;
            
            while($rrssql = mysqli_fetch_array($rssql))
            {
                $cnt++;
                $arr_faculty[$cnt]['cFacultyId'] = $rrssql['cFacultyId'];
                $arr_faculty[$cnt]['vFacultyDesc'] = $rrssql['vFacultyDesc'];
                
                $arr_faculty[$cnt]['cdeptId'] = $rrssql['cdeptId'];
                $arr_faculty[$cnt]['vdeptDesc'] = $rrssql['vdeptDesc'];
                
                $arr_faculty[$cnt]['cProgrammeId'] = $rrssql['cProgrammeId'];
                $arr_faculty[$cnt]['vProgrammeDesc'] = $rrssql['vProgrammeDesc'];
            }
            mysqli_close(link_connect_db());
            
            $faculty_sub_sql = "";
            if (isset($_REQUEST['cEduCtgId_loc_0']) && $_REQUEST['cEduCtgId_loc_0'] <> '')
            {
                $faculty_sub_sql = " AND a.cEduCtgId = '".$_REQUEST['cEduCtgId_loc_0']."'";
            }
            
            if (isset($_REQUEST['show_all_burs']) && $_REQUEST['show_all_burs'] == '0')
            {
                //$faculty_sub_sql .= " AND d.fee_item_desc <> 'Application Fee' AND d.fee_item_desc <> 'Late Fee' AND d.fee_item_desc <> 'Acceptance Fee' AND d.fee_item_desc <> 'Convocation gown' AND d.fee_item_desc <> 'Outstanding amount at graduation'";

                $faculty_sub_sql .= " AND d.fee_item_desc <> 'Application Fee' AND d.fee_item_desc <> 'Late Fee' AND d.fee_item_desc <> 'Convocation gown' AND d.fee_item_desc <> 'Outstanding amount at graduation'";
            }

            if (isset($_REQUEST['cFacultyId_loc_0']) && $_REQUEST['cFacultyId_loc_0'] <> '')
            {
                $faculty_sub_sql .= " AND cFacultyId = '".$_REQUEST['cFacultyId_loc_0']."'";
            }

            if (isset($_REQUEST['new_old_structure_h']) && $_REQUEST['new_old_structure_h'] <> '')
            {
                $faculty_sub_sql .= " AND new_old_structure = '".$_REQUEST['new_old_structure_h']."'";
            }

            
                                            
            if (((isset($_REQUEST['cEduCtgId_loc_0']) && $_REQUEST['cEduCtgId_loc_0'] <> '') || (isset($_REQUEST['user_centre']) && $_REQUEST['user_centre'] <> '')) && isset($_REQUEST['cFacultyId_loc_0']) && $_REQUEST['cFacultyId_loc_0'] <> '')
            {
                $stmt = $mysqli->prepare("SELECT a.iItemID, a.citem_cat, a.cEduCtgId, b.vEduCtgDesc, a.iSemester, c.citem_cat_desc, d.fee_item_desc, d.fee_item_id, a.iCreditUnit, a.Amount, a.cFacultyId, a.cdeptid, a.cprogrammeId, a.ilevel, a.add_date
                FROM s_f_s a, educationctg b, sell_item_cat c, fee_items d
                WHERE a.cEduCtgId = b.cEduCtgId 
                AND a.citem_cat = c.citem_cat
                AND a.fee_item_id = d.fee_item_id
                AND a.cdel = 'N'
		        AND d.cdel = 'N'
		        AND a.Amount > 0
                $faculty_sub_sql
                order by a.citem_cat, d.fee_item_desc");
                
                $stmt->execute();
                $stmt->store_result();
                
                $stmt->bind_result($iItemID_01, $citem_cat_01, $cEduCtgId_01, $vEduCtgDesc_01, $iSemester_01, $citem_cat_desc_01, $vDesc_01, $fee_item_id_01, $iCreditUnit_01, $Amount_01, $cFacultyId_01, $cdeptid_01, $cprogrammeId_01, $ilevel_01, $add_date_01);?>
                
                
                <div id="rtside" class="innercont_stff" style="height:75%; overflow:scroll; overflow-x: hidden; display:<?php if (isset($_REQUEST['cEduCtgId_loc_0'])&&$_REQUEST['cEduCtgId_loc_0']<>''){echo 'block';}else{echo 'none';}?>"><?php
                    $balance = 0; 
                    $cnt = 0;
                
                    $prev_citem_cat = '';
                    $citem_cat_total = 0;  
                    $faculty_diff = '';
                    $prev_citem_cat_diff = '';
                    $cEduCtgId_transi = '';
                    $background_color='';
                    while($stmt->fetch())
                    {
                        $citem_cat_01 = $citem_cat_01 ?? '';
                        if ($cnt%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>

                        <label class="lbl_beh"><?php
                            if ($prev_citem_cat == '' || ($prev_citem_cat <> $citem_cat_01))
                            {	
                                if ($citem_cat_total > 0)
                                {
                                    $prev_citem_cat_diff = '1';?>
                                    <div class="innercont_stff" style="font-weight:bold;">
                                        <div class="_label" style="border:1px solid #cdd8cf; width:4%; padding:5px; padding-top:10px; padding-bottom:10px;">.</div>
                                        <div class="_label" style="border:1px solid #cdd8cf; width:7.2%; padding-left:0.6%; padding:5px; padding-top:10px; padding-bottom:10px;">.</div>
                                        <div class="_label" style="border:1px solid #cdd8cf; width:7.2%; padding-left:0.6%; padding:5px; padding-top:10px; padding-bottom:10px;" >.</div>
                                        <div class="_label" style="border:1px solid #cdd8cf; width:4.4%; padding:5px; padding-top:10px; padding-bottom:10px;">.</div>
                                        <div class="_label" style="border:1px solid #cdd8cf; width:50.4%; padding-left:0.6%; padding:5px; padding-top:10px; padding-bottom:10px;">
                                            Sub total
                                        </div>
                                        
                                        <div class="_label" style="border:1px solid #cdd8cf; width:9.7%; padding:5px; padding-top:10px; padding-bottom:10px; text-align:right;">
                                            <?php if (substr($prev_citem_cat,1,1) == '1' || substr($prev_citem_cat,1,1) == '4' || substr($prev_citem_cat,1,1) == '5')
                                            {
                                                echo number_format($citem_cat_total, 2, '.', ',');
                                            }else{
                                                echo 'NA';
                                            }?>
                                        </div>
                                        <div class="_label" style="border:1px solid #cdd8cf; width:9.2%; padding:5px; padding-top:10px; padding-bottom:10px; text-align:right">.</div>
                                    </div><?php
                                    $citem_cat_total = 0;
                                }
                            }
                            
                            if ($prev_citem_cat == '' || ($prev_citem_cat <> $citem_cat_01))
                            {?>
                                <div class="innercont_stff">
                                        <div class="_label" style="border:0px solid #cdd8cf; width:97.5%; padding:5px; padding-top:10px; padding-bottom:10px; text-align:left; font-weight:bold;">
                                        <?php echo  $citem_cat_desc_01;?>
                                    </div>
                                </div><?php
                            }?>

                            <div class="innercont_stff">
                                <div class="_label" style="border:1px solid #cdd8cf; width:4%; padding:5px; padding-top:10px; padding-bottom:10px; background-color:<?php echo $background_color;?>; text-align:right">
                                    <?php echo ++$cnt;?>
                                </div>

                                <!-- <div class="_label" style="border:1px solid #cdd8cf; width:7.2%; padding-left:0.6%; padding:5px; padding-top:10px; padding-bottom:10px; background-color:<?php //echo $background_color;?>; text-align:left">
                                    <?php //echo str_pad($iItemID_01, 3, "0", STR_PAD_LEFT).' '.$citem_cat_01 ?>
                                </div> -->

                                <?php //$key = array_search($cFacultyId_01, array_column($arr_faculty, 'cFacultyId'));?>
                                <!--<div class="_label" style="border:1px solid #cdd8cf; width:5.1%; padding-left:0.6%; padding:5px; padding-top:10px; padding-bottom:10px; background-color:<?php //echo $background_color;?>; text-align:left" title="<?php //if (!is_bool($key)){echo $arr_faculty[$key]['vFacultyDesc'];}?>">
                                    <?php //if ($cFacultyId_01 == '0'){echo 'N/A';}else{echo $cFacultyId_01;}?>
                                </div>-->

                                <?php $key = array_search($cdeptid_01, array_column($arr_faculty, 'cdeptId'));?>
                                <div class="_label" style="border:1px solid #cdd8cf; width:7.2%; padding-left:0.6%; padding:5px; padding-top:10px; padding-bottom:10px; background-color:<?php echo $background_color;?>; text-align:left" title="<?php if (!is_bool($key)){echo $arr_faculty[$key]['vdeptDesc'];}?>">
                                    <?php if ($cdeptid_01 == '0'){echo 'N/A.';}else{echo $cdeptid_01;}echo ' '.$citem_cat_01.' '.$iItemID_01;?>
                                </div>

                                <?php $key = array_search($cprogrammeId_01, array_column($arr_faculty, 'cProgrammeId'));?>
                                <div class="_label" style="border:1px solid #cdd8cf; width:7.2%; padding-left:0.6%; padding:5px; padding-top:10px; padding-bottom:10px; background-color:<?php echo $background_color;?>; text-align:left" title="<?php if (!is_bool($key)){echo $arr_faculty[$key]['vProgrammeDesc'];}?>">
                                    <?php if ($cprogrammeId_01 == '0'){echo 'N/A.';}else{echo $cprogrammeId_01;}?>
                                </div>

                                <div class="_label" style="border:1px solid #cdd8cf; width:4.4%; padding:5px; padding-top:10px; padding-bottom:10px; background-color:<?php echo $background_color;?>; text-align:right">
                                    <?php if ($ilevel_01 == 0){echo 'All';}else{echo $ilevel_01;}?>
                                </div>

                                <!--<div class="_label" style="border:1px solid #cdd8cf; width:6.1%; padding:5px; padding-top:10px; padding-bottom:10px; background-color:<?php echo $background_color;?>; text-align:left">
                                    <?php if ($iSemester_01 < 1){echo 'N/A.';}else{echo $iSemester_01;}?>
                                </div>-->

                                <div class="_label" style="border:1px solid #cdd8cf; width:50.4%; padding-left:0.6%; padding:5px; padding-top:10px; padding-bottom:10px; background-color:<?php echo $background_color;?>; text-align:left">
                                    <?php echo $vDesc_01; if ($vDesc_01 == 'Course Registration'){echo ' - '.$iCreditUnit_01;}?>
                                </div>
                                
                                <div class="_label" style="border:1px solid #cdd8cf; width:9.7%; padding:5px; padding-top:10px; padding-bottom:10px; background-color:<?php echo $background_color;?>; text-align:right">
                                    <?php  echo number_format($Amount_01, 2, '.', ',');
                                    $balance += $Amount_01;
                                    $citem_cat_total += $Amount_01;?>
                                </div>
                                
                                <div class="_label" style="border:1px solid #cdd8cf; width:9.5%; padding-top:2px; padding-bottom:0.5px; background-color:<?php echo $background_color;?>; text-align:center"><?php
                                    if (check_scope3('Bursary', 'Fee structure', 'Edit') > 0)
                                    {?>
                                        <a href="#" style="text-decoration:none;" 
                                            onclick="if (_('semester_open').value == 1)
                                            {
                                                caution_box('Make changes when semester closes');
                                                return;
                                            }
                                            _('iItemID_h').value='<?php echo str_pad($iItemID_01, 3, '0', STR_PAD_LEFT);?>';
                                            _('whatodo').value='e';
                                            _('cEduCtgId_loc').value='<?php echo $cEduCtgId_01;?>';
                                            _('cEduCtgId_loch').value='<?php echo $cEduCtgId_01;?>';
                                            _('vDesc_loc').value='<?php echo $fee_item_id_01;?>';
                                            _('vDesc_loch').value='<?php echo $fee_item_id_01;?>';
                                            _('eff_date').value='<?php echo $add_date_01;?>';
                                            _('amount_loc').value='<?php echo $Amount_01;?>';
                                            _('amount_loch').value='<?php echo $Amount_01;?>';
                                            _('iCreditUnit_burs').value='<?php echo $iCreditUnit_01;?>';
                                            _('iCreditUnit_loch').value='<?php echo $iCreditUnit_01;?>';
                                            _('level_burs').value='<?php echo $ilevel_01;?>';
                                            _('ilevel_loch').value='<?php echo $ilevel_01;?>';
                                            _('item_cat').value='<?php echo $citem_cat_01;?>';
                                            _('item_cat_loch').value='<?php echo $citem_cat_01;?>';

                                            _('edit_clk').value='1';
                                            _('whatodo').value='e';
                                            selitems_loc.save_cf.value='-1';
                                            _('frm_upd').value='f';
                                            _('cFacultyId_loc').value='<?php echo $cFacultyId_01;?>';
                                            update_cat_country('cFacultyId_loc', 'cdeptId_readup', 'cdeptid_loc', 'cprogrammeId_loc');
                                            _('cdeptid_loc').value = '<?php echo $cdeptid_01;?>';
                                        
                                            update_cat_country('cdeptid_loc', 'cprogrammeId_readup', 'cprogrammeId_loc', 'cprogrammeId_loc');
                                            _('cprogrammeId_loc').value = '<?php echo $cprogrammeId_01;?>';

                                            _('cFacultyId_loch').value='<?php echo $cFacultyId_01;?>';
                                            _('cdeptid_loch').value='<?php echo $cdeptid_01;?>';
                                            _('cprogrammeId_loch').value='<?php echo $cprogrammeId_01;?>';

                                            setScreen();
                                            
                                            update_cat_country('cEduCtgId_loc', 'item_cat_readup', 'item_cat', 'item_cat');
                                            _('item_cat').value='<?php echo $citem_cat_01.$cEduCtgId_01;?>';
                                            _('item_cat_loch').value='<?php echo $citem_cat_01;?>';
                                            if(_('item_cat_loch').value.substr(1,1)==2)
                                            {
                                                _('iCreditUnit_burs_div').style.display='block';
                                            }else
                                            {
                                                _('iCreditUnit_burs_div').style.display='none';
                                            };
                                            return false">
                                            <div id="add_qual_div"
                                                style="margin:0px;
                                                float:right;
                                                margin-left:2%; 
                                                padding:3%;
                                                width:20%;
                                                border:0px solid #ccc;">
                                                 <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'edit.png');?>" style="cursor:pointer; height:22px; width:19px; margin-top:3px;" title="Click to edit selected item">
                                            </div>
                                        </a><?php
                                    }else
                                    {?>;
                                        <div id="add_qual_div"
                                            style="margin:0px;
                                            float:right;
                                            margin-left:2%; 
                                            padding:3%;
                                            width:20%;
                                            border:0px solid #ccc; opacity:0.2">
                                             <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'edit.png');?>" style="cursor:not-allowed; height:22px; width:19px; margin-top:3px;" title="Not available for your role">
                                        </div><?php 
                                    }

                                    if (check_scope3('Bursary', 'Fee structure', 'Delete') > 0)
                                    {?>
                                        <a href="#" style="text-decoration:none;" 
                                        onclick="if (_('semester_open').value == 1)
                                        {
                                            caution_box('Make changes when semester closes');
                                            return;
                                        }
                                        _('whatodo').value='d';
                                        _('iItemID_h').value='<?php echo $iItemID_01;?>';

                                        _('conf_msg_msg_loc').innerHTML = 'Are you sure about this ?';
                                        _('conf_box_loc').style.display = 'block';
                                        _('conf_box_loc').style.zIndex = '3';
                                        _('smke_screen_2').style.display = 'block';
                                        _('smke_screen_2').style.zIndex = '2';">
                                            <div id="add_qual_div"
                                                style="margin:0px;
                                                float:right;
                                                margin-left:2%; 
                                                padding:4px;
                                                padding:3%;
                                                width:20%;
                                                border:0px solid #ccc;" 
                                                title="Click to delete selected item">
                                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'delete_one.png');?>" style="cursor:pointer; height:22px; width:19px; margin-top:3px;">
                                            </div>
                                        </a><?php
                                        if (is_bool(strpos($citem_cat_01, '2')))
                                        {?>
                                            <a href="#" style="text-decoration:none;" 
                                                onclick="if (_('semester_open').value == 1)
                                                {
                                                    caution_box('Make changes when semester closes');
                                                    return;
                                                }
                                                _('whatodo').value='da';
                                                _('cEduCtgId_loc').value='<?php echo $cEduCtgId_01;?>';
                                                _('vDesc_loc').value='<?php echo $fee_item_id_01;?>';
                                                _('item_cat_loch').value='<?php echo $citem_cat_01;?>';

                                                _('conf_msg_msg_loc').innerHTML = 'Selected fee item in all faculties will be deleted<br>Are you sure about this ?';
                                                _('conf_box_loc').style.display = 'block';
                                                _('conf_box_loc').style.zIndex = '3';
                                                _('smke_screen_2').style.display = 'block';
                                                _('smke_screen_2').style.zIndex = '2';">
                                                <div id="add_qual_div"
                                                    style="margin:0px;
                                                    float:right;
                                                    padding:3%;
                                                    width:20%;
                                                    border:0px solid #ccc;" 
                                                    title="Click to delete multiple items">
                                                        <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'delete_mult.png');?>" style="cursor:pointer; height:22px; width:19px; margin-top:3px;">
                                                </div>
                                            </a><?php
                                            }
                                    }else
                                    {?>
                                        <div id="add_qual_div"
                                            style="margin:0px;
                                            float:right;
                                            margin-left:2%; 
                                            padding:4px;
                                            padding:3%;
                                            width:20%;
                                            border:1px solid #ccc; opacity:0.2" 
                                            title="Not available for your role">
                                            <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'delete_one.png');?>" style="cursor:not-allowed; height:22px; width:19px; margin-top:3px;">
                                        </div>
                                       <div id="add_qual_div"
                                            style="margin:0px;
                                            float:right;
                                            padding:3%;
                                            width:20%;
                                            border:1px solid #ccc; opacity:0.2" title="Not available for your role">
                                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'delete_mult.png');?>" style="cursor:not-allowed; height:22px; width:19px; margin-top:3px;">
                                        </div><?php 
                                    }?>
                                </div>
                            </div>
                        </label><?php
                    
                        $prev_citem_cat = $citem_cat_01;
                        $faculty_diff = $cFacultyId_01;
                        $cEduCtgId_transi = $cEduCtgId_01;
                    }
                    $stmt->close();?>
                    <div class="innercont_stff" style="font-weight:bold;">
                        <div class="_label" style="border:1px solid #cdd8cf; width:4%; padding:5px; padding-top:10px; padding-bottom:10px;">.</div>
                        <div class="_label" style="border:1px solid #cdd8cf; width:7.2%; padding-left:0.6%; padding:5px; padding-top:10px; padding-bottom:10px;">.</div>
                        <div class="_label" style="border:1px solid #cdd8cf; width:7.2%; padding-left:0.6%; padding:5px; padding-top:10px; padding-bottom:10px;" >.</div>
                        <div class="_label" style="border:1px solid #cdd8cf; width:4.4%; padding:5px; padding-top:10px; padding-bottom:10px;">.</div>
                        <div class="_label" style="border:1px solid #cdd8cf; width:50.4%; padding-left:0.6%; padding:5px; padding-top:10px; padding-bottom:10px;">
                            Sub total
                        </div>
                        
                        <div class="_label" style="border:1px solid #cdd8cf; width:9.7%; padding:5px; padding-top:10px; padding-bottom:10px; text-align:right;">
                            <?php echo number_format($citem_cat_total, 2, '.', ',');?>
                        </div>
                        <div class="_label" style="border:1px solid #cdd8cf; width:9.2%; padding:5px; padding-top:10px; padding-bottom:10px; text-align:right">.</div>
                    </div>
                </div><?php
            }?>
                
            <div id="edit_new_it" class="center" 
                style="width:795px; 
                height:auto;
                border:1px solid #CCCCCC; 
                padding:8px; 
                display:none;
                box-shadow: 2px 2px 8px 2px #726e41;
                background:#ffffff;
                z-index:5;">
                <div id="div_header" class="innercont_stff" style="height:auto; padding:3px; color:#FFFFFF; margin-bottom:5px; width:95.3%; color:#637649"></div>

                <div class="innercont_stff" style="height:auto; padding:3px; color:#FFFFFF; margin-bottom:5px; width:2%; color:#637649">
                    <img style="width:17px; height:17px; cursor:pointer" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" 
                        onclick="_('edit_new_it').style.zIndex = '-1';
                        _('edit_new_it').style.display='none';
                        _('smke_screen_2').style.zIndex = '-1';
                        _('smke_screen_2').style.display = 'none';
                        return false"/>
                </div>
                
                <hr style="height:5px; width:100%; margin-top:6px; margin-bottom:7px; background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0px; height:1px;" />
            
                <div class="innercont_stff" style="padding-top:1px;">
                    <label for="cEduCtgId_loc" class="labell" style="width:180px;">Programme category</label>
                    <div class="div_select" style="width:227px;"><?php
                        $stmt = $mysqli->prepare("SELECT distinct cEduCtgId, vEduCtgDesc, iEduCtgRank 
                        FROM educationctg WHERE cEduCtgId IN ('ELX','ELZ','PGX','PGY','PGZ','PRX','PSZ') ORDER BY iEduCtgRank");
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($cEduCtgId_02, $vEduCtgDesc_02, $iEduCtgRank_02);									
                        $prev_iEduCtgRank = '';?>

                        <select name="cEduCtgId_loc" id="cEduCtgId_loc" class="select" style="border:0.5px solid #000; border-radius:3px;"
                        onchange="
                        update_cat_country('cEduCtgId_loc', 'item_cat_readup', 'item_cat', 'item_cat');
                        _('item_cat_div').style.display = 'block';">
                            <option value="" selected></option><?php
                            while ($stmt->fetch())
                            {
                                if ($prev_iEduCtgRank <> $iEduCtgRank_02)
                                {?>
                                    <option disabled></option><?php
                                }?>
                                <option value="<?php echo $cEduCtgId_02?>">
                                    <?php echo $vEduCtgDesc_02;?>
                                </option><?php
                                $prev_iEduCtgRank = $iEduCtgRank_02;
                            }
                            $stmt->close();?>
                        </select>
                        <input name="cEduCtgId_loch" id="cEduCtgId_loch" type="hidden" />
                    </div>
                    <div class="labell_msg labell_msg_glas orange_msg" style="width:auto" id="labell_msg0"></div>
                </div>
                
                <input name="confam" id="confam" type="hidden" value="0" />
                
                <div id="all_faculty_div" class="innercont_stff" style="padding-top:1px; height:25px;">
                    <label for="all_faculty" class="labell" style="width:180px;">All faculty</label>
                    <div class="div_select" style="width:227px;">
                        <input name="all_faculty" id="all_faculty" type="checkbox" style="margin-top:4px; margin-left:0px" 
                            onclick="if (this.checked)
                            {
                                for (var i = 0; i < _('cFacultyId_loc').length; i++)
                                {
                                    _('cFacultyId_loc').options[i].selected = true
                                }
                            } else 
                            {
                                for (var i = 0; i < _('cFacultyId_loc').length; i++)
                                {
                                    _('cFacultyId_loc').options[i].selected = false
                                }
                            }" />
                    </div>
                </div>

                <div class="innercont_stff" style="height:100px;">
                    <label for="cFacultyId_loc" class="labell" style="width:180px;">Faculty</label>
                    <div class="div_select" style="width:227px;"><?php
                        $sql1 = "SELECT cFacultyId, concat(cFacultyId,' ',vFacultyDesc) vFacultyDesc FROM faculty WHERE cCat = 'A' ORDER BY vFacultyDesc";
                        $rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
                        <select name="cFacultyId_loc" id="cFacultyId_loc" 
                            multiple="multiple"  
                            style="height:100%"
                            class="select" 
                            onchange="_('confam').value='0';
                            update_cat_country('cFacultyId_loc', 'cdeptId_readup', 'cdeptid_loc', 'cprogrammeId_loc');" style="height:auto">
                            <option value="" selected="selected">Select faculty</option><?php
                            while ($table= mysqli_fetch_array($rsql1))
                            {?>
                                <option value="<?php echo $table[0] ?>"<?php if ((isset($_REQUEST['cFacultyIdNew_abrv']) && $table[0] == strtoupper($_REQUEST['cFacultyIdNew_abrv'])) || (isset($_REQUEST['cFacultyIdold']) && $table[0] == $_REQUEST['cFacultyIdold'])){echo ' selected';}?>>
                                    <?php echo $table[1];?>
                                </option><?php
                            }
                            mysqli_close(link_connect_db());?>
                        </select>
                        <input name="cFacultyId_loch" id="cFacultyId_loch" type="hidden" />
                    </div>
                    <div class="labell_msg labell_msg_glas orange_msg" style="width:auto" id="labell_msg1"></div>
                </div>
                
                <div class="innercont_stff" style="height:70px; padding-top:1px;">
                    <label for="cdeptid_loc" class="labell" style="width:180px;">Department</label>
                    <div class="div_select" style="width:227px;">
                        <select name="cdeptid_loc" id="cdeptid_loc" class="select" multiple="multiple" style="height:100%" 
                            onchange="
                                _('confam').value='0';
                                update_cat_country('cdeptid_loc', 'cprogrammeId_readup', 'cprogrammeId_loc', 'cprogrammeId_loc');" style="height:auto">
                            <option value="0" selected="selected">All departments</option>
                        </select>
                        <input name="cdeptid_loch" id="cdeptid_loch" type="hidden" />
                    </div>
                    <div class="labell_msg labell_msg_glas orange_msg" style="width:auto" id="labell_msg2"></div>
                </div>
                
                <div class="innercont_stff" style="padding-top:1px; margin-bottom:5px; height:70px;">
                    <label for="cprogrammeId_loc" class="labell" style="width:180px;">Programme</label>
                    <div class="div_select" style="width:227px;">
                        <select name="cprogrammeId_loc" id="cprogrammeId_loc" class="select" multiple="multiple" size="4" style="height:auto">
                            <option value="0" selected="selected">All programmes</option>
                        </select>
                        <input name="cprogrammeId_loch" id="cprogrammeId_loch" type="hidden" />
                    </div>
                    <div class="labell_msg labell_msg_glas orange_msg" style="width:auto" id="labell_msg3"></div>
                </div>

                <div class="innercont_stff" style="padding-top:1px;">
                    <label for="level_burs" class="labell" style="width:180px;">Level</label>
                    <div class="div_select" style="width:227px;">
                        <select name="level_burs" id="level_burs" class="select" style="border:0.5px solid #000; border-radius:3px;">
                            <option value="" selected="selected"></option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option><?php
                            for ($t = 100; $t <= 800; $t+=100)
                            {?>
                                <option value="<?php echo $t ?>"><?php echo $t;?></option><?php
                            }?>
                        </select>
                        <input name="ilevel_loch" id="ilevel_loch" type="hidden" />
                    </div>
                </div>
                
                <div id="item_cat_div" class="innercont_stff" style="padding-top:1px; display:none">
                    <label for="item_cat" class="labell" style="width:180px;">Item category<font color="#FF0000">*</font></label>
                    <div class="div_select" style="width:227px;">
                        <select name="item_cat" id="item_cat" class="select" style="border:0.5px solid #000; border-radius:3px;"
                            onchange="_('item_cat_letter').value=this.options[this.selectedIndex].text; if (this.value.substr(1,1)==2)
                            {_('iCreditUnit_burs_div').style.display='block';}else{_('iCreditUnit_burs_div').style.display='none';}">
                            <option value="" selected></option>
                        </select>
                        <input name="item_cat_letter" id="item_cat_letter" type="hidden" />
                        <input name="item_cat_loch" id="item_cat_loch" type="hidden" />
                    </div>
                    <div class="labell_msg labell_msg_glas orange_msg" style="width:auto" id="labell_msg4"></div>
                </div>
                
                <div id="iCreditUnit_burs_div" class="innercont_stff" style="padding-top:1px; display:none">
                    <label for="item_cat" class="labell" style="width:180px;">Credit unit</label>
                    <div class="div_select" style="width:227px;">
                        <select name="iCreditUnit_burs" id="iCreditUnit_burs" class="select" style="border:0.5px solid #000; border-radius:3px;">
                            <option value="" selected></option><?php
                            for ($c = 1; $c <= 6; $c++)
                            {?>
                                <option value="<?php echo $c;?>" <?php if (isset($_REQUEST['iCreditUnit']) && $_REQUEST['iCreditUnit'] == $c){echo ' selected';} ?>><?php echo $c;?></option><?php
                            }?>
                        </select>
                    </div>
                    <div class="labell_msg labell_msg_glas orange_msg" style="width:auto" id="labell_msg11" style="width:auto;"></div>
                    <input name="iCreditUnit_loch" id="iCreditUnit_loch" type="hidden" />
                </div>

                <div class="innercont_stff" style="padding-top:1px;"><?php
                    $rs_sql = mysqli_query(link_connect_db(), "SELECT fee_item_id, fee_item_desc FROM fee_items WHERE 
                    cdel = 'N' ORDER BY fee_item_desc") or die(mysqli_error(link_connect_db()));?>
                    <label for="fee_item" class="labell" style="width:180px;">Description</label>
                    <div class="div_select" style="width:227px;">
                        <select name="vDesc_loc" id="vDesc_loc" class="select" style="border:0.5px solid #000; border-radius:3px;">
                            <option value="" selected></option><?php
                            $c = 0;
                            while ($rs = mysqli_fetch_array($rs_sql))
                            {
                                $c++;
                                if ($c%5==0)
                                {?>
                                    <option disabled></option><?php
                                }?>
                                <option value="<?php echo $rs['fee_item_id'];?>">
                                    <?php echo $rs['fee_item_desc'];?>
                                </option><?php
                            }
                            mysqli_close(link_connect_db());?>
                        </select>
                    </div>
                    <div id="labell_msg5" class="labell_msg blink_text orange_msg" style="width:auto;"></div>
                    <input name="vDesc_loch" id="vDesc_loch" type="hidden" />
                </div>
                
                <div class="innercont_stff" style="padding-top:1px; margin-bottom:5px;">
                    <label for="amount_loc" class="labell" style="width:180px;">Amount<font color="#FF0000">*</font></label>
                    <div class="div_select" style="width:227px;">
                        <input name="amount_loc" id="amount_loc" type="number" class="textbox" style="text-transform:none; width:96.5%" />
                    </div>
                    <div class="labell_msg labell_msg_glas orange_msg" style="width:auto" id="labell_msg6"></div>
                    <input name="amount_loch" id="amount_loch" type="hidden" />
                </div>
                
                <div class="innercont_stff" style="padding-top:1px; margin-bottom:5px;">
                    <label for="eff_date" class="labell" style="width:180px;">Effective date<font color="#FF0000">*</font></label>
                    <div class="div_select" style="width:227px;"><?php
                        $min_date = date('Y-m-d');?>
                        <input name="eff_date" id="eff_date" type="date" class="textbox" min="<?php echo $min_date;?>" style="text-transform:none; width:96.5%" />
                    </div>
                    <div class="labell_msg labell_msg_glas orange_msg" style="width:auto" id="labell_msg7"></div>
                </div>
                
                <input name="parent_share_i1" id="parent_share_i1" type="hidden" value="100"/>
                <input name="parent_share_d1" id="parent_share_d1" type="hidden" value="0"/>
                
                <input id="parent_share_banker" name="parent_share_banker" type="hidden" value="000" />
                <input id="parent_share_bank_account" name="parent_share_bank_account" type="hidden" value="0320496861013" />
                <input id="parent_share_name" name="parent_share_name" type="hidden" value="Remita Revenue" />

                <div class="labell_msg labell_msg_glas orange_msg" style="width:auto" id="labell_msg7"></div>
                <input name="parent_share_h" id="parent_share_h" type="hidden" value="0" />
                <input name="parent_share_banker_name" id="parent_share_banker_name" type="hidden" />

                <div class="innercont_stff" style="margin-bottom:2px;">
                    <div id="konfirm" style="float:right">
                        <a href="#"class="basic_three_sm_stff basic_three_sm_stff_loc"
                        style="width:85px; padding:9px; color:#000; background:#FFFFFF; margin:0px; margin-right:5px"
                        onclick="_('edit_new_it').style.zIndex = '-1';
                        _('edit_new_it').style.display='none';
                        _('smke_screen_2').style.zIndex = '-1';
                        _('smke_screen_2').style.display = 'none';
                        
                        _('print_btn').style.display = 'block';
                        return false">Close</a>
                        
                        <a id="btn_save" href="#" class="basic_three_sm_stff"
                        style="width:85px; padding:9px; margin:0px; display:block" 
                        onclick="_('save_cf').value='1';								
                        selitems_loc.conf.value = '';
                        chk_inputs();return false">Save</a>
                    </div>
                </div>
            </div>
            
		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;">
			<div id="pp_box">
				<img name="passprt" id="passprt" src="img/p_.png" width="95%" height="185"  
				style="margin:0px;<?php if ($currency <> '1' ){?>opacity:0.3;<?php }?>" alt="" />
			</div>
			<!-- InstanceBeginEditable name="EditRegion7" -->
			<!-- InstanceEndEditable -->
		</div>
		<div id="insiderightSide">
			<!-- InstanceBeginEditable name="EditRegion8" -->
                <div class="innercont_stff" style="margin:0px; padding:0px;">
                    <a href="#" style="text-decoration:none;" onclick="_('nxt').action = 'staff_home_page';_('nxt').mm.value='';_('nxt').submit();return false">
                        <div class="basic_three" style="height:auto; width:inherit; padding:8.5px; float:none; margin:0px;">Home</div>
                    </a>
                </div>
                
				<?php side_detail('');?>
				<!-- InstanceEndEditable -->
		</div>
		<div id="insiderightSide" style="position:relative;">
			<!-- InstanceBeginEditable name="EditRegion9" -->
			<?php require_once ('stff_bottom_right_menu.php');?>
			<!-- InstanceEndEditable -->
		</div>
	</div>
	<div id="futa"><?php foot_bar();?></div>
</div>
</body>
<!-- InstanceEnd --></html>