<meta charset="UTF-8">
<?php
require_once '../function.php';
require_once '../class/Database.class.php';
$params		= array(
    'server' 	=> 'localhost',
    'username'	=> 'root',
    'password'	=> '',
    'database'	=> 'management',
    'table'		=> 'user',
);
$database = new Database($params);
$data = getData("../csv/member.csv");

foreach($data as $key => $value) {
    if(trim($value[2]) == '' && empty($value[2])) {
        unset($data[$key]);
    }
}


$arrData = array();
foreach($data as $key => $value) {
    $arrData[$key]['team'] = trim($value[0]);
    $arrData[$key]['nickname'] = trim($value[1]);
    $arrData[$key]['fullname'] = trim($value[2]);
    $arrData[$key]['position'] = trim($value[3]);
}
    echo '<pre>';
    print_r($arrData);
    echo '</pre>';
    //$database->insert($arrData, 'multy');
//echo $database->createInsertSQL( array('id' => 200, 'name'=>'Admin 4', 'ordering' => 99, 'status' => 0)) . '<br />';