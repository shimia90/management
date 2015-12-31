<?php
session_start();
require_once 'function.php';
require_once 'class/connect_user.php';
require_once 'class/connect_worktime.php';
require_once 'class/connect_project.php';
require_once 'class/connect_work.php';
$today          = date("d/m/Y");
if(isset($_GET['updateSQL']) && $_GET['updateSQL'] == 'yes') {
    require_once 'import_work.php';
    require_once 'import_worktime.php';
    
    if(isset($_SESSION['user_name']) && trim($_SESSION != '') && trim($_SESSION['date_from']) != '' && isset($_SESSION['date_from'])) {
        $dateFrom       =   trim($_SESSION['date_from']);
        $dateTo         =   trim($_SESSION['date_to']);
        $userPost       =   $_SESSION['user_name'];
        if($dateFrom == $dateTo) {
            $queryWork      =   "SELECT * FROM `work` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) = STR_TO_DATE( '{$dateTo}', '%d/%m/%Y' ) AND `user` = {$userPost} ORDER BY `work_date` ASC";
            //SELECT * FROM `work` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE('02/11/2015', '%d/%m/%Y') AND STR_TO_DATE('23/11/2015', '%d/%m/%Y') AND `user` = 3
        } else {
            $queryWork      =   "SELECT * FROM `work` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateTo}', '%d/%m/%Y' ) AND `user` = {$userPost} ORDER BY `work_date` ASC";
        }
        
        $arrayWork      =   $databaseWork->listRecord($databaseWork->query($queryWork));
        foreach ($arrayWork as $key => $value) {
            foreach($arrayProject as $k => $v) {
                if($arrayWork[$key]['project_type'] == $arrayProject[$k]['id']) {
                    $arrayWork[$key]['project_type'] = $arrayProject[$k]['project_type'];
                }
            }
        }
    }
    
}
require_once 'class/Database.class.php';
$arrayProject       =   $databaseProject->listRecord($databaseProject->query('SELECT * FROM project_type'));
$datePost           =   '';
$userPost           =   '';
$arrayWork          =   array();
$dateFrom           =   $today;
$dateTo             =   $today;
$dateAllFrom        =   $today;
$dateAllTo          =   $today;
$projectFilter      =   '';
$queryTotal         =   '';

