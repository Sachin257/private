<?php
$tentative_work_entities = elgg_extract('tentative_work', $vars);
$offset = elgg_extract('offset', $vars);
?>
<div class="clear"></div>
<div class="cmp_list rounded_corners frm_box_shadow frm_box_border MB_five mgr_listall">
    <div class="search_box nest_wrap ">
        <h3 class="column_left"><?php echo elgg_echo('enitiy:tentative_work')?></h3>
        <div class="column_right"><?php echo  elgg_view_form("tentative_work/filter", array('id'=>'frm_tentative_work_search'), $vars);?></div>
    </div>
    <div>
        <?php if($tentative_work_entities && count($tentative_work_entities)) { ?>
            <table class="elgg-list elgg-list-entity mgr_list">
                <tbody>
                <tr>
                    <th style="width: 20%"><?php echo elgg_echo('entity:date')?></th>
                    <th style="width: 20%"><?php echo elgg_echo('paint:used:shift')?></th>
                    <th style="width: 20%"><?php echo elgg_echo('paint:colour')?></th>
                    <th style="width: 35%"><?php echo elgg_echo('entity:description')?></th>
                    <th style="width: 5%"></th>
                </tr>
                <?php foreach($tentative_work_entities as $tentative_work_entitie)  {?>
                    <tr id="elgg-object-<?php echo $tentative_work_entitie->guid?>" class="elgg-item" style="height: 40px;">
                        <td class="company-title"><?php  echo $tentative_work_entitie->date; ?></td>
                        <td><?php echo $tentative_work_entitie->shift;?></td>
                        <td><?php echo $tentative_work_entitie->color;?></td>
                        <td><?php echo $tentative_work_entitie->description;?></td>
                        <td class="company-link">
                            <?php
                            $edit_url = "/tentative_work/edit/$tentative_work_entitie->guid";
                            echo elgg_view('output/url', array(
                                'href' => $edit_url,
                                'text' => elgg_echo('entity:edit'),
                                'class' => 'MR_20 elgg-button-edit-information float-alt',
                                'rel' => 'nofollow'
                            ));
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <?php echo elgg_echo('tentative_work:none')?>
        <?php }?>
    </div>

    <div class="clear">
    </div>
