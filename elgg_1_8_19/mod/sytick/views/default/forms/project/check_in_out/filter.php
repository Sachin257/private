
<?php 
$s = get_sanitised_input('s')
?>
<div class="span4 mgr_lsearch" align="right">
 	<?php echo elgg_view('input/text', array('name' => 's', 'id' => 's', 'placeholder' => 'Search', 'value' => $s)); ?>
	<?php echo elgg_view('output/url', array('name' => 'filter', 'id' => 'btn_in_out_filter', 'class' => 'flt_src_btn', 'text' => '<i class="fa fa-search"></i>')); ?>
    
</div>
