<?php // start session, connect to database
    require_once('connectvars.php'); session_start(); $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $type;
    $id = intval($_POST['uid']);
    $type = $_POST['type'];

    
    $query;
    // echo(strcmp($type, "masters"));
    //echo(strcmp($type, "phd"));
    if (strcmp($type, "masters") == 0 || strcmp($type, "phd") == 0) {
        //echo("h");
        $query = "select uid, username, fname, lname, address, email from student where uid = '$id'";
        
        $result = $dbc->query($query);
        $results = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $uid = $row["uid"];
            $uname = $row["username"];
            $fname = $row["fname"];
            $lname = $row["lname"];
            $email = $row["email"];
            // $grad_status = $row["grad_status"];
            // $thesis = $row["thesis"];
            // $audited = $row["audited"];
            //$dep = $row["department"];
            $add = $row["address"];
           // $program = $row["program"];

            $results[] = array("uid" => $uid, "uname" => $uname, "fname" => $fname,
            "lname" => $lname, "email" => $email, "add" => $add);
            
            echo json_encode($results);
        }
    } else {
        $query = "select uid, username, sfname, slname, email, address from staff where uid = '$id'";
        //echo("hello");
        $result = $dbc->query($query);
        $results = array();
        
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $uid = $row["uid"];
            $uname = $row["username"];
            $fname = $row["sfname"];
            $lname = $row["slname"];
            $email = $row["email"];
            //$dep = $row["department"];
            $add = $row["address"];
            
            $results[] = array("uid" => $uid, "uname" => $uname, "fname" => $fname,
            "lname" => $lname, "email" => $email, "add" => $add);
            echo json_encode($results);
        }
    }  
?>