<?php
    session_start(); 
    session_destroy();
    
    $home_url = 'landingPage.php';
    header('Location: ' . $home_url);
  
    $mysqli->close();
?>
