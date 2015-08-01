<div class="nest_wrap cmp_enity rounded_corners frm_box_shadow frm_box_border">    
    
    <div class="span4">
        <label><?php echo elgg_echo("company:extra:abn"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'abn', 'id' => 'abn', "tabindex" => 1, 'value' => $vars["entity"]->abn)); ?>
        <span class="error_msg clear abn_err"></span>
    </div>
    
    <div class="span4">
        <label><?php echo elgg_echo("company:entity_name"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'title', 'id' => 'entity_name', "tabindex" => 2, 'value' => $vars["entity"]->title)); ?>
        <span class="error_msg clear entity_name_err"></span>
    </div>
    
    <div class="span4">
        <label><?php echo elgg_echo("company:trading_name"); ?></label>
        <?php echo elgg_view('input/text', array('name' => 'trading_name', 'id' => 'trading_name', "tabindex" => 3, 'value' => $vars["entity"]->trading_name)); ?>
    </div>
    
    

</div>

<div class="cmp_enity nest_wrap rounded_corners frm_box_shadow frm_box_border span12 MT_one MB_three">
    <div class="span8">
        <div class="span4 MR_20">
            <label><?php echo elgg_echo("company:contact"); ?></label>
            <?php echo elgg_view('input/text', array('name' => 'contact', 'id' => 'contact', "tabindex" => 4, 'value' => $vars["entity"]->contact)); ?>
            <span class="error_msg clear contact_err"></span>
        </div>
        <div class="span4">
            <label><?php echo elgg_echo("email"); ?></label>
            <?php echo elgg_view('input/text', array('name' => 'contact_email', 'id' => 'contact_email', "tabindex" => 5, 'value' => $vars["entity"]->contact_email)); ?>
            <span class="error_msg clear contact_email_err"></span>
        </div>
        <div class="span4 MR_20">
            <label><?php echo elgg_echo("company:street_address"); ?></label>
            <?php //echo elgg_view('input/text', array('name' => 'street_address', 'id' => 'street_address', 'value' => $vars["entity"]->contact_email)); ?>
            <textarea id = 'street_address' name = 'street_address' tabindex=6 ><?php echo $vars["entity"]->street_address;?></textarea>
            <span class="error_msg clear street_address_err"></span>
        </div>
        <div class="span4">
            <label><?php echo elgg_echo("company:contact_postal_address"); ?> <?php echo elgg_view('input/checkbox', array('id' => 'same_as_company' , "tabindex" => 11)); ?><span><?php echo elgg_echo("company:same:as_company");?></span></label>
            <?php //echo elgg_view('input/text', array('name' => 'street_address', 'id' => 'street_address', 'value' => $vars["entity"]->contact_email)); ?>
            <textarea id = 'contact_postal_address' name = 'contact_postal_address' tabindex=12><?php echo $vars["entity"]->contact_postal_address;?></textarea>
            <span class="error_msg clear contact_postal_address_err"></span>
        </div>
        <div class="span4 MR_20">
            <label><?php echo elgg_echo("company:town"); ?></label>
            <?php echo elgg_view('input/text', array('name' => 'town', 'id' => 'town', "tabindex" => 7, 'value' => $vars["entity"]->town)); ?>
            <span class="error_msg clear town_err"></span>
        </div>
        <div class="span4">
            <label><?php echo elgg_echo("company:town"); ?></label>
            <?php echo elgg_view('input/text', array('name' => 'contact_town', 'id' => 'contact_town', "tabindex" => 13, 'value' => $vars["entity"]->contact_town)); ?>
            <span class="error_msg clear contact_town_err"></span>
        </div>
        <div class="span4 MR_20">
            <label><?php echo elgg_echo("profile:state"); ?></label>
            <?php echo elgg_view('input/text', array('name' => 'state', 'id' => 'state', "tabindex" => 8, 'value' => $vars["entity"]->state)); ?>
            <span class="error_msg clear state_err"></span>
        </div>
        <div class="span4">
            <label><?php echo elgg_echo("profile:state"); ?></label>
            <?php echo elgg_view('input/text', array('name' => 'contact_state', 'id' => 'contact_state', "tabindex" => 14, 'value' => $vars["entity"]->contact_state)); ?>
            <span class="error_msg clear contact_state_err"></span>
        </div>
        <div class="span4 MR_20">
            <label><?php echo elgg_echo("profile:postcode"); ?></label>
            <?php echo elgg_view('input/text', array('name' => 'postcode', 'id' => 'postcode', "tabindex" => 9, 'value' => $vars["entity"]->postcode)); ?>
            <span class="error_msg clear postcode_err"></span>
        </div>
        <div class="span4">
            <label><?php echo elgg_echo("profile:postcode"); ?></label>
            <?php echo elgg_view('input/text', array('name' => 'contact_postcode', 'id' => 'contact_postcode', "tabindex" => 15, 'value' => $vars["entity"]->contact_postcode)); ?>
            <span class="error_msg clear contact_postcode_err"></span>
        </div>
        <div class="span4 MR_20">
            <label><?php echo elgg_echo("company:country"); ?></label>
            <?php echo elgg_view('input/text', array('name' => 'country', 'id' => 'country', "tabindex" => 10, 'value' => $vars["entity"]->country)); ?>
        </div>
       <div class="span4">
            <label><?php echo elgg_echo("company:country"); ?></label>
            <?php echo elgg_view('input/text', array('name' => 'contact_country', 'id' => 'contact_country', "tabindex" => 16, 'value' => $vars["entity"]->contact_country)); ?>
        </div>
        <?php 
        if ($vars["entity"]->guid) {
        ?>
        <div class="span4 MR_20">
            <label><?php echo elgg_echo("company:logo"); ?></label>
            <?php echo elgg_view('input/file', array('name' => 'logo', 'id' => 'logo')); ?>
             <span class="error_msg clear logo_err"></span>
        </div>
        <?php } ?>
    </div>
    
    <div class="span4">
        <div class="cmp_contact">
            <label><?php echo elgg_echo("company:telephone"); ?></label>
            <span><?php echo elgg_view('input/text', array('name' => 'telephone_area_code', "placeholder"=>elgg_echo("company:telephone:area_code"), 'id' => 'telephone_area_code', "tabindex" => 17, 'value' => $vars["entity"]->telephone_area_code)); ?></span>
            <?php echo elgg_view('input/text', array('name' => 'telephone', "placeholder"=>elgg_echo("company:telephone:number"), 'id' => 'telephone', "tabindex" => 18, 'value' => $vars["entity"]->telephone)); ?>
        </div>
        <div class="cmp_contact MT_three">
            <label><?php echo elgg_echo("company:fax"); ?></label>
            <span><?php echo elgg_view('input/text', array('name' => 'fax_area_code', "placeholder"=>elgg_echo("company:telephone:area_code"), 'id' => 'fax_area_code', "tabindex" => 19, 'value' => $vars["entity"]->fax_area_code)); ?></span>
            <?php echo elgg_view('input/text', array('name' => 'fax', 'id' => 'fax', "placeholder"=>elgg_echo("company:telephone:number"), "tabindex" => 20, 'value' => $vars["entity"]->fax)); ?>
        </div>
        <div class="cmp_contact MT_three">
            <label><?php echo elgg_echo("profile:mobile"); ?></label>
            <span><?php echo elgg_view('input/text', array('name' => 'mobile_area_code', "placeholder"=>elgg_echo("company:telephone:area_code"), 'id' => 'mobile_area_code', "tabindex" => 21, 'value' => $vars["entity"]->mobile_area_code)); ?></span>
            <?php echo elgg_view('input/text', array('name' => 'mobile', 'id' => 'mobile', "placeholder"=>elgg_echo("company:telephone:number"), "tabindex" => 22, 'value' => $vars["entity"]->mobile)); ?>
        </div>
        <?php if ($vars["entity"]->guid) {
              if($vars['company_type']==2){?>
        <div class="nest_wrap" style="margin-top: 10px;">
        <label class="column_left"><?php echo elgg_echo('job_type:list');?></label>
            <div class="rounded_corners clear" style="height: 275px; border: 1px solid #cfcfcf; background: none repeat scroll 0 0 #fff; overflow: auto; ">
            		<?php 
						echo elgg_view("input/checkboxes", array(
							"name" => "job_type",			
							"options" => $vars["job_type_values"],
                                                        'value' => $vars["current_job_types"]
						));                                      
					?>
            </div>
        </div>
        <?php }}?>
    </div>
    
