<div class="cmp_enity nest_wrap rounded_corners frm_box_shadow frm_box_border span12 MT_one MB_three mger_add">
    <?php
    if(!$vars["key"]){
        
    ?>
    <div class="span5">
        <label><?php echo elgg_echo("inventory:type"); ?></label>
        <?php
        echo elgg_view("input/dropdown", array(
            "name" => "inventory_type",
            "id" => "inventory_type",
            "class" => "custom-select",
            "options_values" => $vars["inventory_types"],
            'value' => $vars["key"]
        ));
        ?>
        <span class="error_msg clear inventory_type_err"></span>
    </div>
    <?php } ?>
    <div class="span5">
        <label><?php echo elgg_echo("item:code"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'item_code', "id" => "item_code", 'value' => $vars["entity"]->item_code)); ?>
        <span class="error_msg clear item_code_err"></span>
    </div>
    
    <div class="span5">
        <label><?php echo elgg_echo("item:name"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'title', "id" => "item_name", 'value' => $vars["entity"]->title)); ?>
        <span class="error_msg clear item_name_err"></span>
    </div>

    <div class="span5">
        <label><?php echo elgg_echo("item:length"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'length', "id" => "item_length", 'value' => $vars["entity"]->length)); ?>
        <span class="error_msg clear item_length_err"></span>
    </div>
    
    <div class="span5">
        <label><?php echo elgg_echo("item:weight"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'weight', "id" => "item_weight", 'value' => $vars["entity"]->weight)); ?>
        <span class="error_msg clear item_weight_err"></span>
    </div>

    <div class="span5">
        <label><?php echo elgg_echo("item:price"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'price', "id" => "item_price", 'value' => $vars["entity"]->price)); ?>
        <span class="error_msg clear item_price_err"></span>
    </div>

    <div class="clear"></div>

    <?php
    if ($vars["entity"]->guid){
        echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars["entity"]->guid));
    }if ($vars["key"]){
        echo elgg_view('input/hidden', array('name' => 'inventory_type', "id" => "inventory_type", 'value' => $vars["key"]));
    }
    
    ?>
    <div align="center" class="MT_two MB_three">
        <?php echo elgg_view('input/submit', array('name' => 'btn_item_save', 'id' => 'btn_item_save', 'class' => 'btn btn_submit MR_20', 'value' => elgg_echo('manager:save'))); ?>
        <?php echo elgg_view('input/button', array('name' => 'btn_item_cancel', 'id' => 'btn_item_cancel', "onclick" => "javascript:window.location.href='/inventory/all'", 'class' => 'btn btn_submit_grey', 'value' => elgg_echo('certificate:cancel'))); ?><span class="ajx-submit-load disp-none"></span>
    </div>

    <br/><br/>
</div>
