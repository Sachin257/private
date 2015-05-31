
<div class="avatar_upld column_left">
    <label style="display: none;"><?php echo elgg_echo("avatar:upload"); ?></label>
	<?php echo elgg_view("input/file",array('name' => 'avatar', 'id' => 'avatar')); ?>
</div>
<div class="elgg-foot column_right">
	<?php echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['entity']->guid)); ?>
    <div style="display: none;"><?php echo elgg_view('input/submit', array('id' =>'btn_upload' ,'value' => elgg_echo('upload'))); ?></div>
    <div class="avatar_upld" align="center"><?php echo elgg_view('input/button', array('data-dismiss' =>'modal','id' =>'btn_profile_pic_save' , 'class'=>'btn btn_submit', 'value' => elgg_echo('manager:save'))); ?>
    <?php echo elgg_view('input/button', array('data-dismiss' =>'modal','id' =>'btn_cancel_upload' , 'class'=>'btn_submit_grey', 'value' => elgg_echo('certificate:cancel'))); ?></div>
</div>