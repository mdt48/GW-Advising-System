<?php
/* end session */
  require_once('connectvars.php');

  session_start();

  //open database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // If the user is logged in, delete the session vars to log them out
  if (isset($_SESSION['username'])) {
    $_SESSION = array();
  }

  // Redirect to the login page
  $home_url = 'http://' . $_SERVER["HTTP_HOST"] .
    dirname($_SERVER["PHP_SELF"]) . '/login.php';
    header('Location: ' . $home_url);
?>
