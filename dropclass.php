<?php

  //start the session
  require_once('connectvars.php');
  session_start();

  //open database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Use GET variables to delete instance of current students ID and the course ID

  if (isset($_GET['uid'])) {
      $uid = mysqli_real_escape_string($dbc, trim($_GET['uid']));
  }
  if (isset($_GET['cid'])) {
      $cid = mysqli_real_escape_string($dbc, trim($_GET['cid']));
  }
  if (isset($_GET['semester'])) {
      $semester = mysqli_real_escape_string($dbc, trim($_GET['semester']));
  }
  if (isset($_GET['year'])) {
      $year = mysqli_real_escape_string($dbc, trim($_GET['year']));
  }
  if (isset($_GET['dept'])) {
      $dept = mysqli_real_escape_string($dbc, trim($_GET['dept']));
  }
  if (isset($_GET['section'])) {
      $section = mysqli_real_escape_string($dbc, trim($_GET['section']));
  }

  $query = "DELETE FROM takes WHERE u_id='$uid' and c_id='$cid' and dept='$dept' and section='$section' and year='$year' and semester='$semester'";

  // Execute query
  mysqli_query($dbc, $query);

  // Redirect back to the users homepage
  $home_url = 'http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/homepage.php';
  header('Location: ' . $home_url);

  //echo $uid;
  //echo $cid;
  //echo $semester;
  //echo $year;
  //echo $dept;
  //echo $section;

?>
