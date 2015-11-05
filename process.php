<?php
require_once 'link.php';

$newArray = array();

// Maintenance
array_shift($maintenance_data);
for($i = 0; $i < count($maintenance_data) - 1; $i++) {
    if($maintenance_data[$i][13] == $today && trim($maintenance_data[$i][15]) != '' && trim($maintenance_data[$i][16]) != '' && trim($maintenance_data[$i][13]) != '') {
        if($maintenance_data[$i][6] == '') {
            unset($maintenance_data[$i][6]);
            continue;
        } else {
            $maintenance_data[$i][8]    = str_replace(',', '.', $maintenance_data[$i][8]);
            $maintenance_data[$i][19]   = str_replace(',', '.', $maintenance_data[$i][19]); 
            $newArray[$i]['PROJECT_NO']  =    $maintenance_data[$i][1];
            $newArray[$i]['PROJECT_TYPE']  =    'Maintenance';
            $newArray[$i]['ORDER_DATE']  =    $maintenance_data[$i][2];
            $newArray[$i]['PROJECT_NAME']  =    $maintenance_data[$i][4];
            $newArray[$i]['STATUS']  =    $maintenance_data[$i][5];
            $newArray[$i]['STANDARD_DURATION']  =    $maintenance_data[$i][8];
            $newArray[$i]['DELIVERY_DATE']  =    $maintenance_data[$i][12];
            $newArray[$i]['DELIVERY_BEFORE'] = $maintenance_data[$i][10];
            $newArray[$i]['USER']  =    $maintenance_data[$i][6];
            $newArray[$i]['START']  =    $maintenance_data[$i][15];
            $newArray[$i]['END']  =    $maintenance_data[$i][16];
            $newArray[$i]['REAL_DURATION']  =    $maintenance_data[$i][19];
            $newArray[$i]['PERFORMANCE']  =    ($maintenance_data[$i][19] > 0) ? $maintenance_data[$i][8]/$maintenance_data[$i][19] : 0;
            $newArray[$i]['NOTE']  =    $maintenance_data[$i][21];
            $newArray[$i]['REAL_DURATION']  =    str_replace(',', '.', $newArray[$i]['REAL_DURATION']);
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
            $newArray[$i]['PROJECT_NO']  =    $newton_data[$i][1];
            $newArray[$i]['PROJECT_TYPE']  =    'Newton';
            $newArray[$i]['ORDER_DATE']  =  $newton_data[$i][11];
            $newArray[$i]['PROJECT_NAME']  =    $newton_data[$i][4];
            $newArray[$i]['STATUS']  =    $newton_data[$i][5];
            $newArray[$i]['STANDARD_DURATION']  =    $newton_data[$i][8];
            $newArray[$i]['DELIVERY_DATE']  =    '<strong>'.$newton_data[$i][10]. '</strong>'. ' ' . $newton_data[$i][12];
            $newArray[$i]['USER']  =    $newton_data[$i][6];
            $newArray[$i]['START']  =    $newton_data[$i][15];
            $newArray[$i]['END']  =    $newton_data[$i][16];
            $newArray[$i]['REAL_DURATION']  =    $newton_data[$i][19];
            $newArray[$i]['PERFORMANCE']  =    ($newton_data[$i][19] > 0) ? $newton_data[$i][8]/$newton_data[$i][19] : 0;
            $newArray[$i]['NOTE']  =    $newton_data[$i][21];
        }
    }
}


$result = array();

// Go over the data one by one
foreach ($newArray as $key => $item)
{
    // Use the category name to identify unique categories
    $name = $item['USER'];
    
    // If the category appears in the auxiliary variable
    if (isset($result[$name]))
    {
        // Then add the orders total to it
        /* $result[$name]['DURATION'] = str_replace(',', '.', $result[$name]['DURATION']);
        $item['DURATION'] = str_replace(',', '.', $item['DURATION']); */
        
        $result[$name][$name][$key]['PROJECT_NO'] = $item['PROJECT_NO'];
        $result[$name][$name][$key]['PROJECT_TYPE'] = $item['PROJECT_TYPE'];
        $result[$name][$name][$key]['ORDER_DATE'] = $item['ORDER_DATE'];
        $result[$name][$name][$key]['PROJECT_NAME'] = $item['PROJECT_NAME'];
        $result[$name][$name][$key]['STANDARD_DURATION'] = $item['STANDARD_DURATION'];
        $result[$name][$name][$key]['DELIVERY_DATE'] = $item['DELIVERY_DATE'];
        $result[$name][$name][$key]['USER'] = $item['USER'];
        $result[$name][$name][$key]['START'] = $item['START'];
        $result[$name][$name][$key]['END'] = $item['END'];
        $result[$name][$name][$key]['REAL_DURATION'] = $item['REAL_DURATION'];
        $result[$name][$name][$key]['PERFORMANCE'] = $item['PERFORMANCE'];
        $result[$name][$name][$key]['NOTE'] = $item['NOTE'];
        
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

