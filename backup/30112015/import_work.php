<?php
require_once 'function.php';
require_once 'process_all.php';
require_once 'class/Database.class.php';
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
        //echo $databaseWork->checkExistRow($arrayMaintenance['Maintenance'][$key]) . '<br />';
        $arrayToSelect['project_no']    = $arrayMaintenance['Maintenance'][$key]['project_no'];
        $arrayToSelect['project_type']  = $arrayMaintenance['Maintenance'][$key]['project_type'];
        $arrayToSelect['project_name']  = $arrayMaintenance['Maintenance'][$key]['project_name'];
        $arrayToSelect['work_date']  = $arrayMaintenance['Maintenance'][$key]['work_date'];
        $arrayToSelect['user']  = $arrayMaintenance['Maintenance'][$key]['user'];
        if($databaseWork->checkExistRow($arrayToSelect) == true) {
            $arrayIdMaintenance = $databaseWork->returnID($arrayMaintenance['Maintenance'][$key]);
            foreach($arrayIdMaintenance as $key => $value) {
                $arrayMaitenanceWhere[] = array('id',$value['id'], null);    
            }
            $databaseWork->update($arrayMaintenance['Maintenance'][$key], $arrayMaitenanceWhere);
        } else {
            $databaseWork->insert($arrayMaintenance['Maintenance'][$key]);
        }
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
       $arrayNewtonToSelect['project_no']   =   $arrayNewton['Newton'][$key]['project_no'];
       $arrayNewtonToSelect['project_type']   =   $arrayNewton['Newton'][$key]['project_type'];
       $arrayNewtonToSelect['project_name']   =   $arrayNewton['Newton'][$key]['project_name'];
       $arrayNewtonToSelect['work_date']   =   $arrayNewton['Newton'][$key]['work_date'];
       $arrayNewtonToSelect['user']   =   $arrayNewton['Newton'][$key]['user'];
        if($databaseWork->checkExistRow($arrayNewtonToSelect) == true) {
            $arrayIdNewton = $databaseWork->returnID($arrayNewton['Newton'][$key]);
            foreach($arrayIdNewton as $key => $value) {
                $arrayNewtonWhere[] = array('id',$value['id'], null);    
            }
            $databaseWork->update($arrayNewton['Newton'][$key], $arrayNewtonWhere);
        } else {
            $databaseWork->insert($arrayNewton['Newton'][$key]);
        }
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
        $arrayDomesticToSelect['project_name']  =   $arrayDomestic['Domestic'][$key]['project_name'];
        $arrayDomesticToSelect['project_type']  =   $arrayDomestic['Domestic'][$key]['project_type'];
        $arrayDomesticToSelect['user']  =   $arrayDomestic['Domestic'][$key]['user'];
        $arrayDomesticToSelect['work_date']  =   $arrayDomestic['Domestic'][$key]['work_date'];
        if($databaseWork->checkExistRow($arrayDomesticToSelect) == true) {
            $arrayIdDomestic = $databaseWork->returnID($arrayDomestic['Domestic'][$key]);
            foreach($arrayIdDomestic as $key => $value) {
                $arrayDomesticWhere[] = array('id',$value['id'], null);
            }
            $databaseWork->update($arrayDomestic['Domestic'][$key], $arrayDomesticWhere);
        } else {
            $databaseWork->insert($arrayDomestic['Domestic'][$key]);
        }
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
        $arrayFcToSelect['project_no']    =   $arrayFc['FC'][$key]['project_no'];
        $arrayFcToSelect['project_type']    =   $arrayFc['FC'][$key]['project_type'];
        $arrayFcToSelect['project_name']    =   $arrayFc['FC'][$key]['project_name'];
        $arrayFcToSelect['work_date']    =   $arrayFc['FC'][$key]['work_date'];
        $arrayFcToSelect['user']    =   $arrayFc['FC'][$key]['user'];
        if($databaseWork->checkExistRow($arrayFcToSelect) == true) {
            $arrayIdFC = $databaseWork->returnID($arrayFc['FC'][$key]);
            foreach($arrayIdFC as $key => $value) {
                $arrayFCWhere[] = array('id',$value['id'], null);
            }
            $databaseWork->update($arrayFc['FC'][$key], $arrayFCWhere);
        } else {
            $databaseWork->insert($arrayFc['FC'][$key]);
        }
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
        $arrayOtherToSelect['project_name']     =   $arrayOther['Other'][$key]['project_name'];
        $arrayOtherToSelect['project_type']     =   $arrayOther['Other'][$key]['project_type'];
        $arrayOtherToSelect['user']             =   $arrayOther['Other'][$key]['user'];
        $arrayOtherToSelect['work_date']     =   $arrayOther['Other'][$key]['work_date'];
        if($databaseWork->checkExistRow($arrayOtherToSelect) == true) {
            $arrayIdOther = $databaseWork->returnID($arrayOther['Other'][$key]);
            foreach($arrayIdOther as $key => $value) {
                $arrayOtherWhere[] = array('id',$value['id'], null);
            }
            $databaseWork->update($arrayOther['Other'][$key], $arrayOtherWhere);
        } else {
            $databaseWork->insert($arrayOther['Other'][$key]);
        }
       
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
        $arrayResearchToSelect['project_type'] = $arrayResearch['Research'][$key]['project_type'];
        $arrayResearchToSelect['project_name'] = $arrayResearch['Research'][$key]['project_name'];
        $arrayResearchToSelect['user'] = $arrayResearch['Research'][$key]['user'];
        $arrayResearchToSelect['work_date'] = $arrayResearch['Research'][$key]['work_date'];
        if($databaseWork->checkExistRow($arrayResearchToSelect) == true) {
            $arrayIdResearch = $databaseWork->returnID($arrayResearch['Research'][$key]);
            foreach($arrayIdResearch as $key => $value) {
                $arrayResearchWhere[] = array('id',$value['id'], null);
            }
            $databaseWork->update($arrayResearch['Research'][$key], $arrayResearchWhere);
        } else {
            $databaseWork->insert($arrayResearch['Research'][$key]);
        }
    }
}

