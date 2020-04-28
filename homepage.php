<html lang="en">
<head>
  <title>Registration</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <div id="top">
  	<h1 id = "home">Home Page</h1>
  </div>
</head>
<?php
        session_start();
	require_once("homemenu.php");

	// Connect to the database
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	// GET CURRENT TIME / FIGURE OUT WHAT THE CURRENT SEASON AND YEAR ARE!
	// Get the year
	$year = date("Y");
	$today = new DateTime();
	$spring = new DateTime('December 25');
	$summer = new DateTime('June 1');
	$fall = new DateTime('August 15');

	// Get the season
	// If its the fall semester
	if (($today >= $fall) && ($today < $spring)) {
	    $season - "Fall";
	}
	// If its the summer semester
	else if (($today >= $summer) && ($today < $fall)) {
	    $season = "Summer";
	}
	// If its the spring semester
	else {
	    $season = "Spring";
	}

	$year = mysqli_real_escape_string($dbc, trim($year));
	$season = mysqli_real_escape_string($dbc, trim($season));

	// Get u_id of current user
	$uid = mysqli_real_escape_string($dbc, trim($_SESSION['u_id']));

	// If the user is a student, print out all of the classes they are currently registered for/are in progress
	if ($_SESSION['whoareyou'] == "gradstudent") {
	    $query = "SELECT c.c_id, c.name, s.day, s.start_time, s.end_time, s.room, t.dept, t.section FROM student x, takes t, course c, schedule s WHERE x.u_id=t.u_id and t.semester='$season' and t.year='$year' and t.c_id=c.c_id and c.c_id=s.c_id and x.u_id='$uid' and t.section=s.section and t.dept=s.dept and c.dept=t.dept";
	    $data = mysqli_query($dbc, $query);

	    // Put a header for the table!
	    echo '<h4>Current Schedule - ' . $season . ' ' . $year . '</h4>';

	    if ($data != false) {

                //print out table
                echo "<table>";
                echo "<tr><td><b>Class Name</b></td><td class='too_short'><b>Day</b></td><td><b>Start Time</b></td><td><b>End Time</b></td><td><b>Room</b></td><td><b>Drop</b></td></tr>";
		while ($classes_result = mysqli_fetch_array($data)) {
		    
		    echo "<tr>";
                    echo "<td>".$classes_result['name']."</td>";
                    echo "<td class='too_short'>".$classes_result['day']."</td>";
                    echo "<td>".$classes_result['start_time']."</td>";
                    echo "<td>".$classes_result['end_time']."</td>";
                    echo "<td>".$classes_result['room']."</td>";
		    echo "<td>";
		    ?>
		    <! info needed to drop class>
		    <form action="dropclass.php" method="GET">
		    <input type="hidden" name="cid" value="<?php echo $classes_result['c_id'];?>" />
		    <input type="hidden" name="uid" value="<?php echo $_SESSION['u_id'];?>" />
		    <input type="hidden" name="semester" value="<?php echo $season;?>" />
		    <input type="hidden" name="year" value="<?php echo $year;?>" />
		    <input type="hidden" name="dept" value="<?php echo $classes_result['dept'];?>" />
		    <input type="hidden" name="section" value="<?php echo $classes_result['section'];?>" />

		    <input type="submit" name="dropclass" value="Drop" />
    		    </form>
		    <?php
		    echo "</td>";
		    echo "</tr>";
                }
                echo "</table>";
            }
            else {
                echo "ERROR: No classes have been found!";
            }
	}

	// If the user is a faculty or admin and they do not need the drop class buttons
	else {

	    // If the user is a faculty, print out all of the classes they are currently teaching/are in progress	
	    if ($_SESSION['whoareyou'] == "faculty") {
		$query = "SELECT c.name, s.day, s.start_time, s.end_time, s.room FROM faculty f, teaches t, course c, schedule s WHERE f.u_id=t.u_id and t.c_id=s.c_id and s.c_id=c.c_id and f.u_id='$uid' and t.semester='$season' and t.year='$year' and t.section=s.section and t.dept=s.dept and c.dept=t.dept";
	    
	        // Put a header for the table!
		echo '<h4>Current Schedule - ' . $season . ' ' . $year . '</h4>';
	    }	

	    // If the user is a GS or admin, print out all of the classes currently in progress
	    else {
                $query = "SELECT * FROM schedule s, course c WHERE s.c_id=c.c_id and s.semester='$season' and s.year='$year'";	
	    	
		// Put a header for the table!
		echo '<h4>Current Classes - ' . $season . ' ' . $year . '</h4>';
	    }

	    $data = mysqli_query($dbc, $query);
	    if ($data != false) {
                //print out table
                echo "<table>";
                echo "<tr><td><b>Class Name</b></td><td><b>Day</b></td><td><b>Start Time</b></td><td><b>End Time</b></td><td><b>Room</b></td></tr>";
                while ($classes_result = mysqli_fetch_array($data)) {
          	    echo "<tr>";
          	    echo "<td>".$classes_result['name']."</td>";
          	    echo "<td>".$classes_result['day']."</td>";
          	    echo "<td>".$classes_result['start_time']."</td>";
          	    echo "<td>".$classes_result['end_time']."</td>";
          	    echo "<td>".$classes_result['room']."</td>";
          	    echo "</tr>";
                }
                echo "</table>";
      	    } 
	    else {
                echo "ERROR: No classes have been found!";
	    }   
	}

?>

<body>

</body>
