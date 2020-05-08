<?php 
    require_once('connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $id = intval($_POST['uid']);
    $thesis = $_POST['thesis'];

    $q = "insert into thesis values ('$id', '$thesis')";
    $up = "update student set thesis = 0 where uid = '$id'";
    echo $q;
    $res = $dbc->query($q);
    if (!$dbc->query($q)){
        $q = "update thesis set th = '$thesis' where uid ='$id'";
        echo $q;
        $dbc->query($q);
    }
    $dbc->query($up);
?>