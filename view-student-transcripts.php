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
	  	  $takes_query = mysqli_query($dbc, "SELECT * FROM transcript WHERE uid='$u_id';");
	  	  echo('</script> <!-- F1 --> <table class="table" id="tab"><thead><tr><th scope="col">Course #</th> <th scope="col">Course ID</th><th scope="col">Grade</tr></thead><tbody>');
	      //print out classes
	      if ($takes_query != false) {
	      	echo "<h2>Transcript for ".$student_result['fname']." ".$student_result['lname'].":</h2>";
	      	echo "id: ".$u_id;
	        //print out table
	        $count = 1;
			  $gpa_sum = 0.0;
			  $credit_sum = 0.0;
				while($row = mysqli_fetch_array($takes_query)){
					$cid = $row['cid'];
					$dept = $row['subject'];
					$grade = $row['grade'];

					$query = "SELECT credit FROM course WHERE department='$dept' AND cid='$cid';";
					$credit_res = mysqli_query($dbc, $query);
					$credit_row = mysqli_fetch_array($credit_res);
					$credit = $credit_row['credit'];

					if(strcmp($grade,"IP")==0){	//do not count incomplete classes
						continue;
					}

					$credit_sum += $credit;

					if(strcmp($grade,"A")==0){
							$gpa_sum += ($credit * 4);
			
					}else if(strcmp($grade,"A-")==0){
							$gpa_sum += ($credit * 3.7);
					}else if(strcmp($grade,"B+")==0){
							$gpa_sum += ($credit * 3.3);
					}else if(strcmp($grade,"B")==0){
							$gpa_sum += ($credit * 3);
					}else if(strcmp($grade,"B-")==0){
							$gpa_sum += ($credit * 2.7);
					}else if(strcmp($grade,"C+")==0){
							$gpa_sum += ($credit * 2.3);
					}else if(strcmp($grade,"C")==0){
							$gpa_sum += ($credit * 2);
					}else if(strcmp($grade,"F")==0){
							//add zero
					}else{
						//invalid grade
					}

					echo "	
						<tr>
							<th scope=row>$count</th>
							<td>$dept $cid</td>
							<td>$grade</td>
						</tr>
					";
					$count++;
				}
				if($credit_sum!=0){
					$gpa = round(($gpa_sum)/($credit_sum),2);
				}else{
					$gpa =0;
				}
	      } else {
	        echo "ERROR: No transcript located for that student!<br/><br/>";
	      }
	  	} else {
	  		echo "Student not found in database!<br/><br/>";
	  	}
	}
	echo("</tbody>
	  </table>");
	if (isset($gpa)) {
		echo('<h1><span class="badge badge-primary">Total GPA: '.$gpa.'</span></h1>');
	}
  ?>
  <br></br><a href="index.php"><p style="text-align:center">Home</p></a>
</body>  