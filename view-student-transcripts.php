<?php

  //start the session
  require_once('connectvars.php');

  session_start();

  //open database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel = "stylesheet" href="/css/heroic-features.css" >
  <link rel="stylesheet" type="text/css" href="style.css">    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

  
  <header class = "bg py-5 mb-5" style = "background-color: #033b59; height: 15em;">
    <div class = "container h-100">
        <div class = "row h-100 align-items-center">
            <div class = "col-lg-12">
                <h1 class = "display-4 text-center text-white mt-5 mb-2">Student Transcripts</h1></div>
        </div>
    </div>
  </header>

<head>
  <title>Transcripts</title>
</head>

<body style = "text-align: center;">
  <form method="post" style = "display: inline-block;">
    <input type="text" name="input_id" placeholder="Enter student id">
    <div></div></br>
    <input type="text" name="input_fname" placeholder="Enter student first name">
    <div></div></br>
    <input type="text" name="input_lname" placeholder="Enter student last name">
    <div></div></br>
    <input type="text" name="input_uname" placeholder="Enter student username">
    <div></div></br>
    <input name="Submit" type="submit">
  </form>
  <?php 
  	if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
	  	//first chek if student is in the database
	    $u_id = $_POST['input_id'];
	    $fname = $_POST['input_fname'];
	    $lname = $_POST['input_lname'];
	    $uname = $_POST['input_uname'];
	  	$student_query = mysqli_query($dbc, "SELECT * FROM student a JOIN people b ON a.uid = b.uid WHERE a.uid = '$u_id' OR (b.fname = '$fname' AND b.lname = '$lname') OR b.username = '$uname';");
	  	//if yes, search for their transcript
	  	if ($student_query != false && mysqli_num_rows($student_query) != 0) {
	  	  $student_result = mysqli_fetch_array($student_query);	
	  	  $u_id = $student_result['uid'];
	  	  //use id to get that student's transcript
	  	  $takes_query = mysqli_query($dbc, "SELECT * FROM transcript a JOIN course b ON a.cid = b.cid WHERE a.uid = '$u_id';");
	      //print out classes
	      if ($takes_query != false) {
	      	echo "<h2>Transcript for ".$student_result['fname']." ".$student_result['lname'].":</h2>";
	      	echo "id: ".$u_id;
	        //print out table
	        echo "<table style = 'margin-left:auto;margin-right:auto;'>";
	        echo "<tr><td><b>Class name</b></td><td><b>Department</b></td><td><b>Grade</b></td></tr>";        
	        while ($takes_result = mysqli_fetch_array($takes_query)) {
	          echo "<tr>";
	          echo "<td>".$takes_result['cid']."</td>";
	          echo "<td>".$takes_result['subject']."</td>";
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
  <br></br><a href="index.php"><p style="text-align:center">Home</p></a>
</body>  