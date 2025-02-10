//document.addEventListener('contextmenu', event => event.preventDefault());
//event.preventDefault();

/*document.captureEvents("onkeydown", my_onkeydown_handler);
function my_onkeydown_handler()
{
	switch (event.keyCode)
	{
		case 69 : // 'E'
			if (event.ctrlKey) // Ctrl-E
			{
				event.returnValue = false;
			}
			break;
		case 53 : // '5'
			if (event.ctrlKey) // Ctrl-5
			{
				event.returnValue = false;
			}
			break;
		case 116 : // 'F5'
			event.returnValue = false;
			event.keyCode = 0; // required to disable stubborn key strokes
			break;

		case 82 : // Ctrl-R
			if (event.ctrlKey) // Ctrl-R
			{
				event.returnValue = false;
			}
			break;

		case 85 : // Ctrl-U
			if (event.ctrlKey) // Ctrl-U
			{
				event.returnValue = false;
			}
			break;

		// case 13 : // Enter/Return
		// 	alert();
		// 	event.returnValue = false;
		// 	event.keyCode = 0; // required to disable stubborn key strokes
		// 	//window.status = "You have just disabled Enter/Return";
		// 	break;
	}
}*/

document.onkeydown = function (evt)
{
	var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
	
	if (_("container_cover_in") && _("container_cover_in").style.zIndex != -1 && keyCode == 27)
	{
		_("container_cover_in").style.zIndex = -1;
		_("container_cover_in").style.display = 'none';
		if (_('smke_screen_2'))
		{
			_('smke_screen_2').style.display = 'none';
			_('smke_screen_2').style.zIndex = -1;
		}
	}else if (_("container_cover_in_chkps") && _("container_cover_in_chkps").style.zIndex != -1 && keyCode == 27)
	{
		if (_('smke_screen_2'))
		{
			_('smke_screen_2').style.display = 'none';
			_('smke_screen_2').style.zIndex = -1;
		}
		_("container_cover_in_chkps").style.zIndex = -1;
		_("container_cover_in_chkps").style.display = 'none';
	}else if (_("container_cover_in_chkps_cal") && _("container_cover_in_chkps_cal").style.zIndex != -1 && keyCode == 27)
		{
			if (_('smke_screen_2'))
			{
				_('smke_screen_2').style.display = 'none';
				_('smke_screen_2').style.zIndex = -1;
			}
			_("container_cover_in_chkps_cal").style.zIndex = -1;
			_("container_cover_in_chkps_cal").style.display = 'none';
		}else if (_('container_cover') && _("container_cover").style.zIndex != -1 && keyCode == 27)
	{
		_("container_cover").style.zIndex = -1;
		_("container_cover").style.display = 'none';
	}else if (_('edit_new_it') && _("edit_new_it").style.zIndex != -1 && keyCode == 27)
	{
		_("edit_new_it").style.zIndex = -1;
		_('edit_new_it').style.display='none';

		_("smke_screen_2").style.zIndex = -1;
		_('smke_screen_2').style.display='none';

		_('print_btn').style.display = 'block';
	}else if (_('view_new_it') && _("view_new_it").style.zIndex != -1 && keyCode == 27)
	{
		_("view_new_it").style.zIndex = -1;
		_('view_new_it').style.display='none';

		_("smke_screen_2").style.zIndex = -1;
		_('smke_screen_2').style.display='none';
		
		_('print_btn').style.display = 'block';
	}else if (_("container_cover_in2") && _("container_cover_in2").style.zIndex != -1 && keyCode == 27)
	{
		_("container_cover_in2").style.zIndex = -1;
		_("container_cover_in2").style.display = 'none';
		result_stff_loc.save.value = 0;
	}else if (_("container_cover_in_2") && _("container_cover_in_2").style.zIndex != -1 && keyCode == 27)
	{
		if (_('smke_screen_2'))
		{
			_('smke_screen_2').style.display = 'none';
			_('smke_screen_2').style.zIndex = -1;
		}
		
		_("container_cover_in_2").style.zIndex = -1;
		_("container_cover_in_2").style.display = 'none';
	}else if (_("container_cover_constat_warn") && _("container_cover_constat_warn").style.zIndex != -1 && keyCode == 27)
	{
		_("container_cover_in_constat_warn").style.zIndex = -1;
		_("container_cover_in_constat_warn").style.display = 'none';
		
		_("container_cover_constat_warn").style.zIndex = -1;
		_("container_cover_constat_warn").style.display = 'none';
	}else if (_("container_cover_in_constat_0") && keyCode == 27)
	{
		_("container_cover_in_constat_0").style.zIndex = -1;
		_("container_cover_in_constat_0").style.display = 'none';

		_("contact_guide_div").style.display = 'none';
		_("adm_guide_div").style.display = 'none';
	}else /*if (_("container_cover_in_banks") && keyCode == 27)
	{alert()
		_("container_cover_in_banks").style.zIndex = -1;
		_("container_cover_in_banks").style.display = 'none';

		_("smoke_scrn_loc").style.zIndex = -1;
		_("smoke_scrn_loc").style.display = 'none';
	}else*/ if (_("smke_screen") && keyCode == 27)
	{
		_("smke_screen").style.zIndex = -1;
		_("smke_screen").style.display = 'none';
		_("conf_warn").style.display = 'none';
		_("conf_warn").style.display = 'none';
	}else if (keyCode == 27)
	{
		evt.returnValue = false;
		evt.keyCode = 0;
	}
}
//-->
