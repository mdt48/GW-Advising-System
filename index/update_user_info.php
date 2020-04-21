<?php 
    require_once('connectvars.php'); session_start(); $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // $id = intval($_POST['uid']);
    $type = $_POST['type'];
    // $grad_status;
    // $thesis;
    // $audited;
    // $program;
    $fname;
    $lname;
    $uid = $_POST['data'][1]['uid'];
    $uname = $_POST['data'][1]['uname'];
    $address = $_POST['data'][1]['add'];
    $email = $_POST['data'][1]['email'];
    $id = $_POST['data'][1]['uid'];
    
    $add = $_POST['data'][1]['add'];
    if (strcmp($type, "masters") == 0 || strcmp($type, "phd") == 0) {
        
        $fname = $_POST['data'][1]['fname'];
        $lname = $_POST['data'][1]['lname'];

        $query = "update student 
            set 
            username = '$uname',
            fname = '$fname',
            lname = '$lname',
            email = '$email',
            address = '$address'
            where uid = '$uid'";
        print($query);
        $dbc->query($query);
    } else {
        $title = $_POST['data'][1]['title'];
        $fname = $_POST['data'][1]['fname'];
        $lname = $_POST['data'][1]['lname'];

        $query = "update staff 
            set 
            username = '$uname',
            sfname = '$fname',
            slname = '$lname',
            title = '$title', 
            email = '$email',
            address = '$address'
            where uid = '$uid'";
        print($query);
        $dbc->query($query);
    }

?>