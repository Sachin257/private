<?php
$s = get_sanitised_input('s')
?>

<div class="span3" style="float: left;">
    <span>Name : </span><?php
    echo elgg_view("input/dropdown", array(
        "name" => "project",
        "id" => "uniq_project",
        "options_values" => $vars["uniqueproject"],
    ));
    ?>
</div>
<div class="span4" style="float: left;">
    <span>Material : </span><?php
    echo elgg_view("input/dropdown", array(
        "name" => "material_id",
        "id" => "material_id",
        "options_values" => $vars["materials"],
    ));
    ?>
</div>
<div class="span4 mgr_lsearch" style="float: left;">
    <?php echo elgg_view('input/text', array('name' => 's', 'id' => 's', 'placeholder' => 'Search', 'value' => $s)); ?>
    <?php echo elgg_view('input/button', array('name' => 'filter', 'id' => 'btn_painting_project_filter', 'class' => 'btn btn_submit', 'value' => elgg_echo('enitiy:search'))); ?>
</div>