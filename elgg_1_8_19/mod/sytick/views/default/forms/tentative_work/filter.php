
<div class="col-lg">
    <div class="span4" style="margin-left: 0px;">
        <span>Start date:</span>
        <?php echo elgg_view('input/date', array('id' => 'start_date', "value" => $vars["start_date"], 'name' => 'start_date')); ?><a href="javascript:void(0)" id="date_of_issue_lnk" class="calimage"></a>
    </div>

    <div class="span4" style="margin-left: 0px;">
        <span>End Date</span>
        <?php echo elgg_view('input/date', array('id' => 'final_date', "value" => $vars["final_date"], 'name' => 'final_date')); ?><a href="javascript:void(0)" id="date_of_expiry_lnk" class="calimage"></a>
    </div>
    <div class="span4" style="margin-left: 0px;">
        <?php echo elgg_view('input/button', array( 'id' => 'btn_tentative_filter', 'class' => 'btn btn_submit', 'value' => elgg_echo('entity:filter'))); ?>
        <?php echo elgg_view('input/button', array( 'id' => 'btn_tentative_filter_reset', 'class' => 'btn btn_submit_grey', 'value' => elgg_echo('entity:reset'))); ?>
    </div>
</div>
