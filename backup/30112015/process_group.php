<?php
require_once 'process.php';
$resultArray =  array();

// Create List Of Member
foreach($memberArray as $key => $value) {
    $resultArray[$value[2]][$key]['NICK_NAME'] = $value[0];
    $resultArray[$value[2]][$key]['NAME'] = $value[1];
    $resultArray[$value[2]][$key]['POSITION'] = $value[3];
}



// Add Data From Google Doc
for($i = 0 ; $i < count($data); $i++) {
    foreach($data[$i] as $key => $value) {
        for($j = 1; $j <= count($resultArray); $j++) {
            foreach($resultArray[$j] as $k => $v) {
                if(in_array($key, $v)) {
                    $resultArray[$j][$k]['WORK'] = $data[$i][$key];
                }
            }
        }
    }
}