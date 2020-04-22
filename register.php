<?php

require_once('connectvars.php');

session_start();

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
echo '<link rel="stylesheet" type="text/css" href="style.css">';
echo '<div id = "top"><h1>Registration</h1></div>';
?>

<head>
  <title>Register</title>
</head>

<?php

if (isset($_SESSION['username'])) { //only display things if they are logged in

  $theusername = $_SESSION['username'];
  $userquery = "SELECT u_id FROM person WHERE username='$theusername'";
  $userdata = mysqli_query($dbc, $userquery);
  $userrow = mysqli_fetch_array($userdata);
  $user = $userrow["u_id"]; //get the user's u_id

  $yearquery = "SELECT MAX(year) FROM schedule";
  $yeardata = mysqli_query($dbc, $yearquery);
  $yearrow = mysqli_fetch_array($yeardata);
  $year = $yearrow["MAX(year)"]; //only show classes available in the current year

  //take all the classes for this year
  $query = "SELECT c_id, dept, semester, year, section FROM schedule WHERE year = '$year'";
  $data = mysqli_query($dbc, $query);


  echo '<h4>Classes:</h4>';
  echo '<table>';
  while ($row = mysqli_fetch_array($data)) { //show all the classes available to them with a button to register
?>
    <form action="classregister.php" method="GET">
      <input type="hidden" name="c_id" value="<?php echo $row["c_id"]; ?>" />
      <input type="hidden" name="dept" value="<?php echo $row["dept"]; ?>" />
      <input type="hidden" name="semester" value="<?php echo $row["semester"]; ?>" />
      <input type="hidden" name="year" value="<?php echo $row["year"]; ?>" />
      <input type="hidden" name="section" value="<?php echo $row["section"]; ?>" />
      <input type="hidden" name="u_id" value="<?php echo $user; ?>" />
      <input type="submit" name="registerclass" value="Register" />
    </form><?php
    echo $row["dept"]." ".$row["c_id"]." ".$row["semester"]." ".$row["year"]; ?><br><br><?php
  }

  echo '</table>';

  }

  echo '<a href="homepage.php">Home</a>';

?>