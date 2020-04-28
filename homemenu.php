<?php

  require_once('connectvars.php');

  if (!isset($_SESSION)) {
    session_start();
  }

  echo "Welcome, ";
  echo ($_SESSION['username']);

  //open database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Generate the menu depending on the user
echo '<hr />';

  /*if (!$_SESSION['whoareyou']) {
    $home_url = 'http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/login.php';
    header('Location: ' . $home_url);
  }*/

  // The user is a graduate student
  if ($_SESSION['whoareyou'] == "gradstudent") {
	  echo '<a href="register.php">Register</a>    ';
	  echo '<a href="view-classes.php">View Classes</a>    ';
	  echo '<a href="view-transcript.php">View Transcript</a>    ';
	  echo '<a href="logout.php">Log Out</a>    ';
    echo '<a href="reset.php" id = "reset">Reset Database</a>    ';
  }
  // The user is a GS
  else if ($_SESSION['whoareyou'] == "GS") {
	  echo '<a href="grades.php">Assign Grades</a>    ';
	  echo '<a href="view-student-transcripts.php">View Transcripts</a>    ';
	  echo '<a href="view-classes.php">View Classes</a>    ';
	  echo '<a href="logout.php">Log Out</a>    ';
    echo '<a href="reset.php" id = "reset">Reset Database</a>    ';
  
  }
  // The user is a faculty
  else if ($_SESSION['whoareyou'] == "faculty") {
	  echo '<a href="grades.php">Assign Grades</a>    ';
          echo '<a href="view-student-transcripts.php">View Transcripts</a>    ';
	  echo '<a href="logout.php">Log Out</a>    ';
    echo '<a href="reset.php" id = "reset">Reset Database</a>    ';
  
  }
  // The user is an admin
  else if ($_SESSION['whoareyou'] == "admin") {
    echo '<a href="add-user.php">Add User</a>    ';
	  echo '<a href="grades.php">Assign Grades</a>    ';
          echo '<a href="view-student-transcripts.php">View Transcripts</a>    ';
          echo '<a href="view-classes.php">View Classes</a>    ';
          echo '<a href="logout.php">Log Out</a>    ';
          echo '<a href="reset.php" id = "reset">Reset Database</a>    ';
    
  }
  echo '<hr />';
?>
