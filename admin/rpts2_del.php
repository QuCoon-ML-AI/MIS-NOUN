<?php
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('fn_l01b.php');
require_once('rpt_lib.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php

$orgsetins = settns();


$currency = 1;?>
<!--<script language="JavaScript" type="text/javascript" src="button_ops.js"></script> -->
<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
<!--<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" /> -->
<title>NOUN-MIS</title>
<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
<style type="text/css">
	div{
		-webkit-border-radius:3px; /* for Webkit-Browsers */
		-moz-border-radius: 3px;
		-o-border-radius: 3px;
		border-radius:3px; /* regular */
		/* opacity:0.5; Transparent Background 50% */
	}
	#succ_box {
		padding: 10px;
		width:632px;;
		height:auto;
		margin-top:200px;
		margin-left:370px;
		float: none;
		vertical-align: bottom;
		font-family:Verdana, Arial, Helvetica, sans-serif;
		background-color:#FFFFFF;
		font-size:13px;
		text-align:center;
		border: 1px solid #000;
	}

	table
	{
		border:0px solid #cccccc;
		padding:0px
	}
	

	td
	{
		border:1px solid #cccccc;
		padding:5px;
		font-size:12px;
		font-family:arial;
		text-align:left;
	}
</style>
</head>

<body onload="/*window.print()*/">
	<form action="open-to-enter" method="post" name="pass1" enctype="multipart/form-data">
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"])){echo $_REQUEST["vMatricNo"];} ?>" />
		<input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="currency" id="currency" type="hidden" value="<?php if ($GLOBALS['currency']=='1'){echo $GLOBALS['currency'];} ?>" />
	</form><?php
	if (isset($_REQUEST['finich']) && $_REQUEST['finich'] = 'go' && $currency == 1)
	{
		if (isset($_REQUEST['whc_lnk']) && $_REQUEST['whc_lnk'] == 'ad')
		{
			require_once('age_dist_rpt.php');
		}else
		{
			$sqlwhere = '';
			
			$title = title_rpt();
			
			$selection = $_REQUEST['selection'];

			
			if (is_bool(strpos($selection, 'a')))
			{
				$selection = 'a'.$selection;
			}			

			$title1 = get_grp_flds($selection);

			if ($_REQUEST['hdqry_type'] == '1' && $title1 <> '')
			{
				$title .= '<br>'.$title1;
			}
			
			$title1 = get_srt_flds($_REQUEST['selectionst']);
			if(isset($_REQUEST['selectionst']) && $title1 <> '')
			{
				$title .= '<br>' . $title1.'<p>';
			}

			$title .= "<p>SESSION <b>".$_REQUEST['schl_session'].'</b>';
			
			$sqlselect = "SELECT ";
			$sqlfrom = std_cat();
			
			$sqlgrp = "GROUP BY ";
			$sqlorder = "ORDER BY ";
			
			$binders = '';
			$bind_vars = array();
			$bind_rslt_vars = '';
			
			compose_cols();
			
			if ($_REQUEST['hdqry_type'] == '1')
			{
				$sqlselect .= "Count(*) AS Count, ";
				if (strlen($_REQUEST['selectionst']) == 0)
				{
					$sqlorder .= "Count, ";
				}
			}
			
			
			$sqlwhere .= complete_where_clause_new();
			$sqlorder .= complete_order_clause();
						
			$sqlselect = substr($sqlselect, 0,strlen($sqlselect)-2);
			$sqlfrom = substr($sqlfrom, 0,strlen($sqlfrom)-2);
			$sqlwhere = substr($sqlwhere, 0,strlen($sqlwhere)-5);
			
			
			if ($sqlgrp <> "GROUP BY ")
			{
				$sqlgrp = substr($sqlgrp, 0,strlen($sqlgrp)-2);
			}else
			{
				$sqlgrp = "";
			}
		
			
			if ($sqlorder <> "ORDER BY ")
			{
				$sqlorder = substr($sqlorder, 0,strlen($sqlorder)-2);
			}else
			{
				$sqlorder = "";
			}

			$sqloverall = $sqlselect.' '.$sqlfrom.' '.$sqlwhere.' '.$sqlgrp.' '.$sqlorder;			
			

			foreach ($bind_vars as $value) {
				echo $value.',';
			}
			echo '<br>'.$binders.'<br>'.$sqloverall;


			wrt_rpt($title, $sqloverall);
		}
	}else if ($currency <> 1)
	{?>
		<form action="home-page" method="post" name="hpg" enctype="multipart/form-data">
			<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
			<input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"])){echo $_REQUEST["vMatricNo"];} ?>" />
			<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
			<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
			<input name="logout" type="hidden" value="1" />
		</form>

		<div id="succ_box">
			<div class="hrline"></div>
			<?php echo $currency;?>
			<div class="hrline"></div>
		</div><?php
	}?>
</body>
</html>
