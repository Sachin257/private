
<div class="profile_box rounded_corners MB_five">
    <div class="nest_wrap">
        <label class="column_left"><?php echo elgg_echo('certificate:trade');?></label>
        <?php echo elgg_view('input/button', array('id' => 'btn_trade_add', 'data:id'=>CERTIFICATE_TYPE_TRADE,  'class' => 'column_right btn_submit_small', 'value' => elgg_echo('certificate:add'))); ?>
        <div class="cert_list rounded_corners clear">
        	<?php $vars['certificates'] = $vars["trade_certificates"];?>
        	<?php echo  elgg_view('user/blocks/certificate', $vars);?>
        </div>
    </div>
    <div class="nest_wrap MT_three">
        <label class="column_left"><?php echo elgg_echo('certificate:licenses');?></label>
        <?php echo elgg_view('input/button', array('id' => 'btn_license_add', 'data:id'=>CERTIFICATE_TYPE_LICENSE,  'class' => 'column_right btn_submit_small', 'value' => elgg_echo('certificate:add'))); ?>
        <div class="cert_list rounded_corners clear">
        	<?php $vars['certificates'] = $vars["license_certificates"];?>
        	<?php echo  elgg_view('user/blocks/certificate', $vars);?>
        </div>
    </div>
    <div class="nest_wrap MT_three">
        <label class="column_left"><?php echo elgg_echo('certificate:insurances');?></label>
        <?php echo elgg_view('input/button', array('id' => 'btn_insurance_add', 'data:id'=>CERTIFICATE_TYPE_INSURANCE,  'class' => 'column_right btn_submit_small', 'value' => elgg_echo('certificate:add'))); ?>
        <div class="cert_list rounded_corners clear">
        	<?php $vars['certificates'] = $vars["insurance_certificates"];?>
        	<?php echo  elgg_view('user/blocks/certificate', $vars);?>
        </div>
    </div>
    
</div>

<div class="modal fade" id="myCertificateModal" style="display: none;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="myModalLabel"><?php echo elgg_echo('certificate:add:popup:title');?> <?php echo $vars["entity"]->name;?></h1>
      </div>
      <div class="modal-body">
        <div id="addCertificate" class="userfileup clear span6">
		    <ul>
		        <li><?php echo elgg_echo('certificate:add:popup:line1');?></li>
		        <li><?php echo elgg_echo('certificate:add:popup:line2');?></li>
		        <li><?php echo elgg_echo('certificate:add:popup:line3');?></li>
		        <li><?php echo elgg_echo('certificate:add:popup:line4');?></li>
		    </ul>
		    <div class="nest_wrap">
		        <div class="userrow">
		            <label><?php echo elgg_echo('document_type:extra:type');?></label>
		            <?php 
						echo elgg_view("input/dropdown", array(
							"name" => "document_type",	
							"id" => "document_type",
                                                    "class" => "custom-select-default",
							"options_values" => $vars["document_type_values"]
						));
					?>
		        </div>
		        <span class="error_msg clear document_type_err"></span>
		        <div class="userrow daterow">
		            <label><?php echo elgg_echo('certificate:label:doi');?></label>
		            <?php echo elgg_view('input/date', array('id' => 'date_of_issue',  'name' => 'date_of_issue')); ?><a href="#" id="date_of_issue_lnk" class="calimage"></a>
		        </div>
		        <span class="error_msg clear date_of_issue_err"></span>
		        <div class="userrow daterow">
		            <label><?php echo elgg_echo('certificate:label:expiry');?></label>
		            <?php echo elgg_view('input/date', array('id' => 'date_of_expiry', 'name' => 'date_of_expiry')); ?><a href="#" id="date_of_expiry_lnk" class="calimage"></a>
		        </div>
		        <span class="error_msg clear date_of_expiry_err"></span>
		        <div class="userrow">
		            <label><?php echo elgg_echo('certificate:label:id');?></label>
		            <?php echo elgg_view('input/text', array('id' => 'certificate_id', 'name' => 'certificate_id')); ?>
		        </div>
		        <span class="error_msg clear certificate_id_err"></span>
                <div class="clear"></div>
		        <div class="userrow">
		            <label><?php echo elgg_echo('certificate:label:upload');?></label>
		            <?php echo elgg_view('input/file', array('id' => 'certificate_upload', 'name' => 'certificate_upload')); ?>
		        </div>
		        <span class="error_msg clear certificate_upload_err"></span>
		        <div class="userrow">
		            <label><?php echo elgg_echo('certificate:label:comments');?></label>
		            <textarea id="comments" name="comments"></textarea>
		            <?php echo elgg_view('input/hidden', array('id' => 'certificate_type', 'name' => 'certificate_type')); ?>
		        </div>
		    </div>
		</div>      
      </div>
        <div align="center" class="MT_two">
	      <?php 
				echo elgg_view('input/hidden', array('name' => 'guid', 'id' => 'guid'));
				echo elgg_view('input/hidden', array('name' => 'file_guid', 'id' => 'file_guid')); 
		  ?>	
		  <?php 
				echo elgg_view('input/hidden', array('name' => 'user_guid', 'id' => 'user_guid', 'value'=>$vars["entity"]->guid)); 
		  ?>
      	<?php echo elgg_view('input/button', array('id' => 'btn_cert_save', "class"=>"btn btn-default btn_submit_grey", 'value' => elgg_echo('certificate:add'))); ?>
      	<?php echo elgg_view('input/button', array('id' => 'btn_cert_cancel', "data-dismiss"=>"modal", "class"=>"btn btn-default btn_submit_grey", 'value' => elgg_echo('certificate:cancel'))); ?><span class="ajx-submit-load disp-none"></span>
      </div>
    </div>
  </div>
</div>

