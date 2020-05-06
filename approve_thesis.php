<?php 
    require_once('connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $id = intval($_POST['uid']);

        $q = "update student set thesis = 1 where uid = '$id'";
        $dbc->query($q);
        echo("Success");
    
?>