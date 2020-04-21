<?php

  //start the session
  require_once('connectvars.php');

  session_start();

  echo '<link rel="stylesheet" type="text/css" href="style.css">';
  echo '<div id = "top"><h1>Registration</h1></div>';

  //open database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


  if(isset($_GET["c_id"])) {
    $c_id = $_GET["c_id"];
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

  if(isset($_GET["u_id"])) {
    $u_id = $_GET["u_id"];
  }

  $takenbefore = "SELECT * FROM takes WHERE u_id = '$u_id' AND dept = '$dept' AND semester = '$semester' AND year = '$year' AND section = '$section' AND c_id = '$c_id'";
  $takenquery = mysqli_query($dbc, $takenbefore);

  //use to determine if they are able to take
  $cantake = true;

  if ($row = mysqli_fetch_array($takenquery)) { //this class already exists in their takes table
    echo "ERROR: You have already taken this class before";?><br><?php
  } else {

    //main prereq
    $prereq = "SELECT * FROM prereqs WHERE c_id = '$c_id' AND dept = '$dept' AND ismain = true";
    $prereqquery = mysqli_query($dbc, $prereq);
    $prereqrow = mysqli_fetch_array($prereqquery);

    if ($prereqrow) { //if there is main prereq

      //see if they have taken it
      $req_dept = $prereqrow["req_dept"];
      $req_cid = $prereqrow["req_cid"];
      $checkprereq = "SELECT * FROM takes WHERE u_id = '$u_id' AND dept = '$req_dept' AND c_id = '$req_cid'";
      $checkprereqquery = mysqli_query($dbc, $checkprereq);

      if (!($row = mysqli_fetch_array($checkprereqquery))) {
        //they have not taken the main prereq
        echo "You have not taken a prerequisite for this class: ".$req_dept." ".$req_cid;?><br><?php
        $cantake = false; //mark that they cannot take class
      } else { //they have taken the main prereq check secondary

        //secondary prereq
        $prereq = "SELECT * FROM prereqs WHERE c_id = '$c_id' AND dept = '$dept' AND ismain = false";
        $prereqquery = mysqli_query($dbc, $prereq);
        $prereqrow = mysqli_fetch_array($prereqquery);

        if ($prereqrow) { //if there is a secondary prereq
          $req_dept = $prereqrow["req_dept"];
          $req_cid = $prereqrow["req_cid"];
          $checkprereq = "SELECT * FROM takes WHERE u_id = '$u_id' AND dept = '$req_dept' AND c_id = '$req_cid'";
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
    $timeinfo = "SELECT * FROM schedule WHERE dept = '$dept' AND semester = '$semester' AND year = '$year' AND section = '$section' AND c_id = '$c_id'";
    $timequery = mysqli_query($dbc, $timeinfo);
    $timerow = mysqli_fetch_array($timequery);
    $day = $timerow["day"];
    $starttime = $timerow["start_time"];
    $endtime = $timerow["end_time"];

    if ($cantake) {
      //they have taken the prereqs
      $conflict = "SELECT * FROM takes c JOIN schedule d ON (c.c_id = d.c_id AND c.dept = d.dept AND c.year = d.year AND c.section = d.section AND c.semester = d.semester) WHERE c.u_id = '$u_id' AND d.semester = '$semester' AND d.year = '$year' AND d.day = '$day'";
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
      $registerquery = "INSERT INTO takes VALUES ('$c_id', '$dept', '$year', '$section', '$semester', '$u_id', 'IP')";
      $registerdata = mysqli_query($dbc, $registerquery);
      echo "You have sucessfully registered for ".$dept." ".$c_id;?><br><?php
    }
 
  }

  echo '<br/><br/><a href="register.php">Back</a>';


?>

