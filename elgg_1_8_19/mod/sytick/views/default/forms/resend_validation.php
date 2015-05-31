<div id="content_body">
    	<div class="cnt_wrap">
        	<div class="ackno_wrap MT_four" align="center">
            	<h1 align="center"><?php echo elgg_echo('registration:success')?></h1>
                <p align="center"><?php echo elgg_echo('registration:success:line1')?> <br /> </p>
                <p align="center" class="MT_three"><?php echo elgg_echo('registration:success:line3')?></p>
                <p align="center" class="MT_three"><?php echo elgg_echo('registration:success:line4')?></p>
                
                <?php echo elgg_view('input/text', array('id' => 'resend_email','name' => 'resend_email','class'=>'MT_one' ,'placeholder'=>elgg_echo('email'))); ?>
                <span class="error_msg clear resend_email_err"></span>
                <div class="MT_three">
                	<?php echo elgg_view('input/submit', array('name' => 'submit', 'class'=>'btn_resend MR_one', 'id'=>'btn_resend','value' => elgg_echo('registration:resend:email')));?>
                </div>
            </div>
        </div>
    </div>
