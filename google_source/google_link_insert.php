<?php 
    ob_start();
    if(!isset($_GET['type']) || isset($_GET['type']) && !isset($_GET['idLink']) && $_GET['type'] == 'edit') {
        header("location: google_link.php");
    } else {
        require_once '../class/Database.class.php';
        $paramsProject		= array(
            'server' 	=> 'localhost',
            'username'	=> 'root',
            'password'	=> '',
            'database'	=> 'management',
            'table'		=> 'project_type',
        );
        
        $paramsSource		= array(
            'server' 	=> 'localhost',
            'username'	=> 'root',
            'password'	=> '',
            'database'	=> 'management',
            'table'		=> 'source_link',
        );
        
        $databaseProject        =   new Database($paramsProject);
        $databaseSource        =   new Database($paramsSource);
         
        $queryProject           =   'SELECT * FROM project_type';
        $arrayProject           =   $databaseProject->listRecord($databaseProject->query($queryProject));
        $message = '';
        $titleType  =   ($_GET['type'] == "insert") ? 'Insert' : (($_GET['type'] == 'edit') ? 'Edit' : '');
        if(isset($_POST['form_insert'])&&isset($_POST['google_insert']) && trim($_POST['google_link']) != '' && trim($_POST['google_date']) != '' && $_POST['google_project'] != '') {
        
        
            $arraySource    =   array();
            $arrayDate      =   explode(' ', $_POST['google_date']);
            $month          =   $arrayDate[0];
            $year           =   $arrayDate[1];
            foreach($_POST as $key => $value) {
                $arraySource['link']            =   $_POST['google_link'];
                $arraySource['link_month']      =   $month;
                $arraySource['link_year']       =   $year;
                $arraySource['project_link']    =   $_POST['google_project'];
            }
            $querySource    =   "SELECT * FROM source_link WHERE `link_month` = '{$month}' AND `project_link` = {$_POST['google_project']}";
            if($databaseSource->checkRow($querySource) == true) {
                $arrayWhere = array(
                    array('link_month', $month, 'AND'),
                    array('project_link', $_POST['google_project'], null),
                );
                $databaseSource->update($arraySource, $arrayWhere);
                if($databaseSource->affectedRows() > 0 ) {
                    $message = '<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								Update successful!
							</div>';
                }
            } else {
                $databaseSource->insert($arraySource, 'single');
                if($databaseSource->affectedRows() > 0 ) {
                    $message = '<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								Insert successful!
							</div>';
                }
            }
        }
        
        if(isset($_GET['type']) && $_GET['type'] == 'edit') {
            $queryEdit  =   "SELECT * FROM source_link WHERE `id` = {$_GET['idLink']}";
            $arrayEdit  =   $databaseSource->listRecord($databaseSource->query($queryEdit));
        }
        
        if(isset($_POST['form_edit'])&& trim($_POST['form_edit']) != '') {
            $arraySource    =   array();
            $arrayDate      =   explode(' ', $_POST['google_date']);
            $month          =   $arrayDate[0];
            $year           =   $arrayDate[1];
            foreach($_POST as $key => $value) {
                $arraySource['link']            =   $_POST['google_link'];
                $arraySource['link_month']      =   $month;
                $arraySource['link_year']       =   $year;
                $arraySource['project_link']    =   $_POST['google_project'];
            }
            $arrayWhere = array(
                array('id', $_POST['form_edit'], null));
                
                $databaseSource->update($arraySource, $arrayWhere);
                if($databaseSource->affectedRows() > 0 ) {
                    $message = '<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								Update successful!
							</div>';
                }
        }
    }
