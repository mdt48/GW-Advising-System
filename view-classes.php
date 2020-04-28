<?php

  //start the session
  require_once('connectvars.php');

  session_start();

  //open database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  echo '<link rel="stylesheet" type="text/css" href="style.css">';
  echo '<div id = "top"><h1>Schedule of classes</h1></div>';

?>

<head>
  <title>Class Schedule</title>
</head>

<body>
  <form method="post">
    <input type="text" name="input_season" placeholder="Season (Fall or Spring)" required>
    <input type="text" name="input_year" placeholder="Year" required>
    <input name="Submit" type="submit">
  </form>
  <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
      //form was submitted, process it ...
      $valid_input = true;
      $season = $_POST["input_season"];
      $year = $_POST["input_year"];
      //putting the "season" entry into the correct format
      $season = strtolower($season);
      $season = ucfirst($season);
      //query the database for the classes
      $classes_query = mysqli_query($dbc, "SELECT * FROM schedule a LEFT JOIN teaches c ON (a.c_id = c.c_id AND a.dept = c.dept AND a.year = c.year AND a.section = c.section AND a.semester = c.semester) JOIN course b ON (a.c_id = b.c_id AND a.dept = b.dept) LEFT JOIN person d ON (c.u_id = d.u_id) WHERE a.semester = '$season' AND a.year = '$year';");
      //display results
      if ($classes_query != false) {
        //print out table
        echo "<table>";
        echo "<tr><td><b>Class ID</b></td><td><b>Class Name</b></td><td><b>Day</b></td><td><b>Start Time</b></td><td><b>End Time</b></td><td><b>Room</b></td><td><b>Credit Hours</b></td><td><b>Instructor</b></td></tr>";
        while ($classes_result = mysqli_fetch_array($classes_query)) {
          echo "<tr>";
          echo "<td>".$classes_result['c_id']."</td>";
          echo "<td>".$classes_result['name']."</td>";
          echo "<td>".$classes_result['day']."</td>";
          echo "<td>".$classes_result['start_time']."</td>";
          echo "<td>".$classes_result['end_time']."</td>";
          echo "<td>".$classes_result['room']."</td>";
          echo "<td>".$classes_result['credits']."</td>";
          echo "<td>".$classes_result['fname']."";
          echo " ".$classes_result['lname']."</td>";
          echo "</tr>";
        }
        echo "</table>";
      } else {
        echo "ERROR: No classes have been found!";
      }
    }
  ?>
  <br/>
    <a href="homepage.php">Home</a>
  <br/>
</body>

<?php

  //close database

?>
