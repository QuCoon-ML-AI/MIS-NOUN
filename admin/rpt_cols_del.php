<div class="innercont_stff" id="ans2" 
    style="display:<?php if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '2'){?>block<?php }else{?>none<?php }?>; 
    height:auto;
    width:100%;
    margin-top:0%;
    padding:0%; 
    border:0px solid #000;">
    <div class="innercont_stff" style="width:99.9%; margin-top:0px; padding:0%; border:0px solid #000;">
        <a href="#" style="text-decoration:none;" 
            onclick="unchkAll('ans2'); return false">
            <div class="submit_button_green" 
                style="margin-left:0px;
                padding:5px;
                float:left;
                font-size: 0.9em;
                width:auto">
                Clear all boxes
            </div>
        </a>

        <!-- <a href="#" style="text-decoration:none;" 
            onclick="if(_('ans2_1').style.display=='block')
            {
                _('ans2_1').style.display='none';
                _('ans2_2').style.display='block';
                _('add_qual_div').innerHTML = 'Select column';
                _('whc_lnk').value='ad';
                _('sub_box').style.display='block';
                _('sub_box_0').style.display='none';
                //validate('2','ad');
            }else
            {
                _('ans2_1').style.display='block';
                _('ans2_2').style.display='none';
                _('add_qual_div').innerHTML = 'Age distribution';
                _('whc_lnk').value='sf'
                _('sub_box').style.display='none';
                _('sub_box_0').style.display='block';
                //validate('2','sf');
            }
            return false">
            <div id="add_qual_div" class="submit_button_green" 
                style="margin:0px;
                padding:4px; 
                width:90px; 
                float:right; 
                font-size:0.9em;">Age distribution</div>
        </a> -->
    </div>



    <div class="innercont_stff" id="ans2_1" 
        style="display:block; height:auto; margin-top:5px; width:100%;">
        <div class="innercont_stff" 
            style="width:48.3%; 
            float:left; 
            height:auto; 
            padding:0.5%; 
            border:1px solid #CCCCCC; 
            background:#E6E6E6">
            General columns
        </div>
        <div class="innercont_stff" 
            style="width:48.3%; 
            float:right; 
            height:auto; 
            padding:0.5%; 
            border:1px solid #CCCCCC; 
            background:#E6E6E6">
            Identity Columns
        </div>
        
        <ul class="checklist" style="float:left; width:49.45%; overflow:scroll; overflow-x: hidden; height:518px">
            <li style="margin:0%">
                <label class="lbl_beh" for="col1">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">1</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="col1" name="col1" value="a"
                            <?php if (isset($_REQUEST['col1'])){echo 'checked';}?> 
                            onClick="if(this.checked){_('col12').disabled=false;}else{_('col12').disabled=true;}
                            set_other_chkboxes(this,'col','','19');
                            set_other_chkboxes(this,'srt','','1');
                            compose_sel(this,'col')" />
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Study Centre
                    </div>	
                </label>
            </li>
            <li>
                <label class="lbl_beh" for="col2">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">2</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="col2" name="col2" value="b"
                        <?php if (isset($_REQUEST['col2'])){echo 'checked';}?>  
                        onClick="set_other_chkboxes(this,'col','','9');
                        set_other_chkboxes(this,'srt','','2');
                        compose_sel(this,'col')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Faculty
                    </div>							
                </label>
            </li>
            
            <li>
                <label class="lbl_beh" for="col3">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">3</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="col3" name="col3" value="c" 
                        <?php if (isset($_REQUEST['col3'])){echo 'checked';}?> 
                        onClick="set_other_chkboxes(this,'srt','','3');
                        compose_sel(this,'col')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Department
                    </div>							
                </label>
            </li>
            
            <li>
                <label class="lbl_beh" for="col4">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">4</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="col4" name="col4" value="d"
                        <?php if (isset($_REQUEST['col4'])){echo 'checked';}?>  
                        onClick="set_other_chkboxes(this,'srt','','4');
                        set_other_chkboxes(this,'col','','10-11');
                        compose_sel(this,'col')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Programme
                    </div>						
                </label>
            </li>
            
            <li>
                <label class="lbl_beh" for="col5" <?php if (isset($_REQUEST['std_cat'])&&$_REQUEST['std_cat']<>'c'){echo ' title="Only enabled if registered students is selected under type of report"';}?>>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">5</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="col5" name="col5" value="e"
                        <?php if (isset($_REQUEST['col5']) && !(isset($_REQUEST['std_cat'])&&$_REQUEST['std_cat']<>'c')){echo 'checked';} 
                        if (isset($_REQUEST['std_cat'])&&$_REQUEST['std_cat']<>'c'){echo ' disabled';}
                        if (isset($_REQUEST['std_cat'])&&$_REQUEST['std_cat']<>'c'){echo ' title="Only enabled if registered students is selected under type of report"';}?>  
                        onClick="set_other_chkboxes(this,'srt','','5');
                        compose_sel(this,'col')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Course
                    </div>
                </label>
            </li>
            
            <li>
                <label class="lbl_beh" for="col6">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">6</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="col6" name="col6" value="f"
                        <?php if (isset($_REQUEST['col6'])){echo 'checked';}?>  
                        onClick="set_other_chkboxes(this,'srt','','6');
                        compose_sel(this,'col')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Qualification
                    </div>
                </label>
            </li>
            
            <li>
                <label class="lbl_beh" for="col7">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">7</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="col7" name="col7" value="g"
                        <?php if (isset($_REQUEST['col7'])){echo 'checked';}?>  
                        onClick="set_other_chkboxes(this,'srt','','7');
                        compose_sel(this,'col')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Level
                    </div>
                </label>
            </li>
            
            <li>
                <label class="lbl_beh" for="col8">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">8</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="col8" name="col8" value="h"
                        <?php if (isset($_REQUEST['col8'])){echo 'checked';}?>  
                        onClick="set_other_chkboxes(this,'srt','','8');
                        compose_sel(this,'col')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Gender
                    </div>
                </label>
            </li>
            <li></li>
            <li>
                <label class="lbl_beh" for="col9">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">9</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="col9" name="col9" value="i"
                        <?php if (isset($_REQUEST['col2']))
                        {
                            if (isset($_REQUEST['col9']))
                            {
                                echo 'checked';
                            }
                        }else
                        {
                            echo ' disabled="disabled"';    
                        }?> />
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Show faculty name in full
                    </div>
                </label>
            </li>
            <li>
                <label class="lbl_beh" for="col10">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">10</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="col10" name="col10" value="j"
                        <?php if (isset($_REQUEST['col4']))
                        {
                            if (isset($_REQUEST['col10']))
                            {
                                echo 'checked';
                            }
                        }else
                        {
                            echo ' disabled="disabled"';    
                        }?>
                        onClick="if (this.checked){_('col11').checked=false}"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Show qualification and programme description only
                    </div>
                </label>
            </li>	
            <li>
                <label class="lbl_beh" for="col11">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">11</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="col11" name="col11" value="k"
                        <?php if (isset($_REQUEST['col4']))
                        {
                            if (isset($_REQUEST['col11']))
                            {
                                echo 'checked';
                            }
                        }else
                        {
                            echo ' disabled="disabled"';    
                        }?> 
                        onClick="if (this.checked){_('col10').checked=false}"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Show code, qualification and  programme description
                    </div>						
                </label>
            </li>
            <li></li>
            <li>
                <label class="lbl_beh" for="col12">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">12</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="col12" name="col12" value="l" 
                            <?php if (!isset($_REQUEST['col1'])){echo ' disabled';}else if (isset($_REQUEST['col12'])){echo 'checked';}?>
                            onClick="if(_('qry_type1').checked){set_other_chkboxes(this,'col','0','1-11');
                            set_other_chkboxes(this,'col','0','13-26');}
                            if(this.checked&&_('qry_type2').checked)
                            {_('col15').checked=false;_('srt12').checked=false;_('srt12').disabled=true;
                            _('col18').checked=false;_('srt15').checked=false;_('srt15').disabled=true;}
                            set_other_chkboxes(this,'srt','','9');
                            compose_sel(this,'col')" disabled/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Geo-political zone of Study Centre
                    </div>
                </label>
            </li>
            <li>
                <label class="lbl_beh" for="col13">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">13</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="col13" name="col13" value="m" 
                            <?php if (isset($_REQUEST['col13'])){echo 'checked';}?> onClick="set_other_chkboxes(this,'srt','','10');
                        compose_sel(this,'col')" />
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        State of origin
                    </div>
                </label>
            </li>
            <li>
                <label class="lbl_beh" for="col14">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">14</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="col14" name="col14" value="n" 
                            <?php if (isset($_REQUEST['col14'])){echo 'checked';}?> onClick="set_other_chkboxes(this,'srt','','11');
                        compose_sel(this,'col')" />
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        LGA of origin
                    </div>
                </label>
            </li>
            <li>
                <label class="lbl_beh" for="col15">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">15</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="col15" name="col15" value="o" 
                            <?php if (isset($_REQUEST['col15'])){echo 'checked';}?> 
                            onClick="if(_('qry_type1').checked){set_other_chkboxes(this,'col','0','1-14');
                            set_other_chkboxes(this,'col','0','16-26');}
                            if(this.checked&&_('qry_type2').checked){
                            _('col12').checked=false;_('srt9').checked=false;_('srt9').disabled=true;
                            _('col18').checked=false;_('srt15').checked=false;_('srt15').disabled=true;}
                            set_other_chkboxes(this,'srt','','12');
                            compose_sel(this,'col')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Geo-political zone of origin
                    </div>						
                </label>
            </li>
            
            <li>
                <label class="lbl_beh" for="col16">
                <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">16</div>
                <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                    <input type="checkbox" id="col16" name="col16" value="p" 
                        <?php if (isset($_REQUEST['col16'])){echo 'checked';}?> onClick="set_other_chkboxes(this,'srt','','13');
                    compose_sel(this,'col')" />
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        State of residence
                    </div>
                </label>
            </li>
            
            <li>
                <label class="lbl_beh" for="col17">
                <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">17</div>
                <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                    <input type="checkbox" id="col17" name="col17" value="q" 
                        <?php if (isset($_REQUEST['col17'])){echo 'checked';}?> onClick="set_other_chkboxes(this,'srt','','14');
                        compose_sel(this,'col')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        LGA of residence
                    </div>
                </label>
            </li>
            <li>
                <label class="lbl_beh" for="col18">
                <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">18</div>
                <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                    <input type="checkbox" id="col18" name="col18" value="r"  
                        <?php if (isset($_REQUEST['col18'])){echo 'checked';}?>
                        onClick="if(_('qry_type1').checked){set_other_chkboxes(this,'col','0','1-17');
                        set_other_chkboxes(this,'col','0','19-26');}
                        if(this.checked&&_('qry_type2').checked)
                        {_('col15').checked=false;_('srt12').checked=false;_('srt12').disabled=true;
                        _('col12').checked=false;_('srt9').checked=false;_('srt9').disabled=true;}
                        set_other_chkboxes(this,'srt','','15');
                        compose_sel(this,'col')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Geo-political zone of residence
                    </div>						
                </label>
            </li>
            <li></li>
            <li>
                <label class="lbl_beh" for="col19">
                <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">19</div>
                <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                    <input type="checkbox" id="col19" name="col19" value="s" 
                        <?php if (isset($_REQUEST['col19'])){echo 'checked';}?> disabled="disabled" 
                        onClick="if(this.checked){this.value='r'}else{this.value=''}" />
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Show state
                    </div>				
                </label>
            </li>	
        </ul>
        
        <ul class="checklist" style="float:right; width:49.5%; overflow:scroll; overflow-x: hidden; height:518px">										
            <li>
                <label class="lbl_beh" for="col20">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">20</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="col20" name="col20" value="t" 
                            <?php if (isset($_REQUEST['hdqry_type']) && $_REQUEST['hdqry_type'] == '1')
                            {
                                echo ' disabled="disabled"';
                            }else if (isset($_REQUEST['col20'])){echo 'checked';}?> 
                            onClick="set_other_chkboxes(this,'srt','','16');compose_sel(this,'col');" />
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Form application number
                    </div>			
                </label>
            </li>									
            <li>
                <label class="lbl_beh" for="col21">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">21</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="col21" name="col21" value="u" 
                            <?php if (isset($_REQUEST['std_cat']) && $_REQUEST['std_cat'] <> 'c')
                            {
                                echo ' disabled="disabled"';
                            }else if (isset($_REQUEST['col21'])){echo 'checked';}?>
                            onClick="set_other_chkboxes(this,'srt','','17');compose_sel(this,'col')" />
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Matriculation number
                    </div>
                </label>
            </li>									
            <li>
                <label class="lbl_beh" for="col22">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">22</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="col22" name="col22" value="v" 
                            <?php if (isset($_REQUEST['hdqry_type']) && $_REQUEST['hdqry_type'] == '1')
                            {
                                echo ' disabled="disabled"';
                            }else if (isset($_REQUEST['col22'])){echo 'checked';}?>
                        onClick="set_other_chkboxes(this,'srt','','18');compose_sel(this,'col')" />
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Name of applicant/student
                    </div>
                </label>
            </li>
            <li></li>
            <li>
                <label class="lbl_beh" for="col23">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">23</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                    <input type="checkbox" id="col23" name="col23" value="w" 
                        <?php if (isset($_REQUEST['hdqry_type']) && $_REQUEST['hdqry_type'] == '1')
                        {
                            echo ' disabled="disabled"';
                        }else if (isset($_REQUEST['col23'])){echo 'checked';}?>
                        onClick="set_other_chkboxes(this,'srt','','19');compose_sel(this,'col')" />
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        eMail address
                    </div>
                </label>
            </li>
            <li>
                <label class="lbl_beh" for="col24">
                <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">24</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                    <input type="checkbox" id="col24" name="col24" value="x" 
                        <?php if (isset($_REQUEST['hdqry_type']) && $_REQUEST['hdqry_type'] == '1')
                        {
                            echo ' disabled="disabled"';
                        }else if (isset($_REQUEST['col24'])){echo 'checked';}?>
                        onClick="set_other_chkboxes(this,'srt','','20');compose_sel(this,'col')" />
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Mobile phone
                    </div>
                </label>
            </li>									
            <li>
                <label class="lbl_beh" for="col25">
                <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">25</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                    <input type="checkbox" id="col25" name="col25" value="y" 
                        <?php if (isset($_REQUEST['hdqry_type']) && $_REQUEST['hdqry_type'] == '1')
                        {
                            echo ' disabled="disabled"';
                        }else if (isset($_REQUEST['col25'])){echo 'checked';}?>
                        onClick="set_other_chkboxes(this,'srt','','21');compose_sel(this,'col')" />
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        eMail address of NOK
                    </div>
                </label>
            </li>									
            <li>
                <label class="lbl_beh" for="col26">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">26</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                    <input type="checkbox" id="col26" name="col26" value="z" 
                        <?php if (isset($_REQUEST['hdqry_type']) && $_REQUEST['hdqry_type'] == '1')
                        {
                            echo ' disabled="disabled"';
                        }else if (isset($_REQUEST['col26'])){echo 'checked';}?>
                        onClick="set_other_chkboxes(this,'srt','','22');ompose_sel(this,'col')" />
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Mobile phone of NOK
                    </div>		
                </label>
            </li>
        </ul>
    </div>

    <div class="innercont_stff" id="ans2_2" 
        style="display:none; height:441px; 
        margin:-1px; 
        margin-top:5px;">

        <div class="innercont_stff" style="width:100%; font-weight:bold;">
            <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding:4px; background-color:#E3EBE2; text-align:right; width:10%">Sno</div>
            
            <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding:4px; background-color:#E3EBE2; margin-left:-1px; width:43.5%; text-align:left; text-indent:2px">Lower limit</div>
            
            <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding:4px; background-color:#E3EBE2; margin-left:-1px; width:43.4%; text-align:left;">Upper limit</div>
        </div>

        <ul class="checklist" style="float:left; margin-top:5px; width:100%; height:auto;"><?php
            for ($c = 1; $c <= 10; $c++)
            {?>
                <li style="width:100%; height:25px;">
                    <label>
                        <div class="ctabletd_1" style="width:10%; height:auto; padding:4px;">Group <?php echo $c;?></div>
                        <div class="ctabletd_1" style="width:43.5%; height:auto; padding:4px; margin-left:-1px; ">
                            <select name="grp<?php echo $c;?>1" id="grp<?php echo $c;?>1" style="margin:-2px;" onChange="/*hdgrp11.value=this.value*/">
                                <option value = "" selected></option><?php
                                for ($t = 1; $t <= 100; $t++)
                                {?>
                                    <option value="<?php echo $t ?>">
                                        <?php echo $t ?>
                                    </option><?php
                                }?>
                            </select>
                        </div>
                        <div class="ctabletd_1 ctabletd_1_loc" style="width:43.4%; height:auto; padding:4px; margin-left:-1px; ">
                            <select name="grp<?php echo $c;?>2" id="grp<?php echo $c;?>2" style="margin:-2px;" onChange="/*hdgrp12.value=this.value*/">
                                <option value = "" selected></option><?php
                                for ($t = 1; $t <= 100; $t++)
                                {?>
                                    <option value="<?php echo $t ?>">
                                        <?php echo $t ?>
                                    </option><?php
                                }?>
                            </select>
                        </div>																
                    </label>
                </li><?php
            }?>
        </ul>
    </div>
</div>