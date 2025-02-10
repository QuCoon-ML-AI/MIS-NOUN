<?php
if (!isset($_REQUEST['user_cat']))
{?>
    <div style="font-family:Verdana, Arial, Helvetica, sans-serif; 
    margin:auto; 
    text-align:center;
	font-size: 0.78em;"> Follow <a href="../" style="text-decoration:none;">here</a></div><?php
    exit;
}
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once(BASE_FILE_NAME.'lib_fn.php');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" />
		<script language="JavaScript" type="text/javascript" src="<?php echo BASE_FILE_NAME;?>js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/std_lg.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE_FILE_NAME;?>styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/std_lg.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
		<script language="JavaScript" type="text/javascript">
			function completeHandler(event)
			{
				on_error('0');
				on_abort('0');
				in_progress('0');
				var returnedStr = event.target.responseText;
				returnedStr = returnedStr.trim();
			
				with(ps)
				{
					if (returnedStr == 'can continue')
					{
						in_progress('1');
						action = './student_recover_password';
						submit();
						return false;
					}else if (returnedStr.indexOf("session created") > -1)
					{
						in_progress('1');
						ilin.value = returnedStr.substr(15);
						action = './welcome_student';
						submit();
						return false;
					}else if (returnedStr == '')
					{
						caution_inform('We could not reach your student email address. Please contact the ICT unit at your study centre for resolution')
					}else
					{
						caution_inform(returnedStr)
					}
				}
			}
		</script>
	</head>
	<body><?php
        require_once(BASE_FILE_NAME."feedback_mesages.php");
        require_once(BASE_FILE_NAME."forms.php");

		$mysqli = link_connect_db();

		if ((isset($_REQUEST["new_pwd"]) && $_REQUEST["new_pwd"] == '1') || (isset($_REQUEST["rec_pwd"]) && $_REQUEST["rec_pwd"] == '1'))
        {
            $stmt = $mysqli->prepare("REPLACE INTO rs_client SET
			vPassword = md5(?), 
			cpwd = '0',
			vMatricNo = ?");
			$stmt->bind_param("ss", $_REQUEST['vPassword'], $_REQUEST['vMatricNo']);
			$stmt->execute();
			$stmt->close();
            
            if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] == '5')
            {
                if (isset($_REQUEST["new_pwd"]) && $_REQUEST["new_pwd"] == '1')
        		{
					log_actv('Set new password');
				}else
				{
					log_actv('Reset password');
				}
            }
		}

        if ((isset($_REQUEST["new_pwd"]) && $_REQUEST["new_pwd"] == '1') && !(isset($_REQUEST["rec_pwd"]) && $_REQUEST["rec_pwd"] == '1'))
        {
            $a = strtoupper($_REQUEST['vMatricNo']);
			$b = $a;

			$orgsetins = settns();

			$cAcademicDesc = $orgsetins['cAcademicDesc'];

			$student_email = strtolower($_REQUEST["vMatricNo"])."@noun.edu.ng";

			/*try
			{
				$mysqli->autocommit(FALSE);*/
				
				$stmt = $mysqli->prepare("REPLACE INTO s_m_t SELECT ?, 
				a.vApplicationNo, 
				b.vTitle, 
				b.vLastName, 
				b.vFirstName, 
				b.vOtherName, 
				b.dBirthDate,
				b.cMaritalStatusId, 
				b.cGender, 
				b.cDisabilityId, 
				c.cFacultyId, 
				d.cdeptId, 
				c.cProgrammeId, 
				d.cObtQualId,
				c.iBeginLevel, 
				c.iBeginLevel, 
				0,  
				b.cHomeCountryId, 
				b.cHomeStateId, 
				b.cHomeLGAId, 
				vHomeCityName, 
				e.cPostalCountryId, 
				e.cPostalStateId, 
				e.cPostalLGAId, 
				e.vPostalCityName, 
				e.vPostalAddress, 
				f.cResidenceCountryId, 
				f.cResidenceStateId, 
				f.cResidenceLGAId, 
				f.vResidenceCityName, 
				f.vResidenceAddress, 
				'$student_email', 
				e.vMobileNo, 
                e.w_vMobileNo,
				c.cStudyCenterId, 
				g.vNOKName, 
				g.cNOKType, 
				g.sponsor, 
				g.vNOKAddress, 
				g.vNOKEMailId, 
				g.vNOKMobileNo, 
				g.vNOKName1, 
				g.cNOKType1, 
				g.sponsor1, 
				g.vNOKAddress1, 
				g.vNOKEMailId1, 
				g.vNOKMobileNo1, 
				g.sponsor2,
				'0',
				'0',
				'0',
				'0',
				'0',
				now(),
				'$cAcademicDesc',
				'0',
				c.in_mate,
				c.cAcademicDesc
				FROM afnmatric a, pers_info b, prog_choice c, programme d, post_addr e, res_addr f, nextofkin g
				WHERE a.vApplicationNo = b.vApplicationNo 
				AND c.vApplicationNo = b.vApplicationNo 
				AND e.vApplicationNo = b.vApplicationNo 
				AND f.vApplicationNo = b.vApplicationNo 
				AND g.vApplicationNo = b.vApplicationNo 
				AND c.cProgrammeId = d.cProgrammeId
				AND a.vMatricNo = ?");
				$stmt->bind_param("ss", $_REQUEST['vMatricNo'], $_REQUEST['vMatricNo']);
				$stmt->execute();

				$stmt = $mysqli->prepare("REPLACE INTO applyqual_stff SELECT ?, a.cQualCodeId, '', '', a.vExamNo, a.vExamSchoolName, a.cExamMthYear, a.cDelFlag FROM applyqual a, afnmatric b WHERE a.vApplicationNo = b.vApplicationNo AND b.vMatricNo = ?");
				$stmt->bind_param("ss", $a, $b);
				$stmt->execute();
				
				$stmt = $mysqli->prepare("REPLACE INTO afnqualsubject_stff SELECT ?, a.cEduCtgId, a.cQualCodeId, a.cExamMthYear, a.vExamNo, a.cNouSubjectId, a.cNouGradeId, a.iGradeRank, a.iSittingSerial, a.cStatus, a.cDelFlag FROM afnqualsubject a, afnmatric b WHERE a.vApplicationNo = b.vApplicationNo AND b.vMatricNo = ?");
				$stmt->bind_param("ss", $a, $b);
				$stmt->execute();
				
				$stmt = $mysqli->prepare("REPLACE INTO applysubject_stff SELECT ?, a.cQualCodeId, a.vExamNo, a.cQualSubjectId, a.cQualGradeId, a.cDelFlag FROM applysubject a, afnmatric b WHERE a.vApplicationNo = b.vApplicationNo AND b.vMatricNo = ?");
				$stmt->bind_param("ss", $a, $b);
				$stmt->execute();

				$stmt = $mysqli->prepare("INSERT IGNORE INTO s_m_t_semester SELECT 
				vMatricNo, 
				1, 
				iBegin_level, 
				iStudy_level,  
				1
				FROM s_m_t
				WHERE vMatricNo = ?");
				$stmt->bind_param("s", $a);
				$stmt->execute();

				// $stmt = $mysqli->prepare("SELECT LCASE(b.cFacultyId), b.cEduCtgId FROM afnmatric a, prog_choice b WHERE a.vApplicationNo = b.vApplicationNo AND a.vMatricNo = ?");
				// $stmt->bind_param("s", $_REQUEST['vMatricNo']);
				// $stmt->execute();
				// $stmt->store_result();
				// $stmt->bind_result($fac, $cEduCtgId);
				// $stmt->fetch();

				// $fac = $fac ?? '';
				// $cEduCtgId = $cEduCtgId ?? '';

				// if ($fac <> '')
				// {
				// 	if ($cEduCtgId == 'ELX')
				// 	{
				// 		$fac = 'elx';
				// 	}

				// 	$stmt = $mysqli->prepare("REPLACE INTO s_m_t_$fac SELECT * FROM s_m_t WHERE vMatricNo = ?");
				// 	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
				// 	$stmt->execute();
					
				// 	$stmt = $mysqli->prepare("REPLACE INTO applyqual_stff_$fac SELECT * FROM applyqual_stff WHERE vMatricNo = ?");
				// 	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
				// 	$stmt->execute();
					
				// 	$stmt = $mysqli->prepare("REPLACE INTO afnqualsubject_stff_$fac SELECT * FROM afnqualsubject_stff WHERE vMatricNo = ?");
				// 	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
				// 	$stmt->execute();
					
				// 	$stmt = $mysqli->prepare("REPLACE INTO applysubject_stff_$fac SELECT * FROM applysubject_stff WHERE vMatricNo = ?");
				// 	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
				// 	$stmt->execute();
				// }
									                
                if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] == '4')
                {
				    log_actv('Signed up');
                }
				$stmt->close();
				
			/*	$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
				
			}catch(Exception $e)
			{
			  $mysqli->rollback(); //remove all queries FROM queue if error (undo)
			  throw $e;
			}*/

            
            $msg = "Success<p>All e-mail correspondence between you and the University will henceforth, be via your student email (".$student_email.") address<p>
			Default password to your eamil is <b>".strtoupper($_REQUEST["vMatricNo"])."</b><p>Login to continue";
			success_box($msg);?>
    
            <script language="JavaScript" type="text/javascript">
                //inform('<?php //echo $msg;?>');
            </script><?php
        }
        
        if (isset($_REQUEST["logout"]) && $_REQUEST["logout"] == '1' || (isset($_REQUEST["new_pwd"]) && $_REQUEST["new_pwd"] == '1'))
        {
            clean_up();   
        }?>

        <form method="post" name="ps" enctype="multipart/form-data" onsubmit="chk_inputs(); return false">
			<input name="ilin" type="hidden" value="" />
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
            <input name="recover_pwd" type="hidden" value="" />
            <input name="just_coming" type="hidden" value="1" />
            <div class="button_container">
                <div style="flex:100%; text-align:center; margin-top:20px; background-color:#FFFFFF;">
                    <img id="logo_pix" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" />
                </div>

                <div style="margin-top:10px; font-size:1.1em; text-align:center;">
                    Students' Login Page
                </div>

                <div style="margin-top:10px;">
                    <label for="vMatricNo">
                        Matriculation (Registration) number
                    </label>
                </div>            
                <div>
                    <input type="text" id="vMatricNo" name="vMatricNo" placeholder="Example: NOU123456789" maxlength="25" required 
                        onchange="this.value=this.value.replace(/ /g, '');
						this.value=this.value.toUpperCase();
						if (this.value.trim() != '' && ps.vPassword.value.trim() != '')
                        {
                            do_capt()
                        }"
						autocomplete="off"
                        value="<?php if(isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>">
                </div>
                
                <div>
                    <label class="chkbox_container">
                        <input type="checkbox"
                        onclick="if (this.checked)
                        {
                            _('vPassword').type = 'text';
                        }else
                        {
                            _('vPassword').type = 'password';
                        }">
                        <span class="checkmark box_checkmark"></span><div style="line-height:1.8;">Show Password</div>
                    </label>
                </div>

                <div style="margin-top:10px;">
                    <label for="vPassword">
                        Password
                    </label>
                </div>
                <div>
                    <input type="password" id="vPassword" name="vPassword" placeholder="Your password..." 
                        onchange="if (this.value.trim() != '' && ps.vMatricNo.value.trim() != '')
                        {
                            do_capt()
                        }" required>
                </div><?php
                $show = 'none';
                if ((isset($_REQUEST["logout"]) && $_REQUEST["logout"] == '1') || (isset($_REQUEST["new_pwd"]) && $_REQUEST["new_pwd"] == '1'))
                {
                    $show = 'flex';
                }?>

                <div id="cap_mean" style="margin-top:10px; display:<?php echo $show;?>">
                    <label for="cap_text" title="Completely Automated Public Turing test to tell Computers and Humans Apart">
                        Captcha
                    </label>
                </div>

                <div id="cap_caller" style="margin-top:0px; display:<?php echo $show;?>">
                    <img id="refresh_img" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'refresh.png');?>" 
						title="Refresh code" 
						width="35px" 
						height="35px" 
						style="cursor:pointer; margin-top:4px;"
                        onclick="if (ps.vMatricNo.value.trim() != '')
                        {
                            do_capt()
                        }"/>
                    <canvas id="valicode" style="height:35px; width:50%"></canvas>
                    <input name="hidden_cap_text" id="hidden_cap_text" type="hidden"/>
                </div>

                <div id="cap_resp" style="display:<?php echo $show;?>">
                    <input type="text" id="cap_text" name="cap_text" 
					placeholder="Enter the above captcha text here"
					autocomplete="off" 
					maxlength="7">
                </div>
                
				<!-- <script src="<?php //echo BASE_FILE_NAME;?>cap2.js"></script> -->
                
                <div style="text-align:center">
                    <button type="submit" class="login_button">Login</button>
                </div>
                
                <div style="text-align:center; margin-top:10px;">
					<a href="#" target="_self" style="text-decoration:none;"> 
						<div class="rec_pwd_button" title="Reset paasword" 
						onclick="ps.recover_pwd.value=1;
						chk_inputs();">Reset password
						</div>
					</a>
                </div>
                
                <div style="text-align:center; margin-top:10px;">
                    <a href="#" target="_self" style="text-decoration:none;" onclick="ps.action='../';ps.submit();return false"> 
                        <div class="login_button">Home
                        </div>
                    </a>
                </div>
            </div>
        </form>
	</body>
</html>