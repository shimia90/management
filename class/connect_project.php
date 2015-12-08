<?php
require_once 'Database.class.php';
$paramsProject		= array(
    'server' 	=> 'localhost',
    'username'	=> 'root',
    'password'	=> '',
    'database'	=> 'management',
    'table'		=> 'project_type',
);
$databaseProject    =   new Database($paramsProject);