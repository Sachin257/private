<?php
$item_entities = elgg_extract('inventory', $vars);
$inventory_types = elgg_extract("inventory_types", $vars);
?>
<div class="clear"></div>
<div class="cmp_list rounded_corners frm_box_shadow frm_box_border MB_five mgr_listall">
    <div class="search_box nest_wrap "> 
    <h3 class="column_left"><?php echo elgg_echo('enitiy:item')?></h3>
    <div class="column_right"><?php echo  elgg_view_form("inventory/filter", array('id'=>'frm_inventory_search'), $vars);?></div>
    </div>
    <div>
    <?php if($item_entities && count($item_entities)) { ?>
    <table class="elgg-list elgg-list-entity mgr_list">	
		<tbody>
		<tr>
                        <th style="width: 20%"><?php echo elgg_echo('item:name')?></th>
                        <th style="width: 20%"><?php echo elgg_echo('inventory:type')?></th>
			<th style="width: 20%"><?php echo elgg_echo('item:code')?></th>
			<th style="width: 10%"><?php echo elgg_echo('item:length')?></th>
                        <th style="width: 10%"><?php echo elgg_echo('item:weight')?></th>
                        <th style="width: 10%"><?php echo elgg_echo('item:price')?></th>
			<th style="width: 10%"></th>
		</tr>
		<?php foreach($item_entities as $item_entitie)  {?>
		<tr id="elgg-object-<?php echo $item_entitie->guid?>" class="elgg-item">
			<td class="company-title"><?php  echo $item_entitie->title; ?></td>
                        <td><?php echo get_subtype_from_id($item_entitie->subtype); ?></td>
                        <td><?php echo $item_entitie->item_code;?></td>
                        <td><?php echo $item_entitie->length;?></td>
                        <td style="text-align: left;"><?php echo $item_entitie->weight;?></td>
                        <td><?php echo $item_entitie->price;?></td>
			<td class="company-link">
			<?php
				$edit_url = "/inventory/edit/$item_entitie->guid";
						
			echo elgg_view('output/url', array(
					'href' => $edit_url,
					'text' => elgg_echo('entity:edit'),
					'class' => 'MR_20 elgg-button-edit-information float-alt',
					'rel' => 'nofollow'
			));
			$delete_url = "/action/inventory/delete/?guid={$item_entitie->guid}";
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
	<?php echo elgg_echo('inventory:none')?>	
	<?php }?>
</div>

<div class="clear">
</div>
