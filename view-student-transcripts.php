<?php

  //start the session
  require_once('connectvars.php');

  session_start();

  //open database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  echo '<link rel="stylesheet" type="text/css" href="style.css">';
  echo '<div id = "top"><h1>Student transcripts</h1></div>';

?>

<head>
  <title>Transcripts</title>
</head>

<body>
  <form method="post">
    <input type="text" name="input_id" placeholder="Enter student id">
    <input type="text" name="input_fname" placeholder="Enter student first name">
    <input type="text" name="input_lname" placeholder="Enter student last name">
    <input type="text" name="input_uname" placeholder="Enter student username">
    <input name="Submit" type="submit">
  </form>
  <?php 
  	if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
	  	//first chek if student is in the database
	    $u_id = $_POST['input_id'];
	    $fname = $_POST['input_fname'];
	    $lname = $_POST['input_lname'];
	    $uname = $_POST['input_uname'];
	  	$student_query = mysqli_query($dbc, "SELECT * FROM student a JOIN person b ON a.u_id = b.u_id WHERE a.u_id = '$u_id' OR (b.fname = '$fname' AND b.lname = '$lname') OR b.username = '$uname';");
	  	//if yes, search for their transcript
	  	if ($student_query != false && mysqli_num_rows($student_query) != 0) {
	  	  $student_result = mysqli_fetch_array($student_query);	
	  	  $u_id = $student_result['u_id'];
	  	  //use id to get that student's transcript
	  	  $takes_query = mysqli_query($dbc, "SELECT * FROM takes a JOIN course b ON a.c_id = b.c_id WHERE a.u_id = '$u_id';");
	      //print out classes
	      if ($takes_query != false) {
	      	echo "<h2>Transcript for ".$student_result['fname']." ".$student_result['lname'].":</h2>";
	      	echo "id: ".$u_id;
	        //print out table
	        echo "<table>";
	        echo "<tr><td><b>Class name</b></td><td><b>Department</b></td><td><b>Grade</b></td></tr>";        
	        while ($takes_result = mysqli_fetch_array($takes_query)) {
	          echo "<tr>";
	          echo "<td>".$takes_result['name']."</td>";
	          echo "<td>".$takes_result['dept']."</td>";
	          echo "<td>".$takes_result['grade']."</td>";
	          echo "</tr>";
	        }
	        echo "</table>";
	      } else {
	        echo "ERROR: No transcript located for that student!<br/><br/>";
	      }
	  	} else {
	  		echo "Student not found in database!<br/><br/>";
	  	}
	}
  ?>
  <a href="homepage.php">Home</a>
</body>  