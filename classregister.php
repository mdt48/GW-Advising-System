<?php

  //start the session
  require_once('connectvars.php');

  session_start();
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel = "stylesheet" href="/css/heroic-features.css" >
  <link rel="stylesheet" type="text/css" href="style.css">    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

  
  <header class = "bg py-5 mb-5" style = "background-color: #033b59; height: 15em;">
    <div class = "container h-100">
        <div class = "row h-100 align-items-center">
            <div class = "col-lg-12">
                <h1 class = "display-4 text-center text-white mt-5 mb-2">Registration</h1></div>
        </div>
    </div>
  </header>
  <body style = "text-align: center;">

<?php
  //open database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


  if(isset($_GET["cid"])) {
    $c_id = $_GET["cid"];
  }

  if(isset($_GET["dept"])) {
    $dept = $_GET["dept"];
  }

  if(isset($_GET["semester"])) {
    $semester = $_GET["semester"];
  }

  if(isset($_GET["year"])) {
    $year = $_GET["year"];
  }

  if(isset($_GET["section"])) {
    $section = $_GET["section"];
  }

  if(isset($_GET["uid"])) {
    $uid = $_GET["uid"];
  }

  $takenbefore = "SELECT * FROM transcript WHERE uid = '$uid' AND subject = '$dept' AND cid = '$c_id'";
  $takenquery = mysqli_query($dbc, $takenbefore);

  $taking = "SELECT * FROM takes WHERE uid = '$uid' AND department = '$dept' AND semester = '$semester' AND year = '$year' AND section = '$section' AND cid = '$c_id'";
  $takingquery = mysqli_query($dbc, $taking);

  //use to determine if they are able to take
  $cantake = true;

  if ($row = mysqli_fetch_array($takenquery)) { //this class already exists in their takes table
    echo "ERROR: This class is already listed in your transcript";?><br><?php
  } else if ($row = mysqli_fetch_array($takingquery)) {
    echo "ERROR: You are already registered for this class";?><br><?php
  } else {

    //main prereq
    $prereq = "SELECT * FROM prereqs WHERE c_id = '$c_id' AND department = '$dept'";
    $prereqquery = mysqli_query($dbc, $prereq);
    if ($prereqquery != false) {
      $prereqrow = mysqli_fetch_array($prereqquery);
    } else {
      $prereqrow = false;
    }

    if ($prereqrow) { //if there is main prereq

      //see if they have taken it
      $req_dept = $prereqrow["department"];
      $req_cid = $prereqrow["cid"];
      $checkprereq = "SELECT * FROM transcript WHERE uid = '$uid' AND subject = '$req_dept' AND cid = '$req_cid'";
      $checkprereqquery = mysqli_query($dbc, $checkprereq);

      if (!($row = mysqli_fetch_array($checkprereqquery))) {
        //they have not taken the main prereq
        echo "You have not taken a prerequisite for this class: ".$req_dept." ".$req_cid;?><br><?php
        $cantake = false; //mark that they cannot take class
      } else { //they have taken the main prereq check secondary

        //secondary prereq
        $prereq = "SELECT * FROM prereqs WHERE cid = '$cid' AND department = '$department'";
        $prereqquery = mysqli_query($dbc, $prereq);
        $prereqrow = mysqli_fetch_array($prereqquery);

        if ($prereqrow) { //if there is a secondary prereq
          $req_dept = $prereqrow["department"];
          $req_cid = $prereqrow["cid"];
          $checkprereq = "SELECT * FROM transcript WHERE uid = '$uid' AND subject = '$req_dept' AND cid = '$req_cid'";
          $checkprereqquery = mysqli_query($dbc, $checkprereq);
          if (!($row = mysqli_fetch_array($checkprereqquery))) { //see if they have taken the prereq
            echo "You have not taken a prerequisite for this class: ".$req_dept." ".$req_cid;?><br><?php
            $cantake = false; //mark that they cannot take class
          }
        }
      }

    }

    //check for time conflict

    //info about class they want to register for
    $timeinfo = "SELECT * FROM schedule WHERE department = '$dept' AND semester = '$semester' AND year = '$year' AND section = '$section' AND cid = '$c_id'";
    $timequery = mysqli_query($dbc, $timeinfo);
    $timerow = mysqli_fetch_array($timequery);
    $day = $timerow["day"];
    $starttime = $timerow["start_time"];
    $endtime = $timerow["end_time"];

    if ($cantake) {
      //they have taken the prereqs
      $conflict = "SELECT * FROM takes c JOIN schedule d ON (c.cid = d.cid AND c.department = d.department AND c.year = d.year AND c.section = d.section AND c.semester = d.semester) WHERE c.uid = '$uid' AND d.semester = '$semester' AND d.year = '$year' AND d.day = '$day'";
      $conflictquery = mysqli_query($dbc, $conflict);

      while ($conflictrow = mysqli_fetch_array($conflictquery)) {
        if ($cantake) {
          $oldstarttime = $conflictrow["start_time"];
          $oldendtime = $conflictrow["end_time"];
          if (($oldstarttime <= $starttime) && ($oldendtime >= $starttime)) {
            //starts during another class
            echo "ERROR: You have a time conflict with ".$conflictrow["dept"]." ".$conflictrow["c_id"];
            $cantake = false;
          } else if (($oldendtime >= $endtime) && ($oldstarttime <= $endtime)) {
            //ends during another class
            echo "ERROR: You have a time conflict with " . $conflictrow["dept"] . " " . $conflictrow["c_id"];
            $cantake = false;
          }
        }
      }
    }
    
    if ($cantake) { //check if they can take class or not

      //they can take - add to database
      $registerquery = "INSERT INTO takes VALUES ('$c_id', '$dept', '$year', '$section', '$semester', '$uid', 'IP')";
      $registerdata = mysqli_query($dbc, $registerquery);
      echo "You have sucessfully registered for ".$dept." ".$c_id;?><br><?php
    }
 
  }

  echo '<br/><br/><a href="register.php">Back</a>';


?>
</body>

