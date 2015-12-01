<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="UTF-8">
        <title>Group Management</title>
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
    <body>
        <?php require_once 'header.php'; ?>
        <div class="container-fluid">
            <div class="row-fluid">
                
                <div class="span12" id="content">

                     <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Group Management</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <div class="span6">
                                    </div>
                                    <div class="span6 text-right">
                                    </div>

  									<div id="group_table">
  									     <div class="span6">
                                            <!-- block -->
                                            <div class="block">
                                                <div class="navbar navbar-inner block-header">
                                                    <div class="muted pull-left">Users</div>
                                                    <div class="pull-right"><span class="badge badge-info">1,234</span>
                
                                                    </div>
                                                </div>
                                                <div class="block-content collapse in">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>First Name</th>
                                                                <th>Last Name</th>
                                                                <th>Username</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>Mark</td>
                                                                <td>Otto</td>
                                                                <td>@mdo</td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>Jacob</td>
                                                                <td>Thornton</td>
                                                                <td>@fat</td>
                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td>Vincent</td>
                                                                <td>Gabriel</td>
                                                                <td>@gabrielva</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- /block -->
                                        </div>
  									</div><!-- group_table -->
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
        <script type="text/javascript">
        /* $(document).ready(function(){
            $("#btn_show").click(function(){
                $("#user_form").submit();
            });
        }); */

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

        });
        </script>
    </body>

</html>