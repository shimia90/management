<meta charset="UTF-8"><?php
require_once 'link.php';

$arrayMaintenance       =   array();
$arrayNewton            =   array();
$arrayDomestic          =   array();
$arrayFc                =   array();
$arrayOther             =   array();
$arrayResearch          =   array();
$arrayNewCoding         =   array();
$arrayNewtonDetail      =   array();
$arrayFcDetail          =   array();
$arrayNewCodingDetail   =   array();

// Maintenance
array_shift($maintenance_data);
for ($i = 0; $i < count($maintenance_data) - 1; $i ++) {
    if (trim($maintenance_data[$i][15]) != '' && trim($maintenance_data[$i][16]) != '' && trim($maintenance_data[$i][13]) != '') {
        if ($maintenance_data[$i][6] == '') {
            unset($maintenance_data[$i][6]);
            continue;
        } else {
            $maintenance_data[$i][8] = str_replace(',', '.', $maintenance_data[$i][8]);
            $maintenance_data[$i][19] = str_replace(',', '.', $maintenance_data[$i][19]);
            $arrayMaintenance['Maintenance'][$i]['PROJECT_NO'] = $maintenance_data[$i][1];
            $arrayMaintenance['Maintenance'][$i]['PROJECT_TYPE'] = 'Maintenance';
            $arrayMaintenance['Maintenance'][$i]['ORDER_DATE'] = $maintenance_data[$i][2];
            $arrayMaintenance['Maintenance'][$i]['WORK_DATE'] = $maintenance_data[$i][13];
            $arrayMaintenance['Maintenance'][$i]['PROJECT_NAME'] = $maintenance_data[$i][4];
            $arrayMaintenance['Maintenance'][$i]['STATUS'] = $maintenance_data[$i][5];
            $arrayMaintenance['Maintenance'][$i]['STANDARD_DURATION'] = $maintenance_data[$i][8];
            $arrayMaintenance['Maintenance'][$i]['DELIVERY_DATE'] = $maintenance_data[$i][12];
            $arrayMaintenance['Maintenance'][$i]['DELIVERY_BEFORE'] = $maintenance_data[$i][10];
            $arrayMaintenance['Maintenance'][$i]['USER'] = $maintenance_data[$i][6];
            $arrayMaintenance['Maintenance'][$i]['START'] = $maintenance_data[$i][15];
            $arrayMaintenance['Maintenance'][$i]['END'] = $maintenance_data[$i][16];
            $arrayMaintenance['Maintenance'][$i]['REAL_DURATION'] = $maintenance_data[$i][19];
            $arrayMaintenance['Maintenance'][$i]['PERFORMANCE'] = ($maintenance_data[$i][19] > 0) ? (round($maintenance_data[$i][8] / $maintenance_data[$i][19], 2)) : 0;
            $arrayMaintenance['Maintenance'][$i]['NOTE'] = $maintenance_data[$i][21];
            $arrayMaintenance['Maintenance'][$i]['PAGE_NAME'] = '';
            $arrayMaintenance['Maintenance'][$i]['PAGE_NUMBER'] = '';
            $arrayMaintenance['Maintenance'][$i]['TYPE'] = '';
            $arrayMaintenance['Maintenance'][$i]['WORK_CONTENT'] = '';
        }
    }
}

//Newton Detail
array_shift($newton_detail_data);


