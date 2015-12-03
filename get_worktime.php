<?php
require_once 'link.php';
require_once 'class/Database.class.php';
$params		= array(
    'server' 	=> 'localhost',
    'username'	=> 'root',
    'password'	=> '',
    'database'	=> 'management',
    'table'		=> 'source_link',
);
$database       =   new Database($params);
$queryDate      =   "SELECT * FROM `source_link` WHERE `project_link` = '8'";
$arrayQueryDate =   $database->listRecord($database->query($queryDate)); 
$currentWorkMonth   =   $arrayQueryDate[0]['link_month'];
$currentWorkYear    =   $arrayQueryDate[0]['link_year'];
foreach($working_data as $key => $value) {
    array_pop($working_data[$key]);
    
    $working_data[$key] = array_values($working_data[$key]);
}

$finalArray = array();

$arrayDate  =   array();
foreach($working_data[0] as $key => $value) {
    if(is_numeric($value) == 1 && trim($value) != '' ) {
        if($value > 0 && $value <= 9) {
            $arrayDate[] = '0'.$value.'/'.$currentMonth.'/'.$currentWorkYear;
        } else {
            $arrayDate[] = $value.'/'.$currentMonth.'/'.$currentWorkYear;
        }
    } else {
        continue;
    }
}

unset($working_data[0]);
unset($working_data[1]);
$working_data = array_values($working_data);

for($i = 0 ; $i < count($working_data) ; $i++) {
    foreach($arrayDate as $key => $value) {
        if($working_data[$i][$key+6] == '') {
            $working_data[$i][$key+6] = 0;
        } 
        $finalArray[$value][$working_data[$i][0]][] = $working_data[$i][$key+6];
    }
}

$arrayKey = array(
    'Overtime',
    'Delay',
    'Unpaid',
    'Special Paid',
    'Paid',
    'Others'
);
foreach($finalArray as $key => $value) {
    foreach($value as $k => $v) {
        $finalArray[$key][$k] = array_combine($arrayKey, $v);
    }
}
