<?php
ob_start();

if (isset($_GET['idLink'])) {
    $message = '';
    require_once '../class/Database.class.php';
    $params = array(
        'server' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'management',
        'table' => 'source_link'
    );
    $database = new Database($params);
    $arrayDelete = array(
        $_GET['idLink']
    );
    if ($database->delete($arrayDelete)) {
        $message = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert"></button>
						Delete successful!
					</div>';
    } else {
        $message = '<div class="alert alert-error">
                    	<button class="close" data-dismiss="alert"></button>
                    	Invalid ID or Delete Failed;
                    </div>';
    }
} else {
    header("location: google_link.php");
}
?>
							
<!DOCTYPE html>
<html>

<head>
<title>Forms</title>
<!-- Bootstrap -->
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet"
	media="screen">
<link href="../bootstrap/css/bootstrap-responsive.min.css"
	rel="stylesheet" media="screen">
<link href="../assets/styles.css" rel="stylesheet" media="screen">
<link href="../css/jquery-ui.min.css" rel="stylesheet" media="screen">
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../vendors/flot/excanvas.min.js"></script><![endif]-->
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
<script src="../vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>

<body>

	<div class="container-fluid">
		<div class="row-fluid">

			<div class="offset2 span6" id="content">

				<!-- validation -->
				<div class="row-fluid">
					<!-- block -->
					<div class="block">
						<div class="navbar navbar-inner block-header">
							<div class="muted pull-left">Google Link Delete</div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
							     <?php echo $message; ?>
							     <p><a href="google_link.php" class="btn btn-success">Go Back</a></p>
							</div>
						</div>
					</div>
					<!-- /block -->
				</div>
				<!-- /validation -->


			</div>
		</div>
		<hr>
		<footer>
			<p>&copy; Freesale VietNam</p>
		</footer>
	</div>
	<!--/.fluid-container-->
	<link href="../vendors/datepicker.css" rel="stylesheet" media="screen">
	<link href="../vendors/uniform.default.css" rel="stylesheet"
		media="screen">
	<link href="../vendors/chosen.min.css" rel="stylesheet" media="screen">

	<link href="../vendors/wysiwyg/bootstrap-wysihtml5.css"
		rel="stylesheet" media="screen">

	<script src="../vendors/jquery-1.9.1.js"></script>
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	<script src="../vendors/jquery.uniform.min.js"></script>
	<script src="../vendors/chosen.jquery.min.js"></script>
	<script src="../vendors/bootstrap-datepicker.js"></script>

	<script src="../vendors/wysiwyg/wysihtml5-0.3.0.js"></script>
	<script src="../vendors/wysiwyg/bootstrap-wysihtml5.js"></script>

	<script src="../vendors/wizard/jquery.bootstrap.wizard.min.js"></script>

	<script type="text/javascript"
		src="../vendors/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="../assets/form-validation.js"></script>

	<script src="../assets/scripts.js"></script>
	<script src="../js/jquery-ui.min.js"></script>
</body>

</html>