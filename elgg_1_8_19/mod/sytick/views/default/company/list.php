<?php
$companies = elgg_extract('companies', $vars);
$offset = elgg_extract('offset', $vars);
$company_type = elgg_extract('company_type', $vars);
?>
<div class="clear"></div>
<div class="cmp_list rounded_corners frm_box_shadow frm_box_border MB_five mgr_listall">
    <div class="search_box nest_wrap "> 
    <h3 class="column_left"><?php echo elgg_echo('enitiy:company')?></h3>
    <div class="column_right"><?php echo  elgg_view_form("company/filter", array('id'=>'frm_company_search'), $vars);?></div>
    </div>
    <div>
    <?php if($companies && count($companies)) { ?>
    <table class="elgg-list elgg-list-entity mgr_list">	
		<tbody>
		<tr>
			<th><?php echo elgg_echo('company:name:table_head')?></th>
			<th><?php echo elgg_echo('company:trading_name:table_head')?></th>
			<th><?php echo elgg_echo('entity:creation_date')?></th>
			<th></th>
		</tr>
		<?php foreach($companies as $company)  {?>
		<tr id="elgg-object-<?php echo $company->guid?>" class="elgg-item">
			<td class="company-title">
			<?php   $company_link = $company->name; $company_link= str_replace(' ', '', $company_link);
                                  echo elgg_view('output/url', array(
					'href' => "/company/$company_link",
					'text' => $company->title,
					'class' => '',
					'rel' => 'nofollow'
			)); ?>
			</td>
                        <td><?php echo $company->description;?></td>
			<td class="company-abn"><?php echo date('d-m-Y',$company->time_created)?></td>
			<td class="company-link">
			<?php
				$edit_url = "/company/edit/$company_link";
						
			echo elgg_view('output/url', array(
					'href' => $edit_url,
					'text' => elgg_echo('entity:edit'),
					'class' => 'MR_20 elgg-button-edit-information float-alt',
					'rel' => 'nofollow'
			));
			$delete_url = "/action/company/delete/?guid={$company->guid}&offset=$offset&company_type=$company_type";
			echo elgg_view('output/confirmlink', array(
					'href' => $delete_url,
					'text' => elgg_echo('entity:delete'),
					'class' => 'elgg-button-delete float-alt'
			));
			?>
			</td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php } else { ?>
	<?php echo elgg_echo('company:none')?>	
	<?php }?>
</div>

<div class="clear">
</div>
