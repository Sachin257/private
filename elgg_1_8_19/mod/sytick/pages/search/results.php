<?php
$search = $_GET["search_content"];
//print "<pre>";print_r($search);print "</pre>";exit;
$title = elgg_echo('search:results', array(''));


$company_ids = company_general_search();
$result_company = get_company_search($search , join($company_ids,",") );
$result_company = array_slice($result_company, 0, 4);
$comapnies =array();
foreach($result_company as $company)
{
    $companies[] = get_entity($company);
}
$vars['companies'] = $companies;
//print "<pre>";print_r($companies);print "</pre>";exit;
                
$project_ids = project_general_search();
$result_project = get_project_search($search , join($project_ids,",") );
$result_project = array_slice($result_project, 0, 4);
$projects = array();
foreach ($result_project as $project)
{
    $projects[] = get_entity($project);
}
//print "<pre>";print_r($projects);print "</pre>";exit;
$vars['projects'] = $projects;
                
$user_ids = user_general_search();
$result_users = get_user_search($search,join($user_ids,",") );
$result_users = array_slice($result_users, 0, 4);
$users =array();
foreach($result_users as $user)
{
    $users[] = get_entity($user);
}
$vars['users'] =$users;
                
$induction_ids = induction_general_search();
$result_induction = get_induction_search($search,join($induction_ids,",") );
$result_induction = array_slice($result_induction, 0, 4);
$inductions = array();
foreach($result_induction as $induction)
{
    $inductions[] = get_entity($induction);
}
$vars['inductions'] = $inductions;

//print "<pre>";print_r($vars);print "</pre>";exit;
$body_title = elgg_view_title($title ,array('class'=>"companytitle"));
$body = elgg_view("search/results", $vars );

$body = elgg_view_layout('one_column', array('title' => $body_title,'content' => $body));

echo elgg_view_page($title, $body);