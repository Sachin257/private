
<div class="nest_wrap adm_dashbrd MT_two">
    <div class="adm_row nest_wrap">
        <div class="span4 adm_stats nest_wrap">
            <div class="adm_sites" style="width:100%">
                <?php echo "SUMMARY";?>  <a href="#" class="circle">x</a>
                <span class="st_count"><a href="#"></a></span>
            </div>
            <div class="adm_statbar column_right"></div>
            <div class="nest_wrap site_status status">
                <div class="site_statcount column_left"></div>
                <div class="stat_text column_right"></div>
            </div>
        </div>
        <div class="span4 nest_wrap">
            <div class="cnt_cmp" style="width:100%">
                <?php echo "PROJECTS";?>  <a href="/painting_project/add/" class="circle">+</a>
                <span class="st_count"><a href="/painting_project/all"><?=$vars["painting_projects"]; ?></a></span>
            </div>
            <div class="adm_statbar column_right"></div>
            <div class="nest_wrap cntr_workstatus status">
                <div class="cntr_workcount column_left"></div>
                <div class="stat_text column_right"><?php //echo elgg_echo('admin:dashboard:pending_text')?></div>
            </div>
        </div>
        <div class="span4">
            <div class="cntr_work" style="width:100%">
                <?php echo "INVENTORY"?> <a href="/paint/add/" class="circle">+</a>
                <span class="st_count"><a href="/paint/all"><?= $vars["paints"];?></a></span>
            </div>
            <div class="adm_statbar column_right"></div>
            <div class="nest_wrap cntr_workstatus status">
                <div class="cntr_workcount column_left"></div>
                <div class="stat_text column_right"></div>
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
            <!--<li><a href="#"><span class="ic_useraccount circle"></span><?php //echo elgg_echo("entity:Securities"); ?></a></li>-->
            <li><a href="/paint_used"><span class="ic_reports circle"></span>Paint Usage</li>
        </ul>
    </div>
    <div class="clear"></div>
</div>