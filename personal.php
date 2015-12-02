<?php
$today          = date("d/m/Y");
if(isset($_GET['updateSQL']) && $_GET['updateSQL'] == 'yes') {
    require_once 'import_work.php';
}
require_once 'class/Database.class.php';
$arrayConnect = array('server' 	=> 'localhost','username'	=> 'root',);
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
$paramsWork		= array(
    'server' 	=> 'localhost',
    'username'	=> 'root',
    'password'	=> '',
    'database'	=> 'management',
    'table'		=> 'work',
);
$databaseUser       =   new Database($paramsUser);
$databaseProject    =   new Database($paramsProject);
$databaseWork       =   new Database($paramsWork);
$arrayUser          =   $databaseUser->listRecord($databaseUser->query('SELECT * FROM user'));
$arrayProject       =   $databaseProject->listRecord($databaseProject->query('SELECT * FROM project_type'));
$datePost           =   '';
$userPost           =   '';
$arrayWork          =   array();
/* echo '<pre>';
print_r($arrayUser);
echo '</pre>';
die(); */
if(isset($_POST['date_search']) && isset($_POST['user_name']) && trim($_POST['date_search']) != '' && trim($_POST['user_name']) != '') {
    $datePost       =   $_POST['date_search'];
    $arrayDateRange =   explode(" to ", $datePost);
    $dateFrom       =   trim($arrayDateRange[0]);
    $dateTo         =   trim($arrayDateRange[1]);
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
if(isset($_POST['date_show'])) {
        $datePost       =   $_POST['date_show'];
        $queryWork      =   "SELECT * FROM `work` WHERE `work_date` = '{$datePost}' ORDER BY `user` ASC";
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
                                                            $selectedUser = ($value['id'] == $_POST['user_name']) ? 'selected="selected"' : '';
                                                        ?>
                                                        <option value="<?php echo $value['id']; ?>" <?php echo $selectedUser; ?>><?php echo $value['fullname'];?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </label>
                                                <label>
                                                    Date: <input type="text" id="datepicker_from" name="date_search" value="<?php echo $datePost; ?>" placeholder="Date Range" />
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
                                            <?php elseif(isset($_POST['date_search']) && trim($_POST['date_search'] == '')) :?>
                                                <div class="alert alert-error">
                                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                                  <strong>Date is empty!</strong> Please select date
                                                </div>
                                            <?php elseif(isset($_POST['date_search']) && isset($_POST['user_name']) && $_POST['date_search'] == '' && $_POST['user_name'] == '') : ?>
                                                <div class="alert alert-error">
                                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                                  <strong>These fields are empty! </strong> Please input
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="working_time">
                                            <p>Being late/ Leave early: <span></span></p>
                                            <p>Working dur: <span></span></p>
                                        </div>
                                    </div>
                                    <div class="span6 text-right"><a class="btn btn-success" href="personal.php?updateSQL=yes">Update Latest Data</a> <button tabindex="0" class="btn btn-primary" role="button" data-toggle="popover" data-trigger="click" data-placement="left" data-container="body" data-html="true" id="PopS"
                                        data-content='
                                        <div id="popover-content">
                                        <form role="form" method="post" action="personal.php">
                                            <div class="form-group">
                                                <label>Select Date</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" placeholder="Select Date" id="datetimepicker1" name="date_show" />
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
												<th class="text-center">No</th>
												<?php if(isset($_POST['date_show'])) :?>
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
										      if(!empty($arrayWork)) { 
										          $countArrayWork =       count($arrayWork);
										          foreach($arrayWork as $key => $value) :
										              foreach($arrayUser as $k => $v) :
										                  if($value['user'] == $v['id']) {
										                      $value['user'] = $v['nickname'];
										                  }   
										                  endforeach;
										                  $tmpUser = $value['user'];
										                  $totalStandard  += $value['standard_duration'];
										                  $totalReal      +=      $value['real_duration'];
										                  $totalPerformance += $value['performance'];
										  ?>
										  <tr class="info"><td colspan="<?php if(isset($_POST['date_show'])) { echo '15'; } else { echo '14'; } ?>"><strong><?php echo $value['work_date']; ?></strong></td></tr>
								          <tr class="gradeX">
								            <td class="text-center"><?php echo $key+1; ?></td>
								            <?php if(isset($_POST['date_show'])) :?>
											     <td class="text-center"><?php echo $value['user']; ?></td>
											<?php endif; ?>
								            <td class="text-center"><?php echo $value['project_type']?></td>
											<td class="text-center"><?php echo $value['project_no']?></td>
											<td class="text-center"><?php echo $value['project_name']?></td>
											<td class="text-center"><?php echo $value['order_date']?></td>
											<td class="text-center"><?php echo $value['delivery_date']?></td>
											<td class="text-center"><?php echo $value['delivery_before']?></td>
											<td class="text-center"><?php echo $value['status']?></td>
											<td class="text-center"><?php echo $value['standard_duration']?></td>
											<td class="text-center"><?php echo $value['real_duration']?></td>
											<td class="text-center"><?php echo $value['start']?></td>
											<td class="text-center"><?php echo $value['end']?></td>
											<td class="text-center"><?php echo $value['performance']?></td>
											<td class="text-center"><?php echo $value['note']?></td>
									      </tr>
									      
									      <?php 
									               $i++;
									           endforeach;
									           if(!@$_POST['date_show'] && isset($_POST['date_search']) && $_POST['date_search'] != '' && $_POST['user_name'] != '') : ?>  
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
           									           <td colspan="7"></td>
           									           <td class="text-center"><b>Total</b></td>
           									           <td class="text-center"><span class="label <?php echo $statusClass; ?>"><?php echo $totalStandard;?></span></td>
           									           <td class="text-center"><span class="label <?php echo $statusClass; ?>"><?php echo $totalReal; ?></span></td>
           									           <td></td>
           									           <td class="text-center"><b>Average</b></td>
           									           <td class="text-center"><span class="label <?php echo $statusClass; ?>"><?php echo round(($totalStandard / $totalReal * 100), 2); ?>%</span><td>
           									           <td colspan="2"></td>
           									       </tr>
           								   <?php endif;
										      } else {
									       ?>
									             <tr class="warning">
									               <td class="text-center" colspan="<?php if(isset($_POST['date_show'])) { echo '15'; } else { echo '14'; } ?>"><strong>No Records</strong></td>
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
                }
            });

            var $demo1 = $('table.table-fixed');
            $demo1.floatThead({
            	scrollContainer: function($table){
            		return $table.closest('.wrapper');
            	}
            });

            $('#datepicker_from').dateRangePicker({
                format: 'DD/MM/YYYY'
            });

        });
        
        </script>
    </body>

</html>