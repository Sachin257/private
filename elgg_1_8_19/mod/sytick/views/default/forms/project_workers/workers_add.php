<?php //print "<pre>";print_r($vars['contracting_companies']) ;print "</pre>"; //exit; ?>
<div class="modal fade" id="wrkrs_add_popup" style="display: none;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="myModalLabel"><?php echo elgg_echo('project:workers:add');?></h1>
      </div>
      <div class="modal-body">
        <div id="addQuestion" class="userfileup clear span6">		    
		    <div class="nest_wrap">
		        <div class="userrow">
		            <label><?php echo elgg_echo('entity:contracting:company');?></label>
		            <?php 
						echo elgg_view("input/dropdown", array(
							"name" => "contracting_company_id",	
							"id" => "contracting_company_id",
                                                        "class" => "custom-select",
							"options_values" => $vars["contracting_companies"]
						));
					?>
		        </div>
		        <span class="error_msg clear contracting_company_err"></span>
		        <div class="userrow">
		            <label><?php echo elgg_echo('entity:projectmanagers');?></label>
		          <div id="dv_prj_mangrs" class="rounded_corners clear" style="height: 100px; border: 1px solid #cfcfcf; background: none repeat scroll 0 0 #fff; overflow: auto; ">
            		
                  </div>       
		        </div>
		        <span class="error_msg clear prj_mgrs_err"></span>
		        <div class="userrow">
		            <label><?php echo elgg_echo('entity:contractors');?></label>
		            <div id="dv_contractors" class="rounded_corners clear" style="height: 100px; border: 1px solid #cfcfcf; background: none repeat scroll 0 0 #fff; overflow: auto; ">
            		
                    </div>       
		        </div>
		        <span class="error_msg clear contractors_err"></span>
		    </div>
		</div>      
      </div>
        <div align="center" class="MT_two">
	      <?php 
				echo elgg_view('input/hidden', array('name' => 'project_guid', 'id' => 'project_guid', "value" => $vars["entity"]->guid));								 
		  ?>	
		<?php echo elgg_view('input/submit', array('id' => 'btn_workers_save', "class"=>"btn btn-default btn_submit_grey", 'value' => elgg_echo('certificate:add'))); ?>
      	<?php echo elgg_view('input/button', array('id' => 'btn_quest_cancel', "data-dismiss"=>"modal", "class"=>"btn btn-default btn_submit_grey", 'value' => elgg_echo('certificate:cancel'))); ?><span class="ajx-submit-load disp-none"></span>
      </div>
    </div>
  </div>
</div>
