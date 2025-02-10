<div class="innercont_stff" id="ans3" 
    style="display:<?php if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '3'){?>block<?php }else{?>none<?php }?>; 
    height:auto; margin-top:0%; width:99.8%; padding:0%; 
    border:0px solid #000;">
    <div class="innercont_stff" id="ans3_1" 
        style="display:block; height:auto; margin-top:0%;">
        <div class="innercont_stff" 
            style="width:48.25%; 
            float:left; 
            height:auto; 
            padding:0.5%; 
            margin-top:0%;
            border:1px solid #CCCCCC; 
            background:#E6E6E6">
            General columns
        </div>
        <div class="innercont_stff" 
            style="width:48.3%; 
            float:right; 
            height:auto; 
            padding:0.5%;
            margin-top:0%;
            border:1px solid #CCCCCC; 
            background:#E6E6E6">
            Identity Columns
        </div>

        <ul class="checklist" style="float:left; width:49.45%; overflow:scroll; overflow-x: hidden; height:563px">
            <li>
                <label class="lbl_beh" for="srt1">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">1</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt1" name="srt1" value="a" 
                        <?php if (!isset($_REQUEST['col1'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt1'])){echo 'checked';} ?>
                        onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Study Centre
                    </div>
                </label>
            </li>
            <li>
                <label class="lbl_beh" for="srt2">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">2</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                    <input type="checkbox" id="srt2" name="srt2" value="b"
                    <?php if (!isset($_REQUEST['col2'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt2'])){echo 'checked';} ?>
                        onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Faculty
                    </div>
                </label>
            </li>
            <li>
                <label class="lbl_beh" for="srt3">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">3</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt3" name="srt3" value="c" 
                        <?php if (!isset($_REQUEST['col3'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt3'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Department
                    </div>							
                </label>
            </li>
            
            <li>
                <label class="lbl_beh" for="srt4">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">4</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt4" name="srt4" value="d" d
                        <?php if (!isset($_REQUEST['col4'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt4'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Programme
                    </div>							
                </label>
            </li>
            
            <li>
                <label class="lbl_beh" for="srt5">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">5</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt5" name="srt5" value="e" 
                        <?php if (!isset($_REQUEST['col5'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt5'])){echo 'checked';} ?>
                        onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Course
                    </div>							
                </label>
            </li>
            
            <li>    
                <label class="lbl_beh" for="srt6">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">6</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                            <input type="checkbox" id="srt6" name="srt6" value="f" 
                        <?php if (!isset($_REQUEST['col6'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt6'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Qualification
                    </div>							
                </label>
            </li>
            <li>
                <label class="lbl_beh" for="srt7">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">7</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt7" name="srt7" value="g"  
                        <?php if (!isset($_REQUEST['col7'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt7'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Level
                    </div>						
                </label>
            </li>
            
            <li>
                <label class="lbl_beh" for="srt8">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">8</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt8" name="srt8" value="h"  
                        <?php if (!isset($_REQUEST['col8'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt8'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Gender
                    </div>						
                </label>
            </li>
            
            <li>
                <label class="lbl_beh" for="srt9">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">9</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt9" name="srt9" value="l" 
                        <?php if (!isset($_REQUEST['col9'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt9'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')" disabled/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Geo-political zone of Study Centre
                    </div>
                </label>
            </li>
            <li>
                <label class="lbl_beh" for="srt10">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">10</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt10" name="srt10" value="m" 
                        <?php if (!isset($_REQUEST['col10'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt10'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        State of origin
                    </div>
                </label>
            </li>
            <li>
                <label class="lbl_beh" for="srt11">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">11</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt11" name="srt11" value="n" 
                        <?php if (!isset($_REQUEST['col14'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt11'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')" />
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        LGA of origin
                    </div>
                </label>
            </li>
            <li>
                <label class="lbl_beh" for="srt12">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">12</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt12" name="srt12" value="o" 
                        <?php if (!isset($_REQUEST['col12'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt12'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Geo-political zone of origin
                    </div>
                </label>
            </li>
            
            <li>
                <label class="lbl_beh" for="srt13">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">13</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt13" name="srt13" value="p" 
                        <?php if (!isset($_REQUEST['col13'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt13'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')" />
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        State of residence
                    </div>
                </label>
            </li>
            <li>
                <label class="lbl_beh" for="srt14">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">14</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt14" name="srt14" value="q" 
                        <?php if (!isset($_REQUEST['col14'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt14'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        LGA of residence
                    </div>
                </label>
            </li>
            <li>
                <label class="lbl_beh" for="srt15">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">15</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt15" name="srt15" value="r" 
                            <?php if (!isset($_REQUEST['col15'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt15'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Geo-political zone of residence
                    </div>
                </label>
            </li>
            <li></li>
            <li>
                <label class="lbl_beh" for="srt23">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;"></div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt23" name="srt23" value="-"
                            <?php if (isset($_REQUEST['hdqry_type']) && $_REQUEST['hdqry_type'] <> 1){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt23'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Count
                    </div>
                </label>
            </li>
        </ul>

        <ul class="checklist" style="float:right; width:49.5%; overflow:scroll; overflow-x: hidden; height:563px">
            <li>
                <label class="lbl_beh" for="srt16">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">16</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt16" name="srt16" value="s" 
                        <?php if (!isset($_REQUEST['col20'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt16'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Form application number
                    </div>
                </label>
            </li>									
            <li>
                <label class="lbl_beh" for="srt17">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">17</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt17" name="srt17" value="t" 
                        <?php if (!isset($_REQUEST['col21'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt17'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Matriculation number
                    </div>
                </label>
            </li>									
            <li>
                <label class="lbl_beh" for="srt18">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">18</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt18" name="srt18" value="u" 
                            <?php if (!isset($_REQUEST['col22'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt18'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')" />
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Name of student
                    </div>
                </label>
            </li>
            <li></li>
            <li>
                <label class="lbl_beh" for="srt19">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">19</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt19" name="srt19" value="v" 
                        <?php if (!isset($_REQUEST['col23'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt19'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        eMail address
                    </div>
                </label>
            </li>
            <li>
                <label class="lbl_beh" for="srt20">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">20</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt20" name="srt20" value="w" 
                        <?php if (!isset($_REQUEST['col24'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt20'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Mobile phone
                    </div>
                </label>
            </li>									
            <li>
                <label class="lbl_beh" for="srt21">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">21</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt21" name="srt21" value="x" 
                        <?php if (!isset($_REQUEST['col25'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt21'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        eMail address of NOK
                    </div>
                </label>
            </li>									
            <li>
                <label class="lbl_beh" for="srt22">
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; text-align:right;">22</div>
                    <div class="ctabletd_1" style="width:5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        <input type="checkbox" id="srt22" name="srt22" value="y" 
                        <?php if (!isset($_REQUEST['col26'])){echo ' disabled="disabled"';}else if (isset($_REQUEST['srt22'])){echo 'checked';} ?>
                            onClick="compose_sel(this,'st')"/>
                    </div>
                    <div class="ctabletd_1" style="width:85.5%; padding:0.6%; padding-top:2%; padding-bottom:2%; margin-left:-1px; text-align:left;">
                        Mobile phone of NOK
                    </div>
                </label>
            </li>
        </ul>
    </div>
</div>