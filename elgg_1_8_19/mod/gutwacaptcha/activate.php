<?php
/*
*
* Gutwa Table creator
*
*/

// create tables if not exist
$prefix = elgg_get_config('dbprefix');
$tables = get_db_tables();
if (! in_array("{$prefix}captcha_codes", $tables)) {
    run_sql_script(__DIR__ . '/sql/create_captcha_tables.sql');
    system_message("Table : {$prefix}captcha_codes  has been Created in your database: The {$prefix}captcha_codes is the necessary databaes table for storing gutwacaptcha captcha codes");
}