// New Coding
foreach($arrayNewCoding['NewCoding'] as $key => $value) {
    if(empty($arrayNewCoding['NewCoding'][$key])) {
        unset($arrayNewCoding['NewCoding'][$key]);
    } else {
        $arrayNewCoding['NewCoding'][$key] = array_change_key_case($arrayNewCoding['NewCoding'][$key], CASE_LOWER);
        foreach($arrayUser as $k => $v) {
            if($arrayNewCoding['NewCoding'][$key]['user'] == $arrayUser[$k]['nickname']) {
                $arrayNewCoding['NewCoding'][$key]['user'] = $arrayUser[$k]['id'];
            }
        }
        foreach($arrayProject as $e => $q) {
            if($arrayNewCoding['NewCoding'][$key]['project_type'] == $arrayProject[$e]['project_type']) {
                $arrayNewCoding['NewCoding'][$key]['project_type'] = $arrayProject[$e]['id'];
            }
        }
        //$databaseWork->insert($arrayNewCoding['New Coding'][$key]);
        $arrayNewCodingToSelect['project_no']   =   $arrayNewCoding['NewCoding'][$key]['project_no'];
        $arrayNewCodingToSelect['project_name']   =   $arrayNewCoding['NewCoding'][$key]['project_name'];
        $arrayNewCodingToSelect['project_type']   =   $arrayNewCoding['NewCoding'][$key]['project_type'];
        $arrayNewCodingToSelect['work_date']   =   $arrayNewCoding['NewCoding'][$key]['work_date'];
        $arrayNewCodingToSelect['user']   =   $arrayNewCoding['NewCoding'][$key]['user'];
        if($databaseWork->checkExistRow($arrayNewCoding['NewCoding'][$key]) == true) {
            $arrayIdCoding = $databaseWork->returnID($arrayNewCoding['NewCoding'][$key]);
            foreach($arrayIdCoding as $key => $value) {
                $arrayNewCodingWhere[] = array('id',$value['id'], null);
            }
            $databaseWork->update($arrayNewCoding['NewCoding'][$key], $arrayNewCodingWhere);
        } else {
            $databaseWork->insert($arrayNewCoding['NewCoding'][$key]);
        }
    }
}
