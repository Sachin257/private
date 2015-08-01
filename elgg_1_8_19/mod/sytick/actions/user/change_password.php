<?php
$user_guid = get_input('guid');
$name = strip_tags(get_input('name'));

elgg_set_user_password();

forward(REFERER);