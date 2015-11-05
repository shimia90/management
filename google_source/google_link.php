<?php 
    require_once '../class/Database.class.php';
    $params		= array(
        'server' 	=> 'localhost',
        'username'	=> 'root',
        'password'	=> '',
        'database'	=> 'management',
        'table'		=> 'source_link',
    );
    $database       =   new Database($params);
    $query          =   'SELECT * FROM source_link';
    $arraySource    =   $database->listRecord($database->query($query));
?>
<!DOCTYPE html>
<html>
    
    <head>
        <title>Google Doc Link Management</title>
        <!-- Bootstrap -->
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="../assets/styles.css" rel="stylesheet" media="screen">
        <link href="../assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="vendors/flot/excanvas.min.js"></script><![endif]-->
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="../vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    
    <body>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12" id="content">
                     <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Bootstrap dataTables with Toolbar</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                   <div class="table-toolbar">
                                      <div class="btn-group">
                                         <a href="google_link_insert.php?type=insert"><button class="btn btn-success">Add New <i class="icon-plus icon-white"></i></button></a>
                                      </div>
                                   </div>
                                    
                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th class="text-center">Link</th>
                                                <th class="text-center">Month</th>
                                                <th class="text-center">Year</th>
                                                <th class="text-center">Project Type</th>
                                                <th class="text-center">Action</th>
                                            </tr> 
                                        </thead>
                                        <tbody>
                                        <?php
                                            $arrayProject = array('Maintenance', 'New coding', 'Domestic', 'Newton', 'Research', 'Other'); 
                                            $d = 1;
                                            
                                            for($i = 0; $i < count($arraySource); $i++) { 
                                                $class = ($d % 2 == 0) ?  'even' : 'odd';
                                                foreach($arrayProject as $key => $value) {
                                                    if($arraySource[$i]['project_link'] == $key + 1) {
                                                        $arraySource[$i]['project_link'] = $value;
                                                    }
                                                }
                                        ?>
                                                <tr class="<?php echo $class; ?> gradeA">
                                                    <td class="text-center"><?php echo $arraySource[$i]['id']; ?></td>
                                                    <td class="text-center"><?php echo $arraySource[$i]['link']?></td>
                                                    <td class="text-center"><?php echo $arraySource[$i]['link_month']; ?></td>
                                                    <td class="text-center"><?php echo $arraySource[$i]['link_year']; ?></td>
                                                    <td class="text-center"><?php echo $arraySource[$i]['project_link']; ?></td>
                                                    <td class="text-center"><a class="btn btn-mini btn-primary" href="google_link_insert.php?type=edit&&idLink=<?php echo $arraySource[$i]['id']; ?>">Edit</a> <a class="btn btn-mini btn-danger" href="google_link_delete.php?idLink=<?php echo $arraySource[$i]['id']; ?>" onclick="deleteConfirm()">Delete</a></td>
                                                </tr>
                                        <?php
                                                $d++;
                                            }
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
                <p>&copy; Freesale VietNam</p>
            </footer>
        </div>
        <!--/.fluid-container-->

        <script src="../vendors/jquery-1.9.1.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendors/datatables/js/jquery.dataTables.min.js"></script>


        <script src="../assets/scripts.js"></script>
        <script src="../assets/DT_bootstrap.js"></script>
        <script>
        function deleteConfirm() {
            confirm("Do you want to delete this row ?");
        }
        </script>
    </body>

</html>