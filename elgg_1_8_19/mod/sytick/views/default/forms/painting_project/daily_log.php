<?php //print "<pre>";print_r($vars['contracting_companies']) ;print "</pre>"; //exit;   ?>
<div class="modal fade" id="daily_log_add" style="display: none;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="myModalLabel"><?php echo elgg_echo('project:dailylog:add'); ?></h1>
            </div>
            <div class="modal-body">
                <div id="addQuestion" class="userfileup clear span6">		    
                    <div class="nest_wrap">
                        <div class="userrow">
                            <label><?php echo elgg_echo('entity:paint'); ?></label>
                            <?php
                            echo elgg_view("input/dropdown", array(
                                "name" => "paint_id",
                                "id" => "paint_id",
                                "class" => "custom-select",
                                "options_values" => $vars["paints"]
                            ));
                            ?>
                        </div>
                        <br>
                        <span class="error_msg clear paint_err"></span>
                        <div class="clear"></div>
                        <div class="userrow">

                            <label><?php echo elgg_echo("project:nopieces"); ?></label>
                            <?php echo elgg_view('input/text', array('name' => 'nopieces', "id" => "nopieces")); ?>
                            <span class="error_msg clear nopieces_err"></span>      
                        </div>
                        <div class="userrow">
                            <label><?php echo elgg_echo("paint:used:shift"); ?></label>
                            <?php   $options = array("Moring" => "Moring" , "Noon" => "Noon" );
                                    $value = array("Moring" => "Moring");
                                    echo elgg_view('input/radio', array('name' => 'shift', "id" => "shift" , "options" => $options, "value" => $value)); ?>
                            <span class="error_msg clear shift_err"></span>
                        </div>
                        <div class="userrow">
                            <label><?php echo elgg_echo("paint:user:employee"); ?></label>
                            <?php echo elgg_view('input/text', array('name' => 'employee_name', "id" => "employee_name")); ?>
                            <span class="error_msg employee_name_err"></span>
                        </div>
                    </div>      
                </div>
                <div align="center" class="MT_two">
                    <?php
                    echo elgg_view('input/hidden', array('name' => 'project_guid', 'id' => 'project_guid', "value" => $vars["entity"]->guid));
                    ?>	
                    <?php echo elgg_view('input/button', array('id' => 'btn_daily_save', "class" => "btn btn-default btn_submit_grey", 'value' => elgg_echo('certificate:add'))); ?>
                    <?php echo elgg_view('input/button', array('id' => 'btn_daily_cancel', "data-dismiss" => "modal", "class" => "btn btn-default btn_submit_grey", 'value' => elgg_echo('certificate:cancel'))); ?><span class="ajx-submit-load disp-none"></span>
                </div>
            </div>
        </div>
    </div>
