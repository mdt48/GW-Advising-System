<?php

    //start the session
    require_once('connectvars.php');

    session_start();

    //open database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (isset($_GET["c_id"])) {
        $c_id = $_GET["c_id"];
    }

    if (isset($_GET["dept"])) {
        $dept = $_GET["dept"];
    }

    if (isset($_GET["semester"])) {
        $semester = $_GET["semester"];
    }

    if (isset($_GET["year"])) {
        $year = $_GET["year"];
    }

    if (isset($_GET["section"])) {
        $section = $_GET["section"];
    }

    if (isset($_GET["u_id"])) {
        $u_id = $_GET["u_id"];
    }

    if (isset($_GET["grade"])) {
        $newgrade = $_GET["grade"];
    }
    

    //grade was entered
    if (isset($_GET["grade"])) {
        $gradequery = "INSERT INTO transcript VALUES ('$u_id', '$dept', '$c_id', '$newgrade', '$year', '');";
        $gradedata = mysqli_query($dbc, $gradequery);
        $deletequery = "DELETE FROM takes WHERE uid = '$u_id' AND department = '$dept' AND cid = '$c_id' AND year = '$year';";
        $deletedata = mysqli_query($dbc, $deletequery);
    }

    $home_url = 'http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/grades.php';
    header('Location: ' . $home_url);


?>