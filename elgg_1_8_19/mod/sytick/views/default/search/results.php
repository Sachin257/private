<div class="clear"></div>
<div class="cmp_list rounded_corners frm_box_shadow frm_box_border MB_five mgr_listall">
    <div class="search_box nest_wrap "> 
    </div>
    <div id="tabs">
        <ul>
            <li><button class="tab" id="search_all">ALL RESULTS</button></li>
            <li><button class="tab" id="search_project">PROJECTS</button></li>
            <li><button class="tab" id="search_user">USERS</button></li>
            <li><button class="tab" id="search_company">COMPANIES</button></li>
            <li><button class="tab" id="search_induction">INDUCTIONS</button></li>
        </ul>
        <div id="results">
                <?php echo elgg_view('search/all', $vars)?>
        </div>
    </div>
</div>
