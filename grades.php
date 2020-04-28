<?php

  //start the session
  require_once('connectvars.php');

  session_start();

  //open database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  echo '<link rel="stylesheet" type="text/css" href="style.css">';
  echo '<div id = "top"><h1>Enter grades</h1></div>';

?>

<head>
  <title>Enter grades</title>
</head>


<?php
  
  if (isset($_SESSION['username']) && isset($_SESSION['whoareyou'])) {

    if ($_SESSION['whoareyou'] == "faculty") {
      //user is faculty - only sees students in their class

      $theusername = $_SESSION['username'];

      $userquery = "SELECT u_id FROM person WHERE username='$theusername'";
      $userdata = mysqli_query($dbc, $userquery);
      $userrow = mysqli_fetch_array($userdata);
      $user = $userrow["u_id"];

      //for teacher only show students currently enrolled in their class who don't have a grade already
      $query = "SELECT a.u_id, b.fname, b.lname FROM student a JOIN person b ON (a.u_id = b.u_id) JOIN takes c ON (b.u_id = c.u_id) JOIN teaches d ON (c.c_id = d.c_id AND c.dept = d.dept AND c.year = d.year AND c.section = d.section AND c.semester = d.semester) WHERE d.u_id = '$user' AND c.grade = 'IP'";

    } else {
      //for GS and admin show all students
      $query = "SELECT a.u_id, b.fname, b.lname FROM student a JOIN person b ON (a.u_id = b.u_id) JOIN takes c ON (b.u_id = c.u_id)";

      $user = " ";
    }

    $data = mysqli_query($dbc, $query);

    echo '<h4>Students:</h4>';
    echo '<table>';
    $student_id = "";
    while ($row = mysqli_fetch_array($data)) { //show the students with a button to add a grade for them
      if ($row["u_id"] != $student_id) {
        ?>
        <form action="addgrade.php" method="GET">
          <input type="hidden" name ="u_id" value="<?php echo $row["u_id"]; ?>" />
          <input type="hidden" name ="teach_id" value="<?php echo $user; ?>" />
          <input type="submit" name="addgrade" value="Add grade" />
	      </form><?php
        echo $row["fname"]." ". $row["lname"];?><br><?php
        $student_id = $row["u_id"];
      }
    }

    echo '</table>';


  }

  //link to homepage
  echo '<br/><br/><a href="homepage.php">Home</a>';


?>
