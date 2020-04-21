<?php

    //start the session
    require_once('connectvars.php');

    session_start();

    //open database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    //open file to clear all tables
    $file = '/home/ead/sp20DBp1-not_sam_gassman/public_html/not_sam_gassman/Deliverables/delete.sql';

    //seperate file by semicolons and run every line in database
    if ($fp = file_get_contents($file)) {
        $var_array = explode(';', $fp);
        foreach ($var_array as $value) {
            mysqli_query($dbc, $value);
        }
    }

    //open file to add starting information to tables
    $file = '/home/ead/sp20DBp1-not_sam_gassman/public_html/not_sam_gassman/Deliverables/inserts.sql';

    //seperate file by semicolons and run every line in database
    if ($fp = file_get_contents($file)) {
        $var_array = explode(';', $fp);
        foreach ($var_array as $value) {
            mysqli_query($dbc, $value);
        }
    }

    header("Location: logout.php");

?>