		<?php foreach($vars['inductions'] as $_induction)  {?>
		<tr id="elgg-object-<?php echo $_induction->guid?>" class="elgg-item">
			<td class="company-title">
			<?php  echo elgg_view('output/url', array(
					'href' => "/induction/view/$_induction->induction_name",
					'text' => $_induction->title,
					'class' => '',
					'rel' => 'nofollow'
			)); ?>
			</td>
			<td class="company-abn"><?php echo get_induction_assigned_project($_induction->guid, $type = "title")?></td>
			<td class="company-abn"><?php echo date('d-m-Y',$_induction->time_created)?></td>
			<td class="company-link">
			<?php		

			
			if($_questionnaire->induction_name != "" ) {
				$edit_url = "/induction/edit/{$_induction->induction_name}";
			} else {
				$edit_url = "/induction/edit/?guid={$_induction->guid}";
			}			
			echo elgg_view('output/url', array(
					'href' => $edit_url,
					'text' => elgg_echo('entity:edit'),
					'class' => 'MR_20 elgg-button-edit-information float-alt',
					'rel' => 'nofollow'
			));
			

			$delete_url = "/action/induction/delete/?guid={$_induction->guid}";
			echo elgg_view('output/confirmlink', array(
					'href' => $delete_url,
					'text' => elgg_echo('entity:delete'),
					'class' => 'elgg-button-delete float-alt'
			));
			if($_induction->induction_status == 1 ) {
				echo elgg_view('output/url', array(
						'href' => "#",
						'text' => elgg_echo('entity:attend'),
						'class' => 'MR_20 elgg-button-edit-information float-alt',
						'data:guid' =>  $_induction->guid,
						'class' => 'induction_attend',
						'data:induction_guid' => $_induction->guid,
						"id" => "induction_attend_{$_induction->guid}",
						'rel' => 'nofollow', 
				));
			} else {
				echo elgg_view('output/url', array(
						'href' => "#",
						'text' => elgg_echo('entity:activate'),
						'class' => 'MR_20 elgg-button-edit-information float-alt',
						'data:guid' =>  $_induction->guid,
						'class' => 'induction_activate',
						'data:induction_guid' => $_induction->guid,
						"id" => "induction_activate_{$_induction->guid}",
						'rel' => 'nofollow',
				));
			}
			?>
			</td>
		</tr>
		<?php } ?>