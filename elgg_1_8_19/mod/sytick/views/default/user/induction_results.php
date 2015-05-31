
      <div class="nest_wrap">
		<div class="userrow">
		<div class="clear"></div>
			<div class="userrow">
				<label style="width:100%;"><?php echo $vars['title'];?></label>
		        <div id="question_title"></div>		            
		    </div>
                <div style="height:300px; overflow: auto;">
                <table class="elgg-list elgg-list-entity mgr_list">	
		<tbody>
		<tr>
			
                        <th style="width: 50%"><?php echo elgg_echo('entity:attented:on')?></th>
			<th style="width: 50%"><?php echo elgg_echo('entity:screen:status')?></th>
		</tr>
                
                
                   <?php  $number_of_attempts = count($vars['induction_results']);
                   foreach($vars['induction_results'] as $induction_result)
                   {                   ?>        
                    <tr>               		            
		    
                    <td><?php echo gmdate("F j, Y, g:i a", $induction_result->last_action);?></td>
                    
		    
                    <td><?php echo ($induction_result->screen_status) ? elgg_echo('entity:screen:yes'): elgg_echo('entity:screen:no');?></td>
                    
		    </tr>
                   <?php }?>
                    
                </tbody>
                </table>
                    </div>
                    <div class="clear"></div>
		    </div>
		</div>
		<?php echo elgg_view('input/button', array('id' => 'btn_quest_cancel', "data-dismiss"=>"modal", "class"=>"btn btn-default btn_submit_grey", 'value' => elgg_echo('entity:ok'))); ?><span class="ajx-submit-load disp-none"></span>
      </div>