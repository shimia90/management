<?php
require_once '../class/connect_work.php';
require_once '../class/connect_user.php';
require_once '../class/connect_project.php';
$queryWork      =   "SELECT * FROM `work` WHERE `project_type` = '{$_GET['id']}' ORDER BY `work_date` ASC";
$arrayWork      =   $databaseWork->listRecord($databaseWork->query($queryWork));
/* echo '<pre>';
print_r($arrayWork);
echo '</pre>';

echo '<pre>';
print_r($arrayUser);
echo '</pre>'; */
//echo json_encode($arrayWork);