<?php
require_once 'link.php';

$newArray = array();

// Maintenance
for($i = 0; $i < count($maintenance_data) - 1; $i++) {
    if($maintenance_data[$i][13] == $today && trim($maintenance_data[$i][15]) != '' && trim($maintenance_data[$i][16]) != '' && trim($maintenance_data[$i][13]) != '') {
        if($maintenance_data[$i][6] == '') {
            unset($maintenance_data[$i][6]);
            continue;
        } else {
            $maintenance_data[$i][8]    = str_replace(',', '.', $maintenance_data[$i][8]);
            $maintenance_data[$i][19]   = str_replace(',', '.', $maintenance_data[$i][19]); 
            $newArray[$i]['NO']  =    $maintenance_data[$i][1];
            $newArray[$i]['PROJECT_TYPE']  =    'Maintenance';
            $newArray[$i]['ORDER_DATE']  =    $maintenance_data[$i][2];
            $newArray[$i]['SITE']  =    $maintenance_data[$i][4];
            $newArray[$i]['STANDARD_DURATION']  =    $maintenance_data[$i][8];
            $newArray[$i]['DELIVERY']  =    '<strong>'.$maintenance_data[$i][10]. '</strong>'. ' ' . $maintenance_data[$i][12];
            $newArray[$i]['MAIN_DES']  =    $maintenance_data[$i][6];
            $newArray[$i]['START_WORK']  =    $maintenance_data[$i][15];
            $newArray[$i]['END_WORK']  =    $maintenance_data[$i][16];
            $newArray[$i]['REAL_DURATION']  =    $maintenance_data[$i][19];
            $newArray[$i]['PERFORMANCE']  =    $maintenance_data[$i][8]/$maintenance_data[$i][19];
            $newArray[$i]['NOTES']  =    $maintenance_data[$i][21];
            /* $newArray[$i]['REAL_DURATION']  =    str_replace(',', '.', $newArray[$i]['REAL_DURATION']); */
        }
    }
}

//Newton
for($i = 0; $i < count($newton_data) - 1; $i++) {
    if($newton_data[$i][13] == $today && trim($newton_data[$i][15]) != '' && trim($newton_data[$i][16]) != '' && trim($newton_data[$i][13]) != '') {
        if($newton_data[$i][6] == '') {
            unset($newton_data[$i][6]);
            continue;
        } else {
            $newton_data[$i][8]    = str_replace(',', '.', $newton_data[$i][8]);
            $newton_data[$i][19]   = str_replace(',', '.', $newton_data[$i][19]);
            $newArray[$i]['NO']  =    $newton_data[$i][1];
            $newArray[$i]['PROJECT_TYPE']  =    'Newton';
            $newArray[$i]['ORDER_DATE']  =  $newton_data[$i][11];
            $newArray[$i]['SITE']  =    $newton_data[$i][4];
            $newArray[$i]['STANDARD_DURATION']  =    $newton_data[$i][8];
            $newArray[$i]['DELIVERY']  =    '<strong>'.$newton_data[$i][10]. '</strong>'. ' ' . $newton_data[$i][12];
            $newArray[$i]['MAIN_DES']  =    $newton_data[$i][6];
            $newArray[$i]['START_WORK']  =    $newton_data[$i][15];
            $newArray[$i]['END_WORK']  =    $newton_data[$i][16];
            $newArray[$i]['REAL_DURATION']  =    $newton_data[$i][19];
            $newArray[$i]['PERFORMANCE']  =    $newton_data[$i][8]/$newton_data[$i][19];
            $newArray[$i]['NOTES']  =    $newton_data[$i][21];
        }
    }
}


$result = array();

// Go over the data one by one
foreach ($newArray as $key => $item)
{
    // Use the category name to identify unique categories
    $name = $item['MAIN_DES'];
    
    // If the category appears in the auxiliary variable
    if (isset($result[$name]))
    {
        // Then add the orders total to it
        /* $result[$name]['DURATION'] = str_replace(',', '.', $result[$name]['DURATION']);
        $item['DURATION'] = str_replace(',', '.', $item['DURATION']); */
        
        $result[$name][$name][$key]['NO'] = $item['NO'];
        $result[$name][$name][$key]['PROJECT_TYPE'] = $item['PROJECT_TYPE'];
        $result[$name][$name][$key]['ORDER_DATE'] = $item['ORDER_DATE'];
        $result[$name][$name][$key]['SITE'] = $item['SITE'];
        $result[$name][$name][$key]['STANDARD_DURATION'] = $item['STANDARD_DURATION'];
        $result[$name][$name][$key]['DELIVERY'] = $item['DELIVERY'];
        $result[$name][$name][$key]['MAIN_DES'] = $item['MAIN_DES'];
        $result[$name][$name][$key]['START_WORK'] = $item['START_WORK'];
        $result[$name][$name][$key]['END_WORK'] = $item['END_WORK'];
        $result[$name][$name][$key]['REAL_DURATION'] = $item['REAL_DURATION'];
        $result[$name][$name][$key]['PERFORMANCE'] = $item['PERFORMANCE'];
        $result[$name][$name][$key]['NOTES'] = $item['NOTES'];
        
        /* $result[$name]['DURATION'] = $result[$name]['DURATION'] + $item['DURATION']; */
    }
    else // Otherwise
    {
        // Add the category to the auxiliary variable
        $result[$name][$name][$key] = $item;
        
    }
}
// Get the values from the auxiliary variable and override the
// old $data array. This is not strictly necessary, but if you
// want the indices to be numeric and in order then do this.
$data = array_values($result);
