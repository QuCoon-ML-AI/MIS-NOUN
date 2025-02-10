<?php 
if (isset($_REQUEST["top_menu_no"]) && (($_REQUEST["top_menu_no"] == 4 && $_REQUEST["side_menu_no"] == 'transcript') || 
$_REQUEST["top_menu_no"] == 6 ||
$_REQUEST["top_menu_no"] == 11 || 
($_REQUEST["top_menu_no"] == 12 && $_REQUEST["side_menu_no"]  == 'drop_complaint') || 
($_REQUEST["top_menu_no"] == 10 && $_REQUEST["side_menu_no"] == 'eticket')))
{?>
	<div id="smke_screen_5" class="smoke_scrn" style="display:block; z-Index:7"></div>

	<div id="letsgo_box" class="center top_most talk_backs talk_backs_logo" 
	style="border-color:#4fbf5c; background-size: 42px 45px; background-image: url('<?php echo BASE_FILE_NAME_FOR_IMG;?>letsgo.png'); max-height:450px; display:block; ">
		<div id="informa_msg_content" class="informa_msg_content_caution_cls" style="color:#4fbf5c;"><?php
			if ($_REQUEST["top_menu_no"]== 4 && $_REQUEST["side_menu_no"] == 'transcript')
			{
				echo "Let's go to the 'transcript processor'";
			}else if ($_REQUEST["top_menu_no"] == 6)
			{
				echo "Let's go to 'My learning space";
			}else if ($_REQUEST["top_menu_no"] == 7)
			{
				echo "Let's go the library.";
			}else if ($_REQUEST["top_menu_no"] == 10)
			{
				if ($_REQUEST["side_menu_no"]  == 'tma1')
				{
					echo "Let's go to TMA1";
				}else if ($_REQUEST["side_menu_no"]  == 'tma2')
				{
					echo "Let's go to TMA2";
				}else if ($_REQUEST["side_menu_no"]  == 'tma3')
				{
					echo "Let's go to TMA3";
				}else if ($_REQUEST["side_menu_no"]  == 'seminar')
				{
					echo "Let's go to your seminar record";
				}else if ($_REQUEST["side_menu_no"]  == 'siwess')
				{
					echo "Let's go to your SIWESS record";
				}else if ($_REQUEST["side_menu_no"]  == 'research_project')
				{
					echo "Let's go to your research project record";
				}else if ($_REQUEST["side_menu_no"]  == 'internship')
				{
					echo "Let's go to your internship record";
				}else if ($_REQUEST["side_menu_no"]  == 'practicum')
				{
					echo "Let's go to your practcum record";
				}else if ($_REQUEST["side_menu_no"]  == 'teaching_practice')
				{
					echo "Let's go to your teaching practice record";
				}
			}else if ($_REQUEST["top_menu_no"] == 11)
			{
				echo "Let's go to the progess board";
			}else if ($_REQUEST["top_menu_no"] == 12)
			{
				if ($_REQUEST["side_menu_no"]  == 'drop_complaint')
				{
					echo "Let's go to Support";
				}
			}?>
		</div>
		<div class="informa_msg_content_caution_cls" style="margin-top:3px; text-align:right">
			<input id="ok_button" class="buttons_yes"type="submit" value="Go" 
			style="width:auto; padding:10px; height:auto;"
			onclick="_('smke_screen_5').style.display = 'none';
			_('smke_screen_5').style.zIndex = '-1';
			_('letsgo_box').style.display = 'none';
			_('letsgo_box').style.zIndex = '-1';
			_('informa_msg_content').innerHTML = '';"/>
		</div>
	</div><?php
}?>