for ($i = 0; $i < count($newton_detail_data) - 1; $i ++) {
    if (trim($newton_detail_data[$i][11]) != '' && trim($newton_detail_data[$i][12]) != '' && trim($newton_detail_data[$i][13]) != '') {
        if ($newton_detail_data[$i][6] == '') {
            unset($newton_detail_data[$i][6]);
            continue;
        } else {
            $newton_detail_data[$i][8] = str_replace(',', '.', $newton_detail_data[$i][8]);
            //$newton_detail_data[$i][5] = str_replace(',', '.', $newton_detail_data[$i][5]);
            $arrayNewtonDetail['Newton'][$i]['PROJECT_NO'] = $newton_detail_data[$i][1];
            $arrayNewtonDetail['Newton'][$i]['PROJECT_TYPE'] = 'Newton';
            $arrayNewtonDetail['Newton'][$i]['ORDER_DATE'] = $newton_detail_data[$i][11];
            $arrayNewtonDetail['Newton'][$i]['WORK_DATE'] = $newton_detail_data[$i][13];
            $arrayNewtonDetail['Newton'][$i]['PROJECT_NAME'] = $newton_detail_data[$i][4];
            $arrayNewtonDetail['Newton'][$i]['STATUS'] = $newton_detail_data[$i][5];
            $arrayNewtonDetail['Newton'][$i]['STANDARD_DURATION'] = $newton_detail_data[$i][8];
            $arrayNewtonDetail['Newton'][$i]['DELIVERY_DATE'] = $newton_detail_data[$i][12];
            $arrayNewtonDetail['Newton'][$i]['DELIVERY_BEFORE'] = $newton_detail_data[$i][10];
            $arrayNewtonDetail['Newton'][$i]['USER'] = $newton_detail_data[$i][6];
            $arrayNewtonDetail['Newton'][$i]['START'] = $newton_detail_data[$i][15];
            $arrayNewtonDetail['Newton'][$i]['END'] = $newton_detail_data[$i][16];
            $arrayNewtonDetail['Newton'][$i]['REAL_DURATION'] = $newton_detail_data[$i][19];
            $arrayNewtonDetail['Newton'][$i]['PERFORMANCE'] = '';
            $arrayNewtonDetail['Newton'][$i]['NOTE'] = $newton_detail_data[$i][21];
            $arrayNewtonDetail['Newton'][$i]['PAGE_NAME'] = '';
            $arrayNewtonDetail['Newton'][$i]['PAGE_NUMBER'] = '';
            $arrayNewtonDetail['Newton'][$i]['TYPE'] = $newton_detail_data[$i][2];
            $arrayNewtonDetail['Newton'][$i]['WORK_CONTENT'] = '';
        }
    }
}

// Newton
array_shift($newton_data);

for ($i = 0; $i < count($newton_data) - 1; $i ++) {
    if (trim($newton_data[$i][9]) != '' && trim($newton_data[$i][10]) != '' && trim($newton_data[$i][0]) != '') {
        if ($newton_data[$i][7] == '') {
            unset($newton_data[$i][7]);
            continue;
        } else {
            $newton_data[$i][4] = str_replace(',', '.', $newton_data[$i][4]);
            $newton_data[$i][5] = str_replace(',', '.', $newton_data[$i][5]);
            $arrayNewton['Newton'][$i]['PROJECT_NO'] = $newton_data[$i][1];
            $arrayNewton['Newton'][$i]['PROJECT_TYPE'] = 'Newton';
            $arrayNewton['Newton'][$i]['ORDER_DATE'] = '';
            $arrayNewton['Newton'][$i]['DELIVERY_DATE'] = '';
            $arrayNewton['Newton'][$i]['DELIVERY_BEFORE'] = '';
            foreach($arrayNewtonDetail['Newton'] as $a => $b) {
                
                if($arrayNewtonDetail['Newton'][$a]['PROJECT_NO'] == $newton_data[$i][1] && $arrayNewtonDetail['Newton'][$a]['PROJECT_NAME'] == $newton_data[$i][2] && $arrayNewtonDetail['Newton'][$a]['USER'] == $newton_data[$i][7] && $arrayNewtonDetail['Newton'][$a]['WORK_DATE'] == $newton_data[$i][0]) {
                    $arrayNewton['Newton'][$i]['ORDER_DATE']            = $b['ORDER_DATE'];
                    $arrayNewton['Newton'][$i]['DELIVERY_DATE']         = $b['DELIVERY_DATE'];
                    $arrayNewton['Newton'][$i]['DELIVERY_BEFORE']       = $b['DELIVERY_BEFORE'];
                }
            }
               
            
            $arrayNewton['Newton'][$i]['WORK_DATE'] = $newton_data[$i][0];
            $arrayNewton['Newton'][$i]['PROJECT_NAME'] = $newton_data[$i][2];
            $arrayNewton['Newton'][$i]['STATUS'] = $newton_data[$i][8];
            $arrayNewton['Newton'][$i]['STANDARD_DURATION'] = $newton_data[$i][4];
            
            $arrayNewton['Newton'][$i]['DELIVERY_BEFORE'] = '';
            $arrayNewton['Newton'][$i]['USER'] = $newton_data[$i][7];
            $arrayNewton['Newton'][$i]['START'] = $newton_data[$i][9];
            $arrayNewton['Newton'][$i]['END'] = $newton_data[$i][10];
            $arrayNewton['Newton'][$i]['REAL_DURATION'] = $newton_data[$i][5];
            $arrayNewton['Newton'][$i]['PERFORMANCE'] = ($newton_data[$i][4] > 0 && $newton_data[$i][5] > 0) ? (round($newton_data[$i][5] / $newton_data[$i][4], 2)) : 0;
            $arrayNewton['Newton'][$i]['NOTE'] = $newton_data[$i][12];
            $arrayNewton['Newton'][$i]['PAGE_NAME'] = $newton_data[$i][6];
            $arrayNewton['Newton'][$i]['PAGE_NUMBER'] = '';
            $arrayNewton['Newton'][$i]['TYPE'] = $newton_data[$i][3];
            $arrayNewton['Newton'][$i]['WORK_CONTENT'] = '';
        }
    }
}
// Domestic Data

