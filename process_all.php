<?php
require_once 'link.php';

$arrayMaintenance   =       array();
$arrayNewton        =       array();

// Maintenance
array_shift($maintenance_data);
for($i = 0; $i < count($maintenance_data) - 1; $i++) {
    if(trim($maintenance_data[$i][15]) != '' && trim($maintenance_data[$i][16]) != '' && trim($maintenance_data[$i][13]) != '') {
        if($maintenance_data[$i][6] == '') {
            unset($maintenance_data[$i][6]);
            continue;
        } else {
            $maintenance_data[$i][8]    = str_replace(',', '.', $maintenance_data[$i][8]);
            $maintenance_data[$i][19]   = str_replace(',', '.', $maintenance_data[$i][19]); 
            $arrayMaintenance['Maintenance'][$i]['PROJECT_NO']  =    $maintenance_data[$i][1];
            $arrayMaintenance['Maintenance'][$i]['PROJECT_TYPE']  =    'Maintenance';
            $arrayMaintenance['Maintenance'][$i]['ORDER_DATE']  =    $maintenance_data[$i][2];
            $arrayMaintenance['Maintenance'][$i]['PROJECT_NAME']  =    $maintenance_data[$i][4];
            $arrayMaintenance['Maintenance'][$i]['STATUS']  =    $maintenance_data[$i][5];
            $arrayMaintenance['Maintenance'][$i]['STANDARD_DURATION']  =    $maintenance_data[$i][8];
            $arrayMaintenance['Maintenance'][$i]['DELIVERY_DATE']  =    $maintenance_data[$i][12];
            $arrayMaintenance['Maintenance'][$i]['DELIVERY_BEFORE'] = $maintenance_data[$i][10];
            $arrayMaintenance['Maintenance'][$i]['USER']  =    $maintenance_data[$i][6];
            $arrayMaintenance['Maintenance'][$i]['START']  =    $maintenance_data[$i][15];
            $arrayMaintenance['Maintenance'][$i]['END']  =    $maintenance_data[$i][16];
            $arrayMaintenance['Maintenance'][$i]['REAL_DURATION']  =    $maintenance_data[$i][19];
            $arrayMaintenance['Maintenance'][$i]['PERFORMANCE']  =    ($maintenance_data[$i][19] > 0) ? $maintenance_data[$i][8]/$maintenance_data[$i][19] : 0;
            $arrayMaintenance['Maintenance'][$i]['NOTE']  =    $maintenance_data[$i][21];
            $arrayMaintenance['Maintenance'][$i]['REAL_DURATION']  =    str_replace(',', '.', $arrayMaintenance['Maintenance'][$i]['REAL_DURATION']);
        }
    }
}

//Newton
array_shift($newton_data);

for($i = 0; $i < count($newton_data) -1; $i++) {
    if( trim($newton_data[$i][15]) != '' && trim($newton_data[$i][16]) != '' && trim($newton_data[$i][13]) != '') {
        if($newton_data[$i][6] == '') {
            unset($newton_data[$i][6]);
            continue;
        } else {
            $newton_data[$i][8]    = str_replace(',', '.', $newton_data[$i][8]);
            $newton_data[$i][19]   = str_replace(',', '.', $newton_data[$i][19]);
            $arrayNewton['Newton'][$i]['PROJECT_NO'] =    $newton_data[$i][1];
            $arrayNewton['Newton'][$i]['PROJECT_TYPE']  =    'Newton';
            $arrayNewton['Newton'][$i]['ORDER_DATE']  =  $newton_data[$i][11];
            $arrayNewton['Newton'][$i]['PROJECT_NAME'] =    $newton_data[$i][4];
            $arrayNewton['Newton'][$i]['STATUS']  =    $newton_data[$i][5];
            $arrayNewton['Newton'][$i]['STANDARD_DURATION']  =    $newton_data[$i][8];
            $arrayNewton['Newton'][$i]['DELIVERY_DATE']  =    '<strong>'.$newton_data[$i][10]. '</strong>'. ' ' . $newton_data[$i][12];
            $arrayNewton['Newton'][$i]['USER']  =    $newton_data[$i][6];
            $arrayNewton['Newton'][$i]['START']  =    $newton_data[$i][15];
            $arrayNewton['Newton'][$i]['END']  =    $newton_data[$i][16];
            $arrayNewton['Newton'][$i]['REAL_DURATION']  =    $newton_data[$i][19];
            $arrayNewton['Newton'][$i]['PERFORMANCE']  =    ($newton_data[$i][19] > 0) ? $newton_data[$i][8]/$newton_data[$i][19] : 0;
            $arrayNewton['Newton'][$i]['NOTE']  =    $newton_data[$i][21];
        }
    }
}
