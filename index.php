<?php 
require_once 'process_group.php';
if(isset($_GET['date_search']) && trim($_GET['date_search']) != '') $_SESSION['date_search'] = $_GET['date_search'];
if(isset($_POST['maintenance_link']) || isset($_POST['newton_link'])) {
    
    $_SESSION['maintenance_link'] = $_POST['maintenance_link'];
    $_SESSION['newton_link'] = $_POST['newton_link'];
} 
?>
<!DOCTYPE html>
<html class="no-js">
    
    <head>
        <title>Users Management System</title>
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
        <link href="assets/styles.css" rel="stylesheet" media="screen">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    
    <body>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12" id="content">
                    <div class="row-fluid">
                    	<div class="span6"><?php echo $messageUrl; ?></div>
                    	<div class="span6">
                    	   <div class="alert alert-info">Records of Group on <?php echo $today; ?></div>
                    	</div>
                    </div>
                    <div class="row-fluid">
                        <div class="span6">
                            <a href="#change_link" class="btn btn-warning" data-toggle="modal" role="button">Change Google Doc Link</a>
                        </div>
                        <div class="span6">
                            <form action="" method="get" id="user_form" class="form-inline pull-left">
                                <label>
                                    <select size="1" name="date_search" aria-controls="example">
                                        <option value="">Select Date</option>
                                        <?php 
                                            // for each day in the month
                                            for($i = 1; $i <=  date('t'); $i++)
                                            {
                                                // add the date to the dates array
                                                $dates[] = str_pad($i, 2, '0', STR_PAD_LEFT). "/" . date('m') . "/" . date('Y')   ;
                                            }
                                            foreach($dates as $key => $value) :
                                                if($value == $today) { $selected = 'selected="selected"'; } else { $selected = ''; }
                                        ?>
                                            <option value="<?php echo $value; ?>" <?php echo $selected;?>><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </label>
                                <input type="hidden" name="type" value="single" />
                                <button class="btn btn-warning" type="submit">Search</button>
                            </form>
                    	   <ul class="unstyled inline text-right pull-right">
                            	<li><span class="label label-success">&nbsp;</span> Maintenance</li>
                            	<li><span class="label label-info">&nbsp;</span> Newton</li>
                            </ul>
                        </div>
                    </div>
            <?php 
                $countTeam = count($resultArray);
                $r = 1;
                for($t = 1; $t <= $countTeam; $t++) {
            ?>
            <?php if($t >= 3 && $t%2 !=0 || $t == 1) { ?>
                    <div class="row-fluid">
            <?php } ?>
                        <div class="span6">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Team</div>
                                    <div class="pull-right"><span class="badge badge-info"><?php echo $t; ?></span>

                                    </div>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Project</th>
                                                <th>Standard Duration</th>
                                                <th>Real Duration</th>
                                                <th>Performance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                foreach($resultArray[$t] as $key => $value) :
                                            ?>
                                            <tr class="success">
                                                <td><?php echo $key + 1; ?></td>
                                                <td><a href="record.php?user_name=<?php echo $value['NICK_NAME']; ?>&&type=single" title="<?php echo $value['NAME']; ?>"><?php echo $value['NICK_NAME']; ?></a></td>
                                                <?php 
                                                    if(array_key_exists('WORK', $value)) :
                                                        /* $value['WORK'] = array_values($value['WORK']); */
                                                        $countMaintenance = 0;
                                                        $countNewton = 0;
                                                        $xhtml = '';
                                                        $sumStandard = 0;
                                                        $sumReal = 0;
                                                        foreach($value['WORK'] as $v) :
                                                            $flagType = '';
                                                            foreach($v as $a => $b) {
                                                                if($a == 'PROJECT_TYPE') {
                                                                    if($b == 'Maintenance') $flagType = 'maintenance';
                                                                    if($b == 'Newton') $flagType = 'newton';
                                                                    /* $xhtml = '<td><span class="label label-success">'.$countMaintenance.'</span> <span class="label label-info">'.$countNewton.'</span></td>'; */
                                                                }
                                                                if($a == 'STANDARD_DURATION') {
                                                                    $sumStandard += $b;
                                                                    if($flagType == 'maintenance') {
                                                                        $countMaintenance += $b;
                                                                    } elseif($flagType == 'newton') {
                                                                        $countNewton += $b;
                                                                    }
                                                                    $xhtml = '<td><span class="label label-success" title="Maitenance">'.$countMaintenance.'</span> <span class="label label-info" title="Newton">'.$countNewton.'</span></td>';
                                                                    $xhtml .= '<td class="text-center">'.$sumStandard.'</td>';
                                                                }
                                                                if($a == 'REAL_DURATION') {
                                                                    $sumReal += $b;
                                                                    $xhtml .= '<td class="text-center">'.$sumReal.'</td>';
                                                                }
                                                                
                                                                if($a == 'PERFORMANCE') {
                                                                    $xhtml .= '<td class="text-center">'.round($sumStandard/$sumReal, 2)*100 .'%'.'</td>';
                                                                }
                                                            }        
                                                        endforeach;
                                                        echo $xhtml;
                                                    else:
                                                ?>
                                                    <td><span class="label label-success">0</span> <span class="label label-info">0</span></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                <?php 
                                                    endif;
                                                ?>
                                            </tr>
                                            <?php 
                                                endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /block -->
                        </div>
                   <?php if($t == 2) echo '</div>'; ?>
            <?php if($t > 3 && $t%2 == 0) { ?>
                    </div>
            <?php } ?>
                
            <?php } ?>
                </div>
            </div>
            <hr>
            <footer>
                <p>&copy; Freesale Vietnam</p>
            </footer>
        </div>
        <!--/.fluid-container-->
        <script src="vendors/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="vendors/easypiechart/jquery.easy-pie-chart.js"></script>
        <script src="assets/scripts.js"></script>
        
        <!-- Modal -->
        <div id="change_link" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Google Doc Links</h3>
          </div>
          <div class="modal-body">
            <form action="index.php" method="post" id="google_change_link_form">
              <fieldset>
                <label>Maintenance Google Doc Link</label>
                <input type="text" placeholder="Google Doc Link" value="" name="maintenance_link">
                <label>Newton Google Doc Link</label>
                <input type="text" placeholder="Google Doc Link" value="" name="newton_link">
              </fieldset>
            </form>
          </div>
          <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button id="google_btn_change" class="btn btn-primary">Save changes</button>
          </div>
        </div>
    </body>

</html>