<?php
require_once '../function.php';
require_once '../process_all.php';
require_once '../class/Database.class.php';
$paramsWork		= array(
    'server' 	=> 'localhost',
    'username'	=> 'root',
    'password'	=> '',
    'database'	=> 'management',
    'table'		=> 'work',
);

$paramsUser		= array(
    'server' 	=> 'localhost',
    'username'	=> 'root',
    'password'	=> '',
    'database'	=> 'management',
    'table'		=> 'user',
);

$paramsProject		= array(
    'server' 	=> 'localhost',
    'username'	=> 'root',
    'password'	=> '',
    'database'	=> 'management',
    'table'		=> 'project_type',
);

$databaseWork       = new Database($paramsWork);
$databaseUser       = new Database($paramsUser);
$databaseProject    = new Database($paramsProject);

$queryUser      = 'SELECT * FROM user';
$queryProject   =   'SELECT * FROM project_type';

$arrayUser      =   $databaseUser->listRecord($databaseUser->query($queryUser));
$arrayProject   =   $databaseProject->listRecord($databaseProject->query($queryProject));   

//Import Maintenance Data
foreach($arrayMaintenance['Maintenance'] as $key => $value) {
    if(empty($arrayMaintenance['Maintenance'][$key])) {
        unset($arrayMaintenance['Maintenance'][$key]);
    } else {
        $arrayMaintenance['Maintenance'][$key] = array_change_key_case($arrayMaintenance['Maintenance'][$key], CASE_LOWER);
        foreach($arrayUser as $k => $v) {
            if($arrayMaintenance['Maintenance'][$key]['user'] == $arrayUser[$k]['nickname']) {
                $arrayMaintenance['Maintenance'][$key]['user'] = $arrayUser[$k]['id'];
            }
        }
        foreach($arrayProject as $e => $q) {
            if($arrayMaintenance['Maintenance'][$key]['project_type'] == $arrayProject[$e]['project_type']) {
                $arrayMaintenance['Maintenance'][$key]['project_type'] = $arrayProject[$e]['id'];
            }
        }
        $databaseWork->insert($arrayMaintenance['Maintenance'][$key]);
    }
}

//Import Newton Data
foreach($arrayNewton['Newton'] as $key => $value) {
    if(empty($arrayNewton['Newton'][$key])) {
        unset($arrayNewton['Newton'][$key]);
    } else {
        $arrayNewton['Newton'][$key] = array_change_key_case($arrayNewton['Newton'][$key], CASE_LOWER);
        foreach($arrayUser as $k => $v) {
            if($arrayNewton['Newton'][$key]['user'] == $arrayUser[$k]['nickname']) {
                $arrayNewton['Newton'][$key]['user'] = $arrayUser[$k]['id'];
            }
        }
        foreach($arrayProject as $e => $q) {
            if($arrayNewton['Newton'][$key]['project_type'] == $arrayProject[$e]['project_type']) {
                $arrayNewton['Newton'][$key]['project_type'] = $arrayProject[$e]['id'];
            }
        }
       //$databaseWork->insert($arrayNewton['Newton'][$key]);
    }
}

//Import Domestic Data
foreach($arrayDomestic['Domestic'] as $key => $value) {
    if(empty($arrayDomestic['Domestic'][$key])) {
        unset($arrayDomestic['Domestic'][$key]);
    } else {
        $arrayDomestic['Domestic'][$key] = array_change_key_case($arrayDomestic['Domestic'][$key], CASE_LOWER);
        foreach($arrayUser as $k => $v) {
            if($arrayDomestic['Domestic'][$key]['user'] == $arrayUser[$k]['nickname']) {
                $arrayDomestic['Domestic'][$key]['user'] = $arrayUser[$k]['id'];
            }
        }
        foreach($arrayProject as $e => $q) {
            if($arrayDomestic['Domestic'][$key]['project_type'] == $arrayProject[$e]['project_type']) {
                $arrayDomestic['Domestic'][$key]['project_type'] = $arrayProject[$e]['id'];
            }
        }
        //$databaseWork->insert($arrayDomestic['Domestic'][$key]);
    }
}

