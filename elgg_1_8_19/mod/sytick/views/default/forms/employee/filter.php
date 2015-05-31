<?php 
$s = get_sanitised_input('s');
$profile_type_name = elgg_extract('role_name', $vars);
if(!$profile_type_name)
{
   $profile_type_name =  "employee";
}
?>
<div class="span4 mgr_lsearch" align="right">
 	<?php echo elgg_view('input/text', array('name' => 's', 'id' => 's', 'placeholder' => 'Search', 'value' => $s)); ?>
	<?php echo elgg_view('input/button', array('name' => 'filter', 'id' => 'btn_'.$profile_type_name.'_filter', 'class' => 'btn btn_submit', 'value' => elgg_echo('enitiy:search'))); ?>
</div>