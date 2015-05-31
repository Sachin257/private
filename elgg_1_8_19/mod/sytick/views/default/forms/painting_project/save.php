<div class="cmp_enity nest_wrap rounded_corners frm_box_shadow frm_box_border span12 MT_one MB_three mger_add">

    <div class="span5">
        <label><?php echo elgg_echo("project:name"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'title', "id" => "paint_project_name", 'value' => $vars["entity"]->title)); ?>
        <span class="error_msg clear paint_name_err"></span>
    </div>

    <div class="span5">
        <label><?php echo elgg_echo("material_type:extra:type"); ?></label>
        <?php
        echo elgg_view("input/dropdown", array(
            "name" => "material_id",
            "id" => "material_id",
            "class" => "custom-select",
            "options_values" => $vars["material_id_values"],
            'value' => $vars["entity"]->material_id
        ));
        ?>
        <span class="error_msg clear material_id_err"></span>
    </div>
    <br/>
    <div class="clear"></div>
    <div class="span5">
        <label><?php echo elgg_echo("project:nopieces"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'nopieces', "id" => "nopieces", 'value' => $vars["entity"]->nopieces)); ?>
        <span class="error_msg clear nopieces_err"></span>
    </div>

    <div class="span5">
        <label><?php echo elgg_echo("project:lengthperpiece"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'lengthperpiece', "id" => "lengthperpiece", 'value' => $vars["entity"]->lengthperpiece)); ?>
        <span class="error_msg clear lengthperpiece_err"></span>
    </div>

    <div class="clear"></div>

    <?php
    if ($vars["entity"]->guid)
        echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars["entity"]->guid));
    ?>
    <div align="center" class="MT_two MB_three">
        
        <?php echo elgg_view('input/submit', array('name' => 'btn_paint_project_save', 'id' => 'btn_paint_project_save', 'class' => 'btn btn_submit MR_20', 'value' => elgg_echo('manager:save'))); ?>
        <?php echo elgg_view('input/button', array('name' => 'btn_paint_project_cancel', 'id' => 'btn_paint_project_cancel', "onclick" => "javascript:window.location.href='/painting_project/all'", 'class' => 'btn btn_submit_grey', 'value' => elgg_echo('certificate:cancel'))); ?><span class="ajx-submit-load disp-none"></span>
    </div>

    <br/><br/>
</div>
