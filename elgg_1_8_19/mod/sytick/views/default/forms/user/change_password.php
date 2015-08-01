<div id="content_body">
    	<div class="cnt_wrap">
        	<div class="ackno_wrap MT_four" align="center">
            	<h1 align="center"><?php echo elgg_echo('profile:change_password:title')?></h1>            	
                
                <?php echo elgg_view('input/password', array('id' => 'current_password','class'=>'MT_one' ,'placeholder'=>elgg_echo('change_pswd:current_pswd'), 'name' => 'current_password')); ?>
                <span class="error_msg clear current_password_err"></span>
               	<?php echo elgg_view('input/password', array('id' => 'password','class'=>'MT_one' ,'placeholder'=>elgg_echo('change_pswd:new_pswd'), 'name' => 'password')); ?>
                <span class="error_msg clear new_password_err"></span>
                <?php echo elgg_view('input/password', array('id' => 'password2','class'=>'MT_one' ,'placeholder'=>elgg_echo('change_pswd:repeat_pswd'), 'name' => 'password2')); ?>
                <span class="error_msg clear repeat_password_err"></span>
                <div class="MT_three">
                	<?php
					echo elgg_view('input/hidden', array(
							'name' => 'guid',
							'value' => $vars['guid'],
					));
					
					echo elgg_view('input/submit', array('name' => 'btn_change_password', 'class'=>'btn_resend MR_one', 'id'=>'btn_change_password','value' => elgg_echo('profile:change_password:title')));
					?>
                </div>
            </div>
        </div>
    </div>





