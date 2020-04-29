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
                <h1 class = "display-4 text-center text-white mt-5 mb-2">Schedule of Classes</h1></div>
        </div>
    </div>
  </header>

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
      $classes_query = mysqli_query($dbc, "SELECT * FROM schedule a LEFT JOIN teaches c ON (a.cid = c.cid AND a.department = c.department AND a.year = c.year AND a.section = c.section AND a.semester = c.semester) JOIN course b ON (a.cid = b.cid AND a.department = b.department) LEFT JOIN people d ON (c.uid = d.uid) WHERE a.semester = '$season' AND a.year = '$year';
");
      //display results
      if ($classes_query != false) {
        //print out table
        echo "<table>";
        echo "<tr><td><b>Class ID</b></td><td><b>Class Name</b></td><td><b>Day</b></td><td><b>Start Time</b></td><td><b>End Time</b></td><td><b>Room</b></td><td><b>Credit Hours</b></td><td><b>Instructor</b></td></tr>";
        while ($classes_result = mysqli_fetch_array($classes_query)) {
          echo "<tr>";
          echo "<td>".$classes_result['cid']."</td>";
          echo "<td>".$classes_result['subject']."</td>";
          echo "<td>".$classes_result['day']."</td>";
          echo "<td>".$classes_result['start_time']."</td>";
          echo "<td>".$classes_result['end_time']."</td>";
          echo "<td>".$classes_result['room']."</td>";
          echo "<td>".$classes_result['credit']."</td>";
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
    <a href="index.php">Home</a>
  <br/>
</body>

<?php

  //close database

?>
