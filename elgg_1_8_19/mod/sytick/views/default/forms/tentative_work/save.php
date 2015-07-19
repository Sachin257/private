<div class="cmp_enity nest_wrap rounded_corners frm_box_shadow frm_box_border span12 MT_one MB_three mger_add">

    <div class="span5">
        <label><?php echo elgg_echo("entity:date"); ?></label>
        <?php echo elgg_view('input/date', array('id' => 'date', 'name' => 'date')); ?><a href="javascript:void(0)" id="date_of_issue_lnk" class="calimage"></a>
        <span class="error_msg clear paint_date_err"></span>
    </div>

    <div class="span5" style="height: 80px;">
        <label><?php echo elgg_echo("paint:used:shift"); ?></label>
        <?php
        $options = array("Moring" => "Moring", "Noon" => "Noon");
        echo elgg_view("input/dropdown", array(
            "name" => "shift",
            "id" => "shift",
            "class" => "custom-select",
            "options_values" => $options
        ));
        ?>
        <span class="error_msg clear shift_err"></span>
    </div>

    <div class="span5">
        <label><?php echo elgg_echo("paint:colour"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'colour', "id"=>"paint_color" , 'value' => $vars["entity"]->colour)); ?>
        <span class="error_msg clear paint_color_err"></span>
    </div>

    <div class="span5">
        <label><?php echo elgg_echo("entity:description"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'description', "id" => "description")); ?>
        <span class="error_msg clear description_err"></span>
    </div>

    <div class="clear"></div>
    <div align="center" class="MT_two MB_three">

        <?php echo elgg_view('input/submit', array('name' => 'btn_project_tentative_save', 'id' => 'btn_project_tentative_save', 'class' => 'btn btn_submit MR_20', 'value' => elgg_echo('manager:save'))); ?>
        <?php echo elgg_view('input/button', array('name' => 'btn_paint_project_cancel', 'id' => 'btn_paint_project_cancel', "onclick" => "javascript:window.location.href='/tentative_work/all'", 'class' => 'btn btn_submit_grey', 'value' => elgg_echo('certificate:cancel'))); ?><span class="ajx-submit-load disp-none"></span>
    </div>

    <br/><br/>
</div>
