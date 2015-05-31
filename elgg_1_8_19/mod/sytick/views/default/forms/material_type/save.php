<div class="cmp_enity nest_wrap rounded_corners frm_box_shadow frm_box_border span12 MT_one MB_three mger_add">

<div class="span5">
    <label><?php echo elgg_echo("title"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'title', "id"=>"material_title", 'value' => $vars["entity"]->title)); ?>
    <span class="error_msg clear material_type_name_err"></span>
</div>

<div class="span5">
    <label><?php echo elgg_echo("material_type:perimeter"); ?></label>
   <?php echo elgg_view('input/text', array('name' => 'perimeter', "id"=>"perimeter" , 'value' => $vars["entity"]->perimeter)); ?>
    <span class="error_msg clear perimeter_err"></span>
</div>
<br/>

<div class="span5">
    <label><?php echo elgg_echo("material_type:price"); ?></label>
   <?php echo elgg_view('input/text', array('name' => 'price', "id"=>"price" , 'value' => $vars["entity"]->price)); ?>
    <span class="error_msg clear price_err"></span>
</div>

<div class="span5">
    <label><?php echo elgg_echo("description"); ?></label>
    <textarea id = 'description' name = 'description'><?php echo $vars["entity"]->description;?></textarea>
    <span class="error_msg clear"></span>
</div>

<?php 
	if ($vars["entity"]->guid)
		echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars["entity"]->guid)); 
?>
<div align="center" class="MT_two MB_three">
    <?php echo elgg_view('input/submit', array('name' => 'btn_material_type_save', 'id' => 'btn_material_type_save', 'class' => 'btn btn_submit MR_20', 'value' => elgg_echo('manager:save'))); ?>
    <?php echo elgg_view('input/button', array('name' => 'btn_material_type_cancel', 'id' => 'btn_material_type_cancel', "onclick"=>"javascript:window.location.href='/material_type/all'", 'class' => 'btn btn_submit_grey', 'value' => elgg_echo('certificate:cancel'))); ?><span class="ajx-submit-load disp-none"></span>
</div>

<br/><br/>
</div>