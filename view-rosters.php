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
                <h1 class = "display-4 text-center text-white mt-5 mb-2">Class Rosters</h1></div>
        </div>
    </div>
  </header>

<head>
  <title>Rosters</title>
</head>

<?php
  if (isset($_SESSION['uid']) && isset($_SESSION['type'])) {
    if ($_SESSION['type'] == 5 || $_SESSION['type'] == 7 || $_SESSION['type'] == 8 || $_SESSION['type'] == 9) {
      //user is faculty
      $uid = $_SESSION['uid'];
      $coursesquery = "SELECT cid, department FROM teaches WHERE uid = $uid;";
      $coursesdata = mysqli_query($dbc, $coursesquery);
      
      if ($coursesdata != false) {
        if (mysqli_num_rows($coursesdata) != 0) {
          while ($coursesresult = mysqli_fetch_array($coursesdata)) {
            $currcourse = $coursesresult['cid'];
            $currdept = $coursesresult['department'];
            $rosterquery = "SELECT fname, lname, username FROM takes a JOIN teaches b on a.cid = b.cid join people c on a.uid = c.uid where b.uid = $uid and b.cid = $currcourse;";
            echo("<h2>$currdept $currcourse<br/></h2>");
            $rosterdata = mysqli_query($dbc, $rosterquery);
            
            if ($rosterdata != false) {
              if (mysqli_num_rows($rosterdata) != 0) {
                echo('</script> <!-- F1 --> <table class="table" id="tab"><thead><tr><th scope="col">First name</th> <th scope="col">Last name</th><th scope="col">Username</tr></thead><tbody>');  
                while ($rosterresult = mysqli_fetch_array($rosterdata)) {
                  echo "<tr>";
                  echo "<td>".$rosterresult['fname']."</td>";
                  echo "<td>".$rosterresult['lname']."</td>";
                  echo "<td>".$rosterresult['username']."</td>";
                  echo "</tr>";
                }
                echo("</table>");
              } else {
                echo "<br/><p>  No students are currently enrolled in this course.</p><br/><br/>";
              }
            }
          }
        } else {
          echo "<p style = 'text-align: center;'>It doesn't look like you're teaching any courses currently...</p>";
        }
      }
    }
  }
  echo '<br/><br/><a href="index.php"><p style="text-align:center">Home</p></a>';
?>