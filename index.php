<?php
// Date in the past

/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('./appl/const_def.php');
require_once('../fsher/fisher.php');
require_once('./appl/lib_fn.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="/appl/img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="./appl/js_file_1.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="./appl/styless.css" />
        <!-- <link rel="stylesheet" type="text/css" media="all" href="./bamboo/styless0.css" /> -->
        <style>
            #logo_pix
            {
                width:120px; 
                height:130;
            }

            .button_container
            {
                /* margin: 10vh auto; */
                height:auto; 
                display:flex; 
                flex-flow: column nowrap;
                /* margin:20px auto; */
                width:25vw;
                font-size:1.1em;
            }

            .button_container > div, .child2_div > div
            {
                width: 96%;
                margin: 1.3% auto;
                height:auto; 
                padding:0px;
                text-align: center;
                background-color: #FFFFFF;
            }

            .ind_button
            {
                border: none;
                color: black;
                width:100%;
                text-align: left;
                text-decoration: none;
                background-color: #FFFFFF;
                font-size: 0.9em;
                cursor: pointer;
                border-top:0px solid #b6b6b6;
                height:60px; 
                padding:0px; 
                display:flex; 
                flex-flow:row; 
                justify-content:flex-start; 
                text-indent:0px;

                box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;

                /*box-shadow: rgba(0, 0, 0, 0.15) 0px 15px 25px, rgba(0, 0, 0, 0.05) 0px 5px 0px;*/
                
                /* box-shadow: 2px 2px 5px #afafaf; */
                /*box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;*/ 
                /*box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;*/
            }

            .ind_button:hover 
            {
                color: #eb0c27;
                box-shadow: 2px 2px 2px #afafaf;
            }

            .ind_button:active 
            {
                box-shadow: none;
            }
        

            .ind_button_ma
            {
                border: none;
                color: black;
                flex:50%;
                padding:0px;
                text-align: center;
                text-decoration: none;
                background-color: #6cee80;
                border:1px solid #b6b6b6;
                font-size: 0.9em;
                cursor: pointer;
            }

            #noun_font_div
            {
                font-size:20px;
            }

            @media screen and (max-width: 800px) 
            {
                #logo_pix
                {
                    width:48px; 
                    height:70;
                }

                .button_container
                {
                    width:90vw;
                    margin:auto;
                    max-height:95vh;
                    overflow: auto;
                }

                #noun_font_div
                {
                    font-size:18px;
                }
            }
        </style>
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
        date_default_timezone_set('Africa/Lagos');
        $current_date = date("Y-m-d");
        
        $count = 0;
        
	    $mysqli = link_connect_db();
        $stmt = $mysqli->prepare("SELECT msg_subject, msg_body, sender_signature, date1, act_time
        FROM student_notice_board WHERE msg_loc = 1 AND cshow = '1' AND date1 >= '$current_date' ORDER BY act_time DESC");
        $stmt->execute();
        $stmt->store_result();
        $there_is_msg = $stmt->num_rows;
        if ($there_is_msg > 0)
        {
            $stmt->bind_result($msg_subject, $msg_body, $sender_signature, $date1, $act_time);?>
            <div id="smke_screen" class="smoke_scrn" style="opacity:0.9;"></div>
            <div id="container_cover_in_chkps" class="center" 
                style="display: flex;
                z-index:2;
                flex-direction:column; 
                gap:5px;  
                justify-content:space-around; 
                max-height:60vh;
                padding:10px;
                box-shadow: 2px 2px 8px 2px #726e41;            
                background-color:#fff;
                opacity:0.9;" title="Press escape to close">
                    <div style="line-height:1.5; width:70%; font-weight:bold">
                        Notice board
                    </div>
                    <div style="height:auto; top:10px; right:10px; max-height:68vh; overflow:auto; overflow-x: hidden">
                        <div style="line-height:1.5; width:20; position:absolute; top:10px; right:10px;">
                            <img style="width:17px; height:17px; cursor:pointer" src="data:image/jpg;base64,<?php echo c_image(BASE_FILE_FOR_INDEX_IMG.'close.png');?>" 
                            onclick="_('container_cover_in_chkps').style.zIndex = -1;
                                _('container_cover_in_chkps').style.display = 'none';
                                _('smke_screen').style.zIndex = -1;
                                _('smke_screen').style.display = 'none';"/>
                        </div><?php
                        while($stmt->fetch())
                        {?>
                            <div style="line-height:1.4; padding:8px 0px 8px 8px; width:99%; background-color: #fdf0bf; margin-top:5px">
                                <?php echo $msg_subject;?>
                            </div> 
                            
                            <div style="line-height:1.5; margin-top:10px; text-align:right;">
                                <?php echo formatdate($act_time, 'fromdb').' '.substr($act_time, 11,strlen($act_time)-1);?>
                            </div>

                            <div style="line-height:2; margin-top:10px; text-align:justify;">
                                <?php echo nl2br($msg_body);?>
                            </div>
                            <div style="line-height:1.5; height:43px; margin-top:10px;">
                                <?php echo $sender_signature;?>
                            </div><?php
                            $count++;
                        }?>
                    </div>
            </div><?php
        }

        include(BASE_FILE_FOR_INDEX."feedback_mesages.php");
        
        if (isset($_REQUEST["logout"]) && $_REQUEST["logout"] == '1')
        {
            clean_up();   
        }?>
        
        <form method="post" name="ps" enctype="multipart/form-data" onsubmit="chk_inputs(); return false">
			<input name="ilin" type="hidden" value="" />
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];} ?>" />
            <div class="button_container center">
                <div style="margin-top:0px; margin-bottom:-2px; border-bottom:none; padding-bottom:0px">                    
                    <img id="logo_pix" src="data:image/jpg;base64,<?php echo c_image(BASE_FILE_FOR_INDEX_IMG.'left_side_logo.png');?>" />
                </div>
                <div style="margin-top:10px; line-height:1.4; padding:0px; border-top:none;">
                    <font id="noun_font_div" style="font-weight:bold;color:#249865;">National Open University of Nigeria</font><br>
                    <font style="font-weight:normal; font-size:13xp;">Application and Student Management System</font>
                </div><?php 
                if ($count > 0)
                {?>
                    <div>
                        <a href="#" target="_self" style="text-decoration:none;" 
                            onclick="_('container_cover_in_chkps').style.zIndex = 3;
                            _('container_cover_in_chkps').style.display = 'flex';
                            _('smke_screen').style.zIndex = 3;
                            _('smke_screen').style.display = 'block';
                            return false"> 
                            <div id="ann_div" class="ind_button">
                                <div style="float:left; height:100%; flex:20%;  text-indent:0px;
                                background-image: url('data:image/jpg;base64,<?php echo c_image(BASE_FILE_FOR_INDEX_IMG.'anouncement.png');?>');
                                background-position:center center;
                                background-size: 34px 30px;
                                background-repeat:no-repeat;">
                                </div>
                                <div style="float:left; height:100%; flex:80%; line-height:4.8;">
                                    Announcement
                                </div>
                            </div>
                        </a>
                    </div><?php
                }?>

                <div>
                    <a href="#" target="_self" style="text-decoration:none;" 
                        onclick="ps.action='<?php echo BASE_FILE_FOR_INDEX;?>guides-instructions';
                        ps.target='_blank';
                        ps.submit();
                        return false">
                        <div class="ind_button">
                            <div style="height:100%; flex:20%; 
                            text-indent:0px; 
                            background-image: url('data:image/jpg;base64,<?php echo c_image(BASE_FILE_FOR_INDEX_IMG.'help2.png');?>');
                            background-position:center center;
                            background-size: 22px 30px;
                            background-repeat:no-repeat;">
                            </div>
                            <div style="height:100%; flex:60%; line-height:4.8;">
                                How to do things
                            </div>
                            <div style="height:100%; flex:20%; 
                            text-indent:0px; 
                            background-image: url('data:image/jpg;base64,<?php echo c_image(BASE_FILE_FOR_INDEX_IMG.'play.png');?>');
                            background-position:center center;
                            background-size: 30px 30px;
                            background-repeat:no-repeat;">
                            </div>
                        </div>
                    </a>
                </div>

                <div>
                    <a href="#" target="_self" style="text-decoration:none;" 
                        onclick="if(_('adm_menu').style.display=='none'){_('adm_menu').style.display='block';}else{_('adm_menu').style.display='none';}">
                        <div class="ind_button">
                            <div style="float:left; height:100%; flex:20%; text-indent:0px; 
                            background-image: url('data:image/jpg;base64,<?php echo c_image(BASE_FILE_FOR_INDEX_IMG.'admission.png');?>');
                            background-position:center center;
                            background-size: 29px 30px;
                            background-repeat:no-repeat;">
                            </div>
                            <div style="float:left; height:100%; width:75%; line-height:4.8;">
                                Admission
                            </div>
                            <div style="float:left; height:100%; width:5%;">
                                <img style="float:right; width:13px; height:10px; margin-right:40px; margin-top:25px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_FOR_INDEX_IMG.'submenu.png');?>" alt="Submenu">
                            </div>
                        </div>
                    </a>
                </div>
                
                <div id="adm_menu" class="child2_div" style="width:94%; display:none; border:1px; background: #ebeeea; margin-bottom:0px; margin-top:-8px; padding:4px; padding-top:0px;">
                    <div>
                        <a href="#" target="_self" style="text-decoration:none;" 
                            onclick="ps.action='<?php echo BASE_FILE_FOR_INDEX;?>check-qualification';
                            ps.target='_self';
                            ps.submit();
                            return false"> 
                            <div class="ind_button">
                                <div style="float:left; height:100%; flex:20%;  text-indent:0px;
                                    background-image: url('data:image/jpg;base64,<?php echo c_image(BASE_FILE_FOR_INDEX_IMG.'help1.png');?>');
                                    background-position:center center;
                                    background-size: 20px 27px;
                                    background-repeat:no-repeat;">
                                </div>
                                <div style="float:left; height:100%; flex:80%; line-height:4.8;">
                                    Am I qualified
                                </div>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="#" target="_self" style="text-decoration:none;" 
                            onclick="ps.action='<?php echo BASE_FILE_FOR_INDEX;?>pay-for-application-form';
                            ps.user_cat.value='1';
                            ps.target='_self';
                            ps.submit();
                            return false"> 
                            <div class="ind_button">
                                <div style="float:left; height:100%; flex:20%;  text-indent:0px;
                                    background-image: url('data:image/jpg;base64,<?php echo c_image(BASE_FILE_FOR_INDEX_IMG.'appy_for_admission.png');?>');
                                    background-position:center center;
                                    background-size: 25px 27px;
                                    background-repeat:no-repeat;">
                                </div>
                                <div style="float:left; height:100%; flex:80%; line-height:4.8;">
                                    Apply for admission
                                </div>
                            </div>
                        </a>
                    </div>

                    <div title="For incomplete payment transaction only">
                        <a href="#" target="_self" style="text-decoration:none;"
                            onclick="ps.action='<?php echo BASE_FILE_FOR_INDEX;?>confirm-payment';
                            ps.user_cat.value='2';
                            ps.target='_self';
                            ps.submit();
                            return false"> 
                            <div class="ind_button">
                                <div style="float:left; height:100%; flex:20%;  text-indent:0px;
                                    background-image: url('data:image/jpg;base64,<?php echo c_image(BASE_FILE_FOR_INDEX_IMG.'cont.png');?>');
                                    background-position:center center;
                                    background-size: 27px 27px;
                                    background-repeat:no-repeat;">
                                </div>
                                <div style="float:left; height:100%; flex:80%; line-height:4.8;">
                                    Conclude hanging payment
                                </div>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="#" target="_self" style="text-decoration:none;"
                            onclick="ps.action='<?php echo BASE_FILE_FOR_INDEX;?>applicant_login_page';
                            ps.user_cat.value='3';
                            ps.target='_self';
                            ps.submit();
                            return false"> 
                            <div class="ind_button">
                                <div style="float:left; height:100%; flex:20%;  text-indent:0px;
                                    background-image: url('data:image/jpg;base64,<?php echo c_image(BASE_FILE_FOR_INDEX_IMG.'return_to.png');?>');
                                    background-position:center center;
                                    background-size: 27px 27px;
                                    background-repeat:no-repeat;">
                                </div>
                                <div style="float:left; height:100%; flex:80%; line-height:4.8;">
                                    Return to application form
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div>
                    <a href="#" target="_self" style="text-decoration:none;"
                            onclick="ps.action='./rs/student_reset_password';
                            ps.user_cat.value='4';
                            ps.target='_self';
                            ps.submit();
                            return false"> 
                        <div class="ind_button">
                            <div style="float:left; height:100%; flex:20%;  text-indent:0px; 
                            background-image: url('data:image/jpg;base64,<?php echo c_image(BASE_FILE_FOR_INDEX_IMG.'fresh_student.png');?>');
                            background-position:center center;
                            background-size: 29px 30px;
                            background-repeat:no-repeat;">
                            </div>
                            <div style="float:left; height:100%; flex:80%; line-height:4.8;">
                                Fresh student
                            </div>
                        </div>
                    </a>
                </div>
                
                <div>
                    <a href="#" target="_self" style="text-decoration:none;"
                            onclick="ps.action='./rs/student_login_page';
                            ps.user_cat.value='5';
                            ps.target='_self';
                            ps.submit();
                            return false"> 
                        <div class="ind_button">
                            <div style="float:left; height:100%; flex:20%;  text-indent:0px; 
                            background-image: url('data:image/jpg;base64,<?php echo c_image(BASE_FILE_FOR_INDEX_IMG.'reg_student.png');?>');
                            background-position:center center;
                            background-size: 29px 25px;
                            background-repeat:no-repeat;">
                            </div>
                            <div style="float:left; height:100%; flex:80%; line-height:4.8;">
                                Registered student
                            </div>
                        </div>
                    </a>
                </div>
                
                <div>
                    <a href="https://support.nou.edu.ng/" target="_blank" style="text-decoration:none;"> 
                        <div class="ind_button">
                            <div style="float:left; height:100%; flex:20%;  text-indent:0px;
                            background-image: url('data:image/jpg;base64,<?php echo c_image(BASE_FILE_FOR_INDEX_IMG.'support.png');?>');
                            background-position:center center;
                            background-size: 29px 30px;
                            background-repeat:no-repeat;">
                            </div>
                            <div style="float:left; height:100%; flex:80%; line-height:4.8;">
                                Support
                            </div>
                        </div>
                    </a>
                </div>
                
                <div>
                    <a href="#" target="_self" style="text-decoration:none;" 
                        onclick="ps.user_cat.value='6';
                        ps.action='./admin/staff_login_page';
                        ps.target='_self';
                        ps.submit();
                        return false"> 
                        <div class="ind_button">
                            <div style="float:left; height:100%; flex:20%;  text-indent:0px;
                            background-image: url('data:image/jpg;base64,<?php echo c_image(BASE_FILE_FOR_INDEX_IMG.'staff.png');?>');
                            background-position:center center;
                            background-size: 31px 23px;
                            background-repeat:no-repeat;">
                            </div>
                            <div style="float:left; height:100%; flex:80%; line-height:4.8;">
                                Staff
                            </div>
                        </div>
                    </a>
                </div>

                <div style="margin-bottom:10px; padding:10px 0px 0px 0px">
                    NOUN eLink
                </div>
                <div style="display:flex; justify-content:center; flex-direction:row; height:auto; gap:10px; margin:auto;">
                    <a href="https://play.google.com/store/apps/details?id=com.intradot.nounnigeria" target="_blank" style="text-decoration:none;"> 
                        <div>
                            <img width="105" height="30" src="data:image/jpg;base64,<?php echo c_image(BASE_FILE_FOR_INDEX_IMG.'google_store.png');?>" alt="google play store"/>
                        </div>
                    </a>
                    
                    <a href="https://apps.apple.com/ng/app/noun-official/id6446352205" target="_blank" style="text-decoration:none;"> 
                        <div>
                            <img width="105" height="30" src="data:image/jpg;base64,<?php echo c_image(BASE_FILE_FOR_INDEX_IMG.'apple_store.png');?>" alt="apple store"/>
                        </div>
                    </a>
                </div>
            </div>
        </form>
	</body>
</html>