array_shift($domestic_data);

for ($i = 0; $i < count($domestic_data) - 1; $i ++) {
    if (trim($domestic_data[$i][9]) != '' && trim($domestic_data[$i][10]) != '' && trim($domestic_data[$i][0]) != '') {
        if ($domestic_data[$i][7] == '') {
            unset($domestic_data[$i][7]);
            continue;
        } else {
            $domestic_data[$i][4] = str_replace(',', '.', $domestic_data[$i][4]);
            $domestic_data[$i][5] = str_replace(',', '.', $domestic_data[$i][5]);
            $arrayDomestic['Domestic'][$i]['PROJECT_NO'] = '';
            $arrayDomestic['Domestic'][$i]['PROJECT_TYPE'] = 'Domestic';
            $arrayDomestic['Domestic'][$i]['ORDER_DATE'] = '';
            $arrayDomestic['Domestic'][$i]['WORK_DATE'] = $domestic_data[$i][0];
            $arrayDomestic['Domestic'][$i]['PROJECT_NAME'] = $domestic_data[$i][1];
            $arrayDomestic['Domestic'][$i]['STATUS'] = $domestic_data[$i][8];
            $arrayDomestic['Domestic'][$i]['STANDARD_DURATION'] = $domestic_data[$i][4];
            $arrayDomestic['Domestic'][$i]['DELIVERY_DATE'] = '';
            $arrayDomestic['Domestic'][$i]['DELIVERY_BEFORE'] = '';
            $arrayDomestic['Domestic'][$i]['USER'] = $domestic_data[$i][7];
            $arrayDomestic['Domestic'][$i]['START'] = $domestic_data[$i][9];
            $arrayDomestic['Domestic'][$i]['END'] = $domestic_data[$i][10];
            $arrayDomestic['Domestic'][$i]['REAL_DURATION'] = $domestic_data[$i][5];
            $arrayDomestic['Domestic'][$i]['PERFORMANCE'] = ($domestic_data[$i][4] > 0 && $domestic_data[$i][5] > 0) ? (round($domestic_data[$i][5] / $domestic_data[$i][4], 2)) : 0;
            $arrayDomestic['Domestic'][$i]['NOTE'] = $domestic_data[$i][12];
            $arrayDomestic['Domestic'][$i]['PAGE_NAME'] = '';
            $arrayDomestic['Domestic'][$i]['PAGE_NUMBER'] = $domestic_data[$i][3];
            $arrayDomestic['Domestic'][$i]['TYPE'] = $domestic_data[$i][2];
            $arrayDomestic['Domestic'][$i]['WORK_CONTENT'] = $domestic_data[$i][6];
        }
    }
}

// FC Detail

