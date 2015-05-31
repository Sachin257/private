<?php
$material_type_entities = elgg_extract('material_type', $vars);
$offset = elgg_extract('offset', $vars);
?>
<div class="clear"></div>
<div class="cmp_list rounded_corners frm_box_shadow frm_box_border MB_five mgr_listall">
    <div class="search_box nest_wrap "> 
    <h3 class="column_left"><?php echo elgg_echo('enitiy:material_type')?></h3>
    <div class="column_right"><?php echo  elgg_view_form("material_type/filter", array('id'=>'frm_material_type_search'), $vars);?></div>
    </div>
    <div>
    <?php if($material_type_entities && count($material_type_entities)) { ?>
    <table class="elgg-list elgg-list-entity mgr_list">	
		<tbody>
		<tr>
                    <th style="width: 25%;"><?php echo elgg_echo('entity:name')?></th>
			<th style="width: 25%;"><?php echo elgg_echo('entity:description')?></th>
			<th style="width: 20%;"><?php echo elgg_echo('material_type:perimeter')?></th>
			<th style="width: 20%;"><?php echo elgg_echo('material_type:price')?></th>
                        <th style="width: 10%;"></th>
		</tr>
		<?php foreach($material_type_entities as $material_type_entitie)  {?>
		<tr id="elgg-object-<?php echo $material_type_entitie->guid?>" class="elgg-item">
			<td class="company-title">
			<?php  echo elgg_view('output/url', array(
					'href' => "/material_type/edit/$material_type_entitie->guid",
					'text' => $material_type_entitie->title,
					'class' => '',
					'rel' => 'nofollow'
			)); ?>
			</td>
                        <td><?php echo $material_type_entitie->description;?></td>
                        <td><?php echo $material_type_entitie->perimeter;?></td>
                        <td style="text-align: left;"><?php echo $material_type_entitie->price;?></td>
			<td class="company-link">
			<?php
				$edit_url = "/material_type/edit/$material_type_entitie->guid";
						
			echo elgg_view('output/url', array(
					'href' => $edit_url,
					'text' => elgg_echo('entity:edit'),
					'class' => 'MR_20 elgg-button-edit-information float-alt',
					'rel' => 'nofollow'
			));
			$delete_url = "/action/material_type/delete/?guid={$material_type_entitie->guid}&offset=$offset";
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
	<?php echo elgg_echo('material_type:none')?>	
	<?php }?>
</div>

<div class="clear">
</div>
