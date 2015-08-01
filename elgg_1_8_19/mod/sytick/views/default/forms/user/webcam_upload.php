<?php
/**
 * Avatar upload form
 * 
 * @uses $vars['entity']
 */
elgg_load_js('webcam');
?>

<div id="avatar-options">
	<div id="avatar-upload" class="hidden">
		<label><?php echo elgg_echo("avatar:upload"); ?></label><br />
		<?php echo elgg_view("input/file", array('name' => 'avatar')); ?>
	</div>

	<div id="avatar-acquire">
		<label><?php echo elgg_echo("webcam:acquire:info"); ?></label><br />
		<div id="webcam">
			<canvas id="webcam-canvas" class="hidden"></canvas>
			<video id="webcam-video"></video>
		</div>
	</div>

	<div id="avatar-url" class="hidden">
		<label><?php echo elgg_echo("webcam:url:info"); ?></label><br />
		<?php echo elgg_view("input/text", array('name' => 'avatar_url')); ?>
	</div>
	<span class="error_msg clear crop_err"></span>
</div>


<div class="elgg-foot" align="center">
<?php
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['entity']->guid));
	echo elgg_view('input/submit', array(
		'value' => elgg_echo('upload'),
		'id' => 'avatar-upload',
                'class'=>'btn btn_submit',
	));
?>
<?php echo elgg_view('input/button', array('data-dismiss' =>'modal','id' =>'btn_webcam_cancel_upload' , 'class'=>'btn btn_submit_grey', 'value' => elgg_echo('certificate:cancel'))); ?><span class="ajx-submit-load disp-none"></span>
</div>