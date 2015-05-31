<?php
$paint_entities = elgg_extract('paint', $vars);
$offset = elgg_extract('offset', $vars);
?>
<div class="clear"></div>
<div class="cmp_list rounded_corners frm_box_shadow frm_box_border MB_five mgr_listall">
    <div class="search_box nest_wrap "> 
    <h3 class="column_left"><?php echo elgg_echo('enitiy:paint')?></h3>
    <div class="column_right"><?php echo  elgg_view_form("paint/filter", array('id'=>'frm_paint_search'), $vars);?></div>
    </div>
    <div>
    <?php if($paint_entities && count($paint_entities)) { ?>
    <table class="elgg-list elgg-list-entity mgr_list">	
		<tbody>
		<tr>
                        <th style="width: 20%"><?php echo elgg_echo('entity:name')?></th>
			<th style="width: 20%"><?php echo elgg_echo('paint:id')?></th>
			<th style="width: 15%"><?php echo elgg_echo('paint:colour')?></th>
                        <th style="width: 15%"><?php echo elgg_echo('paint:price')?></th>
                        <th style="width: 20%"><?php echo elgg_echo('paint:current:quantity')?></th>
			<th style="width: 10%"></th>
		</tr>
		<?php foreach($paint_entities as $paint_entitie)  {?>
		<tr id="elgg-object-<?php echo $paint_entitie->guid?>" class="elgg-item">
			<td class="company-title">
			<?php  echo elgg_view('output/url', array(
					'href' => "#",
					'text' => $paint_entitie->title,
					'class' => '',
					'rel' => 'nofollow'
			)); ?>
			</td>
                        <td><?php echo $paint_entitie->paint_id;?></td>
                        <td><?php echo $paint_entitie->colour;?></td>
                        <td style="text-align: left;"><?php echo $paint_entitie->price;?></td>
                        <td><?php echo $paint_entitie->quantity;?></td>
			<td class="company-link">
			<?php
				$edit_url = "/paint/edit/$paint_entitie->guid";
						
			echo elgg_view('output/url', array(
					'href' => $edit_url,
					'text' => elgg_echo('entity:edit'),
					'class' => 'MR_20 elgg-button-edit-information float-alt',
					'rel' => 'nofollow'
			));
			$delete_url = "/action/paint/delete/?guid={$paint_entitie->guid}&offset=$offset";
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
	<?php echo elgg_echo('paint:none')?>	
	<?php }?>
</div>

<div class="clear">
</div>
