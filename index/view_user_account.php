<?php // start session, connect to database
    require_once('connectvars.php'); session_start(); $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $type;
    $id = intval($_POST['uid']);
    $type = $_POST['type'];


    if(isset($_SESSION['alumn']) || isset($_SESSION['program'])){
		$style = "style='display:none;'";
    } else {
		$title = $_SESSION['type'];
		$home_link = "./staff_home.php";
    }
    
    $query;
    // echo(strcmp($type, "masters"));
    //echo(strcmp($type, "phd"));
    //if (isset($_SESSION['alumn']) || isset($_SESSION['program'])) {
        $query = "select uid, password, username, fname, lname, address, email from people where uid = '$id'";
        $result = $dbc->query($query);
        $results = array();
        while ($row = $result->fetch_object()) {
            $uid = $row->uid;
            $pass = $row->password;
            $uname = $row->username;
            $fname = $row->fname;
            $lname = $row->lname;
            $email = $row->email;
            $add = $row->address;

            $results[] = array("uid" => $uid, "pass" => $pass, "uname" => $uname, "fname" => $fname,
            "lname" => $lname, "email" => $email, "add" => $add);
            
            echo json_encode($results);
        }
    //} 
    // else {
    //     $query = "select uid, username, sfname, slname, email, address from staff where uid = '$id'";
    //     //echo("hello");
    //     $result = $dbc->query($query);
    //     $results = array();
        
    //     while ($row = $result->fetch_object()) {
    //         $uid = $row->uid;
    //         $uname = $row->username;
    //         $fname = $row->fname;
    //         $lname = $row->lname;
    //         $email = $row->email;
    //         $add = $row->address;

    //         $results[] = array("uid" => $uid, "uname" => $uname, "fname" => $fname,
    //         "lname" => $lname, "email" => $email, "add" => $add);
            
    //         echo json_encode($results);
    //     }
    // }  
?>