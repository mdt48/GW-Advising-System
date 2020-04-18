<?php
  session_start();  

  if (isset($_SESSION['gwid']))  {
    $_SESSION = array();
    session_destroy();
  }
  
  $home_url = 'landingPage.php';
  header('Location: ' . $home_url);

  $mysqli->close();
 
?>