//Import FC Data
foreach($arrayFc['FC'] as $key => $value) {
    if(empty($arrayFc['FC'][$key])) {
        unset($arrayFc['FC'][$key]);
    } else {
        $arrayFc['FC'][$key] = array_change_key_case($arrayFc['FC'][$key], CASE_LOWER);
        foreach($arrayUser as $k => $v) {
            if($arrayFc['FC'][$key]['user'] == $arrayUser[$k]['nickname']) {
                $arrayFc['FC'][$key]['user'] = $arrayUser[$k]['id'];
            }
        }
        foreach($arrayProject as $e => $q) {
            if($arrayFc['FC'][$key]['project_type'] == $arrayProject[$e]['project_type']) {
                $arrayFc['FC'][$key]['project_type'] = $arrayProject[$e]['id'];
            }
        }
        //$databaseWork->insert($arrayFc['FC'][$key]);
    }
}

// Other Data
foreach($arrayOther['Other'] as $key => $value) {
    if(empty($arrayOther['Other'][$key])) {
        unset($arrayOther['Other'][$key]);
    } else {
        $arrayOther['Other'][$key] = array_change_key_case($arrayOther['Other'][$key], CASE_LOWER);
        foreach($arrayUser as $k => $v) {
            if($arrayOther['Other'][$key]['user'] == $arrayUser[$k]['nickname']) {
                $arrayOther['Other'][$key]['user'] = $arrayUser[$k]['id'];
            }
        }
        foreach($arrayProject as $e => $q) {
            if($arrayOther['Other'][$key]['project_type'] == $arrayProject[$e]['project_type']) {
                $arrayOther['Other'][$key]['project_type'] = $arrayProject[$e]['id'];
            }
        }
        //$databaseWork->insert($arrayOther['Other'][$key]);
    }
}

// Research Data
foreach($arrayResearch['Research'] as $key => $value) {
    if(empty($arrayResearch['Research'][$key])) {
        unset($arrayResearch['Research'][$key]);
    } else {
        $arrayResearch['Research'][$key] = array_change_key_case($arrayResearch['Research'][$key], CASE_LOWER);
        foreach($arrayUser as $k => $v) {
            if($arrayResearch['Research'][$key]['user'] == $arrayUser[$k]['nickname']) {
                $arrayResearch['Research'][$key]['user'] = $arrayUser[$k]['id'];
            }
        }
        foreach($arrayProject as $e => $q) {
            if($arrayResearch['Research'][$key]['project_type'] == $arrayProject[$e]['project_type']) {
                $arrayResearch['Research'][$key]['project_type'] = $arrayProject[$e]['id'];
            }
        }
        //$databaseWork->insert($arrayResearch['Research'][$key]);
    }
}

// New Coding
foreach($arrayNewCoding['New Coding'] as $key => $value) {
    if(empty($arrayNewCoding['New Coding'][$key])) {
        unset($arrayNewCoding['New Coding'][$key]);
    } else {
        $arrayNewCoding['New Coding'][$key] = array_change_key_case($arrayNewCoding['New Coding'][$key], CASE_LOWER);
        foreach($arrayUser as $k => $v) {
            if($arrayNewCoding['New Coding'][$key]['user'] == $arrayUser[$k]['nickname']) {
                $arrayNewCoding['New Coding'][$key]['user'] = $arrayUser[$k]['id'];
            }
        }
        foreach($arrayProject as $e => $q) {
            if($arrayNewCoding['New Coding'][$key]['project_type'] == $arrayProject[$e]['project_type']) {
                $arrayNewCoding['New Coding'][$key]['project_type'] = $arrayProject[$e]['id'];
            }
        }
        //$databaseWork->insert($arrayNewCoding['New Coding'][$key]);
    }
}