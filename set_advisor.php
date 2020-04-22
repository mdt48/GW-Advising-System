<?php 
    require_once('connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $s_uid = intval($_POST['s_uid']);
    $a_uid = intval($_POST['a_uid']);

    $query = "update student set advisoruid = '$a_uid' where uid = '$s_uid'";
    echo($query);
    $dbc->query($query);
?>
