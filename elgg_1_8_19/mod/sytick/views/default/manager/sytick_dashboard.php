
<div class="nest_wrap adm_dashbrd MT_two">
    <div class="adm_row nest_wrap">
        <div class="span4 adm_stats nest_wrap">
            <div class="adm_sites" style="width: 100%;">
            	<?php 
            	$pro_url = "#";
            	if($vars["company_type"] != CONTRACTING_TYPE_COMPANY)
            	{
            		$pro_url = "/project/add";
            	}
            	?>
                <?php echo elgg_echo('manager:dashboard:projects')?>  <a href="<?php echo $pro_url;?>" class="circle">+</a>
                <span class="st_count"><a href="/project/all"><?php echo $vars["projects"];?></a></span>
            </div>
            <div class="adm_statbar column_right"></div>
            <div class="nest_wrap site_status">
                <div class="site_statcount column_left">0</div>
                <div class="stat_text column_right"><?php //echo elgg_echo('admin:dashboard:pending_text')?></div>
            </div>
        </div>
        <div class="span4 nest_wrap">
        	<?php 
            	$comp_url = "#";
            	$list_url = "#";
            	if($vars["company_type"] != CONTRACTING_TYPE_COMPANY)
            	{
            		$comp_url = "/company/add/".CONTRACTING_TYPE_COMPANY;
            		$list_url = "/company/all/".CONTRACTING_TYPE_COMPANY;
            	}
            	?>
            <div class="cnt_cmp">
                <?php echo elgg_echo('admin:dashboard:contracting')?>  <a href="<?php echo $comp_url?>" class="circle">+</a>
                <span class="st_count"><a href="<?php echo $list_url;?>"><?php echo $vars['no_of_companies'];?></a></span>
            </div>
            <div class="adm_statbar column_right"></div>
            <div class="nest_wrap cntr_status">
                <div class="cntr_statcount column_left">10</div>
                <div class="stat_text column_right"><?php //echo elgg_echo('admin:dashboard:pending_text')?></div>
            </div>
        </div>
        <div class="span4">
            <div class="cntr_work">
            	<?php 
            	$emp_url ="/employee/add/";
            	$emp_list_url ="/employee/all";
                echo elgg_echo('manager:dashboard:workers')?> <a href="<?php echo $emp_url;?>" class="circle">+</a>
                <span class="st_count"><a href="<?php echo $emp_list_url;?>"><?php echo $vars['workers']?></a></span>
            </div>
            <div class="adm_statbar column_right"></div>
            <div class="nest_wrap cntr_workstatus">
                <div class="cntr_workcount column_left"><?php echo $vars["workers_not_enabled"]?></div>
                <div class="stat_text column_right"><?php //echo elgg_echo('admin:dashboard:pending_text')?></div>
            </div>
        </div>
    </div>
    <h2>Manage your Accounts</h2>
    <div class="adm_secicons">
        <ul class="nest_wrap">
            <li><span class="ic_settings circle"></span>Settings</li>
            <li><span class="ic_admaccoutns circle"></span>Administration<br />Accounts</li>
            <li><a href="/inductionmanager/all"><span class="ic_induction circle"></span>Induction<br />Manager</a></li>
            <li><a href="/sitemanager/all"><span class="ic_evemanager circle"></span>Site Managers</a></li>
            <li><a href="/manager/all"><span class="ic_mgmaccount circle"></span>Manager<br />Accounts</a></li>
            <li><a href="/security_person/all"><span class="ic_useraccount circle"></span><?php echo elgg_echo("entity:Securities"); ?></a></li>
            <li><span class="ic_reports circle"></span>Reports</li>
        </ul>
    </div>
    <h2>Manage Induction Programs </h2>
    <div class="adm_secicons MB_two">
        <ul class="nest_wrap">
            <li><a href="/induction/all"><span class="ic_courseeditor circle"></span>Course<br />Editor</a></li>
            <li><span class="ic_assessment circle"></span>Assessment<br />Editor</li>
            <li><span class="ic_induction circle"></span>Certificate<br />Manager</li>
        </ul>
    </div>
    <div class="clear"></div>
</div>