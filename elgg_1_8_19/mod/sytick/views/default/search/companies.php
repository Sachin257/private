    <?php foreach( $vars["companies"] as $company)  {?>
		<tr id="elgg-object-<?php echo $company->guid?>" class="elgg-item">
			<td class="company-title">
			<?php   $company_link = strtolower($company->title); $company_link= str_replace(' ', '', $company_link);
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
			$delete_url = "/action/company/delete/?guid={$company->guid}";
			echo elgg_view('output/confirmlink', array(
					'href' => $delete_url,
					'text' => elgg_echo('entity:delete'),
					'class' => 'elgg-button-delete float-alt'
			));
			?>
			</td>
		</tr>
		<?php } ?>