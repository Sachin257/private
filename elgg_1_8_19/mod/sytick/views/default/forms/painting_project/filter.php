<?php
$s = get_sanitised_input('s')
?>
<div class="col-lg">
    <div class="span4" style="margin-left: 0px">
        <span>Name : </span><?php
        echo elgg_view("input/dropdown", array(
            "name" => "project",
            "id" => "uniq_project",
            "options_values" => $vars["uniqueproject"],
            "value" => $vars["s"]
        ));
        ?>
    </div>
    <div class="span4" style="margin-left: 0px;">
        <span>Material : </span><?php
        echo elgg_view("input/dropdown", array(
            "name" => "material_id",
            "id" => "material_drpdown",
            "options_values" => $vars["materials"],
            "value" => $vars["m"]
        ));
        ?>
    </div>
    <div class="span4" style="margin-left: 0px;">
        <span>Order From : </span><?php
        echo elgg_view("input/dropdown", array(
            "id" => "order_from_drpdown",
            "options_values" => $vars["order_from"],
            "value" => $vars["o"]
        ));
        ?>
    </div>
</div>
<div class="clear" style="height: 20px;"></div>
<div>
    <div class="span4" style="margin-left: 0px;">
        <span>Start date:</span>
        <?php echo elgg_view('input/date', array('id' => 'start_date', "value" => $vars["start_date"], 'name' => 'start_date')); ?><a href="javascript:void(0)" id="date_of_issue_lnk" class="calimage"></a>
    </div>

    <div class="span4" style="margin-left: 0px;">
        <span>End Date</span>
        <?php echo elgg_view('input/date', array('id' => 'final_date', "value" => $vars["final_date"], 'name' => 'final_date')); ?><a href="javascript:void(0)" id="date_of_expiry_lnk" class="calimage"></a>
    </div>
    <div class="span4" style="margin-left: 0px;">    
        <?php echo elgg_view('input/button', array( 'id' => 'btn_paint_prj_filter', 'class' => 'btn btn_submit', 'value' => elgg_echo('entity:filter'))); ?>
        <?php echo elgg_view('input/button', array( 'id' => 'btn_paint_prj_filter_reset', 'class' => 'btn btn_submit_grey', 'value' => elgg_echo('entity:reset'))); ?>
    </div>
</div>
<div class="span4 mgr_lsearch" style="display: none; float: left;">
    <?php echo elgg_view('input/text', array('name' => 's', 'id' => 's', 'placeholder' => 'Search', 'class' => 'hidden', 'value' => $s)); ?>
    <?php echo elgg_view('input/button', array('name' => 'filter', 'id' => 'btn_painting_project_filter', 'class' => 'btn hidden btn_submit', 'value' => elgg_echo('enitiy:search'))); ?>
</div>