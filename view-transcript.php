<?php

  //start the session
  require_once('connectvars.php');

  session_start();

  //open database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


  echo '<link rel="stylesheet" type="text/css" href="style.css">';
  echo '<div id = "top"><h1>Your transcript</h1></div>';

?>

<head>
  <title>Transcript</title>
</head>

<body>
  <?php
    if (isset($_SESSION['u_id'])) {
      //query database for classes for this user
      $u_id = $_SESSION['u_id'];
      $takes_query = mysqli_query($dbc, "SELECT * FROM takes a JOIN course b ON a.c_id = b.c_id WHERE u_id = '$u_id';");
      //print out classes
      if ($takes_query != false) {
        //print out table
        echo "<table>";
        echo "<tr><td><b>Class name</b></td><td><b>Department</b></td><td><b>Grade</b></td></tr>";        
        while ($takes_result = mysqli_fetch_array($takes_query)) {
          echo "<tr>";
          echo "<td>".$takes_result['name']."</td>";
          echo "<td class = 'too_short'>".$takes_result['dept']."</td>";
          echo "<td>".$takes_result['grade']."</td>";
          echo "</tr>";
        }
        echo "</table>";
      } else {
        echo "ERROR: No classes have been found!";
      }
    } else {
      echo "ERROR: You are not logged in!";
    }
  ?>
  <br/>
  <a href="homepage.php">Home</a>
</body>

<?php

  //close database

?>