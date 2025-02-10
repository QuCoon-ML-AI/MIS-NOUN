<?php if (isset($_REQUEST['mm']) && $_REQUEST['mm'] == 8)
{?>
	<div style="width:15%; height:auto; position:absolute; margin-top:5px; right:0; border-radius:0px"><?php
		/*if (check_scope2('SPGS', 'Forward application') > 0)
		{?>
			<a href="#" style="text-decoration:none;" 
				onclick="pg_environ.sm.value=20;pg_environ.submit(); return false;">
				<div class="rtlft_inner_button" style="width:100%; border-bottom:1px dashed #ccc" title="...to respective departments">
					Forward applications...
				</div>
			</a><?php

		}

		if (check_scope2('SPGS', 'Retrieve application') > 0)
		{?>
			<a href="#" style="text-decoration:none;" 
				onclick="pg_environ.sm.value=21;pg_environ.submit(); return false;">
				<div class="rtlft_inner_button" style="width:100%; border-bottom:1px dashed #ccc" title="...from respective departments">
				Retrieve application(s)...
				</div>
			</a><?php
		}*/

		if (check_scope2('SPGS', 'Send invitation for interview') > 0)
		{?>
			<a href="#" style="text-decoration:none;" 
				onclick="pg_environ.sm.value=22;pg_environ.submit();return false">
				<div class="rtlft_inner_button" style="width:100%; border-bottom:1px dashed #ccc" title="...to shortlisted candidates">
					Send invitation for interview...
				</div>
			</a><?php
		}
		

		if (check_scope2('SPGS', 'Interview status') > 0)
		{?>
			<a href="#" style="text-decoration:none;"
				onclick="pg_environ.sm.value=23;pg_environ.submit();return false">
				<div class="rtlft_inner_button" style="width:100%; border-bottom:1px dashed #ccc">
					Interview status
				</div>
			</a><?php
		}

			
		if (check_scope2('SPGS', 'Forward interview reports') > 0)
		{?>
			<a href="#" style="text-decoration:none;" 
				onclick="pg_environ.sm.value=24;pg_environ.submit();return false">
				<div class="rtlft_inner_button" style="width:100%; border-bottom:1px dashed #ccc" title="...to SPGS">
					Recommend candidte...
				</div>
			</a><?php
		}
		
		if (check_scope2('SPGS', 'Send admission letter') > 0)
		{?>
			<a href="#" style="text-decoration:none;" 
				onclick="pg_environ.sm.value=25;pg_environ.submit();return false">
				<div class="rtlft_inner_button" style="width:100%; border-bottom:1px dashed #ccc" title="...to  successful candidates">
					Enable admission letter...
				</div>
			</a><?php
		}
		
		if (check_scope2('SPGS', 'Screen admitted candidates') > 0)
		{?>
			<a href="#" style="text-decoration:none;" 
				onclick="pg_environ.sm.value=26;pg_environ.submit();return false">
				<div class="rtlft_inner_button" style="width:100%; border-bottom:1px dashed #ccc">
					Screen admitted candidates
				</div>
			</a><?php
		}
		
		if (check_scope2('SPGS', 'Confirm transcript') > 0)
		{?>
			<a href="#" style="text-decoration:none;" 
				onclick="pg_environ.sm.value=28;pg_environ.submit();return false">
				<div class="rtlft_inner_button" style="width:100%; border-bottom:1px dashed #ccc">
					Confirm transcript
				</div>
			</a><?php
		}
		
		
		if (check_scope2('SPGS', 'Manage seminar topics') > 0)
		{?>
			<div class="rtlft_inner_button" style="padding:0%; background:none;" 
				onmouseover="_('mgt_std_menu').style.display='block'" 
				onmouseout="_('mgt_std_menu').style.display='none'">
				<div class="rtlft_inner_button" style="width:100%; position:relative">
					Manage student
					<img src="<?php echo BASE_FILE_NAME_FOR_IMG;?>drop_down.png" style="position:absolute; right:10px; top:17px; width:12px; height:8px;">
				</div>
				<div id="mgt_std_menu" class="rtlft_inner_button" 
					style="display:none; border:0px; background:none; padding-bottom:0%;" 
					onclick=""><?php
									
					//if (check_scope4('SPGS', 'Manage student', 'Supervisor and Seminar topic', 'New topic') > 0)
					//{
						/*if (isset($_REQUEST['sm']) && $_REQUEST["sm"] == '27a')
						{?>
							<div class="rtlft_inner_button rtlft_inner_button_sub" style="width:100%; background:#a0aba7; color:#FFFFFF; margin-top:-1px;">
								Supervisor and Seminar
						</div><?php
						}else
						{*/?>
							<a href="#" style="text-decoration:none;" 
								onclick="pg_environ.sm.value='27a';pg_environ.submit();return false;">
								<div class="rtlft_inner_button rtlft_inner_button_sub" style="width:100%; margin-top:-1px;">
									Supervisor and Seminar
								</div>
							</a><?php
						//}
					//}

					//if (check_scope3('SPGS', 'Manage seminar topics', 'New topic') > 0)
					//{
						/*if (isset($_REQUEST['sm']) && $_REQUEST["sm"] == '27b')
						{?>							
							<div class="rtlft_inner_button rtlft_inner_button_sub"  style="width:100%; background:#a0aba7; color:#FFFFFF; margin-top:-1px;">
								Thesis proposal
							</div><?php
						}else
						{*/?>						
							<a href="#" style="text-decoration:none;" 
								onclick="pg_environ.sm.value='27b';pg_environ.submit();return false;">
								<div class="rtlft_inner_button rtlft_inner_button_sub" style="width:100%; margin-top:-1px;">
									Thesis proposal
								</div>
							</a><?php
						//}
					//}

					/*if (isset($_REQUEST['sm']) && $_REQUEST["sm"] == '27c')
					{?>
						<div class="rtlft_inner_button rtlft_inner_button_sub"  style="width:100%; background:#a0aba7; color:#FFFFFF; margin-top:-1px;">
							Pre-field proposal defence
						</div><?php
					}else
					{*/?>
						<a href="#" style="text-decoration:none;" 
							onclick="pg_environ.sm.value='27c';pg_environ.submit();return false;">
							<div class="rtlft_inner_button rtlft_inner_button_sub" style="width:100%; margin-top:-1px;">
								Pre-field proposal defence
							</div>
						</a><?php
					//}

					/*if (isset($_REQUEST['sm']) && $_REQUEST["sm"] == '27d')
					{?>							
						<div class="rtlft_inner_button rtlft_inner_button_sub"  style="width:100%; background:#a0aba7; color:#FFFFFF; margin-top:-1px;">
							Post-field defence
						</div><?php
					}else
					{*/?>							
						<a href="#" style="text-decoration:none;" 
							onclick="pg_environ.sm.value='27d';pg_environ.submit();return false;">
							<div class="rtlft_inner_button rtlft_inner_button_sub" style="width:100%; margin-top:-1px;">
								Post-field defence
							</div>
						</a><?php
					/*}

					if (isset($_REQUEST['sm']) && $_REQUEST["sm"] == '27e')
					{?>
						<div class="rtlft_inner_button rtlft_inner_button_sub"  style="width:100%; background:#a0aba7; color:#FFFFFF; margin-top:-1px;">
							Approval of thesis
						</div><?php
					}else
					{*/?>
						<a href="#" style="text-decoration:none;" 
							onclick="pg_environ.sm.value='27e';pg_environ.submit();return false;">
							<div class="rtlft_inner_button rtlft_inner_button_sub" style="width:100%; margin-top:-1px;">
								Approval of thesis
							</div>
						</a><?php
					/*}

					if (isset($_REQUEST['sm']) && $_REQUEST["sm"] == '27f')
					{?>
						<div class="rtlft_inner_button rtlft_inner_button_sub"  style="width:100%; background:#a0aba7; color:#FFFFFF; margin-top:-1px;">
							Defence of thesis
						</div><?php
					}else
					{*/?>
						<a href="#" style="text-decoration:none;" 
							onclick="pg_environ.sm.value='27f';pg_environ.submit();return false;">
							<div class="rtlft_inner_button rtlft_inner_button_sub" style="width:100%; margin-top:-1px;">
								Defence of thesis
							</div>
						</a><?php
					/*}

					if (isset($_REQUEST['sm']) && $_REQUEST["sm"] == '27g')
					{?>						
						<div class="rtlft_inner_button rtlft_inner_button_sub"  style="width:100%; background:#a0aba7; color:#FFFFFF; margin-top:-1px;">
							Award of degree
						</div><?php
					}else
					{*/?>
						<a href="#" style="text-decoration:none;" 
							onclick="pg_environ.sm.value='27g';pg_environ.submit();return false;">
							<div class="rtlft_inner_button rtlft_inner_button_sub" style="width:100%; margin-top:-1px;">
								Award of degree
							</div>
						</a><?php
					//}?>
				</div>
			</div><?php
		}?>
	</div><?php
}?>