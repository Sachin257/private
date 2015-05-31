<div class="cmp_enity rounded_corners frm_box_shadow frm_box_border span12 MT_one MB_three mger_add">   
    
	<?php if(!($vars["profile_type_id"]) && !($vars["entity"]->custom_profile_type) ){ ?>
	<div class="frm_cmpr cmpaddrow">
        <label><?php echo elgg_echo("company:employee:type"); ?></label>
        	<?php 
                    echo elgg_view("input/dropdown", array(
                            "name" => "custom_profile_type",	
                            "id" => "custom_profile_type",
                            "class" => "custom-select-default",
                            "options_values" => $vars["profile_type_values"],
                            'value' => $vars["entity"]->custom_profile_type
                    ));
            ?>	            
        <span class="error_msg clear custom_profile_type_err"></span>
    </div>      
    <?php 
	} else if($vars["profile_type_id"]) { 
		echo elgg_view('input/hidden', array('name' => 'custom_profile_type', 'id' => 'custom_profile_type','value' => $vars["profile_type_id"]));
    }  else if($vars["entity"]->custom_profile_type) { 
		echo elgg_view('input/hidden', array('name' => 'custom_profile_type', 'id' => 'custom_profile_type','value' => $vars["entity"]->custom_profile_type));
	}
    ?>  
    <div class="cmpsrow frm_cmpr column_left">
        <label><?php echo elgg_echo("entity:name"); ?></label>
        <?php echo elgg_view('input/text', array(
            'name' => 'name', 
            'id' => 'name', 
            'class' => 'MR_one',
            'value' => $vars["entity"]->name
                )); ?>
        <span class="error_msg clear name_err"></span>
    </div>
    <div class="frm_cmpr cmpsrow column_right">
        <label><?php echo elgg_echo("email"); ?></label>
        <?php 
        $contact_email_arr = array('name' => 'email', 'id' => 'employee_email', 'value' => $vars["entity"]->email);
        if($vars["entity"]->guid) { 
          $contact_email_arr['readonly'] = "readonly";
        }
        ?>	            
        <?php echo elgg_view('input/text', $contact_email_arr); ?>
        <span class="error_msg clear employee_email_err"></span>
    </div>
    <div class="clear"></div>
    <div class="frm_cmpr cmpaddrow">
        <label><?php echo elgg_echo("company:contact_postal_address"); ?></label>
        <?php 
        $contact_postal_address_arr = array('name' => 'street1', 'id' => 'street1', 'value' => $vars["entity"]->street1);
       ?>	            
        <?php echo elgg_view('input/text', $contact_postal_address_arr); ?>
        <span class="error_msg clear  street1_err"></span>
    </div> 
    
	        <div class="frm_cmpr cmpsrow column_left">
	            <label><?php echo elgg_echo("company:town"); ?></label>
	            <?php echo elgg_view('input/text', array('name' => 'town', 'id' => 'town', 'value' => $vars["entity"]->town)); ?>
	            <span class="error_msg clear town_err"></span>
	        </div>
	        <div class="frm_cmpr cmpsrow column_right">
	            <label><?php echo elgg_echo("profile:state"); ?></label>
	            <?php echo elgg_view('input/text', array('name' => 'state', 'id' => 'state', 'value' => $vars["entity"]->state)); ?>
	            <span class="error_msg clear state_err"></span>
	        </div>
	        <div class="frm_cmpr cmpsrow column_left">
	            <label><?php echo elgg_echo("profile:postcode"); ?></label>
	            <?php echo elgg_view('input/text', array('name' => 'postcode', 'id' => 'postcode', 'value' => $vars["entity"]->postcode)); ?>
	            <span class="error_msg clear postcode_err"></span>
	        </div>
	       <div class="frm_cmpr cmpsrow column_right">
	            <label><?php echo elgg_echo("company:country"); ?></label>
	            <?php echo elgg_view('input/text', array('name' => 'country', 'id' => 'country', 'value' => $vars["entity"]->country)); ?>
	        </div>
    <div class="clear"></div>
    <div align="center" class="MT_two MB_two cmpaddrow">
        <?php echo elgg_view('input/submit', array('name' => 'btn_employee_save', 'id' => 'btn_employee_save', 'class' => 'btn btn_submit MR_20', 'value' => elgg_echo('manager:save'))); ?>
        <?php echo elgg_view('input/button', array('name' => 'btn_employee_cancel', 'onclick'=>"javascript:history.back(-1);", 'id' => 'btn_employee_cancel', 'class' => 'btn btn_submit_grey', 'value' => elgg_echo('certificate:cancel'))); ?>
    </div>
	    </div>
	    <?php 
		    if ($vars["company_id"]) 
				echo elgg_view('input/hidden', array('name' => 'company_id', 'id' => 'company_id','value' => $vars["company_id"]));
			if ($vars["entity"]->guid)
				echo elgg_view('input/hidden', array('name' => 'guid', 'id' => 'guid', 'value' => $vars["entity"]->guid)); 
		?>   
</div>