if(isset($_POST['date_from']) && isset($_POST['user_name']) && isset($_POST['date_to']) && trim($_POST['date_from']) != '' && trim($_POST['date_to']) != '' && trim($_POST['user_name']) != '') {
    $_SESSION['user_name']      =   $_POST['user_name'];
    $_SESSION['date_from']      =   $_POST['date_from'];
    $_SESSION['date_to']        =   $_POST['date_to'];
    
    $dateFrom       =   trim($_POST['date_from']);
    $dateTo         =   trim($_POST['date_to']);
    $userPost       =   $_POST['user_name'];
    if($dateFrom == $dateTo) {
        $queryWork      =   "SELECT * FROM `work` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) = STR_TO_DATE( '{$dateTo}', '%d/%m/%Y' ) AND `user` = {$_POST['user_name']} ORDER BY `work_date` ASC";
        //SELECT * FROM `work` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE('02/11/2015', '%d/%m/%Y') AND STR_TO_DATE('23/11/2015', '%d/%m/%Y') AND `user` = 3
    } else {
        $queryWork      =   "SELECT * FROM `work` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateTo}', '%d/%m/%Y' ) AND `user` = {$_POST['user_name']} ORDER BY `work_date` ASC";
        //$queryWorkOver1 =   "SELECT SUM(`real_duration`) AS `total_time`, `work_date`, `user` FROM `work` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateTo}', '%d/%m/%Y' ) AND `user` = {$_POST['user_name']} GROUP BY `work_date`";
        $queryWorkOver1 =   "SELECT SUM(`real_duration`) AS `total_time`, `work_date`, `user` FROM `work` WHERE `work_date` IN (SELECT `work_date` FROM `work_time` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateTo}', '%d/%m/%Y' ) AND `change` = '0' AND `user` = {$_POST['user_name']} ) AND `user` = {$_POST['user_name']} GROUP BY `work_date`";
        //$queryWorkOver2 =   "SELECT `work_time`, `work_date`, `user` FROM `work_time` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateTo}', '%d/%m/%Y' ) AND `user` = {$_POST['user_name']} GROUP BY `work_date`";
        $queryWorkOver2 =   "SELECT `work_time`, `work_date`, `user` FROM `work_time` WHERE `user` = {$_POST['user_name']} AND `change` = '0' AND `work_date` IN ( SELECT `work_date` FROM `work` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateTo}', '%d/%m/%Y' ) AND `user` = {$_POST['user_name']} ) GROUP BY `work_date`";
    }
        
    $arrayWork      =   $databaseWork->listRecord($databaseWork->query($queryWork));
    
    if($dateFrom != $dateTo) {
        // Process Overload Work
        $arrayWorkOver1 =   $databaseWork->listRecord($databaseWork->query($queryWorkOver1));
        $arrayWorkOver2 =   $databaseWork->listRecord($databaseWork->query($queryWorkOver2));
        $resultOverload = array();
        foreach($arrayWorkOver1 as $key => $value) {
            if(isset($arrayWorkOver1[$key])) {
                if($arrayWorkOver1[$key]['total_time'] > $arrayWorkOver2[$key]['work_time']) {
                    $resultOverload['work_date'][] = $arrayWorkOver1[$key]['work_date'];
                    $resultOverload['user'][] = $arrayWorkOver1[$key]['user'];
                }
            } else {
                break;
            }
        }

    }
    foreach ($arrayWork as $key => $value) {
        foreach($arrayProject as $k => $v) {
            if($arrayWork[$key]['project_type'] == $arrayProject[$k]['id']) {
                $arrayWork[$key]['project_type'] = $arrayProject[$k]['project_type'];
            }
        }
    }
    
}
if(isset($_POST['date_all_from']) && isset($_POST['date_all_to']) && trim($_POST['date_all_from']) != '' && trim($_POST['date_all_to']) != '') {
        $dateAllFrom        =       $_POST['date_all_from'];
        $dateAllTo          =       $_POST['date_all_to'];
        $projectFilter      =       $_POST['filter_project'];
        if($dateAllFrom == $dateAllTo && $projectFilter != '') {
            $queryWork      =   "SELECT * FROM `work` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) = STR_TO_DATE( '{$dateAllTo}', '%d/%m/%Y' ) AND `project_type` = '{$projectFilter}' ORDER BY `user`, `work_date` ASC";
            $queryTotal     =   "SELECT SUM(`real_duration`) AS `total_real`, SUM(`standard_duration`) AS `total_standard`, (SUM(`performance`)/ COUNT(`id`)) AS `total_performance`  FROM `work` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) = STR_TO_DATE( '{$dateAllTo}', '%d/%m/%Y' ) AND `project_type` = '{$projectFilter}' ORDER BY `user`, `work_date` ASC";
        } elseif ($dateAllFrom != $dateAllTo && $projectFilter != '') {
            $queryWork      =   "SELECT * FROM `work` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateAllFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateAllTo}', '%d/%m/%Y' ) AND `project_type` = '{$projectFilter}' ORDER BY `user`, `work_date` ASC";
            $queryTotal     =   "SELECT SUM(`real_duration`) AS `total_real`, SUM(`standard_duration`) AS `total_standard`, (SUM(`performance`)/ COUNT(`id`)) AS `total_performance`  FROM `work` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateAllFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateAllTo}', '%d/%m/%Y' ) AND `project_type` = '{$projectFilter}' ORDER BY `user`, `work_date` ASC";
        } elseif($dateAllFrom == $dateAllTo && $projectFilter == '') {
            $queryWork      =   "SELECT * FROM `work` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) = STR_TO_DATE( '{$dateAllTo}', '%d/%m/%Y' ) ORDER BY `user`, `work_date` ASC";
        } elseif($dateAllFrom != $dateAllTo && $projectFilter == '') {
            $queryWork      =   "SELECT * FROM `work` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateAllFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateAllTo}', '%d/%m/%Y' ) ORDER BY `user`, `work_date` ASC";
        }
        
        $arrayTotalFilter   =   $databaseWork->listRecord($databaseWork->query($queryTotal));
        
        $arrayWork      =   $databaseWork->listRecord($databaseWork->query($queryWork));
        foreach ($arrayWork as $key => $value) {
            foreach($arrayProject as $k => $v) {
                if($arrayWork[$key]['project_type'] == $arrayProject[$k]['id']) {
                    $arrayWork[$key]['project_type'] = $arrayProject[$k]['project_type'];
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="UTF-8">
        <title>Personal Management</title>
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="assets/styles.css" rel="stylesheet" media="screen">
        <link href="assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <link href="css/jquery-ui.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="css/daterangepicker.css" />
        <link rel="stylesheet" href="css/timestack.css" />
        <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="vendors/flot/excanvas.min.js"></script><![endif]-->
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        
    </head>
    <body>
        <?php require_once 'header.php'; ?>
        <div class="container-fluid">
            <div class="row-fluid">
                
                <div class="span12" id="content">

                     <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Personal Management</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <div id="search-information">
                                        <div class="span8">
                                        
                                        <div id="example_length">
                                            <form action="personal.php" method="post" id="user_form" class="form-inline mb_10">
                                                <label>
                                                    Name: 
                                                    <select id="user_select" size="1" name="user_name" aria-controls="example">
                                                        <option value="">Select Member</option>
                                                        <?php foreach($arrayUser as $key => $value) :
                                                            if(isset($_SESSION['user_name']) && trim($_SESSION['user_name']) != '') {
                                                                $selectedUser = ($value['id'] == $_SESSION['user_name']) ? 'selected="selected"' : '';
                                                            } else {
                                                                $selectedUser = ($value['id'] == $_POST['user_name']) ? 'selected="selected"' : '';
                                                            }
                                                            
                                                        ?>
                                                        <option value="<?php echo $value['id']; ?>" <?php echo $selectedUser; ?>><?php echo $value['fullname'];?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </label>
                                                <label>
                                                    <!-- Date: <input type="text" id="datepicker_from" name="date_search" value="<?php //echo $datePost; ?>" placeholder="Date Range" />  -->
                                                    From <span id="two-inputs"><input id="date-range200" size="20" name="date_from" value="<?php if(isset($_SESSION['date_from']) && trim($_SESSION['date_from']) != '') { echo $_SESSION['date_from']; } else { echo $dateFrom; } ?>"> To <input id="date-range201" size="20" name="date_to" value="<?php if(isset($_SESSION['date_to']) && trim($_SESSION['date_to']) != '') { echo $_SESSION['date_to']; } else { echo $dateTo; } ?>"></span>
                                                </label>
             
                                                <input type="hidden" name="type" value="single" />
                                                <input type="hidden" name="page_submit" value="record" />
                                                <button class="btn btn-warning" type="submit">Search</button>
                                            </form>
                                            <?php if(isset($_POST['user_name']) && trim($_POST['user_name']) == '') : ?>
                                                <div class="alert alert-error">
                                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                                  <strong>Username is empty!</strong> Please select a user
                                                </div>
                                            <?php elseif(isset($_POST['date_from']) && trim($_POST['date_from'] == '') || isset($_POST['date_to']) && trim($_POST['date_to'] == '') ) :?>
                                                <div class="alert alert-error">
                                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                                  <strong>Date is empty!</strong> Please select date
                                                </div>
                                            <?php elseif(isset($_POST['date_from']) && isset($_POST['user_name']) && isset($_POST['date_to']) && $_POST['date_from'] == '' && $_POST['date_to'] == '' && $_POST['user_name'] == '') : ?>
                                                <div class="alert alert-error">
                                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                                  <strong>These fields are empty! </strong> Please input
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="working_time">
                                                <?php 
                                                    $totalBeingLate     =   0;
                                                    $workingDayTotal    =   0;
                                                    $OvertimeTotal      =   0;
                                                    $flagAbort          =   false;
                                                    if(isset($_POST['user_name']) && trim($_POST['user_name']) != '' && isset($_POST['date_from']) && trim($_POST['date_from']) != '' && isset($_POST['date_to']) && trim($_POST['date_to']) != '') {
                                                        if($dateFrom != $dateTo) {
                                                            
                                                            $queryWt = "SELECT * FROM `work_time` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateTo}', '%d/%m/%Y' ) AND `user` = '{$_POST['user_name']}' ORDER BY `user`, `work_date` ASC";
                                                            $arrayGetWorktime = $dbWorktime->listRecord($dbWorktime->query($queryWt));
                                                            // Being Late / Leave Early
                                                            echo '<ul class="inline">';
                                                                echo '<li>';
                                                                    echo '<ul class="inline">';
                                                                    echo '<li>Being late/ Leave early: </li>';
                                                                    foreach($arrayGetWorktime as $key => $value) {
                                                                        if(isWeekend($value['work_date']) == true) {
                                                                            continue;
                                                                        } else {
                                                                            $totalBeingLate     += ($value['delay'] + $value['unpaid'] + $value['paid'] + $value['others']);
                                                                            //echo '<li class="work-time-tooltip" data-placement="top" data-toggle="tooltip" title="'.$value['work_date'].'"><strong>'.($value['delay'] + $value['unpaid'] + $value['paid'] + $value['others']).'</strong></li>';
                                                                        }
                                                                    }
                                                                        echo '<li><strong>'.$totalBeingLate.'</strong></li>';
                                                                    echo '</ul>';
                                                                echo '</li>';
                                                                    
                                                                echo '<li>';
                                                                    // Working Day Hour
                                                                    echo '<ul class="inline">';
                                                                        echo '<li>Working day hour: </li>';
                                                                        foreach($arrayGetWorktime as $key => $value) {
                                                                            if(isWeekend($value['work_date']) == true) {
                                                                                continue;
                                                                                
                                                                            } else {
                                                                                $workingDayTotal += $value['work_time'];
                                                                            }
                                                                        }
                                                                        echo '<li><strong>'.$workingDayTotal.'</strong></li>';
                                                                    echo '</ul>';
                                                                echo '</li>';
                                                                
                                                                echo '<li>';
                                                                    // Overtime
                                                                    echo '<ul class="inline">';
                                                                    echo '<li>Overtime: </li>';
                                                                    foreach($arrayGetWorktime as $key => $value) {
                                                                        if(isWeekend($value['work_date']) == true) {
                                                                            continue;
                                                                        } else {
                                                                            $OvertimeTotal += $value['overtime'];
                                                                        }
                                                                        
                                                                    }
                                                                    echo '<li><strong>'.$OvertimeTotal.'</strong></li> ';
                                                                    echo '</ul>';
                                                                echo '</li>';
                                                                
                                                                echo '<li>';
                                                                    //Performance
                                                                    $dayRealDur = 0;
                                                                    foreach($arrayWork as $key => $value) {
                                                                        if(isWeekend($value['work_date']) == true) {
                                                                            continue;
                                                                            $dayRealDur += 0;
                                                                        } else {
                                                                            $dayRealDur += $value['real_duration'];
                                                                        }
                                                                    }
                                                                    
                                                                    echo '<ul class="inline">';
                                                                    echo '<li>Working real hour: </li>';
                                                                    echo '<li class="label label-warning">'.$dayRealDur.'</li>';
                                                                    echo '</ul>';
                                                                echo '</li>';
                                                                
                                                                echo '<li>';
                                                                    echo '<ul class="inline">';
                                                                        echo '<li>Capacity: </li>';
                                                                        echo '<li class="label label-info">'.round((($dayRealDur / $workingDayTotal) * 100), 2).'%</li>';
                                                                    echo '</ul>';
                                                                echo '</li>';
                                                             echo '</ul>';
                                                            
                                                            //Create Alert
                                                            if($dateFrom == $dateTo) {
                                                                if($dayRealDur > $workingDayTotal) {
                                                                    echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>The real time duration on <strong>'.$value['work_date'].'</strong> didnt input correctly, please check !!!</div>';
                                                                }
                                                            } else {
                                                                if(!empty($resultOverload)) {
                                                                    foreach($resultOverload['work_date'] as $key => $value) {
                                                                        echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>The real time duration on <strong>'.$value.'</strong> didnt input correctly, please check !!!</div>';
                                                                    }
                                                                }
                                                            }
                                                            
                                                        } else {
                                                            $queryWt = "SELECT * FROM `work_time` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) = STR_TO_DATE( '{$dateTo}', '%d/%m/%Y' ) AND `user` = {$_POST['user_name']} ORDER BY `work_date` ASC";
                                                            $arrayGetWorktime = $dbWorktime->listRecord($dbWorktime->query($queryWt));
                                                        // Being Late / Leave Early
                                                            echo '<ul class="inline">';
                                                                echo '<li>';
                                                                    echo '<ul class="inline">';
                                                                    echo '<li>Being late/ Leave early: </li>';
                                                                    foreach($arrayGetWorktime as $key => $value) {
                                                                        if($value['change'] == '0') {
                                                                            $flagAbort = false;
                                                                        } elseif ($value['change'] == '1') {
                                                                            $flagAbort = true;
                                                                        }
                                                                        if(isWeekend($value['work_date']) == true) {
                                                                            continue;
                                                                        } else {
                                                                            $totalBeingLate     += ($value['delay'] + $value['unpaid'] + $value['paid'] + $value['others']);
                                                                            //echo '<li class="work-time-tooltip" data-placement="top" data-toggle="tooltip" title="'.$value['work_date'].'"><strong>'.($value['delay'] + $value['unpaid'] + $value['paid'] + $value['others']).'</strong></li>';
                                                                        }
                                                                    }
                                                                        echo '<li><strong>'.$totalBeingLate.'</strong></li>';
                                                                    echo '</ul>';
                                                                echo '</li>';
                                                                    
                                                                echo '<li>';
                                                                    // Working Day Hour
                                                                    echo '<ul class="inline">';
                                                                        echo '<li>Working day hour: </li>';
                                                                        foreach($arrayGetWorktime as $key => $value) {
                                                                            if(isWeekend($value['work_date']) == true) {
                                                                                continue;
                                                                                
                                                                            } else {
                                                                                $workingDayTotal += $value['work_time'];
                                                                            }
                                                                        }
                                                                        echo '<li><strong>'.$workingDayTotal.'</strong></li>';
                                                                    echo '</ul>';
                                                                echo '</li>';
                                                                
                                                                echo '<li>';
                                                                    // Overtime
                                                                    echo '<ul class="inline">';
                                                                    echo '<li>Overtime: </li>';
                                                                    foreach($arrayGetWorktime as $key => $value) {
                                                                        if(isWeekend($value['work_date']) == true) {
                                                                            continue;
                                                                        } else {
                                                                            $OvertimeTotal += $value['overtime'];
                                                                        }
                                                                        
                                                                    }
                                                                    echo '<li><strong>'.$OvertimeTotal.'</strong></li> ';
                                                                    echo '</ul>';
                                                                echo '</li>';
                                                                
                                                                echo '<li>';
                                                                    //Performance
                                                                    $dayRealDur = 0;
                                                                    foreach($arrayWork as $key => $value) {
                                                                        if(isWeekend($value['work_date']) == true) {
                                                                            echo '<li class="work-time-tooltip" data-placement="top" data-toggle="tooltip" title="Weekend"><strong>Weekend</strong></li>';
                                                                            $dayRealDur += 0;
                                                                        } else {
                                                                            $dayRealDur += $value['real_duration'];
                                                                        }
                                                                    }
                                                                    
                                                                    echo '<ul class="inline">';
                                                                    echo '<li>Working real hour: </li>';
                                                                    echo '<li class="label label-warning">'.$dayRealDur.'</li>';
                                                                    echo '</ul>';
                                                                echo '</li>';
                                                                
                                                                echo '<li>';
                                                                    echo '<ul class="inline">';
                                                                        echo '<li>Capacity: </li>';
                                                                        echo '<li class="label label-info">'.@round((($dayRealDur / $workingDayTotal) * 100), 2).'%</li>';
                                                                    echo '</ul>';
                                                                echo '</li>';
                                                             echo '</ul>';
                                                            
                                                            //Create Alert
                                                            if($dayRealDur > $workingDayTotal) {
                                                                if($flagAbort == false) {
                                                                    echo '<div class="alert_wrapper"><div class="alert alert-error"><button id="btn_abort" type="button" class="close" data-dismiss="alert" data-user="'.$value['user'].'" data-date="'.$value['work_date'].'">&times;</button>The real time duration on <strong>'. $value['work_date'] .'</strong> didnt input correctly, please check !!!</div></div>';
                                                                }
                                                            }
                                                        }
                                                        echo '<div class="alert alert-info">（※）Capacity=Real duration/Working real hour --> hiện thị % lượng công việc làm trong ngày　（稼働率）<br />（※）Performance=Real duration/Standard duration --> hiện thị % tốc độ công việc　（パフォーマンス）</div>';
                                                    }
                                                ?>
                                                
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="span4 text-right">
                                    <?php 
                                        if(!empty($arrayTotalFilter)) { 
                                            echo '<a href="#work_sum" class="btn btn-info">Total View</a>';
                                        }
                                    ?>        
                                    <a class="btn btn-success" href="personal.php?updateSQL=yes">Update Latest Data</a> <button tabindex="0" class="btn btn-primary" role="button" data-toggle="popover" data-trigger="click" data-placement="left" data-container="body" data-html="true" id="PopS"
                                        data-content='
                                        <div id="popover-content">
                                        
                                        <form role="form" method="post" action="personal.php">
                                            
                                            <div class="form-group">
                                                <label>Select Date</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" id="datetimepicker" name="date_all_from" placeholder="From" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" id="datetimepicker1" name="date_all_to" placeholder="To" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                                
                                                <!-- Create Filter -->
                                                <?php 
                                                    echo '<label><select id="filter_project" name="filter_project" style="margin-bottom: 0;">';
                                                        echo '<option value="">Type of Project</option>';
                                                        $selectedProject = (isset($_POST['filter_project']) && $_POST['filter_project'] != '') ? 'selected="selected"' : '';
                                                    foreach($arrayProject as $key => $value) {
                                                        if($value['project_type'] == 'Newton Detail' || $value['project_type'] == 'New Coding Detail' || $value['project_type'] == 'FC Detail' || $value['project_type'] == 'Working') {
                                                            continue;
                                                        }
                                                        
                                                        echo '<option value="'.$value['id'].'" '.$selectedProject.'>'.$value['project_type'].'</option>';
                                                    }
                                                    echo '</select></label>';
                                                ?>
                                                
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary btn-block" type="submit">Show</button>
                                            </div>
                                        </form>
                                        </div>'>Show All</button></div>
                                    </div>

  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-fixed" id="example">
										<thead>
											<tr class="success">
											    <th>Working Date</th>
												<th class="text-center">No</th>
												<?php if(isset($_POST['date_all_from']) && isset($_POST['date_all_to']) && trim($_POST['date_all_from']) != '' && trim($_POST['date_all_to'])) :?>
												<th class="text-center">Designer</th>
												<?php endif; ?>
												<th class="text-center">Project Type</th>
												<th class="text-center">Project no.</th>
												<th class="text-center">Project Name</th>
												<th class="text-center">Order Date</th>
												<th class="text-center">Delivery Date</th>
												<th class="text-center">Delivery Before</th>
												<th class="text-center">Status</th>
												<th class="text-center">Standard Duration</th>
												<th class="text-center">Real Duration </th>
												<th class="text-center">Start</th>
												<th class="text-center">End</th>
												<th class="text-center">Performance</th>
												<th class="text-center">Note</th>
											</tr>
										</thead>
										<tbody>
										  <?php 
										  $totalStandard      =       0;
										  $totalReal          =       0;
										  $totalPerformance   =       0;
										  $i                  =       1;
										  $j                  =       0;
										      if(!empty($arrayWork)) { 
										          $countArrayWork =       count($arrayWork);
										          $arrayWorkKey = array_keys($arrayWork);
										          foreach($arrayWork as $key => $value) :
										              foreach($arrayUser as $k => $v) :
										                  if($value['user'] == $v['id']) {
										                      $value['user'] = $v['nickname'];
										                  }   
										                  endforeach;
										                  $tmpUser = $value['user'];
										                  if($value['project_type'] == 'Other' || $value['project_type'] == 'Research') {
										                      $totalStandard  += 0;
										                      //$totalReal      += 0;
										                      $totalReal      +=      $value['real_duration'];
										                      $totalPerformance += 0;
										                  } else {
										                      $totalStandard  += $value['standard_duration'];
										                      $totalReal      +=      $value['real_duration'];
										                      
										                  }
										                  
										                  if($value['performance'] != 0) {

										                      $j              +=      1;
										                      $totalPerformance += $value['performance'];
										                      
										                  }
										                  /* $totalStandard  += $value['standard_duration'];*/
										                  //$totalReal      +=      $value['real_duration']; 
										                  
										                  
										  ?>
										  
								          <tr class="gradeX">
								            <td><?php echo $value['work_date']; ?></td>
								            <td class="text-center"><?php echo $key+1; ?></td>
								            <?php if(isset($_POST['date_all_from']) && isset($_POST['date_all_to']) && trim($_POST['date_all_from']) != '' && trim($_POST['date_all_to'])) : ?>
											     <td class="text-center"><?php echo $value['user']; ?></td>
											<?php endif; ?>
								            <td class="text-center"><?php echo emptyReturn($value['project_type']); ?></td>
											<td class="text-center"><?php echo emptyReturn($value['project_no']); ?></td>
											<td class="text-center"><?php echo emptyReturn($value['project_name']); ?></td>
											<td class="text-center"><?php echo emptyReturn($value['order_date']); ?></td>
											<td class="text-center"><?php echo emptyReturn($value['delivery_date']); ?></td>
											<td class="text-center"><?php echo emptyReturn($value['delivery_before']); ?></td>
											<td class="text-center"><?php echo emptyReturn($value['status']); ?></td>
											<td class="text-center"><?php echo emptyReturn($value['standard_duration']); ?></td>
											<td class="text-center"><?php echo emptyReturn($value['real_duration']); ?></td>
											<td class="text-center"><?php echo emptyReturn($value['start']); ?></td>
											<td class="text-center"><?php echo emptyReturn($value['end']); ?></td>
											<td class="text-center"><?php echo emptyReturn($value['performance'] * 100); ?>%</td>
											<td class="text-center"><?php echo emptyReturn($value['note']); ?></td>
									      </tr>
									      <?php 
                                             //Divide Date
                                             if(($key+1) < count($arrayWork)) {
                                                 if($arrayWork[$key]['work_date'] != $arrayWork[$key+1]['work_date']) {
                                                     echo '<tr class="info"><td class="text-center" colspan="16">&nbsp;</td></tr>';
                                                 }
                                             } else {
                                                 echo '';
                                             }
                                              
										      /* echo '<pre>';
										      print_r($arrayWork[$key]);
										      echo '</pre>';

										      echo '<pre>';
										      print_r($arrayWork[$key+1]);
										      echo '</pre>'; */
										  ?>
									      <?php 
									               $i++;
									           endforeach;
									           if(!@$_POST['date_all_from'] && isset($_POST['date_from']) && isset($_POST['date_to']) && $_POST['date_from'] != '' && $_POST['date_to'] && $_POST['user_name'] != '') : ?>  
           									       <tr>
           									           <?php 
           									               $statusClass = '';
           									               if($totalStandard <= 6 || $totalReal <= 6) {
           									                   $statusClass = 'label-important';
           									               } elseif($totalStandard >= 7 && $totalStandard <= 8 || $totalReal >= 7 && $totalReal <= 8) {
           									                   $statusClass = 'label-info';
           									               } elseif($totalStandard > 8 && $totalReal > 8) {
           									                   $statusClass = 'label-success';
           									               }
           									           ?>
           									           <td colspan="8"></td>
           									           <td class="text-center"><b>Total</b></td>
           									           <td class="text-center"><span class="label <?php echo $statusClass; ?>"><?php echo $totalStandard;?></span></td>
           									           <td class="text-center"><span class="label <?php echo $statusClass; ?>"><?php echo $totalReal; ?></span></td>
           									           <td></td>
           									           <td class="text-center"><b>Average</b></td>
           									           <td class="text-center"><span class="label <?php echo $statusClass; ?>"><?php echo @round(($totalPerformance / $j * 100), 2); ?>%</span></td>
           									           <td colspan="2"></td>
           									       </tr>
           								   <?php endif;
                   								   //Show Total Work
                   								   if(!empty($arrayTotalFilter)) {
                   								       echo '<tr id="work_sum">';
                       								       foreach($arrayTotalFilter as $key => $value) {
                       								         echo '<td colspan="9"></td>
                                                                   <td class="text-center"><b>Total</b></td>
                                                                   <td class="text-center"><span class="label label-info">'.$value['total_standard'].'</span></td>
                                                                   <td class="text-center"><span class="label label-info">'.$value['total_real'].'</span></td>
                                                                   <td></td>
                       									           <td class="text-center"><b>Average</b></td>
                       									           <td class="text-center"><span class="label label-info">'.@round(($totalPerformance / $j * 100), 2).'%</span></td>
                       									           <td colspan="2"></td>
                                                                    ';
                       								       }
                   								       echo '</tr>';
                   								   }
										      } else {
									       ?>
									             <tr class="warning">
									               <td class="text-center" colspan="<?php if(isset($_POST['date_all_from']) && isset($_POST['date_all_to'])) { echo '15'; } else { echo '14'; } ?>"><strong>No Records</strong></td>
									             </tr>
									       <?php } ?>
										</tbody>
									</table>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                </div>
            </div>
            
            <?php if(!empty($arrayWork) && isset($_POST['user_name']) && $dateFrom == $dateTo) :
                $countArrayWork =       count($arrayWork);
                echo "<div id='timeline'>";
                echo "<ul>";
                $key_flag = false;
                $colorDetail        =   '';
                $maintenanceCheck   =       false;
                $newtonCheck        =       false;
                $fcCheck            =       false;
                $newCodingCheck     =       false;
                $domesticCheck      =       false;
                $researchCheck      =       false;
                $otherCheck         =       false;
                foreach($arrayWork as $key => $value) :
                $newDate = DateTime::createFromFormat('d/m/Y', $value['work_date'])->format('Y-m-d');
                if($key_flag == false) { echo '<li data-start="'.$newDate.'T08:30" data-end="'.$newDate.'T'.$value['start'].'" data-color="transparent"></li><li data-start="'.$newDate.'T12:00" data-end="'.$newDate.'T13:00" data-color="#AB82FF">Lunch Break</li><li data-start="'.$newDate.'T'.$value['end'].'" data-end="'.$newDate.'T17:30" data-color="transparent"></li>'; $key_flag= true;}
                    foreach($arrayUser as $k => $v) :
                    if($value['user'] == $v['id']) {
                        $value['user'] = $v['nickname'];
                    }
                endforeach;
                $tmpUser = $value['user'];
                if($value['project_type'] == 'Other' || $value['project_type'] == 'Research') {
                    //$totalStandard  += 0;
                    //$totalReal      += 0;
                } else {
                
                }
                $totalStandard  += $value['standard_duration'];
                $totalReal      +=      $value['real_duration'];
                $totalPerformance += $value['performance'];
                
                $hourStart  =   substr($value['start'], 0, 2);
                $minStart   =   number_format((substr($value['start'], 3, 2) / 60), 1);
                $hourEnd    =   substr($value['end'], 0, 2);
                $minEnd     =   number_format((substr($value['end'], 3, 2) / 60), 1);
                
                switch ($value['project_type']) {
                    case 'Maintenance':
                        $projectColor = 'rgb(149, 203, 255)';
                        if($maintenanceCheck == false) { $colorDetail .= '<span class="badge" style="background-color: '.$projectColor.';">'.$value['project_type'].'</span>'; $maintenanceCheck = true; }
                        $projectName  = $value['project_no'];
                        break;
                    case 'Newton':
                        $projectColor = '#EE7621';
                        if($newtonCheck == false) { $colorDetail .= '<span class="badge" style="background-color: '.$projectColor.';">'.$value['project_type'].'</span>'; $newtonCheck = true; }
                        $projectName  = $value['project_no'];
                        break;
                    case 'FC':
                        $projectColor = 'rgb(251, 194, 83)';
                        if($fcCheck == false) { $colorDetail .= '<span class="badge" style="background-color: '.$projectColor.';">'.$value['project_type'].'</span>'; $fcCheck = true; }
                        $projectName  = $value['project_name'] . ' (' . $value['page_name'] . ') ';
                        break;
                    case 'New Coding':
                        $projectColor = 'rgb(255, 149, 192)';
                        if($newCodingCheck == false) { $colorDetail .= '<span class="badge" style="background-color: '.$projectColor.';">'.$value['project_type'].'</span>'; $newCodingCheck = true; }
                        $projectName  = (trim($value['page_name']) == '') ? $value['project_name'] . ' (' . $value['work_content'] . ') ' : $value['project_name'] . ' ('. $value['page_name'] . ') ';
                        break;
                    case 'Domestic':
                        $projectColor = 'rgb(218, 152, 241)';
                        if($domesticCheck == false) { $colorDetail .= '<span class="badge" style="background-color: '.$projectColor.';">'.$value['project_type'].'</span>'; $domesticCheck == true; }
                        $projectName  = $value['project_name'];
                        break;
                    case 'Research':
                        $projectColor = 'rgb(54, 248, 220)';
                        if($researchCheck == false) { $colorDetail .= '<span class="badge" style="background-color: '.$projectColor.';">'.$value['project_type'].'</span>'; $researchCheck = true; }
                        $projectName  = $value['project_name'];
                        break;
                    case 'Other':
                        $projectColor = 'rgb(151, 255, 177)';
                        if($otherCheck == false) { $colorDetail .= '<span class="badge" style="background-color: '.$projectColor.';">'.$value['project_type'].'</span>'; $otherCheck = true; }
                        $projectName  = $value['work_content'];
                        break;
                }
            ?>
                    <?php /* if($hourStart < 12 && $hourEnd > 13) {
                        if($key_flag == false) { echo '<li data-start="'.$newDate.'T12:00" data-end="'.$newDate.'T13:00" data-color="#97ffb1">Lunch Break</li>'; $key_flag == true; }
                        echo '<li data-start="'.$newDate.'T'. $value['start'] .'" data-end="'.$newDate.'T12:00" data-color="#95e6ff">'.$value['project_no'].'</li>';
                        echo '<li data-start="'.$newDate.'T13:00" data-end="'.$newDate.'T'.$value['end'].'" data-color="#95e6ff">'.$value['project_no'].'</li>';
                    } elseif(($hourStart < 12 && $hourEnd < 12) || ($hourStart > 13 && $hourEnd > 13)) {
                        if($key_flag == false) { echo '<li data-start="'.$newDate.'T12:00" data-end="'.$newDate.'T13:00" data-color="#97ffb1">Lunch Break</li>'; $key_flag = true; }
                        echo '<li data-start="'.$newDate.'T'. $value['start'] .'" data-end="'.$newDate.'T'.$value['end'].'" data-color="#95e6ff">'.$value['project_no'].'</li>';
                        
                    } else {
                        $projectShow = (trim($value['project_no'] == '')) ? $value['project_name'] : $value['project_no']; 
                        echo '<li data-start="'.$newDate.'T'. $value['start'] .'" data-end="'.$newDate.'T'.$value['end'].'" data-color="#95e6ff">'.$projectShow.'</li>';
                        //echo '<li data-start="'.$newDate.'T'. $value['end'] .'" data-end="'.$newDate.'T17:30" data-color="#95e6ff"></li>';
                    } */
            
                        if((($hourStart+$minStart) < 12 && ($hourEnd+$minEnd) < 12) || (($hourStart+$minStart) > 13 && ($hourEnd+$minEnd) > 13)) {
                            //Addition
                            /* if(($hourStart + $minStart) > 8.5) {
                                echo '<li data-start="'.$newDate.'T8:30" data-end="'.$newDate.'T'.$value['start'].'" data-color="#FF3030">No Work</li>';
                            } */
                            echo '<li data-start="'.$newDate.'T'. $value['start'] .'" data-end="'.$newDate.'T'.$value['end'].'" data-color="'.$projectColor.'">'.$projectName.'</li>';
                            
                        } elseif (($hourStart+$minStart) < 12 && $hourEnd == 12) {
                            
                            echo '<li data-start="'.$newDate.'T'. $value['start'] .'" data-end="'.$newDate.'T12:00" data-color="'.$projectColor.'">'.$projectName.'</li>';
                        } elseif($hourStart == 13 && ($hourEnd+$minEnd) > 13) {
                            echo '<li data-start="'.$newDate.'T13:00" data-end="'.$newDate.'T'.$value['end'].'" data-color="'.$projectColor.'">'.$projectName.'</li>';
                        } elseif (($hourStart+$minStart) < 12 && ($hourEnd+$minEnd) > 13) {
                            echo '<li data-start="'.$newDate.'T'. $value['start'] .'" data-end="'.$newDate.'T12:00" data-color="'.$projectColor.'">'.$projectName.'</li>';
                            echo '<li data-start="'.$newDate.'T13:00" data-end="'.$newDate.'T'.$value['end'].'" data-color="'.$projectColor.'">'.$projectName.'</li>';
                            
                        }
                        
                        
                    ?>
                    
            <?php 
                endforeach;
                echo "</ul>";
                echo "</div>";
                echo '<div class="pull-right">'.$colorDetail.'</div>';
            endif; ?>  
            <div class="clearboth"></div>
            <hr>
            <footer>
                <p>&copy; Freesale Vietnam</p>
            </footer>
        <!--/.fluid-container-->

        <script src="vendors/jquery-1.9.1.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- <script src="vendors/datatables/js/jquery.dataTables.min.js"></script> -->


        <script src="assets/scripts.js"></script>
        <!-- <script src="assets/DT_bootstrap.js"></script> -->
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/custom.js"></script>
        <script src="js/jquery.floatThead.min.js"></script>
        <script src="js/moment.min.js"></script>
        <script src="js/jquery.daterangepicker.js"></script>
        <script src="js/timestack.min.js"></script>
        <script type="text/javascript">        
        $(document).ready(function () {
            var showPopover = $.fn.popover.Constructor.prototype.show;
            $.fn.popover.Constructor.prototype.show = function () {
                showPopover.call(this);
                if (this.options.showCallback) {
                    this.options.showCallback.call(this);
                }
            }
            $("#PopS").popover({
                html: true,
                showCallback: function () {
                	$("#datetimepicker1").datepicker({
                		dateFormat:"dd/mm/yy",
                	});

                	$("#datetimepicker").datepicker({
                		dateFormat:"dd/mm/yy",
                	    onSelect: function(dateText, inst) {
                	        var date = $(this).val();
                	        $("#datetimepicker1").val(date);
                	    }
                	});

                }
            });

            var $demo1 = $('table.table-fixed');
            $demo1.floatThead({
            	scrollContainer: function($table){
            		return $table.closest('.wrapper');
            	}
            });

            $('.work-time-tooltip').tooltip();

            $("#date-range201").datepicker({
        		dateFormat:"dd/mm/yy",
            });
            
            $("#date-range200").datepicker({
        		dateFormat:"dd/mm/yy",
        	    onSelect: function(dateText, inst) {
        	        var date = $(this).val();
        	        $("#date-range201").val(date);
        	    }
        	});

            $('#timeline').timestack({
          	  span: 'hour',
          	  data: [/*...*/],
 
            	dateFormats: {                       //how to render times for various spans. These are moment formatting tokens.
              	    year: 'MMM YYYY',
              	    month: 'MMM DD',
              	    day: 'MMM DD',
              	    hour: 'HH:mm'
              	  },

              	  intervalFormats: {                   //how to render the intervals for various spans. These are moment formatting tokens.
              	    year: 'YYYY',
              	    month: 'MMM YYYY',
              	    day: 'MMM DD',
              	    hour: 'HH:mm'
              	  }, 
          	});

            $("#btn_abort").click(function(){
                var dataUser = $(this).attr('data-user');
                var dataDate = $(this).attr('data-date');
                var url      = 'abort.php';
                var dataSend = {'user' : dataUser, 'date' : dataDate};
                $.post(url, dataSend, function(data, status){
                    //console.log(data);
                    if(status == 'success') {
                        if(data == 'success') {
                            $(".alert_wrapper .alert-error").fadeOut('fast');
                            $(".alert_wrapper").html('<div class="alert alert-success">Update Successfully</div>').fadeIn('slow');
                        }
                    }
                });
            });
        });
        
        </script>
    </body>

</html>