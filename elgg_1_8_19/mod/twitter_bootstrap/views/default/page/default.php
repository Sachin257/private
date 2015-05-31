<?php
/**
 * Elgg pageshell
 * The standard HTML page shell that everything else fits into
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['title']       The page title
 * @uses $vars['body']        The main content of the page
 * @uses $vars['sysmessages'] A 2d array of various message registers, passed from system_messages()
 */

// backward compatability support for plugins that are not using the new approach
// of routing through admin. See reportedcontent plugin for a simple example.
if (elgg_get_context() == 'admin') {
	if (get_input('handler') != 'admin') {
		elgg_deprecated_notice("admin plugins should route through 'admin'.", 1.8);
	}
	elgg_admin_add_plugin_settings_menu();
	elgg_unregister_css('elgg');
	echo elgg_view('page/admin', $vars);
	return true;
}

// render content before head so that JavaScript and CSS can be loaded. See #4032
$topbar = elgg_view('page/elements/topbar', $vars);
$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));
$header = elgg_view('page/elements/header', $vars);
$body = elgg_view('page/elements/body', $vars);
$footer = elgg_view('page/elements/footer', $vars);
if($vars['class'])
    {
        $class = $vars['class'];
    }
if($vars['tb_head'])
    {
        $tb_head = $vars["tb_head"];
    }
// Set the content type
header("Content-type: text/html; charset=UTF-8");

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php echo elgg_view('page/elements/head', $vars); ?>
    <script type="text/javascript">
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
</head>
<body class="<?php echo $class; ?>">

    
<div class="elgg-page elgg-page-default">
	<div class="elgg-page-topbar navbar navbar-fixed-top">
		<div class="elgg-inner navbar-inner">
			<div class="container headerbg">
				<?php echo $topbar; ?>
                            <div id="appScreenSize" class="appScreenSize" style="display:none;"></div>
			</div>
		</div>
	</div>
    <div class="home_slider">
           <?php if($tb_head){ echo $tb_head; }?>
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="elgg-page-messages"><?php echo $messages; ?></div>
				</div>
			</div>
			<?php  /*if(elgg_is_admin_logged_in()){ ?>
			<div class="row">
				<div class="span12">
					<div class="elgg-page-header"><?php echo $header; ?></div>
				</div>
			</div>
			<?php }*/ ?>
			<div class="row">
                            
                    <div class="elgg-page-body nest_wrap <?php  if(elgg_is_logged_in()){ ?>userloginpg<?php } ?>"><?php echo $body; ?></div>
			</div>
		</div>
    </div>
    <div id="footer" class="footer-outer nest_wrap">
        
            <div class="elgg-page-footer">
                
                <div class="elgg-inner"><?php echo $footer; ?></div>
            </div>
	
    </div>	
</div>
    
<?php  ?>
<?php echo elgg_view('page/elements/foot'); ?>
</body>
</html>