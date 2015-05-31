
<!--<div id="appScreenSize" class="appScreenSize"></div>-->
<div class="sp_dash_form span9 MT_one MB_three" align="center">
    
    
     
	<h2><?php echo elgg_echo("entity:project:security:login"); ?></h2>
     
	    <?php 
                echo elgg_view("input/dropdown", array(
                               "name" => "project_id",	
                               "id" => "chkin_sp_project_id",
                               "options_values" => $vars["projects"],
                			   'data:user:guid' => $vars['user']->guid                               
                              ));
            ?>
        <span class="error_msg clear sp_project_id_err"></span>
    <div id="pending_induction_list" class="clear" style="display:none;"></div>
    <?php echo elgg_view('input/button', array('data:user:guid' => $vars['user']->guid, "data:site:guid"=>"", 'name' => 'btn_site_checkin', 'id' => 'btn_site_checkin', 'class' => 'btn btn_submit MR_20 btn_checkin', 'value' => elgg_echo(''))); ?><span class="ajx-submit-load disp-none"></span>
</div>
<script language="javascript">
$(document).ready(function(e) {
try {
$("#chkin_sp_project_id").msDropDown();
} catch(e) {
alert(e.message);
}

});

		var QB = window.QB = window.QB || {};
		QB.init = function() {
			QB.dumpScreenSize();
			$(window).on('resize', function() {
				QB.dumpScreenSize();
			});
		};
		QB.dumpScreenSize = function() {
			$(".appScreenSize").html('[' + $(window).width() + 'x' + $(window).height() + ']');
		},
		$(document).ready(function() {
				QB.init();
		});
	</script>



