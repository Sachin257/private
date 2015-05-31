<?php
//print '<pre>';print_r( $vars['certificates']);print '</pre>';
if(count($vars['certificates']))
{
	?>
	<table class="certificate_tbl" width="100%">
	<tr>
		<th width="42%" align="center">
			<?php echo elgg_echo('document_type:extra:type');?>
		</th>
		<th width="25%" align="center">
			<?php echo elgg_echo('certificate:label:id');?>
		</th>
		<th width="14%" align="center">
			<?php echo elgg_echo('certificate:label:expiry');?>
		</th>
		<?php 
		if (elgg_is_admin_logged_in() || ( $login_user_id == $page_user_id) ) {
		?>
		<th width="19%" align="center">
			
		</th>
		<?php 
		}
		?>
	</tr>
	<?php
	foreach($vars['certificates'] as $certificate)
	{
		?>
		<tr>
			<td align="center">
				<?php echo $certificate['title'];?>
			</td>
			<td align="center">
				<?php echo $certificate['certificate_id'];?>
			</td>
			<td align="center">
				<?php echo date('d-m-Y', $certificate['date_of_expiry']);?>
			</td>
			<?php 
			if (elgg_is_admin_logged_in() || ( $login_user_id == $page_user_id) ) {
			?>
			<td align="center">
				 	<?php 
				 	echo elgg_view('output/url', array(
				 			'href' => '#',
							'is_trusted' => true,
				 			'text' => elgg_echo ('dashboard:edit'),				 			
							'id'=> 'edit_certi_'.$certificate['guid'],
							'data:guid' =>  $certificate['guid'],
				 			'class' => 'elgg-button elgg-button-edit edit_certi',
				 	));
					?>
					&nbsp;
					<?php
				    echo elgg_view('output/confirmlink', array(
				                    'href' => '/action/user/certification/delete?guid='.$certificate['guid'],
				                    'text' => elgg_echo ('entity:delete'),
				                    'is_trusted' => true,
									'id'=> 'delet_certi_'.$certificate['guid'],
									'data:guid' =>  $certificate['guid'],
				                    'class' => 'elgg-button elgg-button-delete delet_certi',
				    ));					
				    ?>
			</td>
			<?php 
			}
			?>
		</tr>
		<?php
	}
	?>
	</table>
	<?php 
}