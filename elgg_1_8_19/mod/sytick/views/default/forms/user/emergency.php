<div class="profile_box rounded_corners column_left edt_profile">
    <label><?php echo elgg_echo("profile:firstname"); ?><sup>*</sup></label>
    <?php echo elgg_view('input/text', array('id' => 'name', 'name' => 'name', 'value' => $vars["emergency_contact"]->name)); ?>

<span class="error_msg clear name_err"></span>



    <label><?php echo elgg_echo("profile:middlename"); ?></label>
    <?php echo elgg_view('input/text', array('id' => 'middlename', 'name' => 'middlename', 'value' => $vars["emergency_contact"]->middlename)); ?>

<span class="error_msg clear middle_err"></span>

    <label><?php echo elgg_echo("profile:lastname"); ?><sup>*</sup></label>
    <?php echo elgg_view('input/text', array('id' => 'lastname', 'name' => 'lastname', 'value' => $vars["emergency_contact"]->lastname)); ?>
<span class="error_msg clear lastname_err"></span>
</div>

<div class="profile_box rounded_corners column_right edt_profile">
    <label><?php echo elgg_echo("email"); ?></label>
    <?php echo elgg_view('input/text', array('id' => 'email', 'name' => 'email', 'value' => $vars["emergency_contact"]->email)); ?>
<span class="error_msg clear email_err"></span>
    <label><?php echo elgg_echo("profile:mobile"); ?></label>
    <?php echo elgg_view('input/text', array('id' => 'mobile','name' => 'mobile', 'value' => $vars["emergency_contact"]->mobile)); ?>

<span class="error_msg clear mobile_err"></span>

    <label><?php echo elgg_echo("profile:homephone"); ?></label>
    <?php echo elgg_view('input/text', array('id' => 'homephone', 'name' => 'homephone', 'value' => $vars["emergency_contact"]->homephone)); ?>
<span class="error_msg clear homephone_err"></span>
</div>
<div class="clear"></div>
<div class="profile_box rounded_corners column_left MT_three MB_one edt_profile">
    <label><?php echo elgg_echo("profile:street1"); ?><sup>*</sup></label>
    <?php echo elgg_view('input/text', array('id' => 'street1', 'name' => 'street1', 'value' => $vars["emergency_contact"]->street1)); ?>

<span class="error_msg clear street1_err"></span>

    <label><?php echo elgg_echo("profile:street2"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'street2', 'value' => $vars["emergency_contact"]->street2)); ?>

    <label><?php echo elgg_echo("profile:town"); ?><sup>*</sup></label>
    <?php echo elgg_view('input/text', array('id' => 'town', 'name' => 'town', 'value' => $vars["emergency_contact"]->town)); ?>

<span class="error_msg clear town_err"></span>

    <label><?php echo elgg_echo("profile:state"); ?><sup>*</sup></label>
    <?php echo elgg_view('input/text', array('id' => 'state', 'name' => 'state', 'value' => $vars["emergency_contact"]->state)); ?>

<span class="error_msg clear state_err"></span>

    <label><?php echo elgg_echo("profile:postcode"); ?><sup>*</sup></label>
    <?php echo elgg_view('input/text', array('id' => 'postcode', 'name' => 'postcode', 'value' => $vars["emergency_contact"]->postcode)); ?>

<span class="error_msg clear postcode_err"></span>

<?php 
	if ($vars["emergency_contact"]->guid)
		echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars["emergency_contact"]->guid)); 
?>
<?php 
	if ($vars["entity"]->guid)
		echo elgg_view('input/hidden', array('name' => 'user_guid', 'value' => $vars["entity"]->guid)); 
?>

    
</div>
<div class="clear"></div>
<div align="center" class="MT_three MB_five"><?php echo elgg_view('input/submit', array('id' => 'btn_save', 'name' => 'btn_save', 'class' => 'btn_submit', 'value' => elgg_echo('profile:save:title'))); ?></div>
