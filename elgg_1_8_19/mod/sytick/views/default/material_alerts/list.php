<?php
$material_alerts_entities = elgg_extract('material_alerts', $vars);
$offset = elgg_extract('offset', $vars);
?>
<div class="clear"></div>
<div class="cmp_list rounded_corners frm_box_shadow frm_box_border MB_five mgr_listall">
    <div class="search_box nest_wrap "> 
        <h3 class="column_left" style="color: #3a5795;"><?php echo elgg_echo('material_alerts:head') ?></h3>
    </div>
    <div>
        <?php if ($material_alerts_entities && count($material_alerts_entities)) { ?>
            <table class="elgg-list elgg-list-entity mgr_list">	
                <tbody>
                    <tr>
                        <th><?php echo elgg_echo("entity:date")?></th>
                        <th><?php echo elgg_echo('material:name') ?></th>
                        <th><?php echo elgg_echo('material:type') ?></th>
                        <th><?php echo elgg_echo('material_alerts:used:quantity') ?></th>
                        <th><?php echo "Alert Response"?></th>
                    </tr>
                    <?php foreach ($material_alerts_entities as $material_alerts_entitie) {
                        $response = "No";
                        if($material_alerts_entitie->response){
                            $response = "Yes";
                        }
                        if($material_alerts_entitie->is_active){
                        ?>
                        <tr id="elgg-object-<?php echo $material_alerts_entitie->guid ?>" class="elgg-item" style="height: 40px;">
                            <td><?php echo date("d-m-Y",$material_alerts_entitie->time_created); ?></td>
                            <td><?php echo $material_alerts_entitie->title; ?></td>
                            <td><?php echo $material_alerts_entitie->material_type; ?></td>
                            <td><?php echo $material_alerts_entitie->quantity; ?></td>
                            <td class="respond_alert" style="cursor: pointer;" data-guid="<?php echo $material_alerts_entitie->guid ?>"><?php echo $response;?></td>
                        </tr>
                        <?php }
                        } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <?php echo elgg_echo('material_alerts:none') ?>	
        <?php } ?>
    </div>

    <div class="clear">
    </div>
