<div class="cmp_enity nest_wrap rounded_corners frm_box_shadow frm_box_border span12 MT_one MB_three mger_add">
    <div class="span5">
        <label><?php echo elgg_echo("inventory:type"); ?></label>
        <?php
        echo elgg_view("input/dropdown", array(
            "name" => "inventory_type",
            "id" => "inventory_type_select",
            "class" => "custom-select",
            "options_values" => $vars["types"]
        ));
        ?>
        <span class="error_msg clear inventory_type_err"></span>
    </div>
    <div class="span5">
        <label><?php echo elgg_echo("item:name"); ?></label>
        <?php
        echo elgg_view("input/dropdown", array(
            "name" => "item_name",
            "id" => "item_name",
            "class" => "custom-select",
            "options_values" => $vars["materials"]
        ));
        ?>
        <span class="error_msg clear inventory_type_err"></span>
    </div>
    <div class="span5">
        <label><?php echo elgg_echo("item:code"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'item_code', "id" => "item_code")); ?>
        <span class="error_msg clear item_code_err"></span>
    </div>

    <div class="span5">
        <label><?php echo elgg_echo("item:place"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'place', "id" => "item_place")); ?>
        <span class="error_msg clear item_place_err"></span>
    </div>
    
    <div class="span5">
        <label><?php echo elgg_echo("item:invoice"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'invoice', "id" => "invoice")); ?>
        <span class="error_msg clear invoice_err"></span>
    </div>

    <div class="clear"></div>

    <div align="center" class="MT_two MB_three">
        <?php echo elgg_view('input/submit', array('name' => 'btn_inventory_save', 'id' => 'btn_inventory_save', 'class' => 'btn btn_submit MR_20', 'value' => elgg_echo('manager:save'))); ?>
        <?php echo elgg_view('input/button', array('name' => 'btn_inventory_cancel', 'id' => 'btn_inventory_cancel', "onclick" => "javascript:window.location.href='/'", 'class' => 'btn btn_submit_grey', 'value' => elgg_echo('certificate:cancel'))); ?><span class="ajx-submit-load disp-none"></span>
    </div>

    <br/><br/>
</div>
