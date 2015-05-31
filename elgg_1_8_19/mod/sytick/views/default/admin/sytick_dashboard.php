
<div class="nest_wrap adm_dashbrd MT_two">
    <div class="adm_row nest_wrap">
        <div class="span4 adm_stats nest_wrap">
            <div class="adm_sites" style="width:100%">
                <?php echo "SUMMARY";?>  <a href="/company/add/<?php echo CONSTRUCTION_TYPE_COMPANY?>" class="circle">x</a>
                <span class="st_count"><a href="/company/all/<?php echo CONSTRUCTION_TYPE_COMPANY;?>"><?php echo $vars["constructing_active"];?></a></span>
            </div>
            <div class="adm_statbar column_right"></div>
            <div class="nest_wrap site_status status">
                <div class="site_statcount column_left"><?php echo $vars["constructing_in_active"]?></div>
                <div class="stat_text column_right"><?php //echo elgg_echo('admin:dashboard:pending_text')?> </div>
            </div>
        </div>
        <div class="span4 nest_wrap">
            <div class="cnt_cmp" style="width:100%">
                <?php echo "PROJECTS";?>  <a href="/company/add/<?php echo CONTRACTING_TYPE_COMPANY?>" class="circle">+</a>
                <span class="st_count"><a href="/company/all/<?php echo CONTRACTING_TYPE_COMPANY;?>"><?php echo $vars["contracting_active"]?></a></span>
            </div>
            <div class="adm_statbar column_right"></div>
            <div class="nest_wrap cntr_status status">
                <div class="cntr_statcount column_left"><?php echo $vars["contracting_in_active"]?></div>
                <div class="stat_text column_right"><?php //echo elgg_echo('admin:dashboard:pending_text')?></div>
            </div>
        </div>
        <div class="span4">
            <div class="cntr_work" style="width:100%">
            	<?php 
            	$profile_type_arr = get_custom_profile_types(CONTRACTOR_PROFILE_TYPE);
            	?>
                <?php echo "INVENTORY"?> <a href="/employee/add/<?php echo $profile_type_arr['guid']?>" class="circle">+</a>
                <span class="st_count"><a href="/contractor/all"><?php echo $vars["active_contractor"];?></a></span>
            </div>
            <div class="adm_statbar column_right"></div>
            <div class="nest_wrap cntr_workstatus status">
                <div class="cntr_workcount column_left"><?php echo $vars["in_active_contractor"];?></div>
                <div class="stat_text column_right"><?php //echo elgg_echo('admin:dashboard:pending_text')?></div>
            </div>
        </div>
    </div>
    <h2>Manage your Accounts</h2>
    <div class="adm_secicons">
        <ul class="nest_wrap">
            <li><a href="#"><span class="ic_settings circle"></span>Daily Settings</li>
            <li><a href="/admin"><span class="ic_admaccoutns circle"></span>Administration<br />Accounts</a></li>
            <li><a href="#"><span class="ic_induction circle"></span>Alert<br />Settings</a></li>
            <li><a href="#"><span class="ic_evemanager circle"></span>Calculations</a></li>
            <li><a href="#"><span class="ic_mgmaccount circle"></span>Efficency<br />Settings</a></li>
            <li><a href="#"><span class="ic_useraccount circle"></span><?php echo elgg_echo("entity:Securities"); ?></a></li>
            <li><span class="ic_reports circle"></span>Reports</li>
        </ul>
    </div>
    <div class="clear"></div>
</div>