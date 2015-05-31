<div class="cnt_wrap">
        	<div class="ackno_wrap MT_four" align="center">
            	<h1 align="center"><?php echo elgg_echo('login:title')?></h1>            	
                <?php echo elgg_view('input/text', array(
	'name' => 'username',
        'autocomplete' => 'off',
        'tabindex' => '1',
	'id' =>'header_login_name',
	'class' => 'MT_one',
	'placeholder' => elgg_echo('email')
	));
        ?> <br>
        <?php echo elgg_view('input/password', array(
	'name' => 'password',
        'autocomplete' => 'off',
        'tabindex' => '2',
	'id' =>'header_login_passwd' ,
        'class' => 'MT_one',
	'placeholder' => elgg_echo('password')
	));
        ?>
                <span class="error_msg clear username_err"></span>
                <div class="MT_three">
                        <?php echo elgg_view('input/submit', array('value' => elgg_echo('initial:login'), 'id' =>'header_login' , 'class' => 'btn btn_resend MR_one')); ?>
                </div>
            
                
                <div class="MT_three" style="color: #666;">
            <a href="javascript:void(0)" id="register_modal"><?php echo elgg_echo("title:register");?></a> |
            <a id ="forgot_password_link" href="<?php echo elgg_get_site_url(); ?>sytick/forgotpassword"><?php echo elgg_echo("home:forgotpassword:label");?></a>
            </div>
        </div>
        </div>