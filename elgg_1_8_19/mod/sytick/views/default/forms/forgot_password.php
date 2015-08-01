<div id="content_body">
    	<div class="cnt_wrap">
        	<div class="ackno_wrap MT_four" align="center">
            	<h1 align="center"><?php echo elgg_echo('forgotpasssword:title')?></h1>            	
                <div class="MT_two MB_two"><?php echo elgg_echo('forgotpasssword:smallcap:title')?></div>
                <?php echo elgg_view('input/text', array('id' => 'username','name' => 'username','class'=>'MT_one' ,'placeholder'=>elgg_echo('email'))); ?>
                <span class="error_msg clear username_err"></span>
                <div class="MT_three">
                	<?php echo elgg_view('input/submit', array('name' => 'submit', 'class'=>'btn_resend MR_one', 'id'=>'btn_request','value' => elgg_echo('request')));?>
                </div>
            </div>
        </div>
    </div>
