<?php
    if(isset($_POST['id']) || isset($_POST['date'])) {
        include 'class/connect_worktime.php';
        $data   =   array(
            'change'        =>      '1'
        );
        $where = array(
            array('user', $_POST['user'], 'AND'),
            array('work_date', $_POST['date'], null)  
        );
        $affectRow = $dbWorktime->update($data, $where);
        if($affectRow != '') {
            echo 'success';
        } 
    }