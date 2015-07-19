<?php
$assign_works = elgg_extract('assign_work', $vars);
$offset = elgg_extract('offset', $vars);
$order_from = elgg_extract('order_from', $vars);
?>
<div class="clear"></div>
<div class="cmp_list rounded_corners frm_box_shadow frm_box_border MB_five mgr_listall">
    <div class="search_box nest_wrap ">
        <h3 class="column_left"><?php echo elgg_echo('enitiy:assign_work')?></h3>
        <div class="column_right"><?php echo  elgg_view_form("assign_work/filter", array('id'=>'frm_assign_work_search'), $vars);?></div>
    </div>
    <div>
        <?php if($assign_works && count($assign_works)) { ?>
            <table class="elgg-list elgg-list-entity mgr_list">
                <tbody>
                <tr>
                    <th><?php echo "Project - Date"?></th>
                    <th><?php echo elgg_echo('order:from') ?></th>
                    <th><?php echo elgg_echo('material:name')?></th>
                    <th><?php echo elgg_echo("paint:used:shift"); ?></th>
                    <th><?php echo elgg_echo("entity:assigned");?></th>
                    <th><?php echo elgg_echo("entity:finished");?></th>
                    <th><?php echo elgg_echo("entity:efficiency")?></th>
                </tr>
                <?php foreach($assign_works as $assign_work)  {
                    $project = get_entity($assign_work->project);
                    $material = get_entity($project->material_id);
                    $array = calculate_efficiency($project->guid, $assign_work->guid);
                    ?>
                    <tr style="height: 39px;" id="elgg-object-<?php echo $assign_work->guid?>" class="elgg-item">
                        <td><?php
                            echo elgg_view('output/url', array(
                                'href' => "/painting_project/employee_view/$project->guid",
                                'text' => $assign_work->title,
                                'class' => '',
                                'rel' => 'nofollow'
                            ));
                            ?>
                        </td>
                        <td><?php echo $order_from[$project->order_from]; ?></td>
                        <td><?php echo $material->title; ?></td>
                        <td><?php echo $assign_work->shift;?></td>
                        <td><?php echo $assign_work->nopieces;?></td>
                        <td><?php echo $array['finished'];?></td>
                        <td><?php echo $array['efficiency'];?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <?php echo elgg_echo('assign_work:none')?>
        <?php }?>
    </div>

    <div class="clear">
    </div>
