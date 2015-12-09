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
if(isset($_POST['date_all_from']) && isset($_POST['date_all_to']) && trim($_POST['date_all_from']) != '' && trim($_POST['date_all_to']) != '') {
        $dateAllFrom       =    $_POST['date_all_from'];
        $dateAllTo          =   $_POST['date_all_to'];
        if($dateAllFrom == $dateAllTo) {
            $queryWork      =   "SELECT * FROM `work` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) = STR_TO_DATE( '{$dateAllTo}', '%d/%m/%Y' ) ORDER BY `user`, `work_date` ASC";
        } else {
            $queryWork      =   "SELECT * FROM `work` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateAllFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateAllTo}', '%d/%m/%Y' ) ORDER BY `user`, `work_date` ASC";
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
                                        <div class="span6">
                                        
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
                                                                            echo '<li class="work-time-tooltip" data-placement="top" data-toggle="tooltip" title="'.$value['work_date'].'"><strong>'.($value['delay'] + $value['unpaid'] + $value['paid'] + $value['others']).'</strong></li>';
                                                                        }
                                                                    }
                                                                    echo '</ul>';
                                                                echo '</li>';
                                                                    
                                                                echo '<li>';
                                                                    // Working Day Hour
                                                                    $workingDayTotal = 0;
                                                                    echo '<ul class="inline">';
                                                                        echo '<li>Working day hour: </li>';
                                                                        foreach($arrayGetWorktime as $key => $value) {
                                                                            if(isWeekend($value['work_date']) == true) {
                                                                                continue;
                                                                                $workingDayTotal += 0;
                                                                            } else {
                                                                                echo '<li class="work-time-tooltip" data-placement="top" data-toggle="tooltip" title="'.$value['work_date'].'"><strong>'.$value['work_time'].'</strong></li>';
                                                                                $workingDayTotal += $value['work_time'];
                                                                            }
                                                                        }
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
                                                                            echo '<li class="work-time-tooltip label label-important" data-placement="top" data-toggle="tooltip" title="'.$value['work_date'].'"><strong>'.$value['overtime'].'</strong></li> ';
                                                                        }
                                                                        
                                                                    }
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
                                                                        echo '<li>Performance: </li>';
                                                                        echo '<li class="label label-info">'.round((($dayRealDur / $workingDayTotal) * 100), 2).'%</li>';
                                                                    echo '</ul>';
                                                                echo '</li>';
                                                             echo '</ul>';
                                                            
                                                            //Create Alert
                                                            if($dayRealDur > $workingDayTotal) {
                                                                echo '<div class="alert alert-error">The real time duration didnt input correctly, please check !!!</div>';
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
                                                                        if(isWeekend($value['work_date']) == true) { 
                                                                            echo '<li class="work-time-tooltip" data-placement="top" data-toggle="tooltip" title="Weekend"><strong>Weekend</strong></li>';
                                                                        } else {
                                                                            echo '<li class="work-time-tooltip" data-placement="top" data-toggle="tooltip" title="'.$value['work_date'].'"><strong>'.($value['delay'] + $value['unpaid'] + $value['paid'] + $value['others']).'</strong></li>';
                                                                        }
                                                                    }
                                                                    echo '</ul>';
                                                                echo '</li>';
                                                                    
                                                                echo '<li>';
                                                                    // Working Day Hour
                                                                    $workingDayTotal = 0;
                                                                    echo '<ul class="inline">';
                                                                        echo '<li>Working day hour: </li>';
                                                                        foreach($arrayGetWorktime as $key => $value) {
                                                                            if(isWeekend($value['work_date']) == true) {
                                                                                echo '<li class="work-time-tooltip" data-placement="top" data-toggle="tooltip" title="Weekend"><strong>Weekend</strong></li>';
                                                                                $workingDayTotal = 1;
                                                                            } else {
                                                                                echo '<li class="work-time-tooltip" data-placement="top" data-toggle="tooltip" title="'.$value['work_date'].'"><strong>'.$value['work_time'].'</strong></li>';
                                                                                $workingDayTotal += $value['work_time'];
                                                                            }
                                                                        }
                                                                    echo '</ul>';
                                                                echo '</li>';
                                                                
                                                                echo '<li>';
                                                                    // Overtime
                                                                    echo '<ul class="inline">';
                                                                    echo '<li>Overtime: </li>';
                                                                    foreach($arrayGetWorktime as $key => $value) {
                                                                        if(isWeekend($value['work_date']) == true) {
                                                                            echo '<li class="work-time-tooltip" data-placement="top" data-toggle="tooltip" title="Weekend"><strong>Weekend</strong></li>';
                                                                        } else {
                                                                            echo '<li class="work-time-tooltip label label-important" data-placement="top" data-toggle="tooltip" title="'.$value['work_date'].'"><strong>'.$value['overtime'].'</strong></li> ';
                                                                        }
                                                                        
                                                                    }
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
                                                                        echo '<li>Performance: </li>';
                                                                        echo '<li class="label label-info">'.round((($dayRealDur / $workingDayTotal) * 100), 2).'%</li>';
                                                                    echo '</ul>';
                                                                echo '</li>';
                                                             echo '</ul>';
                                                            
                                                            //Create Alert
                                                            if($dayRealDur > $workingDayTotal) {
                                                                echo '<div class="alert alert-error">The real time duration didnt input correctly, please check !!!</div>';
                                                            }
                                                        }
                                                    }
                                                ?>
                                        </div>
                                        
                                    </div>
                                    <div class="span6 text-right"><a class="btn btn-success" href="personal.php?updateSQL=yes">Update Latest Data</a> <button tabindex="0" class="btn btn-primary" role="button" data-toggle="popover" data-trigger="click" data-placement="left" data-container="body" data-html="true" id="PopS"
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
												<th class="text-center">Speed</th>
												<th class="text-center">Note</th>
											</tr>
										</thead>
										<tbody>
										  <?php 
										  $totalStandard      =       0;
										  $totalReal          =       0;
										  $totalPerformance   =       0;
										  $i                  =       1;
										      if(!empty($arrayWork)) { 
										          $countArrayWork =       count($arrayWork);
										          foreach($arrayWork as $key => $value) :
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
											<td class="text-center"><?php echo emptyReturn($value['performance']); ?></td>
											<td class="text-center"><?php echo emptyReturn($value['note']); ?></td>
									      </tr>
									      
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
           									           <td class="text-center"><span class="label <?php echo $statusClass; ?>"><?php echo round(($totalStandard / $totalReal * 100), 2); ?>%</span></td>
           									           <td colspan="2"></td>
           									       </tr>
           								   <?php endif;
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
            
            <hr>
            <footer>
                <p>&copy; Freesale Vietnam</p>
            </footer>
        </div>
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

            /*$('#two-inputs').dateRangePicker({
                format: 'DD/MM/YYYY',
                separator : ' to ',
            	getValue: function()
            	{
            		if ($('#date-range200').val() && $('#date-range201').val() )
            			return $('#date-range200').val() + ' to ' + $('#date-range201').val();
            		else
            			return '';
            	},
            	setValue: function(s,s1,s2)
            	{
            		$('#date-range200').val(s1);
            		$('#date-range201').val(s2);
            	}
            });*/

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

        });
        
        </script>
    </body>

</html>