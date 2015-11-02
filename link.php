<?php
ob_start();
session_start();
require_once 'function.php';
$today          = date("d/m/Y");
if(isset($_SESSION['date_search']) && trim($_SESSION['date_search']) != '') {
    $today = $_SESSION['date_search'];
}
$messageUrl     = '';
// Link to get
$maintenance_url="https://docs.google.com/spreadsheets/d/1VRE9AtN-csRxYwtuhWBUdt7UQlGoKMs3Bvdcne0BfWg/pub?gid=785801277&single=true&output=csv";
$newton_url="https://docs.google.com/spreadsheets/d/18OztKU73I3zQHWWlYwYgalciFCWD_IowwsHd-YabkBE/pub?gid=785801277&single=true&output=csv";
if(isset($_SESSION['maintenance_link']) && trim($_SESSION['maintenance_link']) != '' || isset($_SESSION['newton_link']) && trim($_SESSION['newton_link']) != '') {
    $maintenance_url = $_SESSION['maintenance_link'];
    $newton_url      = $_SESSION['newton_link'];
}
if(isset($_SESSION['maintenance_link'])&&trim($_SESSION['maintenance_link']) == '' && $maintenance_url == '') $messageUrl = '<div class="alert alert-error">Empty Maintenance URL !!! Please input the link.</div>';
if(isset($_SESSION['newton_link'])&&trim($_SESSION['newton_link']) == '' && $newton_url == '') $messageUrl .= '<div class="alert alert-error">Empty Newton URL !!! Please input the link.</div>';

// Maitenance Data

$maintenance_data   =       getData($maintenance_url);
if(empty($maintenance_data)) { $messageUrl .= '<div class="alert alert-error">Wrong Maintenance URL !!! Please input the correct link.</div>'; } 

// Newton Data
$newton_data        =       getData($newton_url);
if(empty($maintenance_data)) { $messageUrl .= '<div class="alert alert-error">Wrong Newton URL !!! Please input the correct link.</div>'; }

// Get Member
$member_data        =       getData('./csv/member.csv');
$memberArray        =       array();
foreach($member_data as $key => $value) {
    if(trim($value[2]) == '') {
        continue;
    }
    $memberArray[$key][]  =       trim($value[1]);
    $memberArray[$key][]  =       trim($value[2]);
    $memberArray[$key][]  =       trim($value[0]);
    $memberArray[$key][]  =       trim($value[3]);
}
if(isset($_GET['page_submit']) && $_GET['page_submit'] == 'record') {
    header("location: record.php?user_name={$_GET['user_name']}&&date_search={$_GET['date_search']}&&type={$_GET['type']}");
}