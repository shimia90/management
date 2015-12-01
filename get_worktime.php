<?php
require_once 'link.php';


foreach($working_data as $key => $value) {
    array_pop($working_data[$key]);
    
    $working_data[$key] = array_values($working_data[$key]);
}
echo '<pre>';
print_r($working_data);
echo '</pre>';
$arrayDate  =   array();
foreach($working_data[0] as $key => $value) {
    if(is_numeric($value) == 1 && trim($value) != '' ) {
        $arrayDate[] = $value;
    } else {
        continue;
    }
}
unset($working_data[0]);
unset($working_data[1]);
