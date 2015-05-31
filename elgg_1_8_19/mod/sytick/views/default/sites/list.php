<?php
$sites = elgg_extract('sites', $vars);
$offset = elgg_extract('offset', $vars);
?>
<div class="cmp_list rounded_corners frm_box_shadow frm_box_border MB_five mgr_listall">
    <div class="search_box nest_wrap "> 
    <h3 class="column_left"><?php echo elgg_echo('enitiy:sites')?></h3>
    <div class="column_right"><?php echo  elgg_view_form("sites/filter", array('id'=>'frm_sites_search'), $vars);?></div>
    </div>
    <div>
    <?php if($sites && count($sites)) { ?>
    <table class="elgg-list elgg-list-entity mgr_list">	
		<tbody>
		<tr>
			<th><?php echo elgg_echo('entity:name')?></th>
			<th><?php echo elgg_echo('entity:creation_date')?></th>
			<th></th>
		</tr>
		<?php foreach($sites as $_site)  {?>
		<tr id="elgg-object-<?php echo $_site->guid?>" class="elgg-item">
			<td class="company-title">
			<?php  echo elgg_view('output/url', array(
					'href' => "/sites/view/$_site->site_name",
					'text' => $_site->title,
					'class' => '',
					'rel' => 'nofollow'
			)); ?>
			</td>
			<td class="company-abn"><?php echo date('d-m-Y',$_site->time_created)?></td>
			<td class="company-link">
			<?php
			if($_site->site_name != "" ) {
				$edit_url = "/sites/edit/{$_site->site_name}";
			} else {
				$edit_url = "/sites/edit/?guid={$_site->guid}";
			}			
			echo elgg_view('output/url', array(
					'href' => $edit_url,
					'text' => '<i class="fa fa-pencil"></i>'.elgg_echo('entity:edit'),
					'class' => 'MR_20 elgg-button-edit-information float-alt',
					'rel' => 'nofollow'
			));
			$delete_url = "/action/sites/delete/?guid={$_site->guid}&offset=$offset";
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
	<?php echo elgg_echo('sites:list:none')?>	
	<?php }?>
</div>

<div class="clear">
</div>
