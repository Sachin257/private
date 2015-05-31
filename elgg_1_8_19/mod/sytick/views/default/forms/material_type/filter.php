<?php 
$s = get_sanitised_input('s')
?>
<div class="span4 mgr_lsearch" align="right">
 	<?php echo elgg_view('input/text', array('name' => 's', 'id' => 's', 'placeholder' => 'Search', 'value' => $s)); ?>
	<?php echo elgg_view('input/button', array('name' => 'filter', 'id' => 'btn_material_type_filter', 'class' => 'btn btn_submit', 'value' => elgg_echo('enitiy:search'))); ?>
</div>