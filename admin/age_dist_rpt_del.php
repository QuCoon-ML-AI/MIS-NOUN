<table cellspacing="0" cellpadding="2" border="1" bordercolor="#000000">
			<tr>
				<td colspan="2"><?php
					$title = '<font size="3" face="Tahoma"><b>NATIONAL OPEN UNIVERSITY OF NIGERIA</b></font><p>';
					
					$title = $title . 'AGE DISITRIBUTION OF ';
					if ($_REQUEST['std_cat'] == 'a'){$title = $title . 'APPLICANT STUDENTS';}else
					if ($_REQUEST['std_cat'] == 'b'){$title = $title . 'ADMITTED STUDENTS';}else
					if ($_REQUEST['std_cat'] == 'c'){$title = $title . 'REGISTERED STUDENTS';}
					
					//$title = $title . sesion($_REQUEST['schl_session'],$_REQUEST['iyear']) . '<p>';
					//$title = put_crit_in_title($title);
					
					if (isset($_REQUEST['rpt_date_title']) && $_REQUEST['rpt_date_title'] == 1)
					{
						//$title = $title . date_cond_title();
					}
					
					for ($d = 1; $d <= 4; $d++)
					{
						if (isset($_REQUEST["rpt_title$d"]) && trim($_REQUEST["rpt_title$d"]) <> '')
						{
							$title = $title . $_REQUEST["rpt_title$d"] . '<br>';
						}
					}
//echo strlen($title);
					/*if (strlen($title) == 88)
					{
						$title = $title . 'AGE DISITRIBUTION OF ';
						if ($_REQUEST['std_cat'] == 'a'){$title = $title . 'APPLICANT STUDENTS';}else
						if ($_REQUEST['std_cat'] == 'b'){$title = $title . 'ADMITTED STUDENTS';}else
						if ($_REQUEST['std_cat'] == 'c'){$title = $title . 'REGISTERED STUDENTS';}
						$title = $title . sesion($_REQUEST['schl_session'],$_REQUEST['iyear']);
						$title = put_crit_in_title($title);
						if (isset($_REQUEST['rpt_date_title']) && $_REQUEST['rpt_date_title'] == 1)
						{
							$title = $title . date_cond_title();
						}
					}*/?><font  face="Tahoma" size="2"><?php
					echo $title;?>
					</font><p></p>
					<font size="1" face="Tahoma">
					As at 01-06-2010
					</font>
				</td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<!--<tr><td colspan="2">
				<b><font size="2" face="Tahoma">AGE DISTRIBUTION</font></b>
			</td>
			</tr>-->
			<tr>
			<td>
				<b><font size="2" face="Tahoma"><?php
					echo 'AGE RANGE (YEARS)';?>
				</font></b>
			</td>
			<td align="right">
				<b><font size="2" face="Tahoma"><?php
					echo 'COUNT';?>
				</font></b>
			</td>
		</tr><?php

		$spec_cond = ''; $open_brac = ''; $close_brac = ''; $lkb = '';
		
		$selectCol = "SELECT floor(PERIOD_DIFF(DATE_FORMAT(curdate(), '%Y%m'),
		DATE_FORMAT(dBirthDate, '%Y%m'))/12) AS age ";
		
		$fromm = substr(std_cat($_REQUEST['std_cat'],$_REQUEST['schl_session'],$_REQUEST['iyear']),0,strlen(std_cat($_REQUEST['std_cat'],$_REQUEST['schl_session'],$_REQUEST['hdiyear']))-2);
		
		$sqlwhere = ' WHERE ';
		
		// if ($_REQUEST['crit3'] <> '')
		// {
		// 	$fromm .= ', depts dpt';
		// 	$sqlwhere .= "a.cFacultyId = dpt.cFacultyId AND ";
		// }
		// $sqlwhere .= complete_where_clause();

		$sqlwhere .= complete_where_clause_new();
		
		//$sqlwhere .= substr(date_cond($sqlwhere),4,strlen(date_cond($sqlwhere)));
		if ($sqlwhere <> ' WHERE ')
		{
			$sqlwhere = substr($sqlwhere,0,strlen($sqlwhere)-5);
		}else
		{
			$sqlwhere = '';
		}
				
		$sql_ad_rpt =  $selectCol . $fromm . $sqlwhere . "  ORDER BY age";
		echo $sql_ad_rpt;
		
		// $cnx_loc = mysqli_connect("localhost", "root", "") or die(mysqli_error(link_connect_db()));
		// mysqli_select_db('noumisdb202', $cnx_loc);
		
		
		$ad_name = '';
		for ($k = 1; $k <= 10; $k++)
		{
			$ad_name1 = "grp".$k."1";
			$ad_name2 = "grp".$k."2";
			if ($_REQUEST["$ad_name1"] <> '' && $_REQUEST["$ad_name2"] <> '')
			{
				$rs_ad_rpt = mysqli_query(link_connect_db(), $sql_ad_rpt, $cnx_loc) or die(mysqli_error(link_connect_db()));
				$age_count = 0;
				while($row_ad = mysqli_fetch_array($rs_ad_rpt))
				{
					if (($row_ad['age'] >= $_REQUEST["$ad_name1"]) && ($row_ad['age'] <= $_REQUEST["$ad_name2"]))
					{
						$age_count++;
					}
				}
				mysqli_close(link_connect_db());?>
				<tr>
					<td>
						<font size="2" face="Tahoma"><?php
							echo $_REQUEST["$ad_name1"] . '-' . $_REQUEST["$ad_name2"];?>
						</font>
					</td>
					<td align="right">
						<font size="2" face="Tahoma"><?php
						echo number_format($age_count);?>
						</font>
					</td>
				</tr><?php
			}
		}?>
		<tr>
			<td align="right" colspan="2">&nbsp;</td>
		</tr>
	</table>