/* array_shift($fc_detail_data);

for ($i = 0; $i < count($fc_detail_data) - 1; $i ++) {
    if (trim($fc_detail_data[$i][6]) != '' && trim($fc_detail_data[$i][7]) != '' && trim($fc_detail_data[$i][9]) != '') {
        if ($fc_detail_data[$i][8] == '') {
            unset($fc_detail_data[$i][8]);
            continue;
        } else {
            $arrayFcDetail['FC'][$i]['PROJECT_NO'] = $fc_detail_data[$i][0];
            $arrayFcDetail['FC'][$i]['PROJECT_TYPE'] = 'FC';
            $arrayFcDetail['FC'][$i]['ORDER_DATE'] = $fc_detail_data[$i][6];
            $arrayFcDetail['FC'][$i]['WORK_DATE'] = '';
            $arrayFcDetail['FC'][$i]['PROJECT_NAME'] = $fc_detail_data[$i][2];
            $arrayFcDetail['FC'][$i]['STATUS'] = $fc_detail_data[$i][9];
            $arrayFcDetail['FC'][$i]['STANDARD_DURATION'] = '';
            $arrayFcDetail['FC'][$i]['DELIVERY_DATE'] = '';
            $arrayFcDetail['FC'][$i]['DELIVERY_BEFORE'] = '';
            $arrayFcDetail['FC'][$i]['USER'] = $fc_detail_data[$i][8];
            $arrayFcDetail['FC'][$i]['START'] = $fc_detail_data[$i][10];
            $arrayFcDetail['FC'][$i]['END'] = $fc_detail_data[$i][11];
            $arrayFcDetail['FC'][$i]['REAL_DURATION'] = '';
            $arrayFcDetail['FC'][$i]['PERFORMANCE'] = 0;
            $arrayFcDetail['FC'][$i]['NOTE'] = $fc_detail_data[$i][13];
            $arrayFcDetail['FC'][$i]['PAGE_NAME'] = $fc_detail_data[$i][7];
            $arrayFcDetail['FC'][$i]['PAGE_NUMBER'] = $fc_detail_data[$i][4];
            $arrayFcDetail['FC'][$i]['TYPE'] = $fc_detail_data[$i][3];
            $arrayFcDetail['FC'][$i]['WORK_CONTENT'] = '';
        }
    }
} */

// FC Data

array_shift($fc_data);

for ($i = 0; $i < count($fc_data) - 1; $i ++) {
    if (trim($fc_data[$i][10]) != '' && trim($fc_data[$i][11]) != '' && trim($fc_data[$i][0]) != '') {
        if ($fc_data[$i][8] == '') {
            unset($fc_data[$i][8]);
            continue;
        } else {
            $fc_data[$i][5] = str_replace(',', '.', $fc_data[$i][5]);
            $fc_data[$i][6] = str_replace(',', '.', $fc_data[$i][6]);
            $arrayFc['FC'][$i]['PROJECT_NO'] = $fc_data[$i][1];
            $arrayFc['FC'][$i]['PROJECT_TYPE'] = 'FC';
            $arrayFc['FC'][$i]['ORDER_DATE'] = '';
            $arrayFc['FC'][$i]['WORK_DATE'] = $fc_data[$i][0];
            $arrayFc['FC'][$i]['PROJECT_NAME'] = $fc_data[$i][2];
            $arrayFc['FC'][$i]['STATUS'] = $fc_data[$i][9];
            $arrayFc['FC'][$i]['STANDARD_DURATION'] = $fc_data[$i][5];
            $arrayFc['FC'][$i]['DELIVERY_DATE'] = '';
            $arrayFc['FC'][$i]['DELIVERY_BEFORE'] = '';
            $arrayFc['FC'][$i]['USER'] = $fc_data[$i][8];
            $arrayFc['FC'][$i]['START'] = $fc_data[$i][10];
            $arrayFc['FC'][$i]['END'] = $fc_data[$i][11];
            $arrayFc['FC'][$i]['REAL_DURATION'] = $fc_data[$i][6];
            $arrayFc['FC'][$i]['PERFORMANCE'] = ($fc_data[$i][5] > 0 && $fc_data[$i][6] > 0) ? (round($fc_data[$i][6] / $fc_data[$i][5], 2)) : 0;
            $arrayFc['FC'][$i]['NOTE'] = $fc_data[$i][13];
            $arrayFc['FC'][$i]['PAGE_NAME'] = $fc_data[$i][7];
            $arrayFc['FC'][$i]['PAGE_NUMBER'] = $fc_data[$i][4];
            $arrayFc['FC'][$i]['TYPE'] = $fc_data[$i][3];
            $arrayFc['FC'][$i]['WORK_CONTENT'] = '';
        }
    }
}