<div class="clear"></div>

<?php 
	echo elgg_view('input/hidden', array('name' => 'company_type', 'id' => 'company_type','value' => $vars["company_type"]));
	if ($vars["file_guid"])
		echo elgg_view('input/hidden', array('name' => 'file_guid', 'id' => 'file_guid', 'value' => $vars["file_guid"]));
	if ($vars["entity"]->guid)
		echo elgg_view('input/hidden', array('name' => 'guid', 'id' => 'guid', 'value' => $vars["entity"]->guid)); 
	if ($vars["entity"]->contact_id)
		echo elgg_view('input/hidden', array('name' => 'contact_id', 'id' => 'contact_id','value' => $vars["entity"]->contact_id));
	
?>
    <div align="center" class="MT_two MB_three">
        <?php echo elgg_view('input/submit', array('name' => 'btn_company_save', 'id' => 'btn_company_save', 'class' => 'btn btn_submit MR_20', 'value' => elgg_echo('company:save'))); ?>
        <?php 
        $cancel_arr = array('name' => 'btn_company_cancel', 'id' => 'btn_company_cancel', 'class' => 'btn btn_submit_grey', 'value' => elgg_echo('certificate:cancel'));
        $cancel_url = "";
        if($vars["company_type"] == CONSTRUCTION_TYPE_COMPANY) {
			$cancel_url = "/company/all/".CONSTRUCTION_TYPE_COMPANY;
			$cancel_arr['onclick'] = "javascript:window.location.href='".$cancel_url."'";
		} else if($vars["company_type"] == CONTRACTING_TYPE_COMPANY){
			$cancel_url = "/company/all/".CONTRACTING_TYPE_COMPANY;
			$cancel_arr['onclick'] = "javascript:window.location.href='".$cancel_url."'";
		} else {
			$cancel_arr['onclick'] = "javascript:history.back(-1);";
		}
        ?>
        <?php echo elgg_view('input/button', $cancel_arr); ?><span class="ajx-submit-load disp-none"></span>
    </div>
</div>

