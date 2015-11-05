<?php
require_once '../function.php';
require_once '../process_all.php';
require_once '../class/Database.class.php';
$paramsWork		= array(
    'server' 	=> 'localhost',
    'username'	=> 'root',
    'password'	=> '',
    'database'	=> 'management',
    'table'		=> 'work',
);

$paramsUser		= array(
    'server' 	=> 'localhost',
    'username'	=> 'root',
    'password'	=> '',
    'database'	=> 'management',
    'table'		=> 'user',
);

$paramsProject		= array(
    'server' 	=> 'localhost',
    'username'	=> 'root',
    'password'	=> '',
    'database'	=> 'management',
    'table'		=> 'project_type',
);

$databaseWork       = new Database($paramsWork);
$databaseUser       = new Database($paramsUser);
$databaseProject    = new Database($paramsProject);

$queryUser      = 'SELECT * FROM user';
$queryProject   =   'SELECT * FROM project_type';

$arrayUser      =   $databaseUser->listRecord($databaseUser->query($queryUser));
$arrayProject   =   $databaseProject->listRecord($databaseProject->query($queryProject));   

foreach($arrayMaintenance as $key => $value) {
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    /* foreach($arrayUser as $k => $v) {
        if(trim($value['user']) == trim($v['nickname'])) {
            $workArray[$key]['user'] = $v['id'];
        }
    } */
    /* foreach($arrayProject as $p => $q) {
        if(trim($value['project_type']) == trim($q['project_type'])) {
            $workArray[$key]['project_type'] = $q['id'];
        }
    } */
}
/* echo '<pre>';
print_r($workArray);
echo '</pre>'; */
/* for($i = 0 ; $i < count($workArray); $i++) {
    $databaseWork->insert($workArray[$i]);
} */