?>
<!DOCTYPE html>
<html>
    
    <head>
        <title>Google Link <?php echo $titleType; ?></title>
        <!-- Bootstrap -->
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
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
                                <div class="muted pull-left">Google Link <?php echo $titleType; ?></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
					<!-- BEGIN FORM-->
					<form action="" id="form_sample_1" class="form-horizontal" method="post" name="google_link_form">
						<fieldset>
							<!-- <div class="alert alert-error hide">
								<button class="close" data-dismiss="alert"></button>
								You have some input errors. Please check below.
							</div> -->
							<?php echo $message;?>
  							<div class="control-group">
  								<label class="control-label">Name<span class="required">*</span></label>
  								<div class="controls">
  									<input type="text" name="google_link" data-required="1" class="span6 m-wrap" placeholder="Name" value="<?php if(isset($_POST['form_edit'])){ echo $_POST['google_link']; } else if($_GET['type'] == 'edit') { echo @$arrayEdit[0]['link']; } ?>" />
  								</div>
  							</div>
  							<div class="control-group">
  								<label class="control-label">Month<span class="required">*</span></label>
  								<div class="controls">
  									<input type="text" name="google_date" data-required="1" class="span6 m-wrap date-picker" placeholder="Date" value="<?php if(isset($_POST['form_edit'])) { echo $_POST['google_date']; } else if($_GET['type'] == 'edit') { echo @$arrayEdit[0]['link_month'] . ' ' . @$arrayEdit[0]['link_year']; } ?>" />
  								</div>
  							</div>
  							<div class="control-group">
  								<label class="control-label">Project Type<span class="required">*</span></label>
  								<div class="controls">
  									<select class="span6 m-wrap" name="google_project">
  										<option value="">Select...</option>
  										<?php for($i = 0; $i < count($arrayProject); $i++) { ?>
  										<?php 
  										    if($_GET['type'] == 'edit' && $arrayEdit[0]['project_link'] == $arrayProject[$i]['id'] || isset($_POST['google_project']) && $_POST['form_edit'] == $arrayProject[$i]['id']) {
  										        $selected = 'selected="selected"';   
  										    } else {
  										        $selected = '';   
  										    }
  										?>
  										<option value="<?php echo $arrayProject[$i]['id']; ?>" <?php echo $selected; ?>><?php echo $arrayProject[$i]['project_type']; ?></option>
  										<?php } ?>
  									</select>
  								</div>
  							</div>
  							<?php if($_GET['type'] == 'edit') : ?>
  							   <input type="hidden" name="form_edit" value="<?php echo $_GET['idLink']; ?>" />
  							<?php endif; ?>
  							<?php if($_GET['type'] == 'insert') : ?>
  							   <input type="hidden" name="form_insert" value="" />
  							<?php endif; ?>
  							<div class="form-actions">
  								<button type="submit" class="btn btn-primary" name="google_insert"><?php echo $titleType; ?></button>
  								<a class="btn" href="google_link_insert.php">Cancel</a>
  								<a class="btn btn-success" href="google_link.php">Go Back</a>
  							</div>
						</fieldset>
					</form>
					<!-- END FORM-->
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
        <link href="../vendors/uniform.default.css" rel="stylesheet" media="screen">
        <link href="../vendors/chosen.min.css" rel="stylesheet" media="screen">

        <link href="../vendors/wysiwyg/bootstrap-wysihtml5.css" rel="stylesheet" media="screen">

        <script src="../vendors/jquery-1.9.1.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendors/jquery.uniform.min.js"></script>
        <script src="../vendors/chosen.jquery.min.js"></script>
        <script src="../vendors/bootstrap-datepicker.js"></script>

        <script src="../vendors/wysiwyg/wysihtml5-0.3.0.js"></script>
        <script src="../vendors/wysiwyg/bootstrap-wysihtml5.js"></script>

        <script src="../vendors/wizard/jquery.bootstrap.wizard.min.js"></script>

	<script type="text/javascript" src="../vendors/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="../assets/form-validation.js"></script>
        
	<script src="../assets/scripts.js"></script>
	<script src="../js/jquery-ui.min.js"></script>
        <script>

	/* jQuery(document).ready(function() {   
	   FormValidation.init();
	}); */
	
	$(function() {
	    $('.date-picker').datepicker( {
	        changeMonth: true,
	        changeYear: true,
	        showButtonPanel: true,
	        dateFormat: 'm yy',
	        onClose: function(dateText, inst) { 
	            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
	            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
	            $(this).datepicker('setDate', new Date(year, month, 1));
	        }
	    });
	});
	
        $(function() {
            $(".datepicker").datepicker();
            $(".uniform_on").uniform();
            $(".chzn-select").chosen();
            $('.textarea').wysihtml5();

            $('#rootwizard').bootstrapWizard({onTabShow: function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index+1;
                var $percent = ($current/$total) * 100;
                $('#rootwizard').find('.bar').css({width:$percent+'%'});
                // If it's the last tab then hide the last button and show the finish instead
                if($current >= $total) {
                    $('#rootwizard').find('.pager .next').hide();
                    $('#rootwizard').find('.pager .finish').show();
                    $('#rootwizard').find('.pager .finish').removeClass('disabled');
                } else {
                    $('#rootwizard').find('.pager .next').show();
                    $('#rootwizard').find('.pager .finish').hide();
                }
            }});
            $('#rootwizard .finish').click(function() {
                alert('Finished!, Starting over!');
                $('#rootwizard').find("a[href*='tab1']").trigger('click');
            });
        });
        </script>
    </body>

</html>