<div class="cmp_enity rounded_corners frm_box_shadow frm_box_border span12 MT_one MB_three mger_add">   
        <?php if(elgg_is_admin_logged_in() && !($vars["company_id"])){ ?>
			 <div class="cmpsdprow column_left">
			            <label><?php echo elgg_echo("company:title"); ?></label>
			            <?php 
			                    echo elgg_view("input/dropdown", array(
			                            "name" => "company_id",	
			                            "id" => "company_id",
                                                    "class" => "custom-select-default",
			                            "options_values" => $vars["company_id_values"],
			                            'value' => $vars["company_id"]
			                    ));
			            ?>
			            <span class="error_msg clear company_id_err"></span>
			    </div>
			    <div class="clear"></div>
	        <?php  } ?>    
    <div class="cmpsrow frm_cmpr column_left">
        <label><?php echo elgg_echo("entity:name"); ?></label>
        <?php echo elgg_view('input/text', array(
            'name' => 'contact', 
            'id' => 'contact', 
            'class' => 'MR_one',
            'value' => $vars["entity"]->name
                )); ?>
        <span class="error_msg clear contact_err"></span>
    </div>
    <div class="frm_cmpr cmpsrow column_right">
        <label><?php echo elgg_echo("email"); ?></label>
        <?php 
        $contact_email_arr = array('name' => 'contact_email', 'id' => 'manager_email', 'value' => $vars["entity"]->email);
        if($vars["entity"]->guid) { 
          $contact_email_arr['readonly'] = "readonly";
        }
        ?>	            
        <?php echo elgg_view('input/text', $contact_email_arr); ?>
        <span class="error_msg clear manager_email_err"></span>
    </div>
    <div class="clear"></div>
    <div class="frm_cmpr cmpaddrow">
        <label><?php echo elgg_echo("company:contact_postal_address"); ?></label>
        <?php 
        $contact_postal_address_arr = array('name' => 'contact_postal_address', 'id' => 'contact_postal_address', 'value' => $vars["entity"]->street1);
       ?>	            
        <?php echo elgg_view('input/text', $contact_postal_address_arr); ?>
        <span class="error_msg clear contact_postal_address_err"></span>
    </div> 
    
	        <div class="frm_cmpr cmpsrow column_left">
	            <label><?php echo elgg_echo("company:town"); ?></label>
	            <?php echo elgg_view('input/text', array('name' => 'contact_town', 'id' => 'contact_town', 'value' => $vars["entity"]->town)); ?>
	            <span class="error_msg clear contact_town_err"></span>
	        </div>
	        <div class="frm_cmpr cmpsrow column_right">
	            <label><?php echo elgg_echo("profile:state"); ?></label>
	            <?php echo elgg_view('input/text', array('name' => 'contact_state', 'id' => 'contact_state', 'value' => $vars["entity"]->state)); ?>
	            <span class="error_msg clear contact_state_err"></span>
	        </div>
	        <div class="frm_cmpr cmpsrow column_left">
	            <label><?php echo elgg_echo("profile:postcode"); ?></label>
	            <?php echo elgg_view('input/text', array('name' => 'contact_postcode', 'id' => 'contact_postcode', 'value' => $vars["entity"]->postcode)); ?>
	            <span class="error_msg clear contact_postcode_err"></span>
	        </div>
	       <div class="frm_cmpr cmpsrow column_right">
	            <label><?php echo elgg_echo("company:country"); ?></label>
	            <?php echo elgg_view('input/text', array('name' => 'contact_country', 'id' => 'contact_country', 'value' => $vars["entity"]->country)); ?>
	        </div>
    <div class="clear"></div>
    <div align="center" class="MT_two MB_two cmpaddrow">
        <?php echo elgg_view('input/submit', array('name' => 'btn_manager_save', 'id' => 'btn_manager_save', 'class' => 'btn btn_submit MR_20', 'value' => elgg_echo('manager:save'))); ?>
        <?php echo elgg_view('input/button', array('name' => 'btn_manager_cancel', 'id' => 'btn_manager_cancel', "onclick"=>"javascript:window.location.href='/manager/all'",   'class' => 'btn btn_submit_grey', 'value' => elgg_echo('certificate:cancel'))); ?>
    </div>
	    </div>
	    <?php 
		    if ($vars["company_id"]) 
				echo elgg_view('input/hidden', array('name' => 'company_id', 'id' => 'company_id','value' => $vars["company_id"]));
			if ($vars["entity"]->guid)
				echo elgg_view('input/hidden', array('name' => 'guid', 'id' => 'guid', 'value' => $vars["entity"]->guid)); 
		?>   
</div>
