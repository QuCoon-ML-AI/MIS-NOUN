<script language="JavaScript" type="text/javascript">
    function chk_election_of_subject_list()
	{
        var cnt_clection = 0;
        for (var cnt = 1; cnt <= 10; cnt++)
        {
            var chk_name = "subject_chk"+cnt;
            var sbj_desc_name = "subject_desc"+cnt;
            var grd_name = "grade"+cnt;

            if (_(chk_name).checked)
            {
                cnt_clection++;

                //alert(_(chk_name).value+', '+_(sbj_desc_name).value+', '+_(grd_name).value)
            }
        }

        if (cnt_clection == 0)
        {
            caution_inform('No sbject selected')
        }
        
        _("subject_list").style.zIndex = -1;
        _("subject_list").style.display = 'none';

        _("smke_screen_3").style.zIndex = -1;
        _("smke_screen_3").style.display = 'none';
        
        _("subject_list_btn_div").style.display = 'block';
    }
</script><?php 
if ((isset($_REQUEST["ope_mode"]) && ($_REQUEST["ope_mode"] == 'e' || $_REQUEST["ope_mode"] == 'a')) && (isset($_REQUEST["cQualCodeId"]) && ($_REQUEST["cQualCodeId"] == '201' || $_REQUEST["cQualCodeId"] == '202' || $_REQUEST["cQualCodeId"] == '203' || $_REQUEST["cQualCodeId"] == '204' || $_REQUEST["cQualCodeId"] == '207')))
{?>
    <div id="smke_screen_3" class="smoke_scrn" style="z-index:2;"></div>

    <div id="subject_list" class="center top_most" 
        style="text-align:center; 
        padding:10px; 
        box-shadow: 2px 2px 8px 2px #726e41; 
        background:#FFFFFF;
        display:none">
        <div style="width:90%; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
            Subject list
        </div>

        <div style="width:20px; float:left; text-align:center; padding:0px;">
            <a href="#"
                onclick="_('subject_list').style.display = 'none';
                _('subject_list').style.zIndex = -1;
                _('smke_screen_3').style.display = 'none';
                _('smke_screen_3').style.zIndex = -1;
                return false" 
                style="color:#666666; margin-right:3px; text-decoration:none;text-shadow: 0 1px 0 #fafafa; position:absolute; top:10px; right:10px;">
                    <img style="width:15px; height:15px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" />
                </a>
        </div>
        <div id="conf_msg_msg_loc" style="height:auto; margin-top:10px; width:100%; float:left; text-align:center; padding:0px;">
            <div id="exam_id" style="float:left; width:100%; line-height:2.5; text-align:left;">
            </div>

            <div style="float:left; width:99%; padding-left:1%; line-height:2; text-align:left; background-color: #fdf0bf">
                Select applicable subjects and click the ok button. If no subject is selected, click the close button (top right)
            </div>
        
            <div style="float:left; width:9%; line-height:2.5; font-weight:bold; text-align:right; padding-right:1%;">Sno</div>
            <div style="float:left; width:10%; line-height:2.5; font-weight:bold; color:#fff; margin-left:0.5%;">.</div>
            <div style="float:left; width:65.2%; line-height:2.5; font-weight:bold; margin-left:0.5%; text-align:left;">Subject</div>
            <div style="float:left; width:13%; line-height:2.5; font-weight:bold; margin-left:0.5%;">Grade</div><?php
            $background = '';
            for ($i = 1; $i <= 10; $i++)
            {
                if ($i%2>0)
                {
                    $background = 'background-color: #ebebeb;';
                }else
                {
                    $background = '';
                } ?>
                <label for="subject_chk<?php echo $i;?>">
                    <div style="float:left; width:9%; line-height:2.5; <?php echo $background;?> text-align:right; padding-right:1%;"><?php echo $i;?></div>
                    <div style="float:left; width:10%; line-height:2.5; <?php echo $background;?> margin-left:0.5%;">
                        <input type="checkbox" name="subject_chk<?php echo $i;?>" id="subject_chk<?php echo $i;?>" value="<?php echo 'subject_chk'.$i;?>">
                    </div>
                    <div style="float:left; width:64.2%; line-height:2.5; <?php echo $background;?> margin-left:0.5%; padding-left:1%; text-align:left;">
                        <?php echo 'subject_desc'.$i;?>
                        <input type="hidden" name="subject_desc<?php echo $i;?>" id="subject_desc<?php echo $i;?>" value="<?php echo 'subject_desc'.$i;?>">
                    </div>
                    <div style="float:left; width:13%; line-height:2.5; <?php echo $background;?> margin-left:0.5%;">
                        <?php echo 'grade'.$i;?>
                        <input type="hidden" name="grade<?php echo $i;?>" id="grade<?php echo $i;?>" value="<?php echo 'grade'.$i;?>">
                    </div>
                </label><?php
            }?>
        </div>
        <div style="margin-top:10px; width:90%; float:right; text-align:right; padding:0px;">
            <a href="#" style="text-decoration:none;" 
                onclick="chk_election_of_subject_list();
                ps.conf.value='1';
                /*set_rec_mgt_btn();
                in_progress('1');
                ps.submit();*/
                return false">
                <div class="login_button" style="width:60px; padding:6px; margin-left:10px; float:right">
                    Ok
                </div>
            </a>
        </div>
    </div><?php
}?>