// Other Data

array_shift($other_data);

for ($i = 0; $i < count($other_data) - 1; $i ++) {
    if (trim($other_data[$i][4]) != '' && trim($other_data[$i][5]) != '' && trim($other_data[$i][0]) != '') {
        if ($other_data[$i][3] == '') {
            unset($other_data[$i][3]);
            continue;
        } else {
            $other_data[$i][7] = str_replace(',', '.', $other_data[$i][7]);
            $arrayOther['Other'][$i]['PROJECT_NO'] = '';
            $arrayOther['Other'][$i]['PROJECT_TYPE'] = 'Other';
            $arrayOther['Other'][$i]['ORDER_DATE'] = '';
            $arrayOther['Other'][$i]['WORK_DATE'] = $other_data[$i][0];
            $arrayOther['Other'][$i]['PROJECT_NAME'] = $other_data[$i][1];
            $arrayOther['Other'][$i]['STATUS'] = '';
            $arrayOther['Other'][$i]['STANDARD_DURATION'] = '';
            $arrayOther['Other'][$i]['DELIVERY_DATE'] = '';
            $arrayOther['Other'][$i]['DELIVERY_BEFORE'] = '';
            $arrayOther['Other'][$i]['USER'] = $other_data[$i][3];
            $arrayOther['Other'][$i]['START'] = $other_data[$i][4];
            $arrayOther['Other'][$i]['END'] = $other_data[$i][5];
            $arrayOther['Other'][$i]['REAL_DURATION'] = $other_data[$i][7];
            $arrayOther['Other'][$i]['PERFORMANCE'] = '0';
            $arrayOther['Other'][$i]['NOTE'] = $other_data[$i][8];
            $arrayOther['Other'][$i]['PAGE_NAME'] = '';
            $arrayOther['Other'][$i]['PAGE_NUMBER'] = '';
            $arrayOther['Other'][$i]['TYPE'] = '';
            $arrayOther['Other'][$i]['WORK_CONTENT'] = $other_data[$i][2];
        }
    }
}

// Research Data

for($i = 0; $i < 4; $i++) {
    array_shift($research_data);
}

