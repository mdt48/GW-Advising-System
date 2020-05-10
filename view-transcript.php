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
      $takes_query = mysqli_query($dbc, "SELECT * FROM transcript WHERE uid='$u_id';");
        echo('</script> <!-- F1 --> <table class="table" id="tab"><thead><tr><th scope="col">Course #</th> <th scope="col">Course ID</th><th scope="col">Grade</tr></thead><tbody>');
      //print out classes
      if ($takes_query != false) {
        //print out table
          $count = 1;
        $gpa_sum = 0.0;
        $credit_sum = 0.0;
        while($row = mysqli_fetch_array($takes_query)){
          $cid = $row['cid'];
          $dept = $row['subject'];
          $grade = $row['grade'];

          $query = "SELECT credit FROM course WHERE department='$dept' AND cid='$cid';";
          $credit_res = mysqli_query($dbc, $query);
          $credit_row = mysqli_fetch_array($credit_res);
          $credit = $credit_row['credit'];

          if(strcmp($grade,"IP")==0){ //do not count incomplete classes
            continue;
          }

          $credit_sum += $credit;

          if(strcmp($grade,"A")==0){
              $gpa_sum += ($credit * 4);
      
          }else if(strcmp($grade,"A-")==0){
              $gpa_sum += ($credit * 3.7);
          }else if(strcmp($grade,"B+")==0){
              $gpa_sum += ($credit * 3.3);
          }else if(strcmp($grade,"B")==0){
              $gpa_sum += ($credit * 3);
          }else if(strcmp($grade,"B-")==0){
              $gpa_sum += ($credit * 2.7);
          }else if(strcmp($grade,"C+")==0){
              $gpa_sum += ($credit * 2.3);
          }else if(strcmp($grade,"C")==0){
              $gpa_sum += ($credit * 2);
          }else if(strcmp($grade,"F")==0){
              //add zero
          }else{
            //invalid grade
          }

          echo "  
            <tr>
              <th scope=row>$count</th>
              <td>$dept $cid</td>
              <td>$grade</td>
            </tr>
          ";
          $count++;
        }
        if($credit_sum!=0){
          $gpa = round(($gpa_sum)/($credit_sum),2);
        }else{
          $gpa =0;
        }
          echo("</tbody>
            </table>");
          echo('<h1><span class="badge badge-primary">Total GPA: '.$gpa.'</span></h1>');
      } else {
        echo "ERROR: No classes have been found!";
      }

      echo "\n</br><p style = 'text-align:center;'><b>Classes currently in progress:</b></p>";

      $takes_query = mysqli_query($dbc, "SELECT * FROM takes a JOIN course b ON a.cid = b.cid WHERE a.uid = '$u_id';");
      //print out classes
      if ($takes_query != false) {
        if (mysqli_num_rows($takes_query) != 0) {
          //print out table
          echo('</script> <!-- F1 --> <table class="table" id="tab"><thead><tr><th scope="col">Class name</th> <th scope="col">Department</th><th scope="col">Grade</th><th scope="col"></th></tr></thead><tbody>');     
          while ($takes_result = mysqli_fetch_array($takes_query)) {
            echo "<tr>";
            echo "<td>".$takes_result['subject']."</td>";
            echo "<td>".$takes_result['department']."</td>";
            echo "<td>".$takes_result['grade']."</td>";
            $thisCid = $takes_result['cid'];
            echo('<td><form method = "POST"><input type = "submit" name = "$thisCid" value = "Drop Class"/></form></td>');
            if (isset($_POST['$thisCid'])) {
              $deleteQuery = "DELETE FROM takes WHERE uid = $u_id AND cid = $thisCid;";
              mysqli_query($dbc, $deleteQuery);
              header('Location: '.$_SERVER['REQUEST_URI']);
            }
            echo "</tr>";
          }
          echo "</table>";
        } else {
          echo"<p style = 'text-align:center;'>You are currently not registered for any classes.</p>";
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