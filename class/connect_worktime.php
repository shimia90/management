<?php
require_once 'Database.class.php';
$paramsWorktime     =   array(
                            'server' 	=> 'localhost',
                            'username'	=> 'root',
                            'password'	=> '',
                            'database'	=> 'management',
                            'table'		=> 'work_time',
                        );
$dbWorktime         =   new Database($paramsWorktime);
$queryWorktime      =   'SELECT * FROM `work_time`';
$arraydbWorktime    =   $dbWorktime->listRecord($dbWorktime->query($queryWorktime));