<div class="cmp_enity nest_wrap rounded_corners frm_box_shadow frm_box_border span12 MT_one MB_three mger_add">

    <div class="clear"></div>

    <div class="span5">
        <label><?php echo elgg_echo("project:name"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'project_name', 'id' => 'project_name', 'value' => $vars["entity"]->title)); ?>
        <span class="error_msg clear project_name_err"></span>
    </div>               

    <div class="span5">
        <label><?php echo elgg_echo("project:customer"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'customer', 'id' => 'customer', 'value' => $vars["entity"]->customer)); ?>
        <span class="error_msg clear customer_err"></span>
    </div>             

    <div class="span5 daterow">
        <label><?php echo elgg_echo('project:doi'); ?></label>
        <?php echo elgg_view('input/date', array('id' => 'start_date', "style" => "width: 89.5%;", "value" => $vars["entity"]->start_date, 'name' => 'start_date')); ?><a href="javascript:void(0)" id="date_of_issue_lnk" class="calimage"></a>
        <span class="error_msg  start_date_err"></span>
    </div>

    <div class="span5 daterow">
        <label><?php echo elgg_echo('project:expiry'); ?></label>
        <?php echo elgg_view('input/date', array('id' => 'final_date', "style" => "width: 89.5%;", "value" => $vars["entity"]->final_date, 'name' => 'final_date')); ?><a href="javascript:void(0)" id="date_of_expiry_lnk" class="calimage"></a>
        <span class="error_msg clear final_date_err"></span>
    </div>

    <div class="clear"></div>
    <?php
    if ($vars["entity"]->guid) {
        echo elgg_view('input/hidden', array('name' => 'guid', 'id' => 'guid', 'value' => $vars["entity"]->guid));
    }
    ?>

    <div align="center" class="MT_two MB_three">
        <?php echo elgg_view('input/submit', array('name' => 'btn_project_save', 'id' => 'btn_project_save', 'class' => 'btn btn_submit MR_20', 'value' => elgg_echo('manager:save'))); ?>
        <?php echo elgg_view('input/button', array('name' => 'btn_project_cancel', 'id' => 'btn_project_cancel', "onclick" => "javascript:window.location.href='/project/all'", 'class' => 'btn btn_submit_grey', 'value' => elgg_echo('certificate:cancel'))); ?><span class="ajx-submit-load disp-none"></span>
    </div>
</div>
