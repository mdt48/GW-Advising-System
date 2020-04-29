<?php

require_once('connectvars.php');
session_start();

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);



$user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
$user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));


if (!empty($user_username) && !empty($user_password)) {
  // TODO: Look up the username and password in the database
  $query = "SELECT * FROM people WHERE username='$user_username' AND password = '$user_password'" ; 
  $data = mysqli_query($dbc, $query);
  
  // If The log-in is OK 
  if (mysqli_num_rows($data) == 1) {
	
    $row = mysqli_fetch_assoc($data);
    $uid = $_SESSION['uid'] = $row['uid'];
    $_SESSION['username'] = $row['username'];
    //$_SESSION['program'] = $row['program'];

    $query = "SELECT * FROM student WHERE uid = '$uid'" ;
    $data = mysqli_query($dbc, $query);
    
    // if student
    if (mysqli_num_rows($data) == 1) {
      $row = mysqli_fetch_assoc($data); 
      $_SESSION['program'] = $row['program'];
      if (strcmp($row['grad_status'], "alumni") == 0) {
        $_SESSION['alumn'] = "true";
        print_r($_SESSION);
      } 
      echo "<script>location.href='index.php'</script>";
    } else {
      $query = "SELECT type FROM staff WHERE uid = '$uid'" ;
      $data = mysqli_query($dbc, $query);
      $row = mysqli_fetch_assoc($data); 
      $_SESSION['type'] = $row['type'];
      echo "<script>location.href='index.php'</script>";
    }
  } else {
	  // The username/password are incorrect so set an error message
	  echo "<script>alert('wrong username/password, please check again'); location.href='login.html'</script>";
  }
}



?>