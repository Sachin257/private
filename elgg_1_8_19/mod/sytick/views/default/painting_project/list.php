<?php
$painting_project_entities = elgg_extract('paint', $vars);
$offset = elgg_extract('offset', $vars);
$order_from = elgg_extract('order_from', $vars);
$total_cost = elgg_extract('cost', $vars);
$total_pieces = elgg_extract('nopiece', $vars);
$gtotal_cost = elgg_extract('gcost', $vars);
$gtotal_pieces = elgg_extract('gnopiece', $vars);


?>
<div class="clear"></div>
<div class="cmp_list rounded_corners frm_box_shadow frm_box_border MB_five mgr_listall">
    <div class="search_box nest_wrap "> 
        <div><?php echo elgg_view_form("painting_project/filter", array('id' => 'frm_painting_project_search'), $vars); ?></div>
    </div>
    <div class="clear" style="margin: 5px; height: 25px;">
         <span>Total Cost:&nbsp;&nbsp;<?php echo $gtotal_cost ?> &nbsp;&nbsp;&nbsp;Total number of pieces:&nbsp;&nbsp;<?php echo $gtotal_pieces ?> </span>
    </div>
    <div style="height: 350px; overflow: auto">
        <?php if ($painting_project_entities && count($painting_project_entities)) { ?>
            <table class="elgg-list elgg-list-entity mgr_list">	
                <tbody>
                    <tr>
                        <th style="width:10%;">Date</th>
                        <th style="width:25%;"><?php echo elgg_echo('entity:name') ?></th>
                        <th style="width:15%;"><?php echo elgg_echo('order:from') ?></th>
                        <th style="width:20%;"><?php echo elgg_echo('material_type:extra:type') ?></th>
                        <th style="width:10%;"><?php echo elgg_echo('project:nopieces') ?></th>
                        <th style="width:10%;"><?php echo "Total Cost"; ?></th>
                        <th style="width:10%;"></th>
                    </tr>
                    <?php foreach ($painting_project_entities as $paint_entitie) { ?>
                        <tr id="elgg-object-<?php echo $paint_entitie->guid ?>" class="elgg-item">
                            <td> <?php echo date("d-m-Y", $paint_entitie->time_created); ?></td>
                            <td class="company-title">
                                <?php
                                echo elgg_view('output/url', array(
                                    'href' => "/painting_project/view/$paint_entitie->guid",
                                    'text' => $paint_entitie->title,
                                    'class' => '',
                                    'rel' => 'nofollow'
                                ));
                                ?>
                            </td>
                            <td>
                                <?php echo $order_from[$paint_entitie->order_from] ?>
                            </td>
                            <td>
                                <?php
                                $material_id = $paint_entitie->material_id;
                                $material = get_entity($material_id);
                                echo $material->title;
                                ?>
                            </td>
                            <td><?php echo $paint_entitie->nopieces; ?></td>
                            <td>
                                <?php
                                $cost = $paint_entitie->nopieces * $material->price * $material->perimeter * $paint_entitie->lengthperpiece;

                                echo $cost;
                                ?></td>
                            <td class="company-link">
                                <?php
                                $edit_url = "/painting_project/add?name=$paint_entitie->title";

                                echo elgg_view('output/url', array(
                                    'href' => $edit_url,
                                    'text' => elgg_echo('entity:edit'),
                                    'class' => 'MR_20 elgg-button-edit-information float-alt',
                                    'title' => 'Add new',
                                    'rel' => 'nofollow'
                                ));
				if(elgg_is_admin_logged_in()){
                                    $delete_url = "/action/paint/delete/?guid={$paint_entitie->guid}&offset=$offset";
                                    echo elgg_view('output/confirmlink', array(
                                        'href' => $delete_url,
                                        'text' => elgg_echo('entity:delete'),
                                        'title' => 'Delete',
                                        'class' => 'elgg-button-delete float-alt'
                                    ));
				}
                                ?>
                            </td>
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
    <div class="modal fade" id="projectNameModal" style="display: none;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="myModalLabel"><?php echo elgg_echo('project:name'); ?></h1>
                </div>
                <div class="modal-body">
                    <div id="addQuestion" class="userfileup clear span6">		    
                        <div class="nest_wrap">

                            <label><?php echo elgg_echo("project:name"); ?></label>
                            <?php echo elgg_view('input/text', array('name' => 'projName', "id" => "projName")); ?>
                            <span class="error_msg clear projName_err"></span>
                            <label><?php echo elgg_echo("order:from"); ?></label>
                            <?php
                            echo elgg_view("input/dropdown", array(
                                "name" => "order_from",
                                "id" => "order_from",
                                "class" => "custom-select",
                                "options_values" => $order_from
                            ));
                            ?>
                            <span class="error_msg clear orderFrom_err"></span>
                        </div>
                        <div class="userrow">


                        </div>
                    </div>      
                </div>
                <div align="center" class="MT_two">

                    <?php echo elgg_view('input/button', array('id' => 'btn_project_name', "class" => "btn btn-default btn_submit_grey", 'value' => elgg_echo('certificate:add'))); ?>
                    <?php echo elgg_view('input/button', array('id' => 'btn_quest_cancel', "data-dismiss" => "modal", "class" => "btn btn-default btn_submit_grey", 'value' => elgg_echo('certificate:cancel'))); ?><span class="ajx-submit-load disp-none"></span>
                </div>
            </div>
        </div>
    </div>
