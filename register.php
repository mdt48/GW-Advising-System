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
  <body style = "text-align: center;">

<?php
if (isset($_SESSION['username'])) { //only display things if they are logged in
  $theusername = $_SESSION['username'];
  $userquery = "SELECT uid FROM people WHERE username='$theusername'";
  $userdata = mysqli_query($dbc, $userquery);
  $userrow = mysqli_fetch_array($userdata);
  $user = $userrow["uid"]; //get the user's u_id
  //check if they have any courses in their transcript
  $classquery = "SELECT * FROM transcript WHERE uid = '$user';";
  $classdata = mysqli_query($dbc, $classquery);
  $classrow = mysqli_num_rows($classdata);
  $doestake = "SELECT * FROM takes WHERE uid = '$user';";
  $dtdata = mysqli_query($dbc, $doestake);
  $dtrow = mysqli_num_rows($dtdata);
  if ($classrow != 0 || $dtrow != 0) {
    $yearquery = "SELECT MAX(year) FROM schedule";
    $yeardata = mysqli_query($dbc, $yearquery);
    $yearrow = mysqli_fetch_array($yeardata);
    $year = $yearrow["MAX(year)"]; //only show classes available in the current year

    //take all the classes for this year
    $query = "SELECT cid, department, semester, year, section FROM schedule WHERE year = '$year'";
    $data = mysqli_query($dbc, $query);


    echo '<h4 style="text-align: center;">Classes:</h4>';
    echo '<table>';
    while ($row = mysqli_fetch_array($data)) { //show all the classes available to them with a button to register
  ?>
      <?php
      echo $row["department"]." ".$row["cid"]." ".$row["semester"]." ".$row["year"]."\n"; ?>
      <br>
      <form action="classregister.php" method="GET" style = "display: inline-block;">
        <input type="hidden" name="cid" value="<?php echo $row["cid"]; ?>" />
        <input type="hidden" name="dept" value="<?php echo $row["department"]; ?>" />
        <input type="hidden" name="semester" value="<?php echo $row["semester"]; ?>" />
        <input type="hidden" name="year" value="<?php echo $row["year"]; ?>" />
        <input type="hidden" name="section" value="<?php echo $row["section"]; ?>" />
        <input type="hidden" name="uid" value="<?php echo $user; ?>" />
        <input type="submit" name="registerclass" value="Register" />
      </form>
      
      <br><br><?php
    }

    echo '</table>';

    } else {
      $formAlreadySubmittedQuery = "SELECT * FROM courseForm WHERE uid = $user;";
      $formData = mysqli_query($dbc, $formAlreadySubmittedQuery);
      if (mysqli_num_rows($formData) == 0) {
        echo("As a newly-matriculated student, you must have your courses be approved by your advisor. Please fill out the courses you wish to take in your first semester below");
        ?>
        <form action = "submitCourseForm.php" method = "POST" style = "display: inline-block;">
          <input type = "text" name = "cid1" placeholder = "Course ID"/>
          <input type = "text" name = "dept1" placeholder = "Department"/>
          </br>
          <input type = "text" name = "cid2" placeholder = "Course ID"/>
          <input type = "text" name = "dept2" placeholder = "Department"/>
          </br>
          <input type = "text" name = "cid3" placeholder = "Course ID"/>
          <input type = "text" name = "dept3" placeholder = "Department"/>
          </br>
          <input type = "text" name = "cid4" placeholder = "Course ID"/>
          <input type = "text" name = "dept4" placeholder = "Department"/>
          </br>
          <input type = "text" name = "cid5" placeholder = "Course ID"/>
          <input type = "text" name = "dept5" placeholder = "Department"/>
          </br>
          <input type = "text" name = "cid5" placeholder = "Course ID"/>
          <input type = "text" name = "dept5" placeholder = "Department"/>
          </br>
          </br>
          <input type = "submit" name = "submit" value = "Submit"/>
        </form>
        <?php
        //saving course form into database
          if (isset($_POST["submit"])) {
            if (isset($_POST["cid1"]) && isset($_POST["dept1"])) {
              $cid1 = $_POST["cid1"]; $dept1 = $_POST["dept1"];
            } else {
              $cid1 = NULL; $dept1 = NULL;
            }
            if (isset($_POST["cid2"]) && isset($_POST["dept2"])) {
              $cid2 = $_POST["cid2"]; $dept2 = $_POST["dept2"];
            } else {
              $cid2 = NULL; $dept2 = NULL;
            }
            if (isset($_POST["cid3"]) && isset($_POST["dept3"])) {
              $cid3 = $_POST["cid3"]; $dept3 = $_POST["dept3"];
            } else {
              $cid3 = NULL; $dept3 = NULL;
            }
            if (isset($_POST["cid4"]) && isset($_POST["dept4"])) {
              $cid4 = $_POST["cid4"]; $dept4 = $_POST["dept4"];
            } else {
              $cid4 = NULL; $dept4 = NULL;
            }
            if (isset($_POST["cid5"]) && isset($_POST["dept5"])) {
              $cid5 = $_POST["cid5"]; $dept5 = $_POST["dept5"];
            } else {
              $cid5 = NULL; $dept5 = NULL;
            }
            if (isset($_POST["cid6"]) && isset($_POST["dept6"])) {
              $cid6 = $_POST["cid6"]; $dept6 = $_POST["dept6"];
            } else {
              $cid6 = NULL; $dept6 = NULL;
            }
            //insert into database
            //echo(isset($_POST["submit"]));
            $insertquery = "INSERT INTO courseForm VALUES ($user, $cid1, $dept1, $cid2, $dept2, $cid3, $dept3, $cid4, $dept4, $cid5, $dept5, $cid6, $dept6);";
            $data = mysqli_query($dbc, $insertquery);
            echo($data);
          }
        } else {
          echo ("Your course form has been submitted and is pending review.");
        }
    }
  }

    echo '<br/><br/><a href="index.php">Home</a>';

?>
</br>
</br>
</body>