for ($i = 0; $i < count($research_data) - 1; $i ++) {
    if (trim($research_data[$i][6]) != '' && trim($research_data[$i][7]) != '' && trim($research_data[$i][1]) != '') {
        if ($research_data[$i][3] == '') {
            unset($research_data[$i][3]);
            continue;
        } else {
            $research_data[$i][4] = str_replace(',', '.', $research_data[$i][4]);
            $research_data[$i][5] = str_replace(',', '.', $research_data[$i][5]);
            $arrayResearch['Research'][$i]['PROJECT_NO'] = '';
            $arrayResearch['Research'][$i]['PROJECT_TYPE'] = 'Research';
            $arrayResearch['Research'][$i]['ORDER_DATE'] = '';
            $arrayResearch['Research'][$i]['WORK_DATE'] = $research_data[$i][1];
            $arrayResearch['Research'][$i]['PROJECT_NAME'] = $research_data[$i][0];
            $arrayResearch['Research'][$i]['STATUS'] = '';
            $arrayResearch['Research'][$i]['STANDARD_DURATION'] = $research_data[$i][4];
            $arrayResearch['Research'][$i]['DELIVERY_DATE'] = '';
            $arrayResearch['Research'][$i]['DELIVERY_BEFORE'] = '';
            $arrayResearch['Research'][$i]['USER'] = $research_data[$i][3];
            $arrayResearch['Research'][$i]['START'] = $research_data[$i][6];
            $arrayResearch['Research'][$i]['END'] = $research_data[$i][7];
            $arrayResearch['Research'][$i]['REAL_DURATION'] = $research_data[$i][5];
            //$arrayResearch['Research'][$i]['PERFORMANCE'] = ($research_data[$i][4] > 0 && $research_data[$i][5] > 0) ? (round($research_data[$i][5] / $research_data[$i][4], 2)) : 0;
            $arrayResearch['Research'][$i]['PERFORMANCE'] = '0';
            $arrayResearch['Research'][$i]['NOTE'] = $research_data[$i][9]. '-' . $research_data[$i][10] . '-' . $research_data[$i][11];
            $arrayResearch['Research'][$i]['PAGE_NAME'] = '';
            $arrayResearch['Research'][$i]['PAGE_NUMBER'] = '';
            $arrayResearch['Research'][$i]['TYPE'] = '';
            $arrayResearch['Research'][$i]['WORK_CONTENT'] = $research_data[$i][2];;
        }
    }
}
// New Coding Detail
/* array_shift($newcoding_detail_data);

for ($i = 0; $i < count($newcoding_detail_data) - 1; $i ++) {
    if (trim($newcoding_detail_data[$i][7]) != '' && trim($newcoding_detail_data[$i][7]) != '-' && trim($newcoding_detail_data[$i][8]) != '' && trim($newcoding_detail_data[$i][9]) != '') {
        $arrayNewCodingDetail['NewCoding'][$i]['PROJECT_NO'] = $newcoding_detail_data[$i][3];
        $arrayNewCodingDetail['NewCoding'][$i]['PROJECT_TYPE'] = 'New Coding';
        $arrayNewCodingDetail['NewCoding'][$i]['ORDER_DATE'] = $newcoding_detail_data[$i][9];
        $arrayNewCodingDetail['NewCoding'][$i]['WORK_DATE'] = '';
        $arrayNewCodingDetail['NewCoding'][$i]['PROJECT_NAME'] = $newcoding_detail_data[$i][5];
        $arrayNewCodingDetail['NewCoding'][$i]['STATUS'] = '';
        $arrayNewCodingDetail['NewCoding'][$i]['STANDARD_DURATION'] = $newcoding_detail_data[$i][12];
        $arrayNewCodingDetail['NewCoding'][$i]['DELIVERY_DATE'] = $newcoding_detail_data[$i][10];;
        $arrayNewCodingDetail['NewCoding'][$i]['DELIVERY_BEFORE'] = $newcoding_detail_data[$i][8];
        $arrayNewCodingDetail['NewCoding'][$i]['USER'] = $newcoding_detail_data[$i][7];
        $arrayNewCodingDetail['NewCoding'][$i]['START'] = '';
        $arrayNewCodingDetail['NewCoding'][$i]['END'] = '';
        $arrayNewCodingDetail['NewCoding'][$i]['REAL_DURATION'] = 0;
        $arrayNewCodingDetail['NewCoding'][$i]['PERFORMANCE'] = 0;
        $arrayNewCodingDetail['NewCoding'][$i]['NOTE'] = $newcoding_detail_data[$i][20];
        $arrayNewCodingDetail['NewCoding'][$i]['PAGE_NAME'] = '';
        $arrayNewCodingDetail['NewCoding'][$i]['PAGE_NUMBER'] = $newcoding_detail_data[$i][11];
        $arrayNewCodingDetail['NewCoding'][$i]['TYPE'] = $newcoding_detail_data[$i][4];
        $arrayNewCodingDetail['NewCoding'][$i]['WORK_CONTENT'] = '';
    }
}

foreach($arrayNewCodingDetail as $key => $value) {

    $value = array_values($value);
    $arrayNewCodingDetail[$key] = $value;
} */

// New Coding
array_shift($newcoding_data);

