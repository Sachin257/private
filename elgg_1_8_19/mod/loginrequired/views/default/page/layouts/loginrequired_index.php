<?php
/**
 * Loginrequired Login page layout
 *
 */

$img_path =  elgg_get_site_url() .'mod/loginrequired/views/default/page/images/';
?>

<div id="content_body">
    	<?php echo elgg_view_form("login");?>
    </div>
<div class="modal fade" id="myregistrationModal" style="display: none;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2><?php echo elgg_echo('registration:getstarted');?><span><?php echo elgg_echo('registration:itsfree');?></span></h2>
        <p><?php echo elgg_echo('registration:lessthan2m');?></p>
      </div>
        <div class="modal-body">

        <?php
            $register = $vars['register'];
            //$login = $vars['login'];
            $mod_params = array('class' => 'elgg-module-highlight');
            //echo $login;
            //echo elgg_view_module('','',$register,$mod_params);
            //echo elgg_view_module('','',$login,$mod_params);
            echo elgg_view_form('register');
        ?>
        </div>
    </div>
  </div>
</div>    
<div class="row" style="margin-left:0;">
</div> <?php  ?>


