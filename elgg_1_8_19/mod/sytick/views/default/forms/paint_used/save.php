<div class="cmp_enity nest_wrap rounded_corners frm_box_shadow frm_box_border span12 MT_one MB_three mger_add">

    <div class="span5">
        <label><?php echo elgg_echo("paint:select"); ?></label>
        <?php
        echo elgg_view("input/dropdown", array(
            "name" => "paint_id_name",
            "id" => "paint_id_name",
            "class" => "custom-select",
            "options_values" => $vars["paints"]
        ));
        ?>
        <span class="error_msg clear paint_id_name_err"></span>
    </div>

    <div class="span5">
        <label><?php echo elgg_echo("paint:amount"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'paint_amount', "id" => "paint_amount")); ?>
        <span class="clear error_msg paint_amount_err"></span>
    </div>
    
    <div class="span5">
        <label><?php echo elgg_echo("paint:name"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'title', "id" => "paint_name", "readonly" => TRUE)); ?>
        <span class="clear error_msg"></span>
    </div>

    <br/>

    <div class="span5">
        <label><?php echo elgg_echo("paint:id"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'paint_id', "id" => "paint_id", "readonly" => TRUE )); ?>
        <span class="clear error_msg"></span>
    </div>

    <div class="span5">
        <label><?php echo elgg_echo("paint:colour"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'colour', "id" => "paint_color" , "readonly" => TRUE)); ?>
        <span class="clear error_msg"></span>
    </div>

    <div class="span5">
        <label><?php echo elgg_echo("paint:current:quantity"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'quantity', "id" => "paint_quantity" , "readonly" => TRUE)); ?>
        <span class="clear error_msg"></span>
    </div>

    <div class="clear"></div>

    <div align="center" class="MT_two MB_three">
        <?php echo elgg_view('input/submit', array('name' => 'btn_paint_used_save', 'id' => 'btn_paint_used_save', 'class' => 'btn btn_submit MR_20', 'value' => elgg_echo('manager:save'))); ?>
        <?php echo elgg_view('input/button', array('name' => 'btn_paint_used_cancel', 'id' => 'btn_paint_used_cancel', "onclick" => "javascript:window.location.href='/paint_used/all'", 'class' => 'btn btn_submit_grey', 'value' => elgg_echo('certificate:cancel'))); ?><span class="ajx-submit-load disp-none"></span>
    </div>

    <br/>
</div>
