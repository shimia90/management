<?php
require_once 'get_worktime.php';
require_once 'class/connect_worktime.php';
require_once 'class/connect_user.php';

$arrayWorktimeImport =  array();
$arrayWorktimeSelect =  array();
$arrayIdWorktime     =  array();
/*
 * Fix not correct User
 */
foreach($finalArray as $key => $value) {
    foreach($value as $k => $v) {
        if($k == 'ManhTD') {
            $finalArray[$key]['ManhT'] = $v;
            unset($finalArray[$key]['ManhTD']);
        }
    }
}

/*
 * Change User nick name to id
 */
foreach($finalArray as $key => $value) {
    foreach($value as $k => $v) {
        foreach($arrayUser as $a => $b) {
            if($k == $b['nickname']) {
                $finalArray[$key][$b['id']] = $v;
                unset($finalArray[$key][$k]);
            }
        }
    }
}

/*
 * Create Array to Inset to mysql
 */
foreach($finalArray as $key => $value) {
    foreach($value as $k => $v) {
        $arrayWorktimeImport[$key][$k]['work_date']        =     $key;
        $arrayWorktimeImport[$key][$k]['user']            =     $k;
        $arrayWorktimeImport[$key][$k]['overtime']        =     $v['Overtime'];
        $arrayWorktimeImport[$key][$k]['delay']           =     $v['Delay'];
        $arrayWorktimeImport[$key][$k]['unpaid']          =     $v['Unpaid'];
        $arrayWorktimeImport[$key][$k]['special_paid']    =     $v['Special Paid'];
        $arrayWorktimeImport[$key][$k]['paid']            =     $v['Paid'];
        $arrayWorktimeImport[$key][$k]['others']          =     $v['Others'];
        $arrayWorktimeImport[$key][$k]['work_time']       =     (8 + $v['Overtime']) - ($v['Delay'] + $v['Unpaid'] + $v['Paid'] + $v['Others']);
    }
}

foreach($arrayWorktimeImport as $key => $value) {
    foreach($value as $k => $v) {
        $arrayWorktimeSelect['work_date'] = $v['work_date'];
        $arrayWorktimeSelect['user'] = $v['user'];
        if($dbWorktime->checkExistRow($arrayWorktimeSelect)) {
            $arrayIdWorktime = $dbWorktime->returnID($arrayWorktimeSelect);
            if(!empty($arrayIdWorktime)) {
                $dbWorktime->update($v, array(array('id', $arrayIdWorktime[0]['id'], null)));
            }
        } else {
            $dbWorktime->insert($v);
        }
        
    }
}