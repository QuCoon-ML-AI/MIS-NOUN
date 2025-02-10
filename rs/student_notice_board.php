<?php 
$stmt = $mysqli->prepare("SELECT vApplicationNo, cFacultyId, cdeptId, cProgrammeId, silevel, msg_subject, msg_body, sender_signature, date1, cshow, f_pg
FROM student_notice_board ORDER BY act_time DESC");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($vApplicationNo, $cFacultyId, $cdeptId, $cProgrammeId, $silevel, $msg_subject, $msg_body, $sender_signature, $date1, $cshow, $f_pg);

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

	if ($cshow == '1' && $date1 > $current_date)
	{
		$messages .= nl2br("<b>(".++$counting.") ".$msg_subject."</b>\r\n".$msg_body."\r\n<i>". $sender_signature."</i><hr><p>");
	}
}
$stmt->close();
if ($messages <> '')
{?>
	<div id="smke_screen_3" class="smoke_scrn" style="display:block; z-Index:5"></div>
	<div id="noticeboard" class="center" 
		style="display:block; 
		width:525px; 
		text-align:center; 
		padding:15px;  
		padding-right:10px; 
		box-shadow: 2px 2px 8px 2px #726e41; 
		background:#FFFFFF; 
		top: 45%;
		z-Index:6;">
		<div style="width:94.8%; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
			Notice Board
		</div>
		<div style="width:4%;
			height:15px;
			padding:3px;
			float:left; 
			text-align:right;">
				<a href="#"
					onclick="_('noticeboard').style.display = 'none';
					_('noticeboard').zIndex = '-1';
					_('smke_screen_3').style.display = 'none';
					_('smke_screen_3').zIndex = '-1';
					return false" 
					style="margin-right:3px; text-decoration:none;">
						<img style="width:17px; height:17px" src="../m/img/close.png"/>
				</a>
		</div>

		<div style="line-height:2; margin-top:10px; width:100%; float:left; text-align:justify; padding:0px;
		max-height: 650px;
		padding-right:5px;
		overflow:auto; 
		overflow-x: hidden;">
			<?php echo $messages;?>
		</div>
	</div><?php
}?>