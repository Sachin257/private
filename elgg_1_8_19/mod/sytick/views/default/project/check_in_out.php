<?php
$workers = elgg_extract('workers', $vars);
$offset = elgg_extract('offset', $vars);
$employee_check_in_out_status = elgg_extract('employee_check_in_out_status', $vars);
$project = elgg_extract('project', $vars);
$all_count = elgg_extract('all_count', $vars);
$checked_in_count = elgg_extract('checked_in_count', $vars);
$checked_out_count = elgg_extract('checked_out_count', $vars);
$pending_count = elgg_extract('pending_count', $vars);
$base_url = elgg_extract('base_url', $vars);
?>
<div class="clear"></div>
<div class="cmp_list rounded_corners frm_box_shadow MB_five mgr_listall">

    <div class="chkl_list">
    <?php if($workers && count($workers)) {   ?>
    <table class="elgg-list elgg-list-entity mgr_list">	
		<tbody>
		<tr>
			<th width="10%"><?php echo elgg_echo('entity:profile_pic')?></th>
			<th width="45%"><?php echo elgg_echo('entity:nameandcompany')?></th>
			<th width="25%"><?php echo elgg_echo('entity:last_transaction')?></th>
			<th width="20%"><?php echo elgg_echo('entity:check_in_out')?></th>
		</tr>
		<?php foreach($workers as $worker)  {
                    $company = get_company_of_employee($worker->guid);
                    $company_name = $company->title;
                    
                    ?>
		<tr id="elgg-object-<?php echo $worker->guid?>" class="elgg-item">
			<td class="company-title">
			<?php  
                        $name = htmlspecialchars($worker->name, ENT_QUOTES, 'UTF-8', false);
                        $size = elgg_extract('size', $vars, DEFAULT_PROFILE_PIC_MEDIUM);
                        $icon_url = elgg_format_url($worker->getIconURL($size));
                        echo elgg_view('output/img', array(
                                       'src' => $icon_url,
                                       'alt' => $name,
                                       'title' => $name,
                                       'class' => '',
                                       'style' => "background: url($icon_url) no-repeat 45% 10%; background-size: 105%;",
                                      )); 
                        ?>
			</td>
			<td class="company-title">
                            <span class="tbls_name"><?php echo $worker->name;?></span><br> <?php echo $company_name;?>  
                        </td>
			<td class="company-abn" style="text-align:left;">
							<?php 
							if( isset($employee_check_in_out_status[$worker->guid]) 
									&& isset($employee_check_in_out_status[$worker->guid]['check_out_timetamp']) 
									&& ($employee_check_in_out_status[$worker->guid]['check_out_timetamp'])) 
							{
								$chk_out_time = 0;
								$chk_out_time = $employee_check_in_out_status[$worker->guid]['check_out_timetamp'];
								echo "<span class='spn-lastacttime' id='spn_checkin-in_out_time_".$worker->guid."'>@".date('H:i',$chk_out_time)."</span>";
							} else  if( isset($employee_check_in_out_status[$worker->guid]) 
									&& isset($employee_check_in_out_status[$worker->guid]['check_in_timetamp']) 
									&& ($employee_check_in_out_status[$worker->guid]['check_in_timetamp']))
							{
								$chk_in_time = 0;
								$chk_in_time = $employee_check_in_out_status[$worker->guid]['check_in_timetamp'];
								echo "<span class='spn-lastacttime' id='spn_checkin-in_out_time_".$worker->guid."'>@".date('H:i',$chk_in_time)."</span>";
							} else {
								echo "<span class='spn-lastacttime' id='spn_checkin-in_out_time_".$worker->guid."'>-</span>";
							}
                        	?> 
			</td>
            <td class="company-link">
            				<?php 
							if( isset($employee_check_in_out_status[$worker->guid]) 
									&& isset($employee_check_in_out_status[$worker->guid]['check_out_timetamp']) 
									&& ($employee_check_in_out_status[$worker->guid]['check_out_timetamp'])) 
							{
							?>
								<input type="checkbox" data:site:guid="<?php echo $project->guid;?>" data:user:guid="<?php echo $worker->guid;?>" class="check_in_out_chk" data-on-text="In" data-off-text="Out"/>
							<?php 
							} else  if( isset($employee_check_in_out_status[$worker->guid]) 
									&& isset($employee_check_in_out_status[$worker->guid]['check_in_timetamp']) 
									&& ($employee_check_in_out_status[$worker->guid]['check_in_timetamp']))
							{
							?>
								<input type="checkbox" class="check_in_out_chk" data:site:guid="<?php echo $project->guid;?>" checked data:user:guid="<?php echo $worker->guid;?>"  data-on-text="<?php echo elgg_echo('entity:in')?>" data-off-text="<?php echo elgg_echo('entity:out')?>" />
							<?php 
							} else if( isset($employee_check_in_out_status[$worker->guid]) 
										&& 	isset($employee_check_in_out_status[$worker->guid]['check_in_out_status'])
										&& $employee_check_in_out_status[$worker->guid]['check_in_out_status'] !="success" ){
								echo ( isset($employee_check_in_out_status[$worker->guid]) 
										&& 	isset($employee_check_in_out_status[$worker->guid]['check_in_out_status'])
										&& $employee_check_in_out_status[$worker->guid]['check_in_out_status']!="success") ?
										$employee_check_in_out_status[$worker->guid]['check_in_out_status'] : "-";
							} else {
								?>
									<input type="checkbox" data:site:guid="<?php echo $project->guid;?>" data:user:guid="<?php echo $worker->guid;?>" class="check_in_out_chk" data-on-text="<?php echo elgg_echo('entity:in')?>" data-off-text="<?php echo elgg_echo('entity:out')?>"/>
								<?php 
							}
                        	?>                        	                              
            </td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php } else { ?>
	<?php echo elgg_echo('employee:list:none')?>	
	<?php }?>
</div>

<div class="clear">
</div>
    <script>
        $(document).ready(function(){
          $(".check_in_out_chk").bootstrapSwitch();
           //console.log('hiiiiiiiiiiii',jQuery("[name='my-checkbox']").length);
        });
    </script>