<?php 
    require_once('connectvars.php'); session_start(); $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // $id = intval($_POST['uid']);
    $type = $_POST['type'];
    $fname;
    $lname;
    $uid = $_POST['data'][1]['uid'];
    $uname = $_POST['data'][1]['uname'];
    $address = $_POST['data'][1]['add'];
    $email = $_POST['data'][1]['email'];
    $id = $_POST['data'][1]['uid'];
    $pass = $_POST['data'][1]['pass'];
    
    $add = $_POST['data'][1]['add'];


    $title = $_POST['data'][1]['title'];
    $fname = $_POST['data'][1]['fname'];
    $lname = $_POST['data'][1]['lname'];

    $query = "update people 
        set 
        username = '$uname',
        password = '$pass',
        fname = '$fname',
        lname = '$lname',
        email = '$email',
        address = '$address'
        where uid = '$uid'";
    $dbc->query($query);
    

?>