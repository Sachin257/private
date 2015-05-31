<?php foreach($vars['projects'] as $_project)  {?>
		<tr id="elgg-object-<?php echo $_project->guid?>" class="elgg-item">
			<td class="company-title">
			<?php  echo elgg_view('output/url', array(
					'href' => "/project/view/$_project->project_name",
					'text' => $_project->title,
					'class' => '',
					'rel' => 'nofollow'
			)); ?>
			</td>
			<td class="company-title"><?php echo $_project->project_postal_address?> </td>
			<td class="company-abn"><?php echo date('d-m-Y',$_project->time_created)?></td>
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
					'class' => 'MR_20 elgg-button-edit-information float-alt',
					'rel' => 'nofollow'
			));
			$delete_url = "/action/project/delete/?guid={$_project->guid}";
			echo elgg_view('output/confirmlink', array(
					'href' => $delete_url,
					'text' => elgg_echo('entity:delete'),
					'class' => 'elgg-button-delete float-alt'
			));
			?>
			</td>
		</tr>
		<?php }?>