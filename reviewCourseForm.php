<?php

  //start the session
  require_once('connectvars.php');

  session_start();

  //open database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

?>

<head>
  <title>Review Course Forms</title>
</head>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel = "stylesheet" href="/css/heroic-features.css" >
  <link rel="stylesheet" type="text/css" href="style.css">    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

  
  <header class = "bg py-5 mb-5" style = "background-color: #033b59; height: 15em;">
    <div class = "container h-100">
        <div class = "row h-100 align-items-center">
            <div class = "col-lg-12">
                <h1 class = "display-4 text-center text-white mt-5 mb-2">Review Course Forms</h1></div>
        </div>
    </div>
  </header>
<body style = "text-align: center;">

<?php
	if (isset($_SESSION['uid']) && isset($_SESSION['type'])) {
		$uid = $_SESSION['uid'];
		$query = "SELECT * FROM people a JOIN student b ON a.uid = b.uid JOIN courseForm c ON a.uid = c.uid WHERE advisoruid = $uid;";
		$data = mysqli_query($dbc, $query);
		if (mysqli_num_rows($data) != 0) {
			while($row = mysqli_fetch_array($data)) {
				echo("<h4>".$row['fname']." ".$row['lname']."</h4>");
				$studentUid = $row['uid'];
				$courseFormQuery = "SELECT * FROM courseForm a JOIN schedule b ON a.cid1 = b.cid OR a.cid2 = b.cid OR a.cid3 = b.cid OR a.cid4 = b.cid OR a.cid5 = b.cid OR a.cid6 = b.cid WHERE a.uid = $studentUid;";
				$cfData = mysqli_query($dbc, $courseFormQuery);
				if (mysqli_num_rows($cfData) != 0) {
				  //print out table
		          echo('</script> <!-- F1 --> <table class="table" id="tab"><thead><tr><th scope="col">Course ID</th> <th scope="col">Department</th><th scope="col">Day</th><th scope="col">Start Time</th><th scope="col">End Time</th></tr></thead><tbody>');     
		          while ($row = mysqli_fetch_array($cfData)) {
		            echo "<tr>";
		            echo "<td>".$row['cid']."</td>";
		            echo "<td>".$row['department']."</td>";
		            echo "<td>".$row['day']."</td>";
		            echo "<td>".$row['start_time']."</td>";
		            echo "<td>".$row['end_time']."</td>";
		            echo "</tr>";
		          }
		          echo "</table>";
		          echo('<form method = "POST"><input type = "submit" name = "submit" value = "Approve"/></form>');
		          echo('<form method = "POST"><input type = "submit" name = "submit2" value = "Deny"/></form>');
		          if (isset($_POST['submit'])) {
		          	$courseFormQuery = "SELECT * FROM courseForm a JOIN schedule b ON a.cid1 = b.cid OR a.cid2 = b.cid OR a.cid3 = b.cid OR a.cid4 = b.cid OR a.cid5 = b.cid OR a.cid6 = b.cid WHERE a.uid = $studentUid;";
					$cfData = mysqli_query($dbc, $courseFormQuery);
		          	echo('worked');
		          	while ($row = mysqli_fetch_array($cfData)) {
		          		echo('entered');
			            $thisCid = $row['cid'];
			            $thisDept = $row['department'];
			            $thisYear = $row['year'];
			            $thisSemester = $row['semester'];
			            $thisSection = $row['section'];
			            $insertQuery = "INSERT INTO takes VALUES($thisCid, '$thisDept', $thisYear, $thisSection, '$thisSemester', $studentUid, 'IP');";
			            echo($insertQuery);
			            mysqli_query($dbc, $insertQuery);
		          	}
		          	$deleteQuery = "DELETE FROM courseForm WHERE uid = $studentUid;";
		          	mysqli_query($dbc, $deleteQuery);
		          	header('Location: '.$_SERVER['REQUEST_URI']);
		          } 
		          if (isset($_POST['submit2'])) {
		          	$deleteQuery = "DELETE FROM courseForm WHERE uid = $studentUid;";
		          	mysqli_query($dbc, $deleteQuery);
		          	header('Location: '.$_SERVER['REQUEST_URI']);
		          }
				}
			}
		} else {
			echo("No students have pending course forms!");
		}
	} 
	echo '<br/><br/><a href="index.php">Home</a>';
?>