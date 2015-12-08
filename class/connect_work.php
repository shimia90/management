<?php
require_once 'Database.class.php';
$paramsWork		= array(
    'server' 	=> 'localhost',
    'username'	=> 'root',
    'password'	=> '',
    'database'	=> 'management',
    'table'		=> 'work',
);
$databaseWork       =   new Database($paramsWork);