for ($i = 0; $i < count($newcoding_data) - 1; $i ++) {
    if (trim($newcoding_data[$i][9]) != '' && trim($newcoding_data[$i][11]) != '' && trim($newcoding_data[$i][12]) != '') {
            $newcoding_data[$i][5] = str_replace(',', '.', $newcoding_data[$i][5]);
            $newcoding_data[$i][6] = str_replace(',', '.', $newcoding_data[$i][6]);
            $arrayNewCoding['NewCoding'][$i]['PROJECT_NO'] = $newcoding_data[$i][1];
            $arrayNewCoding['NewCoding'][$i]['PROJECT_TYPE'] = 'New Coding';
            $arrayNewCoding['NewCoding'][$i]['ORDER_DATE'] = '';
            $arrayNewCoding['NewCoding'][$i]['WORK_DATE'] = $newcoding_data[$i][0];
            $arrayNewCoding['NewCoding'][$i]['PROJECT_NAME'] = $newcoding_data[$i][2];
            $arrayNewCoding['NewCoding'][$i]['STATUS'] = $newcoding_data[$i][10];
            $arrayNewCoding['NewCoding'][$i]['STANDARD_DURATION'] = $newcoding_data[$i][5];
            $arrayNewCoding['NewCoding'][$i]['DELIVERY_DATE'] = '';
            $arrayNewCoding['NewCoding'][$i]['DELIVERY_BEFORE'] = '';
            $arrayNewCoding['NewCoding'][$i]['USER'] = $newcoding_data[$i][9];
            $arrayNewCoding['NewCoding'][$i]['START'] = $newcoding_data[$i][11];
            $arrayNewCoding['NewCoding'][$i]['END'] = $newcoding_data[$i][12];
            $arrayNewCoding['NewCoding'][$i]['REAL_DURATION'] = $newcoding_data[$i][6];
            $arrayNewCoding['NewCoding'][$i]['PERFORMANCE'] = ($newcoding_data[$i][5] > 0 && $newcoding_data[$i][6] > 0) ? (round($newcoding_data[$i][6] / $newcoding_data[$i][5], 2)) : 0;
            $arrayNewCoding['NewCoding'][$i]['NOTE'] = $newcoding_data[$i][14];
            $arrayNewCoding['NewCoding'][$i]['PAGE_NAME'] = $newcoding_data[$i][8];
            $arrayNewCoding['NewCoding'][$i]['PAGE_NUMBER'] = $newcoding_data[$i][4];
            $arrayNewCoding['NewCoding'][$i]['TYPE'] = $newcoding_data[$i][3];
            $arrayNewCoding['NewCoding'][$i]['WORK_CONTENT'] = $newcoding_data[$i][7];
            
            //echo ' <strong>'.$newcoding_data[$i][9].'</strong> ';
            /* foreach($arrayNewtonDetail['Newton'] as $a => $b) {
                echo $arrayNewCodingDetail['NewCoding'][$a]['PROJECT_NAME'];
                echo '-------------------<strong>'.$newcoding_data[$i][2].'</strong><br /> ';
                if($arrayNewCodingDetail['NewCoding'][$a]['PROJECT_NAME'] == $newcoding_data[$i][2]) {
                    echo '<h1>Yes</h1>';
                }
                if($arrayNewCodingDetail['NewCoding'][$a]['PROJECT_NO'] == $newcoding_data[$i][1] && $arrayNewCodingDetail['NewCoding'][$a]['PROJECT_NAME'] == $newcoding_data[$i][2] && $arrayNewCodingDetail['NewCoding'][$a]['TYPE'] == $newcoding_data[$i][3] && $arrayNewCodingDetail['NewCoding'][$a]['USER'] == $newcoding_data[$i][9]) {
                    $arrayNewCoding['NewCoding'][$i]['ORDER_DATE']            = $b['ORDER_DATE'];
                    $arrayNewCoding['NewCoding'][$i]['DELIVERY_DATE']         = $b['DELIVERY_DATE'];
                    $arrayNewCoding['NewCoding'][$i]['DELIVERY_BEFORE']       = $b['DELIVERY_BEFORE'];
                    break;
                }
            } */
    }
}



foreach($arrayNewCoding as $key => $value) {
    
    $value = array_values($value);
    $arrayNewCoding[$key] = $value; 
}

foreach($arrayMaintenance as $key => $value) {
    $value = array_values($value);
    $arrayMaintenance[$key] = $value;
}
