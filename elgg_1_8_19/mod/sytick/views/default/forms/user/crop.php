<?php
/**
 * Avatar crop form
 *
 * @uses $vars['entity']
 */
elgg_load_js('jquery.imgareaselect');
elgg_load_css('jquery.imgareaselect');
$master_img = elgg_view('output/img', array(
	'src' => $vars['entity']->getIconUrl('master'),
	'alt' => elgg_echo('avatar'),
	'class' => 'mrl',
	'id' => 'user-avatar-cropper',
));

?>
<div class="clearfix" align="center">
	<?php echo $master_img; ?>
	<span class="error_msg clear crop_err"></span>
</div>
<div>
<?php
$coords = array('x1', 'x2', 'y1', 'y2');
foreach ($coords as $coord) {
	echo elgg_view('input/hidden', array('id' => $coord, 'name' => $coord, 'value' => (($vars['entity']->$coord)?$vars['entity']->$coord:0)  ));
}

echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['entity']->guid));

//echo elgg_view('input/submit', array('id' => 'btn_crop', 'value' => elgg_echo('avatar:create')));

?>
</div>
