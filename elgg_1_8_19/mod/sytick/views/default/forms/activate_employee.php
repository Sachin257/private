<div id="content_body">
    	<div class="cnt_wrap">
        	<div class="ackno_wrap MT_four" align="center">
            	<h1 align="center"><?php echo elgg_echo('activate_employee:title')?></h1>            	
                <p><?php echo elgg_echo("activate:employee:text");?></p>
                <?php echo elgg_view('input/password', array('id' => 'password','name' => 'password','class'=>'MT_one' ,'placeholder'=>elgg_echo('password'))); ?>
                <span class="error_msg clear password_err"></span>
                <?php echo elgg_view('input/password', array('id' => 'password2','name' => 'password2','class'=>'MT_one' ,'placeholder'=>elgg_echo('passwordagain'))); ?>
                <span class="error_msg clear password2_err"></span>
                <div class="MT_three">
                	<?php
					echo elgg_view('input/hidden', array(
							'name' => 'u',
							'value' => $vars['guid'],
					));
					
					echo elgg_view('input/hidden', array(
							'name' => 'c',
							'value' => $vars['code'],
					));
					
					echo elgg_view('input/submit', array('name' => 'submit', 'class'=>'btn_resend MR_one', 'id'=>'btn_activate_employee','value' => elgg_echo('activate_employee:create_password')));
					?>
                </div>
            </div>
        </div>
    </div>