<div class="innercont_stff_tabs" id="ans1" 
    style="display:<?php if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '1'){?>block<?php }else{?>none<?php }?>; 
        height:450px; 
        border:0px;">
    <div class="innercont_stff" style="padding-top:5px">
        <label for="schl_session" class="labell" style="width:160px; margin-left:7px;">Session</label><?php $sessn_date = substr($orgsetins['cAcademicDesc'],0,4);?>

        <div class="div_select">
            <select id="schl_session" name="schl_session" class="select">
                <option value="All">All</option><?php
                for ($y = 2018; $y <= $sessn_date+1; $y++)
                {
                    $sessn = $y."/".($y+1);
                    if ($y%5==0)
                    {?>
                        <option disabled></option><?php
                    }?>
                    <option value="<?php echo $sessn; ?>" <?php if (isset($_REQUEST["schl_session"]) && $_REQUEST["schl_session"] == $sessn){echo ' selected';}?>>
                        <?php echo $sessn; ?>
                    </option><?php
                }?>
            </select>
        </div>
        <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
    </div>

    <div class="innercont_stff" style="padding-top:5px; height:auto;">
        <input id="std_cat" name="std_cat" type="hidden" value="<?php if (isset($_REQUEST["std_cat"])){echo $_REQUEST["std_cat"];}?>">

        <label class="labell" style="width:160px; margin-left:7px;">Category of subject</label>
        <div class="div_select" style="height:auto; padding:3px; padding-left:0px;">
            <div style="float:left; width:100%; padding-left:0px">
                <input id="std_cat1" name="std_cat" type="radio" value="a"
                    onClick="_('qry_type1').checked=false;
                    _('qry_type2').checked=false;
                    _('qry_type3').checked=false;
                    _('qry_type3').disabled=true;"
                    <?php if (isset($_REQUEST['std_cat']) && $_REQUEST['std_cat'] == 'a'){echo ' checked';}?>>
                <label for="std_cat1" style="width:auto;">Applicants</label>
            </div>

            <div style="float:left; width:100%; margin-top:5px; padding-left:0px">
                <input id="std_cat2" name="std_cat" type="radio" value="b"
                    onClick="_('qry_type1').checked=false;
                    _('qry_type2').checked=false;
                    _('qry_type3').checked=false;
                    _('qry_type3').disabled=false;" 
                    <?php if (isset($_REQUEST['std_cat']) && $_REQUEST['std_cat'] == 'b'){echo ' checked';}?>>
                <label for="std_cat2" style="width:auto;">Admission status</label>
            </div>

            <div style="float:left; width:100%; margin-top:5px; padding-left:0px">
                <input id="std_cat3" name="std_cat" type="radio" value="c"
                    onClick="_('qry_type1').checked=false;
                    _('qry_type2').checked=false;
                    _('qry_type3').checked=false;
                    _('qry_type3').disabled=true;" 
                    <?php if (isset($_REQUEST['std_cat']) && $_REQUEST['std_cat'] == 'c'){echo ' checked';}?>>
                <label for="std_cat3" style="width:auto;">Registered students</label>
            </div>
        </div>        
        <div id="labell_msg2" class="labell_msg blink_text orange_msg"></div>
    </div>

    <div class="succ_box blue_msg" style="display:block; margin-top:15px; line-height:1.5">
        Selecting 'Distributions' will disable the boxes under 'Identity Columns' in step 2
    </div>

    <div class="innercont_stff" style="height:auto; padding-top:5px">
        <label class="labell" style="width:160px; margin-left:7px;">Type of report</label>
        <div class="div_select" style="height:auto; padding:3px; padding-left:0px;">
            <div style="float:left; width:100%; padding-left:0px">
                <input id="qry_type1" name="qry_type" type="radio" value="1"
                    onClick="set_other_chkboxes(this,'col','0','20-26');
                    if(_('col12').checked){set_other_chkboxes(this,'col','0','1-11');
                    set_other_chkboxes(this,'col','0','13-26');}else
                    if(_('col15').checked){set_other_chkboxes(this,'col','0','1-14');
                    set_other_chkboxes(this,'col','0','16-26');}else
                    if(_('col18').checked){set_other_chkboxes(this,'col','0','1-17');
                    set_other_chkboxes(this,'col','0','19-26');}
                    set_other_chkboxes(this,'srt','0','16-22');
                    set_other_chkboxes(this,'srt','0','23');
                    _('hdqry_type').value=this.value;
                    set_suppl();"
                    <?php if (isset($_REQUEST['hdqry_type']) && $_REQUEST['hdqry_type'] == '1'){echo ' checked';}?>>
                <label for="qry_type1" style="width:auto;">Distributions</label>
            </div>

            <div style="float:left; width:100%; margin-top:5px; padding-left:0px">
                <input id="qry_type2" name="qry_type" type="radio" value="2"
                    onClick="set_other_chkboxes(this,'col','1','20-26');
                    if(_('col12').checked){set_other_chkboxes(this,'col','1','1-11');
                    set_other_chkboxes(this,'col','1','13-26');}else
                    if(_('col15').checked){set_other_chkboxes(this,'col','1','1-14');
                    set_other_chkboxes(this,'col','1','16-26');}else
                    if(_('col18').checked){set_other_chkboxes(this,'col','1','1-17');
                    set_other_chkboxes(this,'col','1','19-26');}
                    set_other_chkboxes(this,'srt','1','16-22');
                    set_other_chkboxes(this,'srt','1','23');
                    set_suppl()" 
                    <?php if (isset($_REQUEST['hdqry_type']) && $_REQUEST['hdqry_type'] == '2'){echo ' checked';}?>>
                <label for="qry_type2" style="width:auto;">A list</label>
            </div>
        </div>
    </div>

    <div class="innercont_stff" style="padding-top:5px; height:auto;">
        <label for="corect" class="labell" style="width:160px; margin-left:7px;"></label>
        <div class="div_select" style="height:auto; padding:3px; padding-left:0px;">
            <div style="float:left; width:100%; padding-left:0px">
                <input id="qry_type3" name="qry_type" type="radio" value="3"
                    onClick="set_suppl();" 
                    <?php if (isset($_REQUEST['hdqry_type']) && $_REQUEST['hdqry_type'] == '3'){echo ' checked';}
                    if (isset($_REQUEST['std_cat']) && $_REQUEST['std_cat'] <> 'b'){echo ' disabled';}?>>
                <label for="qry_type3" style="width:auto;">A matriculation list</label>
            </div>

            <!-- <div style="float:left; width:100%; margin-top:5px; padding-left:0px">
                <input type="checkbox" id="suppl_lst" name="suppl_lst" value="1"
                    onClick="set_hds(this,hdsuppl_lst,'chk');
                    if (this.checked){hdsuppl_lst.value=this.value}else{hdsuppl_lst.value=''}"
                    <?php if (!isset($_REQUEST['hdqry_type']) || isset($_REQUEST['hdqry_type']) && $_REQUEST['hdqry_type'] <> '4'){echo ' disabled';}
                    if (isset($_REQUEST['hdsuppl_lst']) && $_REQUEST['hdsuppl_lst'] == 1){echo ' checked';}?>>
                <label for="suppl_lst" style="width:auto;">Supplementary list</label>
            </div>

            <div style="float:left; width:100%; margin-top:5px; padding-left:0px">
                <input type="checkbox" id="xtra_col" name="xtra_col" value="1" 
                    onClick="set_hds(this,hdxtra_col,'chk');
                    if(this.checked)
                    {
                        hdcol_name.value=rpts1_loc.col_name.value;
                        rpts1_loc.col_name.disabled=false;
                        rpts1_loc.col_width.disabled=false;
                        hdxtra_col.value=this.value;
                        
                    }else
                    {
                        hdcol_name.value='';
                        rpts1_loc.col_name.disabled=true;
                        rpts1_loc.col_width.disabled=true;
                        hdxtra_col.value='';
                    }"<?php 
                    if (isset($_REQUEST['hdxtra_col']) && $_REQUEST['hdxtra_col'] == '1'){echo 'checked';} 
                    if (!isset($_REQUEST['hdqry_type']) || (isset($_REQUEST['hdqry_type']) && $_REQUEST['hdqry_type'] <> '3' && $_REQUEST['hdqry_type'] <> '4')){echo ' disabled';}?>>
                <label for="xtra_col" style="width:auto;">Add extra column</label>
            </div>

            <div style="float:left; width:100%; margin-top:10px; padding-left:5px;">
                <input type="text" name="col_name" id="col_name"
                    style="padding:4px; width:93.5%"
                    placeholder="Enter column label"
                    onClick="set_hds(this,hdcol_name);
                    if (this.checked){hdxtra_col.value=this.value}else{hdxtra_col.value=''}"
                    value="<?php if (isset($_REQUEST['hdcol_name']) && $_REQUEST['hdcol_name'] <> ''){echo $_REQUEST['hdcol_name'];}?>"                                
                    <?php if (!isset($_REQUEST['hdqry_type']) || (isset($_REQUEST['hdqry_type']) && $_REQUEST['hdqry_type'] <> '3' && $_REQUEST['hdqry_type'] <> '4')){echo ' disabled';}?>>
            </div>

            <div style="float:left; width:100%; margin-top:5px; padding-left:5px; margin-top:5px">
                <label for="col_width" class="labell">Increase column width by</label>
                <select name="col_width" onChange="hdcol_width.value=this.value" style="padding:4px; float:right; margin-right:7px"
                    <?php if (isset($_REQUEST['hdxtra_col']) && $_REQUEST['hdxtra_col'] == '1'){echo 'value="'.$_REQUEST['hdcol_name'].'"';}
                    else{echo 'disabled ';echo 'value="Enter column label"';}?>>
                    <option value = "0" selected>0 </option><?php
                    for ($t = 10; $t <= 50; $t+=5)
                    {?>
                        <option value="<?php echo $t ?>" <?php 
                            if (isset($_REQUEST['hdcol_width']) && $_REQUEST['hdcol_width'] == $t){echo ' selected';}?>>
                            <?php echo $t ?>
                        </option><?php
                    }?>
                </select>
            </div> -->
        </div>
    </div>
</div>