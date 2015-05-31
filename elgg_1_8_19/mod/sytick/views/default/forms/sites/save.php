<div class="cmp_enity nest_wrap frm_box_shadow frm_box_border MB_three sites_add">
  
    		<div class="span5 MT_one">
	            <label><?php echo elgg_echo("entity:name"); ?></label>
	            <?php echo elgg_view('input/text', array('name' => 'site_name', 'id' => 'site_name', 'value' => $vars["entity"]->title)); ?>
	            <span class="error_msg clear site_name_err"></span>
	        </div>
       	<?php if(elgg_is_admin_logged_in() && !($vars["entity"]->company_guid)){ ?>
    		<div class="span5 MT_one">
	            <label><?php echo elgg_echo("company:title"); ?></label>
	            <?php 
						echo elgg_view("input/dropdown", array(
							"name" => "company_id",	
							"id" => "sites_company_id",
                                                        "class" => "custom-select-default",
							"options_values" => $vars["company_id_values"],
							'value' => $vars["entity"]->company_guid
						));
					?>
	            <span class="error_msg clear sites_company_id_err"></span>
	        </div>
	        <?php  } ?>	        
	        <div class="span5 MT_one">
	            <label><?php echo elgg_echo("enitiy:project"); ?></label>	            
					<?php 
						echo elgg_view("input/dropdown", array(
							"name" => "project_id",	
							"id" => "project_id",
                                                        "class" => "custom-select-default",
							"options_values" => $vars["projects_id_values"],
                            'value' => $vars["entity"]->project_guid
						));                                      
					?>
	            <span class="error_msg clear project_id_err"></span>
	        </div>  
	        <div class="span5">
	            <label><?php echo elgg_echo("entity:sitemanager"); ?></label>	
	            	<div id="admin_sitemanager">
	            		<?php 
							echo elgg_view("input/checkboxes", array(
								"name" => "sitemanager_id",	
								"id" => "sitemanager_id",		
								"options" => $vars["sitemanager_id_values"],
	                            'value' => $vars["current_sitemanagers"]
							));                                      
						?>
	            	</div>		
	            <span class="error_msg clear sitemanager_id_err"></span>
	        </div>   
	         <div class="span5">
	            <label><?php echo elgg_echo("entity:documenttype"); ?></label>	            
					<?php 
						echo elgg_view("input/checkboxes", array(
							"name" => "documenttype_id",	
							"id" => "documenttype_id",		
							"options" => $vars["document_type_values"],
                            'value' => $vars["current_documenttypes"]
						));                                      
					?>
	            <span class="error_msg clear documenttype_id_err"></span>
	        </div>  
	        <div class="span4">
	            <label><?php echo elgg_echo('certificate:label:upload');?></label>
	            <?php echo elgg_view('input/file', array('id' => 'site_layout', 'name' => 'site_layout')); ?>
	            <span class="error_msg clear site_layout_err"></span>
	        </div>
	        <div class="span4">
	            <label><?php echo elgg_echo("entity:description"); ?>
	             <textarea id = 'site_description' name = 'site_description'><?php echo $vars["entity"]->description;?></textarea>
	            <span class="error_msg clear description_err"></span>
	        </div>

	    <?php 
	    	if($vars['file_guid'])
	    		echo elgg_view('input/hidden', array('name' => 'file_guid', 'id' => 'file_guid','value' => $vars["file_guid"]));
		    if ($vars["entity"]->company_guid) {
				echo elgg_view('input/hidden', array('name' => 'company_id', 'id' => 'sites_company_id','value' => $vars["entity"]->company_guid));
			} else if($vars["company_id"]) {
				echo elgg_view('input/hidden', array('name' => 'company_id', 'id' => 'sites_company_id','value' => $vars["company_id"]));
			}
			if ($vars["entity"]->guid)
				echo elgg_view('input/hidden', array('name' => 'guid', 'id' => 'guid', 'value' => $vars["entity"]->guid)); 
		?>
	<div class="clear"></div>
    <div align="center" class="MT_two MB_three">
        <?php echo elgg_view('input/submit', array('name' => 'btn_sites_save', 'id' => 'btn_sites_save', 'class' => 'btn btn_submit MR_20', 'value' => elgg_echo('manager:save'))); ?>
        <?php echo elgg_view('input/button', array('name' => 'btn_sites_cancel', 'id' => 'btn_sites_cancel', "onclick"=>"javascript:window.location.href='/sites/all'",  'class' => 'btn btn_submit_grey', 'value' => elgg_echo('certificate:cancel'))); ?><span class="ajx-submit-load disp-none"></span>
    </div>
</div>
