<style>

@media(max-width:1025px){



}



@media(max-width:1133px){

.MT_two{
   
   margin-right:230px;
  

}

}

@media(max-width:900px){

.MT_two{
   
     margin-right:400px;
   
}



@media(max-width:336px){

.MT_two{
   
     margin-right:1000px;
   
}

}


@media(max-width:767px){

.span5 input[type="text"]{
   
     width:294px;
   
}


.MT_two{
   
     margin-right:800px;
   
}


}


</style>



<div class="cmp_enity nest_wrap rounded_corners frm_box_shadow frm_box_border span12 MT_one MB_three mger_add">
    <div class="row">
        <div class="span5">
            <label><?php echo elgg_echo("order:from"); ?></label>
            <?php
            echo elgg_view("input/dropdown", array(
                "id" => "a_order_from",
                "class" => "custom-select",
                "options_values" => $vars["order_from_types"]
            ));
            ?>
            <span class="error_msg clear"></span>
        </div>
        <div class="span5">
            <label><?php echo elgg_echo("project:name"); ?></label>
            <?php
            echo elgg_view("input/dropdown", array(
                "id" => "a_paint_project_name",
                "class" => "custom-select"
            ));
            ?>
            <span class="error_msg clear"></span>
        </div>
    </div>
    <div class="row">
        <div class="span5">
            <label><?php echo elgg_echo("material_type:extra:type"); ?></label>
            <?php
            echo elgg_view("input/dropdown", array(
                "id" => "a_material_id",
                "class" => "custom-select"
            ));
            ?>
            <span class="error_msg clear"></span>
        </div>
        <div class="span5">
            <label><?php echo "Project start date"; ?></label>
            <?php
            echo elgg_view("input/dropdown", array(
                "name" => "start_date",
                "id" => "a_start_date",
                "class" => "custom-select"
            ));
            ?>
            <span class="error_msg clear prj_start_date_err"></span>
        </div>
    </div>
    <div class="row">
        <div class="span5">
            <label><?php echo elgg_echo("entity:date"); ?></label>
            <?php echo elgg_view('input/date', array('id' => 'date', 'name' => 'date')); ?><a href="javascript:void(0)" id="date_of_issue_lnk" class="calimage"></a>
            <span class="error_msg clear paint_date_err"></span>
        </div>

        <div class="span5">
            <label><?php echo elgg_echo("paint:used:shift"); ?></label>
            <?php
            $options = array("Moring" => "Shift 1", "Noon" => "Shift 2");
            echo elgg_view("input/dropdown", array(
                "name" => "shift",
                "id" => "shift",
                "class" => "custom-select",
                "options_values" => $options
            ));
            ?>
            <span class="error_msg clear shift_err"></span>
        </div>
    </div>
    <div class="row">
        <div class="span5">
            <label><?php echo elgg_echo("project:nopieces"); ?></label>
            <?php echo elgg_view('input/text', array('name' => 'nopieces', "id" => "nopieces")); ?>
            <span class="error_msg clear nopieces_err"></span>
        </div>
    </div>
    <div class="clear"></div>
    <div  align="center" class="MT_two MB_three">

        <?php echo elgg_view('input/submit', array('name' => 'btn_project_assign_save', 'id' => 'btn_project_assign_save', 'class' => 'btn btn_submit MR_20', 'value' => elgg_echo('manager:save'))); ?>
        <?php echo elgg_view('input/button', array('name' => 'btn_paint_project_cancel', 'id' => 'btn_paint_project_cancel', "onclick" => "javascript:window.location.href='/assign_work/all'", 'class' => 'btn btn_submit_grey', 'value' => elgg_echo('certificate:cancel'))); ?><span class="ajx-submit-load disp-none"></span>
    </div>

    <br/><br/>
</div>
