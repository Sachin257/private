<?php
$projects = elgg_extract('projects', $vars);
$offset = elgg_extract('offset', $vars);
?>
<div class="clear"></div>
<div class="cmp_list rounded_corners frm_box_shadow frm_box_border MB_five mgr_listall">
    <div class="search_box nest_wrap "> 
    <h3 class="column_left"><?php echo elgg_echo('enitiy:projects')?></h3>
    <div class="column_right"><?php echo  elgg_view_form("project/filter", array('id'=>'frm_projects_search'), $vars);?></div>
    </div>
    <div>
    <?php if($projects && count($projects)) { ?>
    <table class="elgg-list elgg-list-entity mgr_list">	
		<tbody>
		<tr>
			<th style="width: 30%"><?php echo elgg_echo('entity:name')?></th>
			<th style="width: 30%"><?php echo elgg_echo('project:customer')?></th>
                        <th style="width: 15%"><?php echo elgg_echo('project:doi')?></th>
			<th style="width: 15%"><?php echo elgg_echo('project:expiry')?></th>
			<th style="width: 10%"></th>
		</tr>
		<?php foreach($projects as $_project)  {?>
		<tr id="elgg-object-<?php echo $_project->guid?>" class="elgg-item">
			<td class="company-title">
			<?php  echo elgg_view('output/url', array(
					'href' => "/project/view/$_project->project_name",
					'text' => $_project->title,
					'class' => '',
					'rel' => 'nofollow'
			)); ?>
			</td>
			<td class="company-title"><?php echo $_project->customer?> </td>
			<td class="company-abn"><?php echo $_project->start_date; ?></td>
                        <td class="company-abn"><?php echo $_project->final_date; ?></td>
			<td class="company-link">
			<?php
			if($_project->project_name != "" ) {
				$edit_url = "/project/edit/{$_project->project_name}";
			} else {
				$edit_url = "/project/edit/?guid={$_project->guid}";
			}			
			echo elgg_view('output/url', array(
					'href' => $edit_url,
					'text' => elgg_echo('entity:edit'),
					'title' => elgg_echo('entity:edit:text'),
					'class' => 'MR_20 elgg-button-edit-information float-alt',
					'rel' => 'nofollow'
			));
			$delete_url = "/action/project/delete/?guid={$_project->guid}&offset=$offset";
			echo elgg_view('output/confirmlink', array(
					'href' => $delete_url,
					'title' => elgg_echo('entity:delete:text'),
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
	<?php echo elgg_echo('project:list:none')?>	
	<?php }?>
</div>

<div class="clear">
</div>
