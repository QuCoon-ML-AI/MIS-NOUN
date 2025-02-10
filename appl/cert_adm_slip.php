<?php
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('const_def.php');
require_once('../../fsher/fisher.php');
require_once('lib_fn.php');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="./img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/gpin.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/gpin.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body>
    
        <form method="post" name="ps" enctype="multipart/form-data">
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
            <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />
        </form><?php
        require_once("feedback_mesages.php");
        require_once("forms.php");
        
        $vApplicationNo = '';

        if (isset($_REQUEST["user_cat"]) && ($_REQUEST["user_cat"] == '1' || $_REQUEST["user_cat"]=='3' || $_REQUEST["user_cat"]=='5'))
        {
            $vApplicationNo = $_REQUEST["vApplicationNo"];
        }else if (isset($_REQUEST["uvApplicationNo"]))
        {
            $vApplicationNo = $_REQUEST["uvApplicationNo"];
        }
        
	    $mysqli = link_connect_db();
        
        $stmt = $mysqli->prepare("UPDATE prog_choice SET
        iprnltr = iprnltr + 1 
        WHERE vApplicationNo = ?");
        $stmt->bind_param("s", $vApplicationNo);
        $stmt->execute();
        $stmt->close();
        log_actv('submitted application form');
	
        $stmt = $mysqli->prepare("SELECT vFirstName, vObtQualTitle, vProgrammeDesc, a.iBeginLevel, e.cProgrammeId, e.cdeptId 
        FROM prog_choice a, programme e, obtainablequal f
        WHERE a.cProgrammeId = e.cProgrammeId 
        AND e.cObtQualId = f. cObtQualId 
        AND vApplicationNo = ?");
        $stmt->bind_param("s", $vApplicationNo);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($my_name, $vObtQualTitle_db, $vProgrammeDesc_db, $iBeginLevel_db, $cProgrammeId, $cdeptId);
        $stmt->fetch();
        $stmt->close();
        
        if (is_null($cProgrammeId))
        {
            $cProgrammeId = '';
            $vProgrammeDesc_db = '';
            $cdeptId = '';
        }?>
        <div class="appl_container">
            <?php //left_conttent('Pay for application form for admission');?> 
            
            <div id="right_div" class="appl_right_div" style="font-size:1em;">
                <div class="appl_left_child_div" style="text-align: left; margin:auto; max-height:95%; margin-top:5px; background-color: #eff5f0;">
                    <div id="pinfo" class="appl_left_child_div_child" style="flex-flow: column; margin-top:10px;">
                        <div class="appl_left_child_div_child" style="justify-content:center;">
                            <div class="adm_slip_cls" style="padding:10px; height:auto; text-align:center; background-color: #ffffff">
                                <img width="80px" height="92px" src="data:image/jpg;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG."left_side_logo.png");?>" alt="NOUN Logo"><br>
                                National Open University of Nigeria<br><?php
                                if (!is_bool(strpos($cProgrammeId, "CHD")))
                                {
                                    if ($cdeptId == 'PCC')
                                    {
                                        echo 'Centre For Human Resource Development (CHRD) in Collaboration with Supernannies Nigeria Ltd (SNL)<br>';
                                    }else if ($cdeptId == 'ACL')
                                    {
                                        echo 'Centre For Human Resource Development (CHRD) in Collaboration with Auto Clinic Centre<br>';
                                    }
                                }else if (!is_bool(strpos($cProgrammeId, "DEG")))
                                {
                                    echo 'Directorate for Entrepreneurship and General Studies<br>';
                                }?>
                                <?php echo $vProgrammeDesc_db;?> <p>
                                Admission Slip
                            </div>
                        </div> 
                        <div class="appl_left_child_div_child" style="justify-content:center;">
                            <div class="adm_slip_cls" style="padding:10px; height:auto; background-color: #ffffff">
                                Dear <?php echo $my_name;?>,<p>
                                Congratulations! <p>
                                We are pleased to inform you that your application for the <?php echo $vObtQualTitle_db.' '.$vProgrammeDesc_db;?> at the National Open University of Nigeria has been successful.<p>

                                The program calendar, including start date, end date, registration, quiz, and any additional instructions, will be communicated accordingly.<p>

                                We look forward to welcoming you to our academic community.<p>

                                Best regards,<p>

                                Registrar<br>
                                National Open University of Nigeria
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</body>
</html>