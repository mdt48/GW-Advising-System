<?php

require_once('connectvars.php');

session_start();

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>
<head>
  <title>Course Form</title>
</head>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel = "stylesheet" href="/css/heroic-features.css" >
  <link rel="stylesheet" type="text/css" href="style.css">    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

  
  <header class = "bg py-5 mb-5" style = "background-color: #033b59; height: 15em;">
    <div class = "container h-100">
        <div class = "row h-100 align-items-center">
            <div class = "col-lg-12">
                <h1 class = "display-4 text-center text-white mt-5 mb-2">Your Course Form</h1></div>
        </div>
    </div>
  </header>
  <body style = "text-align: center;">
<?php
$user = $_SESSION["uid"];
if (isset($_POST["submit"])) {
  if (isset($_POST["cid1"]) && isset($_POST["dept1"]) && $_POST["cid1"] != '' && $_POST["dept1"] != '') {
    $cid1 = $_POST["cid1"]; $dept1 = $_POST["dept1"];
  } else {
    $cid1 = "NULL"; $dept1 = "NULL";
  }
  if (isset($_POST["cid2"]) && isset($_POST["dept2"]) && $_POST["cid2"] != '' && $_POST["dept2"] != '') {
    $cid2 = $_POST["cid2"]; $dept2 = $_POST["dept2"];
  } else {
    $cid2 = "NULL"; $dept2 = "NULL";
  }
  if (isset($_POST["cid3"]) && isset($_POST["dept3"]) && $_POST["cid3"] != '' && $_POST["dept3"] != '') {
    $cid3 = $_POST["cid3"]; $dept3 = $_POST["dept3"];
  } else {
    $cid3 = "NULL"; $dept3 = "NULL";
  }
  if (isset($_POST["cid4"]) && isset($_POST["dept4"]) && $_POST["cid4"] != '' && $_POST["dept4"] != '') {
    $cid4 = $_POST["cid4"]; $dept4 = $_POST["dept4"];
  } else {
    $cid4 = "NULL"; $dept4 = "NULL";
  }
  if (isset($_POST["cid5"]) && isset($_POST["dept5"]) && $_POST["cid5"] != '' && $_POST["dept5"] != '') {
    $cid5 = $_POST["cid5"]; $dept5 = $_POST["dept5"];
  } else {
    $cid5 = "NULL"; $dept5 = "NULL";
  }
  if (isset($_POST["cid6"]) && isset($_POST["dept6"]) && $_POST["cid6"] != '' && $_POST["dept6"] != '') {
    $cid6 = $_POST["cid6"]; $dept6 = $_POST["dept6"];
  } else {
    $cid6 = "NULL"; $dept6 = "NULL";
  }
  //insert into database
  //echo(isset($_POST["submit"]));
  $insertquery = "INSERT INTO courseForm VALUES ($user, $cid1, '$dept1', $cid2, '$dept2', $cid3, '$dept3', $cid4, '$dept4', $cid5, '$dept5', $cid6, '$dept6');";
  $data = mysqli_query($dbc, $insertquery);
  if (!$data) {
  	echo 'ERROR: Your course form was not successfully submitted. Please check your list of courses and verify the course ID\'s and Department codes.';
  	echo '<br/><br/><a href="register.php">Back</a>';
  } else {
  	echo 'Course form successfully submitted.';
  	echo '<br/><br/><a href="index.php">Home</a>';
  }
}
?>
</body>