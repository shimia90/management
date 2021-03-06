<?php require_once 'process.php'; 
    if(isset($_GET['date_search']) && trim($_GET['date_search']) != '') $_SESSION['date_search'] = $_GET['date_search'];
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
        <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="vendors/flot/excanvas.min.js"></script><![endif]-->
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <?php 
        // Single Person
        $username       =   '';
        $message        = '';
        if(isset($_GET['user_name']) && $_GET['type'] == 'single') {
            $username       = $_GET['user_name'];
            $resultArray    = array();
            $flagUser       = false;
            foreach ($data as $key => $value) {
                if(array_key_exists($username, $value)) {
                    $flagUser = true;
                    $resultArray = $value[$username];
                    break;
                } else {
                    $message    = '<h4 class="text-center">This user doesn\'t have any records today !</h4>';
                    $flagUser   =   false;
                }
            }
        }
    ?>
    <body>
        <div class="container-fluid">
            <div class="row-fluid">
                
                <div class="span12" id="content">

                     <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Records on <?php echo $today; ?></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <div class="span6">
                                        <div id="example_length">
                                            <form action="link.php" method="get" id="user_form" class="form-inline">
                                                <label>
                                                    Name: 
                                                    <select id="user_select" size="1" name="user_name" aria-controls="example">
                                                        <option value="">Select Member</option>
                                                        <?php foreach($memberArray as $key => $value) :
                                                            if($value[0] == $username) { $selected = 'selected="selected"'; } else { $selected = ''; }
                                                        ?>
                                                        <option value="<?php echo $value[0]; ?>" <?php echo $selected; ?>><?php echo $value[1]; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </label>
                                                <label>
                                                    Date: <input type="text" id="datepicker" name="date_search" value="<?php if(isset($_GET['date_search'])) { echo $_GET['date_search']; } else { echo $today; } ?>" />
                                                </label>
                                                <input type="hidden" name="type" value="single" />
                                                <input type="hidden" name="page_submit" value="record" />
                                                <button class="btn btn-warning" type="submit">Search</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="span6 text-right"><a href="record.php" class="btn btn-primary">Show All</a> <a href="index.php" class="btn btn-success">Go Back</a></div>
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="example">
										<thead>
											<tr>
												<th>No</th>
												<th>Name</th>
												<th>Project Type</th>
												<th>Project No</th>
												<th>Project Name</th>
												<th>Order Date</th>
												<th>Delivery Date</th>
												<th>Delivery Before</th>
												<th>Standard Duration</th>
												<th>Real Duration</th>
												<th>Start </th>
												<th>End</th>
												<th>Performance</th>
												<th>Note</th>
											</tr>
										</thead>
										<tbody>
									       <?php 
									           // Show All Record Today
									           if(!isset($_GET['user_name']) || trim($_GET['user_name']) == '') :
									            $j = 1;
                                                for($i = 0; $i < count($data); $i++) {
                                                    $sum = 0;
                                                    foreach ($data[$i] as $key => $value) {
                                                        $c = 1;
                                                        foreach($value as $k => $v) {
                                                            
									               $class = ($i%2 == 0) ? 'even' : 'odd';
									       ?>
											<tr class="gradeX <?php echo projectTypeBg($v['PROJECT_TYPE']);?>">
												<td class="text-center"><?php if($c == 1) echo $j; ?></td>
												<td class="text-center"><?php if($c == 1) echo $key; ?></td>
												<td class="text-center"><?php echo $v['PROJECT_TYPE'];?></td>
												<td class="text-center"><?php echo $v['PROJECT_NO'];?></td>
												<td class="text-center"><?php echo $v['PROJECT_NAME']; ?></td>
												<td class="text-center"><?php echo $v['ORDER_DATE']; ?></td>
												<td class="text-center"><?php echo $v['DELIVERY_DATE']; ?></td>
												<td class="text-center"><?php echo @$v['DELIVERY_BEFORE']; ?></td>
												<td class="text-center"><?php echo $v['STANDARD_DURATION']; ?></td>
												<td class="text-center"><?php echo $v['REAL_DURATION']; ?></td>
												<td class="text-center"><?php echo $v['START']; ?></td>
												<td class="text-center"><?php echo $v['END']; ?></td>
												<td class="text-center"><?php echo round($v['PERFORMANCE'],2); ?></td>
												<td class="text-center"><?php echo $v['NOTE']; ?></td>
											</tr>
											<?php 
											     $sum += $v['REAL_DURATION'];
											     $c++;
									                   }
									        ?>
									        <tr>
											     <td colspan="14" class="text-center"><?php echo '<h4 class="text-right">Total: <strong>' . $sum . '</strong></h4>'; ?></td>
											</tr>
									        <?php 
									               }
									            $j++;
									          } 
									          endif;
									        ?>
									        <?php 
                        			           // Show Single People
                        			           if(isset($_GET['user_name']) && $flagUser == true) :
                        			               $i = 1;
                        			               $sum = 0;
                        				           foreach($resultArray as $key => $value) :
                        				           $class = ($i%2 == 0) ? 'even' : 'odd';
                        				     ?>
                            							<tr class="gradeX <?php echo projectTypeBg($value['PROJECT_TYPE']);?>">
                        									<td class="text-center"><?php echo $i; ?></td>
                        									<td class="text-center"><?php echo $value['USER']; ?></td>
                        									<td class="text-center"><?php echo $value['PROJECT_TYPE'];?></td>
                        									<td class="text-center"><?php echo $value['PROJECT_NO'];?></td>
                        									<td class="text-center"><?php echo $value['PROJECT_NAME']; ?></td>
                        									<td class="text-center"><?php echo $value['ORDER_DATE']; ?></td>
                        									<td class="text-center"><?php echo $value['DELIVERY_DATE']; ?></td>
                        									<td class="text-center"><?php echo @$value['DELIVERY_BEFORE']; ?></td>
                        									<td class="text-center"><?php echo $value['STANDARD_DURATION']; ?></td>
                        									<td class="text-center"><?php echo $value['REAL_DURATION']; ?></td>
                        									<td class="text-center"><?php echo $value['START']; ?></td>
                        									<td class="text-center"><?php echo $value['END']; ?></td>
                        									<td class="text-center"><?php echo round($value['PERFORMANCE'],2); ?></td>
                        									<td class="text-center"><?php echo $value['NOTE']; ?></td>
                        								</tr>		               
                                            <?php
                                                   $i++;
                                                   $sum += $value['REAL_DURATION'];
                        				           endforeach;
                        				    ?>
                        				                <tr>
            											     <td colspan="14" class="text-center"><?php echo '<h4 class="text-right">Total: <strong>' . $sum . '</strong></h4>'; ?></td>
            											</tr>
                        				    <?php
                        			           elseif(isset($_GET['user_name']) && $flagUser == false && trim($_GET['user_name']) != ''):
                        			        ?>
                        			          <tr class="error">
                        			             <td colspan="14"><?php echo $message; ?></td>
                        			          </tr>
                        			        <?php    
                        			           endif;
                        			        ?>
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
    </body>

</html>