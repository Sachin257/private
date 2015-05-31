<?php
/**
 * Elgg footer
 * The standard HTML footer that displays across the site
 *
 * @package Elgg
 * @subpackage Core
 *
 */
/*
//bootstrap
echo '<hr>';
echo '<div class="span12">';
echo '</div>';
*/
?>
<div class="fcolumn column_left"> 
	<a href="javascript:void(0)" class="terms"><?php echo elgg_echo("access:footer:useragree"); ?></a>   |   <a href="javascript:void(0)" class="privacy"><?php echo elgg_echo("access:footer:privacy"); ?></a>  
</div>
<div class="fcolumn column_right" align="right">
	<?php echo date("Y").' &copy; ';?> <a href="//stadit.in" target="_blank">Stad TechnoInnovations</a> - <small>All rights reserved.</small>
</div>
<div class="modal fade footerModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="myModalLabelFooter">User Agreement</h1>
      </div>
      <div id="myModalbodyFooter" class="modal-body">
        ...
      </div>
      <div align="center">
        <button type="button" class="btn btn-default btn_submit_grey" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    
