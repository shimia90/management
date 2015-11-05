<?php
function getData($url) {
    $array_data = array();
    if(!ini_set('default_socket_timeout', 15)) echo "<!-- unable to change socket timeout -->";
    
    if (($handle = @fopen($url, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $array_data[]=$data;
        }
        fclose($handle);
    }
    else {
        $array_data = array();
    }
    return $array_data;
}

function projectTypeBg($data) {
    $class  = "";
    if(trim($data) == "Maintenance") {
        $class = "success";
    } elseif (trim($data) == "Newton") {
        $class = "info";
    }
    return $class;
}

function removeArrayItem($arrayRemove = array(), $arraySource = array()) {
    foreach($arrayRemove as $key => $value) {
        if(array_key_exists($value, $arraySource)) {
            unset($arraySource[$value]);
        }
    }
    return $arraySource;
}

function convertMonth($str) {
    $month = '';
    $arrayDate = explode('/', $str);
    $month = $arrayDate[1];
    return $month;
}
