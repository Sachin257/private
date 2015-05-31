<div class="sp_dash_form span10 MT_one MB_three" align="center">
    <!--<div class="sp_dash_logo"><img src="<?php echo $vars["image_url"]?>" /></div>-->
    
		<h2 class="checin_index_h2"><?php echo $vars["company"]->title; ?></h2>
                <div class="clearfix"></div>
		<h4 class="checin_index_h4" ><?php echo $vars["check_in_out_site"]->title; ?> | 
                    <a data:user:guid="<?php echo $vars['user']->guid;?>" data:site:guid="<?php echo $vars['check_in_out_site']->guid;?>" href="javascript:void(0);" class="MR_20 " id="security_checkout">Checkout</a>
                </h4> 
		<div class="checin_index_dvs MT_five">
			<div id="contractor-dv" class="chkin_con_dv MR_ten"> 
                            <div class="cmn_bg">
				<a href="/project/check_in_out/<?php echo $vars["check_in_out_site"]->project_name;?>/contractor" id="contractor_scr_lnk">
                                    <?php echo elgg_echo('checkin:contractor')?><br />
                                    <span>Check-in/Check-out</span>
                                </a>
                           </div>     
			</div>
			<div id="staff-dv" class="chkin_staff_dv"> 
                            <div class="cmn_bg">
				<a href="/project/check_in_out/<?php echo $vars["check_in_out_site"]->project_name;?>/staff" id="contractor_scr_lnk">
                                    <?php echo elgg_echo('checkin:staff')?><br />
                                    <span>Check-in/Check-out</span>
                                </a>
                            </div>     
			</div>
			<div class="clear"></div>
                        
			<div id="visitor-dv" class="chkin_visitor_dv MR_ten MT_ten"> 
                            <div class="cmn_bg">
				<a href="#" id="contractor_scr_lnk">
                                    <?php echo elgg_echo('checkin:visitor')?><br />
                                    <span>Check-in/Check-out</span>
                                </a>
                            </div>
			</div>
                        <div id="stafffrieght-dv" class="chkin_frieght_dv MT_ten"> 
                            <div class="cmn_bg">
				<a href="#" id="contractor_scr_lnk">
                                    <?php echo elgg_echo('checkin:frieght')?><br />
                                    <span>Check-in/Check-out</span>
                                </a>
                            </div>
			</div>
		</div>		      

</div>