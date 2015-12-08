<?php
require_once 'Database.class.php';
$paramsUser     =   array(
                            'server' 	=> 'localhost',
                            'username'	=> 'root',
                            'password'	=> '',
                            'database'	=> 'management',
                            'table'		=> 'user',
                        );
$databaseUser       =   new Database($paramsUser);
$arrayUser          =   $databaseUser->listRecord($databaseUser->query('SELECT * FROM user'));