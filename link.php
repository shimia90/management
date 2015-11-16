<?php
require_once 'function.php';
require_once 'class/Database.class.php';
$params		= array(
    'server' 	=> 'localhost',
    'username'	=> 'root',
    'password'	=> '',
    'database'	=> 'management',
    'table'		=> 'source_link',
);
$database       =   new Database($params);
$currentMonth   =   date('m');
$querySource    =   "SELECT * FROM source_link WHERE `link_month` = '".$currentMonth."'";
$arraySource    =   $database->listRecord($database->query($querySource));   

$today          = date("d/m/Y");
for($i = 0; $i < count($arraySource); $i++) {
    switch ($arraySource[$i]['project_link']) {
        case 1:
            $maintenance_url    =   $arraySource[$i]['link'];
            break;
        case 2: 
            $newcoding_url      =   $arraySource[$i]['link'];
            break;
        case 3:
            $domestic_url        =   $arraySource[$i]['link'];
            break;
        case 4:
            $newton_url         =   $arraySource[$i]['link'];
            break;
        case 5:
            $research_url       =   $arraySource[$i]['link'];
            break;
        case 6:
            $other_url          =   $arraySource[$i]['link'];
            break;   
        case 7:
            $fc_url             =   $arraySource[$i]['link'];
            break;
        case 8:
            $working_url        =   $arraySource[$i]['link'];  
    } 
}
$messageUrl     = '';

// Maitenance Data

$maintenance_data           =       getData($maintenance_url); 

// Newton Data
$newton_data                =       getData($newton_url);

// Domestic Data
$domestic_data              =       getData($domestic_url);

// Domestic Data
$fc_data                    =       getData($fc_url);

// Others
$other_data                 =       getData($other_url);

// Research
$research_data              =       getData($research_url);

// New Coding
$newcoding_data             =       getData($newcoding_url);

// Working
$working_data               =       getData($working_url);

// Get Member
$member_data        =       getData('./csv/member.csv');
$memberArray        =       array();
foreach($member_data as $key => $value) {
    if(trim($value[2]) == '') {
        continue;
    }
    $memberArray[$key][]  =       trim($value[1]);
    $memberArray[$key][]  =       trim($value[2]);
    $memberArray[$key][]  =       trim($value[0]);
    $memberArray[$key][]  =       trim($value[3]);
}