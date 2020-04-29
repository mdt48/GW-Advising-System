<?php

require_once('connectvars.php');

session_start();

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
                <h1 class = "display-4 text-center text-white mt-5 mb-2">Regstration</h1></div>
        </div>
    </div>
  </header>

<?php
if (isset($_SESSION['username'])) { //only display things if they are logged in
  $theusername = $_SESSION['username'];
  $userquery = "SELECT uid FROM people WHERE username='$theusername'";
  $userdata = mysqli_query($dbc, $userquery);
  $userrow = mysqli_fetch_array($userdata);
  $user = $userrow["uid"]; //get the user's u_id

  $yearquery = "SELECT MAX(year) FROM schedule";
  $yeardata = mysqli_query($dbc, $yearquery);
  $yearrow = mysqli_fetch_array($yeardata);
  $year = $yearrow["MAX(year)"]; //only show classes available in the current year

  //take all the classes for this year
  $query = "SELECT cid, department, semester, year, section FROM schedule WHERE year = '$year'";
  $data = mysqli_query($dbc, $query);


  echo '<h4>Classes:</h4>';
  echo '<table>';
  while ($row = mysqli_fetch_array($data)) { //show all the classes available to them with a button to register
?>
    <form action="classregister.php" method="GET">
      <input type="hidden" name="cid" value="<?php echo $row["cid"]; ?>" />
      <input type="hidden" name="dept" value="<?php echo $row["department"]; ?>" />
      <input type="hidden" name="semester" value="<?php echo $row["semester"]; ?>" />
      <input type="hidden" name="year" value="<?php echo $row["year"]; ?>" />
      <input type="hidden" name="section" value="<?php echo $row["section"]; ?>" />
      <input type="hidden" name="uid" value="<?php echo $user; ?>" />
      <input type="submit" name="registerclass" value="Register" />
    </form>
    
    <?php
    echo $row["department"]." ".$row["cid"]." ".$row["semester"]." ".$row["year"]; ?><br><br><?php
  }

  echo '</table>';

  }

  echo '<a href="index.php">Home</a>';

?>