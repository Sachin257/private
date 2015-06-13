<div class="cmp_enity nest_wrap rounded_corners frm_box_shadow frm_box_border span12 MT_one MB_three mger_add">

<div class="span5">
    <label><?php echo elgg_echo("paint:name"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'title', "id"=>"paint_name" , 'value' => $vars["entity"]->title)); ?>
    <span class="error_msg clear paint_name_err"></span>
</div>

<br/>

<div class="span5">
    <label><?php echo elgg_echo("paint:id"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'paint_id', "id"=>"paint_id" , 'value' => $vars["entity"]->paint_id)); ?>
    <span class="error_msg clear paint_id_err"></span>
</div>

<br/>

<div class="span5">
    <label><?php echo elgg_echo("paint:colour"); ?></label>
   <?php echo elgg_view('input/text', array('name' => 'colour', "id"=>"paint_color" , 'value' => $vars["entity"]->colour)); ?>
    <span class="error_msg clear paint_color_err"></span>
</div>
<br/>

<div class="span5">
    <label><?php echo elgg_echo("paint:price"); ?></label>
   <?php echo elgg_view('input/text', array('name' => 'price', "id"=>"paint_price" , 'value' => $vars["entity"]->price)); ?>
    <span class="error_msg clear paint_price_err"></span>
</div>
<br/>

<div class="span5">
    <label><?php if ($vars["entity"]->guid) { 
                    echo elgg_echo("paint:current:quantity");
                    $disabled = TRUE;
                } else {
                    echo elgg_echo("paint:quantity");
                    $disabled = FALSE;
                } ?></label>
   <?php echo elgg_view('input/text', array('name' => 'quantity', "id"=>"paint_quantity" , 'value' => $vars["entity"]->quantity , 'disabled' => $disabled)); ?>
    <span class="error_msg clear paint_quantity_err"></span>
</div>
<?php if ($vars["entity"]->guid) { ?>
<div class="span5">
    <label><?php echo elgg_echo("additional:stock");?></label> 
    <?php echo elgg_view('input/text', array('name' => 'additional', "id"=>"paint_additional", 'value' => 0)); ?>
    <span class="error_msg clear paint_additional_err"></span>
</div>
<?php }?>

<div class="span5">
    <label><?php echo elgg_echo("minimum:stock");?></label> 
    <?php echo elgg_view('input/text', array('name' => 'alert_threshold', "id"=>"alert_threshold", 'value' => $vars["entity"]->threshold)); ?>
    <span class="error_msg clear alert_threshold_err"></span>
</div>

<div class="clear"></div>

<?php 
	if ($vars["entity"]->guid)
		echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars["entity"]->guid)); 
?>
    <div align="center" class="MT_two MB_three">
    <?php echo elgg_view('input/submit', array('name' => 'btn_paint_save', 'id' => 'btn_paint_save', 'class' => 'btn btn_submit MR_20', 'value' => elgg_echo('manager:save'))); ?>
    <?php echo elgg_view('input/button', array('name' => 'btn_paint_cancel', 'id' => 'btn_paint_cancel', "onclick"=>"javascript:window.location.href='/paint/all'", 'class' => 'btn btn_submit_grey', 'value' => elgg_echo('certificate:cancel'))); ?><span class="ajx-submit-load disp-none"></span>
</div>

<br/><br/>
</div>
