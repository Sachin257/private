<?php
$paint_entities = elgg_extract('paint', $vars);
$offset = elgg_extract('offset', $vars);
?>
<div class="clear"></div>
<div class="cmp_list rounded_corners frm_box_shadow frm_box_border MB_five mgr_listall">
    <div class="search_box nest_wrap "> 
        <h3 class="column_left" style="color: #3a5795;"><?php echo elgg_echo('paint_used:head') ?></h3>
    </div>
    <div>
        <?php if ($paint_entities && count($paint_entities)) { ?>
            <table class="elgg-list elgg-list-entity mgr_list">	
                <tbody>
                    <tr>
                        <th><?php echo elgg_echo("entity:date")?></th>
                        <th><?php echo elgg_echo('entity:name') ?></th>
                        <th><?php echo elgg_echo('paint:id') ?></th>
                        <th><?php echo elgg_echo('paint:colour') ?></th>
                        <th><?php echo elgg_echo('paint:used:quantity') ?></th>
                    </tr>
                    <?php foreach ($paint_entities as $paint_entitie) { ?>
                        <tr id="elgg-object-<?php echo $paint_entitie->guid ?>" class="elgg-item" style="height: 40px;">
                            <td><?php echo date("d-m-Y",$paint_entitie->time_created); ?></td>
                            <td><?php echo $paint_entitie->title; ?></td>
                            <td><?php echo $paint_entitie->paint_used_id; ?></td>
                            <td><?php echo $paint_entitie->colour; ?></td>
                            <td><?php echo $paint_entitie->quantity; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <?php echo elgg_echo('paint:none') ?>	
        <?php } ?>
    </div>

    <div class="clear">
    </div>
