<?php $current_date = date("Y-m-d");

$stmt = $mysqli->prepare("SELECT vApplicationNo, cFacultyId, cdeptId, cProgrammeId, silevel, msg_subject, msg_body, sender_signature, f_pg, act_time
FROM student_notice_board WHERE msg_loc = 2 AND cshow = '1' AND date1 >= '$current_date' ORDER BY act_time");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($vApplicationNo, $cFacultyId, $cdeptId, $cProgrammeId, $silevel, $msg_subject, $msg_body, $sender_signature, $f_pg, $act_time);

$messages = '';
$counting = 0;
while($stmt->fetch())
{
	if ($f_pg == '0')
	{
		$stmt_centre = $mysqli->prepare("SELECT cStudyCenterId
		FROM user_centre 
		WHERE vApplicationNo = '$vApplicationNo'");
		$stmt_centre->execute();
		$stmt_centre->store_result();
		$stmt_centre->bind_result($cStudyCenterId_staff);						

		if ($stmt_centre->num_rows > 0)
		{
			$found_match = 0;
			while ($stmt_centre->fetch())
			{
				if ($cStudyCenterId_staff == $cStudyCenterId_loc)
				{
					$found_match = 1;
					break;
				}
			}

			if ($found_match == 0)
			{
				$stmt_centre->close();
				continue;
			}
		}

		if ($cEduCtgId_loc == 'PGZ' || $cEduCtgId_loc == 'PRX')
		{
			continue;
		}
	}else if ($cEduCtgId_loc <> 'PGZ' && $cEduCtgId_loc <> 'PRX')
	{
		continue;
	}
	
	if ($cFacultyId <> '' && $cFacultyId_loc <> $cFacultyId)
	{
		continue;
	}

	if ($cdeptId <> '' && $cdeptId_loc <> $cdeptId)
	{
		continue;
	}

	if ($cProgrammeId <> '' && $cProgrammeId_loc <> $cProgrammeId)
	{
		continue;
	}

	if ($silevel <> 0 && $silevel <> '' && $iStudy_level_loc <> $silevel)
	{
		continue;
	}

	$messages .= nl2br("<b>(".++$counting.") ".$msg_subject."</b> ".formatdate($act_time,'fromdb')." ".substr($act_time,11)."\r\n".$msg_body."\r\n<i>". $sender_signature."</b>\r\n</i><hr><p>");
}
$stmt->close();

if ($messages <> '')
{?>
	<div id="smke_screen_3" class="smoke_scrn" style="display:block; z-Index:5"></div>

	<div id="noticeboard" class="center top_most" 
		style="display:block; 
		text-align:center; 
		padding:15px;  
		padding-right:10px; 
		box-shadow: 2px 2px 8px 2px #726e41; 
		background:#FFFFFF;
		z-Index:6;
		max-height: 620px;
		overflow:auto; 
		overflow-x: hidden;"
		onclick="_('noticeboard').style.display = 'none';
		_('noticeboard').zIndex = '-1';
		_('smke_screen_3').style.display = 'none';
		_('smke_screen_3').zIndex = '-1';
		return false" title="Click to remove">
		<div style="width:94%; 
			float:left; 
			text-align:left; 
			padding:0px; 
			color:#e31e24;
			height:15px;">
			Notice Board
		</div>
		<div style="width:4%;
			height:15px;
			padding:3px;
			float:right; 
			text-align:right;">
				<a href="#"
					onclick="_('noticeboard').style.display = 'none';
					_('noticeboard').zIndex = '-1';
					_('smke_screen_3').style.display = 'none';
					_('smke_screen_3').zIndex = '-1';
					return false" 
					style="margin-right:3px; text-decoration:none;">
						<img style="width:17px; height:17px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>"/>
				</a>
		</div>

		<div style="line-height:2; margin-top:10px; width:98%; float:left; text-align:justify; padding:0px;
		padding-right:5px;">
			<?php echo $messages;?>
		</div>
	</div><?php
}?>