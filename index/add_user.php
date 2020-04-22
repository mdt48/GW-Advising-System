<?php 
    require_once('connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $uid = $_POST['uid'];
    $username = $_POST['uname'];
    $pass = $_POST['password'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $acc = $_POST['accT'];
    $address = $_POST['add'];
    $email = $_POST['em'];
    $dep = $_POST['dep'];

    $uid_query = "select max(uid) as max_uid from (select uid from staff union all select uid from student) as subQuery";
    $result = mysqli_query($dbc, $uid_query);
    $row = $row = mysqli_fetch_assoc($result);

    


    if (strcmp($acc, "gs")==0 || strcmp($acc, "fa")==0 || strcmp($acc, "admin")==0 ) {
        $query = "insert into staff (`uid`, `username`, `password`, `sfname`, `slname`, `title`, `department`, `email`, `address`) values ('$uid', '$username', '$pass', '$fname', '$lname', '$acc', '$dep', '$email', '$address')";
        
        if ($dbc->query($query)){
            echo json_encode(array('success'));
            
        }
    } else {
        $fa_query = "select uid from staff where title = 'fa'";
        $result2 = mysqli_query($dbc, $fa_query);
        $row2 = mysqli_fetch_assoc($result2);
        print_r($row2);
        $fa_uid = intval($row2['uid']);
        $query = "insert into student (`uid`, `username`, `password`, `fname`, `lname`, `program`, `advisoruid`, `department`, `address`, `email` , `grad_status`, `audited`, `thesis`) values ('$uid', '$username', '$pass', '$fname', '$lname', '$acc', '$fa_uid','$dep', '$address', '$email', null, false, false)";
        print($query);
        if ($dbc->query($query)){
            echo json_encode(array('success'));
        }
    }
?>