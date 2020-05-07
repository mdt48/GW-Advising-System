<?php

  //start the session
  require_once('connectvars.php');

  session_start();

  //open database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


?>

<head>
  <title>Transcript</title>
</head>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel = "stylesheet" href="/css/heroic-features.css" >
  <link rel="stylesheet" type="text/css" href="style.css">    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

  
  <header class = "bg py-5 mb-5" style = "background-color: #033b59; height: 15em;">
    <div class = "container h-100">
        <div class = "row h-100 align-items-center">
            <div class = "col-lg-12">
                <h1 class = "display-4 text-center text-white mt-5 mb-2">Your Transcript</h1></div>
        </div>
    </div>
  </header>

<body>
  <?php
    if (isset($_SESSION['uid'])) {
      //query database for classes for this user
      $u_id = $_SESSION['uid'];
      echo "\n<p style = 'text-align:center;'><b>Previously-taken classes:</b></p>";
      $takes_query = mysqli_query($dbc, "SELECT * FROM transcript a JOIN course b ON a.cid = b.cid WHERE a.uid = '$u_id';");
      //print out classes
      if ($takes_query != false) {
        //print out table
        echo "<table style = 'margin-left:auto;margin-right:auto;'>";
        echo "<tr><td><b>Class name</b></td><td><b>Department</b></td><td><b>Grade</b></td></tr>";        
        while ($takes_result = mysqli_fetch_array($takes_query)) {
          echo "<tr>";
          echo "<td>".$takes_result['subject']."</td>";
          echo "<td>".$takes_result['department']."</td>";
          echo "<td>".$takes_result['grade']."</td>";
          echo "</tr>";
        }
        echo "</table>";
      } else {
        echo "ERROR: No classes have been found!";
      }

      echo "\n</br><p style = 'text-align:center;'><b>Classes currently in progress:</b></p>";

      $takes_query = mysqli_query($dbc, "SELECT * FROM takes a JOIN course b ON a.cid = b.cid WHERE a.uid = '$u_id';");
      //print out classes
      if ($takes_query != false) {
        if (mysqli_num_rows($takes_query) != 0) {
          //print out table
          echo "<table style = 'margin-left:auto;margin-right:auto;'>";
          echo "<tr><td><b>Class name</b></td><td><b>Department</b></td><td><b>Grade</b></td></tr>";        
          while ($takes_result = mysqli_fetch_array($takes_query)) {
            echo "<tr>";
            echo "<td>".$takes_result['subject']."</td>";
            echo "<td>".$takes_result['department']."</td>";
            echo "<td>".$takes_result['grade']."</td>";
            echo "</tr>";
          }
          echo "</table>";
        } else {
          echo"<p style = 'text-align:center;'>This student is currently not registered for any classes.</p>";
        }
      } else {
        echo "ERROR: No classes have been found!";
      }
    } else {
      echo "ERROR: You are not logged in!";
    }
  ?>
  <br/>
  <a href="index.php"><p style = 'text-align:center;'>Home</p></a>
</body>

<?php

  //close database

?>