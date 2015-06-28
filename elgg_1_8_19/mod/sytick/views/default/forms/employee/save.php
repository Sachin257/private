<div class="cmp_enity nest_wrap rounded_corners frm_box_shadow frm_box_border span12 MT_one MB_three mger_add">

    <div class="span5">
        <label><?php echo elgg_echo("entity:name"); ?></label>
        <?php
        echo elgg_view('input/text', array('name' => 'name', 'id' => 'name', 'class' => 'MR_one', 'value' => $vars["entity"]->name));
        ?>
        <span class="error_msg clear name_err"></span>
    </div>
    
    <div class="span5">
        <label><?php echo elgg_echo("company:contact_postal_address"); ?></label>
        <?php
        $contact_postal_address_arr = array('name' => 'street1', 'id' => 'street1', 'value' => $vars["entity"]->street1);
        ?>	            
        <?php echo elgg_view('input/text', $contact_postal_address_arr); ?>
        <span class="error_msg clear  street1_err"></span>
    </div>
    <div class="span5">
        <label><?php echo elgg_echo('entity:joined:date');?></label>
	<?php echo elgg_view('input/date', array('id' => 'date_of_join',  'name' => 'date_of_join', 'value' => $vars["entity"]->date_of_join)); ?><a href="#" id="date_of_issue_lnk" class="calimage"></a>
        <span class="error_msg clear  street1_err"></span>
    </div>
    <div class="span5">
        <label><?php echo elgg_echo('entity:designation');?></label>
	<?php echo elgg_view('input/text', array('name' => 'designation', 'id' => 'designation', 'value' => $vars["entity"]->designation)); ?>
        <span class="error_msg clear  street1_err"></span>
    </div>
    <div class="span5">
        <label><?php echo elgg_echo("entity:password"); ?></label>
        <?php echo elgg_view('input/password', array('name' => 'pass', 'id' => 'pass')); ?>
        <span class="error_msg clear pass_err"></span>
    </div>
    <div class="span5">
        <label><?php echo elgg_echo("entity:confirm:password"); ?></label>
        <?php echo elgg_view('input/password', array('name' => 'confpass', 'id' => 'confpass')); ?>
        <span class="error_msg clear confpass_err"></span>
    </div>
    <div class="clear"></div>
    <div align="center" class="MT_two MB_two cmpaddrow">
    <?php echo elgg_view('input/submit', array('name' => 'btn_employee_save', 'id' => 'btn_employee_save', 'class' => 'btn btn_submit MR_20', 'value' => elgg_echo('manager:save'))); ?>
    <?php echo elgg_view('input/button', array('name' => 'btn_employee_cancel', 'onclick' => "javascript:history.back(-1);", 'id' => 'btn_employee_cancel', 'class' => 'btn btn_submit_grey', 'value' => elgg_echo('certificate:cancel'))); ?>
    </div>
</div>
<?php
if ($vars["entity"]->guid)
    echo elgg_view('input/hidden', array('name' => 'guid', 'id' => 'guid', 'value' => $vars["entity"]->guid));
?>   
</div>
