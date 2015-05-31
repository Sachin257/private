<?php 
$s = get_sanitised_input('s')
?>
<?php
        echo elgg_view("input/dropdown", array(
            "name" => "material_id",
            "id" => "uniq_project",
            "class" => "custom-select",
            "options_values" => $vars["uniqueproject"],
        ));
        ?>
<div class="span4 mgr_lsearch" style="float: left;">
    
 	<?php echo elgg_view('input/text', array('name' => 's', 'id' => 's', 'placeholder' => 'Search', 'value' => $s)); ?>
	<?php echo elgg_view('input/button', array('name' => 'filter', 'id' => 'btn_painting_project_filter', 'class' => 'btn btn_submit', 'value' => elgg_echo('enitiy:search'))); ?>
</div>