<?php
$employees = elgg_extract('employees', $vars);
$profile_type_values = elgg_extract('profile_type_values', $vars);
?>
<div class="clear"></div>
<div class="cmp_list rounded_corners frm_box_shadow frm_box_border MB_five mgr_listall">
    <div class="search_box nest_wrap "> 
    <h3 class="column_left"><?php echo $profile_type_label?> </h3>
    <div class="column_right"><?php echo  elgg_view_form("employee/filter", array('id'=>'frm_employee_search'), $vars);?></div>
    </div>
    <div>
    <?php if($employees && count($employees)) { ?>
    <table class="elgg-list elgg-list-entity mgr_list">	
		<tbody>
		<tr>
			<th style="width: 23%;"><?php echo elgg_echo('entity:name')?></th>
			<th style="width: 26%;"><?php echo elgg_echo('email')?></th>
                        <th style="width: 26%;"><?php echo elgg_echo('entity:company')?></th>
			<th style="width: 15%;"><?php echo elgg_echo('company:employee:type')?></th>
			<th style="width: 10%;"></th>
		</tr>
		<?php foreach($employees as $_employee)  {                    
                    $company_name = get_company_of_employee($_employee->guid);
                    $company_name = $company_name->trading_name;
                    ?>
		<tr id="elgg-object-<?php echo $_employee->guid?>" class="elgg-item">
			<td class="company-title">
			<?php  echo elgg_view('output/url', array(
					'href' => "/user/$_employee->username",
					'text' => $_employee->name,
					'class' => '',
					'rel' => 'nofollow'
			)); ?>
			</td>
			<td class="company-title"><?php echo $_employee->email?></td>
                        <td class="company-title"><?php echo $company_name?></td>
			<td class="company-title"><?php echo $profile_type_values[$_employee->custom_profile_type]?></td>
			<td class="company-link">
				<?php 
				$edit_url = "/employee/edit/{$_employee->username}";
				echo elgg_view('output/url', array(
						'href' => $edit_url,
						'text' => elgg_echo('entity:edit'),
						'class' => 'MR_20 elgg-button-edit-information float-alt',
						'rel' => 'nofollow'
				));
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