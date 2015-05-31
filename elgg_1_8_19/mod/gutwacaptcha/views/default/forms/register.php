<?php
/**
 * Elgg register form
 *
 * @package Elgg
 * @subpackage Core
 */

$password = $password2 = '';
$username = get_input('u');
$email = get_input('e');
$name = get_input('n');

if (elgg_is_sticky_form('register')) {
	extract(elgg_get_sticky_values('register'));
	elgg_clear_sticky_form('register');
}
?>
<div class="mtm name">
	<?php
	echo elgg_view('input/text', array(
		'name' => 'name',
		'id' => 'name',
		'value' => $name,
		'class' => 'elgg-autofocus column_left',
		'placeholder' => elgg_echo('registration:firstname'),
	));
	?>
    <?php
	echo elgg_view('input/text', array(
		'name' => 'custom_profile_fields_lastname',
		'id' => 'custom_profile_fields_lastname',
		'value' => $custom_profile_fields_lastname,
		'class' => 'column_right',
		'placeholder' => elgg_echo('registration:lastname'),
	));
	?>
</div>
<span class="error_msg clear name_err custom_profile_fields_lastname_err"></span>
<div>
	
    <?php
	echo elgg_view('input/text', array(
		'name' => 'email',
		'id' => 'email',
		'value' => $email,
		'placeholder' => elgg_echo('email'),
	));
	?>
</div>
<span class="error_msg clear email_err"></span>
<!-- <div>  -->
	<?php
	echo elgg_view('input/hidden', array(
		'name' => 'username',
		'id' => 'username',
		'value' => $username,
		'placeholder' => elgg_echo('username'),
	));
	?>
<!-- </div>
<span class="error_msg clear username_err"></span> -->
<div>
	<?php
	echo elgg_view('input/password', array(
		'name' => 'password',
		'id' => 'password',
		'value' => $password,
		'placeholder' => elgg_echo('password'),
	));
	?>
</div>
<span class="error_msg clear password_err"></span>
<div>
	<?php
	echo elgg_view('input/password', array(
		'name' => 'password2',
		'id' => 'password2',
		'value' => $password2,
		'placeholder' => elgg_echo('passwordagain'),
	));
	?>
</div>
<span class="error_msg clear password2_err"></span>
<?php
// view to extend to add more fields to the registration form
echo elgg_view('register/extend');

// Add captcha hook
echo elgg_view('input/captcha');

echo '<div class="elgg-foot">';
echo elgg_view('input/hidden', array('name' => 'friend_guid', 'value' => $vars['friend_guid']));
echo elgg_view('input/hidden', array('name' => 'invitecode', 'value' => $vars['invitecode']));
echo elgg_view('input/submit', array('name' => 'submit', 'id'=>'btn_join_now','value' => elgg_echo('registration:joinnow')));
echo '</div>';
