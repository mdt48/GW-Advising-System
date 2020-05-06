<?php

  //start the session
  require_once('connectvars.php');

  session_start();

  //open database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

?>

<head>
  <title>Enter grades</title>
</head>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel = "stylesheet" href="/css/heroic-features.css" >
  <link rel="stylesheet" type="text/css" href="style.css">    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

  
  <header class = "bg py-5 mb-5" style = "background-color: #033b59; height: 15em;">
    <div class = "container h-100">
        <div class = "row h-100 align-items-center">
            <div class = "col-lg-12">
                <h1 class = "display-4 text-center text-white mt-5 mb-2">Enter grades</h1></div>
        </div>
    </div>
  </header>


<?php
  
  if (isset($_SESSION['username']) && isset($_SESSION['type'])) {

    if ($_SESSION['type'] == 5 || $_SESSION['type'] == 7 || $_SESSION['type'] == 8 || $_SESSION['type'] == 9) {
      //user is faculty - only sees students in their class

      $theusername = $_SESSION['username'];

      $userquery = "SELECT uid FROM people WHERE username='$theusername'";


      $userquery = "SELECT u_id FROM person WHERE username='$theusername'";
      $userdata = mysqli_query($dbc, $userquery);
      $userrow = mysqli_fetch_array($userdata);
      $user = $userrow["uid"];

      //for teacher only show students currently enrolled in their class who don't have a grade already
      $query = "SELECT a.uid, b.fname, b.lname FROM student a JOIN people b ON (a.uid = b.uid) JOIN takes c ON (b.uid = c.uid) JOIN teaches d ON (c.cid = d.cid AND c.department = d.department AND c.year = d.year AND c.section = d.section AND c.semester = d.semester) WHERE d.uid = '$user' AND c.grade = 'IP'";

    } else if ($_SESSION['type'] <= 1) {
      //for GS and admin show all students
      $query = "SELECT a.uid, b.fname, b.lname FROM student a JOIN people b ON (a.uid = b.uid) JOIN takes c ON (b.uid = c.uid)";

      $user = " ";
    }

    $data = mysqli_query($dbc, $query);

    echo '<h4>Students:</h4>';
    echo '<table>';
    $student_id = "";
    while ($row = mysqli_fetch_array($data)) { //show the students with a button to add a grade for them
      if ($row["uid"] != $student_id) {
        ?>
        <form action="addgrade.php" method="GET">
          <input type="hidden" name ="u_id" value="<?php echo $row["uid"]; ?>" />
          <input type="hidden" name ="teach_id" value="<?php echo $user; ?>" />
          <input type="submit" name="addgrade" value="Add grade" />
	      </form><?php
        echo $row["fname"]." ". $row["lname"];?><br><?php
        $student_id = $row["uid"];
      }
    }

    echo '</table>';


  }

  //link to homepage
  echo '<br/><br/><a href="index.php">Home</a>';


?>
