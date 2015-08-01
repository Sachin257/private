<?php
$employees = elgg_extract('employees', $vars);
$profile_type_label = elgg_extract('role', $vars);
$profile_type_name = elgg_extract('role_name', $vars);
?>
<div class="clear"></div>
<div class="cmp_list rounded_corners frm_box_shadow frm_box_border MB_five mgr_listall">
    <div class="search_box nest_wrap "> 
    <h3 class="column_left"><?php echo $profile_type_label?> </h3>
    <div class="column_right"><?php echo  elgg_view_form("employee/filter", array('id'=>'frm_'.$profile_type_name.'_search'), $vars);?></div>
    </div>
    <div>
    <?php if($employees && count($employees)) { ?>
    <table class="elgg-list elgg-list-entity mgr_list">	
		<tbody>
		<tr>
			<th style="width: 20%;"><?php echo elgg_echo('entity:name')?></th>
			<th style="width: 15%;"><?php echo elgg_echo('entity:joined:date')?></th>
                        <th style="width: 25%;"><?php echo elgg_echo('entity:designation')?></th>
			<th style="width: 30%;"><?php echo elgg_echo('company:contact_postal_address')?></th>
			<th style="width: 10%;"></th>
		</tr>
		<?php foreach($employees as $_employee)  {                    
                    $company_name = get_company_of_employee($_employee->guid);
                    $company_name = $company_name->trading_name;
                    ?>
		<tr id="elgg-object-<?php echo $_employee->guid?>" class="elgg-item">
			<td class="company-title"><?php echo $_employee->title;?></td>
			<td class="company-title"><?php echo $_employee->date_of_join;?></td>
                        <td class="company-title"><?php echo $_employee->designation;?></td>
			<td class="company-title"><?php echo $_employee->address;?></td>
			<td class="company-link">
				<?php 
				$edit_url = "/employee/edit/$_employee->guid";
				echo elgg_view('output/url', array(
						'href' => $edit_url,
						'text' => elgg_echo('entity:edit'),
						'class' => 'MR_20 elgg-button-edit-information float-alt',
						'rel' => 'nofollow'
				));
                                $delete_url = "/action/employee/delete/?guid={$_employee->guid}&offset=$offset";
                                echo elgg_view('output/confirmlink', array(
                                                'href' => $delete_url,
                                                'text' => elgg_echo('entity:delete'),
                                                'title' => 'Delete',
                                                'class' => 'elgg-button-delete float-alt'
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