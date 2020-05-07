<?php 
    require_once('connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $id = intval($_POST['uid']);
    $type = $_POST['type'];
    $query;
    if (strcmp($type, "t") == 0){
        $query = "select * from transcript where uid = '$id'";
        
        $result = $dbc->query($query);
        $results = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $user_id =$row["uid"];
            $course = $row["cid"];
            $grade = $row["grade"];
            $results[] = array("uid" => $user_id, "course" => $course, "grade" => $grade);
            
        }
        echo json_encode($results);
    } else if (strcmp($type, "f") == 0) {
        $query = "select * from form where uid = '$id'";
        $result = $dbc->query($query);
        $results = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $cid =$row["cid"];
            $dep = $row["department"];
            $results[] = array("cid" => $cid, "dep" => $dep);
        }
        echo json_encode($results);
    } else if (strcmp($type, "f1") == 0) {
        $query = "update student set grad_status = 'f1' where uid = '$id'";
        $dbc->query($query);
    }else if (strcmp($type, "f12") == 0) {
        $query = "delete from form where uid = '$id'";
        $dbc->query($query);
    } 
    else if (strcmp($type, "approve") == 0) {
        $query = "update student set thesis = true where uid = '$id'";
        print($query);
        $dbc->query($query);
    } else if (strcmp($type, "disaprove") == 0) {
        $query = "update student set thesis = false where uid = '$id'";
        $dbc->query($query);
    }else if (strcmp($type, "grad") == 0){
        $year = date("Y");
        $query = "update student set grad_status = 'alumni',  grad_year = '$year' where uid = '$id'";
        $dbc->query($query);
        
    } else {
        echo("failed");
    }
    
 
    
    //echo json_encode($results);


?>