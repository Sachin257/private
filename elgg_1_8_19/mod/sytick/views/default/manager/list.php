<?php
$managers = elgg_extract('managers', $vars);
?>
<div class="clear"></div>
<div class="cmp_list rounded_corners frm_box_shadow frm_box_border MB_five mgr_listall">
    <div class="search_box nest_wrap "> 
    <h3 class="column_left"><?php echo elgg_echo('enitiy:managers')?></h3>
    <div class="column_right"><?php echo  elgg_view_form("manager/filter", array('id'=>'frm_manager_search'), $vars);?></div>
    </div>
    <div>
    <?php if($managers && count($managers)) { ?>
    <table class="elgg-list elgg-list-entity mgr_list">	
		<tbody>
		<tr>
			<th style="width: 16%;"><?php echo elgg_echo('entity:name')?></th>
			<th style="width: 27%;"><?php echo elgg_echo('email')?></th>
                        <th style="width: 27%;"><?php echo elgg_echo('entity:company')?></th>
			<th style="width: 15%;"><?php echo elgg_echo('entity:creation_date')?></th>
			<th style="width: 15%;"></th>
		</tr>
		<?php foreach($managers as $_manager)  {
                    
                    $company_name = get_company_of_manager($_manager->guid);
                    $company_name = $company_name->trading_name;
                    ?>
		<tr id="elgg-object-<?php echo $_manager->guid?>" class="elgg-item">
			<td class="company-title"><a href="/user/<?php echo $_manager->username?>"><?php echo $_manager->name?></a></td>
			<td class="company-title"><?php echo $_manager->email?></td>
                        <td class="company-title"><?php echo $company_name?></td>
			<td class="company-abn"><?php echo date('d-m-Y',$_manager->time_created)?></td>
			<td class="company-link"><a href="/manager/edit/<?php echo $_manager->username?>" class="MR_20 elgg-button-edit-information float-alt" rel="nofollow"><?php echo elgg_echo('entity:edit')?> </a></td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php } else { ?>
	<?php echo elgg_echo('manager:list:none')?>	
	<?php }?>
</div>

<div class="clear">
</div>